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
				Id = '',
				BenutzerId = '" . $row->uid . "',
				BenutzerName = '" . $row->uname . "',
				GroupIdMisc = '" . $row->group_id_misc . "',
				Beitraege = '" . $row->user_posts . "',
				ZeigeProfil = '" . $row->show_public . "',
				Signatur = '" . $row->user_sig . "',
				Icq = '" . $row->user_icq . "',
				Aim = '" . $row->user_aim . "',
				Skype = '" . $row->user_skype . "',
				Emailempfang = '" . (($row->user_viewemail=='yes' || $row->user_viewemail=='') ? 1 : 0) . "',
				Pnempfang = '" . (($row->user_canpn=='yes') ? 1 : 0) . "',
				Avatar = '" . $row->user_avatar . "',
				AvatarStandard = '" . $row->usedefault_avatar . "',
				Webseite = '" . $row->url . "',
				Unsichtbar = '" . (($row->invisible=='yes') ? 1 : 0) . "',
				Interessen = '" . $row->user_interests . "',
				Email = '" . $row->email . "',
				Registriert = '" . $row->user_regdate . "',
				GeburtsTag = '" . $row->user_birthday . "'
		");

		if($row->uid != 1)
		{
			$AVE_DB->Query("
				INSERT
				INTO " . PREFIX . "_users
				SET
					Id = '" . $row->uid . "',
					Kennwort = '" . $row->pass . "',
					Email = '" . $row->email . "',
					Strasse = '" . $row->street . "',
					HausNr = '',
					Postleitzahl = '" . $row->zip . "',
					city = '" . $row->user_from . "',
					Telefon = '" . $row->phone . "',
					Telefax = '" . $row->fax . "',
					Bemerkungen = '',
					Vorname = '" . $row->name . "',
					Nachname = '" . $row->lastname . "',
					`UserName` = '" . $row->uname . "',
					Benutzergruppe = '" . $row->ugroup . "',
					Registriert = '" . $row->user_regdate . "',
					Status = '" . $row->status . "',
					ZuletztGesehen = '" . $row->last_login . "',
					Land = '" . $row->country . "',
					Geloescht = '',
					GeloeschtDatum = '',
					emc = '',
					IpReg = '',
					new_pass = '" . $row->passtemp . "',
					Firma = '" . addslashes($row->company) . "',
					UStPflichtig = '1',
					GebTag = '" . $row->user_birthday . "'
			");
		}
	}
}
?>