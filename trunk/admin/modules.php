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

require(BASE_DIR . '/class/class.modules.php');
$AVE_Module = new AVE_Module;

$AVE_Template->config_load(BASE_DIR . '/admin/lang/' . $_SESSION['admin_language'] . '/modules.txt', 'modules');

if (!empty($_REQUEST['moduleaction']))
{
	if (!check_permission('mod_' . $_REQUEST['mod']))
	{
		echo $AVE_Template->get_config_vars('MAIN_NO_PERM_MODULES');
		exit;
	}
}

if (!empty($_REQUEST['module'])) define('MODULE_PATH', $_REQUEST['module']);

switch($_REQUEST['action'])
{
	case '':
		if (permCheck('modules'))
		{
			$AVE_Module->moduleList();
		}
		break;

	case 'quicksave':
		if (permCheck('modules_admin'))
		{
			$AVE_Module->moduleOptionsSave();
		}
		break;

	case 'install':
		if (permCheck('modules_admin'))
		{
			$AVE_Module->moduleInstall();
		}
		break;

	case 'reinstall':
		if (permCheck('modules_admin'))
		{
			$AVE_Module->moduleInstall();
		}
		break;

	case 'update':
		if (permCheck('modules_admin'))
		{
			$AVE_Module->moduleUpdate();
		}
		break;

	case 'delete':
		if (permCheck('modules_admin'))
		{
			$AVE_Module->moduleDelete();
		}
		break;

	case 'onoff':
		if (permCheck('modules_admin'))
		{
			$AVE_Module->moduleStatusChange();
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