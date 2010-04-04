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

$modul_sql_deinstall = array();
$modul_sql_install = array();

$modul_sql_deinstall[] = "DROP TABLE IF EXISTS CPPREFIX_modul_login;";

$modul_sql_install[] = "DROP TABLE IF EXISTS CPPREFIX_modul_login;";
$modul_sql_install[] = "CREATE TABLE CPPREFIX_modul_login (
  Id smallint(2) unsigned NOT NULL auto_increment,
  RegTyp enum('now','email','byadmin') NOT NULL default 'now',
  AntiSpam tinyint(1) NOT NULL default '0',
  IstAktiv tinyint(1) NOT NULL default '1',
  DomainsVerboten text NOT NULL,
  EmailsVerboten text NOT NULL,
  ZeigeFirma TINYINT(1) UNSIGNED DEFAULT '0' NOT NULL,
  ZeigeVorname TINYINT(1) UNSIGNED DEFAULT '0' NOT NULL,
  ZeigeNachname TINYINT(1) UNSIGNED DEFAULT '0' NOT NULL,
  PRIMARY KEY  (Id)
) TYPE=MyISAM DEFAULT CHARSET=cp1251;";

$modul_sql_install[] = "INSERT INTO CPPREFIX_modul_login VALUES (1, 'email', 1, 1, 'domain.ru', 'name@domain.ru',0,0,0);";
?>