<?php

/**
 * Класс, включающий все свойства и методы для управления контактными формами и сообщениями
 * как в Публичной части сайта, так и в Панели управления.
 *
 * @package AVE.cms
 * @subpackage module_Contact
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
 *	Внутренние методы класса
 */

	/**
	 * Метод, предназначенный для удаление из текста непечатаемых символов
	 *
	 * @param string $code обрабатываемый текст
	 * @return string обработанный текст
	 */
	function _replace_wildcode($code)
	{
		$code = preg_replace('/[^\x20-\xFF]/', '', $code);
//		$code = htmlspecialchars($code);

		return $code;
	}

	/**
	 * Метод, предназначенный для вывода сообщения об успешной отправке формы
	 *
	 * @param string $tpl_dir путь к папке с шаблонами
	 * @param string $lang_file путь к языковому файлу
	 */
	function _thankyou($tpl_dir, $lang_file)
	{
		global $AVE_DB, $AVE_Template;

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
	function _renameFile($file)
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
	function _uploadFile($maxupload = '0')
	{
		global $_FILES;

		$attach = '';
		define('UPDIR', BASE_DIR . '/attachments/');

        // Если в сообщение были прикреплены файлы, тогда циклически
        // обрабатываем каждый из них, приводя название файла к нижнему регистру,
        // убирая из имени пробелы, и, если файл с таким именем уже существует, тогда
        // генерируем новое название и заменям текущее. Также, в данном методе происходит проверка
        // намаксимально-допустимый размер файла.

        if (isset($_FILES['upfile']) && is_array($_FILES['upfile']))
		{
			for ($i=0; $i<count($_FILES['upfile']['tmp_name']); $i++)
			{
				if ($_FILES['upfile']['tmp_name'][$i] != '')
				{
					$d_name = strtolower(ltrim(rtrim($_FILES['upfile']['name'][$i])));
					$d_name = str_replace(' ', '', $d_name);
					$d_tmp = $_FILES['upfile']['tmp_name'][$i];

					$fz = filesize($_FILES['upfile']['tmp_name'][$i]);
					$mz = $maxupload*1024;;

					if ($mz >= $fz)
					{
						if (file_exists(UPDIR . $d_name))
						{
							$d_name = $this->_renameFile($d_name);
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
 *	Внешние методы класса
 */

	/**
	 * Метод, предназначенный для вывода контактной формы в публичной части сайта
	 *
	 * @param string $tpl_dir путь к папке с шаблонами
	 * @param string $lang_file путь к языковому файлу
	 * @param int $id идентификатор формы
	 * @param int $im идентификатор защитного кода
	 * @param int $maxupload максимальный размер прикреплённого файла
	 * @param int $fetch вывод в браузер 1
	 * @return string контактная форма
	 */
	function fetchForm($tpl_dir, $lang_file, $id, $im = '', $maxupload = '0', $fetch = '0')
	{
		global $AVE_DB, $AVE_Template;

        $id = preg_replace('/\D/', '', $id);

		$AVE_Template->config_load($lang_file);

        // Получаем всю информацию о данной форме по ее Id
		$row = $AVE_DB->Query("
			SELECT *
			FROM " . PREFIX . "_modul_contacts
			WHERE Id = '" . $id . "'
		")->FetchRow();

        // Определяем группы, которым разрешен доступ к данной контактной форме
        @$AllowedGroups = explode(',', $row->form_allow_group);

        // Если группа пользователя не входит в разрешенный список групп, фиксируем ошибку и
        // выводим сообщение.
        if (!in_array($_SESSION['user_group'], $AllowedGroups))
        {
            $AVE_Template->assign('no_access', 1);
            $AVE_Template->assign('form_message_noaccess', $row->form_message_noaccess);
        }
        // В противном случае
        else
        {
            // Определяем ряд переменных для использования в шаблоне
            $AVE_Template->assign('im', $row->form_antispam);
            $AVE_Template->assign('form_id', $id);
            $AVE_Template->assign('maxupload', $row->form_max_upload);
            $AVE_Template->assign('send_copy', $row->form_send_copy);

		    $receiver = '';
		    // Формируем список получателей данного сообщения (если их несколько)
            if ($row->form_receiver_multi != '')
		    {
			    $receiver = array();
			    $e = explode(';', $row->form_receiver_multi);
			    foreach ($e as $em)
			    {
				    $e_name = explode(',', $em);
				    $receiver[] = $e_name[0];
				    $em = '';
			    }
		    }
		    $AVE_Template->assign('receiver', $receiver);

            // Если тема сообщения не указана, тогда используем название темы по умолчанию
            if ($row->form_show_subject == '0' && $row->form_default_subject != '')
		    {
			    $AVE_Template->assign('default_subject', $row->form_default_subject);
		    }

		    // Выполняем запрос к БД на получение списка всех полей формы
            $fields = array();
		    $sql = $AVE_DB->Query("
			    SELECT *
			    FROM " . PREFIX . "_modul_contact_fields
			    WHERE field_status = '1'
			    AND form_id = '" . $id . "'
			    ORDER BY field_position ASC
		    ");
		    while ($row = $sql->FetchRow())
		    {
			    // Определяем тип поля и преобразуем данные к установленному типу
                switch ($row->field_datatype)
			    {
				    // Любые символы
                    case 'anysymbol':
					    $row->field_pattern = $row->field_maxchars != '' ? ('^([\s\S]{' . $row->field_maxchars . '})' . ($row->field_required != 1 ? '?$' : '{1}$')) : '';
					    break;

				    // Только целые числа
                    case 'onlydecimal':
					    $row->field_pattern = $row->field_maxchars != '' ? ('^(\d{' . $row->field_maxchars . '})' . ($row->field_required != 1 ? '?$' : '{1}$')) : '';
					    break;

				    // Только буквы
                    case 'onlychars':
					    $row->field_pattern = $row->field_maxchars != '' ? ('^(\D{' . $row->field_maxchars . '})' . ($row->field_required != 1 ? '?$' : '{1}$')) : '';
					    break;

				    // По умолчанию любые символы
                    default:
					    $row->field_pattern = $row->field_maxchars != '' ? ('^([\s\S]{' . $row->field_maxchars . '})' . ($row->field_required != 1 ? '?$' : '{1}$')) : '';
					    break;
			    }

                // Если тип поля "Выпадающий список", тогда получем все его элементы
                if ($row->field_type == 'dropdown' && $row->field_default != '')
			    {
				    $value = explode(',', $row->field_default);
				    $row->field_default = $value;
			    }

			    // Если в название поля присутствуют пробелы, убираем их и формируем окончательный массив данных полей
                $field_title = $_REQUEST[str_replace(' ', '_', $row->field_title)];
			    $row->value = isset($field_title) ? $field_title : '';
			    array_push($fields, $row);
		    }

            // Перердаем в шаблон полученный массив с данными и формируем ссылку для редиректа после отправки
            $AVE_Template->assign('fields', $fields);
		    $action = rewrite_link('index.php?id=' . $AVE_Core->curentdoc->Id . '&amp;doc=' . (empty($AVE_Core->curentdoc->Url) ? prepare_url($AVE_Core->curentdoc->Titel) : $AVE_Core->curentdoc->Url));
		    $AVE_Template->assign('contact_action', $action);
		}

		// Отображаем контактную форму
        if ($fetch == 1)
		{
			return $AVE_Template->fetch($tpl_dir . 'form.tpl');
		}
		else
		{
			$AVE_Template->display($tpl_dir . 'form.tpl');
		}
	}

	/**
	 * Метод, предназначенный для отправки контактной формы с функцией защиты от спама
	 *
	 * @param string $tpl_dir путь к папке с шаблонами
	 * @param string $lang_file путь к языковому файлу
	 * @param int $id идентификатор формы
	 * @param int $secure защита от спама 1
	 * @param int $maxupload максимальный размер прикреплённого файла
	 */
	function sendSecure($tpl_dir, $lang_file, $id, $secure = '0', $maxupload = '0')
	{
		global $AVE_DB, $AVE_Template;

        // Получаем всю информацию из БД о контактной форме
        $row = $AVE_DB->Query("
            SELECT *
            FROM " . PREFIX . "_modul_contacts
            WHERE Id = '" . $id . "'
        ")->FetchRow();

		// Если для данной формы используется защитный код, тогда
        if ($row->form_antispam == 1)
		{
            // Проверяем, правильно ли он указан пользователем
            if (! (isset($_SESSION['captcha_keystring']) && isset($_POST['securecode'])
                && $_SESSION['captcha_keystring'] == $_POST['securecode']))
			{
				// Если нет, фиксируем ошибку и снова показываем форму
                $AVE_Template->assign('wrong_securecode', 1);
                $this->fetchForm($tpl_dir, $lang_file, $id);
                unset($_SESSION['captcha_keystring']);
                return;
			}
            unset($_SESSION['captcha_keystring']);
		}

        $AVE_Template->config_load($lang_file);
        $config_vars = $AVE_Template->get_config_vars();

		// Если получателей несколько, тогда
        if (!empty($_REQUEST['reciever']))
		{
			// Формируем список получателей
            $_REQUEST['reciever'] = $_REQUEST['reciever']-1;
			$arr = explode(';', $row->form_receiver_multi);
			$i = 0;

			while (list(, $value) = each($arr))
			{
				$tom = explode(',', $value);
				$multi_e[$i]['email'] = $tom[1];
				if ($i == $_REQUEST['reciever'])
				{
					$row->form_receiver = $multi_e[$i]['email'];
				}
				$i++;
			}
		}

		// Обрабатываем прикрепленные файлы
        $attach = $this->_uploadFile($maxupload);
		@reset($_POST);
		$newtext = '';
        $skip_keys = array(
            'contact_action',
            'sendcopy',
            'reciever',
            'form_num',
            'form_id',
            'secure_image_id',
            'action',
            'modules',
            'securecode'
        );

		while (list($key, $val) = each($_POST))
		{
			if (!empty($val) && !in_array($key, $skip_keys))
			{
				$key = ($key == 'in_subject' || $key == 'in_email')
                    ? $config_vars['CONTACT_' . strtoupper($key)]
                    : $key;
				$newtext .= str_replace('_', ' ', $key) . ':  ' . $val . "\n\n";
			}
		}
		$text = strip_tags($newtext);
		$in_attachment = (is_array($attach) && count($attach) >= 1) ? implode(';', $attach) : '';

		// Отправляем сообщение получателям с учетом прикрепленных файлов
        send_mail(
			$row->form_receiver,
			stripslashes(substr($text, 0, $row->form_mail_max_chars)),
			$_POST['in_subject'],
			$_POST['in_email'],
			$_POST['in_email'],
			'text',
			$attach
		);


        // Если в настройках модуля указана отправка копии сообщения, тогда выполняем отправку копии на
        // e-mail, указанный в общих настройках системы
        if (isset($_REQUEST['sendcopy']) && $_REQUEST['sendcopy'] == 1)
		{
			$mail_from = get_settings('mail_from');
			$mail_from_name = get_settings('mail_from_name');
			send_mail(
				$_POST['in_email'],
				$config_vars['CONTACT_TEXT_THANKYOU'] . "\n\n" . stripslashes(substr($text, 0, $row->form_mail_max_chars)),
				$_POST['in_subject'] . ' ' . $config_vars['CONTACT_SUBJECT_COPY'],
				$mail_from,
				$mail_from_name,
				'text',
				''
			);
		}

		// Добавляем в БД запись об отправленном сообщении
        $AVE_DB->Query("
			INSERT
			INTO " . PREFIX . "_modul_contact_info
			SET
                form_id       = '" . (int)$_REQUEST['form_id'] . "',
				in_email      = '" . $_POST['in_email'] . "',
				in_date       = '" . time() . "',
				in_subject    = '" . $_POST['in_subject'] . "',
				in_message    = '" . stripslashes(substr($text, 0, $row->form_mail_max_chars)) . "',
				in_attachment = '" . $in_attachment . "'
		");

        // Отображаем шаблон с "Благодарностью"
        $this->_thankyou($tpl_dir, $lang_file);
	}


    /**
	 * Метод, предназначенный для вывода списка всех контактных форм в Панели управления
	 *
	 * @param string $tpl_dir путь к папке с шаблонами
	 */
	function showForms($tpl_dir)
	{
		global $AVE_DB, $AVE_Template;

		// Получаем общее количество контактных форм в системе
        $num = $AVE_DB->Query("SELECT COUNT(*) FROM " . PREFIX . "_modul_contacts")->GetCell();

		// Определяем количество страниц для постраничной навигации
        $limit  = $this->_adminlimit;
		$seiten = ceil($num / $limit);
		$start  = get_current_page() * $limit - $limit;

		// Получаем информацию о контактных формах, а также о количестве прочитанных и непрочитанных сообщений
        // для каждой из форм.
        $items = array();
		$sql = $AVE_DB->Query("
            SELECT
                frm.*,
                SUM(IF(out_date>0,1,0)) AS messages_new,
                SUM(IF(out_date=0,1,0)) AS messages
            FROM
            	" . PREFIX . "_modul_contacts AS frm
            LEFT OUTER JOIN
            	" . PREFIX . "_modul_contact_info
                	ON form_id = frm.Id
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
			$page_nav = " <a class=\"pnav\" href=\"index.php?do=modules&action=modedit&mod=contact&moduleaction=1&cp=" . SESSION . "&page={s}\">{t}</a> ";
			$page_nav = get_pagination($seiten, 'page', $page_nav);
			$AVE_Template->assign('page_nav', $page_nav);
		}

        // Передаем данные в шаблон и отображаем страницу
        $AVE_Template->assign('items', $items);
		$AVE_Template->assign('content', $AVE_Template->fetch($tpl_dir . 'admin_forms.tpl'));
	}



    /**
	 * Метод, предназначенный для редактирование формы в Панели управления
	 *
	 * @param string $tpl_dir путь к папке с шаблонами
	 * @param int $id идентификатор формы
	 */
	function editForms($tpl_dir, $id)
	{
		global $AVE_DB, $AVE_Template;

		// Получаем общую информацию о контактной форме, которую мы хотим отредактировать
        $row_e = $AVE_DB->Query("
			SELECT *
			FROM " . PREFIX . "_modul_contacts
			WHERE Id = '" . $id . "'
		")->FetchRow();

		// Получаем всю информацию о полях формы, которую мы хотим отредактировать
        $items = array();
		$sql = $AVE_DB->Query("
			SELECT *
			FROM " . PREFIX . "_modul_contact_fields
			WHERE form_id = '" . $id . "'
			ORDER BY field_position ASC
		");
		while ($row = $sql->FetchRow())
		{
			array_push($items,$row);
		}


        // Получаем список групп пользователей в системе
        $Groups = array();
		$sql_g = $AVE_DB->Query("
			SELECT
				Benutzergruppe,
				Name
			FROM " . PREFIX . "_user_groups
		");
		while ($row_g = $sql_g->FetchRow())
		{
			array_push($Groups, $row_g);
		}

		// Передаем в шаблон полученные данные и отображаем страницу
        $AVE_Template->assign('groups', $Groups);
		$AVE_Template->assign('groups_form', explode(',', $row_e->form_allow_group));
		$AVE_Template->assign('row', $row_e);
		$AVE_Template->assign('items', $items);
		$AVE_Template->assign('tpl_dir', $tpl_dir);
		$AVE_Template->assign('formaction', 'index.php?do=modules&action=modedit&mod=contact&moduleaction=save&cp=' . SESSION . '&id=' . $_REQUEST['id'] . '&pop=1');
		$AVE_Template->assign('content', $AVE_Template->fetch($tpl_dir . 'admin_fields.tpl'));
	}

	/**
	 * Метод, предназначенный для сохранения изменений отредактированной формы в БД
	 *
	 * @param int $id идентификатор формы
	 */
	function saveForms($id)
	{
		global $AVE_DB;

		// Выполняем запрос к БД на обновление общих параметров для данной контактной формы
        $AVE_DB->Query("
			UPDATE " . PREFIX . "_modul_contacts
			SET
				form_name             = '" . $_REQUEST['form_name'] . "',
				form_mail_max_chars   = '" . $_REQUEST['form_mail_max_chars'] . "',
				form_receiver         = '" . $_REQUEST['form_receiver'] . "',
				form_receiver_multi   = '" . $_REQUEST['form_receiver_multi'] . "',
				form_antispam         = '" . $_REQUEST['form_antispam'] . "',
				form_max_upload       = '" . $_REQUEST['form_max_upload'] . "',
				form_show_subject     = '" . $_REQUEST['form_show_subject'] . "',
				form_default_subject  = '" . $_REQUEST['form_default_subject'] . "',
				form_allow_group      = '" . @implode(',', $_REQUEST['form_allow_group']) . "',
				form_message_noaccess = '" . $_POST['form_message_noaccess'] . "',
				form_send_copy        = '" . $_POST['form_send_copy'] . "'
			WHERE
				Id = '" . $id . "'
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
        foreach ($_POST['field_title'] as $id => $field)
		{
			// Если поле не пустое
            if (!empty($field))
			{
				// Убираем из названия поля некорректные символы
                $field_title = $this->_replace_wildcode($field);
				if (isset($_POST['field_datatype'][$id]))
				{
					switch ($_POST['field_datatype'][$id])
					{
						case 'anysymbol':
						case 'onlydecimal':
						case 'onlychars':
							break;

						default:
							$_POST['field_datatype'][$id] = 'anysymbol';
							break;
					}
				}
				else
				{
					$_POST['field_datatype'][$id] = 'anysymbol';
				}

                // Выполняем запрос к БД на обновление информации
                $AVE_DB->Query("
					UPDATE " . PREFIX . "_modul_contact_fields
					SET
						field_title    = '" . $field_title . "',
						field_type     = '" . $_POST['field_type'][$id] . "',
						field_position = '" . $_POST['field_position'][$id] . "',
						field_required = '" . $_POST['field_required'][$id] . "',
						field_default  = '" . $this->_replace_wildcode($_POST['field_default'][$id]) . "',
						field_status   = '" . (int)$_POST['field_status'][$id] . "',
						field_size     = '" . (int)$_POST['field_size'][$id] . "',
						field_newline  = '" . (int)$_POST['field_newline'][$id] . "',
						field_datatype = '" . $_POST['field_datatype'][$id] . "',
						field_maxchars = '" . $this->_replace_wildcode($_POST['field_maxchars'][$id]) . "',
						field_message  = '" . $this->_replace_wildcode($_POST['field_message'][$id]) . "'
					WHERE
						Id = '" . $id . "'
				");
				// Сохраняем системное сообщние
                reportLog($_SESSION['user_name'] . ' - отредактировал поле в модуле контакты (' . $field_title . ')', 2, 2);
			}
		}
		// Выполняем обновление страницы
        header('Location:index.php?do=modules&action=modedit&mod=contact&moduleaction=edit&id=' . $_REQUEST['id'] . '&pop=1&cp=' . SESSION);
	}

	/**
	 * Метод, предназначенный для добавления новой формы в БД
	 *
	 * @param int $id идентификатор формы
	 */
	function saveFormsNew($id)
	{
		global $AVE_DB;

        // Обрабатываем все поля формы (если они были созданы)
		if (!empty($_POST['field_title']))
		{
			// Убираем из названия поля некорректные символы
            $field_title = $this->_replace_wildcode($_REQUEST['field_title']);
			if (isset($_REQUEST['field_datatype']))
			{
				switch ($_REQUEST['field_datatype'])
				{
					case 'anysymbol':
					case 'onlydecimal':
					case 'onlychars':
						break;

					default:
						$_REQUEST['field_datatype'] = 'anysymbol';
						break;
				}
			}
			else
			{
				$_REQUEST['field_datatype'] = 'anysymbol';
			}

            // Выполняем запрок к БД на добавление новых полей в форму
            $AVE_DB->Query("
				INSERT
				INTO " . PREFIX . "_modul_contact_fields
				SET
					Id             = '',
					form_id        = '" . $id . "',
					field_type     = '" . $_REQUEST['field_type'] . "',
					field_position = '" . $_REQUEST['field_position'] . "',
					field_title    = '" . $field_title . "',
					field_required = '" . $_REQUEST['field_required'] . "',
					field_default  = '" . $this->_replace_wildcode($_REQUEST['field_default']) . "',
					field_status   = '" . $_REQUEST['field_status'] . "',
					field_size     = '" . (int)$_REQUEST['field_size'] . "',
					field_newline  = '" . (int)$_REQUEST['field_newline'] . "',
					field_datatype = '" . $_REQUEST['field_datatype'] . "',
					field_maxchars = '" . $this->_replace_wildcode($_REQUEST['field_maxchars']) . "',
					field_message  = '" . $this->_replace_wildcode($_REQUEST['field_message']) . "'
			");
		}

		// Сохраняем системное сообщние
        reportLog($_SESSION['user_name'] . ' - добавил новое поле в модуле контакты (' . $field_title . ')', 2, 2);

        // Выполняем обновление страницы
		header('Location:index.php?do=modules&action=modedit&mod=contact&moduleaction=edit&id=' . $_REQUEST['id'] . '&pop=1&cp=' . SESSION);
	}

	/**
	 * Метод, предназначенный для создание новой формы
	 *
	 * @param string $tpl_dir путь к папке с шаблонами
	 */
	function newForms($tpl_dir)
	{
		global $AVE_DB, $AVE_Template;


        // Определяем, пришел ли запрос на сохранение данных
        switch($_REQUEST['sub'])
		{
			// Если нет
            case '':
				// Получаем список групп пользователей в системе
                $Groups = array();
				$sql_g = $AVE_DB->Query("
					SELECT
						Benutzergruppe,
						Name
					FROM " . PREFIX . "_user_groups
				");
				while ($row_g = $sql_g->FetchRow())
				{
					array_push($Groups, $row_g);
				}

				// Формируем ряд переменных и передаем их в шаблон
                $AVE_Template->assign('groups', $Groups);
				$AVE_Template->assign('tpl_dir', $tpl_dir);
				$AVE_Template->assign('formaction', 'index.php?do=modules&action=modedit&mod=contact&moduleaction=new&sub=save&cp=' . SESSION . '&pop=1');

                // Отображаем страницу с новой формой
                $AVE_Template->assign('content', $AVE_Template->fetch($tpl_dir . 'admin_fields.tpl'));
				break;

			// Если да
            case 'save':

                // Выполняем запрос к БД на добавление новой формы
                $AVE_DB->Query("
					INSERT
					INTO " . PREFIX . "_modul_contacts
					SET
						Id                    = '',
						form_name             = '" . $_REQUEST['form_name'] . "',
						form_mail_max_chars   = '" . $_REQUEST['form_mail_max_chars'] . "',
						form_receiver         = '" . $_REQUEST['form_receiver'] . "',
						form_receiver_multi   = '" . $_REQUEST['form_receiver_multi'] . "',
						form_antispam         = '" . $_REQUEST['form_antispam'] . "',
						form_max_upload       = '" . $_REQUEST['form_max_upload'] . "',
						form_allow_group      = '" . @implode(',', $_REQUEST['form_allow_group']) . "',
						form_message_noaccess = '" . $_REQUEST['form_message_noaccess'] . "',
						form_send_copy        = '" . $_REQUEST['form_send_copy'] . "'
				");
				$iid = $AVE_DB->InsertId();

                // Сохраняем системное сообщние
				reportLog($_SESSION['user_name'] . ' - добавил новую контактную форму (' . stripslashes($_REQUEST['form_name']) . ')', 2, 2);

                // Выполняем обновление страницы
				header('Location:index.php?do=modules&action=modedit&mod=contact&moduleaction=edit&id=' . $iid . '&pop=1&cp=' . SESSION);
				exit;
				break;
		}
	}

	/**
	 * Метод, предназначенный для удаления контактной формы
	 *
	 * @param int $id идентификатор формы
	 */
	function deleteForms($id)
	{
		global $AVE_DB;

		// Выполняем запрос к БД на удаление общей информации о контактной форме
        $AVE_DB->Query("
			DELETE
			FROM " . PREFIX . "_modul_contacts
			WHERE Id = '" . $id . "'
		");

        // Выполняем запрос к БД на удаление полей, относящихся к данной контактной форме
        $AVE_DB->Query("
			DELETE
			FROM " . PREFIX . "_modul_contact_fields
			WHERE form_id = '" . $id . "'
		");


        // Получаем список всех прикрепленных файлов у сообщений, относящихся к данной контактной форме
        $row = $AVE_DB->Query("
			SELECT
				in_attachment,
				out_attachment
			FROM " . PREFIX . "_modul_contact_info
			WHERE form_id = '" . $id . "'
		")->FetchRow();

		// Удаляем все прикрепленные сообщения из папки /attachments для входящих писем
        if ($row->in_attachment != '')
		{
			$del = explode(';', $row->in_attachment);
			foreach ($del as $delfile)
			{
				@unlink(BASE_DIR . '/attachments/' . $delfile);
			}
		}

        // Удаляем все прикрепленные сообщения из папки /attachments для исходящих писем
		if ($row->out_attachment != '')
		{
			$del = explode(';', $row->out_attachment);
			foreach ($del as $delfile)
			{
				@unlink(BASE_DIR . '/attachments/' . $delfile);
			}
		}

		// Удаляем все сообщения, относящиеся к данной контактной форме
        $AVE_DB->Query("
			DELETE
			FROM " . PREFIX . "_modul_contact_info
			WHERE form_id = '" . $id . "'
		");

		// Сохраняем системное сообщние
        reportLog($_SESSION['user_name'] . ' - удалил контактную форму (' . $id . ')', 2, 2);

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
	 * @param int $id идентификатор формы
	 * @param string $newold сообщение без ответа new
	 */
	function showMessages($tpl_dir, $id, $newold = '')
	{
		global $AVE_DB, $AVE_Template;

		// Определяем, пришел ли запрос на полный просмотр сообщения
        switch($_REQUEST['sub'])
		{
			// Если нет, тогда
            case '':
				// Определяем условия просмотра (прочитанные или новые)
                $n_o     = ($newold == 'new') ? 'AND out_date < 1' : 'AND out_date > 1';
				$new_old = ($newold == 'new') ? 'showmessages_new' : 'showmessages_old';

				// Выполняем запрос к БД на получение списка сообщений согласно условиям
                $num = $AVE_DB->Query("
					SELECT COUNT(*)
					FROM " . PREFIX . "_modul_contact_info
					WHERE form_id = '" . $id . "'
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
					WHERE form_id = '" . $id . "'
					" . $n_o . "
					ORDER BY in_date DESC
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
                if ($row->in_attachment != '')
				{
					$attachments = array();
					$attachments_arr = explode(';', $row->in_attachment);

					foreach ($attachments_arr as $attachment)
					{
						$row_a->name = $attachment;
						$row_a->size = round(filesize(BASE_DIR . '/attachments/' . $attachment)/1024 ,2);
						array_push($attachments, $row_a);
						$row_a = '';
					}
				}

                // Приводим текст сообщения к правильному формату и передаем в шаблон полученные данные
				$row->nl2brText = nl2br(stripslashes($row->in_message));
				$row->replytext = $row->in_message;
				$AVE_Template->assign('attachments', $attachments);
				$AVE_Template->assign('row', $row);

                // Отображаем данные
				$AVE_Template->assign('content', $AVE_Template->fetch($tpl_dir . 'admin_messageform.tpl'));
				break;
		}
	}



    /**
	 * Метод, предназначенный для сохранения прикреплённых файлов на жесткий диск
	 *
	 * @param file $file
	 */
	function getAttachment($file)
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
		@file_download(BASE_DIR . '/attachments/' . $file) or die('File not found. ');
	}



    /**
	 * Метод, предназначенный для отправки ответа на сообщение пользователя через Панель управления
	 *
	 */
	function replyMessage()
	{
		global $AVE_DB;

		// Подготавливаем прикрепленные файлы для отправки
        $attach = $this->_uploadFile(100000);
		$out_attachment = (is_array($attach) && count($attach) >= 1) ? implode(';', $attach) : '';

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

        // Выполняем запрос к БД на обновление информации об отправленном сообщение
		$AVE_DB->Query("UPDATE " . PREFIX . "_modul_contact_info
			SET
				out_date     = '" . time() . "',
				out_email    = '" . $_REQUEST['fromemail'] . "',
				out_sender = '" . $_POST['fromname'] . "',
				out_message     = '" . $_REQUEST['message'] . "',
				out_attachment   = '" . $out_attachment . "'
			WHERE
				Id          = '" . $_REQUEST['id'] . "'
		");

        // Закрываем окно и обновляем страницу
        echo '<script>window.opener.location.reload(); window.close();</script>';
	}


    /**
	 * Метод, предназначенный для управления прикреплёнными файлами (удаление)
	 *
	 */
	function quickSave()
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
						in_attachment,
						out_attachment
					FROM " . PREFIX . "_modul_contact_info
					WHERE Id = '" . $id . "'
				")->FetchRow();

				// Если полученные данные содержат информацию о прикрепленных файлах у входящих сообщений для данной формы
                if ($row->in_attachment != '')
				{
					// Получаем список названий файлов и удаляем их из директории /attachments
                    $del = explode(';', $row->in_attachment);
					foreach ($del as $delfile)
					{
						@unlink(BASE_DIR . '/attachments/' . $delfile);
					}
				}

				// Если полученные данные содержат информацию о прикрепленных файлах у исходящих сообщений для данной формы
                if ($row->out_attachment != '')
				{

                    // Получаем список названий файлов и удаляем их из директории /attachments
                    $del = explode(';', $row->out_attachment);
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