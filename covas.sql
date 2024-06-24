-- --------------------------------------------------------
-- Anfitrião:                    127.0.0.1
-- Versão do servidor:           8.0.30 - MySQL Community Server - GPL
-- SO do servidor:               Win64
-- HeidiSQL Versão:              12.1.0.6537
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


-- A despejar estrutura da base de dados para fujimoto_barbershop
CREATE DATABASE IF NOT EXISTS `fujimoto_barbershop` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci */ /*!80016 DEFAULT ENCRYPTION='N' */;
USE `fujimoto_barbershop`;

-- A despejar estrutura para tabela fujimoto_barbershop.appointments
CREATE TABLE IF NOT EXISTS `appointments` (
  `Id` int NOT NULL,
  `user_id` int NOT NULL,
  `Subject` varchar(200) DEFAULT NULL,
  `StartTime` datetime NOT NULL,
  `EndTime` datetime NOT NULL,
  `StartTimezone` varchar(200) DEFAULT NULL,
  `EndTimezone` varchar(200) DEFAULT NULL,
  `Location` varchar(200) DEFAULT NULL,
  `Description` varchar(200) DEFAULT NULL,
  `IsAllDay` bit(1) NOT NULL,
  `RecurrenceID` int DEFAULT NULL,
  `FollowingID` int DEFAULT NULL,
  `RecurrenceRule` varchar(200) DEFAULT NULL,
  `RecurrenceException` varchar(200) DEFAULT NULL,
  `IsReadonly` bit(1) DEFAULT NULL,
  `IsBlock` bit(1) DEFAULT NULL,
  `RoomID` int DEFAULT NULL,
  PRIMARY KEY (`Id`),
  KEY `FK_appointmentss_users` (`user_id`),
  CONSTRAINT `FK_appointmentss_users` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- A despejar dados para tabela fujimoto_barbershop.appointments: ~0 rows (aproximadamente)

-- A despejar estrutura para tabela fujimoto_barbershop.appointments2
CREATE TABLE IF NOT EXISTS `appointments2` (
  `appointment_id` int NOT NULL AUTO_INCREMENT,
  `user_id` int NOT NULL,
  `date` date NOT NULL,
  `time` time NOT NULL,
  `message` varchar(50) DEFAULT '',
  `creation_user` int NOT NULL,
  `update_user` int NOT NULL,
  `creation_at` timestamp NOT NULL,
  `updated_at` timestamp NOT NULL,
  PRIMARY KEY (`appointment_id`),
  KEY `FK_appointments_users` (`user_id`),
  CONSTRAINT `FK_appointments_users` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- A despejar dados para tabela fujimoto_barbershop.appointments2: ~0 rows (aproximadamente)

-- A despejar estrutura para tabela fujimoto_barbershop.role_type
CREATE TABLE IF NOT EXISTS `role_type` (
  `role_id` int NOT NULL,
  `role_name` varchar(20) NOT NULL DEFAULT '',
  PRIMARY KEY (`role_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- A despejar dados para tabela fujimoto_barbershop.role_type: ~2 rows (aproximadamente)
INSERT INTO `role_type` (`role_id`, `role_name`) VALUES
	(1, 'cliente'),
	(2, 'administrador');

-- A despejar estrutura para tabela fujimoto_barbershop.users
CREATE TABLE IF NOT EXISTS `users` (
  `user_id` int NOT NULL AUTO_INCREMENT,
  `email` varchar(70) NOT NULL,
  `username` varchar(30) NOT NULL,
  `password` varchar(255) NOT NULL,
  `name` varchar(25) NOT NULL,
  `last_name` varchar(50) NOT NULL,
  `phonenumber` varchar(50) DEFAULT NULL,
  `token` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `role_id` int NOT NULL DEFAULT '1',
  `update_user` int DEFAULT NULL,
  `created_at` timestamp NOT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`user_id`),
  UNIQUE KEY `Índice 4` (`email`,`username`),
  KEY `FK_users_role_type` (`role_id`),
  KEY `FK_users_users` (`update_user`),
  CONSTRAINT `FK_users_role_type` FOREIGN KEY (`role_id`) REFERENCES `role_type` (`role_id`),
  CONSTRAINT `FK_users_users` FOREIGN KEY (`update_user`) REFERENCES `users` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- A despejar dados para tabela fujimoto_barbershop.users: ~2 rows (aproximadamente)
INSERT INTO `users` (`user_id`, `email`, `username`, `password`, `name`, `last_name`, `phonenumber`, `token`, `role_id`, `update_user`, `created_at`, `updated_at`) VALUES
	(1, 'brunoduarte602@gmail.com', 'bruno', '$2y$10$UUtS/avOwZ2sPwNRlVVJJuOTRd9ENq4qV8oWeFjO/BohLYx77RUYu', 'Bruno', 'Duarte', '658592139', '0bbf412537418771a531ae834f3136b9', 2, 1, '2024-06-22 12:22:36', '2024-06-24 19:03:36'),
	(3, 'covais@gmail.com', 'covais', '$2y$10$PGwBF.Upp5idyFxgMN.DeOyAxDlo5PYQ7J8yyOk49Ecz7qEs.L29m', 'Rodrigo', 'Pinto', '963436426', NULL, 1, NULL, '2024-06-22 13:48:50', NULL);

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
