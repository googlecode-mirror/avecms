ALTER TABLE cp_antispam
  CHANGE COLUMN Code Code CHAR(10) NOT NULL,
  ADD INDEX Ctime (Ctime),
  ROW_FORMAT = FIXED;#####systemdump#####

ALTER TABLE cp_countries
  CHANGE COLUMN Id Id MEDIUMINT(5) UNSIGNED NOT NULL AUTO_INCREMENT,
  CHANGE COLUMN LandCode LandCode CHAR(2) NOT NULL DEFAULT 'RU',
  CHANGE COLUMN LandName LandName CHAR(50) NOT NULL,
  CHANGE COLUMN Aktiv Aktiv ENUM('1','2') NOT NULL DEFAULT '2',
  CHANGE COLUMN IstEU IstEU ENUM('1','2') NOT NULL DEFAULT '2',
  ROW_FORMAT = FIXED;#####systemdump#####

ALTER TABLE cp_document_comments
  CHANGE COLUMN KommentarStart KommentarStart ENUM('1','0') NOT NULL DEFAULT '0',
  CHANGE COLUMN Titel Titel VARCHAR(255) NOT NULL,
  CHANGE COLUMN Author Author VARCHAR(50) NOT NULL,
  CHANGE COLUMN Zeit Zeit INT(10) UNSIGNED NOT NULL,
  CHANGE COLUMN Aktiv Aktiv ENUM('1','0') NOT NULL DEFAULT '1',
  CHANGE COLUMN AntwortEMail AntwortEMail VARCHAR(100) NOT NULL;#####systemdump#####

ALTER TABLE cp_document_fields
  DROP INDEX RubrikFeld_2,
  CHANGE COLUMN RubrikFeld RubrikFeld MEDIUMINT(5) UNSIGNED NOT NULL DEFAULT 0,
  CHANGE COLUMN Suche Suche ENUM('1','0') NOT NULL DEFAULT '1';#####systemdump#####

ALTER TABLE cp_document_permissions
  CHANGE COLUMN Id Id MEDIUMINT(5) UNSIGNED NOT NULL AUTO_INCREMENT,
  CHANGE COLUMN RubrikId RubrikId SMALLINT(3) UNSIGNED NOT NULL,
  CHANGE COLUMN BenutzerGruppe BenutzerGruppe SMALLINT(3) UNSIGNED NOT NULL,
  CHANGE COLUMN Rechte Rechte CHAR(255) NOT NULL,
  ROW_FORMAT = FIXED;#####systemdump#####

ALTER TABLE cp_documents
  CHANGE COLUMN Suche Suche ENUM('1','0') NOT NULL DEFAULT '1',
  CHANGE COLUMN DokStatus DokStatus ENUM('1','0') NOT NULL DEFAULT '1',
  CHANGE COLUMN Geloescht Geloescht ENUM('0','1') NOT NULL DEFAULT '0';#####systemdump#####

ALTER TABLE cp_log
  CHANGE COLUMN Zeit Zeit INT(10) NOT NULL DEFAULT 0,
  CHANGE COLUMN Seite Seite VARCHAR(255) NOT NULL,
  CHANGE COLUMN LogTyp LogTyp TINYINT(1) UNSIGNED NOT NULL DEFAULT 2,
  CHANGE COLUMN Rub Rub TINYINT(1) UNSIGNED NOT NULL DEFAULT 2;#####systemdump#####

ALTER TABLE cp_modul_banner_categories
  CHANGE COLUMN Id Id SMALLINT(3) UNSIGNED NOT NULL AUTO_INCREMENT,
  CHANGE COLUMN KatName KatName CHAR(100) NOT NULL,
  ROW_FORMAT = FIXED;#####systemdump#####

ALTER TABLE cp_modul_banners
  CHANGE COLUMN Id Id MEDIUMINT(5) UNSIGNED NOT NULL AUTO_INCREMENT,
  CHANGE COLUMN KatId KatId SMALLINT(3) UNSIGNED NOT NULL DEFAULT 0,
  CHANGE COLUMN Bannertags Bannertags CHAR(255) NOT NULL,
  CHANGE COLUMN BannerUrl BannerUrl CHAR(255) NOT NULL,
  CHANGE COLUMN Gewicht Gewicht ENUM('1','2','3') NOT NULL DEFAULT '1',
  CHANGE COLUMN Bannername Bannername CHAR(255) NOT NULL,
  CHANGE COLUMN BildAlt BildAlt CHAR(255) NOT NULL,
  CHANGE COLUMN ZStart ZStart ENUM('0','1','2','3','4','5','6','7','8','9','10','11','12','13','14','15','16','17','18','19','20','21','22','23') NOT NULL DEFAULT '0',
  CHANGE COLUMN ZEnde ZEnde ENUM('0','1','2','3','4','5','6','7','8','9','10','11','12','13','14','15','16','17','18','19','20','21','22','23') NOT NULL DEFAULT '0',
  CHANGE COLUMN Aktiv Aktiv ENUM('1','0') NOT NULL DEFAULT '1',
  CHANGE COLUMN Target Target ENUM('_blank','_self') NOT NULL DEFAULT '_blank',
  CHANGE COLUMN Width Width SMALLINT(3) UNSIGNED NOT NULL DEFAULT 0,
  CHANGE COLUMN Height Height SMALLINT(3) UNSIGNED NOT NULL DEFAULT 0,
  ADD INDEX Aktiv (Aktiv),
  ADD INDEX KatId (KatId),
  ROW_FORMAT = FIXED;#####systemdump#####

ALTER TABLE cp_modul_comments
  CHANGE COLUMN Id Id TINYINT(1) UNSIGNED NOT NULL AUTO_INCREMENT,
  CHANGE COLUMN max_chars max_chars SMALLINT(3) UNSIGNED NOT NULL DEFAULT 1000,
  CHANGE COLUMN moderate moderate ENUM('0','1') NOT NULL DEFAULT '0',
  CHANGE COLUMN active active ENUM('1','0') NOT NULL DEFAULT '1',
  CHANGE COLUMN spamprotect spamprotect ENUM('1','0') NOT NULL DEFAULT '1';#####systemdump#####

ALTER TABLE cp_modul_contact_fields
  CHANGE COLUMN field_required field_required ENUM('0','1') NOT NULL DEFAULT '0',
  CHANGE COLUMN field_status field_status ENUM('1','0') NOT NULL DEFAULT '1',
  CHANGE COLUMN field_newline field_newline ENUM('1','0') NOT NULL DEFAULT '1';#####systemdump#####

ALTER TABLE cp_modul_contact_info
  CHANGE COLUMN form_id form_id MEDIUMINT(5) UNSIGNED NOT NULL DEFAULT 0 AFTER form_num,
  CHANGE COLUMN in_email in_email VARCHAR(255) NOT NULL AFTER in_date,
  CHANGE COLUMN in_subject in_subject VARCHAR(255) NOT NULL AFTER in_email,
  CHANGE COLUMN in_message in_message LONGTEXT NOT NULL AFTER in_subject,
  CHANGE COLUMN in_attachment in_attachment TINYTEXT NOT NULL AFTER in_message,
  CHANGE COLUMN out_date out_date INT(10) UNSIGNED NOT NULL DEFAULT 0 AFTER in_attachment,
  CHANGE COLUMN out_email out_email VARCHAR(255) NOT NULL AFTER out_date,
  CHANGE COLUMN out_sender out_sender VARCHAR(255) NOT NULL AFTER out_email,
  CHANGE COLUMN out_message out_message LONGTEXT NOT NULL AFTER out_sender,
  CHANGE COLUMN out_attachment out_attachment TINYTEXT NOT NULL;#####systemdump#####

ALTER TABLE cp_modul_contacts
  CHANGE COLUMN form_mail_max_chars form_mail_max_chars SMALLINT(3) UNSIGNED NOT NULL DEFAULT 20000,
  CHANGE COLUMN form_antispam form_antispam ENUM('1','0') NOT NULL DEFAULT '1',
  CHANGE COLUMN form_show_subject form_show_subject ENUM('1','0') NOT NULL DEFAULT '1',
  CHANGE COLUMN form_default_subject form_default_subject VARCHAR(255) NOT NULL DEFAULT 'Сообщение',
  CHANGE COLUMN form_send_copy form_send_copy ENUM('1','0') NOT NULL DEFAULT '1';#####systemdump#####

ALTER TABLE cp_modul_counter
  CHANGE COLUMN id id SMALLINT(3) UNSIGNED NOT NULL AUTO_INCREMENT,
  CHANGE COLUMN counter_name counter_name CHAR(50) NOT NULL,
  ROW_FORMAT = FIXED;#####systemdump#####

ALTER TABLE cp_modul_counter_info
  CHANGE COLUMN counter_id counter_id SMALLINT(3) UNSIGNED NOT NULL,
  CHANGE COLUMN client_ip client_ip CHAR(50) NOT NULL,
  CHANGE COLUMN client_os client_os CHAR(20) NOT NULL,
  CHANGE COLUMN client_browser client_browser CHAR(20) NOT NULL,
  CHANGE COLUMN client_referer client_referer CHAR(255) NOT NULL,
  ROW_FORMAT = FIXED;#####systemdump#####

ALTER TABLE cp_modul_download_lizenzen
  CHANGE COLUMN Name Name CHAR(255) NOT NULL,
  ROW_FORMAT = FIXED;#####systemdump#####

ALTER TABLE cp_modul_download_log
  CHANGE COLUMN Datum Datum CHAR(10) NOT NULL,
  CHANGE COLUMN Ip Ip CHAR(100) NOT NULL,
  ROW_FORMAT = FIXED;#####systemdump#####

ALTER TABLE cp_modul_download_os
  CHANGE COLUMN Name Name CHAR(200) NOT NULL,
  ROW_FORMAT = FIXED;#####systemdump#####

ALTER TABLE cp_modul_download_payhistory
  CHANGE COLUMN PayDate PayDate CHAR(10) NOT NULL,
  CHANGE COLUMN User_IP User_IP CHAR(15) NOT NULL,
  ROW_FORMAT = FIXED;#####systemdump#####

ALTER TABLE cp_modul_download_sprachen
  CHANGE COLUMN Name Name CHAR(200) NOT NULL,
  ROW_FORMAT = FIXED;#####systemdump#####

ALTER TABLE cp_modul_faq
  CHANGE COLUMN faq_name faq_name CHAR(100) NOT NULL,
  CHANGE COLUMN description description CHAR(255) NOT NULL,
  ROW_FORMAT = FIXED;#####systemdump#####

ALTER TABLE cp_modul_forum_allowed_files
  CHANGE COLUMN filetype filetype CHAR(200) NOT NULL,
  ROW_FORMAT = FIXED;#####systemdump#####

ALTER TABLE cp_modul_forum_attachment
  CHANGE COLUMN orig_name orig_name CHAR(255) NOT NULL,
  CHANGE COLUMN filename filename CHAR(255) NOT NULL,
  ROW_FORMAT = FIXED;#####systemdump#####

ALTER TABLE cp_modul_forum_category
  DROP INDEX id,
  DROP INDEX id_2,
  DROP INDEX title_2,
  DROP INDEX title_3,
  DROP INDEX title_4,
  ADD INDEX parent_id (parent_id);#####systemdump#####

ALTER TABLE cp_modul_forum_forum
  DROP INDEX group_id_2,
  DROP INDEX id,
  DROP INDEX id_2,
  DROP INDEX position_2,
  DROP INDEX position_3,
  DROP INDEX status_2,
  DROP INDEX title_2,
  DROP INDEX title_3,
  DROP INDEX title_4,
  ADD INDEX category_id (category_id);#####systemdump#####

ALTER TABLE cp_modul_forum_groupavatar
  CHANGE COLUMN StandardAvatar StandardAvatar CHAR(255) NOT NULL,
  ROW_FORMAT = FIXED;#####systemdump#####

ALTER TABLE cp_modul_forum_ignorelist
  CHANGE COLUMN Grund Grund CHAR(255) NOT NULL,
  ROW_FORMAT = FIXED;#####systemdump#####

ALTER TABLE cp_modul_forum_permissions
  CHANGE COLUMN permissions permissions CHAR(255) NOT NULL,
  ROW_FORMAT = FIXED;#####systemdump#####

ALTER TABLE cp_modul_forum_pn
  DROP INDEX id;#####systemdump#####

ALTER TABLE cp_modul_forum_post
  DROP INDEX datum_2,
  DROP INDEX id,
  DROP INDEX id_2,
  DROP INDEX title_2,
  DROP INDEX topci_id,
  DROP INDEX topic_id_2;#####systemdump#####

ALTER TABLE cp_modul_forum_posticons
  CHANGE COLUMN path path CHAR(55) NOT NULL,
  ROW_FORMAT = FIXED;#####systemdump#####

ALTER TABLE cp_modul_forum_rank
  CHANGE COLUMN title title CHAR(100) NOT NULL,
  ROW_FORMAT = FIXED;#####systemdump#####

ALTER TABLE cp_modul_forum_smileys
  CHANGE COLUMN active active ENUM('1','0') NOT NULL DEFAULT '1',
  CHANGE COLUMN code code CHAR(15) NOT NULL,
  CHANGE COLUMN path path CHAR(55) NOT NULL,
  ROW_FORMAT = FIXED;#####systemdump#####

ALTER TABLE cp_modul_forum_topic
  DROP INDEX id,
  DROP INDEX id_2,
  DROP INDEX title_2;#####systemdump#####

ALTER TABLE cp_modul_forum_useronline
  CHANGE COLUMN ip ip CHAR(25) NOT NULL DEFAULT '0',
  CHANGE COLUMN expire expire INT(10) NOT NULL DEFAULT 0,
  CHANGE COLUMN uname uname CHAR(255) NOT NULL,
  CHANGE COLUMN invisible invisible CHAR(10) NOT NULL,
  ADD INDEX expire (expire),
  ROW_FORMAT = FIXED;#####systemdump#####

ALTER TABLE cp_modul_gallery
  CHANGE COLUMN gallery_title gallery_title VARCHAR(255) NOT NULL,
  CHANGE COLUMN gallery_author gallery_author INT(10) UNSIGNED NOT NULL DEFAULT 0,
  CHANGE COLUMN gallery_date gallery_date INT(10) UNSIGNED NOT NULL DEFAULT 0,
  CHANGE COLUMN thumb_width thumb_width SMALLINT(3) UNSIGNED NOT NULL DEFAULT 120,
  CHANGE COLUMN image_on_line image_on_line TINYINT(1) UNSIGNED NOT NULL DEFAULT 4,
  CHANGE COLUMN show_title show_title ENUM('1','0') NOT NULL DEFAULT '1',
  CHANGE COLUMN show_description show_description ENUM('1','0') NOT NULL DEFAULT '1',
  CHANGE COLUMN show_size show_size ENUM('0','1') NOT NULL DEFAULT '0',
  CHANGE COLUMN image_on_page image_on_page TINYINT(1) UNSIGNED NOT NULL DEFAULT 12,
  CHANGE COLUMN orderby orderby ENUM('datedesc','dateasc','titleasc','titledesc','position') NOT NULL DEFAULT 'datedesc';#####systemdump#####

ALTER TABLE cp_modul_gallery_images
  CHANGE COLUMN image_filename image_filename VARCHAR(255) NOT NULL,
  CHANGE COLUMN image_author image_author INT(10) UNSIGNED NOT NULL DEFAULT 0,
  CHANGE COLUMN image_file_ext image_file_ext CHAR(4) NOT NULL,
  CHANGE COLUMN image_date image_date INT(10) UNSIGNED NOT NULL DEFAULT 0,
  CHANGE COLUMN image_position image_position SMALLINT(3) UNSIGNED NOT NULL DEFAULT 1;#####systemdump#####

ALTER TABLE cp_modul_login
  CHANGE COLUMN Id Id TINYINT(1) UNSIGNED NOT NULL AUTO_INCREMENT,
  CHANGE COLUMN AntiSpam AntiSpam ENUM('0','1') NOT NULL DEFAULT '0',
  CHANGE COLUMN IstAktiv IstAktiv ENUM('1','0') NOT NULL DEFAULT '1',
  CHANGE COLUMN ZeigeFirma ZeigeFirma ENUM('0','1') NOT NULL DEFAULT '0',
  CHANGE COLUMN ZeigeVorname ZeigeVorname ENUM('0','1') NOT NULL DEFAULT '0',
  CHANGE COLUMN ZeigeNachname ZeigeNachname ENUM('0','1') NOT NULL DEFAULT '0';#####systemdump#####

ALTER TABLE cp_modul_newsarchive
  CHANGE COLUMN arc_name arc_name CHAR(100) NOT NULL,
  CHANGE COLUMN rubs rubs CHAR(255) NOT NULL,
  CHANGE COLUMN show_days show_days ENUM('1','0') NOT NULL DEFAULT '1',
  CHANGE COLUMN show_empty show_empty ENUM('1','0') NOT NULL DEFAULT '1',
  ROW_FORMAT = FIXED;#####systemdump#####

ALTER TABLE cp_modul_poll
  CHANGE COLUMN id id SMALLINT(3) UNSIGNED NOT NULL AUTO_INCREMENT,
  CHANGE COLUMN active active ENUM('1','0') NOT NULL DEFAULT '1',
  CHANGE COLUMN group_id group_id TINYTEXT NOT NULL,
  CHANGE COLUMN can_comment can_comment ENUM('1','0') NOT NULL DEFAULT '0';#####systemdump#####

ALTER TABLE cp_modul_poll_comments
  CHANGE COLUMN id id INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  CHANGE COLUMN pollid pollid SMALLINT(3) NOT NULL,
  CHANGE COLUMN title title VARCHAR(255) NOT NULL;#####systemdump#####

ALTER TABLE cp_modul_poll_items
  CHANGE COLUMN id id MEDIUMINT(5) UNSIGNED NOT NULL AUTO_INCREMENT,
  CHANGE COLUMN pollid pollid SMALLINT(3) NOT NULL,
  CHANGE COLUMN title title CHAR(255) NOT NULL,
  CHANGE COLUMN hits hits INT(10) NOT NULL,
  CHANGE COLUMN color color CHAR(7) NOT NULL,
  CHANGE COLUMN posi posi SMALLINT(3) NOT NULL,
  ROW_FORMAT = FIXED;#####systemdump#####

ALTER TABLE cp_modul_roadmap
  CHANGE COLUMN id id SMALLINT(3) UNSIGNED NOT NULL AUTO_INCREMENT,
  CHANGE COLUMN project_status project_status ENUM('1','0') NOT NULL DEFAULT '1';#####systemdump#####

ALTER TABLE cp_modul_roadmap_tasks
  CHANGE COLUMN id id MEDIUMINT(5) UNSIGNED NOT NULL AUTO_INCREMENT,
  CHANGE COLUMN pid pid SMALLINT(3) UNSIGNED NOT NULL,
  CHANGE COLUMN task_status task_status ENUM('0','1') NOT NULL DEFAULT '0';#####systemdump#####

ALTER TABLE cp_modul_rss
  CHANGE COLUMN id id SMALLINT(3) UNSIGNED NOT NULL AUTO_INCREMENT,
  CHANGE COLUMN rss_name rss_site_name CHAR(255) NOT NULL AFTER id,
  CHANGE COLUMN rss_descr rss_site_description CHAR(255) NOT NULL AFTER rss_site_name,
  CHANGE COLUMN site_url rss_site_url CHAR(255) NOT NULL AFTER rss_site_description,
  CHANGE COLUMN rub_id rss_rubric_id SMALLINT(3) UNSIGNED NOT NULL AFTER rss_site_url,
  CHANGE COLUMN title_id rss_title_id INT(10) UNSIGNED NOT NULL AFTER rss_rubric_id,
  CHANGE COLUMN descr_id rss_description_id INT(10) UNSIGNED NOT NULL AFTER rss_title_id,
  CHANGE COLUMN on_page rss_item_on_page TINYINT(1) UNSIGNED NOT NULL AFTER rss_description_id,
  CHANGE COLUMN lenght rss_description_lenght SMALLINT(3) UNSIGNED NOT NULL AFTER rss_item_on_page,
  ROW_FORMAT = FIXED;#####systemdump#####

ALTER TABLE cp_modul_search
  CHANGE COLUMN Suchbegriff search_query CHAR(255) NOT NULL AFTER Id,
  CHANGE COLUMN Anzahl search_count MEDIUMINT(5) UNSIGNED NOT NULL DEFAULT 0 AFTER search_query,
  CHANGE COLUMN Gefunden search_found MEDIUMINT(5) UNSIGNED NOT NULL DEFAULT 0 AFTER search_count,
  ADD UNIQUE INDEX search_query (search_query),
  ROW_FORMAT = FIXED;#####systemdump#####

ALTER TABLE cp_modul_shop
  CHANGE COLUMN Id Id TINYINT(1) UNSIGNED NOT NULL AUTO_INCREMENT,
  CHANGE COLUMN Aktiv Aktiv ENUM('0','1') NOT NULL DEFAULT '0';#####systemdump#####

ALTER TABLE cp_modul_shop_artikel
  CHANGE COLUMN Hersteller Hersteller MEDIUMINT(5) NOT NULL,
  ADD INDEX Angebot (Angebot),
  ADD INDEX Bestellungen (Bestellungen),
  ADD INDEX Erschienen (Erschienen),
  ADD FULLTEXT INDEX Schlagwoerter (Schlagwoerter);#####systemdump#####

ALTER TABLE cp_modul_shop_artikel_bilder
  CHANGE COLUMN Bild Bild CHAR(255) NOT NULL,
  ROW_FORMAT = FIXED;#####systemdump#####

ALTER TABLE cp_modul_shop_einheiten
  CHANGE COLUMN Name Name CHAR(100) NOT NULL,
  CHANGE COLUMN NameEinzahl NameEinzahl CHAR(255) NOT NULL,
  ROW_FORMAT = FIXED;#####systemdump#####

ALTER TABLE cp_modul_shop_hersteller
  CHANGE COLUMN Name Name CHAR(255) NOT NULL,
  CHANGE COLUMN Link Link CHAR(255) NOT NULL,
  CHANGE COLUMN Logo Logo CHAR(255) NOT NULL,
  ROW_FORMAT = FIXED;#####systemdump#####

ALTER TABLE cp_modul_shop_kategorie
  CHANGE COLUMN KatName KatName VARCHAR(100) NOT NULL;#####systemdump#####

ALTER TABLE cp_modul_shop_ust
  CHANGE COLUMN Name Name CHAR(100) NOT NULL,
  ROW_FORMAT = FIXED;#####systemdump#####

ALTER TABLE cp_modul_shop_varianten
  CHANGE COLUMN Name Name CHAR(255) NOT NULL,
  CHANGE COLUMN Position Position SMALLINT(3) UNSIGNED NOT NULL DEFAULT 1,
  CHANGE COLUMN Vorselektiert Vorselektiert ENUM('0','1') NOT NULL DEFAULT '0',
  ROW_FORMAT = FIXED;#####systemdump#####

ALTER TABLE cp_modul_sysblock
  CHANGE COLUMN sysblock_name sysblock_name VARCHAR(255) NOT NULL;#####systemdump#####

ALTER TABLE cp_module
  CHANGE COLUMN Id Id SMALLINT(3) UNSIGNED NOT NULL AUTO_INCREMENT,
  CHANGE COLUMN ModulName ModulName CHAR(50) NOT NULL,
  CHANGE COLUMN CpEngineTag CpEngineTag CHAR(255) NOT NULL,
  CHANGE COLUMN CpPHPTag CpPHPTag CHAR(255) NOT NULL,
  CHANGE COLUMN ModulFunktion ModulFunktion CHAR(255) NOT NULL,
  CHANGE COLUMN ModulPfad ModulPfad CHAR(50) NOT NULL,
  CHANGE COLUMN Version Version CHAR(20) NOT NULL DEFAULT '1.0',
  CHANGE COLUMN Template Template SMALLINT(3) UNSIGNED NOT NULL DEFAULT 1,
  ADD COLUMN AdminEdit ENUM('0','1') NOT NULL DEFAULT '0' AFTER Template,
  ROW_FORMAT = FIXED;#####systemdump#####

ALTER TABLE cp_navigation
  CHANGE COLUMN id id SMALLINT(3) UNSIGNED NOT NULL AUTO_INCREMENT,
  CHANGE COLUMN titel titel VARCHAR(255) NOT NULL,
  CHANGE COLUMN ebene1 ebene1 TEXT NOT NULL,
  CHANGE COLUMN ebene2 ebene2 TEXT NOT NULL,
  CHANGE COLUMN ebene3 ebene3 TEXT NOT NULL,
  CHANGE COLUMN ebene1a ebene1a TEXT NOT NULL,
  CHANGE COLUMN ebene2a ebene2a TEXT NOT NULL,
  CHANGE COLUMN ebene3a ebene3a TEXT NOT NULL,
  CHANGE COLUMN ebene1_v ebene1_v TEXT NOT NULL,
  CHANGE COLUMN ebene1_n ebene1_n TEXT NOT NULL,
  CHANGE COLUMN ebene2_v ebene2_v TEXT NOT NULL,
  CHANGE COLUMN ebene2_n ebene2_n TEXT NOT NULL,
  CHANGE COLUMN ebene3_v ebene3_v TEXT NOT NULL,
  CHANGE COLUMN ebene3_n ebene3_n TEXT NOT NULL,
  CHANGE COLUMN vor vor TEXT NOT NULL,
  CHANGE COLUMN nach nach TEXT NOT NULL,
  CHANGE COLUMN Expand Expand ENUM('1','0') NOT NULL DEFAULT '0';#####systemdump#####

ALTER TABLE cp_navigation_items
  CHANGE COLUMN Titel Titel CHAR(255) NOT NULL,
  CHANGE COLUMN Elter Elter MEDIUMINT(5) UNSIGNED NOT NULL,
  CHANGE COLUMN Link Link CHAR(255) NOT NULL,
  CHANGE COLUMN Ziel Ziel ENUM('_blank','_self','_parent','_top') NOT NULL DEFAULT '_self',
  CHANGE COLUMN Ebene Ebene ENUM('1','2','3') NOT NULL DEFAULT '1',
  CHANGE COLUMN Rang Rang SMALLINT(3) UNSIGNED NOT NULL DEFAULT 1,
  CHANGE COLUMN Rubrik Rubrik SMALLINT(3) UNSIGNED NOT NULL DEFAULT 0,
  CHANGE COLUMN Aktiv Aktiv ENUM('1','0') NOT NULL DEFAULT '1',
  CHANGE COLUMN Url Url CHAR(255) NOT NULL,
  ROW_FORMAT = FIXED;#####systemdump#####

ALTER TABLE cp_queries
  CHANGE COLUMN Id Id SMALLINT(3) UNSIGNED NOT NULL AUTO_INCREMENT,
  CHANGE COLUMN RubrikId RubrikId SMALLINT(3) UNSIGNED NOT NULL,
  CHANGE COLUMN Zahl Zahl INT(10) NOT NULL,
  CHANGE COLUMN Titel Titel VARCHAR(255) NOT NULL,
  CHANGE COLUMN Template Template TEXT NOT NULL,
  CHANGE COLUMN AbGeruest AbGeruest TEXT NOT NULL,
  CHANGE COLUMN Sortierung Sortierung VARCHAR(255) NOT NULL,
  CHANGE COLUMN Autor Autor INT(10) UNSIGNED NOT NULL DEFAULT 1,
  CHANGE COLUMN Erstellt Erstellt INT(10) UNSIGNED NOT NULL,
  CHANGE COLUMN Navi Navi ENUM('1','0') NOT NULL DEFAULT '1';#####systemdump#####

ALTER TABLE cp_queries_conditions
  CHANGE COLUMN Abfrage Abfrage SMALLINT(3) UNSIGNED NOT NULL,
  CHANGE COLUMN Operator Operator CHAR(30) NOT NULL,
  CHANGE COLUMN Feld Feld INT(10) NOT NULL,
  CHANGE COLUMN Wert Wert CHAR(255) NOT NULL,
  CHANGE COLUMN Oper Oper ENUM('OR','AND') NOT NULL DEFAULT 'OR',
  ROW_FORMAT = FIXED;#####systemdump#####

ALTER TABLE cp_rubric_fields
  CHANGE COLUMN Id Id MEDIUMINT(5) UNSIGNED NOT NULL AUTO_INCREMENT,
  CHANGE COLUMN RubrikId RubrikId SMALLINT(3) UNSIGNED NOT NULL,
  CHANGE COLUMN rubric_position rubric_position SMALLINT(3) UNSIGNED NOT NULL DEFAULT 1;#####systemdump#####

ALTER TABLE cp_rubric_template_cache
  ADD COLUMN `hash` CHAR(32) NOT NULL AFTER id,
  CHANGE COLUMN rub_id rub_id SMALLINT(3) NOT NULL AFTER `hash`,
  CHANGE COLUMN wysiwyg wysiwyg ENUM('0','1') NOT NULL DEFAULT '0' AFTER doc_id;#####systemdump#####

ALTER TABLE cp_rubrics
  CHANGE COLUMN Id Id SMALLINT(3) UNSIGNED NOT NULL AUTO_INCREMENT,
  CHANGE COLUMN RubrikName RubrikName VARCHAR(255) NOT NULL,
  CHANGE COLUMN Vorlage Vorlage SMALLINT(3) UNSIGNED NOT NULL DEFAULT 1,
  CHANGE COLUMN RBenutzer RBenutzer INT(10) UNSIGNED NOT NULL DEFAULT 1,
  CHANGE COLUMN RDatum RDatum INT(10) UNSIGNED NOT NULL DEFAULT 0;#####systemdump#####

ALTER TABLE cp_settings
  DROP INDEX Mail_Typ,
  CHANGE COLUMN Id Id TINYINT(1) UNSIGNED NOT NULL AUTO_INCREMENT,
  CHANGE COLUMN mail_port mail_port SMALLINT(3) UNSIGNED NOT NULL DEFAULT 25,
  CHANGE COLUMN mail_smtp_login mail_smtp_login VARCHAR(50) NOT NULL,
  CHANGE COLUMN mail_smtp_pass mail_smtp_pass VARCHAR(50) NOT NULL,
  CHANGE COLUMN navi_box navi_box VARCHAR(255) NOT NULL,
  CHANGE COLUMN use_doctime use_doctime ENUM('1','0') NOT NULL DEFAULT '1';#####systemdump#####

ALTER TABLE cp_templates
  CHANGE COLUMN Id Id SMALLINT(3) UNSIGNED NOT NULL AUTO_INCREMENT,
  CHANGE COLUMN TBenutzer TBenutzer INT(10) UNSIGNED NOT NULL,
  CHANGE COLUMN TDatum TDatum INT(10) UNSIGNED NOT NULL;#####systemdump#####

ALTER TABLE cp_user_groups
  CHANGE COLUMN Name Name CHAR(50) NOT NULL,
  CHANGE COLUMN Aktiv Aktiv ENUM('1','0') NOT NULL DEFAULT '1',
  CHANGE COLUMN set_default_avatar set_default_avatar ENUM('1','0') NOT NULL DEFAULT '0',
  CHANGE COLUMN default_avatar default_avatar CHAR(255) NOT NULL,
  CHANGE COLUMN Rechte Rechte CHAR(255) NOT NULL,
  ROW_FORMAT = FIXED;#####systemdump#####

ALTER TABLE cp_users
  CHANGE COLUMN Kennwort Kennwort CHAR(32) NOT NULL,
  CHANGE COLUMN Email Email CHAR(100) NOT NULL,
  CHANGE COLUMN Strasse Strasse CHAR(100) NOT NULL,
  CHANGE COLUMN HausNr HausNr CHAR(10) NOT NULL,
  CHANGE COLUMN Postleitzahl Postleitzahl CHAR(15) NOT NULL,
  CHANGE COLUMN city city CHAR(100) NOT NULL,
  CHANGE COLUMN Telefon Telefon CHAR(35) NOT NULL,
  CHANGE COLUMN Telefax Telefax CHAR(35) NOT NULL,
  CHANGE COLUMN Bemerkungen Bemerkungen CHAR(255) NOT NULL,
  CHANGE COLUMN Vorname Vorname CHAR(50) NOT NULL,
  CHANGE COLUMN Nachname Nachname CHAR(50) NOT NULL,
  CHANGE COLUMN UserName UserName CHAR(50) NOT NULL,
  CHANGE COLUMN Benutzergruppe Benutzergruppe SMALLINT(3) UNSIGNED NOT NULL DEFAULT 4,
  CHANGE COLUMN BenutzergruppeMisc BenutzergruppeMisc CHAR(255) NOT NULL,
  CHANGE COLUMN Registriert Registriert INT(10) UNSIGNED NOT NULL,
  CHANGE COLUMN Status Status ENUM('1','0') NOT NULL DEFAULT '1',
  CHANGE COLUMN ZuletztGesehen ZuletztGesehen INT(10) UNSIGNED NOT NULL,
  CHANGE COLUMN GebTag GebTag CHAR(10) NOT NULL,
  CHANGE COLUMN Geloescht Geloescht ENUM('1','0') NOT NULL DEFAULT '0',
  CHANGE COLUMN GeloeschtDatum GeloeschtDatum INT(10) UNSIGNED NOT NULL,
  CHANGE COLUMN emc emc CHAR(32) NOT NULL,
  CHANGE COLUMN IpReg IpReg CHAR(20) NOT NULL,
  CHANGE COLUMN new_pass new_pass CHAR(32) NOT NULL,
  CHANGE COLUMN Firma Firma CHAR(255) NOT NULL,
  CHANGE COLUMN UStPflichtig UStPflichtig ENUM('1','0') NOT NULL DEFAULT '0',
  CHANGE COLUMN salt salt CHAR(16) NOT NULL,
  CHANGE COLUMN new_salt new_salt CHAR(16) NOT NULL,
  ADD COLUMN user_ip INT(10) UNSIGNED NOT NULL DEFAULT 0 AFTER new_salt,
  ADD UNIQUE INDEX Email (Email),
  ADD UNIQUE INDEX UserName (UserName),
  ROW_FORMAT = FIXED;#####systemdump#####

UPDATE cp_templates 
  SET Template = REPLACE(Template, '[theme_folder:', '[cp:theme:');#####systemdump#####
