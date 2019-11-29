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
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- Copiando dados para a tabela busroutes.empresa: ~0 rows (aproximadamente)
DELETE FROM `empresa`;
/*!40000 ALTER TABLE `empresa` DISABLE KEYS */;
INSERT INTO `empresa` (`id`, `nome`, `email`, `senha`, `telefone`, `token`) VALUES
	(1, 'padrão', 'a@a', 'aosjdaw', '131231231', 'token_padrao');
/*!40000 ALTER TABLE `empresa` ENABLE KEYS */;

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

-- Copiando dados para a tabela busroutes.localizacao_onibus: ~0 rows (aproximadamente)
DELETE FROM `localizacao_onibus`;
/*!40000 ALTER TABLE `localizacao_onibus` DISABLE KEYS */;
/*!40000 ALTER TABLE `localizacao_onibus` ENABLE KEYS */;

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
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

-- Copiando dados para a tabela busroutes.noticias: ~5 rows (aproximadamente)
DELETE FROM `noticias`;
/*!40000 ALTER TABLE `noticias` DISABLE KEYS */;
INSERT INTO `noticias` (`id`, `titulo`, `descricao`, `minidescricao`, `id_usuario`) VALUES
	(1, 'Where does it come from?', 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. \r\nLorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type \r\nand scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap\r\n into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem IpsumLorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, \r\nwhen an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting,\r\n remaining essentially unchanged. It was popularised in the 1960s with\r\n the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum', 'Lorem Ipsum is simply dummy text', 1),
	(2, 'Noticia', 'uma descrição bem básica só pra testa', 'descriçãozinha', 1);
/*!40000 ALTER TABLE `noticias` ENABLE KEYS */;

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
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- Copiando dados para a tabela busroutes.onibus: ~0 rows (aproximadamente)
DELETE FROM `onibus`;
/*!40000 ALTER TABLE `onibus` DISABLE KEYS */;
INSERT INTO `onibus` (`id`, `placa`, `modelo`, `intermunicipal`, `img_onibus`, `id_empresa`, `data_registro`, `ativo`) VALUES
	(1, '1231', '123', 0, NULL, 1, '2019-11-28 22:54:59', 1);
/*!40000 ALTER TABLE `onibus` ENABLE KEYS */;

-- Copiando estrutura para tabela busroutes.paradas
CREATE TABLE IF NOT EXISTS `paradas` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `lat` float NOT NULL,
  `lng` float NOT NULL,
  `horario` time NOT NULL,
  `id_rota` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_paradas_rotas` (`id_rota`),
  CONSTRAINT `FK_paradas_rotas` FOREIGN KEY (`id_rota`) REFERENCES `rotas` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

-- Copiando dados para a tabela busroutes.paradas: ~0 rows (aproximadamente)
DELETE FROM `paradas`;
/*!40000 ALTER TABLE `paradas` DISABLE KEYS */;
INSERT INTO `paradas` (`id`, `lat`, `lng`, `horario`, `id_rota`) VALUES
	(2, 123.1, 123.1, '01:02:00', 6),
	(3, 123.1, 123.1, '01:02:00', 6),
	(4, 123.1, 123.1, '01:02:00', 6),
	(5, 123.1, 123.1, '01:02:00', 6);
/*!40000 ALTER TABLE `paradas` ENABLE KEYS */;

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

-- Copiando dados para a tabela busroutes.promocao: ~0 rows (aproximadamente)
DELETE FROM `promocao`;
/*!40000 ALTER TABLE `promocao` DISABLE KEYS */;
/*!40000 ALTER TABLE `promocao` ENABLE KEYS */;

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

-- Copiando dados para a tabela busroutes.promocoes_empresa: ~0 rows (aproximadamente)
DELETE FROM `promocoes_empresa`;
/*!40000 ALTER TABLE `promocoes_empresa` DISABLE KEYS */;
/*!40000 ALTER TABLE `promocoes_empresa` ENABLE KEYS */;

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
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;

-- Copiando dados para a tabela busroutes.rotas: ~0 rows (aproximadamente)
DELETE FROM `rotas`;
/*!40000 ALTER TABLE `rotas` DISABLE KEYS */;
INSERT INTO `rotas` (`id`, `lat_inicial`, `lng_inicial`, `lat_final`, `lng_final`, `id_onibus`, `horario_ini`, `horario_fim`, `v_passagem`, `v_passagem_estudante`) VALUES
	(6, 1, 2, 1, 2, 1, '01:01:00', '02:02:00', 3, 1.5);
/*!40000 ALTER TABLE `rotas` ENABLE KEYS */;

-- Copiando estrutura para tabela busroutes.usuario
CREATE TABLE IF NOT EXISTS `usuario` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(60) NOT NULL,
  `email` varchar(80) NOT NULL,
  `senha` varchar(45) NOT NULL,
  `admin` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8;

-- Copiando dados para a tabela busroutes.usuario: ~1 rows (aproximadamente)
DELETE FROM `usuario`;
/*!40000 ALTER TABLE `usuario` DISABLE KEYS */;
INSERT INTO `usuario` (`id`, `nome`, `email`, `senha`, `admin`) VALUES
	(1, 'percio', 'a@a', 'd9f85236a3f7d17b2311ef98953ebf233700ac82', 0),
	(10, 'a', 'a', '0c366ef9026c6f7c6b1f2f97b480649437a2f294', 0);
/*!40000 ALTER TABLE `usuario` ENABLE KEYS */;

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
