<?php

$cache 	  = true;										// �����������
$cachedir = dirname(__FILE__) . '/cache';				// ���� � ����
$cssdir   = dirname(__FILE__) . '/templates/aohua/css';	// ���� � css ������
$jsdir    = dirname(__FILE__) . '/templates/aohua/js';// ���� � js ������

// ���������� ��� ������, ������ ���� � ������
// � �������� ������ ���� ������
if (!empty($_GET['css']))
{
	$type = 'css';
	$base = realpath($cssdir);
	$hash = md5($_GET['css']);
	$elements = explode(',', $_GET['css']);
}
elseif (!empty($_GET['js']))
{
	$type = 'javascript';
	$base = realpath($jsdir);
	$hash = md5($_GET['js']);
	$elements = explode(',', $_GET['js']);
}
else
{
	header ("HTTP/1.0 503 Not Implemented");
	exit;
}

// ���������� ���� ��������� ����������� ������
$lastmodified = 0;
while (list(,$element) = each($elements))
{
	$path = realpath($base . '/' . $element);

	if (($type == 'javascript' && substr($path, -3) != '.js') ||
		($type == 'css' && substr($path, -4) != '.css'))
	{
		header ("HTTP/1.0 403 Forbidden");
		exit;
	}

	if (substr($path, 0, strlen($base)) != $base || !file_exists($path))
	{
		header ("HTTP/1.0 404 Not Found");
		exit;
	}

	$lastmodified = max($lastmodified, filemtime($path));
}

// ���������� Etag
$hash = $lastmodified . '-' . $hash;
header ("Etag: \"" . $hash . "\"");

if (isset($_SERVER['HTTP_IF_NONE_MATCH']) &&
	stripslashes($_SERVER['HTTP_IF_NONE_MATCH']) == '"' . $hash . '"')
{
	// ��������� ����� � ����� �� ���������� - ������ �� ����������
	header ("HTTP/1.0 304 Not Modified");
	header ('Content-Length: 0');
	exit;
}
else
{
	// ������ ����� ��� ����� ����������
	if ($cache)
	{
		// ���������� ��������� ������ ������
		$gzip = strstr($_SERVER['HTTP_ACCEPT_ENCODING'], 'gzip');
		$deflate = strstr($_SERVER['HTTP_ACCEPT_ENCODING'], 'deflate');

		// ���������� ����� ����� ������������
		$encoding = $gzip ? 'gzip' : ($deflate ? 'deflate' : 'none');

		// ������������ � ������� �������� ��� ������ ������ IE
		if (!strstr($_SERVER['HTTP_USER_AGENT'], 'Opera') &&
			preg_match('/^Mozilla\/4\.0 \(compatible; MSIE ([0-9]\.[0-9])/i', $_SERVER['HTTP_USER_AGENT'], $matches))
		{
			$version = floatval($matches[1]);

			if ($version < 6)
				$encoding = 'none';

			if ($version == 6 && !strstr($_SERVER['HTTP_USER_AGENT'], 'EV1'))
				$encoding = 'none';
		}

		// ��������� ������� ���������������� ����� � ����
		$cachefile = 'cache-' . $hash . '.' . $type . ($encoding != 'none' ? '.' . $encoding : '');

		if (file_exists($cachedir . '/' . $cachefile))
		{
			if ($fp = fopen($cachedir . '/' . $cachefile, 'rb'))
			{
				if ($encoding != 'none')
				{
					header ("Content-Encoding: " . $encoding);
				}

				header ("Content-Type: text/" . $type);
				header ("Content-Length: " . filesize($cachedir . '/' . $cachefile));

				fpassthru($fp);
				fclose($fp);
				exit;
			}
		}
	}

	// ��������� �����
	$contents = '';
	reset($elements);
	while (list(,$element) = each($elements))
	{
		$path = realpath($base . '/' . $element);
		$contents .= "\n\n" . file_get_contents($path);
	}

	// ���������� ��������� Content-Type
	header ("Content-Type: text/" . $type);

	if (isset($encoding) && $encoding != 'none')
	{
		// ������� � ���������� ��������������� ����
		$contents = gzencode($contents, 9, $gzip ? FORCE_GZIP : FORCE_DEFLATE);
		header ("Content-Encoding: " . $encoding);
		header ('Content-Length: ' . strlen($contents));
		echo $contents;
	}
	else
	{
		// ���������� ��������������� ���� ��� ������
		header ('Content-Length: ' . strlen($contents));
		echo $contents;
	}

	// ��������
	if ($cache)
	{
		if ($fp = fopen($cachedir . '/' . $cachefile, 'wb'))
		{
			fwrite($fp, $contents);
			fclose($fp);
		}
	}
}
