CREATE TABLE `%%PRFX%%_countries` (
  `Id` mediumint(5) unsigned NOT NULL auto_increment,
  `country_code` char(2) NOT NULL default 'RU',
  `country_name` char(50) NOT NULL,
  `status` enum('1','2') NOT NULL default '2',
  `ist_eu` enum('1','2') NOT NULL default '2',
  PRIMARY KEY  (`Id`)
) ENGINE=MyISAM DEFAULT CHARSET=cp1251;#inst#

CREATE TABLE `%%PRFX%%_document_comments` (
  `Id` int(10) unsigned NOT NULL auto_increment,
  `document_id` int(10) unsigned NOT NULL default '0',
  `first_comment` enum('1','0') NOT NULL default '0',
  `title` varchar(255) NOT NULL,
  `comment_text` text NOT NULL,
  `author` varchar(50) NOT NULL,
  `published` int(10) unsigned NOT NULL,
  `status` enum('1','0') NOT NULL default '1',
  `author_email` varchar(100) NOT NULL,
  PRIMARY KEY  (`Id`)
) ENGINE=MyISAM DEFAULT CHARSET=cp1251;#inst#

CREATE TABLE `%%PRFX%%_document_fields` (
  `Id` int(10) unsigned NOT NULL auto_increment,
  `rubric_field_id` mediumint(5) unsigned NOT NULL default '0',
  `document_id` int(10) unsigned NOT NULL default '0',
  `field_value` longtext NOT NULL,
  `in_search` enum('1','0') NOT NULL default '1',
  PRIMARY KEY  (`Id`),
  KEY `document_id` (`document_id`),
  KEY `rubric_field_id` (`rubric_field_id`)
) ENGINE=MyISAM DEFAULT CHARSET=cp1251;#inst#

CREATE TABLE `%%PRFX%%_document_permissions` (
  `Id` mediumint(5) unsigned NOT NULL auto_increment,
  `rubric_id` smallint(3) unsigned NOT NULL,
  `user_group` smallint(3) unsigned NOT NULL,
  `permission` char(255) NOT NULL,
  PRIMARY KEY  (`Id`),
  KEY `rubric_id` (`rubric_id`)
) ENGINE=MyISAM DEFAULT CHARSET=cp1251;#inst#

CREATE TABLE `%%PRFX%%_documents` (
  `Id` int(10) unsigned NOT NULL auto_increment,
  `rubric_id` mediumint(5) unsigned NOT NULL default '0',
  `alias` varchar(255) NOT NULL,
  `title` varchar(255) NOT NULL,
  `published` int(10) unsigned NOT NULL default '0',
  `expire` int(10) unsigned NOT NULL default '0',
  `changed` int(10) unsigned NOT NULL default '0',
  `author_id` mediumint(5) unsigned NOT NULL default '1',
  `in_search` enum('1','0') NOT NULL default '1',
  `meta_keywords` tinytext NOT NULL,
  `meta_description` tinytext NOT NULL,
  `meta_robots` enum('index,follow','index,nofollow','noindex,nofollow') NOT NULL default 'index,follow',
  `status` enum('1','0') NOT NULL default '1',
  `deleted` enum('0','1') NOT NULL default '0',
  `count_print` int(10) unsigned NOT NULL default '0',
  `count_view` int(10) unsigned NOT NULL default '0',
  `linked_navi_id` mediumint(5) unsigned NOT NULL default '0',
  PRIMARY KEY  (`Id`),
  UNIQUE KEY `alias` (`alias`),
  KEY `expire` (`expire`),
  KEY `published` (`published`),
  KEY `status` (`status`),
  KEY `rubric_id` (`rubric_id`)
) ENGINE=MyISAM DEFAULT CHARSET=cp1251;#inst#

CREATE TABLE `%%PRFX%%_log` (
  `Id` int(10) unsigned NOT NULL auto_increment,
  `log_time` int(10) NOT NULL default '0',
  `log_ip` varchar(25) NOT NULL,
  `log_url` varchar(255) NOT NULL,
  `log_text` text NOT NULL,
  `log_type` tinyint(1) unsigned NOT NULL default '2',
  `log_rubric` tinyint(1) unsigned NOT NULL default '2',
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
  `login_reg_type` enum('now','email','byadmin') NOT NULL default 'now',
  `login_spam_protect` enum('0','1') NOT NULL default '0',
  `login_status` enum('1','0') NOT NULL default '1',
  `login_deny_domain` text NOT NULL,
  `login_deny_email` text NOT NULL,
  `login_require_company` enum('0','1') NOT NULL default '0',
  `login_require_firstname` enum('0','1') NOT NULL default '0',
  `login_require_lastname` enum('0','1') NOT NULL default '0',
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
  `navi_titel` varchar(255) NOT NULL,
  `navi_level1` text NOT NULL,
  `navi_level2` text NOT NULL,
  `navi_level3` text NOT NULL,
  `navi_level1active` text NOT NULL,
  `navi_level2active` text NOT NULL,
  `navi_level3active` text NOT NULL,
  `navi_level1begin` text NOT NULL,
  `navi_level1end` text NOT NULL,
  `navi_level2begin` text NOT NULL,
  `navi_level2end` text NOT NULL,
  `navi_level3begin` text NOT NULL,
  `navi_level3end` text NOT NULL,
  `navi_begin` text NOT NULL,
  `navi_end` text NOT NULL,
  `navi_user_group` text NOT NULL,
  `navi_expand` enum('1','0') NOT NULL default '0',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=cp1251;#inst#

CREATE TABLE `%%PRFX%%_navigation_items` (
  `Id` mediumint(5) unsigned NOT NULL auto_increment,
  `title` char(255) NOT NULL,
  `parent_id` mediumint(5) unsigned NOT NULL,
  `navi_link` char(255) NOT NULL,
  `target` enum('_blank','_self','_parent','_top') NOT NULL default '_self',
  `level` enum('1','2','3') NOT NULL default '1',
  `position` smallint(3) unsigned NOT NULL default '1',
  `navi_id` smallint(3) unsigned NOT NULL default '0',
  `status` enum('1','0') NOT NULL default '1',
  `alias` char(255) NOT NULL,
  PRIMARY KEY  (`Id`),
  KEY `status` (`status`),
  KEY `navi_id` (`navi_id`),
  KEY `alias` (`alias`)
) ENGINE=MyISAM DEFAULT CHARSET=cp1251;#inst#

CREATE TABLE `%%PRFX%%_queries` (
  `Id` smallint(3) unsigned NOT NULL auto_increment,
  `rubric_id` smallint(3) unsigned NOT NULL,
  `items_on_page` int(10) NOT NULL,
  `title` varchar(255) NOT NULL,
  `Template` text NOT NULL,
  `AbGeruest` text NOT NULL,
  `order_by` varchar(255) NOT NULL,
  `Autor` int(10) unsigned NOT NULL default '1',
  `Erstellt` int(10) unsigned NOT NULL,
  `description` tinytext NOT NULL,
  `asc_desc` enum('ASC','DESC') NOT NULL default 'DESC',
  `show_pagination` enum('1','0') NOT NULL default '1',
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
  `rubric_id` smallint(3) unsigned NOT NULL,
  `title` varchar(255) NOT NULL,
  `RubTyp` varchar(75) NOT NULL,
  `rubric_position` smallint(3) unsigned NOT NULL default '1',
  `StdWert` text NOT NULL,
  `tpl_field` text NOT NULL,
  `tpl_req` text NOT NULL,
  PRIMARY KEY  (`Id`),
  KEY `rubric_id` (`rubric_id`)
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
  `user_group` smallint(3) unsigned NOT NULL auto_increment,
  `Name` char(50) NOT NULL,
  `status` enum('1','0') NOT NULL default '1',
  `set_default_avatar` enum('1','0') NOT NULL default '0',
  `default_avatar` char(255) NOT NULL,
  `permission` char(255) NOT NULL,
  PRIMARY KEY  (`user_group`)
) ENGINE=MyISAM DEFAULT CHARSET=cp1251;#inst#

CREATE TABLE `%%PRFX%%_users` (
  `Id` int(10) unsigned NOT NULL auto_increment,
  `password` char(32) NOT NULL,
  `email` char(100) NOT NULL,
  `street` char(100) NOT NULL,
  `street_nr` char(10) NOT NULL,
  `zipcode` char(15) NOT NULL,
  `city` char(100) NOT NULL,
  `phone` char(35) NOT NULL,
  `telefax` char(35) NOT NULL,
  `description` char(255) NOT NULL,
  `firstname` char(50) NOT NULL,
  `lastname` char(50) NOT NULL,
  `user_name` char(50) NOT NULL,
  `user_group` smallint(3) unsigned NOT NULL default '4',
  `user_group_extra` char(255) NOT NULL,
  `reg_time` int(10) unsigned NOT NULL,
  `Status` enum('1','0') NOT NULL default '1',
  `last_visit` int(10) unsigned NOT NULL,
  `country` char(2) NOT NULL default 'ru',
  `birthday` char(10) NOT NULL,
  `deleted` enum('1','0') NOT NULL default '0',
  `del_time` int(10) unsigned NOT NULL,
  `emc` char(32) NOT NULL,
  `reg_ip` char(20) NOT NULL,
  `new_pass` char(32) NOT NULL,
  `company` char(255) NOT NULL,
  `taxpay` enum('1','0') NOT NULL default '0',
  `salt` char(16) NOT NULL,
  `new_salt` char(16) NOT NULL,
  `user_ip` int(10) unsigned NOT NULL default '0',
  PRIMARY KEY  (`Id`),
  UNIQUE KEY `email` (`email`),
  UNIQUE KEY `user_name` (`user_name`),
  KEY `user_group` (`user_group`)
) ENGINE=MyISAM DEFAULT CHARSET=cp1251;
