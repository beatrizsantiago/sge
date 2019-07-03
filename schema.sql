-- MySQL dump 10.13  Distrib 8.0.16, for Win64 (x86_64)
--
-- Host: localhost    Database: sge
-- ------------------------------------------------------
-- Server version	8.0.16

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
-- Table structure for table `administrador`
--

DROP TABLE IF EXISTS `administrador`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
 SET character_set_client = utf8mb4 ;
CREATE TABLE `administrador` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `usuarioID` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id_UNIQUE` (`id`),
  KEY `usuarioID_idx` (`usuarioID`),
  CONSTRAINT `usuarioIdAdm` FOREIGN KEY (`usuarioID`) REFERENCES `usuario` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `administrador`
--

LOCK TABLES `administrador` WRITE;
/*!40000 ALTER TABLE `administrador` DISABLE KEYS */;
INSERT INTO `administrador` VALUES (1,1);
/*!40000 ALTER TABLE `administrador` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `atividade`
--

DROP TABLE IF EXISTS `atividade`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
 SET character_set_client = utf8mb4 ;
CREATE TABLE `atividade` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `tipo` varchar(255) NOT NULL,
  `tema` varchar(255) NOT NULL,
  `data` date NOT NULL,
  `hora` time NOT NULL,
  `duracao` time NOT NULL,
  `local` varchar(255) NOT NULL,
  `pontospex` int(11) NOT NULL,
  `vagasminimas` int(11) NOT NULL,
  `vagasmaximas` int(11) NOT NULL,
  `cancelada` tinyint(4) NOT NULL,
  `descricao` varchar(255) DEFAULT NULL,
  `eventoID` int(11) NOT NULL,
  `respAtividadeID` int(11) NOT NULL,
  `palestrante` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id_UNIQUE` (`id`),
  KEY `eventoID_idx` (`eventoID`),
  KEY `respAtividadeID` (`respAtividadeID`),
  CONSTRAINT `eventoIdAtv` FOREIGN KEY (`eventoID`) REFERENCES `evento` (`id`),
  CONSTRAINT `respAtividadeID` FOREIGN KEY (`respAtividadeID`) REFERENCES `responsavelatividade` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `atividade`
--

LOCK TABLES `atividade` WRITE;
/*!40000 ALTER TABLE `atividade` DISABLE KEYS */;
INSERT INTO `atividade` VALUES (4,'Workshop','Fazer a Neve Cair com Let It Go','2019-10-12','12:12:00','03:00:00','Arendel',20,10,20,0,'',3,1,'Rainha Elsa - Atriz Principal de Frozen');
/*!40000 ALTER TABLE `atividade` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `evento`
--

DROP TABLE IF EXISTS `evento`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
 SET character_set_client = utf8mb4 ;
CREATE TABLE `evento` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `titulo` varchar(255) NOT NULL,
  `diaInicio` int(11) NOT NULL,
  `mesInicio` int(11) NOT NULL,
  `anoInicio` int(11) NOT NULL,
  `dataFim` date NOT NULL,
  `local` varchar(255) NOT NULL,
  `cancelado` tinyint(4) NOT NULL,
  `descricao` varchar(255) DEFAULT NULL,
  `respGeralID` int(11) NOT NULL,
  `administradorID` int(11) NOT NULL,
  `imgEvento` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id_UNIQUE` (`id`),
  KEY `respGeralID_idx` (`respGeralID`),
  KEY `administradorID_idx` (`administradorID`),
  CONSTRAINT `administradorID` FOREIGN KEY (`administradorID`) REFERENCES `administrador` (`id`),
  CONSTRAINT `respGeralID` FOREIGN KEY (`respGeralID`) REFERENCES `responsavelgeral` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `evento`
--

LOCK TABLES `evento` WRITE;
/*!40000 ALTER TABLE `evento` DISABLE KEYS */;
INSERT INTO `evento` VALUES (1,'Semana da TI',15,10,2019,'2019-10-20','Unifanor|Wyden',0,NULL,1,1,NULL),(3,'Sematec',12,10,2019,'2019-10-16','Fanor',0,'',3,1,'./img/evento.jpg'),(4,'Semanau',12,4,2019,'2019-12-10','Fanor',0,'',3,1,'./img/evento.jpg'),(5,'Xou da Xuxa com X',17,4,2020,'2020-04-17','RioMar',0,'',3,1,'./img/evento.jpg');
/*!40000 ALTER TABLE `evento` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `inscricaoatividade`
--

DROP TABLE IF EXISTS `inscricaoatividade`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
 SET character_set_client = utf8mb4 ;
CREATE TABLE `inscricaoatividade` (
  `usuarioID` int(11) NOT NULL,
  `atividadeID` int(11) NOT NULL,
  KEY `usuarioID_idx` (`usuarioID`),
  KEY `atividadeID_idx` (`atividadeID`),
  CONSTRAINT `atividadeIdInsAtv` FOREIGN KEY (`atividadeID`) REFERENCES `atividade` (`id`),
  CONSTRAINT `usuarioIdInsAtv` FOREIGN KEY (`usuarioID`) REFERENCES `usuario` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `inscricaoatividade`
--

LOCK TABLES `inscricaoatividade` WRITE;
/*!40000 ALTER TABLE `inscricaoatividade` DISABLE KEYS */;
/*!40000 ALTER TABLE `inscricaoatividade` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `inscricaoevento`
--

DROP TABLE IF EXISTS `inscricaoevento`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
 SET character_set_client = utf8mb4 ;
CREATE TABLE `inscricaoevento` (
  `usuarioID` int(11) NOT NULL,
  `eventoID` int(11) NOT NULL,
  KEY `usuarioID_idx` (`usuarioID`),
  KEY `eventoID_idx` (`eventoID`),
  CONSTRAINT `eventoIdInsEvt` FOREIGN KEY (`eventoID`) REFERENCES `evento` (`id`),
  CONSTRAINT `usuarioIdInsEvt` FOREIGN KEY (`usuarioID`) REFERENCES `usuario` (`id`)
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
-- Table structure for table `organizador`
--

DROP TABLE IF EXISTS `organizador`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
 SET character_set_client = utf8mb4 ;
CREATE TABLE `organizador` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `usuarioID` int(11) NOT NULL,
  `atividadeID` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id_UNIQUE` (`id`),
  KEY `usuarioID_idx` (`usuarioID`),
  KEY `atividadeID_idx` (`atividadeID`),
  CONSTRAINT `atividadeIdOrg` FOREIGN KEY (`atividadeID`) REFERENCES `atividade` (`id`),
  CONSTRAINT `usuarioIdOrg` FOREIGN KEY (`usuarioID`) REFERENCES `usuario` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `organizador`
--

LOCK TABLES `organizador` WRITE;
/*!40000 ALTER TABLE `organizador` DISABLE KEYS */;
/*!40000 ALTER TABLE `organizador` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `participante`
--

DROP TABLE IF EXISTS `participante`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
 SET character_set_client = utf8mb4 ;
CREATE TABLE `participante` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(255) NOT NULL,
  `instituicao` varchar(255) NOT NULL,
  `curso` varchar(150) NOT NULL,
  `imgUser` varchar(255) DEFAULT NULL,
  `apelido` varchar(45) NOT NULL,
  `usuarioID` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id_UNIQUE` (`id`),
  KEY `usuarioID_idx` (`usuarioID`),
  CONSTRAINT `usuarioIdPart` FOREIGN KEY (`usuarioID`) REFERENCES `usuario` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `participante`
--

LOCK TABLES `participante` WRITE;
/*!40000 ALTER TABLE `participante` DISABLE KEYS */;
INSERT INTO `participante` VALUES (1,'asd asd','asd','asd',NULL,'asd',8);
/*!40000 ALTER TABLE `participante` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `responsavelatividade`
--

DROP TABLE IF EXISTS `responsavelatividade`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
 SET character_set_client = utf8mb4 ;
CREATE TABLE `responsavelatividade` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `usuarioID` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id_UNIQUE` (`id`),
  KEY `usuarioIdRespAtv` (`usuarioID`),
  CONSTRAINT `usuarioIdRespAtv` FOREIGN KEY (`usuarioID`) REFERENCES `usuario` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `responsavelatividade`
--

LOCK TABLES `responsavelatividade` WRITE;
/*!40000 ALTER TABLE `responsavelatividade` DISABLE KEYS */;
INSERT INTO `responsavelatividade` VALUES (1,7);
/*!40000 ALTER TABLE `responsavelatividade` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `responsavelgeral`
--

DROP TABLE IF EXISTS `responsavelgeral`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
 SET character_set_client = utf8mb4 ;
CREATE TABLE `responsavelgeral` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `usuarioID` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id_UNIQUE` (`id`),
  KEY `usuarioIdRespGeral` (`usuarioID`),
  CONSTRAINT `usuarioIdRespGeral` FOREIGN KEY (`usuarioID`) REFERENCES `usuario` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `responsavelgeral`
--

LOCK TABLES `responsavelgeral` WRITE;
/*!40000 ALTER TABLE `responsavelgeral` DISABLE KEYS */;
INSERT INTO `responsavelgeral` VALUES (1,2),(2,3),(4,4),(3,5),(5,6);
/*!40000 ALTER TABLE `responsavelgeral` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `usuario`
--

DROP TABLE IF EXISTS `usuario`;
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
INSERT INTO `usuario` VALUES (1,'beatriz@email.com','a8f5f167f44f4964e6c998dee827110c',''),(2,'annabeth@email.com','a8f5f167f44f4964e6c998dee827110c',''),(3,'mione@email.com','a8f5f167f44f4964e6c998dee827110c',''),(4,'potter@email.com','a8f5f167f44f4964e6c998dee827110c',''),(5,'percy@email.com','a8f5f167f44f4964e6c998dee827110c',''),(6,'gina@email.com','7815696ecbf1c96e6894b779456d330e',''),(7,'groover@email.com','7815696ecbf1c96e6894b779456d330e',''),(8,'asd@email.com','7815696ecbf1c96e6894b779456d330e','Administrador');
/*!40000 ALTER TABLE `usuario` ENABLE KEYS */;
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
