<?php
/*::::::::::::::::::::::::::::::::::::::::
 System name: cpengine
 Short Desc: Full Russian Security Power Pack
 Version: 2.0 (Service Pack 2)
 Authors:  Arcanum (php@211.ru) &  Censored!
 Date: March 18, 2008
::::::::::::::::::::::::::::::::::::::::*/

define("no_avatar", 1);
define("date_format", "d.m.y, H:i");

class userpage {

	var $_commentwords = 1000;
	var $_anti_spam = 1;
	var $_allowed_imagetypes = array('image/pjpeg', 'image/jpeg', 'image/jpg', 'image/x-png', 'image/png', 'image/gif');

	//=======================================================
	// Userpage Ausgabe
	//=======================================================
	function show($tpl_dir,$lang_file,$uid)
	{

		$sql = $GLOBALS['AVE_DB']->Query("
			SELECT
				a.*,
				c.firstname,lastname,country,user_group,user_name,
				d.*
			FROM
				" . PREFIX . "_modul_userpage  as a,
				" . PREFIX . "_users  as c,
				" . PREFIX . "_modul_forum_userprofile  as d
			WHERE
				c.Id = '" . $uid . "' AND
				d.BenutzerId = '" . $uid . "'
			LIMIT 1
		");

		# LADE TEMPLATE
		$sql_tpl = $GLOBALS['AVE_DB']->Query("SELECT tpl FROM " . PREFIX . "_modul_userpage_template WHERE id = '1'");
		$row_tpl = $sql_tpl->FetchRow();


		# LADE BENUTZERDATEN
		$row = $sql->FetchRow();

		if(!is_object($row)) $this->msg($GLOBALS['AVE_Template']->get_config_vars('ProfileError'),'',$tpl_dir);
		if($row->ZeigeProfil != '1') $this->msg($GLOBALS['AVE_Template']->get_config_vars('NoPublicProfile'),'',$tpl_dir);
		if(!$this->fperm('userprofile')) $this->msg($GLOBALS['AVE_Template']->get_config_vars('ErrornoPerm'),'',$tpl_dir);

		$sql_country = $GLOBALS['AVE_DB']->Query("SELECT country_name FROM " . PREFIX . "_countries WHERE country_code = '".$row->country."'");
		$row_country = $sql_country->FetchRow();


		# ERSETZEN
		$tpl = $row_tpl->tpl;
		$tpl = str_replace("[tag:benutzername]", $row->user_name, $tpl);
		$tpl = str_replace("[tag:header-1]","<?php userpage_header(\"userpanel_forums.tpl\",".$uid."); ?>", $tpl);
		$tpl = str_replace("[tag:header-2]","<?php userpage_header(\"header_sthreads.tpl\",".$uid."); ?>", $tpl);
		$tpl = str_replace("[tag:land]", $row_country->country_name, $tpl);
		$tpl = str_replace("[tag:name]", $row->firstname ." ". $row->lastname, $tpl);
		$tpl = str_replace("[tag:registriert]", date(date_format, $row->reg_time), $tpl);
		$tpl = str_replace("[tag:onlinestatus]", userpage_onlinestatus($row->user_name), $tpl);
		$tpl = str_replace("[tag:onlinestatus-1]", userpage_onlinestatus($row->user_name,1), $tpl);
		$tpl = str_replace("[tag:avatar]",  userpage_avatar($row->user_group,$row->Avatar,$row->AvatarStandard), $tpl);
		$tpl = preg_replace("/\[tag\:(.*?)-([0-9]*)\]/","<?php userpage_felder(\"\\1\",\"\\2\",".$uid."); ?>", $tpl);
		$tpl = preg_replace("/\[tag\:(.*?)\]/","<?php userpage_felder(\"\\1\",\"1\",".$uid."); ?>", $tpl);
		$tpl = preg_replace("/\[tag_forum\:([0-9]*)\]/","<?php userpage_lastposts(\"\\1\",".$uid."); ?>", $tpl);
		$tpl = preg_replace("/\[tag_downloads\:([0-9]*)\]/","<?php userpage_downloads(\"\\1\",".$uid."); ?>", $tpl);
		$tpl = preg_replace("/\[tag_guestbook\:([0-9]*)\]/","<?php userpage_guestbook(\"\\1\",".$uid."); ?>", $tpl);
		$tpl = preg_replace("/\[tag_feld\:([0-9]*)-([0-9]*)\]/","<?php userpage_getfield(\"\\1\",\"\\2\",".$uid."); ?>", $tpl);
		$tpl = preg_replace("/\[tag_feld\:([0-9]*)\]/","<?php userpage_getfield(\"\\1\",\"1\",".$uid."); ?>", $tpl);
		$tpl = preg_replace("[\[tag_lang:(.*?)\]]",  "<?php userpage_lang(\"\\1\"); ?>", $tpl);



		define("MODULE_SITE", $row->user_name.$GLOBALS['AVE_Template']->get_config_vars('UPheader'));


		if(!defined("MODULE_CONTENT"))
		{
			define("MODULE_CONTENT", $tpl);
		}

	}

	//=======================================================
	// Gдstebucheintrag
	//=======================================================
	function displayForm($tpl_dir,$uid,$theme_folder)
	{
		$sql = $GLOBALS['AVE_DB']->Query("SELECT * FROM " . PREFIX . "_modul_userpage WHERE id = '1'");
		$row = $sql->FetchRow();
		$gruppen = explode(',', $row->group_id);

		if($row->can_comment == 1 && in_array(UGROUP, $gruppen))
		{
			$GLOBALS['AVE_Template']->assign('cancomment', 1);
		}
		$GLOBALS['AVE_Template']->assign('MaxZeichen', $this->_commentwords);

		$im = "";

		$sql_ig = $GLOBALS['AVE_DB']->Query("SELECT * FROM " . PREFIX . "_modul_forum_ignorelist WHERE BenutzerId = '$uid' AND IgnoreId = '".$_SESSION['user_id']."'");
		$num_ig = $sql_ig->NumRows();

		if ($num_ig == 1) $GLOBALS['AVE_Template']->assign('cancomment', 1);

		// absenden
		if(isset($_POST['send']) && $_POST['send'] == 1)
		{

			$Text = substr(htmlspecialchars($_POST['Text']), 0, $this->_commentwords);
			$Text_length = strlen($Text);
			$Text .= ($Text_length > $this->_commentwords) ? '...' : '';
			$Text = pretty_chars($Text);

			$error = array();
			if (empty($_POST['title'])) $error[] = $GLOBALS['AVE_Template']->get_config_vars('NoTitle');
			if (empty($Text)) $error[] = $GLOBALS['AVE_Template']->get_config_vars('NoComment');


			if (function_exists("imagettftext") && function_exists("imagepng") && $this->_anti_spam == 1)
			{
				if(empty($_POST['cpSecurecode']) || $_POST['cpSecurecode'] != $_SESSION['cpSecurecode'])
				{
					$error[] = $GLOBALS['AVE_Template']->get_config_vars('NoSecure');

				}
			}

			if (count($error)>0)
			{
				$GLOBALS['AVE_Template']->assign('errors', $error);
				$GLOBALS['AVE_Template']->assign('titel', $_POST['title']);
				$GLOBALS['AVE_Template']->assign('text', $_POST['Text']);
			}
			else
			{
				if (isset($_SESSION['user_id']))  $author = $_SESSION['user_id'];
				else $author = '0';

				if(in_array(UGROUP, $gruppen) && $Text_length > 3)
				{

					$sql = "INSERT INTO " . PREFIX . "_modul_userpage_guestbook (
						id,
						uid,
						ctime,
						author,
						title,
						message
					) VALUES (
						'',
						'" . $uid . "',
						'" . time() . "',
						'" . $author . "',
						'" . $_POST['title'] . "',
						'" . $Text . "'
					)";
					$GLOBALS['AVE_DB']->Query($sql);

				}


				echo '<script>window.opener.location.reload(); window.close();</script>';
			}
		}

		if(function_exists("imagettftext") && function_exists("imagepng") && $this->_anti_spam == 1)
		{
			$codeid = secureCode();
			$im = $codeid;
			$sql_sc = $GLOBALS['AVE_DB']->Query("SELECT Code FROM " . PREFIX . "_antispam WHERE Id = '$codeid'");
			$row_sc = $sql_sc->FetchRow();
			$GLOBALS['AVE_Template']->assign("im", $im);
			$_SESSION['cpSecurecode'] = $row_sc->Code;
			$_SESSION['cpSecurecode_id'] = $codeid;

			$GLOBALS['AVE_Template']->assign("anti_spam", 1);
		}

		$GLOBALS['AVE_Template']->assign('theme_folder', $theme_folder);
		$GLOBALS['AVE_Template']->assign('uid', $uid);
		$GLOBALS['AVE_Template']->display($tpl_dir . 'guestbook_form.tpl');
	}

	//=======================================================
	// Gдstebucheintrдge lцschen
	//=======================================================
	function del_guest($tpl_dir,$gid,$uid,$page)
	{
		if(empty($page)) $page = 1;

		if(UGROUP != 1) $this->msg($GLOBALS['AVE_Template']->get_config_vars('ErrornoPerm'),'index.php?module=userpage&action=show&uid='.$uid.'&page='.$page,$tpl_dir);

		$GLOBALS['AVE_DB']->Query("DELETE FROM " . PREFIX . "_modul_userpage_guestbook WHERE id = '$gid' AND uid = '$uid'");

		$this->msg($GLOBALS['AVE_Template']->get_config_vars('Delok'),'index.php?module=userpage&action=show&uid='.$uid.'&page='.$page,$tpl_dir);


	}

	//=======================================================
	// Kontakt
	//=======================================================
	function showContact($tpl_dir,$method='',$uid,$theme_folder)
	{
		$sql = $GLOBALS['AVE_DB']->Query("SELECT * FROM " . PREFIX . "_modul_forum_userprofile WHERE BenutzerId = '$uid'");
		$row = $sql->FetchRow();

		$sql_ig = $GLOBALS['AVE_DB']->Query("SELECT * FROM " . PREFIX . "_modul_forum_ignorelist WHERE BenutzerId = '$uid' AND IgnoreId = '".$_SESSION['user_id']."'");
		$num_ig = $sql_ig->NumRows();

		if ($num_ig == 1) exit();

		switch($method)
		{
			case 'email':
				$GLOBALS['AVE_Template']->assign('titel', $GLOBALS['AVE_Template']->get_config_vars('Emailc'));
				if($row->Emailempfang == '1') $GLOBALS['AVE_Template']->assign('email', 1);
			break;

			case 'icq':
				$GLOBALS['AVE_Template']->assign('titel', $GLOBALS['AVE_Template']->get_config_vars('Icq'));
				if($row->Icq != '')  $GLOBALS['AVE_Template']->assign('wert', "<a href=\"http://www.icq.com/people/about_me.php?uin=$row->Icq\" target=\"_blank\">$row->Icq</a>");
			break;

			case 'aim':
				$GLOBALS['AVE_Template']->assign('titel', $GLOBALS['AVE_Template']->get_config_vars('Aim'));
				if($row->Aim != '')  $GLOBALS['AVE_Template']->assign('wert', $row->Aim);
			break;

			case 'skype':
				$GLOBALS['AVE_Template']->assign('titel', $GLOBALS['AVE_Template']->get_config_vars('Skype'));
				if($row->Skype != '')  $GLOBALS['AVE_Template']->assign('wert', "<a href=\"skype:$row->Skype?call\">$row->Skype</a>");
			break;
		}

		if(isset($_POST['send']) && $_POST['send'] == 1 && $row->Emailempfang == '1' && UGROUP!=2)
		{

			$error = array();
			$GLOBALS['AVE_Template']->assign('titel', $GLOBALS['AVE_Template']->get_config_vars('Emailc'));
			if (empty($_POST['title'])) $error[] = $GLOBALS['AVE_Template']->get_config_vars('NoBetreff');
			if (empty($_POST['Text'])) $error[] = $GLOBALS['AVE_Template']->get_config_vars('NoMessage');


			if (count($error)>0)
			{
				$GLOBALS['AVE_Template']->assign('errors', $error);
				$GLOBALS['AVE_Template']->assign('titel', $_POST['title']);
				$GLOBALS['AVE_Template']->assign('text', $_POST['Text']);
			}
			else
			{
				$Absender = $_SESSION['forum_user_email'];
				$Empfang = $uid;

				$Prefab = $GLOBALS['AVE_Template']->get_config_vars('EmailBodyUser');
				$Prefab = str_replace('%%USER%%', $row->BenutzerName, $Prefab);
				$Prefab = str_replace('%%ABSENDER%%', $_SESSION['forum_user_name'], $Prefab);
				$Prefab = str_replace('%%BETREFF%%', stripslashes($_POST['title']), $Prefab);
				$Prefab = str_replace('%%NACHRICHT%%', stripslashes($_POST['Text']), $Prefab);
				$Prefab = str_replace('%%ID%%', $_SESSION['user_id'], $Prefab);
				$Prefab = str_replace('%%N%%', "\n",$Prefab);
				$Prefab = str_replace('','',$Prefab);
				send_mail(
					$row->email,
					$Prefab,
					stripslashes($_POST['title']),
					FORUMEMAIL,
					FORUMABSENDER,
					'text'
				);
    		$GLOBALS['AVE_Template']->assign("content", $GLOBALS['AVE_Template']->get_config_vars('MessageAfterEmail'));
    		$tpl_out = $GLOBALS['AVE_Template']->display($tpl_dir . 'after_send.tpl');
    		exit;
			}
		}



		$GLOBALS['AVE_Template']->assign('theme_folder', $theme_folder);
		$GLOBALS['AVE_Template']->display($tpl_dir . 'popup.tpl');
	}

	//=======================================================
	// Benutzerdaten дndern
	//=======================================================
	function changeData($tpl_dir,$lang_file)
	{
		if(!isset($_SESSION['user_id']))
		{
			$this->msg($GLOBALS['AVE_Template']->get_config_vars('ErrornoPerm'),"index.php?module=forums",$tpl_dir);
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

		$r = $sql->FetchArray();

		if($r['BenutzerNameChanged'] >= '1' && !$this->fperm('changenick')) $GLOBALS['AVE_Template']->assign('changenick', 'no');
		if(!$this->fperm('changenick')) $GLOBALS['AVE_Template']->assign('changenick_once', '1');

		//felder
		$felder = array();

		$sql_tpl = $GLOBALS['AVE_DB']->Query("SELECT tpl FROM ".PREFIX."_modul_userpage_template WHERE id='1'");
		$row_tpl = $sql_tpl->FetchRow();

		$sql_b = $GLOBALS['AVE_DB']->Query("SELECT * FROM  " . PREFIX . "_modul_userpage_values WHERE uid = '" . addslashes($_SESSION['user_id']) . "'");
		$row_b = $sql_b->FetchRow();

		// falls nicht vorhanden
		if($sql_b->NumRows() == 0)
		{
			$q = "INSERT INTO " . PREFIX . "_modul_userpage_values (
						id,
						uid
					) VALUES (
					    '',
						'".addslashes($_SESSION['user_id'])."'
					)";
					$GLOBALS['AVE_DB']->Query($q);
		}

		$sql_a = $GLOBALS['AVE_DB']->Query("SELECT * FROM " . PREFIX . "_modul_userpage_items WHERE active = '1'");
		while($row_a = $sql_a->FetchRow())
		{
			if(strpos($row_tpl->tpl, "[tag_feld:".$row_a->Id) !== false)
			{

				if ($row_a->type == 'dropdown')
				{

					$fid = "f_".$row_a->Id;
					$drop =  explode(",", $row_a->value);

					$row_a->wert .= "<select style=\"width:210px;\" id=\"feld[$row_a->Id]\" name=\"feld[$row_a->Id]\">";

					$count = 0;

					foreach($drop as $i)
					{

						if($row_b->$fid == $count)
						{
						$row_a->wert .= "<option selected=\"\" value=\"".$count."\" >".$i."</option>";
						}
						else
						{
						$row_a->wert .= "<option value=\"".$count."\" >".$i."</option>";
						}

						$count = $count +1;
					}

					$row_a->wert .= "</select>";

				}
				else if ($row_a->type == 'multi')
				{

					$fid = "f_".$row_a->Id;
					$drop =  explode(",", $row_a->value);
					$values = explode(",", $row_b->$fid);

					$row_a->wert .= "<select style=\"width:210px;\" id=\"feld_multi[$row_a->Id][]\" name=\"feld_multi[$row_a->Id][]\" size=\"5\" multiple=\"multiple\">";

					$count = 0;

					foreach($drop as $i)
					{

						if(in_array($count,$values))
						{
						$row_a->wert .= "<option selected=\"\" value=\"".$count."\" >".$i."</option>";
						}
						else
						{
						$row_a->wert .= "<option value=\"".$count."\" >".$i."</option>";
						}

						$count = $count +1;
					}

					$row_a->wert .= "</select>";

				}
				else if ($row_a->type == 'text')
				{

					$fid = "f_".$row_a->Id;

					$row_a->wert = "<input type=\"text\" id=\"feld[$row_a->Id]\" size=\"40\" name=\"feld[$row_a->Id]\" value=\"".$row_b->$fid."\" >";

				}
				else
				{

					$fid = "f_".$row_a->Id;
					$row_a->wert = "<textarea id=\"feld[$row_a->Id]\" name=\"feld[$row_a->Id]\" cols=\"38\" rows=\"5\">".$row_b->$fid."</textarea>";


				}
				array_push($felder, $row_a);

			}


		}
		// definierte Felder
		$def = array("webseite","geburtstag","avatar","geschlecht","interessen","signatur");

		foreach($def as $i)
		{
			if(strpos($row_tpl->tpl, "[tag:".$i) !== false)
			{
				$GLOBALS['AVE_Template']->assign("show_".$i, 1);
			}
		}


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
			// Benutzername prьfen
			//=======================================================
			if((isset($_POST['BenutzerName'])) && ($this->checkIfUserName(addslashes($_POST['BenutzerName']),addslashes($_SESSION['forum_user_name']))))
			{
					$errors[] = $GLOBALS['AVE_Template']->get_config_vars('PE_UsernameInUse');
					$r['BenutzerName'] = trim(htmlspecialchars($_POST['BenutzerName']));
			}

			if(( @isset($_POST['BenutzerName']) && @empty($_POST['BenutzerName'])) || preg_match($muster, str_replace($allowed,'',@$_POST['BenutzerName']) ))
			{
				$errors[] = $GLOBALS['AVE_Template']->get_config_vars('PE_Username');
			}

			//=======================================================
			// E-Mail prьfen
			//=======================================================
			if(!empty($_POST['email']) && $this->checkIfUserEmail($_POST['email'], $_SESSION['forum_user_email']))
			{
				$errors[] = $GLOBALS['AVE_Template']->get_config_vars('PE_EmailInUse');
			}

			if(empty($_POST['email']) || !preg_match($muster_email, $_POST['email']))
			{
				$errors[] = $GLOBALS['AVE_Template']->get_config_vars('PE_Email');
			}

			//=======================================================
			// WENN GEBURTSTAG IM FALSCHEN FORMAT
			//=======================================================
			if(!empty($_POST['GeburtsTag']) && !preg_match($muster_geb, $_POST['GeburtsTag']))
			{
				$errors[] = $GLOBALS['AVE_Template']->get_config_vars('PE_WrongBd');
			}

			if(!empty($_POST['GeburtsTag']))
			{
				$check_year = explode(".", $_POST['GeburtsTag']);
				if(@$check_year[0] > 31 || @$check_year[1] > 12 || @$check_year[2] < date("Y")-75)
				{
					$errors[] = $GLOBALS['AVE_Template']->get_config_vars('PE_WrongBd');
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

			@$r['BenutzerName'] = trim(htmlspecialchars($_POST['BenutzerName']));
			$r['ZeigeProfil'] = @$_POST['ZeigeProfil'];
			$r['Unsichtbar'] = @$_POST['Unsichtbar'];
			$r['Emailempfang'] = @$_POST['Emailempfang'];
			$r['ZeigeProfil'] = @$_POST['ZeigeProfil'];
			$r['email'] = trim(@$_POST['email']);
			$r['Icq'] = trim(htmlspecialchars(@$_POST['Icq']));
			$r['Aim'] = trim(htmlspecialchars(@$_POST['Aim']));
			$r['Skype'] = trim(htmlspecialchars(@$_POST['Skype']));
			$r['Email_show'] = '';
			$r['Icq_show'] = '';
			$r['Aim_show'] = '';
			$r['Skype_show'] = '';
			$r['GeburtsTag_show'] = '';
			$r['Webseite_show'] = '';
			$r['Interessen_show'] = '';
			$r['Signatur_show'] = '';
			$r['Webseite'] = trim(htmlspecialchars(@$_POST['Webseite']));
			$r['Interessen'] = trim(htmlspecialchars(@$_POST['Interessen']));
			$r['Signatur'] = trim(htmlspecialchars(@$_POST['Signatur']));
			$r['Geschlecht'] = @$_POST['Geschlecht'];
			$r['GeburtsTag'] = @$_POST['GeburtsTag'];
			$r['Pnempfang'] = @$_POST['Pnempfang'];

			//=======================================================
			if(is_array($errors) && count($errors) > 0)
			{
				$ok = false;
				$GLOBALS['AVE_Template']->assign("errors", $errors);
			} else {
				if(!empty($_POST['GeburtsTag']))
				{
					$GLOBALS['AVE_DB']->Query("UPDATE " . PREFIX . "_users SET birthday = '" . @$_POST['GeburtsTag'] . "' WHERE Id = '" . $_SESSION['user_id'] . "'");
				}

				if(isset($_POST['DelAvatar']) && $_POST['DelAvatar']==1)
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

				// Prьfen, ob Benutzername mehr als 1 mal geдndert wurde und ob er das
				// recht hat, diesen zu дndern
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
						ZeigeProfil = '" . $r['ZeigeProfil'] . "',
						Unsichtbar = '" . $r['Unsichtbar'] . "',
						Emailempfang = '" . $r['Emailempfang'] . "',
						ZeigeProfil = '" . $r['ZeigeProfil'] . "',
						email = '" . trim(@$_POST['email']) . "',
						Icq = '" . trim(htmlspecialchars(@$_POST['Icq'])) . "',
						Aim = '" . trim(htmlspecialchars(@$_POST['Aim'])) . "',
						Skype = '" . trim(htmlspecialchars(@$_POST['Skype'])) . "',
						Email_show = '',
						Icq_show = '',
						Aim_show = '',
						Skype_show = '',
						GeburtsTag_show = '',
						Webseite_show = '',
						Interessen_show = '',
						Signatur_show = '',
						Webseite = '" . trim(htmlspecialchars(@$_POST['Webseite'])) . "',
						Interessen = '" . trim(htmlspecialchars(@$_POST['Interessen'])) . "',
						Signatur = '" . trim(htmlspecialchars(@$_POST['Signatur'])) . "',
						Geschlecht = '" . @$_POST['Geschlecht'] . "',
						GeburtsTag = '" . trim(@$_POST['GeburtsTag']) . "',
						AvatarStandard = '" . @$_POST['AvatarStandard'] . "',
						Pnempfang = '" . @$_POST['Pnempfang'] . "'
						$avatar
						$BC

					WHERE
						BenutzerId = '" . $_SESSION['user_id'] . "'";

				$GLOBALS['AVE_DB']->Query($q);

				// Felder
				if(isset($_POST['feld']))
				{
					foreach($_POST['feld'] as $id => $Feld)
					{

						$GLOBALS['AVE_DB']->Query("UPDATE " . PREFIX . "_modul_userpage_values
							SET
							f_".$id." = '" . trim(htmlspecialchars($_POST['feld'][$id])) ."'
							WHERE uid = '" . $_SESSION['user_id'] . "'");

					}
				}

				// Multi-Felder
				if(isset($_POST['feld_multi']))
				{
					foreach($_POST['feld_multi'] as $id => $Feld)
					{
						$GLOBALS['AVE_DB']->Query("UPDATE " . PREFIX . "_modul_userpage_values
							SET
							f_".$id." = '" . @implode(",",@$_POST['feld_multi'][$id]) ."'
							WHERE uid = '" . $_SESSION['user_id'] . "'");

					}
				}

				$this->msg($GLOBALS['AVE_Template']->get_config_vars('ProfileOK'),"index.php?module=userpage&action=change",$tpl_dir);
			}

		}
		$sql_un = $GLOBALS['AVE_DB']->Query("SELECT pnid FROM " . PREFIX . "_modul_forum_pn WHERE to_uid = '$uid' AND  is_readed != 'yes' AND typ='inbox'" );
		$GLOBALS['AVE_Template']->assign("PNunreaded", $sql_un->NumRows());

		$sql_r = $GLOBALS['AVE_DB']->Query("SELECT pnid FROM " . PREFIX . "_modul_forum_pn WHERE to_uid = '$uid' AND  is_readed = 'yes' AND typ='inbox'" );
		$GLOBALS['AVE_Template']->assign("PNreaded", $sql_r->NumRows());

		$GLOBALS['AVE_Template']->assign('sys_avatars', SYSTEMAVATARS);
		$GLOBALS['AVE_Template']->assign('prefabAvatars', $this->prefabAvatars(@$r['Avatar']));
		$GLOBALS['AVE_Template']->assign('avatar_width', MAX_AVATAR_WIDTH);
		$GLOBALS['AVE_Template']->assign('avatar_height', MAX_AVATAR_HEIGHT);
		$GLOBALS['AVE_Template']->assign('avatar_size', round(MAX_AVATAR_BYTES/1024));
		$GLOBALS['AVE_Template']->assign("forum_images", "/templates/". THEME_FOLDER ."/modules/forums/");
    $search_tpl = $GLOBALS['AVE_Template']->fetch(BASE_DIR . "/modules/forums/templates/search.tpl");
  	$GLOBALS['AVE_Template']->assign("SearchPop", addslashes($search_tpl));
		$GLOBALS['AVE_Template']->assign("inc_path", BASE_DIR . "/modules/forums/templates");
		$GLOBALS['AVE_Template']->assign('r', $r);
		$GLOBALS['AVE_Template']->assign('felder', $felder);
		$tpl_out = $GLOBALS['AVE_Template']->fetch($tpl_dir . 'myprofile.tpl');
		define("MODULE_CONTENT", $tpl_out);
		define("MODULE_SITE", $GLOBALS['AVE_Template']->get_config_vars('Userdata'));

}

//=======================================================================
// Admin Funktionen
//=======================================================================

	//=======================================================
	// Admin - Einstellungen
	//=======================================================
	function showSetting($tpl_dir)
	{
		$sql = $GLOBALS['AVE_DB']->Query("SELECT * FROM " . PREFIX . "_modul_userpage WHERE Id = '1'");
		$row_e = $sql->FetchRow();

		$items = array();
		$sql = $GLOBALS['AVE_DB']->Query("SELECT * FROM " . PREFIX . "_modul_userpage_items ORDER BY Id ASC");
		while($row = $sql->FetchRow())
		{
			array_push($items,$row);
		}

		$Groups = array();
		$sql_g = $GLOBALS['AVE_DB']->Query("SELECT user_group,user_group_name FROM " . PREFIX . "_user_groups");
		while($row_g = $sql_g->FetchRow())
		{
			array_push($Groups, $row_g);
		}

		$GLOBALS['AVE_Template']->assign("groups", $Groups);
		$GLOBALS['AVE_Template']->assign("groups_form", explode(",", $row_e->group_id));
		$GLOBALS['AVE_Template']->assign("row", $row_e);
		$GLOBALS['AVE_Template']->assign("items", $items);
		$GLOBALS['AVE_Template']->assign("tpl_dir", $tpl_dir);
		$GLOBALS['AVE_Template']->assign("sess", SESSION);


		$GLOBALS['AVE_Template']->assign("formaction", "index.php?do=modules&action=modedit&mod=userpage&moduleaction=save&cp=" . SESSION);
		$GLOBALS['AVE_Template']->assign("content", $GLOBALS['AVE_Template']->fetch($tpl_dir . "admin_fields.tpl"));
	}

	//=======================================================
	// Speichern
	//=======================================================
	function saveSetting($tpl_dir)
	{

		$GLOBALS['AVE_DB']->Query("UPDATE " . PREFIX . "_modul_userpage
			SET
				can_comment = '" . $_REQUEST['can_comment'] . "',
				group_id = '" . @implode(",", $_REQUEST['user_group']) . "'
			WHERE
				id = '1'");


		if(!empty($_POST['del']))
		{
			foreach($_POST['del'] as $id => $Feld)
			{

				$GLOBALS['AVE_DB']->Query("ALTER TABLE " . PREFIX . "_modul_userpage_values DROP f_".$id." ");

				$GLOBALS['AVE_DB']->Query("DELETE FROM " . PREFIX . "_modul_userpage_items WHERE id = '$id'");
			}
		}

		foreach($_POST['titel'] as $id => $Feld)
		{
			if(!empty($_POST['titel'][$id]))
			{


				$GLOBALS['AVE_DB']->Query("UPDATE " . PREFIX . "_modul_userpage_items
					SET
					title = '" . $_POST['titel'][$id] ."',
					type = '" . $_POST['type'][$id] . "',
					value = '" . $_POST['wert'][$id] . "',
					active = '" . $_POST['aktiv'][$id] . "'
					WHERE id = '$id'");
				reportLog($_SESSION['user_name'] . " - изменил поля в модуле Профиль пользователя (" . stripslashes($_POST['title']) . ")",'2','2');
			}
		}
		header("Location:index.php?do=modules&action=modedit&mod=userpage&moduleaction=1&cp=" . SESSION);
	}

	//=======================================================
	// Neue Felder anlegen
	//=======================================================
	function saveFieldsNew($tpl_dir)
	{
		if(!empty($_POST['titel']))
		{
			$GLOBALS['AVE_DB']->Query("INSERT INTO " . PREFIX . "_modul_userpage_items
			 VALUES (
				'',
				'" . $_REQUEST['titel'] . "',
				'" . $_REQUEST['type'] . "',
				'" . $_REQUEST['wert'] . "',
				'" . $_REQUEST['aktiv'] . "'
			)
			");

			$sql = $GLOBALS['AVE_DB']->Query("SELECT id FROM " . PREFIX . "_modul_userpage_items WHERE title = '".$_REQUEST['titel']."'");
			$row = $sql->FetchRow();

			switch($_POST['type'])
			{
				case 'text':
					$GLOBALS['AVE_DB']->Query("ALTER TABLE " . PREFIX . "_modul_userpage_values ADD (f_".$row->id." VARCHAR(250) NOT NULL) ;");
				break;

				case 'textfield':
					$GLOBALS['AVE_DB']->Query("ALTER TABLE " . PREFIX . "_modul_userpage_values ADD (f_".$row->id." text NOT NULL) ;");
				break;

				case 'dropdown':
					$GLOBALS['AVE_DB']->Query("ALTER TABLE " . PREFIX . "_modul_userpage_values ADD (f_".$row->id." VARCHAR(250) NOT NULL) ;");
				break;

				case 'multi':
					$GLOBALS['AVE_DB']->Query("ALTER TABLE " . PREFIX . "_modul_userpage_values ADD (f_".$row->id." VARCHAR(250) NOT NULL) ;");
				break;
			}
		}
		reportLog($_SESSION['user_name'] . " - добавил поле в модуле Профиль пользователя (" . stripslashes($_REQUEST['title']) . ")",'2','2');
		header("Location:index.php?do=modules&action=modedit&mod=userpage&moduleaction=1&cp=" . SESSION);
	}

	//=======================================================
	// Templateдnderungen
	//=======================================================
	function showTemplate($tpl_dir)
	{
		switch($_REQUEST['sub'])
		{
		default:

			$sql = $GLOBALS['AVE_DB']->Query("SELECT * FROM " . PREFIX . "_modul_userpage_template WHERE Id = '1'");
			$row = $sql->FetchRow();

			$tags = array();
			$sql_tags = $GLOBALS['AVE_DB']->Query("SELECT * FROM " . PREFIX . "_modul_userpage_items ORDER BY Id ASC");
			while($row_tags = $sql_tags->FetchRow())
			{
				array_push($tags, $row_tags);
			}


			$GLOBALS['AVE_Template']->assign("row", $row);
			$GLOBALS['AVE_Template']->assign("tags", $tags);
			$GLOBALS['AVE_Template']->assign("sess", SESSION);


			$GLOBALS['AVE_Template']->assign("formaction", "index.php?do=modules&action=modedit&mod=userpage&moduleaction=tpl&sub=save&cp=" . SESSION);
			$GLOBALS['AVE_Template']->assign("content", $GLOBALS['AVE_Template']->fetch($tpl_dir . "admin_tpl.tpl"));

	 	break;
		case 'save':

			$GLOBALS['AVE_DB']->Query("UPDATE " . PREFIX . "_modul_userpage_template
					SET
					tpl = '" . $_POST['Template'] ."'
					WHERE id = '1'");

			reportLog($_SESSION['user_name'] . " - изменил шаблон в модуле Профиль пользователя",'2','2');
			header("Location:index.php?do=modules&action=modedit&mod=userpage&moduleaction=tpl&cp=" . SESSION);
		}
	}

	//=======================================================
	// Forum-Update
	//=======================================================
	function update($tpl_dir)
	{
		$files = array(
		"/class.forums.php",
		"/internals/last24.php",
		"/internals/pn.php",
		"/internals/search.php",
		"/internals/showabos.php",
		"/internals/showforum.php",
		"/internals/showtopic.php",
		"/internals/userlist.php",
		"/templates/categs.tpl",
		"/templates/ignorelist.tpl",
		"/templates/showpost.tpl",
		"/templates/showposter.tpl",
		"/templates/stats_forums.tpl",
		"/templates/userpanel_forums.tpl",
		"/templates/userprofile.tpl"
		);

		switch($_REQUEST['sub'])
		{
		default:

			$error = array();
			foreach($files as $i)
			{
				if(!is_writable(BASE_DIR. "/modules/forums".$i)) array_push($error, $i);

			}

			if (count($error)>0)
			{
				$GLOBALS['AVE_Template']->assign("error", $error);
			}
			else
			{
				$GLOBALS['AVE_Template']->assign("error", 0);
				$GLOBALS['AVE_Template']->assign("files", $files);
			}

			$GLOBALS['AVE_Template']->assign("formaction", "index.php?do=modules&action=modedit&mod=userpage&moduleaction=update&sub=start&cp=" . SESSION);
			$GLOBALS['AVE_Template']->assign("content", $GLOBALS['AVE_Template']->fetch($tpl_dir . "admin_update.tpl"));

	 	break;
		case 'start':

		foreach($files as $i)
		{
			$content = file_get_contents(BASE_DIR. "/modules/forums".$i);

			$content = str_replace ("index.php?module=forums&amp;show=userprofile&amp;user_id=", "index.php?module=userpage&amp;action=show&amp;uid=", $content);
//  Для отмены обновления форума закоментировать предыдущую строку и раскоментировать следующую строку
//	    $content = str_replace ("index.php?module=userpage&amp;action=show&amp;uid=", "index.php?module=forums&amp;show=userprofile&amp;user_id=", $content);

			if($i == "/templates/userpanel_forums.tpl")
			{
				$content = str_replace ("index.php?module=forums&amp;show=publicprofile", "index.php?module=userpage&amp;action=change", $content);
//  Для отмены обновления форума закоментировать предыдущую строку и раскоментировать следующую строку
//	      $content = str_replace ("index.php?module=userpage&amp;action=change", "index.php?module=forums&amp;show=publicprofile", $content);
			}

			$write = fopen(BASE_DIR ."/modules/forums".$i, "wb");
			fwrite($write, $content);
			fclose($write);


		}

			reportLog($_SESSION['user_name'] . " - обновил файлы модуля Форум",'2','2');
			header("Location:index.php?do=modules&action=modedit&mod=userpage&moduleaction=update&ok=1&cp=" . SESSION);
		}
	}

//=======================================================================
// Sonstige Funktionen
//=======================================================================

	//=======================================================
	// Allgemeine Forum - Rechte nach Gruppen
	//=======================================================
	function fperm($perm,$group='')
	{
		if(empty($group)) $group = UGROUP;
		$sql = $GLOBALS['AVE_DB']->Query("SELECT permission FROM " . PREFIX . "_modul_forum_grouppermissions WHERE user_group='$group'");
		$row = $sql->FetchRow();
		$perms = @explode("|", $row->permission);
		if (in_array($perm, $perms) || UGROUP==1 ) // Admin darf alles!
		{
			return true;
		}
		return false;
	}

	//=======================================================
	// System - Avatare ausgeben
	//=======================================================
	function prefabAvatars($selected='')
	{
		$verzname = BASE_DIR . "/modules/forums/avatars/various";
		$dht = opendir( $verzname );
		$sel_theme = "";
		$i = 0;
		while ( gettype( $theme = readdir ( $dht )) != @boolean )
		{
			if ( is_file( "$verzname/$theme" ))
			{
				if ($theme != "." && $theme != ".." && $theme != 'index.php')
				{
					$pres = ($selected=="various/$theme") ? "checked" : "";
					$sel_theme .= "
					<div style='float:left; text-align:center; padding:1px'><img src=\"modules/forums/avatars/various/$theme\" alt=\"\" /><br />
					<input name=\"SystemAvatar\" type=\"radio\" value=\"$theme\" $pres></div>";
					$theme = "";
					$i++;
					if($i == 6)
					{
						$sel_theme .=  "<div style='clear:both'></div>";
						$i = 0;
					}

				}
			}
		}
		return $sel_theme;

	}

	//=======================================================
	// GET AVATAR
	// ermittelt die rechte fuer den aktuellen user
	//=======================================================
	function getAvatar($group, $avatar="", $usedefault, $canupload='')
	{
		$aprint = false;
		$own = 1;
		$permown = -1;
		// nutzt er default- avatar?
		if (($usedefault == 1) && ($avatar == ""))
		{
			$own = 0;
		}

		// wenn er admin ist, fallen alle regeln weg
		if ($this->fperm('alles') || $this->fperm('own_avatar') || $group == 1)
		{
			$permown = 1;
		} else {
			// wenn seine gruppe die rechte besitzt, eigene avatar zu nutzen
			if ($this->fperm('own_avatar'))
			{
				$permown = 1;
			}
		}
		if ($permown != 1)
		{
			$own = 0;
		}
		// wenn eigenes avatar beutzt werden darf und es existiert
		if ($own == 1 && $usedefault != 1)
		{
			$avatar_file = BASE_DIR . "/modules/forums/avatars/$avatar";
			if (@is_file($avatar_file))
			{
				$fz = @getimagesize($avatar_file);
				if($fz[0] <= MAX_AVATAR_WIDTH && $fz[1] <= MAX_AVATAR_HEIGHT || $group==1)
				{
					$avatar = "<img src=\"modules/forums/avatars/$avatar\" alt=\"\" border=\"\" />";
					$aprint = true;
				}
			}
		} else {
			$sql = $GLOBALS['AVE_DB']->Query("SELECT * FROM " . PREFIX."_modul_forum_groupavatar WHERE user_group = '$group'");
			$row = $sql->FetchRow();
			if (is_object($row) && ($row->IstStandard == 1) && ($row->StandardAvatar != ""))
			{
				$avatar = "<img src=\"modules/forums/avatars_default/$row->StandardAvatar\" alt=\"\" border=\"\" />";
				$aprint = true;

			}
		}
		if ($avatar == '') $avatar = '';
		if ($aprint == true) return $avatar;
	}

	// Avatar Zufallsfunktion
	function rand_tostring($path, $file)
	{
		if (@file_exists($path . $file)) {
			$arr = explode(".", $file);
			$ext = $arr[count($arr)-1];
			$rand_fn = $arr[0] . mt_rand(0, 999) . "." . $ext;
		} else {
			$rand_fn = $file;
		}
		return $rand_fn;
	}

	// Дnderungen ?!
	function checkIfUserName($new='',$old='')
	{
		$sql = $GLOBALS['AVE_DB']->Query("SELECT
			BenutzerName
		FROM
			" . PREFIX . "_modul_forum_userprofile
		WHERE
			BenutzerName = '$new' AND
			BenutzerName != '$old'
			");

		$rc = $sql->NumRows();
		if($rc==1) return true;
		return false;

	}

	// Дnderungen ?!
	function checkIfUserEmail($new='',$old='')
	{
		$sql = $GLOBALS['AVE_DB']->Query("SELECT
			email
		FROM
			" . PREFIX . "_modul_forum_userprofile
		WHERE
			email = '$new' AND
			email != '$old'
			");

		$rc = $sql->NumRows();
		if($rc==1) return true;
		return false;

	}

	function getForumUserEmail($id)
	{
		$sql = $GLOBALS['AVE_DB']->Query("SELECT email FROM " . PREFIX . "_modul_forum_userprofile WHERE BenutzerId = '$id'");
		$ru = $sql->FetchRow();
		return $ru->email;
	}

	//=======================================================
	// Benutzername anhand ID abfagen
	//=======================================================
	function fetchusername($param)
	{
		$where = (@is_array($param)) ? $param[userid] : $param;
		$sql = $GLOBALS['AVE_DB']->Query("SELECT BenutzerName,BenutzerId FROM " . PREFIX . "_modul_forum_userprofile WHERE BenutzerId='$where'");
		$row_un = $sql->FetchRow();

		if(!is_object($row_un))
		{
			return $GLOBALS['AVE_Template']->get_config_vars('Guest');
		} else {
			return $row_un->BenutzerName;
		}
	}

	//=======================================================
	// Online-User aktualisieren
	//=======================================================
	function UserOnlineUpdate()
	{
		$expire = time() + (60 * 10);
		$sql = $GLOBALS['AVE_DB']->Query("DELETE FROM " . PREFIX . "_modul_forum_useronline WHERE expire <= '" . time() . "'");

		if(isset($_SESSION['user_id']))
		{
			$sql = $GLOBALS['AVE_DB']->Query("SELECT Id FROM " . PREFIX . "_modul_forum_userprofile WHERE BenutzerId = '".$_SESSION['user_id']."'");
			$num = $sql->NumRows();

			// Wenn der Benutzet noch nicht im Forum-Profil gespeichert wurde,
			// wird dies hier getan
			if(!$num)
			{
				$sql = $GLOBALS['AVE_DB']->Query("SELECT * FROM " . PREFIX . "_users WHERE Id  = '".$_SESSION['user_id']."'");
				$row = $sql->FetchRow();

				$GLOBALS['AVE_DB']->Query("
					INSERT
					INTO " . PREFIX . "_modul_forum_userprofile
					SET
						Id             = '',
						BenutzerId     = '" . $row->Id . "',
						BenutzerName   = '" . (($row->user_name!='') ? $row->user_name : substr($row->firstname,0,1) . '. ' . $row->lastname) . "',
						GroupIdMisc    = '',
						Beitraege      = '',
						ZeigeProfil    = '1',
						Signatur       = '',
						Icq            = '',
						Aim            = '',
						Skype          = '',
						Emailempfang   = '1',
						Pnempfang      = '1',
						Avatar         = '',
						AvatarStandard = '',
						Webseite       = '',
						Unsichtbar     = '0',
						Interessen     = '',
						email          = '" . $row->email . "',
						reg_time       = '" . $row->reg_time . "',
						GeburtsTag     = '" . $row->birthday . "'
				");

				header("Location:index.php?module=forums");
			}

			$sql = $GLOBALS['AVE_DB']->Query("SELECT ip FROM " . PREFIX . "_modul_forum_useronline WHERE ip='" . $_SERVER['REMOTE_ADDR'] . "' limit 1");
			$num = $sql->NumRows();

			if ($num < 1)
				$sql = $GLOBALS['AVE_DB']->Query("INSERT INTO " . PREFIX . "_modul_forum_useronline (ip,expire,uname,invisible) VALUES ('" . $_SERVER['REMOTE_ADDR'] . "','$expire','" . (defined("USERNAME") ? USERNAME : "UNAME") . "','" . (defined("USERNAME") ? $this->getInvisibleStatus($_SESSION['user_id']) : "INVISIBLE") . "')");
			 else
				$sql = $GLOBALS['AVE_DB']->Query("UPDATE " . PREFIX . "_modul_forum_useronline set uid = '" .  $_SESSION['user_id']. "', uname='" . (defined("USERNAME") ? USERNAME : "UNAME") . "', invisible = '" . (defined("USERNAME") ? $this->getInvisibleStatus($_SESSION['user_id']) : "INVISIBLE") . "'  WHERE ip='" . $_SERVER['REMOTE_ADDR'] . "'");
		} else {
			$sql = $GLOBALS['AVE_DB']->Query("SELECT ip FROM " . PREFIX . "_modul_forum_useronline WHERE ip='" . $_SERVER['REMOTE_ADDR'] . "' limit 1");
			$num = $sql->NumRows();
			if ($num < 1)
				$sql = $GLOBALS['AVE_DB']->Query("INSERT INTO " . PREFIX . "_modul_forum_useronline (ip,expire,uname,invisible) VALUES ('" . $_SERVER['REMOTE_ADDR'] . "','$expire','UNAME','0')");
		}
	}

	// Weiterleitung
	function msg($msg='', $goto='', $tpl='')
	{
		$goto = ($goto=='') ? 'index.php?module=forums' : $goto;
		$msg = str_replace('%%GoTo%%', $goto, $msg);
		$GLOBALS['AVE_Template']->assign("theme_folder", THEME_FOLDER);
		$GLOBALS['AVE_Template']->assign("GoTo", $goto);
		$GLOBALS['AVE_Template']->assign("content", $msg);
		$tpl_out = $GLOBALS['AVE_Template']->fetch($tpl . 'redirect.tpl');
		define("MODULE_CONTENT", $tpl_out);
		define("MODULE_SITE", "Weiterleitung");
		echo $tpl_out;
		exit;
	}
}
?>