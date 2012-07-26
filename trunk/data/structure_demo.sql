CREATE TABLE `%%PRFX%%_antispam` (
  `Id` bigint(15) unsigned NOT NULL auto_increment,
  `Code` char(10) NOT NULL,
  `Ctime` int(10) unsigned NOT NULL default '0',
  PRIMARY KEY  (`Id`),
  UNIQUE KEY `Code` (`Code`),
  KEY `Ctime` (`Ctime`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;#inst#

CREATE TABLE `%%PRFX%%_countries` (
  `Id` mediumint(5) unsigned NOT NULL auto_increment,
  `country_code` char(2) NOT NULL default 'RU',
  `country_name` char(50) NOT NULL,
  `country_status` enum('1','2') NOT NULL default '2',
  `country_eu` enum('1','2') NOT NULL default '2',
  PRIMARY KEY  (`Id`)
) ENGINE=MyISAM AUTO_INCREMENT=238 DEFAULT CHARSET=utf8;#inst#

CREATE TABLE `%%PRFX%%_document_fields` (
  `Id` int(10) unsigned NOT NULL auto_increment,
  `rubric_field_id` mediumint(5) unsigned NOT NULL default '0',
  `document_id` int(10) unsigned NOT NULL default '0',
  `field_number_value` int(11) NOT NULL DEFAULT '0',
  `field_value` longtext NOT NULL,
  `document_in_search` enum('1','0') NOT NULL default '1',
  PRIMARY KEY  (`Id`),
  KEY `document_id` (`document_id`),
  KEY `rubric_field_id` (`rubric_field_id`,`document_in_search`)
) ENGINE=MyISAM AUTO_INCREMENT=100 DEFAULT CHARSET=utf8 PACK_KEYS=0;#inst#


CREATE TABLE `%%PRFX%%_document_remarks` (
  `Id` int(10) unsigned NOT NULL auto_increment,
  `document_id` int(10) unsigned NOT NULL default '0',
  `remark_first` enum('0','1') NOT NULL default '0',
  `remark_title` varchar(255) NOT NULL,
  `remark_text` text NOT NULL,
  `remark_author_id` int(10) unsigned NOT NULL default '1',
  `remark_published` int(10) unsigned NOT NULL default '0',
  `remark_status` enum('1','0') NOT NULL default '1',
  `remark_author_email` varchar(255) NOT NULL,
  PRIMARY KEY  (`Id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 PACK_KEYS=0;#inst#

CREATE TABLE `%%PRFX%%_documents` (
  `Id` int(10) unsigned NOT NULL auto_increment,
  `rubric_id` mediumint(5) unsigned NOT NULL default '0',
  `document_parent` int(10) unsigned NOT NULL default '0',
  `document_alias` varchar(255) NOT NULL,
  `document_title` varchar(255) NOT NULL,
  `document_published` int(10) unsigned NOT NULL default '0',
  `document_expire` int(10) unsigned NOT NULL default '0',
  `document_changed` int(10) unsigned NOT NULL default '0',
  `document_author_id` mediumint(5) unsigned NOT NULL default '1',
  `document_in_search` enum('1','0') NOT NULL default '1',
  `document_meta_keywords` tinytext NOT NULL,
  `document_meta_description` tinytext NOT NULL,
  `document_meta_robots` enum('index,follow','index,nofollow','noindex,nofollow') NOT NULL default 'index,follow',
  `document_status` enum('1','0') NOT NULL default '1',
  `document_deleted` enum('0','1') NOT NULL default '0',
  `document_count_print` int(10) unsigned NOT NULL default '0',
  `document_count_view` int(10) unsigned NOT NULL default '0',
  `document_linked_navi_id` mediumint(5) unsigned NOT NULL default '0',
  PRIMARY KEY  (`Id`),
  UNIQUE KEY `document_alias` (`document_alias`),
  KEY `rubric_id` (`rubric_id`),
  KEY `document_status` (`document_status`),
  KEY `document_published` (`document_published`),
  KEY `document_expire` (`document_expire`)
) ENGINE=MyISAM AUTO_INCREMENT=28 DEFAULT CHARSET=utf8 PACK_KEYS=0;#inst#

CREATE TABLE `%%PRFX%%_modul_banner_categories` (
  `Id` smallint(3) unsigned NOT NULL auto_increment,
  `banner_category_name` char(100) NOT NULL default '',
  PRIMARY KEY  (`Id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;#inst#

CREATE TABLE `%%PRFX%%_modul_basket` (
  `id` int(11) NOT NULL auto_increment,
  `basket_session_id` varchar(50) default NULL,
  `basket_product_id` int(11) default NULL,
  `basket_product_name_id` int(11) default NULL,
  `basket_product_price_id` int(11) default NULL,
  `basket_product_quantity` smallint(5) default NULL,
  `basket_product_amount` float(10,2) default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 PACK_KEYS=0;#inst#


CREATE TABLE `%%PRFX%%_modul_banners` (
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
  `banner_target` enum('_blank','_self') NOT NULL default '_blank',
  `banner_width` smallint(3) unsigned NOT NULL default '0',
  `banner_height` smallint(3) unsigned NOT NULL default '0',
  PRIMARY KEY  (`Id`),
  KEY `banner_category_id` (`banner_category_id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;#inst#

CREATE TABLE `%%PRFX%%_modul_contact_fields` (
  `Id` int(10) unsigned NOT NULL auto_increment,
  `contact_form_id` mediumint(5) unsigned NOT NULL default '0',
  `contact_field_type` varchar(25) NOT NULL default 'text',
  `contact_field_position` smallint(3) unsigned NOT NULL default '10',
  `contact_field_title` tinytext NOT NULL,
  `contact_field_required` enum('0','1') NOT NULL default '0',
  `contact_field_default` longtext NOT NULL,
  `contact_field_status` enum('1','0') NOT NULL default '1',
  `contact_field_size` smallint(3) unsigned NOT NULL default '300',
  `contact_field_newline` enum('1','0') NOT NULL default '1',
  `contact_field_datatype` enum('anysymbol','onlydecimal','onlychars') NOT NULL default 'anysymbol',
  `contact_field_max_chars` varchar(20) NOT NULL,
  `contact_field_value` varchar(255) NOT NULL,
  PRIMARY KEY  (`Id`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;#inst#

CREATE TABLE `%%PRFX%%_modul_contact_info` (
  `Id` int(10) unsigned NOT NULL auto_increment,
  `contact_form_number` varchar(20) NOT NULL,
  `contact_form_id` mediumint(5) unsigned NOT NULL default '0',
  `contact_form_in_date` int(10) unsigned NOT NULL default '0',
  `contact_form_in_email` varchar(255) NOT NULL,
  `contact_form_in_subject` varchar(255) NOT NULL,
  `contact_form_in_message` longtext NOT NULL,
  `contact_form_in_attachment` tinytext NOT NULL,
  `contact_form_out_date` int(10) unsigned NOT NULL default '0',
  `contact_form_out_email` varchar(255) NOT NULL,
  `contact_form_out_sender` varchar(255) NOT NULL,
  `contact_form_out_message` longtext NOT NULL,
  `contact_form_out_attachment` tinytext NOT NULL,
  PRIMARY KEY  (`Id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;#inst#

CREATE TABLE `%%PRFX%%_modul_contacts` (
  `Id` mediumint(5) unsigned NOT NULL auto_increment,
  `contact_form_title` varchar(100) NOT NULL,
  `contact_form_mail_max_chars` smallint(3) unsigned NOT NULL default '20000',
  `contact_form_reciever` varchar(100) default NULL,
  `contact_form_reciever_multi` varchar(255) default NULL,
  `contact_form_antispam` enum('1','0') NOT NULL default '1',
  `contact_form_max_upload` mediumint(5) unsigned NOT NULL default '500',
  `contact_form_subject_show` enum('1','0') NOT NULL default '1',
  `contact_form_subject_default` varchar(255) NOT NULL default 'Сообщение',
  `contact_form_allow_group` varchar(255) NOT NULL default '1,2,3,4',
  `contact_form_send_copy` enum('1','0') NOT NULL default '1',
  `contact_form_message_noaccess` text NOT NULL,
  PRIMARY KEY  (`Id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;#inst#

CREATE TABLE `%%PRFX%%_modul_comment_info` (
  `Id` int(10) unsigned NOT NULL auto_increment,
  `parent_id` int(10) unsigned NOT NULL default '0',
  `document_id` int(10) unsigned NOT NULL default '0',
  `comment_author_name` varchar(255) NOT NULL,
  `comment_author_id` int(10) unsigned NOT NULL default '0',
  `comment_author_email` varchar(255) NOT NULL,
  `comment_author_city` varchar(255) NOT NULL,
  `comment_author_website` varchar(255) NOT NULL,
  `comment_author_ip` varchar(15) NOT NULL,
  `comment_published` int(10) unsigned NOT NULL default '0',
  `comment_changed` int(10) unsigned NOT NULL default '0',
  `comment_text` text NOT NULL,
  `comment_status` tinyint(1) unsigned NOT NULL default '1',
  `comments_close` tinyint(1) unsigned NOT NULL default '0',
  PRIMARY KEY  (`Id`),
  KEY `document_id` (`document_id`),
  KEY `parent_id` (`parent_id`),
  KEY `status` (`comment_status`)
) ENGINE=MyISAM AUTO_INCREMENT=20 DEFAULT CHARSET=utf8 PACK_KEYS=0;#inst#

CREATE TABLE `%%PRFX%%_modul_comments` (
  `Id` tinyint(1) unsigned NOT NULL auto_increment,
  `comment_max_chars` smallint(3) unsigned NOT NULL default '1000',
  `comment_user_groups` char(255) NOT NULL,
  `comment_need_approve` enum('0','1') NOT NULL default '0',
  `comment_active` enum('1','0') NOT NULL default '1',
  `comment_use_antispam` enum('1','0') NOT NULL default '1',
  PRIMARY KEY  (`Id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;#inst#

CREATE TABLE `%%PRFX%%_modul_download_comments` (
  `Id` int(10) unsigned NOT NULL auto_increment,
  `FileId` int(10) unsigned NOT NULL default '0',
  `Datum` int(14) unsigned NOT NULL default '0',
  `title` varchar(100) NOT NULL,
  `comment_text` text NOT NULL,
  `Name` varchar(100) NOT NULL default '',
  `Email` varchar(100) NOT NULL default '',
  `Ip` varchar(200) NOT NULL default '',
  `Aktiv` tinyint(1) unsigned NOT NULL default '1',
  PRIMARY KEY  (`Id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;#inst#

CREATE TABLE `%%PRFX%%_modul_download_files` (
  `Id` int(10) unsigned NOT NULL auto_increment,
  `Autor` varchar(255) default NULL,
  `AutorUrl` varchar(255) default NULL,
  `Version` varchar(255) default NULL,
  `Sprache` varchar(255) default '1',
  `KatId` int(10) unsigned NOT NULL default '1',
  `Name` varchar(255) NOT NULL default '',
  `description` text NOT NULL,
  `Limitierung` text,
  `status` tinyint(1) unsigned NOT NULL default '1',
  `Methode` enum('ftp','http','local') NOT NULL default 'local',
  `Pfad` varchar(255) NOT NULL default '',
  `Downloads` int(10) unsigned NOT NULL default '0',
  `Groesse` int(14) unsigned NOT NULL default '0',
  `GroesseEinheit` enum('kb','mb') NOT NULL default 'kb',
  `Datum` int(14) unsigned NOT NULL default '0',
  `Geaendert` int(14) unsigned default NULL,
  `Os` varchar(255) NOT NULL default '1',
  `Lizenz` mediumint(2) default NULL,
  `Wertung` enum('1','2','3','4','5') NOT NULL default '5',
  `Wertungen_top` int(14) unsigned NOT NULL default '0',
  `Wertungen_flop` int(14) unsigned NOT NULL default '0',
  `Wertungen_ip` text NOT NULL,
  `Wertungen_ja` tinyint(1) unsigned NOT NULL default '1',
  `RegGebuehr` varchar(200) default NULL,
  `Mirrors` text,
  `Screenshot` varchar(255) default NULL,
  `Autor_Erstellt` int(14) unsigned NOT NULL default '1',
  `Autor_Geandert` int(10) unsigned NOT NULL default '1',
  `Kommentar_ja` int(10) unsigned NOT NULL default '1',
  `Downloads_Max` int(10) unsigned NOT NULL default '0',
  `Pay` varchar(10) default '0',
  `Pay_val` int(10) unsigned NOT NULL default '0',
  `Pay_Type` smallint(2) unsigned NOT NULL default '0',
  `Only_Pay` tinyint(1) unsigned NOT NULL default '1',
  `Excl_Pay` tinyint(1) unsigned NOT NULL default '0',
  `Excl_Chk` tinyint(1) unsigned NOT NULL default '0',
  PRIMARY KEY  (`Id`)
) ENGINE=MyISAM AUTO_INCREMENT=13 DEFAULT CHARSET=utf8;#inst#

CREATE TABLE `%%PRFX%%_modul_download_kat` (
  `Id` int(10) unsigned NOT NULL auto_increment,
  `parent_id` int(10) unsigned NOT NULL default '0',
  `KatName` varchar(255) NOT NULL default '',
  `position` int(8) unsigned NOT NULL default '1',
  `KatBeschreibung` text NOT NULL,
  `user_group` varchar(255) NOT NULL default '1|2|3|4|5|6',
  `Bild` varchar(200) default NULL,
  PRIMARY KEY  (`Id`)
) ENGINE=MyISAM AUTO_INCREMENT=32 DEFAULT CHARSET=utf8;#inst#

CREATE TABLE `%%PRFX%%_modul_download_lizenzen` (
  `Id` smallint(2) unsigned NOT NULL auto_increment,
  `Name` char(255) NOT NULL,
  PRIMARY KEY  (`Id`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;#inst#

CREATE TABLE `%%PRFX%%_modul_download_log` (
  `Id` int(14) unsigned NOT NULL auto_increment,
  `FileId` int(14) unsigned NOT NULL default '0',
  `Datum` char(10) NOT NULL,
  `Ip` char(100) NOT NULL,
  PRIMARY KEY  (`Id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;#inst#

CREATE TABLE `%%PRFX%%_modul_download_os` (
  `Id` int(10) unsigned NOT NULL auto_increment,
  `Name` char(200) NOT NULL,
  PRIMARY KEY  (`Id`)
) ENGINE=MyISAM AUTO_INCREMENT=18 DEFAULT CHARSET=utf8;#inst#

CREATE TABLE `%%PRFX%%_modul_download_payhistory` (
  `Id` int(10) unsigned NOT NULL auto_increment,
  `User_Id` int(10) unsigned NOT NULL default '0',
  `PayAmount` double(14,2) unsigned NOT NULL default '0.00',
  `File_Id` int(10) unsigned NOT NULL default '0',
  `PayDate` char(10) NOT NULL,
  `User_IP` char(15) NOT NULL,
  PRIMARY KEY  (`Id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;#inst#

CREATE TABLE `%%PRFX%%_modul_download_settings` (
  `Empfehlen` tinyint(1) unsigned NOT NULL default '1',
  `Bewerten` tinyint(1) unsigned NOT NULL default '0',
  `Spamwoerter` text NOT NULL,
  `Kommentare` tinyint(1) unsigned NOT NULL default '1'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;#inst#

CREATE TABLE `%%PRFX%%_modul_download_sprachen` (
  `Id` int(10) unsigned NOT NULL auto_increment,
  `Name` char(200) NOT NULL,
  PRIMARY KEY  (`Id`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;#inst#

CREATE TABLE `%%PRFX%%_modul_faq` (
  `id` mediumint(5) unsigned NOT NULL auto_increment,
  `faq_title` char(100) NOT NULL,
  `faq_description` char(255) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 PACK_KEYS=0;#inst#

CREATE TABLE `%%PRFX%%_modul_faq_quest` (
  `id` mediumint(5) unsigned NOT NULL auto_increment,
  `faq_quest` text NOT NULL,
  `faq_answer` text NOT NULL,
  `faq_id` mediumint(5) unsigned NOT NULL default '1',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 PACK_KEYS=0;#inst#

CREATE TABLE `%%PRFX%%_modul_forum_allowed_files` (
  `id` tinyint(3) unsigned NOT NULL auto_increment,
  `filetype` char(200) NOT NULL,
  `filesize` int(10) unsigned NOT NULL default '0',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=11 DEFAULT CHARSET=utf8;#inst#

CREATE TABLE `%%PRFX%%_modul_forum_attachment` (
  `id` mediumint(8) unsigned NOT NULL auto_increment,
  `orig_name` char(255) NOT NULL,
  `filename` char(255) NOT NULL,
  `hits` int(11) NOT NULL default '0',
  PRIMARY KEY  (`id`),
  KEY `filename` (`filename`),
  FULLTEXT KEY `filename_2` (`filename`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;#inst#

CREATE TABLE `%%PRFX%%_modul_forum_category` (
  `id` int(11) NOT NULL auto_increment,
  `title` varchar(200) NOT NULL default '',
  `position` smallint(5) unsigned NOT NULL default '0',
  `parent_id` smallint(5) unsigned default NULL,
  `comment` text,
  `group_id` text,
  PRIMARY KEY  (`id`),
  KEY `title` (`title`),
  KEY `position` (`position`),
  KEY `parent_id` (`parent_id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;#inst#

CREATE TABLE `%%PRFX%%_modul_forum_forum` (
  `id` int(11) unsigned NOT NULL auto_increment,
  `title` varchar(200) NOT NULL default '',
  `category_id` int(11) unsigned NOT NULL default '0',
  `statusicon` varchar(20) default NULL,
  `comment` text,
  `status` tinyint(1) default '0',
  `last_post` datetime default NULL,
  `last_post_id` int(11) NOT NULL default '0',
  `group_id` varchar(150) default NULL,
  `active` tinyint(3) unsigned NOT NULL default '0',
  `password` varchar(100) default NULL,
  `password_raw` varchar(255) NOT NULL default '',
  `moderator` int(11) default NULL,
  `position` smallint(6) default '0',
  `moderated` tinyint(1) NOT NULL default '0',
  `moderated_posts` tinyint(1) NOT NULL default '0',
  `topic_emails` text NOT NULL,
  `post_emails` text NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `title` (`title`),
  KEY `position` (`position`),
  KEY `group_id` (`group_id`),
  KEY `status` (`status`),
  KEY `category_id` (`category_id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;#inst#

CREATE TABLE `%%PRFX%%_modul_forum_groupavatar` (
  `Id` int(10) unsigned NOT NULL auto_increment,
  `user_group` int(10) unsigned NOT NULL default '0',
  `IstStandard` tinyint(1) unsigned NOT NULL default '1',
  `StandardAvatar` char(255) NOT NULL,
  PRIMARY KEY  (`Id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;#inst#

CREATE TABLE `%%PRFX%%_modul_forum_grouppermissions` (
  `Id` int(10) unsigned NOT NULL auto_increment,
  `user_group` int(10) unsigned NOT NULL default '0',
  `permission` text NOT NULL,
  `MAX_AVATAR_BYTES` int(8) unsigned NOT NULL default '10240',
  `MAX_AVATAR_HEIGHT` mediumint(3) unsigned NOT NULL default '90',
  `MAX_AVATAR_WIDTH` mediumint(3) unsigned NOT NULL default '90',
  `UPLOADAVATAR` tinyint(1) unsigned NOT NULL default '1',
  `MAXPN` mediumint(3) unsigned NOT NULL default '50',
  `MAXPNLENTH` int(8) unsigned NOT NULL default '5000',
  `MAXLENGTH_POST` int(8) unsigned NOT NULL default '10000',
  `MAXATTACHMENTS` smallint(2) unsigned NOT NULL default '5',
  `MAX_EDIT_PERIOD` smallint(4) unsigned NOT NULL default '672',
  PRIMARY KEY  (`Id`),
  UNIQUE KEY `Benutzergruppe` (`user_group`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 PACK_KEYS=0;#inst#

CREATE TABLE `%%PRFX%%_modul_forum_ignorelist` (
  `Id` int(14) unsigned NOT NULL auto_increment,
  `BenutzerId` int(14) unsigned NOT NULL default '0',
  `IgnoreId` int(10) unsigned NOT NULL default '0',
  `Grund` char(255) NOT NULL,
  `Datum` int(14) unsigned NOT NULL default '0',
  PRIMARY KEY  (`Id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;#inst#

CREATE TABLE `%%PRFX%%_modul_forum_mods` (
  `forum_id` int(11) NOT NULL default '0',
  `user_id` int(11) NOT NULL default '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;#inst#

CREATE TABLE `%%PRFX%%_modul_forum_permissions` (
  `forum_id` int(11) NOT NULL default '0',
  `group_id` int(11) NOT NULL default '0',
  `permissions` char(255) NOT NULL,
  PRIMARY KEY  (`forum_id`,`group_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;#inst#

CREATE TABLE `%%PRFX%%_modul_forum_pn` (
  `pnid` int(11) unsigned NOT NULL auto_increment,
  `to_uid` mediumint(8) unsigned default NULL,
  `from_uid` mediumint(8) unsigned default NULL,
  `topic` varchar(255) default NULL,
  `message` text,
  `is_readed` enum('yes','no') default NULL,
  `pntime` int(11) default '0',
  `typ` enum('inbox','outbox') default 'inbox',
  `smilies` enum('yes','no') NOT NULL default 'yes',
  `parseurl` enum('yes','no') NOT NULL default 'no',
  `reply` enum('yes','no') NOT NULL default 'no',
  `forward` enum('yes','no') NOT NULL default 'no',
  PRIMARY KEY  (`pnid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;#inst#

CREATE TABLE `%%PRFX%%_modul_forum_post` (
  `id` bigint(20) unsigned NOT NULL auto_increment,
  `title` varchar(200) default NULL,
  `topic_id` smallint(6) NOT NULL default '0',
  `datum` datetime NOT NULL default '0000-00-00 00:00:00',
  `uid` smallint(6) NOT NULL default '0',
  `use_bbcode` tinyint(1) NOT NULL default '0',
  `use_smilies` tinyint(1) NOT NULL default '0',
  `use_sig` tinyint(1) NOT NULL default '0',
  `message` text NOT NULL,
  `attachment` tinytext,
  `opened` tinyint(1) NOT NULL default '1',
  PRIMARY KEY  (`id`),
  KEY `title` (`title`),
  KEY `uid` (`uid`),
  KEY `topic_id` (`topic_id`),
  KEY `datum` (`datum`)
) ENGINE=MyISAM AUTO_INCREMENT=12 DEFAULT CHARSET=utf8;#inst#

CREATE TABLE `%%PRFX%%_modul_forum_posticons` (
  `id` int(11) NOT NULL auto_increment,
  `posi` mediumint(5) NOT NULL default '1',
  `active` tinyint(1) NOT NULL default '1',
  `path` char(55) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=15 DEFAULT CHARSET=utf8;#inst#

CREATE TABLE `%%PRFX%%_modul_forum_rank` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `title` char(100) NOT NULL,
  `count` int(11) NOT NULL default '0',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;#inst#

CREATE TABLE `%%PRFX%%_modul_forum_rating` (
  `topic_id` int(11) NOT NULL default '0',
  `rating` text NOT NULL,
  `ip` text NOT NULL,
  `uid` text NOT NULL,
  PRIMARY KEY  (`topic_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;#inst#

CREATE TABLE `%%PRFX%%_modul_forum_settings` (
  `boxwidthcomm` int(10) unsigned NOT NULL default '300',
  `boxwidthforums` int(10) unsigned NOT NULL default '300',
  `maxlengthword` int(10) unsigned NOT NULL default '50',
  `maxlines` int(10) unsigned NOT NULL default '15',
  `badwords` text,
  `badwords_replace` varchar(255) NOT NULL default '',
  `pageheader` text NOT NULL,
  `AbsenderMail` varchar(200) default NULL,
  `AbsenderName` varchar(200) default NULL,
  `SystemAvatars` tinyint(1) unsigned NOT NULL default '1',
  `BBCode` tinyint(1) unsigned NOT NULL default '1',
  `Smilies` tinyint(1) unsigned NOT NULL default '1',
  `Posticons` tinyint(1) unsigned NOT NULL default '1',
  UNIQUE KEY `boxwidthcomm` (`boxwidthcomm`),
  UNIQUE KEY `boxwidthforums` (`boxwidthforums`),
  UNIQUE KEY `maxlengthword` (`maxlengthword`),
  UNIQUE KEY `maxlines` (`maxlines`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;#inst#

CREATE TABLE `%%PRFX%%_modul_forum_smileys` (
  `id` int(11) NOT NULL auto_increment,
  `posi` mediumint(5) NOT NULL default '1',
  `active` enum('1','0') NOT NULL default '1',
  `code` char(15) NOT NULL,
  `path` char(55) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=14 DEFAULT CHARSET=utf8;#inst#

CREATE TABLE `%%PRFX%%_modul_forum_topic` (
  `id` int(11) NOT NULL auto_increment,
  `title` varchar(200) NOT NULL default '',
  `status` int(11) default '0',
  `views` int(11) NOT NULL default '0',
  `rating` text,
  `forum_id` int(11) NOT NULL default '0',
  `icon` smallint(5) unsigned default NULL,
  `posticon` smallint(5) unsigned default NULL,
  `datum` datetime NOT NULL default '0000-00-00 00:00:00',
  `replies` int(10) unsigned NOT NULL default '0',
  `uid` smallint(5) unsigned NOT NULL default '0',
  `notification` text NOT NULL,
  `type` tinyint(1) NOT NULL default '0',
  `last_post` datetime default NULL,
  `last_post_id` int(11) default NULL,
  `opened` tinyint(4) NOT NULL default '1',
  `last_post_int` int(14) NOT NULL default '0',
  PRIMARY KEY  (`id`),
  KEY `forum_id` (`forum_id`),
  KEY `opened` (`opened`),
  KEY `uid` (`uid`),
  KEY `title` (`title`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;#inst#

CREATE TABLE `%%PRFX%%_modul_forum_topic_read` (
  `Usr` int(11) NOT NULL default '0',
  `Topic` int(11) NOT NULL default '0',
  `ReadOn` timestamp NOT NULL default CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP,
  PRIMARY KEY  (`Usr`,`Topic`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;#inst#

CREATE TABLE `%%PRFX%%_modul_forum_useronline` (
  `ip` char(25) NOT NULL default '0',
  `uid` int(10) unsigned NOT NULL default '0',
  `expire` int(10) NOT NULL default '0',
  `uname` char(255) NOT NULL,
  `invisible` char(10) NOT NULL,
  UNIQUE KEY `ip` (`ip`),
  KEY `expire` (`expire`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;#inst#

CREATE TABLE `%%PRFX%%_modul_forum_userprofile` (
  `Id` int(14) unsigned NOT NULL auto_increment,
  `BenutzerId` int(14) unsigned NOT NULL default '0',
  `BenutzerName` varchar(200) default NULL,
  `BenutzerNameChanged` mediumint(3) unsigned default '0',
  `GroupIdMisc` text,
  `Beitraege` int(10) unsigned NOT NULL default '0',
  `ZeigeProfil` tinyint(1) unsigned NOT NULL default '1',
  `Signatur` tinytext,
  `Icq` varchar(150) default NULL,
  `Aim` varchar(150) default NULL,
  `Skype` varchar(150) default NULL,
  `Emailempfang` tinyint(1) unsigned NOT NULL default '1',
  `Pnempfang` tinyint(1) unsigned NOT NULL default '1',
  `Avatar` varchar(255) default NULL,
  `AvatarStandard` tinyint(1) NOT NULL default '1',
  `Webseite` varchar(255) default NULL,
  `Unsichtbar` tinyint(1) unsigned NOT NULL default '1',
  `Interessen` text,
  `Email` varchar(200) default NULL,
  `reg_time` int(10) unsigned NOT NULL default '0',
  `GeburtsTag` varchar(10) default NULL,
  `Email_show` tinyint(1) unsigned NOT NULL default '0',
  `Icq_show` tinyint(1) unsigned NOT NULL default '1',
  `Aim_show` tinyint(1) unsigned NOT NULL default '1',
  `Skype_show` tinyint(1) unsigned NOT NULL default '1',
  `Interessen_show` tinyint(1) unsigned NOT NULL default '1',
  `Signatur_show` tinyint(1) unsigned NOT NULL default '1',
  `GeburtsTag_show` tinyint(1) unsigned NOT NULL default '1',
  `Webseite_show` tinyint(1) unsigned NOT NULL default '1',
  `Geschlecht` enum('male','female') NOT NULL default 'male',
  PRIMARY KEY  (`Id`),
  UNIQUE KEY `BenutzerId` (`BenutzerId`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 PACK_KEYS=0;#inst#

CREATE TABLE `%%PRFX%%_modul_gallery` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `gallery_title` varchar(255) NOT NULL,
  `gallery_description` text NOT NULL,
  `gallery_author_id` int(10) unsigned NOT NULL default '1',
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
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 PACK_KEYS=0;#inst#

CREATE TABLE `%%PRFX%%_modul_gallery_images` (
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
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=utf8 PACK_KEYS=0;#inst#

CREATE TABLE `%%PRFX%%_modul_login` (
  `Id` tinyint(1) unsigned NOT NULL auto_increment,
  `login_reg_type` enum('now','email','byadmin') NOT NULL default 'now',
  `login_antispam` enum('0','1') NOT NULL default '0',
  `login_status` enum('1','0') NOT NULL default '1',
  `login_deny_domain` text NOT NULL,
  `login_deny_email` text NOT NULL,
  `login_require_company` enum('0','1') NOT NULL default '0',
  `login_require_firstname` enum('0','1') NOT NULL default '0',
  `login_require_lastname` enum('0','1') NOT NULL default '0',
  PRIMARY KEY  (`Id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;#inst#

CREATE TABLE `%%PRFX%%_modul_newsarchive` (
  `id` mediumint(5) unsigned NOT NULL auto_increment,
  `newsarchive_name` char(100) NOT NULL default '',
  `newsarchive_rubrics` char(255) NOT NULL default '',
  `newsarchive_show_days` enum('1','0') NOT NULL default '1',
  `newsarchive_show_empty` enum('1','0') NOT NULL default '1',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 PACK_KEYS=0;#inst#

CREATE TABLE `%%PRFX%%_modul_poll` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `poll_title` varchar(255) NOT NULL default '',
  `poll_status` enum('1','0') NOT NULL default '1',
  `poll_can_comment` enum('0','1') NOT NULL default '0',
  `poll_groups_id` tinytext,
  `poll_start` int(10) unsigned NOT NULL default '0',
  `poll_end` int(10) unsigned NOT NULL default '0',
  `poll_users_id` text NOT NULL,
  `poll_users_ip` text NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;#inst#

CREATE TABLE `%%PRFX%%_modul_poll_comments` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `poll_id` int(10) NOT NULL,
  `poll_comment_author_id` int(10) NOT NULL,
  `poll_comment_author_ip` text NOT NULL,
  `poll_comment_time` int(10) unsigned NOT NULL default '0',
  `poll_comment_title` varchar(250) NOT NULL default '',
  `poll_comment_text` text NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;#inst#

CREATE TABLE `%%PRFX%%_modul_poll_items` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `poll_id` int(10) NOT NULL,
  `poll_item_title` varchar(250) NOT NULL default '',
  `poll_item_hits` int(10) NOT NULL default '0',
  `poll_item_color` varchar(10) NOT NULL default '',
  `poll_item_position` int(2) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;#inst#

CREATE TABLE `%%PRFX%%_modul_search` (
  `Id` int(10) unsigned NOT NULL auto_increment,
  `search_query` char(255) NOT NULL,
  `search_count` mediumint(5) unsigned NOT NULL default '0',
  `search_found` mediumint(5) unsigned NOT NULL default '0',
  PRIMARY KEY  (`Id`),
  UNIQUE KEY `search_query` (`search_query`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 PACK_KEYS=0;#inst#

CREATE TABLE `%%PRFX%%_modul_shop` (
  `Id` tinyint(1) unsigned NOT NULL auto_increment,
  `status` enum('0','1') NOT NULL default '0',
  `Waehrung` varchar(10) NOT NULL default 'RUR',
  `WaehrungSymbol` varchar(10) NOT NULL default 'руб.',
  `Waehrung2` varchar(10) NOT NULL default 'EUR',
  `WaehrungSymbol2` varchar(10) NOT NULL default '&euro;',
  `Waehrung2Multi` decimal(10,4) NOT NULL default '1.0000',
  `ShopLand` char(2) NOT NULL default 'RU',
  `ArtikelMax` mediumint(3) unsigned NOT NULL default '10',
  `KaufLagerNull` tinyint(1) unsigned NOT NULL default '0',
  `VersandLaender` tinytext NOT NULL,
  `VersFrei` tinyint(1) unsigned NOT NULL default '0',
  `VersFreiBetrag` decimal(7,2) NOT NULL default '0.00',
  `GutscheinCodes` tinyint(1) unsigned NOT NULL default '1',
  `ZeigeEinheit` tinyint(1) unsigned NOT NULL default '1',
  `ZeigeNetto` tinyint(1) NOT NULL default '1',
  `KategorienStart` tinyint(1) unsigned NOT NULL default '1',
  `KategorienSons` tinyint(1) unsigned NOT NULL default '1',
  `ZufallsAngebot` tinyint(1) unsigned NOT NULL default '1',
  `ZufallsAngebotKat` tinyint(1) unsigned NOT NULL default '1',
  `BestUebersicht` tinyint(1) unsigned NOT NULL default '1',
  `Merkliste` tinyint(1) unsigned NOT NULL default '1',
  `Topseller` tinyint(1) unsigned NOT NULL default '1',
  `TemplateArtikel` varchar(100) NOT NULL default '',
  `Vorschaubilder` mediumint(3) NOT NULL default '80',
  `Topsellerbilder` mediumint(3) NOT NULL default '40',
  `GastBestellung` tinyint(1) unsigned default '0',
  `Kommentare` tinyint(1) unsigned default '1',
  `KommentareGast` tinyint(1) NOT NULL default '0',
  `ZeigeWaehrung2` tinyint(1) unsigned default '0',
  `ShopKeywords` varchar(255) default '',
  `ShopDescription` varchar(255) default '',
  `required_intro` tinyint(1) unsigned default '1',
  `required_desc` tinyint(1) unsigned default '1',
  `required_price` tinyint(1) unsigned default '1',
  `required_stock` tinyint(1) unsigned default '1',
  `company_name` varchar(255) default '',
  `custom` int(10) unsigned NOT NULL,
  `delivery` int(10) unsigned default '0',
  `delivery_local` int(10) unsigned default '0',
  `downloadable` int(10) unsigned default '0',
  `track_label` tinyint(1) unsigned default '0',
  `ShopWillkommen` text NOT NULL,
  `ShopFuss` text NOT NULL,
  `VersandInfo` text NOT NULL,
  `DatenschutzInf` text NOT NULL,
  `Impressum` text NOT NULL,
  `Agb` text NOT NULL,
  `AdresseText` text NOT NULL,
  `AdresseHTML` text NOT NULL,
  `Logo` varchar(255) NOT NULL default '',
  `EmailFormat` enum('text','html') NOT NULL default 'text',
  `AbsEmail` varchar(255) NOT NULL default '',
  `AbsName` varchar(255) NOT NULL default '',
  `EmpEmail` varchar(255) NOT NULL default '',
  `BetreffBest` varchar(255) NOT NULL default '',
  PRIMARY KEY  (`Id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;#inst#

CREATE TABLE `%%PRFX%%_modul_shop_artikel` (
  `Id` int(10) unsigned NOT NULL auto_increment,
  `ArtNr` varchar(200) NOT NULL,
  `KatId` int(10) unsigned NOT NULL default '0',
  `KatId_Multi` text NOT NULL,
  `ArtName` varchar(255) NOT NULL,
  `status` smallint(1) unsigned NOT NULL default '1',
  `Preis` decimal(10,2) NOT NULL default '0.00',
  `PreisListe` decimal(10,2) NOT NULL default '0.00',
  `Bild` varchar(255) NOT NULL,
  `Bild_Typ` varchar(10) NOT NULL default 'jpg',
  `Bilder` text NOT NULL,
  `TextKurz` text NOT NULL,
  `TextLang` text NOT NULL,
  `Gewicht` decimal(6,3) NOT NULL default '0.000',
  `Angebot` tinyint(1) unsigned NOT NULL default '0',
  `AngebotBild` varchar(255) NOT NULL,
  `UstZone` smallint(2) unsigned NOT NULL default '1',
  `Erschienen` int(14) unsigned NOT NULL default '0',
  `Frei_Titel_1` varchar(100) NOT NULL,
  `Frei_Text_1` text NOT NULL,
  `Frei_Titel_2` varchar(100) NOT NULL,
  `Frei_Text_2` text NOT NULL,
  `Frei_Titel_3` varchar(100) NOT NULL,
  `Frei_Text_3` text NOT NULL,
  `Frei_Titel_4` varchar(100) NOT NULL,
  `Frei_Text_4` text NOT NULL,
  `Hersteller` mediumint(5) NOT NULL,
  `Schlagwoerter` tinytext NOT NULL,
  `Einheit` decimal(7,2) NOT NULL default '0.00',
  `EinheitId` int(10) unsigned NOT NULL default '0',
  `Lager` int(10) unsigned NOT NULL default '0',
  `VersandZeitId` smallint(2) unsigned NOT NULL default '1',
  `Bestellungen` int(10) unsigned NOT NULL default '0',
  `DateiDownload` varchar(255) NOT NULL,
  `PosiStartseite` smallint(2) unsigned NOT NULL default '1',
  `ProdKeywords` varchar(255) NOT NULL default '',
  `ProdDescription` varchar(255) NOT NULL default '',
  `country_of_origin` varchar(255) NOT NULL default '',
  `bid` int(5) unsigned NOT NULL default '0',
  `cbid` int(5) unsigned NOT NULL default '0',
  PRIMARY KEY  (`Id`),
  UNIQUE KEY `ArtNr` (`ArtNr`),
  KEY `KatId` (`KatId`),
  KEY `ArtName` (`ArtName`),
  KEY `Hersteller` (`Hersteller`),
  KEY `Preis` (`Preis`),
  KEY `Erschienen` (`Erschienen`),
  KEY `Bestellungen` (`Bestellungen`),
  KEY `Angebot` (`Angebot`),
  FULLTEXT KEY `Schlagwoerter` (`Schlagwoerter`)
) ENGINE=MyISAM AUTO_INCREMENT=18 DEFAULT CHARSET=utf8 PACK_KEYS=0;#inst#

CREATE TABLE `%%PRFX%%_modul_shop_artikel_bilder` (
  `Id` int(10) unsigned NOT NULL auto_increment,
  `ArtId` int(10) unsigned NOT NULL default '0',
  `Bild` char(255) NOT NULL,
  PRIMARY KEY  (`Id`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 PACK_KEYS=0;#inst#

CREATE TABLE `%%PRFX%%_modul_shop_artikel_downloads` (
  `Id` int(10) unsigned NOT NULL auto_increment,
  `ArtId` varchar(255) NOT NULL,
  `Datei` varchar(255) NOT NULL,
  `DateiTyp` enum('full','update','bugfix','other') NOT NULL default 'full',
  `TageNachKauf` mediumint(5) NOT NULL default '365',
  `Bild` varchar(255) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `Position` mediumint(3) unsigned NOT NULL default '1',
  PRIMARY KEY  (`Id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;#inst#

CREATE TABLE `%%PRFX%%_modul_shop_artikel_kommentare` (
  `Id` int(8) unsigned NOT NULL auto_increment,
  `ArtId` int(10) unsigned NOT NULL default '0',
  `Benutzer` int(10) unsigned NOT NULL default '0',
  `Datum` int(14) unsigned NOT NULL default '0',
  `title` varchar(255) NOT NULL,
  `comment_text` text NOT NULL,
  `Wertung` smallint(1) unsigned NOT NULL default '0',
  `Publik` tinyint(1) unsigned NOT NULL default '0',
  PRIMARY KEY  (`Id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;#inst#


CREATE TABLE `%%PRFX%%_modul_shop_bestellungen` (
  `Id` int(14) unsigned NOT NULL auto_increment,
  `Benutzer` varchar(255) NOT NULL,
  `TransId` varchar(100) NOT NULL,
  `Datum` int(14) unsigned NOT NULL default '0',
  `Gesamt` decimal(7,2) NOT NULL default '0.00',
  `USt` decimal(7,2) NOT NULL default '0.00',
  `Artikel` text NOT NULL,
  `Artikel_Vars` text NOT NULL,
  `RechnungText` text NOT NULL,
  `RechnungHtml` text NOT NULL,
  `NachrichtBenutzer` text NOT NULL,
  `NachrichtAdmin` text NOT NULL,
  `Ip` varchar(200) NOT NULL,
  `ZahlungsId` mediumint(5) unsigned NOT NULL default '0',
  `VersandId` mediumint(5) unsigned NOT NULL default '0',
  `KamVon` tinytext NOT NULL,
  `Gutscheincode` int(10) default NULL,
  `Bestell_Email` varchar(255) NOT NULL,
  `Liefer_Firma` varchar(100) NOT NULL,
  `Liefer_Abteilung` varchar(100) NOT NULL,
  `Liefer_Vorname` varchar(100) NOT NULL,
  `Liefer_Nachname` varchar(100) NOT NULL,
  `Liefer_Strasse` varchar(100) NOT NULL,
  `Liefer_Hnr` varchar(10) NOT NULL,
  `Liefer_PLZ` varchar(15) NOT NULL,
  `Liefer_Ort` varchar(100) NOT NULL,
  `Liefer_Land` char(2) NOT NULL,
  `Rech_Firma` varchar(100) NOT NULL,
  `Rech_Abteilung` varchar(100) NOT NULL,
  `Rech_Vorname` varchar(100) NOT NULL,
  `Rech_Nachname` varchar(100) NOT NULL,
  `Rech_Strasse` varchar(100) NOT NULL,
  `Rech_Hnr` varchar(10) NOT NULL,
  `Rech_PLZ` varchar(15) NOT NULL,
  `Rech_Ort` varchar(100) NOT NULL,
  `Rech_Land` char(2) NOT NULL,
  `Status` enum('wait','progress','ok','ok_send','failed') NOT NULL default 'wait',
  `DatumBezahlt` int(10) unsigned NOT NULL default '0',
  PRIMARY KEY  (`Id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 PACK_KEYS=0;#inst#

CREATE TABLE `%%PRFX%%_modul_shop_downloads` (
  `Id` int(11) unsigned NOT NULL auto_increment,
  `Benutzer` int(11) NOT NULL default '0',
  `PName` varchar(255) NOT NULL,
  `ArtikelId` varchar(50) NOT NULL,
  `DownloadBis` int(11) NOT NULL default '0',
  `Lizenz` varchar(20) NOT NULL,
  `Downloads` int(11) NOT NULL default '0',
  `UrlLizenz` varchar(255) NOT NULL,
  `KommentarBenutzer` text NOT NULL,
  `KommentarAdmin` text NOT NULL,
  `Gesperrt` tinyint(1) NOT NULL default '0',
  `GesperrtGrund` text NOT NULL,
  `Position` smallint(2) NOT NULL default '1',
  PRIMARY KEY  (`Id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;#inst#

CREATE TABLE `%%PRFX%%_modul_shop_einheiten` (
  `Id` int(10) unsigned NOT NULL auto_increment,
  `Name` char(100) NOT NULL,
  `NameEinzahl` char(255) NOT NULL,
  PRIMARY KEY  (`Id`),
  UNIQUE KEY `Name` (`Name`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;#inst#

CREATE TABLE `%%PRFX%%_modul_shop_gutscheine` (
  `Id` int(10) unsigned NOT NULL auto_increment,
  `Code` varchar(100) NOT NULL,
  `Prozent` decimal(4,2) NOT NULL default '10.00',
  `Mehrfach` tinyint(1) unsigned NOT NULL default '1',
  `Benutzer` text NOT NULL,
  `Eingeloest` int(14) unsigned NOT NULL default '0',
  `BestellId` text NOT NULL,
  `GueltigVon` int(14) unsigned NOT NULL default '0',
  `GueltigBis` int(14) unsigned NOT NULL default '0',
  `AlleBenutzer` tinyint(1) unsigned NOT NULL default '0',
  PRIMARY KEY  (`Id`),
  UNIQUE KEY `Code` (`Code`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;#inst#

CREATE TABLE `%%PRFX%%_modul_shop_hersteller` (
  `Id` mediumint(5) unsigned NOT NULL auto_increment,
  `Name` char(255) NOT NULL,
  `Link` char(255) NOT NULL,
  `Logo` char(255) NOT NULL,
  PRIMARY KEY  (`Id`),
  UNIQUE KEY `Name` (`Name`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;#inst#

CREATE TABLE `%%PRFX%%_modul_shop_kategorie` (
  `Id` mediumint(5) unsigned NOT NULL auto_increment,
  `parent_id` mediumint(5) unsigned NOT NULL default '0',
  `KatName` varchar(100) NOT NULL,
  `KatBeschreibung` text NOT NULL,
  `position` smallint(3) unsigned NOT NULL default '1',
  `Bild` varchar(255) NOT NULL,
  `bid` int(5) unsigned NOT NULL default '0',
  `cbid` int(5) unsigned NOT NULL default '0',
  PRIMARY KEY  (`Id`,`parent_id`),
  KEY `KatName` (`KatName`)
) ENGINE=MyISAM AUTO_INCREMENT=29 DEFAULT CHARSET=utf8 PACK_KEYS=0;#inst#

CREATE TABLE `%%PRFX%%_modul_shop_kundenrabatte` (
  `Id` smallint(3) unsigned NOT NULL auto_increment,
  `GruppenId` smallint(3) unsigned NOT NULL default '0',
  `Wert` decimal(7,2) unsigned NOT NULL default '0.00',
  PRIMARY KEY  (`Id`),
  UNIQUE KEY `GruppenId` (`GruppenId`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;#inst#

CREATE TABLE `%%PRFX%%_modul_shop_merkliste` (
  `Id` int(10) unsigned NOT NULL auto_increment,
  `Benutzer` int(10) unsigned NOT NULL default '0',
  `Ip` varchar(200) NOT NULL,
  `Inhalt` text NOT NULL,
  `Inhalt_Vars` text NOT NULL,
  PRIMARY KEY  (`Id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;#inst#

CREATE TABLE `%%PRFX%%_modul_shop_staffelpreise` (
  `Id` int(10) unsigned NOT NULL auto_increment,
  `ArtId` int(10) unsigned NOT NULL default '0',
  `StkVon` mediumint(5) NOT NULL default '2',
  `StkBis` mediumint(5) NOT NULL default '5',
  `Preis` decimal(10,2) NOT NULL default '0.00',
  PRIMARY KEY  (`Id`),
  KEY `ArtId` (`ArtId`),
  KEY `Preis` (`Preis`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;#inst#

CREATE TABLE `%%PRFX%%_modul_shop_ust` (
  `Id` smallint(3) unsigned NOT NULL auto_increment,
  `Name` char(100) NOT NULL,
  `Wert` decimal(4,2) NOT NULL default '16.00',
  PRIMARY KEY  (`Id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;#inst#

CREATE TABLE `%%PRFX%%_modul_shop_varianten` (
  `Id` int(10) unsigned NOT NULL auto_increment,
  `KatId` int(10) unsigned NOT NULL default '0',
  `ArtId` int(10) unsigned NOT NULL default '0',
  `Name` char(255) NOT NULL,
  `Wert` decimal(7,2) NOT NULL default '0.00',
  `Operant` enum('+','-') NOT NULL default '+',
  `Position` smallint(3) unsigned NOT NULL default '1',
  `Vorselektiert` enum('0','1') NOT NULL default '0',
  PRIMARY KEY  (`Id`),
  KEY `KatId` (`KatId`),
  KEY `ArtId` (`ArtId`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;#inst#

CREATE TABLE `%%PRFX%%_modul_shop_varianten_kategorien` (
  `Id` int(10) unsigned NOT NULL auto_increment,
  `KatId` mediumint(5) unsigned NOT NULL default '0',
  `Name` varchar(200) NOT NULL,
  `description` text NOT NULL,
  `status` tinyint(1) unsigned NOT NULL default '1',
  PRIMARY KEY  (`Id`),
  KEY `KatId` (`KatId`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;#inst#

CREATE TABLE `%%PRFX%%_modul_shop_versandarten` (
  `Id` int(10) unsigned NOT NULL auto_increment,
  `Name` varchar(200) NOT NULL default '',
  `description` text NOT NULL,
  `Icon` varchar(255) NOT NULL default '',
  `LaenderVersand` tinytext NOT NULL,
  `Pauschalkosten` decimal(5,2) NOT NULL default '0.00',
  `KeineKosten` tinyint(1) unsigned NOT NULL default '0',
  `status` tinyint(1) unsigned NOT NULL default '0',
  `NurBeiGewichtNull` tinyint(1) unsigned NOT NULL default '0',
  `ErlaubteGruppen` tinytext NOT NULL,
  PRIMARY KEY  (`Id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;#inst#

CREATE TABLE `%%PRFX%%_modul_shop_versandkosten` (
  `Id` int(10) unsigned NOT NULL auto_increment,
  `VersandId` int(10) unsigned NOT NULL default '0',
  `country` char(2) NOT NULL default 'RU',
  `KVon` decimal(8,3) NOT NULL default '0.001',
  `KBis` decimal(8,3) NOT NULL default '10.000',
  `Betrag` decimal(7,2) NOT NULL default '0.00',
  PRIMARY KEY  (`Id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;#inst#

CREATE TABLE `%%PRFX%%_modul_shop_versandzeit` (
  `Id` smallint(2) unsigned NOT NULL auto_increment,
  `Name` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `Icon` varchar(255) NOT NULL,
  PRIMARY KEY  (`Id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;#inst#

CREATE TABLE `%%PRFX%%_modul_shop_zahlungsmethoden` (
  `Id` mediumint(5) unsigned NOT NULL auto_increment,
  `Name` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `ErlaubteVersandLaender` tinytext NOT NULL,
  `ErlaubteVersandarten` tinytext NOT NULL,
  `ErlaubteGruppen` tinytext NOT NULL,
  `status` tinyint(1) unsigned NOT NULL default '0',
  `Kosten` decimal(7,2) NOT NULL default '0.00',
  `KostenOperant` enum('Wert','%') NOT NULL default 'Wert',
  `InstId` varchar(100) NOT NULL,
  `Modus` int(10) unsigned default NULL,
  `ZahlungsBetreff` varchar(255) NOT NULL,
  `TestModus` varchar(10) NOT NULL,
  `Extern` tinyint(1) unsigned default NULL,
  `Gateway` varchar(100) default NULL,
  `Position` mediumint(5) unsigned NOT NULL default '0',
  PRIMARY KEY  (`Id`),
  UNIQUE KEY `Name` (`Name`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;#inst#

CREATE TABLE `%%PRFX%%_modul_sysblock` (
  `id` mediumint(5) unsigned NOT NULL auto_increment,
  `sysblock_name` varchar(255) NOT NULL,
  `sysblock_text` longtext NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=22 DEFAULT CHARSET=utf8 PACK_KEYS=0;#inst#

CREATE TABLE `%%PRFX%%_modul_who_is_online` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `ip` int(11) unsigned NOT NULL default '0',
  `country` char(64) NOT NULL default '',
  `countrycode` char(2) NOT NULL default '',
  `city` char(64) NOT NULL default '',
  `dt` timestamp NOT NULL default CURRENT_TIMESTAMP,
  PRIMARY KEY  (`id`),
  UNIQUE KEY `ip` (`ip`),
  KEY `countrycode` (`countrycode`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;#inst#

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
) ENGINE=MyISAM AUTO_INCREMENT=27 DEFAULT CHARSET=utf8 PACK_KEYS=0;#inst#

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
  `navi_expand` enum('0','1') NOT NULL default '0',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 PACK_KEYS=0;#inst#

CREATE TABLE `%%PRFX%%_navigation_items` (
  `Id` mediumint(5) unsigned NOT NULL auto_increment,
  `title` char(255) NOT NULL,
  `parent_id` mediumint(5) unsigned NOT NULL,
  `navi_item_link` char(255) NOT NULL,
  `navi_item_target` enum('_blank','_self','_parent','_top') NOT NULL default '_self',
  `navi_item_level` enum('1','2','3') NOT NULL default '1',
  `navi_item_position` smallint(3) unsigned NOT NULL default '1',
  `navi_id` smallint(3) unsigned NOT NULL default '0',
  `navi_item_status` enum('1','0') NOT NULL default '1',
  `document_alias` char(255) NOT NULL,
  PRIMARY KEY  (`Id`),
  KEY `navi_id` (`navi_id`),
  KEY `document_alias` (`document_alias`),
  KEY `navi_item_status` (`navi_item_status`)
) ENGINE=MyISAM AUTO_INCREMENT=20 DEFAULT CHARSET=utf8 PACK_KEYS=0;#inst#

CREATE TABLE `%%PRFX%%_request` (
  `Id` smallint(3) unsigned NOT NULL auto_increment,
  `rubric_id` smallint(3) unsigned NOT NULL,
  `request_items_per_page` smallint(3) unsigned NOT NULL,
  `request_title` varchar(255) NOT NULL,
  `request_template_item` text NOT NULL,
  `request_template_main` text NOT NULL,
  `request_order_by` varchar(255) NOT NULL,
  `request_order_by_nat` int(10) NOT NULL DEFAULT '0',
  `request_author_id` int(10) unsigned NOT NULL default '1',
  `request_created` int(10) unsigned NOT NULL,
  `request_description` tinytext NOT NULL,
  `request_asc_desc` enum('ASC','DESC') NOT NULL default 'DESC',
  `request_show_pagination` enum('0','1') NOT NULL default '0',
  `request_where_cond` text NOT NULL,
  `request_cache_lifetime` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY  (`Id`)
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=utf8 PACK_KEYS=0;#inst#

CREATE TABLE `%%PRFX%%_request_conditions` (
  `Id` mediumint(5) unsigned NOT NULL auto_increment,
  `request_id` smallint(3) unsigned NOT NULL,
  `condition_compare` char(30) NOT NULL,
  `condition_field_id` int(10) NOT NULL,
  `condition_value` char(255) NOT NULL,
  `condition_join` enum('OR','AND') NOT NULL default 'OR',
  PRIMARY KEY  (`Id`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 PACK_KEYS=0;#inst#

CREATE TABLE `%%PRFX%%_rubric_fields` (
  `Id` mediumint(5) unsigned NOT NULL auto_increment,
  `rubric_id` smallint(3) unsigned NOT NULL,
  `rubric_field_title` varchar(255) NOT NULL,
  `rubric_field_type` varchar(75) NOT NULL,
  `rubric_field_position` smallint(3) unsigned NOT NULL default '1',
  `rubric_field_default` text NOT NULL,
  `rubric_field_template` text NOT NULL,
  `rubric_field_template_request` text NOT NULL,
  PRIMARY KEY  (`Id`),
  KEY `rubric_id` (`rubric_id`),
  KEY `rubric_field_type` (`rubric_field_type`)
) ENGINE=MyISAM AUTO_INCREMENT=41 DEFAULT CHARSET=utf8 PACK_KEYS=0;#inst#

CREATE TABLE `%%PRFX%%_rubric_permissions` (
  `Id` mediumint(5) unsigned NOT NULL auto_increment,
  `rubric_id` smallint(3) unsigned NOT NULL,
  `user_group_id` smallint(3) unsigned NOT NULL,
  `rubric_permission` char(255) NOT NULL,
  PRIMARY KEY  (`Id`),
  KEY `rubric_id` (`rubric_id`)
) ENGINE=MyISAM AUTO_INCREMENT=21 DEFAULT CHARSET=utf8 PACK_KEYS=0;#inst#

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
) ENGINE=MyISAM DEFAULT CHARSET=utf8 PACK_KEYS=0;#inst#

CREATE TABLE `%%PRFX%%_rubrics` (
  `Id` smallint(3) unsigned NOT NULL auto_increment,
  `rubric_title` varchar(255) NOT NULL,
  `rubric_alias` varchar(255) NOT NULL,
  `rubric_template` text NOT NULL,
  `rubric_template_id` smallint(3) unsigned NOT NULL default '1',
  `rubric_author_id` int(10) unsigned NOT NULL default '1',
  `rubric_created` int(10) unsigned NOT NULL default '0',
  `rubric_docs_active` int(1) unsigned NOT NULL default '1',
  `rubric_code_start` text NOT NULL,
  `rubric_code_end` text NOT NULL,
  PRIMARY KEY  (`Id`),
  KEY `rubric_template_id` (`rubric_template_id`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 PACK_KEYS=0;#inst#

CREATE TABLE `%%PRFX%%_sessions` (
  `sesskey` varchar(32) NOT NULL,
  `expiry` int(10) unsigned NOT NULL default '0',
  `value` text NOT NULL,
  `Ip` varchar(35) NOT NULL,
  `expire_datum` varchar(25) NOT NULL,
  PRIMARY KEY  (`sesskey`),
  KEY `expiry` (`expiry`),
  KEY `expire_datum` (`expire_datum`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;#inst#

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
  `use_editor` int(1) unsigned NOT NULL default '0',
  `use_doctime` enum('1','0') NOT NULL default '1',
  `hidden_text` text NOT NULL,
  PRIMARY KEY  (`Id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;#inst#

CREATE TABLE `%%PRFX%%_templates` (
  `Id` smallint(3) unsigned NOT NULL auto_increment,
  `template_title` varchar(255) NOT NULL,
  `template_text` longtext NOT NULL,
  `template_author_id` int(10) unsigned NOT NULL default '1',
  `template_created` int(10) unsigned NOT NULL,
  PRIMARY KEY  (`Id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 PACK_KEYS=0;#inst#

CREATE TABLE `%%PRFX%%_user_groups` (
  `user_group` smallint(3) unsigned NOT NULL auto_increment,
  `user_group_name` char(50) NOT NULL,
  `status` enum('1','0') NOT NULL default '1',
  `set_default_avatar` enum('1','0') NOT NULL default '0',
  `default_avatar` char(255) NOT NULL,
  `user_group_permission` longtext NOT NULL,
  PRIMARY KEY  (`user_group`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;#inst#

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
  `status` enum('1','0') NOT NULL default '1',
  `last_visit` int(10) unsigned NOT NULL,
  `country` char(2) NOT NULL default 'ru',
  `birthday` char(10) NOT NULL,
  `deleted` enum('0','1') NOT NULL default '0',
  `del_time` int(10) unsigned NOT NULL,
  `emc` char(32) NOT NULL,
  `reg_ip` char(20) NOT NULL,
  `new_pass` char(32) NOT NULL,
  `company` char(255) NOT NULL,
  `taxpay` enum('0','1') NOT NULL default '0',
  `salt` char(16) NOT NULL,
  `new_salt` char(16) NOT NULL,
  `user_ip` int(10) unsigned NOT NULL default '0',
  PRIMARY KEY  (`Id`),
  UNIQUE KEY `email` (`email`),
  UNIQUE KEY `user_name` (`user_name`),
  KEY `user_group` (`user_group`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 PACK_KEYS=0;#inst#
