<?php

/**
 * 
 *
 * @package AVE.cms
 * @subpackage module_Forums
 * @filesource
 */
if(!defined("FLOGIN")) exit;

global $AVE_DB;

$r_pass = $AVE_DB->Query("SELECT password, title FROM " . PREFIX . "_modul_forum_forum WHERE id = '" . addslashes($_REQUEST['fid']) . "'");
$pass = $r_pass->FetchRow();

if (is_object($pass) && isset($_POST['pass']) && md5(md5($_POST['pass'])) == $pass->password)
{
	$_SESSION["f_pass_id_" . addslashes($_REQUEST['fid'])] =  md5(md5($_POST['pass']));
	header("Location:index.php?module=forums&show=showforum&fid=" . $_POST['fid']);
} else {
	header("Location:" . $_SERVER['HTTP_REFERER']);
	exit;
}
?>