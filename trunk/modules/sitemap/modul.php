<?php

/**
 * AVE.cms - ћодуль  арта сайта
 *
 * @package AVE.cms
 * @subpackage module_SiteMap
 * @filesource
 */

if (!defined('BASE_DIR')) exit;

if (defined('ACP'))
{
    $modul['ModulName'] = ' арта сайта';
    $modul['ModulPfad'] = 'sitemap';
    $modul['ModulVersion'] = '1.0';
    $modul['Beschreibung'] = 'ƒанный модуль предназначен дл€ построени€ карты вашего сайта на основании пунктов меню навигации. ƒл€ того, чтобы осуществить просмотр карты сайта, необходимо разместить системный тег <strong>[mod_sitemap:XXX]</strong> в теле какого-либо документа, где XXX - идентификаторы меню навигации указанные через зап€тую.';
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
 * @param int $id - идентификатор меню навигации
 * или нескольких меню указанных через зап€тую
 * дл€ формировани€ карты сайта.
 * ≈сли идентификатор не указан используютс€ все меню
 */
function mod_sitemap($id = '')
{
	global $AVE_DB, $navigations;

	if (!empty($id))
	{
		$sql = array();

		$id = explode(',', $id);

		foreach ($id as $val)
		{
			if (is_numeric($val) && checkSeePerm($val))
			{
				array_push($sql,
					"(
						SELECT *
						FROM " . PREFIX . "_navigation_items
						WHERE Aktiv = '1'
						AND Rubrik = " . $val . "
						ORDER BY Rang ASC
					)"
				);
			}
		}

		$sql = implode(' UNION ', $sql);

		if (empty($sql)) return;
	}
	else
	{
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
		if (empty($navigations)) return;

		$rubrik_in = array();
		foreach ($navigations as $val)
		{
			if (in_array(UGROUP, $val->Gruppen))
			{
				array_push($rubrik_in, $val->id);
			}
		}

		if (sizeof($rubrik_in)) {
			$sql = "
				SELECT *
				FROM " . PREFIX . "_navigation_items
				WHERE Aktiv = '1'
				AND Rubrik IN(" . implode(',', $rubrik_in) . ")
				ORDER BY Rubrik ASC, Rang ASC
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
		$nav_items[$row_nav_item['Elter']][] = $row_nav_item;
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
		if (strpos($row['Link'], 'module=') === false &&
			startsWith('index.php?', $row['Link']))
		{
			$row['Link'] .= '&amp;doc=' . (empty($row['Url'])
				? cpParseLinkname($row['Titel'])
				: $row['Url']);
		}

		if (startsWith('www.', $row['Link']))
		{
			$row['Link'] = str_replace('www.', 'http://www.', $row['Link']);
		}

		if (CP_REWRITE == 1)
		{
			$row['Link'] = cpRewrite($row['Link']);
		}

		$sitemap .= '<li><a href="' . $row['Link'] . '" target="' . $row['Ziel'] . '">';
		$sitemap .= prettyChars($row['Titel']) . '</a>';

		if (isset($nav_items[$row['Id']]))
		{
			printSitemap($nav_items, $sitemap, $row['Id']);
		}

		$sitemap .= '</li>';
	}

	$sitemap .= '</ul>';
}

?>