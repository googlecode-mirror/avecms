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
	echo 'Извините, но Вы не имеете права доступа к данному разделу!';
	exit;
}

require(BASE_DIR . '/inc/init.php');
require(BASE_DIR . '/class/class.user.php');
require(BASE_DIR . '/admin/functions/func.admin.common.php');
require(BASE_DIR . '/admin/editor/fckeditor.php');

$tpl_dir = 'templates/' . (!empty($_SESSION['admin_theme']) ? $_SESSION['admin_theme'] : DEFAULT_ADMIN_THEME_FOLDER);
$AVE_Template = new AVE_Template($tpl_dir . '/');
$AVE_Template->config_load(BASE_DIR . '/admin/lang/' . (empty($_SESSION['admin_lang']) ? DEFAULT_COUNTRY : addslashes($_SESSION['admin_lang']))  . '/main.txt');
$AVE_Template->assign('tpl_dir', $tpl_dir);

define('SESSION', session_id());
$AVE_Template->assign('sess', SESSION);

?>