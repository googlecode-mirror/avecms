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

include_once(BASE_DIR . '/class/class.logs.php');
$AVE_Logs = new AVE_Logs;

$AVE_Template->assign('navi', $AVE_Template->fetch('navi/navi.tpl'));

$AVE_Template->config_load(BASE_DIR . '/admin/lang/' . $_SESSION['admin_lang'] . '/logs.txt', 'logs');
$config_vars = $AVE_Template->get_config_vars();
$AVE_Template->assign('config_vars', $config_vars);

$_REQUEST['sub']    = (!isset($_REQUEST['sub']))    ? '' : addslashes($_REQUEST['sub']);
$_REQUEST['action'] = (!isset($_REQUEST['action'])) ? '' : addslashes($_REQUEST['action']);
$_REQUEST['submit'] = (!isset($_REQUEST['submit'])) ? '' : addslashes($_REQUEST['submit']);

switch ($_REQUEST['action'])
{
	case '':
		if (permCheck('logs'))
		{
			$AVE_Logs->showLogs();
		}
		break;

	case 'delete':
		if (permCheck('logs'))
		{
			$AVE_Logs->deleteLogs();
		}
		break;

	case 'export':
		if (permCheck('logs'))
		{
			$AVE_Logs->logExport();
		}
		break;
}

?>