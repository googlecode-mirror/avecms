<?php

$modul_sql_install = array();
$modul_sql_deinstall = array();
$modul_sql_update = array();

$modul_sql_deinstall[] = "DROP TABLE IF EXISTS CPPREFIX_modul_poll;";
$modul_sql_deinstall[] = "DROP TABLE IF EXISTS CPPREFIX_modul_poll_comments;";
$modul_sql_deinstall[] = "DROP TABLE IF EXISTS CPPREFIX_modul_poll_items;";

$modul_sql_install[] = "CREATE TABLE CPPREFIX_modul_poll (
  id int(10) unsigned NOT NULL auto_increment,
  title varchar(250) NOT NULL default '',
  active tinyint(1) NOT NULL default '1',
  group_id tinytext,
  ip text NOT NULL default '',
  uid text NOT NULL default '',
  can_comment tinyint(1) NOT NULL default '0',
  start int(10) unsigned NOT NULL,
  ende int(10) unsigned NOT NULL,
  PRIMARY KEY  (id)
) TYPE=MyISAM DEFAULT CHARSET=cp1251;";

$modul_sql_install[] = "CREATE TABLE CPPREFIX_modul_poll_comments (
  id int(8) unsigned NOT NULL auto_increment,
  pollid int(8) NOT NULL,
  ctime int(10) unsigned NOT NULL,
  author int(10) NOT NULL,
  title varchar(250) NOT NULL default '',
  comment text NOT NULL default '',
  ip text NOT NULL default '',
  PRIMARY KEY  (id)
) TYPE=MyISAM DEFAULT CHARSET=cp1251;";

$modul_sql_install[] = "CREATE TABLE CPPREFIX_modul_poll_items (
  id int(10) unsigned NOT NULL auto_increment,
  pollid int(8) NOT NULL,
  title varchar(250) NOT NULL default '',
  hits int(10) NOT NULL default '0',
  color varchar(10) NOT NULL default '',
  posi int(2) NOT NULL,
  PRIMARY KEY  (id)
) TYPE=MyISAM DEFAULT CHARSET=cp1251;";

$modul_sql_update[] = "UPDATE CPPREFIX_module SET CpEngineTag = '" . $modul['CpEngineTag'] . "', CpPHPTag = '" . $modul['CpPHPTag'] . "', Version = '" . $modul['ModulVersion'] . "' WHERE ModulPfad = '" . $modul['ModulPfad'] . "' LIMIT 1;";

?>