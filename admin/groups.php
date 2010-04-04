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

global $AVE_Template, $AVE_User;

$AVE_User = new AVE_User;
$listAllGroups = $AVE_User->listAllGroups();
$AVE_Template->assign('navi_groups', $listAllGroups);
$AVE_Template->assign('navi', $AVE_Template->fetch('navi/navi.tpl'));

$AVE_Template->config_load(BASE_DIR . '/admin/lang/' . $_SESSION['admin_lang'] . '/groups.txt', 'groups');

$config_vars = $AVE_Template->get_config_vars();
$AVE_Template->assign('config_vars', $config_vars);

$_REQUEST['sub']    = (!isset($_REQUEST['sub']))    ? '' : addslashes($_REQUEST['sub']);
$_REQUEST['action'] = (!isset($_REQUEST['action'])) ? '' : addslashes($_REQUEST['action']);
$_REQUEST['submit'] = (!isset($_REQUEST['submit'])) ? '' : addslashes($_REQUEST['submit']);

switch ($_REQUEST['action'])
{
	case '':
		if (checkPermission('group'))
		{
			$AVE_Template->assign('ugroups', $listAllGroups);
			$AVE_Template->assign('content', $AVE_Template->fetch('groups/groups.tpl'));
		}
		else
		{
			define('NOPERM', 1);
		}
		break;

	case 'grouprights':
		if (checkPermission('group_edit'))
		{
			switch ($_REQUEST['sub'])
			{
				case '':
					$get_group = (isset($_REQUEST['Id']) && $_REQUEST['Id'] != '') ? (int)$_REQUEST['Id'] : 1;
					$AVE_User->fetchAllPerms($get_group);
					if($get_group==UGROUP) $AVE_Template->assign('own_group',1);
					$AVE_Template->assign('g_name', $AVE_User->fetchGroupNameById($get_group));
					$AVE_Template->assign('modules', $AVE_User->getModules());
					$AVE_Template->assign('content', $AVE_Template->fetch('groups/perms.tpl'));
					break;

				case 'save':
					$AVE_User->savePerms($_REQUEST['Id']);
					break;
			}
		}
		else
		{
			define('NOPERM', 1);
		}
		break;

	case 'new':
		if (checkPermission('group_new'))
		{
			$AVE_User->newGroup();
		}
		else
		{
			define('NOPERM', 1);
		}
		break;

	case 'delete':
		if (checkPermission('group_edit'))
		{
			$AVE_User->delGroup($_REQUEST['Id']);
		}
		else
		{
			define('NOPERM', 1);
		}
		break;
}

?>