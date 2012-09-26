<?php

/**
 * 
 *
 * @package AVE.cms
 * @subpackage module_Forums
 * @filesource
 */
if(!defined("MYPROFILE")) exit;

global $AVE_DB, $AVE_Template, $mod;

if(!isset($_SESSION['user_id']))
{
	$this->msg($mod['config_vars']['ErrornoPerm']);
}
$sql = $AVE_DB->Query("SELECT
	u.*,
	us.status,
	us.user_group
FROM
	".PREFIX."_modul_forum_userprofile as u,
	".PREFIX."_users as us
WHERE
	uid = '" . addslashes($_SESSION['user_id']) . "' AND
	us.status = '1' AND
	us.Id = u.uid

");
$n = $sql->NumRows();

if(!$n)
{
	$this->msg($mod['config_vars']['ProfileError']);
}

$r = $sql->FetchAssocArray();

if($r['uname_changed'] >= '1' && !$this->fperm('changenick')) $AVE_Template->assign('changenick', 'no');
if(!$this->fperm('changenick')) $AVE_Template->assign('changenick_once', '1');

$r['OwnAvatar'] = $this->getAvatar($r['user_group'],$r['avatar'],$r['avatar_standard_group']);
if(@!is_file(BASE_DIR . '/modules/forums/avatars/' . $r['avatar'])) $r['avatar'] = '';

// avatar
$avatar = '';
$own = 1;
$permown = false;

// wenn er admin ist, fallen alle regeln weg
if ($this->fperm('alles') || $this->fperm('own_avatar') || UGROUP == 1)
{
	$permown = true;
} 
else 
{
	// wenn seine gruppe die rechte besitzt, eigene avatar zu nutzen
	if ($this->fperm('own_avatar'))
	{
		$permown = true;
	}
}

if($permown == true)
{
	$AVE_Template->assign('avatar_upload', 1);
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
	// Benutzername prьfen
	//=======================================================
	if((isset($_POST['uname'])) && ($this->checkIfUserName(addslashes($_POST['uname']),addslashes($_SESSION['forum_user_name']))))
	{
		$errors[] = $mod['config_vars']['PE_UsernameInUse'];
		$r['uname'] = trim(htmlspecialchars($_POST['uname']));
	}

	if(( @isset($_POST['uname']) && @empty($_POST['uname'])) || preg_match($muster, str_replace($allowed,'',@$_POST['uname']) ))
	{
		$errors[] = $mod['config_vars']['PE_Username'];
	}

	//=======================================================
	// E-Mail prьfen
	//=======================================================
	if(!empty($_POST['email']) && $this->checkIfUserEmail($_POST['email'], $_SESSION['forum_user_email']))
	{
		$errors[] = $mod['config_vars']['PE_EmailInUse'];
	}

	if(empty($_POST['email']) || !preg_match($muster_email, $_POST['email']))
	{
		$errors[] = $mod['config_vars']['PE_Email'];
	}

	//=======================================================
	// WENN GEBURTSTAG IM FALSCHEN FORMAT
	//=======================================================
	if(!empty($_POST['birthday']) && !preg_match($muster_geb, $_POST['birthday']))
	{
		$errors[] = $mod['config_vars']['PE_WrongBd'];
	}

	if(!empty($_POST['birthday']))
	{
		$check_year = explode(".", $_POST['birthday']);
		if(@$check_year[0] > 31 || @$check_year[1] > 12 || @$check_year[2] < date("Y")-75)
		{
			$errors[] = $mod['config_vars']['PE_WrongBd'];
		}
	}

	/**
	* Аватар
	*
	*/
	if(isset($_POST['sys_avatar']) && $_POST['sys_avatar']!='')
	{
		$avatar = ",avatar  = 'system/" . $_POST['sys_avatar'] . "'";
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

				$avatar = ",avatar  = '$fupload_name'";

				#$sql_old = $AVE_DB->Query("SELECT Avatar FROM " . PREFIX . "_modul_forum_userprofile WHERE uid='" . UID . "'");
				#$row_old = $sql_old->FetchRow();
				#@unlink($target . $row_old->Avatar);
				#$avatar .= "Avatar ='$fupload_name',";
			}
		}
	}

	foreach ($_POST as $key => $value) 
	{
		$r[$key] = trim(htmlspecialchars($_POST[$key]));
	}

	//=======================================================
	if(is_array($errors) && count($errors) > 0)
	{
		$ok = false;
		$AVE_Template->assign("errors", $errors);
	} 
	else 
	{
		if(!empty($r['birthday']))
		{
			$AVE_DB->Query("UPDATE ".PREFIX."_users SET birthday = '" . @$r['birthday'] . "' WHERE Id = '" . $_SESSION['user_id'] . "'");
		}

		if(isset($r['del_avatar']) && $r['del_avatar']==1)
		{
			$sql = $AVE_DB->Query("SELECT uid, avatar FROM ".PREFIX."_modul_forum_userprofile  WHERE uid = '" . $_SESSION['user_id'] . "'");
			$row_a = $sql->FetchRow();

			if(strpos($row_a->avatar, 'system/') === false)
			{
				@unlink(BASE_DIR . '/modules/forums/avatars/' . $row_a->avatar);
			}

			$AVE_DB->Query("
				UPDATE
					".PREFIX."_modul_forum_userprofile
				SET
					avatar                = '',
					avatar_standard_group = '1'
				WHERE
					uid = '" . $_SESSION['user_id'] . "'");
			$avatar = '';
		}

		// Prьfen, ob Benutzername mehr als 1 mal geдndert wurde und ob er das
		// recht hat, diesen zu дndern
		$BC = '';
		$sql = $AVE_DB->Query("SELECT uid, uname, uname_changed FROM " . PREFIX . "_modul_forum_userprofile WHERE uid = '" . $_SESSION['user_id'] . "'");
		$row = $sql->FetchRow();
		if(($row->uname != $r['uname']) && ($row->uname_changed < '1' || $this->fperm('changenick')) )
		{
			$BC = "
				,uname_changed = uname_changed+1
				,uname = '" . $r['uname'] . "'
				";
		}

		$q = "UPDATE ".PREFIX."_modul_forum_userprofile
			SET
				show_profile          = '" . @$r['show_profile'] . "',
				invisible             = '" . @$r['invisible'] . "',
				email_receipt         = '" . @$r['email_receipt'] . "',
				pn_receipt            = '" . @$r['pn_receipt'] . "',
				email                 = '" . @$r['email'] . "',
				icq                   = '" . @$r['icq'] . "',
				aim                   = '" . @$r['aim'] . "',
				skype                 = '" . @$r['skype'] . "',
				email_show            = '" . @$r['email_show'] . "',
				icq_show              = '" . @$r['icq_show'] . "',
				aim_show              = '" . @$r['aim_show'] . "',
				skype_show            = '" . @$r['skype_show'] . "',
				birthday_show         = '" . @$r['birthday_show'] . "',
				web_site_show         = '" . @$r['web_site_show'] . "',
				interests_show        = '" . @$r['interests_show'] . "',
				signature_show        = '" . @$r['signature_show'] . "',
				web_site              = '" . @$r['web_site'] . "',
				interests             = '" . @$r['interests'] . "',
				signature             = '" . @$r['signature'] . "',
				gender                = '" . @$r['gender'] . "',
				birthday              = '" . @$r['birthday'] . "',
				avatar_standard_group = '" . @$r['avatar_standard_group'] . "'
 				$avatar
				$BC

			WHERE
				uid = '" . $_SESSION['user_id'] . "'";

		$AVE_DB->Query($q);
		$this->msg($mod['config_vars']['ProfileOK'], 'index.php?module=forums&show=publicprofile');
	}
}

$AVE_Template->assign('prefabAvatars', $this->prefabAvatars(@$r['avatar']));
$AVE_Template->assign('avatar_width', MAX_AVATAR_WIDTH);
$AVE_Template->assign('avatar_height', MAX_AVATAR_HEIGHT);
$AVE_Template->assign('avatar_size', round(MAX_AVATAR_BYTES/1024));
$AVE_Template->assign('r', $r);
$tpl_out = $AVE_Template->fetch($mod['tpl_dir'] . 'myprofile.tpl');
define("MODULE_CONTENT", $tpl_out);
define("MODULE_SITE", $mod['config_vars']['MyProfilePublic']);
?>