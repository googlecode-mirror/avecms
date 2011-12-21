<?php

/**
 * AVE.cms - Модуль RSS
 *
 * @package AVE.cms
 * @subpackage module_RSS
 * @since 2.07
 * @filesource
 */

/**
 * mySQL-запросы для установки, обновления и удаления модуля
 */

$modul_sql_install = array();
$modul_sql_deinstall = array();
$modul_sql_update = array();

$modul_sql_deinstall[] = "DROP TABLE IF EXISTS CPPREFIX_modul_rss;";

$modul_sql_install[] = "CREATE TABLE CPPREFIX_modul_rss (
  `id` smallint(3) unsigned NOT NULL auto_increment,
  `rss_site_name` char(255) NOT NULL,
  `rss_site_description` char(255) NOT NULL,
  `rss_site_url` char(255) NOT NULL,
  `rss_rubric_id` smallint(3) unsigned NOT NULL,
  `rss_title_id` int(10) unsigned NOT NULL,
  `rss_description_id` int(10) unsigned NOT NULL,
  `rss_item_on_page` tinyint(1) unsigned NOT NULL,
  `rss_description_lenght` smallint(3) unsigned NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;";

$modul_sql_update[] = "UPDATE CPPREFIX_module SET CpEngineTag = '" . $modul['CpEngineTag'] . "', CpPHPTag = '" . $modul['CpPHPTag'] . "', Version = '" . $modul['ModulVersion'] . "' WHERE ModulPfad = '" . $modul['ModulPfad'] . "' LIMIT 1;";

?>