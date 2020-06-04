-- MySQL dump 10.13  Distrib 8.0.18, for Linux (x86_64)
--
-- Host: localhost    Database: itm_jobs
-- ------------------------------------------------------
-- Server version	8.0.18

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
-- Table structure for table `applications`
--

DROP TABLE IF EXISTS `applications`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `applications` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `is_company` int(1) DEFAULT '0',
  `contact` varchar(255) NOT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `institution` varchar(255) DEFAULT NULL,
  `proof` varchar(255) DEFAULT NULL,
  `status` int(1) DEFAULT '0',
  `program` int(10) NOT NULL,
  `date_created` bigint(20) DEFAULT NULL,
  `last_updated` bigint(20) DEFAULT NULL,
  `gender` varchar(255) DEFAULT NULL,
  `number_of_applicants` int(50) DEFAULT '1',
  `password` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `applications`
--

LOCK TABLES `applications` WRITE;
/*!40000 ALTER TABLE `applications` DISABLE KEYS */;
INSERT INTO `applications` VALUES (1,'Kampangala Landry',0,'landry.kapela@neelansoft.co.tz','+255784086726',NULL,'1587363045_Invoice EliteBook - ITM.pdf',0,3,1587363045,1587363045,NULL,1,'$2y$10$DVhm0UXHMVSFBJxJjjAOHuc2e43mJqp8Fbvjty/Hqpy2zr2PgwHX2'),(2,'Neelansoft Technologies',1,'info@neelansoft.co.tz','07840867041','Neelansoft Technologies','1587373595_Invoice Web Project -ITM.pdf',0,3,1587373595,1587373595,NULL,5,'$2y$10$JvjyqkYJIS9NlLx.lPZ0HOJAwJX7Ih0oHwYC6lwRFbW4AZsrU4VFW'),(3,'Melanie Adanna',0,'landrykapela@gmail.com','0752867041',NULL,'1587374779_Invoice EliteBook - ITM.pdf',0,3,1587374779,1587374779,NULL,1,'$2y$10$tFVaWcCIfFoYxnq5wvy./u59KWbjFqaU1iBRRTAoDqkBRkQ91RI.e'),(4,'Tristan Landry',0,'tristankapela@gmail.com','0686868058',NULL,'1587375212_Screenshot from 2020-03-02 09-06-50.png',0,3,1587375212,1587375212,NULL,1,'$2y$10$wJs5S1o3bRvgowNob57TSOfjsvNchCl5galYi16Q7k9aS/I6Ke6iK'),(5,'Open Classrooms Internationl',1,'ney.landry@gmail.com','+255686012564','Open Classrooms Internationl','_1587393822.png',0,3,1587393949,1587393949,NULL,5,'$2y$10$4sX3nk4alKnBL2EGVue/1Ox7sBpxXbl.yirKiCpQJ1Q0OaN9NGi1q'),(6,'Neema Landry',0,'ney.landry@gmail.com','0686012564',NULL,'_1587399872.png',0,1,1587399872,1587399872,NULL,1,'$2y$10$vxCHEAeBv5ZlL4ggQT3kqekZNTt.X.M90yDkrYxIvgt8dwpOfVCJC');
/*!40000 ALTER TABLE `applications` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `career`
--

DROP TABLE IF EXISTS `career`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `career` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `career`
--

LOCK TABLES `career` WRITE;
/*!40000 ALTER TABLE `career` DISABLE KEYS */;
INSERT INTO `career` VALUES (1,'Information Technology'),(2,'Accounting'),(3,'Software Engineering'),(4,'Data Analysis'),(5,'Broadcasting and Media'),(6,'Business Management'),(7,'Mechanical Engineering'),(8,'Law'),(9,'Agribusiness'),(10,'Medicine'),(11,'Pharmacieuticals'),(12,'Human Resources'),(13,'Chemical Engineering'),(14,'Pedagogy'),(15,'Geological Sciences'),(16,'Science'),(17,'Arts and Linguistics'),(18,'Economics');
/*!40000 ALTER TABLE `career` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `education`
--

DROP TABLE IF EXISTS `education`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `education` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `level` varchar(255) DEFAULT NULL,
  `title` varchar(255) NOT NULL,
  `institution` varchar(255) NOT NULL,
  `country` varchar(255) DEFAULT 'Tanzania',
  `year` int(4) DEFAULT '2020',
  `user` int(10) DEFAULT NULL,
  `email` varchar(255) NOT NULL,
  `major` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `education`
--

LOCK TABLES `education` WRITE;
/*!40000 ALTER TABLE `education` DISABLE KEYS */;
INSERT INTO `education` VALUES (4,'Master','Msc. IT and Managment','Institute of Finance Management','TZ',2014,2,'support@neelansoft.co.tz','Information Technology'),(5,'Bachelor','BSc. Information and Communication Technology Management','Mzumbe University','TZ',2014,2,'support@neelansoft.co.tz','Information Technology'),(6,'Bachelor','Accounting and Finance','Institute of Finance Management','TZ',2019,24,'michael.mwangoka@itmafrica.com','Accounting'),(7,'Master','Business Management','Mzumbe University','GB',2020,24,'michael.mwangoka@itmafrica.com','Business Management'),(8,'Certificate','Broadcasting','Dar es Salaam Institute of Journalism','TZ',2007,10,'ney.landry@gmail.com','Broadcasting and Media'),(9,'Master','Msc IT and Managment','Institute of Finance Management','TZ',2014,25,'info@neelansoft.co.tz','Information Technology'),(11,'Certificate','Junior Web Developer','Open Classrooms Internationl','FR',2018,25,'info@neelansoft.co.tz','Software Engineering'),(12,'Bachelor','BSc. Information and Communication Technology Management','Mzumbe University','TZ',2009,25,'info@neelansoft.co.tz','Information Technology'),(13,'Certificate','ACSEE PCM','Lutheran Junior Seminary','TZ',2005,25,'info@neelansoft.co.tz','Science');
/*!40000 ALTER TABLE `education` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `events`
--

DROP TABLE IF EXISTS `events`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `events` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `content` text NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `caption` varchar(255) DEFAULT NULL,
  `status` int(1) DEFAULT '0',
  `date_created` bigint(20) DEFAULT NULL,
  `event_date` bigint(20) DEFAULT NULL,
  `last_updated` bigint(20) DEFAULT NULL,
  `location` varchar(255) DEFAULT NULL,
  `link` varchar(255) DEFAULT NULL,
  `link_text` varchar(255) DEFAULT 'View Details',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `events`
--

LOCK TABLES `events` WRITE;
/*!40000 ALTER TABLE `events` DISABLE KEYS */;
INSERT INTO `events` VALUES (1,'ITM Annual Review','There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form, by injected humour, or randomised words which don&#39;t look even slightly believable. If you are going to use a passage of Lorem Ipsum, you need to be sure there isn&#39;t anything embarrassing hidden in the middle of text. All the Lorem Ipsum generators on the Internet tend to repeat predefined chunks as necessary, making this the first true generator on the Internet. It uses a dictionary of over 200 Latin words, combined with a handful of model sentence structures, to generate Lorem Ipsum which looks reasonable. The generated Lorem Ipsum is therefore always free from repetition, injected humour, or non-characteristic words etc.','1587219695_home-bg.jpg','2019 Annual Review',1,1587205098,1577829600,1587222335,NULL,NULL,'View Details'),(2,'Super Special Event','Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical Latin literature from 45 BC, making it over 2000 years old. Richard McClintock, a Latin professor at Hampden-Sydney College in Virginia, looked up one of the more obscure Latin words, consectetur, from a Lorem Ipsum passage, and going through the cites of the word in classical literature, discovered the undoubtable source. Lorem Ipsum comes from sections 1.10.32 and 1.10.33 of &#34;de Finibus Bonorum et Malorum&#34; (The Extremes of Good and Evil) by Cicero, written in 45 BC. This book is a treatise on the theory of ethics, very popular during the Renaissance. The first line of Lorem Ipsum, &#34;Lorem ipsum dolor sit amet..&#34;, comes from a line in section 1.10.32.\r\nLorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry&#39;s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.\r\nIt is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using &#39;Content here, content here&#39;, making it look like readable English. Many desktop publishing packages and web page editors now use Lorem Ipsum as their default model text, and a search for &#39;lorem ipsum&#39; will uncover many web sites still in their infancy. Various versions have evolved over the years, sometimes by accident, sometimes on purpose (injected humour and the like).','1587218692_event.jpg','Annual Beach Party',0,1587214663,1577829600,1587226534,'Dar es Salaam','https://neelansoft.co.tz','Visit Site'),(3,'Introduction to Mind Chemistry Training','Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical Latin literature from 45 BC, making it over 2000 years old. Richard McClintock, a Latin professor at Hampden-Sydney College in Virginia, looked up one of the more obscure Latin words, consectetur, from a Lorem Ipsum passage, and going through the cites of the word in classical literature, discovered the undoubtable source. Lorem Ipsum comes from sections 1.10.32 and 1.10.33 of &#34;de Finibus Bonorum et Malorum&#34; (The Extremes of Good and Evil) by Cicero, written in 45 BC. This book is a treatise on the theory of ethics, very popular during the Renaissance. The first line of Lorem Ipsum, &#34;Lorem ipsum dolor sit amet..&#34;, comes from a line in section 1.10.32.\r\n\r\nThe standard chunk of Lorem Ipsum used since the 1500s is reproduced below for those interested. Sections 1.10.32 and 1.10.33 from &#34;de Finibus Bonorum et Malorum&#34; by Cicero are also reproduced in their exact original form, accompanied by English versions from the 1914 translation by H. Rackham.','1587334571_team-image.jpg','An Introductory Course',0,1587334388,1588543200,1587334571,'Arusha','https://neelansoft.co.tz','Register Now');
/*!40000 ALTER TABLE `events` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `jobs`
--

DROP TABLE IF EXISTS `jobs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `jobs` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `position` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL,
  `company` varchar(255) DEFAULT 'Anonymous',
  `contact` varchar(255) DEFAULT NULL,
  `date_created` bigint(20) DEFAULT NULL,
  `last_updated` bigint(20) DEFAULT NULL,
  `deadline` bigint(20) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `jobs`
--

LOCK TABLES `jobs` WRITE;
/*!40000 ALTER TABLE `jobs` DISABLE KEYS */;
INSERT INTO `jobs` VALUES (2,'Project Manager','Manage clients and in house project while maintaining deadlines and budgets. Preparing and presenting reports on project progress, interacting with clients','Neelansoft Technologies','landrykapela@neelansoft.co.tz',1587046710,1587118626,1593468000),(3,'Marketing Manager','blalj ldla jdlaj flakj lkdajl kla. ahdkjahdka hl l..af','ITM Tanzania','karen.mark@itmafrica.com',1587125570,1587125570,1592258400);
/*!40000 ALTER TABLE `jobs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `mailing_list`
--

DROP TABLE IF EXISTS `mailing_list`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `mailing_list` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `email` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `status` int(1) DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `mailing_list`
--

LOCK TABLES `mailing_list` WRITE;
/*!40000 ALTER TABLE `mailing_list` DISABLE KEYS */;
INSERT INTO `mailing_list` VALUES (4,'ney.landry@gmail.com','Neema Landry',0),(5,'landrykapela@gmail.com','Melanie Adanna',0),(6,'kampangala2014@gmail.com','Maureen Kapela',0),(7,'michael.mwangoka@itmafrica.com','Michael Mwangoka',0),(8,'info@neelansoft.co.tz','Landry Kapela',0),(9,'landrykapela@neelansoft.co.tz','Kampangala Landry',0);
/*!40000 ALTER TABLE `mailing_list` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `reference`
--

DROP TABLE IF EXISTS `reference`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `reference` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `contact` varchar(255) NOT NULL,
  `title` varchar(255) DEFAULT NULL,
  `email` varchar(255) NOT NULL,
  `user` int(10) DEFAULT NULL,
  `phone` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `reference`
--

LOCK TABLES `reference` WRITE;
/*!40000 ALTER TABLE `reference` DISABLE KEYS */;
INSERT INTO `reference` VALUES (1,'Mark Zuckerberg','mark.zuckerberg@facebook.com','Facebook Inc.','landrykapela@gmail.com',NULL,NULL),(2,'Noella Kajeneri','noella.kajeneri@itmafrica.com','Country Manager - ITM Tanzania','michael.mwangoka@itmafrica.com',NULL,NULL),(3,'Kampangala Landry','kampangala2014@gmail.com','ABC Co. Limited','info@neelansoft.co.tz',NULL,'+255784086726'),(4,'Noella Kajeneri','noella.kajeneri@itmafrica.com','Country Manager - ITM Tanzania','info@neelansoft.co.tz',NULL,'07840867041'),(5,'James Mayunga','james.mayunga@gmail.com','Senior Android Developer - Google','info@neelansoft.co.tz',NULL,'+14452541254');
/*!40000 ALTER TABLE `reference` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `training`
--

DROP TABLE IF EXISTS `training`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `training` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) DEFAULT NULL,
  `description` text,
  `start_date` bigint(20) DEFAULT NULL,
  `end_date` bigint(20) DEFAULT NULL,
  `target` int(10) DEFAULT NULL,
  `instructor` varchar(255) DEFAULT NULL,
  `registered` int(10) DEFAULT '0',
  `last_updated` bigint(20) DEFAULT NULL,
  `contact` varchar(255) DEFAULT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `location` varchar(255) DEFAULT NULL,
  `status` int(1) DEFAULT '0',
  `image` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `training`
--

LOCK TABLES `training` WRITE;
/*!40000 ALTER TABLE `training` DISABLE KEYS */;
INSERT INTO `training` VALUES (1,'Basic Computer for Teachers','Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry&#39;s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum',1587938400,1588284000,200,'Landry Kapela',1,1587252701,'landrykapela@neelansoft.co.tz',NULL,'Dar es Salaam',0,NULL),(2,'Fullstack Web Development With ReactJS and Nodejs','It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using &#39;Content here, content here&#39;, making it look like readable English. Many desktop publishing packages and web page editors now use Lorem Ipsum as their default model text, and a search for &#39;lorem ipsum&#39; will uncover many web sites still in their infancy. Various versions have evolved over the years, sometimes by accident, sometimes on purpose (injected humour and the like).',1588197600,1596146400,100,'Landry Kapela',0,1587335884,'landrykapela@neelansoft.co.tz','+255784086726','Arusha',0,'1587335884_event2.jpg'),(3,'Introduction to Mind Chemistry','Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical Latin literature from 45 BC, making it over 2000 years old. Richard McClintock, a Latin professor at Hampden-Sydney College in Virginia, looked up one of the more obscure Latin words, consectetur, from a Lorem Ipsum passage, and going through the cites of the word in classical literature, discovered the undoubtable source. Lorem Ipsum comes from sections 1.10.32 and 1.10.33 of &#34;de Finibus Bonorum et Malorum&#34; (The Extremes of Good and Evil) by Cicero, written in 45 BC. This book is a treatise on the theory of ethics, very popular during the Renaissance. The first line of Lorem Ipsum, &#34;Lorem ipsum dolor sit amet..&#34;, comes from a line in section 1.10.32.\r\n\r\nThe standard chunk of Lorem Ipsum used since the 1500s is reproduced below for those interested. Sections 1.10.32 and 1.10.33 from &#34;de Finibus Bonorum et Malorum&#34; by Cicero are also reproduced in their exact original form, accompanied by English versions from the 1914 translation by H. Rackham.',1588456800,1598824800,200,'Landry Kapela',10,1587308286,'landrykapela@neelansoft.co.tz','07840867041','Arusha',0,'1587308286_team-image.jpg');
/*!40000 ALTER TABLE `training` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user`
--

DROP TABLE IF EXISTS `user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `user` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `date_created` bigint(20) DEFAULT NULL,
  `last_login` bigint(20) DEFAULT NULL,
  `profile` varchar(255) DEFAULT '10,0,0,0',
  `location` varchar(255) DEFAULT NULL,
  `date_of_birth` bigint(20) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=26 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user`
--

LOCK TABLES `user` WRITE;
/*!40000 ALTER TABLE `user` DISABLE KEYS */;
INSERT INTO `user` VALUES (1,'System Administrator','landrykapela@neelansoft.co.tz','$2y$10$FULVvVF15ZwvMlNP5lyBiO0n1E5/u/wt53AssldkLqF3bq0wWT1d.','0784086726',1586150833,1587397270,'40,40',NULL,NULL),(2,'Kampangala Landry','support@neelansoft.co.tz','$2y$10$iSeDaN4VdrbFD35yFdU3ROMzOzzgQ6cjFrHBpgH4C26q9ePXq0QK6','0686868058',NULL,1587112192,'10,40,40,0',NULL,NULL),(10,'Neema Landry','ney.landry@gmail.com','$2y$10$IZ6tbgEGwXhR4LXbXgGEz.iqHvVklPp8Tq6JfBx3psZcmGNYirdYW','0686012564',NULL,1587388595,'10,40,40,0',NULL,NULL),(12,'Melanie Adanna','landrykapela@gmail.com','$2y$10$ThVqf3U3VHzfyarmv1Hp7ep4GSPrnkCq0D3CdZMj7WsANl5Vm9MDq','0686868058',NULL,1587147957,'10,0,0,40',NULL,NULL),(14,'Maureen Kapela','kampangala2014@gmail.com','$2y$10$9Wj8gfvxbOvzfkYg6nSFJuLMeCmbI9gYbnaO1f6l3ZTu3y9ftDJQC','0744777663',NULL,NULL,'10,0,0,0',NULL,NULL),(20,'Tristan Landry','tristankapela@gmail.com','$2y$10$KqNEoe9z1hBqAEw63ApWFeBYlePE.E6vv02Uni8lHzCcCT5RDF0xO','0752867041',NULL,1587037918,'10,0,0,0',NULL,NULL),(22,'Landry Kapela','neelansofttech@gmail.com','$2y$10$rHd87GoQ48u49mvX7DZNiurDnrL4MVHGSQAqzecfdB8bLj3MkZ9R.','0784086726',NULL,NULL,'10,0,0,0',NULL,NULL),(24,'Michael Mwangoka','michael.mwangoka@itmafrica.com','$2y$10$DF5xuAgidNvH1AR7/i/sCOWcnWWvwpi4cYcP0oEHqPb8zGpFtj60.','0743472714',NULL,1586348398,'10,40,40,40',NULL,NULL),(25,'Landry Kapela','info@neelansoft.co.tz','$2y$10$8IFQrjPS.GVQQcBSEJyQoOSZmbI9weVcofPkYz9n71mskJlqw.Zt2','0784086726',NULL,1587332583,'10,40,40,40','Morogoro',539906400);
/*!40000 ALTER TABLE `user` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `work`
--

DROP TABLE IF EXISTS `work`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `work` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `institution` varchar(255) DEFAULT NULL,
  `tasks` text,
  `country` varchar(2) DEFAULT 'TZ',
  `year_start` int(4) DEFAULT NULL,
  `year_end` int(4) DEFAULT NULL,
  `month_start` int(2) DEFAULT NULL,
  `month_end` int(2) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `user` int(10) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `work`
--

LOCK TABLES `work` WRITE;
/*!40000 ALTER TABLE `work` DISABLE KEYS */;
INSERT INTO `work` VALUES (1,'Mentor','Open Classrooms Internationl','Mentoring students who take the Junior Web Developer Path and Android developer path.\r\nAssessing students projects','FR',2019,-1,3,4,'support@neelansoft.co.tz',NULL),(2,'Software Developer','Neelansoft Technologies','Develop Web and mobile app (Android).\r\nMaintain and manage upgrades to existing apps.\r\nIntegrate third party APIs such as Mobile Money Payment gateways.\r\nListen to clients and reporting back project progress','TZ',2016,2020,1,4,'support@neelansoft.co.tz',NULL),(3,'Project Manager','ITM Tanzania','Managing Projects\r\nDefining projects guidelines\r\nMaintaining project scope and budget and time lines, etc','TZ',2019,2020,5,4,'michael.mwangoka@itmafrica.com',NULL),(4,'Reporter and Presenter','Sahara Media Group Ltd','Reporting and presenting sports news and programs for both TV and radio','TZ',2008,2012,1,6,'ney.landry@gmail.com',NULL),(5,'Program Coordinator','Telenets and Links','Coordinating video production and lessons planning. Preparing powerpoint presentations for upload to the LMS','TZ',2013,2015,11,6,'ney.landry@gmail.com',NULL),(6,'Manager','DN Foods','Preparing budgets for the restaurant. Cooking special foods, finding corporate clients','TZ',2015,2016,3,9,'ney.landry@gmail.com',NULL),(8,'Tutorial Assistant','Institute of Finance Management','Assisting Lecturer in conducting seminars with students. Administering class exercises and marking them. Administering programming challenges','TZ',2017,2019,4,11,'info@neelansoft.co.tz',NULL),(9,'Junior Front-end Engineer','Neelansoft Technologies','Creating Web interfaces, training interns on basic front end technologies, writing css and javascript code for web interaction','TZ',2019,-1,3,1,'info@neelansoft.co.tz',NULL),(10,'Mentor for Android and Web Developer Paths','Open Classrooms Internationl','pdf.addHtml doesnot work if there are svg images on the web page.. I copy the solution here: suppose your picture is already in a canvas var imgData = canvas.toDataURL(image/png); Here are the numbers (paper width and height) that I found to work. It still creates a little overlap part between the pages, but good enough for me. if you can find an official number from jsPDF, use them\r\npdf.addHtml doesnot work if there are svg images on the web page.. I copy the solution here:  suppose your picture is already in a canvas var imgData = canvas.toDataURL(image/png); Here are the numbers (paper width and height) that I found to work. It still creates a little overlap part between the pages, but good enough for me. if you can find an official number from jsPDF, use them','FR',2019,-1,3,1,'info@neelansoft.co.tz',NULL);
/*!40000 ALTER TABLE `work` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2020-04-20 23:35:35
