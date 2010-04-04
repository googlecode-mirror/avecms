<?php

/**
 * AVE.cms
 *
 * @package AVE.cms
 * @filesource
 */

if (empty($config['dbhost']))
{
	header("Location:install.php");
	exit;
}

ini_set('session.save_handler', 'user');

$config['sess_dblink'] = '';
$config['sess_life'] = (!empty($config['session_lifetime']) && is_numeric($config['session_lifetime'])) ? $config['session_lifetime'] : (get_cfg_var("session.gc_maxlifetime") < 1440 ? 1440 : get_cfg_var("session.gc_maxlifetime"));

function sess_open($save_path, $session_name)
{
	global $config;

	if (! $config['sess_dblink'] = @mysql_connect($config['dbhost'], $config['dbuser'], $config['dbpass']))
	{
		echo "<li>Can't connect to ", $config['dbhost'], " as ", $config['dbuser'];
		echo "<li>MySQL Error: ", mysql_error();
		die;
	}

	if (! @mysql_select_db($config['dbname'], $config['sess_dblink']))
	{
		echo "<li>Ќевозможно получить доступ к базе данных ", $config['dbname'];
		die;
	}

	@mysql_query("SET NAMES 'cp1251'", $config['sess_dblink']);

	return true;
}

function sess_close()
{
	global $config;

	$qid = mysql_query("DELETE FROM {$config['dbpref']}_sessions WHERE expiry < '".time()."'", $config['sess_dblink']);

	return true;
}

function sess_read($key)
{
	global $config;

	$qid = mysql_query("SELECT value FROM {$config['dbpref']}_sessions WHERE sesskey = '$key' AND expiry > '".time()."' AND Ip = '{$_SERVER['REMOTE_ADDR']}'", $config['sess_dblink']);
	if (list($value) = @mysql_fetch_row($qid)) return $value;

	return false;
}

function sess_write($key, $val)
{
	global $config;

	if (! $qid = mysql_query("INSERT INTO {$config['dbpref']}_sessions VALUES ('$key', ".(time()+$config['sess_life']).", '".addslashes($val)."', '{$_SERVER['REMOTE_ADDR']}', FROM_UNIXTIME(expiry,'%d.%m.%Y, %H:%i:%s'))", $config['sess_dblink']))
	{
		$qid = mysql_query("UPDATE {$config['dbpref']}_sessions SET expiry = ".(time()+$config['sess_life']).", expire_datum = FROM_UNIXTIME(expiry,'%d.%m.%Y, %H:%i:%s'), value = '".addslashes($val)."', Ip = '{$_SERVER['REMOTE_ADDR']}' WHERE sesskey = '".$key."' AND Ip = '".$_SERVER['REMOTE_ADDR']."' AND expiry > '".time()."'", $config['sess_dblink']);
	}

	return $qid;
}

function sess_destroy($key)
{
	global $config;

	return mysql_query("DELETE FROM {$config['dbpref']}_sessions WHERE sesskey = '$key' AND Ip = '{$_SERVER['REMOTE_ADDR']}'", $config['sess_dblink']);
}

function sess_gc($maxlifetime)
{
	global $config;

	$qid = mysql_query("DELETE FROM {$config['dbpref']}_sessions WHERE expiry < '".time()."'", $config['sess_dblink']);

	return mysql_affected_rows($config['sess_dblink']);
}

session_set_save_handler("sess_open", "sess_close", "sess_read", "sess_write", "sess_destroy", "sess_gc");

?>