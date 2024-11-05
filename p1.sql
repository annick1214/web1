-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : ven. 18 oct. 2024 à 15:20
-- Version du serveur : 10.4.32-MariaDB
-- Version de PHP : 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `p1`
--

-- --------------------------------------------------------

--
-- Structure de la table `attribution`
--

CREATE TABLE `attribution` (
  `idAttribution` int(11) NOT NULL,
  `dateEnd` date DEFAULT NULL,
  `statutAttribution` enum('en cours','terminer') NOT NULL,
  `idMaterielle` int(11) NOT NULL,
  `idSite` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Déchargement des données de la table `attribution`
--



-- --------------------------------------------------------

--
-- Structure de la table `categoriematerielle`
--

CREATE TABLE `categoriematerielle` (
  `idCategorie` int(11) NOT NULL,
  `nomCategorie` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Déchargement des données de la table `categoriematerielle`
--


-- --------------------------------------------------------

--
-- Structure de la table `eleve`
--

CREATE TABLE `eleve` (
  `ideleve` int(11) NOT NULL,
  `matriculeeleve` varchar(15) DEFAULT NULL,
  `nomeleve` varchar(30) NOT NULL,
  `prenomeleve` varchar(100) NOT NULL,
  `datenaissance` date NOT NULL,
  `sexe` text DEFAULT NULL,
  `statut` text DEFAULT NULL,
  `site` text DEFAULT NULL,
  `dateAdd` datetime NOT NULL DEFAULT current_timestamp(),
  `contacteleve` text DEFAULT NULL,
  `idmoyenne` int(11) DEFAULT NULL,
  `idpaye` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Déchargement des données de la table `eleve`
--


-- --------------------------------------------------------

--
-- Structure de la table `moyenne`
--

CREATE TABLE `moyenne` (
  `idmoyenne` int(11) NOT NULL,
  `moyenne` float NOT NULL,
  `ideleve` int(15) NOT NULL,
  `matriculeeleve` varchar(25) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Déchargement des données de la table `moyenne`
--


-- --------------------------------------------------------

--
-- Structure de la table `moyenne0`
--

--
-- Déchargement des données de la table `moyenne0`
--


-- --------------------------------------------------------

--
-- Structure de la table `paye`
--

CREATE TABLE `paye` (
  `idpaye` int(11) NOT NULL,
  `montant` varchar(100) NOT NULL,
  `ideleve` int(15) NOT NULL,
  `matriculeeleve` varchar(25) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Déchargement des données de la table `paye`
--



-- --------------------------------------------------------

--
-- Structure de la table `ressourcematerielle`
--

CREATE TABLE `ressourcematerielle` (
  `idMaterielle` int(11) NOT NULL,
  `codeMaterielle` varchar(15) DEFAULT NULL,
  `nomMaterielle` varchar(50) DEFAULT NULL,
  `typeMaterielle` int(11) NOT NULL,
  `descriptionMaterielle` varchar(255) NOT NULL,
  `etatMaterielle` varchar(50) NOT NULL DEFAULT '',
  `statutMaterielle` enum('disponible','indisponible') NOT NULL,
  `dateAdd` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Déchargement des données de la table `ressourcematerielle`
--


-- --------------------------------------------------------

--
-- Structure de la table `site`
--

CREATE TABLE `site` (
  `idSite` int(11) NOT NULL,
  `nomSite` varchar(30) NOT NULL,
  `contactSite` varchar(30) NOT NULL,
  `emailSite` varchar(30) NOT NULL,
  `adresseSite` varchar(100) NOT NULL,
  `cover` varchar(255) DEFAULT NULL,
  `dateCreat` date DEFAULT NULL,
  `idUtilisateur` int(11) DEFAULT NULL,
  `ideleve` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Déchargement des données de la table `site`
--


-- --------------------------------------------------------

--
-- Structure de la table `utilisateur`
--

CREATE TABLE `utilisateur` (
  `idUtilisateur` int(11) NOT NULL,
  `nomUtilisateur` varchar(30) NOT NULL,
  `prenomUtilisateur` varchar(100) NOT NULL,
  `contactUtilisateur` text DEFAULT NULL,
  `emailUtilisateur` varchar(30) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('client','cm','gs','admin') NOT NULL,
  `photoUtilisateur` varchar(255) DEFAULT NULL,
  `dateAdd` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Déchargement des données de la table `utilisateur`
--


--
-- Index pour les tables déchargées
--

--
-- Index pour la table `attribution`
--
ALTER TABLE `attribution`
  ADD PRIMARY KEY (`idAttribution`),
  ADD KEY `idMaterielle` (`idMaterielle`),
  ADD KEY `idSite` (`idSite`);

--
-- Index pour la table `categoriematerielle`
--
ALTER TABLE `categoriematerielle`
  ADD PRIMARY KEY (`idCategorie`);

--
-- Index pour la table `eleve`
--
ALTER TABLE `eleve`
  ADD PRIMARY KEY (`ideleve`),
  ADD KEY `idpaye` (`idpaye`);

--
-- Index pour la table `moyenne`
--
ALTER TABLE `moyenne`
  ADD PRIMARY KEY (`idmoyenne`),
  ADD KEY `ideleve` (`ideleve`,`matriculeeleve`);

--
-- Index pour la table `moyenne0`
--
ALTER TABLE `moyenne0`
  ADD PRIMARY KEY (`idmoyenne`),
  ADD KEY `matriculeeleve` (`matriculeeleve`),
  ADD KEY `ideleve` (`ideleve`),
  ADD KEY `contacteleve` (`contacteleve`(1024));

--
-- Index pour la table `paye`
--
ALTER TABLE `paye`
  ADD PRIMARY KEY (`idpaye`),
  ADD KEY `ideleve` (`ideleve`,`matriculeeleve`);

--
-- Index pour la table `ressourcematerielle`
--
ALTER TABLE `ressourcematerielle`
  ADD PRIMARY KEY (`idMaterielle`),
  ADD KEY `typeMaterielle` (`typeMaterielle`);

--
-- Index pour la table `site`
--
ALTER TABLE `site`
  ADD PRIMARY KEY (`idSite`) USING BTREE,
  ADD KEY `idUtilisateur` (`idUtilisateur`),
  ADD KEY `ideleve` (`ideleve`);

--
-- Index pour la table `utilisateur`
--
ALTER TABLE `utilisateur`
  ADD PRIMARY KEY (`idUtilisateur`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `attribution`
--
ALTER TABLE `attribution`
  MODIFY `idAttribution` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT pour la table `categoriematerielle`
--
ALTER TABLE `categoriematerielle`
  MODIFY `idCategorie` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT pour la table `eleve`
--
ALTER TABLE `eleve`
  MODIFY `ideleve` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT pour la table `moyenne`
--
ALTER TABLE `moyenne`
  MODIFY `idmoyenne` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT pour la table `moyenne0`
--
ALTER TABLE `moyenne0`
  MODIFY `idmoyenne` int(50) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT pour la table `paye`
--
ALTER TABLE `paye`
  MODIFY `idpaye` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=105;

--
-- AUTO_INCREMENT pour la table `ressourcematerielle`
--
ALTER TABLE `ressourcematerielle`
  MODIFY `idMaterielle` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT pour la table `site`
--
ALTER TABLE `site`
  MODIFY `idSite` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT pour la table `utilisateur`
--
ALTER TABLE `utilisateur`
  MODIFY `idUtilisateur` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `attribution`
--
ALTER TABLE `attribution`
  ADD CONSTRAINT `attribution_ibfk_2` FOREIGN KEY (`idMaterielle`) REFERENCES `ressourcematerielle` (`idMaterielle`),
  ADD CONSTRAINT `attribution_ibfk_3` FOREIGN KEY (`idSite`) REFERENCES `site` (`idSite`),
  ADD CONSTRAINT `attribution_ibfk_4` FOREIGN KEY (`idSite`) REFERENCES `site` (`idSite`);

--
-- Contraintes pour la table `eleve`
--
ALTER TABLE `eleve`
  ADD CONSTRAINT `eleve_ibfk_3` FOREIGN KEY (`idmoyenne`) REFERENCES `moyenne` (`idmoyenne`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `eleve_ibfk_4` FOREIGN KEY (`idpaye`) REFERENCES `paye` (`idpaye`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Contraintes pour la table `ressourcematerielle`
--
ALTER TABLE `ressourcematerielle`
  ADD CONSTRAINT `ressourcematerielle_ibfk_1` FOREIGN KEY (`typeMaterielle`) REFERENCES `categoriematerielle` (`idCategorie`);

--
-- Contraintes pour la table `site`
--
ALTER TABLE `site`
  ADD CONSTRAINT `site_ibfk_1` FOREIGN KEY (`idUtilisateur`) REFERENCES `utilisateur` (`idUtilisateur`),
  ADD CONSTRAINT `site_ibfk_2` FOREIGN KEY (`ideleve`) REFERENCES `eleve` (`ideleve`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
