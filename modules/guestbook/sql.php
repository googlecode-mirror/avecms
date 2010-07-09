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

$modul_sql_deinstall[] = "DROP TABLE IF EXISTS `CPPREFIX_modul_guestbook`;";
$modul_sql_deinstall[] = "DROP TABLE IF EXISTS `CPPREFIX_modul_guestbook_post`;";

$modul_sql_install[] = "CREATE TABLE `CPPREFIX_modul_guestbook` (
  `id` tinyint(1) unsigned NOT NULL auto_increment,
  `guestbook_antispam` enum('1','0') NOT NULL default '1',
  `guestbook_antispam_time` mediumint(5) NOT NULL default '1',
  `guestbook_send_copy` enum('1','0') NOT NULL default '1',
  `guestbook_email_copy` char(100) NOT NULL default 'info@domain.tld',
  `guestbook_post_max_length` mediumint(5) NOT NULL default '1500',
  `guestbook_need_approve` enum('1','0') NOT NULL default '1',
  `guestbook_use_bbcode` enum('1','0') NOT NULL default '1',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=cp1251;";

$modul_sql_install[] = "CREATE TABLE `CPPREFIX_modul_guestbook_post` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `guestbook_post_author_name` varchar(25) NOT NULL default '',
  `guestbook_post_author_email` varchar(100) NOT NULL default '',
  `guestbook_post_author_web` varchar(100) NOT NULL default '',
  `guestbook_post_author_ip` varchar(15) NOT NULL default '',
  `guestbook_post_author_sity` varchar(100) NOT NULL default '',
  `guestbook_post_text` text NOT NULL,
  `guestbook_post_approve` enum('0','1') NOT NULL default '0',
  `guestbook_post_created` int(10) unsigned NOT NULL default '0',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=cp1251 PACK_KEYS=0;";

$modul_sql_install[] = "INSERT INTO `CPPREFIX_modul_guestbook` VALUES (1, '1', 0, '1', 'info@domain.tld', 1500, '1', '1');";

$modul_sql_update[] = "UPDATE CPPREFIX_module SET CpEngineTag = '" . $modul['CpEngineTag'] . "', CpPHPTag = '" . $modul['CpPHPTag'] . "', Version = '" . $modul['ModulVersion'] . "' WHERE ModulPfad = '" . $modul['ModulPfad'] . "' LIMIT 1;";

?>