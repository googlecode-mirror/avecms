<?php

/**
 * ����� ������ � ������� ��������
 *
 * @package AVE.cms
 * @subpackage module_Newsarchive
 * @filesource
 */
class Newsarchive
{
	/**
	 * �����, ���������� �� ����� ������ ���� ������� � ������ ����������
	 *
	 * @param string $tpl_dir - ���� � ����� � ���������
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
			$ids[] = explode(',', $archives[$i]->newsarchive_rubrics);
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
					@$archives[$i]->RubrikName = strstr($archives[$i]->RubrikName . ', ' . $row->RubrikName, ' ');
				}
			}
		}

		$AVE_Template->assign('archives', $archives);
		$AVE_Template->assign('content', $AVE_Template->fetch($tpl_dir . 'admin_archive_list.tpl'));
	}

	/**
	 * �����, ���������� �� ���������� ������ ������ � ������ ����������
	 *
	 */
	function addArchive()
	{
		global $AVE_DB;

		$AVE_DB->Query("
			INSERT
			INTO " . PREFIX . "_modul_newsarchive
			SET
				id = '',
				newsarchive_name = '" . $_POST['newsarchive_name_new'] . "',
				newsarchive_rubrics = '',
				newsarchive_show_days = '1',
				newsarchive_show_empty = ''
		");

		header('Location:index.php?do=modules&action=modedit&mod=newsarchive&moduleaction=edit&cp=' . SESSION . '&id=' . $AVE_DB->InsertId());
		exit;
	}

	/**
	 * �����, ���������� �� �������� ���������� ������ �� ������ ����������
	 *
	 */
	function delArchive()
	{
		global $AVE_DB;

		$AVE_DB->Query("
			DELETE
			FROM " . PREFIX . "_modul_newsarchive
			WHERE id = '" . intval($_GET['id']) . "'
		");

		header('Location:index.php?do=modules&action=modedit&mod=newsarchive&moduleaction=1&cp=' . SESSION);
		exit;
	}

	/**
	 * �����, ���������� �� ��������� ��������� � ������ ���� ������� � ������ ����������
	 *
	 */
	function saveList()
	{
		global $AVE_DB;

		foreach ((array)$_POST['newsarchive_name'] as $id => $newsarchive_name)
		{
			$AVE_DB->Query("
				UPDATE " . PREFIX . "_modul_newsarchive
				SET newsarchive_name = '" . $newsarchive_name . "'
				WHERE id = '" . (int)$id . "'
			");
		}

		header('Location:index.php?do=modules&action=modedit&mod=newsarchive&moduleaction=1&cp=' . SESSION);
		exit;
	}

	/**
	 * �����, ���������� �� ����� ������ ��� �������������� ���������� ������
	 *
	 * @param string $tpl_dir - ���� � ����� � ���������
	 */
	function editArchive($tpl_dir)
	{
		global $AVE_DB, $AVE_Template;

		$id = intval($_GET['id']);
		$archives = $AVE_DB->Query("
			SELECT *
			FROM " . PREFIX . "_modul_newsarchive
			WHERE id = '" . $id . "'
		")->FetchRow();

		$ids = @explode(',', $archives->newsarchive_rubrics);

		$sql = $AVE_DB->Query("
			SELECT
				Id,
				RubrikName
			FROM " . PREFIX . "_rubrics
		");
		$newsarchive_rubrics = array();
		while ($row = $sql->FetchRow())
		{
			if (in_array($row->Id, $ids))
			{
				$row->sel = 1;
				array_push($newsarchive_rubrics, $row);
			}
			else
			{
				$row->sel = 0;
				array_push($newsarchive_rubrics, $row);
			}
		}

		$AVE_Template->assign('archives', $archives);
		$AVE_Template->assign('newsarchive_rubrics', $newsarchive_rubrics);
		$AVE_Template->assign('content', $AVE_Template->fetch($tpl_dir . 'admin_archive_edit.tpl'));
	}

	/**
	 * �����, ���������� �� ���������� ��������� ��� �������������� ������
	 *
	 */
	function saveArchive()
	{
		global $AVE_DB;

		$AVE_DB->Query("
			UPDATE " . PREFIX . "_modul_newsarchive
			SET
				newsarchive_name = '" . $_POST['newsarchive_name'] . "',
				newsarchive_rubrics = '" . implode(',', (array)$_POST['newsarchive_rubrics']) . "',
				newsarchive_show_days = '" . $_POST['newsarchive_show_days'] . "',
				newsarchive_show_empty = '" . $_POST['newsarchive_show_empty'] . "'
			WHERE
				id = '" . intval($_POST['id']) . "'
		");

		header('Location:index.php?do=modules&action=modedit&mod=newsarchive&moduleaction=1&cp=' . SESSION);
		exit;
	}

	/**
	 * �����, ���������� �� ����� ������ ������� � ��������� ����� ����� (�������� ������� ������)
	 *
	 * @param string $tpl_dir - ���� � ����� � ���������
	 * @param int $id - ������������� ������ ��������
	 */
	function showArchive($tpl_dir, $id)
	{
		global $AVE_DB, $AVE_Template;

		$months = array('','������','�������','����','������','���','����','����','������','��������','�������','������','�������');
		$mid = array('','01','02','03','04','05','06','07','08','09','10','11','12');
		$dd = array();
		$doctime = get_settings('use_doctime')
			? ("AND (DokEnde = 0 || DokEnde > '" . time() . "') AND DokStart < '" . time() . "'")
			: '';

		$row = $AVE_DB->Query("
			SELECT
				newsarchive_rubrics,
				newsarchive_show_empty
			FROM " . PREFIX . "_modul_newsarchive
			WHERE id = '" . $id . "'
		")->FetchRow();

		$query = $AVE_DB->Query("
			SELECT
				MONTH(FROM_UNIXTIME(DokStart)) AS `month`,
				YEAR(FROM_UNIXTIME(DokStart)) AS `year`,
				COUNT(*) AS nums
			FROM " . PREFIX . "_documents
			WHERE RubrikId IN (" . $row->newsarchive_rubrics . ")
			AND Id != '1'
			AND Id != '" . PAGE_NOT_FOUND_ID . "'
			AND Geloescht = '0'
			AND DokStatus = '1'
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
		$AVE_Template->assign('newsarchive_show_empty', $row->newsarchive_show_empty);
		$AVE_Template->assign('months', $dd);
		$AVE_Template->display($tpl_dir . 'public_archive-' . $id . '.tpl');
	}
}

?>