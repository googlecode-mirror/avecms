<?php

/**
 * AVE.cms
 *
 * @package AVE.cms
 * @subpackage admin
 * @filesource
 */

ob_start();

define('BASE_DIR', str_replace("\\", "/", substr(dirname(__FILE__), 0, -6)));

//include_once(BASE_DIR . '/functions/func.pref.php');
//include_once(BASE_DIR . '/inc/db.config.php');
//include_once(BASE_DIR . '/inc/config.php');
include_once(BASE_DIR . '/inc/init.php');

if (!isset($_SESSION['user_id']))
{
	header('Location:index.php');
	exit;
}

define('ACP', 1);
define('SESSION', session_id());
define('UPDIR', BASE_DIR . '/uploads');
define('ADMIN_THEME_FOLDER', empty($_SESSION['admin_theme']) ? DEFAULT_ADMIN_THEME_FOLDER : $_SESSION['admin_theme']);
define('ADMIN_LANGUAGE', empty($_SESSION['admin_lang']) ? DEFAULT_COUNTRY : $_SESSION['admin_lang']);

$tpl_dir = 'templates/' . ADMIN_THEME_FOLDER;
$AVE_Template = new AVE_Template($tpl_dir . '/browser');
$AVE_Template->config_load(BASE_DIR . '/admin/lang/' . ADMIN_LANGUAGE . '/main.txt');
$AVE_Template->assign('tpl_dir', $tpl_dir);
$AVE_Template->assign('sess', SESSION);

$mediapath = '';
$max_size  = 128; // максимальный размер миниатюры
$th_pref   = 'th_' . $max_size . '_'; // префикс миниатюр

if (isset($_REQUEST['thumb']) && $_REQUEST['thumb']==1)
{
	$img_path = str_replace(array('../', '..', '\'', '//', './'), '', $_REQUEST['bild']);
	$namepos = strrpos($img_path, '/');
	if ($namepos > 0)
	{
		$img_name = substr($img_path, ++$namepos);
		$img_dir  = substr($img_path, 0, $namepos);
		if (substr($img_path, 0, 1) != '/')
		{
			$img_dir = '/' . $img_dir;
		}
	}
	else {
		$img_name = substr($img_path, 1);
		$img_dir  = '/';
	}

	$thumb = imagecreatetruecolor($max_size, $max_size);

	$img_data = getimagesize(UPDIR . $img_path);
	switch ($img_data[2])
	{
		case '1' :
			if (function_exists('imagecreatefromgif'))
			{
				$img_src = imagecreatefromgif(UPDIR . $img_path);
				$header  = 'image/gif';
				imagecolortransparent($thumb, imagecolorallocate($thumb, 0, 0, 0));
			}
			else
			{
				exit;
			}
			break;

		case '2' :
			if (function_exists('imagecreatefromjpeg'))
			{
				$img_src = imagecreatefromjpeg(UPDIR . $img_path);
				$header  = 'image/jpeg';
//				imagefill($thumb, 0, 0, imagecolorallocate($thumb, 239, 243, 235));
				imagefill($thumb, 0, 0, imagecolorallocate($thumb, 255, 255, 255));
			}
			else
			{
				exit;
			}
			break;

		case '3' :
			if (function_exists('imagecreatefrompng'))
			{
				$img_src = imagecreatefrompng(UPDIR . $img_path);
				$header = 'image/png';
				imagecolortransparent($thumb, imagecolorallocate($thumb, 0, 0, 0));
			}
			else
			{
				exit;
			}
			break;
	}

	$thumb_id = $img_dir . $th_pref . $img_name;
	if (file_exists(UPDIR . $thumb_id))
	{
		header('Content-Type:' . $header, true);
		readfile(UPDIR . $thumb_id);
		exit;
	}

	if ($max_size > max($img_data[0], $img_data[1]))
	{
		$new_width  = $img_data[0];
		$new_height = $img_data[1];
	}
	elseif ($img_data[0]==$img_data[1])
	{
		$new_width  = $max_size;
		$new_height = $max_size;
	}
	elseif ($img_data[0] > $img_data[1])
	{
		$new_width  = $max_size;
		$new_height = round(($img_data[1]/$img_data[0]) * $max_size);
	}
	else {
		$new_width  = round(($img_data[0]/$img_data[1]) * $max_size);
		$new_height = $max_size;
	}

	imagecopyresampled($thumb, $img_src, round(($max_size-$new_width)/2), round(($max_size-$new_height)/2), 0, 0, $new_width, $new_height, $img_data[0], $img_data[1]);

	header($_SERVER['SERVER_PROTOCOL'] . ' 200 OK', true);
	header('Date: ' . gmdate("D, d M Y H:i:s") . ' GMT', true);
	header('Content-Type:' . $header, true);

	ob_start();
	switch ($img_data[2])
	{
		case '1' : imagegif($thumb); break;
		case '2' : imagejpeg($thumb, '', 70); break;
		case '3' : imagepng($thumb, '', 7); break;
	}
	$a = ob_get_contents();
	ob_end_clean();
	$fp = fopen(UPDIR . $thumb_id, 'wb+');
	fwrite($fp, $a);
	fclose($fp);
	@chmod(UPDIR . $thumb_id, 0777);
	echo $a;
	imagedestroy($thumb);
}

$_REQUEST['action'] = (isset($_REQUEST['action'])) ? $_REQUEST['action'] : '';

if ($_REQUEST['action']=='upload')
{
	$AVE_Template->display('browser_upload.tpl');
	exit;
}

if ($_REQUEST['action']=='upload2')
{
	for ($i=0;$i<count($_FILES['upfile']['tmp_name']);$i++)
	{
		$d_name = strtolower(ltrim(rtrim($_FILES['upfile']['name'][$i])));
		$d_name = str_replace(' ', '', $d_name);
		$d_tmp = $_FILES['upfile']['tmp_name'][$i];
		$endg = strtolower(substr($d_name, strlen($d_name) - 4));

		if ($_FILES['upfile']['type'][$i]=='image/pjpeg' ||
			$_FILES['upfile']['type'][$i]=='image/jpeg' ||
			$_FILES['upfile']['type'][$i]=='image/x-png' ||
			$_FILES['upfile']['type'][$i]=='image/png')
		{
			if (file_exists(UPDIR . $_REQUEST['pfad'] . $d_name ))
			{
				$expl = explode('.', $d_name);
				$d_name = $expl[0] . date('dhi'). '.' . $expl[1];
			}

			reportLog($_SESSION['user_name'] . ' - загрузил изображение в ('. $_REQUEST['pfad'] . $d_name. ')', 2, 2);

			@move_uploaded_file($d_tmp, UPDIR . $_REQUEST['pfad'] . $d_name);
			@chmod(UPDIR . $_REQUEST['pfad'] . $d_name, 0777);
			if (isset($_REQUEST['resize']) && $_REQUEST['resize']==1)
			{
				$error = 0;

				if (function_exists('imagecreatetruecolor'))
				{
					$sowhat = 'imagecreatetruecolor';
				}
				else
				{
					$sowhat = 'imagecreate';
				}

				$neues_bild = $sowhat($_REQUEST['w'], $_REQUEST['h']);
				if ($_FILES['upfile']['type'][$i]=='image/pjpeg' || $_FILES['upfile']['type'][$i]=='image/jpeg')
				{
					$altes_bild = imagecreatefromjpeg(UPDIR . $_REQUEST['pfad'] . $d_name);
				}

				if ($_FILES['upfile']['type'][$i]=='image/png' || $_FILES['upfile']['type'][$i]=='x/png')
				{
					$altes_bild = imagecreatefrompng(UPDIR . $_REQUEST['pfad'] . $d_name);
				}

				if ($_FILES['upfile']['type'][$i]=='image/gif')
				{
					$error = 1;
				}

				if (isset($altes_bild))
				{
					imagecopyresampled($neues_bild, $altes_bild, 0, 0, 0, 0, imagesx($neues_bild), imagesy($neues_bild), imagesx($altes_bild), imagesy($altes_bild));

					if ($_FILES['upfile']['type'][$i]=='image/pjpeg' || $_FILES['upfile']['type'][$i]=='image/jpeg')
					{
						unlink(UPDIR . $_REQUEST['pfad'] . $d_name);
						imagejpeg($neues_bild, UPDIR . $_REQUEST['pfad'] . $d_name, 95);
					}

					if ($_FILES['upfile']['type'][$i]=='image/png' || $_FILES['upfile']['type'][$i]=='x/png')
					{
						unlink(UPDIR . $_REQUEST['pfad'] . $d_name);
						imagepng($neues_bild, UPDIR . $_REQUEST['pfad'] . $d_name, 95);
					}
				}
			}
			else
			{
				$d_tmp = $_FILES['upfile']['tmp_name'];
				move_uploaded_file($d_tmp, UPDIR . $_REQUEST['pfad'] . $d_name);
				@chmod(UPDIR . $_REQUEST['pfad'] . $d_name, 0777);
			}
		}
		else
		{
			move_uploaded_file($d_tmp, UPDIR . $_REQUEST['pfad'] . $d_name);
			@chmod(UPDIR . $_REQUEST['pfad'] . $d_name, 0777);
		}
	}

	echo "<script language=\"javascript\"> \n",
		"<!-- \n",
		"window.opener.parent.frames['zf'].location.href = window.opener.parent.frames['zf'].location.href; \n",
		"window.close(); \n",
		"//--> \n",
		"</script> \n";
	exit();
}

if ($_REQUEST['action']=='delfile')
{
	if (checkPermission('mediapool_del'))
	{
		@copy(UPDIR . $_REQUEST['file'], BASE_DIR . '/uploads/recycled/' . $_REQUEST['df'] );
		if (@unlink(UPDIR . $_REQUEST['file']))
		{
			$error = 0;
			reportLog($_SESSION['user_name'] . ' - удалил изображение (' . $_REQUEST['file']  . ')', 2, 2);

			$img_path = $_REQUEST['file'];
			$namepos = strrpos($img_path, '/');
			if ($namepos > 0)
			{
				$img_name = substr($img_path, ++$namepos);
				$img_dir  = substr($img_path, 0, $namepos);
				if (substr($img_path, 0, 1) != '/')
				{
					$img_dir = '/' . $img_dir;
				}
			}
			else
			{
				$img_name = substr($img_path, 1);
				$img_dir  = '/';
			}
			@unlink(UPDIR . $img_dir . $th_pref . $img_name);

			$_REQUEST['file'] = '';
			$_REQUEST['action'] = '';
			echo "<script language=\"javascript\"> \n",
				"<!-- \n",
				"parent.frames['zf'].location.href=\"browser.php?typ=", $_REQUEST['typ'], "&dir=", $_REQUEST['dir'], "&cpengine=", SESSION, "&done=1\"; \n",
				"--> \n",
				"</script> \n";
		}
	}
	else
	{
		echo "<script language=\"javascript\"> \n",
			"<!-- \n",
			"parent.frames['zf'].location.href=\"browser.php?typ=", $_REQUEST['typ'], "&dir=", $_REQUEST['dir'], "&cpengine=", SESSION, "&done=1\"; \n",
			"--> \n",
			"</script> \n";
	}
	$_REQUEST['action'] = 'list';
}

$_REQUEST['done'] = (isset($_REQUEST['done']) && $_REQUEST['done']==1) ? 1 : '';
$dir = (isset($_REQUEST['dir']) && $_REQUEST['dir'] != '') ? $_REQUEST['dir'] : '';
$dir = (strpos($dir, '//')!==false || substr($dir, 0, 4)=='/../' ) ? '' : $dir;

if ($_REQUEST['action']=='list' || $_REQUEST['done']==1)
{
	if (substr($dir, -4) == '/../')
	{
		$dir = explode('/', substr($dir, 0, -4));
		array_pop($dir);
		$dir = implode('/', $dir);
		$dir = rtrim($dir, '/') . '/';
	}

	if (!($dir=='/'))
	{
		$AVE_Template->assign('dir', $dir);
		$AVE_Template->assign('dirup', 1);
	}

	$resuld = @mkdir(UPDIR . $mediapath. '' . $dir . $_REQUEST['newdir']);
	$d = @dir(UPDIR . $mediapath. '' . $dir);

	while (false !== ($entry = @$d->read()))
	{
		if ($entry != '.' &&
			$entry != '..' &&
			$entry != '.svn' &&
			$entry != 'index.php' &&
			$entry != 'thumbnail' &&
			substr($entry, 0, strlen($th_pref)) != $th_pref)
		{
			if (is_dir(UPDIR . $mediapath. '' . $dir . $entry))
			{
				$elem['dir'][] = $entry;
			}
			else
			{
				$elem['file'][] = $entry;
			}
		}
	}
	$d->close();

	@asort($elem['dir']);
	$bfiles = array();
	while (list($key, $val) = @each($elem['dir']))
	{
		unset($row);
		$row->fileopen = $_REQUEST['typ'] . "&amp;cpengine=" . SESSION . "&amp;dir=" . $dir . $val . "/&amp;action=list";
		$row->val = $val;
		array_push($bfiles, $row);
	}

	@asort($elem['file']);
	$unable_delete = 0;
	$dats = array();
	while (list($key, $val) = @each($elem['file']))
	{
		unset($row);
		$endg = strtolower(substr($val, strlen($val) - 3));
		$endg_r = strtolower(substr($val, strlen($val) - 4));
		$end = $endg;

		$file_allowed = array(
			'.swf', '.fla', '.rar', '.zip', '.pdf', '.exe', '.avi',
			'.mov', 'r.gz', '.doc', '.wmf', '.wmv', '.mp3', '.mp4',
			'.mpg', '.tif', '.psd', '.txt', '.xls', '.pps'
		);
		$allowed_images =  array('.jpg', 'jpeg', '.png', '.gif');

		if (isset($_REQUEST['target']) && $_REQUEST['target']=='link')
		{
			$allowed = $file_allowed;
		}

		$val_allowed = substr($val, -4);

		$row->gifends = (file_exists($tpl_dir . '/images/mediapool/' . $endg . '.gif')) ? $endg : 'attach';
		$row->gifend = $row->gifends;
		$row->datsize = @round(@filesize('../uploads' . $dir . $val)/1024, 2);
		$row->val = $val;
		$row->moddate = date("d.m.y, H:i", @filemtime('../uploads' . $dir . $val));
		$row->rowval = $dir . $val;

		if (in_array($val_allowed,$allowed_images) && function_exists('getimagesize') && function_exists('imagecreatetruecolor'))
		{
			$row->bild = "<img border=\"0\" src=\"browser.php?thumb=1&bild=" . $dir . $val . "\">";
		}

		$unable_delete = (strpos($dir, 'recycled')!==false) ? 1 : 0;
		array_push($dats, $row);
		unset($row);
	}

	$AVE_Template->assign('unable_delete', $unable_delete);
	$AVE_Template->assign('dats', $dats);
	$AVE_Template->assign('bfiles', $bfiles);
	$AVE_Template->assign('dir', $dir);

	$_REQUEST['newdir'] = (isset($_REQUEST['newdir'])) ? $_REQUEST['newdir'] : '';
	if (!empty($_REQUEST['newdir']))
	{
		if ($resuld)
		{
			$oldumask = umask(0);
			chmod(UPDIR . $dir . $_REQUEST['newdir'], 0777);
			umask($oldumask);
		}
		else
		{
			echo "<script language=\"JavaScript\" type=\"text/javascript\"> \n",
			"alert(\"Ошибка! Невозможно создать директорию на сервере. Пожалуйста, проверьте ваши настройки.\"); \n",
			"</script> \n";
		}
	}

	$AVE_Template->display('browser.tpl');

}
else
{
	$self = substr($_SERVER['PHP_SELF'], 0, -18);

	$sub_target = @explode('__', $_REQUEST['target']);
	if (is_array($sub_target)) $sub = @$sub_target[1];

	$AVE_Template->assign('target_img', $sub_target[0]);
	$AVE_Template->assign('pop_id', $sub);
	$AVE_Template->assign('cppath', !empty($self) ? $self . '/' : '');
	$AVE_Template->display('browser_2frames.tpl');
}

?>