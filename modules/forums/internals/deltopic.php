<?php

/**
 * 
 *
 * @package AVE.cms
 * @subpackage module_Forums
 * @filesource
 */
if(!defined("DELTOPIC")) exit;

global $AVE_DB, $mod;

$NOOUT = 0;
if(!isset($_REQUEST['fid']) || !isset($_REQUEST['toid']) || !is_numeric($_REQUEST['fid']) || !is_numeric($_REQUEST['toid']) )
{
	header("Location:index.php?module=forums");
	exit;
}
$own = -1;

$sql = $AVE_DB->Query("SELECT uid FROM ".PREFIX."_modul_forum_topic WHERE id='" . $_REQUEST['toid'] . "'");
$row = $sql->FetchRow();

if($row->uid == UID)
{
	$own = 1;
}

$f_id = $_REQUEST['fid'];

//=========================================================
// zugriffsrechte
//=========================================================
$cat_query = $AVE_DB->Query("SELECT group_id FROM " . PREFIX . "_modul_forum_forum WHERE id = '" . $f_id . "'");
while ($category = $cat_query->FetchAssocArray()) {

	//=========================================================
	// miscrechte
	//=========================================================
	include (BASE_DIR . "/modules/forums/internals/misc_ids.php");
	$groups = explode(",", $category['group_id']);
	if (array_intersect($group_ids, $groups))
	{
		$permissions = $this->getForumPermissionsByUser($f_id, UID);
	}
}

if($own != 1)
{
	//=========================================================
	// Keine Rechte
	//=========================================================
	if ($permissions[FORUM_PERMISSIONS_CAN_DELETE_TOPIC] == 0)
	{
		header("Location:index.php?module=forums");
		exit;
	}
}
else
{
	//=========================================================
	// Keine Rechte
	//=========================================================
	if ($permissions[FORUM_PERMISSION_CAN_DELETE_OWN_TOPIC] == 0)
	{
		header("Location:index.php?module=forums");
		exit;
	}
}

if($NOOUT != 1)
{
	//=========================================================
	// Keine ID angegeben
	//=========================================================
	if ($_REQUEST["toid"] == "" || $_GET["fid"] == "")
	{
		$this->msg($mod['config_vars']['FORUMS_ERROR_NO_PERM']);
	}

    $Board_ID = $this->Cpengine_Board_GetTopic_Board($_GET['toid']);
	$this->deleteTopic($_GET["toid"]);
   	$this->Cpengine_Board_SetLastPost($Board_ID);

	//=========================================================
	// Thema gelцscht, weiterleiten...
	//=========================================================
	header("Location:index.php?module=forums&show=showforum&fid=" . $_REQUEST['fid']);
	exit;
}
?>