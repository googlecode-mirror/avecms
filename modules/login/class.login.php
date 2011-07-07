<?php

/**
 * Класс работы с модулем Авторизация
 *
 * @package AVE.cms
 * @subpackage module_Login
 * @since 1.4
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
	 * Идентификатор группы пользователей для зарегистрированных пользователей
	 *
	 * @var int
	 */
	var $_newuser_group = 4;

	/**
	 * Путь к директории с шаблонами модуля
	 *
	 * @var string
	 */
	var $_tpl_dir;

	/**
	 * Путь к языковому файлу
	 *
	 * @var string
	 */
	var $_lang_file;

	/**
	 * Регулярное выражение для проверки непечатаемых и нежелательных символов
	 *
	 * @var string
	 */
	var $_regex = '/[^\x20-\xFF]|[><]/';

	/**
	 * Регулярное выражение для проверки даты
	 *
	 * @var string
	 */
	var $_regex_geb = '#(0[1-9]|[12][0-9]|3[01])([[:punct:]| ])(0[1-9]|1[012])\2(19|20)\d\d#';

	/**
	 * Регулярное выражение для проверки e-Mail
	 *
	 * @var string
	 */
	var $_regex_email = '/^[\w.-]+@[a-z0-9.-]+\.(?:[a-z]{2}|com|org|net|edu|gov|mil|biz|info|mobi|name|aero|asia|jobs|museum)$/i';

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
	 * Конструктор
	 *
	 * @param string $tpl_dir путь к директории с шаблонами модуля
	 * @param string $lang_file путь к языковому файлу
	 * @return Login
	 */
	function Login($tpl_dir, $lang_file)
	{
		$this->_tpl_dir   = $tpl_dir;
		$this->_lang_file = $lang_file;
	}

/**
 *	ВНУТРЕННИЕ МЕТОДЫ
 */

	/**
	 * Получение параметра настройки модуля Авторизация
	 *
	 * @param string $field название параметра
	 * @return mixed значение параметра или массив параметров если не указан $field
	 */
	function _loginSettingsGet($field = '')
	{
		global $AVE_DB;

		static $settings = null;

		if ($settings === null)
		{
			$settings = $AVE_DB->Query("
				SELECT *
				FROM " . PREFIX . "_modul_login
				WHERE Id = 1
			")->FetchAssocArray();
		}

		if ($field == '') return $settings;

		return (isset($settings[$field]) ? $settings[$field] : null);
	}

	/**
	 * Получение параметра "Обязательное поле" для формы авторизации
	 *
	 * @param string $field название поля БД в котором хранится параметр
	 * @return boolean
	 */
	function _loginFieldIsRequired($field)
	{
		return (bool)$this->_loginSettingsGet($field);
	}

	/**
	 * Передать в Smarty признаки обязательных полей
	 *
	 */
	function _loginRequiredFieldFetch()
	{
		global $AVE_Template;

		if ($this->_loginFieldIsRequired('login_require_company'))
		{
			$AVE_Template->assign('FirmName',  1);
		}
		if ($this->_loginFieldIsRequired('login_require_firstname'))
		{
			$AVE_Template->assign('FirstName', 1);
		}
		if ($this->_loginFieldIsRequired('login_require_lastname'))
		{
			$AVE_Template->assign('LastName',  1);
		}
	}

	/**
	 * Проверка наличия учетной записи с указанным email
	 *
	 * @param string $email проверяемый email
	 * @return boolean
	 */
	function _loginEmailExistCheck($email)
	{
		global $AVE_DB;

		$exist = $AVE_DB->Query("
			SELECT 1
			FROM " . PREFIX . "_users
			WHERE email = '" . addslashes($email) . "'
		")->NumRows();

		return (bool)$exist;
	}

	/**
	 * Проверка наличия учетной записи с проверяемым именем пользователя
	 *
	 * @param string $user_name проверяемое имя пользователя
	 * @return boolean
	 */
	function _loginUserNameExistsCheck($user_name)
	{
		global $AVE_DB;

		$exist = $AVE_DB->Query("
			SELECT 1
			FROM " . PREFIX . "_users
			WHERE user_name = '" . addslashes($user_name) . "'
			LIMIT 1
		")->NumRows();

		return (bool)$exist;
	}

	/**
	 * Проверка наличия в черном списке email
	 *
	 * @param unknown_type $email
	 * @return unknown
	 */
	function _loginEmailInBlacklistCheck($email)
	{
		if (empty($email)) return false;

		$deny_emails = explode(',', chop($this->_loginSettingsGet('login_deny_email')));

		return !in_array($email, $deny_emails);
	}

	/**
	 * Проверка наличия в черном списке доменного имени
	 *
	 * @param string $email email доменное имя которого надо проверить
	 * @return boolean
	 */
	function _loginEmailDomainInBlacklistCheck($email = '')
	{
		if (empty($email)) return false;

		$deny_domains = explode(',', chop($this->_loginSettingsGet('login_deny_domain')));
		$domain = explode('@', $email);

		return !in_array(@$domain[1], $deny_domains);
	}

/**
 *	ВНЕШНИЕ МЕТОДЫ
 */

	/**
	 * Форма авторизации
	 *
	 */
	function loginLoginformShow()
	{
		global $AVE_Template;

		$AVE_Template->config_load($this->_lang_file, 'displayloginform');

		if ($this->_loginSettingsGet('login_status') == 1) $AVE_Template->assign('active', 1);

		$AVE_Template->display($this->_tpl_dir . 'loginform.tpl');
	}

	/**
	 * Панель пользователя
	 *
	 */
	function loginUserpanelShow()
	{
		global $AVE_Template;

		$AVE_Template->config_load($this->_lang_file, 'displaypanel');

		$AVE_Template->display($this->_tpl_dir . 'userpanel.tpl');
	}

	/**
	 * Выход из системы
	 *
	 */
	function loginUserLogout()
	{
		user_logout();

		$referer_link = get_referer_link();
		if (false === strstr($referer_link, 'module=login'))
		{
			header('Location:' . $referer_link);
		}
		else
		{
			header('Location:' . get_home_link());
		}
		exit;
	}

	/**
	 * Авторизация пользователя
	 *
	 */
	function loginUserLogin()
	{
		global $AVE_Template;

		if (empty($_SESSION['referer']))
		{
			$referer = get_referer_link();
			$_SESSION['referer'] = (false === strstr($referer, 'module=login')) ? $referer : get_home_link();
		}

		if (!empty($_POST['user_login']) && !empty($_POST['user_pass']))
		{
			$result = user_login(
				$_POST['user_login'],
				$_POST['user_pass'],
				1,
				(int)(isset($_POST['SaveLogin']) && $_POST['SaveLogin'] == 1)
			);
			if ($result === true)
			{
				header('Location:' . rewrite_link($_SESSION['referer']));
				unset($_SESSION['referer']);
				exit;
			}
			elseif ($result === 3)
			{
				header('Location:' . ABS_PATH . 'index.php?module=login&action=register&sub=registerfinal');
				exit;
			}
			else
			{
				unset($_SESSION['user_id'], $_SESSION['user_pass']);

				$AVE_Template->assign('login', false);
			}
		}
		else
		{
			$AVE_Template->assign('login', false);
		}

		if ($this->_loginSettingsGet('login_status') == 1) $AVE_Template->assign('active', 1);

		$AVE_Template->config_load($this->_lang_file, 'loginprocess');

		if (!defined('MODULE_CONTENT'))
		{
			define('MODULE_CONTENT', $AVE_Template->fetch($this->_tpl_dir . 'process.tpl'));
		}
	}

	/**
	 * Регистрация новой учетной записи пользователя
	 *
	 */
	function loginNewUserRegister()
	{
		global $AVE_DB, $AVE_Template;

		if (isset($_SESSION['user_id']) || isset($_SESSION['user_pass']))
		{
			header('Location:' . get_referer_link());
			exit;
		}

		if (empty($_SESSION['referer']))
		{
			$referer = get_referer_link();
			$_SESSION['referer'] = (false === strstr($referer, 'module=login')) ? $referer : get_home_link();
		}

		$AVE_Template->config_load($this->_lang_file, 'registernew');

		define('MODULE_SITE', $AVE_Template->get_config_vars('LOGIN_TEXT_REGISTER'));

		if ($this->_loginSettingsGet('login_antispam')) define('ANTISPAM', 1);

		switch($this->_loginSettingsGet('login_status'))
		{
			case '1':
				switch ($_REQUEST['sub'])
				{
					case 'register':
						$error = array();

						$_POST['user_name']         = (!empty($_POST['user_name']))
													  ? trim($_POST['user_name'])
													  : '';

						$_POST['reg_email']        = (!empty($_POST['reg_email']))
													  ? trim($_POST['reg_email'])
													  : '';

						$_POST['reg_email_return'] = (!empty($_POST['reg_email_return']))
													  ? trim($_POST['reg_email_return'])
													  : '';

						// ЛОГИН
						if (empty($_POST['user_name']))
						{
							$error[] = $AVE_Template->get_config_vars('LOGIN_WRONG_L_EMPTY');
						}
						elseif (!ctype_alnum($_POST['user_name']))
						{
							$error[] = $AVE_Template->get_config_vars('LOGIN_WRONG_LOGIN');
						}
						elseif ($this->_loginUserNameExistsCheck($_POST['user_name']))
						{
							$error[] = $AVE_Template->get_config_vars('LOGIN_WRONG_L_INUSE');
						}

						// EMAIL
						if (empty($_POST['reg_email']))
						{
							$error[] = $AVE_Template->get_config_vars('LOGIN_WRONG_EM_EMPTY');
						}
						elseif (!preg_match($this->_regex_email, $_POST['reg_email']))
						{
							$error[] = $AVE_Template->get_config_vars('LOGIN_WRONG_EMAIL');
						}
//						elseif (empty($_POST['reg_email_return']))
//						{
//							$error[] = $AVE_Template->get_config_vars('LOGIN_WRONG_ER_EMPTY');
//						}
//						elseif ($_POST['reg_email'] != $_POST['reg_email_return'])
//						{
//							$error[] = $AVE_Template->get_config_vars('LOGIN_WRONG_RETRY');
//						}
						else
						{
							if ($this->_loginEmailExistCheck($_POST['reg_email']))
							{
								$error[] = $AVE_Template->get_config_vars('LOGIN_WRONG_INUSE');
							}
							if (!$this->_loginEmailDomainInBlacklistCheck($_POST['reg_email']))
							{
								$error[] = $AVE_Template->get_config_vars('LOGIN_DOMAIN_FALSE');
							}
							if (!$this->_loginEmailInBlacklistCheck($_POST['reg_email']))
							{
								$error[] = $AVE_Template->get_config_vars('LOGIN_EMAIL_FALSE');
							}
						}

						// ПАРОЛЬ
						if (empty($_POST['reg_pass']))
						{
							$error[] = $AVE_Template->get_config_vars('LOGIN_WRONG_PASS');
						}
						elseif (strlen($_POST['reg_pass']) < 5)
						{
							$error[] = $AVE_Template->get_config_vars('LOGIN_WRONG_SHORT_PASS');
						}
						elseif (preg_match($this->_regex, $_POST['reg_pass']))
						{
							$error[] = $AVE_Template->get_config_vars('LOGIN_WRONG_SYM_PASS');
						}

						// ИМЯ
						if ($this->_loginFieldIsRequired('login_require_firstname') && empty($_POST['reg_firstname']))
						{
							$error[] = $AVE_Template->get_config_vars('LOGIN_WRONG_FN_EMPTY');
						}
						if (!empty($_POST['reg_firstname']) && preg_match($this->_regex, $_POST['reg_firstname']))
						{
							$error[] = $AVE_Template->get_config_vars('LOGIN_WRONG_FIRSTNAME');
						}

						// ФАМИЛИЯ
						if ($this->_loginFieldIsRequired('login_require_lastname') && empty($_POST['reg_lastname']))
						{
							$error[] = $AVE_Template->get_config_vars('LOGIN_WRONG_LN_EMPTY');
						}
						if (!empty($_POST['reg_lastname']) && preg_match($this->_regex, $_POST['reg_lastname']))
						{
							$error[] = $AVE_Template->get_config_vars('LOGIN_WRONG_LASTNAME');
						}

						// КАПЧА
						if (defined("ANTISPAM"))
						{
							if (empty($_POST['reg_secure']))
							{
								$error[] = $AVE_Template->get_config_vars('LOGIN_WROND_E_SCODE');
							}
							elseif (!(isset($_SESSION['captcha_keystring'])
								&& $_POST['reg_secure'] == $_SESSION['captcha_keystring']))
							{
								$error[] = $AVE_Template->get_config_vars('LOGIN_WROND_SCODE');
							}
							unset($_SESSION['captcha_keystring']);
						}

						if (count($error))
						{
							$AVE_Template->assign('errors', $error);

							if (defined('ANTISPAM')) $AVE_Template->assign('im', 1);

							$this->_loginRequiredFieldFetch();

							$AVE_Template->assign('available_countries', get_country_list(1));

							define('MODULE_CONTENT', $AVE_Template->fetch($this->_tpl_dir . 'register.tpl'));
						}
						else
						{
							$status = 0;

							$emailcode = md5(rand(100000,999999));

							switch ($this->_loginSettingsGet('login_reg_type'))
							{
								case 'now':
									$email_body = str_replace("%N%", "\n", $AVE_Template->get_config_vars('LOGIN_MESSAGE_1'));
									$email_body = str_replace("%NAME%", $_POST['user_name'], $email_body);
									$email_body = str_replace("%HOST%", get_home_link(), $email_body);
									$email_body = str_replace("%KENNWORT%", $_POST['reg_pass'], $email_body);
									$email_body = str_replace("%EMAIL%", $_POST['reg_email'], $email_body);
									$status = 1;
									$link = $this->_reg_now;
									break;

								case 'email':
									$email_body = str_replace("%N%", "\n", $AVE_Template->get_config_vars('LOGIN_MESSAGE_2')
																		 . $AVE_Template->get_config_vars('LOGIN_MESSAGE_3'));
									$email_body = str_replace("%NAME%", $_POST['user_name'], $email_body);
									$email_body = str_replace("%KENNWORT%", $_POST['reg_pass'], $email_body);
									$email_body = str_replace("%EMAIL%", $_POST['reg_email'], $email_body);
									$email_body = str_replace("%REGLINK%",
															  get_home_link() . "index.php"
																			  . "?module=login"
																			  . "&action=register"
																			  . "&sub=registerfinal"
																			  . "&emc=" . $emailcode,
															  $email_body);
									$email_body = str_replace("%HOST%", get_home_link(), $email_body);
									$email_body = str_replace("%CODE%", $emailcode, $email_body);
									$link = $this->_reg_email;
									break;

								case 'byadmin':
									$email_body = str_replace("%N%", "\n", $AVE_Template->get_config_vars('LOGIN_MESSAGE_2')
																		 . $AVE_Template->get_config_vars('LOGIN_MESSAGE_4'));
									$email_body = str_replace("%NAME%", $_POST['user_name'], $email_body);
									$email_body = str_replace("%KENNWORT%", $_POST['reg_pass'], $email_body);
									$email_body = str_replace("%EMAIL%", $_POST['reg_email'], $email_body);
									$email_body = str_replace("%HOST%", get_home_link(), $email_body);
									$link = $this->_reg_admin;
									break;
							}

							$bodytoadmin = str_replace("%N%", "\n", $AVE_Template->get_config_vars('LOGIN_MESSAGE_5'));
							$bodytoadmin = str_replace("%NAME%", $_POST['user_name'], $bodytoadmin);
							$bodytoadmin = str_replace("%EMAIL%", $_POST['reg_email'], $bodytoadmin);

							$salt = make_random_string();
							$md5_pass_salt = md5(md5($_POST['reg_pass'] . $salt));

							$AVE_DB->Query("
								INSERT
								INTO " . PREFIX . "_users
								SET
									Id         = '',
									user_name  = '" . $_POST['user_name'] . "',
									password   = '" . addslashes($md5_pass_salt) . "',
									firstname  = '" . $_POST['reg_firstname'] . "',
									lastname   = '" . $_POST['reg_lastname'] . "',
									user_group = '" . $this->_newuser_group . "',
									reg_time   = '" . time() . "',
									status     = '" . (int)$status . "',
									email      = '" . $_POST['reg_email'] . "',
									emc        = '" . addslashes($emailcode) . "',
									country    = '" . strtoupper($_POST['country']) . "',
									reg_ip     = '" . addslashes($_SERVER['REMOTE_ADDR']) . "',
									taxpay     = '1',
									company    = '" . @$_POST['company'] . "',
									salt       = '" . addslashes($salt) . "'
							");

							if ($status == 1)
							{
								$_SESSION['user_id']      = $AVE_DB->InsertId();
						        $_SESSION['user_name']    = get_username(
									stripslashes($_POST['user_name']),
									stripslashes($_POST['reg_firstname']),
									stripslashes($_POST['reg_lastname'])
						        );
								$_SESSION['user_email']   = $_POST['reg_email'];
								$_SESSION['user_pass']    = $md5_pass_salt;
								$_SESSION['user_group']   = $this->_newuser_group;
								$_SESSION['user_country'] = strtoupper($_POST['country']);
								$_SESSION['user_ip']      = addslashes($_SERVER['REMOTE_ADDR']);
							}

							$SystemMail     = get_settings('mail_from');
							$SystemMailName = get_settings('mail_from_name');
							send_mail(
								$SystemMail,
								$bodytoadmin,
								$AVE_Template->get_config_vars('LOGIN_SUBJECT_ADMIN'),
								$SystemMail,
								$SystemMailName,
								'text'
							);
							send_mail(
								$_POST['reg_email'],
								$email_body,
								$AVE_Template->get_config_vars('LOGIN_SUBJECT_USER'),
								$SystemMail,
								$SystemMailName,
								'text'
							);
							header('Location:' . $link);
							exit;
						}
						break;

					case 'thankyou':
						$AVE_Template->config_load($this->_lang_file);

						define('MODULE_CONTENT', $AVE_Template->fetch($this->_tpl_dir . 'register_thankyou.tpl'));
						break;

					case 'registerfinal':
						if (isset($_REQUEST['emc']) && $_REQUEST['emc'] != '')
						{
							$row = $AVE_DB->Query("
								SELECT *
								FROM " . PREFIX . "_users
								WHERE emc = '" . $_REQUEST['emc'] . "'
							")->FetchRow();
							if ($row)
							{
//								$AVE_Template->assign('reg_type', $reg_type);
								$AVE_Template->assign('final', 'ok');
								$AVE_DB->Query("
									UPDATE " . PREFIX . "_users
									SET status = '1'
									WHERE emc = '" . $_REQUEST['emc'] . "'
								");
								$_SESSION['user_id']    = $row->Id;
								$_SESSION['user_pass']  = $row->password;
								$_SESSION['user_email'] = $row->email;
								$_SESSION['user_name']  = get_username($row->user_name,
																	   $row->firstname,
																	   $row->lastname);
								$_SESSION['user_ip']    = addslashes($_SERVER['REMOTE_ADDR']);
							}
						}

						define('MODULE_CONTENT', $AVE_Template->fetch($this->_tpl_dir . 'register_final.tpl'));
						break;

					case 'thankadmin':
						$AVE_Template->config_load($this->_lang_file);

						define('MODULE_CONTENT', $AVE_Template->fetch($this->_tpl_dir . 'register_admin.tpl'));
						break;

					case '':
					default :
						if (defined('ANTISPAM')) $AVE_Template->assign('im', 1);

						$this->_loginRequiredFieldFetch();

						$AVE_Template->assign('available_countries', get_country_list(1));

						define('MODULE_CONTENT', $AVE_Template->fetch($this->_tpl_dir . 'register.tpl'));
						break;
				}
				break;

			case '0':
				define('MODULE_CONTENT', $AVE_Template->get_config_vars('LOGIN_NOT_ACTIVE'));
				break;
		}
	}

	/**
	 * Восстановление пароля
	 *
	 */
	function loginUserPasswordReminder()
	{
		global $AVE_DB, $AVE_Template;

		if (isset($_SESSION['user_id']))
		{
			header('Location:' . get_home_link());
			exit;
		}

		$AVE_Template->config_load($this->_lang_file, 'passwordreminder');

		define('MODULE_SITE', $AVE_Template->get_config_vars('LOGIN_REMIND'));

		if (isset($_REQUEST['sub'])
			&& $_REQUEST['sub'] == 'confirm'
			&& !empty($_REQUEST['email']))
		{
			$row_remind = $AVE_DB->Query("
				SELECT
					new_pass,
					new_salt
				FROM " . PREFIX . "_users
				WHERE email   = '" . $_REQUEST['email'] . "'
				AND new_pass != ''
				AND new_pass  = '" . $_REQUEST['code'] . "'
				LIMIT 1
			")->FetchRow();
			if ($row_remind)
			{
				$AVE_DB->Query("
					UPDATE " . PREFIX . "_users
					SET
						password = '" . addslashes($row_remind->new_pass) . "',
						salt     = '" . addslashes($row_remind->new_salt) . "'
					WHERE email  = '" . $_REQUEST['email'] . "'
					AND new_pass = '" . $_REQUEST['code'] . "'
				");
			}

			$tpl_out = $AVE_Template->fetch($this->_tpl_dir . 'password_ok.tpl');
			define('MODULE_CONTENT', $tpl_out);
		}
		else
		{
			if (isset($_REQUEST['sub']) && $_REQUEST['sub'] == 'send' && !empty($_POST['f_mailreminder']))
			{
				$row_remind = $AVE_DB->Query("
					SELECT
						email,
						user_name,
						firstname,
						lastname
					FROM " . PREFIX . "_users
					WHERE email = '" . $_POST['f_mailreminder'] . "'
					LIMIT 1
				")->FetchRow();

				if ($row_remind)
				{
					$SystemMail = get_settings('mail_from');
					$SystemMailName = get_settings('mail_from_name');

					$chars  = "abcdefghijklmnopqrstuvwxyz";
					$chars .= "ABCDEFGHIJKLMNOPRQSTUVWXYZ";
					$chars .= "0123456789";
					$newpass = make_random_string(8, $chars);
					$newsalt = make_random_string();
					$md5_pass_salt = md5(md5($newpass . $newsalt));

					$AVE_DB->Query("
						UPDATE " . PREFIX . "_users
						SET
							new_pass = '" . addslashes($md5_pass_salt) . "',
							new_salt = '" . addslashes($newsalt) . "'
						WHERE email = '" . $_POST['f_mailreminder'] . "'
						LIMIT 1
					");

					$body = $AVE_Template->get_config_vars('LOGIN_MESSAGE_6');
					$body = str_replace("%NAME%",
										get_username($row_remind->user_name,
													 $row_remind->firstname,
													 $row_remind->lastname, 0),
										$body);
					$body = str_replace("%PASS%", $newpass, $body);
					$body = str_replace("%HOST%", get_home_link(), $body);
					$body = str_replace("%LINK%",
										get_home_link()	. "index.php"
														. "?module=login"
														. "&action=passwordreminder"
														. "&sub=confirm"
														. "&code=" . $md5_pass_salt
														. "&email=" . $_POST['f_mailreminder'],
										$body);
					$body = str_replace("%N%", "\n", $body);
					send_mail(
						stripslashes($_POST['f_mailreminder']),
						$body,
						$AVE_Template->get_config_vars('LOGIN_SUBJECT_REMINDER'),
						$SystemMail,
						$SystemMailName,
						'text'
					);
				}
			}

			define('MODULE_CONTENT', $AVE_Template->fetch($this->_tpl_dir . 'password_lost.tpl'));
		}
	}

	/**
	 * Изменение пароля
	 *
	 */
	function loginUserPasswordChange()
	{
		global $AVE_DB, $AVE_Template;

		$AVE_Template->config_load($this->_lang_file, 'passwordchange');

		define('MODULE_SITE', $AVE_Template->get_config_vars('LOGIN_PASSWORD_CHANGE'));

		if (!isset($_SESSION['user_id']))
		{
			header('Location:' . get_home_link());
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
			$error = array();

			if ($_POST['old_pass'] == '')
			{
				$error[] = $AVE_Template->get_config_vars('LOGIN_EMPTY_OLD_PASS');
			}
			elseif ($_SESSION['user_pass'] != md5(md5($_POST['old_pass'] . $salt)))
			{
				$error[] = $AVE_Template->get_config_vars('LOGIN_WRONG_OLD_PASS');
			}
			elseif ($_POST['new_pass'] == '')
			{
				$error[] = $AVE_Template->get_config_vars('LOGIN_EMPTY_NEW_PASS');
			}
			elseif (strlen($_POST['new_pass']) < 5)
			{
				$error[] = $AVE_Template->get_config_vars('LOGIN_WRONG_SHORT_PASS');
			}
			elseif ($_POST['new_pass_c'] == '')
			{
				$error[] = $AVE_Template->get_config_vars('LOGIN_EMPTY_NEW_PASS_C');
			}
			elseif ($_POST['new_pass'] != $_POST['new_pass_c'])
			{
				$error[] = $AVE_Template->get_config_vars('LOGIN_WRONG_EQU_PASS');
			}
			elseif (preg_match('/[^\x21-\xFF]/', $_POST['new_pass']))
			{
				$error[] = $AVE_Template->get_config_vars('LOGIN_WRONG_SYM_PASS');
			}

			if (count($error) > 0)
			{
				$AVE_Template->assign('errors', $error);
			}
			else
			{
				$newsalt = make_random_string();
				$md5_pass_salt = md5(md5($_POST['new_pass'] . $newsalt));

				$AVE_DB->Query("
					UPDATE " . PREFIX . "_users
					SET
						password = '" . addslashes($md5_pass_salt) . "',
						salt     = '" . addslashes($newsalt) . "'
					WHERE Id     = '" . (int)$_SESSION['user_id'] . "'
					AND email    = '" . addslashes($_SESSION['user_email']) . "'
					AND password = '" . addslashes($_SESSION['user_pass']) . "'
				");
				$_SESSION['user_pass'] = $md5_pass_salt;
				$AVE_Template->assign('changeok', 1);
			}
		}

		define('MODULE_CONTENT', $AVE_Template->fetch($this->_tpl_dir . 'password_change.tpl'));
	}

	/**
	 * Удаление учетной записи пользователя
	 *
	 */
	function loginUserAccountDelete()
	{
		global $AVE_Template;

		$AVE_Template->config_load($this->_lang_file, 'delaccount');

		define('MODULE_SITE', $AVE_Template->get_config_vars('LOGIN_DELETE_ACCOUNT'));

		if (!isset($_SESSION['user_id']) || !isset($_SESSION['user_pass']))
		{
			header('Location:index.php');
			exit;
		}

		if (isset($_REQUEST['delconfirm']) && $_REQUEST['delconfirm'] == 1 && UGROUP != 1)
		{
			user_delete($_SESSION['user_id']);
			unset($_SESSION['user_id']);
			unset($_SESSION['user_pass']);
			$AVE_Template->assign('delok', 1);
		}

		if (defined('UGROUP') && UGROUP == 1)
		{
			$AVE_Template->assign('admin', 1);
		}

		$tpl_out = $AVE_Template->fetch($this->_tpl_dir . 'delete_account.tpl');
		define('MODULE_CONTENT', $tpl_out);
	}

	/**
	 * Управление учетной записью пользователя
	 *
	 */
	function loginUserProfileEdit()
	{
		global $AVE_DB, $AVE_Template;

		if (!isset($_SESSION['user_id']) || !isset($_SESSION['user_pass']))
		{
			header('Location:'.get_home_link());
			exit;
		}

		$AVE_Template->config_load($this->_lang_file, 'myprofile');

		define('MODULE_SITE', $AVE_Template->get_config_vars('LOGIN_CHANGE_DETAILS'));

		if (isset($_REQUEST['sub']) && $_REQUEST['sub'] == 'update')
		{
			$errors = array();

			if ($this->_loginFieldIsRequired('login_require_firstname') && empty($_POST['firstname']))
			{
				$errors[] = $AVE_Template->get_config_vars('LOGIN_WRONG_FN_EMPTY');
			}
			if (preg_match($this->_regex, $_POST['firstname']))
			{
				$errors[] = $AVE_Template->get_config_vars('LOGIN_WRONG_FIRSTNAME');
			}

			if ($this->_loginFieldIsRequired('login_require_lastname') && empty($_POST['lastname']))
			{
				$errors[] = $AVE_Template->get_config_vars('LOGIN_WRONG_LN_EMPTY');
			}
			if (preg_match($this->_regex, $_POST['lastname']))
			{
				$errors[] = $AVE_Template->get_config_vars('LOGIN_WRONG_LASTNAME');
			}

			if (!empty($_POST['street']) && preg_match($this->_regex, $_POST['street']))
			{
				$errors[] = $AVE_Template->get_config_vars('LOGIN_WRONG_STREET');
			}
			if (!empty($_POST['street_nr']) && preg_match($this->_regex, $_POST['street_nr']))
			{
				$errors[] = $AVE_Template->get_config_vars('LOGIN_WRONG_HOUSE');
			}
			if (!empty($_POST['zipcode']) && preg_match($this->_regex, $_POST['zipcode']))
			{
				$errors[] = $AVE_Template->get_config_vars('LOGIN_WRONG_ZIP');
			}
			if (!empty($_POST['city']) && preg_match($this->_regex, $_POST['city']))
			{
				$errors[] = $AVE_Template->get_config_vars('LOGIN_WRONG_TOWN');
			}
			if (!empty($_POST['phone']) && preg_match($this->_regex, $_POST['phone']))
			{
				$errors[] = $AVE_Template->get_config_vars('LOGIN_WRONG_PHONE');
			}
			if (!empty($_POST['telefax']) && preg_match($this->_regex, $_POST['telefax']))
			{
				$errors[] = $AVE_Template->get_config_vars('LOGIN_WRONG_FAX');
			}

			if (!preg_match($this->_regex_email, $_POST['email']))
			{
				$errors[] = $AVE_Template->get_config_vars('LOGIN_WRONG_EMAIL');
			}
			else
			{
				$exist = $AVE_DB->Query("
					SELECT 1
					FROM " . PREFIX . "_users
					WHERE Id != '" . (int)$_SESSION['user_id'] . "'
					AND email = '" . $_POST['email'] . "'
				")->NumRows();

				if ($exist)
				{
					$errors[] = $AVE_Template->get_config_vars('LOGIN_WRONG_INUSE');
				}
			}

			if (!empty($_POST['birthday']) && !preg_match($this->_regex_geb, $_POST['birthday']))
			{
				$errors[] = $AVE_Template->get_config_vars('LOGIN_WRONG_BIRTHDAY');
			}

			if (!empty($_POST['birthday']))
			{
				$birthday = preg_split('/[[:punct:]| ]/', $_POST['birthday']);
				if (empty($birthday[0]) || $birthday[0] > 31)
				{
					$errors[] = $AVE_Template->get_config_vars('LOGIN_WRONG_DATE');
				}
				if (empty($birthday[1]) || $birthday[1] > 12)
				{
					$errors[] = $AVE_Template->get_config_vars('LOGIN_WRONG_MONTH');
				}
				if (empty($birthday[2]) || $birthday[2] > date("Y") || $birthday[2] < date("Y")-100)
				{
					$errors[] = $AVE_Template->get_config_vars('LOGIN_WRONG_YEAR');
				}

				if (empty($errors))
				{
					$_POST['birthday'] = $birthday[0] . '.' . $birthday[1] . '.' . $birthday[2];
				}
			}

			if (!empty($errors))
			{
				$AVE_Template->assign('errors', $errors);
			}
			else
			{
				$AVE_DB->Query("
					UPDATE " . PREFIX . "_users
					SET
						email     = '" . $_POST['email'] . "',
						street    = '" . $_POST['street'] . "',
						street_nr = '" . $_POST['street_nr'] . "',
						zipcode   = '" . $_POST['zipcode'] . "',
						city      = '" . $_POST['city'] . "',
						phone     = '" . $_POST['phone'] . "',
						telefax   = '" . $_POST['telefax'] . "',
						firstname = '" . $_POST['firstname'] . "',
						lastname  = '" . $_POST['lastname'] . "',
						country   = '" . $_POST['country'] . "',
						birthday  = '" . $_POST['birthday'] . "',
						company   = '" . $_POST['company'] . "'
					WHERE
						Id = '" . (int)$_SESSION['user_id'] . "'
					AND
						password = '" . addslashes($_SESSION['user_pass']) . "'
				");
				$AVE_Template->assign('password_changed', 1);
			}
		}

		$row = $AVE_DB->Query("
			SELECT *
			FROM " . PREFIX . "_users
			WHERE Id = '" . (int)$_SESSION['user_id'] . "'
			LIMIT 1
		")->FetchAssocArray();

		$AVE_Template->assign('available_countries', get_country_list(1));
		$AVE_Template->assign('row', $row);

		$this->_loginRequiredFieldFetch();

		define('MODULE_CONTENT', $AVE_Template->fetch($this->_tpl_dir . 'myprofile.tpl'));
	}

	/**
	 * Управление модулем Авторизации
	 *
	 */
	function loginSettingsEdit()
	{
		global $AVE_DB, $AVE_Template;

		if (isset($_REQUEST['sub']) && $_REQUEST['sub'] == 'save')
		{
			$login_deny_domain = str_replace(	array("\r\n", "\n"),
											',',
											$_REQUEST['login_deny_domain']
			);
			$login_deny_email = str_replace(	array("\r\n", "\n"),
											',',
											$_REQUEST['login_deny_email']
			);

			$AVE_DB->Query("
				UPDATE " . PREFIX . "_modul_login
				SET
					login_reg_type          = '" . $_REQUEST['login_reg_type'] . "',
					login_antispam          = '" . $_REQUEST['login_antispam'] . "',
					login_status            = '" . $_REQUEST['login_status'] . "',
					login_deny_domain       = '" . $login_deny_domain . "',
					login_deny_email        = '" . $login_deny_email . "',
					login_require_company   = '" . $_REQUEST['login_require_company'] . "',
					login_require_firstname = '" . $_REQUEST['login_require_firstname'] . "',
					login_require_lastname  = '" . $_REQUEST['login_require_lastname'] . "'
				WHERE
					Id = 1
			");

			header('Location:index.php?do=modules&action=modedit&mod=login&moduleaction=1&cp=' . SESSION);
			exit;
		}

		$row = $this->_loginSettingsGet();
		$row['login_deny_domain'] = str_replace(',', "\n", $row['login_deny_domain']);
		$row['login_deny_email']  = str_replace(',', "\n", $row['login_deny_email']);
		$AVE_Template->assign($row);

		$AVE_Template->config_load($this->_lang_file, 'showconfig');

		$AVE_Template->assign('content', $AVE_Template->fetch($this->_tpl_dir . 'admin_config.tpl'));
	}

	function loginUsernameAjaxCheck()
	{
		global $AVE_Template;

		$errors = array();

		$AVE_Template->config_load($this->_lang_file, 'registernew');

		if (empty($_POST['username']))
		{
			$errors[] = $AVE_Template->get_config_vars('LOGIN_WRONG_L_EMPTY');
		}
		elseif (!ctype_alnum($_POST['username']))
		{
			$errors[] = $AVE_Template->get_config_vars('LOGIN_WRONG_LOGIN');
		}
		elseif ($this->_loginUserNameExistsCheck($_POST['username']))
		{
			$errors[] = $AVE_Template->get_config_vars('LOGIN_WRONG_L_INUSE');
		}

		if (!empty($errors))
		{
			echo '<ul>';
			foreach ($errors as $error) echo '<li>' . $error . '</li>';
			echo '</ul>';
		}

		exit;
	}

	function loginEmailAjaxCheck()
	{
		global $AVE_Template;

		$errors = array();

		$AVE_Template->config_load($this->_lang_file, 'registernew');

		if (empty($_POST['email']))
		{
			$errors[] = $AVE_Template->get_config_vars('LOGIN_WRONG_EM_EMPTY');
		}
		elseif (!preg_match($this->_regex_email, $_POST['email']))
		{
			$errors[] = $AVE_Template->get_config_vars('LOGIN_WRONG_EMAIL');
		}
		else
		{
			if ($this->_loginEmailExistCheck($_POST['email']))
			{
				$errors[] = $AVE_Template->get_config_vars('LOGIN_WRONG_INUSE');
			}
			if (!$this->_loginEmailDomainInBlacklistCheck($_POST['email']))
			{
				$errors[] = $AVE_Template->get_config_vars('LOGIN_DOMAIN_FALSE');
			}
			if (!$this->_loginEmailInBlacklistCheck($_POST['email']))
			{
				$errors[] = $AVE_Template->get_config_vars('LOGIN_EMAIL_FALSE');
			}
		}

		if (!empty($errors))
		{
			echo '<ul>';
			foreach ($errors as $error) echo '<li>' . $error . '</li>';
			echo '</ul>';
		}

		exit;
	}
}

?>