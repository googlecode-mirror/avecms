<?php

/**
 * 
 *
 * @package AVE.cms
 * @subpackage module_Forums
 * @filesource
 */
if (!defined("PN")) exit;

global $AVE_DB, $AVE_Template, $mod;

$MAXPN = MAXPN;
$boxtype = "pagecomments";
$ok = 1;
$pnin = 1;

$limit = (isset($_REQUEST['pp']) && is_numeric($_REQUEST['pp']) && $_REQUEST['pp']>0) ? $_REQUEST['pp'] : 50;

if ((!$this->fperm("canpn")) || (UGROUP==2))
{
	$this->msg($mod['config_vars']['FORUMS_ERROR_NO_PERM']);
}
else
{
	//=======================================================
	// PN LЦSCHEN
	//=======================================================
	if (isset($_REQUEST['del']) && $_REQUEST['del']!="")
	{
		$where_id = (isset($_REQUEST['goto']) && $_REQUEST['goto']=='inbox') ? " AND to_uid='" . UID . "'" : " AND from_uid='" . UID . "'";
		reset ($_POST);
		while (list($key, $val) = each($_POST))
		{
			if (substr($key,0,3)=="pn_")
			{
				$aktid = str_replace("pn_","",$key);
				$sql = $AVE_DB->Query("DELETE FROM ".PREFIX."_modul_forum_pn WHERE pnid='". $aktid. "' $where_id");
			}
		}
		header("Location:index.php?module=forums&show=pn&goto=" . $_REQUEST['goto']);
	}

	if (!@isset($_REQUEST['action']) && @$_REQUEST['action']=="")
	{

		$goto = (isset($_REQUEST['goto']) && $_REQUEST['goto']=="outbox") ? "outbox" : "inbox";
		$tofrom = $goto=="inbox" ? "to_uid" : "from_uid";

		$send_recieve_text = $goto=="inbox" ? $mod['config_vars']['FORUMS_PN_IS_RECEIVED'] : $mod['config_vars']['FORUMS_PN_IS_SEND'];
		$text_fromto = $goto=="inbox" ? $mod['config_vars']['FORUMS_PN_SENDER'] : $mod['config_vars']['FORUMS_PN_RECIEVER'];

		//=======================================================
		// Aufsteigende & Absteigende Sortierung
		//=======================================================
		$sort = (isset($_REQUEST['sort']) && ($_REQUEST['sort'] == 'ASC' || $_REQUEST['sort'] == 'DESC')) ? $_REQUEST['sort'] : 'DESC';

		//=======================================================
		// Sortierung nach Betreff, Autor, Gelesen und Ungelesen
		//=======================================================
		if (!@isset($_REQUEST['porder']) && @$_REQUEST['porder']==""){
			$porder = "pntime";
		}
		else
		{
			$porder = $_REQUEST['porder'];
			if (($porder != "pntime") && ($porder != "topic") && ($porder != "uid") && ($porder != "readed") && ($porder != "notreaded")) $porder = "pntime";
		}

		if (($goto=="inbox") && ($porder=="uid"))
		{
			$porder = "from_uid";
			$inbox_uid = " selected";
		}
		if (($goto=="outbox") && ($porder=="uid"))
		{
			$porder = "to_uid";
			$outbox_uid = " selected";
		}

		if ($porder=="pntime")
		{
			$porder = "pntime";
			$pntime_sel = " selected";
		}

		if ($porder=="topic")
		{
			$porder = "topic";
			$topic_sel = " selected";
		}

		if ($porder=="readed")
		{
			$porder = "is_readed='yes'";
			$readed_sel = " selected";
		}

		if ($porder=="notreaded")
		{
			$porder = "is_readed='no'";
			$notreaded_sel = " selected";
		}

		//=======================================================
		// Sortierungsoptionen dem Template zuweisen...
		//=======================================================
		$sel_topic_read_unread	 = '<option value="pntime" ' . @$pntime_sel . '>'.$mod['config_vars']['FORUMS_PN_BY_DATE'].'</option>';
		$sel_topic_read_unread	.= '<option value="topic" ' . @$topic_sel . '>'.$mod['config_vars']['FORUMS_PN_BY_TOPIC'].'</option>';
		$sel_topic_read_unread	.= '<option value="uid" ' . @$outbox_uid . @$inbox_uid . '>'.$mod['config_vars']['FORUMS_PN_BY_AUTHOR'].'</option>';
		$sel_topic_read_unread	.= '<option value="readed" ' . @$readed_sel . ' >'.$mod['config_vars']['FORUMS_PN_BY_READED'].'</option>';
		$sel_topic_read_unread	.= '<option value="notreaded" ' . @$notreaded_sel . '>'.$mod['config_vars']['FORUMS_PN_BY_UN_READED'].'</option>';

		$AVE_Template->assign('sel_topic_read_unread', $sel_topic_read_unread) ;

		$sql = $AVE_DB->Query("SELECT * FROM ".PREFIX."_modul_forum_pn WHERE $tofrom='".UID."' AND typ='".$goto."'  ORDER BY $porder $sort");
		$pnin = $sql->NumRows();

		$seiten = ceil($pnin / $limit);
		$a = get_current_page() * $limit - $limit;

		$sql = $AVE_DB->Query("SELECT * FROM ".PREFIX."_modul_forum_pn WHERE $tofrom='".UID."' AND typ='".$goto."'  ORDER BY $porder $sort limit  $a,$limit");

		$LISTPN = -1;
		if (!isset($_COOKIE['listpn']))
		{
			$LISTPN = 1;
			setcookie("listpn", "katalog", time()+(365*24*3600));
			$switchto = "katalog";
		}

		//=======================================================
		// Normale oder Katalogisierte Ansicht...
		//=======================================================
		if (($_COOKIE['listpn']=="katalog" ) || (!$_COOKIE['listpn']))
		{
			$LISTPN = 1;
			setcookie("listpn", "katalog", time()+(365*24*3600));
		}

		if (isset($_REQUEST['switchto']) && $_REQUEST['switchto']!="")
		{
			if ($_REQUEST['switchto'] == "katalog")
			{
				$LISTPN = 1;
				setcookie("listpn", "katalog", time()+(365*24*3600));
				$switchto = "katalog";
			}
			if (isset($_REQUEST['switchto']) && $_REQUEST['switchto']=="norm")
			{
				$LISTPN = -1;
				setcookie("listpn", "norm", time()+(365*24*3600));
				$switchto = "norm";
			}
		}

		$entry_array = array();
		$table_data = array();
		if ($LISTPN==1)
		{
			while ($row = $sql->FetchRow())
			{
				$sql2 = $AVE_DB->Query("SELECT
					u.uname as uname,
					u.uid as uid
				FROM
					".PREFIX."_modul_forum_userprofile as u
				WHERE
					u.uid='".$row->from_uid."'
					");
				$row2 = $sql2->FetchRow();
				$sql2->Close();

				if ($goto=="inbox")
				{
					$theuserid = $row2->uid;
					$theusername = $row2->uname;
				}
				else
				{
					$sql_emp = $AVE_DB->Query("
						SELECT
							u.uname as uname,
							u.uid as uid
						FROM
							".PREFIX."_modul_forum_userprofile as u
						WHERE
							u.uid='".$row->to_uid."'
					");
					$row_emp = $sql_emp->FetchRow();
					$theuserid = $row->to_uid;
					$theusername = $row_emp->uname;
				}

				$entry_array[] = array(
					'timestamp' => $row->pntime,
					'data'      => array(
					'title'   => stripslashes($row->topic),
					'message' => htmlspecialchars($row->message),
					'pntime'  => $row->pntime,
					'pnday'   => $row->pntime,
					'von'     => $theusername,
					'goto'    => $goto,
					'pnid'    => $row->pnid,
					'icon'    => $this->isreaded($row->pnid),
					'toid'    => "index.php?module=forums&amp;show=userprofile&amp;user_id=".$theuserid,
					'mlink'	  => "index.php?module=forums&amp;show=pn&amp;action=message&amp;pn_id=".$row->pnid."&amp;goto=".$goto
					)
				);
			}

			$last = 0;

			$ts = array();
			$ts[0] = array(
				'anfang' => mktime(0,0,0,date("m"),date("d"),date("Y")),
				'ende'	 => mktime(23,59,59,date("m"),date("d"),date("Y"))
			);

			$last = mktime(0,0,0,date("m"),date("d"),date("Y"));
			$wochentag = date("w") + 1;

			for ($i = 1; $i < $wochentag; $i++)
			{
				$a = $wochentag - $i;
				if (date("d")-$i > 0)
				{
					$last -= 86400;
					$ts[$a] = array(
						'anfang' => $last,
						'ende'	 => $last+86399
					);
				}
			}

			$ts[-2] = array(
				'anfang' => $last-(7 * 86400),
				'ende'   => $last
			);

			$last -= 7 * 86400;

			$ts[-1] = array(
				'anfang' => 0,
				'ende'   => $last
			);

			$wochentage = explode(",",$mod['config_vars']['FORUMS_PN_DAY_NAMES']);
			while (list($key,$val)=each($ts))
			{
				if ($key==0)
				{
					$t = $mod['config_vars']['FORUMS_TODAY'];
					$d = ", " . date("d.m.Y", $val['anfang']);
				}
				elseif ($key==-1)
				{
					$t = $mod['config_vars']['FORUMS_PN_LATER'];
					$d = "";
				}
				elseif ($key==-2)
				{
					$t = $mod['config_vars']['FORUMS_PN_LAST_WEEK'];
					$d = "";
				}
				else
				{
					$t = $wochentage[$key-1];
					$d = ", " . date("d.m.Y", $val['anfang']);
				}

				$mys = 0;

				reset($entry_array);
				while (list($k,$v) = each($entry_array))
				{
					if ($v['timestamp'] > $val['anfang'] && $v['timestamp'] < $val['ende']) $mys++;
				}

				if ($mys > 0)
				{
					$a = 0;
					reset($entry_array);
					while (list($k,$v) = each($entry_array))
					{
						if ($v['timestamp'] > $val['anfang'] && $v['timestamp'] < $val['ende'])
						{
							$a++;
							if ($a==1)
							{
								unset($position,$plusminus,$disp);
								$disp = "";
								$position = @strpos($_COOKIE["pn"], "pn" . $goto.$key);

								if ( is_numeric($position) )
								{
									$disp= "none";
									$plusminus = "plus.gif";
								}
								else
								{
									$plusminus = "minus.gif";
								}
								$toggle = "<img hspace=\"2\" class=\"absmiddle\" border=\"0\" id=\"pn_".$goto.$key."\" src=\"templates/".THEME_FOLDER."/modules/forums/".$plusminus."\" onmouseover=\"this.style.cursor = 'pointer'\" onclick=\"MWJ_changeDisplay('pn".$goto.$key."', MWJ_getStyle( 'pn".$goto.$key."', 'display' ) ? '' : 'none'); cpengine_toggleImage('pn_".$goto.$key."', this.src); cpengine_setCookie('pn', 'pn".$goto.$key."');\" alt=\"\" />";

								$v['data']['tbody_start'] = "<tr><td class=\"toggletr\" colspan=\"4\">".$toggle.$t.$d."</td></tr><tbody id='pn".$goto.$key."' name='pn".$goto.$key."' style=\"display: ".$disp.";\">";
							}

							if ($a==$mys) $v['data']['tbody_end'] = "</tbody>";

							array_push($table_data, $v['data']);
						}
					}
				}
			}
		}
		else
		{
			while ($row = $sql->FetchRow())
			{
				$sql2 = $AVE_DB->Query("
					SELECT
						uname as uname,
						uid as uid
					FROM ".PREFIX."_modul_forum_userprofile
					WHERE uid='".$row->from_uid."'
				");

				$row2 = $sql2->FetchRow();
				$sql2->Close();

				if ($goto=="inbox")
				{
					$theuserid = $row2->uid;
					$theusername = $row2->uname;
				}
				else
				{
					$sql_emp = $AVE_DB->Query("
						SELECT
							uname as uname,
							uid as uid
						FROM ".PREFIX."_modul_forum_userprofile
						WHERE uid='".$row->to_uid."'
					");
					$row_emp = $sql_emp->FetchRow();
					$theuserid = $row->to_uid;
					$theusername = $row_emp->uname;
				}
				array_push(
					$table_data,
					array(
						'timestamp' => $row->pntime,
						'title'     => stripslashes($row->topic),
						'pntime'    => $row->pntime,
						'pnday'     => $row->pntime,
						'von'       => $theusername,
						'pnid'      => $row->pnid,
						'goto'      => $goto,
						'icon'      => $this->isreaded($row->pnid),
						'toid'      => "index.php?module=forums&amp;show=userprofile&amp;user_id=" . $theuserid,
						'mlink'     => "index.php?module=forums&amp;show=pn&amp;action=message&amp;pn_id=" . $row->pnid . "&amp;goto=" . $goto
					)
				);
			}
		}

		//=======================================================
		// Selektion fьr gelesene und ungelesene Nachrichten wieder дndern...
		//=======================================================
		if (isset($_REQUEST['porder']) && $_REQUEST['porder']=="readed")    $porder = "readed";
		if (isset($_REQUEST['porder']) && $_REQUEST['porder']=="notreaded") $porder = "notreaded";
		if (isset($_REQUEST['porder']) && $_REQUEST['porder']=="uid")       $porder = "uid";

		//=======================================================
		// Navigation erzeugen
		//=======================================================
		if ($pnin > $limit)
		{
			$nav = " <a class=\"page_navigation\" href=\"index.php?module=forums&amp;show=pn&amp;goto=" . $goto
				. "&sort=" . $sort . "&porder=" . $porder . "&pp=" . $limit . "&page={s}&switchto="
				. ((empty($switchto)) ? 'katalog' : $switchto) . "\">{t}</a> ";
			$nav = get_pagination($seiten, 'page', $nav);
			$AVE_Template->assign("nav", $nav) ;
		}

		//=======================================================
		// Anzahlwahl + Auf oder Absteigend
		//=======================================================
		$pp_l = "";
		for ($i = 50; $i >= 10; $i-=10)
		{
			unset($thisselect);
			$thisselect = "";
			if (isset($_REQUEST['pp']) && $_REQUEST['pp']==$i) $thisselect = "selected";
			$pp_l .= '<option value="'.$i.'" '.$thisselect.'>'.$i.' '.$mod['config_vars']['FORUMS_PN_EACH_PAGE'].'</option>';
		}
		$AVE_Template->assign('pp_l', $pp_l) ;

		$page = (isset($_REQUEST['page']) && $_REQUEST['page'] != '' && $_REQUEST['page'] > 0 && is_numeric($_REQUEST['page'])) ? $_REQUEST['page'] : 1;

		if (isset($_REQUEST['sort']) && $_REQUEST['sort']=="DESC")
		{ // ABSTEIGEND
			$AVE_Template->assign('sel1', "selected");
			$AVE_Template->assign('sel2', "");
		}
		if (isset($_REQUEST['sort']) && $_REQUEST['sort']=="ASC")
		{ // AUFSTEIGEND
			$AVE_Template->assign('sel2', "selected");
			$AVE_Template->assign('sel1', "");
		}
		$AVE_Template->assign('page', $page);

		//=======================================================
		// Normale Ansicht & Katalogisierte Ansicht
		//=======================================================
		$link_the_normmodus = "index.php?module=forums&amp;show=pn&goto=".$goto."&sort=".$sort."&porder=".$porder."&pp=".$limit."&page=".$page."&switchto=norm";
		$link_the_katmodus = "index.php?module=forums&amp;show=pn&goto=".$goto."&sort=".$sort."&porder=".$porder."&pp=".$limit."&page=".$page."&switchto=katalog";
		$AVE_Template->assign('normmodus_link', $link_the_normmodus) ;
		$AVE_Template->assign('katmodus_link', $link_the_katmodus) ;

		//=======================================================
		// PROZENT EINGANG / AUSGANG
		//=======================================================
		$warningpnfull = "";
		$onepn = 100 / $MAXPN;
		$allpn = $onepn * $pnin;
		$inoutwidth = round($allpn/1.005, 3);
		$inoutpercent = round($allpn, 0);
		if ($pnin==$MAXPN) $warningpnfull = $mod['config_vars']['FORUMS_PN_BOX_MY_FULL'];

		if ($goto=="inbox")
		{
			$AVE_Template->assign('selin', "selected");
			$AVE_Template->assign("view", "inbox");
		}

		if ($goto=="outbox")
		{
			$AVE_Template->assign('selout', "selected");
			$AVE_Template->assign("view", "outbox");
		}
	}

	if (!@isset($_REQUEST['action']) && @$_REQUEST['action']=="")
	{
		$desclink = "index.php?p=pn&goto=".$goto."&sort=DESC&pp=".@$_REQUEST['pp']."&page=".get_current_page();
		$asclink = "index.php?p=pn&goto=".$goto."&sort=ASC&pp=".@$_REQUEST['pp']."&page=".get_current_page();

		$AVE_Template->assign('send_recieve_text', $send_recieve_text);
		$AVE_Template->assign('from_t', $text_fromto);
		$AVE_Template->assign('goto', $goto);
		$AVE_Template->assign('inoutwidth', $inoutwidth);
		$AVE_Template->assign('inoutpercent', $inoutpercent);
		$AVE_Template->assign('pnioutnall', $pnin);
		$AVE_Template->assign('pnmax', str_replace("__MAXPN__", $MAXPN, $mod['config_vars']['FORUMS_PN_TEXT_FILLED']));
		$AVE_Template->assign('warningpnfull', $warningpnfull);
		$AVE_Template->assign('sortdesc', $desclink);
		$AVE_Template->assign('sortasc', $asclink);
		$AVE_Template->assign('pndl_text', "index.php?module=forums&amp;show=pn&amp;goto=".$goto."&amp;download=1&amp;type=text");
		$AVE_Template->assign('pndl_html', "index.php?module=forums&amp;show=pn&amp;goto=".$goto."&amp;download=1&amp;type=html");

		//=======================================================
		// Subtemplate
		//=======================================================
		$AVE_Template->assign('outin', 1);
		$AVE_Template->assign('neu', 0);

		/**
		* Если нет PN...
		*
		*/
		if ($pnin)
		{
			$AVE_Template->assign('table_data', $table_data);
		}
		else
		{
			$AVE_Template->assign('nomessages', 1);
			$AVE_Template->assign('outin', 0);
		}

		//=======================================================
		// PN herunterladen
		//=======================================================
		if (isset($_REQUEST['download']) && $_REQUEST['download']==1)
		{
			$sql = $AVE_DB->Query("SELECT * FROM ".PREFIX."_modul_forum_pn WHERE $tofrom='" . UID . "' AND typ='".$goto."'  ORDER BY pntime ".$sort."");
			$dlmessage = "";
			while ($row = $sql->FetchRow())
			{
				$message = str_replace("\n", "\r\n", str_replace("\r\n", "\n", $row->message));
				$message = stripslashes($message);

				if ($goto=="inbox")
				{
					$pninout = $mod['config_vars']['FORUMS_PN_IN'];
					$fname = $theusername;
					$tname = $_SESSION['forum_user_name'];
				}
				else
				{
					$pninout = $mod['config_vars']['FORUMS_PN_OUT'];
					$fname = $_SESSION['forum_user_name'];
					$tname = $theusername;
				}

				if ($_REQUEST['type']=="text")
				{
					$dlmessage .= "===============================================================================\r\n";
					$dlmessage .= $mod['config_vars']['FORUMS_PN_SENDER'].":\t" . $fname ."\r\n";
					$dlmessage .= $mod['config_vars']['FORUMS_PN_RECIEVER'].":\t" . $tname . "\r\n";
					$dlmessage .= $mod['config_vars']['FORUMS_PN_DATE'].":\t" . date('d-m-Y H:i', $row->pntime) . "\r\n";
					$dlmessage .= $mod['config_vars']['FORUMS_PN_THE_SUBJECT'].":\t" . $row->topic . "\r\n";
					$dlmessage .= "-------------------------------------------------------------------------------\r\n";
					$dlmessage .=  wordwrap( $message, 90, "\r\n", 1) . "\r\n\r\n";
					$end = ".txt";
					$type = "text/plain";
				}
				else
				{
					$dlmessage .= '<style><!-- td,div,th{FONT-SIZE: 11px;FONT-FAMILY:   Verdana, Arial, Helvetica, sans-serif;} --></style>';
					$dlmessage .= '<table width="100%"  border="1" cellpadding="3" cellspacing="0" bordercolor="#333333"><tr><td bgcolor="#F4F4F4">';
					$dlmessage .= "<B>".$mod['config_vars']['FORUMS_PN_SENDER']."</B>:\t" . $fname ."\r<br>";
					$dlmessage .= "<B>".$mod['config_vars']['FORUMS_PN_RECIEVER']."</B>:\t" . $tname . "\r<br>";
					$dlmessage .= "<B>".$mod['config_vars']['FORUMS_PN_DATE']."</B>:\t" . date('d-m-Y H:i', $row->pntime) . "\r<br>";
					$dlmessage .= "<B>".$mod['config_vars']['FORUMS_PN_THE_SUBJECT']."</B>:\t" . $row->topic . "\r<br>";
					$dlmessage .= '</td></tr><tr><td>';
					$dlmessage .=  nl2br(stripslashes(wordwrap(htmlspecialchars($message), 90, "\r\n", 1))) ."";
					$dlmessage .= '</td></tr></table><br>';
					$end = ".htm";
					$type = "text/html";
				}
			}
			$this->downloadfile($dlmessage, $pninout ."__" . date("d-m-Y") . $end, $type);
		}
	}

	//=======================================================
	// NACHRICHT ANSEHEN
	//=======================================================
	if (isset($_REQUEST['action']) && $_REQUEST['action']=="message")
	{
		$goto = $_REQUEST['goto']=="inbox" ? "inbox" : "outbox";
		$tofrom = $goto=="inbox" ? "to_uid" : "from_uid";
		$sql = $AVE_DB->Query("SELECT * FROM ".PREFIX."_modul_forum_pn WHERE pnid='".$_REQUEST['pn_id']."' AND $tofrom='".UID."' AND typ='".$goto."'");
		$num = $sql->NumRows();
		$row = $sql->FetchRow();
		$sql->Close();

		// WENN UNGЬLTIGE ID ODER PN NICHT == USER-ID
		if (!$num) $this->msg($mod['config_vars']['FORUMS_PN_WRONG_ID'], 'index.php?module=forums&show=pn');

		if ($ok==1)
		{
			$pn_id = addslashes($_REQUEST['pn_id']);
			if (isset($_REQUEST['do']) && $_REQUEST['do']=="del")
			{
				$where_id = (isset($_REQUEST['goto']) && $_REQUEST['goto']=='inbox') ? " AND to_uid='" . UID . "'" : " AND from_uid='" . UID . "'";
				$sql = $AVE_DB->Query("DELETE FROM ".PREFIX."_modul_forum_pn WHERE pnid='" . $pn_id . "' $where_id");
				header("Location:index.php?module=forums&show=pn");
				exit;
			}

			if ($goto == "inbox")
			{
				$sql = $AVE_DB->Query("UPDATE " . PREFIX . "_modul_forum_pn SET is_readed='yes' WHERE pnid='" . addslashes($_GET['pn_id']) . "'");
				$sql = $AVE_DB->Query("SELECT pntime,topic FROM ".PREFIX."_modul_forum_pn WHERE pnid='" . addslashes($_GET['pn_id']) . "'");
				$row_subid = $sql->FetchRow();
				$sql = $AVE_DB->Query("UPDATE ".PREFIX."_modul_forum_pn SET is_readed='yes' WHERE pntime='".$row_subid->pntime."' AND topic='".$row_subid->topic."'");
			}

			if (isset($_POST['goto']) && $_POST['goto'] == "inbox")
			{
				$sqlid = $row->from_uid;
				$tfrlink = "index.php?module=forums&amp;show=userprofile&amp;user_id=" . UID;
			}
			elseif (isset($_POST['goto']) && $_POST['goto'] == "outbox")
			{
				$sqlid = $row->to_uid;
				$tfrlink = "index.php?module=forums&amp;show=userprofile&amp;user_id=" . UID;
			}
			else
			{
				$sqlid = $row->from_uid;
			}

			$goto = (!isset($_REQUEST['goto']) && ($_REQUEST['goto']=="")) ? 'inbox' : $_REQUEST['goto'];
			$text_fromto = ($goto=="inbox") ? "Von" : "An";
			$message = $row->message;

			if ($row->smilies=="yes")
			{
				$AVE_Template->assign('message', $this->replaceWithSmileys($this->kcodes($message)));
			}
			else
			{
				$AVE_Template->assign('message', $this->kcodes($message));
			}

			$sql = $AVE_DB->Query("
				SELECT
					uid as uid,
					uname as uname,
					reg_time as user_regdate,
					messages as user_posts
				FROM
					".PREFIX."_modul_forum_userprofile
				WHERE
					uid='".$sqlid."'
			");
			$row_u = $sql->FetchRow();
			$sql->Close();

			$pnlink = "index.php?module=forums&amp;show=pn&action=message&pn_id=". $_GET['pn_id'] ."&goto=".$goto."&do=del";
			$forwardlink = "index.php?module=forums&amp;show=pn&action=new&forward=1&pn_id=". $_GET['pn_id'] ."&subject=".base64_encode($row->topic)."&aut=".base64_encode($row_u->uname)."&date=".base64_encode($row->pntime);
			$relink = "index.php?module=forums&amp;show=pn&action=new&forward=2&pn_id=". $_GET['pn_id'] ."&subject=".base64_encode($row->topic)."&aut=".base64_encode($row_u->uname)."&date=".base64_encode($row->pntime);

			if (isset($_POST['goto']) && $_POST['goto'] == "inbox")
			{
				$tfrlink = "index.php?module=forums&show=userprofile&user_id=".$row_u->uid."";
			}
			else
			{
				$tfrlink = "index.php?module=forums&show=userprofile&user_id=".$row_u->uid."";
			}

			if ($goto=="inbox") $AVE_Template->assign('answerok', 1);

			$AVE_Template->assign('delpn', $pnlink);
			$AVE_Template->assign('forwardlink', $forwardlink);
			$AVE_Template->assign('relink', $relink);
			$AVE_Template->assign('membersince_date', $row_u->user_regdate);
			$AVE_Template->assign('posts_num', $row_u->user_posts);
			$AVE_Template->assign('pntitle', $row->topic);
			$AVE_Template->assign('pntime', $row->pntime);
			$AVE_Template->assign('tofromname', $row_u->uname);
			$AVE_Template->assign('tofromname_link', $tfrlink);
			$AVE_Template->assign('pndate', $row->pntime);
			$AVE_Template->assign('to_t', $text_fromto);
			$AVE_Template->assign('showmessage', 1);
		}
	}

	// NEUE NACHRICHT
	if (isset($_REQUEST['action']) && $_REQUEST['action'] == "new")
	{
		$sql = $AVE_DB->Query("SELECT typ FROM ".PREFIX."_modul_forum_pn WHERE typ='outbox' and from_uid='".UID."'");
		$num = $sql->NumRows();

		if ($num == $MAXPN || $num >= $MAXPN)
		{
			$this->msg($mod['config_vars']['FORUMS_PN_BOX_MY_FULL'], 'index.php?module=forums&show=pn&goto=inbox');
		}

		// Vorschau
		if (isset($_POST['send']) && $_POST['send']=="1")
		{
			$message = $_POST['text'];

			if (isset($_POST['parseurl']) &&  $_POST['parseurl']=="yes")
			{
				$message = $this->parseurl($message);
			}

			if (isset($_POST['use_smilies']) && $_POST['use_smilies'] == "yes")
			{
				$AVE_Template->assign('preview_text', $this->replaceWithSmileys($this->kcodes($message)));
			}
			else
			{
				$AVE_Template->assign('preview_text', $this->kcodes($message));
			}

			$text = "";
			$AVE_Template->assign('tofromname', $_POST['tofromname']);
			$AVE_Template->assign('title', $_POST['title']);
			$AVE_Template->assign('text',htmlspecialchars($_POST['text']));
			$AVE_Template->assign('preview', 1);
		}

		if (isset($_POST['send']) && $_POST['send']=="2")
		{
			$error = "";
			if (empty($_POST['tofromname']))         $pnerror[] = $mod['config_vars']['FORUMS_PN_PLS_ENTER_ID_USER'];
			if (empty($_POST['title']))              $pnerror[] = $mod['config_vars']['FORUMS_PN_PLS_ENTER_HEADING'];
			if (empty($_POST['text']))               $pnerror[] = $mod['config_vars']['FORUMS_PN_PLS_ENTER_MESSAGE'];
			if (strlen($_POST['text']) > MAXPNLENTH) $pnerror[] = $mod['config_vars']['FORUMS_PN_TEXT_TO_LONG'];

			$AVE_Template->assign('tofromname', $_POST['tofromname']);
			$AVE_Template->assign('title', $_POST['title']);
			$AVE_Template->assign('text', $_POST['text']);

			// CHECK OB USER EXISTIERT
			$sql = $AVE_DB->Query("
				SELECT
					u.uname,
					u.uid,
					u.pn_receipt,
					u.email
				FROM
					".PREFIX."_modul_forum_userprofile  as u
				WHERE
					u.uname = '" . addslashes($_POST['tofromname']) . "'
				OR
					u.uid = '" . addslashes($_POST['tofromname']) . "'
			");
			$num = $sql->NumRows();
			$row = $sql->FetchRow();

			if ($row->pn_receipt != 1)      $pnerror[] = $mod['config_vars']['FORUMS_PN_NOT_WANT'];
			if (empty($pnerror) && $num<1) $pnerror[] = $mod['config_vars']['FORUMS_PN_USER_ERROR'];

			// CHECK OB ABSENDER IN IGNORIERLISTE DES EMPFДNGERS STEHT
			$num_ignore = 0;
			if (is_object($row))
			{
				$sql_ignore = $AVE_DB->Query("
					SELECT
						IgnoreId,
						uid
					FROM
						".PREFIX."_modul_forum_ignorelist
					WHERE
						uid='" . addslashes($row->uid) . "' AND
						IgnoreId='".UID."'
				");

				$num_ignore = $sql_ignore->NumRows();
			}
			if (empty($pnerror) && $num_ignore>0) $pnerror[] = $mod['config_vars']['FORUMS_PN_IGNORED_BY_USER'];

			// CHECK OB NACHRICHTENBOX VOLL IST
			if (empty($pnerror))
			{
				$usermaxpn = MAXPN;

				$sql3 = $AVE_DB->Query("SELECT * FROM ".PREFIX."_modul_forum_pn WHERE to_uid='".$row->uid."' AND typ='inbox'");
				$numuserpn = $sql3->NumRows();

				if ($numuserpn >= $usermaxpn) $pnerror[] = $mod['config_vars']['FORUMS_PN_BOX_FULL'];
			}

			// CHECK OB USER PN'S EMPFANGEN MЦCHTE
			if (empty($pnerror))
			{
				if ($row->pn_receipt=="no") $pnerror[] = $mod['config_vars']['FORUMS_PN_NOT_WANT'];
			}

			$text = substr($_POST['text'],0, MAXPNLENTH);
			if ($_POST['parseurl']=="yes") $text = $this->parseurl($text);

			if (empty($pnerror))
			{
				$sql = $AVE_DB->Query("INSERT INTO ".PREFIX."_modul_forum_pn (smilies,pnid,to_uid,from_uid,topic,message,is_readed,pntime,typ) VALUES ('".$_POST['use_smilies']."','','".$row->uid."','".UID."','".$_POST['title']."','".$text."','no','".time()."','inbox')");
				if (isset($_REQUEST['savecopy']) && $_REQUEST['savecopy']=="yes")
				{
					$sql = $AVE_DB->Query("INSERT INTO ".PREFIX."_modul_forum_pn (smilies,pnid,to_uid,from_uid,topic,message,is_readed,pntime,typ) VALUES ('".$_POST['use_smilies']."','','".$row->uid."','".UID."','".$_POST['title']."','".$text."','no','".time()."','outbox')");
				}

				// MAILBENACHRICHTIGUNG
				$body = $mod['config_vars']['FORUMS_PN_BODY'];
				$body = str_replace("__USER__", $row->uname, $body);
				$body = str_replace("__AUTOR__", $_SESSION['forum_user_name'], $body);
				$body = str_replace("__LINK__", HOST . str_replace("/index.php","",$_SERVER['PHP_SELF']) . "/index.php?module=forums&show=pn&goto=inbox", $body);
				$body = str_replace("%%N%%","\n", $body);

				send_mail(
					$row->email,
					stripslashes($body),
					$mod['config_vars']['FORUMS_PN_SUBJECT'],
					FORUMEMAIL,
					FORUMABSENDER,
					"text"
				);

				// Vielen Dank, Ihre Nachricht wurde erfolgreich versendet.
				$this->msg($mod['config_vars']['FORUMS_PN_THANK_YOU'], 'index.php?module=forums&show=pn&goto=outbox');
			}
		}

		if (!empty($pnerror))
		{
			$AVE_Template->assign('iserror', 1);
			$AVE_Template->assign('error', $pnerror);
		}

		$AVE_Template->assign('listfonts',  $this->fontdropdown());
		$AVE_Template->assign('sizedropdown',  $this->sizedropdown());
		$AVE_Template->assign('colordropdown',  $this->colordropdown());
		$AVE_Template->assign('max_post_length', MAXPNLENTH);
		$AVE_Template->assign('listemos', $this->listsmilies());
		$AVE_Template->assign('newpn_t', str_replace("__ZEICHEN__", MAXPNLENTH , $mod['config_vars']['FORUMS_PN_TEXT_NEW_MSG']));
		$AVE_Template->assign('newpn_error', @$pnerror);

		if (isset($_REQUEST['to']) && $_REQUEST['to']!="")
		{
			$AVE_Template->assign('tofromname', base64_decode($_REQUEST['to']));
		}

		if (isset($_REQUEST['forward']) && $_REQUEST['forward']!="")
		{
			$fwre = $_REQUEST['forward']=="1" ? "Fw: " : "Re: ";
			$fromto = $_REQUEST['forward']=="1" ? "from_uid" : "to_uid";

			$sql = $AVE_DB->Query("SELECT message FROM ".PREFIX."_modul_forum_pn WHERE pnid='".addslashes($_GET['pn_id'])."' AND $fromto='".UID."'");
			$row = $sql->FetchRow();
			$sql->Close();

			$qtext = $row->message;
			$qtext = str_replace("\r\n", "\r\n", $qtext);
			$qtext = htmlspecialchars($qtext);

			$qtext = "\r\n\r\n" . "===================\n" . $mod['config_vars']['FORUMS_PN_ORIGINAL_MESSAGE'] . "\n===================\r\n" . $mod['config_vars']['FORUMS_PN_SENDER'].": ".base64_decode($_REQUEST['aut'])."\n". $mod['config_vars']['FORUMS_PN_THE_SUBJECT'] .": ".base64_decode($_REQUEST['subject'])."\n". $mod['config_vars']['FORUMS_PN_DATE'] .": " . date("d.m.Y, H:i:s", base64_decode($_REQUEST['date'])) . "\r\n\n". $qtext . "";

			$AVE_Template->assign('tofromname', base64_decode($_REQUEST['aut']));
			$AVE_Template->assign('title', $fwre.base64_decode($_REQUEST['subject']));
			$AVE_Template->assign('text', $qtext);
		}

		if (SMILIES == 1) $AVE_Template->assign('smilie', 1);

		$AVE_Template->assign('outin', 0);
		$AVE_Template->assign('neu', 1);
	}

	if ($ok == 1)
	{
		$tpl_out = $AVE_Template->fetch($mod['tpl_dir'] . 'pn.tpl');
		define("MODULE_CONTENT", $tpl_out);
		define("MODULE_SITE", $mod['config_vars']['FORUMS_PN_NAME']);
	}
}

?>