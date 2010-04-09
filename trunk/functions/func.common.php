<?php

/**
 * AVE.cms
 *
 * @package AVE.cms
 * @filesource
 */

/**
 * Вычисление разницы между двумя метками времени
 *
 * @param string $a начальная метка
 * @param string $b конечная метка
 * @return int время между метками
 */
function microtimeDiff($a, $b)
{
	list($a_dec, $a_sec) = explode(' ', $a);
	list($b_dec, $b_sec) = explode(' ', $b);
	return $b_sec - $a_sec + $b_dec - $a_dec;
}

/**
 * Слешевание (для глобальных массивов)
 * рекурсивно обрабатывает вложенные массивы
 *
 * @param array $array обрабатываемый массив
 * @return array обработанный массив
 */
function addArray($array)
{
	reset($array);
	while (list($key, $val) = each($array))
	{
		if (is_string($val))
		{
			$array[$key] = addslashes($val);
		}
		elseif (is_array($val))
		{
			$array[$key] = addArray($val);
		}
	}

	return $array;
}

/**
 * Регистронезависимый вариант функции strpos
 * Возвращает числовую позицию первого вхождения needle в строке haystack.
 *
 * @param unknown_type $haystack проверяемая строка
 * @param unknown_type $needle искомая подстрока
 * @param unknown_type $offset с какого символа в haystack начинать поиск.
 * @return int числовая позиция
 */
function stc($haystack, $needle, $offset = 0)
{
	return strpos(strtoupper($haystack), strtoupper($needle), $offset);
}

/**
 * Инициализация констант и session.cookie_domain
 *  BASE_URL
 *  BASE_DIR
 *  BASE_PATH
 *  session.cookie_domain
 *
 */
function init_path()
{
	if (isset($_SERVER['HTTP_HOST']))
	{
		// HTTP_HOST вводится пользователем, поэтому проверяем на наличие запрещённых символов
		// в соответствии с RFC 952 и RFC 2181.
		// Все символы $_SERVER['HTTP_HOST'] приводим к строчным в соответствии с указанными спецификациями.
		$_SERVER['HTTP_HOST'] = strtolower($_SERVER['HTTP_HOST']);
		if (!preg_match('/^\[?(?:[a-z0-9-:\]_]+\.?)+$/', $_SERVER['HTTP_HOST']))
		{
			// HTTP_HOST не соответствует спецификациям.
			// Возможно это попытка взлома, поэтому даём отлуп статусом 400.
			header('HTTP/1.1 400 Bad Request');
			exit;
		}
	}
	else
	{
		// Некоторые клиенты использующие протоколы младше HTTP/1.1 не передают имя хоста в заголовках.
		// Создаём $_SERVER['HTTP_HOST'] для предотвращения вывода ошибки при E_ALL.
		$_SERVER['HTTP_HOST'] = '';
	}

	$host = ((isset($_SERVER['HTTPS']) && strtolower($_SERVER['HTTPS']) == 'on') || $_SERVER['SERVER_PORT'] == 443) ? 'https://' : 'http://';
	$host .= $_SERVER['HTTP_HOST'];
	if ($_SERVER['SERVER_PORT'] != 80) $host = str_replace(':' . $_SERVER['SERVER_PORT'], '', $host);
	$host .= ($_SERVER['SERVER_PORT'] == 80 || $_SERVER['SERVER_PORT'] == 443 || (isset($_SERVER['HTTPS']) && strtolower($_SERVER['HTTPS']) == 'on')) ? '' : ':' . $_SERVER['SERVER_PORT'];
	define('BASE_URL', $host);

	if (!strstr($_SERVER['PHP_SELF'], $_SERVER['SCRIPT_NAME']) && (@php_sapi_name() == 'cgi'))
	{
		$script_name = $_SERVER['PHP_SELF'];
	}
	else
	{
		$script_name = $_SERVER['SCRIPT_NAME'];
	}
	$script_name = explode("/inc", str_replace("\\", "/", dirname($script_name)));
	if (sizeof($script_name) > 1) array_pop($script_name);
	$script_name = implode("inc", $script_name);
	define('BASE_PATH', rtrim($script_name, '/') . '/');
}

/**
 * Проверка прав пользователя
 *
 * @param string $action проверяемое право
 * @return boolean результат проверки
 */
function checkPermission($action)
{
	global $_SESSION;

	if ((isset($_SESSION['user_group']) && $_SESSION['user_group'] == 1)
	|| (isset($_SESSION['alles']) && $_SESSION['alles'] == 1)
	|| (isset($_SESSION[$action]) && $_SESSION[$action] == 1))
	{
		return true;
	}

	return false;
}

/**
 * Авторизация по данным сессии или куки
 *
 * @return unknown
 */
function checkLogin()
{
	global $AVE_DB;

	if (isset($_SESSION['user_id']) && isset($_SESSION['user_pass']))
	{
		// авторизация по данным сессии
	}
	elseif (isset($_COOKIE['auth[id]']) && isset($_COOKIE['auth[hash]']))
	{
		// авторизация по данным куки
		$userid = intval($_COOKIE['auth[id]']);

		$row = $AVE_DB->Query("
			SELECT
				usr.Id,
				usr.Benutzergruppe,
				UserName,
				Vorname,
				Nachname,
				Email,
				Land,
				Rechte,
				Kennwort
			FROM " . PREFIX . "_users AS usr
			JOIN " . PREFIX . "_user_groups USING (Benutzergruppe)
			WHERE `Status` = 1
			AND usr.Id = '" . $userid . "'
			LIMIT 1
		")->FetchRow();

		if (!is_object($row) || $row->Kennwort != $_COOKIE['auth[hash]']) return false;

		$row->Rechte = str_replace(array(' ', "\n", "\r\n"), '', $row->Rechte);
		$permissions = explode('|', $row->Rechte);
		foreach($permissions as $permission) $_SESSION[$permission] = 1;

		$_SESSION['user_id'] = $row->Id;
		$_SESSION['user_group'] = $row->Benutzergruppe;
		$_SESSION['user_name'] = htmlspecialchars(empty($row->UserName) ? $row->Vorname . ' ' . $row->Nachname : $row->UserName);
		$_SESSION['user_pass'] = $row->Kennwort;
		$_SESSION['user_email'] = $row->Email;
		$_SESSION['user_country'] = strtoupper($row->Land);

		if (checkPermission('adminpanel'))
		{
			$_SESSION['admin_theme'] = DEFAULT_ADMIN_THEME_FOLDER;
			$_SESSION['admin_lang'] = DEFAULT_LANGUAGE;
		}
	}
	else
	{
		return false;
	}

	define('UID', $_SESSION['user_id']);
	define('UGROUP', $_SESSION['user_group']);
	define('UNAME', $_SESSION['user_name']);

	return true;
}

/**
 * Удаление глобальных массивов
 *
 */
function unsetGlobals()
{
	if (ini_get('register_globals'))
	{
		$allowed = array(
			'_ENV' => 1,
			'_GET' => 1,
			'_POST' => 1,
			'_COOKIE' => 1,
			'_FILES' => 1,
			'_SERVER' => 1,
			'_REQUEST' => 1,
			'GLOBALS' => 1
		);
		foreach ($GLOBALS as $key => $value)
		{
			if (!isset($allowed[$key]))
			{
				unset($GLOBALS[$key]);
			}
		}
	}
}

/**
 * Проверка начинается ли строка с указанной подстроки
 *
 * @param string $str проверяемая строка
 * @param string $in подстрока
 * @return boolean результат проверки
 */
function startsWith($str, $in)
{
	return(substr($in, 0, strlen($str)) == $str);
}

/**
 * Очистка текста от програмного кода
 *
 * @param string $text исходный текст
 * @return string очищенный текст
 */
function phpReplace($text)
{
	return str_replace(array('<?', '?>', '<script'), '', $text);
}

function getNavigations($navi_id = '')
{
	global $AVE_DB;

	static $navigations = null;

	if ($navigations == null)
	{
		$navigations = array();

		$sql = $AVE_DB->Query("SELECT * FROM " . PREFIX . "_navigation");

		while ($row = $sql->FetchRow())
		{
			$row->Gruppen = explode(',', $row->Gruppen);
			$navigations[$row->id] = $row;
		}
		$sql->Close();
	}

	if ($navi_id == '') return $navigations;

	return (isset($navigations[$navi_id]) ? $navigations[$navi_id] : false);
}

/**
 * Проверка прав доступа к навигации по группе пользователя
 *
 * @param int $id идентификатор меню навигации
 * @return boolean
 */
function checkSeePerm($id)
{
	global $AVE_DB;

	$navigations = getNavigations($id);

	if (empty($navigations[$id]->Gruppen)) return false;

	if (!defined('UGROUP')) define('UGROUP', 2);
	if (!in_array(UGROUP, $navigations[$id]->Gruppen)) return false;

	return true;
}

/**
 * Обработка парного тэга [hide:X,X]...[/hide] (скрытый текст)
 * Заменяет скрываемый текст в зависимости от группы пользователя
 *
 * @param string $data обрабатываемый текст
 * @return string обработанный текст
 */
function hide($data)
{
	global $AVE_Globals;

	if (1 != preg_match("/\[hide:\d+(,\d+)*].*?\[\/hide]/s", $data)) return $data;

	static $hidden_text = null;
	if ($hidden_text === null) $hidden_text = trim($AVE_Globals->mainSettings('hidden_text'));

	$data = preg_replace("/\[hide:(\d+,)*" . UGROUP . "(,\d+)*].*?\[\/hide]/s", $hidden_text, $data);
	$data = preg_replace("/\[hide:\d+(,\d+)*](.*?)\[\/hide]/s", "\\2", $data);

	return $data;
}

/**
 * Сообщение о запрете распечатки страницы
 *
 */
function printError()
{
	echo 'Запрашиваемая страница не может быть распечатана.';
	exit;
}

/**
 * Сообщение о проблемах доступа к файлам модуля
 *
 */
function moduleError()
{
	echo 'Запрашиваемый модуль не может быть загружен.';
	exit;
}

/**
 * Идентификатор текущей страницы
 *
 * @return int идентификатор текущей страницы
 */
function currentDocId()
{
	if (! (isset($_REQUEST['id']) && is_numeric($_REQUEST['id'])))
	{
		$_REQUEST['id'] = 1;
	}

	return $_REQUEST['id'];
}

/**
 * Форматирование числа
 *
 * @param array $param значение и параметры
 * @return string отформатированное значение
 */
function numFormat($param)
{
	if (is_array($param))
	{
		$out = number_format($param['val'], 0, ',', '.');
	}

	return $out;
}

/**
 * Формирование URL редиректа
 *
 * @return string URL
 */
function redirectLink($exclude = '')
{
	if (!strstr($_SERVER['PHP_SELF'], $_SERVER['SCRIPT_NAME']) && (@php_sapi_name() == 'cgi'))
	{
		$uri = $_SERVER['PHP_SELF'];
	}
	else
	{
		$uri = $_SERVER['SCRIPT_NAME'];
	}

	if (!empty($_GET))
	{
		if ($exclude != '' && !is_array($exclude))
		{
			$exclude = explode(',', $exclude);
		}
		$exclude[] = 'url';

		$params = array();
		foreach($_GET as $paname => $value)
		{
			if (!in_array($paname, $exclude))
			{
				$params[] = @urlencode($paname) . '=' . @urlencode($value);
			}
		}

		if (sizeof($params) > 0)
		{
			$uri .= '?' . implode('&amp;', $params);
		}
	}

	return ($uri);
}

/**
 * Ссылка на главную страницу
 *
 * @return string ссылка
 */
function homeLink()
{
	return BASE_URL . BASE_PATH;
//	return (CP_REWRITE == 1) ? 'index.html' : 'index.php';
}

/**
 * Ссылка на страницу версии для печати
 *
 * @return string ссылка
 */
function printLink()
{
	global $AVE_Core;

	$print_link = redirectLink('print');
	$print_link .= (strpos($print_link, '?')===false ? '?print=1' : '&amp;print=1');

	return $print_link;
}

/**
 * Вывод системного сообщения
 *
 * @param string $message сообщение
 */
function displayNotice($message)
{
	echo '<div style="background-color:#fff;padding:5px;border:1px solid #000;"><b>Системное сообщение: </b>' . $message . '</div>';
}

/**
 * Замена некоторых символов на их сущности
 * замена и исправление HTML-тэгов
 *
 * @param unknown_type $s
 * @return unknown
 */
function prettyChars($s)
{
	return preg_replace(
		array("'©'"   , "'®'"  , "'<b>'i"  , "'</b>'i"  , "'<i>'i", "'</i>'i", "'<br>'i", "'<br/>'i"),
		array('&copy;', '&reg;', '<strong>', '</strong>', '<em>'  , '</em>'  , '<br />' , '<br />'),
		$s);
}

/**
 * Swap named HTML entities with numeric entities.
 *
 * @see http://www.lazycat.org/software/html_entity_decode_full.phps
 */
function convertEntity($matches, $destroy = true)
{
	$table = array(
		'Aacute'   => '&#193;',  'aacute'   => '&#225;',  'Acirc'    => '&#194;',  'acirc'    => '&#226;',  'acute'    => '&#180;',
		'AElig'    => '&#198;',  'aelig'    => '&#230;',  'Agrave'   => '&#192;',  'agrave'   => '&#224;',  'alefsym'  => '&#8501;',
		'Alpha'    => '&#913;',  'alpha'    => '&#945;',  'amp'      => '&#38;',   'and'      => '&#8743;', 'ang'      => '&#8736;',
		'Aring'    => '&#197;',  'aring'    => '&#229;',  'asymp'    => '&#8776;', 'Atilde'   => '&#195;',  'atilde'   => '&#227;',
		'Auml'     => '&#196;',  'auml'     => '&#228;',  'bdquo'    => '&#8222;', 'Beta'     => '&#914;',  'beta'     => '&#946;',
		'brvbar'   => '&#166;',  'bull'     => '&#8226;', 'cap'      => '&#8745;', 'Ccedil'   => '&#199;',  'ccedil'   => '&#231;',
		'cedil'    => '&#184;',  'cent'     => '&#162;',  'Chi'      => '&#935;',  'chi'      => '&#967;',  'circ'     => '&#710;',
		'clubs'    => '&#9827;', 'cong'     => '&#8773;', 'copy'     => '&#169;',  'crarr'    => '&#8629;', 'cup'      => '&#8746;',
		'curren'   => '&#164;',  'dagger'   => '&#8224;', 'Dagger'   => '&#8225;', 'darr'     => '&#8595;', 'dArr'     => '&#8659;',
		'deg'      => '&#176;',  'Delta'    => '&#916;',  'delta'    => '&#948;',  'diams'    => '&#9830;', 'divide'   => '&#247;',
		'Eacute'   => '&#201;',  'eacute'   => '&#233;',  'Ecirc'    => '&#202;',  'ecirc'    => '&#234;',  'Egrave'   => '&#200;',
		'egrave'   => '&#232;',  'empty'    => '&#8709;', 'emsp'     => '&#8195;', 'ensp'     => '&#8194;', 'Epsilon'  => '&#917;',
		'epsilon'  => '&#949;',  'equiv'    => '&#8801;', 'Eta'      => '&#919;',  'eta'      => '&#951;',  'ETH'      => '&#208;',
		'eth'      => '&#240;',  'Euml'     => '&#203;',  'euml'     => '&#235;',  'euro'     => '&#8364;', 'exist'    => '&#8707;',
		'fnof'     => '&#402;',  'forall'   => '&#8704;', 'frac12'   => '&#189;',  'frac14'   => '&#188;',  'frac34'   => '&#190;',
		'frasl'    => '&#8260;', 'Gamma'    => '&#915;',  'gamma'    => '&#947;',  'ge'       => '&#8805;', 'gt'       => '&#62;',
		'harr'     => '&#8596;', 'hArr'     => '&#8660;', 'hearts'   => '&#9829;', 'hellip'   => '&#8230;', 'Iacute'   => '&#205;',
		'iacute'   => '&#237;',  'Icirc'    => '&#206;',  'icirc'    => '&#238;',  'iexcl'    => '&#161;',  'Igrave'   => '&#204;',
		'igrave'   => '&#236;',  'image'    => '&#8465;', 'infin'    => '&#8734;', 'int'      => '&#8747;', 'Iota'     => '&#921;',
		'iota'     => '&#953;',  'iquest'   => '&#191;',  'isin'     => '&#8712;', 'Iuml'     => '&#207;',  'iuml'     => '&#239;',
		'Kappa'    => '&#922;',  'kappa'    => '&#954;',  'Lambda'   => '&#923;',  'lambda'   => '&#955;',  'lang'     => '&#9001;',
		'laquo'    => '&#171;',  'larr'     => '&#8592;', 'lArr'     => '&#8656;', 'lceil'    => '&#8968;', 'ldquo'    => '&#8220;',
		'le'       => '&#8804;', 'lfloor'   => '&#8970;', 'lowast'   => '&#8727;', 'loz'      => '&#9674;', 'lrm'      => '&#8206;',
		'lsaquo'   => '&#8249;', 'lsquo'    => '&#8216;', 'lt'       => '&#60;',   'macr'     => '&#175;',  'mdash'    => '&#8212;',
		'micro'    => '&#181;',  'middot'   => '&#183;',  'minus'    => '&#8722;', 'Mu'       => '&#924;',  'mu'       => '&#956;',
		'nabla'    => '&#8711;', 'nbsp'     => '&#160;',  'ndash'    => '&#8211;', 'ne'       => '&#8800;', 'ni'       => '&#8715;',
		'not'      => '&#172;',  'notin'    => '&#8713;', 'nsub'     => '&#8836;', 'Ntilde'   => '&#209;',  'ntilde'   => '&#241;',
		'Nu'       => '&#925;',  'nu'       => '&#957;',  'Oacute'   => '&#211;',  'oacute'   => '&#243;',  'Ocirc'    => '&#212;',
		'ocirc'    => '&#244;',  'OElig'    => '&#338;',  'oelig'    => '&#339;',  'Ograve'   => '&#210;',  'ograve'   => '&#242;',
		'oline'    => '&#8254;', 'Omega'    => '&#937;',  'omega'    => '&#969;',  'Omicron'  => '&#927;',  'omicron'  => '&#959;',
		'oplus'    => '&#8853;', 'or'       => '&#8744;', 'ordf'     => '&#170;',  'ordm'     => '&#186;',  'Oslash'   => '&#216;',
		'oslash'   => '&#248;',  'Otilde'   => '&#213;',  'otilde'   => '&#245;',  'otimes'   => '&#8855;', 'Ouml'     => '&#214;',
		'ouml'     => '&#246;',  'para'     => '&#182;',  'part'     => '&#8706;', 'permil'   => '&#8240;', 'perp'     => '&#8869;',
		'Phi'      => '&#934;',  'phi'      => '&#966;',  'Pi'       => '&#928;',  'pi'       => '&#960;',  'piv'      => '&#982;',
		'plusmn'   => '&#177;',  'pound'    => '&#163;',  'prime'    => '&#8242;', 'Prime'    => '&#8243;', 'prod'     => '&#8719;',
		'prop'     => '&#8733;', 'Psi'      => '&#936;',  'psi'      => '&#968;',  'quot'     => '&#34;',   'radic'    => '&#8730;',
		'rang'     => '&#9002;', 'raquo'    => '&#187;',  'rarr'     => '&#8594;', 'rArr'     => '&#8658;', 'rceil'    => '&#8969;',
		'rdquo'    => '&#8221;', 'real'     => '&#8476;', 'reg'      => '&#174;',  'rfloor'   => '&#8971;', 'Rho'      => '&#929;',
		'rho'      => '&#961;',  'rlm'      => '&#8207;', 'rsaquo'   => '&#8250;', 'rsquo'    => '&#8217;', 'sbquo'    => '&#8218;',
		'Scaron'   => '&#352;',  'scaron'   => '&#353;',  'sdot'     => '&#8901;', 'sect'     => '&#167;',  'shy'      => '&#173;',
		'Sigma'    => '&#931;',  'sigma'    => '&#963;',  'sigmaf'   => '&#962;',  'sim'      => '&#8764;', 'spades'   => '&#9824;',
		'sub'      => '&#8834;', 'sube'     => '&#8838;', 'sum'      => '&#8721;', 'sup'      => '&#8835;', 'sup1'     => '&#185;',
		'sup2'     => '&#178;',  'sup3'     => '&#179;',  'supe'     => '&#8839;', 'szlig'    => '&#223;',  'Tau'      => '&#932;',
		'tau'      => '&#964;',  'there4'   => '&#8756;', 'Theta'    => '&#920;',  'theta'    => '&#952;',  'thetasym' => '&#977;',
		'thinsp'   => '&#8201;', 'THORN'    => '&#222;',  'thorn'    => '&#254;',  'tilde'    => '&#732;',  'times'    => '&#215;',
		'trade'    => '&#8482;', 'Uacute'   => '&#218;',  'uacute'   => '&#250;',  'uarr'     => '&#8593;', 'uArr'     => '&#8657;',
		'Ucirc'    => '&#219;',  'ucirc'    => '&#251;',  'Ugrave'   => '&#217;',  'ugrave'   => '&#249;',  'uml'      => '&#168;',
		'upsih'    => '&#978;',  'Upsilon'  => '&#933;',  'upsilon'  => '&#965;',  'Uuml'     => '&#220;',  'uuml'     => '&#252;',
		'weierp'   => '&#8472;', 'Xi'       => '&#926;',  'xi'       => '&#958;',  'Yacute'   => '&#221;',  'yacute'   => '&#253;',
		'yen'      => '&#165;',  'Yuml'     => '&#376;',  'yuml'     => '&#255;',  'Zeta'     => '&#918;',  'zeta'     => '&#950;',
		'zwj'      => '&#8205;', 'zwnj'     => '&#8204;'
	);
	if (isset($table[$matches[1]]))
	{
		return $table[$matches[1]];
	}
	else
	{
		return $destroy ? '' : $matches[0];
	}
}

/**
 * Транслитерация и удаление запрещённых символов для ЧПУ
 *
 * @param string $st строка для транслитерации
 * @return string обработанная строка
 */
function cpParseLinkname($st)
{
//	$st = htmlspecialchars_decode($st);

	// Convert all named HTML entities to numeric entities
	$st = preg_replace_callback('/&([a-zA-Z][a-zA-Z0-9]{1,7});/', 'convertEntity', $st);

	// Convert all numeric entities to their actual character
	$st = preg_replace('/&#x([0-9a-f]{1,7});/ei', 'chr(hexdec("\\1"))', $st);
	$st = preg_replace('/&#([0-9]{1,7});/e', 'chr("\\1")', $st);

	$st = strtolower($st);
	$st = strtr($st, array(
		'ье'=>'ye', 'ъе'=>'ye', 'ьи'=>'yi', 'ъи'=>'yi',  'ъо'=>'yo',
		'ьо'=>'yo', 'ё'=>'yo',  'ю'=>'yu',  'я'=>'ya',   'ж'=>'zh', 'х'=>'kh',
		'ц'=>'ts',  'ч'=>'ch',  'ш'=>'sh',  'щ'=>'shch', 'ъ'=>'',   'ь'=>''
	));
	$st = strtr($st,'абвгдезийклмнопрстуфыэ',
					'abvgdeziyklmnoprstufye');
	$st = strip_tags($st);
	$st = preg_replace(
		array('/^[\/-]+|[\/-]+$|[^ a-z0-9\/-]/', '/\s+/', '/[-]{2,}/', '/[-]*[\/]+[-]*/', '/[\/]{2,}/'),
		array(''							   , '-'	, '-'		 , '/'			    , '/'),
		$st
	);
	$st = trim($st, '-');

	return $st;
}

/**
 * Формирование ЧПУ для документов
 *
 * @param string $s ссылка или текст с ссылками
 * @return string
 */
function cpRewrite($s)
{
	$s = preg_replace("/index.php(?:\?)id=(?:[0-9]+)&(?:amp;)*doc=(index|[a-z0-9\/-]+)&(?:amp;)*(artpage|apage|page)=([{s}0-9]+)&(?:amp;)*(artpage|apage|page)=([{s}0-9]+)&(?:amp;)*(artpage|apage|page)=([{s}0-9]+)/", "\\1/\\2-\\3/\\4-\\5/\\6-\\7".URL_SUFF, $s);
	$s = preg_replace("/index.php(?:\?)id=(?:[0-9]+)&(?:amp;)*doc=(index|[a-z0-9\/-]+)&(?:amp;)*(artpage|apage|page)=([{s}0-9]+)&(?:amp;)*(artpage|apage|page)=([{s}0-9]+)/", "\\1/\\2-\\3/\\4-\\5".URL_SUFF, $s);
	$s = preg_replace("/index.php(?:\?)id=(?:[0-9]+)&(?:amp;)*doc=(index|[a-z0-9\/-]+)&(?:amp;)*(artpage|apage|page)=([{s}0-9]+)/", "\\1/\\2-\\3".URL_SUFF, $s);
	$s = preg_replace("/index.php(?:\?)id=(?:[0-9]+)&(?:amp;)*doc=(index|[a-z0-9\/-]+)/", "\\1".URL_SUFF, $s);
	$s = preg_replace("/".preg_quote(URL_SUFF, '/')."&(?:amp;)*print=1/", "/print".URL_SUFF, $s);

	$s = preg_replace('/index.php(?:\?)module=(shop|forums|download)&(?:amp;)*page=([{s}]|\d+)/', '\\1-\\2.html', $s);
	$s = preg_replace('/index.php(?:\?)module=(shop|forums|download)&(?:amp;)*print=1/', "\\1-print.html", $s);
	$s = preg_replace('/index.php(?:\?)module=(shop|forums|download)(?!&)/', "\\1.html", $s);

	return $s;
}

/**
 * Подключение функции обработки внутренних запросов
 * и обработка тэга запроса
 *
 * @param unknown_type $param
 * @return unknown
 */
function parseRequest($param)
{
	require_once(BASE_DIR . '/functions/func.parserequest.php');
	return cpParseRequest($param);
}

function reportLog($meldung, $typ = 0, $rub = 0)
{
	global $AVE_DB;

	$AVE_DB->Query("
		INSERT INTO " . PREFIX . "_log
		SET
			Id		= '',
			Zeit	= '" . time() . "',
			IpCode	= '" . addslashes($_SERVER['REMOTE_ADDR']) . "',
			Seite	= '" . addslashes($_SERVER['QUERY_STRING']) . "',
			Meldung	= '" . addslashes($meldung) . "',
			LogTyp	= '" . $typ . "',
			Rub		= '" . $rub . "'
	");
}

/**
 * Текущая страница
 *
 * @param string $type - тип постраничной навигации,
 *  допустимые значения: page, apage, artpage
 * @return int - номер текущей страницы
 */
function prepage($type = 'page')
{
	if (!in_array($type, array('page', 'apage', 'artpage'))) return 1;

	$page = (!empty($_REQUEST[$type]) && is_numeric($_REQUEST[$type])) ? intval($_REQUEST[$type]) : 1;

	return $page;
}

/**
 * Постраничная навигация для запросов и модулей
 *
 * @param int $total_pages - количество страниц в документе
 * @param string $type - тип постраничной навигации,
 *  допустимые значения: page, apage, artpage
 * @param string $template_label - шаблон метки навигации
 * @param string $navi_box - контейнер постраничной навигации
 * @return string - HTML-код постраничной навигации
 */
function pagenav($total_pages, $type, $template_label, $navi_box = '')
{
	global $AVE_Globals;

	$nav = '';
	if (!in_array($type, array('page', 'apage', 'artpage'))) $type = 'page';
	$curent_page = prepage($type);

	if ($curent_page == 1)
	{
		$seiten = array ($curent_page, $curent_page+1, $curent_page+2, $curent_page+3, $curent_page+4);
	}
	elseif ($curent_page == 2)
	{
		$seiten = array ($curent_page-1, $curent_page, $curent_page+1, $curent_page+2, $curent_page+3);
	}
	elseif ($curent_page+1 == $total_pages)
	{
		$seiten = array ($curent_page-3, $curent_page-2, $curent_page-1, $curent_page, $curent_page+1);
	}
	elseif ($curent_page == $total_pages)
	{
		$seiten = array ($curent_page-4, $curent_page-3, $curent_page-2, $curent_page-1, $curent_page);
	}
	else
	{
		$seiten = array ($curent_page-2, $curent_page-1, $curent_page, $curent_page+1, $curent_page+2);
	}

	$seiten = array_unique($seiten);

	$total_label = trim($AVE_Globals->mainSettings('total_label'));
	$start_label = trim($AVE_Globals->mainSettings('start_label'));
	$end_label = trim($AVE_Globals->mainSettings('end_label'));
	$separator_label = trim($AVE_Globals->mainSettings('separator_label'));
	$next_label = trim($AVE_Globals->mainSettings('next_label'));
	$prev_label = trim($AVE_Globals->mainSettings('prev_label'));

	if ($total_pages > 5 && $curent_page > 3)
	{
		$nav .= str_replace('{t}', $start_label, str_replace(array('&amp;'.$type.'={s}','&'.$type.'={s}'), '', $template_label));
		if ($separator_label != '') $nav .= '<span>' . $separator_label . '</span>';
	}

	if ($curent_page > 1)
	{
		if ($curent_page == 2)
		{
			$nav .= str_replace('{t}', $prev_label, str_replace(array('&amp;'.$type.'={s}','&'.$type.'={s}'), '', $template_label));
		}
		else
		{
			$nav .= str_replace('{t}', $prev_label, str_replace('{s}', ($curent_page - 1), $template_label));
		}
	}

	while (list($key,$val) = each($seiten))
	{
		if ($val >= 1 && $val <= $total_pages)
		{
			if ($curent_page == $val)
			{
				$nav .= str_replace(array('{s}', '{t}'), $val, '<span class="curent_page">' . $curent_page . '</span>');
			}
			else
			{
				if ($val == 1)
				{
					$nav .= str_replace('{t}', $val, str_replace(array('&amp;'.$type.'={s}','&'.$type.'={s}'), '', $template_label));
				}
				else
				{
					$nav .= str_replace(array('{s}', '{t}'), $val, $template_label);
				}
			}
		}
	}

	if ($curent_page < $total_pages)
	{
		$nav .= str_replace('{t}', $next_label, str_replace('{s}', ($curent_page + 1), $template_label));
	}

	if ($total_pages > 5 && ($curent_page < $total_pages-2))
	{
		if ($separator_label != '') $nav .= '<span>' . $separator_label . '</span>';
		$nav .= str_replace('{t}', $end_label, str_replace('{s}', $total_pages, $template_label));
	}

	if ($nav != '')
	{
		if ($total_label != '') $nav = '<span class="pages">' . sprintf($total_label, $curent_page, $total_pages) . '</span> ' . $nav;
		if ($navi_box != '') $nav = sprintf($navi_box, $nav);
	}

	return $nav;
}

function get_document_fields($document_id)
{
	global $AVE_DB;

	static $document_fields;

	if (!is_numeric($document_id)) return false;

	if (!isset ($document_fields[$document_id]))
	{
		$fields = false;

		$sql = $AVE_DB->Query("
			SELECT
				doc_field.Id,
				RubrikFeld,
				RubTyp,
				Inhalt,
				Redakteur,
				tpl_req,
				tpl_field
			FROM
				" . PREFIX . "_document_fields AS doc_field
			JOIN
				" . PREFIX . "_rubric_fields AS rub_field
					ON RubrikFeld = rub_field.Id
			JOIN
				" . PREFIX . "_documents AS doc
					ON doc.Id = DokumentId
			WHERE
				DokumentId = '" . $document_id . "'
		");

		while ($row = $sql->FetchAssocArray())
		{
			$row['tpl_req_empty'] = (trim($row['tpl_req']) == '') ? true : false;
			$row['tpl_field_empty'] = (trim($row['tpl_field']) == '') ? true : false;

			if ($row['Inhalt'] === '')
			{
				$row['tpl_req'] = preg_replace("/\[cp:not_empty](.*?)\[\/cp:not_empty]/si", '', $row['tpl_req']);
				$row['tpl_req'] = trim(str_replace(array('[cp:if_empty]','[/cp:if_empty]'), '', $row['tpl_req']));

				$row['tpl_field'] = preg_replace("/\[cp:not_empty](.*?)\[\/cp:not_empty]/si", '', $row['tpl_field']);
				$row['tpl_field'] = trim(str_replace(array('[cp:if_empty]','[/cp:if_empty]'), '', $row['tpl_field']));
			}
			else
			{
				$row['tpl_req'] = preg_replace("/\[cp:if_empty](.*?)\[\/cp:if_empty]/si", '', $row['tpl_req']);
				$row['tpl_req'] = trim(str_replace(array('[cp:not_empty]','[/cp:not_empty]'), '', $row['tpl_req']));

				$row['tpl_field'] = preg_replace("/\[cp:if_empty](.*?)\[\/cp:if_empty]/si", '', $row['tpl_field']);
				$row['tpl_field'] = trim(str_replace(array('[cp:not_empty]','[/cp:not_empty]'), '', $row['tpl_field']));
			}

			$fields[$row['RubrikFeld']] = $row;
		}

		$document_fields[$document_id] = $fields;
	}

	return $document_fields[$document_id];
}

/**
 * имя пользователя по его идентификатору
 *
 * @param int $id - идентификатор пользователя
 * @return string
 */
function getUserById($id)
{
	global $AVE_DB;

	static $users = array();

	if (!isset($users[$id]))
	{
		$row = $AVE_DB->Query("
			SELECT
				Vorname,
				Nachname
			FROM " . PREFIX . "_users
			WHERE Id = '" . (int)$id . "'
		")->FetchRow();

		if ($row)
		{
			$users[$id] = substr($row->Vorname, 0, 1) . "." . $row->Nachname;
		}
		else
		{
			$users[$id] = null;
		}
	}

	return $users[$id];
}

/**
 * Исправление форматирования даты
 * Функцию можно использовать в шаблонах Smarty как модификатор
 *
 * @param string $string - дата отформатированная в соответствии с текущей локалью
 * @param string $language - язык
 * @return string
 */
function pretty_date($string, $language = 'ru')
{
	$language = strtolower($language);

	switch ($language)
	{
		case 'by':
			break;

		case 'de':
			break;

		case 'ru':
			$pretty = array(
				'Январь'     =>'января',      'Февраль'    =>'февраля',     'Март'    =>'марта',
				'Апрель'     =>'апреля',      'Май'        =>'мая',         'Июнь'    =>'июня',
				'Июль'       =>'июля',        'Август'     =>'августа',     'Сентябрь'=>'сентября',
				'Октябрь'    =>'октября',     'Ноябрь'     =>'ноября',      'Декабрь' =>'декабря',

				'воскресенье'=>'Воскресенье', 'понедельник'=>'Понедельник', 'вторник' =>'Вторник',
				'среда'      =>'Среда',       'четверг'    =>'Четверг',     'пятница' =>'Пятница',
				'суббота'    =>'Суббота'
			);
			break;

		case 'ua':
			break;

		default:
			break;
	}

	if (isset($pretty)) $string = strtr($string, $pretty);

	return $string;
}

function preClear($string)
{
	$string = preg_replace('#[\x00-\x08\x0B-\x0C\x0E-\x1F]+#is', ' ', $string);

	return trim($string);
}

?>