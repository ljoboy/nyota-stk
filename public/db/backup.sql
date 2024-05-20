#
# TABLE STRUCTURE FOR: admin
#

DROP TABLE IF EXISTS `admin`;

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

INSERT INTO `admin` (`id`, `first_name`, `last_name`, `email`, `mobile1`, `mobile2`, `password`, `role`, `created_on`, `last_login`, `last_seen`, `last_edited`, `account_status`, `deleted`) VALUES (1, 'Admin', 'Admin', 'admin@stkmgr.com', '08021111111', '07032222222', '$2y$10$kWV1V4ZDcXynnRB4EpRVqeq1u8msAhdccRM4jttsi.qujLIQJvf8i', 'Super', '2017-01-04 22:19:16', '2022-12-21 19:10:14', '2022-12-10 13:53:40', '2022-12-21 19:10:14', '1', '0');
INSERT INTO `admin` (`id`, `first_name`, `last_name`, `email`, `mobile1`, `mobile2`, `password`, `role`, `created_on`, `last_login`, `last_seen`, `last_edited`, `account_status`, `deleted`) VALUES (2, 'Jeanne', 'Doe Doe', 'jeannedoe@stkmgr.com', '+243991551044', '', '$2y$10$lbjO4OlniozIU4aNCfCa5uCJIOfEUYrYw6y3ttrjm7I5NZEG.32.W', 'Super', '2020-11-13 18:23:48', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '2022-11-14 11:57:20', '1', '0');
INSERT INTO `admin` (`id`, `first_name`, `last_name`, `email`, `mobile1`, `mobile2`, `password`, `role`, `created_on`, `last_login`, `last_seen`, `last_edited`, `account_status`, `deleted`) VALUES (3, 'John', 'Doe', 'johndoe@stkmgr.com', '+243999052349', '', '$2y$10$dVDXoCPk0Y9ON3cwibJKBuqm4cQWiF6c8w3gyqJIZKV4sCanCZ6fu', 'Basic', '2021-02-12 15:33:00', '2021-02-12 15:33:11', '2021-02-12 15:35:05', '2022-11-14 11:55:49', '1', '0');


#
# TABLE STRUCTURE FOR: backups
#

DROP TABLE IF EXISTS `backups`;

CREATE TABLE `backups` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `file_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `file_url` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `date` timestamp NOT NULL DEFAULT current_timestamp(),
  `online` tinyint(4) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

INSERT INTO `backups` (`id`, `file_name`, `file_url`, `date`, `online`) VALUES (1, 'nyota_2021-Feb-09_1612865506.sql', 'C:\\xampp\\htdocs\\stk\\backups\\nyota_2021-Feb-09_1612865506.sql', '2021-02-09 12:11:46', 1);
INSERT INTO `backups` (`id`, `file_name`, `file_url`, `date`, `online`) VALUES (2, 'nyota_2021-Feb-09_1612865578.sql', 'C:\\xampp\\htdocs\\stk\\backups\\nyota_2021-Feb-09_1612865578.sql', '2021-02-09 12:12:58', 1);
INSERT INTO `backups` (`id`, `file_name`, `file_url`, `date`, `online`) VALUES (3, 'nyota_2021-Feb-09_1612874484.sql', 'C:\\xampp\\htdocs\\stk\\backups\\nyota_2021-Feb-09_1612874484.sql', '2021-02-09 14:41:24', 1);
INSERT INTO `backups` (`id`, `file_name`, `file_url`, `date`, `online`) VALUES (4, 'nyota_2021-Feb-10_1612940618.sql', 'C:\\xampp\\htdocs\\stk\\backups\\nyota_2021-Feb-10_1612940618.sql', '2021-02-10 09:03:38', 1);
INSERT INTO `backups` (`id`, `file_name`, `file_url`, `date`, `online`) VALUES (5, 'nyota_2021-Feb-10_1612942249.sql', 'C:\\xampp\\htdocs\\stk\\backups\\nyota_2021-Feb-10_1612942249.sql', '2021-02-10 09:30:49', 1);
INSERT INTO `backups` (`id`, `file_name`, `file_url`, `date`, `online`) VALUES (6, 'nyota_2021-Feb-10_1612942314.sql', 'C:\\xampp\\htdocs\\stk\\backups\\nyota_2021-Feb-10_1612942314.sql', '2021-02-10 09:31:54', 1);
INSERT INTO `backups` (`id`, `file_name`, `file_url`, `date`, `online`) VALUES (7, 'nyota_2021-Feb-10_1612942833.sql', 'C:\\xampp\\htdocs\\stk\\backups\\nyota_2021-Feb-10_1612942833.sql', '2021-02-10 09:40:33', 1);
INSERT INTO `backups` (`id`, `file_name`, `file_url`, `date`, `online`) VALUES (8, 'nyota_2021-Feb-10_1612942932.sql', 'C:\\xampp\\htdocs\\stk\\backups\\nyota_2021-Feb-10_1612942932.sql', '2021-02-10 09:42:12', 1);
INSERT INTO `backups` (`id`, `file_name`, `file_url`, `date`, `online`) VALUES (9, 'nyota_2021-Feb-10_1612942938.sql', 'C:\\xampp\\htdocs\\stk\\backups\\nyota_2021-Feb-10_1612942938.sql', '2021-02-10 09:42:18', 1);
INSERT INTO `backups` (`id`, `file_name`, `file_url`, `date`, `online`) VALUES (10, 'nyota_2021-Feb-10_1612942948.sql', 'C:\\xampp\\htdocs\\stk\\backups\\nyota_2021-Feb-10_1612942948.sql', '2021-02-10 09:42:28', 1);
INSERT INTO `backups` (`id`, `file_name`, `file_url`, `date`, `online`) VALUES (11, 'nyota_2021-Feb-10_1612942961.sql', 'C:\\xampp\\htdocs\\stk\\backups\\nyota_2021-Feb-10_1612942961.sql', '2021-02-10 09:42:41', 1);
INSERT INTO `backups` (`id`, `file_name`, `file_url`, `date`, `online`) VALUES (12, 'nyota_2021-Feb-10_1612942997.sql', 'C:\\xampp\\htdocs\\stk\\backups\\nyota_2021-Feb-10_1612942997.sql', '2021-02-10 09:43:17', 1);
INSERT INTO `backups` (`id`, `file_name`, `file_url`, `date`, `online`) VALUES (13, 'nyota_2021-Feb-10_1612943155.sql', 'C:\\xampp\\htdocs\\stk\\backups\\nyota_2021-Feb-10_1612943155.sql', '2021-02-10 09:45:55', 1);
INSERT INTO `backups` (`id`, `file_name`, `file_url`, `date`, `online`) VALUES (14, 'nyota_2021-Feb-10_1612943215.sql', 'C:\\xampp\\htdocs\\stk\\backups\\nyota_2021-Feb-10_1612943215.sql', '2021-02-10 09:46:55', 1);
INSERT INTO `backups` (`id`, `file_name`, `file_url`, `date`, `online`) VALUES (15, 'nyota_2021-Feb-10_1612943419.sql', 'C:\\xampp\\htdocs\\stk\\backups\\nyota_2021-Feb-10_1612943419.sql', '2021-02-10 09:50:19', 1);
INSERT INTO `backups` (`id`, `file_name`, `file_url`, `date`, `online`) VALUES (16, 'nyota_2021-Feb-16_1613485861.sql', 'C:\\xampp\\htdocs\\stk\\backups\\nyota_2021-Feb-16_1613485861.sql', '2021-02-16 16:31:01', 1);
INSERT INTO `backups` (`id`, `file_name`, `file_url`, `date`, `online`) VALUES (17, 'nyota_2021-Feb-16_1613485929.sql', 'C:\\xampp\\htdocs\\stk\\backups\\nyota_2021-Feb-16_1613485929.sql', '2021-02-16 16:32:09', 0);
INSERT INTO `backups` (`id`, `file_name`, `file_url`, `date`, `online`) VALUES (18, 'nyota_2021-Feb-16_1613486009.sql', 'C:\\xampp\\htdocs\\stk\\backups\\nyota_2021-Feb-16_1613486009.sql', '2021-02-16 16:33:29', 0);
INSERT INTO `backups` (`id`, `file_name`, `file_url`, `date`, `online`) VALUES (19, 'nyota_2021-Feb-16_1613486027.sql', 'C:\\xampp\\htdocs\\stk\\backups\\nyota_2021-Feb-16_1613486027.sql', '2021-02-16 16:33:47', 0);
INSERT INTO `backups` (`id`, `file_name`, `file_url`, `date`, `online`) VALUES (20, 'nyota_2021-Feb-16_1613486049.sql', 'C:\\xampp\\htdocs\\stk\\backups\\nyota_2021-Feb-16_1613486049.sql', '2021-02-16 16:34:09', 0);
INSERT INTO `backups` (`id`, `file_name`, `file_url`, `date`, `online`) VALUES (21, 'nyota_2021-Feb-16_1613486055.sql', 'C:\\xampp\\htdocs\\stk\\backups\\nyota_2021-Feb-16_1613486055.sql', '2021-02-16 16:34:15', 0);


#
# TABLE STRUCTURE FOR: categories
#

DROP TABLE IF EXISTS `categories`;

CREATE TABLE `categories` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nom` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `description` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `created_on` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

INSERT INTO `categories` (`id`, `nom`, `description`, `created_on`) VALUES (1, 'Boisson', 'Rafraichissements', '2022-12-21 19:14:12');
INSERT INTO `categories` (`id`, `nom`, `description`, `created_on`) VALUES (12, 'Vin', '', '2021-02-16 15:29:12');
INSERT INTO `categories` (`id`, `nom`, `description`, `created_on`) VALUES (13, 'Cake', '', '2022-12-21 19:14:21');


#
# TABLE STRUCTURE FOR: commandes
#

DROP TABLE IF EXISTS `commandes`;

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

INSERT INTO `commandes` (`id`, `ref`, `item_id`, `quantity`, `sended_at`, `created_at`, `supplier_id`) VALUES ('1', '84732820496561159', '5', '25', '2022-12-10 13:41:41', '2022-12-10 12:06:28', '10');
INSERT INTO `commandes` (`id`, `ref`, `item_id`, `quantity`, `sended_at`, `created_at`, `supplier_id`) VALUES ('2', '1259687408396271', '5', '717', '2022-12-10 13:41:41', '2022-12-10 12:07:11', '10');
INSERT INTO `commandes` (`id`, `ref`, `item_id`, `quantity`, `sended_at`, `created_at`, `supplier_id`) VALUES ('3', '681438573049597', '12', '25', '2022-12-10 13:41:46', '2022-12-10 12:07:19', '12');
INSERT INTO `commandes` (`id`, `ref`, `item_id`, `quantity`, `sended_at`, `created_at`, `supplier_id`) VALUES ('4', '4275983564469', '4', '26', '2022-12-10 13:41:41', '2022-12-10 12:07:29', '10');
INSERT INTO `commandes` (`id`, `ref`, `item_id`, `quantity`, `sended_at`, `created_at`, `supplier_id`) VALUES ('5', '437196205823154', '5', '63', '2022-12-10 13:41:41', '2022-12-10 12:07:38', '10');


#
# TABLE STRUCTURE FOR: couts
#

DROP TABLE IF EXISTS `couts`;

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

INSERT INTO `couts` (`coutsId`, `montant`, `motif`, `author`, `date_sortie`, `staffId`, `created_on`, `lastUpdate`, `deleted`) VALUES (1, '200.00', 'Achat des stylo', 'Roben', '2021-02-16', '1', '2021-02-16 13:45:10', '2021-02-16 13:45:33', 1);


#
# TABLE STRUCTURE FOR: eventlog
#

DROP TABLE IF EXISTS `eventlog`;

CREATE TABLE `eventlog` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `event` varchar(200) NOT NULL,
  `eventRowIdOrRef` varchar(20) DEFAULT NULL,
  `eventDesc` text DEFAULT NULL,
  `eventTable` varchar(20) DEFAULT NULL,
  `staffInCharge` bigint(20) unsigned NOT NULL,
  `eventTime` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=61 DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

INSERT INTO `eventlog` (`id`, `event`, `eventRowIdOrRef`, `eventDesc`, `eventTable`, `staffInCharge`, `eventTime`) VALUES ('1', 'Création d\'un nouveau article', '1', 'Ajout de 12 unités de \'iPhone12\' avec un prix unitaire de USD 1,200.00 dans le stock', 'items', '1', '2020-11-16 14:29:05');
INSERT INTO `eventlog` (`id`, `event`, `eventRowIdOrRef`, `eventDesc`, `eventTable`, `staffInCharge`, `eventTime`) VALUES ('2', 'Mise à jour du stock (Nouveau Stock)', '1', '<p>15 unités de iPhone12 ont été ajouter au stock</p>\n                Raison : <p>De nouveaux articles ont été achetés</p>', 'items', '1', '2020-11-16 14:29:28');
INSERT INTO `eventlog` (`id`, `event`, `eventRowIdOrRef`, `eventDesc`, `eventTable`, `staffInCharge`, `eventTime`) VALUES ('3', 'Création d\'un nouveau article', '2', 'Ajout de 10 unités de \'champagne\' avec un prix unitaire de USD 1,000.00 dans le stock', 'items', '1', '2021-02-01 10:28:39');
INSERT INTO `eventlog` (`id`, `event`, `eventRowIdOrRef`, `eventDesc`, `eventTable`, `staffInCharge`, `eventTime`) VALUES ('4', 'Création d\'un nouveau article', '3', 'Ajout de 20 unités de \'Johnny Walker\' avec un prix unitaire de USD 50.00 dans le stock', 'items', '1', '2021-02-01 10:29:12');
INSERT INTO `eventlog` (`id`, `event`, `eventRowIdOrRef`, `eventDesc`, `eventTable`, `staffInCharge`, `eventTime`) VALUES ('5', 'Création d\'un nouveau article', '4', 'Ajout de 60 unités de \'Jus Ceres\' avec un prix unitaire de USD 5.00 dans le stock', 'items', '1', '2021-02-01 10:29:37');
INSERT INTO `eventlog` (`id`, `event`, `eventRowIdOrRef`, `eventDesc`, `eventTable`, `staffInCharge`, `eventTime`) VALUES ('6', 'Création d\'un nouveau article', '5', 'Ajout de 40 unités de \'Heineken\' avec un prix unitaire de USD 2.75 dans le stock', 'items', '1', '2021-02-01 10:29:50');
INSERT INTO `eventlog` (`id`, `event`, `eventRowIdOrRef`, `eventDesc`, `eventTable`, `staffInCharge`, `eventTime`) VALUES ('8', 'Création d\'un nouveau article', '7', 'Ajout de 27 unités de \'Black Label\' avec un prix unitaire de USD 50.00 dans le stock', 'items', '1', '2021-02-01 10:30:26');
INSERT INTO `eventlog` (`id`, `event`, `eventRowIdOrRef`, `eventDesc`, `eventTable`, `staffInCharge`, `eventTime`) VALUES ('9', 'Création d\'un nouveau article', '8', 'Ajout de 56 unités de \'Savanna\' avec un prix unitaire de USD 2.75 dans le stock', 'items', '1', '2021-02-01 10:30:45');
INSERT INTO `eventlog` (`id`, `event`, `eventRowIdOrRef`, `eventDesc`, `eventTable`, `staffInCharge`, `eventTime`) VALUES ('10', 'Création d\'un nouveau article', '9', 'Ajout de 20 unités de \'Hunters\' avec un prix unitaire de USD 2.75 dans le stock', 'items', '1', '2021-02-01 10:31:14');
INSERT INTO `eventlog` (`id`, `event`, `eventRowIdOrRef`, `eventDesc`, `eventTable`, `staffInCharge`, `eventTime`) VALUES ('11', 'Nouvelle transaction', '57129302', '1 articles totalisant USD 8.25 avec le numéro de référence 57129302 a été acheté', 'transactions', '1', '2021-02-01 10:33:36');
INSERT INTO `eventlog` (`id`, `event`, `eventRowIdOrRef`, `eventDesc`, `eventTable`, `staffInCharge`, `eventTime`) VALUES ('12', 'Nouvelle transaction', '12901827', '1 articles totalisant USD 5.50 avec le numéro de référence 12901827 a été acheté', 'transactions', '1', '2021-02-01 14:09:35');
INSERT INTO `eventlog` (`id`, `event`, `eventRowIdOrRef`, `eventDesc`, `eventTable`, `staffInCharge`, `eventTime`) VALUES ('13', 'Nouvelle transaction', '17698160', '2 articles totalisant USD 55.00 avec le numéro de référence 17698160 a été acheté', 'transactions', '1', '2021-02-01 14:23:50');
INSERT INTO `eventlog` (`id`, `event`, `eventRowIdOrRef`, `eventDesc`, `eventTable`, `staffInCharge`, `eventTime`) VALUES ('14', 'Mise à jour de l\'article', '7', 'Le détails de l\'article avec le code \'960CU9YRGY3\' ont été mise à jour', 'items', '1', '2021-02-08 14:08:29');
INSERT INTO `eventlog` (`id`, `event`, `eventRowIdOrRef`, `eventDesc`, `eventTable`, `staffInCharge`, `eventTime`) VALUES ('15', 'Mise à jour de l\'article', '7', 'Le détails de l\'article avec le code \'960CU9YRGY3\' ont été mise à jour', 'items', '1', '2021-02-08 14:08:44');
INSERT INTO `eventlog` (`id`, `event`, `eventRowIdOrRef`, `eventDesc`, `eventTable`, `staffInCharge`, `eventTime`) VALUES ('16', 'Nouvelle transaction', '019632820', '1 articles totalisant USD 50.00 avec le numéro de référence 019632820 a été acheté', 'transactions', '1', '2021-02-08 14:14:41');
INSERT INTO `eventlog` (`id`, `event`, `eventRowIdOrRef`, `eventDesc`, `eventTable`, `staffInCharge`, `eventTime`) VALUES ('17', 'Nouvelle transaction', '4921870', '1 articles totalisant USD 50.00 avec le numéro de référence 4921870 a été acheté', 'transactions', '1', '2021-02-08 14:17:34');
INSERT INTO `eventlog` (`id`, `event`, `eventRowIdOrRef`, `eventDesc`, `eventTable`, `staffInCharge`, `eventTime`) VALUES ('18', 'Nouvelle transaction', '77059481', '3 articles totalisant USD 57.75 avec le numéro de référence 77059481 a été acheté', 'transactions', '1', '2021-02-10 10:10:32');
INSERT INTO `eventlog` (`id`, `event`, `eventRowIdOrRef`, `eventDesc`, `eventTable`, `staffInCharge`, `eventTime`) VALUES ('19', 'Mise à jour de l\'article', '7', 'Le détails de l\'article avec le code \'960CU9YRGY\' ont été mise à jour', 'items', '1', '2021-02-13 11:14:44');
INSERT INTO `eventlog` (`id`, `event`, `eventRowIdOrRef`, `eventDesc`, `eventTable`, `staffInCharge`, `eventTime`) VALUES ('20', 'Création d\'un nouveau article', '10', 'Ajout de 25 unités de \'Cake\' avec un prix unitaire de USD 35.00 dans le stock', 'items', '1', '2021-02-15 15:36:51');
INSERT INTO `eventlog` (`id`, `event`, `eventRowIdOrRef`, `eventDesc`, `eventTable`, `staffInCharge`, `eventTime`) VALUES ('21', 'Création d\'un nouveau article', '11', 'Ajout de 32 unités de \'Zombo\' avec un prix unitaire de USD 20.00 dans le stock', 'items', '1', '2021-02-15 15:39:41');
INSERT INTO `eventlog` (`id`, `event`, `eventRowIdOrRef`, `eventDesc`, `eventTable`, `staffInCharge`, `eventTime`) VALUES ('22', 'Création d\'un nouveau article', '12', 'Ajout de 45 unités de \'Maziwa\' avec un prix unitaire de USD 10.00 dans le stock', 'items', '1', '2021-02-15 15:41:42');
INSERT INTO `eventlog` (`id`, `event`, `eventRowIdOrRef`, `eventDesc`, `eventTable`, `staffInCharge`, `eventTime`) VALUES ('23', 'Création d\'un nouveau article', '13', 'Ajout de 50 unités de \'YV\' avec un prix unitaire de USD 30.00 dans le stock', 'items', '1', '2021-02-15 15:47:31');
INSERT INTO `eventlog` (`id`, `event`, `eventRowIdOrRef`, `eventDesc`, `eventTable`, `staffInCharge`, `eventTime`) VALUES ('24', 'Création d\'un nouveau article', '14', 'Ajout de 63 unités de \'meschack\' avec un prix unitaire de USD 30.00 dans le stock', 'items', '1', '2021-02-15 15:59:22');
INSERT INTO `eventlog` (`id`, `event`, `eventRowIdOrRef`, `eventDesc`, `eventTable`, `staffInCharge`, `eventTime`) VALUES ('25', 'Mise à jour de l\'article', '7', 'Le détails de l\'article avec le code \'960CU9YRGY\' ont été mise à jour', 'items', '1', '2021-02-15 23:32:10');
INSERT INTO `eventlog` (`id`, `event`, `eventRowIdOrRef`, `eventDesc`, `eventTable`, `staffInCharge`, `eventTime`) VALUES ('26', 'Mise à jour de l\'article', '14', 'Le détails de l\'article avec le code \'8B973YMCF8\' ont été mise à jour', 'items', '1', '2021-02-16 08:25:53');
INSERT INTO `eventlog` (`id`, `event`, `eventRowIdOrRef`, `eventDesc`, `eventTable`, `staffInCharge`, `eventTime`) VALUES ('27', 'Mise à jour de l\'article', '14', 'Le détails de l\'article avec le code \'8B973YMCF8\' ont été mise à jour', 'items', '1', '2021-02-16 08:29:12');
INSERT INTO `eventlog` (`id`, `event`, `eventRowIdOrRef`, `eventDesc`, `eventTable`, `staffInCharge`, `eventTime`) VALUES ('28', 'Mise à jour de l\'article', '14', 'Le détails de l\'article avec le code \'8B973YMCF8\' ont été mise à jour', 'items', '1', '2021-02-16 11:39:59');
INSERT INTO `eventlog` (`id`, `event`, `eventRowIdOrRef`, `eventDesc`, `eventTable`, `staffInCharge`, `eventTime`) VALUES ('29', 'Mise à jour de l\'article', '14', 'Le détails de l\'article avec le code \'8B973YMCF8\' ont été mise à jour', 'items', '1', '2021-02-16 11:41:14');
INSERT INTO `eventlog` (`id`, `event`, `eventRowIdOrRef`, `eventDesc`, `eventTable`, `staffInCharge`, `eventTime`) VALUES ('30', 'Mise à jour de l\'article', '14', 'Le détails de l\'article avec le code \'8B973YMCF8\' ont été mise à jour', 'items', '1', '2021-02-16 11:42:22');
INSERT INTO `eventlog` (`id`, `event`, `eventRowIdOrRef`, `eventDesc`, `eventTable`, `staffInCharge`, `eventTime`) VALUES ('31', 'Mise à jour de l\'article', '14', 'Le détails de l\'article avec le code \'8B973YMCF8\' ont été mise à jour', 'items', '1', '2021-02-16 11:42:51');
INSERT INTO `eventlog` (`id`, `event`, `eventRowIdOrRef`, `eventDesc`, `eventTable`, `staffInCharge`, `eventTime`) VALUES ('32', 'Mise à jour de l\'article', '14', 'Le détails de l\'article avec le code \'8B973YMCF8\' ont été mise à jour', 'items', '1', '2021-02-16 11:45:10');
INSERT INTO `eventlog` (`id`, `event`, `eventRowIdOrRef`, `eventDesc`, `eventTable`, `staffInCharge`, `eventTime`) VALUES ('33', 'Mise à jour de l\'article', '14', 'Le détails de l\'article avec le code \'8B973YMCF8\' ont été mise à jour', 'items', '1', '2021-02-16 11:45:50');
INSERT INTO `eventlog` (`id`, `event`, `eventRowIdOrRef`, `eventDesc`, `eventTable`, `staffInCharge`, `eventTime`) VALUES ('34', 'Mise à jour de l\'article', '14', 'Le détails de l\'article avec le code \'8B973YMCF8\' ont été mise à jour', 'items', '1', '2021-02-16 11:46:09');
INSERT INTO `eventlog` (`id`, `event`, `eventRowIdOrRef`, `eventDesc`, `eventTable`, `staffInCharge`, `eventTime`) VALUES ('35', 'Mise à jour de l\'article', '14', 'Le détails de l\'article avec le code \'8B973YMCF8\' ont été mise à jour', 'items', '1', '2021-02-16 11:47:23');
INSERT INTO `eventlog` (`id`, `event`, `eventRowIdOrRef`, `eventDesc`, `eventTable`, `staffInCharge`, `eventTime`) VALUES ('36', 'Mise à jour de l\'article', '14', 'Le détails de l\'article avec le code \'8B973YMCF8\' ont été mise à jour', 'items', '1', '2021-02-16 11:49:27');
INSERT INTO `eventlog` (`id`, `event`, `eventRowIdOrRef`, `eventDesc`, `eventTable`, `staffInCharge`, `eventTime`) VALUES ('37', 'Mise à jour de l\'article', '14', 'Le détails de l\'article avec le code \'8B973YMCF8\' ont été mise à jour', 'items', '1', '2021-02-16 11:49:47');
INSERT INTO `eventlog` (`id`, `event`, `eventRowIdOrRef`, `eventDesc`, `eventTable`, `staffInCharge`, `eventTime`) VALUES ('38', 'Mise à jour de l\'article', '14', 'Le détails de l\'article avec le code \'8B973YMCF8\' ont été mise à jour', 'items', '1', '2021-02-16 11:52:13');
INSERT INTO `eventlog` (`id`, `event`, `eventRowIdOrRef`, `eventDesc`, `eventTable`, `staffInCharge`, `eventTime`) VALUES ('39', 'Mise à jour de l\'article', '14', 'Le détails de l\'article avec le code \'8B973YMCF8\' ont été mise à jour', 'items', '1', '2021-02-16 11:52:39');
INSERT INTO `eventlog` (`id`, `event`, `eventRowIdOrRef`, `eventDesc`, `eventTable`, `staffInCharge`, `eventTime`) VALUES ('40', 'Mise à jour de l\'article', '14', 'Le détails de l\'article avec le code \'8B973YMCF8\' ont été mise à jour', 'items', '1', '2021-02-16 12:13:47');
INSERT INTO `eventlog` (`id`, `event`, `eventRowIdOrRef`, `eventDesc`, `eventTable`, `staffInCharge`, `eventTime`) VALUES ('41', 'Mise à jour de l\'article', '14', 'Le détails de l\'article avec le code \'8B973YMCF8\' ont été mise à jour', 'items', '1', '2021-02-16 12:13:58');
INSERT INTO `eventlog` (`id`, `event`, `eventRowIdOrRef`, `eventDesc`, `eventTable`, `staffInCharge`, `eventTime`) VALUES ('42', 'Mise à jour de l\'article', '14', 'Le détails de l\'article avec le code \'8B973YMCF8\' ont été mise à jour', 'items', '1', '2021-02-16 12:14:51');
INSERT INTO `eventlog` (`id`, `event`, `eventRowIdOrRef`, `eventDesc`, `eventTable`, `staffInCharge`, `eventTime`) VALUES ('43', 'Mise à jour de l\'article', '14', 'Le détails de l\'article avec le code \'8B973YMCF8\' ont été mise à jour', 'items', '1', '2021-02-16 13:08:30');
INSERT INTO `eventlog` (`id`, `event`, `eventRowIdOrRef`, `eventDesc`, `eventTable`, `staffInCharge`, `eventTime`) VALUES ('44', 'Mise à jour de l\'article', '14', 'Le détails de l\'article avec le code \'8B973YMCF8\' ont été mise à jour', 'items', '1', '2021-02-16 13:08:55');
INSERT INTO `eventlog` (`id`, `event`, `eventRowIdOrRef`, `eventDesc`, `eventTable`, `staffInCharge`, `eventTime`) VALUES ('45', 'Mise à jour de l\'article', '14', 'Le détails de l\'article avec le code \'8B973YMCF8\' ont été mise à jour', 'items', '1', '2021-02-16 13:21:31');
INSERT INTO `eventlog` (`id`, `event`, `eventRowIdOrRef`, `eventDesc`, `eventTable`, `staffInCharge`, `eventTime`) VALUES ('46', 'Mise à jour de l\'article', '14', 'Le détails de l\'article avec le code \'8B973YMCF8\' ont été mise à jour', 'items', '1', '2021-02-16 13:36:21');
INSERT INTO `eventlog` (`id`, `event`, `eventRowIdOrRef`, `eventDesc`, `eventTable`, `staffInCharge`, `eventTime`) VALUES ('47', 'Mise à jour de l\'article', '7', 'Le détails de l\'article avec le code \'960CU9YRGY\' ont été mise à jour', 'items', '1', '2021-02-16 15:29:34');
INSERT INTO `eventlog` (`id`, `event`, `eventRowIdOrRef`, `eventDesc`, `eventTable`, `staffInCharge`, `eventTime`) VALUES ('48', 'Mise à jour de l\'article', '10', 'Le détails de l\'article avec le code \'B4JF6E3PJE\' ont été mise à jour', 'items', '1', '2021-02-16 15:29:43');
INSERT INTO `eventlog` (`id`, `event`, `eventRowIdOrRef`, `eventDesc`, `eventTable`, `staffInCharge`, `eventTime`) VALUES ('49', 'Mise à jour de l\'article', '10', 'Le détails de l\'article avec le code \'B4JF6E3PJE\' ont été mise à jour', 'items', '1', '2021-02-16 15:29:57');
INSERT INTO `eventlog` (`id`, `event`, `eventRowIdOrRef`, `eventDesc`, `eventTable`, `staffInCharge`, `eventTime`) VALUES ('50', 'Mise à jour de l\'article', '2', 'Le détails de l\'article avec le code \'HOH8JXRHUS\' ont été mise à jour', 'items', '1', '2021-02-16 15:30:27');
INSERT INTO `eventlog` (`id`, `event`, `eventRowIdOrRef`, `eventDesc`, `eventTable`, `staffInCharge`, `eventTime`) VALUES ('51', 'Mise à jour de l\'article', '4', 'Le détails de l\'article avec le code \'9OELH9R80F\' ont été mise à jour', 'items', '1', '2021-02-16 15:30:39');
INSERT INTO `eventlog` (`id`, `event`, `eventRowIdOrRef`, `eventDesc`, `eventTable`, `staffInCharge`, `eventTime`) VALUES ('52', 'Mise à jour de l\'article', '5', 'Le détails de l\'article avec le code \'3HRRCAAAMN\' ont été mise à jour', 'items', '1', '2021-02-16 15:53:41');
INSERT INTO `eventlog` (`id`, `event`, `eventRowIdOrRef`, `eventDesc`, `eventTable`, `staffInCharge`, `eventTime`) VALUES ('53', 'Mise à jour de l\'article', '9', 'Le détails de l\'article avec le code \'FOGRLTPCHX\' ont été mise à jour', 'items', '1', '2021-02-16 15:53:47');
INSERT INTO `eventlog` (`id`, `event`, `eventRowIdOrRef`, `eventDesc`, `eventTable`, `staffInCharge`, `eventTime`) VALUES ('54', 'Mise à jour de l\'article', '3', 'Le détails de l\'article avec le code \'JOH804N247\' ont été mise à jour', 'items', '1', '2021-02-16 15:53:52');
INSERT INTO `eventlog` (`id`, `event`, `eventRowIdOrRef`, `eventDesc`, `eventTable`, `staffInCharge`, `eventTime`) VALUES ('55', 'Mise à jour de l\'article', '8', 'Le détails de l\'article avec le code \'T7TX01D1W9\' ont été mise à jour', 'items', '1', '2021-02-16 15:54:03');
INSERT INTO `eventlog` (`id`, `event`, `eventRowIdOrRef`, `eventDesc`, `eventTable`, `staffInCharge`, `eventTime`) VALUES ('56', 'Nouvelle transaction', '5072083', '1 articles totalisant USD 10.00 avec le numéro de référence 5072083 a été acheté', 'transactions', '1', '2022-11-02 14:33:45');
INSERT INTO `eventlog` (`id`, `event`, `eventRowIdOrRef`, `eventDesc`, `eventTable`, `staffInCharge`, `eventTime`) VALUES ('57', 'Nouvelle transaction', '04639741', '1 articles totalisant USD 2.00 avec le numéro de référence 04639741 a été acheté', 'transactions', '1', '2022-11-02 14:34:27');
INSERT INTO `eventlog` (`id`, `event`, `eventRowIdOrRef`, `eventDesc`, `eventTable`, `staffInCharge`, `eventTime`) VALUES ('58', 'Nouvelle transaction', '403186', '1 articles totalisant USD 5.00 avec le numéro de référence 403186 a été acheté', 'transactions', '1', '2022-11-02 14:35:02');
INSERT INTO `eventlog` (`id`, `event`, `eventRowIdOrRef`, `eventDesc`, `eventTable`, `staffInCharge`, `eventTime`) VALUES ('59', 'Nouvelle transaction', '68201975', '1 articles totalisant USD 2.00 avec le numéro de référence 68201975 a été acheté', 'transactions', '1', '2022-12-08 10:12:43');
INSERT INTO `eventlog` (`id`, `event`, `eventRowIdOrRef`, `eventDesc`, `eventTable`, `staffInCharge`, `eventTime`) VALUES ('60', 'Nouvelle transaction', '247869', '2 articles totalisant USD 7.00 avec le numéro de référence 247869 a été acheté', 'transactions', '1', '2022-12-21 19:10:58');


#
# TABLE STRUCTURE FOR: item_category
#

DROP TABLE IF EXISTS `item_category`;

CREATE TABLE `item_category` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_item` bigint(20) NOT NULL,
  `id_category` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id_item` (`id_item`),
  KEY `id_category` (`id_category`),
  CONSTRAINT `item_category_ibfk_1` FOREIGN KEY (`id_category`) REFERENCES `categories` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=50 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

INSERT INTO `item_category` (`id`, `id_item`, `id_category`) VALUES (3, '12', 1);
INSERT INTO `item_category` (`id`, `id_item`, `id_category`) VALUES (30, '7', 1);
INSERT INTO `item_category` (`id`, `id_item`, `id_category`) VALUES (31, '7', 12);
INSERT INTO `item_category` (`id`, `id_item`, `id_category`) VALUES (35, '10', 13);
INSERT INTO `item_category` (`id`, `id_item`, `id_category`) VALUES (36, '2', 1);
INSERT INTO `item_category` (`id`, `id_item`, `id_category`) VALUES (37, '2', 12);
INSERT INTO `item_category` (`id`, `id_item`, `id_category`) VALUES (38, '4', 1);
INSERT INTO `item_category` (`id`, `id_item`, `id_category`) VALUES (39, '5', 1);
INSERT INTO `item_category` (`id`, `id_item`, `id_category`) VALUES (40, '5', 12);
INSERT INTO `item_category` (`id`, `id_item`, `id_category`) VALUES (41, '9', 1);
INSERT INTO `item_category` (`id`, `id_item`, `id_category`) VALUES (42, '9', 12);
INSERT INTO `item_category` (`id`, `id_item`, `id_category`) VALUES (43, '3', 1);
INSERT INTO `item_category` (`id`, `id_item`, `id_category`) VALUES (44, '3', 12);
INSERT INTO `item_category` (`id`, `id_item`, `id_category`) VALUES (45, '8', 1);
INSERT INTO `item_category` (`id`, `id_item`, `id_category`) VALUES (46, '8', 12);


#
# TABLE STRUCTURE FOR: item_supplier
#

DROP TABLE IF EXISTS `item_supplier`;

CREATE TABLE `item_supplier` (
  `item_id` bigint(20) unsigned NOT NULL,
  `supplier_id` bigint(20) unsigned NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  KEY `item_supplier_items_id_fk` (`item_id`),
  KEY `item_supplier_suppliers_id_fk` (`supplier_id`),
  CONSTRAINT `item_supplier_items_id_fk` FOREIGN KEY (`item_id`) REFERENCES `items` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `item_supplier_suppliers_id_fk` FOREIGN KEY (`supplier_id`) REFERENCES `suppliers` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `item_supplier` (`item_id`, `supplier_id`, `created_at`) VALUES ('5', '10', '2022-12-09 16:06:46');
INSERT INTO `item_supplier` (`item_id`, `supplier_id`, `created_at`) VALUES ('9', '10', '2022-12-09 16:06:46');
INSERT INTO `item_supplier` (`item_id`, `supplier_id`, `created_at`) VALUES ('3', '10', '2022-12-09 16:06:46');
INSERT INTO `item_supplier` (`item_id`, `supplier_id`, `created_at`) VALUES ('4', '10', '2022-12-09 16:06:46');
INSERT INTO `item_supplier` (`item_id`, `supplier_id`, `created_at`) VALUES ('8', '10', '2022-12-09 16:06:46');
INSERT INTO `item_supplier` (`item_id`, `supplier_id`, `created_at`) VALUES ('7', '11', '2022-12-09 16:07:13');
INSERT INTO `item_supplier` (`item_id`, `supplier_id`, `created_at`) VALUES ('2', '11', '2022-12-09 16:07:13');
INSERT INTO `item_supplier` (`item_id`, `supplier_id`, `created_at`) VALUES ('9', '11', '2022-12-09 16:07:13');
INSERT INTO `item_supplier` (`item_id`, `supplier_id`, `created_at`) VALUES ('4', '11', '2022-12-09 16:07:13');
INSERT INTO `item_supplier` (`item_id`, `supplier_id`, `created_at`) VALUES ('12', '11', '2022-12-09 16:07:13');
INSERT INTO `item_supplier` (`item_id`, `supplier_id`, `created_at`) VALUES ('8', '11', '2022-12-09 16:07:13');
INSERT INTO `item_supplier` (`item_id`, `supplier_id`, `created_at`) VALUES ('3', '12', '2022-12-09 16:07:34');
INSERT INTO `item_supplier` (`item_id`, `supplier_id`, `created_at`) VALUES ('12', '12', '2022-12-09 16:07:34');


#
# TABLE STRUCTURE FOR: items
#

DROP TABLE IF EXISTS `items`;

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

INSERT INTO `items` (`id`, `name`, `code`, `description`, `unitPrice`, `quantity`, `dateAdded`, `lastUpdated`, `min`) VALUES ('2', 'champagne', 'HOH8JXRHUS', '', '1000.00', 10, '2021-02-01 10:28:39', '2021-02-01 10:28:39', 0);
INSERT INTO `items` (`id`, `name`, `code`, `description`, `unitPrice`, `quantity`, `dateAdded`, `lastUpdated`, `min`) VALUES ('3', 'Johnny Walker', 'JOH804N247', '', '50.00', 19, '2021-02-01 10:29:12', '2021-02-08 14:17:34', 0);
INSERT INTO `items` (`id`, `name`, `code`, `description`, `unitPrice`, `quantity`, `dateAdded`, `lastUpdated`, `min`) VALUES ('4', 'Jus Ceres', '9OELH9R80F', '', '5.00', 56, '2021-02-01 10:29:37', '2022-12-21 19:10:58', 0);
INSERT INTO `items` (`id`, `name`, `code`, `description`, `unitPrice`, `quantity`, `dateAdded`, `lastUpdated`, `min`) VALUES ('5', 'Heineken', '3HRRCAAAMN', '', '2.00', 37, '2021-02-01 10:29:50', '2021-02-16 15:53:41', 0);
INSERT INTO `items` (`id`, `name`, `code`, `description`, `unitPrice`, `quantity`, `dateAdded`, `lastUpdated`, `min`) VALUES ('7', 'Black Label', '960CU9YRGY', 'Red wine', '50.00', 25, '2021-02-01 10:30:26', '2022-12-09 15:35:37', 30);
INSERT INTO `items` (`id`, `name`, `code`, `description`, `unitPrice`, `quantity`, `dateAdded`, `lastUpdated`, `min`) VALUES ('8', 'Savanna', 'T7TX01D1W9', '', '2.00', 51, '2021-02-01 10:30:45', '2022-12-21 19:10:58', 0);
INSERT INTO `items` (`id`, `name`, `code`, `description`, `unitPrice`, `quantity`, `dateAdded`, `lastUpdated`, `min`) VALUES ('9', 'Hunters', 'FOGRLTPCHX', '', '2.00', 19, '2021-02-01 10:31:14', '2021-02-16 15:53:47', 0);
INSERT INTO `items` (`id`, `name`, `code`, `description`, `unitPrice`, `quantity`, `dateAdded`, `lastUpdated`, `min`) VALUES ('10', 'Cake', 'B4JF6E3PJE', '', '35.00', 25, '2021-02-15 15:36:51', '2021-02-15 15:36:51', 0);
INSERT INTO `items` (`id`, `name`, `code`, `description`, `unitPrice`, `quantity`, `dateAdded`, `lastUpdated`, `min`) VALUES ('12', 'Maziwa', 'XDE35T97YD', '', '10.00', 44, '2021-02-15 15:41:42', '2022-11-02 14:33:45', 0);


#
# TABLE STRUCTURE FOR: lk_sess
#

DROP TABLE IF EXISTS `lk_sess`;

CREATE TABLE `lk_sess` (
  `id` varchar(40) NOT NULL,
  `ip_address` varchar(45) NOT NULL,
  `timestamp` int(10) unsigned NOT NULL DEFAULT 0,
  `data` blob NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

#
# TABLE STRUCTURE FOR: lq_articles
#

DROP TABLE IF EXISTS `lq_articles`;

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

INSERT INTO `lq_articles` (`id_article`, `designation`, `prix_unitaire`, `prix_achat`, `devise`, `qte_initial`, `qte_actuelle`, `id_categorie`, `image_article`, `created_at`, `deleted`) VALUES (1, 'PINCE UNIVERSAIRE', '5', '3', 'USD', '25', '80', 6, 'IMG-20211115-WA0002.jpg', '2021-12-30 20:01:20', 'not');
INSERT INTO `lq_articles` (`id_article`, `designation`, `prix_unitaire`, `prix_achat`, `devise`, `qte_initial`, `qte_actuelle`, `id_categorie`, `image_article`, `created_at`, `deleted`) VALUES (2, 'Veste Daro Mars 2022', '100', '90', 'USD', '12', '8', 1, 'aea0e8cdd45d7a11b2caa1e1e95fe6f2.jpeg', '2022-06-22 14:01:36', 'not');
INSERT INTO `lq_articles` (`id_article`, `designation`, `prix_unitaire`, `prix_achat`, `devise`, `qte_initial`, `qte_actuelle`, `id_categorie`, `image_article`, `created_at`, `deleted`) VALUES (3, 'Toles', '65', '50', 'USD', '500', '367', 6, 'b5fa3a87488017f443530175285b8354.png', '2022-11-15 16:30:28', 'not');
INSERT INTO `lq_articles` (`id_article`, `designation`, `prix_unitaire`, `prix_achat`, `devise`, `qte_initial`, `qte_actuelle`, `id_categorie`, `image_article`, `created_at`, `deleted`) VALUES (4, 'Sac de ciment', '10', '16000', 'USD', '500', '500', 1, 'product_image.png', '2022-11-21 10:14:02', 'not');
INSERT INTO `lq_articles` (`id_article`, `designation`, `prix_unitaire`, `prix_achat`, `devise`, `qte_initial`, `qte_actuelle`, `id_categorie`, `image_article`, `created_at`, `deleted`) VALUES (5, 'Tole BG32', '15', '10500', 'USD', '800', '800', 1, 'product_image.png', '2022-11-21 10:17:33', 'not');
INSERT INTO `lq_articles` (`id_article`, `designation`, `prix_unitaire`, `prix_achat`, `devise`, `qte_initial`, `qte_actuelle`, `id_categorie`, `image_article`, `created_at`, `deleted`) VALUES (22, 'Sandales', '250', '200', 'USD', '258', '258', 9, 'IMG_20210411_155801412_BURST004.jpg', '2022-01-26 12:19:55', 'not');
INSERT INTO `lq_articles` (`id_article`, `designation`, `prix_unitaire`, `prix_achat`, `devise`, `qte_initial`, `qte_actuelle`, `id_categorie`, `image_article`, `created_at`, `deleted`) VALUES (33, 'CUVE', '35', '15', 'USD', '200', '200', 4, 'IMG-20211116-WA0017.jpg', '2022-01-28 07:09:56', 'not');


#
# TABLE STRUCTURE FOR: lq_categories
#

DROP TABLE IF EXISTS `lq_categories`;

CREATE TABLE `lq_categories` (
  `id_categorie` int(11) NOT NULL AUTO_INCREMENT,
  `nom_categorie` varchar(200) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `deleted` varchar(20) NOT NULL,
  PRIMARY KEY (`id_categorie`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

INSERT INTO `lq_categories` (`id_categorie`, `nom_categorie`, `created_at`, `deleted`) VALUES (1, 'Construction', '2020-10-21 15:18:13', 'not');
INSERT INTO `lq_categories` (`id_categorie`, `nom_categorie`, `created_at`, `deleted`) VALUES (2, 'Pieces de rechange', '2020-10-21 15:18:13', 'not');
INSERT INTO `lq_categories` (`id_categorie`, `nom_categorie`, `created_at`, `deleted`) VALUES (3, 'Divers', '2020-10-21 19:52:22', 'not');
INSERT INTO `lq_categories` (`id_categorie`, `nom_categorie`, `created_at`, `deleted`) VALUES (4, 'Electrogene', '2020-10-21 19:52:22', 'not');
INSERT INTO `lq_categories` (`id_categorie`, `nom_categorie`, `created_at`, `deleted`) VALUES (6, 'Autres', '2021-10-06 17:16:10', 'yes');
INSERT INTO `lq_categories` (`id_categorie`, `nom_categorie`, `created_at`, `deleted`) VALUES (7, 'Nouvelle catégorie', '2022-11-21 10:51:14', 'yes');
INSERT INTO `lq_categories` (`id_categorie`, `nom_categorie`, `created_at`, `deleted`) VALUES (8, 'Transport', '2022-11-21 11:46:33', 'not');


#
# TABLE STRUCTURE FOR: lq_factures
#

DROP TABLE IF EXISTS `lq_factures`;

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

INSERT INTO `lq_factures` (`id_facture`, `id_article`, `qte_achetee`, `subtotal`, `remise`, `fact_token`, `client_token`, `date_facture`, `product_tva`, `prix_vente`, `prix_unitaire`, `prix_achat`, `client_name`, `usd_amount`, `cdf_amount`, `is_cash`, `is_canceled`) VALUES (1, 3, '10', '650', '10', '47155', '62318', '2022-11-17', 0, '65', '65', '50', 'Erick Banze', '135', '10000', '1', '0');
INSERT INTO `lq_factures` (`id_facture`, `id_article`, `qte_achetee`, `subtotal`, `remise`, `fact_token`, `client_token`, `date_facture`, `product_tva`, `prix_vente`, `prix_unitaire`, `prix_achat`, `client_name`, `usd_amount`, `cdf_amount`, `is_cash`, `is_canceled`) VALUES (2, 2, '5', '500', '10', '47155', '62318', '2022-11-17', 0, '100', '100', '90', 'Erick Banze', '135', '10000', '1', '0');
INSERT INTO `lq_factures` (`id_facture`, `id_article`, `qte_achetee`, `subtotal`, `remise`, `fact_token`, `client_token`, `date_facture`, `product_tva`, `prix_vente`, `prix_unitaire`, `prix_achat`, `client_name`, `usd_amount`, `cdf_amount`, `is_cash`, `is_canceled`) VALUES (3, 2, '2', '200', '0', '55873', '86371', '2022-11-17', 0, '100', '100', '90', 'Kasongo Banze', '330', '0', '1', '0');
INSERT INTO `lq_factures` (`id_facture`, `id_article`, `qte_achetee`, `subtotal`, `remise`, `fact_token`, `client_token`, `date_facture`, `product_tva`, `prix_vente`, `prix_unitaire`, `prix_achat`, `client_name`, `usd_amount`, `cdf_amount`, `is_cash`, `is_canceled`) VALUES (4, 3, '2', '130', '0', '55873', '86371', '2022-11-17', 0, '65', '65', '50', 'Kasongo Banze', '330', '0', '1', '0');
INSERT INTO `lq_factures` (`id_facture`, `id_article`, `qte_achetee`, `subtotal`, `remise`, `fact_token`, `client_token`, `date_facture`, `product_tva`, `prix_vente`, `prix_unitaire`, `prix_achat`, `client_name`, `usd_amount`, `cdf_amount`, `is_cash`, `is_canceled`) VALUES (5, 3, '1', '65', '5', '56948', '26175', '2022-11-18', 0, '65', '65', '50', 'Nyembo', '260', '0', '1', '0');
INSERT INTO `lq_factures` (`id_facture`, `id_article`, `qte_achetee`, `subtotal`, `remise`, `fact_token`, `client_token`, `date_facture`, `product_tva`, `prix_vente`, `prix_unitaire`, `prix_achat`, `client_name`, `usd_amount`, `cdf_amount`, `is_cash`, `is_canceled`) VALUES (6, 2, '2', '200', '5', '56948', '26175', '2022-11-18', 0, '100', '100', '90', 'Nyembo', '260', '0', '1', '0');
INSERT INTO `lq_factures` (`id_facture`, `id_article`, `qte_achetee`, `subtotal`, `remise`, `fact_token`, `client_token`, `date_facture`, `product_tva`, `prix_vente`, `prix_unitaire`, `prix_achat`, `client_name`, `usd_amount`, `cdf_amount`, `is_cash`, `is_canceled`) VALUES (7, 3, '12', '780', '10', '77632', '83584', '2022-11-18', 0, '65', '65', '50', 'Kasongo', '770', '0', '1', '0');
INSERT INTO `lq_factures` (`id_facture`, `id_article`, `qte_achetee`, `subtotal`, `remise`, `fact_token`, `client_token`, `date_facture`, `product_tva`, `prix_vente`, `prix_unitaire`, `prix_achat`, `client_name`, `usd_amount`, `cdf_amount`, `is_cash`, `is_canceled`) VALUES (8, 5, '10', '150', '0', '96259', '57587', '2022-11-21', 0, '15', '15', '10500', 'Jeanclaude', '140', '20000', '1', '1');


#
# TABLE STRUCTURE FOR: lq_quantites_entree
#

DROP TABLE IF EXISTS `lq_quantites_entree`;

CREATE TABLE `lq_quantites_entree` (
  `id_qte` int(11) NOT NULL AUTO_INCREMENT,
  `key_entree` varchar(50) DEFAULT NULL,
  `qte_restante` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id_qte`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

INSERT INTO `lq_quantites_entree` (`id_qte`, `key_entree`, `qte_restante`) VALUES (1, '0', '0');


#
# TABLE STRUCTURE FOR: lq_quantites_sortie
#

DROP TABLE IF EXISTS `lq_quantites_sortie`;

CREATE TABLE `lq_quantites_sortie` (
  `id_qte` int(11) NOT NULL AUTO_INCREMENT,
  `key_sortie` varchar(50) DEFAULT NULL,
  `qte_restante` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id_qte`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

INSERT INTO `lq_quantites_sortie` (`id_qte`, `key_sortie`, `qte_restante`) VALUES (1, '0', '0');


#
# TABLE STRUCTURE FOR: lq_reappro
#

DROP TABLE IF EXISTS `lq_reappro`;

CREATE TABLE `lq_reappro` (
  `id_reappro` int(11) NOT NULL AUTO_INCREMENT,
  `id_article` int(11) NOT NULL,
  `date_reappro` date NOT NULL,
  `qte_reappro` int(11) NOT NULL,
  `nom_fournisseur` varchar(250) NOT NULL,
  `key_entree` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id_reappro`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

INSERT INTO `lq_reappro` (`id_reappro`, `id_article`, `date_reappro`, `qte_reappro`, `nom_fournisseur`, `key_entree`) VALUES (1, 3, '2022-11-15', 100, 'JC', '7514876');


#
# TABLE STRUCTURE FOR: lq_retrieves
#

DROP TABLE IF EXISTS `lq_retrieves`;

CREATE TABLE `lq_retrieves` (
  `id_retrieve` int(11) NOT NULL AUTO_INCREMENT,
  `preview_amount` double NOT NULL DEFAULT 0,
  `retrieve_amount` double NOT NULL DEFAULT 0,
  `current_amount` double NOT NULL DEFAULT 0,
  `motif` text NOT NULL,
  `retrieve_date` date DEFAULT NULL,
  PRIMARY KEY (`id_retrieve`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

#
# TABLE STRUCTURE FOR: lq_shops
#

DROP TABLE IF EXISTS `lq_shops`;

CREATE TABLE `lq_shops` (
  `shop_id` int(11) NOT NULL AUTO_INCREMENT,
  `shop_name` varchar(50) DEFAULT NULL,
  `shop_created_at` datetime DEFAULT NULL,
  PRIMARY KEY (`shop_id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

INSERT INTO `lq_shops` (`shop_id`, `shop_name`, `shop_created_at`) VALUES (1, 'Kipushi', '2022-11-18 09:57:52');
INSERT INTO `lq_shops` (`shop_id`, `shop_name`, `shop_created_at`) VALUES (2, 'Lubumbashi', '2022-11-18 09:58:01');
INSERT INTO `lq_shops` (`shop_id`, `shop_name`, `shop_created_at`) VALUES (3, 'Kolwezi', NULL);
INSERT INTO `lq_shops` (`shop_id`, `shop_name`, `shop_created_at`) VALUES (4, 'Kamina', NULL);


#
# TABLE STRUCTURE FOR: lq_soldes
#

DROP TABLE IF EXISTS `lq_soldes`;

CREATE TABLE `lq_soldes` (
  `id_solde` int(11) NOT NULL AUTO_INCREMENT,
  `date_solde` datetime NOT NULL DEFAULT current_timestamp(),
  `montant_entree` double NOT NULL,
  `cdf_amount` double DEFAULT NULL,
  `usd_amount` double DEFAULT NULL,
  PRIMARY KEY (`id_solde`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

INSERT INTO `lq_soldes` (`id_solde`, `date_solde`, `montant_entree`, `cdf_amount`, `usd_amount`) VALUES (1, '2022-11-21 11:40:54', '140', '20000', '140');


#
# TABLE STRUCTURE FOR: lq_sorties
#

DROP TABLE IF EXISTS `lq_sorties`;

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

INSERT INTO `lq_sorties` (`id_sortie`, `id_article`, `qte_sortie`, `date_sortie`, `motif_sortie`, `key_sortie`, `shop_id`) VALUES (1, 3, '200', '2022-11-15', 'Ventes', '6023045', NULL);


#
# TABLE STRUCTURE FOR: lq_users
#

DROP TABLE IF EXISTS `lq_users`;

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

INSERT INTO `lq_users` (`id`, `password`, `role_utilisateur`, `shop_id`, `user_name`, `statut`, `user_image`) VALUES (1, '$2y$10$caYW1Uo4QsbJBiUN/HeqEu36x6TrM2vS6ok8u/dnICBwtUj2t8fJy', 'admin', 1, 'Erick', 'online', 'noimage_user.png');


#
# TABLE STRUCTURE FOR: suppliers
#

DROP TABLE IF EXISTS `suppliers`;

CREATE TABLE `suppliers` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `address` varchar(255) DEFAULT NULL,
  `phone_number` varchar(20) NOT NULL,
  `email` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `suppliers` (`id`, `name`, `address`, `phone_number`, `email`) VALUES ('10', 'Tyler Wallace', 'Ad quia sed quas ass', '+1 (996) 395-3586', 'sorujit@mailinator.com');
INSERT INTO `suppliers` (`id`, `name`, `address`, `phone_number`, `email`) VALUES ('11', 'Libby Haley', 'Veniam id eum ea mo', '+1 (372) 746-1592', 'rujutokys@mailinator.com');
INSERT INTO `suppliers` (`id`, `name`, `address`, `phone_number`, `email`) VALUES ('12', 'Whoopi Reed', 'Autem est ea aut sim', '+1 (576) 758-6656', 'tufiruduf@mailinator.com');
INSERT INTO `suppliers` (`id`, `name`, `address`, `phone_number`, `email`) VALUES ('13', '7', '', '11', '50');


#
# TABLE STRUCTURE FOR: transactions
#

DROP TABLE IF EXISTS `transactions`;

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
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

INSERT INTO `transactions` (`transId`, `ref`, `itemName`, `itemCode`, `description`, `quantity`, `unitPrice`, `totalPrice`, `totalMoneySpent`, `amountTendered`, `discount_amount`, `discount_percentage`, `vatPercentage`, `vatAmount`, `changeDue`, `modeOfPayment`, `cust_name`, `cust_phone`, `cust_email`, `transType`, `staffId`, `transDate`, `lastUpdated`, `cancelled`, `pos`, `cash`) VALUES ('1', '57129302', 'Heineken', '3HRRCAAAMN', '', 3, '2.75', '8.25', '8.25', '10.00', '0.00', '0.00', '0.00', '0.00', '1.75', 'Cash', '', '', '', '1', '1', '2021-02-01 10:33:36', '2021-02-01 10:33:36', '0', NULL, NULL);
INSERT INTO `transactions` (`transId`, `ref`, `itemName`, `itemCode`, `description`, `quantity`, `unitPrice`, `totalPrice`, `totalMoneySpent`, `amountTendered`, `discount_amount`, `discount_percentage`, `vatPercentage`, `vatAmount`, `changeDue`, `modeOfPayment`, `cust_name`, `cust_phone`, `cust_email`, `transType`, `staffId`, `transDate`, `lastUpdated`, `cancelled`, `pos`, `cash`) VALUES ('2', '12901827', 'Savanna', 'T7TX01D1W9', '', 2, '2.75', '5.50', '5.50', '10.00', '0.00', '0.00', '0.00', '0.00', '4.50', 'Cash', 'Roland Wabubindja Tu', '', '', '1', '1', '2021-02-01 14:09:35', '2021-02-01 14:09:35', '0', NULL, NULL);
INSERT INTO `transactions` (`transId`, `ref`, `itemName`, `itemCode`, `description`, `quantity`, `unitPrice`, `totalPrice`, `totalMoneySpent`, `amountTendered`, `discount_amount`, `discount_percentage`, `vatPercentage`, `vatAmount`, `changeDue`, `modeOfPayment`, `cust_name`, `cust_phone`, `cust_email`, `transType`, `staffId`, `transDate`, `lastUpdated`, `cancelled`, `pos`, `cash`) VALUES ('3', '17698160', 'Jus Ceres', '9OELH9R80F', '', 1, '5.00', '5.00', '55.00', '100.00', '0.00', '0.00', '0.00', '0.00', '45.00', 'Cash', 'Roben', '+243991551044', '', '1', '1', '2021-02-01 14:23:50', '2021-02-01 14:23:50', '0', NULL, NULL);
INSERT INTO `transactions` (`transId`, `ref`, `itemName`, `itemCode`, `description`, `quantity`, `unitPrice`, `totalPrice`, `totalMoneySpent`, `amountTendered`, `discount_amount`, `discount_percentage`, `vatPercentage`, `vatAmount`, `changeDue`, `modeOfPayment`, `cust_name`, `cust_phone`, `cust_email`, `transType`, `staffId`, `transDate`, `lastUpdated`, `cancelled`, `pos`, `cash`) VALUES ('5', '019632820', 'Black Label', '960CU9YRGY', '', 1, '50.00', '50.00', '50.00', '100.00', '0.00', '0.00', '0.00', '0.00', '50.00', 'Cash', '', '', '', '1', '1', '2021-02-08 14:14:40', '2021-02-08 14:14:40', '0', NULL, NULL);
INSERT INTO `transactions` (`transId`, `ref`, `itemName`, `itemCode`, `description`, `quantity`, `unitPrice`, `totalPrice`, `totalMoneySpent`, `amountTendered`, `discount_amount`, `discount_percentage`, `vatPercentage`, `vatAmount`, `changeDue`, `modeOfPayment`, `cust_name`, `cust_phone`, `cust_email`, `transType`, `staffId`, `transDate`, `lastUpdated`, `cancelled`, `pos`, `cash`) VALUES ('6', '4921870', 'Johnny Walker', 'JOH804N247', '', 1, '50.00', '50.00', '50.00', '50.00', '0.00', '0.00', '0.00', '0.00', '0.00', 'Cash and POS', '', '', '', '1', '1', '2021-02-08 14:17:34', '2021-02-08 14:17:34', '0', NULL, NULL);
INSERT INTO `transactions` (`transId`, `ref`, `itemName`, `itemCode`, `description`, `quantity`, `unitPrice`, `totalPrice`, `totalMoneySpent`, `amountTendered`, `discount_amount`, `discount_percentage`, `vatPercentage`, `vatAmount`, `changeDue`, `modeOfPayment`, `cust_name`, `cust_phone`, `cust_email`, `transType`, `staffId`, `transDate`, `lastUpdated`, `cancelled`, `pos`, `cash`) VALUES ('7', '77059481', 'Jus Ceres', '9OELH9R80F', '', 1, '5.00', '5.00', '57.75', '100.00', '0.00', '0.00', '0.00', '0.00', '42.25', 'Cash', '', '', '', '1', '1', '2021-02-10 10:10:32', '2021-02-10 10:10:32', '0', NULL, NULL);
INSERT INTO `transactions` (`transId`, `ref`, `itemName`, `itemCode`, `description`, `quantity`, `unitPrice`, `totalPrice`, `totalMoneySpent`, `amountTendered`, `discount_amount`, `discount_percentage`, `vatPercentage`, `vatAmount`, `changeDue`, `modeOfPayment`, `cust_name`, `cust_phone`, `cust_email`, `transType`, `staffId`, `transDate`, `lastUpdated`, `cancelled`, `pos`, `cash`) VALUES ('8', '77059481', 'Hunters', 'FOGRLTPCHX', '', 1, '2.75', '2.75', '57.75', '100.00', '0.00', '0.00', '0.00', '0.00', '42.25', 'Cash', '', '', '', '1', '1', '2021-02-10 10:10:32', '2021-02-10 10:10:32', '0', NULL, NULL);
INSERT INTO `transactions` (`transId`, `ref`, `itemName`, `itemCode`, `description`, `quantity`, `unitPrice`, `totalPrice`, `totalMoneySpent`, `amountTendered`, `discount_amount`, `discount_percentage`, `vatPercentage`, `vatAmount`, `changeDue`, `modeOfPayment`, `cust_name`, `cust_phone`, `cust_email`, `transType`, `staffId`, `transDate`, `lastUpdated`, `cancelled`, `pos`, `cash`) VALUES ('9', '77059481', 'Black Label', '960CU9YRGY', '', 1, '50.00', '50.00', '57.75', '100.00', '0.00', '0.00', '0.00', '0.00', '42.25', 'Cash', '', '', '', '1', '1', '2021-02-10 10:10:32', '2021-02-10 10:10:32', '0', NULL, NULL);
INSERT INTO `transactions` (`transId`, `ref`, `itemName`, `itemCode`, `description`, `quantity`, `unitPrice`, `totalPrice`, `totalMoneySpent`, `amountTendered`, `discount_amount`, `discount_percentage`, `vatPercentage`, `vatAmount`, `changeDue`, `modeOfPayment`, `cust_name`, `cust_phone`, `cust_email`, `transType`, `staffId`, `transDate`, `lastUpdated`, `cancelled`, `pos`, `cash`) VALUES ('10', '5072083', 'Maziwa', 'XDE35T97YD', '', 1, '10.00', '10.00', '10.00', '10.00', '0.00', '0.00', '0.00', '0.00', '0.00', 'POS', '', '', '', '1', '1', '2022-11-02 14:33:45', '2022-11-02 14:33:45', '0', 10, 0);
INSERT INTO `transactions` (`transId`, `ref`, `itemName`, `itemCode`, `description`, `quantity`, `unitPrice`, `totalPrice`, `totalMoneySpent`, `amountTendered`, `discount_amount`, `discount_percentage`, `vatPercentage`, `vatAmount`, `changeDue`, `modeOfPayment`, `cust_name`, `cust_phone`, `cust_email`, `transType`, `staffId`, `transDate`, `lastUpdated`, `cancelled`, `pos`, `cash`) VALUES ('11', '04639741', 'Savanna', 'T7TX01D1W9', '', 1, '2.00', '2.00', '2.00', '10.00', '0.00', '0.00', '0.00', '0.00', '8.00', 'Cash', '', '', '', '1', '1', '2022-11-02 14:34:27', '2022-11-02 14:34:27', '0', 0, 2);
INSERT INTO `transactions` (`transId`, `ref`, `itemName`, `itemCode`, `description`, `quantity`, `unitPrice`, `totalPrice`, `totalMoneySpent`, `amountTendered`, `discount_amount`, `discount_percentage`, `vatPercentage`, `vatAmount`, `changeDue`, `modeOfPayment`, `cust_name`, `cust_phone`, `cust_email`, `transType`, `staffId`, `transDate`, `lastUpdated`, `cancelled`, `pos`, `cash`) VALUES ('12', '403186', 'Jus Ceres', '9OELH9R80F', '', 1, '5.00', '5.00', '5.00', '5.00', '0.00', '0.00', '0.00', '0.00', '0.00', 'Cash and POS', '', '', '', '1', '1', '2022-11-02 14:35:02', '2022-11-02 14:35:02', '0', 3, 2);
INSERT INTO `transactions` (`transId`, `ref`, `itemName`, `itemCode`, `description`, `quantity`, `unitPrice`, `totalPrice`, `totalMoneySpent`, `amountTendered`, `discount_amount`, `discount_percentage`, `vatPercentage`, `vatAmount`, `changeDue`, `modeOfPayment`, `cust_name`, `cust_phone`, `cust_email`, `transType`, `staffId`, `transDate`, `lastUpdated`, `cancelled`, `pos`, `cash`) VALUES ('13', '68201975', 'Savanna', 'T7TX01D1W9', '', 1, '2.00', '2.00', '2.00', '5.00', '0.00', '0.00', '0.00', '0.00', '3.00', 'Cash', 'gfhh', 'ikyuk', 'thsrthtr@de.fr', '1', '1', '2022-12-08 10:12:43', '2022-12-08 10:12:43', '0', 0, 2);
INSERT INTO `transactions` (`transId`, `ref`, `itemName`, `itemCode`, `description`, `quantity`, `unitPrice`, `totalPrice`, `totalMoneySpent`, `amountTendered`, `discount_amount`, `discount_percentage`, `vatPercentage`, `vatAmount`, `changeDue`, `modeOfPayment`, `cust_name`, `cust_phone`, `cust_email`, `transType`, `staffId`, `transDate`, `lastUpdated`, `cancelled`, `pos`, `cash`) VALUES ('14', '247869', 'Savanna', 'T7TX01D1W9', '', 1, '2.00', '2.00', '7.00', '10.00', '0.00', '0.00', '0.00', '0.00', '3.00', 'Cash', '', '', '', '1', '1', '2022-12-21 19:10:58', '2022-12-21 19:10:58', '0', 0, 7);
INSERT INTO `transactions` (`transId`, `ref`, `itemName`, `itemCode`, `description`, `quantity`, `unitPrice`, `totalPrice`, `totalMoneySpent`, `amountTendered`, `discount_amount`, `discount_percentage`, `vatPercentage`, `vatAmount`, `changeDue`, `modeOfPayment`, `cust_name`, `cust_phone`, `cust_email`, `transType`, `staffId`, `transDate`, `lastUpdated`, `cancelled`, `pos`, `cash`) VALUES ('15', '247869', 'Jus Ceres', '9OELH9R80F', '', 1, '5.00', '5.00', '7.00', '10.00', '0.00', '0.00', '0.00', '0.00', '3.00', 'Cash', '', '', '', '1', '1', '2022-12-21 19:10:58', '2022-12-21 19:10:58', '0', 0, 7);


