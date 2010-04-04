<?php

/**
 * AVE.cms - Модуль Галерея.
 *
 * @package AVE.cms
 * @subpackage module_Gallery
 * @filesource
 */

/**
 * mySQL-запросы для установки, обновления и удаления модуля
 */

$modul_sql_deinstall = array();
$modul_sql_install = array();
$modul_sql_update = array();

$modul_sql_install[] = "DROP TABLE IF EXISTS CPPREFIX_modul_gallery;";
$modul_sql_install[] = "DROP TABLE IF EXISTS CPPREFIX_modul_gallery_images;";

$modul_sql_install[] = "CREATE TABLE `CPPREFIX_modul_gallery` (
  `id` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `gallery_title` VARCHAR(200) NOT NULL DEFAULT '',
  `gallery_description` TEXT NOT NULL,
  `gallery_author` MEDIUMINT(5) UNSIGNED NOT NULL DEFAULT '0',
  `gallery_date` INT(14) UNSIGNED NOT NULL DEFAULT '0',
  `thumb_width` MEDIUMINT(4) UNSIGNED NOT NULL DEFAULT '120',
  `image_on_line` SMALLINT(2) UNSIGNED NOT NULL DEFAULT '4',
  `show_title` TINYINT(1) UNSIGNED NOT NULL DEFAULT '1',
  `show_description` TINYINT(1) UNSIGNED NOT NULL DEFAULT '1',
  `show_size` TINYINT(1) UNSIGNED NOT NULL DEFAULT '0',
  `type_out` TINYINT(1) UNSIGNED NOT NULL DEFAULT '4',
  `image_on_page` MEDIUMINT(4) UNSIGNED NOT NULL DEFAULT '12',
  `watermark` VARCHAR(255) DEFAULT '',
  `gallery_folder` TEXT NOT NULL,
  `orderby` enum('datedesc','dateasc','titledesc','titleasc','position') default 'datedesc',
  `script_out` TEXT NOT NULL,
  `image_tpl` TEXT NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=cp1251;";

$modul_sql_install[] = "CREATE TABLE `CPPREFIX_modul_gallery_images` (
  `id` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `gallery_id` INT(10) UNSIGNED NOT NULL DEFAULT '0',
  `image_filename` VARCHAR(255) NOT NULL DEFAULT '',
  `image_author` MEDIUMINT(5) UNSIGNED NOT NULL DEFAULT '0',
  `image_title` VARCHAR(200) NOT NULL DEFAULT '',
  `image_description` TEXT NOT NULL,
  `image_file_ext` VARCHAR(6) NOT NULL DEFAULT '',
  `image_date` INT(14) UNSIGNED NOT NULL DEFAULT '0',
  `image_position` INT(5) UNSIGNED NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  KEY `image_date` (`image_date`),
  KEY `image_position` (`image_position`)
) ENGINE=MyISAM DEFAULT CHARSET=cp1251;";


$modul_sql_deinstall[] = "DROP TABLE IF EXISTS CPPREFIX_modul_gallery;";
$modul_sql_deinstall[] = "DROP TABLE IF EXISTS CPPREFIX_modul_gallery_images;";


$modul_sql_update[] = "UPDATE CPPREFIX_module SET Version = '" . $modul['ModulVersion'] . "' WHERE ModulName = '" . $modul['ModulName'] . "';" ;

if ($modul['ModulVersion'] < '2.1')
{
	$modul_sql_update[] = "UPDATE CPPREFIX_module SET CpEngineTag = '\\\[mod_gallery:([\\\d-]*)]' WHERE ModulName = '" . $modul['ModulName'] . "' LIMIT 1;";
	$modul_sql_update[] = "UPDATE CPPREFIX_module SET CpPHPTag = '<?php mod_gallery(''$1''); ?>' WHERE ModulName = '" . $modul['ModulName'] . "' LIMIT 1;";

	$modul_sql_update[] = "ALTER TABLE `CPPREFIX_modul_gallery` CHANGE `Id` `id` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT;";
	$modul_sql_update[] = "ALTER TABLE `CPPREFIX_modul_gallery` CHANGE `GName` `gallery_title` VARCHAR(255) DEFAULT '' NOT NULL;";
	$modul_sql_update[] = "ALTER TABLE `CPPREFIX_modul_gallery` CHANGE `Beschreibung` `gallery_description` TEXT DEFAULT '' NOT NULL;";
	$modul_sql_update[] = "ALTER TABLE `CPPREFIX_modul_gallery` CHANGE `Author` `gallery_author` MEDIUMINT(5) UNSIGNED DEFAULT '0' NOT NULL;";
	$modul_sql_update[] = "ALTER TABLE `CPPREFIX_modul_gallery` CHANGE `Erstellt` `gallery_date` INT(14) UNSIGNED DEFAULT '0' NOT NULL;";
	$modul_sql_update[] = "ALTER TABLE `CPPREFIX_modul_gallery` CHANGE `ThumbBreite` `thumb_width` MEDIUMINT(4) UNSIGNED DEFAULT '120' NOT NULL;";
	$modul_sql_update[] = "ALTER TABLE `CPPREFIX_modul_gallery` CHANGE `MaxZeile` `image_on_line` SMALLINT(2) UNSIGNED DEFAULT '4' NOT NULL;";
	$modul_sql_update[] = "ALTER TABLE `CPPREFIX_modul_gallery` CHANGE `ZeigeTitel` `show_title` TINYINT(1) UNSIGNED DEFAULT '1' NOT NULL;";
	$modul_sql_update[] = "ALTER TABLE `CPPREFIX_modul_gallery` CHANGE `ZeigeBeschreibung` `show_description` TINYINT(1) UNSIGNED DEFAULT '1' NOT NULL;";
	$modul_sql_update[] = "ALTER TABLE `CPPREFIX_modul_gallery` CHANGE `ZeigeGroesse` `show_size` TINYINT(1) UNSIGNED DEFAULT '0' NOT NULL;";
	$modul_sql_update[] = "ALTER TABLE `CPPREFIX_modul_gallery` CHANGE `TypeOut` `type_out` TINYINT(1) UNSIGNED DEFAULT '4' NOT NULL:";
	$modul_sql_update[] = "ALTER TABLE `CPPREFIX_modul_gallery` CHANGE `MaxBilder` `image_on_page` MEDIUMINT(4) UNSIGNED DEFAULT '12' NOT NULL;";
	$modul_sql_update[] = "ALTER TABLE `CPPREFIX_modul_gallery` CHANGE `Watermark` `watermark` VARCHAR(255) DEFAULT '' NOT NULL;";
	$modul_sql_update[] = "ALTER TABLE `CPPREFIX_modul_gallery` CHANGE `GPfad` `gallery_folder` VARCHAR(255) DEFAULT '' NOT NULL;";
	$modul_sql_update[] = "ALTER TABLE `CPPREFIX_modul_gallery` ADD `orderby` ENUM('datedesc','dateasc','titledesc','titleasc','position') DEFAULT 'datedesc' NOT NULL;";
	$modul_sql_update[] = "ALTER TABLE `CPPREFIX_modul_gallery` ADD `script_out` TEXT DEFAULT '' NOT NULL;";
	$modul_sql_update[] = "ALTER TABLE `CPPREFIX_modul_gallery` ADD `image_tpl` TEXT DEFAULT '' NOT NULL;";

	$modul_sql_update[] = "ALTER TABLE `CPPREFIX_modul_gallery_images` CHANGE `Id` `id` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT;";
	$modul_sql_update[] = "ALTER TABLE `CPPREFIX_modul_gallery_images` CHANGE `GalId` `gallery_id` INT(10) UNSIGNED DEFAULT '0' NOT NULL;";
	$modul_sql_update[] = "ALTER TABLE `CPPREFIX_modul_gallery_images` CHANGE `Pfad` `image_filename` VARCHAR(255) DEFAULT '' NOT NULL;";
	$modul_sql_update[] = "ALTER TABLE `CPPREFIX_modul_gallery_images` CHANGE `Author` `image_author` MEDIUMINT(5) UNSIGNED DEFAULT '0' NOT NULL;";
	$modul_sql_update[] = "ALTER TABLE `CPPREFIX_modul_gallery_images` CHANGE `BildTitel` `image_title` VARCHAR(255) DEFAULT '' NOT NULL;";
	$modul_sql_update[] = "ALTER TABLE `CPPREFIX_modul_gallery_images` CHANGE `BildBeschr` `image_description` TEXT DEFAULT '' NOT NULL;";
	$modul_sql_update[] = "ALTER TABLE `CPPREFIX_modul_gallery_images` CHANGE `Endung` `image_file_ext` VARCHAR(4) DEFAULT '' NOT NULL;";
	$modul_sql_update[] = "ALTER TABLE `CPPREFIX_modul_gallery_images` CHANGE `Erstellt` `image_date` INT(14) UNSIGNED DEFAULT '0' NOT NULL;";
	$modul_sql_update[] = "ALTER TABLE `CPPREFIX_modul_gallery_images` ADD `image_position` INT(5) UNSIGNED DEFAULT '1' NOT NULL;";
	$modul_sql_update[] = "ALTER TABLE `CPPREFIX_modul_gallery_images` ADD INDEX (`image_position`);";
	$modul_sql_update[] = "ALTER TABLE `CPPREFIX_modul_gallery_images` ADD INDEX (`image_date`);";
	$modul_sql_update[] = "ALTER TABLE `CPPREFIX_modul_gallery_images` ADD INDEX (`image_title`);";
}

?>