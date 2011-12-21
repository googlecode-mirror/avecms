<?php

/**
 * AVE.cms - Модуль Быстрый переход
 *
 * @package AVE.cms
 * @subpackage module_QuickFinder
 * @since 1.4
 * @filesource
 */

if (!defined('BASE_DIR')) exit;

if (defined('ACP'))
{
    $modul['ModulName'] = 'Быстрый переход';
    $modul['ModulPfad'] = 'quickfinder';
    $modul['ModulVersion'] = '1.0';
    $modul['description'] = 'Данный модуль является альтернативным способом организации меню навигации на сайте. Он представлен в виде выпадающего списка разделов и подразделов вашего сайта. Для использования модуля, разместите системный тег <strong>[mod_quickfinder:XXX]</strong> в нужном месте вашего шаблона, где XXX - идентификаторы меню навигации указанные через запятую.';
    $modul['Autor'] = 'Arcanum';
    $modul['MCopyright'] = '&copy; 2007 Overdoze Team';
    $modul['Status'] = 1;
    $modul['IstFunktion'] = 1;
    $modul['AdminEdit'] = 0;
    $modul['ModulFunktion'] = 'mod_quickfinder';
    $modul['CpEngineTagTpl'] = '[mod_quickfinder:XXX]';
    $modul['CpEngineTag'] = '#\\\[mod_quickfinder:([\\\d,]*)]#';
    $modul['CpPHPTag'] = "<?php mod_quickfinder(''$1''); ?>";
}

function mod_quickfinder($navi_ids = '')
{
	global $AVE_DB, $AVE_Core, $navigations;

	if (!empty($navi_ids))
	{
		$sql = array();

		$navi_ids = explode(',', $navi_ids);

		foreach ($navi_ids as $navi_id)
		{
			if (is_numeric($navi_id) && check_navi_permission($navi_id))
			{
				$sql[] = "(
							SELECT
								Id,
								parent_id,
								title,
								navi_item_link,
								navi_item_target,
								navi_item_level,
								document_alias,
								0 AS active
							FROM " . PREFIX . "_navigation_items
							WHERE navi_item_status = '1'
							AND navi_id = " . $navi_id . "
							ORDER BY navi_item_position ASC
						)";
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
				SELECT
					Id,
					parent_id,
					title,
					navi_item_link,
					navi_item_target,
					navi_item_level,
					document_alias,
					0 AS active
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
		if (empty($_REQUEST['module']))
		{
			$curent_doc_id = (isset($_GET['id']) && is_numeric($_GET['id'])) ? $_GET['id'] : 1;
			if ($row_nav_item['document_alias'] == $AVE_Core->curentdoc->document_alias ||
				$row_nav_item['navi_item_link'] == 'index.php?id=' . $curent_doc_id)
			{
				$row_nav_item['active'] = 1;
			}
		}
		else
		{
			if ($row_nav_item['navi_item_link'] == 'index.php?module=' . $_REQUEST['module'])
			{
				$row_nav_item['active'] = 1;
			}
		}

		$nav_items[$row_nav_item['parent_id']][] = $row_nav_item;
	}

	if (sizeof($nav_items))
	{
		$quickfinder = '<select class="mod_quickfinder" name="quickfinder" onchange="eval(this.options[this.selectedIndex].value);">';
		$quickfinder .= '<option></option>';
		printQuickfinder($nav_items, $quickfinder);
		echo $quickfinder . '</select>';
	}
}

function printQuickfinder(&$nav_items, &$quickfinder = '', $parent = '0')
{
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

		if (!start_with('javascript:', $row['navi_item_link']))
		{
			if ($row['navi_item_target'] == '_blank')
			{
				$row['navi_item_link'] = "javascript:window.open('" . $row['navi_item_link'] . "', '', '')";
			}
			else //if ($row['navi_item_target'] == '' || $row['navi_item_target'] == '_self')
			{
				$row['navi_item_link'] = "window.location.href = '" . $row['navi_item_link'] . "'";
			}
		}

		$quickfinder .= '<option class="level_' . $row['navi_item_level'] . '" value="' . $row['navi_item_link'] . '"' . ($row['active'] == 1 ? ' selected="selected"' : '') . '>' . pretty_chars($row['title']) . '</option>';

		if (isset($nav_items[$row['Id']]))
		{
			printQuickfinder($nav_items, $quickfinder, $row['Id']);
		}
	}
}

?>