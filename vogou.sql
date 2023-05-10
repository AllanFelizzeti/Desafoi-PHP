-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 11/05/2023 às 01:18
-- Versão do servidor: 10.4.28-MariaDB
-- Versão do PHP: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `vogou`
--

-- --------------------------------------------------------

--
-- Estrutura para tabela `curriculos`
--

CREATE TABLE `curriculos` (
  `id` int(11) NOT NULL,
  `nome` varchar(220) NOT NULL,
  `celular` varchar(100) NOT NULL,
  `cpf` varchar(50) NOT NULL,
  `email` varchar(220) NOT NULL,
  `brapa` varchar(50) NOT NULL,
  `pretencao_salario` varchar(20) DEFAULT NULL,
  `sexo` varchar(11) DEFAULT NULL,
  `data_nascimento` date NOT NULL,
  `estado_civil` varchar(20) NOT NULL,
  `escolaridade` varchar(50) NOT NULL,
  `empresa` varchar(50) NOT NULL,
  `cargo` varchar(50) NOT NULL,
  `curso` varchar(200) NOT NULL,
  `periodo_entrada` date NOT NULL,
  `periodo_saida` date NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Despejando dados para a tabela `curriculos`
--

INSERT INTO `curriculos` (`id`, `nome`, `celular`, `cpf`, `email`, `brapa`, `pretencao_salario`, `sexo`, `data_nascimento`, `estado_civil`, `escolaridade`, `empresa`, `cargo`, `curso`, `periodo_entrada`, `periodo_saida`, `created`, `modified`) VALUES
(12, 'ALLAN VERGILIO ', '(47)92455-430', '026.312.009-00', 'alllanvergilio@gmail.com', 'Dc395183#', '2500', 'Masculino', '1991-06-01', 'PR', 'Ensino Fundamental', 'Ksys Sistemas ', 'Programador Jr', '', '2022-04-04', '2023-05-09', '2023-05-09 19:46:56', NULL),
(13, 'Sirlene Rodrigues Felizzeti', '(47)92455-430', '123.456.789-00', 'sirlene@gmail.com', '123Dc#', '', 'Feminino', '1983-08-08', 'SC', 'Ensino Fundamental', 'Eletro Aço Altona', 'Programador Jr', '', '2021-06-09', '2023-05-10', '2023-05-10 20:11:48', NULL);

--
-- Índices para tabelas despejadas
--

--
-- Índices de tabela `curriculos`
--
ALTER TABLE `curriculos`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT para tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `curriculos`
--
ALTER TABLE `curriculos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
