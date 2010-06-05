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
	$modul['ModulVersion'] = '1.2';
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
	$modul_sql_update[] = "UPDATE CPPREFIX_module SET CpEngineTag = '" . $modul['CpEngineTag'] . "', CpPHPTag = '" . $modul['CpPHPTag'] . "', Version = '" . $modul['ModulVersion'] . "' WHERE ModulPfad = '" . $modul['ModulPfad'] . "' LIMIT 1;";
}

/**
 * Функция обработки тэга модуля
 *
 * @param int $navigation_id - идентификатор меню навигации
 */
function mod_navigation($navigation_id)
{
	global $AVE_DB, $AVE_Core;

    static $navigations = array();

	$navigation_id  = preg_replace('/\D/', '', $navigation_id);

	if (isset($navigations[$navigation_id]))
	{
		echo $navigations[$navigation_id];
		return;
	}

	$nav = get_navigations($navigation_id);

	if (!$nav)
	{
		echo 'Menu ', $navigation_id, ' not found';
		return;
	}

	if (!defined('UGROUP')) define('UGROUP', 2);
	if (!in_array(UGROUP, $nav->Gruppen)) return;

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
			AND nav.Rubrik = '" . $navigation_id . "'
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
			AND nav.Rubrik = '" . $navigation_id . "'
			AND nav.Link LIKE 'index.php?module=" . $_REQUEST['module'] . "%%'
		")->GetCell();
	}

	$where_elter = '';
	if ($row_navi !== false)
	{
		$way = explode(',', $row_navi);
		if ($nav->Expand!=1) $where_elter = "AND Elter IN(0," . $row_navi . ")";
	}
	else
	{
		$way = array('');
		if ($nav->Expand!=1) $where_elter = "AND Elter = 0";
	}

	$nav_items = array();
	$sql = $AVE_DB->Query("
		SELECT *
		FROM " . PREFIX . "_navigation_items
		WHERE Aktiv = 1
		AND Rubrik = '" . $navigation_id . "'
		" . $where_elter . "
		ORDER BY Rang ASC
	");
	while ($row_nav_item = $sql->FetchAssocArray())
	{
		$nav_items[$row_nav_item['Elter']][] = $row_nav_item;
	}

	$ebenen = array(
		1 =>  array(
			'aktiv' => str_replace('[cp:mediapath]', ABS_PATH . 'templates/' . THEME_FOLDER . '/', $nav->ebene1a),
			'inaktiv' => str_replace('[cp:mediapath]', ABS_PATH . 'templates/' . THEME_FOLDER . '/', $nav->ebene1),
		),
		2 =>  array(
			'aktiv' => str_replace('[cp:mediapath]', ABS_PATH . 'templates/' . THEME_FOLDER . '/', $nav->ebene2a),
			'inaktiv' => str_replace('[cp:mediapath]', ABS_PATH . 'templates/' . THEME_FOLDER . '/', $nav->ebene2),
		),
		3 =>  array(
			'aktiv' => str_replace('[cp:mediapath]', ABS_PATH . 'templates/' . THEME_FOLDER . '/', $nav->ebene3a),
			'inaktiv' => str_replace('[cp:mediapath]', ABS_PATH . 'templates/' . THEME_FOLDER . '/', $nav->ebene3),
		)
	);

	$END = str_replace('[cp:mediapath]', ABS_PATH . 'templates/' . THEME_FOLDER . '/', $nav->vor);

	printNavi($END, $ebenen, $way, $navigation_id, $nav_items, $nav);

	$END .= str_replace('[cp:mediapath]', ABS_PATH . 'templates/' . THEME_FOLDER . '/', $nav->nach);
	$END = rewrite_link($END);
	$END = preg_replace("/(^[\r\n]*|[\r\n]+)[\s\t]*[\r\n]+/", "\n", $END);
//	$END = str_replace(array("\r\n","\n","\r"),'',$END);
	$END = str_replace(array("\n","\r"),'',$END);

	$search = array (
		$nav->ebene1_v . $nav->ebene1_n,
		$nav->ebene2_v . $nav->ebene2_n,
		$nav->ebene3_v . $nav->ebene3_n,
		'</li>' . $nav->ebene2_v . '<li',
		'</li>' . $nav->ebene3_v . '<li',
		'</li>' . $nav->ebene1_n . '<li',
		'</li>' . $nav->ebene2_n . '<li',
		'</li>' . $nav->ebene1_n . $nav->ebene2_n . '<li',
		'</li>' . $nav->ebene1_n . $nav->ebene2_n . $nav->ebene3_n,
		'</li>' . $nav->ebene1_n . $nav->ebene2_n,
		'</li>' . $nav->ebene2_n . $nav->ebene3_n
	);

	$replace = array (
		'',
		'',
		'',
		$nav->ebene2_v . '<li',
		$nav->ebene3_v . '<li',
		'</li>' . $nav->ebene1_n . '</li><li',
		'</li>' . $nav->ebene2_n . '</li><li',
		'</li>' . $nav->ebene1_n . '</li>' . $nav->ebene2_n . '</li><li',
		'</li>' . $nav->ebene1_n . '</li>' . $nav->ebene2_n . '</li>' . $nav->ebene3_n,
		'</li>' . $nav->ebene1_n . '</li>' . $nav->ebene2_n,
		'</li>' . $nav->ebene2_n . '</li>' . $nav->ebene3_n
	);
	$END = str_replace($search, $replace, $END);

	$navigations[$navigation_id] = $END;

	echo $END;
}

/**
 * Рекурсивная функция для формирования меню навигации
 *
 * @param string $navi
 * @param int $ebenen
 * @param string $way
 * @param int $rub
 * @param array $nav_items
 * @param string $row_ul
 * @param int $parent
 */
function printNavi(&$navi, &$ebenen, &$way, &$rub, &$nav_items, &$row_ul, $parent = 0)
{
	$ebene = $nav_items[$parent][0]['Ebene'];

	switch ($ebene)
	{
		case 1 : $navi .= $row_ul->ebene1_v;  break;
		case 2 : $navi .= $row_ul->ebene2_v;  break;
		case 3 : $navi .= $row_ul->ebene3_v;  break;
	}

	foreach ((array) $nav_items[$parent] as $row)
	{
//		$aktiv = (in_array($row['Id'], $way) || strpos($row['Link'], 'index.php?' . $_SERVER['QUERY_STRING']) !== false) ? 'aktiv' : 'inaktiv';
		$aktiv = (in_array($row['Id'], $way)) ? 'aktiv' : 'inaktiv';
		$akt = str_replace('[cp:linkname]', $row['Titel'], $ebenen[$ebene][$aktiv]);

		if (strpos($row['Link'], 'module=') === false && start_with('index.php?', $row['Link']))
		{
			$akt = str_replace('[cp:link]', $row['Link'] . "&amp;doc=" . (empty($row['Url']) ? prepare_url($row['Titel']) : $row['Url']), $akt);
		}
		else
		{
//			if (strpos($row['Link'], 'module=') === false) $row['Link'] = $row['Link'] . URL_SUFF;
			$akt = str_replace('[cp:link]', $row['Link'], $akt);
			if (start_with('www.', $row['Link'])) $akt = str_replace('www.', 'http://www.', $akt);
		}

		$navi .= str_replace('[cp:target]', $row['Ziel'], $akt);
//		$akt = str_replace('[cp:target]', $row['Ziel'], $akt);
//		$navi .= rewrite_link($akt);

		if (isset($nav_items[$row['Id']]))
		{
			printNavi($navi, $ebenen, $way, $rub, $nav_items, $row_ul, $row['Id']);
		}
	}

	switch ($ebene)
	{
		case 1 : $navi .= $row_ul->ebene1_n;  break;
		case 2 : $navi .= $row_ul->ebene2_n;  break;
		case 3 : $navi .= $row_ul->ebene3_n;  break;
	}
}

?>