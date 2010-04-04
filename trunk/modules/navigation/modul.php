<?php

/**
 * AVE.cms - Модуль Навигация
 *
 * @package AVE.cms
 * @subpackage module_Navigation
 * @filesource
 */

if (!defined('BASE_DIR')) exit;

if (defined('ACP'))
{
	$modul['ModulName'] = 'Навигация';
	$modul['ModulPfad'] = 'navigation';
	$modul['ModulVersion'] = '1.1';
	$modul['Beschreibung'] = 'Данный модуль предназначен не только для создания различных видов меню (горизонтального или вертикального), но и меню навигаций, состоящих из различного количества пунктов и уровней вложенности. Помните, что максимальная глубина уровней вложенности не может быть больше 3. Для создания меню, перейдите в раздел <strong>Навигация</strong>. Для отображения меню на сайте разместите системный тег <strong>[mod_navigation:XXX]</strong> в нужном месте вашего шаблона. ХХХ - это порядковый номер меню.';
	$modul['Autor'] = 'Arcanum';
	$modul['MCopyright'] = '&copy; 2007 Overdoze Team';
	$modul['Status'] = 1;
	$modul['IstFunktion'] = 1;
    $modul['AdminEdit'] = 0;
	$modul['ModulFunktion'] = 'mod_navigation';
	$modul['CpEngineTagTpl'] = '[mod_navigation:XXX]';
	$modul['CpEngineTag'] = '#\\\[mod_navigation:(\\\d+)]#';
	$modul['CpPHPTag'] = "<?php mod_navigation(''$1''); ?>";
}

if (defined('ACP') && !(isset($_REQUEST['action']) && $_REQUEST['action'] == 'delete'))
{
	$modul_sql_update = array();
	$modul_sql_update[] = "ALTER TABLE CPPREFIX_navigation ADD Expand TINYINT(1) UNSIGNED DEFAULT '0' NOT NULL;";
	$modul_sql_update[] = "UPDATE CPPREFIX_module SET Version = '" . $modul['ModulVersion'] . "' WHERE ModulName = '" . $modul['ModulName'] . "';";
}

/**
 * Функция обработки тэга модуля
 *
 * @param int $id - идентификатор меню навигации
 */
function mod_navigation($id)
{
	global $AVE_DB, $AVE_Core, $navigations;

    static $navi = array();

	$id  = preg_replace('/(\D+)/', '', $id);
	if (isset($navi[$id]))
	{
		echo $navi[$id];
		return;
	}

	if (is_null($navigations))
	{
		$navigations = array();

		$sql = $AVE_DB->Query("SELECT * FROM " . PREFIX . "_navigation");

		while ($row = $sql->FetchRow())
		{
			$row->Gruppen = explode(',', $row->Gruppen);
			$navigations[$row->id] = $row;
		}
		$sql->Close();
	}

	if (isset($navigations[$id]))
	{
		$row = $navigations[$id];
	}
	else
	{
		echo 'Menu ', $id, ' not found';
		return;
	}

	if (!defined('UGROUP')) define('UGROUP', 2);
	if (!in_array(UGROUP, $row->Gruppen)) return;

	if (empty($_REQUEST['module']))
	{
		$curent_doc_id = (isset($_GET['id']) && is_numeric($_GET['id'])) ? $_GET['id'] : 1;

		$row_navi = $AVE_DB->Query("
			SELECT CONCAT_WS(',', nav.Id, nav.Elter, nav2.Elter)
			FROM
				" . PREFIX . "_navigation_items AS nav
			JOIN
				" . PREFIX . "_documents AS doc
			LEFT JOIN
				" . PREFIX . "_navigation_items AS nav2 ON nav2.Id = nav.Elter
			WHERE nav.Aktiv = 1
			AND nav.Rubrik = '" . $id . "'
			AND doc.Id = '" . $curent_doc_id . "'
			AND (nav.Link = 'index.php?id=" . $curent_doc_id . "'"
				. ((!empty($AVE_Core->curentdoc->Url) && $AVE_Core->curentdoc->Id == $curent_doc_id) ? " OR nav.Url = '" . $AVE_Core->curentdoc->Url . "'" : '')
				. " OR nav.Id = doc.ElterNavi)
		")->GetCell();
	}
	else
	{
		$row_navi = $AVE_DB->Query("
			SELECT CONCAT_WS(',', nav.Id, nav.Elter, nav2.Elter)
			FROM
				" . PREFIX . "_navigation_items AS nav
			LEFT JOIN
				" . PREFIX . "_navigation_items AS nav2 ON nav2.Id = nav.Elter
			WHERE nav.Aktiv = 1
			AND nav.Rubrik = '" . $id . "'
			AND nav.Link LIKE 'index.php?module=" . $_REQUEST['module'] . "%%'
		")->GetCell();
	}

	$where_elter = '';
	if ($row_navi !== false)
	{
		$way = explode(',', $row_navi);
		if ($row->Expand!=1) $where_elter = "AND Elter IN(0," . $row_navi . ")";
	}
	else
	{
		$way = array('');
		if ($row->Expand!=1) $where_elter = "AND Elter = 0";
	}

	$nav_items = array();
	$sql = $AVE_DB->Query("
		SELECT *
		FROM " . PREFIX . "_navigation_items
		WHERE Aktiv = 1
		AND Rubrik = '" . $id . "'
		" . $where_elter . "
		ORDER BY Rang ASC
	");
	while ($row_nav_item = $sql->FetchAssocArray())
	{
		$nav_items[$row_nav_item['Elter']][] = $row_nav_item;
	}

	$ebenen = array(
		1 =>  array(
			'aktiv' => str_replace('[cp:mediapath]', 'templates/' . THEME_FOLDER . '/', $row->ebene1a),
			'inaktiv' => str_replace('[cp:mediapath]', 'templates/' . THEME_FOLDER . '/', $row->ebene1),
		),
		2 =>  array(
			'aktiv' => str_replace('[cp:mediapath]', 'templates/' . THEME_FOLDER . '/', $row->ebene2a),
			'inaktiv' => str_replace('[cp:mediapath]', 'templates/' . THEME_FOLDER . '/', $row->ebene2),
		),
		3 =>  array(
			'aktiv' => str_replace('[cp:mediapath]', 'templates/' . THEME_FOLDER . '/', $row->ebene3a),
			'inaktiv' => str_replace('[cp:mediapath]', 'templates/' . THEME_FOLDER . '/', $row->ebene3),
		)
	);

	ob_start();

	echo str_replace('[cp:mediapath]', 'templates/' . THEME_FOLDER . '/', $row->vor);

	printNavi($ebenen, $way, $id, $nav_items, $row);

	echo str_replace('[cp:mediapath]', 'templates/' . THEME_FOLDER . '/', $row->nach);

	$END = ob_get_contents();
	ob_end_clean();

	$END = preg_replace("/(^[\r\n]*|[\r\n]+)[\s\t]*[\r\n]+/", "\n", $END);
//	$END = str_replace(array("\r\n","\n","\r"),'',$END);
	$END = str_replace(array("\n","\r"),'',$END);

	$search = array (
		$row->ebene1_v . $row->ebene1_n,
		$row->ebene2_v . $row->ebene2_n,
		$row->ebene3_v . $row->ebene3_n,
		'</li>' . $row->ebene2_v . '<li',
		'</li>' . $row->ebene3_v . '<li',
		'</li>' . $row->ebene1_n . '<li',
		'</li>' . $row->ebene2_n . '<li',
		'</li>' . $row->ebene1_n . $row->ebene2_n . '<li',
		'</li>' . $row->ebene1_n . $row->ebene2_n . $row->ebene3_n,
		'</li>' . $row->ebene1_n . $row->ebene2_n,
		'</li>' . $row->ebene2_n . $row->ebene3_n
	);

	$replace = array (
		'',
		'',
		'',
		$row->ebene2_v . '<li',
		$row->ebene3_v . '<li',
		'</li>' . $row->ebene1_n . '</li><li',
		'</li>' . $row->ebene2_n . '</li><li',
		'</li>' . $row->ebene1_n . '</li>' . $row->ebene2_n . '</li><li',
		'</li>' . $row->ebene1_n . '</li>' . $row->ebene2_n . '</li>' . $row->ebene3_n,
		'</li>' . $row->ebene1_n . '</li>' . $row->ebene2_n,
		'</li>' . $row->ebene2_n . '</li>' . $row->ebene3_n
	);
	$END = str_replace($search, $replace, $END);

	$navi[$id] = $END;

	echo $END;
}

/**
 * Рекурсивная функция для формирования меню навигации
 *
 * @param int $ebenen
 * @param string $way
 * @param int $rub
 * @param array $nav_items
 * @param string $row_ul
 * @param int $parent
 */
function printNavi(&$ebenen, &$way, &$rub, &$nav_items, &$row_ul, $parent = 0)
{
	$ebene = $nav_items[$parent][0]['Ebene'];
	switch ($ebene)
	{
		case 1 : echo $row_ul->ebene1_v;  break;
		case 2 : echo $row_ul->ebene2_v;  break;
		case 3 : echo $row_ul->ebene3_v;  break;
	}

	foreach ($nav_items[$parent] as $row)
	{
//		$aktiv = (in_array($row['Id'], $way) || strpos($row['Link'], 'index.php?' . $_SERVER['QUERY_STRING']) !== false) ? 'aktiv' : 'inaktiv';
		$aktiv = (in_array($row['Id'], $way)) ? 'aktiv' : 'inaktiv';
		$akt = str_replace('[cp:linkname]', $row['Titel'], $ebenen[$ebene][$aktiv]);

		if (strpos($row['Link'], 'module=') === false && startsWith('index.php?', $row['Link']))
		{
			$akt = str_replace('[cp:link]', $row['Link'] . "&amp;doc=" . (empty($row['Url']) ? cpParseLinkname($row['Titel']) : $row['Url']), $akt);
		}
		else
		{
//			if (strpos($row['Link'], 'module=') === false) $row['Link'] = $row['Link'] . URL_SUFF;
			$akt = str_replace('[cp:link]', $row['Link'], $akt);
			if (startsWith('www.', $row['Link'])) $akt = str_replace('www.', 'http://www.', $akt);
		}

		$akt = (CP_REWRITE == 1)
			? cpRewrite(str_replace('[cp:target]', $row['Ziel'], $akt))
			: str_replace('[cp:target]', $row['Ziel'], $akt);

		echo $akt;

		if (isset($nav_items[$row['Id']]))
		{
			printNavi($ebenen, $way, $rub, $nav_items, $row_ul, $row['Id']);
		}
	}

	switch ($ebene)
	{
		case 1 : echo $row_ul->ebene1_n;  break;
		case 2 : echo $row_ul->ebene2_n;  break;
		case 3 : echo $row_ul->ebene3_n;  break;
	}
}

?>