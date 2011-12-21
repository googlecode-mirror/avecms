<?php

/**
 * AVE.cms
 *
 * @package AVE.cms
 * @subpackage admin
 * @filesource
 */

if(!defined('ACP'))
{
	header('Location:index.php');
	exit;
}

get_ave_info();
get_editable_module();

//$AVE_Template->config_load(BASE_DIR . '/admin/lang/' . $_SESSION['admin_language'] . '/main.txt', 'index');
$AVE_Template->assign('php_version', (@PHP_VERSION != '') ? @PHP_VERSION : 'unknow');
$AVE_Template->assign('mysql_version', $GLOBALS['AVE_DB']->mysql_version());
$AVE_Template->assign('cache_size', format_size(get_dir_size($AVE_Template->compile_dir)+get_dir_size($AVE_Template->cache_dir_root)));
$AVE_Template->assign('mysql_size', get_mysql_size());
$AVE_Template->assign('navi', $AVE_Template->fetch('navi/navi.tpl'));
$AVE_Template->assign('content', $AVE_Template->fetch('start.tpl'));

?>