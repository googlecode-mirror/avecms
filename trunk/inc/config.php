<?php

/**
 * AVE.cms
 *
 * @package AVE.cms
 * @filesource
 */

$config['mod_rewrite']                = '1';          // {1|0} ���
$config['url_suff']                   = '.html';      // ������ ���
$config['default_theme_folder']       = 'ave';        // ���� ��������� �����
$config['default_admin_theme_folder'] = 'apanel';     // ���� ������ ��������������
$config['default_language']           = 'ru';         // ���� �� ���������
$config['session_save_handler']       = true;         // ������� ������ � ��
$config['session_lifetime']           = 60*24;        // ����� ����� ������ (�������� �� ��������� 24 ������)
$config['cookie_lifetime']            = 60*60*24*14;  // ����� ����� cookie ���������� (60*60*24*14 - 2 ������)
$config['sql_debug']                  = false;        // {true|false} ����� ���������� � ������ ���������� ��������
$config['sql_error']                  = false;        // {true|false} �������� ����� � �������� MySQL
$config['compile_check']              = false;        // {true|false} �������������� ��������� tpl ������ (����� ��������� ����� ���������� - false)
$config['debugging']                  = false;        // {true|false} ������� ������� Smarty
$config['cache_doc_tpl']              = false;        // {true|false} ����������� ���������������� �������� ����������
$config['cache_lifetime']             = 60*60*24;     // ����� ����� ���� (60*60*24 - 1 �����)
$config['cookie_domain']              = '.ave209.ru'; // ��� ������ ������������ ��� cookie

?>