-- phpMyAdmin SQL Dump
-- version 4.9.7
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Nov 22, 2021 at 09:13 AM
-- Server version: 5.7.23-23
-- PHP Version: 7.3.32

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `wallac58_lendsys`
--

-- --------------------------------------------------------

--
-- Table structure for table `address`
--

CREATE TABLE `address` (
  `id` int(11) NOT NULL,
  `street` varchar(100) DEFAULT NULL,
  `number` varchar(45) DEFAULT NULL,
  `complement` varchar(45) DEFAULT NULL,
  `neighborhood` varchar(45) DEFAULT NULL,
  `city` varchar(45) DEFAULT NULL,
  `state` varchar(20) DEFAULT NULL,
  `country` varchar(45) DEFAULT NULL,
  `postalcode` varchar(11) DEFAULT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `address`
--

INSERT INTO `address` (`id`, `street`, `number`, `complement`, `neighborhood`, `city`, `state`, `country`, `postalcode`, `user_id`) VALUES
(32, 'Rua Dois', '25', 'Casa', 'Centro', 'Curitiba', 'PR', 'Brasil', '83893079', 33),
(33, 'Sete de Setembro', '1356', 'Ap 706', 'Batel', 'Curitiba', 'PR', 'Brasil', '87365098', 33),
(34, 'Independência', '7', 'Fundos', 'Maracanã', 'Colombo', 'PR', 'Brasil', '85435876', 34),
(35, 'Avenida Paulista', '747', 'AP 503', 'Paulista', 'São Paulo', 'SP', 'Brasil', '36631620', 35),
(36, 'Presidente JK', '73', 'AP 401', 'Cabo Branco', 'João Pessoa', 'PB', 'Brasil', '77393837', 36),
(37, 'Rua Itália', '46 B', 'AP 1026', 'Jardim Social', 'Rio de Janeiro', 'RJ', 'Brasil', '84346252', 37),
(38, 'Rua Laranjeira', '20', 'AP 707', 'Centro', 'Curitiba', 'PR', 'Brasil', '80747939', 20),
(40, 'Rua Sete de Setembro', '1739', 'Ap 707', 'Centro', 'Curitiba', 'PR', 'Brasil', '98838383', 39);

-- --------------------------------------------------------

--
-- Table structure for table `item`
--

CREATE TABLE `item` (
  `id` int(11) NOT NULL,
  `name` varchar(45) NOT NULL,
  `description` varchar(60) DEFAULT NULL,
  `category` varchar(45) DEFAULT NULL,
  `quantity` int(11) DEFAULT NULL,
  `totalborrowed` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `item`
--

INSERT INTO `item` (`id`, `name`, `description`, `category`, `quantity`, `totalborrowed`) VALUES
(40, 'Torto arado', 'Escritor: Itamar Vieira Junior', 'Livros', 15, 13),
(41, 'Amor &amp; Gelato', 'Escritora: Jenna Evans Welch', 'Livros', 50, 2),
(42, 'Vamos comprar um poeta', 'Escritor: Afonso Cruz', 'Livros', 30, 13),
(43, 'Sapiens: Uma breve história da Humanidade', 'Escritor: Yuval Noah Harari', 'Livros', 50, 15),
(44, 'O diário de Anne Frank', 'Escritora: Anne Frank', 'Livros', 10, 4),
(45, 'Caneta Preta', 'Marca: Bic', 'Papelaria', 25, 8);

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `email` varchar(254) NOT NULL,
  `password` char(64) NOT NULL,
  `name` varchar(50) NOT NULL,
  `surname` varchar(50) NOT NULL,
  `phone` varchar(15) DEFAULT NULL,
  `role` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `email`, `password`, `name`, `surname`, `phone`, `role`) VALUES
(20, 'admin@gmail.com', '$2y$10$IpHHM8YdX9rWcPISUl0nfOo4LXidG4U9aJwy7RVWSqeJ/8M/TisA2', 'Wallace', 'Bottacin', '414352352346', 1),
(21, 'admin2@gmail.com', '$2y$10$J9m5M1JUyveLeumBc7RUa.PcO42LFheNEA/y7WfsMxjsP5Yv2zHDq', 'Wallace', 'Bottacin', '5838357953', 1),
(33, 'usuario1@gmail.com', '$2y$10$5FoObNo91r7awD314.vOR.nBQ7/5sySycbbQJXHAwcUgy9xzIJ2Ve', 'Amanda', 'Azaleia', '4199876474', 2),
(34, 'usuario2@gmail.com', '$2y$10$qZ4ZIjfjGhzHlhoBIWlc1utXO5dHBuNhW1fqV4J9IMzL5Vz4oveJu', 'Bernardo', 'Antúrio', '4198764537', 2),
(35, 'usuario3@gmail.com', '$2y$10$3qca.VZgt8mTE2IS9/wdnOZH.faxp84Pwb0Hvaoh87fa9Vn57iY/a', 'Carla', 'Begônia', '11948547837', 2),
(36, 'usuario4@gmail.com', '$2y$10$R7D6H4oXOd.83bTQ/1UROuK5UlS13CExOEur0d3lDvfAIVcQxqCh2', 'Denise', 'Calêndula', '8372783782', 2),
(37, 'usuario5@gmail.com', '$2y$10$LuQWOZNBC2q9wjyjH3B0uuwKihNYJpNz9ny6lDX5PePs36WBx5rG6', 'Ewerton', 'Lisianto', '74934792737', 2),
(38, 'usuario6@gmail.com', '$2y$10$qHjEPA7edB3oeYnQYLQaUuGek2MxaECf4GC7kdG6F4UK0gvZ/zdSO', 'João', 'Rosa', '82357239', 2),
(39, 'usuario7@gmail.com', '$2y$10$x8uphL7/jPdqTXJz0eyQPe5SPJP32XNgQIC.JmLE.wg97iZbcPqsS', 'João', 'Flores Silva', '7463847494', 2),
(40, 'teste@gmail.com', '$2y$10$8ObSPac0mKY3aL1oFM5Vnebd/JMWU8ERDcQeMDHHLH.smCV5WEgzS', 'teste', 'teste', '324234234', 2);

-- --------------------------------------------------------

--
-- Table structure for table `user_has_item`
--

CREATE TABLE `user_has_item` (
  `user_id` int(11) NOT NULL,
  `item_id` int(11) NOT NULL,
  `lenddate` datetime NOT NULL,
  `returndate` datetime DEFAULT NULL,
  `quantityborrowed` int(11) DEFAULT NULL,
  `lendupto` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `user_has_item`
--

INSERT INTO `user_has_item` (`user_id`, `item_id`, `lenddate`, `returndate`, `quantityborrowed`, `lendupto`) VALUES
(33, 40, '2021-10-14 13:59:31', NULL, 10, '2021-10-19 13:59:31'),
(33, 45, '2021-10-14 13:59:41', '2021-10-14 13:59:49', 8, '2021-10-19 13:59:41'),
(34, 42, '2021-10-14 12:51:44', NULL, 10, '2021-10-19 12:51:44'),
(35, 41, '2021-10-14 13:21:44', NULL, 1, '2021-10-19 13:21:44'),
(35, 44, '2021-10-14 13:23:24', NULL, 4, '2021-10-19 13:23:24'),
(36, 41, '2021-10-14 14:08:19', '2021-10-14 14:08:46', 1, '2021-10-19 14:08:19'),
(36, 42, '2021-10-14 13:22:27', NULL, 3, '2021-10-19 13:22:27'),
(37, 40, '2021-10-14 14:09:40', NULL, 3, '2020-10-15 14:09:40'),
(37, 43, '2021-10-14 13:22:39', '2021-10-14 14:11:35', 15, '2021-10-19 13:22:39');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `address`
--
ALTER TABLE `address`
  ADD PRIMARY KEY (`id`,`user_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `item`
--
ALTER TABLE `item`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `user_has_item`
--
ALTER TABLE `user_has_item`
  ADD PRIMARY KEY (`user_id`,`item_id`),
  ADD KEY `item_id` (`item_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `address`
--
ALTER TABLE `address`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- AUTO_INCREMENT for table `item`
--
ALTER TABLE `item`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=46;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `address`
--
ALTER TABLE `address`
  ADD CONSTRAINT `address_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`);

--
-- Constraints for table `user_has_item`
--
ALTER TABLE `user_has_item`
  ADD CONSTRAINT `user_has_item_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`),
  ADD CONSTRAINT `user_has_item_ibfk_2` FOREIGN KEY (`item_id`) REFERENCES `item` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
