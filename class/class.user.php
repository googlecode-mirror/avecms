<?php

/**
 * AVE.cms
 *
 * @package AVE.cms
 * @filesource
 */

/**
 * Класс для работы с группами и учетными записями пользователей
 */
class AVE_User
{
/**
 *	СВОЙСТВА
 */

	/**
	 * Количество Пользователей отображаемых на одной странице списка
	 *
	 * @var int
	 */
	var $_limit = 15;

	/**
	 * Допустимые права доступа в административной панели
	 *
	 * @var array
	 */
	var $_allowed_admin_permission = array(
		'alles',
		'adminpanel',
		'abfragen', 'abfragen_loesch', 'abfragen_neu',
		'dbactions',
		'docs', 'docs_comments', 'docs_comments_del', 'docs_php',
		'gen_settings',
		'group', 'group_edit', 'group_new',
		'logs',
		'mediapool', 'mediapool_del',
		'modules', 'modules_admin',
		'navigation', 'navigation_edit', 'navigation_new',
		'rubs', 'rub_edit', 'rub_loesch', 'rub_multi', 'rub_neu', 'rub_perms', 'rub_php',
		'user', 'user_edit', 'user_loesch', 'user_new', 'user_perms',
		'vorlagen', 'vorlagen_edit', 'vorlagen_loesch', 'vorlagen_multi', 'vorlagen_neu', 'vorlagen_php'
	);

	/**
	 * Разделитель используемый при записи даты рождения
	 *
	 * @var string
	 */
	var $_birthday_delimetr = '.';

/**
 *	ВНУТРЕННИЕ МЕТОДЫ
 */

	/**
	 * Проверка элементов учетной записи пользователя
	 *
	 * @param boolean $new признак проверки элементов новой учетной записи
	 * @return array
	 */
	function _userFieldValidate($new = false)
	{
		global $AVE_DB, $AVE_Template;

		$errors = array();

		$regex = '/[^\x20-\xFF]/';
		$regex_username = '/[^\w-]/';
		$regex_password = '/[^\x21-\xFF]/';
		$regex_birthday = '#(0[1-9]|[12][0-9]|3[01])([[:punct:]| ])(0[1-9]|1[012])\2(19|20)\d\d#';
//		$regex_email = "¬^[a-z0-9!#$%&'*+/=?^_`{|}~-]+(?:\.[a-z0-9!#$%&'*+/=?^_`{|}~-]+)*@(?:[a-z0-9](?:[a-z0-9-]*[a-z0-9])?\.)+(?:[a-z]{2}|com|org|net|edu|gov|mil|biz|info|mobi|name|aero|asia|jobs|museum)$¬i";
		$regex_email = '/^[\w.-]+@[a-z0-9.-]+\.(?:[a-z]{2}|com|org|net|edu|gov|mil|biz|info|mobi|name|aero|asia|jobs|museum)$/i';

		// Проверка логина
		if (empty($_POST['UserName']))
		{
			$errors[] = @$AVE_Template->get_config_vars('USER_NO_USERNAME');
		}
		elseif (preg_match($regex_username, $_POST['UserName']))
		{
			$errors[] = @$AVE_Template->get_config_vars('USER_ERROR_USERNAME');
		}

		// Проверка имени
		if (empty($_POST['Vorname']))
		{
			$errors[] = @$AVE_Template->get_config_vars('USER_NO_FIRSTNAME');
		}
		elseif (preg_match($regex, stripslashes($_POST['Vorname'])))
		{
			$errors[] = @$AVE_Template->get_config_vars('USER_ERROR_FIRSTNAME');
		}

		// Проверка фамилии
		if (empty($_POST['Nachname']))
		{
			$errors[] = @$AVE_Template->get_config_vars('USER_NO_LASTNAME');
		}
		elseif (preg_match($regex, stripslashes($_POST['Nachname'])))
		{
			$errors[] = @$AVE_Template->get_config_vars('USER_ERROR_LASTNAME');
		}

		// Проверка e-Mail
		if (empty($_POST['Email']))
		{
			$errors[] = @$AVE_Template->get_config_vars('USER_NO_EMAIL');
		}
		elseif (!preg_match($regex_email, $_POST['Email']))
		{
			$errors[] = @$AVE_Template->get_config_vars('USER_EMAIL_ERROR');
		}
		else
		{
			$email_exist = $AVE_DB->Query("
				SELECT Email
				FROM " . PREFIX . "_users
				WHERE Email != '" . $_POST['Email_Old'] . "'
				AND Email = '" . $_POST['Email'] . "'
				" . ($new ? "AND Email != '" . $_SESSION['user_email'] . "'" : '') . "
				LIMIT 1
			")->NumRows();
			if ($email_exist)
			{
				$errors[] = @$AVE_Template->get_config_vars('USER_EMAIL_EXIST');
			}
		}

		// Проверка пароля
		if (isset($_REQUEST['action']) && $_REQUEST['action'] != 'edit')
		{
			if (empty($_POST['Kennwort']))
			{
				$errors[] = @$AVE_Template->get_config_vars('USER_NO_PASSWORD');
			}
			elseif (strlen($_POST['Kennwort']) < 4)
			{
				$errors[] = @$AVE_Template->get_config_vars('USER_PASSWORD_SHORT');
			}
			elseif (preg_match($regex_password, $_POST['Kennwort']))
			{
				$errors[] = @$AVE_Template->get_config_vars('USER_PASSWORD_ERROR');
			}
		}

		// Проверка даты рождения
		$match = '';
		if (!empty($_POST['GebTag']) && !preg_match($regex_birthday, $_POST['GebTag'], $match))
		{
			$errors[] = @$AVE_Template->get_config_vars('USER_ERROR_DATEFORMAT');
		}
		elseif (!empty($match))
		{

			$_POST['GebTag'] = $match[1]
			. $this->_birthday_delimetr . $match[3]
			. $this->_birthday_delimetr . $match[4];
		}

		return $errors;
	}

/**
 *	ВНЕШНИЕ МЕТОДЫ
 */

	/**
	 * Группы пользователей
	 */

	/**
	 * Получение списка Групп пользователей
	 *
	 * @param string $exclude идентификатор исключаемой Группы пользователей (гостей)
	 * @return array
	 */
	function userGroupListGet($exclude = '')
	{
		global $AVE_DB;

		$user_groups = array();
		$sql = $AVE_DB->Query("
			SELECT
				grp.*,
				COUNT(usr.Id) AS UserCount
			FROM
				" . PREFIX . "_user_groups AS grp
			LEFT JOIN
				" . PREFIX . "_users AS usr
					ON usr.Benutzergruppe = grp.Benutzergruppe
			" . (($exclude != '' && is_numeric($exclude)) ? "WHERE grp.Benutzergruppe != '" . $exclude . "'" : '') . "
			GROUP BY grp.Benutzergruppe
		");

		while ($row = $sql->FetchRow())
		{
			array_push($user_groups, $row);
		}

		return $user_groups;
	}

	/**
	 * Отобразить список Групп пользователей
	 *
	 */
	function userGroupListShow()
	{
		global $AVE_Template;

		$AVE_Template->assign('ugroups', $this->userGroupListGet());
		$AVE_Template->assign('content', $AVE_Template->fetch('groups/groups.tpl'));
	}

	/**
	 * Создание новой Группы пользователей
	 *
	 */
	function userGroupNew()
	{
		global $AVE_DB;

		if (!empty($_POST['Name']))
		{
			$AVE_DB->Query("
				INSERT
				INTO " . PREFIX . "_user_groups
				SET
					Benutzergruppe = '',
					Name = '" . $_POST['Name'] . "',
					Aktiv = 1,
					Rechte = ''
			");
			$iid = $AVE_DB->InsertId();

			reportLog($_SESSION['user_name'] . ' - Создал группу пользователей (' . $iid . ')', 2, 2);
			header('Location:index.php?do=groups&action=grouprights&Id=' . $iid . '&cp=' . SESSION);
		}
		else
		{
			header('Location:index.php?do=groups&cp=' . SESSION);
		}
	}

	/**
	 * Удаление Группы пользователей
	 *
	 * @param int $user_group_id идентификатор Группы пользователей
	 */
	function userGroupDelete($user_group_id = '0')
	{
		global $AVE_DB;

		if (is_numeric($user_group_id) && $user_group_id > 2)
		{
			$exist_user_in_group = $AVE_DB->Query("
				SELECT Benutzergruppe
				FROM " . PREFIX . "_users
				WHERE Benutzergruppe = '" . $user_group_id . "'
				LIMIT 1
			")->NumRows();

			if (!$exist_user_in_group)
			{
				$AVE_DB->Query("
					DELETE
					FROM " . PREFIX . "_user_groups
					WHERE Benutzergruppe = '" . $user_group_id . "'
				");

				reportLog($_SESSION['user_name'] . ' - Удалил группу пользователей (' . $user_group_id . ')', 2, 2);
			}
		}

		header('Location:index.php?do=groups&cp=' . SESSION);
	}

	/**
	 * Редактирование прав Группы пользователей
	 *
	 * @param int $user_group_id идентификатор Группы пользователей
	 */
	function userGroupPermissionEdit($user_group_id)
	{
		global $AVE_DB, $AVE_Template, $AVE_Module;

		if (UGROUP != 1 && UGROUP == $user_group_id)
		{
			$AVE_Template->assign('own_group', true);
		}
		else
		{
			if (is_numeric($user_group_id) && $user_group_id)
			{
				$row = $AVE_DB->Query("
					SELECT
						Name,
						Rechte
					FROM " . PREFIX . "_user_groups
					WHERE Benutzergruppe = '" . $user_group_id . "'
				")->FetchRow();
			}

			if (empty($row))
			{
				$AVE_Template->assign('no_group', true);
			}
			else
			{
				$AVE_Template->assign('g_all_permissions', $this->_allowed_admin_permission);
				$AVE_Template->assign('g_group_permissions', explode('|', $row->Rechte));
				$AVE_Template->assign('g_name', $row->Name);
				$AVE_Template->assign('modules', $AVE_Module->moduleListGet(1));
			}
		}

		$AVE_Template->assign('content', $AVE_Template->fetch('groups/perms.tpl'));
	}

	/**
	 * Запись прав Групп пользователей
	 *
	 * @param int $user_group_id идентификатор Группы пользователей
	 */
	function userGroupPermissionSave($user_group_id)
	{
		global $AVE_DB;

		if (is_numeric($user_group_id))
		{
			$perms = (!empty($_REQUEST['perms']) && is_array($_REQUEST['perms'])) ? implode('|', $_REQUEST['perms']) : '';
			$perms = ($user_group_id == '1' || in_array('alles', $_REQUEST['perms'])) ? 'alles' : $perms;
			$perms = ($user_group_id == '2') ? '' : $perms;

			$AVE_DB->Query("
				UPDATE " . PREFIX . "_user_groups
				SET Rechte = '" . $perms . "'
				" . (!empty($_POST['Name']) ? ", Name = '" . $_POST['Name'] . "'" : '') . "
				WHERE BenutzerGruppe = '" . $user_group_id . "'
			");

			reportLog($_SESSION['user_name'] . ' - Изменил права доступа для группы (' . $user_group_id . ')', 2, 2);
		}

		header('Location:index.php?do=groups&cp=' . SESSION);
		exit;
	}

	/**
	 * Учетные записи пользователей
	 */

	/**
	 * Формирование спискка учетных записей пользователей
	 *
	 * @param int $user_group_id идентификатор Группы пользователей
	 */
	function userListFetch($user_group_id = '')
	{
		global $AVE_DB, $AVE_Template;

		$search_by_group = '';
		$search_by_id_or_name = '';
		$user_group_navi = '';
		$query_navi = '';
		$status_search = '';
		$status_navi = '';

		if (isset($_REQUEST['Benutzergruppe']) && $_REQUEST['Benutzergruppe'] != '0')
		{
			$user_group_id = ($user_group_id != '') ? $user_group_id : $_REQUEST['Benutzergruppe'];
			$user_group_navi = '&amp;Benutzergruppe=' . $user_group_id;
			$search_by_group = " AND Benutzergruppe = '" . $user_group_id . "' ";
		}

		if (!empty($_REQUEST['query']))
		{
			$q = urldecode($_REQUEST['query']);
			$search_by_id_or_name = "
				AND (Email LIKE '%" . $q . "%'
				OR Email = '" . $q . "'
				OR Id = '" . $q . "'
				OR Vorname LIKE '" . $q . "%'
				OR Nachname LIKE '" . $q . "%')
			";
			$query_navi = '&amp;query=' . urlencode($_REQUEST['query']);
		}

		if (isset($_REQUEST['Status']) && $_REQUEST['Status'] != 'all')
		{
			$status_search = " AND Status = '" . (int)$_REQUEST['Status'] . "' ";
			$status_navi   = '&amp;Status=' . (int)$_REQUEST['Status'];
		}

		$num = $AVE_DB->Query("
			SELECT COUNT(*)
			FROM " . PREFIX . "_users
			WHERE 1"
			. $search_by_group
			. $search_by_id_or_name
			. $status_search
		)->GetCell();

		$sql = $AVE_DB->Query("
			SELECT *
			FROM " . PREFIX . "_users
			WHERE 1"
			. $search_by_group
			. $search_by_id_or_name
			. $status_search
			. " LIMIT " . (get_current_page()*$this->_limit-$this->_limit) . "," . $this->_limit
		);

		$isShop = $AVE_DB->Query("SHOW TABLES LIKE '" . PREFIX . "_modul_shop_bestellungen'")->GetCell();
		$users = array();
		while ($row = $sql->FetchRow())
		{
			if ($isShop)
			{
				$row->IsShop = 1;
				$row->Orders = $AVE_DB->Query("
					SELECT DISTINCT(Id)
					FROM " . PREFIX . "_modul_shop_bestellungen
					WHERE Benutzer = '" . $row->Id . "'
				")->NumRows();
			}
			array_push($users, $row);
		}

		if ($num > $this->_limit)
		{
			$page_nav = ' <a class="pnav" href="index.php?do=user' . $status_navi . '&page={s}&amp;cp=' . SESSION . $user_group_navi . $query_navi . '">{t}</a> ';
			$page_nav = get_pagination(ceil($num/$this->_limit), 'page', $page_nav);
			$AVE_Template->assign('page_nav', $page_nav);
		}

		$AVE_Template->assign('ugroups', $this->userGroupListGet());
		$AVE_Template->assign('users', $users);
	}

	/**
	 * Создание новой учетной записи
	 *
	 */
	function userNew()
	{
		global $AVE_DB, $AVE_Template;

		switch($_REQUEST['sub'])
		{
			case '':
				$AVE_Template->assign('available_countries', get_country_list(1));
				$AVE_Template->assign('ugroups', $this->userGroupListGet(2));
				$AVE_Template->assign('formaction', 'index.php?do=user&amp;action=new&amp;sub=save&amp;cp=' . SESSION);
				$AVE_Template->assign('content', $AVE_Template->fetch('user/form.tpl'));
				break;

			case 'save':
				$errors = $this->_userFieldValidate(1);
				if (!empty($errors))
				{
					$AVE_Template->assign('errors', $errors);
					$AVE_Template->assign('available_countries', get_country_list(1));
					$AVE_Template->assign('ugroups', $this->userGroupListGet(2));
					$AVE_Template->assign('formaction', 'index.php?do=user&amp;action=new&amp;sub=save&amp;cp=' . SESSION);
					$AVE_Template->assign('content', $AVE_Template->fetch('user/form.tpl'));
				}
				else
				{
					$salt = make_random_string();
					$password = md5(md5(trim($_POST['Kennwort']) . $salt));
					$AVE_DB->Query("
						INSERT INTO " . PREFIX . "_users
						SET
							Id                 = '',
							Kennwort           = '" . $password . "',
							salt               = '" . $salt . "',
							Email              = '" . $_POST['Email'] . "',
							Strasse            = '" . $_POST['Strasse'] . "',
							HausNr             = '" . $_POST['HausNr'] . "',
							Postleitzahl       = '" . $_POST['Postleitzahl'] . "',
							city               = '" . $_POST['city'] . "',
							Telefon            = '" . $_POST['Telefon'] . "',
							Telefax            = '" . $_POST['Telefax'] . "',
						--	Bemerkungen        = '" . $_POST['Bemerkungen'] . "',
							Vorname            = '" . $_POST['Vorname'] . "',
							Nachname           = '" . $_POST['Nachname'] . "',
							`UserName`         = '" . $_POST['Username'] . "',
							Benutzergruppe     = '" . $_POST['Benutzergruppe'] . "',
							Registriert        = '" . time() . "',
							Status             = '" . $_POST['Status'] . "',
							ZuletztGesehen     = '" . time() . "',
							Land               = '" . $_POST['Land'] . "',
							GebTag             = '" . $_POST['GebTag'] . "',
							Firma              = '" . $_POST['Firma'] . "',
							UStPflichtig       = '" . $_POST['UStPflichtig'] . "',
							BenutzergruppeMisc = '" . @implode(';', $_POST['BenutzergruppeMisc']) . "'
					");

					$message = get_settings('mail_new_user');
					$message = str_replace('%NAME%', $_POST['UserName'], $message);
					$message = str_replace('%HOST%', substr(HOST . ABS_PATH, 0, -6), $message);
					$message = str_replace('%KENNWORT%', $_POST['Kennwort'], $message);
					$message = str_replace('%EMAIL%', $_POST['Email'], $message);
					$message = str_replace('%EMAILFUSS%', get_settings('mail_signature'), $message);

					send_mail(
						$_POST['Email'],
						$message,
						$AVE_Template->get_config_vars('USER_MAIL_SUBJECT')
					);

					reportLog($_SESSION['user_name'] . ' - Добавил пользователя (' . stripslashes($_POST['UserName']) . ')', 2, 2);

					header('Location:index.php?do=user&cp=' . SESSION);
				}
				break;
		}
	}

	/**
	 * Редактирование учетной записи пользователя
	 *
	 * @param int $user_id идентификатор учетной записи пользователя
	 */
	function userEdit($user_id)
	{
		global $AVE_DB, $AVE_Template;

		$user_id = (int)$user_id;

		switch($_REQUEST['sub'])
		{
			case '':
				$row = $AVE_DB->Query("
					SELECT *
					FROM " . PREFIX . "_users
					WHERE Id = '" . $user_id . "'
				")->FetchRow();

				$AVE_Template->assign('row', $row);
				$AVE_Template->assign('BenutzergruppeMisc', explode(';', $row->BenutzergruppeMisc));

				if ($AVE_DB->Query("SHOW TABLES LIKE '" . PREFIX . "_modul_shop'")->GetCell())
				{
					$AVE_Template->assign('is_shop', 1);
				}

				if ($AVE_DB->Query("SHOW TABLES LIKE '" . PREFIX . "_modul_forum_userprofile'")->GetCell())
				{
					$row = $AVE_DB->Query("
						SELECT *
						FROM " . PREFIX . "_modul_forum_userprofile
						WHERE BenutzerId = '" . $user_id . "'
					")->FetchRow();

					if (is_object($row))
					{
						$AVE_Template->assign('row_fp', $row);
						$AVE_Template->assign('is_forum', 1);
					}
				}

				$AVE_Template->assign('available_countries', get_country_list(1));
				$AVE_Template->assign('ugroups', $this->userGroupListGet(2));
				$AVE_Template->assign('formaction', 'index.php?do=user&amp;action=edit&amp;sub=save&amp;cp=' . SESSION . '&amp;Id=' . $user_id);
				$AVE_Template->assign('content', $AVE_Template->fetch('user/form.tpl'));
				break;

			case 'save':
				$errors = $this->_userFieldValidate();
				if (!empty($errors))
				{
					$AVE_Template->assign('errors', $errors);
					$AVE_Template->assign('available_countries', get_country_list(1));
					$AVE_Template->assign('ugroups', $this->userGroupListGet(2));
					$AVE_Template->assign('formaction', 'index.php?do=user&amp;action=edit&amp;sub=save&amp;cp=' . SESSION . '&amp;Id=' . $user_id);
					$AVE_Template->assign('content', $AVE_Template->fetch('user/form.tpl'));
				}
				else
				{
					if (!empty($_REQUEST['Kennwort']))
					{
						$salt = make_random_string();
						$password = md5(md5(trim($_POST['Kennwort']) . $salt));
						$password_set = "Kennwort = '" . $password . "', salt = '" . $salt . "',";
					}
					else
					{
						$password_set = '';
					}

					$user_group_id = ($_SESSION['user_id'] != $user_id) ? "Benutzergruppe = '" . $_REQUEST['Benutzergruppe'] . "'," : '';

					$AVE_DB->Query("
						UPDATE " . PREFIX . "_users
						SET
							" . $password_set . "
							" . $user_group_id . "
							Email              = '" . $_REQUEST['Email'] . "',
							Strasse            = '" . $_REQUEST['Strasse'] . "',
							HausNr             = '" . $_REQUEST['HausNr'] . "',
							Postleitzahl       = '" . $_REQUEST['Postleitzahl'] . "',
							city               = '" . $_REQUEST['city'] . "',
							Telefon            = '" . $_REQUEST['Telefon'] . "',
							Telefax            = '" . $_REQUEST['Telefax'] . "',
						--	Bemerkungen        = '" . $_REQUEST['Bemerkungen'] . "',
							Vorname            = '" . $_REQUEST['Vorname'] . "',
							Nachname           = '" . $_REQUEST['Nachname'] . "',
							`UserName`         = '" . $_REQUEST['UserName'] . "',
							Status             = '" . $_REQUEST['Status'] . "',
							Land               = '" . $_REQUEST['Land'] . "',
							GebTag             = '" . $_REQUEST['GebTag'] . "',
							UStPflichtig       = '" . $_REQUEST['UStPflichtig'] . "',
							Firma              = '" . $_REQUEST['Firma'] . "',
							BenutzergruppeMisc = '" . @implode(';', $_REQUEST['BenutzergruppeMisc']) . "'
						WHERE
							Id = '" . $user_id . "'
					");

					if ($AVE_DB->Query("SHOW TABLES LIKE '" . PREFIX . "_modul_forum_userprofile'")->GetCell())
					{
						$AVE_DB->Query("
							UPDATE " . PREFIX . "_modul_forum_userprofile
							SET
								GroupIdMisc  = '" . @implode(';', $_REQUEST['BenutzergruppeMisc']) . "',
								BenutzerName = '" . @$_REQUEST['BenutzerName_fp']. "',
								Signatur     = '" . @$_REQUEST['Signatur_fp'] . "' ,
								Avatar       = '" . @$_REQUEST['Avatar_fp'] . "'
							WHERE
								BenutzerId = '" . $user_id . "'
						");
					}

					if ($_REQUEST['Status'] == 1 && @$_REQUEST['SendFreeMail'] == 1)
					{
						$host        = substr(HOST . ABS_PATH, 0, -6);
						$body_start  = $AVE_Template->get_config_vars('USER_MAIL_BODY1');
						$body_start  = str_replace('%USER%', $_REQUEST['UserName'], $body_start);
						$body_start .= str_replace('%HOST%', $host, $AVE_Template->get_config_vars('USER_MAIL_BODY2'));
						$body_start .= str_replace('%HOMEPAGENAME%', get_settings('site_name'), $AVE_Template->get_config_vars('USER_MAIL_FOOTER'));
						$body_start  = str_replace('%N%', "\n", $body_start);
						$body_start  = str_replace('%HOST%', $host, $body_start);

						send_mail(
							$_POST['Email'],
							$body_start,
							$AVE_Template->get_config_vars('USER_MAIL_SUBJECT'),
							get_settings('mail_from'),
							get_settings('mail_from_name') . ' (' . get_settings('site_name') . ')',
							'text',
							''
						);
					}

					if (!empty($_REQUEST['Kennwort']) && $_REQUEST['PassChange'] == 1)
					{
						$host        = substr(HOST . ABS_PATH, 0, -6);
						$body_start  = $AVE_Template->get_config_vars('USER_MAIL_BODY1');
						$body_start  = str_replace('%USER%', $_REQUEST['UserName'], $body_start);
						$body_start .= str_replace('%HOST%', $host, $AVE_Template->get_config_vars('USER_MAIL_PASSWORD2'));
						$body_start  = str_replace('%NEWPASS%', $_REQUEST['Kennwort'], $body_start);
						$body_start .= str_replace('%HOMEPAGENAME%', get_settings('site_name'), $AVE_Template->get_config_vars('USER_MAIL_FOOTER'));
						$body_start  = str_replace('%N%', "\n", $body_start);
						$body_start  = str_replace('%HOST%', $host, $body_start);

						send_mail(
							$_POST['Email'],
							$body_start,
							$AVE_Template->get_config_vars('USER_MAIL_PASSWORD'),
							get_settings('mail_from'),
							get_settings('mail_from_name') . ' (' . get_settings('site_name') . ')',
							'text',
							''
						);
					}

					if ($_REQUEST['SimpleMessage'] != '')
					{
						send_mail(
							$_POST['Email'],
							stripslashes($_POST['SimpleMessage']),
							stripslashes($_POST['SubjectMessage']),
							$_SESSION['user_email'],
							$_SESSION['user_name'],
							'text',
							''
						);
					}

					if (!empty($_REQUEST['Kennwort']) && $_SESSION['user_id'] == $user_id)
					{
						$_SESSION['user_pass'] = $password;
						$_SESSION['user_email'] = $_POST['Email'];
					}

					reportLog($_SESSION['user_name'] . ' - Отредактировал параметры пользователя (' . stripslashes($_POST['UserName']) . ')', 2, 2);

					header('Location:index.php?do=user&cp=' . SESSION);
					exit;
				}
				break;
		}
	}

	/**
	 * Удаление учетной записи пользователя
	 *
	 * @param int $user_id идентификатор учетной записи пользователя
	 */
	function userDelete($user_id)
	{
		global $AVE_DB;

		if (is_numeric($user_id) && $user_id != 1)
		{
			$AVE_DB->Query("
				DELETE
				FROM " . PREFIX . "_users
				WHERE Id = '" . $user_id . "'
			");

			if ($AVE_DB->Query("SHOW TABLES LIKE '" . PREFIX . "_modul_forum_userprofile'")->GetCell())
			{
				$AVE_DB->Query("
					DELETE
					FROM " . PREFIX . "_modul_forum_userprofile
					WHERE BenutzerId = '" . $user_id . "'
				");
			}

			reportLog($_SESSION['user_name'] . ' - Удалил пользователя (' . $user_id . ')', 2, 2);
		}

		header('Location:index.php?do=user&cp=' . SESSION);
	}

	/**
	 * Запись изменений учетных записей пользователей в списке
	 *
	 */
	function userListEdit()
	{
		global $AVE_DB;

		foreach ($_POST['del'] as $user_id => $del)
		{
			if (is_numeric($user_id) && $user_id > 1)
			{
				$AVE_DB->Query("
					DELETE
					FROM " . PREFIX . "_users
					WHERE Id = '" . $user_id . "'
				");
				reportLog($_SESSION['user_name'] . ' - Удалил пользователя (' . $user_id . ')', 2, 2);
			}
		}

		foreach ($_POST['Benutzergruppe'] as $user_id => $user_group_id)
		{
			if (is_numeric($user_id) && $user_id > 0 &&
				is_numeric($user_group_id) && $user_group_id > 0)
			{
				$AVE_DB->Query("
					UPDATE " . PREFIX . "_users
					SET Benutzergruppe = '" . $user_group_id . "'
					WHERE Id = '" . $user_id . "'
				");
				reportLog($_SESSION['user_name'] . ' - Изменил группу для пользователя (' . $user_id . ')', 2, 2);
			}
		}

		header('Location:index.php?do=user&cp=' . SESSION);
		exit;
	}
}

?>