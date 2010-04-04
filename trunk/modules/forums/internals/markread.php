<?php
/*::::::::::::::::::::::::::::::::::::::::
 System name: cpengine 
 Short Desc: Full Russian Security Power Pack 
 Version: 2.0 (Service Pack 2)
 Authors:  Arcanum (php@211.ru) &  Censored!
 Date: March 18, 2008
::::::::::::::::::::::::::::::::::::::::*/

if(!defined("MARKREAD")) exit;
if(isset($_GET['what']) && ($_GET['what']=='forum' || $_GET['what']=='topic'))
switch ($_GET['what'])
{
	case 'forum':
		if (isset($_GET['forum_id']) && $_GET['forum_id'] != '' && is_numeric($_GET['forum_id']))
		{
			$this->setForumAsRead(addslashes($_GET['forum_id']));
			header("Location:" . $_SERVER['HTTP_REFERER']);
			exit;
		} else {
			$this->setForumAsRead();
			header("Location:" . $_SERVER['HTTP_REFERER']);
			exit;
		}
	break;
}
?>