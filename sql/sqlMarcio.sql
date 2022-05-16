CREATE DATABASE  IF NOT EXISTS `mos` /*!40100 DEFAULT CHARACTER SET utf8 */;
USE `mos`;
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
  `alu_nome` varchar(100) NOT NULL,
  `alu_nascimento` date NOT NULL,
  `alu_resposavel` varchar(100) NOT NULL,
  `alu_cep` varchar(15) DEFAULT NULL,
  `alu_bairro` varchar(45) DEFAULT NULL,
  `alu_endereco` varchar(150) DEFAULT NULL,
  `alu_cidade` varchar(45) DEFAULT NULL,
  `alu_cpf` varchar(20) DEFAULT NULL,
  `alu_telefone` varchar(20) DEFAULT NULL,
  `alu_celular` varchar(20) NOT NULL,
  `alu_sexo` varchar(20) NOT NULL,
  `alu_email` varchar(150) DEFAULT NULL,
  `alu_email_recibo` enum('0','1') DEFAULT '0',
  `alu_obs` varchar(150) DEFAULT NULL,
  `alu_senha` varchar(150) DEFAULT NULL,
  `alu_ativado` enum('0','1') NOT NULL DEFAULT '1',
  `alu_foto` varchar(200) DEFAULT '../Fotos/semfoto.jpg',
  `alu_data_cadastro` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`alu_id`),
  UNIQUE KEY `alu_id_UNIQUE` (`alu_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tab_alunos`
--

LOCK TABLES `tab_alunos` WRITE;
/*!40000 ALTER TABLE `tab_alunos` DISABLE KEYS */;
INSERT INTO `tab_alunos` VALUES (1,'ALEX TESTE','1983-12-08','MARCIO','85856-180','CENTRO','RUA RUI BARBOSA','FOZ DO IGUAÃ§U','036.619.139-05','(45) 9999-9999','(45) 99999-9999','MASCULINO','qkmarcio@gmail.com','0','teste obs','undefined','1','../Fotos/imgAluno/62754541c4ed0.jpg','2022-05-05 07:19:53'),(2,'NAR','1921-12-12','JESSICA','85856-180','FFF','DDD','FOZ DO IGUAÃ§U','036.619.139-05','(45) 4544-5454','(66) 45446-5446','MASCULINO','qkmarcio@gmail.com','0','asdasd','undefined','0','../Fotos/imgAluno/627547f7c0147.jpg','2022-05-05 11:19:21');
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
  `aul_prof_id` int(11) NOT NULL,
  `aul_data_cadastro` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
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
INSERT INTO `tab_aulas` VALUES (1,'AULA1','15:45','TERÇA','TESTE',0,'1',10,'2022-04-25 21:47:58'),(2,'AULA2','15:36','SEGUNDA','SSDFASDF',0,'1',11,'2022-04-25 23:11:56'),(3,'AULA3','15:40','SEXTA','',0,'1',10,'2022-04-25 23:12:49');
/*!40000 ALTER TABLE `tab_aulas` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tab_contas`
--

DROP TABLE IF EXISTS `tab_contas`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tab_contas` (
  `contas_id` int(11) NOT NULL AUTO_INCREMENT,
  `contas_nome` varchar(50) NOT NULL,
  PRIMARY KEY (`contas_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tab_contas`
--

LOCK TABLES `tab_contas` WRITE;
/*!40000 ALTER TABLE `tab_contas` DISABLE KEYS */;
/*!40000 ALTER TABLE `tab_contas` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tab_contratos`
--

DROP TABLE IF EXISTS `tab_contratos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tab_contratos` (
  `con_id` int(11) NOT NULL AUTO_INCREMENT,
  `con_vencimento` date DEFAULT NULL,
  `con_valor` float DEFAULT '0',
  `con_meses` int(11) DEFAULT NULL,
  `con_obs` varchar(200) DEFAULT NULL,
  `con_ativado` enum('0','1') DEFAULT '1',
  `con_email_notificacao` enum('0','1') DEFAULT '1',
  `con_data_cadastro` datetime DEFAULT CURRENT_TIMESTAMP,
  `alunos_id` int(11) NOT NULL,
  `modalidades_id` int(11) NOT NULL,
  PRIMARY KEY (`con_id`),
  KEY `fk_tab_contratos_tab_alunos1_idx` (`alunos_id`),
  KEY `fk_tab_contratos_tab_modalidade1_idx` (`modalidades_id`),
  CONSTRAINT `fk_tab_contratos_tab_alunos1` FOREIGN KEY (`alunos_id`) REFERENCES `tab_alunos` (`alu_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_tab_contratos_tab_modalidade1` FOREIGN KEY (`modalidades_id`) REFERENCES `tab_modalidades` (`modalidade_id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tab_contratos`
--

LOCK TABLES `tab_contratos` WRITE;
/*!40000 ALTER TABLE `tab_contratos` DISABLE KEYS */;
INSERT INTO `tab_contratos` VALUES (1,'2022-05-13',400,12,'TESTE','1','0','2022-05-12 12:16:53',1,1);
/*!40000 ALTER TABLE `tab_contratos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tab_despesas`
--

DROP TABLE IF EXISTS `tab_despesas`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tab_despesas` (
  `des_id` int(11) NOT NULL AUTO_INCREMENT,
  `des_valor` float DEFAULT NULL,
  `des_data` date DEFAULT NULL,
  `des_status` enum('0','1') DEFAULT '0',
  `des_data_cadastro` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`des_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tab_despesas`
--

LOCK TABLES `tab_despesas` WRITE;
/*!40000 ALTER TABLE `tab_despesas` DISABLE KEYS */;
/*!40000 ALTER TABLE `tab_despesas` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tab_mensalidades`
--

DROP TABLE IF EXISTS `tab_mensalidades`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tab_mensalidades` (
  `men_id` int(11) NOT NULL AUTO_INCREMENT,
  `men_vencimento` date DEFAULT NULL,
  `men_data_pago` date DEFAULT NULL,
  `men_status` varchar(1) DEFAULT '0' COMMENT '0 = Pendente\n1 = Pago Parcial\n3 = Pagamento concluído',
  `men_valor` float DEFAULT '0',
  `men_valor_pago` float DEFAULT '0',
  `men_saldo` float DEFAULT '0',
  `men_data_cadastro` datetime DEFAULT CURRENT_TIMESTAMP,
  `contratos_id` int(11) NOT NULL,
  `men_pago_tipo` varchar(45) DEFAULT NULL,
  `men_pago_obs` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`men_id`),
  KEY `fk_tab_mensalidades_tab_contratos1_idx` (`contratos_id`),
  CONSTRAINT `fk_tab_mensalidades_tab_contratos1` FOREIGN KEY (`contratos_id`) REFERENCES `tab_contratos` (`con_id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tab_mensalidades`
--

LOCK TABLES `tab_mensalidades` WRITE;
/*!40000 ALTER TABLE `tab_mensalidades` DISABLE KEYS */;
INSERT INTO `tab_mensalidades` VALUES (1,'2022-05-13',NULL,'0',250,0,250,'2022-05-13 00:00:00',1,NULL,NULL);
/*!40000 ALTER TABLE `tab_mensalidades` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tab_modalidades`
--

DROP TABLE IF EXISTS `tab_modalidades`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tab_modalidades` (
  `modalidade_id` int(11) NOT NULL AUTO_INCREMENT,
  `modalidade_nome` varchar(45) NOT NULL,
  `modalidade_ativado` enum('0','1') DEFAULT '1',
  `modalidade_obs` varchar(200) DEFAULT NULL,
  `modalidade_data_cadastro` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`modalidade_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tab_modalidades`
--

LOCK TABLES `tab_modalidades` WRITE;
/*!40000 ALTER TABLE `tab_modalidades` DISABLE KEYS */;
INSERT INTO `tab_modalidades` VALUES (1,'MENSALIDADE','1','modo de mensalidade','2022-05-09 21:07:04');
/*!40000 ALTER TABLE `tab_modalidades` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tab_professores`
--

DROP TABLE IF EXISTS `tab_professores`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tab_professores` (
  `prof_id` int(11) NOT NULL AUTO_INCREMENT,
  `prof_nome` varchar(100) NOT NULL,
  `prof_nascimento` date NOT NULL,
  `prof_cep` varchar(15) DEFAULT NULL,
  `prof_bairro` varchar(45) DEFAULT NULL,
  `prof_endereco` varchar(150) DEFAULT NULL,
  `prof_cidade` varchar(45) DEFAULT NULL,
  `prof_cpf` varchar(20) DEFAULT NULL,
  `prof_telefone` varchar(20) NOT NULL,
  `prof_celular` varchar(20) DEFAULT NULL,
  `prof_sexo` varchar(20) NOT NULL,
  `prof_email` varchar(150) DEFAULT NULL,
  `prof_obs` varchar(150) DEFAULT NULL,
  `prof_senha` varchar(150) DEFAULT NULL,
  `prof_ativado` enum('0','1') NOT NULL DEFAULT '1',
  `prof_comissao` float NOT NULL DEFAULT '0',
  `prof_foto` varchar(200) DEFAULT '../Fotos/semfoto.jpg',
  `prof_data_cadastro` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`prof_id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tab_professores`
--

LOCK TABLES `tab_professores` WRITE;
/*!40000 ALTER TABLE `tab_professores` DISABLE KEYS */;
INSERT INTO `tab_professores` VALUES (10,'HENRIQUE','2020-05-12','11111-111','SFSAFDSF','SDFASFASDF','SADFASDF','444.546.454-44','(45) 4545-4566','(45) 45454-5466','MASCULINO','sadfasdf@sfff.com','ASDFSADF','undefined','1',1.6,'../Fotos/imgProfessor/62757fe416a67.jpg','2022-05-06 16:10:15'),(11,'JOAQUIM','2020-05-12','11111-111','SFSAFDSF','SDFASFASDF','SADFASDF','666.688.888-88','(45) 4545-4566','(45) 45454-5466','MASCULINO','sadfasdf@sfff.com','ASDFSADF','undefined','0',1.5,'../Fotos/imgProfessor/627581d614953.jpg','2022-05-06 16:15:18');
/*!40000 ALTER TABLE `tab_professores` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tab_receitas`
--

DROP TABLE IF EXISTS `tab_receitas`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tab_receitas` (
  `receitas_id` int(11) NOT NULL AUTO_INCREMENT,
  `receitas_valor` float DEFAULT NULL,
  `receitas_data` date DEFAULT NULL,
  `receitas_obs` varchar(200) DEFAULT NULL,
  `receitas_status` enum('0','1') DEFAULT '0',
  `receitas_data_cadastro` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`receitas_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tab_receitas`
--

LOCK TABLES `tab_receitas` WRITE;
/*!40000 ALTER TABLE `tab_receitas` DISABLE KEYS */;
/*!40000 ALTER TABLE `tab_receitas` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tab_tipo_despesas`
--

DROP TABLE IF EXISTS `tab_tipo_despesas`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tab_tipo_despesas` (
  `tipo_despesa_id` int(11) NOT NULL AUTO_INCREMENT,
  `tipo_despesa_nome` varchar(45) NOT NULL,
  `tipo_despesa_ativado` enum('0','1') DEFAULT '1',
  `tipo_despesa_obs` varchar(200) DEFAULT NULL,
  `tipo_despesa_data_cadastro` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`tipo_despesa_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tab_tipo_despesas`
--

LOCK TABLES `tab_tipo_despesas` WRITE;
/*!40000 ALTER TABLE `tab_tipo_despesas` DISABLE KEYS */;
INSERT INTO `tab_tipo_despesas` VALUES (1,'LUZ','1','luz mes','2022-05-09 21:50:51');
/*!40000 ALTER TABLE `tab_tipo_despesas` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tab_tipo_receitas`
--

DROP TABLE IF EXISTS `tab_tipo_receitas`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tab_tipo_receitas` (
  `tiporeceita_id` int(11) NOT NULL AUTO_INCREMENT,
  `tiporeceita_nome` varchar(50) NOT NULL,
  PRIMARY KEY (`tiporeceita_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tab_tipo_receitas`
--

LOCK TABLES `tab_tipo_receitas` WRITE;
/*!40000 ALTER TABLE `tab_tipo_receitas` DISABLE KEYS */;
INSERT INTO `tab_tipo_receitas` VALUES (1,'');
/*!40000 ALTER TABLE `tab_tipo_receitas` ENABLE KEYS */;
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

-- Dump completed on 2022-05-13 16:50:01
