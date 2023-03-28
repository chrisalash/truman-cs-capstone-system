

USE capstone2;

DROP TABLE IF EXISTS Spring2023;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE Spring2023 (
  id int NOT NULL,
  capstone_day date DEFAULT NULL,
  time_start int NOT NULL DEFAULT '0',
  time_end int NOT NULL DEFAULT '0',
  PRIMARY KEY (id))