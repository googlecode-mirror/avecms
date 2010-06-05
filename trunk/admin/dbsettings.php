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

if (!check_permission('gen_settings')) define('NOPERM', 1);

$AVE_Template->config_load(BASE_DIR . '/admin/lang/' . $_SESSION['admin_language'] . '/dbactions.txt', 'db');

require(BASE_DIR . '/class/class.dbdump.php');
$AVE_DB_Service = new AVE_DB_Service;

if (!empty($_REQUEST['action']))
{
	switch ($_REQUEST['action'])
	{
		case 'optimize':
			$AVE_DB_Service->databaseTableOptimize();
			break;

		case 'repair':
			$AVE_DB_Service->databaseTableRepair();
			break;

		case 'dump':
			$AVE_DB_Service->databaseDumpExport();
			exit;

		case 'restore':
			$AVE_DB_Service->databaseDumpImport(BASE_DIR . '/attachments/');
			break;
	}
}

$AVE_Template->assign('db_size', MySqlSize());
$AVE_Template->assign('tables', $AVE_DB_Service->databaseTableGet());
$AVE_Template->assign('navi', $AVE_Template->fetch('navi/navi.tpl'));
$AVE_Template->assign('content', $AVE_Template->fetch('dbactions/actions.tpl'));

?>