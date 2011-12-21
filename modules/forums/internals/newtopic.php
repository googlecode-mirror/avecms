<?php
/*::::::::::::::::::::::::::::::::::::::::
 System name: cpengine
 Short Desc: Full Russian Security Power Pack
 Version: 2.0 (Service Pack 2)
 Authors:  Arcanum (php@211.ru) &  Censored!
 Date: March 18, 2008
::::::::::::::::::::::::::::::::::::::::*/

if(!defined('NEWTOPIC')) exit;
if(isset($_REQUEST['fid']) && $_REQUEST['fid'] != '' && is_numeric($_REQUEST['fid']) && $_REQUEST['fid'] > 0)
{
	// forum id ьberprьfen
	$forum_result = $GLOBALS['AVE_DB']->Query("SELECT title, status FROM " . PREFIX . "_modul_forum_forum WHERE id = '" . $_REQUEST['fid'] . "'");
	$forum = $forum_result->FetchRow();

	// es wurde eine falsche fid ьbergeben
	if ($forum_result->NumRows() < 1)
	{
		header("Location:index.php?module=forums");
		exit;
	}

	if ( ($forum->status == FORUM_STATUS_CLOSED) )
	{
		$this->msg($GLOBALS['mod']['config_vars']['ErrorClosed'], 'index.php?module=forums&show=showforum&fid=' . $_GET['fid']);
	}

	// ====================================================================================
	// zugriffsrechte
	// ====================================================================================
	$cat_query = $GLOBALS['AVE_DB']->Query("SELECT group_id FROM " . PREFIX . "_modul_forum_forum WHERE id = '" . $_REQUEST['fid'] . "'");
	while ($category = $cat_query->FetchAssocArray())
	{
		// miscrechte
		$group_ids = array();
		include ( BASE_DIR . "/modules/forums/internals/misc_ids.php");

		$perm = false;
		$groups = explode(",", $category['group_id']);
		if (array_intersect($group_ids, $groups))
		{
			$permissions = $this->getForumPermissionsByUser(addslashes($_REQUEST['fid']), UID);
			if ($permissions[FORUM_PERMISSION_CAN_CREATE_TOPIC] == 1)
			{
				$perm = true;
			}
		}
	}

	// user hat keine berechtigung oder ist kein admin
	if ( $perm == false)
	{
		header("Location:index.php?module=forums");
		exit;
	}

	if (SMILIES == 1) $GLOBALS['AVE_Template']->assign("smilie", 1);

	// navigation erzeugen
	$navigation = $this->getNavigation(addslashes($_REQUEST['fid']), "forum");

	$GLOBALS['AVE_Template']->assign("permissions", $permissions);
	$GLOBALS['AVE_Template']->assign("bbcodes", BBCODESITE);
	$GLOBALS['AVE_Template']->assign("new_topic", 1);
	$GLOBALS['AVE_Template']->assign("navigation", $navigation . $GLOBALS['mod']['config_vars']['ForumSep'] . "<a class='forum_links_navi' href='index.php?module=forums&amp;show=showforum&amp;fid=" . addslashes($_REQUEST['fid']). "'>" . $forum->title . "</a>");
	$GLOBALS['AVE_Template']->assign("maxlength_post", MAXLENGTH_POST);
	$GLOBALS['AVE_Template']->assign("listfonts", $this->fontDropdown());
	$GLOBALS['AVE_Template']->assign("sizedropdown", $this->sizeDropdown());
	$GLOBALS['AVE_Template']->assign("colordropdown", $this->colorDropdown());
	$GLOBALS['AVE_Template']->assign("posticons", ( (defined("USEPOSTICONS") && USEPOSTICONS==1) ? $this->getPosticons() : ""));
	$GLOBALS['AVE_Template']->assign("listemos", $this->listSmilies());
	$GLOBALS['AVE_Template']->assign("forum_id", $_GET["fid"]);
	$GLOBALS['AVE_Template']->assign("topicform", $GLOBALS['AVE_Template']->fetch($GLOBALS['mod']['tpl_dir'] . "topicform.tpl"));
	$_POST['subject'] = htmlspecialchars($_POST['subject']);
  $GLOBALS['AVE_Template']->assign("threadform", $GLOBALS['AVE_Template']->fetch($GLOBALS['mod']['tpl_dir'] . "threadform.tpl"));
	$GLOBALS['AVE_Template']->assign("action", "index.php?module=forums&amp;show=addtopic");

	$tpl_out = $GLOBALS['AVE_Template']->fetch($GLOBALS['mod']['tpl_dir'] . 'addtopic.tpl');
	define("MODULE_CONTENT", $tpl_out);
	define("MODULE_SITE", $GLOBALS['mod']['config_vars']['NewThread']);

} else {
	header("Location:index.php?module=forums");
	exit;
}
?>