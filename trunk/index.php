<?php

/**
 * AVE.cms
 *
 * @package AVE.cms
 * @filesource
 */


define('START_MICROTIME', microtime());

define('BASE_DIR', str_replace("\\", "/", dirname(__FILE__)));

if (! @filesize(BASE_DIR . '/inc/db.config.php')) { header('Location:install.php'); exit; }

if (! empty($_REQUEST['thumb'])) { require(BASE_DIR . '/functions/func.thumbnail.php'); exit; }

ob_start();

require(BASE_DIR . '/inc/init.php');

$AVE_Template = new AVE_Template(BASE_DIR . '/templates/' . DEFAULT_THEME_FOLDER);

if (! isset($_REQUEST['sub'])) $_REQUEST['sub'] = '';

require(BASE_DIR . '/class/class.core.php');
$AVE_Core = new AVE_Core;

//if (! empty($_REQUEST['url'])) $AVE_Core->coreUrlParse($_REQUEST['url']);
if (empty($_REQUEST['module']) && empty($_REQUEST['id'])) $AVE_Core->coreUrlParse($_SERVER['REQUEST_URI']);

$AVE_Core->coreSiteFetch(get_current_document_id());

$content = ob_get_clean();
ob_start();

if ($_REQUEST['id'] == 2) header($_SERVER['SERVER_PROTOCOL'] . ' 404 Not Found', true);

eval ('?>' . $content . '<?');

if (isset($cache) && is_object($cache)) $cache->end();

//ob_end_flush();

// Статистика
if (!defined('ONLYCONTENT') && UGROUP == 1 && defined('PROFILING') && PROFILING) echo get_statistic(1, 1, 1, 1);

?>