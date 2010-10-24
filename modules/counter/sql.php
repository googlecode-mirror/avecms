<?php

/**
 * AVE.cms - ������ ����������
 *
 * ������ ���� �������� ������ ������ "����������" � �������� mySQL-�������
 * � ���� ������ ��� �������� ���������, ���������� � �������� ������ ����� ������ ����������.
 *
 * @package AVE.cms
 * @subpackage module_Counter
 * @since 1.4
 * @filesource
 */

$modul_sql_install = array();
$modul_sql_deinstall = array();
$modul_sql_update = array();

$modul_sql_deinstall[] = "DROP TABLE IF EXISTS CPPREFIX_modul_counter;";
$modul_sql_deinstall[] = "DROP TABLE IF EXISTS CPPREFIX_modul_counter_info;";

$modul_sql_install[] = "CREATE TABLE CPPREFIX_modul_counter (
  `id` smallint(3) unsigned NOT NULL auto_increment,
  `counter_title` char(50) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=cp1251;";

$modul_sql_install[] = "CREATE TABLE CPPREFIX_modul_counter_info (
  `id` int(11) unsigned NOT NULL auto_increment,
  `counter_id` smallint(3) unsigned NOT NULL,
  `counter_client_ip` char(50) NOT NULL,
  `counter_client_os` char(20) NOT NULL,
  `counter_client_browser` char(20) NOT NULL,
  `counter_client_referer` char(255) NOT NULL,
  `counter_visit_time` int(10) unsigned NOT NULL,
  `counter_expire_time` int(10) unsigned NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `counter_expire_time` (`counter_expire_time`, `counter_id`),
  KEY `counter_id` (`counter_id`)
) ENGINE=MyISAM DEFAULT CHARSET=cp1251;";

$modul_sql_install[] = "INSERT INTO CPPREFIX_modul_counter VALUES (1, '�������� �������');";
$modul_sql_install[] = "INSERT INTO CPPREFIX_modul_counter VALUES (2, '�������������� �������');";

$modul_sql_update[] = "UPDATE CPPREFIX_module SET CpEngineTag = '" . $modul['CpEngineTag'] . "', CpPHPTag = '" . $modul['CpPHPTag'] . "', Version = '" . $modul['ModulVersion'] . "' WHERE ModulPfad = '" . $modul['ModulPfad'] . "' LIMIT 1;";
?>