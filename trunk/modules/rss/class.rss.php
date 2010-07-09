<?php

/**
 * Класс работы с RSS-лентами
 *
 * @package AVE.cms
 * @subpackage module_RSS
 * @since 2.07
 * @filesource
 */
class Rss
{
	/**
	 * Список RSS - лент
	 *
	 * @param string $tpl_dir путь к папке с шаблонами
	 */
	function rssList($tpl_dir, $lang_file)
	{
		global $AVE_DB, $AVE_Template;

		$AVE_Template->config_load($lang_file);

		$channels = array();
		$sql = $AVE_DB->Query("SELECT * FROM " . PREFIX . "_modul_rss");
		while ($result = $sql->FetchRow())
		{
			$result->tag = '[mod_rss:' . $result->id . ']';
			array_push($channels, $result);
		}

		$AVE_Template->assign('channel', $channels);
		$AVE_Template->assign('content', $AVE_Template->fetch($tpl_dir . 'rss_list.tpl'));
	}

	/**
	 * Создание RSS - ленты
	 *
	 */
	function rssNew()
	{
		global $AVE_DB;

		$home = addslashes(substr(get_home_link(), 0, -6));

		$AVE_DB->Query("
			INSERT
			INTO " . PREFIX . "_modul_rss
			SET
				id                     = '',
				rss_site_name          = '" . $_POST['new_rss'] . "',
				rss_site_description   = '',
				rss_site_url           = '" . $home . "',
				rss_rubric_id          = 1,
				rss_title_id           = 0,
				rss_description_id     = 0,
				rss_item_on_page       = 10,
				rss_description_lenght = 200
		");

		$iid = $AVE_DB->InsertId();

		header('Location:index.php?do=modules&action=modedit&mod=rss&moduleaction=edit&cp=' . SESSION . '&id=' . $iid);
		exit;
	}

	/**
	 * Редактирование RSS - ленты
	 *
	 * @param string $tpl_dir	путь к папке с шаблонами
	 * @param string $lang_file	путь к языковому файлу
	 */
	function rssEdit($tpl_dir, $lang_file)
	{
		global $AVE_DB, $AVE_Template;

		$AVE_Template->config_load($lang_file);

		$result = $AVE_DB->Query("
			SELECT *
			FROM " . PREFIX . "_modul_rss
			WHERE id = '" . (int)($_REQUEST['id']) . "'
		")->FetchRow();

		if (isset($_REQUEST['rubric_id']) && is_numeric($_REQUEST['rubric_id']))
		{
			$result->rss_rubric_id = $_REQUEST['rubric_id'];
		}

		$rubriks = array();
		$get_rubs = $AVE_DB->Query("
			SELECT
				Id,
				rubric_title
			FROM " . PREFIX . "_rubrics
		");
		while ($res = $get_rubs->FetchRow())
		{
			array_push($rubriks, $res);
		}

		$fields = array();
		$get_fields = $AVE_DB->Query("SELECT
				Id,
				rubric_id,
				rubric_field_title
			FROM " . PREFIX . "_rubric_fields
			WHERE rubric_id = '" . $result->rss_rubric_id . "'
		");
		while ($res = $get_fields->FetchRow())
		{
			array_push($fields,$res);
		}

		$AVE_Template->assign('channel', $result);
		$AVE_Template->assign('rubriks', $rubriks);
		$AVE_Template->assign('fields', $fields);
		$AVE_Template->assign('content', $AVE_Template->fetch($tpl_dir . 'rss_edit.tpl'));
	}

	/**
	 * Запись настроек
	 *
	 */
	function rssSave()
	{
		global $AVE_DB;

		$AVE_DB->Query("
			UPDATE " . PREFIX . "_modul_rss
			SET
				rss_site_name          = '" . $_POST['rss_site_name'] . "',
				rss_site_description   = '" . $_POST['site_descr'] . "',
				rss_site_url           = '" . $_POST['rss_site_url'] . "',
				rss_rubric_id          = '" . (int)$_POST['rss_rubric_id'] . "',
				rss_title_id           = '" . (int)$_POST['field_title'] . "',
				rss_description_id     = '" . (int)$_POST['field_descr'] . "',
				rss_item_on_page       = '" . (int)$_POST['rss_item_on_page'] . "',
				rss_description_lenght = '" . (int)$_POST['rss_description_lenght'] . "'
			WHERE
				id = '" . (int)$_POST['id'] . "'
		");

		header('Location:index.php?do=modules&action=modedit&mod=rss&moduleaction=edit&cp=' . SESSION . '&id=' . (int)$_POST['id']);
		exit;
	}

	/**
	 * Удаление RSS - ленты
	 *
	 */
	function rssDelete()
	{
		global $AVE_DB;

		$AVE_DB->Query("
			DELETE
			FROM " . PREFIX . "_modul_rss
			WHERE id = '" . (int)$_REQUEST['id'] . "'
		");

		header('Location:index.php?do=modules&action=modedit&mod=rss&moduleaction=1&cp=' . SESSION);
		exit;
	}
}

?>