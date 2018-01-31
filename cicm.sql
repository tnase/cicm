-- phpMyAdmin SQL Dump
-- version 4.5.5.1
-- http://www.phpmyadmin.net
--
-- Client :  127.0.0.1
-- Généré le :  Mar 09 Janvier 2018 à 19:34
-- Version du serveur :  5.7.11
-- Version de PHP :  5.6.19

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `cicm`
--

-- --------------------------------------------------------

--
-- Structure de la table `calendrier`
--

CREATE TABLE `calendrier` (
  `bgcolor` varchar(25) NOT NULL,
  `cni_personne` varchar(100) NOT NULL,
  `date_attribution_service` varchar(25) NOT NULL,
  `date_liberation_service` varchar(25) NOT NULL,
  `id` bigint(20) UNSIGNED NOT NULL,
  `annee` varchar(10) NOT NULL,
  `code_service` varchar(100) NOT NULL,
  `categorie` varchar(100) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Contenu de la table `calendrier`
--

INSERT INTO `calendrier` (`bgcolor`, `cni_personne`, `date_attribution_service`, `date_liberation_service`, `id`, `annee`, `code_service`, `categorie`) VALUES
('930108', '111546378', '14/10/2017', '25/10/2017', 462, '2017', '40.8-15', 'chambre'),
('522366', '789456512', '30/10/2017', '09/11/2017', 463, '2017', '40.8-15', 'chambre'),
('559797', '789456512', '10/10/2017', '12/10/2017', 464, '2017', '40.8-15', 'chambre'),
('730048', '111409898', '02/10/2017', '09/10/2017', 461, '2017', '40.8-15', 'chambre'),
('973083', '111785474', '27/09/2017', '28/09/2017', 460, '2017', '40.8-15', 'chambre'),
('231756', '111409898', '11/01/2018', '22/01/2018', 465, '2018', '40.28-20', 'chambre'),
('1039875', '111409898', '06/01/2018', '08/01/2018', 466, '2018', 'GS.F-200', 'salle'),
('1069155', '123654321', '07/01/2018', '09/01/2018', 467, '2018', '40.8-15', 'chambre'),
('637077', '789456512', '11/01/2018', '06/02/2018', 468, '2018', '40.8-15', 'chambre'),
('685362', '789456512', '07/01/2018', '10/01/2018', 469, '2018', 'PS-10', 'salle'),
('450184', '111785474', '10/01/2018', '10/01/2018', 470, '2018', '40.8-15', 'chambre'),
('708755', '111785474', '11/01/2018', '12/01/2018', 471, '2018', '40.9-15', 'chambre'),
('727584', '111785474', '09/01/2018', '10/01/2018', 472, '2018', '40.9-15', 'chambre');

-- --------------------------------------------------------

--
-- Structure de la table `journalisation`
--

CREATE TABLE `journalisation` (
  `code_journalisation` varchar(100) NOT NULL,
  `information` text NOT NULL,
  `adresse_ip` varchar(50) NOT NULL,
  `CNI` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `personne`
--

CREATE TABLE `personne` (
  `cni_personne` int(11) NOT NULL,
  `nom_personne` varchar(50) NOT NULL,
  `nationalite` varchar(50) NOT NULL,
  `sexe` varchar(50) NOT NULL,
  `photo` varchar(100) NOT NULL,
  `vehicules` text NOT NULL,
  `contact` int(11) NOT NULL,
  `login` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `don` text NOT NULL,
  `email` varchar(255) DEFAULT NULL,
  `categorie` varchar(50) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Contenu de la table `personne`
--

INSERT INTO `personne` (`cni_personne`, `nom_personne`, `nationalite`, `sexe`, `photo`, `vehicules`, `contact`, `login`, `password`, `don`, `email`, `categorie`) VALUES
(620178953, 'Rodrigue Cheumadjeu', 'mali', 'M', 'pic01.jpg', 'TOYATA ;2002; CE 215 K', 677123467, 'admin', 'admin', '200', 'cheu@gmail.com', 'personel'),
(672999919, 'Tona Ntjam', 'togo', 'M', 'pic02.jpg', 'RAV 4 ;1979; CE 285 K', 679167818, 'tona', 'tona', '1000', 'tona@yy.fr', 'personel'),
(156728295, 'Tionang nadege ', 'Guinee equatorial', 'M', 'zz.png', 'HUMMER ;CE 254;2012', 677878889, '', '', '2500', 'nadege@tt.fr', 'customer'),
(201765779, 'Tankeu Guillome', 'Cameroun', 'M', 'zz.png', '2003;NORAV 4 ; CE 224 ', 677756544, '', '', '1000', 'Tankeu@gmail.cm', 'customer'),
(111409890, 'CICM', '', '', 'pic05.jpg', '', 69541487, 'cicm', 'cim', '', 'contact@cicm.cm', 'admin'),
(814451245, 'Tamo pierre armand', 'Gabon', 'M', 'zz.png', 'lbenz2008;Mercedes ;CE 225  ', 645515874, '', '', '', 'toto@yrh.e', 'customer'),
(116876436, 'Tabi philbert', 'Egypte', 'M', 'zz.png', 'UY7;UYO;4556', 2147483647, '', '', '', 'cheguy@jh.fr', 'customer'),
(111409891, 'Toto martin simon', 'Canada', 'M', 'zz.png', 'ffrfCr; 78j;yut', 766775667, '', '', '', 'ghhj@uhu.fr', 'customer'),
(111546378, 'TAMO simon', 'Mozambique', 'M', 'zz.png', '987;34;7', 867568698, '', '', '', 'hjgh@jij.fr', 'customer'),
(123654321, 'Marcelle france', 'Cameroun', 'M', 'zz.png', 'kjlkj;CE351;JKH', 676765576, '', '', '', 'rodriguewilly@gmail.com', 'customer'),
(118458796, 'Timo junior', 'Belgique', 'M', 'zz.png', '485;4845;CE 25', 695874512, '', '', '', 'tito@yahoo.fr', 'customer'),
(111785474, 'Camille Junior armand', 'RCA', 'M', 'zz.png', 'U7TYUH;jlkj;CE 5467', 685478542, '', '', '', 'alaintona1@gmail.com', 'customer'),
(451515, 'tititop', 'Gabon', 'F', 'zz.png', 'HJ;OU 526;545s', 651445215, '', '', '', 'titi@uh.fd', 'customer'),
(111874459, 'Sakgouok armelle paule', 'Cameroun', 'F', 'zz.png', '7458;CE 154;2006', 699031517, '', '', '', 'armellestar14@yahoo.fr', 'customer'),
(111409898, 'fuhrer willias', 'Cameroun', 'M', 'zz.png', '2015;45;CE455', 676818565, '', '', '', 'cheumadjeu@yahoo.fr', 'customer'),
(789456512, 'denise diffo', 'Cameroun', 'F', 'zz.png', '65;CE 2514;2007', 659875478, '', '', '', 'denisediffo@yahoo.fr', 'customer');

-- --------------------------------------------------------

--
-- Structure de la table `services`
--

CREATE TABLE `services` (
  `ordre` bigint(20) UNSIGNED NOT NULL,
  `code_service` varchar(100) NOT NULL,
  `nom_service` varchar(100) NOT NULL,
  `prix_unitaire` int(11) NOT NULL,
  `categorie` varchar(100) NOT NULL,
  `statut` varchar(100) NOT NULL,
  `photos` varchar(100) NOT NULL,
  `standing` varchar(100) NOT NULL,
  `quantite_stock` int(11) NOT NULL,
  `desription` text NOT NULL,
  `beneficiaire` varchar(100) NOT NULL,
  `date_attribution_service` varchar(100) NOT NULL,
  `date_liberation_service` varchar(100) NOT NULL,
  `deliver_service_agent` varchar(100) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Contenu de la table `services`
--

INSERT INTO `services` (`ordre`, `code_service`, `nom_service`, `prix_unitaire`, `categorie`, `statut`, `photos`, `standing`, `quantite_stock`, `desription`, `beneficiaire`, `date_attribution_service`, `date_liberation_service`, `deliver_service_agent`) VALUES
(1, '40.8-15', 'chambre 15', 15000, 'chambre', 'libre', '', '3*', 1, 'pivot', 'cicm', '21/02/2007', '10/08/2017', '20178953'),
(2, '40.9-15', 'chambre 15', 15000, 'chambre', 'libre', '', '3*', 1, 'pivot', 'cicm', '', '', ''),
(3, '40.10-15', 'chambre 15', 15000, 'chambre', 'libre', '', '3*', 1, 'pivot', 'cicm', '', '07/09/2017', ''),
(4, '40.12-15', 'chambre 15', 15000, 'chambre', 'indisponible', '', '3*', 1, 'pivot', '111409890', '', '', ''),
(5, '40.13-15', 'chambre 15', 15000, 'chambre', 'libre', '', '3*', 1, 'pivot', 'cicm', '', '07/31/2017', ''),
(6, '40.14-15', 'chambre 15', 15000, 'chambre', 'libre', '', '3*', 1, 'pivot', 'cicm', '', '10/08/2017', ''),
(7, '40.15-15', 'chambre 15', 15000, 'chambre', 'libre', '', '3*', 1, 'pivot', 'cicm', '', '07/31/2017', ''),
(8, '40.16-15', 'chambre 15', 15000, 'chambre', 'libre', '', '3*', 1, 'pivot', 'cicm', '', '07/26/2017', ''),
(9, '40.17-15', 'chambre 15', 15000, 'chambre', 'libre', '', '3*', 1, 'pivot', 'cicm', '', '07/26/2017', ''),
(10, '40.18-15', 'chambre 15', 15000, 'chambre', 'libre', '', '3*', 1, 'pivot', 'cicm', '', '07/31/2017', ''),
(11, '40.19-15', 'chambre 15', 15000, 'chambre', 'libre', '', '3*', 1, 'pivot', 'cicm', '', '07/31/2017', ''),
(12, '40.20-15', 'chambre 15', 15000, 'chambre', 'libre', '', '3*', 1, 'pivot', 'cicm', '', '07/07/2017', ''),
(13, '40.21-15', 'chambre 15', 15000, 'chambre', 'indisponible', '', '3*', 1, 'pivot', 'cicm', '', '', ''),
(14, '40.22-15', 'chambre 15', 15000, 'chambre', 'libre', '', '3*', 1, 'pivot', 'cicm', '', '', ''),
(15, '16-10', 'chambre 10', 10000, 'chambre', 'libre', '', '2*', 1, 'pivot', 'cicm', '', '10/08/2017', ''),
(16, '13-10', 'chambre 10', 10000, 'chambre', 'libre', '', '2*', 1, 'pivot', 'cicm', '', '', ''),
(17, '12-10', 'chambre 10', 10000, 'chambre', 'libre', '', '2*', 1, 'pivot', 'cicm', '', '', ''),
(18, '40.28-20', 'chambre 20', 20000, 'chambre', 'libre', '', '4*', 1, 'pivot', 'cicm', '', '', ''),
(19, '40.18-20', 'chambre 20', 20000, 'chambre', 'libre', '', '4*', 1, 'pivot', 'cicm', '', '', ''),
(20, '40.23-15', 'chambre 15', 15000, 'chambre', 'libre', '', '3*', 1, 'pivot', 'cicm', '', '', ''),
(21, '40.24-15', 'chambre 15', 15000, 'chambre', 'indisponible', '', '3*', 1, 'pivot', 'cicm', '', '', ''),
(22, '40.25-15', 'chambre 15', 15000, 'chambre', 'indisponible', '', '3*', 1, 'pivot', 'cicm', '', '', ''),
(23, '40.26-15', 'chambre 15', 15000, 'chambre', 'libre', '', '3*', 1, 'pivot', 'cicm', '', '', ''),
(24, '40.27-15', 'chambre 15', 15000, 'chambre', 'libre', '', '3*', 1, 'pivot', 'cicm', '', '07/31/2017', ''),
(25, '40.28-15', 'chambre 15', 15000, 'chambre', 'libre', '', '3*', 1, 'pivot', 'cicm', '', '07/31/2017', ''),
(26, '40.29-15', 'chambre 15', 15000, 'chambre', 'indisponible', '', '3*', 1, 'pivot', '111409890', '', '', ''),
(27, '17-10', 'chambre 10', 10000, 'chambre', 'indisponible', '', '2*', 1, 'pivot', 'cicm', '', '', ''),
(28, '20-10', 'chambre 10', 10000, 'chambre', 'libre', '', '2*', 1, 'pivot', 'cicm', '', '', ''),
(29, '21-10', 'chambre 10', 10000, 'chambre', 'libre', '', '2*', 1, 'pivot', 'cicm', '', '', ''),
(30, '24-10', 'chambre 10', 10000, 'chambre', 'libre', '', '2*', 1, 'pivot', 'cicm', '', '', ''),
(31, '25-10', 'chambre 10', 10000, 'chambre', 'libre', '', '2*', 1, 'pivot', 'cicm', '', '', ''),
(32, '28-10', 'chambre 10', 10000, 'chambre', 'libre', '', '2*', 1, 'pivot', 'cicm', '', '', ''),
(33, '10-06', 'chambre 06', 6000, 'chambre', 'libre', '', '1*', 1, 'pivot', 'cicm', '', '', ''),
(34, '11-06', 'chambre 06', 6000, 'chambre', 'libre', '', '1*', 1, 'pivot', 'cicm', '', '18/08/2017', ''),
(35, '15-06', 'chambre 06', 6000, 'chambre', 'libre', '', '1*', 1, 'pivot', 'cicm', '', '18/08/2017', ''),
(36, '18-06', 'chambre 06', 6000, 'chambre', 'libre', '', '1*', 1, 'pivot', 'cicm', '', '18/08/2017', ''),
(37, '19-06', 'chambre 06', 6000, 'chambre', 'libre', '', '1*', 1, 'pivot', 'cicm', '', '', ''),
(38, '22-06', 'chambre 06', 6000, 'chambre', 'libre', '', '1*', 1, 'pivot', 'cicm', '', '', ''),
(39, '23-06', 'chambre 06', 6000, 'chambre', 'libre', '', '1*', 1, 'pivot', 'cicm', '', '07/24/2017', ''),
(40, '26-06', 'chambre 06', 6000, 'chambre', 'libre', '', '1*', 1, 'pivot', 'cicm', '', '07/07/2017', ''),
(41, '27-06', 'chambre 06', 6000, 'chambre', 'libre', '', '1*', 1, 'pivot', 'cicm', '', '07/24/2017', ''),
(42, 'pdej15', 'petit dejeuner 1500', 1500, 'gastronomie', '', '', '', 1, 'pivot', 'cicm', '', '', ''),
(43, 'repsoir', 'repas soir 4000', 4000, 'gastronomie', '', '', '', 1, 'pivot', 'cicm', '', '', ''),
(44, 'Jus ', 'Jus 600', 600, 'boissons', '', '', '', 1, 'pivot', 'cicm', '', '', ''),
(45, 'beer', 'biere', 1000, 'boissons', '', '', '', 1, 'pivot', 'cicm', '', '', ''),
(46, 'che-hoe', 'Nettoyage chemise homme', 500, 'linge_salle', '', '', '', 1, 'pivot', 'cicm', '', '', ''),
(47, 'pan-hoe', 'Nettoyage pantalon homme', 800, 'linge_salle', '', '', '', 1, 'pivot', 'cicm', '', '', ''),
(48, 'jup-cuir', 'Nettoyage de jupe en cuir ', 4000, 'linge_salle', '', '', '', 1, 'pivot', 'cicm', '', '', ''),
(49, 'rob-mar', 'Nettoyage robe de mariage', 18000, 'linge_salle', '', '', '', 1, 'pivot', 'cicm', '', '', ''),
(50, 'cul-mix', 'Nettoyage culotte', 500, 'linge_salle', '', '', '', 1, 'pivot', 'cicm', '', '', ''),
(51, 'lin_beb', 'Nettoyage linge bebe', 250, 'linge_salle', '', '', '', 1, 'pivot', 'cicm', '', '', ''),
(52, 'cou-lit', 'Nettoyage couvre lit', 2000, 'linge_salle', '', '', '', 1, 'pivot', 'cicm', '', '', ''),
(53, 'moquet', 'Nettoyage moquette', 4000, 'linge_salle', '', '', '1', 0, 'pivot', 'cicm', '', '', ''),
(54, 'net-nap', 'Nappe', 1000, 'linge_salle', '', '', '1', 0, 'pivot', 'cicm', '', '', ''),
(55, 'net-cra', 'Nettoyage cravate', 300, 'linge_salle', '', '', '1', 0, 'pivot', 'cicm', '', '', ''),
(56, 'ens-bas', 'Nettoyage ensemble bassin', 2000, 'linge_salle', '', '', '', 1, 'pivot', 'cicm', '', '', ''),
(57, 'gan-sim', 'nettoyage gangoura simple', 1500, 'linge_salle', '', '', '', 1, 'pivot', 'cicm', '', '', ''),
(58, 'gan-pie', 'Nettoyage gangoura 3 pieces', 3000, 'linge_salle', '', '', '', 1, 'pivot', 'cicm', '', '', ''),
(59, 'net-nou', 'nettoyage nounous', 1000, 'linge_salle', '', '', '', 1, 'pivot', 'cicm', '', '', ''),
(60, 'ens-pag', 'nettoyage ensemble pagne ', 1000, 'linge_salle', '', '', '', 1, 'pivot', 'cicm', '', '', ''),
(61, 'dem-hoe', 'Nettoyage demenbre homme', 300, 'linge_salle', '', '', '', 1, 'pivot', 'cicm', '', '', ''),
(62, 'pan-jea', 'Nettoyage pantalon jeans ', 1000, 'linge_salle', '', '', '', 1, 'pivot', 'cicm', '', '', ''),
(63, 'net-tri', 'nettoyage tricot', 500, 'linge_salle', '', '', '', 1, 'pivot', 'cicm', '', '', ''),
(64, 'net-polo', 'Nettoyage polo', 500, 'linge_salle', '', '', '', 1, 'pivot', 'cicm', '', '', ''),
(65, 'pet-rid', 'Nettoyage petit rideau', 750, 'linge_salle', '', '', '', 1, 'pivot', 'cicm', '', '', ''),
(66, 'grd-rid', 'nettoyage grand rideau', 1500, 'linge_salle', '', '', '', 1, 'pivot', 'cicm', '', '', ''),
(67, 'tai-ore', 'nettoyage taie doreiller', 300, 'linge_salle', '', '', '', 1, 'pivot', 'cicm', '', '', ''),
(68, 'net-cou', 'nettoyage couverture ', 2500, 'linge_salle', '', '', '', 1, 'pivot', 'cicm', '', '', ''),
(69, 'ser-pte', 'Nettoyage serviette petite', 500, 'linge_salle', '', '', '', 1, 'pivot', 'cicm', '', '', ''),
(70, 'gde-ser', 'Nettoyage grande serviette', 1000, 'linge_salle', '', '', '', 1, 'pivot', 'cicm', '', '', ''),
(71, 'dra-lit', 'Nettoyage draps de lit', 800, 'linge_salle', '', '', '', 1, 'pivot', 'cicm', '', '', ''),
(72, 'net-sou', 'Nettoyage soutane', 1500, 'linge_salle', '', '', '', 1, 'pivot', 'cicm', '', '', ''),
(73, 'net-pij', 'Nettoyage pijament', 1000, 'linge_salle', '', '', '', 1, 'pivot', 'cicm', '', '', ''),
(74, 'net-rob', 'Nettoyage robe', 1000, 'linge_salle', '', '', '', 1, 'pivot', 'cicm', '', '', ''),
(75, 'chau-hoe', 'Nettoyage chaussure homme', 500, 'linge_salle', '', '', '', 1, 'pivot', 'cicm', '', '', ''),
(76, 'net-chau', 'Nettoyage Chaussette', 300, 'linge_salle', '', '', '', 1, 'pivot', 'cicm', '', '', ''),
(77, 'jup-pli', 'Nettoyage jupe plisse', 1500, 'linge_salle', '', '', '', 1, 'pivot', 'cicm', '', '', ''),
(78, 'net-ten', 'Nettoyage tenis', 1000, 'linge_salle', '', '', '', 1, 'pivot', 'cicm', '', '', ''),
(79, 'sou-vet', 'Nettoyage sous vetement ', 300, 'linge_salle', '', '', '', 1, 'pivot', 'cicm', '', '', ''),
(80, 'net-cas', 'Nettoyage nettoyage casquette', 500, 'linge_salle', '', '', '', 1, 'pivot', 'cicm', '', '', ''),
(82, 'GS.F-200', 'salle de 200 places 130000', 130000, 'salle', 'libre', '', '4*', 1, 'pivot', 'cicm', '', '24/08/2017', ''),
(81, 'GS.C-200', 'salle de 200 places 100000', 100000, 'salle', 'libre', '', '4*', 1, 'pivot', 'cicm', '', '', ''),
(83, 'PS-35', 'salle de 35 places 65000', 65000, 'salle', 'indisponible', '', '3*', 1, 'pivot', 'cicm', '', '', ''),
(84, 'PS-25', 'salle de 25 places 45000', 45000, 'salle', 'libre', '', '2*', 1, 'pivot', 'cicm', '', '', ''),
(85, 'PS-18', 'salle de 18 places 30000', 30000, 'salle', 'libre', '', '1*', 1, 'pivot', 'cicm', '', '', ''),
(86, 'PS-10', 'salle de 10 places 25000', 25000, 'salle', 'libre', '', '1*', 1, 'pivot', 'cicm', '', '31/07/2017', ''),
(87, 'dej65', 'dejeuner 6500', 6500, 'gastronomie', '', '', '', 1, 'pivot', 'cicm', '', '', ''),
(88, 'dej60', 'dejeuner 6000', 6000, 'gastronomie', '', '', '', 1, 'pivot', 'cicm', '', '', ''),
(89, 'dej40', 'dejeuner 4000', 4000, 'gastronomie', '', '', '', 1, 'pivot', 'cicm', '', '', ''),
(90, 'dej45', 'dejeuner 4500', 4500, 'gastronomie', '', '', '', 1, 'pivot', 'cicm', '', '', ''),
(518, '67NKN', 'acer aspire 12356332', 35662, 'Ordinateur', '', '', '', 85, 'pivot', 'cicm', '', '', ''),
(92, 'din35', 'diner 3500', 3500, 'gastronomie', '', '', '', 1, 'pivot', 'cicm', '', '', ''),
(93, 'cock50', 'cocktail 5000', 5000, 'gastronomie', '', '', '', 1, 'pivot', 'cicm', '', '', ''),
(510, '40.8-15', 'chambre 15', 15000, 'chambre', 'libre', '', '3*', 2, '2017-09-27 10:55:49', '111785474', '27/09/2017', '28/09/2017', '20178953'),
(511, '40.8-15', 'chambre 15', 15000, 'chambre', 'libre', '', '3*', 8, '2017-09-27 16:49:42', '111409898', '02/10/2017', '09/10/2017', '20178953'),
(512, '40.8-15', 'chambre 15', 15000, 'chambre', 'libre', '', '3*', 12, '2017-09-27 16:52:35', '111546378', '14/10/2017', '25/10/2017', '20178953'),
(513, '40.8-15', 'chambre 15', 15000, 'chambre', 'libre', '', '3*', 11, '2017-09-27 19:55:32', '789456512', '30/10/2017', '09/11/2017', '20178953'),
(514, '40.8-15', 'chambre 15', 15000, 'chambre', 'libre', '', '3*', 3, '2017-09-27 19:58:41', '789456512', '10/10/2017', '12/10/2017', '20178953'),
(515, '40.28-20', 'chambre 20', 20000, 'chambre', 'libre', '', '4*', 12, '2018-01-06 14:30:39', '111409898', '11/01/2018', '22/01/2018', ''),
(516, 'GS.F-200', 'salle de 200 places 130000', 130000, 'salle', 'libre', '', '4*', 3, '2018-01-06 14:35:39', '111409898', '06/01/2018', '08/01/2018', ''),
(517, '40.8-15', 'chambre 15', 15000, 'chambre', 'libre', '', '3*', 3, '2018-01-06 14:36:41', '123654321', '07/01/2018', '09/01/2018', '20178953'),
(519, '67NKN4', 'acer aspire 12356332', 35662, 'Ordinateur', '', '', '', 85, 'pivot', 'cicm', '', '', ''),
(520, '67NKN45', 'acer aspire 12356332', 35662, 'Ordinateur', '', '', '', 85, 'pivot', 'cicm', '', '', ''),
(521, '67NKN458', 'acer aspire 12356332', 35662, 'Ordinateur', '', '', '', 85, 'pivot', 'cicm', '', '', ''),
(522, '67NKN4585', 'acer aspire 12356332', 35662, 'Ordinateur', '', '', '', 85, 'pivot', 'cicm', '', '', ''),
(523, '67NKN45852', 'acer aspire 12356332', 35662, 'Ordinateur', '', '', '', 85, 'pivot', 'cicm', '', '', ''),
(524, '5896295', 'gguyih', 54, 'toto', '', '', '', 12, 'pivot', 'cicm', '', '', ''),
(525, 'ac-7030', 'Acer apsire 7130z', 800000, 'Ordinateur', '', '', '', 0, 'pivot', 'cicm', '', '', ''),
(526, 'hp-pav-17', 'Hp pavillion 17pouces', 250000, 'Ordinateur', '', '', '', 0, 'pivot', 'cicm', '', '', ''),
(527, '40.8-15', 'chambre 15', 15000, 'chambre', 'libre', '', '3*', 27, '2018-01-07 19:15:03', '789456512', '11/01/2018', '06/02/2018', '20178953'),
(528, 'PS-10', 'salle de 10 places 25000', 25000, 'salle', 'libre', '', '1*', 4, '2018-01-07 19:15:29', '789456512', '07/01/2018', '10/01/2018', ''),
(531, '40.9-15', 'chambre 15', 15000, 'chambre', 'libre', '', '3*', 2, '2018-01-08 05:44:53', '111785474', '09/01/2018', '10/01/2018', '');

-- --------------------------------------------------------

--
-- Structure de la table `sollicitation`
--

CREATE TABLE `sollicitation` (
  `nom_service` varchar(100) NOT NULL,
  `cni_personne` varchar(100) NOT NULL,
  `date_sollicitation_service` varchar(100) NOT NULL,
  `quantite_commandee` int(11) NOT NULL,
  `prix_unitaire` int(100) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Contenu de la table `sollicitation`
--

INSERT INTO `sollicitation` (`nom_service`, `cni_personne`, `date_sollicitation_service`, `quantite_commandee`, `prix_unitaire`) VALUES
('chambre 15', '789456512', '27/09/2017', 11, 15000),
('biere', '111409898', '27/09/2017', 2, 1960),
('petit dejeuner 1500', '111409898', '27/09/2017', 1, 1500),
('chambre 15', '111409898', '27/09/2017', 8, 15000),
('chambre 15', '111785474', '27/09/2017', 2, 15000),
('Jus 600', '111785474', '27/09/2017', 1, 600),
('repas soir 4000', '111785474', '27/09/2017', 10, 38800),
('chambre 20', '111409898', '06/01/2018', 12, 20000),
('Jus 600', '111409898', '06/01/2018', 4, 2400),
('repas soir 4000', '789456512', '06/01/2018', 1, 4000),
('salle de 200 places 130000', '111409898', '06/01/2018', 3, 130000),
('Nettoyage chemise homme', '111409898', '06/01/2018', 3, 1500),
('chambre 15', '123654321', '06/01/2018', 3, 15000),
('petit dejeuner 1500', '123654321', '06/01/2018', 2, 3000),
('biere', '123654321', '06/01/2018', 1, 1000),
('chambre 15', '789456512', '07/01/2018', 27, 15000),
('salle de 10 places 25000', '789456512', '07/01/2018', 4, 25000),
('Nettoyage couvre lit', '789456512', '07/01/2018', 3, 6000),
('chambre 15', '111785474', '08/01/2018', 2, 15000),
('Acer apsire 7130z', '111785474', '08/01/2018', 1, 800000);

-- --------------------------------------------------------

--
-- Structure de la table `taxonomie`
--

CREATE TABLE `taxonomie` (
  `code_taxonomy` bigint(20) UNSIGNED NOT NULL,
  `libelle_taxonomy` varchar(100) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Contenu de la table `taxonomie`
--

INSERT INTO `taxonomie` (`code_taxonomy`, `libelle_taxonomy`) VALUES
(50, 'boissons'),
(47, 'gastronomie'),
(46, 'salle'),
(52, 'linge_salle'),
(53, 'chambre'),
(54, 'Ordinateur'),
(60, 'titi franc ');

--
-- Index pour les tables exportées
--

--
-- Index pour la table `calendrier`
--
ALTER TABLE `calendrier`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`);

--
-- Index pour la table `journalisation`
--
ALTER TABLE `journalisation`
  ADD PRIMARY KEY (`code_journalisation`);

--
-- Index pour la table `personne`
--
ALTER TABLE `personne`
  ADD PRIMARY KEY (`cni_personne`);

--
-- Index pour la table `services`
--
ALTER TABLE `services`
  ADD PRIMARY KEY (`code_service`,`beneficiaire`,`date_attribution_service`),
  ADD UNIQUE KEY `ordre` (`ordre`);

--
-- Index pour la table `sollicitation`
--
ALTER TABLE `sollicitation`
  ADD PRIMARY KEY (`nom_service`,`cni_personne`,`date_sollicitation_service`);

--
-- Index pour la table `taxonomie`
--
ALTER TABLE `taxonomie`
  ADD PRIMARY KEY (`code_taxonomy`),
  ADD UNIQUE KEY `code_taxonomy` (`code_taxonomy`);

--
-- AUTO_INCREMENT pour les tables exportées
--

--
-- AUTO_INCREMENT pour la table `calendrier`
--
ALTER TABLE `calendrier`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=473;
--
-- AUTO_INCREMENT pour la table `services`
--
ALTER TABLE `services`
  MODIFY `ordre` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=532;
--
-- AUTO_INCREMENT pour la table `taxonomie`
--
ALTER TABLE `taxonomie`
  MODIFY `code_taxonomy` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=61;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
