<?php

/**
 * AVE.cms - Модуль Рассылки
 *
 * @package AVE.cms
 * @subpackage module_Newsletter
 * @author Arcanum
 * @since 2.01
 * @filesource
 */

if (!defined('BASE_DIR')) exit;

if (defined('ACP'))
{
    $modul['ModulName'] = 'Внутренняя рассылка';
    $modul['ModulPfad'] = 'newsletter';
    $modul['ModulVersion'] = '1.0';
    $modul['description'] = 'Данный модуль предназначен для массовой рассылки сообщений группам пользователей через Панель управления.';
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

if (defined('ACP')
	&& isset($_REQUEST['moduleaction'])
	&& ! (isset($_REQUEST['action']) && $_REQUEST['action'] == 'delete')
	&& (isset($_REQUEST['mod']) && $_REQUEST['mod'] == 'newsletter') )
{
	global $AVE_Template;

	include_once(BASE_DIR . '/modules/newsletter/class.newsletter.php');
	$newsletter = new Newsletter;

	if (defined('THEME_FOLDER')) $AVE_Template->assign('theme_folder', THEME_FOLDER);
	$_REQUEST['action'] = empty($_REQUEST['action']) ? 'overview' : $_REQUEST['action'];

	$tpl_dir   = BASE_DIR . '/modules/newsletter/templates/';
	$lang_file = BASE_DIR . '/modules/newsletter/lang/' . $_SESSION['admin_language'] . '.txt';

	$AVE_Template->config_load($lang_file, 'admin');
	$AVE_Template->assign('source', rtrim($tpl_dir, '/'));

	switch ($_REQUEST['moduleaction'])
	{
		case '':
		case '1':
			$newsletter->newsletterList($tpl_dir);
			break;

		case 'new':
			include_once(BASE_DIR . '/class/class.user.php');
			$AVE_User = new AVE_User;
			$newsletter->newsletterNew($tpl_dir);
			break;

		case 'shownewsletter':
			$newsletter->newsletterShow($tpl_dir, (int)$_REQUEST['id'], (isset($_REQUEST['nl_format']) && $_REQUEST['nl_format'] == 'html') ? 'html' : 'text');
			break;

		case 'delete':
			$newsletter->newsletterDelete();
			break;

		case 'getfile':
			$newsletter->_newsletterFileGet($_REQUEST['file']);
			break;
	}
}

?>