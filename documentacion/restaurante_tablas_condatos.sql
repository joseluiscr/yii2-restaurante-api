-- phpMyAdmin SQL Dump
-- version 4.6.6deb5
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost:3306
-- Tiempo de generación: 16-01-2019 a las 17:30:43
-- Versión del servidor: 5.7.22
-- Versión de PHP: 7.1.17-0ubuntu0.17.10.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `restaurante`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `alergeno`
--

CREATE TABLE `alergeno` (
  `id` int(11) NOT NULL COMMENT 'id unico del alergeno',
  `nombre` varchar(30) NOT NULL COMMENT 'nombre del alergeno',
  `descripcion` varchar(100) DEFAULT NULL COMMENT 'texto libre aclaratorio'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Listado de alergenos';

--
-- Volcado de datos para la tabla `alergeno`
--

INSERT INTO `alergeno` (`id`, `nombre`, `descripcion`) VALUES
(1, 'alergeno1', 'Este es el alergeno 1'),
(2, 'alergeno2', 'Este es el alergeno 2'),
(3, 'alergeno3', 'Este es el alergeno 3'),
(4, 'alergeno4', 'Este es el alergeno 4'),
(5, 'alergeno5', 'Este es el alergeno 5');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ingrediente`
--

CREATE TABLE `ingrediente` (
  `id` int(11) NOT NULL COMMENT 'id unico del ingrediente',
  `nombre` varchar(30) NOT NULL COMMENT 'nombre del ingrediente',
  `descripcion` varchar(100) DEFAULT NULL COMMENT 'texto libre aclaratorio'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Lista de ingredientes';

--
-- Volcado de datos para la tabla `ingrediente`
--

INSERT INTO `ingrediente` (`id`, `nombre`, `descripcion`) VALUES
(1, 'ingrediente1', 'Este es el ingrediente 1'),
(2, 'ingrediente2', 'Este es el ingrediente 2'),
(3, 'ingrediente3', 'Este es el ingrediente 3'),
(4, 'ingrediente4', 'Este es el ingrediente 4'),
(5, 'ingrediente5', 'Este es el ingrediente 5');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ingr_alergeno`
--

CREATE TABLE `ingr_alergeno` (
  `id_ingrediente` int(11) NOT NULL COMMENT 'id del ingrediente',
  `id_alergeno` int(11) NOT NULL COMMENT 'id del alergeno'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Contiene los alergenos de cada ingrediente';

--
-- Volcado de datos para la tabla `ingr_alergeno`
--

INSERT INTO `ingr_alergeno` (`id_ingrediente`, `id_alergeno`) VALUES
(2, 1),
(3, 1),
(2, 2),
(1, 3),
(3, 3),
(1, 4),
(3, 4),
(5, 4);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `plato`
--

CREATE TABLE `plato` (
  `id` int(11) NOT NULL COMMENT 'id unico del plato',
  `nombre` varchar(30) NOT NULL COMMENT 'nombre del plato',
  `descripcion` varchar(100) DEFAULT NULL COMMENT 'texto libre aclaratorio'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Lista de platos';

--
-- Volcado de datos para la tabla `plato`
--

INSERT INTO `plato` (`id`, `nombre`, `descripcion`) VALUES
(1, 'plato1', 'Este es el plato 1'),
(2, 'plato2', 'Este es el plato 2'),
(3, 'plato3', 'Este es el plato 3');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `plato_ingrediente`
--

CREATE TABLE `plato_ingrediente` (
  `id_plato` int(11) NOT NULL COMMENT 'id del plato',
  `id_ingrediente` int(11) NOT NULL COMMENT 'id del ingrediente'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Contiene los ingredientes de cada plato';

--
-- Volcado de datos para la tabla `plato_ingrediente`
--

INSERT INTO `plato_ingrediente` (`id_plato`, `id_ingrediente`) VALUES
(1, 1),
(2, 1),
(1, 2),
(3, 2),
(1, 3),
(2, 3),
(3, 5);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `plato_ingrediente_cambio`
--

CREATE TABLE `plato_ingrediente_cambio` (
  `id_plato` int(11) NOT NULL COMMENT 'id del plato afectado por el cambio',
  `id_ingrediente` int(11) NOT NULL COMMENT 'id del ingrediente anadido o eliminado',
  `orden_cambio` int(11) NOT NULL COMMENT 'num de orden del cambio para un plato concreto',
  `fecha_cambio` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'fecha y hora del cambio',
  `accion` int(11) NOT NULL COMMENT 'Indica la accion realizada sobre el ingrediente del plato: 1-anadir al plato, 2-eliminar del plato'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Contiene los cambios hechos en los ingredientes de un plato';

--
-- Volcado de datos para la tabla `plato_ingrediente_cambio`
--

INSERT INTO `plato_ingrediente_cambio` (`id_plato`, `id_ingrediente`, `orden_cambio`, `fecha_cambio`, `accion`) VALUES
(1, 1, 1, '2019-01-16 17:26:53', 1),
(1, 2, 0, '2019-01-16 17:26:53', 1),
(1, 3, 0, '2019-01-16 17:26:53', 1),
(1, 4, 0, '2019-01-16 17:26:53', 1),
(1, 4, 1, '2019-01-16 17:26:53', 2),
(2, 1, 0, '2019-01-16 17:28:24', 1),
(2, 3, 0, '2019-01-16 17:28:24', 1),
(3, 1, 0, '2019-01-16 17:28:24', 1),
(3, 1, 1, '2019-01-16 17:28:24', 2),
(3, 2, 1, '2019-01-16 17:28:46', 1),
(3, 5, 0, '2019-01-16 17:28:24', 1);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `alergeno`
--
ALTER TABLE `alergeno`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `ingrediente`
--
ALTER TABLE `ingrediente`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `ingr_alergeno`
--
ALTER TABLE `ingr_alergeno`
  ADD PRIMARY KEY (`id_ingrediente`,`id_alergeno`),
  ADD KEY `fk_ingralergeno_alergeno` (`id_alergeno`);

--
-- Indices de la tabla `plato`
--
ALTER TABLE `plato`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `plato_ingrediente`
--
ALTER TABLE `plato_ingrediente`
  ADD PRIMARY KEY (`id_plato`,`id_ingrediente`),
  ADD KEY `fk_platoingr_ingrediente` (`id_ingrediente`);

--
-- Indices de la tabla `plato_ingrediente_cambio`
--
ALTER TABLE `plato_ingrediente_cambio`
  ADD PRIMARY KEY (`id_plato`,`id_ingrediente`,`orden_cambio`,`accion`),
  ADD KEY `idx_platoingrcambio_idplato` (`id_plato`),
  ADD KEY `fk_platoingrcambio_ingr` (`id_ingrediente`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `alergeno`
--
ALTER TABLE `alergeno`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'id unico del alergeno', AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT de la tabla `ingrediente`
--
ALTER TABLE `ingrediente`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'id unico del ingrediente', AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT de la tabla `plato`
--
ALTER TABLE `plato`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'id unico del plato', AUTO_INCREMENT=12;
--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `ingr_alergeno`
--
ALTER TABLE `ingr_alergeno`
  ADD CONSTRAINT `fk_ingralergeno_alergeno` FOREIGN KEY (`id_alergeno`) REFERENCES `alergeno` (`id`),
  ADD CONSTRAINT `fk_ingralergeno_ingrediente` FOREIGN KEY (`id_ingrediente`) REFERENCES `ingrediente` (`id`);

--
-- Filtros para la tabla `plato_ingrediente`
--
ALTER TABLE `plato_ingrediente`
  ADD CONSTRAINT `fk_platoingr_ingrediente` FOREIGN KEY (`id_ingrediente`) REFERENCES `ingrediente` (`id`),
  ADD CONSTRAINT `fk_platoingr_plato` FOREIGN KEY (`id_plato`) REFERENCES `plato` (`id`);

--
-- Filtros para la tabla `plato_ingrediente_cambio`
--
ALTER TABLE `plato_ingrediente_cambio`
  ADD CONSTRAINT `fk_platoingrcambio_ingr` FOREIGN KEY (`id_ingrediente`) REFERENCES `ingrediente` (`id`),
  ADD CONSTRAINT `fk_platoingrcambio_plato` FOREIGN KEY (`id_plato`) REFERENCES `plato` (`id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
