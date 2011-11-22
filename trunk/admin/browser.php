<?php

/**
 * AVE.cms
 *
 * @package AVE.cms
 * @subpackage admin
 * @filesource
 */

@date_default_timezone_set('Europe/Moscow');

ob_start();

define('BASE_DIR', str_replace("\\", "/", dirname(dirname(__FILE__))));

define('MEDIAPATH', 'uploads');
$max_size = 128; // максимальный размер миниатюры
define('TH_PREF', 'thumbnail/th_' . $max_size . '_'); // префикс миниатюр

define('UPDIR', BASE_DIR . '/' . MEDIAPATH);

if (isset($_REQUEST['thumb']) && $_REQUEST['thumb']==1)
{
	$img_path = str_replace(array('../', './', '..', '\'', '//'), '', $_REQUEST['bild']);
	$img_path = '/' . ltrim($img_path, '/');
	$img_dir  = rtrim(dirname($img_path), '/') . '/';
	$img_name = basename($img_path);

	require(BASE_DIR . '/class/class.thumbnail.php');

	$img = new Image_Toolbox(UPDIR . $img_path);

	$img->newOutputSize($max_size, $max_size, 2, false, '#EFF3EB');
//	$img->newOutputSize($max_size, $max_size, 2, false, '#FFFFFF');

	$img->output();

	// Проверяем наличие папки для миниатюр и если её нет - создаём
	if (! file_exists(UPDIR . $img_dir . '/thumbnail'))
	{
		$oldumask = umask(0);
		@mkdir(UPDIR . $img_dir . '/thumbnail', 0777);
		umask($oldumask);
	}

	$img->save(UPDIR . $img_dir . TH_PREF . $img_name);
    $oldumask = umask(0);
	chmod(UPDIR . $img_dir . TH_PREF . $img_name, 0644);
    umask($oldumask);

    exit;
}

require(BASE_DIR . '/inc/init.php');

if (!isset($_SESSION['user_id']))
{
	header('Location:index.php');

	exit;
}

define('ACP', 1);
define('SESSION', session_id());

$tpl_dir = 'templates/' . (empty($_SESSION['admin_theme']) ? DEFAULT_ADMIN_THEME_FOLDER : $_SESSION['admin_theme']);

$AVE_Template = new AVE_Template($tpl_dir . '/browser');

$AVE_Template->assign('tpl_dir', $tpl_dir);
$AVE_Template->assign('sess', SESSION);

$AVE_Template->config_load(BASE_DIR . '/admin/lang/' . (empty($_SESSION['admin_language']) ? $_SESSION['user_language'] : $_SESSION['admin_language']) . '/main.txt');

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
		$d_name = strtolower(trim($_FILES['upfile']['name'][$i]));
		$d_name = str_replace(' ', '', $d_name);
		$d_tmp = $_FILES['upfile']['tmp_name'][$i];

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

			reportLog($_SESSION['user_name'] . ' - загрузил изображение в ('. stripslashes($_REQUEST['pfad']) . $d_name. ')', 2, 2);

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

	exit;
}

if ($_REQUEST['action']=='delfile')
{
	if (check_permission('mediapool_del'))
	{
		@copy(UPDIR . $_REQUEST['file'], BASE_DIR . '/' . MEDIAPATH . '/recycled/' . $_REQUEST['df'] );
		if (@unlink(UPDIR . $_REQUEST['file']))
		{
			$error = 0;
			reportLog($_SESSION['user_name'] . ' - удалил изображение (' . stripslashes($_REQUEST['file'])  . ')', 2, 2);

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
			@unlink(UPDIR . $img_dir . TH_PREF . $img_name);

			$_REQUEST['file'] = '';
			$_REQUEST['action'] = '';
		}
	}

	echo "<script language=\"javascript\"> \n",
		"<!-- \n",
		"parent.frames['zf'].location.href=\"browser.php?typ=", $_REQUEST['typ'], "&dir=", $_REQUEST['dir'], "&cpengine=", SESSION, "&done=1\"; \n",
		"--> \n",
		"</script> \n";

	$_REQUEST['action'] = 'list';
}

$_REQUEST['done'] = (isset($_REQUEST['done']) && $_REQUEST['done']==1) ? 1 : '';
$dir = (!empty($_REQUEST['dir'])) ? $_REQUEST['dir'] : '';
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

	$current_dir = UPDIR . $dir;
	$new_dir = $current_dir . (isset($_REQUEST['newdir']) ? $_REQUEST['newdir'] : '');
	$new_dir_created = file_exists($new_dir) ? 0 : @mkdir($new_dir, 0777);
	$d = @dir($current_dir);
	$elem = array('dir'=>array(), 'file'=>array());
	while (false !== ($entry = @$d->read()))
	{
		if (substr($entry, 0, 1) == '.' || $entry == 'thumbnail' || $entry == 'index.php') continue;

		if (is_dir($current_dir . $entry))
		{
			$elem['dir'][] = $entry;
		}
		else
		{
			$elem['file'][] = $entry;
		}
	}
	$d->close();

	asort($elem['dir']);
	$bfiles = array();
	while (list($key, $dir_name) = each($elem['dir']))
	{
		$row = new stdClass();
		$row->fileopen = $_REQUEST['typ'] . "&amp;cpengine=" . SESSION . "&amp;dir=" . $dir . $dir_name . "/&amp;action=list";
		$row->val = $dir_name;
		array_push($bfiles, $row);
	}

	$allowed_images =  array('.jpg', 'jpeg', '.png', '.gif');
	asort($elem['file']);
	$unable_delete = 0;
	$dats = array();
	while (list($key, $file_name) = each($elem['file']))
	{
		$file_type = strtolower(substr($file_name, strlen($file_name) - 3));

		$row = new stdClass();
		$row->gifend = (file_exists($tpl_dir . '/images/mediapool/' . $file_type . '.gif')) ? $file_type : 'attach';
		$row->datsize = @round(@filesize($current_dir . $file_name)/1024, 2);
		$row->val = $file_name;
		$row->moddate = date("d.m.y, H:i", @filemtime($current_dir . $file_name));

//		if (in_array(substr($file_name, -4), $allowed_images) && function_exists('getimagesize') && function_exists('imagecreatetruecolor'))
		if (in_array(substr($file_name, -4), $allowed_images))
		{
			if (file_exists($current_dir . TH_PREF . $file_name))
			{
				$row->bild = "<img border=\"0\" src=\"../" . MEDIAPATH . $dir . TH_PREF . $file_name . "\">";
			}
			else
			{
				$row->bild = "<img border=\"0\" src=\"browser.php?thumb=1&bild=" . $dir . $file_name . "\">";
			}
		}

		$unable_delete = (strpos($dir, 'recycled')!==false) ? 1 : 0;
		array_push($dats, $row);
	}

	if (!empty($_REQUEST['newdir']) && !$new_dir_created && !file_exists($new_dir))
	{
		echo '<script>alert("Ошибка! Невозможно создать директорию на сервере. Пожалуйста, проверьте ваши настройки.");</script>';
	}

	$AVE_Template->assign('unable_delete', $unable_delete);
	$AVE_Template->assign('dats', $dats);
	$AVE_Template->assign('bfiles', $bfiles);
	$AVE_Template->assign('dir', $dir);
	$AVE_Template->assign('dirup', ($dir != '/') ? 1 : 0);
	$AVE_Template->assign('mediapath', MEDIAPATH);

	$AVE_Template->display('browser.tpl');

	exit;
}

$sub_target = @explode('__', $_REQUEST['target']);
if (is_array($sub_target)) $sub = @$sub_target[1];

$AVE_Template->assign('target_img', $sub_target[0]);
$AVE_Template->assign('pop_id', $sub);
$AVE_Template->assign('cppath', substr($_SERVER['PHP_SELF'], 0, -18));
$AVE_Template->assign('mediapath', MEDIAPATH);

$AVE_Template->display('browser_2frames.tpl');

?>