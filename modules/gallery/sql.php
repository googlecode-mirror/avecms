<?php

/**
 * AVE.cms - Модуль Галерея.
 *
 * @package AVE.cms
 * @subpackage module_Gallery
 * @since 1.4
 * @filesource
 */

/**
 * mySQL-запросы для установки, обновления и удаления модуля
 */

$modul_sql_install = array();
$modul_sql_deinstall = array();
$modul_sql_update = array();


$modul_sql_deinstall[] = "DROP TABLE IF EXISTS CPPREFIX_modul_gallery;";
$modul_sql_deinstall[] = "DROP TABLE IF EXISTS CPPREFIX_modul_gallery_images;";


$modul_sql_install[] = "CREATE TABLE `CPPREFIX_modul_gallery` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `gallery_title` varchar(255) NOT NULL,
  `gallery_description` text NOT NULL,
  `gallery_author_id` int(10) unsigned NOT NULL default '0',
  `gallery_created` int(10) unsigned NOT NULL default '0',
  `gallery_thumb_width` smallint(3) unsigned NOT NULL default '120',
  `gallery_image_on_line` tinyint(1) unsigned NOT NULL default '4',
  `gallery_title_show` enum('1','0') NOT NULL default '1',
  `gallery_description_show` enum('1','0') NOT NULL default '1',
  `gallery_image_size_show` enum('0','1') NOT NULL default '0',
  `gallery_type` tinyint(1) unsigned NOT NULL default '4',
  `gallery_image_on_page` tinyint(1) unsigned NOT NULL default '12',
  `gallery_watermark` varchar(255) NOT NULL,
  `gallery_folder` varchar(255) NOT NULL,
  `gallery_orderby` enum('datedesc','dateasc','titleasc','titledesc','position') NOT NULL default 'datedesc',
  `gallery_script` text NOT NULL,
  `gallery_image_template` text NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=cp1251 PACK_KEYS=0;";

$modul_sql_install[] = "CREATE TABLE `CPPREFIX_modul_gallery_images` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `gallery_id` int(10) unsigned NOT NULL default '0',
  `image_filename` varchar(255) NOT NULL,
  `image_author_id` int(10) unsigned NOT NULL default '0',
  `image_title` varchar(255) NOT NULL,
  `image_description` text NOT NULL,
  `image_file_ext` char(4) NOT NULL,
  `image_date` int(10) unsigned NOT NULL default '0',
  `image_position` smallint(3) unsigned NOT NULL default '1',
  PRIMARY KEY  (`id`),
  KEY `image_position` (`image_position`),
  KEY `image_date` (`image_date`),
  KEY `gallery_id` (`gallery_id`),
  KEY `image_title` (`image_title`)
) ENGINE=MyISAM DEFAULT CHARSET=cp1251 PACK_KEYS=0;";

// демоданные
$modul_sql_install[] = "INSERT INTO `CPPREFIX_modul_gallery` VALUES (1, 'Демонстрационная галерея', 'Эта галерея создана для ознакомления с возможностями модуля', 1, 1250295071, 120, 4, '1', '1', '', 6, 4, 'watermark.gif', '', 'position', '', '');";

$modul_sql_install[] = "INSERT INTO `CPPREFIX_modul_gallery_images` VALUES (1, 1, 'crocodile.jpg', 1, 'Крокодил', '', '.jpg', 1250295071, 1);";
$modul_sql_install[] = "INSERT INTO `CPPREFIX_modul_gallery_images` VALUES (2, 1, 'dolphin.jpg', 1, 'Дельфин', '', '.jpg', 1250295071, 1);";
$modul_sql_install[] = "INSERT INTO `CPPREFIX_modul_gallery_images` VALUES (3, 1, 'duck.jpg', 1, 'Утка', '', '.jpg', 1250295071, 1);";
$modul_sql_install[] = "INSERT INTO `CPPREFIX_modul_gallery_images` VALUES (4, 1, 'eagle.jpg', 1, 'Орел', '', '.jpg', 1250295071, 7);";
$modul_sql_install[] = "INSERT INTO `CPPREFIX_modul_gallery_images` VALUES (5, 1, 'jellyfish.jpg', 1, 'Медузы', '', '.jpg', 1250295071, 1);";
$modul_sql_install[] = "INSERT INTO `CPPREFIX_modul_gallery_images` VALUES (6, 1, 'killer_whale.jpg', 1, 'Касатка', '', '.jpg', 1250295071, 6);";
$modul_sql_install[] = "INSERT INTO `CPPREFIX_modul_gallery_images` VALUES (7, 1, 'leaf.jpg', 1, 'Лист', '', '.jpg', 1250295071, 1);";
$modul_sql_install[] = "INSERT INTO `CPPREFIX_modul_gallery_images` VALUES (8, 1, 'spider.jpg', 1, 'Паук', '', '.jpg', 1250295071, 5);";


$modul_sql_update[] = "UPDATE CPPREFIX_module SET CpEngineTag = '" . $modul['CpEngineTag'] . "', CpPHPTag = '" . $modul['CpPHPTag'] . "', Version = '" . $modul['ModulVersion'] . "' WHERE ModulPfad = '" . $modul['ModulPfad'] . "' LIMIT 1;";

?>