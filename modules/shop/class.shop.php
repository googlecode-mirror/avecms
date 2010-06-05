<?php

class Shop
{

	var $_product_detail = 'index.php?module=shop&amp;action=product_detail&amp;product_id=';
	var $_delete_item = 'index.php?module=shop&amp;action=delitem&amp;product_id=';
	var $_add_item = 'index.php?add=1&amp;module=shop&amp;action=addtobasket&amp;product_id=';
	var $_add_item_wishlist = 'index.php?add=1&amp;module=shop&amp;action=addtowishlist&amp;product_id=';
	var $_link_manufaturer = 'index.php?module=shop&amp;manufacturer=';
	var $_expander = '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
	var $_shop_navi_tpl = 'shop_navi.tpl';
	var $_shop_navi_sub_tpl = 'shop_navi_sub.tpl';
	var $_shop_start_tpl = 'shop_start.tpl';
	var $_shop_product_detailpage = 'shop_product_detail.tpl';
	var $_limit_shoparticles = 1;

	/**
	 * Проверка статуса Магазина
	 *
	 */
	function checkShop()
	{
		if ($this->_getShopSetting('Aktiv') != 1)
		{
			$tpl_out = $GLOBALS['mod']['config_vars']['NotActive'];
			define('MODULE_CONTENT', $tpl_out);
		}
	}

	/**
	 * Формирование идентификатора транзакции
	 *
	 * @param int $c количество символов в идентификаторе
	 * @return string идентификатор транзакции
	 */
	function _transId($c = 0)
	{
		$transid = '';
		$chars = array('1', '2', '3', '4', '5', '6', '7', '8', '9', '0',
			'a', 'A', 'b', 'B', 'c', 'C', 'd', 'D', 'e', 'E', 'f', 'F', 'g', 'G', 'h', 'H', 'i', 'I', 'j', 'J',
			'k', 'K', 'l', 'L', 'm', 'M', 'n', 'N', 'o', 'O', 'p', 'P', 'q', 'Q', 'r', 'R', 's', 'S', 't', 'T',
			'u', 'U', 'v', 'V', 'w', 'W', 'x', 'X', 'y', 'Y', 'z', 'Z');
		$ch = ($c != 0) ? $c : 7;
		$count = count($chars) - 1;
		srand((double)microtime() * 1000000);
		for ($i = 0; $i < $ch; $i++)
		{
			$transid .= $chars[rand(0, $count)];
		}
		return(strtoupper($transid));
	}

	/**
	 * Очистка текста
	 *
	 * @param string $text текст который надо очистить
	 * @return string очищенный текст
	 */
	function _textReplace($text)
	{
		return strip_tags($text);
	}

	/**
	 * Настройки Магазина
	 *
	 * @param string $param название параметра
	 * @return mixed значение запрошенного параметра
	 */
	function _getShopSetting($param, $default_value = '')
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

		return (isset($this->_setings->$param) ? $this->_setings->$param : $default_value);
	}

	/**
	 * Формирование общих значений для шаблонизатора
	 *
	 */
	function getTplSettings()
	{
		global $AVE_DB, $AVE_Template;

		if (isset($_REQUEST['categ']) && $_REQUEST['categ'] > 0)
		{
			$row = $AVE_DB->Query("
				SELECT
					KatName,
					KatBeschreibung
				FROM " . PREFIX . "_modul_shop_kategorie
				WHERE Id = '" . (int)$_REQUEST['categ'] . "'
			")->FetchRow();

			$assign['KatBeschreibung'] = isset($row->KatBeschreibung) ? $row->KatBeschreibung : '';
			$assign['KatName'] = isset($row->KatName) ? $row->KatName : '';
		}
		else
		{
			$assign['KatName'] = '';
			$assign['KatBeschreibung'] = '';
		}

		$categ = (isset($_REQUEST['categ']) && is_numeric($_REQUEST['categ'])) ? $_REQUEST['categ'] : '';

		define('WidthTsThumb',         $this->_getShopSetting('Topsellerbilder', ''));
		define('GastBestellung',       $this->_getShopSetting('GastBestellung', ''));
		define('Kommentare',           $this->_getShopSetting('Kommentare', ''));
		define('WidthThumbs',          $this->_getShopSetting('Vorschaubilder', ''));
		define('WidthThumbsTopseller', $this->_getShopSetting('Topsellerbilder', ''));
		define('Waehrung2',            $this->_getShopSetting('Waehrung2', ''));
		define('WaehrungSymbol2',      $this->_getShopSetting('WaehrungSymbol2', ''));
		define('Waehrung2Multi',       $this->_getShopSetting('Waehrung2Multi', ''));

		$this->_globalProductInfo();

		$assign['theme_folder']      = defined('THEME_FOLDER') ? THEME_FOLDER : DEFAULT_THEME_FOLDER;
		$assign['ZeigeWaehrung2']    = $this->_getShopSetting('ZeigeWaehrung2');
		$assign['Currency2']         = $this->_getShopSetting('WaehrungSymbol2');
		$assign['Kommentare']        = $this->_getShopSetting('Kommentare');
		$assign['KommentareGast']    = $this->_getShopSetting('KommentareGast');
		$assign['GastBestellung']    = $this->_getShopSetting('GastBestellung');
		$assign['WidthThumb']        = $this->_getShopSetting('Vorschaubilder');
		$assign['WidthTsThumb']      = $this->_getShopSetting('Topsellerbilder');
		$assign['TemplateArtikel']   = $this->_getShopSetting('TemplateArtikel');
		$assign['TopsellerActive']   = $this->_getShopSetting('Topseller');
		$assign['WishListActive']    = $this->_getShopSetting('Merkliste');
		$assign['CanOrderHere']      = $this->_getShopSetting('BestUebersicht');
		$assign['Currency']          = $this->_getShopSetting('WaehrungSymbol');
		$assign['KategorienStart']   = $this->_getShopSetting('KategorienStart');
		$assign['KategorienSons']    = $this->_getShopSetting('KategorienSons');
		$assign['ShopWillkommen']    = $this->_getShopSetting('ShopWillkommen');
		$assign['FooterText']        = !empty($this->_setings->ShopFuss) ? $this->_shopRewrite($this->_setings->ShopFuss) : '';
		$assign['ShopAgb']           = !empty($this->_setings->Agb) ? strip_tags($this->_setings->Agb,'<b><strong><br><p><br /><em><i>') : '';
		$assign['RandomOfferKateg']  = $this->_getShopSetting('ZufallsAngebotKat', 0) == 1 ? $this->_randomOffer($categ) : '';
		$assign['RandomOffer']       = $this->_getShopSetting('ZufallsAngebot', 0) == 1 ? $this->_randomOffer() : '';
		$assign['MyIp']              = isset($_SERVER['REMOTE_ADDR']) ? $_SERVER['REMOTE_ADDR'] : '';
		$assign['WishListLink']      = $this->_shopRewrite('index.php?module=shop&amp;action=wishlist&amp;pop=1');
		$assign['TopSeller']         = $this->_topSeller();
		$assign['UserPanel']         = $this->_shopLogin();
		$assign['ShopNavi']          = $this->fetchShopNavi();
		$assign['Basket']            = $AVE_Template->fetch($GLOBALS['mod']['tpl_dir'] . 'shop_basket_small.tpl');
		$assign['Search']            = $AVE_Template->fetch($GLOBALS['mod']['tpl_dir'] . 'shop_smallsearch.tpl');
		$assign['Topseller']         = $AVE_Template->fetch($GLOBALS['mod']['tpl_dir'] . 'shop_topseller.tpl');
//		$assign['TopNav']            = $AVE_Template->fetch($GLOBALS['mod']['tpl_dir'] . 'shop_topnav.tpl');

$AVE_Template->caching = 1;
		$assign['InfoBox']           = $this->_shopRewrite($AVE_Template->fetch($GLOBALS['mod']['tpl_dir'] . 'shop_infobox.tpl'));
		$assign['MyOrders']          = $this->_shopRewrite($AVE_Template->fetch($GLOBALS['mod']['tpl_dir'] . 'shop_myorders.tpl'));
$AVE_Template->caching = 0;

		$AVE_Template->assign($assign);
	}

	/**
	 * Выбор случайным образом баннера презентации/спецпредложения
	 *
	 * @param int $categ идентификатор категории
	 * @return string HTML-код вывода баннера с гиперсылкой на рекламируемый товар
	 */
	function _randomOffer($categ = '')
	{
		global $AVE_DB;

		$row = $AVE_DB->Query("
			SELECT
				Id,
				ArtNr,
				KatId,
				ArtName,
				Angebot,
				AngebotBild
			FROM " . PREFIX . "_modul_shop_artikel
			WHERE Angebot = 1
			AND Aktiv = 1
			AND Erschienen <= '" . time() . "'
			" . ($categ != '' ? "AND KatId = '" . $categ . "'" : '') . "
			ORDER BY rand()
			LIMIT 1
		")
		->FetchRow();

		if ($row)
		{
			$row->Detaillink = $this->_shopRewrite($this->_product_detail . $row->Id . '&amp;categ=' . $row->KatId . '&amp;navop=' . getParentShopcateg($row->KatId));
			$img = (file_exists(BASE_DIR . '/' . $row->AngebotBild)) ? '<!-- START OFFER --><a title="' . $row->ArtName . '" href="' . $row->Detaillink . '"><img src="' . ABS_PATH . $row->AngebotBild . '" alt="' . $row->ArtName . '" border=""></a><br /><br /><!-- END OFFER -->' : '';
		}
		else
		{
			$img = '';
		}

		return $img;
	}

	/**
	 * Определение типа изображения по расширению файла
	 * (поддерживаемые типы JPG, PNG, GIF)
	 *
	 * @param string $file имя файла-изображения
	 * @return string тип изображения,
	 * 			false если тип изображения не поддерживается
	 */
	function _getEndung($file)
	{
		switch (substr(strtolower($file), -4))
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

			default:
				$End = false;
				break;
		}

		return $End;
	}

	/**
	 * Популярные товары
	 *
	 * @return array список популярных товаров
	 */
	function _topSeller()
	{
		global $AVE_DB;

		$topSeller = array();
		$db_categ = (!empty($_REQUEST['categ']) && is_numeric($_REQUEST['categ'])) ? " AND KatId = '" . $_REQUEST['categ'] . "'" : '';
		$sql = $AVE_DB->Query("
			SELECT
				Id,
				ArtNr,
				KatId,
				ArtName,
				TextKurz,
				Bild,
				Preis
			FROM " . PREFIX . "_modul_shop_artikel
			WHERE Aktiv = 1
			AND Erschienen <= '" . time() . "'
			" . $db_categ . "
			ORDER BY Bestellungen DESC
			LIMIT 5
		");
		while ($row = $sql->FetchRow())
		{
			$row->Img = '';
			$row->Preis = $this->_getDiscountVal($row->Preis);

			if (defined('WaehrungSymbol2') && defined('Waehrung2') && defined('Waehrung2Multi'))
			{
				$row->PreisW2 = ($row->Preis * Waehrung2Multi);
			}

			if (file_exists('modules/shop/thumbnails/shopthumb__' . WidthThumbsTopseller . '__' . $row->Bild))
			{
				$row->Img = '<img src="modules/shop/thumbnails/shopthumb__' . WidthThumbsTopseller . '__' . $row->Bild . '" alt="" border="" />';
			}
			else
			{
				$type = $this->_getEndung($row->Bild);
				$row->Img = '<img src="modules/shop/thumb.php?file=' . $row->Bild . '&amp;type=' . $type . '&amp;xwidth=' . WidthTsThumb . '" alt="" border="" />';
			}
			$row->TextKurz = $row->Img . substr(strip_tags($row->TextKurz,'<b>,<strong>,<em>,<i>'), 0, 250) . '...';
			$row->Detaillink = $this->_shopRewrite($this->_product_detail . $row->Id . '&amp;categ=' . $row->KatId . '&amp;navop=' . getParentShopcateg($row->KatId));
			array_push($topSeller, $row);
		}

		return $topSeller;
	}

	/**
	 * Вспомогательные страницы с различной информацией о Магазине
	 *
	 */
	function getInfoPage()
	{
		global $AVE_DB, $AVE_Template;

		if (!isset($this->_setings))
		{
			$this->_setings = $AVE_DB->Query("
				SELECT *
				FROM " . PREFIX . "_modul_shop
				LIMIT 1
			")
			->FetchRow();
		}

		$Inf = '';
		$InfName = '';

		if (!empty($_REQUEST['page']))
		{
			switch ($_REQUEST['page'])
			{
				case 'shippinginf':
					$Inf = $this->_setings->VersandInfo;
					$InfName = $GLOBALS['mod']['config_vars']['ShippingInf'];
					break;

				case 'datainf':
					$Inf = $this->_setings->DatenschutzInf;
					$InfName = $GLOBALS['mod']['config_vars']['DataInf'];
					break;

				case 'imprint':
					$Inf = $this->_setings->Impressum;
					$InfName = $GLOBALS['mod']['config_vars']['Imprint'];
					break;

				case 'agb':
					$Inf = $this->_setings->Agb;
					$InfName = $GLOBALS['mod']['config_vars']['AGB'];
					break;
			}
		}

		$AVE_Template->assign('Inf', $Inf);
		$tpl_out = $AVE_Template->fetch($GLOBALS['mod']['tpl_dir'] . 'shop_infopage.tpl');
		define('MODULE_CONTENT', $tpl_out);
		define('MODULE_SITE', $InfName);
	}

	/**
	 * Страница сравнения товаров
	 *
	 */
	function myWishlist()
	{
		global $AVE_Template;

		$AVE_Template->assign('MyWishlist', $this->_showWishlist());
		$tpl_out = $AVE_Template->fetch($GLOBALS['mod']['tpl_dir'] . 'shop_wishlist.tpl');
		define('MODULE_CONTENT', $tpl_out);
		define('MODULE_SITE', $GLOBALS['mod']['config_vars']['Wishlist']);
	}

	/**
	 * Авторизация пользователя
	 * МОДУЛЬ АВТОРИЗАЦИИ ДОЛЖЕН БЫТЬ УСТАНОВЛЕН!!!
	 *
	 * @return string форма авторизации или панель авторизованного пользователя
	 */
	function _shopLogin()
	{
		$tpl_dir = BASE_DIR . '/modules/login/templates/';
		$lang_file = BASE_DIR . '/modules/login/lang/' . $_SESSION['user_language'] . '.txt';

		if (!isset($_SESSION['user_id']))
		{
			return $this->_displayLoginform($tpl_dir, $lang_file);
		}
		else
		{
			return $this->_displayUserPanel($tpl_dir, $lang_file);
		}
	}

	/**
	 * Вывод формы авторизации
	 *
	 * @param string $tpl_dir путь к шаблонам модуля авторизации
	 * @param string $lang_file путь к языковому файлу модуля авторизации
	 * @return string форма авторизации
	 */
	function _displayLoginform($tpl_dir, $lang_file)
	{
		global $AVE_Template;

$AVE_Template->caching = 1;
if (!$AVE_Template->is_cached($tpl_dir . 'loginform.tpl'))
{

		$AVE_Template->config_load($lang_file, 'displayloginform');
//		$config_vars = $AVE_Template->get_config_vars();
//		$AVE_Template->assign('config_vars', $config_vars);
		$AVE_Template->assign('active', 1);
}
		$output = $AVE_Template->fetch($tpl_dir . 'loginform.tpl');
$AVE_Template->caching = 0;

		return $output;
	}

	/**
	 * Вывод панели авторизованного пользователя
	 *
	 * @param string $tpl_dir путь к шаблонам модуля авторизации
	 * @param string $lang_file путь к языковому файлу модуля авторизации
	 * @return string форма панели авторизованного пользователя
	 */
	function _displayUserPanel($tpl_dir, $lang_file)
	{
		global $AVE_Template;

$AVE_Template->caching = 1;
if (!$AVE_Template->is_cached($tpl_dir . 'userpanel.tpl'))
{

		$AVE_Template->config_load($lang_file, 'displaypanel');
//		$config_vars = $AVE_Template->get_config_vars();
//		$AVE_Template->assign('config_vars', $config_vars);
}
		$output = $AVE_Template->fetch($tpl_dir . 'userpanel.tpl');
$AVE_Template->caching = 0;

		return $output;
	}

	//=======================================================
	// Zahlungsinfo
	//=======================================================
	function PaymentInfo($theme_folder, $id)
	{
		global $AVE_DB, $AVE_Template;

		$row = $AVE_DB->Query("
			SELECT
				Name,
				Beschreibung
			FROM " . PREFIX . "_modul_shop_zahlungsmethoden
			WHERE Id = '" . $id . "'
		")
		->FetchRow();
		//$AVE_Template->assign('config_vars', $config_vars);
		$AVE_Template->assign('theme_folder', $theme_folder);
		$AVE_Template->assign('row', $row);
		$AVE_Template->display($GLOBALS['mod']['tpl_dir'] . 'shop_paymentinfo.tpl');
	}

	/**
	 * Формирование ЧПУ для модуля Магазин
	 *
	 * @param string $string обрабатываемый текст
	 * @return string обработанный текст
	 */
	function _shopRewrite($string)
	{
		if (REWRITE_MODE) $string = shopRewrite($string);

		return $string;
	}

	//=======================================================
	// Alle Steuersдtze anzeigen
	//=======================================================
	function _showVatZones($unset='')
	{
		$vatPercent = array();
		if (!isset($this->_vatZones))
		{
			global $AVE_DB;

			$this->_vatZones = array();
			$sql = $AVE_DB->Query("
				SELECT
					Id,
					Wert
				FROM " . PREFIX . "_modul_shop_ust
				WHERE Wert > '0.00'
			");
			while ($row = $sql->FetchRow())
			{
				$this->_vatZones[$row->Id] = $row;
			}
			$sql->Close();
		}

		foreach ($this->_vatZones as $row)
		{
			if ($unset == 1) unset($_SESSION[$row->Wert]);
			array_push($vatPercent, $row);
		}

		return $vatPercent;
	}

	//=======================================================
	// Steuersatz - Session zurьcksetzen
	//=======================================================
	function _resetVatZoneSessions()
	{
		if (!isset($this->_vatZones))
		{
			global $AVE_DB;

			$this->_vatZones = array();
			$sql = $AVE_DB->Query("
				SELECT
					Id,
					Wert
				FROM " . PREFIX . "_modul_shop_ust
				WHERE Wert > '0.00'
			");
			while ($row = $sql->FetchRow()) $this->_vatZones[$row->Id] = $row;
			$sql->Close();
		}

		foreach ($this->_vatZones as $row) $_SESSION[$row->Wert] = '';
	}

	//=======================================================
	// Downloads fьr einen Kunden anzeigen
	//=======================================================
	// Downloadfunktion
	function _cpReadFile($filename, $retbytes = true)
	{
		$chunksize = 1*(1024*1024);
		$buffer = '';
		$cnt =0;

		$handle = fopen($filename, 'rb');

		if ($handle === false) return false;

		while (!feof($handle))
		{
			$buffer = fread($handle, $chunksize);
			echo $buffer;
			flush();
			if ($retbytes) $cnt += strlen($buffer);
		}
		$status = fclose($handle);

		if ($retbytes && $status) return $cnt;

		return $status;
	}

	/**
	 * Список файлов для загрузки
	 *
	 */
	function myDownloads()
	{
		global $AVE_DB, $AVE_Template;

		if (!empty($_SESSION['user_id']))
		{
			$this->_globalProductInfo();
			if (!empty($_REQUEST['sub']))
			{
				switch ($_REQUEST['sub'])
				{
					case 'getfile':
						$download = false;
					 	//=======================================================
						// Update am 07.1.2006
						// Downloads wie bei Koobi :)
						//=======================================================
						$sql = $AVE_DB->Query("
							SELECT
								a.*,
								b.Datei
							FROM
								" . PREFIX . "_modul_shop_downloads as a,
								" . PREFIX . "_modul_shop_artikel_downloads as b
							WHERE
								a.ArtikelId = '" . (isset($_REQUEST['FileId']) ? $_REQUEST['FileId'] : '') . "'
							AND
								a.Benutzer = '" . $_SESSION['user_id'] . "'
							AND
								((a.DownloadBis >= '" . time(). "') OR (b.DateiTyp = 'other'))
							AND
								a.Gesperrt != 1
							AND
								b.Id = '" . (isset($_GET['getId']) ? $_GET['getId'] : '') . "'
						");

						$row = $sql->FetchRow();
						$num = $sql->NumRows();

						if ($num >= 1) $download = true;

						if ($download == true)
						{
							ob_start();
							#ob_end_flush();
							#ob_end_clean();
							header('Cache-control: private');
							header('Content-type: application/octet-stream');
							header('Content-disposition:attachment; filename=' . str_replace(array(' '), '', $row->Datei));
							@$this->_cpReadFile(BASE_DIR . '/modules/shop/files/' . $row->Datei);
							exit;
						}
						else
						{
							echo "<script>alert('" . $GLOBALS['mod']['config_vars']['DownloadJsError'] . "');</script>";
						}
					break;
				}
			}

			// Nur anzeigen Start

			$downloads = array();
			//=======================================================
			// Update am 07.1.2006
			// Downloads wie bei Koobi :)
			//=======================================================
			$downloads = array();
			$sql = $AVE_DB->Query("
				SELECT
					a.*,
					b.Id as ARTIKELNUMMER,
					b.ArtName
				FROM
					" . PREFIX . "_modul_shop_downloads as a,
					" . PREFIX . "_modul_shop_artikel as b
				WHERE a.Benutzer = '" . $_SESSION['user_id'] . "'
				AND b.ArtNr = a.ArtikelId
				ORDER BY a.Position ASC
			");

			while ($row = $sql->FetchRow())
			{
				if (is_object($row))
				{
					// Vollversionen
					$DataFiles = array();
					$sql_df = $AVE_DB->Query("
						SELECT *
						FROM " . PREFIX . "_modul_shop_artikel_downloads
						WHERE ArtId = '" . $row->ARTIKELNUMMER . "'
						AND DateiTyp = 'full'
						ORDER BY Position ASC,Id DESC
					");
					while ($row_df = $sql_df->FetchRow())
					{
						if ($row->DownloadBis < time())
						{
							$row_df->Abgelaufen = 1;
						}
						$row_df->Beschreibung = str_replace('"','&quot;',$row_df->Beschreibung);
						$row_df->size = (file_exists(BASE_DIR . '/modules/shop/files/' . $row_df->Datei) ) ? round(@filesize(BASE_DIR . '/modules/shop/files/'.$row_df->Datei)/1024,2) : '';
						array_push($DataFiles, $row_df);
					}
					$row->DataFiles = $DataFiles;

					// Updates
					$DataFilesUpdates = array();
					$sql_df = $AVE_DB->Query("
						SELECT *
						FROM " . PREFIX . "_modul_shop_artikel_downloads
						WHERE ArtId = '" . $row->ARTIKELNUMMER . "'
						AND DateiTyp = 'update'
						ORDER BY Position ASC
					");
					while ($row_df = $sql_df->FetchRow())
					{
						$row_df->Beschreibung = str_replace('"', '&quot;', $row_df->Beschreibung);
						$row_df->size = (file_exists(BASE_DIR . '/modules/shop/files/' . $row_df->Datei) ) ? round(@filesize(BASE_DIR . '/modules/shop/files/' . $row_df->Datei)/1024, 2) : '';
						array_push($DataFilesUpdates, $row_df);
					}
					$row->DataFilesUpdates = $DataFilesUpdates;

					// Sonstiges
					$DataFilesOther = array();
					$sql_df = $AVE_DB->Query("
						SELECT *
						FROM " . PREFIX . "_modul_shop_artikel_downloads
						WHERE ArtId = '" . $row->ARTIKELNUMMER . "'
						AND DateiTyp = 'other'
						ORDER BY Position ASC
					");
					while ($row_df = $sql_df->FetchRow())
					{
						$row_df->Beschreibung = str_replace('"', '&quot;', $row_df->Beschreibung);
						$row_df->size = (file_exists(BASE_DIR . '/modules/shop/files/' . $row_df->Datei) ) ? round(@filesize(BASE_DIR . '/modules/shop/files/'.$row_df->Datei)/1024,2) : '';
						array_push($DataFilesOther, $row_df);
					}
					$row->DataFilesOther = $DataFilesOther;

					// Bugfixes
					$DataFilesBugfixes = array();
					$sql_df = $AVE_DB->Query("
						SELECT *
						FROM " . PREFIX . "_modul_shop_artikel_downloads
						WHERE ArtId = '" . $row->ARTIKELNUMMER . "'
						AND DateiTyp = 'bugfix'
						ORDER BY Position ASC
					");
					while ($row_df = $sql_df->FetchRow())
					{
						$row_df->Beschreibung = str_replace('"','&quot;',$row_df->Beschreibung);
						$row_df->size = (file_exists(BASE_DIR . '/modules/shop/files/' . $row_df->Datei) ) ? round(@filesize(BASE_DIR . '/modules/shop/files/'.$row_df->Datei)/1024,2) : '';
						array_push($DataFilesBugfixes, $row_df);
					}
					$row->DataFilesBugfixes = $DataFilesBugfixes;
				}

				array_push($downloads, $row);
			}

			$AVE_Template->assign('downloads', $downloads);
			$tpl_out = $AVE_Template->fetch($GLOBALS['mod']['tpl_dir'] . 'shop_mydownloads.tpl');
			$tpl_out = $this->_shopRewrite($tpl_out);

			define('MODULE_CONTENT', $tpl_out);
			define('MODULE_SITE', $GLOBALS['mod']['config_vars']['PageName'] . $GLOBALS['mod']['config_vars']['PageSep'] . $GLOBALS['mod']['config_vars']['DownloadsOverviewShowLink']);
			// Nur anzeigen Ende
		}
		else
		{
			$AVE_Template->assign('Inf', $GLOBALS['mod']['config_vars']['NoLoggedIn']);
			$tpl_out = $AVE_Template->fetch($GLOBALS['mod']['tpl_dir'] . 'shop_infopage.tpl');
			define('MODULE_CONTENT', $tpl_out);
			define('MODULE_SITE', $GLOBALS['mod']['config_vars']['PageName'] . $GLOBALS['mod']['config_vars']['PageSep'] . $GLOBALS['mod']['config_vars']['DownloadsOverviewShowLink']);
		}
	}

	/**
	 * Список заказов
	 *
	 */
	function myOrders()
	{
		global $AVE_DB, $AVE_Template;

		if (!empty($_SESSION['user_id']))
		{
			if (isset($_REQUEST['sub']) && $_REQUEST['sub'] == 'request')
			{
				send_mail(
					$this->_getShopSetting('EmpEmail'),
					stripslashes($_POST['text']),
					stripslashes($_POST['subject']),
					$_SESSION['user_email'],
					$_SESSION['user_name'],
					'text',
					''
				);
				$AVE_Template->assign('orderRequestOk', 1);
			}

			$this->_globalProductInfo();

			$my_orders = array();
			$sql = $AVE_DB->Query("
				SELECT *
				FROM " . PREFIX . "_modul_shop_bestellungen
				WHERE Benutzer = '" . $_SESSION['user_id'] . "'
				ORDER BY Datum DESC
			");
			while ($row = $sql->FetchRow())
			{
				array_push($my_orders, $row);
			}

			$AVE_Template->assign('my_orders', $my_orders);

			$tpl_out = $AVE_Template->fetch($GLOBALS['mod']['tpl_dir'] . 'shop_orders.tpl');
			$tpl_out = $this->_shopRewrite($tpl_out);

			define('MODULE_CONTENT', $tpl_out);
			define('MODULE_SITE', $GLOBALS['mod']['config_vars']['PageName'] . $GLOBALS['mod']['config_vars']['PageSep'] . $GLOBALS['mod']['config_vars']['OrderOverviewShowLink']);
		}
		else
		{
			$AVE_Template->assign('Inf', $GLOBALS['mod']['config_vars']['NoLoggedIn']);
			$tpl_out = $AVE_Template->fetch($GLOBALS['mod']['tpl_dir'] . 'shop_infopage.tpl');
			define('MODULE_CONTENT', $tpl_out);
			define('MODULE_SITE', $GLOBALS['mod']['config_vars']['PageName'] . $GLOBALS['mod']['config_vars']['PageSep'] . $GLOBALS['mod']['config_vars']['OrderOverviewShowLink']);
		}
	}

	//=======================================================
	// Kategorien erzeugen
	//=======================================================
	function _getCategories($id, $prefix, &$dl, $extra = '', $sc = '')
	{
		if (!isset($this->_categories))
		{
			global $AVE_DB;

			$sql = $AVE_DB->Query("
				SELECT
					cat.*,
					COUNT(KatId) AS acount
				FROM " . PREFIX . "_modul_shop_kategorie AS cat
				LEFT JOIN " . PREFIX . "_modul_shop_artikel AS art ON KatId = cat.Id AND Aktiv = 1
				GROUP BY cat.Id
				ORDER BY Rang ASC
			");
			if (!$sql->NumRows())
			{
				$this->_categories = array();
				$sql->Close();
				return '';
			}

			while ($row = $sql->FetchRow())
			{
				$this->_categories[$row->Elter][$row->Id] = $row;
			}
			$sql->Close();
		}

		if (!empty($extra))
		{
			if (isset($this->_categories[$id][$extra]) && is_array($this->_categories[$id][$extra]))
			{
			}
			else
			{
				return '';
			}
			$Items = $this->_categories[$id][$extra];
		}
		else
		{
			if (isset($this->_categories[$id]) && is_array($this->_categories[$id]))
			{
			}
			else
			{
				return '';
			}
			$Items = $this->_categories[$id];
		}

		foreach ($Items as $item)
		{
			$item->ntr = '';
			$item->visible_title = $prefix . '' . $item->KatName;
			$item->sub = ($item->Elter == 0) ? 0 : 1;

			$item->dyn_link = 'index.php?module=shop&amp;categ=' . $item->Id . '&amp;parent=' . $item->Elter . '&amp;navop=' . (($item->sub == 0) ? $item->Id : getParentShopcateg($item->Elter));
			$item->dyn_link = $this->_shopRewrite($item->dyn_link);

			if ($item->Elter == 0) $item->ntr = 1;

			$mdl = array();
			$this->_getCategories($item->Id, $prefix, $mdl, $extra, $sc);
			$item->sub = $mdl;
			array_push($dl, $item);
		}

		return $dl;
	}

	//=======================================================
	// Shop - Navi erzeugen
	//=======================================================
	function _getCategoriesSimple($id, $prefix, &$entries, $admin = 0, $dropdown = 0)
	{
		if (!isset($this->_categories))
		{
			global $AVE_DB;

			$sql = $AVE_DB->Query("
				SELECT
					cat.*,
					COUNT(KatId) AS acount
				FROM " . PREFIX . "_modul_shop_kategorie AS cat
				LEFT JOIN " . PREFIX . "_modul_shop_artikel AS art ON KatId = cat.Id AND Aktiv = 1
				GROUP BY cat.Id
				ORDER BY Rang ASC
			");
			if (!$sql->NumRows())
			{
				$this->_categories = array();
				$sql->Close();

				return '';
			}

			while ($row = $sql->FetchRow())
			{
				$this->_categories[$row->Elter][$row->Id] = $row;
			}
			$sql->Close();
		}

		if (isset($this->_categories[$id]) && is_array($this->_categories[$id]))
		{
		}
		else
		{
			return '';
		}

		foreach ($this->_categories[$id] as $item)
		{
			$item->visible_title = $prefix . (($item->Elter != 0 && $admin != 1) ? '' : '') . $item->KatName;
			$item->expander = $prefix;
			$item->sub = ($item->Elter == 0) ? 0 : 1;
			$item->dyn_link = 'index.php?module=shop&amp;categ=' . $item->Id . '&amp;parent=' . $item->Elter . '&amp;navop=' . (($item->sub == 0) ? $item->Id : getParentShopcateg($item->Elter));
			$item->dyn_link = $this->_shopRewrite($item->dyn_link);

			array_push($entries,$item);

			if ($admin == 1)
			{
				$this->_getCategoriesSimple($item->Id, $prefix . '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;', $entries, $admin, $dropdown);
			}
			else
			{
				$this->_getCategoriesSimple($item->Id, $prefix . (($dropdown == 1) ? '&nbsp;&nbsp;' : $this->_expander), $entries, $dropdown);
			}
		}

		return $entries;
	}

	function _getCategoriesNavi($id = 0, $op = '')
	{
		$entries = array();
		$clear_sub = false;

		if (!isset($this->_categories))
		{
			global $AVE_DB;

			$sql = $AVE_DB->Query("
				SELECT
					cat.*,
					COUNT(KatId) AS acount
				FROM " . PREFIX . "_modul_shop_kategorie AS cat
				LEFT JOIN " . PREFIX . "_modul_shop_artikel AS art
					ON KatId = cat.Id AND Aktiv = 1
				GROUP BY cat.Id
				ORDER BY Rang ASC
			");
			if (!$sql->NumRows())
			{
				$this->_categories = array();
				$sql->Close();

				return '';
			}

			while ($row = $sql->FetchRow())
			{
				$this->_categories[$row->Elter][$row->Id] = $row;
			}
			$sql->Close();
		}

		if (isset($this->_categories[$id]) && is_array($this->_categories[$id]))
		{
			foreach ($this->_categories[$id] as $item)
			{
				$item->dyn_link = $this->_shopRewrite("index.php?module=shop&amp;categ=" . $item->Id
					. "&amp;parent=" . $item->Elter
					. "&amp;navop=" . (($item->Elter == 0) ? $item->Id : getParentShopcateg($item->Elter)));

				if ($item->Elter == 0) $op = $item->Id;
				if (!empty($_REQUEST['navop']) && $_REQUEST['navop'] == $op)
				{
					if (!empty($_REQUEST['categ']) && $_REQUEST['categ'] == $item->Id)
					{
						$op = '';
						$clear_sub = true;
					}
					$item->sub_navi = $this->_getCategoriesNavi($item->Id, $op);
				}
				else
				{
					$item->sub_navi = array();
				}

				if ($clear_sub)
				{
					$clear_sub = false;
					$count = sizeof($entries);
					for($i=0;$i<$count;++$i)
					{
						$entries[$i]->sub_navi = array();
					}
				}
				array_push($entries, $item);
			}

			return $entries;
		}
		else
		{
			return '';
		}
	}

	//=======================================================
	// Shop - Navi
	//=======================================================
	function fetchShopNavi($noprint='')
	{
		global $mod, $AVE_Template;

		$categs = array();

		if ($noprint != 1)
		{
			$AVE_Template->assign('shopStart', $this->_shopRewrite('index.php?module=shop'));
			$AVE_Template->assign('shopnavi', $this->_getCategoriesNavi());
			$AVE_Template->assign('subtpl', $mod['tpl_dir'] . $this->_shop_navi_sub_tpl);

			return $AVE_Template->fetch($mod['tpl_dir'] . $this->_shop_navi_tpl);
		}
		else
		{
			if (!isset($this->_categories_simple))
			{
				$this->_categories_simple = $this->_getCategoriesSimple(0, '', $categs, 0, 1);
			}

			return $this->_categories_simple;
		}
	}

	//=======================================================
	// Shop - Startseite
	//=======================================================
	function _lastArticles()
	{
		global $AVE_DB, $AVE_Template;

		$limit = $this->_getShopSetting('ArtikelMax');

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
		$db_sort = ' ORDER BY PosiStartseite ASC, Erschienen DESC';
		$nav_sort = '';

		if (isset($_REQUEST['recordset']) && is_numeric($_REQUEST['recordset']))
		{
			$limit = $_REQUEST['recordset'];
			$recordset_n = '&amp;recordset=' . $_REQUEST['recordset'];
		}

		if (isset($_REQUEST['categ']) && is_numeric($_REQUEST['categ']))
		{
			$dbextra = " AND (KatId = '" . (int)$_REQUEST['categ'] . "' "
				. "OR KatId_Multi like '%," . (int)$_REQUEST['categ'] . ",%' "
				. "OR KatId_Multi like '%," . (int)$_REQUEST['categ'] . "' "
				. "OR KatId_Multi like '" . (int)$_REQUEST['categ'] . ",%')";
			$dbextra_n = '&amp;categ=' . $_REQUEST['categ'];
		}

		if (isset($_REQUEST['manufacturer']) && is_numeric($_REQUEST['manufacturer']))
		{
			$manufacturer = " AND Hersteller = '" . $_REQUEST['manufacturer'] . "'";
			$manufacturer_n = '&amp;manufacturer=' . $_REQUEST['manufacturer'];
		}

		if (!empty($_REQUEST['product_query']))
		{
			$product_query = " AND (ArtNr = '" . $_REQUEST['product_query'] . "' "
				. "OR ArtName LIKE '%" . $_REQUEST['product_query'] . "%' "
				. "OR TextKurz LIKE '%" . $_REQUEST['product_query'] . "%')";
			$product_query_n = '&amp;product_query=' . urlencode($_REQUEST['product_query']);
		}

		if (isset($_REQUEST['price_start']) && is_numeric($_REQUEST['price_start']) &&
			isset($_REQUEST['price_end']) && is_numeric($_REQUEST['price_end']) &&
			$_REQUEST['price_start'] >= 0 && $_REQUEST['price_end'] >= 0 && $_REQUEST['price_start'] < $_REQUEST['price_end'])
		{
			$price_query = " AND (Preis BETWEEN " . $_REQUEST['price_start'] . " AND " . $_REQUEST['price_end'] . ")";
			$price_query_n = '&amp;price_start=' . $_REQUEST['price_start'] . '&amp;price_end=' . $_REQUEST['price_end'];
		}

		if (isset($_REQUEST['product_categ']) && is_numeric($_REQUEST['product_categ']))
		{
			$product_categ = " AND KatId = '" . $_REQUEST['product_categ'] . "'";
			$product_categ_n = '&amp;product_categ=' . $_REQUEST['product_categ'];
		}

		if (!empty($_REQUEST['sort']))
		{
			switch ($_REQUEST['sort'])
			{
				case 'price_desc':
					$db_sort = ' ORDER BY Preis DESC';
					$nav_sort = '&amp;sort=price_desc';
					break;

				case 'price_asc':
					$db_sort = ' ORDER BY Preis ASC';
					$nav_sort = '&amp;sort=price_asc';
					break;

				case 'time_desc':
					$db_sort = ' ORDER BY Erschienen DESC';
					$nav_sort = '&amp;sort=time_desc';
					break;

				case 'time_asc':
					$db_sort = ' ORDER BY Erschienen ASC';
					$nav_sort = '&amp;sort=time_asc';
					break;
			}
		}

		$start = get_current_page() * $limit - $limit;

		$sql = $AVE_DB->Query("
			SELECT SQL_CALC_FOUND_ROWS
				art.*,
				ROUND(AVG(Wertung)) AS Prozwertung,
				COUNT(cmnt.Id) AS Anz
			FROM " . PREFIX . "_modul_shop_artikel AS art
			LEFT JOIN " . PREFIX . "_modul_shop_artikel_kommentare AS cmnt ON ArtId = art.Id AND Publik = 1
			WHERE Aktiv = 1
			AND Erschienen <= '" . time() . "'"
			. $product_categ
			. $price_query
			. $product_query
			. $dbextra
			. $manufacturer
			. " GROUP BY art.Id"
			. $db_sort
			. " LIMIT " . $start . "," . $limit
		);

		$num = $AVE_DB->Query("SELECT FOUND_ROWS()")->GetCell();
		@$seiten = @ceil($num / $limit);

		$shopitems = array();
		while ($row = $sql->FetchRow())
		{
			$row = $this->_globalProductInfo($row);
			array_push($shopitems, $row);
		}

		$nop= '';
		if (isset($_REQUEST['categ']) && is_numeric($_REQUEST['categ']))
		{
//			$the_nav = $this->_getNavigationPath((int)$_REQUEST['categ'], '', 1, (int)$_REQUEST['navop']);
//			$nop = '&amp;navop=24';
//			$nop = '&amp;navop=' . getParentShopcateg($_REQUEST['categ']);
			$nop = '&amp;navop=' . (int)$_REQUEST['navop'];
//			define('TITLE_EXTRA', strip_tags($the_nav));
//			$AVE_Template->assign('topnav', $this->_getNavigationPath((int)$_REQUEST['categ'], '', 1, (int)$_REQUEST['navop']));
//			$AVE_Template->assign('topnav', $the_nav);
		}

		$nav_parent = '';
		if (isset($_REQUEST['parent']) && is_numeric($_REQUEST['parent'])) {
			$nav_parent = '&amp;parent=' . (int)$_REQUEST['parent'];
		}

		$AVE_Template->assign('PageNumbers', $seiten);
		if ($seiten > 1)
		{
			$page_nav = " <a class=\"pnav\" href=\"index.php?module=shop" . $recordset_n . $product_categ_n
				. $price_query_n . $product_query_n . $dbextra_n . $manufacturer_n
				. $nav_sort . $nav_parent . $nop . "&amp;page={s}\">{t}</a> ";
			$page_nav = get_pagination($seiten, 'page', $page_nav, get_settings('navi_box'));
			$AVE_Template->assign('page_nav', $this->_shopRewrite($page_nav));
		}
		return $shopitems;
	}

	/**
	 * Формирование списка отобранных для сравнения товаров
	 *
	 * @return array список сравниваемых товаров и их параметров
	 */
	function _showWishlist()
	{
		global $AVE_DB, $_SESSION;

		$items = '';
		$Preis = '';
		$Vars = '';
		$SummVarsE = '';
//		$PreisV = '';
//		$PreisVarianten = '';
		$PreisGesamt = '';
		$GewichtGesamt = '';
//		$row_ieu = '';

		$row = $AVE_DB->Query("
			SELECT *
			FROM " . PREFIX . "_modul_shop_merkliste
			WHERE Benutzer = '" . @$_SESSION['user_id'] . "'
		")
		->FetchRow();

		// Anzahl der Artikel in der WUnschliste aktualisieren
		if (isset($_REQUEST['refresh']) && $_REQUEST['refresh'] == 1)
		{
			if (isset($_POST['del_product']) && is_array($_POST['del_product']))
			{
				foreach ($_POST['del_product'] as $id => $Artikel)
				{
					unset($_SESSION['Product_Wishlist'][$id]);
					unset($_SESSION['Product_Wishlist_Vars'][$id]);
				}
				$AVE_DB->Query("
					UPDATE " . PREFIX . "_modul_shop_merkliste
					SET
						Inhalt = '" . serialize($_SESSION['Product_Wishlist']) . "',
						Inhalt_Vars = '" . serialize($_SESSION['Product_Wishlist_Vars']) . "'
					WHERE Benutzer = '" . @$_SESSION['user_id'] . "'
				");

				header('Location:' . $_SERVER['HTTP_REFERER']);
				exit;
			}

			if (isset($_POST['amount']) && is_array($_POST['amount']))
			{
				foreach ($_POST['amount'] as $id => $Artikel)
				{
					if ($Artikel >= 1) $_SESSION['Product_Wishlist'][$id] = $Artikel;
				}
				$AVE_DB->Query("
					UPDATE " . PREFIX . "_modul_shop_merkliste
					SET Inhalt = '" . serialize($_SESSION['Product_Wishlist']) . "'
					WHERE Benutzer = '" . @$_SESSION['user_id'] . "'
				");

				header('Location:' . $_SERVER['HTTP_REFERER']);
				exit;
			}
		}

		if (!empty($row->Inhalt))
		{
			$arr  = @unserialize($row->Inhalt);
			$vars = @unserialize($row->Inhalt_Vars);

			@$_SESSION['Product_Wishlist'] = $arr;
			if ($row->Inhalt_Vars != '') @$_SESSION['Product_Wishlist_Vars'] = $vars;

			$items = array();
			$SummVars = '';

			foreach ($arr as $key => $value)
			{
				$item->Id = $key;
				$item->Val = $value;
				$SummVars = '';

				// mцgliche Produkt - Varianten auslesen und Preis berechnen
				$Vars = array();
				if (!empty($vars))
				{
					$ExVars = explode(',', @$vars[$item->Id]);
					foreach ($ExVars as $ExVar)
					{
						if (!empty($ExVar))
						{
							$row_vars = $AVE_DB->Query("
								SELECT *
								FROM " . PREFIX . "_modul_shop_varianten
								WHERE Id = '" . $ExVar . "'
								ORDER BY Position ASC
							")
							->FetchRow();

							@$row_vars->Wert = $this->_getDiscountVal(@$row_vars->Wert);

							if ($row_vars->Operant == '+')
							{
								$SummVars += @$row_vars->Wert;
							}
							else
							{
								$SummVars -= @$row_vars->Wert;
							}

							$row_var_cat = $AVE_DB->Query("
								SELECT *
								FROM " . PREFIX . "_modul_shop_varianten_kategorien
								WHERE Id = '" . $row_vars->KatId . "'
							")
							->FetchRow();

							$row_vars->VarName = $row_var_cat->Name;
							$row_vars->Wert = ($this->_checkPayVat() == true) ? @$row_vars->Wert : (@$row_vars->Wert / $this->_getVat($key));
							$row_vars->WertE = $row_vars->Wert;
							array_push($Vars, $row_vars);
						}
					}
				}
				$SummVarsE = $SummVars;
				$SummVars = $SummVars*$value;

//				$sql = $AVE_DB->Query("SELECT * FROM " . PREFIX . "_modul_shop_artikel WHERE Id = '" . $key . "'");
//				$row = $sql->FetchRow();
				if (isset($this->_artikel[$key]))
				{
					$row = $this->_artikel[$key];
				}
				else
				{
					$row = $AVE_DB->Query("
						SELECT *
						FROM " . PREFIX . "_modul_shop_artikel
						WHERE Id = '" . $key . "'
					")
					->fetchrow();

					$this->_artikel[$key] = $row;
				}
				if (is_object($row))
				{
					// Эта строка нужна для отображения поного сравнения в закладке
					$item = $row;

					$Einzelpreis = $row->Preis;

					// Preis des Artikels
					$Einzelpreis = $this->_getNewPrice($key, $value, 0, $Einzelpreis);

					// Wenn Benutzer registriert ist, muss hier geschaut werden, welches Land der
					// Benutzer bei der Registrierung angegeben hat, damit der richtige Preis angezeigt wird
					// Wenn nach dem Ansenden des Formulars (Checkout) ein anderes Versandland angegeben wird
					// als bei der Registrierung, muss dieses Land verwendet werden um die Versandkosten zu berechnen
					$PayUSt = $this->_checkPayVat();
					if ($PayUSt != true)
					{
						$row->Preis = $this->_getDiscountVal($Einzelpreis) / $this->_getVat($row->Id);
					}

					// Anzahl jedes Artikels
					$item->Anzahl = $value;

					// Preis Zusammenrechnen
					$Preis+=$row->Preis;

					// Name des Artikels
					$item->ArtName = $row->ArtName;

					$item->ProdLink = $this->_shopRewrite(($this->_product_detail . $row->Id .'&amp;categ=' . $row->KatId . '&amp;navop=' . getParentShopcateg($row->KatId)));
					$item->Hersteller_Name = $this->_fetchManufacturer($row->Hersteller, 'Name');
					$item->Hersteller_Home = $this->_fetchManufacturer($row->Hersteller, 'Link');
					$item->Hersteller_Logo = $this->_fetchManufacturer($row->Hersteller, 'Logo');
					$item->DelLink = $this->_delete_item . $row->Id;

					// Einzelpreis unter Berьcksichtigung von Kundengruppe und Varianten
					// Summe unter Berьcksichtung der Anzahl
					if ($value>1)
					{
						$item->EPreis = (($PayUSt != true) ? (($this->_getDiscountVal($this->_getNewPrice($key, $value, 0, $Einzelpreis))+$SummVarsE) / $this->_getVat($key)) : ($this->_getDiscountVal($this->_getNewPrice($key, $value, 0, $Einzelpreis))+$SummVarsE));
						$item->EPreisSumme = $item->EPreis * $value;
					}
					else
					{
						$item->EPreis = (($PayUSt != true) ? (($this->_getDiscountVal($Einzelpreis)+$SummVarsE) / $this->_getVat($key)) : ($this->_getDiscountVal($Einzelpreis)+$SummVarsE));
						$item->EPreisSumme = (($PayUSt != true) ? (($this->_getDiscountVal($Einzelpreis*$value)+$SummVarsE) / $this->_getVat($key)) : ($this->_getDiscountVal($Einzelpreis)+$SummVarsE)*$value);
					}

					$item->Gewicht = $row->Gewicht*$value;
					$item->ArtNr = $row->ArtNr;

					// Endpreis aller Artikel
					$PreisGesamt += $item->EPreisSumme;
					$GewichtGesamt += $item->Gewicht;

					// Preis 2.Wдhrung
					if (defined('WaehrungSymbol2') && defined('Waehrung2') && defined('Waehrung2Multi'))
					{
						if ($value>1)
						{
							@$item->PreisW2 = (($PayUSt != true) ? (($this->_getDiscountVal($this->_getNewPrice($key, $value, 0, ($Einzelpreis * Waehrung2Multi)))+$SummVarsE) / $this->_getVat($key) * Waehrung2Multi) : ($this->_getDiscountVal($this->_getNewPrice($key, $value, 0, ($Einzelpreis))* Waehrung2Multi)+$SummVarsE));
							@$item->PreisW2Summ = @$item->PreisW2 * $value;
						}
						else
						{
							@$item->PreisW2 = (($PayUSt != true) ? (($this->_getDiscountVal($Einzelpreis)+$SummVarsE) / $this->_getVat($key) * Waehrung2Multi) : ($this->_getDiscountVal($Einzelpreis)+$SummVarsE) * Waehrung2Multi);
							@$item->PreisW2Summ = @$item->PreisW2;
						}
					}

					if ($Vars) $item->Vars = $Vars;
					$item->Bild = $row->Bild;
					$item->Versandfertig = $this->_getTimeTillSend($row->VersandZeitId);

					if (!file_exists('modules/shop/uploads/' . $row->Bild)) $item->BildFehler = 1;

					if ($PayUSt == true)
					{
						$item->Vat = $this->_getVat($key,1);
						$mu = explode('.', $item->Vat);
						$multiplier = (strlen($mu[0]) == 1) ? '1.0' . $mu[0] . $mu[1] : '1.' . $mu[0] . $mu[1];

						$PreisNettoAll = $item->EPreisSumme / $multiplier;
						$PreisNettoAll = $item->EPreisSumme - $PreisNettoAll;
						$PreisNettoAll = round($PreisNettoAll,2);

						$IncVat = $PreisNettoAll;
						@$_SESSION['VatInc'][] = $item->Vat;
						@$_SESSION[$item->Vat] += ($IncVat);
					}

					array_push($items, $item);
					$item = '';
					$row = '';
				}
			}
		}

		return $items;
	}

	//=======================================================
	// Warenkorb
	//=======================================================
	function _showBasketItems()
	{
		global $AVE_DB, $_SESSION;

		$items = '';
		$Preis = '';
		$Vars = '';
		$SummVarsE = '';
//		$PreisV = '';
//		$PreisVarianten = '';
		$PreisGesamt = '';
		$GewichtGesamt = '';
//		$row_ieu = '';

		if (isset($_SESSION['Product']))
		{
			unset($_SESSION['BasketSumm']);
			unset($_SESSION['BasketOverall']);
			unset($_SESSION['VatInc']);
			unset($_SESSION['ShowNoVatInfo']);
			unset($_SESSION['RabattWert']);
			unset($_SESSION['Rabatt']);
			unset($_SESSION['Zwisumm']);
			unset($_SESSION['BasketSummW2']);

			$this->_resetVatZoneSessions();

			$arr = $_SESSION['Product'];
			$items = array();
			$SummVars = '';

			foreach ($arr as $key => $value)
			{
				$item->Id = $key;
				$item->Val = $value;
				$SummVars = '';

				// mцgliche Produkt - Varianten auslesen und Preis berechnen
				$Vars = array();
				if (!empty($_SESSION['ProductVar'][$item->Id]))
				{
					$ExVars = explode(',', $_SESSION['ProductVar'][$item->Id]);
					foreach ($ExVars as $ExVar)
					{
						if (!empty($ExVar))
						{
							$sql_vars = $AVE_DB->Query("
								SELECT *
								FROM " . PREFIX . "_modul_shop_varianten
								WHERE Id = '" . $ExVar . "'
								ORDER BY Position ASC
							");
							$row_vars = $sql_vars->FetchRow();
							$sql_vars->Close();

							@$row_vars->Wert = $this->_getDiscountVal(@$row_vars->Wert);

							if ($row_vars->Operant == '+')
							{
								$SummVars += @$row_vars->Wert;
							}
							else
							{
								$SummVars -= @$row_vars->Wert;
							}

							$sql_var_cat = $AVE_DB->Query("
								SELECT *
								FROM " . PREFIX . "_modul_shop_varianten_kategorien
								WHERE Id = '" . $row_vars->KatId . "'
							");
							$row_var_cat = $sql_var_cat->FetchRow();
							$sql_var_cat->Close();

							$row_vars->VarName = $row_var_cat->Name;
							$row_vars->Wert = ($this->_checkPayVat() == true) ? @$row_vars->Wert : @$row_vars->Wert / $this->_getVat($key);
							$row_vars->WertE = $row_vars->Wert;
							array_push($Vars, $row_vars);
						}
					}
				}
				$SummVarsE = $SummVars;
				$SummVars = $SummVars*$value;

//				$sql = $AVE_DB->Query("SELECT * FROM " . PREFIX . "_modul_shop_artikel WHERE Id = '" . $key . "'");
//				$row = $sql->FetchRow();
				if (isset($this->_artikel[$key]))
				{
					$row = $this->_artikel[$key];
				}
				else
				{
					$sql = $AVE_DB->Query("
						SELECT *
						FROM " . PREFIX . "_modul_shop_artikel
						WHERE Id = '" . $key . "'
					");
					$this->_artikel[$key] = $row = $sql->fetchrow();
				}
				$Einzelpreis = $row->Preis;

				// Preis des Artikels
				$Einzelpreis = $this->_getNewPrice($key, $value, 0, $Einzelpreis);

				// Wenn Benutzer registriert ist, muss hier geschaut werden, welches Land der
				// Benutzer bei der Registrierung angegeben hat, damit der richtige Preis angezeigt wird
				// Wenn nach dem Ansenden des Formulars (Checkout) ein anderes Versandland angegeben wird
				// als bei der Registrierung, muss dieses Land verwendet werden um die Versandkosten zu berechnen
				$PayUSt = $this->_checkPayVat();
				if ($PayUSt != true)
				{
					$row->Preis = $this->_getDiscountVal($Einzelpreis) / $this->_getVat($row->Id);
				}

				// Anzahl jedes Artikels
				$item->Anzahl = $value;

				// Preis Zusammenrechnen
				$Preis+=$row->Preis;

				// Name des Artikels
				$item->ArtName = $row->ArtName;

				$item->ProdLink = $this->_shopRewrite(($this->_product_detail . $row->Id .'&amp;categ=' . $row->KatId . '&amp;navop=' . getParentShopcateg($row->KatId)));
				$item->Hersteller_Name = $this->_fetchManufacturer($row->Hersteller, 'Name');
				$item->Hersteller_Home = $this->_fetchManufacturer($row->Hersteller, 'Link');
				$item->Hersteller_Logo = $this->_fetchManufacturer($row->Hersteller, 'Logo');
				$item->DelLink = $this->_delete_item . $row->Id;

				// Einzelpreis unter Berьcksichtigung von Kundengruppe und Varianten
				// Summe unter Berьcksichtung der Anzahl
				if ($value>1)
				{
					$item->EPreis = (($PayUSt != true) ? (($this->_getDiscountVal($this->_getNewPrice($key, $value, 0, $Einzelpreis))+$SummVarsE) / $this->_getVat($key)) : ($this->_getDiscountVal($this->_getNewPrice($key, $value, 0, $Einzelpreis))+$SummVarsE));
					$item->EPreisSumme = $item->EPreis * $value;
				}
				else
				{
					$item->EPreis = (($PayUSt != true) ? (($this->_getDiscountVal($Einzelpreis)+$SummVarsE) / $this->_getVat($key)) : ($this->_getDiscountVal($Einzelpreis)+$SummVarsE));
					$item->EPreisSumme = (($PayUSt != true) ? (($this->_getDiscountVal($Einzelpreis*$value)+$SummVarsE) / $this->_getVat($key)) : ($this->_getDiscountVal($Einzelpreis)+$SummVarsE)*$value);
				}

				$item->Gewicht = $row->Gewicht*$value;
				$item->ArtNr = $row->ArtNr;


				// Endpreis aller Artikel
				$PreisGesamt += $item->EPreisSumme;
				$GewichtGesamt += $item->Gewicht;

				// Preis 2.Wдhrung
				if (defined('WaehrungSymbol2') && defined('Waehrung2') && defined('Waehrung2Multi'))
				{
					if ($value>1)
					{
						@$item->PreisW2 = (($PayUSt != true) ? (($this->_getDiscountVal($this->_getNewPrice($key, $value, 0, ($Einzelpreis * Waehrung2Multi)))+$SummVarsE) / $this->_getVat($key) * Waehrung2Multi) : ($this->_getDiscountVal($this->_getNewPrice($key, $value, 0, ($Einzelpreis))* Waehrung2Multi)+$SummVarsE));
						@$item->PreisW2Summ = @$item->PreisW2 * $value;
					}
					else
					{
						@$item->PreisW2 = (($PayUSt != true) ? (($this->_getDiscountVal($Einzelpreis)+$SummVarsE) / $this->_getVat($key) * Waehrung2Multi) : ($this->_getDiscountVal($Einzelpreis)+$SummVarsE) * Waehrung2Multi);
						@$item->PreisW2Summ = @$item->PreisW2;
					}
				}

				if ($Vars) $item->Vars = $Vars;
				$item->Bild = $row->Bild;
				$item->Bild_Typ = $row->Bild_Typ;
				$item->Versandfertig = $this->_getTimeTillSend($row->VersandZeitId);

				if (!file_exists('modules/shop/uploads/' . $row->Bild)) $item->BildFehler = 1;

				if ($PayUSt == true)
				{
					$item->Vat = $this->_getVat($key,1);
					$mu = explode('.', $item->Vat);
					@$multiplier = (strlen($mu[0]) == 1) ? '1.0' . $mu[0] . $mu[1] : '1.' . $mu[0] . $mu[1];

					$PreisNettoAll = $item->EPreisSumme / $multiplier;
					$PreisNettoAll = $item->EPreisSumme - $PreisNettoAll;
					$PreisNettoAll = round($PreisNettoAll,2);

					$IncVat = $PreisNettoAll;
					@$_SESSION['VatInc'][] = $item->Vat;
					@$_SESSION[$item->Vat] += ($IncVat);
				}

				array_push($items, $item);
				$item = '';
				$row = '';
			}
			// Eventuellen Kundengruppen - Rabatt berьcksichtigen!

			$PreisVorher = '';

			$_SESSION['Zwisumm'] = ($PreisVorher != '')? $PreisGesamt : $PreisGesamt;
			$_SESSION['BasketSumm'] = $PreisGesamt;
			$_SESSION['BasketSummW2'] = ($PreisGesamt * @Waehrung2Multi);
			$_SESSION['BasketOverall'] = $PreisGesamt;
			$_SESSION['GewichtSumm'] = str_replace(',','.',$GewichtGesamt);;

			// Gutscheincode lцschen
			if (isset($_POST['couponcode_del']) && $_POST['couponcode_del'] == 1 && $this->_getShopSetting('GutscheinCodes') == 1)
			{
				unset($_SESSION['CouponCode']);
				unset($_SESSION['CouponCodeId']);
			}

			// Gutscheincode dem Warenwert abziehen
			if (!empty($_SESSION['CouponCode']) && !isset($_POST['couponcode']))
			{
				$_SESSION['BasketSumm'] = $_SESSION['BasketSumm'] - ($_SESSION['Zwisumm'] / 100 * $_SESSION['CouponCode']);
			}
		}

		return $items;
	}

	function _checkPayVat()
	{
		global $AVE_DB;

		if (!isset($_SESSION['user_country'])) $_SESSION['user_country'] = '';
		if (isset($_POST['Land']) && $_POST['Land'] != $_SESSION['user_country']) $_SESSION['user_country'] = $_POST['Land'];
		if (!empty($_SESSION['user_country']))
		{
			if (isset($this->_landIstEU[$_SESSION['user_country']]) && is_object($this->_landIstEU[$_SESSION['user_country']]))
			{
				$row_ieu = $this->_landIstEU[$_SESSION['user_country']];
			}
			else
			{
				$row_ieu = $AVE_DB->Query("
					SELECT IstEU
					FROM " . PREFIX . "_countries
					WHERE Aktiv = 1
					AND LandCode = '" . $_SESSION['user_country'] . "'
				")
				->FetchRow();

				$this->_landIstEU[$_SESSION['user_country']] = $row_ieu;
			}
		}

		// Muss der Kдufer USt. zahlen?
		// ShipperId
		$PayUSt = true;
		if (isset($row_ieu) && is_object($row_ieu) && $row_ieu->IstEU == 2)
		{
			// Benutzer ist angemeldet, hat Umsatzsteuerbefreiung
			if (!empty($_SESSION['user_id']) &&
				isset($_SESSION['GewichtSumm']) && $_SESSION['GewichtSumm'] >= '0.001' &&
				($this->_getUserInfo(@$_SESSION['user_id'],'UStPflichtig') != 1) || $this->_getUserInfo($_SESSION['user_id'],'UStPflichtig') == 1)
			{
				$PayUSt = false;
			}

			// Benutzer ist angemeldet, hat keine Umsatzsteuerbefreiung
			elseif (!empty($_SESSION['user_id']) &&
				isset($_SESSION['GewichtSumm']) && $_SESSION['GewichtSumm'] < '0.001' &&
				($this->_getUserInfo($_SESSION['user_id'],'UStPflichtig') == 1))
			{
				$PayUSt = true;
				$_SESSION['ShowNoVatInfo'] = 1;
			}

			// Downloadbare Ware?
			// Benutzer ist nicht angemeldet, Versandgewicht ist gegeben!
			elseif (empty($_SESSION['user_id']) &&
				isset($_SESSION['GewichtSumm']) && $_SESSION['GewichtSumm'] >= '0.001') {
				$PayUSt = false;
			}

			// Downloadbare Ware?
			// Benutzer ist nicht angemeldet, Versandgewicht ist nicht gegeben!
			elseif (empty($_SESSION['user_id']) &&
				isset($_SESSION['GewichtSumm']) && $_SESSION['GewichtSumm'] < '0.001')
			{
				$PayUSt = true;
				$_SESSION['ShowNoVatInfo'] = 1;
			}
			else
			{
				if ($this->_getUserInfo($_SESSION['user_id'],'UStPflichtig') != 1)
				{
					$PayUSt = false;
				}
				else
				{
					$PayUSt = true;
				}
			}
		}
		else
		{
			$PayUSt = true;
		}

		return $PayUSt;
	}

	//=======================================================
	// Shop - Startseite
	//=======================================================
	function displayShopStart()
	{
		global $AVE_Template, $_SESSION;

//		$shopitems = array();
		$categs = array();
		$fetchcat = (isset($_GET['categ']) && is_numeric($_GET['categ'])) ? $_GET['categ'] : 0;

		$this->_getCategories($fetchcat, '', $categs, 0);

		$this->_globalProductInfo();

		$AVE_Template->assign('shopitems', $categs);
		$AVE_Template->assign('ShopArticles', $this->_lastArticles());
		$tpl_out = $AVE_Template->fetch($GLOBALS['mod']['tpl_dir'] . $this->_shop_start_tpl);
		define('MODULE_CONTENT', $tpl_out);
		define('MODULE_SITE',(defined('TITLE_EXTRA') ? TITLE_EXTRA : $GLOBALS['mod']['config_vars']['PageName'] ));
	}

	//=======================================================
	// Produkt - Details
	//=======================================================
	// Rezensionen
	function _fetchArticleComments()
	{
		global $AVE_DB;

		$comments = array();
		$sql = $AVE_DB->Query("
			SELECT
				cmnt.*,
				CONCAT(usr.Vorname, ' ', usr.Nachname) AS Autor
			FROM " . PREFIX . "_modul_shop_artikel_kommentare AS cmnt
			LEFT JOIN " . PREFIX . "_users AS usr ON usr.Id = cmnt.Benutzer
			WHERE Publik = 1
			AND ArtId = '" . (int)$_REQUEST['product_id'] . "'
			ORDER BY cmnt.Id DESC
		");
		while ($row = $sql->FetchRow())
		{
			$row->Titel = htmlspecialchars($row->Titel);
			$row->Kommentar = nl2br(htmlspecialchars($row->Kommentar));
			array_push($comments, $row);
		}

		return $comments;
	}

	/**
	 * Детальная информация о товаре
	 *
	 * @param int $product_id идентификатор товара
	 */
	function showDetails($product_id)
	{
		global $AVE_DB, $AVE_Template;

		if (Kommentare == 1 && isset($_REQUEST['sendcomment']) && $_REQUEST['sendcomment'] == 1 && isset($_SESSION['user_id']))
		{
			$sql = $AVE_DB->Query("
				SELECT Benutzer
				FROM " . PREFIX . "_modul_shop_artikel_kommentare
				WHERE Benutzer = '" . $_SESSION['user_id'] . "'
				AND ArtId = '" . $_REQUEST['product_id'] . "'
			");
			$num = $sql->NumRows();

			if ($num < 1)
			{
				$AVE_DB->Query("
					INSERT INTO " . PREFIX . "_modul_shop_artikel_kommentare
					SET
						ArtId     = '" . $_REQUEST['product_id'] . "',
						Benutzer  = '" . $_SESSION['user_id'] . "',
						Datum     = '" . time() . "',
						Titel     = '" . $_REQUEST['ATitel'] . "',
						Kommentar = '" . $_REQUEST['AKommentar'] . "',
						Wertung   = '" . (((int)$_REQUEST['AWertung'] > 5 || (int)$_REQUEST['AWertung'] < 1) ? 3 : (int)$_REQUEST['AWertung'] ) . "',
						Publik    = 0
				");

				$SystemMail = get_settings('mail_from');
				$SystemMailName = get_settings('mail_from_name');

				$URLAdmin = explode('?', $_SERVER['HTTP_REFERER']);
				$URLAdmin = str_replace('index.php', '', $URLAdmin[0]) . 'admin/index.php?do=modules&action=modedit&mod=shop&moduleaction=edit_comments&pop=1&Id=' . $_REQUEST['product_id'];

				$Text = $GLOBALS['mod']['config_vars']['CommentATextMail'];
				$Text = str_replace('%N%', "\n", $Text);
				$Text = str_replace('%URL%', $_SERVER['HTTP_REFERER'], $Text);
				$Text = str_replace('%URLADMIN%', $URLAdmin, $Text);

				send_mail(
					$SystemMail,
					$Text . stripslashes($_REQUEST['AKommentar']),
					$GLOBALS['mod']['config_vars']['CommentASubject'],
					$SystemMail,
					$SystemMailName,
					'text',
					''
				);
			}

			header('Location:index.php?module=shop&action=product_detail&product_id='.$_REQUEST['product_id'].'&categ='.$_REQUEST['categ'].'&navop='.$_REQUEST['navop']);
			exit;
		}

		$product_id = (int)$product_id;
		$sql = $AVE_DB->Query("
			SELECT *
			FROM " . PREFIX . "_modul_shop_artikel
			WHERE Aktiv = 1
			AND Id = '" . $product_id . "'
			AND Erschienen <= '" . time() . "'
		");
		$row = $sql->FetchRow();

		$the_nav = $this->_getNavigationPath((int)$_REQUEST['categ'], '', 1, (int)$_REQUEST['navop']);
		$AVE_Template->assign('topnav', $the_nav);
		$AVE_Template->assign('StPrices', $this->_getStPrices($product_id));

		$row = $this->_globalProductInfo($row);

		$MultiImages = array();
		$sql_bilder = $AVE_DB->Query("
			SELECT *
			FROM " . PREFIX . "_modul_shop_artikel_bilder
			WHERE ArtId = '" . $row->Id . "'
		");
		while ($row_bilder = $sql_bilder->FetchRow())
		{
			$bild_typ = strtolower(substr($row_bilder->Bild,-4));
			switch ($bild_typ)
			{
				case 'jpeg' :
				case '.jpe' :
				case 'jpg' :
				default :
					$row_bilder->endung = 'jpg';
					break;

				case '.png' :
					$row_bilder->endung = 'png';
					break;

				case '.gif' :
					$row_bilder->endung = 'gif';
					break;
			}
			if (file_exists(BASE_DIR . '/modules/shop/uploads/' . $row_bilder->Bild)) {
				array_push($MultiImages, $row_bilder);
			}
		}

		$row->MultiImages = $MultiImages;

		$AVE_Template->assign('row', $row);

		if (is_object($row))
		{
			$AVE_Template->assign('equalProducts', $this->_equalProducts($row->Schlagwoerter));
			$AVE_Template->assign('Variants', $this->_getVariants($row->KatId, $row->Id));
			if (isset($_SESSION['Product']) && isset($_SESSION['Product'][$row->Id])) $AVE_Template->assign('InBasket', 1);
		}

		// Sind Rezensionen erlaubt ?
		if (Kommentare == 1)
		{
			$sql_w = $AVE_DB->Query("
				SELECT
					ROUND(AVG(Wertung)) AS Proz,
					COUNT(*) AS Anz
				FROM " . PREFIX . "_modul_shop_artikel_kommentare
				WHERE Publik = 1
				AND ArtId = '" . (int)$_REQUEST['product_id'] . "'
			");
			$row_w = $sql_w->FetchRow();

//			$sql_a = $AVE_DB->Query("
//				SELECT Id
//				FROM " . PREFIX . "_modul_shop_artikel_kommentare
//				WHERE Publik = 1
//				AND ArtId = '" . (int)$_REQUEST['product_id'] . "'
//			");
//			$num_a = $sql_a->NumRows();
//
//			$row_w->Anz = $num_a;
//			@$row_w->Proz = round($row_w->Wertung / $num_a);

			$AVE_Template->assign('rez', $row_w);
			$AVE_Template->assign('AllowComments', 1);
			$AVE_Template->assign('Comments', $this->_fetchArticleComments());
		}
		if (Kommentare == 1 && isset($_SESSION['user_id']))
		{
			$AVE_Template->assign('CanComment', 1);
//			$AVE_Template->assign('Comments', $this->_fetchArticleComments());
		}

		$tpl_out = $AVE_Template->fetch($GLOBALS['mod']['tpl_dir'] . $this->_shop_product_detailpage);
		$tpl_out = $this->_shopRewrite($tpl_out);

		define('MODULE_CONTENT', $tpl_out);
		define('MODULE_SITE', $GLOBALS['mod']['config_vars']['PageName'] . $GLOBALS['mod']['config_vars']['PageSep'] . @$row->ArtName);
	}

	//=======================================================
	// Verwandte Produkte
	//=======================================================
	function _equalProducts($Matchwords)
	{
		global $AVE_DB;

		$shopitems = array();
		$prod_id = array();
		if ($Matchwords)
		{
			$Matchword = @explode(',', $Matchwords);
			foreach ($Matchword as $Match)
			{
				$sql = $AVE_DB->Query("
					SELECT *
					FROM " . PREFIX . "_modul_shop_artikel
					WHERE Aktiv = 1
					AND Id != '" . (int)$_REQUEST['product_id'] . "'
					AND Schlagwoerter LIKE '%" . $Match . "%'
					ORDER BY rand()
					LIMIT 5
				");
				while ($row = $sql->FetchRow())
				{
					$row = $this->_globalProductInfo($row);
					if (!in_array($row->Id, $prod_id)) array_push($shopitems, $row);
					$prod_id[] = $row->Id;
				}
			}
		}

		return 	$shopitems;
	}

	//=======================================================
	// Produkt in den Warenkorb legen
	//=======================================================
	function addtoBasket($product_id, $can_update = 0, $to_wishlist = 0)
	{
		global $AVE_DB;

		$to_wishlist = (isset($_REQUEST['wishlist_'.$_REQUEST['product_id']]) && $_REQUEST['wishlist_'.$_REQUEST['product_id']] == 1 ) ? 1 : 0;
		if ($to_wishlist == 1) $can_update=1;

		$product_id = (int)$product_id;
		$amount = (int)$_REQUEST['amount'];
		if (($amount > 0) && ($can_update == 1 || !isset($_SESSION['Product'][$_REQUEST['product_id']]) || !in_array($_REQUEST['id'], $_SESSION['Product'])))
		{
			if (isset($_REQUEST['product_id']) && is_numeric($_REQUEST['product_id']))
			{
				if ($to_wishlist != 1)
				{
					$_SESSION['Product'][$_REQUEST['product_id']] = $amount;

					// Mцgliche Varianten in Session
					// Hier wird ein Produkt aus dem Wunschzettel abgelegt
					if (!empty($_REQUEST['vars']))
					{
						if (!empty($_REQUEST['vars']))
						{
							$Vars_To_Session =$_REQUEST['vars'];
							$_SESSION['ProductVar'][$_REQUEST['product_id']] = $Vars_To_Session;
						}
						else
						{
							$Vars_To_Session = chop(base64_decode($_REQUEST['vars']));
						}
						$_SESSION['ProductVar'][$_REQUEST['product_id']] = $Vars_To_Session;
					}

					// Hier wird ein normal (nicht aus dem Wunschzettel) abgelegt
					if (isset($_POST['product_vars']) && is_array($_POST['product_vars']))
					{
						$Vars_To_Session = implode(',', $_REQUEST['product_vars']);
						$_SESSION['ProductVar'][$_REQUEST['product_id']] = $Vars_To_Session;
					}
				}

				// In Wunschliste?
				if ($to_wishlist == 1)
				{
					$sql = $AVE_DB->Query("
						SELECT *
						FROM " . PREFIX . "_modul_shop_merkliste
						WHERE Benutzer = '".$_SESSION['user_id']."'
					");
					$row = $sql->FetchRow();
					if (is_object($row) && $row->Id != '')
					{
						// Vorhandene Eintrдge auslesen und aktualisieren
						$_SESSION['Product_Wishlist'] = unserialize($row->Inhalt);
						$_SESSION['Product_Wishlist_Vars'] = unserialize($row->Inhalt_Vars);
						$_SESSION['Product_Wishlist'][$_REQUEST['product_id']] = $amount;
						$Vars_To_Session = implode(',', $_REQUEST['product_vars']);
						$_SESSION['Product_Wishlist_Vars'][$_REQUEST['product_id']] = $Vars_To_Session;
						$_SESSION['Product_Wishlist'][$_REQUEST['product_id']] = $amount;

						$AVE_DB->Query("
							UPDATE
								" . PREFIX . "_modul_shop_merkliste
							SET
								Inhalt = '".serialize($_SESSION['Product_Wishlist'])."',
								Inhalt_Vars = '".serialize($_SESSION['Product_Wishlist_Vars'])."'
							WHERE
								Benutzer = '".$_SESSION['user_id']."'
						");
					}
					else
					{
						// Neu
						// mцgliche Varianten
						$Db_Vars = '';
						if (isset($_POST['product_vars']) && is_array($_POST['product_vars']))
						{
							$Vars_To_Session = implode(',', $_REQUEST['product_vars']);
							$_SESSION['Product_Wishlist_Vars'][$_REQUEST['product_id']] = $Vars_To_Session;
							$Db_Vars = serialize($_SESSION['Product_Wishlist_Vars']);
						}

						$_SESSION['Product_Wishlist'][$_REQUEST['product_id']] = $amount;
						$AVE_DB->Query("
							INSERT INTO " . PREFIX . "_modul_shop_merkliste
							SET
								Benutzer    = '" . $_SESSION['user_id'] . "',
								Ip          = '" . $_SERVER['REMOTE_ADDR'] . "',
								Inhalt      = '" . serialize($_SESSION['Product_Wishlist']) . "',
								Inhalt_Vars = '" . $Db_Vars . "'
						");
					}
				}
			}
		}

		header('Location:' . $_SERVER['HTTP_REFERER']);
		exit;
	}

	//=======================================================
	// Produkt aus dem Warenkorb entfernen
	//=======================================================
	function delItem($product_id)
	{
		$product_id = (int)$product_id;
		unset($_SESSION['Product'][$product_id]);
		unset($_SESSION['ProductVar'][$product_id]);
		unset($_SESSION['BasketSumm']);
		unset($_SESSION['ShipperId']);
		unset($_SESSION['GewichtSumm']);
		unset($_SESSION['PaymentId']);

		header('Location:' . $_SERVER['HTTP_REFERER']);
		exit;
	}

	//=======================================================
	// Globale Produkt-Infos
	// Wurd fьr mehrere Ausgaben benцtigt
	//=======================================================
	function _globalProductInfo($row = '')
	{
		global $AVE_Template;

		if (is_object($row))
		{
			$PayUSt = $this->_checkPayVat();

			$mu = explode('.', $this->_getUstVal($row->UstZone));
			@$multiplier = (strlen($mu[0]) == 1) ? '1.0' . $mu[0] . $mu[1] : '1.' . $mu[0] . $mu[1];

			$row->Preis           = ($PayUSt == true) ? $this->_getDiscountVal($row->Preis) : ($this->_getDiscountVal($row->Preis) / $this->_getVat($row->Id));
			$row->PreisListe_Raw  = $row->PreisListe;
			$row->PreisDiff       = ($row->PreisListe_Raw > $row->Preis) ? ($row->PreisListe_Raw-$row->Preis) : '';
			$row->Preis_Raw       = $row->Preis;
			$row->Preis_Netto     = $row->Preis / $multiplier;
			$row->Preis_Netto_Out = $row->Preis / $multiplier;
			$row->Preis_USt       = $row->Preis - $row->Preis_Netto;
//			$row->Preis           = $row->Preis;
			$row->NettoAnzeigen   = ($PayUSt == true) ? 1 : 0;
			$row->AddToLink       = $this->_shopRewrite($this->_add_item . $row->Id);
			$row->AddToWishlist   = $this->_shopRewrite($this->_add_item_wishlist . $row->Id);
			$row->Detaillink      = $this->_shopRewrite($this->_product_detail . $row->Id . '&amp;categ=' . $row->KatId . '&amp;navop=' . getParentShopcateg($row->KatId));
			$row->StPrices        = $this->_getStPrices($row->Id);

			if ($row->Hersteller)
			{
				$row->Hersteller_Name = $this->_fetchManufacturer($row->Hersteller, 'Name');
				$row->Hersteller_Home = $this->_fetchManufacturer($row->Hersteller, 'Link');
				$row->Hersteller_Logo = $this->_fetchManufacturer($row->Hersteller, 'Logo');
				$row->Hersteller_Link = $this->_shopRewrite($this->_link_manufaturer . $row->Hersteller);
			}

			if ($row->Einheit > 0)
			{
				if ($this->_setings->ZeigeEinheit == 1) $row->Einheit_Preis = $row->Preis / $row->Einheit;
				$row->Einheit_Art   = $this->_getUnit($row->EinheitId);
				$row->Einheit_Art_S = $this->_getUnit($row->EinheitId,1);
			}

			if ($row->VersandZeitId > 0) $row->Versandfertig = $this->_getTimeTillSend($row->VersandZeitId);

			if (isset($_SESSION['Product']) && isset($_SESSION['Product'][$row->Id])) $row->InBasket = 1;

			if ($row->Bild == '' || !file_exists('modules/shop/uploads/' . $row->Bild))
			{
				$row->BildFehler = 1;
			}
			else
			{
				// Thumbnail existiert, also einfacher Pfad (schneller)
				if (file_exists('modules/shop/thumbnails/shopthumb__' . WidthThumbs . '__' . $row->Bild))
				{
					$row->ImgSrc = 'modules/shop/thumbnails/shopthumb__' . WidthThumbs . '__' . $row->Bild;
				}
				// Wenn Thumbnail nicht existiert, erzeugen
				else
				{
					$row->ImgSrc = 'FALSE';
				}
			}

			if ($this->_setings->ZeigeNetto == 1) $row->ZeigeNetto = 1;

//			if (Kommentare == 1) {
//				$sql_w = $AVE_DB->Query("
//					SELECT
//						ROUND(AVG(Wertung)) AS Proz,
//						COUNT(*) AS Anz
//					FROM " . PREFIX . "_modul_shop_artikel_kommentare
//					WHERE Publik = 1
//					AND ArtId = '" . $row->Id . "'
//				");
//				$row_w = $sql_w->FetchRow();
//				$row->Prozwertung = $row_w->Proz;
//			}

			if (!empty($this->_setings->Waehrung2) && !empty($this->_setings->WaehrungSymbol2) && !empty($this->_setings->Waehrung2Multi))
			{
				$row->PreisW2 = ($row->Preis_Raw * $this->_setings->Waehrung2Multi);
			}
		}

		$AVE_Template->register_function('get_parent_shopcateg', 'getParentShopcateg');

		$AVE_Template->assign('BasketItems',      $this->_showBasketItems());
		$AVE_Template->assign('Currency',         $this->_setings->WaehrungSymbol);
		$AVE_Template->assign('KaufLagerNull',    $this->_setings->KaufLagerNull);
		$AVE_Template->assign('ProductCategs',    $this->fetchShopNavi(1));
		$AVE_Template->assign('Manufacturer',     $this->_displayManufacturer());
		$AVE_Template->assign('ShopStartLink',    $this->_shopRewrite('index.php?module=shop'));
		$AVE_Template->assign('ShowWishlistLink', $this->_shopRewrite('index.php?module=shop&amp;action=wishlist&amp;pop=1'));
		$AVE_Template->assign('ShowBasketLink',   $this->_shopRewrite('index.php?module=shop&amp;action=showbasket'));
		$AVE_Template->assign('ShowPaymentLink',  $this->_shopRewrite('index.php?module=shop&amp;action=checkout'));
		$AVE_Template->assign('CheckoutLink',     $this->_shopRewrite('index.php?module=shop&amp;action=checkout'));

		return $row;
	}

	// ================================================================
	// Erzeugt einen Pfad zur aktuellen Position
	// ================================================================
	function _getNavigationPath($id, $result = null, $extra = 0, $nav_op = 0)
	{
		global $AVE_DB;

		// daten des aktuellen bereichs
		$r_item = $AVE_DB->Query("
			SELECT
				Id,
				KatName,
				Elter
			FROM " . PREFIX . "_modul_shop_kategorie
			WHERE Id = '" . $id . "'
		");
		$item = $r_item->FetchRow();

		if (is_object($item))
		{
//			$esn = $item->Elter;
			$result_link = $this->_shopRewrite('index.php?module=shop&amp;categ=' . $item->Id .'&amp;parent=' . $item->Elter . '&amp;navop=' . getParentShopcateg($item->Id));
			if ($item->Elter == 0) return '<a class="mod_shop_navi" href="index.php?module=shop">'.$GLOBALS['mod']['config_vars']['PageName'].'</a>'.$GLOBALS['mod']['config_vars']['PageSep'].'<a class="mod_shop_navi" href="' . $result_link . '">' . $item->KatName . '</a>' . ($result ? $GLOBALS['mod']['config_vars']['PageSep'] : '') . $result;

			// Daten des darьberliegenden Bereiches
//			$r_parent = $AVE_DB->Query("SELECT Id,KatName,Elter FROM " . PREFIX . "_modul_shop_kategorie WHERE Id = " . $item->Elter);
//			$parent = $r_parent->FetchRow();

//			$result_link = $this->_shopRewrite('index.php?module=shop&amp;categ=' . $item->Id . '&amp;parent=' . $item->Elter . '&amp;navop=' . getParentShopcateg($item->Id));
			$result = '<a class="mod_shop_navi" href="' . $result_link . '">' . $item->KatName . '</a>' . ($result ? $GLOBALS['mod']['config_vars']['PageSep'] : '') . $result ;

			return $this->_getNavigationPath($item->Elter, $result, $extra, $nav_op);
		}

		return '';
	}

	//=======================================================
	// Benutzerinformationen abfragen
	//=======================================================
	function _getUserInfo($user = '', $field = '')
	{
		global $AVE_DB;

		if ($user != '')
		{
			if (isset($this->_user[$user]) && is_object($this->_user[$user]))
			{
				$row = $this->_user[$user];
			}
			else
			{
				$sql = $AVE_DB->Query("
					SELECT *
					FROM " . PREFIX . "_users
					WHERE Status = 1
					AND Id = '" . $user . "'
				");
				while ($row = $sql->FetchRow())
				{
					$this->_user[$row->Id] = $row;
				}
				$sql->Close();
				$row = $this->_user[$user];
			}

			return $row->$field;
		}

		return '';
	}

	//=======================================================
	// Umsatz - Steuer (Prozentsatz auslesen)
	//=======================================================
	function _getUstVal($UstId)
	{
		global $AVE_DB;

		if ($UstId == 0) return '';
//		if (isset($this->_ust[$UstId]) && is_object($this->_ust[$UstId]))
		if (isset($this->_ust[$UstId]))
		{
			$row = $this->_ust[$UstId];
		}
		else
		{
			$sql = $AVE_DB->Query("SELECT * FROM " . PREFIX . "_modul_shop_ust");
			while ($row = $sql->FetchRow())
			{
				$this->_ust[$row->Id] = $row;
			}
			$sql->Close();
			$row = $this->_ust[$UstId];
		}

		return $row->Wert;
	}

	//=======================================================
	// Funktion zur Preisberechnung und Ausgabe
	//=======================================================
	function _getVat($productId, $showPercent = '')
	{
		global $AVE_DB;
//		$sql = $AVE_DB->Query("SELECT Preis,UstZone FROM " . PREFIX . "_modul_shop_artikel WHERE Id = '" . $productId . "'");
//		$row = $sql->FetchRow();
		if (isset($this->_preisUstZone[$productId]))
		{
			$row = $this->_preisUstZone[$productId];
		}
		else
		{
			$sql = $AVE_DB->Query("
				SELECT
					Preis,
					UstZone
				FROM " . PREFIX . "_modul_shop_artikel
				WHERE Id = '" . $productId . "'
			");
			$row = $sql->FetchRow();
			$this->_preisUstZone[$productId] = $row;
		}

		if (is_object($row) && $row->UstZone != 0)
		{
			if (!isset($this->_ust[$row->UstZone]))
			{
				$sql = $AVE_DB->Query("SELECT * FROM " . PREFIX . "_modul_shop_ust");
				while ($row2 = $sql->FetchRow())
				{
					$this->_ust[$row2->Id] = $row2;
				}
			}
			$row2 = $this->_ust[$row->UstZone];
		}
		else
		{
			$row2->Wert = '0.00';
		}
//		$sql->Close();

		$mu = explode('.', $row2->Wert);
		@$multiplier = (strlen($mu[0]) == 1) ? '1.0' . $mu[0] . $mu[1] : '1.' . $mu[0] . $mu[1];

		$vat = ($showPercent == 1) ? $row2->Wert : $multiplier;

		return $vat;//echo "$row->Preis / 100 * $row2->Wert --> $vat Ђ (Multi:$multiplier)<br>";
	}

	//=======================================================
	// Hersteller anzeigen
	//=======================================================
	function _fetchManufacturer($Hersteller, $fld = 'Name')
	{
		if (empty($this->_manufacturer))
		{
			global $AVE_DB;

			$this->_manufacturer = array();
			$sql = $AVE_DB->Query("
				SELECT *
				FROM " . PREFIX . "_modul_shop_hersteller
				ORDER BY Name ASC
			");
			while ($row = $sql->FetchRow())
			{
				$this->_manufacturer[$row->Id] = $row;
			}
		}

		return @$this->_manufacturer[$Hersteller]->$fld;
	}

	function _displayManufacturer()
	{
		if (empty($this->_manufacturer))
		{
			global $AVE_DB;

			$this->_manufacturer = array();
			$sql = $AVE_DB->Query("
				SELECT *
				FROM " . PREFIX . "_modul_shop_hersteller
				ORDER BY Name ASC
			");
			while ($row = $sql->FetchRow())
			{
				$this->_manufacturer[$row->Id] = $row;
			}
		}

		return $this->_manufacturer;
	}

	//=======================================================
	// Einheiten
	//=======================================================
	function _getUnit($Unit, $NameEinzahl='')
	{
		global $AVE_DB;

		if (empty($this->_units[$Unit]))
		{
//			$Units = array();
			$sql = $AVE_DB->Query("
				SELECT
					Id,
					Name,
					NameEinzahl
				FROM " . PREFIX . "_modul_shop_einheiten
			");
			while ($row = $sql->FetchRow())
			{
				$this->_units[$row->Id] = $row;
			}
		}
		@$row = $this->_units[$Unit];

		if (!empty($row->NameEinzahl) && $NameEinzahl == 1) return @$row->NameEinzahl;

		return @$row->Name;
	}

	//=======================================================
	// Varianten
	//=======================================================
	function _getVariants($KatId, $ArtId)
	{
		global $AVE_DB;

		$Variants = array();
		$Printout = false;
		$sql = $AVE_DB->Query("
			SELECT *
			FROM " . PREFIX . "_modul_shop_varianten_kategorien
			WHERE Aktiv = 1
			AND KatId = '" . $KatId . "'
		");
		while ($row = $sql->FetchRow())
		{
			$row->Beschreibung = str_replace('"', "'", $row->Beschreibung);
			$Variants_Items = array();
			$sql_v = $AVE_DB->Query("
				SELECT *
				FROM " . PREFIX . "_modul_shop_varianten
				WHERE KatId = '" . $row->Id . "'
				AND ArtId = '" . $ArtId . "'
				ORDER BY Position ASC
			");
			while ($row_v = $sql_v->FetchRow())
			{
				$Printout = true;
				$row_v->Wert = ($this->_checkPayVat() == true) ? $this->_getDiscountVal($row_v->Wert) : $this->_getDiscountVal($row_v->Wert) / $this->_getVat($ArtId);
				array_push($Variants_Items, $row_v);
			}

			$row->VarItems = $Variants_Items;
			$row->VarName = $row->Name;
			array_push($Variants, $row);
		}

		if ($Printout == true) return $Variants;

		return '';
	}

	function _getStPrices($ArtId)
	{
		if (!isset($this->_price[$ArtId]))
		{
			global $AVE_DB;

			$StPrices = array();
			$sql = $AVE_DB->Query("
				SELECT *
				FROM " . PREFIX . "_modul_shop_staffelpreise
				WHERE ArtId = '" . $ArtId . "'
				ORDER BY StkVon ASC
			");
			while ($row = $sql->FetchRow())
			{
				$row->Preis = ($this->_checkPayVat() == true) ? $this->_getDiscountVal($row->Preis) : $this->_getDiscountVal($row->Preis) / $this->_getVat($ArtId);
				array_push($StPrices, $row);
			}
			$sql->Close();
			$this->_price[$ArtId] = $StPrices;
		}

		return $this->_price[$ArtId];
	}

	function _getNewPrice($ArtId, $Amount = '', $Max = '', $Price = '')
	{
		global $AVE_DB;

		$key = md5(serialize(array($ArtId, $Amount, $Max)));
		if (isset($this->_price[$key]))
		{
			$row = $this->_price[$key];
		}
		else
		{
			if ($Max == 1)
			{
				$sql = $AVE_DB->Query("
					SELECT Preis
					FROM " . PREFIX . "_modul_shop_staffelpreise
					WHERE ArtId = '" . $ArtId . "'
					ORDER BY StkBis DESC
					LIMIT 1
				");
			}
			else
			{
				$sql = $AVE_DB->Query("
					SELECT Preis
					FROM " . PREFIX . "_modul_shop_staffelpreise
					WHERE ArtId = '" . $ArtId . "'
					AND StkVon <= " . $Amount . "
					AND StkBis >= " . $Amount
				);
			}
			$this->_price[$key] = $row = $sql->fetchrow();
			$sql->close();
		}

		if (is_object($row))
		{
			return  $row->Preis;
		}

		return $Price;
	}

	function _getTimeTillSend($Id, $Zeile = 'Name')
	{
		global $AVE_DB;

		if ($Id == 0) return '';
		if (isset($this->_shipTime[$Id]) && is_object($this->_shipTime[$Id]))
		{
		}
		else
		{
			$sql = $AVE_DB->Query("SELECT * FROM " . PREFIX . "_modul_shop_versandzeit");
			while ($row = $sql->FetchRow())
			{
				$this->_shipTime[$row->Id] = $row;
			}
			$sql->Close();
		}

		return @$this->_shipTime[$Id]->$Zeile;
	}

	//=======================================================
	// Warenkorb
	//=======================================================
	function showBasket()
	{
		global $AVE_Template;

		if (isset($_REQUEST['refresh']) && $_REQUEST['refresh'] == 1)
		{
			if (isset($_POST['del_product']) && is_array($_POST['del_product']))
			{
				foreach ($_POST['del_product'] as $id => $Artikel)
				{
					unset($_SESSION['Product'][$id]);
				}

				header('Location:' . $_SERVER['HTTP_REFERER']);
				exit;
			}

			if (isset($_POST['amount']) && is_array($_POST['amount']))
			{
				foreach ($_POST['amount'] as $id => $Artikel)
				{
					if ($Artikel >= 1) $_SESSION['Product'][$id] = $Artikel;
				}

				header('Location:' . $_SERVER['HTTP_REFERER']);
				exit;
			}
		}

		$this->_globalProductInfo();

		$AVE_Template->assign('VatZones', $this->_showVatZones());
		$tpl_out = $AVE_Template->fetch($GLOBALS['mod']['tpl_dir'] . 'shop_basket.tpl');
		define('MODULE_CONTENT', $tpl_out);
		define('MODULE_SITE', $GLOBALS['mod']['config_vars']['PageName'] . $GLOBALS['mod']['config_vars']['PageSep'] . $GLOBALS['mod']['config_vars']['ShopBasket']);
	}

	/** ФУНКЦИЯ НАФИГ
	 * Процент скидки на товары для группы пользователя
	 *
	 * @return float процент скидки
	 */
	function customerDiscount()
	{
		if (!isset($this->_discount))
		{
			global $AVE_DB;

			$sql = $AVE_DB->Query("
				SELECT
					Benutzergruppe,
					IFNULL(Wert, '0.00') AS Wert
				FROM " . PREFIX . "_user_groups
				LEFT JOIN " . PREFIX . "_modul_shop_kundenrabatte ON GruppenId = Benutzergruppe
			");
			while ($row = $sql->FetchRow())
			{
				$this->_discount[$row->GruppenId] = $row->Wert;
			}
			$sql->Close();
		}

		return $this->_discount[UGROUP];
	}

	/**
	 * Цена с учетом скидки для текущей группы пользователей
	 *
	 * @param float $val цена
	 * @return float цена с учетом скидки
	 */
	function _getDiscountVal($val)
	{
		if (!isset($this->_discount))
		{
			global $AVE_DB;

			$sql = $AVE_DB->Query("
				SELECT
					Benutzergruppe,
					IFNULL(Wert, '0.00') AS Wert
				FROM " . PREFIX . "_user_groups
				LEFT JOIN " . PREFIX . "_modul_shop_kundenrabatte ON GruppenId = Benutzergruppe
			");
			while ($row = $sql->FetchRow())
			{
				$this->_discount[$row->Benutzergruppe] = $row->Wert;
			}
			$sql->Close();
		}

		return $val - ($val / 100 * $this->_discount[UGROUP]);
	}

	//=======================================================
	// Login
	//=======================================================
	function _loginProcess()
	{
		global $AVE_DB, $AVE_Template;

		if (!empty($_POST['shop_user_login']) && !empty($_POST['shop_user_pass']))
		{
			sleep(1);

			$row = $AVE_DB->Query("
				SELECT
					usr.Id,
					usr.Benutzergruppe,
					UserName,
					Vorname,
					Nachname,
					Email,
					Land,
					Rechte,
					Kennwort,
					salt,
					`Status`
				FROM
					" . PREFIX . "_users AS usr
				JOIN
					" . PREFIX . "_user_groups AS grp
						ON grp.Benutzergruppe = usr.Benutzergruppe
				WHERE Email = '" . $_POST['shop_user_login'] . "'
				OR `UserName` = '" . $_POST['shop_user_login'] . "'
				LIMIT 1
			")->FetchRow();

			switch (@$row->Status)
			{
				case 1:
					$password = md5(md5(trim($_POST['user_pass']) . $row->salt));

					if ($password == $row->Kennwort)
					{
						$AVE_DB->Query("
							UPDATE " . PREFIX . "_users
							SET ZuletztGesehen = " . time() . "
							WHERE Id = " . $row->Id . "
						");

						$row->Rechte = str_replace(array(' ', "\n", "\r\n"), '', $row->Rechte);
						$permissions = explode('|', $row->Rechte);
						foreach($permissions as $permission) $_SESSION[$permission] = 1;

						$_SESSION['user_id']       = $row->Id;
						$_SESSION['user_group']    = $row->Benutzergruppe;
						$_SESSION['user_name']     = get_username($row->UserName, $row->Vorname, $row->Nachname);
						$_SESSION['user_pass']     = $password;
						$_SESSION['user_email']    = addslashes($row->Email);
						$_SESSION['user_country']  = strtoupper($row->Land);
						$_SESSION['user_language'] = strtolower($row->Land);
						$_SESSION['user_ip']       = addslashes($_SERVER['REMOTE_ADDR']);

//						$_SESSION['admin_theme'] = DEFAULT_ADMIN_THEME_FOLDER;
//						$_SESSION['admin_language'] = DEFAULT_LANGUAGE;

						if (isset($_POST['SaveLogin']) && $_POST['SaveLogin'] == 1)
						{
							$expire = time() + COOKIE_LIFETIME;
							@setcookie('auth_id', $row->Id, $expire);
							@setcookie('auth_hash', $password, $expire);
						}

						header('Location:index.php?module=shop&action=checkout');
						exit;
					}
					else
					{
						unset($_SESSION['user_id']);
						unset($_SESSION['user_pass']);

						$AVE_Template->assign('login', 'false');
					}
					break;

				default:
					unset($_SESSION['user_id']);
					unset($_SESSION['user_pass']);

					$AVE_Template->assign('login', 'false');
					break;
			}
		}
		else
		{
			$AVE_Template->assign('login', 'false');
		}
	}

	//=======================================================
	// Versandmethoden
	//=======================================================
	function _fetchShipper($id)
	{
		global $AVE_DB;

		$Name = $AVE_DB->Query("
			SELECT Name
			FROM " . PREFIX . "_modul_shop_versandarten
			WHERE Id = '" . $id . "'
			AND Aktiv = 1
		")
		->GetCell();

		return $Name;
	}

	function _shipperSumm($land = '', $Id = '')
	{
		global $AVE_DB;

		$Betrag = $AVE_DB->Query("
			SELECT Betrag
			FROM " . PREFIX . "_modul_shop_versandkosten
			WHERE Land = '" . $land . "'
			AND VersandId = '" . $Id . "'
			AND (" . $_SESSION['GewichtSumm'] . " BETWEEN KVon AND KBis)
			LIMIT 1
		")
		->GetCell();

		return @$Betrag;
	}

	function _showShipper($land = '')
	{
		global $AVE_DB, $AVE_Template;

		$shipper = array();
		$si_count = 0;
		$sql = $AVE_DB->Query("
			SELECT *
			FROM " . PREFIX . "_modul_shop_versandarten
			WHERE Aktiv = 1
		");
		while ($row = $sql->FetchRow())
		{
			$row->L = explode(',', $row->LaenderVersand);
			if ($row->NurBeiGewichtNull == 1 && $_SESSION['GewichtSumm'] > '0.00')
			{
				// Versabdart anzeigen, die nur fьr Downloads gedacht sind!
			}
			else
			{
				if (in_array($land,$row->L))
				{
					$dbex = ($row->KeineKosten == 1) ? '' : 'AND (' . $_SESSION['GewichtSumm'] . ' BETWEEN KVon AND KBis)';

					if ($row->KeineKosten == 1)
					{
						$row->cost = '0.00';
					}
					else if ($row->Pauschalkosten>0)
					{
						$row->cost = $row->Pauschalkosten;
						$row->is_pauschal = 1;
					}
					else
					{
						$sql_cost = $AVE_DB->Query("
							SELECT *
							FROM " . PREFIX . "_modul_shop_versandkosten
							WHERE VersandId = '" . $row->Id . "'
							" . $dbex . "
							AND Land = '" . $land . "'
							LIMIT 1
						");
						$row_cost = $sql_cost->FetchRow();
						$row->cost = (is_object($row_cost)) ? $row_cost->Betrag : '';
					}

					@$row->Groups = @explode(',', $row->ErlaubteGruppen);
					if ($row->cost && in_array($_SESSION['user_group'], $row->Groups)) array_push($shipper, $row);
					if ($row->cost) $si_count++;
				}
			}
		}
		$sql->Close();
		$AVE_Template->assign('si_count', $si_count);

		return $shipper;
	}

	//=======================================================
	// Zahlungsmethoden
	//=======================================================
	function _showPaymentMethod($id)
	{
		global $AVE_DB;

		$Name = $AVE_DB->Query("
			SELECT Name
			FROM " . PREFIX . "_modul_shop_zahlungsmethoden
			WHERE Aktiv = 1
			AND Id = '" . $id . "'
		")
		->GetCell();

		return $Name;
	}

	function _showPaymentMethods()
	{
		global $AVE_DB;

		// unset($_SESSION['PaymentId']);
		$PaymentMethods = array();
		if (isset($_SESSION['ShipperId']) && isset($_POST['Land']) )
		{
			$sql = $AVE_DB->Query("
				SELECT *
				FROM " . PREFIX . "_modul_shop_zahlungsmethoden
				WHERE Aktiv = 1
				ORDER BY Position ASC
			");
			while ($row = $sql->FetchRow())
			{
				$Laender = explode(',', $row->ErlaubteVersandLaender);
				$Gruppen = explode(',', $row->ErlaubteGruppen);
				$Versand = explode(',', $row->ErlaubteVersandarten);
				$row->Kosten = $row->Kosten;

				// Nur Zahlungsarten fьr erlaubte Benutzergruppe ausgeben
				if (in_array($_SESSION['ShipperId'], $Versand) && in_array($_POST['Land'],$Laender) && in_array($_SESSION['user_group'], $Gruppen)) array_push($PaymentMethods, $row);
			}
		}

		return $PaymentMethods;
	}

	function _getPaymentText($id)
	{
		global $AVE_DB;

		$Beschreibung = $AVE_DB->Query("
			SELECT Beschreibung
			FROM " . PREFIX . "_modul_shop_zahlungsmethoden
			WHERE Id = '" . $id . "'
		")
		->GetCell();

		return $Beschreibung;
	}

	function _getDiscount()
	{
		global $AVE_DB;

		if (!defined('UGROUP')) return '';

		$Wert = $AVE_DB->Query("
			SELECT Wert
			FROM " . PREFIX . "_modul_shop_rabatte
			WHERE Gruppe = '" . UGROUP . "'
		")
		->GetCell();

		return $Wert;
	}

	//=======================================================
	// Prьfung
	//=======================================================
	function checkOut()
	{
		global $AVE_DB, $AVE_Template;

		if (!isset($_SESSION['Product']) || count($_SESSION['Product']) < 1)
		{
			header('Location:index.php?module=shop&action=showbasket');
			exit;
		}

		$checkoutinfo = false;
		$orderok = false;

		// Formular auf fehlende Angaben ьberprьfen
		if (isset($_REQUEST['send']) && $_REQUEST['send'] == 1)
		{
			$errors = array();
			if (empty($_POST['billing_firstname'])) array_push($errors, $GLOBALS['mod']['config_vars']['Errors_NoFirstName']);
			if (empty($_POST['billing_lastname'])) array_push($errors, $GLOBALS['mod']['config_vars']['Errors_NoLastName']);
			if (empty($_POST['billing_street'])) array_push($errors, $GLOBALS['mod']['config_vars']['Errors_NoStreet']);
			if (empty($_POST['billing_streetnumber'])) array_push($errors, $GLOBALS['mod']['config_vars']['Errors_NoStreetNr']);
			if (empty($_POST['billing_zip']) || (!preg_match('/^[0-9]{5}$/', $_POST['billing_zip']) && $_POST['Land'] == 'DE') ) array_push($errors, $GLOBALS['mod']['config_vars']['Errors_NoZip']);
			if (empty($_POST['billing_town'])) array_push($errors, $GLOBALS['mod']['config_vars']['Errors_NoTown']);
			$regex_email = '/^[\w.-]+@[a-z0-9.-]+\.(?:[a-z]{2}|com|org|net|edu|gov|mil|biz|info|mobi|name|aero|asia|jobs|museum)$/i';
			if (empty($_POST['OrderEmail']) || !@preg_match($regex_email, chop($_POST['OrderEmail']))) array_push($errors, $GLOBALS['mod']['config_vars']['Errors_NoEmail']);
//			if (empty($_POST['OrderPhone'])) array_push($errors, $GLOBALS['mod']['config_vars']['Errors_NoOrderPhone']);

			// Formularwerte in Session schreiben
			if (isset($_POST['OrderEmail'])) $_SESSION['OrderEmail'] = chop($_POST['OrderEmail']);
			if (isset($_POST['OrderPhone'])) $_SESSION['OrderPhone'] = $_POST['OrderPhone'];
			if (isset($_POST['billing_company'])) $_SESSION['billing_company'] = $_POST['billing_company'];
			if (isset($_POST['billing_company_reciever'])) $_SESSION['billing_company_reciever'] = $_POST['billing_company_reciever'];
			if (isset($_POST['billing_firstname'])) $_SESSION['billing_firstname'] = $_POST['billing_firstname'];
			if (isset($_POST['billing_lastname'])) $_SESSION['billing_lastname'] = $_POST['billing_lastname'];
			if (isset($_POST['billing_street'])) $_SESSION['billing_street'] = $_POST['billing_street'];
			if (isset($_POST['billing_streetnumber'])) $_SESSION['billing_streetnumber'] = $_POST['billing_streetnumber'];
			if (isset($_POST['billing_zip'])) $_SESSION['billing_zip'] = $_POST['billing_zip'];
			if (isset($_POST['billing_town'])) $_SESSION['billing_town'] = $_POST['billing_town'];
			if (isset($_POST['Land'])) $_SESSION['billing_country'] = $_POST['Land'];

			// Formularwerte (Rechnungsadresse)
			if (isset($_POST['shipping_company'])) $_SESSION['shipping_company'] = $_POST['shipping_company'];
			if (isset($_POST['shipping_company_reciever'])) $_SESSION['shipping_company_reciever'] = $_POST['shipping_company_reciever'];
			if (isset($_POST['shipping_firstname'])) $_SESSION['shipping_firstname'] = $_POST['shipping_firstname'];
			if (isset($_POST['shipping_lastname'])) $_SESSION['shipping_lastname'] = $_POST['shipping_lastname'];
			if (isset($_POST['shipping_street'])) $_SESSION['shipping_street'] = $_POST['shipping_street'];
			if (isset($_POST['shipping_streetnumber'])) $_SESSION['shipping_streetnumber'] = $_POST['shipping_streetnumber'];
			if (isset($_POST['shipping_zip'])) $_SESSION['shipping_zip'] = $_POST['shipping_zip'];
			if (isset($_POST['shipping_city'])) $_SESSION['shipping_city'] = $_POST['shipping_city'];

			// Es sind Fehler vorhanden. Benutzer wird zurьck geleitet!
			if (count($errors) > 0)
			{
				$errors = str_replace('+','_',urlencode(base64_encode(serialize($errors))));
				header('Location:index.php?module=shop&action=checkout&create_account=' . $_REQUEST['create_account'] . '&errors=' . $errors);
				exit;
			}
		}

		// Wenn kein Artikel im Warenkorb liegt, zum Shop weiterleiten
		if (!isset($_SESSION['Product']))
		{
			header('Location:index.php?module=shop');
			exit;
		}

		// Alles ausgefьllt...
		if (isset($_REQUEST['zusammenfassung']) && $_REQUEST['zusammenfassung'] == 1)
		{
			if (!empty($_SESSION['ShipperId']) && !empty($_SESSION['PaymentId']))
			{
				// Bestellung zusammenfassen udn weiterleiten...
				$checkoutinfo = true;
			}
			else
			{
				header('Location:index.php?module=shop');
				exit;
			}
		}

		$this->_globalProductInfo();
		$create_account = true;

		if (!empty($_REQUEST['ShipperId'])) $_SESSION['ShipperId'] = $_REQUEST['ShipperId'];
		if (isset($_REQUEST['create_account']) && $_REQUEST['create_account'] == 'no') $create_account = false;
		if (!isset($_SESSION['user_id']) && $create_account == true)
		{
			if (isset($_POST['do']) && $_POST['do'] == 'login')
			{
				$this->_loginProcess();
			}

			$tpl_out = $AVE_Template->fetch($GLOBALS['mod']['tpl_dir'] . 'shop_checkout.tpl');
			$tpl_out = $this->_shopRewrite($tpl_out);
			define('MODULE_CONTENT', $tpl_out);
			define('MODULE_SITE', $GLOBALS['mod']['config_vars']['PageName'] . $GLOBALS['mod']['config_vars']['PageSep'] . $GLOBALS['mod']['config_vars']['ShopPaySite']);
		}
		else
		{
			//=======================================================
			// Liefer & Versandadresse
			//=======================================================
			if (!empty($_POST['Land']))
			{
				$AVE_Template->assign('showShipper', $this->_showShipper($_POST['Land']));
				$_SESSION['IsShipper'] = 1;
			}

			if (isset($_SESSION['ShipperId'])) $_POST['ShipperId'] = $_SESSION['ShipperId'];
			if (!empty($_POST['ShipperId']))
			{
				$_SESSION['ShipperId'] = $_POST['ShipperId'][0];
				$sql_su = $AVE_DB->Query("
					SELECT
						KeineKosten,
						Pauschalkosten
					FROM " . PREFIX . "_modul_shop_versandarten
					WHERE Id = '" . $_SESSION['ShipperId'] . "'
				");
				$row_su = $sql_su->FetchRow();

				$VersFrei = $this->_getShopSetting('VersFrei');
				$VersFreiBetrag = $this->_getShopSetting('VersFreiBetrag');

				//@$_SESSION['BasketSumm'] = ($VersFrei == 1 && $_SESSION['BasketSumm'] >= $VersFreiBetrag) ? '0.00' : ($row_su->KeineKosten != 1 && $row_su->Pauschalkosten > 0) ? $_SESSION['BasketSumm'] + $row_su->Pauschalkosten : $_SESSION['BasketSumm'] = $_SESSION['BasketSumm'] + $this->_shipperSumm(@$_POST['Land'],$_SESSION['ShipperId']);

				// Endsumme
				if ($VersFrei == 1 && $_SESSION['BasketSumm'] >= $VersFreiBetrag)
				{
//					@$_SESSION['BasketSumm'] = @$_SESSION['BasketSumm'];
				}
				elseif ($row_su->KeineKosten != 1 && $row_su->Pauschalkosten > 0)
				{
					// Pauschale Versandkosten
					@$_SESSION['BasketSumm'] += $row_su->Pauschalkosten;
				}
				else
				{
					@$_SESSION['BasketSumm'] += $this->_shipperSumm(@$_POST['Land'], $_SESSION['ShipperId']);
				}

				if ($VersFrei == 1 && $_SESSION['BasketSumm'] >= $VersFreiBetrag)
				{
					@$_SESSION['ShippingSumm'] = 0;
				}
				elseif ($row_su->KeineKosten != 1 && $row_su->Pauschalkosten > 0)
				{
					@$_SESSION['ShippingSumm'] = $row_su->Pauschalkosten;
				}
				else
				{
					@$_SESSION['ShippingSumm'] = $this->_shipperSumm(@$_POST['Land'], $_SESSION['ShipperId']);
				}
				@$_SESSION['ShippingSummOut'] = @$_SESSION['ShippingSumm'];
			}

			// Preisberechnung
			if (!isset($_POST['PaymentId']) && isset($_SESSION['PaymentId']))
			{
				$_POST['PaymentId'][0] = $_SESSION['PaymentId'];
			}

			if (!empty($_POST['PaymentId']))
			{
				$_SESSION['PaymentId'] = $_POST['PaymentId'][0];
				$row = $AVE_DB->Query("
					SELECT
						Kosten,
						KostenOperant
					FROM " . PREFIX . "_modul_shop_zahlungsmethoden
					WHERE Id = '" . $_SESSION['PaymentId'] . "'
				")
				->FetchRow();

				$Kosten = $_SESSION['BasketSumm'];

				$PluMin = substr($row->Kosten, 0, 1);
				switch ($PluMin)
				{
					case '-':
						$row->Kosten = str_replace('-', '', $row->Kosten);
						$Kosten = ($row->KostenOperant == '%') ? $_SESSION['BasketSumm']-$_SESSION['BasketSumm']/100*$row->Kosten : $_SESSION['BasketSumm'] - $row->Kosten;
						$KostenZahlungOp = ($row->KostenOperant == '%') ? '%': $this->_getShopSetting('WaehrungSymbol');
						$_SESSION['KostenZahlung'] = '- ' . $row->Kosten . ' ' . $KostenZahlungOp;
						$_SESSION['KostenZahlungOut'] = ($row->KostenOperant == '%') ? $row->Kosten: $row->Kosten;
						$_SESSION['KostenZahlungPM'] = '-';
						break;

					case '':
					case '+':
					default:
						$row->Kosten = str_replace('+', '', $row->Kosten);
						$Kosten = ($row->KostenOperant == '%') ? $_SESSION['BasketSumm']+$_SESSION['BasketSumm']/100*$row->Kosten: $_SESSION['BasketSumm'] + $row->Kosten;
						$KostenZahlungOp = ($row->KostenOperant == '%') ? '%': $this->_getShopSetting('WaehrungSymbol');
						$_SESSION['KostenZahlung'] = $row->Kosten . ' ' . $KostenZahlungOp;
						$_SESSION['KostenZahlungOut'] = ($row->KostenOperant == '%') ? $row->Kosten: $row->Kosten;
						$_SESSION['KostenZahlungPM'] = '+';
						break;
				}
				$_SESSION['BasketSumm'] = $Kosten;
				$_SESSION['KostenZahlungSymbol'] = $KostenZahlungOp;
			}

			if (!empty($_SESSION['user_id']))
			{
				$row = $AVE_DB->Query("
					SELECT *
					FROM " . PREFIX . "_users
					WHERE Id = '" . $_SESSION['user_id'] . "'
				")
				->FetchRow();
				$AVE_Template->assign('row', $row);
			}

			$AVE_Template->assign('shippingCountries', explode(',', $this->_getShopSetting('VersandLaender')));
			$AVE_Template->assign('Endsumme', $_SESSION['BasketSumm']);
			$AVE_Template->assign('available_countries', get_country_list(1));
			$AVE_Template->assign('PaymentMethods', $this->_showPaymentMethods());

			if (!empty($_REQUEST['errors']))
			{
				$AVE_Template->assign('errors', unserialize(base64_decode(str_replace('_', '+', $_REQUEST['errors']))));
			}

			// Zusammenfassung
			if ($checkoutinfo == true)
			{
				// Проверка принятия лицензионного соглашения
				if (isset($_REQUEST['sendorder']) && $_REQUEST['sendorder'] == 1 && isset($_REQUEST['agb_accept']) && $_REQUEST['agb_accept'] == 1)
				{
					$orderok = true;
				}
				else
				{
					$AVE_Template->assign('NoAGB', 1);
					$orderok = false;
				}

				// Отказ от использования куппона на скидку
				if (isset($_POST['couponcode_del']) && $_POST['couponcode_del'] == 1 && $this->_getShopSetting('GutscheinCodes') == 1)
				{
					unset($_SESSION['CouponCode']);
					unset($_SESSION['CouponCodeId']);
					$AVE_Template->assign('NoAGB', 0);
				}

				// Обработка введённого номера куппона на скидку
				if (!empty($_REQUEST['couponcode']) && $this->_getShopSetting('GutscheinCodes') == 1)
				{
					$use_coupon = true;
					$row_cc = $AVE_DB->Query("
						SELECT *
						FROM " . PREFIX . "_modul_shop_gutscheine
						WHERE Code = '" . chop($_POST['couponcode']) . "'
					")
					->FetchRow();

					if (is_object($row_cc) && $row_cc->Prozent != '' && $row_cc->Prozent < 100)
					{
						$Benutzer = explode(',', $row_cc->Benutzer);
						if (!empty($_SESSION['user_id']) && in_array($_SESSION['user_id'], $Benutzer)/* && $row_cc->Mehrfach != 1*/) $use_coupon = false;
						if ($_SESSION['user_group'] == 2 && $row_cc->AlleBenutzer != 1) $use_coupon = false;
						if ($row_cc->GueltigVon > time()) $use_coupon = false;
						if ($row_cc->GueltigBis < time()) $use_coupon = false;

						if ($use_coupon == true)
						{
							$_SESSION['CouponCode'] = $row_cc->Prozent;
							$_SESSION['CouponCodeId'] = $row_cc->Id;
							$_SESSION['BasketSumm'] = $_SESSION['BasketSumm'] - ($_SESSION['Zwisumm'] / 100 * $row_cc->Prozent);
						}
					}
					$AVE_Template->assign('NoAGB', 0);
				}

				$AVE_Template->assign('AGB', $this->_getShopSetting('Agb'));
				$AVE_Template->assign('step', 2);
				$AVE_Template->assign('ShipperName', $this->_fetchShipper($_SESSION['ShipperId']));
				$AVE_Template->assign('PaymentMethod', $this->_showPaymentMethod($_SESSION['PaymentId']));
				$AVE_Template->assign('PaymentOverall', $_SESSION['BasketSumm']);
				$AVE_Template->assign('PaymentOverall2', (defined('Waehrung2Multi') ? $_SESSION['BasketSumm'] * @Waehrung2Multi : ''));

				if ($orderok == true)
				{
					// Bestellung eintragen und weitere Aktionen durchfьhren
					$ProductsOrder = (!empty($_SESSION['Product'])) ? serialize($_SESSION['Product']) : '';
					$ProductsOrderVars = (!empty($_SESSION['ProductVar'])) ? serialize($_SESSION['ProductVar']) : '';
					// $transId = 'CPE_' . $this->_transId(12) . '_' . date('dmy');
					$transId = '' . $this->_transId(7) . '' . date('dmy');
					$_SESSION['TransId'] = $transId;

					//echo $_REQUEST['create_account'];

					// Besteller
					$Benutzer = (isset($_SESSION['user_id'])) ? $_SESSION['user_id'] : $_SESSION['OrderEmail'];

					// Enthaltene Umsatzssteuer
					$USt = '';

					// Rechnung (Text - Format)
					$RechnungText = '';

					// Rechnung (HTML - Format)
					$RechnungHtml = '';

					// Kam der Kдufer von einer bestimmten Seite?
					$KamVon = (isset($_SESSION['Referer'])) ? $_SESSION['Referer'] : '';

					// Gutscheincode - Wert
//					$Gutscheincode = '';

					$AVE_DB->Query("
						INSERT INTO " . PREFIX . "_modul_shop_bestellungen
						SET
							Benutzer          = '" . $Benutzer . "',
							TransId           = '" . $transId . "',
							Datum             = '" . time() . "',
							Gesamt            = '" . str_replace(',', '.', $_SESSION['BasketSumm']) . "',
							USt               = '" . $USt . "',
							Artikel           = '" . $ProductsOrder . "',
							Artikel_Vars      = '" . $ProductsOrderVars . "',
							RechnungText      = '" . $RechnungText . "',
							RechnungHtml      = '" . $RechnungHtml . "',
							NachrichtBenutzer = '" . nl2br($_POST['Msg']) . "',
							Ip                = '" . $_SERVER['REMOTE_ADDR'] . "',
							ZahlungsId        = '" . $_SESSION['PaymentId'] . "',
							VersandId         = '" . $_SESSION['ShipperId'] . "',
							KamVon            = '" . $KamVon . "',
							Gutscheincode     = '" . (isset($_SESSION['CouponCodeId']) ? $_SESSION['CouponCodeId'] : '') . "',
							Bestell_Email     = '" . $_SESSION['OrderEmail'] . "',
							Liefer_Firma      = '" . (isset($_SESSION['billing_company']) ? $_SESSION['billing_company'] : '') . "',
							Liefer_Abteilung  = '" . (isset($_SESSION['billing_company_reciever']) ? $_SESSION['billing_company_reciever'] : '') . "',
							Liefer_Vorname    = '" . $_SESSION['billing_firstname'] . "',
							Liefer_Nachname   = '" . $_SESSION['billing_lastname'] . "',
							Liefer_Strasse    = '" . $_SESSION['billing_street'] . "',
							Liefer_Hnr        = '" . $_SESSION['billing_streetnumber'] . "',
							Liefer_PLZ        = '" . $_SESSION['billing_zip'] . "',
							Liefer_Ort        = '" . $_SESSION['billing_town'] . "',
							Liefer_Land       = '" . (!empty($_POST['Land']) ? $_POST['Land'] : '') . "',
							Rech_Firma        = '" . (!empty($_SESSION['shipping_company']) ? $_SESSION['shipping_company'] : (!empty($_SESSION['billing_company']) ? $_SESSION['billing_company'] : '') ) . "',
							Rech_Abteilung    = '" . (!empty($_SESSION['shipping_company_reciever']) ? $_SESSION['shipping_company_reciever'] : (!empty($_SESSION['billing_company_reciever']) ? $_SESSION['billing_company_reciever'] : '')) . "',
							Rech_Vorname      = '" . (!empty($_SESSION['shipping_firstname']) ? $_SESSION['shipping_firstname'] : $_SESSION['billing_firstname']) . "',
							Rech_Nachname     = '" . (!empty($_SESSION['shipping_lastname']) ? $_SESSION['shipping_lastname'] : $_SESSION['billing_lastname']) . "',
							Rech_Strasse      = '" . (!empty($_SESSION['shipping_street']) ? $_SESSION['shipping_street'] : $_SESSION['billing_street']) . "',
							Rech_Hnr          = '" . (!empty($_SESSION['shipping_streetnumber']) ? $_SESSION['shipping_streetnumber'] : $_SESSION['billing_streetnumber']) . "',
							Rech_PLZ          = '" . (!empty($_SESSION['shipping_zip']) ? $_SESSION['shipping_zip'] : $_SESSION['billing_zip']) . "',
							Rech_Ort          = '" . (!empty($_SESSION['shipping_city']) ? $_SESSION['shipping_city'] :$_SESSION['billing_town']) . "',
							Rech_Land         = '" . (!empty($_POST['RLand']) ? $_POST['RLand'] : '') . "'
					");
					$OrderId = $AVE_DB->insertid();

					// TransId in Gutscheine eintragen
					if (!empty($_SESSION['CouponCode']))
					{
						$row_cc = $AVE_DB->Query("
							SELECT *
							FROM " . PREFIX . "_modul_shop_gutscheine
							WHERE Id = '" . $_SESSION['CouponCodeId'] . "'
						")
						->FetchRow();

						$AVE_DB->Query("
							UPDATE " . PREFIX . "_modul_shop_gutscheine
							SET BestellId = CONCAT(BestellId, ',', '" . $OrderId . "')
							WHERE Id = '" . $_SESSION['CouponCodeId'] . "'
						");
						if (!empty($_SESSION['user_id']))
						{
							$AVE_DB->Query("
								UPDATE " . PREFIX . "_modul_shop_gutscheine
								SET Benutzer = CONCAT(Benutzer, ',', '" . $_SESSION['user_id']. "')
								WHERE Id = '" . $_SESSION['CouponCodeId'] . "'
							");
						}

						if ($row_cc->Mehrfach != 1)
						{
							$AVE_DB->Query("
								UPDATE " . PREFIX . "_modul_shop_gutscheine
								SET Eingeloest = 1
								WHERE Id = '" . $_SESSION['CouponCodeId'] . "'
							");
						}
					}

					// Anzahl der Kдufe im Artikel erhцhen
					$arr = $_SESSION['Product'];
					foreach ($arr as $key => $value)
					{
						$AVE_DB->Query("
							UPDATE " . PREFIX . "_modul_shop_artikel
							SET Bestellungen = Bestellungen+" . $value . "
							WHERE Id = '" . $key . "'
						");
					}

					$AVE_Template->assign('PaymentText', ($this->_getShopSetting('EmailFormat') == 'html' ? $this->_getPaymentText($_SESSION['PaymentId']) : strip_tags($this->_getPaymentText($_SESSION['PaymentId']))));
					$AVE_Template->assign('TransCode', $transId);
					$AVE_Template->assign('CompanyHeadText', $this->_getShopSetting('AdresseText'));
					$AVE_Template->assign('CompanyHeadHtml', $this->_getShopSetting('AdresseHTML'));
					$AVE_Template->assign('CompanyLogo', $this->_getShopSetting('Logo'));
					$AVE_Template->assign('OrderId', $OrderId);
					$AVE_Template->assign('OrderTime', time());
					$AVE_Template->assign('VatZones', $this->_showVatZones());

					// HTML- & Text E-Mail Template laden
					$mail_html = $AVE_Template->fetch($GLOBALS['mod']['tpl_dir'] . 'shop_orderconfirm_html.tpl');
					$mail_text = $AVE_Template->fetch($GLOBALS['mod']['tpl_dir'] . 'shop_orderconfirm_text.tpl');
					$mail_text = $this->_textReplace($mail_text);

					// E-Mail mit Bestellbestдtigung an Kдufer senden

					// Soll E-Mail als Text oder HTML versendet werden?
					if ($this->_getShopSetting('EmailFormat') == 'html')
					{
						send_mail(
							$this->_getShopSetting('EmpEmail'),
							$mail_html,
							$this->_getShopSetting('BetreffBest'),
							$this->_getShopSetting('AbsEmail'),
							$this->_getShopSetting('AbsName'),
							'html',
							'',
							1
						);
						send_mail(
							$_SESSION['OrderEmail'],
							$mail_html,
							$this->_getShopSetting('BetreffBest'),
							$this->_getShopSetting('AbsEmail'),
							$this->_getShopSetting('AbsName'),
							'html',
							'',
							1
						);
						$AVE_Template->assign('innerhtml', htmlspecialchars($mail_html));
					}
					else
					{
						send_mail(
							$this->_getShopSetting('EmpEmail'),
							$mail_text,
							$this->_getShopSetting('BetreffBest'),
							$this->_getShopSetting('AbsEmail'),
							$this->_getShopSetting('AbsName'),
							'text',
							'',
							''
						);
						send_mail(
							$_SESSION['OrderEmail'],
							$mail_text,
							$this->_getShopSetting('BetreffBest'),
							$this->_getShopSetting('AbsEmail'),
							$this->_getShopSetting('AbsName'),
							'text',
							'',
							''
						);
						$AVE_Template->assign('innerhtml',htmlspecialchars($mail_html));
					}
					// E-Mail mit Bestellbestдtigung an Admin senden

					// Rechnung als HTML & Text in Bestellung aktualisieren
					$AVE_DB->Query("
						UPDATE " . PREFIX . "_modul_shop_bestellungen
						SET
							RechnungHtml = '" . addslashes($mail_html) . "',
							RechnungText = '" . addslashes($mail_text) . "'
						WHERE
							Id = '" . $OrderId . "'
					");

					// Gibt es ein Zahlunsg - Gateway?
					$extern = false;
					$row_gw = $AVE_DB->Query("
						SELECT *
						FROM " . PREFIX . "_modul_shop_zahlungsmethoden
						WHERE Aktiv = 1
						AND Id = '" . $_SESSION['PaymentId'] . "'
					")
					->FetchRow();

					if (is_object($row_gw) && $row_gw->Extern == 1 && file_exists(BASE_DIR . '/modules/shop/gateways/' . $row_gw->Gateway . '.php'))
					{
//						$Waehrung = $this->_getShopSetting('Waehrung');
						define('GATEWAY', BASE_DIR . '/modules/shop/gateways/' . $row_gw->Gateway . '.php');
						if (@include(GATEWAY))
						{
							$extern = true;
						}
					}

					if ($extern == true)
					{
						exit;
					}

					// Wenn es keinen Zahlungs - Gateway gibt, Bestдtigungs - Seite anzeigen
					unset($_SESSION['Zwisumm']);
					unset($_SESSION['BasketSumm']);
					unset($_SESSION['BasketOverall']);
					unset($_SESSION['ShippingSummOut']);
					unset($_SESSION['ShippingSumm']);
					unset($_SESSION['ShipperId']);
					unset($_SESSION['IsShipper']);
					unset($_SESSION['Product']);
					unset($_SESSION['VatInc']);
					unset($_SESSION['GewichtSumm']);
					unset($_SESSION['PaymentId']);
					unset($_SESSION['CouponCode']);
					unset($_SESSION['CouponCodeId']);
					unset($_SESSION['KostenZahlung']);
					unset($_SESSION['KostenZahlungOut']);

					$AVE_Template->assign('step', 3);
					$tpl_out = $AVE_Template->fetch($GLOBALS['mod']['tpl_dir'] . 'shop_confirm_thankyou.tpl');
					$tpl_out = $this->_shopRewrite($tpl_out);
					define('MODULE_CONTENT', $tpl_out);
					define('MODULE_SITE', $GLOBALS['mod']['config_vars']['PageName'] . $GLOBALS['mod']['config_vars']['PageSep'] . $GLOBALS['mod']['config_vars']['ShopPaySite']);
				}
				// Zusammenfassung anzeigen
				else
				{
					if (empty($_SESSION['ShipperId']))
					{
						header('Location:index.php?module=shop&action=checkout&create_account=no');
						exit;
					}

					if ($this->_getShopSetting('GutscheinCodes') == 1) $AVE_Template->assign('couponcodes', 1);
					$AVE_Template->assign('VatZones', $this->_showVatZones());
					$tpl_out = $AVE_Template->fetch($GLOBALS['mod']['tpl_dir'] . 'shop_checkoutinfo.tpl');
					$tpl_out = $this->_shopRewrite($tpl_out);
					define('MODULE_CONTENT', $tpl_out);
					define('MODULE_SITE', $GLOBALS['mod']['config_vars']['PageName'] . $GLOBALS['mod']['config_vars']['PageSep'] . $GLOBALS['mod']['config_vars']['ShopPaySite']);
				}
			}
			else
			{
				if (!isset($_SESSION['user_id']) && GastBestellung != 1)
				{
					header('Location:index.php?module=shop&action=checkout');
					exit;
				}

				$AVE_Template->assign('step', 1);
				$tpl_out = $AVE_Template->fetch($GLOBALS['mod']['tpl_dir'] . 'shop_billing.tpl');
				$tpl_out = $this->_shopRewrite($tpl_out);
				define('MODULE_CONTENT', $tpl_out);
				define('MODULE_SITE', $GLOBALS['mod']['config_vars']['PageName'] . $GLOBALS['mod']['config_vars']['PageSep'] . $GLOBALS['mod']['config_vars']['ShopPaySite']);
			}
		}
	}
}

?>