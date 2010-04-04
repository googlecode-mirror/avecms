<?php

/**
 * AVE.cms
 *
 * @package AVE.cms
 * @filesource
 */

/**
 * Класс для создания и восстановления дампа БД
 */
class AVE_SQL_Dump
{

	function getDump($file)
	{
		header('Content-Type: text/plain');
		header('Expires: ' . gmdate('D, d M Y H:i:s') . ' GMT');
		header('Content-Disposition: attachment; filename=' . $_SERVER['SERVER_NAME'] . '_' . 'DB_BackUP' .  '_' . date('d.m.y') . '.sql');
		header('Content-Length: ' . strlen($file));
		header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
		header('Pragma: public');

		echo $file;

		reportLog($_SESSION['user_name'] . ' - выполнил резервное копирование базы данных.', 2, 2);

		exit;
	}

	function createTable($table)
	{
		global $AVE_DB;

		$row = $AVE_DB->Query("SHOW CREATE TABLE " . $table)->FetchArray();

		return "DROP TABLE IF EXISTS `" . $table . "`;#####systemdump#####\n" . $row[1] . ";#####systemdump#####\n\n";
	}

	function writeDump()
	{
		global $AVE_DB;

		$arr = $_REQUEST['ta'];
		$search  = array("\x00", "\x0a", "\x0d", "\x1a");
		$replace = array('\0', '\n', '\r', '\Z');
		$dump = '';

		while(list($key, $table) = each($arr))
		{
			if(ereg('^' . preg_quote(PREFIX), $table))
			{
				$dump .= $this->createTable($table);
				$sql = $AVE_DB->Query('SELECT * FROM `' . $table . '`');
				$nums = 0;
				while($row = $sql->FetchArray())
				{
					if ($nums==0)
					{
						$nums = $sql->NumFields();

						$temp_array = array();
						for($i=0; $i<$nums; $i++)
						{
							$temp_array[] = $sql->FieldName($i);
						}
						$table_list = '(`' . implode('`, `', $temp_array) . '`)';
					}

					$temp_array = array();
					for($i=0; $i<$nums; $i++)
					{
						if(!isset($row[$i]))
						{
							$temp_array[] = 'NULL';
						}
						elseif($row[$i] != '')
						{
							$temp_array[] = "'" . str_replace($search, $replace, addslashes($row[$i])) . "'";
						}
						else
						{
							$temp_array[] = "''";
						}
					}
					$dump .= 'INSERT INTO `' . $table . '` ' . $table_list . ' VALUES (' . implode(', ', $temp_array) . ");#####systemdump#####\n";
				}
				$dump .= "\n";

//				$sql->Close();
			}
		}

		return $dump;
	}

	function dbRestore($tempdir)
	{
		global $AVE_DB, $AVE_Template, $config_vars;

		$insert = false;
		if($_FILES['file']['size'] != 0)
		{
			$fupload_name = $_FILES['file']['name'];
			$end = substr($fupload_name, -3);
			if($end == 'sql')
			{
				if(!@move_uploaded_file($_FILES['file']['tmp_name'], $tempdir . $fupload_name)) die('Ошибка при загрузке файла!');
				@chmod($fupload_name, 0777);
				$insert = true;
			}
			else
			{
				$AVE_Template->assign('msg', '<span style="color:red">'.$config_vars['MAIN_SQL_FILE_ERROR'].'</span>');
			}
		}

		if($insert)
		{
			if($fupload_name != '' && file_exists($tempdir . $fupload_name))
			{
				$handle = @fopen($tempdir . $fupload_name, 'r');
				$db_q = @fread($handle, filesize($tempdir . $fupload_name));
				fclose($handle);

				$m_ok = 0;
				$m_fail = 0;

				$ar = @explode('#####systemdump#####', $db_q);

				while(@list($key,$val) = @each($ar))
				{
					if(chop($val) != '')
					{
						$q = str_replace("\n",'',$val);
						$q = $q . ';';
						if($AVE_DB->Query($q))
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
				$msg = $config_vars['MAIN_RESTORE_OK'];
				$msg .= '<br /><br />' . $config_vars['MAIN_TABLE_SUCC'] . '<span style="color:green">' . $m_ok . '</span><br/> ' . $config_vars['MAIN_TABLE_ERROR'] . ' <span style="color:red">' . $m_fail . '</span><br />';
				$AVE_Template->assign('msg', $msg);
			}
			else
			{
				$AVE_Template->assign('msg', '<span style="color:red">Ошибка! Импорт базы данных не выполнен, т.к. отсутсвует файл дампа или он поврежден.</span>');
			}
		}
		reportLog($_SESSION['user_name'] . ' - выполнил востановление базы данных из резервной копии', 2, 2);
	}

	function optimizeRep()
	{
		global $AVE_DB;

		if($_REQUEST['whattodo'] == 'optimize')
		{
			$AVE_DB->Query('OPTIMIZE TABLE ' . implode(',', $_REQUEST['ta']));
			reportLog($_SESSION['user_name'] . ' - выполнил оптимизацию базы данных', 2, 2);
		}
		else
		{
			$AVE_DB->Query('REPAIR TABLE ' . implode(',', $_REQUEST['ta']));
			reportLog($_SESSION['user_name'] . ' - выполнил востановление таблиц базы данных', 2, 2);
		}

		return $this->showTables();
	}

	function showTables()
	{
		global $AVE_DB;

		$tabellen = '';
		$sql = $AVE_DB->Query('SHOW TABLES');
		while($row = $sql->FetchArray())
		{
			$titel = $row[0];
			if(ereg('^' . preg_quote(PREFIX), $titel))
			{
				$tabellen .= '<option value="' . $titel . '" selected>' . substr($titel, 1+strlen(PREFIX)) . '</option>';
			}
		}
		$sql->Close();

		return $tabellen;
	}
}

?>