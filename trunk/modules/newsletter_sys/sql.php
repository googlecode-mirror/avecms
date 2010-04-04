<?php
/*::::::::::::::::::::::::::::::::::::::::
 System name: cpengine
 Short Desc: Full Russian Security Power Pack
 Version: 2.0 (Service Pack 2)
 Authors:  Arcanum (php@211.ru) &  Censored!
 Date: March 18, 2008
::::::::::::::::::::::::::::::::::::::::*/

$modul_sql_update = array();
$modul_sql_deinstall = array();
$modul_sql_install = array();

$modul_sql_update[] = "UPDATE CPPREFIX_module SET Version = '".$modul['ModulVersion']."' WHERE ModulName='".$modul['ModulName']."';";

$modul_sql_deinstall[] = "DROP TABLE CPPREFIX_modul_newsletter_sys";

$modul_sql_install[] = "CREATE TABLE CPPREFIX_modul_newsletter_sys (
  id int(10) unsigned NOT NULL auto_increment,
  sender varchar(255) NOT NULL default '',
  send_date int(14) unsigned default NULL,
  format enum('text','html') NOT NULL default 'text',
  title varchar(255) NOT NULL default '',
  message text NOT NULL,
  groups text NOT NULL,
  attach tinytext NOT NULL,
  PRIMARY KEY  (id)
) TYPE=MyISAM DEFAULT CHARSET=cp1251;";
?>