-- phpMyAdmin SQL Dump
-- version 3.5.1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Jan 29, 2021 at 11:49 AM
-- Server version: 5.5.24-log
-- PHP Version: 5.4.3

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `veiculos`
--

-- --------------------------------------------------------

--
-- Table structure for table `reservas`
--

CREATE TABLE IF NOT EXISTS `reservas` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_veiculo` int(11) DEFAULT NULL,
  `id_funcionario` int(11) DEFAULT NULL,
  `data_saida` datetime DEFAULT NULL,
  `data_retorno` datetime DEFAULT NULL,
  `local` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `id_contrato` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=2 ;

--
-- Dumping data for table `reservas`
--

INSERT INTO `reservas` (`id`, `id_veiculo`, `id_funcionario`, `data_saida`, `data_retorno`, `local`, `id_contrato`) VALUES
(1, 71, 11, '2021-01-02 09:02:00', '2021-01-02 09:02:00', 'teste', 3);

-- --------------------------------------------------------

--
-- Table structure for table `usuarios`
--

CREATE TABLE IF NOT EXISTS `usuarios` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(45) COLLATE utf8_unicode_ci DEFAULT NULL,
  `senha` varchar(45) COLLATE utf8_unicode_ci NOT NULL DEFAULT '1234567890',
  `criado` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `editado` timestamp NULL DEFAULT NULL,
  `permissao` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=71 ;

--
-- Dumping data for table `usuarios`
--

INSERT INTO `usuarios` (`id`, `email`, `senha`, `criado`, `editado`, `permissao`) VALUES
(69, 'setra@kuttner.com.br', 'kdb2310', '2021-01-21 19:51:20', NULL, 1),
(70, 'd.oliveira@kuttner.com.br', 'kdb2310', '2021-01-21 20:32:38', NULL, 1);

-- --------------------------------------------------------

--
-- Table structure for table `veiculos`
--

CREATE TABLE IF NOT EXISTS `veiculos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `marca` varchar(45) COLLATE utf8_unicode_ci DEFAULT NULL,
  `modelo` varchar(45) COLLATE utf8_unicode_ci DEFAULT NULL,
  `placa` varchar(7) COLLATE utf8_unicode_ci DEFAULT NULL,
  `criado` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `editado` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=74 ;

--
-- Dumping data for table `veiculos`
--

INSERT INTO `veiculos` (`id`, `marca`, `modelo`, `placa`, `criado`, `editado`) VALUES
(71, 'Volkswagen', 'Gol G5 Branco - flex 1.0', 'HGP6052', '2021-01-22 11:08:11', NULL),
(72, 'Volkswagen', 'Gol G6 Cinza  - flex 1.0', 'OWP6320', '2021-01-22 11:09:10', NULL),
(73, 'Volkswagen', 'Gol G6 Cinza - flex 1.0', 'OWP6342', '2021-01-22 11:10:13', NULL);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
