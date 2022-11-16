-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 16-11-2022 a las 18:55:43
-- Versión del servidor: 10.4.24-MariaDB
-- Versión de PHP: 7.4.29

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `library_db`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `books`
--

CREATE TABLE `books` (
  `id` int(255) NOT NULL,
  `user_id` int(255) NOT NULL,
  `title` varchar(255) DEFAULT NULL,
  `author` varchar(255) DEFAULT NULL,
  `description` text NOT NULL,
  `no_comments` int(255) DEFAULT 0,
  `image` varchar(255) DEFAULT NULL,
  `status` varchar(50) DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `books`
--

INSERT INTO `books` (`id`, `user_id`, `title`, `author`, `description`, `no_comments`, `image`, `status`, `created_at`, `updated_at`) VALUES
(1, 1, 'FIRST BOOK', 'FIRST AUTHOR', 'FIRST BOOK - AUTHOR', 0, NULL, NULL, '2022-11-12 00:00:41', NULL),
(2, 1, 'SECOND BOOK', 'SECOND AUTHOR', 'SECOND BOOK - AUTHOR', 0, NULL, NULL, '2022-11-12 00:01:41', NULL),
(3, 2, 'THIRD BOOK', 'THIRD AUTHOR', 'THIRD BOOK - AUTHOR', 0, NULL, NULL, '2022-11-13 00:01:41', NULL),
(10, 7, 'apitest3E', 'apitestE', 'apitest3e', 0, '', 'DISPONIBLE', '2022-11-15 23:34:45', '2022-11-16 01:25:04'),
(12, 7, 'test', 'test', 'test', 0, '1668606771PC_SpecsLinux.png', 'DISPONIBLE', '2022-11-16 13:52:54', '2022-11-16 13:52:54');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `comments`
--

CREATE TABLE `comments` (
  `id` int(255) NOT NULL,
  `user_id` int(255) NOT NULL,
  `book_id` int(255) NOT NULL,
  `comment` text NOT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `comments`
--

INSERT INTO `comments` (`id`, `user_id`, `book_id`, `comment`, `created_at`, `updated_at`) VALUES
(1, 2, 1, 'GREAT BOOK', '2022-11-12 21:03:25', NULL),
(2, 2, 2, 'GOOD BOOK', '2022-11-12 21:03:46', NULL),
(3, 1, 1, 'BAD BOOK', '2022-11-12 21:04:27', NULL),
(4, 7, 1, 'apiteste', '2022-11-15 23:26:37', '2022-11-16 01:48:05');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `users`
--

CREATE TABLE `users` (
  `id` int(255) NOT NULL,
  `name` varchar(50) NOT NULL,
  `surname` varchar(100) DEFAULT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` varchar(30) NOT NULL,
  `avatar` varchar(255) DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT NULL,
  `remember_token` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `users`
--

INSERT INTO `users` (`id`, `name`, `surname`, `email`, `password`, `role`, `avatar`, `created_at`, `updated_at`, `remember_token`) VALUES
(1, 'admin', 'admin', 'admin@admin.dev', '5e884898da28047151d0e56f8dc6292773603d0d6aabbdd62a11ef721d1542d8', 'ROLE_ADMIN', NULL, NULL, NULL, NULL),
(2, 'testuser', 'testuser', 'testuser@admin.dev', '5e884898da28047151d0e56f8dc6292773603d0d6aabbdd62a11ef721d1542d8', 'ROLE_USER', NULL, NULL, NULL, NULL),
(7, 'erre', 'dos', 'cg1@cg.cg', '5e884898da28047151d0e56f8dc6292773603d0d6aabbdd62a11ef721d1542d8', 'ROLE_ADMIN', '1668597054o2AaF6EI_400x400.jpg', '2022-11-14 06:31:48', '2022-11-16 11:11:08', NULL),
(8, 'carlos a', 'gutierrez c', 'cg@cg.cg', '5e884898da28047151d0e56f8dc6292773603d0d6aabbdd62a11ef721d1542d8', 'ROLE_USER', 'avatar', '2022-11-16 04:03:54', '2022-11-16 17:40:18', NULL),
(10, 'hola', 'mundo', 'as@as.as', '5e884898da28047151d0e56f8dc6292773603d0d6aabbdd62a11ef721d1542d8', 'ROLE_USER', '1668597054o2AaF6EI_400x400.jpg', '2022-11-16 08:24:16', '2022-11-16 08:24:16', NULL),
(11, 'carlos', 'gutierrez', 'cg@c1g.cg', '5e884898da28047151d0e56f8dc6292773603d0d6aabbdd62a11ef721d1542d8', 'ROLE_USER', NULL, '2022-11-16 12:31:04', '2022-11-16 12:31:04', NULL);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `books`
--
ALTER TABLE `books`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FK_BOOK_USER` (`user_id`);

--
-- Indices de la tabla `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FK_COMMENT_USER` (`user_id`),
  ADD KEY `FK_COMMENT_BOOK` (`book_id`);

--
-- Indices de la tabla `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `books`
--
ALTER TABLE `books`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT de la tabla `comments`
--
ALTER TABLE `comments`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT de la tabla `users`
--
ALTER TABLE `users`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `books`
--
ALTER TABLE `books`
  ADD CONSTRAINT `FK_BOOK_USER` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Filtros para la tabla `comments`
--
ALTER TABLE `comments`
  ADD CONSTRAINT `FK_COMMENT_BOOK` FOREIGN KEY (`book_id`) REFERENCES `books` (`id`),
  ADD CONSTRAINT `FK_COMMENT_USER` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
