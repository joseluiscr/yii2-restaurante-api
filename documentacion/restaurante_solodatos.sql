-- phpMyAdmin SQL Dump
-- version 4.6.6deb5
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost:3306
-- Tiempo de generación: 16-01-2019 a las 17:30:43
-- Versión del servidor: 5.7.22
-- Versión de PHP: 7.1.17-0ubuntu0.17.10.1


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `restaurante`
--

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
-- Volcado de datos para la tabla `plato`
--

INSERT INTO `plato` (`id`, `nombre`, `descripcion`) VALUES
(1, 'plato1', 'Este es el plato 1'),
(2, 'plato2', 'Este es el plato 2'),
(3, 'plato3', 'Este es el plato 3');

-- --------------------------------------------------------

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

