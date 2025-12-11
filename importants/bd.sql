-- phpMyAdmin SQL Dump
-- version 4.9.1
-- https://www.phpmyadmin.net/
--
-- Hôte : localhost:3306
-- Généré le :  lun. 11 nov. 2019 à 15:42
-- Version du serveur :  5.7.24
-- Version de PHP :  7.2.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `maxpow895_db`
--

-- --------------------------------------------------------

--
-- Structure de la table `boutiques`
--

CREATE TABLE `boutiques` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nom` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `localisation` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `slogan` text COLLATE utf8mb4_unicode_ci,
  `adresse` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `telephone_1` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `telephone_2` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `latitude` double(8,2) DEFAULT NULL,
  `longitude` double(8,2) DEFAULT NULL,
  `logo` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `numero_rc` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `boite_postale` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `fax` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `boutique_boutiques`
--

CREATE TABLE `boutique_boutiques` (
  `boutique` bigint(20) UNSIGNED DEFAULT NULL,
  `boutique_id` bigint(20) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `boutique_historiques`
--

CREATE TABLE `boutique_historiques` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `boutique_jour_id` bigint(20) UNSIGNED DEFAULT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `boutique_id` bigint(20) UNSIGNED DEFAULT NULL,
  `entite` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `boutique_jours`
--

CREATE TABLE `boutique_jours` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `boutique_id` bigint(20) UNSIGNED DEFAULT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `actif` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `boutique_stocks`
--

CREATE TABLE `boutique_stocks` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `produit_id` bigint(20) UNSIGNED DEFAULT NULL,
  `boutique_id` bigint(20) UNSIGNED DEFAULT NULL,
  `initial` bigint(20) UNSIGNED DEFAULT NULL,
  `valeur` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `categories`
--

CREATE TABLE `categories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nom` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `charge_boutiques`
--

CREATE TABLE `charge_boutiques` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `boutique_jour_id` bigint(20) UNSIGNED DEFAULT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `boutique_id` bigint(20) UNSIGNED DEFAULT NULL,
  `montant` decimal(18,2) DEFAULT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `dette_boutiques`
--

CREATE TABLE `dette_boutiques` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `boutique_jour_id` bigint(20) UNSIGNED DEFAULT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `boutique_id` bigint(20) UNSIGNED DEFAULT NULL,
  `partenaire` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `montant` decimal(18,2) DEFAULT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `entree_magasins`
--

CREATE TABLE `entree_magasins` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `magasin_jour_id` bigint(20) UNSIGNED DEFAULT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `magasin_id` bigint(20) UNSIGNED DEFAULT NULL,
  `magasin_stock_id` bigint(20) UNSIGNED DEFAULT NULL,
  `quantite` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `facture_boutiques`
--

CREATE TABLE `facture_boutiques` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nom` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `client` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `numero` double(8,2) DEFAULT NULL,
  `boutique_id` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `historiques`
--

CREATE TABLE `historiques` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `type` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `action` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `entite` varchar(150) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `message` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `vu` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `magasins`
--

CREATE TABLE `magasins` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nom` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `localisation` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `slogan` text COLLATE utf8mb4_unicode_ci,
  `adresse` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `magasin_boutiques`
--

CREATE TABLE `magasin_boutiques` (
  `magasin_id` bigint(20) UNSIGNED DEFAULT NULL,
  `boutique_id` bigint(20) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `magasin_historiques`
--

CREATE TABLE `magasin_historiques` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `magasin_jour_id` bigint(20) UNSIGNED DEFAULT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `magasin_id` bigint(20) UNSIGNED DEFAULT NULL,
  `entite` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `magasin_jours`
--

CREATE TABLE `magasin_jours` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `magasin_id` bigint(20) UNSIGNED DEFAULT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `actif` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `magasin_magasins`
--

CREATE TABLE `magasin_magasins` (
  `magasin` bigint(20) UNSIGNED DEFAULT NULL,
  `magasin_id` bigint(20) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `magasin_stocks`
--

CREATE TABLE `magasin_stocks` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `produit_id` bigint(20) UNSIGNED DEFAULT NULL,
  `magasin_id` bigint(20) UNSIGNED DEFAULT NULL,
  `initial` bigint(20) UNSIGNED DEFAULT NULL,
  `valeur` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `messages`
--

CREATE TABLE `messages` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `expediteur` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `recepteur` int(10) UNSIGNED DEFAULT NULL,
  `contenu` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `vu` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(65, '2014_10_12_000000_create_users_table', 1),
(66, '2014_10_12_100000_create_password_resets_table', 1),
(67, '2019_08_10_090255_create_permission_tables', 1),
(68, '2019_08_17_114139_create_boutiques_table', 1),
(69, '2019_08_17_114745_create_user_boutiques_table', 1),
(70, '2019_08_18_030643_create_messages_table', 1),
(71, '2019_08_18_032714_create_historiques_table', 1),
(72, '2019_08_18_154208_create_magasins_table', 1),
(73, '2019_08_18_155120_create_magasin_boutiques_table', 1),
(74, '2019_08_18_171248_create_user_magasins_table', 1),
(75, '2019_08_19_011807_create_categories_table', 1),
(76, '2019_08_19_024345_create_produits_table', 1),
(77, '2019_08_19_065058_create_boutique_stocks_table', 1),
(78, '2019_08_19_065130_create_magasin_stocks_table', 1),
(79, '2019_08_20_171749_create_boutique_jours_table', 1),
(80, '2019_08_20_171848_create_magasin_jours_table', 1),
(81, '2019_08_25_010013_create_boutique_boutiques_table', 1),
(82, '2019_08_25_010437_create_magasin_magasins_table', 1),
(83, '2019_08_25_073630_create_magasin_historiques_table', 1),
(84, '2019_08_25_073718_create_boutique_historiques_table', 1),
(85, '2019_08_26_052343_create_sortie_magasin_boutiques_table', 1),
(86, '2019_08_26_052440_create_sortie_magasin_magasins_table', 1),
(87, '2019_08_26_052803_create_sortie_boutique_magasins_table', 1),
(88, '2019_08_31_061240_create_entree_magasins_table', 1),
(89, '2019_09_04_151918_create_facture_boutiques_table', 1),
(90, '2019_09_04_153115_create_vente_boutiques_table', 1),
(91, '2019_09_04_222333_create_charge_boutiques_table', 1),
(92, '2019_09_04_222506_create_tontine_boutiques_table', 1),
(93, '2019_09_04_222544_create_versement_boutiques_table', 1),
(94, '2019_09_04_222905_create_dette_boutiques_table', 1),
(95, '2019_09_18_060748_create_solde_boutiques_table', 1),
(96, '2019_10_02_063752_create_versement_dettes_table', 1);

-- --------------------------------------------------------

--
-- Structure de la table `model_has_permissions`
--

CREATE TABLE `model_has_permissions` (
  `permission_id` int(10) UNSIGNED NOT NULL,
  `model_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `model_has_roles`
--

CREATE TABLE `model_has_roles` (
  `role_id` int(10) UNSIGNED NOT NULL,
  `model_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `model_has_roles`
--

INSERT INTO `model_has_roles` (`role_id`, `model_type`, `model_id`) VALUES
(1, 'App\\User', 1);

-- --------------------------------------------------------

--
-- Structure de la table `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `permissions`
--

CREATE TABLE `permissions` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `guard_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `permissions`
--

INSERT INTO `permissions` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES
(1, 'voir-administration', 'web', '2019-11-11 14:35:41', '2019-11-11 14:35:41'),
(2, 'role-list', 'web', '2019-11-11 14:35:41', '2019-11-11 14:35:41'),
(3, 'role-create', 'web', '2019-11-11 14:35:41', '2019-11-11 14:35:41'),
(4, 'role-edit', 'web', '2019-11-11 14:35:41', '2019-11-11 14:35:41'),
(5, 'role-delete', 'web', '2019-11-11 14:35:41', '2019-11-11 14:35:41'),
(6, 'user-list', 'web', '2019-11-11 14:35:41', '2019-11-11 14:35:41'),
(7, 'user-create', 'web', '2019-11-11 14:35:41', '2019-11-11 14:35:41'),
(8, 'user-edit', 'web', '2019-11-11 14:35:41', '2019-11-11 14:35:41'),
(9, 'user-delete', 'web', '2019-11-11 14:35:41', '2019-11-11 14:35:41'),
(10, 'boutique-list', 'web', '2019-11-11 14:35:41', '2019-11-11 14:35:41'),
(11, 'boutique-create', 'web', '2019-11-11 14:35:41', '2019-11-11 14:35:41'),
(12, 'boutique-edit', 'web', '2019-11-11 14:35:41', '2019-11-11 14:35:41'),
(13, 'boutique-delete', 'web', '2019-11-11 14:35:41', '2019-11-11 14:35:41'),
(14, 'magasin-list', 'web', '2019-11-11 14:35:41', '2019-11-11 14:35:41'),
(15, 'magasin-create', 'web', '2019-11-11 14:35:41', '2019-11-11 14:35:41'),
(16, 'magasin-edit', 'web', '2019-11-11 14:35:41', '2019-11-11 14:35:41'),
(17, 'magasin-delete', 'web', '2019-11-11 14:35:42', '2019-11-11 14:35:42'),
(18, 'categorie-list', 'web', '2019-11-11 14:35:42', '2019-11-11 14:35:42'),
(19, 'categorie-create', 'web', '2019-11-11 14:35:42', '2019-11-11 14:35:42'),
(20, 'categorie-edit', 'web', '2019-11-11 14:35:42', '2019-11-11 14:35:42'),
(21, 'categorie-delete', 'web', '2019-11-11 14:35:42', '2019-11-11 14:35:42'),
(22, 'produit-list', 'web', '2019-11-11 14:35:42', '2019-11-11 14:35:42'),
(23, 'produit-create', 'web', '2019-11-11 14:35:42', '2019-11-11 14:35:42'),
(24, 'produit-edit', 'web', '2019-11-11 14:35:42', '2019-11-11 14:35:42'),
(25, 'produit-delete', 'web', '2019-11-11 14:35:42', '2019-11-11 14:35:42'),
(26, 'magasin-jour-list', 'web', '2019-11-11 14:35:42', '2019-11-11 14:35:42'),
(27, 'magasin-jour-create', 'web', '2019-11-11 14:35:42', '2019-11-11 14:35:42'),
(28, 'magasin-jour-edit', 'web', '2019-11-11 14:35:42', '2019-11-11 14:35:42'),
(29, 'magasin-jour-delete', 'web', '2019-11-11 14:35:42', '2019-11-11 14:35:42'),
(30, 'magasin-jour-close', 'web', '2019-11-11 14:35:42', '2019-11-11 14:35:42'),
(31, 'magasin-jour-open', 'web', '2019-11-11 14:35:42', '2019-11-11 14:35:42'),
(32, 'boutique-jour-list', 'web', '2019-11-11 14:35:42', '2019-11-11 14:35:42'),
(33, 'boutique-jour-create', 'web', '2019-11-11 14:35:42', '2019-11-11 14:35:42'),
(34, 'boutique-jour-edit', 'web', '2019-11-11 14:35:42', '2019-11-11 14:35:42'),
(35, 'boutique-jour-delete', 'web', '2019-11-11 14:35:42', '2019-11-11 14:35:42'),
(36, 'vente-boutique-list', 'web', '2019-11-11 14:35:42', '2019-11-11 14:35:42'),
(37, 'vente-boutique-create', 'web', '2019-11-11 14:35:42', '2019-11-11 14:35:42'),
(38, 'vente-boutique-edit', 'web', '2019-11-11 14:35:42', '2019-11-11 14:35:42'),
(39, 'vente-boutique-delete', 'web', '2019-11-11 14:35:42', '2019-11-11 14:35:42'),
(40, 'solde-boutique-list', 'web', '2019-11-11 14:35:42', '2019-11-11 14:35:42'),
(41, 'solde-boutique-create', 'web', '2019-11-11 14:35:42', '2019-11-11 14:35:42'),
(42, 'solde-boutique-edit', 'web', '2019-11-11 14:35:42', '2019-11-11 14:35:42'),
(43, 'solde-boutique-delete', 'web', '2019-11-11 14:35:42', '2019-11-11 14:35:42'),
(44, 'charge-boutique-list', 'web', '2019-11-11 14:35:42', '2019-11-11 14:35:42'),
(45, 'charge-boutique-create', 'web', '2019-11-11 14:35:42', '2019-11-11 14:35:42'),
(46, 'charge-boutique-edit', 'web', '2019-11-11 14:35:42', '2019-11-11 14:35:42'),
(47, 'charge-boutique-delete', 'web', '2019-11-11 14:35:42', '2019-11-11 14:35:42'),
(48, 'tontine-boutique-list', 'web', '2019-11-11 14:35:42', '2019-11-11 14:35:42'),
(49, 'tontine-boutique-create', 'web', '2019-11-11 14:35:42', '2019-11-11 14:35:42'),
(50, 'tontine-boutique-edit', 'web', '2019-11-11 14:35:42', '2019-11-11 14:35:42'),
(51, 'tontine-boutique-delete', 'web', '2019-11-11 14:35:42', '2019-11-11 14:35:42'),
(52, 'versement-boutique-list', 'web', '2019-11-11 14:35:42', '2019-11-11 14:35:42'),
(53, 'versement-boutique-create', 'web', '2019-11-11 14:35:42', '2019-11-11 14:35:42'),
(54, 'versement-boutique-edit', 'web', '2019-11-11 14:35:42', '2019-11-11 14:35:42'),
(55, 'versement-boutique-delete', 'web', '2019-11-11 14:35:42', '2019-11-11 14:35:42'),
(56, 'dette-boutique-list', 'web', '2019-11-11 14:35:42', '2019-11-11 14:35:42'),
(57, 'dette-boutique-create', 'web', '2019-11-11 14:35:42', '2019-11-11 14:35:42'),
(58, 'dette-boutique-edit', 'web', '2019-11-11 14:35:42', '2019-11-11 14:35:42'),
(59, 'dette-boutique-delete', 'web', '2019-11-11 14:35:42', '2019-11-11 14:35:42'),
(60, 'boutique-magasin-sortie-list', 'web', '2019-11-11 14:35:42', '2019-11-11 14:35:42'),
(61, 'boutique-magasin-sortie-create', 'web', '2019-11-11 14:35:42', '2019-11-11 14:35:42'),
(62, 'boutique-magasin-sortie-edit', 'web', '2019-11-11 14:35:42', '2019-11-11 14:35:42'),
(63, 'boutique-magasin-sortie-delete', 'web', '2019-11-11 14:35:42', '2019-11-11 14:35:42'),
(64, 'boutique-comptabilite', 'web', '2019-11-11 14:35:43', '2019-11-11 14:35:43'),
(65, 'magasin-comptabilite', 'web', '2019-11-11 14:35:43', '2019-11-11 14:35:43'),
(66, 'magasin-entree-list', 'web', '2019-11-11 14:35:43', '2019-11-11 14:35:43'),
(67, 'magasin-entree-create', 'web', '2019-11-11 14:35:43', '2019-11-11 14:35:43'),
(68, 'magasin-entree-edit', 'web', '2019-11-11 14:35:43', '2019-11-11 14:35:43'),
(69, 'magasin-entree-delete', 'web', '2019-11-11 14:35:43', '2019-11-11 14:35:43'),
(70, 'magasin-stocks-list', 'web', '2019-11-11 14:35:43', '2019-11-11 14:35:43'),
(71, 'magasin-historiques-list', 'web', '2019-11-11 14:35:43', '2019-11-11 14:35:43'),
(72, 'boutique-historiques-list', 'web', '2019-11-11 14:35:43', '2019-11-11 14:35:43'),
(73, 'boutique-stocks-list', 'web', '2019-11-11 14:35:43', '2019-11-11 14:35:43'),
(74, 'boutique-jour-close', 'web', '2019-11-11 14:35:43', '2019-11-11 14:35:43'),
(75, 'boutique-jour-open', 'web', '2019-11-11 14:35:43', '2019-11-11 14:35:43'),
(76, 'magasin-magasin-sortie-list', 'web', '2019-11-11 14:35:43', '2019-11-11 14:35:43'),
(77, 'magasin-magasin-sortie-create', 'web', '2019-11-11 14:35:43', '2019-11-11 14:35:43'),
(78, 'magasin-magasin-sortie-edit', 'web', '2019-11-11 14:35:43', '2019-11-11 14:35:43'),
(79, 'magasin-magasin-sortie-delete', 'web', '2019-11-11 14:35:43', '2019-11-11 14:35:43'),
(80, 'magasin-boutique-sortie-list', 'web', '2019-11-11 14:35:43', '2019-11-11 14:35:43'),
(81, 'magasin-boutique-sortie-create', 'web', '2019-11-11 14:35:43', '2019-11-11 14:35:43'),
(82, 'magasin-boutique-sortie-edit', 'web', '2019-11-11 14:35:43', '2019-11-11 14:35:43'),
(83, 'magasin-boutique-sortie-delete', 'web', '2019-11-11 14:35:43', '2019-11-11 14:35:43');

-- --------------------------------------------------------

--
-- Structure de la table `produits`
--

CREATE TABLE `produits` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `reference` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nom` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `categorie_id` bigint(20) UNSIGNED DEFAULT NULL,
  `prix` decimal(18,2) DEFAULT NULL,
  `prix_achat` decimal(18,2) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `roles`
--

CREATE TABLE `roles` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `guard_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `roles`
--

INSERT INTO `roles` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES
(1, 'Admin', 'web', '2019-11-11 14:35:43', '2019-11-11 14:35:43');

-- --------------------------------------------------------

--
-- Structure de la table `role_has_permissions`
--

CREATE TABLE `role_has_permissions` (
  `permission_id` int(10) UNSIGNED NOT NULL,
  `role_id` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `role_has_permissions`
--

INSERT INTO `role_has_permissions` (`permission_id`, `role_id`) VALUES
(1, 1),
(2, 1),
(3, 1),
(4, 1),
(5, 1),
(6, 1),
(7, 1),
(8, 1),
(9, 1),
(10, 1),
(11, 1),
(12, 1),
(13, 1),
(14, 1),
(15, 1),
(16, 1),
(17, 1),
(18, 1),
(19, 1),
(20, 1),
(21, 1),
(22, 1),
(23, 1),
(24, 1),
(25, 1),
(26, 1),
(27, 1),
(28, 1),
(29, 1),
(30, 1),
(31, 1),
(32, 1),
(33, 1),
(34, 1),
(35, 1),
(36, 1),
(37, 1),
(38, 1),
(39, 1),
(40, 1),
(41, 1),
(42, 1),
(43, 1),
(44, 1),
(45, 1),
(46, 1),
(47, 1),
(48, 1),
(49, 1),
(50, 1),
(51, 1),
(52, 1),
(53, 1),
(54, 1),
(55, 1),
(56, 1),
(57, 1),
(58, 1),
(59, 1),
(60, 1),
(61, 1),
(62, 1),
(63, 1),
(64, 1),
(65, 1),
(66, 1),
(67, 1),
(68, 1),
(69, 1),
(70, 1),
(71, 1),
(72, 1),
(73, 1),
(74, 1),
(75, 1),
(76, 1),
(77, 1),
(78, 1),
(79, 1),
(80, 1),
(81, 1),
(82, 1),
(83, 1);

-- --------------------------------------------------------

--
-- Structure de la table `solde_boutiques`
--

CREATE TABLE `solde_boutiques` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `boutique_jour_id` bigint(20) UNSIGNED DEFAULT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `boutique_id` bigint(20) UNSIGNED DEFAULT NULL,
  `facture_boutique_id` bigint(20) UNSIGNED DEFAULT NULL,
  `boutique_stock_id` bigint(20) UNSIGNED DEFAULT NULL,
  `quantite` bigint(20) UNSIGNED DEFAULT NULL,
  `prix` decimal(18,2) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `sortie_boutique_magasins`
--

CREATE TABLE `sortie_boutique_magasins` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `boutique_jour_id` bigint(20) UNSIGNED DEFAULT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `boutique_id` bigint(20) UNSIGNED DEFAULT NULL,
  `magasin_id` bigint(20) UNSIGNED DEFAULT NULL,
  `boutique_stock_id` bigint(20) UNSIGNED DEFAULT NULL,
  `quantite` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `sortie_magasin_boutiques`
--

CREATE TABLE `sortie_magasin_boutiques` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `magasin_jour_id` bigint(20) UNSIGNED DEFAULT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `boutique_id` bigint(20) UNSIGNED DEFAULT NULL,
  `magasin_id` bigint(20) UNSIGNED DEFAULT NULL,
  `magasin_stock_id` bigint(20) UNSIGNED DEFAULT NULL,
  `quantite` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `sortie_magasin_magasins`
--

CREATE TABLE `sortie_magasin_magasins` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `magasin_jour_id` bigint(20) UNSIGNED DEFAULT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `magasin` bigint(20) UNSIGNED DEFAULT NULL,
  `magasin_id` bigint(20) UNSIGNED DEFAULT NULL,
  `magasin_stock_id` bigint(20) UNSIGNED DEFAULT NULL,
  `quantite` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `tontine_boutiques`
--

CREATE TABLE `tontine_boutiques` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `boutique_jour_id` bigint(20) UNSIGNED DEFAULT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `boutique_id` bigint(20) UNSIGNED DEFAULT NULL,
  `nom` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `montant` decimal(18,2) DEFAULT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `users`
--

INSERT INTO `users` (`id`, `name`, `phone`, `email`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'blondin', '695932023', 'blondin@gmail.com', NULL, '$2y$10$roElKGr6Kyg4pYUjAtB5Iul6o.fqXPtwYz2wnCBvTQgs1kKtyy5vy', NULL, '2019-11-11 14:35:43', '2019-11-11 14:35:43');

-- --------------------------------------------------------

--
-- Structure de la table `user_boutiques`
--

CREATE TABLE `user_boutiques` (
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `boutique_id` bigint(20) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `user_magasins`
--

CREATE TABLE `user_magasins` (
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `magasin_id` bigint(20) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `vente_boutiques`
--

CREATE TABLE `vente_boutiques` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `boutique_jour_id` bigint(20) UNSIGNED DEFAULT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `boutique_id` bigint(20) UNSIGNED DEFAULT NULL,
  `facture_boutique_id` bigint(20) UNSIGNED DEFAULT NULL,
  `boutique_stock_id` bigint(20) UNSIGNED DEFAULT NULL,
  `quantite` bigint(20) UNSIGNED DEFAULT NULL,
  `prix` decimal(18,2) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `versement_boutiques`
--

CREATE TABLE `versement_boutiques` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `boutique_jour_id` bigint(20) UNSIGNED DEFAULT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `boutique_id` bigint(20) UNSIGNED DEFAULT NULL,
  `destination` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `montant` decimal(18,2) DEFAULT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `versement_dettes`
--

CREATE TABLE `versement_dettes` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `dette_boutique_id` bigint(20) UNSIGNED DEFAULT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `montant` decimal(18,2) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `boutiques`
--
ALTER TABLE `boutiques`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `boutique_boutiques`
--
ALTER TABLE `boutique_boutiques`
  ADD KEY `boutique_boutiques_boutique_foreign` (`boutique`),
  ADD KEY `boutique_boutiques_boutique_id_foreign` (`boutique_id`);

--
-- Index pour la table `boutique_historiques`
--
ALTER TABLE `boutique_historiques`
  ADD PRIMARY KEY (`id`),
  ADD KEY `boutique_historiques_boutique_jour_id_foreign` (`boutique_jour_id`),
  ADD KEY `boutique_historiques_user_id_foreign` (`user_id`),
  ADD KEY `boutique_historiques_boutique_id_foreign` (`boutique_id`);

--
-- Index pour la table `boutique_jours`
--
ALTER TABLE `boutique_jours`
  ADD PRIMARY KEY (`id`),
  ADD KEY `boutique_jours_boutique_id_foreign` (`boutique_id`);

--
-- Index pour la table `boutique_stocks`
--
ALTER TABLE `boutique_stocks`
  ADD PRIMARY KEY (`id`),
  ADD KEY `boutique_stocks_produit_id_foreign` (`produit_id`),
  ADD KEY `boutique_stocks_boutique_id_foreign` (`boutique_id`);

--
-- Index pour la table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `categories_nom_unique` (`nom`);

--
-- Index pour la table `charge_boutiques`
--
ALTER TABLE `charge_boutiques`
  ADD PRIMARY KEY (`id`),
  ADD KEY `charge_boutiques_boutique_jour_id_foreign` (`boutique_jour_id`),
  ADD KEY `charge_boutiques_user_id_foreign` (`user_id`),
  ADD KEY `charge_boutiques_boutique_id_foreign` (`boutique_id`);

--
-- Index pour la table `dette_boutiques`
--
ALTER TABLE `dette_boutiques`
  ADD PRIMARY KEY (`id`),
  ADD KEY `dette_boutiques_boutique_jour_id_foreign` (`boutique_jour_id`),
  ADD KEY `dette_boutiques_user_id_foreign` (`user_id`),
  ADD KEY `dette_boutiques_boutique_id_foreign` (`boutique_id`);

--
-- Index pour la table `entree_magasins`
--
ALTER TABLE `entree_magasins`
  ADD PRIMARY KEY (`id`),
  ADD KEY `entree_magasins_magasin_jour_id_foreign` (`magasin_jour_id`),
  ADD KEY `entree_magasins_user_id_foreign` (`user_id`),
  ADD KEY `entree_magasins_magasin_id_foreign` (`magasin_id`),
  ADD KEY `entree_magasins_magasin_stock_id_foreign` (`magasin_stock_id`);

--
-- Index pour la table `facture_boutiques`
--
ALTER TABLE `facture_boutiques`
  ADD PRIMARY KEY (`id`),
  ADD KEY `facture_boutiques_boutique_id_foreign` (`boutique_id`);

--
-- Index pour la table `historiques`
--
ALTER TABLE `historiques`
  ADD PRIMARY KEY (`id`),
  ADD KEY `historiques_user_id_foreign` (`user_id`);

--
-- Index pour la table `magasins`
--
ALTER TABLE `magasins`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `magasin_boutiques`
--
ALTER TABLE `magasin_boutiques`
  ADD KEY `magasin_boutiques_magasin_id_foreign` (`magasin_id`),
  ADD KEY `magasin_boutiques_boutique_id_foreign` (`boutique_id`);

--
-- Index pour la table `magasin_historiques`
--
ALTER TABLE `magasin_historiques`
  ADD PRIMARY KEY (`id`),
  ADD KEY `magasin_historiques_magasin_jour_id_foreign` (`magasin_jour_id`),
  ADD KEY `magasin_historiques_user_id_foreign` (`user_id`),
  ADD KEY `magasin_historiques_magasin_id_foreign` (`magasin_id`);

--
-- Index pour la table `magasin_jours`
--
ALTER TABLE `magasin_jours`
  ADD PRIMARY KEY (`id`),
  ADD KEY `magasin_jours_magasin_id_foreign` (`magasin_id`);

--
-- Index pour la table `magasin_magasins`
--
ALTER TABLE `magasin_magasins`
  ADD KEY `magasin_magasins_magasin_foreign` (`magasin`),
  ADD KEY `magasin_magasins_magasin_id_foreign` (`magasin_id`);

--
-- Index pour la table `magasin_stocks`
--
ALTER TABLE `magasin_stocks`
  ADD PRIMARY KEY (`id`),
  ADD KEY `magasin_stocks_produit_id_foreign` (`produit_id`),
  ADD KEY `magasin_stocks_magasin_id_foreign` (`magasin_id`);

--
-- Index pour la table `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`id`),
  ADD KEY `messages_user_id_foreign` (`user_id`);

--
-- Index pour la table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `model_has_permissions`
--
ALTER TABLE `model_has_permissions`
  ADD PRIMARY KEY (`permission_id`,`model_id`,`model_type`),
  ADD KEY `model_has_permissions_model_id_model_type_index` (`model_id`,`model_type`);

--
-- Index pour la table `model_has_roles`
--
ALTER TABLE `model_has_roles`
  ADD PRIMARY KEY (`role_id`,`model_id`,`model_type`),
  ADD KEY `model_has_roles_model_id_model_type_index` (`model_id`,`model_type`);

--
-- Index pour la table `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- Index pour la table `permissions`
--
ALTER TABLE `permissions`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `produits`
--
ALTER TABLE `produits`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `produits_reference_unique` (`reference`),
  ADD UNIQUE KEY `produits_nom_unique` (`nom`),
  ADD KEY `produits_categorie_id_foreign` (`categorie_id`);

--
-- Index pour la table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `role_has_permissions`
--
ALTER TABLE `role_has_permissions`
  ADD PRIMARY KEY (`permission_id`,`role_id`),
  ADD KEY `role_has_permissions_role_id_foreign` (`role_id`);

--
-- Index pour la table `solde_boutiques`
--
ALTER TABLE `solde_boutiques`
  ADD PRIMARY KEY (`id`),
  ADD KEY `solde_boutiques_boutique_jour_id_foreign` (`boutique_jour_id`),
  ADD KEY `solde_boutiques_user_id_foreign` (`user_id`),
  ADD KEY `solde_boutiques_boutique_id_foreign` (`boutique_id`),
  ADD KEY `solde_boutiques_facture_boutique_id_foreign` (`facture_boutique_id`),
  ADD KEY `solde_boutiques_boutique_stock_id_foreign` (`boutique_stock_id`);

--
-- Index pour la table `sortie_boutique_magasins`
--
ALTER TABLE `sortie_boutique_magasins`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sortie_boutique_magasins_boutique_jour_id_foreign` (`boutique_jour_id`),
  ADD KEY `sortie_boutique_magasins_user_id_foreign` (`user_id`),
  ADD KEY `sortie_boutique_magasins_boutique_id_foreign` (`boutique_id`),
  ADD KEY `sortie_boutique_magasins_magasin_id_foreign` (`magasin_id`),
  ADD KEY `sortie_boutique_magasins_boutique_stock_id_foreign` (`boutique_stock_id`);

--
-- Index pour la table `sortie_magasin_boutiques`
--
ALTER TABLE `sortie_magasin_boutiques`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sortie_magasin_boutiques_magasin_jour_id_foreign` (`magasin_jour_id`),
  ADD KEY `sortie_magasin_boutiques_user_id_foreign` (`user_id`),
  ADD KEY `sortie_magasin_boutiques_boutique_id_foreign` (`boutique_id`),
  ADD KEY `sortie_magasin_boutiques_magasin_id_foreign` (`magasin_id`),
  ADD KEY `sortie_magasin_boutiques_magasin_stock_id_foreign` (`magasin_stock_id`);

--
-- Index pour la table `sortie_magasin_magasins`
--
ALTER TABLE `sortie_magasin_magasins`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sortie_magasin_magasins_magasin_jour_id_foreign` (`magasin_jour_id`),
  ADD KEY `sortie_magasin_magasins_user_id_foreign` (`user_id`),
  ADD KEY `sortie_magasin_magasins_magasin_foreign` (`magasin`),
  ADD KEY `sortie_magasin_magasins_magasin_id_foreign` (`magasin_id`),
  ADD KEY `sortie_magasin_magasins_magasin_stock_id_foreign` (`magasin_stock_id`);

--
-- Index pour la table `tontine_boutiques`
--
ALTER TABLE `tontine_boutiques`
  ADD PRIMARY KEY (`id`),
  ADD KEY `tontine_boutiques_boutique_jour_id_foreign` (`boutique_jour_id`),
  ADD KEY `tontine_boutiques_user_id_foreign` (`user_id`),
  ADD KEY `tontine_boutiques_boutique_id_foreign` (`boutique_id`);

--
-- Index pour la table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_phone_unique` (`phone`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- Index pour la table `user_boutiques`
--
ALTER TABLE `user_boutiques`
  ADD KEY `user_boutiques_user_id_foreign` (`user_id`),
  ADD KEY `user_boutiques_boutique_id_foreign` (`boutique_id`);

--
-- Index pour la table `user_magasins`
--
ALTER TABLE `user_magasins`
  ADD KEY `user_magasins_user_id_foreign` (`user_id`),
  ADD KEY `user_magasins_magasin_id_foreign` (`magasin_id`);

--
-- Index pour la table `vente_boutiques`
--
ALTER TABLE `vente_boutiques`
  ADD PRIMARY KEY (`id`),
  ADD KEY `vente_boutiques_boutique_jour_id_foreign` (`boutique_jour_id`),
  ADD KEY `vente_boutiques_user_id_foreign` (`user_id`),
  ADD KEY `vente_boutiques_boutique_id_foreign` (`boutique_id`),
  ADD KEY `vente_boutiques_facture_boutique_id_foreign` (`facture_boutique_id`),
  ADD KEY `vente_boutiques_boutique_stock_id_foreign` (`boutique_stock_id`);

--
-- Index pour la table `versement_boutiques`
--
ALTER TABLE `versement_boutiques`
  ADD PRIMARY KEY (`id`),
  ADD KEY `versement_boutiques_boutique_jour_id_foreign` (`boutique_jour_id`),
  ADD KEY `versement_boutiques_user_id_foreign` (`user_id`),
  ADD KEY `versement_boutiques_boutique_id_foreign` (`boutique_id`);

--
-- Index pour la table `versement_dettes`
--
ALTER TABLE `versement_dettes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `versement_dettes_user_id_foreign` (`user_id`),
  ADD KEY `versement_dettes_dette_boutique_id_foreign` (`dette_boutique_id`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `boutiques`
--
ALTER TABLE `boutiques`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `boutique_historiques`
--
ALTER TABLE `boutique_historiques`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `boutique_jours`
--
ALTER TABLE `boutique_jours`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `boutique_stocks`
--
ALTER TABLE `boutique_stocks`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `charge_boutiques`
--
ALTER TABLE `charge_boutiques`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `dette_boutiques`
--
ALTER TABLE `dette_boutiques`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `entree_magasins`
--
ALTER TABLE `entree_magasins`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `facture_boutiques`
--
ALTER TABLE `facture_boutiques`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `historiques`
--
ALTER TABLE `historiques`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `magasins`
--
ALTER TABLE `magasins`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `magasin_historiques`
--
ALTER TABLE `magasin_historiques`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `magasin_jours`
--
ALTER TABLE `magasin_jours`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `magasin_stocks`
--
ALTER TABLE `magasin_stocks`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `messages`
--
ALTER TABLE `messages`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=97;

--
-- AUTO_INCREMENT pour la table `permissions`
--
ALTER TABLE `permissions`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=84;

--
-- AUTO_INCREMENT pour la table `produits`
--
ALTER TABLE `produits`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT pour la table `solde_boutiques`
--
ALTER TABLE `solde_boutiques`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `sortie_boutique_magasins`
--
ALTER TABLE `sortie_boutique_magasins`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `sortie_magasin_boutiques`
--
ALTER TABLE `sortie_magasin_boutiques`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `sortie_magasin_magasins`
--
ALTER TABLE `sortie_magasin_magasins`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `tontine_boutiques`
--
ALTER TABLE `tontine_boutiques`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT pour la table `vente_boutiques`
--
ALTER TABLE `vente_boutiques`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `versement_boutiques`
--
ALTER TABLE `versement_boutiques`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `versement_dettes`
--
ALTER TABLE `versement_dettes`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `boutique_boutiques`
--
ALTER TABLE `boutique_boutiques`
  ADD CONSTRAINT `boutique_boutiques_boutique_foreign` FOREIGN KEY (`boutique`) REFERENCES `boutiques` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `boutique_boutiques_boutique_id_foreign` FOREIGN KEY (`boutique_id`) REFERENCES `boutiques` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `boutique_historiques`
--
ALTER TABLE `boutique_historiques`
  ADD CONSTRAINT `boutique_historiques_boutique_id_foreign` FOREIGN KEY (`boutique_id`) REFERENCES `boutiques` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `boutique_historiques_boutique_jour_id_foreign` FOREIGN KEY (`boutique_jour_id`) REFERENCES `boutique_jours` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `boutique_historiques_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `boutique_jours`
--
ALTER TABLE `boutique_jours`
  ADD CONSTRAINT `boutique_jours_boutique_id_foreign` FOREIGN KEY (`boutique_id`) REFERENCES `boutiques` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `boutique_stocks`
--
ALTER TABLE `boutique_stocks`
  ADD CONSTRAINT `boutique_stocks_boutique_id_foreign` FOREIGN KEY (`boutique_id`) REFERENCES `boutiques` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `boutique_stocks_produit_id_foreign` FOREIGN KEY (`produit_id`) REFERENCES `produits` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `charge_boutiques`
--
ALTER TABLE `charge_boutiques`
  ADD CONSTRAINT `charge_boutiques_boutique_id_foreign` FOREIGN KEY (`boutique_id`) REFERENCES `boutiques` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `charge_boutiques_boutique_jour_id_foreign` FOREIGN KEY (`boutique_jour_id`) REFERENCES `boutique_jours` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `charge_boutiques_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `dette_boutiques`
--
ALTER TABLE `dette_boutiques`
  ADD CONSTRAINT `dette_boutiques_boutique_id_foreign` FOREIGN KEY (`boutique_id`) REFERENCES `boutiques` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `dette_boutiques_boutique_jour_id_foreign` FOREIGN KEY (`boutique_jour_id`) REFERENCES `boutique_jours` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `dette_boutiques_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `entree_magasins`
--
ALTER TABLE `entree_magasins`
  ADD CONSTRAINT `entree_magasins_magasin_id_foreign` FOREIGN KEY (`magasin_id`) REFERENCES `magasins` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `entree_magasins_magasin_jour_id_foreign` FOREIGN KEY (`magasin_jour_id`) REFERENCES `magasin_jours` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `entree_magasins_magasin_stock_id_foreign` FOREIGN KEY (`magasin_stock_id`) REFERENCES `magasin_stocks` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `entree_magasins_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `facture_boutiques`
--
ALTER TABLE `facture_boutiques`
  ADD CONSTRAINT `facture_boutiques_boutique_id_foreign` FOREIGN KEY (`boutique_id`) REFERENCES `boutiques` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `historiques`
--
ALTER TABLE `historiques`
  ADD CONSTRAINT `historiques_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `magasin_boutiques`
--
ALTER TABLE `magasin_boutiques`
  ADD CONSTRAINT `magasin_boutiques_boutique_id_foreign` FOREIGN KEY (`boutique_id`) REFERENCES `boutiques` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `magasin_boutiques_magasin_id_foreign` FOREIGN KEY (`magasin_id`) REFERENCES `magasins` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `magasin_historiques`
--
ALTER TABLE `magasin_historiques`
  ADD CONSTRAINT `magasin_historiques_magasin_id_foreign` FOREIGN KEY (`magasin_id`) REFERENCES `magasins` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `magasin_historiques_magasin_jour_id_foreign` FOREIGN KEY (`magasin_jour_id`) REFERENCES `magasin_jours` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `magasin_historiques_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `magasin_jours`
--
ALTER TABLE `magasin_jours`
  ADD CONSTRAINT `magasin_jours_magasin_id_foreign` FOREIGN KEY (`magasin_id`) REFERENCES `magasins` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `magasin_magasins`
--
ALTER TABLE `magasin_magasins`
  ADD CONSTRAINT `magasin_magasins_magasin_foreign` FOREIGN KEY (`magasin`) REFERENCES `magasins` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `magasin_magasins_magasin_id_foreign` FOREIGN KEY (`magasin_id`) REFERENCES `magasins` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `magasin_stocks`
--
ALTER TABLE `magasin_stocks`
  ADD CONSTRAINT `magasin_stocks_magasin_id_foreign` FOREIGN KEY (`magasin_id`) REFERENCES `magasins` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `magasin_stocks_produit_id_foreign` FOREIGN KEY (`produit_id`) REFERENCES `produits` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `messages`
--
ALTER TABLE `messages`
  ADD CONSTRAINT `messages_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `model_has_permissions`
--
ALTER TABLE `model_has_permissions`
  ADD CONSTRAINT `model_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `model_has_roles`
--
ALTER TABLE `model_has_roles`
  ADD CONSTRAINT `model_has_roles_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `produits`
--
ALTER TABLE `produits`
  ADD CONSTRAINT `produits_categorie_id_foreign` FOREIGN KEY (`categorie_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `role_has_permissions`
--
ALTER TABLE `role_has_permissions`
  ADD CONSTRAINT `role_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `role_has_permissions_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `solde_boutiques`
--
ALTER TABLE `solde_boutiques`
  ADD CONSTRAINT `solde_boutiques_boutique_id_foreign` FOREIGN KEY (`boutique_id`) REFERENCES `boutiques` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `solde_boutiques_boutique_jour_id_foreign` FOREIGN KEY (`boutique_jour_id`) REFERENCES `boutique_jours` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `solde_boutiques_boutique_stock_id_foreign` FOREIGN KEY (`boutique_stock_id`) REFERENCES `boutique_stocks` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `solde_boutiques_facture_boutique_id_foreign` FOREIGN KEY (`facture_boutique_id`) REFERENCES `facture_boutiques` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `solde_boutiques_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `sortie_boutique_magasins`
--
ALTER TABLE `sortie_boutique_magasins`
  ADD CONSTRAINT `sortie_boutique_magasins_boutique_id_foreign` FOREIGN KEY (`boutique_id`) REFERENCES `boutiques` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `sortie_boutique_magasins_boutique_jour_id_foreign` FOREIGN KEY (`boutique_jour_id`) REFERENCES `boutique_jours` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `sortie_boutique_magasins_boutique_stock_id_foreign` FOREIGN KEY (`boutique_stock_id`) REFERENCES `boutique_stocks` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `sortie_boutique_magasins_magasin_id_foreign` FOREIGN KEY (`magasin_id`) REFERENCES `magasins` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `sortie_boutique_magasins_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `sortie_magasin_boutiques`
--
ALTER TABLE `sortie_magasin_boutiques`
  ADD CONSTRAINT `sortie_magasin_boutiques_boutique_id_foreign` FOREIGN KEY (`boutique_id`) REFERENCES `boutiques` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `sortie_magasin_boutiques_magasin_id_foreign` FOREIGN KEY (`magasin_id`) REFERENCES `magasins` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `sortie_magasin_boutiques_magasin_jour_id_foreign` FOREIGN KEY (`magasin_jour_id`) REFERENCES `magasin_jours` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `sortie_magasin_boutiques_magasin_stock_id_foreign` FOREIGN KEY (`magasin_stock_id`) REFERENCES `magasin_stocks` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `sortie_magasin_boutiques_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `sortie_magasin_magasins`
--
ALTER TABLE `sortie_magasin_magasins`
  ADD CONSTRAINT `sortie_magasin_magasins_magasin_foreign` FOREIGN KEY (`magasin`) REFERENCES `magasins` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `sortie_magasin_magasins_magasin_id_foreign` FOREIGN KEY (`magasin_id`) REFERENCES `magasins` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `sortie_magasin_magasins_magasin_jour_id_foreign` FOREIGN KEY (`magasin_jour_id`) REFERENCES `magasin_jours` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `sortie_magasin_magasins_magasin_stock_id_foreign` FOREIGN KEY (`magasin_stock_id`) REFERENCES `magasin_stocks` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `sortie_magasin_magasins_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `tontine_boutiques`
--
ALTER TABLE `tontine_boutiques`
  ADD CONSTRAINT `tontine_boutiques_boutique_id_foreign` FOREIGN KEY (`boutique_id`) REFERENCES `boutiques` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `tontine_boutiques_boutique_jour_id_foreign` FOREIGN KEY (`boutique_jour_id`) REFERENCES `boutique_jours` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `tontine_boutiques_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `user_boutiques`
--
ALTER TABLE `user_boutiques`
  ADD CONSTRAINT `user_boutiques_boutique_id_foreign` FOREIGN KEY (`boutique_id`) REFERENCES `boutiques` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `user_boutiques_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `user_magasins`
--
ALTER TABLE `user_magasins`
  ADD CONSTRAINT `user_magasins_magasin_id_foreign` FOREIGN KEY (`magasin_id`) REFERENCES `magasins` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `user_magasins_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `vente_boutiques`
--
ALTER TABLE `vente_boutiques`
  ADD CONSTRAINT `vente_boutiques_boutique_id_foreign` FOREIGN KEY (`boutique_id`) REFERENCES `boutiques` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `vente_boutiques_boutique_jour_id_foreign` FOREIGN KEY (`boutique_jour_id`) REFERENCES `boutique_jours` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `vente_boutiques_boutique_stock_id_foreign` FOREIGN KEY (`boutique_stock_id`) REFERENCES `boutique_stocks` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `vente_boutiques_facture_boutique_id_foreign` FOREIGN KEY (`facture_boutique_id`) REFERENCES `facture_boutiques` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `vente_boutiques_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `versement_boutiques`
--
ALTER TABLE `versement_boutiques`
  ADD CONSTRAINT `versement_boutiques_boutique_id_foreign` FOREIGN KEY (`boutique_id`) REFERENCES `boutiques` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `versement_boutiques_boutique_jour_id_foreign` FOREIGN KEY (`boutique_jour_id`) REFERENCES `boutique_jours` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `versement_boutiques_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `versement_dettes`
--
ALTER TABLE `versement_dettes`
  ADD CONSTRAINT `versement_dettes_dette_boutique_id_foreign` FOREIGN KEY (`dette_boutique_id`) REFERENCES `dette_boutiques` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `versement_dettes_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
