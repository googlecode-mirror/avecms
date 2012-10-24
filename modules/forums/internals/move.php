<?php

/**
 * 
 *
 * @package AVE.cms
 * @subpackage module_Forums
 * @filesource
 */
if(!defined("MOVETOPIC")) exit;

global $AVE_DB, $AVE_Template, $mod;

if(!isset($_REQUEST['fid']) || !isset($_REQUEST['toid']) || !is_numeric($_REQUEST['fid']) || !is_numeric($_REQUEST['toid']) )
{
	header("Location:index.php?module=forums");
	exit;
}

$NOOUT = 2;
$own   = -1;

$type = addslashes($_REQUEST['item']);
$f_id = addslashes($_REQUEST['fid']);

$sql = $AVE_DB->Query("SELECT uid FROM ".PREFIX."_modul_forum_topic WHERE id='".addslashes($_REQUEST['toid'])."'");
$row = $sql->FetchRow();

if($row->uid == UID)
{
	$own = 1;
}

//=========================================================
// zugriffsrechte
//=========================================================
$cat_query = $AVE_DB->Query("SELECT group_id FROM " . PREFIX . "_modul_forum_forum WHERE id = '" . $f_id . "'");
while ($category = $cat_query->FetchAssocArray())
{
	// miscrechte
	include (BASE_DIR . "/modules/forums/internals/misc_ids.php");

	$groups = explode(",", $category['group_id']);
	if (array_intersect($group_ids, $groups))
	{
		$permissions = $this->getForumPermissionsByUser($f_id, UID);
	}
}

if($own != 1)
{
	//=======================================================
	// Keine Rechte
	//=======================================================
	if ($permissions[FORUM_PERMISSIONS_CAN_MOVE_TOPIC] == 0)
	{
		$this->msg($mod['config_vars']['FORUMS_ERROR_NO_PERM']);
	}
}
else
{
	//=======================================================
	// Keine Rechte
	//=======================================================
	if ($permissions[FORUM_PERMISSION_CAN_MOVE_OWN_TOPIC] == 0)
	{
		$this->msg($mod['config_vars']['FORUMS_ERROR_NO_PERM']);
	}
}

if($NOOUT != 1)
{
	if (isset($_GET["action"]) && $_GET["action"] == "commit")
	{
        $Source_Board = $this->Cpengine_Board_GetTopic_Board($_REQUEST['toid']);
        $r_commit = $AVE_DB->Query("UPDATE " . PREFIX . "_modul_forum_topic SET forum_id = '".addslashes($_REQUEST['dest'])."' WHERE id = '".addslashes($_REQUEST['toid'])."'");

        //=======================================================
		// Letzten Beitra setzen
		//=======================================================
		$this->Cpengine_Board_SetLastPost($_REQUEST['dest']);
		$this->Cpengine_Board_SetLastPost($Source_Board);

		//=======================================================
		// Zum Beitrag im neuen Forum leiten
		//=======================================================
		header("Location:index.php?module=forums&show=showtopic&toid=" . $_REQUEST['toid'] . "&fid=" . $_REQUEST['dest'] . "");
		exit;
	}
	else
	{
		$r_item = $AVE_DB->Query("SELECT id, title FROM " . PREFIX . "_modul_forum_topic WHERE id = '".addslashes($_REQUEST['toid'])."'");
		$item = $r_item->FetchRow();

		$r_dest = $AVE_DB->Query("SELECT id, title FROM " . PREFIX . "_modul_forum_forum");
		$destinations = array();

		while ($destination = $r_dest->FetchRow())
		{
			array_push($destinations, $destination);
		}

		//=======================================================
		// foren fuer das dropdown feld
		//=======================================================
		$forums_dropdown = array();
		$this->getForums(0, $forums_dropdown, "", $f_id);

		$categories = array();
		$this->getCategories(0, $categories, "");
		$AVE_Template->assign("categories_dropdown", $categories);
		$AVE_Template->assign("item", $item);
		$AVE_Template->assign("backlink", $_SERVER['HTTP_REFERER']);
		$AVE_Template->assign("navigation", $this->getNavigation(addslashes($_GET['toid']), "topic"));
		$AVE_Template->assign("destinations", $destinations);

		$tpl_out = $AVE_Template->fetch($mod['tpl_dir'] . $this->_MoveTpl);

		define("MODULE_CONTENT", $tpl_out);
		define("MODULE_SITE", $mod['config_vars']['FORUMS_MOVE_TOPIC']);
	}
}
?>