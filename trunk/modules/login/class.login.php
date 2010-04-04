<?php

/**
 * Класс работы с модулем Авторизация
 *
 * @package AVE.cms
 * @subpackage module_Login
 * @filesource
 */
class Login
{

/**
 *	СВОЙСТВА
 */

	/**
	 * Время защитной паузы при авторизации в секундах
	 *
	 * @var int
	 */
	var $_sleep = 1;

	/**
	 * Идентификатор записи с настройками модуля Авторизации
	 *
	 * @var int
	 */
	var $_config_id = 1;

	/**
	 * Ссылка на страницу после регистрации без проверок
	 *
	 * @var string
	 */
	var $_reg_now = 'index.php?module=login&action=profile';

	/**
	 * Ссылка на страницу после регистрации с проверкой Email
	 *
	 * @var string
	 */
	var $_reg_email = 'index.php?module=login&action=register&sub=registerfinal';

	/**
	 * Ссылка на страницу после регистрации с проверкой администратором
	 *
	 * @var string
	 */
	var $_reg_admin = 'index.php?module=login&action=register&sub=thankadmin';

/**
 *	ВНЕШНИЕ МЕТОДЫ
 */

	/**
	 * Форма авторизации
	 *
	 * @param string $tpl_dir путь к каталогу с шаблонами
	 * @param string $lang_file путь к языковому файлу
	 */
	function displayLoginform($tpl_dir, $lang_file)
	{
		global $AVE_Template;

		$AVE_Template->config_load($lang_file, 'displayloginform');

		if ($this->_getSettings('IstAktiv') == 1) $AVE_Template->assign('active', 1);

		$AVE_Template->display($tpl_dir . 'loginform.tpl');
	}

	/**
	 * Панель пользователя
	 *
	 * @param string $tpl_dir путь к каталогу с шаблонами
	 * @param string $lang_file путь к языковому файлу
	 */
	function displayPanel($tpl_dir, $lang_file)
	{
		global $AVE_Template;

		$AVE_Template->config_load($lang_file, 'displaypanel');
		$AVE_Template->display($tpl_dir . 'userpanel.tpl');
	}

	/**
	 * Авторизация пользователя
	 *
	 * @param string $tpl_dir путь к каталогу с шаблонами
	 * @param string $lang_file путь к языковому файлу
	 * @param int $logout признак выхода из системы (1 - выход)
	 */
	function loginProcess($tpl_dir, $lang_file, $logout = 0)
	{
		global $config, $AVE_DB, $AVE_Template, $_SESSION;

		if (isset($_REQUEST['module'])
			&& $_REQUEST['module'] == 'login'
			&& $_REQUEST['action'] == 'logout')
		{
			// уничтожаем куки
			@setcookie('auth[id]', '');
			@setcookie('auth[hash]', '');

			// уничтожаем сессию
			@session_destroy();
			session_unset();
			$_SESSION = array();

			header('Location:' . $_SERVER['HTTP_REFERER']);
			exit;
		}

		if (!empty($_POST['user_login'])
			&& !empty($_POST['user_pass'])
			&& $logout === 0)
		{
			sleep($this->_sleep);

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
					salt
				FROM " . PREFIX . "_users AS usr
				JOIN " . PREFIX . "_user_groups USING (Benutzergruppe)
				WHERE `Status` = 1
				AND (Email = '" . $_POST['user_login'] . "' OR `UserName` = '" . $_POST['user_login'] . "')
				LIMIT 1
			")->FetchRow();

			if (is_object($row) === true && md5(md5(trim($_POST['user_pass']) . $row->salt)) == $row->Kennwort)
			{
				$AVE_DB->Query("
					UPDATE " . PREFIX . "_users
					SET ZuletztGesehen = " . time() . "
					WHERE Id = " . $row->Id . "
				");

				$row->Rechte = str_replace(array(' ', "\n", "\r\n"), '', $row->Rechte);
				$permissions = explode('|', $row->Rechte);
				foreach($permissions as $permission) $_SESSION[$permission] = 1;

				$password = md5(md5(trim($_POST['user_pass']) . $row->salt));

				$_SESSION['user_id'] = $row->Id;
				$_SESSION['user_group'] = $row->Benutzergruppe;
				$_SESSION['user_name'] = htmlspecialchars(empty($row->UserName) ? $row->Vorname . ' ' . $row->Nachname : $row->UserName);
				$_SESSION['user_pass'] = $password;
				$_SESSION['user_email'] = $row->Email;
				$_SESSION['user_country'] = strtoupper($row->Land);

				if (checkPermission('adminpanel'))
				{
					$_SESSION['admin_theme'] = DEFAULT_ADMIN_THEME_FOLDER;
					$_SESSION['admin_lang'] = DEFAULT_LANGUAGE;
				}

				if (isset($_POST['SaveLogin']) && $_POST['SaveLogin'] == 1)
				{
					$expire = time() + $config['cookie_lifetime'];
					@setcookie('auth[id]', $row->Id, $expire);
					@setcookie('auth[hash]', $password, $expire);
				}

				header('Location:' . $_SERVER['HTTP_REFERER']);
				exit;
			}
			else
			{
				unset($_SESSION['user_id']);
				unset($_SESSION['user_pass']);

				$AVE_Template->assign('login', 'false');
			}
		}
		else
		{
			$AVE_Template->assign('login', 'false');
		}

		if ($this->_getSettings('IstAktiv') == 1) $AVE_Template->assign('active', 1);
//		$AVE_Template->assign('inc_path', BASE_DIR . '/modules/login/templates');

		$AVE_Template->config_load($lang_file, 'loginprocess');

		$tpl_out = $AVE_Template->fetch($tpl_dir . 'process.tpl');
		if (!defined('MODULE_CONTENT')) define('MODULE_CONTENT', $tpl_out);
	}

	/**
	 * Регистрация новой учетной записи пользователя
	 *
	 * @param string $tpl_dir путь к каталогу с шаблонами
	 * @param string $lang_file путь к языковому файлу
	 */
	function registerNew($tpl_dir, $lang_file)
	{
		global $AVE_DB, $AVE_Template, $AVE_Globals;

		if (isset($_SESSION['user_id']) || isset($_SESSION['user_pass']))
		{
			header('Location:index.php');
			exit;
		}

		$AVE_Template->config_load($lang_file, 'registernew');
		$config_vars = $AVE_Template->get_config_vars();

		define('MODULE_SITE', $config_vars['LOGIN_TEXT_REGISTER']);

		if ($this->_getSettings('AntiSpam')) define('ANTI_SPAM', 1);

		switch($this->_getSettings('IstAktiv'))
		{
			case '1':
				switch ($_REQUEST['sub'])
				{
					case 'register':
						$error = '';

						$UserName = !empty($_POST['UserName'])
							? $_POST['UserName']
							: '';
						$pass = !empty($_POST['reg_pass'])
							? trim($_POST['reg_pass'])
							: '';
						$_POST['reg_email'] = !empty($_POST['reg_email'])
							? chop(str_replace(' ', '', $_POST['reg_email']))
							: '';
						$_POST['reg_email_return'] = !empty($_POST['reg_email_return'])
							? chop(str_replace(' ', '', $_POST['reg_email_return']))
							: '';

						if ( (!empty($UserName)
							&& ereg("[^ ._A-Za-zА-Яа-яЁё0-9-]", $UserName) )
							|| empty($UserName) )
						{
							$error[] = $config_vars['LOGIN_WRONG_LOGIN'];
						}
						if ($this->_checkUserNameExists($UserName))
						{
							$error[] = $config_vars['LOGIN_WRONG_L_INUSE'];
						}

						if ($this->_isRequired('ZeigeVorname')
							&& empty($_POST['reg_firstname']))
						{
								$error[] = $config_vars['LOGIN_WRONG_FIRSTNAME'];
						}
						if (!empty($_POST['reg_firstname'])
							&& ereg("[^ _A-Za-zА-Яа-яЁё0-9-]", $_POST['reg_firstname']))
						{
								$error[] = $config_vars['LOGIN_WRONG_FIRSTNAME'];
						}

						if ($this->_isRequired('ZeigeNachname')
							&& empty($_POST['reg_lastname']))
						{
								$error[] = $config_vars['LOGIN_WRONG_LASTNAME'];
						}
						if (!empty($_POST['reg_lastname'])
							&& ereg("[^ _A-Za-zА-Яа-яЁё0-9-]", $_POST['reg_lastname']))
						{
								$error[] = $config_vars['LOGIN_WRONG_LASTNAME'];
						}

						if (empty($_POST['reg_email'])) $error[] = $config_vars['LOGIN_WRONG_EM_EMPTY'];
						if (empty($_POST['reg_email_return'])) $error[] = $config_vars['LOGIN_WRONG_ER_EMPTY'];
						if (!empty($_POST['reg_email_return']) &&
							!empty($_POST['reg_email']) &&
							$_POST['reg_email'] != $_POST['reg_email_return'])
						{
							$error[] = $config_vars['LOGIN_WRONG_RETRY'];
						}
						if (! (!empty($_POST['reg_email']) &&
							!ereg("^[\w-]+(\.[\w-]+)*@([a-zA-Z0-9-]+\.)+([a-zA-Z]{2,4})$", $_POST['reg_email'])) )
						{
								$error[] = $config_vars['LOGIN_WRONG_EMAIL'];
						}

						if (empty($pass)) $error[] = $config_vars['LOGIN_WRONG_PASS'];
						if (@ereg("[^_A-Za-zА-Яа-яЁё0-9-]", $pass)) $error[] = $config_vars['LOGIN_WRONG_SYM_PASS'];
						if (!empty($pass) && strlen($pass) < 5) $error[] = $config_vars['LOGIN_WRONG_SHORT_PASS'];

						if (!is_array($error))
						{
							if (!$this->_checkEmailExist($_POST['reg_email'])) $error[] = $config_vars['LOGIN_WRONG_INUSE'];
							if (!$this->_checkEmailDomainInBlacklist($_POST['reg_email'])) $error[] = $config_vars['LOGIN_DOMAIN_FALSE'];
							if (!$this->_checkEmailInBlacklist($_POST['reg_email'])) $error[] = $config_vars['LOGIN_EMAIL_FALSE'];
						}

						if (defined("ANTI_SPAM"))
						{
							if (empty($_POST['reg_secure']))
							{
								$error[] = $config_vars['LOGIN_WROND_E_SCODE'];
							}
							else
							{
								if (! (isset($_SESSION['captcha_keystring']) &&
									$_POST['reg_secure'] == $_SESSION['captcha_keystring']))
								{
									$error[] = $config_vars['LOGIN_WROND_SCODE'];
								}
							}
							unset($_SESSION['captcha_keystring']);
						}

						if (is_array($error) && count($error) > 0)
						{
							$AVE_Template->assign('errors', $error);

							if (defined('ANTI_SPAM')) $AVE_Template->assign('im', 1);

							if ($this->_isRequired('ZeigeFirma')) $AVE_Template->assign('FirmName', 1);
							if ($this->_isRequired('ZeigeVorname')) $AVE_Template->assign('FirstName', 1);
							if ($this->_isRequired('ZeigeNachname')) $AVE_Template->assign('LastName', 1);

							$AVE_Globals = new AVE_Globals;
							$AVE_Template->assign('available_countries', $AVE_Globals->fetchCountries());

							define('MODULE_CONTENT', $AVE_Template->fetch($tpl_dir . 'register.tpl'));
						}
						else
						{
							$status = 0;
							$emailcode = md5(rand(100000,999999));
							switch ($this->_getSettings('RegTyp'))
							{
								case 'now':
									$email_body = str_replace("%N%", "\n", $config_vars['LOGIN_MESSAGE_1']);
									$email_body = str_replace("%NAME%", $UserName, $email_body);
									$email_body = str_replace("%HOST%", homeLink(), $email_body);
									$email_body = str_replace("%KENNWORT%", $pass, $email_body);
									$email_body = str_replace("%EMAIL%", $_POST['reg_email'], $email_body);
									$status = 1;
									$link = $this->_reg_now;
									break;

								case 'email':
									$email_body = str_replace("%N%", "\n", $config_vars['LOGIN_MESSAGE_2'] . $config_vars['LOGIN_MESSAGE_3']);
									$email_body = str_replace("%NAME%", $UserName, $email_body);
									$email_body = str_replace("%KENNWORT%", $pass, $email_body);
									$email_body = str_replace("%EMAIL%", $_POST['reg_email'], $email_body);
									$email_body = str_replace("%REGLINK%", homeLink() . "index.php?module=login&action=register&sub=registerfinal&emc=" . $emailcode, $email_body);
									$email_body = str_replace("%HOST%", homeLink(), $email_body);
									$email_body = str_replace("%CODE%", $emailcode, $email_body);
									$link = $this->_reg_email;
									break;

								case 'byadmin':
									$email_body = str_replace("%N%", "\n", $config_vars['LOGIN_MESSAGE_2'] . $config_vars['LOGIN_MESSAGE_4']);
									$email_body = str_replace("%NAME%", $UserName, $email_body);
									$email_body = str_replace("%KENNWORT%", $pass, $email_body);
									$email_body = str_replace("%EMAIL%", $_POST['reg_email'], $email_body);
									$email_body = str_replace("%HOST%", homeLink(), $email_body);
									$link = $this->_reg_admin;
									break;
							}

							$bodytoadmin = str_replace("%N%", "\n", $config_vars['LOGIN_MESSAGE_5']);
							$bodytoadmin = str_replace("%NAME%", $UserName, $bodytoadmin);
							$bodytoadmin = str_replace("%EMAIL%", $_POST['reg_email'], $bodytoadmin);

							$salt = $this->_makeSalt();
							$md5_pass_salt = md5(md5($pass . $salt));

							$AVE_DB->Query("
								INSERT
								INTO " . PREFIX . "_users
								SET
									Id             = '',
									`UserName`     = '" . $UserName . "',
									Kennwort       = '" . $md5_pass_salt . "',
									Vorname        = '" . $_POST['reg_firstname'] . "',
									Nachname       = '" . $_POST['reg_lastname'] . "',
									Benutzergruppe = '4',
									Registriert    = '" . time() . "',
									Status         = '" . $status . "',
									Email          = '" . $_POST['reg_email'] . "',
									emc            = '" . $emailcode . "',
									Land           = '" . strtoupper($_POST['Land']) . "',
									IpReg          = '" . $_SERVER['REMOTE_ADDR'] . "',
									UStPflichtig   = '1',
									Firma          = '" . @$_POST['Firma'] . "',
									salt           = '" . $salt . "'
							");

							if ($status == 1)
							{
								$_SESSION['user_id'] = $AVE_DB->InsertId();
						        $_SESSION['user_name'] = htmlspecialchars(empty($row->UserName)
									? $_POST['reg_firstname'] . ' ' . $_POST['reg_lastname']
									: $UserName);
								$_SESSION['user_email'] = $_POST['reg_email'];
								$_SESSION['user_pass'] = $md5_pass_salt;
								$_SESSION['user_group'] = 4;
								$_SESSION['user_country'] = strtoupper($_POST['Land']);
							}

							$AVE_Globals = new AVE_Globals;
							$SystemMail = $AVE_Globals->mainSettings('mail_from');
							$SystemMailName = $AVE_Globals->mainSettings('mail_from_name');
							$AVE_Globals->cp_mail(
								$SystemMail,
								$bodytoadmin,
								$config_vars['LOGIN_SUBJECT_ADMIN'],
								$SystemMail,
								$SystemMailName,
								'text',
								''
							);
							$AVE_Globals->cp_mail(
								$_POST['reg_email'],
								$email_body,
								$config_vars['LOGIN_SUBJECT_USER'],
								$SystemMail,
								$SystemMailName,
								'text',
								''
							);
							header('Location:' . $link);
							exit;
						}
						break;

					case 'thankyou':
						$AVE_Template->config_load($lang_file);

						define('MODULE_CONTENT', $AVE_Template->fetch($tpl_dir . 'register_thankyou.tpl'));
						break;

					case 'registerfinal':
						if (isset($_REQUEST['emc']) && $_REQUEST['emc'] != '0')
						{
							$sql = $AVE_DB->Query("
								SELECT *
								FROM " . PREFIX . "_users
								WHERE emc = '" . $_REQUEST['emc'] . "'
							");
							$num = $sql->NumRows();
							$row = $sql->FetchRow();
							if ($num == 1)
							{
								$AVE_Template->assign('reg_type', '$reg_type');
								$AVE_Template->assign('final', 'ok');
								$AVE_DB->Query("
									UPDATE " . PREFIX . "_users
									SET Status = 1
									WHERE emc = '" . $_REQUEST['emc'] . "'
								");
								$_SESSION['user_id'] = $row->Id;
								$_SESSION['user_pass'] = $row->Kennwort;
								$_SESSION['user_email'] = $row->Email;
								$_SESSION['user_name'] = htmlspecialchars($row->UserName);
							}
						}

						define('MODULE_CONTENT', $AVE_Template->fetch($tpl_dir . 'register_final.tpl'));
						break;

					case 'thankadmin':
						$AVE_Template->config_load($lang_file);

						define('MODULE_CONTENT', $AVE_Template->fetch($tpl_dir . 'register_admin.tpl'));
						break;

					case '':
					default :
						if (defined('ANTI_SPAM')) $AVE_Template->assign('im', 1);

						if ($this->_isRequired('ZeigeFirma')) $AVE_Template->assign('FirmName', 1);
						if ($this->_isRequired('ZeigeVorname')) $AVE_Template->assign('FirstName', 1);
						if ($this->_isRequired('ZeigeNachname')) $AVE_Template->assign('LastName', 1);

						$AVE_Globals = new AVE_Globals;
						$AVE_Template->assign('available_countries', $AVE_Globals->fetchCountries());

						define('MODULE_CONTENT', $AVE_Template->fetch($tpl_dir . 'register.tpl'));
						break;
				}
				break;

			case '0':
				define('MODULE_CONTENT', $config_vars['LOGIN_NOT_ACTIVE']);
				break;
		}
	}

	/**
	 * Восстановление пароля
	 *
	 * @param string $tpl_dir путь к каталогу с шаблонами
	 * @param string $lang_file путь к языковому файлу
	 */
	function passwordReminder($tpl_dir, $lang_file)
	{
		global $AVE_DB, $AVE_Template, $AVE_Globals;

		if (isset($_SESSION['user_id']))
		{
			header('Location:index.php');
			exit;
		}

		$AVE_Template->config_load($lang_file, 'passwordreminder');
		$config_vars = $AVE_Template->get_config_vars();
		define('MODULE_SITE', $config_vars['LOGIN_REMIND']);

		if (isset($_REQUEST['sub'])
			&& $_REQUEST['sub'] == 'confirm'
			&& !empty($_REQUEST['email']))
		{
			$sql_rem = $AVE_DB->Query("
				SELECT
					new_pass,
					new_salt
				FROM " . PREFIX . "_users
				WHERE Email = '" . $_REQUEST['email'] . "'
				AND new_pass != ''
				AND new_pass = '" . $_REQUEST['code'] . "'
				LIMIT 1
			");
			$num_rem = $sql_rem->NumRows();
			$row_rem = $sql_rem->FetchRow();
			if ($num_rem == 1)
			{
				$AVE_DB->Query("
					UPDATE " . PREFIX . "_users
					SET
						Kennwort = '" . $row_rem->new_pass . "',
						salt = '" . $row_rem->new_salt . "'
					WHERE Email  = '" . $_REQUEST['email'] . "'
					AND new_pass = '" . $_REQUEST['code'] . "'
				");
			}

			$tpl_out = $AVE_Template->fetch($tpl_dir . 'password_ok.tpl');
			define('MODULE_CONTENT', $tpl_out);
		}
		else
		{
			if (isset($_REQUEST['sub']) && $_REQUEST['sub'] == 'send' && !empty($_POST['f_mailreminder']))
			{
				$sql_rem = $AVE_DB->Query("
					SELECT
						Email,
						Vorname,
						Nachname
					FROM " . PREFIX . "_users
					WHERE Email = '" . $_POST['f_mailreminder'] . "'
					LIMIT 1
				");
				$row_rem = $sql_rem->FetchRow();
				$num_rem = $sql_rem->NumRows();
				$sql_rem->Close();

				if ($num_rem == 1)
				{
					$AVE_Globals = new AVE_Globals;
					$SystemMail = $AVE_Globals->mainSettings('mail_from');
					$SystemMailName = $AVE_Globals->mainSettings('mail_from_name');

					$newpass = $this->_makePass();
					$newsalt = $this->_makeSalt();
					$md5_pass_salt = md5(md5($newpass . $newsalt));

					$AVE_DB->Query("
						UPDATE " . PREFIX . "_users
						SET
							new_pass = '" . $md5_pass_salt . "',
							new_salt = '" . $newsalt . "'
						WHERE Email = '" . addslashes($_POST['f_mailreminder']) . "'
						LIMIT 1
					");

					$body = $config_vars['LOGIN_MESSAGE_6'];
					$body = str_replace("%NAME%", $row_rem->UserName, $body);
					$body = str_replace("%PASS%", $newpass, $body);
					$body = str_replace("%HOST%", homeLink(), $body);
					$body = str_replace("%LINK%", homeLink() . "index.php?module=login&action=passwordreminder&sub=confirm&code=" . $md5_pass_salt . "&email=" . $_POST['f_mailreminder'], $body);
					$body = str_replace("%N%", "\n", $body);
					$AVE_Globals->cp_mail(
						$_POST['f_mailreminder'],
						$body,
						$config_vars['LOGIN_SUBJECT_REMINDER'],
						$SystemMail,
						$SystemMailName,
						'text',
						''
					);
				}
			}
			$tpl_out = $AVE_Template->fetch($tpl_dir . 'password_lost.tpl');
			define('MODULE_CONTENT', $tpl_out);
		}
	}

	/**
	 * Изменение пароля
	 *
	 * @param string $tpl_dir путь к каталогу с шаблонами
	 * @param string $lang_file путь к языковому файлу
	 */
	function passwordChange($tpl_dir, $lang_file)
	{
		global $AVE_DB, $AVE_Template;

		$AVE_Template->config_load($lang_file, 'passwordchange');
		$config_vars = $AVE_Template->get_config_vars();

		define('MODULE_SITE', $config_vars['LOGIN_PASSWORD_CHANGE']);

		if (!isset($_SESSION['user_id']))
		{
			header('Location:index.php');
			exit;
		}

		$salt = $AVE_DB->Query("
			SELECT salt
			FROM " . PREFIX . "_users
			WHERE Id = '" . $_SESSION['user_id'] . "'
			LIMIT 1
		")->GetCell();

		if ($salt !== false && isset($_REQUEST['sub']) && $_REQUEST['sub'] == 'send')
		{
			$error = '';

			if (trim($_POST['old_pass']) == '')
			{
				$error[] = $config_vars['LOGIN_EMPTY_OLD_PASS'];
			}
			elseif (trim($_POST['new_pass']) == '')
			{
				$error[] = $config_vars['LOGIN_EMPTY_NEW_PASS'];
			}
			elseif (trim($_POST['new_pass_c']) == '')
			{
				$error[] = $config_vars['LOGIN_EMPTY_NEW_PASS_C'];
			}
			elseif ($_SESSION['user_pass'] != md5(md5(trim($_POST['old_pass']) . $salt)))
			{
				$error[] = $config_vars['LOGIN_WRONG_OLD_PASS'];
			}
			elseif (trim($_POST['new_pass']) != trim($_POST['new_pass_c']))
			{
				$error[] = $config_vars['LOGIN_WRONG_EQU_PASS'];
			}
			else
			{
				$pass = trim($_POST['new_pass']);
				if (preg_match("/[^_A-Za-zА-Яа-яЁё0-9-]/", $pass)) $error[] = $config_vars['LOGIN_WRONG_SYM_PASS'];
				if (!empty($pass) && strlen($pass) < 5) $error[] = $config_vars['LOGIN_WRONG_SHORT_PASS'];
			}

			if (is_array($error) && count($error) > 0)
			{
				$AVE_Template->assign('errors', $error);
			}
			else
			{
				$newsalt = $this->_makeSalt();
				$md5_pass_salt = md5(md5($pass . $newsalt));

				$AVE_DB->Query("
					UPDATE " . PREFIX . "_users
					SET
						Kennwort = '" . $md5_pass_salt . "',
						salt = '" . $newsalt . "'
					WHERE Email  = '" . $_SESSION['user_email'] . "'
					AND Kennwort = '" . $_SESSION['user_pass'] . "'
				");
				$_SESSION['user_pass'] = $md5_pass_salt;
				$AVE_Template->assign('changeok', 1);
			}
		}
		$tpl_out = $AVE_Template->fetch($tpl_dir . 'password_change.tpl');
		define('MODULE_CONTENT', $tpl_out);
	}

	/**
	 * Удаление учетной записи пользователя
	 *
	 * @param string $tpl_dir путь к каталогу с шаблонами
	 * @param string $lang_file путь к языковому файлу
	 */
	function delAccount($tpl_dir, $lang_file)
	{
		global $AVE_Template, $AVE_Globals;

		$AVE_Template->config_load($lang_file, 'delaccount');

		define('MODULE_SITE', $AVE_Template->get_config_vars('LOGIN_DELETE_ACCOUNT'));

		if (!isset($_SESSION['user_id']) || !isset($_SESSION['user_pass']))
		{
			header('Location:index.php');
			exit;
		}

		if (isset($_REQUEST['delconfirm']) && $_REQUEST['delconfirm'] == 1 && UGROUP != 1)
		{
			$AVE_Globals = new AVE_Globals;
			$AVE_Globals->delUser($_SESSION['user_id']);
			unset($_SESSION['user_id']);
			unset($_SESSION['user_pass']);
			$AVE_Template->assign('delok', 1);
		}

		if (defined('UGROUP') && UGROUP == 1)
		{
			$AVE_Template->assign('admin', 1);
		}

		$tpl_out = $AVE_Template->fetch($tpl_dir . 'delete_account.tpl');
		define('MODULE_CONTENT', $tpl_out);
	}

	/**
	 * Управление учетной записью пользователя
	 *
	 * @param string $tpl_dir путь к каталогу с шаблонами
	 * @param string $lang_file путь к языковому файлу
	 */
	function myProfile($tpl_dir, $lang_file)
	{
		global $AVE_DB, $AVE_Template, $AVE_Globals;

		if (!isset($_SESSION['user_id']) || !isset($_SESSION['user_pass']))
		{
			header('Location:index.php');
			exit;
		}

		$AVE_Template->config_load($lang_file, 'myprofile');
		$config_vars = $AVE_Template->get_config_vars();
		define('MODULE_SITE', $config_vars['LOGIN_CHANGE_DETAILS']);

		if (isset($_REQUEST['sub']) && $_REQUEST['sub'] == 'update')
		{
			$errors = '';
//			$muster = "[^ +_A-Za-zА-Яа-яЁё0-9-]";
			$muster = '/[^\x20-\xFF]|[><]/';
			$muster_geb = "([0-9]{2}).([0-9]{2}).([0-9]{4})";
			$muster_email = "^[-._A-Za-z0-9-]+(\.[_A-Za-z0-9-]+)*@([a-zA-Z0-9-]+\.)+([a-zA-Z]{2,4})$";

			if ($this->_isRequired('ZeigeVorname'))
			{
				if (empty($_POST['Vorname'])) $errors[] = $config_vars['LOGIN_WRONG_FIRSTNAME'];
			}
			if (preg_match($muster, $_POST['Vorname'])) $errors[] = $config_vars['LOGIN_WRONG_FIRSTNAME'];

			if ($this->_isRequired('ZeigeNachname'))
			{
				if (empty($_POST['Nachname'])) $errors[] = $config_vars['LOGIN_WRONG_LASTNAME'];
			}
			if (preg_match($muster, $_POST['Nachname'])) $errors[] = $config_vars['LOGIN_WRONG_LASTNAME'];

			if (!empty($_POST['Strasse']) && preg_match($muster, $_POST['Strasse'])) $errors[] = $config_vars['LOGIN_WRONG_STREET'];
			if (!empty($_POST['HausNr']) && preg_match($muster, $_POST['HausNr'])) $errors[] = $config_vars['LOGIN_WRONG_HOUSE'];
			if (!empty($_POST['Postleitzahl']) && preg_match($muster, $_POST['Postleitzahl'])) $errors[] = $config_vars['LOGIN_WRONG_ZIP'];
			if (!empty($_POST['city']) && preg_match($muster, $_POST['city'])) $errors[] = $config_vars['LOGIN_WRONG_TOWN'];
			if (!empty($_POST['Telefon']) && preg_match($muster, $_POST['Telefon'])) $errors[] = $config_vars['LOGIN_WRONG_PHONE'];
			if (!empty($_POST['Telefax']) && preg_match($muster, $_POST['Telefax'])) $errors[] = $config_vars['LOGIN_WRONG_FAX'];

			if (!ereg($muster_email, $_POST['Email']))
			{
				$errors[] = $config_vars['LOGIN_WRONG_EMAIL'];
			}
			else
			{
				$num = $AVE_DB->Query("
					SELECT Id
					FROM " . PREFIX . "_users
					WHERE Id != '" . $_SESSION['user_id'] . "'
					AND Email = '" . $_POST['Email'] . "'
				")->NumRows();

				if ($num > 0) $errors[] = $config_vars['LOGIN_WRONG_INUSE'];
			}

			if (!empty($_POST['GebTag']) && !ereg($muster_geb, $_POST['GebTag'])) $errors[] = $config_vars['LOGIN_WRONG_BIRTHDAY'];

			if (!empty($_POST['GebTag']))
			{
				$check_year = explode('.', $_POST['GebTag']);
				if (empty($check_year[0]) || $check_year[0] > 31) $errors[] = $config_vars['LOGIN_WRONG_DATE'];
				if (empty($check_year[1]) || $check_year[1] > 12) $errors[] = $config_vars['LOGIN_WRONG_MONTH'];
				if (empty($check_year[2]) || $check_year[2] < date("Y")-75) $errors[] = $config_vars['LOGIN_WRONG_YEAR'];
			}

			if (is_array($errors) && count($errors) > 0)
			{
				$AVE_Template->assign('errors', $errors);
			}
			else
			{
				$AVE_DB->Query("
					UPDATE " . PREFIX . "_users
					SET
						Email        = '" . $_POST['Email'] . "',
						Strasse      = '" . $_POST['Strasse'] . "',
						HausNr       = '" . $_POST['HausNr'] . "',
						Postleitzahl = '" . $_POST['Postleitzahl'] . "',
						city         = '" . $_POST['city'] . "',
						Telefon      = '" . $_POST['Telefon'] . "',
						Telefax      = '" . $_POST['Telefax'] . "',
						Vorname      = '" . $_POST['Vorname'] . "',
						Nachname     = '" . $_POST['Nachname'] . "',
						Land         = '" . $_POST['Land'] . "',
						GebTag       = '" . $_POST['GebTag'] . "',
						Firma        = '" . $_POST['Firma'] . "'
					WHERE
						Id           = '" . $_SESSION['user_id'] . "'
					AND
						Kennwort     = '" . $_SESSION['user_pass'] . "'
				");
				$AVE_Template->assign('changed', 1);
			}
		}

		$sql = $AVE_DB->Query("
			SELECT *
			FROM " . PREFIX . "_users
			WHERE Id = '" . $_SESSION['user_id'] . "'
			LIMIT 1
		");
		$row = $sql->FetchAssocArray();
		$sql->Close();

		$AVE_Globals = new AVE_Globals;
		$AVE_Template->assign('available_countries', $AVE_Globals->fetchCountries());
		$AVE_Template->assign('row', $row);

		if ($this->_isRequired('ZeigeFirma')) $AVE_Template->assign('FirmName', 1);
		if ($this->_isRequired('ZeigeVorname')) $AVE_Template->assign('FirstName', 1);
		if ($this->_isRequired('ZeigeNachname')) $AVE_Template->assign('LastName', 1);

		$tpl_out = $AVE_Template->fetch($tpl_dir . 'myprofile.tpl');
		define('MODULE_CONTENT', $tpl_out);
	}

	/**
	 * Управление модулем Авторизации
	 *
	 * @param string $tpl_dir путь к каталогу с шаблонами
	 * @param string $lang_file путь к языковому файлу
	 */
	function showConfig($tpl_dir, $lang_file)
	{
		global $AVE_DB, $AVE_Template;

		if (isset($_REQUEST['sub']) && $_REQUEST['sub'] == 'save')
		{
			$DomainsVerboten = str_replace(array("\r\n", "\n"), ',', chop($_REQUEST['DomainsVerboten']));
			$EmailsVerboten = str_replace(array("\r\n", "\n"), ',', chop($_REQUEST['EmailsVerboten']));

			$AVE_DB->Query("
				UPDATE " . PREFIX . "_modul_login
				SET
					RegTyp          = '" . $_REQUEST['RegTyp'] . "',
					AntiSpam        = '" . $_REQUEST['AntiSpam'] . "',
					IstAktiv        = '" . $_REQUEST['IstAktiv'] . "',
					DomainsVerboten = '" . $DomainsVerboten . "',
					EmailsVerboten  = '" . $EmailsVerboten . "',
					ZeigeFirma      = '" . $_REQUEST['ZeigeFirma'] . "',
					ZeigeVorname    = '" . $_REQUEST['ZeigeVorname'] . "',
					ZeigeNachname   = '" . $_REQUEST['ZeigeNachname'] . "'
				WHERE
					Id              = '" . $this->_config_id . "'
			");
			header('Location:index.php?do=modules&action=modedit&mod=login&moduleaction=1&cp=' . SESSION);
			exit;
		}

		$row = $this->_getSettings();
		$row['DomainsVerboten'] = str_replace(',', "\n", chop($row['DomainsVerboten']));
		$row['EmailsVerboten']  = str_replace(',', "\n", chop($row['EmailsVerboten']));
		$AVE_Template->assign($row);

		$AVE_Template->config_load($lang_file, 'showconfig');

		$AVE_Template->assign('content', $AVE_Template->fetch($tpl_dir . 'admin_config.tpl'));
	}

/**
 *	ВНУТРЕННИЕ МЕТОДЫ
 */

	/**
	 * Получение параметра настройки модуля Авторизация
	 *
	 * @param string $field название параметра
	 * @return mixed значение настройки
	 */
	function _getSettings($field = '')
	{
		global $AVE_DB;
		static $settings = null;

		if (empty($settings))
		{
			$settings = $AVE_DB->Query("
				SELECT *
				FROM " . PREFIX . "_modul_login
				WHERE Id = '" . $this->_config_id . "'
			")->FetchAssocArray();
		}

		if ($field == '') return $settings;
		return $settings[$field];
	}

	/**
	 * Получение параметра "Обязательное поле" для формы авторизации
	 *
	 * @param string $field название поля БД в котором хранится параметр
	 * @return boolean
	 */
	function _isRequired($field)
	{
		if ($this->_getSettings($field) == 1) return true;
		return false;
	}

	/**
	 * Проверка наличия учетной записи с указанным email
	 *
	 * @param string $email проверяемый email
	 * @return boolean
	 */
	function _checkEmailExist($email)
	{
		global $AVE_DB;

		$num = $AVE_DB->Query("
			SELECT COUNT(*)
			FROM " . PREFIX . "_users
			WHERE Email = '" . $email . "'
		")
		->GetCell();

		if ($num > 0) return false;
		return true;
	}

	/**
	 * Проверка наличия учетной записи с проверяемым именем пользователя
	 *
	 * @param string $UserName проверяемое имя пользователя
	 * @return boolean
	 */
	function _checkUserNameExists($UserName)
	{
		global $AVE_DB;

		$num = $AVE_DB->Query("
			SELECT COUNT(*)
			FROM " . PREFIX . "_users
			WHERE `UserName` = '" . $UserName . "'
		")
		->GetCell();

		if ($num > 0) return true;
		return false;
	}

	/**
	 * Проверка наличия в черном списке email
	 *
	 * @param unknown_type $email
	 * @return unknown
	 */
	function _checkEmailInBlacklist($email)
	{
		$Verboten = explode(',', chop($this->_getSettings('EmailsVerboten')));

		if (in_array($email, $Verboten)) return false;
		return true;
	}

	/**
	 * Проверка наличия в черном списке доменного имени
	 *
	 * @param string $email email доменное имя которого надо проверить
	 * @return boolean
	 */
	function _checkEmailDomainInBlacklist($email = '')
	{
		if (empty($email)) return false;

		$DomainsVerboten = explode(',', chop($this->_getSettings('DomainsVerboten')));
		$DomainGesendet = explode('@', $email);

		if (in_array(@$DomainGesendet[1], $DomainsVerboten)) return false;
		return true;
	}

	/**
	 * Формирование защитного кода для борьбы со спамом
	 *
	 * @param int $c количество символов в защитном коде
	 * @return int идентификатор защитного кода
	 */
	function _secureCode($c = 0)
	{
		global $AVE_DB;

		$tdel = time() - 1200;
		$AVE_DB->Query("
			DELETE
			FROM " . PREFIX . "_antispam
			WHERE Ctime < " . $tdel
		);
		$code = '';
		$chars = array(
			'A','B','C','D','E','F','G','H','J','K','M','N',
			'P','Q','R','S','T','U','V','W','X','Y','Z',
			'a','b','c','d','e','f','g','h','j','k','m','n',
			'p','q','r','s','t','u','v','w','x','y','z',
			'2','3','4','5','6','7','8','9'
		);
		$ch = ($c!=0) ? $c : 7;
		$count = count($chars) - 1;
		srand((double)microtime() * 1000000);
		for ($i=0; $i<$ch; $i++)
		{
			$code .= $chars[rand(0, $count)];
		}
		$AVE_DB->Query("
			INSERT
			INTO " . PREFIX . "_antispam
			SET
				Id = '',
				Code = '" . $code . "',
				Ctime = '" . time() . "'
		");

		$_SESSION['reg_secure'] = $code;

		return $AVE_DB->InsertId();
	}

	/**
	 * Формирование пароля
	 *
	 * @param int $length количество символов в пароле
	 * @return string
	 */
	function _makePass($length = 8)
	{
		$chars = "abcdefghijklmnopqrstuvwxyz"
			. "ABCDEFGHIJKLMNOPRQSTUVWXYZ0123456789";
		$code = "";
		$clen = strlen($chars) - 1;
		while (strlen($code) < $length)
		{
			$code .= $chars[mt_rand(0, $clen)];
		}
		return $code;
	}

	/**
	 * Формирование соли
	 *
	 * @param int $length количество символов в соли
	 * @return string
	 */
	function _makeSalt($length = 16)
	{
		$chars = "abcdefghijklmnopqrstuvwxyz"
			. "ABCDEFGHIJKLMNOPRQSTUVWXYZ"
			. "0123456789~!@#$%^&*()-_=+{[;:/?.,]}";
		$code = "";
		$clen = strlen($chars) - 1;
		while (strlen($code) < $length)
		{
				$code .= $chars[mt_rand(0, $clen)];
		}
		return $code;
	}
}

?>