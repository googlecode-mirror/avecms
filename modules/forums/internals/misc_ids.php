<?php
/*::::::::::::::::::::::::::::::::::::::::
 System name: cpengine
 Short Desc: Full Russian Security Power Pack
 Version: 2.0 (Service Pack 2)
 Authors:  Arcanum (php@211.ru) &  Censored!
 Date: March 18, 2008
::::::::::::::::::::::::::::::::::::::::*/

if(defined("MISCIDSINC"))
{
	if (@is_numeric(UID))
	{
		$queryfirst = "SELECT GroupIdMisc FROM " . PREFIX . "_modul_forum_userprofile WHERE BenutzerId = '" . UID . "'";
		$result = $GLOBALS['AVE_DB']->Query($queryfirst);
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