<?php
class Roadmap {

	var $_limit = 15;

	function list_projects($tpl_dir) {
		$limit = $this->_limit;
		$sql = $GLOBALS['AVE_DB']->Query("SELECT id
			FROM " . PREFIX . "_modul_roadmap
		");
		$num = $sql->NumRows();

		$pages = ceil($num / $limit);
		$start = prepage() * $limit - $limit;

		$items = array();
		$sql = $GLOBALS['AVE_DB']->Query("SELECT *
			FROM " . PREFIX . "_modul_roadmap
			ORDER BY position
			LIMIT " . $start . "," . $limit
		);
		while($row = $sql->FetchRow()) {
			$sql_2 = $GLOBALS['AVE_DB']->Query("SELECT id
				FROM " . PREFIX . "_modul_roadmap_tasks
				WHERE pid = '" . $row->id . "'
				AND task_status = 0
			");
			$row->open_tasks = $sql_2->NumRows();

			$sql_2 = $GLOBALS['AVE_DB']->Query("SELECT id
				FROM " . PREFIX . "_modul_roadmap_tasks
				WHERE pid = '" . $row->id . "'
				AND task_status = 1
			");
			$row->closed_tasks = $sql_2->NumRows();

			array_push($items, $row);
		}

		if($num > $limit)
		{
			$page_nav = pagenav($pages, 'page',
				" <a class=\"pnav\" href=\"index.php?do=modules&action=modedit&mod=roadmap&moduleaction=1&cp=" . SESSION . "&page={s}\">{t}</a> ");
			$GLOBALS['AVE_Template']->assign('page_nav', $page_nav);
		}

		$GLOBALS['AVE_Template']->assign('items', $items);
		$GLOBALS['AVE_Template']->assign('content', $GLOBALS['AVE_Template']->fetch($tpl_dir . 'admin_projects.tpl'));
	}

	function edit_project($tpl_dir,$id) {
		switch($_REQUEST['sub']) {
			case '':
				$GLOBALS['AVE_Template']->assign('formaction', 'index.php?do=modules&action=modedit&mod=roadmap&moduleaction=edit_project&id=$id&sub=save&cp=' . SESSION . '&pop=1');

				$sql = $GLOBALS['AVE_DB']->Query("SELECT *
					FROM " . PREFIX . "_modul_roadmap
					WHERE id = '" . $id . "'
				");
				$row = $sql->FetchRow();

				$GLOBALS['AVE_Template']->assign('item', $row);
				$GLOBALS['AVE_Template']->assign('content', $GLOBALS['AVE_Template']->fetch($tpl_dir . 'admin_project_form.tpl'));

				break;

			case 'save':
				$GLOBALS['AVE_DB']->Query("
					UPDATE " . PREFIX . "_modul_roadmap
					SET
						project_desc = '" . $_REQUEST['project_desc']. "',
						project_name = '" . $_REQUEST['project_name'] . "',
						position = '" . $_REQUEST['position'] . "',
						project_status = '" . $_REQUEST['project_status'] . "'
					WHERE
						id = '" . $id . "'
				");

				reportLog($_SESSION['user_name'] . ' - отредактировал проект', 2, 2);

				echo '<script>window.opener.location.reload(); self.close();</script>';
				break;
		}
	}

	function new_project($tpl_dir) {

		switch($_REQUEST['sub']) {
			case '':
				$GLOBALS['AVE_Template']->assign('formaction', 'index.php?do=modules&action=modedit&mod=roadmap&moduleaction=new_project&sub=save&cp=' . SESSION . '&pop=1');
				$GLOBALS['AVE_Template']->assign('content', $GLOBALS['AVE_Template']->fetch($tpl_dir . 'admin_project_form.tpl'));
				break;

			case 'save':
				$GLOBALS['AVE_DB']->Query("
					INSERT INTO " . PREFIX . "_modul_roadmap
					(
						id,
						project_name,
						project_desc,
						project_status,
						position
					) VALUES (
						'',
						'" . $_REQUEST['project_name'] . "',
						'" . $_REQUEST['project_desc'] . "',
						'" . $_REQUEST['project_status'] . "',
						'" . $_REQUEST['position'] . "'
					)
				");

				reportLog($_SESSION['user_name'] . ' - добавил новый проект', 2, 2);

				echo '<script>window.opener.location.reload(); self.close();</script>';
				break;
		}
	}

	function del_project($id) {
		$GLOBALS['AVE_DB']->Query("DELETE FROM " . PREFIX . "_modul_roadmap WHERE id = '" . $id . "'");

		reportLog($_SESSION['user_name'] . ' - удалил проект', 2, 2);

		header('Location:index.php?do=modules&action=modedit&mod=roadmap&moduleaction=1&cp=' . SESSION);
		exit;
	}

	function show_tasks($tpl_dir, $id, $closed) {
		$limit = $this->_limit;
		$sql = $GLOBALS['AVE_DB']->Query("SELECT id
			FROM " . PREFIX . "_modul_roadmap_tasks
			WHERE pid = '" . $id . "'
			AND task_status = '" . $closed . "'
		");
		$num = $sql->NumRows();

		$pages = ceil($num / $limit);
		$start = prepage() * $limit - $limit;

		$items = array();
		$sql = $GLOBALS['AVE_DB']->Query("SELECT *
			FROM " . PREFIX . "_modul_roadmap_tasks
			WHERE pid = '" . $id . "'
			AND task_status = '" . $closed . "'
			ORDER BY priority
			LIMIT " . $start . "," . $limit
		);

		while($row = $sql->FetchRow()) {
			$sql_2 = $GLOBALS['AVE_DB']->Query("SELECT
					Vorname,
					Nachname
				FROM " . PREFIX . "_users
				WHERE Id = '" . $row->uid . "'
			");
			$row_2 = $sql_2->FetchRow();

			$row->lastname  = $row_2->Nachname;
			$row->firstname = $row_2->Vorname;

			switch($row->priority) {
				case'1': $row->priority = $GLOBALS['AVE_Template']->get_config_vars('ROADMAP_TASK_HIGHEST'); break;
				case'2': $row->priority = $GLOBALS['AVE_Template']->get_config_vars('ROADMAP_TASK_HIGH'); break;
				case'3': $row->priority = $GLOBALS['AVE_Template']->get_config_vars('ROADMAP_TASK_NORMAL'); break;
				case'4': $row->priority = $GLOBALS['AVE_Template']->get_config_vars('ROADMAP_TASK_LOW'); break;
				case'5': $row->priority = $GLOBALS['AVE_Template']->get_config_vars('ROADMAP_TASK_LOWEST'); break;
			}

			array_push($items, $row);
		}

		if($num > $limit)
		{
			$page_nav = pagenav($pages, 'page',
				" <a class=\"pnav\" href=\"index.php?do=modules&action=modedit&mod=roadmap&moduleaction=show_tasks&closed=$closed&id=$id&cp=" . SESSION . "&page={s}\">{t}</a> ");
			$GLOBALS['AVE_Template']->assign('page_nav', $page_nav);
		}

		$GLOBALS['AVE_Template']->assign('items', $items);
		$GLOBALS['AVE_Template']->assign('content', $GLOBALS['AVE_Template']->fetch($tpl_dir . 'admin_tasks.tpl'));
	}

	function new_task($tpl_dir, $id) {
		switch($_REQUEST['sub']) {
			case '':
				$GLOBALS['AVE_Template']->assign('formaction', 'index.php?do=modules&action=modedit&mod=roadmap&moduleaction=new_task&id=$id&sub=save&cp=' . SESSION . '&pop=1');
				$GLOBALS['AVE_Template']->assign('content', $GLOBALS['AVE_Template']->fetch($tpl_dir . 'admin_task_form.tpl'));
				break;

			case 'save':
				$GLOBALS['AVE_DB']->Query("
					INSERT INTO " . PREFIX . "_modul_roadmap_tasks
					(
						id,
						pid,
						task_desc,
						date_create,
						task_status,
						uid,
						priority
					) VALUES (
						'',
						'" . $_REQUEST['id'] . "',
						'" . $_REQUEST['task_desc'] . "',
						'" . time() . "',
						'" .$_REQUEST['task_status']. "',
						'" . $_SESSION['user_id'] . "',
						'" . $_REQUEST['priority'] . "'
					)
				");

				reportLog($_SESSION['user_name'] . ' - добавил новую задачу', '2', '2');

				echo '<script>window.opener.location.reload(); self.close();</script>';
				break;
		}
	}

	function edit_task($tpl_dir, $id) {
		switch($_REQUEST['sub']) {
			case '':
				$GLOBALS['AVE_Template']->assign('formaction', 'index.php?do=modules&action=modedit&mod=roadmap&moduleaction=edit_task&id=$id&sub=save&cp=' . SESSION . '&pop=1');

				$sql = $GLOBALS['AVE_DB']->Query("SELECT *
					FROM " . PREFIX . "_modul_roadmap_tasks
					WHERE id = '" . $id . "'
				");
				$row = $sql->FetchRow();

				$sql = $GLOBALS['AVE_DB']->Query("SELECT
						Vorname,
						Nachname
					FROM " . PREFIX . "_users
					WHERE Id = '" . $row->uid . "'
				");
				$row_2 = $sql->FetchRow();

				$row->lastname = $row_2->Nachname;
				$row->firstname = $row_2->Vorname;

				$GLOBALS['AVE_Template']->assign('item', $row);
				$GLOBALS['AVE_Template']->assign('content', $GLOBALS['AVE_Template']->fetch($tpl_dir . 'admin_task_form.tpl'));

				break;

			case 'save':

				$GLOBALS['AVE_DB']->Query("
					UPDATE " . PREFIX . "_modul_roadmap_tasks
					SET
						task_desc = '" . $_REQUEST['task_desc']. "',
						task_status = '" . $_REQUEST['task_status'] . "',
						uid = '" . $_REQUEST['uid'] . "',
						date_create = '" . time() . "',
						priority = '" . $_REQUEST['priority'] . "'
					WHERE
						Id = '" . $id . "'
				");

				reportLog($_SESSION['user_name'] . ' - отредактировал задачу', 2, 2);

				echo '<script>window.opener.location.reload(); self.close();</script>';
				break;
		}
	}

	function del_task($id, $pid, $closed) {
		$GLOBALS['AVE_DB']->Query("DELETE FROM " . PREFIX . "_modul_roadmap_tasks WHERE id = '" . $id . "'");

		reportLog($_SESSION['user_name'] . ' - удалил задачу', 2, 2);

		header('Location:index.php?do=modules&action=modedit&mod=roadmap&moduleaction=show_tasks&id=$pid&closed=$closed&cp=' . SESSION);
		exit;
	}

	function show_p($tpl_dir) {
		$items = array();
		$sql = $GLOBALS['AVE_DB']->Query("SELECT *
			FROM " . PREFIX . "_modul_roadmap
			ORDER BY position
		");
		while($row = $sql->FetchRow()) {
			$sql_2 = $GLOBALS['AVE_DB']->Query("SELECT *
				FROM " . PREFIX . "_modul_roadmap_tasks
				WHERE pid = '" . $row->id . "'
				ORDER BY date_create DESC
				LIMIT 0,1
			");
			$row_date = $sql_2->FetchRow();

			$row->date = $row_date->date_create;

			$sql_2 = $GLOBALS['AVE_DB']->Query("SELECT id
				FROM " . PREFIX . "_modul_roadmap_tasks
				WHERE pid = '" . $row->id . "'
			");
			$all_count = $sql_2->NumRows();

			$sql_2 = $GLOBALS['AVE_DB']->Query("SELECT id
				FROM " . PREFIX . "_modul_roadmap_tasks
				WHERE pid = '" . $row->id . "'
				AND task_status = 1
			");
			$row->num_closed = $sql_2->NumRows();

			$row->num_open = $all_count - $row->num_closed;

			if($row->num_closed != 0) {
				$row->closed = round($row->num_closed * 100 / $all_count);
			} else {
				$row->closed = 0;
			}

			$row->open = round(100 - $row->closed);
			array_push($items,$row);
		}

		$GLOBALS['AVE_Template']->assign('items', $items);
		$tpl_out = $GLOBALS['AVE_Template']->fetch($tpl_dir.'projects.tpl');
		define('MODULE_CONTENT', $tpl_out);
	}

	function show_t($id, $closed, $tpl_dir) {
		$id     = addslashes($id);
		$closed = addslashes($closed);

		$items = array();
		$sql = $GLOBALS['AVE_DB']->Query("SELECT *
			FROM " . PREFIX . "_modul_roadmap_tasks
			WHERE pid = '" . $id . "'
			AND task_status = '" . $closed . "'
			ORDER BY priority
		");
		while($row = $sql->FetchRow()) {
			$sql_2 = $GLOBALS['AVE_DB']->Query("SELECT
					Vorname,
					Nachname
				FROM " . PREFIX . "_users
				WHERE Id = '" . $row->uid . "'
			");~
			$row_2 = $sql_2->FetchRow();

			$row->lastname  = $row_2->Nachname;
			$row->firstname = $row_2->Vorname;

			switch($row->priority) {
				case'1': $row->priority = $GLOBALS['AVE_Template']->get_config_vars('ROADMAP_TASK_HIGHEST'); $row->prio = 1; break;
				case'2': $row->priority = $GLOBALS['AVE_Template']->get_config_vars('ROADMAP_TASK_HIGH'); $row->prio = 2; break;
				case'3': $row->priority = $GLOBALS['AVE_Template']->get_config_vars('ROADMAP_TASK_NORMAL'); $row->prio = 3; break;
				case'4': $row->priority = $GLOBALS['AVE_Template']->get_config_vars('ROADMAP_TASK_LOW'); $row->prio = 4; break;
				case'5': $row->priority = $GLOBALS['AVE_Template']->get_config_vars('ROADMAP_TASK_LOWEST'); $row->prio = 5; break;
			}

			array_push($items,$row);
		}

		$sql = $GLOBALS['AVE_DB']->Query("SELECT *
			FROM " . PREFIX . "_modul_roadmap
			WHERE id = '" . $id . "'
		");
		$row_r = $sql->FetchRow();

		$GLOBALS['AVE_Template']->assign('row', $row_r);
		$GLOBALS['AVE_Template']->assign('items', $items);
		$tpl_out = $GLOBALS['AVE_Template']->fetch($tpl_dir.'tasks.tpl');
		define('MODULE_CONTENT', $tpl_out);
	}
}
?>