<?php

if (!defined("INC_BASKET")) exit;

$items = '';
$Preis = '';
$Vars = '';
$SummVarsE = '';
$PreisV = '';
$PreisVarianten = '';
$PreisGesamt = '';
$GewichtGesamt = '';
$row_ieu = '';

if (isset($_SESSION['Product']))
{
	global $AVE_DB, $shop;

	unset($_SESSION['BasketSumm']);
	unset($_SESSION['BasketOverall']);
	unset($_SESSION['VatInc']);
	unset($_SESSION['ShowNoVatInfo']);
	unset($_SESSION['RabattWert']);
	unset($_SESSION['Rabatt']);
	unset($_SESSION['Zwisumm']);
	unset($_SESSION['BasketSummW2']);

	$this->resetVatZoneSessions();

	$arr = $_SESSION['Product'];
	$items = array();
	$SummVars = '';

	foreach ($arr as $key => $value)
	{
		//$item->EPreis = '';
		$item->Id = $key;
		$item->Val = $value;
		$SummVars = '';
		//$IncVat = '';

		// mцgliche Produkt - Varianten auslesen und Preis berechnen
		$Vars = array();
		if (!empty($_SESSION['ProductVar'][$item->Id]))
		{
			$ExVars = explode(',', $_SESSION['ProductVar'][$item->Id]);
			foreach($ExVars as $ExVar)
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
					$row_vars->Wert = @$row_vars->Wert;
					$row_vars->WertE =@$row_vars->Wert;
					array_push($Vars, $row_vars);
				}
			}
		}
		// echo $SummVars . "<br>";
		$SummVarsE = $SummVars;
		$SummVars = $SummVars*$value;

		$sql = $AVE_DB->Query("
			SELECT *
			FROM " . PREFIX . "_modul_shop_artikel
			WHERE Id = '" . $key . "'
		");
		$row = $sql->FetchRow();
		$Einzelpreis = $row->Preis;
		// Preis des Artikels
		//
		$row->Preis = (!$this->_getNewPrice($key, $value) ) ? (($value >= 2) ? $this->_getNewPrice($key, $value, 1, $this->_getDiscountVal($row->Preis)) : $row->Preis ) : $this->_getNewPrice($key, $value);

		// Wenn Benutzer registriert ist, muss hier geschaut werden, welches country der
		// Benutzer bei der Registrierung angegeben hat, damit der richtige Preis angezeigt wird
		// Wenn nach dem Ansenden des Formulars (Checkout) ein anderes Versandland angegeben wird
		// als bei der Registrierung, muss dieses country verwendet werden um die Versandkosten zu berechnen
		if (!isset($_SESSION['user_country'])) $_SESSION['user_country'] = '';
		if (isset($_POST['country']) && $_POST['country'] != $_SESSION['user_country']) $_SESSION['user_country'] = $_POST['country'];
		if (!empty($_SESSION['user_country']))
		{
			if (isset($shop->_landIstEU[$_SESSION['user_country']]) && is_object($shop->_landIstEU[$_SESSION['user_country']]))
			{
				$row_ieu = $shop->_landIstEU[$_SESSION['user_country']];
			}
			else
			{
				$sql_ieu = $AVE_DB->Query("
					SELECT country_eu
					FROM " . PREFIX . "_countries
					WHERE country_status = '1'
					AND country_code = '" . $_SESSION['user_country'] . "'
				");
				$row_ieu = $sql_ieu->FetchRow();
				$sql_ieu->Close();
				$shop->_landIstEU[$_SESSION['user_country']] = $row_ieu;
			}
		}

		// Muss der Kдufer USt. zahlen?
		// ShipperId
		$PayUSt = true;
		if (is_object($row_ieu) && $row_ieu->country_eu == 2)
		{
			// Benutzer ist angemeldet, hat Umsatzsteuerbefreiung
			if (!empty($_SESSION['user_id']) && $_SESSION['GewichtSumm'] >= '0.001')
			{
				$PayUSt = false;
			}
			// Benutzer ist angemeldet, hat keine Umsatzsteuerbefreiung
			elseif (!empty($_SESSION['user_id']) && $_SESSION['GewichtSumm'] < '0.001' && $this->_getUserInfo($_SESSION['user_id'],'taxpay') == 1)
			{
				$PayUSt = true;
				$_SESSION['ShowNoVatInfo'] = 1;
			}
			// Downloadbare Ware?
			// Benutzer ist nicht angemeldet, Versandgewicht ist gegeben!
			elseif (!isset($_SESSION['user_id']) && $_SESSION['user_id'] == '' && $_SESSION['GewichtSumm'] >= '0.001')
			{
				$PayUSt = false;
			}
			// Downloadbare Ware?
			// Benutzer ist nicht angemeldet, Versandgewicht ist nicht gegeben!
			elseif (!isset($_SESSION['user_id']) && $_SESSION['user_id'] == '' && $_SESSION['GewichtSumm'] < '0.001')
			{
				$PayUSt = true;
				$_SESSION['ShowNoVatInfo'] = 1;
			}
			else
			{
				$PayUSt = true;
			}
		}
		else
		{
			$PayUSt = true;
		}

		if ($PayUSt != true)
		{
			$row->Preis = $this->_getDiscountVal($row->Preis) - $this->_getVat($key);
		}


		// Anzahl jedes Artikels
		$item->Anzahl = $value;

		// Preis Zusammenrechnen
		$Preis+=$row->Preis;

		// Name des Artikels
		$item->ArtName = $row->ArtName;

		$item->ProdLink = $this->shopRewrite(($this->_product_detail . $row->Id .'&amp;categ=' . $row->KatId . '&amp;navop=' . getParentShopcateg($row->KatId)));
		$item->Hersteller_Name = $this->_fetchManufacturer($row->Hersteller);
		$item->DelLink = $this->_delete_item . $row->Id;

		// Einzelpreis unter Berьcksichtigung von Kundengruppe und Varianten
		$item->EPreis = (($PayUSt != true) ? (($this->_getDiscountVal($Einzelpreis)+$SummVarsE) / $this->_getVat($key)) : ($this->_getDiscountVal($Einzelpreis)+$SummVarsE));

		// Summe unter Berьcksichtung der Anzahl
		$item->EPreisSumme = (($PayUSt != true) ? (($this->_getDiscountVal($Einzelpreis*$value)+$SummVarsE) / $this->_getVat($key)) : ($this->_getDiscountVal($Einzelpreis)+$SummVarsE)*$value);

		$item->Gewicht = $row->Gewicht*$value;
		$item->ArtNr = $row->ArtNr;


		// Endpreis aller Artikel
		$PreisGesamt += $item->EPreisSumme;
		$GewichtGesamt += $item->Gewicht;

		// Preis 2.Wдhrung
		if (defined("WaehrungSymbol2") && defined("Waehrung2") && defined("Waehrung2Multi"))
		{
			@$item->PreisW2 = (($PayUSt != true) ? (($this->_getDiscountVal($Einzelpreis * Waehrung2Multi)+$SummVarsE) / $this->_getVat($key)) : ($this->_getDiscountVal($Einzelpreis)+$SummVarsE));;//($row->Preis * Waehrung2Multi);
			@$item->PreisW2Summ = (($PayUSt != true) ? (($this->_getDiscountVal($Einzelpreis * Waehrung2Multi * $value)+$SummVarsE) / $this->_getVat($key)) : ($this->_getDiscountVal($Einzelpreis)+$SummVarsE)*$value);;//($row->Preis * Waehrung2Multi*$value);
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
			@$_SESSION[$item->Vat] += ($IncVat * 1) ; // * $value
		}

		array_push($items, $item);
		$item = '';
		$row = '';
	}
	// Eventuellen Kundengruppen - Rabatt berьcksichtigen!

	$PreisVorher = '';

	$_SESSION['Zwisumm'] = ($PreisVorher != '')  ? $PreisGesamt : $PreisGesamt;
	$_SESSION['BasketSumm'] = $PreisGesamt;
	$_SESSION['BasketSummW2'] = ($PreisGesamt * @Waehrung2Multi);
	$_SESSION['BasketOverall'] = $PreisGesamt;
	$_SESSION['GewichtSumm'] = $GewichtGesamt;

	// Gutscheincode lцschen
	if (isset($_POST['couponcode_del']) && $_POST['couponcode_del'] == '1' && $this->getShopSetting('GutscheinCodes') == 1)
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

?>