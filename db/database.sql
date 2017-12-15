-- Script de création de bdd et de user
--
-- Base de données :  `gedimagination`
--
CREATE DATABASE
IF NOT EXISTS `gedimagination` DEFAULT CHARACTER
SET utf8
COLLATE utf8_general_ci;
USE `gedimagination`;
GRANT ALL PRIVILEGES ON `gedimagination`.* TO 'gedimagination_UserAppWeb'@'localhost' IDENTIFIED BY 'jaipasdimagination';