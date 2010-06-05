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

$modul_sql_install = array();
$modul_sql_deinstall = array();
$modul_sql_update = array();

$modul_sql_deinstall[] = "DROP TABLE IF EXISTS CPPREFIX_modul_counter;";
$modul_sql_deinstall[] = "DROP TABLE IF EXISTS CPPREFIX_modul_counter_info;";

$modul_sql_install[] = "CREATE TABLE CPPREFIX_modul_counter (
  `id` smallint(3) unsigned NOT NULL auto_increment,
  `counter_name` char(50) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=cp1251;";

$modul_sql_install[] = "CREATE TABLE CPPREFIX_modul_counter_info (
  `id` int(11) unsigned NOT NULL auto_increment,
  `counter_id` smallint(3) unsigned NOT NULL,
  `client_ip` char(50) NOT NULL,
  `client_os` char(20) NOT NULL,
  `client_browser` char(20) NOT NULL,
  `client_referer` char(255) NOT NULL,
  `visit` int(10) unsigned NOT NULL,
  `expire` int(10) unsigned NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `expire` (`expire`,`counter_id`),
  KEY `counter_id` (`counter_id`)
) ENGINE=MyISAM DEFAULT CHARSET=cp1251;";

$modul_sql_install[] = "INSERT INTO CPPREFIX_modul_counter VALUES (1, 'Основной счетчик');";
$modul_sql_install[] = "INSERT INTO CPPREFIX_modul_counter VALUES (2, 'Дополнительный счетчик');";

$modul_sql_update[] = "UPDATE CPPREFIX_module SET CpEngineTag = '" . $modul['CpEngineTag'] . "', CpPHPTag = '" . $modul['CpPHPTag'] . "', Version = '" . $modul['ModulVersion'] . "' WHERE ModulPfad = '" . $modul['ModulPfad'] . "' LIMIT 1;";
?>