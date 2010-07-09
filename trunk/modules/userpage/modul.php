<?php

if (!defined('BASE_DIR')) exit;

if (defined('ACP'))
{
    $modul['ModulName'] = 'Профиль';
    $modul['ModulPfad'] = 'userpage';
    $modul['ModulVersion'] = '1.0';
    $modul['description'] = 'Расширенная пользовательская система, полностью интегрируемая в модуль форума. Пользовательский профиль дополнен личной гостевой книгой и может модифицироваться индивидуально задаваемыми полями.';
    $modul['Autor'] = 'Michael Ruhl';
    $modul['MCopyright'] = '&copy; 2007 ecombiz.de';
    $modul['Status'] = 1;
    $modul['IstFunktion'] = 1;
    $modul['ModulTemplate'] = 1;
    $modul['AdminEdit'] = 1;
    $modul['ModulFunktion'] = null;
    $modul['CpEngineTagTpl'] = '<b>Ссылка:</b> <a target="_blank" href="../index.php?module=userpage&action=show&uid=' . UID . '">index.php?module=userpage&action=show&uid=XXX</a>';
    $modul['CpEngineTag'] = null;
    $modul['CpPHPTag'] = null;
}

if (isset($_REQUEST['module']) && $_REQUEST['module'] == 'userpage' && isset($_REQUEST['action']))
{
	global $AVE_DB, $AVE_Template;

	require_once(BASE_DIR . '/modules/userpage/class.userpage.php');
	require_once(BASE_DIR . '/modules/userpage/func/func.replace.php');

	$userpage = new userpage;

	$tpl_dir = BASE_DIR . '/modules/userpage/templates/';
	$lang_file = BASE_DIR . '/modules/userpage/lang/' . $_SESSION['user_language'] . '.txt';

	$sql_set = $AVE_DB->Query("SELECT * FROM " . PREFIX . "_modul_forum_settings");
	$row_set = $sql_set->FetchRow();

	$sql_gs = $AVE_DB->Query("
		SELECT *
		FROM " . PREFIX . "_modul_forum_grouppermissions
		WHERE user_group = '" . UGROUP . "'
	");
	$row_gs = $sql_gs->FetchRow();

	define ('MAX_AVATAR_WIDTH', $row_gs->MAX_AVATAR_WIDTH);
	define ('MAX_AVATAR_HEIGHT', $row_gs->MAX_AVATAR_WIDTH);
	define ('MAX_AVATAR_BYTES', $row_gs->MAX_AVATAR_BYTES);
	define ('SYSTEMAVATARS', $row_set->SystemAvatars);
	define ('UPLOADAVATAR', $row_gs->UPLOADAVATAR);
	define ('FORUMEMAIL', $row_set->AbsenderMail);
	define ('FORUMABSENDER', $row_set->AbsenderName);

	$AVE_Template->config_load($lang_file, 'user');
	$config_vars = $AVE_Template->get_config_vars();
	$AVE_Template->assign('config_vars', $config_vars);

	$_SESSION['forum_user_name'] = (isset($_SESSION['user_id'])) ? $userpage->fetchusername($_SESSION['user_id']) : $AVE_Template->get_config_vars('Guest');
	$_SESSION['forum_user_email'] = (isset($_SESSION['user_id'])) ? $userpage->getForumUserEmail($_SESSION['user_id']) : '';

	$userpage->UserOnlineUpdate();

	switch ($_REQUEST['action'])
	{
		// Userpage zeigen
		case 'show':
			$userpage->show($tpl_dir, $lang_file, addslashes($_REQUEST['uid']));
			break;

			// Form Eintrag
		case 'form':
			$userpage->displayForm($tpl_dir, addslashes($_REQUEST['uid']), $_REQUEST['theme_folder']);
			break;

			// Kontakt
		case 'contact':
			$userpage->showContact($tpl_dir, $_REQUEST['method'], addslashes($_REQUEST['uid']), $_REQUEST['theme_folder']);
			break;

			// Eintrag lцschen
		case 'del':
			$userpage->del_guest($tpl_dir, addslashes($_REQUEST['gid']), addslashes($_REQUEST['uid']), $_REQUEST['page']);
			break;

			// Userpage bearbeiten
		case 'change':
			$userpage->changeData($tpl_dir, $lang_file);
			break;
	}
}

//=======================================================
// Admin - Aktionen
//=======================================================
if (defined('ACP') && !empty($_REQUEST['moduleaction']))
{
	global $AVE_Template;

	require_once(BASE_DIR . '/modules/userpage/class.userpage.php');
	require_once(BASE_DIR . '/modules/userpage/func/func.replace.php');

	$tpl_dir = BASE_DIR . '/modules/userpage/templates/';
	$lang_file = BASE_DIR . '/modules/userpage/lang/' . $_SESSION['user_language'] . '.txt';

	$userpage = new userpage;

	$AVE_Template->config_load($lang_file, 'admin');
	$config_vars = $AVE_Template->get_config_vars();
	$AVE_Template->assign('config_vars', $config_vars);

	switch ($_REQUEST['moduleaction'])
	{
		// Einstellungen
		case '1':
			$userpage->showSetting($tpl_dir);
			break;

			// Neues Feld
		case 'save_new':
			$userpage->saveFieldsNew($tpl_dir);
			break;

			// Speichern
		case 'save':
			$userpage->saveSetting($tpl_dir);
			break;

			// Template
		case 'tpl':
			$userpage->showTemplate($tpl_dir);
			break;

			// Autoupdate
		case 'update':
			$userpage->update($tpl_dir);
			break;
	}
}

?>