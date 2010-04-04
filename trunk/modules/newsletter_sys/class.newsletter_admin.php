<?php

class systemNewsletter
{
	function sentList($tpl_dir)
	{
		global $AVE_DB, $AVE_Template;

		$db_extra = '';
		$nav_string = '';

		if (!empty($_REQUEST['q']))
		{
			$query = ereg_replace('([^ +_A-Za-zР-пр-џ0-9-])', '', $_REQUEST['q']);
			$db_extra = " WHERE title LIKE '%{$query}%' OR message LIKE '%{$query}%' ";
			$nav_string = "&q={$query}";
		}

		$sql = $AVE_DB->Query("
			SELECT id
			FROM " . PREFIX . "_modul_newsletter_sys
			" . $db_extra . "
			ORDER BY id DESC
		");
		$num = $sql->NumRows();

		$limit = 20;
		@$pages = @ceil($num / $limit);
		$start = prepage() * $limit - $limit;

		$items = array();
		$sql = $AVE_DB->Query("
			SELECT *
			FROM " . PREFIX . "_modul_newsletter_sys
			" . $db_extra . "
			ORDER BY Id DESC
			LIMIT " . $start . "," . $limit
		);
		while ($row = $sql->FetchRow())
		{
			$s = $AVE_DB->Query("
				SELECT Name
				FROM " . PREFIX . "_user_groups
				WHERE Benutzergruppe = " . implode(' OR Benutzergruppe = ', explode(';', $row->groups))
			);
			$e = array();
			while ($r = $s->FetchRow())
			{
				array_push($e, $r);
			}

			$row->attach = explode(';', $row->attach);
			$row->groups = $e;
			array_push($items, $row);
		}

		if ($num >= $limit)
		{
			$page_nav = pagenav($pages, 'page',
				" <a class=\"pnav\" href=\"index.php?do=modules&action=modedit&mod=newsletter_sys&moduleaction=1" . $nav_string . "&page={s}&cp=" . SESSION . "\">{t}</a> ");
			$AVE_Template->assign('page_nav', $page_nav);
		}

		$AVE_Template->assign('items', $items);
		$AVE_Template->assign('content', $AVE_Template->fetch($tpl_dir . 'start.tpl'));
	}

	function deleteNewsletter()
	{
		global $AVE_DB;

		foreach ($_POST['del'] as $id => $del)
		{
			$AVE_DB->Query("
				DELETE
				FROM " . PREFIX . "_modul_newsletter_sys
				WHERE id = '". $id ."'
			");
		}
		header("Location:index.php?do=modules&action=modedit&mod=newsletter_sys&moduleaction=1&cp=" . SESSION);
		exit;
	}

	function showNewsletter($tpl_dir,$id, $format)
	{
		global $AVE_DB, $AVE_Template;

		$sql = $AVE_DB->Query("
			SELECT *
			FROM " . PREFIX . "_modul_newsletter_sys
			WHERE id = '" . $id . "'
		");
		$row = $sql->FetchRow();

		if ($format=='html')
		{
			$AVE_Template->assign('Editor', $this->fck(stripslashes($row->message),'550','text','cpengine'));
		}
		$AVE_Template->assign('row', $row);
		$AVE_Template->assign('content', $AVE_Template->fetch($tpl_dir . 'showtext.tpl'));
	}

	function sendNew($tpl_dir)
	{
		global $AVE_DB, $AVE_Template, $AVE_Globals, $AVE_User, $config_vars;

		$AVE_User = new AVE_User;
		$AVE_Globals = new AVE_Globals;

		$tpl_out = "new.tpl";
		$attach = "";

		$email_sender = $AVE_Globals->mainSettings("mail_from");
		$from_name = $AVE_Globals->mainSettings("mail_from_name");

		$AVE_Template->assign('from', $from_name);
		$AVE_Template->assign('frommail', $email_sender);
		$AVE_Template->assign('Editor', $this->fck(
			'<span style="font-family: Verdana;">' . $config_vars['SNL_NEW_TEMPLATE'] . '<br /><br />' . str_replace("\n",
			"<br />",
			$AVE_Globals->mainSettings("mail_signature")) . '</span>',
			'300',
			'text',
			'cpengine')
		);

		if (!empty($_REQUEST['sub']))
		{
			switch ($_REQUEST['sub'])
			{
				case 'send':
					$gruppen = '';
					$count = (!empty($_REQUEST['count'])) ? (int)$_REQUEST['count'] : 0;

					if (isset($_REQUEST['g']))
					{
						$g = $_REQUEST['g'];
						$steps = $_SESSION['steps'];
						$gruppen_r = explode(',', $_REQUEST['g']);
						$gruppen = implode(' OR Benutzergruppe = ', $gruppen_r);
						$nl_text = $_SESSION['nl_text'];
						$nl_titel = $_SESSION['nl_titel'];
						$attach = @implode(';', $_SESSION['attach']);
						$nl_from = $_SESSION['nl_from'];
						$nl_from_mail = $_SESSION['nl_from_mail'];
						$del_attach = $_SESSION['del_attach'];
						$_REQUEST['type'] = $_SESSION['nl_format'];
						$gruppen_db = $_SESSION['gruppen_db'];
					}
					else
					{
						$uri = substr(getenv('PHP_SELF'), 0, -15);
						$url = BASE_URL . $uri;
						$attach = $this->uploadFile();
						$g = implode(',', $_REQUEST['usergroups']);
						$gruppen = implode(' OR Benutzergruppe = ', $_REQUEST['usergroups']);
						$gruppen_db = implode(';', $_REQUEST['usergroups']);
						$steps = $_REQUEST['steps'];
						$del_attach = $_REQUEST['delattach'];
						$_SESSION['nl_text'] = ($_REQUEST['type'] == 'text') ? $_REQUEST['text_norm'] : str_replace('src="' . $uri, 'src="' . $url, stripslashes($_REQUEST['text']));
						$_SESSION['nl_format'] = ($_REQUEST['type'] == 'text') ? 'text' : 'html';
						$_SESSION['nl_titel'] = $_REQUEST['title'];
						$_SESSION['attach'] = $attach;
						$_SESSION['nl_from'] = $_REQUEST['from'];
						$_SESSION['nl_from_mail'] = $_REQUEST['frommail'];
						$_SESSION['steps'] = $steps;
						$_SESSION['del_attach'] = $del_attach;
						$_SESSION['gruppen_db'] = $gruppen_db;
						$nl_text = $_SESSION['nl_text'];
						$nl_titel = $_SESSION['nl_titel'];
						$nl_from = $_SESSION['nl_from'];
						$nl_from_mail = $_SESSION['nl_from_mail'];
					}

					if (!isset($_REQUEST['countall']))
					{
						$sql = $AVE_DB->Query("
							SELECT Benutzergruppe
							FROM " . PREFIX . "_users
							WHERE Benutzergruppe = '" . $gruppen . "'
						");
						$c_all = $sql->NumRows();
					}

					$sql = $AVE_DB->Query("
						SELECT Benutzergruppe
						FROM " . PREFIX . "_users
						WHERE Benutzergruppe = '" . $gruppen . "'
						LIMIT " . $count . "," . $steps
					);
					$c = $sql->NumRows();


					if ($c >= 1)
					{
						$sql = $AVE_DB->Query("
							SELECT
								Vorname,
								Nachname,
								Email
							FROM " . PREFIX . "_users
							WHERE Benutzergruppe = '" . $gruppen . "'
							LIMIT " . $count . "," . $steps
						);
						while ($row = $sql->FetchRow())
						{
							$nl_text = $_SESSION['nl_text'];
							$html_mode = ($_REQUEST['type'] == 'html' || $_REQUEST['html'] == 1) ? '1' : '';
							$nl_text = str_replace('%%USER%%', $row->Nachname . ' ' . $row->Vorname, $nl_text);
							$AVE_Globals->cp_mail(
								$row->Email,
								stripslashes($nl_text),
								$nl_titel,
								$nl_from_mail,
								$nl_from,
								"text",
								$attach,
								$html_mode
							);
						}
						$count += $steps;

						$ca = (!isset($_REQUEST['countall']) ? $c_all : $_REQUEST['countall']);
						$verschickt = $ca - ($ca-$count) ;
						$prozent = round($verschickt / $ca * 100,0);
						$prozent = ($prozent >= 100) ? 100 : $prozent;

						$AVE_Template->assign('prozent', $prozent);
						$AVE_Template->assign('dotcount', str_repeat('.',$count));
						echo '<meta http-equiv="Refresh" content="0;URL=index.php?do=modules&action=modedit&mod=newsletter_sys&moduleaction=new&cp=', SESSION, '&sub=send&pop=1&count=', $count, '&g=', $g, '&countall=', $ca, (($_REQUEST['type'] == 'html') ? '' : '&type=html' ), '" />';
						$tpl_out = "progress.tpl";
					}
					else
					{
						$AVE_DB->Query("
							INSERT
							INTO " . PREFIX . "_modul_newsletter_sys
							SET
								id        = '',
								sender    = '" . $nl_from . "',
								send_date = '" . time() . "',
								format    = '" . (($_REQUEST['type'] == 'html' || $_REQUEST['html'] == 1) ? 'html' : 'text') . "',
								title     = '" . stripslashes($nl_titel) . "',
								message   = '" . stripslashes($nl_text) . "',
								groups    = '" . $gruppen_db. "',
								attach    = '" . $attach . "'
						");

						if (!empty($attach) && $del_attach==1)
						{
							$attach = explode(";", $attach);
							foreach ($attach as $del)
							{
								@unlink(BASE_DIR . "/attachments/" . $del);
							}
						}
						echo "<script>window.opener.location.reload();</script>";
						$tpl_out = "sendok.tpl";
					}
					break;
			}
		}
		$AVE_Template->assign('usergroups', $AVE_User->listAllGroups(2));
		$AVE_Template->assign('content', $AVE_Template->fetch($tpl_dir . $tpl_out));
	}

	function uploadFile($maxupload = '1000')
	{
		global $_FILES;

		$attach = "";
		define("UPDIR", BASE_DIR . "/attachments/");
		if (isset($_FILES['upfile']) && is_array($_FILES['upfile']))
		{
			for ($i=0;$i<count($_FILES['upfile']['tmp_name']);$i++)
			{
				if ($_FILES['upfile']['tmp_name'][$i] != "")
				{
					$d_name = strtolower(ltrim(rtrim($_FILES['upfile']['name'][$i])));
					$d_name = str_replace(" ", "", $d_name);
					$d_tmp = $_FILES['upfile']['tmp_name'][$i];

					$fz = filesize($_FILES['upfile']['tmp_name'][$i]);
					$mz = $maxupload*1024;;

					if ($mz >= $fz)
					{
						if (file_exists(UPDIR . $d_name))
						{
							$d_name = $this->renameFile($d_name);
						}
						@move_uploaded_file($d_tmp, UPDIR . $d_name);
						$attach[] = $d_name;
					}
				}
			}
		}

		return $attach;
	}

	function renameFile($file)
	{
		$old = $file;
		mt_rand();
		$random = rand(1000, 9999);
		$new = $random . "_" . $old;

		return $new;
	}

	function fck($val, $height = '300', $name, $toolbar = 'Default')
	{
		$oFCKeditor = new FCKeditor($name);
		$oFCKeditor->Height = $height;
		$oFCKeditor->ToolbarSet = $toolbar;
		$oFCKeditor->Value = $val;
		$obj = $oFCKeditor->Create();

		return $obj;
	}

	function getFile($file)
	{
		if (!file_exists(BASE_DIR . '/attachments/' . $file))
		{
			$page = (isset($_REQUEST['page'])) ? '&page=' . $_REQUEST['page'] : '';
			header("Location:index.php?do=modules&action=modedit&mod=newsletter_sys&moduleaction=1" . $page . "&file_not_found=1&cp=" . SESSION);
			exit;
		}
		@ob_start();
		header("Pragma: public");
		header("Expires: 0");
		header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
		header("Cache-Control: private",false);
		header("Content-Type: application/octet-stream");
		header("Content-Disposition: attachment; filename=$file");
		header("Content-Transfer-Encoding: binary");
		header("Content-Length: " . @filesize(BASE_DIR . '/attachments/' . $file));
		@set_time_limit(0);
		@readfile(BASE_DIR . '/attachments/' . $file);
		exit;
	}
}

?>