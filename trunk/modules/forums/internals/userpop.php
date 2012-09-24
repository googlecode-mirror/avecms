<?php

/**
 * 
 *
 * @package AVE.cms
 * @subpackage module_Forums
 * @filesource
 */
if(!defined("USERPOP")) exit;

global $AVE_DB, $AVE_Template, $mod;

$limit = 20;

$Phrase = (isset($_REQUEST['Phrase']) && $_REQUEST['Phrase'] != '' && $_REQUEST['Phrase'] > 0 && is_numeric($_REQUEST['Phrase']) && $_REQUEST['Phrase']==1) ? " = " : " LIKE ";
$searchUser = (isset($_REQUEST['uname']) && !empty($_REQUEST['uname'])) ? " a.uname $Phrase '" . addslashes($_REQUEST['uname']). "%%' AND " : "";

$query  = "SELECT
		a.pn_receipt,
		a.uname,
		a.uid,
		b.Id,
		b.status
	FROM
		" . PREFIX . "_modul_forum_userprofile as a,
		" . PREFIX . "_users as b
	WHERE
		a.uid = b.Id AND
		a.pn_receipt = '1' AND
		" . $searchUser . "
		b.status = '1'
	ORDER BY
		a.uname ASC
";

$r_poster = $AVE_DB->Query($query);
$num = $r_poster->NumRows();

$seiten = ceil($num / $limit);
$a = get_current_page() * $limit - $limit;

$r_poster = $AVE_DB->Query($query . "LIMIT $a,$limit");

$poster = array();
while ($post = $r_poster->FetchRow())
{
	$poster[] = $post;
}

$AVE_Template->assign("poster", $poster);

//=======================================================
// Navigation erzeugen
//=======================================================
if($num > $limit){
	$nav = " <a class=\"page_navigation\" href=\"index.php?module=forums&show=userpop&pop=1&theme_folder=" . $_GET['theme_folder'] . "&uname=" . @$_REQUEST['uname'] . "&Phrase=" . @$_REQUEST['Phrase'] . "&page={s}\">{t}</a> ";
	$nav = get_pagination($seiten, 'page', $nav);
	$AVE_Template->assign("nav", $nav) ;
}

$tpl_out = $AVE_Template->fetch($mod['tpl_dir'] . "users.tpl");
define("MODULE_CONTENT", $tpl_out);
define("MODULE_SITE",  $mod['config_vars']['UserpopName']);
?>