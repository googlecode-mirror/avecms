<?php
/*::::::::::::::::::::::::::::::::::::::::
 System name: cpengine
 Short Desc: Full Russian Security Power Pack
 Version: 2.0 (Service Pack 2)
 Authors:  Arcanum (php@211.ru) &  Censored!
 Date: March 18, 2008
::::::::::::::::::::::::::::::::::::::::*/

if(!defined("DELPOST")) exit;
$NOOUT = -1;


$q_forum = "SELECT
	f.id,
	p.uid
	FROM
		" . PREFIX . "_modul_forum_forum AS f,
		" . PREFIX . "_modul_forum_topic AS t,
		" . PREFIX . "_modul_forum_post AS p
	WHERE
	t.id = '" . (int)$_GET['toid'] . "' AND
	t.forum_id = f.id AND
	p.id = '" . (int)$_GET['pid'] . "'";

$r_forum = $GLOBALS['AVE_DB']->Query($q_forum);
$forum = $r_forum->FetchRow();
$permissions = $this->getForumPermissionsByUser($forum->id, UID);
// $permissions = getForumPermissions($forum->id, UGROUP);


// wenn user andere beitraege nicht loeschen kann und kein admin ist ...
if( ($permissions[FORUM_PERMISSION_CAN_DELETE_OTHER_POST] == 0) && (UGROUP != 1) )
{
	// eigener beitrag
	if ($forum->uid == UID)
	{
		if (UGROUP == 2 || $permissions[FORUM_PERMISSION_CAN_DELETE_OWN_POST] == 0)
		{
			// user nicht eingeloggt
			$this->msg($GLOBALS['mod']['config_vars']['ErrornoPerm']);
		}
		// fremder eintrag
	}

	if ( ($forum->uid != UID) && (UGROUP != 1) )
	{
		$this->msg($GLOBALS['mod']['config_vars']['ErrornoPerm']);
	}


	if ($_GET["pid"] == "")
	{
		$this->msg($GLOBALS['mod']['config_vars']['ErrornoPerm']);
	}
}

if($NOOUT != 1)
{
	$q_delpost = "DELETE FROM " . PREFIX . "_modul_forum_post WHERE id = '" . (int)$_GET['pid'] . "'";
	$r_delpost = $GLOBALS['AVE_DB']->Query($q_delpost);

	$q_decrement = "UPDATE " . PREFIX . "_modul_forum_topic SET replies = replies - 1 WHERE id = '" . (int)$_GET['toid'] . "'";
	$r_decrement = $GLOBALS['AVE_DB']->Query($q_decrement);

	$q_topic = "SELECT replies FROM " . PREFIX . "_modul_forum_topic WHERE id = '" . (int)$_GET['toid'] . "'";
	$r_topic = $GLOBALS['AVE_DB']->Query($q_topic);
	$topic = $r_topic->FetchRow();

	$this->Cpengine_Board_SetLastPost($forum->id);
   	$NOOUT = 1;

	if ($topic->replies == 0)
	{
		$this->deleteTopic($_GET['toid']);
		header("Location:index.php?module=forums&show=showforum&fid=$forum->id");
		exit;
	} else {
		header("Location:index.php?module=forums&show=showtopic&toid=$_GET[toid]&fid=$_REQUEST[fid]");
		exit;
	}
}
?>
