<?php

/**
 * AVE.cms
 *
 * @package AVE.cms
 * @subpackage admin
 * @filesource
 */

if (!defined('ACP'))
{
	header('Location:index.php');
	exit;
}

include_once(BASE_DIR . '/class/class.modules.php');
$AVE_Module = new AVE_Module;

$AVE_Template->config_load(BASE_DIR . '/admin/lang/' . $_SESSION['admin_lang'] . '/modules.txt', 'modules');
include_once(BASE_DIR . '/admin/inc/pre.inc.php');

if (!empty($_REQUEST['moduleaction']))
{
//	$r_module = 'mod_' . $_REQUEST['mod'];
	if (!checkPermission('mod_' . $_REQUEST['mod']))
	{
		echo $config_vars['MAIN_NO_PERM_MODULES'];
		exit;
	}
}

if (!empty($_REQUEST['module'])) define('MODULE_PATH', $_REQUEST['module']);

switch($_REQUEST['action'])
{
	case '':
		if (permCheck('modules'))
		{
			$AVE_Module->showModules();
		}
		break;

	case 'quicksave':
		if (permCheck('modules_admin'))
		{
			$AVE_Module->quickSave();
		}
		break;

	case 'install':
		if (permCheck('modules_admin'))
		{
			$AVE_Module->installModule();
		}
		break;

	case 'reinstall':
		if (permCheck('modules_admin'))
		{
			$AVE_Module->installModule();
		}
		break;

	case 'update':
		if (permCheck('modules_admin'))
		{
			$AVE_Module->updateModule();
		}
		break;

	case 'delete':
		if (permCheck('modules_admin'))
		{
			$AVE_Module->deleteModule();
		}
		break;

	case 'onoff':
		if (permCheck('modules_admin'))
		{
			$AVE_Module->OnOff();
		}
		break;

	case 'modedit':
		if (permCheck('modules'))
		{
			include(BASE_DIR . '/modules/' . $_REQUEST['mod'] . '/modul.php');
		}
		break;
}

?>