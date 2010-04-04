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
$modul_sql_deinstall = array();
$modul_sql_install = array();
$modul_sql_update = array();

$modul_sql_deinstall[] = "DROP TABLE IF EXISTS `CPPREFIX_modul_comments`;";
$modul_sql_deinstall[] = "DROP TABLE IF EXISTS `CPPREFIX_modul_comment_info`;";

$modul_sql_install[] = "CREATE TABLE `CPPREFIX_modul_comments` (
  `Id`             SMALLINT(2)  UNSIGNED NOT NULL AUTO_INCREMENT,
  `max_chars`      MEDIUMINT(5) UNSIGNED NOT NULL DEFAULT '1000',
  `user_groups`    TEXT         NOT NULL,
  `moderate`       TINYINT(1)   UNSIGNED NOT NULL DEFAULT '0',
  `active`         TINYINT(1)   UNSIGNED NOT NULL DEFAULT '1',
  `spamprotect`    TINYINT(1)   UNSIGNED NOT NULL DEFAULT '1',
  PRIMARY KEY  (`Id`)
) TYPE=MyISAM DEFAULT CHARSET=cp1251;";

$modul_sql_install[] = "INSERT INTO `CPPREFIX_modul_comments` VALUES ('1', '1000', '1,3,4', '0', '1', '1');";

$modul_sql_install[] = "CREATE TABLE `CPPREFIX_modul_comment_info` (
  `Id`             INT(10)      UNSIGNED NOT NULL AUTO_INCREMENT,
  `parent_id`      INT(10)      UNSIGNED NOT NULL DEFAULT '0',
  `document_id`    INT(10)      UNSIGNED NOT NULL DEFAULT '0',
  `author_name`    VARCHAR(255) NOT NULL,
  `author_id`      INT(10)      UNSIGNED NOT NULL DEFAULT '0',
  `author_email`   VARCHAR(255) NOT NULL,
  `author_city`    VARCHAR(255) NOT NULL,
  `author_website` VARCHAR(255) NOT NULL,
  `author_ip`      VARCHAR(15)  NOT NULL,
  `published`      INT(10)      UNSIGNED NOT NULL DEFAULT '0',
  `edited`         INT(10)      UNSIGNED NOT NULL DEFAULT '0',
  `message`        TEXT         NOT NULL,
  `status`         TINYINT(1)   UNSIGNED NOT NULL DEFAULT '1',
  `comments_close` TINYINT(1)   UNSIGNED NOT NULL DEFAULT '0',
  PRIMARY KEY  (`Id`),
  KEY `DokId`  (`document_id`),
  KEY `Status` (`status`),
  KEY `Elter`  (`parent_id`)
) TYPE=MyISAM DEFAULT CHARSET=cp1251 PACK_KEYS=0;";


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

$modul_sql_update[] = "UPDATE CPPREFIX_module SET Version = '" . $modul['ModulVersion'] . "' WHERE ModulName = '" . $modul['ModulName'] . "';" ;

?>