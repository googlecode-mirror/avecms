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

global $AVE_Template, $AVE_User;

$AVE_User = new AVE_User;
$AVE_User->listUser();

$AVE_Template->assign('navi', $AVE_Template->fetch('navi/navi.tpl'));

$AVE_Template->config_load(BASE_DIR . '/admin/lang/' . $_SESSION['admin_lang'] . '/user.txt', 'user');
$config_vars = $AVE_Template->get_config_vars();
$AVE_Template->assign('config_vars', $config_vars);

$_REQUEST['sub']    = (!isset($_REQUEST['sub']))    ? '' : addslashes($_REQUEST['sub']);
$_REQUEST['action'] = (!isset($_REQUEST['action'])) ? '' : addslashes($_REQUEST['action']);
$_REQUEST['submit'] = (!isset($_REQUEST['submit'])) ? '' : addslashes($_REQUEST['submit']);

switch($_REQUEST['action'])
{
	case '':
		if(permCheck('user'))
		{
			$AVE_Template->assign('content', $AVE_Template->fetch('user/users.tpl'));
		}
		break;

	case 'edit':
		if(permCheck('user_edit'))
		{
			$AVE_User->editUser($_REQUEST['Id']);
		}
		break;

	case 'new':
		if(permCheck('user_new'))
		{
			$AVE_User->newUser();
		}
		break;

	case 'delete':
		if(permCheck('user_loesch'))
		{
			$AVE_User->deleteUser($_REQUEST['Id']);
		}
		break;

	case 'quicksave':
		if(permCheck('user_edit'))
		{
			$AVE_User->quicksaveUser();
		}
		break;
}

?>