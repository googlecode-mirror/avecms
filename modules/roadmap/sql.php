<?php

$modul_sql_install = array();
$modul_sql_deinstall = array();
$modul_sql_update = array();

$modul_sql_deinstall[] = "DROP TABLE IF EXISTS CPPREFIX_modul_roadmap;";
$modul_sql_deinstall[] = "DROP TABLE IF EXISTS CPPREFIX_modul_roadmap_tasks;";

$modul_sql_install[] = "CREATE TABLE CPPREFIX_modul_roadmap (
  id int(10) unsigned NOT NULL auto_increment,
  project_name varchar(255) NOT NULL default '',
  project_desc text NOT NULL default '',
  project_status tinyint(1) unsigned NOT NULL default '1',
  position varchar(250) NOT NULL default '',
  PRIMARY KEY  (id)
) ENGINE=MyISAM DEFAULT CHARSET=cp1251;";

$modul_sql_install[] = "CREATE TABLE CPPREFIX_modul_roadmap_tasks (
  id int(10) unsigned NOT NULL auto_increment,
  pid varchar(10) NOT NULL default '',
  task_desc text NOT NULL default '',
  date_create varchar(250) NOT NULL default '',
  task_status tinyint(1) unsigned NOT NULL default '0',
  uid varchar(250) NOT NULL default '',
  priority varchar(10) NOT NULL default '',
  PRIMARY KEY  (id)
) ENGINE=MyISAM DEFAULT CHARSET=cp1251;";

$modul_sql_update[] = "UPDATE CPPREFIX_module SET CpEngineTag = '" . $modul['CpEngineTag'] . "', CpPHPTag = '" . $modul['CpPHPTag'] . "', Version = '" . $modul['ModulVersion'] . "' WHERE ModulPfad = '" . $modul['ModulPfad'] . "' LIMIT 1;";

?>