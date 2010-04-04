<?php

/**
 * AVE.cms
 *
 * @package AVE.cms
 * @filesource
 */

/**
 * @subpackage install
 */
error_reporting(E_ALL ^ E_NOTICE);

ob_start();

define('SETUP', 1);

define('BASE_DIR', str_replace("\\", "/", dirname(__FILE__)));

require_once(BASE_DIR . '/functions/func.pref.php');
require_once(BASE_DIR . '/inc/db.config.php');
require_once(BASE_DIR . '/class/class.template.php');
require_once(BASE_DIR . '/data/lang/ru.php');

if (!is_writable(BASE_DIR . '/templates_c/')) die($lang_i['templates_c_notwritable']);

$AVE_Template = new AVE_Template(BASE_DIR . '/data/tpl/');
$AVE_Template->assign('version_setup', $lang_i['install_name'] . ' ' . APP_NAME . ' ' . APP_VERSION);
$AVE_Template->assign('la', $lang_i);

$required_php = 423;
$required = array();
$required[] = '/data/eula/ru.tpl';

$writeable = array();
$writeable[] = '/attachments/';
$writeable[] = '/cache/';
$writeable[] = '/templates_c/';
$writeable[] = '/uploads/';
$writeable[] = '/inc/db.config.php';

$con = true;

$dbhost = (!empty($config['dbhost'])) ? $config['dbhost'] : '-';
$dbuser = (!empty($config['dbuser'])) ? $config['dbuser'] : '-';
$dbpass = (!empty($config['dbpass'])) ? $config['dbpass'] : '';
$dbname = (!empty($config['dbname'])) ? $config['dbname'] : '-';
$dbpref = (!empty($config['dbpref'])) ? $config['dbpref'] : '';

$dbpref = ($dbpref != '') ? $dbpref : $_REQUEST['dbprefix'];

if (! @mysql_connect($dbhost, $dbuser, $dbpass)) $con = false;
if (! @mysql_select_db($dbname)) $con = false;

if (!$con)
{
	$error = 1;
}

$error_is_required = array();
foreach ($writeable as $must_writeable)
{
	if (!is_writable(BASE_DIR . $must_writeable))
	{
		array_push($error_is_required, $lang_i['error_is_writeable'] . $must_writeable . $lang_i['error_is_writeable_2'] );
		$error = 1;
	}
}

foreach ($required as $is_required)
{
	if (@!is_file(BASE_DIR . $is_required))
	{
		array_push($error_is_required, $lang_i['error_is_required'] . $is_required . $lang_i['error_is_required_2'] );
		$error = 1;
	}
}

$myphp = @PHP_VERSION;
if ($myphp)
{
	$myphp_v = str_replace('.', '', $myphp);
	if ($myphp_v < $required_php)
	{
		array_push($error_is_required, $lang_i['phpversion_toold'] . $required_php);
	}
}

if (count($error_is_required) >= 1)
{
	$error = 1;
	$AVE_Template->assign('error_header', $lang_i['erroro_more']);
}
else
{
	$AVE_Template->assign('error_header', $lang_i['erroro']);
}

if (count($error_is_required) < 1) $error = '';
if ( ($error == 1) && ($_REQUEST['force'] != 1) )
{
	$AVE_Template->assign('error_is_required', $error_is_required);
	$AVE_Template->display('error.tpl');
	echo '<div align="center" class="footer"><br />'.APP_INFO.'</div>';
	exit;
}

if ($_REQUEST['step'] != 'finish')
{
	$query = @mysql_query("SELECT Id FROM " . $dbpref . "_users LIMIT 1");
	$num = @mysql_num_rows($query);

	if ($num > 0)
	{
		echo '<pre>' . $lang_i['installed'] . '</pre>';
		exit;
	}
}

switch ($_REQUEST['step'])
{
	case '' :
		if ( ($con) && ($_REQUEST['subaction'] != 'newset') )
		{
			$AVE_Template->display('step2.tpl');
			exit;
		}

		switch ($_REQUEST['subaction'])
		{
			case 'newset' :
				if (@!is_writeable(BASE_DIR . '/inc/db.config.php'))
				{
					$AVE_Template->assign('step', 'no');
					$AVE_Template->display('error.tpl');
					echo '<div align="center" class="footer"><br />'.APP_INFO.'</div>';
					exit;
				}

				$connection = 1;
				if (! @mysql_connect($_POST['dbhost'], $_POST['dbuser'], $_POST['dbpass'])) $connection = 0;
				if (! @mysql_select_db($_POST['dbname'])) $connection = 0;

				if ( ($connection == 1) && ($_POST['dbprefix'] != '') )
				{
					$fp=@fopen(BASE_DIR . '/inc/db.config.php', 'w+');
					@fwrite($fp, "<?php
\$config['dbhost'] = \"".str_replace("\"","\\\\\"",stripslashes(trim($_POST['dbhost'])))."\";
\$config['dbuser'] = \"".str_replace("\"","\\\\\"",stripslashes(trim($_POST['dbuser'])))."\";
\$config['dbpass'] = \"".str_replace("\"","\\\\\"",stripslashes(trim($_POST['dbpass'])))."\";
\$config['dbname'] = \"".str_replace("\"","\\\\\"",stripslashes(trim($_POST['dbname'])))."\";
\$config['dbpref'] = \"".str_replace("\"","\\\\\"",stripslashes(trim($_POST['dbprefix'])))."\";
?>");

					@fclose($fp);
					if ((int)$_REQUEST['InstallType'] == 1)
					{
						header("Location:install.php?demo=1&step=");
					}
					else
					{
						header("Location:install.php?step=");
					}

				}
				else
				{
					$AVE_Template->assign('warnnodb', $lang_i['enoconn']);
					$AVE_Template->assign('dbhost' , stripslashes(trim($_POST['dbhost'])));
					$AVE_Template->assign('dbuser' , stripslashes(trim($_POST['dbuser'])));
					$AVE_Template->assign('dbpass' , stripslashes(trim($_POST['dbpass'])));
					$AVE_Template->assign('dbname' , stripslashes(trim($_POST['dbname'])));
					$AVE_Template->assign('dbprefix' , stripslashes(trim($_POST['dbprefix'])));
				}
				break;
		}

		$_pref_ = '';
		$chars = array(
			'a', 'b', 'c', 'd', 'e', 'f', 'g', 'h', 'i', 'j', 'k', 'l', 'm',
			'n', 'o', 'p', 'q', 'r', 's', 't', 'u', 'v', 'w', 'x', 'y', 'z',
			'0', '1', '2', '3', '4', '5', '6', '7', '8', '9'
		);
		$ch = 5;
		$count = count($chars) - 1;
		srand((double)microtime() * 1000000);
		for ($i = 0; $i < $ch; $i++)
		{
			$_pref_ .= $chars[rand(0, $count)];
		}
		$AVE_Template->assign('_pref_', $_pref_);
		$AVE_Template->display('step1.tpl');
		break;

	case 'check' :
		$AVE_Template->display('step2.tpl');
		break;

	case 1 :
		$first_sql = ((int)$_REQUEST['demo']==1) ? 'data/dstruktur.sql' : 'data/struktur.sql';
		$handle = fopen($first_sql, 'r');
		$actdb = fread($handle, filesize($first_sql));
		fclose($handle);
		$actdb = str_replace('%%PRFX%%', $dbpref, $actdb);

		$m_ok = 0;
		$m_fail = 0;

		$message_ok = array();
		$message_error = array();
		$ar = explode('#inst#', $actdb);

		@mysql_query("SET NAMES 'cp1251'");
		@mysql_query("SET COLLATION_CONNECTION = 'cp1251_general_ci'");

		foreach ($ar as $in)
		{
			@mysql_query($in);
		}

		$AVE_Template->assign('header_title', $lang_i['step1_table_status']);
		$AVE_Template->assign('message_ok', $message_ok);
		$AVE_Template->assign('message_error', $message_error);
		if ((int)$_REQUEST['demo']==1)
		{
			header("Location:install.php?demo=1&step=3");
		}
		else
		{
			header("Location:install.php?step=3");
		}
		exit;

	case 2 :
	case 3 :
		if ($_REQUEST['substep'] == 'final')
		{
			$_POST['email'] = chop($_POST['email']);
			$_POST['pass'] = chop($_POST['pass']);
			$_POST['username'] = chop($_POST['username']);
//			$_POST['firstname'] = chop($_POST['firstname']);
//			$_POST['lastname'] = chop($_POST['lastname']);

			$errors = array();
			if ($_POST['email'] == '') array_push($errors, $lang_i['noemail']);
			if (!ereg('^[_A-Za-zР-пр-џ0-9-]+(\.[_A-Za-zР-пр-џ0-9-]+)*@([a-zA-Z0-9-]+\.)+([a-zA-Z]{2,4})$', $_POST['email'])) array_push($errors, $lang_i['email_no_specialchars']);
			if (empty($_POST['pass']) || ereg('[^_A-Za-zР-пр-џ0-9-]', $_POST['pass'])) array_push($errors, $lang_i['check_pass']);
			if (strlen($_POST['pass']) < 5) array_push($errors, $lang_i['pass_too_small']);
			if (empty($_POST['username']) || ereg('[^ _A-Za-zР-пр-џ0-9-]', $_POST['username'])) array_push($errors, $lang_i['check_username']);
//			if (empty($_POST['firstname']) || ereg('[^ _A-Za-zР-пр-џ0-9-]', $_POST['firstname'])) array_push($errors, $lang_i['check_name']);
//			if (empty($_POST['lastname']) || ereg('[^ _A-Za-zР-пр-џ0-9-]', $_POST['lastname'])) array_push($errors, $lang_i['check_last_name']);

			if (count($errors) < 1)
			{
				$first_sql = ((int)$_REQUEST['demo']==1) ? 'data/ddata.sql' : 'data/data.sql';
				$handle = fopen($first_sql, 'r');
				$dbin = fread($handle, filesize($first_sql));
				fclose($handle);

				$dbin = str_replace('%%SITENAME%%', APP_NAME . ' ' . APP_VERSION, $dbin);
				$dbin = str_replace('%%PRFX%%', $dbpref, $dbin);
				$dbin = str_replace('%%EMAIL%%', $_POST['email'], $dbin);
				$dbin = str_replace('%%PASS%%', md5(md5($_POST['pass'])), $dbin);
				$dbin = str_replace('%%ZEIT%%', time(), $dbin);
				$dbin = str_replace('%%VORNAME%%', $_POST['firstname'], $dbin);
				$dbin = str_replace('%%NACHNAME%%', $_POST['lastname'], $dbin);
				$dbin = str_replace('%%USERNAME%%', $_POST['username'], $dbin);
				$dbin = str_replace('%%FON%%', $_POST['fon'], $dbin);
				$dbin = str_replace('%%FAX%%', $_POST['fax'], $dbin);
				$dbin = str_replace('%%PLZ%%', $_POST['zip'], $dbin);
				$dbin = str_replace('%%ORT%%', $_POST['town'], $dbin);
				$dbin = str_replace('%%STRASSE%%', $_POST['street'], $dbin);
				$dbin = str_replace('%%HNR%%', $_POST['hnr'], $dbin);

				$m_ok = 0;
				$m_fail = 0;

				$message_ok = array();
				$message_error = array();
				$ar = explode('#inst#', $dbin);

				@mysql_query("SET NAMES 'cp1251'");
				@mysql_query("SET COLLATION_CONNECTION = 'cp1251_general_ci'");

				foreach ($ar as $in)
				{
					mysql_query($in);
				}

				header('Location:install.php?step=finish');
			}
		}

		if (count($errors) > 0)
		{
			$AVE_Template->assign('errors', $errors);
			$AVE_Template->assign('uname', stripslashes(trim($_POST['uname'])));
			$AVE_Template->assign('pass', stripslashes(trim($_POST['pass'])));
			$AVE_Template->assign('pass_confirm', stripslashes(trim($_POST['pass_confirm'])));
			$AVE_Template->assign('email', stripslashes(trim($_POST['email'])));
			$AVE_Template->assign('email_confirm', stripslashes(trim($_POST['email_confirm'])));
		}

		$AVE_Template->display('step3.tpl');
		break;

	case 'finish' :
		$AVE_Template->display('step4.tpl');
		break;
}

?>