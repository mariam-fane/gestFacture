-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : ven. 10 déc. 2021 à 16:30
-- Version du serveur :  10.4.13-MariaDB
-- Version de PHP : 7.4.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `mariam`
--

-- --------------------------------------------------------

--
-- Structure de la table `client`
--

CREATE TABLE `client` (
  `num_clt` int(11) NOT NULL,
  `nomclt` varchar(90) DEFAULT NULL,
  `prenomclt` varchar(90) DEFAULT NULL,
  `adresseclt` varchar(80) DEFAULT NULL,
  `contactclt` varchar(70) DEFAULT NULL,
  `emailclt` varchar(60) DEFAULT NULL,
  `date_ajout` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `client`
--

INSERT INTO `client` (`num_clt`, `nomclt`, `prenomclt`, `adresseclt`, `contactclt`, `emailclt`, `date_ajout`) VALUES
(5, 'diane   ', 'Bakary', NULL, '595   ', 'x@f.com', '2021-12-06 15:41:56'),
(6, 'Fane', 'Mariam', NULL, '59522', 'xfc@f.com', '2021-12-06 15:41:56'),
(7, 'Coulibaly', 'Aly5', 'zz5', '5952285', 'xfc@df.com', '2021-12-05 15:41:56');

-- --------------------------------------------------------

--
-- Structure de la table `contenir`
--

CREATE TABLE `contenir` (
  `id` int(11) NOT NULL,
  `id_fact` int(11) NOT NULL,
  `id_article` int(11) NOT NULL,
  `prix` int(11) NOT NULL,
  `qte` int(11) NOT NULL,
  `montant` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `contenir`
--

INSERT INTO `contenir` (`id`, `id_fact`, `id_article`, `prix`, `qte`, `montant`) VALUES
(1, 1, 2, 100, 1, 100),
(2, 1, 1, 200, 1, 200),
(3, 1, 6, 266, 1, 266),
(4, 2, 2, 100, 1, 100),
(5, 2, 1, 200, 1, 200),
(6, 2, 6, 266, 1, 266),
(7, 3, 1, 200, 1, 200),
(8, 4, 1, 200, 1, 200),
(9, 5, 2, 100, 1, 100),
(10, 6, 6, 266, 1, 266),
(12, 8, 1, 200, 1, 200),
(13, 8, 6, 266, 2, 532),
(14, 8, 11, 255, 1, 255),
(15, 9, 8, 5000, 1, 5000),
(16, 9, 11, 255, 1, 255),
(17, 9, 5, 266, 1, 266),
(18, 9, 2, 100, 1, 100),
(19, 10, 9, 7500, 3, 22500),
(20, 10, 12, 10000, 4, 40000),
(21, 10, 8, 3000, 2, 6000),
(22, 11, 2, 300, 1, 300),
(23, 11, 6, 15000, 3, 45000),
(24, 11, 7, 25000, 1, 25000),
(30, 14, 1, 7000, 1, 7000),
(31, 14, 2, 300, 1, 300),
(32, 15, 1, 7000, 1, 7000),
(33, 15, 2, 400, 1, 400);

-- --------------------------------------------------------

--
-- Structure de la table `facture`
--

CREATE TABLE `facture` (
  `num_facture` int(11) NOT NULL,
  `type_fact` varchar(50) NOT NULL,
  `date_fact` date DEFAULT NULL,
  `num_clt` int(11) NOT NULL,
  `ht` int(11) NOT NULL,
  `tva` int(11) DEFAULT 0,
  `ttc` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `facture`
--

INSERT INTO `facture` (`num_facture`, `type_fact`, `date_fact`, `num_clt`, `ht`, `tva`, `ttc`) VALUES
(1, 'Facture', '2021-12-01', 5, 566, 18, 668),
(2, 'Facture', '2021-12-01', 5, 566, 0, 0),
(3, 'Facture', '2021-12-01', 7, 200, 20, 240),
(4, 'Facture', '2021-12-01', 7, 200, 20, 240),
(5, 'Facture', '2021-12-02', 5, 100, 0, 0),
(6, 'Facture', '2021-12-02', 6, 266, 0, 0),
(8, 'Facture Proforma', '2021-12-24', 7, 987, 18, 1165),
(9, 'Facture', '2021-12-02', 6, 5621, 0, 0),
(10, 'Facture Proforma', '2021-12-02', 7, 68500, 18, 73750),
(11, 'Facture', '2021-12-03', 5, 70300, 0, 0),
(14, 'Facture', '2021-12-06', 7, 7300, 0, 0),
(15, 'Facture', '2021-12-09', 7, 7400, 0, 0);

-- --------------------------------------------------------

--
-- Structure de la table `produit`
--

CREATE TABLE `produit` (
  `refProduit` int(11) NOT NULL,
  `designation` varchar(90) DEFAULT NULL,
  `prix_intial` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `produit`
--

INSERT INTO `produit` (`refProduit`, `designation`, `prix_intial`) VALUES
(1, 'Instalation win7', 7000),
(2, 'Saisie', 400),
(5, 'Maintenance imprimante', 5000),
(6, 'Installation camera surveillance', 15000),
(7, 'Installation réseau wifi', 25000),
(8, 'Instalation win10', 5000),
(9, 'Antivirus', 7500),
(11, 'Site web', 200000),
(12, 'Maintenance ordinateur', 10000),
(15, 'Instalation win8', 7500),
(16, 'AAAAAA', 5555);

-- --------------------------------------------------------

--
-- Structure de la table `user`
--

CREATE TABLE `user` (
  `id_user` int(11) NOT NULL,
  `nom_user` varchar(100) NOT NULL,
  `prenom_user` varchar(100) NOT NULL,
  `email_user` varchar(2500) NOT NULL,
  `mdp_user` varchar(2500) NOT NULL,
  `droit_user` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `user`
--

INSERT INTO `user` (`id_user`, `nom_user`, `prenom_user`, `email_user`, `mdp_user`, `droit_user`) VALUES
(1, 'Samaké', 'Bakary', 'samak@gmail.com', '7c4a8d09ca3762af61e59520943dc26494f8941b', 'Gestionnaire'),
(2, 'Fane', 'Mariam', 'mariam@gmail.com', '7c4a8d09ca3762af61e59520943dc26494f8941b', 'Admin');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `client`
--
ALTER TABLE `client`
  ADD PRIMARY KEY (`num_clt`);

--
-- Index pour la table `contenir`
--
ALTER TABLE `contenir`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_article` (`id_article`),
  ADD KEY `id_fact` (`id_fact`);

--
-- Index pour la table `facture`
--
ALTER TABLE `facture`
  ADD PRIMARY KEY (`num_facture`),
  ADD KEY `num_clt` (`num_clt`);

--
-- Index pour la table `produit`
--
ALTER TABLE `produit`
  ADD PRIMARY KEY (`refProduit`);

--
-- Index pour la table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id_user`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `client`
--
ALTER TABLE `client`
  MODIFY `num_clt` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT pour la table `contenir`
--
ALTER TABLE `contenir`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT pour la table `facture`
--
ALTER TABLE `facture`
  MODIFY `num_facture` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT pour la table `produit`
--
ALTER TABLE `produit`
  MODIFY `refProduit` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT pour la table `user`
--
ALTER TABLE `user`
  MODIFY `id_user` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `contenir`
--
ALTER TABLE `contenir`
  ADD CONSTRAINT `contenir_ibfk_1` FOREIGN KEY (`id_article`) REFERENCES `produit` (`refProduit`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `contenir_ibfk_2` FOREIGN KEY (`id_fact`) REFERENCES `facture` (`num_facture`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `facture`
--
ALTER TABLE `facture`
  ADD CONSTRAINT `facture_ibfk_1` FOREIGN KEY (`num_clt`) REFERENCES `client` (`num_clt`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
