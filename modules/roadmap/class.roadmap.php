<?php

class Roadmap
{

	var $_limit = 15;

	/**
	 * Административная часть (проекты)
	 */

	function roadmapProjectList($tpl_dir)
	{
		global $AVE_DB, $AVE_Template;

		$limit = $this->_limit;
		$num = $AVE_DB->Query("SELECT COUNT(*) FROM " . PREFIX . "_modul_roadmap")->GetCell();

		$pages = ceil($num / $limit);
		$start = get_current_page() * $limit - $limit;

		$items = array();
		$sql = $AVE_DB->Query("
			SELECT *
			FROM " . PREFIX . "_modul_roadmap
			ORDER BY position
			LIMIT " . $start . "," . $limit
		);
		while ($row = $sql->FetchRow())
		{
			$row->open_tasks = $AVE_DB->Query("
				SELECT COUNT(*)
				FROM " . PREFIX . "_modul_roadmap_tasks
				WHERE pid = '" . $row->id . "'
				AND task_status = 0
			")->GetCell();

			$row->closed_tasks = $AVE_DB->Query("
				SELECT COUNT(*)
				FROM " . PREFIX . "_modul_roadmap_tasks
				WHERE pid = '" . $row->id . "'
				AND task_status = 1
			")->GetCell();

			array_push($items, $row);
		}

		if ($num > $limit)
		{
			$page_nav = " <a class=\"pnav\" href=\"index.php?do=modules&action=modedit&mod=roadmap&moduleaction=1&cp=" . SESSION . "&page={s}\">{t}</a> ";
			$page_nav = get_pagination($pages, 'page', $page_nav);
			$AVE_Template->assign('page_nav', $page_nav);
		}

		$AVE_Template->assign('items', $items);
		$AVE_Template->assign('content', $AVE_Template->fetch($tpl_dir . 'admin_projects.tpl'));
	}

	function roadmapProjectNew($tpl_dir)
	{
		global $AVE_DB, $AVE_Template;

		switch ($_REQUEST['sub'])
		{
			case '':
				$AVE_Template->assign('formaction', 'index.php?do=modules&action=modedit&mod=roadmap&moduleaction=new_project&sub=save&cp=' . SESSION . '&pop=1');
				$AVE_Template->assign('content', $AVE_Template->fetch($tpl_dir . 'admin_project_form.tpl'));
				break;

			case 'save':
				$AVE_DB->Query("
					INSERT
					INTO " . PREFIX . "_modul_roadmap
					SET
						id             = '',
						project_name   = '" . $_REQUEST['project_name'] . "',
						project_desc   = '" . $_REQUEST['project_desc'] . "',
						project_status = '" . $_REQUEST['project_status'] . "',
						position       = '" . $_REQUEST['position'] . "'
				");
				$project_id = $AVE_DB->InsertId();

				reportLog($_SESSION['user_name'] . ' - добавил новый проект ' . $project_id, 2, 2);

				echo '<script>window.opener.location.reload(); self.close();</script>';
				break;
		}
	}

	function roadmapProjectEdit($tpl_dir, $project_id)
	{
		global $AVE_DB, $AVE_Template;

		$project_id = (int)$project_id;
		$subaction = isset($_REQUEST['sub']) ? $_REQUEST['sub'] : '';

		switch ($subaction)
		{
			case '':
				$AVE_Template->assign('formaction', 'index.php?do=modules&action=modedit&mod=roadmap&moduleaction=edit_project&id={$project_id}&sub=save&cp=' . SESSION . '&pop=1');

				$row = $AVE_DB->Query("
					SELECT *
					FROM " . PREFIX . "_modul_roadmap
					WHERE id = '" . $project_id . "'
				")->FetchRow();

				$AVE_Template->assign('item', $row);
				$AVE_Template->assign('content', $AVE_Template->fetch($tpl_dir . 'admin_project_form.tpl'));

				break;

			case 'save':
				$AVE_DB->Query("
					UPDATE " . PREFIX . "_modul_roadmap
					SET
						project_desc   = '" . $_REQUEST['project_desc']. "',
						project_name   = '" . $_REQUEST['project_name'] . "',
						position       = '" . $_REQUEST['position'] . "',
						project_status = '" . $_REQUEST['project_status'] . "'
					WHERE
						id = '" . $project_id . "'
				");

				reportLog($_SESSION['user_name'] . ' - отредактировал проект ' . $project_id, 2, 2);

				echo '<script>window.opener.location.reload(); self.close();</script>';
				break;
		}
	}

	function roadmapProjectDelete($project_id)
	{
		global $AVE_DB;

		$AVE_DB->Query("DELETE FROM " . PREFIX . "_modul_roadmap WHERE id = '" . $project_id . "'");

		reportLog($_SESSION['user_name'] . ' - удалил проект ' . $project_id, 2, 2);

		header('Location:index.php?do=modules&action=modedit&mod=roadmap&moduleaction=1&cp=' . SESSION);
		exit;
	}

	/**
	 * Административная часть (задачи)
	 */

	function roadmapTaskList($tpl_dir, $project_id, $status)
	{
		global $AVE_DB, $AVE_Template;

		$project_id = (int)$project_id;
		$status = (int)$status;

		$limit = $this->_limit;
		$num = $AVE_DB->Query("
			SELECT COUNT(*)
			FROM " . PREFIX . "_modul_roadmap_tasks
			WHERE pid = '" . $project_id . "'
			AND task_status = '" . $status . "'
		")->GetCell();

		$pages = ceil($num / $limit);
		$start = get_current_page() * $limit - $limit;

		$items = array();
		$sql = $AVE_DB->Query("
			SELECT *
			FROM " . PREFIX . "_modul_roadmap_tasks
			WHERE pid = '" . $project_id . "'
			AND task_status = '" . $status . "'
			ORDER BY priority
			LIMIT " . $start . "," . $limit
		);
		while ($row = $sql->FetchRow())
		{
			$row->username = get_username_by_id($row->uid);

			switch ($row->priority)
			{
				case'1': $row->priority = $AVE_Template->get_config_vars('ROADMAP_TASK_HIGHEST'); break;
				case'2': $row->priority = $AVE_Template->get_config_vars('ROADMAP_TASK_HIGH'); break;
				case'3': $row->priority = $AVE_Template->get_config_vars('ROADMAP_TASK_NORMAL'); break;
				case'4': $row->priority = $AVE_Template->get_config_vars('ROADMAP_TASK_LOW'); break;
				case'5': $row->priority = $AVE_Template->get_config_vars('ROADMAP_TASK_LOWEST'); break;
			}

			array_push($items, $row);
		}

		if ($num > $limit)
		{
			$page_nav = " <a class=\"pnav\" href=\"index.php?do=modules&action=modedit&mod=roadmap&moduleaction=show_tasks&closed={$status}&id={$project_id}&cp=" . SESSION . "&page={s}\">{t}</a> ";
			$page_nav = get_pagination($pages, 'page', $page_nav);
			$AVE_Template->assign('page_nav', $page_nav);
		}

		$AVE_Template->assign('items', $items);
		$AVE_Template->assign('content', $AVE_Template->fetch($tpl_dir . 'admin_tasks.tpl'));
	}

	function roadmapTaskNew($tpl_dir, $project_id)
	{
		global $AVE_DB, $AVE_Template;

		$project_id = (int)$project_id;

		switch ($_REQUEST['sub'])
		{
			case '':
				$AVE_Template->assign('formaction', 'index.php?do=modules&action=modedit&mod=roadmap&moduleaction=new_task&id={$project_id}&sub=save&cp=' . SESSION . '&pop=1');
				$AVE_Template->assign('content', $AVE_Template->fetch($tpl_dir . 'admin_task_form.tpl'));
				break;

			case 'save':
				$AVE_DB->Query("
					INSERT
					INTO " . PREFIX . "_modul_roadmap_tasks
					SET
						id          = '',
						pid         = '" . $project_id . "',
						task_desc   = '" . $_REQUEST['task_desc'] . "',
						date_create = '" . time() . "',
						task_status = '" . $_REQUEST['task_status'] . "',
						uid         = '" . $_SESSION['user_id'] . "',
						priority    = '" . $_REQUEST['priority'] . "'
				");

				reportLog($_SESSION['user_name'] . ' - добавил новую задачу', '2', '2');

				echo '<script>window.opener.location.reload(); self.close();</script>';
				break;
		}
	}

	function roadmapTaskEdit($tpl_dir, $task_id)
	{
		global $AVE_DB, $AVE_Template;

		$task_id = (int)$task_id;

		switch ($_REQUEST['sub'])
		{
			case '':
				$AVE_Template->assign('formaction', 'index.php?do=modules&action=modedit&mod=roadmap&moduleaction=edit_task&id={$task_id}&sub=save&cp=' . SESSION . '&pop=1');

				$row = $AVE_DB->Query("
					SELECT *
					FROM " . PREFIX . "_modul_roadmap_tasks
					WHERE id = '" . $task_id . "'
				")->FetchRow();

				$row->username = get_username_by_id($row->uid);

				$AVE_Template->assign('item', $row);

				$AVE_Template->assign('content', $AVE_Template->fetch($tpl_dir . 'admin_task_form.tpl'));
				break;

			case 'save':
				$AVE_DB->Query("
					UPDATE " . PREFIX . "_modul_roadmap_tasks
					SET
						task_desc   = '" . $_REQUEST['task_desc']. "',
						task_status = '" . $_REQUEST['task_status'] . "',
						uid         = '" . $_REQUEST['uid'] . "',
						date_create = '" . time() . "',
						priority    = '" . $_REQUEST['priority'] . "'
					WHERE
						Id = '" . $task_id . "'
				");

				reportLog($_SESSION['user_name'] . ' - отредактировал задачу ' . $task_id, 2, 2);

				echo '<script>window.opener.location.reload(); self.close();</script>';
				break;
		}
	}

	function roadmapTaskDelete($task_id, $project_id, $status)
	{
		global $AVE_DB;

		$task_id = (int)$task_id;
		$project_id = (int)$project_id;
		$status = (int)$status;

		$AVE_DB->Query("DELETE FROM " . PREFIX . "_modul_roadmap_tasks WHERE id = '" . $task_id . "'");

		reportLog($_SESSION['user_name'] . ' - удалил задачу ' . $task_id, 2, 2);

		header('Location:index.php?do=modules&action=modedit&mod=roadmap&moduleaction=show_tasks&id={$project_id}&closed={$status}&cp=' . SESSION);
		exit;
	}

	/**
	 * Публичная часть
	 */

	function roadmapProjectShow($tpl_dir)
	{
		global $AVE_DB, $AVE_Template;

		$items = array();
		$sql = $AVE_DB->Query("
			SELECT *
			FROM " . PREFIX . "_modul_roadmap
			ORDER BY position
		");
		while ($row = $sql->FetchRow())
		{
			$row_date = $AVE_DB->Query("
				SELECT *
				FROM " . PREFIX . "_modul_roadmap_tasks
				WHERE pid = '" . $row->id . "'
				ORDER BY date_create DESC
				LIMIT 1
			")->FetchRow();

			$row->date = $row_date->date_create;

			$all_count = $AVE_DB->Query("
				SELECT COUNT(*)
				FROM " . PREFIX . "_modul_roadmap_tasks
				WHERE pid = '" . $row->id . "'
			")->GetCell();

			$row->num_closed = $AVE_DB->Query("
				SELECT COUNT(*)
				FROM " . PREFIX . "_modul_roadmap_tasks
				WHERE pid = '" . $row->id . "'
				AND task_status = 1
			")->GetCell();

			$row->num_open = $all_count - $row->num_closed;

			if ($row->num_closed != 0)
			{
				$row->closed = round($row->num_closed * 100 / $all_count);
			}
			else
			{
				$row->closed = 0;
			}

			$row->open = round(100 - $row->closed);
			array_push($items,$row);
		}

		$AVE_Template->assign('items', $items);

		define('MODULE_CONTENT', $AVE_Template->fetch($tpl_dir.'projects.tpl'));
	}

	function roadmapTaskShow($tpl_dir, $project_id, $status)
	{
		global $AVE_DB, $AVE_Template;

		$project_id = (int)$project_id;
		$status = (int)$status;

		$items = array();
		$sql = $AVE_DB->Query("
			SELECT *
			FROM " . PREFIX . "_modul_roadmap_tasks
			WHERE pid = '" . $project_id . "'
			AND task_status = '" . $status . "'
			ORDER BY priority
		");
		while ($row = $sql->FetchRow())
		{
			$row->username = get_username_by_id($row->uid);

			switch ($row->priority)
			{
				case'1': $row->priority = $AVE_Template->get_config_vars('ROADMAP_TASK_HIGHEST'); $row->prio = 1; break;
				case'2': $row->priority = $AVE_Template->get_config_vars('ROADMAP_TASK_HIGH'); $row->prio = 2; break;
				case'3': $row->priority = $AVE_Template->get_config_vars('ROADMAP_TASK_NORMAL'); $row->prio = 3; break;
				case'4': $row->priority = $AVE_Template->get_config_vars('ROADMAP_TASK_LOW'); $row->prio = 4; break;
				case'5': $row->priority = $AVE_Template->get_config_vars('ROADMAP_TASK_LOWEST'); $row->prio = 5; break;
			}

			array_push($items, $row);
		}

		$row_r = $AVE_DB->Query("
			SELECT *
			FROM " . PREFIX . "_modul_roadmap
			WHERE id = '" . $project_id . "'
		")->FetchRow();

		$AVE_Template->assign('row', $row_r);
		$AVE_Template->assign('items', $items);

		define('MODULE_CONTENT', $AVE_Template->fetch($tpl_dir.'tasks.tpl'));
	}
}

?>