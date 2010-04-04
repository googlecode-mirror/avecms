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
    $modul['ModulVersion'] = '1.1';
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
	$lang_file = BASE_DIR . '/modules/comment/lang/' . DEFAULT_LANGUAGE . '.txt';
	$AVE_Template->config_load($lang_file);

	$comment->displayComments($tpl_dir);
}

if (isset($_REQUEST['module']) && $_REQUEST['module'] == 'comment' && isset($_REQUEST['action']))
{
	require_once(BASE_DIR . '/modules/comment/class.comment.php');
//	require_once(BASE_DIR . '/functions/func.modulglobals.php');

//	modulGlobals('comment');
	$comment = new Comment;

    $tpl_dir = BASE_DIR . '/modules/comment/templates/';
    $lang_file = BASE_DIR . '/modules/comment/lang/' . DEFAULT_LANGUAGE . '.txt';
    $AVE_Template->config_load($lang_file);

	switch($_REQUEST['action'])
	{
		case 'form':
			$comment->displayForm($tpl_dir);
			break;

		case 'postinfo':
			$comment->postInfo($tpl_dir);
			break;

		case 'comment':
			$comment->newComment($tpl_dir);
			break;

		case 'edit':
			$comment->editComment($_REQUEST['Id']);
			break;

		case 'delete':
			if (UGROUP==1) $comment->deleteComment((int)$_REQUEST['Id']);
			break;

		case 'lock':
		case 'unlock':
			if (UGROUP==1) $comment->setStatusComment((int)$_REQUEST['Id'], $_REQUEST['action']);
			break;

		case 'open':
		case 'close':
			if (UGROUP==1) $comment->setStatusComments((int)$_REQUEST['docid'], $_REQUEST['action']);
			break;
	}
}

if (defined('ACP') &&
    isset($_REQUEST['mod']) && $_REQUEST['mod'] == 'comment' &&
    !(isset($_REQUEST['action']) && $_REQUEST['action'] == 'delete'))
{
	require_once(BASE_DIR . '/modules/comment/sql.php');
	require_once(BASE_DIR . '/modules/comment/class.comment.php');
//	require_once(BASE_DIR . '/functions/func.modulglobals.php');

	$comment = new Comment;

    $tpl_dir   = BASE_DIR . '/modules/comment/templates/';
    $lang_file = BASE_DIR . '/modules/comment/lang/' . $_SESSION['admin_lang'] . '.txt';

	$AVE_Template->config_load($lang_file, 'admin');
//	$config_vars = $AVE_Template->get_config_vars();
//	$AVE_Template->assign('config_vars', $config_vars);

	if (!empty($_REQUEST['moduleaction']))
	{
		switch ($_REQUEST['moduleaction'])
		{
			case '1':
				$comment->showComments($tpl_dir);
				break;

            case 'admin_edit':
                $comment->editCommentAdmin($tpl_dir);
                break;

			case 'settings':
				$comment->settings($tpl_dir);
				break;
		}
	}
}

?>