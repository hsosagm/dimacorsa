-- phpMyAdmin SQL Dump
-- version 4.2.6deb1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Mar 10, 2015 at 05:28 PM
-- Server version: 5.5.41-0ubuntu0.14.10.1
-- PHP Version: 5.5.12-2ubuntu4.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `compu`
--

--
-- Dumping data for table `proveedores`
--

INSERT INTO `proveedores` (`id`, `nombre`, `direccion`, `telefono`, `created_at`, `updated_at`) VALUES
(1, 'Intcomex', '27 ave. A 18-15 zona', '(502) 2418-1', '2015-02-16 17:23:57', '2015-02-16 17:23:57'),
(2, 'USA', 'Miami', '(001) 2323-2', '2015-02-16 17:23:57', '2015-02-16 17:23:57'),
(3, 'Omega', '40 calle 22-85 zona ', '(502) 2380-0', '2015-02-16 17:23:57', '2015-02-16 17:23:57'),
(4, 'Bodega', 'Chiquimula', '(502)4154-63', '2015-02-16 17:23:57', '2015-02-16 17:23:57'),
(5, 'Abanico', '15 Av. 0-30 Zona 11 ', '(502) 2472-8', '2015-02-16 17:23:57', '2015-02-16 17:23:57'),
(6, 'Intelaf', '6ta Ave. 8-28 Zona 9', '(502) 2334-3', '2015-02-16 17:23:57', '2015-02-16 17:23:57'),
(7, 'Compuaccesorios', 'Boulevar Los Proceres', '(502) 2498-9', '2015-02-16 17:23:57', '2015-02-16 17:23:57'),
(8, 'Option Print', '21 Av 7-19 Zona 6 Gu', '(502) 2288-5', '2015-02-16 17:23:57', '2015-02-16 17:23:57'),
(9, 'Icensol', '2A CALLE A 15-56 ZON', '(502) 2478-2', '2015-02-16 17:23:57', '2015-02-16 17:23:57'),
(10, 'Tecnobodega', '20 Calle 24-60 Zona ', '(502) 2420-0', '2015-02-16 17:23:57', '2015-02-16 17:23:57'),
(11, 'Compusersa', 'Calle Mariscal Cruz ', '(502) 2387-2', '2015-02-16 17:23:57', '2015-02-16 17:23:57'),
(12, 'Canella', '6ta Av. Lazaro Chaco', '(502) 7934-9', '2015-02-16 17:23:57', '2015-02-16 17:23:57'),
(13, 'SUPERSONIDOS', '3ra. Ave. 10-53 Zona', '(502) 2311-4', '2015-02-16 17:23:57', '2015-02-16 17:23:57'),
(14, 'USA CPX', 'Guatemala', '(502) 2428-5', '2015-02-16 17:23:57', '2015-02-16 17:23:57'),
(15, 'Cubix', '18 Calle 24-20 Zona ', '(502) 2387-5', '2015-02-16 17:23:57', '2015-02-16 17:23:57'),
(16, 'Intel Pc', 'Quezaltepeque', '(502) 7944-0', '2015-02-16 17:23:57', '2015-02-16 17:23:57'),
(17, 'Telnet S. A.', '11 calle 3-06 zona 9', '23622199', '2015-02-16 17:23:57', '2015-02-16 17:23:57'),
(18, 'Fotolab', '4ta Calle 3-23 Zona ', '(502) 4214-3', '2015-02-16 17:23:57', '2015-02-16 17:23:57'),
(19, 'Comercializador', '5ta calle 2-56 z.13 ', '(502) 2475-3', '2015-02-16 17:23:57', '2015-02-16 17:23:57'),
(20, 'Milita', 'Chiquimula', '(502) 7942-0', '2015-02-16 17:23:57', '2015-02-16 17:23:57'),
(21, 'SAT', 'gutemala ', '(502) 2326-2', '2015-02-16 17:23:57', '2015-02-16 17:23:57'),
(22, 'Multi Ventas', 'Chiquimula', '(502) 4334-0', '2015-02-16 17:23:57', '2015-02-16 17:23:57'),
(23, '5ND Productos ', '16 Av. 1-96 Zona 15 ', '(502) 2386-1', '2015-02-16 17:23:57', '2015-02-16 17:23:57'),
(25, 'Distribuidora Mayoreos Del Norte', '4a. Calle 3-23, Zona 10 Guatemala', '(502) 0000-1', '2015-02-16 17:23:57', '2015-02-16 17:23:57'),
(28, 'Soluciones Totales ', '10 Calle 0-26 Zona 10 Guatemala', '24987000', '2015-02-16 17:23:57', '2015-02-16 17:23:57'),
(31, 'FERCA, S.A.', '3ra. Av. 10-90 Zona 9 Guatemala', '2379-9074', '2015-02-16 17:23:57', '2015-02-16 17:23:57'),
(32, 'Dicoher', 'Boulevard El Naranjo, Bodega 3 Mixco, Guatemala', '2484-8174', '2015-02-16 17:23:57', '2015-02-16 17:23:57'),
(34, 'Retail', '17 Calle 10-41 Zona 11 Col. Mariscal Guatemala', '24731717', '2015-02-16 17:23:57', '2015-02-16 17:23:57'),
(35, 'Grupo M', '19. Calle A 31-21, Zona 7, Villa Linda III', '5691-3328', '2015-02-16 17:23:57', '2015-02-16 17:23:57'),
(37, 'Inteligencia Elite, S.A.', 'Col. Nueva Montserrat, Mixco Guatemala', '(502) 2463-8', '2015-02-16 17:23:57', '2015-02-16 17:23:57'),
(38, 'SERCONET', 'Calzada San Juan 14-06 CC montserrat Z4 Mixco', '2437-3779', '2015-02-16 17:23:57', '2015-02-16 17:23:57'),
(39, 'Negocios Globales', 'Av. Reforma 1-90 Zona 9 Edif. Masval Nivel 9 Of. 9', '23616094', '2015-02-16 17:23:57', '2015-02-16 17:23:57'),
(40, 'Unica', 'Ciudad', '(502) 1111-1', '2015-02-16 17:23:57', '2015-02-16 17:23:57'),
(41, 'BODECO', 'Boulevard El Naranjo 28-98 Z.4 Bodega 2', '2505-8905', '2015-02-16 17:23:57', '2015-02-16 17:23:57'),
(42, 'Combo', '', '', '2015-02-16 17:23:57', '2015-02-16 17:23:57'),
(43, 'CLICK', 'Chiquimula', '7942-1383', '2015-02-16 17:23:57', '2015-02-16 17:23:57'),
(44, 'Piezas', '', '', '2015-02-16 17:23:57', '2015-02-16 17:23:57'),
(45, 'Usa Miami', '', '', '2015-02-16 17:23:57', '2015-02-16 17:23:57'),
(46, 'Printer', 'Chiquimula', '7942-6167', '2015-02-16 17:23:57', '2015-02-16 17:23:57'),
(47, 'Macrosistemas', '7a. Calle A 11-51 Zona 1 2do. Nivel', '24140300', '2015-02-16 17:23:57', '2015-02-16 17:23:57'),
(48, 'Click Pradera', 'Chiquimula', '79438184', '2015-02-16 17:23:57', '2015-02-16 17:23:57'),
(49, 'Atlantic International ', '22 calle  9-53 zona 16 C.C paseo cayala, local f1-205b', '2493-8182', '2015-02-16 17:23:57', '2015-02-16 17:23:57'),
(50, 'Garantias', 'Ciudad', '0', '2015-02-16 17:23:57', '2015-02-16 17:23:57'),
(51, 'IMEQCO S A', '5a. Av. 3-05 Zona 8 Mixco C.C. San Cristobal Local 21A', '24602806', '2015-02-16 17:23:57', '2015-02-16 17:23:57'),
(52, 'Ajuste de inventario', 'Chiquimula', '1', '2015-02-16 17:23:57', '2015-02-16 17:23:57'),
(53, 'Texaco', 'Chiquimula', '79422090', '2015-02-16 17:23:57', '2015-02-16 17:23:57'),
(54, 'proveedor de prueba', 'Guatemala', '54545', '2015-02-16 17:23:57', '2015-02-16 17:23:57'),
(55, 'Elca Comercial', 'Chiquimula', '79423041', '2015-02-16 17:23:57', '2015-02-16 17:23:57'),
(56, 'Operadora de Centro de Servicio S.A.', 'Chiquimula', '0', '2015-02-16 17:23:57', '2015-02-16 17:23:57'),
(57, 'Varios', 'Ciudad', '0', '2015-02-16 17:23:57', '2015-02-16 17:23:57'),
(58, 'Manolo', 'Chiquimula', '0', '2015-02-16 17:23:57', '2015-02-16 17:23:57'),
(59, 'William Trigueros (5ND)', 'Ciudad ', '0', '2015-02-16 17:23:57', '2015-02-16 17:23:57'),
(60, 'Remicro', 'Av. Reforma 15-54 Zona 9 Local 21 Guatemala', '2362-3485', '2015-02-16 17:23:57', '2015-02-16 17:23:57'),
(61, 'Edgar Calderon', 'Ciudad', '0', '2015-02-16 17:23:57', '2015-02-16 17:23:57');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
