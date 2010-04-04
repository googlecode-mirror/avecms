<?php

/**
 * AVE.cms - Модуль RSS
 *
 * @filesource
 */
/**
 * Класс работы с RSS-лентами
 *
 * @package AVE.cms
 * @subpackage module_RSS
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
		$config_vars = $AVE_Template->get_config_vars();
		$AVE_Template->assign('config_vars', $config_vars);

		$channels = array();
		$sql = $AVE_DB->Query("SELECT * FROM " . PREFIX . "_modul_rss");
		while ($result = $sql->FetchRow())
		{
			$result->tag = '[rss:' . $result->id . ']';
			array_push($channels, $result);
		}

		$AVE_Template->assign('channel', $channels);
		$AVE_Template->assign('content', $AVE_Template->fetch($tpl_dir . 'rss_list.tpl'));
	}

	/**
	 * Создание RSS - ленты
	 *
	 */
	function rssAdd()
	{
		global $AVE_DB;

		$rss_name = htmlspecialchars($_POST['new_rss']);
		$AVE_DB->Query("
			INSERT " . PREFIX . "_modul_rss
			VALUES ('', '" . $rss_name . "', '', '', 0, 0, 0, 10, 200)
		");
		header('Location:index.php?do=modules&action=modedit&mod=rss&moduleaction=1&cp=' . SESSION);
	}

	/**
	 * Редактирование RSS - ленты
	 *
	 * @param string $tpl_dir путь к папке с шаблонами
	 */
	function rssEdit($tpl_dir, $lang_file)
	{
		global $AVE_DB, $AVE_Template;

		$AVE_Template->config_load($lang_file);
		$config_vars = $AVE_Template->get_config_vars();
		$AVE_Template->assign('config_vars', $config_vars);

		$id = (int)($_GET['id']);
		$sql = $AVE_DB->Query("
			SELECT *
			FROM " . PREFIX . "_modul_rss
			WHERE id = '" . $id . "'
		");
		$result = $sql->FetchRow();

		if (isset($_REQUEST['RubrikId']) && is_numeric($_REQUEST['RubrikId']))
		{
			$result->rub_id = (int)$_REQUEST['RubrikId'];
		}

		$rubriks = array();
		$get_rubs = $AVE_DB->Query("
			SELECT
				Id,
				RubrikName
			FROM " . PREFIX . "_rubrics
		");
		while ($res = $get_rubs->FetchRow())
		{
			array_push($rubriks,$res);
		}

		$fields = array();
		$get_fields = $AVE_DB->Query("SELECT
				Id,
				RubrikId,
				Titel
			FROM " . PREFIX . "_rubric_fields
			WHERE RubrikId = '" . $result->rub_id . "'
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

		$rss_name  = htmlspecialchars(addslashes($_POST['rss_name']));
		$id        = (int)$_POST['id'];
		$rub_id    = (int)$_POST['rub_id'];
		$rss_des   = htmlspecialchars($_POST['site_descr']);
		$site_url  = $_POST['site_url'];
		$title     = (int)$_POST['field_title'];
		$descr     = (int)$_POST['field_descr'];
		$limit     = (int)$_POST['rss_on_page'];
		$lenght    = (int)$_POST['rss_lenght'];

		$AVE_DB->Query("
			UPDATE " . PREFIX . "_modul_rss
			SET
				rss_name  = '" . $rss_name . "',
				rss_descr = '" . $rss_des . "',
				site_url  = '" . $site_url . "',
				rub_id    = '" . $rub_id . "',
				title_id  = '" . $title . "',
				descr_id  = '" . $descr . "',
				on_page   = '" . $limit . "',
				lenght    = '" . $lenght . "'
			WHERE
				id = '" . $id . "'
		");
		header('Location:index.php?do=modules&action=modedit&mod=rss&moduleaction=1&cp=' . SESSION);
	}

	/**
	 * Удаление RSS - ленты
	 *
	 */
	function rssDelete()
	{
		global $AVE_DB;

		$id = addslashes($_GET['id']);
		$AVE_DB->Query("
			DELETE
			FROM " . PREFIX . "_modul_rss
			WHERE id = '" . $id . "'
		");
		header('Location:index.php?do=modules&action=modedit&mod=rss&moduleaction=1&cp=' . SESSION);
	}
}

?>