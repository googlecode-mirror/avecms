<?php

/**
 * AVE.cms
 *
 * @package AVE.cms
 * @subpackage admin
 * @filesource
 */

error_reporting(E_ALL);

define('START_MICROTIME', microtime());

ob_start();

define('ACP', 1);

define('BASE_DIR', str_replace("\\", "/", substr(dirname(__FILE__), 0, -6)));

if (! @filesize(BASE_DIR . '/inc/db.config.php')) { header('Location:../install.php'); exit; }

require(BASE_DIR . '/admin/init.php');

if (!defined('UID') || !check_permission('adminpanel'))
{
	header('Location:admin.php');
	exit;
}

if (empty($_SESSION['admin_language']))
{
	if (!empty($_REQUEST['feld']) &&
		!empty($_REQUEST['Id']) &&
		!empty($_REQUEST['RubrikId']))
	{
		$_SESSION['redirectlink'] = 'index.php?do=docs&action=edit&pop=1'
									. '&RubrikId=' . (int)$_REQUEST['RubrikId']
									. '&Id='       . (int)$_REQUEST['Id']
									. '&feld='     . (int)$_REQUEST['feld']
									. '#'          . (int)$_REQUEST['feld'];
	}
	else
	{
		unset($_SESSION['redirectlink']);
	}

	header('Location:admin.php');
	exit;
}

$_REQUEST['do']     = (!isset($_REQUEST['do']))     ? '' : $_REQUEST['do'];
$_REQUEST['action'] = (!isset($_REQUEST['action'])) ? '' : $_REQUEST['action'];
$_REQUEST['sub']    = (!isset($_REQUEST['sub']))    ? '' : $_REQUEST['sub'];
$_REQUEST['submit'] = (!isset($_REQUEST['submit'])) ? '' : $_REQUEST['submit'];

$AVE_Template->assign('navi', $AVE_Template->fetch('navi/navi.tpl'));

$allowed = array('index', 'start', 'templates', 'rubs', 'user', 'groups', 'docs', 'navigation', 'logs', 'request', 'modules', 'settings', 'dbsettings');
$do = (!empty($_REQUEST['do'])) ? $_REQUEST['do'] : 'start';
if (in_array($do, $allowed))
{
	define('DO_FILE', BASE_DIR . '/admin/' . $do . '.php');
}
else
{
	define('DO_FILE', BASE_DIR . '/admin/start.php');
}
include(DO_FILE);

if (defined('NOPERM')) $AVE_Template->assign('content', $config_vars['MAIN_NO_PERMISSION']);

//$tpl = (isset($_REQUEST['css']) && $_REQUEST['css'] == 'inline') ? 'iframe.tpl' : 'pop.tpl';
//$tpl = (isset($_REQUEST['pop']) && $_REQUEST['pop'] == 1) ? $tpl : 'main.tpl';
$tpl = (isset($_REQUEST['pop']) && $_REQUEST['pop'] == 1) ? 'pop.tpl' : 'main.tpl';
$AVE_Template->display($tpl);

// Статистика
if (defined('PROFILING') && PROFILING) echo get_statistic(1, 1, 1, 1);

?>