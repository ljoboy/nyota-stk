-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : jeu. 18 fév. 2021 à 10:39
-- Version du serveur :  10.4.14-MariaDB
-- Version de PHP : 7.4.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `db_stk`
--

-- --------------------------------------------------------

--
-- Structure de la table `admin`
--

CREATE TABLE `admin` (
  `id` int(3) NOT NULL,
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
  `deleted` char(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `admin`
--

INSERT INTO `admin` (`id`, `first_name`, `last_name`, `email`, `mobile1`, `mobile2`, `password`, `role`, `created_on`, `last_login`, `last_seen`, `last_edited`, `account_status`, `deleted`) VALUES
(1, 'Admin', 'Admin', 'admin@stkmgr.com', '08021111111', '07032222222', '$2y$10$kWV1V4ZDcXynnRB4EpRVqeq1u8msAhdccRM4jttsi.qujLIQJvf8i', 'Super', '2017-01-04 22:19:16', '2021-02-18 10:53:35', '2021-02-18 11:08:34', '2021-02-18 09:08:34', '1', '0'),
(2, 'Roland beni', 'Wabubindja tubongye', 'roland.beni1@gmail.com', '+243991551044', '', '$2y$10$lbjO4OlniozIU4aNCfCa5uCJIOfEUYrYw6y3ttrjm7I5NZEG.32.W', 'Super', '2020-11-13 18:23:48', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '2020-11-13 16:23:48', '1', '0'),
(3, 'Eric', 'Ampire Big.', 'ericampire@stkmgr.com', '+243999052349', '', '$2y$10$dVDXoCPk0Y9ON3cwibJKBuqm4cQWiF6c8w3gyqJIZKV4sCanCZ6fu', 'Basic', '2021-02-12 15:33:00', '2021-02-12 15:33:11', '2021-02-12 15:35:05', '2021-02-12 14:09:43', '1', '0');

-- --------------------------------------------------------

--
-- Structure de la table `backups`
--

CREATE TABLE `backups` (
  `id` int(11) NOT NULL,
  `file_name` varchar(255) CHARACTER SET utf8mb4 NOT NULL,
  `file_url` varchar(255) CHARACTER SET utf8mb4 NOT NULL,
  `date` timestamp NOT NULL DEFAULT current_timestamp(),
  `online` tinyint(4) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `backups`
--

INSERT INTO `backups` (`id`, `file_name`, `file_url`, `date`, `online`) VALUES
(1, 'nyota_2021-Feb-09_1612865506.sql', 'C:\\xampp\\htdocs\\stk\\backups\\nyota_2021-Feb-09_1612865506.sql', '2021-02-09 10:11:46', 1),
(2, 'nyota_2021-Feb-09_1612865578.sql', 'C:\\xampp\\htdocs\\stk\\backups\\nyota_2021-Feb-09_1612865578.sql', '2021-02-09 10:12:58', 1),
(3, 'nyota_2021-Feb-09_1612874484.sql', 'C:\\xampp\\htdocs\\stk\\backups\\nyota_2021-Feb-09_1612874484.sql', '2021-02-09 12:41:24', 1),
(4, 'nyota_2021-Feb-10_1612940618.sql', 'C:\\xampp\\htdocs\\stk\\backups\\nyota_2021-Feb-10_1612940618.sql', '2021-02-10 07:03:38', 1),
(5, 'nyota_2021-Feb-10_1612942249.sql', 'C:\\xampp\\htdocs\\stk\\backups\\nyota_2021-Feb-10_1612942249.sql', '2021-02-10 07:30:49', 1),
(6, 'nyota_2021-Feb-10_1612942314.sql', 'C:\\xampp\\htdocs\\stk\\backups\\nyota_2021-Feb-10_1612942314.sql', '2021-02-10 07:31:54', 1),
(7, 'nyota_2021-Feb-10_1612942833.sql', 'C:\\xampp\\htdocs\\stk\\backups\\nyota_2021-Feb-10_1612942833.sql', '2021-02-10 07:40:33', 1),
(8, 'nyota_2021-Feb-10_1612942932.sql', 'C:\\xampp\\htdocs\\stk\\backups\\nyota_2021-Feb-10_1612942932.sql', '2021-02-10 07:42:12', 1),
(9, 'nyota_2021-Feb-10_1612942938.sql', 'C:\\xampp\\htdocs\\stk\\backups\\nyota_2021-Feb-10_1612942938.sql', '2021-02-10 07:42:18', 1),
(10, 'nyota_2021-Feb-10_1612942948.sql', 'C:\\xampp\\htdocs\\stk\\backups\\nyota_2021-Feb-10_1612942948.sql', '2021-02-10 07:42:28', 1),
(11, 'nyota_2021-Feb-10_1612942961.sql', 'C:\\xampp\\htdocs\\stk\\backups\\nyota_2021-Feb-10_1612942961.sql', '2021-02-10 07:42:41', 1),
(12, 'nyota_2021-Feb-10_1612942997.sql', 'C:\\xampp\\htdocs\\stk\\backups\\nyota_2021-Feb-10_1612942997.sql', '2021-02-10 07:43:17', 1),
(13, 'nyota_2021-Feb-10_1612943155.sql', 'C:\\xampp\\htdocs\\stk\\backups\\nyota_2021-Feb-10_1612943155.sql', '2021-02-10 07:45:55', 1),
(14, 'nyota_2021-Feb-10_1612943215.sql', 'C:\\xampp\\htdocs\\stk\\backups\\nyota_2021-Feb-10_1612943215.sql', '2021-02-10 07:46:55', 1),
(15, 'nyota_2021-Feb-10_1612943419.sql', 'C:\\xampp\\htdocs\\stk\\backups\\nyota_2021-Feb-10_1612943419.sql', '2021-02-10 07:50:19', 1),
(16, 'nyota_2021-Feb-16_1613485861.sql', 'C:\\xampp\\htdocs\\stk\\backups\\nyota_2021-Feb-16_1613485861.sql', '2021-02-16 14:31:01', 1),
(17, 'nyota_2021-Feb-16_1613485929.sql', 'C:\\xampp\\htdocs\\stk\\backups\\nyota_2021-Feb-16_1613485929.sql', '2021-02-16 14:32:09', 0),
(18, 'nyota_2021-Feb-16_1613486009.sql', 'C:\\xampp\\htdocs\\stk\\backups\\nyota_2021-Feb-16_1613486009.sql', '2021-02-16 14:33:29', 0),
(19, 'nyota_2021-Feb-16_1613486027.sql', 'C:\\xampp\\htdocs\\stk\\backups\\nyota_2021-Feb-16_1613486027.sql', '2021-02-16 14:33:47', 0),
(20, 'nyota_2021-Feb-16_1613486049.sql', 'C:\\xampp\\htdocs\\stk\\backups\\nyota_2021-Feb-16_1613486049.sql', '2021-02-16 14:34:09', 0),
(21, 'nyota_2021-Feb-16_1613486055.sql', 'C:\\xampp\\htdocs\\stk\\backups\\nyota_2021-Feb-16_1613486055.sql', '2021-02-16 14:34:15', 0);

-- --------------------------------------------------------

--
-- Structure de la table `categories`
--

CREATE TABLE `categories` (
  `id` int(11) NOT NULL,
  `nom` varchar(255) CHARACTER SET utf8mb4 NOT NULL,
  `description` varchar(255) CHARACTER SET utf8mb4 NOT NULL,
  `created_on` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `categories`
--

INSERT INTO `categories` (`id`, `nom`, `description`, `created_on`) VALUES
(1, 'Boisson', 'Rafraichissements', '2021-02-16 12:34:54'),
(12, 'Vin', '', '2021-02-16 13:29:12'),
(13, 'Cakes', '', '2021-02-16 13:29:22');

-- --------------------------------------------------------

--
-- Structure de la table `couts`
--

CREATE TABLE `couts` (
  `coutsId` int(11) NOT NULL,
  `montant` decimal(10,2) NOT NULL,
  `motif` text NOT NULL,
  `author` varchar(255) NOT NULL,
  `date_sortie` date NOT NULL,
  `staffId` bigint(20) NOT NULL,
  `created_on` datetime NOT NULL,
  `lastUpdate` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `deleted` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `couts`
--

INSERT INTO `couts` (`coutsId`, `montant`, `motif`, `author`, `date_sortie`, `staffId`, `created_on`, `lastUpdate`, `deleted`) VALUES
(1, '200.00', 'Achat des stylo', 'Roben', '2021-02-16', 1, '2021-02-16 13:45:10', '2021-02-16 11:45:33', 1);

-- --------------------------------------------------------

--
-- Structure de la table `eventlog`
--

CREATE TABLE `eventlog` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `event` varchar(200) NOT NULL,
  `eventRowIdOrRef` varchar(20) DEFAULT NULL,
  `eventDesc` text DEFAULT NULL,
  `eventTable` varchar(20) DEFAULT NULL,
  `staffInCharge` bigint(20) UNSIGNED NOT NULL,
  `eventTime` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `eventlog`
--

INSERT INTO `eventlog` (`id`, `event`, `eventRowIdOrRef`, `eventDesc`, `eventTable`, `staffInCharge`, `eventTime`) VALUES
(1, 'Création d\'un nouveau article', '1', 'Ajout de 12 unités de \'iPhone12\' avec un prix unitaire de USD 1,200.00 dans le stock', 'items', 1, '2020-11-16 12:29:05'),
(2, 'Mise à jour du stock (Nouveau Stock)', '1', '<p>15 unités de iPhone12 ont été ajouter au stock</p>\n                Raison : <p>De nouveaux articles ont été achetés</p>', 'items', 1, '2020-11-16 12:29:28'),
(3, 'Création d\'un nouveau article', '2', 'Ajout de 10 unités de \'champagne\' avec un prix unitaire de USD 1,000.00 dans le stock', 'items', 1, '2021-02-01 08:28:39'),
(4, 'Création d\'un nouveau article', '3', 'Ajout de 20 unités de \'Johnny Walker\' avec un prix unitaire de USD 50.00 dans le stock', 'items', 1, '2021-02-01 08:29:12'),
(5, 'Création d\'un nouveau article', '4', 'Ajout de 60 unités de \'Jus Ceres\' avec un prix unitaire de USD 5.00 dans le stock', 'items', 1, '2021-02-01 08:29:37'),
(6, 'Création d\'un nouveau article', '5', 'Ajout de 40 unités de \'Heineken\' avec un prix unitaire de USD 2.75 dans le stock', 'items', 1, '2021-02-01 08:29:50'),
(8, 'Création d\'un nouveau article', '7', 'Ajout de 27 unités de \'Black Label\' avec un prix unitaire de USD 50.00 dans le stock', 'items', 1, '2021-02-01 08:30:26'),
(9, 'Création d\'un nouveau article', '8', 'Ajout de 56 unités de \'Savanna\' avec un prix unitaire de USD 2.75 dans le stock', 'items', 1, '2021-02-01 08:30:45'),
(10, 'Création d\'un nouveau article', '9', 'Ajout de 20 unités de \'Hunters\' avec un prix unitaire de USD 2.75 dans le stock', 'items', 1, '2021-02-01 08:31:14'),
(11, 'Nouvelle transaction', '57129302', '1 articles totalisant USD 8.25 avec le numéro de référence 57129302 a été acheté', 'transactions', 1, '2021-02-01 08:33:36'),
(12, 'Nouvelle transaction', '12901827', '1 articles totalisant USD 5.50 avec le numéro de référence 12901827 a été acheté', 'transactions', 1, '2021-02-01 12:09:35'),
(13, 'Nouvelle transaction', '17698160', '2 articles totalisant USD 55.00 avec le numéro de référence 17698160 a été acheté', 'transactions', 1, '2021-02-01 12:23:50'),
(14, 'Mise à jour de l\'article', '7', 'Le détails de l\'article avec le code \'960CU9YRGY3\' ont été mise à jour', 'items', 1, '2021-02-08 12:08:29'),
(15, 'Mise à jour de l\'article', '7', 'Le détails de l\'article avec le code \'960CU9YRGY3\' ont été mise à jour', 'items', 1, '2021-02-08 12:08:44'),
(16, 'Nouvelle transaction', '019632820', '1 articles totalisant USD 50.00 avec le numéro de référence 019632820 a été acheté', 'transactions', 1, '2021-02-08 12:14:41'),
(17, 'Nouvelle transaction', '4921870', '1 articles totalisant USD 50.00 avec le numéro de référence 4921870 a été acheté', 'transactions', 1, '2021-02-08 12:17:34'),
(18, 'Nouvelle transaction', '77059481', '3 articles totalisant USD 57.75 avec le numéro de référence 77059481 a été acheté', 'transactions', 1, '2021-02-10 08:10:32'),
(19, 'Mise à jour de l\'article', '7', 'Le détails de l\'article avec le code \'960CU9YRGY\' ont été mise à jour', 'items', 1, '2021-02-13 09:14:44'),
(20, 'Création d\'un nouveau article', '10', 'Ajout de 25 unités de \'Cake\' avec un prix unitaire de USD 35.00 dans le stock', 'items', 1, '2021-02-15 13:36:51'),
(21, 'Création d\'un nouveau article', '11', 'Ajout de 32 unités de \'Zombo\' avec un prix unitaire de USD 20.00 dans le stock', 'items', 1, '2021-02-15 13:39:41'),
(22, 'Création d\'un nouveau article', '12', 'Ajout de 45 unités de \'Maziwa\' avec un prix unitaire de USD 10.00 dans le stock', 'items', 1, '2021-02-15 13:41:42'),
(23, 'Création d\'un nouveau article', '13', 'Ajout de 50 unités de \'YV\' avec un prix unitaire de USD 30.00 dans le stock', 'items', 1, '2021-02-15 13:47:31'),
(24, 'Création d\'un nouveau article', '14', 'Ajout de 63 unités de \'meschack\' avec un prix unitaire de USD 30.00 dans le stock', 'items', 1, '2021-02-15 13:59:22'),
(25, 'Mise à jour de l\'article', '7', 'Le détails de l\'article avec le code \'960CU9YRGY\' ont été mise à jour', 'items', 1, '2021-02-15 21:32:10'),
(26, 'Mise à jour de l\'article', '14', 'Le détails de l\'article avec le code \'8B973YMCF8\' ont été mise à jour', 'items', 1, '2021-02-16 06:25:53'),
(27, 'Mise à jour de l\'article', '14', 'Le détails de l\'article avec le code \'8B973YMCF8\' ont été mise à jour', 'items', 1, '2021-02-16 06:29:12'),
(28, 'Mise à jour de l\'article', '14', 'Le détails de l\'article avec le code \'8B973YMCF8\' ont été mise à jour', 'items', 1, '2021-02-16 09:39:59'),
(29, 'Mise à jour de l\'article', '14', 'Le détails de l\'article avec le code \'8B973YMCF8\' ont été mise à jour', 'items', 1, '2021-02-16 09:41:14'),
(30, 'Mise à jour de l\'article', '14', 'Le détails de l\'article avec le code \'8B973YMCF8\' ont été mise à jour', 'items', 1, '2021-02-16 09:42:22'),
(31, 'Mise à jour de l\'article', '14', 'Le détails de l\'article avec le code \'8B973YMCF8\' ont été mise à jour', 'items', 1, '2021-02-16 09:42:51'),
(32, 'Mise à jour de l\'article', '14', 'Le détails de l\'article avec le code \'8B973YMCF8\' ont été mise à jour', 'items', 1, '2021-02-16 09:45:10'),
(33, 'Mise à jour de l\'article', '14', 'Le détails de l\'article avec le code \'8B973YMCF8\' ont été mise à jour', 'items', 1, '2021-02-16 09:45:50'),
(34, 'Mise à jour de l\'article', '14', 'Le détails de l\'article avec le code \'8B973YMCF8\' ont été mise à jour', 'items', 1, '2021-02-16 09:46:09'),
(35, 'Mise à jour de l\'article', '14', 'Le détails de l\'article avec le code \'8B973YMCF8\' ont été mise à jour', 'items', 1, '2021-02-16 09:47:23'),
(36, 'Mise à jour de l\'article', '14', 'Le détails de l\'article avec le code \'8B973YMCF8\' ont été mise à jour', 'items', 1, '2021-02-16 09:49:27'),
(37, 'Mise à jour de l\'article', '14', 'Le détails de l\'article avec le code \'8B973YMCF8\' ont été mise à jour', 'items', 1, '2021-02-16 09:49:47'),
(38, 'Mise à jour de l\'article', '14', 'Le détails de l\'article avec le code \'8B973YMCF8\' ont été mise à jour', 'items', 1, '2021-02-16 09:52:13'),
(39, 'Mise à jour de l\'article', '14', 'Le détails de l\'article avec le code \'8B973YMCF8\' ont été mise à jour', 'items', 1, '2021-02-16 09:52:39'),
(40, 'Mise à jour de l\'article', '14', 'Le détails de l\'article avec le code \'8B973YMCF8\' ont été mise à jour', 'items', 1, '2021-02-16 10:13:47'),
(41, 'Mise à jour de l\'article', '14', 'Le détails de l\'article avec le code \'8B973YMCF8\' ont été mise à jour', 'items', 1, '2021-02-16 10:13:58'),
(42, 'Mise à jour de l\'article', '14', 'Le détails de l\'article avec le code \'8B973YMCF8\' ont été mise à jour', 'items', 1, '2021-02-16 10:14:51'),
(43, 'Mise à jour de l\'article', '14', 'Le détails de l\'article avec le code \'8B973YMCF8\' ont été mise à jour', 'items', 1, '2021-02-16 11:08:30'),
(44, 'Mise à jour de l\'article', '14', 'Le détails de l\'article avec le code \'8B973YMCF8\' ont été mise à jour', 'items', 1, '2021-02-16 11:08:55'),
(45, 'Mise à jour de l\'article', '14', 'Le détails de l\'article avec le code \'8B973YMCF8\' ont été mise à jour', 'items', 1, '2021-02-16 11:21:31'),
(46, 'Mise à jour de l\'article', '14', 'Le détails de l\'article avec le code \'8B973YMCF8\' ont été mise à jour', 'items', 1, '2021-02-16 11:36:21'),
(47, 'Mise à jour de l\'article', '7', 'Le détails de l\'article avec le code \'960CU9YRGY\' ont été mise à jour', 'items', 1, '2021-02-16 13:29:34'),
(48, 'Mise à jour de l\'article', '10', 'Le détails de l\'article avec le code \'B4JF6E3PJE\' ont été mise à jour', 'items', 1, '2021-02-16 13:29:43'),
(49, 'Mise à jour de l\'article', '10', 'Le détails de l\'article avec le code \'B4JF6E3PJE\' ont été mise à jour', 'items', 1, '2021-02-16 13:29:57'),
(50, 'Mise à jour de l\'article', '2', 'Le détails de l\'article avec le code \'HOH8JXRHUS\' ont été mise à jour', 'items', 1, '2021-02-16 13:30:27'),
(51, 'Mise à jour de l\'article', '4', 'Le détails de l\'article avec le code \'9OELH9R80F\' ont été mise à jour', 'items', 1, '2021-02-16 13:30:39'),
(52, 'Mise à jour de l\'article', '5', 'Le détails de l\'article avec le code \'3HRRCAAAMN\' ont été mise à jour', 'items', 1, '2021-02-16 13:53:41'),
(53, 'Mise à jour de l\'article', '9', 'Le détails de l\'article avec le code \'FOGRLTPCHX\' ont été mise à jour', 'items', 1, '2021-02-16 13:53:47'),
(54, 'Mise à jour de l\'article', '3', 'Le détails de l\'article avec le code \'JOH804N247\' ont été mise à jour', 'items', 1, '2021-02-16 13:53:52'),
(55, 'Mise à jour de l\'article', '8', 'Le détails de l\'article avec le code \'T7TX01D1W9\' ont été mise à jour', 'items', 1, '2021-02-16 13:54:03');

-- --------------------------------------------------------

--
-- Structure de la table `items`
--

CREATE TABLE `items` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(50) NOT NULL,
  `code` varchar(50) NOT NULL,
  `description` text DEFAULT NULL,
  `unitPrice` decimal(10,2) NOT NULL,
  `quantity` int(6) NOT NULL,
  `dateAdded` datetime NOT NULL,
  `lastUpdated` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `items`
--

INSERT INTO `items` (`id`, `name`, `code`, `description`, `unitPrice`, `quantity`, `dateAdded`, `lastUpdated`) VALUES
(2, 'champagne', 'HOH8JXRHUS', '', '1000.00', 10, '2021-02-01 10:28:39', '2021-02-01 08:28:39'),
(3, 'Johnny Walker', 'JOH804N247', '', '50.00', 19, '2021-02-01 10:29:12', '2021-02-08 12:17:34'),
(4, 'Jus Ceres', '9OELH9R80F', '', '5.00', 58, '2021-02-01 10:29:37', '2021-02-10 08:10:32'),
(5, 'Heineken', '3HRRCAAAMN', '', '2.00', 37, '2021-02-01 10:29:50', '2021-02-16 13:53:41'),
(7, 'Black Label', '960CU9YRGY', 'Red wine', '50.00', 25, '2021-02-01 10:30:26', '2021-02-13 09:14:44'),
(8, 'Savanna', 'T7TX01D1W9', '', '2.00', 54, '2021-02-01 10:30:45', '2021-02-16 13:54:03'),
(9, 'Hunters', 'FOGRLTPCHX', '', '2.00', 19, '2021-02-01 10:31:14', '2021-02-16 13:53:47'),
(10, 'Cake', 'B4JF6E3PJE', '', '35.00', 25, '2021-02-15 15:36:51', '2021-02-15 13:36:51'),
(12, 'Maziwa', 'XDE35T97YD', '', '10.00', 45, '2021-02-15 15:41:42', '2021-02-15 13:41:42');

-- --------------------------------------------------------

--
-- Structure de la table `item_category`
--

CREATE TABLE `item_category` (
  `id` int(11) NOT NULL,
  `id_item` bigint(20) NOT NULL,
  `id_category` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `item_category`
--

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

-- --------------------------------------------------------

--
-- Structure de la table `lk_sess`
--

CREATE TABLE `lk_sess` (
  `id` varchar(40) NOT NULL,
  `ip_address` varchar(45) NOT NULL,
  `timestamp` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `data` blob NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `transactions`
--

CREATE TABLE `transactions` (
  `transId` bigint(20) UNSIGNED NOT NULL,
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
  `staffId` bigint(20) UNSIGNED NOT NULL,
  `transDate` datetime NOT NULL,
  `lastUpdated` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `cancelled` char(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `transactions`
--

INSERT INTO `transactions` (`transId`, `ref`, `itemName`, `itemCode`, `description`, `quantity`, `unitPrice`, `totalPrice`, `totalMoneySpent`, `amountTendered`, `discount_amount`, `discount_percentage`, `vatPercentage`, `vatAmount`, `changeDue`, `modeOfPayment`, `cust_name`, `cust_phone`, `cust_email`, `transType`, `staffId`, `transDate`, `lastUpdated`, `cancelled`) VALUES
(1, '57129302', 'Heineken', '3HRRCAAAMN', '', 3, '2.75', '8.25', '8.25', '10.00', '0.00', '0.00', '0.00', '0.00', '1.75', 'Cash', '', '', '', '1', 1, '2021-02-01 10:33:36', '2021-02-01 08:33:36', '0'),
(2, '12901827', 'Savanna', 'T7TX01D1W9', '', 2, '2.75', '5.50', '5.50', '10.00', '0.00', '0.00', '0.00', '0.00', '4.50', 'Cash', 'Roland Wabubindja Tu', '', '', '1', 1, '2021-02-01 14:09:35', '2021-02-01 12:09:35', '0'),
(3, '17698160', 'Jus Ceres', '9OELH9R80F', '', 1, '5.00', '5.00', '55.00', '100.00', '0.00', '0.00', '0.00', '0.00', '45.00', 'Cash', 'Roben', '+243991551044', '', '1', 1, '2021-02-01 14:23:50', '2021-02-01 12:23:50', '0'),
(5, '019632820', 'Black Label', '960CU9YRGY', '', 1, '50.00', '50.00', '50.00', '100.00', '0.00', '0.00', '0.00', '0.00', '50.00', 'Cash', '', '', '', '1', 1, '2021-02-08 14:14:40', '2021-02-08 12:14:40', '0'),
(6, '4921870', 'Johnny Walker', 'JOH804N247', '', 1, '50.00', '50.00', '50.00', '50.00', '0.00', '0.00', '0.00', '0.00', '0.00', 'Cash and POS', '', '', '', '1', 1, '2021-02-08 14:17:34', '2021-02-08 12:17:34', '0'),
(7, '77059481', 'Jus Ceres', '9OELH9R80F', '', 1, '5.00', '5.00', '57.75', '100.00', '0.00', '0.00', '0.00', '0.00', '42.25', 'Cash', '', '', '', '1', 1, '2021-02-10 10:10:32', '2021-02-10 08:10:32', '0'),
(8, '77059481', 'Hunters', 'FOGRLTPCHX', '', 1, '2.75', '2.75', '57.75', '100.00', '0.00', '0.00', '0.00', '0.00', '42.25', 'Cash', '', '', '', '1', 1, '2021-02-10 10:10:32', '2021-02-10 08:10:32', '0'),
(9, '77059481', 'Black Label', '960CU9YRGY', '', 1, '50.00', '50.00', '57.75', '100.00', '0.00', '0.00', '0.00', '0.00', '42.25', 'Cash', '', '', '', '1', 1, '2021-02-10 10:10:32', '2021-02-10 08:10:32', '0');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `mobile1` (`mobile1`);

--
-- Index pour la table `backups`
--
ALTER TABLE `backups`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `couts`
--
ALTER TABLE `couts`
  ADD PRIMARY KEY (`coutsId`);

--
-- Index pour la table `eventlog`
--
ALTER TABLE `eventlog`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `items`
--
ALTER TABLE `items`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`),
  ADD UNIQUE KEY `code` (`code`);

--
-- Index pour la table `item_category`
--
ALTER TABLE `item_category`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_item` (`id_item`),
  ADD KEY `id_category` (`id_category`);

--
-- Index pour la table `transactions`
--
ALTER TABLE `transactions`
  ADD PRIMARY KEY (`transId`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT pour la table `backups`
--
ALTER TABLE `backups`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT pour la table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT pour la table `couts`
--
ALTER TABLE `couts`
  MODIFY `coutsId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT pour la table `eventlog`
--
ALTER TABLE `eventlog`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=56;

--
-- AUTO_INCREMENT pour la table `items`
--
ALTER TABLE `items`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT pour la table `item_category`
--
ALTER TABLE `item_category`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=47;

--
-- AUTO_INCREMENT pour la table `transactions`
--
ALTER TABLE `transactions`
  MODIFY `transId` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `item_category`
--
ALTER TABLE `item_category`
  ADD CONSTRAINT `item_category_ibfk_1` FOREIGN KEY (`id_category`) REFERENCES `categories` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
