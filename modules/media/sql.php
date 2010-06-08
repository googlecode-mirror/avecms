<?php

/**
 * AVE.cms - ������ �������
 *
 * @package AVE.cms
 * @subpackage module_Banner
 * @filesource
 */

/**
 * mySQL-������� ��� ���������, ���������� � �������� ������
 */

$modul_sql_install = array();
$modul_sql_deinstall = array();
$modul_sql_update = array();

$modul_sql_deinstall[] = "DROP TABLE IF EXISTS `CPPREFIX_modul_banner_categories`;";
$modul_sql_deinstall[] = "DROP TABLE IF EXISTS `CPPREFIX_modul_banners`;";

$modul_sql_install[] = "CREATE TABLE `CPPREFIX_modul_banner_categories` (
  `Id` smallint(3) unsigned NOT NULL auto_increment,
  `banner_category_name` char(100) NOT NULL default '',
  PRIMARY KEY  (`Id`)
) TYPE=MyISAM DEFAULT CHARSET=cp1251;";

$modul_sql_install[] = "CREATE TABLE `CPPREFIX_modul_banners` (
  `Id` mediumint(5) unsigned NOT NULL auto_increment,
  `banner_category_id` smallint(3) unsigned NOT NULL default '1',
  `banner_file_name` char(255) NOT NULL default '',
  `banner_url` char(255) NOT NULL default '',
  `banner_priority` enum('0','1','2','3') NOT NULL default '0',
  `banner_name` char(100) NOT NULL default '',
  `banner_views` mediumint(5) unsigned NOT NULL default '0',
  `banner_clicks` mediumint(5) unsigned NOT NULL default '0',
  `banner_alt` char(255) NOT NULL default '',
  `banner_max_clicks` mediumint(5) unsigned NOT NULL default '0',
  `banner_max_views` mediumint(5) unsigned NOT NULL default '0',
  `banner_show_start` tinyint(1) unsigned NOT NULL default '0',
  `banner_show_end` tinyint(1) unsigned NOT NULL default '0',
  `banner_status` enum('1','0') NOT NULL default '1',
  `banner_target` enum('_blank', '_self') NOT NULL DEFAULT '_blank',
  `banner_width` smallint(3) unsigned NOT NULL default '0',
  `banner_height` smallint(3) unsigned NOT NULL default '0',
  PRIMARY KEY  (`Id`),
  KEY `banner_category_id` (`banner_category_id`)
) TYPE=MyISAM DEFAULT CHARSET=cp1251;";

$modul_sql_install[] = "INSERT INTO `CPPREFIX_modul_banner_categories` VALUES ('1', '��������� 1');";
$modul_sql_install[] = "INSERT INTO `CPPREFIX_modul_banner_categories` VALUES ('2', '��������� 2');";

$modul_sql_install[] = "INSERT INTO `CPPREFIX_modul_banners` VALUES ('', '1', 'banner.jpg', 'http://www.overdoze.ru', '1', 'Overdoze-Banner', '0', '0', '������� CMS, ���������� �������, ����� � ��������� �������������', '0', '0', '0', '0', '1', '_self', '0', '0');";
$modul_sql_install[] = "INSERT INTO `CPPREFIX_modul_banners` VALUES ('', '1', 'banner2.gif', 'http://www.google.de', '1', 'Google-Banner', '0', '0', '�������� ���� Google', '0', '0', '0', '0', '1', '_blank', '0', '0');";

$modul_sql_update[] = "UPDATE CPPREFIX_module SET CpEngineTag = '" . $modul['CpEngineTag'] . "', CpPHPTag = '" . $modul['CpPHPTag'] . "', Version = '" . $modul['ModulVersion'] . "' WHERE ModulPfad = '" . BANNER_DIR . "' LIMIT 1;";

?>