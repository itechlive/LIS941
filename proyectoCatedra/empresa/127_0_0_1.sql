-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 29-04-2025 a las 10:28:16
-- Versión del servidor: 10.4.32-MariaDB
-- Versión de PHP: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `cuponera`
--
CREATE DATABASE IF NOT EXISTS `cuponera` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `cuponera`;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `admincuentas`
--

CREATE TABLE `admincuentas` (
  `adminId` int(11) NOT NULL,
  `nivel` enum('administrador','gerente','ventas') NOT NULL,
  `FechaCreado` timestamp NOT NULL DEFAULT current_timestamp(),
  `nombre` varchar(50) NOT NULL,
  `apellido` varchar(50) NOT NULL,
  `correo` varchar(100) NOT NULL,
  `telefono` varchar(20) DEFAULT NULL,
  `usuario` varchar(25) NOT NULL,
  `contraseña` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `clientes`
--

CREATE TABLE `clientes` (
  `clienteId` int(11) NOT NULL,
  `adminId` int(11) NOT NULL,
  `contactoId` int(11) NOT NULL,
  `FechaCreado` timestamp NOT NULL DEFAULT current_timestamp(),
  `estado` enum('pendiente','activo','Desactivo') NOT NULL,
  `nombre` varchar(50) NOT NULL,
  `apellido` varchar(50) NOT NULL,
  `nacimiento` date NOT NULL,
  `correo` varchar(100) NOT NULL,
  `usuario` varchar(25) NOT NULL,
  `contraseña` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `contactos`
--

CREATE TABLE `contactos` (
  `contactoId` int(11) NOT NULL,
  `telefono` varchar(20) DEFAULT NULL,
  `calle` varchar(255) NOT NULL,
  `ciudad` varchar(100) NOT NULL,
  `puntoRef` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cupones`
--

CREATE TABLE `cupones` (
  `cuponId` int(11) NOT NULL,
  `empresaId` int(11) NOT NULL,
  `estado` enum('activo','Desactivo') NOT NULL,
  `FechaCreado` timestamp NOT NULL DEFAULT current_timestamp(),
  `Actualizar` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `FechaInicio` date NOT NULL,
  `FechaFin` date NOT NULL,
  `nombreCupon` varchar(100) NOT NULL,
  `CodigoCupon` varchar(50) DEFAULT NULL,
  `descripcion` text NOT NULL,
  `totalDisp` int(11) NOT NULL,
  `maximo` int(11) NOT NULL,
  `precioRegular` decimal(10,2) NOT NULL,
  `precioPromocion` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `empresas`
--

CREATE TABLE `empresas` (
  `empresaId` int(11) NOT NULL,
  `adminId` int(11) NOT NULL,
  `fechaCreado` timestamp NOT NULL DEFAULT current_timestamp(),
  `nombreEmpresa` varchar(100) NOT NULL,
  `NIT` varchar(20) NOT NULL,
  `contactoId` int(11) NOT NULL,
  `estado` enum('pendiente','activo','Desactivo') NOT NULL,
  `correo` varchar(25) NOT NULL,
  `usuario` varchar(25) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `transacciones`
--

CREATE TABLE `transacciones` (
  `transaccionId` int(11) NOT NULL,
  `clienteId` int(11) NOT NULL,
  `cuponId` int(11) NOT NULL,
  `FechaCreado` timestamp NOT NULL DEFAULT current_timestamp(),
  `estado` enum('pendiente','completado','cancelado','Reintegrado') NOT NULL,
  `cantidad` int(11) NOT NULL,
  `impuesto` decimal(10,2) NOT NULL,
  `TotalPagar` decimal(10,2) NOT NULL,
  `MetodoPago` enum('TarjetaCredito','Bitcoin','efectivo') NOT NULL,
  `DetallesPago` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `admincuentas`
--
ALTER TABLE `admincuentas`
  ADD PRIMARY KEY (`adminId`),
  ADD UNIQUE KEY `correo` (`correo`),
  ADD UNIQUE KEY `usuario` (`usuario`);

--
-- Indices de la tabla `clientes`
--
ALTER TABLE `clientes`
  ADD PRIMARY KEY (`clienteId`),
  ADD UNIQUE KEY `correo` (`correo`),
  ADD UNIQUE KEY `usuario` (`usuario`),
  ADD KEY `adminId` (`adminId`),
  ADD KEY `contactoId` (`contactoId`);

--
-- Indices de la tabla `contactos`
--
ALTER TABLE `contactos`
  ADD PRIMARY KEY (`contactoId`);

--
-- Indices de la tabla `cupones`
--
ALTER TABLE `cupones`
  ADD PRIMARY KEY (`cuponId`),
  ADD KEY `empresaId` (`empresaId`);

--
-- Indices de la tabla `empresas`
--
ALTER TABLE `empresas`
  ADD PRIMARY KEY (`empresaId`),
  ADD UNIQUE KEY `correo` (`correo`),
  ADD KEY `adminId` (`adminId`),
  ADD KEY `contactoId` (`contactoId`);

--
-- Indices de la tabla `transacciones`
--
ALTER TABLE `transacciones`
  ADD PRIMARY KEY (`transaccionId`),
  ADD KEY `clienteId` (`clienteId`),
  ADD KEY `cuponId` (`cuponId`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `admincuentas`
--
ALTER TABLE `admincuentas`
  MODIFY `adminId` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `clientes`
--
ALTER TABLE `clientes`
  MODIFY `clienteId` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `contactos`
--
ALTER TABLE `contactos`
  MODIFY `contactoId` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `cupones`
--
ALTER TABLE `cupones`
  MODIFY `cuponId` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `empresas`
--
ALTER TABLE `empresas`
  MODIFY `empresaId` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `transacciones`
--
ALTER TABLE `transacciones`
  MODIFY `transaccionId` int(11) NOT NULL AUTO_INCREMENT;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `clientes`
--
ALTER TABLE `clientes`
  ADD CONSTRAINT `clientes_ibfk_1` FOREIGN KEY (`adminId`) REFERENCES `admincuentas` (`adminId`),
  ADD CONSTRAINT `clientes_ibfk_2` FOREIGN KEY (`contactoId`) REFERENCES `contactos` (`contactoId`);

--
-- Filtros para la tabla `cupones`
--
ALTER TABLE `cupones`
  ADD CONSTRAINT `cupones_ibfk_1` FOREIGN KEY (`empresaId`) REFERENCES `empresas` (`empresaId`);

--
-- Filtros para la tabla `empresas`
--
ALTER TABLE `empresas`
  ADD CONSTRAINT `empresas_ibfk_1` FOREIGN KEY (`adminId`) REFERENCES `admincuentas` (`adminId`),
  ADD CONSTRAINT `empresas_ibfk_2` FOREIGN KEY (`contactoId`) REFERENCES `contactos` (`contactoId`);

--
-- Filtros para la tabla `transacciones`
--
ALTER TABLE `transacciones`
  ADD CONSTRAINT `transacciones_ibfk_1` FOREIGN KEY (`clienteId`) REFERENCES `clientes` (`clienteId`),
  ADD CONSTRAINT `transacciones_ibfk_2` FOREIGN KEY (`cuponId`) REFERENCES `cupones` (`cuponId`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
