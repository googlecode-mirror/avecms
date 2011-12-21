<?php

/**
 * AVE.cms - Модуль Корзина
 *
 * @package AVE.cms
 * @subpackage module_Basket
 * @filesource
 */

/**
 * mySQL-запросы для установки, обновления и удаления модуля
 */

$modul_sql_install = array();
$modul_sql_deinstall = array();
$modul_sql_update = array();

$modul_sql_deinstall[] = "DROP TABLE IF EXISTS `CPPREFIX_modul_basket`;";

$modul_sql_install[] = "CREATE TABLE `CPPREFIX_modul_basket` (
  `id` int(11) NOT NULL auto_increment,
  `basket_session_id` varchar(50) default NULL,
  `basket_product_id` int(11) default NULL,
  `basket_product_name_id` int(11) default NULL,
  `basket_product_price_id` int(11) default NULL,
  `basket_product_quantity` smallint(5) default NULL,
  `basket_product_amount` float(10,2) default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;";

$modul_sql_update[] = "UPDATE CPPREFIX_module SET CpEngineTag = '" . $modul['CpEngineTag'] . "', CpPHPTag = '" . $modul['CpPHPTag'] . "', Version = '" . $modul['ModulVersion'] . "' WHERE ModulPfad = 'basket' LIMIT 1;";

?>