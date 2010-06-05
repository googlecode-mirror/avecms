<?php

/**
 * AVE.cms - Модуль Комментарии
 *
 * @package AVE.cms
 * @subpackage module_Comment
 * @filesource
 */

if (!defined('BASE_DIR')) exit;

if (defined('ACP'))
{
    $modul['ModulName'] = 'Комментарии';
    $modul['ModulPfad'] = 'comment';
    $modul['ModulVersion'] = '1.2';
    $modul['Beschreibung'] = 'Данный модуль предназначен для организации системы комментариев для документов на сайте. Для того, чтобы использовать данный модуль, разместите системный тег <strong>[mod_comment]</strong> в нужном месте шаблона рубрики.';
    $modul['Autor'] = 'Arcanum';
    $modul['MCopyright'] = '&copy; 2007 Overdoze Team';
    $modul['Status'] = 1;
    $modul['IstFunktion'] = 1;
    $modul['ModulTemplate'] = 0;
    $modul['AdminEdit'] = 1;
    $modul['ModulFunktion'] = 'mod_comment';
    $modul['CpEngineTagTpl'] = '[mod_comment]';
    $modul['CpEngineTag'] = '#\\\[mod_comment]#';
    $modul['CpPHPTag'] = '<?php mod_comment(); ?>';
}

global $AVE_Template;

/**
 * Обработка тэга модуля
 *
 */
function mod_comment()
{
	global $AVE_Template;

	require_once(BASE_DIR . '/modules/comment/class.comment.php');
	$comment = new Comment;

	$tpl_dir = BASE_DIR . '/modules/comment/templates/';
	$lang_file = BASE_DIR . '/modules/comment/lang/' . $_SESSION['user_language'] . '.txt';
	$AVE_Template->config_load($lang_file);

	$comment->commentListShow($tpl_dir);
}

/**
 * Управление комментариями в публичной части
 */
if (!defined('ACP') &&
	isset($_REQUEST['module']) && $_REQUEST['module'] == 'comment' &&
	isset($_REQUEST['action']))
{
	require_once(BASE_DIR . '/modules/comment/class.comment.php');
	$comment = new Comment;

    $tpl_dir = BASE_DIR . '/modules/comment/templates/';
    $lang_file = BASE_DIR . '/modules/comment/lang/' . $_SESSION['user_language'] . '.txt';
    $AVE_Template->config_load($lang_file);

	switch($_REQUEST['action'])
	{
		case 'form':
			$comment->commentPostFormShow($tpl_dir);
			break;

		case 'comment':
			$comment->commentPostNew($tpl_dir);
			break;

		case 'edit':
			$comment->commentPostEdit((int)$_REQUEST['Id']);
			break;

		case 'delete':
			if (UGROUP==1)
			{
				$comment->commentPostDelete((int)$_REQUEST['Id']);
			}
			break;

		case 'postinfo':
			$comment->commentPostInfoShow($tpl_dir);
			break;

		case 'lock':
		case 'unlock':
			if (UGROUP==1)
			{
				$comment->commentReplyStatusSet((int)$_REQUEST['Id'], $_REQUEST['action']);
			}
			break;

		case 'open':
		case 'close':
			if (UGROUP==1)
			{
				$comment->commentStatusSet((int)$_REQUEST['docid'], $_REQUEST['action']);
			}
			break;
	}
}

/**
 * Управление комментариями в административной части
 */
if (defined('ACP') && !empty($_REQUEST['moduleaction']))
{
	global $AVE_User;

	require_once(BASE_DIR . '/modules/comment/class.comment.php');
	$comment = new Comment;

    $tpl_dir   = BASE_DIR . '/modules/comment/templates/';
    $lang_file = BASE_DIR . '/modules/comment/lang/' . $_SESSION['admin_language'] . '.txt';
	$AVE_Template->config_load($lang_file, 'admin');

	switch ($_REQUEST['moduleaction'])
	{
		case '1':
			$comment->commentAdminListShow($tpl_dir);
			break;

        case 'admin_edit':
            $comment->commentAdminPostEdit($tpl_dir);
            break;

		case 'settings':
			require_once(BASE_DIR . '/class/class.user.php');
			$AVE_User = new AVE_User;
			$AVE_Template->assign('groups', $AVE_User->userGroupListGet());

			$comment->commentAdminSettingsEdit($tpl_dir);
			break;
	}
}

?>