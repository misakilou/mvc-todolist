-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le :  mer. 07 oct. 2020 à 16:41
-- Version du serveur :  5.7.26
-- Version de PHP :  7.3.5

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `mvc-todolist`
--

-- --------------------------------------------------------

--
-- Structure de la table `task`
--

DROP TABLE IF EXISTS `task`;
CREATE TABLE IF NOT EXISTS `task` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `title` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `done` tinyint(1) NOT NULL DEFAULT '0',
  `parent_id` bigint(20) DEFAULT NULL,
  `user_id` bigint(20) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=108 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `task`
--

INSERT INTO `task` (`id`, `title`, `done`, `parent_id`, `user_id`, `created_at`, `updated_at`) VALUES
(105, 'sous tache 3.1', 0, 104, 36, '2020-10-07 14:38:54', '2020-10-07 14:38:54'),
(104, 'tache 3', 0, NULL, 36, '2020-10-07 14:38:48', '2020-10-07 14:38:48'),
(102, 'sous tache 1.2', 0, 98, 36, '2020-10-07 14:38:37', '2020-10-07 14:38:37'),
(101, 'sous tache 2', 0, 99, 36, '2020-10-07 14:38:26', '2020-10-07 14:38:26'),
(100, 'sous tache 1.1', 0, 98, 36, '2020-10-07 14:38:19', '2020-10-07 14:38:30'),
(99, 'Tache 2', 0, NULL, 36, '2020-10-07 14:38:14', '2020-10-07 14:38:14'),
(98, 'Tache 1', 0, NULL, 36, '2020-10-07 14:38:08', '2020-10-07 14:38:08');

-- --------------------------------------------------------

--
-- Structure de la table `user`
--

DROP TABLE IF EXISTS `user`;
CREATE TABLE IF NOT EXISTS `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) DEFAULT NULL,
  `api_token` varchar(80) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `api_token` (`api_token`)
) ENGINE=MyISAM AUTO_INCREMENT=37 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `user`
--

INSERT INTO `user` (`id`, `name`, `email`, `password`, `api_token`) VALUES
(36, 'John doe', 'john@doe.fr', '$2y$10$OoiO3yvBnWknY681iiXse.PxjunAPaf1o/3JXQex59PD3fLhGvAcC', 'ZWXuf0ux0V0D2T5L7hAbgoVsvNltZBU9fluWNjwNuSg6Gk0qGDiPQJns9TeanBE5nJTVk73AlHsNlFrm');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
