-- MySQL dump 10.13  Distrib 8.0.29, for Linux (x86_64)
--
-- Host: localhost    Database: capstone2
-- ------------------------------------------------------
-- Server version	8.0.29-0ubuntu0.20.04.3

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Current Database: `capstone2`
--

CREATE DATABASE /*!32312 IF NOT EXISTS*/ `capstone2` /*!40100 DEFAULT CHARACTER SET latin1 */ /*!80016 DEFAULT ENCRYPTION='N' */;

USE `capstone2`;

--
-- Table structure for table `_state`
--

DROP TABLE IF EXISTS `_state`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `_state` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `abbrev` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `state_abbrev` (`abbrev`)
) ENGINE=InnoDB AUTO_INCREMENT=79 DEFAULT CHARSET=utf8mb3 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `_state`
--

LOCK TABLES `_state` WRITE;
/*!40000 ALTER TABLE `_state` DISABLE KEYS */;
INSERT INTO `_state` VALUES (1,'AL','Alabama'),(2,'AK','Alaska'),(4,'AZ','Arizona'),(5,'AR','Arkansas'),(6,'CA','California'),(8,'CO','Colorado'),(9,'CT','Connecticut'),(10,'DE','Delaware'),(11,'DC','District of Columbia'),(12,'FL','Florida'),(13,'GA','Georgia'),(15,'HI','Hawaii'),(16,'ID','Idaho'),(17,'IL','Illinois'),(18,'IN','Indiana'),(19,'IA','Iowa'),(20,'KS','Kansas'),(21,'KY','Kentucky'),(22,'LA','Louisiana'),(23,'ME','Maine'),(24,'MD','Maryland'),(25,'MA','Massachusetts'),(26,'MI','Michigan'),(27,'MN','Minnesota'),(28,'MS','Mississippi'),(29,'MO','Missouri'),(30,'MT','Montana'),(31,'NE','Nebraska'),(32,'NV','Nevada'),(33,'NH','New Hampshire'),(34,'NJ','New Jersey'),(35,'NM','New Mexico'),(36,'NY','New York'),(37,'NC','North Carolina'),(38,'ND','North Dakota'),(39,'OH','Ohio'),(40,'OK','Oklahoma'),(41,'OR','Oregon'),(42,'PA','Pennsylvania'),(44,'RI','Rhode Island'),(45,'SC','South Carolina'),(46,'SD','South Dakota'),(47,'TN','Tennessee'),(48,'TX','Texas'),(49,'UT','Utah'),(50,'VT','Vermont'),(51,'VA','Virginia'),(53,'WA','Washington'),(54,'WV','West Virginia'),(55,'WI','Wisconsin'),(56,'WY','Wyoming'),(72,'PR','Puerto Rico'),(78,'VI','Virgin Islands');
/*!40000 ALTER TABLE `_state` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `professor`
--

DROP TABLE IF EXISTS `professor`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `professor` (
  `username` varchar(12) DEFAULT NULL,
  `first_name` varchar(25) DEFAULT NULL,
  `last_name` varchar(40) DEFAULT NULL,
  `id` int NOT NULL AUTO_INCREMENT,
  `status` tinyint unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `status` (`status`),
  CONSTRAINT `professor_ibfk_1` FOREIGN KEY (`status`) REFERENCES `profstatus` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `professor`
--

LOCK TABLES `professor` WRITE;
/*!40000 ALTER TABLE `professor` DISABLE KEYS */;
INSERT INTO `professor` VALUES ('jbeck','Jon','Beck',1,2),('wbailey','Wayne','Bailey',2,2),('rdare','Ruthie','Halma',3,1),('agarvey','Alan','Garvey',4,1),('jneitzke','John','Neitzke',5,2),('matthews','Bob','Matthews',6,2),('benlewis','Ben','Lewis',7,2),('jseiffertt','John','Seiffertt',8,2),('ac','Ankit','Chaudhary',9,2),('kerrin','Kerrin','Smith',10,2),('cjaiswal','Chetan','Jaiswal',11,1),('jerhart','John','Erhart',12,2),('kafi','Kafi','Rahman',13,1),('tingcao','Ting','Cao',14,1),('cyyu','Charles','Yu',15,1);
/*!40000 ALTER TABLE `professor` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `profstatus`
--

DROP TABLE IF EXISTS `profstatus`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `profstatus` (
  `id` tinyint unsigned NOT NULL AUTO_INCREMENT,
  `description` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `profstatus`
--

LOCK TABLES `profstatus` WRITE;
/*!40000 ALTER TABLE `profstatus` DISABLE KEYS */;
INSERT INTO `profstatus` VALUES (1,'Active'),(2,'Inactive');
/*!40000 ALTER TABLE `profstatus` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `proposal`
--

DROP TABLE IF EXISTS `proposal`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `proposal` (
  `title` varchar(1000) DEFAULT NULL,
  `supervisor` varchar(75) DEFAULT NULL,
  `date_created` datetime DEFAULT NULL,
  `date_last_edited` datetime DEFAULT NULL,
  `date_preapproved` datetime DEFAULT NULL,
  `date_completed` datetime DEFAULT NULL,
  `id` int NOT NULL AUTO_INCREMENT,
  `student_id` int DEFAULT NULL,
  `company` varchar(75) DEFAULT NULL,
  `capstoneID` int DEFAULT NULL,
  `description` text,
  `professor1_id` int DEFAULT NULL,
  `professor2_id` int DEFAULT NULL,
  `professor3_id` int DEFAULT NULL,
  `status` tinyint unsigned NOT NULL DEFAULT '0',
  `proptype` tinyint unsigned NOT NULL DEFAULT '0',
  `other` varchar(255) NOT NULL DEFAULT '',
  `city` varchar(255) DEFAULT NULL,
  `state` int unsigned DEFAULT NULL,
  `country` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `status` (`status`),
  KEY `proposal_state_fk` (`state`),
  CONSTRAINT `proposal_ibfk_1` FOREIGN KEY (`status`) REFERENCES `propstatus` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  CONSTRAINT `proposal_state_fk` FOREIGN KEY (`state`) REFERENCES `_state` (`id`) ON DELETE RESTRICT ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=1319 DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `proposal`
--

LOCK TABLES `proposal` WRITE;
/*!40000 ALTER TABLE `proposal` DISABLE KEYS */;
/*!40000 ALTER TABLE `proposal` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `proposal_notes`
--

DROP TABLE IF EXISTS `proposal_notes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `proposal_notes` (
  `proposal_id` int DEFAULT NULL,
  `date` datetime DEFAULT NULL,
  `id` int NOT NULL AUTO_INCREMENT,
  `note` mediumtext,
  `author_id` int unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=417 DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `proposal_notes`
--

LOCK TABLES `proposal_notes` WRITE;
/*!40000 ALTER TABLE `proposal_notes` DISABLE KEYS */;
/*!40000 ALTER TABLE `proposal_notes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `propstatus`
--

DROP TABLE IF EXISTS `propstatus`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `propstatus` (
  `id` tinyint unsigned NOT NULL AUTO_INCREMENT,
  `description` varchar(255) NOT NULL,
  `sortorder` tinyint unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `propstatus`
--

LOCK TABLES `propstatus` WRITE;
/*!40000 ALTER TABLE `propstatus` DISABLE KEYS */;
INSERT INTO `propstatus` VALUES (1,'Completed',3),(2,'Awaiting Pre-approval',1),(3,'Pre-approved',2),(4,'Inactivated',4);
/*!40000 ALTER TABLE `propstatus` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `proptype`
--

DROP TABLE IF EXISTS `proptype`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `proptype` (
  `id` tinyint unsigned NOT NULL AUTO_INCREMENT,
  `description` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `proptype`
--

LOCK TABLES `proptype` WRITE;
/*!40000 ALTER TABLE `proptype` DISABLE KEYS */;
INSERT INTO `proptype` VALUES (1,'Corporate Internship'),(2,'Research Internship'),(3,'On-Campus SW Project'),(4,'Personal SW Project'),(5,'Individual Research'),(6,'Other');
/*!40000 ALTER TABLE `proptype` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `student`
--

DROP TABLE IF EXISTS `student`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `student` (
  `username` varchar(12) DEFAULT NULL,
  `first_name` varchar(25) DEFAULT NULL,
  `last_name` varchar(40) DEFAULT NULL,
  `banner_id` varchar(9) DEFAULT NULL,
  `hours` int unsigned NOT NULL DEFAULT '0',
  `id` int NOT NULL AUTO_INCREMENT,
  `grad_month` varchar(255) NOT NULL DEFAULT '',
  `grad_year` int unsigned NOT NULL DEFAULT '0',
  `last_login` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `student_username` (`username`)
) ENGINE=InnoDB AUTO_INCREMENT=2313 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `student`
--

LOCK TABLES `student` WRITE;
/*!40000 ALTER TABLE `student` DISABLE KEYS */;
/*!40000 ALTER TABLE `student` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tmpcmp`
--

DROP TABLE IF EXISTS `tmpcmp`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tmpcmp` (
  `name` varchar(255) DEFAULT NULL,
  `banner` char(9) NOT NULL,
  `title` varchar(255) DEFAULT NULL,
  `cmpdate` date DEFAULT NULL,
  PRIMARY KEY (`banner`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tmpcmp`
--

LOCK TABLES `tmpcmp` WRITE;
/*!40000 ALTER TABLE `tmpcmp` DISABLE KEYS */;
/*!40000 ALTER TABLE `tmpcmp` ENABLE KEYS */;
UNLOCK TABLES;

