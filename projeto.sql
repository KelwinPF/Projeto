-- phpMyAdmin SQL Dump
-- version 4.8.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: 14-Fev-2019 às 21:11
-- Versão do servidor: 10.1.37-MariaDB
-- versão do PHP: 7.3.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `projeto`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `colaborador`
--

CREATE TABLE `colaborador` (
  `id_colaborador` int(11) NOT NULL,
  `nome` varchar(50) NOT NULL,
  `email` varchar(30) NOT NULL,
  `CPF` varchar(14) NOT NULL,
  `sexo` enum('Masculino','Feminino') NOT NULL,
  `data` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `ativo` tinyint(1) NOT NULL,
  `id_empresa` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `colaborador`
--

INSERT INTO `colaborador` (`id_colaborador`, `nome`, `email`, `CPF`, `sexo`, `data`, `ativo`, `id_empresa`) VALUES
(26, 'Bla Souzaa', 'souza@hotmail.com', '098.711.544-22', 'Masculino', '2019-02-14 17:13:22', 1, 23),
(27, 'Femia Female', 'femia@hotmail.com', '098.711.533-56', 'Feminino', '2019-02-14 17:14:07', 1, 23),
(28, 'Teste Nome', 'kelwinteste@hotmail.com', '098.711.544-88', 'Masculino', '2019-02-14 17:14:48', 1, 24),
(29, 'eqweqwdsaasd', 'qweqwe@teste.com', '098.711.544-77', 'Feminino', '2019-02-14 17:56:00', 1, 25),
(30, 'Mairon Passos', 'mairon@email.com', '098.711.522-88', 'Masculino', '2019-02-14 17:56:29', 1, 24);

-- --------------------------------------------------------

--
-- Estrutura da tabela `empresa`
--

CREATE TABLE `empresa` (
  `id_empresa` int(11) NOT NULL,
  `nome` varchar(50) NOT NULL,
  `cnpj` varchar(18) NOT NULL,
  `email` varchar(30) NOT NULL,
  `data` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `ativo` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `empresa`
--

INSERT INTO `empresa` (`id_empresa`, `nome`, `cnpj`, `email`, `data`, `ativo`) VALUES
(23, 'Nordestao', '15.409.786/0001-72', 'Nordestao@email.com', '2019-02-14 16:48:55', 1),
(24, 'Riot games', '15.409.786/0001-71', 'riot@batata.com', '2019-02-14 16:52:42', 1),
(25, 'Carrefour', '45.543.915/0001-81', 'carrefour@chev.com', '2019-02-14 16:55:09', 1),
(26, 'Wal Mart', '00.063.960/0001-09', 'walmart@wmart.com', '2019-02-14 16:55:51', 1),
(27, 'Mondial', '11.111.111/1111-11', 'mondial@hotmail.com', '2019-02-14 17:11:39', 1);

-- --------------------------------------------------------

--
-- Estrutura da tabela `user`
--

CREATE TABLE `user` (
  `id_user` int(11) NOT NULL,
  `user_nome` varchar(11) NOT NULL,
  `senha` varchar(255) NOT NULL,
  `email` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `user`
--

INSERT INTO `user` (`id_user`, `user_nome`, `senha`, `email`) VALUES
(6, 'testando77', '$2y$10$N/aYHNCJCxBxSubYRZk7A.k2NisKL3y2I5IS026b20bl7mmv5PjrG', 'kelwin@hotmail.com');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `colaborador`
--
ALTER TABLE `colaborador`
  ADD PRIMARY KEY (`id_colaborador`),
  ADD KEY `id_empresa` (`id_empresa`);

--
-- Indexes for table `empresa`
--
ALTER TABLE `empresa`
  ADD PRIMARY KEY (`id_empresa`),
  ADD UNIQUE KEY `nome` (`nome`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id_user`),
  ADD UNIQUE KEY `usuario` (`user_nome`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `colaborador`
--
ALTER TABLE `colaborador`
  MODIFY `id_colaborador` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT for table `empresa`
--
ALTER TABLE `empresa`
  MODIFY `id_empresa` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id_user` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Constraints for dumped tables
--

--
-- Limitadores para a tabela `colaborador`
--
ALTER TABLE `colaborador`
  ADD CONSTRAINT `colaborador_ibfk_1` FOREIGN KEY (`id_empresa`) REFERENCES `empresa` (`id_empresa`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
