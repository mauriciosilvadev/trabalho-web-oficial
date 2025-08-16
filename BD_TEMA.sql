-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 13/09/2024 às 17:59
-- Versão do servidor: 10.4.32-MariaDB
-- Versão do PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `servicos_informatica`
--

CREATE DATABASE IF NOT EXISTS `servicos_informatica` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `servicos_informatica`;

-- --------------------------------------------------------

--
-- Estrutura para tabela `datas_disponiveis`
--

CREATE TABLE `datas_disponiveis` (
  `id` int(11) NOT NULL,
  `id_servico` int(11) DEFAULT NULL,
  `id_venda` int(11) DEFAULT NULL,
  `data` date NOT NULL,
  `disponivel` tinyint(1) NOT NULL DEFAULT 1,
  `prestado` tinyint(4) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `datas_disponiveis`
--

INSERT INTO `datas_disponiveis` (`id`, `id_servico`, `id_venda`, `data`, `disponivel`, `prestado`) VALUES
(45, 8, NULL, '2025-10-02', 1, 0),
(46, 8, NULL, '2025-10-03', 1, 0),
(47, 8, NULL, '2025-10-04', 1, 0),
(48, 8, NULL, '2025-10-05', 1, 0),
(49, 8, NULL, '2025-10-06', 1, 0),
(56, 7, NULL, '2025-11-25', 1, 0),
(57, 7, NULL, '2025-11-26', 1, 0),
(58, 7, NULL, '2025-11-27', 1, 0),
(59, 7, NULL, '2025-11-28', 1, 0),
(60, 7, NULL, '2025-11-29', 1, 0),
(61, 7, NULL, '2025-12-02', 1, 0),
(62, 9, NULL, '2025-12-09', 1, 0),
(63, 9, NULL, '2025-12-10', 1, 0),
(64, 9, NULL, '2025-12-11', 1, 0),
(65, 9, NULL, '2025-12-12', 1, 0),
(66, 9, NULL, '2025-12-13', 1, 0),
(67, 10, NULL, '2025-12-16', 1, 0),
(68, 10, NULL, '2025-12-17', 1, 0),
(69, 11, NULL, '2025-12-20', 1, 0),
(70, 12, NULL, '2025-12-23', 1, 0),
(71, 12, NULL, '2025-12-24', 1, 0);

-- --------------------------------------------------------

--
-- Estrutura para tabela `servicos`
--

CREATE TABLE `servicos` (
  `id` int(11) NOT NULL,
  `id_prestador` int(11) NOT NULL,
  `nome` varchar(50) NOT NULL,
  `valor` float NOT NULL,
  `descricao` varchar(50) NOT NULL,
  `cidade` varchar(50) NOT NULL,
  `id_tipo` int(11) NOT NULL,
  `esta_deletado` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `servicos`
--

INSERT INTO `servicos` (`id`, `id_prestador`, `nome`, `valor`, `descricao`, `cidade`, `id_tipo`, `esta_deletado`) VALUES
(7, 5, 'Desenvolvimento de Website', 800, 'Sites responsivos com HTML, CSS e JavaScript', 'Vitória', 2, 0),
(8, 5, 'Manutenção de Computadores', 180, 'Formatação, limpeza e instalação de software', 'Vitória', 3, 0),
(9, 6, 'Design de Logotipos', 350, 'Criação de identidade visual para empresas', 'Vitória', 4, 0),
(10, 8, 'Configuração de Redes', 450, 'Instalação e configuração de redes Wi-Fi', 'Vitória', 5, 0),
(11, 8, 'Consultoria em Sistemas', 600, 'Análise e otimização de processos digitais', 'Vitória', 6, 0),
(12, 6, 'Backup e Segurança', 280, 'Implementação de sistemas de backup', 'Vitória', 7, 0),
(13, 5, 'Desenvolvimento de App Mobile', 1200, 'Aplicativos para Android e iOS', 'Vitória', 2, 0),
(14, 7, 'Instalação de Software', 120, 'Instalação e configuração de programas', 'Vitória', 3, 0),
(15, 6, 'Design de Banners', 200, 'Criação de materiais publicitários', 'Vitória', 4, 0),
(16, 8, 'Monitoramento de Rede', 380, 'Supervisão e análise de tráfego', 'Vitória', 5, 0),
(17, 5, 'Auditoria de Sistemas', 750, 'Análise completa de infraestrutura TI', 'Vitória', 6, 0),
(18, 7, 'Antivírus Corporativo', 320, 'Proteção avançada contra malware', 'Vitória', 7, 0),
(19, 8, 'Automação de Processos', 900, 'Scripts e workflows automatizados', 'Vitória', 8, 0),
(20, 6, 'E-commerce Completo', 1500, 'Loja virtual com pagamento integrado', 'Vitória', 2, 0),
(21, 5, 'Suporte Remoto', 150, 'Assistência técnica à distância', 'Vitória', 3, 0),
(22, 7, 'Identidade Visual', 480, 'Criação de marca completa', 'Vitória', 4, 0),
(23, 8, 'Cabeamento Estruturado', 650, 'Instalação de rede física', 'Vitória', 5, 0),
(24, 6, 'Migração de Dados', 420, 'Transferência segura de informações', 'Vitória', 6, 0),
(25, 5, 'Firewall Empresarial', 580, 'Configuração de proteção de rede', 'Vitória', 7, 0),
(26, 7, 'Sistema de Estoque', 1100, 'Controle automatizado de inventário', 'Vitória', 8, 0),
(27, 8, 'Landing Page', 400, 'Página de conversão otimizada', 'Vitória', 2, 0),
(28, 6, 'Recuperação de Dados', 250, 'Restauração de arquivos perdidos', 'Vitória', 3, 0),
(29, 5, 'Design de Cartões', 180, 'Cartões de visita e materiais gráficos', 'Vitória', 4, 0),
(30, 7, 'VPN Corporativa', 520, 'Acesso remoto seguro', 'Vitória', 5, 0),
(31, 8, 'Análise de Performance', 680, 'Otimização de sistemas e aplicações', 'Vitória', 6, 0),
(32, 6, 'Criptografia de Dados', 450, 'Proteção avançada de informações', 'Vitória', 7, 0);

-- --------------------------------------------------------

--
-- Estrutura para tabela `tipos`
--

CREATE TABLE `tipos` (
  `id` int(11) NOT NULL,
  `nome` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `tipos`
--

INSERT INTO `tipos` (`id`, `nome`) VALUES
(2, 'Desenvolvimento Web'),
(3, 'Suporte Técnico'),
(4, 'Design Gráfico'),
(5, 'Redes e Infraestrutura'),
(6, 'Consultoria TI'),
(7, 'Segurança Digital'),
(8, 'Automação');

-- --------------------------------------------------------

--
-- Estrutura para tabela `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL,
  `nome` varchar(50) NOT NULL,
  `endereco` varchar(50) NOT NULL,
  `cidade` varchar(50) NOT NULL,
  `telefone` varchar(20) NOT NULL,
  `cpf_cnpj` varchar(20) DEFAULT NULL,
  `dt_nascimento` date NOT NULL,
  `email` varchar(50) DEFAULT NULL,
  `senha` varchar(8) NOT NULL,
  `tipo` varchar(1) NOT NULL,
  `esta_deletado` tinyint(1) NOT NULL DEFAULT 0,
  `email_deletado` varchar(50) DEFAULT NULL,
  `cpf_cnpj_deletado` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `usuarios`
--

INSERT INTO `usuarios` (`id`, `nome`, `endereco`, `cidade`, `telefone`, `cpf_cnpj`, `dt_nascimento`, `email`, `senha`, `tipo`, `esta_deletado`, `email_deletado`, `cpf_cnpj_deletado`) VALUES
(4, 'Admin', '', 'Vitória', '', '', '2024-09-11', 'admin@email', '1234', 'A', 0, NULL, NULL),
(5, 'Carlos Eduardo Silva', 'Rua das Palmeiras, 150, Jardins', 'Vitória', '27 99887-7654', '123.456.789-01', '1988-03-15', 'carlos.silva@techmail.com', '1234', 'P', 0, NULL, NULL),
(6, 'Ana Paula Santos', 'Avenida Beira Mar, 890', 'Vitória', '27 98765-4321', '987.654.321-09', '1995-07-22', 'ana.santos@designmail.com', '1234', 'C', 0, NULL, NULL),
(7, 'Marina Costa Oliveira', 'Rua do Comércio, 45', 'Vitória', '27 99123-4567', '456.789.123-45', '1992-11-08', 'marina.oliveira@clientemail.com', '1234', 'C', 0, NULL, NULL),
(8, 'Rafael Mendes Pereira', 'Avenida Central, 320', 'Vitória', '27 98456-7890', '789.123.456-78', '1990-01-30', 'rafael.pereira@techsupport.com', '1234', 'P', 0, NULL, NULL);

-- --------------------------------------------------------

--
-- Estrutura para tabela `vendas`
--

CREATE TABLE `vendas` (
  `id` int(11) NOT NULL,
  `id_contratante` int(11) NOT NULL,
  `valor` float NOT NULL,
  `forma_pagamento` varchar(50) NOT NULL,
  `data` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Índices para tabelas despejadas
--

--
-- Índices de tabela `datas_disponiveis`
--
ALTER TABLE `datas_disponiveis`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_servico` (`id_servico`),
  ADD KEY `id_venda` (`id_venda`);

--
-- Índices de tabela `servicos`
--
ALTER TABLE `servicos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_prestador` (`id_prestador`),
  ADD KEY `id_tipo` (`id_tipo`);

--
-- Índices de tabela `tipos`
--
ALTER TABLE `tipos`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `cpf_cnpj` (`cpf_cnpj`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Índices de tabela `vendas`
--
ALTER TABLE `vendas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_contratante` (`id_contratante`);

--
-- AUTO_INCREMENT para tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `datas_disponiveis`
--
ALTER TABLE `datas_disponiveis`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=72;

--
-- AUTO_INCREMENT de tabela `servicos`
--
ALTER TABLE `servicos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT de tabela `tipos`
--
ALTER TABLE `tipos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de tabela `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de tabela `vendas`
--
ALTER TABLE `vendas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- Restrições para tabelas despejadas
--

--
-- Restrições para tabelas `datas_disponiveis`
--
ALTER TABLE `datas_disponiveis`
  ADD CONSTRAINT `datas_disponiveis_ibfk_1` FOREIGN KEY (`id_servico`) REFERENCES `servicos` (`id`),
  ADD CONSTRAINT `datas_disponiveis_ibfk_2` FOREIGN KEY (`id_venda`) REFERENCES `vendas` (`id`);

--
-- Restrições para tabelas `servicos`
--
ALTER TABLE `servicos`
  ADD CONSTRAINT `servicos_ibfk_1` FOREIGN KEY (`id_prestador`) REFERENCES `usuarios` (`id`),
  ADD CONSTRAINT `servicos_ibfk_2` FOREIGN KEY (`id_tipo`) REFERENCES `tipos` (`id`);

--
-- Restrições para tabelas `vendas`
--
ALTER TABLE `vendas`
  ADD CONSTRAINT `vendas_ibfk_1` FOREIGN KEY (`id_contratante`) REFERENCES `usuarios` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
