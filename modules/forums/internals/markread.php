<?php

/**
 * 
 *
 * @package AVE.cms
 * @subpackage module_Forums
 * @filesource
 */
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