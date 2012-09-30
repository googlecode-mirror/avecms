<?php

/**
 * 
 *
 * @package AVE.cms
 * @subpackage module_Forums
 * @filesource
 */
if(!defined("IMPORT")) exit;

function userImport()
{
	global $AVE_DB;

	$sql = $AVE_DB->Query("SELECT * FROM kpro_user WHERE uid != 2");

	while($row = $sql->FetchRow())
	{
		$AVE_DB->Query("
			INSERT
			INTO " . PREFIX . "_modul_forum_userprofile
			SET
				id             = '',
				uid            = '" . $row->uid . "',
				uname          = '" . $row->uname . "',
				group_id_misc  = '" . $row->group_id_misc . "',
				messages       = '" . $row->user_posts . "',
				show_profile   = '" . $row->show_public . "',
				signature      = '" . $row->user_sig . "',
				icq            = '" . $row->user_icq . "',
				aim            = '" . $row->user_aim . "',
				skype          = '" . $row->user_skype . "',
				email_receipt  = '" . (($row->user_viewemail=='yes' || $row->user_viewemail=='') ? 1 : 0) . "',
				pn_receipt     = '" . (($row->user_canpn=='yes') ? 1 : 0) . "',
				avatar         = '" . $row->user_avatar . "',
				avatar_default = '" . $row->usedefault_avatar . "',
				web_site       = '" . $row->url . "',
				invisible      = '" . (($row->invisible=='yes') ? 1 : 0) . "',
				interests      = '" . $row->user_interests . "',
				email          = '" . $row->email . "',
				reg_time       = '" . $row->user_regdate . "',
				birthday       = '" . $row->user_birthday . "'
		");

		if($row->uid != 1)
		{
			$AVE_DB->Query("
				INSERT
				INTO " . PREFIX . "_users
				SET
					Id          = '" . $row->uid . "',
					password    = '" . $row->pass . "',
					email       = '" . $row->email . "',
					street      = '" . $row->street . "',
					street_nr   = '',
					zipcode     = '" . $row->zip . "',
					city        = '" . $row->user_from . "',
					phone       = '" . $row->phone . "',
					telefax     = '" . $row->fax . "',
					description = '',
					firstname   = '" . $row->name . "',
					lastname    = '" . $row->lastname . "',
					user_name   = '" . $row->uname . "',
					user_group  = '" . $row->ugroup . "',
					reg_time    = '" . $row->user_regdate . "',
					status      = '" . $row->status . "',
					last_visit  = '" . $row->last_login . "',
					country     = '" . $row->country . "',
					deleted     = '',
					del_time    = '',
					emc         = '',
					reg_ip      = '',
					new_pass    = '" . $row->passtemp . "',
					company     = '" . addslashes($row->company) . "',
					taxpay      = '1',
					birthday    = '" . $row->user_birthday . "'
			");
		}
	}
}
?>