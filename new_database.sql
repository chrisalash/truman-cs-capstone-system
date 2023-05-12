

USE capstone2;

DROP TABLE IF EXISTS capstone_presentations;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE capstone_presentations (
  id int NOT NULL AUTO_INCREMENT,
  username varchar(12) DEFAULT "",
  time_start datetime NOT NULL,
  time_end datetime NOT NULL,
  professors varchar(255) DEFAULT "",
  PRIMARY KEY (id));
  
DROP TABLE IF EXISTS capstone_presentations_archive;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE capstone_presentations_archive (
  id int NOT NULL AUTO_INCREMENT,
  username varchar(12) DEFAULT "",
  time_start datetime NOT NULL,
  time_end datetime NOT NULL,
  professors varchar(255) DEFAULT "",
  PRIMARY KEY (id));