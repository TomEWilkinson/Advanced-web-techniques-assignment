-- MySQL dump 10.13  Distrib 5.7.12, for osx10.9 (x86_64)
--
-- Host: mudfoot.doc.stu.mmu.ac.uk    Database: wilkinst
-- ------------------------------------------------------
-- Server version	5.6.23-log

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
-- Table structure for table `class_record`
--

DROP TABLE IF EXISTS `class_record`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `class_record` (
  `student_id` int(11) NOT NULL,
  `session_id` int(11) NOT NULL,
  `attendance` int(11) DEFAULT '0',
  `date` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`student_id`,`session_id`,`date`),
  KEY `lesson_id_idx` (`session_id`),
  CONSTRAINT `lesson_id` FOREIGN KEY (`session_id`) REFERENCES `sessions` (`session_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `user_id` FOREIGN KEY (`student_id`) REFERENCES `users` (`user_id`) ON DELETE NO ACTION ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `class_record`
--

LOCK TABLES `class_record` WRITE;
/*!40000 ALTER TABLE `class_record` DISABLE KEYS */;
INSERT INTO `class_record` VALUES (123,1,1,'2017-05-09 14:00:00'),(123,2,1,'2017-05-08 15:00:00'),(123,4,0,'2017-05-09 10:00:00'),(123,5,1,'2017-05-11 10:00:00'),(123,6,1,'2017-05-09 15:00:00'),(123,12,1,'2017-05-09 14:00:00'),(123,13,1,'2017-05-08 15:00:00'),(123,14,0,'2017-05-08 11:00:00'),(123,15,1,'2017-05-09 10:00:00'),(123,16,1,'2017-05-11 10:00:00'),(124,1,1,'2017-05-09 14:00:00'),(124,3,1,'0000-00-00 00:00:00'),(124,4,1,'0000-00-00 00:00:00'),(124,7,1,'0000-00-00 00:00:00'),(124,12,0,'2017-05-09 14:00:00'),(124,14,1,'0000-00-00 00:00:00'),(124,18,0,'0000-00-00 00:00:00'),(125,1,1,'0000-00-00 00:00:00'),(125,3,1,'0000-00-00 00:00:00'),(125,7,1,'0000-00-00 00:00:00'),(125,8,1,'0000-00-00 00:00:00'),(125,9,1,'0000-00-00 00:00:00'),(125,10,1,'0000-00-00 00:00:00'),(125,14,0,'0000-00-00 00:00:00'),(125,18,1,'0000-00-00 00:00:00'),(125,19,1,'0000-00-00 00:00:00'),(125,20,0,'0000-00-00 00:00:00'),(125,21,1,'0000-00-00 00:00:00');
/*!40000 ALTER TABLE `class_record` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `lessons`
--

DROP TABLE IF EXISTS `lessons`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `lessons` (
  `lesson_name` varchar(45) NOT NULL,
  `lesson_location_lat` varchar(100) DEFAULT NULL,
  `lesson_location_lon` varchar(100) DEFAULT NULL,
  `lesson_Building` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`lesson_name`),
  UNIQUE KEY `lesson_name_UNIQUE` (`lesson_name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `lessons`
--

LOCK TABLES `lessons` WRITE;
/*!40000 ALTER TABLE `lessons` DISABLE KEYS */;
INSERT INTO `lessons` VALUES ('Baking','53.4704855','-2.2364179','Univesity Language Center'),('Ethics','53.4708791','-2.2519316','Manchester Law School'),('Meta Physics','53.4717481','-2.2421201','John Dalton'),('Moral Theory','53.4692229','-2.2381369','Geoffrey Manton'),('Socrates Appointment','53.4717481','-2.2521301','John Dalton');
/*!40000 ALTER TABLE `lessons` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `marks`
--

DROP TABLE IF EXISTS `marks`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `marks` (
  `lesson_name` varchar(50) NOT NULL,
  `student_id` int(11) NOT NULL,
  `mark` int(11) DEFAULT NULL,
  PRIMARY KEY (`lesson_name`,`student_id`),
  KEY `Student_id_idx` (`student_id`),
  KEY `lesson_name_idx` (`lesson_name`),
  KEY `name_lesson_idx` (`lesson_name`),
  CONSTRAINT `Student_id` FOREIGN KEY (`student_id`) REFERENCES `users` (`user_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `name_lesson` FOREIGN KEY (`lesson_name`) REFERENCES `lessons` (`lesson_name`) ON DELETE NO ACTION ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `marks`
--

LOCK TABLES `marks` WRITE;
/*!40000 ALTER TABLE `marks` DISABLE KEYS */;
INSERT INTO `marks` VALUES ('Baking',123,50),('Baking',124,60),('Baking',125,30),('Ethics',123,64),('Ethics',124,90),('Ethics',125,80),('Meta Physics',123,20),('Moral Theory',123,83);
/*!40000 ALTER TABLE `marks` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sessions`
--

DROP TABLE IF EXISTS `sessions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sessions` (
  `session_id` int(11) NOT NULL AUTO_INCREMENT,
  `lesson_name` varchar(45) DEFAULT NULL,
  `staff_id` int(20) DEFAULT NULL,
  `staff_first_name` varchar(45) DEFAULT NULL,
  `staff_second_name` varchar(45) DEFAULT NULL,
  `start_time` datetime DEFAULT NULL,
  `free_spaces` int(11) DEFAULT NULL,
  `room_number` varchar(45) DEFAULT 'unknown',
  PRIMARY KEY (`session_id`),
  KEY `lesson_name_idx` (`lesson_name`),
  CONSTRAINT `lesson_name` FOREIGN KEY (`lesson_name`) REFERENCES `lessons` (`lesson_name`) ON DELETE NO ACTION ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=30 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sessions`
--

LOCK TABLES `sessions` WRITE;
/*!40000 ALTER TABLE `sessions` DISABLE KEYS */;
INSERT INTO `sessions` VALUES (1,'Meta Physics',126,'Socrates',NULL,'2017-05-09 14:00:00',0,'1.02'),(2,'Moral Theory',126,'Socrates',NULL,'2017-05-08 15:00:00',2,'1.03'),(3,'Ethics',126,'Socrates',NULL,'2017-05-08 11:00:00',1,'1.04'),(4,'Baking',126,'Scorates',NULL,'2017-05-09 10:00:00',1,'1.05'),(5,'Socrates Appointment',126,'Socrates',NULL,'2017-05-11 10:00:00',0,'1.06'),(6,'Ethics',126,'Scorates',NULL,'2017-05-09 15:00:00',2,'1.07'),(7,'Moral Theory',126,'Scorates',NULL,'2017-05-10 13:00:00',1,'1.08'),(8,'Ethics',126,'Socrates',NULL,'2017-05-12 09:00:00',2,'1.09'),(9,'Baking',126,'Socrates',NULL,'2017-05-12 12:00:00',2,'1.10'),(10,'Moral Theory',126,'Socrates',NULL,'2017-05-12 15:00:00',2,'1.11'),(11,'Socrates Appointment',126,'Socrates',NULL,'2017-05-11 14:00:00',1,'1.12'),(12,'Meta Physics',126,'Socrates',NULL,'2017-05-16 14:00:00',1,'1.13'),(13,'Moral Theory',126,'Socrates',NULL,'2017-05-15 15:00:00',2,'1.14'),(14,'Ethics',126,'Socrates',NULL,'2017-05-15 11:00:00',0,'1.01'),(15,'Baking',126,'Scorates',NULL,'2017-05-16 10:00:00',2,'1.02'),(16,'Socrates Appointment',126,'Socrates',NULL,'2017-05-18 10:00:00',0,'1.03'),(17,'Ethics',126,'Scorates',NULL,'2017-05-16 15:00:00',3,'1.04'),(18,'Moral Theory',126,'Scorates',NULL,'2017-05-17 13:00:00',1,'1.05'),(19,'Ethics',126,'Socrates',NULL,'2017-05-19 09:00:00',2,'1.06'),(20,'Baking',126,'Socrates',NULL,'2017-05-19 12:00:00',2,'1.07'),(21,'Moral Theory',126,'Socrates',NULL,'2017-05-19 15:00:00',1,'1.08'),(22,'Socrates Appointment',126,'Socrates',NULL,'2017-05-18 14:00:00',1,'1.09'),(27,'Baking',126,'Scorates',NULL,'2017-05-08 09:00:00',3,'1.10');
/*!40000 ALTER TABLE `sessions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users` (
  `user_id` int(11) NOT NULL AUTO_INCREMENT,
  `first_name` varchar(45) DEFAULT NULL,
  `second_name` varchar(45) DEFAULT NULL,
  `email` varchar(45) DEFAULT NULL,
  `password` varchar(45) DEFAULT NULL,
  `is_staff` int(1) DEFAULT NULL,
  `phone` varchar(11) DEFAULT NULL,
  `student_image` varchar(1000) DEFAULT NULL,
  PRIMARY KEY (`user_id`),
  UNIQUE KEY `email_UNIQUE` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=127 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (123,'bobby','smithy','test@test.com','test123',0,'12341231234','http://vignette1.wikia.nocookie.net/sanicsource/images/9/97/Doge.jpg/revision/latest/scale-to-width-down/185?cb=20160112233015'),(124,'jane','doe','student124@test.com','student124',0,'01612231539','https://cdn.thinglink.me/api/image/727110550026190849/1240/10/scaletowidth'),(125,'will','griggs','student125@test.com','student123',0,'01612231539','http://i1.kym-cdn.com/photos/images/newsfeed/000/581/296/c09.jpg'),(126,'Socrates',' ','staff@staff.com','staff123',1,'12094307802',NULL);
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

-- Dump completed on 2016-12-15 20:08:00
