<?php

if (!defined('BASE_DIR')) exit;

if (defined('ACP'))
{
    $modul['ModulName'] = 'Карта проектов';
    $modul['ModulPfad'] = 'roadmap';
    $modul['ModulVersion'] = '1.0';
    $modul['description'] = 'Данный модуль предназначен для организации карты проектов с текущими задачами. Вы можете создавать неограниченное количество проектов с неограниченным количеством задач. Все проекты с вложенными задачами могут быть отображены в публичной части сайта.';
    $modul['Autor'] = 'Arcanum';
    $modul['MCopyright'] = '&copy; 2007-2008 Overdoze.Ru';
    $modul['Status'] = 1;
    $modul['IstFunktion'] = 1;
    $modul['ModulTemplate'] = 1;
    $modul['AdminEdit'] = 1;
    $modul['ModulFunktion'] = null;
    $modul['CpEngineTagTpl'] = '<b>Ссылка:</b> <a target="_blank" href="../index.php?module=roadmap">index.php?module=roadmap</a>';
    $modul['CpEngineTag'] = null;
    $modul['CpPHPTag'] = null;
}

if (!defined('ACP') && isset($_REQUEST['module']) && $_REQUEST['module'] == 'roadmap')
{
	require_once(BASE_DIR . '/modules/roadmap/class.roadmap.php');

	$roadmap = new Roadmap;

	$tpl_dir   = BASE_DIR . '/modules/roadmap/templates/';
	$lang_file = BASE_DIR . '/modules/roadmap/lang/' . $_SESSION['user_language'] . '.txt';

	$AVE_Template->config_load($lang_file);

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

	define('MODULE_SITE', 'Карта проектов');
}

if (defined('ACP') && !empty($_REQUEST['moduleaction']))
{
	require_once(BASE_DIR . '/modules/roadmap/class.roadmap.php');

	$roadmap = new Roadmap;

	$tpl_dir   = BASE_DIR . '/modules/roadmap/templates/';
	$lang_file = BASE_DIR . '/modules/roadmap/lang/' . $_SESSION['user_language'] . '.txt';

	$AVE_Template->config_load($lang_file);

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