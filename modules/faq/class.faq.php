<?php

// Base class of the module
class Faq
{
	// This function listen category in module
	function faqList($tpl_dir)
	{
		global $AVE_DB, $AVE_Template;

		$faq = array();
		$sql = $AVE_DB->Query("SELECT * FROM ". PREFIX ."_modul_faq");
		while ($row = $sql->FetchRow()) array_push($faq, $row);

		$AVE_Template->assign("faq", $faq);
		$AVE_Template->assign("content", $AVE_Template->fetch($tpl_dir . "admin_faq_list.tpl"));
	}

	// add new category
	function faqNew()
	{
		global $AVE_DB;

		$AVE_DB->Query("INSERT INTO " . PREFIX . "_modul_faq SET id = '', faq_title = '" . $_POST['new_faq_title'] . "', faq_description = '" . $_POST['new_faq_desc'] . "'");

		header("Location:index.php?do=modules&action=modedit&mod=faq&moduleaction=1&cp=" . SESSION);
		exit;
	}

	// delete category
	function faqDelete()
	{
		global $AVE_DB;

		$AVE_DB->Query("DELETE FROM " . PREFIX . "_modul_faq WHERE id = '" . (int)$_GET['id'] . "'");
		$AVE_DB->Query("DELETE FROM " . PREFIX . "_modul_faq_quest WHERE faq_id = '" . (int)$_GET['id'] . "'");

		header("Location:index.php?do=modules&action=modedit&mod=faq&moduleaction=1&cp=" . SESSION);
		exit;
	}

	// update category
	function faqListSave()
	{
		global $AVE_DB;

		foreach($_POST['faq_title'] as $id => $faq_title)
		{
			$AVE_DB->Query("UPDATE " . PREFIX . "_modul_faq SET faq_title = '" . $faq_title . "' WHERE id = '" . (int)$id . "'");
		}

		foreach($_POST['faq_description'] as $id => $faq_description)
		{
			$AVE_DB->Query("UPDATE " . PREFIX . "_modul_faq SET faq_description = '" . $faq_description . "' WHERE id = '" . (int)$id . "'");
		}

		header("Location:index.php?do=modules&action=modedit&mod=faq&moduleaction=1&cp=" . SESSION);
		exit;
	}

	// This function listen questions in category
	function faqQuestList($tpl_dir)
	{
		global $AVE_DB, $AVE_Template;

		$faq_arr = array();
		$sql = $AVE_DB->Query("SELECT * FROM " . PREFIX . "_modul_faq_quest WHERE faq_id = '" . (int)$_GET['id'] . "'");
		while ($row = $sql->FetchRow()) array_push($faq_arr, $row);

		$AVE_Template->assign("faq_arr", $faq_arr);
		$AVE_Template->assign("faq_id", (int)$_GET['id']);
		$AVE_Template->assign("content", $AVE_Template->fetch($tpl_dir . "admin_faq_edit.tpl"));
	}

	// edit question
	function faqQuestEdit($tpl_dir)
	{
		global $AVE_DB, $AVE_Template;

		$faq = $AVE_DB->Query("SELECT * FROM " . PREFIX . "_modul_faq_quest WHERE id = '" . (int)$_GET['id'] . "'")->fetchAssocArray();
		$AVE_Template->assign($faq);

		$AVE_Template->assign("content", $AVE_Template->fetch($tpl_dir . "admin_quest_edit.tpl"));
	}

	// save question
	function faqQuestSave()
	{
		global $AVE_DB;

		$id  = (int)$_POST['id'];
		$fid = (int)$_POST['faq_id'];

		if (empty($id))
		{
			$AVE_DB->Query("INSERT INTO " . PREFIX . "_modul_faq_quest SET id = '', faq_id = '" . $fid . "', faq_quest = '" . $_POST['faq_quest'] . "', faq_answer = '" . $_POST['faq_answer'] . "'");
		}
		else
		{
			$AVE_DB->Query("UPDATE " . PREFIX . "_modul_faq_quest SET faq_quest = '" . $_POST['faq_quest'] . "', faq_answer = '" . $_POST['faq_answer'] . "' WHERE id = '" . $id . "'");
		}

		header("Location:index.php?do=modules&action=modedit&mod=faq&moduleaction=questlist&cp=" . SESSION . "&id=" . $fid);
		exit;
	}

	// delete question
	function faqQuestDelete()
	{
		global $AVE_DB;

		$fid = $AVE_DB->Query("SELECT faq_id FROM " . PREFIX . "_modul_faq_quest WHERE id = '" . (int)$_GET['id'] . "'")->GetCell();

		$AVE_DB->Query("DELETE FROM " . PREFIX . "_modul_faq_quest WHERE id = '" . (int)$_GET['id'] . "'");

		header("Location:index.php?do=modules&action=modedit&mod=faq&moduleaction=questlist&cp=" . SESSION . "&id=" . $fid);
		exit;
	}

	// show faq
	function faqShow($tpl_dir, $id)
	{
		global $AVE_DB, $AVE_Template;

		$faq = $AVE_DB->Query("SELECT faq_title, faq_description FROM " . PREFIX . "_modul_faq WHERE id = '" . (int)$id . "'")->fetchAssocArray();

		$faq_arr = array();
		$sql = $AVE_DB->Query("SELECT * FROM " . PREFIX . "_modul_faq_quest WHERE faq_id = '" . (int)$id . "'");
		while ($row = $sql->FetchRow()) array_push($faq_arr, $row);

		$AVE_Template->assign($faq);
		$AVE_Template->assign('faq_arr', $faq_arr);

		echo rewrite_link($AVE_Template->fetch($tpl_dir . 'show_faq.tpl'));
	}
}

?>