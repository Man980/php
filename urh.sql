-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 22, 2024 at 08:06 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `urh`
--

-- --------------------------------------------------------

--
-- Table structure for table `inscriptionstudent`
--

CREATE TABLE `inscriptionstudent` (
  `codeInscription` int(11) NOT NULL,
  `nom` varchar(100) DEFAULT NULL,
  `prenom` varchar(100) DEFAULT NULL,
  `sexe` enum('M','F') DEFAULT NULL,
  `datNaissance` date DEFAULT NULL,
  `classe` varchar(50) DEFAULT NULL,
  `fraisInscription` decimal(10,2) DEFAULT NULL,
  `dateInscription` date DEFAULT NULL,
  `codeInscription0` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `inscriptionstudent`
--

INSERT INTO `inscriptionstudent` (`codeInscription`, `nom`, `prenom`, `sexe`, `datNaissance`, `classe`, `fraisInscription`, `dateInscription`, `codeInscription0`) VALUES
(14, 'Man', 'Ralph', 'F', '0003-03-03', 'premiere annee', 4.00, '0003-03-03', '45af'),
(16, 'Man', 'Ralph', 'F', '0003-03-03', 'premiere annee', 4.00, '0003-03-03', '45af44');

-- --------------------------------------------------------

--
-- Table structure for table `paiement`
--

CREATE TABLE `paiement` (
  `codePaiement` int(11) NOT NULL,
  `codeInscription0` varchar(255) NOT NULL,
  `codeInscription` int(11) DEFAULT NULL,
  `montant` decimal(10,2) DEFAULT NULL,
  `datePaiement` date DEFAULT NULL,
  `methodPaiement` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `paiement`
--

INSERT INTO `paiement` (`codePaiement`, `codeInscription0`, `codeInscription`, `montant`, `datePaiement`, `methodPaiement`) VALUES
(6, '45af', NULL, 3434.00, '0023-04-03', 'Espèces');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id_user` int(11) NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id_user`, `username`, `password`) VALUES
(1, 'admin', 'admin');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `inscriptionstudent`
--
ALTER TABLE `inscriptionstudent`
  ADD PRIMARY KEY (`codeInscription`),
  ADD UNIQUE KEY `codeInscription0` (`codeInscription0`);

--
-- Indexes for table `paiement`
--
ALTER TABLE `paiement`
  ADD PRIMARY KEY (`codePaiement`),
  ADD KEY `codeInscription` (`codeInscription`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id_user`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `inscriptionstudent`
--
ALTER TABLE `inscriptionstudent`
  MODIFY `codeInscription` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `paiement`
--
ALTER TABLE `paiement`
  MODIFY `codePaiement` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id_user` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `paiement`
--
ALTER TABLE `paiement`
  ADD CONSTRAINT `paiement_ibfk_1` FOREIGN KEY (`codeInscription`) REFERENCES `inscriptionstudent` (`codeInscription`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
