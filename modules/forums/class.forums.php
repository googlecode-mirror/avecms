<?php

/**
 * Класс работы с Форумом в публичной части.
 *
 * @package AVE.cms
 * @subpackage module_Forums
 * @filesource
 */
class Forum
{
	var $_UserProfileTpl = 'userprofile.tpl';
	var $_ShowForumsTpl = 'show_forums.tpl';
	var $_ShowForumTpl  = 'showforum.tpl';
	var $_ShowTopicTpl = 'showtopic.tpl';
	var $_Print_ShowTopicTpl = 'showtopic_print.tpl';
	var $_MoveTpl = 'move.tpl';
	var $_allowed_imagetypes = array('image/pjpeg', 'image/jpeg', 'image/jpg', 'image/x-png', 'image/png', 'image/gif');
	var $_Fonts = array(
		"Arial" => "Arial",
		"Verdana" => "Verdana",
		"Trebuchet" => "Trebuchet MS",
		"Georgia" => "Georgia",
		"Times" =>
		"Times New Roman",
		"Serif" => "Serif"
	);

	var $_FontSizes = array("1","2","3","4","5","6","7");

	var $_FontColors = array(
		"#cccccc" => "Светло-серый",
		"#666666" => "Темно-серый",
		"#000000" => "Черный",
		"#eec00a" => "Желтый",
		"#ff9900" => "Оранжевый",
		"#ff0000" => "Красный",
		"#990000" => "Темно-красный",
		"#660000" => "Темно-коричневый",
		"#00ccff" => "Светло-голубой",
		"#003366" => "Голубой",
		"#006600" => "Зеленый",
		"#ff33ff" => "Маджента",
		"#660099" => "Лиловый",
		"#ff66ff" => "Розовый",
		"#663300" => "Коричневый"

	);

	var $_default_permission = 'own_avatar|canpn|accessforums|cansearch|last24|userprofile';

	function getActPage()
	{
		$Page = (isset($_REQUEST['page']) && is_numeric($_REQUEST['page']) ? $_REQUEST['page'] : 1);
		return $Page;
	}

	function getUserName($id)
	{
		global $AVE_DB;
		
		$sql = $AVE_DB->Query("SELECT uid, uname FROM " . PREFIX . "_modul_forum_userprofile WHERE uid = '" . $id . "'");
		$row = $sql->FetchRow();
		return $row->uname;
	}
	//=======================================================
	// FORUM-ЬBERSICHT
	//=======================================================
	function showForums()
	{
		define("SHOWFORUMS", 1);
		include_once(BASE_DIR . '/modules/forums/internals/showforums.php');
	}

	//=======================================================
	// Forum mit Id anzeigen
	//=======================================================
	function showForum()
	{
		define("SHOWFORUM", 1);
		include_once(BASE_DIR . '/modules/forums/internals/showforum.php');
	}

	function userPopUp()
	{
		define("USERPOP", 1);
		include_once(BASE_DIR . '/modules/forums/internals/userpop.php');
	}

	//=======================================================
	// Thema anzeigen
	//=======================================================
	function showTopic()
	{
		define("SHOWTOPIC", 1);
		include_once(BASE_DIR . '/modules/forums/internals/showtopic.php');
	}

	function ignoreList()
	{
		define("IGNORELIST",1);
		include_once(BASE_DIR . "/modules/forums/internals/ignorelist.php");
	}

	function getFile()
	{
		define("GETFILE", 1);
		include_once(BASE_DIR . "/modules/forums/internals/getfile.php");
	}

	function voteTopic()
	{
		define("VOTETOPIC", 1);
		include_once(BASE_DIR . "/modules/forums/internals/votetopic.php");
	}

	function openClose($openclose = "open")
	{
		define("OPENCLOSETOPIC", 1);
		include_once(BASE_DIR . "/modules/forums/internals/open_close.php");
	}

	function moveTopic()
	{
		define("MOVETOPIC", 1);
		include_once(BASE_DIR . "/modules/forums/internals/move.php");
	}

	function delTopic()
	{
		define("DELTOPIC", 1);
		include_once(BASE_DIR . "/modules/forums/internals/deltopic.php");
	}

	function delPost()
	{
		define("DELPOST", 1);
		include_once(BASE_DIR . "/modules/forums/internals/delpost.php");
	}

	function setAbo($onoff = "on")
	{
		define("SETABO", 1);
		include_once(BASE_DIR . "/modules/forums/internals/abo.php");
	}

	function forumsLogin()
	{
		define("FLOGIN", 1);
		include_once(BASE_DIR . "/modules/forums/internals/forumlogin.php");
	}

	function changeType()
	{
		define("CHANGETYPE", 1);
		include_once(BASE_DIR . "/modules/forums/internals/changetype.php");
	}

	function markRead()
	{
		define("MARKREAD", 1);
		include_once(BASE_DIR . "/modules/forums/internals/markread.php");
	}

	function userPostings()
	{
		define("USERPOSTINGS", 1);
		include_once(BASE_DIR . "/modules/forums/internals/userpostings.php");
	}

	//=======================================================
	// Lezte aktive Themen der letzten 24 Stunden
	//=======================================================
	function last24()
	{
		define("LAST24", 1);
		include_once(BASE_DIR . "/modules/forums/internals/last24.php");
	}

	//=======================================================
	// Abos anzeigen
	//=======================================================
	function myAbos()
	{
		define("MYABOS", 1);
		include_once(BASE_DIR . "/modules/forums/internals/showabos.php");
	}

	//=======================================================
	// Form fьr neuen Beitrag
	//=======================================================
	function newTopic()
	{
		define("NEWTOPIC", 1);
		include_once(BASE_DIR . "/modules/forums/internals/newtopic.php");
	}

	//=======================================================
	// Beitrag neu
	//=======================================================
	function addTopic()
	{
		define("ADDTOPIC", 1);
		include_once(BASE_DIR . "/modules/forums/internals/addtopic.php");
	}

	function newPost()
	{
		define("NEWPOST", 1);
		include_once(BASE_DIR . "/modules/forums/internals/newpost.php");
	}

	function addPost()
	{
		define("ADDPOST", 1);
		include_once(BASE_DIR . "/modules/forums/internals/addpost.php");
	}

	//=======================================================
	// Datei anhдngen
	//=======================================================
	function attachFile()
	{
		define("ATTACHFILE", 1);
		include_once(BASE_DIR . "/modules/forums/internals/attachfile.php");
	}

	function pMessages()
	{
		define("PN",1);
		include_once(BASE_DIR . "/modules/forums/internals/pn.php");
	}

	/**
	* Поиск
	*
	*/
	function doSearch()
	{
		define("SEARCH", 1);
		include_once(BASE_DIR . "/modules/forums/internals/search.php");
	}

	function searchMask()
	{
		global $AVE_Template, $mod;
		
		$forums_dropdown = array();
		$this->getForums(0, $forums_dropdown, "");

		$AVE_Template->assign("navigation", "<a class='forum_links_navi' href='index.php?module=forums'>" . $mod['config_vars']['FORUMS_PAGE_NAME_FORUMS'] . "</a>" . $mod['config_vars']['FORUMS_FORUM_SEP'] . $mod['config_vars']['FORUMS_FORUMS_SEARCH']);
		$AVE_Template->assign("forums_dropdown", $forums_dropdown);

		$tpl_out = $AVE_Template->fetch($mod['tpl_dir'] . 'search_mask.tpl');
		define("MODULE_CONTENT", $tpl_out);
		define("MODULE_SITE", $mod['config_vars']['FORUMS_FORUMS_SEARCH']);
	}

	function myProfile()
	{
		define("MYPROFILE", 1);
		include_once(BASE_DIR . "/modules/forums/internals/myprofile.php");
	}

	//=======================================================
	// Erzeugt ein Array mit Schriftarten fьr Formulare
	//=======================================================
	function fontDropdown()
	{
		$set['fonts'] = $this->_Fonts;
		$listfonts = array();
		foreach ( $set['fonts'] AS $font => $fontcode )
		{
			$listfonts[] = array('font' => $font,'fontname' => $fontcode);
		}
		return $listfonts;
	}

	//=======================================================
	// Schriftgroesse fьr Beitrag-Feld
	//=======================================================
	function sizeDropdown()
	{
		$set['size'] = $this->_FontSizes;
		$listfontsize = array();
		foreach ( $set['size'] AS $size => $fontsize )
		{
			$listfontsize[] = array('size' => $fontsize);
		}
		return $listfontsize;
	}

	//=======================================================
	// Schriftfarbe fьr Beitrag-Feld
	//=======================================================
	function colorDropdown()
	{
		$set['color'] = $this->_FontColors;
		$listfontcolor = array();
		foreach ( $set['color'] AS $color => $fontcolor )
		{
			$listfontcolor[] = array('color' => $color,'fontcolor' => $fontcolor);
		}
		return $listfontcolor;
	}

	//=======================================================
	// Listet Beitrags-Icons auf
	// Icons mьssen sich in dem Themen-Verzeichnis befinden!
	//=======================================================
	function getPosticons($icon = "0")
	{
		global $AVE_DB, $mod;
		
		$i = 1;
		$posticons = "";
		$sql = $AVE_DB->Query("SELECT id,path FROM " . PREFIX . "_modul_forum_posticons WHERE active = 1 ORDER BY posi ASC");
		while($rows = $sql->FetchRow())
		{
			$br = "&nbsp;";
			if ( ($i % 6) == 0 ) $br = "<br />";
			if ($icon == $rows->id || (isset($_POST['posticon']) && $_POST['posticon']==$rows->id)) $checked = "checked";
			else $checked = "";

			$posticons .= "<input class=\"noborder\"  style=\"background-color:transparent; border:0px\" type=\"radio\" name=\"posticon\" value=\"$rows->id\" $checked />&nbsp;";
			$posticons .= "<img src=\"templates/".THEME_FOLDER."/modules/forums/posticons/$rows->path\" alt=\"\" />$br";
			$i++;
		}
		$NullChecked = ($icon==0 && empty($_POST['posticon']) ) ? "checked" : "";
		$posticons .= "<input class=\"noborder\" style=\"background-color:transparent; border:0px\" type=\"radio\" name=\"posticon\" value=\"0\"  " . $NullChecked . " />&nbsp;" . $mod['config_vars']['FORUMS_NO_POSTICON'];
		return $posticons;
	}

	//=======================================================
	// Listet Smilies auf
	//=======================================================
	function listsmilies()
	{
		global $AVE_DB;
//		$sql = $AVE_DB->Query("SELECT smiliebr FROM " . PREFIX . "_modul_forum_settings");
//		$row = $sql->FetchRow();
		$smiliesw = '';
		$smilie_id = 0;
		$smiliesw .= '<table border="0"><tr>';

		$sql = $AVE_DB->Query("SELECT code, path FROM " . PREFIX . "_modul_forum_smileys WHERE active = 1");
		$num = $sql->NumRows();

		$sql = $AVE_DB->Query("SELECT code,path FROM " . PREFIX . "_modul_forum_smileys WHERE active = 1 ORDER BY posi ASC LIMIT 16");
		while($row_s = $sql->FetchRow())
		{
			$val = $row_s->code;
			$key = $row_s->path;
			$smiliesw .= '<td>';
			$smiliesw .= "<a href='javascript:InsertCode(\" " . $val . " \")'><img hspace='2' vspace='2' src='templates/" . THEME_FOLDER . "/modules/forums/smilies/" . $key . "' border='0' alt='' /></a>";
			$smilie_id++;
			$smiliesw .= '</td>';
			if($smilie_id==4)
			{
				$smiliesw .= "</tr><tr>"; $smilie_id=0;
			}
		}
		$smiliesw .= '</tr></table>';

		$smiliesw_ext = '';
		$smilie_id = 0;
		$smiliesw_ext .= "<table border=\'0\' width=\'100%\'><tr>";

		$sql = $AVE_DB->Query("SELECT code, path FROM " . PREFIX . "_modul_forum_smileys WHERE active = 1");
		$num = $sql->NumRows();

		$sql = $AVE_DB->Query("SELECT code,path FROM " . PREFIX . "_modul_forum_smileys WHERE active = 1 ORDER BY posi ASC");
		while($row_s = $sql->FetchRow())
		{
			$val = $row_s->code;
			$key = $row_s->path;
			$smiliesw_ext .= '<td width=10>';
			$smiliesw_ext .= "<a href=javascript:InsertCode(\'$val\') onclick=javascript:nd()><img hspace=2 vspace=2 src=templates/".THEME_FOLDER."/modules/forums/smilies/".$key." border=0 alt=\'\' /></a>";
			$smiliesw_ext .= '</td><td width=25%>'.$val.'</td>';
			$smilie_id++;
			if($smilie_id==4)
			{
				$smiliesw_ext .= "</tr><tr>"; $smilie_id=0;
			}
		}
		$smiliesw_ext .= '</tr></table>';

		$more_s = $smiliesw_ext;
		$smiliesw_ext_more = '<a id="more_s" href="javascript:void(0);" onmouseover="return overlib(\''.addslashes($more_s).'\',FIXX,elemX(elemObj(\'more_s\')),FIXY,elemY(elemObj(\'more_s\'))+20,TIMEOUT,4000,MOUSEOFF,NOCLOSE,WIDTH,600,STICKY);" onmouseout="nd();">Все смайлы...</a>';
		$smiliesw .= $smiliesw_ext_more;
		return $smiliesw;
	}

	// ========================================================
	// FORUM KATEGORIE- LOESCHFUNKTION
	// 1. foren loeschen
	// 2. kategorie loeschen
	// ========================================================
	function deleteCategory($id)
	{
		global $AVE_DB;
		// foren loeschen
		$query = "SELECT id FROM " . PREFIX . "_modul_forum_forum WHERE category_id = '" . $id . "'";
		$result = $AVE_DB->Query($query);

		while ($forum = $result->FetchRow())
		{
			$this->deleteForum($forum->id);
		}
		// kategorie loeschen
		$query = "DELETE FROM " . PREFIX . "_modul_forum_category WHERE id = '" . $id . "'";
		$result = $AVE_DB->Query($query);
	}

	// ========================================================
	// FORUM- LOESCHFUNKTION
	// 1. themen loeschen
	// 2. berechtigungen loeschen
	// 3. unterkategorien loeschen
	// 4. tforum loeschen
	// ========================================================
	function deleteForum($id)
	{
		global $AVE_DB;
		
		$query = "SELECT id FROM " . PREFIX . "_modul_forum_topic WHERE forum_id = '" . $id . "'";
		$result = $AVE_DB->Query($query);
		// themen loeschen
		while ($topic = $result->FetchRow())
		{
			$this->deleteTopic($topic->id);
		}
		// berechtigungen loeschen
		$query = "DELETE FROM " . PREFIX . "_modul_forum_permissions WHERE forum_id = '" . $id . "'";
		$result = $AVE_DB->Query($query);
		// unterkategorien loeschen
		$query = "SELECT id FROM " . PREFIX . "_modul_forum_category WHERE parent_id = '" . $id . "'";
		$result = $AVE_DB->Query($query);

		while ($category = $result->FetchRow())
		{
			$this->deleteCategory($category->id);
		}
		// forum loeschen
		$query = "DELETE FROM " . PREFIX . "_modul_forum_forum WHERE id = '" . $id . "'";
		$result = $AVE_DB->Query($query);
	}

	// ========================================================
	// THEMEN- LOESCHFUNKTION
	// 1. alle beitraege zum thema loeschen
	// 2. das rating zum thema loeschen
	// 3. thema loeschen
	// ========================================================
	function deleteTopic($id)
	{
		global $AVE_DB;
		
		$query = "SELECT id FROM " . PREFIX . "_modul_forum_post WHERE topic_id = '" . $id . "'";
		$result = $AVE_DB->Query($query);
		// Beitraege loeschen
		while ($post = $result->FetchRow())
		{
			$this->deletePost($post->id);

		}
		// Rating loeschen
		$query = "DELETE FROM " . PREFIX . "_modul_forum_rating WHERE topic_id = '" . $id . "'";
		$result = $AVE_DB->Query($query);
		// Thema loeschen
		$query = "DELETE FROM " . PREFIX . "_modul_forum_topic WHERE id = '" . $id . "'";
		$result = $AVE_DB->Query($query);
	}

	// ========================================================
	// BEITRAGS- LOESCHFUNKTION
	// 1. alle anhaenge loeschen
	// 2. anzahl der beitraege im thema reduzieren
	// 3. anzahl der beitraege des benutzers reduzieren
	// 4. beitrag loeschen
	// ========================================================
	function deletePost($id)
	{
		global $AVE_DB;
		
		$query = "SELECT uid, attachment, topic_id FROM " . PREFIX . "_modul_forum_post WHERE id = '" . $id . "'";
		$result = $AVE_DB->Query($query);
		$post = $result->FetchRow();

		$attachments = @explode(";", $post->attachment);

		// anhaenge loeschen
		foreach ($attachments as $attachment)
		{
			if ($attachment != "")
			{
				$query = "SELECT filename FROM " . PREFIX . "_modul_forum_attachment WHERE id = '" . $attachment . "'";
				$result = $AVE_DB->Query($query);
				$file = $result->FetchRow();
				// loesche aus dem dateisystem
				//  @unlink ("../uploads/attachment" . $file);
				// loesche aus der datenbank
				$query = "DELETE FROM " . PREFIX . "_modul_forum_attachment WHERE id = '" . $attachment . "'";
				$result = $AVE_DB->Query($query);
			}
		}

		// reduziere die anzahl der beitraege im thema
		$query = "UPDATE " . PREFIX . "_modul_forum_topic SET replies = replies -1 WHERE id = " . $post->topic_id;
		$result = $AVE_DB->Query($query);

		// reduziere die anzahl der beitraege des benutzers
		$query = "UPDATE " . PREFIX."_modul_forum_userprofile SET messages = messages -1 WHERE uid = " . $post->uid;
		$result = $AVE_DB->Query($query);

		// loesche beitrag
		$query = "DELETE FROM " . PREFIX . "_modul_forum_post WHERE id = '" . $id . "'";
		$result = $AVE_DB->Query($query);
	}

	//=======================================================
	// 1000er - Schritte formatieren
	//=======================================================
	function num_format($param)
	{
		return number_format($param,'0','','.');
	}

	function getonlinestatus($user_name)
	{
		global $AVE_DB, $mod;
		
		$sql = $AVE_DB->Query("SELECT uname, invisible FROM " . PREFIX . "_modul_forum_useronline WHERE uname='" . $user_name . "' LIMIT 1");
		$num = $sql->NumRows();
		$row = $sql->FetchRow();
		if ($num == 1)
		{
			if ((UGROUP == 1) && ($row->invisible == "INVISIBLE")) {
				$img = "user_invisible.gif" ;
				$alt = $mod['config_vars']['FORUMS_USER_IS_INVISIBLE'];
			}
			if ($row->invisible != "INVISIBLE") {
				$img = "user_online.gif" ;
				$alt = $mod['config_vars']['FORUMS_USER_IS_ONLINE'];
			}
			if ((UGROUP != 1) && ($row->invisible == "INVISIBLE")) {
				$img = "user_offline.gif" ;
				$alt = $mod['config_vars']['FORUMS_USER_IS_OFFLINE'];
			}
		} else {
			$img = "user_offline.gif" ;
			$alt = $mod['config_vars']['FORUMS_USER_IS_OFFLINE'];
		}

		$status_img = "<img class=\"absmiddle\" src=\"templates/".THEME_FOLDER."/modules/forums/statusicons/$img\" alt=\"$alt\" /> $alt";
		return $status_img;
	}

	function getInvisibleStatus($UserId)
	{
		global $AVE_DB;
		
		$sql = $AVE_DB->Query("SELECT uid, invisible FROM " . PREFIX . "_modul_forum_userprofile WHERE uid = '" . $UserId . "'");
		$row = $sql->FetchRow();
		return (@$row->invisible==1) ? "INVISIBLE" : @$row->invisible;
	}

	//=======================================================
	// Online-User aktualisieren
	//=======================================================
	function UserOnlineUpdate()
	{
		global $AVE_DB;
		
		$expire = time() + (60 * 10);
		$sql = $AVE_DB->Query("DELETE FROM " . PREFIX . "_modul_forum_useronline WHERE expire <= '" . time() . "'");

		if(isset($_SESSION['user_id']))
		{
			$sql = $AVE_DB->Query("SELECT id, uid FROM " . PREFIX . "_modul_forum_userprofile WHERE uid = '" . $_SESSION['user_id'] . "'");
			$num = $sql->NumRows();

			// Wenn der Benutzet noch nicht im Forum-Profil gespeichert wurde,
			// wird dies hier getan
			if(!$num)
			{
				$sql = $AVE_DB->Query("SELECT * FROM " . PREFIX . "_users WHERE Id  = '" . $_SESSION['user_id'] . "'");
				$row = $sql->FetchRow();

				$AVE_DB->Query("
					INSERT
					INTO " . PREFIX . "_modul_forum_userprofile
					SET
						id                    = '',
						uid                   = '" . $row->Id . "',
						uname                 = '". (($row->user_name!='') ? $row->user_name : mb_substr($row->firstname,0,1) . '. ' . $row->lastname) . "',
						group_id_misc         = '',
						messages              = '',
						show_profile          = '1',
						signature             = '',
						icq                   = '',
						aim                   = '',
						skype                 = '',
						email_receipt         = '1',
						pn_receipt            = '1',
						avatar                = '',
						avatar_default        = '',
						web_site              = '',
						invisible             = '0',
						interests             = '',
						email                 = '" . $row->email . "',
						reg_time              = '" . $row->reg_time . "',
						birthday              = '" . $row->birthday . "'
				");

				header("Location:index.php?module=forums");
			}

			$sql = $AVE_DB->Query("SELECT ip FROM " . PREFIX . "_modul_forum_useronline WHERE ip = '" . $_SERVER['REMOTE_ADDR'] . "' LIMIT 1");
			$num = $sql->NumRows();

			if ($num < 1)
				$sql = $AVE_DB->Query("
					INSERT INTO " . PREFIX . "_modul_forum_useronline
						(
							ip,expire,uname,invisible
						) VALUES (
							'" . $_SERVER['REMOTE_ADDR'] . "',
							'" . $expire . "',
							'" . (defined("USERNAME") ? USERNAME : "UNAME") . "',
							'" . (defined("USERNAME") ? $this->getInvisibleStatus($_SESSION['user_id']) : "INVISIBLE") . "'
						)
					");
			 else
				$sql = $AVE_DB->Query("
					UPDATE " . PREFIX . "_modul_forum_useronline
					SET
						uid = '" .  $_SESSION['user_id']. "',
						uname = '" . (defined("USERNAME") ? USERNAME : "UNAME") . "',
						invisible = '" . (defined("USERNAME") ? $this->getInvisibleStatus($_SESSION['user_id']) : "INVISIBLE") . "'
					WHERE
						ip='" . $_SERVER['REMOTE_ADDR'] . "'
				");
		} else {
			$sql = $AVE_DB->Query("SELECT ip FROM " . PREFIX . "_modul_forum_useronline WHERE ip = '" . $_SERVER['REMOTE_ADDR'] . "' LIMIT 1");
			$num = $sql->NumRows();
			if ($num < 1)
				$sql = $AVE_DB->Query("INSERT INTO " . PREFIX . "_modul_forum_useronline (ip,expire,uname,invisible) VALUES ('" . $_SERVER['REMOTE_ADDR'] . "','" . $expire . "','UNAME','0')");
		}
	}

	//=======================================================
	// Benutzerprofil anzeigen
	//=======================================================
	function showPoster()
	{
		global $AVE_DB, $AVE_Template, $mod;
		
		if (isset($_GET['tid']) && is_numeric($_GET['tid']) && $_GET['tid'] > 0)
		{
			$q_poster = "SELECT
					COUNT(u.uname) AS ucount,
					u.uid,
					u.uname
				FROM
					" . PREFIX . "_modul_forum_userprofile AS u,
					" . PREFIX . "_modul_forum_post AS p
				WHERE
					p.topic_id = '" . addslashes($_GET['tid']) . "' AND
					p.uid = u.uid
				GROUP BY u.uname
			";

			$r_poster = $AVE_DB->Query($q_poster);
			$poster = array();
			while ($post = $r_poster->FetchRow())
			{
				$poster[] = $post;
			}

			$AVE_Template->assign("poster", $poster);

			$tpl_out = $AVE_Template->fetch($mod['tpl_dir'] . "showposter.tpl");
			define("MODULE_CONTENT", $tpl_out);
			define("MODULE_SITE",  $mod['config_vars']['FORUMS_PAGE_NAME_USER_PROFILE']);
		}
	}

	// ================================================================
	// topicExists eueberprueft, ob thema existiert
	// ================================================================
	function topicExists($t_id)
	{
		global $AVE_DB;
		
		$query = "SELECT id FROM " . PREFIX . "_modul_forum_topic WHERE id = '" . $t_id . "'";
		$result = $AVE_DB->Query($query);
		if ($result->NumRows() > 0) return 1;
		return 0;
	}
	
	/**
	* Показывать профиль пользователя
	*
	*/
	function showUserProfile()
	{
		global $AVE_DB, $AVE_Template, $mod;
		
		if(isset($_POST['SendMail']) && $_POST['SendMail'] == 1 && UGROUP != 2)
		{
			// Prьfen, ob dieser User die E-Mail an den User senden darf
			$Absender = $_SESSION['forum_user_email'];
			$Empfang = $_POST['ToUser'];

			$q = "SELECT
					a.uid,
					a.ignore_id,
					b.uid,
					b.email,
					b.uname
				FROM
					" . PREFIX . "_modul_forum_ignorelist as a,
					" . PREFIX . "_modul_forum_userprofile as b
				WHERE
					a.uid = " . addslashes($_POST['ToUser']) . " AND
					a.ignore_id != " . $_SESSION['user_id'] . " AND
					b.uid = " . addslashes($_POST['ToUser']) . "
			";
			$sql = $AVE_DB->Query($q);
			$num = $sql->NumRows();
			$row = $sql->FetchRow();

			// E-Mail darf gesendet werden
			if($num == 1)
			{
				$Prefab = $mod['config_vars']['FORUMS_EMAIL_BODY_USER'];
				$Prefab = str_replace('%%USER%%', $row->uname, $Prefab);
				$Prefab = str_replace('%%ABSENDER%%', $_SESSION['forum_user_name'], $Prefab);
				$Prefab = str_replace('%%BETREFF%%', stripslashes($_POST['subject']), $Prefab);
				$Prefab = str_replace('%%NACHRICHT%%', stripslashes($_POST['message']), $Prefab);
				$Prefab = str_replace('%%ID%%', $_SESSION['user_id'], $Prefab);
				$Prefab = str_replace('%%N%%', "\n",$Prefab);
				$Prefab = str_replace('','',$Prefab);
				send_mail(
					$row->email,
					$Prefab,
					stripslashes($_POST['subject']),
					FORUMEMAIL,
					FORUMABSENDER,
					"text"
				);

				// weiter leiten
				$this->msg($mod['config_vars']['FORUMS_MESSAGE_AFTER_EMAIL'], 'index.php?module=forums&show=userprofile&user_id=' . $_POST['ToUser']);
			}
			else 
			{
				// keine e-mail
				$this->msg($mod['config_vars']['FORUMS_MESSAGE_NO_EMAIL'], 'index.php?module=forums&show=userprofile&user_id=' . $_POST['ToUser']);
			}
		}

		// Nicht eingeloggt, aber versucht es trotzdem :)
		if(isset($_POST['SendMail']) && $_POST['SendMail'] == 1 && UGROUP == 2)
		{
			$this->msg($mod['config_vars']['FORUMS_ERROR_NO_PERM'], 'index.php?module=forums&show=userprofile&user_id=' . $_POST['ToUser']);
		}

		$_GET['user_id'] = (isset($_GET['user_id']) and is_numeric($_GET['user_id'])) ? $_GET['user_id'] : 0;
		$sql_user = $AVE_DB->Query("SELECT
				u.*,
				ug.user_group,
				ugn.user_group_name as group_name
			FROM
				" . PREFIX . "_modul_forum_userprofile as u,
				" . PREFIX . "_users as ug,
				" . PREFIX . "_user_groups as ugn
			WHERE
				u.uid = '".addslashes($_GET['user_id'])."'
			AND
				ug.Id = u.uid
			AND
				ugn.user_group = ug.user_group
		");
		$row_user = $sql_user->FetchRow();

		if($row_user->show_profile==1)
		{
			$row_user->signature = $this->kcodes_comments($row_user->signature);
			$row_user->signature = (SMILIES==1) ? $this->replaceWithSmileys($row_user->signature) : $row_user->signature;

			$row_user->interests = $this->kcodes_comments($row_user->interests);
			$row_user->interests = (SMILIES==1) ? $this->replaceWithSmileys($row_user->interests) : $row_user->interests;

			$row_user->avatar = $this->getAvatar($row_user->user_group,$row_user->avatar,$row_user->avatar_default);
			$row_user->OnlineStatus = @$this->getonlinestatus(@$row_user->uname);

			$query = "SELECT COUNT(id) AS counts FROM " . PREFIX . "_modul_forum_post WHERE uid = '" . addslashes($_GET['user_id']) . "'";
			$result = $AVE_DB->Query($query);
			$r_c = $result->FetchRow();
			$row_user->postings = $this->num_format($r_c->counts);

			$AVE_Template->assign("Ignored", (($this->isIgnored(addslashes($_GET['user_id']))) ? 1 : 0) );
			$AVE_Template->assign("public", 1);
			$AVE_Template->assign("user", $row_user);
		}

		$tpl_out = $AVE_Template->fetch($mod['tpl_dir'] . $this->_UserProfileTpl);
		define("MODULE_CONTENT", $tpl_out);
		define("MODULE_SITE",  $mod['config_vars']['FORUMS_PAGE_NAME_USER_PROFILE']);
	}

	/**
	*  Список пользователя
	*
	*/
	function getUserlist()
	{
		define("USERLIST", 1);
		include_once(BASE_DIR . "/modules/forums/internals/userlist.php");
	}

	//=======================================================
	// Benennt eine Datei um, wenn diese existiert
	//=======================================================
	function createFilename($dir)
	{
		$fn = time() . mt_rand(0, 1000000000);
		if (file_exists($dir . $fn)) {
			return createFilename($dir);
		} else {
			return $fn;
		}
	}

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

	//=======================================================
	// Funktion um Emoticons mit Smilies zu ersetzen
	//=======================================================
	function replaceWithSmileys($texts)
	{
		global $AVE_DB;
		
		if(SMILIES==1)
		{
			$sql = $AVE_DB->Query("SELECT code,path FROM " . PREFIX . "_modul_forum_smileys WHERE active = 1");
			while($row_s = $sql->FetchRow())
			{
				$texts = @str_replace($row_s->code,'<img src="templates/' . THEME_FOLDER . '/modules/forums/smilies/' . $row_s->path . '" border="0" alt="" />', $texts);
			}
		}
		return $texts;
	}

	//=======================================================
	//BB-CODES KOMMENTARE
	//=======================================================
	function kcodes_comments($text)
	{
		global $pref;
		if (COMMENTSBBCODE == 1){
			$text = $this->pre_kcodes($text);
		}else {
			$text = nl2br(kspecialchars($text));
		}
		return $text;
	}

	//=======================================================
	// Text zensieren
	//=======================================================
	function badwordreplace($text)
	{
		$badwords = $this->forumSettings('bad_words');
		$badwords = str_replace(array("\r\n", "\n"), '', $badwords);
		$badwords = trim($badwords);

		if ($badwords)
		{
			$bwrp = trim($this->forumSettings('bad_words_replace'));
			if (empty($bwrp)) $bwrp = "!#*$&?";

			$badwords = implode('|', explode(',', preg_quote($badwords)));
			$text = @preg_replace("/$badwords/i", $bwrp, $text);
		}

		return $text;
	}

	//=======================================================
	// Rekursive Forum - Navigation erzeugen
	//=======================================================
	function getNavigation($id, $type, $result = null)
	{
		global $AVE_DB, $mod;
		
		if ($type == "category") $parent_id = "parent_id";
		if ($type == "forum") $parent_id = "category_id";
		if ($type == "topic") $parent_id = "forum_id";
		if ($type == "post") $parent_id = "topic_id";

		// daten des aktuellen bereichs
		$q_navi = "SELECT id, title, $parent_id AS pid FROM " . PREFIX . "_modul_forum_" . $type . " WHERE id = '" . $id . "'";
		$r_navi = $AVE_DB->Query($q_navi);
		$navi = $r_navi->FetchRow();

		// rekursion abgeschlossen
		if (@$navi->pid == 0)
		{
			return  '<a class="forum_links_navi"  href="index.php?module=forums&amp;show=showforums">'.$mod['config_vars']['FORUMS_PAGE_NAME_FORUMS'].'</a>' . $result;
		}

		// typ des darueberliegenden bereiches bestimmen
		if ($type == "post") $type = "topic";
		else if ($type == "topic") $type = "forum";
		else if ($type == "forum") $type = "category";
		else if ($type == "category") $type = "forum";

		// daten des darueberliegenden bereiches
		$q_parent = "SELECT id, title FROM " . PREFIX . "_modul_forum_$type WHERE id = '" . $navi->pid . "'";
		$r_parent = $AVE_DB->Query($q_parent);
		$parent = $r_parent->FetchRow();

		if ($type == "topic") $result = $mod['config_vars']['FORUMS_FORUM_SEP'] . "<a class='forum_links_navi' href='index.php?module=forums&show=showtopic&amp;tid=" . $parent->id . "'>" . $parent->title . "</a>" . $result;
		else if ($type == "forum") $result = $mod['config_vars']['FORUMS_FORUM_SEP'] . "<a class='forum_links_navi' href='index.php?module=forums&amp;show=showforum&amp;fid=" . $parent->id . "'>" . $parent->title . "</a>" . $result;
		else if ($type == "category") $result = $mod['config_vars']['FORUMS_FORUM_SEP'] . "<a class='forum_links_navi' href='index.php?module=forums&show=showforums&cid=" . $parent->id . "'>" . $parent->title . "</a>" . $result;
		return $this->getNavigation($navi->pid, $type, $result);
	}

	//=======================================================
	// Grцsse umrechnen
	//=======================================================
	function file_size($param)
	{
		$size = $param;
		$size = $size*1024;
		$sizes = Array(' Байт', 'КБ', 'МБ', 'ГБ', 'ТБ', 'PБ', 'EБ');
		$ext = $sizes[0];
		for ($i = 1; (($i < count($sizes)) && ($size >= 1024)); $i++) {
			$size = $size / 1024;
			$ext = ' ' . $sizes[$i];
		}
		return round($size, 1) . $ext;
	}

	//=======================================================
	// Dateianhang-Grцsse
	//=======================================================
	function get_attachment_size($file)
	{
		if ($fsize = @filesize(BASE_DIR . '/modules/forums/attachments/' . $file))
		{
			$fsize = $fsize/1024;
			return $this->file_size($fsize);
		}
	}

	// ========================================================
	// getForums listet alle foren auf
	// ========================================================
	function getForums($id, &$forums, $prefix, $f_id = "0")
	{
		global $AVE_DB;
		
		// kategorien holen
		$q_cat = "SELECT id FROM " . PREFIX . "_modul_forum_category WHERE parent_id = '" . $id . "'";
		$r_cat = $AVE_DB->Query($q_cat);
		// berechtigung holen
		$group_ids_misc = array();
		// miscrechte
		if (@is_numeric(UID) && UGROUP != 2)
		{
//			$queryfirst = "SELECT group_id_misc FROM " . PREFIX."_modul_forum_userprofile WHERE uid = '" . UID . "'";
//			$result = $AVE_DB->Query($queryfirst);
//			$user = $result->FetchRow();
			$group_id_misc = $this->GroupIdMiscGet(UID);
			// wenn misc nicht leer ist...
			if ($group_id_misc) {
				$group_ids_pre = UGROUP . ";" . $group_id_misc;
				$group_ids_misc = @explode(";", $group_ids_pre);
				// wennn misc leer ist und user eingeloggt ist
			} else {
				$group_ids_misc[] = UGROUP;
			}
			// wenn user nicht eingeloggt ist
		} else {
			$group_ids_misc[] = 2;
		}
		// kategorien durchgehen
		$sub=false;
		while ($cat = $r_cat->FetchRow())
		{
			// foren zur kategorie holen
			$q_forum = "SELECT
					f.id,
					f.category_id,
					f.title,
					f.group_id
				FROM
					" . PREFIX . "_modul_forum_forum AS f
				WHERE
					f.category_id = '" . $cat->id . "' AND
					f.active = 1
			";
			$result = $AVE_DB->Query($q_forum);

			// alle foren durchgehen
			while ($forum = $result->FetchRow())
			{
				// forumname
				$sql_ftitle = $AVE_DB->Query("SELECT title FROM " . PREFIX . "_modul_forum_category WHERE id = '" . $forum->category_id . "'");
				$row_ftitle = $sql_ftitle->FetchRow();

				$group_ids = explode(",", $forum->group_id);

				if (array_intersect($group_ids_misc, $group_ids))
				{
					foreach($group_ids_misc as $gids_misc)
					{
						if(in_array($gids_misc, $group_ids))
						{
							$permissions = $this->getForumPermissions($forum->id, $gids_misc);

							if ($permissions[FORUM_PERMISSION_CAN_SEE] == 1)
							{
								$forum->visible_title = $prefix . $forum->title;
								$forum->fname = $row_ftitle->title;

								$q_sub_cat = "SELECT id FROM " . PREFIX . "_modul_forum_category WHERE parent_id = " . $forum->id;
								$r_sub_cat = $AVE_DB->Query($q_sub_cat);
								$forums[] = $forum;
								$sub=true;
							}
						}
					}

					if($sub==true)
					{
						while ($sub_cat = $r_sub_cat->FetchRow())
						{
							$this->getForums($forum->id, $forums, $prefix . "- ", $f_id);
						}
					}
				}
			}
		}
	}

	function getCategories($id, &$categories, $prefix)
	{
		global $AVE_DB;

		// kategorien holen
		$q_cat = "SELECT
				id,
				title,
				group_id,
				position
			FROM
				" . PREFIX . "_modul_forum_category
			WHERE
				parent_id = $id
			ORDER BY position
		";
		$r_cat = $AVE_DB->Query($q_cat);

		// berechtigung holen
		$group_ids_misc = array();

		// miscrechte
		if (@is_numeric(UID) && UGROUP != 2) {
//			$queryfirst = "SELECT group_id_misc FROM " . PREFIX."_modul_forum_userprofile WHERE uid = '" . UID . "'";
//			$result = $AVE_DB->Query($queryfirst);
//			$user = $result->FetchRow();
			$group_id_misc = $this->GroupIdMiscGet(UID);

			//========================================================
			// wenn misc nicht leer ist...
			//========================================================
			if ($group_id_misc)
			{
				$group_ids_pre = UGROUP . ";" . $group_id_misc;
				$group_ids_misc = @explode(";", $group_ids_pre);

			//========================================================
			// wennn misc leer ist und user eingeloggt ist
			//========================================================
			} else {
				$group_ids_misc[] = UGROUP;
			}
			//========================================================
			// wenn user nicht eingeloggt ist
			//========================================================
		} else {
			$group_ids_misc[] = 2;
		}
		//========================================================
		// kategorien durchgehen
		//========================================================
		while ($cat = $r_cat->FetchRow())
		{
			$cat->group_id = @explode(",", $cat->group_id);
			if (array_intersect($cat->group_id, $group_ids_misc))
			{
				//========================================================
				// foren zur kategorie holen
				//========================================================
				$q_forum = "SELECT
						f.id,
						f.category_id,
						f.title,
						f.group_id,
						f.position,
						c.title AS fname
					FROM
						" . PREFIX . "_modul_forum_forum AS f
					JOIN
						" . PREFIX . "_modul_forum_category AS c
							ON c.id = f.category_id
					WHERE
						f.category_id = '" . $cat->id . "' AND
						f.active = 1
					ORDER BY position
				";
				$result = $AVE_DB->Query($q_forum);
				// alle foren durchgehen
				while ($forum = $result->FetchRow()) {
					// forumname
//					$sql_ftitle = $AVE_DB->Query("SELECT title FROM " . PREFIX . "_modul_forum_category WHERE id = '" . $forum->category_id . "'");
//					$row_ftitle = $sql_ftitle->FetchRow();

					$group_ids = explode(",", $forum->group_id);

					if (array_intersect($group_ids_misc, $group_ids)) {
						$forum->visible_title = $prefix . $forum->title;
//						$forum->fname = $row_ftitle->title;

						$q_sub_cat = "SELECT id FROM " . PREFIX . "_modul_forum_category WHERE parent_id = " . $forum->id;
						$r_sub_cat = $AVE_DB->Query($q_sub_cat);

						$cat->forums[] = $forum;

						while ($sub_cat = $r_sub_cat->FetchRow()) {
							$this->getCategories($forum->id, $categories, $prefix . "- ");
						}
					} // if array
				} // while forum
				$categories[] = $cat;
			} // if array_intersect
		}
	}

	//========================================================
	// FORUM PERMISSIONS
	// ermittelt die rechte fuer den aktuellen Benutzer
	//========================================================
	function getForumPermissions($forumid, $groupid, $ext_uid = 0)
	{
		global $AVE_DB;
		$sql = $AVE_DB->Query("SELECT permissions FROM " . PREFIX . "_modul_forum_permissions WHERE forum_id = '" . $forumid . "' AND group_id = '" . $groupid . "'");
		$row = $sql->FetchRow();

		if (UGROUP == 1) {
			return explode(",", "1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1");
		} else {
			return explode(",", $row->permissions);
		}
	}

	//=======================================================
	// Foren-Rechte nach Benutzer-ID auslesen
	//=======================================================
	function getForumPermissionsByUser($forum_id, $user_id)
	{
		global $AVE_DB;
		
		if (@is_numeric(UID) && UID != 0)
		{
//			$queryfirst = "SELECT group_id_misc FROM " . PREFIX."_modul_forum_userprofile WHERE uid = '" . $user_id . "'";
//			$result = $AVE_DB->Query($queryfirst);
//			$user = $result->FetchRow();
			$group_id_misc = $this->GroupIdMiscGet($user_id);

			if ($group_id_misc)
			{
				$group_ids = @explode(";", UGROUP . ";" . $group_id_misc);
			} else {
				$group_ids[] = UGROUP;
			}
		} else {
			$group_ids[] = 2;
		}

		$all_permissions = array();

		foreach ($group_ids as $group_id)
		{
			$permissions = "";
			$query = "SELECT permissions FROM " . PREFIX . "_modul_forum_permissions WHERE forum_id = '" . $forum_id . "' AND group_id = '" . $group_id . "'";
			$result = $AVE_DB->Query($query);

			$r_permissions = $result->FetchRow();

			$obj = $r_permissions;
			$permissions = explode(",", @$r_permissions->permissions);
			if(is_object($obj))
			{
				if ($permissions[0] == 1) {
					$all_permissions[0] = 1;
				}

				if (@$permissions[FORUM_PERMISSION_CAN_SEE_TOPIC] == 1) {
					$all_permissions[FORUM_PERMISSION_CAN_SEE_TOPIC] = 1;
				}

				if (@$permissions[FORUM_PERMISSION_CAN_SEE_DELETE_MESSAGE] == 1) {
					$all_permissions[FORUM_PERMISSION_CAN_SEE_DELETE_MESSAGE] = 1;
				}

				if (@$permissions[FORUM_PERMISSION_CAN_SEARCH_FORUM] == 1) {
					$all_permissions[FORUM_PERMISSION_CAN_SEARCH_FORUM] = 1;
				}

				if (@$permissions[FORUM_PERMISSION_CAN_DOWNLOAD_ATTACHMENT] == 1) {
					$all_permissions[FORUM_PERMISSION_CAN_DOWNLOAD_ATTACHMENT] = 1;
				}

				if (@$permissions[FORUM_PERMISSION_CAN_CREATE_TOPIC] == 1) {
					$all_permissions[FORUM_PERMISSION_CAN_CREATE_TOPIC] = 1;
				}

				if (@$permissions[FORUM_PERMISSION_CAN_REPLY_OWN_TOPIC] == 1) {
					$all_permissions[FORUM_PERMISSION_CAN_REPLY_OWN_TOPIC] = 1;
				}

				if (@$permissions[FORUM_PERMISSION_CAN_REPLY_OTHER_TOPIC] == 1) {
					$all_permissions[FORUM_PERMISSION_CAN_REPLY_OTHER_TOPIC] = 1;
				}

				if (@$permissions[FORUM_PERMISSION_CAN_UPLOAD_ATTACHMENT] == 1) {
					$all_permissions[FORUM_PERMISSION_CAN_UPLOAD_ATTACHMENT] = 1;
				}

				if (@$permissions[FORUM_PERMISSION_CAN_RATE_TOPIC] == 1) {
					$all_permissions[FORUM_PERMISSION_CAN_RATE_TOPIC] = 1;
				}

				if (@$permissions[FORUM_PERMISSION_CAN_EDIT_OWN_POST] == 1) {
					$all_permissions[FORUM_PERMISSION_CAN_EDIT_OWN_POST] = 1;
				}

				if (@$permissions[FORUM_PERMISSION_CAN_DELETE_OWN_POST] == 1) {
					$all_permissions[FORUM_PERMISSION_CAN_DELETE_OWN_POST] = 1;
				}

				if (@$permissions[FORUM_PERMISSION_CAN_MOVE_OWN_TOPIC] == 1) {
					$all_permissions[FORUM_PERMISSION_CAN_MOVE_OWN_TOPIC] = 1;
				}

				if (@$permissions[FORUM_PERMISSION_CAN_CLOSE_OPEN_OWN_TOPIC] == 1) {
					$all_permissions[FORUM_PERMISSION_CAN_CLOSE_OPEN_OWN_TOPIC] = 1;
				}

				if (@$permissions[FORUM_PERMISSION_CAN_DELETE_OWN_TOPIC] == 1) {
					$all_permissions[FORUM_PERMISSION_CAN_DELETE_OWN_TOPIC] = 1;
				}

				if (@$permissions[FORUM_PERMISSION_CAN_DELETE_OTHER_POST] == 1) {
					$all_permissions[FORUM_PERMISSION_CAN_DELETE_OTHER_POST] = 1;
				}

				if (@$permissions[FORUM_PERMISSION_CAN_EDIT_OTHER_POST] == 1) {
					$all_permissions[FORUM_PERMISSION_CAN_EDIT_OTHER_POST] = 1;
				}

				if (@$permissions[FORUM_PERMISSIONS_CAN_OPEN_TOPIC] == 1) {
					$all_permissions[FORUM_PERMISSIONS_CAN_OPEN_TOPIC] = 1;
				}

				if (@$permissions[FORUM_PERMISSIONS_CAN_CLOSE_TOPIC] == 1) {
					$all_permissions[FORUM_PERMISSIONS_CAN_CLOSE_TOPIC] = 1;
				}

				if (@$permissions[FORUM_PERMISSIONS_CAN_CHANGE_TOPICTYPE] == 1) {
					$all_permissions[FORUM_PERMISSIONS_CAN_CHANGE_TOPICTYPE] = 1;
				}

				if (@$permissions[FORUM_PERMISSIONS_CAN_MOVE_TOPIC] == 1) {
					$all_permissions[FORUM_PERMISSIONS_CAN_MOVE_TOPIC] = 1;
				}

				if (@$permissions[FORUM_PERMISSIONS_CAN_DELETE_TOPIC] == 1) {
					$all_permissions[FORUM_PERMISSIONS_CAN_DELETE_TOPIC] = 1;
				}
			}
		}

		return $all_permissions;
	}

	//=======================================================
	// Returns an array of subforum ids of forum with id $forumId.
	// @param int $forumId
	// @param Array $forumIds
	// @return Array
	//=======================================================
	function getForumIds($forumId, $forumIds = '')
	{
		global $AVE_DB;

		static $retval = array();

		if (!isset($retval[$forumId]))
		{
			if ($forumIds == '')
			{
				$forumIds = array();
				array_push($forumIds, $forumId);
			}

			$sql = $AVE_DB->Query("
				SELECT 
					c.id,
					c.parent_id,
					f.category_id
				FROM " . PREFIX . "_modul_forum_category AS c
				LEFT JOIN " . PREFIX . "_modul_forum_forum AS f ON f.category_id = c.id
				WHERE c.parent_id = '". $forumId ."'
			");
			while ($row = $sql->FetchRow())
			{
				array_push($forumIds, $row->id);
				$forumIds = $this->getForumIds($row->id, $forumIds);
			}

			$retval[$forumId] = $forumIds;
		}

		return $retval[$forumId];
	}

	//=======================================================
	// Returns the last forum post including topic_id, title, id, uid,
	// datum and Registriert as an object
	// if there are forums - otherwise false.
	// @param int $forumId
	// @return Object
	//=======================================================
	function getLastForumPost($forumId)
	{
		global $AVE_DB;

		static $retval = array();

		if (!isset($retval[$forumId]))
		{
			$forumIds = $this->getForumIds($forumId);

			if (!count($forumIds)) return ($retval[$forumId] = false);

//			$oc = (defined("UGROUP") && UGROUP==1) ? '' : "t.opened = '1' AND ";
			$oc = "t.opened = '1' AND ";
			if (defined('UGROUP') && UGROUP==1)
			{
				$oc = '';
			}
			elseif (defined('UID') && UID > 0)
			{
				$is_moderator = $AVE_DB->Query("
					SELECT 1
					FROM " . PREFIX . "_modul_forum_mods
					WHERE forum_id = '" . $fid . "'
					AND  user_id = " . UID . "
					LIMIT 1
				")->NumRows();
				if ($is_moderator) $oc = '';
			}

			$retval[$forumId] = $AVE_DB->Query("
				SELECT
					t.id AS topic_id,
					t.title,
					t.title AS TopicName,
					p.id,
					p.uid,
					p.datum,
					u.reg_time AS user_regdate,
					us.uid,
					us.uname
				FROM
					" . PREFIX . "_modul_forum_topic AS t
				JOIN
					" . PREFIX . "_modul_forum_post AS p
						ON p.topic_id = t.id
				JOIN
					" . PREFIX . "_users AS u
						ON u.Id = p.uid
				JOIN
					" . PREFIX . "_modul_forum_userprofile AS us
						ON us.uid = p.uid
				WHERE
					(" . $oc . "t.forum_id = '"
						. implode("') OR (" . $oc . "t.forum_id = '", $forumIds)
					. "')
				ORDER BY
					t.last_post DESC,
					p.datum DESC
				LIMIT 1
			")->FetchRow();
		}
		return $retval[$forumId];
	}

	//=======================================================
	// Returns a database query including all topic ids of all subforums.
	// @param int $forumId
	// @return DatabaseQuery
	//=======================================================
	function getNumberOfThreadsQuery($forumId)
	{
		global $AVE_DB, $q_tcount_extra, $show_only_own_topics;

		$forumIds = $this->getForumIds($forumId);

		return $AVE_DB->Query("
			SELECT id
			FROM " . PREFIX . "_modul_forum_topic
			WHERE (forum_id = '" . implode("' OR forum_id = '", $forumIds) . "')
			" . $q_tcount_extra . "
			" . $show_only_own_topics . "
		");
	}

	//=======================================================
	// Beitrag als gelesen markieren
	//=======================================================
	function Cpengine_Board_SetTopicRead($Topic, $Usr = null)
	{
		global $AVE_DB;
	   if (is_null($Usr)) $Usr = UID;

		$AVE_DB->Query("REPLACE DELAYED INTO " . PREFIX . "_modul_forum_topic_read (Usr,Topic) VALUES (" . (int)$Usr . "," . (int)$Topic . ")");
	}

	function Cpengine_Board_SetLastPost($Board)
	{
		global $AVE_DB;
		
		$Board = (int) $Board;
		$Sql = "SELECT
			Post.id,
			Post.datum
		FROM
			" . PREFIX . "_modul_forum_topic AS Topic
		INNER JOIN
			" . PREFIX . "_modul_forum_post AS Post
		ON
			Topic.id = Post.topic_id
		AND
			Topic.forum_id = " . $Board . "
		ORDER
			BY  Post.datum DESC
		LIMIT 1";
		$Res = $AVE_DB->Query($Sql);

		if ($Res !== false)
		{
			$LastPost = $Res->FetchRow();
			 $Sql = "UPDATE  " . PREFIX . "_modul_forum_forum SET
					last_post       = '".$LastPost->datum."',
					last_post_id    = ".$LastPost->id."
			   WHERE
					id = " . $Board . " ";
			$Res = $AVE_DB->Query($Sql);
		}
	}

	function Cpengine_Board_GetTopic_Board($Topic)
	{
		global $AVE_DB;
		
		$Sql = "SELECT  Topic.forum_id FROM " . PREFIX . "_modul_forum_topic AS Topic WHERE Topic.id = " . (int)$Topic . " LIMIT 1";
		$Res = $AVE_DB->Query($Sql);
		$Row = $Res->FetchRow();
		return (int) $Row->forum_id;
	}

	//=======================================================
	// Forum als gelesen markieren
	//=======================================================
	function setForumAsRead($Board = '', $Usr = null, $BoardAll = '')
	{
		global $AVE_DB;
		
		if (is_null($Usr))
		$Usr = UID;

		$Board  = (int) $Board;
		$BoardAll = ($_REQUEST['ReadAll']==1) ? 'WHERE Topic.forum_id != 0' :   'WHERE Topic.forum_id = '.$Board.'';
		$Usr    = (int) $Usr;

		$SQL_Post48h    = ' Topic.last_post > \''.date('Y-m-d', strtotime(BOARD_NEWPOSTMAXAGE)).'\' ';
		$sql = 'REPLACE DELAYED INTO ' . PREFIX . '_modul_forum_topic_read (Usr,Topic)
			SELECT
				' . $Usr . ',
				Topic.id
			FROM  ' . PREFIX . '_modul_forum_topic as Topic
			' . $BoardAll . '
			AND
				' . $SQL_Post48h . '';

		$dump = $AVE_DB->Query($sql);
	}

	//=======================================================
	// Lezten Beitrag auslesen
	//=======================================================
	function getLastPost($id)
	{
		global $AVE_DB;
		$post = "";
		if(is_numeric($id))
		{
			$result = $AVE_DB->Query("SELECT id FROM " . PREFIX . "_modul_forum_post WHERE topic_id = '" . $id . "' ORDER BY id DESC LIMIT 2");
			$post = $result->FetchRow();

			if ($result->NumRows() > 1)
			{
				$post->prev_post = $result->FetchRow();
			}
		}
		return $post;
	}

	//=======================================================
	// Letzte Beitrдge eines Forum auslesen
	//=======================================================
	function getLastPostings($id)
	{
		global $AVE_DB;
		
		$postings = "";
		if(is_numeric($id))
		{
			$postings = array();
			$result = $AVE_DB->Query("SELECT id FROM " . PREFIX . "_modul_forum_topic WHERE forum_id = '" . $id . "'");
			while ($topic = $result->FetchRow()) $postings[] = $this->getLastPost($topic->id);
		}
		return $postings;
	}

	function getPageNum($repliesCount, $limit)
	{
		//=======================================================
		// Berechnung
		// 1. ermitteln wieviele beitraege bereits im bereich 0 bis $limit liegen.
		// modulo (%) liefert den rest einer division
		// 2. ermitteln wieviele beitraege bis zum naechsten
		// hoechstwert ($limit*n) noch fehlen
		// 3. diesen wert zu den gesamtantworten addieren;
		// danach hat man eine durch $limit teilbare zahl
		// 4. durch die division durch $limit erhaelt man
		// nun die seite auf der der beitrag angezeigt wird -->>
		//=======================================================
		if (($repliesCount % $limit) == 0) return $repliesCount / $limit;
		return ($repliesCount + ($limit - ($repliesCount % $limit))) / $limit;
	}


	// ================================================================
	// setForumIcon setzt das zutreffende icon fuer die foren
	// ================================================================
	function setForumIcon(&$forum)
	{
		global $AVE_DB;
		$SQL_Post48h    = ' Topic.last_post > \'' . date('Y-m-d', strtotime(BOARD_NEWPOSTMAXAGE)) . '\' ';

		$q_topic = "SELECT  COUNT(*) AS NewPostCount

			FROM    " . PREFIX . "_modul_forum_topic AS Topic

				LEFT JOIN " . PREFIX . "_modul_forum_topic_read AS TRead
					ON  Topic.id = TRead.Topic
					AND TRead.Usr = " . UID . "

			WHERE   forum_id = " . $forum['id'] . "
				AND (   TRead.ReadOn < Topic.last_post
					OR  TRead.ReadOn IS NULL )
				AND " . $SQL_Post48h . "
		";

		$r_topic = $AVE_DB->Query($q_topic);

		$topic = $r_topic->FetchRow();
		$NewPostCount = $topic->NewPostCount;

		$icon = "forum";

		$icon .= ($NewPostCount > 0) ? "_new" : "_old";
		$icon .= ($forum['status'] == FORUM_STATUS_CLOSED) ? "_lock" : "";
		$icon .= ".gif";

		$forum['statusicon'] = $this->getIcon($icon, "forum");
	}

	//=======================================================
	// setTopicIcon setzt das zutreffende icon fuer jedes thema
	//=======================================================
	function setTopicIcon(&$topic, $forum)
	{
		global $AVE_DB;
		
		$SQL_Post48h    = ' Topic.last_post > \''.date('Y-m-d', strtotime(BOARD_NEWPOSTMAXAGE)).'\' ';

		$HOT_VIEW_COUNT = 250;
		$HOT_REPLY_COUNT = 20;

		// post holen
		$r_post = $AVE_DB->Query("SELECT id FROM " . PREFIX . "_modul_forum_post WHERE topic_id = " . $topic['id'] . " ORDER BY id DESC");
		$post = $r_post->FetchRow();

		/* Counting, how often user has posted in this topic */
		$q_uid = "SELECT  COUNT(*) PostedInThread
			FROM    " . PREFIX . "_modul_forum_post
			WHERE   topic_id = " . $topic['id'] . "
				AND uid = " . UID . "
		";
		$r_uid = $AVE_DB->Query($q_uid);
		$uid = $r_uid->FetchRow();

		/* New Posts in Topic */
		$sql = "SELECT  COUNT(*) AS NewPostCount

			FROM    " . PREFIX . "_modul_forum_topic AS Topic

				LEFT JOIN " . PREFIX . "_modul_forum_topic_read AS TRead
					ON  Topic.id = TRead.Topic
					AND TRead.Usr = ".UID."

			WHERE   Topic.id=".$topic['id']."
				AND (   TRead.ReadOn < Topic.last_post
					OR  TRead.ReadOn IS NULL )
				AND ".$SQL_Post48h."
		";
		$res = $AVE_DB->Query($sql);
		$NewPost = $res->FetchRow();

		// neu oder nicht
		$new = false;
		$file = "thread";
		if ($uid->PostedInThread > 0) $file .= "_dot";
		if (@$topic['replies'] > $HOT_REPLY_COUNT || $topic['views'] > $HOT_VIEW_COUNT) $file .= "_hot";
		if (@$topic['status'] == FORUM_STATUS_CLOSED || $forum->status == FORUM_STATUS_CLOSED) $file .= "_lock";

		if ($NewPost->NewPostCount > 0)
		{
			$file .= "_new";
			$new = true;
		}

		$file .= ".gif";

		switch ($topic['type'])
		{
			case TOPIC_TYPE_ANNOUNCE:
				if ($new)
				{
					$topic['statusicon'] = $this->getIcon("announcement_new.gif", "announcement");
				} else {
					$topic['statusicon'] = $this->getIcon("announcement_old.gif", "announcement");
				}
			break;
		case TOPIC_TYPE_STICKY:
		default:
			$topic['statusicon'] = $this->getIcon($file, $file);
		}
	}

	function getStatusIcon($params)
	{
		global $set;
		extract($params);

		if ($icon == "") return "";

		$imageName = $set["statusiconlist"][$icon] . ".gif";
		return "<img src=\"templates/".THEME_FOLDER."/modules/forums/statusicons/$imageName\" alt=\"$imageName\" />";
	}

	function getIcon($file, $alt)
	{
		return "<img src=\"templates/".THEME_FOLDER."/modules/forums/statusicons/$file\" alt=\"$alt\" />";
	}

	//=======================================================
	// setzt den status des forums auf $status
	// auch die subforen werden beachtet
	//=======================================================
	function switchForumStatus($id, $status)
	{
		global $AVE_DB;
		
		$r_close = $AVE_DB->Query("UPDATE " . PREFIX . "_modul_forum_forum SET status = " . $status . " WHERE id = '" . $id . "'");
		$q_child = "SELECT f.id FROM
			" . PREFIX . "_modul_forum_category AS c,
			" . PREFIX . "_modul_forum_forum AS f
			WHERE parent_id = '" . $id . "' AND f.category_id = c.id";

		$r_child = $AVE_DB->Query($q_child);

		if ($r_child->NumRows() == 0) return;

		while ($child = $r_child->FetchRow()) {
			$this->switchForumStatus($child->id, $status);
		}
		return;
	}

	function isreaded($id)
	{
		global $AVE_DB;
		
		$sql = $AVE_DB->Query("SELECT * FROM " . PREFIX . "_modul_forum_pn WHERE pnid = '" . $id . "'");
		$rows = $sql->FetchRow();

		if ($rows->is_readed == "yes")
			$im = "readed";
		else
			$im = "unreaded";

		if ($rows->reply == "yes") $im = "reply";
		if ($rows->forward == "yes") $im = "forward";

		$icon = '<img aling="" hspace="1" src="templates/' . THEME_FOLDER . '/modules/forums/pn/'.$im.'.gif" border="0" alt="" />';
		return $icon;
	}
	//=======================================================
	// Allgemeine Forum - Rechte nach Gruppen
	//=======================================================
	function fperm($perm, $group = '')
	{
		global $AVE_DB;
		
		static $permissions = null;

		if ($permissions === null)
		{
			$permissions = array();

			$sql = $AVE_DB->Query("
				SELECT
					user_group,
					permission
				FROM " . PREFIX . "_modul_forum_group_permissions
			");
			while ($row = $sql->FetchRow())
			{
				$permissions[$row->user_group] = @explode("|", $row->permission);
			}
		}

		if (empty($group)) $group = UGROUP;
		if (@in_array($perm, $permissions[$group]) || UGROUP == 1) // Admin darf alles!
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
		$verzname = BASE_DIR . '/' . UPLOAD_AVATAR_DIR . '/system';
		$dht = opendir( $verzname );
		$sel_theme = "";
		$i = 0;
		while ( gettype( $theme = readdir ( $dht )) != @boolean )
		{
			if ( is_file( "$verzname/$theme" ))
			{
				if ($theme != "." && $theme != ".." && $theme != 'index.php')
				{
					$pres = ($selected=="system/$theme") ? "checked" : "";
					$sel_theme .= "
					<div style='float:left; text-align:center; padding:1px'><img src=\"" . UPLOAD_AVATAR_DIR . "/system/" . $theme . "\" alt=\"\" /><br />
					<input name=\"sys_avatar\" type=\"radio\" value=\"$theme\" $pres></div>";
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
		global $AVE_DB;
		
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
		} 
		else 
		{
			// wenn seine gruppe die rechte besitzt, eigene avatar zu nutzen
			if ($this->fperm('own_avatar'))
			{
				$permown = 1;
			}
		}
		if ($permown != 1)
		{
			$own = 0;
		}//print_r("GROUP - " . $group . "<br />AVATAR - " . $avatar . "<br />USEDEF - " . $usedefault . "<br />OWN - " . $own . "<br />PERMOWN - " . $permown);	
		// wenn eigenes avatar beutzt werden darf und es existiert
		if ($own == 1 && $usedefault != 1)
		{
			$avatar_file = BASE_DIR . '/' . UPLOAD_AVATAR_DIR . '/' . $avatar;
			if (@is_file($avatar_file))
			{
				$fz = @getimagesize($avatar_file);
				if($fz[0] <= MAX_AVATAR_WIDTH && $fz[1] <= MAX_AVATAR_HEIGHT || $group==1)
				{
					$avatar = "<img src=\"" . UPLOAD_AVATAR_DIR . "/" . $avatar . "\" alt=\"\" border=\"\" />";
					$aprint = true;
				}
			}
		} 
		else 
		{
			$sql = $AVE_DB->Query("SELECT * FROM " . PREFIX . "_modul_forum_group_avatar WHERE user_group = '" . $group . "'");
			$row = $sql->FetchRow();
			if (is_object($row) && ($row->set_default_avatar == 1) && ($row->default_avatar != ""))
			{
				$avatar = "<img src=\""  . UPLOAD_AVATAR_DIR . "/default/" . $row->default_avatar . "\" alt=\"\" border=\"\" />";
				$aprint = true;
			}
		}
		if ($avatar == '') $avatar = '';
		if ($aprint == true) return $avatar;
	}

	function checkIfUserName($new='',$old='')
	{
		global $AVE_DB;
		
		$sql = $AVE_DB->Query("SELECT
			uname
		FROM
			" . PREFIX . "_modul_forum_userprofile
		WHERE
			uname  = '" . $new . "' AND
			uname != '" . $old . "'
			");

		$rc = $sql->NumRows();
		if($rc==1) return true;
		return false;
	}

	function checkIfUserEmail($new='',$old='')
	{
		global $AVE_DB;
		
		$sql = $AVE_DB->Query("SELECT
			email
		FROM
			" . PREFIX . "_modul_forum_userprofile
		WHERE
			email = '" . $new . "' AND
			email != '" . $old . "'
			");

		$rc = $sql->NumRows();
		if($rc==1) return true;
		return false;
	}

	function getForumUserEmail($id)
	{
		global $AVE_DB;
		
		$sql = $AVE_DB->Query("SELECT uid, email FROM " . PREFIX . "_modul_forum_userprofile WHERE uid = '" . $id . "'");
		$ru = $sql->FetchRow();
		return $ru->email;
	}

	//=======================================================
	// Benutzername anhand ID abfagen
	//=======================================================
	function fetchusername($param)
	{
		global $AVE_DB, $mod;
	
		static $names = array();

		$user_id = @is_array($param) ? $param[userid] : $param;

		if (!isset($names[$user_id]))
		{
			$names[$user_id] = $AVE_DB->Query("
				SELECT uname
				FROM " . PREFIX . "_modul_forum_userprofile
				WHERE uid = '" . $user_id . "'
			")->GetCell();
		}

		return ($names[$user_id] ? $names[$user_id] : $mod['config_vars']['FORUMS_GUEST']);
	}

	//=======================================================
	// Moderatoren eines Forums ermitteln
	//=======================================================
	function get_mods($fid)
	{
		global $AVE_DB;
		
		if ($fid)
		{
			$mods = array();
			$sql = $AVE_DB->Query("
				SELECT user_id
				FROM " . PREFIX . "_modul_forum_mods
				WHERE forum_id = '" . $fid . "'
			");
			while ($row = $sql->FetchRow())
			{
				$mods[] = "<a class=\"forum_links_small\" href=\"index.php?module=forums&amp;show=userprofile&amp;user_id=" . $row->user_id . "\">" . $this->fetchusername($row->user_id) . "</a>";
			}
			return @implode(", ", $mods);
		}
	}

	//=======================================================
	// Text hervorheben
	//=======================================================
	function high($text)
	{
		if (!empty($_GET['high']))
		{
			$treffer = '/(>[^<]*)(' . preg_quote($_GET['high']) . ')/i';
			$ersatz = '\\1<span class="highlight">\\2</span>';
			$text = preg_replace($treffer, $ersatz , $text);
		}
		return $text;
	}

	function datumtomytime($datum)
	{
		$datum_pre = @explode(' ', $datum);
		$datum_1 = $datum_pre[0];
		$datum_2 = $datum_pre[1];
		$dp2 = @explode('-', $datum_1);
		$dp3 = @explode(':', $datum_2);
		$datum_new = @mktime($dp3[0], $dp3[1], $dp3[2], $dp2[1], $dp2[2], $dp2[0]);
		$datum_new_f = $datum_new;
		return $datum_new_f;
	}

	// ====================================================================
	// <<-- HOEHE DER CODEBOXEN ERMITTELN -->>
	// ====================================================================
	function divheight($text)
	{
		static $maxlines;

//		$sql = $AVE_DB->Query("SELECT maxlines FROM " . PREFIX . "_modul_forum_settings");
//		$row = $sql->FetchRow();

		if (!isset($maxlines)){
			$maxlines = $this->forumSettings('max_lines');
		}

		$lines = max(mb_substr_count($text, "\n"), mb_substr_count($text, "<br />"));
		if ($lines > $maxlines AND $maxlines > 0){
			$lines = $maxlines;
		}
		else if ($lines < 1){
			$lines = 1;
		}
		return ($lines) * 15 + 18;
	}

	// ====================================================================
	// <<-- BB- CODES VORBEREITEN -->>
	// ====================================================================
	function pre_kcodes($text)
	{
		global $set, $pref, $boxtype;
		if(IMGCODE==1) { };

		$divheight = $this->divheight($text);
//		$sql = $AVE_DB->Query("SELECT boxwidthcomm,boxwidthforums,maxlengthword FROM " . PREFIX . "_modul_forum_settings");
//		$row = $sql->FetchRow();
		$bwidth = ("pagecomments") ? $this->forumSettings('box_width_comm') : $this->forumSettings('box_width_forums');

		$head = '<div style="MARGIN: 5px 0px 0px">%%boxtitle%%</div><div class="divcode" style="margin:0px; padding:5px; border:1px inset; width:'.$bwidth.'px; height:'.$divheight.'px; overflow:auto"><code style="white-space:nowrap">';
		$foot = '</code></div>';

		$head_quote = '<div style="MARGIN: 5px 0px 0px">%%boxtitle%%</div><div class="divcode" style="margin:0px; padding:5px; border:1px inset; width:95%;"><span style="font-style:italic;">';
		$foot_quote = '</span></div>';

		$pstring = time() . mt_rand(0,10000000);
		@preg_match_all ('/\[php\](.*?)\[\/php\]/si', $text, $erg);
		for($i=0;$i<count($erg[1]);$i++) {
			$text = str_replace($erg[1][$i], $pstring.$i.$pstring, $text);
		}

		$text = htmlspecialchars($text);
		$lines = explode("\n", $text);
		$c_mlength = $this->forumSettings('max_length_word');
		for($n=0;$n<count($lines);$n++) {
			$words = explode(" ",$lines[$n]);
			$pstringount_w = count($words)-1;
			if($pstringount_w >= 0) {
				for($i=0;$i<=$pstringount_w;$i++) {
					$max_length_word = $c_mlength;
					$tword = trim($words[$i]);
					$tword = preg_replace("/\[(.*?)\]/si", "", $tword);
					$displaybox = mb_substr_count($tword, "http://") + mb_substr_count($tword, "https://") + mb_substr_count($tword, "www.") + mb_substr_count($tword, "ftp://");
					if($displaybox > 0) {
						$max_length_word = 200;
					}
					if(mb_strlen($tword)>$max_length_word) {
						$words[$i] = chunk_split($words[$i], $max_length_word, "<br>");
						$length = mb_strlen($words[$i])-5;
						$words[$i] = mb_substr($words[$i],0,$length);
					}
				}
				$lines[$n] = implode(" ", $words);
			} else {
				$lines[$n] = chunk_split($lines[$n], $max_length_word, "<br>");
			}
		}
		$text = implode("\n", $lines);
		$text = nl2br($text);
//		if (UGROUP==2) $text = preg_replace("!\[(?i)url(=(.*?))*\](.*?)\[/(?i)url\]+!s", styleHiddenText(), $text);
		$text = preg_replace("#\[color=(\#?[\da-fA-F]{6}|[a-z\ \-]{3,})\](.*?)\[/color\]+#i","<span style=\"color:\\1\">\\2</span>",$text);
		$text = preg_replace("#\[size=()?(.*?)\](.*?)\[/size\]#si", "<font size=\"\\2\">\\3</font>", $text);
		$text = preg_replace("#\[face=()?(.*?)\](.*?)\[/face\]#si", "<span style=\"font-family:\\2\">\\3</span>", $text);
		$text = preg_replace("#\[font=()?(.*?)\](.*?)\[/font\]#si", "<span style=\"font-family:\\2\">\\3</span>", $text);
		$text = preg_replace("!\[(?i)b\]!", "<b>", $text);
		$text = preg_replace("!\[/(?i)b\]!", "</b>", $text);
		$text = preg_replace("!\[(?i)u\]!", "<u>", $text);
		$text = preg_replace("!\[/(?i)u\]!", "</u>", $text);
		$text = preg_replace("!\[(?i)i\]!", "<i>", $text);
		$text = preg_replace("!\[/(?i)i\]!", "</i>", $text);
		$text = preg_replace("!\[(?i)url\](http://|ftp://)(.*?)\[/(?i)url\]+!", "<a href=\"\\1\\2\" target=\"_blank\">\\1\\2</a>", $text);
		$text = preg_replace("!\[(?i)url\](.*?)\[/(?i)url\]+!", "<a href=\"http://\\1\" target=\"_blank\">\\1</a>", $text);
		$text = preg_replace("#\[url=(http://)?(.*?)\](.*?)\[/url\]#si", "<A HREF=\"http://\\2\" TARGET=\"_blank\">\\3</A>", $text);
		$text = preg_replace("!\[(?i)email\]([a-zA-Z0-9-._]+@[a-zA-Z0-9-.]+)\[/(?i)email\]!", "<a href=\"mailto:\\1\">\\1</a>", $text);
		$text = preg_replace("#\[email=()?(.*?)\](.*?)\[/email\]#si", "<A HREF=\"mailto:\\2\">\\3</A>", $text);
		$text = preg_replace("!\[(?i)img\]([_-a-zA-Z0-9:/\?\[\]=.@-]+)\[(?i)/img\]!", "<img src=\"\\1\" border=\"0\" alt=\"\" />", $text);
		$text = preg_replace("!\[(?i)IMG\]([_-a-zA-Z0-9:/\?\[\]=.@-]+)\[(?i)/IMG\]!", "<img src=\"\\1\" border=\"0\" alt=\"\" />", $text);
		$text = preg_replace("/\[code\](.*?)\[\/code\]/si",str_replace("%%boxtitle%%", 'Код', $head).'\\1'.$foot, $text);
		$text = preg_replace("!\[(?i)quote\]!", str_replace("%%boxtitle%%", 'Цитата', $head_quote), $text);
		$text = preg_replace("!\[/(?i)quote\]!", $foot_quote, $text);
		$text = preg_replace("/\[list\](.*?)\[\/list\]/si","<ul>\\1</ul>", $text);
		$text = preg_replace("/\[list=(.*?)\](.*?)\[\/list\]/si","<ol type=\"\\1\">\\2</ol>", $text);
		$text = preg_replace("/\[\*\](.*?)\\n/si","<li>\\1</li>", $text);

		for($i=0;$i<count($erg[1]);$i++) {
			ob_start();
			@highlight_string(trim($erg[1][$i]));
			$highlight_string = ob_get_contents();
			ob_end_clean();

			$divheight = $this->divheight($highlight_string);
			$head = '<div style="MARGIN: 5px 0px 0px">%%boxtitle%%</div><div class="divcode" style="margin:0px; padding:5px; border:1px inset; width:' . $bwidth . 'px; height:' . $divheight . 'px; overflow:auto"><code style="white-space:nowrap">';

			$displaybox = str_replace("%%boxtitle%%", "PHP", $head) . $highlight_string . $foot;
			$text = preg_replace("/\[php\]" . $pstring . $i . $pstring . "\[\/php\]/i", $displaybox, $text);
		}
		return $text;
	}

	// ====================================================================
	// <<-- URLS AUTOMATISCH UMWANDELN -->>
	// ====================================================================
	function parseurl($text)
	{
		$urlsearch[]="/([^]_a-z0-9-=\"'\/])((https?|ftp):\/\/|www\.)([^ \r\n\(\)\*\^\$!`\"'\|\[\]\{\};<>]*)/si";
		$urlsearch[]="/^((https?|ftp):\/\/|www\.)([^ \r\n\(\)\*\^\$!`\"'\|\[\]\{\};<>]*)/si";
		$urlreplace[]="\\1[URL]\\2\\4[/URL]";
		$urlreplace[]="[URL]\\1\\3[/URL]";
		$emailsearch[]="/([\s])([_a-zA-Z0-9-]+(\.[_a-zA-Z0-9-]+)*@[a-zA-Z0-9-]+(\.[a-zA-Z0-9-]+)*(\.[a-zA-Z]{2,}))/si";
		$emailsearch[]="/^([_a-zA-Z0-9-]+(\.[_a-zA-Z0-9-]+)*@[a-zA-Z0-9-]+(\.[a-zA-Z0-9-]+)*(\.[a-zA-Z]{2,}))/si";
		$emailreplace[]="\\1[EMAIL]\\2[/EMAIL]";
		$emailreplace[]="[EMAIL]\\0[/EMAIL]";
		$text = preg_replace($urlsearch, $urlreplace,$text);
		if (strpos($text, "@")) $text = preg_replace($emailsearch, $emailreplace, $text);
		return $text;

	}

	// ====================================================================
	// <<-- BB- CODES SEITE -->>
	// ====================================================================
	function kcodes($text)
	{
		if (BBCODESITE==1){
			$text = $this->pre_kcodes($text);
		} else {
			$text = nl2br(kspecialchars($text));
		}
		return $text;
	}

	function msg($msg='', $goto='', $tpl='')
	{
		global $AVE_Template, $mod;
	
		$goto = ($goto=='') ? 'index.php?module=forums' : $goto;
		$msg = str_replace('%%GoTo%%', $goto, $msg);
		$AVE_Template->assign("theme_folder", THEME_FOLDER);
		$AVE_Template->assign("GoTo", $goto);
		$AVE_Template->assign("content", $msg);
		$tpl_out = $AVE_Template->fetch($mod['tpl_dir'] . 'redirect.tpl');
		define("MODULE_CONTENT", $tpl_out);
		define("MODULE_SITE", $mod['config_vars']['FORUMS_NEW_THREAD']);
		echo $tpl_out;
		exit;
	}

	function fetchuserid($name)
	{
		global $AVE_DB;
		
		$sql = $AVE_DB->Query("SELECT uid, uname FROM " . PREFIX . "_modul_forum_userprofile WHERE uname = '" . $name . "'");
		$row = $sql->FetchRow();
		$uid = $row->uid;
		$sql->Close();
		return $uid;
	}

	function ForumStats()
	{
		global $AVE_DB, $AVE_Template, $mod;
		
		$num_threads = $AVE_DB->Query("
			SELECT COUNT(*)
			FROM " . PREFIX . "_modul_forum_topic
		")->GetCell();

		$num_posts = $AVE_DB->Query("
			SELECT COUNT(*)
			FROM " . PREFIX . "_modul_forum_post
		")->GetCell();

		$num_members = $AVE_DB->Query("
			SELECT COUNT(*)
			FROM " . PREFIX . "_users
			WHERE status = '1'
			AND user_group != '2'
		")->GetCell();

		$row_newest_member = $AVE_DB->Query("
			SELECT
				u.Id as UserId,
				m.uname as user_name
			FROM
				" . PREFIX . "_users as u,
				" . PREFIX . "_modul_forum_userprofile as m
			WHERE
				u.status = '1' AND
				u.user_group != '2' AND
				m.uid = u.Id
			ORDER BY
				u.Id DESC LIMIT 1
		")->FetchRow();

		$row_lastpost = $AVE_DB->Query("
			SELECT forum_id
			FROM " . PREFIX . "_modul_forum_topic
			ORDER BY last_post DESC
			LIMIT 1
		")->FetchRow();

		$num_guests = $AVE_DB->Query("
			SELECT DISTINCT ip
			FROM " . PREFIX . "_modul_forum_useronline
			WHERE uname = 'UNAME'
		")->NumRows();

		$sql_user = $AVE_DB->Query("
			SELECT
				DISTINCT u.ip,
				u.uname,
				u.uid,
				ug.user_group,
				up.uid,
				up.show_profile
			FROM
				" . PREFIX . "_modul_forum_useronline as u,
				" . PREFIX . "_users as ug,
				" . PREFIX . "_modul_forum_userprofile as up
			WHERE
				u.uname != 'UNAME' AND
				u.invisible != 'INVISIBLE' AND
				ug.id = u.uid AND
				up.uid = u.uid
		");
		
		$num_user = $sql_user->NumRows();
		$loggeduser = array();
		while ($row_user = $sql_user->FetchRow())
		{
			array_push($loggeduser, $row_user);
		}

		$num_gosts = $AVE_DB->Query("
			SELECT DISTINCT uname
			FROM " . PREFIX . "_modul_forum_useronline
			WHERE invisible = 'INVISIBLE'
			AND uname != 'UNAME'
		")->NumRows();

		$AVE_Template->assign('loggeduser', $loggeduser);
		$AVE_Template->assign('num_guests', $num_guests);
		$AVE_Template->assign('num_user', $num_user);
		$AVE_Template->assign('num_gosts', $num_gosts);
		$AVE_Template->assign('LastPost', @$this->getLastForumPost($row_lastpost->forum_id));
		$AVE_Template->assign('row_user', $row_newest_member);
		$AVE_Template->assign('num_members', $this->num_format($num_members));
		$AVE_Template->assign('num_posts', $this->num_format($num_posts));
		$AVE_Template->assign('num_threads', $this->num_format($num_threads));
		$AVE_Template->assign('forum_images', 'templates/' . THEME_FOLDER . '/modules/forums/');
		return  $AVE_Template->fetch($mod['tpl_dir'] . 'stats_forums.tpl');
	}

	// ================================================================
	// downloadfunktion fьr pn
	// ================================================================
	function downloadfile($datstring, $datname, $dattype, $extra = "0")
	{
		$filetype = 'application/octet-stream';
		header('Content-Type: ' . $dattype);
		header('Expires: ' . gmdate('D, d M Y H:i:s') . ' GMT');
		header('Content-Disposition: attachment; filename="' . $datname . '"');
		if ($extra != 1) header('Content-Length: ' . mb_strlen($datstring));
		header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
		header('Pragma: public');
		echo $datstring;
		exit;
	}

	function isIgnored($uid)
	{
		global $AVE_DB;
		
		$sql = $AVE_DB->Query("SELECT uid, ignore_id FROM " . PREFIX . "_modul_forum_ignorelist WHERE ignore_id = '" . $uid . "' AND uid = '" . UID . "' LIMIT 1" );
		$num = $sql->NumRows();

		if($num == 1) return true;
		return false;
	}

	function pnUnreaded()
	{
		global $AVE_DB;
		
		if(isset($_SESSION['user_id']))
		{
			$sql = $AVE_DB->Query("SELECT pnid FROM " . PREFIX . "_modul_forum_pn WHERE to_uid = '" . $_SESSION['user_id'] . "' AND  is_readed != 'yes' AND typ='inbox'" );
			return $sql->NumRows();
		}
	}

	function pnReaded()
	{
		global $AVE_DB;
		
		if(isset($_SESSION['user_id']))
		{
			$sql = $AVE_DB->Query("SELECT pnid FROM " . PREFIX . "_modul_forum_pn WHERE to_uid = '" . $_SESSION['user_id'] . "' AND  is_readed = 'yes' AND typ='inbox'" );
			return $sql->NumRows();
		}
	}

	function popSearch()
	{
		global $AVE_Template, $mod;
		
		$tpl_out = $AVE_Template->fetch($mod['tpl_dir'] . 'search.tpl');
		return addslashes($tpl_out);
	}

	//=======================================================
	// Daten aus Koobi ьbertragen
	//=======================================================
/*	function importfromkoobi()
	{
		define("IMPORT", 1);
		include_once(BASE_DIR . "/modules/forums/internals/importfromkoobi.php");
	}
*/
	//=======================================================
	// Automatisches Update wenn fьr Gruppe keine Rechte bestehen
	//=======================================================
	function AutoUpdatePerms()
	{
		global $AVE_DB;
		
		// Wenn eine Gruppe in Gruppenberechtigung noch nicht angelegt wurde, anlegen!
		$sql = $AVE_DB->Query("
			SELECT ug.user_group
			FROM " . PREFIX . "_user_groups AS ug
			LEFT JOIN " . PREFIX . "_modul_forum_group_permissions
				USING(user_group)
			WHERE id IS NULL
		");
		while($row = $sql->FetchRow())
		{
			$AVE_DB->Query("
				INSERT INTO
					" . PREFIX . "_modul_forum_group_permissions
				SET
					id = '',
					user_group        = '" . $row->user_group . "',
					permission        = '" . $this->_default_permission . "',
					max_avatar_bytes  = '10240',
					max_avatar_height = '90',
					max_avatar_width  = '90',
					upload_avatar     = '1',
					max_pn            = '50',
					max_lenght_pn     = '5000',
					max_lenght_post   = '10000',
					max_attachments   = '5',
					max_edit_period   = '672'
			");
		}
	}

	function forumSettings($field = '')
	{
		global $AVE_DB;
	    static $settings = null;

		if ($settings === null)
		{
			$settings = $AVE_DB->Query("
				SELECT *
				FROM " . PREFIX . "_modul_forum_settings
			")->FetchAssocArray();
		}

		if ($field == '') return $settings;
		return isset($settings[$field]) ? $settings[$field] : null;
	}

	function GroupIdMiscGet($user_id = 0)
	{
		global $AVE_DB;

		static $group_id_miscs = array();

//		$user_id = (is_numeric($user_id) && $user_id > 0) ? $user_id : UID;
		if (!isset($group_id_miscs[$user_id]))
		{
			$group_id_miscs[$user_id] = $AVE_DB->Query("
				SELECT uid, group_id_misc
				FROM " . PREFIX."_modul_forum_userprofile
				WHERE uid = '" . $user_id . "'
			")->GetCell();
		}

		return $group_id_miscs[$user_id];
	}
}

//=======================================================
// Ende der Klasse
// Start - Sonstige Funktionen
//=======================================================
function cpEncode($param)
{
	return base64_encode($param['val']);
}

function cpDecode($param)
{
	return base64_decode($param['val']);
}

function is_mod($fid)
{
	global $AVE_DB;

	static $user_is_mods = array();

	if (!isset($user_is_mods[$fid]))
	{
		$mods = array();
		$sql = $AVE_DB->Query("
			SELECT user_id
			FROM " . PREFIX . "_modul_forum_mods
			WHERE forum_id = '" . $fid . "'
		");
		while ($row = $sql->FetchRow()) $mods[] = $row->user_id;
		$user_is_mods[$fid] = (@in_array(UID, $mods) || UGROUP == 1) ? 1 : 0;
	}

	return !empty($user_is_mods[$fid]);
}

function getPostIcon($params)
{
	global $AVE_DB;
	
	static $icons = array();

	extract($params);

	if ($icon < 1) return '';

	if (!isset($icons[$icon]))
	{
		$path = $AVE_DB->Query("
			SELECT path
			FROM " . PREFIX . "_modul_forum_posticons
			WHERE active = '1'
			AND id = '" . $icon . "'
		")->GetCell();
		$icons[$icon] = ($path === false) ? '' : ("<img src=\"templates/" . (($theme=='') ? THEME_FOLDER : $theme) . "/modules/forums/posticons/" . $path . "\" alt=\"" . $icon . "\" />");
	}

	return $icons[$icon];
}

?>