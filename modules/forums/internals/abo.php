<?php

/**
 * 
 *
 * @package AVE.cms
 * @subpackage module_Forums
 * @filesource
 */
if(!defined("SETABO") || UGROUP == 2) exit;

global $AVE_DB;

switch($onoff)
{
	case 'on':
		$r_subscriptions = $AVE_DB->Query("SELECT notification FROM " . PREFIX . "_modul_forum_topic WHERE id = '" . addslashes($_GET['t_id']) . "'");
		$subscriptions = $r_subscriptions->FetchRow();
		$user_id = split(",", $subscriptions->notification);

		if (!in_array(UID, $user_id))
		{
			$AVE_DB->Query("UPDATE " . PREFIX . "_modul_forum_topic SET notification = CONCAT(notification, ';', '".UID."') WHERE id = '" . addslashes($_GET['t_id']) . "'");
		}
	break;

	case 'off':
		$sql = $AVE_DB->Query("SELECT notification FROM " . PREFIX . "_modul_forum_topic WHERE id = '" . addslashes($_GET['t_id']) . "'");
		$row = $sql->FetchRow();

		$new_insert = str_replace(";" . UID, "", $row->notification);
		$AVE_DB->Query("UPDATE " . PREFIX . "_modul_forum_topic set notification='" . $new_insert . "' WHERE id = '" . addslashes($_GET['t_id']) . "'");
	break;
}

header("Location:" . $_SERVER['HTTP_REFERER']);
exit;
?>