<?php

/**
 * AVE.cms
 *
 * @package AVE.cms
 * @filesource
 */

$start_time = microtime();

ob_start();

define('BASE_DIR', str_replace("\\", "/", dirname(__FILE__)));

if (! @filesize(BASE_DIR . '/inc/db.config.php'))
{
	header('Location:install.php');
	exit;
}

if (! empty($_REQUEST['thumb']))
{
	require(BASE_DIR . '/functions/func.thumbnail.php');
	exit;
}

require(BASE_DIR . '/inc/init.php');

if (! isset($_REQUEST['sub'])) $_REQUEST['sub'] = '';

$AVE_Template = new AVE_Template('templates/' . DEFAULT_THEME_FOLDER . '/');

require(BASE_DIR . '/class/class.core.php');
$AVE_Core = new AVE_Core;
if (! empty($_GET['url'])) $AVE_Core->parseUrl();
$AVE_Core->displaySite(currentDocId());

$content = ob_get_clean();
ob_start();

if ($_REQUEST['id'] == 2) header($_SERVER['SERVER_PROTOCOL'] . ' 404 Not Found', true);

eval ('?>' . $content . '<?');

if (isset($cache) && is_object($cache)) $cache->end();

// Статистика
if (UGROUP == 1 && $config['sql_debug'])
{
	echo "\n<br>Время генерации: ", number_format(microtimeDiff($start_time, microtime()), 3, ',', ' '), ' сек.';
	echo "\n<br>Количество запросов: ", $AVE_DB->StatDB('count'), ' шт. за ', number_format($AVE_DB->StatDB('time'), 3, ',', '.'), ' сек.';
	echo "\n<br>Пиковое значение ", number_format((function_exists('memory_get_peak_usage') ? memory_get_peak_usage() : 0)/1024, 0, ',', ' '), 'Kb';
	echo "\n<div style=\"text-align:left;padding-left:30px\"><small><ol>", $AVE_DB->StatDB('list'), '</ol></small></div>';
}

?>