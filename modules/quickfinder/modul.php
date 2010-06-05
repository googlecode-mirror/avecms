<?php

if (!defined('BASE_DIR')) exit;

if (defined('ACP'))
{
    $modul['ModulName'] = '������� �������';
    $modul['ModulPfad'] = 'quickfinder';
    $modul['ModulVersion'] = '1.0';
    $modul['Beschreibung'] = '������ ������ �������� �������������� �������� ����������� ���� ��������� �� �����. �� ����������� � ���� ����������� ������ �������� � ����������� ������ �����. ��� ������������� ������, ���������� ��������� ��� <strong>[mod_quickfinder:XXX]</strong> � ������ ����� ������ �������, ��� XXX - �������������� ���� ��������� ��������� ����� �������.';
    $modul['Autor'] = 'Arcanum';
    $modul['MCopyright'] = '&copy; 2007 Overdoze Team';
    $modul['Status'] = 0;
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
								Elter,
								Titel,
								Link,
								Ziel,
								Ebene,
								Url,
								0 AS active
							FROM " . PREFIX . "_navigation_items
							WHERE Aktiv = '1'
							AND Rubrik = " . $navi_id . "
							ORDER BY Rang ASC
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
			if (in_array(UGROUP, $navigation->Gruppen))
			{
				array_push($navi_in, $navigation->id);
			}
		}

		if (sizeof($navi_in)) {
			$sql = "
				SELECT
					Id,
					Elter,
					Titel,
					Link,
					Ziel,
					Ebene,
					Url,
					0 AS active
				FROM " . PREFIX . "_navigation_items
				WHERE Aktiv = '1'
				AND Rubrik IN(" . implode(',', $navi_in) . ")
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
		if (empty($_REQUEST['module']))
		{
			$curent_doc_id = (isset($_GET['id']) && is_numeric($_GET['id'])) ? $_GET['id'] : 1;
			if ($row_nav_item['Url'] == $AVE_Core->curentdoc->Url ||
				$row_nav_item['Link'] == 'index.php?id=' . $curent_doc_id)
			{
				$row_nav_item['active'] = 1;
			}
		}
		else
		{
			if ($row_nav_item['Link'] == 'index.php?module=' . $_REQUEST['module'])
			{
				$row_nav_item['active'] = 1;
			}
		}

		$nav_items[$row_nav_item['Elter']][] = $row_nav_item;
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
		if (strpos($row['Link'], 'module=') === false && start_with('index.php?', $row['Link']))
		{
			$row['Link'] .= '&amp;doc=' . (empty($row['Url']) ? prepare_url($row['Titel']) : $row['Url']);
		}

		if (start_with('www.', $row['Link']))
		{
			$row['Link'] = str_replace('www.', 'http://www.', $row['Link']);
		}

		$row['Link'] = rewrite_link($row['Link']);

		if (!start_with('javascript:', $row['Link']))
		{
			if ($row['Ziel'] == '_blank')
			{
				$row['Link'] = "javascript:window.open('" . $row['Link'] . "', '', '')";
			}
			else //if ($row['Ziel'] == '' || $row['Ziel'] == '_self')
			{
				$row['Link'] = "window.location.href = '" . $row['Link'] . "'";
			}
		}

		$quickfinder .= '<option class="level_' . $row['Ebene'] . '" value="' . $row['Link'] . '"' . ($row['active'] == 1 ? ' selected="selected"' : '') . '>' . pretty_chars($row['Titel']) . '</option>';

		if (isset($nav_items[$row['Id']]))
		{
			printQuickfinder($nav_items, $quickfinder, $row['Id']);
		}
	}
}

?>