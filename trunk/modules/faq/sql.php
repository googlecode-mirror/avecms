<?php

$modul_sql_install = array();
$modul_sql_deinstall = array();
$modul_sql_update = array();

$modul_sql_deinstall[] = "DROP TABLE IF EXISTS CPPREFIX_modul_faq;";
$modul_sql_deinstall[] = "DROP TABLE IF EXISTS CPPREFIX_modul_faq_quest;";

$modul_sql_install[] = "CREATE TABLE CPPREFIX_modul_faq (
  `id` mediumint(5) unsigned NOT NULL auto_increment,
  `faq_title` char(100) NOT NULL default '',
  `faq_description` char(255) NOT NULL default '',
  PRIMARY KEY  (`id`)
) TYPE=MyISAM DEFAULT CHARSET=cp1251;";

$modul_sql_install[] = "CREATE TABLE CPPREFIX_modul_faq_quest (
  `id` mediumint(5) unsigned NOT NULL auto_increment,
  `faq_id` mediumint(5) unsigned NOT NULL default '1',
  `faq_quest` text NOT NULL,
  `faq_answer` text NOT NULL,
  PRIMARY KEY  (`id`)
) TYPE=MyISAM DEFAULT CHARSET=cp1251;";

$modul_sql_update[] = "UPDATE CPPREFIX_module SET CpEngineTag = '" . $modul['CpEngineTag'] . "', CpPHPTag = '" . $modul['CpPHPTag'] . "', Version = '" . $modul['ModulVersion'] . "' WHERE ModulPfad = '" . $modul['ModulPfad'] . "' LIMIT 1;";

?>