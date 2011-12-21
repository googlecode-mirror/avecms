<?php

$width = (isset($_REQUEST['xwidth']) && is_numeric($_REQUEST['xwidth'])
	&& $_REQUEST['xwidth'] > 10 && $_REQUEST['xwidth'] < 500)
		? $_REQUEST['xwidth']
		: 80;

$max = (isset($_REQUEST['max']) && is_numeric($_REQUEST['max'])
	&& $_REQUEST['max'] > 10 && $_REQUEST['max'] < 500)
		? $_REQUEST['max']
		: false;

$type = (!empty($_REQUEST['type'])) ? $_REQUEST['type'] : 'jpg';

$file_name = (!empty($_REQUEST['file'])) ? $_REQUEST['file'] : '';
$file_name = str_replace(array('..','\'',':','http','ftp','/'), '', $file_name);

$image_dir = dirname(__FILE__) . '/uploads/';
$thumb_dir = dirname(__FILE__) . '/thumbnails/';

if(!file_exists($image_dir . $file_name))
{
	header("Content-Type:image/gif", true);
	readfile($image_dir . 'noimage.gif');
	exit;
}

switch($type)
{
	case 'jpg' :
		$src_image = imagecreatefromjpeg($image_dir . $file_name);
		$header = "image/jpeg";
		break;

	case 'png' :
		if(function_exists("imagecreatefrompng"))
		{
			$src_image = imagecreatefrompng($image_dir . $file_name);
			$header = "image/png";
		}
		else
		{
			header("Content-Type:image/png", true);
			readfile($thumb_dir . $file_name);
			exit;
		}
		break;

	case 'gif' :
		if(function_exists("imagecreatefromgif"))
		{
			$src_image = imagecreatefromgif($image_dir . $file_name);
			$header = "image/gif";
		}
		else
		{
			header("Content-Type:image/gif", true);
			readfile($thumb_dir . $file_name);
			exit;
		}
		break;
}

$src_width = imagesx($src_image);
$src_height = imagesy($src_image);

if ($max !== false)
{
	if ($src_width > $src_height)
	{
		$thumb_width = $max;
		$thumb_height = round(($src_height/$src_width) * $thumb_width);
	}
	else
	{
		$thumb_height = $max;
		$thumb_width = round(($src_width/$src_height) * $thumb_height);
	}

	$thumb = imagecreatetruecolor($max, $max);

	switch ($type)
	{
		case 'jpg':
			$bg = (!empty($_REQUEST['bg'])
				&& preg_match('/[a-f\d]{6}/i', $_REQUEST['bg']))
					? $_REQUEST['bg']
					: 'FFFFFF';

			imagefill(
				$thumb,
				0, 0,
				imagecolorallocate(
					$thumb,
					hexdec(mb_substr($bg, -6, 2)),
					hexdec(mb_substr($bg, -4, 2)),
					hexdec(mb_substr($bg, -2))
				)
			);
			break;

		case 'gif':
		case 'png':
			imagecolortransparent($thumb, imagecolorallocate($thumb, 0, 0, 0));
			break;
	}
}
else
{
	$thumb_width = $width;
	$thumb_height = round(($src_height/$src_width) * $thumb_width);

	$thumb = imagecreatetruecolor($thumb_width, $thumb_height);
}

$thumb_file = "shopthumb__" . $thumb_width . "__" . $file_name;

if (file_exists($thumb_dir . $thumb_file)
	&& !(isset($_REQUEST['compile']) && $_REQUEST['compile'] == 1))
{
	header("Content-Type:$header", true);
	readfile($thumb_dir . $thumb_file);
	exit;
}

imagecopyresampled(
	$thumb, $src_image,
	$max?round(($max-$thumb_width)/2):0, $max?round(($max-$thumb_height)/2):0,
	0, 0,
	$thumb_width, $thumb_height,
	$src_width, $src_height
);

header($_SERVER['SERVER_PROTOCOL'] . " 200 OK", true);
header("Date: " . gmdate("D, d M Y H:i:s") . ' GMT', true);
header("Content-Type:$header", true);

ob_start();
switch($type)
{
	case 'gif': imagegif($thumb); break;
	case 'jpg': imagejpeg($thumb, '', 60); break;
	case 'png': imagepng($thumb, '', 6); break;
}
$thumbnail = ob_get_contents();
ob_end_clean();

echo $thumbnail;

$fp = fopen($thumb_dir . $thumb_file, "wb+");
fwrite($fp, $thumbnail);
fclose($fp);
chmod($thumb_dir . $thumb_file, 0644);

imagedestroy($src_image);
imagedestroy($thumb);

?>