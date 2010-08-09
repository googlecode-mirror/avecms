<?php

/**
 *  ласс работы с модулем ¬опрос-ќтвет
 *
 * @package AVE.cms
 * @subpackage module_FAQ
 * @since 2.0
 * @filesource
 */
class Faq
{
	/**
	 * ¬ывод списка рубрик
	 *
	 * @param string $tpl_dir	путь к директории с шаблонами модул€
	 */
	public static function faqList($tpl_dir)
	{
		global $AVE_DB, $AVE_Template;

		$faq = array();
		$sql = $AVE_DB->Query("SELECT * FROM ". PREFIX ."_modul_faq");
		while ($row = $sql->FetchRow()) array_push($faq, $row);

		$AVE_Template->assign("faq_arr", $faq);
		$AVE_Template->assign("content", $AVE_Template->fetch($tpl_dir . "admin_faq_list.tpl"));
	}

	/**
	 * —оздание новой рубрики
	 *
	 */
	public static function faqNew()
	{
		global $AVE_DB;

		if (isset($_POST['new_faq_title']) && trim($_POST['new_faq_title']))
		{
			$AVE_DB->Query("INSERT INTO " . PREFIX . "_modul_faq SET id = '', faq_title = '" . substr($_POST['new_faq_title'], 0, 100) . "', faq_description = '" . substr($_POST['new_faq_desc'], 0, 255) . "'");
		}

		header("Location:index.php?do=modules&action=modedit&mod=faq&moduleaction=1&cp=" . SESSION);
		exit;
	}

	/**
	 * ”даление рубрики вместе с вопросами и ответами
	 *
	 * @param string $tpl_dir	путь к директории с шаблонами модул€
	 */
	public static function faqDelete($tpl_dir)
	{
		global $AVE_DB, $AVE_Template;

		if (isset($_GET['fid']) && is_numeric($_GET['fid']) && $_GET['fid'] > 0)
		{
			$AVE_DB->Query("DELETE FROM " . PREFIX . "_modul_faq WHERE id = '" . $_GET['fid'] . "'");
			$AVE_DB->Query("DELETE FROM " . PREFIX . "_modul_faq_quest WHERE faq_id = '" . $_GET['fid'] . "'");

			$AVE_Template->clear_cache($tpl_dir . 'show_faq.tpl', $_GET['fid']);
		}

		header("Location:index.php?do=modules&action=modedit&mod=faq&moduleaction=1&cp=" . SESSION);
		exit;
	}

	/**
	 * «апись изменений в наименовани€х и описани€х рубрик
	 *
	 * @param string $tpl_dir	путь к директории с шаблонами модул€
	 */
	public static function faqListSave($tpl_dir)
	{
		global $AVE_DB, $AVE_Template;

		foreach($_POST['faq_title'] as $id => $faq_title)
		{
			if (is_numeric($id) && $id > 0 && trim($faq_title))
			{
				$AVE_DB->Query("UPDATE " . PREFIX . "_modul_faq SET faq_title = '" . substr($faq_title, 0, 100) . "', faq_description = '" . substr($_POST['faq_description'][$id], 0, 255) . "' WHERE id = '" . $id . "'");

				$AVE_Template->clear_cache($tpl_dir . 'show_faq.tpl', $id);
			}
		}

		header("Location:index.php?do=modules&action=modedit&mod=faq&moduleaction=1&cp=" . SESSION);
		exit;
	}

	/**
	 * ¬ывод списка вопросов и ответов определЄнной рубрики
	 *
	 * @param string $tpl_dir	путь к директории с шаблонами модул€
	 */
	public static function faqQuestionList($tpl_dir)
	{
		global $AVE_DB, $AVE_Template;

		if (!(isset($_GET['fid']) && is_numeric($_GET['fid']) && $_GET['fid'] > 0))
		{
			header("Location:index.php?do=modules&action=modedit&mod=faq&moduleaction=1&cp=" . SESSION);
			exit;
		}

		$questions = array();
		$sql = $AVE_DB->Query("SELECT * FROM " . PREFIX . "_modul_faq_quest WHERE faq_id = '" . $_GET['fid'] . "'");
		while ($row = $sql->FetchRow()) array_push($questions, $row);

		$AVE_Template->assign("questions", $questions);
		$AVE_Template->assign("content", $AVE_Template->fetch($tpl_dir . "admin_faq_edit.tpl"));
	}

	/**
	 * ¬ывод формы редактировани€ вопроса и ответа на него
	 *
	 * @param string $tpl_dir	путь к директории с шаблонами модул€
	 */
	public static function faqQuestionEdit($tpl_dir)
	{
		global $AVE_DB, $AVE_Template;

		if (!(isset($_GET['fid']) && is_numeric($_GET['fid']) && $_GET['fid'] > 0))
		{
			header("Location:index.php?do=modules&action=modedit&mod=faq&moduleaction=1&cp=" . SESSION);
			exit;
		}

		if (isset($_GET['id']) && is_numeric($_GET['id']) && $_GET['id'] > 0)
		{
			$faq = $AVE_DB->Query("SELECT * FROM " . PREFIX . "_modul_faq_quest WHERE faq_id = '" . $_GET['fid'] . "' AND id = '" . $_GET['id'] . "'")->fetchAssocArray();

			if ($faq === false)
			{
				header("Location:index.php?do=modules&action=modedit&mod=faq&moduleaction=1&cp=" . SESSION);
				exit;
			}
		}
		else
		{
			$faq = array('id' => '', 'faq_quest' => '', 'faq_answer' => '', 'faq_id' => $_GET['fid']);
		}

		$AVE_Template->assign($faq);

		$AVE_Template->assign("content", $AVE_Template->fetch($tpl_dir . "admin_quest_edit.tpl"));
	}

	/**
	 * «апись нового или изменЄнного вопроса и ответа на него
	 *
	 * @param string $tpl_dir	путь к директории с шаблонами модул€
	 */
	public static function faqQuestionSave($tpl_dir)
	{
		global $AVE_DB, $AVE_Template;

		if (!(isset($_POST['fid']) && is_numeric($_POST['fid']) && $_POST['fid'] > 0))
		{
			header("Location:index.php?do=modules&action=modedit&mod=faq&moduleaction=1&cp=" . SESSION);
			exit;
		}

		if (isset($_POST['id']) && is_numeric($_POST['id']) && $_POST['id'] > 0)
		{
			$AVE_DB->Query("UPDATE " . PREFIX . "_modul_faq_quest SET faq_quest = '" . $_POST['faq_quest'] . "', faq_answer = '" . $_POST['faq_answer'] . "' WHERE id = '" . $_POST['id'] . "'");
		}
		else
		{
			if ($AVE_DB->Query("SELECT 1 FROM " . PREFIX . "_modul_faq_quest WHERE faq_id = '" . $_POST['fid'] . "'")->GetCell())
			{
				$AVE_DB->Query("INSERT INTO " . PREFIX . "_modul_faq_quest SET id = '', faq_id = '" . $_POST['fid'] . "', faq_quest = '" . $_POST['faq_quest'] . "', faq_answer = '" . $_POST['faq_answer'] . "'");
			}
		}

		$AVE_Template->clear_cache($tpl_dir . 'show_faq.tpl', $_POST['fid']);

		header("Location:index.php?do=modules&action=modedit&mod=faq&moduleaction=questlist&fid=" . $_POST['fid'] . "&cp=" . SESSION);
		exit;
	}

	/**
	 * ”даление вопроса и ответа на него
	 *
	 * @param string $tpl_dir	путь к директории с шаблонами модул€
	 */
	public static function faqQuestionDelete($tpl_dir)
	{
		global $AVE_DB, $AVE_Template;

		if (!(isset($_GET['fid']) && isset($_GET['id'])
			&& is_numeric($_GET['fid']) && is_numeric($_GET['id'])
			&& $_GET['fid'] > 0 && $_GET['id'] > 0))
		{
			header("Location:index.php?do=modules&action=modedit&mod=faq&moduleaction=1&cp=" . SESSION);
			exit;
		}

		$AVE_DB->Query("DELETE FROM " . PREFIX . "_modul_faq_quest WHERE faq_id = '" . $_GET['fid'] . "' AND id = '" . $_GET['id'] . "'");

		$AVE_Template->clear_cache($tpl_dir . 'show_faq.tpl', $_GET['fid']);

		header("Location:index.php?do=modules&action=modedit&mod=faq&moduleaction=questlist&fid=" . $_GET['fid'] . "&cp=" . SESSION);
		exit;
	}

	/**
	 * ¬ывод модул€ вопросов и ответов в публичной части
	 *
	 * @param int $id	идентификатор рубрики вопросов и ответов
	 */
	public static function faqShow($id)
	{
		global $AVE_DB, $AVE_Template;

		$faq = $AVE_DB->Query("SELECT faq_title, faq_description FROM " . PREFIX . "_modul_faq WHERE id = '" . (int)$id . "'")->fetchAssocArray();

		$questions = array();
		$sql = $AVE_DB->Query("SELECT * FROM " . PREFIX . "_modul_faq_quest WHERE faq_id = '" . (int)$id . "'");
		while ($row = $sql->FetchRow()) array_push($questions, $row);

		$AVE_Template->assign($faq);
		$AVE_Template->assign('questions', $questions);
	}
}

?>