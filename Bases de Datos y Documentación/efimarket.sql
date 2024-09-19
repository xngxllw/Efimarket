-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 19-09-2024 a las 05:05:38
-- Versión del servidor: 10.4.28-MariaDB
-- Versión de PHP: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `efimarket`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categorias`
--

CREATE TABLE `categorias` (
  `id_categoria` bigint(20) UNSIGNED NOT NULL,
  `nombre_categoria` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `categorias`
--

INSERT INTO `categorias` (`id_categoria`, `nombre_categoria`) VALUES
(1, 'despensa'),
(2, 'panaderia'),
(3, 'rapidas'),
(4, 'servicios'),
(5, 'farmacia'),
(6, 'carnicos'),
(7, 'mascotas'),
(8, 'ropa'),
(9, 'frutas');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `contacto`
--

CREATE TABLE `contacto` (
  `id` int(11) NOT NULL,
  `correo` varchar(255) NOT NULL,
  `mensaje` text NOT NULL,
  `fecha` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `contacto`
--

INSERT INTO `contacto` (`id`, `correo`, `mensaje`, `fecha`) VALUES
(1, 'miguelrpo05@gmail.com', 'hola', '2024-09-17 13:13:44'),
(2, 'miguelrpo05@gmail.com', 'hola', '2024-09-17 13:14:15'),
(3, 'miguelrpo05@gmail.com', 'hola', '2024-09-17 13:14:24'),
(4, 'miguelrpo05@gmail.com', 'hola', '2024-09-17 13:14:36'),
(5, 'miguelrpo05@gmail.com', 'hola', '2024-09-19 02:55:29');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `negocios`
--

CREATE TABLE `negocios` (
  `id_negocio` bigint(20) UNSIGNED NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `nombre_negocio` varchar(100) NOT NULL,
  `descripcion` varchar(255) DEFAULT NULL,
  `direccion` varchar(255) DEFAULT NULL,
  `telefono` varchar(20) DEFAULT NULL,
  `sitio_web` varchar(100) DEFAULT NULL,
  `id_categoria` int(11) DEFAULT NULL,
  `horario` varchar(255) NOT NULL,
  `logo` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `negocios`
--

INSERT INTO `negocios` (`id_negocio`, `id_usuario`, `nombre_negocio`, `descripcion`, `direccion`, `telefono`, `sitio_web`, `id_categoria`, `horario`, `logo`) VALUES
(2, 1, 'Barber Angel Restrepo', 'Barbería', 'CLL 32C #27A43', '3196516362', 'instagram.com/xngxllw', 4, 'Fines de Semana', 'barbershopangel.jpg'),
(3, 2, 'Taller Crazy Mechanics', 'Taller de Motos', 'Carrera 30 #32 17', '3022995856', '', 4, '8:00am a 7:00pm', 'crazymechanics.jpg'),
(5, 4, 'La Esquina Canina', 'Tienda de Mascotas', 'Cll 32 # 32a-29', '3126300036', '', 7, 'Lunes a sábado 10AM a 9PM', 'esquinacanina.jpeg'),
(6, 5, 'Mercado La 30', 'Supermercado', 'CRR 30 #32-68', '3166710674', '', 1, '7:20AM a 9:00PM', 'mercadola30.jpeg'),
(7, 6, 'Tienda de Carnes Loreto', 'Carniceria', 'CLL 32 # 29A-35', '3218016805', '', 6, '7:30AM A 8:00PM', 'carnesloreto.jpeg'),
(8, 7, 'Ricuras La Milagrosa', 'Panadería y Repostería', 'CLL 38F #28A-04', '3108244136', 'm.facebook.com/61559767821360', 2, '24/7', 'ricurasmilagrosa.png'),
(9, 7, 'Delicias Loreto', 'Panadería y Repostería', 'CRR 30 #35-19A 35-1', '3108244136', '', 2, '24/7', 'deliciasloreto.png'),
(10, 8, 'Saturn Merch', 'Tienda de Ropa', 'Online', '3106702810', '', 8, '24/7', 'Logo Saturn azul.png'),
(11, 10, 'Mobiliario Eskuadra', 'Tapicería de muebles', 'CLL32 #29-10', '3135435447', '', 4, '8.00AM  a 9PM', 'eskuadra.jpeg'),
(12, 1, 'Milagrito Café', 'Móvil de Café', 'CLL 32C #27A43', '3022397164', 'instagram.com/milagritocafemovil', 2, '4:00PM a 8:00PM', 'milagrito.jpeg'),
(16, 11, 'Pinkittyglam', 'Tienda de Maquillaje Online', 'Online', '3158170408', 'instagram.com/pinkittyglam', 5, '24/7', 'pinkittyglam.jpg'),
(17, 8, 'AZ Parfums', 'Perfumería', 'Online', '3196516362', 'instagram.com/azparfums', 5, '24/7', 'logoAZparfums.jpeg'),
(19, 12, 'Arte de Uñas', 'Belleza y autocuidado', 'Carrera 30 #32 17', '3167927622', '', 5, '9:00a.m a 7:00p.m', 'Arte de Uñas.jfif'),
(21, 15, 'Laboratorio Yada Dental', 'Clínica Dental', 'Carrera 36A #40-90', '3136933101', 'no aplica', 5, '8:00A.M. a 6:30P.M.', 'yadadental.jpeg'),
(22, 16, 'Revueltería Marquetalia', 'Fruver', 'CLL 32 #32-3', '3122202569', 'No aplica', 9, '8:00A.M a 8:00P.M', 'marquetalia.png');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `postulaciones`
--

CREATE TABLE `postulaciones` (
  `id_postulacion` bigint(20) UNSIGNED NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `id_negocio` bigint(20) UNSIGNED NOT NULL,
  `nombres` varchar(100) NOT NULL,
  `apellidos` varchar(100) NOT NULL,
  `edad` int(3) NOT NULL,
  `tipo_documento` varchar(50) NOT NULL,
  `documento_identidad` varchar(20) NOT NULL,
  `celular` varchar(20) NOT NULL,
  `correo_electronico` varchar(100) NOT NULL,
  `acepta_terminos` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `productos`
--

CREATE TABLE `productos` (
  `id_producto` int(11) NOT NULL,
  `id_negocio` int(11) NOT NULL,
  `nombre_producto` varchar(255) NOT NULL,
  `foto_producto` varchar(255) DEFAULT NULL,
  `id_usuario` int(11) NOT NULL,
  `precio` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `productos`
--

INSERT INTO `productos` (`id_producto`, `id_negocio`, `nombre_producto`, `foto_producto`, `id_usuario`, `precio`) VALUES
(11, 12, 'Frappe', 'frappe.jpg', 1, 6500),
(12, 12, 'Malteada', 'frappe.jpg', 1, 6900),
(13, 12, 'Latte', 'frappe.jpg', 1, 3800),
(14, 12, 'Capuccino', 'frappe.jpg', 1, 6200),
(15, 12, 'Torta de Almójabana', 'frappe.jpg', 1, 5800),
(16, 10, 'Camisa 🪐S🪐', 'camisa.png', 8, 70000),
(17, 10, 'Cadena 🪐', 'cadena.png', 8, 20000),
(18, 17, 'Ultramale', 'ultramale.jpg', 8, 15000),
(19, 17, 'Scandal', 'scandal.jpg', 8, 15000),
(20, 17, 'Sauvage EDP', 'sauvageedp.jpg', 8, 15000),
(21, 11, 'Closet', 'closet.jpg', 10, 1900000),
(22, 11, 'Closet Móvil', 'closetMovil.jpg', 10, 2500000),
(23, 11, 'Cocina Integral', 'cocinaIntegral.jpg', 10, 4000000),
(24, 11, 'Cocina', 'cocina.jpg', 10, 3500000),
(25, 11, 'Reparación Muebles', 'reparacionMuebles.jpg', 10, 0),
(27, 16, 'Kit x3 cosmetiqueras', 'kitcosmetiqueras.jpg', 11, 35000),
(28, 16, 'Gorro y Moña de Satín', 'gorroymoñadesatin.jpg', 11, 15000),
(29, 16, 'Toalla Microfibra', 'toallamicrofibra.jpg', 11, 13000),
(30, 16, 'Kit Facial Bioaqua', 'kitfacialarroz.jpg', 11, 55000),
(31, 16, 'Termo Stanley 1.1', 'termostanley.jpg', 11, 92000),
(32, 18, 'Uñas Acrilicas', 'uñas.jfif', 12, 70000),
(33, 18, 'Uñas Acrilicas', 'uñass.jfif', 12, 70000),
(34, 18, 'Uñas Acrilicas', 'Uñas acrilicas.jfif', 12, 70000),
(35, 21, 'Nuestros Servicios', 'yadaa.jpg', 15, 999),
(36, 19, 'Uñas', 'uñas.jfif', 12, 70000),
(37, 8, 'Combo 1', 'combo1.jpg', 7, 0),
(38, 8, 'Combo 2', 'combo2.jpg', 7, 0),
(39, 8, 'Combo 3', 'combo3.jpg', 7, 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `reseñas`
--

CREATE TABLE `reseñas` (
  `id` int(11) NOT NULL,
  `id_negocio` int(11) NOT NULL,
  `calificacion` int(11) DEFAULT NULL CHECK (`calificacion` >= 1 and `calificacion` <= 5),
  `comentario` text DEFAULT NULL,
  `fecha` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `reseñas`
--

INSERT INTO `reseñas` (`id`, `id_negocio`, `calificacion`, `comentario`, `fecha`) VALUES
(1, 12, 5, 'Excelente', '2024-09-17 12:59:06'),
(2, 12, 5, 'Excelente', '2024-09-17 12:59:13'),
(3, 12, 5, 'Excelente', '2024-09-17 13:00:10'),
(4, 12, 5, 'Excelente', '2024-09-17 13:05:34'),
(5, 12, 5, 'Muy bueno todo', '2024-09-17 13:06:10'),
(6, 12, 5, 'Hola', '2024-09-17 13:06:53'),
(7, 12, 5, 'hola', '2024-09-17 13:07:06'),
(8, 9, 4, 'chimba de pan', '2024-09-17 13:07:28');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id_usuario` int(11) NOT NULL,
  `nombre` varchar(50) DEFAULT NULL,
  `correo` varchar(50) DEFAULT NULL,
  `contrasena` varchar(25) NOT NULL,
  `rol` varchar(15) NOT NULL,
  `plan` int(11) DEFAULT 1,
  `xp` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id_usuario`, `nombre`, `correo`, `contrasena`, `rol`, `plan`, `xp`) VALUES
(1, 'Angel Restrepo', 'angel@efimarket.com', '123', 'admin', 3, 4501),
(2, 'Josué Quintero', 'mecanicoslocos1225@gmail.com', 'josue.efimarket123', 'admin', 1, 0),
(3, 'testClienteeeeeee', 'cliente@efimarket.com', '123', 'cliente', 1, 0),
(4, 'Erika Sanchez', 'laesquinacanina18@gmail.com', 'erika.efimarket123', 'admin', 1, 0),
(5, 'Edison Duque', 'edi3110du@gmail.com', 'edison.efimarket123', 'admin', 1, 0),
(6, 'David Cruz', 'tiendadecarnesloreto@gmail.com', 'david.efimarket123', 'admin', 1, 0),
(7, 'Rodinson Franco', 'panaderiasefimarket@gmail.com', 'rodinson.efimarket123', 'admin', 1, 0),
(8, 'samuel zapata', 'samuelocampo65z@gmail.com', 'tomasamuel', 'admin', 3, 10000),
(10, 'Alan J Ramirez R', 'alan3771@hotmail.com', 'alan.efimarket123', 'admin', 3, 0),
(11, 'Mariana Acevedo', 'dulcemarizz3240@gmail.com', 'mariana.efimarket123', 'admin', 1, 0),
(12, 'Valentina López', 'Valentina140821lopez@gmail.com', 'valentina.efimarket123', 'admin', 1, 0),
(14, 'Miguel Ramírez', 'mramirezjaramillo3@gmail.com', 'ramirezprime123', 'admin', 3, 10000),
(15, 'Dairo Grizales', 'carlosgrizales00@gmail.com', 'dairo.efimarket123', 'admin', 1, 0),
(16, 'Miguel Carmona', 'marcelita1043@gmail.com', 'miguel.efimarket123', 'admin', 1, 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `vacantes`
--

CREATE TABLE `vacantes` (
  `id_vacante` int(11) NOT NULL,
  `id_negocio` int(11) NOT NULL,
  `ocupacion` varchar(255) NOT NULL,
  `descripcion` text NOT NULL,
  `requisitos` text NOT NULL,
  `horario` varchar(255) NOT NULL,
  `salario` varchar(255) NOT NULL,
  `fecha` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `vacantes`
--

INSERT INTO `vacantes` (`id_vacante`, `id_negocio`, `ocupacion`, `descripcion`, `requisitos`, `horario`, `salario`, `fecha`) VALUES
(5, 12, 'Domiciliario', 'Domiciliario', 'Licencia de Moto a2', '7:00am a 6:00pm', '0', '2024-09-19 01:06:21');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `categorias`
--
ALTER TABLE `categorias`
  ADD PRIMARY KEY (`id_categoria`);

--
-- Indices de la tabla `contacto`
--
ALTER TABLE `contacto`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `negocios`
--
ALTER TABLE `negocios`
  ADD PRIMARY KEY (`id_negocio`),
  ADD KEY `id_usuario` (`id_usuario`);

--
-- Indices de la tabla `postulaciones`
--
ALTER TABLE `postulaciones`
  ADD PRIMARY KEY (`id_postulacion`);

--
-- Indices de la tabla `productos`
--
ALTER TABLE `productos`
  ADD PRIMARY KEY (`id_producto`);

--
-- Indices de la tabla `reseñas`
--
ALTER TABLE `reseñas`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id_usuario`);

--
-- Indices de la tabla `vacantes`
--
ALTER TABLE `vacantes`
  ADD PRIMARY KEY (`id_vacante`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `categorias`
--
ALTER TABLE `categorias`
  MODIFY `id_categoria` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT de la tabla `contacto`
--
ALTER TABLE `contacto`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `negocios`
--
ALTER TABLE `negocios`
  MODIFY `id_negocio` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT de la tabla `postulaciones`
--
ALTER TABLE `postulaciones`
  MODIFY `id_postulacion` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `productos`
--
ALTER TABLE `productos`
  MODIFY `id_producto` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;

--
-- AUTO_INCREMENT de la tabla `reseñas`
--
ALTER TABLE `reseñas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id_usuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT de la tabla `vacantes`
--
ALTER TABLE `vacantes`
  MODIFY `id_vacante` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
