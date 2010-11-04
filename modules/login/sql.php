<?php

/**
 * AVE.cms - Модуль Авторизация
 *
 * @package AVE.cms
 * @subpackage module_Login
 * @since 1.4
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
  login_reg_type enum('now','email','byadmin') NOT NULL default 'now',
  login_antispam enum('0','1') NOT NULL default '0',
  login_status enum('1','0') NOT NULL default '1',
  login_deny_domain text NOT NULL,
  login_deny_email text NOT NULL,
  login_require_company enum('0','1') NOT NULL default '0',
  login_require_firstname enum('0','1') NOT NULL default '0',
  login_require_lastname enum('0','1') NOT NULL default '0',
  PRIMARY KEY  (Id)
) ENGINE=MyISAM DEFAULT CHARSET=cp1251;";

$modul_sql_install[] = "INSERT INTO CPPREFIX_modul_login VALUES (1, 'email', 1, 1, 'domain.ru', 'name@domain.ru',0,0,0);";

$modul_sql_update[] = "UPDATE CPPREFIX_module SET CpEngineTag = '" . $modul['CpEngineTag'] . "', CpPHPTag = '" . $modul['CpPHPTag'] . "', Version = '" . $modul['ModulVersion'] . "' WHERE ModulPfad = '" . $modul['ModulPfad'] . "' LIMIT 1;";

?>