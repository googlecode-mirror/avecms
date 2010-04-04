<?php

/**
 * AVE.cms
 *
 * @package AVE.cms
 * @filesource
 */

/**
 * Класс работы с навигацией
 */
class AVE_Navigation
{

/**
 * ВНЕШНИЕ МЕТОДЫ
 */

	/**
	 * Вывод списка существующих меню навигации в админке
	 *
	 */
	function showNavis()
	{
		global $AVE_DB, $AVE_Template;

		$mod_navis = array();

		$sql = $AVE_DB->Query("
			SELECT
				id,
				titel
			FROM " . PREFIX . "_navigation
			ORDER BY id ASC
		");

		while ($row_navis = $sql->fetchrow())
		{
			array_push($mod_navis, $row_navis);
		}
		$sql->Close();

		$AVE_Template->assign('mod_navis', $mod_navis);
		$AVE_Template->assign('content', $AVE_Template->fetch('navigation/overview.tpl'));
	}

	/**
	 * Управление статусом пунктов меню навигации
	 * (вызывается при изменении статуса документа с идентификатором $id)
	 *
	 * @param int $off_on 1 - активировать, 0 - деактивировать
	 * @param int $id идентификатор документа на который ссылается пункт меню
	 */
	function statusNavi($off_on, $id)
	{
		global $AVE_DB;

		$off_on = (int)$off_on;
		$id     = (int)$id;
		$action = ($off_on == 1) ? 'активировал' : 'деактивировал';

		$sql = $AVE_DB->Query("
			SELECT Id
			FROM " . PREFIX . "_navigation_items
			WHERE Link = 'index.php?id=" . $id . "'
			AND Aktiv != '" . $off_on . "'
		");

		while ($row = $sql->fetchrow())
		{
			$AVE_DB->Query("
				UPDATE " . PREFIX . "_navigation_items
				SET Aktiv = '" . $off_on . "'
				WHERE Id = '" . $row->Id . "'
			");

			reportLog($_SESSION['user_name'] . " - " . $action . " пункт меню навигации (" . $row->Id . ")", 2, 2);
		}
	}

	/**
	 * Удаление пунктов меню навигации связанных с удаляемым документа
	 * (вызывается при удалении документа с идентификатором $id)
	 * Если у пункта меню нет потомков - пункт удаляется,
	 * иначе пункт деактивируется
	 *
	 * @param int $id идентификатор удаляемого документа
	 */
	function delNavi($id)
	{
		global $AVE_DB;

		$id = (int)$id;

		$sql = $AVE_DB->Query("
			SELECT Id
			FROM " . PREFIX . "_navigation_items
			WHERE Link = 'index.php?id=" . $id . "'
		");
		while ($row = $sql->fetchrow())
		{
			$num = $AVE_DB->Query("
				SELECT Id
				FROM " . PREFIX . "_navigation_items
				WHERE Elter = '" . $row->Id . "'
				LIMIT 1
			")->NumRows();

			if ($num==1)
			{
				$AVE_DB->Query("
					UPDATE " . PREFIX . "_navigation_items
					SET Aktiv = 0
					WHERE Id = '" . $row->Id . "'
				");

				reportLog($_SESSION['user_name'] . " - деактивировал пункт меню навигации (" . $row->Id . ")", 2, 2);
			}
			else
			{
				$AVE_DB->Query("
					DELETE
					FROM " . PREFIX . "_navigation_items
					WHERE Id = '" . $row->Id . "'
				");

				reportLog($_SESSION['user_name'] . " - удалил пункт меню навигации (" . $row->Id . ")", 2, 2);
			}
		}
	}

	/**
	 * Вывод пунктов меню навигации в админке
	 *
	 * @param int $id идентификатор меню навигации
	 */
	function showEntries($id)
	{
		global $AVE_DB, $AVE_Template;

		$id = (int)$id;

		$entries = array();

		$sql_navis = $AVE_DB->Query("
			SELECT *
			FROM " . PREFIX . "_navigation_items
			WHERE Rubrik = '" . $id . "'
			AND Elter = 0
			AND Ebene = 1
			ORDER BY Rang ASC
		");

		while ($row_navis = $sql_navis->fetchrow())
		{
			$entries_2 = array();

			$sql_2 = $AVE_DB->Query("
				SELECT *
				FROM " . PREFIX . "_navigation_items
				WHERE Rubrik = '" . $id . "'
				AND Elter = '" . $row_navis->Id . "'
				AND Ebene = 2
				ORDER BY Rang ASC
			");
			while ($row_2 = $sql_2->fetchrow())
			{
				$entries_3 = array();

				$sql_3 = $AVE_DB->Query("
					SELECT *
					FROM " . PREFIX . "_navigation_items
					WHERE Rubrik = '" . $id . "'
					AND Elter = '" . $row_2->Id . "'
					AND Ebene = 3
					ORDER BY Rang ASC
				");
				while ($row_3 = $sql_3->fetchrow())
				{
					array_push($entries_3, $row_3);
				}

				$row_2->ebene_3 = $entries_3;
				array_push($entries_2, $row_2);
			}
			$row_navis->ebene_2 = $entries_2;
			array_push($entries, $row_navis);
		}

		$sql = $AVE_DB->Query("
			SELECT titel
			FROM " . PREFIX . "_navigation
			WHERE id = '" . $id . "'
		");
		$row = $sql->fetchrow();

		$AVE_Template->assign('NavigatonName', $row->titel);
		$AVE_Template->assign('entries', $entries);
		$AVE_Template->assign('content', $AVE_Template->fetch('navigation/entries.tpl'));
	}

	/**
	 * Формирование списка пунктов всех меню навигации
	 *
	 */
	function showAllEntries()
	{
		global $AVE_DB, $AVE_Template;

		$entries = array();
		$rubs = array();

		$sql = $AVE_DB->Query("
			SELECT
				id,
				titel AS RubrikName
			FROM " . PREFIX . "_navigation
		");

		while ($row_all = $sql->fetchrow())
		{
			$sql_navis = $AVE_DB->Query("
				SELECT *
				FROM " . PREFIX . "_navigation_items
				WHERE Rubrik = '" . $row_all->id . "'
				AND Elter = 0
				AND Ebene = 1
				ORDER BY Rang ASC
			");

			while ($row_navis = $sql_navis->fetchrow())
			{
				$entries_2 = array();

				$sql_2 = $AVE_DB->Query("
					SELECT *
					FROM " . PREFIX . "_navigation_items
					WHERE Rubrik = '" . $row_all->id . "'
					AND Elter = '" . $row_navis->Id . "'
					AND Ebene = 2
					ORDER BY Rang ASC
				");

				while ($row_2 = $sql_2->fetchrow())
				{
					$entries_3 = array();

					$sql_3 = $AVE_DB->Query("
						SELECT *
						FROM " . PREFIX . "_navigation_items
						WHERE Rubrik = '" . $row_all->id . "'
						AND Elter = '" . $row_2->Id . "'
						AND Ebene = 3
						ORDER BY Rang ASC
					");
					while ($row_3 = $sql_3->fetchrow())
					{
						array_push($entries_3, $row_3);
					}

					$row_2->ebene_3 = $entries_3;
					array_push($entries_2, $row_2);
				}

				$row_navis->ebene_2 = $entries_2;
				$row_navis->RubId = $row_all->id;
				$row_navis->Rubname = $row_all->RubrikName;
				array_push($entries, $row_navis);
			}
			array_push($rubs, $row_all);
		}

		$AVE_Template->assign('rubs', $rubs);
		$AVE_Template->assign('navi_entries', $entries);
	}

	/**
	 * Управление пунктами меню навигации в админке
	 *
	 * @param int $id идентификатор меню навигации
	 */
	function quickSave($nav_id)
	{
		global $AVE_DB;

		$nav_id = (int)$nav_id;

		// изменение параметров пунктов меню
		foreach ($_POST['Titel'] as $id => $Titel)
		{
			if (!empty($Titel))
			{
				$id = (int)$id;
				$_POST['Link'][$id] = (strpos($_POST['Link'][$id], 'javascript') !== false) ?
					str_replace(array(' ', '-', '%'), '_', $_POST['Link'][$id]) : $_POST['Link'][$id];
				$aktiv = (empty($_POST['Aktiv'][$id]) || $_POST['Aktiv'][$id] == 0 || empty($_POST['Link'][$id])) ? 0 : 1;
				$AVE_DB->Query("
					UPDATE " . PREFIX . "_navigation_items
					SET
						Titel = '" . $this->_replace_wildcode($Titel) . "',
						Link  = '" . $_POST['Link'][$id] . "',
						Rang  = '" . intval($_POST['Rang'][$id]) . "',
						Ziel  = '" . $_POST['Ziel'][$id] . "',
						Aktiv = '" . $aktiv . "'
					WHERE
						Id = '" . $id . "'
				");
			}
		}

		// добавление новых пунктов меню первого уровня
		if (!empty($_POST['Titel_N'][0]))
		{
			$AVE_DB->Query("
				INSERT
				INTO " . PREFIX . "_navigation_items
				SET
					Id     = '',
					Titel  = '" . $this->_replace_wildcode($_POST['Titel_N'][0]) . "',
					Elter  = '0',
					Link   = '" . $_POST['Link_N'][0] . "',
					Ziel   = '" . $_POST['Ziel_N'][0] . "',
					Ebene  = '1',
					Rang   = '" . intval($_POST['Rang_N'][0]) . "',
					Rubrik = '" . intval($_POST['Rubrik']) . "',
					Aktiv  = '" . (empty($_POST['Link_N'][0]) ? 0 : 1) . "',
					Url    = '" . cpParseLinkname(empty($_POST['Url_N'][0]) ? $_POST['Titel_N'][0] : $_POST['Url_N'][0]) . "'
			");

			reportLog($_SESSION['user_name'] . " - добавил пункт меню навигации (" . $_POST['Titel_N'][0] . ") - на первый уровень", 2, 2);
		}

		// добавление новых пунктов меню второго уровня
		foreach ($_POST['Titel_Neu_2'] as $new2_id => $Titel)
		{
			if (!empty($Titel))
			{
				$new2_id = (int)$new2_id;
				$AVE_DB->Query("
					INSERT
					INTO " . PREFIX . "_navigation_items
					SET
						Id     = '',
						Titel  = '" . $this->_replace_wildcode($Titel) . "',
						Elter  = '" . $new2_id . "',
						Link   = '" . $_POST['Link_Neu_2'][$new2_id] . "',
						Ziel   = '" . $_POST['Ziel_Neu_2'][$new2_id] . "',
						Ebene  = '2',
						Rang   = '" . intval($_POST['Rang_Neu_2'][$new2_id]) . "',
						Rubrik = '" . intval($_POST['Rubrik']) . "',
						Aktiv  = '" . (empty($_POST['Link_Neu_2'][$new2_id]) ? 0 : 1) . "',
						Url    = '" . cpParseLinkname(empty($_POST['Url_Neu_2'][$new2_id]) ? $Titel : $_POST['Url_Neu_2'][$new2_id]) . "'
				");

				reportLog($_SESSION['user_name'] . " - добавил пункт меню навигации (" . $Titel . ") - второй уровень", 2, 2);
			}
		}

		// добавление новых пунктов меню третьего уровня
		foreach ($_POST['Titel_Neu_3'] as $new3_id => $Titel)
		{
			if (!empty($Titel))
			{
				$new3_id = (int)$new3_id;
				$AVE_DB->Query("
					INSERT
					INTO " . PREFIX . "_navigation_items
					SET
						Id     = '',
						Titel  = '" . $this->_replace_wildcode($Titel) . "',
						Elter  = '" . $new3_id . "',
						Link   = '" . $_POST['Link_Neu_3'][$new3_id] . "',
						Ziel   = '" . $_POST['Ziel_Neu_3'][$new3_id] . "',
						Ebene  = '3',
						Rang   = '" . intval($_POST['Rang_Neu_3'][$new3_id]) . "',
						Rubrik = '" . intval($_POST['Rubrik']) . "',
						Aktiv  = '" . (empty($_POST['Link_Neu_3'][$new3_id]) ? 0 : 1) . "',
						Url    = '" . cpParseLinkname(empty($_POST['Url_Neu_3'][$new3_id]) ? $Titel : $_POST['Url_Neu_3'][$new3_id]) . "'
				");

				reportLog($_SESSION['user_name'] . " - добавил пункт меню навигации (" . $Titel . ") - третий уровень", 2, 2);
			}
		}

		// удаление пунктов меню навигации
		if (!empty($_POST['del']) && is_array($_POST['del']))
		{
			foreach ($_POST['del'] as $del_id => $del)
			{
				if (!empty($del))
				{
					$del_id = (int)$del_id;
					$num = $AVE_DB->Query("
						SELECT Id
						FROM " . PREFIX . "_navigation_items
						WHERE Elter = '" . $del_id . "'
						LIMIT 1
					")->NumRows();

					if ($num==1)
					{
						$AVE_DB->Query("
							UPDATE " . PREFIX . "_navigation_items
							SET Aktiv = 0
							WHERE Id = '" . $del_id . "'
						");

						reportLog($_SESSION['user_name'] . " - деактивировал пункт меню навигации (" . $del_id . ")", 2, 2);
					}
					else
					{
						$AVE_DB->Query("
							DELETE
							FROM " . PREFIX . "_navigation_items
							WHERE Id = '" . $del_id . "'
						");

						reportLog($_SESSION['user_name'] . " - удалил пункт меню навигации (" . $del_id . ")", 2, 2);
					}
				}
			}
		}

		header('Location:index.php?do=navigation&action=entries&id=' . $nav_id . '&cp=' . SESSION);
		exit;
	}

	/**
	 * Изменение настроек меню навигации
	 *
	 * @param int $id идентификатор меню навигации
	 */
	function naviTemplate($id)
	{
		global $AVE_DB, $AVE_Template;

		$id = (int)$id;

		switch ($_REQUEST['sub'])
		{
			case '': // вывод формы настроек меню навигации
				$group = new AVE_User;
				$sql = $AVE_DB->Query("
					SELECT *
					FROM " . PREFIX . "_navigation
					WHERE id = '" . $id . "'
				");
				$row = $sql->fetchrow();

				$row->Gruppen = explode(',', $row->Gruppen);
				$row->AvGroups = $group->listAllGroups();
				$AVE_Template->assign('nav', $row);
				$AVE_Template->assign('formaction', 'index.php?do=navigation&amp;action=templates&amp;sub=save&amp;id=' . $id . '&amp;cp=' . SESSION);
				$AVE_Template->assign('content', $AVE_Template->fetch('navigation/template.tpl'));
				break;

			case 'save': // запись изменений меню навигации
				$AVE_DB->Query("
					UPDATE " . PREFIX . "_navigation
					SET
						titel    = '" . $_POST['titel'] . "',
						ebene1   = '" . $_POST['ebene1'] . "',
						ebene1a  = '" . $_POST['ebene1a'] . "',
						ebene2   = '" . $_POST['ebene2'] . "',
						ebene2a  = '" . $_POST['ebene2a'] . "',
						ebene3   = '" . $_POST['ebene3'] . "',
						ebene3a  = '" . $_POST['ebene3a'] . "',
						ebene1_v = '" . $_POST['ebene1_v'] . "',
						ebene1_n = '" . $_POST['ebene1_n'] . "',
						ebene2_v = '" . $_POST['ebene2_v'] . "',
						ebene2_n = '" . $_POST['ebene2_n'] . "',
						ebene3_v = '" . $_POST['ebene3_v'] . "',
						ebene3_n = '" . $_POST['ebene3_n'] . "',
						vor      = '" . $_POST['vor'] . "',
						nach     = '" . $_POST['nach'] . "',
						Gruppen  = '" . (empty($_REQUEST['Gruppen']) ? '' : implode(',', $_REQUEST['Gruppen'])) . "',
						Expand   = '" . (empty($_POST['Expand']) ? 0 : $_POST['Expand']) . "'
					WHERE
						id = '" . (int)$_REQUEST['id'] . "'
				");

				reportLog($_SESSION['user_name'] . ' - изменил шаблон меню навигации (' . $_POST['titel'] . ')', 2, 2);

				header('Location:index.php?do=navigation&cp=' . SESSION);
				exit;
				break;
		}
	}

	/**
	 * Новое меню навигации
	 *
	 */
	function naviTemplateNew()
	{
		global $AVE_DB, $AVE_Template, $AVE_User;

		switch($_REQUEST['sub'])
		{
			case '': // вывод формы ввода нового меню навигации
				$AVE_User = new AVE_User;
				$row->AvGroups = $AVE_User->listAllGroups();
				$AVE_Template->assign('row', $row);
				$AVE_Template->assign('formaction', 'index.php?do=navigation&amp;action=new&amp;sub=save&amp;cp=' . SESSION);
				$AVE_Template->assign('content', $AVE_Template->fetch('navigation/template.tpl'));
				break;

			case 'save': // запись нового меню навигации
				$titel   = (empty($_POST['titel']))   ? 'title' : $_POST['titel'];
				$ebene1  = (empty($_POST['ebene1']))  ? "<a target=\"[cp:target]\" href=\"[cp:link]\">[cp:linkname]</a>" : $_POST['ebene1'];
				$ebene1a = (empty($_POST['ebene1a'])) ? "<a target=\"[cp:target]\" href=\"[cp:link]\" class=\"first_active\">[cp:linkname]</a>" : $_POST['ebene1a'];

				$AVE_DB->Query("
					INSERT
					INTO " . PREFIX . "_navigation
					SET
						id       = '',
						titel    = '" . $titel . "',
						ebene1   = '" . $ebene1 . "',
						ebene1a  = '" . $ebene1a . "',
						ebene2   = '" . $_POST['ebene2'] . "',
						ebene2a  = '" . $_POST['ebene2a'] . "',
						ebene3   = '" . $_POST['ebene3'] . "',
						ebene3a  = '" . $_POST['ebene3a'] . "',
						ebene1_v = '" . $_POST['ebene1_v'] . "',
						ebene2_v = '" . $_POST['ebene2_v'] . "',
						ebene3_v = '" . $_POST['ebene3_v'] . "',
						ebene1_n = '" . $_POST['ebene1_n'] . "',
						ebene2_n = '" . $_POST['ebene2_n'] . "',
						ebene3_n = '" . $_POST['ebene3_n'] . "',
						vor      = '" . $_POST['vor'] . "',
						nach     = '" . $_POST['nach'] . "',
						Gruppen  = '" . (empty($_REQUEST['Gruppen']) ? '' : implode(',', $_REQUEST['Gruppen'])) . "',
						Expand   = '" . (empty($_POST['Expand']) ? 0 : $_POST['Expand']) . "'
				");

				reportLog($_SESSION['user_name'] . " - создал меню навигации (" . $titel . ")", 2, 2);

				header('Location:index.php?do=navigation&cp=' . SESSION);
				break;
		}
	}

	/**
	 * Копирование настроек меню навигации
	 *
	 * @param int $id идентификатор меню навигации источника
	 */
	function copyNaviTemplate($id)
	{
		global $AVE_DB;

		$id = (int)$id;

		$sql = $AVE_DB->Query("
			SELECT *
			FROM " . PREFIX . "_navigation
			WHERE id = '" . $id . "'
		");
		$row = $sql->fetchrow();

		$AVE_DB->Query("
			INSERT
			INTO " . PREFIX . "_navigation
			SET
				id       = '',
				titel    = '" . addslashes($row->titel . ' ' . $GLOBALS['config_vars']['CopyT']) . "',
				ebene1   = '" . addslashes($row->ebene1) . "',
				ebene1a  = '" . addslashes($row->ebene1a) . "',
				ebene2   = '" . addslashes($row->ebene2) . "',
				ebene2a  = '" . addslashes($row->ebene2a) . "',
				ebene3   = '" . addslashes($row->ebene3) . "',
				ebene3a  = '" . addslashes($row->ebene3a) . "',
				vor      = '" . addslashes($row->vor) . "',
				nach     = '" . addslashes($row->nach) . "',
				ebene1_v = '" . addslashes($row->ebene1_v) . "',
				ebene2_v = '" . addslashes($row->ebene2_v) . "',
				ebene3_v = '" . addslashes($row->ebene3_v) . "',
				ebene1_n = '" . addslashes($row->ebene1_n) . "',
				ebene2_n = '" . addslashes($row->ebene2_n) . "',
				ebene3_n = '" . addslashes($row->ebene3_n) . "',
				Gruppen  = '" . addslashes($row->Gruppen) . "',
				Expand   = '" . addslashes($row->Expand) . "'
		");

		reportLog($_SESSION['user_name'] . " - создал копию меню навигации (" . $row->titel . ")", 2, 2);

		header('Location:index.php?do=navigation&cp=' . SESSION);
	}

	/**
	 * Удаление меню навигации и всех его пунктов
	 *
	 * @param int $id идентификатор меню навигации
	 */
	function deleteNavi($id)
	{
		global $AVE_DB;

		if (is_numeric($id) && $id != 1)
		{
			$AVE_DB->Query("DELETE FROM " . PREFIX . "_navigation WHERE id = '" . $id . "'");
			$AVE_DB->Query("DELETE FROM " . PREFIX . "_navigation_items WHERE Rubrik = '" . $id . "'");
			reportLog($_SESSION['user_name'] . " - удалил меню навигации (" . $id . ")", 2, 2);
		}

		header('Location:index.php?do=navigation&cp=' . SESSION);
	}

/**
 * ВНУТРЕННИЕ МЕТОДЫ
 */

	/**
	 * Очистка от запрещённых символов
	 * и преобразование специальных символов в HTML сущности
	 *
	 * @param string $text
	 * @return string
	 */
	function _replace_wildcode($text)
	{
		$text = ereg_replace('([^ :)/(_A-Za-zА-Яа-яЁё0-9&-])', '', $text);
		$text = htmlspecialchars($text);
		return $text;
	}
}

?>