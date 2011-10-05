<?php

/**
 * AVE.cms
 *
 * @package AVE.cms
 * @filesource
 */

/**
 * Êëàññ óïğàâëåíèÿ íàñòğîéêàìè ñèñòåìû
 */
class AVE_Settings
{
/**
 *	ÑÂÎÉÑÒÂÀ
 */

	/**
	 * Êîëè÷åñòâî ñòğàí íà ñòğàíèöå
	 *
	 * @var int
	 */
	var $_limit = 15;

/**
 *	ÂÍÓÒĞÅÍÍÈÅ ÌÅÒÎÄÛ
 */

	function _clearCode($code)
	{
		return preg_replace(
			array("'<'",   "'>'",   "'<b>'i",   "'</b>'i", "'<i>'i", "'</i>'i", "'<br>'i", "'<br/>'i"),
			array('&lt;', '&gt;', '<strong>', '</strong>',   '<em>',   '</em>',  '<br />',   '<br />'),
			$code);
	}

/**
 *	ÂÍÅØÍÈÅ ÌÅÒÎÄÛ
 */

	/**
	 * Ìåòîä îòîáğàæåíèÿ íàñòğîåê
	 *
	 */
	function settingsShow()
	{
		global $AVE_Template;

		$date_formats = array(
			'%d.%m.%Y',
			'%d %B %Y',
			'%A, %d.%m.%Y',
			'%A, %d %B %Y'
		);

		$time_formats = array(
			'%d.%m.%Y, %H:%M',
			'%d %B %Y, %H:%M',
			'%A, %d.%m.%Y (%H:%M)',
			'%A, %d %B %Y (%H:%M)'
		);

		$AVE_Template->assign('date_formats', $date_formats);
		$AVE_Template->assign('time_formats', $time_formats);
		$AVE_Template->assign('row', get_settings());
		$AVE_Template->assign('available_countries', get_country_list(1));
		$AVE_Template->assign('content', $AVE_Template->fetch('settings/settings_main.tpl'));
	}

	/**
	 * Ìåòîä çàïèñè íàñòğîåê
	 *
	 */
	function settingsSave()
	{
		global $AVE_DB;

		$muname = (!empty($_REQUEST['mail_smtp_login']))    ? "mail_smtp_login = '" . $_REQUEST['mail_smtp_login'] . "',"       : '';
		$mpass  = (!empty($_REQUEST['mail_smtp_pass']))     ? "mail_smtp_pass = '" . $_REQUEST['mail_smtp_pass'] . "',"         : '';
		$msmp   = (!empty($_REQUEST['mail_sendmail_path'])) ? "mail_sendmail_path = '" . $_REQUEST['mail_sendmail_path'] . "'," : '';
		$mn     = (!empty($_REQUEST['mail_from_name']))     ? "mail_from_name = '" . $_REQUEST['mail_from_name'] . "',"         : '';
		$ma     = (!empty($_REQUEST['mail_from']))          ? "mail_from = '" . $_REQUEST['mail_from'] . "',"                   : '';
		$ep     = (!empty($_REQUEST['page_not_found_id']))  ? "page_not_found_id = '" . $_REQUEST['page_not_found_id'] . "',"   : '';
		$sn     = (!empty($_REQUEST['site_name']))          ? "site_name = '" . $_REQUEST['site_name'] . "',"                   : '';
		$mp     = (!empty($_REQUEST['mail_port']))          ? "mail_port = '" . $_REQUEST['mail_port'] . "',"                   : '';
		$mh     = (!empty($_REQUEST['mail_host']))          ? "mail_host = '" . $_REQUEST['mail_host'] . "',"                   : '';

		$AVE_DB->Query("
			UPDATE " . PREFIX . "_settings
			SET
				" . $muname . "
				" . $mpass . "
				" . $msmp . "
				" . $ma . "
				" . $mn . "
				" . $ep . "
				" . $sn . "
				" . $mp . "
				" . $mh . "
				default_country   = '" . $_REQUEST['default_country'] . "',
				mail_type         = '" . $_REQUEST['mail_type'] . "',
				mail_content_type = '" . $_REQUEST['mail_content_type'] . "',
				mail_word_wrap    = '" . $_REQUEST['mail_word_wrap'] . "',
				mail_new_user     = '" . $_REQUEST['mail_new_user'] . "',
				mail_signature    = '" . $_REQUEST['mail_signature'] . "',
                message_forbidden = '" . $_REQUEST['message_forbidden'] . "',
				hidden_text       = '" . $_REQUEST['hidden_text'] . "',
				navi_box          = '" . $_REQUEST['navi_box'] . "',
				total_label       = '" . $this->_clearCode($_REQUEST['total_label']) . "',
				start_label       = '" . $this->_clearCode($_REQUEST['start_label']) . "',
				end_label         = '" . $this->_clearCode($_REQUEST['end_label']) . "',
				separator_label   = '" . $this->_clearCode($_REQUEST['separator_label']) . "',
				next_label        = '" . $this->_clearCode($_REQUEST['next_label']) . "',
				prev_label        = '" . $this->_clearCode($_REQUEST['prev_label']) . "',
				date_format       = '" . $_REQUEST['date_format'] . "',
				time_format       = '" . $_REQUEST['time_format'] . "',
				use_doctime       = '" . intval($_REQUEST['use_doctime']) . "',
				use_editor       = '" . intval($_REQUEST['use_editor']) . "'
			WHERE
				Id = 1
		");

		reportLog($_SESSION['user_name'] . ' - èçìåíèë îáùèå íàñòğîéêè ñèñòåìû', 2, 2);
	}

	/**
	 * Ìåòîä îòîáğàæåíèÿ ñïèñêà ñòğàí
	 *
	 */
	function settingsCountriesList()
	{
		global $AVE_DB, $AVE_Template;

		$sql = $AVE_DB->Query("
			SELECT SQL_CALC_FOUND_ROWS *
			FROM " . PREFIX . "_countries
			ORDER BY country_status ASC, country_name ASC
			LIMIT " . (get_current_page() * $this->_limit - $this->_limit) . "," . $this->_limit
		);

		$laender = array();
		while ($row = $sql->FetchAssocArray())
		{
			array_push($laender, $row);
		}

		$num = $AVE_DB->Query("SELECT FOUND_ROWS()")->GetCell();

		if ($num > $this->_limit)
		{
			$page_nav = " <a class=\"pnav\" href=\"index.php?do=settings&sub=countries&page={s}&amp;cp=" . SESSION . "\">{t}</a> ";
			$page_nav = get_pagination(ceil($num / $this->_limit), 'page', $page_nav);
			$AVE_Template->assign('page_nav', $page_nav);
		}

		$AVE_Template->assign('laender', $laender);
		$AVE_Template->assign('content', $AVE_Template->fetch('settings/settings_countries.tpl'));
	}

	/**
	 * Ìåòîä çàïèñè ïàğàìåòğîâ ñòğàí
	 *
	 */
	function settingsCountriesSave()
	{
		global $AVE_DB;

		foreach ($_POST['country_name'] as $id => $country_name)
		{
			$AVE_DB->Query("
				UPDATE " . PREFIX . "_countries
				SET
					country_name   = '" . $country_name . "',
					country_status = '" . $_POST['country_status'][$id] . "',
					country_eu     = '" . $_POST['country_eu'][$id] . "'
				WHERE
					Id = '" . $id . "'
			");
		}
	}
}

?>