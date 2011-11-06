<?php

/**
 * AVE.cms
 *
 * @package AVE.cms
 * @filesource
 */

// ���
define('REWRITE_MODE', true);

// �������������� ���
define('TRANSLIT_URL', true);

// ������ ���
define('URL_SUFF', '/');

// ���� ��������� �����
define('DEFAULT_THEME_FOLDER', 'ave');

// ���� ������ ��������������
define('DEFAULT_ADMIN_THEME_FOLDER', 'apanel');

// ���� �� ���������
define('DEFAULT_LANGUAGE', 'ru');

// ������� ������ � ��
define('SESSION_SAVE_HANDLER', true);

// ����� ����� ������ (�������� �� ��������� 24 ������)
define('SESSION_LIFETIME', 60*24);

// ����� ����� cookie ���������� (60*60*24*14 - 2 ������)
define('COOKIE_LIFETIME', 60*60*24*14);

// {true|false} ����� ���������� � ������ ���������� ��������
define('PROFILING', false);

// {true|false} �������� ����� � �������� MySQL
define('SEND_SQL_ERROR', false);

// {true|false} �������������� ��������� tpl ������ (����� ��������� ����� ���������� - false)
define('SMARTY_COMPILE_CHECK', true);

// {true|false} ������� ������� Smarty
define('SMARTY_DEBUGGING', false);

// {true|false} ���������� ��� � false ���� ���� ��������� PHP
// �� ��������� �������� ���������� �� ����� Smarty.
// ������������� ����� ����������, ��� ��� ����������� ��, ���� ������.
define('SMARTY_USE_SUB_DIRS', false);

// {true|false} ����������� ���������������� �������� ����������
define('CACHE_DOC_TPL', false);

// ����� ����� ���� (60*60*24 = 1 �����)
define('CACHE_LIFETIME', 60*60*24*0);

// ��� ������ ������������ ��� cookie
//define('COOKIE_DOMAIN', '.ave209.ru');

//Yandex MAP API REY
define('YANDEX_MAP_API_KEY', '');

//GOOGLE MAP API REY
define('GOOGLE_MAP_API_KEY', '');

define('APP_NAME', 'AVE.cms');
define('APP_VERSION', '2.09RC1');
define('APP_INFO', APP_NAME . ' ' . APP_VERSION . ' &copy; 2008-2010 <a target="_blank" href="http://www.overdoze.ru/">Overdoze.Ru</a>');

?>