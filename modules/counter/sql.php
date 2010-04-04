<?php

/**
 * AVE.cms - Модуль Статистика
 *
 * @package AVE.cms
 * @subpackage module_Counter
 * @filesource
 */

/**
 * mySQL-запросы для установки, обновления и удаления модуля
 */

$modul_sql_deinstall = array();
$modul_sql_install = array();
$modul_sql_update = array();

$modul_sql_deinstall[] = "DROP TABLE IF EXISTS CPPREFIX_modul_counter;";
$modul_sql_deinstall[] = "DROP TABLE IF EXISTS CPPREFIX_modul_counter_info;";

$modul_sql_install[] = "CREATE TABLE CPPREFIX_modul_counter (
  id int(10) UNSIGNED NOT NULL auto_increment,
  counter_name varchar(50) default NULL,
  PRIMARY KEY  (id)
) TYPE=MyISAM DEFAULT CHARSET=cp1251;";

$modul_sql_install[] = "CREATE TABLE CPPREFIX_modul_counter_info (
  id int(11) UNSIGNED NOT NULL auto_increment,
  counter_id int(11) UNSIGNED NOT NULL,
  client_ip varchar(50) default NULL,
  client_os varchar(20) default NULL,
  client_browser varchar(20) default NULL,
  client_referer varchar(255) default NULL,
  visit int(10) UNSIGNED NOT NULL,
  expire int(10) UNSIGNED NOT NULL,
  PRIMARY KEY  (id)
) TYPE=MyISAM DEFAULT CHARSET=cp1251;";

$modul_sql_install[] = "INSERT INTO CPPREFIX_modul_counter VALUES (1, 'Основной счетчик');";
$modul_sql_install[] = "INSERT INTO CPPREFIX_modul_counter VALUES (2, 'Дополнительный счетчик');";

$modul_sql_update[] = "UPDATE CPPREFIX_module SET CpEngineTag = '" . $modul['CpEngineTag'] . "', CpPHPTag = '" . $modul['CpPHPTag'] . "', Version = '" . $modul['ModulVersion'] . "' WHERE ModulName = '" . $modul['ModulName'] . "' LIMIT 1;";

?>