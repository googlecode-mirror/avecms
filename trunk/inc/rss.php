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

require('./init.php');

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
		rubric_title
	FROM
		" . PREFIX . "_modul_rss AS rss
	LEFT JOIN
		" . PREFIX . "_rubrics AS rub
			ON rub.Id = rss.rss_rubric_id
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
			document_title,
			document_published
		FROM " . PREFIX . "_documents
		WHERE Id != 1
		AND Id != '" . PAGE_NOT_FOUND_ID . "'
		AND rubric_id = '" . $rss_setting->rss_rubric_id . "'
		AND document_status = '1'
		AND document_published <= '" . time() . "'
		AND (document_expire  >= '" . time() . "' OR document_expire  = 0)
		AND document_deleted != '1'
		ORDER BY document_published DESC, Id DESC
		LIMIT " . $rss_setting->rss_item_on_page
	);

	// Формируем массивы, которые будут хранить инфу
	$rss_item  = array();
	$rss_items = array();

	// Выполянем обработку полученных из БД данных
	while ($res = $get_doc_id->FetchRow())
	{
		$get_fields = $AVE_DB->Query("
			SELECT
				rubric_field_id,
				field_value
			FROM " . PREFIX . "_document_fields
			WHERE document_id = '" . $res->Id . "'
			AND (rubric_field_id = '" . $rss_setting->rss_title_id . "'
				OR rubric_field_id = '" . $rss_setting->rss_description_id . "')
	    ");
		while ($f = $get_fields->FetchRow())
		{
			if ($f->rubric_field_id == $rss_setting->rss_title_id)
			{
				$rss_item['Title'] = $f->field_value;
			}

			if ($f->rubric_field_id == $rss_setting->rss_description_id)
			{
				if (strlen($f->field_value) > $rss_setting->rss_description_lenght)
				{
					$rss_item['Description'] = substr($f->field_value, 0, $rss_setting->rss_description_lenght) . '...';
				}
				else
				{
					$rss_item['Description'] = $f->field_value;
				}
			}
		}

		$rss_item['document_alias'] = rewrite_link('index.php?id=' . $res->Id . '&amp;doc=' . prepare_url($res->document_title));

		$rss_item['DataDoc'] = ($res->document_published == 0)
			? date('r', time())
			: date('r', $res->document_published);

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
echo "<title>" . htmlspecialchars($rss_setting->rss_site_name, ENT_QUOTES) . "</title>\n";
echo "<link>" . $rss_setting->rss_site_url . "</link>\n";
echo "<language>ru-ru</language>\n";
echo "<description>" . htmlspecialchars($rss_setting->rss_site_description, ENT_QUOTES) . "</description>\n";
echo "<category><![CDATA[" . $rss_setting->rubric_title . "]]></category>\n";
echo "<generator>AVECMS 2.0</generator>\n";
foreach ($rss_items as $rss_item) {
	echo "\n<item>\n";
	echo "	<title><![CDATA[" . $rss_item['Title'] . "]]></title>\n";
	echo "	<guid isPermaLink=\"true\">" . $rss_setting->rss_site_url . ltrim($rss_item['document_alias'], '/') . "</guid>\n";
	echo "	<link>" . $rss_setting->rss_site_url . ltrim($rss_item['document_alias'], '/') . "</link>\n";
	echo "	<description><![CDATA[" . $rss_item['Description'] . "]]></description>\n";
	echo "	<pubDate>" . $rss_item['DataDoc'] . "</pubDate>\n";
	echo "</item>\n";
}
echo "\n</channel>\n";
echo "</rss>";

?>