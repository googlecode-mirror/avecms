<?php
/*::::::::::::::::::::::::::::::::::::::::
 System name: cpengine
 Short Desc: Full Russian Security Power Pack
 Version: 2.0 (Service Pack 2)
 Authors:  Arcanum (php@211.ru) &  Censored!
 Date: March 18, 2008
::::::::::::::::::::::::::::::::::::::::*/

if(!defined("FLOGIN")) exit;
$r_pass = $GLOBALS['AVE_DB']->Query("SELECT password, title FROM " . PREFIX . "_modul_forum_forum WHERE id = '" . addslashes($_REQUEST['fid']) . "'");
$pass = $r_pass->FetchRow();

if (is_object($pass) && isset($_POST['pass']) && md5(md5($_POST['pass'])) == $pass->password)
{
	$_SESSION["f_pass_id_" . addslashes($_REQUEST['fid'])] =  md5(md5($_POST['pass']));
	header("Location:index.php?module=forums&show=showforum&fid=$_POST[fid]");
} else {
	header("Location:" . $_SERVER['HTTP_REFERER']);
	exit;
}
?>