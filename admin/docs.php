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

include_once(BASE_DIR . '/class/class.docs.php');
include_once(BASE_DIR . '/class/class.queries.php');
include_once(BASE_DIR . '/class/class.navigation.php');

$AVE_Document = new AVE_Document;
$AVE_Query = new AVE_Query;
$AVE_Navigation = new AVE_Navigation;

$AVE_Document->rediRubs();
$AVE_Document->tplTimeAssign();

$AVE_Template->assign('navi', $AVE_Template->fetch('navi/navi.tpl'));

$AVE_Template->config_load(BASE_DIR . '/admin/lang/' . $_SESSION['admin_lang'] . '/docs.txt', 'docs');
$config_vars = $AVE_Template->get_config_vars();
//$AVE_Template->assign('config_vars', $config_vars);

$_REQUEST['sub']    = (!isset($_REQUEST['sub']))    ? '' : addslashes($_REQUEST['sub']);
$_REQUEST['action'] = (!isset($_REQUEST['action'])) ? '' : addslashes($_REQUEST['action']);
$_REQUEST['submit'] = (!isset($_REQUEST['submit'])) ? '' : addslashes($_REQUEST['submit']);

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
			$AVE_Document->showDocs();
		}
		$AVE_Template->assign('content', $AVE_Template->fetch('documents/docs.tpl'));
		break;

	case 'showsimple':
		if (permCheck('docs'))
		{
			$AVE_Document->showDocs();
			$AVE_Template->assign('content', $AVE_Template->fetch('documents/docs_simple.tpl'));
		}
		break;

	case 'edit':
		if (permCheck('docs'))
		{
			$AVE_Navigation->showAllEntries();
			$AVE_Query->showQueries('extern');
			$AVE_Document->editDoc((int)$_REQUEST['Id']);
		}
		break;

	case 'new':
		if (permCheck('docs'))
		{
			$AVE_Navigation->showAllEntries();
			$AVE_Query->showQueries('extern');
			$AVE_Document->newDoc((int)$_REQUEST['RubrikId']);
		}
		break;

	case 'open':
		if (permCheck('docs'))
		{
			$AVE_Navigation->statusNavi('1', $_REQUEST['Id']);
			$AVE_Document->openCloseDoc($_REQUEST['Id'], '1');
		}
		break;

	case 'close':
		if (permCheck('docs'))
		{
			$AVE_Navigation->statusNavi('0', $_REQUEST['Id']);
			$AVE_Document->openCloseDoc($_REQUEST['Id'], '0');
		}
		break;

	case 'delete':
		if (permCheck('docs'))
		{
			$AVE_Navigation->statusNavi('0', $_REQUEST['Id']);
			$AVE_Document->delDoc($_REQUEST['Id']);
		}
		break;

	case 'redelete':
		if (UGROUP == 1)
		{
			$AVE_Navigation->statusNavi('1', $_REQUEST['Id']);
			$AVE_Document->redelDoc($_REQUEST['Id']);
		}
		else
		{
			define('NOPERM', 1);
		}
		break;

	case 'enddelete':
		if (UGROUP == 1)
		{
			$AVE_Navigation->delNavi($_REQUEST['Id']);
			$AVE_Document->enddelDoc($_REQUEST['Id']);
		}
		else
		{
			define('NOPERM', 1);
		}
		break;

	case 'comment':
		if (checkPermission('docs_comments'))
		{
			$AVE_Document->newComment();
		}
		else
		{
			define('NOPERM', 1);
		}
		break;

	case 'comment_reply':
		if (checkPermission('docs_comments'))
		{
			$AVE_Document->newComment(1);
		}
		else
		{
			define('NOPERM', 1);
		}
		break;

	case 'openclose_discussion':
		if (checkPermission('comments_openlose'))
		{
			$AVE_Document->openCloseDiscussion();
		}
		else
		{
			define('NOPERM', 1);
		}
		break;

	case 'del_comment':
		if (checkPermission('docs_comments_del'))
		{
			$AVE_Document->delComment($_REQUEST['KommentarStart']);
		}
		else
		{
			define('NOPERM', 1);
		}
		break;

	case 'change':
		if (permCheck('docs'))
		{
			$AVE_Document->changeRubs();
		}
		break;

	case 'translit':
		echo($AVE_Document->translit());
		exit;
		break;

	case 'checkurl':
		echo($AVE_Document->checkurl());
		exit;
		break;
}

?>