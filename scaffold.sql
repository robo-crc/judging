CREATE DATABASE  IF NOT EXISTS `crc_judge` /*!40100 DEFAULT CHARACTER SET latin1 */;
USE `crc_judge`;
-- MySQL dump 10.13  Distrib 5.7.17, for macos10.12 (x86_64)
--
-- Host: localhost    Database: crc_judge
-- ------------------------------------------------------
-- Server version	5.6.22-cll-lve

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `journalism_rubric`
--

DROP TABLE IF EXISTS `journalism_rubric`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `journalism_rubric` (
  `id` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `judge_id` smallint(5) unsigned NOT NULL DEFAULT '0' COMMENT 'Who cast the vote',
  `school_id` tinyint(3) unsigned NOT NULL COMMENT 'What team the vote is for',
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT 'When the vote was cast',
  `1` enum('true','false') NOT NULL,
  `2` tinyint(3) unsigned NOT NULL,
  `3` tinyint(3) unsigned NOT NULL,
  `4` tinyint(3) unsigned NOT NULL,
  `5` tinyint(3) unsigned NOT NULL,
  `6` tinyint(3) unsigned NOT NULL,
  `7` tinyint(3) unsigned NOT NULL,
  `comments` text,
  `total` int(10) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `judge_id` (`judge_id`),
  KEY `school_id` (`school_id`)
) ENGINE=InnoDB AUTO_INCREMENT=55 DEFAULT CHARSET=utf8 COMMENT='Journalism rubric hints.';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `overall`
--

DROP TABLE IF EXISTS `overall`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `overall` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `school_id` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `judge_id` smallint(5) unsigned NOT NULL DEFAULT '0',
  `component` enum('video','journalism','web','kiosk','build','design') DEFAULT NULL,
  `score` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `submitted` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `school_id` (`school_id`),
  KEY `component` (`component`)
) ENGINE=InnoDB AUTO_INCREMENT=264 DEFAULT CHARSET=utf8 COMMENT='Overall ranking for all schools across all categories';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `schools`
--

DROP TABLE IF EXISTS `schools`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `schools` (
  `id` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT 'School ID',
  `name` varchar(150) NOT NULL DEFAULT '0' COMMENT 'School Name',
  `video` varchar(200) DEFAULT NULL COMMENT 'Video URL',
  `web` varchar(200) DEFAULT NULL COMMENT 'Web site URL',
  `journalism` varchar(200) DEFAULT NULL COMMENT 'Web site URL',
  `result_key` varchar(40) DEFAULT NULL,
  `contact_name` varchar(45) DEFAULT NULL,
  `contact_email` varchar(250) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Mapping table for schools.';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users` (
  `id` smallint(6) NOT NULL AUTO_INCREMENT COMMENT 'User UUID',
  `email` varchar(255) NOT NULL DEFAULT '0' COMMENT 'User email',
  `pin` varchar(6) DEFAULT NULL COMMENT 'Access PIN',
  `state` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '0 = Enabled, 1 = Suspended',
  `lang` enum('en','fr') NOT NULL DEFAULT 'en',
  `firstname` varchar(255) NOT NULL DEFAULT '0' COMMENT 'First name',
  `lastname` varchar(255) NOT NULL DEFAULT '0' COMMENT 'Family name',
  `affiliation` varchar(255) DEFAULT NULL,
  `role` tinyint(3) unsigned DEFAULT '0',
  `lastactivity` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT 'Last activity',
  `year` int(4) unsigned NOT NULL DEFAULT '2015' COMMENT 'The year the judge agreed to participate.',
  `section` varchar(45) DEFAULT NULL COMMENT 'Journalism, web, video',
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`),
  KEY `state` (`state`),
  KEY `lang` (`lang`)
) ENGINE=InnoDB AUTO_INCREMENT=55 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `web_rubric`
--

DROP TABLE IF EXISTS `web_rubric`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `web_rubric` (
  `id` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `judge_id` smallint(5) unsigned NOT NULL DEFAULT '0' COMMENT 'Who cast this vote.',
  `school_id` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT 'The team',
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT 'When this vote was cast',
  `1` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT 'Axis 1',
  `2` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT 'Axis 2',
  `3` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT 'Axis 3',
  `4` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT 'Axis 4',
  `5` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT 'Axis 5',
  `6` enum('true','false') NOT NULL DEFAULT 'false',
  `comments` text,
  `total` int(10) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `judge_id` (`judge_id`),
  KEY `school_id` (`school_id`)
) ENGINE=InnoDB AUTO_INCREMENT=74 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping events for database 'crc_judge'
--

--
-- Dumping routines for database 'crc_judge'
--
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2017-02-16 19:26:47
