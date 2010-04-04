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

cntStat();
NaviModule();

$AVE_Template->config_load(BASE_DIR . '/admin/lang/' . $_SESSION['admin_lang'] . '/main.txt', 'index');
$AVE_Template->assign('php_version', (@PHP_VERSION != '') ? @PHP_VERSION : 'unknow');
$AVE_Template->assign('mysql_version', $GLOBALS['AVE_DB']->mysql_version());
$AVE_Template->assign('cache_size', formatsize(dirsize($AVE_Template->compile_dir)+dirsize($AVE_Template->cache_dir)));
$AVE_Template->assign('mysql_size', MySqlSize());
$AVE_Template->assign('navi', $AVE_Template->fetch('navi/navi.tpl'));
$AVE_Template->assign('content', $AVE_Template->fetch('start.tpl'));

?>