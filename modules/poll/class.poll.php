<?php

class poll
{

/**
 *	СВОЙСТВА
 */

	var $_adminlimit = 15;
	var $_limit = 5;
	var $_commentwords = 1000;
	var $_anti_spam = 1;

/**
 *	ВНЕШНИЕ МЕТОДЫ
 */

	/**
	 * Отображение опроса (вывод тэгами)
	 *
	 * @param string $tpl_dir - путь к папке с шаблонами модуля
	 * @param string $lang_file - путь к языковому файлу модуля
	 * @param int $id - идентификатор опроса
	 */
	function showPoll($tpl_dir, $lang_file, $id)
	{
		global $AVE_DB, $AVE_Template;

		if (isset($_REQUEST['module']) && $_REQUEST['module'] == 'poll') return;

		$AVE_Template->config_load($lang_file, 'showpoll');

		$sql = $AVE_DB->Query("
			SELECT
				poll.*,
				SUM(itm.hits) AS sumhits
			FROM
				" . PREFIX . "_modul_poll AS poll
			LEFT JOIN
				" . PREFIX . "_modul_poll_items AS itm
					ON pollid = poll.id
			WHERE
				active = '1' AND
				poll.title != '' AND
				poll.id = '" . $id . "' AND
				`start` < '" . time() . "'
			GROUP BY poll.id
		");
		$row = $sql->FetchRow();

		if (!$row) return;

		$uid = ($row->uid == '') ? '' : explode(',', $row->uid);
		$ip_a = ($row->ip == '') ? '' : explode(',', $row->ip);
		$group_id = ($row->group_id == '') ? '' : explode(',', $row->group_id);
		$ip = empty($_SERVER['REMOTE_ADDR']) ? '' : $_SERVER['REMOTE_ADDR'];

		if (@in_array($ip, $ip_a) ||
			@in_array($_SESSION['user_id'], $uid) ||
			$_COOKIE['poll_' . $id] == '1')
		{
				$row->message = $AVE_Template->get_config_vars('POLL_ALREADY_POLL');
		}
		elseif (!(@in_array(UGROUP, $group_id)))
		{
			$row->message = $AVE_Template->get_config_vars('POLL_NO_PERMISSION');
		}
		elseif ($row->ende < time())
		{
			$row->message = $AVE_Template->get_config_vars('POLL_EXPIRED');
		}

		$items = array();
		$sql = $AVE_DB->Query("
			SELECT
				*,
				" . ($row->sumhits > 0 ? 'ROUND(hits*100/' . $row->sumhits . ')' : 0) . " AS sum
			FROM " . PREFIX . "_modul_poll_items
			WHERE pollid = '" . $id . "'
			ORDER BY posi ASC
		");
		while ($row_items = $sql->FetchRow())
		{
			array_push($items, $row_items);
		}

		$AVE_Template->assign('formaction', 'index.php?module=poll&amp;action=vote&amp;pid=' . $id);
		$AVE_Template->assign('formaction_result', $this->_PL_Rewrite('index.php?module=poll&amp;action=result&amp;pid=' . $id));
		$AVE_Template->assign('formaction_archive', $this->_PL_Rewrite('index.php?module=poll&amp;action=archive'));

		$AVE_Template->assign('poll', $row);
		$AVE_Template->assign('items', $items);

		if (isset($row->message))
		{
			$AVE_Template->display($tpl_dir . 'poll_nav_result.tpl');
		}
		else
		{
			$AVE_Template->display($tpl_dir . 'poll_nav.tpl');
		}
	}

	/**
	 * Учет результатов опроса
	 *
	 * @param int $pid - идентификатор опроса
	 */
	function vote($pid)
	{
		global $AVE_DB;

		$sql = $AVE_DB->Query("
			SELECT *
			FROM " . PREFIX . "_modul_poll
			WHERE id = '" . $pid . "'
		");
		$row = $sql->FetchRow();

		$uid  = ($row->uid == '') ? $row->uid : explode(',', $row->uid);
		$ip_a = ($row->ip == '')  ? $row->ip  : explode(',', $row->ip);
		$group_id = ($row->group_id == '') ? $row->group_id : explode(',', $row->group_id);
		$ip = empty($_SERVER['REMOTE_ADDR']) ? '' : $_SERVER['REMOTE_ADDR'];

		$back = $this->_PL_Rewrite('index.php?module=poll&amp;action=result&amp;pid=' . $pid);

		if (@in_array($ip, $ip_a) ||
			@in_array($_SESSION['user_id'], $uid) ||
			$_COOKIE['poll_' . $pid] == '1')
		{
			header('Location:' . $back);
			return;
		}

		if (!(@in_array(UGROUP, $group_id)))
		{
			header('Location:' . $back);
			return;
		}

		setcookie('poll_' . $pid, '1', time() + 3600 * 3600);

		$AVE_DB->Query("
			UPDATE " . PREFIX . "_modul_poll_items
			SET hits = hits + 1
			WHERE id = '" . (int)$_POST['p_item'] . "'
		");

		$AVE_DB->Query("
			UPDATE " . PREFIX . "_modul_poll
			SET
				ip = CONCAT_WS(',', ip, '" . $ip . "')
				" . ((UGROUP!='2') ? ", uid = CONCAT_WS(',', uid, '" . $_SESSION['user_id'] . "')" : '') . "
			WHERE
				id = '" . $pid . "'
		");

		header('Location:' . $back);
	}

	/**
	 * Подробная информация и статистика опроса, комментарии пользователей
	 *
	 * @param string $tpl_dir - путь к папке с шаблонами модуля
	 * @param string $lang_file - путь к языковому файлу модуля
	 * @param int $pid - идентификатор опроса
	 */
	function showResult($tpl_dir, $lang_file, $pid)
	{
		global $AVE_DB, $AVE_Template;

		$AVE_Template->config_load($lang_file, 'showresult');

		$sql = $AVE_DB->Query("
			SELECT
				poll.*,
				SUM(itm.hits) AS votes
			FROM
				" . PREFIX . "_modul_poll AS poll
			LEFT JOIN
				" . PREFIX . "_modul_poll_items AS itm
					ON pollid = poll.id
			WHERE
				active = '1' AND
				poll.title != '' AND
				poll.id = '" . $pid . "' AND
				`start` < '" . time() . "'
			GROUP BY poll.id
		");
		$row = $sql->FetchRow();

		if (!$row) return;

		$items = array();
		$sql = $AVE_DB->Query("
			SELECT
				*,
				" . ($row->votes > 0 ? 'ROUND(hits*100/' . $row->votes . ')' : 0) . " AS sum
			FROM " . PREFIX . "_modul_poll_items
			WHERE pollid = '" . $pid . "'
			ORDER BY posi ASC
		");
		while ($row_items = $sql->FetchRow())
		{
			array_push($items, $row_items);
		}

		if ($row->can_comment == '1')
		{
			$comments = array();
			$sql = $AVE_DB->Query("
				SELECT
					cmnt.*,
					IFNULL(Vorname, '') AS firstname,
					IFNULL(Nachname, '" . $AVE_Template->get_config_vars('POLL_GUEST') . "') AS lastname
				FROM
					" . PREFIX . "_modul_poll_comments AS cmnt
				LEFT JOIN
					" . PREFIX . "_users AS usr
						ON usr.Id = cmnt.author
				WHERE pollid = '" . $pid . "'
				ORDER BY ctime DESC
			");
			while ($row_comments = $sql->FetchRow())
			{
				array_push($comments, $row_comments);
			}
			$AVE_Template->assign('count_comments', $sql->NumRows());
		}

		$ip_a = ($row->ip == '') ? '' : explode(',', $row->ip);
		$uid = ($row->uid == '') ? '' : explode(',', $row->uid);
		$ip = empty($_SERVER['REMOTE_ADDR']) ? '' : $_SERVER['REMOTE_ADDR'];

		if (@in_array($ip, $ip_a) ||
			@in_array($_SESSION['user_id'], $uid) ||
			(isset($_COOKIE['poll_' . $pid]) && $_COOKIE['poll_' . $pid] == '1'))
		{
			$vote = 1;
		}

		$groups = array();
		if ($row->group_id != '')
		{
			$sql = $AVE_DB->Query("
				SELECT
					Benutzergruppe,
					Name
				FROM
					" . PREFIX . "_user_groups
				WHERE
					Benutzergruppe IN(" . $row->group_id . ")
			");
			while ($row_g = $sql->FetchRow())
			{
				if (UGROUP == $row_g->Benutzergruppe) $rights = 1;
				array_push($groups, $row_g->Name);
			}
		}
		$row->can_vote = (empty($vote) && !empty($rights)) ? '1' : '0';
		$row->groups = implode(', ', $groups);

		$AVE_Template->assign('formaction', 'index.php?module=poll&amp;action=vote&amp;pid=' . $pid);
		$AVE_Template->assign('formaction_result', $this->_PL_Rewrite('index.php?module=poll&amp;action=result&amp;pid=' . $pid));
		$AVE_Template->assign('formaction_archive', $this->_PL_Rewrite('index.php?module=poll&amp;action=archive'));
		$AVE_Template->assign('formaction_comment', $this->_PL_Rewrite('index.php?module=poll&amp;action=form&amp;pid=' . $pid . '&amp;theme_folder=' . THEME_FOLDER . '&amp;pop=1'));

		$AVE_Template->assign('poll', $row);
		$AVE_Template->assign('items', $items);
		$AVE_Template->assign('comments', $comments);

		define('MODULE_SITE', $AVE_Template->get_config_vars('POLL_PAGE_TITLE_PREFIX') . $row->title);
		define('MODULE_CONTENT', $AVE_Template->fetch($tpl_dir . 'result.tpl'));
	}

	/**
	 * Список завершенных и действующих опросов
	 *
	 * @param string $tpl_dir - путь к папке с шаблонами модуля
	 * @param string $lang_file - путь к языковому файлу модуля
	 */
	function showArchive($tpl_dir, $lang_file)
	{
		global $AVE_DB, $AVE_Template;

		if (!empty($_REQUEST['order']))
		{
			$order = $_REQUEST['order'];
		}
		else
		{
			$order = 'title';
		}

		if (isset($_REQUEST['by']) && $_REQUEST['by'] == 'desc')
		{
			$by = ' DESC';
		}
		else
		{
			$by = ' ASC';
		}

		$items = array();
		$sql = $AVE_DB->Query("
			SELECT
				poll.id,
				poll.title,
				poll.`start`,
				poll.ende,
				SUM(itm.hits) AS votes
			FROM
				" . PREFIX . "_modul_poll AS poll
			LEFT JOIN
				" . PREFIX . "_modul_poll_items AS itm
					ON pollid = poll.id
			WHERE
				active = '1' AND
				poll.title != '' AND
				`start` < '" . time() . "'
			GROUP BY poll.id
			ORDER BY " . $order . $by
		);
		while ($row = $sql->FetchRow())
		{
			$row->plink = $this->_PL_Rewrite('index.php?module=poll&amp;action=result&amp;pid=' . $row->id);
			array_push($items, $row);
		}

		$AVE_Template->assign('items', $items);
		$AVE_Template->config_load($lang_file, 'showarchive');

		define('MODULE_SITE', $AVE_Template->get_config_vars('POLL_ARCHIVE_TITLE'));

		$tpl_out = $AVE_Template->fetch($tpl_dir . 'archive.tpl');
		define('MODULE_CONTENT', $tpl_out);
	}

	function displayForm($tpl_dir, $lang_file, $pid, $theme, $errors='', $text='', $title='')
	{
		global $AVE_DB, $AVE_Template;

		$AVE_Template->config_load($lang_file, 'displayform');

		$sql = $AVE_DB->Query("
			SELECT *
			FROM " . PREFIX . "_modul_poll
			WHERE id = '" . $pid . "'
			LIMIT 1
		");
		$row = $sql->FetchRow();
		$groups = explode(',', $row->group_id);

		if ($row->active == 1 && $row->can_comment == 1 && in_array(UGROUP, $groups))
		{
			$AVE_Template->assign('cancomment', 1);
		}
		$AVE_Template->assign('max_chars', $this->_commentwords);

		$im = '';

		if (function_exists('imagettftext') && function_exists('imagejpeg') && $this->_anti_spam == 1)
		{
			$codeid = $this->_secureCode();
			$im = $codeid;
			$sql = $AVE_DB->Query("
				SELECT Code
				FROM " . PREFIX . "_antispam
				WHERE id = '" . $codeid . "'
			");
			$row_sc = $sql->FetchRow();
			$AVE_Template->assign('im', $im);
			$_SESSION['cpSecurecode'] = $row_sc->Code;
			$_SESSION['cpSecurecode_id'] = $codeid;
			$AVE_Template->assign('anti_spam', 1);
		}

		if (!empty($errors)) $AVE_Template->assign('errors', $errors);

		$AVE_Template->assign('theme_folder', $theme);
		$AVE_Template->assign('title', $title);
		$AVE_Template->assign('text', $text);
		$AVE_Template->display($tpl_dir . 'poll_form.tpl');
	}

	function sendForm($tpl_dir, $lang_file, $pid)
	{
		global $AVE_DB, $AVE_Template;

		$sql = $AVE_DB->Query("
			SELECT *
			FROM " . PREFIX . "_modul_poll
			WHERE id = '" . $pid . "'
			AND active = 1
			AND can_comment = 1
		");
		$row = $sql->FetchRow();
		$groups = explode(',', $row->group_id);

		$text = substr(htmlspecialchars($_POST['comment_text']), 0, $this->_commentwords);
		$text_length = strlen($text);
		$text .= ($text_length > $this->_commentwords) ? '...' : '';
		$text = pretty_chars($text);

		$errors = array();
		if (empty($_POST['comment_title'])) $error[] = $AVE_Template->get_config_vars('POLL_ENTER_TITLE');
		if (empty($text)) $error[] = $AVE_Template->get_config_vars('POLL_ENTER_TEXT');

		if ($this->_anti_spam == 1)
		{
			if (isset($_POST['comment_code']) && $_POST['comment_code'] == $_SESSION['cpSecurecode'])
			{
//				$sql = $AVE_DB->Query("
//					SELECT id
//					FROM " . PREFIX . "_antispam
//					WHERE Code = '" . addslashes($_POST['cpSecurecode']) . "'
//				");
//				$row_sc = $sql->FetchRow();
//				$im = $row_sc->id;
			}
			else
			{
				$errors[] = $AVE_Template->get_config_vars('POLL_ENTER_CODE');
			}
		}

		if (count($errors)>0)
		{
			$this->displayForm($tpl_dir, $lang_file, $pid, THEME_FOLDER, $errors, $text, $_POST['comment_title']);
			exit();
		}

		if (isset($_SESSION['user_id']))
		{
			$author = $_SESSION['user_id'];
		}
		else
		{
			$author = '0';
		}

		if ($row->active == 1 && in_array(UGROUP, $groups) && $text_length > 3)
		{
			$ip = empty($_SERVER['REMOTE_ADDR']) ? '' : $_SERVER['REMOTE_ADDR'];

			$AVE_DB->Query("
				INSERT " . PREFIX . "_modul_poll_comments
				SET
					pollid  = '" . $pid . "',
					ctime   = '" . time() . "',
					author  = '" . $author . "',
					title   = '" . $_POST['comment_title'] . "',
					comment = '" . $text . "',
					ip      = '" . $ip . "'
			");
		}
		echo '<script>window.opener.location.reload(); window.close();</script>';
	}

	function showPolls($tpl_dir, $lang_file)
	{
		global $AVE_DB, $AVE_Template;

		$AVE_Template->config_load($lang_file, 'showpolls');
		$AVE_Template->assign('config_vars', $AVE_Template->get_config_vars());

		$sql = $AVE_DB->Query("SELECT id FROM " . PREFIX . "_modul_poll");
		$num = $sql->NumRows();
//		$sql->Close();

		$limit = $this->_adminlimit;
		$pages = ceil($num / $limit);
		$start = get_current_page() * $limit - $limit;

		$items = array();
		$sql = $AVE_DB->Query("
			SELECT *
			FROM " . PREFIX . "_modul_poll
			LIMIT " . $start . "," . $limit
		);
		while ($row = $sql->FetchRow())
		{
			$id = $row->id;
			$sql_hits = $AVE_DB->Query("
				SELECT SUM(hits) AS sumhits
				FROM " . PREFIX . "_modul_poll_items
				WHERE pollid = '" . $id . "'
				GROUP BY pollid
			");
			$row_hits = $sql_hits->FetchRow();
			if ($row_hits === false)
			{
				$row->sum_hits = 0;
			}
			else
			{
				$row->sum_hits = floor($row_hits->sumhits);
			}

			$sql_c = $AVE_DB->Query("
				SELECT id
				FROM " . PREFIX . "_modul_poll_comments
				WHERE pollid = '" . $id . "'
			");
			$row->comments = $sql_c->NumRows();
			array_push($items, $row);
		}

		if ($num > $limit)
		{
			$page_nav = " <a class=\"pnav\" href=\"index.php?do=modules&action=modedit&mod=poll&moduleaction=1&cp=" . SESSION . "&page={s}\">{t}</a> ";
			$page_nav = get_pagination($pages, 'page', $page_nav);
			$AVE_Template->assign('page_nav', $page_nav);
		}
		$AVE_Template->assign('items', $items);
		$AVE_Template->assign('content', $AVE_Template->fetch($tpl_dir . 'admin_forms.tpl'));
	}

	function editPolls($tpl_dir, $lang_file, $id)
	{
		global $AVE_DB, $AVE_Template;

		$AVE_Template->config_load($lang_file, 'editpolls');
		$AVE_Template->assign('config_vars', $AVE_Template->get_config_vars());

		$items = array();
		$sql = $AVE_DB->Query("
			SELECT *
			FROM " . PREFIX . "_modul_poll_items
			WHERE pollid = '" . $id . "'
			ORDER BY posi ASC
		");
		while ($row = $sql->FetchRow())
		{
			array_push($items, $row);
		}

		$groups = array();
		$sql = $AVE_DB->Query("
			SELECT
				Benutzergruppe,
				Name
			FROM " . PREFIX . "_user_groups
		");
		while ($row = $sql->FetchRow())
		{
			array_push($groups, $row);
		}

		$sql = $AVE_DB->Query("
			SELECT *
			FROM " . PREFIX . "_modul_poll
			WHERE id = '" . $id . "'
		");
		$row = $sql->FetchRow();

		$AVE_Template->assign('groups', $groups);
		$AVE_Template->assign('groups_form', explode(',', $row->group_id));
		$AVE_Template->assign('row', $row);
		$AVE_Template->assign('items', $items);
		$AVE_Template->assign('tpl_dir', $tpl_dir);
		$AVE_Template->assign('year', date('Y'));

		$AVE_Template->assign('s_year', date('Y', $row->start));
		$AVE_Template->assign('s_mon', date('m', $row->start));
		$AVE_Template->assign('s_day', date('d', $row->start));
		$AVE_Template->assign('s_hour', date('H', $row->start));
		$AVE_Template->assign('s_min', date('i', $row->start));

		$AVE_Template->assign('e_year', date('Y', $row->ende));
		$AVE_Template->assign('e_mon', date('m', $row->ende));
		$AVE_Template->assign('e_day', date('d', $row->ende));
		$AVE_Template->assign('e_hour', date('H', $row->ende));
		$AVE_Template->assign('e_min', date('i', $row->ende));

		$AVE_Template->assign('formaction', 'index.php?do=modules&action=modedit&mod=poll&moduleaction=save&cp=' . SESSION . '&id=' . $id . '&pop=1');
		$AVE_Template->assign('content', $AVE_Template->fetch($tpl_dir . 'admin_fields.tpl'));
	}

	function savePolls($id)
	{
		global $AVE_DB;

		$qid = $id;
		$start_date = mktime($_REQUEST['s_hour'], $_REQUEST['s_min'], 0, $_REQUEST['s_mon'], $_REQUEST['s_day'], $_REQUEST['s_year']);
		$end_date   = mktime($_REQUEST['e_hour'], $_REQUEST['e_min'], 0, $_REQUEST['e_mon'], $_REQUEST['e_day'], $_REQUEST['e_year']);

		$AVE_DB->Query("
			UPDATE " . PREFIX . "_modul_poll
			SET
				title       = '" . $_REQUEST['poll_name'] . "',
				active      = '" . $_REQUEST['active'] . "',
				can_comment = '" . $_REQUEST['can_comment'] . "',
				`start`     = '" . $start_date . "',
				ende        = '" . $end_date . "',
				group_id    = '" . @implode(',', $_REQUEST['groups']) . "'
			WHERE
				id          = '" . $qid . "'
		");

		if (!empty($_POST['del']))
		{
			foreach ($_POST['del'] as $id => $field)
			{
				$AVE_DB->Query("
					DELETE
					FROM " . PREFIX . "_modul_poll_items
					WHERE id = '" . $id . "'
				");
			}
		}

		foreach ($_POST['question_title'] as $id => $field)
		{
			if (!empty($field))
			{
				$AVE_DB->Query("
					UPDATE " . PREFIX . "_modul_poll_items
					SET
						title = '" . $field . "',
						hits  = '" . $_POST['hits'][$id] . "',
						color = '" . $_POST['line_color'][$id] . "',
						posi  = '" . $_POST['position'][$id] . "'
					WHERE
						id    = '" . $id . "'
				");
			}
		}
		header('Location:index.php?do=modules&action=modedit&mod=poll&moduleaction=edit&id=' . $qid . '&pop=1&cp=' . SESSION);
	}

	function saveFieldsNew($id)
	{
		global $AVE_DB;

		if (!empty($_POST['question_title']))
		{
			$AVE_DB->Query("
				INSERT
				INTO " . PREFIX . "_modul_poll_items
				VALUES (
					'',
					'" . $id . "',
					'" . $_REQUEST['question_title'] . "',
					'" . $_REQUEST['hits'] . "',
					'" . $_REQUEST['line_color'] . "',
					'" . $_REQUEST['position'] . "'
				)
			");
		}
		reportLog($_SESSION['user_name'] . ' - добавил новый вопрос для опроса (' . ($_REQUEST['question_title']) . ')', 2, 2);
		header('Location:index.php?do=modules&action=modedit&mod=poll&moduleaction=edit&id=' . $id . '&pop=1&cp=' . SESSION);
	}

	function newPolls($tpl_dir, $lang_file)
	{
		global $AVE_DB, $AVE_Template;

		$AVE_Template->config_load($lang_file, 'newpolls');
		$AVE_Template->assign('config_vars', $AVE_Template->get_config_vars());

		switch ($_REQUEST['sub'])
		{
			case '':
				$groups = array();
				$sql = $AVE_DB->Query("
					SELECT
						Benutzergruppe,
						Name
					FROM " . PREFIX . "_user_groups
				");
				while ($row = $sql->FetchRow())
				{
					array_push($groups, $row);
				}

				$AVE_Template->assign('groups', $groups);
				$AVE_Template->assign('year', date('Y'));
				$AVE_Template->assign('mon', date('m'));
				$AVE_Template->assign('day', date('d'));
				$AVE_Template->assign('hour', date('H'));
				$AVE_Template->assign('min', date('i'));
				$AVE_Template->assign('tpl_dir', $tpl_dir);
				$AVE_Template->assign('formaction', 'index.php?do=modules&action=modedit&mod=poll&moduleaction=new&sub=save&cp=' . SESSION . '&pop=1');
				$AVE_Template->assign('content', $AVE_Template->fetch($tpl_dir . 'admin_fields.tpl'));
				break;

			case 'save':
				$start_date = mktime($_REQUEST['s_hour'], $_REQUEST['s_min'], 0, $_REQUEST['s_mon'], $_REQUEST['s_day'], $_REQUEST['s_year']);
				$end_date = mktime($_REQUEST['e_hour'], $_REQUEST['e_min'], 0, $_REQUEST['e_mon'], $_REQUEST['e_day'], $_REQUEST['e_year']);

				$AVE_DB->Query("
					INSERT
					INTO " . PREFIX . "_modul_poll
					VALUES (
						'',
						'" . $_REQUEST['poll_name'] . "',
						'" . $_REQUEST['active'] . "',
						'" . @implode(',', $_REQUEST['groups']) . "',
						0,
						0,
						'" . $_REQUEST['can_comment'] . "',
						'" . $start_date . "',
						'" . $end_date . "'
					)
				");
				$iid = $AVE_DB->InsertId();
				reportLog($_SESSION['user_name'] . ' - добавил новый опрос (' . stripslashes($_REQUEST['poll_name']) . ')', 2, 2);

				header('Location:index.php?do=modules&action=modedit&mod=poll&moduleaction=edit&id=' . $iid . '&pop=1&cp=' . SESSION);
				exit;
				break;
		}
	}

	function deletePolls($id)
	{
		global $AVE_DB;

		$AVE_DB->Query("
			DELETE
			FROM " . PREFIX . "_modul_poll
			WHERE id = '" . $id . "'
		");
		$AVE_DB->Query("
			DELETE
			FROM " . PREFIX . "_modul_poll_items
			WHERE pollid = '" . $id . "'
		");
		$AVE_DB->Query("
			DELETE
			FROM " . PREFIX . "_modul_poll_comments
			WHERE pollid = '" . $id . "'
		");

		reportLog($_SESSION['user_name'] . ' - удалил опрос (' . $id . ')', 2, 2);

		header('Location:index.php?do=modules&action=modedit&mod=poll&moduleaction=1&cp=' . SESSION);
		exit;
	}

	function showComments($tpl_dir, $lang_file, $id)
	{
		global $AVE_DB, $AVE_Template;

		$AVE_Template->config_load($lang_file, 'showcomments');
		$config_vars = $AVE_Template->get_config_vars();
		$AVE_Template->assign('config_vars', $config_vars);

		$qid = $id;
		switch ($_REQUEST['sub'])
		{
			case '':
				$items = array();
				$sql = $AVE_DB->Query("
					SELECT *
					FROM " . PREFIX . "_modul_poll_comments
					WHERE pollid = '" . $qid . "'
				");
				while ($row = $sql->FetchRow())
				{
					if ($row->author != '0')
					{
						$sql_u = $AVE_DB->Query("
							SELECT
								Vorname,
								Nachname
							FROM " . PREFIX . "_users
							WHERE Id = '" . $row->author . "'
						");
						$row_u = $sql_u->FetchRow();
						$row->firstname = $row_u->Vorname;
						$row->lastname  = $row_u->Nachname;
					}
					else
					{
						$row->firstname = $config_vars('POLL_UNKNOWN_USER');
						$row->lastname  = '';
					}
					array_push($items, $row);
				}
				$AVE_Template->assign('items', $items);
				$AVE_Template->assign('tpl_dir', $tpl_dir);
				$AVE_Template->assign('content', $AVE_Template->fetch($tpl_dir . 'admin_comments.tpl'));
				break;

			case 'save':
				if (!empty($_POST['del']))
				{
					foreach ($_POST['del'] as $id => $comment)
					{
						$AVE_DB->Query("
							DELETE
							FROM " . PREFIX . "_modul_poll_comments
							WHERE id = '" . $id . "'
						");
					}
				}

				foreach ($_POST['comment_text'] as $id => $comment)
				{
					if (!empty($comment))
					{
						$AVE_DB->Query("
							UPDATE " . PREFIX . "_modul_poll_comments
							SET
								title   = '" . $_POST['comment_title'][$id] . "',
								comment = '" . $comment . "'
							WHERE
								id      = '" . $id . "'
						");
					}
				}
				header('Location:index.php?do=modules&action=modedit&mod=poll&moduleaction=comments&id=' . $qid . '&pop=1&cp=' . SESSION);
				break;
		}
	}

/**
 *	ВНУТРЕННИЕ МЕТОДЫ
 */

	function _PL_Rewrite($string)
	{
		if (REWRITE_MODE) $string = PollRewrite($string);

		return $string;
	}

	function _secureCode($c = 0)
	{
		global $AVE_DB;

		$AVE_DB->Query("
			DELETE
			FROM " . PREFIX . "_antispam
			WHERE Ctime < " . time() - 1200 . "
		");
		$code = '';
		$chars = array(
			'A','B','C','D','E','F','G','H','J','K','M','N','P','Q','R','S','T','U','V','W','X','Y','Z',
			'a','b','c','d','e','f','g','h','j','k','m','n','p','q','r','s','t','u','v','w','x','y','z',
			'2','3','4','5','6','7','8','9'
		);
		$ch = ($c!=0) ? $c : 7;
		$count = count($chars) - 1;
		srand((double)microtime() * 1000000);
		for ($i=0; $i<$ch; $i++)
		{
			$code .= $chars[rand(0, $count)];
		}
		$AVE_DB->Query("
			INSERT
			INTO " . PREFIX . "_antispam
			SET
				id    = '',
				Code  = '" . $code . "',
				Ctime = '" . time() . "'
		");

		return $AVE_DB->InsertId();
	}
}

?>