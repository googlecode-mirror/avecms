<?php

/**
 * ����� ������ � ���������� �������
 *
 * @package AVE.cms
 * @subpackage module_SysBlock
 * @author Mad Den
 * @since 2.07
 * @filesource
 */
class sysblock
{
	/**
	 * ����� ������ ��������� ������
	 *
	 * @param string $tpl_dir - ���� � ����� � ��������� ������
	 */
	function sysblockList($tpl_dir)
	{
		global $AVE_DB, $AVE_Template;

		$sysblocks = array();
		$sql = $AVE_DB->Query("SELECT * FROM " . PREFIX . "_modul_sysblock");
		while ($result = $sql->FetchRow())
		{
			array_push($sysblocks, $result);
		}

		$AVE_Template->assign('sysblocks', $sysblocks);
		$AVE_Template->assign('content', $AVE_Template->fetch($tpl_dir . 'admin_list.tpl'));
	}

	/**
	 * ���������� ���������� �����
	 *
	 * @param int $sysblock_id ������������� ���������� �����
	 */
	function sysblockSave($sysblock_id = null)
	{
		global $AVE_DB;

		if (is_numeric($sysblock_id))
		{
			$AVE_DB->Query("
				UPDATE " . PREFIX . "_modul_sysblock
				SET
					sysblock_name = '" . $_POST['sysblock_name'] . "',
					sysblock_text = '" . $_POST['sysblock_text'] . "'
				WHERE
					id = '" . $sysblock_id . "'
			");
		}
		else
		{
			$AVE_DB->Query("
				INSERT
				INTO " . PREFIX . "_modul_sysblock
				SET
					id = '',
					sysblock_name = '" . $_POST['sysblock_name'] . "',
					sysblock_text = '" . $_POST['sysblock_text'] . "'
			");
		}

		header('Location:index.php?do=modules&action=modedit&mod=sysblock&moduleaction=1&cp=' . SESSION);
	}

	/**
	 * �������������� ���������� �����
	 *
	 * @param int $sysblock_id ������������� ���������� �����
	 * @param string $tpl_dir - ���� � ����� � ��������� ������
	 *
	 * @todo ������� �������� ������ ���������� � ��������������
	 */
	function sysblockEdit($sysblock_id, $tpl_dir)
	{
		global $AVE_DB, $AVE_Template;

		if (is_numeric($sysblock_id))
		{
			$sql = $AVE_DB->Query("
				SELECT *
				FROM " . PREFIX . "_modul_sysblock
				WHERE id = '" . $sysblock_id . "'
			");

			$row = $sql->FetchAssocArray();
		}
		else
		{
			$row['sysblock_name'] = '';
			$row['sysblock_text'] = '';
		}

		$oFCKeditor = new FCKeditor('sysblock_text');
		$oFCKeditor->Height = '400';
		$oFCKeditor->ToolbarSet = 'Simple';
		$oFCKeditor->Value = $row['sysblock_text'];
		$row['sysblock_text'] = $oFCKeditor->Create();

		$AVE_Template->assign($row);
		$AVE_Template->assign('content', $AVE_Template->fetch($tpl_dir . 'admin_edit.tpl'));
	}

	/**
	 * �������� ���������� �����
	 *
	 * @param int $sysblock_id ������������� ���������� �����
	 */
	function sysblockDelete($sysblock_id)
	{
		global $AVE_DB;

		if (is_numeric($sysblock_id))
		{
			$AVE_DB->Query("
				DELETE
				FROM " . PREFIX . "_modul_sysblock
				WHERE id = '" . $sysblock_id . "'
			");
		}

		header('Location:index.php?do=modules&action=modedit&mod=sysblock&moduleaction=1&cp=' . SESSION);
	}
}

?>