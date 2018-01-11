-- Script de création de bdd et de user
--
-- Base de données :  `gedimagination`
--
CREATE DATABASE
IF NOT EXISTS `gedimagination` DEFAULT CHARACTER
SET utf8
COLLATE utf8_general_ci;
USE `gedimagination`;
-- user gedimaginadmin
CREATE USER 'gedimaginadmin'@'%' IDENTIFIED
WITH mysql_native_password;
GRANT USAGE ON *.* TO 'gedimaginadmin'@'%' REQUIRE NONE
WITH MAX_QUERIES_PER_HOUR 0 MAX_CONNECTIONS_PER_HOUR 0 MAX_UPDATES_PER_HOUR 0 MAX_USER_CONNECTIONS 0;
SET PASSWORD
FOR 'gedimaginadmin'@'%' = '21232f297a57a5a743894a0e4a801fc3';
GRANT ALL PRIVILEGES ON `gedimagination`.* TO 'gedimaginadmin'@'%';
-- --------------------------------------------------------
--
-- Structure de la table `User`
--
DROP TABLE IF EXISTS `User`;
CREATE TABLE
IF NOT EXISTS `User` (
  `id` int
(11) NOT NULL AUTO_INCREMENT,
  `pwd` varchar
(88) NOT NULL,
  `salt` varchar
(23) NOT NULL,
  `email` varchar
(50) NOT NULL,
  `prenom` varchar
(20) NOT NULL,
  `nom` varchar
(20) NOT NULL,
  `urlImgParticipation` varchar
(100) DEFAULT NULL,
  `role` varchar
(5) NOT NULL,
  PRIMARY KEY
(`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
