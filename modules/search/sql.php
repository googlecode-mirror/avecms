<?php
/*::::::::::::::::::::::::::::::::::::::::
 System name: cpengine
 Short Desc: Full Russian Security Power Pack
 Version: 2.0 (Service Pack 2)
 Authors:  Arcanum (php@211.ru) &  Censored!
 Date: March 18, 2008
::::::::::::::::::::::::::::::::::::::::*/

$modul_sql_deinstall = array();
$modul_sql_install = array();

$modul_sql_deinstall[] = "DROP TABLE IF EXISTS CPPREFIX_modul_search;";
$modul_sql_install[] = "DROP TABLE IF EXISTS CPPREFIX_modul_search;";
$modul_sql_install[] = "CREATE TABLE CPPREFIX_modul_search (
  Id int(10) unsigned NOT NULL auto_increment,
  Suchbegriff varchar(255) NOT NULL default '',
  Anzahl mediumint(5) unsigned NOT NULL default '0',
  Gefunden mediumint(5) unsigned NOT NULL default '0',
  PRIMARY KEY  (Id)
) TYPE=MyISAM DEFAULT CHARSET=cp1251;";
?>