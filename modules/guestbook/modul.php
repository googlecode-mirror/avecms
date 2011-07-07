<?php

/**
 * AVE.cms - Модуль Гостевая книга
 *
 * @package AVE.cms
 * @subpackage module_Guestbook
 * @filesource
 */

if (!defined('BASE_DIR')) exit;

if (defined('ACP'))
{
	$modul['ModulName'] = 'Гостевая книга';
	$modul['ModulPfad'] = 'guestbook';
	$modul['ModulVersion'] = '1.0';
	$modul['description'] = 'Модуль для организации на Вашем сайте интерактивного общения между пользователями.';
	$modul['Autor'] = 'Arcanum (arcanum@php.su)';
	$modul['MCopyright'] = '&copy; 2007 (Участник команды overdoze.ru)';
	$modul['Status'] = 1;
	$modul['IstFunktion'] = 0;
	$modul['AdminEdit'] = 1;
	$modul['ModulTemplate'] = 1;
	$modul['ModulFunktion'] = null;
	$modul['CpEngineTagTpl'] = '<b>Ссылка:</b> <a target="_blank" href="../index.php?module=guestbook">index.php?module=guestbook</a>';
	$modul['CpEngineTag'] = null;
	$modul['CpPHPTag'] = null;
}

//=======================================================
// Все функции управления в публичной части
//=======================================================
if (!defined('ACP') && isset ($_REQUEST['module']) && $_REQUEST['module'] == 'guestbook')
{
	require_once (BASE_DIR . '/functions/func.modulglobals.php');
	set_modul_globals('guestbook');

	require_once (BASE_DIR . '/modules/guestbook/class.guest.php');
	$Guest = new Guest;

	$_REQUEST['action'] = isset($_REQUEST['action']) ? $_REQUEST['action'] : '';

	switch ($_REQUEST['action'])
	{
		//Если в запросе пришел параметр на создание нового сообщения, тогда
		case 'new' :
			$Guest->guestbookPostNew();
			break;

		case '' :
		default :
			$Guest->guestbookShow();
			break;
	}
}

//=======================================================
// Управление модулем в Панели управления
//=======================================================
if (defined('ACP') && !empty($_REQUEST['moduleaction']))
{
	require_once (BASE_DIR . '/modules/guestbook/class.guest.php');
	$Guest = new Guest;

	$tpl_dir = BASE_DIR . '/modules/guestbook/templates/';
	$lang_file = BASE_DIR . '/modules/guestbook/lang/' . $_SESSION['user_language'] . '.txt';

	$AVE_Template->config_load($lang_file);

	switch ($_REQUEST['moduleaction'])
	{
		case '1' :
			$Guest->guestbookSettingsEdit($tpl_dir);
			break;

		case 'medit' :
			$Guest->guestbookPostEdit();
			break;
	}
}

?>