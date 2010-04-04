<?php

/**
 * AVE.cms - Модуль Системные блоки
 *
 * @filesource
 */
/**
 * Класс работы с системными блоками
 *
 * @package AVE.cms
 * @subpackage module_SysBlock
 */
class sysblock
{
	/**
	 * Вывод списка системных блоков
	 *
	 * @param string $tpl_dir - путь к папке с шаблонами модуля
	 */
	function ListBlock($tpl_dir)
	{
		global $AVE_DB, $AVE_Template;

		$sysBlock = array();
		$sql = $AVE_DB->Query("SELECT * FROM " . PREFIX . "_modul_sysblock");
		while ($result = $sql->FetchRow())
		{
			array_push($sysBlock, $result);
		}

		$AVE_Template->assign('SysBlock', $sysBlock);
		$AVE_Template->assign('content', $AVE_Template->fetch($tpl_dir . 'admin_list.tpl'));
	}

	/**
	 * Сохранение системного блока
	 *
	 */
	function SaveBlock()
	{
		global $AVE_DB;

		if (isset($_REQUEST['id']) && is_numeric($_REQUEST['id']))
		{
			$AVE_DB->Query("
				UPDATE " . PREFIX . "_modul_sysblock
				SET
					sysblock_name = '" . $_POST['sysblock_name'] . "',
					sysblock_text = '" . $_POST['sysblock_text'] . "'
				WHERE
					id = '" . $_REQUEST['id'] . "'
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
	 * Редактирование системного блока
	 *
	 * @param string $tpl_dir - путь к папке с шаблонами модуля
	 */
	function EditBlock($tpl_dir)
	{
		global $AVE_DB, $AVE_Template;

		if (isset($_REQUEST['id']) && is_numeric($_REQUEST['id']))
		{
			$sql = $AVE_DB->Query("
				SELECT *
				FROM " . PREFIX . "_modul_sysblock
				WHERE id = '" . $_REQUEST['id'] . "'
			");

			$row = $sql->FetchAssocArray();
		}
		else
		{
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
	 * Удаление системного блока
	 *
	 */
	function DelBlock()
	{
		global $AVE_DB;

		if (isset($_REQUEST['id']) && is_numeric($_REQUEST['id']))
		{
			$AVE_DB->Query("
				DELETE
				FROM " . PREFIX . "_modul_sysblock
				WHERE id = '" . $_REQUEST['id'] . "'
			");
		}

		header('Location:index.php?do=modules&action=modedit&mod=sysblock&moduleaction=1&cp=' . SESSION);
	}

	/**
	 * Вывод текстового блока
	 *
	 * @param int $id идентификатор системного блока
	 */
	function ShowSysBlock($id)
	{
		global $AVE_DB, $Shared;

		if (is_numeric($id))
		{
			$sql = $AVE_DB->Query("
				SELECT sysblock_text
				FROM " . PREFIX . "_modul_sysblock
				WHERE id = '" . $id . "'
				LIMIT 1
			");
			$return = prettyChars($sql->GetCell());
			$return = str_replace('[cp:mediapath]', 'templates/' . THEME_FOLDER . '/', $return);
//			$return = parseModuleTag($return);
//			$return = stripslashes(hide($return));
			$return = hide($return);

			eval ('?>' . $return . '<?');
		}
	}
}

?>