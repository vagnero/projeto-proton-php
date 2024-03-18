CREATE DATABASE protoon_php;
USE protoon_php;
 
CREATE TABLE `enderecos` (
  `idEndereco` int(11) NOT NULL,
  `cep` varchar(10) DEFAULT NULL,
  `estado` varchar(2) CHARACTER SET utf8 DEFAULT NULL,
  `cidade` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
  `bairro` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
  `rua` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
  `numero` varchar(10) DEFAULT NULL,
  `complemento` varchar(255) CHARACTER SET utf8 DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

CREATE TABLE `municipes` (
  `idMunicipe` int(11) NOT NULL,
  `nome` varchar(20) CHARACTER SET utf8 NOT NULL,
  `celular` varchar(15) NOT NULL,
  `dataInscricao` datetime NOT NULL,
  `idEndereco` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `senha` varchar(255) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

CREATE TABLE `reclamacoes` (
  `idReclamacao` int(11) NOT NULL,
  `problema` varchar(255) CHARACTER SET utf8 NOT NULL,
  `descricao` text CHARACTER SET utf8 DEFAULT NULL,
  `idEndereco` int(11) NOT NULL,
  `idMunicipe` int(11) NOT NULL,
  `dataReclamacao` datetime NOT NULL,
  `statusAtual` varchar(50) CHARACTER SET utf8mb4 NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;