-- phpMyAdmin SQL Dump
-- version 4.1.14
-- http://www.phpmyadmin.net
--
-- Client :  127.0.0.1
-- Généré le :  Mar 14 Juillet 2015 à 15:18
-- Version du serveur :  5.6.17
-- Version de PHP :  5.5.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de données :  `gelm`
--

-- --------------------------------------------------------

--
-- Structure de la table `t_caisse_entrees`
--

CREATE TABLE IF NOT EXISTS `t_caisse_entrees` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `montant` decimal(12,2) DEFAULT NULL,
  `designation` varchar(255) DEFAULT NULL,
  `dateOperation` date DEFAULT NULL,
  `utilisateur` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=7 ;

--
-- Contenu de la table `t_caisse_entrees`
--

INSERT INTO `t_caisse_entrees` (`id`, `montant`, `designation`, `dateOperation`, `utilisateur`) VALUES
(6, '1000.00', 'R&eacute;sidence Dawliz', '2015-07-14', 'abdessamad');

-- --------------------------------------------------------

--
-- Structure de la table `t_caisse_sorties`
--

CREATE TABLE IF NOT EXISTS `t_caisse_sorties` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `montant` decimal(12,2) DEFAULT NULL,
  `designation` varchar(255) DEFAULT NULL,
  `dateOperation` date DEFAULT NULL,
  `destination` varchar(255) DEFAULT NULL,
  `utilisateur` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=6 ;

-- --------------------------------------------------------

--
-- Structure de la table `t_cheque`
--

CREATE TABLE IF NOT EXISTS `t_cheque` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `dateCheque` date DEFAULT NULL,
  `numero` varchar(100) DEFAULT NULL,
  `designationSociete` varchar(100) DEFAULT NULL,
  `designationPersonne` varchar(100) DEFAULT NULL,
  `montant` decimal(12,2) DEFAULT NULL,
  `statut` varchar(50) DEFAULT NULL,
  `url` text,
  `idProjet` int(12) DEFAULT NULL,
  `createdBy` varchar(50) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

--
-- Contenu de la table `t_cheque`
--

INSERT INTO `t_cheque` (`id`, `dateCheque`, `numero`, `designationSociete`, `designationPersonne`, `montant`, `statut`, `url`, `idProjet`, `createdBy`, `created`) VALUES
(1, '2015-07-12', '1205f200', 'SoufiPasta', '', '12000.00', 'Annul&eacute;', '../GELM/pieces/pieces_cheque/55a500de56316cheq1.png', 1, 'abdessamad', '0000-00-00 00:00:00'),
(2, '2015-07-14', 'aze120555', 'JimilCo', '', '500000.00', 'D&eacute;pos&eacute;', '../GELM/pieces/pieces_cheque/55a500b26572dcheq1.png', 1, 'abdessamad', '0000-00-00 00:00:00'),
(3, '2015-07-14', '8795000az', 'Briconad', 'Mohamed Zlij', '14500.00', 'En cours', '../GELM/pieces/pieces_cheque/55a500de56316cheq1.png', 1, 'abdessamad', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Structure de la table `t_contrattravail`
--

CREATE TABLE IF NOT EXISTS `t_contrattravail` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nom` varchar(255) DEFAULT NULL,
  `dateNaissance` date DEFAULT NULL,
  `cin` varchar(45) DEFAULT NULL,
  `adresse` text,
  `matiere` varchar(100) DEFAULT NULL,
  `prix` decimal(12,2) DEFAULT NULL,
  `mesure` float DEFAULT NULL,
  `prixTotal` decimal(12,2) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Structure de la table `t_fournisseur`
--

CREATE TABLE IF NOT EXISTS `t_fournisseur` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nom` varchar(255) DEFAULT NULL,
  `adresse` varchar(255) DEFAULT NULL,
  `email` varchar(50) DEFAULT NULL,
  `telephone1` varchar(45) DEFAULT NULL,
  `telephone2` varchar(45) DEFAULT NULL,
  `fax` varchar(45) DEFAULT NULL,
  `dateCreation` date DEFAULT NULL,
  `code` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=22 ;

--
-- Contenu de la table `t_fournisseur`
--

INSERT INTO `t_fournisseur` (`id`, `nom`, `adresse`, `email`, `telephone1`, `telephone2`, `fax`, `dateCreation`, `code`) VALUES
(21, 'Amin Bouzit', 'Al Boustane', '', '0536660021', '', '', '2015-07-12', '55a25b2c2569a20150712141852');

-- --------------------------------------------------------

--
-- Structure de la table `t_livraison`
--

CREATE TABLE IF NOT EXISTS `t_livraison` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `libelle` varchar(50) NOT NULL,
  `designation` text NOT NULL,
  `quantite` int(11) NOT NULL,
  `prixUnitaire` decimal(10,2) NOT NULL,
  `paye` decimal(10,2) NOT NULL,
  `reste` decimal(10,2) NOT NULL,
  `dateLivraison` date NOT NULL,
  `modePaiement` varchar(50) NOT NULL,
  `idFournisseur` int(11) NOT NULL,
  `idProjet` int(11) NOT NULL,
  `code` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=36 ;

--
-- Contenu de la table `t_livraison`
--

INSERT INTO `t_livraison` (`id`, `libelle`, `designation`, `quantite`, `prixUnitaire`, `paye`, `reste`, `dateLivraison`, `modePaiement`, `idFournisseur`, `idProjet`, `code`) VALUES
(35, 'LB100', '', 0, '0.00', '0.00', '0.00', '2015-07-12', '', 21, 1, '55a25c118f66520150712142241');

-- --------------------------------------------------------

--
-- Structure de la table `t_livraison_detail`
--

CREATE TABLE IF NOT EXISTS `t_livraison_detail` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `libelle` varchar(255) DEFAULT NULL,
  `designation` text,
  `prixUnitaire` decimal(12,2) DEFAULT NULL,
  `quantite` decimal(12,2) DEFAULT NULL,
  `idLivraison` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=12 ;

--
-- Contenu de la table `t_livraison_detail`
--

INSERT INTO `t_livraison_detail` (`id`, `libelle`, `designation`, `prixUnitaire`, `quantite`, `idLivraison`) VALUES
(10, NULL, 'beton', '100.00', '100.00', 35),
(11, '', 'granit', '10.00', '120.00', 35);

-- --------------------------------------------------------

--
-- Structure de la table `t_mail`
--

CREATE TABLE IF NOT EXISTS `t_mail` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `content` text NOT NULL,
  `sender` varchar(50) NOT NULL,
  `created` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=25 ;

--
-- Contenu de la table `t_mail`
--

INSERT INTO `t_mail` (`id`, `content`, `sender`, `created`) VALUES
(24, 'test', 'abdessamad', '2015-07-06 17:57:23');

-- --------------------------------------------------------

--
-- Structure de la table `t_piecesprojet`
--

CREATE TABLE IF NOT EXISTS `t_piecesprojet` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `url` varchar(255) DEFAULT NULL,
  `description` text,
  `idProjet` int(12) DEFAULT NULL,
  `createdBy` varchar(100) DEFAULT NULL,
  `created` date DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=11 ;

--
-- Contenu de la table `t_piecesprojet`
--

INSERT INTO `t_piecesprojet` (`id`, `url`, `description`, `idProjet`, `createdBy`, `created`) VALUES
(8, '../GELM/pieces/pieces_projet/55a257382c859plan2D.jpg', '', 1, 'abdessamad', '2015-07-12'),
(10, '../GELM/pieces/pieces_projet/55a257f274758plan3d.jpg', '', 1, 'abdessamad', '2015-07-12');

-- --------------------------------------------------------

--
-- Structure de la table `t_piecessociete`
--

CREATE TABLE IF NOT EXISTS `t_piecessociete` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `url` text,
  `description` text,
  `idSociete` int(12) DEFAULT NULL,
  `createdBy` varchar(100) DEFAULT NULL,
  `created` date DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=12 ;

--
-- Contenu de la table `t_piecessociete`
--

INSERT INTO `t_piecessociete` (`id`, `url`, `description`, `idSociete`, `createdBy`, `created`) VALUES
(2, '../GELM/pieces/pieces_societe/559d60fc38e61cheq1.png', 'ch&egrave;que ', 2, 'abdessamad', '2015-07-08'),
(6, '../GELM/pieces/pieces_societe/559e74d2329dc13-CONTREFACON.jpg', 'Titre\r\n', 2, 'abdessamad', '2015-07-09'),
(7, '../GELM/pieces/pieces_societe/559e74e89783ecertificat titre.jpg', 'Certificat Titre', 2, 'abdessamad', '2015-07-09');

-- --------------------------------------------------------

--
-- Structure de la table `t_projet`
--

CREATE TABLE IF NOT EXISTS `t_projet` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nom` varchar(255) DEFAULT NULL,
  `numeroTitre` text,
  `emplacement` varchar(255) DEFAULT NULL,
  `superficie` varchar(50) DEFAULT NULL,
  `description` text,
  `dateCreation` date DEFAULT NULL,
  `createdBy` varchar(100) DEFAULT NULL,
  `created` date DEFAULT NULL,
  `idSociete` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Contenu de la table `t_projet`
--

INSERT INTO `t_projet` (`id`, `nom`, `numeroTitre`, `emplacement`, `superficie`, `description`, `dateCreation`, `createdBy`, `created`, `idSociete`) VALUES
(1, 'R&eacute;sidence DAWLIZE', 'azer1221z', 'Al Matar', '550', 'R&eacute;sidence de haute qualit&eacute;', '2005-07-13', NULL, NULL, 2);

-- --------------------------------------------------------

--
-- Structure de la table `t_reglement_fournisseur`
--

CREATE TABLE IF NOT EXISTS `t_reglement_fournisseur` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `montant` decimal(12,2) DEFAULT NULL,
  `dateReglement` date DEFAULT NULL,
  `idProjet` int(11) DEFAULT NULL,
  `idFournisseur` int(11) DEFAULT NULL,
  `modePaiement` varchar(255) DEFAULT NULL,
  `numeroCheque` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=11 ;

--
-- Contenu de la table `t_reglement_fournisseur`
--

INSERT INTO `t_reglement_fournisseur` (`id`, `montant`, `dateReglement`, `idProjet`, `idFournisseur`, `modePaiement`, `numeroCheque`) VALUES
(10, '1200.00', '2015-07-12', 1, 21, 'Especes', '');

-- --------------------------------------------------------

--
-- Structure de la table `t_societe`
--

CREATE TABLE IF NOT EXISTS `t_societe` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `raisonSociale` text,
  `dateCreation` date DEFAULT NULL,
  `createdBy` varchar(100) DEFAULT NULL,
  `created` date DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Contenu de la table `t_societe`
--

INSERT INTO `t_societe` (`id`, `raisonSociale`, `dateCreation`, `createdBy`, `created`) VALUES
(2, 'MarocPromo', '2005-07-13', 'abdessamad', '2008-07-15');

-- --------------------------------------------------------

--
-- Structure de la table `t_user`
--

CREATE TABLE IF NOT EXISTS `t_user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `login` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created` date NOT NULL,
  `profil` varchar(30) NOT NULL,
  `status` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=11 ;

--
-- Contenu de la table `t_user`
--

INSERT INTO `t_user` (`id`, `login`, `password`, `created`, `profil`, `status`) VALUES
(9, 'hassan', 'hassan123', '2015-07-06', 'user', 1),
(10, 'abdessamad', 'abdo123', '2015-07-06', 'admin', 1);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
