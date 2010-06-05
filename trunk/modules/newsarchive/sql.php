<?php

/**
 * AVE.cms - Модуль Архив новостей
 *
 * @package AVE.cms
 * @subpackage module_Newsarchive
 * @filesource
 */

/**
 * mySQL-запросы для установки, обновления и удаления модуля
 */

$modul_sql_install = array();
$modul_sql_deinstall = array();
$modul_sql_update = array();

$modul_sql_deinstall[] = "DROP TABLE IF EXISTS CPPREFIX_modul_newsarchive;";

$modul_sql_install[] = "CREATE TABLE CPPREFIX_modul_newsarchive (
  `id` mediumint(5) unsigned NOT NULL auto_increment,
  `newsarchive_name` char(255) NOT NULL default '',
  `newsarchive_rubrics` char(255) NOT NULL default '',
  `newsarchive_show_days` enum('1','0') NOT NULL default '1',
  `newsarchive_show_empty` enum('1','0') NOT NULL default '1',
  PRIMARY KEY  (`id`)
) TYPE=MyISAM DEFAULT CHARSET=cp1251;";

$modul_sql_update[] = "UPDATE CPPREFIX_module SET CpEngineTag = '" . $modul['CpEngineTag'] . "', CpPHPTag = '" . $modul['CpPHPTag'] . "', Version = '" . $modul['ModulVersion'] . "' WHERE ModulPfad = '" . $modul['ModulPfad'] . "' LIMIT 1;";

?>