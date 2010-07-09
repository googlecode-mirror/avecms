<?php

//=======================================================
// FELDER LESEN
//=======================================================
function userpage_getfield($id, $display, $uid)
{
	global $AVE_DB, $AVE_Template;

	$sql_a = $AVE_DB->Query("
		SELECT *
		FROM " . PREFIX . "_modul_userpage_items
		WHERE active = '1'
		AND id = '" . $id . "'
	");
	$row_a = $sql_a->FetchRow();

	$sql_b = $AVE_DB->Query("
		SELECT *
		FROM  " . PREFIX . "_modul_userpage_values
		WHERE uid = '" . $uid . "'
	");
	$row_b = $sql_b->FetchRow();

	$show = true;

	if ($row_a->type == 'dropdown')
	{
		$fid = 'f_' . $row_a->Id;
		$drop =  explode(',', $row_a->value);

		$titel = $row_a->title;
		$wert = $drop[$row_b->$fid];

		if ($wert == '') $show = false;
	}
	elseif ($row_a->type == 'multi')
	{
		$fid = 'f_' . $row_a->Id;
		$titel = $row_a->title;
		$drop =  explode(',', $row_a->value);
		$values = explode(',', $row_b->$fid);

		if ($row_b->$fid == '') $show = false;

		$wert = '<ul>';

		foreach ($values as $item)
		{
			$wert .= '<li>' . $drop[$item] . '</li>';
		}

		$wert .= '</ul>';
	}
	else
	{
		$fid = 'f_' . $row_a->Id;
		$titel = $row_a->title;
		$wert = $row_b->$fid;

		if ($wert == '') $show = false;
	}

	if ($show != false)
	{
		$wert = nl2br(preg_replace("/\[([\/]?)([biuBIU]{1})\]/", "<\$1\$2>", $wert));
 		$AVE_Template->assign('titel', $titel);
		$AVE_Template->assign('wert', $wert);
		$AVE_Template->display(BASE_DIR . '/modules/userpage/templates/felder-' . $display . '.tpl');
	}
}

//=======================================================
// HEADER
//=======================================================
function userpage_header($file, $uid)
{
	global $AVE_DB, $AVE_Template;

	$sql = $AVE_DB->Query("
		SELECT pnid
		FROM " . PREFIX . "_modul_forum_pn
		WHERE to_uid = '" . $uid . "'
		AND is_readed != 'yes'
		AND typ = 'inbox'
	");
	$AVE_Template->assign('PNunreaded', $sql->NumRows());

	$sql_r = $AVE_DB->Query("
		SELECT pnid
		FROM " . PREFIX . "_modul_forum_pn
		WHERE to_uid = '" . $uid . "'
		AND is_readed = 'yes'
		AND typ = 'inbox'
	");
	$AVE_Template->assign('PNreaded', $sql_r->NumRows());
	$search_tpl = $AVE_Template->fetch(BASE_DIR . '/modules/forums/templates/search.tpl');
	$AVE_Template->assign('SearchPop', $search_tpl);
	$AVE_Template->assign('inc_path', BASE_DIR . '/modules/forums/templates');
	$AVE_Template->assign('forum_images', 'templates/'. THEME_FOLDER . '/modules/forums/');
	$AVE_Template->display(BASE_DIR . '/modules/forums/templates/' . $file);
}

//=======================================================
// SPRACHE ERSETZEN
//=======================================================
function userpage_lang($id)
{
	global $AVE_Template;

	echo $AVE_Template->get_config_vars($id);
}

//=======================================================
// ONLINESTATUS
//=======================================================
function userpage_onlinestatus($user_name, $type = '')
{
	global $AVE_DB, $AVE_Template;

	$sql = $AVE_DB->Query("
		SELECT
			uname,
			invisible
		FROM
			" . PREFIX . "_modul_forum_useronline
		WHERE
			uname = '" . $user_name . "'
		LIMIT 1
	");
	$num = $sql->NumRows();
	$row = $sql->FetchRow();
	if ($num == 1)
	{
		if ((UGROUP == 1) && ($row->invisible == 'INVISIBLE'))
		{
			$img = 'user_invisible.gif' ;
			$alt = $AVE_Template->get_config_vars('UserIsInvisible');
		}
		if ($row->invisible != 'INVISIBLE')
		{
			$img = 'user_online.gif' ;
			$alt = $AVE_Template->get_config_vars('UserIsOnline');
		}
		if ((UGROUP != 1) && ($row->invisible == 'INVISIBLE'))
		{
			$img = 'user_offline.gif' ;
			$alt = $AVE_Template->get_config_vars('UserIsOffline');
		}
	}
	else
	{
		$img = 'user_offline.gif' ;
		$alt = $AVE_Template->get_config_vars('UserIsOffline');
	}

	$status_img = $alt . '<img class="absmiddle" src="templates/' . THEME_FOLDER . '/modules/forums/statusicons/' . $img . '" alt="' . $alt . '" />';

	if ($type==1)
	{
		return $status_img;
	}
	else
	{
		return $alt;
	}
}

//=======================================================
// AVATAR
//=======================================================
function userpage_avatar($group, $avatar, $usedefault)
{
	global $AVE_DB;

	if ($avatar != '' && $usedefault == '0')
	{
		$avatar_file = BASE_DIR . '/modules/forums/avatars/' . $avatar;
		if (@is_file($avatar_file))
		{
				$avatar = '<img src="modules/forums/avatars/' . $avatar . '" alt="" border="" />';
				$aprint = true;
		}
	}
	else
	{
		$sql = $AVE_DB->Query("
			SELECT *
			FROM " . PREFIX . "_modul_forum_groupavatar
			WHERE user_group = '" . $group . "'
		");
		$row = $sql->FetchRow();
		if (is_object($row) && ($row->IstStandard == 1) && ($row->StandardAvatar != ''))
		{
			$avatar = '<img src="modules/forums/avatars_default/' . $row->StandardAvatar . '" alt="" border="" />';
			$aprint = true;
		}
		else
		{
			if (no_avatar == 1)
			{
				$avatar = '<img src="modules/userpage/img/no_avatar.gif" alt="" border="" />';
				$aprint = true;
			}
		}
	}

	if ($aprint == true) return $avatar;
}

//=======================================================
// SCHON DEFINIERTE FELDER (SIGNATUR / INTERESSEN / KONTAKT )
//=======================================================
function userpage_felder ($type, $display, $uid)
{
	global $AVE_DB, $AVE_Template;

	$sql = $AVE_DB->Query("
		SELECT *
		FROM " . PREFIX . "_modul_forum_userprofile
		WHERE BenutzerId = '" . $uid . "'
	");
	$row = $sql->FetchRow();

	$show = true;

	switch ($type)
	{
		case 'signatur':
			if ($row->Signatur == '') $show = false;
			$titel = $AVE_Template->get_config_vars('Signatur');
			$wert = $row->Signatur;
			break;

		case 'interessen':
			if ($row->Interessen == '') $show = false;
			$titel = $AVE_Template->get_config_vars('Interessen');
			$wert = $row->Interessen;
			break;

		case 'kontakt':
			$sql_ig = $AVE_DB->Query("
				SELECT *
				FROM " . PREFIX . "_modul_forum_ignorelist
				WHERE BenutzerId = '" . $uid . "'
				AND IgnoreId = '" . (int)$_SESSION['user_id'] . "'
			");
			$num_ig = $sql_ig->NumRows();

			if ($num_ig == 1) $show = false;

			$titel = $AVE_Template->get_config_vars('Kontakt');
			if ($row->Emailempfang == '1')
			{
				$wert .= " <a href=\"javascript:void(0);\" onclick=\"popup('index.php?module=userpage&amp;action=contact&amp;method=email&amp;uid=" . $uid . "&amp;pop=1&amp;theme_folder=" . THEME_FOLDER . "','comment','600','400','1');\"> " . $AVE_Template->get_config_vars('Emailc') . "</a> ";
			}
			if ($row->Pnempfang == '1')
			{
				$wert .= " <a href=\"index.php?module=forums&amp;show=pn&amp;action=new&amp;to=" . base64_encode($row->BenutzerName) . "\"> " . $AVE_Template->get_config_vars('Pn') . "</a> ";
			}
			if ($row->Icq != '')
			{
				$wert .= " <a href=\"javascript:void(0);\" onclick=\"popup('index.php?module=userpage&amp;action=contact&amp;method=icq&amp;uid=" . $uid . "&amp;pop=1&amp;theme_folder=" . THEME_FOLDER . "','comment','500','200','1');\"> " . $AVE_Template->get_config_vars('Icq') . "</a> ";
			}
			if ($row->Aim != '')
			{
				$wert .= " <a href=\"javascript:void(0);\" onclick=\"popup('index.php?module=userpage&amp;action=contact&amp;method=aim&amp;uid=" . $uid . "&amp;pop=1&amp;theme_folder=" . THEME_FOLDER . "','comment','500','200','1');\"> " . $AVE_Template->get_config_vars('Aim') . "</a> ";
			}
			if ($row->Skype != '')
			{
				$wert .= " <a href=\"javascript:void(0);\" onclick=\"popup('index.php?module=userpage&amp;action=contact&amp;method=skype&amp;uid=" . $uid . "&amp;pop=1&amp;theme_folder=" . THEME_FOLDER . "','comment','500','200','1');\"> " . $AVE_Template->get_config_vars('Skype') . "</a> ";
			}
			break;

		case 'webseite':
			if ($row->Webseite == '') $show = false;
			$titel = $AVE_Template->get_config_vars('Webseite');
			$wert = ' <a href="' . $row->Webseite . '" target="_blank">' . $row->Webseite . '</a> ';
			break;

		case 'geschlecht':
			if ($row->Geschlecht == '') $show = false;
			$titel = $AVE_Template->get_config_vars('Geschlecht');
			$wert = $AVE_Template->get_config_vars($row->Geschlecht);
			break;

		case 'geburtstag':
			if ($row->GeburtsTag == '') $show = false;
			$titel = $AVE_Template->get_config_vars('Geburtstag');
			$wert = $row->GeburtsTag;
			break;
	}

	$wert = nl2br(preg_replace("/\[([\/]?)([biuBIU]{1})\]/", "<\$1\$2>", $wert));

	if ($show == true)
	{
		$AVE_Template->assign('titel', $titel);
		$AVE_Template->assign('wert', $wert);
		$AVE_Template->display(BASE_DIR . '/modules/userpage/templates/felder-' . $display . '.tpl');
	}
}

//=======================================================
// Zufallscode erzeugen
//=======================================================
function secureCode($c = 0)
{
	global $AVE_DB;

	$tdel = time() - 1200; // 20 Minuten
	$AVE_DB->Query("DELETE FROM " . PREFIX . "_antispam WHERE Ctime < " . $tdel);
	$pass = '';
	$chars = array(
		'2','3','4','5','6','7','8','9',
		'A','B','C','D','E','F','G','H','J','K','M','N',
		'P','Q','R','S','T','U','V','W','X','Y','Z',
		'a','b','c','d','e','f','g','h','j','k','m','n',
		'p','q','r','s','t','u','v','w','x','y','z'
	);
	$ch = ($c!=0) ? $c : 7;
	$count = count($chars) - 1;
	srand((double)microtime() * 1000000);
	for ($i = 0; $i < $ch; $i++)
	{
		$pass .= $chars[rand(0, $count)];
	}

	$code = $pass;
	$sql = $AVE_DB->Query("
		INSERT
		INTO " . PREFIX . "_antispam
		SET
			Id = '',
			Code = '" . $code . "',
			Ctime = '" . time() . "'
	");
	$codeid = $AVE_DB->InsertId();

	return $codeid;
}

//=======================================================
// GÄSTEBUCH
//=======================================================
function userpage_guestbook ($limit, $uid)
{
	global $AVE_DB, $AVE_Template;

	$sql = $AVE_DB->Query("
		SELECT *
		FROM " . PREFIX . "_modul_userpage
		WHERE id = '1'
	");
	$row = $sql->FetchRow();

	if ($row->can_comment == '1')
	{
		$sql = $AVE_DB->Query("
			SELECT id
			FROM " . PREFIX . "_modul_userpage_guestbook
			WHERE uid = '" . $uid . "'
		");
		$num = $sql->NumRows();
		$count = $sql->NumRows();

		$seiten = ceil($num / $limit);
		$start = get_current_page() * $limit - $limit;

		if (isset($_REQUEST['page']) && is_numeric($_REQUEST['page'])) $count = $count - $limit * ((int)$_REQUEST['page'] - 1);

		$guests = array();
		$sql_gb = $AVE_DB->Query("
			SELECT *
			FROM " . PREFIX . "_modul_userpage_guestbook
			WHERE uid = '" . $uid . "'
			ORDER BY id DESC
			LIMIT " . $start . "," . $limit . "
		");
		while ($row_gb = $sql_gb->FetchRow())
		{
			$row_gb->ctime = date(date_format ,$row_gb->ctime);

			if ($row_gb->author != '0')
			{
				$sql_dd = $AVE_DB->Query("
					SELECT user_name
					FROM " . PREFIX . "_users WHERE
					Id = '" . $row_gb->author . "'
				");
				$row_dd = $sql_dd->FetchRow();

				$row_gb->uname = $row_dd->user_name;
			}
			else
			{
				$row_gb->uname = $AVE_Template->get_config_vars('Guest');
			}

			$row_gb->gid = $count;
			$count = $count - 1;

			array_push($guests,$row_gb);
		}

		if ($num > $limit) {
			$page_nav = ' <a class="pnav" href="index.php?module=userpage&action=show&uid=' . $uid . '&page={s}">{t}</a> ';
			$page_nav = get_pagination($seiten, 'page', $page_nav);
			$AVE_Template->assign('page_nav', $page_nav);
		}

		$sql_ig = $AVE_DB->Query("
			SELECT *
			FROM " . PREFIX . "_modul_forum_ignorelist
			WHERE BenutzerId = '" . $uid . "'
			AND IgnoreId = '" . (int)$_SESSION['user_id'] . "'
		");
		$num_ig = $sql_ig->NumRows();

		$group_id = ($row->group_id == '') ? $row->group_id : explode(',', $row->group_id);
		if (@in_array(UGROUP, $group_id) && $num_ig == 0) $AVE_Template->assign('cc', 1);

		$AVE_Template->assign('guests', $guests);
		$AVE_Template->assign('item', $row);
		$AVE_Template->assign('num', $num);
		$AVE_Template->assign('formaction', 'index.php?module=userpage&amp;action=form&amp;uid=' . $uid . '&amp;theme_folder=' . THEME_FOLDER . '&amp;pop=1');
		$AVE_Template->display(BASE_DIR . '/modules/userpage/templates/guestbook.tpl');
	}
}

//=======================================================
// FORUM
//=======================================================
function userpage_lastposts($limit, $uid)
{
	global $AVE_DB, $AVE_Template;

	$num = 1;

	$sql = $AVE_DB->Query("
		SELECT *
		FROM " . PREFIX . "_modul_forum_post
		WHERE uid = '" . $uid . "'
		ORDER BY id DESC
		LIMIT " . $limit . "
	");
	while ($row = $sql->FetchRow())
	{
		$sql_t = $AVE_DB->Query("
			SELECT *
			FROM " . PREFIX . "_modul_forum_topic
			WHERE id = '" . $row->topic_id . "'
		");
		$row_t = $sql_t->FetchRow();

		$row->topic_title = $row_t->title;

		if (is_object($row))
		{
			$wert .= $num . '. <a href="index.php?module=forums&show=showtopic&toid=' . $row->topic_id . '#pid_' . $row->id . '">' . $row_t->title . '</a> <br />';
		}

		++$num;
	}

	$titel = $AVE_Template->get_config_vars('Lastposts');

	$AVE_Template->assign('titel', $titel);
	$AVE_Template->assign('wert', $wert);

	if (!empty($wert)) $AVE_Template->display(BASE_DIR . '/modules/userpage/templates/felder-1.tpl');
}

//=======================================================
// DOWNLOADS
//=======================================================
function userpage_downloads ($limit, $uid)
{
	global $AVE_DB, $AVE_Template;

	$num = 1;

	$sql = $AVE_DB->Query("
		SELECT *
		FROM " . PREFIX . "_modul_download_files
		WHERE Autor_Erstellt = '" . $uid . "'
		AND status = '1'
		ORDER BY id DESC
		LIMIT " . $limit . "
	");
	while ($row = $sql->FetchRow())
	{
		if (is_object($row))
		{
			$wert .= $num . '. <a href="index.php?module=download&action=showfile&file_id=' . $row->Id . '&categ=' . $row->KatId . '">' . $row->Name . '</a> <br />';
		}

		++$num;
	}

	$titel = $AVE_Template->get_config_vars('Downloads');

	$AVE_Template->assign('titel', $titel);
	$AVE_Template->assign('wert', $wert);

	if (!empty($wert)) $AVE_Template->display(BASE_DIR . '/modules/userpage/templates/felder-1.tpl');
}

?>