<?php

/**
 * AVE.cms - Модуль Гостевая книга
 *
 * @package AVE.cms
 * @subpackage module_Guestbook
 * @filesource
 */

/**
 * mySQL-запросы для установки, обновления и удаления модуля
 */

$modul_sql_install = array();
$modul_sql_deinstall = array();
$modul_sql_update = array();

$modul_sql_deinstall[] = "DROP TABLE IF EXISTS CPPREFIX_modul_guestbook_smileys;";
$modul_sql_deinstall[] = "DROP TABLE IF EXISTS CPPREFIX_modul_guestbook;";
$modul_sql_deinstall[] = "DROP TABLE IF EXISTS CPPREFIX_modul_guestbook_settings;";

$modul_sql_install[] = "CREATE TABLE CPPREFIX_modul_guestbook_settings (
  id int(11) NOT NULL auto_increment,
  spamprotect tinyint(1) NOT NULL default '1',
  spamprotect_time mediumint(5) NOT NULL default '1',
  mailbycomment tinyint(1) NOT NULL default '1',
  maxpostlength mediumint(5) NOT NULL default '500',
  entry_censore tinyint(1) UNSIGNED default '1' NOT NULL,
  smiles tinyint(1) NOT NULL default '1',
  bbcodes tinyint(1) NOT NULL default '1',
  smiliebr smallint(3) NOT NULL default '5',
  maxlines smallint(3) UNSIGNED NOT NULL default '50',
  mailsend varchar(50) NOT NULL default 'test@test.ru',
  PRIMARY KEY (id)
) TYPE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=cp1251;";

$modul_sql_install[] = "CREATE TABLE CPPREFIX_modul_guestbook (
  id int(11) NOT NULL auto_increment,
  ctime int(11) NOT NULL default '0',
  author varchar(255) NOT NULL default '',
  comment text NOT NULL,
  email varchar(255) NOT NULL default '',
  web varchar(255) NOT NULL default '',
  ip varchar(255) NOT NULL default '',
  authfrom varchar(255) NOT NULL default '',
  is_active tinyint(1) UNSIGNED default '0' NOT NULL,
  PRIMARY KEY  (id)
) TYPE=MyISAM PACK_KEYS=0 AUTO_INCREMENT=1 DEFAULT CHARSET=cp1251;";

$modul_sql_install[] = "CREATE TABLE CPPREFIX_modul_guestbook_smileys (
  id int(11) NOT NULL auto_increment,
  posi mediumint(5) NOT NULL default '1',
  active tinyint(1) NOT NULL default '1',
  code varchar(15) NOT NULL default '',
  path varchar(55) NOT NULL default '',
  PRIMARY KEY  (id)
) TYPE=MyISAM AUTO_INCREMENT=25 DEFAULT CHARSET=cp1251;";

$modul_sql_install[] = "INSERT INTO CPPREFIX_modul_guestbook_smileys VALUES (2, 1, 1, ':)', '1.gif');";
$modul_sql_install[] = "INSERT INTO CPPREFIX_modul_guestbook_smileys VALUES (3, 2, 1, ';)', '2.gif');";
$modul_sql_install[] = "INSERT INTO CPPREFIX_modul_guestbook_smileys VALUES (4, 3, 1, ':D', '3.gif');";
$modul_sql_install[] = "INSERT INTO CPPREFIX_modul_guestbook_smileys VALUES (5, 4, 1, ':(', '4.gif');";
$modul_sql_install[] = "INSERT INTO CPPREFIX_modul_guestbook_smileys VALUES (6, 5, 1, ':-0', '5.gif');";
$modul_sql_install[] = "INSERT INTO CPPREFIX_modul_guestbook_smileys VALUES (7, 6, 1, ':((', '6.gif');";
$modul_sql_install[] = "INSERT INTO CPPREFIX_modul_guestbook_smileys VALUES (8, 7, 1, '0=)', '7.gif');";
$modul_sql_install[] = "INSERT INTO CPPREFIX_modul_guestbook_smileys VALUES (9, 8, 1, ':-P', '8.gif');";
$modul_sql_install[] = "INSERT INTO CPPREFIX_modul_guestbook_smileys VALUES (10, 9, 1, ':ok:', '9.gif');";
$modul_sql_install[] = "INSERT INTO CPPREFIX_modul_guestbook_smileys VALUES (11, 10, 1, ':unknown:', '10.gif');";
$modul_sql_install[] = "INSERT INTO CPPREFIX_modul_guestbook_smileys VALUES (12, 11, 1, ':bravo:', '11.gif');";
$modul_sql_install[] = "INSERT INTO CPPREFIX_modul_guestbook_smileys VALUES (13, 12, 1, '%)', '12.gif');";
$modul_sql_install[] = "INSERT INTO CPPREFIX_modul_guestbook_smileys VALUES (14, 13, 1, ':rams:', '13.gif');";
$modul_sql_install[] = "INSERT INTO CPPREFIX_modul_guestbook_smileys VALUES (15, 14, 1, ':drink:', '14.gif');";
$modul_sql_install[] = "INSERT INTO CPPREFIX_modul_guestbook_smileys VALUES (16, 15, 1, '@}->--', '15.gif');";
$modul_sql_install[] = "INSERT INTO CPPREFIX_modul_guestbook_smileys VALUES (17, 16, 1, ':kiss:', '16.gif');";
$modul_sql_install[] = "INSERT INTO CPPREFIX_modul_guestbook_smileys VALUES (18, 17, 1, ':stop:', '17.gif');";
$modul_sql_install[] = "INSERT INTO CPPREFIX_modul_guestbook_smileys VALUES (19, 18, 1, ':-!', '18.gif');";
$modul_sql_install[] = "INSERT INTO CPPREFIX_modul_guestbook_smileys VALUES (20, 19, 1, ']:->', '19.gif');";
$modul_sql_install[] = "INSERT INTO CPPREFIX_modul_guestbook_smileys VALUES (21, 20, 1, ':box:', '20.gif');";

$modul_sql_install[] = "INSERT INTO CPPREFIX_modul_guestbook_settings VALUES ('1', '1', '5', '1', '500', '0', '1', '0', '5', '50', 'test@test.ru');";

$modul_sql_update[] = "UPDATE CPPREFIX_module SET CpEngineTag = '" . $modul['CpEngineTag'] . "', CpPHPTag = '" . $modul['CpPHPTag'] . "', Version = '" . $modul['ModulVersion'] . "' WHERE ModulPfad = '" . $modul['ModulPfad'] . "' LIMIT 1;";

?>