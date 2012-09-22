<?php

/**
 * 
 *
 * @package AVE.cms
 * @subpackage module_Forums
 * @filesource
 */
if(defined("MISCIDSINC"))
{
	global $AVE_DB;

	if (@is_numeric(UID))
	{
		$queryfirst = "SELECT GroupIdMisc FROM " . PREFIX . "_modul_forum_userprofile WHERE BenutzerId = '" . UID . "'";
		$result = $AVE_DB->Query($queryfirst);
		$user = $result->FetchRow();

		if(is_object($user)&& $user->GroupIdMisc != "")
		{
			$group_ids_pre = UGROUP . ";" . $user->GroupIdMisc;
			$group_ids     = @explode(";", $group_ids_pre);
		} else {
			$group_ids[] = UGROUP;
		}
	} else {
		$group_ids[] = 2;
	}
}
?>