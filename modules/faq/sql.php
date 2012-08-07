<?php

/**
 * AVE.cms - Модуль Вопрос-Ответ
 *
 * @package AVE.cms
 * @subpackage module_FAQ
 * @since 2.0
 * @filesource
 */

/**
 * mySQL-запросы для установки, обновления и удаления модуля
 */

$modul_sql_install = array();
$modul_sql_deinstall = array();
$modul_sql_update = array();

$modul_sql_deinstall[] = "DROP TABLE IF EXISTS CPPREFIX_modul_faq;";
$modul_sql_deinstall[] = "DROP TABLE IF EXISTS CPPREFIX_modul_faq_quest;";

$modul_sql_install[] = "CREATE TABLE CPPREFIX_modul_faq (
  `id` mediumint(5) unsigned NOT NULL auto_increment,
  `faq_title` char(100) NOT NULL default '',
  `faq_description` char(255) NOT NULL default '',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;";

$modul_sql_install[] = "CREATE TABLE CPPREFIX_modul_faq_quest (
  `id` mediumint(5) unsigned NOT NULL auto_increment,
  `faq_id` mediumint(5) unsigned NOT NULL default '1',
  `faq_quest` text NOT NULL,
  `faq_answer` text NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;";

$modul_sql_update[] = "UPDATE CPPREFIX_module SET CpEngineTag = '" . $modul['CpEngineTag'] . "', CpPHPTag = '" . $modul['CpPHPTag'] . "', Version = '" . $modul['ModulVersion'] . "' WHERE ModulPfad = '" . $modul['ModulPfad'] . "' LIMIT 1;";

?>