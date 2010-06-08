<?php
/*::::::::::::::::::::::::::::::::::::::::
 System name: cpengine
 Short Desc: Full Russian Security Power Pack
 Version: 2.0 (Service Pack 2)
 Authors:  Arcanum (php@211.ru) &  Censored!
 Date: March 18, 2008
::::::::::::::::::::::::::::::::::::::::*/

if(!defined("NEWPOST")) exit;

$q_closed = "SELECT
		f.id,
		f.status AS fstatus,
		t.status AS tstatus,
		t.id AS TopicFid,
		t.uid,
		t.title
	FROM
		" . PREFIX . "_modul_forum_forum AS f,
		" . PREFIX . "_modul_forum_topic AS t
	WHERE
		t.id = '" . addslashes($_GET["toid"]) . "' AND f.id = t.forum_id";
$r_closed = $GLOBALS['AVE_DB']->Query($q_closed);
$closed = $r_closed->FetchRow();

if(!is_object($closed))
{
	$this->msg($GLOBALS['mod']['config_vars']['ErrorTopicWrong']);
}

$TopicTitle = stripslashes($closed->title);
$TopicFid = $closed->id;

// ist user moderator
$is_moderator = false;
$result =  $GLOBALS['AVE_DB']->Query("SELECT user_id FROM " . PREFIX . "_modul_forum_mods WHERE forum_id = '" . $closed->id . "'");
while ($user = $result->FetchRow())
{
	if ($user->user_id == UID) $is_moderator = true;
}

// =========================================================
// <<-- forum geschlossen -->>
// =========================================================

if ( ($closed->fstatus == FORUM_STATUS_CLOSED)  && (UGROUP != 1) && !$is_moderator)
{
	$this->msg($GLOBALS['mod']['config_vars']['ErrornoPerm']);
}

// =========================================================
// <<-- topic geschlossen -->>
// =========================================================
if ( ($closed->tstatus == FORUM_STATUS_CLOSED) && (UGROUP != 1) && !$is_moderator)
{
	$this->msg($GLOBALS['mod']['config_vars']['ErrornoPerm']);
}

// =========================================================
// <<-- gibt es den topic und das posting ueberhaupt schon -->>
// =========================================================
if (!$this->topicExists($_GET['toid']))
{
	$this->msg($GLOBALS['mod']['config_vars']['ErrorTopicWrong']);
}


// =========================================================
// <<-- zugriffsrechte -->>
// =========================================================
$permissions = $this->getForumPermissionsByUser($closed->id, UID);
$cat_query = $GLOBALS['AVE_DB']->Query("SELECT group_id FROM " . PREFIX . "_modul_forum_forum WHERE id = '" . $closed->id . "'");
while ($category = $cat_query->FetchAssocArray())
{
	// miscrechte
	include (BASE_DIR . "/modules/forums/internals/misc_ids.php");

	$groups = explode(",", $category['group_id']);
	if (array_intersect($group_ids, $groups))
	{
		@$permissions[FORUM_PERMISSION_CAN_SEE] = 1;
	}

	if (@$permissions[FORUM_PERMISSION_CAN_SEE] == 0)
	{
		$this->msg($GLOBALS['mod']['config_vars']['ErrornoPerm']);
	}
}

// =========================================================

// =========================================================
// <<-- wenn benutzer der verfasser des themas ist -->>
// =========================================================
if ($closed->uid == UID) {
	// kann auf eigene themen antworten
	if (@$permissions[FORUM_PERMISSION_CAN_REPLY_OWN_TOPIC] == 0)
	{
		$this->msg($GLOBALS['mod']['config_vars']['ErrornoPerm']);
	}
} else {
	// kann auf andere themen antworten
	if (@$permissions[FORUM_PERMISSION_CAN_REPLY_OTHER_TOPIC] == 0)
	{
		$this->msg($GLOBALS['mod']['config_vars']['ErrornoPerm']);
	}
}


// ueberpruefung der rechte und des datums
if (isset($_GET['action']) && $_GET['action'] == "edit")
{
	$q_information = "SELECT
		u.BenutzerId,
		UNIX_TIMESTAMP(p.datum) AS datum,
		UNIX_TIMESTAMP(NOW()) AS today
	FROM
		" . PREFIX . "_modul_forum_post AS p,
		" . PREFIX . "_modul_forum_userprofile AS u
	WHERE
		p.id = '" . $_GET["pid"] . "' AND
		u.BenutzerId = p.uid
	";

	$r_information = $GLOBALS['AVE_DB']->Query($q_information);
	$information = $r_information->FetchRow();

	$curr_unix_stamp = $information->today;
	$post_unix_stamp = $information->datum;

	// zeitdifferenz in stunden
	// zu einem integer casten
	$time_diff = (int) (($curr_unix_stamp - $post_unix_stamp) / 60 / 60);

	// wenn user andere beitraege nicht bearbeiten kann und kein admin ist ...
	if( ($permissions[FORUM_PERMISSION_CAN_EDIT_OTHER_POST] == 0) && (UGROUP != 1) )
	{
		// wenn nicht der beitragverfasser und der benutzer ist kein admin
		if ($information->BenutzerId == UID && $permissions[FORUM_PERMISSION_CAN_EDIT_OWN_POST] == 0)
		{
			$this->msg($GLOBALS['mod']['config_vars']['ErrornoPerm']);
		}

		// wenn nicht der beitragverfasser und der benutzer ist kein admin
		if ($information->BenutzerId != UID && UGROUP != 1 && !$is_moderator)
		{
			$this->msg($GLOBALS['mod']['config_vars']['ErrornoPerm']);
		}

		// wenn die zeit fuer die editierung abgelaufen ist und
		// der benutzer ist kein admin
		if ($time_diff >= MAX_EDIT_PERIOD && UGROUP != 1 && !$is_moderator)
		{
			$this->msg($GLOBALS['mod']['config_vars']['ErrorCannotEdit']);
		}
	}
}

if (SMILIES == 1) $GLOBALS['AVE_Template']->assign("smilie", 1);

if (isset($_GET['pid']) && !empty($_GET['pid'])) {

	// wir moechten nicht, dass der user bei einem zitat die anhaenge des posters angehaengt bekommt...
	$attachment = (isset($_REQUEST['action']) && $_REQUEST['action']=="quote") ? '' : "p.attachment,";

	$q_message = "SELECT
		u.BenutzerName,
		p.message,
		p.title,
		$attachment
		t.title AS topic,
		t.posticon,
		t.uid
	FROM
		" . PREFIX . "_modul_forum_post AS p,
		" . PREFIX . "_modul_forum_userprofile AS u,
		" . PREFIX . "_modul_forum_topic AS t
	WHERE
		p.id = '" . $_GET["pid"] . "' AND
		p.uid = u.BenutzerId AND
		t.id = p.topic_id";

	$r_message = $GLOBALS['AVE_DB']->Query($q_message);
	$message = $r_message->FetchRow();

	if (isset($_GET["action"]) && $_GET["action"] == "quote")
	{
		$message->message = "[QUOTE][B]" . $GLOBALS['mod']['config_vars']['QuotePrefix'] . " " . $message->BenutzerName . "[/B]\n ". htmlspecialchars($message->message) . "[/QUOTE]\n\n";
	}
	elseif (isset($_GET["action"]) && $_GET["action"] == "edit")
	{
		if(is_object($message) && $message->message != '')
		{
		  $message->message = htmlspecialchars($message->message);
		}
	  $attach = (is_object($message) && $message->attachment != '') ? explode(";", $message->attachment) : '';
		if(is_object($message) && $message->attachment != '')
		{
			foreach($attach as $attachment)
			{
				$sql = $GLOBALS['AVE_DB']->Query("SELECT * FROM " . PREFIX ."_modul_forum_attachment WHERE id='$attachment'");
				$row_a = $sql->FetchRow();

				$h_attachments_only_show[] = '
				<div id="div_'.$row_a->id.'" style="display:">
				<input type="hidden" name="attach_hidden[]" id="att_'.$row_a->id.'" value="'.$row_a->id.'" />
				&bull; '.$row_a->orig_name.'
				<a href="javascript:;"
				onclick="if(confirm(\''.$GLOBALS['mod']['config_vars']['ConfirmDelAttach'].'\'))
				{
					document.getElementById(\'att_' . $row_a->id . '\').value=\'\';
					document.getElementById(\'div_' . $row_a->id . '\').style.display=\'none\';
					document.getElementById(\'hidden_count\').value = document.getElementById(\'hidden_count\').value - 1;
				}
				;"><img src="templates/'.THEME_FOLDER.'/modules/forums/forum/del_attach.gif" alt="" border="0" hspace="2" /></a>
				</div>';
			}

			$GLOBALS['AVE_Template']->assign("h_attachments_only_show", $h_attachments_only_show);
			$GLOBALS['AVE_Template']->assign("attachments_hidden", $message->attachment);// $message = $message->message;
		}

	}

	$GLOBALS['AVE_Template']->assign("message", $message);
	$GLOBALS['AVE_Template']->assign("f_id", $closed->id);
}

// hat user thema abonniert?
$sql = $GLOBALS['AVE_DB']->Query("SELECT notification FROM " . PREFIX . "_modul_forum_topic WHERE id = '$_GET[toid]'");
$row = $sql->FetchRow();
$notifactions = @explode(";", $row->notification);

if(@in_array(UID, $notifactions))
{
	$GLOBALS['AVE_Template']->assign('notification', 1);
}

$navigation = $this->getNavigation($_GET["toid"], "topic")
	. $GLOBALS['mod']['config_vars']['ForumSep']
	. "<a class='forum_links_navi' href='index.php?module=forums&amp;show=showtopic&amp;toid=" . $_GET['toid'] . "&amp;fid=" . $TopicFid. "'>" . $TopicTitle . "</a>"
	. $GLOBALS['mod']['config_vars']['ForumSep']
	. $GLOBALS['mod']['config_vars']['ReplyToPost'];

if(isset($_REQUEST['preview']) && $_REQUEST['preview']==1)
{
	$GLOBALS['AVE_Template']->assign("subject", $_REQUEST['subject']);
	$GLOBALS['AVE_Template']->assign("text", $_REQUEST['text']);
}

$items = array();
include (BASE_DIR . "/modules/forums/internals/addpost_last.php");

$GLOBALS['AVE_Template']->assign("aid", $closed->uid);
$GLOBALS['AVE_Template']->assign("items", $items);
$GLOBALS['AVE_Template']->assign("permissions", $permissions);
$GLOBALS['AVE_Template']->assign("maxlength_post", MAXLENGTH_POST);
$GLOBALS['AVE_Template']->assign("bbcodes", BBCODESITE);
$GLOBALS['AVE_Template']->assign("navigation", $navigation);
$GLOBALS['AVE_Template']->assign("max_post_length", MAXLENGTH_POST);
$GLOBALS['AVE_Template']->assign("listfonts",  $this->fontdropdown());
$GLOBALS['AVE_Template']->assign("sizedropdown",  $this->sizedropdown());
$GLOBALS['AVE_Template']->assign("colordropdown",  $this->colordropdown());
$GLOBALS['AVE_Template']->assign("listemos", $this->listsmilies());
$GLOBALS['AVE_Template']->assign("topic_id", $_GET["toid"]);
$GLOBALS['AVE_Template']->assign("forum_id", $TopicFid);
$GLOBALS['AVE_Template']->assign("action", "index.php?module=forums&amp;show=addpost");

$_POST['subject'] = isset($_POST['subject']) ? htmlspecialchars($_POST['subject']) : '';
$GLOBALS['AVE_Template']->assign("threadform", $GLOBALS['AVE_Template']->fetch($GLOBALS['mod']['tpl_dir'] . "threadform.tpl"));

if (isset($_GET['action']) && $_GET['action'] == "edit")
{
	if ($message->uid == UID || UGROUP == 1 || $is_moderator)
	{
		$GLOBALS['AVE_Template']->assign("topic", $message->topic);
		$GLOBALS['AVE_Template']->assign("posticons", $this->getPosticons($message->posticon));
		$GLOBALS['AVE_Template']->assign("topicform", $GLOBALS['AVE_Template']->fetch($GLOBALS['mod']['tpl_dir'] . "topicform.tpl"));
	}
}

$tpl_out = $GLOBALS['AVE_Template']->fetch($GLOBALS['mod']['tpl_dir'] . 'addtopic.tpl');
define("MODULE_CONTENT", $tpl_out);
define("MODULE_SITE", $GLOBALS['mod']['config_vars']['ReplyToPost']);
?>