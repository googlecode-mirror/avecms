<?php

/**
 * �����, ���������� ��� �������� � ������ ��� ���������� ������������� ��� �
 * ��������� ����� �����, ��� � � ������ ����������.
 *
 * @package AVE.cms
 * @subpackage module_Comment
 * @filesource
 */
class Comment
{

/**
 * �������� ������
 */

	/**
	 * ������������� ������ � ����������� ������ �����������
	 *
	 * @var int
	 */
	var $_config_id = 1;

	/**
	 * ���������� ������������ �� �������� � ���������������� �����
	 *
	 * @var int
	 */
	var $_limit = 15;

	/**
	 * ��� ����� � �������� ��� ������ ����� ������������
	 *
	 * @var string
	 */
	var $_comments_tree_tpl = 'comments_tree.tpl';

	/**
	 * ��� ����� � �������� ��� ������������ ������ �������� ������������
	 *
	 * @var string
	 */
	var $_comments_tree_sub_tpl = 'comments_tree_sub.tpl';

	/**
	 * ��� ����� � �������� ����� ���������� �����������
	 *
	 * @var string
	 */
	var $_comment_form_tpl = 'comment_form.tpl';

	/**
	 * ��� ����� � �������� ������ �����������
	 *
	 * @var string
	 */
	var $_comment_new_tpl = 'comment_new.tpl';

	/**
	 * ��� ������ � �������� ������������ � �������� ���������� ��������
	 *
	 * @var string
	 */
	var $_comment_thankyou_tpl = 'comment_thankyou.tpl';

	/**
	 * ��� ����� � �������� �������������� ������� � ���������������� �����
	 *
	 * @var string
	 */
	var $_admin_edit_link_tpl = 'admin_edit.tpl';

	/**
	 * ��� ����� � �������� ������ ������������ � ���������������� �����
	 *
	 * @var string
	 */
	var $_admin_comments_tpl = 'admin_comments.tpl';

	/**
	 * ��� ����� � �������� �������������� �������� ������ � ���������������� �����
	 *
	 * @var string
	 */
	var $_admin_settings_tpl = 'admin_settings.tpl';

	/**
	 * ��� ����� � �������� �������������� ������� � ��������� �����
	 *
	 * @var string
	 */
	var $_edit_link_tpl = 'comment_edit.tpl';

	/**
	 * ��� ����� � �������� ��� ������ ���������� �� ������ �����������
	 *
	 * @var string
	 */
	var $_postinfo_tpl = 'comment_info.tpl';

/**
 * ���������� ������ ������
 */

	/**
	 * �����, ��������������� ��� ��������� �������� �������� ������,������� �������� � ������ ����������.
     *
     * @param string $param �������� ���������
	 * @return mixed �������� ���������
	*/
	function _commentSettingsGet($param = '')
	{
		global $AVE_DB;

		// ���������� ����������� ����������, ������� ����� ������� ���������� ��������� �� ���������� �����
        // ����� ����� �������.
        static $settings = null;

        // ���� ���������� $settings ��� �� ����� ��������, ����� ��������� ������ � �� �� ��������� ������
		if ($settings === null)
		{
			$settings = $AVE_DB->Query("
				SELECT *
				FROM " . PREFIX . "_modul_comments
				WHERE Id = '" . $this->_config_id . "'
			")->FetchAssocArray();
		}

		if ($param == '') return $settings;

        // � ��������� ������ ���������� ��� ��������� ��������
		return (isset($settings[$param]) ? $settings[$param] : null);
	}

    /**
     * �����, ��������������� ��� ��������� ���������� ������������ ��� ������������� ���������.
     *
     * @param int $document_id - ������������� ���������
     * @return int - ���������� ������������
     */
    function _commentPostCountGet($document_id)
    {
        global $AVE_DB;

   		// ���������� ����������� ������, ������� ����� ������� ���������� ������������ ��� ���������� ��
        // ���������� ����� ����� ����� �������.
        static $comments = array();


        // ���� � ������� �� ������ ����, ������� ������������� �������������� ���������, ����� ���������
        // ������ � �� �� ��������� ���������� ������������
        if (! isset($comments[$document_id]))
        {
            $comments[$document_id] = $AVE_DB->Query("
                SELECT COUNT(*)
                FROM " . PREFIX . "_modul_comment_info
                WHERE document_id = '" . $document_id . "'
            ")->GetCell();
        }

        // ���������� ���������� ������������ ��� �������������� ���������
        return $comments[$document_id];
    }

/**
 * ������� ������ ������
 */

	/**
	 * ��������� ������ ��������� ������ ������ � ��������� ����� �����.
     */

    /**
     * �����, ��������������� ��� ��������� �� �� ���� ������������, ����������� � ����������
     * ��������� � ����������� ������� � ��������� �����.
     *
     * @param string $tpl_dir - ���� � �������� ������
     *
	 * @todo ����� ���������� � ������ �����������
     */
    function commentListShow($tpl_dir)
	{
		global $AVE_DB, $AVE_Template;

		// ���������, ��� � ���������� ������ ��������� ��������������� ����������
        if ($this->_commentSettingsGet('active') == 1)
		{
			$assign['display_comments'] = 1;

            // ���� ������ ������������, ������� � ������� ������ ������������� �������� �������� � ������
            // ����������� (� ���������� ������), ����� ������� ����, ������� ����� ��������� � ������
            // ����� ��� ���������� ������ �����������
            if (in_array(UGROUP, explode(',', $this->_commentSettingsGet('user_groups'))))
			{
				$assign['cancomment'] = 1;
			}

            $assign['max_chars'] = $this->_commentSettingsGet('max_chars');
			$assign['im'] = $this->_commentSettingsGet('spamprotect');

			// ��������� ������ � �� �� ��������� ���������� ������������ ��� �������� ���������
            $comments = array();
			$sql = $AVE_DB->Query("
				SELECT *
				FROM " . PREFIX . "_modul_comment_info
				WHERE document_id = '" . (int)$_REQUEST['id'] . "'
				" . (UGROUP == 1 ? '' : 'AND status = 1') . "
				ORDER BY published ASC
			");

			// �������� ������ ����, ������� ������ � ����� ���������� ������� �
            // �������� ���� �������� ����������� � ���� �������������� � ����� �������
            $date_time_format = $AVE_Template->get_config_vars('COMMENT_DATE_TIME_FORMAT');
			while ($row = $sql->FetchAssocArray())
			{
				$row['published']  = strftime($date_time_format, $row['published']);
				$row['edited'] = strftime($date_time_format, $row['edited']);
//				if ($row['parent_id'] == 0)
//					$row['message'] = nl2br(wordwrap($row['message'], 100, "\n", true));
//				else
//					$row['message'] = nl2br(wordwrap($row['message'], 90, "\n", true));
//				$row['message'] = nl2br($row['message']);

				$comments[$row['parent_id']][] = $row;
			}

			// ��������� ��� ���������� ��� ������������� � �������
            $assign['closed'] = @$comments[0][0]['comments_close'];
			$assign['comments'] = $comments;
			$assign['theme'] = defined('THEME_FOLDER') ? THEME_FOLDER : DEFAULT_THEME_FOLDER;
			$assign['doc_id'] = (int)$_REQUEST['id'];
			$assign['page'] = base64_encode(get_redirect_link());
			$assign['subtpl'] = $tpl_dir . $this->_comments_tree_sub_tpl;
			$AVE_Template->assign($assign);

            // ���������� ������
            $AVE_Template->display($tpl_dir . $this->_comments_tree_tpl);
		}
	}

	/**
	 * �����, ��������������� ��� ����������� ����� ��� ���������� ������ �����������.
	 *
     * @param string $tpl_dir - ���� � �������� ������
	 */
	function commentPostFormShow($tpl_dir)
	{
		global $AVE_DB, $AVE_Template;

		// �������� ������ ������������ �� ������� ��������� ������
        $geschlossen = $AVE_DB->Query("
			SELECT comments_close
			FROM " . PREFIX . "_modul_comment_info
			WHERE document_id = '" . (int)$_REQUEST['docid'] . "'
			LIMIT 1
		")->GetCell();

		// ��������� ��� ���������� ��� ������������� � �������
        $AVE_Template->assign('closed', $geschlossen);
		$AVE_Template->assign('cancomment', ($this->_commentSettingsGet('active') == 1 && in_array(UGROUP, explode(',', $this->_commentSettingsGet('user_groups')))));
		$AVE_Template->assign('max_chars', $this->_commentSettingsGet('max_chars'));
		$AVE_Template->assign('theme', defined('THEME_FOLDER') ? THEME_FOLDER : DEFAULT_THEME_FOLDER);

        // ���������� ����� ��� ���������� �����������
        $AVE_Template->display($tpl_dir . $this->_comment_form_tpl);
	}

    /**
	 * �����, ��������������� ��� ������ � �� ������ �����������.
	 *
     * @param string $tpl_dir - ���� � �������� ������
     *
     * @todo ����� ��������� � ���������� ���������� �����������, � �����
     * ����������� ������ � ���������� ��� ������ ��������� ��������� ������, ������� ����� ����������
     * ������������� �������� ����������� �� e-mail � ����� �����������. �������� �� ���� ������� ��������
     * �����������.
     *
	 */
	function commentPostNew($tpl_dir)
	{
		global $AVE_DB, $AVE_Template;
        // ���� ������ ������ �� ajax ��������, ����� ��������� ������ ��� ������������ ���������
		if (! $ajax = (isset($_REQUEST['ajax']) && $_REQUEST['ajax'] == 1))
		{
			$link = rewrite_link(urldecode(get_redirect_link()));
		}


        // ���� � ���������� ������ �������� ������������� ��������� ����, �����
        if ($this->_commentSettingsGet('spamprotect') == 1)
		{
            // ���� ��������� ������������� �������� ��� �������, ����� ��������� ���������� ����
            if (! (isset($_SESSION['captcha_keystring']) && isset($_POST['securecode'])
                && $_SESSION['captcha_keystring'] == $_POST['securecode']))
			{
				unset($_SESSION['captcha_keystring']);

				if ($ajax)
				{
					echo 'wrong_securecode';
				}
				else
				{
					header('Location:' . $link . '#end');
				}
				exit;
			}
            unset($_SESSION['captcha_keystring']);
		}

		// ���������� ���� ��������� ������������
        $status = ($this->_commentSettingsGet('moderate') == 1) ? 0 : 1;

		// ���� ����������� ���������, ����� �������� ��� ������, ������� ������������ ������ � �����
        if ($this->_commentSettingsGet('active') == 1
			&& !empty($_POST['message'])
			&& !empty($_POST['author_name'])
			&& in_array(UGROUP, explode(',', $this->_commentSettingsGet('user_groups'))))
		{
			$new_comment['parent_id'] = (int)$_POST['parent_id'];
			$new_comment['document_id'] = (int)$_POST['doc_id'];
			$new_comment['author_name'] = $_POST['author_name'];
			$new_comment['author_id'] = empty($_SESSION['user_id']) ? '' : $_SESSION['user_id'];
			$new_comment['author_email'] = $_POST['author_email'];
			$new_comment['author_city'] = $_POST['author_city'];
			$new_comment['author_website'] = $_POST['author_website'];
			$new_comment['author_ip'] = $_SERVER['REMOTE_ADDR'];
			$new_comment['published'] = time();
			$new_comment['message'] = $_POST['message'];
			$new_comment['status'] = $status;

			// ���� ������ ���� ���������� � ������� ajax_�������, ����������� ��������� ����������
            // � ��������� cp1251
            if ($ajax)
			{
				$new_comment['author_name'] = iconv('utf-8', 'cp1251', $new_comment['author_name']);
				$new_comment['author_email'] = iconv('utf-8', 'cp1251', $new_comment['author_email']);
				$new_comment['author_website'] = iconv('utf-8', 'cp1251', $new_comment['author_website']);
				$new_comment['author_city'] = iconv('utf-8', 'cp1251', $new_comment['author_city']);
				$new_comment['message'] = iconv('utf-8', 'cp1251', $new_comment['message']);
			}

			// ���������� ������������ ����� �������� ��� �����������
            $max_chars = $this->_commentSettingsGet('max_chars');
			$max_chars = (!empty($max_chars) && $max_chars > 10) ? $max_chars : 200;

            // ���� ����� ����������� ��������� ����������� ����������, �������� �����, �� ������������� ��������
			$new_comment['message'] = substr(stripslashes($new_comment['message']), 0, $max_chars);
			$new_comment['message'] .= (strlen($new_comment['message']) > $max_chars) ? '�' : '';
//			$new_comment['message'] = htmlspecialchars($new_comment['message'], ENT_QUOTES);
			$new_comment['message'] = pretty_chars($new_comment['message']);


            // ��������� ������ � �� �� ���������� �����������
            $AVE_DB->Query("
				INSERT INTO " . PREFIX . "_modul_comment_info
					(" . implode(',', array_keys($new_comment)) .")
				VALUES
					('" . implode("','", $new_comment) . "')
			");
			$new_comment['Id'] = $AVE_DB->InsertId();

			// �������� e-mail ����� �� ����� �������� ������� � ��������� ������ �� ����������� � ��������� �����
            $mail_from = get_settings('mail_from');
			$mail_from_name = get_settings('mail_from_name');
			$page = get_home_link() . urldecode(base64_decode($_REQUEST['page'])) . '&subaction=showonly&comment_id=' . $new_comment['Id'] . '#' . $new_comment['Id'];

			//  ��������� ����� ����������� ��� �������� �� e-mail
            $mail_text = $AVE_Template->get_config_vars('COMMENT_MESSAGE_ADMIN');
			$mail_text = str_replace('%COMMENT%', stripslashes($new_comment['message']), $mail_text);
			$mail_text = str_replace('%N%', "\n", $mail_text);
			$mail_text = str_replace('%PAGE%', $page, $mail_text);
			$mail_text = str_replace('&amp;', '&', $mail_text);

			// ���������� �����������
            send_mail(
				$mail_from,
				$mail_text,
				$AVE_Template->get_config_vars('COMMENT_SUBJECT_MAIL'),
				$mail_from,
				$mail_from_name,
				'text'
			);

			// ���� ������ ���� ���������� ajax-��������, ����� ��������� �������������� ����� �����������
            // �� ��������.
            if ($ajax)
			{
				$new_comment['published'] = strftime($AVE_Template->get_config_vars('COMMENT_DATE_TIME_FORMAT'), $new_comment['published']);
				$subcomments[] = $new_comment;
				$AVE_Template->assign('subcomments', $subcomments);
				$AVE_Template->assign('theme', defined('THEME_FOLDER') ? THEME_FOLDER : DEFAULT_THEME_FOLDER);
				$AVE_Template->display($tpl_dir . $this->_comments_tree_sub_tpl);
			}
		}

//		$JsAfter = ($status == 0) ? $AVE_Template->get_config_vars('COMMENT_AFTER_MODER') : $AVE_Template->get_config_vars('COMMENT_THANKYOU_TEXT');
//		$AVE_Template->assign('JsAfter', $JsAfter);
//		$AVE_Template->display($tpl_dir . $this->_comment_thankyou_tpl);

        // ���� �� ������ ������ �� ajax-��������, ����� ��������� ��������� ��������.
		if (! $ajax) header('Location:' . $link . '#end');
		exit;
	}

    /**
     * �����, ��������������� ��� �������������� ����������� � ��������� �����
     *
     * @param int $comment_id - ������������� �����������
     */
	function commentPostEdit($comment_id)
	{
		global $AVE_DB;

		if (empty($_SESSION['user_id'])) exit;

        $comment_id  = intval(preg_replace('/\D/', '', $comment_id));

		// ��������� ������ � �� � �������� ��� ���������� � �����������, � ����� ��� �������� �� �������� ������
        $row = $AVE_DB->Query("
			SELECT
			--	msg.Id,
			--	msg.document_id,
			--	msg.author_name,
			--	msg.author_email,
			--	msg.author_city,
			--	msg.author_website,
				msg.parent_id,
				msg.message,
				cmnt.user_groups,
				cmnt.max_chars,
				cmnt.moderate
			FROM
				" . PREFIX . "_modul_comment_info AS msg,
				" . PREFIX . "_modul_comments AS cmnt
			WHERE active = 1
			AND msg.Id = '" . $comment_id . "'
			" . ((UGROUP != 1) ? "AND author_id = " . $_SESSION['user_id'] : '') . "
		")->FetchAssocArray();

		// ���� ������ ��������
        if ($row !== false)
		{

            $max_chars = ($row['max_chars'] != '' && $row['max_chars'] > 10) ? $row['max_chars'] : 20;

			$message = iconv('utf-8', 'cp1251', $_POST['text']);

			// ����������� ��� HTML �������� � �������� ��������
			$message = preg_replace_callback('/&([a-zA-Z][a-zA-Z0-9]{1,7});/', 'convert_entity', $message);

			// ����������� ����� ���������
			$message = preg_replace('/&#x([0-9a-f]{1,7});/ei', 'chr(hexdec("\\1"))', $message);
			$message = preg_replace('/&#([0-9]{1,7});/e', 'chr("\\1")', $message);

			$message = stripslashes($message);
			$message = str_replace(array("<br>\n", "<br />\n", "<br/>\n"), "\n", $message);
//			$message = strip_tags($message);
			$message = substr($message, 0, $max_chars-1);
			$message_length = strlen($message);
			$message .= ($message_length > $max_chars) ? '�' : '';
//			$message = pretty_chars(htmlspecialchars($message, ENT_QUOTES));

			// ���� ������ �������� ������������ ��������� � ����������� ������� � ���������� ������, �����
            // ��������� ������ � �� �� ���������� ����������.
            if (in_array(UGROUP, explode(',', $row['user_groups'])) && $message_length > 3)
			{
				$AVE_DB->Query("
					UPDATE " . PREFIX . "_modul_comment_info
					SET
					--	author_name = '" . (empty($_POST['author_name']) ? @addslashes($row['author_name']) : $_POST['author_name']) . "',
					--	author_email = '" . (empty($_POST['author_email']) ? @addslashes($row['author_email']) : $_POST['author_email']) . "',
					--	author_city = '" . (empty($_POST['author_city']) ? @addslashes($row['author_city']) : $_POST['author_city']) . "',
					--	author_website = '" . (empty($_POST['author_website']) ? @addslashes($row['author_website']) : $_POST['author_website']) . "',
						edited = '" . time() . "',
						status = '" . intval(!(bool)$row['moderate']) . "',
						message = '" . addslashes($message) . "'
					WHERE
						Id = '" . $comment_id . "'
				");

//				if ($row['parent_id'] == 0)
//					echo nl2br(wordwrap($message, 100, "\n", true));
//				else
//					echo nl2br(wordwrap($message, 90, "\n", true));
//				echo nl2br(htmlspecialchars($message, ENT_QUOTES));

				// ����������� HTML ���� � HTML ��������
                echo htmlspecialchars($message, ENT_QUOTES);
				exit;
			}

//			if ($row['parent_id'] == 0)
//				echo nl2br(wordwrap($row['message'], 100, "\n", true));
//			else
//				echo nl2br(wordwrap($row['message'], 90, "\n", true));
//			echo nl2br(htmlspecialchars($row['message'], ENT_QUOTES));

			// ����������� HTML ���� � HTML ��������
            echo htmlspecialchars($row['message'], ENT_QUOTES);
		}
		exit;
	}

    /**
     * �����, ��������������� ��� �������� �����������. ���� ����������� �������� �����-���� ������ �� ����,
     * �� ��� ������ ����� ����� ������� ������ � ������������ ������������.
     *
     * @param int $comment_id - ������������� �����������
     */
	function commentPostDelete($comment_id)
	{
		global $AVE_DB;

        // ��������� ������ � �� �� �������� ������������� �����������
		$AVE_DB->Query("
			DELETE
			FROM " . PREFIX . "_modul_comment_info
			WHERE Id = '" . $comment_id . "'
		");

        // ��������� ������ � �� �� �������� �������� ������������ (�������)
        $AVE_DB->Query("
			DELETE
			FROM " . PREFIX . "_modul_comment_info
			WHERE parent_id = '" . $comment_id . "'
			AND parent_id != 0
		");

		exit;
	}

	/**
	 * �����, ��������������� ��� ������ ��������� ���������� �� ������ �����������
	 *
     * @param string $tpl_dir - ���� � �������� ������
	 */
	function commentPostInfoShow($tpl_dir)
	{
		global $AVE_DB, $AVE_Template;

		// �������� ������ ���������� � �����������
        $row = $AVE_DB->Query("
			SELECT *
			FROM " . PREFIX . "_modul_comment_info
			WHERE Id = '" . (int)$_REQUEST['Id'] . "'
		")->FetchAssocArray();

        // ����������� ����� ����� � ������� ������
        $row['author_website'] = str_replace('http://', '', $row['author_website']);
		$row['author_website'] = ($row['author_website'] != '') ? '<a target="_blank" href="http://' . $row['author_website'] . '">' . $row['author_website'] .'</a>' : '';

		// ��������� ������ � �� �� ��������� ���������� ���� ������������, ����������� ������ �������������
        $row['num'] = $AVE_DB->Query("
			SELECT COUNT(*)
			FROM " . PREFIX . "_modul_comment_info
			WHERE author_id = '" . $row['author_id'] . "'
			AND author_id != 0
		")->GetCell();

		// ���������� ���� � �����������
        $AVE_Template->assign('c', $row);
		$AVE_Template->display($tpl_dir . $this->_postinfo_tpl);
	}

    /**
	 * �����, ��������������� ��� ���������� �������� ��� ����������� �������� �� �����������
	 *
	 * @param int $comment_id - ������������� �����������
	 * @param string $status - {lock|unlock} ������� �������/����������
	 */
	function commentReplyStatusSet($comment_id, $status = 'lock')
	{
		global $AVE_DB;

		$AVE_DB->Query("
			UPDATE " . PREFIX . "_modul_comment_info
			SET status = '" . (($status == 'lock') ? 0 : 1) . "'
			WHERE Id = '" . $comment_id . "'
		");

		exit;
	}

    /**
	 * �����, ��������������� ��� ���������� �������� ��� ����������� �������������� ��������
	 *
	 * @param int $document_id - ������������� ���������
	 * @param string $status - {close|open} ������� �������/����������
	 */
	function commentStatusSet($document_id, $status = 'open')
	{
		global $AVE_DB;

		$AVE_DB->Query("
			UPDATE " . PREFIX . "_modul_comment_info
			SET comments_close = '" . (($status == 'open') ? 0 : 1) . "'
			WHERE document_id = '" . $document_id . "'
		");

		exit;
	}

    /**
	 * ��������� ������ ��������� ������ ������ � ���������������� ����� �����.
	 */

    /**
     * �����, ��������������� ��� ������ ������ ���� ������������ � ���������������� �����.
     *
     * @param string $tpl_dir - ���� � �������� ������
     */
	function commentAdminListShow($tpl_dir)
	{
		global $AVE_DB, $AVE_Template;

		// �������� ����� ���������� ������������
        $num = $AVE_DB->Query("SELECT COUNT(*) FROM " . PREFIX . "_modul_comment_info")->GetCell();

		// ���������� ���������� �������, �������� �������� _limit, ������� ����������� ����������
        // ������������ ������������ �� ����� ��������
        @$seiten = @ceil($num / $this->_limit);
		$start = get_current_page() * $this->_limit - $this->_limit;

		$docs = array();

		$def_sort = 'ORDER BY doc.Id DESC';
		$def_nav = '';

        // ���������� ������� ���������� ������������
		if (!empty($_REQUEST['sort']))
		{
			switch ($_REQUEST['sort'])
			{
				case 'doc_desc':
					$def_sort = 'ORDER BY CId ASC';
					$def_nav  = '&sort=doc_desc';
					break;

				case 'doc_asc':
					$def_sort = 'ORDER BY CId DESC';
					$def_nav  = '&sort=doc_asc';
					break;

				case 'comment_desc':
					$def_sort = 'ORDER BY cmnt.message ASC';
					$def_nav  = '&sort=comment_desc';
					break;

				case 'comment_asc':
					$def_sort = 'ORDER BY cmnt.message DESC';
					$def_nav  = '&sort=comment_asc';
					break;

				case 'created_desc':
					$def_sort = 'ORDER BY cmnt.published ASC';
					$def_nav  = '&sort=created_desc';
					break;

				case 'created_asc':
					$def_sort = 'ORDER BY cmnt.published DESC';
					$def_nav  = '&sort=created_asc';
					break;
			}
		}


        // ��������� ������ � �� �� ��������� ����������� � ������ ���������� ���������� � ������.
        $sql = $AVE_DB->Query("
			SELECT
				doc.Id,
				doc.Titel,
				cmnt.Id AS CId,
				cmnt.document_id,
				cmnt.message,
				cmnt.published
			FROM
                " . PREFIX . "_modul_comment_info AS cmnt
			JOIN
                " . PREFIX . "_documents AS doc
			        ON doc.Id = cmnt.document_id
			" . $def_sort . "
			LIMIT " . $start . "," . $this->_limit
		);

		while ($row = $sql->FetchAssocArray())
		{
            $row['Comments'] = $this->_commentPostCountGet($row['Id']);
			array_push($docs, $row);
		}


        // ���� ���������� ������������ ���������� �� �� ��������� ���������� �� ��������, ����� ���������
        // ���� ������������ ���������
        if ($num > $this->_limit)
		{
			$page_nav = ' <a class="pnav" href="index.php?do=modules&action=modedit&mod=comment&moduleaction=1&cp=' . SESSION . '&page={s}' . $def_nav . '">{t}</a> ';
			$page_nav = get_pagination($seiten, 'page', $page_nav);
			$AVE_Template->assign('page_nav', $page_nav);
		}

        // �������� ������ � ������ ��� ������ � ���������� ������
        $AVE_Template->assign('docs', $docs);
		$AVE_Template->assign('content', $AVE_Template->fetch($tpl_dir . $this->_admin_comments_tpl));
	}

    /**
     * �����, ��������������� ��� �������������� ������������ � ���������������� �����.
     *
     * @param string $tpl_dir - ���� � �������� ������
     */
	function commentAdminPostEdit($tpl_dir)
	{
		global $AVE_DB, $AVE_Template;

		// ��������� ������ � �� �� ��������� ���������� � ������������� �����������
        $row = $AVE_DB->Query("
			SELECT *
			FROM " . PREFIX . "_modul_comment_info
			WHERE Id = '" . (int)$_REQUEST['Id'] . "'
			LIMIT 1
		")->FetchAssocArray();


        // ���� � ������� ���������� ��������� �� ���������� ������ (������������ ��� �������������� �����������
        // � ����� ������ ��������� ���������), ����� ��������� ������ � �� �� ���������� ����������.
        if (isset($_POST['sub']) && $_POST['sub'] == 'send' && false != $row)
        {
            $AVE_DB->Query("
                UPDATE " . PREFIX . "_modul_comment_info
                SET
                    author_name = '" . htmlspecialchars($_POST['author_name']) . "',
                    author_email = '" . htmlspecialchars($_POST['author_email']) . "',
                    author_city = '" . htmlspecialchars($_POST['author_city']) . "',
                    author_website = '" . htmlspecialchars($_POST['author_website']) . "',
                    message = '" . htmlspecialchars($_POST['message']) . "',
                    edited = '" . time() . "'
                WHERE
                    Id = '" . (int)$_POST['Id'] . "'
            ");

            echo '<script>window.opener.location.reload();window.close();</script>';

            return;
        }

		// ���� � ������ ������� �� �� �� �������� ������� ���������, ����� ���������� ��������� � �������
        if ($row == false)
		{
			$AVE_Template->assign('editfalse', 1);
		}
		// � ��������� ������ �������� ������ ������������, � ������� ����� ������ �� ������
        else
		{
		    $closed = $AVE_DB->Query("
			    SELECT comments_close
			    FROM " . PREFIX . "_modul_comment_info
			    WHERE document_id = '" . (int)$_REQUEST['docid'] . "'
			    LIMIT 1
		    ")->GetCell();

		    $AVE_Template->assign('closed', $closed);
            $AVE_Template->assign('row', $row);
		    $AVE_Template->assign('max_chars', $this->_commentSettingsGet('max_chars'));
        }

        // ���������� ������
        $AVE_Template->assign('content', $AVE_Template->fetch($tpl_dir . $this->_admin_edit_link_tpl));
	}

    /**
     * �����, ��������������� ��� ���������� ����������� ������
     *
     * @param string $tpl_dir - ���� � �������� ������
     */
	function commentAdminSettingsEdit($tpl_dir)
	{
		global $AVE_DB, $AVE_Template;

        // ���� � ������� ���������� ��������� �� ���������� ������ (������������ ����� ������
        // ��������� ���������), ����� ��������� ������ � �� �� ���������� ����������.

		if (isset($_REQUEST['sub']) && $_REQUEST['sub'] == 'save')
		{
			$_POST['max_chars'] = (empty($_POST['max_chars']) || $_POST['max_chars'] < 50) ? 50 : $_POST['max_chars'];
			$AVE_DB->Query("
				UPDATE " . PREFIX . "_modul_comments
				SET
					max_chars = '" . @(int)$_POST['max_chars'] . "',
					user_groups = '" . @implode(',', $_POST['user_groups']) . "',
					moderate = '" . @(int)$_POST['moderate'] . "',
					active = '" . @(int)$_POST['active'] . "',
					spamprotect = '" . @(int)$_POST['spamprotect'] . "'
				WHERE
					Id = 1
			");
		}

        // �������� ������ ���� �������� ������
		$row = $this->_commentSettingsGet();
        $row['user_groups'] = explode(',', $row['user_groups']);

		// �������� ������ � ������ � ���������� �������� � ����������� ������
        $AVE_Template->assign($row);
		$AVE_Template->assign('content', $AVE_Template->fetch($tpl_dir . $this->_admin_settings_tpl));
	}
}

?>