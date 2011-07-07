<?php

/**
 * �����, ���������� ��� �������� � ������ ��� ���������� ���������� ���������� ��� � ��������� ����� �����,
 * ��� � � ������ ����������.
 *
 * @package AVE.cms
 * @subpackage module_Counter
 * @since 1.4
 * @filesource
 */
class Counter
{

/**
 *	�������� ������
 */

	/**
	 * ���������� ����� ��� ������ ���������� � �������
	 *
	 * @var int
	 */
	var $_limit = 25;

/**
 *	���������� ������ ������
 */

	/**
	 * �����, �������������� ��� �������� �� �� ���������� � ��������� �������� (��, �������, ����� � �.�.)
	 *
	 * @param int $id - ������������� ��������
	 * @return array
	 * 	all   - ����� ���������� �������
	 * 	today - ���������� ������� �� ������� ����
	 * 	yestd - ���������� ������� �� ��������� ����
	 * 	prevm - ���������� ������� �� ���������� �����
	 * 	prevy - ���������� ������� �� ���������� ���
	 */
	function _counterStatisticGet($id)
	{
		global $AVE_DB;

        // ��������� �������, ��������� ������ � �� �� ��������� ���������� �� ��������� ������� �������
		$sql = $AVE_DB->Query("
			SELECT COUNT(*) AS visits
			FROM " . PREFIX . "_modul_counter_info
			WHERE counter_id = '" . $id . "'
			UNION ALL
			SELECT COUNT(*) AS visits
			FROM " . PREFIX . "_modul_counter_info
			WHERE counter_id = '" . $id . "'
			AND counter_expire_time = " . mktime(23,59,59) . "
			UNION ALL
			SELECT COUNT(*) AS visits
			FROM " . PREFIX . "_modul_counter_info
			WHERE counter_id = '" . $id . "'
			AND counter_expire_time = " . mktime(0,0,-1) . "
			UNION ALL
			SELECT COUNT(*) AS visits
			FROM " . PREFIX . "_modul_counter_info
			WHERE counter_id = '" . $id . "'
			AND (counter_expire_time
				BETWEEN " . mktime(0,0,0,date('m'),1) . "
				AND " . mktime(0,0,-1,date('m')+1,1) . ")
			UNION ALL
			SELECT COUNT(*) AS visits
			FROM " . PREFIX . "_modul_counter_info
			WHERE counter_id = '" . $id . "'
			AND (counter_expire_time
				BETWEEN " . mktime(0,0,0,1,1) . "
				AND " . mktime(0,0,-1,1,1,date('Y')+1) . ")
		");

		// ��������� � ���������� ���������� ������
        $row['all']       = $sql->fetchRow()->visits;
		$row['today']     = $sql->fetchRow()->visits;
		$row['yesterday'] = $sql->fetchRow()->visits;
		$row['prevmonth'] = $sql->fetchRow()->visits;
		$row['prevyear']  = $sql->fetchRow()->visits;

		return $row;
	}

/**
 *	������� ������ ������
 */

	/**
	 * �����, ��������������� ��� ��������� ���������� � �������, �������� COOKIE ����� ������ �� ����� �
     * ������ � ��, ���� ������� ������� ��� ���.
	 *
	 * @param int $id - ������������� ��������
	 */
	function counterClientNew($id)
	{
		global $AVE_DB;

		// ���������� IP ����� �������
        if (!empty($_SERVER['REMOTE_ADDR']))
		{
			$ip = $_SERVER['REMOTE_ADDR'];
		}
		else
		{
			$ip = $_SERVER['HTTP_CLIENT_IP'];
		}

        // �������� ���������� ������� �� �� � ������ �������
		$exist = $AVE_DB->Query("
			SELECT 1
			FROM " . PREFIX . "_modul_counter_info
			WHERE counter_client_ip = '" . addslashes($ip) . "'
			AND counter_id = '" . $id. "'
			AND counter_expire_time > '" . time() . "'
			LIMIT 1
		")->NumRows();

		// ������������� ���� ����� COOKIE �����
        $counter_expire_time  = mktime(23, 59, 59);
		setcookie('counter_' . $id, '1', $counter_expire_time);

		// ���� ���������� � ������ ������� �� ������� � ��
        if (! $exist)
		{
			$referer = '';
			// �������� �������
            if (isset($_SERVER['HTTP_REFERER']))
			{
				$referer = urldecode(trim($_SERVER['HTTP_REFERER']));
				$referer = iconv("UTF-8", "WINDOWS-1251", $referer);
			}

			// ���������� ������, ��������������� ��� ��������� ��������� ���������� � ������������
            // (������������ �������, ������� � �.�.)
            include_once(BASE_DIR . '/modules/counter/phpSniff.core.php');
			include_once(BASE_DIR . '/modules/counter/phpSniff.class.php');
			$settings = array(
				'check_cookies'=>'',
				'default_language'=>'',
				'allow_masquerading'=>''
			);
			$client = new phpSniff('', $settings);

            // ��������� ������ � �� �� ������ ���������� ����������
			$AVE_DB->Query("
				INSERT
				INTO " . PREFIX . "_modul_counter_info
				SET
					counter_id             = '" . $id . "',
					counter_client_ip      = '" . addslashes($ip) . "',
					counter_client_os      = '" . $client->property('platform') . ' ' . $client->property('os') . "',
					counter_client_browser = '" . $client->property('long_name') . ' ' . $client->property('version') . "',
					counter_client_referer = '" . addslashes($referer) . "',
					counter_visit_time     = '" . time() . "',
					counter_expire_time    = '" . $counter_expire_time . "'
			");
		}
	}

	/**
	 * �����, ��������������� ��� �������� ������ �������� � ������ ����������
	 *
	 */
	function counterNew()
	{
		global $AVE_DB;

		// ��������� ������ � �� �� ���������� ������ ��������
        $AVE_DB->Query("
			INSERT
			INTO " . PREFIX . "_modul_counter
			SET
				id = '',
				counter_title = '" . htmlspecialchars($_POST['counter_title']) . "'
		");

		// ��������� ���������� ��������
        header('Location:index.php?do=modules&action=modedit&mod=counter&moduleaction=1&cp=' . SESSION);
		exit;
	}

	/**
	 * �����, ��������������� ��� ���������� ��������� � ��������� (�������� �� ��� ������������� � ������ ����������),
	 * ���� ��� �������� ��������� �� �������.
	 */
	function counterSettingsSave()
	{
		global $AVE_DB;

		// ���������� ������������ ��� �������� � ��������� ���������� � ��� � ��
        foreach($_POST['counter_title'] as $id => $counter_title)
		{
			$AVE_DB->Query("
				UPDATE  " . PREFIX . "_modul_counter
				SET counter_title ='" . $counter_title . "'
				WHERE id = '" . $id . "'
			");
		}

        // ���������� ������������ ��� �������� � ������� ��, ������� ���� �������� �� ��������.
        // �����, ������ � ��������� ��������, ���������� �������� ���� ��������� �� ����������.
		foreach($_POST['del'] as $id => $del)
		{
			$AVE_DB->Query("
				DELETE
				FROM " . PREFIX . "_modul_counter
				WHERE id = '" . $id . "'
			");

			$AVE_DB->Query("
				DELETE
				FROM " . PREFIX . "_modul_counter_info
				WHERE counter_id = '" . $id . "'
			");
		}

        // ��������� ���������� ��������
		header('Location:index.php?do=modules&action=modedit&mod=counter&moduleaction=1&cp=' . SESSION);
		exit;
	}



    /**
	 * �����, ��������������� ��� ������ ������ ���� ��������� � �������
	 *
	 * @param string $tpl_dir - ���� � ����� � ��������� ������
	 * @param string $lang_file - ���� � ��������� ����� ������
	 */
	function counterList($tpl_dir, $lang_file)
	{
		global $AVE_DB, $AVE_Template;

		// ��������� ������ � �� �� ��������� ���� ���������
        $sql = $AVE_DB->Query("
			SELECT *
			FROM " . PREFIX . "_modul_counter
			ORDER BY id ASC
		");

		// ��������� ������ ������
        $items = array();
		while ($row = $sql->FetchRow())
		{
			$stat = $this->_counterStatisticGet($row->id);

			$row->all       = $stat['all'];
			$row->today     = $stat['today'];
			$row->yesterday = $stat['yesterday'];
			$row->prevmonth = $stat['prevmonth'];
			$row->prevyear  = $stat['prevyear'];

			array_push($items, $row);
		}

    	// �������� ������ � ������ ��� ������
        $AVE_Template->assign('items', $items);

		$AVE_Template->config_load($lang_file, 'admin');

		// ���������� �������� � �������
        $AVE_Template->assign('content', $AVE_Template->fetch($tpl_dir . 'admin_counter.tpl'));
	}


    /**
	 * �����, ��������������� ��� ��������� ��������� ���������� �� ������-���� ��������
	 *
	 * @param string $tpl_dir - ���� � ����� � ��������� ������
	 * @param string $lang_file - ���� � ��������� ����� ������
	 */
	function counterRefererList($tpl_dir, $lang_file)
	{
		global $AVE_DB, $AVE_Template;

		// ���������� ����� ���������� ������
        $sort = ' ORDER BY counter_visit_time DESC';
		$sort_navi = '';

		// ��������� �������������� ������� ��� ������� � �� � ������ ����������
        if (!empty($_REQUEST['sort']))
		{
			switch($_REQUEST['sort'])
			{
				case 'visit_desc' :
					$sort = ' ORDER BY counter_visit_time DESC';
					$sort_navi = '&amp;sort=visit_desc';
					break;

				case 'visit_asc' :
					$sort = ' ORDER BY counter_visit_time ASC';
					$sort_navi = '&amp;sort=visit_asc';
					break;

				case 'ip_desc' :
					$sort = ' ORDER BY counter_client_ip DESC';
					$sort_navi = '&amp;sort=ip_desc';
					break;

				case 'ip_asc' :
					$sort = ' ORDER BY counter_client_ip ASC';
					$sort_navi = '&amp;sort=ip_asc';
					break;

				case 'referer_desc' :
					$sort = ' ORDER BY counter_client_referer DESC';
					$sort_navi = '&amp;sort=referer_desc';
					break;

				case 'referer_asc' :
					$sort = ' ORDER BY counter_client_referer ASC';
					$sort_navi = '&amp;sort=referer_asc';
					break;

				case 'os_desc' :
					$sort = ' ORDER BY counter_client_os DESC';
					$sort_navi = '&amp;sort=os_desc';
					break;

				case 'os_asc' :
					$sort = ' ORDER BY counter_client_os ASC';
					$sort_navi = '&amp;sort=os_asc';
					break;

				case 'browser_desc' :
					$sort = ' ORDER BY counter_client_browser DESC';
					$sort_navi = '&amp;sort=browser_desc';
					break;

				case 'browser_asc' :
					$sort = ' ORDER BY counter_client_browser ASC';
					$sort_navi = '&amp;sort=browser_asc';
					break;
			}
		}

		// ���������� ������ ��������� ������ ������
        $start = get_current_page() * $this->_limit - $this->_limit;

    	// ��������� ������ � �� � ������ ���� ���������� � ������ ������� ��� ������ �� ��������
        $sql = $AVE_DB->Query("
			SELECT SQL_CALC_FOUND_ROWS *
			FROM " . PREFIX . "_modul_counter_info
			WHERE counter_id = '" . intval($_REQUEST['id']) . "'
			" . $sort . "
			LIMIT " . $start . "," . $this->_limit
		);

		// ��������� ������ �� ���������� ������
        $items = array();
		while($row = $sql->FetchRow())
		{
			array_push($items, $row);
		}

		$num = $AVE_DB->Query("SELECT FOUND_ROWS()")->GetCell();

		// ���� ���������� ������� ��������� ���������� ������ �� ��������, ��������� ������������ ���������
        if($num > $this->_limit)
		{
			$seiten = ceil($num / $this->_limit);
			$page_nav = " <a class=\"pnav\" href=\"index.php?do=modules&action=modedit&mod=counter&moduleaction=view_referer&cp=" . SESSION
				. '&id=' . intval($_REQUEST['id']) . '&pop=1&page={s}' . $sort_navi . "\">{t}</a> ";
			$page_nav = get_pagination($seiten, 'page', $page_nav);
			$AVE_Template->assign('page_nav', $page_nav);
		}

		// �������� ������ � ������ ��� �������
        $AVE_Template->assign('items', $items);

		$AVE_Template->config_load($lang_file, 'admin');

		// ����������� ���� � �������
        $AVE_Template->assign('content', $AVE_Template->fetch($tpl_dir . 'admin_entries.tpl'));
	}




    /**
	 * �����, ��������������� ��� ������ ���������� � ������������� �������� � ��������� ����� �����.
	 *
	 * @param string $tpl_dir - ���� � ����� � ��������� ������
	 * @param string $lang_file - ���� � ��������� ����� ������
	 * @param int $id - ������������� ��������
	 */
	function counterStatisticShow($tpl_dir, $lang_file, $id)
	{
		global $AVE_Template;

		// ���� ��� ����� ������ (� ������ ��� ���������� � ���� ���� �� ����������)
        if (! (empty($_SERVER['REMOTE_ADDR']) && empty($_SERVER['HTTP_CLIENT_IP'])) &&
			! (isset($_COOKIE['counter_' . $id]) && $_COOKIE['counter_' . $id] == '1'))
		{
			// ��������� ���������� � ������� � �� � ������� COOKIE-����
            $this->counterClientNew($id);
		}

		$AVE_Template->config_load($lang_file, 'user');

		// �������� ������ �� ��
        $AVE_Template->assign($this->_counterStatisticGet($id));

		// �������� ������ � ���������� ������ � ��������� �����
        $AVE_Template->display($tpl_dir . 'show_stat-' . $id . '.tpl');
	}
}

?>