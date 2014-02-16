-- phpMyAdmin SQL Dump
-- version 4.0.5
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Erstellungszeit: 16. Feb 2014 um 04:59
-- Server Version: 5.1.66-0+squeeze1
-- PHP-Version: 5.3.16

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;



-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `00_einstellungenSoftware`
--

CREATE TABLE IF NOT EXISTS `00_einstellungenSoftware` (
  `nr` int(5) NOT NULL AUTO_INCREMENT,
  `SessionJaNein` int(1) NOT NULL DEFAULT '0',
  `Desc_Session` varchar(20) NOT NULL,
  `Beschreibung` varchar(255) NOT NULL,
  `InhaltDerEinstellung` text NOT NULL,
  `letzteAenderung` datetime NOT NULL,
  PRIMARY KEY (`nr`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=96 ;

--
-- Daten für Tabelle `00_einstellungenSoftware`
--

INSERT INTO `00_einstellungenSoftware` (`nr`, `SessionJaNein`, `Desc_Session`, `Beschreibung`, `InhaltDerEinstellung`, `letzteAenderung`) VALUES
(1, 1, 'SE_profilDelMonth', 'User- Profil wird nach x Monaten (mit Leih Daten) Inaktivität gelöscht.', '12', '2014-01-01 01:01:01'),
(2, 1, 'SE_GooTrans', 'Google Translate an?', '1', '2014-01-01 01:01:01'),
(6, 0, 'SE_cronJob', 'cronjob aktiv oder nicht', '0', '2014-01-01 01:01:01'),
(7, 1, 'SE_KarTimeAbholungMi', 'Karenzzeit in x min bei Nichtabholung einer Reservierung', '60', '2014-01-01 01:01:01'),
(3, 1, 'SE_AdressModuleYesNo', 'Adress Modul aktiv?', '1', '2014-01-01 01:01:01'),
(4, 1, 'SE_twitterModuleActi', 'twitter Modul aktiv?', '0', '2014-01-01 01:01:01'),
(5, 1, 'SE_MoneyModule', 'monetäres Modul aktiv?', '0', '2014-01-01 01:01:01'),
(8, 1, 'SE_GooTransScript', 'Script für Google Translate', '<div id="google_translate_element"></div>\n<script>\nfunction googleTranslateElementInit() {\n  new google.translate.TranslateElement({\n    pageLanguage: ''de'',\n    layout: google.translate.TranslateElement.InlineLayout.SIMPLE\n  }, ''google_translate_element'');\n}\n</script>\n<script src="http://translate.google.com/translate_a/element.js?cb=googleTranslateElementInit"></script>', '2014-01-01 01:01:01'),
(9, 1, 'SE_AccessContrYN', 'Matrikel N°, Ausweisnummer o.ö. soll geprüft werden (und Prüfung bei Registrierung)', '0', '2014-01-01 01:01:01'),
(10, 1, 'SE_AccessContrName', 'Bezeichnung für Kontrollnummer (Matrikelnummer, Personalausweisnummer etc.)', 'Identnummer', '2014-01-01 01:01:01'),
(11, 0, 'SE_reCap_private', 'recaptcha privat Schlüssel', '', '2014-01-01 01:01:01'),
(12, 0, 'SE_reCap_public', 'recaptcha öffentlicher Schlüssel', '', '2014-01-01 01:01:01'),
(13, 1, 'SE_vortextJaNein', 'für Nutzungsbedingungen oder Hinweise', '1', '2014-01-01 01:01:01'),
(14, 0, 'SE_vortextInhalt', 'Inhalt des Nutzungstextes', 'Vortext für Leihbedingungen \noder andere Hinweise.\n', '2014-01-01 01:01:01'),
(89, 1, 'SE_versandMod', 'Versandmodul', '0', '2014-01-01 01:01:01'),
(90, 1, 'SE_versandURL', 'Url für nähere Infos zum Versand', 'http://DEINE_VERSAND_URL', '2014-01-01 01:01:01'),
(91, 1, 'SE_versandPreisAll', 'Preis für Komplettversand', '1', '2014-01-01 01:01:01'),
(15, 0, 'SE_auth_consumerKey', '', '', '2014-01-01 01:01:01'),
(16, 0, 'SE_consumerSecret', '', '', '2014-01-01 01:01:01'),
(17, 0, 'SE_oAuthToken', '', '', '2014-01-01 01:01:01'),
(81, 0, 'SE_oAuthSecret', '', '', '2014-01-01 01:01:01'),
(18, 1, 'SE_ProtokollAnAus', 'Alle Aktivitäten werden Protokolliert', '1', '2014-01-01 01:01:01'),
(19, 1, 'SE_GleichLeiheMoegli', 'Recht "ausleihebereichtigt" nach Registrierung?', '1', '2014-01-01 01:01:01'),
(20, 1, 'SE_ProfilOnOff', 'Ist das Profil nach der Registierung aktiviert oder deaktiviert?', '1', '2014-01-01 01:01:01'),
(21, 1, 'SE_adminEMail', 'Absenderadresse Reg Bestätigung & Mail bei Fehlern in der Software, z.B. wenn ein Profil deaktiviert ist', 'DEINE-EMAIL ADRESSE', '2014-01-01 01:01:01'),
(22, 1, 'SE_Kundenname', 'Zuordnung für Support (bei Mail Versand als Absender)', 'Organisationsname', '2014-01-01 01:01:01'),
(23, 0, 'SE_TextRegBestaetigu', 'Text nach Registrierung', '\nSehr geehrte Dame, \nsehr geehrter Herr,\n\nmit dieser Benachrichtigung können Sie \ndie Ausleihe  nutzen.\nAm Ende dieser Nachricht befinden sich \ndie Zugangsdaten. Ihr Passwort \nkönnen Sie nach dem Login ändern. \n\nSie erreichen den Login-Bereich direkt unter: \n\n\nHerzlichen Gruß,\ndas Team der Ausleihe\n', '2014-01-01 01:01:01'),
(24, 1, 'SE_festUrl', 'Hauptseite mit http:// für Weiterleitungen und Bilder (z.B. HTML5 Footer Bild) Wichtig: Slash am Ende, damit Verzeichnis aktiviert wird!!', 'DEINE URL MIT HTTP UND SLASH (NICHT BACKSLASH) AM ENDE DER URL', '2014-01-01 01:01:01'),
(25, 1, 'SE_VerfallAccountTag', 'Anzahl der Tage, die vertreichen muss, um einen Account nach der Registrierung zu löschen. (Inaktivität)', '3', '2014-01-01 01:01:01'),
(27, 1, 'SE_normaloMaxStartTa', '(normalo Benutzer) maximale Anzahl der Tage,die zwischen jetzt und Beginn&Ende der Leihe liegen dürfen', '80', '2014-01-01 01:01:01'),
(28, 1, 'SE_normaloMaxDauerTa', '(normalo Benutzer) maximale Zeitspanne in Tagen pro Ausleih-Item', '5', '22014-01-01 01:01:01'),
(29, 1, 'SE_DauerleiheMaxStar', '(Dauerleihe Benutzer) maximale Anzahl der Tage,die zwischen jetzt und Beginn&Ende der Leihe liegen dürfen', '180', '2014-01-01 01:01:01'),
(30, 1, 'SE_DauerleiheMaxDaue', '(Dauerleihe Benutzer) maximale Zeitspanne in Tagen pro Ausleih-Item', '90', '2014-01-01 01:01:01'),
(31, 1, 'SE_ViewLeihmodHauptg', 'Soll der Nutzer bei der Ausleihe via Hauptgruppen ausleihen können?', '1', '2014-01-01 01:01:01'),
(32, 1, 'SE_ViewLeihmodEinzel', 'Soll der Nutzer bei der Ausleihe via Einzelgeräte ausleihen können?', '1', '2014-01-01 01:01:01'),
(33, 1, 'SE_ViewLeihmodTag', 'Soll der Nutzer bei der Ausleihe via Tags ausleihen können?', '1', '2014-01-01 01:01:01'),
(34, 1, 'SE_jQuerUI', 'Code für Include jquery & ui & pnot', '<script type="text/javascript" src="<DEINE_URL>/BL_JS/jquery-2.0.2.min.js"></script><script type="text/javascript" src="<DEINE_URL>/BL_JS/jquery-ui.min.js"></script><script type="text/javascript" src="<DEINE_URL>/BL_JS/jq_pnotify/jquery.pnotify.min.js"></script>', '2014-01-01 01:01:01'),
(35, 1, 'SE_IntervStunde', 'Schritte pro Stunde , z.B. 4= 4x15 min IST AUCH MINDESTAUSLEIHEZEIT!!!', '2', '2014-01-01 01:01:01'),
(36, 1, 'SE_MoGeschlOderZeite', '0=zu 1=es gelten die ind. Öffnungszeiten', '1', '2014-01-01 01:01:01'),
(37, 1, 'SE_DiGeschlOderZeite', '0=zu 1=es gelten die ind. Öffnungszeiten', '0', '2014-01-01 01:01:01'),
(38, 1, 'SE_MiGeschlOderZeite', '0=zu 1=es gelten die ind. Öffnungszeiten', '0', '2014-01-01 01:01:01'),
(39, 1, 'SE_DoGeschlOderZeite', '0=zu 1=es gelten die ind. Öffnungszeiten', '0', '2014-01-01 01:01:01'),
(40, 1, 'SE_FrGeschlOderZeite', '0=zu 1=es gelten die ind. Öffnungszeiten', '0', '2014-01-01 01:01:01'),
(41, 1, 'SE_SaGeschlOderZeite', '0=zu 1=es gelten die ind. Öffnungszeiten', '1', '2014-01-01 01:01:01'),
(42, 1, 'SE_SoGeschlOderZeite', '0=zu 1=es gelten die ind. Öffnungszeiten', '1', '2014-01-01 01:01:01'),
(43, 1, 'SE_MoOffen11', '', '4', '2014-01-01 01:01:01'),
(44, 1, 'SE_MoOffen12', '', '13', '2014-01-01 01:01:01'),
(45, 1, 'SE_MoOffen21', '', '-', '2014-01-01 01:01:01'),
(46, 1, 'SE_MoOffen22', '', '-', '2014-01-01 01:01:01'),
(47, 1, 'SE_DiOffen11', '', '8', '2014-01-01 01:01:01'),
(48, 1, 'SE_DiOffen12', '', '17', '2014-01-01 01:01:01'),
(49, 1, 'SE_DiOffen21', '', '-', '2014-01-01 01:01:01'),
(50, 1, 'SE_DiOffen22', '', '-', '2014-01-01 01:01:01'),
(51, 1, 'SE_MiOffen11', '', '10', '2014-01-01 01:01:01'),
(52, 1, 'SE_MiOffen12', '', '15', '2014-01-01 01:01:01'),
(53, 1, 'SE_MiOffen21', '', '-', '2014-01-01 01:01:01'),
(54, 1, 'SE_MiOffen22', '', '-', '2014-01-01 01:01:01'),
(55, 1, 'SE_DoOffen11', '', '10', '2014-01-01 01:01:01'),
(56, 1, 'SE_DoOffen12', '', '21', '2014-01-01 01:01:01'),
(57, 1, 'SE_DoOffen21', '', '-', '2014-01-01 01:01:01'),
(58, 1, 'SE_DoOffen22', '', '-', '2014-01-01 01:01:01'),
(59, 1, 'SE_FrOffen11', '', '7', '2014-01-01 01:01:01'),
(60, 1, 'SE_FrOffen12', '', '11', '2014-01-01 01:01:01'),
(61, 1, 'SE_FrOffen21', '', '-', '2014-01-01 01:01:01'),
(62, 1, 'SE_FrOffen22', '', '-', '2014-01-01 01:01:01'),
(63, 1, 'SE_SaOffen11', '', '6', '2014-01-01 01:01:01'),
(64, 1, 'SE_SaOffen12', '', '11', '2014-01-01 01:01:01'),
(65, 1, 'SE_SaOffen21', '', '12', '2014-01-01 01:01:01'),
(66, 1, 'SE_SaOffen22', '', '15', '2014-01-01 01:01:01'),
(67, 1, 'SE_SoOffen11', '', '0', '2014-01-01 01:01:01'),
(68, 1, 'SE_SoOffen12', '', '11', '2014-01-01 01:01:01'),
(69, 1, 'SE_SoOffen21', '', '-', '2014-01-01 01:01:01'),
(70, 1, 'SE_SoOffen22', '', '-', '2014-01-01 01:01:01'),
(71, 1, 'SE_EndeIndex', 'Dateien am Ende jeder Datei  /// Bemerkung: wenn jquerys toggle vom ie unterstützt wird: && parseInt($.browser.version, 10)<9', '<script>\nif ( $.browser.msie && parseInt($.browser.version, 10)!=9) {\nalert("Bitte beachten Sie, dass Ihr Browser (Internet Explorer) veraltert ist und nur begrenzt alle (HTML5) Funktionen von BORROW LAND anbietet. Empfehlung: Mozilla Firefox, Opera und Safari \\n\\nPlease note, that the Internet Explorer (your current browser) does not support all (HTML5) features of BORROW LAND. recommendation: Mozilla Firefox, Opera or Safari");\n}\n\n				\n$(function(){\n	$(''.ui-state-default'').hover(\n		function(){$(this).addClass(''ui-state-hover'');},\n		function(){$(this).removeClass(''ui-state-hover'');}\n	)\n	.mousedown(function(){$(this).addClass(''ui-state-active'');})\n	.mouseup(function(){$(this).removeClass(''ui-state-active'');})\n	.mouseout(function(){$(this).removeClass(''ui-state-active'');});\n});\n</script>', '2014-01-01 01:01:01'),
(72, 0, 'SE_MailRecov', 'E-Mail Text wenn Passwort neu zugesendet werden soll', 'Passwort-Wiederherstellung Ausleihsoftware \n<IHRE ORGANISATION>\n\nSehr geehrte Dame, Sehr geehrter Herr,\n\naufgrund der Anforderung auf den Webseiten\nzur Ausleihe senden wir Ihnen auf diesem\nWeg Ihr neues Passwort am Ende dieser\nE-Mail zu. \n\nSollten Sie diesen Vorgang nicht gestartet haben,\nbitten wir um eine kurze Nachricht.\n\nHerzlichen Gruß,\ndas Team der Ausleihe.', '2014-01-01 01:01:01'),
(73, 1, 'SE_AnzahlElemWKMax', 'maximale Anzahl der Warenkorb Elemente', '10', '2014-01-01 01:01:01'),
(77, 1, 'SE_MoneyModule_Mietp', 'Sollen auf den Verleihscheinen auch die Verleihpreise rauf?', '0', '2014-01-01 01:01:01'),
(26, 0, 'SE_imprint', 'Impressum', '\n\nRechtsverbindlicher Haftungsausschluss für Inhalte und Verlinkung:\nAlle Angaben und Daten wurden nach bestem Wissen erstellt, es wird jedoch keine Gewähr für deren Vollständigkeit und Richtigkeit übernommen. Dieser Onlineauftritt enthält Verknüpfungen auf die Internet-Inhalte anderer Anbieter (im folgenden "Links" genannt).\n erklärt ausdrücklich, dass zum Zeitpunkt einer Linksetzung die entsprechenden verlinkten Seiten frei von illegalen Inhalten waren.   hat keinerlei Einfluss auf die aktuelle und zukünftige Gestaltung und auf die Inhalte der verknüpften Seiten.\nDeshalb distanziert er sich hiermit ausdrücklich von allen Inhalten aller gelinkten Seiten, die nach der Linksetzung verändert wurden undschließt deshalb für diese jede Haftung aus.\n\nCopyright: Das Layout der Homepage, Texte, Bilder, Grafiken, und andere multimediale Dateien auf den Internetseiten  sind urheberrechtlich geschützt.\n\nAlle Abbildungen und Fotos auf den Webseiten sind Eigentum der Urheber und dürfen ohne ihre Genehmigung nicht übernommen, vervielfältigt und verbreitet werden. \n', '2014-01-01 01:01:01'),
(78, 1, 'SE_InfoFaellObj', 'Fällige Objekte werden in der Ausleiheverwaltung angezeigt.', '1', '2014-01-01 01:01:01'),
(79, 1, 'SE_TimeFreigabeLeihe', 'Zeitspanne in Stunden, wann eine Ausgabe der Leihe möglich ist, obwohl der Reservierungszeitraum noch nicht begonnen hat', '2', '2014-01-01 01:01:01'),
(80, 1, 'SE_RFIDModule', 'RFID Funktionalität anzeigen und anbieten', '0', '2014-01-01 01:01:01'),
(82, 0, 'SE_infoOeff_MO', '', 'Hinweisfeld für Montag', '2014-01-01 01:01:01'),
(83, 0, 'SE_infoOeff_DI', '', 'Hinweisfeld für Dienstag', '2014-01-01 01:01:01'),
(84, 0, 'SE_infoOeff_MI', '', 'Hinweisfeld für Mittwoch', '2014-01-01 01:01:01'),
(85, 0, 'SE_infoOeff_DO', '', 'Hinweisfeld für Donnerstag', '2014-01-01 01:01:01'),
(86, 0, 'SE_infoOeff_FR', '', 'Hinweisfeld für Freitag', '2014-01-01 01:01:01'),
(87, 0, 'SE_infoOeff_SA', '', 'Hinweisfeld für Sonnabend', '2014-01-01 01:01:01'),
(88, 0, 'SE_infoOeff_SO', '', 'Hinweisfeld für Sonntag', '2014-01-01 01:01:01'),
(92, 0, 'SE_headBereich', 'Head Bereich jeder Datei', '?>\n<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />\n<meta name="robots" content="noindex,nofollow" />\n<title>Die Ausleihsoftware BORROW LAND</title>\n\n<link rel="stylesheet" type="text/css" href="<? echo $_SESSION["SE_festUrl"]; ?>BL_CSS/Styles.css" />\n<link type="text/css" href="<? echo $_SESSION["SE_festUrl"]; ?>BL_CSS/le-frog/jquery-ui-1.8.16.custom.css" rel="stylesheet" />\n<link type="text/css" href="<? echo $_SESSION["SE_festUrl"]; ?>BL_JS/jq_pnotify/jquery.pnotify.default.css" rel="stylesheet" />\n\n<!-- Internet Explorer HTML5 enabling code: -->\n<!--[if IE]>\n<script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>\n\n<style type="text/css">\n.clear {\n  zoom: 1;\n  display: block;\n}\n</style>\n<![endif]-->\n\n<link rel="SHORTCUT ICON" href="<? echo $_SESSION["SE_festUrl"]; ?>favicon.ico" />', '2014-01-01 01:01:01'),
(93, 0, 'SE_tagAnzahl', 'Anzahl der tags im Bereich der Suche', '10', '2014-01-01 01:01:01'),
(94, 0, 'SE_twitterName', 'twitter Name wenn alles okay war', '', '2014-01-01 01:01:01'),
(95, 0, 'SE_VerfallWkTag', 'Anzahl Tage, wann WK gelöscht werden sollen, wenn alle Leihen x Tage vergangen', '10', '2014-01-01 01:01:01');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `01_Benutzer`
--

CREATE TABLE IF NOT EXISTS `01_Benutzer` (
  `id` int(50) NOT NULL AUTO_INCREMENT,
  `specid_cyrpt_md5` varchar(50) NOT NULL,
  `vortextBe` int(1) NOT NULL COMMENT 'Vortext',
  `vn_nn` varchar(100) NOT NULL COMMENT 'VornameNachname',
  `tn` varchar(20) NOT NULL COMMENT 'Telefonnummer',
  `m_id` varchar(50) NOT NULL COMMENT 'MatrikelID',
  `email` varchar(60) NOT NULL COMMENT 'EMail',
  `pw_hash` varchar(70) NOT NULL,
  `adr_strasse_hn` varchar(100) NOT NULL COMMENT 'Strasse mit hausnummer',
  `adr_plz` varchar(5) DEFAULT NULL COMMENT 'plz',
  `adr_stadt` varchar(100) NOT NULL COMMENT 'stadt oder ort',
  `ProfOnOff` int(1) NOT NULL COMMENT 'profil an oder aus',
  `userreg_selbst` int(40) NOT NULL COMMENT '(datum)',
  `userreg_bestaet` int(40) NOT NULL COMMENT '(datum)',
  `lastlogin` int(40) NOT NULL COMMENT '(datum)',
  `rechte_ausleihe` int(1) NOT NULL,
  `rechte_ausgabeberechtigt` int(1) NOT NULL,
  `rechte_bestaetiger` int(1) NOT NULL,
  `rechte_dauerleihe` int(1) NOT NULL,
  `rechte_admin` int(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='Benutzer Tabelle' AUTO_INCREMENT=2 ;

--
-- Daten für Tabelle `01_Benutzer`
--

INSERT INTO `01_Benutzer` (`id`, `specid_cyrpt_md5`, `vortextBe`, `vn_nn`, `tn`, `m_id`, `email`, `pw_hash`, `adr_strasse_hn`, `adr_plz`, `adr_stadt`, `ProfOnOff`, `userreg_selbst`, `userreg_bestaet`, `lastlogin`, `rechte_ausleihe`, `rechte_ausgabeberechtigt`, `rechte_bestaetiger`, `rechte_dauerleihe`, `rechte_admin`) VALUES
(0, '3c6f58a59f83cc757e7dcbd860a7e264', 1, 'Vorname Nachname', '0381123456789', 'Modul Pruef-ID war nicht aktiviert', 'deinemailadressefuerden@login.com', '5c2c0ea5ed029de6e454119b6290465d72a5187d5c6d549ee931a26320a8e49d', 'Forbes Ave 5000 ', '15213', 'Pittsburgh PA ', 1, 283996800, 283996800, 283996800, 1, 1, 1, 1, 1),
(1, '670806171ab34129fb2476580b0a614ab43d15ed', 1, 'Vorname Nachname 2', '0381123456789', 'Modul Pruef-ID war nicht aktiviert', 'deinemailadressefuerden2@login.com', '05ec1221e60a3bc1ede4b2033ec14c719aa3b6b12e44ae11d4b28cac91a19831', 'Strasse Hausnummer 2', '12345', 'Hüttenhausen', 1, 283996800, 283996800, 283996800, 1, 1, 1, 1, 1);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `02_protokoll`
--

CREATE TABLE IF NOT EXISTS `02_protokoll` (
  `id` int(50) NOT NULL AUTO_INCREMENT,
  `wann` datetime NOT NULL,
  `gruppe` int(2) DEFAULT NULL COMMENT '0=generell, 1=benutzer, 2=sicherheit, 3=passwort, 4=autom.datenlöschung',
  `untergruppe` int(2) DEFAULT NULL COMMENT 'bei gruppe 0&1: 0=gelöscht, 1=hinzugefügt, 2=geändert; @@ bei 2: 0=niedrig, 1=mittel, 3=hoch @@ bei 3: 1=geändert user, 2=geändert system @@ bei 4: wk wegen ablauf gelöscht',
  `descr` varchar(500) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='Protokoll der Ausleihesoftware' AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `03_obj_hauptgruppen`
--

CREATE TABLE IF NOT EXISTS `03_obj_hauptgruppen` (
  `id` int(50) NOT NULL AUTO_INCREMENT,
  `specid_hg` varchar(50) DEFAULT NULL COMMENT 'wird erstellt aus datum(sekundengenau) und angemeldetet nutzer',
  `Kurzbez` varchar(50) NOT NULL,
  `langeBeschre` text NOT NULL,
  `ErstelltAm` int(40) NOT NULL,
  `ErstelltVon` varchar(100) NOT NULL,
  `HGruppenOnOff` int(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='Hauptgruppen der Ausleihesoftware mit Flag Reparatur ' AUTO_INCREMENT=2 ;

--
-- Daten für Tabelle `03_obj_hauptgruppen`
--

INSERT INTO `03_obj_hauptgruppen` (`id`, `specid_hg`, `Kurzbez`, `langeBeschre`, `ErstelltAm`, `ErstelltVon`, `HGruppenOnOff`) VALUES
(1, '372f5c4d10452b8b6be3a0d23f894e812a0d1e8e', 'Hardware', 'Eine tolle Beschreibung für die Gruppe Hardware, z.B. AMD Prozessoren', 1392511425, 'Vorname Nachname', 1);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `04_obj_objekte`
--

CREATE TABLE IF NOT EXISTS `04_obj_objekte` (
  `id` int(50) NOT NULL AUTO_INCREMENT,
  `specid_obj` varchar(50) DEFAULT NULL COMMENT 'wird erstellt aus datum(sekundengenau) und angemeldetet nutzer',
  `Kurzbez` varchar(50) NOT NULL,
  `langeBeschre` text NOT NULL,
  `ErstelltAm` int(40) NOT NULL,
  `ErstelltVon` varchar(100) NOT NULL,
  `HGruppe` varchar(50) NOT NULL,
  `ObjOnOff` int(1) NOT NULL,
  `Mietpreis1` varchar(20) NOT NULL COMMENT 'Mietpreis für kleinste Mieteinheit (SE_IntervStunde)',
  `Mietpreis2` varchar(20) NOT NULL COMMENT 'Angabe für Tagesmiete, um Rabatt anzubieten',
  `Mietpreis3` varchar(50) CHARACTER SET ucs2 NOT NULL COMMENT 'zeitlich unabhängiger Mietpreis, Angabe ohne Berechnung',
  `aktivierterMietpreis` int(1) NOT NULL COMMENT '0=niht festgelegt, 1+2=berechnung anhand zeit, 3=individuell',
  `VorschauAnAus` int(1) NOT NULL COMMENT 'soll das Gerät bei der Vorschau angezeigt werden?',
  `Wiederbeschaffungswert` varchar(20) NOT NULL,
  `metatags` text NOT NULL COMMENT 'mit ; getrennt',
  `interneBez` varchar(50) CHARACTER SET latin1 NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='Mögliche Objekte (Abhängig von Hauptgruppen)' AUTO_INCREMENT=2 ;

--
-- Daten für Tabelle `04_obj_objekte`
--

INSERT INTO `04_obj_objekte` (`id`, `specid_obj`, `Kurzbez`, `langeBeschre`, `ErstelltAm`, `ErstelltVon`, `HGruppe`, `ObjOnOff`, `Mietpreis1`, `Mietpreis2`, `Mietpreis3`, `aktivierterMietpreis`, `VorschauAnAus`, `Wiederbeschaffungswert`, `metatags`, `interneBez`) VALUES
(1, 'e67c13e295f4cc026eaa94f230f0821a014622f4', 'CPU AMD', 'Eine CPU die sehr gut arbeitet.', 1392511662, 'Vorname Nachname', '372f5c4d10452b8b6be3a0d23f894e812a0d1e8e', 1, '', '', '', 0, 1, '', 'CPU,AMD,Büro', '');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `05_wk`
--

CREATE TABLE IF NOT EXISTS `05_wk` (
  `id` int(50) NOT NULL AUTO_INCREMENT,
  `specid_wk` varchar(50) NOT NULL,
  `owner` varchar(50) NOT NULL COMMENT 'specid_cyrpt_md5 aus 01_Benutzer',
  `erstellt_am` int(40) NOT NULL,
  `bemerkungen` varchar(255) NOT NULL,
  `fuer_dritte` int(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='Metadaten Warenkorb mit Angabe iner möglichen Ort-Ausleihe ' AUTO_INCREMENT=2 ;

--
-- Daten für Tabelle `05_wk`
--

INSERT INTO `05_wk` (`id`, `specid_wk`, `owner`, `erstellt_am`, `bemerkungen`, `fuer_dritte`) VALUES
(1, '6640307be9e56b444adac53e65dd29eb8586c079', '3c6f58a59f83cc757e7dcbd860a7e264', 1392523004, 'angelegt mit 1 Element/en', 0);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `06_wkObje`
--

CREATE TABLE IF NOT EXISTS `06_wkObje` (
  `id` int(50) NOT NULL AUTO_INCREMENT,
  `wkid` varchar(50) NOT NULL COMMENT 'specid_wk aus 05_wk',
  `geraet` varchar(50) NOT NULL COMMENT 'specid_obj aus 04_obj_objekte ',
  `von` int(40) NOT NULL,
  `bis` int(40) NOT NULL,
  `abgeholt` int(40) DEFAULT NULL,
  `gebracht` int(40) DEFAULT NULL,
  `bemerkungen` varchar(255) NOT NULL,
  `versandObj` int(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='Objekte im Warenkorb und dessen Attribute' AUTO_INCREMENT=2 ;

--
-- Daten für Tabelle `06_wkObje`
--

INSERT INTO `06_wkObje` (`id`, `wkid`, `geraet`, `von`, `bis`, `abgeholt`, `gebracht`, `bemerkungen`, `versandObj`) VALUES
(1, '6640307be9e56b444adac53e65dd29eb8586c079', 'e67c13e295f4cc026eaa94f230f0821a014622f4', 1392613200, 1393216200, NULL, NULL, '', 0);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `07_wkHistory`
--

CREATE TABLE IF NOT EXISTS `07_wkHistory` (
  `id` int(50) NOT NULL AUTO_INCREMENT,
  `specid_wk` varchar(50) NOT NULL,
  `owner` varchar(50) NOT NULL COMMENT 'specid_cyrpt_md5 aus 01_Benutzer',
  `geloescht_am` int(40) NOT NULL,
  `bemerkungen` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='Warenkorb Archiv' AUTO_INCREMENT=1 ;


--
-- Tabellenstruktur für Tabelle `08_statistik`
--

CREATE TABLE IF NOT EXISTS `08_statistik` (
  `no` int(20) NOT NULL AUTO_INCREMENT,
  `datum` datetime NOT NULL,
  `aktiveObjekte` int(20) NOT NULL COMMENT 'deaktivierte werden nicht berücksichtigt (Berechnung Auslastung 1)',
  `ausgegebeneObjekte` int(20) NOT NULL COMMENT '(Objekte1) UND alles was draussen ist (Berechnung Auslastung 2) ',
  `beendteWKs` int(20) NOT NULL,
  `aktiveWKs` int(20) NOT NULL,
  `NutzerGesamt` int(20) NOT NULL,
  `NutzerAusleihe` int(20) NOT NULL,
  `NutzerAusgabe` int(20) NOT NULL,
  `NutzerDL` int(20) NOT NULL,
  `NutzerBestaetig` int(20) NOT NULL,
  `NutzerAdmin` int(20) NOT NULL,
  `reservierteObjeGesamt` int(20) NOT NULL COMMENT '(Objekte2) ausgegeben ist schon vorher erhoben',
  `reservierteObjeBeendet` int(20) NOT NULL COMMENT '(Objekte3)',
  `deaktiveObjekte` int(20) NOT NULL,
  `aktiveHG` int(20) NOT NULL,
  `deaktiveHG` int(20) NOT NULL,
  `dateiGrMediaVerz` int(20) NOT NULL,
  `SummeWiederBesc` varchar(20) NOT NULL,
  PRIMARY KEY (`no`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='Grundlage für Ausgabe Statistik' AUTO_INCREMENT=1 ;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
