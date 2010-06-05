<?php

/**
 * AVE.cms - Модуль Комментарии
 *
 * @package AVE.cms
 * @subpackage module_Comment
 * @filesource
 */

/**
 * mySQL-запросы для установки, обновления и удаления модуля
 */

$modul_sql_install = array();
$modul_sql_deinstall = array();
$modul_sql_update = array();

$modul_sql_deinstall[] = "DROP TABLE IF EXISTS `CPPREFIX_modul_comments`;";
$modul_sql_deinstall[] = "DROP TABLE IF EXISTS `CPPREFIX_modul_comment_info`;";

$modul_sql_install[] = "CREATE TABLE `CPPREFIX_modul_comments` (
  `Id` tinyint(1) unsigned NOT NULL auto_increment,
  `max_chars` smallint(3) unsigned NOT NULL default '1000',
  `user_groups` text NOT NULL,
  `moderate` enum('0','1') NOT NULL default '0',
  `active` enum('1','0') NOT NULL default '1',
  `spamprotect` enum('1','0') NOT NULL default '1',
  PRIMARY KEY  (`Id`)
) ENGINE=MyISAM DEFAULT CHARSET=cp1251;";

$modul_sql_install[] = "CREATE TABLE `CPPREFIX_modul_comment_info` (
  `Id` int(10) unsigned NOT NULL auto_increment,
  `parent_id` int(10) unsigned NOT NULL default '0',
  `document_id` int(10) unsigned NOT NULL default '0',
  `author_name` varchar(255) NOT NULL,
  `author_id` int(10) unsigned NOT NULL default '0',
  `author_email` varchar(255) NOT NULL,
  `author_city` varchar(255) NOT NULL,
  `author_website` varchar(255) NOT NULL,
  `author_ip` varchar(15) NOT NULL,
  `published` int(10) unsigned NOT NULL default '0',
  `edited` int(10) unsigned NOT NULL default '0',
  `message` text NOT NULL,
  `status` tinyint(1) unsigned NOT NULL default '1',
  `comments_close` tinyint(1) unsigned NOT NULL default '0',
  PRIMARY KEY  (`Id`),
  KEY `document_id` (`document_id`),
  KEY `parent_id` (`parent_id`),
  KEY `status` (`status`)
) ENGINE=MyISAM DEFAULT CHARSET=cp1251 PACK_KEYS=0;";

$modul_sql_install[] = "INSERT INTO `CPPREFIX_modul_comments` VALUES (1, 1000, '1,3', '0', '1', '1');";

$modul_sql_update[] = "UPDATE CPPREFIX_module SET CpEngineTag = '" . $modul['CpEngineTag'] . "', CpPHPTag = '" . $modul['CpPHPTag'] . "', Version = '" . $modul['ModulVersion'] . "' WHERE ModulPfad = '" . $modul['ModulPfad'] . "' LIMIT 1;";

/*
$modul_sql_update[] = "ALTER TABLE `CPPREFIX_modul_comments`
CHANGE `MaxZeichen`  `max_chars`      MEDIUMINT(5) UNSIGNED DEFAULT '1000' NOT NULL,
CHANGE `Gruppen`     `user_groups`    TEXT         CHARACTER SET cp1251 COLLATE cp1251_general_ci NOT NULL,
CHANGE `Zensur`      `moderate`       TINYINT(1)   UNSIGNED DEFAULT '0' NOT NULL,
CHANGE `Aktiv`       `active`         TINYINT(1)   UNSIGNED DEFAULT '1' NOT NULL,
ADD    `spamprotect`                  TINYINT(1)   UNSIGNED DEFAULT '1' NOT NULL;";

$modul_sql_update[] = "ALTER TABLE `CPPREFIX_modul_comment_info`
CHANGE `Elter`       `parent_id`      INT(10)      UNSIGNED DEFAULT '0' NOT NULL,
CHANGE `DokId`       `document_id`    INT(10)      UNSIGNED DEFAULT '0' NOT NULL,
CHANGE `Author`      `author_name`    VARCHAR(255) CHARACTER SET cp1251 COLLATE cp1251_general_ci NOT NULL,
CHANGE `Author_Id`   `author_id`      INT(10)      UNSIGNED DEFAULT '0' NOT NULL,
CHANGE `AEmail`      `author_email`   VARCHAR(255) CHARACTER SET cp1251 COLLATE cp1251_general_ci NOT NULL,
CHANGE `author_city` `author_city`    VARCHAR(255) CHARACTER SET cp1251 COLLATE cp1251_general_ci NOT NULL,
CHANGE `AWebseite`   `author_website` VARCHAR(255) CHARACTER SET cp1251 COLLATE cp1251_general_ci NOT NULL,
CHANGE `AIp`         `author_ip`      VARCHAR(15)  CHARACTER SET cp1251 COLLATE cp1251_general_ci NOT NULL,
CHANGE `Erstellt`    `published`      INT(10)      UNSIGNED DEFAULT '0' NOT NULL,
CHANGE `Geaendert`   `edited`         INT(10)      UNSIGNED DEFAULT '0' NOT NULL,
CHANGE `Text`        `message`        TEXT         CHARACTER SET cp1251 COLLATE cp1251_general_ci NOT NULL,
CHANGE `Status`      `status`         TINYINT(1)   UNSIGNED DEFAULT '1' NOT NULL,
CHANGE `Geschlossen` `comments_close` TINYINT(1)   UNSIGNED DEFAULT '0' NOT NULL,
DROP   `Titel`;";
*/

?>