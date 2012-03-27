<?php

/**
 * Класс, включающий все свойства и методы для управления контактными формами
 * и сообщениями как в Публичной части сайта, так и в Панели управления.
 *
 * @package AVE.cms
 * @subpackage module_Contact
 * @since 1.4
 * @filesource
 */
class Contact
{

/**
 *	Свойства класса
 */

	/**
	 * Количество записей в списке форм административной части
	 *
	 * @var int
	 */
	var $_adminlimit = 15;

	/**
	 * Удалять прикреплённые файлы с диска
	 *
	 * @var int
	 */
	var $_delfile = 1;

	/**
	 * Регулярное выражение корректного e-Mail
	 *
	 * @var string
	 */
	var $_regex_email = '/[\w.-]+@[a-z0-9.-]+\.(?:[a-z]{2}|com|org|net|edu|gov|mil|biz|info|mobi|name|aero|asia|jobs|museum)/i';

/**
 *	Внутренние методы класса
 */

	/**
	 * Метод, предназначенный для удаление из текста непечатаемых символов
	 *
	 * @param string $text обрабатываемый текст
	 * @return string обработанный текст
	 */
	function _contactTextClean($text)
	{
		$text = preg_replace('/[^\x20-\xFF]/', '', $text);
//		$text = htmlspecialchars($text);

		return $text;
	}

	/**
	 * Метод, предназначенный для вывода сообщения об успешной отправке формы
	 *
	 * @param string $tpl_dir путь к папке с шаблонами
	 * @param string $lang_file путь к языковому файлу
	 */
	function _contactThankyou($tpl_dir, $lang_file)
	{
		global $AVE_Template;

		$AVE_Template->config_load($lang_file);

		$AVE_Template->display($tpl_dir . 'thankyou.tpl');
	}

	/**
	 * Метод, предназначенный для формирования уникальных имен файлов,
     * которые были прикреплены к сообщениям
	 *
	 * @param string $file имя файла
	 * @return string изменённое имя файла
	 */
	function _contactFileRename($file)
	{
		$old = $file;
		mt_rand();
		$random = rand(1000, 9999);
		$new = $random . '_' . $old;

		return $new;
	}

	/**
	 * Метод, предназначенный для записи прикреплённых файлов в папку /attachments
	 *
	 * @param int $maxupload максимальный размер прикреплённых файлов
	 * @return string путь к файлу в хранилище (/attachments)
	 */
	function _contactFileUpload($maxupload = '0')
	{
		global $_FILES;

		$attach = '';
		define('UPDIR', BASE_DIR . '/attachments/');

        // Если к сообщению прикреплены файлы - циклически обрабатываем каждый файл,
        // приводя имя файла к нижнему регистру, убирая из имени пробелы,
        // и если файл с таким именем уже существует - формируем уникальное имя файла.
        // Также, в данном методе происходит проверка на максимально-допустимый размер файла.
        if (isset($_FILES['upfile']) && is_array($_FILES['upfile']))
		{
			for ($i=0; $i<count($_FILES['upfile']['tmp_name']); $i++)
			{
				if ($_FILES['upfile']['tmp_name'][$i] != '')
				{
					$d_name = mb_strtolower(trim($_FILES['upfile']['name'][$i]));
					$d_name = str_replace(' ', '_', $d_name);
					$d_tmp = $_FILES['upfile']['tmp_name'][$i];

					$fz = filesize($_FILES['upfile']['tmp_name'][$i]);
					$mz = $maxupload*1024;

					if ($mz >= $fz)
					{
						if (file_exists(UPDIR . $d_name))
						{
							$d_name = $this->_contactFileRename($d_name);
						}

						@move_uploaded_file($d_tmp, UPDIR . $d_name);

						$attach[] = $d_name;
					}
				}
			}
		}

		return $attach;
	}

	/**
	 * Метод возвращающий получателей отправленных форм в виде строки
	 *
	 * @return string получатели отправленных форм
	 */
	function _contactRecieverMultiGet()
	{
		$match_email = '';
		$cf_reciever_multi = trim($_REQUEST['contact_form_reciever_multi']);
		$e_recievers = preg_split('/\s*;\s*/', $cf_reciever_multi);
		$cf_reciever_multi = array();
		foreach ($e_recievers as $reciever)
		{
			$reciever = trim($reciever, ',');
			if ($reciever != '')
			{
				if (preg_match($this->_regex_email, $reciever, $match_email))
				{
					$e_reciever = preg_split('/\s*,(\s*,*\s*)*/', $reciever);
					if (sizeof($e_reciever) > 2)
					{
						$reciever = $match_email[0];
					}
					else
					{
						$reciever = trim(implode(',', $e_reciever), ',');
					}

					if ($reciever != '') array_push($cf_reciever_multi, $reciever);
				}
			}
		}

		return implode(';', $cf_reciever_multi);
	}

	/**
	 * Метод возвращающий группы пользователей имеющих доступ к форме в виде строки
	 *
	 * @return string строка групп пользователей
	 */
	function _contactAllowGroupGet()
	{
		return (!empty($_REQUEST['contact_form_allow_group'])
			? implode(',', $_REQUEST['contact_form_allow_group'])
			: '');
	}

/**
 *	Внешние методы класса
 */

	/**
	 * Методы публичной части
	 */

	/**
	 * Метод, предназначенный для вывода контактной формы в публичной части сайта
	 *
	 * @param string $tpl_dir путь к папке с шаблонами
	 * @param string $lang_file путь к языковому файлу
	 * @param int $contact_form_id идентификатор формы
	 * @param int $spam_protect использовать защитный код 1
	 * @param int $max_upload максимальный размер прикреплённого файла
	 * @param int $fetch вывод в браузер 1
	 * @return string контактная форма
	 */
	function contactFormShow($tpl_dir, $lang_file, $contact_form_id, $spam_protect = null, $max_upload = null, $fetch = '0')
	{
		global $AVE_Core, $AVE_DB, $AVE_Template;

        $contact_form_id = preg_replace('/\D/', '', $contact_form_id);

		$AVE_Template->config_load($lang_file);

        // Получаем всю информацию о данной форме по ее идентификатору
		$row = $AVE_DB->Query("
			SELECT *
			FROM " . PREFIX . "_modul_contacts
			WHERE Id = '" . $contact_form_id . "'
		")->FetchRow();

        // Определяем группы, которым разрешен доступ к данной контактной форме
        $allowed_groups = array();
        if (isset($row->contact_form_allow_group))
        {
			$allowed_groups = explode(',', $row->contact_form_allow_group);
        }

        // Если группа пользователя не входит в разрешенный список групп,
        // фиксируем ошибку и выводим сообщение.
        if (!in_array($_SESSION['user_group'], $allowed_groups))
        {
            $AVE_Template->assign('no_access', 1);
			if (isset($row->contact_form_message_noaccess))
			{
				$AVE_Template->assign('contact_form_message_noaccess', $row->contact_form_message_noaccess);
			}
        }
        // В противном случае
        else
        {
            // Определяем ряд переменных для использования в шаблоне
            $AVE_Template->assign('contact_form_id', $contact_form_id);
            $AVE_Template->assign('im', $spam_protect === null ? $row->contact_form_antispam : $spam_protect);
            $AVE_Template->assign('maxupload', $max_upload === null ? $row->contact_form_max_upload : $max_upload);
            $AVE_Template->assign('send_copy', $row->contact_form_send_copy);

		    // Формируем список получателей данного сообщения (если их несколько)
		    $recievers = array();
            if ($row->contact_form_reciever_multi != '')
		    {
			    $e_recievers = explode(';', $row->contact_form_reciever_multi);
			    foreach ($e_recievers as $reciever)
			    {
					$e_reciever = explode(',', $reciever);
					array_push($recievers, htmlspecialchars($e_reciever[0], ENT_QUOTES));
			    }
		    }
		    $AVE_Template->assign('recievers', $recievers);

            // Если тема сообщения не указана, тогда используем название темы по умолчанию
            if ($row->contact_form_subject_show == '0' && $row->contact_form_subject_default != '')
		    {
			    $AVE_Template->assign('default_subject', $row->contact_form_subject_default);
		    }

		    // Выполняем запрос к БД на получение списка всех полей формы
            $fields = array();
		    $sql = $AVE_DB->Query("
			    SELECT *
			    FROM " . PREFIX . "_modul_contact_fields
			    WHERE contact_field_status = '1'
			    AND contact_form_id = '" . $contact_form_id . "'
			    ORDER BY contact_field_position ASC
		    ");
		    while ($row = $sql->FetchRow())
		    {
			    // Определяем тип поля и формируем регулярное выражение
			    // для проверки введённых символов и их количества
                switch ($row->contact_field_datatype)
			    {
				    // Любые символы
                    case 'anysymbol':
					    $row->field_pattern = $row->contact_field_max_chars != '' ? ('^([\s\S]{' . $row->contact_field_max_chars . '})' . ($row->contact_field_required != 1 ? '?$' : '{1}$')) : '';
					    break;

				    // Только целые числа
                    case 'onlydecimal':
					    $row->field_pattern = $row->contact_field_max_chars != '' ? ('^(\d{' . $row->contact_field_max_chars . '})' . ($row->contact_field_required != 1 ? '?$' : '{1}$')) : '';
					    break;

				    // Только буквы
                    case 'onlychars':
					    $row->field_pattern = $row->contact_field_max_chars != '' ? ('^(\D{' . $row->contact_field_max_chars . '})' . ($row->contact_field_required != 1 ? '?$' : '{1}$')) : '';
					    break;

				    // По умолчанию любые символы
                    default:
					    $row->field_pattern = $row->contact_field_max_chars != '' ? ('^([\s\S]{' . $row->contact_field_max_chars . '})' . ($row->contact_field_required != 1 ? '?$' : '{1}$')) : '';
					    break;
			    }

                // Если тип поля "Выпадающий список", тогда получем все его элементы
                if ($row->contact_field_type == 'dropdown' && $row->contact_field_default != '')
			    {
				    $value = explode(',', $row->contact_field_default);
				    $row->contact_field_default = $value;
			    }

			    // В имени поля заменяем пробелы на подчерки, и формируем массив данных полей
                $field_title_ = str_replace(' ', '_', $row->contact_field_title);
			    $row->value = isset($_REQUEST[$field_title_]) ? $_REQUEST[$field_title_] : '';
			    array_push($fields, $row);
		    }

            // Перердаем в шаблон массив с данными полей и формируем ссылку для редиректа после отправки
            $AVE_Template->assign('fields', $fields);
		    $action = rewrite_link('index.php?id=' . $AVE_Core->curentdoc->Id . '&amp;doc=' . (empty($AVE_Core->curentdoc->document_alias) ? prepare_url($AVE_Core->curentdoc->document_title) : $AVE_Core->curentdoc->document_alias));
		    $AVE_Template->assign('contact_action', $action);
		}

		// Возвращаем сформированную контактную форму
        if ($fetch == 1) return $AVE_Template->fetch($tpl_dir . 'form.tpl');

		// Отображаем сформированную контактную форму
		if (file_exists($tpl_dir . 'form-'.$contact_form_id.'.tpl')) {
			$AVE_Template->display($tpl_dir . 'form-'.$contact_form_id.'.tpl');
		} else {
			$AVE_Template->display($tpl_dir . 'form.tpl');
		}	
	}

	/**
	 * Метод, предназначенный для отправки контактной формы с функцией защиты от спама
	 *
	 * @param string $tpl_dir путь к папке с шаблонами
	 * @param string $lang_file путь к языковому файлу
	 * @param int $contact_form_id идентификатор формы
	 * @param int $spam_protect защита от спама 1
	 * @param int $max_upload максимальный размер прикреплённого файла
	 */
	function contactFormSend($tpl_dir, $lang_file, $contact_form_id, $spam_protect = null, $max_upload = null)
	{
		global $AVE_DB, $AVE_Template;

        // Получаем всю информацию из БД о контактной форме
        $row = $AVE_DB->Query("
            SELECT *
            FROM " . PREFIX . "_modul_contacts
            WHERE Id = '" . $contact_form_id . "'
        ")->FetchRow();

		// Если для данной формы используется защитный код, тогда
        $spam_protect = $spam_protect === null ? $row->contact_form_antispam : $spam_protect;
        if ($spam_protect == 1)
		{
            // Проверяем, правильно ли он указан пользователем
            if (! (isset($_SESSION['captcha_keystring']) && isset($_POST['securecode'])
                && $_SESSION['captcha_keystring'] == $_POST['securecode']))
			{
				// Если нет, фиксируем ошибку и снова показываем форму
                $AVE_Template->assign('wrong_securecode', 1);
                $this->contactFormShow($tpl_dir, $lang_file, $contact_form_id);
                unset($_SESSION['captcha_keystring']);
                return;
			}
            unset($_SESSION['captcha_keystring']);
		}

        $AVE_Template->config_load($lang_file);

		// Если в форме есть выбор получателя
        if (isset($_REQUEST['reciever']) && is_numeric($_REQUEST['reciever']))
		{
			// Формируем список всех получателей
			$recievers = explode(';', $row->contact_form_reciever_multi);
			if (!empty($recievers[$_REQUEST['reciever']]))
			{
				$cfr = explode(',', $recievers[$_REQUEST['reciever']]);
				$row->contact_form_reciever = (isset($cfr[1]) && trim($cfr[1]))
					? trim($cfr[1])
					: $row->contact_form_reciever;
			}
		}

		// Обрабатываем прикрепленные файлы
		if ($max_upload === null) $max_upload = $row->contact_form_max_upload;
        $attach = $this->_contactFileUpload($max_upload);
		@reset($_POST);
		$newtext = '';
        $skip_keys = array(
            'contact_action',
            'sendcopy',
            'reciever',
            'contact_form_number',
            'contact_form_id',
            'secure_image_id',
            'action',
            'modules',
            'securecode'
        );

		while (list($key, $val) = each($_POST))
		{
			if (!empty($val) && !in_array($key, $skip_keys))
			{
				$key = ($key == 'contact_form_in_subject' || $key == 'contact_form_in_email')
                    ? $AVE_Template->get_config_vars('CONTACT_' . strtoupper(mb_substr($key, 13)))
                    : $key;
				$newtext .= str_replace('_', ' ', $key) . ':  ' . $val . "\n\n";
			}
		}
		$text = strip_tags($newtext);
		$contact_form_in_attachment = (is_array($attach) && count($attach) >= 1) ? implode(';', $attach) : '';

		// Отправляем сообщение получателям с учетом прикрепленных файлов
        send_mail(
			$row->contact_form_reciever,
			stripslashes(mb_substr($text, 0, $row->contact_form_mail_max_chars)),
			$_POST['contact_form_in_subject'],
			$_POST['contact_form_in_email'],
			$_POST['contact_form_in_email'],
			'text',
			$attach
		);

        // Если в настройках модуля указана отправка копии сообщения,
        // тогда выполняем отправку копии на e-mail, указанный в общих настройках системы
        if (isset($_REQUEST['sendcopy']) && $_REQUEST['sendcopy'] == 1)
		{
			$mail_from = get_settings('mail_from');
			$mail_from_name = get_settings('mail_from_name');
			send_mail(
				$_POST['contact_form_in_email'],
				$AVE_Template->get_config_vars('CONTACT_TEXT_THANKYOU') . "\n\n" . stripslashes(mb_substr($text, 0, $row->contact_form_mail_max_chars)),
				$_POST['contact_form_in_subject'] . ' ' . $AVE_Template->get_config_vars('CONTACT_SUBJECT_COPY'),
				$mail_from,
				$mail_from_name,
				'text'
			);
		}

		// Добавляем в БД запись об отправленном сообщении
        $AVE_DB->Query("
			INSERT
			INTO " . PREFIX . "_modul_contact_info
			SET
                contact_form_id            = '" . (int)$_REQUEST['contact_form_id'] . "',
				contact_form_in_email      = '" . $_POST['contact_form_in_email'] . "',
				contact_form_in_date       = '" . time() . "',
				contact_form_in_subject    = '" . $_POST['contact_form_in_subject'] . "',
				contact_form_in_message    = '" . stripslashes(mb_substr($text, 0, $row->contact_form_mail_max_chars)) . "',
				contact_form_in_attachment = '" . $contact_form_in_attachment . "'
		");

        // Отображаем сообщение о успешной отправке формы с благодарностью
        $this->_contactThankyou($tpl_dir, $lang_file);
	}

	/**
	 * Методы административной части
	 */

    /**
	 * Метод, предназначенный для вывода списка всех контактных форм в Панели управления
	 *
	 * @param string $tpl_dir путь к папке с шаблонами
	 */
	function contactFormList($tpl_dir)
	{
		global $AVE_DB, $AVE_Template;

		// Получаем общее количество контактных форм в системе
        $num = $AVE_DB->Query("SELECT COUNT(*) FROM " . PREFIX . "_modul_contacts")->GetCell();

		// Определяем максимальное количество контактных форм на странице
        $limit = $this->_adminlimit;

        // Определяем текущую страницу списка контактных форм
		$start = get_current_page() * $limit - $limit;

		// Получаем информацию о контактных формах, а также о количестве прочитанных и непрочитанных сообщений
        // для каждой из форм.
        $items = array();
		$sql = $AVE_DB->Query("
            SELECT
                frm.*,
                SUM(IF(contact_form_out_date>0,1,0)) AS messages_new,
                SUM(IF(contact_form_out_date=0,1,0)) AS messages
            FROM
            	" . PREFIX . "_modul_contacts AS frm
            LEFT OUTER JOIN
            	" . PREFIX . "_modul_contact_info
                	ON contact_form_id = frm.Id
            GROUP BY frm.Id
			LIMIT " . $start . "," . $limit
		);
		while ($row = $sql->FetchRow())
		{
			array_push($items, $row);
		}

        // Если количество контактных форм на странице превышает установленный лимит, формируем постраничную навигацию
        if ($num > $limit)
		{
			$pagination_template = " <a class=\"pnav\" href=\"index.php?do=modules&action=modedit&mod=contact&moduleaction=1&cp=" . SESSION . "&page={s}\">{t}</a> ";
			$AVE_Template->assign('page_nav', get_pagination(ceil($num / $limit), 'page', $pagination_template));
		}

        // Передаем данные в шаблон и отображаем страницу
        $AVE_Template->assign('items', $items);
		$AVE_Template->assign('content', $AVE_Template->fetch($tpl_dir . 'admin_forms.tpl'));
	}

	/**
	 * Метод, предназначенный для создание новой формы
	 *
	 * @param string $tpl_dir путь к папке с шаблонами
	 */
	function contactFormNew($tpl_dir)
	{
		global $AVE_DB, $AVE_Template;

        // Определяем, пришел ли запрос на сохранение данных
        switch($_REQUEST['sub'])
		{
			// Если нет
            case '':
				// Получаем список групп пользователей в системе
                $user_groups = array();
				$sql_g = $AVE_DB->Query("
					SELECT
						user_group,
						user_group_name
					FROM " . PREFIX . "_user_groups
				");
				while ($row_g = $sql_g->FetchRow())
				{
					array_push($user_groups, $row_g);
				}

				// Формируем ряд переменных и передаем их в шаблон
                $AVE_Template->assign('groups', $user_groups);
				$AVE_Template->assign('include_path', $tpl_dir);
				$AVE_Template->assign('formaction', 'index.php?do=modules&action=modedit&mod=contact&moduleaction=new&sub=save&cp=' . SESSION . '&pop=1');

                // Формируем форму ввода новой контактной формы
                $AVE_Template->assign('content', $AVE_Template->fetch($tpl_dir . 'admin_fields.tpl'));
				break;

			// Если да
            case 'save':
                // Выполняем запрос к БД на добавление новой формы
                $AVE_DB->Query("
					INSERT
					INTO " . PREFIX . "_modul_contacts
					SET
						Id                            = '',
						contact_form_title            = '" . $_REQUEST['contact_form_title'] . "',
						contact_form_mail_max_chars   = '" . $_REQUEST['contact_form_mail_max_chars'] . "',
						contact_form_reciever         = '" . $_REQUEST['contact_form_reciever'] . "',
						contact_form_reciever_multi   = '" . $this->_contactRecieverMultiGet() . "',
						contact_form_antispam         = '" . $_REQUEST['contact_form_antispam'] . "',
						contact_form_max_upload       = '" . $_REQUEST['contact_form_max_upload'] . "',
						contact_form_allow_group      = '" . $this->_contactAllowGroupGet() . "',
						contact_form_message_noaccess = '" . $_REQUEST['contact_form_message_noaccess'] . "',
						contact_form_send_copy        = '" . $_REQUEST['contact_form_send_copy'] . "'
				");
				$iid = $AVE_DB->InsertId();

                // Сохраняем системное сообщние
				reportLog($_SESSION['user_name'] . ' - добавил новую контактную форму id=' . $iid . ' (' . stripslashes($_REQUEST['contact_form_title']) . ')', 2, 2);

                // Выполняем обновление страницы
				header('Location:index.php?do=modules&action=modedit&mod=contact&moduleaction=edit&id=' . $iid . '&pop=1&cp=' . SESSION);
				exit;
		}
	}

	/**
	 * Метод, предназначенный для добавления полей новой формы в БД
	 *
	 * @param int $contact_form_id идентификатор формы
	 */
	function contactFormFieldSave($contact_form_id)
	{
		global $AVE_DB;

        // Обрабатываем все поля формы (если они были созданы)
		if (!empty($_POST['contact_field_title']))
		{
			// Убираем из названия поля непечатаемые символы
            $contact_field_title = $this->_contactTextClean($_REQUEST['contact_field_title']);
			if (isset($_REQUEST['contact_field_datatype']))
			{
				switch ($_REQUEST['contact_field_datatype'])
				{
					case 'anysymbol':
					case 'onlydecimal':
					case 'onlychars':
						break;

					default:
						$_REQUEST['contact_field_datatype'] = 'anysymbol';
						break;
				}
			}
			else
			{
				$_REQUEST['contact_field_datatype'] = 'anysymbol';
			}

            // Выполняем запрок к БД на добавление новых полей в форму
            $AVE_DB->Query("
				INSERT
				INTO " . PREFIX . "_modul_contact_fields
				SET
					Id                      = '',
					contact_form_id         = '" . $contact_form_id . "',
					contact_field_type      = '" . $_REQUEST['contact_field_type'] . "',
					contact_field_position  = '" . $_REQUEST['contact_field_position'] . "',
					contact_field_title     = '" . $contact_field_title . "',
					contact_field_required  = '" . $_REQUEST['contact_field_required'] . "',
					contact_field_default   = '" . $this->_contactTextClean($_REQUEST['contact_field_default']) . "',
					contact_field_status    = '" . $_REQUEST['contact_field_status'] . "',
					contact_field_size      = '" . (int)$_REQUEST['contact_field_size'] . "',
					contact_field_newline   = '" . (int)$_REQUEST['contact_field_newline'] . "',
					contact_field_datatype  = '" . $_REQUEST['contact_field_datatype'] . "',
					contact_field_max_chars = '" . $this->_contactTextClean($_REQUEST['contact_field_max_chars']) . "',
					contact_field_value     = '" . $this->_contactTextClean($_REQUEST['contact_field_value']) . "'
			");
            $iid = $AVE_DB->InsertId();

			// Сохраняем системное сообщние
	        reportLog($_SESSION['user_name'] . ' - добавил новое поле в модуле контакты id=' . $iid . ' (' . $contact_field_title . ')', 2, 2);
		}

        // Выполняем обновление страницы
		header('Location:index.php?do=modules&action=modedit&mod=contact&moduleaction=edit&id=' . $contact_form_id . '&pop=1&cp=' . SESSION);
	}

    /**
	 * Метод, предназначенный для редактирование формы в Панели управления
	 *
	 * @param string $tpl_dir путь к папке с шаблонами
	 * @param int $contact_form_id идентификатор формы
	 */
	function contactFormEdit($tpl_dir, $contact_form_id)
	{
		global $AVE_DB, $AVE_Template;

		// Получаем общую информацию о контактной форме, которую мы хотим отредактировать
        $row_e = $AVE_DB->Query("
			SELECT *
			FROM " . PREFIX . "_modul_contacts
			WHERE Id = '" . $contact_form_id . "'
		")->FetchRow();

		// Получаем всю информацию о полях формы, которую мы хотим отредактировать
        $items = array();
		$sql = $AVE_DB->Query("
			SELECT *
			FROM " . PREFIX . "_modul_contact_fields
			WHERE contact_form_id = '" . $contact_form_id . "'
			ORDER BY contact_field_position ASC
		");
		while ($row = $sql->FetchRow())
		{
			array_push($items,$row);
		}

        // Получаем список групп пользователей в системе
        $user_groups = array();
		$sql_g = $AVE_DB->Query("
			SELECT
				user_group,
				user_group_name
			FROM " . PREFIX . "_user_groups
		");
		while ($row_g = $sql_g->FetchRow())
		{
			array_push($user_groups, $row_g);
		}

		// Передаем в шаблон полученные данные и отображаем страницу
        $AVE_Template->assign('groups', $user_groups);
		$AVE_Template->assign('groups_form', explode(',', $row_e->contact_form_allow_group));
		$AVE_Template->assign('row', $row_e);
		$AVE_Template->assign('items', $items);
		$AVE_Template->assign('include_path', $tpl_dir);
		$AVE_Template->assign('formaction', 'index.php?do=modules&action=modedit&mod=contact&moduleaction=save&cp=' . SESSION . '&id=' . $_REQUEST['id'] . '&pop=1');
		$AVE_Template->assign('content', $AVE_Template->fetch($tpl_dir . 'admin_fields.tpl'));
	}

	/**
	 * Метод, предназначенный для сохранения изменений отредактированной формы в БД
	 *
	 * @param int $contact_form_id идентификатор формы
	 */
	function contactFormSave($contact_form_id)
	{
		global $AVE_DB;

		// Выполняем запрос к БД на обновление общих параметров для данной контактной формы
        $AVE_DB->Query("
			UPDATE " . PREFIX . "_modul_contacts
			SET
				contact_form_title            = '" . $_REQUEST['contact_form_title'] . "',
				contact_form_mail_max_chars   = '" . $_REQUEST['contact_form_mail_max_chars'] . "',
				contact_form_reciever         = '" . $_REQUEST['contact_form_reciever'] . "',
				contact_form_reciever_multi   = '" . $this->_contactRecieverMultiGet() . "',
				contact_form_antispam         = '" . $_REQUEST['contact_form_antispam'] . "',
				contact_form_max_upload       = '" . $_REQUEST['contact_form_max_upload'] . "',
				contact_form_subject_show     = '" . $_REQUEST['contact_form_subject_show'] . "',
				contact_form_subject_default  = '" . $_REQUEST['contact_form_subject_default'] . "',
				contact_form_allow_group      = '" . $this->_contactAllowGroupGet() . "',
				contact_form_message_noaccess = '" . $_POST['contact_form_message_noaccess'] . "',
				contact_form_send_copy        = '" . $_POST['contact_form_send_copy'] . "'
			WHERE
				Id = '" . $contact_form_id . "'
		");

		// Если в запросе пришел параметр на удаление каких-либо полей, тогда
        if (!empty($_POST['del']))
		{
			// Обрабатываем все поля, которые неоюходимо удалить
            foreach ($_POST['del'] as $id => $field)
			{
				// И выполняем запрос к БД на удаление
                $AVE_DB->Query("
					DELETE
					FROM " . PREFIX . "_modul_contact_fields
					WHERE Id = '" . $id . "'
				");
			}
		}

		// Обрабатываем все поля формы
        foreach ($_POST['contact_field_title'] as $id => $field)
		{
			// Если поле не пустое
            if (!empty($field))
			{
				// Убираем из названия поля некорректные символы
                $contact_field_title = $this->_contactTextClean($field);
				if (isset($_POST['contact_field_datatype'][$id]))
				{
					switch ($_POST['contact_field_datatype'][$id])
					{
						case 'anysymbol':
						case 'onlydecimal':
						case 'onlychars':
							break;

						default:
							$_POST['contact_field_datatype'][$id] = 'anysymbol';
							break;
					}
				}
				else
				{
					$_POST['contact_field_datatype'][$id] = 'anysymbol';
				}

                // Выполняем запрос к БД на обновление информации
                $AVE_DB->Query("
					UPDATE " . PREFIX . "_modul_contact_fields
					SET
						contact_field_title     = '" . $contact_field_title . "',
						contact_field_type      = '" . $_POST['contact_field_type'][$id] . "',
						contact_field_position  = '" . $_POST['contact_field_position'][$id] . "',
						contact_field_required  = '" . $_POST['contact_field_required'][$id] . "',
						contact_field_default   = '" . $this->_contactTextClean($_POST['contact_field_default'][$id]) . "',
						contact_field_status    = '" . (int)$_POST['contact_field_status'][$id] . "',
						contact_field_size      = '" . (int)$_POST['contact_field_size'][$id] . "',
						contact_field_newline   = '" . (int)$_POST['contact_field_newline'][$id] . "',
						contact_field_datatype  = '" . $_POST['contact_field_datatype'][$id] . "',
						contact_field_max_chars = '" . $this->_contactTextClean($_POST['contact_field_max_chars'][$id]) . "',
						contact_field_value     = '" . $this->_contactTextClean($_POST['contact_field_value'][$id]) . "'
					WHERE
						Id = '" . $id . "'
				");

				// Сохраняем системное сообщние
                reportLog($_SESSION['user_name'] . ' - отредактировал поле в модуле контакты id=' . $id . ' (' . $contact_field_title . ')', 2, 2);
			}
		}

		// Выполняем обновление страницы
        header('Location:index.php?do=modules&action=modedit&mod=contact&moduleaction=edit&id=' . $contact_form_id . '&pop=1&cp=' . SESSION);
        exit;
	}

	/**
	 * Метод, предназначенный для удаления контактной формы
	 *
	 * @param int $contact_form_id идентификатор формы
	 */
	function contactFormDelete($contact_form_id)
	{
		global $AVE_DB;

		// Выполняем запрос к БД на удаление общей информации о контактной форме
        $AVE_DB->Query("
			DELETE
			FROM " . PREFIX . "_modul_contacts
			WHERE Id = '" . $contact_form_id . "'
		");

        // Выполняем запрос к БД на удаление полей, относящихся к данной контактной форме
        $AVE_DB->Query("
			DELETE
			FROM " . PREFIX . "_modul_contact_fields
			WHERE contact_form_id = '" . $contact_form_id . "'
		");

        // Получаем список всех прикрепленных файлов у сообщений, относящихся к данной контактной форме
        $row = $AVE_DB->Query("
			SELECT
				contact_form_in_attachment,
				contact_form_out_attachment
			FROM " . PREFIX . "_modul_contact_info
			WHERE contact_form_id = '" . $contact_form_id . "'
		")->FetchRow();

		// Удаляем все прикрепленные сообщения из папки /attachments для входящих писем
        if ($row->contact_form_in_attachment != '')
		{
			$del = explode(';', $row->contact_form_in_attachment);
			foreach ($del as $delfile)
			{
				@unlink(BASE_DIR . '/attachments/' . $delfile);
			}
		}

        // Удаляем все прикрепленные сообщения из папки /attachments для исходящих писем
		if ($row->contact_form_out_attachment != '')
		{
			$del = explode(';', $row->contact_form_out_attachment);
			foreach ($del as $delfile)
			{
				@unlink(BASE_DIR . '/attachments/' . $delfile);
			}
		}

		// Удаляем все сообщения, относящиеся к данной контактной форме
        $AVE_DB->Query("
			DELETE
			FROM " . PREFIX . "_modul_contact_info
			WHERE contact_form_id = '" . $contact_form_id . "'
		");

		// Сохраняем системное сообщние
        reportLog($_SESSION['user_name'] . ' - удалил контактную форму (id=' . $contact_form_id . ')', 2, 2);

        // Выполняем обновление страницы
		header('Location:index.php?do=modules&action=modedit&mod=contact&moduleaction=1&cp=' . SESSION);
		exit;
	}

    /**
	 * Метод, предназначенный для просмотра сообщений отправленных пользователями.
     * Данный метод работает в двух режимах:
     * 1) Просмотр входящих или исходящих сообщений списком
     * 2) Полный просмотр любого сообщения
	 *
	 * @param string $tpl_dir путь к папке с шаблонами
	 * @param int $contact_form_id идентификатор формы
	 * @param string $newold сообщение без ответа new
	 */
	function contactMessageShow($tpl_dir, $contact_form_id, $newold = '')
	{
		global $AVE_DB, $AVE_Template;

		// Определяем, пришел ли запрос на полный просмотр сообщения
        switch($_REQUEST['sub'])
		{
			// Если нет, тогда
            case '':
				// Определяем условия просмотра (прочитанные или новые)
                $n_o     = ($newold == 'new') ? 'AND contact_form_out_date < 1' : 'AND contact_form_out_date > 1';
				$new_old = ($newold == 'new') ? 'showmessages_new' : 'showmessages_old';

				// Выполняем запрос к БД на получение списка сообщений согласно условиям
                $num = $AVE_DB->Query("
					SELECT COUNT(*)
					FROM " . PREFIX . "_modul_contact_info
					WHERE contact_form_id = '" . $contact_form_id . "'
					" . $n_o . "
				")->GetCell();

                // Формируем условия для выборки опредленного диапазона сообщений, в зависимости от
                // номера страницы при постраницной навигации
				$limit  = $this->_adminlimit;
				$seiten = ceil($num / $limit);
				$start  = get_current_page() * $limit - $limit;

				// Выполняем запрос к БД на получение сообщений с учетом всех условий выборки
                $items = array();
				$sql = $AVE_DB->Query("
					SELECT *
					FROM " . PREFIX . "_modul_contact_info
					WHERE contact_form_id = '" . $contact_form_id . "'
					" . $n_o . "
					ORDER BY contact_form_in_date DESC
					LIMIT " . $start . "," . $limit
				);
				while ($row = $sql->FetchRow())
				{
					array_push($items, $row);
				}
				$sql->Close();

				// Если количество сообщений превышает максимально-допустимый лимит на странице, тогла
                // формируем постраничную навигацию.
                if ($num > $limit)
				{
					$page_nav = " <a class=\"pnav\" href=\"index.php?do=modules&action=modedit&mod=contact&moduleaction=" . $new_old . "&cp=" . SESSION
						. "&page={s}&id=" . intval($_REQUEST['id']) . "\">{t}</a> ";
					$page_nav = get_pagination($seiten, 'page', $page_nav);
					$AVE_Template->assign('page_nav', $page_nav);
				}

                // Передаем данные в шаблон и выводим
                $AVE_Template->assign('items', $items);
				$AVE_Template->assign('content', $AVE_Template->fetch($tpl_dir . 'admin_messages.tpl'));
				break;

			// Если да
            case 'view':
				// Выполняем запрос к БД и получаем полную информацию о просматриваемом сообщении
                $row = $AVE_DB->Query("
					SELECT *
					FROM " . PREFIX . "_modul_contact_info
					WHERE Id = '" . $_REQUEST['id'] . "'
				")->FetchRow();

				$attachments = '';

				// Если сообщение имеет прикрепленные файлы, тогда получаем названия файлов
                if ($row->contact_form_in_attachment != '')
				{
					$attachments = array();
					$attachments_arr = explode(';', $row->contact_form_in_attachment);

					foreach ($attachments_arr as $attachment)
					{
						$row_a->name = $attachment;
						$row_a->size = round(filesize(BASE_DIR . '/attachments/' . $attachment)/1024 ,2);
						array_push($attachments, $row_a);
						$row_a = '';
					}
				}

                // Приводим текст сообщения к правильному формату и передаем в шаблон полученные данные
				$row->nl2brText = nl2br(stripslashes($row->contact_form_in_message));
				$row->replytext = $row->contact_form_in_message;
				$AVE_Template->assign('attachments', $attachments);
				$AVE_Template->assign('row', $row);

                // Отображаем данные
				$AVE_Template->assign('content', $AVE_Template->fetch($tpl_dir . 'admin_messageform.tpl'));
				break;
		}
	}

    /**
	 * Метод, предназначенный для отправки ответа на сообщение пользователя через Панель управления
	 *
	 */
	function contactMessageReply()
	{
		global $AVE_DB;

		// Подготавливаем прикрепленные файлы для отправки
        $attach = $this->_contactFileUpload(100000);
		$contact_form_out_attachment = (is_array($attach) && count($attach) >= 1) ? implode(';', $attach) : '';

		// Выполняем отправку сообщения
        send_mail(
			$_REQUEST['to'],
			stripslashes($_REQUEST['message']),
			$_REQUEST['subject'],
			$_REQUEST['fromemail'],
			$_POST['fromname'],
			'text',
			$attach
		);

        // Выполняем запрос к БД на обновление информации о отправленном сообщение
		$AVE_DB->Query("
			UPDATE " . PREFIX . "_modul_contact_info
			SET
				contact_form_out_date       = '" . time() . "',
				contact_form_out_email      = '" . $_REQUEST['fromemail'] . "',
				contact_form_out_sender     = '" . $_POST['fromname'] . "',
				contact_form_out_message    = '" . $_REQUEST['message'] . "',
				contact_form_out_attachment = '" . $contact_form_out_attachment . "'
			WHERE
				Id = '" . $_REQUEST['id'] . "'
		");

        // Закрываем окно и обновляем страницу
        echo '<script>window.opener.location.reload(); window.close();</script>';
	}

    /**
	 * Метод, предназначенный для скачивания прикреплённых к сообщению файлов
	 *
	 * @param file $file
	 */
	function contactAttachmentGet($file)
	{
		$file_ex = get_mime_type($file);
		header('Pragma: public');
		header('Expires: 0');
		header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
		header('Cache-Control: private', false);
		header('Content-Type: ' . $file_ex);
		header('Content-Disposition: attachment; filename=' . $file);
		header('Content-Transfer-Encoding: binary');
		header('Content-Length: ' . @filesize(BASE_DIR . '/attachments/' . $file));
		@set_time_limit(0);
		if (false === file_download(BASE_DIR . '/attachments/' . $file)) die('File not found.');
	}

    /**
	 * Метод, удаления прикреплённых файлов
	 *
	 */
	function contactAttachmentDelete()
	{
		global $AVE_DB;

        // Обрабатываем массив файлов, помеченных для удаления
		foreach ($_POST['del'] as $id => $del)
		{
			if ($this->_delfile == 1)
			{
				// Выполняем запрос к БД на получение информации о прикрепленных файлах для данной формы
                $row = $AVE_DB->Query("
					SELECT
						contact_form_in_attachment,
						contact_form_out_attachment
					FROM " . PREFIX . "_modul_contact_info
					WHERE Id = '" . $id . "'
				")->FetchRow();

				// Если полученные данные содержат информацию о прикрепленных файлах у входящих сообщений для данной формы
                if ($row->contact_form_in_attachment != '')
				{
					// Получаем список названий файлов и удаляем их из директории /attachments
                    $del = explode(';', $row->contact_form_in_attachment);
					foreach ($del as $delfile)
					{
						@unlink(BASE_DIR . '/attachments/' . $delfile);
					}
				}

				// Если полученные данные содержат информацию о прикрепленных файлах у исходящих сообщений для данной формы
                if ($row->contact_form_out_attachment != '')
				{

                    // Получаем список названий файлов и удаляем их из директории /attachments
                    $del = explode(';', $row->contact_form_out_attachment);
					foreach ($del as $delfile)
					{
						@unlink(BASE_DIR . '/attachments/' . $delfile);
					}
				}
			}

            // Выполняем запрос к БД на удаление информации об этих файлах
            $AVE_DB->Query("
				DELETE
				FROM " . PREFIX . "_modul_contact_info
				WHERE Id = '" . $id . "'
			");
		}

        // Выполняем обновление страницы
        header('Location:index.php?do=modules&action=modedit&mod=contact&moduleaction=1&cp=' . SESSION);
		exit;
	}
}

?>