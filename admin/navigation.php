<?php

/**
 * AVE.cms
 *
 * @package AVE.cms
 * @subpackage admin
 * @filesource
 */

if (!defined('ACP'))
{
	header('Location:index.php');
	exit;
}

include_once(BASE_DIR . '/class/class.navigation.php');
$AVE_Navigation = new AVE_Navigation;

$AVE_Template->assign('navi', $AVE_Template->fetch('navi/navi.tpl'));

$AVE_Template->config_load(BASE_DIR . '/admin/lang/' . $_SESSION['admin_lang'] . '/navigation.txt', 'navi');
//$config_vars = $AVE_Template->get_config_vars();
//$AVE_Template->assign('config_vars', $config_vars);

$_REQUEST['sub']    = (!isset($_REQUEST['sub']))    ? '' : addslashes($_REQUEST['sub']);
$_REQUEST['action'] = (!isset($_REQUEST['action'])) ? '' : addslashes($_REQUEST['action']);
$_REQUEST['submit'] = (!isset($_REQUEST['submit'])) ? '' : addslashes($_REQUEST['submit']);

switch ($_REQUEST['action'])
{
	case '':
		if (permCheck('navigation'))
		{
			$AVE_Navigation->showNavis();
		}
		break;

	case 'entries':
		if (permCheck('navigation'))
		{
			$AVE_Navigation->showEntries($_REQUEST['id']);
		}
		break;

	case 'quicksave':
		if (permCheck('navigation_edit'))
		{
			$AVE_Navigation->quickSave($_REQUEST['id']);
		}
		break;

	case 'templates':
		if (permCheck('navigation_edit'))
		{
			include_once(BASE_DIR . '/class/class.user.php');
			$AVE_Navigation->naviTemplate($_REQUEST['id']);
		}
		break;

	case 'new':
		if (permCheck('navigation_new'))
		{
			include_once(BASE_DIR . '/class/class.user.php');
			$AVE_Navigation->naviTemplateNew();
		}
		break;

	case 'copy':
		if (permCheck('navigation_new'))
		{
			$AVE_Navigation->copyNaviTemplate($_REQUEST['id']);
		}
		break;

	case 'delete':
		if (permCheck('navigation_edit'))
		{
			$AVE_Navigation->deleteNavi($_REQUEST['id']);
		}
		break;
}
?>