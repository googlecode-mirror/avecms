<?php

$modul_sql_update = array();
$modul_sql_deinstall = array();
$modul_sql_install = array();

$modul_sql_update[] = "UPDATE CPPREFIX_module SET Version = '".$modul['ModulVersion']."' WHERE ModulName='".$modul['ModulName']."';";

$modul_sql_deinstall[] = "DROP TABLE CPPREFIX_modul_who_is_online";

$modul_sql_install[] = "CREATE TABLE CPPREFIX_modul_who_is_online (
  `id` int(10) unsigned NOT NULL auto_increment,
  `ip` int(11) NOT NULL default '0',
  `country` char(64) NOT NULL default '',
  `countrycode` char(2) NOT NULL default '',
  `city` char(64) NOT NULL default '',
  `dt` timestamp NOT NULL default CURRENT_TIMESTAMP,
  PRIMARY KEY  (`id`),
  UNIQUE KEY `ip` (`ip`),
  KEY `countrycode` (`countrycode`)
) TYPE=MyISAM DEFAULT CHARSET=cp1251;";

?>