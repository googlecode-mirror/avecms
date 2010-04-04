<?php

/**
 * AVE.cms
 *
 * @package AVE.cms
 * @filesource
 */

/**
 * @todo
 * <pre>
 * добавить в настройки выбор срока доставки означающий "самовывоз" для delivery
 * добавить в настройки выбор доставки для определения стоимости локальной доставки - local_delivery_cost
 * добавить в карточку товара поле страны происхождения - country_of_origin
 * добавить в карточку товара и категории стоимость переходов - bid, cbid,
 * валюты перенести в настройки
 * </pre>
 */

global $config;

require('config.php');
require('db.config.php');

if (!mysql_select_db($config['dbname'], @mysql_connect($config['dbhost'], $config['dbuser'], $config['dbpass']))) die;

@mysql_query("SET NAMES 'cp1251'");

// общая информация о магазине и валюты
$sql = mysql_query("
	SELECT
		Aktiv,
		Waehrung,
		site_name,
		company_name,
		custom,
		delivery,
		delivery_local,
		downloadable,
		track_label
	FROM
		" . $config['dbpref'] . "_settings,
		" . $config['dbpref'] . "_modul_shop
");
list($shop_active, $shop_currency_id, $shop_name, $shop_company, $custom, $delivery, $delivery_local, $downloadable, $track_label) = mysql_fetch_row($sql);

if ($shop_active != 1) exit;

$shop_url = ((isset($_SERVER['HTTPS']) && strtolower($_SERVER['HTTPS']) == 'on') || $_SERVER['SERVER_PORT'] == 443) ? 'https://' : 'http://';
$shop_url .= $_SERVER['HTTP_HOST'];
if ($_SERVER['SERVER_PORT'] != 80)
{
	$shop_url = str_replace(':' . $_SERVER['SERVER_PORT'], '', $shop_url);
}
if ($_SERVER['SERVER_PORT'] != 80 || (isset($_SERVER['HTTPS']) && strtolower($_SERVER['HTTPS']) == 'on') || $_SERVER['SERVER_PORT'] == 443)
{
	$shop_url .= ':' . $_SERVER['SERVER_PORT'];
}

require('../modules/shop/funcs/func.rewrite.php');
require('../class/class.yml.php');

$AVE_YML = new AVE_YML();

// информация о магазине
$AVE_YML->set_shop($shop_name, $shop_company, $shop_url . ($config['mod_rewrite'] ? '/shop.html' : '/index.php?module=shop'));

// вылюты
$AVE_YML->add_currency($shop_currency_id, 1);
$AVE_YML->add_currency('USD', 'CBRF', 3);
$AVE_YML->add_currency('UAH', 'NBU', 1);

// категории
$sql = mysql_query("
	SELECT
		Id,
		Elter,
		KatName
	FROM " . $config['dbpref'] . "_modul_shop_kategorie
");

while (list($cat_id, $cat_parent_id, $cat_name) = mysql_fetch_row($sql))
{
	if ($cat_parent_id)
	{
		$AVE_YML->add_category($cat_name, $cat_id, $cat_parent_id);
	}
	else
	{
		$AVE_YML->add_category($cat_name, $cat_id);
	}
}

// товарные предложения
//if ($downloadable) ? "IF(VersandZeitId == " . $downloadable . ", 'true', 'false') AS downloadable," : "";
$sql = mysql_query("
	SELECT
		art.Id AS url,
		Preis AS price,
		'" . $shop_currency_id . "' AS currencyId,
		KatId AS categoryId,
		art.Bild AS picture,
		'true' AS delivery,
		ArtName AS name,
		vend.Name AS vendor,
		ArtNr AS vendorCode,
		TextLang AS description,
		" . ($custom ? "IF(VersandZeitId = " . $custom . ", 0, 1)" : 1) . " AS available,
		" . ($downloadable ? "IF(VersandZeitId = " . $downloadable . ", 'true', 'false') AS downloadable," : '') . "
		Elter
	FROM
		" . $config['dbpref'] . "_modul_shop_artikel AS art
	LEFT JOIN
		" . $config['dbpref'] . "_modul_shop_hersteller AS vend
			ON vend.Id = Hersteller
	LEFT JOIN
		" . $config['dbpref'] . "_modul_shop_kategorie AS cat
			ON cat.Id = KatId
	WHERE
		Aktiv = 1
	AND
		(Lager > 0" . ($custom ? " OR VersandZeitId = " . $custom : '') . ")
	AND
		Erschienen <= " . time() . "
	AND
		Preis != '0.00'
");

while ($row = mysql_fetch_assoc($sql))
{
	$offer_id = $row['url'];
	if ($config['mod_rewrite'])
	{
		$row['url'] = $shop_url . '/'
			. shopRewrite("index.php?module=shop&amp;action=product_detail&amp;product_id=" . $offer_id
			. "&amp;categ=" . $row['categoryId']
			. "&amp;navop=" . (($row['Elter'] == 0) ? $row['categoryId'] : $row['Elter']))
			. ($track_label ? "#ym" : "");
	}
	else
	{
		$row['url'] = $shop_url . '/'
			. "index.php?module=shop&amp;action=product_detail&amp;product_id=" . $offer_id
			. "&amp;categ=" . $row['categoryId']
			. "&amp;navop=" . (($row['Elter'] == 0) ? $row['categoryId'] : $row['Elter'])
			. ($track_label ? "&amp;tl=ym" : "");
	}

	if (empty($row['picture']))
	{
		unset($row['picture']);
	}
	else
	{
		$row['picture'] = $shop_url . '/modules/shop/uploads/' . $row['picture'];
	}

	$offer_available = $row['available'];

	unset($row['available'], $row['Elter']);

	$AVE_YML->add_offer($offer_id, $row, $offer_available);
}

mysql_free_result($sql);

header('Content-type: text/xml');

print_r($AVE_YML->get_xml());

?>