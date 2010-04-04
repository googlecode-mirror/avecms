<?php

/**
 * AVE.cms - Модуль Контакты
 *
 * @package AVE.cms
 * @subpackage module_Contact
 * @filesource
 */

/**
 * mySQL-запросы для установки, обновления и удаления модуля
 */

$modul_sql_deinstall = array();
$modul_sql_install = array();
$modul_sql_update = array();

$modul_sql_deinstall[] = "DROP TABLE IF EXISTS CPPREFIX_modul_contacts;";
$modul_sql_deinstall[] = "DROP TABLE IF EXISTS CPPREFIX_modul_contact_fields;";
$modul_sql_deinstall[] = "DROP TABLE IF EXISTS CPPREFIX_modul_contact_info;";

$modul_sql_install[] = "DROP TABLE IF EXISTS CPPREFIX_modul_contacts;";
$modul_sql_install[] = "DROP TABLE IF EXISTS CPPREFIX_modul_contact_fields;";
$modul_sql_install[] = "DROP TABLE IF EXISTS CPPREFIX_modul_contact_info;";

$modul_sql_install[] = "CREATE TABLE CPPREFIX_modul_contacts (
  Id mediumint(5) unsigned NOT NULL auto_increment,
  form_name varchar(100) NOT NULL default '',
  form_mail_max_chars int(8) unsigned NOT NULL default '20000',
  form_receiver varchar(100) NOT NULL,
  form_receiver_multi varchar(255) NOT NULL,
  form_antispam tinyint(1) unsigned NOT NULL default '1',
  form_max_upload mediumint(5) unsigned NOT NULL default '500',
  form_show_subject tinyint(1) unsigned NOT NULL default '1',
  form_default_subject varchar(200) NOT NULL default 'Сообщение',
  form_allow_group varchar(255) NOT NULL default '1,2,3,4',
  form_send_copy tinyint(1) unsigned NOT NULL default '1',
  form_message_noaccess text NOT NULL,
  PRIMARY KEY  (Id)
) TYPE=MyISAM PACK_KEYS=0 DEFAULT CHARSET=cp1251;";

$modul_sql_install[] = "CREATE TABLE CPPREFIX_modul_contact_fields (
  Id int(10) unsigned NOT NULL auto_increment,
  form_id mediumint(5) unsigned NOT NULL default '0',
  field_type varchar(25) NOT NULL default 'text',
  field_position smallint(3) unsigned NOT NULL default '10',
  field_title tinytext NOT NULL,
  field_required tinyint(1) unsigned NOT NULL default '0',
  field_default tinytext NOT NULL,
  field_status tinyint(1) unsigned NOT NULL default '1',
  field_size int(4) unsigned default '300',
  field_newline tinyint(1) unsigned NOT NULL default '1',
  field_datatype enum('anysymbol','onlydecimal','onlychars') NOT NULL default 'anysymbol',
  field_maxchars varchar(20) NOT NULL,
  field_message varchar(255) NOT NULL,
  PRIMARY KEY  (Id)
) TYPE=MyISAM DEFAULT CHARSET=cp1251;";

$modul_sql_install[] = "CREATE TABLE CPPREFIX_modul_contact_info (
  Id int(10) unsigned NOT NULL auto_increment,
  form_num varchar(20) NOT NULL default '',
  form_id mediumint(5) unsigned NOT NULL default '0',
  in_date int(10) unsigned NOT NULL default '0',
  in_email varchar(255) NOT NULL default '',
  in_subject varchar(255) NOT NULL default '',
  in_message longtext NOT NULL,
  in_attachment tinytext NOT NULL,
  out_date int(10) unsigned NOT NULL default '0',
  out_email varchar(255) NOT NULL default '',
  out_sender varchar(255) NOT NULL default '',
  out_message longtext NOT NULL,
  out_attachment tinytext NOT NULL,
  PRIMARY KEY  (Id)
) TYPE=MyISAM DEFAULT CHARSET=cp1251;";

$modul_sql_install[] = "INSERT INTO CPPREFIX_modul_contacts VALUES ('1', 'Обратная связь', 5000, 'youremail@yourdomain.ru', '', '1', '120', '1', '', '1,2,3,4,5,6', '1', 'У вас недостаточно прав для использования этой формы.');";
$modul_sql_install[] = "INSERT INTO CPPREFIX_modul_contact_fields VALUES ('', '1', 'textfield', '5', 'Сообщение', '1', '', '1', '624', '1', '', '10,500', 'Пожалуйста, напишите сообщение длинной от 10 до 500 символов.');";
$modul_sql_install[] = "INSERT INTO CPPREFIX_modul_contact_fields VALUES ('', '1', 'dropdown', '10', 'Как вы оцените наш сайт?', '0', 'Плохой,Средне,Отличный', '1', '220', '1', '', '', 'Пожалуйста, оцените наш сайт.');";
$modul_sql_install[] = "INSERT INTO CPPREFIX_modul_contact_fields VALUES ('', '1', 'fileupload', '15', 'Прикрепить файл', '1', '', '1', '220', '1', '', '', 'Вы забыли прикрепить файл.');";
$modul_sql_install[] = "INSERT INTO CPPREFIX_modul_contact_fields VALUES ('', '1', 'fileupload', '20', 'Прикрепить файл', '0', '', '1', '220', '1', '', '', '');";

$modul_sql_update[] = "UPDATE CPPREFIX_module SET Version = '" . $modul['ModulVersion'] . "' WHERE ModulName = '" . $modul['ModulName'] . "';" ;
/*
$modul_sql_update[] = "ALTER TABLE CPPREFIX_modul_contact_info 
    CHANGE FormId      form_num       VARCHAR(20)  CHARACTER SET cp1251 COLLATE cp1251_general_ci NOT NULL, 
    CHANGE FId         form_id        MEDIUMINT(5)                           UNSIGNED DEFAULT '0' NOT NULL, 
    CHANGE Datum       in_date        INT(10)                                UNSIGNED DEFAULT '0' NOT NULL, 
    CHANGE Email       in_email       VARCHAR(255) CHARACTER SET cp1251 COLLATE cp1251_general_ci NOT NULL, 
    CHANGE Betreff     in_subject     VARCHAR(255) CHARACTER SET cp1251 COLLATE cp1251_general_ci NOT NULL, 
    CHANGE Text        in_message     LONGTEXT     CHARACTER SET cp1251 COLLATE cp1251_general_ci NOT NULL, 
    CHANGE Anhang      in_attachment  TEXT         CHARACTER SET cp1251 COLLATE cp1251_general_ci NOT NULL, 
    CHANGE Aw_Zeit     out_date       INT(10)                                UNSIGNED DEFAULT '0' NOT NULL, 
    CHANGE Aw_Email    out_email      VARCHAR(255) CHARACTER SET cp1251 COLLATE cp1251_general_ci NOT NULL, 
    CHANGE Aw_Absender out_sender     VARCHAR(255) CHARACTER SET cp1251 COLLATE cp1251_general_ci NOT NULL, 
    CHANGE Aw_Text     out_message    LONGTEXT     CHARACTER SET cp1251 COLLATE cp1251_general_ci NOT NULL, 
    CHANGE Aw_Anhang   out_attachment TEXT         CHARACTER SET cp1251 COLLATE cp1251_general_ci NOT NULL
    ";

$modul_sql_update[] = "ALTER TABLE CPPREFIX_modul_contact_fields 
    CHANGE KontaktId form_id        MEDIUMINT(5)                                       UNSIGNED DEFAULT '0'         NOT NULL,
    CHANGE Feld      field_type     VARCHAR(25)  CHARACTER SET cp1251 COLLATE cp1251_general_ci DEFAULT 'text'      NOT NULL,
    CHANGE Position  field_position SMALLINT(3)                                        UNSIGNED DEFAULT '10'        NOT NULL,
    CHANGE FeldTitel field_title    TINYTEXT     CHARACTER SET cp1251 COLLATE cp1251_general_ci                     NOT NULL,
    CHANGE Pflicht   field_required TINYINT(1)                                         UNSIGNED DEFAULT '0'         NOT NULL,
    CHANGE StdWert   field_default  LONGTEXT     CHARACTER SET cp1251 COLLATE cp1251_general_ci                     NOT NULL,
    CHANGE Aktiv     field_status   TINYINT(1)                                         UNSIGNED DEFAULT '1'         NOT NULL,
    CHANGE FieldSize field_size     INT(4)                                             UNSIGNED DEFAULT '300'       NOT NULL,
    CHANGE NewLine   field_newline  TINYINT(1)                                         UNSIGNED DEFAULT '1'         NOT NULL,
    CHANGE DataType  field_datatype ENUM('anysymbol','onlydecimal','onlychars')                 DEFAULT 'anysymbol' NOT NULL,
    CHANGE MaxChars  field_maxchars VARCHAR(20)  CHARACTER SET cp1251 COLLATE cp1251_general_ci                     NOT NULL,
    CHANGE ErrMsg    field_message  VARCHAR(255) CHARACTER SET cp1251 COLLATE cp1251_general_ci                     NOT NULL
    ";

$modul_sql_update[] = "ALTER TABLE CPPREFIX_modul_contacts 
    CHANGE `Name`           form_name             VARCHAR(100) CHARACTER SET cp1251 COLLATE cp1251_general_ci                     NOT NULL ,
    CHANGE MaxZeichen       form_mail_max_chars   INT(8)                                             UNSIGNED DEFAULT '20000'     NOT NULL ,
    CHANGE Empfaenger       form_receiver         VARCHAR(100) CHARACTER SET cp1251 COLLATE cp1251_general_ci                     NOT NULL ,
    CHANGE Empfaenger_Multi form_receiver_multi   VARCHAR(255) CHARACTER SET cp1251 COLLATE cp1251_general_ci                     NOT NULL ,
    CHANGE AntiSpam         form_antispam         TINYINT(1)                                         UNSIGNED DEFAULT '1'         NOT NULL ,
    CHANGE MaxUpload        form_max_upload       MEDIUMINT(5)                                       UNSIGNED DEFAULT '500'       NOT NULL ,
    CHANGE ZeigeBetreff     form_show_subject     TINYINT(1)                                         UNSIGNED DEFAULT '1'         NOT NULL ,
    CHANGE StandardBetreff  form_default_subject  VARCHAR(255) CHARACTER SET cp1251 COLLATE cp1251_general_ci DEFAULT 'Сообщение' NOT NULL ,
    CHANGE Gruppen          form_allow_group      VARCHAR(255) CHARACTER SET cp1251 COLLATE cp1251_general_ci DEFAULT '1,2,3,4'   NOT NULL ,
    CHANGE ZeigeKopie       form_send_copy        TINYINT(1)                                         UNSIGNED DEFAULT '1'         NOT NULL ,
    CHANGE TextKeinZugriff  form_message_noaccess TEXT         CHARACTER SET cp1251 COLLATE cp1251_general_ci                     NOT NULL
    ";
*/

?>