<?php

/**
 * 
 *
 * @package AVE.cms
 * @subpackage module_Forums
 * @filesource
 */
if (!defined("SHOWFORUM")) exit;

global $AVE_DB, $AVE_Template, $mod;

// Angriff verhindern!
if(!is_numeric($_REQUEST['fid']) || $_REQUEST['fid'] < 1)
{
	header("Location:index.php?module=forums");
	exit;
}

$_REQUEST['fid'] = addslashes($_REQUEST['fid']);
$fid = $_REQUEST['fid'];

if ($fid == "")
{
	header("Location:index.php?module=forums");
	exit;
}

$forum_result = $AVE_DB->Query("SELECT  id, status, title, password, category_id FROM " . PREFIX . "_modul_forum_forum WHERE id = '" . $fid . "'");

// link: neue kategorie
$newcatlink = "index.php?p=newcategory&amp;pid=" . $fid;

// es wurde eine falsche fid ьbergeben
if ($forum_result->NumRows() < 1)
{
	header("Location:index.php?module=forums");
	exit;
}

$forum_obj = $forum_result->FetchRow();

// navigation erzeugen
$navigation = $this->getNavigation($fid, "forum", null);
$tmp_navi = $navigation . $mod['config_vars']['ForumSep'] . $forum_obj->title;

$AVE_Template->assign("navigation", $tmp_navi);
$AVE_Template->assign("treeview", @explode($mod['config_vars']['ForumSep'], $tmp_navi));

$pass = false;
if ($forum_obj->password != "")
{
	$f_pass_id = @$_SESSION['f_pass_id'];
	$pass_id = explode(";", $f_pass_id);

	$p1 = @$_SESSION["f_pass_id_" . $_REQUEST['fid']];
	$p2 = $forum_obj->password;
	if( $p1 == $p2 )
	{
		$pass = true;
	}
	else
	{
		$AVE_Template->assign("fid", $fid);
		$AVE_Template->assign("navigation", $navigation);

		$tpl_out = $AVE_Template->fetch($mod['tpl_dir'] . 'forumlogin.tpl');
		define("MODULE_CONTENT", $tpl_out);
		define("MODULE_SITE",  strip_tags($navigation));
	}
}
else
{
	$pass = true;
}

if ($pass)
{
	$q_topic_count_extra = "";
	$where_time_stat = "";
	$only_own_topics = "";
	$topic_query_extra = "";

	// ====================================================================================
	// zugriffsrechte
	// ====================================================================================
	$group_ids = array();
	if (!defined("MISCIDSINC")) define("MISCIDSINC", 1);
	$cat_query = $AVE_DB->Query("SELECT group_id FROM " . PREFIX . "_modul_forum_forum WHERE id = '" . $_REQUEST['fid'] . "'");
	while ($category = $cat_query->FetchAssocArray())
	{
		// miscrechte
		if (@is_numeric(UID))
		{
			$queryfirst = "SELECT uid, group_id_misc FROM " . PREFIX . "_modul_forum_userprofile WHERE uid = '" . UID . "'";
			$result = $AVE_DB->Query($queryfirst);
			$user = $result->FetchRow();

			if (@$user->group_id_misc != "")
			{
				$group_ids_pre = UGROUP . ";" . $user->group_id_misc;
				$group_ids     = @explode(";", $group_ids_pre);
			}
			else
			{
				$group_ids[] = UGROUP;
			}
		}
		else
		{
			$group_ids[] = 2;
		}

		$forum_obj->permissions = $this->getForumPermissionsByUser($forum_obj->id, UID);
		$forum_obj->permissions[FORUM_PERMISSION_CAN_SEE] = 0;
		$groups = explode(",", $category['group_id']);
		$can_see = 0;
		if (array_intersect($group_ids, $groups))
		{
			$can_see = 1;
		}

		if ($can_see != 1)
		{
			header("Location:index.php?module=forums");
			exit;
		}
	}

	// ============================================
	//  <<-- Falls der User eine Sortierung und
	//  eine Filterung angefordert hat -->>
	// ============================================
	$unit = (isset($_POST['unit']) && $_POST['unit'] != "") ? addslashes($_POST['unit']) : @addslashes($_GET['unit']);
	$period = (isset($_POST['period']) && $_POST['period'] != "") ? addslashes($_POST['period']) : @addslashes($_GET['period']);
	$order = (isset($_POST['sort']) && $_POST['sort'] != "") ? addslashes($_POST['sort']) : @addslashes($_GET['sort']);
	$order = (!empty($order) && ($order != 'ASC' && $order != 'DESC')) ? 'DESC' : $order;

	$period = htmlspecialchars(strip_tags($period));
	$unit = htmlspecialchars(strip_tags($unit));

	$order_orig = $order;

	switch ($unit)
	{
		// Stunden
		case 'h':
		// sekunden * 60 * 60 = stunde
//		$divisor = 60 * 60;
//		$where_time_stat = " AND ((UNIX_TIMESTAMP(NOW()) / $divisor) - (UNIX_TIMESTAMP(p.datum) / $divisor)) <= $period";
		$where_time_stat = " AND NOW() - INTERVAL $period HOUR <= p.datum";
		break;

		// Tage
		case 'd':
		// sekunden * 60 * 60 * 24 = tag
//		$divisor = 60 * 60 * 24;
//		$where_time_stat = " AND ((UNIX_TIMESTAMP(NOW()) / $divisor) - (UNIX_TIMESTAMP(p.datum) / $divisor)) <= $period";
		$where_time_stat = " AND NOW() - INTERVAL $period DAY <= p.datum";
		break;

		// Monat
		case 'm':
//		$divisor = 60 * 60 * 24 * 30;
//		$where_time_stat = " AND ((UNIX_TIMESTAMP(NOW()) / $divisor) - (UNIX_TIMESTAMP(p.datum) / $divisor)) <= $period";
		$where_time_stat = " AND NOW() - INTERVAL $period MONTH <= p.datum";
		break;

		case 'all':
		$where_time_stat = " AND 1";
	}

	$order_by = (
		(isset($_GET["sortby"]) &&  $_GET["sortby"] != "")
		&&
		(
			$_GET["sortby"]=='last_post' ||
			$_GET["sortby"]=='title' ||
			$_GET["sortby"]=='replies' ||
			$_GET["sortby"]=='user_name' ||
			$_GET["sortby"]=='views' ||
			$_GET["sortby"]=='last_post_int' ||
			$_GET["sortby"]=='rating'
		))
		? addslashes($_GET["sortby"])
		: "last_post_int";

	$order_by = ($order_by == 'user_name') ? 'uname' : $order_by;
	$order = ($order != "") ? $order : "DESC";

	// wenn user nicht mod dieses forum ist und kein admin ist, nicht freigeschaltete themen verbergen
	if(!is_mod($fid)) {
		$q_topic_count_extra .= " AND t.opened = 1 ";
	}

	$q_topic_count = "
		SELECT DISTINCT
			t.id,
			t.title,
			t.status,
			t.datum,
			t.type,
			t.views,
			t.posticon,
			t.uid,
			u.uid,
			u.uname,
			t.replies,
			t.last_post
		FROM
			" . PREFIX . "_modul_forum_topic AS t,
			" . PREFIX . "_modul_forum_userprofile AS u,
			" . PREFIX . "_modul_forum_post AS p
		WHERE
			(t.forum_id = '" . $fid . "' AND u.uid = t.uid)
		AND
			p.topic_id = t.id
		" . $q_topic_count_extra . "
		" . $where_time_stat . "
	";

	// der user darf nur eigene topics sehen
	if ($forum_obj->permissions[FORUM_PERMISSION_CAN_SEE_TOPIC] == 0)
	{
		$only_own_topics = " AND t.uid = '" . UID . "'";
	}

	$q_topic_count .= $only_own_topics;
	$q_topic_count .= " AND t.opened = '1'";
	$r_topic_count = $AVE_DB->Query($q_topic_count);
	$num = $r_topic_count->NumRows();

	$limit = ( isset($_REQUEST['pp']) && is_numeric($_REQUEST['pp']) && $_REQUEST['pp']>0 ) ? $_REQUEST['pp'] : 15;

	if(!isset($page))
	{
		$page = 1;
	}

	$seiten = ceil($num / $limit);
	$a = get_current_page() * $limit - $limit;

	if(!is_mod($fid))
	{
		$topic_query_extra .= " AND t.opened = 1 ";
	}

	$order_by = str_replace('last_post_int', 'last_post', $order_by);

	$topic_query = "
		SELECT DISTINCT
			t.id,
			t.title,
			t.status,
			t.datum,
			t.type,
			t.views,
			t.posticon,
			t.uid,
			u.uid,
			u.uname,
			u.reg_time,
			t.last_post,
			t.opened,
			r.rating
		FROM
			" . PREFIX . "_modul_forum_topic AS t,
			" . PREFIX . "_modul_forum_userprofile AS u,
			" . PREFIX . "_modul_forum_rating AS r,
			" . PREFIX . "_modul_forum_post AS p
		WHERE
			(t.forum_id = '" . $fid . "' AND u.uid = t.uid  AND r.topic_id = t.id)
		AND
			p.topic_id = t.id
		" . $topic_query_extra . "
		" . $where_time_stat . "
		" . $only_own_topics . "
		ORDER BY
			type DESC, $order_by $order
		LIMIT " . $a . "," . $limit . "
	";

	$order = ($order == "DESC") ? "ASC" : "DESC";
	$topic_result = $AVE_DB->Query($topic_query);
	$topic_array = array();

	// topic liste durchgehen.
	// fuer jeden topic einen link zusammenstellen, damit im template der user
	// keine fehler machen kann.
	// fuer jeden topic den autor ermitteln und als einen link
	// zum userprofil im topic ablegen.

	while ($topic = $topic_result->FetchAssocArray())
	{
		$topic['link'] = "index.php?module=forums&amp;show=showtopic&amp;toid=" . $topic['id'] . "&amp;fid=" . $_REQUEST['fid'] . "";
		$topic['closelink'] = "index.php?module=forums&amp;show=closetopic&amp;fid=" . $fid . "&amp;toid=" . $topic['id'];
		$topic['openlink'] = "index.php?module=forums&amp;show=opentopic&amp;fid=" . $fid . "&amp;toid=" . $topic['id'];
		$topic['dellink'] = "index.php?module=forums&amp;show=deltopic&amp;fid=" . $fid . "&amp;toid=" . $topic['id'];
		$topic['movelink'] = "index.php?module=forums&amp;show=move&amp;item=t&amp;id=" . $topic['id'];
		$topic['typelink'] = "index.php?module=forums&amp;show=forum&amp;action=change_type&amp;id=" . $topic['id'] . "&amp;fid=" . $fid;
		$topic['title'] = stripslashes($topic['title']);
		$topic['opened'] = $topic['opened'];

		$rating = @explode(",", $topic['rating']);
		$topic['rating'] = (int) (array_sum($rating) / count($rating));

		if ($topic["status"] == FORUM_STATUS_MOVED)
		{
			$topic["statusicon"] = $this->getIcon("thread_moved.gif", "moved");
		}
		else
		{
			if ($_SESSION['user_group'] == 2 || ($forum_obj->status == FORUM_STATUS_CLOSED) )
			{
				// nicht eingeloggt oder forum geschlossen
				$topic["statusicon"] = $this->getIcon("thread_lock.gif", "lock");
			}
			else
			{
				$this->setTopicIcon($topic, $forum_obj);
			}
		}

		$user_query = "SELECT uid, reg_time FROM " . PREFIX . "_modul_forum_userprofile WHERE uid = '" . $topic['uid'] . "'";

		$user_result = $AVE_DB->Query($user_query);
		$user_row = $user_result->FetchRow();


		$topic["autorlink"] = "index.php?module=forums&amp;show=userprofile&amp;user_id=$topic[uid]";
		$topic["autor"] = $topic["uname"];

		// letzten beitrag ermitteln
		$last_post_query = "
			SELECT
				p.id,
				p.datum,
				p.topic_id,
				p.uid,
				u.uid,
				u.uname,
				u.reg_time
			FROM
				" . PREFIX . "_modul_forum_post AS p,
				" . PREFIX . "_modul_forum_userprofile AS u
			WHERE
				p.topic_id = " . $topic['id'] . " AND
				u.uid = p.uid
			GROUP BY
				p.id
			ORDER BY
				p.datum DESC
			LIMIT 1
		";

		$last_post_result = $AVE_DB->Query($last_post_query);
		$topic_post_count = $last_post_result->NumRows();
		$last_post_row = $last_post_result->FetchRow();

		$last_post_row->reg_time = $last_post_row->reg_time;
		$last_post_row->link = ($last_post_row->reg_time < 2) ? $mod['config_vars']['Guest'] : "<a class='forum_links_small' href='index.php?module=forums&amp;show=userprofile&amp;user_id=$last_post_row->uid'>$last_post_row->uname</a>";
		$topic["lastposter"] = $last_post_row;

		// =================================================
		//  <<-- Anzahl der Postings ermitteln -->>
		// =================================================

		// als limit fuer die maximale anzahl der postings auf
		// einer seite wird 15 als standardwert genommen
		$limit = 15;

		$q_post = "SELECT COUNT(id) as count FROM " . PREFIX . "_modul_forum_post WHERE topic_id = " . $topic['id'];
		$r_post = $AVE_DB->Query($q_post);
		$post = $r_post->FetchRow();

		$numPages = $this->getPageNum($post->count, $limit);
		$topic['navigation_page'] = ($numPages == 1) ? 0 : $numPages;
		$topic['next_page'] = $numPages;
		$topic['replies'] = $post->count;

		array_push($topic_array, $topic);
	}

	$subcat_query = "SELECT id, title, position, comment, parent_id, group_id FROM " . PREFIX . "_modul_forum_category WHERE parent_id = " . $fid . " ORDER BY position";
	$subcat_result = $AVE_DB->Query($subcat_query);
	$subcat_array = array();

	while ($subcategory = $subcat_result->FetchAssocArray())
	{
		// gruppen, die zugriff auf die kategorie haben
		$groups = @explode(",", $subcategory['group_id']);

		if (array_intersect($group_ids, $groups))
		{
			// den status der anzeige aus dem cookie holen
			$position = strpos($_COOKIE["categories"], 'id' . $subcategory['id']);
			if ( is_numeric($position) )
			{
				$subcategory["display"] = "none";
				$subcategory["image"] = "plus.gif";
			}

			$subcategory["link"] = "index.php?module=forums&amp;show=showforums&amp;cid=" . $subcategory['id'] . "&amp;pid=" . $fid;

			array_push($subcat_array, $subcategory);

			$subforum_query = "
				SELECT
					group_id,
					id,
					title,
					comment,
					status
				FROM " . PREFIX . "_modul_forum_forum
				WHERE category_id = " . $subcategory['id'] . "
				AND active = 1
				ORDER BY position
			";

			$subforum_result = $AVE_DB->Query($subforum_query);
			$subforum_array[$subcategory["title"]] = array();

			while ($subforum = $subforum_result->FetchAssocArray())
			{
				if (@$subforum['group_found'] != "no")
				{
					$pcount = 0;
					$q_tcount = "SELECT id FROM " . PREFIX . "_modul_forum_topic WHERE forum_id = '" . (int)$subforum['id'] . "'";
					$r_tcount = $AVE_DB->Query($q_tcount);
					$subforum["tcount"] = $r_tcount->NumRows();

					$ids = "";

					while ($tid = $r_tcount->FetchRow())
					{
						if ($ids == "")
						{
							$ids .= $tid->id;
						}
						else
						{
							$ids .= " OR topic_id = " . $tid->id;
						}
					}

					if ($ids != "")
					{
						$q_pcount = "
							SELECT id
							FROM " . PREFIX . "_modul_forum_post
							WHERE topic_id = " . $ids . "
						";

						$r_pcount = $AVE_DB->Query($q_pcount);
						$pcount = $r_pcount->NumRows();

						// ====================
						// letzter beitrag
						$q_last_post = "
							SELECT
								p.datum,
								p.topic_id,
								p.uid,
								p.id
							FROM
								" . PREFIX . "_modul_forum_post AS p,
								" . PREFIX . "_modul_forum_topic AS t
							WHERE
								p.topic_id = $ids AND
								t.id = p.topic_id
							ORDER BY
								p.datum DESC
							LIMIT 1
						";

						$last_post = $this->getLastForumPost($subforum['id']);
						if ( ! $last_post)
						{
							$r_last_post = $AVE_DB->Query($q_last_post);
							$last_post = $r_last_post->FetchRow();
						}

						$q_replies = "SELECT COUNT(id) AS replies FROM " . PREFIX . "_modul_forum_post WHERE topic_id = " . $last_post->topic_id;
						$r_replies = $AVE_DB->Query($q_replies);
						$replies = $r_replies->FetchRow();

						$last_post->replies = $replies->replies;

						$q_last_user = "SELECT uid, uname, reg_time FROM " . PREFIX . "_modul_forum_userprofile WHERE uid = " . $last_post->uid;
						$r_last_user = $AVE_DB->Query($q_last_user);
						$last_user = $r_last_user->FetchRow();

						$last_post->LastPoster = $last_user->uname;

						$last_post->page = $this->getPageNum($last_post->replies, 15);
						$subforum['last_post'] = $last_post;
					}

					// Forumicon
					if ($_SESSION['user_group'] == 0)
					{
						$subforum["statusicon"] = $this->getIcon("forum_old_lock.gif", "forum");
					}
					else
					{
						$this->setForumIcon($subforum);
					}

					$subforum["pcount"] = $pcount;
					// ==============================================================
					//  <<-- Unterkategorien und Unterforen -->>
					// ==============================================================
					$q_subcat = "SELECT id FROM " . PREFIX . "_modul_forum_category WHERE parent_id = " . $subforum['id'];
					$r_subcat = $AVE_DB->Query($q_subcat);

					$subfors = array();

					while ($subcat = $r_subcat->FetchRow())
					{
						$q_subfor = "SELECT id, title FROM " . PREFIX . "_modul_forum_forum WHERE category_id = " . $subcat->id;
						$r_subfor = $AVE_DB->Query($q_subfor);

						while ($subfor = $r_subfor->FetchRow())
						{
							$subfors[] = $subfor;
						}
					}

					$subforum["link"] = "index.php?module=forums&amp;show=showforum&amp;fid=$subforum[id]";
					$subforum['subforums'] = $subfors;
					array_push($subforum_array[$subcategory["title"]], $subforum);
				}
			}
		}
	}

	$sname = strip_tags($navigation) . $mod['config_vars']['ForumSep'] . $forum_obj->title;

	$AVE_Template->register_function("get_post_icon", "getPostIcon");
	$AVE_Template->assign("sort_by_theme_link", "index.php?module=forums&amp;show=showforum&amp;fid=" . $fid . "&amp;sortby=title&amp;sort=$order");
	$AVE_Template->assign("sort_by_reply_link", "index.php?module=forums&amp;show=showforum&amp;fid=" . $fid . "&amp;sortby=replies&amp;sort=$order");
	$AVE_Template->assign("sort_by_author_link", "index.php?module=forums&amp;show=showforum&amp;fid=" . $fid . "&amp;sortby=user_name&amp;sort=$order");
	$AVE_Template->assign("sort_by_hits_link", "index.php?module=forums&amp;show=showforum&amp;fid=" . $fid . "&amp;sortby=views&amp;sort=$order");
	$AVE_Template->assign("sort_by_rating_link", "index.php?module=forums&amp;show=showforum&amp;fid=" . $fid . "&amp;sortby=rating&amp;sort=$order");
	$AVE_Template->assign("sort_by_lastpost_link", "index.php?module=forums&amp;show=showforum&amp;fid=" . $fid . "&amp;sortby=last_post_int&amp;sort=$order");

	if ($num > $limit)
	{
		$page_nav = " <a class=\"page_navigation\" href=\"index.php?module=forums&amp;show=showforum&amp;fid={$fid}&amp;unit={$unit}&amp;period={$period}&amp;sortby=$order_by&amp;sort=$order_orig&amp;pp={$limit}&amp;page={s}\">{t}</a> ";
		$page_nav = get_pagination($seiten, 'page', $page_nav);
		$AVE_Template->assign('pages', $page_nav);
	}

	// foren fuer das dropdown feld
	$forums_dropdown = array();
	$this->getForums(0, $forums_dropdown, "", $fid);

	$categories = array();
	$this->getCategories(0, $categories, "");

	$AVE_Template->assign("subnavi", @$subnavi);
	$AVE_Template->assign("rsslink", "index.php?rss=forums&amp;fid=$fid");
	$AVE_Template->assign("categories_dropdown", $categories);
	$AVE_Template->assign("forum", $forum_obj);
	$AVE_Template->assign("f_id", $forum_obj->id);
	$AVE_Template->assign("newcatlink", $newcatlink);
	$AVE_Template->assign("categories", $subcat_array);
	$AVE_Template->assign("forums", @$subforum_array);
	$AVE_Template->assign("topics", $topic_array);

	$tpl_out = $AVE_Template->fetch($mod['tpl_dir'] . $this->_ShowForumTpl);
	define("MODULE_CONTENT", $tpl_out);
	define("MODULE_SITE", $sname);
}
?>