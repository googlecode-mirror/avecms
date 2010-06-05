<?php

/**
 * AVE.cms - Модуль Авторизация
 *
 * @package AVE.cms
 * @subpackage module_Login
 * @filesource
 */

/**
 * mySQL-запросы для установки, обновления и удаления модуля
 */

$modul_sql_install = array();
$modul_sql_deinstall = array();
$modul_sql_update = array();

$modul_sql_deinstall[] = "DROP TABLE IF EXISTS CPPREFIX_modul_login;";

$modul_sql_install[] = "CREATE TABLE CPPREFIX_modul_login (
  Id tinyint(1) unsigned NOT NULL auto_increment,
  RegTyp enum('now','email','byadmin') NOT NULL default 'now',
  AntiSpam enum('0','1') NOT NULL default '0',
  IstAktiv enum('1','0') NOT NULL default '1',
  DomainsVerboten text NOT NULL,
  EmailsVerboten text NOT NULL,
  ZeigeFirma enum('0','1') NOT NULL default '0',
  ZeigeVorname enum('0','1') NOT NULL default '0',
  ZeigeNachname enum('0','1') NOT NULL default '0',
  PRIMARY KEY  (Id)
) TYPE=MyISAM DEFAULT CHARSET=cp1251;";

$modul_sql_install[] = "INSERT INTO CPPREFIX_modul_login VALUES (1, 'email', 1, 1, 'domain.ru', 'name@domain.ru',0,0,0);";

$modul_sql_update[] = "UPDATE CPPREFIX_module SET CpEngineTag = '" . $modul['CpEngineTag'] . "', CpPHPTag = '" . $modul['CpPHPTag'] . "', Version = '" . $modul['ModulVersion'] . "' WHERE ModulPfad = '" . $modul['ModulPfad'] . "' LIMIT 1;";

?>