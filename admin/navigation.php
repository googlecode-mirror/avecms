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

require(BASE_DIR . '/class/class.navigation.php');
$AVE_Navigation = new AVE_Navigation;

$AVE_Template->config_load(BASE_DIR . '/admin/lang/' . $_SESSION['admin_language'] . '/navigation.txt', 'navi');

switch ($_REQUEST['action'])
{
	case '':
		if (permCheck('navigation'))
		{
			$AVE_Navigation->navigationList();
		}
		break;

	case 'new':
		if (permCheck('navigation_new'))
		{
			require(BASE_DIR . '/class/class.user.php');
			$AVE_User = new AVE_User;

			$AVE_Navigation->navigationNew();
		}
		break;

	case 'templates':
		if (permCheck('navigation_edit'))
		{
			require(BASE_DIR . '/class/class.user.php');
			$AVE_User = new AVE_User;

			$AVE_Navigation->navigationEdit($_REQUEST['id']);
		}
		break;

	case 'copy':
		if (permCheck('navigation_new'))
		{
			$AVE_Navigation->navigationCopy($_REQUEST['id']);
		}
		break;

	case 'delete':
		if (permCheck('navigation_edit'))
		{
			$AVE_Navigation->navigationDelete($_REQUEST['id']);
		}
		break;

	case 'entries':
		if (permCheck('navigation'))
		{
			$AVE_Navigation->navigationItemList($_REQUEST['id']);
		}
		break;

	case 'quicksave':
		if (permCheck('navigation_edit'))
		{
			$AVE_Navigation->navigationItemEdit($_REQUEST['id']);
		}
		break;
}
?>