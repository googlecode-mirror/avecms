<?php

/**
 * 
 *
 * @package AVE.cms
 * @subpackage module_Forums
 * @filesource
 */
if (!defined("SHOWTOPIC")) exit;

global $AVE_DB, $AVE_Template, $mod;

$_REQUEST['page'] = (isset($_REQUEST['page']) && is_numeric($_REQUEST['page']) && $_REQUEST['page'] > 0) ? $_REQUEST['page'] : 1;

$printlink = get_redirect_link('print')."&amp;print=1";
$post_count_extra = "";
$post_query_extra = "";

// alle postings fьr einen thread anzeigen
if ( isset($_GET['toid']) && $_GET['toid'] != "" )
{
	// gibt es den topic und das posting ueberhaupt schon
	if (!$this->topicExists(addslashes($_GET['toid'])))
	{
		$this->msg($mod['config_vars']['ErrorTopicWrong']);
	}

	$navigation = $this->getNavigation((int)$_GET['toid'], "topic");

	// ueberpruefen ob das forum passwortgeschuetzt ist
	// und ob der benutzer sich schon angemeldet hat
	$q_pass = "
		SELECT
			f.id,
			f.password
		FROM
			" . PREFIX . "_modul_forum_forum AS f,
			" . PREFIX . "_modul_forum_topic AS t
		WHERE
			t.id = '" . (int)$_GET['toid'] . "' AND
			t.forum_id = f.id
	";
	$r_pass = $AVE_DB->Query($q_pass);
	$pass = $r_pass->FetchRow();
	$ForumId = $pass->id;
	$pass_b = false;

	if ($pass->password != "")
	{
		$p1 = @$_SESSION["f_pass_id_" . addslashes($pass->id)];
		$p2 = $pass->password;
		if ( $p1 == $p2 )
		{
			$pass_b = true;
		}
		else
		{
			$AVE_Template->assign("fid", addslashes(@$_REQUEST['fid']));
			$AVE_Template->assign("navigation", $navigation);

			$tpl_out = $AVE_Template->fetch($mod['tpl_dir'] . 'forumlogin.tpl');
			define("MODULE_CONTENT", $tpl_out);
			define("MODULE_SITE",  strip_tags($navigation));
		}
	}
	else
	{
		$pass_b = true;
	}

	if ($pass_b)
	{
		// ====================================================================================
		// zugriffsrechte
		// ====================================================================================
		$group_id = array();

		if (!@is_numeric(UID) || UGROUP == 2)
		{
			$group_id[] = UGROUP;
		}
		else
		{
			$query = "SELECT uid, group_id_misc FROM " . PREFIX . "_modul_forum_userprofile WHERE uid = '" . UID . "'";
			$result = $AVE_DB->Query($query);
			$user = $result->FetchRow();

			if ($user->group_id_misc != "")
			{
				$group_id_ = UGROUP . ";" . $user->group_id_misc;
				$group_id = @explode(";", $group_id_);

			}
			else
			{
				$group_id[] = UGROUP;
			}
		}

		$query = "SELECT
				c.group_id
			FROM
				" . PREFIX . "_modul_forum_category AS c,
				" . PREFIX . "_modul_forum_forum AS f
			WHERE
				f.id = '" . $pass->id . "' AND
				f.category_id = c.id
		";

		$result = $AVE_DB->Query($query);

		$category = $result->FetchRow();
		$category->group_id = @explode(",", $category->group_id);

		if (!array_intersect($group_id, $category->group_id))
		{
			$this->msg($mod['config_vars']['ErrornoPerm']);
		}

		$permissions = $this->getForumPermissionsByUser($pass->id, UID);

		if ($permissions[FORUM_PERMISSION_CAN_SEE] != 1)
		{
			$this->msg($mod['config_vars']['ErrornoPerm']);
		}

		// ====================================================================================

		if(!is_mod(@$_GET['fid']))
		{
			$post_count_extra .= " AND opened = 1 ";
		}

		// freischalten
		if(isset($_REQUEST['open']) && $_REQUEST['open'] == 1)
		{
			if(is_mod(addslashes($_REQUEST['fid'])))
			{
				if(isset($_REQUEST['ispost']) && $_REQUEST['ispost'] == 1)
				{
					$sql_p = "UPDATE " . PREFIX . "_modul_forum_post SET opened = '1' WHERE id='" . $_REQUEST['post_id'] . "'";
					$res_p = $AVE_DB->Query($sql_p);

					// mail an autor eines beitrages
					$link = HOST . str_replace("/index.php","",$_SERVER['PHP_SELF']) . "/index.php?module=forums&show=showtopic&toid=" . $_REQUEST['toid'] . "&pp=15";
					$sql = $AVE_DB->Query("SELECT uid FROM ".PREFIX."_modul_forum_post WHERE id = '" . $_REQUEST['post_id'] . "'");
					$row = $sql->FetchRow();

					$sql_2 = $AVE_DB->Query("SELECT uid, uname, email FROM ".PREFIX."_modul_forum_userprofile WHERE uid = '$row->uid'");
					$row_2 = $sql_2->FetchRow();

					$body = str_replace("%%USER%%", $row_2->uname, $mod['config_vars']['BodyToUserAfterMod']);
					$body = str_replace("%%LINK%%", $link, $body);
					$body = str_replace("%%N%%","\n", $body);

					send_mail(
						$row_2->email,
						stripslashes($body),
						$mod['config_vars']['SubjectToUserAfterMod'],
						FORUMEMAIL,
						FORUMABSENDER,
						"text"
					);
				}
				else
				{
					$sql_t = "UPDATE " . PREFIX . "_modul_forum_topic SET opened = '1' WHERE id='" . $_REQUEST['toid'] . "'";
					$sql_p = "UPDATE " . PREFIX . "_modul_forum_post SET opened = '1' WHERE topic_id='" . $_REQUEST['toid'] . "'";
					$res_t = $AVE_DB->Query($sql_t);
					$res_p = $AVE_DB->Query($sql_p);
					// mail an autor eines thema
					$link = HOST . str_replace("/index.php","",$_SERVER['PHP_SELF']) . "/index.php?module=forums&show=showtopic&toid=" . $_REQUEST['toid'] . "&fid=" . $_REQUEST['fid'] . "";
					$sql = $AVE_DB->Query("SELECT uid FROM ".PREFIX."_modul_forum_topic WHERE id = '" . $_REQUEST['toid'] . "'");
					$row = $sql->FetchRow();

					$sql_2 = $AVE_DB->Query("SELECT uid, uname, email FROM ".PREFIX."_modul_forum_userprofile WHERE uid = '$row->uid'");
					$row_2 = $sql_2->FetchRow();

					$body = str_replace("%%USER%%", $row_2->uname, $mod['config_vars']['BodyToUserAfterMod']);
					$body = str_replace("%%LINK%%", $link, $body);
					$body = str_replace("%%N%%","\n", $body);

					send_mail(
						$row_2->email,
						stripslashes($body),
						$mod['config_vars']['SubjectToUserAfterMod'],
						FORUMEMAIL,
						FORUMABSENDER,
						"text"
					);
				}
			}
		}

		// ======================================================
		// alle beitrдge holen
		$post_count = "SELECT
			id
		FROM " .
			PREFIX . "_modul_forum_post
		WHERE
			topic_id = '" . addslashes($_GET['toid']) . "'
			$post_count_extra
			ORDER BY
			id DESC
		";

		$post_count_result = $AVE_DB->Query($post_count);
		$num = $post_count_result->NumRows();

		if($num < 1)
		{
			$this->msg($mod['config_vars']['ErrornoPerm']);
		}

		$this->Cpengine_Board_SetTopicRead(addslashes($_GET['toid']));

		// ===================================================================
		$limit = (isset($_REQUEST['pp']) && is_numeric($_REQUEST['pp']) && $_REQUEST['pp'] > 0 ) ? $_REQUEST['pp'] : 15;
		$limit = (isset($_REQUEST['print']) && $_REQUEST['print']==1) ? 10000 : $limit;

		if (!isset($page)) $page = 1;
		$seiten = $this->getPageNum($num, $limit);
		$a = get_current_page() * $limit - $limit;
		$a = (isset($_REQUEST['print']) && $_REQUEST['print']==1) ? 0 : $a;

		if (!is_mod(@$_GET['fid']))
		{
			$post_query_extra .= " AND opened = 1 ";
		}
		$post_query = "SELECT
				p.id,
				p.title,
				p.message,
				p.datum,
				p.use_bbcode,
				p.use_smilies,
				p.use_sig,
				p.uid,
				p.attachment,
				p.opened
			FROM
				" . PREFIX . "_modul_forum_post AS p
			WHERE topic_id = '" . addslashes($_GET['toid']) . "'
			" . $post_query_extra . "
			ORDER BY
				p.datum ASC
			LIMIT " . $a . "," . $limit . "
		";

		$post_result = $AVE_DB->Query($post_query);
		$post_array = array();
		$current_user = null;

		if (($_SESSION['user_group'] != 2))
		{
			$q_current_user = "SELECT uid, email_receipt, pn_receipt FROM " . PREFIX . "_modul_forum_userprofile WHERE uid = '".UID."'";
			$r_current_user = $AVE_DB->Query($q_current_user);
			$current_user = $r_current_user->FetchRow();
		}

		while ($post = $post_result->FetchRow())
		{
			$Attach = array();
			// der beitragverfasser
			$q_user = "SELECT
					u.avatar,
					u.avatar_standard_group,
					u.uname,
					u.email,
					u.web_site,
					u.reg_time,
					u.signature,
					u.invisible,
					u.uid,
					us.firstname,
					us.user_group,
					us.lastname,
					ug.user_group_name,
					COUNT(p.uid) AS user_posts
				FROM
					" . PREFIX . "_modul_forum_userprofile AS u
				JOIN
					" . PREFIX . "_users AS us
						ON us.Id = u.uid
				JOIN
					" . PREFIX . "_user_groups AS ug
						ON ug.user_group = us.user_group
				JOIN
				    " . PREFIX . "_modul_forum_post AS p
				    	ON p.uid = u.uid
				WHERE
					u.uid = " . intval($post->uid) . " AND
					us.status = '1'
				GROUP BY p.uid
			";

			$r_user = $AVE_DB->Query($q_user);
			$poster = $r_user->FetchRow();
//			$query = "SELECT COUNT(id) AS count FROM " . PREFIX . "_modul_forum_post WHERE uid = '" . @$poster->uid . "'";
//			$result = $AVE_DB->Query($query);
//			$postings = $result->FetchRow();
//			$poster->user_posts = $postings->count;

			$query = "SELECT title, count FROM " . PREFIX . "_modul_forum_rank WHERE count < '" . $poster->user_posts . "' ORDER BY count DESC LIMIT 1";
			$result = $AVE_DB->Query($query);
			$rank = $result->FetchRow();
			$poster->avatar = $this->getAvatar( @$poster->user_group, @$poster->avatar, @$poster->avatar_standard_group);
			$poster->regdate = @$poster->reg_time;
			$poster->user_sig = $this->kcodes(@$poster->signature);
			$poster->rank = @$rank->title;
			$poster->OnlineStatus = @$this->getonlinestatus(@$poster->uname);

			$popUpInsert = addslashes ("<div style='padding:6px; line-height:1.5em'> &raquo; <a class='forum_links_small' href='index.php?module=forums&amp;show=userprofile&amp;user_id=".@$poster->uid."'>".$mod['config_vars']['ShowPosterProfile']."</a><br /> &raquo; <a class='forum_links_small' href='index.php?module=forums&amp;show=ignorelist&amp;insert=".@$poster->uid."'>".$mod['config_vars']['InsertIgnore']."</a><br />&raquo; <a class='forum_links_small' href='index.php?module=forums&amp;show=pn&action=new&amp;to=".base64_encode(@$poster->uname)."'>".$mod['config_vars']['UserSendPn']."</a></div>");
			$popUpRemove = "<div style='padding:6px; line-height:1.5em'> &raquo; <a class='forum_links_small' href='index.php?module=forums&amp;show=userprofile&amp;user_id=".@$poster->uid."'>".$mod['config_vars']['ShowPosterProfile']."</a><br /> &raquo; <a class='forum_links_small' href='index.php?module=forums&amp;show=ignorelist&amp;remove=".@$poster->uid."'>".$mod['config_vars']['RemoveIgnore']."</a><br />&raquo; <a class='forum_links_small' href='index.php?module=forums&amp;show=pn&action=new&amp;to=".base64_encode(@$poster->uname)."'>".$mod['config_vars']['UserSendPn']."</a></div>";

			$poster->Ignored = (($this->isIgnored(addslashes(@$poster->uid))) ? $popUpRemove : $popUpInsert);

			if (defined("SMILIES") && SMILIES==1) $poster->user_sig = $this->replaceWithSmileys($poster->user_sig);

			// der verfasser
			$post->poster = $poster;

			// soll bbcode verwendet werden
			if ($post->use_bbcode == 1)
			{
				$post->message = $this->kcodes($post->message);
			}
			else
			{
				$post->message = nl2br($post->message);
			}

			// sollen smilies angezeigt werden
			if ( ($post->use_smilies == 1) && (SMILIES==1) )
			{
				$post->message = $this->replaceWithSmileys($post->message);
			}

			$post->message = (!$this->badwordreplace($post->message)) ? $post->message : $this->badwordreplace($post->message);
			$post->message = $this->high($post->message);

			$post->files = array();
			// attachments
			if ($post->attachment != "")
			{
				$attachments = @explode(";", $post->attachment);
				$sub_query = @implode(" || id = ", $attachments);

				$q_file = "SELECT
					id,
					hits,
					orig_name,
					filename
				FROM " . PREFIX . "_modul_forum_attachment
				WHERE id = " . $sub_query . "
				";

				$r_file = $AVE_DB->Query($q_file);

				while ($file = $r_file->FetchRow())
				{
					$file->FileSize = $this->get_attachment_size($file->filename);
					array_push($Attach, $file);
				}
			}
			//$post->UserStatus = $this->getonlinestatus();

			$post->Attachments = $Attach;
			//if(!empty($poster->uid))
			array_push($post_array, $post);
		}
		$all_posts = $post_array;

		$AVE_Template->assign('files', $Attach);

		// anzahl der besichtigungen erhцhen
		$increment_query = $AVE_DB->Query("UPDATE " . PREFIX . "_modul_forum_topic SET views = views + 1 WHERE id = '" . addslashes($_REQUEST['toid']). "'");

		// daten des aktuellen topics holen
		$topic_result = $AVE_DB->Query("SELECT  notification, id, title, status, forum_id, uid FROM " . PREFIX . "_modul_forum_topic WHERE id = '" . addslashes($_REQUEST['toid']) . "'");
		$topic = $topic_result->FetchRow();

		// hat der user das thema abonniert?
		$user_id = explode(";", $topic->notification);
		if (@in_array(UID, $user_id))
		{
			$AVE_Template->assign('canabo', 0);
		}
		else
		{
			$AVE_Template->assign('canabo', 1);
		}

		// hat der user schon abgestimmt?
		$sql = $AVE_DB->Query("SELECT uid,ip FROM " . PREFIX . "_modul_forum_rating WHERE  topic_id = '".(int)$_GET['toid']."' ");
		$row_ip = $sql->FetchRow();
		$v_uid = @explode(",", $row_ip->uid);
		$ip = @explode(",", $row_ip->ip);

		if ( (!@in_array(UID, $v_uid)) && (!@in_array($_SERVER['REMOTE_ADDR'], $ip)) )
		{
			$AVE_Template->assign('display_rating', 1);
		}

		// nextes thema holen
		$query = "SELECT id FROM " . PREFIX . "_modul_forum_topic WHERE id < '" . (int)$_GET['toid'] . "' AND forum_id = '" . $pass->id . "' ORDER BY id DESC LIMIT 1";
		$result = $AVE_DB->Query($query);
		$next_topic = $result->FetchRow();

		// vorheriges thema holen
		$query = "SELECT id FROM " . PREFIX . "_modul_forum_topic WHERE id > '" .  (int)$_GET['toid'] . "' AND forum_id = '" . $pass->id . "' ORDER BY id ASC LIMIT 1";
		$result = $AVE_DB->Query($query);
		$prev_topic = $result->FetchRow();

		$topic->next_topic = $next_topic;
		$topic->prev_topic = $prev_topic;

		$sname = strip_tags($navigation) . " - " . stripslashes(htmlspecialchars($topic->title)) ;

		// navigation erzeugen
		$navigation = $this->getNavigation((int)$_GET['toid'], "topic");
		$tmp_navi = $navigation . $mod['config_vars']['ForumSep'] . $topic->title;

		$AVE_Template->assign("navigation", $tmp_navi);
		$AVE_Template->assign("treeview", @explode($mod['config_vars']['ForumSep'], $tmp_navi));
		// ende navigation

		if ($limit < $num)
		{
			$page_nav = " <a class=\"page_navigation\" href=\"index.php?module=forums&amp;show=showtopic&amp;toid=" . $_GET["toid"]
				. "&amp;high=" . @$_GET['high'] . "&amp;pp=$limit&amp;page={s}&amp;fid=$ForumId\">{t}</a> ";
			$page_nav = get_pagination($seiten, 'page', $page_nav);
			$AVE_Template->assign('pages', $page_nav);
		}

		if (UID == 1) array_fill(0, sizeof($permissions), 1);
		if (is_mod(@$_GET['fid'])) $AVE_Template->assign('ismod', 1);

		$categories = array();
		$this->getCategories(0, $categories, "");

		$this->Cpengine_Board_SetTopicRead(addslashes($_GET['toid']));

		$AVE_Template->assign("permissions", $permissions);
		$AVE_Template->assign("categories_dropdown", $categories);
		$AVE_Template->assign("navigation", $navigation);
		$AVE_Template->assign("next_site", $seiten);
		$AVE_Template->assign("currUser", $current_user);
		$AVE_Template->assign("printlink", $printlink);
		$AVE_Template->assign("topic", $topic);
		$AVE_Template->assign("postings", $all_posts);
		$AVE_Template->assign("referer", @$_SERVER['HTTP_REFERER']);
		$AVE_Template->register_function('getonlinestatus', 'getonlinestatus');

		$tpl = (isset($_REQUEST['print']) && $_REQUEST['print'] == 1) ? $this->_Print_ShowTopicTpl : $this->_ShowTopicTpl;
		$tpl_out = $AVE_Template->fetch($mod['tpl_dir'] . $tpl);

		define("MODULE_CONTENT", $tpl_out);
		define("MODULE_SITE",  htmlspecialchars(stripslashes(strip_tags($tmp_navi))));
	}
}
else
{
	header("Location:index.php?module=forums");
	exit;
}
?>