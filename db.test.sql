-- phpMyAdmin SQL Dump
-- version 3.3.9.2
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Erstellungszeit: 11. August 2016 um 17:32
-- Server Version: 5.1.66
-- PHP-Version: 5.3.3-7+squeeze19

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

--
-- Datenbank: `test`
--
CREATE DATABASE `test` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `test`;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `tbl_category`
--

CREATE TABLE IF NOT EXISTS `tbl_category` (
  `categoryid` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `parent_categoryid` int(11) unsigned DEFAULT NULL,
  `name` varchar(255) NOT NULL,
  `description` varchar(45) DEFAULT NULL,
  `sortorder` int(11) DEFAULT NULL,
  `icon` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`categoryid`),
  KEY `fk_tbl_category_tbl_category1_idx` (`parent_categoryid`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=9 ;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `tbl_commentary`
--

CREATE TABLE IF NOT EXISTS `tbl_commentary` (
  `commentaryid` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `parent_commentaryid` int(11) unsigned DEFAULT NULL,
  `username` varchar(255) DEFAULT NULL,
  `ip` varchar(32) DEFAULT NULL,
  `message` varchar(2000) DEFAULT NULL,
  `tstamp_created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `tstamp_modified` timestamp NULL DEFAULT NULL,
  `tstamp_deleted` timestamp NULL DEFAULT NULL,
  `gameid` int(11) unsigned NOT NULL,
  PRIMARY KEY (`commentaryid`),
  KEY `fk_tbl_commentary_tbl_game1_idx` (`gameid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `tbl_country`
--

CREATE TABLE IF NOT EXISTS `tbl_country` (
  `countryiso2` char(2) NOT NULL,
  `description` varchar(255) DEFAULT NULL,
  `has_clubs` int(1) NOT NULL,
  PRIMARY KEY (`countryiso2`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `tbl_country_language`
--

CREATE TABLE IF NOT EXISTS `tbl_country_language` (
  `countryiso2` char(2) NOT NULL,
  `languageiso2` char(2) NOT NULL,
  PRIMARY KEY (`countryiso2`,`languageiso2`),
  KEY `languageiso2` (`languageiso2`),
  KEY `countryiso2` (`countryiso2`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `tbl_game`
--

CREATE TABLE IF NOT EXISTS `tbl_game` (
  `gameid` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `userid` int(11) unsigned NOT NULL,
  `title` varchar(255) NOT NULL,
  `title_seo` varchar(255) DEFAULT NULL,
  `description_short` varchar(155) NOT NULL,
  `description_medium` varchar(2000) DEFAULT NULL,
  `description` text NOT NULL,
  `total_rating` double unsigned NOT NULL DEFAULT '0',
  `total_in` int(11) unsigned DEFAULT '0',
  `total_out` int(11) unsigned DEFAULT '0',
  `tstamp_created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `tstamp_modified` timestamp NULL DEFAULT NULL,
  `tstamp_deleted` timestamp NULL DEFAULT NULL,
  `reviewtext` text,
  `review_rating_graphics` double DEFAULT NULL,
  `review_rating_gameplay` double DEFAULT NULL,
  `review_rating_fun` double DEFAULT NULL,
  `review_rating_motivation` double DEFAULT NULL,
  `review_rating_handling` double DEFAULT NULL,
  `review_rating_total` double DEFAULT NULL,
  `developer` varchar(255) DEFAULT NULL,
  `publisher` varchar(255) DEFAULT NULL,
  `url` varchar(255) DEFAULT NULL,
  `banner` varchar(255) DEFAULT NULL,
  `genre` varchar(255) DEFAULT NULL,
  `releasedate` varchar(255) DEFAULT NULL,
  `players` varchar(255) DEFAULT NULL,
  `languages` varchar(255) DEFAULT NULL,
  `is_special_game` int(1) NOT NULL DEFAULT '0',
  `views` int(11) NOT NULL DEFAULT '0',
  `review_rating_text` varchar(2000) DEFAULT NULL,
  `is_active` int(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`gameid`),
  UNIQUE KEY `title_UNIQUE` (`title`),
  KEY `fk_tbl_game_tbl_user_idx` (`userid`),
  KEY `is_special_game` (`is_special_game`),
  KEY `total_in` (`total_in`),
  KEY `total_out` (`total_out`),
  KEY `is_active` (`is_active`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=73 ;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `tbl_game_category`
--

CREATE TABLE IF NOT EXISTS `tbl_game_category` (
  `gameid` int(11) unsigned NOT NULL,
  `categoryid` int(11) unsigned NOT NULL,
  PRIMARY KEY (`gameid`,`categoryid`),
  KEY `fk_tbl_category_has_tbl_game_tbl_game1_idx` (`gameid`),
  KEY `fk_tbl_category_has_tbl_game_tbl_category1_idx` (`categoryid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `tbl_game_history`
--

CREATE TABLE IF NOT EXISTS `tbl_game_history` (
  `gamehistoryid` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `gameid` int(11) unsigned NOT NULL,
  `userid` int(11) unsigned NOT NULL,
  `infotext` varchar(2000) DEFAULT NULL,
  `tstamp_created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`gamehistoryid`),
  KEY `gameid` (`gameid`,`userid`),
  KEY `userid` (`userid`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=82 ;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `tbl_game_in`
--

CREATE TABLE IF NOT EXISTS `tbl_game_in` (
  `gameinid` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `gameid` int(11) unsigned NOT NULL,
  `ip` varchar(12) NOT NULL,
  `tstamp_created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`gameinid`),
  UNIQUE KEY `UQ_IP_GAME` (`ip`,`gameid`),
  KEY `fk_tbl_game_in_tbl_game1_idx` (`gameid`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3460 ;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `tbl_game_out`
--

CREATE TABLE IF NOT EXISTS `tbl_game_out` (
  `gameoutid` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `gameid` int(11) unsigned NOT NULL,
  `ip` varchar(12) DEFAULT NULL,
  `tstamp_created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`gameoutid`),
  UNIQUE KEY `UQ_IP_OUT` (`gameid`,`ip`),
  KEY `fk_tbl_game_out_tbl_game1_idx` (`gameid`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2985 ;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `tbl_game_plattform`
--

CREATE TABLE IF NOT EXISTS `tbl_game_plattform` (
  `gameid` int(11) unsigned NOT NULL,
  `plattformid` int(11) unsigned NOT NULL,
  PRIMARY KEY (`gameid`,`plattformid`),
  KEY `plattformid` (`plattformid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `tbl_game_rating`
--

CREATE TABLE IF NOT EXISTS `tbl_game_rating` (
  `gameratingid` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `gameid` int(11) unsigned NOT NULL,
  `ip` varchar(32) DEFAULT NULL,
  `rating` int(1) NOT NULL,
  `tstamp_created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`gameratingid`),
  UNIQUE KEY `gameid_2` (`gameid`,`ip`),
  KEY `gameid` (`gameid`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=399 ;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `tbl_game_tag`
--

CREATE TABLE IF NOT EXISTS `tbl_game_tag` (
  `gameid` int(11) unsigned NOT NULL,
  `tagid` int(11) unsigned NOT NULL,
  PRIMARY KEY (`gameid`,`tagid`),
  KEY `fk_tbl_game_has_tbl_tag_tbl_tag1_idx` (`tagid`),
  KEY `fk_tbl_game_has_tbl_tag_tbl_game1_idx` (`gameid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `tbl_game_view`
--

CREATE TABLE IF NOT EXISTS `tbl_game_view` (
  `gameviewid` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `gameid` int(11) unsigned NOT NULL,
  `ip` varchar(32) NOT NULL,
  `tstamp_created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`gameviewid`),
  UNIQUE KEY `gameid_2` (`gameid`,`ip`),
  KEY `gameid` (`gameid`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=75171 ;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `tbl_image`
--

CREATE TABLE IF NOT EXISTS `tbl_image` (
  `imageid` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) DEFAULT NULL,
  `gameid` int(11) unsigned NOT NULL,
  `filename` varchar(255) DEFAULT NULL,
  `path` varchar(255) DEFAULT NULL,
  `sortorder` int(3) NOT NULL DEFAULT '1',
  `tstamp_created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `tstamp_modified` timestamp NULL DEFAULT NULL,
  `tstamp_deleted` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`imageid`),
  KEY `fk_tbl_images_tbl_game1_idx` (`gameid`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=530 ;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `tbl_language`
--

CREATE TABLE IF NOT EXISTS `tbl_language` (
  `languageiso2` char(2) NOT NULL,
  `description` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`languageiso2`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `tbl_mailqueue`
--

CREATE TABLE IF NOT EXISTS `tbl_mailqueue` (
  `mailqueueid` int(11) NOT NULL AUTO_INCREMENT,
  `userid` int(11) unsigned DEFAULT NULL,
  `charset` varchar(50) NOT NULL DEFAULT 'utf-8',
  `senderadress` varchar(255) NOT NULL,
  `sendername` varchar(255) DEFAULT NULL,
  `mailtypename` varchar(255) NOT NULL,
  `subject` varchar(255) NOT NULL,
  `content` varchar(15000) DEFAULT NULL,
  `commentary` varchar(255) DEFAULT NULL,
  `filepath` varchar(255) DEFAULT NULL,
  `filename` varchar(255) DEFAULT NULL,
  `signature` varchar(4000) DEFAULT NULL,
  `tstamp_created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `tstamp_modified` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`mailqueueid`),
  KEY `mailtype` (`mailtypename`),
  KEY `IDX_MANAGER_MAILTYPE` (`userid`,`mailtypename`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `tbl_mailqueue_mailtype`
--

CREATE TABLE IF NOT EXISTS `tbl_mailqueue_mailtype` (
  `mailtypename` varchar(255) NOT NULL,
  PRIMARY KEY (`mailtypename`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `tbl_mailqueue_recipient`
--

CREATE TABLE IF NOT EXISTS `tbl_mailqueue_recipient` (
  `mailqueuerecipientid` int(11) NOT NULL AUTO_INCREMENT,
  `mailqueueid` int(11) NOT NULL,
  `recipientadress` varchar(255) NOT NULL,
  `recipientname` varchar(255) DEFAULT NULL,
  `typename` char(3) NOT NULL,
  `status` int(3) NOT NULL DEFAULT '0',
  `lasttry` timestamp NULL DEFAULT NULL,
  `trys` int(3) NOT NULL DEFAULT '0',
  `statustext` varchar(2000) DEFAULT NULL,
  `tstamp_created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `tstamp_modified` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`mailqueuerecipientid`),
  KEY `mailqueueid` (`mailqueueid`),
  KEY `recipienttype` (`typename`),
  KEY `IDX_TRY_STA_LAST` (`trys`,`status`,`lasttry`),
  KEY `IDX_STATUS` (`status`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Email Empfänger' AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `tbl_mailqueue_recipienttype`
--

CREATE TABLE IF NOT EXISTS `tbl_mailqueue_recipienttype` (
  `typename` char(3) NOT NULL,
  PRIMARY KEY (`typename`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `tbl_news`
--

CREATE TABLE IF NOT EXISTS `tbl_news` (
  `newsid` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `tstamp_created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `tstamp_modified` timestamp NULL DEFAULT NULL,
  `tstamp_deleted` timestamp NULL DEFAULT NULL,
  `gameid` int(11) unsigned NOT NULL,
  `content` text,
  `title` varchar(255) DEFAULT NULL,
  `userid` int(11) unsigned NOT NULL,
  PRIMARY KEY (`newsid`),
  KEY `fk_tbl_news_tbl_game1_idx` (`gameid`),
  KEY `userid` (`userid`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=13 ;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `tbl_plattform`
--

CREATE TABLE IF NOT EXISTS `tbl_plattform` (
  `plattformid` int(11) unsigned NOT NULL,
  `name` varchar(255) NOT NULL,
  `sortorder` int(3) NOT NULL DEFAULT '1',
  PRIMARY KEY (`plattformid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `tbl_tag`
--

CREATE TABLE IF NOT EXISTS `tbl_tag` (
  `tagid` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(45) NOT NULL,
  `tstamp_created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `tstamp_modified` timestamp NULL DEFAULT NULL,
  `tstamp_deleted` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`tagid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `tbl_translation_placeholder`
--

CREATE TABLE IF NOT EXISTS `tbl_translation_placeholder` (
  `translationplaceholderid` int(11) NOT NULL AUTO_INCREMENT,
  `placeholdername` varchar(255) NOT NULL,
  `tstamp_created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`translationplaceholderid`),
  UNIQUE KEY `placeholdername` (`placeholdername`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=26 ;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `tbl_translation_placeholder_content`
--

CREATE TABLE IF NOT EXISTS `tbl_translation_placeholder_content` (
  `translationcontentid` int(11) NOT NULL AUTO_INCREMENT,
  `translationplaceholderid` int(11) NOT NULL,
  `languageiso2` char(2) NOT NULL DEFAULT 'DE',
  `content` text NOT NULL,
  `hash` varchar(32) NOT NULL,
  `tstamp_created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `tstamp_modified` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`translationcontentid`),
  UNIQUE KEY `translationplaceholderid_2` (`translationplaceholderid`,`languageiso2`),
  KEY `languageiso2` (`languageiso2`),
  KEY `translationplaceholderid` (`translationplaceholderid`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=42 ;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `tbl_translation_template`
--

CREATE TABLE IF NOT EXISTS `tbl_translation_template` (
  `translationtemplateid` int(11) NOT NULL AUTO_INCREMENT,
  `templatename` varchar(255) NOT NULL,
  `commentary` text NOT NULL,
  `tstamp_created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`translationtemplateid`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=6 ;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `tbl_translation_template_placeholder`
--

CREATE TABLE IF NOT EXISTS `tbl_translation_template_placeholder` (
  `translationtemplateid` int(11) NOT NULL,
  `translationplaceholderid` int(11) NOT NULL,
  PRIMARY KEY (`translationtemplateid`,`translationplaceholderid`),
  KEY `translationplaceholderid` (`translationplaceholderid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `tbl_user`
--

CREATE TABLE IF NOT EXISTS `tbl_user` (
  `userid` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(45) NOT NULL,
  `password` varchar(32) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `tstamp_created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `tstamp_modified` timestamp NULL DEFAULT NULL,
  `tstamp_deleted` timestamp NULL DEFAULT NULL,
  `statusname` varchar(255) DEFAULT NULL,
  `tstamp_confirmed` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`userid`),
  UNIQUE KEY `username_UNIQUE` (`username`),
  UNIQUE KEY `email_UNIQUE` (`email`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `tbl_video`
--

CREATE TABLE IF NOT EXISTS `tbl_video` (
  `videoid` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `gameid` int(11) unsigned NOT NULL,
  `filename` varchar(255) DEFAULT NULL,
  `url` varchar(255) DEFAULT NULL,
  `tstamp_created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `tstamp_modified` timestamp NULL DEFAULT NULL,
  `tstamp_deleted` timestamp NULL DEFAULT NULL,
  `title` varchar(255) NOT NULL,
  PRIMARY KEY (`videoid`),
  KEY `fk_tbl_video_tbl_game1_idx` (`gameid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Constraints der exportierten Tabellen
--

--
-- Constraints der Tabelle `tbl_category`
--
ALTER TABLE `tbl_category`
  ADD CONSTRAINT `fk_tbl_category_tbl_category1` FOREIGN KEY (`parent_categoryid`) REFERENCES `tbl_category` (`categoryid`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints der Tabelle `tbl_commentary`
--
ALTER TABLE `tbl_commentary`
  ADD CONSTRAINT `fk_tbl_commentary_tbl_game1` FOREIGN KEY (`gameid`) REFERENCES `tbl_game` (`gameid`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints der Tabelle `tbl_country_language`
--
ALTER TABLE `tbl_country_language`
  ADD CONSTRAINT `tbl_country_language_ibfk_1` FOREIGN KEY (`countryiso2`) REFERENCES `tbl_country` (`countryiso2`),
  ADD CONSTRAINT `tbl_country_language_ibfk_2` FOREIGN KEY (`languageiso2`) REFERENCES `tbl_language` (`languageiso2`);

--
-- Constraints der Tabelle `tbl_game`
--
ALTER TABLE `tbl_game`
  ADD CONSTRAINT `fk_tbl_game_tbl_user` FOREIGN KEY (`userid`) REFERENCES `tbl_user` (`userid`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints der Tabelle `tbl_game_category`
--
ALTER TABLE `tbl_game_category`
  ADD CONSTRAINT `fk_tbl_category_has_tbl_game_tbl_category1` FOREIGN KEY (`categoryid`) REFERENCES `tbl_category` (`categoryid`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_tbl_category_has_tbl_game_tbl_game1` FOREIGN KEY (`gameid`) REFERENCES `tbl_game` (`gameid`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints der Tabelle `tbl_game_history`
--
ALTER TABLE `tbl_game_history`
  ADD CONSTRAINT `tbl_game_history_ibfk_1` FOREIGN KEY (`gameid`) REFERENCES `tbl_game` (`gameid`),
  ADD CONSTRAINT `tbl_game_history_ibfk_2` FOREIGN KEY (`userid`) REFERENCES `tbl_user` (`userid`);

--
-- Constraints der Tabelle `tbl_game_in`
--
ALTER TABLE `tbl_game_in`
  ADD CONSTRAINT `fk_tbl_game_in_tbl_game1` FOREIGN KEY (`gameid`) REFERENCES `tbl_game` (`gameid`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints der Tabelle `tbl_game_out`
--
ALTER TABLE `tbl_game_out`
  ADD CONSTRAINT `fk_tbl_game_out_tbl_game1` FOREIGN KEY (`gameid`) REFERENCES `tbl_game` (`gameid`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints der Tabelle `tbl_game_plattform`
--
ALTER TABLE `tbl_game_plattform`
  ADD CONSTRAINT `tbl_game_plattform_ibfk_1` FOREIGN KEY (`gameid`) REFERENCES `tbl_game` (`gameid`),
  ADD CONSTRAINT `tbl_game_plattform_ibfk_2` FOREIGN KEY (`plattformid`) REFERENCES `tbl_plattform` (`plattformid`);

--
-- Constraints der Tabelle `tbl_game_rating`
--
ALTER TABLE `tbl_game_rating`
  ADD CONSTRAINT `tbl_game_rating_ibfk_1` FOREIGN KEY (`gameid`) REFERENCES `tbl_game` (`gameid`);

--
-- Constraints der Tabelle `tbl_game_tag`
--
ALTER TABLE `tbl_game_tag`
  ADD CONSTRAINT `tbl_game_tag_ibfk_1` FOREIGN KEY (`tagid`) REFERENCES `tbl_tag` (`tagid`),
  ADD CONSTRAINT `tbl_game_tag_ibfk_2` FOREIGN KEY (`gameid`) REFERENCES `tbl_game` (`gameid`);

--
-- Constraints der Tabelle `tbl_game_view`
--
ALTER TABLE `tbl_game_view`
  ADD CONSTRAINT `tbl_game_view_ibfk_1` FOREIGN KEY (`gameid`) REFERENCES `tbl_game` (`gameid`);

--
-- Constraints der Tabelle `tbl_image`
--
ALTER TABLE `tbl_image`
  ADD CONSTRAINT `fk_tbl_images_tbl_game1` FOREIGN KEY (`gameid`) REFERENCES `tbl_game` (`gameid`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints der Tabelle `tbl_mailqueue`
--
ALTER TABLE `tbl_mailqueue`
  ADD CONSTRAINT `tbl_mailqueue_ibfk_1` FOREIGN KEY (`mailtypename`) REFERENCES `tbl_mailqueue_mailtype` (`mailtypename`),
  ADD CONSTRAINT `tbl_mailqueue_ibfk_2` FOREIGN KEY (`userid`) REFERENCES `tbl_user` (`userid`);

--
-- Constraints der Tabelle `tbl_mailqueue_recipient`
--
ALTER TABLE `tbl_mailqueue_recipient`
  ADD CONSTRAINT `FK_tbl_mailqueue_recipient_tbl_mailqueue` FOREIGN KEY (`mailqueueid`) REFERENCES `tbl_mailqueue` (`mailqueueid`),
  ADD CONSTRAINT `tbl_mailqueue_recipient_ibfk_1` FOREIGN KEY (`typename`) REFERENCES `tbl_mailqueue_recipienttype` (`typename`);

--
-- Constraints der Tabelle `tbl_news`
--
ALTER TABLE `tbl_news`
  ADD CONSTRAINT `fk_tbl_news_tbl_game1` FOREIGN KEY (`gameid`) REFERENCES `tbl_game` (`gameid`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `tbl_news_ibfk_1` FOREIGN KEY (`userid`) REFERENCES `tbl_user` (`userid`);

--
-- Constraints der Tabelle `tbl_translation_placeholder_content`
--
ALTER TABLE `tbl_translation_placeholder_content`
  ADD CONSTRAINT `tbl_translation_placeholder_content_ibfk_1` FOREIGN KEY (`languageiso2`) REFERENCES `tbl_language` (`languageiso2`),
  ADD CONSTRAINT `tbl_translation_placeholder_content_ibfk_2` FOREIGN KEY (`translationplaceholderid`) REFERENCES `tbl_translation_placeholder` (`translationplaceholderid`);

--
-- Constraints der Tabelle `tbl_translation_template_placeholder`
--
ALTER TABLE `tbl_translation_template_placeholder`
  ADD CONSTRAINT `tbl_translation_template_placeholder_ibfk_1` FOREIGN KEY (`translationtemplateid`) REFERENCES `tbl_translation_template` (`translationtemplateid`),
  ADD CONSTRAINT `tbl_translation_template_placeholder_ibfk_2` FOREIGN KEY (`translationplaceholderid`) REFERENCES `tbl_translation_placeholder` (`translationplaceholderid`);

--
-- Constraints der Tabelle `tbl_video`
--
ALTER TABLE `tbl_video`
  ADD CONSTRAINT `fk_tbl_video_tbl_game1` FOREIGN KEY (`gameid`) REFERENCES `tbl_game` (`gameid`) ON DELETE NO ACTION ON UPDATE NO ACTION;
