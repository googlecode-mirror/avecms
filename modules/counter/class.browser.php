<?php

/**
 * Êëàññ îáğàáîòêè ñòàòèñòèêè âèçèòîâ
 *
 * @package AVE.cms
 * @subpackage module_Counter
 * @filesource
 */
class Counter
{

/**
 *	ÑÂÎÉÑÒÂÀ
 */

	/**
	 * Êîëè÷åñòâî ñòğîê ïğè âûâîäå èíôîğìàöèè î âèçèòàõ
	 *
	 * @var int
	 */
	var $_limit = 25;

/**
 *	ÂÍÓÒĞÅÍÍÈÅ ÌÅÒÎÄÛ
 */

	/**
	 * Âûáîğêà ñâîäíîé ñòàòèñòèêè èç áàçû
	 *
	 * @param int $id - èäåíòèôèêàòîğ ñ÷åò÷èêà
	 * @return array
	 * 	all   - îáùåå êîëè÷åñòâî âèçèòîâ
	 * 	today - êîëè÷åñòâî âèçèòîâ çà òåêóùèé äåíü
	 * 	yestd - êîëè÷åñòâî âèçèòîâ çà â÷åğàøíèé äåíü
	 * 	prevm - êîëè÷åñòâî âèçèòîâ çà ïğåäûäóùèé ìåñÿö
	 * 	prevy - êîëè÷åñòâî âèçèòîâ çà ïğåäûäóùèé ãîä
	 */
	function _counterStatisticGet($id)
	{
		global $AVE_DB;

		$sql = $AVE_DB->Query("
			SELECT COUNT(*) AS visits
			FROM " . PREFIX . "_modul_counter_info
			WHERE counter_id = '" . $id . "'
			UNION ALL
			SELECT COUNT(*) AS visits
			FROM " . PREFIX . "_modul_counter_info
			WHERE counter_id = '" . $id . "'
			AND expire = " . mktime(23,59,59) . "
			UNION ALL
			SELECT COUNT(*) AS visits
			FROM " . PREFIX . "_modul_counter_info
			WHERE counter_id = '" . $id . "'
			AND expire = " . (mktime(0,0,0)-1) . "
			UNION ALL
			SELECT COUNT(*) AS visits
			FROM " . PREFIX . "_modul_counter_info
			WHERE counter_id = '" . $id . "'
			AND (expire
				BETWEEN " . mktime(0,0,0,date('m'),1) . "
				AND " . (mktime(0,0,0,date('m')+1,1)-1) . ")
			UNION ALL
			SELECT COUNT(*) AS visits
			FROM " . PREFIX . "_modul_counter_info
			WHERE counter_id = '" . $id . "'
			AND (expire
				BETWEEN " . mktime(0,0,0,1,1) . "
				AND " . (mktime(0,0,0,1,1,date('Y')+1)-1) . ")
		");

		$row['all']       = $sql->fetchRow()->visits;
		$row['today']     = $sql->fetchRow()->visits;
		$row['yesterday'] = $sql->fetchRow()->visits;
		$row['prevmonth'] = $sql->fetchRow()->visits;
		$row['prevyear']  = $sql->fetchRow()->visits;

		return $row;
	}

/**
 *	ÂÍÅØÍÈÅ ÌÅÒÎÄÛ
 */

	/**
	 * Îáğàáîòêà òıãà ñ÷åò÷èêà
	 *
	 * @param int $id - èäåíòèôèêàòîğ ñ÷åò÷èêà
	 */
	function counterClientNew($id)
	{
		global $AVE_DB;

		if (!empty($_SERVER['REMOTE_ADDR']))
		{
			$ip = $_SERVER['REMOTE_ADDR'];
		}
		else
		{
			$ip = $_SERVER['HTTP_CLIENT_IP'];
		}

		$exist = $AVE_DB->Query("
			SELECT 1
			FROM " . PREFIX . "_modul_counter_info
			WHERE client_ip = '" . addslashes($ip) . "'
			AND counter_id = '" . $id. "'
			AND expire > '" . time() . "'
			LIMIT 1
		")->NumRows();

		$expire  = mktime(23, 59, 59);
		setcookie('counter_' . $id, '1', $expire);

		if (! $exist)
		{
			$referer = '';
			if (isset($_SERVER['HTTP_REFERER']))
			{
				$referer = urldecode(trim($_SERVER['HTTP_REFERER']));
				$referer = iconv("UTF-8", "WINDOWS-1251", $referer);
			}

			include_once(BASE_DIR . '/modules/counter/phpSniff.core.php');
			include_once(BASE_DIR . '/modules/counter/phpSniff.class.php');
			$settings = array(
				'check_cookies'=>'',
				'default_language'=>'',
				'allow_masquerading'=>''
			);
			$client = new phpSniff('', $settings);

			$AVE_DB->Query("
				INSERT
				INTO " . PREFIX . "_modul_counter_info
				SET
					counter_id     = '" . $id . "',
					client_ip      = '" . addslashes($ip) . "',
					client_os      = '" . $client->property('platform') . ' ' . $client->property('os') . "',
					client_browser = '" . $client->property('long_name') . ' ' . $client->property('version') . "',
					client_referer = '" . addslashes($referer) . "',
					visit          = '" . time() . "',
					expire         = '" . $expire . "'
			");
		}
	}

	/**
	 * Ñîçäàíèå íîâîãî ñ÷åò÷èêà
	 *
	 */
	function counterNew()
	{
		global $AVE_DB;

		$AVE_DB->Query("
			INSERT
			INTO " . PREFIX . "_modul_counter
			SET
				id = '',
				counter_name = '" . htmlspecialchars($_POST['counter_name']) . "'
		");

		header('Location:index.php?do=modules&action=modedit&mod=counter&moduleaction=1&cp=' . SESSION);
		exit;
	}

	/**
	 * Çàïèñü ïàğàìåòğîâ ñ÷åò÷èêà
	 *
	 */
	function counterSettingsSave()
	{
		foreach($_POST['counter_name'] as $id => $counter_name)
		{
			$AVE_DB->Query("
				UPDATE  " . PREFIX . "_modul_counter
				SET counter_name ='" . $counter_name . "'
				WHERE id = '" . $id . "'
			");
		}

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

		header('Location:index.php?do=modules&action=modedit&mod=counter&moduleaction=1&cp=' . SESSION);
		exit;
	}

	/**
	 * Ñïèñîê ñ÷åò÷èêîâ â àäìèíïàíåëè
	 *
	 * @param string $tpl_dir - ïóòü ê ïàïêå ñ øàáëîíàìè ìîäóëÿ
	 * @param string $lang_file - ïóòü ê ÿçûêîâîìó ôàéëó ìîäóëÿ
	 */
	function counterList($tpl_dir, $lang_file)
	{
		global $AVE_DB, $AVE_Template;

		$sql = $AVE_DB->Query("
			SELECT *
			FROM " . PREFIX . "_modul_counter
			ORDER BY id ASC
		");

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

		$AVE_Template->assign('items', $items);

		$AVE_Template->config_load($lang_file, 'admin');

		$AVE_Template->assign('content', $AVE_Template->fetch($tpl_dir . 'admin_counter.tpl'));
	}

	/**
	 * Ïîäğîáíàÿ èíôîğìàöèÿ î âèçèòàõ
	 *
	 * @param string $tpl_dir - ïóòü ê ïàïêå ñ øàáëîíàìè ìîäóëÿ
	 * @param string $lang_file - ïóòü ê ÿçûêîâîìó ôàéëó ìîäóëÿ
	 */
	function counterRefererList($tpl_dir, $lang_file)
	{
		global $AVE_DB, $AVE_Template;

		$sort = ' ORDER BY visit DESC';
		$sort_navi = '';

		if (!empty($_REQUEST['sort']))
		{
			switch($_REQUEST['sort'])
			{
				case 'visit_desc' :
					$sort = ' ORDER BY visit DESC';
					$sort_navi = '&amp;sort=visit_desc';
					break;

				case 'visit_asc' :
					$sort = ' ORDER BY visit ASC';
					$sort_navi = '&amp;sort=visit_asc';
					break;

				case 'ip_desc' :
					$sort = ' ORDER BY client_ip DESC';
					$sort_navi = '&amp;sort=ip_desc';
					break;

				case 'ip_asc' :
					$sort = ' ORDER BY client_ip ASC';
					$sort_navi = '&amp;sort=ip_asc';
					break;

				case 'referer_desc' :
					$sort = ' ORDER BY client_referer DESC';
					$sort_navi = '&amp;sort=referer_desc';
					break;

				case 'referer_asc' :
					$sort = ' ORDER BY client_referer ASC';
					$sort_navi = '&amp;sort=referer_asc';
					break;

				case 'os_desc' :
					$sort = ' ORDER BY client_os DESC';
					$sort_navi = '&amp;sort=os_desc';
					break;

				case 'os_asc' :
					$sort = ' ORDER BY client_os ASC';
					$sort_navi = '&amp;sort=os_asc';
					break;

				case 'browser_desc' :
					$sort = ' ORDER BY client_browser DESC';
					$sort_navi = '&amp;sort=browser_desc';
					break;

				case 'browser_asc' :
					$sort = ' ORDER BY client_browser ASC';
					$sort_navi = '&amp;sort=browser_asc';
					break;
			}
		}

		$start = get_current_page() * $this->_limit - $this->_limit;

		$sql = $AVE_DB->Query("
			SELECT SQL_CALC_FOUND_ROWS *
			FROM " . PREFIX . "_modul_counter_info
			WHERE counter_id = '" . intval($_REQUEST['id']) . "'
			" . $sort . "
			LIMIT " . $start . "," . $this->_limit
		);

		$items = array();
		while($row = $sql->FetchRow())
		{
			array_push($items, $row);
		}

		$num = $AVE_DB->Query("SELECT FOUND_ROWS()")->GetCell();

		if($num > $this->_limit)
		{
			$seiten = ceil($num / $this->_limit);
			$page_nav = " <a class=\"pnav\" href=\"index.php?do=modules&action=modedit&mod=counter&moduleaction=view_referer&cp=" . SESSION
				. '&id=' . intval($_REQUEST['id']) . '&pop=1&page={s}' . $sort_navi . "\">{t}</a> ";
			$page_nav = get_pagination($seiten, 'page', $page_nav);
			$AVE_Template->assign('page_nav', $page_nav);
		}

		$AVE_Template->assign('items', $items);

		$AVE_Template->config_load($lang_file, 'admin');

		$AVE_Template->assign('content', $AVE_Template->fetch($tpl_dir . 'admin_entries.tpl'));
	}

	/**
	 * Âûâîä ñòàòèñòèêè â ïóáëè÷íîé ÷àñòè
	 *
	 * @param string $tpl_dir - ïóòü ê ïàïêå ñ øàáëîíàìè ìîäóëÿ
	 * @param string $lang_file - ïóòü ê ÿçûêîâîìó ôàéëó ìîäóëÿ
	 * @param int $id - èäåíòèôèêàòîğ ñ÷åò÷èêà
	 */
	function counterStatisticShow($tpl_dir, $lang_file, $id)
	{
		global $AVE_Template;

		if (! (empty($_SERVER['REMOTE_ADDR']) && empty($_SERVER['HTTP_CLIENT_IP'])) &&
			! (isset($_COOKIE['counter_' . $id]) && $_COOKIE['counter_' . $id] == '1'))
		{
			$this->counterClientNew($id);
		}

		$AVE_Template->config_load($lang_file, 'user');

		$AVE_Template->assign($this->_counterStatisticGet($id));

		$AVE_Template->display($tpl_dir . 'show_stat-' . $id . '.tpl');
	}
}

?>