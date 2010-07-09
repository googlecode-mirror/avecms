<?php

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
				Id             = '',
				BenutzerId     = '" . $row->uid . "',
				BenutzerName   = '" . $row->uname . "',
				GroupIdMisc    = '" . $row->group_id_misc . "',
				Beitraege      = '" . $row->user_posts . "',
				ZeigeProfil    = '" . $row->show_public . "',
				Signatur       = '" . $row->user_sig . "',
				Icq            = '" . $row->user_icq . "',
				Aim            = '" . $row->user_aim . "',
				Skype          = '" . $row->user_skype . "',
				Emailempfang   = '" . (($row->user_viewemail=='yes' || $row->user_viewemail=='') ? 1 : 0) . "',
				Pnempfang      = '" . (($row->user_canpn=='yes') ? 1 : 0) . "',
				Avatar         = '" . $row->user_avatar . "',
				AvatarStandard = '" . $row->usedefault_avatar . "',
				Webseite       = '" . $row->url . "',
				Unsichtbar     = '" . (($row->invisible=='yes') ? 1 : 0) . "',
				Interessen     = '" . $row->user_interests . "',
				email          = '" . $row->email . "',
				reg_time       = '" . $row->user_regdate . "',
				GeburtsTag     = '" . $row->user_birthday . "'
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