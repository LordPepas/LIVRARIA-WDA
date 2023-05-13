-- MySQL dump 10.13  Distrib 8.0.30, for Win64 (x86_64)
--
-- Host: localhost    Database: dblocadora
-- ------------------------------------------------------
-- Server version	8.0.31

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `acesso_admin`
--

DROP TABLE IF EXISTS `acesso_admin`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8 */;
CREATE TABLE `acesso_admin` (
  `Cod_admin` int NOT NULL AUTO_INCREMENT,
  `Nome_admin` varchar(50) NOT NULL,
  `Username_admin` varchar(50) NOT NULL,
  `Email` varchar(100) NOT NULL,
  `Senha` varchar(50) NOT NULL,
  PRIMARY KEY (`Cod_admin`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `acesso_admin`
--

LOCK TABLES `acesso_admin` WRITE;
/*!40000 ALTER TABLE `acesso_admin` DISABLE KEYS */;
INSERT INTO `acesso_admin` VALUES (1,'Caio César Henrique Cunha','Caio César','caio@wdatecnologia.com.br','0000');
/*!40000 ALTER TABLE `acesso_admin` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `aluguel`
--

DROP TABLE IF EXISTS `aluguel`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8 */;
CREATE TABLE `aluguel` (
  `Cod_aluguel` int NOT NULL AUTO_INCREMENT,
  `Livro` int NOT NULL,
  `Usuário` int NOT NULL,
  `Data_aluguel` date NOT NULL,
  `Data_previsão` date NOT NULL,
  `Quantidade_alugada` int NOT NULL,
  PRIMARY KEY (`Cod_aluguel`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `aluguel`
--

LOCK TABLES `aluguel` WRITE;
/*!40000 ALTER TABLE `aluguel` DISABLE KEYS */;
INSERT INTO `aluguel` VALUES (2,4,3,'2023-05-09','2023-05-10',1),(4,3,2,'2023-05-09','2023-05-25',1);
/*!40000 ALTER TABLE `aluguel` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `editora`
--

DROP TABLE IF EXISTS `editora`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8 */;
CREATE TABLE `editora` (
  `Cod_editora` int NOT NULL AUTO_INCREMENT,
  `Nome_editora` varchar(50) NOT NULL,
  `Cidade` varchar(35) NOT NULL,
  `Contato` varchar(50) NOT NULL,
  PRIMARY KEY (`Cod_editora`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `editora`
--

LOCK TABLES `editora` WRITE;
/*!40000 ALTER TABLE `editora` DISABLE KEYS */;
INSERT INTO `editora` VALUES (1,'Armada Press','unknown','(XX) XXXXX-XXXX'),(2,'Intrínseca','Rio de Janeiro ','(21) 2274-2643'),(3,'Gente','Caieiras','sac@editoragente.com.br'),(4,'Cengage Learning','Boston','(11) 3665-9900'),(5,'HarperCollins','Nova Iorque','(21) 3175-1030 ');
/*!40000 ALTER TABLE `editora` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `histórico`
--

DROP TABLE IF EXISTS `histórico`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8 */;
CREATE TABLE `histórico` (
  `Cod_hist` int NOT NULL AUTO_INCREMENT,
  `Livro` varchar(50) NOT NULL,
  `Usuário` varchar(50) NOT NULL,
  `Data_aluguel` date NOT NULL,
  `Data_previsão` date NOT NULL,
  `Data_devolução` date NOT NULL,
  `Quantidade` int NOT NULL,
  PRIMARY KEY (`Cod_hist`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `histórico`
--

LOCK TABLES `histórico` WRITE;
/*!40000 ALTER TABLE `histórico` DISABLE KEYS */;
INSERT INTO `histórico` VALUES (1,'1','1','2023-05-09','2023-05-10','2023-05-09',1),(2,'4','4','2023-05-11','2023-05-17','2023-05-09',1);
/*!40000 ALTER TABLE `histórico` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `livro`
--

DROP TABLE IF EXISTS `livro`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8 */;
CREATE TABLE `livro` (
  `Cod_livro` int NOT NULL AUTO_INCREMENT,
  `Nome_livro` varchar(50) NOT NULL,
  `Editora` varchar(50) NOT NULL,
  `Autor` varchar(50) NOT NULL,
  `Lançamento` year NOT NULL,
  `Quantidade` int NOT NULL,
  PRIMARY KEY (`Cod_livro`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `livro`
--

LOCK TABLES `livro` WRITE;
/*!40000 ALTER TABLE `livro` DISABLE KEYS */;
INSERT INTO `livro` VALUES (1,'Esquema Ponzi','1','Fabio Cres',2014,100),(2,'Steve Jobs','2','Walter Isaacson',2022,100),(3,'O poder da ação','3','Paulo Vieira',2015,99),(4,'Algoritmos E Lógica','4','Marco Souza',2019,99),(5,'Do Mil ao Milhãoo','5','Thiago Nigro',2018,100);
/*!40000 ALTER TABLE `livro` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `usuario`
--

DROP TABLE IF EXISTS `usuario`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8 */;
CREATE TABLE `usuario` (
  `Cod_usuario` int NOT NULL AUTO_INCREMENT,
  `Nome_usuario` varchar(50) NOT NULL,
  `Cidade` varchar(50) NOT NULL,
  `Endereço` varchar(100) NOT NULL,
  `Email` varchar(100) NOT NULL,
  PRIMARY KEY (`Cod_usuario`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `usuario`
--

LOCK TABLES `usuario` WRITE;
/*!40000 ALTER TABLE `usuario` DISABLE KEYS */;
INSERT INTO `usuario` VALUES (1,'Caio César','unknown','Rua A,001','caio@wdatecnologia.com.br'),(2,'Pedro dos Santos','Fortaleza','Rua A,001','pedro@wdatecnologia.com.br'),(3,'Sabrine Silva','Fortaleza ','Rua B,003','sabrine@wdatecnologia.com.br'),(4,'Antonio Jose','Fortaleza','Rua A,004','antonio@wdatecnologia.com.br'),(5,'Matheus Medeiros Braga','unknown','Rua A,005','matheus@wdatecnologia.com.br');
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

-- Dump completed on 2023-05-09 21:36:54
