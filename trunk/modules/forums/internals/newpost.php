<?php

/**
 * 
 *
 * @package AVE.cms
 * @subpackage module_Forums
 * @filesource
 */
if(!defined("NEWPOST")) exit;

global $AVE_DB, $AVE_Template, $mod;

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
$r_closed = $AVE_DB->Query($q_closed);
$closed = $r_closed->FetchRow();

if(!is_object($closed))
{
	$this->msg($mod['config_vars']['FORUMS_ERROR_TOPIC_WRONG']);
}

$TopicTitle = stripslashes($closed->title);
$TopicFid = $closed->id;

// ist user moderator
$is_moderator = false;
$result =  $AVE_DB->Query("SELECT user_id FROM " . PREFIX . "_modul_forum_mods WHERE forum_id = '" . $closed->id . "'");
while ($user = $result->FetchRow())
{
	if ($user->user_id == UID) $is_moderator = true;
}

// =========================================================
// <<-- forum geschlossen -->>
// =========================================================

if ( ($closed->fstatus == FORUM_STATUS_CLOSED)  && (UGROUP != 1) && !$is_moderator)
{
	$this->msg($mod['config_vars']['FORUMS_ERROR_NO_PERM']);
}

// =========================================================
// <<-- topic geschlossen -->>
// =========================================================
if ( ($closed->tstatus == FORUM_STATUS_CLOSED) && (UGROUP != 1) && !$is_moderator)
{
	$this->msg($mod['config_vars']['FORUMS_ERROR_NO_PERM']);
}

// =========================================================
// <<-- gibt es den topic und das posting ueberhaupt schon -->>
// =========================================================
if (!$this->topicExists($_GET['toid']))
{
	$this->msg($mod['config_vars']['FORUMS_ERROR_TOPIC_WRONG']);
}

// =========================================================
// <<-- zugriffsrechte -->>
// =========================================================
$permissions = $this->getForumPermissionsByUser($closed->id, UID);
$cat_query = $AVE_DB->Query("SELECT group_id FROM " . PREFIX . "_modul_forum_forum WHERE id = '" . $closed->id . "'");
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
		$this->msg($mod['config_vars']['FORUMS_ERROR_NO_PERM']);
	}
}

// =========================================================
// <<-- wenn benutzer der verfasser des themas ist -->>
// =========================================================
if ($closed->uid == UID) {
	// kann auf eigene themen antworten
	if (@$permissions[FORUM_PERMISSION_CAN_REPLY_OWN_TOPIC] == 0)
	{
		$this->msg($mod['config_vars']['FORUMS_ERROR_NO_PERM']);
	}
}
else 
{
	// kann auf andere themen antworten
	if (@$permissions[FORUM_PERMISSION_CAN_REPLY_OTHER_TOPIC] == 0)
	{
		$this->msg($mod['config_vars']['FORUMS_ERROR_NO_PERM']);
	}
}

// ueberpruefung der rechte und des datums
if (isset($_GET['action']) && $_GET['action'] == "edit")
{
	$q_information = "SELECT
		u.uid,
		UNIX_TIMESTAMP(p.datum) AS datum,
		UNIX_TIMESTAMP(NOW()) AS today
	FROM
		" . PREFIX . "_modul_forum_post AS p,
		" . PREFIX . "_modul_forum_userprofile AS u
	WHERE
		p.id = '" . $_GET["pid"] . "' AND
		u.uid = p.uid
	";

	$r_information = $AVE_DB->Query($q_information);
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
		if ($information->uid == UID && $permissions[FORUM_PERMISSION_CAN_EDIT_OWN_POST] == 0)
		{
			$this->msg($mod['config_vars']['FORUMS_ERROR_NO_PERM']);
		}

		// wenn nicht der beitragverfasser und der benutzer ist kein admin
		if ($information->uid != UID && UGROUP != 1 && !$is_moderator)
		{
			$this->msg($mod['config_vars']['FORUMS_ERROR_NO_PERM']);
		}

		// wenn die zeit fuer die editierung abgelaufen ist und
		// der benutzer ist kein admin
		if ($time_diff >= MAX_EDIT_PERIOD && UGROUP != 1 && !$is_moderator)
		{
			$this->msg($mod['config_vars']['FORUMS_ERROR_CANNOT_EDIT']);
		}
	}
}

if (SMILIES == 1) $AVE_Template->assign("smilie", 1);

if (isset($_GET['pid']) && !empty($_GET['pid'])) {

	// wir moechten nicht, dass der user bei einem zitat die anhaenge des posters angehaengt bekommt...
	$attachment = (isset($_REQUEST['action']) && $_REQUEST['action']=="quote") ? '' : "p.attachment,";

	$q_message = "SELECT
		u.uname,
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
		p.uid = u.uid AND
		t.id = p.topic_id";

	$r_message = $AVE_DB->Query($q_message);
	$message = $r_message->FetchRow();

	if (isset($_GET["action"]) && $_GET["action"] == "quote")
	{
		$message->message = "[QUOTE][B]" . $mod['config_vars']['FORUMS_QUOTE_PREFIX'] . " " . $message->uname . "[/B]\n ". htmlspecialchars($message->message) . "[/QUOTE]\n\n";
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
				$sql = $AVE_DB->Query("SELECT * FROM " . PREFIX ."_modul_forum_attachment WHERE id='$attachment'");
				$row_a = $sql->FetchRow();

				$h_attachments_only_show[] = '
				<div id="div_'.$row_a->id.'" style="display:">
				<input type="hidden" name="attach_hidden[]" id="att_'.$row_a->id.'" value="'.$row_a->id.'" />
				&bull; '.$row_a->orig_name.'
				<a href="javascript:;"
				onclick="if(confirm(\''.$mod['config_vars']['FORUMS_CONFIRM_DEL_ATTACH'].'\'))
				{
					document.getElementById(\'att_' . $row_a->id . '\').value=\'\';
					document.getElementById(\'div_' . $row_a->id . '\').style.display=\'none\';
					document.getElementById(\'hidden_count\').value = document.getElementById(\'hidden_count\').value - 1;
				}
				;"><img src="templates/'.THEME_FOLDER.'/modules/forums/forum/del_attach.gif" alt="" border="0" hspace="2" /></a>
				</div>';
			}

			$AVE_Template->assign("h_attachments_only_show", $h_attachments_only_show);
			$AVE_Template->assign("attachments_hidden", $message->attachment);// $message = $message->message;
		}
	}

	$AVE_Template->assign("message", $message);
	$AVE_Template->assign("f_id", $closed->id);
}

// hat user thema abonniert?
$sql = $AVE_DB->Query("SELECT notification FROM " . PREFIX . "_modul_forum_topic WHERE id = '" . $_GET['toid'] . "'");
$row = $sql->FetchRow();
$notifactions = @explode(";", $row->notification);

if(@in_array(UID, $notifactions))
{
	$AVE_Template->assign('notification', 1);
}

$navigation = $this->getNavigation($_GET["toid"], "topic")
	. $mod['config_vars']['FORUMS_FORUM_SEP']
	. "<a class='forum_links_navi' href='index.php?module=forums&amp;show=showtopic&amp;toid=" . $_GET['toid'] . "&amp;fid=" . $TopicFid. "'>" . $TopicTitle . "</a>"
	. $mod['config_vars']['FORUMS_FORUM_SEP']
	. $mod['config_vars']['FORUMS_REPLY_TO_POST'];

if(isset($_REQUEST['preview']) && $_REQUEST['preview']==1)
{
	$AVE_Template->assign("subject", $_REQUEST['subject']);
	$AVE_Template->assign("text", $_REQUEST['text']);
}

$items = array();
include (BASE_DIR . "/modules/forums/internals/addpost_last.php");

$AVE_Template->assign("aid", $closed->uid);
$AVE_Template->assign("items", $items);
$AVE_Template->assign("permissions", $permissions);
$AVE_Template->assign("maxlength_post", MAXLENGTH_POST);
$AVE_Template->assign("bbcodes", BBCODESITE);
$AVE_Template->assign("navigation", $navigation);
$AVE_Template->assign("max_post_length", MAXLENGTH_POST);
$AVE_Template->assign("listfonts",  $this->fontdropdown());
$AVE_Template->assign("sizedropdown",  $this->sizedropdown());
$AVE_Template->assign("colordropdown",  $this->colordropdown());
$AVE_Template->assign("listemos", $this->listsmilies());
$AVE_Template->assign("topic_id", $_GET["toid"]);
$AVE_Template->assign("forum_id", $TopicFid);
$AVE_Template->assign("action", "index.php?module=forums&amp;show=addpost");

$_POST['subject'] = isset($_POST['subject']) ? htmlspecialchars($_POST['subject']) : '';
$AVE_Template->assign("threadform", $AVE_Template->fetch($mod['tpl_dir'] . "threadform.tpl"));

if (isset($_GET['action']) && $_GET['action'] == "edit")
{
	if ($message->uid == UID || UGROUP == 1 || $is_moderator)
	{
		$AVE_Template->assign("topic", $message->topic);
		$AVE_Template->assign("posticons", $this->getPosticons($message->posticon));
		$AVE_Template->assign("topicform", $AVE_Template->fetch($mod['tpl_dir'] . "topicform.tpl"));
	}
}

$tpl_out = $AVE_Template->fetch($mod['tpl_dir'] . 'addtopic.tpl');
define("MODULE_CONTENT", $tpl_out);
define("MODULE_SITE", $mod['config_vars']['FORUMS_REPLY_TO_POST']);
?>