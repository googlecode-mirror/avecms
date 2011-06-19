<?php
/**
 * Класс, включающий все свойства и методы для управления комментариями как в
 * Публичной части сайта, так и в Панели управления.
 *
 * @package AVE.cms
 * @subpackage module_Comment
 * @since 1.4
 * @filesource
 */
class Comment
{

/**
 * Свойства класса
 */

	/**
	 * Идентификатор записи с настройками модуля Комментарии
	 *
	 * @var int
	 */
	var $_config_id = 1;

	/**
	 * Количество комментариев на странице в административной части
	 *
	 * @var int
	 */
	var $_limit = 15;

	/**
	 * Имя файла с шаблоном для вывода блока комментариев
	 *
	 * @var string
	 */
	var $_comments_tree_tpl = 'comments_tree.tpl';

	/**
	 * Имя файла с шаблоном для рекурсивного вывода иерархии комментариев
	 *
	 * @var string
	 */
	var $_comments_tree_sub_tpl = 'comments_tree_sub.tpl';

	/**
	 * Имя файла с шаблоном формы добавления комментария
	 *
	 * @var string
	 */
	var $_comment_form_tpl = 'comment_form.tpl';

	/**
	 * Имя файла с шаблоном нового комментария
	 *
	 * @var string
	 */
	var $_comment_new_tpl = 'comment_new.tpl';

	/**
	 * Имя файлаа с шаблоном уведомляющим о успешном выполнении операции
	 *
	 * @var string
	 */
	var $_comment_thankyou_tpl = 'comment_thankyou.tpl';

	/**
	 * Имя файла с шаблоном редактирования шаблона в административной части
	 *
	 * @var string
	 */
	var $_admin_edit_link_tpl = 'admin_edit.tpl';

	/**
	 * Имя файла с шаблоном списка комментариев в административной части
	 *
	 * @var string
	 */
	var $_admin_comments_tpl = 'admin_comments.tpl';

	/**
	 * Имя файла с шаблоном редактирования настроек модуля в административной части
	 *
	 * @var string
	 */
	var $_admin_settings_tpl = 'admin_settings.tpl';

	/**
	 * Имя файла с шаблоном редактирования шаблона в публичной части
	 *
	 * @var string
	 */
	var $_edit_link_tpl = 'comment_edit.tpl';

	/**
	 * Имя файла с шаблоном для вывода информации об авторе комментария
	 *
	 * @var string
	 */
	var $_postinfo_tpl = 'comment_info.tpl';

/**
 * Внутренние методы класса
 */

	/**
	 * Метод, предназначенный для получения основных настроек модуля,которые задаются в Панели управления.
     *
     * @param string $param название параметра
	 * @return mixed значение настройки
	*/
	function _commentSettingsGet($param = '')
	{
		global $AVE_DB;

		// Определяем статическую переменную, которая будет хранить полученные настройки на протяжении всего
        // срока жизни объекта.
        static $settings = null;

        // Если переменная $settings еще не имеет значений, тогда выполняем запрос к БД на получение данных
		if ($settings === null)
		{
			$settings = $AVE_DB->Query("
				SELECT *
				FROM " . PREFIX . "_modul_comments
				WHERE Id = '" . $this->_config_id . "'
			")->FetchAssocArray();
		}

		if ($param == '') return $settings;

        // В противном случае возвращаем уже имеющиеся значения
		return (isset($settings[$param]) ? $settings[$param] : null);
	}

    /**
     * Метод, предназначенный для получения количества комментариев для определенного документа.
     *
     * @param int $document_id - идентификатор документа
     * @return int - количество комментариев
     */
    function _commentPostCountGet($document_id)
    {
        global $AVE_DB;

   		// Определяем статический массив, который будет хранить количество комментариев для документов на
        // протяжении всего срока жизни объекта.
        static $comments = array();

        // Если в массиве не найден ключ, который соответствует запрашиваемому документу, тогда выполняем
        // запрос к БД на получение количества комментариев
        if (! isset($comments[$document_id]))
        {
            $comments[$document_id] = $AVE_DB->Query("
                SELECT COUNT(*)
                FROM " . PREFIX . "_modul_comment_info
                WHERE document_id = '" . $document_id . "'
            ")->GetCell();
        }

        // Возвращаем количество комментариев для запрашиваемого документа
        return $comments[$document_id];
    }

/**
 * Внешние методы класса
 */

	/**
	 * Следующие методы описывают работу модуля в Публичной части сайта.
     */

    /**
     * Метод, предназначенный для получения из БД всех комментариев, относящихся к указанному
     * документу с последующим выводом в Публичной части.
     *
     * @param string $tpl_dir - путь к шаблонам модуля
     *
	 * @todo Вывод информации о авторе комментария
     */
    function commentListShow($tpl_dir)
	{
		global $AVE_DB, $AVE_Template;

		// Проверяем, что в настройках модуля разрешено комментирование документов
        if ($this->_commentSettingsGet('comment_active') == 1)
		{
			$assign['display_comments'] = 1;

            // Если группа пользователя, который в текущий момент просматривает документ попадает в список
            // разрешенных (в настройках модуля), тогда создаем флаг, который будет разрешать к показу
            // форму для добавления нового комментария
            if (in_array(UGROUP, explode(',', $this->_commentSettingsGet('comment_user_groups'))))
			{
				$assign['cancomment'] = 1;
			}

            $assign['comment_max_chars'] = $this->_commentSettingsGet('comment_max_chars');
			$assign['im'] = $this->_commentSettingsGet('comment_use_antispam');

			// Выполняем запрос к БД на получение количества комментариев для текущего документа
            $comments = array();
			$sql = $AVE_DB->Query("
				SELECT *
				FROM " . PREFIX . "_modul_comment_info
				WHERE document_id = '" . (int)$_REQUEST['id'] . "'
				" . (UGROUP == 1 ? '' : "AND comment_status = '1'") . "
				ORDER BY comment_published ASC
			");

			// Получаем формат даты, который указан в общих настройках системы и
            // приводим дату создания комментария и дату редактирования к этому формату
            $date_time_format = $AVE_Template->get_config_vars('COMMENT_DATE_TIME_FORMAT');
			while ($row = $sql->FetchAssocArray())
			{
				$row['comment_published']  = strftime($date_time_format, $row['comment_published']);
				$row['comment_changed'] = strftime($date_time_format, $row['comment_changed']);
//				if ($row['parent_id'] == 0)
//					$row['comment_text'] = nl2br(wordwrap($row['comment_text'], 100, "\n", true));
//				else
//					$row['comment_text'] = nl2br(wordwrap($row['comment_text'], 90, "\n", true));
//				$row['comment_text'] = nl2br($row['comment_text']);

				$comments[$row['parent_id']][] = $row;
			}

			// Формируем ряд переменных для использования в шаблоне
            $assign['closed'] = @$comments[0][0]['comments_close'];
			$assign['comments'] = $comments;
			$assign['theme'] = defined('THEME_FOLDER') ? THEME_FOLDER : DEFAULT_THEME_FOLDER;
			$assign['doc_id'] = (int)$_REQUEST['id'];
			$assign['page'] = base64_encode(get_redirect_link());
			$assign['subtpl'] = $tpl_dir . $this->_comments_tree_sub_tpl;
			$AVE_Template->assign($assign);

            // Отображаем шаблон
            $AVE_Template->display($tpl_dir . $this->_comments_tree_tpl);
		}
	}

	/**
	 * Метод, предназначенный для отображения формы при добавлении нового комментария.
	 *
     * @param string $tpl_dir - путь к шаблонам модуля
	 */
	function commentPostFormShow($tpl_dir)
	{
		global $AVE_DB, $AVE_Template;

		// Получаем список комментариев на которые запрещены ответы
        $geschlossen = $AVE_DB->Query("
			SELECT comments_close
			FROM " . PREFIX . "_modul_comment_info
			WHERE document_id = '" . (int)$_REQUEST['docid'] . "'
			LIMIT 1
		")->GetCell();

		// Формируем ряд переменных для использования в шаблоне
        $AVE_Template->assign('closed', $geschlossen);
		$AVE_Template->assign('cancomment', ($this->_commentSettingsGet('comment_active') == 1 && in_array(UGROUP, explode(',', $this->_commentSettingsGet('comment_user_groups')))));
		$AVE_Template->assign('comment_max_chars', $this->_commentSettingsGet('comment_max_chars'));
		$AVE_Template->assign('theme', defined('THEME_FOLDER') ? THEME_FOLDER : DEFAULT_THEME_FOLDER);

        // Отображаем форму для добавления комментария
        $AVE_Template->display($tpl_dir . $this->_comment_form_tpl);
	}

    /**
	 * Метод, предназначенный для записи в БД нового комментария.
	 *
     * @param string $tpl_dir - путь к шаблонам модуля
     *
     * @todo Вывод сообщения о результате добавления комментария, а также
     * рассмотреть вопрос о добавлении еще одного параметра настройки модуля, который будет определять
     * необходимость отправки уведомления на e-mail о новом комментарии. Возможно не всем хочется получать
     * уведомления.
     *
	 */
	function commentPostNew($tpl_dir)
	{
		global $AVE_DB, $AVE_Template;
        // Если запрос пришел не ajax запросом, тогда формируем ссылку для последующего редиректа
		if (! $ajax = (isset($_REQUEST['ajax']) && $_REQUEST['ajax'] == 1))
		{
			$link = rewrite_link(urldecode(get_redirect_link()));
		}

        // Если в настройках модуля включено использование защитного кода, тогда
        if ($this->_commentSettingsGet('comment_use_antispam') == 1)
		{
            // Если введенный пользователем защитный код неверен, тогда выполняем обновление кода
            if (! (isset($_SESSION['captcha_keystring']) && isset($_POST['securecode'])
                && $_SESSION['captcha_keystring'] == $_POST['securecode']))
			{
				unset($_SESSION['captcha_keystring']);

				if ($ajax)
				{
					echo 'wrong_securecode';
				}
				else
				{
					$GLOBALS['tmpl']->assign("wrongSecureCode", 1);
					header('Location:' . $link . '#end');
				}
				exit;
			}
            unset($_SESSION['captcha_keystring']);
		}

		// Определяем флаг модерации комментариев
        $comment_status = ($this->_commentSettingsGet('comment_need_approve') == 1) ? 0 : 1;

		// Если комментарии разрешены, тогда получаем все данные, который пользователь указал в форме
        if ($this->_commentSettingsGet('comment_active') == 1
			&& !empty($_POST['comment_text'])
			&& !empty($_POST['comment_author_name'])
			&& in_array(UGROUP, explode(',', $this->_commentSettingsGet('comment_user_groups'))))
		{
			$new_comment['parent_id'] = (int)$_POST['parent_id'];
			$new_comment['document_id'] = (int)$_POST['doc_id'];
			$new_comment['comment_author_name'] = $_POST['comment_author_name'];
			$new_comment['comment_author_id'] = empty($_SESSION['user_id']) ? '' : $_SESSION['user_id'];
			$new_comment['comment_author_email'] = $_POST['comment_author_email'];
			$new_comment['comment_author_city'] = $_POST['comment_author_city'];
			$new_comment['comment_author_website'] = $_POST['comment_author_website'];
			$new_comment['comment_author_ip'] = $_SERVER['REMOTE_ADDR'];
			$new_comment['comment_published'] = time();
			$new_comment['comment_text'] = $_POST['comment_text'];
			$new_comment['comment_status'] = $comment_status;

			// Если данные были отправлены с помощью ajax_запроса, преобразуем текстовую информацию
            // в кодировку cp1251
            if ($ajax)
			{
				$new_comment['comment_author_name'] = iconv('utf-8', 'cp1251', $new_comment['comment_author_name']);
				$new_comment['comment_author_email'] = iconv('utf-8', 'cp1251', $new_comment['comment_author_email']);
				$new_comment['comment_author_website'] = iconv('utf-8', 'cp1251', $new_comment['comment_author_website']);
				$new_comment['comment_author_city'] = iconv('utf-8', 'cp1251', $new_comment['comment_author_city']);
				$new_comment['comment_text'] = iconv('utf-8', 'cp1251', $new_comment['comment_text']);
			}

			// Определяем максимальную длину символов для комментария
            $comment_max_chars = $this->_commentSettingsGet('comment_max_chars');
			$comment_max_chars = (!empty($comment_max_chars) && $comment_max_chars > 10) ? $comment_max_chars : 200;

            // Если длина комментария превышает максимально допустимую, обрезаем текст, до максимального значения
			$new_comment['comment_text'] = substr(stripslashes($new_comment['comment_text']), 0, $comment_max_chars);
			$new_comment['comment_text'] .= (strlen($new_comment['comment_text']) > $comment_max_chars) ? '…' : '';
//			$new_comment['comment_text'] = htmlspecialchars($new_comment['comment_text'], ENT_QUOTES);
			$new_comment['comment_text'] = pretty_chars($new_comment['comment_text']);

            // Выполняем запрос к БД на добавление комментария
            $AVE_DB->Query("
				INSERT INTO " . PREFIX . "_modul_comment_info
					(" . implode(',', array_keys($new_comment)) .")
				VALUES
					('" . implode("','", $new_comment) . "')
			");
			$new_comment['Id'] = $AVE_DB->InsertId();

			// Получаем e-mail адрес из Общих настроек системы и формируем ссылку на комментарий в Публичной части
            $mail_from = get_settings('mail_from');
			$mail_from_name = get_settings('mail_from_name');
			$page = get_home_link() . urldecode(base64_decode($_REQUEST['page'])) . '&subaction=showonly&comment_id=' . $new_comment['Id'] . '#' . $new_comment['Id'];

			//  Формируем текст уведомления для отправки на e-mail
            $mail_text = $AVE_Template->get_config_vars('COMMENT_MESSAGE_ADMIN');
			$mail_text = str_replace('%COMMENT%', stripslashes($new_comment['comment_text']), $mail_text);
			$mail_text = str_replace('%N%', "\n", $mail_text);
			$mail_text = str_replace('%PAGE%', $page, $mail_text);
			$mail_text = str_replace('&amp;', '&', $mail_text);

			// Отправляем уведомление
            send_mail(
				$mail_from,
				$mail_text,
				$AVE_Template->get_config_vars('COMMENT_SUBJECT_MAIL'),
				$mail_from,
				$mail_from_name,
				'text'
			);

			// Если данные были отправлены ajax-запросом, тогда выполняем автоматический показ комментария
            // на странице.
            if ($ajax)
			{
				$new_comment['comment_published'] = strftime($AVE_Template->get_config_vars('COMMENT_DATE_TIME_FORMAT'), $new_comment['comment_published']);
				$subcomments[] = $new_comment;
				$AVE_Template->assign('subcomments', $subcomments);
				$AVE_Template->assign('theme', defined('THEME_FOLDER') ? THEME_FOLDER : DEFAULT_THEME_FOLDER);
				$AVE_Template->display($tpl_dir . $this->_comments_tree_sub_tpl);
			}
		}

//		$JsAfter = ($comment_status == 0) ? $AVE_Template->get_config_vars('COMMENT_AFTER_MODER') : $AVE_Template->get_config_vars('COMMENT_THANKYOU_TEXT');
//		$AVE_Template->assign('JsAfter', $JsAfter);
//		$AVE_Template->display($tpl_dir . $this->_comment_thankyou_tpl);

        // Если же данные пришли НЕ ajax-запросом, тогда полностью обновляем страницу.
		if (! $ajax) header('Location:' . $link . '#end');
		exit;
	}

    /**
     * Метод, предназначенный для редактирования комментария в Публичной части
     *
     * @param int $comment_id - идентификатор комментария
     */
	function commentPostEdit($comment_id)
	{
		global $AVE_DB;

		if (empty($_SESSION['user_id'])) exit;

        $comment_id  = intval(preg_replace('/\D/', '', $comment_id));

		// Выполняем запрос к БД и получаем всю информацию о комментарии, а также ряд значений из настроек модуля
        $row = $AVE_DB->Query("
			SELECT
			--	msg.Id,
			--	msg.document_id,
			--	msg.comment_author_name,
			--	msg.comment_author_email,
			--	msg.comment_author_city,
			--	msg.comment_author_website,
				msg.parent_id,
				msg.comment_text,
				cmnt.comment_user_groups,
				cmnt.comment_max_chars,
				cmnt.comment_need_approve
			FROM
				" . PREFIX . "_modul_comment_info AS msg,
				" . PREFIX . "_modul_comments AS cmnt
			WHERE comment_active = '1'
			AND msg.Id = '" . $comment_id . "'
			" . ((UGROUP != 1) ? "AND comment_author_id = " . $_SESSION['user_id'] : '') . "
		")->FetchAssocArray();

		// Если данные получены
        if ($row !== false)
		{

            $comment_max_chars = ($row['comment_max_chars'] != '' && $row['comment_max_chars'] > 10) ? $row['comment_max_chars'] : 20;

			$comment_text = iconv('utf-8', 'cp1251', $_POST['text']);

			// Преобразуем все HTML сущности к числовым аналогам
			$comment_text = preg_replace_callback('/&([a-zA-Z][a-zA-Z0-9]{1,7});/', 'convert_entity', $comment_text);

			// Форматируем текст сообщения
			$comment_text = preg_replace('/&#x([0-9a-f]{1,7});/ei', 'chr(hexdec("\\1"))', $comment_text);
			$comment_text = preg_replace('/&#([0-9]{1,7});/e', 'chr("\\1")', $comment_text);

			$comment_text = stripslashes($comment_text);
			$comment_text = str_replace(array("<br>\n", "<br />\n", "<br/>\n"), "\n", $comment_text);
//			$comment_text = strip_tags($comment_text);
			$comment_text = substr($comment_text, 0, $comment_max_chars-1);
			$message_length = strlen($comment_text);
			$comment_text .= ($message_length > $comment_max_chars) ? '…' : '';
//			$comment_text = pretty_chars(htmlspecialchars($comment_text, ENT_QUOTES));

			// Если группа текущего пользователя совпадает с разрешенной группой в настройках модуля, тогда
            // выполняем запрос к БД на обновление информации.
            if (in_array(UGROUP, explode(',', $row['comment_user_groups'])) && $message_length > 3)
			{
				$AVE_DB->Query("
					UPDATE " . PREFIX . "_modul_comment_info
					SET
					--	comment_author_name = '" . (empty($_POST['comment_author_name']) ? @addslashes($row['comment_author_name']) : $_POST['comment_author_name']) . "',
					--	comment_author_email = '" . (empty($_POST['comment_author_email']) ? @addslashes($row['comment_author_email']) : $_POST['comment_author_email']) . "',
					--	comment_author_city = '" . (empty($_POST['comment_author_city']) ? @addslashes($row['comment_author_city']) : $_POST['comment_author_city']) . "',
					--	comment_author_website = '" . (empty($_POST['comment_author_website']) ? @addslashes($row['comment_author_website']) : $_POST['comment_author_website']) . "',
						comment_changed = '" . time() . "',
						comment_status = '" . intval(!(bool)$row['comment_need_approve']) . "',
						comment_text = '" . addslashes($comment_text) . "'
					WHERE
						Id = '" . $comment_id . "'
				");

//				if ($row['parent_id'] == 0)
//					echo nl2br(wordwrap($comment_text, 100, "\n", true));
//				else
//					echo nl2br(wordwrap($comment_text, 90, "\n", true));
//				echo nl2br(htmlspecialchars($comment_text, ENT_QUOTES));

				// Преобразуем HTML теги в HTML сущности
                echo htmlspecialchars($comment_text, ENT_QUOTES);
				exit;
			}

//			if ($row['parent_id'] == 0)
//				echo nl2br(wordwrap($row['comment_text'], 100, "\n", true));
//			else
//				echo nl2br(wordwrap($row['comment_text'], 90, "\n", true));
//			echo nl2br(htmlspecialchars($row['comment_text'], ENT_QUOTES));

			// Преобразуем HTML теги в HTML сущности
            echo htmlspecialchars($row['comment_text'], ENT_QUOTES);
		}
		exit;
	}

    /**
     * Метод, предназначенный для удаления комментария. Если комментарий содержал какие-либо ответы на него,
     * то все ответы также будут удалены вместе с родительским комментарием.
     *
     * @param int $comment_id - идентификатор комментария
     */
	function commentPostDelete($comment_id)
	{
		global $AVE_DB;

        // Выполняем запрос к БД на удаление родительского комментария
		$AVE_DB->Query("
			DELETE
			FROM " . PREFIX . "_modul_comment_info
			WHERE Id = '" . $comment_id . "'
		");

        // Выполняем запрос к БД на удаление дочерних комментариев (ответов)
        $AVE_DB->Query("
			DELETE
			FROM " . PREFIX . "_modul_comment_info
			WHERE parent_id = '" . $comment_id . "'
			AND parent_id != 0
		");

		exit;
	}
	function commentAdminDelete($comment_id)
	{
		global $AVE_DB;

        // Выполняем запрос к БД на удаление родительского комментария
		$AVE_DB->Query("
			DELETE
			FROM " . PREFIX . "_modul_comment_info
			WHERE Id = '" . $comment_id . "'
		");

        // Выполняем запрос к БД на удаление дочерних комментариев (ответов)
        $AVE_DB->Query("
			DELETE
			FROM " . PREFIX . "_modul_comment_info
			WHERE parent_id = '" . $comment_id . "'
			AND parent_id != 0
		");
        header('Location:index.php?do=modules&action=modedit&mod=comment&moduleaction=1&cp= . SESSION');
		exit;
	}

	/**
	 * Метод, предназначенный для вывода детальной информации об авторе комментария
	 *
     * @param string $tpl_dir - путь к шаблонам модуля
	 */
	function commentPostInfoShow($tpl_dir)
	{
		global $AVE_DB, $AVE_Template;

		// Получаем полную информацию о комментарии
        $row = $AVE_DB->Query("
			SELECT *
			FROM " . PREFIX . "_modul_comment_info
			WHERE Id = '" . (int)$_REQUEST['Id'] . "'
		")->FetchAssocArray();

        // Преобразуем адрес сайта к формату ссылки
        $row['comment_author_website'] = str_replace('http://', '', $row['comment_author_website']);
		$row['comment_author_website'] = ($row['comment_author_website'] != '') ? '<a target="_blank" href="http://' . $row['comment_author_website'] . '">' . $row['comment_author_website'] .'</a>' : '';

		// Выполняем запрос к БД на получение количества всех комментариев, оставленных данным пользователем
        $row['num'] = $AVE_DB->Query("
			SELECT COUNT(*)
			FROM " . PREFIX . "_modul_comment_info
			WHERE comment_author_id = '" . $row['comment_author_id'] . "'
			AND comment_author_id != 0
		")->GetCell();

		// Отображаем окно с информацией
        $AVE_Template->assign('c', $row);
		$AVE_Template->display($tpl_dir . $this->_postinfo_tpl);
	}

    /**
	 * Метод, предназначенный для управления запретом или разрешением отвечать на комментарии
	 *
	 * @param int $comment_id - идентификатор комментария
	 * @param string $comment_status - {lock|unlock} признак запрета/разрешения
	 */
	function commentReplyStatusSet($comment_id, $comment_status = 'lock')
	{
		global $AVE_DB;

		$AVE_DB->Query("
			UPDATE " . PREFIX . "_modul_comment_info
			SET comment_status = '" . (($comment_status == 'lock') ? 0 : 1) . "'
			WHERE Id = '" . $comment_id . "'
		");

		exit;
	}

    /**
	 * Метод, предназначенный для управления запретом или разрешением комментировать документ
	 *
	 * @param int $document_id - идентификатор документа
	 * @param string $comment_status - {close|open} признак запрета/разрешения
	 */
	function commentStatusSet($document_id, $comment_status = 'open')
	{
		global $AVE_DB;

		$AVE_DB->Query("
			UPDATE " . PREFIX . "_modul_comment_info
			SET comments_close = '" . (($comment_status == 'open') ? 0 : 1) . "'
			WHERE document_id = '" . $document_id . "'
		");

		exit;
	}

    /**
	 * Следующие методы описывают работу модуля в Административной части сайта.
	 */

    /**
     * Метод, предназначенный для вывода списка всех комментариев в Административной части.
     *
     * @param string $tpl_dir - путь к шаблонам модуля
     */
	function commentAdminListShow($tpl_dir)
	{
		global $AVE_DB, $AVE_Template;

		// Получаем общее количество комментариев
        $num = $AVE_DB->Query("SELECT COUNT(*) FROM " . PREFIX . "_modul_comment_info")->GetCell();

		// Определяем количество страниц, учитывая параметр _limit, который опроеделяет количество
        // комментариев отображаемых на одной странице
        @$seiten = @ceil($num / $this->_limit);
		$start = get_current_page() * $this->_limit - $this->_limit;

		$docs = array();

		$def_sort = 'ORDER BY doc.Id DESC';
		$def_nav = '';

        // Определяем условия сортировки комментариев
		if (!empty($_REQUEST['sort']))
		{
			switch ($_REQUEST['sort'])
			{
				case 'document_desc':
					$def_sort = 'ORDER BY CId ASC';
					$def_nav  = '&sort=document_desc';
					break;

				case 'document':
					$def_sort = 'ORDER BY CId DESC';
					$def_nav  = '&sort=document';
					break;

				case 'comment_desc':
					$def_sort = 'ORDER BY cmnt.comment_text ASC';
					$def_nav  = '&sort=comment_desc';
					break;

				case 'comment':
					$def_sort = 'ORDER BY cmnt.comment_text DESC';
					$def_nav  = '&sort=comment';
					break;

				case 'created_desc':
					$def_sort = 'ORDER BY cmnt.comment_published ASC';
					$def_nav  = '&sort=created_desc';
					break;

				case 'created':
					$def_sort = 'ORDER BY cmnt.comment_published DESC';
					$def_nav  = '&sort=created';
					break;
			}
		}

        // Выполняем запрос к БД на получение комметариев с учетом параметров сортировки и лимита.
        $sql = $AVE_DB->Query("
			SELECT
				doc.Id,
				doc.document_title,
				cmnt.Id AS CId,
				cmnt.document_id,
				cmnt.comment_text,
				cmnt.comment_published
			FROM
                " . PREFIX . "_modul_comment_info AS cmnt
			JOIN
                " . PREFIX . "_documents AS doc
			        ON doc.Id = cmnt.document_id
			" . $def_sort . "
			LIMIT " . $start . "," . $this->_limit
		);

		while ($row = $sql->FetchAssocArray())
		{
            $row['Comments'] = $this->_commentPostCountGet($row['Id']);
			array_push($docs, $row);
		}

        // Если количество комментариев полученных из БД превышает допустимое на странице, тогда формируем
        // меню постраницной навигации
        if ($num > $this->_limit)
		{
			$page_nav = ' <a class="pnav" href="index.php?do=modules&action=modedit&mod=comment&moduleaction=1&cp=' . SESSION . '&page={s}' . $def_nav . '">{t}</a> ';
			$page_nav = get_pagination($seiten, 'page', $page_nav);
			$AVE_Template->assign('page_nav', $page_nav);
		}

        // Передаем данные в шаблон для вывода и отображаем шаблон
        $AVE_Template->assign('docs', $docs);
		$AVE_Template->assign('content', $AVE_Template->fetch($tpl_dir . $this->_admin_comments_tpl));
	}

    /**
     * Метод, предназначенный для редактирования комментариев в Административной части.
     *
     * @param string $tpl_dir - путь к шаблонам модуля
     */
	function commentAdminPostEdit($tpl_dir)
	{
		global $AVE_DB, $AVE_Template;

		// Выполняем запрос к БД на получение информации о редактируемом комментарии
        $row = $AVE_DB->Query("
			SELECT *
			FROM " . PREFIX . "_modul_comment_info
			WHERE Id = '" . (int)$_REQUEST['Id'] . "'
			LIMIT 1
		")->FetchAssocArray();

        // Если в запросе содержится подзапрос на сохранение данных (пользователь уже отредактировал комментарий
        // и нажал кнопку сохранить изменения), тогда выполняем запрос к БД на обновление информации.
        if (isset($_POST['sub']) && $_POST['sub'] == 'send' && false != $row)
        {
            $AVE_DB->Query("
                UPDATE " . PREFIX . "_modul_comment_info
                SET
                    comment_author_name = '" . htmlspecialchars($_POST['comment_author_name']) . "',
                    comment_author_email = '" . htmlspecialchars($_POST['comment_author_email']) . "',
                    comment_author_city = '" . htmlspecialchars($_POST['comment_author_city']) . "',
                    comment_author_website = '" . htmlspecialchars($_POST['comment_author_website']) . "',
                    comment_text = '" . htmlspecialchars($_POST['comment_text']) . "',
                    comment_changed = '" . time() . "'
                WHERE
                    Id = '" . (int)$_POST['Id'] . "'
            ");

            echo '<script>window.opener.location.reload();window.close();</script>';

            return;
        }

		// Если в первой выборке из БД мы получили нулевой результат, тогда генерируем сообщение с ошибкой
        if ($row == false)
		{
			$AVE_Template->assign('editfalse', 1);
		}
		// в противном случае получаем список комментариев, у которых стоит запрет на ответы
        else
		{
		    $closed = $AVE_DB->Query("
			    SELECT comments_close
			    FROM " . PREFIX . "_modul_comment_info
			    WHERE document_id = '" . (int)$_REQUEST['docid'] . "'
			    LIMIT 1
		    ")->GetCell();

		    $AVE_Template->assign('closed', $closed);
            $AVE_Template->assign('row', $row);
		    $AVE_Template->assign('comment_max_chars', $this->_commentSettingsGet('comment_max_chars'));
        }

        // Отображаем шаблон
        $AVE_Template->assign('content', $AVE_Template->fetch($tpl_dir . $this->_admin_edit_link_tpl));
	}

    /**
     * Метод, предназначенный для управления настройками модуля
     *
     * @param string $tpl_dir - путь к шаблонам модуля
     */
	function commentAdminSettingsEdit($tpl_dir)
	{
		global $AVE_DB, $AVE_Template;

        // Если в запросе содержится подзапрос на сохранение данных (пользователь нажал кнопку
        // сохранить изменения), тогда выполняем запрос к БД на обновление информации.

		if (isset($_REQUEST['sub']) && $_REQUEST['sub'] == 'save')
		{
			$_POST['comment_max_chars'] = (empty($_POST['comment_max_chars']) || $_POST['comment_max_chars'] < 50) ? 50 : $_POST['comment_max_chars'];
			$AVE_DB->Query("
				UPDATE " . PREFIX . "_modul_comments
				SET
					comment_max_chars = '" . @(int)$_POST['comment_max_chars'] . "',
					comment_user_groups = '" . @implode(',', $_POST['comment_user_groups']) . "',
					comment_need_approve = '" . @(int)$_POST['comment_need_approve'] . "',
					comment_active = '" . @(int)$_POST['comment_active'] . "',
					comment_use_antispam = '" . @(int)$_POST['comment_use_antispam'] . "'
				WHERE
					Id = 1
			");
		}

        // Получаем список всех настроек модуля
		$row = $this->_commentSettingsGet();
        $row['comment_user_groups'] = explode(',', $row['comment_user_groups']);

		// Передаем данные в шаблон и показываем страницу с настройками модуля
        $AVE_Template->assign($row);
		$AVE_Template->assign('content', $AVE_Template->fetch($tpl_dir . $this->_admin_settings_tpl));
	}
}

?>