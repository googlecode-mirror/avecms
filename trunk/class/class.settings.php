<?php

/**
 * AVE.cms
 *
 * @package AVE.cms
 * @filesource
 */

/**
 * Класс управления настройками системы
 */
class AVE_Settings
{

	var $_climit = 25;

	function displaySettings()
	{
		global $AVE_DB, $AVE_Template;

		switch ($_REQUEST['sub'])
		{
			case 'save':
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
						use_doctime       = '" . intval($_REQUEST['use_doctime']) . "'
					WHERE
						Id = 1
				");

				reportLog($_SESSION['user_name'] . ' - изменил общие настройки системы', 2, 2);
				header('Location:index.php?do=settings&cp=' . SESSION . '&saved=1');
				exit;
				break;

			case '':
				global $AVE_Globals;
				$AVE_Globals = new AVE_Globals;

				$day = $this->_dayFormatReplace(date('l'));
				$month = $this->_monthFormatReplace(date('F'));

				$dateFormat = array(
					array('format' => 'd.m.Y',          'view' => date('d.m.Y')),
					array('format' => 'd.m.Y, H:i',     'view' => date('d.m.Y, H:i')),
					array('format' => 'd F Y',          'view' => date('d ' . $month . ' Y')),
					array('format' => 'd F Y, H:i',     'view' => date('d ' . $month . ' Y, H:i')),
					array('format' => 'l, d.m.Y',       'view' => date($day . ', d.m.Y')),
					array('format' => 'l, d.m.Y (H:i)', 'view' => date($day . ', d.m.Y (H:i)')),
					array('format' => 'l, d F Y',       'view' => date($day . ', d ' . $month . ' Y')),
					array('format' => 'l, d F Y (H:i)', 'view' => date($day . ', d ' . $month . ' Y (H:i)'))
				);

				$AVE_Template->assign('dateFormat', $dateFormat);
				$AVE_Template->assign('row', $AVE_Globals->mainSettings());
				$AVE_Template->assign('available_countries', $AVE_Globals->fetchCountries());
				$AVE_Template->assign('content', $AVE_Template->fetch('settings/settings_main.tpl'));
				break;

			case 'countries':
				if (isset($_REQUEST['save']) && $_REQUEST['save'] == 1)
				{
					foreach ($_POST['LandName'] as $id => $LandName)
					{
						$AVE_DB->Query("
							UPDATE " . PREFIX . "_countries
							SET
								LandName = '" . $LandName . "',
								Aktiv    = '" . $_POST['Aktiv'][$id] . "',
								IstEU    = '" . $_POST['IstEU'][$id] . "'
							WHERE
								Id       = '" . $id . "'
						");
					}

					header('Location:index.php?do=settings&sub=countries');
					exit;
				}

				$sql = $AVE_DB->Query("
					SELECT SQL_CALC_FOUND_ROWS *
					FROM " . PREFIX . "_countries
					ORDER BY Aktiv ASC
					LIMIT " . (prepage() * $this->_climit - $this->_climit) . "," . $this->_climit
				);

				$laender = array();
				while ($row = $sql->FetchAssocArray())
				{
					array_push($laender, $row);
				}

				$num = $AVE_DB->Query("SELECT FOUND_ROWS()")
					->GetCell();

				$sql->Close();

				if ($num > $this->_climit)
				{
					$page_nav = pagenav(ceil($num / $this->_climit), 'page',
						" <a class=\"pnav\" href=\"index.php?do=settings&sub=countries&page={s}&amp;cp=" . SESSION . "\">{t}</a> ");
					$AVE_Template->assign('page_nav', $page_nav);
				}

				$AVE_Template->assign('laender', $laender);
				$AVE_Template->assign('content', $AVE_Template->fetch('settings/settings_countries.tpl'));
				break;

			case 'clearcache':
				$AVE_Template->clear_all_cache();
				$AVE_Template->clear_compiled_tpl();

				$filename = $AVE_Template->cache_dir . '/.htaccess';
				if (!file_exists($filename))
				{
					$fp = @fopen($filename, 'w');
					if ($fp)
					{
						fputs($fp, 'Deny from all');
						fclose($fp);
					}
				}

				$filename = $AVE_Template->compile_dir . '/.htaccess';
				if (!file_exists($filename))
				{
					$fp = @fopen($filename, 'w');
					if ($fp)
					{
						fputs($fp, 'Deny from all');
						fclose($fp);
					}
				}

				reportLog($_SESSION['user_name'] . ' - Очистил кэш', 2, 2);
				exit();
				break;
		}
	}

	function _clearCode($code)
	{
		return preg_replace(
			array("'<'",   "'>'",   "'<b>'i",   "'</b>'i", "'<i>'i", "'</i>'i", "'<br>'i", "'<br/>'i"),
			array('&lt;', '&gt;', '<strong>', '</strong>',   '<em>',   '</em>',  '<br />',   '<br />'),
			$code);
	}

	function _monthFormatReplace($month)
	{
		switch ($month)
		{
			case 'January':   $month = 'января';   break;
			case 'February':  $month = 'февраля';  break;
			case 'March':     $month = 'марта';    break;
			case 'April':     $month = 'апреля';   break;
			case 'May':       $month = 'мая';      break;
			case 'June':      $month = 'июня';     break;
			case 'July':      $month = 'июля';     break;
			case 'August':    $month = 'августа';  break;
			case 'September': $month = 'сентября'; break;
			case 'October':   $month = 'октября';  break;
			case 'November':  $month = 'ноября';   break;
			case 'December':  $month = 'декабря';  break;
		}

		return $month;
	}

	function _dayFormatReplace($day)
	{
		switch ($day)
		{
			case 'Sunday':    $day = 'Воскресенье'; break;
			case 'Monday':    $day = 'Понедельник'; break;
			case 'Tuesday':   $day = 'Вторник';     break;
			case 'Wednesday': $day = 'Среда';       break;
			case 'Thursday':  $day = 'Четверг';     break;
			case 'Friday':    $day = 'Пятница';     break;
			case 'Saturday':  $day = 'Суббота';     break;
		}

		return $day;
	}
}

?>