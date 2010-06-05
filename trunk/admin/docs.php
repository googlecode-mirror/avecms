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

require(BASE_DIR . '/class/class.docs.php');
require(BASE_DIR . '/class/class.rubs.php');
require(BASE_DIR . '/class/class.navigation.php');
require(BASE_DIR . '/class/class.request.php');

$AVE_Document   = new AVE_Document;
$AVE_Rubric     = new AVE_Rubric;
$AVE_Navigation = new AVE_Navigation;
$AVE_Request    = new AVE_Request;

$AVE_Document->documentTemplateTimeAssign();

$AVE_Rubric->rubricPermissionFetch();

$AVE_Template->config_load(BASE_DIR . '/admin/lang/' . $_SESSION['admin_language'] . '/docs.txt', 'docs');

switch($_REQUEST['action'])
{
	case '' :
		if (permCheck('docs'))
		{
			switch($_REQUEST['sub'])
			{
				case 'quicksave':
					$AVE_Document->quickSave();
					break;
			}
			$AVE_Document->documentListGet();
		}
		$AVE_Template->assign('DEF_DOC_START_YEAR', mktime(0, 0, 0, date("m"), date("d"), date("Y") - 10));
		$AVE_Template->assign('DEF_DOC_END_YEAR', mktime(0, 0, 0, date("m"), date("d"), date("Y") + 20));
		$AVE_Template->assign('content', $AVE_Template->fetch('documents/docs.tpl'));
		break;

	case 'showsimple':
		if (permCheck('docs'))
		{
			$AVE_Document->documentListGet();
			$AVE_Template->assign('content', $AVE_Template->fetch('documents/docs_simple.tpl'));
		}
		break;

	case 'edit':
		if (permCheck('docs'))
		{
			$AVE_Navigation->navigationAllItemList();
			$AVE_Request->requestListFetch();
			$AVE_Document->documentEdit((int)$_REQUEST['Id']);
		}
		break;

	case 'new':
		if (permCheck('docs'))
		{
			$AVE_Navigation->navigationAllItemList();
			$AVE_Request->requestListFetch();
			$AVE_Document->documentNew((int)$_REQUEST['RubrikId']);
		}
		break;

	case 'open':
		if (permCheck('docs'))
		{
			$AVE_Navigation->navigationItemStatusOn((int)$_REQUEST['Id']);
			$AVE_Document->documentStatusSet((int)$_REQUEST['Id'], '1');
		}
		break;

	case 'close':
		if (permCheck('docs'))
		{
			$AVE_Navigation->navigationItemStatusOff((int)$_REQUEST['Id']);
			$AVE_Document->documentStatusSet((int)$_REQUEST['Id'], '0');
		}
		break;

	case 'delete':
		if (permCheck('docs'))
		{
			$AVE_Navigation->navigationItemStatusOff((int)$_REQUEST['Id']);
			$AVE_Document->documentMarkDelete((int)$_REQUEST['Id']);
		}
		break;

	case 'redelete':
		if (UGROUP == 1)
		{
			$AVE_Navigation->navigationItemStatusOn((int)$_REQUEST['Id']);
			$AVE_Document->documentUndelete((int)$_REQUEST['Id']);
		}
		else
		{
			define('NOPERM', 1);
		}
		break;

	case 'enddelete':
		if (UGROUP == 1)
		{
			$AVE_Navigation->navigationItemDelete((int)$_REQUEST['Id']);
			$AVE_Document->documentDelete((int)$_REQUEST['Id']);
		}
		else
		{
			define('NOPERM', 1);
		}
		break;

	case 'comment':
		if (check_permission('docs_comments'))
		{
			$AVE_Document->documentRemarkNew((int)$_REQUEST['Id'], 0);
		}
		else
		{
			define('NOPERM', 1);
		}
		break;

	case 'comment_reply':
		if (check_permission('docs_comments'))
		{
			$AVE_Document->documentRemarkNew((int)$_REQUEST['Id'], 1);
		}
		else
		{
			define('NOPERM', 1);
		}
		break;

	case 'openclose_discussion':
		if (check_permission('comments_openlose'))
		{
			$AVE_Document->documentRemarkStatus((int)$_REQUEST['Id'], (int)$_REQUEST['Aktiv']);
		}
		else
		{
			define('NOPERM', 1);
		}
		break;

	case 'del_comment':
		if (check_permission('docs_comments_del'))
		{
			$AVE_Document->documentRemarkDelete((int)$_REQUEST['Id'], (int)$_REQUEST['KommentarStart']);
		}
		else
		{
			define('NOPERM', 1);
		}
		break;

	case 'change':
		if (permCheck('docs'))
		{
			$AVE_Document->documentRubricChange();
		}
		break;

	case 'translit':
		echo($AVE_Document->documentAliasCreate());
		exit;

	case 'checkurl':
		echo($AVE_Document->documentAliasCheck());
		exit;
}

?>