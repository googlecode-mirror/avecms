<?php

/**
 * 
 *
 * @package AVE.cms
 * @subpackage module_Forums
 * @filesource
 */
if(!defined("ADDTOPIC")) exit;

global $AVE_DB, $AVE_Template, $mod;

// forum id ьberprьfen
$forum_result = $AVE_DB->Query("SELECT title, status FROM " . PREFIX . "_modul_forum_forum WHERE id = '" . $_POST['fid'] . "'");
$forum = $forum_result->FetchRow();

//=======================================================
// es wurde eine falsche fid ьbergeben
//=======================================================
if ($forum_result->NumRows() < 1)
{
	$this->msg($mod['config_vars']['ErrornoPerm']);
}

if ( ($forum->status == FORUM_STATUS_CLOSED) && (UGROUP != 1) )
{
	$this->msg($mod['config_vars']['ErrornoPerm']);
}

//=======================================================
// Zugriffsrechte
//=======================================================
$cat_query = $AVE_DB->Query("SELECT group_id FROM " . PREFIX . "_modul_forum_forum WHERE id = '" . addslashes($_POST['fid']) . "'");
while ($category = $cat_query->FetchAssocArray())
{
	//=======================================================
	// miscrechte
	//=======================================================
	include_once(BASE_DIR . "/modules/forums/internals/misc_ids.php");

	$groups = explode(",", $category['group_id']);
	if (array_intersect($group_ids, $groups))
	{
		$permissions = $this->getForumPermissionsByUser(addslashes($_POST['fid']), UID);
	}
}

if ($permissions[FORUM_PERMISSION_CAN_CREATE_TOPIC] == 0 )
{
	$this->msg($mod['config_vars']['ErrornoPerm']);
}

$error_array = array();

if (empty($_POST["topic"]))
{
	array_push($error_array, str_replace("{0}", $mod['config_vars']['MissingTopic'], $mod['config_vars']['MissingE']));
}

if (empty($_POST["text"]))
{
	array_push($error_array, str_replace("{0}", $mod['config_vars']['MissingText'], $mod['config_vars']['MissingE']));
}

if ( count($error_array) || (isset($_REQUEST['preview']) && $_REQUEST['preview']==1) )
{
	$AVE_Template->assign("smilie", SMILIES);

	// vorschau darstellen
	if($_REQUEST['preview']==1)
	{
		$preview_text = stripslashes($_REQUEST['text']);
		if ( ($_REQUEST['parseurl']) == 1) $preview_text = $this->parseurl($preview_text);
		if ( (BBCODESITE == 1) )
		{
			$preview_text = (isset($_REQUEST['disablebb']) && $_REQUEST['disablebb']==1) ? nl2br($preview_text) : $this->kcodes($preview_text);
		} else {
			$preview_text = nl2br($preview_text);
		}

		$preview_text = ((isset($_POST['disablesmileys']) && $_POST['disablesmileys']==1) || (SMILIES!=1)) ? $preview_text : $this->replaceWithSmileys($preview_text);


		// attachments anhaengen
		if(isset($_POST['attach_hidden']) && $_POST['attach_hidden']>=1)
		{
			foreach($_POST['attach_hidden'] as $attachment)
			{
				$sql = $AVE_DB->Query("SELECT * FROM " . PREFIX ."_modul_forum_attachment WHERE id='$attachment'");
				$row_a = $sql->FetchRow();

				$h_attachments_only_show[] = '
				<div id="div_'.$row_a->id.'" style="display:">
				<input type="hidden" name="attach_hidden[]" id="att_'.$row_a->id.'" value="'.$row_a->id.'" />
				&bull; '.$row_a->orig_name.'
				<a title="" href="javascript:;"
				onclick="if(confirm(\''.$mod['config_vars']['DelAttach'].'\'))
				{
					document.getElementById(\'att_'.$row_a->id.'\').value=\'\';
					document.getElementById(\'div_'.$row_a->id.'\').style.display=\'none\';
					document.getElementById(\'hidden_count\').value = document.getElementById(\'hidden_count\').value - 1;
				}
				;"><img src="templates/' . THEME_FOLDER . '/modules/forums/forum/del_attach.gif" alt="" border="0" hspace="2" /></a>
				</div>';
			}
			$AVE_Template->assign("h_attachments_only_show", $h_attachments_only_show);
		}

		$AVE_Template->assign("permissions", $permissions);
		$AVE_Template->assign("preview_text", $preview_text);
		$AVE_Template->assign("preview_text_form", htmlspecialchars(stripslashes($_REQUEST['text'])));



		$items = array();
		$AVE_Template->assign("items", $items);
	}

	$navigation = $this->getNavigation(addslashes($_POST['fid']), "forum") . $mod['config_vars']['ForumSep'] . "<a class='forum_links_navi' href='index.php?module=forums&amp;show=showforum&amp;fid=" . addslashes($_REQUEST['fid']). "'>" . $forum->title . "</a>";

	$AVE_Template->assign("forum_id", $_POST['fid']);
	$AVE_Template->assign("new_topic", 1);
	$AVE_Template->assign("navigation", $navigation);
	$AVE_Template->assign("bbcodes", BBCODESITE);
	$AVE_Template->assign("posticons", $this->getPosticons());
	$AVE_Template->assign("listemos", $this->listsmilies());
	$AVE_Template->assign("topic", addslashes($_POST["topic"]));
	$AVE_Template->assign("subject", addslashes($_POST["subject"]));
	$AVE_Template->assign("message", addslashes($_POST["text"]));
	$AVE_Template->assign("listfonts",  $this->fontdropdown());
	$AVE_Template->assign("sizedropdown",  $this->sizedropdown());
	$AVE_Template->assign("colordropdown",  $this->colordropdown());
	$AVE_Template->assign("errors", $error_array);

	$AVE_Template->assign("topicform", $AVE_Template->fetch($mod['tpl_dir'] . "topicform.tpl"));
	$_POST['subject'] = htmlspecialchars($_POST['subject']);
	$AVE_Template->assign("threadform", $AVE_Template->fetch($mod['tpl_dir'] . "threadform.tpl"));

	$tpl_out = $AVE_Template->fetch($mod['tpl_dir'] . 'addtopic.tpl');
	define("MODULE_CONTENT", $tpl_out);
	define("MODULE_SITE", $mod['config_vars']['NewThread']);

} else {

	//=======================================================
	// TODO status: ANNOUNCEMENT | STICKY | MOVED | ...
	//=======================================================
	$status =  (isset($_POST['status']) && !empty($_POST['status'])) ? addslashes($_POST['status']) : '-';//($_POST["status"] == "") ? "-" : $_POST['status'];

	//=======================================================
	// posticon: NULL | ...
	//=======================================================
	$posticon = $_POST["posticon"];

	//=======================================================
	// topic name
	//=======================================================
	$topic = addslashes($_POST["topic"]);
	$forum_id = addslashes($_POST["fid"]);

	//=======================================================
	// antwort- benachrichtigung
	//=======================================================
	$notification = (isset($_POST['notification']) && !empty($_POST['notification'])) ? ';' . UID : '';// ($_REQUEST['notification'] != "") ? ';' . UID : '';

	//=======================================================
	// topic eintragen
	// wenn forum moderiert ist
	//=======================================================
	$sql = $AVE_DB->Query("SELECT moderated,topic_emails FROM " . PREFIX . "_modul_forum_forum WHERE id = '$forum_id'");
	$row = $sql->FetchRow();
	$opened = ($row->moderated == 1) ? 2 : 1;
	$topic_emails = $row->topic_emails;


	//=======================================================
	// wenn user admin oder selbst mod dieses forum ist, ist der Beitrag nicht moderiert
	//=======================================================
	if(is_mod($forum_id)) $opened = 1;

	$announce = '';
	$type = '';

	if(@$permissions[FORUM_PERMISSIONS_CAN_CHANGE_TOPICTYPE] == 1)
	{
		if(isset($_POST['subaction']) && $_POST['subaction'] == "announce")
		{
			$announce = "type,";
			$type = "'100',";
		}
		if(isset($_POST['subaction']) && $_POST['subaction'] == "attention")
		{
			$announce = "type,";
			$type = "'1',";
		}
	}

	if(@$permissions[FORUM_PERMISSIONS_CAN_CLOSE_TOPIC] == 1)
	{
		if(isset($_POST['subaction']) && $_POST['subaction'] == 'close')
		{
			$status = 1;
		}
	}

	$new_topic_query = "INSERT INTO " . PREFIX . "_modul_forum_topic
	(
		$announce
		id,
		title,
		status,
		replies,
		datum,
		views,
		forum_id,
		posticon,
		uid,
		notification,
		opened,
		last_post_int
	) VALUES (
		$type
		'',
		'" . mysql_escape_string($topic) . "',
		'$status',
		1,
		NOW(),
		1,
		'$forum_id',
		'$posticon',
		'".UID."',
		'$notification',
		'$opened',
		'".time()."'
	)";
	$db_result = $new_topic_result = $AVE_DB->Query($new_topic_query);
	$topic_id = $AVE_DB->InsertId();


	//=======================================================
	// mail an mods senden
	//=======================================================
	if($opened == 2)
	{
		$sql = $AVE_DB->Query("SELECT user_id FROM " . PREFIX . "_modul_forum_mods WHERE forum_id = '$forum_id'");
		while($row = $sql->FetchRow()){
			$sql2 = $AVE_DB->Query("SELECT user_name,email FROM " . PREFIX . "_users WHERE Id = '$row->user_id'");
			$row2 = $sql2->FetchRow();

			// link
			$link = HOST . str_replace("/index.php","",$_SERVER['PHP_SELF']) . "/index.php?module=forums&show=showtopic&toid=$topic_id&fid=$forum_id";
			$username = (UGROUP==2) ? $mod['config_vars']['Guest'] : $this->getUserName($_SESSION['user_id']);
			$body = $mod['config_vars']['BodyNewThreadEmailMod'];
			$body = str_replace("%%DATUM%%", date("d.m.Y, H:i:s"), $body);
			$body = str_replace("%%N%%", "\n", $body);
			$body = str_replace("%%USER%%", $username, $body);
			$body = str_replace(array("%%SUBJECT%%","%%BETREFF%%"),  "\"$title\"" , $body);
			$body = str_replace("%%LINK%%", $link, $body);
			$body = str_replace("%%MESSAGE%%", $message, $body);

			send_mail(
				$row2->email,
				stripslashes($body_s),
				$mod['config_vars']['SubjectNewThreadEmail'] . $exsubject,
				FORUMEMAIL,
				FORUMABSENDER,
				"text"
			);
		}
	}

	$q_rating    = "INSERT INTO " . PREFIX . "_modul_forum_rating (topic_id, rating, ip) VALUES ($topic_id, '', '')";
	$r_rating    = $AVE_DB->Query($q_rating);
	$title       = (isset($_POST['subject']) && !empty($_POST['subject'])) ? $_POST['subject'] : '';
	$message     = (isset($_POST['parseurl']) && $_POST['parseurl']==1) ? $this->parseurl(substr($_POST['text'], 0, MAXLENGTH_POST)) : substr($_POST['text'], 0, MAXLENGTH_POST);
	$use_bbcode  = (isset($_POST['disablebb']) && $_POST['disablebb']==1) ? 0 : 1;
	$use_smilies = (isset($_POST['disablesmileys']) && $_POST['disablesmileys']==1) ? 0 : 1;
	$use_sig     = (isset($_POST['usesig']) && $_POST['usesig']==1) ? 1 : 0;


	if(isset($_POST['attach_hidden']) && $_POST['attach_hidden']>=1)
	{
		foreach($_POST['attach_hidden'] as $file)
		{
			if($file!="")
			{
				$attached_files[] = $file;
			}
		}
		$attachments = @implode(";", $attached_files);
	} else {
		$attachments = @implode(";", $_POST['attachment']);
	}

	$new_post_query = "INSERT INTO " . PREFIX . "_modul_forum_post
	(
		id,
		title,
		message,
		datum,
		topic_id,
		uid,
		use_bbcode,
		use_smilies,
		use_sig,
		attachment,
		opened
	) VALUES (
		'',
		'" . mysql_escape_string($title) . "',
		'" . mysql_escape_string($message) . "',
		NOW(),
		'$topic_id',
		'".UID."',
		'$use_bbcode',
		'$use_smilies',
		'$use_sig',
		'$attachments',
		'$opened'
	)";
	$db_result = $new_post_result = $AVE_DB->Query($new_post_query);
	$last_post_id = mysql_insert_id();

	if($topic_emails != "")
	{
		$headers = array();
		$mails = @explode(",",$row->topic_emails);

		//=======================================================
		// link zusammensetzen
		//=======================================================
		$link = HOST . str_replace("/index.php","",$_SERVER['PHP_SELF']) . "/index.php?module=forums&show=showtopic&toid=$topic_id&fid=$forum_id";

		$username = (UGROUP==2) ? $mod['config_vars']['Guest'] : $this->getUserName($_SESSION['user_id']);
		$body_s = ($opened==2) ? $mod['config_vars']['BodyNewThreadEmailMod'] : $mod['config_vars']['BodyNewThreadEmail'];
		$body_s = str_replace("%%DATUM%%", date("d.m.Y, H:i:s"), $body_s);
		$body_s = str_replace("%%N%%", "\n", $body_s);
		$body_s = str_replace("%%USER%%", $username, $body_s);
		$body_s = str_replace(array("%%SUBJECT%%","%%BETREFF%%"),  "\"".stripslashes($topic)."\"" , $body_s);
		$body_s = str_replace("%%LINK%%", $link, $body_s);
		$body_s = str_replace("%%MESSAGE%%", $message, $body_s);

		$exsubject = ($opened==2) ? " - " . $mod['config_vars']['HaveToModerate'] : "";

		//=======================================================
		// E-Mails an Forum-Empfдnger (Admin-Bereich) senden
		//=======================================================
		foreach ($mails as $send_mail)
		{
			send_mail(
				$send_mail,
				stripslashes($body_s),
				$mod['config_vars']['SubjectNewThreadEmail'] . $exsubject,
				FORUMEMAIL,
				FORUMABSENDER,
				"text"
			);
		}
	}

	// ОШИБКА
	if (!$db_result)
	{
		$this->msg($mod['config_vars']['ErrornoPerm']);
		//=======================================================
		// neuer topic wurde erfolgreich erstellt
		//=======================================================
	} else {
		if(UGROUP!= 2)
		{
    		$q_post_increment = "UPDATE " . PREFIX . "_modul_forum_userprofile SET messages = messages + 1 WHERE uid = '".UID."'";
    		$r_post_increment = $AVE_DB->Query($q_post_increment);
		}

        $q_reply_increment = "UPDATE " . PREFIX . "_modul_forum_topic SET last_post = NOW(), last_post_int ='".time()."' WHERE id = '".$topic_id."'";
        $r_reply_increment = $AVE_DB->Query($q_reply_increment);

        $q_update_forums = "UPDATE " . PREFIX . "_modul_forum_forum SET last_post = NOW(), last_post_id = ".$last_post_id." WHERE id = '".$forum_id."'";
        $r_update_forums = $AVE_DB->Query($q_update_forums);

		$this->Cpengine_Board_SetTopicRead($topic_id);

		//=======================================================
		// Meldung zusammensetzen
		//=======================================================
		$GoTo = ($opened == 2) ? "index.php?module=forums&show=showforum&fid=$forum_id" : "index.php?module=forums&show=showtopic&toid=$topic_id&fid=$forum_id";
		$Msg = ($opened == 2) ? $mod['config_vars']['MessageTopicCreatedModerated'] : $mod['config_vars']['MessageTopicCreated'];
		$Msg = str_replace('%%GoTo%%', $GoTo, $Msg);

		$AVE_Template->assign("GoTo", $GoTo);
		$AVE_Template->assign("content", $Msg);

		//=======================================================
		// Meldung ausgeben und weiter leiten
		//=======================================================
		$tpl_out = $AVE_Template->fetch($mod['tpl_dir'] . 'redirect.tpl');
		define("MODULE_CONTENT", $tpl_out);
		define("MODULE_SITE", $mod['config_vars']['NewThread']);
	}
}

?>