-- MySQL dump 10.13  Distrib 8.0.16, for Win64 (x86_64)
--
-- Host: localhost    Database: db_sge
-- ------------------------------------------------------
-- Server version	8.0.16

SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION';

CREATE SCHEMA IF NOT EXISTS `db_sge` DEFAULT CHARACTER SET utf8 ;
USE `db_sge` ;

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
 SET NAMES utf8 ;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `usuario`
--

DROP TABLE IF EXISTS `db_sge`.`usuario`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
 SET character_set_client = utf8mb4 ;
CREATE TABLE `usuario` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `login` varchar(255) NOT NULL,
  `senha` varchar(255) NOT NULL,
  `tipoUsuario` varchar(150) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id_UNIQUE` (`id`),
  UNIQUE KEY `login_UNIQUE` (`login`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `usuario`
--

LOCK TABLES `usuario` WRITE;
/*!40000 ALTER TABLE `usuario` DISABLE KEYS */;
INSERT INTO `db_sge`.`usuario` VALUES (1,'beatriz@email.com','a8f5f167f44f4964e6c998dee827110c','Administrador'),(2,'annie@email.com','a8f5f167f44f4964e6c998dee827110c','ResponsavelGeral'),(3,'mione@email.com','a8f5f167f44f4964e6c998dee827110c','ResponsavelAtividade'),(4,'percy@email.com','a8f5f167f44f4964e6c998dee827110c','Participante'),(5,'potter@email.com','a8f5f167f44f4964e6c998dee827110c','Participante');
/*!40000 ALTER TABLE `usuario` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `participante`
--

DROP TABLE IF EXISTS `db_sge`.`participante`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
 SET character_set_client = utf8mb4 ;
CREATE TABLE `participante` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(255) NOT NULL,
  `instituicao` varchar(255) NOT NULL,
  `curso` varchar(150) NOT NULL,
  `matricula` varchar(12) DEFAULT NULL,
  `imgUser` varchar(255) DEFAULT NULL,
  `apelido` varchar(45) NOT NULL,
  `usuarioID` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id_UNIQUE` (`id`),
  KEY `usuarioID_idx` (`usuarioID`),
  CONSTRAINT `usuarioIdPart` FOREIGN KEY (`usuarioID`) REFERENCES `usuario` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `participante`
--

LOCK TABLES `participante` WRITE;
/*!40000 ALTER TABLE `participante` DISABLE KEYS */;
INSERT INTO `db_sge`.`participante` VALUES (1,'Annabeth Chase','Acampamento Meio Sangue','Arquitetura','171014034','','Annabeth',2),(2,'Hermione Granger','Hogwarts','Transfiguração','171014034','','Hermione',3),(3,'Percy Jackson','Acampamento Meio Sangue','Oceanografia','171014034','','Percy',4),(4,'Harry Potter','Hogwarts','Quadribol','171014034','','Harry',5);
/*!40000 ALTER TABLE `participante` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `administrador`
--

DROP TABLE IF EXISTS `db_sge`.`administrador`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
 SET character_set_client = utf8mb4 ;
CREATE TABLE `administrador` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `usuarioID` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id_UNIQUE` (`id`),
  UNIQUE KEY `usuarioID` (`usuarioID`),
  KEY `usuarioID_idx` (`usuarioID`),
  CONSTRAINT `usuarioIdAdm` FOREIGN KEY (`usuarioID`) REFERENCES `usuario` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `administrador`
--

LOCK TABLES `administrador` WRITE;
/*!40000 ALTER TABLE `administrador` DISABLE KEYS */;
INSERT INTO `db_sge`.`administrador` VALUES (1,1);
/*!40000 ALTER TABLE `administrador` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `responsavelgeral`
--

DROP TABLE IF EXISTS `db_sge`.`responsavelgeral`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
 SET character_set_client = utf8mb4 ;
CREATE TABLE `responsavelgeral` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `usuarioID` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id_UNIQUE` (`id`),
  UNIQUE KEY `usuarioID` (`usuarioID`),
  KEY `usuarioIdRespGeral` (`usuarioID`),
  CONSTRAINT `usuarioIdRespGeral` FOREIGN KEY (`usuarioID`) REFERENCES `usuario` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `responsavelgeral`
--

LOCK TABLES `responsavelgeral` WRITE;
/*!40000 ALTER TABLE `responsavelgeral` DISABLE KEYS */;
INSERT INTO `db_sge`.`responsavelgeral` VALUES (1,2);
/*!40000 ALTER TABLE `responsavelgeral` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `evento`
--

DROP TABLE IF EXISTS `db_sge`.`evento`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
 SET character_set_client = utf8mb4 ;
CREATE TABLE `evento` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `titulo` varchar(255) NOT NULL,
  `dataInicio` date NOT NULL,
  `dataFim` date NOT NULL,
  `local` varchar(255) NOT NULL,
  `cancelado` tinyint(4) NOT NULL,
  `descricao` varchar(255) DEFAULT NULL,
  `respGeralID` int(11) DEFAULT NULL,
  `administradorID` int(11) DEFAULT NULL,
  `imgEvento` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id_UNIQUE` (`id`),
  KEY `respGeralID_idx` (`respGeralID`),
  KEY `administradorID_idx` (`administradorID`),
  CONSTRAINT `administradorID` FOREIGN KEY (`administradorID`) REFERENCES `administrador` (`id`) ON DELETE SET NULL,
  CONSTRAINT `respGeralID` FOREIGN KEY (`respGeralID`) REFERENCES `responsavelgeral` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `evento`
--

LOCK TABLES `evento` WRITE;
/*!40000 ALTER TABLE `evento` DISABLE KEYS */;
INSERT INTO `db_sge`.`evento` VALUES (1, 'Semana Acadêmica da TI','2019-10-14','2019-10-17','Unifanor|Wyden',0,'Semana cheia de palestras relacionado ao mundo da TI',1,1,'./img/evento.jpg');
/*!40000 ALTER TABLE `evento` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `responsavelatividade`
--

DROP TABLE IF EXISTS `db_sge`.`responsavelatividade`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
 SET character_set_client = utf8mb4 ;
CREATE TABLE `responsavelatividade` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `usuarioID` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id_UNIQUE` (`id`),
  UNIQUE KEY `usuarioID` (`usuarioID`),
  KEY `usuarioIdRespAtv` (`usuarioID`),
  CONSTRAINT `usuarioIdRespAtv` FOREIGN KEY (`usuarioID`) REFERENCES `usuario` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `responsavelatividade`
--

LOCK TABLES `responsavelatividade` WRITE;
/*!40000 ALTER TABLE `responsavelatividade` DISABLE KEYS */;
INSERT INTO `db_sge`.`responsavelatividade` VALUES (1,3);
/*!40000 ALTER TABLE `responsavelatividade` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tipoatividade`
--

DROP TABLE IF EXISTS `db_sge`.`tipoatividade`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
 SET character_set_client = utf8mb4 ;
CREATE TABLE `tipoatividade` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `tipo` varchar(50) NOT NULL,
  `cor` varchar(7) NOT NULL,
  UNIQUE KEY `id` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tipoatividade`
--

LOCK TABLES `tipoatividade` WRITE;
/*!40000 ALTER TABLE `tipoatividade` DISABLE KEYS */;
INSERT INTO `db_sge`.`tipoatividade` VALUES ("Palestra", "#75036c"), ("Minicurso", "#036819"), ("Workshop", "#225e97"), ("Mesa Redonda", "#c27e00"), ("Painel", "#6107aa"), ("Exposição", "#5c3c00");
/*!40000 ALTER TABLE `tipoatividade` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `atividade`
--

DROP TABLE IF EXISTS `db_sge`.`atividade`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
 SET character_set_client = utf8mb4 ;
CREATE TABLE `atividade` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `tipoID` int(11) NOT NULL,
  `tema` varchar(255) NOT NULL,
  `data` date NOT NULL,
  `hora` time NOT NULL,
  `duracao` time NOT NULL,
  `local` varchar(255) NOT NULL,
  `pontosPex` int(11) NOT NULL,
  `vagasMinimas` int(11) NOT NULL,
  `vagasMaximas` int(11) NOT NULL,
  `cancelada` tinyint(4) NOT NULL,
  `descricao` varchar(255) DEFAULT NULL,
  `eventoID` int(11) NOT NULL,
  `respAtividadeID` int(11) DEFAULT NULL,
  `palestrante` varchar(255) NOT NULL,
  `imgPalestrante` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id_UNIQUE` (`id`),
  KEY `eventoID_idx` (`eventoID`),
  KEY `respAtividadeID` (`respAtividadeID`),
  KEY `tipoID` (`tipoID`),
  CONSTRAINT `eventoIdAtv` FOREIGN KEY (`eventoID`) REFERENCES `evento` (`id`) ON DELETE CASCADE,
  CONSTRAINT `respAtividadeID` FOREIGN KEY (`respAtividadeID`) REFERENCES `responsavelatividade` (`id`) ON DELETE SET NULL,
  CONSTRAINT `tipoID` FOREIGN KEY (`tipoID`) REFERENCES `tipoatividade` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `atividade`
--

LOCK TABLES `atividade` WRITE;
/*!40000 ALTER TABLE `atividade` DISABLE KEYS */;
INSERT INTO `db_sge`.`atividade` VALUES (1,1,'Fazer a Neve Cair com Let It Go','2019-10-15','19:00:00','02:00:00','Auditório 02',20,30,100,0,'',1,1,'Rainha Elsa - Atriz Principal de Frozen');
/*!40000 ALTER TABLE `atividade` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `inscricaoevento`
--

DROP TABLE IF EXISTS `db_sge`.`inscricaoevento`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
 SET character_set_client = utf8mb4 ;
CREATE TABLE `inscricaoevento` (
  `usuarioID` int(11) NOT NULL,
  `eventoID` int(11) NOT NULL,
  KEY `usuarioID_idx` (`usuarioID`),
  KEY `eventoID_idx` (`eventoID`),
  CONSTRAINT `eventoIdInsEvt` FOREIGN KEY (`eventoID`) REFERENCES `evento` (`id`) ON DELETE CASCADE,
  CONSTRAINT `usuarioIdInsEvt` FOREIGN KEY (`usuarioID`) REFERENCES `usuario` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `inscricaoevento`
--

LOCK TABLES `inscricaoevento` WRITE;
/*!40000 ALTER TABLE `inscricaoevento` DISABLE KEYS */;
/*!40000 ALTER TABLE `inscricaoevento` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `inscricaoatividade`
--

DROP TABLE IF EXISTS `db_sge`.`inscricaoatividade`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
 SET character_set_client = utf8mb4 ;
CREATE TABLE `inscricaoatividade` (
  `usuarioID` int(11) NOT NULL,
  `atividadeID` int(11) NOT NULL,
  `presente` tinyint(1) DEFAULT NULL,
  KEY `usuarioID_idx` (`usuarioID`),
  KEY `atividadeID_idx` (`atividadeID`),
  CONSTRAINT `atividadeIdInsAtv` FOREIGN KEY (`atividadeID`) REFERENCES `atividade` (`id`) ON DELETE CASCADE,
  CONSTRAINT `usuarioIdInsAtv` FOREIGN KEY (`usuarioID`) REFERENCES `usuario` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `inscricaoatividade`
--

LOCK TABLES `inscricaoatividade` WRITE;
/*!40000 ALTER TABLE `inscricaoatividade` DISABLE KEYS */;
/*!40000 ALTER TABLE `inscricaoatividade` ENABLE KEYS */;
UNLOCK TABLES;

/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2019-07-02 22:47:10
