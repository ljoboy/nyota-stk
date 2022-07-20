-- --------------------------------------------------------
-- Host:                         localhost
-- Server version:               5.7.24 - MySQL Community Server (GPL)
-- Server OS:                    Win64
-- HeidiSQL Version:             10.2.0.5599
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;


-- Dumping database structure for db_stk
DROP DATABASE IF EXISTS `db_stk`;
CREATE DATABASE IF NOT EXISTS `db_stk` /*!40100 DEFAULT CHARACTER SET latin1 */;
USE `db_stk`;

-- Dumping structure for table db_stk.admin
DROP TABLE IF EXISTS `admin`;
CREATE TABLE IF NOT EXISTS `admin` (
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
  `last_edited` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `account_status` char(1) NOT NULL DEFAULT '1',
  `deleted` char(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`),
  UNIQUE KEY `mobile1` (`mobile1`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

-- Dumping data for table db_stk.admin: ~3 rows (approximately)
DELETE FROM `admin`;
/*!40000 ALTER TABLE `admin` DISABLE KEYS */;
INSERT INTO `admin` (`id`, `first_name`, `last_name`, `email`, `mobile1`, `mobile2`, `password`, `role`, `created_on`, `last_login`, `last_seen`, `last_edited`, `account_status`, `deleted`) VALUES
	(1, 'Admin', 'Admin', 'admin@stkmgr.com', '08021111111', '07032222222', '$2y$10$kWV1V4ZDcXynnRB4EpRVqeq1u8msAhdccRM4jttsi.qujLIQJvf8i', 'Super', '2017-01-04 22:19:16', '2021-02-22 23:40:36', '2021-02-22 22:46:24', '2021-02-22 23:40:36', '1', '0'),
	(2, 'Roland beni', 'Wabubindja tubongye', 'roland.beni1@gmail.com', '+243991551044', '', '$2y$10$lbjO4OlniozIU4aNCfCa5uCJIOfEUYrYw6y3ttrjm7I5NZEG.32.W', 'Super', '2020-11-13 18:23:48', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '2020-11-13 18:23:48', '1', '0'),
	(3, 'Eric', 'Ampire Big.', 'ericampire@stkmgr.com', '+243999052349', '', '$2y$10$dVDXoCPk0Y9ON3cwibJKBuqm4cQWiF6c8w3gyqJIZKV4sCanCZ6fu', 'Basic', '2021-02-12 15:33:00', '2021-02-12 15:33:11', '2021-02-12 15:35:05', '2021-02-12 16:09:43', '1', '0');
/*!40000 ALTER TABLE `admin` ENABLE KEYS */;

-- Dumping structure for table db_stk.backups
DROP TABLE IF EXISTS `backups`;
CREATE TABLE IF NOT EXISTS `backups` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `file_name` varchar(255) CHARACTER SET utf8mb4 NOT NULL,
  `file_url` varchar(255) CHARACTER SET utf8mb4 NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `online` tinyint(4) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=utf8;

-- Dumping data for table db_stk.backups: ~21 rows (approximately)
DELETE FROM `backups`;
/*!40000 ALTER TABLE `backups` DISABLE KEYS */;
INSERT INTO `backups` (`id`, `file_name`, `file_url`, `date`, `online`) VALUES
	(1, 'nyota_2021-Feb-09_1612865506.sql', 'C:\\xampp\\htdocs\\stk\\backups\\nyota_2021-Feb-09_1612865506.sql', '2021-02-09 12:11:46', 1),
	(2, 'nyota_2021-Feb-09_1612865578.sql', 'C:\\xampp\\htdocs\\stk\\backups\\nyota_2021-Feb-09_1612865578.sql', '2021-02-09 12:12:58', 1),
	(3, 'nyota_2021-Feb-09_1612874484.sql', 'C:\\xampp\\htdocs\\stk\\backups\\nyota_2021-Feb-09_1612874484.sql', '2021-02-09 14:41:24', 1),
	(4, 'nyota_2021-Feb-10_1612940618.sql', 'C:\\xampp\\htdocs\\stk\\backups\\nyota_2021-Feb-10_1612940618.sql', '2021-02-10 09:03:38', 1),
	(5, 'nyota_2021-Feb-10_1612942249.sql', 'C:\\xampp\\htdocs\\stk\\backups\\nyota_2021-Feb-10_1612942249.sql', '2021-02-10 09:30:49', 1),
	(6, 'nyota_2021-Feb-10_1612942314.sql', 'C:\\xampp\\htdocs\\stk\\backups\\nyota_2021-Feb-10_1612942314.sql', '2021-02-10 09:31:54', 1),
	(7, 'nyota_2021-Feb-10_1612942833.sql', 'C:\\xampp\\htdocs\\stk\\backups\\nyota_2021-Feb-10_1612942833.sql', '2021-02-10 09:40:33', 1),
	(8, 'nyota_2021-Feb-10_1612942932.sql', 'C:\\xampp\\htdocs\\stk\\backups\\nyota_2021-Feb-10_1612942932.sql', '2021-02-10 09:42:12', 1),
	(9, 'nyota_2021-Feb-10_1612942938.sql', 'C:\\xampp\\htdocs\\stk\\backups\\nyota_2021-Feb-10_1612942938.sql', '2021-02-10 09:42:18', 1),
	(10, 'nyota_2021-Feb-10_1612942948.sql', 'C:\\xampp\\htdocs\\stk\\backups\\nyota_2021-Feb-10_1612942948.sql', '2021-02-10 09:42:28', 1),
	(11, 'nyota_2021-Feb-10_1612942961.sql', 'C:\\xampp\\htdocs\\stk\\backups\\nyota_2021-Feb-10_1612942961.sql', '2021-02-10 09:42:41', 1),
	(12, 'nyota_2021-Feb-10_1612942997.sql', 'C:\\xampp\\htdocs\\stk\\backups\\nyota_2021-Feb-10_1612942997.sql', '2021-02-10 09:43:17', 1),
	(13, 'nyota_2021-Feb-10_1612943155.sql', 'C:\\xampp\\htdocs\\stk\\backups\\nyota_2021-Feb-10_1612943155.sql', '2021-02-10 09:45:55', 1),
	(14, 'nyota_2021-Feb-10_1612943215.sql', 'C:\\xampp\\htdocs\\stk\\backups\\nyota_2021-Feb-10_1612943215.sql', '2021-02-10 09:46:55', 1),
	(15, 'nyota_2021-Feb-10_1612943419.sql', 'C:\\xampp\\htdocs\\stk\\backups\\nyota_2021-Feb-10_1612943419.sql', '2021-02-10 09:50:19', 1),
	(16, 'nyota_2021-Feb-16_1613485861.sql', 'C:\\xampp\\htdocs\\stk\\backups\\nyota_2021-Feb-16_1613485861.sql', '2021-02-16 16:31:01', 1),
	(17, 'nyota_2021-Feb-16_1613485929.sql', 'C:\\xampp\\htdocs\\stk\\backups\\nyota_2021-Feb-16_1613485929.sql', '2021-02-16 16:32:09', 0),
	(18, 'nyota_2021-Feb-16_1613486009.sql', 'C:\\xampp\\htdocs\\stk\\backups\\nyota_2021-Feb-16_1613486009.sql', '2021-02-16 16:33:29', 0),
	(19, 'nyota_2021-Feb-16_1613486027.sql', 'C:\\xampp\\htdocs\\stk\\backups\\nyota_2021-Feb-16_1613486027.sql', '2021-02-16 16:33:47', 0),
	(20, 'nyota_2021-Feb-16_1613486049.sql', 'C:\\xampp\\htdocs\\stk\\backups\\nyota_2021-Feb-16_1613486049.sql', '2021-02-16 16:34:09', 0),
	(21, 'nyota_2021-Feb-16_1613486055.sql', 'C:\\xampp\\htdocs\\stk\\backups\\nyota_2021-Feb-16_1613486055.sql', '2021-02-16 16:34:15', 0);
/*!40000 ALTER TABLE `backups` ENABLE KEYS */;

-- Dumping structure for table db_stk.categories
DROP TABLE IF EXISTS `categories`;
CREATE TABLE IF NOT EXISTS `categories` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nom` varchar(255) CHARACTER SET utf8mb4 NOT NULL,
  `description` varchar(255) CHARACTER SET utf8mb4 NOT NULL,
  `created_on` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=latin1;

-- Dumping data for table db_stk.categories: ~3 rows (approximately)
DELETE FROM `categories`;
/*!40000 ALTER TABLE `categories` DISABLE KEYS */;
INSERT INTO `categories` (`id`, `nom`, `description`, `created_on`) VALUES
	(1, 'Boisson', 'Rafraichissements', '2021-02-16 14:34:54'),
	(12, 'Vin', '', '2021-02-16 15:29:12'),
	(13, 'Cakes', '', '2021-02-16 15:29:22');
/*!40000 ALTER TABLE `categories` ENABLE KEYS */;

-- Dumping structure for table db_stk.couts
DROP TABLE IF EXISTS `couts`;
CREATE TABLE IF NOT EXISTS `couts` (
  `coutsId` int(11) NOT NULL AUTO_INCREMENT,
  `montant` decimal(10,2) NOT NULL,
  `motif` text NOT NULL,
  `author` varchar(255) NOT NULL,
  `date_sortie` date NOT NULL,
  `staffId` int(11) NOT NULL DEFAULT '0',
  `created_on` datetime NOT NULL,
  `lastUpdate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `deleted` int(11) NOT NULL,
  PRIMARY KEY (`coutsId`),
  KEY `FK_couts_admin` (`staffId`),
  CONSTRAINT `FK_couts_admin` FOREIGN KEY (`staffId`) REFERENCES `admin` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- Dumping data for table db_stk.couts: ~0 rows (approximately)
DELETE FROM `couts`;
/*!40000 ALTER TABLE `couts` DISABLE KEYS */;
INSERT INTO `couts` (`coutsId`, `montant`, `motif`, `author`, `date_sortie`, `staffId`, `created_on`, `lastUpdate`, `deleted`) VALUES
	(1, 200.00, 'Achat des stylo', 'Roben', '2021-02-16', 1, '2021-02-16 13:45:10', '2021-02-16 13:45:33', 1);
/*!40000 ALTER TABLE `couts` ENABLE KEYS */;

-- Dumping structure for table db_stk.eventlog
DROP TABLE IF EXISTS `eventlog`;
CREATE TABLE IF NOT EXISTS `eventlog` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `event` varchar(200) NOT NULL,
  `eventRowIdOrRef` varchar(20) DEFAULT NULL,
  `eventDesc` text,
  `eventTable` varchar(20) DEFAULT NULL,
  `staffInCharge` int(11) NOT NULL DEFAULT '0',
  `eventTime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `FK_eventlog_admin` (`staffInCharge`),
  CONSTRAINT `FK_eventlog_admin` FOREIGN KEY (`staffInCharge`) REFERENCES `admin` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=60 DEFAULT CHARSET=latin1;

-- Dumping data for table db_stk.eventlog: ~58 rows (approximately)
DELETE FROM `eventlog`;
/*!40000 ALTER TABLE `eventlog` DISABLE KEYS */;
INSERT INTO `eventlog` (`id`, `event`, `eventRowIdOrRef`, `eventDesc`, `eventTable`, `staffInCharge`, `eventTime`) VALUES
	(1, 'Création d\'un nouveau article', '1', 'Ajout de 12 unités de \'iPhone12\' avec un prix unitaire de USD 1,200.00 dans le stock', 'items', 1, '2020-11-16 14:29:05'),
	(2, 'Mise à jour du stock (Nouveau Stock)', '1', '<p>15 unités de iPhone12 ont été ajouter au stock</p>\n                Raison : <p>De nouveaux articles ont été achetés</p>', 'items', 1, '2020-11-16 14:29:28'),
	(3, 'Création d\'un nouveau article', '2', 'Ajout de 10 unités de \'champagne\' avec un prix unitaire de USD 1,000.00 dans le stock', 'items', 1, '2021-02-01 10:28:39'),
	(4, 'Création d\'un nouveau article', '3', 'Ajout de 20 unités de \'Johnny Walker\' avec un prix unitaire de USD 50.00 dans le stock', 'items', 1, '2021-02-01 10:29:12'),
	(5, 'Création d\'un nouveau article', '4', 'Ajout de 60 unités de \'Jus Ceres\' avec un prix unitaire de USD 5.00 dans le stock', 'items', 1, '2021-02-01 10:29:37'),
	(6, 'Création d\'un nouveau article', '5', 'Ajout de 40 unités de \'Heineken\' avec un prix unitaire de USD 2.75 dans le stock', 'items', 1, '2021-02-01 10:29:50'),
	(8, 'Création d\'un nouveau article', '7', 'Ajout de 27 unités de \'Black Label\' avec un prix unitaire de USD 50.00 dans le stock', 'items', 1, '2021-02-01 10:30:26'),
	(9, 'Création d\'un nouveau article', '8', 'Ajout de 56 unités de \'Savanna\' avec un prix unitaire de USD 2.75 dans le stock', 'items', 1, '2021-02-01 10:30:45'),
	(10, 'Création d\'un nouveau article', '9', 'Ajout de 20 unités de \'Hunters\' avec un prix unitaire de USD 2.75 dans le stock', 'items', 1, '2021-02-01 10:31:14'),
	(11, 'Nouvelle transaction', '57129302', '1 articles totalisant USD 8.25 avec le numéro de référence 57129302 a été acheté', 'transactions', 1, '2021-02-01 10:33:36'),
	(12, 'Nouvelle transaction', '12901827', '1 articles totalisant USD 5.50 avec le numéro de référence 12901827 a été acheté', 'transactions', 1, '2021-02-01 14:09:35'),
	(13, 'Nouvelle transaction', '17698160', '2 articles totalisant USD 55.00 avec le numéro de référence 17698160 a été acheté', 'transactions', 1, '2021-02-01 14:23:50'),
	(14, 'Mise à jour de l\'article', '7', 'Le détails de l\'article avec le code \'960CU9YRGY3\' ont été mise à jour', 'items', 1, '2021-02-08 14:08:29'),
	(15, 'Mise à jour de l\'article', '7', 'Le détails de l\'article avec le code \'960CU9YRGY3\' ont été mise à jour', 'items', 1, '2021-02-08 14:08:44'),
	(16, 'Nouvelle transaction', '019632820', '1 articles totalisant USD 50.00 avec le numéro de référence 019632820 a été acheté', 'transactions', 1, '2021-02-08 14:14:41'),
	(17, 'Nouvelle transaction', '4921870', '1 articles totalisant USD 50.00 avec le numéro de référence 4921870 a été acheté', 'transactions', 1, '2021-02-08 14:17:34'),
	(18, 'Nouvelle transaction', '77059481', '3 articles totalisant USD 57.75 avec le numéro de référence 77059481 a été acheté', 'transactions', 1, '2021-02-10 10:10:32'),
	(19, 'Mise à jour de l\'article', '7', 'Le détails de l\'article avec le code \'960CU9YRGY\' ont été mise à jour', 'items', 1, '2021-02-13 11:14:44'),
	(20, 'Création d\'un nouveau article', '10', 'Ajout de 25 unités de \'Cake\' avec un prix unitaire de USD 35.00 dans le stock', 'items', 1, '2021-02-15 15:36:51'),
	(21, 'Création d\'un nouveau article', '11', 'Ajout de 32 unités de \'Zombo\' avec un prix unitaire de USD 20.00 dans le stock', 'items', 1, '2021-02-15 15:39:41'),
	(22, 'Création d\'un nouveau article', '12', 'Ajout de 45 unités de \'Maziwa\' avec un prix unitaire de USD 10.00 dans le stock', 'items', 1, '2021-02-15 15:41:42'),
	(23, 'Création d\'un nouveau article', '13', 'Ajout de 50 unités de \'YV\' avec un prix unitaire de USD 30.00 dans le stock', 'items', 1, '2021-02-15 15:47:31'),
	(24, 'Création d\'un nouveau article', '14', 'Ajout de 63 unités de \'meschack\' avec un prix unitaire de USD 30.00 dans le stock', 'items', 1, '2021-02-15 15:59:22'),
	(25, 'Mise à jour de l\'article', '7', 'Le détails de l\'article avec le code \'960CU9YRGY\' ont été mise à jour', 'items', 1, '2021-02-15 23:32:10'),
	(26, 'Mise à jour de l\'article', '14', 'Le détails de l\'article avec le code \'8B973YMCF8\' ont été mise à jour', 'items', 1, '2021-02-16 08:25:53'),
	(27, 'Mise à jour de l\'article', '14', 'Le détails de l\'article avec le code \'8B973YMCF8\' ont été mise à jour', 'items', 1, '2021-02-16 08:29:12'),
	(28, 'Mise à jour de l\'article', '14', 'Le détails de l\'article avec le code \'8B973YMCF8\' ont été mise à jour', 'items', 1, '2021-02-16 11:39:59'),
	(29, 'Mise à jour de l\'article', '14', 'Le détails de l\'article avec le code \'8B973YMCF8\' ont été mise à jour', 'items', 1, '2021-02-16 11:41:14'),
	(30, 'Mise à jour de l\'article', '14', 'Le détails de l\'article avec le code \'8B973YMCF8\' ont été mise à jour', 'items', 1, '2021-02-16 11:42:22'),
	(31, 'Mise à jour de l\'article', '14', 'Le détails de l\'article avec le code \'8B973YMCF8\' ont été mise à jour', 'items', 1, '2021-02-16 11:42:51'),
	(32, 'Mise à jour de l\'article', '14', 'Le détails de l\'article avec le code \'8B973YMCF8\' ont été mise à jour', 'items', 1, '2021-02-16 11:45:10'),
	(33, 'Mise à jour de l\'article', '14', 'Le détails de l\'article avec le code \'8B973YMCF8\' ont été mise à jour', 'items', 1, '2021-02-16 11:45:50'),
	(34, 'Mise à jour de l\'article', '14', 'Le détails de l\'article avec le code \'8B973YMCF8\' ont été mise à jour', 'items', 1, '2021-02-16 11:46:09'),
	(35, 'Mise à jour de l\'article', '14', 'Le détails de l\'article avec le code \'8B973YMCF8\' ont été mise à jour', 'items', 1, '2021-02-16 11:47:23'),
	(36, 'Mise à jour de l\'article', '14', 'Le détails de l\'article avec le code \'8B973YMCF8\' ont été mise à jour', 'items', 1, '2021-02-16 11:49:27'),
	(37, 'Mise à jour de l\'article', '14', 'Le détails de l\'article avec le code \'8B973YMCF8\' ont été mise à jour', 'items', 1, '2021-02-16 11:49:47'),
	(38, 'Mise à jour de l\'article', '14', 'Le détails de l\'article avec le code \'8B973YMCF8\' ont été mise à jour', 'items', 1, '2021-02-16 11:52:13'),
	(39, 'Mise à jour de l\'article', '14', 'Le détails de l\'article avec le code \'8B973YMCF8\' ont été mise à jour', 'items', 1, '2021-02-16 11:52:39'),
	(40, 'Mise à jour de l\'article', '14', 'Le détails de l\'article avec le code \'8B973YMCF8\' ont été mise à jour', 'items', 1, '2021-02-16 12:13:47'),
	(41, 'Mise à jour de l\'article', '14', 'Le détails de l\'article avec le code \'8B973YMCF8\' ont été mise à jour', 'items', 1, '2021-02-16 12:13:58'),
	(42, 'Mise à jour de l\'article', '14', 'Le détails de l\'article avec le code \'8B973YMCF8\' ont été mise à jour', 'items', 1, '2021-02-16 12:14:51'),
	(43, 'Mise à jour de l\'article', '14', 'Le détails de l\'article avec le code \'8B973YMCF8\' ont été mise à jour', 'items', 1, '2021-02-16 13:08:30'),
	(44, 'Mise à jour de l\'article', '14', 'Le détails de l\'article avec le code \'8B973YMCF8\' ont été mise à jour', 'items', 1, '2021-02-16 13:08:55'),
	(45, 'Mise à jour de l\'article', '14', 'Le détails de l\'article avec le code \'8B973YMCF8\' ont été mise à jour', 'items', 1, '2021-02-16 13:21:31'),
	(46, 'Mise à jour de l\'article', '14', 'Le détails de l\'article avec le code \'8B973YMCF8\' ont été mise à jour', 'items', 1, '2021-02-16 13:36:21'),
	(47, 'Mise à jour de l\'article', '7', 'Le détails de l\'article avec le code \'960CU9YRGY\' ont été mise à jour', 'items', 1, '2021-02-16 15:29:34'),
	(48, 'Mise à jour de l\'article', '10', 'Le détails de l\'article avec le code \'B4JF6E3PJE\' ont été mise à jour', 'items', 1, '2021-02-16 15:29:43'),
	(49, 'Mise à jour de l\'article', '10', 'Le détails de l\'article avec le code \'B4JF6E3PJE\' ont été mise à jour', 'items', 1, '2021-02-16 15:29:57'),
	(50, 'Mise à jour de l\'article', '2', 'Le détails de l\'article avec le code \'HOH8JXRHUS\' ont été mise à jour', 'items', 1, '2021-02-16 15:30:27'),
	(51, 'Mise à jour de l\'article', '4', 'Le détails de l\'article avec le code \'9OELH9R80F\' ont été mise à jour', 'items', 1, '2021-02-16 15:30:39'),
	(52, 'Mise à jour de l\'article', '5', 'Le détails de l\'article avec le code \'3HRRCAAAMN\' ont été mise à jour', 'items', 1, '2021-02-16 15:53:41'),
	(53, 'Mise à jour de l\'article', '9', 'Le détails de l\'article avec le code \'FOGRLTPCHX\' ont été mise à jour', 'items', 1, '2021-02-16 15:53:47'),
	(54, 'Mise à jour de l\'article', '3', 'Le détails de l\'article avec le code \'JOH804N247\' ont été mise à jour', 'items', 1, '2021-02-16 15:53:52'),
	(55, 'Mise à jour de l\'article', '8', 'Le détails de l\'article avec le code \'T7TX01D1W9\' ont été mise à jour', 'items', 1, '2021-02-16 15:54:03'),
	(56, 'Nouvelle transaction', '0567290', '1 articles totalisant USD 10.00 avec le numéro de référence 0567290 a été acheté', 'transactions', 1, '2021-02-18 15:35:00'),
	(57, 'Nouvelle transaction', '768158', '1 articles totalisant USD 105.00 avec le numéro de référence 768158 a été acheté', 'transactions', 1, '2021-02-18 16:57:28'),
	(58, 'Nouvelle transaction', '35287046', '1 articles totalisant USD 15.00 avec le numéro de référence 35287046 a été acheté', 'transactions', 1, '2021-02-18 17:03:51'),
	(59, 'Nouvelle transaction', '615830251', '3 articles totalisant USD 175.00 avec le numéro de référence 615830251 a été acheté', 'transactions', 1, '2021-02-18 21:58:46');
/*!40000 ALTER TABLE `eventlog` ENABLE KEYS */;

-- Dumping structure for table db_stk.items
DROP TABLE IF EXISTS `items`;
CREATE TABLE IF NOT EXISTS `items` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `code` varchar(50) NOT NULL,
  `description` text,
  `unitPrice` decimal(10,2) NOT NULL,
  `quantity` int(6) NOT NULL,
  `min` int(11) DEFAULT 10 NOT NULL ,
  `dateAdded` datetime NOT NULL,
  `lastUpdated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`),
  UNIQUE KEY `code` (`code`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Dumping data for table db_stk.items: ~9 rows (approximately)
DELETE FROM `items`;
/*!40000 ALTER TABLE `items` DISABLE KEYS */;
INSERT INTO `items` (`id`, `name`, `code`, `description`, `unitPrice`, `quantity`, `dateAdded`, `lastUpdated`) VALUES
	(2, 'champagne', 'HOH8JXRHUS', '', 1000.00, 10, '2021-02-01 10:28:39', '2021-02-01 10:28:39'),
	(3, 'Johnny Walker', 'JOH804N247', '', 50.00, 19, '2021-02-01 10:29:12', '2021-02-08 14:17:34'),
	(4, 'Jus Ceres', '9OELH9R80F', '', 5.00, 50, '2021-02-01 10:29:37', '2021-02-18 21:58:46'),
	(5, 'Heineken', '3HRRCAAAMN', '', 2.00, 37, '2021-02-01 10:29:50', '2021-02-16 15:53:41'),
	(7, 'Black Label', '960CU9YRGY', 'Red wine', 50.00, 22, '2021-02-01 10:30:26', '2021-02-18 21:58:46'),
	(8, 'Savanna', 'T7TX01D1W9', '', 2.00, 53, '2021-02-01 10:30:45', '2021-02-18 16:26:57'),
	(9, 'Hunters', 'FOGRLTPCHX', '', 2.00, 19, '2021-02-01 10:31:14', '2021-02-16 15:53:47'),
	(10, 'Cake', 'B4JF6E3PJE', '', 35.00, 22, '2021-02-15 15:36:51', '2021-02-18 16:57:28'),
	(12, 'Maziwa', 'XDE35T97YD', '', 10.00, 44, '2021-02-15 15:41:42', '2021-02-18 21:58:46');
/*!40000 ALTER TABLE `items` ENABLE KEYS */;

-- Dumping structure for table db_stk.item_category
DROP TABLE IF EXISTS `item_category`;
CREATE TABLE IF NOT EXISTS `item_category` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_item` int(11) NOT NULL,
  `id_category` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id_item` (`id_item`),
  KEY `id_category` (`id_category`),
  CONSTRAINT `FK_item_category_items` FOREIGN KEY (`id_item`) REFERENCES `items` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `item_category_ibfk_1` FOREIGN KEY (`id_category`) REFERENCES `categories` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=47 DEFAULT CHARSET=utf8;

-- Dumping data for table db_stk.item_category: ~15 rows (approximately)
DELETE FROM `item_category`;
/*!40000 ALTER TABLE `item_category` DISABLE KEYS */;
INSERT INTO `item_category` (`id`, `id_item`, `id_category`) VALUES
	(3, 12, 1),
	(30, 7, 1),
	(31, 7, 12),
	(35, 10, 13),
	(36, 2, 1),
	(37, 2, 12),
	(38, 4, 1),
	(39, 5, 1),
	(40, 5, 12),
	(41, 9, 1),
	(42, 9, 12),
	(43, 3, 1),
	(44, 3, 12),
	(45, 8, 1),
	(46, 8, 12);
/*!40000 ALTER TABLE `item_category` ENABLE KEYS */;

-- Dumping structure for table db_stk.lk_sess
DROP TABLE IF EXISTS `lk_sess`;
CREATE TABLE IF NOT EXISTS `lk_sess` (
  `id` varchar(40) NOT NULL,
  `ip_address` varchar(45) NOT NULL,
  `timestamp` int(10) unsigned NOT NULL DEFAULT '0',
  `data` blob NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Dumping data for table db_stk.lk_sess: ~0 rows (approximately)
DELETE FROM `lk_sess`;
/*!40000 ALTER TABLE `lk_sess` DISABLE KEYS */;
/*!40000 ALTER TABLE `lk_sess` ENABLE KEYS */;

-- Dumping structure for table db_stk.payements
DROP TABLE IF EXISTS `payements`;
CREATE TABLE IF NOT EXISTS `payements` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `staff_id` int(11) NOT NULL,
  `ref` varchar(10) NOT NULL,
  `montant_percu` float NOT NULL,
  `montant_paye` float NOT NULL,
  `montant_retourne` float NOT NULL,
  `date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `staff_id` (`staff_id`),
  CONSTRAINT `FK_payements_admin` FOREIGN KEY (`staff_id`) REFERENCES `admin` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=latin1;

-- Dumping data for table db_stk.payements: ~4 rows (approximately)
DELETE FROM `payements`;
/*!40000 ALTER TABLE `payements` DISABLE KEYS */;
INSERT INTO `payements` (`id`, `staff_id`, `ref`, `montant_percu`, `montant_paye`, `montant_retourne`, `date`) VALUES
	(7, 1, '615830251', 30, 30, 0, '2021-02-22 23:07:26'),
	(8, 1, '615830251', 10, 10, 0, '2021-02-22 23:18:48'),
	(9, 1, '615830251', 5, 5, 0, '2021-02-22 23:22:25'),
	(10, 1, '615830251', 10, 5, 5, '2021-02-22 23:22:42');
/*!40000 ALTER TABLE `payements` ENABLE KEYS */;

-- Dumping structure for table db_stk.transactions
DROP TABLE IF EXISTS `transactions`;
CREATE TABLE IF NOT EXISTS `transactions` (
  `transId` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `ref` varchar(10) NOT NULL,
  `itemName` varchar(50) NOT NULL,
  `itemCode` varchar(50) NOT NULL,
  `description` text,
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
  `staffId` int(11) NOT NULL,
  `transDate` datetime NOT NULL,
  `lastUpdated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `cash` float DEFAULT NULL,
  `pos` float DEFAULT NULL,
  `cancelled` char(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`transId`),
  KEY `FK_transactions_admin` (`staffId`),
  CONSTRAINT `FK_transactions_admin` FOREIGN KEY (`staffId`) REFERENCES `admin` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=latin1;

-- Dumping data for table db_stk.transactions: ~15 rows (approximately)
DELETE FROM `transactions`;
/*!40000 ALTER TABLE `transactions` DISABLE KEYS */;
INSERT INTO `transactions` (`transId`, `ref`, `itemName`, `itemCode`, `description`, `quantity`, `unitPrice`, `totalPrice`, `totalMoneySpent`, `amountTendered`, `discount_amount`, `discount_percentage`, `vatPercentage`, `vatAmount`, `changeDue`, `modeOfPayment`, `cust_name`, `cust_phone`, `cust_email`, `transType`, `staffId`, `transDate`, `lastUpdated`, `cash`, `pos`, `cancelled`) VALUES
	(1, '57129302', 'Heineken', '3HRRCAAAMN', '', 3, 2.75, 8.25, 8.25, 10.00, 0.00, 0.00, 0.00, 0.00, 1.75, 'Cash', '', '', '', '1', 1, '2021-02-01 10:33:36', '2021-02-01 10:33:36', NULL, NULL, '0'),
	(2, '12901827', 'Savanna', 'T7TX01D1W9', '', 2, 2.75, 5.50, 5.50, 10.00, 0.00, 0.00, 0.00, 0.00, 4.50, 'Cash', 'Roland Wabubindja Tu', '', '', '1', 1, '2021-02-01 14:09:35', '2021-02-01 14:09:35', NULL, NULL, '0'),
	(3, '17698160', 'Jus Ceres', '9OELH9R80F', '', 1, 5.00, 5.00, 55.00, 100.00, 0.00, 0.00, 0.00, 0.00, 45.00, 'Cash', 'Roben', '+243991551044', '', '1', 1, '2021-02-01 14:23:50', '2021-02-01 14:23:50', NULL, NULL, '0'),
	(5, '019632820', 'Black Label', '960CU9YRGY', '', 1, 50.00, 50.00, 50.00, 100.00, 0.00, 0.00, 0.00, 0.00, 50.00, 'Cash', '', '', '', '1', 1, '2021-02-08 14:14:40', '2021-02-08 14:14:40', NULL, NULL, '0'),
	(6, '4921870', 'Johnny Walker', 'JOH804N247', '', 1, 50.00, 50.00, 50.00, 50.00, 0.00, 0.00, 0.00, 0.00, 0.00, 'Cash and POS', '', '', '', '1', 1, '2021-02-08 14:17:34', '2021-02-08 14:17:34', NULL, NULL, '0'),
	(7, '77059481', 'Jus Ceres', '9OELH9R80F', '', 1, 5.00, 5.00, 57.75, 100.00, 0.00, 0.00, 0.00, 0.00, 42.25, 'Cash', '', '', '', '1', 1, '2021-02-10 10:10:32', '2021-02-10 10:10:32', NULL, NULL, '0'),
	(8, '77059481', 'Hunters', 'FOGRLTPCHX', '', 1, 2.75, 2.75, 57.75, 100.00, 0.00, 0.00, 0.00, 0.00, 42.25, 'Cash', '', '', '', '1', 1, '2021-02-10 10:10:32', '2021-02-10 10:10:32', NULL, NULL, '0'),
	(9, '77059481', 'Black Label', '960CU9YRGY', '', 1, 50.00, 50.00, 57.75, 100.00, 0.00, 0.00, 0.00, 0.00, 42.25, 'Cash', '', '', '', '1', 1, '2021-02-10 10:10:32', '2021-02-10 10:10:32', NULL, NULL, '0'),
	(10, '0567290', 'Jus Ceres', '9OELH9R80F', '', 2, 5.00, 10.00, 10.00, 10.00, 0.00, 0.00, 0.00, 0.00, 0.00, 'POS', '', '', '', '1', 1, '2021-02-18 15:34:59', '2021-02-18 16:20:01', 0, 10, '0'),
	(11, '32039451', 'Savanna', 'T7TX01D1W9', '', 1, 2.00, 2.00, 2.00, 5.00, 0.00, 0.00, 0.00, 0.00, 3.00, 'Cash', '', '', '', '1', 1, '2021-02-18 16:26:57', '2021-02-18 16:26:57', 2, 0, '0'),
	(12, '768158', 'Cake', 'B4JF6E3PJE', '', 3, 35.00, 105.00, 105.00, 110.00, 0.00, 0.00, 0.00, 0.00, 5.00, 'Cash', '', '', '', '1', 1, '2021-02-18 16:57:28', '2021-02-18 16:57:28', 105, 0, '0'),
	(13, '35287046', 'Jus Ceres', '9OELH9R80F', '', 3, 5.00, 15.00, 15.00, 20.00, 0.00, 0.00, 0.00, 0.00, 5.00, 'Cash', '', '', '', '1', 1, '2021-02-18 17:03:51', '2021-02-18 17:03:51', 15, 0, '0'),
	(14, '615830251', 'Black Label', '960CU9YRGY', '', 3, 50.00, 150.00, 175.00, 175.00, 0.00, 0.00, 0.00, 0.00, 0.00, 'Cash and POS', '', '', '', '1', 1, '2021-02-18 21:58:46', '2021-02-22 23:22:42', 175, 0, '0'),
	(15, '615830251', 'Jus Ceres', '9OELH9R80F', '', 3, 5.00, 15.00, 175.00, 175.00, 0.00, 0.00, 0.00, 0.00, 0.00, 'Cash and POS', '', '', '', '1', 1, '2021-02-18 21:58:46', '2021-02-22 23:22:42', 175, 0, '0'),
	(16, '615830251', 'Maziwa', 'XDE35T97YD', '', 1, 10.00, 10.00, 175.00, 175.00, 0.00, 0.00, 0.00, 0.00, 0.00, 'Cash and POS', '', '', '', '1', 1, '2021-02-18 21:58:46', '2021-02-22 23:22:42', 175, 0, '0');
/*!40000 ALTER TABLE `transactions` ENABLE KEYS */;

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
