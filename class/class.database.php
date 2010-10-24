<?php

/**
 * AVE.cms
 *
 * ����� ������������ ��� �������� ������� ��� mysql ��������� � ��.
 *
 * @package AVE.cms
 * @filesource
 */

/**
 * �����, ��������������� ��� ������ � ������������ ���������� MySQL-�������
 */
class AVE_DB_Result
{

/**
 *	�������� ������
 */

	/**
	 * �������� ��������� ���������� �������
	 *
	 * @var resource
	 * @access private
	 */
	var $_result;


/**
 *	������� ������ ������
 */

	/**
	 * �����������, ���������� ������ � ���������� �� ��������� ���������� SQL-�������
	 *
	 * @param resource $result	���������� �� ��������� ���������� SQL-�������
	 * @return object AVE_DB_Result
	 * @access public
	 */
	function AVE_DB_Result($result)
	{
		$this->_result = $result;
	}

	/**
	 * �����, ��������������� ��� ��������� ���������� �������.
	 * ���������� ��� �������������, ��� � ��������� ������.
	 *
	 * @return array
	 * @access public
	 */
	function FetchArray()
	{
		return @mysql_fetch_array($this->_result);
	}

	/**
	 *  �����, ��������������� ��� ��������� ���������� �������.
	 *  ���������� ������ ������������� ������.
	 *
	 * @return array
	 * @access public
	 */
	function FetchAssocArray()
	{
		return @mysql_fetch_assoc($this->_result);
	}

	/**
	 * �����, ��������������� ��� ��������� ���������� �������, ��������� ������ � ���� �������.
	 *
	 * @return object
	 * @access public
	 */
	function FetchRow()
	{
		return @mysql_fetch_object($this->_result);
	}

	/**
	 * �����, ��������������� ��� ����������� ������ ���������� �������
	 *
	 * @return mixed
	 * @access public
	 */
	function GetCell()
	{
		if ($this->NumRows())
		{
			return @mysql_result($this->_result, 0);
		}
		return false;
	}


	/**
	 * �����, ��������������� ��� ����������� ����������� ��������� � ���������� �������
	 *
	 * @param int $id - ����� ���� ����������� �������
	 * @return bool
	 * @access public
	 */
	function DataSeek($id = 0)
	{
		return @mysql_data_seek($this->_result, $id);
	}

	/**
	 * �����, ��������������� ��� ��������� ���������� ����� ���������� �������
	 *
	 * @return int
	 * @access public
	 */
	function NumRows()
	{
		return @mysql_num_rows($this->_result);
	}


	/**
	 * �����, ��������������� ��� ��������� ���������� ����� ���������� �������
	 *
	 * @return int
	 * @access public
	 */
	function NumFields()
	{
		return mysql_num_fields($this->_result);
	}

	/**
	 * �����, ��������������� ��� ��������� �������� ��������� ������� ���������� �������
	 *
	 * @param int $i - ������ �������
	 * @return string
	 * @access public
	 */
	function FieldName($i)
	{
		return mysql_field_name($this->_result, $i);
	}

	/**
	 * �����, ��������������� ��� ������������ ������ �� ���������� �������
	 *
	 * @return bool
	 * @access public
	 */
	function Close()
	{
		$r = @mysql_free_result($this->_result);
		unset($this);
		return $r;
	}
}

/**
 * �����, ��������������� ��� ������ ��������������� � MySQL ��
 */
class AVE_DB
{

/**
 *	�������� ������
 */

	/**
	 * ������������� ���������� � ��
	 *
	 * @var DbStateHandler
	 * @access private
	 */
	var $_handle;

	/**
	 * ������ ����������� ��������
	 *
	 * @var array
	 * @access private
	 */
	var $_query_list;

	/**
	 * ����� ������� �� � ����� ���������� SQL-�������
	 *
	 * @var array
	 * @access private
	 */
	var $_time_exec;


	/**
	 * �����������
	 *
	 * @param string $host	����� �������
	 * @param string $user	��� ������������
	 * @param string $pass	������
	 * @param string $db	��� ��
	 * @return object		AVE_DB - ������
	 * @access public
	 */
	function AVE_DB($host, $user, $pass, $db)
	{
		// �������� ���������� ���������� � ��
		if (! $this->_handle = @mysql_connect($host, $user, $pass))
		{
			$this->_error('connect');
			exit;
		}

		// �������� ������� ��
 		if (! @mysql_select_db($db, $this->_handle))
		{
			$this->_error('select');
			exit;
		}

		// ������������� ���������
		if (function_exists('mysql_set_charset'))
		{
			mysql_set_charset('cp1251', $this->_handle);
		}
		else
		{
			mysql_query("SET NAMES 'cp1251'");
		}

		// ���������� ��������������
		if (defined('PROFILING') && PROFILING)
		{
//			mysql_query("QUERY_CACHE_TYPE = OFF");
//			mysql_query("FLUSH TABLES");
			if (mysql_query("SET PROFILING_HISTORY_SIZE = 100"))
			{
				mysql_query("SET PROFILING = 1");
			}
			else
			{
				define('SQL_PROFILING_DISABLE', 1);
			}
		}
	}

	/**
	 * �����, ��������������� ��� ��������� ������� �� ������� ������ ������ � �������
	 *
	 * @return string
	 */
	function get_caller()
	{
		if (! function_exists('debug_backtrace')) return '';

		$stack = debug_backtrace();
		$stack = array_reverse($stack);

		$caller = array();
		foreach ((array)$stack as $call)
		{
			if (@$call['class'] == __CLASS__) continue;
			$function = $call['function'];
			if (isset($call['class']))
			{
				$function = $call['class'] . "->$function";
			}
			$caller[] = (isset($call['file']) ? 'FILE: ' . $call['file'] . ' ' : '')
						. 'FUNCTION: ' . $function
						. (isset($call['line']) ? ' LINE: ' . $call['line'] : '');
		}

		return implode(', ', $caller);
	}

	/**
	 * �����, ��������������� ��� ��������� ������
	 *
	 * @param string $type - ��� ������ (��� ����������� � �� ��� ��� ���������� SQL-�������)
	 * @param string $query - ����� SQL ������� ���������� ������
	 * @access private
	 */
	function _error($type, $query = '')
	{
		if ($type != 'query')
		{
			display_notice('Error ' . $type . ' MySQL database.');
		}
		else
		{
			$my_error = mysql_error();

			reportLog('SQL ERROR: ' . $my_error . PHP_EOL
					. "\t\tQUERY: " . stripslashes($query) . PHP_EOL
					. "\t\t"        . $this->get_caller() . PHP_EOL
					. "\t\tURL: "   . HOST . $_SERVER['SCRIPT_NAME']
						            . '?' . $_SERVER['QUERY_STRING'] . PHP_EOL
			);

            // ���� � ���������� ������� ���������� �������� �� �������� ��������� �� e-mail, �����
            if (SEND_SQL_ERROR)
			{
				// ��������� ����� ��������� � �������
                $mail_body = ('SQL ERROR: ' . $my_error . PHP_EOL
					. 'TIME: '  . date('d-m-Y, H:i:s') . PHP_EOL
					. 'URL: '   . HOST . $_SERVER['SCRIPT_NAME']
					            . '?' . $_SERVER['QUERY_STRING'] . PHP_EOL
					. $this->get_caller() . PHP_EOL
					. 'QUERY: ' . stripslashes($query) . PHP_EOL
				);

                // ���������� ���������
                send_mail(
					get_settings('mail_from'),
					$mail_body,
					'MySQL Error!',
					get_settings('mail_from'),
					get_settings('mail_from_name'),
					'text'
				);
			}
		}
	}

/**
 *	������� ������ ������
 */

	/**
	 * �����, ��������������� ��� ���������� ������� � MySQL
	 *
	 * @param string $query - ����� SQL-�������
	 * @return object - ������ � ���������� �� ��������� ���������� �������
	 * @access public
	 */
	function Query($query)
	{
//		$this->_time_exec[] = microtime();
		$res = @mysql_query($query, $this->_handle);
//		$this->_time_exec[] = microtime();
//		$this->_query_list[] = $query;
		if (!$res) $this->_error('query', $query);

		return new AVE_DB_Result($res);
	}

	/**
	 * �����, ��������������� ��� ������������� ����������� �������� � ������� ��� ������������� � ���������� SQL
	 *
	 * @param mixed $value - �������������� ��������
	 * @return mixed
	 * @access public
	 */
	function Escape($value)
	{
		if (!is_numeric($value))
		{
			$value = function_exists('mysql_real_escape_string')
				? mysql_real_escape_string($value, $this->_handle)
				: mysql_escape_string($value);
		}

		return $value;
	}

	/**
	 * �����, ��������������� ��� ����������� ID ������, ��������������� ��� ��������� INSERT-�������
	 *
	 * @return int
	 * @access public
	 */
	function InsertId()
	{
		return mysql_insert_id($this->_handle);
	}

	/**
	 * �����, ��������������� ��� ������������ ���������� ���������� SQL-��������.
	 *
	 *
	 * @param string $type - ��� ������������� ����������
	 * <pre>
	 * ��������� ��������:
	 *     list  - ������ ���������� ��������
	 *     time  - ����� ���������� �������
	 *     count - ���������� ����������� ��������
	 * </pre>
	 * @return mixed
	 * @access public
	 */
	function DBStatisticGet($type = '')
	{
		switch ($type)
		{
			case 'list':
				list($s_dec, $s_sec) = explode(' ', $GLOBALS['start_time']);
				$query_list = '';
				$nq = 0;
				$time_exec = 0;
				$arr = $this->_time_exec;
				$co = sizeof($arr);
				for ($it=0;$it<$co;)
				{
					list($a_dec, $a_sec) = explode(' ', $arr[$it++]);
					list($b_dec, $b_sec) = explode(' ', $arr[$it++]);
					$time_main = ($a_sec - $s_sec + $a_dec - $s_dec)*1000;
					$time_exec = ($b_sec - $a_sec + $b_dec - $a_dec)*1000;
					$query = sizeof(array_keys($this->_query_list, $this->_query_list[$nq])) > 1
						? "<span style=\"background-color:#ff9;\">" . $this->_query_list[$nq++] . "</span>"
						: $this->_query_list[$nq++];
					$query_list .= (($time_exec > 1) ? "<li style=\"color:#c00\">(" : "<li>(")
						. round($time_main) . " ms) " . $time_exec . " ms " . $query . "</li>\n";
				}

				return $query_list;
				break;

			case 'time':
				$arr = $this->_time_exec;
				$time_exec = 0;
				$co = sizeof($arr);
				for ($it=0;$it<$co;) {
					list($a_dec, $a_sec) = explode(" ", $arr[$it++]);
					list($b_dec, $b_sec) = explode(" ", $arr[$it++]);
					$time_exec += $b_sec - $a_sec + $b_dec - $a_dec;
				}

				return $time_exec;
				break;

			case 'count':
				return sizeof($this->_query_list);
				break;

			default:
				return '';
				break;
		}
	}

	/**
	 * �����, ��������������� ��� ������������ ���������� ���������� SQL-��������.
	 *
	 * @param string $type - ��� ������������� ����������
	 * <pre>
	 * ��������� ��������:
	 *     list  - ������ ���������� ��������
	 *     time  - ����� ���������� �������
	 *     count - ���������� ����������� ��������
	 * </pre>
	 * @return mixed
	 * @access public
	 */
	function DBProfilesGet($type = '')
	{
		static $result, $list, $time, $count;

		if (!(defined('PROFILING') && PROFILING) || defined('SQL_PROFILING_DISABLE')) return false;

		if (!$result)
		{
			$list = "<table width=\"100%\">"
				. "\n\t<col width=\"20\">\n\t<col width=\"70\">";
			$result = mysql_query("SHOW PROFILES");
			while (list($qid, $qtime, $qstring) = @mysql_fetch_row($result))
			{
				$time += $qtime;
			    $list .= "\n\t<tr>\n\t\t<td><strong>"
			    	. $qid
			    	. "</strong></td>\n\t\t<td><strong>"
			    	. number_format($qtime * 1, 6, ',', '')
			    	. "</strong></td>\n\t\t<td><strong>"
			    	. $qstring
			    	. "</strong></td>\n\t</tr>";
			    $res = mysql_query("
			    	SELECT STATE, FORMAT(DURATION, 6) AS DURATION
			    	FROM INFORMATION_SCHEMA.PROFILING
			    	WHERE QUERY_ID = " . $qid
			    );
				while (list($state, $duration) = @mysql_fetch_row($res))
				{
				    $list .= "\n\t<tr>\n\t\t<td>&nbsp;</td><td>"
				    	. number_format($duration * 1, 6, ',', '')
				    	. "</td>\n\t\t<td>" . $state . "</td>\n\t</tr>";
				}
			}
			$time = number_format($time * 1, 6, ',', '');
			$list .= "\n</table>";
			$count = @mysql_num_rows($result);
		}

		switch ($type)
		{
			case 'list':  return $list;  break;
			case 'time':  return $time;  break;
			case 'count': return $count; break;
		}

		return false;
	}

	/**
	 * �����, ��������������� ��� ��������� ���������� � ������� MySQL
	 *
	 * @return string
	 * @access public
	 */
	function mysql_version()
	{
		return  mysql_get_server_info($this->_handle);
	}
}

global $AVE_DB;


// ������ ���������� ������� �� ������ � ��
if (! isset($AVE_DB))
{
	// ���������� ���������������� ���� � ����������� �����������
	require(BASE_DIR . '/inc/db.config.php');

	// ���� ��������� �� �������, ��������� ������
	if (! isset($config)) exit;

	// ���� ��������� �������� ������ �� ������, ������������� ���������� �� �� ��������� ���������� � ����� db.config.php
	if (! defined('PREFIX')) define('PREFIX', $config['dbpref']);

	// ������� ������ ��� ������ � ��
	$AVE_DB = new AVE_DB($config['dbhost'], $config['dbuser'], $config['dbpass'], $config['dbname']);

	unset($config);
}

?>