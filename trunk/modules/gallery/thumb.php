<?php

/**
 * AVE.cms - Модуль Галерея
 *
 * @package AVE.cms
 * @subpackage module_Gallery
 * @filesource
 */

/**
 * Генератор миниатюр
 *
 */
$width = (isset($_REQUEST['xwidth']) && is_numeric($_REQUEST['xwidth']) &&
	$_REQUEST['xwidth'] > 10 && $_REQUEST['xwidth'] < 500) ? (int)$_REQUEST['xwidth'] : 120;

$type = (empty($_REQUEST['type'])) ? 'jpg' : strtolower($_REQUEST['type']);

switch($type)
{
	case 'gif' :
	case 'jpg' :
	case 'png' :
		$source_file = isset($_REQUEST['file']) ? rawurldecode($_REQUEST['file']) : '';
		$source_file = str_replace(array('..', '\'', ':', 'http', 'ftp', '/', ' '), '', $source_file);

		$source_dir = isset($_REQUEST['folder']) ? rawurldecode($_REQUEST['folder']) : '';
		$source_dir = str_replace(array('..', '\'', ':', 'http', 'ftp', '/', ' '), '', $source_dir);
		$source_dir = dirname(__FILE__) . rtrim('/uploads/' . $source_dir, '/');

		if ($file = realpath($source_dir . '/' . $source_file))
		{
			$thumb_file = $source_dir . '/th__' . $source_file;
			// Если не указано обязательное формирование миниатюр (&compile=1)
			// и есть миниатюра сформированная ранее - выводим её
			if (file_exists($thumb_file) && empty($_REQUEST['compile']))
			{
				$img_data = @getimagesize($file);
				header('Content-Type:' . $img_data['mime'], true);
				readfile($thumb_file);
				exit;
			}
		}
		else
		{
			exit;
		}
		break;

	case 'video' :
		if (! $file = realpath(dirname(__FILE__) . '/uploads/dummy_video.gif'))
		{
			exit;
		}
		break;
}

if (! @include(substr(dirname(__FILE__), 0, -16) . '/class/class.thumbnail.php')) die();

$img = new Image_Toolbox($file);

$img->newOutputSize($width, $width, 1);

$img->output();

if (! empty($thumb_file))
{
	$img->save($thumb_file);
	chmod($thumb_file, 0644);
}

?>