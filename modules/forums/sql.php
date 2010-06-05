<?php

$modul_sql_install = array();
$modul_sql_deinstall = array();
$modul_sql_update = array();

$modul_sql_deinstall[] = "DROP TABLE IF EXISTS CPPREFIX_modul_forum_userprofile;";
$modul_sql_deinstall[] = "DROP TABLE IF EXISTS CPPREFIX_modul_forum_useronline;";
$modul_sql_deinstall[] = "DROP TABLE IF EXISTS CPPREFIX_modul_forum_topic_read;";
$modul_sql_deinstall[] = "DROP TABLE IF EXISTS CPPREFIX_modul_forum_topic;";
$modul_sql_deinstall[] = "DROP TABLE IF EXISTS CPPREFIX_modul_forum_smileys;";
$modul_sql_deinstall[] = "DROP TABLE IF EXISTS CPPREFIX_modul_forum_settings;";
$modul_sql_deinstall[] = "DROP TABLE IF EXISTS CPPREFIX_modul_forum_rating;";
$modul_sql_deinstall[] = "DROP TABLE IF EXISTS CPPREFIX_modul_forum_rank;";
$modul_sql_deinstall[] = "DROP TABLE IF EXISTS CPPREFIX_modul_forum_posticons;";
$modul_sql_deinstall[] = "DROP TABLE IF EXISTS CPPREFIX_modul_forum_post;";
$modul_sql_deinstall[] = "DROP TABLE IF EXISTS CPPREFIX_modul_forum_pn;";
$modul_sql_deinstall[] = "DROP TABLE IF EXISTS CPPREFIX_modul_forum_permissions;";
$modul_sql_deinstall[] = "DROP TABLE IF EXISTS CPPREFIX_modul_forum_mods;";
$modul_sql_deinstall[] = "DROP TABLE IF EXISTS CPPREFIX_modul_forum_ignorelist;";
$modul_sql_deinstall[] = "DROP TABLE IF EXISTS CPPREFIX_modul_forum_grouppermissions;";
$modul_sql_deinstall[] = "DROP TABLE IF EXISTS CPPREFIX_modul_forum_groupavatar;";
$modul_sql_deinstall[] = "DROP TABLE IF EXISTS CPPREFIX_modul_forum_forum;";
$modul_sql_deinstall[] = "DROP TABLE IF EXISTS CPPREFIX_modul_forum_category;";
$modul_sql_deinstall[] = "DROP TABLE IF EXISTS CPPREFIX_modul_forum_attachment;";
$modul_sql_deinstall[] = "DROP TABLE IF EXISTS CPPREFIX_modul_forum_allowed_files;";


$modul_sql_install[] = "CREATE TABLE CPPREFIX_modul_forum_allowed_files (
  id tinyint(3) unsigned NOT NULL auto_increment,
  filetype varchar(200) NOT NULL default '',
  filesize int(10) unsigned NOT NULL default '0',
  PRIMARY KEY  (id)
) TYPE=MyISAM DEFAULT CHARSET=cp1251;";


$modul_sql_install[] = "INSERT INTO CPPREFIX_modul_forum_allowed_files VALUES ('', 'text/html', 250);";
$modul_sql_install[] = "INSERT INTO CPPREFIX_modul_forum_allowed_files VALUES ('', 'text/plain', 500);";
$modul_sql_install[] = "INSERT INTO CPPREFIX_modul_forum_allowed_files VALUES ('', 'image/jpeg', 500);";
$modul_sql_install[] = "INSERT INTO CPPREFIX_modul_forum_allowed_files VALUES ('', 'image/gif', 500);";
$modul_sql_install[] = "INSERT INTO CPPREFIX_modul_forum_allowed_files VALUES ('', 'application/x-zip-compressed', 500);";
$modul_sql_install[] = "INSERT INTO CPPREFIX_modul_forum_allowed_files VALUES ('', 'application/x-rar-compressed', 500);";
$modul_sql_install[] = "INSERT INTO CPPREFIX_modul_forum_allowed_files VALUES ('', 'application/postscript', 1024);";
$modul_sql_install[] = "INSERT INTO CPPREFIX_modul_forum_allowed_files VALUES ('', 'image/x-photoshop', 1024);";
$modul_sql_install[] = "INSERT INTO CPPREFIX_modul_forum_allowed_files VALUES ('', 'application/x-msdownload', 1024);";
$modul_sql_install[] = "INSERT INTO CPPREFIX_modul_forum_allowed_files VALUES ('', 'application/msword', 350);";

$modul_sql_install[] = "CREATE TABLE CPPREFIX_modul_forum_attachment (
  id mediumint(8) unsigned NOT NULL auto_increment,
  orig_name varchar(200) NOT NULL default '',
  filename varchar(200) NOT NULL default '',
  hits int(11) NOT NULL default '0',
  PRIMARY KEY  (id),
  KEY filename (filename),
  FULLTEXT KEY filename_2 (filename)
) TYPE=MyISAM DEFAULT CHARSET=cp1251;";

$modul_sql_install[] = "CREATE TABLE CPPREFIX_modul_forum_category (
  id int(11) NOT NULL auto_increment,
  title varchar(200) NOT NULL default '',
  position smallint(5) unsigned NOT NULL default '0',
  parent_id smallint(5) unsigned default NULL,
  `comment` text,
  group_id text,
  PRIMARY KEY  (id),
  KEY title (title),
  KEY position (position),
  KEY id (id),
  KEY title_3 (title),
  KEY id_2 (id),
  KEY title_4 (title),
  FULLTEXT KEY title_2 (title)
) TYPE=MyISAM DEFAULT CHARSET=cp1251;";

$modul_sql_install[] = "CREATE TABLE CPPREFIX_modul_forum_forum (
  id int(11) unsigned NOT NULL auto_increment,
  title varchar(200) NOT NULL default '',
  category_id int(11) unsigned NOT NULL default '0',
  statusicon varchar(20) default NULL,
  `comment` text,
  `status` tinyint(1) default '0',
  last_post datetime default NULL,
  last_post_id int(11) NOT NULL default '0',
  group_id varchar(150) default NULL,
  active tinyint(3) unsigned NOT NULL default '0',
  `password` varchar(100) default NULL,
  password_raw varchar(255) NOT NULL default '',
  moderator int(11) default NULL,
  position smallint(6) default '0',
  moderated tinyint(1) NOT NULL default '0',
  moderated_posts tinyint(1) NOT NULL default '0',
  topic_emails text NOT NULL,
  post_emails text NOT NULL,
  PRIMARY KEY  (id),
  KEY title (title),
  KEY position (position),
  KEY group_id (group_id),
  KEY id (id),
  KEY title_3 (title),
  KEY `status` (`status`),
  KEY position_2 (position),
  KEY group_id_2 (group_id),
  KEY id_2 (id),
  KEY title_4 (title),
  KEY status_2 (`status`),
  KEY position_3 (position),
  FULLTEXT KEY title_2 (title)
) TYPE=MyISAM DEFAULT CHARSET=cp1251;";

$modul_sql_install[] = "CREATE TABLE CPPREFIX_modul_forum_groupavatar (
  Id int(10) unsigned NOT NULL auto_increment,
  Benutzergruppe int(10) unsigned NOT NULL default '0',
  IstStandard tinyint(1) unsigned NOT NULL default '1',
  StandardAvatar varchar(255) NOT NULL default '',
  PRIMARY KEY  (Id)
) TYPE=MyISAM DEFAULT CHARSET=cp1251;";

$modul_sql_install[] = "INSERT INTO CPPREFIX_modul_forum_groupavatar VALUES (1, 1, 1, '');";
$modul_sql_install[] = "INSERT INTO CPPREFIX_modul_forum_groupavatar VALUES (2, 2, 1, '');";
$modul_sql_install[] = "INSERT INTO CPPREFIX_modul_forum_groupavatar VALUES (3, 3, 1, '');";
$modul_sql_install[] = "INSERT INTO CPPREFIX_modul_forum_groupavatar VALUES (4, 4, 1, '');";

$modul_sql_install[] = "CREATE TABLE CPPREFIX_modul_forum_grouppermissions (
  Id int(10) unsigned NOT NULL auto_increment,
  Benutzergruppe int(10) unsigned NOT NULL default '0',
  Rechte text,
  MAX_AVATAR_BYTES int(8) unsigned NOT NULL default '10240',
  MAX_AVATAR_HEIGHT mediumint(3) unsigned NOT NULL default '90',
  MAX_AVATAR_WIDTH mediumint(3) unsigned NOT NULL default '90',
  UPLOADAVATAR tinyint(1) unsigned NOT NULL default '1',
  MAXPN mediumint(3) unsigned NOT NULL default '50',
  MAXPNLENTH int(8) unsigned NOT NULL default '5000',
  MAXLENGTH_POST int(8) unsigned NOT NULL default '10000',
  MAXATTACHMENTS smallint(2) unsigned NOT NULL default '5',
  MAX_EDIT_PERIOD smallint(4) unsigned NOT NULL default '672',
  PRIMARY KEY  (Id),
  UNIQUE KEY Benutzergruppe (Benutzergruppe)
) TYPE=MyISAM DEFAULT CHARSET=cp1251;";

$modul_sql_install[] = "INSERT INTO CPPREFIX_modul_forum_grouppermissions VALUES (1, 1, 'own_avatar|canpn|accessforums|cansearch|last24|userprofile|changenick', 45056, 120, 120, 1, 100, 50000, 10000, 10, 1440);";
$modul_sql_install[] = "INSERT INTO CPPREFIX_modul_forum_grouppermissions VALUES (2, 2, 'accessforums|cansearch|last24|userprofile', 0, 0, 0, 1, 0, 0, 5000, 3, 0);";
$modul_sql_install[] = "INSERT INTO CPPREFIX_modul_forum_grouppermissions VALUES (3, 3, 'own_avatar|canpn|accessforums|cansearch|last24|userprofile', 10240, 90, 90, 1, 50, 5000, 10000, 5, 672);";
$modul_sql_install[] = "INSERT INTO CPPREFIX_modul_forum_grouppermissions VALUES (4, 4, 'own_avatar|canpn|accessforums|cansearch|last24|userprofile', 10240, 90, 90, 1, 50, 5000, 10000, 5, 672);";


$modul_sql_install[] = "CREATE TABLE CPPREFIX_modul_forum_ignorelist (
  Id int(14) unsigned NOT NULL auto_increment,
  BenutzerId int(14) unsigned NOT NULL default '0',
  IgnoreId int(10) unsigned NOT NULL default '0',
  Grund varchar(255) default NULL,
  Datum int(14) unsigned NOT NULL default '0',
  PRIMARY KEY  (Id)
) TYPE=MyISAM DEFAULT CHARSET=cp1251;";

$modul_sql_install[] = "CREATE TABLE CPPREFIX_modul_forum_mods (
  forum_id int(11) NOT NULL default '0',
  user_id int(11) NOT NULL default '0'
) TYPE=MyISAM DEFAULT CHARSET=cp1251;";

$modul_sql_install[] = "CREATE TABLE CPPREFIX_modul_forum_permissions (
  forum_id int(11) NOT NULL default '0',
  group_id int(11) NOT NULL default '0',
  permissions varchar(255) default NULL,
  PRIMARY KEY  (forum_id,group_id)
) TYPE=MyISAM DEFAULT CHARSET=cp1251;";

$modul_sql_install[] = "CREATE TABLE CPPREFIX_modul_forum_pn (
  pnid int(11) unsigned NOT NULL auto_increment,
  to_uid mediumint(8) unsigned default NULL,
  from_uid mediumint(8) unsigned default NULL,
  topic varchar(255) default NULL,
  message text,
  is_readed enum('yes','no') default NULL,
  pntime int(11) default '0',
  typ enum('inbox','outbox') default 'inbox',
  smilies enum('yes','no') NOT NULL default 'yes',
  parseurl enum('yes','no') NOT NULL default 'no',
  reply enum('yes','no') NOT NULL default 'no',
  forward enum('yes','no') NOT NULL default 'no',
  PRIMARY KEY  (pnid),
  KEY id (pnid)
) TYPE=MyISAM DEFAULT CHARSET=cp1251;";

$modul_sql_install[] = "CREATE TABLE CPPREFIX_modul_forum_post (
  id bigint(20) unsigned NOT NULL auto_increment,
  title varchar(200) default NULL,
  topic_id smallint(6) NOT NULL default '0',
  datum datetime NOT NULL default '0000-00-00 00:00:00',
  uid smallint(6) NOT NULL default '0',
  use_bbcode tinyint(1) NOT NULL default '0',
  use_smilies tinyint(1) NOT NULL default '0',
  use_sig tinyint(1) NOT NULL default '0',
  message text NOT NULL,
  attachment tinytext,
  opened tinyint(1) NOT NULL default '1',
  PRIMARY KEY  (id),
  KEY title (title),
  KEY topci_id (topic_id),
  KEY uid (uid),
  KEY id (id),
  KEY topic_id (topic_id),
  KEY datum (datum),
  KEY id_2 (id),
  KEY topic_id_2 (topic_id),
  KEY datum_2 (datum),
  FULLTEXT KEY title_2 (title)
) TYPE=MyISAM DEFAULT CHARSET=cp1251;";

$modul_sql_install[] = "CREATE TABLE CPPREFIX_modul_forum_posticons (
  id int(11) NOT NULL auto_increment,
  posi mediumint(5) NOT NULL default '1',
  active tinyint(1) NOT NULL default '1',
  path varchar(55) NOT NULL default '',
  PRIMARY KEY  (id)
) TYPE=MyISAM DEFAULT CHARSET=cp1251;";

$modul_sql_install[] = "INSERT INTO CPPREFIX_modul_forum_posticons VALUES (1, 1, 1, 'icon1.gif');";
$modul_sql_install[] = "INSERT INTO CPPREFIX_modul_forum_posticons VALUES (2, 2, 1, 'icon2.gif');";
$modul_sql_install[] = "INSERT INTO CPPREFIX_modul_forum_posticons VALUES (3, 14, 1, 'icon3.gif');";
$modul_sql_install[] = "INSERT INTO CPPREFIX_modul_forum_posticons VALUES (4, 3, 1, 'icon4.gif');";
$modul_sql_install[] = "INSERT INTO CPPREFIX_modul_forum_posticons VALUES (5, 13, 1, 'icon5.gif');";
$modul_sql_install[] = "INSERT INTO CPPREFIX_modul_forum_posticons VALUES (6, 12, 1, 'icon6.gif');";
$modul_sql_install[] = "INSERT INTO CPPREFIX_modul_forum_posticons VALUES (7, 11, 1, 'icon7.gif');";
$modul_sql_install[] = "INSERT INTO CPPREFIX_modul_forum_posticons VALUES (8, 10, 1, 'icon8.gif');";
$modul_sql_install[] = "INSERT INTO CPPREFIX_modul_forum_posticons VALUES (9, 9, 1, 'icon9.gif');";
$modul_sql_install[] = "INSERT INTO CPPREFIX_modul_forum_posticons VALUES (10, 8, 1, 'icon10.gif');";
$modul_sql_install[] = "INSERT INTO CPPREFIX_modul_forum_posticons VALUES (11, 7, 1, 'icon11.gif');";
$modul_sql_install[] = "INSERT INTO CPPREFIX_modul_forum_posticons VALUES (12, 6, 1, 'icon12.gif');";
$modul_sql_install[] = "INSERT INTO CPPREFIX_modul_forum_posticons VALUES (13, 5, 2, 'icon13.gif');";
$modul_sql_install[] = "INSERT INTO CPPREFIX_modul_forum_posticons VALUES (14, 4, 2, 'icon14.gif');";

$modul_sql_install[] = "CREATE TABLE CPPREFIX_modul_forum_rank (
  id int(10) unsigned NOT NULL auto_increment,
  title varchar(100) NOT NULL default '',
  count int(11) NOT NULL default '0',
  PRIMARY KEY  (id)
) TYPE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=cp1251;";

$modul_sql_install[] = "INSERT INTO CPPREFIX_modul_forum_rank VALUES (1, 'Новичок', 1);";
$modul_sql_install[] = "INSERT INTO CPPREFIX_modul_forum_rank VALUES (2, 'Иногда пишет', 100);";
$modul_sql_install[] = "INSERT INTO CPPREFIX_modul_forum_rank VALUES (3, 'Советник', 600);";
$modul_sql_install[] = "INSERT INTO CPPREFIX_modul_forum_rank VALUES (4, 'Эксперт', 1000);";
$modul_sql_install[] = "INSERT INTO CPPREFIX_modul_forum_rank VALUES (5, 'Живет здесь', 5000);";
$modul_sql_install[] = "INSERT INTO CPPREFIX_modul_forum_rank VALUES (6, 'Писатель', 200);";

$modul_sql_install[] = "CREATE TABLE CPPREFIX_modul_forum_rating (
  topic_id int(11) NOT NULL default '0',
  rating text NOT NULL,
  ip text NOT NULL,
  uid text NOT NULL,
  PRIMARY KEY  (topic_id)
) TYPE=MyISAM DEFAULT CHARSET=cp1251;";

$modul_sql_install[] = "CREATE TABLE CPPREFIX_modul_forum_settings (
  boxwidthcomm int(10) unsigned NOT NULL default '300',
  boxwidthforums int(10) unsigned NOT NULL default '300',
  maxlengthword int(10) unsigned NOT NULL default '50',
  maxlines int(10) unsigned NOT NULL default '15',
  badwords text,
  badwords_replace varchar(255) NOT NULL default '',
  pageheader text NOT NULL,
  AbsenderMail varchar(200) default NULL,
  AbsenderName varchar(200) default NULL,
  SystemAvatars tinyint(1) unsigned NOT NULL default '1',
  BBCode tinyint(1) unsigned NOT NULL default '1',
  Smilies tinyint(1) unsigned NOT NULL default '1',
  Posticons tinyint(1) unsigned NOT NULL default '1',
  UNIQUE KEY boxwidthcomm (boxwidthcomm),
  UNIQUE KEY boxwidthforums (boxwidthforums),
  UNIQUE KEY maxlengthword (maxlengthword),
  UNIQUE KEY maxlines (maxlines)
) TYPE=MyISAM DEFAULT CHARSET=cp1251;";

$modul_sql_install[] = "INSERT INTO CPPREFIX_modul_forum_settings VALUES (300, 300, 50, 150, 'Arschloch,Ficken,Drecksau', '***', '<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.0 Transitional//EN\" \"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd\">\r\n<html xmlns=\"http://www.w3.org/1999/xhtml\">\r\n<head>\r\n<meta http-equiv=\"Content-Type\" content=\"text/html; charset=windows-1251\" />', '" . $_SESSION['user_email'] . "', '" . $_SESSION['user_name'] . "', 1, 1, 1, 1);";

$modul_sql_install[] = "CREATE TABLE CPPREFIX_modul_forum_smileys (
  id int(11) NOT NULL auto_increment,
  posi mediumint(5) NOT NULL default '1',
  active tinyint(1) NOT NULL default '1',
  code varchar(15) NOT NULL default '',
  path varchar(55) NOT NULL default '',
  PRIMARY KEY  (id)
) TYPE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=cp1251;";

$modul_sql_install[] = "INSERT INTO CPPREFIX_modul_forum_smileys VALUES ('', 14, 1, ';)', 'wink.gif');";
$modul_sql_install[] = "INSERT INTO CPPREFIX_modul_forum_smileys VALUES ('', 13, 1, ':eek:', 'eek.gif');";
$modul_sql_install[] = "INSERT INTO CPPREFIX_modul_forum_smileys VALUES ('', 15, 1, ':(', 'mad.gif');";
$modul_sql_install[] = "INSERT INTO CPPREFIX_modul_forum_smileys VALUES ('', 12, 1, ':D', 'biggrin.gif');";
$modul_sql_install[] = "INSERT INTO CPPREFIX_modul_forum_smileys VALUES ('', 11, 1, ':P', 'tongue.gif');";
$modul_sql_install[] = "INSERT INTO CPPREFIX_modul_forum_smileys VALUES ('', 9, 1, ':cool:', 'cool.gif');";
$modul_sql_install[] = "INSERT INTO CPPREFIX_modul_forum_smileys VALUES ('', 8, 1, ':kisses:', 'kisses.gif');";
$modul_sql_install[] = "INSERT INTO CPPREFIX_modul_forum_smileys VALUES ('', 7, 1, ':rolleyes:', 'rolleyes.gif');";
$modul_sql_install[] = "INSERT INTO CPPREFIX_modul_forum_smileys VALUES ('', 6, 2, ':schlecht:', 'schlecht.gif');";
$modul_sql_install[] = "INSERT INTO CPPREFIX_modul_forum_smileys VALUES ('', 5, 2, ':unsicher:', 'unsure.gif');";
$modul_sql_install[] = "INSERT INTO CPPREFIX_modul_forum_smileys VALUES ('', 3, 1, ':)', 'smile.gif');";
$modul_sql_install[] = "INSERT INTO CPPREFIX_modul_forum_smileys VALUES ('', 2, 1, ':^^:', 'lol.gif');";
$modul_sql_install[] = "INSERT INTO CPPREFIX_modul_forum_smileys VALUES ('', 1, 1, ':cry:', 'cry.gif');";


$modul_sql_install[] = "CREATE TABLE CPPREFIX_modul_forum_topic (
  id int(11) NOT NULL auto_increment,
  title varchar(200) NOT NULL default '',
  `status` int(11) default '0',
  views int(11) NOT NULL default '0',
  rating text,
  forum_id int(11) NOT NULL default '0',
  icon smallint(5) unsigned default NULL,
  posticon smallint(5) unsigned default NULL,
  datum datetime NOT NULL default '0000-00-00 00:00:00',
  replies int(10) unsigned NOT NULL default '0',
  uid smallint(5) unsigned NOT NULL default '0',
  notification text NOT NULL,
  `type` tinyint(1) NOT NULL default '0',
  last_post datetime default NULL,
  last_post_id int(11) default NULL,
  opened tinyint(4) NOT NULL default '1',
  last_post_int int(14) NOT NULL default '0',
  PRIMARY KEY  (id),
  KEY forum_id (forum_id),
  KEY opened (opened),
  KEY uid (uid),
  KEY id (id),
  KEY title (title),
  KEY id_2 (id),
  KEY title_2 (title)
) TYPE=MyISAM PACK_KEYS=0 AUTO_INCREMENT=1 DEFAULT CHARSET=cp1251;";

$modul_sql_install[] = "CREATE TABLE CPPREFIX_modul_forum_topic_read (
  Usr int(11) NOT NULL default '0',
  Topic int(11) NOT NULL default '0',
  ReadOn timestamp NOT NULL,
  PRIMARY KEY  (Usr,Topic)
) TYPE=MyISAM DEFAULT CHARSET=cp1251;";

$modul_sql_install[] = "CREATE TABLE CPPREFIX_modul_forum_useronline (
  ip varchar(25) NOT NULL default '0',
  uid int(10) unsigned NOT NULL default '0',
  expire int(11) NOT NULL default '0',
  uname varchar(255) NOT NULL default '',
  invisible varchar(10) NOT NULL default '',
  UNIQUE KEY ip (ip)
) TYPE=MyISAM DEFAULT CHARSET=cp1251;";

$modul_sql_install[] = "CREATE TABLE CPPREFIX_modul_forum_userprofile (
  Id int(14) unsigned NOT NULL auto_increment,
  BenutzerId int(14) unsigned NOT NULL default '0',
  BenutzerName varchar(200) default NULL,
  BenutzerNameChanged mediumint(3) unsigned default '0',
  GroupIdMisc text,
  Beitraege int(10) unsigned NOT NULL default '0',
  ZeigeProfil tinyint(1) unsigned NOT NULL default '1',
  Signatur tinytext,
  Icq varchar(150) default NULL,
  Aim varchar(150) default NULL,
  Skype varchar(150) default NULL,
  Emailempfang tinyint(1) unsigned NOT NULL default '1',
  Pnempfang tinyint(1) unsigned NOT NULL default '1',
  Avatar varchar(255) default NULL,
  AvatarStandard tinyint(1) NOT NULL default '1',
  Webseite varchar(255) default NULL,
  Unsichtbar tinyint(1) unsigned NOT NULL default '1',
  Interessen text,
  Email varchar(200) default NULL,
  Registriert int(14) unsigned NOT NULL default '0',
  GeburtsTag varchar(10) default NULL,
  Email_show tinyint(1) unsigned NOT NULL default '0',
  Icq_show tinyint(1) unsigned NOT NULL default '1',
  Aim_show tinyint(1) unsigned NOT NULL default '1',
  Skype_show tinyint(1) unsigned NOT NULL default '1',
  Interessen_show tinyint(1) unsigned NOT NULL default '1',
  Signatur_show tinyint(1) unsigned NOT NULL default '1',
  GeburtsTag_show tinyint(1) unsigned NOT NULL default '1',
  Webseite_show tinyint(1) unsigned NOT NULL default '1',
  Geschlecht enum('male','female') NOT NULL default 'male',
  PRIMARY KEY  (Id),
  UNIQUE KEY BenutzerId (BenutzerId)
) TYPE=MyISAM PACK_KEYS=0 AUTO_INCREMENT=1 DEFAULT CHARSET=cp1251;";


$modul_sql_install[] = "INSERT INTO CPPREFIX_modul_forum_category VALUES (1, 'Демонстрационная категория', 1, 0, 'Категория для демонстрации работы форумов', '1,2,3,4,5,6,7,8,9');";
$modul_sql_install[] = "INSERT INTO CPPREFIX_modul_forum_forum VALUES (1, 'Общий форум', 1, NULL, 'Здесь можно говорить обо всем', 0, '2008-05-10 11:45:16', 0, '1,2,3,4,5,6,7,8,9', 1, '', '', NULL, 1, 0, 0, '', '');";
$modul_sql_install[] = "INSERT INTO CPPREFIX_modul_forum_forum VALUES (2, 'Мир вокруг нас', 1, NULL, 'Форум о событиях на планете земля.', 0, NULL, 0, '1,2,3,4,5,6,7,8,9', 1, '', '', NULL, 2, 0, 0, '', '');";
$modul_sql_install[] = "INSERT INTO CPPREFIX_modul_forum_topic VALUES (1, 'Добро пожаловать!', 0, 3, NULL, 1, NULL, 0, '2008-05-10 11:45:16', 1, 1, '', 0, '".date("Y-m-d H:i:s")."', NULL, 1, '".time()."');";
$modul_sql_install[] = "INSERT INTO CPPREFIX_modul_forum_post VALUES (1, '', 1, '".date("Y-m-d H:i:s")."', 1, 1, 1, 1, 'Мы приветствуем Вас в наших форумах!\r\nОбщайтесь в удовольствие.', '', 1);";
$modul_sql_install[] = "INSERT INTO CPPREFIX_modul_forum_rating VALUES (1, '', '', '');";
$modul_sql_install[] = "INSERT INTO CPPREFIX_modul_forum_permissions VALUES (1, 1, '1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1');";
$modul_sql_install[] = "INSERT INTO CPPREFIX_modul_forum_permissions VALUES (1, 2, '1,1,1,1,0,0,0,0,,,,,,,,,,,,,,');";
$modul_sql_install[] = "INSERT INTO CPPREFIX_modul_forum_permissions VALUES (1, 3, '1,1,1,1,1,1,1,1,1,1,1,1,1,1,0,0,0,0,0,0,0,0');";
$modul_sql_install[] = "INSERT INTO CPPREFIX_modul_forum_permissions VALUES (1, 4, '1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,0,1,1,1,1,1');";
$modul_sql_install[] = "INSERT INTO CPPREFIX_modul_forum_permissions VALUES (1, 5, '1,1,1,1,1,1,1,1,0,0,0,0,0,0,0,0,0,0,0,0,0,0');";
$modul_sql_install[] = "INSERT INTO CPPREFIX_modul_forum_permissions VALUES (2, 1, '1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1');";
$modul_sql_install[] = "INSERT INTO CPPREFIX_modul_forum_permissions VALUES (2, 2, '1,1,1,1,0,0,0,0,,,,,,,,,,,,,,');";
$modul_sql_install[] = "INSERT INTO CPPREFIX_modul_forum_permissions VALUES (2, 3, '1,1,1,1,1,1,1,1,1,1,1,1,1,1,0,0,0,0,0,0,0,0');";
$modul_sql_install[] = "INSERT INTO CPPREFIX_modul_forum_permissions VALUES (2, 4, '1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,0,1,1,1,1,1');";
$modul_sql_install[] = "INSERT INTO CPPREFIX_modul_forum_permissions VALUES (2, 5, '1,1,1,1,1,1,1,1,0,0,0,0,0,0,0,0,0,0,0,0,0,0');";

$modul_sql_update[] = "UPDATE CPPREFIX_module SET CpEngineTag = '" . $modul['CpEngineTag'] . "', CpPHPTag = '" . $modul['CpPHPTag'] . "', Version = '" . $modul['ModulVersion'] . "' WHERE ModulPfad = '" . $modul['ModulPfad'] . "' LIMIT 1;";

?>