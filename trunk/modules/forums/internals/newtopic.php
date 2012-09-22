<?php

/**
 * 
 *
 * @package AVE.cms
 * @subpackage module_Forums
 * @filesource
 */
if(!defined('NEWTOPIC')) exit;
if(isset($_REQUEST['fid']) && $_REQUEST['fid'] != '' && is_numeric($_REQUEST['fid']) && $_REQUEST['fid'] > 0)
{
global $AVE_DB, $AVE_Template, $mod;
	// forum id ьberprьfen
	$forum_result = $AVE_DB->Query("SELECT title, status FROM " . PREFIX . "_modul_forum_forum WHERE id = '" . $_REQUEST['fid'] . "'");
	$forum = $forum_result->FetchRow();

	// es wurde eine falsche fid ьbergeben
	if ($forum_result->NumRows() < 1)
	{
		header("Location:index.php?module=forums");
		exit;
	}

	if ( ($forum->status == FORUM_STATUS_CLOSED) )
	{
		$this->msg($mod['config_vars']['ErrorClosed'], 'index.php?module=forums&show=showforum&fid=' . $_GET['fid']);
	}

	// ====================================================================================
	// zugriffsrechte
	// ====================================================================================
	$cat_query = $AVE_DB->Query("SELECT group_id FROM " . PREFIX . "_modul_forum_forum WHERE id = '" . $_REQUEST['fid'] . "'");
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

	if (SMILIES == 1) $AVE_Template->assign("smilie", 1);

	// navigation erzeugen
	$navigation = $this->getNavigation(addslashes($_REQUEST['fid']), "forum");

	$AVE_Template->assign("permissions", $permissions);
	$AVE_Template->assign("bbcodes", BBCODESITE);
	$AVE_Template->assign("new_topic", 1);
	$AVE_Template->assign("navigation", $navigation . $mod['config_vars']['ForumSep'] . "<a class='forum_links_navi' href='index.php?module=forums&amp;show=showforum&amp;fid=" . addslashes($_REQUEST['fid']). "'>" . $forum->title . "</a>");
	$AVE_Template->assign("maxlength_post", MAXLENGTH_POST);
	$AVE_Template->assign("listfonts", $this->fontDropdown());
	$AVE_Template->assign("sizedropdown", $this->sizeDropdown());
	$AVE_Template->assign("colordropdown", $this->colorDropdown());
	$AVE_Template->assign("posticons", ( (defined("USEPOSTICONS") && USEPOSTICONS==1) ? $this->getPosticons() : ""));
	$AVE_Template->assign("listemos", $this->listSmilies());
	$AVE_Template->assign("forum_id", $_GET["fid"]);
	$AVE_Template->assign("topicform", $AVE_Template->fetch($mod['tpl_dir'] . "topicform.tpl"));
	$_POST['subject'] = htmlspecialchars($_POST['subject']);
	$AVE_Template->assign("threadform", $AVE_Template->fetch($mod['tpl_dir'] . "threadform.tpl"));
	$AVE_Template->assign("action", "index.php?module=forums&amp;show=addtopic");

	$tpl_out = $AVE_Template->fetch($mod['tpl_dir'] . 'addtopic.tpl');
	define("MODULE_CONTENT", $tpl_out);
	define("MODULE_SITE", $mod['config_vars']['NewThread']);

} else {
	header("Location:index.php?module=forums");
	exit;
}
?>