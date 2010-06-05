CREATE TABLE `%%PRFX%%_countries` (
  `Id` mediumint(5) unsigned NOT NULL auto_increment,
  `LandCode` char(2) NOT NULL default 'RU',
  `LandName` char(50) NOT NULL,
  `Aktiv` enum('1','2') NOT NULL default '2',
  `IstEU` enum('1','2') NOT NULL default '2',
  PRIMARY KEY  (`Id`)
) ENGINE=MyISAM DEFAULT CHARSET=cp1251;#inst#

CREATE TABLE `%%PRFX%%_document_comments` (
  `Id` int(10) unsigned NOT NULL auto_increment,
  `DokumentId` int(10) unsigned NOT NULL default '0',
  `KommentarStart` enum('1','0') NOT NULL default '0',
  `Titel` varchar(255) NOT NULL,
  `Kommentar` text NOT NULL,
  `Author` varchar(50) NOT NULL,
  `Zeit` int(10) unsigned NOT NULL,
  `Aktiv` enum('1','0') NOT NULL default '1',
  `AntwortEMail` varchar(100) NOT NULL,
  PRIMARY KEY  (`Id`)
) ENGINE=MyISAM DEFAULT CHARSET=cp1251;#inst#

CREATE TABLE `%%PRFX%%_document_fields` (
  `Id` int(10) unsigned NOT NULL auto_increment,
  `RubrikFeld` mediumint(5) unsigned NOT NULL default '0',
  `DokumentId` int(10) unsigned NOT NULL default '0',
  `Inhalt` longtext NOT NULL,
  `Suche` enum('1','0') NOT NULL default '1',
  PRIMARY KEY  (`Id`),
  KEY `DokumentId` (`DokumentId`),
  KEY `RubrikFeld` (`RubrikFeld`)
) ENGINE=MyISAM DEFAULT CHARSET=cp1251;#inst#

CREATE TABLE `%%PRFX%%_document_permissions` (
  `Id` mediumint(5) unsigned NOT NULL auto_increment,
  `RubrikId` smallint(3) unsigned NOT NULL,
  `BenutzerGruppe` smallint(3) unsigned NOT NULL,
  `Rechte` char(255) NOT NULL,
  PRIMARY KEY  (`Id`),
  KEY `RubrikId` (`RubrikId`)
) ENGINE=MyISAM DEFAULT CHARSET=cp1251;#inst#

CREATE TABLE `%%PRFX%%_documents` (
  `Id` int(10) unsigned NOT NULL auto_increment,
  `RubrikId` mediumint(5) unsigned NOT NULL default '0',
  `Url` varchar(255) NOT NULL,
  `Titel` varchar(255) NOT NULL,
  `DokStart` int(10) unsigned NOT NULL default '0',
  `DokEnde` int(10) unsigned NOT NULL default '0',
  `DokEdi` int(10) unsigned NOT NULL default '0',
  `Redakteur` mediumint(5) unsigned NOT NULL default '1',
  `Suche` enum('1','0') NOT NULL default '1',
  `MetaKeywords` tinytext NOT NULL,
  `MetaDescription` tinytext NOT NULL,
  `IndexFollow` enum('index,follow','index,nofollow','noindex,nofollow') NOT NULL default 'index,follow',
  `DokStatus` enum('1','0') NOT NULL default '1',
  `Geloescht` enum('0','1') NOT NULL default '0',
  `Drucke` int(10) unsigned NOT NULL default '0',
  `Geklickt` int(10) unsigned NOT NULL default '0',
  `ElterNavi` mediumint(5) unsigned NOT NULL default '0',
  PRIMARY KEY  (`Id`),
  UNIQUE KEY `Url` (`Url`),
  KEY `DokEnde` (`DokEnde`),
  KEY `DokStart` (`DokStart`),
  KEY `DokStatus` (`DokStatus`),
  KEY `RubrikId` (`RubrikId`)
) ENGINE=MyISAM DEFAULT CHARSET=cp1251;#inst#

CREATE TABLE `%%PRFX%%_log` (
  `Id` int(10) unsigned NOT NULL auto_increment,
  `Zeit` int(10) NOT NULL default '0',
  `IpCode` varchar(25) NOT NULL,
  `Seite` varchar(255) NOT NULL,
  `Meldung` text NOT NULL,
  `LogTyp` tinyint(1) unsigned NOT NULL default '2',
  `Rub` tinyint(1) unsigned NOT NULL default '2',
  PRIMARY KEY  (`Id`)
) ENGINE=MyISAM DEFAULT CHARSET=cp1251 PACK_KEYS=0;#inst#

CREATE TABLE `%%PRFX%%_modul_comment_info` (
  `Id` int(10) unsigned NOT NULL auto_increment,
  `parent_id` int(10) unsigned NOT NULL default '0',
  `document_id` int(10) unsigned NOT NULL default '0',
  `author_name` varchar(255) NOT NULL,
  `author_id` int(10) unsigned NOT NULL default '0',
  `author_email` varchar(255) NOT NULL,
  `author_city` varchar(255) NOT NULL,
  `author_website` varchar(255) NOT NULL,
  `author_ip` varchar(15) NOT NULL,
  `published` int(10) unsigned NOT NULL default '0',
  `edited` int(10) unsigned NOT NULL default '0',
  `message` text NOT NULL,
  `status` tinyint(1) unsigned NOT NULL default '1',
  `comments_close` tinyint(1) unsigned NOT NULL default '0',
  PRIMARY KEY  (`Id`),
  KEY `document_id` (`document_id`),
  KEY `parent_id` (`parent_id`),
  KEY `status` (`status`)
) ENGINE=MyISAM DEFAULT CHARSET=cp1251 PACK_KEYS=0;#inst#

CREATE TABLE `%%PRFX%%_modul_comments` (
  `Id` tinyint(1) unsigned NOT NULL auto_increment,
  `max_chars` smallint(3) unsigned NOT NULL default '1000',
  `user_groups` text NOT NULL,
  `moderate` enum('0','1') NOT NULL default '0',
  `active` enum('1','0') NOT NULL default '1',
  `spamprotect` enum('1','0') NOT NULL default '1',
  PRIMARY KEY  (`Id`)
) ENGINE=MyISAM DEFAULT CHARSET=cp1251;#inst#

CREATE TABLE `%%PRFX%%_modul_counter` (
  `id` smallint(3) unsigned NOT NULL auto_increment,
  `counter_name` char(50) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=cp1251;#inst#

CREATE TABLE `%%PRFX%%_modul_counter_info` (
  `id` int(11) unsigned NOT NULL auto_increment,
  `counter_id` smallint(3) unsigned NOT NULL,
  `client_ip` char(50) NOT NULL,
  `client_os` char(20) NOT NULL,
  `client_browser` char(20) NOT NULL,
  `client_referer` char(255) NOT NULL,
  `visit` int(10) unsigned NOT NULL,
  `expire` int(10) unsigned NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `expire` (`expire`,`counter_id`),
  KEY `counter_id` (`counter_id`)
) ENGINE=MyISAM DEFAULT CHARSET=cp1251;#inst#

CREATE TABLE `%%PRFX%%_modul_gallery` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `gallery_title` varchar(255) NOT NULL,
  `gallery_description` text NOT NULL,
  `gallery_author` int(10) unsigned NOT NULL default '0',
  `gallery_date` int(10) unsigned NOT NULL default '0',
  `thumb_width` smallint(3) unsigned NOT NULL default '120',
  `image_on_line` tinyint(1) unsigned NOT NULL default '4',
  `show_title` enum('1','0') NOT NULL default '1',
  `show_description` enum('1','0') NOT NULL default '1',
  `show_size` enum('0','1') NOT NULL default '0',
  `type_out` tinyint(1) unsigned NOT NULL default '4',
  `image_on_page` tinyint(1) unsigned NOT NULL default '12',
  `watermark` varchar(255) NOT NULL,
  `gallery_folder` varchar(255) NOT NULL,
  `orderby` enum('datedesc','dateasc','titleasc','titledesc','position') NOT NULL default 'datedesc',
  `script_out` text NOT NULL,
  `image_tpl` text NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=cp1251 PACK_KEYS=0;#inst#

CREATE TABLE `%%PRFX%%_modul_gallery_images` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `gallery_id` int(10) unsigned NOT NULL default '0',
  `image_filename` varchar(255) NOT NULL,
  `image_author` int(10) unsigned NOT NULL default '0',
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
) ENGINE=MyISAM DEFAULT CHARSET=cp1251 PACK_KEYS=0;#inst#

CREATE TABLE `%%PRFX%%_modul_login` (
  `Id` tinyint(1) unsigned NOT NULL auto_increment,
  `RegTyp` enum('now','email','byadmin') NOT NULL default 'now',
  `AntiSpam` enum('0','1') NOT NULL default '0',
  `IstAktiv` enum('1','0') NOT NULL default '1',
  `DomainsVerboten` text NOT NULL,
  `EmailsVerboten` text NOT NULL,
  `ZeigeFirma` enum('0','1') NOT NULL default '0',
  `ZeigeVorname` enum('0','1') NOT NULL default '0',
  `ZeigeNachname` enum('0','1') NOT NULL default '0',
  PRIMARY KEY  (`Id`)
) ENGINE=MyISAM DEFAULT CHARSET=cp1251;#inst#

CREATE TABLE `%%PRFX%%_modul_rss` (
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
) ENGINE=MyISAM DEFAULT CHARSET=cp1251;#inst#

CREATE TABLE `%%PRFX%%_modul_search` (
  `Id` int(10) unsigned NOT NULL auto_increment,
  `search_query` char(255) NOT NULL,
  `search_count` mediumint(5) unsigned NOT NULL default '0',
  `search_found` mediumint(5) unsigned NOT NULL default '0',
  PRIMARY KEY  (`Id`),
  UNIQUE KEY `search_query` (`search_query`)
) ENGINE=MyISAM DEFAULT CHARSET=cp1251 PACK_KEYS=0;#inst#

CREATE TABLE `%%PRFX%%_modul_sysblock` (
  `id` mediumint(5) unsigned NOT NULL auto_increment,
  `sysblock_name` varchar(255) NOT NULL,
  `sysblock_text` longtext NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=cp1251;#inst#

CREATE TABLE `%%PRFX%%_modul_who_is_online` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `ip` int(11) NOT NULL default '0',
  `country` char(64) NOT NULL default '',
  `countrycode` char(2) NOT NULL default '',
  `city` char(64) NOT NULL default '',
  `dt` timestamp NOT NULL default CURRENT_TIMESTAMP,
  PRIMARY KEY  (`id`),
  UNIQUE KEY `ip` (`ip`),
  KEY `countrycode` (`countrycode`)
) ENGINE=MyISAM DEFAULT CHARSET=cp1251;#inst#

CREATE TABLE `%%PRFX%%_module` (
  `Id` smallint(3) unsigned NOT NULL auto_increment,
  `ModulName` char(50) NOT NULL,
  `Status` enum('1','0') NOT NULL default '1',
  `CpEngineTag` char(255) NOT NULL,
  `CpPHPTag` char(255) NOT NULL,
  `ModulFunktion` char(255) NOT NULL,
  `IstFunktion` enum('1','0') NOT NULL default '1',
  `ModulPfad` char(50) NOT NULL,
  `Version` char(20) NOT NULL default '1.0',
  `Template` smallint(3) unsigned NOT NULL default '1',
  `AdminEdit` enum('0','1') NOT NULL default '0',
  PRIMARY KEY  (`Id`),
  UNIQUE KEY `ModulName` (`ModulName`)
) ENGINE=MyISAM DEFAULT CHARSET=cp1251;#inst#

CREATE TABLE `%%PRFX%%_navigation` (
  `id` smallint(3) unsigned NOT NULL auto_increment,
  `titel` varchar(255) NOT NULL,
  `ebene1` text NOT NULL,
  `ebene2` text NOT NULL,
  `ebene3` text NOT NULL,
  `ebene1a` text NOT NULL,
  `ebene2a` text NOT NULL,
  `ebene3a` text NOT NULL,
  `ebene1_v` text NOT NULL,
  `ebene1_n` text NOT NULL,
  `ebene2_v` text NOT NULL,
  `ebene2_n` text NOT NULL,
  `ebene3_v` text NOT NULL,
  `ebene3_n` text NOT NULL,
  `vor` text NOT NULL,
  `nach` text NOT NULL,
  `Gruppen` text NOT NULL,
  `Expand` enum('1','0') NOT NULL default '0',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=cp1251;#inst#

CREATE TABLE `%%PRFX%%_navigation_items` (
  `Id` mediumint(5) unsigned NOT NULL auto_increment,
  `Titel` char(255) NOT NULL,
  `Elter` mediumint(5) unsigned NOT NULL,
  `Link` char(255) NOT NULL,
  `Ziel` enum('_blank','_self','_parent','_top') NOT NULL default '_self',
  `Ebene` enum('1','2','3') NOT NULL default '1',
  `Rang` smallint(3) unsigned NOT NULL default '1',
  `Rubrik` smallint(3) unsigned NOT NULL default '0',
  `Aktiv` enum('1','0') NOT NULL default '1',
  `Url` char(255) NOT NULL,
  PRIMARY KEY  (`Id`),
  KEY `Aktiv` (`Aktiv`),
  KEY `Rubrik` (`Rubrik`),
  KEY `Url` (`Url`)
) ENGINE=MyISAM DEFAULT CHARSET=cp1251;#inst#

CREATE TABLE `%%PRFX%%_queries` (
  `Id` smallint(3) unsigned NOT NULL auto_increment,
  `RubrikId` smallint(3) unsigned NOT NULL,
  `Zahl` int(10) NOT NULL,
  `Titel` varchar(255) NOT NULL,
  `Template` text NOT NULL,
  `AbGeruest` text NOT NULL,
  `Sortierung` varchar(255) NOT NULL,
  `Autor` int(10) unsigned NOT NULL default '1',
  `Erstellt` int(10) unsigned NOT NULL,
  `Beschreibung` tinytext NOT NULL,
  `AscDesc` enum('ASC','DESC') NOT NULL default 'DESC',
  `Navi` enum('1','0') NOT NULL default '1',
  `where_cond` text NOT NULL,
  PRIMARY KEY  (`Id`)
) ENGINE=MyISAM DEFAULT CHARSET=cp1251;#inst#

CREATE TABLE `%%PRFX%%_queries_conditions` (
  `Id` mediumint(5) unsigned NOT NULL auto_increment,
  `Abfrage` smallint(3) unsigned NOT NULL,
  `Operator` char(30) NOT NULL,
  `Feld` int(10) NOT NULL,
  `Wert` char(255) NOT NULL,
  `Oper` enum('OR','AND') NOT NULL default 'OR',
  PRIMARY KEY  (`Id`)
) ENGINE=MyISAM DEFAULT CHARSET=cp1251;#inst#

CREATE TABLE `%%PRFX%%_rubric_fields` (
  `Id` mediumint(5) unsigned NOT NULL auto_increment,
  `RubrikId` smallint(3) unsigned NOT NULL,
  `Titel` varchar(255) NOT NULL,
  `RubTyp` varchar(75) NOT NULL,
  `rubric_position` smallint(3) unsigned NOT NULL default '1',
  `StdWert` text NOT NULL,
  `tpl_field` text NOT NULL,
  `tpl_req` text NOT NULL,
  PRIMARY KEY  (`Id`),
  KEY `RubrikId` (`RubrikId`)
) ENGINE=MyISAM DEFAULT CHARSET=cp1251;#inst#

CREATE TABLE `%%PRFX%%_rubric_template_cache` (
  `id` bigint(15) unsigned NOT NULL auto_increment,
  `hash` char(32) NOT NULL,
  `rub_id` smallint(3) NOT NULL,
  `grp_id` smallint(3) NOT NULL default '2',
  `doc_id` int(10) NOT NULL,
  `wysiwyg` enum('0','1') NOT NULL default '0',
  `expire` int(10) unsigned default '0',
  `compiled` longtext NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `rubric_id` (`rub_id`,`doc_id`,`wysiwyg`)
) ENGINE=MyISAM DEFAULT CHARSET=cp1251;#inst#

CREATE TABLE `%%PRFX%%_rubrics` (
  `Id` smallint(3) unsigned NOT NULL auto_increment,
  `RubrikName` varchar(255) NOT NULL,
  `UrlPrefix` varchar(255) NOT NULL,
  `RubrikTemplate` text NOT NULL,
  `Vorlage` smallint(3) unsigned NOT NULL default '1',
  `RBenutzer` int(10) unsigned NOT NULL default '1',
  `RDatum` int(10) unsigned NOT NULL default '0',
  PRIMARY KEY  (`Id`),
  KEY `Vorlage` (`Vorlage`)
) ENGINE=MyISAM DEFAULT CHARSET=cp1251;#inst#

CREATE TABLE `%%PRFX%%_sessions` (
  `sesskey` varchar(32) NOT NULL default '',
  `expiry` int(10) unsigned NOT NULL default '0',
  `value` text NOT NULL,
  `Ip` varchar(35) NOT NULL,
  `expire_datum` varchar(25) NOT NULL,
  PRIMARY KEY  (`sesskey`),
  KEY `expire_datum` (`expire_datum`),
  KEY `expiry` (`expiry`)
) ENGINE=MyISAM DEFAULT CHARSET=cp1251;#inst#

CREATE TABLE `%%PRFX%%_settings` (
  `Id` tinyint(1) unsigned NOT NULL auto_increment,
  `site_name` varchar(255) NOT NULL,
  `mail_type` enum('mail','smtp','sendmail') NOT NULL default 'mail',
  `mail_content_type` enum('text/plain','text/html') NOT NULL default 'text/plain',
  `mail_port` smallint(3) unsigned NOT NULL default '25',
  `mail_host` varchar(255) NOT NULL,
  `mail_smtp_login` varchar(50) NOT NULL,
  `mail_smtp_pass` varchar(50) NOT NULL,
  `mail_sendmail_path` varchar(255) NOT NULL default '/usr/sbin/sendmail',
  `mail_word_wrap` smallint(3) NOT NULL default '50',
  `mail_from` varchar(255) NOT NULL,
  `mail_from_name` varchar(255) NOT NULL,
  `mail_new_user` text NOT NULL,
  `mail_signature` text NOT NULL,
  `page_not_found_id` int(10) unsigned NOT NULL default '2',
  `message_forbidden` text NOT NULL,
  `navi_box` varchar(255) NOT NULL,
  `start_label` varchar(255) NOT NULL,
  `end_label` varchar(255) NOT NULL,
  `separator_label` varchar(255) NOT NULL,
  `next_label` varchar(255) NOT NULL,
  `prev_label` varchar(255) NOT NULL,
  `total_label` varchar(255) NOT NULL,
  `date_format` varchar(25) NOT NULL default '%d.%m.%Y',
  `time_format` varchar(25) NOT NULL default '%d.%m.%Y, %H:%M',
  `default_country` char(2) NOT NULL default 'ru',
  `use_doctime` enum('1','0') NOT NULL default '1',
  `hidden_text` text NOT NULL,
  PRIMARY KEY  (`Id`)
) ENGINE=MyISAM DEFAULT CHARSET=cp1251;#inst#

CREATE TABLE `%%PRFX%%_templates` (
  `Id` smallint(3) unsigned NOT NULL auto_increment,
  `TplName` varchar(255) NOT NULL,
  `Template` longtext NOT NULL,
  `TBenutzer` int(10) unsigned NOT NULL,
  `TDatum` int(10) unsigned NOT NULL,
  PRIMARY KEY  (`Id`)
) ENGINE=MyISAM DEFAULT CHARSET=cp1251;#inst#

CREATE TABLE `%%PRFX%%_user_groups` (
  `Benutzergruppe` smallint(3) unsigned NOT NULL auto_increment,
  `Name` char(50) NOT NULL,
  `Aktiv` enum('1','0') NOT NULL default '1',
  `set_default_avatar` enum('1','0') NOT NULL default '0',
  `default_avatar` char(255) NOT NULL,
  `Rechte` char(255) NOT NULL,
  PRIMARY KEY  (`Benutzergruppe`)
) ENGINE=MyISAM DEFAULT CHARSET=cp1251;#inst#

CREATE TABLE `%%PRFX%%_users` (
  `Id` int(10) unsigned NOT NULL auto_increment,
  `Kennwort` char(32) NOT NULL,
  `Email` char(100) NOT NULL,
  `Strasse` char(100) NOT NULL,
  `HausNr` char(10) NOT NULL,
  `Postleitzahl` char(15) NOT NULL,
  `city` char(100) NOT NULL,
  `Telefon` char(35) NOT NULL,
  `Telefax` char(35) NOT NULL,
  `Bemerkungen` char(255) NOT NULL,
  `Vorname` char(50) NOT NULL,
  `Nachname` char(50) NOT NULL,
  `UserName` char(50) NOT NULL,
  `Benutzergruppe` smallint(3) unsigned NOT NULL default '4',
  `BenutzergruppeMisc` char(255) NOT NULL,
  `Registriert` int(10) unsigned NOT NULL,
  `Status` enum('1','0') NOT NULL default '1',
  `ZuletztGesehen` int(10) unsigned NOT NULL,
  `Land` char(2) NOT NULL default 'ru',
  `GebTag` char(10) NOT NULL,
  `Geloescht` enum('1','0') NOT NULL default '0',
  `GeloeschtDatum` int(10) unsigned NOT NULL,
  `emc` char(32) NOT NULL,
  `IpReg` char(20) NOT NULL,
  `new_pass` char(32) NOT NULL,
  `Firma` char(255) NOT NULL,
  `UStPflichtig` enum('1','0') NOT NULL default '0',
  `salt` char(16) NOT NULL,
  `new_salt` char(16) NOT NULL,
  `user_ip` int(10) unsigned NOT NULL default '0',
  PRIMARY KEY  (`Id`),
  UNIQUE KEY `Email` (`Email`),
  UNIQUE KEY `UserName` (`UserName`),
  KEY `BenutzerGruppe` (`Benutzergruppe`)
) ENGINE=MyISAM DEFAULT CHARSET=cp1251;
