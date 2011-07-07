<?php

/**
 * AVE.cms
 *
 * ������� � �������� ��������� ����������� � ��������� ���������.
 * ��� ������ ������� ����������� ��������� � ������������ �� ����
 * ��� ������ ������� ��������� ��� ����������� ��������.
 * <pre>
 * �������������:
 * ����� ��������� ������� 120px � ���������������� �������
 * index.php?thumb=����_�_�����������_�� �����_�����
 *
 * ����� ��������� ������� 200px � ���������������� �������
 * index.php?thumb=����_�_�����������_�� �����_�����&width=200
 *
 * ����� ��������� ������� 200px � ���������������� �������
 * index.php?thumb=����_�_�����������_�� �����_�����&height=200
 *
 * ����� ��������� ������� 200px � ������� 150px
 * index.php?thumb=����_�_�����������_�� �����_�����&width=200&height=150
 * </pre>
 * @package AVE.cms
 * @filesource
 */

if (!defined('BASE_DIR')) exit;

// ���� ������ �� � ��������� �� 10 �� 600 (�� ��� ����� ����� ���������) ������������� = 0
$height = (isset($_REQUEST['height']) && is_numeric($_REQUEST['height']) &&
		$_REQUEST['height'] > 10 && $_REQUEST['height'] <= 600) ? (int)$_REQUEST['height'] : 0;

// ���� ������ �� � ��������� �� 10 �� 800 (�� ��� ����� ����� ���������) ������������� = 0 ��� 120 ���� ������ = 0
$width = (isset($_REQUEST['width']) && is_numeric($_REQUEST['width']) &&
		$_REQUEST['width'] > 10 && $_REQUEST['width'] <= 800) ? (int)$_REQUEST['width'] : (0 == $height ? 120 : 0);

// ������� ������������ ������� � ������� ����
if (! empty($_REQUEST['thumb'])) $filename = ltrim(preg_replace('/[^\x20-\xFF]/', '', $_REQUEST['thumb']), '/');

// ��������� ������ ���� � ��������� �����������
$file = BASE_DIR . '/' . ltrim($filename, '/');

// ��������� ������� �����������
if (! empty($filename) && file_exists($file))
{
	$filename = basename($file);
	$file_dir = dirname($file);

	// ��������� ���� � ��������� � ������ ���� ��� ��������� ������ ��������� � ����� thumbnail,
	// � ��� ����� ��������� �������� ������� ��������� (��� �������� �������� � ������� ���������)
	$thumb_file = $file_dir . '/thumbnail/th'
		. ($width ? '-w' . $width : '') . ($height ? '-h' . $height : '') . '-' . $filename;

	// ��������� ������� ��������� � ������� ���������
	if (file_exists($thumb_file))
	{
		$img_data = @getimagesize($file);
		header('Content-Type:' . $img_data['mime'], true);
		readfile($thumb_file);
		exit;
	}

	// ��������� ������� ����� ��� �������� � ���� � ��� - ������
	if (! file_exists($file_dir . '/thumbnail'))
	{
		$oldumask = umask(0);
		@mkdir($file_dir . '/thumbnail', 0777);
		umask($oldumask);
	}
}
elseif (! $file = realpath(BASE_DIR . '/uploads/images/noimage.gif'))
{
	exit;
}

define('IMAGE_TOOLBOX_DEFAULT_JPEG_QUALITY', 75);

require(BASE_DIR . '/class/class.thumbnail.php');

$img = new Image_Toolbox($file);

$img->newOutputSize($width, $height, 1, false);

//$img->addText('AVE.cms 2.09', BASE_DIR . '/inc/fonts/ft16.ttf', 16, '#709536', 'right -10', 'bottom -10');

$img->output();

if (! empty($thumb_file))
{
	$img->save($thumb_file);
    $oldumask = umask(0);
	chmod($thumb_file, 0644);
    umask($oldumask);
}

?>