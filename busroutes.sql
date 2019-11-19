-- --------------------------------------------------------
-- Servidor:                     127.0.0.1
-- Versão do servidor:           8.0.13 - MySQL Community Server - GPL
-- OS do Servidor:               Win64
-- HeidiSQL Versão:              10.1.0.5464
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;


-- Copiando estrutura do banco de dados para busroutes
CREATE DATABASE IF NOT EXISTS `busroutes` /*!40100 DEFAULT CHARACTER SET utf8 */;
USE `busroutes`;

-- Copiando estrutura para tabela busroutes.empresa
CREATE TABLE IF NOT EXISTS `empresa` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(100) NOT NULL,
  `email` varchar(60) NOT NULL,
  `senha` varchar(30) NOT NULL,
  `telefone` varchar(15) DEFAULT NULL,
  `token` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Exportação de dados foi desmarcado.
-- Copiando estrutura para tabela busroutes.localizacao_onibus
CREATE TABLE IF NOT EXISTS `localizacao_onibus` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `lat_atual` float NOT NULL,
  `lng_atual` float NOT NULL,
  `id_onibus` int(11) NOT NULL,
  `data_hora_atual` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `FK_Onibus_loc` (`id_onibus`),
  CONSTRAINT `FK_Onibus_loc` FOREIGN KEY (`id_onibus`) REFERENCES `onibus` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Exportação de dados foi desmarcado.
-- Copiando estrutura para tabela busroutes.noticias
CREATE TABLE IF NOT EXISTS `noticias` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `titulo` varchar(40) NOT NULL,
  `descricao` text NOT NULL,
  `minidescricao` text,
  `id_usuario` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_Usuario` (`id_usuario`),
  CONSTRAINT `FK_Usuario` FOREIGN KEY (`id_usuario`) REFERENCES `usuario` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Exportação de dados foi desmarcado.
-- Copiando estrutura para tabela busroutes.onibus
CREATE TABLE IF NOT EXISTS `onibus` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `placa` varchar(15) NOT NULL,
  `modelo` varchar(58) DEFAULT NULL,
  `intermunicipal` tinyint(1) NOT NULL DEFAULT '0',
  `img_onibus` varchar(60) DEFAULT NULL,
  `id_empresa` int(11) NOT NULL,
  `data_registro` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `ativo` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  KEY `FK_Empresa_onibus` (`id_empresa`),
  CONSTRAINT `FK_Empresa_onibus` FOREIGN KEY (`id_empresa`) REFERENCES `empresa` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Exportação de dados foi desmarcado.
-- Copiando estrutura para tabela busroutes.promocao
CREATE TABLE IF NOT EXISTS `promocao` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `descricao` varchar(150) NOT NULL,
  `prcnt_desconto` int(3) DEFAULT NULL,
  `desconto_fixo` float DEFAULT NULL,
  `data_ini` date NOT NULL,
  `data_fim` date NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Exportação de dados foi desmarcado.
-- Copiando estrutura para tabela busroutes.promocoes_empresa
CREATE TABLE IF NOT EXISTS `promocoes_empresa` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_empresa` int(11) NOT NULL,
  `id_promocao` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_Promocao` (`id_promocao`),
  KEY `FK_Empresa` (`id_empresa`),
  CONSTRAINT `FK_Empresa` FOREIGN KEY (`id_empresa`) REFERENCES `empresa` (`id`) ON DELETE CASCADE,
  CONSTRAINT `FK_Promocao` FOREIGN KEY (`id_promocao`) REFERENCES `promocao` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Exportação de dados foi desmarcado.
-- Copiando estrutura para tabela busroutes.rotas
CREATE TABLE IF NOT EXISTS `rotas` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `lat_inicial` float NOT NULL,
  `lng_inicial` float NOT NULL,
  `lat_final` float NOT NULL,
  `lng_final` float NOT NULL,
  `id_onibus` int(11) NOT NULL,
  `horario_ini` time NOT NULL,
  `horario_fim` time NOT NULL,
  `v_passagem` float NOT NULL,
  `v_passagem_estudante` float NOT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_Onibus_rotas` (`id_onibus`),
  CONSTRAINT `FK_Onibus_rotas` FOREIGN KEY (`id_onibus`) REFERENCES `onibus` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Exportação de dados foi desmarcado.
-- Copiando estrutura para tabela busroutes.usuario
CREATE TABLE IF NOT EXISTS `usuario` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(60) NOT NULL,
  `email` varchar(80) NOT NULL,
  `senha` varchar(30) NOT NULL,
  `admin` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Exportação de dados foi desmarcado.
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
