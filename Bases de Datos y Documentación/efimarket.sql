-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 30-07-2024 a las 17:55:17
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
(2, 1, 'Barbershop Angel Restrepo', 'Barbería', 'Calle 32C #27A43', '3196516362', 'instagram.com/xngxllw', 4, 'Fines de Semana', 'barbershopangel.jpg'),
(3, 2, 'Taller Crazy Mechanics', 'Taller de Motos', 'Carrera 30 #32 17', '3022995856', '', 4, '8:00am a 7:00pm', 'crazymechanics.jpg'),
(5, 4, 'La Esquina Canina', 'Tienda de Mascotas', 'Cll 32 # 32a-29', '3126300036', '', 7, 'Lunes a sábado 10AM a 9PM', 'esquinacanina.jpeg'),
(6, 5, 'Mercado La 30', 'Supermercado', 'CRR 30 #32-68', '3166710674', '', 1, '7:20AM a 9:00PM', 'mercadola30.jpeg'),
(7, 6, 'Tienda de Carnes Loreto', 'Carniceria', 'CLL 32 # 29A-35', '3218016805', '', 6, '7:30AM A 8:00PM', 'carnesloreto.jpeg'),
(8, 7, 'Ricuras La Milagrosa', 'Panadería y Repostería', 'CLL 38F #28A-04', '3108244136', 'm.facebook.com/61559767821360', 2, '24/7', 'ricurasmilagrosa.png'),
(9, 7, 'Delicias Loreto', 'Panadería y Repostería', 'CRR 30 #35-19A 35-1', '3108244136', '', 2, '24/7', 'deliciasloreto.png'),
(10, 8, 'Saturn Merch', 'Tienda de Ropa', 'Online', '3106702810', '', 8, '24/7', 'Logo Saturn azul.png'),
(11, 10, 'Mobiliario Eskuadra', 'Tapicería de muebles', 'CLL32 #29-10', '3145018489', '', 4, '8.00AM  a 9PM', 'eskuadra.jpeg'),
(13, 12, 'Revuelteria Marquetalia', 'Revuelteria', 'CLL32 30-3', '3013343433', '', 9, '8:30 AM a 8:00PM', 'revuelteriamarquetalia.png');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id_usuario` int(11) NOT NULL,
  `nombre` varchar(50) DEFAULT NULL,
  `correo` varchar(50) DEFAULT NULL,
  `contrasena` varchar(25) NOT NULL,
  `rol` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id_usuario`, `nombre`, `correo`, `contrasena`, `rol`) VALUES
(1, 'Angel Restrepo', 'miguelrpo05@gmail.com', 'a1036451368', 'admin'),
(2, 'Josué Quintero', 'mecanicoslocos1225@gmail.com', 'josue.efimarket123', 'admin'),
(3, 'testClienteeeeeee', 'a@a.com', '123456789', 'cliente'),
(4, 'Erika Sanchez', 'laesquinacanina18@gmail.com', 'erika.efimarket123', 'admin'),
(5, 'Edison Duque', 'edi3110du@gmail.com', 'edison.efimarket123', 'admin'),
(6, 'David Cruz', 'tiendadecarnesloreto@gmail.com', 'david.efimarket123', 'admin'),
(7, 'Rodinson Franco', 'panaderiasefimarket@gmail.com', 'rodinson.efimarket123', 'admin'),
(8, 'samuel zapata', 'samuelocampo65z@gmail.com', 'tomasamuel', 'admin'),
(10, 'Alan J Ramirez R', 'alan3771@hotmail.com', 'alan.efimarket123', 'admin'),
(11, 'Juan G', 'juanfervilla2007@gmail.com', 'Prueba0123', 'admin'),
(12, 'Miguel Carmona', 'marcelita1043@gmail.com', 'miguel.efimarket123', 'admin');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `categorias`
--
ALTER TABLE `categorias`
  ADD PRIMARY KEY (`id_categoria`);

--
-- Indices de la tabla `negocios`
--
ALTER TABLE `negocios`
  ADD PRIMARY KEY (`id_negocio`),
  ADD KEY `id_usuario` (`id_usuario`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id_usuario`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `categorias`
--
ALTER TABLE `categorias`
  MODIFY `id_categoria` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT de la tabla `negocios`
--
ALTER TABLE `negocios`
  MODIFY `id_negocio` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id_usuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
