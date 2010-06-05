<?php

if(!defined('BASE_DIR')) exit;

if (defined('ACP'))
{
    $modul['ModulName'] = '������';
    $modul['ModulPfad'] = 'poll';
    $modul['ModulVersion'] = '1.0';
    $modul['Beschreibung'] = '������ ������ ����������� ��� ����������� ������� ������� �� �����. ����������� ������ ��������� ��������� �������������� ���������� �������� ������, � ����� �������������� ���������� ��������.';
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

	$tpl_dir   = BASE_DIR . '/modules/poll/templates/';
	$lang_file = BASE_DIR . '/modules/poll/lang/' . $_SESSION['user_language'] . '.txt';

	$poll = new poll;
	$poll->showPoll($tpl_dir, $lang_file, stripslashes($poll_id));
}

if (isset($_REQUEST['module']) && $_REQUEST['module'] == 'poll' && isset($_REQUEST['action']))
{
	require_once(BASE_DIR . '/modules/poll/class.poll.php');
	require_once(BASE_DIR . '/modules/poll/funcs/func.rewrite.php');

	$poll = new poll;

	$tpl_dir   = BASE_DIR . '/modules/poll/templates/';
	$lang_file = BASE_DIR . '/modules/poll/lang/' . $_SESSION['user_language'] . '.txt';

	switch ($_REQUEST['action'])
	{
		case 'result':
			$poll->showResult($tpl_dir, $lang_file, (int)$_REQUEST['pid']);
			break;

		case 'vote':
			$poll->vote((int)$_REQUEST['pid']);
			break;

		case 'archive':
			$poll->showArchive($tpl_dir, $lang_file);
			break;

		case 'form':
			$poll->displayForm($tpl_dir, $lang_file, (int)$_REQUEST['pid'], $_REQUEST['theme_folder']);
			break;

		case 'comment':
			$poll->sendForm($tpl_dir, $lang_file, (int)$_REQUEST['pid']);
			break;
	}
}

if (defined('ACP') && !empty($_REQUEST['moduleaction']))
{
	global $AVE_Template;

	require_once(BASE_DIR . '/modules/poll/class.poll.php');
	require_once(BASE_DIR . '/modules/poll/funcs/func.rewrite.php');

	$tpl_dir   = BASE_DIR . '/modules/poll/templates/';
	$lang_file = BASE_DIR . '/modules/poll/lang/' . $_SESSION['user_language'] . '.txt';

	$poll = new poll;

	switch ($_REQUEST['moduleaction'])
	{
		case '1':
			$poll->showPolls($tpl_dir, $lang_file);
			break;

		case 'edit':
			$poll->editPolls($tpl_dir, $lang_file, (int)$_REQUEST['id']);
			break;

		case 'save_new':
			$poll->saveFieldsNew((int)$_REQUEST['id']);
			break;

		case 'save':
			$poll->savePolls((int)$_REQUEST['id']);
			break;

		case 'new':
			$poll->newPolls($tpl_dir, $lang_file);
			break;

		case 'delete':
			$poll->deletePolls((int)$_REQUEST['id']);
			break;

		case 'comments':
			$poll->showComments($tpl_dir, $lang_file, (int)$_REQUEST['id']);
			break;
	}
}

?>