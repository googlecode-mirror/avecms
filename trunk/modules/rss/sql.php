<?php

/**
 * AVE.cms - Модуль RSS
 *
 * @package AVE.cms
 * @subpackage module_RSS
 * @filesource
 */

/**
 * mySQL-запросы для установки, обновления и удаления модуля
 */

$modul_sql_deinstall = array();
$modul_sql_install = array();
$modul_sql_update = array();

$modul_sql_update[] = "UPDATE CPPREFIX_module SET Version = '" . $modul['ModulVersion'] . "' WHERE ModulName = '" . $modul['ModulName'] . "';" ;

$modul_sql_deinstall[] = "DROP TABLE IF EXISTS CPPREFIX_modul_rss;";

$modul_sql_install[] = "CREATE TABLE CPPREFIX_modul_rss (
  id mediumint(5) unsigned NOT NULL auto_increment,
  rss_name varchar(150) NOT NULL default '',
  rss_descr varchar(255) NOT NULL default '',
  site_url varchar(100) NOT NULL default '',
  rub_id mediumint(4) NOT NULL,
  title_id mediumint(4) NOT NULL,
  descr_id mediumint(4) NOT NULL,
  on_page mediumint(4) NOT NULL,
  lenght int(5) unsigned NOT NULL,
  PRIMARY KEY  (id)
) TYPE=MyISAM;";

?>