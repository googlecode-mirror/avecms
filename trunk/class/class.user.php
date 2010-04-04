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
	var $_limit = 15;
	var $_available_countries = array(
		'ru', 'de', 'cz', 'ch', 'dk', 'en', 'fr', 'at', 'gb', 'it', 'es', 'be', 'se', 'gr'
	);
	var $_allperms_admin = array(
		'adminpanel',    'gen_settings',   'logs',         'alles',            'dbactions',
		'modules',       'modules_admin',  'navigation',   'navigation_edit',  'navigation_new',
		'docs',          'docs_php',       'docs_comments','docs_comments_del','vorlagen',
		'vorlagen_multi','vorlagen_loesch','vorlagen_edit','vorlagen_php',     'vorlagen_neu',
		'rubs',          'rub_neu',        'rub_edit',     'rub_loesch',       'rub_multi',
		'rub_perms',     'rub_php',        'abfragen',     'abfragen_neu',     'abfragen_loesch',
		'user',          'user_new',       'user_edit',    'user_loesch',      'user_perms',
		'group',         'group_edit',     'group_new',    'mediapool',        'mediapool_del'
	);

	function getModules()
	{
		global $AVE_DB;

		$modules = array();

		$sql = $AVE_DB->Query("
			SELECT
				ModulPfad,
				ModulName
			FROM
				" . PREFIX . "_module
		");

		while ($row = $sql->FetchRow())
		{
			$row->ModulPfad = 'mod_' . $row->ModulPfad;
			array_push($modules, $row);
		}

		return $modules;
	}

	function allPerms($front = '0')
	{
		$allperms_admin = $this->_allperms_admin;
		$allperms_front = array('adminpanel');

		if ($front == 1)
			return $allperms_front;
		else
			return $allperms_admin;
	}

	function fetchAllPerms($group = '0')
	{
		global $AVE_DB, $AVE_Template;

		$row = $AVE_DB->Query("
			SELECT Rechte
			FROM " . PREFIX . "_user_groups
			" . ($group != 0 ? "WHERE Benutzergruppe = '" . $group . "'" : '')
		)
		->FetchRow();

		if (!$row)
		{
			$AVE_Template->assign('no_group', 1);
		}
		else
		{
			$AVE_Template->assign('g_all_permissions', $this->_allperms_admin);
			$AVE_Template->assign('g_group_permissions', explode('|', $row->Rechte));
		}
	}

	function fetchGroupNameById($id = '')
	{
		global $AVE_DB;

		return $AVE_DB->Query("
			SELECT Name
			FROM " . PREFIX . "_user_groups
			WHERE Benutzergruppe = '" . $id . "'
		")
		->GetCell();
	}

	function userCountGroup($group = 1)
	{
		global $AVE_DB;

		return $AVE_DB->Query("
			SELECT COUNT(*)
			FROM " . PREFIX . "_users
			WHERE Benutzergruppe = '" . $group . "'
		")
		->GetCell();
	}

	function listAllGroups($ex = '')
	{
		global $AVE_DB;

		$exclude = '';
		$sugroups = array();
		if ($ex != '') $exclude = 'WHERE Benutzergruppe != 2';
		$sql = $AVE_DB->Query("
			SELECT *
			FROM " . PREFIX . "_user_groups
			" . $exclude
		);

		while ($row = $sql->FetchRow())
		{
			if ($row->Benutzergruppe == 1) $row->FieldDisabled = 1;
			$row->UserCount = $this->userCountGroup($row->Benutzergruppe);
			array_push($sugroups, $row);
		}

		return $sugroups;
	}

	function listUser($gruppe = '')
	{
		global $AVE_DB, $AVE_Template;

		$search_by_group = '';
		$search_by_id_or_name = '';
		$gruppe_navi = '';
		$query_navi = '';
		$status_search = '';
		$status_navi = '';

		if (isset($_REQUEST['Benutzergruppe']) && $_REQUEST['Benutzergruppe'] != '0')
		{
			$gruppe = ($gruppe != '') ? $gruppe : $_REQUEST['Benutzergruppe'];
			$gruppe_navi = '&amp;Benutzergruppe=' . $gruppe;
			$search_by_group = " AND Benutzergruppe = '" . $gruppe . "' ";
		}

		if (!empty($_REQUEST['query']))
		{
			$q = addslashes($_REQUEST['query']);
			$email_domain = explode('@', $q);
			$search_by_id_or_name = "
				AND (Email like '%" . $q . "%'
				OR Email = '" . $q . "'
				OR Id='" . $q . "'
				OR Vorname like '" . $q . "%'
				OR Nachname like '" . $q . "%')
			";
			$query_navi = '&amp;query=' . $_REQUEST['query'];
		}

		if (isset($_REQUEST['Status']) && $_REQUEST['Status'] != 'all')
		{
			$status_search = " AND Status = '" . $_REQUEST['Status'] . "' ";
			$status_navi   = '&amp;Status=' . $_REQUEST['Status'];
		}

		$num = $AVE_DB->Query("
			SELECT COUNT(*)
			FROM " . PREFIX . "_users
			WHERE Id > 0"
			. $search_by_group
			. $search_by_id_or_name
			. $status_search
		)->GetCell();

		$sql = $AVE_DB->Query("
			SELECT *
			FROM " . PREFIX . "_users
			WHERE Id > 0"
			. $search_by_group
			. $search_by_id_or_name
			. $status_search
			. " LIMIT " . (prepage()*$this->_limit-$this->_limit) . "," . $this->_limit
		);

		$isShop = @file_exists(BASE_DIR . '/modules/shop/modul.php');
		$users = array();
		while ($row = $sql->FetchRow())
		{
			if ($isShop)
			{
				$row->IsShop = 1;
				$sql_o = $AVE_DB->Query("
					SELECT DISTINCT(Id)
					FROM " . PREFIX . "_modul_shop_bestellungen
					WHERE Benutzer = '" . $row->Id . "'
				");
				$row->Orders = $sql_o->NumRows();
			}
			array_push($users, $row);
		}

		if ($num > $this->_limit)
		{
			$page_nav = pagenav(ceil($num/$page_limit), 'page',
				' <a class="pnav" href="index.php?do=user' . $status_navi . '&page={s}&amp;cp=' . SESSION . $gruppe_navi . $query_navi . '">{t}</a> ');
			$AVE_Template->assign('page_nav', $page_nav);
		}

		$AVE_Template->assign('ugroups', $this->listAllGroups());
		$AVE_Template->assign('users', $users);
	}

	function savePerms($id, $perms = '')
	{
		global $AVE_DB;

		$id = (int)$id;
		$perms = (!empty($_REQUEST['perms']) && is_array($_REQUEST['perms'])) ? implode('|', $_REQUEST['perms']) : '';
		$perms = ($id == 1 || in_array('alles', $_REQUEST['perms'])) ? 'alles' : $perms;

		if (!empty($_POST['Name']))
		{
			$AVE_DB->Query("
				UPDATE " . PREFIX . "_user_groups
				SET
					Name = '" . $_POST['Name'] . "',
					Rechte = '" . $perms . "'
				WHERE Benutzergruppe = '" . $id . "'
			");
		}
		else
		{
			$AVE_DB->Query("
				UPDATE " . PREFIX . "_user_groups
				SET Rechte = '" . $perms . "'
				WHERE BenutzerGruppe = '" . $id . "'
			");
		}

		reportLog($_SESSION['user_name'] . ' - Изменил права доступа для группы (' . $id . ')', 2, 2);
		header('Location:index.php?do=groups&cp=' . SESSION);
		exit;
	}

	function newGroup()
	{
		global $AVE_DB;

		if (!empty($_POST['Name']))
		{
			$AVE_DB->Query("
				INSERT
				INTO " . PREFIX . "_user_groups
				SET
					Benutzergruppe = '',
					Name = '" . htmlspecialchars($_POST['Name']) . "',
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

	function delGroup($id)
	{
		global $AVE_DB;

		$count = $this->userCountGroup($id);

		if ($count > 0 || $id == 1 || $id == 2 || $id == 3 || $id == 4)
		{
			header('Location:index.php?do=groups&cp=' . SESSION);
		}
		else
		{
			$AVE_DB->Query("
				DELETE
				FROM " . PREFIX . "_user_groups
				WHERE Benutzergruppe = '" . $id . "'
			");

			reportLog($_SESSION['user_name'] . ' - Удалил группу пользователей (' . $id . ')', 2, 2);
			header('Location:index.php?do=groups&cp=' . SESSION);
		}
	}

	function checkFields($new = '0')
	{
		global $AVE_DB;

		$errors = array();

		$kennwort   = $_POST['Kennwort'];
		$muster     = '[^ _A-Za-zА-Яа-яЁё0-9-]';
		$muster_pw  = '[^_A-Za-zА-Яа-яЁё0-9-]';
		$muster_geb = '([0-9]{2}).([0-9]{2}).([0-9]{4})';

		if (empty($_POST['UserName'])) array_push($errors, @$GLOBALS['config_vars']['USER_NO_USERNAME']);
		if (ereg($muster, $_POST['UserName'])) array_push($errors, @$GLOBALS['config_vars']['USER_ERROR_USERNAME']);

//		if (empty($_POST['Vorname'])) array_push($errors, @$GLOBALS['config_vars']['USER_NO_FIRSTNAME']);
//		if (ereg($muster, $_POST['Vorname'])) array_push($errors, @$GLOBALS['config_vars']['USER_ERROR_FIRSTNAME']);

//		if (empty($_POST['Nachname'])) array_push($errors, @$GLOBALS['config_vars']['USER_NO_LASTNAME']);
//		if (ereg($muster, $_POST['Nachname'])) array_push($errors, @$GLOBALS['config_vars']['USER_ERROR_LASTNAME']);

		if (empty($_POST['Email'])) array_push($errors, @$GLOBALS['config_vars']['USER_NO_EMAIL']);
		if (!ereg('^[ -._A-Za-z0-9-]+(\.[_A-Za-z0-9-]+)*@([a-zA-Z0-9-]+\.)+([a-zA-Z]{2,4})$', $_POST['Email'])) array_push($errors, @$GLOBALS['config_vars']['USER_EMAIL_ERROR']);

		if (isset($_REQUEST['action']) && $_REQUEST['action'] != 'edit')
		{
			if (empty($kennwort)) array_push($errors, @$GLOBALS['config_vars']['USER_NO_PASSWORD']);
			if (strlen($kennwort) < 4) array_push($errors, @$GLOBALS['config_vars']['USER_PASSWORD_SHORT']);
			if (ereg($muster_pw, $kennwort)) array_push($errors, @$GLOBALS['config_vars']['USER_PASSWORD_ERROR']);
		}

		if (!empty($_POST['GebTag']) && !ereg($muster_geb, $_POST['GebTag'])) array_push($errors, @$GLOBALS['config_vars']['USER_ERROR_DATEFORMAT']);

		$extra = ($new != 1) ? " AND Email != '" . $_SESSION['user_email'] . "'" : '';

		$sql = $AVE_DB->Query("
			SELECT Email
			FROM " . PREFIX . "_users
			WHERE Email != '" . $_REQUEST['Email_Old'] . "'
			AND Email = '" . $_POST['Email'] . "'
			" . $extra
		);
		$num = $sql->NumRows();

		if ($num > 0) array_push($errors, @$GLOBALS['config_vars']['USER_EMAIL_EXIST']);

		return $errors;
	}

	function getPost()
	{
		while (list($key, $val) = each($_POST))
		{
			$row->$key = htmlspecialchars(stripslashes($val));
		}

		return $row;
	}

	function editUser($id)
	{
		global $AVE_DB, $AVE_Globals, $AVE_Template;

		switch($_REQUEST['sub'])
		{
			case '':
				$row = $AVE_DB->Query("
					SELECT *
					FROM " . PREFIX . "_users
					WHERE Id = '" . $id . "'
				")
				->FetchRow();
				$AVE_Template->assign('row', $row);
				$AVE_Template->assign('BenutzergruppeMisc', explode(';', $row->BenutzergruppeMisc));

				if (@file_exists(BASE_DIR . '/modules/shop/modul.php'))
				{
					$AVE_Template->assign('is_shop', 1);
				}

				if (@file_exists(BASE_DIR . '/modules/forums/modul.php'))
				{
					$row = $AVE_DB->Query("
						SELECT *
						FROM " . PREFIX . "_modul_forum_userprofile
						WHERE BenutzerId = '" . $id . "'
					")
					->FetchRow();

					if (is_object($row))
					{
						$AVE_Template->assign('row_fp', $row);
						$AVE_Template->assign('is_forum', 1);
					}
				}

				$AVE_Globals = new AVE_Globals;
				$AVE_Template->assign('available_countries', $AVE_Globals->fetchCountries());
				$AVE_Template->assign('ugroups', $this->listAllGroups(2));
				$AVE_Template->assign('formaction', 'index.php?do=user&amp;action=edit&amp;sub=save&amp;cp=' . SESSION . '&amp;Id=' . $id);
				$AVE_Template->assign('content', $AVE_Template->fetch('user/form.tpl'));
				break;

			case 'save':
				$AVE_Globals = new AVE_Globals;
				$SystemMail = $AVE_Globals->mainSettings('mail_from');
				$SystemMailName = $AVE_Globals->mainSettings('mail_from_name');

				$errors = $this->checkFields();
				if (sizeof($errors) == 0)
				{
					if (isset($_REQUEST['Kennwort']) && $_REQUEST['Kennwort'] != '')
					{
						$pass = "Kennwort = '" . md5(md5($_REQUEST['Kennwort'])) . "',";
						$mailpasschange = true;
					}
					else
					{
						$pass = '';
						$mailpasschange = false;
					}

					$ugroup = ($_SESSION['user_id'] != $_REQUEST['Id']) ? "Benutzergruppe = '" . $_REQUEST['Benutzergruppe'] . "'," : '';

					$AVE_DB->Query("
						UPDATE " . PREFIX . "_users
						SET
							" . $pass . "
							Email              = '" . $_REQUEST['Email'] . "',
							Strasse            = '" . $_REQUEST['Strasse'] . "',
							HausNr             = '" . $_REQUEST['HausNr'] . "',
							Postleitzahl       = '" . $_REQUEST['Postleitzahl'] . "',
							city                = '" . $_REQUEST['city'] . "',
							Telefon            = '" . $_REQUEST['Telefon'] . "',
							Telefax            = '" . $_REQUEST['Telefax'] . "',
							Bemerkungen        = '" . $_REQUEST['Bemerkungen'] . "',
							Vorname            = '" . $_REQUEST['Vorname'] . "',
							Nachname           = '" . $_REQUEST['Nachname'] . "',
							`UserName`         = '" . @$_REQUEST['UserName'] . "',
							" . $ugroup . "
							Status             = '" . $_REQUEST['Status'] . "',
							Land               = '" . $_REQUEST['Land'] . "',
							GebTag             = '" . $_REQUEST['GebTag'] . "',
							UStPflichtig       = '" . $_REQUEST['UStPflichtig'] . "',
							Firma              = '" . $_REQUEST['Firma'] . "',
							BenutzergruppeMisc = '" . @implode(';', $_REQUEST['BenutzergruppeMisc']) . "'
						WHERE
							Id = '" . $_REQUEST['Id'] . "'
					");

					$AVE_DB->Query("
						UPDATE " . PREFIX . "_modul_forum_userprofile
						SET
							GroupIdMisc  = '" . @implode(';', $_REQUEST['BenutzergruppeMisc']) . "',
							BenutzerName = '" . @addslashes($_REQUEST['BenutzerName_fp']). "',
							Signatur     = '" . @addslashes($_REQUEST['Signatur_fp']) . "' ,
							Avatar       = '" . @addslashes($_REQUEST['Avatar_fp']) . "'
						WHERE
							BenutzerId = '" . $_REQUEST['Id'] . "'
					");

					if ($_REQUEST['Status']==1 && @$_REQUEST['SendFreeMail']==1)
					{
						$host        = explode('?', redirectLink());
						$host_real   = substr($host[0], 0, -15);
						$body_start  = $GLOBALS['config_vars']['USER_MAIL_BODY1'];
						$body_start  = str_replace('%USER%', $_REQUEST['UserName'], $body_start);
						$body_start .= str_replace('%HOST%', $host_real, $GLOBALS['config_vars']['USER_MAIL_BODY2']);
						$body_start .= str_replace('%HOMEPAGENAME%', $AVE_Globals->mainSettings('site_name'), $GLOBALS['config_vars']['USER_MAIL_FOOTER']);
						$body_start  = str_replace('%N%', "\n", $body_start);
						$body_start  = str_replace('%HOST%', $host_real, $body_start);

						$AVE_Globals->cp_mail($_POST['Email'], $body_start, $GLOBALS['config_vars']['USER_MAIL_SUBJECT'], $SystemMail, $SystemMailName . ' (' . $AVE_Globals->mainSettings('site_name') . ')', 'text', '');
					}

					if ($mailpasschange==true && $_REQUEST['PassChange']==1)
					{
						$host        = explode('?', redirectLink());
						$host_real   = substr($host[0],0,-15);
						$body_start  = $GLOBALS['config_vars']['USER_MAIL_BODY1'];
						$body_start  = str_replace('%USER%', $_REQUEST['UserName'], $body_start);
						$body_start .= str_replace('%HOST%', $host_real, $GLOBALS['config_vars']['USER_MAIL_PASSWORD2']);
						$body_start  = str_replace('%NEWPASS%', $_REQUEST['Kennwort'], $body_start);
						$body_start .= str_replace('%HOMEPAGENAME%', $AVE_Globals->mainSettings('site_name'), $GLOBALS['config_vars']['USER_MAIL_FOOTER']);
						$body_start  = str_replace('%N%', "\n", $body_start);
						$body_start  = str_replace('%HOST%', $host_real, $body_start);

						$AVE_Globals->cp_mail($_POST['Email'], $body_start, $GLOBALS['config_vars']['USER_MAIL_PASSWORD'], $SystemMail, $SystemMailName . ' (' . $AVE_Globals->mainSettings('site_name') . ')', 'text', '');
					}

					if ($_REQUEST['SimpleMessage'] != '')
					{
						$message = stripslashes($_REQUEST['SimpleMessage']);
						$AVE_Globals->cp_mail($_POST['Email'], $message, $_REQUEST['SubjectMessage'], $_SESSION['user_email'], $_SESSION['user_name'], 'text', '');
					}

					if ($_REQUEST['Id'] == $_SESSION['user_id'] && $mailpasschange==true)
					{
						$_SESSION['user_pass'] = md5(md5($_POST['Kennwort']));
						$_SESSION['user_email'] = $_POST['Email'];
					}

					reportLog($_SESSION['user_name'] . ' - Отредактировал параметры пользователя (' . $_POST['UserName'] . ')', 2, 2);
					header('Location:index.php?do=user&cp=' . SESSION);
					exit;
				}
				else
				{
					$row = $this->getPost();

					$AVE_Template->assign('available_countries', $AVE_Globals->fetchCountries());
					$AVE_Template->assign('row', $row);
					$AVE_Template->assign('errors', $errors);
					$AVE_Template->assign('ugroups', $this->listAllGroups(2));
					$AVE_Template->assign('formaction', 'index.php?do=user&amp;action=edit&amp;sub=save&amp;Id=' . $id . '&amp;cp=' . SESSION);
					$AVE_Template->assign('content', $AVE_Template->fetch('user/form.tpl'));
				}
				break;
		}
	}

	function newUser()
	{
		global $AVE_DB, $AVE_Globals, $AVE_Template;

		switch($_REQUEST['sub'])
		{
			case 'save':
				$errors = $this->checkFields(1);
				if (sizeof($errors) == 0)
				{
					$AVE_DB->Query("
						INSERT INTO " . PREFIX . "_users
						SET
							Id                 = '',
							Kennwort           = '" . md5(md5($_POST['Kennwort'])) . "',
							Email              = '" . $_POST['Email'] . "',
							Strasse            = '" . $_POST['Strasse'] . "',
							HausNr             = '" . $_POST['HausNr'] . "',
							Postleitzahl       = '" . $_POST['Postleitzahl'] . "',
							city                = '" . $_POST['city'] . "',
							Telefon            = '" . $_POST['Telefon'] . "',
							Telefax            = '" . $_POST['Telefax'] . "',
							Bemerkungen        = '" . $_POST['Bemerkungen'] . "',
							Vorname            = '" . $_POST['Vorname'] . "',
							Nachname           = '" . $_POST['Nachname'] . "',
							`UserName`         = '" . $_POST['Username'] . "',
							Benutzergruppe     = '" . $_POST['Benutzergruppe'] . "',
							Registriert        = '" . time() . "',
							Status             = '" . $_REQUEST['Status'] . "',
							ZuletztGesehen     = '" . time() . "',
							Land               = '" . $_POST['Land'] . "',
							GebTag             = '" . $_POST['GebTag'] . "',
							Firma              = '" . $_POST['Firma'] . "',
							UStPflichtig       = '" . $_POST['UStPflichtig'] . "',
							BenutzergruppeMisc = '" . @implode(';', $_REQUEST['BenutzergruppeMisc']) . "'
					");

					$host = explode('?', redirectLink());
					$message = $AVE_Globals->mainSettings('mail_new_user');
					$message = str_replace('%NAME%', $_POST['UserName'], $message);
					$message = str_replace('%HOST%', $host[0], $message);
					$message = str_replace('%KENNWORT%', $_POST['Kennwort'], $message);
					$message = str_replace('%EMAIL%', $_POST['Email'], $message);
					$message = str_replace('%EMAILFUSS%', $AVE_Globals->mainSettings('mail_signature'), $message);

					$AVE_Globals->cp_mail($_POST['Email'], $message, $GLOBALS['config_vars']['USER_MAIL_SUBJECT']);

					// Log
					reportLog($_SESSION['user_name'] . ' - Добавил пользователя (' . $_POST['UserName'] . ')', 2, 2);

					header('Location:index.php?do=user&cp=' . SESSION);
				}
				else
				{
					while (list($key, $val) = each($_POST))
					{
						$row->$key = htmlspecialchars(stripslashes($val));
					}

					$AVE_Template->assign('available_countries', $AVE_Globals->fetchCountries());
					$AVE_Template->assign('row', $row);
					$AVE_Template->assign('errors', $errors);
					$AVE_Template->assign('ugroups', $this->listAllGroups(2));
					$AVE_Template->assign('formaction', 'index.php?do=user&amp;action=new&amp;sub=save&amp;cp=' . SESSION);
					$AVE_Template->assign('content', $AVE_Template->fetch('user/form.tpl'));
				}
				break;

			case '':
				$AVE_Template->assign('available_countries', $AVE_Globals->fetchCountries());
				$AVE_Template->assign('ugroups', $this->listAllGroups(2));
				$AVE_Template->assign('formaction', 'index.php?do=user&amp;action=new&amp;sub=save&amp;cp=' . SESSION);
				$AVE_Template->assign('content', $AVE_Template->fetch('user/form.tpl'));
				break;
		}
	}

	function deleteUser($id)
	{
		global $AVE_DB;

		if ($id != 1)
		{
			$AVE_DB->Query("
				DELETE
				FROM " . PREFIX . "_users
				WHERE Id = '" . $id . "'
			");
			$AVE_DB->Query("
				DELETE
				FROM " . PREFIX . "_modul_forum_userprofile
				WHERE BenutzerId = '" . $id . "'
			");
			reportLog($_SESSION['user_name'] . ' - Удалил пользователя (' . $id . ')', 2, 2);
		}

		header('Location:index.php?do=user&cp=' . SESSION);
	}

	function quicksaveUser()
	{
		global $AVE_DB;

		foreach ($_POST['del'] as $id => $del)
		{
			$AVE_DB->Query("
				DELETE
				FROM " . PREFIX . "_users
				WHERE Id = '" . $id . "'
			");
			reportLog($_SESSION['user_name'] . ' - Удалил пользователя (' . $id . ')', 2, 2);
		}

		foreach ($_POST['Benutzergruppe'] as $id => $bG)
		{
			if (!empty($_POST['Benutzergruppe']))
			{
				$AVE_DB->Query("
					UPDATE " . PREFIX . "_users
					SET Benutzergruppe = '" . $_POST['Benutzergruppe'][$id] . "'
					WHERE Id='" . $id . "'
				");
				reportLog($_SESSION['user_name'] . ' - Изменил группу для пользователя (' . $id . ')', 2, 2);
			}
		}

		header('Location:index.php?do=user&cp=' . SESSION);
		exit;
	}
}

?>