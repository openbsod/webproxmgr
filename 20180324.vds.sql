-- MySQL dump 10.13  Distrib 5.7.21, for Linux (aarch64)
--
-- Host: localhost    Database: vds
-- ------------------------------------------------------
-- Server version	5.7.21-0ubuntu0.16.04.1

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
-- Current Database: `vds`
--

CREATE DATABASE /*!32312 IF NOT EXISTS*/ `vds` /*!40100 DEFAULT CHARACTER SET utf8 COLLATE utf8_bin */;

USE `vds`;

--
-- Table structure for table `orders`
--

DROP TABLE IF EXISTS `orders`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `orders` (
  `date` date NOT NULL,
  `datetime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `taskid` int(10) NOT NULL AUTO_INCREMENT,
  `clientid` int(10) NOT NULL,
  `ip` int(32) unsigned NOT NULL,
  `name` varchar(128) NOT NULL,
  `cores` int(8) NOT NULL,
  `memory` int(8) NOT NULL,
  `geo` varchar(64) NOT NULL,
  `scsi0` varchar(128) NOT NULL,
  `ide0` varchar(128) NOT NULL,
  `spec` varchar(128) DEFAULT NULL,
  `ide2` varchar(128) NOT NULL,
  `size` int(10) NOT NULL,
  `bootdisk` varchar(64) NOT NULL,
  `ostype` varchar(64) NOT NULL,
  `net0` varchar(64) NOT NULL,
  `ordered` varchar(64) DEFAULT NULL,
  `installed` varchar(64) DEFAULT NULL,
  `vnc_token` varchar(64) NOT NULL,
  `vnc_password` varchar(64) NOT NULL,
  `passwd` varchar(64) DEFAULT NULL,
  `vnc_port` int(10) NOT NULL,
  `vnc` varchar(512) NOT NULL,
  `first_ip` int(32) unsigned DEFAULT NULL,
  `second_ip` int(32) unsigned DEFAULT NULL,
  PRIMARY KEY (`taskid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `orders`
--

LOCK TABLES `orders` WRITE;
/*!40000 ALTER TABLE `orders` DISABLE KEYS */;
/*!40000 ALTER TABLE `orders` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2018-03-24 18:18:34
