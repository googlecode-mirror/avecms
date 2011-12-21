<?php

if(!defined('BASE_DIR')) exit;

if (defined('ACP'))
{
    $modul['ModulName'] = 'Опросы';
    $modul['ModulPfad'] = 'poll';
    $modul['ModulVersion'] = '1.0';
    $modul['description'] = 'Данный модуль предназачен для организации системы опросов на сайте. Возможности модуля позволяют создавать неограниченное количество опросных листов, а также неограниченное количество вопросов.';
    $modul['Autor'] = 'Arcanum';
    $modul['MCopyright'] = '&copy; 2008 Overdoze.Ru';
    $modul['Status'] = 1;
    $modul['IstFunktion'] = 1;
    $modul['ModulTemplate'] = 1;
    $modul['AdminEdit'] = 1;
    $modul['ModulFunktion'] = 'mod_poll';
    $modul['CpEngineTagTpl'] = '[mod_poll:XXX]';
    $modul['CpEngineTag'] = '#\\\[mod_poll:(\\\d+)]#';
    $modul['CpPHPTag'] = "<?php mod_poll(''$1''); ?>";
}

function mod_poll($poll_id)
{
	require_once(BASE_DIR . '/modules/poll/class.poll.php');
	require_once(BASE_DIR . '/modules/poll/funcs/func.rewrite.php');

	$poll = new Poll;

	$tpl_dir   = BASE_DIR . '/modules/poll/templates/';
	$lang_file = BASE_DIR . '/modules/poll/lang/' . $_SESSION['user_language'] . '.txt';

	$poll->pollShow($tpl_dir, $lang_file, stripslashes($poll_id));
}

if (!defined('ACP')
	&& isset($_REQUEST['module']) && $_REQUEST['module'] == 'poll'
	&& isset($_REQUEST['action']))
{
	require_once(BASE_DIR . '/modules/poll/class.poll.php');
	require_once(BASE_DIR . '/modules/poll/funcs/func.rewrite.php');

	$poll = new Poll;

	$tpl_dir   = BASE_DIR . '/modules/poll/templates/';
	$lang_file = BASE_DIR . '/modules/poll/lang/' . $_SESSION['user_language'] . '.txt';

	switch ($_REQUEST['action'])
	{
		case 'result':
			$poll->pollResultShow($tpl_dir, $lang_file, (int)$_REQUEST['pid']);
			break;

		case 'vote':
			$poll->pollVote((int)$_REQUEST['pid']);
			break;

		case 'archive':
			$poll->pollArchiveShow($tpl_dir, $lang_file);
			break;

		case 'form':
			$poll->pollCommentShow($tpl_dir, $lang_file, (int)$_REQUEST['pid'], THEME_FOLDER);
			break;

		case 'comment':
			$poll->pollCommentNew($tpl_dir, $lang_file, (int)$_REQUEST['pid']);
			break;
	}
}

if (defined('ACP') && !empty($_REQUEST['moduleaction']))
{
	require_once(BASE_DIR . '/modules/poll/class.poll.php');
	require_once(BASE_DIR . '/modules/poll/funcs/func.rewrite.php');

	$poll = new Poll;

	$tpl_dir   = BASE_DIR . '/modules/poll/templates/';
	$lang_file = BASE_DIR . '/modules/poll/lang/' . $_SESSION['user_language'] . '.txt';

	switch ($_REQUEST['moduleaction'])
	{
		case '1':
			$poll->pollList($tpl_dir, $lang_file);
			break;

		case 'new':
			$poll->pollNew($tpl_dir, $lang_file);
			break;

		case 'save_new':
			$poll->pollNewItemSave((int)$_REQUEST['id']);
			break;

		case 'edit':
			$poll->pollEdit($tpl_dir, $lang_file, (int)$_REQUEST['id']);
			break;

		case 'save':
			$poll->pollSave((int)$_REQUEST['id']);
			break;

		case 'delete':
			$poll->pollDelete((int)$_REQUEST['id']);
			break;

		case 'comments':
			$poll->pollCommentEdit($tpl_dir, $lang_file, (int)$_REQUEST['id']);
			break;
	}
}

?>