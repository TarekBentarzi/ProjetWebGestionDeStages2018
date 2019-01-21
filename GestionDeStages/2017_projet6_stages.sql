-- phpMyAdmin SQL Dump
-- version 4.6.6
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: May 02, 2017 at 03:43 PM
-- Server version: 5.7.11
-- PHP Version: 7.1.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `2017_projet6_stages`
--
CREATE DATABASE IF NOT EXISTS `2017_projet6_stages` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `2017_projet6_stages`;

-- --------------------------------------------------------

--
-- Table structure for table `etudiants`
--

DROP TABLE IF EXISTS `etudiants`;
CREATE TABLE `etudiants` (
  `eid` int(11) NOT NULL,
  `nom` varchar(30) NOT NULL,
  `prenom` varchar(30) NOT NULL,
  `email` varchar(30) NOT NULL,
  `tel` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `etudiants`
--

INSERT INTO `etudiants` (`eid`, `nom`, `prenom`, `email`, `tel`) VALUES
(1, 'Beauvais', 'Jean-Luc', 'jlbeauvais@u-pec.fr', '06552888145'),
(2, 'Petit', 'Nicolas', 'npetit@u-pec.fr', '016628882665653'),
(3, 'Brouillard', 'Patrick', 'pb@u-pec.fr', '00210028832'),
(4, 'Pires', 'Simon', 'spires@u-peec.fr', '01020304050607'),
(5, 'Dulot', 'André', 'adulot@yahoo.com', '+33677199928773');

-- --------------------------------------------------------

--
-- Table structure for table `gestionnaires`
--

DROP TABLE IF EXISTS `gestionnaires`;
CREATE TABLE `gestionnaires` (
  `gid` int(11) NOT NULL,
  `nom` varchar(30) NOT NULL,
  `prenom` varchar(30) NOT NULL,
  `email` varchar(30) NOT NULL,
  `token` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `gestionnaires`
--

INSERT INTO `gestionnaires` (`gid`, `nom`, `prenom`, `email`, `token`) VALUES
(1, 'Responsable', 'Scolarité', 'scola@u-pec.fr', 'M9RxlBL7bwC4Ux6bH0gCd.NfJf6.M37.5ICIObtQjcSHJjjIZ0Dkq');

-- --------------------------------------------------------

--
-- Table structure for table `notes`
--

DROP TABLE IF EXISTS `notes`;
CREATE TABLE `notes` (
  `nid` int(11) NOT NULL,
  `sid` int(11) NOT NULL,
  `note` int(10) UNSIGNED NOT NULL,
  `commentaire` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `notes`
--

INSERT INTO `notes` (`nid`, `sid`, `note`, `commentaire`) VALUES
(1, 1, 14, 'Stage raisonnable. Problème d\'exposition du travail fait.'),
(2, 3, 18, 'Travail bien réalisé. Travail en production. À permis de grosses économies à l\'entreprise.');

-- --------------------------------------------------------

--
-- Table structure for table `soutenances`
--

DROP TABLE IF EXISTS `soutenances`;
CREATE TABLE `soutenances` (
  `stid` int(11) NOT NULL,
  `sid` int(11) NOT NULL,
  `tuteur1` int(11) NOT NULL,
  `tuteur2` int(11) NOT NULL,
  `date` datetime NOT NULL,
  `salle` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `soutenances`
--

INSERT INTO `soutenances` (`stid`, `sid`, `tuteur1`, `tuteur2`, `date`, `salle`) VALUES
(1, 1, 3, 4, '2017-06-15 10:23:00', 'P2-11'),
(2, 2, 3, 5, '2017-09-07 16:25:00', 'P1-011'),
(3, 3, 7, 3, '2017-07-07 10:00:00', 'P1-011');

-- --------------------------------------------------------

--
-- Table structure for table `stages`
--

DROP TABLE IF EXISTS `stages`;
CREATE TABLE `stages` (
  `sid` int(11) NOT NULL,
  `eid` int(11) NOT NULL,
  `titre` varchar(100) NOT NULL,
  `description` text NOT NULL,
  `entreprise` varchar(50) NOT NULL DEFAULT '',
  `tuteurE` varchar(40) NOT NULL,
  `emailTE` varchar(30) NOT NULL,
  `tuteurP` int(11) DEFAULT NULL,
  `dateDebut` date NOT NULL,
  `dateFin` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `stages`
--

INSERT INTO `stages` (`sid`, `eid`, `titre`, `description`, `entreprise`, `tuteurE`, `emailTE`, `tuteurP`, `dateDebut`, `dateFin`) VALUES
(1, 1, 'Développement web, XML et développement Java', '- reprise du site web de l\'entreprise - création d\'une base FAQ pour un client - création d\'une interface de programmation XML', 'Integraphone', 'Baron David', 'bd@yahoo.com', 3, '2017-04-03', '2017-06-10'),
(2, 2, 'Web-Service', 'Implémentation et déploiement de services web côté serveur, documentation fonctionnelle et technique', 'Telesolf', 'Alexandre Miles', 'amma@mail.com', 5, '2017-02-08', '2017-05-18'),
(3, 4, 'Participer à la mise en place d\'un processus de déploiement industrialisé pour les applications', 'Mettre en place un outil pour automatiser le déploiement des applications', 'RYYDE Consulting', 'Lydia Benkacem', 'lbks#tikaz.de', 3, '2017-02-05', '2017-06-09'),
(4, 3, 'Création d\'une interface de modification de base de donnée dans une application java', 'Prise en charge d\'une application en production', 'Hôpital Henri Mondor', 'Janne d\'Arc', 'jda@maila.com', 7, '2017-03-06', '2017-05-04'),
(5, 5, 'Création et automatisation de la gestion administrative du SAV', 'Création et automatisation de la gestion administrative du service après-vente avec création d\'une interface web-client.', 'Athesi', 'Amir Safran', 'amsafr@googla.fr', NULL, '2017-05-02', '2017-07-14');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `uid` int(11) NOT NULL,
  `nom` varchar(30) DEFAULT NULL,
  `prenom` varchar(30) DEFAULT NULL,
  `login` varchar(30) NOT NULL,
  `mdp` varchar(255) NOT NULL,
  `role` enum('user','admin') NOT NULL DEFAULT 'user',
  `actif` bit(1) NOT NULL DEFAULT b'0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`uid`, `nom`, `prenom`, `login`, `mdp`, `role`, `actif`) VALUES
(1, 'Admin', 'User', 'admin', '$2y$10$WUXmfWOTO3gf.QIwxuHH0ecG51cmEsgW5YmHbQaAHcYL6wV11GgOm', 'admin', b'1'),
(2, 'Test', 'User', 'test', '$2y$10$rwE2jgPjPrw1i8DBi5xgY.aZuqV..6w9ZEFQmiYAy1G3slnJpKFVy', 'user', b'1'),
(3, 'Dupont', 'Jean', 'jdupont', '$2y$10$lyEiQXexGfSd.7YMzpHkMurB6ghYnSQqFWAr97FxDxPJPC3aZZyC6', 'user', b'1'),
(4, 'Fermi', 'Enrico', 'efermi', '$2y$10$YRrjhKVaaV39aZrXm2nRiuSioSKbgWrpETY33jRELIoGo/OQjh0cu', 'user', b'1'),
(5, 'Descartes', 'René', 'rdescartes', '$2y$10$2YNN8a.4ojBUR4NPPUi4uuGkbe/Ka3gFGEa/HWClQcRFjpnELR26K', 'user', b'1'),
(6, 'Pascal', 'Blaise', 'bpascal', '$2y$10$/Ef1yfTzrQPRZglkw2Epl.ZuLubilM3JU0WzNvTSv81pDkI1itHRC', 'user', b'0'),
(7, 'Knuth', 'Donald', 'dknuth', '$2y$10$TLsBum/NSyJwX/vxAEKJeeE20arY3ILNIHEkC3.sckNUVNtvVz5kS', 'user', b'1'),
(8, NULL, NULL, 'test2', '$2y$10$t812JaGkKeUGSPW2O217lOQ8JbzRg65U7nYH17bO.cAmC8jFf2he2', 'user', b'0');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `etudiants`
--
ALTER TABLE `etudiants`
  ADD PRIMARY KEY (`eid`);

--
-- Indexes for table `gestionnaires`
--
ALTER TABLE `gestionnaires`
  ADD PRIMARY KEY (`gid`);

--
-- Indexes for table `notes`
--
ALTER TABLE `notes`
  ADD PRIMARY KEY (`nid`),
  ADD KEY `sid` (`sid`);

--
-- Indexes for table `soutenances`
--
ALTER TABLE `soutenances`
  ADD PRIMARY KEY (`stid`),
  ADD KEY `eid` (`sid`),
  ADD KEY `tuteur1` (`tuteur1`),
  ADD KEY `tuteur2` (`tuteur2`);

--
-- Indexes for table `stages`
--
ALTER TABLE `stages`
  ADD PRIMARY KEY (`sid`),
  ADD UNIQUE KEY `eid` (`eid`),
  ADD KEY `tuteurP` (`tuteurP`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`uid`),
  ADD UNIQUE KEY `login` (`login`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `etudiants`
--
ALTER TABLE `etudiants`
  MODIFY `eid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `gestionnaires`
--
ALTER TABLE `gestionnaires`
  MODIFY `gid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `notes`
--
ALTER TABLE `notes`
  MODIFY `nid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `soutenances`
--
ALTER TABLE `soutenances`
  MODIFY `stid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `stages`
--
ALTER TABLE `stages`
  MODIFY `sid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `uid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `notes`
--
ALTER TABLE `notes`
  ADD CONSTRAINT `notes_ibfk_1` FOREIGN KEY (`sid`) REFERENCES `stages` (`sid`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `soutenances`
--
ALTER TABLE `soutenances`
  ADD CONSTRAINT `soutenances_ibfk_2` FOREIGN KEY (`tuteur1`) REFERENCES `users` (`uid`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `soutenances_ibfk_3` FOREIGN KEY (`tuteur2`) REFERENCES `users` (`uid`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `soutenances_ibfk_4` FOREIGN KEY (`sid`) REFERENCES `stages` (`sid`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `stages`
--
ALTER TABLE `stages`
  ADD CONSTRAINT `stages_ibfk_1` FOREIGN KEY (`eid`) REFERENCES `etudiants` (`eid`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `stages_ibfk_2` FOREIGN KEY (`tuteurP`) REFERENCES `users` (`uid`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
