-- phpMyAdmin SQL Dump
-- version 4.1.14
-- http://www.phpmyadmin.net
--
-- Client :  127.0.0.1
-- Généré le :  Mar 05 Avril 2016 à 19:11
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
-- Structure de la table `t_appartement`
--

CREATE TABLE IF NOT EXISTS `t_appartement` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `numeroTitre` varchar(255) DEFAULT NULL,
  `nom` varchar(50) DEFAULT NULL,
  `superficie` decimal(12,2) DEFAULT NULL,
  `surplan` decimal(12,2) DEFAULT NULL,
  `prix` decimal(12,2) DEFAULT NULL,
  `niveau` varchar(50) DEFAULT NULL,
  `facade` varchar(50) DEFAULT NULL,
  `nombrePiece` int(11) DEFAULT NULL,
  `status` varchar(50) DEFAULT NULL,
  `cave` varchar(50) DEFAULT NULL,
  `par` varchar(50) DEFAULT NULL,
  `dateReservation` date DEFAULT NULL,
  `idProjet` int(11) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `createdBy` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=178 ;

-- --------------------------------------------------------

--
-- Structure de la table `t_caisse`
--

CREATE TABLE IF NOT EXISTS `t_caisse` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nom` varchar(255) DEFAULT NULL,
  `dateCreation` date DEFAULT NULL,
  `created` date DEFAULT NULL,
  `createdBy` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

-- --------------------------------------------------------

--
-- Structure de la table `t_caissedetails`
--

CREATE TABLE IF NOT EXISTS `t_caissedetails` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `dateOperation` date DEFAULT NULL,
  `personne` varchar(100) DEFAULT NULL,
  `designation` text,
  `projet` varchar(100) DEFAULT NULL,
  `type` varchar(50) DEFAULT NULL,
  `montant` decimal(12,2) DEFAULT NULL,
  `commentaire` text,
  `idCaisse` int(11) DEFAULT NULL,
  `created` date DEFAULT NULL,
  `createdBy` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Structure de la table `t_chargesconstruction`
--

CREATE TABLE IF NOT EXISTS `t_chargesconstruction` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `dateOperation` date DEFAULT NULL,
  `designation` varchar(100) DEFAULT NULL,
  `beneficiaire` varchar(50) DEFAULT NULL,
  `numeroCheque` varchar(255) DEFAULT NULL,
  `montant` decimal(12,2) DEFAULT NULL,
  `idProjet` int(12) DEFAULT NULL,
  `created` date DEFAULT NULL,
  `createdBy` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=82 ;

-- --------------------------------------------------------

--
-- Structure de la table `t_chargesfinition`
--

CREATE TABLE IF NOT EXISTS `t_chargesfinition` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `dateOperation` date DEFAULT NULL,
  `designation` varchar(50) DEFAULT NULL,
  `beneficiaire` varchar(50) DEFAULT NULL,
  `numeroCheque` varchar(255) DEFAULT NULL,
  `montant` decimal(12,2) DEFAULT NULL,
  `idProjet` int(12) DEFAULT NULL,
  `created` date DEFAULT NULL,
  `createdBy` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1498 ;

-- --------------------------------------------------------

--
-- Structure de la table `t_chargesterrain`
--

CREATE TABLE IF NOT EXISTS `t_chargesterrain` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `dateOperation` date DEFAULT NULL,
  `designation` varchar(255) DEFAULT NULL,
  `beneficiaire` varchar(50) DEFAULT NULL,
  `numeroCheque` varchar(255) DEFAULT NULL,
  `montant` decimal(12,2) DEFAULT NULL,
  `idProjet` int(12) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `createdBy` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=58 ;

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
  `idSociete` int(11) NOT NULL,
  `compteBancaire` varchar(255) NOT NULL,
  `createdBy` varchar(50) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=262 ;

-- --------------------------------------------------------

--
-- Structure de la table `t_client`
--

CREATE TABLE IF NOT EXISTS `t_client` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nom` varchar(100) DEFAULT NULL,
  `adresse` varchar(255) DEFAULT NULL,
  `telephone1` varchar(45) DEFAULT NULL,
  `telephone2` varchar(45) DEFAULT NULL,
  `cin` varchar(45) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `facebook` varchar(255) DEFAULT NULL,
  `created` date DEFAULT NULL,
  `code` text,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=275 ;

-- --------------------------------------------------------

--
-- Structure de la table `t_comptebancaire`
--

CREATE TABLE IF NOT EXISTS `t_comptebancaire` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `numero` varchar(255) DEFAULT NULL,
  `idSociete` int(12) DEFAULT NULL,
  `dateCreation` date DEFAULT NULL,
  `createdBy` varchar(50) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=20 ;

-- --------------------------------------------------------

--
-- Structure de la table `t_contrat`
--

CREATE TABLE IF NOT EXISTS `t_contrat` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `numero` varchar(255) DEFAULT NULL,
  `dateCreation` date DEFAULT NULL,
  `dateRetour` date DEFAULT NULL,
  `prixVente` decimal(12,2) DEFAULT NULL,
  `avance` decimal(12,2) DEFAULT NULL,
  `taille` decimal(12,2) DEFAULT NULL,
  `modePaiement` varchar(255) DEFAULT NULL,
  `dureePaiement` int(11) DEFAULT NULL,
  `echeance` decimal(12,2) DEFAULT NULL,
  `note` text,
  `idClient` int(11) DEFAULT NULL,
  `idProjet` int(11) DEFAULT NULL,
  `idBien` int(11) DEFAULT NULL,
  `typeBien` varchar(255) DEFAULT NULL,
  `code` varchar(255) DEFAULT NULL,
  `status` varchar(255) DEFAULT NULL,
  `numeroCheque` varchar(255) DEFAULT NULL,
  `nomClient` varchar(255) DEFAULT NULL,
  `adresse` text,
  `cin` varchar(50) DEFAULT NULL,
  `telephone` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=392 ;

-- --------------------------------------------------------

--
-- Structure de la table `t_contratdetails`
--

CREATE TABLE IF NOT EXISTS `t_contratdetails` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `dateOperation` date DEFAULT NULL,
  `montant` decimal(12,2) DEFAULT NULL,
  `numeroCheque` varchar(100) DEFAULT NULL,
  `idContratEmploye` int(12) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `createdBy` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=101 ;

-- --------------------------------------------------------

--
-- Structure de la table `t_contratemploye`
--

CREATE TABLE IF NOT EXISTS `t_contratemploye` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `dateContrat` date DEFAULT NULL,
  `prixUnitaire` decimal(12,2) DEFAULT NULL,
  `nombreUnites` decimal(10,2) DEFAULT NULL,
  `total` decimal(12,2) DEFAULT NULL,
  `employe` varchar(100) DEFAULT NULL,
  `idProjet` int(12) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `createdBy` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=31 ;

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
-- Structure de la table `t_employe`
--

CREATE TABLE IF NOT EXISTS `t_employe` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nom` varchar(50) DEFAULT NULL,
  `cin` varchar(50) DEFAULT NULL,
  `adresse` varchar(255) DEFAULT NULL,
  `telephone` varchar(50) DEFAULT NULL,
  `dateCreation` date DEFAULT NULL,
  `created` date DEFAULT NULL,
  `createdBy` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=27 ;

-- --------------------------------------------------------

--
-- Structure de la table `t_fournisseur`
--

CREATE TABLE IF NOT EXISTS `t_fournisseur` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nom` varchar(255) DEFAULT NULL,
  `societe` varchar(255) DEFAULT NULL,
  `adresse` varchar(255) DEFAULT NULL,
  `email` varchar(50) DEFAULT NULL,
  `telephone1` varchar(45) DEFAULT NULL,
  `telephone2` varchar(45) DEFAULT NULL,
  `fax` varchar(45) DEFAULT NULL,
  `dateCreation` date DEFAULT NULL,
  `code` varchar(255) DEFAULT NULL,
  `nature` text,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=45 ;

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
  `url` text,
  `status` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=326 ;

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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=359 ;

-- --------------------------------------------------------

--
-- Structure de la table `t_locaux`
--

CREATE TABLE IF NOT EXISTS `t_locaux` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `numeroTitre` varchar(100) DEFAULT NULL,
  `nom` varchar(50) DEFAULT NULL,
  `superficie` decimal(12,2) DEFAULT NULL,
  `surplan` decimal(12,2) DEFAULT NULL,
  `facade` varchar(50) DEFAULT NULL,
  `prix` decimal(12,2) DEFAULT NULL,
  `mezzanine` varchar(50) DEFAULT NULL,
  `status` varchar(50) DEFAULT NULL,
  `idProjet` int(12) DEFAULT NULL,
  `createdBy` varchar(50) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=48 ;

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
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=28 ;

-- --------------------------------------------------------

--
-- Structure de la table `t_maison`
--

CREATE TABLE IF NOT EXISTS `t_maison` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `numeroTitre` varchar(100) DEFAULT NULL,
  `nom` varchar(50) DEFAULT NULL,
  `superficie` decimal(12,2) DEFAULT NULL,
  `surplan` decimal(12,2) DEFAULT NULL,
  `prix` decimal(12,2) DEFAULT NULL,
  `emplacement` varchar(255) DEFAULT NULL,
  `status` varchar(50) DEFAULT NULL,
  `nombreEtage` varchar(20) DEFAULT NULL,
  `idProjet` int(12) DEFAULT NULL,
  `created` date DEFAULT NULL,
  `createdBy` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=30 ;

-- --------------------------------------------------------

--
-- Structure de la table `t_operation`
--

CREATE TABLE IF NOT EXISTS `t_operation` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `date` date DEFAULT NULL,
  `montant` decimal(12,2) DEFAULT NULL,
  `modePaiement` varchar(255) DEFAULT NULL,
  `idContrat` int(11) DEFAULT NULL,
  `numeroCheque` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1296 ;

-- --------------------------------------------------------

--
-- Structure de la table `t_paiementemploye`
--

CREATE TABLE IF NOT EXISTS `t_paiementemploye` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `dateOperation` date DEFAULT NULL,
  `montant` decimal(12,2) DEFAULT NULL,
  `numeroCheque` varchar(50) DEFAULT NULL,
  `idProjet` int(12) DEFAULT NULL,
  `idEmploye` int(12) DEFAULT NULL,
  `created` date DEFAULT NULL,
  `createdBy` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=67 ;

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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=47 ;

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
  `status` varchar(50) DEFAULT NULL,
  `createdBy` varchar(100) DEFAULT NULL,
  `created` date DEFAULT NULL,
  `idSociete` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=26 ;

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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=11 ;

-- --------------------------------------------------------

--
-- Structure de la table `t_terrain`
--

CREATE TABLE IF NOT EXISTS `t_terrain` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `numeroTitre` varchar(100) DEFAULT NULL,
  `nom` varchar(50) DEFAULT NULL,
  `superficie` decimal(12,2) DEFAULT NULL,
  `surplan` decimal(12,2) DEFAULT NULL,
  `emplacement` varchar(255) DEFAULT NULL,
  `status` varchar(50) DEFAULT NULL,
  `prix` decimal(12,2) DEFAULT NULL,
  `idProjet` int(12) DEFAULT NULL,
  `created` date DEFAULT NULL,
  `createdBy` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

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
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=14 ;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
