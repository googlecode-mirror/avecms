<?php

/**
 * AVE.cms
 *
 * @package AVE.cms
 * @filesource
 */

/**
 * ���������� ������� ����� ����� ������� �������
 *
 * @param string $a ��������� �����
 * @param string $b �������� �����
 * @return int ����� ����� �������
 */
function microtime_diff($a, $b)
{
	list($a_dec, $a_sec) = explode(' ', $a);
	list($b_dec, $b_sec) = explode(' ', $b);
	return $b_sec - $a_sec + $b_dec - $a_dec;
}

/**
 * ������������������� ������� ������� strpos
 * ���������� �������� ������� ������� ��������� needle � ������ haystack.
 *
 * @param unknown_type $haystack ����������� ������
 * @param unknown_type $needle ������� ���������
 * @param unknown_type $offset � ������ ������� � haystack �������� �����.
 * @return int �������� �������
 */
if (!function_exists("stripos"))
{
	function stripos($haystack, $needle, $offset = 0)
	{
		return strpos(strtoupper($haystack), strtoupper($needle), $offset);
	}
}

/**
 * �������������� �����
 *
 * @param array $param �������� � ���������
 * @return string ����������������� ��������
 */
function num_format($param)
{
	if (is_array($param)) return number_format($param['val'], 0, ',', '.');
	return '';
}

/**
 * �������� ���������� �� ������ � ��������� ���������
 *
 * @param string $str ����������� ������
 * @param string $in ���������
 * @return boolean ��������� ��������
 */
function start_with($str, $in)
{
	return(substr($in, 0, strlen($str)) == $str);
}

/**
 * �������� ���� ������������
 *
 * @param string $action ����������� �����
 * @return boolean ��������� ��������
 */
function check_permission($action)
{
	global $_SESSION;

	if ((isset($_SESSION['user_group']) && $_SESSION['user_group'] == 1) ||
		(isset($_SESSION['alles'])      && $_SESSION['alles'] == 1) ||
		(isset($_SESSION[$action])      && $_SESSION[$action] == 1))
	{
		return true;
	}

	return false;
}


function clean_no_print_char($text)
{
	return trim(preg_replace('#[\x00-\x08\x0B-\x0C\x0E-\x1F]+#is', ' ', $text));
}

/**
 * ������� ������ �� ����������� ����
 *
 * @param string $text �������� �����
 * @return string ��������� �����
 */
function clean_php($text)
{
	return str_replace(array('<?', '?>', '<script'), '', $text);
}

/**
 * ����� ���������� ���������
 *
 * @param string $message ���������
 */
function display_notice($message)
{
	echo '<div style="background-color:#ff6;padding:5px;border:1px solid #f00;color:#f00;text-align:center;"><b>��������� ���������: </b>' . $message . '</div>';
}

/**
 * ��������� � ������� ���������� ��������
 *
 */
function print_error()
{
	display_notice('������������� �������� �� ����� ���� �����������.');
	exit;
}

/**
 * ��������� � ��������� ������� � ������ ������
 *
 */
function module_error()
{
	display_notice('������������� ������ �� ����� ���� ��������.');
	exit;
}

/**
 * ��������� �������� ��������
 *
 * @param string $field �������� ���������, ���� �� ������ - ��� ���������
 * @return mixed
 */
function get_settings($field = '')
{
	global $AVE_DB;

	static $settings = null;

	if ($settings === null)
	{
		$settings = $AVE_DB->Query("SELECT * FROM " . PREFIX . "_settings")->FetchAssocArray();
	}

	if ($field == '') return $settings;

	return isset($settings[$field]) ? $settings[$field] : null;
}

function get_navigations($navi_id = '')
{
	global $AVE_DB;

	static $navigations = null;

	if ($navigations == null)
	{
		$navigations = array();

		$sql = $AVE_DB->Query("SELECT * FROM " . PREFIX . "_navigation");

		while ($row = $sql->FetchRow())
		{
			$row->navi_user_group = explode(',', $row->navi_user_group);
			$navigations[$row->id] = $row;
		}
	}

	if ($navi_id == '') return $navigations;

	return (isset($navigations[$navi_id]) ? $navigations[$navi_id] : false);
}

/**
 * �������� ���� ������� � ��������� �� ������ ������������
 *
 * @param int $id ������������� ���� ���������
 * @return boolean
 */
function check_navi_permission($id)
{
	$navigation = get_navigations($id);

	if (empty($navigation->navi_user_group)) return false;

	if (!defined('UGROUP')) define('UGROUP', 2);
	if (!in_array(UGROUP, $navigation->navi_user_group)) return false;

	return true;
}

/**
 * ��������� ������� ���� [tag:hide:X,X]...[/tag:hide] (������� �����)
 * �������� ���������� ����� � ����������� �� ������ ������������
 *
 * @param string $data �������������� �����
 * @return string ������������ �����
 */
function parse_hide($data)
{
	static $hidden_text = null;

	if (1 != preg_match('/\[tag:hide:\d+(,\d+)*].*?\[\/tag:hide]/s', $data)) return $data;

	if ($hidden_text === null) $hidden_text = trim(get_settings('hidden_text'));

	$data = preg_replace('/\[tag:hide:(\d+,)*' . UGROUP . '(,\d+)*].*?\[\/tag:hide]/s', $hidden_text, $data);
	$data = preg_replace('/\[tag:hide:\d+(,\d+)*](.*?)\[\/tag:hide]/s', '\\2', $data);

	return $data;
}

/**
 * �������� ������������� �������� ���������
 *
 * @return int ������������� �������� ���������
 */
function get_current_document_id()
{
	$_REQUEST['id'] = (isset($_REQUEST['id']) && is_numeric($_REQUEST['id'])) ? $_REQUEST['id'] : 1;

	return $_REQUEST['id'];
}

/**
 * ������������ URL ���������
 *
 * @return string URL
 */
function get_redirect_link($exclude = '')
{
	global $AVE_Core;

	$link = 'index.php';

	if (!empty($_GET))
	{
		if ($exclude != '' && !is_array($exclude)) $exclude = explode(',', $exclude);

		$exclude[] = 'url';

		$params = array();
		foreach($_GET as $key => $value)
		{
			if (!in_array($key, $exclude))
			{
				if ($key == 'doc')
				{
					$params[] = 'doc=' . (empty($AVE_Core->curentdoc->document_alias) ? prepare_url($AVE_Core->curentdoc->document_title) : $AVE_Core->curentdoc->document_alias);
				}
				else
				{
					$params[] = @urlencode($key) . '=' . @urlencode($value);
				}
			}
		}

		if (sizeof($params)) $link .= '?' . implode('&amp;', $params);
	}

	return $link;
}

/**
 * ������ �� ������� ��������
 *
 * @return string ������
 */
function get_home_link()
{
	return HOST . ABS_PATH;
}

/**
 * ������������ ������� ������
 *
 * @return string ������
 */
function get_breadcrumb()
{
	global $AVE_DB;
	
	$crumb = array();
	$curent_document = get_current_document_id();
	
	$bread_crumb = "<a href=\"".get_home_link()."\">�������</a>&nbsp;&rarr;&nbsp;";
	if ($curent_document == 1|| $curent_document == 2) $noprint = 1;
	
	$sql_document = $AVE_DB->Query("SELECT document_title, document_parent FROM " . PREFIX . "_documents WHERE Id = '".$curent_document."'");
	$row_document = $sql_document->fetchrow();
	$current->document_title = $row_document->document_title;
		
	if (isset($row_document->document_parent) && $row_document->document_parent != 0) {
		$i = 0;
		$current->document_parent = $row_document->document_parent;

		 while ($current->document_parent != 0) {
			$sql_doc = $AVE_DB->Query("SELECT Id, document_alias, document_title, document_parent FROM " . PREFIX . "_documents WHERE Id = '".$current->document_parent."'");
			$row_doc = $sql_doc->fetchrow();
			$current->document_parent = $row_doc->document_parent;
			
			if ($row_doc->document_parent == $row_doc->Id) {
				echo "������! �� ������� � �������� ������������� ��������� ������� ��������.<br>";
				$current->document_parent = 1;
			}
			
			$crumb['document_title'][$i] = $row_doc->document_title;
			$crumb['document_alias'][$i] = $row_doc->document_alias;
			$crumb['Id'][$i] = $row_doc->Id;
			$i++;
		 }
				
		$length = count($crumb['document_title']);
		$crumb['document_title'] = array_reverse($crumb['document_title']);
		$crumb['document_alias'] = array_reverse($crumb['document_alias']);
		$crumb['Id'] = array_reverse($crumb['Id']);
		
		for ($n=0; $n < $length; $n++) {
			$url = rewrite_link('index.php?id=' . $crumb['Id'][$n] . '&amp;doc=' . (empty($crumb['document_alias'][$n]) ? prepare_url($crumb['document_title'][$n]) : $crumb['document_alias'][$n]));
			$bread_crumb.= "<a href=\"".$url."\"  target=\"_self\">".$crumb['document_title'][$n]."</a>&nbsp;&rarr;&nbsp;";
		}
	}
	
	$bread_crumb.= "<span>".$current->document_title."</span>";
		
	 if (!$noprint)  return $bread_crumb;
}

/**
 * ������ �� �������� ������ ��� ������
 *
 * @return string ������
 */
function get_print_link()
{
	$link = get_redirect_link('print');
	$link .= (strpos($link, '?')===false ? '?print=1' : '&amp;print=1');

	return $link;
}

function get_referer_link()
{
	static $link = null;

	if ($link === null)
	{
		if (isset($_SERVER['HTTP_REFERER']))
		{
			$link = parse_url($_SERVER['HTTP_REFERER']);
			$link = (trim($link['host']) == $_SERVER['SERVER_NAME']);
		}
		$link = ($link === true ? $_SERVER['HTTP_REFERER'] : get_home_link());
	}

	return $link;
}

function truncate_text($string, $length = 80, $etc = '...', $break_words = false, $middle = false)
{
	if ($length == 0) return '';

	if (strlen($string) > $length)
	{
		$length -= min($length, strlen($etc));
		if (!$break_words && !$middle)
		{
			$string = preg_replace('/\s+?(\S+)?$/', '', substr($string, 0, $length+1));
		}

		if (!$middle)
		{
			return substr($string, 0, $length) . $etc;
		}
		else
		{
			return substr($string, 0, $length/2) . $etc . substr($string, -$length/2);
		}
	}
	else
	{
		return $string;
	}
}

/**
 * Swap named HTML entities with numeric entities.
 *
 * @see http://www.lazycat.org/software/html_entity_decode_full.phps
 */
function convert_entity($matches, $destroy = true)
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

	if (isset($table[$matches[1]])) return $table[$matches[1]];
	else							return $destroy ? '' : $matches[0];
}

/**
 * ������ ��������� �������� �� �� ��������
 * ������ � ����������� HTML-�����
 *
 * @param unknown_type $s
 * @return unknown
 */
function pretty_chars($s)
{
	return preg_replace(array("'�'"   , "'�'"  , "'<b>'i"  , "'</b>'i"  , "'<i>'i", "'</i>'i", "'<br>'i", "'<br/>'i"),
						array('&copy;', '&reg;', '<strong>', '</strong>', '<em>'  , '</em>'  , '<br />' , '<br />'), $s);
}

/**
 * ��������������
 *
 * @param string $st ������ ��� ��������������
 * @return string
 */
function translit_string($st)
{
//	$st = htmlspecialchars_decode($st);
//
//	// Convert all named HTML entities to numeric entities
//	$st = preg_replace_callback('/&([a-zA-Z][a-zA-Z0-9]{1,7});/', 'convert_entity', $st);
//
//	// Convert all numeric entities to their actual character
//	$st = preg_replace('/&#x([0-9a-f]{1,7});/ei', 'chr(hexdec("\\1"))', $st);
//	$st = preg_replace('/&#([0-9]{1,7});/e', 'chr("\\1")', $st);
//
	$st = strtr ($st, array('��'=>'ye', '��'=>'ye', '��'=>'yi',  '��'=>'yi',
							'��'=>'yo', '��'=>'yo', '�'=>'yo',   '�'=>'yu',
							'�'=>'ya',  '�'=>'zh',  '�'=>'kh',   '�'=>'ts',
							'�'=>'ch',  '�'=>'sh',  '�'=>'shch', '�'=>'',
							'�'=>'',    '�'=>'yi',  '�'=>'ye')
	);
	$st = strtr($st,'�����������������������',
					'abvgdeziyklmnoprstufyei');

	return trim($st, '-');
}

/**
 * ���������� URL
 *
 * @param string $st
 * @return string
 */
function prepare_url($st)
{
	$st = strip_tags($st);

	$st = strtr($st,'ABCDEFGHIJKLMNOPQRSTUVWXYZ�����Ũ�������������������������߯��',
					'abcdefghijklmnopqrstuvwxyz�����������������������������������');

	if (defined('TRANSLIT_URL') && TRANSLIT_URL) $st = translit_string(trim($st));

	$st = preg_replace(
		array('/^[\/-]+|[\/-]+$|^[\/_]+|[\/_]+$|[^a-z�-�����0-9\/_-]/', '/--+/', '/-*\/+-*/', '/\/\/+/'),
		array('-',                                                      '-',     '/',         '/'),
		$st
	);

	return trim($st, '-');
}

/**
 * ���������� ����� ����� ��� ����������
 *
 * @param string $st
 * @return string
 */
function prepare_fname($st)
{
	$st = strip_tags($st);

	$st = strtr($st,'ABCDEFGHIJKLMNOPQRSTUVWXYZ�����Ũ�������������������������߯��',
					'abcdefghijklmnopqrstuvwxyz�����������������������������������');

	$st = translit_string(trim($st));

	$st = preg_replace(array('/[^a-z0-9_-]/', '/--+/'), '-', $st);

	return trim($st, '-');
}

/**
 * ������������ ��� ��� ����������
 *
 * @param string $s ������ ��� ����� � ��������
 * @return string
 */
function rewrite_link($s)
{
	if (!REWRITE_MODE) return $s;

	$doc_regex = '/index.php(?:\?)id=(?:[0-9]+)&(?:amp;)*doc='.(TRANSLIT_URL ? '([a-z0-9\/_-]+)' : '([a-z�-�����0-9\/_-]+)');
	$page_regex = '&(?:amp;)*(artpage|apage|page)=([{s}0-9]+)';

	$s = preg_replace($doc_regex.$page_regex.$page_regex.$page_regex.'/', ABS_PATH.'$1/$2-$3/$4-$5/$6-$7'.URL_SUFF, $s);
	$s = preg_replace($doc_regex.$page_regex.$page_regex.'/',             ABS_PATH.'$1/$2-$3/$4-$5'.URL_SUFF, $s);
	$s = preg_replace($doc_regex.$page_regex.'/',                         ABS_PATH.'$1/$2-$3'.URL_SUFF, $s);
	$s = preg_replace($doc_regex.'/',                                     ABS_PATH.'$1'.URL_SUFF, $s);
	$s = preg_replace('/'.preg_quote(URL_SUFF, '/').'[?|&](?:amp;)*print=1/', '/print'.URL_SUFF, $s);

	$mod_regex = '/index.php(?:\?)module=(shop|forums|download|guestbook|roadmap)';

	$s = preg_replace($mod_regex.'&(?:amp;)*page=([{s}]|\d+)/', ABS_PATH.'$1-$2.html', $s);
	$s = preg_replace($mod_regex.'&(?:amp;)*print=1/',          ABS_PATH.'$1-print.html', $s);
	$s = preg_replace($mod_regex.'(?!&)/',                      ABS_PATH.'$1.html', $s);

	return $s;
}

function reportLog($meldung, $typ = 0, $rub = 0)
{
	global $AVE_DB;

	$AVE_DB->Query("
		INSERT INTO " . PREFIX . "_log
		SET
			Id         = '',
			log_time   = '" . time() . "',
			log_ip     = '" . addslashes($_SERVER['REMOTE_ADDR']) . "',
			log_url	   = '" . addslashes($_SERVER['QUERY_STRING']) . "',
			log_text   = '" . addslashes($meldung) . "',
			log_type   = '" . (int)$typ . "',
			log_rubric = '" . (int)$rub . "'
	");
}

function get_document_fields($document_id)
{  
    header('Content-Type: text/html; charset=windows-1251');
	global $AVE_DB, $request_documents;

	static $document_fields = array();

	if (!is_numeric($document_id)) return false;

	if (!isset ($document_fields[$document_id]))
	{
		if (!empty($request_documents) && is_array($request_documents))
		{
			$documents = array_combine($request_documents, $request_documents);
			$documents = array_diff_key($documents, $document_fields);

			foreach ($documents as $id) $document_fields[$id] = false;

			$where = "WHERE doc_field.document_id IN(" . implode(',', $documents) . ")";
		}
		else
		{
			$document_fields[$document_id] = false;

			$where = "WHERE doc_field.document_id = '" . $document_id . "'";
		}

		$sql = $AVE_DB->Query("
			SELECT
				doc_field.Id,
				document_id,
				rubric_field_id,
				rubric_field_type,
				field_value,
				document_author_id,
				rubric_field_template,
				rubric_field_template_request
			FROM
				" . PREFIX . "_document_fields AS doc_field
			JOIN
				" . PREFIX . "_rubric_fields AS rub_field
					ON doc_field.rubric_field_id = rub_field.Id
			JOIN
				" . PREFIX . "_documents AS doc
					ON doc.Id = doc_field.document_id
			" . $where
		);

		while ($row = $sql->FetchAssocArray())
		{
			$row['tpl_req_empty'] = (trim($row['rubric_field_template_request']) == '');
			$row['tpl_field_empty'] = (trim($row['rubric_field_template']) == '');

			if ($row['field_value'] === '')
			{
				$row['rubric_field_template_request'] = preg_replace('/\[tag:if_notempty](.*?)\[\/tag:if_notempty]/si', '', $row['rubric_field_template_request']);
				$row['rubric_field_template_request'] = trim(str_replace(array('[tag:if_empty]','[/tag:if_empty]'), '', $row['rubric_field_template_request']));

				$row['rubric_field_template'] = preg_replace('/\[tag:if_notempty](.*?)\[\/tag:if_notempty]/si', '', $row['rubric_field_template']);
				$row['rubric_field_template'] = trim(str_replace(array('[tag:if_empty]','[/tag:if_empty]'), '', $row['rubric_field_template']));
			}
			else
			{
				$row['rubric_field_template_request'] = preg_replace('/\[tag:if_empty](.*?)\[\/tag:if_empty]/si', '', $row['rubric_field_template_request']);
				$row['rubric_field_template_request'] = trim(str_replace(array('[tag:if_notempty]','[/tag:if_notempty]'), '', $row['rubric_field_template_request']));

				$row['rubric_field_template'] = preg_replace('/\[tag:if_empty](.*?)\[\/tag:if_empty]/si', '', $row['rubric_field_template']);
				$row['rubric_field_template'] = trim(str_replace(array('[tag:if_notempty]','[/tag:if_notempty]'), '', $row['rubric_field_template']));
			}

			$document_fields[$row['document_id']][$row['rubric_field_id']] = $row;
		}
	}

	return $document_fields[$document_id];
}

/**
 * ������������ ������ ����� ������������
 * ��� ������� ���� ���������� �������� ������������ ������ <b>��� �������</b>
 * ���� ������ $short=1 - ��������� �������� ����� <b>�. �������</b>
 * ����� ����������� ���������� � ����� ��� ������� �������� ������������
 * ������ �� ������ ��������� ������, � ���� ������ ��� ������ - �������
 * ��� ���������� ������������ ������� �������� � �������� ���������� �������.
 *
 * @todo �������� �������� 'anonymous' � ���������
 *
 * @param string $login ����� ������������
 * @param string $first_name ��� ������������
 * @param string $last_name ������� ������������
 * @param int $short {0|1} ������� ������������ �������� �����
 * @return string
 */
function get_username($login = '', $first_name = '', $last_name = '', $short = 1)
{
	if ($first_name != '' && $last_name != '')
	{
		if ($short == 1) $first_name = substr($first_name, 0, 1) . '.';
		return ucfirst(strtolower($first_name)) . ' ' . ucfirst(strtolower($last_name));
	}
	elseif ($first_name != '' && $last_name == '')
	{
		return ucfirst(strtolower($first_name));
	}
	elseif ($first_name == '' && $last_name != '')
	{
		return ucfirst(strtolower($last_name));
	}
	elseif ($login != '')
	{
		return ucfirst(strtolower($login));
	}

//	return get_settings('anonymous');
	return 'Anonymous';
}

/**
 * ���������� ��� ������������ �� ��� ��������������
 *
 * @param int $id - ������������� ������������
 * @return string
 */
function get_username_by_id($id)
{
	global $AVE_DB;

	static $users = array();

	if (!isset($users[$id]))
	{
		$row = $AVE_DB->Query("
			SELECT
				user_name,
				firstname,
				lastname
			FROM " . PREFIX . "_users
			WHERE Id = '" . (int)$id . "'
		")->FetchRow();

		$users[$id] = !empty($row) ? get_username($row->user_name, $row->firstname, $row->lastname, 1) : get_username();
	}

	return $users[$id];
}

/**
 * ����������� �������������� ����
 * ������� ����� ������������ � �������� Smarty ��� �����������
 *
 * @param string $string - ���� ����������������� � ������������ � ������� �������
 * @param string $language - ����
 * @return string
 */
function pretty_date($string, $language = '')
{
	if ($language == '')
	{
		$language = (defined('ACP') && ACP) ? $_SESSION['admin_language'] : $_SESSION['user_language'];
	}

	$language = strtolower($language);

	switch ($language)
	{
		case 'by':
			break;

		case 'de':
			break;

		case 'ru':
			$pretty = array(
				'������'     =>'������',      '�������'    =>'�������',     '����'    =>'�����',
				'������'     =>'������',      '���'        =>'���',         '����'    =>'����',
				'����'       =>'����',        '������'     =>'�������',     '��������'=>'��������',
				'�������'    =>'�������',     '������'     =>'������',      '�������' =>'�������',

				'�����������'=>'�����������', '�����������'=>'�����������', '�������' =>'�������',
				'�����'      =>'�����',       '�������'    =>'�������',     '�������' =>'�������',
				'�������'    =>'�������'
			);
			break;

		case 'ua':
			$pretty = array(
				'ѳ����' =>'����',  '�����'    =>'������',    '��������'=>'�������',
				'������'=>'�����', '�������'  =>'������',    '�������' =>'������',
				'������' =>'�����',  '�������'  =>'������',    '��������'=>'�������',
				'�������'=>'������', '��������' =>'���������', '�������' =>'������',

				'�����' =>'�����', '��������'=>'��������', '�������'=>'³������',
				'������' =>'������', '������'   =>'������',    "�'������"=>"�'������",
				'������' =>'������'
			);
			break;

		default:
			break;
	}

	return (isset($pretty) ? strtr($string, $pretty) : $string);
}

/**
 * ������������ ������ �� ��������� ��������
 *
 * @param int $length ���������� �������� � ������
 * @param string $chars ����� �������� ��� ������������ ������
 * @return string �������������� ������
 */
function make_random_string($length = 16, $chars = '')
{
	if ($chars == '')
	{
		$chars  = 'abcdefghijklmnopqrstuvwxyz';
		$chars .= 'ABCDEFGHIJKLMNOPRQSTUVWXYZ';
		$chars .= '~!@#$%^&*()-_=+{[;:/?.,]}';
		$chars .= '0123456789';
	}

	$clen = strlen($chars) - 1;

	$string = '';
	while (strlen($string) < $length) $string .= $chars[mt_rand(0, $clen)];

	return $string;
}

function get_statistic($t=0, $m=0, $q=0, $l=0)
{
	global $AVE_DB;

	$s = '';

	if ($t) $s .= "\n<br>����� ���������: " . number_format(microtime_diff(START_MICROTIME, microtime()), 3, ',', ' ') . ' ���.';
	if ($m && function_exists('memory_get_peak_usage')) $s .= "\n<br>������� �������� " . number_format(memory_get_peak_usage()/1024, 0, ',', ' ') . 'Kb';
//	if ($q) $s .= "\n<br>���������� ��������: " . $AVE_DB->DBStatisticGet('count') . ' ��. �� ' . number_format($AVE_DB->DBStatisticGet('time')*1000, 3, ',', '.') . ' �����.';
//	if ($l) $s .= "\n<br><div style=\"text-align:left;padding-left:30px\"><small><ol>" . $AVE_DB->DBStatisticGet('list') . '</ol></small></div>';
	if ($q && !defined('SQL_PROFILING_DISABLE')) $s .= "\n<br>���������� ��������: " . $AVE_DB->DBProfilesGet('count') . ' ��. �� ' . $AVE_DB->DBProfilesGet('time') . ' ���.';
	if ($l && !defined('SQL_PROFILING_DISABLE')) $s .= $AVE_DB->DBProfilesGet('list');

	return $s;
}

function add_template_comment($tpl_source, &$smarty)
{
    return "\n\n<!-- BEGIN SMARTY TEMPLATE " . $smarty->_current_file . " -->\n".$tpl_source."\n<!-- END SMARTY TEMPLATE " . $smarty->_current_file . " -->\n\n";
}

/**
 * ��������� ������ �����
 *
 * @param int $status ������ ����� �������� � ������
 * <ul>
 * <li>1 - �������� ������</li>
 * <li>0 - ���������� ������</li>
 * </ul>
 * ���� �� ������� ���������� ������ ����� ��� ����� �������
 * @return array
 */
function get_country_list($status = '')
{
	global $AVE_DB;

	$countries = array();
	$sql = $AVE_DB->Query("
		SELECT
			Id,
			LOWER(country_code) AS country_code,
			country_name,
			country_status,
			country_eu
		FROM " . PREFIX . "_countries
		" . (($status != '') ? "WHERE country_status = '" . $status . "'" : '') . "
		ORDER BY country_name ASC
	");
	while ($row = $sql->FetchRow()) array_push($countries, $row);

	return $countries;
}

/**
 * �������� e-Mail
 *
 * @param string $to
 * @param string $text
 * @param string $subject
 * @param string $from
 * @param string $from_name
 * @param string $content_type
 * @param string $attachments
 */
function send_mail($to, $text, $subject = '', $from = '', $from_name = '', $content_type = '', $attachments = '')
{
	ob_start();

	if (!function_exists('version_compare') || version_compare(phpversion(), '5', '<'))
	{
		include_once(BASE_DIR . '/lib/PHPMailer/php4/class.phpmailer.php') ;
	}
	else
	{
		include_once(BASE_DIR . '/lib/PHPMailer/php5/class.phpmailer.php') ;
	}

	$PHPMailer = new PHPMailer;

	$PHPMailer->CharSet     = 'windows-1251';
	$PHPMailer->Mailer      = get_settings('mail_type');
	$PHPMailer->ContentType = ($content_type == 'html') ? 'text/html' : (($content_type == 'text' || get_settings('mail_content_type') == 'text/plain') ? 'text/plain' : 'text/html');
	$PHPMailer->WordWrap    = get_settings('mail_word_wrap');
	$PHPMailer->Subject     = $subject;
	$PHPMailer->Body        = $text . "\n\n" . ($PHPMailer->ContentType == 'text/html' ? '' : get_settings('mail_signature'));
	$PHPMailer->From        = ($from != '') ? $from : get_settings('mail_from');
	$PHPMailer->FromName    = ($from_name != '') ? $from_name : get_settings('mail_from_name');
	$PHPMailer->AddAddress($to);

	switch ($PHPMailer->Mailer)
	{
		case 'sendmail':
			$PHPMailer->Sendmail = get_settings('mail_sendmail_path');
			break;

		case 'smtp':
			$PHPMailer->Host       = get_settings('mail_host');
			$PHPMailer->Port       = get_settings('mail_port');
			$PHPMailer->Username   = get_settings('mail_smtp_login');
			$PHPMailer->Password   = get_settings('mail_smtp_pass');
			$PHPMailer->AddReplyTo($PHPMailer->Username, $PHPMailer->FromName);
			$PHPMailer->SMTPAuth   = true;  // authentication enabled
			$PHPMailer->SMTPSecure = 'ssl'; // secure transfer enabled REQUIRED for Gmail
//			$PHPMailer->SMTPDebug  = true;  // enables SMTP debug information (for testing)
			break;

		case 'mail':
		default:
			break;
	}

	if (! empty($attachments))
	{
		if (is_array($attachments))
		{
			foreach ($attachments as $attachment)
			{
				$PHPMailer->AddAttachment(BASE_DIR . '/attachments/' . $attachment);
			}
		}
		else
		{
			$PHPMailer->AddAttachment(BASE_DIR . '/attachments/' . $attachments);
		}
	}

	if ($PHPMailer->Send())
	{
//		if (! empty($attachments))
//		{
//			if (is_array($attachments))
//			{
//				foreach ($attachments as $attachment)
//				{
//					@unlink(BASE_DIR . '/attachments/' . $attachment);
//				}
//			}
//			else
//			{
//				@unlink(BASE_DIR . '/attachments/' . $attachments);
//			}
//		}
	}
	else
	{
		reportLog('PHPMailer Error: ' . $PHPMailer->ErrorInfo);
	}

	ob_end_clean();
}

/**
 * Replace array_combine()
 *
 * @category    PHP
 * @package     PHP_Compat
 * @license     LGPL - http://www.gnu.org/licenses/lgpl.html
 * @copyright   2004-2007 Aidan Lister <aidan@php.net>, Arpad Ray <arpad@php.net>
 * @link        http://php.net/function.array_combine
 * @author      Aidan Lister <aidan@php.net>
 * @version     $Revision: 1.23 $
 * @since       PHP 5
 * @require     PHP 4.0.0 (user_error)
 */
function php_compat_array_combine($keys, $values)
{
    if (!is_array($keys)) {
        user_error('array_combine() expects parameter 1 to be array, ' .
            gettype($keys) . ' given', E_USER_WARNING);
        return;
    }

    if (!is_array($values)) {
        user_error('array_combine() expects parameter 2 to be array, ' .
            gettype($values) . ' given', E_USER_WARNING);
        return;
    }

    $key_count = count($keys);
    $value_count = count($values);
    if ($key_count !== $value_count) {
        user_error('array_combine() Both parameters should have equal number of elements', E_USER_WARNING);
        return false;
    }

    if ($key_count === 0 || $value_count === 0) {
        user_error('array_combine() Both parameters should have number of elements at least 0', E_USER_WARNING);
        return false;
    }

    $keys    = array_values($keys);
    $values  = array_values($values);

    $combined = array();
    for ($i = 0; $i < $key_count; $i++) {
        $combined[$keys[$i]] = $values[$i];
    }

    return $combined;
}
// Define
if (!function_exists('array_combine')) {
    function array_combine($keys, $values)
    {
        return php_compat_array_combine($keys, $values);
    }
}

/**
 * Replace PHP_EOL constant
 *
 * @category    PHP
 * @package     PHP_Compat
 * @license     LGPL - http://www.gnu.org/licenses/lgpl.html
 * @copyright   2004-2007 Aidan Lister <aidan@php.net>, Arpad Ray <arpad@php.net>
 * @link        http://php.net/reserved.constants.core
 * @author      Aidan Lister <aidan@php.net>
 * @version     $Revision: 1.3 $
 * @since       PHP 5.0.2
 */
if (!defined('PHP_EOL')) {
    switch (strtoupper(substr(PHP_OS, 0, 3))) {
        // Windows
        case 'WIN':
            define('PHP_EOL', "\r\n");
            break;

        // Mac
        case 'DAR':
            define('PHP_EOL', "\r");
            break;

        // Unix
        default:
            define('PHP_EOL', "\n");
    }
}

?>