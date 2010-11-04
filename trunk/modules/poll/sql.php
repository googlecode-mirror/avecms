<?php

$modul_sql_install = array();
$modul_sql_deinstall = array();
$modul_sql_update = array();

$modul_sql_deinstall[] = "DROP TABLE IF EXISTS CPPREFIX_modul_poll;";
$modul_sql_deinstall[] = "DROP TABLE IF EXISTS CPPREFIX_modul_poll_comments;";
$modul_sql_deinstall[] = "DROP TABLE IF EXISTS CPPREFIX_modul_poll_items;";

$modul_sql_install[] = "CREATE TABLE CPPREFIX_modul_poll (
  id int(10) unsigned NOT NULL auto_increment,
  poll_title varchar(255) NOT NULL default '',
  poll_status enum('1','0') NOT NULL default '1',
  poll_can_comment enum('0','1') NOT NULL default '0',
  poll_groups_id tinytext,
  poll_start int(10) unsigned NOT NULL default '0',
  poll_end int(10) unsigned NOT NULL default '0',
  poll_users_id text NOT NULL default '',
  poll_users_ip text NOT NULL default '',
  PRIMARY KEY  (id)
) ENGINE=MyISAM DEFAULT CHARSET=cp1251;";

$modul_sql_install[] = "CREATE TABLE CPPREFIX_modul_poll_comments (
  id int(10) unsigned NOT NULL auto_increment,
  poll_id int(10) NOT NULL,
  poll_comment_author_id int(10) NOT NULL,
  poll_comment_author_ip text NOT NULL default '',
  poll_comment_time int(10) unsigned NOT NULL default '0',
  poll_comment_title varchar(250) NOT NULL default '',
  poll_comment_text text NOT NULL default '',
  PRIMARY KEY  (id)
) ENGINE=MyISAM DEFAULT CHARSET=cp1251;";

$modul_sql_install[] = "CREATE TABLE CPPREFIX_modul_poll_items (
  id int(10) unsigned NOT NULL auto_increment,
  poll_id int(10) NOT NULL,
  poll_item_title varchar(250) NOT NULL default '',
  poll_item_hits int(10) NOT NULL default '0',
  poll_item_color varchar(10) NOT NULL default '',
  poll_item_position int(2) NOT NULL,
  PRIMARY KEY  (id)
) ENGINE=MyISAM DEFAULT CHARSET=cp1251;";

$modul_sql_update[] = "UPDATE CPPREFIX_module SET CpEngineTag = '" . $modul['CpEngineTag'] . "', CpPHPTag = '" . $modul['CpPHPTag'] . "', Version = '" . $modul['ModulVersion'] . "' WHERE ModulPfad = '" . $modul['ModulPfad'] . "' LIMIT 1;";

?>