<?php

/**
 * AVE.cms
 *
 * @package AVE.cms
 * @subpackage admin
 * @filesource
 */

define('ACP', 1);

define('BASE_DIR', str_replace("\\", "/", substr(dirname(__FILE__), 0, -6)));

require_once(BASE_DIR . '/admin/init.php');

if (isset($_REQUEST['do']) && $_REQUEST['do'] == 'logout')
{
	// Завершение работы в админке
	reportLog($_SESSION['user_name'] . ' - закончил сеанс в Панели управления', 2, 2);
	@session_destroy();
	header('Location:admin.php');
}

// Если в сессии нет темы оформления или языка и в запросе нет действия - отправляем на форму авторизации
if ((!isset($_SESSION['admin_theme']) || !isset($_SESSION['admin_lang'])) && !isset($_REQUEST['action']))
{
	$AVE_Template->display('login.tpl');
	exit;
}

if (isset($_REQUEST['action']) && $_REQUEST['action'] == 'login')
{
	// Авторизация
	if (!empty($_POST['user_login']) && !empty($_POST['user_pass']))
	{
		sleep(1);

        $row = $AVE_DB->Query("
            SELECT
                usr.Id,
                usr.Benutzergruppe,
                UserName,
                Vorname,
                Nachname,
                Email,
                Land,
                Rechte,
                Kennwort,
                salt,
                `Status`
			FROM
				" . PREFIX . "_users AS usr
			JOIN
				" . PREFIX . "_user_groups AS grp
					ON grp.Benutzergruppe = usr.Benutzergruppe
            WHERE Email = '" . $_POST['user_login'] . "'
            OR `UserName` = '" . $_POST['user_login'] . "'
            LIMIT 1
        ")->FetchRow();

		switch ($row->Status)
		{
			case 1:
                $password = md5(md5(trim($_POST['user_pass']) . $row->salt));

                if ($password == $row->Kennwort)
                {
                    $AVE_DB->Query("
                        UPDATE " . PREFIX . "_users
                        SET ZuletztGesehen = " . time() . "
                        WHERE Id = " . $row->Id . "
                    ");

                    $row->Rechte = str_replace(array(' ', "\n", "\r\n"), '', $row->Rechte);
                    $permissions = explode('|', $row->Rechte);
                    foreach($permissions as $permission) $_SESSION[$permission] = 1;

                    $_SESSION['user_id'] = $row->Id;
                    $_SESSION['user_group'] = $row->Benutzergruppe;
                    $_SESSION['user_name'] = htmlspecialchars(empty($row->UserName) ? $row->Vorname . ' ' . $row->Nachname : $row->UserName);
                    $_SESSION['user_pass'] = $password;
                    $_SESSION['user_email'] = $row->Email;
                    $_SESSION['user_country'] = strtoupper($row->Land);
                    $_SESSION['admin_lang'] = $_REQUEST['lang'];
                    $_SESSION['admin_theme'] = $_REQUEST['theme'];

                    if (!empty($_SESSION['redirectlink']))
                    {
                        header('Location:' . $_SESSION['redirectlink']);
                        unset($_SESSION['redirectlink']);
                        exit;
                    }

                    define('UID', $row->Id);

                    reportLog($row->UserName . '  - начал сеанс в Панели управления', 2, 2);

                    echo '<meta http-equiv="refresh" content="0;URL=index.php">';
                }
                else
                {
                    reportLog('Ошибка при входе в Панель управления - ' . $_POST['user_login'] . ' / ' . $_POST['user_pass'], 2, 2);

                    unset($_SESSION['user_id'], $_SESSION['user_pass']);

                    header('Location:admin.php?login=false');
                }
				break;

			default:
				reportLog('Ошибка при входе в Панель управления - ' . $_POST['user_login'] . ' / ' . $_POST['user_pass'], 2, 2);

                unset($_SESSION['user_id'], $_SESSION['user_pass']);

				header('Location:admin.php?login=false');
				break;
		}
	}
	else
	{
		reportLog('Ошибка при входе в Панель управления - ' . $_POST['user_login'] . ' / ' . $_POST['user_pass'], 2, 2);

        unset($_SESSION['user_id'], $_SESSION['user_pass']);

		header('Location:admin.php?login=false');
	}
}
else
{
	$AVE_Template->display('login.tpl');
}

?>