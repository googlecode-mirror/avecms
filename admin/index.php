<?php

/**
 * AVE.cms
 *
 * @package AVE.cms
 * @subpackage admin
 * @filesource
 */

error_reporting(E_ALL);
$start_time = microtime();

ob_start();

define('BASE_DIR', str_replace("\\", "/", substr(dirname(__FILE__), 0, -6)));

define('ACP', 1);

require_once(BASE_DIR . '/admin/init.php');

userCheck();

if (!empty($_SESSION['admin_lang']))
{
	$lang_local = $_SESSION['admin_lang'];
}
else
{
	if (!empty($_REQUEST['feld']) && !empty($_REQUEST['Id']) && !empty($_REQUEST['RubrikId']))
	{
		$_SESSION['redirectlink'] = 'index.php?do=docs&action=edit&RubrikId=' . (int)$_REQUEST['RubrikId']
			. '&Id=' . (int)$_REQUEST['Id'] . '&pop=1&feld=' . $_REQUEST['feld'] . '#' . $_REQUEST['feld'];
	}
	else
	{
		unset($_SESSION['redirectlink']);
	}

	header('Location:admin.php');
	exit;
}

$AVE_Template->config_load(BASE_DIR . '/admin/lang/' . $_SESSION['admin_lang'] . '/main.txt', 'templates');
$config_vars = $AVE_Template->get_config_vars();
$AVE_Template->assign('config_vars', $config_vars);
$AVE_Template->assign('navi', $AVE_Template->fetch('navi/navi.tpl'));

switch ($lang_local)
{
	case 'de':
		@setlocale(LC_ALL, 'de_DE@euro', 'de_DE', 'de', 'ge');
		break;

	case 'ru':
		@setlocale(LC_ALL, 'ru_RU.CP1251', 'rus_RUS.CP1251', 'Russian_Russia.1251', 'russian');
		break;

	default:
		@setlocale(LC_ALL, strtolower($lang_local) . '_' . strtoupper($lang_local), strtolower($lang_local), '');
		break;
}

$do = (!empty($_REQUEST['do'])) ? $_REQUEST['do'] : 'start';

$allowed_files = array(
	'index',
	'start',
	'templates',
	'rubs',
	'user',
	'groups',
	'docs',
	'navigation',
	'logs',
	'queries',
	'modules',
	'settings',
	'dbsettings'
);

if (in_array($do, $allowed_files))
{
	include_once(addslashes(BASE_DIR . '/admin/' . $do . '.php'));
}
else
{
	include_once(addslashes(BASE_DIR . '/admin/start.php'));
}

if (defined('NOPERM')) $AVE_Template->assign('content', $config_vars['MAIN_NO_PERMISSION']);
$tpl_disp = (isset($_REQUEST['pop']) && $_REQUEST['pop'] == 1)
	? ((isset($_REQUEST['css']) && $_REQUEST['css'] == 'inline' ) ? 'iframe.tpl' : 'pop.tpl')
	: 'main.tpl';
$AVE_Template->display($tpl_disp);

// Статистика
if (UGROUP == 1 && $config['sql_debug'])
{
	echo "\n<br>Время генерации: ", number_format(microtimeDiff($start_time, microtime()), 3, ',', ' '), ' сек.';
	echo "\n<br>Количество запросов: ", $AVE_DB->StatDB('count'), ' шт. за ', number_format($AVE_DB->StatDB('time'), 3, ',', '.'), ' сек.';
	echo "\n<br>Пиковое значение ", number_format((function_exists('memory_get_peak_usage') ? memory_get_peak_usage() : 0)/1024, 0, ',', ' '), 'Kb';
	echo "\n<div style=\"text-align:left;\"><small><ol>", $AVE_DB->StatDB('list'), '</ol></small></div>';
}

?>