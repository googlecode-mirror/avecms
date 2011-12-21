<?php

/**
 * AVE.cms - Модуль Комментарии
 *
 * Данный файл является частью модуля "Комментарии" и содержит mySQL-запросы
 * к базе данных при операцих установки, обновления и удаления модуля через Панель управления.
 *
 * @package AVE.cms
 * @subpackage module_Comment
 * @since 1.4
 * @filesource
 */

$modul_sql_install = array();
$modul_sql_deinstall = array();
$modul_sql_update = array();

$modul_sql_deinstall[] = "DROP TABLE IF EXISTS `CPPREFIX_modul_comments`;";
$modul_sql_deinstall[] = "DROP TABLE IF EXISTS `CPPREFIX_modul_comment_info`;";

$modul_sql_install[] = "CREATE TABLE `CPPREFIX_modul_comments` (
  `Id` tinyint(1) unsigned NOT NULL auto_increment,
  `comment_max_chars` smallint(3) unsigned NOT NULL default '1000',
  `comment_user_groups` text NOT NULL,
  `comment_need_approve` enum('0','1') NOT NULL default '0',
  `comment_active` enum('1','0') NOT NULL default '1',
  `comment_use_antispam` enum('1','0') NOT NULL default '1',
  PRIMARY KEY  (`Id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;";

$modul_sql_install[] = "CREATE TABLE `CPPREFIX_modul_comment_info` (
  `Id` int(10) unsigned NOT NULL auto_increment,
  `parent_id` int(10) unsigned NOT NULL default '0',
  `document_id` int(10) unsigned NOT NULL default '0',
  `comment_author_name` varchar(255) NOT NULL,
  `comment_author_id` int(10) unsigned NOT NULL default '0',
  `comment_author_email` varchar(255) NOT NULL,
  `comment_author_city` varchar(255) NOT NULL,
  `comment_author_website` varchar(255) NOT NULL,
  `comment_author_ip` varchar(15) NOT NULL,
  `comment_published` int(10) unsigned NOT NULL default '0',
  `comment_changed` int(10) unsigned NOT NULL default '0',
  `comment_text` text NOT NULL,
  `comment_status` tinyint(1) unsigned NOT NULL default '1',
  `comments_close` tinyint(1) unsigned NOT NULL default '0',
  PRIMARY KEY  (`Id`),
  KEY `document_id` (`document_id`),
  KEY `parent_id` (`parent_id`),
  KEY `comment_status` (`comment_status`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 PACK_KEYS=0;";

$modul_sql_install[] = "INSERT INTO `CPPREFIX_modul_comments` VALUES (1, 1000, '1,3', '0', '1', '1');";

$modul_sql_update[] = "UPDATE CPPREFIX_module SET CpEngineTag = '" . $modul['CpEngineTag'] . "', CpPHPTag = '" . $modul['CpPHPTag'] . "', Version = '" . $modul['ModulVersion'] . "' WHERE ModulPfad = '" . $modul['ModulPfad'] . "' LIMIT 1;";

?>