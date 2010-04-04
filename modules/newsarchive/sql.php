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

$modul_sql_deinstall = array();
$modul_sql_install = array();
$modul_sql_update = array();

$modul_sql_deinstall[] = "DROP TABLE IF EXISTS CPPREFIX_modul_newsarchive;";

$modul_sql_install[] = "CREATE TABLE CPPREFIX_modul_newsarchive (
  id mediumint(5) unsigned NOT NULL auto_increment,
  arc_name varchar(100) NOT NULL default '',
  rubs varchar(255) NOT NULL default '',
  show_days smallint(1) unsigned NOT NULL default '1',
  show_empty smallint(1) unsigned NOT NULL default '1',
  PRIMARY KEY  (id)
) TYPE=MyISAM DEFAULT CHARSET=cp1251;";
?>