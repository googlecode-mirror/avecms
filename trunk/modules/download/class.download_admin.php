<?php
class Download {

	var $_allowed = array('.jpg','jpeg','.jpe','.gif','.png');
	var $_allowed_images = array('image/jpeg','image/pjpeg','image/jpe','image/gif','image/png','image/x-png');
	var $_coupon_limit = 10;
	var $_file_limit = 20;
	var $_expander = '---';

	//=======================================================
	// Wandelt Zeichen in XHTML-Konforme Zeichen um
	//=======================================================
	function pretty_chars($text)
	{
	  return $text;
/*
		$text = str_replace('ü', '&uuml;', $text);
		$text = str_replace('Ü', '&Uuml;', $text);
		$text = str_replace('ö', '&ouml;', $text);
		$text = str_replace('Ö', '&Ouml;', $text);
		$text = str_replace('ä', '&auml;', $text);
		$text = str_replace('Ä', '&Auml;', $text);
		$text = str_replace(' & ', ' &amp; ', $text);
		$text = str_replace('»', '&raquo;', $text);
		$text = str_replace('«', '&laquo;', $text);
		$text = str_replace('>', '&gt;', $text);
		$text = str_replace('<', '&lt;', $text);
		$text = str_replace('ß', '&szlig;', $text);
		$text = str_replace('€', '&euro;', $text);
		$text = str_replace('©', '&copy;', $text);
		$text = str_replace('®', '&reg;', $text);
		$text = str_replace('™', '&#8482;', $text);
		return $text;
*/
	}

	//=======================================================
	// Startseite
	//=======================================================
	function hello($tpl_dir)
	{
		$GLOBALS['AVE_Template']->assign('content', $GLOBALS['AVE_Template']->fetch($tpl_dir . 'download_start.tpl'));
	}

	//=======================================================
	// Funktion zum umbenennen einer Datei
	//=======================================================
	function renameFile($file)
	{
		mt_rand();
		$zufall = rand(1,999);
		$rn_file = $zufall . '_' . $file;
		return $rn_file;
	}

	//=======================================================
	// Kategorien auslesen für Dropdown
	//=======================================================
	function fetchCategs($noprint='')
	{
		$shopitems = array();
		$categs = array();
		$fetchcat = (isset($_GET['categ']) && is_numeric($_GET['categ'])) ? $_GET['categ'] : '0';

		if($noprint != 1)
		{
			$ShopCategs = $this->getCategoriesSimple(0, '', $categs,'0');
			$GLOBALS['AVE_Template']->assign('shopStart', $this->shopRewrite('index.php?module=shop'));
			$GLOBALS['AVE_Template']->assign('shopnavi', $ShopCategs);
			$GLOBALS['AVE_Template']->display($GLOBALS['mod']['tpl_dir'] . $this->_shop_navi);
		} else {
			$ShopCategs = $this->getCategoriesSimple(0, '', $categs,'0',1);
			return $ShopCategs;
		}
	}

	//=======================================================
	// Kategorien
	//=======================================================
	function categs($tpl_dir)
	{
		if(isset($_REQUEST['sub']) && $_REQUEST['sub'] == 'save')
		{
			foreach($_REQUEST['KatName'] as $id => $KatName)
			{
				$GLOBALS['AVE_DB']->Query("UPDATE " . PREFIX . "_modul_download_kat SET
					KatName = '" . pretty_chars($_REQUEST['KatName'][$id]) . "',
					position = '" . $_REQUEST['position'][$id] . "'
				WHERE
					Id = '$id'");
			}
		}

		$categs = array();
		$GLOBALS['AVE_Template']->assign('ProductCategs', $this->getCategoriesSimple(0, '', $categs,'0'));
		$GLOBALS['AVE_Template']->assign('content', $GLOBALS['AVE_Template']->fetch($tpl_dir . 'download_productcategs.tpl'));
	}

	//=======================================================
	// Kategorien auslesen
	//=======================================================
	function getCategoriesSimple($id, $prefix, &$entries, $admin=0, $dropdown=0, $itid='')
	{
		$query = $GLOBALS['AVE_DB']->Query("SELECT * FROM " . PREFIX . "_modul_download_kat WHERE parent_id = '$id' order by position ASC");

   		if (!$query->NumRows()) return;

		while ($item = $query->FetchRow())
		{
			$item->visible_title = $prefix . (($item->parent_id!=0 && $admin != 1) ? '' : '') . $item->KatName;
			$item->expander = $prefix;
			$item->sub = ($item->parent_id==0) ? 0 : 1;
//			$item->dyn_link = "index.php?module=shop&amp;categ=$item->Id&amp;parent=$item->parent_id&amp;navop=" . (($item->sub==0) ? $item->Id : $this->getParentcateg($item->parent_id));
//			$sql = $GLOBALS['AVE_DB']->Query("SELECT Id,KatId FROM ".PREFIX."_modul_shop_artikel WHERE KatId = '$item->Id' AND status='1'");
//			$item->acount = $sql->NumRows();

			array_push($entries,$item);
			if($admin == 1)
			{
				$this->getCategoriesSimple($item->Id, $prefix . '', $entries, $admin, $dropdown);
			} else {
				$this->getCategoriesSimple($item->Id, $prefix . (($dropdown==1) ? '---' : $this->_expander), $entries, $dropdown,  $item->Id);
			}
		}
    	return $entries;
	}

	//=======================================================
	// Elter-Kategorie ermitteln
	//=======================================================
	function getParentcateg($param='')
	{
	global $AVE_DB;
		$id = (is_array($param)) ? $param['id'] : $param ;

		$parent_id = $id;
		$id = 0;
		while($parent_id != 0)
		{
			$sql = $AVE_DB->Query("SELECT parent_id,Id FROM ".PREFIX."_modul_download_kat WHERE Id='".$parent_id."'");

			$row = $sql->FetchRow();
			@$parent_id = $row->parent_id;
			@$id = $row->Id;
		}
		return($id);
	}

	//=======================================================
	// Kategorie bearbeiten
	//=======================================================
	function editCateg($tpl_dir,$id)
	{
		// Speichern
		if(isset($_REQUEST['sub']) && $_REQUEST['sub'] == 'save')
		{
			$DbImage = '';
			$upload_dir = BASE_DIR . '/modules/download/icons/';

			if(isset($_REQUEST['ImgDel']) && $_REQUEST['ImgDel'] == 1)
			{
				@unlink($upload_dir . $_REQUEST['Old']);
				$DbImage = ", Bild = ''";
			}

			if(isset($_FILES) && $_FILES['Bild']['tmp_name'] != '')
			{
				$name = str_replace(array(' ', '+','-'),'',strtolower($_FILES['Bild']['name']));
				$temp = $_FILES['Bild']['tmp_name'];
				$endung = strtolower(substr($name, -3));
				$fupload_name = $name;

				if(in_array($_FILES['Bild']['type'], $this->_allowed_images))
				{
					// Wenn Bild existiert, Bild umbenennen
					@unlink($upload_dir . $_REQUEST['Old']);
					if(file_exists($upload_dir . $fupload_name))
					{
						$fupload_name = $this->renameFile($fupload_name);
						$name = $fupload_name;
					}

					// Bild hochladen
					@move_uploaded_file($_FILES['Bild']['tmp_name'], $upload_dir . $fupload_name);
					@chmod($upload_dir . $fupload_name, 0777);

					$DbImage = ", Bild = '$fupload_name'";
				}
			}

			$q = "UPDATE " . PREFIX . "_modul_download_kat
			SET
				KatName = '" . pretty_chars($_POST['KatName']) . "',
				KatBeschreibung = '" . pretty_chars(@$_POST['KatBeschreibung']) . "',
				position = '" . @$_POST['position'] . "',
				user_group = '" . implode('|', $_POST['user_group']) . "'
				$DbImage
			WHERE Id = '$id'";
			$GLOBALS['AVE_DB']->Query($q);

			echo '<script>window.opener.location.reload(); window.close();</script>';
		}

		// Anzeigen
		$sql = $GLOBALS['AVE_DB']->Query("SELECT * FROM " . PREFIX . "_modul_download_kat WHERE Id = '$id'");
		$row = $sql->FetchRow();

		$row->Bild = ($row->Bild != "" && file_exists(BASE_DIR . "/modules/download/icons/$row->Bild")) ? $row->Bild : "";

		$GLOBALS['AVE_Template']->assign('GruppenErlaubt', @explode('|', $row->user_group));
		$GLOBALS['AVE_Template']->assign('Groups', $this->UserGroups());
		$GLOBALS['AVE_Template']->assign('Categs', $this->fetchCategs(1));
		$GLOBALS['AVE_Template']->assign('row', $row);
		$GLOBALS['AVE_Template']->assign('content', $GLOBALS['AVE_Template']->fetch($tpl_dir . 'download_editcateg.tpl'));
	}

	//=======================================================
	// Neue Kategorie anlegen
	//=======================================================
	function newCateg($tpl_dir,$id='')
	{
		// Speichern
		if(isset($_REQUEST['sub']) && $_REQUEST['sub'] == 'save')
		{
			$DbImage = '';
			$upload_dir = BASE_DIR . '/modules/download/icons/';

			if(isset($_FILES) && $_FILES['Bild']['tmp_name'] != '')
			{
				$name = str_replace(array(' ', '+','-'),'',strtolower($_FILES['Bild']['name']));
				$temp = $_FILES['Bild']['tmp_name'];
				$endung = strtolower(substr($name, -3));
				$fupload_name = $name;

				if(in_array($_FILES['Bild']['type'], $this->_allowed_images))
				{
					// Wenn Bild existiert, Bild umbenennen
					if(file_exists($upload_dir . $fupload_name))
					{
						$fupload_name = $this->renameFile($fupload_name);
						$name = $fupload_name;
					}

					// Bild hochladen
					@move_uploaded_file($_FILES['Bild']['tmp_name'], $upload_dir . $fupload_name);
					@chmod($upload_dir . $fupload_name, 0777);

					$DbImage = $fupload_name;
				}
			}
			$GLOBALS['AVE_DB']->Query("INSERT INTO " . PREFIX . "_modul_download_kat
			(
				Id,
				parent_id,
				KatName,
				position,
				KatBeschreibung,
				user_group,
				Bild
			) VALUES (
				'',
				'" . $_POST['parent_id'] . "',
				'" . pretty_chars($_POST['KatName']) . "',
				'" . $_POST['position'] . "',
				'" . pretty_chars($_POST['KatBeschreibung']) . "',
				'" . @implode('|', $_POST['user_group']) . "',
				'" . $DbImage . "'
			)");
			echo '<script>window.opener.location.reload(); window.close();</script>';
		}

		$GLOBALS['AVE_Template']->assign('Groups', $this->UserGroups());
		$GLOBALS['AVE_Template']->assign('Categs', $this->fetchCategs(1));
		$GLOBALS['AVE_Template']->assign('content', $GLOBALS['AVE_Template']->fetch($tpl_dir . 'download_newcateg.tpl'));
	}

	function UserGroups()
	{
		$sql = $GLOBALS['AVE_DB']->Query("SELECT * FROM " . PREFIX . "_user_groups ORDER BY Name ASC");
		$gruppen = array();
		while($row = $sql->FetchRow())
		{
			array_push($gruppen, $row);
		}
		return $gruppen;
	}

	//=======================================================
	// Löschaufruf
	//=======================================================
	function delCategAll($id)
	{
		$this->delCateg($id);
		header("Location:index.php?do=modules&action=modedit&mod=download&moduleaction=categs&cp=" . SESSION);
		exit;
	}

	//=======================================================
	// Löschfunktion von Kategorien
	//=======================================================
	function delCateg($id)
	{
		$query = $GLOBALS['AVE_DB']->Query("SELECT * FROM " . PREFIX . "_modul_download_kat WHERE parent_id = '$id'");
		while ($item = $query->FetchRow())
		{
			$sql = $GLOBALS['AVE_DB']->Query("DELETE FROM " . PREFIX . "_modul_download_kat WHERE Id = '$item->Id'");
			$this->delCateg($item->Id);
		}
		$query = $GLOBALS['AVE_DB']->Query("DELETE FROM " . PREFIX . "_modul_download_kat WHERE Id = '$id'");
	}

	//=======================================================
	// Übersicht
	//=======================================================
	function overView($tpl_dir)
	{
		if(isset($_REQUEST['sub']) && $_REQUEST['sub']=='save')
		{
			// Aktualisieren
			foreach($_POST['Name'] as $id => $name)
			{
				$q = "UPDATE " . PREFIX . "_modul_download_files
					SET
						Name = '" . htmlspecialchars($_POST['Name'][$id]) . "',
						KatId = '" . $_POST['KatId'][$id] . "',
						Geaendert = '" . time() . "'
					WHERE
						Id = '{$id}'";
				$GLOBALS['AVE_DB']->Query($q);
			}

			// Loeschen
			if(isset($_POST['Del'])  && $_POST['Del'] >= 1)
			{
				foreach($_POST['Del'] as $id => $del)
				{
					$GLOBALS['AVE_DB']->Query("DELETE FROM " . PREFIX . "_modul_download_files  WHERE Id = '{$id}'");
				}
			}

			// Weiterleiten
			header("Location:index.php?do=modules&action=modedit&mod=download&moduleaction=overview&cp=" . SESSION .  "&page=" . $_REQUEST['page']);
			exit;
		}

		$GLOBALS['AVE_Template']->assign('Files', $this->FetchFiles());
		$GLOBALS['AVE_Template']->assign('Categs', $this->fetchCategs(1));
		$GLOBALS['AVE_Template']->assign('content', $GLOBALS['AVE_Template']->fetch($tpl_dir . 'download_downloads.tpl'));
	}

	//=======================================================
	// Dateien auslesen
	//=======================================================
	function FetchFiles()
	{
		$order = ' ORDER BY Name ASC ';
		$name_sort = '';
		$categ_sort = '';
		$search = '';
		$search_string = '';
		$search_categ = '';
		$search_categ_string = '';
		$aktiv_categ = '';
		$aktiv_categ_string = '';

		if(isset($_REQUEST['sort']) && !empty($_REQUEST['sort']))
		{
			switch($_REQUEST['sort'])
			{
				case 'name_desc': $order = " ORDER BY Name DESC"; $name_sort = '&amp;sort=name_desc'; break;
				case 'name_asc': $order = " ORDER BY Name ASC";  $name_sort = '&amp;sort=name_asc';break;
				case 'categ_desc': $order = " ORDER BY KatId DESC"; $name_sort = '&amp;sort=categ_desc'; break;
				case 'categ_asc': $order = " ORDER BY KatId ASC"; $name_sort = '&amp;sort=categ_asc'; break;
				case 'download_desc': $order = " ORDER BY Downloads DESC"; $name_sort = '&amp;sort=download_desc'; break;
				case 'download_asc': $order = " ORDER BY Downloads ASC"; $name_sort = '&amp;sort=download_asc'; break;
				case 'datum_desc': $order = " ORDER BY Datum DESC"; $name_sort = '&amp;sort=datum_desc'; break;
				case 'datum_asc': $order = " ORDER BY Datum ASC"; $name_sort = '&amp;sort=datum_asc'; break;
				case 'geaendert_desc' : $order = " ORDER BY Geaendert DESC"; $name_sort = '&amp;sort=geaendert_desc'; break;
				case 'geaendert_asc' : $order = " ORDER BY Geaendert ASC"; $name_sort = '&amp;sort=geaendert_asc'; break;
			}
		}

		// Es wird ein Such-String angegeben
		if(isset($_REQUEST['dl_query']) && !empty($_REQUEST['dl_query']))
		{
			$_REQUEST['dl_query'] = preg_replace('/[^ _A-Za-zÀ-ßà-ÿ¨¸¯ª²¿º³0-9]/', '', $_REQUEST['dl_query']);
			$search = " AND Name LIKE '" . $_REQUEST['dl_query'] . "%' ";
			$search_string = "&amp;dl_query=" . urlencode($_REQUEST['dl_query']);
			$GLOBALS['AVE_Template']->assign('search_string', $search_string);
		}

		// Es wird eine Kategorie angegeben
		if(isset($_REQUEST['KatId']) && !empty($_REQUEST['KatId']) && $_REQUEST['KatId'] != 'Alle')
		{
			$search_categ = " AND KatId = '" . (int)$_REQUEST['KatId'] . "' ";
			$search_categ_string = "&amp;KatId=" . (int)$_REQUEST['KatId'];
			$GLOBALS['AVE_Template']->assign('search_categ_string', $search_categ_string);
		}

		// Es wird angegeben, ob aktiv oder inaktiv
		if(isset($_REQUEST['status']) && $_REQUEST['status'] != 'Alle')
		{
			$aktiv_categ = " AND status = '" . (int)$_REQUEST['status'] . "' ";
			$aktiv_categ_string = "&amp;status=" . (int)$_REQUEST['status'];
			$GLOBALS['AVE_Template']->assign('aktiv_categ_string', $aktiv_categ_string);
		}


		// Limitierung Datensaetze
		if(isset($_REQUEST['recordset']) && $_REQUEST['recordset'] != '')
		{
			$limit = $_REQUEST['recordset'];
			$limit_nav = "&recordset=" . $_REQUEST['recordset'];
		} else {
			$limit = $this->_file_limit;
			$limit_nav = "";
		}

		$q = " {$search} {$search_categ} {$aktiv_categ} {$order} ";
		$sql = $GLOBALS['AVE_DB']->Query("SELECT Id FROM " . PREFIX . "_modul_download_files WHERE Id != '0' {$q}");
		$num = $sql->NumRows();

		@$seiten = @ceil($num / $limit);
		$start = get_current_page() * $limit - $limit;

		$items = array();
		$query = $GLOBALS['AVE_DB']->Query("SELECT * FROM " . PREFIX . "_modul_download_files WHERE Id != '0' {$q} LIMIT $start,$limit");

		if($num > $limit)
		{
			$page_nav = " <a class=\"pnav\" href=\"index.php?do=modules&action=modedit&mod=download&moduleaction=overview&cp=".SESSION
				. "&page={s}&recordset={$limit}{$name_sort}{$categ_sort}{$search_string}{$search_categ_string}{$aktiv_categ_string}\">{t}</a> ";
			$page_nav = get_pagination($seiten, 'page', $page_nav);
			$GLOBALS['AVE_Template']->assign('page_nav', $page_nav);
		}
		$GLOBALS['AVE_Template']->assign('recordset', $this->_file_limit);

		while ($row = $query->FetchRow())
		{
			$sql_c = $GLOBALS['AVE_DB']->Query("SELECT Id FROM " . PREFIX . "_modul_download_comments WHERE FileId = '{$row->Id}'");
			$num_c = $sql_c->NumRows();

			$row->Comments = $num_c;
//			$row->Categ = $this->fetchCategs(1);
			$row->Author = $this->getAuthor($row->Autor_Erstellt);
			$row->AuthorG = $this->getAuthor($row->Autor_Geandert);
			array_push($items, $row);
		}
		return $items;
	}

	function getAuthor($id)
	{
		$sql = $GLOBALS['AVE_DB']->Query("SELECT email,firstname,lastname FROM " . PREFIX . "_users WHERE Id = '{$id}'");
		$row = $sql->FetchRow();

		$Author = ($row->firstname == '') ? $row->email : substr($row->firstname,0,1) . '.' . $row->lastname;
		return $Author;
	}

	//=======================================================
	// Kommentare bearbeiten
	//=======================================================
	function editComments($tpl_dir,$id)
	{
		// Kommentare speichern
		if(isset($_REQUEST['sub']) && $_REQUEST['sub']=='save')
		{
			foreach($_POST['title'] as $cid => $titel)
			{
				$GLOBALS['AVE_DB']->Query("UPDATE " . PREFIX . "_modul_download_comments SET
					title = '" . @$_POST['title'][$cid] . "',
					Name = '" . @$_POST['Name'][$cid] . "',
					comment_text = '" . @$_POST['comment_text'][$cid] . "',
					email = '" . @$_POST['email'][$cid] . "'
				WHERE
						Id = '{$cid}'
					");
			}

			foreach($_POST['Del'] as $did => $titel) $GLOBALS['AVE_DB']->Query("DELETE FROM " . PREFIX . "_modul_download_comments WHERE Id = '{$did}'");

			header("Location:index.php?do=modules&action=modedit&mod=download&moduleaction=editcomments&cp=" . SESSION . "&pop=1&Id=" . $_REQUEST['Id'] . "&page=1");
			exit;
		}

		$sql = $GLOBALS['AVE_DB']->Query("SELECT Id FROM " . PREFIX . "_modul_download_comments WHERE FileId = '{$id}' ORDER BY Id DESC");
		$num = $sql->NumRows();

		$limit = 5;
		@$seiten = @ceil($num / $limit);
		$start = get_current_page() * $limit - $limit;

		$comments = array();
		$sql = $GLOBALS['AVE_DB']->Query("SELECT * FROM " . PREFIX . "_modul_download_comments WHERE FileId = '{$id}' ORDER BY Id DESC LIMIT $start,$limit");
		while($row = $sql->FetchRow())
		{
			array_push($comments, $row);
		}

		if($num > $limit)
		{
			$page_nav = " <a class=\"pnav\" href=\"index.php?do=modules&action=modedit&mod=download&moduleaction=editcomments&pop=1&Id={$id}&cp=".SESSION."&page={s}\">{t}</a> ";
			$page_nav = get_pagination($seiten, 'page', $page_nav);
			$GLOBALS['AVE_Template']->assign('page_nav', $page_nav);
		}

		$GLOBALS['AVE_Template']->assign('comments', $comments);
		$GLOBALS['AVE_Template']->assign('content', $GLOBALS['AVE_Template']->fetch($tpl_dir . 'download_comments.tpl'));
	}

	//=======================================================
	// Download bearbeiten
	//=======================================================
	function editDownload($tpl_dir,$id)
	{
		if(isset($_REQUEST['sub']) && $_REQUEST['sub']=='save')
		{

			$sql_extra = " ,Pfad = '" . @$_REQUEST['Pfad'] . "', Methode = 'local'";
			$wertungen_extra = "";

			// Pruefen, ob Dateiupload erfolgen soll
			if(isset($_FILES['file_local']) && $_FILES['file_local']['tmp_name'] != '')
			{
				$upload_dir = BASE_DIR . '/modules/download/files/';
				$name = str_replace(array(' ', '+','-'),'',strtolower($_FILES['file_local']['name']));
				$temp = $_FILES['file_local']['tmp_name'];
				$endung = strtolower(substr($name, -3));
				$fupload_name = $name;

				if(file_exists($upload_dir . $fupload_name))
				{
					$fupload_name = $this->renameFile($fupload_name);
					$name = $fupload_name;
				}

				@move_uploaded_file($_FILES['file_local']['tmp_name'], $upload_dir . $fupload_name);
				@chmod($upload_dir . $fupload_name, 0777);

				$sql_extra = " ,Pfad = '" . $fupload_name . "', Methode = 'local', Groesse = '' ";
			}

			if(isset($_REQUEST['Pfad2']) && $_REQUEST['Pfad2'] != '')
			{
				$sql_extra = " ,Pfad = '" . @$_REQUEST['Pfad2'] . "', Methode = 'http', Groesse = '" . @$_REQUEST['FileSize'] . "' ";
			}

			if(isset($_POST['ResetVote']) && $_POST['ResetVote'] == 1)
			{
				$wertungen_extra = ", Wertungen_ip = '', Wertungen_top = '', Wertungen_flop = ''";
			}

			$q = "UPDATE " . PREFIX . "_modul_download_files
				SET
					Name = '" . @$_POST['Name'] ."',
					Geaendert = '" . time() . "',
					Autor_Geandert = '" . UID . "',
					description = '" . $_POST['description'] ."',
					Sprache = '" . implode(',', $_POST['Sprache']) . "',
					Os = '" . implode(',', $_POST['Os']) . "',
					Wertungen_ja = '" . $_POST['Wertungen_ja'] . "',
					Kommentar_ja = '" . $_POST['Kommentar_ja'] . "',
					Autor = '" . $_POST['Autor'] . "',
					AutorUrl = '" . $_POST['AutorUrl'] . "',
					Downloads = '" . $_POST['Downloads'] . "',
					Lizenz = '" . $_POST['Lizenz'] . "',
					RegGebuehr = '" . @$_POST['RegGebuehr'] . "',
					Limitierung = '" . @$_POST['Limitierung'] . "',
					Mirrors = '" . @$_POST['Mirrors'] . "',
					Downloads_Max = '" . @$_POST['Downloads_Max'] . "',
					Pay = '" . @$_POST['Pay'] . "',
					Pay_val = '" . @$_POST['valuta'] . "',
					Pay_Type = '" . @$_POST['Pay_Type'] . "',
					Only_Pay = '" . @$_POST['Only_Pay'] . "',
					Excl_Pay = '" . @$_POST['Excl_Pay'] . "',
					Excl_Chk = '" . (strcmp($_POST['Excl_Chk'],"on")==0?"1":"0") . "',
					Wertung = '" . @$_POST['Wertung'] . "',
					Screenshot = '" . @$_POST['Screenshot'] . "',
					status = '" . @$_POST['status'] . "',
					Version = '" . @$_POST['Version'] . "',
					KatId = '" . @$_POST['KatId'] . "'
					$sql_extra
					$wertungen_extra
				WHERE
					Id = '{$id}'";

			$GLOBALS['AVE_DB']->Query($q);

			if(isset($_POST['DelComments']) && $_POST['DelComments'] == 1)
			{
				$GLOBALS['AVE_DB']->Query("DELETE FROM " . PREFIX . "_modul_download_comments WHERE FileId = '{$id}'");
			}

			echo "<script>window.opener.location.reload(); window.close();</script>";
		}


		$sql = $GLOBALS['AVE_DB']->Query("SELECT * FROM " . PREFIX . "_modul_download_files WHERE Id = '{$id}'");
		$row = $sql->FetchRow();

		$row->FCK_Beschreibung = $this->fck($row->description,'400','description','');
		$row->FCK_Limits = $this->fck($row->Limitierung,'200','Limitierung','Basic');

		$GLOBALS['AVE_Template']->assign('row', $row);
		$GLOBALS['AVE_Template']->assign('DlLanguages', explode(',',$row->Sprache));
		$GLOBALS['AVE_Template']->assign('DlOs', explode(',',$row->Os));
		$GLOBALS['AVE_Template']->assign('Languages', $this->getLang());
		$GLOBALS['AVE_Template']->assign('Licenses', $this->getLicense());
		$GLOBALS['AVE_Template']->assign('Systeme', $this->getOs());
		$GLOBALS['AVE_Template']->assign('Categs', $this->fetchCategs(1));
		$GLOBALS['AVE_Template']->assign('LocalFiles', $this->getLocalFiles());
		$GLOBALS['AVE_Template']->assign('VoteIps', explode(',', $row->Wertungen_ip));
		$GLOBALS['AVE_Template']->assign('content', $GLOBALS['AVE_Template']->fetch($tpl_dir . 'download_edit.tpl'));
	}

	//=======================================================
	// Neuen Download anlegen
	//=======================================================
	function newDownload($tpl_dir)
	{
		if(isset($_REQUEST['sub']) && $_REQUEST['sub'] == 'save')
		{
			$pfad = '';
			$groesse = '';
			$method = 'local';
			$pfad = @$_POST['Pfad'];

			// Pruefen, ob Dateiupload erfolgen soll
			if(isset($_FILES['file_local']) && $_FILES['file_local']['tmp_name'] != '')
			{
				$upload_dir = BASE_DIR . '/modules/download/files/';
				$name = str_replace(array(' ', '+','-'),'',strtolower($_FILES['file_local']['name']));
				$temp = $_FILES['file_local']['tmp_name'];
				$endung = strtolower(substr($name, -3));
				$fupload_name = $name;

				if(file_exists($upload_dir . $fupload_name))
				{
					$fupload_name = $this->renameFile($fupload_name);
					$name = $fupload_name;
				}

				@move_uploaded_file($_FILES['file_local']['tmp_name'], $upload_dir . $fupload_name);
				@chmod($upload_dir . $fupload_name, 0777);

				$pfad = $fupload_name;
				$method = 'local';
			}

			// Kein Dateiupload, sondern Wahl aus dem Mediapool
			if(isset($_REQUEST['Pfad2']) && $_REQUEST['Pfad2'] != '')
			{
				$pfad =  @$_REQUEST['Pfad2'];
				$groesse = @$_REQUEST['FileSize'];
				$method = 'http';
			}

			$q = "INSERT INTO " . PREFIX . "_modul_download_files
			(
				Id,
				Autor,
				AutorUrl,
				Version,
				Sprache,
				KatId,
				Name,
				description,
				Limitierung,
				status,
				Pfad,
				Groesse,
				Datum,
				Os,
				Lizenz,
				Wertung,
				Wertungen_ja,
				RegGebuehr,
				Mirrors,
				Screenshot,
				Autor_Erstellt,
				Kommentar_ja,
				Downloads_Max,
				Pay,
				Pay_val,
				Methode,
				Pay_Type,
				Only_Pay,
				Excl_Pay,
				Excl_Chk
			) VALUES (
				'',
				'" . @$_POST['Autor'] . "',
				'" . @$_POST['AutorUrl'] . "',
				'" . @$_POST['Version'] . "',
				'" . @implode(',', $_POST['Sprache']) . "',
				'" . @$_POST['KatId'] . "',
				'" . @$_POST['Name'] . "',
				'" . @$_POST['description'] . "',
				'" . @$_POST['Limitierung'] . "',
				'" . @$_POST['status'] . "',
				'" . $pfad . "',
				'" . $groesse . "',
				'" . time() . "',
				'" . @implode(',', $_POST['Os']) . "',
				'" . @$_POST['Lizenz'] . "',
				'" . @$_POST['Wertung'] . "',
				'" . @$_POST['Wertungen_ja'] . "',
				'" . @$_POST['RegGebuehr'] . "',
				'" . @$_POST['Mirrors'] . "',
				'" . @$_POST['Screenshot'] . "',
				'" . UID . "',
				'" . @$_POST['Kommentar_ja'] . "',
				'" . @$_POST['Downloads_Max	'] . "',
				'" . @$_POST['Pay'] . "',
				'" . @$_POST['valuta'] . "',
				'" . $method . "',
				'" . @$_POST['Pay_Type'] . "',
				'" . @$_POST['Only_Pay'] . "',
				'" . @$_POST['Excl_Pay'] . "',
				'" . (strcmp($_POST['Excl_Chk'],"on")==0?"1":"0") . "'
			)";
			$GLOBALS['AVE_DB']->Query($q);
			echo "<script>window.opener.location.reload(); window.close();</script>";
		}

		$GLOBALS['AVE_Template']->assign('description', $this->fck('Text','400','description',''));
		$GLOBALS['AVE_Template']->assign('Limitierung', $this->fck('','200','Limitierung','Basic'));
		$GLOBALS['AVE_Template']->assign('Languages', $this->getLang());
		$GLOBALS['AVE_Template']->assign('Licenses', $this->getLicense());
		$GLOBALS['AVE_Template']->assign('Systeme', $this->getOs());
		$GLOBALS['AVE_Template']->assign('Categs', $this->fetchCategs(1));
		$GLOBALS['AVE_Template']->assign('LocalFiles', $this->getLocalFiles());
		$GLOBALS['AVE_Template']->assign('content', $GLOBALS['AVE_Template']->fetch($tpl_dir . 'download_new.tpl'));
	}

	//=======================================================
	// Systeme
	//=======================================================
	function Systems($tpl_dir)
	{
		// Aktualisieren bzw. löschen
		if(isset($_REQUEST['sub']) && $_REQUEST['sub'] == 'save')
		{
			foreach($_POST['Del'] as $id => $del) $GLOBALS['AVE_DB']->Query("DELETE FROM " . PREFIX . "_modul_download_os WHERE Id = '{$id}'");
			foreach($_POST['Name'] as $id => $name) $GLOBALS['AVE_DB']->Query("UPDATE " . PREFIX . "_modul_download_os SET Name = '" . pretty_chars($_POST['Name'][$id]). "' WHERE Id = '{$id}'");
			header("Location:index.php?do=modules&action=modedit&mod=download&moduleaction=systems&cp=" . SESSION . "&pop=1");
			exit;
		}

		// Neu
		if(isset($_REQUEST['sub']) && $_REQUEST['sub'] == 'new')
		{
			foreach($_POST['Name'] as $New) $GLOBALS['AVE_DB']->Query("INSERT INTO " . PREFIX . "_modul_download_os (Id,Name) VALUES ('', '" . pretty_chars($New). "')");
			header("Location:index.php?do=modules&action=modedit&mod=download&moduleaction=systems&cp=" . SESSION . "&pop=1");
			exit;
		}

		$sys = array();
		$sql = $GLOBALS['AVE_DB']->Query("SELECT * FROM " . PREFIX . "_modul_download_os ORDER BY Name ASC");
		while ($row = $sql->FetchRow())
		{
			array_push($sys, $row);
		}

		$GLOBALS['AVE_Template']->assign('sys', $sys);
		$GLOBALS['AVE_Template']->assign('content', $GLOBALS['AVE_Template']->fetch($tpl_dir . 'download_systems.tpl'));
	}

	//=======================================================
	// Lizenzen
	//=======================================================
	function Licenses($tpl_dir)
	{
		// Aktualisieren bzw. löschen
		if(isset($_REQUEST['sub']) && $_REQUEST['sub'] == 'save')
		{
			foreach($_POST['Del'] as $id => $del) $GLOBALS['AVE_DB']->Query("DELETE FROM " . PREFIX . "_modul_download_lizenzen WHERE Id = '{$id}'");
			foreach($_POST['Name'] as $id => $name) $GLOBALS['AVE_DB']->Query("UPDATE " . PREFIX . "_modul_download_lizenzen SET Name = '" . pretty_chars($_POST['Name'][$id]). "' WHERE Id = '{$id}'");
			header("Location:index.php?do=modules&action=modedit&mod=download&moduleaction=licenses&cp=" . SESSION . "&pop=1");
			exit;
		}

		// Neu
		if(isset($_REQUEST['sub']) && $_REQUEST['sub'] == 'new')
		{
			foreach($_POST['Name'] as $New) $GLOBALS['AVE_DB']->Query("INSERT INTO " . PREFIX . "_modul_download_lizenzen (Id,Name) VALUES ('', '" . pretty_chars($New). "')");
			header("Location:index.php?do=modules&action=modedit&mod=download&moduleaction=licenses&cp=" . SESSION . "&pop=1");
			exit;
		}

		$lic = array();
		$sql = $GLOBALS['AVE_DB']->Query("SELECT * FROM " . PREFIX . "_modul_download_lizenzen ORDER BY Name ASC");
		while ($row = $sql->FetchRow())
		{
			array_push($lic, $row);
		}

		$GLOBALS['AVE_Template']->assign('lic', $lic);
		$GLOBALS['AVE_Template']->assign('content', $GLOBALS['AVE_Template']->fetch($tpl_dir . 'download_licenses.tpl'));
	}

	//=======================================================
	// Sprachen
	//=======================================================
	function Languages($tpl_dir)
	{
		// Aktualisieren bzw. löschen
		if(isset($_REQUEST['sub']) && $_REQUEST['sub'] == 'save')
		{
			foreach($_POST['Del'] as $id => $del) $GLOBALS['AVE_DB']->Query("DELETE FROM " . PREFIX . "_modul_download_sprachen WHERE Id = '{$id}'");
			foreach($_POST['Name'] as $id => $name) $GLOBALS['AVE_DB']->Query("UPDATE " . PREFIX . "_modul_download_sprachen SET Name = '" . pretty_chars($_POST['Name'][$id]). "' WHERE Id = '{$id}'");
			header("Location:index.php?do=modules&action=modedit&mod=download&moduleaction=languages&cp=" . SESSION . "&pop=1");
			exit;
		}

		// Neu
		if(isset($_REQUEST['sub']) && $_REQUEST['sub'] == 'new')
		{
			foreach($_POST['Name'] as $New) $GLOBALS['AVE_DB']->Query("INSERT INTO " . PREFIX . "_modul_download_sprachen(Id,Name) VALUES ('', '" . pretty_chars($New). "')");
			header("Location:index.php?do=modules&action=modedit&mod=download&moduleaction=languages&cp=" . SESSION . "&pop=1");
			exit;
		}

		$lang= array();
		$sql = $GLOBALS['AVE_DB']->Query("SELECT * FROM " . PREFIX . "_modul_download_sprachen ORDER BY Name ASC");
		while ($row = $sql->FetchRow())
		{
			array_push($lang, $row);
		}

		$GLOBALS['AVE_Template']->assign('lang', $lang);
		$GLOBALS['AVE_Template']->assign('content', $GLOBALS['AVE_Template']->fetch($tpl_dir . 'download_languages.tpl'));
	}

	//=======================================================
	// Einstellungen
	//=======================================================
	function Settings($tpl_dir)
	{
		if(isset($_REQUEST['sub']) && $_REQUEST['sub'] == 'save')
		{
			$GLOBALS['AVE_DB']->Query("UPDATE " . PREFIX . "_modul_download_settings SET
				Empfehlen = '" . @$_POST['Empfehlen'] . "',
				Bewerten = '" . @$_POST['Bewerten'] . "',
				Spamwoerter = '" . @$_POST['Spamwoerter'] . "',
				Kommentare = '" . @$_POST['Kommentare'] . "'");
		}

		$sql = $GLOBALS['AVE_DB']->Query("SELECT * FROM " . PREFIX . "_modul_download_settings");
		$row = $sql->FetchRow();
		$GLOBALS['AVE_Template']->assign('row', $row);
		$GLOBALS['AVE_Template']->assign('content', $GLOBALS['AVE_Template']->fetch($tpl_dir . 'download_settings.tpl'));
	}

	function SetModule($off_on,$id)
	{
		$GLOBALS['AVE_DB']->Query("UPDATE " . PREFIX . "_modul_download_files SET status = '" . ( ($off_on=='off') ? '0' : '1' ) . "' WHERE Id = '{$id}'");
		echo "<script>window.opener.location.reload(); window.close(); </script>";
	}

	//=======================================================
	// Lokale Dateien auslesen
	//=======================================================
	function getLocalFiles()
	{
		$verzname = BASE_DIR . '/modules/download/files/';
		$dh = opendir( $verzname );
		$sel = "";

		while ( @gettype( $datei = @readdir ( $dh )) != @boolean )
		{
			if ( is_file( "$verzname/$datei" ))
			{
				if ($datei != "." && $datei != ".." && $datei != ".htaccess")
				{
					$sel .= "<option value=\"$datei\"";
					$sel .= ">" . $datei . "</option>";
				}
			}
		}
		return $sel;
	}

	//=======================================================
	// Sprachen
	//=======================================================
	function getLang()
	{
		$lang = array();
		$sql = $GLOBALS['AVE_DB']->Query("SELECT * FROM " . PREFIX . "_modul_download_sprachen");
		while ($row = $sql->FetchRow())
		{
			array_push($lang, $row);
		}
		return $lang;
	}

	//=======================================================
	// Lizenzen
	//=======================================================
	function getLicense()
	{
		$liz = array();
		$sql = $GLOBALS['AVE_DB']->Query("SELECT * FROM " . PREFIX . "_modul_download_lizenzen");
		while ($row = $sql->FetchRow())
		{
			array_push($liz, $row);
		}
		return $liz;
	}

	//=======================================================
	// Systeme
	//=======================================================
	function getOs()
	{
		$os = array();
		$sql = $GLOBALS['AVE_DB']->Query("SELECT * FROM " . PREFIX . "_modul_download_os");
		while ($row = $sql->FetchRow())
		{
			array_push($os, $row);
		}
		return $os;
	}

	//=======================================================
	// Editor erzeugen
	//=======================================================
	function fck($val,$height='300',$name, $toolbar='Default')
	{
		$oFCKeditor = new FCKeditor($name);
		$oFCKeditor->Height = $height;
		$oFCKeditor->ToolbarSet = $toolbar;
		$oFCKeditor->Value = $val;
		$out = $oFCKeditor->Create();
		return $out;
	}

	//=======================================================
	// Ôóíêöèÿ ïîêàçûâàþùàÿ ïàíåëü ïëàòåæåé
	//=======================================================
	function ShowPayHist($tpl_dir)
	{
		$pay = array();

		$sql = $GLOBALS['AVE_DB']->Query("SELECT t1.PayAmount,t1.PayDate,t1.User_IP,t2.Name as FileName,CONCAT(t3.VorName,' ',t3.NachName) AS user_name FROM ".PREFIX."_modul_download_payhistory as t1 ".
																 "LEFT JOIN ".PREFIX."_modul_download_files as t2 ON t1.File_id=t2.Id ".
																 "LEFT JOIN ".PREFIX."_users as t3 ON t1.User_id=t3.Id");

		while ($row = $sql->FetchRow())
		{
			array_push($pay, $row);
		}

		$GLOBALS['AVE_Template']->assign('pay', $pay);
		$GLOBALS['AVE_Template']->assign('content', $GLOBALS['AVE_Template']->fetch($tpl_dir . 'download_payhist.tpl'));
	}
}
?>