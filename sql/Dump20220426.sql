-- MySQL dump 10.13  Distrib 5.6.23, for Win32 (x86)
--
-- Host: localhost    Database: mos
-- ------------------------------------------------------
-- Server version	5.7.36

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `tab_alunos`
--

DROP TABLE IF EXISTS `tab_alunos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tab_alunos` (
  `alu_id` int(11) NOT NULL AUTO_INCREMENT,
  `alu_nome` varchar(50) NOT NULL,
  `alu_sobrenome` varchar(50) NOT NULL,
  `alu_nascimento` date NOT NULL,
  `alu_telefone` varchar(20) NOT NULL,
  `alu_resposavel` varchar(100) NOT NULL,
  `alu_sexo` varchar(20) NOT NULL,
  `alu_email` varchar(150) DEFAULT NULL,
  `alu_endereco` varchar(150) DEFAULT NULL,
  `alu_obs` varchar(150) DEFAULT NULL,
  `alu_senha` varchar(150) DEFAULT NULL,
  `alu_ativado` enum('0','1') NOT NULL DEFAULT '1',
  `alu_data_cadastro` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `alu_foto` varchar(200) DEFAULT NULL,
  `alu_mensalidade` float DEFAULT '0',
  `alu_mensalidade_venc` varchar(4) NOT NULL DEFAULT '01',
  `alu_aul_id` int(11) NOT NULL,
  `alu_prof_id` int(11) NOT NULL,
  `alu_cpf` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`alu_id`),
  UNIQUE KEY `alu_id_UNIQUE` (`alu_id`),
  KEY `fk_tab_alunos_tab_aulas1_idx` (`alu_aul_id`),
  KEY `fk_tab_alunos_tab_professores1_idx` (`alu_prof_id`),
  CONSTRAINT `fk_tab_alunos_tab_aulas1` FOREIGN KEY (`alu_aul_id`) REFERENCES `tab_aulas` (`aul_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_tab_alunos_tab_professores1` FOREIGN KEY (`alu_prof_id`) REFERENCES `tab_professores` (`prof_id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tab_alunos`
--

LOCK TABLES `tab_alunos` WRITE;
/*!40000 ALTER TABLE `tab_alunos` DISABLE KEYS */;
/*!40000 ALTER TABLE `tab_alunos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tab_aulas`
--

DROP TABLE IF EXISTS `tab_aulas`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tab_aulas` (
  `aul_id` int(11) NOT NULL AUTO_INCREMENT,
  `aul_nome` varchar(50) NOT NULL,
  `aul_horario` varchar(5) NOT NULL,
  `aul_dia_semana` varchar(15) NOT NULL,
  `aul_obs` varchar(150) DEFAULT NULL,
  `aul_comissao` float DEFAULT '0',
  `aul_ativado` enum('0','1') DEFAULT '1',
  `aul_data_cadastro` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `aul_prof_id` int(11) NOT NULL,
  PRIMARY KEY (`aul_id`),
  UNIQUE KEY `aul_id_UNIQUE` (`aul_id`),
  KEY `fk_tab_aulas_tab_professores1_idx` (`aul_prof_id`),
  CONSTRAINT `fk_tab_aulas_tab_professores1` FOREIGN KEY (`aul_prof_id`) REFERENCES `tab_professores` (`prof_id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tab_aulas`
--

LOCK TABLES `tab_aulas` WRITE;
/*!40000 ALTER TABLE `tab_aulas` DISABLE KEYS */;
INSERT INTO `tab_aulas` VALUES (1,'AULA1','15:45','TERÃ‡A','TESTE',0,'0','2022-04-25 21:47:58',7),(2,'AULA2','15:36','SEGUNDA','SSDFASDF',0,'1','2022-04-25 23:11:56',4),(3,'AULA3','15:40','QUARTA','',0,'1','2022-04-25 23:12:49',7);
/*!40000 ALTER TABLE `tab_aulas` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tab_professores`
--

DROP TABLE IF EXISTS `tab_professores`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tab_professores` (
  `prof_id` int(11) NOT NULL AUTO_INCREMENT,
  `prof_nome` varchar(50) NOT NULL,
  `prof_sobrenome` varchar(50) NOT NULL,
  `prof_nascimento` date NOT NULL,
  `prof_telefone` varchar(20) NOT NULL,
  `prof_sexo` varchar(20) NOT NULL,
  `prof_email` varchar(150) DEFAULT NULL,
  `prof_endereco` varchar(150) DEFAULT NULL,
  `prof_obs` varchar(150) DEFAULT NULL,
  `prof_senha` varchar(150) DEFAULT NULL,
  `prof_ativado` varchar(7) NOT NULL DEFAULT 'Ativo',
  `prof_data_cadastro` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `prof_comissao` double NOT NULL DEFAULT '0',
  `prof_foto` varchar(200) DEFAULT '../Fotos/semfoto.jpg',
  PRIMARY KEY (`prof_id`),
  UNIQUE KEY `prof_id_UNIQUE` (`prof_id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tab_professores`
--

LOCK TABLES `tab_professores` WRITE;
/*!40000 ALTER TABLE `tab_professores` DISABLE KEYS */;
INSERT INTO `tab_professores` VALUES (1,'MARCIO','SOUZA','1983-12-08','459997218883','MASCULINO','qkmarcio@gmail.com','ENDERECO','OOOSDFSADFASDF','5e543256c480ac577d30f76f9120eb74','ATIVO','2022-04-14 21:35:15',10,'../Fotos/imgProfessor/62631903669a1.png'),(2,'MARCIO1','SOUZA1','1983-12-08','459997218883','MASCULINO','qkmarcio@gmail.com','ENDERECO','OOOSDFSADFASDF','5e543256c480ac577d30f76f9120eb74','INATIVO','2022-04-14 21:36:03',5.3,'../Fotos/imgProfessor/6263195e5c94c.png'),(3,'TESTE','TEETEEEE','5222-12-12','545888554','MASCULINO','sadfasdf@sfff.com','SFSADFASDFSF','SDFASDFASDFASDF','31555','Ativo','2022-04-14 21:58:58',3,'../Fotos/semfoto.jpg'),(4,'DENISE','DUTRA','1987-05-28','(44) 4444-4444','FEMININO','qkdenise@gmail.com','RUA RUI BARBOSA,931,APT301','TESTE DENISELLL OIOIPIOIPIOPfffff','5e543256c480ac577d30f76f9120eb74','ATIVO','2022-04-14 22:03:41',22,'../Fotos/imgProfessor/6263192128b71.png'),(5,'TESTE','ASETSAT','2022-04-18','555555','MASCULINO','asetsat','SAET','ASTASET','5e543256c480ac577d30f76f9120eb74','ATIVO','2022-04-17 18:43:06',123,'../Fotos/semfoto.jpg'),(6,'TESTE','ASETSAT','2022-04-18','555555','MASCULINO','asetsat','SAET','ASTASET','5e543256c480ac577d30f76f9120eb74','INATIVO','2022-04-17 18:43:37',123,'../Fotos/semfoto.jpg'),(7,'TESTE','ASETSAT','2022-04-18','555555','MASCULINO','asetsat','SAET','ASTASET','5e543256c480ac577d30f76f9120eb74','INATIVO','2022-04-17 18:45:50',123,'../Fotos/semfoto.jpg'),(8,'TETTE','TTTE','1983-12-12','454545','MASCULINO','qkmarcio@gmail.com','SAFDSAD','SDFSADFSADF','5e543256c480ac577d30f76f9120eb74','ATIVO','2022-04-22 18:11:44',10,'../Fotos/imgProfessor/62631a4276a13.png'),(9,'joaquim','almeida','2019-12-24','(45) 99972-1883','MASCULINO','qkmarcio@gmail.com','tes','teste tesat f','5e543256c480ac577d30f76f9120eb74','ATIVO','2022-04-24 14:14:44',22.22,'../Fotos/imgProfessor/626587d584484.png');
/*!40000 ALTER TABLE `tab_professores` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tab_usuarios`
--

DROP TABLE IF EXISTS `tab_usuarios`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tab_usuarios` (
  `usu_id` int(11) NOT NULL AUTO_INCREMENT,
  `usu_nome` varchar(50) NOT NULL,
  `usu_login` varchar(50) NOT NULL,
  `usu_email` varchar(150) NOT NULL,
  `usu_senha` varchar(150) NOT NULL,
  `usu_telefone` varchar(150) NOT NULL,
  `usu_ativado` enum('0','1') NOT NULL,
  `usu_nivel_usuario` enum('0','1','2') NOT NULL,
  `usu_data_cadastro` datetime NOT NULL,
  `usu_descricao` varchar(150) DEFAULT NULL,
  `usu_data_ultimo_login` datetime DEFAULT NULL,
  PRIMARY KEY (`usu_id`),
  UNIQUE KEY `usu_id_UNIQUE` (`usu_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tab_usuarios`
--

LOCK TABLES `tab_usuarios` WRITE;
/*!40000 ALTER TABLE `tab_usuarios` DISABLE KEYS */;
INSERT INTO `tab_usuarios` VALUES (1,'marcio oliveira de souza','marcio','qkmarcio@gmail.com','698dc19d489c4e4db73e28a713eab07b','(45) 99972-1883','1','2','2022-04-01 00:25:05','Usuario de Teste.','2022-04-01 04:54:00');
/*!40000 ALTER TABLE `tab_usuarios` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2022-04-26  1:04:53
