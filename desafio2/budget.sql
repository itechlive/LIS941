-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1:3306
-- Tiempo de generación: 31-03-2025 a las 05:26:19
-- Versión del servidor: 9.1.0
-- Versión de PHP: 8.3.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `budget`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `access`
--

DROP TABLE IF EXISTS `access`;
CREATE TABLE IF NOT EXISTS `access` (
  `accessId` int NOT NULL AUTO_INCREMENT,
  `access` varchar(25) DEFAULT NULL,
  PRIMARY KEY (`accessId`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categories`
--

DROP TABLE IF EXISTS `categories`;
CREATE TABLE IF NOT EXISTS `categories` (
  `categoryId` int NOT NULL AUTO_INCREMENT,
  `categoryName` varchar(50) NOT NULL,
  `type` enum('income','expenses') NOT NULL,
  PRIMARY KEY (`categoryId`)
) ENGINE=MyISAM AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `categories`
--

INSERT INTO `categories` (`categoryId`, `categoryName`, `type`) VALUES
(1, 'Pago de Luz', 'expenses'),
(2, 'Pago de Gasolina', 'expenses'),
(3, 'Pago de Colegiatura', 'expenses'),
(4, 'Pago de Vivienda', 'expenses'),
(5, 'Quincena', 'income'),
(6, 'Bono de Venta', 'income'),
(7, 'Venta Enlinea', 'income'),
(8, 'Uber', 'income'),
(9, 'Pago de Agua', 'expenses'),
(10, 'Pago de Internet', 'expenses');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `transactionrecord`
--

DROP TABLE IF EXISTS `transactionrecord`;
CREATE TABLE IF NOT EXISTS `transactionrecord` (
  `transactionId` int NOT NULL AUTO_INCREMENT,
  `userId` int NOT NULL,
  `typeId` int NOT NULL,
  `categoryId` int NOT NULL,
  `description` text,
  `fecha` date NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `factura` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`transactionId`),
  KEY `userId` (`userId`),
  KEY `categoryId` (`categoryId`),
  KEY `typeId` (`typeId`)
) ENGINE=MyISAM AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `transactionrecord`
--

INSERT INTO `transactionrecord` (`transactionId`, `userId`, `typeId`, `categoryId`, `description`, `fecha`, `amount`, `factura`) VALUES
(13, 2, 2, 10, 'pago', '2025-03-22', 8.99, '67ea2726811e8_Captura de pantalla 2025-03-30 232255.png'),
(12, 2, 1, 5, 'Pago Freelancer', '2025-03-06', 13.89, '67ea255f78f74_Captura de pantalla 2025-03-24 234643.png');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `transactiontype`
--

DROP TABLE IF EXISTS `transactiontype`;
CREATE TABLE IF NOT EXISTS `transactiontype` (
  `typeId` int NOT NULL AUTO_INCREMENT,
  `typeCategory` varchar(30) NOT NULL,
  PRIMARY KEY (`typeId`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `userId` int NOT NULL AUTO_INCREMENT,
  `accessId` int DEFAULT NULL,
  `firstName` varchar(50) DEFAULT NULL,
  `lastName` varchar(50) DEFAULT NULL,
  `email` varchar(50) NOT NULL,
  `userLogin` varchar(25) NOT NULL,
  `userPwd` varchar(300) NOT NULL,
  PRIMARY KEY (`userId`),
  UNIQUE KEY `email` (`email`),
  UNIQUE KEY `userLogin` (`userLogin`),
  KEY `accessId` (`accessId`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `users`
--

INSERT INTO `users` (`userId`, `accessId`, `firstName`, `lastName`, `email`, `userLogin`, `userPwd`) VALUES
(1, NULL, 'David Ernesto', 'Orellana Gomez', 'dorellana@udb.com', 'dorellana', '$2y$10$qJSgGIAEzcXhN6G1tjXfXe.Yxw6d36nRzt0n/RiLVPL5847hAR6wu'),
(2, NULL, 'Diego Josue', 'Padilla Arevalo', 'Diegojosue201@gmail.com', 'DiegoJosue322', '$2y$10$KH1sJiNcSr0eG8yoljJFXuzFcZvgue407UcTIeC0q.Q7IO5dE1BAW'),
(3, NULL, 'Mercedes Guadalupe', 'Perez Rivas', 'merciperezcstj@gmail.com', 'Mer', '$2y$10$BJfMTO./wfSg6dBPfqFQref1kxpo10LXATiTNUIygjO/cXKEgUEAu');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
