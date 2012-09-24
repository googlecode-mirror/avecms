<?php

/**
 * 
 *
 * @package AVE.cms
 * @subpackage module_Forums
 * @filesource
 */
if (!defined('USERLIST')) exit;

global $AVE_DB, $AVE_Template, $mod;

//// Beitragszaehler aktualisieren
//$sql_first = $AVE_DB->Query("SELECT Id FROM " . PREFIX . "_modul_forum_userprofile");
//while ($row_first = $sql_first->FetchRow())
//{
//	$sql = $AVE_DB->Query("SELECT COUNT(id) AS counts FROM " . PREFIX . "_modul_forum_post WHERE uid = {$row_first->Id}");
//	while ($row = $sql->FetchRow())
//	{
//		$AVE_DB->Query("UPDATE " . PREFIX . "_modul_forum_userprofile SET Beitraege={$row->counts} WHERE uid={$row_first->Id}");
//	}
//}

// Benutzerabfrage
$user = array();

if (!empty($_REQUEST['orderby']))
{
	$nav_link = '';
	switch ($_REQUEST['orderby'])
	{
		case 'posts_asc':
			$orderby = ' ORDER BY messages ASC';
			$nav_link = '&amp;orderby=posts_asc';
			$img_post = '<img hspace="5" border="0" src="templates/'. THEME_FOLDER.'/modules/forums/sortasc.gif" alt="" />';
			$AVE_Template->assign("img_post", $img_post);
			break;

		case 'posts_desc':
			$orderby = ' ORDER BY messages DESC';
			$nav_link = '&amp;orderby=posts_desc';
			$img_post = '<img hspace="5" border="0" src="templates/'. THEME_FOLDER.'/modules/forums/sortdesc.gif" alt="" />';
			$AVE_Template->assign("img_post", $img_post);
			break;

		case 'reg_asc':
			$orderby = ' ORDER BY reg_time ASC';
			$nav_link = '&amp;orderby=reg_asc';
			$img_reg = '<img hspace="5" border="0" src="templates/'. THEME_FOLDER.'/modules/forums/sortasc.gif" alt="" />';
			$AVE_Template->assign("img_reg", $img_reg);
			break;

		case 'reg_desc':
			$orderby = ' ORDER BY reg_time DESC';
			$nav_link = '&amp;orderby=reg_desc';
			$img_reg = '<img hspace="5" border="0" src="templates/'. THEME_FOLDER.'/modules/forums/sortdesc.gif" alt="" />';
			$AVE_Template->assign("img_reg", $img_reg);
			break;

		case 'name_asc':
			$orderby = ' ORDER BY uname ASC';
			$nav_link = '&amp;orderby=name_asc';
			$img_name = '<img hspace="5" border="0" src="templates/'. THEME_FOLDER.'/modules/forums/sortasc.gif" alt="" />';
			$AVE_Template->assign("img_name", $img_name);
			break;

		case 'name_desc':
			$orderby = ' ORDER BY uname DESC';
			$nav_link = '&amp;orderby=name_desc';
			$img_name = '<img hspace="5" border="0" src="templates/'. THEME_FOLDER.'/modules/forums/sortdesc.gif" alt="" />';
			$AVE_Template->assign("img_name", $img_name);
			break;
	}
}
else
{
	$orderby = ' ORDER BY messages DESC';
}

// Aktuelle Seite fьr Links
$f_page = (!empty($_REQUEST['page']) && is_numeric($_REQUEST['page']) && $_REQUEST['page']>0)
	? "&amp;page=". $_REQUEST['page']
	: "";

// Sortierungs-Links
$Link_PostSort = (isset($_REQUEST['orderby']) && $_REQUEST['orderby'] == 'posts_asc')
	? "index.php?module=forums&amp;show=userlist&amp;orderby=posts_desc{$f_page}"
	: "index.php?module=forums&amp;show=userlist&amp;orderby=posts_asc{$f_page}";
$Link_RegSort = (isset($_REQUEST['orderby']) && $_REQUEST['orderby'] == 'reg_asc')
	? "index.php?module=forums&amp;show=userlist&amp;orderby=reg_desc{$f_page}"
	: "index.php?module=forums&amp;show=userlist&amp;orderby=reg_asc{$f_page}";
$Link_NameSort = (isset($_REQUEST['orderby']) && $_REQUEST['orderby'] == 'name_asc')
	? "index.php?module=forums&amp;show=userlist&amp;orderby=name_desc{$f_page}"
	: "index.php?module=forums&amp;show=userlist&amp;orderby=name_asc{$f_page}";

$limit = (isset($_REQUEST['pp']) && is_numeric($_REQUEST['pp']) && $_REQUEST['pp'] > 0 ) ? $_REQUEST['pp'] : 25;
$limit = (isset($_REQUEST['print']) && $_REQUEST['print']==1) ? 10000 : $limit;

$a = get_current_page() * $limit - $limit;
$a = (isset($_REQUEST['print']) && $_REQUEST['print']==1) ? 0 : $a;

$sql = $AVE_DB->Query("
	SELECT SQL_CALC_FOUND_ROWS *
	FROM " . PREFIX . "_modul_forum_userprofile
	" . $orderby . "
	LIMIT " . $a . "," . $limit . "
");
while ($row = $sql->FetchRow())
{
	$row->UserWeb = ($row->web_site != '' && $row->web_site_show==1)
		? 'http://' . str_replace('http://', '', $row->web_site)
		: '';
	$row->UserPN = ($row->pn_receipt==1)
		? 'index.php?module=forums&show=pn&amp;action=new&amp;to=' . base64_encode($row->uname)
		: '';
	$row->UserLink = ($row->show_profile==1)
		? "<a class=\"forum_links\" href=\"index.php?module=forums&amp;show=userprofile&amp;user_id={$row->uid}\">{$row->uname}</a>"
		: "$row->uname";
	$row->Posts = $this->num_format($row->messages);
	if ($row->reg_time != '') array_push($user, $row);
}

$num = $AVE_DB->Query("SELECT FOUND_ROWS()")->GetCell();
//if (!isset($page)) $page = 1;
$seiten = $this->getPageNum($num, $limit);

// Navigation
if ($num > $limit)
{
	$nav_link = (empty($nav_link)) ? '' : $nav_link;
	$page_nav = " <a class=\"page_navigation\" href=\"index.php?module=forums&amp;show=userlist{$nav_link}&amp;pp={$limit}&amp;page={s}\">{t}</a> ";
	$page_nav = get_pagination($seiten, 'page', $page_nav);
	$AVE_Template->assign('pages', $page_nav);
}

$AVE_Template->assign("user", $user);
$AVE_Template->assign("Link_PostSort", $Link_PostSort);
$AVE_Template->assign("Link_RegSort", $Link_RegSort);
$AVE_Template->assign("Link_NameSort", $Link_NameSort);

define("MODULE_CONTENT", $AVE_Template->fetch($mod['tpl_dir'] . 'userlist.tpl'));
define("MODULE_SITE", $mod['config_vars']['PageNameUserProfile']);

?>