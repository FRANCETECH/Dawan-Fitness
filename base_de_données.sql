-- MySQL dump 10.13  Distrib 8.0.31, for macos12.6 (arm64)
--
-- Host: localhost    Database: l_orange_bleue
-- ------------------------------------------------------
-- Server version	8.0.31

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `doctrine_migration_versions`
--

DROP TABLE IF EXISTS `doctrine_migration_versions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `doctrine_migration_versions` (
  `version` varchar(191) COLLATE utf8mb3_unicode_ci NOT NULL,
  `executed_at` datetime DEFAULT NULL,
  `execution_time` int DEFAULT NULL,
  PRIMARY KEY (`version`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `doctrine_migration_versions`
--

LOCK TABLES `doctrine_migration_versions` WRITE;
/*!40000 ALTER TABLE `doctrine_migration_versions` DISABLE KEYS */;
INSERT INTO `doctrine_migration_versions` VALUES ('DoctrineMigrations\\Version20220928082609','2022-09-28 08:27:41',127),('DoctrineMigrations\\Version20221007123121','2022-10-07 12:34:15',70),('DoctrineMigrations\\Version20221007123421','2022-10-07 12:34:42',236),('DoctrineMigrations\\Version20221007123706','2022-10-07 12:37:28',95);
/*!40000 ALTER TABLE `doctrine_migration_versions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `permissions`
--

DROP TABLE IF EXISTS `permissions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `permissions` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_active` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `permissions`
--

LOCK TABLES `permissions` WRITE;
/*!40000 ALTER TABLE `permissions` DISABLE KEYS */;
INSERT INTO `permissions` VALUES (1,'Vendre des boissons','Vous pouvez vendre des boissons sans limitation. Cependant, vous ne pouvez pas vendre de boissons alcoolisées au sein de votre établissement.',1),(2,'Faire un planning','Nous mettons à votre disposition, un outil rapide et ergonomique afin de faire vos plannings pour vos collaborateurs.',1),(3,'Envoi de sms à vos clients','Vous pouvez envoyer un sms à vos clients afin de communiquer des remises par exemple.',1),(5,'Com sur instagram','Nous créons votre compte et nous alimentons le contenu avec des photos que vous nous communiquez.',1);
/*!40000 ALTER TABLE `permissions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `permissions_structures`
--

DROP TABLE IF EXISTS `permissions_structures`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `permissions_structures` (
  `permissions_id` int NOT NULL,
  `structures_id` int NOT NULL,
  `is_active` tinyint(1) NOT NULL,
  PRIMARY KEY (`permissions_id`,`structures_id`),
  KEY `IDX_3050A8C89C3E4F87` (`permissions_id`),
  KEY `IDX_3050A8C89D3ED38D` (`structures_id`),
  CONSTRAINT `FK_3050A8C89C3E4F87` FOREIGN KEY (`permissions_id`) REFERENCES `permissions` (`id`),
  CONSTRAINT `FK_3050A8C89D3ED38D` FOREIGN KEY (`structures_id`) REFERENCES `structures` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `permissions_structures`
--

LOCK TABLES `permissions_structures` WRITE;
/*!40000 ALTER TABLE `permissions_structures` DISABLE KEYS */;
INSERT INTO `permissions_structures` VALUES (2,1,1),(2,2,1),(2,3,1),(3,5,0),(5,5,1);
/*!40000 ALTER TABLE `permissions_structures` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `permissions_users`
--

DROP TABLE IF EXISTS `permissions_users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `permissions_users` (
  `permissions_id` int NOT NULL,
  `users_id` int NOT NULL,
  `is_active` tinyint(1) NOT NULL,
  PRIMARY KEY (`permissions_id`,`users_id`),
  KEY `IDX_5F7CBD769C3E4F87` (`permissions_id`),
  KEY `IDX_5F7CBD7667B3B43D` (`users_id`),
  CONSTRAINT `FK_5F7CBD7667B3B43D` FOREIGN KEY (`users_id`) REFERENCES `users` (`id`),
  CONSTRAINT `FK_5F7CBD769C3E4F87` FOREIGN KEY (`permissions_id`) REFERENCES `permissions` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `permissions_users`
--

LOCK TABLES `permissions_users` WRITE;
/*!40000 ALTER TABLE `permissions_users` DISABLE KEYS */;
INSERT INTO `permissions_users` VALUES (1,2,1),(1,13,1),(2,3,1),(2,11,0),(2,13,1),(3,2,1),(3,6,1),(3,11,1),(3,14,1),(5,6,1),(5,11,1),(5,14,1),(5,33,1);
/*!40000 ALTER TABLE `permissions_users` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `structures`
--

DROP TABLE IF EXISTS `structures`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `structures` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `address` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone_number` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '(DC2Type:datetime_immutable)',
  `is_active` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `structures`
--

LOCK TABLES `structures` WRITE;
/*!40000 ALTER TABLE `structures` DISABLE KEYS */;
INSERT INTO `structures` VALUES (1,'DeDoàDo','435 rue des pirates, 32900 LAREN','0987665423','2022-09-30 12:19:43',1),(2,'Tout est possible','32 impasse de la taupe 29000 POMPE','0098165432','2022-10-04 09:21:26',1),(3,'Le poids du vent','456 boulevard Henri IV 76543 BASTON','0965387769','2022-10-05 07:52:18',1),(5,'BiSept','07 avenue du Docteur Jean Bru 11000 HOIX','0435223311','2022-10-12 21:04:28',0),(6,'Droit devant','6 rue Henri Dès, 44000 LURON','0834992311','2022-10-17 13:21:32',1);
/*!40000 ALTER TABLE `structures` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `structures_users`
--

DROP TABLE IF EXISTS `structures_users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `structures_users` (
  `structures_id` int NOT NULL,
  `users_id` int NOT NULL,
  PRIMARY KEY (`users_id`,`structures_id`),
  KEY `IDX_8F1FFDB79D3ED38D` (`structures_id`),
  KEY `IDX_8F1FFDB767B3B43D` (`users_id`),
  CONSTRAINT `FK_8F1FFDB767B3B43D` FOREIGN KEY (`users_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  CONSTRAINT `FK_8F1FFDB79D3ED38D` FOREIGN KEY (`structures_id`) REFERENCES `structures` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `structures_users`
--

LOCK TABLES `structures_users` WRITE;
/*!40000 ALTER TABLE `structures_users` DISABLE KEYS */;
INSERT INTO `structures_users` VALUES (1,3),(1,13),(2,3),(2,16),(2,31),(3,14),(3,31),(3,34),(5,6),(5,11);
/*!40000 ALTER TABLE `structures_users` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `users` (
  `id` int NOT NULL AUTO_INCREMENT,
  `email` varchar(180) COLLATE utf8mb4_unicode_ci NOT NULL,
  `roles` json NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone_number` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '(DC2Type:datetime_immutable)',
  `is_active` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_1483A5E9E7927C74` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=36 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (2,'fahodaj566@ploneix.com','[\"ROLE_ADMIN\"]','$2y$13$HpU//0GL.pmn4/n/fnbkCu3Cf6fnZwEEfy1YoRAmlI/kX1ZXTJpay','Fahodaj','0611567432','2022-09-29 14:31:00',0),(3,'admin@mail.com','[\"ROLE_ADMIN\"]','$2y$13$v.dVWiAbfEUsqNGThswtgubWFHeQPSYVj8N7OhSZYKlvNgYP07vXS','Administrateur','0167224511','2022-09-29 15:09:00',1),(6,'partenaire@mail.com','[\"ROLE_PARTNER\"]','$2y$13$Ut/Rrl.Fy7CNzcOBHudFpu73k128BYDx9pHCI3W/FrCqLL5YPxMuW','Partenaire','0897600983','2022-10-03 15:04:09',1),(8,'minus@derien.fr','[]','$2y$13$VSsV4CsvB9Pyf9eDBWhme.goV1uNwE6N2dGfsfSl56hdqUOrEgoAW','Zoé','0987654321','2022-10-04 09:22:45',1),(11,'manager@mail.com','[]','$2y$13$C2FdBA2rivT8nWS.7/LX9ONw.uyWU9B0Y4ToRg9MKHPRWYT2aY4fa','Manager','0912116654','2022-10-06 14:47:49',1),(12,'nouveauuser@kamel.com','[\"ROLE_PARTNER\"]','$2y$13$JVd8Y/UNbYNR1ukv1knF9.1W0Yo7QzA3E5h.Fo4ztQ/I8yY18PzdC','Mohamed','0983848999','2022-10-07 13:35:21',1),(13,'ne@de.fr','[\"ROLE_PARTNER\"]','$2y$13$aWbZF4qr268K7KhdWa085OYXStY8u50.o9BfGX9skVSsUFapy8/am','Amaël','0928382912','2022-10-07 13:40:00',1),(14,'sqsdfm@fsdf.Fr','[\"ROLE_ADMIN\"]','$2y$13$XJpQo0y7W9NhOsqtqNuawenzNUJYZ9bmP/5BHaS9s8bjXfiIb.jcS','Martin','0988765633','2022-10-07 14:04:39',1),(16,'bonjourbonjour@azert.fr','[]','$2y$13$oYesbEHRknZVJGyQN1PSXez9rb.ELG3CAEjfbAI.bxHevmHdY/fKC','Lucas','0983728787','2022-10-10 12:48:33',1),(18,'monPalette@montdor.cote','[]','$2y$13$rFmHBR3n1c2QZRg/yMBG3.RUhF4ZzkGUUjiVHAURtQ6i6ouGMohCS','Magalie','0877653421','2022-10-13 11:54:13',0),(19,'rififi@picsou.com','[\"ROLE_PARTNER\"]','$2y$13$EPvi3Fncn1M9A8Zdi5L/Ou8uehi3NnTXivw6Rp.tkb/x61qigDRse','Rififi','0988793844','2022-10-13 11:55:45',1),(20,'envoimail@mail.com','[]','$2y$13$TJedSwbP6p4vWOPT01PfeejyyQqGsCKJMGbWrtPz7c1mxsRGzB2Cy','Marie','0876543219','2022-10-13 15:13:46',1),(21,'envoimail@test.fr','[]','$2y$13$wz7MzmQjNiocXeSeAgSgv./6lmhvves9FpyOkJS13XcNX9ZxJcTUW','Paul','0876543219','2022-10-13 15:18:37',1),(22,'envoimail@test.com','[]','$2y$13$uvdTEpZfLJAhubn6RN2MNuWhllLS/Qbr4UGcZQFKhl20GJWzyCoQ2','Manon','0876543219','2022-10-14 07:36:08',0),(23,'envoimail@test.test','[]','$2y$13$YMrd77/noGEg4k0zYh5Ej.onfdnN26KDhxc/8W5x0G95a0NNjj/eO','Timothée','0876543219','2022-10-14 07:51:09',1),(24,'io@test.com','[]','$2y$13$guIzTAOirzpvSXwdGqlWqeawCOjlbcc1rTXzBPbGYCCYUFp9rqMQG','Harry','0876543219','2022-10-14 08:06:57',1),(25,'mamapata@null.com','[\"ROLE_PARTNER\"]','$2y$13$9y4Zdw9PrVPOO5jrrRYHieWIhtHMoLA0x8Gv111kEtqOV.gCtRLIy','Noé','0766445628','2022-10-14 09:05:44',1),(26,'mamapata@null.fr','[\"ROLE_PARTNER\"]','$2y$13$zYhKLoqRY3YBnnY47qgtlOjYT5jRzMn8KuvMwcn.0wDLDdiK1m97S','Mamapata','0766442311','2022-10-14 09:07:52',1),(27,'mamapata@com.fr','[\"ROLE_PARTNER\"]','$2y$13$AK/RJBuKmVWRJFCQYBB9lurl5727cloQgLj3l.D8geRQRMIn.XoB.','Nicolas','0766442311','2022-10-14 09:14:00',1),(28,'mamapata@com.com','[\"ROLE_PARTNER\"]','$2y$13$d6l/rSSLww4lcL9pfB0QQ.VxxWSn0FEYyXmKDPfgZ60ajnkCcDQQy','Lison','0766442311','2022-10-14 09:14:58',0),(29,'mamapata@de.de','[\"ROLE_PARTNER\"]','$2y$13$ksoSFlYDc9qrRmsDtXfob.AdE7ZJrRDppDhvzbmGvEMAGfgTEd8Ey','Rachid','0766442311','2022-10-14 09:27:19',1),(30,'mamapata@de.fr','[\"ROLE_PARTNER\"]','$2y$13$2j2wjFZ8Gswj8PJnQFkVzOwV6XKawRMn23QbhzyWtAcF6DgK5Mk6.','Joël','0766442311','2022-10-14 12:05:21',1),(31,'oucou@de.fr','[\"ROLE_PARTNER\"]','$2y$13$0Tpm4QAcjEvtBeRvRcS5sOYKr308JsQe2.nPEDEJGED5r203Cqu/q','Claude','0544362777','2022-10-14 12:42:43',1),(32,'manager@orangebleue.fr','[]','$2y$13$h.JFD.WBTaC3/9xAwlb8Ve9SJy52lhwrxFKKpZ7/fhzdEqAGf6Re.','Louison','0988765733','2022-10-14 12:44:52',1),(33,'admin002@lorangebleue.fr','[\"ROLE_ADMIN\"]','$2y$13$yMo.YOSZfU20cU7Cy6f.4OECPt8.DstPyW8PgX6zsgYe3/5FZuY4u','Roland','0234119928','2022-10-14 12:47:11',1),(34,'Coco@perroquet.fr','[]','$2y$13$lTMhRkP7zLpKqrrneMX2o.y8uiLyh3L3ZlncULmiEPUtGo4V0tUj6','Coralie','0766231190','2022-10-14 12:59:28',1),(35,'sanstructure@sans.com','[]','$2y$13$79EKLvmnzVl6WQVhSAnar.i9s1lnb8Cr1s80gJnXdmjSBjt2ABDy2','Nathanaël','0213241988','2022-10-14 13:02:53',1);
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2022-10-31 10:22:32
