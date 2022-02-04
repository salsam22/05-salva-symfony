-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost
-- Temps de generació: 04-02-2022 a les 12:14:57
-- Versió del servidor: 10.4.21-MariaDB
-- Versió de PHP: 7.4.23

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de dades: `05-salva-symfony`
--

-- --------------------------------------------------------

--
-- Estructura de la taula `category`
--

CREATE TABLE `category` (
  `id` int(11) NOT NULL,
  `name` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Bolcament de dades per a la taula `category`
--

INSERT INTO `category` (`id`, `name`) VALUES
(1, 'Black'),
(2, 'White'),
(3, 'Red'),
(4, 'Blue');

-- --------------------------------------------------------

--
-- Estructura de la taula `doctrine_migration_versions`
--

CREATE TABLE `doctrine_migration_versions` (
  `version` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `executed_at` datetime DEFAULT NULL,
  `execution_time` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Bolcament de dades per a la taula `doctrine_migration_versions`
--

INSERT INTO `doctrine_migration_versions` (`version`, `executed_at`, `execution_time`) VALUES
('DoctrineMigrations\\Version20220128111456', '2022-02-04 12:09:56', 239),
('DoctrineMigrations\\Version20220131104400', '2022-02-04 12:09:57', 541),
('DoctrineMigrations\\Version20220131105516', '2022-02-04 12:09:57', 1623),
('DoctrineMigrations\\Version20220202093807', '2022-02-04 12:09:59', 1515),
('DoctrineMigrations\\Version20220202094155', '2022-02-04 12:10:00', 1028);

-- --------------------------------------------------------

--
-- Estructura de la taula `rol`
--

CREATE TABLE `rol` (
  `id` int(11) NOT NULL,
  `name` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Bolcament de dades per a la taula `rol`
--

INSERT INTO `rol` (`id`, `name`) VALUES
(1, 'ADMIN'),
(2, 'USER_CREATOR'),
(3, 'USER');

-- --------------------------------------------------------

--
-- Estructura de la taula `shirt`
--

CREATE TABLE `shirt` (
  `id` int(11) NOT NULL,
  `title` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `image` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `upload_date` date NOT NULL,
  `category_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Bolcament de dades per a la taula `shirt`
--

INSERT INTO `shirt` (`id`, `title`, `description`, `image`, `upload_date`, `category_id`, `user_id`) VALUES
(1, 'Black is the Future', 'Camiseta Black is the Future', 'camiseta-black-is-the-future-unisex.jpg', '2022-01-25', 1, 1),
(2, 'Juego del calamar', 'Camiseta del Juego del Calamar.', 'juego-del-calamar.jpg', '2022-01-31', 1, 1),
(3, 'Dragon Oriental', 'Camiseta con un dragon oriental.', 'dragon-oriental-unisex.jpg', '2022-01-28', 1, 1),
(6, 'gkaghfg', 'afafagasfasfas', 'juego-del-calamar.jpg', '2022-04-05', 4, 1);

-- --------------------------------------------------------

--
-- Estructura de la taula `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `avatar` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `rol_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Bolcament de dades per a la taula `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `avatar`, `rol_id`) VALUES
(1, 'admin', '1234', NULL, 1),
(2, 'user', '1234', NULL, 3);

--
-- Índexs per a les taules bolcades
--

--
-- Índexs per a la taula `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`id`);

--
-- Índexs per a la taula `doctrine_migration_versions`
--
ALTER TABLE `doctrine_migration_versions`
  ADD PRIMARY KEY (`version`);

--
-- Índexs per a la taula `rol`
--
ALTER TABLE `rol`
  ADD PRIMARY KEY (`id`);

--
-- Índexs per a la taula `shirt`
--
ALTER TABLE `shirt`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_8BA5EC1012469DE2` (`category_id`),
  ADD KEY `IDX_8BA5EC10A76ED395` (`user_id`);

--
-- Índexs per a la taula `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_1483A5E94BAB96C` (`rol_id`);

--
-- AUTO_INCREMENT per les taules bolcades
--

--
-- AUTO_INCREMENT per la taula `category`
--
ALTER TABLE `category`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT per la taula `rol`
--
ALTER TABLE `rol`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT per la taula `shirt`
--
ALTER TABLE `shirt`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT per la taula `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Restriccions per a les taules bolcades
--

--
-- Restriccions per a la taula `shirt`
--
ALTER TABLE `shirt`
  ADD CONSTRAINT `FK_8BA5EC1012469DE2` FOREIGN KEY (`category_id`) REFERENCES `category` (`id`),
  ADD CONSTRAINT `FK_8BA5EC10A76ED395` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Restriccions per a la taula `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `FK_1483A5E94BAB96C` FOREIGN KEY (`rol_id`) REFERENCES `rol` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
