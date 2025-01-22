/*!999999\- enable the sandbox mode */ 
-- MariaDB dump 10.19  Distrib 10.11.8-MariaDB, for debian-linux-gnu (x86_64)
--
-- Host: 127.0.0.1    Database: db_stk
-- ------------------------------------------------------
-- Server version	10.11.8-MariaDB-0ubuntu0.24.04.1

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
-- Table structure for table `admin`
--

DROP TABLE IF EXISTS `admin`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `admin` (
  `id` int(3) NOT NULL AUTO_INCREMENT,
  `first_name` varchar(25) NOT NULL,
  `last_name` varchar(25) NOT NULL,
  `email` varchar(255) NOT NULL,
  `mobile1` varchar(15) NOT NULL,
  `mobile2` varchar(15) NOT NULL,
  `password` char(60) NOT NULL,
  `role` char(5) NOT NULL,
  `created_on` datetime NOT NULL,
  `last_login` datetime NOT NULL,
  `last_seen` datetime NOT NULL,
  `last_edited` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `account_status` char(1) NOT NULL DEFAULT '1',
  `deleted` char(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`),
  UNIQUE KEY `mobile1` (`mobile1`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `admin`
--

LOCK TABLES `admin` WRITE;
/*!40000 ALTER TABLE `admin` DISABLE KEYS */;
INSERT INTO `admin` VALUES
(1,'Admin','Admin','admin@stkmgr.com','08021111111','07032222222','$2y$10$kWV1V4ZDcXynnRB4EpRVqeq1u8msAhdccRM4jttsi.qujLIQJvf8i','Super','2017-01-04 22:19:16','2022-12-14 22:41:59','2025-01-18 12:20:46','2025-01-18 10:20:46','1','0'),
(2,'Jeanne','Doe Doe','jeannedoe@stkmgr.com','+243991551044','','$2y$10$lbjO4OlniozIU4aNCfCa5uCJIOfEUYrYw6y3ttrjm7I5NZEG.32.W','Super','2020-11-13 18:23:48','0000-00-00 00:00:00','0000-00-00 00:00:00','2022-11-14 09:57:20','1','0'),
(3,'John','Doe','johndoe@stkmgr.com','+243999052349','','$2y$10$dVDXoCPk0Y9ON3cwibJKBuqm4cQWiF6c8w3gyqJIZKV4sCanCZ6fu','Basic','2021-02-12 15:33:00','2021-02-12 15:33:11','2021-02-12 15:35:05','2022-11-14 09:55:49','1','0');
/*!40000 ALTER TABLE `admin` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `backups`
--

DROP TABLE IF EXISTS `backups`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `backups` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `file_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `file_url` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `date` timestamp NOT NULL DEFAULT current_timestamp(),
  `online` tinyint(4) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `backups`
--

LOCK TABLES `backups` WRITE;
/*!40000 ALTER TABLE `backups` DISABLE KEYS */;
/*!40000 ALTER TABLE `backups` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `categories`
--

DROP TABLE IF EXISTS `categories`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `categories` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nom` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `description` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `created_on` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `categories`
--

LOCK TABLES `categories` WRITE;
/*!40000 ALTER TABLE `categories` DISABLE KEYS */;
INSERT INTO `categories` VALUES
(1,'Boisson','Rafraichissements','2021-02-16 12:34:54'),
(12,'Vin','','2021-02-16 13:29:12'),
(13,'Cakes','','2021-02-16 13:29:22');
/*!40000 ALTER TABLE `categories` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `commandes`
--

DROP TABLE IF EXISTS `commandes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `commandes` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `ref` varchar(20) NOT NULL,
  `item_id` bigint(20) unsigned NOT NULL,
  `quantity` bigint(20) NOT NULL,
  `sended_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `supplier_id` bigint(20) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `commandes_pk2` (`ref`),
  KEY `commandes_items_id_fk` (`item_id`),
  KEY `commandes_suppliers_id_fk` (`supplier_id`),
  CONSTRAINT `commandes_items_id_fk` FOREIGN KEY (`item_id`) REFERENCES `items` (`id`),
  CONSTRAINT `commandes_suppliers_id_fk` FOREIGN KEY (`supplier_id`) REFERENCES `suppliers` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `commandes`
--

LOCK TABLES `commandes` WRITE;
/*!40000 ALTER TABLE `commandes` DISABLE KEYS */;
INSERT INTO `commandes` VALUES
(1,'84732820496561159',5,25,'2022-12-10 11:41:41','2022-12-10 10:06:28',10),
(2,'1259687408396271',5,717,'2022-12-10 11:41:41','2022-12-10 10:07:11',10),
(3,'681438573049597',12,25,'2022-12-10 11:41:46','2022-12-10 10:07:19',12),
(4,'4275983564469',4,26,'2022-12-10 11:41:41','2022-12-10 10:07:29',10),
(5,'437196205823154',5,63,'2022-12-10 11:41:41','2022-12-10 10:07:38',10);
/*!40000 ALTER TABLE `commandes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `couts`
--

DROP TABLE IF EXISTS `couts`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `couts` (
  `coutsId` int(11) NOT NULL AUTO_INCREMENT,
  `montant` decimal(10,2) NOT NULL,
  `motif` text NOT NULL,
  `author` varchar(255) NOT NULL,
  `date_sortie` date NOT NULL,
  `staffId` bigint(20) NOT NULL,
  `created_on` datetime NOT NULL,
  `lastUpdate` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `deleted` int(11) NOT NULL,
  PRIMARY KEY (`coutsId`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `couts`
--

LOCK TABLES `couts` WRITE;
/*!40000 ALTER TABLE `couts` DISABLE KEYS */;
INSERT INTO `couts` VALUES
(1,200.00,'Achat des stylo','Roben','2021-02-16',1,'2021-02-16 13:45:10','2021-02-16 11:45:33',1);
/*!40000 ALTER TABLE `couts` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `eventlog`
--

DROP TABLE IF EXISTS `eventlog`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `eventlog` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `event` varchar(200) NOT NULL,
  `eventRowIdOrRef` varchar(20) DEFAULT NULL,
  `eventDesc` text DEFAULT NULL,
  `eventTable` varchar(20) DEFAULT NULL,
  `staffInCharge` bigint(20) unsigned NOT NULL,
  `eventTime` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=60 DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `eventlog`
--

LOCK TABLES `eventlog` WRITE;
/*!40000 ALTER TABLE `eventlog` DISABLE KEYS */;
INSERT INTO `eventlog` VALUES
(1,'Création d\'un nouveau article','1','Ajout de 12 unités de \'iPhone12\' avec un prix unitaire de USD 1,200.00 dans le stock','items',1,'2020-11-16 12:29:05'),
(2,'Mise à jour du stock (Nouveau Stock)','1','<p>15 unités de iPhone12 ont été ajouter au stock</p>\n                Raison : <p>De nouveaux articles ont été achetés</p>','items',1,'2020-11-16 12:29:28'),
(3,'Création d\'un nouveau article','2','Ajout de 10 unités de \'champagne\' avec un prix unitaire de USD 1,000.00 dans le stock','items',1,'2021-02-01 08:28:39'),
(4,'Création d\'un nouveau article','3','Ajout de 20 unités de \'Johnny Walker\' avec un prix unitaire de USD 50.00 dans le stock','items',1,'2021-02-01 08:29:12'),
(5,'Création d\'un nouveau article','4','Ajout de 60 unités de \'Jus Ceres\' avec un prix unitaire de USD 5.00 dans le stock','items',1,'2021-02-01 08:29:37'),
(6,'Création d\'un nouveau article','5','Ajout de 40 unités de \'Heineken\' avec un prix unitaire de USD 2.75 dans le stock','items',1,'2021-02-01 08:29:50'),
(8,'Création d\'un nouveau article','7','Ajout de 27 unités de \'Black Label\' avec un prix unitaire de USD 50.00 dans le stock','items',1,'2021-02-01 08:30:26'),
(9,'Création d\'un nouveau article','8','Ajout de 56 unités de \'Savanna\' avec un prix unitaire de USD 2.75 dans le stock','items',1,'2021-02-01 08:30:45'),
(10,'Création d\'un nouveau article','9','Ajout de 20 unités de \'Hunters\' avec un prix unitaire de USD 2.75 dans le stock','items',1,'2021-02-01 08:31:14'),
(11,'Nouvelle transaction','57129302','1 articles totalisant USD 8.25 avec le numéro de référence 57129302 a été acheté','transactions',1,'2021-02-01 08:33:36'),
(12,'Nouvelle transaction','12901827','1 articles totalisant USD 5.50 avec le numéro de référence 12901827 a été acheté','transactions',1,'2021-02-01 12:09:35'),
(13,'Nouvelle transaction','17698160','2 articles totalisant USD 55.00 avec le numéro de référence 17698160 a été acheté','transactions',1,'2021-02-01 12:23:50'),
(14,'Mise à jour de l\'article','7','Le détails de l\'article avec le code \'960CU9YRGY3\' ont été mise à jour','items',1,'2021-02-08 12:08:29'),
(15,'Mise à jour de l\'article','7','Le détails de l\'article avec le code \'960CU9YRGY3\' ont été mise à jour','items',1,'2021-02-08 12:08:44'),
(16,'Nouvelle transaction','019632820','1 articles totalisant USD 50.00 avec le numéro de référence 019632820 a été acheté','transactions',1,'2021-02-08 12:14:41'),
(17,'Nouvelle transaction','4921870','1 articles totalisant USD 50.00 avec le numéro de référence 4921870 a été acheté','transactions',1,'2021-02-08 12:17:34'),
(18,'Nouvelle transaction','77059481','3 articles totalisant USD 57.75 avec le numéro de référence 77059481 a été acheté','transactions',1,'2021-02-10 08:10:32'),
(19,'Mise à jour de l\'article','7','Le détails de l\'article avec le code \'960CU9YRGY\' ont été mise à jour','items',1,'2021-02-13 09:14:44'),
(20,'Création d\'un nouveau article','10','Ajout de 25 unités de \'Cake\' avec un prix unitaire de USD 35.00 dans le stock','items',1,'2021-02-15 13:36:51'),
(21,'Création d\'un nouveau article','11','Ajout de 32 unités de \'Zombo\' avec un prix unitaire de USD 20.00 dans le stock','items',1,'2021-02-15 13:39:41'),
(22,'Création d\'un nouveau article','12','Ajout de 45 unités de \'Maziwa\' avec un prix unitaire de USD 10.00 dans le stock','items',1,'2021-02-15 13:41:42'),
(23,'Création d\'un nouveau article','13','Ajout de 50 unités de \'YV\' avec un prix unitaire de USD 30.00 dans le stock','items',1,'2021-02-15 13:47:31'),
(24,'Création d\'un nouveau article','14','Ajout de 63 unités de \'meschack\' avec un prix unitaire de USD 30.00 dans le stock','items',1,'2021-02-15 13:59:22'),
(25,'Mise à jour de l\'article','7','Le détails de l\'article avec le code \'960CU9YRGY\' ont été mise à jour','items',1,'2021-02-15 21:32:10'),
(26,'Mise à jour de l\'article','14','Le détails de l\'article avec le code \'8B973YMCF8\' ont été mise à jour','items',1,'2021-02-16 06:25:53'),
(27,'Mise à jour de l\'article','14','Le détails de l\'article avec le code \'8B973YMCF8\' ont été mise à jour','items',1,'2021-02-16 06:29:12'),
(28,'Mise à jour de l\'article','14','Le détails de l\'article avec le code \'8B973YMCF8\' ont été mise à jour','items',1,'2021-02-16 09:39:59'),
(29,'Mise à jour de l\'article','14','Le détails de l\'article avec le code \'8B973YMCF8\' ont été mise à jour','items',1,'2021-02-16 09:41:14'),
(30,'Mise à jour de l\'article','14','Le détails de l\'article avec le code \'8B973YMCF8\' ont été mise à jour','items',1,'2021-02-16 09:42:22'),
(31,'Mise à jour de l\'article','14','Le détails de l\'article avec le code \'8B973YMCF8\' ont été mise à jour','items',1,'2021-02-16 09:42:51'),
(32,'Mise à jour de l\'article','14','Le détails de l\'article avec le code \'8B973YMCF8\' ont été mise à jour','items',1,'2021-02-16 09:45:10'),
(33,'Mise à jour de l\'article','14','Le détails de l\'article avec le code \'8B973YMCF8\' ont été mise à jour','items',1,'2021-02-16 09:45:50'),
(34,'Mise à jour de l\'article','14','Le détails de l\'article avec le code \'8B973YMCF8\' ont été mise à jour','items',1,'2021-02-16 09:46:09'),
(35,'Mise à jour de l\'article','14','Le détails de l\'article avec le code \'8B973YMCF8\' ont été mise à jour','items',1,'2021-02-16 09:47:23'),
(36,'Mise à jour de l\'article','14','Le détails de l\'article avec le code \'8B973YMCF8\' ont été mise à jour','items',1,'2021-02-16 09:49:27'),
(37,'Mise à jour de l\'article','14','Le détails de l\'article avec le code \'8B973YMCF8\' ont été mise à jour','items',1,'2021-02-16 09:49:47'),
(38,'Mise à jour de l\'article','14','Le détails de l\'article avec le code \'8B973YMCF8\' ont été mise à jour','items',1,'2021-02-16 09:52:13'),
(39,'Mise à jour de l\'article','14','Le détails de l\'article avec le code \'8B973YMCF8\' ont été mise à jour','items',1,'2021-02-16 09:52:39'),
(40,'Mise à jour de l\'article','14','Le détails de l\'article avec le code \'8B973YMCF8\' ont été mise à jour','items',1,'2021-02-16 10:13:47'),
(41,'Mise à jour de l\'article','14','Le détails de l\'article avec le code \'8B973YMCF8\' ont été mise à jour','items',1,'2021-02-16 10:13:58'),
(42,'Mise à jour de l\'article','14','Le détails de l\'article avec le code \'8B973YMCF8\' ont été mise à jour','items',1,'2021-02-16 10:14:51'),
(43,'Mise à jour de l\'article','14','Le détails de l\'article avec le code \'8B973YMCF8\' ont été mise à jour','items',1,'2021-02-16 11:08:30'),
(44,'Mise à jour de l\'article','14','Le détails de l\'article avec le code \'8B973YMCF8\' ont été mise à jour','items',1,'2021-02-16 11:08:55'),
(45,'Mise à jour de l\'article','14','Le détails de l\'article avec le code \'8B973YMCF8\' ont été mise à jour','items',1,'2021-02-16 11:21:31'),
(46,'Mise à jour de l\'article','14','Le détails de l\'article avec le code \'8B973YMCF8\' ont été mise à jour','items',1,'2021-02-16 11:36:21'),
(47,'Mise à jour de l\'article','7','Le détails de l\'article avec le code \'960CU9YRGY\' ont été mise à jour','items',1,'2021-02-16 13:29:34'),
(48,'Mise à jour de l\'article','10','Le détails de l\'article avec le code \'B4JF6E3PJE\' ont été mise à jour','items',1,'2021-02-16 13:29:43'),
(49,'Mise à jour de l\'article','10','Le détails de l\'article avec le code \'B4JF6E3PJE\' ont été mise à jour','items',1,'2021-02-16 13:29:57'),
(50,'Mise à jour de l\'article','2','Le détails de l\'article avec le code \'HOH8JXRHUS\' ont été mise à jour','items',1,'2021-02-16 13:30:27'),
(51,'Mise à jour de l\'article','4','Le détails de l\'article avec le code \'9OELH9R80F\' ont été mise à jour','items',1,'2021-02-16 13:30:39'),
(52,'Mise à jour de l\'article','5','Le détails de l\'article avec le code \'3HRRCAAAMN\' ont été mise à jour','items',1,'2021-02-16 13:53:41'),
(53,'Mise à jour de l\'article','9','Le détails de l\'article avec le code \'FOGRLTPCHX\' ont été mise à jour','items',1,'2021-02-16 13:53:47'),
(54,'Mise à jour de l\'article','3','Le détails de l\'article avec le code \'JOH804N247\' ont été mise à jour','items',1,'2021-02-16 13:53:52'),
(55,'Mise à jour de l\'article','8','Le détails de l\'article avec le code \'T7TX01D1W9\' ont été mise à jour','items',1,'2021-02-16 13:54:03'),
(56,'Nouvelle transaction','5072083','1 articles totalisant USD 10.00 avec le numéro de référence 5072083 a été acheté','transactions',1,'2022-11-02 12:33:45'),
(57,'Nouvelle transaction','04639741','1 articles totalisant USD 2.00 avec le numéro de référence 04639741 a été acheté','transactions',1,'2022-11-02 12:34:27'),
(58,'Nouvelle transaction','403186','1 articles totalisant USD 5.00 avec le numéro de référence 403186 a été acheté','transactions',1,'2022-11-02 12:35:02'),
(59,'Nouvelle transaction','68201975','1 articles totalisant USD 2.00 avec le numéro de référence 68201975 a été acheté','transactions',1,'2022-12-08 08:12:43');
/*!40000 ALTER TABLE `eventlog` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `item_category`
--

DROP TABLE IF EXISTS `item_category`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `item_category` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_item` bigint(20) NOT NULL,
  `id_category` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id_item` (`id_item`),
  KEY `id_category` (`id_category`),
  CONSTRAINT `item_category_ibfk_1` FOREIGN KEY (`id_category`) REFERENCES `categories` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=50 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `item_category`
--

LOCK TABLES `item_category` WRITE;
/*!40000 ALTER TABLE `item_category` DISABLE KEYS */;
INSERT INTO `item_category` VALUES
(3,12,1),
(30,7,1),
(31,7,12),
(35,10,13),
(36,2,1),
(37,2,12),
(38,4,1),
(39,5,1),
(40,5,12),
(41,9,1),
(42,9,12),
(43,3,1),
(44,3,12),
(45,8,1),
(46,8,12);
/*!40000 ALTER TABLE `item_category` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `item_supplier`
--

DROP TABLE IF EXISTS `item_supplier`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `item_supplier` (
  `item_id` bigint(20) unsigned NOT NULL,
  `supplier_id` bigint(20) unsigned NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  KEY `item_supplier_items_id_fk` (`item_id`),
  KEY `item_supplier_suppliers_id_fk` (`supplier_id`),
  CONSTRAINT `item_supplier_items_id_fk` FOREIGN KEY (`item_id`) REFERENCES `items` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `item_supplier_suppliers_id_fk` FOREIGN KEY (`supplier_id`) REFERENCES `suppliers` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `item_supplier`
--

LOCK TABLES `item_supplier` WRITE;
/*!40000 ALTER TABLE `item_supplier` DISABLE KEYS */;
INSERT INTO `item_supplier` VALUES
(5,10,'2022-12-09 14:06:46'),
(9,10,'2022-12-09 14:06:46'),
(3,10,'2022-12-09 14:06:46'),
(4,10,'2022-12-09 14:06:46'),
(8,10,'2022-12-09 14:06:46'),
(7,11,'2022-12-09 14:07:13'),
(2,11,'2022-12-09 14:07:13'),
(9,11,'2022-12-09 14:07:13'),
(4,11,'2022-12-09 14:07:13'),
(12,11,'2022-12-09 14:07:13'),
(8,11,'2022-12-09 14:07:13'),
(3,12,'2022-12-09 14:07:34'),
(12,12,'2022-12-09 14:07:34');
/*!40000 ALTER TABLE `item_supplier` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `items`
--

DROP TABLE IF EXISTS `items`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `items` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `code` varchar(50) NOT NULL,
  `description` text DEFAULT NULL,
  `unitPrice` decimal(10,2) NOT NULL,
  `quantity` int(6) NOT NULL,
  `dateAdded` datetime NOT NULL,
  `lastUpdated` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `min` int(11) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`),
  UNIQUE KEY `code` (`code`)
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `items`
--

LOCK TABLES `items` WRITE;
/*!40000 ALTER TABLE `items` DISABLE KEYS */;
INSERT INTO `items` VALUES
(2,'champagne','HOH8JXRHUS','',1000.00,10,'2021-02-01 10:28:39','2021-02-01 08:28:39',0),
(3,'Johnny Walker','JOH804N247','',50.00,19,'2021-02-01 10:29:12','2021-02-08 12:17:34',0),
(4,'Jus Ceres','9OELH9R80F','',5.00,57,'2021-02-01 10:29:37','2022-11-02 12:35:02',0),
(5,'Heineken','3HRRCAAAMN','',2.00,37,'2021-02-01 10:29:50','2021-02-16 13:53:41',0),
(7,'Black Label','960CU9YRGY','Red wine',50.00,25,'2021-02-01 10:30:26','2022-12-09 13:35:37',30),
(8,'Savanna','T7TX01D1W9','',2.00,52,'2021-02-01 10:30:45','2022-12-08 08:12:43',0),
(9,'Hunters','FOGRLTPCHX','',2.00,19,'2021-02-01 10:31:14','2021-02-16 13:53:47',0),
(10,'Cake','B4JF6E3PJE','',35.00,25,'2021-02-15 15:36:51','2021-02-15 13:36:51',0),
(12,'Maziwa','XDE35T97YD','',10.00,44,'2021-02-15 15:41:42','2022-11-02 12:33:45',0);
/*!40000 ALTER TABLE `items` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `lk_sess`
--

DROP TABLE IF EXISTS `lk_sess`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `lk_sess` (
  `id` varchar(40) NOT NULL,
  `ip_address` varchar(45) NOT NULL,
  `timestamp` int(10) unsigned NOT NULL DEFAULT 0,
  `data` blob NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `lk_sess`
--

LOCK TABLES `lk_sess` WRITE;
/*!40000 ALTER TABLE `lk_sess` DISABLE KEYS */;
/*!40000 ALTER TABLE `lk_sess` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `lq_articles`
--

DROP TABLE IF EXISTS `lq_articles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `lq_articles` (
  `id_article` int(11) NOT NULL AUTO_INCREMENT,
  `designation` varchar(250) NOT NULL,
  `prix_unitaire` varchar(100) NOT NULL,
  `prix_achat` varchar(100) DEFAULT NULL,
  `devise` varchar(20) NOT NULL,
  `qte_initial` varchar(100) NOT NULL,
  `qte_actuelle` varchar(100) NOT NULL,
  `id_categorie` int(11) NOT NULL,
  `image_article` varchar(100) NOT NULL DEFAULT 'product_image.png',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `deleted` varchar(12) NOT NULL,
  PRIMARY KEY (`id_article`)
) ENGINE=InnoDB AUTO_INCREMENT=34 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `lq_articles`
--

LOCK TABLES `lq_articles` WRITE;
/*!40000 ALTER TABLE `lq_articles` DISABLE KEYS */;
INSERT INTO `lq_articles` VALUES
(1,'PINCE UNIVERSAIRE','5','3','USD','25','80',6,'IMG-20211115-WA0002.jpg','2021-12-30 18:01:20','not'),
(2,'Veste Daro Mars 2022','100','90','USD','12','8',1,'aea0e8cdd45d7a11b2caa1e1e95fe6f2.jpeg','2022-06-22 12:01:36','not'),
(3,'Toles','65','50','USD','500','367',6,'b5fa3a87488017f443530175285b8354.png','2022-11-15 14:30:28','not'),
(4,'Sac de ciment','10','16000','USD','500','500',1,'product_image.png','2022-11-21 08:14:02','not'),
(5,'Tole BG32','15','10500','USD','800','800',1,'product_image.png','2022-11-21 08:17:33','not'),
(22,'Sandales','250','200','USD','258','258',9,'IMG_20210411_155801412_BURST004.jpg','2022-01-26 10:19:55','not'),
(33,'CUVE','35','15','USD','200','200',4,'IMG-20211116-WA0017.jpg','2022-01-28 05:09:56','not');
/*!40000 ALTER TABLE `lq_articles` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `lq_categories`
--

DROP TABLE IF EXISTS `lq_categories`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `lq_categories` (
  `id_categorie` int(11) NOT NULL AUTO_INCREMENT,
  `nom_categorie` varchar(200) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `deleted` varchar(20) NOT NULL,
  PRIMARY KEY (`id_categorie`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `lq_categories`
--

LOCK TABLES `lq_categories` WRITE;
/*!40000 ALTER TABLE `lq_categories` DISABLE KEYS */;
INSERT INTO `lq_categories` VALUES
(1,'Construction','2020-10-21 15:18:13','not'),
(2,'Pieces de rechange','2020-10-21 15:18:13','not'),
(3,'Divers','2020-10-21 19:52:22','not'),
(4,'Electrogene','2020-10-21 19:52:22','not'),
(6,'Autres','2021-10-06 17:16:10','yes'),
(7,'Nouvelle catégorie','2022-11-21 10:51:14','yes'),
(8,'Transport','2022-11-21 11:46:33','not');
/*!40000 ALTER TABLE `lq_categories` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `lq_factures`
--

DROP TABLE IF EXISTS `lq_factures`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `lq_factures` (
  `id_facture` int(11) NOT NULL AUTO_INCREMENT,
  `id_article` int(11) NOT NULL,
  `qte_achetee` varchar(50) NOT NULL,
  `subtotal` varchar(50) NOT NULL,
  `remise` double NOT NULL DEFAULT 0,
  `fact_token` varchar(50) NOT NULL,
  `client_token` varchar(50) NOT NULL,
  `date_facture` date NOT NULL,
  `product_tva` int(11) NOT NULL DEFAULT 0,
  `prix_vente` varchar(50) NOT NULL,
  `prix_unitaire` varchar(50) NOT NULL,
  `prix_achat` varchar(50) NOT NULL,
  `client_name` varchar(50) DEFAULT NULL,
  `usd_amount` double DEFAULT NULL,
  `cdf_amount` double DEFAULT NULL,
  `is_cash` enum('1','0') NOT NULL DEFAULT '1',
  `is_canceled` enum('0','1') DEFAULT '0',
  PRIMARY KEY (`id_facture`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `lq_factures`
--

LOCK TABLES `lq_factures` WRITE;
/*!40000 ALTER TABLE `lq_factures` DISABLE KEYS */;
INSERT INTO `lq_factures` VALUES
(1,3,'10','650',10,'47155','62318','2022-11-17',0,'65','65','50','Erick Banze',135,10000,'1','0'),
(2,2,'5','500',10,'47155','62318','2022-11-17',0,'100','100','90','Erick Banze',135,10000,'1','0'),
(3,2,'2','200',0,'55873','86371','2022-11-17',0,'100','100','90','Kasongo Banze',330,0,'1','0'),
(4,3,'2','130',0,'55873','86371','2022-11-17',0,'65','65','50','Kasongo Banze',330,0,'1','0'),
(5,3,'1','65',5,'56948','26175','2022-11-18',0,'65','65','50','Nyembo',260,0,'1','0'),
(6,2,'2','200',5,'56948','26175','2022-11-18',0,'100','100','90','Nyembo',260,0,'1','0'),
(7,3,'12','780',10,'77632','83584','2022-11-18',0,'65','65','50','Kasongo',770,0,'1','0'),
(8,5,'10','150',0,'96259','57587','2022-11-21',0,'15','15','10500','Jeanclaude',140,20000,'1','1');
/*!40000 ALTER TABLE `lq_factures` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `lq_quantites_entree`
--

DROP TABLE IF EXISTS `lq_quantites_entree`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `lq_quantites_entree` (
  `id_qte` int(11) NOT NULL AUTO_INCREMENT,
  `key_entree` varchar(50) DEFAULT NULL,
  `qte_restante` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id_qte`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `lq_quantites_entree`
--

LOCK TABLES `lq_quantites_entree` WRITE;
/*!40000 ALTER TABLE `lq_quantites_entree` DISABLE KEYS */;
INSERT INTO `lq_quantites_entree` VALUES
(1,'0','0');
/*!40000 ALTER TABLE `lq_quantites_entree` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `lq_quantites_sortie`
--

DROP TABLE IF EXISTS `lq_quantites_sortie`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `lq_quantites_sortie` (
  `id_qte` int(11) NOT NULL AUTO_INCREMENT,
  `key_sortie` varchar(50) DEFAULT NULL,
  `qte_restante` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id_qte`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `lq_quantites_sortie`
--

LOCK TABLES `lq_quantites_sortie` WRITE;
/*!40000 ALTER TABLE `lq_quantites_sortie` DISABLE KEYS */;
INSERT INTO `lq_quantites_sortie` VALUES
(1,'0','0');
/*!40000 ALTER TABLE `lq_quantites_sortie` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `lq_reappro`
--

DROP TABLE IF EXISTS `lq_reappro`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `lq_reappro` (
  `id_reappro` int(11) NOT NULL AUTO_INCREMENT,
  `id_article` int(11) NOT NULL,
  `date_reappro` date NOT NULL,
  `qte_reappro` int(11) NOT NULL,
  `nom_fournisseur` varchar(250) NOT NULL,
  `key_entree` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id_reappro`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `lq_reappro`
--

LOCK TABLES `lq_reappro` WRITE;
/*!40000 ALTER TABLE `lq_reappro` DISABLE KEYS */;
INSERT INTO `lq_reappro` VALUES
(1,3,'2022-11-15',100,'JC','7514876');
/*!40000 ALTER TABLE `lq_reappro` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `lq_retrieves`
--

DROP TABLE IF EXISTS `lq_retrieves`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `lq_retrieves` (
  `id_retrieve` int(11) NOT NULL AUTO_INCREMENT,
  `preview_amount` double NOT NULL DEFAULT 0,
  `retrieve_amount` double NOT NULL DEFAULT 0,
  `current_amount` double NOT NULL DEFAULT 0,
  `motif` text NOT NULL,
  `retrieve_date` date DEFAULT NULL,
  PRIMARY KEY (`id_retrieve`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `lq_retrieves`
--

LOCK TABLES `lq_retrieves` WRITE;
/*!40000 ALTER TABLE `lq_retrieves` DISABLE KEYS */;
/*!40000 ALTER TABLE `lq_retrieves` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `lq_shops`
--

DROP TABLE IF EXISTS `lq_shops`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `lq_shops` (
  `shop_id` int(11) NOT NULL AUTO_INCREMENT,
  `shop_name` varchar(50) DEFAULT NULL,
  `shop_created_at` datetime DEFAULT NULL,
  PRIMARY KEY (`shop_id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `lq_shops`
--

LOCK TABLES `lq_shops` WRITE;
/*!40000 ALTER TABLE `lq_shops` DISABLE KEYS */;
INSERT INTO `lq_shops` VALUES
(1,'Kipushi','2022-11-18 09:57:52'),
(2,'Lubumbashi','2022-11-18 09:58:01'),
(3,'Kolwezi',NULL),
(4,'Kamina',NULL);
/*!40000 ALTER TABLE `lq_shops` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `lq_soldes`
--

DROP TABLE IF EXISTS `lq_soldes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `lq_soldes` (
  `id_solde` int(11) NOT NULL AUTO_INCREMENT,
  `date_solde` datetime NOT NULL DEFAULT current_timestamp(),
  `montant_entree` double NOT NULL,
  `cdf_amount` double DEFAULT NULL,
  `usd_amount` double DEFAULT NULL,
  PRIMARY KEY (`id_solde`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `lq_soldes`
--

LOCK TABLES `lq_soldes` WRITE;
/*!40000 ALTER TABLE `lq_soldes` DISABLE KEYS */;
INSERT INTO `lq_soldes` VALUES
(1,'2022-11-21 11:40:54',140,20000,140);
/*!40000 ALTER TABLE `lq_soldes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `lq_sorties`
--

DROP TABLE IF EXISTS `lq_sorties`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `lq_sorties` (
  `id_sortie` int(11) NOT NULL AUTO_INCREMENT,
  `id_article` int(11) NOT NULL,
  `qte_sortie` varchar(100) NOT NULL,
  `date_sortie` date NOT NULL,
  `motif_sortie` varchar(250) NOT NULL,
  `key_sortie` varchar(50) DEFAULT NULL,
  `shop_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id_sortie`),
  KEY `FK_Shop` (`shop_id`),
  CONSTRAINT `FK_Shop` FOREIGN KEY (`shop_id`) REFERENCES `lq_shops` (`shop_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `lq_sorties`
--

LOCK TABLES `lq_sorties` WRITE;
/*!40000 ALTER TABLE `lq_sorties` DISABLE KEYS */;
INSERT INTO `lq_sorties` VALUES
(1,3,'200','2022-11-15','Ventes','6023045',NULL);
/*!40000 ALTER TABLE `lq_sorties` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `lq_users`
--

DROP TABLE IF EXISTS `lq_users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `lq_users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `password` varchar(200) NOT NULL,
  `role_utilisateur` varchar(50) NOT NULL,
  `shop_id` int(11) NOT NULL DEFAULT 0,
  `user_name` varchar(75) DEFAULT NULL,
  `statut` varchar(50) DEFAULT 'online',
  `user_image` varchar(100) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_Shopsd` (`shop_id`),
  CONSTRAINT `FK_Shopsd` FOREIGN KEY (`shop_id`) REFERENCES `lq_shops` (`shop_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `lq_users`
--

LOCK TABLES `lq_users` WRITE;
/*!40000 ALTER TABLE `lq_users` DISABLE KEYS */;
INSERT INTO `lq_users` VALUES
(1,'$2y$10$caYW1Uo4QsbJBiUN/HeqEu36x6TrM2vS6ok8u/dnICBwtUj2t8fJy','admin',1,'Erick','online','noimage_user.png');
/*!40000 ALTER TABLE `lq_users` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `suppliers`
--

DROP TABLE IF EXISTS `suppliers`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `suppliers` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `address` varchar(255) DEFAULT NULL,
  `phone_number` varchar(20) NOT NULL,
  `email` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `suppliers`
--

LOCK TABLES `suppliers` WRITE;
/*!40000 ALTER TABLE `suppliers` DISABLE KEYS */;
INSERT INTO `suppliers` VALUES
(10,'Tyler Wallace','Ad quia sed quas ass','+1 (996) 395-3586','sorujit@mailinator.com'),
(11,'Libby Haley','Veniam id eum ea mo','+1 (372) 746-1592','rujutokys@mailinator.com'),
(12,'Whoopi Reed','Autem est ea aut sim','+1 (576) 758-6656','tufiruduf@mailinator.com');
/*!40000 ALTER TABLE `suppliers` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `transactions`
--

DROP TABLE IF EXISTS `transactions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `transactions` (
  `transId` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `ref` varchar(10) NOT NULL,
  `itemName` varchar(50) NOT NULL,
  `itemCode` varchar(50) NOT NULL,
  `description` text DEFAULT NULL,
  `quantity` int(6) NOT NULL,
  `unitPrice` decimal(10,2) NOT NULL,
  `totalPrice` decimal(10,2) NOT NULL,
  `totalMoneySpent` decimal(10,2) NOT NULL,
  `amountTendered` decimal(10,2) NOT NULL,
  `discount_amount` decimal(10,2) NOT NULL,
  `discount_percentage` decimal(10,2) NOT NULL,
  `vatPercentage` decimal(10,2) NOT NULL,
  `vatAmount` decimal(10,2) NOT NULL,
  `changeDue` decimal(10,2) NOT NULL,
  `modeOfPayment` varchar(20) NOT NULL,
  `cust_name` varchar(20) DEFAULT NULL,
  `cust_phone` varchar(15) DEFAULT NULL,
  `cust_email` varchar(50) DEFAULT NULL,
  `transType` char(1) NOT NULL,
  `staffId` bigint(20) unsigned NOT NULL,
  `transDate` datetime NOT NULL,
  `lastUpdated` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `cancelled` char(1) NOT NULL DEFAULT '0',
  `pos` int(11) DEFAULT NULL,
  `cash` int(11) DEFAULT NULL,
  PRIMARY KEY (`transId`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `transactions`
--

LOCK TABLES `transactions` WRITE;
/*!40000 ALTER TABLE `transactions` DISABLE KEYS */;
INSERT INTO `transactions` VALUES
(1,'57129302','Heineken','3HRRCAAAMN','',3,2.75,8.25,8.25,10.00,0.00,0.00,0.00,0.00,1.75,'Cash','','','','1',1,'2021-02-01 10:33:36','2021-02-01 08:33:36','0',NULL,NULL),
(2,'12901827','Savanna','T7TX01D1W9','',2,2.75,5.50,5.50,10.00,0.00,0.00,0.00,0.00,4.50,'Cash','Roland Wabubindja Tu','','','1',1,'2021-02-01 14:09:35','2021-02-01 12:09:35','0',NULL,NULL),
(3,'17698160','Jus Ceres','9OELH9R80F','',1,5.00,5.00,55.00,100.00,0.00,0.00,0.00,0.00,45.00,'Cash','Roben','+243991551044','','1',1,'2021-02-01 14:23:50','2021-02-01 12:23:50','0',NULL,NULL),
(5,'019632820','Black Label','960CU9YRGY','',1,50.00,50.00,50.00,100.00,0.00,0.00,0.00,0.00,50.00,'Cash','','','','1',1,'2021-02-08 14:14:40','2021-02-08 12:14:40','0',NULL,NULL),
(6,'4921870','Johnny Walker','JOH804N247','',1,50.00,50.00,50.00,50.00,0.00,0.00,0.00,0.00,0.00,'Cash and POS','','','','1',1,'2021-02-08 14:17:34','2021-02-08 12:17:34','0',NULL,NULL),
(7,'77059481','Jus Ceres','9OELH9R80F','',1,5.00,5.00,57.75,100.00,0.00,0.00,0.00,0.00,42.25,'Cash','','','','1',1,'2021-02-10 10:10:32','2021-02-10 08:10:32','0',NULL,NULL),
(8,'77059481','Hunters','FOGRLTPCHX','',1,2.75,2.75,57.75,100.00,0.00,0.00,0.00,0.00,42.25,'Cash','','','','1',1,'2021-02-10 10:10:32','2021-02-10 08:10:32','0',NULL,NULL),
(9,'77059481','Black Label','960CU9YRGY','',1,50.00,50.00,57.75,100.00,0.00,0.00,0.00,0.00,42.25,'Cash','','','','1',1,'2021-02-10 10:10:32','2021-02-10 08:10:32','0',NULL,NULL),
(10,'5072083','Maziwa','XDE35T97YD','',1,10.00,10.00,10.00,10.00,0.00,0.00,0.00,0.00,0.00,'POS','','','','1',1,'2022-11-02 14:33:45','2022-11-02 12:33:45','0',10,0),
(11,'04639741','Savanna','T7TX01D1W9','',1,2.00,2.00,2.00,10.00,0.00,0.00,0.00,0.00,8.00,'Cash','','','','1',1,'2022-11-02 14:34:27','2022-11-02 12:34:27','0',0,2),
(12,'403186','Jus Ceres','9OELH9R80F','',1,5.00,5.00,5.00,5.00,0.00,0.00,0.00,0.00,0.00,'Cash and POS','','','','1',1,'2022-11-02 14:35:02','2022-11-02 12:35:02','0',3,2),
(13,'68201975','Savanna','T7TX01D1W9','',1,2.00,2.00,2.00,5.00,0.00,0.00,0.00,0.00,3.00,'Cash','gfhh','ikyuk','thsrthtr@de.fr','1',1,'2022-12-08 10:12:43','2022-12-08 08:12:43','0',0,2);
/*!40000 ALTER TABLE `transactions` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2025-01-18 12:31:16
