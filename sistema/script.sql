-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: 06-Fev-2018 às 14:46
-- Versão do servidor: 10.1.28-MariaDB
-- PHP Version: 7.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `colecionavel`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `tb_game_item`
--

CREATE TABLE `tb_game_item` (
  `id` int(11) NOT NULL,
  `data_cadastro` datetime DEFAULT NULL,
  `data_update` datetime DEFAULT NULL,
  `titulo` varchar(200) DEFAULT NULL,
  `descricao` text,
  `procedencia` varchar(255) DEFAULT NULL,
  `regiao` varchar(255) DEFAULT NULL,
  `valor_pago` decimal(9,2) DEFAULT NULL,
  `valor_atual` decimal(9,2) DEFAULT NULL,
  `plataforma` varchar(255) DEFAULT NULL,
  `tipo` varchar(255) DEFAULT NULL,
  `codigo` varchar(20) DEFAULT NULL,
  `genero` varchar(255) DEFAULT NULL,
  `produtora` varchar(255) DEFAULT NULL,
  `publicadora` varchar(255) DEFAULT NULL,
  `complemento` int(11) DEFAULT NULL,
  `avaliacao` int(11) DEFAULT NULL,
  `local_primeiro` varchar(200) DEFAULT NULL,
  `local_segundo` varchar(200) DEFAULT NULL,
  `local_terceiro` varchar(200) DEFAULT NULL,
  `flag_cartucho_disco` int(11) DEFAULT NULL,
  `flag_replica` int(11) DEFAULT NULL,
  `flag_protetor` int(11) DEFAULT NULL,
  `flag_cd_dvd` int(11) DEFAULT NULL,
  `flag_caixa` int(11) DEFAULT NULL,
  `flag_manual` int(11) DEFAULT NULL,
  `flag_berco` int(11) DEFAULT NULL,
  `flag_panfleto` int(11) DEFAULT NULL,
  `flag_poster` int(11) DEFAULT NULL,
  `flag_nota_fiscal` int(11) DEFAULT NULL,
  `flag_lacrado` int(11) DEFAULT NULL,
  `flag_luva` int(11) DEFAULT NULL,
  `id_user` int(11) DEFAULT NULL,
  `status` varchar(1) DEFAULT 'C',
  `progressao` int(11) DEFAULT '0',
  `situacao` varchar(50) DEFAULT NULL COMMENT 'comprado, alugado, emprestado...',
  `possui` int(11) DEFAULT NULL COMMENT 'se tem ou não o item',
  `screenshot1` varchar(255) DEFAULT NULL,
  `screenshot2` varchar(255) DEFAULT NULL,
  `screenshot3` varchar(255) DEFAULT NULL,
  `screenshot4` varchar(255) DEFAULT NULL,
  `tempo` int(11) DEFAULT NULL COMMENT 'tempo de jogo',
  `num_jogadas` int(11) NOT NULL,
  `imagem` varchar(255) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `tb_game_item`
--

INSERT INTO `tb_game_item` (`id`, `data_cadastro`, `data_update`, `titulo`, `descricao`, `procedencia`, `regiao`, `valor_pago`, `valor_atual`, `plataforma`, `tipo`, `codigo`, `genero`, `produtora`, `publicadora`, `complemento`, `avaliacao`, `local_primeiro`, `local_segundo`, `local_terceiro`, `flag_cartucho_disco`, `flag_replica`, `flag_protetor`, `flag_cd_dvd`, `flag_caixa`, `flag_manual`, `flag_berco`, `flag_panfleto`, `flag_poster`, `flag_nota_fiscal`, `flag_lacrado`, `flag_luva`, `id_user`, `status`, `progressao`, `situacao`, `possui`, `screenshot1`, `screenshot2`, `screenshot3`, `screenshot4`, `tempo`, `num_jogadas`, `imagem`) VALUES
(1, '2017-11-26 15:30:35', '2018-01-16 00:48:06', 'Injustice Gods Among', '3', 'Original', 'BRA', '0.00', '0.00', 'Xbox 360', 'Jogo Físico', '', 'Luta', 'Netherhelms', 'Warner Bros Games', 0, 5, '', '', '', 1, 0, 1, 1, 1, 0, 0, 0, 0, 0, 0, 0, 1, 'C', 100, 'Comprado', 1, 'default.jpg', 'default.jpg', 'default.jpg', 'default.jpg', 6, 1, '914032eade889566935cf9f7eaba9623.png'),
(230, '2018-02-06 10:23:43', '2018-02-06 10:23:43', 'Super Nintendo', 'Console da Nintendo', 'Original', 'BRA', '100.00', '200.00', 'Super Nintendo/Super Famicom', 'Console', '', '', '', '', 0, 75, '', '', '', 0, 0, 0, 0, 0, 0, 0, 1, 0, 1, 0, 0, 1, '', 0, 'Comprado', 1, 'default.jpg', 'default.jpg', 'default.jpg', 'default.jpg', 0, 0, 'c51f008a46f17ec696a705ccf5f18351.jpg');

-- --------------------------------------------------------

--
-- Estrutura da tabela `tb_game_log`
--

CREATE TABLE `tb_game_log` (
  `id` int(11) NOT NULL,
  `descricao` varchar(1000) CHARACTER SET latin1 NOT NULL,
  `data` datetime NOT NULL,
  `id_user` int(11) NOT NULL,
  `id_item` int(11) NOT NULL,
  `icone` varchar(50) CHARACTER SET latin1 DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `tb_game_log`
--

INSERT INTO `tb_game_log` (`id`, `descricao`, `data`, `id_user`, `id_item`, `icone`) VALUES
(3, 'O Item XXX teve seus dados atualizados', '2017-12-31 01:21:47', 1, 1, 'fa-refresh'),
(4, 'O status encontra-se do XXX como ', '2017-12-31 01:23:10', 1, 1, 'fa-gamepad'),
(90, 'Cadastro um novo Console de nome XXX', '2018-02-06 10:23:43', 1, 230, 'fa-plus');

-- --------------------------------------------------------

--
-- Estrutura da tabela `tb_game_user`
--

CREATE TABLE `tb_game_user` (
  `id` int(11) NOT NULL,
  `nome` varchar(200) CHARACTER SET latin1 NOT NULL,
  `email` varchar(200) CHARACTER SET latin1 NOT NULL,
  `senha` varchar(50) CHARACTER SET latin1 NOT NULL,
  `data_nascimento` date DEFAULT NULL,
  `telefone` varchar(10) CHARACTER SET latin1 DEFAULT NULL,
  `site` varchar(255) CHARACTER SET latin1 DEFAULT NULL,
  `descricao` varchar(1000) CHARACTER SET latin1 DEFAULT NULL,
  `foto` varchar(255) DEFAULT NULL,
  `fundo` varchar(255) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `tb_game_user`
--

INSERT INTO `tb_game_user` (`id`, `nome`, `email`, `senha`, `data_nascimento`, `telefone`, `site`, `descricao`, `foto`, `fundo`) VALUES
(1, 'Usuário Teste', 'usuario.teste@email.com', '123456', '2001-01-01', '1111111111', 'www.dicaseprogramacao.com.br', 'Exemplo de um usuário', '459e8302548fd6e4d04b7c6eeb08c166.png', 'd9ee434f2fa8d437086e64bb458ce6a3.jpg');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tb_game_item`
--
ALTER TABLE `tb_game_item`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tb_game_log`
--
ALTER TABLE `tb_game_log`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tb_game_user`
--
ALTER TABLE `tb_game_user`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tb_game_item`
--
ALTER TABLE `tb_game_item`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=231;

--
-- AUTO_INCREMENT for table `tb_game_log`
--
ALTER TABLE `tb_game_log`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=91;

--
-- AUTO_INCREMENT for table `tb_game_user`
--
ALTER TABLE `tb_game_user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
