-- phpMyAdmin SQL Dump
-- version 4.2.12deb2
-- http://www.phpmyadmin.net
--
-- Servidor: localhost
-- Tiempo de generación: 12-06-2015 a las 11:09:04
-- Versión del servidor: 5.6.24-0ubuntu2
-- Versión de PHP: 5.6.4-4ubuntu6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de datos: `laravel`
--

--
-- Volcado de datos para la tabla `metodo_pago`
--

INSERT INTO `metodo_pago` (`id`, `descripcion`, `created_at`, `updated_at`) VALUES
(1, 'Efectivo', '2015-02-16 23:23:05', '2015-02-16 23:23:05'),
(2, 'Credito', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(3, 'Cheque', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(4, 'Tarjeta', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(5, 'Deposito', '0000-00-00 00:00:00', '0000-00-00 00:00:00');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
