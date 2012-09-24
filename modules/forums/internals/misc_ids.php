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
		$queryfirst = "SELECT uid, group_id_misc FROM " . PREFIX . "_modul_forum_userprofile WHERE uid = '" . UID . "'";
		$result = $AVE_DB->Query($queryfirst);
		$user = $result->FetchRow();

		if(is_object($user)&& $user->group_id_misc != "")
		{
			$group_ids_pre = UGROUP . ";" . $user->group_id_misc;
			$group_ids     = @explode(";", $group_ids_pre);
		} else {
			$group_ids[] = UGROUP;
		}
	} else {
		$group_ids[] = 2;
	}
}
?>