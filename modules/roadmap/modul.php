<?php

if (!defined('BASE_DIR')) exit;

if (defined('ACP'))
{
    $modul['ModulName'] = ' арта проектов';
    $modul['ModulPfad'] = 'roadmap';
    $modul['ModulVersion'] = '1.0';
    $modul['description'] = 'ƒанный модуль предназначен дл€ организации карты проектов с текущими задачами. ¬ы можете создавать неограниченное количество проектов с неограниченным количеством задач. ¬се проекты с вложенными задачами могут быть отображены в публичной части сайта.';
    $modul['Autor'] = 'Arcanum';
    $modul['MCopyright'] = '&copy; 2007-2008 Overdoze.Ru';
    $modul['Status'] = 1;
    $modul['IstFunktion'] = 1;
    $modul['ModulTemplate'] = 1;
    $modul['AdminEdit'] = 1;
    $modul['ModulFunktion'] = null;
    $modul['CpEngineTagTpl'] = '<b>—сылка:</b> <a target="_blank" href="../index.php?module=roadmap">index.php?module=roadmap</a>';
    $modul['CpEngineTag'] = null;
    $modul['CpPHPTag'] = null;
}

if (isset($_REQUEST['module']) && $_REQUEST['module'] != '' && $_REQUEST['module'] == 'roadmap')
{
	require_once(BASE_DIR . '/modules/roadmap/class.roadmap.php');

	$roadmap = new Roadmap;

	$tpl_dir   = BASE_DIR . '/modules/roadmap/templates/';
	$lang_file = BASE_DIR . '/modules/roadmap/lang/' . $_SESSION['user_language'] . '.txt';

	$AVE_Template->config_load($lang_file);
//	$config_vars = $AVE_Template->get_config_vars();
//	$AVE_Template->assign('config_vars', $config_vars);

	switch ($_REQUEST['action'])
	{
		case 'show_p':
		default:
			$roadmap->roadmapProjectShow($tpl_dir);
			break;

		case 'show_t':
			$roadmap->roadmapTaskShow($tpl_dir, $_REQUEST['pid'], $_REQUEST['closed']);
			break;
	}

	define('MODULE_SITE', ' арта проектов');
}

if (defined('ACP') && !empty($_REQUEST['moduleaction']))
{
	require_once(BASE_DIR . '/modules/roadmap/class.roadmap.php');

	$tpl_dir   = BASE_DIR . '/modules/roadmap/templates/';
	$lang_file = BASE_DIR . '/modules/roadmap/lang/' . $_SESSION['user_language'] . '.txt';

	$roadmap = new Roadmap;

	$AVE_Template->config_load($lang_file);
//	$config_vars = $AVE_Template->get_config_vars();
//	$AVE_Template->assign('config_vars', $config_vars);

	switch($_REQUEST['moduleaction'])
	{
		case '1':
			$roadmap->roadmapProjectList($tpl_dir);
			break;

		case 'edit_project':
			$roadmap->roadmapProjectEdit($tpl_dir, $_REQUEST['id']);
			break;

		case 'new_project':
			$roadmap->roadmapProjectNew($tpl_dir);
			break;

		case 'del_project':
			$roadmap->roadmapProjectDelete($_REQUEST['id']);
			break;

		case 'show_tasks':
			$roadmap->roadmapTaskList($tpl_dir, $_REQUEST['id'], $_REQUEST['closed']);
			break;

		case 'new_task':
			$roadmap->roadmapTaskNew($tpl_dir, $_REQUEST['id']);
			break;

		case 'edit_task':
			$roadmap->roadmapTaskEdit($tpl_dir, $_REQUEST['id']);
			break;

		case 'del_task':
			$roadmap->roadmapTaskDelete($_REQUEST['id'], $_REQUEST['pid'], $_REQUEST['closed']);
			break;
	}
}

?>