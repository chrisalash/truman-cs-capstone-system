

USE capstone2;

DROP TABLE IF EXISTS Spring2023;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE Spring2023 (
  id int DEFAULT NULL,
  time_start datetime NOT NULL,
  time_end datetime NOT NULL,
  PRIMARY KEY (time_start,time_end))