<?php

/**
 * AVE.cms
 *
 * @package AVE.cms
 * @subpackage admin
 * @filesource
 */

if(!defined('ACP')) {header('Location:index.php'); exit;}

include_once(BASE_DIR . '/class/class.dbdump.php');
include_once(BASE_DIR . '/class/class.settings.php');

$AVE_Settings = new AVE_Settings;

include_once(BASE_DIR . '/admin/inc/pre.inc.php');

function getDump($string)
{
	header('Content-Type:text/plain');
	header('Expires: ' . gmdate('D, d M Y H:i:s') . ' GMT');
	header('Content-Disposition: attachment; filename="backup.sql"');
	header('Content-Length: ' . strlen($string));
	header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
	header('Pragma: public');
	echo $string;
	exit;
}

switch($_REQUEST['action'])
{
	case '':
		if(permCheck('gen_settings'))
		{
			$AVE_Template->config_load(BASE_DIR . '/admin/lang/' . $_SESSION['admin_lang'] . '/settings.txt', 'settings');
			$AVE_Settings->displaySettings();
		}
		break;
}
?>