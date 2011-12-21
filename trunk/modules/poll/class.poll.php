<?php

class Poll
{

/**
 *	СВОЙСТВА
 */

	var $_adminlimit = 5;
	var $_limit = 5;
	var $_commentwords = 1000;
	var $_antispam = 0;

/**
 *	ВНУТРЕННИЕ МЕТОДЫ
 */

	function _pollLinkRewrite($string)
	{
		return (REWRITE_MODE) ? PollRewrite($string) : $string;
	}

/**
 *	ВНЕШНИЕ МЕТОДЫ
 */

	/**
	 * Методы публичной части
	 */

	/**
	 * Отображение опроса (вывод тэгами)
	 *
	 * @param string $tpl_dir	путь к папке с шаблонами модуля
	 * @param string $lang_file	путь к языковому файлу модуля
	 * @param int $pid			идентификатор опроса
	 */
	function pollShow($tpl_dir, $lang_file, $pid)
	{
		global $AVE_DB, $AVE_Template;

//		if (isset($_REQUEST['module']) && $_REQUEST['module'] == 'poll') return;

		$AVE_Template->config_load($lang_file, 'showpoll');

		$row = $AVE_DB->Query("
			SELECT
				poll.*,
				SUM(itm.poll_item_hits) AS sumhits
			FROM
				" . PREFIX . "_modul_poll AS poll
			LEFT JOIN
				" . PREFIX . "_modul_poll_items AS itm
					ON poll_id = poll.id
			WHERE
				poll.id = '" . $pid . "' AND
				poll.poll_title != '' AND
				poll.poll_status = '1' AND
				poll.poll_start < '" . time() . "'
			GROUP BY poll.id
		")->FetchRow();

		if (!$row) return;

		$poll_groups_id = empty($row->poll_groups_id) ? array() : explode(',', $row->poll_groups_id);
		$poll_users_id  = empty($row->poll_users_id)  ? array() : explode(',', $row->poll_users_id);
		$poll_users_ip  = empty($row->poll_users_ip)  ? array() : explode(',', $row->poll_users_ip);

		$current_user_ip = empty($_SERVER['REMOTE_ADDR']) ? '' : $_SERVER['REMOTE_ADDR'];

		if (@in_array($current_user_ip, $poll_users_ip) ||
			@in_array($_SESSION['user_id'], $poll_users_id) ||
			(isset($_COOKIE['poll_' . $pid]) && $_COOKIE['poll_' . $pid] == '1') )
		{
				$row->message = $AVE_Template->get_config_vars('POLL_ALREADY_POLL');
		}
		elseif (!(@in_array(UGROUP, $poll_groups_id)))
		{
			$row->message = $AVE_Template->get_config_vars('POLL_NO_PERMISSION');
		}
		elseif ($row->poll_end < time())
		{
			$row->message = $AVE_Template->get_config_vars('POLL_EXPIRED');
		}

		$items = array();
		$sql = $AVE_DB->Query("
			SELECT
				*,
				" . ($row->sumhits > 0 ? 'ROUND(poll_item_hits*100/' . $row->sumhits . ')' : 0) . " AS sum
			FROM " . PREFIX . "_modul_poll_items
			WHERE poll_id = '" . $pid . "'
			ORDER BY poll_item_position ASC
		");
		while ($row_items = $sql->FetchRow())
		{
			array_push($items, $row_items);
		}

		$AVE_Template->assign('formaction', 'index.php?module=poll&amp;action=vote&amp;pid=' . $pid);
		$AVE_Template->assign('formaction_result', $this->_pollLinkRewrite('index.php?module=poll&amp;action=result&amp;pid=' . $pid));
		$AVE_Template->assign('formaction_archive', $this->_pollLinkRewrite('index.php?module=poll&amp;action=archive'));

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
	 * @param int $pid	идентификатор опроса
	 */
	function pollVote($pid)
	{
		global $AVE_DB;

		$row = $AVE_DB->Query("
			SELECT *
			FROM " . PREFIX . "_modul_poll
			WHERE id = '" . $pid . "'
		")->FetchRow();

		$poll_groups_id = empty($row->poll_groups_id) ? array() : explode(',', $row->poll_groups_id);
		$poll_users_id  = empty($row->poll_users_id)  ? array() : explode(',', $row->poll_users_id);
		$poll_users_ip  = empty($row->poll_users_ip)  ? array() : explode(',', $row->poll_users_ip);

		$current_user_ip = empty($_SERVER['REMOTE_ADDR']) ? '' : $_SERVER['REMOTE_ADDR'];

		$back = $this->_pollLinkRewrite('index.php?module=poll&amp;action=result&amp;pid=' . $pid);

		if (!(@in_array(UGROUP, $poll_groups_id)))
		{
			header('Location:' . $back);
			exit;
		}

		if (@in_array($current_user_ip, $poll_users_ip) ||
			@in_array($_SESSION['user_id'], $poll_users_id) ||
			$_COOKIE['poll_' . $pid] == '1')
		{
			header('Location:' . $back);
			exit;
		}

		setcookie('poll_' . $pid, '1', time() + 3600 * 3600);

		$AVE_DB->Query("
			UPDATE " . PREFIX . "_modul_poll_items
			SET poll_item_hits = poll_item_hits + 1
			WHERE id = '" . (int)$_POST['p_item'] . "'
		");

		$AVE_DB->Query("
			UPDATE " . PREFIX . "_modul_poll
			SET
				poll_users_ip = CONCAT_WS(',', poll_users_ip, '" . $current_user_ip . "')
				" . ((UGROUP != 2) ? ", poll_users_id = CONCAT_WS(',', poll_users_id, '" . $_SESSION['user_id'] . "')" : '') . "
			WHERE
				id = '" . $pid . "'
		");

		header('Location:' . $back);
		exit;
	}

	/**
	 * Подробная информация и статистика опроса, комментарии пользователей
	 *
	 * @param string $tpl_dir	путь к папке с шаблонами модуля
	 * @param string $lang_file	путь к языковому файлу модуля
	 * @param int $pid			идентификатор опроса
	 */
	function pollResultShow($tpl_dir, $lang_file, $pid)
	{
		global $AVE_DB, $AVE_Template;

		$AVE_Template->config_load($lang_file, 'showresult');

		if (isset($_REQUEST['sub']) && $_REQUEST['sub'] == 'new')
		{
			$errors = $this->pollCommentNew($pid);

			if (sizeof($errors) == 0)
			{
				header('Location:' . $this->_pollLinkRewrite('index.php?module=poll&amp;action=result&amp;pid=' . $pid));
				exit;
			}

			$AVE_Template->assign('errors', $errors);
		}

		$poll = $AVE_DB->Query("
			SELECT
				poll.*,
				SUM(itm.poll_item_hits) AS votes
			FROM
				" . PREFIX . "_modul_poll AS poll
			LEFT JOIN
				" . PREFIX . "_modul_poll_items AS itm
					ON poll_id = poll.id
			WHERE
				poll.id = '" . $pid . "' AND
				poll.poll_title != '' AND
				poll.poll_status = '1' AND
				poll.poll_start < '" . time() . "'
			GROUP BY poll.id
		")->FetchRow();

		if ($poll === false) return;

		$items = array();
		$sql = $AVE_DB->Query("
			SELECT
				*,
				" . ($poll->votes > 0 ? 'ROUND(poll_item_hits*100/' . $poll->votes . ')' : 0) . " AS sum
			FROM " . PREFIX . "_modul_poll_items
			WHERE poll_id = '" . $pid . "'
			ORDER BY poll_item_position ASC
		");
		while ($row_items = $sql->FetchRow())
		{
			array_push($items, $row_items);
		}

		if ($poll->poll_can_comment == 1)
		{
			include_once(BASE_DIR . '/lib/markitup/sets/bbcode/markitup.bbcode-parser.php');

			$comments = array();
			$sql = $AVE_DB->Query("
				SELECT
					cmnt.*,
					IFNULL(firstname, '') AS firstname,
					IFNULL(lastname, '" . $AVE_Template->get_config_vars('POLL_GUEST') . "') AS lastname
				FROM
					" . PREFIX . "_modul_poll_comments AS cmnt
				LEFT JOIN
					" . PREFIX . "_users AS usr
						ON usr.Id = cmnt.poll_comment_author_id
				WHERE poll_id = '" . $pid . "'
				ORDER BY poll_comment_time DESC
			");
			while ($row_comments = $sql->FetchRow())
			{
				$row_comments->poll_comment_text = BBCode2Html($row_comments->poll_comment_text);

				array_push($comments, $row_comments);
			}

			$poll->count_comments = $sql->NumRows();
		}

		$poll_users_id = empty($poll->poll_users_id) ? array() : explode(',', $poll->poll_users_id);
		$poll_users_ip = empty($poll->poll_users_ip) ? array() : explode(',', $poll->poll_users_ip);

		$current_user_ip = empty($_SERVER['REMOTE_ADDR']) ? '' : $_SERVER['REMOTE_ADDR'];

		$is_vote = 1;
		if (@in_array($current_user_ip, $poll_users_ip) ||
			@in_array($_SESSION['user_id'], $poll_users_id) ||
			(isset($_COOKIE['poll_' . $pid]) && $_COOKIE['poll_' . $pid] == '1'))
		{
			$is_vote = 0;
		}

		$rights = 0;
		$groups = array();
		if ($poll->poll_groups_id != '')
		{
			$sql = $AVE_DB->Query("
				SELECT
					user_group,
					user_group_name
				FROM
					" . PREFIX . "_user_groups
				WHERE
					user_group IN(" . $poll->poll_groups_id . ")
			");
			while ($row_g = $sql->FetchRow())
			{
				if (UGROUP == $row_g->user_group) $rights = 1;
				array_push($groups, $row_g->user_group_name);
			}
		}

		$poll->can_vote = ($is_vote == 1 && $rights == 1) ? 1 : 0;
		$poll->groups = implode(', ', $groups);
		$poll->can_comment = ($poll->poll_status == 1 && $poll->poll_can_comment == 1 && $rights == 1) ? 1 : 0;
		$poll->anti_spam = ($this->_antispam == 1 && function_exists('imagettftext') && function_exists('imagejpeg')) ? 1 : 0;
		$poll->comment_max_chars = $this->_commentwords;
		$poll->items = $items;
		$poll->comments = $comments;
		$poll->formaction = 'index.php?module=poll&amp;action=vote&amp;pid=' . $pid;
		$poll->link_result = $this->_pollLinkRewrite('index.php?module=poll&amp;action=result&amp;pid=' . $pid);
//		$poll->link_archive = $this->_pollLinkRewrite('index.php?module=poll&amp;action=archive');
//		$poll->link_comment = $this->_pollLinkRewrite('index.php?module=poll&amp;action=form&amp;pop=1&amp;pid=' . $pid);

		$AVE_Template->assign('poll', $poll);

		define('MODULE_SITE', $AVE_Template->get_config_vars('POLL_PAGE_TITLE_PREFIX') . $poll->poll_title);
		define('MODULE_CONTENT', $AVE_Template->fetch($tpl_dir . 'result.tpl'));
	}

	/**
	 * Список завершенных и действующих опросов
	 *
	 * @param string $tpl_dir	путь к папке с шаблонами модуля
	 * @param string $lang_file	путь к языковому файлу модуля
	 */
	function pollArchiveShow($tpl_dir, $lang_file)
	{
		global $AVE_DB, $AVE_Template;

		if (empty($_REQUEST['order']))
		{
			$order = 'poll_title';
		}
		else
		{
			switch ($_REQUEST['order'])
			{
				case 'title':
					$order = 'poll_title';
					break;

				case 'start':
					$order = 'poll_start';
					break;

				case 'end':
					$order = 'poll_end';
					break;

				case 'votes':
					$order = 'votes';
					break;

				default:
					$order = 'poll_title';
					break;
			}
		}

		if (isset($_REQUEST['by']) && $_REQUEST['by'] == 'desc')
		{
			$order .= ' DESC';
		}
		else
		{
			$order .= ' ASC';
		}

		$items = array();
		$sql = $AVE_DB->Query("
			SELECT
				poll.id,
				poll.poll_title,
				poll.poll_start,
				poll.poll_end,
				SUM(itm.poll_item_hits) AS votes
			FROM
				" . PREFIX . "_modul_poll AS poll
			LEFT JOIN
				" . PREFIX . "_modul_poll_items AS itm
					ON poll_id = poll.id
			WHERE
				poll.poll_title != '' AND
				poll.poll_status = '1' AND
				poll.poll_start < '" . time() . "'
			GROUP BY poll.id
			ORDER BY " . $order
		);
		while ($row = $sql->FetchRow())
		{
			$row->plink = $this->_pollLinkRewrite('index.php?module=poll&amp;action=result&amp;pid=' . $row->id);
			array_push($items, $row);
		}

		$AVE_Template->assign('items', $items);
		$AVE_Template->config_load($lang_file, 'showarchive');

		define('MODULE_SITE', $AVE_Template->get_config_vars('POLL_ARCHIVE_TITLE'));
		define('MODULE_CONTENT', $AVE_Template->fetch($tpl_dir . 'archive.tpl'));
	}

	/**
	 * Метод отображения комментариев
	 *
	 * @param string $tpl_dir	путь к папке с шаблонами модуля
	 * @param string $lang_file	путь к языковому файлу модуля
	 * @param ini $pid			идентификатор опроса
	 * @param string $theme
	 * @param string $errors
	 * @param string $text
	 * @param string $title
	 */
	function pollCommentShow($tpl_dir, $lang_file, $pid, $theme, $errors='', $text='', $title='')
	{
		global $AVE_DB, $AVE_Template;

		$AVE_Template->config_load($lang_file, 'displayform');

		$row = $AVE_DB->Query("
			SELECT *
			FROM " . PREFIX . "_modul_poll
			WHERE id = '" . $pid . "'
			LIMIT 1
		")->FetchRow();
		$groups = explode(',', $row->poll_groups_id);

		if ($row->poll_status == 1 && $row->poll_can_comment == 1 && in_array(UGROUP, $groups))
		{
			$AVE_Template->assign('cancomment', 1);
		}
		$AVE_Template->assign('max_chars', $this->_commentwords);

		if ($this->_antispam == 1 && function_exists('imagettftext') && function_exists('imagejpeg'))
		{
			$AVE_Template->assign('anti_spam', 1);
		}

		if (!empty($errors)) $AVE_Template->assign('errors', $errors);

		$AVE_Template->assign('theme_folder', $theme);
		$AVE_Template->assign('title', $title);
		$AVE_Template->assign('text', $text);
		$AVE_Template->display($tpl_dir . 'poll_form.tpl');
	}

	/**
	 * Метод создания нового комментария
	 *
	 * @param string $tpl_dir	путь к папке с шаблонами модуля
	 * @param string $lang_file	путь к языковому файлу модуля
	 * @param int $pid			идентификатор опроса
	 */
	function pollCommentNew($pid)
	{
		global $AVE_DB, $AVE_Template;

		$errors = array();

		if (isset($_REQUEST['ajax']) && $_REQUEST['ajax'] == 1)
		{
			$comment_title = iconv('utf-8', 'cp1251', $_POST['comment_title']);
			$comment_text = iconv('utf-8', 'cp1251', $_POST['comment_text']);
		}
		else
		{
			$comment_title = $_POST['comment_title'];
			$comment_text = $_POST['comment_text'];
		}

		$text = (mb_strlen($comment_text) > $this->_commentwords)
			? mb_substr($comment_text, 0, $this->_commentwords) . '...'
			: $comment_text;

		if (mb_strlen($text) <= 10)   $errors[] = $AVE_Template->get_config_vars('POLL_ENTER_TEXT');
		if (empty($comment_title)) $errors[] = $AVE_Template->get_config_vars('POLL_ENTER_TITLE');

		if ($this->_antispam == 1)
		{
			if (! (isset($_SESSION['captcha_keystring']) && isset($_POST['securecode'])
				&& $_SESSION['captcha_keystring'] == $_POST['securecode']))
			{
				$errors[] = $AVE_Template->get_config_vars('POLL_ENTER_CODE');
			}

			unset($_SESSION['captcha_keystring']);
		}

		if (sizeof($errors) == 0)
		{
			$poll_groups_id = $AVE_DB->Query("
				SELECT poll_groups_id
				FROM " . PREFIX . "_modul_poll
				WHERE id = '" . $pid . "'
				AND poll_status = '1'
				AND poll_can_comment = '1'
			")->GetCell();

			if (!empty($poll_groups_id) && in_array(UGROUP, explode(',', $poll_groups_id)))
			{
				$author_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : 0;
				$author_ip = empty($_SERVER['REMOTE_ADDR']) ? '' : $_SERVER['REMOTE_ADDR'];

				$AVE_DB->Query("
					INSERT " . PREFIX . "_modul_poll_comments
					SET
						poll_id                = '" . $pid . "',
						poll_comment_time      = '" . time() . "',
						poll_comment_author_id = '" . $author_id . "',
						poll_comment_author_ip = '" . $author_ip . "',
						poll_comment_title     = '" . $comment_title . "',
						poll_comment_text      = '" . $text . "'
				");

				return $errors;
			}

			$errors[] = $AVE_Template->get_config_vars('POLL_ERROR_PERM');
		}

		return $errors;
	}

	/**
	 * Методы административной части
	 */

	/**
	 * Метод вывода списка опросов
	 *
	 * @param string $tpl_dir	путь к папке с шаблонами модуля
	 * @param string $lang_file	путь к языковому файлу модуля
	 */
	function pollList($tpl_dir, $lang_file)
	{
		global $AVE_DB, $AVE_Template;

		$AVE_Template->config_load($lang_file, 'showpolls');

		$num = $AVE_DB->Query("SELECT COUNT(*) FROM " . PREFIX . "_modul_poll")->GetCell();

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
			$row_hits = $AVE_DB->Query("
				SELECT SUM(poll_item_hits)
				FROM " . PREFIX . "_modul_poll_items
				WHERE poll_id = '" . $row->id . "'
				GROUP BY poll_id
			")->GetCell();

			$row->sum_hits = floor($row_hits);

			$row->comments = $AVE_DB->Query("
				SELECT COUNT(*)
				FROM " . PREFIX . "_modul_poll_comments
				WHERE poll_id = '" . $row->id . "'
			")->GetCell();

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

	/**
	 * Метод создания нового опроса
	 *
	 * @param string $tpl_dir	путь к папке с шаблонами модуля
	 * @param string $lang_file	путь к языковому файлу модуля
	 */
	function pollNew($tpl_dir, $lang_file)
	{
		global $AVE_DB, $AVE_Template;

		$AVE_Template->config_load($lang_file, 'newpolls');

		switch ($_REQUEST['sub'])
		{
			case '':
				$groups = array();
				$sql = $AVE_DB->Query("
					SELECT
						user_group AS id,
						user_group_name AS name
					FROM " . PREFIX . "_user_groups
				");
				while ($row = $sql->FetchRow())
				{
					$groups[$row->id] = $row->name;
				}

				$AVE_Template->assign('groups', $groups);
				$AVE_Template->assign('selected', array_keys($groups));
				$AVE_Template->assign('tpl_dir', $tpl_dir);
				$AVE_Template->assign('start', time());
				$AVE_Template->assign('end', time());
				$AVE_Template->assign('formaction', 'index.php?do=modules&action=modedit&mod=poll&moduleaction=new&sub=save&cp=' . SESSION . '&pop=1');
				$AVE_Template->assign('content', $AVE_Template->fetch($tpl_dir . 'admin_fields.tpl'));
				break;

			case 'save':
				$start_date = $this->_mktime('sd', 'st');
				$end_date = $this->_mktime('ed', 'et');

				$AVE_DB->Query("
					INSERT
					INTO " . PREFIX . "_modul_poll
					SET
						id               = '',
						poll_title       = '" . $_REQUEST['poll_name'] . "',
						poll_status      = '" . $_REQUEST['poll_status'] . "',
						poll_groups_id   = '" . @implode(',', $_REQUEST['groups']) . "',
						poll_users_id    = '0',
						poll_users_ip    = '0',
						poll_can_comment = '" . $_REQUEST['poll_can_comment'] . "',
						poll_start       = '" . $start_date . "',
						poll_end         = '" . $end_date . "'
				");
				$iid = $AVE_DB->InsertId();

				reportLog($_SESSION['user_name'] . ' - добавил новый опрос (' . stripslashes($_REQUEST['poll_name']) . ')', 2, 2);

				header('Location:index.php?do=modules&action=modedit&mod=poll&moduleaction=edit&id=' . $iid . '&pop=1&cp=' . SESSION);
				exit;
		}
	}

	/**
	 * Метод записи вариантов ответа нового опроса
	 *
	 * @param int $pid	идентификатор опроса
	 */
	function pollNewItemSave($pid)
	{
		global $AVE_DB;

		if (!empty($_POST['item_title']))
		{
			$AVE_DB->Query("
				INSERT
				INTO " . PREFIX . "_modul_poll_items
				SET
					id                 = '',
					poll_id            = '" . $pid . "',
					poll_item_title    = '" . $_REQUEST['item_title'] . "',
					poll_item_hits     = '" . $_REQUEST['poll_item_hits'] . "',
					poll_item_color    = '" . $_REQUEST['line_color'] . "',
					poll_item_position = '" . $_REQUEST['position'] . "'
			");
		}

		reportLog($_SESSION['user_name'] . ' - добавил новый вариант ответа (' . ($_REQUEST['item_title']) . ') для опроса', 2, 2);

		header('Location:index.php?do=modules&action=modedit&mod=poll&moduleaction=edit&id=' . $pid . '&pop=1&cp=' . SESSION);
		exit;
	}

	/**
	 * Метод редактирования опроса
	 *
	 * @param string $tpl_dir	путь к папке с шаблонами модуля
	 * @param string $lang_file	путь к языковому файлу модуля
	 * @param int $pid			идентификатор опроса
	 */
	function pollEdit($tpl_dir, $lang_file, $pid)
	{
		global $AVE_DB, $AVE_Template;

		$AVE_Template->config_load($lang_file, 'editpolls');

		$items = array();
		$sql = $AVE_DB->Query("
			SELECT *
			FROM " . PREFIX . "_modul_poll_items
			WHERE poll_id = '" . $pid . "'
			ORDER BY poll_item_position ASC
		");
		while ($row = $sql->FetchRow())
		{
			array_push($items, $row);
		}

		$groups = array();
		$sql = $AVE_DB->Query("
			SELECT
				user_group AS id,
				user_group_name AS name
			FROM " . PREFIX . "_user_groups
		");
		while ($row = $sql->FetchRow())
		{
			$groups[$row->id] = $row->name;
		}

		$row = $AVE_DB->Query("
			SELECT *
			FROM " . PREFIX . "_modul_poll
			WHERE id = '" . $pid . "'
		")->FetchRow();

		$AVE_Template->assign('groups', $groups);
		$AVE_Template->assign('selected', explode(',', $row->poll_groups_id));
		$AVE_Template->assign('row', $row);
		$AVE_Template->assign('items', $items);
		$AVE_Template->assign('tpl_dir', $tpl_dir);
		$AVE_Template->assign('start', $row->poll_start);
		$AVE_Template->assign('end', $row->poll_end);
		$AVE_Template->assign('formaction', 'index.php?do=modules&action=modedit&mod=poll&moduleaction=save&cp=' . SESSION . '&id=' . $pid . '&pop=1');
		$AVE_Template->assign('content', $AVE_Template->fetch($tpl_dir . 'admin_fields.tpl'));
	}

	/**
	 * Метод записи изменений в опросе
	 *
	 * @param int $pid	идентификатор опроса
	 */
	function pollSave($pid)
	{
		global $AVE_DB;

		$start_date = $this->_mktime('sd', 'st');
		$end_date = $this->_mktime('ed', 'et');

		$AVE_DB->Query("
			UPDATE " . PREFIX . "_modul_poll
			SET
				poll_title       = '" . $_REQUEST['poll_name'] . "',
				poll_status      = '" . $_REQUEST['poll_status'] . "',
				poll_can_comment = '" . $_REQUEST['poll_can_comment'] . "',
				poll_start       = '" . $start_date . "',
				poll_end         = '" . $end_date . "',
				poll_groups_id   = '" . @implode(',', (array)$_REQUEST['groups']) . "'
			WHERE
				id = '" . $pid . "'
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

		foreach ($_POST['item_title'] as $id => $field)
		{
			if (!empty($field))
			{
				$AVE_DB->Query("
					UPDATE " . PREFIX . "_modul_poll_items
					SET
						poll_item_title    = '" . $field . "',
						poll_item_hits     = '" . $_POST['poll_item_hits'][$id] . "',
						poll_item_color    = '" . $_POST['line_color'][$id] . "',
						poll_item_position = '" . $_POST['position'][$id] . "'
					WHERE
						id = '" . $id . "'
				");
			}
		}

		header('Location:index.php?do=modules&action=modedit&mod=poll&moduleaction=edit&id=' . $pid . '&pop=1&cp=' . SESSION);
		exit;
	}

	/**
	 * Метод удаления опроса
	 *
	 * @param int $pid	идентификатор опроса
	 */
	function pollDelete($pid)
	{
		global $AVE_DB;

		$AVE_DB->Query("
			DELETE
			FROM " . PREFIX . "_modul_poll
			WHERE id = '" . $pid . "'
		");
		$AVE_DB->Query("
			DELETE
			FROM " . PREFIX . "_modul_poll_items
			WHERE poll_id = '" . $pid . "'
		");
		$AVE_DB->Query("
			DELETE
			FROM " . PREFIX . "_modul_poll_comments
			WHERE poll_id = '" . $pid . "'
		");

		reportLog($_SESSION['user_name'] . ' - удалил опрос (' . $pid . ')', 2, 2);

		header('Location:index.php?do=modules&action=modedit&mod=poll&moduleaction=1&cp=' . SESSION);
		exit;
	}

	/**
	 * Метод управления комментариями к опросам
	 *
	 * @param string $tpl_dir	путь к папке с шаблонами модуля
	 * @param string $lang_file	путь к языковому файлу модуля
	 * @param int $pid			идентификатор опроса
	 */
	function pollCommentEdit($tpl_dir, $lang_file, $pid)
	{
		global $AVE_DB, $AVE_Template;

		$AVE_Template->config_load($lang_file, 'showcomments');

		switch ($_REQUEST['sub'])
		{
			case '':
				$items = array();
				$sql = $AVE_DB->Query("
					SELECT *
					FROM " . PREFIX . "_modul_poll_comments
					WHERE poll_id = '" . $pid . "'
				");
				while ($row = $sql->FetchRow())
				{
					$row->poll_comment_author = get_username_by_id($row->poll_comment_author_id);

					array_push($items, $row);
				}

				$AVE_Template->assign('items', $items);
				$AVE_Template->assign('tpl_dir', $tpl_dir);
				$AVE_Template->assign('content', $AVE_Template->fetch($tpl_dir . 'admin_comments.tpl'));
				break;

			case 'save':
				if (!empty($_POST['del']))
				{
					foreach ($_POST['del'] as $id => $val)
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
								poll_comment_title = '" . $_POST['comment_title'][$id] . "',
								poll_comment_text  = '" . $comment . "'
							WHERE
								id = '" . $id . "'
						");
					}
				}

				header('Location:index.php?do=modules&action=modedit&mod=poll&moduleaction=comments&id=' . $pid . '&pop=1&cp=' . SESSION);
				exit;
		}
	}

	/**
	 * Формитрование метки времени по данным полученным из выпадающих списков
	 * сформированных Smarty {html_select_date} и {html_select_time}
	 *
	 * @param string $date имя массива с значениями даты
	 * @param string $time имя массива с значениями времени
	 * @return unknown timestamp
	 */
	function _mktime($date = '', $time = '')
	{
		if (empty($date) && empty($time)) return time();

		$hour = $minute = $second = $day = $month = $year = 0;

		if ($time != '' && isset($_REQUEST[$time]) && is_array($_REQUEST[$time]))
		{
			$hour   = isset($_REQUEST[$time]['Hour'])   ? (int)$_REQUEST[$time]['Hour']   : 0;
			$minute = isset($_REQUEST[$time]['Minute']) ? (int)$_REQUEST[$time]['Minute'] : 0;
			$second = isset($_REQUEST[$time]['Second']) ? (int)$_REQUEST[$time]['Second'] : 0;
		}

		if ($date != '' && isset($_REQUEST[$date]) && is_array($_REQUEST[$date]))
		{
			$day   = isset($_REQUEST[$date]['Day'])   ? (int)$_REQUEST[$date]['Day']   : 0;
			$month = isset($_REQUEST[$date]['Month']) ? (int)$_REQUEST[$date]['Month'] : 0;
			$year  = isset($_REQUEST[$date]['Year'])  ? (int)$_REQUEST[$date]['Year']  : 0;
		}

		return mktime($hour, $minute, $second, $month, $day, $year);
	}
}

?>