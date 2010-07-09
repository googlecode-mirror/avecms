<?php
/*::::::::::::::::::::::::::::::::::::::::
 System name: cpengine
 Short Desc: Full Russian Security Power Pack
 Version: 2.0 (Service Pack 2)
 Authors:  Arcanum (php@211.ru) &  Censored!
 Date: March 18, 2008
::::::::::::::::::::::::::::::::::::::::*/

if(!defined("MYPROFILE")) exit;
if(!isset($_SESSION['user_id']))
{
	$this->msg($GLOBALS['mod']['config_vars']['ErrornoPerm']);
}
$sql = $GLOBALS['AVE_DB']->Query("SELECT
	u.*,
	us.status,
	us.user_group
FROM
	".PREFIX."_modul_forum_userprofile as u,
	".PREFIX."_users as us
WHERE
	BenutzerId = '" . addslashes($_SESSION['user_id']) . "' AND
	us.status = '1' AND
	us.Id = u.BenutzerId

");
$n = $sql->NumRows();


if(!$n)
{
	$this->msg($GLOBALS['mod']['config_vars']['ProfileError']);
}

$r = $sql->FetchAssocArray();

if($r['BenutzerNameChanged'] >= '1' && !$this->fperm('changenick')) $GLOBALS['AVE_Template']->assign('changenick', 'no');
if(!$this->fperm('changenick')) $GLOBALS['AVE_Template']->assign('changenick_once', '1');




$r['OwnAvatar'] = $this->getAvatar($r['user_group'],$r['Avatar'],$r['AvatarStandard']);
if(@!is_file(BASE_DIR . '/modules/forums/avatars/' . $r['Avatar'])) $r['Avatar'] = '';

// avatar
$avatar = '';
$own = 1;
$permown = false;

// wenn er admin ist, fallen alle regeln weg
if ($this->fperm('alles') || $this->fperm('own_avatar') || UGROUP == 1)
{
	$permown = true;
} else {
	// wenn seine gruppe die rechte besitzt, eigene avatar zu nutzen
	if ($this->fperm('own_avatar'))
	{
		$permown = true;
	}
}

if($permown == true)
{
	$GLOBALS['AVE_Template']->assign('avatar_upload', 1);
}

//doupdate

if(isset($_POST['doupdate']) && $_POST['doupdate'] == 1)
{
	$ok = true;
	$errors = "";
	$allowed = array('*','[',']','-','=');
	$muster = '/[^\x20-\xFF]/';
	$muster_geb = '#(0[1-9]|[12][0-9]|3[01])([[:punct:]| ])(0[1-9]|1[012])\2(19|20)\d\d#';
	$muster_email = '/^[\w.-]+@[a-z0-9.-]+\.(?:[a-z]{2}|com|org|net|edu|gov|mil|biz|info|mobi|name|aero|asia|jobs|museum)$/i';

	//=======================================================
	// Benutzername prüfen
	//=======================================================
	if((isset($_POST['BenutzerName'])) && ($this->checkIfUserName(addslashes($_POST['BenutzerName']),addslashes($_SESSION['forum_user_name']))))
  {
		$errors[] = $GLOBALS['mod']['config_vars']['PE_UsernameInUse'];
		$r['BenutzerName'] = trim(htmlspecialchars($_POST['BenutzerName']));
	}

	if(( @isset($_POST['BenutzerName']) && @empty($_POST['BenutzerName'])) || preg_match($muster, str_replace($allowed,'',@$_POST['BenutzerName']) ))
	{
		$errors[] = $GLOBALS['mod']['config_vars']['PE_Username'];
	}

	//=======================================================
	// E-Mail prüfen
	//=======================================================
	if(!empty($_POST['email']) && $this->checkIfUserEmail($_POST['email'], $_SESSION['forum_user_email']))
	{
		$errors[] = $GLOBALS['mod']['config_vars']['PE_EmailInUse'];
	}

	if(empty($_POST['email']) || !preg_match($muster_email, $_POST['email']))
	{
		$errors[] = $GLOBALS['mod']['config_vars']['PE_Email'];
	}

	//=======================================================
	// WENN GEBURTSTAG IM FALSCHEN FORMAT
	//=======================================================
	if(!empty($_POST['GeburtsTag']) && !preg_match($muster_geb, $_POST['GeburtsTag']))
	{
		$errors[] = $GLOBALS['mod']['config_vars']['PE_WrongBd'];
	}

	if(!empty($_POST['GeburtsTag']))
	{
		$check_year = explode(".", $_POST['GeburtsTag']);
		if(@$check_year[0] > 31 || @$check_year[1] > 12 || @$check_year[2] < date("Y")-75)
		{
			$errors[] = $GLOBALS['mod']['config_vars']['PE_WrongBd'];
		}
	}

	//=======================================================
	// Avatar
	//=======================================================
	if(isset($_POST['SystemAvatar']) && $_POST['SystemAvatar']!='')
	{
		$avatar = ",Avatar  = 'various/" . $_POST['SystemAvatar'] . "'";
	}

	if($this->fperm('own_avatar'))
	{
		$target = BASE_DIR . '/modules/forums/avatars/';
		if(in_array($_FILES['file']['type'], $this->_allowed_imagetypes))
		{
			$filesize = @filesize($_FILES['file']['tmp_name']);
			$file_wh = @GetImageSize($_FILES['file']['tmp_name']);
			$file_wh_w = $file_wh[0];
			$file_wh_h = $file_wh[1];

			$fupload_name = @trim($_FILES['file']['name'],1);
			$fupload_name = @$this->rand_tostring($target ,$fupload_name);

			if( (($file_wh_w <= MAX_AVATAR_WIDTH) && ($file_wh_h <= MAX_AVATAR_HEIGHT) && ($filesize <= MAX_AVATAR_BYTES) && (@$_REQUEST['delav']!=1)) || UGROUP == 1 )
			{
				@move_uploaded_file($_FILES['file']['tmp_name'], $target . $fupload_name);
				@chmod($target . $fupload_name,0777);

				$avatar = ",Avatar  = '$fupload_name'";

				#$sql_old = $GLOBALS['AVE_DB']->Query("SELECT Avatar FROM " . PREFIX . "_modul_forum_userprofile WHERE BenutzerId='" . UID . "'");
				#$row_old = $sql_old->FetchRow();
				#@unlink($target . $row_old->Avatar);
				#$avatar .= "Avatar ='$fupload_name',";

			}
		}
	}

//	@$r['BenutzerName'] = trim(htmlspecialchars($_POST['BenutzerName']));
//	$r['ZeigeProfil'] = @$_POST['ZeigeProfil'];
//	$r['Unsichtbar'] = @$_POST['Unsichtbar'];
//	$r['Emailempfang'] = @$_POST['Emailempfang'];
//	$r['ZeigeProfil'] = @$_POST['ZeigeProfil'];
//	$r['email'] = trim(@$_POST['email']);
//	$r['Icq'] = trim(htmlspecialchars(@$_POST['Icq']));
//	$r['Aim'] = trim(htmlspecialchars(@$_POST['Aim']));
//	$r['Skype'] = trim(htmlspecialchars(@$_POST['Skype']));
//	$r['Email_show'] = @$_POST['Email_show'];
//	$r['Icq_show'] = @$_POST['Icq_show'];
//	$r['Aim_show'] = @$_POST['Aim_show'];
//	$r['Skype_show'] = @$_POST['Skype_show'];
//	$r['GeburtsTag_show'] = @$_POST['GeburtsTag_show'];
//	$r['Webseite_show'] = @$_POST['Webseite_show'];
//	$r['Interessen_show'] = @$_POST['Interessen_show'];
//	$r['Signatur_show'] = @$_POST['Signatur_show'];
//	$r['Webseite'] = trim(htmlspecialchars(@$_POST['Webseite']));
//	$r['Interessen'] = trim(htmlspecialchars(@$_POST['Interessen']));
//	$r['Signatur'] = trim(htmlspecialchars(@$_POST['Signatur']));
//	$r['Geschlecht'] = @$_POST['Geschlecht'];
//	$r['GeburtsTag'] = @$_POST['GeburtsTag'];
//	$r['Pnempfang'] = @$_POST['Pnempfang'];
  foreach ($_POST as $key => $value) {
  	$r[$key] = trim(htmlspecialchars($_POST[$key]));
  }

	//=======================================================
	if(is_array($errors) && count($errors) > 0)
	{
		$ok = false;
		$GLOBALS['AVE_Template']->assign("errors", $errors);
	} else {
		if(!empty($r['GeburtsTag']))
		{
			$GLOBALS['AVE_DB']->Query("UPDATE ".PREFIX."_users SET birthday = '" . @$r['GeburtsTag'] . "' WHERE Id = '" . $_SESSION['user_id'] . "'");
		}

		if(isset($r['DelAvatar']) && $r['DelAvatar']==1)
		{
			$sql = $GLOBALS['AVE_DB']->Query("SELECT Avatar FROM ".PREFIX."_modul_forum_userprofile  WHERE BenutzerId = '" . $_SESSION['user_id'] . "'");
			$row_a = $sql->FetchRow();

			if(strpos($row_a->Avatar, 'various/') === false)
			{
				@unlink(BASE_DIR . '/modules/forums/avatars/' . $row_a->Avatar);
			}

			$GLOBALS['AVE_DB']->Query("
				UPDATE
					".PREFIX."_modul_forum_userprofile
				SET
					Avatar = '',
					AvatarStandard = '1'
				WHERE
					BenutzerId = '" . $_SESSION['user_id'] . "'");
			$avatar = '';
		}

		// Prüfen, ob Benutzername mehr als 1 mal geändert wurde und ob er das
		// recht hat, diesen zu ändern
		$BC = '';
		$sql = $GLOBALS['AVE_DB']->Query("SELECT BenutzerName,BenutzerNameChanged FROM " . PREFIX . "_modul_forum_userprofile WHERE BenutzerId = '" . $_SESSION['user_id'] . "'");
		$row = $sql->FetchRow();
		if(($row->BenutzerName != $r['BenutzerName']) && ($row->BenutzerNameChanged < '1' || $this->fperm('changenick')) )
		{
			$BC = "
				,BenutzerNameChanged = BenutzerNameChanged+1
				,BenutzerName = '" . $r['BenutzerName'] . "'
				";
		}

    $q = "UPDATE ".PREFIX."_modul_forum_userprofile
			SET
				ZeigeProfil = '" . @$r['ZeigeProfil'] . "',
				Unsichtbar = '" . @$r['Unsichtbar'] . "',
				Emailempfang = '" . @$r['Emailempfang'] . "',
				ZeigeProfil = '" . @$r['ZeigeProfil'] . "',
				email = '" . @$r['email'] . "',
				Icq = '" . @$r['Icq'] . "',
				Aim = '" . @$r['Aim'] . "',
				Skype = '" . @$r['Skype'] . "',
				Email_show = '" . @$r['Email_show'] . "',
				Icq_show = '" . @$r['Icq_show'] . "',
				Aim_show = '" . @$r['Aim_show'] . "',
				Skype_show = '" . @$r['Skype_show'] . "',
				GeburtsTag_show = '" . @$r['GeburtsTag_show'] . "',
				Webseite_show = '" . @$r['Webseite_show'] . "',
				Interessen_show = '" . @$r['Interessen_show'] . "',
				Signatur_show = '" . @$r['Signatur_show'] . "',
				Webseite = '" . @$r['Webseite'] . "',
				Interessen = '" . @$r['Interessen'] . "',
				Signatur = '" . @$r['Signatur'] . "',
				Geschlecht = '" . @$r['Geschlecht'] . "',
				GeburtsTag = '" . @$r['GeburtsTag'] . "',
				AvatarStandard = '" . @$r['AvatarStandard'] . "',
				Pnempfang = '" . @$r['Pnempfang'] . "'
 				$avatar
				$BC

			WHERE
				BenutzerId = '" . $_SESSION['user_id'] . "'";

		$GLOBALS['AVE_DB']->Query($q);
		$this->msg($GLOBALS['mod']['config_vars']['ProfileOK'], 'index.php?module=forums&show=publicprofile');
	}

}

$GLOBALS['AVE_Template']->assign('prefabAvatars', $this->prefabAvatars(@$r['Avatar']));
$GLOBALS['AVE_Template']->assign('avatar_width', MAX_AVATAR_WIDTH);
$GLOBALS['AVE_Template']->assign('avatar_height', MAX_AVATAR_HEIGHT);
$GLOBALS['AVE_Template']->assign('avatar_size', round(MAX_AVATAR_BYTES/1024));
$GLOBALS['AVE_Template']->assign('r', $r);
$tpl_out = $GLOBALS['AVE_Template']->fetch($GLOBALS['mod']['tpl_dir'] . 'myprofile.tpl');
define("MODULE_CONTENT", $tpl_out);
define("MODULE_SITE", $GLOBALS['mod']['config_vars']['MyProfilePublic']);
?>