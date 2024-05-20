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


