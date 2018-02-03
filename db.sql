SET
    SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";CREATE DATABASE IF NOT EXISTS `gedimagination` DEFAULT CHARACTER
SET utf8 COLLATE utf8_general_ci;USE `gedimagination`;DROP TABLE IF EXISTS `Utilisateur`;CREATE TABLE IF NOT EXISTS `Utilisateur` (
        `id` int (11) NOT NULL AUTO_INCREMENT,
        `email` varchar (50) NOT NULL,
        `mdp` varchar (130) NOT NULL,
        `nom` varchar (20) NOT NULL,
        `idImageParticipation` int (11) DEFAULT NULL,
        `role` varchar (12) NOT NULL,
        PRIMARY KEY (`id`)
    ) ENGINE = InnoDB AUTO_INCREMENT = 4 DEFAULT CHARSET = utf8;
    DROP TABLE IF EXISTS `ImageParticipation`;
    CREATE TABLE IF NOT EXISTS `ImageParticipation` (
        `id` int (11) NOT NULL AUTO_INCREMENT,
        `url` int (11) NOT NULL,
        `votes` int (11) DEFAULT NULL,
        PRIMARY KEY (`id`)
    ) ENGINE = InnoDB AUTO_INCREMENT = 2 DEFAULT CHARSET = utf8;
INSERT INTO
    `Utilisateur` (
        `email`,
        `mdp`,
        `nom`,
        `idImageParticipation`,
        `role`
    )
VALUES
    (
        'admin@local.dev',
        '$2y$10$0UlzN65BPxhBl9PU65PTUeMY9.aVZSpO2e52gz3dEzbWfv9lCslMK',
        'Admin Istrator',
        NULL,
        'admin'
    ),
    (
        'loulegrain@gmail.com',
        '$2y$10$0UlzN65BPxhBl9PU65PTUeMY9.aVZSpO2e52gz3dEzbWfv9lCslMK',
        'Louis Legrain',
        NULL,
        'user'
    );
ALTER TABLE
    `Utilisateur`
ADD
    CONSTRAINT `image` FOREIGN KEY (`idImageParticipation`) REFERENCES `ImageParticipation` (`id`);