-- MySQL dump 10.19  Distrib 10.3.34-MariaDB, for debian-linux-gnu (x86_64)
--
-- Host: localhost    Database: ADAPT
-- ------------------------------------------------------
-- Server version	10.3.34-MariaDB-0ubuntu0.20.04.1

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `ADVS`
--

DROP TABLE IF EXISTS `ADVS`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ADVS` (
  `STORE_NAME` varchar(100) DEFAULT NULL,
  `SLOGAN` varchar(180) DEFAULT NULL,
  `DESCRIPTION` varchar(180) DEFAULT NULL,
  `IMG` varchar(180) DEFAULT NULL,
  `TOTAL_PAID` decimal(10,0) DEFAULT NULL,
  `LAST_PAID_ON` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `FLAGGED` int(11) DEFAULT NULL,
  `START` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `END` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `SERIAL` int(11) DEFAULT NULL,
  `URL` varchar(300) DEFAULT NULL,
  `SEEN` int(11) DEFAULT NULL,
  `ZIP` int(11) DEFAULT NULL,
  `NUMS` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ADVS`
--

LOCK TABLES `ADVS` WRITE;
/*!40000 ALTER TABLE `ADVS` DISABLE KEYS */;
/*!40000 ALTER TABLE `ADVS` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `AD_REVS`
--

DROP TABLE IF EXISTS `AD_REVS`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `AD_REVS` (
  `STORE_UNIQ` int(11) NOT NULL AUTO_INCREMENT,
  `STORE_CREDITOR` varchar(100) DEFAULT NULL,
  `PHONE` int(11) DEFAULT NULL,
  `ADS_RUN` int(11) DEFAULT NULL,
  `TOTAL_SPENT` int(11) DEFAULT NULL,
  `IMG_DIR` varchar(200) DEFAULT NULL,
  `FLAGS` int(11) DEFAULT NULL,
  `JOINED_ON` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `LEFT_ON` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `AVG_HRS_DAY` decimal(10,0) DEFAULT NULL,
  `AVG_ADS_HR` decimal(10,0) DEFAULT NULL,
  `REVIEWS` int(11) DEFAULT NULL,
  `REVIEW_TALLY` int(11) DEFAULT NULL,
  `USERNAME` varchar(100) DEFAULT NULL,
  `PASSWORD` varchar(100) DEFAULT NULL,
  `ALIAS` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`STORE_UNIQ`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `AD_REVS`
--

LOCK TABLES `AD_REVS` WRITE;
/*!40000 ALTER TABLE `AD_REVS` DISABLE KEYS */;
/*!40000 ALTER TABLE `AD_REVS` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `CHAT`
--

DROP TABLE IF EXISTS `CHAT`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `CHAT` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `START` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `AIM` varchar(100) DEFAULT NULL,
  `FILENAME` varchar(200) DEFAULT NULL,
  `LAST` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `ALTERED` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `CHECKED` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `CHAT`
--

LOCK TABLES `CHAT` WRITE;
/*!40000 ALTER TABLE `CHAT` DISABLE KEYS */;
/*!40000 ALTER TABLE `CHAT` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `CONDUCT`
--

DROP TABLE IF EXISTS `CONDUCT`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `CONDUCT` (
  `SERIAL_ID` int(11) NOT NULL AUTO_INCREMENT,
  `CHAT_ID` int(11) DEFAULT NULL,
  `CONDUCT_ON` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `MESSAGE` text DEFAULT NULL,
  `DATE` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `FLAGGED` tinyint(1) DEFAULT NULL,
  `USERNAME` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`SERIAL_ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `CONDUCT`
--

LOCK TABLES `CONDUCT` WRITE;
/*!40000 ALTER TABLE `CONDUCT` DISABLE KEYS */;
/*!40000 ALTER TABLE `CONDUCT` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `FRANCHISE`
--

DROP TABLE IF EXISTS `FRANCHISE`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `FRANCHISE` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `STORE_NAME` varchar(100) DEFAULT NULL,
  `STORE_NO` int(11) DEFAULT NULL,
  `OWNER_ID` int(11) DEFAULT NULL,
  `MANAGER` varchar(100) DEFAULT NULL,
  `ADDR_STR` varchar(100) DEFAULT NULL,
  `CITY` varchar(100) DEFAULT NULL,
  `STATE` varchar(100) DEFAULT NULL,
  `PASSWORD` varchar(100) DEFAULT NULL,
  `PHONE` int(11) DEFAULT NULL,
  `EMAIL` varchar(100) DEFAULT NULL,
  `AVG_ADS_HR` decimal(10,0) DEFAULT NULL,
  `VIEWS` int(11) DEFAULT NULL,
  `AVG_VIEWS_DAY` int(11) DEFAULT NULL,
  `REVIEWS` int(11) DEFAULT NULL,
  `AVG_REVIEWS` decimal(10,0) DEFAULT NULL,
  `KEY1` varchar(25) DEFAULT NULL,
  `KEY2` varchar(25) DEFAULT NULL,
  `KEY3` varchar(25) DEFAULT NULL,
  `KEY4` varchar(25) DEFAULT NULL,
  `KEY5` varchar(25) DEFAULT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `FRANCHISE`
--

LOCK TABLES `FRANCHISE` WRITE;
/*!40000 ALTER TABLE `FRANCHISE` DISABLE KEYS */;
/*!40000 ALTER TABLE `FRANCHISE` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `KEYWORDS`
--

DROP TABLE IF EXISTS `KEYWORDS`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `KEYWORDS` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `KEYWORD` varchar(25) DEFAULT NULL,
  `DEFINITION` varchar(180) DEFAULT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `KEYWORDS`
--

LOCK TABLES `KEYWORDS` WRITE;
/*!40000 ALTER TABLE `KEYWORDS` DISABLE KEYS */;
/*!40000 ALTER TABLE `KEYWORDS` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `PREORDERS`
--

DROP TABLE IF EXISTS `PREORDERS`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `PREORDERS` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `CUSTOMER` varchar(100) DEFAULT NULL,
  `STORE_NAME` varchar(100) DEFAULT NULL,
  `STORE_NO` int(11) DEFAULT NULL,
  `PRODUCT` varchar(100) DEFAULT NULL,
  `QUANTITY` int(11) DEFAULT NULL,
  `INDV_PRICE` decimal(10,0) DEFAULT NULL,
  `TAX` decimal(10,0) DEFAULT NULL,
  `TOTAL_PRICE` decimal(10,0) DEFAULT NULL,
  `NEEDED_BY` date DEFAULT NULL,
  `DELIVERED` tinyint(1) DEFAULT NULL,
  `EXPECTED` date DEFAULT NULL,
  `ACTION` tinyint(1) DEFAULT NULL,
  `CREATED` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `ORDER_ID` int(11) NOT NULL,
  `EDITED` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`ID`),
  UNIQUE KEY `ORDER_ID` (`ORDER_ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `PREORDERS`
--

LOCK TABLES `PREORDERS` WRITE;
/*!40000 ALTER TABLE `PREORDERS` DISABLE KEYS */;
/*!40000 ALTER TABLE `PREORDERS` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2022-09-02 11:04:40
