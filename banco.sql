-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 14-12-2020 a las 11:06:44
-- Versión del servidor: 10.4.17-MariaDB
-- Versión de PHP: 7.4.13

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `banco_bloqueo`
--

CREATE DATABASE IF NOT EXISTS `banco_bloqueo` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci;
USE `banco_bloqueo`;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cuentas`
--

DROP TABLE IF EXISTS `cuentas`;
CREATE TABLE `cuentas` (
  `iban` varchar(24) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `saldo` float NOT NULL,
  `dni_cuenta` varchar(9) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

--
-- Volcado de datos para la tabla `cuentas`
--

INSERT INTO `cuentas` (`iban`, `saldo`, `dni_cuenta`) VALUES
('ES2011111111111111111111', 1437, '11111111A'),
('ES2022222222222222222222', 120200, '22222222B'),
('ES2033333333333333333333', 50000, '33333333C'),
('ES2044444444444444444444', 25000, '44444444D'),
('ES2055555555555555555555', 10347.5, '11111111A'),
('ES2066666666666666666666', 20500, '22222222B'),
('ES2099999999999999999999', 2, '12121212A');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `transferencias`
--

DROP TABLE IF EXISTS `transferencias`;
CREATE TABLE `transferencias` (
  `iban_origen` varchar(24) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `iban_destino` varchar(24) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `fecha` int(11) NOT NULL,
  `cantidad` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

--
-- Volcado de datos para la tabla `transferencias`
--

INSERT INTO `transferencias` (`iban_origen`, `iban_destino`, `fecha`, `cantidad`) VALUES
('ES2011111111111111111111', 'ES2022222222222222222222', 1606130274, 100),
('ES2011111111111111111111', 'ES2055555555555555555555', 1606123963, 500),
('ES2011111111111111111111', 'ES2055555555555555555555', 1606125378, 100),
('ES2055555555555555555555', 'ES2011111111111111111111', 1606123981, 250);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

DROP TABLE IF EXISTS `usuarios`;
CREATE TABLE `usuarios` (
  `Nombre` varchar(20) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `Direccion` varchar(50) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `Telefono` int(11) NOT NULL,
  `DNI` varchar(9) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `clave` varchar(50) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `intentos` int(11) NOT NULL DEFAULT 3,
  `bloqueado` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`Nombre`, `Direccion`, `Telefono`, `DNI`, `clave`, `intentos`, `bloqueado`) VALUES
('Administrador', 'Juego de Pelota, 54', 111111111, '11111111A', '21232f297a57a5a743894a0e4a801fc3', 3, 0),
('Comisiones', 'Banco', 0, '12121212A', '', 3, 0),
('Pepe López', 'Ancha,21', 222222222, '22222222B', '926e27eecdbc7a18858b3798ba99bddd', 3, 0),
('Maria Pérez', 'Moreno, 1', 333333333, '33333333C', '263bce650e68ab4e23f28263760b9fa5', 3, 0),
('Juan Sánchez', 'Corredera, 32', 444444444, '44444444D', 'a94652aa97c7211ba8954dd15a3cf838', 3, 0);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `cuentas`
--
ALTER TABLE `cuentas`
  ADD PRIMARY KEY (`iban`),
  ADD KEY `dni_cuenta` (`dni_cuenta`);

--
-- Indices de la tabla `transferencias`
--
ALTER TABLE `transferencias`
  ADD PRIMARY KEY (`iban_origen`,`iban_destino`,`fecha`),
  ADD KEY `iban_destino` (`iban_destino`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`DNI`);

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `cuentas`
--
ALTER TABLE `cuentas`
  ADD CONSTRAINT `cuentas_ibfk_1` FOREIGN KEY (`dni_cuenta`) REFERENCES `usuarios` (`DNI`);

--
-- Filtros para la tabla `transferencias`
--
ALTER TABLE `transferencias`
  ADD CONSTRAINT `transferencias_ibfk_1` FOREIGN KEY (`iban_origen`) REFERENCES `cuentas` (`iban`),
  ADD CONSTRAINT `transferencias_ibfk_2` FOREIGN KEY (`iban_destino`) REFERENCES `cuentas` (`iban`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;