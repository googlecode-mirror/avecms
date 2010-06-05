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

global $AVE_Template;

require(BASE_DIR . '/class/class.user.php');
$AVE_User = new AVE_User;

$AVE_Template->config_load(BASE_DIR . '/admin/lang/' . $_SESSION['admin_language'] . '/groups.txt', 'groups');

switch ($_REQUEST['action'])
{
	case '':
		if (check_permission('group'))
		{
			$AVE_User->userGroupListShow();
		}
		else
		{
			define('NOPERM', 1);
		}
		break;

	case 'grouprights':
		if (check_permission('group_edit'))
		{
			switch ($_REQUEST['sub'])
			{
				case '':
					require(BASE_DIR . '/class/class.modules.php');
					$AVE_Module = new AVE_Module;
					$AVE_User->userGroupPermissionEdit($_REQUEST['Id']);
					break;

				case 'save':
					$AVE_User->userGroupPermissionSave($_REQUEST['Id']);
					break;
			}
		}
		else
		{
			define('NOPERM', 1);
		}
		break;

	case 'new':
		if (check_permission('group_new'))
		{
			$AVE_User->userGroupNew();
		}
		else
		{
			define('NOPERM', 1);
		}
		break;

	case 'delete':
		if (check_permission('group_edit'))
		{
			$AVE_User->userGroupDelete($_REQUEST['Id']);
		}
		else
		{
			define('NOPERM', 1);
		}
		break;
}

?>