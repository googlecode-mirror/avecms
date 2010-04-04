<?php

/**
 * AVE.cms
 *
 * @package AVE.cms
 * @filesource
 */

/**
 * Класс работы с результатом выполнения MySQL-запроса
 */
class AVE_DB_Result
{

/**
 *	СВОЙСТВА
 */

	/**
	 * Результат выполнения запроса
	 *
	 * @var resource
	 * @access private
	 */
	var $_result;

/**
 *	ВНЕШНИЕ МЕТОДЫ
 */

	/**
	 * Конструктор, возвращает объект с указателем на результат выполнения SQL-запроса
	 *
	 * @param resource $result - указателем на результат выполнения SQL-запроса
	 * @return object AVE_DB_Result
	 * @access public
	 */
	function AVE_DB_Result($result)
	{
		$this->_result = $result;
	}

	/**
	 * Обрабатывает ряд результата запроса, возвращая ассоциативный массив и численный массив
	 *
	 * @return array
	 * @access public
	 */
	function FetchArray()
	{
		return @mysql_fetch_array($this->_result);
	}

	/**
	 *  Обрабатывает ряд результата запроса и возвращает ассоциативный массив
	 *
	 * @return array
	 * @access public
	 */
	function FetchAssocArray()
	{
		return @mysql_fetch_array($this->_result, MYSQL_ASSOC);
	}

	/**
	 * Обрабатывает ряд результата запроса и возвращает объект
	 *
	 * @return object
	 * @access public
	 */
	function FetchRow()
	{
		return @mysql_fetch_object($this->_result);
	}

	/**
	 * Возвращает данные результата запроса
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
	 * Перемещает внутренний указатель в результате запроса
	 *
	 * @param int $id - номер ряда результатов запроса
	 * @return bool
	 * @access public
	 */
	function DataSeek($id = 0)
	{
		return @mysql_data_seek($this->_result, $id);
	}

	/**
	 * Возвращает количество рядов результата запроса
	 *
	 * @return int
	 * @access public
	 */
	function NumRows()
	{
		return @mysql_num_rows($this->_result);
	}

	/**
	 * Возвращает количество полей результата запроса
	 *
	 * @return int
	 * @access public
	 */
	function NumFields()
	{
		return mysql_num_fields($this->_result);
	}

	/**
	 * Возвращает название указанной колонки результата запроса
	 *
	 * @param int $i - индекс колонки
	 * @return string
	 * @access public
	 */
	function FieldName($i)
	{
		return mysql_field_name($this->_result, $i);
	}

	/**
	 * Освобождает память от результата запроса
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
 * Класс работы с MySQL
 */
class AVE_DB
{

/**
 *	СВОЙСТВА
 */

	/**
	 * Идентификатор соединения с БД
	 *
	 * @var DbStateHandler
	 * @access private
	 */
	var $_handle;

	/**
	 * Список выполненных запросов
	 *
	 * @var array
	 * @access private
	 */
	var $_query_list;

	/**
	 * Метки времени до и после выполнения SQL-запроса
	 *
	 * @var array
	 * @access private
	 */
	var $_time_exec;

/**
 *	ВНЕШНИЕ МЕТОДЫ
 */

	/**
	 * Конструктор устанавливающий соединение с БД
	 *
	 * @param string $host - адрес сервера
	 * @param string $user - имя пользователя
	 * @param string $pass - пароль
	 * @param string $db - имя БД
	 * @return object AVE_DB - объект для работы с БД
	 * @access public
	 */
	function AVE_DB($host, $user, $pass, $db)
	{
		if (!$this->_handle = @mysql_connect($host, $user, $pass))
		{
			$this->_error('connect');
			return false;
		}

		if (!@mysql_select_db($db, $this->_handle))
		{
			$this->_error('select');
			return false;
		}

		@mysql_query ("SET NAMES 'cp1251'");
		return true;
	}

	/**
	 * Посылает запрос MySQL
	 *
	 * @param string $query - текст SQL-запроса
	 * @return object - объект с указателем на результат выполнения запроса
	 * @access public
	 */
	function Query($query)
	{
		$this->_time_exec[] = microtime();
		$res = @mysql_query($query, $this->_handle);
		$this->_time_exec[] = microtime();
		$this->_query_list[] = $query;
		if (!$res) $this->_error('query', $query);

		return new AVE_DB_Result($res);
	}

	/**
	 * Экранирует специальные символы в строках для использования в выражениях SQL
	 *
	 * @param mixed $value - обрабатываемое значение
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
	 * Возвращает ID, сгенерированный при последнем INSERT-запросе
	 *
	 * @return int
	 * @access public
	 */
	function InsertId()
	{
		return mysql_insert_id($this->_handle);
	}

	/**
	 * Статистика выполнения SQL-запросов
	 *
	 * @param string $type - тип запрашиваемой статистики
	 * <pre>
	 * Возможные значения:
	 *     list  - список выполненых зпаросов
	 *     time  - время исполнения зпросов
	 *     count - количество выполненных запросов
	 * </pre>
	 * @return mixed
	 * @access public
	 */
	function StatDB($type = '')
	{
		switch ($type)
		{
			case 'list':
				list($s_dec, $s_sec) = explode(" ", $GLOBALS['start_time']);
				$query_list = '';
				$nq = 0;
				$time_exec = 0;
				$arr = $this->_time_exec;
				$co = sizeof($arr);
				for ($it=0;$it<$co;)
				{
					list($a_dec, $a_sec) = explode(" ", $arr[$it++]);
					list($b_dec, $b_sec) = explode(" ", $arr[$it++]);
					$time_main = ($a_sec - $s_sec + $a_dec - $s_dec)*1000;
					$time_exec = ($b_sec - $a_sec + $b_dec - $a_dec)*1000;
					$query = sizeof(array_keys($this->_query_list, $this->_query_list[$nq])) > 1
						? "<span style=\"background-color:#ff9;\">" . $this->_query_list[$nq++] . "</span>"
						: $this->_query_list[$nq++];
					$query_list .= (($time_exec > 1)
						? "<li style=\"color:#c00\">("
						: "<li>(")
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
	 * Возвращает информацию о сервере MySQL
	 *
	 * @return string
	 * @access public
	 */
	function mysql_version()
	{
		return  mysql_get_server_info($this->_handle);
	}

/**
 *	ВНУТРЕННИЕ МЕТОДЫ
 */

	/**
	 * Обработка ошибок
	 *
	 * @param string $type - тип ошибки
	 *         (при подключении к БД или при выполнении SQL-запроса)
	 * @param string $query - текст SQL запроса вызвавшего ошибку
	 * @access private
	 */
	function _error($type, $query = '')
	{
		global $AVE_Globals, $config;

		if ($type != 'query')
		{
			echo 'Error ' . $type . ' MySQL database. <br />';
		}
		else
		{
			$my_error = mysql_error();
			reportLog("SQL Errror: " . $my_error . PHP_EOL
				. "IP: " . $_SERVER['REMOTE_ADDR']
				. " Time: " . date('d-m-Y, H:i:s')
				. " URL: " . BASE_URL . $_SERVER['REQUEST_URI']
			);
			if ($config['sql_error'])
			{
				$AVE_Globals = new AVE_Globals;
				$system_mail = $AVE_Globals->mainSettings('mail_from');
				$system_mail_name = $AVE_Globals->mainSettings('mail_from_name');
				$mail_body = ('Query:' . $query
					. ' Errror:' . $my_error
					. ' IP: ' . $_SERVER['REMOTE_ADDR']
					. ' Time: ' . date('d-m-Y, H:i:s')
					. ' URL: ' . BASE_URL . $_SERVER['REQUEST_URI']
				);
				$AVE_Globals->cp_mail(
					$system_mail,
					$mail_body,
					'MySQL Error!',
					$system_mail,
					$system_mail_name,
					'text'
				);
			}
		}
	}
}

?>