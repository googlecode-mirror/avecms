<?php

/**
 * AVE.cms - ћодуль  арта сайта
 *
 * @package AVE.cms
 * @subpackage module_SiteMap
 * @since 1.4
 * @filesource
 */

if (!defined('BASE_DIR')) exit;

if (defined('ACP'))
{
    $modul['ModulName'] = ' арта сайта';
    $modul['ModulPfad'] = 'sitemap';
    $modul['ModulVersion'] = '1.0';
    $modul['description'] = 'ƒанный модуль предназначен дл€ построени€ карты вашего сайта на основании пунктов меню навигации. ƒл€ того, чтобы осуществить просмотр карты сайта, необходимо разместить системный тег <strong>[mod_sitemap:XXX]</strong> в теле какого-либо документа, где XXX - идентификаторы меню навигации указанные через зап€тую.';
    $modul['Autor'] = 'Arcanum';
    $modul['MCopyright'] = '&copy; 2007 Overdoze Team';
    $modul['Status'] = 1;
    $modul['IstFunktion'] = 1;
    $modul['AdminEdit'] = 0;
    $modul['ModulFunktion'] = 'mod_sitemap';
    $modul['CpEngineTagTpl'] = '[mod_sitemap:XXX]';
    $modul['CpEngineTag'] = '#\\\[mod_sitemap:([\\\d,]*)]#';
    $modul['CpPHPTag'] = "<?php mod_sitemap(''$1''); ?>";
}

/**
 * ‘ункци€ вывода карты сайта
 *
 * @param int $navi_ids - идентификатор меню навигации
 * или нескольких меню указанных через зап€тую
 * дл€ формировани€ карты сайта.
 * ≈сли идентификатор не указан используютс€ все меню
 */
function mod_sitemap($navi_ids = '')
{
	global $AVE_DB;

	if (!empty($navi_ids))
	{
		$sql = array();

		$navi_ids = explode(',', $navi_ids);

		foreach ($navi_ids as $navi_id)
		{
			if (is_numeric($navi_id) && check_navi_permission($navi_id))
			{
				array_push($sql,
					"(
						SELECT *
						FROM " . PREFIX . "_navigation_items
						WHERE navi_item_status = '1'
						AND navi_id = " . $navi_id . "
						ORDER BY navi_item_position ASC
					)"
				);
			}
		}

		$sql = implode(' UNION ', $sql);

		if (empty($sql)) return;
	}
	else
	{
		$navigations = get_navigations();

		if (empty($navigations)) return;

		$navi_in = array();
		foreach ($navigations as $navigation)
		{
			if (in_array(UGROUP, $navigation->navi_user_group))
			{
				array_push($navi_in, $navigation->id);
			}
		}

		if (sizeof($navi_in)) {
			$sql = "
				SELECT *
				FROM " . PREFIX . "_navigation_items
				WHERE navi_item_status = '1'
				AND navi_id IN(" . implode(',', $navi_in) . ")
				ORDER BY navi_id ASC, navi_item_position ASC
			";
		}
		else
		{
			return;
		}
	}

	$nav_items = array();
	$sql = $AVE_DB->Query($sql);
	while ($row_nav_item = $sql->FetchAssocArray())
	{
		$nav_items[$row_nav_item['parent_id']][] = $row_nav_item;
	}

	$sitemap = '';
	if (sizeof($nav_items))
	{
		printSitemap($nav_items, $sitemap);
	}

	echo $sitemap;
}

/**
 * –екурсивна€ функци€ формировани€ карты сайта
 *
 * @param int $nav_items
 * @param string $sitemap
 * @param int $parent
 */
function printSitemap(&$nav_items, &$sitemap = '', $parent = 0)
{
	$sitemap .= empty($sitemap) ?  '<ul class="sitemap">' : '<ul>';

	foreach ($nav_items[$parent] as $row)
	{
		if (strpos($row['navi_item_link'], 'module=') === false && start_with('index.php?', $row['navi_item_link']))
		{
			$row['navi_item_link'] .= '&amp;doc=' . (empty($row['document_alias']) ? prepare_url($row['title']) : $row['document_alias']);
		}

		if (start_with('www.', $row['navi_item_link']))
		{
			$row['navi_item_link'] = str_replace('www.', 'http://www.', $row['navi_item_link']);
		}

		$row['navi_item_link'] = rewrite_link($row['navi_item_link']);

		$sitemap .= '<li><a href="' . $row['navi_item_link'] . '" target="' . $row['navi_item_target'] . '">';
		$sitemap .= pretty_chars($row['title']) . '</a>';

		if (isset($nav_items[$row['Id']]))
		{
			printSitemap($nav_items, $sitemap, $row['Id']);
		}

		$sitemap .= '</li>';
	}

	$sitemap .= '</ul>';
}

?>