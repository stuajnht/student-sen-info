-- MySQL dump 10.13  Distrib 5.5.43, for debian-linux-gnu (i686)
--
-- Host: localhost    Database: sen_info
-- ------------------------------------------------------
-- Server version	5.5.43-0+deb7u1
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO,NO_KEY_OPTIONS,NO_TABLE_OPTIONS,NO_FIELD_OPTIONS' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `tbl_comments`
--

DROP TABLE IF EXISTS `tbl_comments`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_comments` (
  `CommentID` int(11) NOT NULL,
  `Comment` longtext NOT NULL,
  `MessageID` int(11) NOT NULL,
  `StaffUsername` varchar(64) NOT NULL,
  `CommentDate` datetime NOT NULL,
  PRIMARY KEY (`CommentID`),
  KEY `Comments.MessageID` (`MessageID`),
  KEY `Comments.StaffUsername` (`StaffUsername`),
  CONSTRAINT `Comments.StaffUsername` FOREIGN KEY (`StaffUsername`) REFERENCES `tbl_staff` (`StaffUsername`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `Comments.MessageID` FOREIGN KEY (`MessageID`) REFERENCES `tbl_messages` (`MessageID`) ON DELETE CASCADE ON UPDATE CASCADE
);
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_comments`
--

LOCK TABLES `tbl_comments` WRITE;
/*!40000 ALTER TABLE `tbl_comments` DISABLE KEYS */;
/*!40000 ALTER TABLE `tbl_comments` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_messages`
--

DROP TABLE IF EXISTS `tbl_messages`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_messages` (
  `MessageID` int(11) NOT NULL,
  `MessageTitle` varchar(255) NOT NULL,
  `StudentID` int(11) NOT NULL,
  `StaffUsername` varchar(64) NOT NULL,
  `MessageDate` datetime NOT NULL,
  `MessageStatus` int(11) NOT NULL,
  `PanelID` int(11) NOT NULL,
  PRIMARY KEY (`MessageID`),
  KEY `Messages.StudentID` (`StudentID`),
  KEY `Messages.StaffUsername` (`StaffUsername`),
  KEY `Messages.PanelID` (`PanelID`),
  CONSTRAINT `Messages.PanelID` FOREIGN KEY (`PanelID`) REFERENCES `tbl_panels` (`PanelID`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `Messages.StaffUsername` FOREIGN KEY (`StaffUsername`) REFERENCES `tbl_staff` (`StaffUsername`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `Messages.StudentID` FOREIGN KEY (`StudentID`) REFERENCES `tbl_students` (`StudentID`) ON DELETE CASCADE ON UPDATE CASCADE
);
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_messages`
--

LOCK TABLES `tbl_messages` WRITE;
/*!40000 ALTER TABLE `tbl_messages` DISABLE KEYS */;
/*!40000 ALTER TABLE `tbl_messages` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_panels`
--

DROP TABLE IF EXISTS `tbl_panels`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_panels` (
  `PanelID` int(11) NOT NULL,
  `PanelTitle` varchar(255) NOT NULL,
  `DisplayOrder` int(11) NOT NULL,
  `Colour` varchar(16) NOT NULL,
  `TextColour` varchar(16) NOT NULL,
  `AccentColourHover` varchar(16) NOT NULL,
  `PanelHidden` int(11) NOT NULL,
  PRIMARY KEY (`PanelID`)
);
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_panels`
--

LOCK TABLES `tbl_panels` WRITE;
/*!40000 ALTER TABLE `tbl_panels` DISABLE KEYS */;
INSERT INTO `tbl_panels` VALUES (1,'SEN Info',1,'purple','white','#8e24aa',0),(2,'Key Worker',2,'light-green','grey-800','#7cb342',0),(3,'Pastoral',3,'orange','grey-800','#fb8c00',0),(4,'Curriculum Overview',4,'red','grey-800','#e53935',0);
/*!40000 ALTER TABLE `tbl_panels` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_permissions`
--

DROP TABLE IF EXISTS `tbl_permissions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_permissions` (
  `StaffUsername` varchar(64) NOT NULL,
  `Permission` int(10) unsigned DEFAULT NULL,
  PRIMARY KEY (`StaffUsername`),
  CONSTRAINT `Permissions.StaffUsername` FOREIGN KEY (`StaffUsername`) REFERENCES `tbl_staff` (`StaffUsername`) ON DELETE CASCADE ON UPDATE CASCADE
);
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_permissions`
--

LOCK TABLES `tbl_permissions` WRITE;
/*!40000 ALTER TABLE `tbl_permissions` DISABLE KEYS */;
/*!40000 ALTER TABLE `tbl_permissions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_staff`
--

DROP TABLE IF EXISTS `tbl_staff`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_staff` (
  `StaffUsername` varchar(64) NOT NULL,
  `StaffForename` varchar(64) NOT NULL,
  `StaffSurname` varchar(64) NOT NULL,
  `StaffPassword` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`StaffUsername`)
);
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_staff`
--

LOCK TABLES `tbl_staff` WRITE;
/*!40000 ALTER TABLE `tbl_staff` DISABLE KEYS */;
/*!40000 ALTER TABLE `tbl_staff` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_student_meta`
--

DROP TABLE IF EXISTS `tbl_student_meta`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_student_meta` (
  `StudentID` int(11) NOT NULL,
  `YearGroup` varchar(3) DEFAULT NULL,
  `House` varchar(32) DEFAULT NULL,
  `Form` varchar(32) DEFAULT NULL,
  `DoB` varchar(32) DEFAULT NULL,
  `Comment` longtext,
  PRIMARY KEY (`StudentID`),
  CONSTRAINT `Meta.StudentID` FOREIGN KEY (`StudentID`) REFERENCES `tbl_students` (`StudentID`) ON DELETE CASCADE ON UPDATE CASCADE
);
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_student_meta`
--

LOCK TABLES `tbl_student_meta` WRITE;
/*!40000 ALTER TABLE `tbl_student_meta` DISABLE KEYS */;
/*!40000 ALTER TABLE `tbl_student_meta` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_students`
--

DROP TABLE IF EXISTS `tbl_students`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_students` (
  `StudentID` int(11) NOT NULL,
  `StudentForename` varchar(64) NOT NULL,
  `StudentSurname` varchar(64) NOT NULL,
  PRIMARY KEY (`StudentID`)
);
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_students`
--

LOCK TABLES `tbl_students` WRITE;
/*!40000 ALTER TABLE `tbl_students` DISABLE KEYS */;
/*!40000 ALTER TABLE `tbl_students` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping events for database 'sen_info'
--

--
-- Dumping routines for database 'sen_info'
--
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2015-09-24 11:48:45
