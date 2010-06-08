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
 *	СВОЙСТВА
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
 *	ВНУТРЕННИЕ МЕТОДЫ
 */

	/**
	 * Удаление из текста непечатаемых символов
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
	 * Вывод сообщения об успешной отправке формы
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
	 * Формирование уникального имени файла
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
	 * Запись прикреплённых файлов в папку /attachments
	 *
	 * @param int $maxupload максимальный размер прикреплённых файлов
	 * @return string путь к файлу в хранилище (/attachments)
	 */
	function _uploadFile($maxupload = '0')
	{
		global $_FILES;

		$attach = '';
		define('UPDIR', BASE_DIR . '/attachments/');
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
 *	ВНЕШНИЕ МЕТОДЫ
 */

	/**
	 * Вывод формы в публичной части сайта
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

		$row = $AVE_DB->Query("
			SELECT *
			FROM " . PREFIX . "_modul_contacts
			WHERE Id = '" . $id . "'
		")->FetchRow();

        @$AllowedGroups = explode(',', $row->form_allow_group);
        if (!in_array($_SESSION['user_group'], $AllowedGroups))
        {
            $AVE_Template->assign('no_access', 1);
            $AVE_Template->assign('form_message_noaccess', $row->form_message_noaccess);
        }
        else
        {
            $AVE_Template->assign('im', $row->form_antispam);
            $AVE_Template->assign('form_id', $id);
            $AVE_Template->assign('maxupload', $row->form_max_upload);
            $AVE_Template->assign('send_copy', $row->form_send_copy);

		    $receiver = '';
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

            if ($row->form_show_subject == '0' && $row->form_default_subject != '')
		    {
			    $AVE_Template->assign('default_subject', $row->form_default_subject);
		    }

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
			    switch ($row->field_datatype)
			    {
				    case 'anysymbol':
					    $row->field_pattern = $row->field_maxchars != '' ? ('^([\s\S]{' . $row->field_maxchars . '})' . ($row->field_required != 1 ? '?$' : '{1}$')) : '';
					    break;

				    case 'onlydecimal':
					    $row->field_pattern = $row->field_maxchars != '' ? ('^(\d{' . $row->field_maxchars . '})' . ($row->field_required != 1 ? '?$' : '{1}$')) : '';
					    break;

				    case 'onlychars':
					    $row->field_pattern = $row->field_maxchars != '' ? ('^(\D{' . $row->field_maxchars . '})' . ($row->field_required != 1 ? '?$' : '{1}$')) : '';
					    break;

				    default:
					    $row->field_pattern = $row->field_maxchars != '' ? ('^([\s\S]{' . $row->field_maxchars . '})' . ($row->field_required != 1 ? '?$' : '{1}$')) : '';
					    break;
			    }
			    if ($row->field_type == 'dropdown' && $row->field_default != '')
			    {
				    $value = explode(',', $row->field_default);
				    $row->field_default = $value;
			    }

			    $field_title = $_REQUEST[str_replace(' ', '_', $row->field_title)];
			    $row->value = isset($field_title) ? $field_title : '';
			    array_push($fields, $row);
		    }

            $AVE_Template->assign('fields', $fields);
		    $action = rewrite_link('index.php?id=' . $AVE_Core->curentdoc->Id . '&amp;doc=' . (empty($AVE_Core->curentdoc->Url) ? prepare_url($AVE_Core->curentdoc->Titel) : $AVE_Core->curentdoc->Url));
		    $AVE_Template->assign('contact_action', $action);
		}

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
	 * Получение данных из формы с защитой от спама
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

        $row = $AVE_DB->Query("
            SELECT *
            FROM " . PREFIX . "_modul_contacts
            WHERE Id = '" . $id . "'
        ")->FetchRow();

		if ($row->form_antispam == 1)
		{
            if (! (isset($_SESSION['captcha_keystring']) && isset($_POST['securecode'])
                && $_SESSION['captcha_keystring'] == $_POST['securecode']))
			{
				$AVE_Template->assign('wrong_securecode', 1);
                $this->fetchForm($tpl_dir, $lang_file, $id);
                unset($_SESSION['captcha_keystring']);
                return;
			}
            unset($_SESSION['captcha_keystring']);
		}

        $AVE_Template->config_load($lang_file);
        $config_vars = $AVE_Template->get_config_vars();

		if (!empty($_REQUEST['reciever']))
		{
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

		send_mail(
			$row->form_receiver,
			stripslashes(substr($text, 0, $row->form_mail_max_chars)),
			$_POST['in_subject'],
			$_POST['in_email'],
			$_POST['in_email'],
			'text',
			$attach
		);

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

        $this->_thankyou($tpl_dir, $lang_file);
	}

	/**
	 * Формирование формы для административной части
	 *
	 * @param string $tpl_dir путь к папке с шаблонами
	 */
	function showForms($tpl_dir)
	{
		global $AVE_DB, $AVE_Template;

		$num = $AVE_DB->Query("SELECT COUNT(*) FROM " . PREFIX . "_modul_contacts")->GetCell();

		$limit  = $this->_adminlimit;
		$seiten = ceil($num / $limit);
		$start  = get_current_page() * $limit - $limit;

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

		if ($num > $limit)
		{
			$page_nav = " <a class=\"pnav\" href=\"index.php?do=modules&action=modedit&mod=contact&moduleaction=1&cp=" . SESSION . "&page={s}\">{t}</a> ";
			$page_nav = get_pagination($seiten, 'page', $page_nav);
			$AVE_Template->assign('page_nav', $page_nav);
		}
		$AVE_Template->assign('items', $items);
		$AVE_Template->assign('content', $AVE_Template->fetch($tpl_dir . 'admin_forms.tpl'));
	}

	/**
	 * Редактирование формы в административной части
	 *
	 * @param string $tpl_dir путь к папке с шаблонами
	 * @param int $id идентификатор формы
	 */
	function editForms($tpl_dir, $id)
	{
		global $AVE_DB, $AVE_Template;

		$row_e = $AVE_DB->Query("
			SELECT *
			FROM " . PREFIX . "_modul_contacts
			WHERE Id = '" . $id . "'
		")->FetchRow();

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

		$AVE_Template->assign('groups', $Groups);
		$AVE_Template->assign('groups_form', explode(',', $row_e->form_allow_group));
		$AVE_Template->assign('row', $row_e);
		$AVE_Template->assign('items', $items);
		$AVE_Template->assign('tpl_dir', $tpl_dir);
		$AVE_Template->assign('formaction', 'index.php?do=modules&action=modedit&mod=contact&moduleaction=save&cp=' . SESSION . '&id=' . $_REQUEST['id'] . '&pop=1');
		$AVE_Template->assign('content', $AVE_Template->fetch($tpl_dir . 'admin_fields.tpl'));
	}

	/**
	 * Запись существующей формы
	 *
	 * @param int $id идентификатор формы
	 */
	function saveForms($id)
	{
		global $AVE_DB;

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

		if (!empty($_POST['del']))
		{
			foreach ($_POST['del'] as $id => $field)
			{
				$AVE_DB->Query("
					DELETE
					FROM " . PREFIX . "_modul_contact_fields
					WHERE Id = '" . $id . "'
				");
			}
		}

		foreach ($_POST['field_title'] as $id => $field)
		{
			if (!empty($field))
			{
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
				reportLog($_SESSION['user_name'] . ' - отредактировал поле в модуле контакты (' . $field_title . ')', 2, 2);
			}
		}
		header('Location:index.php?do=modules&action=modedit&mod=contact&moduleaction=edit&id=' . $_REQUEST['id'] . '&pop=1&cp=' . SESSION);
	}

	/**
	 * Запись новой формы
	 *
	 * @param int $id идентификатор формы
	 */
	function saveFormsNew($id)
	{
		global $AVE_DB;

		if (!empty($_POST['field_title']))
		{
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

		reportLog($_SESSION['user_name'] . ' - добавил новое поле в модуле контакты (' . $field_title . ')', 2, 2);

		header('Location:index.php?do=modules&action=modedit&mod=contact&moduleaction=edit&id=' . $_REQUEST['id'] . '&pop=1&cp=' . SESSION);
	}

	/**
	 * Создание новой формы
	 *
	 * @param string $tpl_dir путь к папке с шаблонами
	 */
	function newForms($tpl_dir)
	{
		global $AVE_DB, $AVE_Template;

		switch($_REQUEST['sub'])
		{
			case '':
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

				$AVE_Template->assign('groups', $Groups);
				$AVE_Template->assign('tpl_dir', $tpl_dir);
				$AVE_Template->assign('formaction', 'index.php?do=modules&action=modedit&mod=contact&moduleaction=new&sub=save&cp=' . SESSION . '&pop=1');
				$AVE_Template->assign('content', $AVE_Template->fetch($tpl_dir . 'admin_fields.tpl'));
				break;

			case 'save':
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

				reportLog($_SESSION['user_name'] . ' - добавил новую контактную форму (' . stripslashes($_REQUEST['form_name']) . ')', 2, 2);

				header('Location:index.php?do=modules&action=modedit&mod=contact&moduleaction=edit&id=' . $iid . '&pop=1&cp=' . SESSION);
				exit;
				break;
		}
	}

	/**
	 * Удаление формы
	 *
	 * @param int $id идентификатор формы
	 */
	function deleteForms($id)
	{
		global $AVE_DB;

		$AVE_DB->Query("
			DELETE
			FROM " . PREFIX . "_modul_contacts
			WHERE Id = '" . $id . "'
		");
		$AVE_DB->Query("
			DELETE
			FROM " . PREFIX . "_modul_contact_fields
			WHERE form_id = '" . $id . "'
		");

		$row = $AVE_DB->Query("
			SELECT
				in_attachment,
				out_attachment
			FROM " . PREFIX . "_modul_contact_info
			WHERE form_id = '" . $id . "'
		")->FetchRow();

		if ($row->in_attachment != '')
		{
			$del = explode(';', $row->in_attachment);
			foreach ($del as $delfile)
			{
				@unlink(BASE_DIR . '/attachments/' . $delfile);
			}
		}

		if ($row->out_attachment != '')
		{
			$del = explode(';', $row->out_attachment);
			foreach ($del as $delfile)
			{
				@unlink(BASE_DIR . '/attachments/' . $delfile);
			}
		}

		$AVE_DB->Query("
			DELETE
			FROM " . PREFIX . "_modul_contact_info
			WHERE form_id = '" . $id . "'
		");

		reportLog($_SESSION['user_name'] . ' - удалил контактную форму (' . $id . ')', 2, 2);

		header('Location:index.php?do=modules&action=modedit&mod=contact&moduleaction=1&cp=' . SESSION);
		exit;
	}

	/**
	 * Просмотр сообщений отправленных пользователями
	 *
	 * @param string $tpl_dir путь к папке с шаблонами
	 * @param int $id идентификатор формы
	 * @param string $newold сообщение без ответа new
	 */
	function showMessages($tpl_dir, $id, $newold = '')
	{
		global $AVE_DB, $AVE_Template;

		switch($_REQUEST['sub'])
		{
			case '':
				$n_o     = ($newold == 'new') ? 'AND out_date < 1' : 'AND out_date > 1';
				$new_old = ($newold == 'new') ? 'showmessages_new' : 'showmessages_old';

				$num = $AVE_DB->Query("
					SELECT COUNT(*)
					FROM " . PREFIX . "_modul_contact_info
					WHERE form_id = '" . $id . "'
					" . $n_o . "
				")->GetCell();

				$limit  = $this->_adminlimit;
				$seiten = ceil($num / $limit);
				$start  = get_current_page() * $limit - $limit;

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

				if ($num > $limit)
				{
					$page_nav = " <a class=\"pnav\" href=\"index.php?do=modules&action=modedit&mod=contact&moduleaction=" . $new_old . "&cp=" . SESSION
						. "&page={s}&id=" . intval($_REQUEST['id']) . "\">{t}</a> ";
					$page_nav = get_pagination($seiten, 'page', $page_nav);
					$AVE_Template->assign('page_nav', $page_nav);
				}
				$AVE_Template->assign('items', $items);
				$AVE_Template->assign('content', $AVE_Template->fetch($tpl_dir . 'admin_messages.tpl'));
				break;

			case 'view':
				$row = $AVE_DB->Query("
					SELECT *
					FROM " . PREFIX . "_modul_contact_info
					WHERE Id = '" . $_REQUEST['id'] . "'
				")->FetchRow();

				$attachments = '';

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

				$row->nl2brText = nl2br(stripslashes($row->in_message));
				$row->replytext = $row->in_message;
				$AVE_Template->assign('attachments', $attachments);
				$AVE_Template->assign('row', $row);
				$AVE_Template->assign('content', $AVE_Template->fetch($tpl_dir . 'admin_messageform.tpl'));
				break;
		}
	}

	/**
	 * Получение прикреплённых файлов
	 *
	 * @param file $file
	 */
	function getAttachment($file)
	{
		$file_ex = getMimeTyp($file);
		header('Pragma: public');
		header('Expires: 0');
		header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
		header('Cache-Control: private', false);
		header('Content-Type: ' . $file_ex);
		header('Content-Disposition: attachment; filename=' . $file);
		header('Content-Transfer-Encoding: binary');
		header('Content-Length: ' . @filesize(BASE_DIR . '/attachments/' . $file));
		@set_time_limit(0);
		@cpReadfile(BASE_DIR . '/attachments/' . $file) or die('File not found. ');
	}

	/**
	 * Отправка ответа на сообщение пользователя
	 *
	 */
	function replyMessage()
	{
		global $AVE_DB;

		$attach = $this->_uploadFile(100000);
		$out_attachment = (is_array($attach) && count($attach) >= 1) ? implode(';', $attach) : '';

		send_mail(
			$_REQUEST['to'],
			stripslashes($_REQUEST['message']),
			$_REQUEST['subject'],
			$_REQUEST['fromemail'],
			$_POST['fromname'],
			'text',
			$attach
		);

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
		echo '<script>window.opener.location.reload(); window.close();</script>';
	}

	/**
	 * Управление прикреплёнными файлами
	 *
	 */
	function quickSave()
	{
		global $AVE_DB;

		foreach ($_POST['del'] as $id => $del)
		{
			if ($this->_delfile == 1)
			{
				$row = $AVE_DB->Query("
					SELECT
						in_attachment,
						out_attachment
					FROM " . PREFIX . "_modul_contact_info
					WHERE Id = '" . $id . "'
				")->FetchRow();

				if ($row->in_attachment != '')
				{
					$del = explode(';', $row->in_attachment);
					foreach ($del as $delfile)
					{
						@unlink(BASE_DIR . '/attachments/' . $delfile);
					}
				}

				if ($row->out_attachment != '')
				{
					$del = explode(';', $row->out_attachment);
					foreach ($del as $delfile)
					{
						@unlink(BASE_DIR . '/attachments/' . $delfile);
					}
				}
			}
			$AVE_DB->Query("
				DELETE
				FROM " . PREFIX . "_modul_contact_info
				WHERE Id = '" . $id . "'
			");
		}
		header('Location:index.php?do=modules&action=modedit&mod=contact&moduleaction=1&cp=' . SESSION);
		exit;
	}
}

?>