-- MySQL dump 10.13  Distrib 8.0.46, for Win64 (x86_64)
--
-- Host: 116.193.129.229    Database: prioisp_nsl
-- ------------------------------------------------------
-- Server version	8.0.46

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
-- Table structure for table `mst_apploptions`
--

DROP TABLE IF EXISTS `mst_apploptions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `mst_apploptions` (
  `Opt_Id` int NOT NULL,
  `Grp_Id` int DEFAULT NULL,
  `Opt_Group` varchar(150) DEFAULT NULL,
  `Opt_Sl` int DEFAULT NULL,
  `Opt_Name` varchar(255) DEFAULT NULL,
  `IsActive` bit(1) DEFAULT NULL,
  PRIMARY KEY (`Opt_Id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 AVG_ROW_LENGTH=420;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `mst_apploptions`
--

LOCK TABLES `mst_apploptions` WRITE;
/*!40000 ALTER TABLE `mst_apploptions` DISABLE KEYS */;
INSERT INTO `mst_apploptions` VALUES (1,1,'Customer Status',1,'Active',_binary ''),(2,1,'Customer Status',2,'InActive',_binary ''),(3,1,'Customer Status',3,'Suspended',_binary ''),(4,1,'Customer Status',4,'Disabled',_binary ''),(5,2,'Payment Status',1,'Billed',_binary ''),(6,2,'Payment Status',2,'Paid',_binary ''),(7,3,'Billing Type',1,'Daily',_binary ''),(8,3,'Billing Type',2,'Monthly',_binary ''),(9,3,'Billing Type',3,'Free',_binary ''),(10,4,'Sort By',1,'Customer Id',_binary '');
/*!40000 ALTER TABLE `mst_apploptions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `mst_counter`
--

DROP TABLE IF EXISTS `mst_counter`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `mst_counter` (
  `Counter_Id` smallint NOT NULL AUTO_INCREMENT,
  `Counter_Name` varchar(75) DEFAULT NULL,
  `Counter_Address` varchar(200) DEFAULT NULL,
  `Contact_No` varchar(25) DEFAULT NULL,
  `Email_Id` varchar(50) DEFAULT NULL,
  `Is_Active` bit(1) DEFAULT NULL,
  `Created_Date` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`Counter_Id`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `mst_counter`
--

LOCK TABLES `mst_counter` WRITE;
/*!40000 ALTER TABLE `mst_counter` DISABLE KEYS */;
INSERT INTO `mst_counter` VALUES (10,'Hoogly branch','Block-A, Tarkeshwar, Hoogly,westbengal ,700122','9878767656','hooglybranch@gmail.com',_binary '','2026-07-10 00:00:00'),(12,'Mednipur Branch','chandracona,mednipur,westbengal,788677','9898786756','mednipurbranch@gmail.com',_binary '','2026-07-10 00:00:00'),(13,'Murshidabad Branch','murshidabad,westbengal,767763','9878675645','mrbranch@gmail.com',_binary '','2026-07-10 00:00:00'),(16,'kolkata branch',NULL,NULL,NULL,_binary '','2026-09-04 00:00:00');
/*!40000 ALTER TABLE `mst_counter` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `mst_counter_user`
--

DROP TABLE IF EXISTS `mst_counter_user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `mst_counter_user` (
  `User_Id` smallint NOT NULL AUTO_INCREMENT,
  `Counter_Id` smallint DEFAULT NULL,
  `Print_Name` varchar(75) DEFAULT NULL,
  `User_Name` varchar(75) DEFAULT NULL,
  `User_Pwd` varchar(255) DEFAULT NULL,
  `Is_Active` bit(1) DEFAULT NULL,
  `Created_Date` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`User_Id`)
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `mst_counter_user`
--

LOCK TABLES `mst_counter_user` WRITE;
/*!40000 ALTER TABLE `mst_counter_user` DISABLE KEYS */;
INSERT INTO `mst_counter_user` VALUES (14,11,'rakesh pratihar','rakesh','$2y$12$03w4V9jBZr2p6so0xRcJEu6D9nI5gbVpxFTZ02aP8da4ZPB2Z4RfW',_binary '','2026-07-10 11:48:54'),(15,10,'mukesh roy','mukesh','$2y$12$yvYppcps74bjaebchONeu.XFbjXxtmAn8hxaMWP44x4IlYKoqRD0G',_binary '','2026-07-10 11:55:26'),(16,12,'KAUSHIK','KAUSHIK','$2y$12$gft1dLG/6IlpuS9wiXzl9u.ZYgMw0AK9wRLWsRR7YOUNEUWGgfUgm',_binary '','2026-07-14 19:09:46'),(17,13,'MANISH','MANISH','$2y$12$OR7KvahzcCqsNgvWN80bEem5EFnAXvzBlXG5RP4bd2WJTCmwpYK3e',_binary '','2026-07-14 19:10:10'),(19,13,'ooo','rrrrrr','$2y$12$SEVE7VZC.bJlpwll7OwNsOEoQuqiX1vrDzsHynr1EH.f6uG3WqHkO',_binary '','2026-07-23 11:47:09'),(20,13,'ghf','tttttt','$2y$12$2txcD5eXWarOaW3.OGzZxeavmYSTs9WyZxz9WWq7tJl1oJzbcECvO',_binary '','2026-07-23 11:48:07'),(21,10,'rrrr','rrrr','$2y$12$LU2J1/zOvedApcZrmS0vSeGsYnVKvVcPsm2aKcHqkWCIwyTkuonIG',_binary '','2026-07-23 12:16:11'),(24,12,'rakesh','rakesh2019','$2y$12$4Jix4WsIzgnA0ex./PRJyONdHSEPv9ar8A4MR0QFYewxhh7k9dI5K',_binary '','2026-07-28 10:40:56');
/*!40000 ALTER TABLE `mst_counter_user` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `mst_customer`
--

DROP TABLE IF EXISTS `mst_customer`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `mst_customer` (
  `Cust_Id` int NOT NULL AUTO_INCREMENT,
  `Join_Date` date DEFAULT NULL,
  `Cust_Code` int DEFAULT NULL,
  `Cust_Name` varchar(250) DEFAULT NULL,
  `Billing_Address` longtext,
  `User_Id` varchar(75) DEFAULT NULL,
  `Account_No` varchar(75) DEFAULT NULL,
  `Contact_No` varchar(25) DEFAULT NULL,
  `Mail_Id` varchar(75) DEFAULT NULL,
  `IP_Addrs` varchar(25) DEFAULT NULL,
  `Package_Id` smallint DEFAULT NULL,
  `Plan_Amount` decimal(8,2) DEFAULT NULL,
  `GST` decimal(8,2) DEFAULT NULL,
  `Total_Amount` decimal(8,2) DEFAULT NULL,
  `Due_Amount` decimal(8,2) DEFAULT NULL,
  `Last_PayDt` date DEFAULT NULL,
  `Renew_From` date DEFAULT NULL,
  `Renew_Upto` date DEFAULT NULL,
  `Counter_Id` smallint DEFAULT NULL,
  `Zone_Id` smallint DEFAULT NULL,
  `Router_Dtls` varchar(255) DEFAULT NULL,
  `Remarks` varchar(150) DEFAULT NULL,
  `Status` tinyint DEFAULT NULL COMMENT '1: Active; 2: Inactive; 3: Surrendered',
  `AsOn_Date` date DEFAULT NULL,
  `Created_By` smallint DEFAULT NULL,
  `Created_On` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`Cust_Id`),
  UNIQUE KEY `Cust_Code_UNIQUE` (`Cust_Code`),
  UNIQUE KEY `User_Id_UNIQUE` (`User_Id`),
  UNIQUE KEY `Account_No_UNIQUE` (`Account_No`)
) ENGINE=InnoDB AUTO_INCREMENT=204 DEFAULT CHARSET=utf8mb3 AVG_ROW_LENGTH=327;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `mst_customer`
--

LOCK TABLES `mst_customer` WRITE;
/*!40000 ALTER TABLE `mst_customer` DISABLE KEYS */;
INSERT INTO `mst_customer` VALUES (1,NULL,1,'Aaishik Thakur','LIG, HOUSING ESTATE,BLOCK-C,FLAT-5,37,BELGACHIA ROAD, WEST BENGAL, KOLKATA-700037','aaishik_nl','10215047214','6291065126',NULL,'172.16.63.247',39,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,1,NULL,NULL,'2026-04-23 16:08:59'),(2,NULL,4,'Abdul Bari','11/A Indrabiswas Road, West Bengal, Kolkata-700037','abdul_nl','2644047916','9830380858',NULL,'172.22.120.214',39,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,1,NULL,NULL,'2026-04-23 16:08:59'),(3,NULL,6,'Abhijeet Bhattacharya','6B, U. K Sen Lane, Kolkata-700 030','abhijeetb1_nl','25047026','9836333944',NULL,'172.16.61.225',6,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,1,NULL,NULL,'2026-04-23 16:08:59'),(4,NULL,9,'Abhijit Bagui','C7/1, Indralok Housing, Kolkata- 700 002','bagui_nl','2271047504','9007290056',NULL,'172.16.194.39',43,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,1,NULL,NULL,'2026-04-23 16:08:59'),(5,NULL,10,'Abhijit Chowdhury','14A/2,Srinath Mukherjee Lane, Kolkata-700 037','ac183_nl','2467047127','9830166491',NULL,'172.16.64.183',48,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,1,NULL,NULL,'2026-04-23 16:08:59'),(6,NULL,12,'Abhijit Dutta','Block-O, Flat-2 Belghachia Villa, Kolkata- 700 047','abhijitd3_nl','1224047216','8479927084',NULL,'172.16.220.94',39,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,1,NULL,NULL,'2026-04-23 16:08:59'),(7,NULL,14,'Abhijit Ghosh','Belgachia Villa, Block-Z, Flat-1, Kolkata-700 037','abhijitg_nl','1077047844','9830264515',NULL,'172.16.220.90',26,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,1,NULL,NULL,'2026-04-23 16:08:59'),(8,NULL,17,'Abhijit Sarkar','9B Nothern Avenew, Kolkata- 700 037','abhijits_nl','1950047798','9433405279',NULL,'172.16.249.60',45,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,1,NULL,NULL,'2026-04-23 16:08:59'),(9,NULL,20,'Abhik Ghosh','Block-H, Flat-6, Belgachia Vila, Kolkata-700 037','abhik_nl','185047738','9830298975',NULL,'172.16.220.74',40,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,1,NULL,NULL,'2026-04-23 16:08:59'),(10,NULL,21,'Abhik Kumar Seth','26/1, 7 Tanks Lane, Kolkata- 700 030','abhikks_nl','2453047712','9830907145',NULL,'172.16.224.8',26,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,1,NULL,NULL,'2026-04-23 16:08:59'),(11,NULL,24,'Abhisek Chakraborty','7 Umakanta Sen Lane Santibon Flat Topor 401B, Kolkata- 700 030','abhisekc_nl','1086047840','9830256610',NULL,'172.16.61.55 PAT',39,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,1,NULL,NULL,'2026-04-23 16:08:59'),(12,NULL,30,'Abhishek Das','38/2 South Sithi Road, Kolkata -700 050','abhishekd_nl','54047226','9748299460',NULL,'172.16.64.79',39,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,1,NULL,NULL,'2026-04-23 16:08:59'),(13,NULL,32,'Abhishek Dasgupta','22/3A/9, Sreenath Mukherjee Lane, Kolkata-700030','ad33_nl','1585047123','9830035032',NULL,'172.16.61.213',26,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,1,NULL,NULL,'2026-04-23 16:08:59'),(14,NULL,34,'Abhishek Dutta','48/5A Anath Nath Deb Lane, West Bengal, Kolkata -700037','adutta_nl','1328047740','9051202980',NULL,'172.16.61.92',39,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,1,NULL,NULL,'2026-04-23 16:08:59'),(15,NULL,35,'Abhishek Ghosh','18/B Monmatha Dutta Road, Kolkata-700 037','abhig_nl','20170111/abhig_nl','9830009774',NULL,'172.18.223.3',43,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,1,NULL,NULL,'2026-04-23 16:08:59'),(16,NULL,37,'Lipi Kar','2H NILMANI MITRA ROAD, WEST BENGAL,  KOLKATA-700002','lipi_nl','28031047652','9748088145',NULL,'172.16.245.74',39,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,1,NULL,NULL,'2026-04-23 16:08:59'),(17,NULL,41,'Abhishek Sen','48 Talapark Avenue, Kolkata- 700 037','abhisheks_nl','51047019','9831336830',NULL,'172.16.61.78',39,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,1,NULL,NULL,'2026-04-23 16:08:59'),(18,NULL,43,'Abhra Sankar Roy','1A Rani Banch Road, Kolkata - 700 002','abhras_nl','49047654','9830434034',NULL,'172.16.62.25',39,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,1,NULL,NULL,'2026-04-23 16:08:59'),(19,NULL,45,'Abin Chaudhury','22/1C, Gunguly Para Lane, Kolkata-700 037','abin_nl','48047548','9163796988',NULL,'172.17.233.215',39,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,1,NULL,NULL,'2026-04-23 16:08:59'),(20,NULL,50,'Aditi Ghosh Dostidar','15A Manmata Dutta Road, Kolkata - 700 037','agd_nl','1535047724','8981105879',NULL,'172.18.223.4',45,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,1,NULL,NULL,'2026-04-23 16:08:59'),(21,NULL,56,'Samir Basak','33, PAIK PARA ROW, WEST BENGAL, KOLKATA-700037','samir48_nl','30565047093','9433811307',NULL,'172.16.63.48',43,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,1,NULL,NULL,'2026-04-23 16:08:59'),(22,NULL,58,'Agnitra Ghosh','22C, Srinath Mukherjee Lane, Kolkata-700 030','agnitra_nl','2677047429','8981222432',NULL,'172.16.61.234',6,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,1,NULL,NULL,'2026-04-23 16:08:59'),(23,NULL,59,'Ajanta Dhar','Block-S, Flat-5, Belgachiya Vila, Kolkata-700 037','ad117_nl','2152047306','9830515870',NULL,'172.16.220.117',5,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,1,NULL,NULL,'2026-04-23 16:08:59'),(24,NULL,60,'Ajay Agarwal','27B Indra Biswas Road Kolkata-700 037','ajaya_nl','1457047040','9830048849',NULL,'172.17.54.195',26,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,1,NULL,NULL,'2026-04-23 16:08:59'),(25,NULL,61,'Ajay Bhattacharya','64/1/25A Belgachia Road, Milk Colony, Kolkata - 70','ajay_nl','8602047872','9830683270',NULL,'172.17.177.26',24,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,1,NULL,NULL,'2026-04-23 16:08:59'),(26,NULL,67,'Akash Ghosh','22/3A/1A Sreenath Mukherjee Lane, Kolkata-700 030','akash_nl','1165047630','9830018737',NULL,'172.16.18.25',39,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,1,NULL,NULL,'2026-04-23 16:08:59'),(27,NULL,72,'Aloke Sadhu','13K, Sarba Khan Road, Kolkata-700 037','asadhu_nl','1763047018','9830031228',NULL,'172.22.108.34',22,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,1,NULL,NULL,'2026-04-23 16:08:59'),(28,NULL,75,'Amal Kr Nandy','6A Bhabanath Sen Street, Kolkata-700 004','amalkn_nl','2545047922','9433028005',NULL,'172.16.62.131',16,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,1,NULL,NULL,'2026-04-23 16:08:59'),(29,NULL,77,'Amal Sanyal','22/132, Raja Mahindra Road, Kolkata-700 037','as182_nl','2610047186','9836309723',NULL,'172.17.231.182',40,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,1,NULL,NULL,'2026-04-23 16:08:59'),(30,NULL,79,'Amalina Banerjee','Block 1- Flat -13,L I G Houseing State Kolkata-700','amalina_nl','11120047893','8777679488',NULL,'172.16.63.204',39,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,1,NULL,NULL,'2026-04-23 16:08:59'),(31,NULL,81,'Amar Roy','24 Indra Biswas Road, Kolkata-700 037','amar112_nl','2425047618','8013492504',NULL,'172.16.185.112',39,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,1,NULL,NULL,'2026-04-23 16:08:59'),(32,NULL,83,'Amaresh Kumar Ray','10, Umakanta Sen Lane, North Plaza, Fl-13A, Kolkat','amaresh_nl','65047434','9804442677',NULL,'172.16.64.7',45,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,1,NULL,NULL,'2026-04-23 16:08:59'),(33,NULL,86,'Amit Dutta','9L, BEER PARA LANE, WEST BENGAL, KOLKATA-7000030','adutta196_nl','11371047598','9830600461',NULL,'172.17.231.201',39,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,1,NULL,NULL,'2026-04-23 16:08:59'),(34,NULL,88,'Amit Kumar Dutta','9/1D Nothern Avenue, Kolkata-700 037','akdutta_nl','1739047237','9433249737',NULL,'172.17.233.202',39,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,1,NULL,NULL,'2026-04-23 16:08:59'),(35,NULL,89,'Arindra Saha','28J, Northern Avenue, Kolkata-700030','amitks_nl','58047650','9038016926',NULL,'172.17.190.193',26,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,1,NULL,NULL,'2026-04-23 16:08:59'),(36,NULL,90,'Triptanjana Sarangi','BLOCK-Q,FLAT-2,BELGACHIA VILLA, MIG HOUSING ESTATE, BELGACHIA, WEST BENGAL, KOLKATA 700037','triptanjana_nl','29238047579','9830246541',NULL,'172.16.220.82',6,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,1,NULL,NULL,'2026-04-23 16:08:59'),(37,NULL,91,'Amit Mazumdar','25C/1,Seven Tanks Lane,Kolkata-700 030','am25_nl','1808047036','9831706708',NULL,'172.16.224.25',39,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,1,NULL,NULL,'2026-04-23 16:08:59'),(38,NULL,92,'Amit Ray','11/1A, Roy para road, Kolkata-700050','amitr_nl','7132047582','9436012585',NULL,'192.168.171.6',20,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,1,NULL,NULL,'2026-04-23 16:08:59'),(39,NULL,94,'Amitabh Chattopadhyay','12/3A, NORTHERN AVENUE, WEST BENGAL, KOLKATA-700037','amitabhc_nl','2143047310','9830119603',NULL,'172.16.63.80',22,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,1,NULL,NULL,'2026-04-23 16:08:59'),(40,NULL,97,'Amitabha Sen','25/4, Northern Avenue, Kolkata-700 037','as118_nl','11849047529','9830273421',NULL,'172.17.99.118',39,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,1,NULL,NULL,'2026-04-23 16:08:59'),(41,NULL,98,'Amitava Chatterjee','10/2A,GOUR SUNDAR SETH LANE, WEST BENGAL KOLKATA-700050','amitavac_nl','62047116','9831290496',NULL,'172.19.168.73',39,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,1,NULL,NULL,'2026-04-23 16:08:59'),(42,NULL,99,'Amitava Chatterjee','58, Anath Nath Deb Lane, Kolkata-700 037','ac145_nl','1453047616','8910717028',NULL,'172.16.185.126',29,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,1,NULL,NULL,'2026-04-23 16:08:59'),(43,NULL,101,'Amitava Dutta','11/1G,Roypara Road, Kolkata-700 050','adutta95_nl','2237047732','9836186585',NULL,'172.16.64.95',44,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,1,NULL,NULL,'2026-04-23 16:08:59'),(44,NULL,104,'Amitava Kar','19/S, Dum Dum Road, Kolkata-700 030','amitavak_nl','1854047011','9433746453',NULL,'172.18.203.5',24,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,1,NULL,NULL,'2026-04-23 16:08:59'),(45,NULL,106,'Amiya Kumar Mallick','64/54/2, BELGACHIA ROAD, WEST BENGAL, KOLKATA-700037','amiya_nl','2280047500','8017133590',NULL,'172.17.177.97',39,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,1,NULL,NULL,'2026-04-23 16:08:59'),(46,NULL,114,'Angshuman Sarkar','12No Monmatha Dutta Road, West Bengal, Kolkata-700037','asarkar_nl','1898047843','9433518196',NULL,'172.18.223.5',26,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,1,NULL,NULL,'2026-04-23 16:08:59'),(47,NULL,119,'Anindya Chatterjee','39A Paik Para Row, Kolkata-700 037','anindya4_nl','1507047630','9163425414',NULL,'172.16.63.4',24,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,1,NULL,NULL,'2026-04-23 16:08:59'),(48,NULL,120,'Anindya Chatterjee','29/2C Northern Avenue, Kolkata - 700 030','aninda_nl','2590047902','9830281913',NULL,'172.16.64.177',39,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,1,NULL,NULL,'2026-04-23 16:08:59'),(49,NULL,123,'Anirban Dutta','64/1/28A K.B. Sarani, Kolkata - 700 037','adutta67_nl','39047552','9830238667',NULL,'172.16.220.67',39,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,3,NULL,NULL,'2026-04-23 16:08:59'),(50,NULL,125,'Anirban Sengupta','8/A Raypara Bye lane, Kolkata-700050','as116_nl','2500047095','9230567390',NULL,'172.16.64.116',39,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,1,NULL,NULL,'2026-04-23 16:08:59'),(201,'2026-08-05',1111,'shiv kumar','kolkata','21311','2324','9858587845','shiv@gmail.com','23423',66,800.00,50.00,850.00,0.00,'2026-08-05','2026-10-11','2026-12-19',NULL,42,'5345','gfhfgh',1,NULL,1,'2026-08-05 10:03:03'),(202,'2026-08-14',9090,'ROBIN HOOD','KOLKATA','909090','90909090','9090909090',NULL,'9090',67,200.00,2.00,202.00,404.00,'2026-09-04','2026-09-30','2026-10-29',NULL,43,NULL,NULL,1,NULL,1,'2026-09-04 16:44:26'),(203,'2026-09-04',1010,'TTT','TTT','101010','10101010','4444444444',NULL,'10101010',68,200.00,10.00,210.00,0.00,'2026-09-04','2026-09-04','2026-10-03',NULL,43,NULL,NULL,1,NULL,1,'2026-09-04 17:10:44');
/*!40000 ALTER TABLE `mst_customer` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `mst_menus`
--

DROP TABLE IF EXISTS `mst_menus`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `mst_menus` (
  `Menu_Sl` smallint NOT NULL AUTO_INCREMENT,
  `Menu_Id` smallint DEFAULT NULL,
  `Menu_Name` varchar(25) DEFAULT NULL,
  `SubMenu_Id` smallint DEFAULT NULL,
  `SubMenu_Name` varchar(50) DEFAULT NULL,
  `Icon` varchar(25) DEFAULT NULL,
  `Route` varchar(50) DEFAULT NULL,
  `Is_Active` tinyint(1) DEFAULT NULL,
  `Is_Admin` bit(1) DEFAULT NULL,
  PRIMARY KEY (`Menu_Sl`)
) ENGINE=InnoDB AUTO_INCREMENT=71 DEFAULT CHARSET=utf8mb3 AVG_ROW_LENGTH=1489;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `mst_menus`
--

LOCK TABLES `mst_menus` WRITE;
/*!40000 ALTER TABLE `mst_menus` DISABLE KEYS */;
INSERT INTO `mst_menus` VALUES (1,1,'Dashboard',NULL,NULL,'home','dashboard',1,NULL),(3,3,'Transactions',NULL,NULL,'credit-card',NULL,1,NULL),(4,3,NULL,1,'Generate Renewal','','generate.demand',1,NULL),(5,3,NULL,2,'Payment Collection',NULL,'demand.collection',1,NULL),(6,3,NULL,3,'Rectify Collection',NULL,'rectify',1,NULL),(7,3,NULL,4,'Bill Print',NULL,'bill.print',1,NULL),(8,4,'Dashboard',NULL,NULL,'home','dashboard',1,_binary ''),(11,5,'Admin',NULL,NULL,'shield',NULL,1,_binary ''),(12,5,NULL,1,'Counter Setup',NULL,'admin.counter',1,_binary ''),(13,5,NULL,2,'Zone Setup',NULL,'admin.zone',1,_binary ''),(14,5,NULL,4,'User Setup',NULL,'admin.user.setup',1,_binary ''),(15,5,NULL,5,'Package Details',NULL,'admin.package',1,_binary ''),(16,5,NULL,6,'Rectify Collection',NULL,'admin.rectify',1,_binary ''),(17,5,NULL,7,'Customer Surrender',NULL,'admin.surrender',1,_binary ''),(20,6,'Reports',NULL,NULL,'file-text',NULL,1,NULL),(21,6,NULL,1,'Customer Register',NULL,'report.customer.register',1,NULL),(22,6,NULL,2,'Customer Ledger',NULL,'customer.ledger',1,NULL),(23,6,NULL,3,'Renewal Register',NULL,'report.renewal.register',1,NULL),(24,6,NULL,4,'Collection Register',NULL,'report.collection.register',1,NULL),(25,6,NULL,5,'Due Register',NULL,'report.due.register',1,NULL),(51,11,'Sub Menu',NULL,NULL,NULL,NULL,0,NULL),(52,11,NULL,1,'Edit',NULL,NULL,0,NULL),(53,11,NULL,2,'Suspend',NULL,NULL,0,NULL),(54,11,NULL,3,'Disable',NULL,NULL,0,NULL),(55,11,NULL,4,'Recharge',NULL,NULL,0,NULL),(56,11,NULL,5,'Add OTT',NULL,NULL,0,NULL),(57,11,NULL,6,'Delete',NULL,NULL,0,NULL),(58,12,NULL,9,'Commission Register Zone',NULL,'admin.commission.register',1,_binary ''),(59,5,NULL,3,'Customers',NULL,'admin.new.customer',1,_binary ''),(60,5,NULL,11,'Counter Wise Collection',NULL,'admin.counterwisecollection',1,_binary ''),(61,6,NULL,6,'Commission Register',NULL,'report.commission.register',1,NULL),(62,5,NULL,12,'Comision Payout',NULL,'admin.commission.payout',1,_binary ''),(63,12,NULL,10,'Commission Register Counter',NULL,'admin.commission.register.counter',1,_binary ''),(64,5,NULL,13,'Generate Renewal',NULL,'admin.generate.demand',1,_binary ''),(65,5,NULL,14,'Payment Collection',NULL,'admin.demand.collection',1,_binary ''),(66,12,'Reports',NULL,NULL,NULL,NULL,1,_binary ''),(67,12,NULL,4,'Renewal Register',NULL,'admin.report.renewal.register',1,_binary ''),(68,12,NULL,5,'Collection Register',NULL,'admin.report.collection.register',1,_binary ''),(69,12,NULL,6,'Due Register',NULL,'admin.report.due.register',1,_binary ''),(70,12,NULL,7,'Customer Ledger',NULL,'admin.customer.ledger',1,_binary '');
/*!40000 ALTER TABLE `mst_menus` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `mst_mode`
--

DROP TABLE IF EXISTS `mst_mode`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `mst_mode` (
  `Mode_Id` tinyint NOT NULL AUTO_INCREMENT,
  `Mode` varchar(25) DEFAULT NULL,
  `Is_Active` bit(1) DEFAULT NULL,
  PRIMARY KEY (`Mode_Id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb3 AVG_ROW_LENGTH=2048;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `mst_mode`
--

LOCK TABLES `mst_mode` WRITE;
/*!40000 ALTER TABLE `mst_mode` DISABLE KEYS */;
INSERT INTO `mst_mode` VALUES (1,'Cash',_binary ''),(2,'GPay',_binary ''),(3,'PhonePe',_binary ''),(4,'Paytm',_binary ''),(5,'Bhim',_binary ''),(6,'Cheque',_binary ''),(7,'Netbanking',_binary ''),(9,'Others',_binary '');
/*!40000 ALTER TABLE `mst_mode` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `mst_operator`
--

DROP TABLE IF EXISTS `mst_operator`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `mst_operator` (
  `Oper_Id` smallint NOT NULL AUTO_INCREMENT,
  `Oper_Name` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`Oper_Id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `mst_operator`
--

LOCK TABLES `mst_operator` WRITE;
/*!40000 ALTER TABLE `mst_operator` DISABLE KEYS */;
/*!40000 ALTER TABLE `mst_operator` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `mst_org`
--

DROP TABLE IF EXISTS `mst_org`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `mst_org` (
  `Org_Name` varchar(150) DEFAULT NULL,
  `Org_Address` varchar(200) DEFAULT NULL,
  `Print_Name` varchar(150) DEFAULT NULL,
  `Print_Address` varchar(200) DEFAULT NULL,
  `Print_Footer` varchar(200) DEFAULT NULL,
  `Exp_Date` date DEFAULT NULL,
  `LOC_Comm` decimal(5,2) DEFAULT '0.00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 AVG_ROW_LENGTH=16384;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `mst_org`
--

LOCK TABLES `mst_org` WRITE;
/*!40000 ALTER TABLE `mst_org` DISABLE KEYS */;
INSERT INTO `mst_org` VALUES ('NORTH SATELLITE LINK (P) LTD.','120/1B, PAIK PARA ROW, KOLKATA - 700 037','ALLIANCE BROADBAND SERVICES PVT. LTD.','P-89, C.I.T ROAD , 2ND FLOOR . KOLKATA - 700014','COMPLAINT No. 6292235093, 6292235094, 6292235095, 6292235096 ( 7AM TO 9PM ) TOLL FREE No. 1800 1200 300',NULL,NULL);
/*!40000 ALTER TABLE `mst_org` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `mst_othercoll`
--

DROP TABLE IF EXISTS `mst_othercoll`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `mst_othercoll` (
  `Coll_Id` int NOT NULL AUTO_INCREMENT,
  `Coll_Date` date DEFAULT NULL,
  `Cust_Id` int DEFAULT NULL,
  `Purp_Id` smallint DEFAULT NULL,
  `Coll_Amount` decimal(8,2) DEFAULT NULL,
  `Coll_Mode` tinyint DEFAULT NULL,
  `Receipt_No` int DEFAULT NULL,
  `Particulars` varchar(150) DEFAULT NULL,
  `Counter_Id` smallint DEFAULT NULL,
  `Created_By` smallint DEFAULT NULL,
  `Created_On` datetime DEFAULT NULL,
  PRIMARY KEY (`Coll_Id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `mst_othercoll`
--

LOCK TABLES `mst_othercoll` WRITE;
/*!40000 ALTER TABLE `mst_othercoll` DISABLE KEYS */;
/*!40000 ALTER TABLE `mst_othercoll` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `mst_pack_type`
--

DROP TABLE IF EXISTS `mst_pack_type`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `mst_pack_type` (
  `Pack_Type_Id` tinyint NOT NULL AUTO_INCREMENT,
  `Pack_Type_Name` varchar(50) NOT NULL,
  `Is_Active` tinyint DEFAULT '1',
  PRIMARY KEY (`Pack_Type_Id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `mst_pack_type`
--

LOCK TABLES `mst_pack_type` WRITE;
/*!40000 ALTER TABLE `mst_pack_type` DISABLE KEYS */;
INSERT INTO `mst_pack_type` VALUES (1,'UNLIMITED',1),(2,'OTT PLAN',1),(3,'SCHEME',1),(4,'UTSAB PLAN',1),(5,'IPTV PLAN',1),(6,'OTHER 1',1),(7,'OTHER 2',1),(8,'OTHER 3',1);
/*!40000 ALTER TABLE `mst_pack_type` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `mst_package`
--

DROP TABLE IF EXISTS `mst_package`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `mst_package` (
  `Package_Id` smallint NOT NULL AUTO_INCREMENT,
  `Pack_Type` tinyint DEFAULT NULL COMMENT '1: Package; 2: OTT',
  `Package_Name` varchar(100) DEFAULT NULL,
  `Basic_Amt` decimal(8,2) DEFAULT NULL,
  `GST_Amt` decimal(8,2) DEFAULT NULL,
  `Total_Amt` decimal(8,2) DEFAULT NULL,
  `Plan_Days` smallint DEFAULT NULL,
  `Comm_Amt` decimal(8,2) DEFAULT NULL,
  `Is_Active` bit(1) DEFAULT NULL,
  PRIMARY KEY (`Package_Id`)
) ENGINE=InnoDB AUTO_INCREMENT=69 DEFAULT CHARSET=utf8mb3 AVG_ROW_LENGTH=287;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `mst_package`
--

LOCK TABLES `mst_package` WRITE;
/*!40000 ALTER TABLE `mst_package` DISABLE KEYS */;
INSERT INTO `mst_package` VALUES (1,4,'ALLIANCE 699 IPTV [BANGLA',699.00,125.82,824.82,30,1.00,_binary ''),(2,1,'ANNUAL COMBO 1 (12M+2M)',14000.00,2520.00,16520.00,420,1.00,_binary ''),(3,1,'Annual Combo 2 (12M+4K Box)',14000.00,2520.00,16520.00,365,1.00,_binary ''),(4,1,'BINGE 40',600.00,108.00,708.00,30,1.00,_binary ''),(5,1,'BINGE 100',700.00,126.00,826.00,30,1.00,_binary ''),(6,1,'BINGE 150',850.00,153.00,1003.00,30,1.00,_binary ''),(7,1,'BROWSER',400.00,72.00,472.00,30,1.00,_binary ''),(8,1,'Corp_175',1150.00,207.00,1357.00,30,1.00,_binary ''),(9,1,'Corp_250',1500.00,270.00,1770.00,30,1.00,_binary ''),(10,1,'Corp_510',3500.00,630.00,4130.00,30,1.00,_binary ''),(11,1,'CRUISE',1000.00,180.00,1180.00,30,1.00,_binary ''),(12,1,'ENTRY',700.00,126.00,826.00,30,1.00,_binary ''),(13,1,'FLASH+',2600.00,468.00,3068.00,30,1.00,_binary ''),(14,1,'Free pack',0.00,0.00,0.00,30,1.00,_binary ''),(15,1,'GIGABLAST',7000.00,1260.00,8260.00,30,1.00,_binary ''),(16,1,'IPTV BASIC 50',600.00,108.00,708.00,30,1.00,_binary ''),(17,1,'IPTV HD [BANGLA]',900.00,162.00,1062.00,30,1.00,_binary ''),(18,1,'IPTV HD [HINDI]',900.00,162.00,1062.00,30,1.00,_binary ''),(19,1,'IPTV HD LITE [HINDI]',700.00,126.00,826.00,30,1.00,_binary ''),(20,1,'LAUNCHER',425.00,76.50,501.50,30,1.00,_binary ''),(21,1,'PREFERRED+',850.00,153.00,1003.00,30,1.00,_binary ''),(22,1,'PREFERRED+ (8M+4M)',6800.00,1224.00,8024.00,360,1.00,_binary ''),(23,1,'PREMIUM+',1150.00,207.00,1357.00,30,1.00,_binary ''),(24,1,'PRIME+',650.00,117.00,767.00,30,1.00,_binary ''),(25,1,'PRIME+ (6M+2M)',3900.00,702.00,4602.00,240,1.00,_binary ''),(26,1,'PRIME+ (8M+4M)',5200.00,936.00,6136.00,360,1.00,_binary ''),(27,1,'QTR 150',1850.00,333.00,2183.00,90,1.00,_binary ''),(28,1,'QTR 150+',2370.00,426.60,2796.60,90,1.00,_binary ''),(29,1,'QTR 400',2110.00,379.80,2489.80,90,1.00,_binary ''),(30,1,'QTR 400+',2700.00,486.00,3186.00,90,1.00,_binary ''),(31,1,'QTR 50',1350.00,243.00,1593.00,90,1.00,_binary ''),(32,1,'QTR 50+',1770.00,318.60,2088.60,90,1.00,_binary ''),(33,1,'SMART',850.00,153.00,1003.00,30,1.00,_binary ''),(34,1,'SME 1 Gbps',7000.00,1260.00,8260.00,30,1.00,_binary ''),(35,1,'SME 175',1150.00,207.00,1357.00,30,1.00,_binary ''),(36,1,'SME 250',1500.00,270.00,1770.00,30,1.00,_binary ''),(37,1,'SME 400',2600.00,468.00,3068.00,30,1.00,_binary ''),(38,1,'SPEED+',1500.00,270.00,1770.00,30,1.00,_binary ''),(39,1,'STARTER',500.00,90.00,590.00,30,1.00,_binary ''),(40,1,'STARTER_YEARLY',6000.00,1080.00,7080.00,390,1.00,_binary ''),(41,1,'STREAM',550.00,99.00,649.00,30,1.00,_binary ''),(42,1,'UTSAV 140 (180 days)',2550.00,459.00,3009.00,180,1.00,_binary ''),(43,1,'UTSAV 140 (360 days)',5100.00,918.00,6018.00,360,1.00,_binary ''),(44,1,'UTSAV 175 (390 DAYS)',6900.00,1242.00,8142.00,390,1.00,_binary ''),(45,1,'UTSAV 250 (420 DAYS)',9000.00,1620.00,10620.00,420,1.00,_binary ''),(46,1,'UTSAV 400 (450 DAYS)',15600.00,2808.00,18408.00,450,1.00,_binary ''),(47,1,'WELCOME IPTV HD [BANGLA]',2700.00,486.00,3186.00,90,1.00,_binary ''),(48,1,'ZOOM',600.00,108.00,708.00,30,1.00,_binary ''),(49,1,'Zoom OTT',0.00,0.00,0.00,0,1.00,_binary ''),(50,2,'NETFLIX',0.00,0.00,0.00,0,1.00,_binary ''),(51,2,'PRIME VIDEO',0.00,0.00,0.00,0,1.00,_binary ''),(52,2,'TATA PLAY',0.00,0.00,0.00,0,1.00,_binary ''),(53,2,'HOICHOI',0.00,0.00,0.00,0,1.00,_binary ''),(54,2,'ZEE 5',0.00,0.00,0.00,0,1.00,_binary ''),(55,2,'HOTSTAR',0.00,0.00,0.00,0,1.00,_binary ''),(62,1,'Bengali Sports',600.00,100.00,700.00,30,1.00,_binary '\0'),(64,1,'sonny1',2000.00,30.00,2030.00,90,1.00,_binary ''),(65,1,'sonny2',500.00,80.00,580.00,70,0.00,_binary ''),(66,3,'sonny3',800.00,50.00,850.00,70,0.00,_binary ''),(67,1,'SKY WORLD',200.00,2.00,202.00,30,1.00,_binary ''),(68,1,'YYY',200.00,10.00,210.00,30,1.00,_binary '');
/*!40000 ALTER TABLE `mst_package` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `mst_package_ott`
--

DROP TABLE IF EXISTS `mst_package_ott`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `mst_package_ott` (
  `OTT_Id` smallint NOT NULL AUTO_INCREMENT,
  `OTT_Name` varchar(75) DEFAULT NULL,
  `Basic` decimal(8,2) DEFAULT NULL,
  `Gst` decimal(5,2) DEFAULT NULL,
  `Total` decimal(8,2) DEFAULT NULL,
  `Plan_Days` smallint DEFAULT NULL,
  `Is_Active` bit(1) DEFAULT NULL,
  PRIMARY KEY (`OTT_Id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb3 AVG_ROW_LENGTH=2048;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `mst_package_ott`
--

LOCK TABLES `mst_package_ott` WRITE;
/*!40000 ALTER TABLE `mst_package_ott` DISABLE KEYS */;
INSERT INTO `mst_package_ott` VALUES (1,'NETFLIX',NULL,NULL,NULL,NULL,_binary ''),(2,'PRIME VIDEO',NULL,NULL,NULL,NULL,_binary ''),(3,'TATA PLAY',NULL,NULL,NULL,NULL,_binary ''),(4,'HOICHOI',NULL,NULL,NULL,NULL,_binary ''),(5,'ZEE 5',NULL,NULL,NULL,NULL,_binary ''),(6,'HOTSTAR',NULL,NULL,NULL,NULL,_binary ''),(7,'SONY LIV',NULL,NULL,NULL,NULL,_binary ''),(8,'ADD-ON-PACKAGE',NULL,NULL,NULL,NULL,_binary '');
/*!40000 ALTER TABLE `mst_package_ott` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `mst_purpose`
--

DROP TABLE IF EXISTS `mst_purpose`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `mst_purpose` (
  `Purpose_Id` smallint NOT NULL AUTO_INCREMENT,
  `Purpose` varchar(75) DEFAULT NULL,
  `Purp_Type` char(1) DEFAULT NULL,
  `Amount` decimal(8,2) DEFAULT NULL,
  `Is_Active` bit(1) DEFAULT NULL,
  PRIMARY KEY (`Purpose_Id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb3 AVG_ROW_LENGTH=8192;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `mst_purpose`
--

LOCK TABLES `mst_purpose` WRITE;
/*!40000 ALTER TABLE `mst_purpose` DISABLE KEYS */;
INSERT INTO `mst_purpose` VALUES (1,'Installation Charges','R',0.00,_binary ''),(2,'ONU Charges','R',0.00,_binary ''),(3,'Router Charges','R',0.00,_binary ''),(4,'Package Update','R',0.00,_binary ''),(5,'Static IP Charges','R',0.00,_binary '');
/*!40000 ALTER TABLE `mst_purpose` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `mst_user`
--

DROP TABLE IF EXISTS `mst_user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `mst_user` (
  `User_Id` smallint NOT NULL AUTO_INCREMENT,
  `Full_Name` varchar(75) DEFAULT NULL,
  `User_Name` varchar(75) DEFAULT NULL,
  `Usr_Pwd` varchar(255) DEFAULT NULL,
  `Is_Admin` bit(1) DEFAULT NULL,
  `Is_Active` bit(1) DEFAULT b'1',
  `User_Type` smallint NOT NULL COMMENT '1: Office; 2: Counter',
  `Counter_Id` smallint DEFAULT NULL,
  `Created_Date` datetime DEFAULT NULL,
  PRIMARY KEY (`User_Id`)
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=utf8mb3 AVG_ROW_LENGTH=16384;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `mst_user`
--

LOCK TABLES `mst_user` WRITE;
/*!40000 ALTER TABLE `mst_user` DISABLE KEYS */;
INSERT INTO `mst_user` VALUES (1,'Admin','admin','$2y$10$pTFkqtzyiVTmDI.2b/.TMem7sVwfm0zRw/fBr4CICmdkk1kd9tt0K',_binary '',_binary '',1,NULL,NULL),(21,'User','user','$2y$10$XbBzRGXv5U2ozwdrE4X8B.J41/BK9eso39q9N5JQx5.0msEH1uoXC',NULL,_binary '',0,10,'2026-07-23 12:16:11'),(24,'rakesh','rakesh2019','$2y$12$4Jix4WsIzgnA0ex./PRJyONdHSEPv9ar8A4MR0QFYewxhh7k9dI5K',NULL,_binary '',0,12,'2026-07-28 10:40:56');
/*!40000 ALTER TABLE `mst_user` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `mst_user_menu`
--

DROP TABLE IF EXISTS `mst_user_menu`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `mst_user_menu` (
  `Id` int NOT NULL AUTO_INCREMENT,
  `User_Id` smallint NOT NULL,
  `Menu_Sl` int NOT NULL,
  PRIMARY KEY (`Id`),
  UNIQUE KEY `uq_user_menu` (`User_Id`,`Menu_Sl`)
) ENGINE=InnoDB AUTO_INCREMENT=175 DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `mst_user_menu`
--

LOCK TABLES `mst_user_menu` WRITE;
/*!40000 ALTER TABLE `mst_user_menu` DISABLE KEYS */;
INSERT INTO `mst_user_menu` VALUES (162,21,1),(163,21,3),(164,21,4),(165,21,5),(166,21,6),(167,21,7),(168,21,20),(169,21,21),(170,21,22),(171,21,23),(172,21,24),(173,21,25),(174,21,61),(1,22,1),(2,22,4),(3,22,5),(4,22,21),(5,22,22),(8,23,21),(9,23,22),(80,24,1),(81,24,3),(82,24,4),(83,24,5),(84,24,6),(85,24,7),(86,24,20),(87,24,21),(88,24,22),(89,24,23),(90,24,24),(91,24,25),(92,24,61);
/*!40000 ALTER TABLE `mst_user_menu` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `mst_zone`
--

DROP TABLE IF EXISTS `mst_zone`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `mst_zone` (
  `Zone_Id` smallint NOT NULL AUTO_INCREMENT,
  `Zone_Cd` varchar(25) DEFAULT NULL,
  `LCO_Name` varchar(100) DEFAULT NULL,
  `Operator_Name` varchar(100) DEFAULT NULL,
  `Comm_Pct` decimal(5,2) DEFAULT '0.00',
  `Counter_Id` smallint DEFAULT NULL,
  `Is_Active` bit(1) DEFAULT NULL,
  `Created_Date` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`Zone_Id`)
) ENGINE=InnoDB AUTO_INCREMENT=44 DEFAULT CHARSET=utf8mb3 AVG_ROW_LENGTH=528;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `mst_zone`
--

LOCK TABLES `mst_zone` WRITE;
/*!40000 ALTER TABLE `mst_zone` DISABLE KEYS */;
INSERT INTO `mst_zone` VALUES (1,'A','SUBRATA BASU ','SUBRATA BASU',0.00,NULL,_binary '','2026-04-23 11:13:05'),(2,'B2','BHOWMIK AGENCY','NARAYAN CH BHOWMIK',0.00,NULL,_binary '','2026-04-23 11:13:05'),(3,'B3A','LOVELY CABLE','DEB KUMAR KUNDU',0.00,NULL,_binary '','2026-04-23 11:13:05'),(4,'B3A','DEBNATH AGENCY','KASHINATH DEBNATH',0.00,NULL,_binary '','2026-04-23 11:13:05'),(5,'B4','PARSS ENTERPRISE ','SHYAMSUNDAR BHATTACHARYA',0.00,NULL,_binary '','2026-04-23 11:13:05'),(6,'B4A','N C ENTERPRICE ','BIPLAB CHAKRABORTY',0.00,NULL,_binary '','2026-04-23 11:13:05'),(7,'B5','J M AGENCIES ','MONAJ PRAMANIK',0.00,NULL,_binary '','2026-04-23 11:13:05'),(8,'B6','MONORAMA AGENCIES ','BRAJESWER TALUKDER',0.00,NULL,_binary '','2026-04-23 11:13:05'),(9,'B7','RUBI MAITY ','PRABUDDHA MAITY',0.00,NULL,_binary '','2026-04-23 11:13:05'),(10,'B8','INDRA AGENCIES ','SHIVAJI RAY',0.00,NULL,_binary '','2026-04-23 11:13:05'),(11,'B9','INDRAJIT MITRA ','INDRAJIT MITRA',0.00,NULL,_binary '','2026-04-23 11:13:05'),(12,'B12','RAJIB NANDI ','RAJIB NANDI',0.00,NULL,_binary '','2026-04-23 11:13:05'),(13,'B13B','OM CABLE ','PRADIP GOUR',0.00,NULL,_binary '','2026-04-23 11:13:05'),(14,'B13C','MOUSUMI DUTTA','MOUSUMI DUTTA',10.00,NULL,_binary '','2026-04-23 11:13:05'),(15,'D','RANS COMMUNICATIONS ','ARINDAM PALIT',0.00,NULL,_binary '','2026-04-23 11:13:05'),(16,'D2','TAPAN DAS ','TAPAN DAS',0.00,NULL,_binary '','2026-04-23 11:13:05'),(17,'D3','SPAN ENTERPRISE ','TAPAN MONDAL',0.00,NULL,_binary '','2026-04-23 11:13:05'),(18,'D4','D G ENTERPRISE','SANTANU GANGULY',0.00,NULL,_binary '','2026-04-23 11:13:05'),(19,'F','VINEETH PATEL','VINEETH PATEL',0.00,NULL,_binary '','2026-04-23 11:13:05'),(20,'F2','DIYA CABLE & BROADBAND SERVICE','ASTAMI MALAKR',0.00,NULL,_binary '','2026-04-23 11:13:05'),(21,'G','RINKU JANA','RINKU JANA',0.00,NULL,_binary '','2026-04-23 11:13:05'),(22,'J1','YOGSUTRA ','SANJOY PAUL',0.00,NULL,_binary '','2026-04-23 11:13:05'),(23,'J3','STAR CLUB ','DEBRAJ GHOSH',0.00,NULL,_binary '','2026-04-23 11:13:05'),(24,'L','BLUE STAR CABLE LINK','AKASHDEEP ARORA',0.00,NULL,_binary '','2026-04-23 11:13:05'),(25,'NSL','NORTH SATELLITE LINK','NSL',0.00,NULL,_binary '','2026-04-23 11:13:05'),(26,'ALLIANCE','ALLIANCE ONLINE','ALLIANCE ONLINE',0.00,NULL,_binary '','2026-04-23 11:13:05'),(27,'J4','SHIBSANKAR ROY','PAPPU ROY',0.00,NULL,_binary '','2026-04-23 11:13:05'),(28,'JRE','GOLD CABLE VISION ','ATANU DAS',0.00,NULL,_binary '','2026-04-23 11:13:05'),(29,'C3','MOUSUMI CABLE NETWORK','MANTU DAS',0.00,NULL,_binary '','2026-04-23 11:13:05'),(30,'K','GOVIND CABLE NETWORK ','GOVIND LAL SHAW',0.00,NULL,_binary '','2026-04-23 11:13:05'),(31,'I','SATYA TELECOM ','RIKI JAISWAL',0.00,NULL,_binary '','2026-04-23 11:13:05'),(35,'I9','Golden Club','Sumon Mondal',0.00,NULL,_binary '','2026-07-10 00:00:00'),(36,'C12','R.MUKESH','C.KUMAR',0.00,NULL,_binary '','2026-07-14 00:00:00'),(37,'N8','SURESH ROY','MUKESH ROY',12.00,NULL,_binary '','2026-07-14 00:00:00'),(40,'v12','sunil raj','vairab kamli',13.00,NULL,_binary '','2026-07-14 00:00:00'),(42,'v1','probodh roy','sanjib roy',10.00,NULL,_binary '','2026-07-16 00:00:00'),(43,'zone201','mukesh kumar','mukesh kumar',10.00,NULL,_binary '','2026-09-04 00:00:00');
/*!40000 ALTER TABLE `mst_zone` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `mst_zone_comm_rate`
--

DROP TABLE IF EXISTS `mst_zone_comm_rate`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `mst_zone_comm_rate` (
  `Id` int NOT NULL AUTO_INCREMENT,
  `Zone_Id` int NOT NULL,
  `Comm_Rate` decimal(6,0) NOT NULL DEFAULT '0',
  `Eff_From` date NOT NULL,
  `Eff_Upto` date DEFAULT NULL,
  `Is_Active` bit(1) NOT NULL DEFAULT b'1',
  `Created_By` smallint DEFAULT NULL,
  `Created_On` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `mst_zone_comm_rate`
--

LOCK TABLES `mst_zone_comm_rate` WRITE;
/*!40000 ALTER TABLE `mst_zone_comm_rate` DISABLE KEYS */;
INSERT INTO `mst_zone_comm_rate` VALUES (1,40,10,'2026-07-14','2026-07-17',_binary '\0',1,'2026-07-14 15:50:51'),(2,40,12,'2026-07-18','2026-07-24',_binary '\0',1,'2026-07-14 15:57:57'),(3,40,13,'2026-07-25',NULL,_binary '',1,'2026-07-14 15:59:04'),(4,41,10,'2026-07-15',NULL,_binary '',1,'2026-07-15 09:53:31'),(5,42,10,'2026-07-16',NULL,_binary '',1,'2026-07-16 10:29:48'),(6,43,10,'2026-09-04',NULL,_binary '',1,'2026-09-04 16:37:40');
/*!40000 ALTER TABLE `mst_zone_comm_rate` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `trans_commission_payout`
--

DROP TABLE IF EXISTS `trans_commission_payout`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `trans_commission_payout` (
  `Payout_Id` int NOT NULL AUTO_INCREMENT,
  `Payout_Type` tinyint NOT NULL,
  `Ref_Id` smallint NOT NULL,
  `Ref_Name` varchar(100) NOT NULL,
  `From_Date` date NOT NULL,
  `To_Date` date NOT NULL,
  `Total_Comm` decimal(8,2) NOT NULL,
  `Paid_Amt` decimal(8,2) NOT NULL,
  `Due_Amt` decimal(8,2) NOT NULL,
  `Pay_Mode` tinyint DEFAULT NULL,
  `Pay_Date` date NOT NULL,
  `Remarks` varchar(150) DEFAULT NULL,
  `Created_By` smallint NOT NULL,
  `Created_On` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`Payout_Id`)
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `trans_commission_payout`
--

LOCK TABLES `trans_commission_payout` WRITE;
/*!40000 ALTER TABLE `trans_commission_payout` DISABLE KEYS */;
INSERT INTO `trans_commission_payout` VALUES (24,2,42,'probodh roy','2026-07-23','2026-07-23',3570.00,3570.00,0.00,2,'2026-07-23',NULL,1,'2026-07-23 10:41:59');
/*!40000 ALTER TABLE `trans_commission_payout` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `trans_cust_status`
--

DROP TABLE IF EXISTS `trans_cust_status`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `trans_cust_status` (
  `Sl` int NOT NULL AUTO_INCREMENT,
  `Cust_Id` int DEFAULT NULL,
  `Status_Cd` int DEFAULT NULL,
  `AsOn_Date` date DEFAULT NULL,
  `Created_By` smallint DEFAULT NULL,
  `Created_On` datetime DEFAULT NULL,
  PRIMARY KEY (`Sl`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `trans_cust_status`
--

LOCK TABLES `trans_cust_status` WRITE;
/*!40000 ALTER TABLE `trans_cust_status` DISABLE KEYS */;
/*!40000 ALTER TABLE `trans_cust_status` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `trans_othercoll`
--

DROP TABLE IF EXISTS `trans_othercoll`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `trans_othercoll` (
  `Coll_Id` int NOT NULL AUTO_INCREMENT,
  `Coll_Date` date DEFAULT NULL,
  `Cust_Id` int DEFAULT NULL,
  `Purp_Id` smallint DEFAULT NULL,
  `Coll_Amount` decimal(8,2) DEFAULT NULL,
  `Coll_Mode` tinyint DEFAULT NULL,
  `Receipt_No` int DEFAULT NULL,
  `Particulars` varchar(150) DEFAULT NULL,
  `Counter_Id` smallint DEFAULT NULL,
  `Created_By` smallint DEFAULT NULL,
  `Created_On` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`Coll_Id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `trans_othercoll`
--

LOCK TABLES `trans_othercoll` WRITE;
/*!40000 ALTER TABLE `trans_othercoll` DISABLE KEYS */;
/*!40000 ALTER TABLE `trans_othercoll` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `trans_ott_cust`
--

DROP TABLE IF EXISTS `trans_ott_cust`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `trans_ott_cust` (
  `Conn_Id` int NOT NULL AUTO_INCREMENT,
  `Cust_Id` int DEFAULT NULL,
  `Issue_Date` date DEFAULT NULL,
  `OTT_Id` smallint DEFAULT NULL,
  `Pack_Amt` decimal(8,2) DEFAULT NULL,
  `Gst_Amt` decimal(5,2) DEFAULT NULL,
  `Tot_Amt` decimal(8,2) DEFAULT NULL,
  `Created_By` smallint DEFAULT NULL,
  `Created_On` datetime DEFAULT CURRENT_TIMESTAMP,
  `Is_Active` bit(1) DEFAULT NULL,
  PRIMARY KEY (`Conn_Id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `trans_ott_cust`
--

LOCK TABLES `trans_ott_cust` WRITE;
/*!40000 ALTER TABLE `trans_ott_cust` DISABLE KEYS */;
/*!40000 ALTER TABLE `trans_ott_cust` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `trans_rectify`
--

DROP TABLE IF EXISTS `trans_rectify`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `trans_rectify` (
  `Rectify_Id` bigint NOT NULL AUTO_INCREMENT,
  `Rec_Date` date DEFAULT NULL,
  `Rec_From` smallint DEFAULT NULL COMMENT '1: Customer Update; 2: Customer Delete; 3: Collection Update; 4: Collection Delete; 5: Misc',
  `Rec_Id` bigint DEFAULT NULL,
  `Remarks` varchar(255) DEFAULT NULL,
  `Created_By` smallint DEFAULT NULL,
  `Created_On` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`Rectify_Id`)
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `trans_rectify`
--

LOCK TABLES `trans_rectify` WRITE;
/*!40000 ALTER TABLE `trans_rectify` DISABLE KEYS */;
/*!40000 ALTER TABLE `trans_rectify` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `trans_renewal`
--

DROP TABLE IF EXISTS `trans_renewal`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `trans_renewal` (
  `Renewal_Id` bigint NOT NULL AUTO_INCREMENT,
  `Cust_Id` int DEFAULT NULL,
  `Demand_Date` date DEFAULT NULL,
  `Inv_No` varchar(200) DEFAULT NULL,
  `Plan_Id` smallint DEFAULT NULL,
  `Renew_Mnth` smallint DEFAULT NULL,
  `Renew_From` date DEFAULT NULL,
  `Renew_Upto` date DEFAULT NULL,
  `Renew_Amt` decimal(8,2) DEFAULT NULL,
  `OTT_Amt` decimal(8,2) DEFAULT NULL,
  `GST_Amt` decimal(8,2) DEFAULT NULL,
  `Total_Amount` decimal(8,2) DEFAULT NULL,
  `Pay_Status` tinyint DEFAULT NULL COMMENT '1: Paid; 2: Unpaid',
  `Receipt_Date` date DEFAULT NULL,
  `Receipt_No` varchar(200) DEFAULT NULL,
  `Receipt_Mode` tinyint DEFAULT NULL,
  `Disc_Amount` decimal(8,2) DEFAULT NULL,
  `Receipt_Amt` decimal(8,2) DEFAULT NULL,
  `Due_Amt` decimal(8,2) DEFAULT NULL,
  `Counter_Id` smallint DEFAULT NULL,
  `Payment_Detls` varchar(75) DEFAULT NULL,
  `Counter_Comm` decimal(8,2) DEFAULT '0.00',
  `Counter_Comm_Paid` tinyint DEFAULT '0',
  `Zone_Comm` decimal(8,2) DEFAULT '0.00',
  `Zone_Comm_Paid` tinyint DEFAULT '0',
  `Created_By` smallint DEFAULT NULL,
  `Created_On` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`Renewal_Id`)
) ENGINE=InnoDB AUTO_INCREMENT=282 DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `trans_renewal`
--

LOCK TABLES `trans_renewal` WRITE;
/*!40000 ALTER TABLE `trans_renewal` DISABLE KEYS */;
INSERT INTO `trans_renewal` VALUES (275,201,'2026-08-05','INV-202608-0001',38,30,'2026-08-12','2026-09-10',1500.00,0.00,270.00,1770.00,2,'2026-08-05','BILL-202608-0001',3,0.00,1770.00,0.00,12,NULL,48.75,0,150.00,0,21,'2026-08-05 10:04:50'),(276,201,'2026-08-05','INV-202609-0001',38,30,'2026-09-11','2026-10-10',1500.00,0.00,270.00,1770.00,2,'2026-08-05','BILL-202608-0002',4,0.00,1770.00,0.00,10,NULL,48.75,0,150.00,0,24,'2026-08-05 10:13:22'),(277,201,'2026-08-05','INV-202610-0001',66,70,'2026-10-11','2026-12-19',800.00,0.00,50.00,850.00,2,'2026-08-05','BILL-202608-0003',3,0.00,850.00,0.00,NULL,NULL,0.00,0,0.00,0,1,'2026-08-05 10:17:19'),(278,202,'2026-09-04','INV-202608-0002',67,30,'2026-08-01','2026-08-30',200.00,0.00,2.00,202.00,2,'2026-09-04','BILL-202609-0001',1,0.00,202.00,0.00,10,NULL,6.50,0,20.00,0,1,'2026-09-04 16:48:01'),(279,203,'2026-09-04','INV-202609-0002',68,30,'2026-09-04','2026-10-03',200.00,0.00,10.00,210.00,2,'2026-09-04','BILL-202609-0002',2,0.00,210.00,0.00,NULL,NULL,0.00,0,0.00,0,1,'2026-09-04 17:11:35'),(280,202,'2026-09-04','INV-202608-0003',67,30,'2026-08-31','2026-09-29',200.00,0.00,2.00,202.00,1,NULL,NULL,NULL,NULL,NULL,202.00,10,NULL,0.00,0,20.00,0,21,'2026-09-04 17:32:49'),(281,202,'2026-09-04','INV-202609-0003',67,30,'2026-09-30','2026-10-29',200.00,0.00,2.00,202.00,1,NULL,NULL,NULL,NULL,NULL,202.00,10,NULL,0.00,0,20.00,0,21,'2026-09-04 17:32:55');
/*!40000 ALTER TABLE `trans_renewal` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `trans_zone_comm`
--

DROP TABLE IF EXISTS `trans_zone_comm`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `trans_zone_comm` (
  `Id` bigint NOT NULL AUTO_INCREMENT,
  `Zone_Id` smallint DEFAULT NULL,
  `Cust_Id` int DEFAULT NULL,
  `For_Mnth` tinyint DEFAULT NULL,
  `For_Year` smallint DEFAULT NULL,
  `Coll_Amt` decimal(8,2) DEFAULT NULL,
  `Comm_Amt` decimal(5,2) DEFAULT NULL,
  `Is_Paid` bit(1) DEFAULT NULL,
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `trans_zone_comm`
--

LOCK TABLES `trans_zone_comm` WRITE;
/*!40000 ALTER TABLE `trans_zone_comm` DISABLE KEYS */;
/*!40000 ALTER TABLE `trans_zone_comm` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping routines for database 'prioisp_nsl'
--
/*!50003 DROP PROCEDURE IF EXISTS `usp_collectPayment` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_0900_ai_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`priority`@`%` PROCEDURE `usp_collectPayment`(
    IN pRenewalIds   TEXT,
    IN pCustId       INT,
    IN pReceiptDate  DATE,
    IN pModeId       TINYINT,
    IN pDiscount     DECIMAL(8,2),
    IN pNetAmt       DECIMAL(8,2),
    IN pCollectedBy  INT,
    IN pCounterId    SMALLINT
)
BEGIN
    DECLARE vDone          INT DEFAULT 0;
    DECLARE vRenewalId     INT;
    DECLARE vTotalAmt      DECIMAL(8,2);
    DECLARE vRowDisc       DECIMAL(8,2);
    DECLARE vRowReceipt    DECIMAL(8,2);
    DECLARE vGrandTotal    DECIMAL(8,2) DEFAULT 0;
    DECLARE vDiscLeft      DECIMAL(8,2);
    DECLARE vRowCount      INT DEFAULT 0;
    DECLARE vCurrentRow    INT DEFAULT 0;
    DECLARE vRemainingDue  DECIMAL(8,2);
    DECLARE vBillNo        VARCHAR(20);
    DECLARE vLastBillSeq   INT;
    DECLARE vBillYearMonth VARCHAR(6);
    DECLARE vBasicAmt      DECIMAL(8,2);
    DECLARE vCounterComm   DECIMAL(8,2);

    DECLARE cur CURSOR FOR
        SELECT Renewal_Id, Total_Amount
        FROM trans_renewal
        WHERE FIND_IN_SET(Renewal_Id, pRenewalIds)
        ORDER BY Renewal_Id ASC;

    DECLARE CONTINUE HANDLER FOR NOT FOUND SET vDone = 1;

    SET vBillYearMonth = DATE_FORMAT(pReceiptDate, '%Y%m');

    SELECT COALESCE(MAX(CAST(SUBSTRING_INDEX(Receipt_No, '-', -1) AS UNSIGNED)), 0)
    INTO vLastBillSeq
    FROM trans_renewal
    WHERE Receipt_No LIKE CONCAT('BILL-', vBillYearMonth, '-%');

    SET vBillNo = CONCAT('BILL-', vBillYearMonth, '-', LPAD(vLastBillSeq + 1, 4, '0'));

    SELECT COALESCE(SUM(Total_Amount), 0)
    INTO vGrandTotal
    FROM trans_renewal
    WHERE FIND_IN_SET(Renewal_Id, pRenewalIds);

    SELECT COUNT(*) INTO vRowCount
    FROM trans_renewal
    WHERE FIND_IN_SET(Renewal_Id, pRenewalIds);

    SET vDiscLeft = pDiscount;

    OPEN cur;
    read_loop: LOOP
        FETCH cur INTO vRenewalId, vTotalAmt;
        IF vDone THEN LEAVE read_loop; END IF;

        SET vCurrentRow = vCurrentRow + 1;

        IF vCurrentRow = vRowCount THEN
            SET vRowDisc = vDiscLeft;
        ELSE
            SET vRowDisc  = ROUND((vTotalAmt / vGrandTotal) * pDiscount, 2);
            SET vDiscLeft = vDiscLeft - vRowDisc;
        END IF;

        SET vRowReceipt = vTotalAmt - vRowDisc;

        SELECT Renew_Amt INTO vBasicAmt FROM trans_renewal WHERE Renewal_Id = vRenewalId;
        SET vCounterComm = CASE WHEN pCounterId IS NULL THEN 0.00
                           ELSE ROUND(vBasicAmt * 0.65 * 0.05, 2)
                           END;

        UPDATE trans_renewal
        SET Pay_Status   = 2,
            Due_Amt      = 0,
            Receipt_No   = vBillNo,
            Receipt_Date = pReceiptDate,
            Receipt_Mode = pModeId,
            Disc_Amount  = vRowDisc,
            Receipt_Amt  = vRowReceipt,
            Counter_Id   = pCounterId,
            Counter_Comm = vCounterComm
        WHERE Renewal_Id = vRenewalId;

    END LOOP;
    CLOSE cur;

    SELECT COALESCE(SUM(Due_Amt), 0)
    INTO vRemainingDue
    FROM trans_renewal
    WHERE Cust_Id = pCustId AND Pay_Status != 2;

    UPDATE mst_customer
    SET Due_Amount = vRemainingDue,
        Status     = 1,
        Last_PayDt = pReceiptDate
    WHERE Cust_Id = pCustId;

    SELECT
        r.Receipt_No, r.Receipt_Date, r.Receipt_Amt,
        r.Renew_From, r.Renew_Upto, r.Disc_Amount,
        c.Cust_Name, c.Account_No, c.User_Id,
        c.Cust_Code,
        c.Billing_Address,
        p.Package_Name,
        m.Mode AS Pay_Mode
    FROM trans_renewal r
    INNER JOIN mst_customer c ON c.Cust_Id = r.Cust_Id
    INNER JOIN mst_package  p ON p.Package_Id = r.Plan_Id
    LEFT  JOIN mst_mode     m ON m.Mode_Id = r.Receipt_Mode
    WHERE FIND_IN_SET(r.Renewal_Id, pRenewalIds)
    ORDER BY r.Renewal_Id ASC;

    SELECT 0 AS Error_No, 'Payment collected successfully.' AS Message;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `usp_CommissionPayout` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_0900_ai_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`priority`@`%` PROCEDURE `usp_CommissionPayout`(
    IN pAction    TINYINT,
    IN pType      TINYINT,
    IN pRefId     SMALLINT,
    IN pRefName   VARCHAR(100),
    IN pFromDate  DATE,
    IN pToDate    DATE,
    IN pTotalComm DECIMAL(8,2),
    IN pPaidAmt   DECIMAL(8,2),
    IN pPayMode   TINYINT,
    IN pPayDate   DATE,
    IN pRemarks   VARCHAR(150),
    IN pCreatedBy SMALLINT
)
BEGIN
    DECLARE vDueAmt DECIMAL(8,2);

    IF pAction = 1 THEN
        IF pType = 1 THEN
            SELECT
                COALESCE(SUM(r.Counter_Comm), 0) AS Total_Comm,
                CASE WHEN COALESCE(SUM(r.Counter_Comm), 0) > 0
                     THEN COALESCE((SELECT SUM(Paid_Amt) FROM trans_commission_payout
                                    WHERE Payout_Type = 1 AND Ref_Id = pRefId AND Due_Amt > 0), 0)
                     ELSE 0
                END AS Paid_Comm,
                CASE WHEN COALESCE(SUM(r.Counter_Comm), 0) > 0
                     THEN GREATEST(COALESCE(SUM(r.Counter_Comm), 0) -
                                   COALESCE((SELECT SUM(Paid_Amt) FROM trans_commission_payout
                                             WHERE Payout_Type = 1 AND Ref_Id = pRefId AND Due_Amt > 0), 0), 0)
                     ELSE 0
                END AS Due_Comm,
                MIN(CASE WHEN r.Counter_Comm_Paid=0 THEN r.Receipt_Date END) AS From_Date,
                MAX(CASE WHEN r.Counter_Comm_Paid=0 THEN r.Receipt_Date END) AS To_Date
            FROM trans_renewal r
            WHERE r.Pay_Status        = 2
              AND r.Counter_Id        = pRefId
              AND r.Counter_Comm_Paid = 0;
        ELSE
            SELECT
                COALESCE(SUM(r.Zone_Comm), 0) AS Total_Comm,
                CASE WHEN COALESCE(SUM(r.Zone_Comm), 0) > 0
                     THEN COALESCE((SELECT SUM(Paid_Amt) FROM trans_commission_payout
                                    WHERE Payout_Type = 2 AND Ref_Id = pRefId AND Due_Amt > 0), 0)
                     ELSE 0
                END AS Paid_Comm,
                CASE WHEN COALESCE(SUM(r.Zone_Comm), 0) > 0
                     THEN GREATEST(COALESCE(SUM(r.Zone_Comm), 0) -
                                   COALESCE((SELECT SUM(Paid_Amt) FROM trans_commission_payout
                                             WHERE Payout_Type = 2 AND Ref_Id = pRefId AND Due_Amt > 0), 0), 0)
                     ELSE 0
                END AS Due_Comm,
                MIN(CASE WHEN r.Zone_Comm_Paid=0 THEN r.Receipt_Date END) AS From_Date,
                MAX(CASE WHEN r.Zone_Comm_Paid=0 THEN r.Receipt_Date END) AS To_Date
            FROM trans_renewal r
            INNER JOIN mst_customer c ON c.Cust_Id = r.Cust_Id
            WHERE r.Pay_Status     = 2
              AND c.Zone_Id        = pRefId
              AND r.Zone_Comm_Paid = 0;
        END IF;

    ELSEIF pAction = 2 THEN
        SET vDueAmt = pTotalComm - pPaidAmt;

        INSERT INTO trans_commission_payout (
            Payout_Type, Ref_Id, Ref_Name,
            From_Date, To_Date,
            Total_Comm, Paid_Amt, Due_Amt,
            Pay_Mode, Pay_Date, Remarks,
            Created_By, Created_On
        ) VALUES (
            pType, pRefId, pRefName,
            pFromDate, pToDate,
            pTotalComm, pPaidAmt, vDueAmt,
            pPayMode, pPayDate, pRemarks,
            pCreatedBy, CURRENT_TIMESTAMP
        );

        IF vDueAmt <= 0 THEN
            IF pType = 1 THEN
                UPDATE trans_renewal
                SET Counter_Comm_Paid = 1
                WHERE Pay_Status        = 2
                  AND Counter_Id        = pRefId
                  AND Receipt_Date      BETWEEN pFromDate AND pToDate
                  AND Counter_Comm_Paid = 0;
            ELSE
                UPDATE trans_renewal r
                INNER JOIN mst_customer c ON c.Cust_Id = r.Cust_Id
                SET r.Zone_Comm_Paid = 1
                WHERE r.Pay_Status    = 2
                  AND c.Zone_Id       = pRefId
                  AND r.Receipt_Date  BETWEEN pFromDate AND pToDate
                  AND r.Zone_Comm_Paid = 0;
            END IF;
        END IF;

        SELECT 0 AS Error_No, 'Commission payout saved successfully.' AS Message;

    ELSEIF pAction = 3 THEN
        SELECT
            p.Payout_Id,
            CASE p.Payout_Type WHEN 1 THEN 'Counter' WHEN 2 THEN 'Zone' END AS Type,
            p.Ref_Name,
            p.From_Date, p.To_Date,
            p.Total_Comm, p.Paid_Amt, p.Due_Amt,
            m.Mode AS Pay_Mode,
            p.Pay_Date,
            p.Remarks,
            p.Created_On
        FROM trans_commission_payout p
        LEFT JOIN mst_mode m ON m.Mode_Id = p.Pay_Mode
        WHERE (pType  = 0 OR p.Payout_Type = pType)
          AND (pRefId = 0 OR p.Ref_Id      = pRefId)
        ORDER BY p.Created_On DESC;

    END IF;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `usp_deleteCounter` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_0900_ai_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`priority`@`%` PROCEDURE `usp_deleteCounter`(
    IN pCounterId SMALLINT
)
BEGIN
    DECLARE vLinkedCustomer INT DEFAULT 0;
    DECLARE vLinkedUser     INT DEFAULT 0;

    SELECT COUNT(*) INTO vLinkedCustomer 
    FROM mst_customer WHERE Counter_Id = pCounterId;

    SELECT COUNT(*) INTO vLinkedUser 
    FROM mst_user WHERE Counter_Id = pCounterId;

    IF vLinkedCustomer > 0 THEN
        SELECT -1 AS Error_No, 'Cannot delete. Counter has linked customers.' AS Message;
    ELSEIF vLinkedUser > 0 THEN
        SELECT -1 AS Error_No, 'Cannot delete. Counter is assigned to a user.' AS Message;
    ELSE
        DELETE FROM mst_counter WHERE Counter_Id = pCounterId;
        SELECT 0 AS Error_No, 'Counter deleted successfully.' AS Message;
    END IF;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `usp_deleteCustomer` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_0900_ai_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`priority`@`%` PROCEDURE `usp_deleteCustomer`(
    IN pCustId INT
)
BEGIN
    DECLARE vLinkedRenewal INT DEFAULT 0;

    SELECT COUNT(*) INTO vLinkedRenewal
    FROM trans_renewal WHERE Cust_Id = pCustId;

    IF vLinkedRenewal > 0 THEN
        DELETE FROM trans_renewal WHERE Cust_Id = pCustId;
    END IF;

    DELETE FROM mst_customer WHERE Cust_Id = pCustId;
    SELECT 0 AS Error_No, 'Customer deleted successfully.' AS Message;

END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `usp_deleteUser` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_0900_ai_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`priority`@`%` PROCEDURE `usp_deleteUser`(
    IN p_User_Id INT
)
BEGIN
    DECLARE vCounterId      SMALLINT DEFAULT 0;
    DECLARE vLinkedCollection INT DEFAULT 0;

    SELECT Counter_Id INTO vCounterId
    FROM mst_user WHERE User_Id = p_User_Id;

    SELECT COUNT(*) INTO vLinkedCollection
    FROM trans_renewal WHERE Counter_Id = vCounterId;

    IF vLinkedCollection > 0 THEN
        SELECT -1 AS Error_No, 'Cannot delete. User has linked collection records.' AS Message;
    ELSE
        DELETE FROM mst_counter_user WHERE User_Id = p_User_Id;
        DELETE FROM mst_user WHERE User_Id = p_User_Id;
        SELECT 0 AS Error_No, 'User deleted successfully.' AS Message;
    END IF;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `usp_deleteZone` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_0900_ai_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`priority`@`%` PROCEDURE `usp_deleteZone`(
    IN pZoneId SMALLINT
)
BEGIN
    DECLARE vLinkedCustomer INT DEFAULT 0;

    SELECT COUNT(*) INTO vLinkedCustomer 
    FROM mst_customer WHERE Zone_Id = pZoneId;

    IF vLinkedCustomer > 0 THEN
        SELECT -1 AS Error_No, 'Cannot delete. Zone has linked customers.' AS Message;
    ELSE
        DELETE FROM mst_zone WHERE Zone_Id = pZoneId;
        SELECT 0 AS Error_No, 'Zone deleted successfully.' AS Message;
    END IF;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `usp_exportCustomers` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_0900_ai_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`priority`@`%` PROCEDURE `usp_exportCustomers`(
    IN pStatus    TINYINT,
    IN pCustName  VARCHAR(250),
    IN pWildcard  VARCHAR(100),
    IN pPayStatus TINYINT,
    IN pPackageId SMALLINT,
    IN pCounterId SMALLINT,
    IN pZoneId    SMALLINT,
    IN pFromDate  DATE,
    IN pToDate    DATE
)
BEGIN
    SELECT
        c.Cust_Code, c.Cust_Name, c.Join_Date, c.User_Id,
        c.Account_No, c.Contact_No, c.Mail_Id, c.IP_Addrs,
        p.Package_Name AS Package, c.Renew_From,
        c.Renew_Upto AS Exp_Date, c.Status,
        CASE WHEN c.Due_Amount > 0 THEN 'Unpaid' ELSE 'Paid' END AS Payment_Status
    FROM mst_customer c
    INNER JOIN mst_package p ON p.Package_Id = c.Package_Id
    WHERE
        (pStatus    IS NULL OR c.Status     = pStatus)
    AND (pCustName  IS NULL OR c.Cust_Name  LIKE CONCAT('%', pCustName, '%'))
    AND (pWildcard  IS NULL OR c.User_Id    LIKE CONCAT('%', pWildcard, '%')
                            OR c.Account_No LIKE CONCAT('%', pWildcard, '%')
                            OR c.Contact_No LIKE CONCAT('%', pWildcard, '%')
                            OR c.Cust_Code  LIKE CONCAT('%', pWildcard, '%'))
    AND (pPayStatus IS NULL OR (pPayStatus = 2 AND c.Due_Amount = 0)
                            OR (pPayStatus = 1 AND c.Due_Amount > 0))
    AND (pPackageId IS NULL OR c.Package_Id = pPackageId)
    AND (pCounterId IS NULL OR c.Counter_Id = pCounterId)
    AND (pZoneId    IS NULL OR c.Zone_Id    = pZoneId)
    AND (pFromDate  IS NULL OR DATE(c.Join_Date) >= pFromDate)
    AND (pToDate    IS NULL OR DATE(c.Join_Date) <= pToDate)
    ORDER BY c.Cust_Code;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `usp_generateDemandManual` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_0900_ai_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`priority`@`%` PROCEDURE `usp_generateDemandManual`(
    IN pCustId      INT,
    IN pRenewFrom   DATE,
    IN pRenewUpto   DATE,
    IN pCreatedBy   INT,
    IN pHomeCounter SMALLINT,
    IN pPackageId   SMALLINT
)
BEGIN
    DECLARE vPlanId    SMALLINT;
    DECLARE vBasicAmt  DECIMAL(8,2);
    DECLARE vGstAmt    DECIMAL(8,2);
    DECLARE vTotalAmt  DECIMAL(8,2);
    DECLARE vPlanDays  INT;
    DECLARE vInvNo     VARCHAR(20);
    DECLARE vLastSeq   INT;
    DECLARE vYearMonth VARCHAR(6);
    -- ADD: new variables for zone commission
    DECLARE vZoneComm  DECIMAL(8,2) DEFAULT 0.00;
    DECLARE vCommPct   DECIMAL(5,2) DEFAULT 0.00;

    DECLARE EXIT HANDLER FOR SQLEXCEPTION
    BEGIN
        ROLLBACK;
        SELECT -1 AS Error_No, 'Database error occurred.' AS Message;
    END;

    IF (SELECT COUNT(*) FROM trans_renewal WHERE Cust_Id = pCustId AND Pay_Status = 1) >= 2 THEN
        SELECT -2 AS Error_No, 'Customer has 2 unpaid demands. Please clear previous demands first.' AS Message;


    ELSEIF COALESCE(pPackageId, 0) != 0 AND
           pPackageId != (SELECT Package_Id FROM mst_customer WHERE Cust_Id = pCustId) AND
           (SELECT COUNT(*) FROM trans_renewal WHERE Cust_Id = pCustId AND Pay_Status = 1) >= 2 THEN
        SELECT -3 AS Error_No, 'Cannot change package. Customer has 2 unpaid demands.' AS Message;

    ELSE
        START TRANSACTION;

        IF COALESCE(pPackageId, 0) = 0 THEN
            SELECT Package_Id INTO vPlanId FROM mst_customer WHERE Cust_Id = pCustId;
        ELSE
            SET vPlanId = pPackageId;
        END IF;

        SELECT Basic_Amt, GST_Amt, Total_Amt, Plan_Days
        INTO vBasicAmt, vGstAmt, vTotalAmt, vPlanDays
        FROM mst_package WHERE Package_Id = vPlanId;

	
     IF (SELECT COALESCE(Comm_Amt, 1) FROM mst_package WHERE Package_Id = vPlanId) = 0 THEN
       SET vZoneComm = 0.00;
    ELSE
     SELECT COALESCE(z.Comm_Pct, 0)
     INTO vCommPct
     FROM mst_customer c
     LEFT JOIN mst_zone z ON z.Zone_Id = c.Zone_Id
     WHERE c.Cust_Id = pCustId;
     SET vZoneComm = ROUND(vBasicAmt * vCommPct / 100, 2);
END IF;


        SET vYearMonth = DATE_FORMAT(pRenewFrom, '%Y%m');

        SELECT COALESCE(MAX(CAST(SUBSTRING_INDEX(Inv_No, '-', -1) AS UNSIGNED)), 0)
        INTO vLastSeq
        FROM trans_renewal
        WHERE Inv_No LIKE CONCAT('INV-', vYearMonth, '-%');

        SET vInvNo = CONCAT('INV-', vYearMonth, '-', LPAD(vLastSeq + 1, 4, '0'));

        -- CHANGE: added Zone_Comm to INSERT columns and vZoneComm to VALUES
        INSERT INTO trans_renewal (
            Cust_Id, Demand_Date, Plan_Id, Renew_Mnth,
            Renew_From, Renew_Upto, Renew_Amt, OTT_Amt,
            GST_Amt, Total_Amount, Pay_Status, Due_Amt, Inv_No, Counter_Id,
            Zone_Comm, Created_By, Created_On
        ) VALUES (
            pCustId, CURRENT_DATE(), vPlanId, vPlanDays,
            pRenewFrom, pRenewUpto, vBasicAmt, 0,
            vGstAmt, vTotalAmt, 1, vTotalAmt, vInvNo, pHomeCounter,
            vZoneComm, pCreatedBy, NOW()
        );

        UPDATE mst_customer
        SET Renew_From   = pRenewFrom,
            Renew_Upto   = pRenewUpto,
            Due_Amount   = Due_Amount + vTotalAmt,
            Package_Id   = vPlanId,
            Plan_Amount  = vBasicAmt,
            GST          = vGstAmt,
            Total_Amount = vTotalAmt
        WHERE Cust_Id = pCustId;

        COMMIT;

        SELECT 0 AS Error_No, CONCAT('Demand generated: ', vInvNo) AS Message;
    END IF;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `usp_getActionMenus` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_0900_ai_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`priority`@`%` PROCEDURE `usp_getActionMenus`()
BEGIN
    SELECT
        SubMenu_Id,
        SubMenu_Name
    FROM mst_menus
    WHERE Menu_Id = 11
    AND SubMenu_Id IS NOT NULL
    ORDER BY SubMenu_Id;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `usp_getCommissionRegisterDetail` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_0900_ai_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`priority`@`%` PROCEDURE `usp_getCommissionRegisterDetail`(
    IN p_from_date DATE,
    IN p_to_date   DATE,
    IN p_zone_id   INT
)
BEGIN
    SELECT
        tr.Demand_Date                  AS Coll_Date,   -- CHANGED: Demand_Date instead of Receipt_Date
        mc.Cust_Code,
        mc.Cust_Name,
        mp.Package_Name                 AS Package,
        tr.Renew_Amt                    AS Basic_Amt,
        tr.Total_Amount                 AS Ren_Amt,
        tr.Receipt_Amt                  AS Coll_Amt,
        mz.Comm_Pct,
        tr.Zone_Comm                    AS Comm_Amt     -- CHANGED: use stored Zone_Comm instead of recalculating
    FROM trans_renewal tr
    INNER JOIN mst_customer mc ON mc.Cust_Id    = tr.Cust_Id
    LEFT JOIN  mst_zone     mz ON mz.Zone_Id    = mc.Zone_Id
    LEFT JOIN  mst_package  mp ON mp.Package_Id = tr.Plan_Id
    WHERE tr.Demand_Date BETWEEN p_from_date AND p_to_date  -- CHANGED: Demand_Date instead of Receipt_Date
      AND (p_zone_id IS NULL OR mc.Zone_Id = p_zone_id)
    ORDER BY tr.Demand_Date, mc.Cust_Code;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `usp_getCommissionRegisterSummary` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_0900_ai_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`priority`@`%` PROCEDURE `usp_getCommissionRegisterSummary`(
    IN p_from_date DATE,
    IN p_to_date   DATE
)
BEGIN
    SELECT
        mz.Zone_Cd       AS Zone_Name,
        mz.LCO_Name,
        mz.Operator_Name,
        SUM(tr.Receipt_Amt)    AS Coll_Amount,
        mz.Comm_Pct            AS Comm_Pct,
        SUM(tr.Zone_Comm)      AS Comm_Amount  -- CHANGED: use stored Zone_Comm instead of recalculating
    FROM trans_renewal tr
    INNER JOIN mst_customer mc ON mc.Cust_Id = tr.Cust_Id
    LEFT JOIN  mst_zone     mz ON mz.Zone_Id = mc.Zone_Id
    WHERE tr.Demand_Date BETWEEN p_from_date AND p_to_date  -- CHANGED: Demand_Date instead of Receipt_Date
    GROUP BY mz.Zone_Id, mz.Zone_Cd, mz.LCO_Name, mz.Operator_Name, mz.Comm_Pct
    ORDER BY mz.Zone_Cd;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `usp_getCounter` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_0900_ai_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `usp_getCounter`(IN CntId SMALLINT)
BEGIN
    SELECT
        Counter_Id       AS Id,
        Counter_Name     AS Name,
        Counter_Address,
        Contact_No,
        Email_Id,
        Is_Active,
        Created_Date
    FROM mst_counter
    WHERE (CntId = 0 OR Counter_Id = CntId)
    ORDER BY Counter_Id;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `usp_getCounterCommissionRegister` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_0900_ai_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`priority`@`%` PROCEDURE `usp_getCounterCommissionRegister`(
    IN pFromDate   DATE,
    IN pToDate     DATE,
    IN pCounterId  SMALLINT
)
BEGIN
    SELECT
        c.Cust_Code,
        c.Cust_Name,
        r.Receipt_Date                               AS Coll_Date,
        r.Renew_Amt                                  AS Basic_Amt,
        r.Receipt_Amt                                AS Coll_Amt,
       r.Counter_Comm   AS Comm_Amt
    FROM trans_renewal r
    INNER JOIN mst_customer c ON c.Cust_Id = r.Cust_Id
    WHERE r.Pay_Status   = 2
      AND r.Receipt_Date BETWEEN pFromDate AND pToDate
      AND r.Counter_Id   = pCounterId
    ORDER BY r.Receipt_Date, r.Renewal_Id;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `usp_getCounterWiseCollection` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_0900_ai_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`priority`@`%` PROCEDURE `usp_getCounterWiseCollection`(
    IN pFromDate   DATE,
    IN pToDate     DATE,
    IN pCounterId  SMALLINT
)
BEGIN
    SELECT
        ROW_NUMBER() OVER (ORDER BY m.Mode_Id) AS Sl_No,
        m.Mode                                  AS Payment_Mode,
        COALESCE(SUM(r.Receipt_Amt), 0)         AS Total_Amount
    FROM mst_mode m
    LEFT JOIN trans_renewal r
        ON r.Receipt_Mode = m.Mode_Id
        AND r.Pay_Status = 2
        AND DATE(r.Receipt_Date) BETWEEN pFromDate AND pToDate
        AND r.Counter_Id = pCounterId
    WHERE m.Is_Active = 1
    GROUP BY m.Mode_Id, m.Mode
    ORDER BY m.Mode_Id;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `usp_getCustomerCounts` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_0900_ai_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`priority`@`%` PROCEDURE `usp_getCustomerCounts`(IN p_Counter_Id INT)
BEGIN
    SELECT
        COUNT(*)                                     AS Total,
        SUM(CASE WHEN Status = 1 THEN 1 ELSE 0 END) AS Active,
        SUM(CASE WHEN Status = 2 THEN 1 ELSE 0 END) AS InActive,
		SUM(CASE WHEN Status = 3 THEN 1 ELSE 0 END) AS Suspended,
        SUM(CASE WHEN Status = 4 THEN 1 ELSE 0 END) AS Disabled
    FROM mst_customer
    WHERE (p_Counter_Id = 0 OR Counter_Id = p_Counter_Id);
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `usp_getCustomerLedger` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_0900_ai_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`priority`@`%` PROCEDURE `usp_getCustomerLedger`(
    IN pAccount   VARCHAR(75),
    IN pUserId    VARCHAR(75),
    IN pCode      VARCHAR(50),
    IN pName      VARCHAR(250),
     IN pPhone     VARCHAR(20),
    IN pCounterId SMALLINT
)
BEGIN
    SELECT
        c.Cust_Id,
        c.Cust_Name,
        c.User_Id,
        c.Contact_No,
        c.Billing_Address,
        p.Package_Name AS Plan_Name,
         z.Zone_Cd      AS Zone_Cd     
    FROM mst_customer c
    JOIN mst_package p ON p.Package_Id = c.Package_Id
    LEFT JOIN mst_zone z ON z.Zone_Id = c.Zone_Id
    WHERE 
      (pAccount IS NULL OR c.Account_No = pAccount)
      AND (pUserId  IS NULL OR c.User_Id    = pUserId)
      AND (pCode    IS NULL OR c.Cust_Code  = pCode)
      AND (pName    IS NULL OR c.Cust_Name  LIKE CONCAT('%', pName, '%'))
        AND (pPhone   IS NULL OR c.Contact_No LIKE CONCAT('%', pPhone, '%'));
   
    
    SELECT
        r.Renewal_Id,
        r.Inv_No,
        r.Receipt_No     AS Bill_No,
        r.Demand_Date,
        r.Renew_From,
        r.Renew_Upto,
        r.Total_Amount,
        r.Disc_Amount,
        r.Receipt_Amt    AS Pay_Amount,
        r.Due_Amt,
        r.Receipt_Date   AS Pay_Date,
       m.Mode          AS Receipt_Mode,
        CASE r.Pay_Status
            WHEN 1 THEN 'Unpaid'
            WHEN 2 THEN 'Paid'
            ELSE 'Unknown'
        END AS Pay_Status
    FROM trans_renewal r
    INNER JOIN mst_customer c ON c.Cust_Id = r.Cust_Id
    LEFT JOIN mst_mode m ON m.Mode_Id = r.Receipt_Mode
    WHERE 
       (pAccount IS NULL OR c.Account_No = pAccount)
      AND (pUserId  IS NULL OR c.User_Id    = pUserId)
      AND (pCode    IS NULL OR c.Cust_Code  = pCode)
      AND (pName    IS NULL OR c.Cust_Name  LIKE CONCAT('%', pName, '%'))
      AND (pPhone   IS NULL OR c.Contact_No LIKE CONCAT('%', pPhone, '%'))
    ORDER BY r.Renew_From ASC;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `usp_getCustomerRegister` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_0900_ai_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`priority`@`%` PROCEDURE `usp_getCustomerRegister`(
    IN pFromDate  DATE,
    IN pToDate    DATE,
    IN pStatus    TINYINT,
    IN pZoneId    SMALLINT,
    IN pCounterId SMALLINT
)
BEGIN
    SELECT
        ROW_NUMBER() OVER (ORDER BY c.Join_Date ASC) AS Sl_No,
        c.Cust_Id,
        c.Cust_Name,
        c.Contact_No,
        c.User_Id,
        c.Cust_Code     AS Client_Id,
        c.IP_Addrs      AS IP,
        p.Package_Name  AS Plan_Name,
        c.Renew_Upto    AS Valid_Upto,
        c.Join_Date,
        CASE c.Status
            WHEN 1 THEN 'Active'
            WHEN 2 THEN 'InActive'
            WHEN 3 THEN 'Suspended'
            ELSE 'Unknown'
        END AS Cust_Status
    FROM mst_customer c
    JOIN mst_package p ON p.Package_Id = c.Package_Id
    WHERE
        DATE(c.Join_Date) BETWEEN pFromDate AND pToDate
      AND (pStatus IS NULL OR c.Status  = pStatus)
      AND (pZoneId IS NULL OR c.Zone_Id = pZoneId)
    ORDER BY c.Join_Date ASC;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `usp_getCustomersAdmin` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_0900_ai_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`priority`@`%` PROCEDURE `usp_getCustomersAdmin`(
    IN p_Page INT,
    IN p_PageSize INT
)
BEGIN
    DECLARE v_Offset INT DEFAULT 0;

    SET p_Page = IFNULL(NULLIF(p_Page, 0), 1);
    SET p_PageSize = IFNULL(NULLIF(p_PageSize, 0), 25);
    SET v_Offset = (p_Page - 1) * p_PageSize;

    SELECT
        c.Cust_Id, c.Cust_Code, c.Cust_Name, c.Join_Date, c.Billing_Address,
        c.User_Id, c.Account_No, c.Contact_No, c.Mail_Id, c.IP_Addrs,
        c.Package_Id, p.Package_Name AS Package, c.Renew_From,
        c.Renew_Upto AS Exp_Date, c.Counter_Id, c.Zone_Id,
        c.Router_Dtls, c.Remarks, c.Status,
        CASE
            WHEN r.Pay_Status = 2 THEN 'Paid'
            WHEN r.Pay_Status = 1 THEN 'Unpaid'
            ELSE NULL
        END AS Payment_Status
    FROM mst_customer c
    INNER JOIN mst_package p ON p.Package_Id = c.Package_Id
    LEFT JOIN (
        SELECT Cust_Id, Pay_Status
        FROM trans_renewal
        WHERE Renewal_Id IN (
            SELECT MAX(Renewal_Id) FROM trans_renewal GROUP BY Cust_Id
        )
    ) r ON r.Cust_Id = c.Cust_Id
    ORDER BY c.Cust_Id
    LIMIT v_Offset, p_PageSize;

    SELECT COUNT(*) AS Total_Count
    FROM mst_customer c;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `usp_getDropdownList` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb3 */ ;
/*!50003 SET character_set_results = utf8mb3 */ ;
/*!50003 SET collation_connection  = utf8mb3_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_AUTO_VALUE_ON_ZERO' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `usp_getDropdownList`(IN PrmGrpCd Int)
    READS SQL DATA
BEGIN

SELECT
  Opt_Sl AS Id,
  Opt_Name AS IdVal
FROM mst_apploptions
WHERE Grp_Id = PrmGrpCd
AND IsActive
ORDER BY Opt_Id;

END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `usp_getLastBill` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_0900_ai_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`priority`@`%` PROCEDURE `usp_getLastBill`(
    IN pAccount   VARCHAR(50),
    IN pUserId    VARCHAR(50),
    IN pCode      VARCHAR(50),
    IN pCounterId SMALLINT
)
BEGIN
    SELECT
        r.Receipt_No, r.Receipt_Date, r.Receipt_Amt, r.Disc_Amount,
        r.Renew_From, r.Renew_Upto,
        c.Cust_Name, c.Account_No, c.User_Id,c.Cust_Code,
    c.Billing_Address,
        p.Package_Name, m.Mode AS Pay_Mode
    FROM trans_renewal r
    INNER JOIN mst_customer c ON c.Cust_Id    = r.Cust_Id
    INNER JOIN mst_package  p ON p.Package_Id = r.Plan_Id
    LEFT JOIN  mst_mode     m ON m.Mode_Id    = r.Receipt_Mode
    WHERE r.Pay_Status  = 2
      AND r.Receipt_No IS NOT NULL        -- only actual collections, not initial creation
      AND (pAccount IS NULL OR c.Account_No = pAccount)
      AND (pUserId  IS NULL OR c.User_Id    = pUserId)
      AND (pCode    IS NULL OR c.Cust_Code  = pCode)
    ORDER BY r.Renewal_Id DESC
    LIMIT 1;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `usp_GetMenus` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb3 */ ;
/*!50003 SET character_set_results = utf8mb3 */ ;
/*!50003 SET collation_connection  = utf8mb3_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_AUTO_VALUE_ON_ZERO' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `usp_GetMenus`()
    READS SQL DATA
BEGIN
SELECT
  Menu_Sl AS Sl,
  Menu_Id,
  IFNULL(Menu_Name, '') AS MnuName,
  SubMenu_Id,
  IFNULL(SubMenu_Name, '') AS SubMnuName,
  IFNULL(Icon, '') AS Icon,
  IFNULL(Route, '') AS Route,
  Is_Admin AS OnlyAdm
FROM mst_menus
WHERE Is_Active
ORDER BY Menu_Sl;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `usp_getOrganization` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_0900_ai_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`priority`@`%` PROCEDURE `usp_getOrganization`()
BEGIN
    SELECT Org_Name, Org_Address, Print_Name, Print_Address, Print_Footer
    FROM mst_org
    LIMIT 1;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `usp_getPackage` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_0900_ai_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `usp_getPackage`(
    IN PackType TINYINT,
    IN pShowAll TINYINT
)
BEGIN
    SELECT
        p.Package_Id  AS Id,
        p.Pack_Type,
        pt.Pack_Type_Name AS Pack_Type_Name,
        p.Package_Name AS Name,
        p.Basic_Amt,
        p.GST_Amt,
        p.Total_Amt,
        p.Plan_Days,
        p.Comm_Amt,
        p.Is_Active
    FROM mst_package p
    LEFT JOIN mst_pack_type pt ON pt.Pack_Type_Id = p.Pack_Type
    WHERE (PackType = 0 OR p.Pack_Type = PackType)
      AND (pShowAll = 1 OR p.Is_Active = 1)
    ORDER BY p.Package_Id;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `usp_getPackageType` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_0900_ai_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`priority`@`%` PROCEDURE `usp_getPackageType`()
BEGIN
    SELECT Pack_Type_Id AS Id, Pack_Type_Name AS Name
    FROM mst_pack_type
    WHERE Is_Active = 1
    ORDER BY Pack_Type_Id;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `usp_getPayMode` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb3 */ ;
/*!50003 SET character_set_results = utf8mb3 */ ;
/*!50003 SET collation_connection  = utf8mb3_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_AUTO_VALUE_ON_ZERO' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `usp_getPayMode`(IN MdId TINYINT)
BEGIN
SELECT
  Mode_Id AS Id,
  Mode AS Name
FROM mst_mode
WHERE Is_Active
AND (MdId = 0
OR Mode_Id = MdId)
ORDER BY Mode_Id;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `usp_getRectifyRenewals` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_0900_ai_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`priority`@`%` PROCEDURE `usp_getRectifyRenewals`(
    IN pAccount  VARCHAR(50),
    IN pUserId   VARCHAR(50),
    IN pCode     VARCHAR(50),
    IN pName     VARCHAR(100),
     IN pReceiptDate DATE
)
BEGIN
    SELECT 
        r.Renewal_Id, r.Cust_Id, r.Demand_Date, r.Inv_No,
        r.Renew_From, r.Renew_Upto, r.Total_Amount,
        r.Receipt_No, r.Receipt_Date, r.Receipt_Mode,
        r.Pay_Status, m.Mode AS Mode_Name
    FROM trans_renewal r
    LEFT JOIN mst_mode m ON r.Receipt_Mode = m.Mode_Id
    JOIN mst_customer c ON c.Cust_Id = r.Cust_Id
    WHERE r.Pay_Status = 2
      AND (pAccount IS NULL OR c.Account_No   LIKE CONCAT('%', pAccount, '%'))
      AND (pUserId  IS NULL OR c.User_Id   LIKE CONCAT('%', pUserId,  '%'))
      AND (pCode    IS NULL OR c.Cust_Code LIKE CONCAT('%', pCode,    '%'))
      AND (pName    IS NULL OR c.Cust_Name LIKE CONCAT('%', pName,    '%'))
       AND (pReceiptDate IS NULL OR r.Receipt_Date = pReceiptDate)
    ORDER BY r.Renewal_Id DESC;

    SELECT Mode_Id, Mode FROM mst_mode WHERE Is_Active = 1;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `usp_getRenewalRegister` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_0900_ai_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`priority`@`%` PROCEDURE `usp_getRenewalRegister`(
    IN pFromDate  DATE,
    IN pToDate    DATE,
    IN pCounterId SMALLINT,
    IN pType      TINYINT  
)
BEGIN
    SELECT
        ROW_NUMBER() OVER (ORDER BY r.Demand_Date ASC) AS Sl_No,
        c.Cust_Name,
        c.User_Id,
        r.Inv_No,
        CONCAT(
            DATE_FORMAT(r.Renew_From, '%d-%b-%Y'),
            ' to ',
            DATE_FORMAT(r.Renew_Upto, '%d-%b-%Y')
        )                   AS Renewal_Details,
        r.Receipt_Date      AS Pay_Date,
        r.Total_Amount      AS Plan_Amount,
        r.GST_Amt,
        r.Disc_Amount,
        r.Receipt_Amt       AS Paid_Amount,
        r.Due_Amt,
        r.Demand_Date,
         m.Mode              AS Pay_Mode,
        CASE r.Pay_Status
            WHEN 1 THEN 'Unpaid'
            WHEN 2 THEN 'Paid'
            ELSE 'Unknown'
        END AS Pay_Status
    FROM trans_renewal r
    JOIN mst_customer c ON c.Cust_Id = r.Cust_Id
    LEFT JOIN mst_mode m ON m.Mode_Id = r.Receipt_Mode 
   WHERE (pCounterId IS NULL OR r.Counter_Id = pCounterId)
  AND DATE(r.Demand_Date) BETWEEN pFromDate AND pToDate
  AND (
        pType = 1                             
     OR (pType = 2 AND r.Pay_Status = 2)       
     OR (pType = 3 AND r.Pay_Status = 1)        
  )

    ORDER BY r.Demand_Date ASC;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `usp_getSurrenderCustomers` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_0900_ai_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`priority`@`%` PROCEDURE `usp_getSurrenderCustomers`(
    IN pAccount  VARCHAR(50),
    IN pUserId   VARCHAR(50),
    IN pCode     VARCHAR(50),
    IN pName     VARCHAR(100)
)
BEGIN
    SELECT
        c.Cust_Id, c.Join_Date, c.Cust_Code, c.Cust_Name,
        c.Billing_Address, c.User_Id, c.Account_No, c.Contact_No,
        c.Mail_Id, c.IP_Addrs, c.Package_Id, c.Plan_Amount,
        c.GST, c.Total_Amount, c.Due_Amount, c.Last_PayDt,
        c.Renew_From, c.Renew_Upto, c.Counter_Id, c.Zone_Id,
        c.Router_Dtls, c.Remarks, c.Status, c.AsOn_Date,
        c.Created_By, c.Created_On,ct.Counter_Name, p.Package_Name
    FROM mst_customer c
    LEFT JOIN mst_counter ct ON ct.Counter_Id = c.Counter_Id
    LEFT JOIN mst_package p  ON p.Package_Id  = c.Package_Id
    WHERE (pAccount IS NULL OR c.Account_No LIKE CONCAT('%', pAccount, '%'))
      AND (pUserId  IS NULL OR c.User_Id    LIKE CONCAT('%', pUserId,  '%'))
      AND (pCode    IS NULL OR c.Cust_Code  LIKE CONCAT('%', pCode,    '%'))
      AND (pName    IS NULL OR c.Cust_Name  LIKE CONCAT('%', pName,    '%'))
    ORDER BY c.Cust_Id;

    SELECT Opt_Id, Opt_Name
    FROM mst_apploptions
    WHERE Grp_Id = 1 AND IsActive = 1;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `usp_getUserMenus` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_0900_ai_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`priority`@`%` PROCEDURE `usp_getUserMenus`(IN pUserId SMALLINT)
BEGIN
    -- Always include Dashboard
    SELECT m.*
    FROM mst_menus m
    WHERE m.Menu_Sl = 1
      AND m.Is_Active = 1

    UNION ALL

    -- Parent menu rows (auto-included when user has any sub-menu under them)
    SELECT m.*
    FROM mst_menus m
    WHERE m.SubMenu_Id IS NULL
      AND m.Is_Active = 1
      AND m.Is_Admin IS NULL
      AND m.Menu_Sl != 1
      AND m.Menu_Id IN (
          SELECT DISTINCT mm.Menu_Id
          FROM mst_menus mm
          INNER JOIN mst_user_menu um ON um.Menu_Sl = mm.Menu_Sl
          WHERE um.User_Id = pUserId
            AND mm.SubMenu_Id IS NOT NULL
      )

    UNION ALL

    -- Assigned sub-menu rows
    SELECT m.*
    FROM mst_menus m
    INNER JOIN mst_user_menu um ON um.Menu_Sl = m.Menu_Sl
    WHERE um.User_Id = pUserId
      AND m.Is_Active = 1
      AND m.Is_Admin IS NULL
      AND m.SubMenu_Id IS NOT NULL

    ORDER BY Menu_Id, SubMenu_Id;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `usp_getUsers` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_0900_ai_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`priority`@`%` PROCEDURE `usp_getUsers`()
BEGIN
    SELECT
        u.User_Id, u.Full_Name, u.User_Name, u.Is_Admin,
        u.Is_Active, u.User_Type, u.Counter_Id,
        c.Counter_Name
    FROM mst_user u
    LEFT JOIN mst_counter c ON c.Counter_Id = u.Counter_Id
    ORDER BY u.User_Id ASC;

    SELECT Counter_Id, Counter_Name
    FROM mst_counter
    WHERE Is_Active = 1;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `usp_getZone` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_0900_ai_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `usp_getZone`(IN ZnId SMALLINT)
BEGIN
SELECT
  Zone_Id AS Id,
  Zone_Cd AS Cd,
  LCO_Name AS Name,
  Operator_Name AS OpNm,
   Comm_Pct,
   Is_Active
FROM mst_zone
WHERE Is_Active = 1
AND (ZnId = 0 OR Zone_Id= ZnId)
ORDER BY Zone_Id;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `usp_InsertCustomer` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_0900_ai_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`priority`@`%` PROCEDURE `usp_InsertCustomer`(
    IN JnDate DATE,
    IN CustCd VARCHAR(50),
    IN CustNm VARCHAR(250),
    IN BillAdd TEXT,
    IN UsrNm VARCHAR(75),
    IN AcctNo VARCHAR(75),
    IN ContNo VARCHAR(25),
    IN MailId VARCHAR(75),
    IN IPAdd VARCHAR(25),
    IN PackId SMALLINT,
    IN ZnId SMALLINT,
    IN RoutrDtls VARBINARY(255),
    IN Remks VARCHAR(150),
    IN RnwFrom DATE,
    IN RnwUpto DATE,
    IN Sts TINYINT,
    IN CreatedBy SMALLINT,
    IN CstId INT
)
BEGIN
    DECLARE PlanAmt      DECIMAL(8,2);
    DECLARE GstAmt       DECIMAL(8,2);
    DECLARE TAmt         DECIMAL(8,2);
    DECLARE RtnId        INT;
    DECLARE ExistsCount  INT DEFAULT 0;
    DECLARE vCurPackage  SMALLINT;

    IF COALESCE(CstId, 0) = 0 THEN
        SELECT COUNT(*) INTO ExistsCount FROM mst_customer
        WHERE Cust_Code = CustCd OR User_Id = UsrNm OR Account_No = AcctNo;
    ELSE
        SELECT COUNT(*) INTO ExistsCount FROM mst_customer
        WHERE (Cust_Code = CustCd OR User_Id = UsrNm OR Account_No = AcctNo)
        AND Cust_Id != CstId;
    END IF;

    IF ExistsCount > 0 THEN
        IF EXISTS (SELECT 1 FROM mst_customer WHERE Cust_Code = CustCd AND (COALESCE(CstId,0) = 0 OR Cust_Id != CstId)) THEN
            SELECT -1 AS Error_No, 'Customer Code already exists.' AS Message;
        ELSEIF EXISTS (SELECT 1 FROM mst_customer WHERE User_Id = UsrNm AND (COALESCE(CstId,0) = 0 OR Cust_Id != CstId)) THEN
            SELECT -1 AS Error_No, 'User ID already exists.' AS Message;
        ELSEIF EXISTS (SELECT 1 FROM mst_customer WHERE Account_No = AcctNo AND (COALESCE(CstId,0) = 0 OR Cust_Id != CstId)) THEN
            SELECT -1 AS Error_No, 'Account Number already exists.' AS Message;
        END IF;
    ELSE

        SELECT Basic_Amt, GST_Amt, Total_Amt
        INTO PlanAmt, GstAmt, TAmt
        FROM mst_package WHERE Package_Id = PackId;

        IF COALESCE(CstId, 0) = 0 THEN

            INSERT INTO mst_customer (
                Join_Date, Cust_Code, Cust_Name, Billing_Address,
                User_Id, Account_No, Contact_No, Mail_Id, IP_Addrs,
                Package_Id, Plan_Amount, GST, Total_Amount, Due_Amount,
                Last_PayDt,
                Renew_From, Renew_Upto, Zone_Id,
                Router_Dtls, Remarks, Status, Created_By, Created_On
            ) VALUES (
                JnDate, CustCd, CustNm, BillAdd,
                UsrNm, AcctNo, ContNo, MailId, IPAdd,
                PackId, PlanAmt, GstAmt, TAmt, 0.00,
               NULL,
                NULL, NULL, IFNULL(ZnId, NULL),
                RoutrDtls, Remks, Sts, CreatedBy, CURRENT_TIMESTAMP
            );

            SET RtnId = LAST_INSERT_ID();
            SELECT RtnId AS NewId;

        ELSE

            -- block package change during edit
            SELECT Package_Id INTO vCurPackage FROM mst_customer WHERE Cust_Id = CstId;

            IF PackId != vCurPackage THEN
                SELECT -1 AS Error_No, 'Package cannot be changed here. Please use Generate Demand to change package.' AS Message;
            ELSE
                UPDATE mst_customer SET
                    Join_Date       = JnDate,
                    Cust_Code       = CustCd,
                    Cust_Name       = CustNm,
                    Billing_Address = BillAdd,
                    User_Id         = UsrNm,
                    Account_No      = AcctNo,
                    Contact_No      = ContNo,
                    Mail_Id         = MailId,
                    IP_Addrs        = IPAdd,
                    Zone_Id         = IFNULL(ZnId, NULL),
                    Router_Dtls     = RoutrDtls,
                    Remarks         = Remks,
                    Created_By      = CreatedBy,
                    Created_On      = CURRENT_TIMESTAMP
                WHERE Cust_Id = CstId;

                SELECT CstId AS NewId;
            END IF;

        END IF;

    END IF;

END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `USP_PUSH_USER_LOGIN` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb3 */ ;
/*!50003 SET character_set_results = utf8mb3 */ ;
/*!50003 SET collation_connection  = utf8mb3_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_AUTO_VALUE_ON_ZERO' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `USP_PUSH_USER_LOGIN`(IN pUser_Name VARCHAR(75))
BEGIN
    Declare	pError_No	      Int;
    Declare	pError_Message  Varchar(100);
    Declare	pExists_Count		Int;
    
    Set pExists_Count = ( SELECT
    COUNT(*)
  FROM mst_user
  WHERE User_Name = pUser_Name
  AND Is_Active);
    
    If(pExists_Count=0) Then
    	Set pError_No = -1;
        Set pError_Message = 'Invalid User Name Entred !!';
    Else
    	Set pError_No = 0;
    End If;
    
    If(pError_No=0) Then
SELECT
  pError_No AS Error_No,
  pError_Message AS Message,
  User_Id,
  Full_Name,
  User_Name,
  Usr_Pwd,
  Is_Admin,
  User_Type,
  Counter_Id
FROM mst_user
WHERE User_Name = pUser_Name
AND Is_Active;
ELSE
SELECT
  pError_No AS Error_No,
  pError_Message AS Message;
END IF;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `usp_saveCounter` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_0900_ai_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`priority`@`%` PROCEDURE `usp_saveCounter`(
    IN pCounterId       SMALLINT,
    IN pCounterName     VARCHAR(100),
    IN pAddress         VARCHAR(200),
    IN pContactNo       VARCHAR(25),
    IN pEmailId         VARCHAR(75),
    IN pIsActive        TINYINT
)
BEGIN
    DECLARE ErrNo  INT DEFAULT 0;
    DECLARE ErrMsg VARCHAR(100) DEFAULT '';
    DECLARE ExistsCount INT DEFAULT 0;

    SET ExistsCount = (SELECT COUNT(*) FROM mst_counter
                       WHERE Counter_Name = pCounterName
                       AND (pCounterId = 0 OR Counter_Id != pCounterId));

    IF ExistsCount > 0 THEN
        SET ErrNo  = -1;
        SET ErrMsg = 'Counter name already exists.';
    END IF;

    IF ErrNo = 0 THEN
        IF pCounterId = 0 THEN
            INSERT INTO mst_counter (
                Counter_Name, Counter_Address, Contact_No, Email_Id,
                 Is_Active, Created_Date
            ) VALUES (
                pCounterName, pAddress, pContactNo, pEmailId,
                pIsActive, CURDATE()
            );
        ELSE
            UPDATE mst_counter SET
                Counter_Name    = pCounterName,
                Counter_Address = pAddress,
                Contact_No      = pContactNo,
                Email_Id        = pEmailId,
                Is_Active       = pIsActive
            WHERE Counter_Id = pCounterId;
        END IF;
    END IF;

    SELECT ErrNo AS Error_No, ErrMsg AS Message;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `usp_savePackage` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_0900_ai_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`priority`@`%` PROCEDURE `usp_savePackage`(
    IN pPackageId   SMALLINT,
    IN pPackType    TINYINT,
    IN pPackageName VARCHAR(100),
    IN pBasicAmt    DECIMAL(8,2),
    IN pGstAmt      DECIMAL(8,2),
    IN pTotalAmt    DECIMAL(8,2),
    IN pPlanDays    INT,
    IN pCommAmt     DECIMAL(8,2),
    IN pIsActive    TINYINT,
    IN pAction      TINYINT
)
BEGIN
    DECLARE ErrNo       INT DEFAULT 0;
    DECLARE ErrMsg      VARCHAR(100) DEFAULT '';
    DECLARE ExistsCount INT DEFAULT 0;
     DECLARE UsedCount   INT DEFAULT 0;

   IF pAction = 1 THEN
        -- Delete: check if package is used by any customer
        SET UsedCount = (SELECT COUNT(*) FROM mst_customer WHERE Package_Id = pPackageId);
        IF UsedCount > 0 THEN
            SET ErrNo  = -1;
            SET ErrMsg = 'Cannot delete. Package is assigned to customers.';
        ELSE
            DELETE FROM mst_package WHERE Package_Id = pPackageId;
        END IF;
    ELSE
    
    SET ExistsCount = (SELECT COUNT(*) FROM mst_package
                       WHERE Package_Name = pPackageName
                       AND (pPackageId = 0 OR Package_Id != pPackageId));

    IF ExistsCount > 0 THEN
        SET ErrNo  = -1;
        SET ErrMsg = 'Package name already exists.';
    END IF;

    IF ErrNo = 0 THEN
        IF pPackageId = 0 THEN
            INSERT INTO mst_package (
                Pack_Type, Package_Name, Basic_Amt, GST_Amt,
                Total_Amt, Plan_Days, Comm_Amt, Is_Active
            ) VALUES (
                pPackType, pPackageName, pBasicAmt, pGstAmt,
                pTotalAmt, pPlanDays, pCommAmt, pIsActive
            );
        ELSE
            UPDATE mst_package SET
                Pack_Type    = pPackType,
                Package_Name = pPackageName,
                Basic_Amt    = pBasicAmt,
                GST_Amt      = pGstAmt,
                Total_Amt    = pTotalAmt,
                Plan_Days    = pPlanDays,
                Comm_Amt     = pCommAmt,
                Is_Active    = pIsActive
            WHERE Package_Id = pPackageId;
        END IF;
    END IF;
  END IF;
    SELECT ErrNo AS Error_No, ErrMsg AS Message;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `usp_saveRectify` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_0900_ai_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`priority`@`%` PROCEDURE `usp_saveRectify`(
    IN p_Renewal_Id  INT,
    IN p_Cust_Id     INT,
    IN p_New_Mode_Id INT,
    IN p_Remarks     VARCHAR(500),
    IN p_Created_By  INT,
    IN p_Rec_Date    DATE
)
BEGIN
    DECLARE EXIT HANDLER FOR SQLEXCEPTION
    BEGIN
        ROLLBACK;
        SELECT -1 AS Error_No, 'Database error occurred.' AS Message;
    END;

    START TRANSACTION;

    UPDATE trans_renewal
    SET Receipt_Mode = p_New_Mode_Id
    WHERE Renewal_Id = p_Renewal_Id;

    INSERT INTO trans_rectify (Rec_Date, Rec_From, Rec_Id, Remarks, Created_By, Created_On)
    VALUES (p_Rec_Date, p_Cust_Id, p_Renewal_Id, p_Remarks, p_Created_By, NOW());

    COMMIT;

    SELECT 0 AS Error_No, 'Success' AS Message;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `usp_saveUser` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_0900_ai_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`priority`@`%` PROCEDURE `usp_saveUser`(
    IN p_User_Id    INT,
    IN p_Full_Name  VARCHAR(100),
    IN p_User_Name  VARCHAR(75),
    IN p_Password   VARCHAR(255),
    IN p_Is_Admin   TINYINT,
    IN p_Is_Active  TINYINT,
    IN p_User_Type  TINYINT,
    IN p_Counter_Id INT
)
BEGIN
    DECLARE vNewUserId INT;

    DECLARE EXIT HANDLER FOR SQLEXCEPTION
    BEGIN
        ROLLBACK;
        SELECT -1 AS Error_No, 'Database error occurred.' AS Message;
    END;

    SET p_Is_Admin   = NULLIF(p_Is_Admin, 0);
    SET p_Counter_Id = NULLIF(p_Counter_Id, 0);

    START TRANSACTION;

    IF p_User_Id = 0 THEN

        IF p_Counter_Id IS NULL THEN
            ROLLBACK;
            SELECT -1 AS Error_No, 'Counter is required.' AS Message;
        ELSEIF EXISTS (SELECT 1 FROM mst_user WHERE User_Name = p_User_Name) THEN
            ROLLBACK;
            SELECT -1 AS Error_No, 'Username already exists.' AS Message;
            ELSEIF EXISTS (SELECT 1 FROM mst_user WHERE Counter_Id = p_Counter_Id) THEN
           ROLLBACK;
        SELECT -1 AS Error_No, 'This counter is already assigned to another user.' AS Message;
        ELSE
            INSERT INTO mst_user (Full_Name, User_Name, Usr_Pwd, Is_Admin, Is_Active, User_Type, Counter_Id, Created_Date)
            VALUES (p_Full_Name, p_User_Name, p_Password, p_Is_Admin, p_Is_Active, p_User_Type, p_Counter_Id, NOW());

            SET vNewUserId = LAST_INSERT_ID();

            INSERT INTO mst_counter_user (User_Id, Counter_Id, Print_Name, User_Name, User_Pwd, Is_Active, Created_Date)
            VALUES (vNewUserId, p_Counter_Id, p_Full_Name, p_User_Name, p_Password, p_Is_Active, NOW());

            COMMIT;
            SELECT 0 AS Error_No, 'User created successfully.' AS Message;
        END IF;

    ELSE

        IF p_Password != '' THEN
            UPDATE mst_user
            SET Full_Name  = p_Full_Name,
                User_Name  = p_User_Name,
                Is_Admin   = p_Is_Admin,
                Is_Active  = p_Is_Active,
                User_Type  = p_User_Type,
                Counter_Id = p_Counter_Id,
                Usr_Pwd    = p_Password
            WHERE User_Id = p_User_Id;
        ELSE
            UPDATE mst_user
            SET Full_Name  = p_Full_Name,
                User_Name  = p_User_Name,
                Is_Admin   = p_Is_Admin,
                Is_Active  = p_Is_Active,
                User_Type  = p_User_Type,
                Counter_Id = p_Counter_Id
            WHERE User_Id = p_User_Id;
        END IF;

        IF p_Counter_Id IS NOT NULL THEN
            IF EXISTS (SELECT 1 FROM mst_counter_user WHERE User_Id = p_User_Id) THEN
                IF p_Password != '' THEN
                    UPDATE mst_counter_user
                    SET Counter_Id = p_Counter_Id,
                        Print_Name = p_Full_Name,
                        User_Name  = p_User_Name,
                        User_Pwd   = p_Password,
                        Is_Active  = p_Is_Active
                    WHERE User_Id = p_User_Id;
                ELSE
                    UPDATE mst_counter_user
                    SET Counter_Id = p_Counter_Id,
                        Print_Name = p_Full_Name,
                        User_Name  = p_User_Name,
                        Is_Active  = p_Is_Active
                    WHERE User_Id = p_User_Id;
                END IF;
            ELSE
                INSERT INTO mst_counter_user (User_Id, Counter_Id, Print_Name, User_Name, User_Pwd, Is_Active, Created_Date)
                SELECT p_User_Id, p_Counter_Id, p_Full_Name, p_User_Name,
                       IF(p_Password != '', p_Password, Usr_Pwd),
                       p_Is_Active, NOW()
                FROM mst_user
                WHERE User_Id = p_User_Id;
            END IF;
        ELSE
            DELETE FROM mst_counter_user WHERE User_Id = p_User_Id;
        END IF;

        COMMIT;
        SELECT 0 AS Error_No, 'User updated successfully.' AS Message;
    END IF;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `usp_saveUserMenus` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_0900_ai_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`priority`@`%` PROCEDURE `usp_saveUserMenus`(
    IN pUserId  SMALLINT,
    IN pMenuSls TEXT
)
BEGIN
    DELETE FROM mst_user_menu WHERE User_Id = pUserId;

    INSERT INTO mst_user_menu (User_Id, Menu_Sl)
    SELECT pUserId, CAST(TRIM(value) AS UNSIGNED)
    FROM JSON_TABLE(
        CONCAT('["', REPLACE(pMenuSls, ',', '","'), '"]'),
        '$[*]' COLUMNS(value VARCHAR(10) PATH '$')
    ) AS jt
    WHERE TRIM(value) != '';

    SELECT 0 AS Error_No, 'Menu saved successfully.' AS Message;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `usp_saveZone` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_0900_ai_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`priority`@`%` PROCEDURE `usp_saveZone`(
    IN pZoneId       SMALLINT,
    IN pZoneCd       VARCHAR(50),
    IN pLcoName      VARCHAR(100),
    IN pOperatorName VARCHAR(100),
    IN pCommPct      DECIMAL(5,2),
    IN pEffFrom      DATE,
    IN pIsActive     TINYINT,
    IN pCreatedBy    SMALLINT
)
BEGIN
    DECLARE ErrNo       INT          DEFAULT 0;
    DECLARE ErrMsg      VARCHAR(100) DEFAULT '';
    DECLARE ExistsCount INT          DEFAULT 0;
    DECLARE OldCommPct  DECIMAL(5,2) DEFAULT NULL;
    DECLARE NewZoneId   SMALLINT;

    SET ExistsCount = (SELECT COUNT(*) FROM mst_zone
                       WHERE Zone_Cd = pZoneCd
                       AND (pZoneId = 0 OR Zone_Id != pZoneId));

    IF ExistsCount > 0 THEN
        SET ErrNo  = -1;
        SET ErrMsg = 'Zone code already exists.';
    END IF;

    IF ErrNo = 0 THEN
        IF pZoneId = 0 THEN

            INSERT INTO mst_zone (Zone_Cd, LCO_Name, Operator_Name, Comm_Pct, Is_Active, Created_Date)
            VALUES (pZoneCd, pLcoName, pOperatorName, pCommPct, pIsActive, CURDATE());

            SET NewZoneId = LAST_INSERT_ID();

            -- Insert first rate record with Eff_From = today
            INSERT INTO mst_zone_comm_rate (Zone_Id, Comm_Rate, Eff_From, Eff_Upto, Is_Active, Created_By)
            VALUES (NewZoneId, pCommPct, CURDATE(), NULL, 1, pCreatedBy);

        ELSE

            SELECT Comm_Pct INTO OldCommPct FROM mst_zone WHERE Zone_Id = pZoneId;

            UPDATE mst_zone SET
                Zone_Cd       = pZoneCd,
                LCO_Name      = pLcoName,
                Operator_Name = pOperatorName,
                Comm_Pct      = pCommPct,
                Is_Active     = pIsActive
            WHERE Zone_Id = pZoneId;

            -- Only update rate history if Comm_Pct changed
            IF OldCommPct != pCommPct THEN

                -- Close old active rate
                UPDATE mst_zone_comm_rate
                SET Eff_Upto  = DATE_SUB(pEffFrom, INTERVAL 1 DAY),
                    Is_Active = 0
                WHERE Zone_Id = pZoneId AND Is_Active = 1;

                -- Insert new rate with Eff_From from input
                INSERT INTO mst_zone_comm_rate (Zone_Id, Comm_Rate, Eff_From, Eff_Upto, Is_Active, Created_By)
                VALUES (pZoneId, pCommPct, pEffFrom, NULL, 1, pCreatedBy);

            END IF;

        END IF;
    END IF;

    SELECT ErrNo AS Error_No, ErrMsg AS Message;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `usp_searchCustomerDemand` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_0900_ai_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`priority`@`%` PROCEDURE `usp_searchCustomerDemand`(
    IN pAccount   VARCHAR(75),
    IN pUserId    VARCHAR(75),
    IN pCode      VARCHAR(50),
    IN pName      VARCHAR(250),
    IN pCounterId SMALLINT
)
BEGIN
    DECLARE vCustId INT;

    SELECT c.Cust_Id INTO vCustId
    FROM mst_customer c
    WHERE c.Status IN (1, 2)
      AND (pAccount IS NULL OR c.Account_No LIKE CONCAT('%', pAccount, '%'))
      AND (pUserId  IS NULL OR c.User_Id    LIKE CONCAT('%', pUserId,  '%'))
      AND (pCode    IS NULL OR c.Cust_Code  LIKE CONCAT('%', pCode,    '%'))
      AND (pName    IS NULL OR c.Cust_Name  LIKE CONCAT('%', pName,    '%'))
    LIMIT 1;

    SELECT
        c.Cust_Id, c.Cust_Code, c.Cust_Name, c.Account_No,
        c.User_Id, c.Contact_No, c.Renew_From, c.Renew_Upto,
        c.Due_Amount, c.Status,
        p.Package_Name, p.Basic_Amt, p.Total_Amt, p.Plan_Days
    FROM mst_customer c
    INNER JOIN mst_package p ON p.Package_Id = c.Package_Id
    WHERE c.Cust_Id = vCustId;

    SELECT
        r.Renewal_Id, r.Inv_No, r.Demand_Date,
        r.Renew_From, r.Renew_Upto, r.Total_Amount,
        r.Pay_Status, r.Receipt_No, r.Receipt_Date
    FROM trans_renewal r
    WHERE r.Cust_Id = vCustId
    ORDER BY r.Demand_Date DESC, r.Renewal_Id DESC;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `usp_searchCustomers` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_0900_ai_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`priority`@`%` PROCEDURE `usp_searchCustomers`(
    IN pStatus    TINYINT,
    IN pCustName  VARCHAR(250),
    IN pWildcard  VARCHAR(100),
    IN pPayStatus TINYINT,
    IN pPackageId SMALLINT,
    IN pCounterId SMALLINT,
    IN pZoneId    SMALLINT,
    IN pFromDate  DATE,      
    IN pToDate    DATE, 
    IN pPageNo    INT,
    IN pPageSize  INT
)
BEGIN
    DECLARE vOffset INT;
    SET vOffset = (pPageNo - 1) * pPageSize;

    SELECT
        c.Cust_Id, c.Cust_Code, c.Cust_Name, c.Join_Date, c.Billing_Address,
        c.User_Id, c.Account_No, c.Contact_No, c.Mail_Id, c.IP_Addrs,
        c.Package_Id, p.Package_Name AS Package, c.Renew_From,
        c.Renew_Upto AS Exp_Date, c.Counter_Id, c.Zone_Id,
        c.Router_Dtls, c.Remarks, c.Status,
        CASE
            WHEN r.Pay_Status = 2 THEN 'Paid'
            WHEN r.Pay_Status = 1 THEN 'Unpaid'
            ELSE NULL
        END AS Payment_Status
    FROM mst_customer c
    INNER JOIN mst_package p ON p.Package_Id = c.Package_Id
    LEFT JOIN (
        SELECT Cust_Id, Pay_Status
        FROM trans_renewal
        WHERE Renewal_Id IN (
            SELECT MAX(Renewal_Id) FROM trans_renewal GROUP BY Cust_Id
        )
    ) r ON r.Cust_Id = c.Cust_Id
    WHERE
        (pStatus    IS NULL OR c.Status     = pStatus)
    AND (pCustName  IS NULL OR c.Cust_Name  LIKE CONCAT('%', pCustName, '%'))
    AND (pWildcard  IS NULL OR c.Cust_Code  LIKE CONCAT('%', pWildcard, '%')
							OR c.User_Id    LIKE CONCAT('%', pWildcard, '%')
                            OR c.Account_No LIKE CONCAT('%', pWildcard, '%')
                            OR c.Contact_No LIKE CONCAT('%', pWildcard, '%'))
    AND (pPayStatus IS NULL OR (pPayStatus = 2 AND r.Pay_Status = 2)
                            OR (pPayStatus = 1 AND r.Pay_Status = 1))
    AND (pPackageId IS NULL OR c.Package_Id = pPackageId)
    AND (pCounterId IS NULL OR c.Counter_Id = pCounterId)
    AND (pZoneId    IS NULL OR c.Zone_Id    = pZoneId)
    AND (pFromDate  IS NULL OR c.Join_Date >= pFromDate)   
     AND (pToDate    IS NULL OR c.Join_Date <= pToDate)  
    ORDER BY c.Cust_Id
    LIMIT pPageSize OFFSET vOffset;

    SELECT COUNT(*) AS Total_Count
    FROM mst_customer c
    INNER JOIN mst_package p ON p.Package_Id = c.Package_Id
    LEFT JOIN (
        SELECT Cust_Id, Pay_Status
        FROM trans_renewal
        WHERE Renewal_Id IN (
            SELECT MAX(Renewal_Id) FROM trans_renewal GROUP BY Cust_Id
        )
    ) r ON r.Cust_Id = c.Cust_Id
    WHERE
        (pStatus    IS NULL OR c.Status     = pStatus)
    AND (pCustName  IS NULL OR c.Cust_Name  LIKE CONCAT('%', pCustName, '%'))
    AND (pWildcard  IS NULL OR c.User_Id    LIKE CONCAT('%', pWildcard, '%')
                            OR c.Account_No LIKE CONCAT('%', pWildcard, '%')
                            OR c.Contact_No LIKE CONCAT('%', pWildcard, '%'))
    AND (pPayStatus IS NULL OR (pPayStatus = 2 AND r.Pay_Status = 2)
                            OR (pPayStatus = 1 AND r.Pay_Status = 1))
    AND (pPackageId IS NULL OR c.Package_Id = pPackageId)
    AND (pCounterId IS NULL OR c.Counter_Id = pCounterId)
    AND (pZoneId    IS NULL OR c.Zone_Id    = pZoneId)
    AND (pFromDate  IS NULL OR c.Join_Date >= pFromDate)
    AND (pToDate    IS NULL OR c.Join_Date <= pToDate); 
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `usp_searchDemandCustomer` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_0900_ai_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`priority`@`%` PROCEDURE `usp_searchDemandCustomer`(
    IN pAcctNo    VARCHAR(75),
    IN pUserId    VARCHAR(75),
    IN pCustCode  VARCHAR(50),
    IN pCustName  VARCHAR(250)
)
BEGIN
    DECLARE vCustId  INT DEFAULT NULL;
    DECLARE vCount   INT DEFAULT 0;

    SELECT COUNT(*) INTO vCount
    FROM mst_customer
    WHERE (pAcctNo   IS NULL OR Account_No = pAcctNo)
    AND  (pUserId   IS NULL OR User_Id    = pUserId)
    AND  (pCustCode IS NULL OR Cust_Code  = pCustCode)
    AND  (pCustName IS NULL OR Cust_Name  LIKE CONCAT('%', pCustName, '%'));

    IF vCount = 0 THEN
        SELECT -1 AS Error_No, 'Customer not found.' AS Message;

    ELSEIF vCount > 1 THEN
        SELECT 1 AS Error_No, 'Multiple customers found. Please refine your search.' AS Message;

    ELSE
        SELECT Cust_Id INTO vCustId
        FROM mst_customer
        WHERE (pAcctNo   IS NULL OR Account_No = pAcctNo)
        AND  (pUserId   IS NULL OR User_Id    = pUserId)
        AND  (pCustCode IS NULL OR Cust_Code  = pCustCode)
        AND  (pCustName IS NULL OR Cust_Name  LIKE CONCAT('%', pCustName, '%'));

        IF NOT EXISTS (SELECT 1 FROM trans_renewal WHERE Cust_Id = vCustId AND Pay_Status != 2) THEN
            SELECT 0 AS Error_No, 'No pending demands. All bills are paid.' AS Message;
        ELSE
            SELECT
                c.Cust_Id, c.Cust_Code, c.Cust_Name,
                c.Account_No, c.User_Id, c.Contact_No,
                r.Renewal_Id, r.Inv_No,
                CONCAT(DATE_FORMAT(r.Renew_From, '%d %b %Y'), ' - ', DATE_FORMAT(r.Renew_Upto, '%d %b %Y')) AS Inv_Period,
                r.Due_Amt, r.Pay_Status, r.Total_Amount
            FROM mst_customer c
            INNER JOIN trans_renewal r ON r.Cust_Id = c.Cust_Id
            WHERE c.Cust_Id = vCustId
            AND   r.Pay_Status != 2
            ORDER BY r.Demand_Date ASC;
        END IF;
    END IF;

END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `usp_updateCustomerStatus` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_0900_ai_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`priority`@`%` PROCEDURE `usp_updateCustomerStatus`(
    IN p_Cust_Id    INT,
    IN p_Status     INT,
    IN p_Updated_By INT
)
BEGIN
    DECLARE EXIT HANDLER FOR SQLEXCEPTION
    BEGIN
        SELECT -1 AS Error_No, 'Database error occurred.' AS Message;
    END;

    UPDATE mst_customer
    SET Status = p_Status
    WHERE Cust_Id = p_Cust_Id;

    SELECT 0 AS Error_No, 'Success' AS Message;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2026-09-04 17:35:09
