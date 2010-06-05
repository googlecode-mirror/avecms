<?php

if (!defined('BASE_DIR')) exit;

if (defined('ACP'))
{
    $modul['ModulName'] = 'Внутренняя рассылка';
    $modul['ModulPfad'] = 'newsletter_sys';
    $modul['ModulVersion'] = '1.0';
    $modul['Beschreibung'] = 'Данный модуль предназначен для массовой рассылки сообщений группам пользователей через Панель управления.';
    $modul['Autor'] = 'Arcanum';
    $modul['MCopyright'] = '&copy; 2007-2008 Overdoze.Ru';
    $modul['Status'] = 1;
    $modul['IstFunktion'] = 0;
    $modul['ModulTemplate'] = 0;
    $modul['AdminEdit'] = 1;
    $modul['ModulFunktion'] = null;
    $modul['CpEngineTagTpl'] = '';
    $modul['CpEngineTag'] = null;
    $modul['CpPHPTag'] = null;
}

if (defined('ACP') && isset($_REQUEST['module']) && $_REQUEST['module'] == 'newsletter_sys')
{
	require_once(BASE_DIR . '/modules/newsletter_sys/class.newsletter_admin.php');
	$newsletter = new systemNewsletter;

	if (defined('THEME_FOLDER')) $GLOBALS['AVE_Template']->assign('theme_folder', THEME_FOLDER);
	$_REQUEST['action'] = empty($_REQUEST['action']) ? 'overview' : $_REQUEST['action'];

	$tpl_dir        = BASE_DIR . '/modules/newsletter_sys/templates_admin/';
	$lang_file      = BASE_DIR . '/modules/newsletter_sys/lang/' . $_SESSION['admin_language'] . '.txt';


	$GLOBALS['AVE_Template']->config_load($lang_file, 'admin');
	$GLOBALS['AVE_Template']->assign('source', rtrim($tpl_dir, '/'));

	if (!(isset($_REQUEST['action']) && $_REQUEST['action'] == 'delete'))
	{
		if (!empty($_REQUEST['moduleaction']))
		{
			switch($_REQUEST['moduleaction'])
			{
				case '':
				case '1':
					$newsletter->sentList($tpl_dir);
					break;

				case 'new':
					include_once(BASE_DIR . '/class/class.user.php');
					$AVE_User = new AVE_User;
					$newsletter->sendNew($tpl_dir);
					break;

				case 'shownewsletter':
					$id = (int)$_REQUEST['id'];
					$format = ($_REQUEST['format'] == 'html') ? 'html' : 'text';
					$newsletter->showNewsletter($tpl_dir, $id, $format);
					break;

				case 'delete':
					$newsletter->deleteNewsletter();
					break;

				case 'getfile':
					$newsletter->getFile($_REQUEST['file']);
					break;
			}
		}
	}
}

?>