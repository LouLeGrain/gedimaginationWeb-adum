-- phpMyAdmin SQL Dump
-- version 4.7.5
-- https://www.phpmyadmin.net/
--
-- Hôte : localhost:3306
-- Généré le :  mer. 07 fév. 2018 à 20:07
-- Version du serveur :  5.6.38
-- Version de PHP :  7.1.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- Base de données :  `gedimagination`
--
CREATE DATABASE IF NOT EXISTS `gedimagination` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `gedimagination`;

-- --------------------------------------------------------

--
-- Structure de la table `ImageParticipation`
--

DROP TABLE IF EXISTS `ImageParticipation`;
CREATE TABLE `ImageParticipation` (
  `id` int(11) NOT NULL,
  `url` varchar(200) NOT NULL,
  `note` decimal(3,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `ImageParticipation`
--

INSERT INTO `ImageParticipation` (`id`, `url`, `note`) VALUES
(15, 'participations/mabornedarcade.jpg', '2.55'),
(16, 'participations/monfirepit.jpg', '3.87'),
(17, 'participations/macuisine.jpg', '4.55');

-- --------------------------------------------------------

--
-- Structure de la table `Utilisateur`
--

DROP TABLE IF EXISTS `Utilisateur`;
CREATE TABLE `Utilisateur` (
  `id` int(11) NOT NULL,
  `email` varchar(50) NOT NULL,
  `mdp` varchar(130) NOT NULL,
  `nom` varchar(20) NOT NULL,
  `idImageParticipation` int(11) DEFAULT NULL,
  `role` varchar(12) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `Utilisateur`
--

INSERT INTO `Utilisateur` (`id`, `email`, `mdp`, `nom`, `idImageParticipation`, `role`) VALUES
(1, 'admin@local.dev', '$2y$10$Us4CG827A6sNcadbcwMiIO4KsuBh3pn0V5aVxMIy8Wn4m/p8hJAT.', 'Admin Istrator', NULL, 'user'),
(2, 'loulegrain@gmail.com', '$2y$10$bn6SBXvRp5fBKYPwSdQF5OKirXq02ZkZTUhcsTFpLBZg5lTe2/qYq', 'Louis Legrain', 15, 'user'),
(3, 'kedu@local.dev', '$2y$10$IkF00aaqf27IBGyf1cA1XeU8xrnnnRzn4QJXfB1pz8Ni6eRABytA2', 'Kevin Dumenil', 16, 'user'),
(4, 'tim@local.dev', '$2y$10$ylZyqNI1ssD/JH1wiPV.neB7USYoW1l0YC0kVmocrQ/EW3UqZFOFS', 'Timothée Comte', 17, 'user');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `ImageParticipation`
--
ALTER TABLE `ImageParticipation`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `Utilisateur`
--
ALTER TABLE `Utilisateur`
  ADD PRIMARY KEY (`id`),
  ADD KEY `image` (`idImageParticipation`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `ImageParticipation`
--
ALTER TABLE `ImageParticipation`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT pour la table `Utilisateur`
--
ALTER TABLE `Utilisateur`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `Utilisateur`
--
ALTER TABLE `Utilisateur`
  ADD CONSTRAINT `image` FOREIGN KEY (`idImageParticipation`) REFERENCES `ImageParticipation` (`id`) ON DELETE CASCADE;
