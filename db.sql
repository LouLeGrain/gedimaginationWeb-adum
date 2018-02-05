-- phpMyAdmin SQL Dump
-- version 4.7.7
-- https://www.phpmyadmin.net/
--
-- Hôte : localhost:3306
-- Généré le :  Dim 04 fév. 2018 à 18:47
-- Version du serveur :  5.6.35
-- Version de PHP :  7.1.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- Base de données :  `gedimagination`
--
CREATE DATABASE IF NOT EXISTS `gedimagination` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `gedimagination`;

GRANT USAGE ON *.* TO 'gedimaginadmin'@'%' IDENTIFIED BY PASSWORD '*A3E999ACF5747057118E626877C41DAD62A550E8'; 
-- mdp : jaipasdimagination

GRANT ALL PRIVILEGES ON `gedimagination`.* TO 'gedimaginadmin'@'%' WITH GRANT OPTION;
-- --------------------------------------------------------

--
-- Structure de la table `Utilisateur`
--

DROP TABLE IF EXISTS `Utilisateur`;
CREATE TABLE IF NOT EXISTS `Utilisateur` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(50) NOT NULL,
  `mdp` varchar(130) NOT NULL,
  `nom` varchar(20) NOT NULL,
  `idImageParticipation` int(11) DEFAULT NULL,
  `role` varchar(12) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `image` (`idImageParticipation`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `Utilisateur`
--

INSERT INTO `Utilisateur` (`id`, `email`, `mdp`, `nom`, `idImageParticipation`, `role`) VALUES(1, 'admin@local.dev', '$2y$10$Us4CG827A6sNcadbcwMiIO4KsuBh3pn0V5aVxMIy8Wn4m/p8hJAT.', 'Admin Istrator', NULL, 'user');
INSERT INTO `Utilisateur` (`id`, `email`, `mdp`, `nom`, `idImageParticipation`, `role`) VALUES(2, 'loulegrain@gmail.com', '$2y$10$bn6SBXvRp5fBKYPwSdQF5OKirXq02ZkZTUhcsTFpLBZg5lTe2/qYq', 'Louis Legrain', 15, 'user');
INSERT INTO `Utilisateur` (`id`, `email`, `mdp`, `nom`, `idImageParticipation`, `role`) VALUES(3, 'kedu@local.dev', '$2y$10$IkF00aaqf27IBGyf1cA1XeU8xrnnnRzn4QJXfB1pz8Ni6eRABytA2', 'Kevin Dumenil', 16, 'user');
INSERT INTO `Utilisateur` (`id`, `email`, `mdp`, `nom`, `idImageParticipation`, `role`) VALUES(4, 'tim@local.dev', '$2y$10$ylZyqNI1ssD/JH1wiPV.neB7USYoW1l0YC0kVmocrQ/EW3UqZFOFS', 'Timothée Comte', 17, 'user');

--
-- Structure de la table `ImageParticipation`
--

DROP TABLE IF EXISTS `ImageParticipation`;
CREATE TABLE IF NOT EXISTS `ImageParticipation` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `url` varchar(200) NOT NULL,
  `votes` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `ImageParticipation`
--

INSERT INTO `ImageParticipation` (`id`, `url`, `votes`) VALUES(15, 'participations/mabornedarcade.jpg', 10);
INSERT INTO `ImageParticipation` (`id`, `url`, `votes`) VALUES(16, 'participations/monfirepit.jpg', 30);
INSERT INTO `ImageParticipation` (`id`, `url`, `votes`) VALUES(17, 'participations/macuisine.jpg', 15);

-- --------------------------------------------------------

--
-- Contraintes pour la table `Utilisateur`
--
ALTER TABLE `Utilisateur`
  ADD CONSTRAINT `image` FOREIGN KEY (`idImageParticipation`) REFERENCES `ImageParticipation` (`id`) ON DELETE CASCADE;

