<?php

/**
 * AVE.cms
 *
 * @package AVE.cms
 * @filesource
 */

/**
 * ����� ��� �������� � �������������� ����� ��
 */
class AVE_DB_Service
{

/**
 *	��������
 */

	/**
	 * ����������� SQL-��������
	 *
	 * @var string
	 */
	var $_delimiter = '#####systemdump#####';

	/**
	 * ���� ���� ������
	 *
	 * @var string
	 */
	var $_database_dump = '';

/**
 *	���������� ������
 */

	/**
	 * ����� ������������ ����� ����� ���� ������
	 *
	 * @return boolean
	 */
	function _databaseDumpCreate()
	{
		global $AVE_DB;

		if (! (!empty($_REQUEST['ta']) && is_array($_REQUEST['ta']))) return false;

		$search  = array("\x00", "\x0a", "\x0d", "\x1a");
		$replace = array('\0', '\n', '\r', '\Z');

		$this->_database_dump = '';

		foreach ($_REQUEST['ta'] as $table)
		{
			if (preg_match('/^' . preg_quote(PREFIX) . '_/', $table))
			{
				$row = $AVE_DB->Query("SHOW CREATE TABLE " . $table)->FetchArray();
				$this->_database_dump .= "DROP TABLE IF EXISTS `" . $table . "`;" . $this->_delimiter . "\n";
				$this->_database_dump .= $row[1] . ";" . $this->_delimiter . "\n\n";

				$nums = 0;
				$sql = $AVE_DB->Query('SELECT * FROM `' . $table . '`');
				while ($row = $sql->FetchArray())
				{
					if ($nums==0)
					{
						$nums = $sql->NumFields();

						$temp_array = array();
						for ($i=0; $i<$nums; $i++)
						{
							$temp_array[] = $sql->FieldName($i);
						}
						$table_list = '(`' . implode('`, `', $temp_array) . '`)';
					}

					$temp_array = array();
					for ($i=0; $i<$nums; $i++)
					{
						if (!isset($row[$i]))
						{
							$temp_array[] = 'NULL';
						}
						elseif ($row[$i] != '')
						{
							$temp_array[] = "'" . str_replace($search, $replace, addslashes($row[$i])) . "'";
						}
						else
						{
							$temp_array[] = "''";
						}
					}
					$this->_database_dump .= 'INSERT INTO `' . $table . '` ' . $table_list . ' VALUES (' . implode(', ', $temp_array) . ");" . $this->_delimiter . "\n";
				}
				$this->_database_dump .= "\n";

				$sql->Close();
			}
		}

		return !empty($this->_database_dump);
	}

/**
 *	������� ������
 */

	/**
	 * �������� ����� ����� ���� ������
	 *
	 */
	function databaseDumpExport()
	{
		if (!$this->_databaseDumpCreate()) exit;

		header('Content-Type: text/plain');
		header('Expires: ' . gmdate('D, d M Y H:i:s') . ' GMT');
		header('Content-Disposition: attachment; filename=' . $_SERVER['SERVER_NAME'] . '_' . 'DB_BackUP' .  '_' . date('d.m.y') . '.sql');
		header('Content-Length: ' . strlen($this->_database_dump));
		header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
		header('Pragma: public');

		echo $this->_database_dump;

		$this->_database_dump = '';

		reportLog($_SESSION['user_name'] . ' - �������� ��������� ����������� ���� ������.', 2, 2);

		exit;
	}

	/**
	 * �������������� ���� ������ �� �����
	 *
	 * @param string $tempdir ���� � ����� � ������� ����������� ���� �����
	 */
	function databaseDumpImport($tempdir)
	{
		global $AVE_DB, $AVE_Template;

		$insert = false;

		if ($_FILES['file']['size'] != 0)
		{
			$fupload_name = $_FILES['file']['name'];
			$end = substr($fupload_name, -3);
			if ($end == 'sql')
			{
				if (!@move_uploaded_file($_FILES['file']['tmp_name'], $tempdir . $fupload_name)) die('������ ��� �������� �����!');
				@chmod($fupload_name, 0777);
				$insert = true;
			}
			else
			{
				$AVE_Template->assign('msg', '<span style="color:red">' . $AVE_Template->get_config_vars('MAIN_SQL_FILE_ERROR') . '</span>');
			}
		}

		if ($insert)
		{
			if ($fupload_name != '' && file_exists($tempdir . $fupload_name))
			{
				$handle = @fopen($tempdir . $fupload_name, 'r');
				$db_q = @fread($handle, filesize($tempdir . $fupload_name));
				fclose($handle);

				$m_ok = 0;
				$m_fail = 0;

				$querys = @explode($this->_delimiter, $db_q);

				foreach ($querys as $val)
				{
					if (chop($val) != '')
					{
						$q = str_replace("\n",'',$val);
						$q = $q . ';';
						if ($AVE_DB->Query($q))
						{
							$m_ok++;
						}
						else
						{
							$m_fail++;
						}
					}
				}

				@unlink($tempdir . $fupload_name);
				$msg = $AVE_Template->get_config_vars('MAIN_RESTORE_OK') . '<br /><br />'
					. $AVE_Template->get_config_vars('MAIN_TABLE_SUCC')
					. '<span style="color:green">' . $m_ok . '</span><br/> '
					. $AVE_Template->get_config_vars('MAIN_TABLE_ERROR')
					. ' <span style="color:red">' . $m_fail . '</span><br />';
				$AVE_Template->assign('msg', $msg);
			}
			else
			{
				$AVE_Template->assign('msg', '<span style="color:red">������! ������ ���� ������ �� ��������, �.�. ���������� ���� ����� ��� �� ���������.</span>');
			}
		}

		reportLog($_SESSION['user_name'] . ' - �������� ������������� ���� ������ �� ��������� �����', 2, 2);
	}

	/**
	 * ����������� ������ ���� ������
	 *
	 */
	function databaseTableOptimize()
	{
		global $AVE_DB;

		if (!empty($_POST['ta']) && is_array($_POST['ta']))
		{
			$AVE_DB->Query("OPTIMIZE TABLE `" . implode("`, `", $_POST['ta']) . "`");

			reportLog($_SESSION['user_name'] . ' - �������� ����������� ���� ������', 2, 2);
		}
	}

	/**
	 * �������������� ����������� ������ ���� ������
	 *
	 */
	function databaseTableRepair()
	{
		global $AVE_DB;

		if (!empty($_POST['ta']) && is_array($_POST['ta']))
		{
			$AVE_DB->Query("REPAIR TABLE `" . implode("`, `", $_POST['ta']) . "`");

			reportLog($_SESSION['user_name'] . ' - �������� ������������� ������ ���� ������', 2, 2);
		}
	}

	/**
	 * ������������ ������ ������
	 *
	 * @return string
	 */
	function databaseTableGet()
	{
		global $AVE_DB;

		$tables = '';

		$sql = $AVE_DB->Query("SHOW TABLES LIKE '" . PREFIX . "_%'");
		while ($row = $sql->FetchArray())
		{
			$tables .= '<option value="' . $row[0] . '" selected="selected">' . substr($row[0], 1+strlen(PREFIX)) . '</option>';
		}
		$sql->Close();

		return $tables;
	}
}

?>