-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: May 05, 2025 at 02:21 AM
-- Server version: 8.0.31
-- PHP Version: 8.0.26

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `cuponera`
--

-- --------------------------------------------------------

--
-- Table structure for table `admincuentas`
--

DROP TABLE IF EXISTS `admincuentas`;
CREATE TABLE IF NOT EXISTS `admincuentas` (
  `adminId` int NOT NULL AUTO_INCREMENT,
  `nivel` enum('administrador','gerente','ventas','web') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `FechaCreado` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `nombre` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `apellido` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `correo` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `telefono` varchar(20) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `usuario` varchar(25) COLLATE utf8mb4_general_ci NOT NULL,
  `contraseña` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  PRIMARY KEY (`adminId`),
  UNIQUE KEY `correo` (`correo`),
  UNIQUE KEY `usuario` (`usuario`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admincuentas`
--

INSERT INTO `admincuentas` (`adminId`, `nivel`, `FechaCreado`, `nombre`, `apellido`, `correo`, `telefono`, `usuario`, `contraseña`) VALUES
(1, 'administrador', '2025-05-04 12:56:18', 'Master', 'Admin', 'webmaster@coponera.sv', '503555252', 'admin', '$2y$10$/NydLvysFoxHRwR6lchFiuq5ymH3COiAcuZc7bRmdR0xpZGFLTSEq');

-- --------------------------------------------------------

--
-- Table structure for table `clientes`
--

DROP TABLE IF EXISTS `clientes`;
CREATE TABLE IF NOT EXISTS `clientes` (
  `clienteId` int NOT NULL AUTO_INCREMENT,
  `adminId` int NOT NULL,
  `contactoId` int NOT NULL,
  `FechaCreado` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `estado` enum('pendiente','activo','Desactivo') COLLATE utf8mb4_general_ci NOT NULL,
  `nombre` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `apellido` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `nacimiento` date NOT NULL,
  `correo` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `usuario` varchar(25) COLLATE utf8mb4_general_ci NOT NULL,
  `contraseña` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  PRIMARY KEY (`clienteId`),
  UNIQUE KEY `correo` (`correo`),
  UNIQUE KEY `usuario` (`usuario`),
  KEY `adminId` (`adminId`),
  KEY `contactoId` (`contactoId`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `clientes`
--

INSERT INTO `clientes` (`clienteId`, `adminId`, `contactoId`, `FechaCreado`, `estado`, `nombre`, `apellido`, `nacimiento`, `correo`, `usuario`, `contraseña`) VALUES
(2, 1, 2, '2025-05-04 12:56:41', 'pendiente', 'David Ernesto', 'Orellana Gomez', '1982-05-20', 'dorellana@udb.com.sv', 'dorellana', '$2y$10$No81vaozXgC3c0zv02oYnOtRS5iGD1/qsH9lrZNRC7USjlAQTmmXK');

-- --------------------------------------------------------

--
-- Table structure for table `contactos`
--

DROP TABLE IF EXISTS `contactos`;
CREATE TABLE IF NOT EXISTS `contactos` (
  `contactoId` int NOT NULL AUTO_INCREMENT,
  `telefono` varchar(20) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `calle` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `ciudad` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `puntoRef` text COLLATE utf8mb4_general_ci,
  PRIMARY KEY (`contactoId`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `contactos`
--

INSERT INTO `contactos` (`contactoId`, `telefono`, `calle`, `ciudad`, `puntoRef`) VALUES
(2, '4036696517', '200 El milagro', 'San Salvador', 'Palo de Mango'),
(3, '5035323232', '235 Ilopango', 'Soyapango', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `cupones`
--

DROP TABLE IF EXISTS `cupones`;
CREATE TABLE IF NOT EXISTS `cupones` (
  `cuponId` int NOT NULL AUTO_INCREMENT,
  `empresaId` int NOT NULL,
  `estado` enum('activo','Desactivo') COLLATE utf8mb4_general_ci NOT NULL,
  `FechaCreado` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `Actualizar` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `FechaInicio` date NOT NULL,
  `FechaFin` date NOT NULL,
  `nombreCupon` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `CodigoCupon` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `descripcion` text COLLATE utf8mb4_general_ci NOT NULL,
  `totalDisp` int NOT NULL,
  `maximo` int NOT NULL,
  `precioRegular` decimal(10,2) NOT NULL,
  `precioPromocion` decimal(10,2) NOT NULL,
  PRIMARY KEY (`cuponId`),
  KEY `empresaId` (`empresaId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `empresas`
--

DROP TABLE IF EXISTS `empresas`;
CREATE TABLE IF NOT EXISTS `empresas` (
  `empresaId` int NOT NULL AUTO_INCREMENT,
  `adminId` int NOT NULL,
  `fechaCreado` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `nombreEmpresa` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `NIT` varchar(20) COLLATE utf8mb4_general_ci NOT NULL,
  `contactoId` int NOT NULL,
  `estado` enum('pendiente','activo','Desactivo') COLLATE utf8mb4_general_ci NOT NULL,
  `correo` varchar(25) COLLATE utf8mb4_general_ci NOT NULL,
  `usuario` varchar(25) COLLATE utf8mb4_general_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  PRIMARY KEY (`empresaId`),
  UNIQUE KEY `correo` (`correo`),
  KEY `adminId` (`adminId`),
  KEY `contactoId` (`contactoId`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `empresas`
--

INSERT INTO `empresas` (`empresaId`, `adminId`, `fechaCreado`, `nombreEmpresa`, `NIT`, `contactoId`, `estado`, `correo`, `usuario`, `password`) VALUES
(1, 1, '2025-05-04 12:59:14', 'Hotel Vista Lago', '061408071985', 3, 'pendiente', 'info@hotelvistalago.sv', 'vistalago', '$2y$10$vm1Sn3Dh0m5UH0cU5c1dNeiY0L.g6juU1vdieV1SFKcB7Y/Q6Rrsy');

-- --------------------------------------------------------

--
-- Table structure for table `transacciones`
--

DROP TABLE IF EXISTS `transacciones`;
CREATE TABLE IF NOT EXISTS `transacciones` (
  `transaccionId` int NOT NULL AUTO_INCREMENT,
  `clienteId` int NOT NULL,
  `cuponId` int NOT NULL,
  `FechaCreado` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `estado` enum('pendiente','completado','cancelado','Reintegrado') COLLATE utf8mb4_general_ci NOT NULL,
  `cantidad` int NOT NULL,
  `impuesto` decimal(10,2) NOT NULL,
  `TotalPagar` decimal(10,2) NOT NULL,
  `MetodoPago` enum('TarjetaCredito','Bitcoin','efectivo') COLLATE utf8mb4_general_ci NOT NULL,
  `DetallesPago` text COLLATE utf8mb4_general_ci,
  PRIMARY KEY (`transaccionId`),
  KEY `clienteId` (`clienteId`),
  KEY `cuponId` (`cuponId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `clientes`
--
ALTER TABLE `clientes`
  ADD CONSTRAINT `clientes_ibfk_1` FOREIGN KEY (`adminId`) REFERENCES `admincuentas` (`adminId`),
  ADD CONSTRAINT `clientes_ibfk_2` FOREIGN KEY (`contactoId`) REFERENCES `contactos` (`contactoId`);

--
-- Constraints for table `cupones`
--
ALTER TABLE `cupones`
  ADD CONSTRAINT `cupones_ibfk_1` FOREIGN KEY (`empresaId`) REFERENCES `empresas` (`empresaId`);

--
-- Constraints for table `empresas`
--
ALTER TABLE `empresas`
  ADD CONSTRAINT `empresas_ibfk_1` FOREIGN KEY (`adminId`) REFERENCES `admincuentas` (`adminId`),
  ADD CONSTRAINT `empresas_ibfk_2` FOREIGN KEY (`contactoId`) REFERENCES `contactos` (`contactoId`);

--
-- Constraints for table `transacciones`
--
ALTER TABLE `transacciones`
  ADD CONSTRAINT `transacciones_ibfk_1` FOREIGN KEY (`clienteId`) REFERENCES `clientes` (`clienteId`),
  ADD CONSTRAINT `transacciones_ibfk_2` FOREIGN KEY (`cuponId`) REFERENCES `cupones` (`cuponId`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
