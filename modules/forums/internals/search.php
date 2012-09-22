<?php

/**
 * 
 *
 * @package AVE.cms
 * @subpackage module_Forums
 * @filesource
 */
if(!defined("SEARCH")) exit;

global $AVE_DB, $AVE_Template, $mod;

// Kein Suchbegriff... Weiterleiten
if (@$_GET['pattern'] == "" && @$_GET['user_name'] == "")
{
	$this->msg($mod['config_vars']['SearchNoKey'], 'index.php?module=forums&show=search_mask');
}

// typ des topics
$type = "1";
$_GET['type'] = (isset($_GET['type']) && is_numeric($_GET['type']) && $_GET['type'] > 0) ? $_GET['type'] : '';
if(!empty($_GET['type']))
{
	switch ($_GET['type'])
	{
		case 1:
		$type = "t.type = " . TOPIC_TYPE_STICKY;
		break;
		case 2:
		$type = "t.type = " . TOPIC_TYPE_ANNOUNCE;
		break;
		case 3:
		$type = "t.status = " . FORUM_STATUS_MOVED;
		default:
		break;
	}
}

// art der suche
$search_type = 'REGEXP';
$search_prefix = '';

$search_type = (isset($_GET['regexp']) && $_GET['regexp'] == 1) ? 'REGEXP' : 'LIKE';
$search_prefix = (isset($_GET['regexp']) && $_GET['regexp'] == 1) ? '' : '%';

// schluesselwort
$pattern_or = @explode(' or ', strtolower($_GET['pattern']));
$pattern_tmp = "";
$p_and_array = array();

foreach ($pattern_or as $part) {
	$pattern_and = @explode(' and ', strtolower($part));
	$sub_pattern = array();

	foreach ($pattern_and as $sub_part) {
		$sub_part = trim($sub_part);

		// die gesamten beitraege durchsuchen
		if ($_GET['search_post'] == 1) {
			$sub_pattern[] = "
			(
			p.title $search_type '" . $search_prefix . $sub_part . $search_prefix . "' OR
			p.message $search_type '" . $search_prefix . $sub_part . $search_prefix . "' OR
			t.title $search_type '" . $search_prefix . $sub_part . $search_prefix . "'
			)";
			// nur den beitrag durchsuchen
		} else {
			$sub_pattern[] = "
			(
			p.title $search_type '" . $search_prefix . $sub_part . $search_prefix . "' OR
			t.title $search_type '" . $search_prefix . $sub_part . $search_prefix . "'
			)";
		}
	}
	$pattern_tmp = @implode(' AND ', $sub_pattern);
	$p_and_array[] = $pattern_tmp;
}

$pattern = @implode(' OR ', $p_and_array);


// sortieren nach
$order_by = "t.title";

if(isset($_GET['search_sort']))
{
	switch ($_GET['search_sort'])
	{
		case 1:
		$order_by = "t.title";
		break;
		case 2:
		$order_by = "t.replies";
		break;
		case 3:
		$order_by = "author";
		break;
		case 4:
		$order_by = "forum";
		break;
		case 5:
		$order_by = "views";
		break;
		case 6:
		$order_by = "datum";
		break;
	}
}

// sortieren
$order = (isset($_GET['ascdesc'])) ? addslashes($_GET['ascdesc']) : '';

// nach benutzer suchen
$search_by_user = "(1)";

if (isset($_GET['user_name']) && !empty($_GET['user_name']))
{
	// exakte suche
	if ($_GET['user_opt'] == 1)
	{
		$search_by_user = "(u.BenutzerName LIKE '" . addslashes($_GET['user_name']) . "')";
	} elseif ($_GET['user_opt'] == 0) {
		$search_by_user = "(u.BenutzerName LIKE '%" . addslashes($_GET['user_name']) . "%')";
	}
}

// suche in foren
$search_in_forums = "(1)";
$nav_sinf = "";
// Dummy-Array
if (@$_GET['search_in_forums'] == '' || @$_GET['search_in_forums'] == 'Array') @$_GET['search_in_forums'] = array('0','');


if ($_GET['search_in_forums'] != "")
{
	if(isset($_GET['unserialize']) && $_GET['unserialize'] == 1)
	{
		$_GET['search_in_forums'] = base64_decode($_GET['search_in_forums']);
		$_GET['search_in_forums'] = unserialize($_GET['search_in_forums']);
	} else {

	}

	$nav_sinf = base64_encode(serialize($_GET['search_in_forums']));

	// foren die zu durchsuchen sind durchgehen
	// und die foren rausfiltern die die gruppe
	// nicht durchsuchen kann
	$allowed_forums = array();

	// wenn alle foren durchsucht werden sollen,
	// muessen zunaechst die foren ins array geschoben
	// werden, die auch durchsucht werden duerfen
	if (in_array(0, $_GET['search_in_forums']))
	{
		$q_all_forums = "SELECT id FROM " . PREFIX . "_modul_forum_forum";
		$r_all_forums = $AVE_DB->Query($q_all_forums);

		while ($one_forum = $r_all_forums->FetchRow())
		{
			$f_perms = $this->getForumPermissions($one_forum->id, UGROUP);
			if ( ($f_perms[FORUM_PERMISSION_CAN_SEARCH_FORUM] == 1) && ($f_perms[FORUM_PERMISSION_CAN_SEE] == 1) )
			{
				$allowed_forums[] = $one_forum->id;
			}
			$f_perms = "";
		}
		// ansonsten gehe alle ausgewaehlten foren durch und
		// ueberpruefe die berechtigung
	} else {
		foreach ($_GET['search_in_forums'] as $forum)
		{
			$f_perms = $this->getForumPermissions($forum, UGROUP);
			#if ($f_perms[FORUM_PERMISSION_CAN_SEARCH_FORUM] == 1) {
			if ( ($f_perms[FORUM_PERMISSION_CAN_SEARCH_FORUM] == 1) && ($f_perms[FORUM_PERMISSION_CAN_SEE] == 1) )
			{
				$allowed_forums[] = $forum;
			}
		}
	}

	$search_in_forums = "(f.id = " . @implode(' OR f.id = ', $allowed_forums) . ")";


}

// suche nach dem datum
$search_by_date = "(1)";
$date_comparator = (@$_GET['b4after'] == 0) ? ' <= ' : ' >= ';
// Tage
$divisor = 60 * 60 * 24;
//$search_by_date = (@$_GET['date'] == 0) ? "(1)" : "((UNIX_TIMESTAMP(NOW()) / $divisor - (UNIX_TIMESTAMP(t.datum) / $divisor)) $date_comparator " . $_GET['date'] . ")";
$search_by_date = (@$_GET['date'] == 0) ? "(1)" : "(NOW() - INTERVAL " . $_GET['date'] . " DAY $date_comparator t.datum)";


$query = "SELECT DISTINCT
		t.id,
		t.forum_id,
		t.title,
		t.replies,
		t.views,
		t.type,
		t.datum,
		t.status,
		t.posticon,
		t.uid,
		r.rating,
		f.status AS f_status,
		f.title AS f_title,
		u.BenutzerName AS autor,
		f.title AS forum,
		t.opened,
		p.opened
	FROM
		" . PREFIX . "_modul_forum_topic AS t,
		" . PREFIX . "_modul_forum_post AS p,
		" . PREFIX . "_modul_forum_forum AS f,
		" . PREFIX . "_modul_forum_userprofile AS u,
		" . PREFIX . "_modul_forum_rating AS r
	WHERE
		(" . $pattern . ") AND
		(" . $type . ") AND
		(t.id = p.topic_id AND t.forum_id = f.id AND u.BenutzerId = t.uid AND r.topic_id = t.id) AND
		f.active = 1 AND
		$search_by_user AND
		$search_in_forums AND
		$search_by_date
	ORDER BY
		t.type DESC,
		" . $order_by . " " . $order;

$result = $AVE_DB->Query($query);
$matches = array();

while ($hit = $result->FetchAssocArray())
{
	// freizuschaltende beitrage nicht beruecksichtigen!
	if(is_mod($hit['forum_id']) || ($hit['opened'] == 1) ) {

		$q_forum = "SELECT id, status FROM " . PREFIX . "_modul_forum_forum WHERE id = '" . $hit['forum_id'] . "'";
		$r_forum = $AVE_DB->Query($q_forum);
		$forum = $r_forum->FetchRow();

		$rating_array = @explode(",", $hit['rating']);
		$hit['rating'] = (int) ( array_sum($rating_array) / count($rating_array) );

		$hit['link'] = "index.php?module=forums&amp;show=showtopic&amp;toid=" . $hit['id'];

		if ($hit['status'] == FORUM_STATUS_MOVED) {
			$hit['statusicon'] = $this->getIcon("thread_moved.gif", "moved");
		} else {
			if (UGROUP == 2 || ($hit['f_status'] == FORUM_STATUS_CLOSED) )
			{
				// nicht eingeloggt oder forum geschlossen
				$hit['statusicon'] = $this->getIcon("thread_lock.gif", "lock");
			} else {
			  $this->setTopicIcon($hit, $forum);
			}
		}

		$hit['autorlink'] = "index.php?module=forums&amp;show=userprofile&amp;user_id=" . $hit['uid'];

		$matches[] = $hit;
	}
}

// wenn keinen ergebnisse gefunden wurden...
if(!$matches)
{
	$this->msg($mod['config_vars']['SearchNotFound'], 'index.php?module=forums&show=search_mask');
}

// seitennavigation
$page_order_by = (isset($_GET["sortby"]) && $_GET["sortby"] != "") ? $_GET["sortby"] : "datum";
$page_order = ($order != "") ? $order : "DESC";
$num = count($matches);

$limit = (isset($_REQUEST['pp']) && $_REQUEST['pp'] != '' && is_numeric($_REQUEST['pp'])) ? $_REQUEST['pp'] : 15;

if(!isset($page)){
	$page = 1;
}

$seiten = ceil($num / $limit);
$a = get_current_page() * $limit - $limit;


if ($num > $limit) {
	$page_nav = " <a class=\"page_navigation\" href=\"index.php?module=forums&amp;show=search" . "&amp;type=" . $_GET['type']
		. "&amp;pattern=" . $_GET['pattern']
		. ((isset($_GET['user_name']) && $_GET['user_name'] != '') ? "&amp;user_name=" . $_GET['user_name'] : '' )
		. "&amp;search_in_forums=" . ( (!empty($nav_sinf)) ? $nav_sinf . "&amp;unserialize=1" : "" )
		. ((isset($_GET['user_opt']) && $_GET['user_opt'] != '') ? "&amp;user_opt=" . $_GET['user_opt'] : '' )
		. "&amp;search_post=" . $_GET['search_post']
		. ((isset($_GET['date']) && $_GET['date'] != '') ? "&amp;date=" . $_GET['date'] : '' )
		. ((isset($_GET['b4after']) && $_GET['b4after'] != '') ? "&amp;b4after=" . $_GET['b4after'] : '' )
		. ((isset($_GET['search_sort']) && $_GET['search_sort'] != '') ? "&amp;search_sort=" . $_GET['search_sort'] : '' )
		. ((isset($_GET['ascdesc']) && $_GET['ascdesc'] != '') ? "&amp;ascdesc=" . $_GET['ascdesc'] : '' )
		. "&amp;pp=" . $limit . "&amp;page={s}\">{t}</a> ";
	$page_nav = get_pagination($seiten, 'page', $page_nav);
	$AVE_Template->assign('pages', $page_nav);
}

$AVE_Template->assign("matches", array_slice($matches, $a, $limit));
$AVE_Template->assign("navigation", "<a class='forum_links_navi' href='index.php?module=forums'>"
		. $mod['config_vars']['PageNameForums'] . "</a>"
		. $mod['config_vars']['ForumSep']
		. "<a class='forum_links_navi' href='index.php?module=forums&amp;show=search_mask'>"
		. $mod['config_vars']['ForumsSearch']
		. "</a>" );
$AVE_Template->assign("matches_count", $result->NumRows());
#$AVE_Template->assign("content", parsetrue("container/".container("forum"), $stitle, $AVE_Template->fetch("forums/result.tpl")));

$tpl_out = $AVE_Template->fetch($mod['tpl_dir'] . 'result.tpl');
define("MODULE_CONTENT", $tpl_out);
define("MODULE_SITE", $mod['config_vars']['ForumsSearch']);
?>