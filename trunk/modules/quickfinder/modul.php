<?php

if (!defined('BASE_DIR')) exit;

if (defined('ACP'))
{
    $modul['ModulName'] = 'Быстрый переход';
    $modul['ModulPfad'] = 'quickfinder';
    $modul['ModulVersion'] = '1.0';
    $modul['Beschreibung'] = 'Данный модуль является альтернативным способом организации меню навигации на сайте. Он представлен в виде выпадающего списка разделов и подразделов вашего сайта. Для использования модуля, разместите системный тег <strong>[mod_quickfinder:XXX]</strong> в нужном месте вашего шаблона, где XXX - идентификаторы меню навигации указанные через запятую.';
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

function mod_quickfinder($id = '')
{
	global $AVE_DB, $AVE_Core, $navigations;

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
		if (strpos($row['Link'], 'module=') === false && startsWith('index.php?', $row['Link']))
		{
			$row['Link'] .= '&amp;doc=' . (empty($row['Url']) ? cpParseLinkname($row['Titel']) : $row['Url']);
		}

		if (startsWith('www.', $row['Link']))
		{
			$row['Link'] = str_replace('www.', 'http://www.', $row['Link']);
		}

		if (CP_REWRITE == 1)
		{
			$row['Link'] = cpRewrite($row['Link']);
		}

		if (!startsWith('javascript:', $row['Link']))
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

		$quickfinder .= '<option class="level_' . $row['Ebene'] . '" value="' . $row['Link'] . '"' . ($row['active'] == 1 ? ' selected="selected"' : '') . '>' . prettyChars($row['Titel']) . '</option>';

		if (isset($nav_items[$row['Id']]))
		{
			printQuickfinder($nav_items, $quickfinder, $row['Id']);
		}
	}
}

?>