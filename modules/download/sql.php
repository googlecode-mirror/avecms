<?php

$modul_sql_install = array();
$modul_sql_deinstall = array();
$modul_sql_update = array();

$modul_sql_deinstall[] = "DROP TABLE IF EXISTS CPPREFIX_modul_download_comments;";
$modul_sql_deinstall[] = "DROP TABLE IF EXISTS CPPREFIX_modul_download_files;";
$modul_sql_deinstall[] = "DROP TABLE IF EXISTS CPPREFIX_modul_download_kat;";
$modul_sql_deinstall[] = "DROP TABLE IF EXISTS CPPREFIX_modul_download_lizenzen;";
$modul_sql_deinstall[] = "DROP TABLE IF EXISTS CPPREFIX_modul_download_log;";
$modul_sql_deinstall[] = "DROP TABLE IF EXISTS CPPREFIX_modul_download_os;";
$modul_sql_deinstall[] = "DROP TABLE IF EXISTS CPPREFIX_modul_download_settings;";
$modul_sql_deinstall[] = "DROP TABLE IF EXISTS CPPREFIX_modul_download_sprachen;";
$modul_sql_deinstall[] = "DROP TABLE IF EXISTS CPPREFIX_modul_download_payhistory;";

$modul_sql_install[] = "CREATE TABLE CPPREFIX_modul_download_comments (
  Id int(10) unsigned NOT NULL auto_increment,
  FileId int(10) unsigned NOT NULL default '0',
  Datum int(14) unsigned NOT NULL default '0',
  title varchar(100) NOT NULL default '',
  comment_text text NOT NULL,
  Name varchar(100) NOT NULL default '',
  email varchar(100) NOT NULL default '',
  Ip varchar(200) NOT NULL default '',
  status tinyint(1) unsigned NOT NULL default '1',
  PRIMARY KEY  (Id)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;";

$modul_sql_install[] = "CREATE TABLE CPPREFIX_modul_download_files (
  Id int(10) unsigned NOT NULL auto_increment,
  Autor varchar(255) default NULL,
  AutorUrl varchar(255) default NULL,
  Version varchar(255) default NULL,
  Sprache varchar(255) default '1',
  KatId int(10) unsigned NOT NULL default '1',
  Name varchar(255) NOT NULL default '',
  description text,
  Limitierung text,
  status tinyint(1) unsigned NOT NULL default '1',
  Methode enum('ftp','http','local') NOT NULL default 'local',
  Pfad varchar(255) NOT NULL default '',
  Downloads int(10) unsigned NOT NULL default '0',
  Groesse int(14) unsigned NOT NULL default '0',
  GroesseEinheit enum('kb','mb') NOT NULL default 'kb',
  Datum int(14) unsigned NOT NULL default '0',
  Geaendert int(14) unsigned default NULL,
  Os varchar(255) NOT NULL default '1',
  Lizenz mediumint(2) default NULL,
  Wertung enum('1','2','3','4','5') NOT NULL default '5',
  Wertungen_top int(14) unsigned NOT NULL default '0',
  Wertungen_flop int(14) unsigned NOT NULL default '0',
  Wertungen_ip text NOT NULL,
  Wertungen_ja tinyint(1) unsigned NOT NULL default '1',
  RegGebuehr varchar(200) default NULL,
  Mirrors text,
  Screenshot varchar(255) default NULL,
  Autor_Erstellt int(14) unsigned NOT NULL default '1',
  Autor_Geandert int(10) unsigned NOT NULL default '1',
  Kommentar_ja int(10) unsigned NOT NULL default '1',
  Downloads_Max int(10) unsigned NOT NULL default '0',
  Pay varchar(10) default '0',
  Pay_val int(10) unsigned NOT NULL default '0',
  PRIMARY KEY  (Id)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;";

$modul_sql_install[] = "CREATE TABLE CPPREFIX_modul_download_kat (
  Id int(10) unsigned NOT NULL auto_increment,
  parent_id int(10) unsigned NOT NULL default '0',
  KatName varchar(255) NOT NULL default '',
  position int(8) unsigned NOT NULL default '1',
  KatBeschreibung text NOT NULL,
  user_group varchar(255) NOT NULL default '1|2|3|4|5|6',
  Bild varchar(200) default NULL,
  PRIMARY KEY  (Id)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;";

$modul_sql_install[] = "CREATE TABLE CPPREFIX_modul_download_lizenzen (
  Id smallint(2) unsigned NOT NULL auto_increment,
  Name varchar(255) NOT NULL default '',
  PRIMARY KEY  (Id)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;";

$modul_sql_install[] = "CREATE TABLE CPPREFIX_modul_download_log (
  Id int(14) unsigned NOT NULL auto_increment,
  FileId int(14) unsigned NOT NULL default '0',
  Datum varchar(10) NOT NULL default '',
  Ip varchar(100) NOT NULL default '',
  PRIMARY KEY  (Id)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;";

$modul_sql_install[] = "CREATE TABLE CPPREFIX_modul_download_os (
  Id int(10) unsigned NOT NULL auto_increment,
  Name varchar(200) NOT NULL default '',
  PRIMARY KEY  (Id)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;";

$modul_sql_install[] = "CREATE TABLE CPPREFIX_modul_download_settings (
  Empfehlen tinyint(1) unsigned NOT NULL default '1',
  Bewerten tinyint(1) unsigned NOT NULL default '0',
  Spamwoerter text NOT NULL,
  Kommentare tinyint(1) unsigned NOT NULL default '1'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;";

$modul_sql_install[] = "CREATE TABLE CPPREFIX_modul_download_sprachen (
  Id int(10) unsigned NOT NULL auto_increment,
  Name varchar(200) NOT NULL default '',
  PRIMARY KEY  (Id)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;";

$modul_sql_install[] = "INSERT INTO CPPREFIX_modul_download_files VALUES (8, 'Overdoze', 'http://www.overdoze.ru', '5.0', '1', 24, 'Koobi Handbuch', '<p>Актуальное руководство для Koobi 5 Standard и Koobi 5 Pro.<br />\r\n<br />\r\nНа данный момент руководство состоит из 130 страниц с 240 цветными иллюстрациями. Это руководство постоянно обновляется, поэтому Вы сможете получить специальные сведения о последних изменениях.</p>\r\n<p>Для просмотра у Вас должна быть установлена программа Adobe&reg; Acrobat&reg; Reader</p>', 'keine', 1, 'local', 'HandbuchKoobi5.pdf', 450, 0, 'kb', 1164046575, 1164047383, '8', 3, '5', 32, 5, '', 1, 'keine', 'http://www.overdoze.ru\r\nhttp://www.domain.ru', 'uploads/images/splash_koobi.gif', 1, 1, 1, 0, 0, 0);";
$modul_sql_install[] = "INSERT INTO CPPREFIX_modul_download_files VALUES (11, '', '', '', '1', 24, 'Koobi Changelog', 'Этот документ содержит описание всех изменений в Koobi', '', 1, 'local', 'Changelog.pdf', 69, 0, 'kb', 1164047584, NULL, '9', 3, '5', 20, 3, '', 1, '', '', 'uploads/images/splash_koobi.gif', 1, 1, 1, 0, 0, 0);";

$modul_sql_install[] = "INSERT INTO CPPREFIX_modul_download_kat VALUES (24, 0, 'Koobi', 1, '', '1|12|6|2|8|7|4|5|11|3', 'koobi.gif');";

$modul_sql_install[] = "INSERT INTO CPPREFIX_modul_download_lizenzen VALUES ('', 'Freeware');";
$modul_sql_install[] = "INSERT INTO CPPREFIX_modul_download_lizenzen VALUES ('', 'Shareware');";
$modul_sql_install[] = "INSERT INTO CPPREFIX_modul_download_lizenzen VALUES ('', 'Без лицензии');";
$modul_sql_install[] = "INSERT INTO CPPREFIX_modul_download_lizenzen VALUES ('', 'GNU LGPL');";
$modul_sql_install[] = "INSERT INTO CPPREFIX_modul_download_lizenzen VALUES ('', 'GPL');";
$modul_sql_install[] = "INSERT INTO CPPREFIX_modul_download_lizenzen VALUES ('', 'LGPL');";

$modul_sql_install[] = "INSERT INTO CPPREFIX_modul_download_os VALUES (1, 'Windows 95');";
$modul_sql_install[] = "INSERT INTO CPPREFIX_modul_download_os VALUES (2, 'Windows 98');";
$modul_sql_install[] = "INSERT INTO CPPREFIX_modul_download_os VALUES (3, 'Windows ME');";
$modul_sql_install[] = "INSERT INTO CPPREFIX_modul_download_os VALUES (4, 'Windows 2000');";
$modul_sql_install[] = "INSERT INTO CPPREFIX_modul_download_os VALUES (5, 'Windows 2003');";
$modul_sql_install[] = "INSERT INTO CPPREFIX_modul_download_os VALUES (6, 'Windows NT');";
$modul_sql_install[] = "INSERT INTO CPPREFIX_modul_download_os VALUES (7, 'Windows XP');";
$modul_sql_install[] = "INSERT INTO CPPREFIX_modul_download_os VALUES (8, 'Windows Vista');";
$modul_sql_install[] = "INSERT INTO CPPREFIX_modul_download_os VALUES (9, 'Independent');";
$modul_sql_install[] = "INSERT INTO CPPREFIX_modul_download_os VALUES (10, 'Handheld');";
$modul_sql_install[] = "INSERT INTO CPPREFIX_modul_download_os VALUES (11, 'Linux');";
$modul_sql_install[] = "INSERT INTO CPPREFIX_modul_download_os VALUES (12, 'Mac');";
$modul_sql_install[] = "INSERT INTO CPPREFIX_modul_download_os VALUES (13, 'Mac OS 7.x');";
$modul_sql_install[] = "INSERT INTO CPPREFIX_modul_download_os VALUES (14, 'Mac OS 8.x');";
$modul_sql_install[] = "INSERT INTO CPPREFIX_modul_download_os VALUES (15, 'Mac OS 9.x');";
$modul_sql_install[] = "INSERT INTO CPPREFIX_modul_download_os VALUES (16, 'Mac OS X');";
$modul_sql_install[] = "INSERT INTO CPPREFIX_modul_download_os VALUES (17, 'Unix');";

$modul_sql_install[] = "INSERT INTO CPPREFIX_modul_download_settings VALUES (1, 1, 'viagra\r\ncialis\r\ncasino\r\ngamble\r\npoker\r\nholdem\r\nbackgammon\r\nbackjack\r\nblack Jack\r\nRoulette\r\nV-I-A-G-R-A\r\nsex\r\ninsurance\r\n!!!\r\n???\r\nxxx', 1);";

$modul_sql_install[] = "INSERT INTO CPPREFIX_modul_download_sprachen VALUES (1, 'Русский');";
$modul_sql_install[] = "INSERT INTO CPPREFIX_modul_download_sprachen VALUES (2, 'Английский');";
$modul_sql_install[] = "INSERT INTO CPPREFIX_modul_download_sprachen VALUES (3, 'Немецкий');";
$modul_sql_install[] = "INSERT INTO CPPREFIX_modul_download_sprachen VALUES (4, 'Французский');";
$modul_sql_install[] = "INSERT INTO CPPREFIX_modul_download_sprachen VALUES (5, 'Итальянский');";

$modul_sql_install[] = "ALTER TABLE CPPREFIX_modul_download_files ADD Pay_Type SMALLINT(2) UNSIGNED NOT NULL DEFAULT '0';";
$modul_sql_install[] = "ALTER TABLE CPPREFIX_modul_download_files ADD Only_Pay TINYINT(1) UNSIGNED NOT NULL DEFAULT '1';";
$modul_sql_install[] = "ALTER TABLE CPPREFIX_modul_download_files ADD Excl_Pay TINYINT(1) UNSIGNED NOT NULL DEFAULT '0';";
$modul_sql_install[] = "ALTER TABLE CPPREFIX_modul_download_files ADD Excl_Chk TINYINT(1) UNSIGNED NOT NULL DEFAULT '0';";

$modul_sql_install[] = "CREATE TABLE CPPREFIX_modul_download_payhistory (
  Id int(10) unsigned NOT NULL auto_increment,
  User_Id int(10) unsigned NOT NULL default '0',
  PayAmount double(14,2) unsigned NOT NULL default '0',
  File_Id int(10) unsigned NOT NULL default '0',
  PayDate varchar(10) default '',
  User_IP varchar(15) default '',
  PRIMARY KEY  (Id)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;";

$modul_sql_update[] = "UPDATE CPPREFIX_module SET CpEngineTag = '" . $modul['CpEngineTag'] . "', CpPHPTag = '" . $modul['CpPHPTag'] . "', Version = '" . $modul['ModulVersion'] . "' WHERE ModulPfad = '" . $modul['ModulPfad'] . "' LIMIT 1;";

?>