<?php

/**
 * 
 *
 * @package AVE.cms
 * @subpackage module_Forums
 * @filesource
 */
if(!defined("ADDPOST")) exit;

global $AVE_DB, $AVE_Template, $mod;

$forum = $AVE_DB->Query("
	SELECT
		f.id,
		t.uid,
		t.title
	FROM
		" . PREFIX . "_modul_forum_forum AS f,
		" . PREFIX . "_modul_forum_topic AS t
	WHERE
		t.id = '" . @$_POST['toid'] . "' AND
		t.forum_id = f.id
")
->FetchRow();

if(!is_object($forum))
{
	$this->msg($mod['config_vars']['ErrornoPerm']);
}

$TopicTitle = stripslashes($forum->title);

// =========================================================
// <<-- zugriffsrechte -->>
// =========================================================
$cat_query = $AVE_DB->Query("
	SELECT group_id
	FROM " . PREFIX . "_modul_forum_forum
	WHERE id = '" . $forum->id . "'
");
while ($category = $cat_query->FetchAssocArray())
{
	// miscrechte
	include_once(BASE_DIR . "/modules/forums/internals/misc_ids.php");

	$groups = explode(",", $category['group_id']);
	if (array_intersect($group_ids, $groups))
	{
		$permissions = $this->getForumPermissionsByUser($forum->id, UID);
	}
}

// =========================================================

// ist user moderator
$is_moderator = false;

$result = $AVE_DB->Query("
	SELECT user_id
	FROM " . PREFIX . "_modul_forum_mods
	WHERE forum_id = '" . $forum->id . "'
");
while ($user = $result->FetchRow())
{
	if ($user->user_id == UID) $is_moderator = true;
}

// wenn user nicht auf eigenes thema antworten kann
if ($forum->uid == UID)
{
	if ($permissions[FORUM_PERMISSION_CAN_REPLY_OWN_TOPIC] == 0)
	{
		$this->msg($mod['config_vars']['ErrornoPerm']);
	}
}
else
{
	// kann nicht auf andere themen antworten
	if ($permissions[FORUM_PERMISSION_CAN_REPLY_OTHER_TOPIC] == 0 && UGROUP != 1 && !$is_moderator)
	{
		$this->msg($mod['config_vars']['ErrornoPerm']);
	}
}

$error_array = array();

// kein text eingegeben
if ($_POST["text"] == "")
{
	array_push($error_array, $mod['config_vars']['CommentMissing']);
}

// wenn fehler oder vorschau
if (count($error_array) || ($_REQUEST['preview']==1))
{
	$AVE_Template->assign("smilie", SMILIES);
	#$navigation = $this->getNavigation($_POST["toid"], "topic");

	$navigation = $this->getNavigation($_POST["toid"], "topic")
		. $mod['config_vars']['ForumSep']
		. "<a class='forum_links_navi' href='index.php?module=forums&amp;show=showtopic&amp;toid=" . $_POST['toid'] . "&amp;fid=" . $_POST['fid']. "'>" . $TopicTitle . "</a>"
		. $mod['config_vars']['ForumSep']
		. $mod['config_vars']['ReplyToPost'];

	// vorschau darstellen
	if ($_REQUEST['preview']==1)
	{
		$preview_text = stripslashes($_REQUEST['text']);
		if (($_REQUEST['parseurl']) == 1) $preview_text = $this->parseurl($preview_text);
		if ((BBCODESITE == 1))
		{
			$preview_text = (isset($_REQUEST['disablebb']) && $_REQUEST['disablebb']==1) ? nl2br($preview_text) : $this->kcodes($preview_text);
		}
		else
		{
			$preview_text = nl2br($preview_text);
		}

		$preview_text = ((isset($_POST['disablesmileys']) && $_POST['disablesmileys']==1) || (SMILIES!=1)) ? $preview_text : $this->replaceWithSmileys($preview_text);


		// attachments anhaengen
		if(isset($_POST['attach_hidden']) && $_POST['attach_hidden']>=1)
		{
			foreach($_POST['attach_hidden'] as $attachment)
			{
				$row_a = $AVE_DB->Query("
					SELECT *
					FROM " . PREFIX ."_modul_forum_attachment
					WHERE id = '" . $attachment . "'
				")
				->FetchRow();

				$h_attachments_only_show[] = '
					<div id="div_' . $row_a->id . '" style="display:">
					<input type="hidden" name="attach_hidden[]" id="att_' . $row_a->id . '" value="' . $row_a->id . '" />
					&bull; ' . $row_a->orig_name . '
					<a href="javascript:;"
					onclick="if(confirm(\'' . $mod['config_vars']['DelAttach'] . '\'))
					{
						document.getElementById(\'att_' . $row_a->id . '\').value=\'\';
						document.getElementById(\'div_' . $row_a->id . '\').style.display=\'none\';
						document.getElementById(\'hidden_count\').value = document.getElementById(\'hidden_count\').value - 1;
					}
					;"><img src="templates/' . THEME_FOLDER . '/modules/forums/forum/del_attach.gif" alt="" border="0" hspace="2" /></a>
					</div>';
			}
			$AVE_Template->assign("h_attachments_only_show", $h_attachments_only_show);
		}
		$AVE_Template->assign("permissions", $permissions);
		$AVE_Template->assign("pre_error", 1);
		$AVE_Template->assign("preview_text", $preview_text);
		$AVE_Template->assign("preview_text_form", htmlspecialchars(stripslashes($_REQUEST['text'])));
		$AVE_Template->assign("fid", $_POST['fid']);
		$AVE_Template->assign("toid", $_POST['toid']);

		$items = array();
		include (BASE_DIR . "/modules/forums/internals/addpost_last.php");
		$AVE_Template->assign("items", $items);
	}

	$AVE_Template->assign("topic_id", $_POST["toid"]);
	$AVE_Template->assign("navigation", $navigation);
	$AVE_Template->assign("bbcodes", BBCODESITE);
	$AVE_Template->assign("posticons", $this->getPosticons());
	$AVE_Template->assign("listemos", $this->listsmilies());
	$AVE_Template->assign("subject", stripslashes(@$_POST["subject"]));
	$AVE_Template->assign("message", $_POST["text"]);
	$AVE_Template->assign("listfonts",  $this->fontdropdown());
	$AVE_Template->assign("sizedropdown",  $this->sizedropdown());
	$AVE_Template->assign("colordropdown",  $this->colordropdown());
	$AVE_Template->assign("errors", $error_array);
	$AVE_Template->assign("forum_id", $_POST['fid']);
	$_POST['subject'] = htmlspecialchars($_POST['subject']);
	$AVE_Template->assign("threadform", $AVE_Template->fetch($mod['tpl_dir'] . "threadform.tpl"));
	$tpl_out = $AVE_Template->fetch($mod['tpl_dir'] . 'addtopic.tpl');
	define("MODULE_CONTENT", $tpl_out);
	define("MODULE_SITE", $mod['config_vars']['NewThread']);
}
else
{
	$topic_id = $_POST["toid"];
	$title = ( $_POST["subject"] == "" ) ? '' : htmlspecialchars(addslashes($_POST["subject"]));
	$message = substr($_POST["text"], 0, MAXLENGTH_POST);

	// automatisch url umwandeln
	if ($_POST["parseurl"]) { $message = $this->parseurl($message);}

	// ueberpruefung bbcodes
	$disable_bbcode  = (isset($_POST['disablebb']) && $_POST['disablebb']==1) ? 0 : 1;
	$disable_smilies = (isset($_POST['disablesmileys']) && $_POST['disablesmileys']==1) ? 0 : 1;
	$use_sig     = (isset($_POST['usesig']) && $_POST['usesig']==1) ? 1 : 0;
	$notification = (isset($_POST["notification"]) && $_POST["notification"]==1) ? 1 : 0;

	// abos auslesen
	$r_notification = $AVE_DB->Query("
		SELECT
			notification,
			forum_id
		FROM " . PREFIX . "_modul_forum_topic
		WHERE id = '" . $topic_id . "'
	")
	->FetchRow();

	$forum_id = $r_notification->forum_id;
	$user_ids = explode(";",$r_notification->notification);

	// attachments anhaengen
	if(isset($_POST['attach_hidden']) && $_POST['attach_hidden'] >= 1)
	{
		foreach($_POST['attach_hidden'] as $file)
		{
			if($file!="")
			{
				$attached_files[] = $file;
			}
		}
		$attachments = @implode(";", $attached_files);
	}
	else
	{
		$attachments = @implode(";", $_POST['attachment']);
	}

	// wenn topic, keine posts
	$last_post_id = -1;

	// editieren
	if ($_POST['action'] == "edit")
	{
		$announce = "";
		$status = "";
		if ($permissions[FORUM_PERMISSIONS_CAN_CHANGE_TOPICTYPE] == 1)
		{
			if ($_REQUEST['subaction'] == "announce")
			{
				$announce = "type='100'";
			}
			if ($_REQUEST['subaction'] == "attention")
			{
				$announce = "type='1'";
			}
		}

		if ($permissions[FORUM_PERMISSIONS_CAN_CLOSE_TOPIC] == 1)
		{
			if ($_REQUEST['subaction'] == "close")
			{
				$status = "status='1'";
			}
		}

		if (($status!="") || ($announce!=""))
		{
			if($announce!="" && $status==1) $sep = ",";
			$AVE_DB->Query("
				UPDATE " . PREFIX . "_modul_forum_topic
				SET
					" . $announce . "
					" . $sep . "
					" . $status . "
				WHERE
					id = '" . $_REQUEST['toid'] . "'
			");
		}

		// befinden sich anhaenge am beitrag?
		$attachments = ($attachments != "")
			? "attachment = '" . $attachments . "',"
			: "attachment = '',";

		$AVE_DB->Query("
			UPDATE " . PREFIX . "_modul_forum_post
			SET
				" . $attachments . "
				title       = '" . $title . "',
				message     = '" . $message . " \n[size=2]Отредактировано: " . date("d.m.Y, H:i:s") . "[/size]',
				use_bbcode  = '" . $disable_bbcode . "',
				use_smilies = '" . $disable_smilies . "',
				use_sig     = '" . $use_sig . "'
			WHERE
				id = '" . $_POST['p_id'] . "'
		");

		// u.U. das Thema aendern
		$topic = $AVE_DB->Query("
			SELECT
				t.uid,
				t.id
			FROM
				" . PREFIX . "_modul_forum_topic AS t,
				" . PREFIX . "_modul_forum_post AS p
			WHERE
				p.id = " . $_POST['p_id'] . " AND
				t.id = p.topic_id
		")
		->FetchRow();

		// nur der themenstarter (admin und moderator auch) darf das thema aendern
		if ($topic->uid == UID || UGROUP == 1 || $is_moderator)
		{
			if ($_POST['topic'] != '')
			{
				$title = (!empty($_POST['topic'])) ? addslashes($_POST['topic']) : "";
				$result = $AVE_DB->Query("
					UPDATE
						" . PREFIX . "_modul_forum_topic
					SET
						title = '" . $title . "',
						posticon = '" . $_POST['posticon'] . "'
					WHERE
						id = '" . $topic->id . "'
				");
			}
		}
		// neu einfuegen
	}
	else
	{
		// muessen beitraege moderiert werden?
		$row = $AVE_DB->Query("
			SELECT
				moderated_posts,
				post_emails
			FROM " . PREFIX . "_modul_forum_forum
			WHERE id = '" . $forum_id . "'
		")
		->FetchRow();

		$opened = ($row->moderated_posts == 1) ? 2 : 1;
		if (is_mod($forum_id)) { $opened = 1; }

		// aktionen
		if (@$permissions[FORUM_PERMISSIONS_CAN_CLOSE_TOPIC] == 1)
		{
			if ($_REQUEST['subaction'] == "close")
			{
				$AVE_DB->Query("
					UPDATE " . PREFIX . "_modul_forum_topic
					SET status = '1'
					WHERE id = '" . $topic_id ."'
				");
			}
		}

		if (@$permissions[FORUM_PERMISSIONS_CAN_CHANGE_TOPICTYPE] == 1)
		{
			if ($_REQUEST['subaction'] == "announce")
			{
				$announce = "type='100'";
				$AVE_DB->Query("
					UPDATE " . PREFIX . "_modul_forum_topic
					SET type = '100'
					WHERE id = '" . $topic_id ."'
				");
			}
			if ($_REQUEST['subaction'] == "attention")
			{
				$AVE_DB->Query("
					UPDATE " . PREFIX . "_modul_forum_topic
					SET type = '1'
					WHERE id = '" . $topic_id ."'
				");
			}
		}

		// post eintragen
		$q_post_query = "
			INSERT
			INTO " . PREFIX . "_modul_forum_post
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
				'$title',
				'$message',
				NOW(),
				'$topic_id',
				'".UID."',
				'$disable_bbcode',
				'$disable_smilies',
				'$use_sig',
				'$attachments',
				'$opened'
			)
		";

		// letzten beitrag holen
		$q_last_post = "
			SELECT id
			FROM " . PREFIX . "_modul_forum_post
			WHERE topic_id = " . $topic_id . "
			ORDER BY id DESC
		";
		$r_last_post = $AVE_DB->Query($q_last_post);
		$last_post = $r_last_post->FetchRow();
		$last_post_id = $last_post->id;

		$datum = date("d.m.Y H:i");
		// ================================================================
		// <<-- wenn im admin empfaenger fьr jeden post eingetragen wurden,
		//      werden hier nun die mails versendet. -->>
		// ================================================================
		if ($_POST['action'] != "edit")
		{
			if($row->post_emails != "")
			{
				$mails = @explode(",",$row->post_emails);

				// welche seite?
				$sql = $AVE_DB->Query("SELECT topic_id FROM " . PREFIX . "_modul_forum_post WHERE topic_id = '$topic_id'");
				$count = $sql->NumRows();
				$page = $this->getPageNum($count, 15);

				// link
				$link = HOST . str_replace("/index.php","",$_SERVER['PHP_SELF'])
					. "/index.php?module=forums&show=showtopic&toid=$topic_id&pp=15&page=$page#pid_$last_post_id";

				$username = (UNAME == 'UNAME')
					? $mod['config_vars']['Guest']
					: $this->getUserName($_SESSION['user_id']);
				$body_msg = ($opened==2)
					? $mod['config_vars']['BodyNewPostEmailMod']
					: $mod['config_vars']['BodyNewPostEmail'];
				$subject_msg = ($opened==2)
					? $mod['config_vars']['SubjectNewPostEmailMod']
					: $mod['config_vars']['SubjectNewPostEmail'];

				$body = $body_msg;
				$body = str_replace("%%DATUM%%", $datum, $body);
				$body = str_replace("%%USER%%", $username, $body);
				$body = str_replace("%%SUBJECT%%", $title, $body);
				$body = str_replace("%%LINK%%", $link, $body);
				$body = str_replace("%%MESSAGE%%", $message, $body);
				$body = str_replace("%%N%%", "\n", $body);

				foreach ($mails as $send_mail)
				{
					send_mail(
						$send_mail,
						stripslashes($body),
						$subject_msg,
						FORUMEMAIL,
						FORUMABSENDER,
						"text"
					);
				}
			}
		}
		// ================================================================
		// <<-- EMAILS AN ABONNENTEN -->>
		// ================================================================
		// welche seite?
		$count = $AVE_DB->Query("
			SELECT COUNT(*)
			FROM " . PREFIX . "_modul_forum_post
			WHERE topic_id = '" . $topic_id . "'
		")
		->GetCell();
		$page = $this->getPageNum($count, 15);

		// link
		$link = HOST . str_replace("/index.php","",$_SERVER['PHP_SELF'])
			. "/index.php?module=forums&show=showtopic&toid=$topic_id&pp=15&page=$page#pid_$last_post_id";
		$users = @explode(";", $r_notification->notification);
		foreach ($users as $mail_to)
		{
			if ($mail_to != "")
			{
				$row_u = $AVE_DB->Query ("
					SELECT
						BenutzerName,
						email
					FROM " . PREFIX . "_modul_forum_userprofile
					WHERE BenutzerId = '" . $mail_to . "'
				")
				->FetchRow();

				$Autor = (UNAME == 'UNAME')
					? $mod['config_vars']['Guest']
					: $this->getUserName($_SESSION['user_id']);

				$n_body = $mod['config_vars']['BodyNewPostToUser'];
				$n_body = str_replace("%%DATUM%%", $datum, $n_body);
				$n_body = str_replace("%%USER%%", @$row_u->user_name, $n_body);
				$n_body = str_replace("%%AUTOR%%", $Autor, $n_body);
				$n_body = str_replace("%%SUBJECT%%", $title, $n_body);
				$n_body = str_replace("%%LINK%%", $link, $n_body);
				$n_body = str_replace("%%MESSAGE%%", $message, $n_body);
				$n_body = str_replace("%%N%%", "\n", $n_body);
				send_mail(
					$row_u->email,
					stripslashes($n_body),
					$mod['config_vars']['SubjectNewPostEmail'],
					FORUMEMAIL,
					FORUMABSENDER,
					"text"
				);
			}
		}
	}

	if ($notification)
	{
		// moechte user benachrichtigt werden?
		if (!in_array(UID,$user_ids))
		{
			$r_newrec = $AVE_DB->Query("
				UPDATE " . PREFIX . "_modul_forum_topic
				SET notification = CONCAT(notification, ';', '" . UID . "')
				WHERE id = '" . $topic_id . "'
			");
		}
	}
	else
	{
		// ansonsten user aus notification entfernen
		$row = $AVE_DB->Query("
			SELECT notification
			FROM " . PREFIX . "_modul_forum_topic
			WHERE id = '" . $topic_id . "'
		")
		->FetchRow();
		$new = @str_replace(";" . UID, "", $row->notification);
		$sql = $AVE_DB->Query("
			UPDATE " . PREFIX . "_modul_forum_topic
			SET notification = '" . $new . "'
			WHERE id = '" . $topic_id . "'
		");
	}

	$db_result = $new_post_result = $AVE_DB->Query($q_post_query);
	$new_id = $AVE_DB->InsertId();

	// FEHLER
	if (!$db_result)
	{
		$this->msg($mod['config_vars']['ErrornoPerm']);
	}

    if ($_POST['action'] != 'edit')
	{
    	// POST erfolgreich eingetragen
		$AVE_DB->Query("
    		UPDATE " . PREFIX . "_modul_forum_userprofile
    		SET Beitraege = Beitraege + 1
    		WHERE BenutzerId = '" . UID . "'
    	");
		$AVE_DB->Query("
    		UPDATE " . PREFIX . "_modul_forum_topic
    		SET replies = replies + 1,
    		last_post = NOW(),
    		last_post_int = '" . time() . "'
    		WHERE id = '" . $topic_id . "'
    	");
		$AVE_DB->Query("
    		UPDATE " . PREFIX . "_modul_forum_forum
    		SET last_post = NOW(),
    		last_post_id = " . $new_id . "
    		WHERE id = '" . $forum_id . "'
    	");
    }

    $this->Cpengine_Board_SetTopicRead($topic_id);

	$count = $AVE_DB->Query("
		SELECT COUNT(*)
		FROM " . PREFIX . "_modul_forum_post
		WHERE topic_id = '" . $topic_id . "'
	")
	->GetCell();

	$page = $this->getPageNum($count, 15);
	$page = ($page < 1) ? 1 : $page;

	$GoTo = "index.php?module=forums&amp;show=showtopic&amp;toid=" . $topic_id . "&amp;pp=15&amp;page=" . $page . "#pid_" . $last_post_id;

	if ($_POST['p_id'] != "")
	{
		$this->msg($mod['config_vars']['PostSuccess'], $GoTo);
	}
	else
	{
		$Msg = ($opened == 2)
			? $mod['config_vars']['MessageTopicCreatedModerated']
			: $mod['config_vars']['MessageTopicCreated'];
		$this->msg($Msg, $GoTo);
	}
}

?>