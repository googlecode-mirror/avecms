<?php

/**
 * ����� ������ � �������� ������
 *
 * @package AVE.cms
 * @subpackage module_Guestbook
 * @filesource
 */
class Guest
{
	/**
	 * ��������� ��������� ��������� ������ �������� �����
	 *
	 * @param string $field �������� ���������
	 * @return mixed �������� ��������� ��� ������ ���������� ���� �� ������ $field
	 */
	function _guestbookSettingsGet($field = '')
	{
		global $AVE_DB;

		static $settings = null;

		if ($settings === null)
		{
			$settings = $AVE_DB->Query("
				SELECT *
				FROM " . PREFIX . "_modul_guestbook
				WHERE Id = 1
			")->FetchAssocArray();
		}

		if ($field == '') return $settings;

		return (isset($settings[$field]) ? $settings[$field] : null);
	}

	/**
	 * ����� ��������� ������ ��� ����������� (�� 5 �������, �� 10 ������� � �.�.)
	 *
	 * @return array
	 */
	function _guestbookPostPerSiteGet()
	{
		$pps_array = array();
		for ($a = 5; $a <= 50; $a += 5)
		{
			array_push($pps_array, array('ps' => $a, 'pps_sel' => (($_REQUEST['pp'] == $a) ? 'selected="selected"' : '')));
		}

		return $pps_array;
	}

	/**
	 * ��� ���� �������� bbCode
	 *
	 * @param string $text
	 * @return string
	 */
	function _guestbookBbcodeParse($text)
	{
		global $AVE_Template;

		require_once(BASE_DIR . '/lib/markitup/sets/bbcode/markitup.bbcode-parser.php');

		return BBCode2Html($text);
	}

	/**
	 * ����� ������ ��������� (��������� ���������, ������ �� �����, �������� ��� � �.�.)
	 *
	 * @param string $msg
	 * @param string $goto
	 * @param string $tpl
	 */
	function _guestbookMessageShow($msg = '', $goto = '')
	{
		global $AVE_Template, $mod;

		$goto = ($goto == '') ? 'index.php?module=guestbook' : $goto;
		$msg = str_replace('%%GoTo%%', $goto, $msg);
		$AVE_Template->assign('theme_folder', THEME_FOLDER);
		$AVE_Template->assign('GoTo', $goto);
		$AVE_Template->assign('content', $msg);
		$tpl_out = $AVE_Template->fetch($mod['tpl_dir'] . 'redirect.tpl');
		echo $tpl_out;
		exit;
	}

	/**
	 * ����� �������� ����� � ��������� �����
	 *
	 */
	function guestbookShow()
	{
		global $AVE_DB, $AVE_Template, $mod;

		$_REQUEST['pp'] = (!empty ($_REQUEST['pp']) && is_numeric($_REQUEST['pp'])) ? $_REQUEST['pp'] : '10';
		if (empty ($_REQUEST['sort'])) $_REQUEST['sort'] = 'asc';
		if ($_REQUEST['sort'] != 'asc') $_REQUEST['sort'] = 'desc';

		// ���� ���� ������������ ������ �� ����� - ��������� ������� ���������� GD � ������� ������ ������ �� �����������
		if ($this->_guestbookSettingsGet('guestbook_antispam') == 1 && @ extension_loaded('gd') == 1 && function_exists('imagettftext'))
		{
			$AVE_Template->assign('use_code', 1);
		}

		$AVE_Template->assign('post_max_length', $this->_guestbookSettingsGet('guestbook_post_max_length'));
		$AVE_Template->assign('dessel', ($_REQUEST['sort'] == 'desc') ? 'selected="selected"' : '');
		$AVE_Template->assign('ascsel', ($_REQUEST['sort'] == 'asc')  ? 'selected="selected"' : '');
		$AVE_Template->assign('pps_array', $this->_guestbookPostPerSiteGet());

		// ���� ��������� ������������ bbCode, �������� � ������ ����������
		if ($this->_guestbookSettingsGet('guestbook_use_bbcode') == 1)
		{
			$AVE_Template->assign('use_bbcode', 1);
		}

		// �������� ���������� ��������� � ��������� ������������ ���������
		$inserts = array();
		$num = $AVE_DB->Query("
			SELECT COUNT(*)
			FROM " . PREFIX . "_modul_guestbook_post
			WHERE guestbook_post_approve = '1'
		")->GetCell();

		if ($num > $_REQUEST['pp'])
		{
			$page_nav = " <a class=\"page_navigation\" href=\"index.php?module=guestbook&amp;pp=" . $_REQUEST['pp'] . "&amp;sort=" . $_REQUEST['sort'] . "&amp;page={s}\">{t}</a> ";
			$page_nav = get_pagination(ceil($num / $_REQUEST['pp']), 'page', $page_nav);
			$AVE_Template->assign('pages', $page_nav);
		}

		$start = get_current_page() * $_REQUEST['pp'] - $_REQUEST['pp'];

		// �������� ������ ���� ��������� � �������� �� � ������ ��� ������
		$sql = $AVE_DB->Query("
			SELECT *
			FROM " . PREFIX . "_modul_guestbook_post
			WHERE guestbook_post_approve = '1'
			ORDER BY id " . $_REQUEST['sort'] . "
			LIMIT " . $start . "," . $_REQUEST['pp']
		);

		while ($row = $sql->FetchRow())
		{
			if ($this->_guestbookSettingsGet('guestbook_use_bbcode') == 1)
			{
				$row->guestbook_post_text = $this->_guestbookBbcodeParse($row->guestbook_post_text);
			}
			else
			{
				$row->guestbook_post_text = htmlspecialchars($row->guestbook_post_text);
				$row->guestbook_post_text = str_replace("\r", "", $row->guestbook_post_text);
				$row->guestbook_post_text = "<p>".preg_replace("/(\n){2,}/", "</p><p>", $row->guestbook_post_text)."</p>";
				$row->guestbook_post_text = nl2br($row->guestbook_post_text);
			}

			array_push($inserts, $row);
		}

		$AVE_Template->assign('comments_array', $inserts);
		$AVE_Template->assign('allcomments', $num);
		define('MODULE_CONTENT', $AVE_Template->fetch($mod['tpl_dir'] . 'guestbook.tpl'));
	}

	/**
	 * ����� ���������
	 *
	 */
	function guestbookPostNew()
	{
		global $AVE_DB, $mod;

		// ���� ���� ��������� �������� ���
		if ($this->_guestbookSettingsGet('guestbook_antispam') == 1)
		{
			if (! (isset($_SESSION['captcha_keystring']) && isset($_POST['securecode'])
				&& $_SESSION['captcha_keystring'] == $_POST['securecode']))
			{
				unset($_SESSION['captcha_keystring']);
				$this->_guestbookMessageShow($mod['config_vars']['GUEST_WRONG_SCODE']);
			}
			unset($_SESSION['captcha_keystring']);
		}

		// ��������� ����� ����� ����������� ��������� (������ �� �����)
		if ($this->_guestbookSettingsGet('guestbook_antispam_time') > 0 && !$error)
		{
			$last_post_created = $AVE_DB->Query("
				SELECT
					guestbook_post_created
				FROM " . PREFIX . "_modul_guestbook_post
				WHERE guestbook_post_author_ip = '" . $_SERVER['REMOTE_ADDR'] . "'
				ORDER BY id DESC
				LIMIT 1
			")->GetCell();

			if ($last_post_created)
			{
				if (($last_post_created) + (60 * $this->_guestbookSettingsGet('guestbook_antispam_time')) > time())
				{
					$this->_guestbookMessageShow($mod['config_vars']['GUEST_WRONG_SPAM']);
				}
			}
		}

		if (strlen(trim($_POST['text'])) < 10)
		{
			$this->_guestbookMessageShow($mod['config_vars']['GUEST_SMALL_TEXT']);
		}

		if ($this->_guestbookSettingsGet('guestbook_need_approve') == 1)
		{
			$entry_now = 0;
			$text_thankyou = $mod['config_vars']['GUEST_CHECK_THANKS'];
		}
		else
		{
			$entry_now = 1;
			$text_thankyou = $mod['config_vars']['GUEST_THANKS'];
		}

		$text = substr($_POST['text'], 0, $this->_guestbookSettingsGet('guestbook_post_max_length'));

		$AVE_DB->Query("
			INSERT
			INTO " . PREFIX . "_modul_guestbook_post
			SET
				id                          = '',
				guestbook_post_author_name  = '" . substr($_REQUEST['author'], 0, 25) . "',
				guestbook_post_author_email = '" . substr($_REQUEST['email'], 0, 100) . "',
				guestbook_post_author_web   = '" . substr($_REQUEST['web'], 0, 100) . "',
				guestbook_post_author_ip    = '" . getenv('REMOTE_ADDR') . "',
				guestbook_post_author_sity  = '" . substr($_REQUEST['sity'], 0, 100) . "',
				guestbook_post_text         = '" . $text . "',
				guestbook_post_approve      = '" . $entry_now . "',
				guestbook_post_created      = '" . time() . "'
		");

		// ���������� ��������� �������������� �� E-mail
		if ($this->_guestbookSettingsGet('guestbook_send_copy') == 1)
		{
			send_mail(
				$this->_guestbookSettingsGet('guestbook_email_copy'),
				$text,
				$mod['config_vars']['GUEST_NEW_MAIL'],
				$this->_guestbookSettingsGet('guestbook_email_copy'),
				$mod['config_vars']['GUEST_PUB_NAME'],
				'text'
			);
		}

		$this->_guestbookMessageShow($text_thankyou);
	}

	/**
	 * ����� ���������� ����������� ������
	 *
	 * @param string $tpl_dir ���� � ����� � ���������
	 */
	function guestbookSettingsEdit($tpl_dir)
	{
		global $AVE_DB, $AVE_Template;

		switch ($_REQUEST['sub'])
		{
			case 'save' :
				$AVE_DB->Query("
					UPDATE " . PREFIX . "_modul_guestbook
					SET
						guestbook_antispam        = '" . $_REQUEST['antispam'] . "',
						guestbook_send_copy       = '" . $_REQUEST['send_copy'] . "',
						guestbook_email_copy      = '" . $_REQUEST['email_copy'] . "',
						guestbook_post_max_length = '" . $_REQUEST['post_max_length'] . "',
						guestbook_antispam_time   = '" . $_REQUEST['antispam_time'] . "',
						guestbook_need_approve    = '" . $_REQUEST['need_approve'] . "',
						guestbook_use_bbcode      = '" . $_REQUEST['use_bbcode'] . "'
				");
				header('Location:index.php?do=modules&action=modedit&mod=guestbook&moduleaction=1&cp=' . SESSION);
				exit;

			case '' :
			default :
				// ���� � ������� �� ������ �������� �� ����������, �����
				// �������� ��� ��������� ��� ������ � �������� �� � ������
				$AVE_Template->assign('settings', $this->_guestbookSettingsGet());

				if (empty ($_REQUEST['sort'])) $_REQUEST['sort'] = 'asc';
				if ($_REQUEST['sort'] != 'asc') $_REQUEST['sort'] = 'desc';

				$limit = (!empty ($_REQUEST['pp']) && is_numeric($_REQUEST['pp'])) ? $_REQUEST['pp'] : '15';

				// �������� ���������� ���������
				$num = $AVE_DB->Query("SELECT COUNT(*) FROM " . PREFIX . "_modul_guestbook_post")->GetCell();

				// ��������� ��������� ����� �����������
				if ($num > $limit)
				{
					$page_nav = " <a class=\"page_navigation\" href=\"index.php?do=modules&action=modedit&mod=guestbook&moduleaction=1&cp=" . SESSION . "&pp=" . $limit . "&sort=" . $_REQUEST['sort'] . "&page={s}\">{t}</a> ";
					$page_nav = get_pagination(ceil($num / $limit), 'page', $page_nav);
					$AVE_Template->assign('pnav', $page_nav);
				}

				$start = get_current_page() * $limit - $limit;

				//�������� ��������� ������� ����� �������� � ����������� �� ��������
				$sql = $AVE_DB->Query("
					SELECT *
					FROM " . PREFIX . "_modul_guestbook_post
					ORDER BY id " . $_REQUEST['sort'] . "
					LIMIT " . $start . "," . $limit
				);
				$inserts = array();
				while ($row = $sql->FetchRow())
				{
					array_push($inserts, $row);
				}

				$AVE_Template->assign('comments_array', $inserts);
				$AVE_Template->assign('content', $AVE_Template->fetch($tpl_dir . 'admin_conf.tpl'));
				break;
		}
	}

	/**
	 * ����� ���������� ����������� (���������, �������� � �.�.)
	 *
	 */
	function guestbookPostEdit()
	{
		global $AVE_DB;

		if (count($_POST['author']) > 0)
		{
			foreach ($_POST['author'] as $id => $author)
			{
				$AVE_DB->Query("
					UPDATE " . PREFIX . "_modul_guestbook_post
					SET
						" . (isset($_POST['approve'][$id]) ? "guestbook_post_approve = '" . $_POST['approve'][$id] . "'," : '') . "
						guestbook_post_author_name  = '" . $author . "',
						guestbook_post_author_email = '" . $_POST['email'][$id] . "',
						guestbook_post_author_web   = '" . $_POST['web'][$id] . "',
						guestbook_post_author_sity  = '" . $_POST['sity'][$id] . "',
						guestbook_post_text         = '" . $_POST['post_text'][$id] . "'
					WHERE
						id = '" . $id . "'
				");
			}
		}

		if (count($_POST['del']) > 0)
		{
			foreach ($_POST['del'] as $id => $del)
			{
				$AVE_DB->Query("DELETE FROM " . PREFIX . "_modul_guestbook_post WHERE id = '" . $id . "'");
				$AVE_DB->Query("ALTER TABLE " . PREFIX . "_modul_guestbook_post PACK_KEYS = 0 CHECKSUM = 0 DELAY_KEY_WRITE = 0 AUTO_INCREMENT = 1");
			}
		}

		header('Location:index.php?do=modules&action=modedit&mod=guestbook&moduleaction=1&cp=' . SESSION);
		exit;
	}
}

?>