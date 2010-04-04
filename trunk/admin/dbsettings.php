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

if (!checkPermission('gen_settings')) define('NOPERM', 1);

define('DUMPDIR', BASE_DIR . '/attachments/');

include_once(BASE_DIR . '/class/class.dbdump.php');
$AVE_SQL_Dump = new AVE_SQL_Dump;

if (@$_REQUEST['action']=='dboption')
{
	if (isset($_REQUEST['whattodo']) && $_REQUEST['whattodo']=='dump')
	{
		$dump = $AVE_SQL_Dump->writeDump();
		$AVE_SQL_Dump->getDump($dump);
		exit;
	}

	$AVE_SQL_Dump->optimizeRep();
	$tabellen = $AVE_SQL_Dump->showTables();
}
else
{
	$tabellen = $AVE_SQL_Dump->showTables();
}

if (isset($_REQUEST['restore']) && $_REQUEST['restore']==1)
{
	$AVE_SQL_Dump->dbRestore(DUMPDIR);
}

$AVE_Template->assign('tabellen', $tabellen);
$AVE_Template->config_load(BASE_DIR . '/admin/lang/' . $_SESSION['admin_lang'] . '/dbactions.txt', 'db');
$AVE_Template->assign('navi', $AVE_Template->fetch('navi/navi.tpl'));
$AVE_Template->assign('mysql_size', MySqlSize());
$AVE_Template->assign('content', $AVE_Template->fetch('dbactions/actions.tpl'));

?>