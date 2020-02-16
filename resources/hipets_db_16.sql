-- MySQL dump 10.13  Distrib 5.7.29, for Linux (x86_64)
--
-- Host: 127.0.0.1    Database: hipets
-- ------------------------------------------------------
-- Server version	5.7.29-0ubuntu0.18.04.1

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
-- Table structure for table `actividad`
--

DROP TABLE IF EXISTS `actividad`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `actividad` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `nombre` varchar(15) NOT NULL,
  `descripcion` varchar(45) DEFAULT NULL,
  `fecha` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `lugar` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `actividad`
--

LOCK TABLES `actividad` WRITE;
/*!40000 ALTER TABLE `actividad` DISABLE KEYS */;
INSERT INTO `actividad` VALUES (1,'Salir a pasear','Paseo por el barrio','2020-02-15 16:00:00','Madrid'),(2,'Vacunación','Ven a vacunar a tu mascota','2020-02-15 11:00:00','Madrid'),(3,'Esterilización','Campaña de esterilización de gatos','2020-02-14 19:00:00','Alicante'),(4,'Ir al campo','Salir a disfrutar del aire','2020-02-15 09:00:00','Zaragoza');
/*!40000 ALTER TABLE `actividad` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `amigos`
--

DROP TABLE IF EXISTS `amigos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `amigos` (
  `usuario_id` int(10) unsigned NOT NULL,
  `usuario_id2` int(10) unsigned NOT NULL,
  PRIMARY KEY (`usuario_id`,`usuario_id2`),
  KEY `usuario_id2` (`usuario_id2`),
  CONSTRAINT `amigos_ibfk_1` FOREIGN KEY (`usuario_id`) REFERENCES `usuario` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `amigos_ibfk_2` FOREIGN KEY (`usuario_id2`) REFERENCES `usuario` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `amigos`
--

LOCK TABLES `amigos` WRITE;
/*!40000 ALTER TABLE `amigos` DISABLE KEYS */;
INSERT INTO `amigos` VALUES (2,1),(3,1),(3,2),(1,3),(2,3),(1,4);
/*!40000 ALTER TABLE `amigos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `anuncio`
--

DROP TABLE IF EXISTS `anuncio`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `anuncio` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `cliente_id` int(10) unsigned NOT NULL,
  `imagen` varchar(255) DEFAULT NULL,
  `fecha_alta` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `fecha_baja` date DEFAULT NULL,
  `url` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`,`cliente_id`),
  KEY `cliente_id` (`cliente_id`),
  CONSTRAINT `anuncio_ibfk_1` FOREIGN KEY (`cliente_id`) REFERENCES `cliente` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `anuncio`
--

LOCK TABLES `anuncio` WRITE;
/*!40000 ALTER TABLE `anuncio` DISABLE KEYS */;
INSERT INTO `anuncio` VALUES (1,2,'empresa.png','2020-02-15 20:09:28','2020-03-15','www.anuncio_1.com'),(2,2,'anuncio5.jpeg','2020-02-15 20:09:28','2020-07-23','www.anuncio_2.com'),(3,1,'anuncio2.jpeg','2020-02-15 20:09:28','2020-02-20','www.anuncio_3.com'),(4,1,'anuncio3.jpeg','2020-02-23 23:00:00','2020-02-28','http://www.google.es'),(5,1,'anuncio4.jpeg','2020-02-25 23:00:00','2020-03-06','http://www.google.es');
/*!40000 ALTER TABLE `anuncio` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cliente`
--

DROP TABLE IF EXISTS `cliente`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cliente` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `nombre` varchar(45) NOT NULL,
  `email` varchar(45) NOT NULL,
  `pass` varchar(100) NOT NULL,
  `foto` varchar(255) DEFAULT NULL,
  `localidad` varchar(45) DEFAULT NULL,
  `cp` int(10) unsigned DEFAULT NULL,
  `cif` varchar(20) NOT NULL,
  `telefono` int(10) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cliente`
--

LOCK TABLES `cliente` WRITE;
/*!40000 ALTER TABLE `cliente` DISABLE KEYS */;
INSERT INTO `cliente` VALUES (1,'Royal','cliente1@gmial.com','$2y$10$2JnNTcrWG.9S8Wp/xYgVeOxXMBY/MNx5eqNWqDrbezFS.VmAobXRS','Royal.png','Madrid',28045,'B847521695',915487458),(2,'Tiendanimal','cliente2@gmial.com','$2y$10$2JnNTcrWG.9S8Wp/xYgVeOxXMBY/MNx5eqNWqDrbezFS.VmAobXRS','empresa2.png','Barcelona',28045,'B85965254',925965147);
/*!40000 ALTER TABLE `cliente` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `comentario_actividad`
--

DROP TABLE IF EXISTS `comentario_actividad`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `comentario_actividad` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `usuario_id` int(10) unsigned NOT NULL,
  `actividad_id` int(10) unsigned NOT NULL,
  `texto` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `usuario_id` (`usuario_id`),
  KEY `actividad_id` (`actividad_id`),
  CONSTRAINT `comentario_actividad_ibfk_1` FOREIGN KEY (`usuario_id`) REFERENCES `usuario` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `comentario_actividad_ibfk_2` FOREIGN KEY (`actividad_id`) REFERENCES `actividad` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `comentario_actividad`
--

LOCK TABLES `comentario_actividad` WRITE;
/*!40000 ALTER TABLE `comentario_actividad` DISABLE KEYS */;
INSERT INTO `comentario_actividad` VALUES (1,1,1,'Muy grande!!'),(2,2,1,'Genial'),(3,1,2,'Que bonito...'),(4,3,3,'Estupendo!!'),(5,1,3,'Vamoss');
/*!40000 ALTER TABLE `comentario_actividad` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `comentario_publicacion`
--

DROP TABLE IF EXISTS `comentario_publicacion`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `comentario_publicacion` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `usuario_id` int(10) unsigned NOT NULL,
  `publicacion_id` int(10) unsigned NOT NULL,
  `texto` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `usuario_id` (`usuario_id`),
  KEY `publicacion_id` (`publicacion_id`),
  CONSTRAINT `comentario_publicacion_ibfk_1` FOREIGN KEY (`usuario_id`) REFERENCES `usuario` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `comentario_publicacion_ibfk_2` FOREIGN KEY (`publicacion_id`) REFERENCES `publicacion` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `comentario_publicacion`
--

LOCK TABLES `comentario_publicacion` WRITE;
/*!40000 ALTER TABLE `comentario_publicacion` DISABLE KEYS */;
INSERT INTO `comentario_publicacion` VALUES (3,1,1,'Allí estaremos'),(4,3,2,'Como???'),(5,1,2,'Increible'),(12,1,2,'Alucino'),(18,1,3,'Eso que es....??'),(19,1,3,'Muy bieeennn');
/*!40000 ALTER TABLE `comentario_publicacion` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `factura`
--

DROP TABLE IF EXISTS `factura`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `factura` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `cliente_id` int(10) unsigned NOT NULL,
  `importe` int(10) unsigned DEFAULT NULL,
  `iva` int(10) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`,`cliente_id`),
  KEY `cliente_id` (`cliente_id`),
  CONSTRAINT `factura_ibfk_1` FOREIGN KEY (`cliente_id`) REFERENCES `cliente` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `factura`
--

LOCK TABLES `factura` WRITE;
/*!40000 ALTER TABLE `factura` DISABLE KEYS */;
INSERT INTO `factura` VALUES (1,1,20,21),(1,2,40,21);
/*!40000 ALTER TABLE `factura` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `megusta`
--

DROP TABLE IF EXISTS `megusta`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `megusta` (
  `usuario_id` int(10) unsigned NOT NULL,
  `publicacion_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`usuario_id`,`publicacion_id`),
  KEY `publicacion_id` (`publicacion_id`),
  CONSTRAINT `megusta_ibfk_1` FOREIGN KEY (`usuario_id`) REFERENCES `usuario` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `megusta_ibfk_2` FOREIGN KEY (`publicacion_id`) REFERENCES `publicacion` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `megusta`
--

LOCK TABLES `megusta` WRITE;
/*!40000 ALTER TABLE `megusta` DISABLE KEYS */;
INSERT INTO `megusta` VALUES (1,1),(1,2),(2,2),(3,2),(4,3),(1,4),(2,4),(1,5);
/*!40000 ALTER TABLE `megusta` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `participa`
--

DROP TABLE IF EXISTS `participa`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `participa` (
  `usuario_id` int(10) unsigned NOT NULL,
  `actividad_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`usuario_id`,`actividad_id`),
  KEY `actividad_id` (`actividad_id`),
  CONSTRAINT `participa_ibfk_1` FOREIGN KEY (`usuario_id`) REFERENCES `usuario` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `participa_ibfk_2` FOREIGN KEY (`actividad_id`) REFERENCES `actividad` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `participa`
--

LOCK TABLES `participa` WRITE;
/*!40000 ALTER TABLE `participa` DISABLE KEYS */;
INSERT INTO `participa` VALUES (1,1),(2,1),(3,1),(1,2),(2,2),(1,3),(5,3),(4,4);
/*!40000 ALTER TABLE `participa` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `publicacion`
--

DROP TABLE IF EXISTS `publicacion`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `publicacion` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `usuario_id` int(10) unsigned NOT NULL,
  `imagen` varchar(255) DEFAULT NULL,
  `texto` varchar(255) DEFAULT NULL,
  `fecha` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`,`usuario_id`),
  KEY `usuario_id` (`usuario_id`),
  CONSTRAINT `publicacion_ibfk_1` FOREIGN KEY (`usuario_id`) REFERENCES `usuario` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `publicacion`
--

LOCK TABLES `publicacion` WRITE;
/*!40000 ALTER TABLE `publicacion` DISABLE KEYS */;
INSERT INTO `publicacion` VALUES (1,2,'jugando_cat.png','Jugando con mi gatito','2020-02-14 23:00:00'),(2,3,'campo.jpg','Paseito','2020-02-14 23:00:00'),(3,4,'jugando_cat.png','Como se lo pasa!!','2020-02-15 20:20:20'),(4,2,'vistas.jpeg','Esto es vida!!!','2020-02-15 20:40:22'),(5,1,'campo.jpg','Naturaleza ','2020-02-16 15:38:09');
/*!40000 ALTER TABLE `publicacion` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `usuario`
--

DROP TABLE IF EXISTS `usuario`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `usuario` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `email` varchar(45) NOT NULL,
  `pass` varchar(100) NOT NULL,
  `nombre` varchar(45) NOT NULL,
  `foto_perfil` varchar(255) DEFAULT NULL,
  `localidad` varchar(45) DEFAULT NULL,
  `cp` int(11) DEFAULT NULL,
  `telefono` int(11) DEFAULT NULL,
  `descripcion` varchar(255) DEFAULT NULL,
  `nombre_dueno` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `usuario`
--

LOCK TABLES `usuario` WRITE;
/*!40000 ALTER TABLE `usuario` DISABLE KEYS */;
INSERT INTO `usuario` VALUES (1,'bigotes@gmail.com','$2y$10$2JnNTcrWG.9S8Wp/xYgVeOxXMBY/MNx5eqNWqDrbezFS.VmAobXRS','Bigotes','gatito.png','Madrid',28026,666958459,'Cariñoso','Petunio'),(2,'zero@gmail.com','$2y$10$2JnNTcrWG.9S8Wp/xYgVeOxXMBY/MNx5eqNWqDrbezFS.VmAobXRS','Zero','gato2.png','Madrid',28026,666958459,':)','Patricio'),(3,'coqui@gmail.com','$2y$10$2JnNTcrWG.9S8Wp/xYgVeOxXMBY/MNx5eqNWqDrbezFS.VmAobXRS','Coqui','juego_bola.png','Madrid',28026,666958459,'Lo mejor del mundo','Paty'),(4,'mayra1@gmail.com','$2y$10$yZSRcyBt.6Wiyh4Kzf7aaO/xxDMTVcJh6ahJ22fQy80V2tMYP3adW','Calcetines','perrito.png','Madrid',28026,627025654,'Es un trasto','Mayra'),(5,'marbeucv@gmail.com','$2y$10$yZSRcyBt.6Wiyh4Kzf7aaO/xxDMTVcJh6ahJ22fQy80V2tMYP3adW','Zelda','perro4.png','Madrid',28045,627025654,'Ladrar y comer','Marbe');
/*!40000 ALTER TABLE `usuario` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `usuario_token`
--

DROP TABLE IF EXISTS `usuario_token`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `usuario_token` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `usuario_id` int(10) unsigned NOT NULL,
  `token` varchar(100) NOT NULL,
  `tipo` varchar(10) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_usuario_token_idx` (`usuario_id`),
  CONSTRAINT `fk_usuario_token` FOREIGN KEY (`usuario_id`) REFERENCES `usuario` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `usuario_token`
--

LOCK TABLES `usuario_token` WRITE;
/*!40000 ALTER TABLE `usuario_token` DISABLE KEYS */;
/*!40000 ALTER TABLE `usuario_token` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2020-02-16 23:23:40