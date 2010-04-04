<?php

/**
 * AVE.cms
 *
 * @package AVE.cms
 * @filesource
 */

if (!defined('BASE_DIR')) exit;

set_include_path(get_include_path() . PATH_SEPARATOR . BASE_DIR . '/lib');

require(BASE_DIR . '/inc/config.php');
require(BASE_DIR . '/inc/db.config.php');
require(BASE_DIR . '/functions/func.common.php');

if (isset($_SERVER['REQUEST_METHOD']) && strtolower($_SERVER['REQUEST_METHOD'])=='post')
{
    if (!isset($_SERVER['HTTP_REFERER']) || !stc($_SERVER['HTTP_REFERER'], $_SERVER['HTTP_HOST']))
    {
        die('<div style="background-color:#fff;padding:5px;border:2px solid #f00"><b>Illegal Operation:</b> Posting allowed only from main server.</div>');
    }
}

unsetGlobals();

if (isset($HTTP_POST_VARS))
{
	$_POST     = $HTTP_POST_VARS;
	$_GET      = $HTTP_GET_VARS;
	$_REQUEST  = array_merge($_POST, $_GET);
	$_COOKIE   = $HTTP_COOKIE_VARS;
	if (isset($HTTP_SESSION_VARS)) $_SESSION = $HTTP_SESSION_VARS;
}

if (!get_magic_quotes_gpc())
{
	$_REQUEST  = addArray($_REQUEST);
	$_POST     = addArray($_POST);
	$_GET      = addArray($_GET);
	$_COOKIE   = addArray($_COOKIE);
}

ini_set('arg_separator.output',     '&amp;');
ini_set('session.cache_limiter',    'none');
ini_set('session.cookie_lifetime',  60*60*24*14);
ini_set('session.gc_maxlifetime',   60*24);
ini_set('session.use_cookies',      1);
ini_set('session.use_only_cookies', 1);
ini_set('session.use_trans_sid',    0);
ini_set('url_rewriter.tags',        '');

define('APP_NAME', 'AVE.cms');
define('APP_VERSION', '2.09c');
define('APP_INFO', APP_NAME . ' ' . APP_VERSION . ' &copy; 2008-' . gmdate('Y') . ' <a target="_blank" href="http://www.overdoze.ru/">Overdoze.Ru</a>');

define('URL_SUFF', $config['url_suff']);
define('CP_REWRITE', $config['mod_rewrite']);
define('CACHE_DOC_TPL', $config['cache_doc_tpl']);
define('DEFAULT_LANGUAGE', $config['default_language']);
define('DEFAULT_THEME_FOLDER', $config['default_theme_folder']);
define('DEFAULT_ADMIN_THEME_FOLDER', $config['default_admin_theme_folder']);

define('DB_HOST', $config['dbhost']);
define('DB_USER', $config['dbuser']);
define('DB_PASS', $config['dbpass']);
define('DB_NAME', $config['dbname']);
define('PREFIX', $config['dbpref']);

init_path();

if ($config['session_save_handler'])
{
    require(BASE_DIR . '/functions/func.session.php');
}
else
{
	ini_set('session.save_handler', 'files');
}

if (! empty($config['cookie_domain']))
{
    // ≈сли пользователь указал им€ домена дл€ cookie используем его дл€ имени сессии.
//    $session_name = $config['cookie_domain'];
    $cookie_domain = $config['cookie_domain'];
}
else
{
    // »наче используем BASE_URL дл€ имени сессии, без протокола
    // что-бы использовать одинаковый идентификатор сессии дл€ протоколов http и https.
    list( , $session_name) = explode('://', BASE_URL, 2);
    // Ёкранируем им€ хоста так как пользователь может его модифицировать дл€ взлома.
    if (!empty($_SERVER['HTTP_HOST']))
    {
        $cookie_domain = htmlspecialchars($_SERVER['HTTP_HOST'], ENT_QUOTES);
    }
}

// ”дал€ем ведущие www. и номер порта в имени домена дл€ использовани€ в cookie.
$cookie_domain = ltrim($cookie_domain, '.');
if (strpos($cookie_domain, 'www.') === 0)
{
    $cookie_domain = substr($cookie_domain, 4);
}
$cookie_domain = explode(':', $cookie_domain);
$cookie_domain = '.'. $cookie_domain[0];

// ¬ соответствии с RFC 2109, им€ домена дл€ cookie должно быть второго или более уровн€.
// ƒл€ хостов 'localhost' или указанных IP-адресом им€ домена дл€ cookie не устанавливаетс€.
if (count(explode('.', $cookie_domain)) > 2 && !is_numeric(str_replace('.', '', $cookie_domain)))
{
    ini_set('session.cookie_domain', $cookie_domain);
}

//session_name('SESS'. md5($session_name));
session_name('cp');
session_start();

if (isset($HTTP_SESSION_VARS)) $_SESSION = $HTTP_SESSION_VARS;

//include(BASE_DIR . '/inc/ids.php');

require(BASE_DIR . '/class/class.database.php');
$AVE_DB = new AVE_DB(DB_HOST, DB_USER, DB_PASS, DB_NAME);

if (isset($_REQUEST['action']) && $_REQUEST['action'] == 'logout')
{
    // уничтожаем куки
    @setcookie('auth[id]', '');
    @setcookie('auth[hash]', '');

    // уничтожаем сессию
    @session_destroy();
    session_unset();
    $_SESSION = array();

    if (!isset($_SERVER['HTTP_REFERER']) || !stc($_SERVER['HTTP_REFERER'], $_SERVER['HTTP_HOST']))
    {
        header('Location:' . BASE_URL . BASE_PATH);
    }
    else
    {
        header('Location:' . $_SERVER['HTTP_REFERER']);
    }
    exit;
}

if (!checkLogin())
{
    // чистим данные авторизации в сессии
    unset($_SESSION['user_id'], $_SESSION['user_pass']);

	// считаем пользовател€ √остем
	$_SESSION['user_group'] = 2;
	define('UNAME', '√ость');
	define('UGROUP', 2);
	define('UID', 0);
}

if (empty($_POST) && !isset($_REQUEST['module']) && UGROUP == -2)
{
	require(BASE_DIR . '/lib/Cache/Lite/Output.php');

	$options = array(
		'writeControl' => false,
		'readControl'  => false,
		'lifeTime'     => $config['cache_lifetime'],
		'cacheDir'     => BASE_DIR . '/cache/'
	);

	$cache = new Cache_Lite_Output($options);

	if ($cache->start($_SERVER['REQUEST_URI']))
	{
		// ¬ыводим статистику и завершаем работу
		echo "\n<br>¬рем€ генерации: ", number_format(microtimeDiff($start_time, microtime()), 3, ',', ' '), ' сек.';
		echo "\n<br> оличество запросов: ", $AVE_DB->StatDB('count'), ' шт. за ', number_format($AVE_DB->StatDB('time'), 3, ',', '.'), ' сек.';
		echo "\n<br>ѕиковое значение ", number_format((function_exists('memory_get_peak_usage') ? memory_get_peak_usage() : 0)/1024, 0, ',', ' '), 'Kb';
		exit;
	}
}

require(BASE_DIR . '/class/class.globals.php');
$AVE_Globals = new AVE_Globals;

define('DEFAULT_COUNTRY', strtolower(chop($AVE_Globals->mainSettings('default_country'))));

switch (DEFAULT_COUNTRY)
{
	case 'de':
		@setlocale (LC_ALL, 'de_DE@euro', 'de_DE', 'de', 'ge');
		break;

	case 'ru':
		@setlocale(LC_ALL, 'ru_RU.CP1251', 'rus_RUS.CP1251', 'Russian_Russia.1251', 'russian');
		break;

	default:
		@setlocale (LC_ALL, DEFAULT_COUNTRY . '_' . strtoupper(DEFAULT_COUNTRY), DEFAULT_COUNTRY, '');
		break;
}

require(BASE_DIR . '/class/class.template.php');

?>
