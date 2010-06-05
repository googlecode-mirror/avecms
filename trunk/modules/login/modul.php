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
    $modul['ModulVersion'] = '2.2';
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
	global $AVE_DB, $AVE_Template;

	$tpl_dir   = BASE_DIR . '/modules/login/templates/';
	$lang_file = BASE_DIR . '/modules/login/lang/' . $_SESSION['user_language'] . '.txt';

	if (isset($_SESSION['user_id']) && isset($_SESSION['user_pass']))
	{
		$AVE_Template->config_load($lang_file, 'displaypanel');

		$AVE_Template->display($tpl_dir . 'userpanel.tpl');
	}
	else
	{
		$AVE_Template->config_load($lang_file, 'displayloginform');

		$active = $AVE_DB->Query("
			SELECT IstAktiv
			FROM " . PREFIX . "_modul_login
			WHERE Id = 1
		")->GetCell();

		$AVE_Template->assign('active', $active);

		$AVE_Template->display($tpl_dir . 'loginform.tpl');
	}
}

if (!defined('ACP') &&
	!empty($_REQUEST['action']) &&
	isset($_REQUEST['module']) && $_REQUEST['module'] == 'login')
{
	global $login;

	if (isset($_REQUEST['print']) && $_REQUEST['print'] == 1) print_error();

	$tpl_dir   = BASE_DIR . '/modules/login/templates/';
	$lang_file = BASE_DIR . '/modules/login/lang/' . $_SESSION['user_language'] . '.txt';

	if (! @require(BASE_DIR . '/modules/login/class.login.php')) module_error();

	$login = new Login($tpl_dir, $lang_file);

	switch($_REQUEST['action'])
	{
		case 'wys':
			if (isset($_REQUEST['sub']) && $_REQUEST['sub'] == 'on')
			{
				if (check_permission('docs')) $_SESSION['user_adminmode'] = 1;
			}
			else
			{
				unset($_SESSION['user_adminmode']);
			}

			header('Location:' . get_referer_link());
			exit;

		case 'wys_adm':
			if (isset($_REQUEST['sub']) && $_REQUEST['sub'] == 'on')
			{
				if (check_permission('docs')) $_SESSION['user_adminmode'] = 1;
			}
			else
			{
				unset($_SESSION['user_adminmode']);
			}

			header('Location:' . get_home_link());
			exit;

		case 'login':
			$login->loginUserLogin();
			break;

		case 'logout':
			$login->loginUserLogout();
			break;

		case 'register':
			$login->loginNewUserRegister();
			break;

		case 'passwordreminder':
			$login->loginUserPasswordReminder();
			break;

		case 'passwordchange':
			$login->loginUserPasswordChange();
			break;

		case 'delaccount':
			$login->loginUserAccountDelete();
			break;

		case 'profile':
			$login->loginUserProfileEdit();
			break;

		case 'checkusername':
			$login->loginUsernameAjaxCheck();
			break;

		case 'checkemail':
			$login->loginEmailAjaxCheck();
			break;
	}
}


if (defined('ACP') && !empty($_REQUEST['moduleaction']))
{
	global $login, $AVE_Template;

	$tpl_dir   = BASE_DIR . '/modules/login/templates/';
	$lang_file = BASE_DIR . '/modules/login/lang/' . $_SESSION['admin_language'] . '.txt';

	if (! @require(BASE_DIR . '/modules/login/class.login.php')) module_error();

	$login = new Login($tpl_dir, $lang_file);

	switch($_REQUEST['moduleaction'])
	{
		case '1':
			$login->loginSettingsEdit();
			break;
	}
}

?>