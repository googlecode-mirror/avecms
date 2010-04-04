<?php
/*::::::::::::::::::::::::::::::::::::::::
 System name: cpengine
 Short Desc: Full Russian Security Power Pack
 Version: 2.0 (Service Pack 1)
 Authors:  Arcanum (php@211.ru) &  Censored!
 Date: February 22, 2008
::::::::::::::::::::::::::::::::::::::::*/

/*::::::::::::::::::::::::::::::::::::::::
 Module name: Faq
 Short Desc: Frequrent Answer and Questions
 Version: 1.0 alpha
 Authors:  Freeon (php_demon@mail.ru)
 Date: april 5, 2008
::::::::::::::::::::::::::::::::::::::::*/

$modul_sql_deinstall = array();
$modul_sql_install = array();

$modul_sql_deinstall[] = "DROP TABLE IF EXISTS CPPREFIX_modul_faq;";
$modul_sql_deinstall[] = "DROP TABLE IF EXISTS CPPREFIX_modul_faq_quest;";

$modul_sql_install[] = "CREATE TABLE CPPREFIX_modul_faq (
  id mediumint(5) unsigned NOT NULL auto_increment,
  faq_name varchar(100) NOT NULL default '',
  description varchar(255) NOT NULL default '',
  PRIMARY KEY  (id)
) TYPE=MyISAM DEFAULT CHARSET=cp1251;";

$modul_sql_install[] = "CREATE TABLE CPPREFIX_modul_faq_quest (
  id mediumint(5) unsigned NOT NULL auto_increment,
  quest text NOT NULL default '',
  answer text NOT NULL default '',
  parent mediumint(5) NOT NULL default '1',
  PRIMARY KEY  (id)
) TYPE=MyISAM DEFAULT CHARSET=cp1251;";
?>