<?php

/**
 * AVE.cms
 *
 * @package AVE.cms
 * @subpackage admin
 * @filesource
 */

@error_reporting(E_ALL | E_STRICT);
@ini_set('display_errors', true);
@ini_set('html_errors', true);
@ini_set('error_reporting', E_ALL | E_STRICT);
@date_default_timezone_set('Europe/Moscow');

define('ACP', 1);
define('ACPL', 1);
define('BASE_DIR', str_replace("\\", "/", dirname(dirname(__FILE__))));

if (! @filesize(BASE_DIR . '/inc/db.config.php')) { header('Location:../install.php'); exit; }

require(BASE_DIR . '/admin/init.php');

if (isset($_REQUEST['do']) && $_REQUEST['do'] == 'logout')
{
	// Завершение работы в админке
	reportLog($_SESSION['user_name'] . ' - закончил сеанс в Панели управления', 2, 2);
	@session_destroy();
	header('Location:admin.php');
}

//// Если в сессии нет темы оформления или языка
//// и в запросе нет действия - отправляем на форму авторизации
//if  (!isset($_REQUEST['action']) &&
//	(!isset($_SESSION['admin_theme']) || !isset($_SESSION['admin_language'])))
//{
//	$AVE_Template->display('login.tpl');
//	exit;
//}

if (isset($_REQUEST['action']) && $_REQUEST['action'] == 'login')
{
	// Авторизация
	if (!empty($_POST['user_login']) && !empty($_POST['user_pass']))
	{
		if (user_login($_POST['user_login'], $_POST['user_pass'], 1))
		{
            if (!empty($_SESSION['redirectlink']))
            {
                header('Location:' . $_SESSION['redirectlink']);
                unset($_SESSION['redirectlink']);
                exit;
            }

            reportLog($_SESSION['user_name']
            			. ' - начал сеанс в Панели управления', 2, 2);

            header('Location:index.php');
            exit;
		}
        reportLog('Ошибка при входе в Панель управления - '
        			. stripslashes($_POST['user_login']) . ' / '
        			. stripslashes($_POST['user_pass']), 2, 2);

        unset($_SESSION['user_id'], $_SESSION['user_pass']);
	}
}

$AVE_Template->display('login.tpl');

?>