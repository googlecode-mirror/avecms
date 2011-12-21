<?php

/**
 * AVE.cms - module Google Weather
 *
 * @package AVE.cms
 * @subpackage module_Weather
 * @author N.Popova, npop@abv.bg
 * @since 2.09
 * @filesource
 */

/**
 * mySQL-query install, update and delete module
 */

$modul_sql_install = array();
$modul_sql_deinstall = array();
$modul_sql_update = array();

$modul_sql_deinstall[] = "DROP TABLE IF EXISTS `CPPREFIX_modul_gweather`;";

$modul_sql_install[] = "CREATE TABLE `CPPREFIX_modul_gweather` (
  `id` tinyint(1) unsigned NOT NULL auto_increment,
  `city` char(100) NOT NULL,
  `fullcity` char(100) NOT NULL,
  `language` char(2) NOT NULL default 'ru',
  `lat` decimal(10,8) NOT NULL,
  `lon` decimal(10,8) NOT NULL,
  `timezone` char(3) NOT NULL default '0',
  `showCity` enum('1','0') NOT NULL default '1',
  `showHum` enum('1','0') NOT NULL default '1',
  `showWind` enum('1','0') NOT NULL default '1',
  `tempUnit` enum('c','f') NOT NULL default 'c',
  `amountDays` enum('0','1','2','3','4') NOT NULL default '4',
  `current_icon_size` enum('64','128','32') NOT NULL default '64',
  `forecast_icon_size` enum('32','128','64') NOT NULL default '32',
  `cacheTime` tinyint(1) unsigned NOT NULL default '5',
  `encoding` char(30) NOT NULL default 'cp1251',
  `template` enum('gweather','simple') NOT NULL default 'gweather',
  `useCSS` enum('1','0') NOT NULL default '1',
  `nameCSS` enum('gweather','simple') NOT NULL default 'gweather',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;" ;

$modul_sql_install[] = "INSERT INTO `CPPREFIX_modul_gweather` VALUES (1, 'Odessa,Ukraine', 'Одесса', 'ru', 46.46666666, 30.73333333, '+2', '1', '1', '1', 'c', '3', '64', '32', 30, 'cp1251', 'gweather', '1', 'gweather');";

$modul_sql_update[] = "UPDATE CPPREFIX_module SET CpEngineTag = '" . $modul['CpEngineTag'] . "', CpPHPTag = '" . $modul['CpPHPTag'] . "', Version = '" . $modul['ModulVersion'] . "' WHERE ModulPfad = '" . $modul['ModulPfad'] . "' LIMIT 1;";

?>