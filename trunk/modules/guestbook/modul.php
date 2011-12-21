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
	$modul['ModulVersion'] = '1.1';
	$modul['description'] = 'Модуль для организации на Вашем сайте интерактивного общения между пользователями.';
	$modul['Autor'] = 'Arcanum (arcanum@php.su)';
	$modul['MCopyright'] = '&copy; 2007 (Участник команды overdoze.ru)';
	$modul['Status'] = 1;
	$modul['IstFunktion'] = 1;
	$modul['AdminEdit'] = 1;
	$modul['ModulTemplate'] = 1;
	$modul['ModulFunktion'] = 'mod_guestbook';
	$modul['CpEngineTagTpl'] = '<b>Ссылка:</b> <a target="_blank" href="../index.php?module=guestbook">index.php?module=guestbook</a> или <b>тег</b>: [mod_guestbook]';
    $modul['CpEngineTag'] = '#\\\[mod_guestbook]#'; // Сам системный тег, который будет использоваться в шаблонах
    $modul['CpPHPTag'] = '<?php mod_guestbook(); ?>';  // PHP-код, который будет вызван вместо системного тега, при парсинге шаблона
}


function mod_guestbook()
{
	require_once (BASE_DIR . '/functions/func.modulglobals.php');
	set_modul_globals('guestbook');
	
	require_once (BASE_DIR . '/modules/guestbook/class.guest.php');
	$Guest = new Guest;
	$Guest->guestbookShow("standalone");
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