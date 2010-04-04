<?php

/**
 * AVE.cms
 *
 * @package AVE.cms
 * @subpackage admin
 * @filesource
 */

/**
 * Извлечение из БД статистики по основным компонентам системы
 *
 */
function cntStat()
{
	global $AVE_DB, $AVE_Template;

	$cnts = array();

	$cnts['templates'] = $AVE_DB->Query("SELECT COUNT(*) FROM " . PREFIX . "_templates")->GetCell();
	$cnts['documents'] = $AVE_DB->Query("SELECT COUNT(*) FROM " . PREFIX . "_documents")->GetCell();
	$cnts['queries']   = $AVE_DB->Query("SELECT COUNT(*) FROM " . PREFIX . "_queries")->GetCell();
	$cnts['rubrics']   = $AVE_DB->Query("SELECT COUNT(*) FROM " . PREFIX . "_rubrics")->GetCell();

	$sql = $AVE_DB->Query("
		SELECT
			`Status`,
			COUNT(`Status`) AS cntStatus
		FROM " . PREFIX . "_module
		GROUP BY `Status`
	");
	while ($row = $sql->FetchRow())
	{
		$cnts['modules_' . $row->Status] = $row->cntStatus;
	}

	$sql = $AVE_DB->Query("
		SELECT
			Status,
			COUNT(Status) AS cntStatus
		FROM " . PREFIX . "_users
		GROUP BY `Status`
	");
	while ($row = $sql->FetchRow())
	{
		$cnts['users_' . $row->Status] = $row->cntStatus;
	}

	$AVE_Template->assign('cnts', $cnts);
}

/**
 * Форматированный вывод размера
 *
 * @param int $file_size размер
 * @return string нормированный размер с единицой измерения
 */
function formatsize($file_size)
{
	if ($file_size >= 1073741824)
	{
		$file_size = round($file_size / 1073741824 * 100) / 100 . ' Gb';
	}
	elseif ($file_size >= 1048576)
	{
		$file_size = round($file_size / 1048576 * 100) / 100 . ' Mb';
	}
	elseif ($file_size >= 1024)
	{
		$file_size = round($file_size / 1024 * 100) / 100 . ' Kb';
	}
	else
	{
		$file_size = $file_size . ' b';
	}

	return $file_size;
}

/**
 * Размер дириктории
 *
 * @param string $directory наименование директории
 * @return int
 */
function dirsize($directory)
{
	if (!is_dir($directory)) return -1;
	$size = 0;
	if ($DIR = opendir($directory))
	{
		while (($dirfile = readdir($DIR)) !== false)
		{
			if (@is_link($directory . '/' . $dirfile) || $dirfile == '.' || $dirfile == '..') continue;
			if (@is_file($directory . '/' . $dirfile))
			{
				$size += filesize($directory . '/' . $dirfile);
			}
			elseif (@is_dir($directory . '/' . $dirfile))
			{
				$dirSize = dirsize($directory . '/' . $dirfile);
				if ($dirSize >= 0)
				{
					$size += $dirSize;
				}
				else
				{
					return -1;
				}
			}
		}
		closedir($DIR);
	}

	return $size;
}

/**
 * Размер базы данных
 *
 * @return int
 */
function MySqlSize()
{
	global $AVE_DB;

	$sql = $AVE_DB->Query("SHOW TABLE STATUS");
	$mysql_size = '';
	while ($row = $sql->FetchAssocArray())
	{
		if (ereg('^' . preg_quote(PREFIX), $row['Name']))
		{
			$mysql_size += $row['Data_length'];
			$mysql_size += $row['Index_length'];
		}
	}

	return formatsize($mysql_size);
}

function cpReadfile($filename, $retbytes=true)
{
	$chunksize = 1*(1024*1024);
	$buffer = '';
	$cnt =0;

	$handle = fopen($filename, 'rb');

	if ($handle === false)
	{
		return false;
	}

	while (!feof($handle))
	{
		$buffer = fread($handle, $chunksize);
		echo $buffer;
		flush();
		if ($retbytes)
		{
			$cnt += strlen($buffer);
		}
	}

	$status = fclose($handle);

	if ($retbytes && $status)
	{
		return $cnt;
	}

	return $status;
}

function userCheck()
{
	if (!defined('UID') || !checkPermission('adminpanel'))
	{
		header('Location:admin.php');
		exit;
	}
}

function permCheck($perm)
{
	if (!checkPermission($perm))
	{
		define('NOPERM', 1);
		return false;
	}

	return true;
}

function isPhpCode($check_code)
{
	$check_code = stripslashes($check_code);
	$check_code = str_replace(' ', '', $check_code);
	$check_code = strtolower($check_code);

	if (strpos($check_code, '<?php') !== false ||
		strpos($check_code, '<?') !== false ||
		strpos($check_code, '<? ') !== false ||
		strpos($check_code, '<?=') !== false ||
		strpos($check_code, '<script language="php">') !== false ||
		strpos($check_code, 'language="php"') !== false ||
		strpos($check_code, "language='php'") !== false ||
		strpos($check_code, 'language=php') !== false)
	{
		return true;
	}

	return false;
}

function fetchTplTags($srcfile)
{
	global $vorlage;

	if (@include_once($srcfile))
	{
		reset ($vorlage);
		$vl = array();

		while (list($key, $value) = each($vorlage))
		{
			$tag->cp_tag = $key;
			$tag->cp_desc = $value;
			array_push($vl, $tag);
			unset($tag);
		}

		return $vl;
	}
	else
	{
		return '';
	}
}

function getMimeTyp($file)
{
	$file_extension = strtolower(substr(strrchr($file, '.'), 1));

	switch ($file_extension)
	{
		case 'psd': $ctype = 'image/x-photoshop'; break;
		case 'rar': $ctype = 'application/x-rar-compressed'; break;
		case 'zip': $ctype = 'application/x-zip-compressed'; break;
		case 'pdf': $ctype = 'application/pdf'; break;
		case 'bz2': $ctype = 'application/bzip2'; break;
		case 'doc':
		case 'dot':
		case 'wiz':
		case 'wzs': $ctype = 'application/msword'; break;
		case 'eps': $ctype = 'application/postscript'; break;
		case 'pot':
		case 'ppa':
		case 'pps':
		case 'ppt':
		case 'pwz': $ctype = 'application/vnd.ms-powerpoint'; break;
		case 'rtf': $ctype = 'application/rtf'; break;
		case 'rnx': $ctype = 'application/vnd.rn-realmedia'; break;
		case 'hlp': $ctype = 'hlp'; break;
		case 'gtar': $ctype = 'application/x-gtar'; break;
		case 'gzip':
		case 'tgz': $ctype = 'application/x-gzip'; break;
		case 'lnx': $ctype = 'application/x-latex'; break;
		case 'exe': $ctype = 'application/x-msdownload'; break;
		case 'swf': $ctype = 'application/x-shockwafe-flash'; break;
		case 'xml': $ctype = 'application/xml'; break;
		case 'midi': $ctype = 'audio/midi'; break;
		case 'mp3':
		case 'mp2':
		case 'mpga': $ctype = 'audio/mpeg'; break;
		case 'wav': $ctype = 'audio/wav'; break;
		case 'bmp': $ctype = 'audio/wav'; break;
		case 'gif': $ctype = 'image/gif'; break;
		case 'jpeg':
		case 'jpg':
		case 'jpe': $ctype = 'image/jpeg'; break;
		case 'png': $ctype = 'image/png'; break;
		case 'tif':
		case 'tiff': $ctype = 'image/tiff'; break;
		case 'ico': $ctype = 'image/x-icon'; break;
		case 'csv': $ctype = 'text/comma-separated-values'; break;
		case 'css': $ctype = 'text/css'; break;
		case 'htm':
		case 'html':
		case 'shtml': $ctype = 'text/html'; break;
		case 'txt':
		case 'klp':
		case 'tex':
		case 'php':
		case 'asp':
		case 'aspx':
		case 'php3':
		case 'php4':
		case 'php5':
		case 'sql': $ctype = 'text/plain'; break;
		case 'xml': $ctype = 'text/xml'; break;
		case 'xhtm': $ctype = 'text/xhtml'; break;
		case 'wml': $ctype = 'text/wml'; break;
		case 'mpeg':
		case 'mpg':
		case 'mpe':
		case 'mlv':
		case 'mpa':
		case 'wma':
		case 'wmv': $ctype = 'video/mpeg'; break;
		case 'avi': $ctype = 'video/x-msvideo'; break;
		case 'mov': $ctype = 'video/quicktime'; break;
		case 'xls': $ctype = 'application/vnd.ms-excel'; break;
		case 'ai': $ctype = 'application/postscript'; break;
		case 'rm': $ctype = 'application/vnd.rn-realmedia'; break;
		case 'gz': $ctype = 'application/x-gzip'; break;
		case 'js': $ctype = 'application/x-javascript'; break;
		case 'pl':
		case 'cc': $ctype = 'text/plain'; break;
		case 'qt': $ctype = 'video/quicktime'; break;
		default : $ctype='application/force-download';
	}

	return $ctype;
}

/**
 * имя пользователя по его идентификатору
 *
 * @param int $id - идентификатор пользователя
 * @return string
 */
function getUserById($id)
{
	global $AVE_DB, $user_by_id;

	$user = $row = '';

	if (!isset($user_by_id[$id]))
	{
		$row = $AVE_DB->Query("
			SELECT
				Vorname,
				Nachname
			FROM " . PREFIX . "_users
			WHERE Id = '" . (int)$id . "'
		")
		->FetchRow();

		if ($row)
		{
			$user = substr($row->Vorname, 0, 1) . "." . $row->Nachname;
			$user_by_id[$id] = $user;
		}
		else
		{
			$user_by_id[$id] = null;
		}
	}

	return $user_by_id[$id];
}

function getTemplateById($id)
{
	global $AVE_DB;

	$tplName = $AVE_DB->Query("
		SELECT TplName
		FROM " . PREFIX . "_templates
		WHERE Id = " . intval($id) . "
		LIMIT 1
	")
	->GetCell();

	return ($tplName) ? $tplName : '';
}

function getAllTemplates()
{
	global $AVE_DB;

	$sql = $AVE_DB->Query("
		SELECT
			Id,
			TplName
		FROM " . PREFIX . "_templates
	");
	$vorlagen_array = array();

	while ($row = $sql->FetchRow())
	{
		array_push($vorlagen_array, $row);
	}

	return $vorlagen_array;
}

function fetchFields($assign = 0)
{
	global $AVE_Template;

	$AVE_Template->config_load(BASE_DIR . '/admin/lang/' . $_SESSION['admin_lang'] . '/fields.txt', 'fields');
	$felder_vars = $AVE_Template->get_config_vars();

	$felder = array(
		array('id' => 'kurztext',  'name' => $felder_vars['FIELD_TEXT']),
		array('id' => 'langtext',  'name' => $felder_vars['FIELD_TEXTAREA']),
		array('id' => 'smalltext', 'name' => $felder_vars['FIELD_TEXTAREA_S']),
		array('id' => 'dropdown',  'name' => $felder_vars['FIELD_DROPDOWN']),
		array('id' => 'bild',      'name' => $felder_vars['FIELD_IMAGE']),
		array('id' => 'download',  'name' => $felder_vars['FIELD_FILE']),
		array('id' => 'link',      'name' => $felder_vars['FIELD_LINK']),
		array('id' => 'video_avi', 'name' => $felder_vars['FIELD_VIDEO_AVI']),
		array('id' => 'video_wmf', 'name' => $felder_vars['FIELD_VIDEO_WMF']),
		array('id' => 'video_wmv', 'name' => $felder_vars['FIELD_VIDEO_WMV']),
		array('id' => 'video_mov', 'name' => $felder_vars['FIELD_VIDEO_MOV']),
		array('id' => 'flash',     'name' => $felder_vars['FIELD_FLASH'])
	);

	if ($assign == 1)
	{
		$AVE_Template->assign('feld_array', $felder);
		return '';
	}
	else
	{
		return $felder;
	}
}

function NaviModule()
{
	global $AVE_DB, $AVE_Template;

	$modules = array();
	$sql = $AVE_DB->Query("
		SELECT
			ModulName,
			ModulPfad
		FROM " . PREFIX . "_module
		WHERE `Status` = 1
		ORDER BY ModulName ASC
	");
	while ($row = $sql->FetchRow())
	{
        unset($modul);
		if (! @include(BASE_DIR . '/modules/' . $row->ModulPfad . '/modul.php'))
		{
			echo 'Ошибка доступа к файлам модуля ' . $row->ModulPfad . '<br />';
		}
		elseif ($modul['AdminEdit'] == 1 && checkPermission('mod_' . $row->ModulPfad))
		{
			array_push($modules, $row);
		}
	}

	$AVE_Template->assign('modules', $modules);
}

?>