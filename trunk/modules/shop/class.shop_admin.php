<?php

class Shop
{

	var $_allowed = array('.jpg','jpeg','.jpe','.gif','.png');
	var $_allowed_images = array('image/jpeg','image/pjpeg','image/jpe','image/gif','image/png','image/x-png');
	var $_coupon_limit = 10;
	var $_orders_limit = 10;
	var $_expander = '---';

	/**
	 * Стартовая страница административной части
	 *
	 * @param string $tpl_dir путь к папке с шаблонами
	 */
	function shopStart($tpl_dir)
	{
		global $AVE_Template;

		$home = true;
		if (!empty($_REQUEST['sub']))
		{
			$home = false;
			switch ($_REQUEST['sub'])
			{
				case 'topseller':
					$AVE_Template->assign('TopSeller', $this->topSeller('','',100));
					$AVE_Template->assign('content', $AVE_Template->fetch($tpl_dir . 'shop_home_topseller.tpl'));
					break;

				case 'flopseller':
					$AVE_Template->assign('TopSeller', $this->topSeller('','1',100));
					$AVE_Template->assign('content', $AVE_Template->fetch($tpl_dir . 'shop_home_flopseller.tpl'));
					break;

				case 'rez':
					$AVE_Template->assign('Rez', $this->getRez(100));
					$AVE_Template->assign('content', $AVE_Template->fetch($tpl_dir . 'shop_rez100.tpl'));
					break;
			}
		}

		$AVE_Template->assign('Rez', $this->getRez(10));
		$AVE_Template->assign('TopSeller', $this->topSeller());
		$AVE_Template->assign('FlopSeller', $this->topSeller(0,1));
		if ($home == true) $AVE_Template->assign('content', $AVE_Template->fetch($tpl_dir . 'shop_home.tpl'));
	}

	//=======================================================
	// Rezensionen / Bewertungen (Рецензии / Оценки)
	//=======================================================
	function getRez($limit='')
	{
		global $AVE_DB;

		$L = (!empty($limit)) ? $limit : 10;
		$rez = array();
		$sql = $AVE_DB->Query("
			SELECT
				DISTINCT(ArtId)
			FROM " . PREFIX . "_modul_shop_artikel_kommentare
			WHERE Publik != 1
			LIMIT " . $L
		);

		while ($row = $sql->FetchRow())
		{
			$sql_a = $AVE_DB->Query("
				SELECT
					Id,
					ArtNr,
					ArtName
				FROM " . PREFIX . "_modul_shop_artikel
				WHERE Id = '" . $row->ArtId . "'
			");
			$row_a = $sql_a->FetchRow();
			@$row->Artname = $row_a->ArtName;
			@$row->ArtNr = $row_a->Id;
			array_push($rez,$row);
		}

		return $rez;
	}

	/**
	 * Настройки Магазина
	 *
	 * @param string $param название параметра
	 * @return mixed значение запрошенного параметра
	 */
	function _getShopSetting($param)
	{
		if (!isset($this->_setings))
		{
			global $AVE_DB;

			$this->_setings = $AVE_DB->Query("
				SELECT *
				FROM " . PREFIX . "_modul_shop
				LIMIT 1
			")->FetchRow();
		}

		return $this->_setings->$param;
	}

	//=======================================================
	// Dateiendung ermitteln (Определение типа файла по расширению)
	//=======================================================
	function getEndung($file)
	{
		$Endg = mb_substr(mb_strtolower($file),-4);
		switch ($Endg)
		{
			case '.jpg':
			case '.jpe':
			case 'jpeg':
			default :
				$End = 'jpg';
				break;

			case '.png':
				$End = 'png';
				break;

			case '.gif':
				$End = 'gif';
				break;
		}

		return $End;
	}

	function topSeller($type = '', $flop = '', $limit = 10)
	{
		global $AVE_DB;

		$topSeller = array();
		$db_categ = (!empty($_REQUEST['categ'])) ? " AND KatId = '" . $_REQUEST['categ'] . "'" : '';
		$asc_desc = ($flop == 1) ? 'ASC' : 'DESC';
		$sql = $AVE_DB->Query("
			SELECT
				Id,
				ArtNr,
				KatId,
				ArtName,
				TextKurz,
				Bild,
				Preis,
				Bestellungen
			FROM
				" . PREFIX . "_modul_shop_artikel
			WHERE status = '1'
			AND Erschienen <= '" . time() . "'
			" . $db_categ . "
			ORDER BY Bestellungen " . $asc_desc . "
			LIMIT " . $limit
		);
		while ($row = $sql->FetchRow())
		{
			$row->Img = "";
			if (file_exists(BASE_DIR . '/modules/shop/thumbnails/shopthumb__' . $this->_getShopSetting('Topsellerbilder') . '__' . $row->Bild))
			{
				$row->Img = "<img src=\"../modules/shop/thumbnails/shopthumb__" . $this->_getShopSetting('Topsellerbilder') . "__" . $row->Bild . "\" alt=\"\" border=\"\" />";
			}
			else
			{
				$type = $this->getEndung($row->Bild);
				$row->Img = "<img src=\"../modules/shop/thumb.php?file=$row->Bild&amp;type=$type&amp;xwidth=" . $this->_getShopSetting('Topsellerbilder') . "\" alt=\"\" border=\"\" />";
			}

			$row->TextKurz = $row->Img . mb_substr(strip_tags($row->TextKurz,'<b>,<strong>,<em>,<i>'), 0, 250) . '...';
			$row->Detaillink = 'index.php?module=shop&amp;action=product_detail&amp;product_id=' . $row->Id . '&amp;categ=' . $row->KatId . '&amp;navop=' . getParentShopcateg($row->KatId);
			array_push($topSeller, $row);
		}

		return $topSeller;
	}

	//=======================================================
	// Downloads einlesen (Файлы для скачивания)
	//=======================================================
	function fetchEsdFiles()
	{
		$verzname = BASE_DIR . '/modules/shop/files/';
		$dh = @opendir($verzname);
		$esds = array();
		while (@gettype($datei = @readdir($dh)) != @boolean)
		{
			if (@is_file("$verzname/$datei"))
			{
				if ($datei != "." && $datei != ".." && $datei != ".htaccess")
				{
					@array_push($esds, $datei);
				}
			}
		}
		@closedir($dh);

		return $esds;
	}

	//=======================================================
	// Wandelt eine falsche Eingabe um (10,50 in 10.5)
	//=======================================================
	function kReplace($string)
	{
		return str_replace(',', '.', $string);
	}

	function randomVar($c=0)
	{
		$transid = '';
		$chars = array('1', '2', '3', '4', '5', '6', '7', '8', '9', '0',
			'a', 'A', 'b', 'B', 'c', 'C', 'd', 'D', 'e', 'E', 'f', 'F', 'g', 'G', 'h', 'H', 'i', 'I', 'j', 'J',
			'k', 'K', 'l', 'L', 'm', 'M', 'n', 'N', 'o', 'O', 'p', 'P', 'q', 'Q', 'r', 'R', 's', 'S', 't', 'T',
			'u', 'U', 'v', 'V', 'w', 'W', 'x', 'X', 'y', 'Y', 'z', 'Z');
		$ch = ($c != 0) ? $c : 6;
		$count = count($chars) - 1;
		srand((double)microtime() * 1000000);
		for ($i = 0; $i < $ch; $i++)
		{
			$transid .= $chars[rand(0, $count)];
		}

		return(strtoupper($transid));
	}

	//=======================================================
	// Funktion zum umbenennen einer Datei (Функция переименовывания файлов)
	//=======================================================
	function renameFile($file)
	{
		mt_rand();
		$zufall = rand(1,999);
		$rn_file = $zufall . '_' . $file;

		return $rn_file;
	}

	//=======================================================
	// Einen Hersteller auslesen (Выборка производителей)
	//=======================================================
	function _fetchManufacturer($Hersteller)
	{
		global $AVE_DB;

		$sql = $AVE_DB->Query("
			SELECT Name
			FROM " . PREFIX . "_modul_shop_hersteller
			WHERE Id = '" . $Hersteller . "'
			LIMIT 1
		");
		$row = $sql->FetchRow();
		$sql->Close();

		return (is_object($row) ? $row->Name : '');
	}

	function displayManufacturer()
	{
		global $AVE_DB;

		$manufacturer = array();
		$sql = $AVE_DB->Query("
			SELECT *
			FROM " . PREFIX . "_modul_shop_hersteller
			ORDER BY Name ASC
		");
		while ($row = $sql->FetchRow())
		{
			array_push($manufacturer, $row);
		}

		return $manufacturer;
	}

	function getUnit($Unit)
	{
		global $AVE_DB;

		$sql = $AVE_DB->Query("
			SELECT Name
			FROM " . PREFIX . "_modul_shop_einheiten
			WHERE Id = '" . $Unit . "'
			LIMIT 1
		");
		$row = $sql->FetchRow();
		$sql->Close();

		return (is_object($row) ? $row->Name : '');
	}

	function fetchVatZones()
	{
		global $AVE_DB;

		$VatZones = array();
		$sql = $AVE_DB->Query("
			SELECT *
			FROM " . PREFIX . "_modul_shop_ust
			ORDER BY Wert DESC
		");
		while ($row = $sql->FetchRow())
		{
			array_push($VatZones, $row);
		}

		return $VatZones;
	}

	function displayPaymentMethods()
	{
		global $AVE_DB;

		$paymentMethods = array();
		$sql = $AVE_DB->Query("
			SELECT
				Id,
				Name
			FROM " . PREFIX . "_modul_shop_zahlungsmethoden
			ORDER BY Name ASC
		");
		while ($row = $sql->FetchRow())
		{
			array_push($paymentMethods, $row);
		}

		return $paymentMethods;
	}

	function displayShippingMethods()
	{
		global $AVE_DB;

		$ShippingMethods = array();
		$sql = $AVE_DB->Query("
			SELECT
				Id,
				Name
			FROM " . PREFIX . "_modul_shop_versandarten
			ORDER BY Name ASC
		");
		while ($row = $sql->FetchRow())
		{
			array_push($ShippingMethods, $row);
		}

		return $ShippingMethods;
	}

	function displayUnits()
	{
		global $AVE_DB;

		$Units = array();
		$sql = $AVE_DB->Query("
			SELECT *
			FROM " . PREFIX . "_modul_shop_einheiten
			ORDER BY Name ASC
		");
		while ($row = $sql->FetchRow())
		{
			array_push($Units, $row);
		}

		return $Units;
	}

	//=======================================================
	// Versand - Zeiten (Сроки доставки)
	//=======================================================
	function shippingTime()
	{
		global $AVE_DB;

		$shippingTime = array();
		$sql = $AVE_DB->Query("
			SELECT *
			FROM " . PREFIX . "_modul_shop_versandzeit
			ORDER BY Name ASC
		");
		while ($row = $sql->FetchRow())
		{
			array_push($shippingTime, $row);
		}

		return $shippingTime;
	}

	//=======================================================
	// Steuersдtze (Налоги)
	//=======================================================
	function vatZones($tpl_dir)
	{
		global $AVE_DB, $AVE_Template;

		// Neu
		if (isset($_REQUEST['sub']) && $_REQUEST['sub'] == 'new')
		{
			$AVE_DB->Query("
				INSERT " . PREFIX . "_modul_shop_ust
				SET
					Name = '" . $_POST['Name'] . "',
					Wert = '" . $this->kreplace($_POST['Wert']) . "'
			");
		}

		// Speichern
		if (isset($_REQUEST['sub']) && $_REQUEST['sub'] == 'save')
		{
			foreach ($_POST['Name'] as $id => $Name)
			{
				$AVE_DB->Query("
					UPDATE " . PREFIX . "_modul_shop_ust
					SET
						Wert = '" . $this->kreplace($_POST['Wert'][$id]) . "',
						Name = '" . $Name . "'
					WHERE
						Id = '" . $id . "'
				");
			}
			// Lцschen
			if (isset($_POST['Del']) && $_POST['Del'] >= 1)
			{
				foreach ($_POST['Del'] as $id => $Del)
				{
					$AVE_DB->Query("
						DELETE
						FROM " . PREFIX . "_modul_shop_ust
						WHERE Id = '" . $id . "'
					");
				}
			}
		}

		$AVE_Template->assign('vatZones', $this->fetchVatZones());
		$AVE_Template->assign('content', $AVE_Template->fetch($tpl_dir . 'shop_vatzones.tpl'));
	}

	//=======================================================
	// Datei - Downloads fьr einen Artikel (Файл - загрузки для товара)
	//=======================================================
	function esdDownloads($tpl_dir)
	{
		global $AVE_DB, $AVE_Template;

		// Neu anlegen
		if (isset($_REQUEST['sub']) && $_REQUEST['sub'] == 'new')
		{
			$AVE_DB->Query("
				INSERT INTO " . PREFIX . "_modul_shop_artikel_downloads
				SET
					ArtId        = '" . (!empty($_REQUEST['Id']) ? $_REQUEST['Id'] : '') . "',
					Datei        = '" . (!empty($_POST['Datei']) ? $_POST['Datei'] : '') . "',
					DateiTyp     = '" . (!empty($_POST['DateiTyp']) ? $_POST['DateiTyp'] : '') . "',
					TageNachKauf = '" . (!empty($_POST['TageNachKauf']) ? $_POST['TageNachKauf'] : '') . "',
					Bild         = '" . (!empty($_POST['Bild']) ? $_POST['Bild'] : '') . "',
					title        = '" . (!empty($_POST['title']) ? $_POST['title'] : '') . "',
					description = '" . (!empty($_POST['description']) ? $_POST['description'] : '') . "',
					Position     = '" . (!empty($_POST['Position']) ? $_POST['Position'] : '') . "'
			");
		}

		if (isset($_REQUEST['sub']) && $_REQUEST['sub'] == 'save')
		{
		// Speichern
			if (isset($_POST['Del']) && $_POST['Del'] >= 1)
			{
				foreach ($_POST['Del'] as $id => $Datei)
				{
					$AVE_DB->Query("
						DELETE
						FROM " . PREFIX . "_modul_shop_artikel_downloads
						WHERE Id = '" . $id . "'
					");
				}
			}

			foreach ($_POST['Datei'] as $id => $Datei)
			{
				$AVE_DB->Query("
					UPDATE " . PREFIX . "_modul_shop_artikel_downloads
					SET
						Datei        = '" . (!empty($Datei) ? $Datei : '') . "',
						DateiTyp     = '" . (!empty($_POST['DateiTyp'][$id]) ? $_POST['DateiTyp'][$id] : '') . "',
						TageNachKauf = '" . (!empty($_POST['TageNachKauf'][$id]) ? $_POST['TageNachKauf'][$id] : '') . "',
						Bild         = '" . (!empty($_POST['Bild'][$id]) ? $_POST['Bild'][$id] : '') . "',
						title        = '" . (!empty($_POST['title'][$id]) ? $_POST['title'][$id] : '') . "',
						description = '" . (!empty($_POST['description'][$id]) ? $_POST['description'][$id] : '') . "',
						Position     = '" . (!empty($_POST['Position'][$id]) ? $_POST['Position'][$id] : '') . "'
					WHERE
						Id = '" . $id . "'
				");
			}
		}

		$downloads_full = array();
		$downloads_updates = array();
		$downloads_bugfixes = array();
		$downloads_other = array();

		$sql_full = $AVE_DB->Query("
			SELECT *
			FROM " . PREFIX . "_modul_shop_artikel_downloads
			WHERE DateiTyp = 'full'
			AND ArtId = '" . $_REQUEST['Id'] . "'
			ORDER BY Position ASC
		");
		$sql_updates = $AVE_DB->Query("
			SELECT *
			FROM " . PREFIX . "_modul_shop_artikel_downloads
			WHERE DateiTyp = 'update'
			AND ArtId = '" . $_REQUEST['Id'] . "'
			ORDER BY Position ASC
		");
		$sql_bugfixes = $AVE_DB->Query("
			SELECT *
			FROM " . PREFIX . "_modul_shop_artikel_downloads
			WHERE DateiTyp = 'bugfix'
			AND ArtId = '" . $_REQUEST['Id'] . "'
			ORDER BY Position ASC
		");
		$sql_other = $AVE_DB->Query("
			SELECT *
			FROM " . PREFIX . "_modul_shop_artikel_downloads
			WHERE DateiTyp = 'other'
			AND ArtId = '" . $_REQUEST['Id'] . "'
			ORDER BY Position ASC
		");

		while ($row_full = $sql_full->FetchRow()) array_push($downloads_full, $row_full);
		while ($row_updates = $sql_updates->FetchRow()) array_push($downloads_updates, $row_updates);
		while ($row_bugfixes = $sql_bugfixes->FetchRow()) array_push($downloads_bugfixes, $row_bugfixes);
		while ($row_other = $sql_other->FetchRow()) array_push($downloads_other, $row_other);

		$AVE_Template->assign('downloads_full', $downloads_full);
		$AVE_Template->assign('downloads_updates', $downloads_updates);
		$AVE_Template->assign('downloads_bugfixes', $downloads_bugfixes);
		$AVE_Template->assign('downloads_other', $downloads_other);

		$AVE_Template->assign('esds', $this->fetchEsdFiles());
		$AVE_Template->assign('content', $AVE_Template->fetch($tpl_dir . 'shop_product_files.tpl'));
	}

	//=======================================================
	// Dateiupload-Funktion (Функция загрузки файлов)
	//=======================================================
	function uploadFile($maxupload=4000)
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
					$d_name = mb_strtolower(ltrim(rtrim($_FILES['upfile']['name'][$i])));
					$d_name = str_replace(" ","", $d_name);
					$d_tmp = $_FILES['upfile']['tmp_name'][$i];

					$fz = filesize($_FILES['upfile']['tmp_name'][$i]);
					$mz = $maxupload*1024;;

					if ($mz >= $fz)
					{
						if (file_exists(UPDIR . $d_name)) $d_name = $this->renameFile($d_name);
						@move_uploaded_file($d_tmp, UPDIR . $d_name);
						$attach[] = $d_name;
					}
				}
			}

			return $attach;
		}

		return '';
	}

	function showMoney($tpl_dir)
	{
		global $AVE_DB, $AVE_Template;

		if (isset($_REQUEST['search']) && $_REQUEST['search'] == 1)
		{
			$ZeitStart = mktime(0,0,1,$_REQUEST['start_Month'],$_REQUEST['start_Day'],$_REQUEST['start_Year']);
			$ZeitEnde = mktime(23,59,59,$_REQUEST['end_Month'],$_REQUEST['end_Day'],$_REQUEST['end_Year']);
		}
		else
		{
			$ZeitStart = mktime(0,0,1,date("m"),date("d")-(date("d")-1),date("Y"));
			$ZeitEnde = mktime(23,59,59,date("m"),date("d"),date("Y"));
		}

		$ZahlungsId = (isset($_REQUEST['ZahlungsId']) && $_REQUEST['ZahlungsId'] != 'egal') ? "AND ZahlungsId = '" . $_REQUEST['ZahlungsId'] . "'" : '';
		$VersandId = (isset($_REQUEST['VersandId']) && $_REQUEST['VersandId'] != 'egal') ? "AND VersandId = '" . $_REQUEST['VersandId'] . "'" : '';
		$Benutzer = (!empty($_REQUEST['Benutzer'])) ? "AND Benutzer = '" . $_REQUEST['Benutzer'] . "'" : '';

		$sql = $AVE_DB->Query("
			SELECT
				SUM(Gesamt) AS GesamtUmsatz
			FROM " . PREFIX . "_modul_shop_bestellungen
			WHERE (Status = 'ok' || Status = 'ok_send')
			AND (Datum BETWEEN " . $ZeitStart . " AND " . $ZeitEnde . ")
			" . $ZahlungsId . "
			" . $VersandId . "
			" . $Benutzer
		);
		$row = $sql->FetchRow();

		$sql2 = $AVE_DB->Query("
			SELECT
				SUM(Gesamt) AS GesamtUmsatz
			FROM " . PREFIX . "_modul_shop_bestellungen
			WHERE (Datum BETWEEN " . $ZeitStart . " AND " . $ZeitEnde . ")
			" . $ZahlungsId . "
			" . $VersandId . "
			" . $Benutzer
		);
		$row2 = $sql2->FetchRow();

		$sql3 = $AVE_DB->Query("
			SELECT
				SUM(Gesamt) AS GesamtUmsatz
			FROM " . PREFIX . "_modul_shop_bestellungen
			WHERE (Status = 'wait')
			AND (Datum BETWEEN " . $ZeitStart . " AND " . $ZeitEnde . ")
			" . $ZahlungsId . "
			" . $VersandId . "
			" . $Benutzer
		);
		$row3 = $sql3->FetchRow();

		$sql4 = $AVE_DB->Query("
			SELECT
				SUM(Gesamt) AS GesamtUmsatz
			FROM " . PREFIX . "_modul_shop_bestellungen
			WHERE (Status = 'progress')
			AND (Datum BETWEEN " . $ZeitStart . " AND " . $ZeitEnde . ")
			" . $ZahlungsId . "
			" . $VersandId . "
			" . $Benutzer
		);
		$row4 = $sql4->FetchRow();

		$sql5 = $AVE_DB->Query("
			SELECT
				SUM(Gesamt) AS GesamtUmsatz
			FROM " . PREFIX . "_modul_shop_bestellungen
			WHERE (Status = 'failed')
			AND (Datum BETWEEN " . $ZeitStart . " AND " . $ZeitEnde . ")
			" . $ZahlungsId . "
			" . $VersandId . "
			" . $Benutzer
		);
		$row5 = $sql5->FetchRow();

		$row->GesamtUmsatz = number_format($row->GesamtUmsatz,'2',',','.');
		$row->GesamtUmsatzAlle = number_format($row2->GesamtUmsatz,'2',',','.');
		$row->GesamtUmsatzWartend = number_format($row3->GesamtUmsatz,'2',',','.');
		$row->GesamtUmsatzBearbeitung = number_format($row4->GesamtUmsatz,'2',',','.');
		$row->GesamtFehlgeschlagen = number_format($row5->GesamtUmsatz,'2',',','.');

		$AVE_Template->assign('paymentMethods', $this->displayPaymentMethods());
		$AVE_Template->assign('shippingMethods', $this->displayShippingMethods());

		$AVE_Template->assign('row', $row);
		$AVE_Template->assign('ZeitStart', $ZeitStart);
		$AVE_Template->assign('ZeitEnde', $ZeitEnde);
		$AVE_Template->assign('currency', $this->_getShopSetting('WaehrungSymbol'));
		$AVE_Template->assign('content', $AVE_Template->fetch($tpl_dir . 'shop_money.tpl'));
	}

	//=======================================================
	//=======================================================
	// Bestellungen (ЗАКАЗЫ)
	//=======================================================
	//=======================================================
	function ZahlungsArt($id)
	{
		global $AVE_DB;

		$sql = $AVE_DB->Query("
			SELECT
				Name
			FROM " . PREFIX . "_modul_shop_zahlungsmethoden
			WHERE Id = '" . $id . "'
		");
		$row = $sql->FetchRow();

		return $row->Name;
	}

	function VersandArt($id)
	{
		global $AVE_DB;

		$sql = $AVE_DB->Query("
			SELECT
				Name
			FROM " . PREFIX . "_modul_shop_versandarten
			WHERE Id = '" . $id . "'
		");
		$row = $sql->FetchRow();

		return (is_object($row) ? $row->Name : '');
	}

	function getUserName($id)
	{
		global $AVE_DB;

		$sql = $AVE_DB->Query("
			SELECT
				firstname,
				lastname
			FROM " . PREFIX . "_users
			WHERE Id = '" . $id . "'
		");
		$row = $sql->FetchRow();

		return (is_object($row) ? (mb_substr($row->firstname,0,1) . '. ' . $row->lastname) : '');
	}

	function mailPage($tpl_dir,$orderid)
	{
		global $AVE_DB, $AVE_Template, $config_vars;

		if (isset($_REQUEST['sub']) && $_REQUEST['sub'] == 'save')
		{
			send_mail(
				$_REQUEST['mto'],
				stripslashes($_POST['Message']),
				$_POST['Subject'],
				get_settings("mail_from"),
				get_settings("mail_from_name"),
				"text",
				$this->uploadFile()
			);
			echo '<script>window.close();</script>';
		}
		else
		{
			$sql = $AVE_DB->Query("
				SELECT *
				FROM " . PREFIX . "_modul_shop_bestellungen
				WHERE Id = '" . $orderid . "'
			");
			$row = $sql->FetchAssocArray();
			$row['ProductOrdersMailPreBody'] = $config_vars['ProductOrdersMailPreBody'];
			$row['ProductOrdersMailPreBody'] = str_replace("%N%", "\n", $row['ProductOrdersMailPreBody']);

			$UploadSize = @ini_get('upload_max_filesize');
			$PostSize = @ini_get('post_max_size');

			if (mb_strtolower(@ini_get('file_uploads')) == 'off' || @ini_get('file_uploads') == 0)	$AVE_Template->assign('no_uploads', 1);

			$AVE_Template->assign('UploadSize', (($PostSize < $UploadSize) ? $PostSize : $UploadSize) );
			$AVE_Template->assign('row', $row);
			$AVE_Template->assign('content', $AVE_Template->fetch($tpl_dir . 'shop_mailpage.tpl'));
		}
	}

	function getArticleName($id)
	{
		global $AVE_DB;

		$sql = $AVE_DB->Query("
			SELECT ArtName
			FROM " . PREFIX . "_modul_shop_artikel
			WHERE Id = '" . $id . "'
		");
		$row = $sql->FetchRow();

		return (is_object($row) ? ((mb_strlen($row->ArtName)>60) ? mb_substr($row->ArtName, 0, 60) . '...' : $row->ArtName) : '');
	}

	function varCategory($id)
	{
		global $AVE_DB;

		$sql = $AVE_DB->Query("
			SELECT Name
			FROM " . PREFIX . "_modul_shop_varianten_kategorien
			WHERE Id = '" . $id . "'
		");
		$row = $sql->FetchRow();

		return (is_object($row) ? $row->Name : '');
	}

	function splitVars($vars, $out = '')
	{
		global $AVE_DB;

		$v = explode(',', $vars);
		if (count($v)>=1)
		{
			foreach ($v as $var)
			{
				if ($var)
				{
					$sql = $AVE_DB->Query("
						SELECT *
						FROM " . PREFIX . "_modul_shop_varianten
						WHERE Id = '" . $var . "'
					");
					$row = $sql->FetchRow();
					$out .= '<b>' . $this->varCategory($row->KatId) . '</b>: ' . stripslashes($row->Name) . ' ' . $row->Operant . number_format($row->Wert, '2', ',', '.') . '<br />';
				}
			}
		}

		return $out;
	}

	//=======================================================
	// Alle Bestellungen (Все заказы)
	//=======================================================
	function showOrders($tpl_dir)
	{
		global $AVE_DB, $AVE_Template;

		$Status = "";
		$Status_nav = "";
		$Query = "";
		$Query_nav = "";
		$Betrag = "";
//		$Betrag_nav = "";
		$ZahlungsId = "";
		$ZahlungsId_nav = "";
		$VersandId = "";
		$VersandId_nav = "";
		$Order = "ORDER BY Id DESC";
		$Order_nav = "";

		// Schnellstatus
		if (isset($_REQUEST['StatusOrder']) && $_REQUEST['StatusOrder'] != 'nothing')
		{
			reset ($_POST);
			while (list($key,/*$val*/) = each($_POST))
			{
				if (mb_substr($key,0,7) == "orders_")
				{
					$aktid = str_replace("orders_","",$key);
					$AVE_DB->Query("
						UPDATE " . PREFIX . "_modul_shop_bestellungen
						SET Status = '" . $_REQUEST['StatusOrder'] . "'
						WHERE Id = '" . $aktid . "'
					");
				}
			}

			header("Location:index.php?do=modules&action=modedit&mod=shop&moduleaction=showorders&cp=" . SESSION);
			exit;
		}

		// Sortierung
		if (!empty($_REQUEST['Order']))
		{
			switch ($_REQUEST['Order'])
			{
				case 'IdAsc': $Order = "ORDER BY Id ASC"; $Order_nav = "&Order=IdAsc"; break;
				case 'IdDesc': $Order = "ORDER BY Id DESC"; $Order_nav = "&Order=IdDesc"; break;
				case 'PaymentIdAsc': $Order = "ORDER BY ZahlungsId ASC"; $Order_nav = "&Order=PaymentIdAsc"; break;
				case 'PaymentIdDesc': $Order = "ORDER BY ZahlungsId Desc"; $Order_nav = "&Order=PaymentIdDesc"; break;
				case 'ShippingIdAsc': $Order = "ORDER BY VersandId ASC"; $Order_nav = "&Order=ShippingIdAsc"; break;
				case 'ShippingIdDesc': $Order = "ORDER BY VersandId Desc"; $Order_nav = "&Order=ShippingIdDesc"; break;
				case 'CustomerAsc': $Order = "ORDER BY Benutzer ASC"; $Order_nav = "&Order=CustomerAsc"; break;
				case 'CustomerDesc': $Order = "ORDER BY Benutzer Desc"; $Order_nav = "&Order=CustomerDesc"; break;
				case 'SummAsc': $Order = "ORDER BY Gesamt ASC"; $Order_nav = "&Order=SummAsc"; break;
				case 'SummDesc': $Order = "ORDER BY Gesamt Desc"; $Order_nav = "&Order=SummDesc"; break;
			}
		}

		if (isset($_REQUEST['start_Day']))
		{
			$ZeitStart = mktime(0,0,0,$_REQUEST['start_Month'],$_REQUEST['start_Day'],$_REQUEST['start_Year']);
			$ZeitStart_nav = "&start_Month=" . $_REQUEST['start_Month'] . "&start_Day=" . $_REQUEST['start_Day'] . "&start_Year=" . $_REQUEST['start_Year'];
		}
		else
		{
			$ZeitStart = (isset($_REQUEST['date']) && $_REQUEST['date'] == 'today') ? mktime(0,0,1,date("m"),date("d"),date("Y")) : mktime(0,0,1,date("m")-1,date("d"),date("Y"));
			$ZeitStart_nav = (isset($_REQUEST['date']) && $_REQUEST['date'] == 'today') ? "&amp;date=today" : "";
		}

		if (isset($_REQUEST['end_Day']))
		{
			$ZeitEnde = mktime(23,59,59,$_REQUEST['end_Month'],$_REQUEST['end_Day'],$_REQUEST['end_Year']);
			$ZeitEnde_nav = "&end_Month=" . $_REQUEST['end_Month'] . "&end_Day=" . $_REQUEST['end_Day'] . "&end_Year=" . $_REQUEST['end_Year'];
		}
		else
		{
			$ZeitEnde = mktime(23,59,59,date("m"),date("d"),date("Y"));
			$ZeitEnde_nav = "";
		}

		if (isset($_REQUEST['Status']) && $_REQUEST['Status'] != 'egal')
		{
			$Status = " AND Status = '" . $_REQUEST['Status'] . "'";
			$Status_nav = "&status=" . $_REQUEST['Status'];
		}

		if (!empty($_REQUEST['Query']))
		{
			$Query = " AND (Id = '" . $_REQUEST['Query'] . "' || TransId = '" . $_REQUEST['Query'] . "' || Benutzer = '" . $_REQUEST['Query'] . "' || Bestell_Email = '" . $_REQUEST['Query'] . "' || Liefer_Nachname = '" . $_REQUEST['Query'] . "' || Rech_Nachname = '" . $_REQUEST['Query'] . "') ";
			$Query_nav = "&Query=" . $_REQUEST['Query'];
		}

		if (!empty($_REQUEST['price_start']) && !empty($_REQUEST['price_end']))
		{
			$Betrag = " AND (Gesamt BETWEEN " . $this->kreplace($_REQUEST['price_start']) . " AND " . $this->kreplace($_REQUEST['price_end']) . ")";
//			$Betrag_nav = "&price_start=".$_REQUEST['price_start']."&price_end=".$_REQUEST['price_end'];
		}

		if (isset($_REQUEST['ZahlungsId']) && $_REQUEST['ZahlungsId'] != 'egal')
		{
			$ZahlungsId = " AND ZahlungsId = '" . $_REQUEST['ZahlungsId'] . "' ";
			$ZahlungsId_nav = "&ZahlungsId=" . $_REQUEST['ZahlungsId'];
		}

		if (isset($_REQUEST['VersandId']) && $_REQUEST['VersandId'] != 'egal')
		{
			$VersandId = " AND VersandId = '" . $_REQUEST['VersandId'] . "' ";
			$VersandId_nav = "&VersandId=" . $_REQUEST['VersandId'];
		}

		$ZeitSpanne = (isset($_REQUEST['search']) && $_REQUEST['search'] == 1 || isset($_REQUEST['date'])) ? "AND (Datum BETWEEN " . $ZeitStart . " AND " . $ZeitEnde . ") " : "";

		$Orders = array();
		$sql = $AVE_DB->Query("
			SELECT Id
			FROM " . PREFIX . "_modul_shop_bestellungen
			WHERE Id != 0
			" . $VersandId . "
			" . $ZahlungsId . "
			" . $Betrag . "
			" . $Query . "
			" . $Status . "
			" . $ZeitSpanne
		);
		$num = $sql->NumRows();

		if (!empty($_REQUEST['recordset']))
		{
			$limit = $_REQUEST['recordset'];
			$limit_nav = "&recordset=" . $_REQUEST['recordset'];
		}
		else
		{
			$limit = $this->_orders_limit;
			$limit_nav = "";
		}

		@$seiten = @ceil($num / $limit);
		$start = get_current_page() * $limit - $limit;

		$sql = $AVE_DB->Query("
			SELECT *
			FROM " . PREFIX . "_modul_shop_bestellungen
			WHERE Id != 0
			" . $VersandId . "
			" . $ZahlungsId . "
			" . $Betrag . "
			" . $Query . "
			" . $Status . "
			" . $ZeitSpanne . "
			" . $Order . "
			LIMIT " . $start . "," . $limit
		);
		while ($row = $sql->FetchAssocArray())
		{
			$row['ArtikelS'] = "";
			$row['ArtikelSVars'] = "";
			$row['UserId'] = $row['Benutzer'];
			$Artikel = unserialize($row['Artikel']);
			$ArtikelVars = unserialize($row['Artikel_Vars']);
			if (is_array($Artikel))
			{
				foreach ($Artikel as $key => $value)
				{
					$row['ArtikelS'] .= "<br />$value x <a href=javascript:void(0) onclick=cp_pop(\'index.php?do=modules&action=modedit&mod=shop&moduleaction=edit_product&cp=" . SESSION . "&pop=1&Id=" . $key . "\',\'980\',\'740\',\'1\',\'edit_product\');>" . $this->getArticleName($key) . "</a>";
					if (is_array($ArtikelVars))
					{
						foreach ($ArtikelVars as $keys => $values)
						{
							if ($key == $keys) $row['ArtikelS'] .= "<br />" . $this->splitVars($values);
						}
					} // Ende Varianten
				} // Ende enthaltene Artikel
			}

			$row['N'] = $this->getUserName($row['Benutzer']);
			$row['Zahlart'] = $this->ZahlungsArt($row['ZahlungsId']);
			$row['VersandArt'] = $this->VersandArt($row['VersandId']);
			$row['Gesamt'] = number_format($row['Gesamt'],'2',',','.');
			$row['BenId'] = (is_numeric($row['Benutzer'])) ? $row['Benutzer'] : '';
			$row['Benutzer'] = (is_numeric($row['Benutzer']) && ($row['Benutzer']>0) ) ? '<a href="javascript:void(0);" onclick="cp_pop(\'index.php?do=user&action=edit&Id=' . $row['Benutzer'] . '&cp=' . SESSION . '&pop=1\')">' . ( mb_strlen($this->getUserName($row['Benutzer']))< 3 ? $row['Benutzer'] : $this->getUserName($row['Benutzer'])) . '</a>' : '<b>' . $row['Benutzer'] . '</b>';
			$row['BenutzerMail'] = '<a href="javascript:void(0);" onclick="cp_pop(\'index.php?do=modules&action=modedit&mod=shop&moduleaction=mailpage&OrderId=' . $row['Id'] . '&cp=' . SESSION . '&pop=1\')">E-Mail</a>';

			array_push($Orders, $row);
		}

		if ($num > $limit)
		{
			$page_nav = " <a class=\"pnav\" href=\"index.php?do=modules&action=modedit&mod=shop&moduleaction=showorders&cp=" . SESSION
				. "&page={s}" . $Order_nav . $limit_nav . $VersandId_nav . $ZahlungsId_nav
				. $Query_nav . $Status_nav . $ZeitStart_nav . $ZeitEnde_nav . "\">{t}</a> ";
			$page_nav = get_pagination($seiten, 'page', $page_nav);
			$AVE_Template->assign('page_nav', $page_nav);
		}

		$AVE_Template->assign('Orders', $Orders);
		$AVE_Template->assign('ZeitStart', $ZeitStart);
		$AVE_Template->assign('ZeitEnde', $ZeitEnde);
		$AVE_Template->assign('paymentMethods', $this->displayPaymentMethods());
		$AVE_Template->assign('shippingMethods', $this->displayShippingMethods());
		$AVE_Template->assign('content', $AVE_Template->fetch($tpl_dir . 'shop_orders.tpl'));
	}

	// Einzelne Bestellung
	function showOrder($tpl_dir,$id)
	{
		global $AVE_DB, $AVE_Template;

		if (isset($_REQUEST['sub']) && $_REQUEST['sub'] == 'save')
		{
			$sql = $AVE_DB->Query("
				SELECT *
				FROM " . PREFIX . "_modul_shop_bestellungen
				WHERE Id = '" . $id . "'
			");
			$row = $sql->FetchRow();

			$db_gesamt = (!empty($_REQUEST['Gesamt'])) ? ",Gesamt = '" . $this->kreplace($_REQUEST['Gesamt']) . "'" : "";

			$Bez = ($_POST['Status'] == 'ok' || $_POST['Status'] == 'ok_send') ? time() : '';
			$AVE_DB->Query("UPDATE " . PREFIX . "_modul_shop_bestellungen
				SET
					DatumBezahlt      = '" . $Bez . "',
					NachrichtBenutzer = '" . $_POST['NachrichtBenutzer'] . "',
					NachrichtAdmin    = '" . $_POST['NachrichtAdmin'] . "',
					Status            = '" . $_POST['Status'] . "',
					RechnungText      = '" . $_POST['Text'] . "',
					RechnungHtml      = '" . $_POST['RechnungHtml'] . "'
					" . $db_gesamt . "
				WHERE
					Id = '" . $id . "'
			");

			// Artikel - Bestand verringern
			$Artikel = unserialize($row->Artikel);
//			$ArtikelVars = unserialize($row->Artikel_Vars);
			if (is_array($Artikel))
			{
				foreach ($Artikel as $key => $value)
				{
					$AVE_DB->Query("
						UPDATE " . PREFIX . "_modul_shop_artikel
						SET Lager = Lager-" . $value . "
						WHERE Id = '" . $key . "'
					");
				}
			}

			// Mail an Kдufer senden
			if (isset($_REQUEST['SendMail']) && $_REQUEST['SendMail'] == 1)
			{
				$_POST['Message'] = str_replace("%%ORDER_NUMBER%%", $row->Id, $_POST['Message']);

				send_mail(
					$row->Bestell_Email,
					stripslashes($_POST['Message'] . $_POST['Text']),
					$_POST['Subject'],
					get_settings("mail_from"),
					get_settings("mail_from_name"),
					"text",
					$this->uploadFile()
				);
			}

			echo '<script>window.opener.location.reload();window.close();</script>';
		}
		else
		{
			$sql = $AVE_DB->Query("
				SELECT *
				FROM " . PREFIX . "_modul_shop_bestellungen
				WHERE Id = '" . $id . "'
			");
			$row = $sql->FetchAssocArray();

			$oFCKeditor = new FCKeditor('RechnungHtml');
			$oFCKeditor->Height = '300';
			$oFCKeditor->ToolbarSet = 'Simple';
			$oFCKeditor->Value= $row['RechnungHtml'];
			$html = $oFCKeditor->Create();

			$row['IPC'] = $this->gethost($row['Ip']);
			$AVE_Template->assign('row', $row);
			$AVE_Template->assign('html', $html);
			$AVE_Template->assign('text', (!empty($row['RechnungText']) ? $row['RechnungText'] : ''));
			$AVE_Template->assign('content', $AVE_Template->fetch($tpl_dir . 'shop_order_edit.tpl'));
		}
	}

	function markFailed($id)
	{
		global $AVE_DB;

		$AVE_DB->Query("
			UPDATE " . PREFIX . "_modul_shop_bestellungen
			SET Status = 'failed'
			WHERE Id = '" . $id . "'
		");

		echo '<script>window.opener.location.reload();window.close();</script>';
	}

	//=======================================================
	// Kategorien (Категории)
	//=======================================================

	// Neue Kategorie
	function newCateg($tpl_dir)
	{
		global $AVE_DB, $AVE_Template;

		// Speichern
		if (isset($_REQUEST['sub']) && $_REQUEST['sub'] == 'save')
		{
			$DbImage = '';
			$upload_dir = BASE_DIR . '/modules/shop/uploads/';

			if (!empty($_FILES['Bild']['tmp_name']))
			{
				$name = str_replace(array(' ', '+','-'),'_',mb_strtolower($_FILES['Bild']['name']));
				$name = preg_replace("/__+/", "_", $name);
//				$temp = $_FILES['Bild']['tmp_name'];
//				$endung = mb_strtolower(mb_substr($name, -3));
				$fupload_name = $name;

				if (in_array($_FILES['Bild']['type'], $this->_allowed_images))
				{
					// Wenn Bild existiert, Bild umbenennen
					if (file_exists($upload_dir . $fupload_name))
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
			$AVE_DB->Query("
				INSERT " . PREFIX . "_modul_shop_kategorie
				SET
					parent_id           = '" . ((!empty($_POST['parent_id']) && is_numeric($_POST['parent_id'])) ? $_POST['parent_id'] : '0') . "',
					KatName         = '" . $_POST['KatName'] . "',
					KatBeschreibung = '" . $_POST['KatBeschreibung'] . "',
					position            = '" . ((!empty($_POST['position']) && is_numeric($_POST['position'])) ? $_POST['position'] : '1') . "',
					Bild            = '" . $DbImage . "',
					bid             = '" . ((!empty($_POST['bid']) && is_numeric($_POST['bid'])) ? $_POST['bid'] : '0') . "',
					cbid            = '" . ((!empty($_POST['cbid']) && is_numeric($_POST['cbid'])) ? $_POST['cbid'] : '0') . "'
			");

			echo '<script>window.opener.location.reload(); window.close();</script>';
		}

		$oFCKeditor = new FCKeditor('KatBeschreibung') ;
		$oFCKeditor->Height = '200';
		$oFCKeditor->ToolbarSet = 'Basic';
		$oFCKeditor->Value	= @$_POST['KatBeschreibung'];
		$KatBeschreibung = $oFCKeditor->Create();

		$AVE_Template->assign('KatBeschreibung', $KatBeschreibung);
		$AVE_Template->assign('ProductCategs', $this->fetchShopNavi(1));
		$AVE_Template->assign('content', $AVE_Template->fetch($tpl_dir . 'shop_categ_new.tpl'));
	}

	// Bearbeiten
	function editCateg($tpl_dir,$id)
	{
		global $AVE_DB, $AVE_Template;

		// Speichern
		if (isset($_REQUEST['sub']) && $_REQUEST['sub'] == 'save')
		{
			$DbImage = '';
			$upload_dir = BASE_DIR . '/modules/shop/uploads/';

			if (isset($_REQUEST['ImgDel']) && $_REQUEST['ImgDel'] == 1)
			{
				@unlink($upload_dir . $_REQUEST['Old']);
				$DbImage = ", Bild = ''";
			}

			if (!empty($_FILES['Bild']['tmp_name']))
			{
				$name = str_replace(array(' ', '+','-'),'_',mb_strtolower($_FILES['Bild']['name']));
				$name = preg_replace("/__+/", "_", $name);
//				$temp = $_FILES['Bild']['tmp_name'];
//				$endung = mb_strtolower(mb_substr($name, -3));
				$fupload_name = $name;

				if (in_array($_FILES['Bild']['type'], $this->_allowed_images))
				{
					// Wenn Bild existiert, Bild umbenennen
					@unlink($upload_dir . $_REQUEST['Old']);
					if (file_exists($upload_dir . $fupload_name))
					{
						$fupload_name = $this->renameFile($fupload_name);
						$name = $fupload_name;
					}

					// Bild hochladen
					@move_uploaded_file($_FILES['Bild']['tmp_name'], $upload_dir . $fupload_name);
					@chmod($upload_dir . $fupload_name, 0777);

					$DbImage = "Bild = '" . $fupload_name . "',";
				}
			}

			$AVE_DB->Query("
				UPDATE " . PREFIX . "_modul_shop_kategorie
				SET
					" . $DbImage . "
					KatName         = '" . $_POST['KatName'] . "',
					KatBeschreibung = '" . (!empty($_POST['KatBeschreibung']) ? $_POST['KatBeschreibung'] : '') . "',
					position            = '" . (!empty($_POST['position']) ? $_POST['position'] : '') . "',
					bid             = '" . ((!empty($_POST['bid']) && is_numeric($_POST['bid'])) ? $_POST['bid'] : '0') . "',
					cbid            = '" . ((!empty($_POST['cbid']) && is_numeric($_POST['cbid'])) ? $_POST['cbid'] : '0') . "'
				WHERE
					Id = '" . $id . "'
			");

			echo '<script>window.opener.location.reload(); window.close();</script>';
		}

		// Anzeigen
		$sql = $AVE_DB->Query("
			SELECT *
			FROM " . PREFIX . "_modul_shop_kategorie
			WHERE Id = '" . $id . "'
		");
		$row = $sql->FetchRow();

		$row->Bild = ($row->Bild != "" && file_exists(BASE_DIR . "/modules/shop/uploads/$row->Bild")) ? $row->Bild : "";

		$oFCKeditor = new FCKeditor('KatBeschreibung') ;
		$oFCKeditor->Height = '200';
		$oFCKeditor->ToolbarSet = 'Basic';
		$oFCKeditor->Value	= $row->KatBeschreibung;
		$row->KatBeschreibung = $oFCKeditor->Create();

		$AVE_Template->assign('row', $row);
		$AVE_Template->assign('content', $AVE_Template->fetch($tpl_dir . 'shop_categ_edit.tpl'));
	}

	// Lцschaufruf
	function delCategCall($id)
	{
		$this->delCateg($id);

		header("Location:index.php?do=modules&action=modedit&mod=shop&moduleaction=product_categs&cp=" . SESSION);
		exit;
	}

	// Lцschfunktion von Kategorien
	function delCateg($id)
	{
		global $AVE_DB;

		$query = $AVE_DB->Query("
			SELECT *
			FROM " . PREFIX . "_modul_shop_kategorie
			WHERE parent_id = '" . $id . "'
		");

		while ($item = $query->FetchRow())
		{
			$AVE_DB->Query("
				DELETE
				FROM " . PREFIX . "_modul_shop_kategorie
				WHERE Id = '" . $item->Id . "'
			");
			$this->delCateg($item->Id);
		}

		$query = $AVE_DB->Query("
			DELETE
			FROM " . PREFIX . "_modul_shop_kategorie
			WHERE Id = '" . $id . "'
		");
	}

	function productCategs($tpl_dir)
	{
		global $AVE_DB, $AVE_Template;

		if (isset($_REQUEST['sub']) && $_REQUEST['sub'] == 'save')
		{
			foreach ($_REQUEST['KatName'] as $id => $KatName)
			{
				$AVE_DB->Query("
					UPDATE " . PREFIX . "_modul_shop_kategorie
					SET
						KatName = '" . $KatName . "',
						position    = '" . $_REQUEST['position'][$id] . "'
					WHERE
						Id = '" . $id . "'
				");
			}
		}

		$categs = array();
		$AVE_Template->assign('ProductCategs', $this->getCategoriesSimple(0, '', $categs,'0'));
		$AVE_Template->assign('content', $AVE_Template->fetch($tpl_dir . 'shop_categs.tpl'));
	}

	//=======================================================
	// Gutschein - Codes (Купоны на скидку)
	//=======================================================
	function getOrderDate($id)
	{
		global $AVE_DB;

		$sql = $AVE_DB->Query("
			SELECT Datum
			FROM " . PREFIX . "_modul_shop_bestellungen
			WHERE Id = '" . $id . "'
		");
		$row = $sql->FetchRow();

		return (is_object($row) ? $row->Datum : '0');
	}

	// Neuer Code
	function couponCodesNew()
	{
		global $AVE_DB;

		$AVE_DB->Query("
			INSERT " . PREFIX . "_modul_shop_gutscheine
			SET
				Code         = '" . $_POST['Code'] . "',
				Prozent      = '" . $this->kReplace($_POST['Prozent']) . "',
				Mehrfach     = '" . $_POST['Mehrfach'] . "',
				AlleBenutzer = '" . $_POST['AlleBenutzer'] . "',
				GueltigVon   = '" . @mktime(0,0,0,date("m"),date("d")-1,date("Y")) . "',
				GueltigBis   = '" . @mktime(23,59,59,date("m")+1,date("d"),date("Y")) . "'
		");

		header("Location:index.php?do=modules&action=modedit&mod=shop&moduleaction=couponcodes&cp=" . SESSION);
		exit;
	}

	// Anzeigen
	function couponCodes($tpl_dir)
	{
		global $AVE_DB, $AVE_Template;

		// Lцschen
		if (isset($_REQUEST['sub']) && $_REQUEST['sub'] == 'save')
		{
			if (isset($_POST['Del']) && $_POST['Del'] >= 1)
			{
				foreach ($_POST['Del'] as $id => $Del)
				{
					$AVE_DB->Query("
						DELETE
						FROM " . PREFIX . "_modul_shop_gutscheine
						WHERE Id = '" . $id . "'
					");
				}
			}
			// Speichern
			$regex_birthday = '#(0[1-9]|[12][0-9]|3[01])([[:punct:]| ])(0[1-9]|1[012])\2(19|20)\d\d#';
			foreach ($_POST['Code'] as $id => $Code)
			{
				if (@preg_match($regex_birthday, $_POST['GueltigVon'][$id]) &&
					@preg_match($regex_birthday, $_POST['GueltigBis'][$id]))
				{
					$gueltig_von = explode('.', $_POST['GueltigVon'][$id]);
					$gueltig_bis = explode('.', $_POST['GueltigBis'][$id]);

					$gvon = @mktime(0,0,0,$gueltig_von[1],$gueltig_von[0],$gueltig_von[2]);
					$gbis = @mktime(23,59,59,$gueltig_bis[1],$gueltig_bis[0],$gueltig_bis[2]);

					$DB_von_bis = ",GueltigVon = '" . $gvon . "', GueltigBis = '" . $gbis . "' ";
				}
				else
				{
					$DB_von_bis = "";
				}

				$AVE_DB->Query("
					UPDATE " . PREFIX . "_modul_shop_gutscheine
					SET
						Code         = '" . $Code . "',
						Prozent      = '" . $this->kReplace($_POST['Prozent'][$id]) . "',
						Mehrfach     = '" . $_POST['Mehrfach'][$id] . "',
						AlleBenutzer = '" . $_POST['AlleBenutzer'][$id] . "'
						" . $DB_von_bis . "
					WHERE
						Id = '" . $id . "'
				");
			}
		}

		// Auslesen
		$couponCodes = array();
		$sql = $AVE_DB->Query("
			SELECT
				Id
			FROM " . PREFIX . "_modul_shop_gutscheine
		");
		$num = $sql->NumRows();

		$limit = $this->_coupon_limit;
		@$seiten = @ceil($num / $limit);
		$start = get_current_page() * $limit - $limit;

		$sql = $AVE_DB->Query("
			SELECT *
			FROM " . PREFIX . "_modul_shop_gutscheine
			LIMIT " . $start . "," . $limit
		);

		while ($row = $sql->FetchRow())
		{
			$row->BIdLink = '';
			$BestellIds = explode(',', $row->BestellId);
			foreach ($BestellIds as $BId)
			{
				if ($BId != '')
				{
					$row->BIdLink .= '<a href=\'javascript:void(0);\' onclick=cp_pop(\'index.php?do=modules&action=modedit&mod=shop&moduleaction=showorder&cp=' . SESSION . '&Id=' . $BId . '&pop=1\',\'980\',\'740\',\'1\',\'show_order\')>' . date("d.m.Y, H:i", $this->getOrderDate($BId)) . '</a><br />';
				}
			}

			$row->GueltigVon = date('d.m.Y', $row->GueltigVon);
			$row->GueltigBis = date('d.m.Y', $row->GueltigBis);
			array_push($couponCodes, $row);
		}

		if ($num > $limit)
		{
			$page_nav = " <a class=\"pnav\" href=\"index.php?do=modules&action=modedit&mod=shop&moduleaction=couponcodes&cp=" . SESSION . "&page={s}\">{t}</a> ";
			$page_nav = get_pagination($seiten, 'page', $page_nav);
			$AVE_Template->assign('page_nav', $page_nav);
		}

		$AVE_Template->assign('randomVar', $this->randomVar());
		$AVE_Template->assign('couponCodes', $couponCodes);
		$AVE_Template->assign('content', $AVE_Template->fetch($tpl_dir . 'shop_couponcodes.tpl'));
	}

	//=======================================================
	// Produkte anzeigen (Последние поступления)
	//=======================================================
	function lastArticles()
	{
		global $AVE_DB, $AVE_Template;

		$limit = 10;

		$dbextra = '';
		$dbextra_n = '';
		$manufacturer = '';
		$manufacturer_n = '';
		$product_query = '';
		$product_query_n = '';
		$price_query = '';
		$price_query_n = '';
		$product_categ = '';
		$product_categ_n = '';
		$recordset_n = '';
		$active = '';
		$active_n = '';
		$lager = '';
		$lager_n = '';
		$best = '';
		$best_n = '';
		$angebot = '';
		$angebot_n = '';

		if (isset($_REQUEST['recordset']) && is_numeric($_REQUEST['recordset']))
		{
			$limit = $_REQUEST['recordset'];
			$recordset_n = "&amp;recordset=" . $_REQUEST['recordset'];
		}

		if (isset($_REQUEST['categ']) && is_numeric($_REQUEST['categ']))
		{
			$dbextra = " AND (KatId = '" . (int)$_REQUEST['categ'] . "' OR a.KatId_Multi LIKE '%," . (int)$_REQUEST['categ'] . ",%' OR a.KatId_Multi LIKE '%," . (int)$_REQUEST['categ'] . "' OR a.KatId_Multi LIKE '" . (int)$_REQUEST['categ'] . ",%')";
			$dbextra_n = "&amp;categ=" . $_REQUEST['categ'];
		}

		if (isset($_REQUEST['manufacturer']) && is_numeric($_REQUEST['manufacturer']))
		{
			$manufacturer = " AND a.Hersteller = '" . $_REQUEST['manufacturer'] . "'";
			$manufacturer_n = "&amp;manufacturer=" . $_REQUEST['manufacturer'];
		}

		if (!empty($_REQUEST['product_query']))
		{
			$product_query = " AND (a.ArtNr = '" . $_REQUEST['product_query'] . "' OR a.ArtName LIKE '%" . $_REQUEST['product_query'] . "%' OR a.TextKurz LIKE '%" . $_REQUEST['product_query'] . "%')";
			$product_query_n = "&amp;product_query=" . urlencode($_REQUEST['product_query']);
		}

		if (isset($_REQUEST['price_start']) && is_numeric($_REQUEST['price_start']) &&
			isset($_REQUEST['price_end']) && is_numeric($_REQUEST['price_end']) &&
			$_REQUEST['price_start'] >= 0 && $_REQUEST['price_end'] >= 0 &&
			$_REQUEST['price_start'] < $_REQUEST['price_end'])
		{
			$price_query = " AND (a.Preis BETWEEN " . $_REQUEST['price_start'] . " AND " . $_REQUEST['price_end'] . ")";
			$price_query_n = "&amp;price_start=" . $_REQUEST['price_start'] . "&amp;price_end=" . $_REQUEST['price_end'];
		}

		if (isset($_REQUEST['product_categ']) && is_numeric($_REQUEST['product_categ']))
		{
			$product_categ = " AND a.KatId = '" . $_REQUEST['product_categ'] . "'";
			$product_categ_n = "&amp;product_categ=" . $_REQUEST['product_categ'];
		}

		if (!empty($_REQUEST['active']) && $_REQUEST['active'] != 'all')
		{
			$active = " AND a.status = '" . $_REQUEST['active'] . "'";
			$active_n = "&amp;active=" . $_REQUEST['active'];
		}

		if (!empty($_REQUEST['Lager']) && $_REQUEST['Lager'] != 'egal')
		{
			$lager = " AND a.Lager < '" . $_REQUEST['Lager'] . "'";
			$lager_n = "&amp;Lager=" . $_REQUEST['Lager'];
		}

		if (!empty($_REQUEST['Bestellungen']) && $_REQUEST['Bestellungen'] != 'egal')
		{
			$best = " AND a.Bestellungen < '" . $_REQUEST['Bestellungen'] . "'";
			$best_n = "&amp;Bestellungen=" . $_REQUEST['Bestellungen'];
		}

		if (!empty($_REQUEST['Angebot']) && $_REQUEST['Angebot'] != 'egal')
		{
			$angebot = " AND a.Angebot = 1";
			$angebot_n = "&amp;Angebot=1";
		}

		// Sortierung
		$db_sort = "ORDER BY a.Id DESC";
		$navi_sort = "";

		if (!empty($_REQUEST['sort']))
		{
			switch ($_REQUEST['sort'])
			{
				case 'NameAsc':
					$db_sort = "ORDER BY a.ArtName ASC";
					$navi_sort = "&sort=NameAsc";
					break;

				case 'NameDesc':
					$db_sort = "ORDER BY a.ArtName DESC";
					$navi_sort = "&sort=NameDesc";
					break;

				case 'PriceAsc':
					$db_sort = "ORDER BY a.Preis ASC";
					$navi_sort = "&sort=PriceAsc";
					break;

				case 'PriceDesc':
					$db_sort = "ORDER BY a.Preis DESC";
					$navi_sort = "&sort=PriceDesc";
					break;

				case 'LagerAsc':
					$db_sort = "ORDER BY a.Lager ASC";
					$navi_sort = "&sort=LagerAsc";
					break;

				case 'LagerDesc':
					$db_sort = "ORDER BY a.Lager DESC";
					$navi_sort = "&sort=LagerDesc";
					break;

				case 'GekauftAsc':
					$db_sort = "ORDER BY a.Bestellungen ASC";
					$navi_sort = "&sort=GekauftAsc";
					break;

				case 'GekauftDesc':
					$db_sort = "ORDER BY a.Bestellungen DESC";
					$navi_sort = "&sort=GekauftDesc";
					break;

				case 'PositionAsc':
					$db_sort = "ORDER BY a.PosiStartseite ASC";
					$navi_sort = "&sort=PositionAsc";
					break;

				case 'PositionDesc':
					$db_sort = "ORDER BY a.PosiStartseite DESC";
					$navi_sort = "&sort=PositionDesc";
					break;
			}
		}

		$shopitems = array();

		$sql = $AVE_DB->Query("
			SELECT
				a.Id
			FROM " . PREFIX . "_modul_shop_artikel as a
			WHERE a.Id != 0
			" . $angebot . "
			" . $best . "
			" . $lager . "
			" . $active . "
			" . $product_categ . "
			" . $price_query . "
			" . $product_query . "
			" . $dbextra . "
			" . $manufacturer . "
		");
		$num = $sql->NumRows();


		$limit = $limit;
		@$seiten = @ceil($num / $limit);
		$start = get_current_page() * $limit - $limit;

		$sql = $AVE_DB->Query("
			SELECT
				a.*
			FROM " . PREFIX . "_modul_shop_artikel as a
			WHERE a.Id != 0
			" . $angebot . "
			" . $best . "
			" . $lager . "
			" . $active . "
			" . $product_categ . "
			" . $price_query . "
			" . $product_query . "
			" . $dbextra . "
			" . $manufacturer . "
			" . $db_sort . "
			LIMIT " . $start . "," . $limit
		);

		while ($row = $sql->FetchRow())
		{
			$row->NavOp = getParentShopcateg($row->KatId);
//			$this->globalProductInfo($row);

			$sql_a = $AVE_DB->Query("
				SELECT
					Id
				FROM " . PREFIX . "_modul_shop_artikel_kommentare
				WHERE ArtId = '" . $row->Id . "'
			");
			$num_a = $sql_a->NumRows();

			$row->comments = $num_a;

			array_push($shopitems, $row);
		}

//		$the_nav_title = '';
		if (isset($_REQUEST['categ']) && is_numeric($_REQUEST['categ']))
		{
			$the_nav = $this->_getNavigationPath((int)$_REQUEST['categ'], '', '1', (int)$_REQUEST['navop']);
			define("TITLE_EXTRA", strip_tags($the_nav));
			$AVE_Template->assign('topnav', $this->_getNavigationPath((int)$_REQUEST['categ'], '', '1', (int)$_REQUEST['navop']));
		}

		if ($num > $limit)
		{
			$page_nav = " <a class=\"pnav\" href=\"index.php?do=modules&action=modedit&mod=shop&moduleaction=products&cp=" . SESSION
				. $navi_sort . $angebot_n . $best_n . $lager_n . $active_n . $recordset_n . $product_categ_n
				. $price_query_n . $product_query_n . $dbextra_n . $manufacturer_n . "&amp;page={s}\">{t}</a> ";
			$page_nav = get_pagination($seiten, 'page', $page_nav);
			$AVE_Template->assign('page_nav', $page_nav);
		}

		return $shopitems;
	}

	// Rezensionen bearbeiten
	function editComments($tpl_dir)
	{
		global $AVE_DB, $AVE_Template;

		if (isset($_REQUEST['sub']) && $_REQUEST['sub'] == 'save')
		{
			foreach ($_POST['title'] as $id => $title)
			{
				$AVE_DB->Query("
					UPDATE " . PREFIX . "_modul_shop_artikel_kommentare
					SET
						title     = '" . $title . "',
						comment_text = '" . $_POST['comment_text'][$id] . "',
						Wertung   = '" . (($_POST['Wertung'][$id]<1 || $_POST['Wertung'][$id]>5) ? 3 : $_POST['Wertung'][$id]) . "',
						Publik    = '" . $_POST['Publik'][$id] . "'
					WHERE
						Id = '" . $id . "'
				");
			}

			if (isset($_REQUEST['Del']) && $_REQUEST['Del']>=1)
			{
				foreach ($_POST['Del'] as $id => $Del)
				{
					$AVE_DB->Query("DELETE FROM " . PREFIX . "_modul_shop_artikel_kommentare WHERE Id = '" . $id . "'");
				}
			}

			echo '<script>window.opener.location.reload();window.close();</script>';
		}

		$comments = array();
		$sql = $AVE_DB->Query("
			SELECT *
			FROM " . PREFIX . "_modul_shop_artikel_kommentare
			WHERE ArtId = '" . (int)$_REQUEST['Id'] . "'
			ORDER BY Id DESC
		");
		while ($row = $sql->FetchRow())
		{
			array_push($comments, $row);
		}

		$AVE_Template->assign('comments', $comments);
		$AVE_Template->assign('content', $AVE_Template->fetch($tpl_dir . 'shop_comments.tpl'));
	}

//	function globalProductInfo($row = '') {
//		//
//	}

	//=======================================================
	// Shop - Navi erzeugen (Магазин - Навигация по категориям)
	//=======================================================
	function getCategoriesSimple($id, $prefix, &$entries, $admin=0, $dropdown=0)
	{
		global $AVE_DB;

		$query = $AVE_DB->Query("
			SELECT *
			FROM " . PREFIX . "_modul_shop_kategorie
			WHERE parent_id = '" . $id . "'
			ORDER BY position ASC
		");

		if (!$query->NumRows()) return '';

		while ($item = $query->FetchRow())
		{
			$item->visible_title = $prefix . (($item->parent_id != 0 && $admin != 1) ? '' : '') . $item->KatName;
			$item->expander = $prefix;
			$item->dyn_link = "index.php?module=shop&amp;categ=" . $item->Id . "&amp;parent=" . $item->parent_id . "&amp;navop=" . (($item->parent_id == 0) ? $item->Id : getParentShopcateg($item->parent_id));
			$item->acount = $AVE_DB->Query("
				SELECT
					Id,
					KatId
				FROM " . PREFIX . "_modul_shop_artikel
				WHERE KatId = '" . $item->Id . "'
				AND status = '1'
			")->NumRows();

			array_push($entries,$item);
			if ($admin == 1)
			{
				$this->getCategoriesSimple($item->Id, $prefix . '', $entries, $admin, $dropdown);
			}
			else
			{
				$this->getCategoriesSimple($item->Id, $prefix . (($dropdown == 1) ? '&nbsp;&nbsp;' : $this->_expander), $entries, $dropdown);
			}
		}

		return $entries;
	}

	//=======================================================
	// Shop - Navi (Магазин - Навигация)
	//=======================================================
	function fetchShopNavi($noprint='')
	{
		global $AVE_Template;

//		$shopitems = array();
		$categs = array();
//		$fetchcat = (isset($_GET['categ']) && is_numeric($_GET['categ'])) ? $_GET['categ'] : '0';

		if ($noprint != 1)
		{
			$ShopCategs = $this->getCategoriesSimple(0, '', $categs,'0');
			$AVE_Template->assign('shopStart', $this->shopRewrite('index.php?module=shop'));
			$AVE_Template->assign('shopnavi', $ShopCategs);
			$AVE_Template->display($GLOBALS['mod']['tpl_dir'] . $this->_shop_navi);
		}
		else
		{
			$ShopCategs = $this->getCategoriesSimple(0, '', $categs,'0',1);

			return $ShopCategs;
		}

		return '';
	}

	//=======================================================
	// Funktion zum Auslesen der Lдnder (Выборка списка стран)
	//=======================================================
	function displayCountries()
	{
		global $AVE_DB;

		$laender = array();
		$sql = $AVE_DB->Query("
			SELECT
				country_code,
				country_name
			FROM " . PREFIX . "_countries
			WHERE country_status = '1'
			ORDER BY country_name ASC
		");
		while ($row = $sql->FetchRow()) array_push($laender,$row);

		return $laender;
	}

	//=======================================================
	// Funktion zum Auslesen der Versandkosten einer Versandart
	// (Функция расчета стоимости пересылки в зависимости от вида отправки)
	//=======================================================
	function displayShippingCost($arr = '', $vid = '')
	{
		global $AVE_DB;

		$shippingcost = array();
		$sql = $AVE_DB->Query("
			SELECT
				country_code,
				country_name
			FROM " . PREFIX . "_countries
			WHERE country_status = '1'
			ORDER BY country_name ASC
		");

		while ($row = $sql->FetchRow())
		{
			$vcost = array();
			if (in_array($row->country_code,$arr))
			{
				$sql_vcost = $AVE_DB->Query("
					SELECT *
					FROM " . PREFIX . "_modul_shop_versandkosten
					WHERE country = '" . $row->country_code . "'
					AND VersandId = '" . $vid . "'
					ORDER BY KVon ASC
				");
				while ($row_vcost = $sql_vcost->FetchRow())
				{
					array_push($vcost, $row_vcost);
				}
				$row->versandkosten = $vcost;
				array_push($shippingcost, $row);
			}
		}

		return $shippingcost ;
	}

	//=======================================================
	// Funktion zum Auslesen der Versandarten (Выборка видов отправки)
	//=======================================================
	function displayShipper()
	{
		global $AVE_DB;

		$shipper = array();
		$sql = $AVE_DB->Query("
			SELECT *
			FROM " . PREFIX . "_modul_shop_versandarten
			ORDER BY Name ASC
		");
		while ($row = $sql->FetchRow()) array_push($shipper,$row);

		return $shipper;
	}

	//=======================================================
	// Funktion zum Auslesen der Gruppen (Выборка групп пользователей)
	//=======================================================
	function displayGroups()
	{
		global $AVE_DB;

		$Groups = array();
		$sql = $AVE_DB->Query("
			SELECT *
			FROM " . PREFIX . "_user_groups
			ORDER BY user_group_name ASC
		");
		while ($row = $sql->FetchRow()) array_push($Groups,$row);

		return $Groups;
	}

	//=======================================================
	// Versandarten (Виды отправки)
	//=======================================================
	function shopShipper($tpl_dir)
	{
		global $AVE_DB, $AVE_Template;

		if (!empty($_REQUEST['sub']))
		{
			switch ($_REQUEST['sub'])
			{
				case 'save':
					foreach ($_POST['Name'] as $id => $Name)
					{
						if (!empty($Name))
						{
							$AVE_DB->Query("
								UPDATE " . PREFIX . "_modul_shop_versandarten
								SET
									Name        = '" . htmlspecialchars($Name) . "',
									KeineKosten = '" . intval($_POST['KeineKosten'][$id]) . "',
									status      = '" . intval($_POST['status'][$id]) . "'
								WHERE
									Id = '" . (int)$id . "'
							");
						}
					}

					if (isset($_POST['Del']) && count($_POST['Del']) >= 1)
					{
						foreach ($_POST['Del'] as $id => $Del)
						{
							$AVE_DB->Query("
								DELETE
								FROM " . PREFIX . "_modul_shop_versandkosten
								WHERE VersandId = '" . $id . "'
							");
							$AVE_DB->Query("
								DELETE
								FROM " . PREFIX . "_modul_shop_versandarten
								WHERE Id = '" . $id . "'
							");
						}
					}
					break;

				case 'new':
					$shipper_name = trim($_POST['NewShipper']);
					if (!empty($shipper_name))
					{
						$AVE_DB->Query("
							INSERT " . PREFIX . "_modul_shop_versandarten
							SET Name = '" . htmlspecialchars($shipper_name) . "'
						");
					}
					break;
			}
		}

		$AVE_Template->assign('shopShipper',$this->displayShipper());
		$AVE_Template->assign('content', $AVE_Template->fetch($tpl_dir . 'shop_shippers.tpl'));
	}

	function editShipper($tpl_dir)
	{
		global $AVE_DB, $AVE_Template;

		if (isset($_REQUEST['sub']) && $_REQUEST['sub'] == 'save')
		{
			$Icon = '';
			$AVE_DB->Query("
				UPDATE " . PREFIX . "_modul_shop_versandarten
				SET
					Name              = '" . $_POST['Name'] . "',
					description      = '" . $_POST['description'] . "',
					Icon              = '" . $Icon . "',
					LaenderVersand    = '" . (!empty($_POST['LaenderVersand']) ? implode(',', $_POST['LaenderVersand']) : '') . "',
					Pauschalkosten    = '" . str_replace(',','.',$_POST['Pauschalkosten']) . "',
					NurBeiGewichtNull = '" . $_POST['NurBeiGewichtNull'] . "',
					ErlaubteGruppen   = '" . (!empty($_POST['ErlaubteGruppen']) ? implode(',', $_POST['ErlaubteGruppen']) : '') . "'
				WHERE
					Id = '" . $_REQUEST['Id'] . "'
			");

			echo '<script>window.opener.location.reload(); window.close();</script>';
		}

		$sql = $AVE_DB->Query("
			SELECT *
			FROM " . PREFIX . "_modul_shop_versandarten
			WHERE Id = '" . $_REQUEST['Id'] . "'
		");
		$row = $sql->FetchRow();
		$row->VersandLaender = explode(',', $row->LaenderVersand);
		$row->user_group = explode(',', $row->ErlaubteGruppen);

		$oFCKeditor = new FCKeditor('description') ;
		$oFCKeditor->Height = '100';
		$oFCKeditor->ToolbarSet = 'Basic';
		$oFCKeditor->Value = $row->description;
		$row->description = $oFCKeditor->Create();

		$AVE_Template->assign('laender', $this->displayCountries());
		$AVE_Template->assign('gruppen', $this->displayGroups());
		$AVE_Template->assign('ss', $row);
		$AVE_Template->assign('content', $AVE_Template->fetch($tpl_dir . 'shop_shipper_edit.tpl'));
	}

	//=======================================================
	// Versandkosten bearbeiten (Стоимость пересылки)
	//=======================================================
	function editshipperCost($tpl_dir)
	{
		global $AVE_DB, $AVE_Template;

		$close_window = true;
		if (isset($_REQUEST['sub']) && $_REQUEST['sub'] == 'save')
		{
			// Einzelne lцschen
			if (isset($_POST['Del']) && count($_POST['Del']) >= 1)
			{
				foreach ($_POST['Del'] as $id => $Del)
				{
					$AVE_DB->Query("
						DELETE
						FROM " . PREFIX . "_modul_shop_versandkosten
						WHERE Id = '" . $id . "'
					");
				}
			}

			// Neue Werte
			if (!empty($_REQUEST['NeuVon']) && !empty($_REQUEST['NeuBis']) && !empty($_REQUEST['NeuBetrag']))
			{
				$close_window = false;
				foreach ($_POST['NeuVon'] as $land => $NeuVon)
				{
					if (isset($NeuVon) && is_numeric($this->kReplace($NeuVon)) &&
						isset($_POST['NeuBis'][$land]) && is_numeric($this->kReplace($_POST['NeuBis'][$land])) &&
						isset($_POST['NeuBetrag'][$land]) && is_numeric($this->kReplace($_POST['NeuBetrag'][$land])))
					{
						$AVE_DB->Query("
							INSERT " . PREFIX . "_modul_shop_versandkosten
							SET
								VersandId = '" . $_REQUEST['Id'] . "',
								country      = '" . $land . "',
								KVon      = '" . $this->kReplace($NeuVon) . "',
								KBis      = '" . $this->kReplace($_POST['NeuBis'][$land]) . "',
								Betrag    = '" . $this->kReplace($_POST['NeuBetrag'][$land]) . "'
						");
					}
				}
			}

			// Vorhandene Versandkosten aktualisieren
			if (isset($_POST['KVon']))
			{
				foreach ($_POST['KVon'] as $id => $KVon)
				{
					if (isset($KVon) && is_numeric($this->kReplace($KVon)) &&
						isset($_POST['KBis'][$id]) && is_numeric($this->kReplace($_POST['KBis'][$id])) &&
						isset($_POST['Betrag'][$id]) && is_numeric($this->kReplace($_POST['Betrag'][$id])))
					{
						$AVE_DB->Query("
							UPDATE " . PREFIX . "_modul_shop_versandkosten
							SET
								KVon   = '" . $this->kReplace($KVon) . "',
								KBis   = '" . $this->kReplace($_POST['KBis'][$id]) . "',
								Betrag = '" . $this->kReplace($_POST['Betrag'][$id]) . "'
							WHERE
								Id = '" . $id . "'
						");
					}
				}
			}
			if ($close_window == true) echo '<script>window.opener.location.reload(); window.close();</script>';
		}

		$sql = $AVE_DB->Query("
			SELECT *
			FROM " . PREFIX . "_modul_shop_versandarten
			WHERE Id = '" . $_REQUEST['Id'] . "'
		");
		$row = $sql->FetchRow();
		$row->VersandLaender = explode(',', $row->LaenderVersand);
		$AVE_Template->assign('ss', $row);

		$AVE_Template->assign('laender', $this->displayShippingCost($row->VersandLaender, $_REQUEST['Id']));
		$AVE_Template->assign('content', $AVE_Template->fetch($tpl_dir . 'shop_shipper_cost.tpl'));
	}

	//=======================================================
	// Einstellungen E-Mail (Установки E-mail)
	//=======================================================
	function emailSettings($tpl_dir)
	{
		global $AVE_DB, $AVE_Template;

		if (isset($_REQUEST['sub']) && $_REQUEST['sub'] == 'save')
		{
			$AVE_DB->Query("
				UPDATE " . PREFIX . "_modul_shop
				SET
					AdresseText = '" . $_POST['AdresseText'] . "',
					AdresseHTML = '" . $_POST['AdresseHTML'] . "',
					Logo        = '" . $_POST['Logo'] . "',
					EmailFormat = '" . $_POST['EmailFormat'] . "',
					AbsEmail    = '" . chop($_POST['AbsEmail']) . "',
					AbsName     = '" . chop($_POST['AbsName']) . "',
					EmpEmail    = '" . chop($_POST['EmpEmail']) . "',
					BetreffBest = '" . $_POST['BetreffBest'] . "'
				WHERE
					Id = 1
			");
		}

		$sql = $AVE_DB->Query("
			SELECT *
			FROM " . PREFIX . "_modul_shop
			LIMIT 1
		");
		$row = $sql->FetchRow();
		$row->VersandLaender = explode(',', $row->VersandLaender);

		$AVE_Template->assign('row', $row);
		$AVE_Template->assign('laender', $this->displayCountries());
		$AVE_Template->assign('content', $AVE_Template->fetch($tpl_dir . 'shop_settings_email.tpl'));
	}

	//=======================================================
	// Einstellungen (Настройки)
	//=======================================================
	function Settings($tpl_dir)
	{
		global $AVE_DB, $AVE_Template;

		if (isset($_REQUEST['sub']) && $_REQUEST['sub'] == 'save')
		{
			$AVE_DB->Query("
				UPDATE " . PREFIX . "_modul_shop
				SET
					status            = '" . (empty($_POST['status'])            ? '0'   : (int)$_POST['status']) . "',
					Waehrung          = '" . (empty($_POST['Waehrung'])          ? 'RUR' : htmlspecialchars(trim($_POST['Waehrung']))) . "',
					WaehrungSymbol    = '" . (empty($_POST['WaehrungSymbol'])    ? ''    : $_POST['WaehrungSymbol']) . "',
					Waehrung2         = '" . (empty($_POST['Waehrung2'])         ? ''    : $_POST['Waehrung2']) . "',
					WaehrungSymbol2   = '" . (empty($_POST['WaehrungSymbol2'])   ? ''    : $_POST['WaehrungSymbol2']) . "',
					Waehrung2Multi    = '" . (empty($_POST['Waehrung2Multi'])    ? ''    : $this->kreplace($_POST['Waehrung2Multi'])) . "',
					ShopLand          = '" . (empty($_POST['ShopLand'])          ? ''    : htmlspecialchars(strtoupper(trim($_POST['ShopLand'])))) . "',
					ArtikelMax        = '" . ((!empty($_POST['ArtikelMax']) && (int)$_POST['ArtikelMax'] > 2) ? (int)$_POST['ArtikelMax'] : '10') . "',
					KaufLagerNull     = '" . (empty($_POST['KaufLagerNull'])     ? '0'   : (int)$_POST['KaufLagerNull']) . "',
					VersandLaender    = '" . (empty($_POST['VersandLaender'])    ? ''    : implode(',', $_POST['VersandLaender'])) . "',
					VersFrei          = '" . (empty($_POST['VersFrei'])          ? '0'   : (int)$_POST['VersFrei']) . "',
					VersFreiBetrag    = '" . (empty($_POST['VersFreiBetrag'])    ? ''    : str_replace(',','.',$_POST['VersFreiBetrag'])) . "',
					GutscheinCodes    = '" . (empty($_POST['GutscheinCodes'])    ? ''    : $_POST['GutscheinCodes']) . "',
					ZeigeEinheit      = '" . (empty($_POST['ZeigeEinheit'])      ? ''    : $_POST['ZeigeEinheit']) . "',
					ZeigeNetto        = '" . (empty($_POST['ZeigeNetto'])        ? ''    : $_POST['ZeigeNetto']) . "',
					KategorienStart   = '" . (empty($_POST['KategorienStart'])   ? ''    : $_POST['KategorienStart']) . "',
					KategorienSons    = '" . (empty($_POST['KategorienSons'])    ? ''    : $_POST['KategorienSons']) . "',
					ZufallsAngebot    = '" . (empty($_POST['ZufallsAngebot'])    ? ''    : $_POST['ZufallsAngebot']) . "',
					ZufallsAngebotKat = '" . (empty($_POST['ZufallsAngebotKat']) ? ''    : $_POST['ZufallsAngebotKat']) . "',
					BestUebersicht    = '" . (empty($_POST['BestUebersicht'])    ? '0'   : (int)$_POST['BestUebersicht']) . "',
					Merkliste         = '" . (empty($_POST['Merkliste'])         ? ''    : $_POST['Merkliste']) . "',
					Topseller         = '" . (empty($_POST['Topseller'])         ? ''    : $_POST['Topseller']) . "',
					TemplateArtikel   = '" . (empty($_POST['TemplateArtikel'])   ? ''    : $_POST['TemplateArtikel']) . "',
					Vorschaubilder    = '" . (empty($_POST['Vorschaubilder'])    ? '80'  : intval($_POST['Vorschaubilder'])) . "',
					Topsellerbilder   = '" . (empty($_POST['Topsellerbilder'])   ? '40'  : intval($_POST['Topsellerbilder'])) . "',
					GastBestellung    = '" . (empty($_POST['GastBestellung'])    ? '0'   : (int)$_POST['GastBestellung']) . "',
					Kommentare        = '" . (empty($_POST['Kommentare'])        ? ''    : $_POST['Kommentare']) . "',
					KommentareGast    = '" . (empty($_POST['KommentareGast'])    ? ''    : $_POST['KommentareGast']) . "',
					ZeigeWaehrung2    = '" . (empty($_POST['ZeigeWaehrung2'])    ? '0'   : (int)$_POST['ZeigeWaehrung2']) . "',
					ShopKeywords      = '" . (empty($_POST['ShopKeywords'])      ? ''    : htmlspecialchars(trim($_POST['ShopKeywords']))) . "',
					ShopDescription   = '" . (empty($_POST['ShopDescription'])   ? ''    : htmlspecialchars(trim($_POST['ShopDescription']))) . "',
					required_intro    = '" . (empty($_POST['required_intro'])    ? '0'   : (int)$_POST['required_intro']) . "',
					required_desc     = '" . (empty($_POST['required_desc'])     ? '0'   : (int)$_POST['required_desc']) . "',
					required_price    = '" . (empty($_POST['required_price'])    ? '0'   : (int)$_POST['required_price']) . "',
					required_stock    = '" . (empty($_POST['required_stock'])    ? '0'   : (int)$_POST['required_stock']) . "'
				WHERE
					Id = '1'
			");
		}

		$sql = $AVE_DB->Query("
			SELECT *
			FROM " . PREFIX . "_modul_shop
			LIMIT 1
		");
		$row = $sql->FetchRow();
		$row->VersandLaender = explode(',', $row->VersandLaender);

		$AVE_Template->assign('row', $row);
		$AVE_Template->assign('laender', $this->displayCountries());
		$AVE_Template->assign('content', $AVE_Template->fetch($tpl_dir . 'shop_settings.tpl'));
	}

	function settingsYML($tpl_dir)
	{
		global $AVE_DB, $AVE_Template;

		if (isset($_REQUEST['sub']) && $_REQUEST['sub'] == 'save')
		{
			$AVE_DB->Query("
				UPDATE " . PREFIX . "_modul_shop
				SET
					company_name   = '" . (empty($_POST['company_name'])   ? ''  : htmlspecialchars(trim($_POST['company_name']))) . "',
					custom         = '" . (empty($_POST['custom'])         ? '0' : (int)$_POST['custom']) . "',
					delivery       = '" . (empty($_POST['delivery'])       ? '0' : (int)$_POST['delivery']) . "',
					delivery_local = '" . (empty($_POST['delivery_local']) ? '0' : (int)$_POST['delivery_local']) . "',
					downloadable   = '" . (empty($_POST['downloadable'])   ? '0' : (int)$_POST['downloadable']) . "',
					track_label    = '" . (empty($_POST['track_label'])    ? '0' : (int)$_POST['track_label']) . "'
				WHERE
					Id = '1'
			");
		}

		$shipper_times[0] = $AVE_Template->get_config_vars('YML_SelectItem');
		$sql = $AVE_DB->Query("
			SELECT
				Id,
				Name
			FROM " . PREFIX . "_modul_shop_versandzeit
			ORDER BY Name ASC
		");
		while ($row = $sql->FetchAssocArray())
		{
			$shipper_times[$row['Id']] = $row['Name'];
		}

		$shipper_method[0] = $AVE_Template->get_config_vars('YML_SelectItem');
		$sql = $AVE_DB->Query("
			SELECT
				Id,
				Name
			FROM " . PREFIX . "_modul_shop_versandarten
			ORDER BY Name ASC
		");
		while ($row = $sql->FetchAssocArray())
		{
			$shipper_method[$row['Id']] = $row['Name'];
		}

		$sql = $AVE_DB->Query("
			SELECT
				company_name,
				custom,
				delivery,
				delivery_local,
				downloadable,
				track_label
			FROM " . PREFIX . "_modul_shop
			LIMIT 1
		");
		$row = $sql->FetchRow();

		$AVE_Template->assign('row', $row);
		$AVE_Template->assign('shipper_times', $shipper_times);
		$AVE_Template->assign('shipper_method', $shipper_method);
		$AVE_Template->assign('content', $AVE_Template->fetch($tpl_dir . 'shop_settings_yml.tpl'));
	}

	//=======================================================
	// Hilfeseiten bearbeiten (Страница помощи)
	//=======================================================
	function helpPages($tpl_dir)
	{
		global $AVE_DB, $AVE_Template;

		if (isset($_REQUEST['sub']) && $_REQUEST['sub'] == 'save')
		{
			$AVE_DB->Query("
				UPDATE " . PREFIX . "_modul_shop
				SET
					VersandInfo    = '" . (!empty($_POST['VersandInfo']) ? $_POST['VersandInfo'] : '') . "',
					DatenschutzInf = '" . (!empty($_POST['DatenschutzInf']) ? $_POST['DatenschutzInf'] : '') . "',
					Impressum      = '" . (!empty($_POST['Impressum']) ? $_POST['Impressum'] : '') . "',
					ShopWillkommen = '" . (!empty($_POST['ShopWillkommen']) ? $_POST['ShopWillkommen'] : '') . "',
					ShopFuss       = '" . (!empty($_POST['ShopFuss']) ? $_POST['ShopFuss'] : '') . "',
					Agb            = '" . (!empty($_POST['Agb']) ? $_POST['Agb'] : '') . "'
				WHERE
					Id = 1
			");
		}

		$sql = $AVE_DB->Query("
			SELECT *
			FROM " . PREFIX . "_modul_shop
			LIMIT 1
		");
		$row = $sql->FetchRow();

		$oFCKeditor = new FCKeditor('VersandInfo');
		$oFCKeditor->Height = '200';
		$oFCKeditor->ToolbarSet = 'Simple';
		$oFCKeditor->Value= $row->VersandInfo;
		$row->VersandInfo = $oFCKeditor->Create();

		$oFCKeditor = new FCKeditor('DatenschutzInf');
		$oFCKeditor->Height = '200';
		$oFCKeditor->ToolbarSet = 'Simple';
		$oFCKeditor->Value= $row->DatenschutzInf;
		$row->DatenschutzInf = $oFCKeditor->Create();

		$oFCKeditor = new FCKeditor('Impressum');
		$oFCKeditor->Height = '200';
		$oFCKeditor->ToolbarSet = 'Simple';
		$oFCKeditor->Value= $row->Impressum;
		$row->Impressum = $oFCKeditor->Create();

		$oFCKeditor = new FCKeditor('ShopWillkommen');
		$oFCKeditor->Height = '200';
		$oFCKeditor->ToolbarSet = 'Simple';
		$oFCKeditor->Value= $row->ShopWillkommen;
		$row->ShopWillkommen = $oFCKeditor->Create();

		$oFCKeditor = new FCKeditor('ShopFuss');
		$oFCKeditor->Height = '200';
		$oFCKeditor->ToolbarSet = 'Simple';
		$oFCKeditor->Value= $row->ShopFuss;
		$row->ShopFuss = $oFCKeditor->Create();

		$oFCKeditor = new FCKeditor('Agb');
		$oFCKeditor->Height = '200';
		$oFCKeditor->ToolbarSet = 'Simple';
		$oFCKeditor->Value= $row->Agb;
		$row->Agb = $oFCKeditor->Create();

		$AVE_Template->assign('row', $row);
		$AVE_Template->assign('content', $AVE_Template->fetch($tpl_dir . 'shop_settings_help_pages.tpl'));
	}

	//=======================================================
	// Versandkosten (Стоимость пересылки)
	//=======================================================

	// Versandart lцschen
	function deleteMethod($id)
	{
		global $AVE_DB;

		if ($id != 1 && $id != 2 && $id != 3 && $id != 4 && $id != 5)
		{
			$AVE_DB->Query("
				DELETE
				FROM " . PREFIX . "_modul_shop_zahlungsmethoden
				WHERE Id = '" . $id . "'
			");
		}

		header("Location:index.php?do=modules&action=modedit&mod=shop&moduleaction=paymentmethods&cp=" . SESSION);
		exit;
	}

	// Versandarten auslesen
	function displayMethods()
	{
		global $AVE_DB;

		$methods = array();
		$sql = $AVE_DB->Query("
			SELECT *
			FROM " . PREFIX . "_modul_shop_zahlungsmethoden
			ORDER BY Position ASC
		");
		while ($row = $sql->FetchRow()) array_push($methods,$row);

		return $methods;
	}

	// Neue Zahlungsmethode
	function newPaymentMethod()
	{
		global $AVE_DB;

		$AVE_DB->Query("
			INSERT " . PREFIX . "_modul_shop_zahlungsmethoden
			SET Name = '" . $_POST['Name'] . "'
		");

		header("Location:index.php?do=modules&action=modedit&mod=shop&moduleaction=paymentmethods&cp=" . SESSION);
		exit;
	}

	// Versandarten anzeigen & Schnellspeicherung
	function paymentMethods($tpl_dir)
	{
		global $AVE_DB, $AVE_Template;

		if (isset($_REQUEST['sub']) && $_REQUEST['sub'] == 'save')
		{
			foreach ($_POST['Name'] as $id => $Name)
			{
				if (!empty($Name))
				{
					$AVE_DB->Query("
						UPDATE " . PREFIX . "_modul_shop_zahlungsmethoden
						SET
							Name     = '" . $Name . "',
							status   = '" . $_POST['status'][$id] . "',
							Position = '" . $_POST['Position'][$id] . "'
						WHERE
							Id = '" . $id . "'
					");
				}
			}
		}

		$AVE_Template->assign('methods', $this->displayMethods());
		$AVE_Template->assign('content', $AVE_Template->fetch($tpl_dir . 'shop_payment_methods.tpl'));
	}

	// Versandart bearbeiten
	function editPaymentMethod($tpl_dir,$id)
	{
		global $AVE_DB, $AVE_Template;

		if (isset($_REQUEST['sub']) && $_REQUEST['sub'] == 'save')
		{
//			$Icon = '';
			$AVE_DB->Query("
				UPDATE " . PREFIX . "_modul_shop_zahlungsmethoden
				SET
					Name                   = '" . $_POST['Name'] . "',
					description            = '" . $_POST['description'] . "',
					ErlaubteVersandLaender = '" . ((isset($_POST['ErlaubteVersandLaender']) && is_array($_POST['ErlaubteVersandLaender'])) ? implode(',', $_POST['ErlaubteVersandLaender']) : '') . "',
					ErlaubteVersandarten   = '" . ((isset($_POST['ErlaubteVersandarten']) && is_array($_POST['ErlaubteVersandarten'])) ? implode(',', $_POST['ErlaubteVersandarten']) : '') . "',
					ErlaubteGruppen        = '" . ((isset($_POST['ErlaubteGruppen']) && is_array($_POST['ErlaubteGruppen'])) ? implode(',', $_POST['ErlaubteGruppen']) : '') . "',
					status                 = '" . $_POST['status'] . "',
					Kosten                 = '" . $this->kReplace($_POST['Kosten']) . "',
					KostenOperant          = '" . $_POST['KostenOperant'] . "',
					InstId                 = '" . (!empty($_POST['InstId']) ? chop($_POST['InstId']) : '') . "',
					ZahlungsBetreff        = '" . (!empty($_POST['ZahlungsBetreff']) ? $_POST['ZahlungsBetreff'] : '') . "',
					TestModus              = '" . (!empty($_POST['TestModus']) ? chop($_POST['TestModus']) : '') . "',
					Extern                 = '" . (!empty($_POST['Extern']) ? $_POST['Extern'] : '') . "',
					Gateway                = '" . (!empty($_POST['Gateway']) ? chop($_POST['Gateway']) : '') . "'
				WHERE
					Id = '" . $_REQUEST['Id'] . "'
			");

			echo '<script>window.opener.location.reload(); window.close();</script>';
		}

		$sql = $AVE_DB->Query("
			SELECT *
			FROM " . PREFIX . "_modul_shop_zahlungsmethoden
			WHERE Id = '" . $id . "'
		");
		$row = $sql->FetchRow();
		$row->VersandLaender = explode(',', $row->ErlaubteVersandLaender);
		$row->user_group = explode(',', $row->ErlaubteGruppen);
		$row->Versandarten = explode(',', $row->ErlaubteVersandarten);

		$oFCKeditor = new FCKeditor('description') ;
		$oFCKeditor->Height = '200';
		$oFCKeditor->ToolbarSet = 'Basic';
		$oFCKeditor->Value	= $row->description;
		$Edi = $oFCKeditor->Create();

		$AVE_Template->assign('Edi', $Edi);
		$AVE_Template->assign('laender', $this->displayCountries());
		$AVE_Template->assign('gruppen', $this->displayGroups());
		$AVE_Template->assign('shipper', $this->displayShipper());
		$AVE_Template->assign('ss', $row);
		$AVE_Template->assign('content', $AVE_Template->fetch($tpl_dir . 'shop_payment_method_edit.tpl'));
	}

	//=======================================================
	// Versandzeiten (Срок доставки)
	//=======================================================
	function displaySt()
	{
		global $AVE_DB;

		$st = array();
		$sql = $AVE_DB->Query("
			SELECT *
			FROM " . PREFIX . "_modul_shop_versandzeit
			ORDER BY Name ASC
		");
		while ($row = $sql->FetchRow()) array_push($st,$row);

		return $st;
	}

	// Neue Versanndzeit
	function shipperTimeNew()
	{
		global $AVE_DB;

		$AVE_DB->Query("
			INSERT " . PREFIX . "_modul_shop_versandzeit
			SET Name = '" . $_POST['Name'] . "'
		");

		header("Location:index.php?do=modules&action=modedit&mod=shop&moduleaction=timeshipping&cp=" . SESSION);
		exit;
	}

	// Versandzeiten
	function shipperTime($tpl_dir)
	{
		global $AVE_DB, $AVE_Template;

		if (isset($_REQUEST['sub']) && $_REQUEST['sub'] == 'save')
		{
			if (isset($_POST['Del']) && count($_POST['Del']) >= 1)
			{
				foreach ($_POST['Del'] as $id => $Name)
				{
					$AVE_DB->Query("
						DELETE
						FROM " . PREFIX . "_modul_shop_versandzeit
						WHERE Id = '" . $id . "'
					");
				}
			}

			foreach ($_POST['Name'] as $id => $Name)
			{
				if (!empty($Name))
				{
					$AVE_DB->Query("
						UPDATE " . PREFIX . "_modul_shop_versandzeit
						SET Name = '" . $Name . "'
						WHERE Id = '" . $id . "'
					");
				}
			}
		}

		$AVE_Template->assign('st', $this->displaySt());
		$AVE_Template->assign('content', $AVE_Template->fetch($tpl_dir . 'shop_shipper_time.tpl'));
	}

	//=======================================================
	// Produkt - Varianten (Товар - Варианты)
	//=======================================================
	function displayVariantCategories()
	{
		global $AVE_DB;

		$variantCateg = array();
		$sql = $AVE_DB->Query("
			SELECT *
			FROM " . PREFIX . "_modul_shop_varianten_kategorien
			ORDER BY Name ASC
		");
		while ($row = $sql->FetchRow()) array_push($variantCateg,$row);

		return $variantCateg;
	}

	function variantsCategories($tpl_dir)
	{
		global $AVE_DB, $AVE_Template;

		if (isset($_REQUEST['sub']) && $_REQUEST['sub'] == 'save')
		{
			foreach ($_POST['Name'] as $id => $Name)
			{
				if (!empty($Name))
				{
					$AVE_DB->Query("
						UPDATE " . PREFIX . "_modul_shop_varianten_kategorien
						SET
							KatId = '" . $_POST['KatId'][$id] . "',
							Name  = '" . $Name . "',
							status = '" . $_POST['status'][$id] . "'
						WHERE
							Id = '" . $id . "'
					");
				}
			}
		}

		$AVE_Template->assign('ProductCategs', $this->fetchShopNavi(1));
		$AVE_Template->assign('variantCateg', $this->displayVariantCategories());
		$AVE_Template->assign('content', $AVE_Template->fetch($tpl_dir . 'shop_variants.tpl'));
	}

	function newVariantsCategories()
	{
		global $AVE_DB;

		$AVE_DB->Query("
			INSERT " . PREFIX . "_modul_shop_varianten_kategorien
			SET
				Name  = '" . $_POST['Name'] . "',
				KatId = '" . $_POST['KatId'] . "'
		");

		header("Location:index.php?do=modules&action=modedit&mod=shop&moduleaction=variants_categories&cp=" . SESSION);
		exit;
	}

	function editVariantsCategory($tpl_dir,$id)
	{
		global $AVE_DB, $AVE_Template;

		if (isset($_REQUEST['sub']) && $_REQUEST['sub'] == 'save')
		{
			$AVE_DB->Query("
				UPDATE " . PREFIX . "_modul_shop_varianten_kategorien
				SET description = '" . $_POST['description'] . "'
				WHERE Id = '" . $id . "'
			");

			echo '<script>window.close()</script>';
		}

		$sql = $AVE_DB->Query("
			SELECT *
			FROM " . PREFIX . "_modul_shop_varianten_kategorien
			WHERE Id = '" . $id . "'
		");
		$row = $sql->FetchRow();

		$oFCKeditor = new FCKeditor('description') ;
		$oFCKeditor->Height = '400';
		$oFCKeditor->ToolbarSet = 'Simple';
		$oFCKeditor->Value	= $row->description;
		$Edi = $oFCKeditor->Create();

		$AVE_Template->assign('Edi', $Edi);
		$AVE_Template->assign('content', $AVE_Template->fetch($tpl_dir . 'shop_variant_edit.tpl'));
	}

	function deleteVariantsCategory($id)
	{
		global $AVE_DB;

		$AVE_DB->Query("
			DELETE
			FROM " . PREFIX . "_modul_shop_varianten_kategorien
			WHERE Id = '" . $id . "'
		");

		header("Location:index.php?do=modules&action=modedit&mod=shop&moduleaction=variants_categories&cp=" . SESSION);
		exit;
	}

	//=======================================================
	// Produkte (Товар)
	//=======================================================
	function displayProducts($tpl_dir)
	{
		global $AVE_DB, $AVE_Template;

		if (isset($_REQUEST['sub']) && $_REQUEST['sub'] == 'save')
		{
			foreach ($_POST['Preis'] as $id => $Preis)
			{
				$AVE_DB->Query("
					UPDATE " . PREFIX . "_modul_shop_artikel
					SET
						Preis          = '" . $this->kReplace($Preis) . "',
						KatId          = '" . $_POST['KatId'][$id] . "',
						Lager          = '" . (int)$_POST['Lager'][$id] . "',
						Bestellungen   = '" . (int)$_POST['Bestellungen'][$id] . "',
						PosiStartseite = '" . (int)$_POST['PosiStartseite'][$id] . "'
					WHERE
						Id = '" . $id . "'
				");
			}

			$dbAct = '';
			reset ($_POST);
			while (list($key,/*$val*/) = each($_POST))
			{
				if (isset($_REQUEST['SubAction']) && $_REQUEST['SubAction'] != 'nothing')
				{
					switch ($_REQUEST['SubAction'])
					{
						case 'close':
							$dbAct = "SET status = '0'";
							break;

						case 'open':
							$dbAct = "SET status = '1'";
							break;

						case 'del':
							$dbAct = "del";
							break;

						case '':
						default:
							$dbAct = '';
							break;
					}
				}

				if (mb_substr($key,0,12) == "shopartikel_" && $dbAct != '')
				{
					$aktid = str_replace("shopartikel_","",$key);
					if ($dbAct == 'del')
					{
						$AVE_DB->Query("
							DELETE
							FROM " . PREFIX . "_modul_shop_artikel
							WHERE Id = '" . $aktid . "'
						");
					}
					else
					{
						$AVE_DB->Query("
							UPDATE " . PREFIX . "_modul_shop_artikel
							" . $dbAct . "
							WHERE Id = '" . $aktid . "'
						");
					}
				}
			}

			header("Location:index.php?do=modules&action=modedit&mod=shop&moduleaction=products&cp=" . SESSION);
			exit;
		}

		$AVE_Template->assign('products', $this->lastArticles());
		$AVE_Template->assign('ProductCategs', $this->fetchShopNavi(1));
		$AVE_Template->assign('Manufacturer', $this->displayManufacturer());
		$AVE_Template->assign('content', $AVE_Template->fetch($tpl_dir . 'shop_products.tpl'));
	}

	//=======================================================
	// Einheiten (Единицы)
	//=======================================================
	function Units($tpl_dir)
	{
		global $AVE_DB, $AVE_Template;

		// Speichern
		if (isset($_REQUEST['sub']) && $_REQUEST['sub'] == 'save')
		{
			foreach ($_POST['Name'] as $id => $Name)
			{
				$AVE_DB->Query("
					UPDATE " . PREFIX . "_modul_shop_einheiten
					SET
						Name        = '" . $Name . "',
						NameEinzahl = '" . $_POST['NameEinzahl'][$id] . "'
					WHERE
						Id = '" . $id . "'
				");
			}

			// Einzelne EInheit lцschen
			if (isset($_POST['Del']) && $_POST['Del'] >= 1)
			{
				foreach ($_POST['Del'] as $id => $Del)
				{
					$AVE_DB->Query("
						DELETE
						FROM " . PREFIX . "_modul_shop_einheiten
						WHERE Id = '" . $id . "'
					");
				}
			}
		}

		$Units = array();
		$sql = $AVE_DB->Query("
			SELECT *
			FROM " . PREFIX . "_modul_shop_einheiten
			ORDER BY Name ASC
		");
		while ($row = $sql->FetchRow())
		{
			array_push($Units, $row);
		}

		$AVE_Template->assign('Units', $Units);
		$AVE_Template->assign('content', $AVE_Template->fetch($tpl_dir . 'shop_units.tpl'));
	}

	// Neue Einheit
	function UnitsNew()
	{
		global $AVE_DB;

		$AVE_DB->Query("
			INSERT " . PREFIX . "_modul_shop_einheiten
			SET
				Name        = '" . $_POST['NameEinzahl'] . "',
				NameEinzahl = '" . $_POST['NameEinzahl'] . "'
		");

		header("Location:index.php?do=modules&action=modedit&mod=shop&moduleaction=units&cp=" . SESSION);
		exit;
	}

	//=======================================================
	// Hersteller (Производитель)
	//=======================================================
	function Manufacturer($tpl_dir)
	{
		global $AVE_DB, $AVE_Template;

		// Speichern
		if (isset($_REQUEST['sub']) && $_REQUEST['sub'] == 'save')
		{
			foreach ($_POST['Name'] as $id => $Name)
			{
				$AVE_DB->Query("
					UPDATE " . PREFIX . "_modul_shop_hersteller
					SET
						Name = '" . $Name . "',
						Logo = '" . $_POST['Logo'][$id] . "',
						Link = '" . $_POST['Link'][$id] . "'
					WHERE
						Id = '" . $id . "'
				");
			}

			// Hersteller lцschen
			if (isset($_POST['Del']) && $_POST['Del'] >= 1)
			{
				foreach ($_POST['Del'] as $id => $Del)
				{
					$AVE_DB->Query("
						DELETE
						FROM " . PREFIX . "_modul_shop_hersteller
						WHERE Id = '" . $id . "'
					");
				}
			}
		}

		$Manufacturer = array();
		$sql = $AVE_DB->Query("
			SELECT *
			FROM " . PREFIX . "_modul_shop_hersteller
			ORDER BY Name ASC
		");
		while ($row = $sql->FetchRow())
		{
			array_push($Manufacturer, $row);
		}

		$AVE_Template->assign('Manufacturer', $Manufacturer);
		$AVE_Template->assign('content', $AVE_Template->fetch($tpl_dir . 'shop_manufacturer.tpl'));
	}

	// Neuer Hersteller
	function ManufacturerNew()
	{
		global $AVE_DB;

		$AVE_DB->Query("
			INSERT " . PREFIX . "_modul_shop_hersteller
			SET
				Name = '" . $_POST['Name'] . "',
				Logo = '" . $_POST['Logo'] . "',
				Link = '" . $_POST['Link'] . "'
		");

		header("Location:index.php?do=modules&action=modedit&mod=shop&moduleaction=manufacturer&cp=" . SESSION);
		exit;
	}

	//=======================================================
	// Produktvarianten zuweisen (Варианты товаров)
	//=======================================================
	function prouctVars($tpl_dir,$product_id,$kat_id)
	{
		global $AVE_DB, $AVE_Template;

		if (isset($_REQUEST['sub']) && $_REQUEST['sub'] == 'save')
		{
			if (isset($_POST['NameNew']) && count($_POST['NameNew']) >= 1)
			{
				foreach ($_POST['NameNew'] as $id => $NameNew)
				{
					if (!empty($NameNew))
					{
						$AVE_DB->Query("
							INSERT " . PREFIX . "_modul_shop_varianten
							SET
								KatId    = '" . $id . "',
								ArtId    = '" . $_REQUEST['Id'] . "',
								Name     = '" . $NameNew . "',
								Wert     = '" . $this->kReplace(chop($_REQUEST['WertNew'][$id])) . "',
								Operant  = '" . $_REQUEST['OperantNew'][$id] . "',
								Position = '" . $_REQUEST['PositionNew'][$id] . "'
						");
					}
				}
			}

			// Varianten - Kategorienamen aktualisieren
			// Varianten aktualisieren
			if (!empty($_POST['Name']))
			{
				foreach ($_POST['Name'] as $id => $Name)
				{
					$AVE_DB->Query("
						UPDATE " . PREFIX . "_modul_shop_varianten
						SET
							Name     = '" . $Name . "',
							Operant  = '" . $_POST['Operant'][$id] . "',
							Wert     = '" . $_POST['Wert'][$id] . "',
							Position = '" . $_POST['Position'][$id] . "'
						WHERE
							Id = '" . $id . "'
					");
				}
			}

			// Varianten - Positionen lцschen
			if (!empty($_POST['Del']))
			{
				foreach ($_POST['Del'] as $id => $Name)
				{
					$AVE_DB->Query("
						DELETE
						FROM " . PREFIX . "_modul_shop_varianten
						WHERE Id = '" . $id . "'
					");
				}
			}
		}

		//NameVar
		$Vars = array();
		$sql = $AVE_DB->Query("
			SELECT *
			FROM " . PREFIX . "_modul_shop_varianten_kategorien
			WHERE KatId = '" . $kat_id . "'
		");
		while ($row = $sql->FetchRow())
		{
			$SubVars = array();
			$sql_v = $AVE_DB->Query("
				SELECT *
				FROM " . PREFIX . "_modul_shop_varianten
				WHERE ArtId = '" . $product_id . "'
				AND KatId = '" . $row->Id . "'
				ORDER BY Position ASC
			");
			while ($row_v = $sql_v->FetchRow())
			{
				array_push($SubVars, $row_v);
			}

			$row->SubVars = $SubVars;
			array_push($Vars, $row);
		}
		$AVE_Template->assign('Vars', $Vars);
		$AVE_Template->assign('content', $AVE_Template->fetch($tpl_dir . 'shop_product_vars.tpl'));
	}

	//=======================================================
	// Produkt bearbeiten (Редактирование товара)
	//=======================================================
	/**
	 * Редактировать товар
	 *
	 * @param string $tpl_dir путь к шаблонам модуля авторизации
	 * @param int $id идентификатор товара
	 */
	function editProduct($tpl_dir,$id)
	{
		global $AVE_DB, $AVE_Template, $config_vars;

		if (isset($_REQUEST['sub']) && $_REQUEST['sub'] == 'save')
		{
			$endung = '';
			$DbNewImage = '';
//			$DbBilder = '';

			// Wenn neues Bild gespeichert werden soll
			if (!empty($_FILES['Bild']['tmp_name']))
			{
				$upload_dir = BASE_DIR . '/modules/shop/uploads/';
				$name = str_replace(array(' ', '+','-'),'_',mb_strtolower($_FILES['Bild']['name']));
				$name = preg_replace("/__+/", "_", $name);
//				$temp = $_FILES['Bild']['tmp_name'];
				$endung = mb_strtolower(mb_substr($name, -3));
				$fupload_name = $name;

				if (in_array($_FILES['Bild']['type'], $this->_allowed_images))
				{
					// Wenn Bild existiert, Bild umbenennen
					if (file_exists($upload_dir . $fupload_name))
					{
						$fupload_name = $this->renameFile($fupload_name);
						$name = $fupload_name;
					}

					// Bild hochladen
					@move_uploaded_file($_FILES['Bild']['tmp_name'], $upload_dir . $fupload_name);
					@chmod($upload_dir . $fupload_name, 0777);

					// Altes Bild lцschen
					@unlink($upload_dir . $_REQUEST['del_old']);

					$DbNewImage = "Bild = '" . $fupload_name . "', Bild_Typ = '" . $endung . "',";
				}
			}
			elseif (!empty($_POST['del_img']) && $_POST['del_img'] == 1)
			{
				@unlink($upload_dir . $_REQUEST['del_old']);
					$DbNewImage = "Bild = '', Bild_Typ = '',";
			}

			// Weitere Bilder
			if (!empty($_FILES['file']['tmp_name']) && count(@$_FILES['file']['tmp_name']) >= 1)
			{
				$fupload_name = '';
				$upload_dir = BASE_DIR . '/modules/shop/uploads/';

				for ($i=0;$i<count(@$_FILES['file']['tmp_name']);$i++)
				{
//					$size = $_FILES['file']['size'][$i];
					$name = str_replace(array(' ', '+','-'),'_',mb_strtolower($_FILES['file']['name'][$i]));
					$name = preg_replace("/__+/", "_", $name);
//					$temp = $_FILES['file']['tmp_name'][$i];
					$fupload_name = $name;

					if (file_exists($upload_dir . $fupload_name))
					{
						$fupload_name = $this->renameFile($fupload_name);
						$name = $fupload_name;
					}

					if (!empty($name) && in_array($_FILES['file']['type'][$i], $this->_allowed_images) )
					{
						@move_uploaded_file($_FILES['file']['tmp_name'][$i], $upload_dir . $fupload_name);
						@chmod($upload_dir . $fupload_name, 0777);
						$AVE_DB->Query("
							INSERT " . PREFIX . "_modul_shop_artikel_bilder
							SET
								ArtId = '" . $_REQUEST['Id'] . "',
								Bild = '" . $fupload_name . "'
						");
					}
				}
			}

			// Eventuelle Bilder lцschen
			if (isset($_POST['del_multi']) && count($_POST['del_multi']) >= 1)
			{
				$upload_dir = BASE_DIR . '/modules/shop/uploads/';
				foreach ($_POST['del_multi'] as $did => $del_multi)
				{
					$sql_del = $AVE_DB->Query("
						SELECT Bild
						FROM " . PREFIX . "_modul_shop_artikel_bilder
						WHERE Id = '" . $did . "'
					");
					$row_del = $sql_del->FetchRow();
					@unlink($upload_dir . $row_del->Bild);
					$AVE_DB->Query("
						DELETE
						FROM " . PREFIX . "_modul_shop_artikel_bilder
						WHERE Id = '" . $did . "'
					");
				}
			}

			$q = "
				UPDATE " . PREFIX . "_modul_shop_artikel
				SET
					ArtNr           = '" . (empty($_POST['ArtNr']) ? '' : chop($_POST['ArtNr'])) . "',
					" . $DbNewImage . "
					Artname         = '" . chop($_POST['ArtName']) . "',
					status          = '" . (empty($_POST['status']) ? '0' : (int)$_POST['status']) . "',
					KatId           = '" . (empty($_POST['KatId']) ? '0' : (int)$_POST['KatId']) . "',
					KatId_Multi     = '" . (empty($_POST['KatId_Multi']) ? '' : implode(',', $_POST['KatId_Multi'])) . "',
					TextKurz        = '" . chop($_POST['TextKurz']) . "',
					TextLang        = '" . chop($_POST['TextLang']) . "',
					Schlagwoerter   = '" . chop($_POST['Schlagwoerter']) . "',
					Preis           = '" . $this->kReplace(chop($_POST['Preis'])) . "',
					PreisListe      = '" . $this->kReplace(chop($_POST['PreisListe'])) . "',
					Gewicht         = '" . $this->kReplace(chop($_POST['Gewicht'])) . "',
					UstZone         = '" . ((!empty($_POST['UstZone']) && is_numeric($_POST['UstZone'])) ? $_POST['UstZone'] : '0') . "',
					Hersteller      = '" . ((!empty($_POST['Hersteller']) && is_numeric($_POST['Hersteller'])) ? $_POST['Hersteller'] : '') . "',
					Einheit         = '" . $this->kReplace(chop($_POST['Einheit'])) . "',
					EinheitId       = '" . $_POST['EinheitId'] . "',
					Lager           = '" . chop($_POST['Lager']) . "',
					VersandZeitId   = '" . $_POST['VersandZeitId'] . "',
					Erschienen      = '" . mktime(0, 0, 0, $_POST['ErschMonth'], $_POST['ErschDay'], $_POST['ErschYear']) . "',
					Angebot         = '" . $_POST['Angebot'] . "',
					Frei_Titel_1    = '" . (empty($_POST['Frei_Titel_1'])    ? '' : $_POST['Frei_Titel_1']) . "',
					Frei_Titel_2    = '" . (empty($_POST['Frei_Titel_2'])    ? '' : $_POST['Frei_Titel_2']) . "',
					Frei_Titel_3    = '" . (empty($_POST['Frei_Titel_3'])    ? '' : $_POST['Frei_Titel_3']) . "',
					Frei_Titel_4    = '" . (empty($_POST['Frei_Titel_4'])    ? '' : $_POST['Frei_Titel_4']) . "',
					Frei_Text_1     = '" . (empty($_POST['Frei_Text_1'])     ? '' : $_POST['Frei_Text_1']) . "',
					Frei_Text_2     = '" . (empty($_POST['Frei_Text_2'])     ? '' : $_POST['Frei_Text_2']) . "',
					Frei_Text_3     = '" . (empty($_POST['Frei_Text_3'])     ? '' : $_POST['Frei_Text_3']) . "',
					Frei_Text_4     = '" . (empty($_POST['Frei_Text_4'])     ? '' : $_POST['Frei_Text_4']) . "',
					DateiDownload   = '" . (empty($_POST['DateiDownload'])   ? '' : $_POST['DateiDownload']) . "',
					AngebotBild     = '" . (empty($_POST['AngebotBild'])     ? '' : $_POST['AngebotBild']) . "',
					ProdKeywords    = '" . (empty($_POST['ProdKeywords'])    ? '' : $_POST['ProdKeywords']) . "',
					ProdDescription = '" . (empty($_POST['ProdDescription']) ? '' : $_POST['ProdDescription']) . "',
					bid             = '" . ((!empty($_POST['bid']) && is_numeric($_POST['bid'])) ? $_POST['bid'] : '0') . "',
					cbid            = '" . ((!empty($_POST['cbid']) && is_numeric($_POST['cbid'])) ? $_POST['cbid'] : '0') . "'
				WHERE
					Id = '" . $_REQUEST['Id'] . "'
			";

			$errors = '';

			$regex = '/[^\x20-\xFF]/';
			$regex_no_space = '/[^\x21-\xFF]/';
			if (empty($_POST['ArtName']) || preg_match($regex, $_POST['ArtName']))
				$errors[] = $GLOBALS['config_vars']['ProductNewPCheck'] . $GLOBALS['config_vars']['ProductName'];
			if (empty($_POST['ArtNr']) || preg_match($regex_no_space, $_POST['ArtNr']))
				$errors[] = $GLOBALS['config_vars']['ProductNewPCheck'] . $GLOBALS['config_vars']['ProductNrS'];
			if ((!empty($_POST['ArtNr']) && $_POST['ArtNr'] != $_POST['ArtNrOld'] && !$this->_checkArtNumber($_POST['ArtNr'])))
				$errors[] = $GLOBALS['config_vars']['ProductNewArtnumberUnique'];
			if ($this->_getShopSetting('required_intro') && (empty($_POST['TextKurz']) || $_POST['TextKurz'] == '<br />'))
				$errors[] = $GLOBALS['config_vars']['ProductNewPCheck'] . $GLOBALS['config_vars']['ProductTs'];
			if ($this->_getShopSetting('required_desc') && (empty($_POST['TextLang']) || $_POST['TextLang'] == '<br />'))
				$errors[] = $GLOBALS['config_vars']['ProductNewPCheck'] . $GLOBALS['config_vars']['ProductTl'];
			if ($this->_getShopSetting('required_price') && empty($_POST['Preis']) || (!empty($_POST['Preis']) && !is_numeric($this->kReplace($_POST['Preis']))))
				$errors[] = $GLOBALS['config_vars']['ProductNewPCheck'] . $GLOBALS['config_vars']['ProductPrice'];
			if ($this->_getShopSetting('required_stock') && empty($_POST['Lager']) || (!empty($_POST['Lager']) && !is_numeric($this->kReplace($_POST['Lager']))))
				$errors[] = $GLOBALS['config_vars']['ProductNewPCheck'] . $GLOBALS['config_vars']['ProductStored'];
			if (!empty($_FILES['Bild']['tmp_name']) && (!in_array($_FILES['Bild']['type'], $this->_allowed_images)) )
				$errors[] = $GLOBALS['config_vars']['ProductNewVorbittenImage'];

			// Fehler
			if (is_array($errors))
			{
				$AVE_Template->assign('errors', $errors);
			}
			// Speichern
			else
			{
				$AVE_DB->Query($q);

				echo '<script>window.opener.location.reload(); window.close();</script>';
			}
		}

		$sql = $AVE_DB->Query("
			SELECT *
			FROM " . PREFIX . "_modul_shop_artikel
			WHERE Id = '" . $id . "'
		");
		$row = $sql->FetchAssocArray();

		$MultiImages = array();
		$sql_bilder = $AVE_DB->Query("
			SELECT *
			FROM " . PREFIX . "_modul_shop_artikel_bilder
			WHERE ArtId = '" . $row['Id'] . "'
		");
		while ($row_bilder = $sql_bilder->FetchRow())
		{
			array_push($MultiImages, $row_bilder);
		}
		$row['BilderMulti'] = $MultiImages;

		if (!empty($row['Bild']) && file_exists(BASE_DIR . '/modules/shop/uploads/' . $row['Bild'])) $row['BildFehler'] = 1;

		$KatIds = explode(',', $row['KatId_Multi']);

		$oFCKeditor = new FCKeditor('TextLang'); $oFCKeditor->Height = '300'; $oFCKeditor->ToolbarSet = 'Simple'; $oFCKeditor->Value = $row['TextLang']; $Lang = $oFCKeditor->Create();
		$oFCKeditor = new FCKeditor('TextKurz'); $oFCKeditor->Height = '150'; $oFCKeditor->ToolbarSet = 'Basic'; $oFCKeditor->Value	= $row['TextKurz']; $Kurz = $oFCKeditor->Create();

		$oFCKeditor = new FCKeditor('Frei_Text_1'); $oFCKeditor->Height = '150'; $oFCKeditor->ToolbarSet = 'Basic'; $oFCKeditor->Value	= $row['Frei_Text_1']; $Frei1 = $oFCKeditor->Create();
		$oFCKeditor = new FCKeditor('Frei_Text_2'); $oFCKeditor->Height = '150'; $oFCKeditor->ToolbarSet = 'Basic'; $oFCKeditor->Value	= $row['Frei_Text_2']; $Frei2 = $oFCKeditor->Create();
		$oFCKeditor = new FCKeditor('Frei_Text_3'); $oFCKeditor->Height = '150'; $oFCKeditor->ToolbarSet = 'Basic'; $oFCKeditor->Value	= $row['Frei_Text_3']; $Frei3 = $oFCKeditor->Create();
		$oFCKeditor = new FCKeditor('Frei_Text_4'); $oFCKeditor->Height = '150'; $oFCKeditor->ToolbarSet = 'Basic'; $oFCKeditor->Value	= $row['Frei_Text_4']; $Frei4 = $oFCKeditor->Create();

		$AVE_Template->assign('Frei1', $Frei1);
		$AVE_Template->assign('Frei2', $Frei2);
		$AVE_Template->assign('Frei3', $Frei3);
		$AVE_Template->assign('Frei4', $Frei4);

		$AVE_Template->assign('Kurz', $Kurz);
		$AVE_Template->assign('Lang', $Lang);
		$AVE_Template->assign('row', $row);
		$AVE_Template->assign('KatIds', $KatIds);
		$AVE_Template->assign('VatZones', $this->fetchVatZones());
		$AVE_Template->assign('Manufacturer', $this->displayManufacturer());
		$AVE_Template->assign('Units', $this->displayUnits());
		$AVE_Template->assign('ShippingTime', $this->shippingTime());
		$AVE_Template->assign('ProductCategs', $this->fetchShopNavi(1));
		$AVE_Template->assign('esds', $this->fetchEsdFiles());
		$AVE_Template->assign('content', $AVE_Template->fetch($tpl_dir . 'shop_product_edit.tpl'));
	}

	/**
	 * Проверка артикула товара на уникальность
	 *
	 * @param string $artnumber артикул
	 * @return boolean true - артикул уникален, false - артикул уже используется
	 */
	function _checkArtNumber($artnumber)
	{
		global $AVE_DB;

		$sql = $AVE_DB->Query("
			SELECT ArtNr
			FROM " . PREFIX . "_modul_shop_artikel
			WHERE ArtNr = '" . $artnumber . "'
			LIMIT 1
		");
		$num = $sql->NumRows();

		if ($num == 1) return false;

		return true;
	}

	/**
	 * Добавить новый товар
	 *
	 * @param string $tpl_dir путь к шаблонам
	 */
	function newProduct($tpl_dir)
	{
		global $AVE_DB, $AVE_Template, $config_vars;

		// Speichern
		if (isset($_REQUEST['sub']) && $_REQUEST['sub'] == 'save')
		{
			$DbImage = '';
			$MultiBilder = '';
			$errors = '';

			$regex = '/[^\x20-\xFF]/';
			$regex_no_space = '/[^\x21-\xFF]/';
			if (empty($_POST['ArtName']) || preg_match($regex, $_POST['ArtName']))
				$errors[] = $GLOBALS['config_vars']['ProductNewPCheck'] . $GLOBALS['config_vars']['ProductName'];
			if (empty($_POST['ArtNr']) || preg_match($regex_no_space, $_POST['ArtNr']))
				$errors[] = $GLOBALS['config_vars']['ProductNewPCheck'] . $GLOBALS['config_vars']['ProductNrS'];
			if (!empty($_POST['ArtNr']) && !$this->_checkArtNumber($_POST['ArtNr']))
				$errors[] = $GLOBALS['config_vars']['ProductNewArtnumberUnique'];
			if ($this->_getShopSetting('required_intro') && (empty($_POST['TextKurz']) || (!empty($_POST['TextKurz']) && $_POST['TextKurz'] == '<br />')))
				$errors[] = $GLOBALS['config_vars']['ProductNewPCheck'] . $GLOBALS['config_vars']['ProductTs'];
			if ($this->_getShopSetting('required_desc') && (empty($_POST['TextLang']) || (!empty($_POST['TextLang']) && $_POST['TextLang'] == '<br />')))
				$errors[] = $GLOBALS['config_vars']['ProductNewPCheck'] . $GLOBALS['config_vars']['ProductTl'];
			if ($this->_getShopSetting('required_price') && empty($_POST['Preis']) || (!empty($_POST['Preis']) && !is_numeric($_POST['Preis'])))
				$errors[] = $GLOBALS['config_vars']['ProductNewPCheck'] . $GLOBALS['config_vars']['ProductPrice'];
			if ($this->_getShopSetting('required_stock') && empty($_POST['Lager']) || (!empty($_POST['Lager']) && !is_numeric($_POST['Lager'])))
				$errors[] = $GLOBALS['config_vars']['ProductNewPCheck'] . $GLOBALS['config_vars']['ProductStored'];
			if (!empty($_FILES['Bild']['tmp_name']) && (!in_array($_FILES['Bild']['type'], $this->_allowed_images)))
				$errors[] = $GLOBALS['config_vars']['ProductNewVorbittenImage'];

			// Fehler
			if (is_array($errors))
			{
				$AVE_Template->assign('errors', $errors);
			}
			// Speichern
			else
			{
				// Bildupload
				if (!empty($_FILES['Bild']['tmp_name']))
				{
					$upload_dir = BASE_DIR . '/modules/shop/uploads/';
					$name = str_replace(array(' ', '+', '-'), '_', mb_strtolower($_FILES['Bild']['name']));
					$name = preg_replace("/__+/", "_", $name);
//					$temp = $_FILES['Bild']['tmp_name'];
//					$endung = mb_strtolower(mb_substr($name, -3));
					$fupload_name = $name;

					if (in_array($_FILES['Bild']['type'], $this->_allowed_images))
					{
						// Wenn Bild existiert, Bild umbenennen
						if (file_exists($upload_dir . $fupload_name))
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

				// Weitere Bilder
				if (isset($_FILES) && count(@$_FILES['file']['tmp_name']) >= 1 && $_FILES['file']['tmp_name'] != '')
				{
					$fupload_name = '';
					$upload_dir = BASE_DIR . '/modules/shop/uploads/';

					for ($i=0;$i<count(@$_FILES['file']['tmp_name']);$i++)
					{
//						$size = $_FILES['file']['size'][$i];
						$name = str_replace(array(' ', '+','-'),'_',mb_strtolower($_FILES['file']['name'][$i]));
						$name = preg_replace("/__+/", "_", $name);
//						$temp = $_FILES['file']['tmp_name'][$i];
						$fupload_name = $name;

						if (file_exists($upload_dir . $fupload_name))
						{
							$fupload_name = $this->renameFile($fupload_name);
							$name = $fupload_name;
						}

						if (!empty($name) && in_array($_FILES['file']['type'][$i], $this->_allowed_images) )
						{
							@move_uploaded_file($_FILES['file']['tmp_name'][$i], $upload_dir . $fupload_name);
							@chmod($upload_dir . $fupload_name, 0777);
							$MultiBilder[] = $fupload_name;
						}
					}
				}
				// Eintrag in die DB
				$AVE_DB->Query("
					INSERT " . PREFIX . "_modul_shop_artikel
					SET
						ArtNr           = '" . (!empty($_POST['ArtNr']) ? chop($_POST['ArtNr']) : '') . "',
						KatId           = '" . $_POST['KatId'] . "',
						KatId_Multi     = '" . implode(',', $_POST['KatId_Multi']) . ",',
						Artname         = '" . chop($_POST['ArtName']) . "',
						status          = '1',
						Preis           = '" . $this->kReplace(chop($_POST['Preis'])) . "',
						PreisListe      = '" . $this->kReplace(chop($_POST['PreisListe'])) . "',
						Bild            = '" . $DbImage . "',
						Bild_Typ        = '" . (!empty($DbImage) ? mb_substr($_FILES['Bild']['name'], -3) : '') . "',
						TextKurz        = '" . chop($_POST['TextKurz']) . "',
						TextLang        = '" . chop($_POST['TextLang']) . "',
						Gewicht         = '" . $this->kReplace(chop($_POST['Gewicht'])) . "',
						Angebot         = '" . $_POST['Angebot'] . "',
						UstZone         = '" . $_POST['UstZone'] . "',
						Erschienen      = '" . mktime(0,0,0,$_POST['ErschMonth'],$_POST['ErschDay'],$_POST['ErschYear']) . "',
						Frei_Titel_1    = '" . (!empty($_POST['Frei_Titel_1']) ? $_POST['Frei_Titel_1'] : '') . "',
						Frei_Titel_2    = '" . (!empty($_POST['Frei_Titel_2']) ? $_POST['Frei_Titel_2'] : '') . "',
						Frei_Titel_3    = '" . (!empty($_POST['Frei_Titel_3']) ? $_POST['Frei_Titel_3'] : '') . "',
						Frei_Titel_4    = '" . (!empty($_POST['Frei_Titel_4']) ? $_POST['Frei_Titel_4'] : '') . "',
						Frei_Text_1     = '" . (!empty($_POST['Frei_Text_1']) ? $_POST['Frei_Text_1'] : '') . "',
						Frei_Text_2     = '" . (!empty($_POST['Frei_Text_2']) ? $_POST['Frei_Text_2'] : '') . "',
						Frei_Text_3     = '" . (!empty($_POST['Frei_Text_3']) ? $_POST['Frei_Text_3'] : '') . "',
						Frei_Text_4     = '" . (!empty($_POST['Frei_Text_4']) ? $_POST['Frei_Text_4'] : '') . "',
						Hersteller      = '" . (!empty($_POST['Hersteller']) ? $_POST['Hersteller'] : '') . "',
						Schlagwoerter   = '" . (!empty($_POST['Schlagwoerter']) ? chop($_POST['Schlagwoerter']) : '') . "',
						Einheit         = '" . $this->kReplace(chop($_POST['Einheit'])) . "',
						EinheitId       = '" . (!empty($_POST['EinheitId']) ? $_POST['EinheitId'] : '') . "',
						Lager           = '" . chop($_POST['Lager']) . "',
						VersandZeitId   = '" . $_POST['VersandZeitId'] . "',
						DateiDownload   = '" . (!empty($_POST['DateiDownload']) ? $_POST['DateiDownload'] : '') . "',
						AngebotBild     = '" . (!empty($_POST['AngebotBild']) ? $_POST['AngebotBild'] : '') . "',
						ProdKeywords    = '" . (!empty($_POST['ProdKeywords']) ? $_POST['ProdKeywords'] : '') . "',
						ProdDescription = '" . (!empty($_POST['ProdDescription']) ? $_POST['ProdDescription'] : '') . "',
						bid             = '" . ((!empty($_POST['bid']) && is_numeric($_POST['bid'])) ? $_POST['bid'] : '0') . "',
						cbid            = '" . ((!empty($_POST['cbid']) && is_numeric($_POST['cbid'])) ? $_POST['cbid'] : '0') . "'
				");
				// ID des neuen Artikels
				$iid = $AVE_DB->InsertId();

				// Weitere Bilder speichern
				if (isset($MultiBilder) && is_array($MultiBilder) && count($MultiBilder) >= 1)
				{
					foreach ($MultiBilder as $bild)
					{
						$AVE_DB->Query("
							INSERT " . PREFIX . "_modul_shop_artikel_bilder
							SET
								ArtId = '" . $iid . "',
								Bild  = '" . $bild . "'
						");
					}
				}

				// Fenster schliessen...
				echo '<script>window.opener.location.reload(); window.close();</script>';
			}
		}

		// Form anzeigen
		$oFCKeditor = new FCKeditor('TextLang'); $oFCKeditor->Height = '300'; $oFCKeditor->ToolbarSet = 'Simple'; $oFCKeditor->Value = @$_POST['TextLang']; $Lang = $oFCKeditor->Create();
		$oFCKeditor = new FCKeditor('TextKurz'); $oFCKeditor->Height = '150'; $oFCKeditor->ToolbarSet = 'Basic';  $oFCKeditor->Value = @$_POST['TextKurz']; $Kurz = $oFCKeditor->Create();

		$oFCKeditor = new FCKeditor('Frei_Text_1'); $oFCKeditor->Height = '150'; $oFCKeditor->ToolbarSet = 'Basic'; $oFCKeditor->Value = @$_POST['Frei_Text_1']; $Frei1 = $oFCKeditor->Create();
		$oFCKeditor = new FCKeditor('Frei_Text_2'); $oFCKeditor->Height = '150'; $oFCKeditor->ToolbarSet = 'Basic'; $oFCKeditor->Value = @$_POST['Frei_Text_2']; $Frei2 = $oFCKeditor->Create();
		$oFCKeditor = new FCKeditor('Frei_Text_3'); $oFCKeditor->Height = '150'; $oFCKeditor->ToolbarSet = 'Basic'; $oFCKeditor->Value = @$_POST['Frei_Text_3']; $Frei3 = $oFCKeditor->Create();
		$oFCKeditor = new FCKeditor('Frei_Text_4'); $oFCKeditor->Height = '150'; $oFCKeditor->ToolbarSet = 'Basic'; $oFCKeditor->Value = @$_POST['Frei_Text_4']; $Frei4 = $oFCKeditor->Create();

		$AVE_Template->assign('Frei1', $Frei1);
		$AVE_Template->assign('Frei2', $Frei2);
		$AVE_Template->assign('Frei3', $Frei3);
		$AVE_Template->assign('Frei4', $Frei4);

		$AVE_Template->assign('Kurz', $Kurz);
		$AVE_Template->assign('Lang', $Lang);
		$AVE_Template->assign('VatZones', $this->fetchVatZones());
		$AVE_Template->assign('Manufacturer', $this->displayManufacturer());
		$AVE_Template->assign('Units', $this->displayUnits());
		$AVE_Template->assign('ShippingTime', $this->shippingTime());
		$AVE_Template->assign('ProductCategs', $this->fetchShopNavi(1));
		$AVE_Template->assign('content', $AVE_Template->fetch($tpl_dir . 'shop_product_new.tpl'));

	}

	//=======================================================
	// Export (Экспорт)
	//=======================================================
	function dataExport($tpl_dir)
	{
		global $AVE_DB, $AVE_Template;

		if (isset($_REQUEST['sub']) && $_REQUEST['sub'] == 'export')
		{
			require_once(BASE_DIR . '/modules/shop/class.export.php');

			$export = new DataExport();

			switch ($_REQUEST['t'])
			{
				case 'orders':
					$table = 'orders';
					$Prefab = 'CP_BESTELLUNGEN_';
					break;

				case 'user':
					$table = 'user';
					$Prefab = 'CP_BENUTZER_';
					break;

				case 'articles':
					$table = 'articles';
					$Prefab = 'CP_SHOPARTIKEL_';
					break;
			}

			$export->Export($Prefab . date('d_m_Y_H_i') . '',$table, @$_REQUEST['format'], @$_REQUEST['groups']);
		}

		$groups = array();
		$sql = $AVE_DB->Query("SELECT * FROM " . PREFIX . "_user_groups");
		while ($row = $sql->FetchArray())
		{
			array_push($groups, $row);
		}

		$AVE_Template->assign('ProductCategs', $this->fetchShopNavi(1));
		$AVE_Template->assign('groups', $groups);
		$AVE_Template->assign('content', $AVE_Template->fetch($tpl_dir . 'shop_export_data.tpl'));
	}

	//=======================================================
	//=======================================================
	function gethost($ip)
	{
		if ($ip == '') $ip = $_SERVER['REMOTE_ADDR'];
		$longisp = @gethostbyaddr($ip);
		$isp = explode('.', $longisp);
		$isp = array_reverse($isp);
		$tmp = @$isp[1];
		if (preg_match("/\<(org?|com?|net)\>/i", $tmp))
		{
			$myisp = @$isp[2].'.'.@$isp[1].'.'.@$isp[0];
		}
		else
		{
			$myisp = @$isp[1].'.'.@$isp[0];
		}

		if (preg_match("/^(?:(?:25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.){3}(?:25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)$/", $myisp)) return 'ISP lookup failed.';

		return $myisp;
	}

	//=======================================================
	// Kunden-Downloads (wie Koobi) (Загрузки клиента как в Koobi)
	//=======================================================
	function listFiles()
	{
		global $AVE_DB;

		$files = array();
		$sql = $AVE_DB->Query("SELECT * FROM " . PREFIX . "_modul_shop_artikel");

		while ($row = $sql->FetchRow())
		{
			$sql_2 = $AVE_DB->Query("
				SELECT ArtId
				FROM " . PREFIX . "_modul_shop_artikel_downloads
				WHERE ArtId = '" . $row->Id . "'
				LIMIT 1
			");
			$num = $sql_2->NumRows();
			if ($num == 1) array_push($files, $row);
		}

		return $files;
	}

	function shopDownloads($tpl_dir)
	{
		global $AVE_DB, $AVE_Template;

		if (!empty($_REQUEST['sub']))
		{
			switch ($_REQUEST['sub'])
			{
				// Datei neu
				case 'new':
					$AVE_DB->Query("
						INSERT INTO " . PREFIX . "_modul_shop_downloads
						SET
							Benutzer    = '" . addslashes($_REQUEST['User']) . "',
							ArtikelId   = '" . addslashes($_REQUEST['file']) . "',
							DownloadBis = '" . mktime(23,59,59,$_REQUEST['filetimeMonth'],$_REQUEST['filetimeDay'],$_REQUEST['filetimeYear']) . "',
							Lizenz      = ''
					");
					break;


				// Aktualisieren
				case 'save':
					if (isset($_REQUEST['Id']))
					{
						foreach ($_POST['Id'] as $id=>$post)
						{
							// Speichern
							$AVE_DB->Query("
								UPDATE " . PREFIX . "_modul_shop_downloads
								SET
									Lizenz            = '" . (!empty($_POST['Lizenz'][$id]) ? $_POST['Lizenz'][$id] : '') . "',
									UrlLizenz         = '" . (!empty($_POST['UrlLizenz'][$id]) ? $_POST['UrlLizenz'][$id] : '') . "',
									DownloadBis       = '" . mktime(23,59,59,$_POST['Monat'][$id],$_POST['Tag'][$id],$_POST['Jahr'][$id]) . "',
									Gesperrt          = '" . (!empty($_POST['Gesperrt'][$id]) ? $_POST['Gesperrt'][$id] : '') . "',
									GesperrtGrund     = '" . (!empty($_POST['GesperrtGrund'][$id]) ? $_POST['GesperrtGrund'][$id] : '') . "',
									KommentarBenutzer = '" . (!empty($_POST['KommentarBenutzer'][$id]) ? addslashes($_POST['KommentarBenutzer'][$id]) : '') . "',
									KommentarAdmin    = '" . (!empty($_POST['KommentarAdmin'][$id]) ? addslashes($_POST['KommentarAdmin'][$id]) : '') . "'
								WHERE
									id = '" . $id . "'
							");
						}

						// Lцschen
						if (isset($_POST['Del']) && $_POST['Del']>=0)
						{
							foreach ($_POST['Del'] as $id => $post)
							{
								$AVE_DB->Query("DELETE FROM " . PREFIX . "_modul_shop_downloads WHERE id = '" . $id . "'");
							}
						}
					}
					break;
			}
		}

		$Items = array();
		$sql = $AVE_DB->Query("
			SELECT
				a.*,
				b.Artname
			FROM
				" . PREFIX . "_modul_shop_downloads as a,
				" . PREFIX . "_modul_shop_artikel as b
			WHERE
				a.Benutzer = '" . addslashes($_REQUEST['User']) . "'
			AND
				b.ArtNr = a.ArtikelId
		");
		while ($row = $sql->FetchRow())
		{
			$row->TagEnde = date("d", $row->DownloadBis);
			$row->MonatEnde = date("m", $row->DownloadBis);
			$row->JahrEnde = date("Y", $row->DownloadBis);
			array_push($Items, $row);
		}

		$AVE_Template->assign('Start', date("Y")-6);

		$AVE_Template->assign('Items', $Items);
		$AVE_Template->assign('Files', $this->listFiles());
		$AVE_Template->assign('content', $AVE_Template->fetch($tpl_dir . 'shop_customer_downloads.tpl'));
	}

	//=======================================================
	//=======================================================
	function customerDiscounts($tpl_dir)
	{
		global $AVE_DB, $AVE_Template;

		if (isset($_REQUEST['sub']) && $_REQUEST['sub'] == 'save')
		{
			foreach ($_POST['Wert'] as $key => $val)
			{
				$wert = ($val<100) ? $this->kreplace($val) : 99;
				$AVE_DB->Query("
					INSERT INTO " . PREFIX . "_modul_shop_kundenrabatte
					SET
						Wert = '" . $wert . "',
						GruppenId = '" . $key . "'
					ON DUPLICATE KEY UPDATE
						Wert = '" . $wert . "'
				");
			}
		}

		$ugroups = array();
		$sql = $AVE_DB->Query("
			SELECT
				grp.*,
				IFNULL(Wert,'0.00') AS Wert
			FROM " . PREFIX . "_user_groups AS grp
			LEFT JOIN " . PREFIX . "_modul_shop_kundenrabatte ON GruppenId = user_group
		");
		while ($row = $sql->FetchRow()) array_push($ugroups, $row);

		$AVE_Template->assign('Groups', $ugroups);
		$ttt = $AVE_Template->fetch($tpl_dir . 'shop_discounts.tpl');
		$AVE_Template->assign('content', $ttt);
	}

	//=======================================================
	//=======================================================
	function shopImport($tpl_dir)
	{
		global $AVE_DB, $AVE_Template;

		define("ARTICLE_IMPORT", 1);

		@require_once(BASE_DIR . "/modules/shop/class.csv.php");
		@require_once(BASE_DIR . "/modules/shop/internals/product_import.php");
	}

	//=======================================================
	//=======================================================
	function userImport($tpl_dir)
	{
		global $AVE_DB, $AVE_Template;

		define("USER_IMPORT", 1);

		@require_once(BASE_DIR . "/modules/shop/class.csv.php");
		@require_once(BASE_DIR . "/modules/shop/internals/user_import.php");
	}

	//=======================================================
	// Staffelpreise (Цены на количестве)
	//=======================================================
	function staffelPreise($tpl_dir)
	{
		global $AVE_DB, $AVE_Template;

		if (!empty($_REQUEST['sub']))
		{
			switch ($_REQUEST['sub'])
			{
				// Nei
				case 'new':
					$AVE_DB->Query("
						INSERT " . PREFIX . "_modul_shop_staffelpreise
						SET
							StkVon = '" . (int)$_POST['Von'] . "',
							StkBis = '" . (int)$_POST['Bis'] . "',
							Preis  = '" . (!empty($_POST['Preis']) ? str_replace(',','.',$_POST['Preis']) : '') . "',
							ArtId  = '" . (int)$_REQUEST['Id'] . "'
					");
					break;

				// Aktualisieren
				case 'save':
					if (!empty($_POST['StkVon']) && is_array($_POST['StkVon']))
					{
						foreach ($_POST['StkVon'] as $id => $stk_von)
						{
							if ((is_numeric($stk_von) && $stk_von > 0) && (is_numeric($_POST['StkBis'][$id]) && $_POST['StkBis'][$id] > $stk_von))
							{
								$AVE_DB->Query("
									UPDATE " . PREFIX . "_modul_shop_staffelpreise
									SET
										StkVon = '" . (int)$stk_von . "',
										StkBis = '" . (int)$_POST['StkBis'][$id] . "',
										Preis  = '" . (!empty($_POST['Preis'][$id]) ? str_replace(',','.',$_POST['Preis'][$id]) : '') . "'
									WHERE
										Id = '" . $id . "'
								");
							}

							if (isset($_POST['Del']) && $_POST['Del']>0)
							{
								foreach ($_POST['Del'] as $id => $del)
								{
									$AVE_DB->Query("
										DELETE
										FROM " . PREFIX . "_modul_shop_staffelpreise
										WHERE Id = '" . $id . "'
									");
								}
							}
						}
					}
					break;
			}
		}

		$items = array();
		$sql = $AVE_DB->Query("
			SELECT *
			FROM " . PREFIX . "_modul_shop_staffelpreise
			WHERE ArtId = '" . $_GET['Id'] . "'
			ORDER BY StkVon ASC
		");
		while ($row = $sql->FetchRow())
		{
			array_push($items, $row);
		}

		$AVE_Template->assign('Stf', $items);
		$AVE_Template->assign('content', $AVE_Template->fetch($tpl_dir . 'shop_product_price.tpl'));
	}

	//=======================================================
	// Fьr den Import von Benutzern aus Koobi (Импорт пользователей из Koobi)
	//=======================================================
	function dream4_userImport($Prefix = '', $Truncate = '')
	{
		global $AVE_DB;

		$sql = $AVE_DB->Query("
			SELECT *
			FROM " . $Prefix . "_user
			WHERE uid != 1
		");
		$num = $sql->NumRows();

		// Gibt es Benutzer in der alten Tabelle?
		if ($num>0)
		{
			$Truncate=1;
			if ($Truncate == 1)
			{
				$AVE_DB->Query("
					DELETE
					FROM " . PREFIX . "_modul_forum_userprofile
					WHERE BenutzerId != 1
					AND BenutzerId != '" . $_SESSION['user_id'] . "'
				");
				$AVE_DB->Query("
					DELETE
					FROM " . PREFIX . "_users
					WHERE Id != 1
					AND Id != '" . $_SESSION['user_id'] . "'
				");
				$AVE_DB->Query("
					ALTER
					TABLE " . PREFIX . "_modul_forum_userprofile
					PACK_KEYS = 0
					CHECKSUM = 0
					DELAY_KEY_WRITE = 0
					AUTO_INCREMENT = 1
				");
				$AVE_DB->Query("
					ALTER
					TABLE " . PREFIX . "_users
					PACK_KEYS = 0
					CHECKSUM = 0
					DELAY_KEY_WRITE = 0
					AUTO_INCREMENT = 1
				");
			}

			while ($row = $sql->FetchRow())
			{
				$AVE_DB->Query("
					INSERT " . PREFIX . "_modul_forum_userprofile
					SET
						BenutzerId     = '" . $row->uid . "',
						BenutzerName   = '" . $row->uname . "',
						GroupIdMisc    = '" . $row->group_id_misc . "',
						Beitraege      = '" . $row->user_posts . "',
						ZeigeProfil    = '" . $row->show_public . "',
						Signatur       = '" . $row->user_sig . "',
						Icq            = '" . $row->user_icq . "',
						Aim            = '" . $row->user_aim . "',
						Skype          = '" . $row->user_skype . "',
						Emailempfang   = '" . (($row->user_viewemail == 'yes' || $row->user_viewemail == '') ? 1 : 0) . "',
						Pnempfang      = '" . (($row->user_canpn == 'yes') ? 1 : 0) . "',
						Avatar         = '" . $row->user_avatar . "',
						AvatarStandard = '" . $row->usedefault_avatar . "',
						Webseite       = '" . $row->url . "',
						Unsichtbar     = '" . (($row->invisible == 'yes') ? 1 : 0) . "',
						Interessen     = '" . $row->user_interests . "',
						email          = '" . $row->email . "',
						reg_time       = '" . $row->user_regdate . "',
						GeburtsTag     = '" . $row->user_birthday . "'
				");

				if ($row->uid != 2) $AVE_DB->Query("
					INSERT " . PREFIX . "_users
					SET
						Id               = '" . $row->uid . "',
						password         = '" . $row->pass . "',
						email            = '" . $row->email . "',
						street           = '" . $row->street . "',
						street_nr        = '',
						zipcode          = '" . $row->zip . "',
						city             = '" . $row->user_from . "',
						phone            = '" . $row->phone . "',
						telefax          = '" . $row->fax . "',
						description      = '',
						firstname        = '" . $row->name . "',
						lastname         = '" . $row->lastname . "',
						user_name        = '" . $row->uname . "',
						user_group       = '" . $row->ugroup . "',
						user_group_extra = '" . $row->group_id_misc . "',
						reg_time         = '" . $row->user_regdate . "',
						status           = '" . $row->status . "',
						last_visit       = '" . $row->last_login . "',
						country          = '" . $row->country . "',
						deleted          = '',
						del_time         = '',
						emc              = '',
						reg_ip           = '',
						new_pass         = '" . $row->passtemp . "',
						company          = '" . $row->company . "',
						taxpay           = '1',
						birthday         = '" . $row->user_birthday . "'
				");
			}
		}
	}

	function imp()
	{
		global $AVE_DB;

		$this->dream4_userImport('kpro');

		$_REQUEST['import_from_koobi'] = 1;
		if (isset($_REQUEST['import_from_koobi']) && $_REQUEST['import_from_koobi'] == 1)
		{
			//$AVE_DB->Query("TRUNCATE TABLE " . PREFIX . "_modul_shop_artikel_downloads");
			$AVE_DB->Query("TRUNCATE TABLE " . PREFIX . "_modul_shop_downloads");
			$sql = $AVE_DB->Query("SELECT * FROM kpro_private_files_items");
			while ($row = $sql->FetchRow())
			{
				$sql_ts = $AVE_DB->Query("
					SELECT Id
					FROM " . PREFIX . "_modul_shop_artikel
					WHERE ArtNr = '" . $row->artnumber . "'
				");
				$row_ts = $sql_ts->FetchRow();

				switch ($row->type)
				{
					case '0': $ft = 'full'; break;
					case '' : $ft = 'full'; break;
					case '1': $ft = 'other'; break;
					case '2': $ft = 'bugfix'; break;
					case '3': $ft = 'update'; break;
					case '4': $ft = 'other'; break;
				}

				if (!empty($row_ts->Id))
				{
					$q = "
						INSERT
						INTO " . PREFIX . "_modul_shop_artikel_downloads
						SET
							ArtId        = '" . $row_ts->Id . "',
							Datei        = '" . $row->file_name . "',
							DateiTyp     = '" . $ft . "',
							Bild         = '',
							title        = '" . $row->file_name . "',
							description = '" . $row->text . "',
							Position     = '1',
							Datum        = '" . $row->ctime . "'
					";
					//$AVE_DB->Query($q);
					//echo "<pre>$q</pre>";
				}
			}

			$sql = $AVE_DB->Query("SELECT * FROM kpro_private_files");
			while ($row = $sql->FetchRow())
			{
				$AVE_DB->Query("
					INSERT
					INTO " . PREFIX . "_modul_shop_downloads
					SET
						Id                = '',
						Benutzer          = '" . $row->uid . "',
						PName             = '',
						ArtikelId         = '" . $row->artnumber . "',
						DownloadBis       = '" . $row->ptilltime . "',
						Lizenz            = '" . $row->plicdata . "',
						Downloads         = '" . $row->downloads . "',
						UrlLizenz         = '" . $row->url . "',
						KommentarBenutzer = '" . $row->comment_user . "',
						KommentarAdmin    = '" . $row->comment_admin . "',
						Gesperrt          = '" . $row->locked . "',
						GesperrtGrund     = '" . $row->locked_reason . "',
						Position          = '1'
				");
			}

			$sql = $AVE_DB->Query("SELECT * FROM kpro_shop_orders");
			while ($row = $sql->FetchRow())
			{
				$row->articles = explode(',', $row->articles);
				$row->articles = serialize($row->articles);

				/*
					wait', 'progress', 'ok', 'failed', 'download')
					1 = VORK
					2 = NACHNAH
					3 = RECH
					4 = PayPal
					5 = KK
				*/

				switch ($row->payment_id)
				{
					case '1' : $payid = 1; break;
					case '2' : $payid = 2; break;
					case '3' : $payid = 5; break;
					case '5' : $payid = 4; break;
				}

				$AVE_DB->Query("
					INSERT
					INTO " . PREFIX . "_modul_shop_bestellungen
					SET
						Benutzer          = '" . $row->uid . "',
						TransId           = '" . $row->control . "',
						Datum             = '" . $row->ordertime . "',
						Gesamt            = '" . $row->ovall . "',
						USt               = '" . $row->ust . "',
						Artikel           = '" . $row->articles . "',
						Artikel_Vars      = '',
						RechnungText      = '" . $row->calculation2 . "',
						RechnungHtml      = '" . $row->calculation . "',
						NachrichtBenutzer = '" . $row->Bemerkung . "',
						Ip                = '" . $row->ip . "',
						ZahlungsId        = '" . $payid . "',
						VersandId         = '',
						KamVon            = '',
						Gutscheincode     = '" . $row->coupon_id . "',
						Bestell_Email     = '',
						Liefer_Firma      = '',
						Liefer_Abteilung  = '" . $row->shipping_company . "',
						Liefer_Vorname    = '" . $row->shipping_firstname . "',
						Liefer_Nachname   = '" . $row->shipping_lastname . "',
						Liefer_Strasse    = '" . $row->shipping_street . "',
						Liefer_Hnr        = '" . $row->shipping_streetnumber . "',
						Liefer_PLZ        = '" . $row->shipping_zip . "',
						Liefer_Ort        = '" . $row->shipping_city . "',
						Liefer_Land       = '" . $row->shipping_country . "',
						Rech_Firma        = '" . $row->rng_company . "',
						Rech_Abteilung    = '" . $row->rng_company_reciever . "',
						Rech_Vorname      = '" . $row->rng_firstname . "',
						Rech_Nachname     = '" . $row->rng_lastname . "',
						Rech_Strasse      = '" . $row->rng_street . "',
						Rech_Hnr          = '" . $row->rng_streetnumber . "',
						Rech_PLZ          = '" . $row->rng_zip . "',
						Rech_Ort          = '" . $row->rng_town . "',
						Rech_Land         = '" . $row->rng_country . "',
						Status            = '" . $row->status_o . "'
				");
			}
		}
	}
}

?>