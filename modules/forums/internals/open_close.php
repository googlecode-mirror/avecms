<?php

/**
 * 
 *
 * @package AVE.cms
 * @subpackage module_Forums
 * @filesource
 */
if(!defined("OPENCLOSETOPIC")) exit;

global $AVE_DB, $mod;

if(!isset($_REQUEST['fid']) || !isset($_REQUEST['toid']) || !is_numeric($_REQUEST['fid']) || !is_numeric($_REQUEST['toid']) )
{
	header("Location:index.php?module=forums");
	exit;
}

$f_id = addslashes($_REQUEST['fid']);
$permissions = $this->getForumPermissionsByUser($f_id, UID);

if ( (UGROUP == 2) || ($permissions[FORUM_PERMISSIONS_CAN_OPEN_TOPIC] == 0) )
{
	$this->msg($mod['config_vars']['ErrornoPerm']);
}

switch($openclose)
{
	case 'open':
		$status = FORUM_STATUS_OPEN;
		$r_opentopic = $AVE_DB->Query("UPDATE " . PREFIX . "_modul_forum_topic SET status = $status WHERE id = '" . addslashes($_GET['toid']) . "'");
	break;

	case 'close':
		$status = FORUM_STATUS_CLOSED;
		$r_opentopic = $AVE_DB->Query("UPDATE " . PREFIX . "_modul_forum_topic SET status = $status WHERE id = '" . addslashes($_GET['toid']) . "'");
	break;
}

header("Location:" . $_SERVER['HTTP_REFERER']);
exit;
?>