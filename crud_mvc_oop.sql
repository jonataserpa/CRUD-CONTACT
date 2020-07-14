-- phpMyAdmin SQL Dump
-- version 4.9.5deb2
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Tempo de geração: 14/07/2020 às 01:19
-- Versão do servidor: 8.0.20-0ubuntu0.20.04.1
-- Versão do PHP: 7.4.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `crud_mvc_oop`
--

-- --------------------------------------------------------

--
-- Estrutura para tabela `contacts`
--

CREATE TABLE `contacts` (
  `c_id` int NOT NULL,
  `c_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `c_email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `c_address` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `c_date_create` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `c_fdeletado` int DEFAULT NULL,
  `c_password` varchar(256) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Despejando dados para a tabela `contacts`
--

INSERT INTO `contacts` (`c_id`, `c_name`, `c_email`, `c_address`, `c_date_create`, `c_fdeletado`, `c_password`) VALUES
(1, 'logan serpa', 'jonataserpa@gmail.com', 'RUA VOLVERINE', '2020-07-08 02:14:19', NULL, NULL),
(2, 'nubia oli', 'nubia@gmail.com', 'rua das flores 75', '2020-07-08 02:17:17', NULL, NULL),
(45, 'arthur bertolini', 'arthur@gmail.com', 'rua alvaro costa', '2020-07-10 23:10:20', NULL, '$2b$10$Eysb86Jw5vEK7/UzhslKIOiunco5AclOwLRoQZQxMlZr5UnkQXXTm'),
(46, 'jonata', 'jonataserpa@gmail.com', 'RUA teste', '2020-07-11 14:07:24', NULL, NULL),
(47, 'teste', 'teste@gmail.com', 'teste teste', '2020-07-13 00:51:08', 1, NULL);

-- --------------------------------------------------------

--
-- Estrutura para tabela `phone`
--

CREATE TABLE `phone` (
  `p_id` int NOT NULL,
  `p_tipo` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `p_numero` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `p_date_create` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `p_conctacts_id` int DEFAULT NULL,
  `p_fdeletado` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Despejando dados para a tabela `phone`
--

INSERT INTO `phone` (`p_id`, `p_tipo`, `p_numero`, `p_date_create`, `p_conctacts_id`, `p_fdeletado`) VALUES
(5, 'Personal', '+5535997433853', '2020-07-10 23:10:21', 45, 1),
(6, ' Sales', '(35)9784-5688', '2020-07-10 23:10:21', 45, 1),
(11, 'Personal', '09809809808', '2020-07-11 01:21:29', 2, 1),
(12, ' Sales', '06456456456', '2020-07-11 01:21:29', 2, 1),
(19, 'Personal', '7777777', '2020-07-11 01:28:34', 1, 1),
(54, 'Personal', '7777777', '2020-07-11 02:43:12', 1, 1),
(55, 'Work', '2222222', '2020-07-11 02:43:12', 1, 1),
(56, 'Commercial', '333333', '2020-07-11 02:43:12', 1, 1),
(57, 'Personal', '+5535997433853', '2020-07-11 02:46:15', 45, 1),
(58, ' Sales', '(35)9784-5688', '2020-07-11 02:46:15', 45, 1),
(59, 'Work', '55555555', '2020-07-11 02:46:15', 45, 1),
(60, 'Personal', '09809809808', '2020-07-11 02:50:36', 2, NULL),
(61, ' Sales', '06456456456', '2020-07-11 02:50:36', 2, NULL),
(62, 'Work', '123456789', '2020-07-11 02:50:36', 2, NULL),
(63, 'Personal', '+5535997433853', '2020-07-11 13:36:09', 45, NULL),
(64, 'Personal', '7777777', '2020-07-11 13:47:31', 1, 1),
(65, 'Commercial', '333333', '2020-07-11 13:47:31', 1, 1),
(66, 'Personal', '7777777', '2020-07-11 13:51:32', 1, 1),
(67, 'Commercial', '333333', '2020-07-11 13:51:32', 1, 1),
(68, 'Sales', '8888888', '2020-07-11 13:51:32', 1, 1),
(69, 'Sales', '(35) 4539-5566', '2020-07-11 13:53:47', 1, 1),
(70, 'Sales', '(35) 4539-5566', '2020-07-11 14:07:03', 1, 1),
(71, 'Sales', '(35) 4539-5566', '2020-07-11 15:37:21', 1, NULL),
(72, 'Personal', '(35) 9856-5689', '2020-07-11 19:04:51', 46, NULL);

--
-- Índices de tabelas apagadas
--

--
-- Índices de tabela `contacts`
--
ALTER TABLE `contacts`
  ADD PRIMARY KEY (`c_id`);

--
-- Índices de tabela `phone`
--
ALTER TABLE `phone`
  ADD PRIMARY KEY (`p_id`),
  ADD KEY `phone_fk_contact` (`p_conctacts_id`);

--
-- AUTO_INCREMENT de tabelas apagadas
--

--
-- AUTO_INCREMENT de tabela `contacts`
--
ALTER TABLE `contacts`
  MODIFY `c_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=48;

--
-- AUTO_INCREMENT de tabela `phone`
--
ALTER TABLE `phone`
  MODIFY `p_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=73;

--
-- Restrições para dumps de tabelas
--

--
-- Restrições para tabelas `phone`
--
ALTER TABLE `phone`
  ADD CONSTRAINT `phone_fk_contact` FOREIGN KEY (`p_conctacts_id`) REFERENCES `contacts` (`c_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
