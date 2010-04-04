<?php

/**
 * AVE.cms - Модуль Авторизация
 *
 * @package AVE.cms
 * @subpackage module_Login
 * @filesource
 */

if (!defined('BASE_DIR')) exit;

if (defined('ACP'))
{
    $modul['ModulName'] = 'Авторизация';
    $modul['ModulPfad'] = 'login';
    $modul['ModulVersion'] = '2.1';
    $modul['Beschreibung'] = 'Данный модуль предназначен для регистрации пользователей на вашем сайте. Для вывода формы авторизации, разместите системный тег <strong>[mod_login]</strong> в нужном месте вашего шаблона. Также вы можете указать шаблон, в котором будет отображена форма для регистрации и авторизации.';
    $modul['Autor'] = 'Arcanum';
    $modul['MCopyright'] = '&copy; 2007 Overdoze Team';
    $modul['Status'] = 1;
    $modul['IstFunktion'] = 1;
    $modul['ModulTemplate'] = 1;
    $modul['AdminEdit'] = 1;
    $modul['ModulFunktion'] = 'mod_login';
    $modul['CpEngineTagTpl'] = '[mod_login]';
    $modul['CpEngineTag'] = '#\\\[mod_login]#';
    $modul['CpPHPTag'] = '<?php mod_login(); ?>';
}

/**
 * Обработка тэга модуля
 *
 */
function mod_login()
{
	global $login;

	if (! @require_once(BASE_DIR . '/modules/login/class.login.php')) moduleError();
	$login = new Login;

	$tpl_dir   = BASE_DIR . '/modules/login/templates/';
	$lang_file = BASE_DIR . '/modules/login/lang/' . DEFAULT_LANGUAGE . '.txt';

	if (isset($_SESSION['user_id']) && isset($_SESSION['user_pass']))
	{
		$login->displayPanel($tpl_dir, $lang_file);
	}
	else
	{
		$login->displayLoginform($tpl_dir, $lang_file);
	}
}

if (!defined('ACP') && isset($_REQUEST['action']) && isset($_REQUEST['module']) && $_REQUEST['module'] == 'login')
{
	global $login;

	if (isset($_REQUEST['print']) && $_REQUEST['print'] == 1) printError();

	if (!@require_once(BASE_DIR . '/modules/login/class.login.php')) moduleError();
	$login = new Login;

	$tpl_dir   = BASE_DIR . '/modules/login/templates/';
	$lang_file = BASE_DIR . '/modules/login/lang/' . DEFAULT_LANGUAGE . '.txt';

	switch($_REQUEST['action'])
	{
		case 'wys':
			if (isset($_REQUEST['sub']) && $_REQUEST['sub'] == 'on')
			{
				if (checkPermission('docs')) $_SESSION['user_adminmode'] = 1;
			}
			else
			{
				unset($_SESSION['user_adminmode']);
			}
			header('Location:' . $_SERVER['HTTP_REFERER']);
			exit;
			break;

		case 'wys_adm':
			if (isset($_REQUEST['sub']) && $_REQUEST['sub'] == 'on')
			{
				if (checkPermission('docs')) $_SESSION['user_adminmode'] = 1;
			}
			else
			{
				unset($_SESSION['user_adminmode']);
			}
			header('Location:' . $_SERVER['PHP_SELF']);
			exit;
			break;

		case 'login':
			$login->loginProcess($tpl_dir, $lang_file);
			break;

		case 'logout':
			$login->loginProcess($tpl_dir, $lang_file, 1);
			break;

		case 'register':
			$login->registerNew($tpl_dir, $lang_file);
			break;

		case 'passwordreminder':
			$login->passwordReminder($tpl_dir, $lang_file);
			break;

		case 'passwordchange':
			$login->passwordChange($tpl_dir, $lang_file);
			break;

		case 'delaccount':
			$login->delAccount($tpl_dir, $lang_file);
			break;

		case 'profile':
			$login->myProfile($tpl_dir, $lang_file);
			break;
	}
}


if (defined('ACP') && !(isset($_REQUEST['action']) && $_REQUEST['action'] == 'delete'))
{
	global $login, $AVE_Template;

	require_once(BASE_DIR . '/modules/login/sql.php');
	if (!@require_once(BASE_DIR . '/modules/login/class.login.php')) moduleError();
	$login = new Login;

	$tpl_dir   = BASE_DIR . '/modules/login/templates/';
	$lang_file = BASE_DIR . '/modules/login/lang/' . $_SESSION['admin_lang'] . '.txt';

	if (isset($_REQUEST['moduleaction']) && $_REQUEST['moduleaction'] != '')
	{
		switch($_REQUEST['moduleaction'])
		{
			case '1':
				$login->showConfig($tpl_dir, $lang_file);
				break;
		}
	}
}

?>