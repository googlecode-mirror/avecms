<?php

/**
 * AVE.cms
 *
 * @package AVE.cms
 * @subpackage module_RSS
 * @filesource
 */

$base_dir = explode('/inc', str_replace("\\", "/", dirname(__FILE__)));
define('BASE_DIR', $base_dir[0]);

require('init.php');

// Получаем входной id канала
if (isset($_GET['id']) && is_numeric($_GET['id']) && $AVE_DB)
{
	$id = $_GET['id'];
}
else
{
	exit;
}

// Выполняем запрос к БД и выгребаем все параметры для данного канала
$rss_setting = $AVE_DB->Query("
	SELECT
		rss.*,
		RubrikName
	FROM
		" . PREFIX . "_modul_rss AS rss
	LEFT JOIN
		" . PREFIX . "_rubrics AS rub
			ON rub.Id = rss.rub_id
	WHERE
		rss.id = '" . $id . "'
")->FetchRow();

if ($rss_setting !== false)
{
	// Выполняем запрос к БД и выгребаем ID, URL  и Дату публикации для документов, которые соответсвуют нашей рубрики
	// Количество выборки ограничиваем значением установленным для канала
	$get_doc_id = $AVE_DB->Query("
		SELECT
			Id,
			Titel,
			DokStart
		FROM " . PREFIX . "_documents
		WHERE Id > 2
		AND RubrikId = '" . $rss_setting->rub_id . "'
		AND DokStatus = 1
		AND (DokStart < '" . time() . "' OR DokStart = 0)
		AND (DokEnde  > '" . time() . "' OR DokEnde  = 0)
		AND Geloescht != 1
		ORDER BY DokStart DESC, Id DESC
		LIMIT " . $rss_setting->on_page
	);

	// Формируем массивы, которые будут хранить инфу
	$rss_item  = array();
	$rss_items = array();

	// Выполянем обработку полученных из БД данных
	while ($res = $get_doc_id->FetchRow())
	{
		$get_fields = $AVE_DB->Query("
			SELECT
				RubrikFeld,
				Inhalt
			FROM " . PREFIX . "_document_fields
			WHERE DokumentId = '" . $res->Id . "'
			AND (RubrikFeld = '" . $rss_setting->title_id . "'
				OR RubrikFeld = '" . $rss_setting->descr_id . "')
	    ");
		while ($f = $get_fields->FetchRow())
		{
			if ($f->RubrikFeld == $rss_setting->title_id)
			{
				$rss_item['Title'] = $f->Inhalt;
			}

			if ($f->RubrikFeld == $rss_setting->descr_id)
			{
				if (strlen($f->Inhalt) > $rss_setting->lenght)
				{
					$rss_item['Description'] = substr($f->Inhalt, 0, $rss_setting->lenght) . '...';
				}
				else
				{
					$rss_item['Description'] = $f->Inhalt;
				}
			}
		}

		$rss_item['Url'] = ($config['mod_rewrite'])
			? cpRewrite('/index.php?id=' . $res->Id . '&amp;doc=' . cpParseLinkname($res->Titel))
			: '/index.php?id=' . $res->Id . '&amp;doc=' . cpParseLinkname($res->Titel);

		$rss_item['DataDoc'] = ($res->DokStart == 0)
			? date('r', time())
			: date('r', $res->DokStart);

		array_push($rss_items, $rss_item);
	}
}

// Ну а тут собственно шлем заголовок, что у нас документ XML и в путь... выводим данные
header("Content-Type: application/xml");
header("Cache-Control: no-cache");
header("Pragma: no-cache");
echo "<?xml version=\"1.0\" encoding=\"windows-1251\"?>\n";
echo "<rss version=\"2.0\" xmlns:dc=\"http://purl.org/dc/elements/1.1/\">\n";
echo "<channel>\n";
echo "<title>" . $rss_setting->rss_name . "</title>\n";
echo "<link>http://" . $rss_setting->site_url . "/</link>\n";
echo "<language>ru-ru</language>\n";
echo "<description>" . $rss_setting->rss_descr . "</description>\n";
echo "<category><![CDATA[" . $rss_setting->RubrikName . "]]></category>\n";
echo "<generator>AVECMS 2.0</generator>\n";
foreach ($rss_items as $rss_item) {
	echo "\n<item>\n";
	echo "	<title><![CDATA[" . $rss_item['Title'] . "]]></title>\n";
	echo "	<guid isPermaLink=\"true\">http://" . $rss_setting->site_url . $rss_item['Url'] . "</guid>\n";
	echo "	<link>http://" . $rss_setting->site_url . $rss_item['Url'] . "</link>\n";
	echo "	<description><![CDATA[" . $rss_item['Description'] . "]]></description>\n";
	echo "	<pubDate>" . $rss_item['DataDoc'] . "</pubDate>\n";
	echo "</item>\n";
}
echo "\n</channel>\n";
echo "</rss>";

?>