CREATE TABLE `%%PRFX%%_countries` (
  Id MEDIUMINT(5) UNSIGNED NOT NULL AUTO_INCREMENT,
  LandCode CHAR(2) NOT NULL DEFAULT 'RU',
  LandName CHAR(50) NOT NULL,
  Aktiv ENUM ('1', '2') NOT NULL DEFAULT '2',
  IstEU ENUM ('1', '2') NOT NULL DEFAULT '2',
  PRIMARY KEY (Id)
)
ENGINE = MYISAM
CHARACTER SET cp1251
COLLATE cp1251_general_ci;#inst#

CREATE TABLE `%%PRFX%%_document_comments` (
  Id INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  DokumentId INT(10) UNSIGNED NOT NULL DEFAULT 0,
  KommentarStart ENUM ('1', '0') NOT NULL DEFAULT '0',
  Titel VARCHAR(255) NOT NULL,
  Kommentar TEXT NOT NULL,
  Author VARCHAR(50) NOT NULL,
  Zeit INT(10) UNSIGNED NOT NULL,
  Aktiv ENUM ('1', '0') NOT NULL DEFAULT '1',
  AntwortEMail VARCHAR(100) NOT NULL,
  PRIMARY KEY (Id)
)
ENGINE = MYISAM
CHARACTER SET cp1251
COLLATE cp1251_general_ci;#inst#

CREATE TABLE `%%PRFX%%_document_fields` (
  Id INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  RubrikFeld MEDIUMINT(5) UNSIGNED NOT NULL DEFAULT 0,
  DokumentId INT(10) UNSIGNED NOT NULL DEFAULT 0,
  Inhalt LONGTEXT NOT NULL,
  Suche ENUM ('1', '0') NOT NULL DEFAULT '1',
  PRIMARY KEY (Id),
  INDEX DokumentId (DokumentId),
  INDEX RubrikFeld (RubrikFeld)
)
ENGINE = MYISAM
CHARACTER SET cp1251
COLLATE cp1251_general_ci;#inst#

CREATE TABLE `%%PRFX%%_document_permissions` (
  Id MEDIUMINT(5) UNSIGNED NOT NULL AUTO_INCREMENT,
  RubrikId SMALLINT(3) UNSIGNED NOT NULL,
  BenutzerGruppe SMALLINT(3) UNSIGNED NOT NULL,
  Rechte CHAR(255) NOT NULL,
  PRIMARY KEY (Id),
  INDEX RubrikId (RubrikId)
)
ENGINE = MYISAM
CHARACTER SET cp1251
COLLATE cp1251_general_ci;#inst#

CREATE TABLE `%%PRFX%%_documents` (
  Id INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  RubrikId MEDIUMINT(5) UNSIGNED NOT NULL DEFAULT 0,
  Url VARCHAR(255) NOT NULL,
  Titel VARCHAR(255) NOT NULL,
  DokStart INT(10) UNSIGNED NOT NULL DEFAULT 0,
  DokEnde INT(10) UNSIGNED NOT NULL DEFAULT 0,
  DokEdi INT(10) UNSIGNED NOT NULL DEFAULT 0,
  Redakteur MEDIUMINT(5) UNSIGNED NOT NULL DEFAULT 1,
  Suche ENUM ('1', '0') DEFAULT '1',
  MetaKeywords TINYTEXT NOT NULL,
  MetaDescription TINYTEXT NOT NULL,
  IndexFollow ENUM ('index,follow', 'index,nofollow', 'noindex,nofollow') NOT NULL DEFAULT 'index,follow',
  DokStatus ENUM ('1', '0') DEFAULT '1',
  Geloescht ENUM ('0', '1') DEFAULT '0',
  Drucke INT(10) UNSIGNED NOT NULL DEFAULT 0,
  Geklickt INT(10) UNSIGNED NOT NULL DEFAULT 0,
  ElterNavi MEDIUMINT(5) UNSIGNED NOT NULL DEFAULT 0,
  PRIMARY KEY (Id),
  INDEX DokEnde (DokEnde),
  INDEX DokStart (DokStart),
  INDEX DokStatus (DokStatus),
  INDEX RubrikId (RubrikId),
  UNIQUE INDEX Url (Url)
)
ENGINE = MYISAM
CHARACTER SET cp1251
COLLATE cp1251_general_ci;#inst#

CREATE TABLE `%%PRFX%%_log` (
  Id INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  Zeit INT(10) NOT NULL DEFAULT 0,
  IpCode VARCHAR(25) NOT NULL,
  Seite VARCHAR(255) NOT NULL,
  Meldung TEXT NOT NULL,
  LogTyp TINYINT(1) UNSIGNED NOT NULL DEFAULT 2,
  Rub TINYINT(1) UNSIGNED NOT NULL DEFAULT 2,
  PRIMARY KEY (Id)
)
ENGINE = MYISAM
CHARACTER SET cp1251
COLLATE cp1251_general_ci;#inst#

CREATE TABLE `%%PRFX%%_module` (
  Id SMALLINT(3) UNSIGNED NOT NULL AUTO_INCREMENT,
  ModulName CHAR(50) NOT NULL,
  Status ENUM ('1', '0') NOT NULL DEFAULT '1',
  CpEngineTag CHAR(255) NOT NULL,
  CpPHPTag CHAR(255) NOT NULL,
  ModulFunktion CHAR(255) NOT NULL,
  IstFunktion ENUM ('1', '0') NOT NULL DEFAULT '1',
  ModulPfad CHAR(50) NOT NULL,
  Version CHAR(20) NOT NULL DEFAULT '1.0',
  Template SMALLINT(3) UNSIGNED NOT NULL DEFAULT 1,
  AdminEdit ENUM ('0', '1') NOT NULL DEFAULT '0',
  PRIMARY KEY (Id),
  UNIQUE INDEX ModulName (ModulName)
)
ENGINE = MYISAM
CHARACTER SET cp1251
COLLATE cp1251_general_ci;#inst#

CREATE TABLE `%%PRFX%%_navigation` (
  id SMALLINT(3) UNSIGNED NOT NULL AUTO_INCREMENT,
  titel VARCHAR(255) NOT NULL,
  ebene1 TEXT NOT NULL,
  ebene2 TEXT NOT NULL,
  ebene3 TEXT NOT NULL,
  ebene1a TEXT NOT NULL,
  ebene2a TEXT NOT NULL,
  ebene3a TEXT NOT NULL,
  ebene1_v TEXT NOT NULL,
  ebene1_n TEXT NOT NULL,
  ebene2_v TEXT NOT NULL,
  ebene2_n TEXT NOT NULL,
  ebene3_v TEXT NOT NULL,
  ebene3_n TEXT NOT NULL,
  vor TEXT NOT NULL,
  nach TEXT NOT NULL,
  Gruppen TEXT NOT NULL,
  Expand ENUM ('1', '0') NOT NULL DEFAULT '0',
  PRIMARY KEY (id)
)
ENGINE = MYISAM
CHARACTER SET cp1251
COLLATE cp1251_general_ci;#inst#

CREATE TABLE `%%PRFX%%_navigation_items` (
  Id MEDIUMINT(5) UNSIGNED NOT NULL AUTO_INCREMENT,
  Titel CHAR(255) NOT NULL,
  Elter MEDIUMINT(5) UNSIGNED NOT NULL,
  Link CHAR(255) NOT NULL,
  Ziel ENUM ('_blank', '_self', '_parent', '_top') NOT NULL DEFAULT '_self',
  Ebene ENUM ('1', '2', '3') NOT NULL DEFAULT '1',
  Rang SMALLINT(3) UNSIGNED NOT NULL DEFAULT 1,
  Rubrik SMALLINT(3) UNSIGNED NOT NULL DEFAULT 0,
  Aktiv ENUM ('1', '0') NOT NULL DEFAULT '1',
  Url CHAR(255) NOT NULL,
  PRIMARY KEY (Id),
  INDEX Aktiv (Aktiv),
  INDEX Rubrik (Rubrik),
  INDEX Url (Url)
)
ENGINE = MYISAM
CHARACTER SET cp1251
COLLATE cp1251_general_ci;#inst#

CREATE TABLE `%%PRFX%%_queries` (
  Id SMALLINT(3) UNSIGNED NOT NULL AUTO_INCREMENT,
  RubrikId SMALLINT(3) UNSIGNED NOT NULL,
  Zahl INT(10) NOT NULL,
  Titel VARCHAR(255) NOT NULL,
  Template TEXT NOT NULL,
  AbGeruest TEXT NOT NULL,
  Sortierung VARCHAR(255) NOT NULL,
  Autor INT(10) UNSIGNED NOT NULL DEFAULT 1,
  Erstellt INT(10) UNSIGNED NOT NULL,
  Beschreibung TINYTEXT NOT NULL,
  AscDesc ENUM ('ASC', 'DESC') NOT NULL DEFAULT 'DESC',
  Navi ENUM ('1', '0') NOT NULL DEFAULT '1',
  where_cond TEXT NOT NULL,
  PRIMARY KEY (Id)
)
ENGINE = MYISAM
CHARACTER SET cp1251
COLLATE cp1251_general_ci;#inst#

CREATE TABLE `%%PRFX%%_queries_conditions` (
  Id MEDIUMINT(5) UNSIGNED NOT NULL AUTO_INCREMENT,
  Abfrage SMALLINT(3) UNSIGNED NOT NULL,
  Operator CHAR(30) NOT NULL,
  Feld INT(10) NOT NULL,
  Wert CHAR(255) NOT NULL,
  Oper ENUM ('OR', 'AND') NOT NULL DEFAULT 'OR',
  PRIMARY KEY (Id)
)
ENGINE = MYISAM
CHARACTER SET cp1251
COLLATE cp1251_general_ci;#inst#

CREATE TABLE `%%PRFX%%_rubric_fields` (
  Id MEDIUMINT(5) UNSIGNED NOT NULL AUTO_INCREMENT,
  RubrikId SMALLINT(3) UNSIGNED NOT NULL,
  Titel VARCHAR(255) NOT NULL,
  RubTyp VARCHAR(75) NOT NULL,
  rubric_position SMALLINT(3) UNSIGNED NOT NULL DEFAULT 1,
  StdWert TEXT NOT NULL,
  tpl_field TEXT NOT NULL,
  tpl_req TEXT NOT NULL,
  PRIMARY KEY (Id),
  INDEX RubrikId (RubrikId)
)
ENGINE = MYISAM
CHARACTER SET cp1251
COLLATE cp1251_general_ci;#inst#

CREATE TABLE `%%PRFX%%_rubric_template_cache` (
  id BIGINT(15) UNSIGNED NOT NULL AUTO_INCREMENT,
  `hash` CHAR(32) NOT NULL,
  rub_id SMALLINT(3) NOT NULL,
  grp_id SMALLINT(3) NOT NULL DEFAULT 2,
  doc_id INT(10) NOT NULL,
  wysiwyg ENUM ('0', '1') NOT NULL DEFAULT '0',
  expire INT(10) UNSIGNED DEFAULT 0,
  compiled LONGTEXT NOT NULL,
  PRIMARY KEY (id),
  INDEX rubric_id (rub_id, doc_id, wysiwyg)
)
ENGINE = MYISAM
CHARACTER SET cp1251
COLLATE cp1251_general_ci;#inst#

CREATE TABLE `%%PRFX%%_rubrics` (
  Id SMALLINT(3) UNSIGNED NOT NULL AUTO_INCREMENT,
  RubrikName VARCHAR(255) NOT NULL,
  UrlPrefix VARCHAR(255) NOT NULL,
  RubrikTemplate TEXT NOT NULL,
  Vorlage SMALLINT(3) UNSIGNED NOT NULL DEFAULT 1,
  RBenutzer INT(10) UNSIGNED NOT NULL DEFAULT 1,
  RDatum INT(10) UNSIGNED NOT NULL DEFAULT 0,
  PRIMARY KEY (Id),
  INDEX Vorlage (Vorlage)
)
ENGINE = MYISAM
CHARACTER SET cp1251
COLLATE cp1251_general_ci;#inst#

CREATE TABLE `%%PRFX%%_sessions` (
  sesskey VARCHAR(32),
  expiry INT(10) UNSIGNED NOT NULL DEFAULT 0,
  value TEXT NOT NULL,
  Ip VARCHAR(35) NOT NULL,
  expire_datum VARCHAR(25) NOT NULL,
  PRIMARY KEY (sesskey),
  INDEX expire_datum (expire_datum),
  INDEX expiry (expiry)
)
ENGINE = MYISAM
CHARACTER SET cp1251
COLLATE cp1251_general_ci;#inst#

CREATE TABLE `%%PRFX%%_settings` (
  Id TINYINT(1) UNSIGNED NOT NULL AUTO_INCREMENT,
  site_name VARCHAR(255) NOT NULL,
  mail_type ENUM ('mail', 'smtp', 'sendmail') NOT NULL DEFAULT 'mail',
  mail_content_type ENUM ('text/plain', 'text/html') NOT NULL DEFAULT 'text/plain',
  mail_port SMALLINT(3) UNSIGNED NOT NULL DEFAULT 25,
  mail_host VARCHAR(255) NOT NULL,
  mail_smtp_login VARCHAR(50) NOT NULL,
  mail_smtp_pass VARCHAR(50) NOT NULL,
  mail_sendmail_path VARCHAR(255) NOT NULL DEFAULT '/usr/sbin/sendmail',
  mail_word_wrap SMALLINT(3) NOT NULL DEFAULT 50,
  mail_from VARCHAR(255) NOT NULL,
  mail_from_name VARCHAR(255) NOT NULL,
  mail_new_user TEXT NOT NULL,
  mail_signature TEXT NOT NULL,
  page_not_found_id INT(10) UNSIGNED NOT NULL DEFAULT 2,
  message_forbidden TEXT NOT NULL,
  navi_box VARCHAR(255) NOT NULL,
  start_label VARCHAR(255) NOT NULL,
  end_label VARCHAR(255) NOT NULL,
  separator_label VARCHAR(255) NOT NULL,
  next_label VARCHAR(255) NOT NULL,
  prev_label VARCHAR(255) NOT NULL,
  total_label VARCHAR(255) NOT NULL,
  date_format VARCHAR(25) NOT NULL DEFAULT '%d.%m.%Y',
  time_format VARCHAR(25) NOT NULL DEFAULT '%d.%m.%Y, %H:%M',
  default_country CHAR(2) NOT NULL DEFAULT 'ru',
  use_doctime ENUM ('1', '0') NOT NULL DEFAULT '1',
  hidden_text TEXT NOT NULL,
  PRIMARY KEY (Id)
)
ENGINE = MYISAM
CHARACTER SET cp1251
COLLATE cp1251_general_ci;#inst#

CREATE TABLE `%%PRFX%%_templates` (
  Id SMALLINT(3) UNSIGNED NOT NULL AUTO_INCREMENT,
  TplName VARCHAR(255) NOT NULL,
  Template LONGTEXT NOT NULL,
  TBenutzer INT(10) UNSIGNED NOT NULL,
  TDatum INT(10) UNSIGNED NOT NULL,
  PRIMARY KEY (Id)
)
ENGINE = MYISAM
CHARACTER SET cp1251
COLLATE cp1251_general_ci;#inst#

CREATE TABLE `%%PRFX%%_user_groups` (
  Benutzergruppe SMALLINT(3) UNSIGNED NOT NULL AUTO_INCREMENT,
  Name CHAR(50) NOT NULL,
  Aktiv ENUM ('1', '0') NOT NULL DEFAULT '1',
  set_default_avatar ENUM ('1', '0') NOT NULL DEFAULT '0',
  default_avatar CHAR(255) NOT NULL,
  Rechte CHAR(255) NOT NULL,
  PRIMARY KEY (Benutzergruppe)
)
ENGINE = MYISAM
CHARACTER SET cp1251
COLLATE cp1251_general_ci;#inst#

CREATE TABLE `%%PRFX%%_users` (
  Id INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  Kennwort CHAR(32) NOT NULL,
  Email CHAR(100) NOT NULL,
  Strasse CHAR(100) NOT NULL,
  HausNr CHAR(10) NOT NULL,
  Postleitzahl CHAR(15) NOT NULL,
  city CHAR(100) NOT NULL,
  Telefon CHAR(35) NOT NULL,
  Telefax CHAR(35) NOT NULL,
  Bemerkungen CHAR(255) NOT NULL,
  Vorname CHAR(50) NOT NULL,
  Nachname CHAR(50) NOT NULL,
  UserName CHAR(50) NOT NULL,
  Benutzergruppe SMALLINT(3) UNSIGNED NOT NULL DEFAULT 4,
  BenutzergruppeMisc CHAR(255) NOT NULL,
  Registriert INT(10) UNSIGNED NOT NULL,
  Status ENUM ('1', '0') NOT NULL DEFAULT '1',
  ZuletztGesehen INT(10) UNSIGNED NOT NULL,
  Land CHAR(2) NOT NULL DEFAULT 'ru',
  GebTag CHAR(10) NOT NULL,
  Geloescht ENUM ('1', '0') NOT NULL DEFAULT '0',
  GeloeschtDatum INT(10) UNSIGNED NOT NULL,
  emc CHAR(32) NOT NULL,
  IpReg CHAR(20) NOT NULL,
  new_pass CHAR(32) NOT NULL,
  Firma CHAR(255) NOT NULL,
  UStPflichtig ENUM ('1', '0') NOT NULL DEFAULT '0',
  salt CHAR(16) NOT NULL,
  new_salt CHAR(16) NOT NULL,
  user_ip INT(10) UNSIGNED NOT NULL DEFAULT 0,
  PRIMARY KEY (Id),
  INDEX BenutzerGruppe (Benutzergruppe),
  UNIQUE INDEX Email (Email),
  UNIQUE INDEX UserName (UserName)
)
ENGINE = MYISAM
CHARACTER SET cp1251
COLLATE cp1251_general_ci;