<?php

/**
 * Класс работы с архивом новостей
 *
 * @package AVE.cms
 * @subpackage module_Newsarchive
 * @filesource
 */
class Newsarchive
{
	/**
	 * Метод, отвечающий за вывод списка всех архивов в Панели управления
	 *
	 * @param string $tpl_dir - путь к папке с шаблонами
	 */
	function archiveList($tpl_dir)
	{
		global $AVE_DB, $AVE_Template;

		$archives = array();
		$ids = array();

		$sql = $AVE_DB->Query("SELECT * FROM " . PREFIX . "_modul_newsarchive");
		while ($row = $sql->FetchRow())
		{
			array_push($archives, $row);
		}

		$cnt = count($archives);
		for ($i=0; $i< $cnt; $i++)
		{
			$ids[] = explode(',', $archives[$i]->rubs);
		}

		$sql = $AVE_DB->Query("
			SELECT
				Id,
				RubrikName
			FROM " . PREFIX . "_rubrics
		");
		while ($row = $sql->FetchRow())
		{
			for ($i=0; $i< $cnt; $i++)
			{
				if (in_array($row->Id, $ids[$i]))
				{
					@$archives[$i]->RubrikName = strstr(@$archives[$i]->RubrikName . ', ' . @$row->RubrikName, ' ');
				}
			}
		}

		$AVE_Template->assign('archives', $archives);
		$AVE_Template->assign('content', $AVE_Template->fetch($tpl_dir . 'admin_archive_list.tpl'));
	}

	/**
	 * Метод, отвечающий за добавление нового архива в Панели управления
	 *
	 */
	function addArchive()
	{
		global $AVE_DB;

		$arc_name = htmlspecialchars($_POST['new_arc']);
		$AVE_DB->Query("
			INSERT
			INTO " . PREFIX . "_modul_newsarchive
			VALUES (
				'',
				'" . $arc_name . "',
				'',
				'1',
				'1'
			)
		");
		header('Location:index.php?do=modules&action=modedit&mod=newsarchive&moduleaction=1&cp=' . SESSION);
	}

	/**
	 * Метод, отвечающий за удаление выбранного архива из Панели управления
	 *
	 */
	function delArchive()
	{
		global $AVE_DB;

		$id = addslashes($_GET['id']);
		$AVE_DB->Query("
			DELETE
			FROM " . PREFIX . "_modul_newsarchive
			WHERE id = '" . $id . "'
		");
		header('Location:index.php?do=modules&action=modedit&mod=newsarchive&moduleaction=1&cp=' . SESSION);
	}

	/**
	 * Метод, отвечающий за схранение изменений в списке всех архивов в Панели управления
	 *
	 */
	function saveList()
	{
		global $AVE_DB;

		foreach ($_POST['arc_name'] as $id => $arc_name)
		{
			$AVE_DB->Query("
				UPDATE " . PREFIX . "_modul_newsarchive
				SET arc_name = '" . $arc_name . "'
				WHERE id = '" . $id . "'
			");
		}
		header('Location:index.php?do=modules&action=modedit&mod=newsarchive&moduleaction=1&cp=' . SESSION);
	}

	/**
	 * Метод, отвечающий за вывод данных для редактирования выбранного архива
	 *
	 * @param string $tpl_dir - путь к папке с шаблонами
	 */
	function editArchive($tpl_dir)
	{
		global $AVE_DB, $AVE_Template;

		$id = intval($_GET['id']);
		$archives = $AVE_DB->Query("
			SELECT *
			FROM " . PREFIX . "_modul_newsarchive
			WHERE id = '" . $id . "'
		")
		->FetchRow();

		$ids = explode(',', $archives->rubs);

		$sql = $AVE_DB->Query("
			SELECT
				Id,
				RubrikName
			FROM " . PREFIX . "_rubrics
		");
		$rubs = array();
		while ($row = $sql->FetchRow())
		{
			if (in_array($row->Id, $ids))
			{
				$row->sel = 1;
				array_push($rubs, $row);
			}
			else
			{
				$row->sel = 0;
				array_push($rubs, $row);
			}
		}

		$AVE_Template->assign('archives', $archives);
		$AVE_Template->assign('rubs', $rubs);
		$AVE_Template->assign('content', $AVE_Template->fetch($tpl_dir . 'admin_archive_edit.tpl'));
	}

	/**
	 * Метод, отвечающий за сохранение изменений для редактируемого архива
	 *
	 */
	function saveArchive()
	{
		global $AVE_DB;

		$id = intval($_POST['id']);
		$arc_name = htmlspecialchars($_POST['arc_name']);
		$data = implode(',', $_POST['rubs']);
		$show_days = $_POST['show_days'];
		$show_empty = $_POST['show_empty'];

		$AVE_DB->Query("
			UPDATE " . PREFIX . "_modul_newsarchive
			SET
				arc_name   = '" . $arc_name . "',
				rubs       = '" . $data . "',
				show_days  = '" . $show_days . "',
				show_empty = '" . $show_empty . "'
			WHERE
				id = '" . $id . "'
		");
		header('Location:index.php?do=modules&action=modedit&mod=newsarchive&moduleaction=1&cp=' . SESSION);
	}

	/**
	 * Метод, отвечающий за вывод списка месяцев в публичной части сайта (Основная функция вывода)
	 *
	 * @param string $tpl_dir - путь к папке с шаблонами
	 * @param int $id - идентификатор архива новостей
	 */
	function showArchive($tpl_dir, $id)
	{
		global $AVE_DB, $AVE_Template;

		$months = array('','Январь','Февраль','Март','Апрель','Май','Июнь','Июль','Август','Сентябрь','Октябрь','Ноябрь','Декабрь');
		$mid = array('','01','02','03','04','05','06','07','08','09','10','11','12');
		$dd = array();
		$doctime = get_settings('use_doctime')
			? ("AND (DokEnde = 0 || DokEnde > '" . time() . "') AND (DokStart = 0 || DokStart < '" . time() . "')")
			: '';

		$row = $AVE_DB->Query("
			SELECT
				rubs,
				show_empty
			FROM " . PREFIX . "_modul_newsarchive
			WHERE id = '" . $id . "'
		")
		->FetchRow();

		$query = $AVE_DB->Query("
			SELECT
				MONTH(FROM_UNIXTIME(DokStart)) AS `month`,
				YEAR(FROM_UNIXTIME(DokStart)) AS `year`,
				COUNT(*) AS nums
			FROM " . PREFIX . "_documents
			WHERE RubrikId IN (" . $row->rubs . ")
			AND Id != 1
			AND Id != '" . PAGE_NOT_FOUND_ID . "'
			AND Geloescht = 0
			AND DokStatus = 1
			AND DokStart > UNIX_TIMESTAMP(DATE_FORMAT((CURDATE() - INTERVAL 11 MONTH),'%Y-%m-01'))
			" . $doctime . "
			GROUP BY `month`
			ORDER BY `year` DESC,`month` DESC
	    ");

		while ($res = $query->FetchRow())
		{
			$res->mid   = $mid[$res->month];
			$res->month = $months[$res->month];
			array_push($dd, $res);
		}

		$AVE_Template->assign('archiveid', $id);
		$AVE_Template->assign('show_empty', $row->show_empty);
		$AVE_Template->assign('months', $dd);
		$AVE_Template->display($tpl_dir . 'public_archive-' . $id . '.tpl');
	}
}

?>