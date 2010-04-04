<?php

/**
 * Класс работы с Гостевой книгой в публичной части
 *
 * @package AVE.cms
 * @subpackage module_Guestbook
 * @filesource
 */
class Guest_Module_Pub
{
	/**
	 * Метод генерации секретного кода
	 *
	 * @param int $c количество символов в секретном коде
	 * @return int
	 */
	function secureCode($c = 0)
	{
		global $AVE_DB;

		$tdel = time() - 1200;
		$AVE_DB->Query("DELETE FROM " . PREFIX . "_antispam WHERE Ctime < '" . $tdel . "'");
		$code = '';
		$chars = array(
			'A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'J', 'K', 'M', 'N',
			'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z',
			'a', 'b', 'c', 'd', 'e', 'f', 'g', 'h', 'j', 'k', 'm', 'n',
			'p', 'q', 'r', 's', 't', 'u', 'v', 'w', 'x', 'y', 'z',
			'2', '3', '4', '5', '6', '7', '8', '9'
		);
		$ch = ($c != 0) ? $c : 7;
		$count = count($chars) - 1;
		srand((double) microtime() * 1000000);
		for ($i = 0; $i < $ch; $i++)
		{
			$code .= $chars[rand(0, $count)];
		}

		$AVE_DB->Query("
			INSERT
			INTO " . PREFIX . "_antispam
			SET
				Id = '',
				Code = '" . $code . "',
				Ctime = '" . time() . "'
		");
		$codeid = $AVE_DB->InsertId();

		return $codeid;
	}

	/**
	 * Метод ограничения количества символов в сообщении
	 *
	 * @param string $text
	 * @param int $maxlength
	 * @return string
	 */
	function formtext($text, $maxlength)
	{
		$text = substr($text, 0, $maxlength);
		return $text;
	}

	/**
	 * Метод генерации списка для отображения (по 5 страниц, по 10 страниц и т.д.)
	 *
	 * @return array
	 */
	function ppsite()
	{
		$pps_array = array();
		for ($a = 5; $a <= 50; $a += 5)
		{
			unset ($pps_sel);
			if ($_REQUEST['pp'] == $a)
			{
				$pps_sel = 'selected';
			}
			array_push($pps_array, array('ps' => $a, 'pps_sel' => $pps_sel));
		}
		return $pps_array;
	}

	/**
	 * Метод получения списка всех смайлов
	 *
	 * @return string
	 */
	function listsmilies()
	{
		$row = $GLOBALS['AVE_DB']->Query("SELECT smiliebr FROM " . PREFIX . "_modul_guestbook_settings")->FetchRow();
		$smilie_id = 0;
		$smiliesw .= '<table border="0"><tr>';

		$sql = $GLOBALS['AVE_DB']->Query("
			SELECT
				code,
				path
			FROM " . PREFIX . "_modul_guestbook_smileys
			WHERE active = '1'
			ORDER BY posi ASC
		");
		while ($row_s = $sql->FetchRow())
		{
			$val = $row_s->code;
			$key = $row_s->path;
			$smiliesw .= '<td align="center">';
			$smiliesw .= '<a href="javascript:smilie(\'' . $val . '\')"><img hspace="2" vspace="2" src="modules/guestbook/smilies/' . $key . '" border="0" alt="" /></a>';
			$smilie_id++;
			$smiliesw .= '</td>';
			$edit = $row->smiliebr;
			if ($smilie_id == $edit)
			{
				$smiliesw .= '</tr><tr>';
				$smilie_id = 0;
			}

		}
		$smiliesw .= '</tr></table>';
		return $smiliesw;
	}

	/**
	 * Метод преобразования графических смайлов в их текстовый эквивалент
	 *
	 * @param string $texts
	 * @return string
	 */
	function dosmilies($texts)
	{
		$sql = $GLOBALS['AVE_DB']->Query("
			SELECT
				code,
				path
			FROM " . PREFIX . "_modul_guestbook_smileys
			WHERE active = '1'
		");
		while ($row_s = $sql->FetchRow())
		{
			$texts = @ str_replace($row_s->code, '<img src="modules/guestbook/smilies/' . $row_s->path . '" border="0" alt="" />', $texts);
		}
		return $texts;
	}

	/**
	 * Обработка bbCode для сообщений
	 *
	 * @param string $text
	 * @return string
	 */
	function kcodes_comments($text)
	{
		$row = $GLOBALS['AVE_DB']->Query("SELECT bbcodes FROM " . PREFIX . "_modul_guestbook_settings")->FetchRow();
		if ($row->bbcodes == 1)
		{
			$text = $this->pre_kcodes($text);
		}
		else
		{
			$text = nl2br(htmlspecialchars($text));
		}
		return $text;
	}

	/**
	 * Еще одна обрабтка bbCode
	 *
	 * @param string $text
	 * @return string
	 */
	function pre_kcodes($text)
	{
		$divheight = $this->divheight($text);
		$bwidth = '100';

		$head = '<div style="margin: 5px 0 0"><em>Программный код:</em></div><div class="divcode" style="margin:0; padding:5px; border:1px inset; width:' . $bwidth . '; height:' . $divheight . 'px; overflow:auto"><code style="white-space:nowrap">';
		$foot = '</code></div>';

		$head_quote = '<div style="MARGIN: 5px 0px 0px">%%boxtitle%%</div><div class="divcode" style="margin:0; padding:5px; border:1px inset; width:95%;"><span style="font-style:italic;">';
		$foot_quote = '</span></div>';

		$pstring = time() . mt_rand(0, 10000000);
		$treffer = '/\[php\](.*?)\[\/php\]/si';
		@ preg_match_all($treffer, $text, $erg);
		for ($i = 0; $i < count($erg[1]); $i++)
		{
			$text = str_replace($erg[1][$i], $pstring . $i . $pstring, $text);
		}

		$text = htmlspecialchars($text);
		$lines = explode(PHP_EOL, $text);
		$c_mlength = 1000;
		for ($n = 0; $n < count($lines); $n++)
		{
			$words = explode(' ', $lines[$n]);
			$pstringount_w = count($words) - 1;
			if ($pstringount_w >= 0)
			{
				for ($i = 0; $i <= $pstringount_w; $i++)
				{
					$max_length_word = $c_mlength;
					$tword = trim($words[$i]);
					$tword = preg_replace('/\[(.*?)\]/si', '', $tword);
					$displaybox = substr_count($tword, 'http://') + substr_count($tword, 'https://') + substr_count($tword, 'www.') + substr_count($tword, 'ftp://');
					if ($displaybox > 0)
					{
						$max_length_word = 200;
					}
					if (strlen($tword) > $max_length_word)
					{
						$words[$i] = chunk_split($words[$i], $max_length_word, '<br />');
						$length = strlen($words[$i]) - 5;
						$words[$i] = substr($words[$i], 0, $length);
					}
				}
				$lines[$n] = implode(' ', $words);
			}
			else
			{
				$lines[$n] = chunk_split($lines[$n], $max_length_word, '<br />');
			}
		}
		$text = implode(PHP_EOL, $lines);
		$text = nl2br($text);
		$text = preg_replace('#\[color=(\#?[\da-fA-F]{6}|[a-z\ \-]{3,})\](.*?)\[/color\]+#i', "<font color=\"\\1\">\\2</font>", $text);
		$text = preg_replace('#\[size=()?(.*?)\](.*?)\[/size\]#si', "<font size=\"\\2\">\\3</font>", $text);
		$text = preg_replace('#\[face=()?(.*?)\](.*?)\[/face\]#si', "<span style=\"font-family:\\2\">\\3</span>", $text);
		$text = preg_replace('#\[font=()?(.*?)\](.*?)\[/font\]#si', "<span style=\"font-family:\\2\">\\3</span>", $text);
		$text = preg_replace('!\[(?i)b\]!', '<b>', $text);
		$text = preg_replace('!\[/(?i)b\]!', '</b>', $text);
		$text = preg_replace('!\[(?i)u\]!', '<u>', $text);
		$text = preg_replace('!\[/(?i)u\]!', '</u>', $text);
		$text = preg_replace('!\[(?i)i\]!', '<i>', $text);
		$text = preg_replace('!\[/(?i)i\]!', '</i>', $text);
		$text = preg_replace('!\[(?i)url\](http://|ftp://)(.*?)\[/(?i)url\]+!', "<a href=\"\\1\\2\" target=\"_blank\">\\1\\2</a>", $text);
		$text = preg_replace('!\[(?i)url\](.*?)\[/(?i)url\]+!', "<a href=\"http://\\1\" target=\"_blank\">\\1</a>", $text);
		$text = preg_replace('#\[url=(http://)?(.*?)\](.*?)\[/url\]#si', "<a href=\"http://\\2\" target=\"_blank\">\\3</a>", $text);
		$text = preg_replace('!\[(?i)email\]([a-zA-Z0-9-._]+@[a-zA-Z0-9-.]+)\[/(?i)email\]!', "<a href=\"mailto:\\1\">\\1</a>", $text);
		$text = preg_replace('#\[email=()?(.*?)\](.*?)\[/email\]#si', "<a href=\"mailto:\\2\">\\3</a>", $text);
		$text = preg_replace('!\[(?i)img\]([_-a-zA-Z0-9:/\?\[\]=.@-]+)\[(?i)/img\]!', "<img src=\"\\1\" border=\"0\" alt=\"\" />", $text);
		$text = preg_replace('!\[(?i)IMG\]([_-a-zA-Z0-9:/\?\[\]=.@-]+)\[(?i)/IMG\]!', "<img src=\"\\1\" border=\"0\" alt=\"\" />", $text);
		$text = preg_replace('/\[code\](.*?)\[\/code\]/si', str_replace('%%boxtitle%%', $lang['code'], $head) . '\\1' . $foot, $text);
		$text = preg_replace('!\[(?i)quote\]!', str_replace('%%boxtitle%%', '<em>Цитата:</em>', $head_quote), $text);
		$text = preg_replace('!\[/(?i)quote\]!', $foot_quote, $text);
		$text = preg_replace('/\[list\](.*?)\[\/list\]/si', "<ul>\\1</ul>", $text);
		$text = preg_replace('/\[list=(.*?)\](.*?)\[\/list\]/si', "<ol type=\"\\1\">\\2</ol>", $text);
		$text = preg_replace('/\[\*\](.*?)\\n/si', "<li>\\1</li>", $text);

		for ($i = 0; $i < count($erg[1]); $i++)
		{
			ob_start();
			@ highlight_string(trim($erg[1][$i]));
			$highlight_string = ob_get_contents();
			ob_end_clean();
			$displaybox = str_replace('%%boxtitle%%', 'Код:', $head) . $highlight_string . $foot;
			$text = str_replace('[PHP]', '[php]', $text);
			$text = str_replace('[/PHP]', '[/php]', $text);
			$text = str_replace('[php]' . $pstring . $i . $pstring . '[/php]', $displaybox, $text);
		}
		return $text;
	}

	/**
	 * Получение размера окна для Цитаты, Кода и т.д.
	 *
	 * @param string $text
	 * @return string
	 */
	function divheight($text)
	{
		static $maxlines;

		$row = $GLOBALS['AVE_DB']->Query("SELECT maxlines FROM " . PREFIX . "_modul_guestbook_settings")->FetchRow();
		if (!isset ($maxlines))
		{
			$maxlines = $row->maxlines;
		}

		$lines = max(substr_count($text, PHP_EOL), substr_count($text, '<br />')) + 1;
		if ($lines > $maxlines && $maxlines > 0)
		{
			$lines = $maxlines;
		}
		elseif ($lines < 1)
		{
			$lines = 1;
		}
		return ($lines) * 15 + 18;
	}

	/**
	 * Метод вывода сообщения (Сообщение добавлено, Защита от спама, Неверный код и т.д.)
	 *
	 * @param string $msg
	 * @param string $goto
	 * @param string $tpl
	 */
	function msg($msg = '', $goto = '', $tpl = '')
	{
		$goto = ($goto == '') ? 'index.php?module=guestbook' : $goto;
		$msg = str_replace('%%GoTo%%', $goto, $msg);
		$GLOBALS['AVE_Template']->assign('theme_folder', THEME_FOLDER);
		$GLOBALS['AVE_Template']->assign('GoTo', $goto);
		$GLOBALS['AVE_Template']->assign('content', $msg);
		$tpl_out = $GLOBALS['AVE_Template']->fetch($GLOBALS['mod']['tpl_dir'] . 'redirect.tpl');
		define('MODULE_CONTENT', $tpl_out);
		echo $tpl_out;
		exit;
	}
}

?>