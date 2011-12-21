<?php

/**
 * AVE.cms - Модуль Навигация
 *
 * @package AVE.cms
 * @subpackage module_Navigation
 * @since 1.4
 * @filesource
 */

if (!defined('BASE_DIR')) exit;

if (defined('ACP'))
{
	$modul['ModulName'] = 'Навигация';
	$modul['ModulPfad'] = 'navigation';
	$modul['ModulVersion'] = '1.2';
	$modul['description'] = 'Данный модуль предназначен не только для создания различных видов меню (горизонтального или вертикального), но и меню навигаций, состоящих из различного количества пунктов и уровней вложенности. Помните, что максимальная глубина уровней вложенности не может быть больше 3. Для создания меню, перейдите в раздел <strong>Навигация</strong>. Для отображения меню на сайте разместите системный тег <strong>[mod_navigation:XXX]</strong> в нужном месте вашего шаблона. ХХХ - это порядковый номер меню.';
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
	if (!in_array(UGROUP, $nav->navi_user_group)) return;

	if (empty($_REQUEST['module']))
	{
		$curent_doc_id = (isset($_GET['id']) && is_numeric($_GET['id'])) ? $_GET['id'] : 1;

		$row_navi = $AVE_DB->Query("
			SELECT CONCAT_WS(',', nav.Id, nav.parent_id, nav2.parent_id)
			FROM
				" . PREFIX . "_navigation_items AS nav
			JOIN
				" . PREFIX . "_documents AS doc
			LEFT JOIN
				" . PREFIX . "_navigation_items AS nav2 ON nav2.Id = nav.parent_id
			WHERE nav.navi_item_status = 1
			AND nav.navi_id = '" . $navigation_id . "'
			AND doc.Id = '" . $curent_doc_id . "'
			AND (nav.navi_item_link = 'index.php?id=" . $curent_doc_id . "'"
				. ((!empty($AVE_Core->curentdoc->document_alias) && $AVE_Core->curentdoc->Id == $curent_doc_id) ? " OR nav.document_alias = '" . $AVE_Core->curentdoc->document_alias . "'" : '')
				. " OR nav.Id = doc.document_linked_navi_id)
		")->GetCell();
	}
	else
	{
		$row_navi = $AVE_DB->Query("
			SELECT CONCAT_WS(',', nav.Id, nav.parent_id, nav2.parent_id)
			FROM
				" . PREFIX . "_navigation_items AS nav
			LEFT JOIN
				" . PREFIX . "_navigation_items AS nav2 ON nav2.Id = nav.parent_id
			WHERE nav.navi_item_status = '1'
			AND nav.navi_id = '" . $navigation_id . "'
			AND nav.navi_item_link LIKE 'index.php?module=" . $_REQUEST['module'] . "%%'
		")->GetCell();
	}

	$where_elter = '';
	if ($row_navi !== false)
	{
		$way = explode(',', $row_navi);
		if ($nav->navi_expand!=1) $where_elter = "AND parent_id IN(0," . $row_navi . ")";
	}
	else
	{
		$way = array('');
		if ($nav->navi_expand!=1) $where_elter = "AND parent_id = 0";
	}

	$nav_items = array();
	$sql = $AVE_DB->Query("
		SELECT *
		FROM " . PREFIX . "_navigation_items
		WHERE navi_item_status = '1'
		AND navi_id = '" . $navigation_id . "'
		" . $where_elter . "
		ORDER BY navi_item_position ASC
	");
	while ($row_nav_item = $sql->FetchAssocArray())
	{
		$nav_items[$row_nav_item['parent_id']][] = $row_nav_item;
	}

	$ebenen = array(
		1 =>  array(
			'aktiv' => str_replace('[tag:mediapath]', ABS_PATH . 'templates/' . THEME_FOLDER . '/', $nav->navi_level1active),
			'inaktiv' => str_replace('[tag:mediapath]', ABS_PATH . 'templates/' . THEME_FOLDER . '/', $nav->navi_level1),
		),
		2 =>  array(
			'aktiv' => str_replace('[tag:mediapath]', ABS_PATH . 'templates/' . THEME_FOLDER . '/', $nav->navi_level2active),
			'inaktiv' => str_replace('[tag:mediapath]', ABS_PATH . 'templates/' . THEME_FOLDER . '/', $nav->navi_level2),
		),
		3 =>  array(
			'aktiv' => str_replace('[tag:mediapath]', ABS_PATH . 'templates/' . THEME_FOLDER . '/', $nav->navi_level3active),
			'inaktiv' => str_replace('[tag:mediapath]', ABS_PATH . 'templates/' . THEME_FOLDER . '/', $nav->navi_level3),
		)
	);

	$END = str_replace('[tag:mediapath]', ABS_PATH . 'templates/' . THEME_FOLDER . '/', $nav->navi_begin);

	printNavi($END, $ebenen, $way, $navigation_id, $nav_items, $nav);

	$END .= str_replace('[tag:mediapath]', ABS_PATH . 'templates/' . THEME_FOLDER . '/', $nav->navi_end);
	$END = rewrite_link($END);
	$END = preg_replace("/(^[\r\n]*|[\r\n]+)[\s\t]*[\r\n]+/", "\n", $END);
//	$END = str_replace(array("\r\n","\n","\r"),'',$END);
	$END = str_replace(array("\n","\r"),'',$END);

	$search = array (
		$nav->navi_level1begin . $nav->navi_level1end,
		$nav->navi_level2begin . $nav->navi_level2end,
		$nav->navi_level3begin . $nav->navi_level3end,
		'</li>' . $nav->navi_level2begin . '<li',
		'</li>' . $nav->navi_level3begin . '<li',
		'</li>' . $nav->navi_level1end . '<li',
		'</li>' . $nav->navi_level2end . '<li',
		'</li>' . $nav->navi_level1end . $nav->navi_level2end . '<li',
		'</li>' . $nav->navi_level1end . $nav->navi_level2end . $nav->navi_level3end,
		'</li>' . $nav->navi_level1end . $nav->navi_level2end,
		'</li>' . $nav->navi_level2end . $nav->navi_level3end
	);

	$replace = array (
		'',
		'',
		'',
		$nav->navi_level2begin . '<li',
		$nav->navi_level3begin . '<li',
		'</li>' . $nav->navi_level1end . '</li><li',
		'</li>' . $nav->navi_level2end . '</li><li',
		'</li>' . $nav->navi_level1end . '</li>' . $nav->navi_level2end . '</li><li',
		'</li>' . $nav->navi_level1end . '</li>' . $nav->navi_level2end . '</li>' . $nav->navi_level3end,
		'</li>' . $nav->navi_level1end . '</li>' . $nav->navi_level2end,
		'</li>' . $nav->navi_level2end . '</li>' . $nav->navi_level3end
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
	$ebene = $nav_items[$parent][0]['navi_item_level'];

	switch ($ebene)
	{
		case 1 : $navi .= $row_ul->navi_level1begin;  break;
		case 2 : $navi .= $row_ul->navi_level2begin;  break;
		case 3 : $navi .= $row_ul->navi_level3begin;  break;
	}

	foreach ((array) $nav_items[$parent] as $row)
	{
//		$aktiv = (in_array($row['Id'], $way) || strpos($row['navi_item_link'], 'index.php?' . $_SERVER['QUERY_STRING']) !== false) ? 'aktiv' : 'inaktiv';
		$aktiv = (in_array($row['Id'], $way)) ? 'aktiv' : 'inaktiv';
		$akt = str_replace('[tag:linkname]', $row['title'], $ebenen[$ebene][$aktiv]);
		$akt = str_replace('[tag:linkid]', $row['Id'], $akt);

		if (strpos($row['navi_item_link'], 'module=') === false && start_with('index.php?', $row['navi_item_link']))
		{
			if ($row['navi_item_link'] == 'index.php?id=1') 
			{
				$akt = str_replace('[tag:link]', ABS_PATH, $akt);
			}
			else
			{
				$akt = str_replace('[tag:link]', $row['navi_item_link'] . "&amp;doc=" . (empty($row['document_alias']) ? prepare_url($row['title']) : $row['document_alias']), $akt);
			}
		}
		else
		{
//			if (strpos($row['navi_item_link'], 'module=') === false) $row['navi_item_link'] = $row['navi_item_link'] . URL_SUFF;
			$akt = str_replace('[tag:link]', $row['navi_item_link'], $akt);
			if (start_with('www.', $row['navi_item_link'])) $akt = str_replace('www.', 'http://www.', $akt);
		}

		$navi .= str_replace('[tag:target]', $row['navi_item_target'], $akt);
//		$akt = str_replace('[tag:target]', $row['navi_item_target'], $akt);
//		$navi .= rewrite_link($akt);

		if (isset($nav_items[$row['Id']]))
		{
			printNavi($navi, $ebenen, $way, $rub, $nav_items, $row_ul, $row['Id']);
		}
	}

	switch ($ebene)
	{
		case 1 : $navi .= $row_ul->navi_level1end;  break;
		case 2 : $navi .= $row_ul->navi_level2end;  break;
		case 3 : $navi .= $row_ul->navi_level3end;  break;
	}
}

?>