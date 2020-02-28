-- phpMyAdmin SQL Dump
-- version 5.0.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 28-02-2020 a las 21:03:47
-- Versión del servidor: 10.4.11-MariaDB
-- Versión de PHP: 7.4.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `comanda`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `logs`
--

CREATE TABLE `logs` (
  `id` int(11) NOT NULL,
  `user` int(11) DEFAULT NULL,
  `ip` varchar(20) COLLATE latin1_spanish_ci NOT NULL,
  `action` varchar(20) COLLATE latin1_spanish_ci NOT NULL,
  `resource` tinytext COLLATE latin1_spanish_ci NOT NULL,
  `request` text COLLATE latin1_spanish_ci NOT NULL,
  `response` text COLLATE latin1_spanish_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL,
  `removed_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `menu`
--

CREATE TABLE `menu` (
  `id` int(11) NOT NULL,
  `name` varchar(50) COLLATE latin1_spanish_ci NOT NULL,
  `description` tinytext COLLATE latin1_spanish_ci NOT NULL,
  `price` decimal(10,2) NOT NULL DEFAULT 0.00,
  `stock` int(11) NOT NULL,
  `role` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL,
  `removed_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;

--
-- Volcado de datos para la tabla `menu`
--

INSERT INTO `menu` (`id`, `name`, `description`, `price`, `stock`, `role`, `created_at`, `updated_at`, `removed_at`) VALUES
(2, 'Pizza', 'Masa crujiente cocinada en horno de piedra con fino colchón de salsa de tomate y cuajo vacuno derretido', '232.00', 24, 5, '2020-02-26 23:08:34', '2020-02-28 13:17:32', NULL),
(4, 'Empanadas', 'Carne, pollo o verdura', '30.00', 100, 5, '2020-02-26 23:41:42', NULL, NULL),
(6, 'Cerveza', 'Cerveza artesanal', '150.00', 68, 6, '2020-02-26 23:46:39', NULL, NULL),
(7, 'Vinito', 'Vino em rico', '102.00', 28, 4, '2020-02-26 23:47:14', '2020-02-27 05:47:24', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `orders`
--

CREATE TABLE `orders` (
  `code` varchar(5) COLLATE latin1_spanish_ci NOT NULL,
  `state` int(11) NOT NULL DEFAULT 0,
  `user` int(11) NOT NULL,
  `table` varchar(5) COLLATE latin1_spanish_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL,
  `removed_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;

--
-- Volcado de datos para la tabla `orders`
--

INSERT INTO `orders` (`code`, `state`, `user`, `table`, `created_at`, `updated_at`, `removed_at`) VALUES
('6m65r', 0, 32, 'me001', '2020-02-28 13:03:20', NULL, NULL),
('asqyf', 0, 32, 'me001', '2020-02-28 11:55:31', NULL, NULL),
('kq8tw', 0, 32, 'me002', '2020-02-28 11:56:58', NULL, NULL),
('xaarr', 0, 30, 'me002', '2020-02-28 19:41:10', NULL, NULL),
('yywoe', 0, 30, 'me001', '2020-02-28 19:40:52', NULL, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `order_details`
--

CREATE TABLE `order_details` (
  `id` int(11) NOT NULL,
  `user` int(11) DEFAULT NULL,
  `order` varchar(5) COLLATE latin1_spanish_ci NOT NULL,
  `menu` int(11) NOT NULL,
  `amount` int(11) NOT NULL DEFAULT 1,
  `state` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL,
  `removed_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;

--
-- Volcado de datos para la tabla `order_details`
--

INSERT INTO `order_details` (`id`, `user`, `order`, `menu`, `amount`, `state`, `created_at`, `updated_at`, `removed_at`) VALUES
(2, NULL, 'asqyf', 6, 1, NULL, '2020-02-28 11:55:31', NULL, NULL),
(3, NULL, 'kq8tw', 4, 3, NULL, '2020-02-28 11:56:58', NULL, NULL),
(4, NULL, 'kq8tw', 6, 1, NULL, '2020-02-28 11:56:58', NULL, NULL),
(5, NULL, '6m65r', 6, 1, NULL, '2020-02-28 13:03:20', NULL, NULL),
(6, NULL, 'yywoe', 4, 1, NULL, '2020-02-28 19:40:52', NULL, NULL),
(7, NULL, 'xaarr', 2, 3, NULL, '2020-02-28 19:41:10', NULL, NULL),
(8, NULL, 'xaarr', 4, 3, NULL, '2020-02-28 19:41:10', NULL, NULL),
(9, NULL, 'kq8tw', 6, 1, NULL, '2020-02-28 19:54:00', NULL, NULL),
(10, NULL, 'kq8tw', 6, 1, NULL, '2020-02-28 19:54:03', NULL, NULL),
(11, NULL, 'kq8tw', 6, 1, NULL, '2020-02-28 19:54:07', NULL, NULL),
(12, NULL, '6m65r', 6, 3, NULL, '2020-02-28 20:00:10', NULL, NULL),
(13, NULL, '6m65r', 4, 2, NULL, '2020-02-28 20:00:10', NULL, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `order_states`
--

CREATE TABLE `order_states` (
  `id` int(11) NOT NULL,
  `name` varchar(50) COLLATE latin1_spanish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;

--
-- Volcado de datos para la tabla `order_states`
--

INSERT INTO `order_states` (`id`, `name`) VALUES
(2, 'Done'),
(0, 'Pending'),
(1, 'Preparing'),
(3, 'Served');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `reviews`
--

CREATE TABLE `reviews` (
  `id` int(11) NOT NULL,
  `order` varchar(5) COLLATE latin1_spanish_ci NOT NULL,
  `name` varchar(25) COLLATE latin1_spanish_ci NOT NULL,
  `email` varchar(50) COLLATE latin1_spanish_ci NOT NULL,
  `description` text COLLATE latin1_spanish_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL,
  `removed_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `roles`
--

CREATE TABLE `roles` (
  `id` int(11) NOT NULL,
  `name` varchar(50) COLLATE latin1_spanish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;

--
-- Volcado de datos para la tabla `roles`
--

INSERT INTO `roles` (`id`, `name`) VALUES
(1, 'Admin'),
(4, 'Bar'),
(6, 'Brewery'),
(3, 'Floor'),
(5, 'Kitchen'),
(2, 'Manager');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tables`
--

CREATE TABLE `tables` (
  `code` varchar(5) COLLATE latin1_spanish_ci NOT NULL,
  `capacity` int(11) NOT NULL DEFAULT 0,
  `state` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL,
  `removed_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;

--
-- Volcado de datos para la tabla `tables`
--

INSERT INTO `tables` (`code`, `capacity`, `state`, `created_at`, `updated_at`, `removed_at`) VALUES
('me001', 8, 0, '2020-02-27 04:07:07', '2020-02-28 10:54:03', NULL),
('me002', 5, 0, '2020-02-27 04:16:24', '2020-02-28 10:54:05', NULL),
('me003', 7, 0, '2020-02-27 04:16:29', '2020-02-28 10:54:08', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `table_states`
--

CREATE TABLE `table_states` (
  `id` int(11) NOT NULL,
  `name` varchar(50) COLLATE latin1_spanish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;

--
-- Volcado de datos para la tabla `table_states`
--

INSERT INTO `table_states` (`id`, `name`) VALUES
(0, 'Available'),
(3, 'Paying'),
(2, 'Served'),
(1, 'Waiting');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(50) COLLATE latin1_spanish_ci NOT NULL,
  `first_name` varchar(50) COLLATE latin1_spanish_ci DEFAULT NULL,
  `last_name` varchar(50) COLLATE latin1_spanish_ci DEFAULT NULL,
  `password` longblob NOT NULL,
  `email` varchar(100) COLLATE latin1_spanish_ci DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL,
  `removed_at` timestamp NULL DEFAULT NULL,
  `last_login_at` timestamp NULL DEFAULT NULL,
  `role` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;

--
-- Volcado de datos para la tabla `users`
--

INSERT INTO `users` (`id`, `name`, `first_name`, `last_name`, `password`, `email`, `created_at`, `updated_at`, `removed_at`, `last_login_at`, `role`) VALUES
(28, 'Admin', 'mariano', 'burgos', 0x243279243130243549384f69492e6d305642703536515441316368692e4b6a33487a4179454c4c51724442306d676544473949367175766f666a4f47, 'admin@comanda.com', '2020-02-14 23:34:24', '2020-02-27 05:01:28', NULL, '2020-02-28 19:52:03', 1),
(30, 'Manager', 'Ger', 'Mana', 0x243279243130242f6d58784d423146586f795059544d7048376269452e4d48595638727a4e53396b38463944474943526430706e49663769475a6a75, 'ger.mana@comanda.com', '2020-02-17 05:29:36', '2020-02-28 17:57:38', NULL, NULL, 2),
(31, 'usertbh', 'user', 'oof', 0x243279243130246f79725a446b5758422e636246756476414b4e63452e2f2e47366978447a58724e73745a54336e544f377654484c4f557a47754c36, 'user@comanda.com', '2020-02-26 00:36:04', '2020-02-28 17:58:25', NULL, NULL, 6),
(32, 'some.user', 'pancho', 'lopez', 0x2432792431302476645164363938394873506b5275504d684f317077656650562f766856424b595179734430497742586a4b394d7856685539412f4f, 'pancho.lopez@comanda.com', '2020-02-26 00:40:22', '2020-02-28 18:33:29', NULL, NULL, 4),
(33, 'the-cook', 'cook', 'cook', 0x243279243130246b526763787336645a4638674b4976657871445133754c4c6e597754474975374a4e2f416e414853656d59726f76675234754c7971, 'cook@comanda.com', '2020-02-28 18:33:21', NULL, NULL, '2020-02-28 19:43:52', 5);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `logs`
--
ALTER TABLE `logs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_log_user_idx` (`user`);

--
-- Indices de la tabla `menu`
--
ALTER TABLE `menu`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_menu_role_idx` (`role`);

--
-- Indices de la tabla `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`code`),
  ADD KEY `fk_order_user_idx` (`user`),
  ADD KEY `fk_order_table` (`table`),
  ADD KEY `fk_order_state_idx` (`state`);

--
-- Indices de la tabla `order_details`
--
ALTER TABLE `order_details`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_detail_order` (`order`),
  ADD KEY `fk_detail_menu` (`menu`),
  ADD KEY `fk_detail_user_idx` (`user`);

--
-- Indices de la tabla `order_states`
--
ALTER TABLE `order_states`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name_UNIQUE` (`name`);

--
-- Indices de la tabla `reviews`
--
ALTER TABLE `reviews`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order` (`order`);

--
-- Indices de la tabla `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`);

--
-- Indices de la tabla `tables`
--
ALTER TABLE `tables`
  ADD PRIMARY KEY (`code`),
  ADD KEY `fk_table_state_idx` (`state`);

--
-- Indices de la tabla `table_states`
--
ALTER TABLE `table_states`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name_UNIQUE` (`name`);

--
-- Indices de la tabla `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`),
  ADD KEY `fk_role_id_idx` (`role`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `logs`
--
ALTER TABLE `logs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `menu`
--
ALTER TABLE `menu`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `order_details`
--
ALTER TABLE `order_details`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT de la tabla `order_states`
--
ALTER TABLE `order_states`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de la tabla `reviews`
--
ALTER TABLE `reviews`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `roles`
--
ALTER TABLE `roles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `logs`
--
ALTER TABLE `logs`
  ADD CONSTRAINT `fk_log_user` FOREIGN KEY (`user`) REFERENCES `users` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `menu`
--
ALTER TABLE `menu`
  ADD CONSTRAINT `fk_menu_role` FOREIGN KEY (`role`) REFERENCES `roles` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `fk_order_state` FOREIGN KEY (`state`) REFERENCES `order_states` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_order_table` FOREIGN KEY (`table`) REFERENCES `tables` (`code`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_order_user` FOREIGN KEY (`user`) REFERENCES `users` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `order_details`
--
ALTER TABLE `order_details`
  ADD CONSTRAINT `fk_detail_menu` FOREIGN KEY (`menu`) REFERENCES `menu` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_detail_order` FOREIGN KEY (`order`) REFERENCES `orders` (`code`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_detail_user` FOREIGN KEY (`user`) REFERENCES `users` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `reviews`
--
ALTER TABLE `reviews`
  ADD CONSTRAINT `reviews_ibfk_1` FOREIGN KEY (`order`) REFERENCES `orders` (`code`);

--
-- Filtros para la tabla `tables`
--
ALTER TABLE `tables`
  ADD CONSTRAINT `fk_table_state` FOREIGN KEY (`state`) REFERENCES `table_states` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `fk_role_id` FOREIGN KEY (`role`) REFERENCES `roles` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
