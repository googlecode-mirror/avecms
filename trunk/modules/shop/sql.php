<?php

$modul_sql_install = array();
$modul_sql_deinstall = array();
$modul_sql_update = array();

// установка (структура)
$modul_sql_install[] = "CREATE TABLE `CPPREFIX_modul_shop` (
  `Id` smallint(2) unsigned NOT NULL auto_increment,
  `country_code` tinyint(1) unsigned NOT NULL default '0',
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
  `custom` int(10) unsigned default '0',
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
) ENGINE=MyISAM DEFAULT CHARSET=cp1251;";

$modul_sql_install[] = "CREATE TABLE `CPPREFIX_modul_shop_artikel` (
  `Id` int(10) unsigned NOT NULL auto_increment,
  `ArtNr` varchar(200) NOT NULL,
  `KatId` int(10) unsigned NOT NULL default '0',
  `KatId_Multi` text NOT NULL,
  `ArtName` varchar(255) NOT NULL,
  `country_code` smallint(1) unsigned NOT NULL default '1',
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
  `Hersteller` mediumint(3) default NULL,
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
  KEY `Preis` (`Preis`)
) ENGINE=MyISAM DEFAULT CHARSET=cp1251 PACK_KEYS=0;";

$modul_sql_install[] = "CREATE TABLE `CPPREFIX_modul_shop_artikel_bilder` (
  `Id` int(10) unsigned NOT NULL auto_increment,
  `ArtId` int(10) unsigned NOT NULL default '0',
  `Bild` varchar(255) NOT NULL,
  PRIMARY KEY  (`Id`)
) ENGINE=MyISAM DEFAULT CHARSET=cp1251 PACK_KEYS=0;";

$modul_sql_install[] = "CREATE TABLE `CPPREFIX_modul_shop_artikel_downloads` (
  `Id` int(10) unsigned NOT NULL auto_increment,
  `ArtId` varchar(255) NOT NULL,
  `Datei` varchar(255) NOT NULL,
  `DateiTyp` enum('full','update','bugfix','other') NOT NULL default 'full',
  `TageNachKauf` mediumint(5) NOT NULL default '365',
  `Bild` varchar(255) NOT NULL,
  `title` varchar(200) NOT NULL,
  `description` text NOT NULL,
  `Position` mediumint(3) unsigned NOT NULL default '1',
  PRIMARY KEY  (`Id`)
) ENGINE=MyISAM DEFAULT CHARSET=cp1251;";

$modul_sql_install[] = "CREATE TABLE `CPPREFIX_modul_shop_artikel_kommentare` (
  `Id` int(8) unsigned NOT NULL auto_increment,
  `ArtId` int(10) unsigned NOT NULL default '0',
  `Benutzer` int(10) unsigned NOT NULL default '0',
  `Datum` int(14) unsigned NOT NULL default '0',
  `title` varchar(255) NOT NULL,
  `comment_text` text NOT NULL,
  `Wertung` smallint(1) unsigned NOT NULL default '0',
  `Publik` tinyint(1) unsigned NOT NULL default '0',
  PRIMARY KEY  (`Id`)
) ENGINE=MyISAM DEFAULT CHARSET=cp1251;";

$modul_sql_install[] = "CREATE TABLE `CPPREFIX_modul_shop_bestellungen` (
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
) ENGINE=MyISAM DEFAULT CHARSET=cp1251 PACK_KEYS=0;";

$modul_sql_install[] = "CREATE TABLE `CPPREFIX_modul_shop_downloads` (
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
) ENGINE=MyISAM DEFAULT CHARSET=cp1251;";

$modul_sql_install[] = "CREATE TABLE `CPPREFIX_modul_shop_einheiten` (
  `Id` int(10) unsigned NOT NULL auto_increment,
  `Name` varchar(100) NOT NULL,
  `NameEinzahl` varchar(255) NOT NULL,
  PRIMARY KEY  (`Id`),
  UNIQUE KEY `Name` (`Name`)
) ENGINE=MyISAM DEFAULT CHARSET=cp1251;";

$modul_sql_install[] = "CREATE TABLE `CPPREFIX_modul_shop_gutscheine` (
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
) ENGINE=MyISAM DEFAULT CHARSET=cp1251;";

$modul_sql_install[] = "CREATE TABLE `CPPREFIX_modul_shop_hersteller` (
  `Id` mediumint(5) unsigned NOT NULL auto_increment,
  `Name` varchar(255) NOT NULL,
  `Link` varchar(255) default NULL,
  `Logo` varchar(255) default NULL,
  PRIMARY KEY  (`Id`),
  UNIQUE KEY `Name` (`Name`)
) ENGINE=MyISAM DEFAULT CHARSET=cp1251;";

$modul_sql_install[] = "CREATE TABLE `CPPREFIX_modul_shop_kategorie` (
  `Id` mediumint(5) unsigned NOT NULL auto_increment,
  `parent_id` mediumint(5) unsigned NOT NULL default '0',
  `KatName` varchar(100) default NULL,
  `KatBeschreibung` text NOT NULL,
  `position` smallint(3) unsigned NOT NULL default '1',
  `Bild` varchar(255) NOT NULL,
  `bid` int(5) unsigned NOT NULL default '0',
  `cbid` int(5) unsigned NOT NULL default '0',
  PRIMARY KEY  (`Id`),
  KEY `KatName` (`KatName`)
) ENGINE=MyISAM DEFAULT CHARSET=cp1251 PACK_KEYS=0;";

$modul_sql_install[] = "CREATE TABLE `CPPREFIX_modul_shop_kundenrabatte` (
  `Id` smallint(3) unsigned NOT NULL auto_increment,
  `GruppenId` smallint(3) unsigned NOT NULL default '0',
  `Wert` decimal(7,2) unsigned NOT NULL default '0.00',
  PRIMARY KEY  (`Id`),
  UNIQUE KEY `GruppenId` (`GruppenId`)
) ENGINE=MyISAM DEFAULT CHARSET=cp1251;";

$modul_sql_install[] = "CREATE TABLE `CPPREFIX_modul_shop_merkliste` (
  `Id` int(10) unsigned NOT NULL auto_increment,
  `Benutzer` int(10) unsigned NOT NULL default '0',
  `Ip` varchar(200) NOT NULL,
  `Inhalt` text NOT NULL,
  `Inhalt_Vars` text NOT NULL,
  PRIMARY KEY  (`Id`)
) ENGINE=MyISAM DEFAULT CHARSET=cp1251;";

$modul_sql_install[] = "CREATE TABLE `CPPREFIX_modul_shop_staffelpreise` (
  `Id` int(10) unsigned NOT NULL auto_increment,
  `ArtId` int(10) unsigned NOT NULL default '0',
  `StkVon` mediumint(5) NOT NULL default '2',
  `StkBis` mediumint(5) NOT NULL default '5',
  `Preis` decimal(10,2) NOT NULL default '0.00',
  PRIMARY KEY  (`Id`),
  KEY `ArtId` (`ArtId`),
  KEY `Preis` (`Preis`)
) ENGINE=MyISAM DEFAULT CHARSET=cp1251;";

$modul_sql_install[] = "CREATE TABLE `CPPREFIX_modul_shop_ust` (
  `Id` smallint(3) unsigned NOT NULL auto_increment,
  `Name` varchar(100) NOT NULL,
  `Wert` decimal(4,2) NOT NULL default '16.00',
  PRIMARY KEY  (`Id`)
) ENGINE=MyISAM DEFAULT CHARSET=cp1251;";

$modul_sql_install[] = "CREATE TABLE `CPPREFIX_modul_shop_varianten` (
  `Id` int(10) unsigned NOT NULL auto_increment,
  `KatId` int(10) unsigned NOT NULL default '0',
  `ArtId` int(10) unsigned NOT NULL default '0',
  `Name` varchar(255) NOT NULL,
  `Wert` decimal(7,2) NOT NULL default '0.00',
  `Operant` enum('+','-') NOT NULL default '+',
  `Position` smallint(2) unsigned NOT NULL default '1',
  `Vorselektiert` tinyint(1) unsigned NOT NULL default '0',
  PRIMARY KEY  (`Id`),
  KEY `KatId` (`KatId`),
  KEY `ArtId` (`ArtId`)
) ENGINE=MyISAM DEFAULT CHARSET=cp1251;";

$modul_sql_install[] = "CREATE TABLE `CPPREFIX_modul_shop_varianten_kategorien` (
  `Id` int(10) unsigned NOT NULL auto_increment,
  `KatId` mediumint(5) unsigned NOT NULL default '0',
  `Name` varchar(200) NOT NULL,
  `description` text NOT NULL,
  `country_code` tinyint(1) unsigned NOT NULL default '1',
  PRIMARY KEY  (`Id`),
  KEY `KatId` (`KatId`)
) ENGINE=MyISAM DEFAULT CHARSET=cp1251;";

$modul_sql_install[] = "CREATE TABLE `CPPREFIX_modul_shop_versandarten` (
  `Id` int(10) unsigned NOT NULL auto_increment,
  `Name` varchar(200) NOT NULL default '',
  `description` text NOT NULL,
  `Icon` varchar(255) NOT NULL default '',
  `LaenderVersand` tinytext NOT NULL,
  `Pauschalkosten` decimal(5,2) NOT NULL default '0.00',
  `KeineKosten` tinyint(1) unsigned NOT NULL default '0',
  `country_code` tinyint(1) unsigned NOT NULL default '0',
  `NurBeiGewichtNull` tinyint(1) unsigned NOT NULL default '0',
  `ErlaubteGruppen` tinytext NOT NULL,
  PRIMARY KEY  (`Id`)
) ENGINE=MyISAM DEFAULT CHARSET=cp1251;";

$modul_sql_install[] = "CREATE TABLE `CPPREFIX_modul_shop_versandkosten` (
  `Id` int(10) unsigned NOT NULL auto_increment,
  `VersandId` int(10) unsigned NOT NULL default '0',
  `country` char(2) NOT NULL default 'RU',
  `KVon` decimal(8,3) NOT NULL default '0.001',
  `KBis` decimal(8,3) NOT NULL default '10.000',
  `Betrag` decimal(7,2) NOT NULL default '0.00',
  PRIMARY KEY  (`Id`)
) ENGINE=MyISAM DEFAULT CHARSET=cp1251;";

$modul_sql_install[] = "CREATE TABLE `CPPREFIX_modul_shop_versandzeit` (
  `Id` smallint(2) unsigned NOT NULL auto_increment,
  `Name` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `Icon` varchar(255) NOT NULL,
  PRIMARY KEY  (`Id`)
) ENGINE=MyISAM DEFAULT CHARSET=cp1251;";

$modul_sql_install[] = "CREATE TABLE `CPPREFIX_modul_shop_zahlungsmethoden` (
  `Id` mediumint(5) unsigned NOT NULL auto_increment,
  `Name` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `ErlaubteVersandLaender` tinytext NOT NULL,
  `ErlaubteVersandarten` tinytext NOT NULL,
  `ErlaubteGruppen` tinytext NOT NULL,
  `country_code` tinyint(1) unsigned NOT NULL default '0',
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
) ENGINE=MyISAM DEFAULT CHARSET=cp1251;";


// установка (данные)
$modul_sql_install[] = "INSERT INTO `CPPREFIX_modul_shop` VALUES ();";

// удаление
$modul_sql_deinstall[] = "DROP TABLE CPPREFIX_modul_shop";
$modul_sql_deinstall[] = "DROP TABLE CPPREFIX_modul_shop_artikel";
$modul_sql_deinstall[] = "DROP TABLE CPPREFIX_modul_shop_artikel_bilder";
$modul_sql_deinstall[] = "DROP TABLE CPPREFIX_modul_shop_artikel_downloads";
$modul_sql_deinstall[] = "DROP TABLE CPPREFIX_modul_shop_artikel_kommentare";
$modul_sql_deinstall[] = "DROP TABLE CPPREFIX_modul_shop_bestellungen";
$modul_sql_deinstall[] = "DROP TABLE CPPREFIX_modul_shop_einheiten";
$modul_sql_deinstall[] = "DROP TABLE CPPREFIX_modul_shop_downloads";
$modul_sql_deinstall[] = "DROP TABLE CPPREFIX_modul_shop_gutscheine";
$modul_sql_deinstall[] = "DROP TABLE CPPREFIX_modul_shop_hersteller";
$modul_sql_deinstall[] = "DROP TABLE CPPREFIX_modul_shop_kategorie";
$modul_sql_deinstall[] = "DROP TABLE CPPREFIX_modul_shop_kundenrabatte";
$modul_sql_deinstall[] = "DROP TABLE CPPREFIX_modul_shop_merkliste";
$modul_sql_deinstall[] = "DROP TABLE CPPREFIX_modul_shop_staffelpreise";
$modul_sql_deinstall[] = "DROP TABLE CPPREFIX_modul_shop_ust";
$modul_sql_deinstall[] = "DROP TABLE CPPREFIX_modul_shop_varianten";
$modul_sql_deinstall[] = "DROP TABLE CPPREFIX_modul_shop_varianten_kategorien";
$modul_sql_deinstall[] = "DROP TABLE CPPREFIX_modul_shop_versandarten";
$modul_sql_deinstall[] = "DROP TABLE CPPREFIX_modul_shop_versandkosten";
$modul_sql_deinstall[] = "DROP TABLE CPPREFIX_modul_shop_versandzeit";
$modul_sql_deinstall[] = "DROP TABLE CPPREFIX_modul_shop_zahlungsmethoden";

// обновление
$modul_sql_update[] = "UPDATE CPPREFIX_module SET CpEngineTag = '" . $modul['CpEngineTag'] . "', CpPHPTag = '" . $modul['CpPHPTag'] . "', Version = '" . $modul['ModulVersion'] . "' WHERE ModulPfad = '" . $modul['ModulPfad'] . "' LIMIT 1;";

?>