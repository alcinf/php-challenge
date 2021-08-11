-- phpMyAdmin SQL Dump
-- version 4.5.4.1deb2ubuntu2.1
-- http://www.phpmyadmin.net
--
-- Servidor: localhost
-- Tiempo de generación: 11-08-2021 a las 11:26:07
-- Versión del servidor: 10.0.38-MariaDB-0ubuntu0.16.04.1
-- Versión de PHP: 7.4.18

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `php-challenge`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `stock`
--

CREATE TABLE `stock` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `name` varchar(190) NOT NULL,
  `symbol` varchar(20) NOT NULL,
  `open` decimal(10,4) NOT NULL,
  `high` decimal(10,4) NOT NULL,
  `low` decimal(10,4) NOT NULL,
  `close` decimal(10,4) NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `stock`
--

INSERT INTO `stock` (`id`, `user_id`, `name`, `symbol`, `open`, `high`, `low`, `close`, `date`) VALUES
(1, 3, 'APPLE', 'AAPL.US', '146.0000', '147.0000', '146.0000', '146.0000', '2021-08-11 15:57:24'),
(2, 3, 'UBER TECHNOLOGIES', '0A1U.UK', '44.0000', '44.0000', '42.0000', '42.0000', '2021-08-11 15:59:44'),
(3, 3, 'UBER TECHNOLOGIES', '0A1U.UK', '44.0000', '44.0000', '42.0000', '42.0000', '2021-08-11 16:01:21'),
(4, 3, 'UBER TECHNOLOGIES', '0A1U.UK', '43.5600', '43.5600', '42.1000', '42.1116', '2021-08-11 16:02:53'),
(5, 4, 'UBER TECHNOLOGIES', '0A1U.UK', '43.5600', '43.5600', '42.1000', '42.1116', '2021-08-11 16:04:09'),
(6, 4, 'APPLE', 'AAPL.US', '146.0500', '146.7200', '145.5300', '145.7400', '2021-08-11 16:04:25');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(190) NOT NULL,
  `email` varchar(190) NOT NULL,
  `pass` varchar(70) NOT NULL,
  `last_update` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `pass`, `last_update`) VALUES
(3, 'Test 1', 'test1@example.com', '$2y$10$Uvv3Xcx7X/trtrb/YRBl8uYZyQHZJoyRNkMSpKqiSLYCO5OU3M9o6', '2021-08-11 05:10:32'),
(4, 'Test 2', 'test2@example.com', '$2y$10$2z94H.kjeU7duNUP87YhFe1SHdKvL3cKvWtkDrzNK6KBmB7Dn/Bc.', '2021-08-11 16:03:48');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `stock`
--
ALTER TABLE `stock`
  ADD PRIMARY KEY (`id`),
  ADD KEY `stock2` (`user_id`),
  ADD KEY `stock3` (`symbol`);

--
-- Indices de la tabla `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users2` (`email`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `stock`
--
ALTER TABLE `stock`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT de la tabla `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
