<?php
/**
 * AVE.cms
 *
 * @package AVE.cms
 * @subpackage admin
 * @filesource
 */
@date_default_timezone_set('Europe/Moscow');

define('START_MICROTIME', microtime());

ob_start();

define('ACP', 1);

define('BASE_DIR', str_replace("\\", "/", dirname(dirname(__FILE__))));

if (! @filesize(BASE_DIR . '/inc/db.config.php')) { header('Location:../install.php'); exit; }

require(BASE_DIR . '/admin/init.php');

if (!defined('UID') || !check_permission('adminpanel'))
{
	header('Location:admin.php');
	exit;
}

if (empty($_SESSION['admin_language']))
{
	if (!empty($_REQUEST['feld']) && !empty($_REQUEST['Id']) && !empty($_REQUEST['rubric_id']))
	{
		$_SESSION['redirectlink'] = 'index.php?do=docs&action=edit&pop=1'
									. '&rubric_id=' . (int)$_REQUEST['rubric_id']
									. '&Id='        . (int)$_REQUEST['Id']
									. '&feld='      . (int)$_REQUEST['feld']
									. '#'           . (int)$_REQUEST['feld'];
	}
	else
	{
		unset($_SESSION['redirectlink']);
	}

	header('Location:admin.php');
	exit;
}

if (!isset($_REQUEST['do']))     $_REQUEST['do']     = '';
if (!isset($_REQUEST['action'])) $_REQUEST['action'] = '';
if (!isset($_REQUEST['sub']))    $_REQUEST['sub']    = '';
if (!isset($_REQUEST['submit'])) $_REQUEST['submit'] = '';

$AVE_Template->assign('navi', $AVE_Template->fetch('navi/navi.tpl'));

$allowed = array('index',   'start',    'templates',  'rubs', 'user', 'finder',
				 'groups',  'docs',     'navigation', 'logs', 'request',
				 'modules', 'settings', 'dbsettings'
);
$do = (!empty($_REQUEST['do']) && in_array($_REQUEST['do'], $allowed)) ? $_REQUEST['do'] : 'start';
include(BASE_DIR . '/admin/' . $do . '.php');

if (defined('NOPERM')) $AVE_Template->assign('content', $config_vars['MAIN_NO_PERMISSION']);

//$tpl = (isset($_REQUEST['css']) && $_REQUEST['css'] == 'inline') ? 'iframe.tpl' : 'pop.tpl';
//$tpl = (isset($_REQUEST['pop']) && $_REQUEST['pop'] == 1) ? $tpl : 'main.tpl';
$tpl = (isset($_REQUEST['pop']) && $_REQUEST['pop'] == 1) ? 'pop.tpl' : 'main.tpl';
$AVE_Template->display($tpl);

// Статистика
if (defined('PROFILING') && PROFILING) echo get_statistic(1, 1, 1, 1);

?>