<?php

/**
 * AVE.cms - Модуль Рассылки
 *
 * @package AVE.cms
 * @subpackage module_Newsletter
 * @author Arcanum
 * @since 2.01
 * @filesource
 */

/**
 * mySQL-запросы для установки, обновления и удаления модуля
 */

$modul_sql_install = array();
$modul_sql_deinstall = array();

$modul_sql_deinstall[] = "DROP TABLE IF EXISTS CPPREFIX_modul_newsletter";

$modul_sql_install[] = "CREATE TABLE CPPREFIX_modul_newsletter (
  id int(10) unsigned NOT NULL auto_increment,
  newsletter_sender varchar(255) NOT NULL default '',
  newsletter_send_date int(10) unsigned default NULL,
  newsletter_format enum('text','html') NOT NULL default 'text',
  newsletter_title varchar(255) NOT NULL default '',
  newsletter_message text NOT NULL,
  newsletter_groups text NOT NULL,
  newsletter_attach tinytext NOT NULL,
  PRIMARY KEY  (id)
) ENGINE=MyISAM DEFAULT CHARSET=cp1251;";

$modul_sql_update[] = "UPDATE CPPREFIX_module SET CpEngineTag = '" . $modul['CpEngineTag'] . "', CpPHPTag = '" . $modul['CpPHPTag'] . "', Version = '" . $modul['ModulVersion'] . "' WHERE ModulPfad = '" . $modul['ModulPfad'] . "' LIMIT 1;";

?>