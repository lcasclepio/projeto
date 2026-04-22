-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 09/02/2026 às 12:40
-- Versão do servidor: 10.4.32-MariaDB
-- Versão do PHP: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `banco`
--

-- --------------------------------------------------------

--
-- Estrutura para tabela `alunos`
--

CREATE TABLE `alunos` (
  `id` int(11) NOT NULL,
  `nome` varchar(255) DEFAULT NULL,
  `cpf` varchar(14) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `senha` varchar(255) DEFAULT NULL,
  `plano` varchar(100) DEFAULT NULL,
  `mensalidade` decimal(10,2) DEFAULT NULL,
  `status` tinyint(1) DEFAULT NULL,
  `observacoes` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `alunos`
--

INSERT INTO `alunos` (`id`, `nome`, `cpf`, `email`, `senha`, `plano`, `mensalidade`, `status`, `observacoes`) VALUES
(1, 'jkenen', '233,333.333', 'joao.filho@gmail.com', '$2y$10$avCi/T41i1nCWUJtJyB1Fet6AqaLCMbSbYREVHM.qqndV9vrLvgfi', 'gold', 200.00, 1, 'cmkckmkcme'),
(11, 'pedro', '11111111127', 'pedro.filho@gmail.com', '$2y$10$YpALsdnR2nj.PQEynTjEQO/t7uJWZg/2KYNl2BkkXWS7F9oD7TYme', 'basico', 123.00, 1, 'ddnnd'),
(14, 'jhon', '12312312355', 'j.silva@gmail.com', '$2y$10$xQ4FziCOI74BOUSEwtJdC.xl4dmIgb9G9wrGzYDP8DY5VNUTxJNFa', 'simples', 123.00, 1, 'nn');

-- --------------------------------------------------------

--
-- Estrutura para tabela `exercicios`
--

CREATE TABLE `exercicios` (
  `id` int(11) NOT NULL,
  `nome` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `exercicios`
--

INSERT INTO `exercicios` (`id`, `nome`) VALUES
(1, 'Supino reto'),
(2, 'Supino inclinado'),
(3, 'Crucifixo'),
(4, 'Flexão de braço'),
(5, 'Puxada frontal'),
(6, 'Remada curvada'),
(7, 'Remada baixa'),
(8, 'Barra fixa'),
(9, 'Desenvolvimento com halteres'),
(10, 'Elevação lateral'),
(11, 'Elevação frontal'),
(12, 'Rosca direta'),
(13, 'Rosca alternada'),
(14, 'Rosca martelo'),
(15, 'Tríceps pulley'),
(16, 'Tríceps testa'),
(17, 'Tríceps banco'),
(18, 'Agachamento livre'),
(19, 'Leg press'),
(20, 'Cadeira extensora'),
(21, 'Cadeira flexora'),
(22, 'Panturrilha em pé'),
(23, 'Panturrilha sentado'),
(24, 'Abdominal reto'),
(25, 'Abdominal infra'),
(26, 'Prancha'),
(27, 'Stiff'),
(28, 'Levantamento terra'),
(29, 'Afundo'),
(30, 'Passada');

-- --------------------------------------------------------

--
-- Estrutura para tabela `funcionarios`
--

CREATE TABLE `funcionarios` (
  `id` int(11) NOT NULL,
  `nome` varchar(60) DEFAULT NULL,
  `sobrenome` varchar(60) DEFAULT NULL,
  `cpf` varchar(14) NOT NULL,
  `email` varchar(100) DEFAULT NULL,
  `senha` varchar(255) DEFAULT NULL,
  `cargo` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `funcionarios`
--

INSERT INTO `funcionarios` (`id`, `nome`, `sobrenome`, `cpf`, `email`, `senha`, `cargo`) VALUES
(2, 'João', 'filho ', '288282', 'joao.filho@gmail.com', '$2y$10$d3hxRsMk0MftNF26YD7lduu1F8.qqUPhrevOjHRiyHqn2Fz24b9Om', 'prof'),
(9, 'Lucas ', 'Cavalcante ', '11111111122', 'lucas.ribeiro@gmail.com', '$2y$10$CE5nXgY9YsJ2UnVU/LwaEeb6N8hx/1ZKwZCbKUs8TmGuz.XDtbSoa', 'Scrum master ');

-- --------------------------------------------------------

--
-- Estrutura para tabela `treinos`
--

CREATE TABLE `treinos` (
  `id` int(11) NOT NULL,
  `aluno_id` int(11) NOT NULL,
  `funcionario_id` int(11) NOT NULL,
  `observacao_geral` text DEFAULT NULL,
  `data_treino` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `treinos`
--

INSERT INTO `treinos` (`id`, `aluno_id`, `funcionario_id`, `observacao_geral`, `data_treino`) VALUES
(1, 1, 2, 'ndjncncw', '2026-01-31'),
(4, 1, 2, 'mc,.s', '2026-01-31'),
(5, 1, 2, '', '2026-02-02'),
(6, 1, 2, '', '2026-02-02'),
(10, 1, 2, '', '2026-02-07'),
(12, 14, 2, '', '2026-02-07');

-- --------------------------------------------------------

--
-- Estrutura para tabela `treino_exercicios`
--

CREATE TABLE `treino_exercicios` (
  `id` int(11) NOT NULL,
  `treino_id` int(11) NOT NULL,
  `exercicio_id` int(11) NOT NULL,
  `comentario` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `treino_exercicios`
--

INSERT INTO `treino_exercicios` (`id`, `treino_id`, `exercicio_id`, `comentario`) VALUES
(1, 1, 25, ''),
(2, 1, 28, ''),
(10, 4, 25, 'dmxmc'),
(11, 4, 21, ''),
(12, 4, 26, ''),
(13, 5, 25, ''),
(14, 5, 24, ''),
(15, 6, 27, ''),
(16, 6, 17, ''),
(24, 10, 24, ''),
(25, 10, 29, ''),
(26, 10, 11, 'tres series '),
(27, 10, 19, '3 series de 2 '),
(32, 12, 25, ''),
(33, 12, 24, ''),
(34, 12, 29, '');

--
-- Índices para tabelas despejadas
--

--
-- Índices de tabela `alunos`
--
ALTER TABLE `alunos`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `exercicios`
--
ALTER TABLE `exercicios`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `funcionarios`
--
ALTER TABLE `funcionarios`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Índices de tabela `treinos`
--
ALTER TABLE `treinos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `treinos_ibfk_1` (`aluno_id`),
  ADD KEY `treinos_ibfk_2` (`funcionario_id`);

--
-- Índices de tabela `treino_exercicios`
--
ALTER TABLE `treino_exercicios`
  ADD PRIMARY KEY (`id`),
  ADD KEY `treino_exercicios_ibfk_1` (`treino_id`),
  ADD KEY `treino_exercicios_ibfk_2` (`exercicio_id`);

--
-- AUTO_INCREMENT para tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `alunos`
--
ALTER TABLE `alunos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT de tabela `exercicios`
--
ALTER TABLE `exercicios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT de tabela `funcionarios`
--
ALTER TABLE `funcionarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT de tabela `treinos`
--
ALTER TABLE `treinos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT de tabela `treino_exercicios`
--
ALTER TABLE `treino_exercicios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- Restrições para tabelas despejadas
--

--
-- Restrições para tabelas `treinos`
--
ALTER TABLE `treinos`
  ADD CONSTRAINT `treinos_ibfk_1` FOREIGN KEY (`aluno_id`) REFERENCES `alunos` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `treinos_ibfk_2` FOREIGN KEY (`funcionario_id`) REFERENCES `funcionarios` (`id`) ON DELETE CASCADE;

--
-- Restrições para tabelas `treino_exercicios`
--
ALTER TABLE `treino_exercicios`
  ADD CONSTRAINT `treino_exercicios_ibfk_1` FOREIGN KEY (`treino_id`) REFERENCES `treinos` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `treino_exercicios_ibfk_2` FOREIGN KEY (`exercicio_id`) REFERENCES `exercicios` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
