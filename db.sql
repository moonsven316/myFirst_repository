/*
SQLyog Community v13.1.5  (64 bit)
MySQL - 10.4.11-MariaDB : Database - amazon_discord
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`amazon_discord` /*!40100 DEFAULT CHARACTER SET utf8mb4 */;

USE `amazon_discord`;

/*Table structure for table `errors` */

DROP TABLE IF EXISTS `errors`;

CREATE TABLE `errors` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `code` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4;

/*Data for the table `errors` */

insert  into `errors`(`id`,`code`,`created_at`,`updated_at`) values 
(7,'11','2022-12-29 08:46:11','2022-12-29 08:46:58'),
(8,'212','2022-12-29 08:46:15','2022-12-29 08:47:21'),
(9,'3','2022-12-29 08:46:26','2022-12-29 08:46:26'),
(10,'4','2022-12-29 08:46:27','2022-12-29 08:46:27'),
(11,'5','2022-12-29 08:46:29','2022-12-29 08:46:29');

/*Table structure for table `machines` */

DROP TABLE IF EXISTS `machines`;

CREATE TABLE `machines` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) NOT NULL,
  `access_key` varchar(255) DEFAULT NULL,
  `secret_key` varchar(255) DEFAULT NULL,
  `category` varchar(255) DEFAULT NULL,
  `down` bigint(20) DEFAULT 30,
  `web_hook` varchar(255) DEFAULT NULL,
  `is_reg` tinyint(1) NOT NULL DEFAULT 0,
  `reg_num` int(10) NOT NULL DEFAULT 0,
  `trk_num` int(10) NOT NULL DEFAULT 0,
  `file_name` varchar(255) DEFAULT NULL,
  `len` int(10) DEFAULT NULL,
  `round` int(10) NOT NULL DEFAULT 0,
  `stop` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=101 DEFAULT CHARSET=utf8;

/*Data for the table `machines` */

insert  into `machines`(`id`,`user_id`,`access_key`,`secret_key`,`category`,`down`,`web_hook`,`is_reg`,`reg_num`,`trk_num`,`file_name`,`len`,`round`,`stop`,`created_at`,`updated_at`) values 
(70,1,'','','',0,'',0,0,0,'',0,0,0,NULL,'2023-02-11 14:38:34'),
(71,1,NULL,NULL,NULL,NULL,NULL,0,0,0,NULL,NULL,0,0,NULL,NULL),
(72,1,NULL,NULL,NULL,NULL,NULL,0,0,0,NULL,NULL,0,0,NULL,NULL),
(73,1,'','','',0,'',0,0,0,'',0,0,0,NULL,'2023-02-11 12:24:10'),
(74,1,NULL,NULL,NULL,NULL,NULL,0,0,0,NULL,NULL,0,0,NULL,NULL),
(86,1,'','','',0,'',0,0,0,'',0,0,0,NULL,'2023-02-11 11:33:09'),
(87,1,NULL,NULL,NULL,NULL,NULL,0,0,0,NULL,NULL,0,0,NULL,NULL),
(88,1,NULL,NULL,NULL,NULL,NULL,0,0,0,NULL,NULL,0,0,NULL,NULL),
(89,1,NULL,NULL,NULL,NULL,NULL,0,0,0,NULL,NULL,0,0,NULL,NULL),
(90,1,NULL,NULL,NULL,NULL,NULL,0,0,0,NULL,NULL,0,0,NULL,NULL),
(91,1,NULL,NULL,NULL,NULL,NULL,0,0,0,NULL,NULL,0,0,NULL,NULL),
(92,1,NULL,NULL,NULL,NULL,NULL,0,0,0,NULL,NULL,0,0,NULL,NULL),
(93,1,NULL,NULL,NULL,NULL,NULL,0,0,0,NULL,NULL,0,0,NULL,NULL),
(94,1,NULL,NULL,NULL,NULL,NULL,0,0,0,NULL,NULL,0,0,NULL,NULL),
(95,1,NULL,NULL,NULL,NULL,NULL,0,0,0,NULL,NULL,0,0,NULL,NULL),
(96,1,NULL,NULL,NULL,NULL,NULL,0,0,0,NULL,NULL,0,0,NULL,NULL),
(97,1,NULL,NULL,NULL,NULL,NULL,0,0,0,NULL,NULL,0,0,NULL,NULL),
(98,1,NULL,NULL,NULL,NULL,NULL,0,0,0,NULL,NULL,0,0,NULL,NULL),
(99,1,NULL,NULL,NULL,NULL,NULL,0,0,0,NULL,NULL,0,0,NULL,NULL),
(100,1,NULL,NULL,NULL,NULL,NULL,0,0,0,NULL,NULL,0,0,NULL,NULL);

/*Table structure for table `migrations` */

DROP TABLE IF EXISTS `migrations`;

CREATE TABLE `migrations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `migrations` */

/*Table structure for table `personal_access_tokens` */

DROP TABLE IF EXISTS `personal_access_tokens`;

CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `tokenable_type` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint(20) unsigned NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `personal_access_tokens` */

/*Table structure for table `products` */

DROP TABLE IF EXISTS `products`;

CREATE TABLE `products` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `machine_id` bigint(20) DEFAULT NULL,
  `user_id` bigint(20) DEFAULT NULL,
  `asin` varchar(20) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `reg_price` int(10) NOT NULL DEFAULT 0,
  `price` int(10) NOT NULL DEFAULT 0,
  `pro` int(10) NOT NULL DEFAULT 100,
  `tar_price` int(10) DEFAULT NULL,
  `in_stock` varchar(255) NOT NULL DEFAULT 'x',
  `is_notified` int(1) NOT NULL DEFAULT 0,
  `url` varchar(255) DEFAULT NULL,
  `error` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=121 DEFAULT CHARSET=utf8;

/*Data for the table `products` */

insert  into `products`(`id`,`machine_id`,`user_id`,`asin`,`image`,`reg_price`,`price`,`pro`,`tar_price`,`in_stock`,`is_notified`,`url`,`error`,`created_at`,`updated_at`) values 
(101,70,1,'B0BNWH56FL',NULL,0,0,30,0,'x',0,NULL,NULL,'2023-02-10 21:38:38','2023-02-11 05:38:38'),
(102,70,1,'B0BNWJBN7L',NULL,0,0,30,0,'x',0,NULL,NULL,'2023-02-10 21:38:38','2023-02-11 05:38:38'),
(103,70,1,'B0BNWGKVW5',NULL,0,0,30,0,'x',0,NULL,NULL,'2023-02-10 21:38:38','2023-02-11 05:38:38'),
(104,70,1,'B09QC5XDXV',NULL,0,0,30,0,'x',0,NULL,NULL,'2023-02-10 21:38:38','2023-02-11 05:38:38'),
(105,70,1,'B0BNWFX7BX',NULL,0,0,30,0,'x',0,NULL,NULL,'2023-02-10 21:38:38','2023-02-11 05:38:38'),
(106,70,1,'B0991TGVVD',NULL,0,0,30,0,'x',0,NULL,NULL,'2023-02-10 21:38:38','2023-02-11 05:38:38'),
(107,70,1,'B0BNWHP2K2',NULL,0,0,30,0,'x',0,NULL,NULL,'2023-02-10 21:38:38','2023-02-11 05:38:38'),
(108,70,1,'B0BNWK94X8',NULL,0,0,30,0,'x',0,NULL,NULL,'2023-02-10 21:38:38','2023-02-11 05:38:38'),
(109,70,1,'B09NFGSCY5',NULL,0,0,30,0,'x',0,NULL,NULL,'2023-02-10 21:38:38','2023-02-11 05:38:38'),
(110,70,1,'B09NFGQG1N',NULL,0,0,30,0,'x',0,NULL,NULL,'2023-02-10 21:38:38','2023-02-11 05:38:38'),
(111,70,1,'B09NFGKDZ4',NULL,0,0,30,0,'x',0,NULL,NULL,'2023-02-10 21:38:40','2023-02-11 05:38:40'),
(112,70,1,'B09NFG2D92',NULL,0,0,30,0,'x',0,NULL,NULL,'2023-02-10 21:38:40','2023-02-11 05:38:40'),
(113,70,1,'B09NFG1GM4',NULL,0,0,30,0,'x',0,NULL,NULL,'2023-02-10 21:38:40','2023-02-11 05:38:40'),
(114,70,1,'B0B6N8R6TG',NULL,0,0,30,0,'x',0,NULL,NULL,'2023-02-10 21:38:40','2023-02-11 05:38:40'),
(115,70,1,'B09CMJPSFG',NULL,0,0,30,0,'x',0,NULL,NULL,'2023-02-10 21:38:40','2023-02-11 05:38:40'),
(116,70,1,'B09CMJQRQX',NULL,0,0,30,0,'x',0,NULL,NULL,'2023-02-10 21:38:40','2023-02-11 05:38:40'),
(117,70,1,'B09NFFYZJ9',NULL,0,0,30,0,'x',0,NULL,NULL,'2023-02-10 21:38:40','2023-02-11 05:38:40'),
(118,70,1,'B0B3X531R6',NULL,0,0,30,0,'x',0,NULL,NULL,'2023-02-10 21:38:40','2023-02-11 05:38:40'),
(119,70,1,'B09CMK47VW',NULL,0,0,30,0,'x',0,NULL,NULL,'2023-02-10 21:38:40','2023-02-11 05:38:40'),
(120,70,1,'B07SVLZGTK',NULL,0,0,30,0,'x',0,NULL,NULL,'2023-02-10 21:38:40','2023-02-11 05:38:40');

/*Table structure for table `sessions` */

DROP TABLE IF EXISTS `sessions`;

CREATE TABLE `sessions` (
  `id` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint(20) unsigned DEFAULT NULL,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_activity` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `sessions_user_id_index` (`user_id`),
  KEY `sessions_last_activity_index` (`last_activity`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `sessions` */

insert  into `sessions`(`id`,`user_id`,`ip_address`,`user_agent`,`payload`,`last_activity`) values 
('tdB5AAolXFdgkOuiaX8HM7eb8Hs82f55y4eplzv3',1,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/110.0.0.0 Safari/537.36','YTo1OntzOjk6Il9wcmV2aW91cyI7YToxOntzOjM6InVybCI7czozODoiaHR0cDovLzEyNy4wLjAuMTo4MDAwL3JlZ2lzdGVyX3Byb2R1Y3QiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX1zOjY6Il90b2tlbiI7czo0MDoiOTQxYklvNU1kZUF5a1UwWk56bmJDcFlLSXNUbmpYUVRqSVAxYWVGbCI7czo1MDoibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO2k6MTtzOjE3OiJwYXNzd29yZF9oYXNoX3dlYiI7czo2MDoiJDJ5JDEwJDVQT2RETkYwZkZ6VkI5c0VYWGpkRU9LNm12dmgyankycXl3REdlcERiLmVMUlMwS25YWUxtIjt9',1676098060);

/*Table structure for table `users` */

DROP TABLE IF EXISTS `users`;

CREATE TABLE `users` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `_token` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `role` enum('user','admin') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'user',
  `family_name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_permitted` tinyint(1) NOT NULL DEFAULT 0,
  `discord_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `line_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=24 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `users` */

insert  into `users`(`id`,`_token`,`email`,`email_verified_at`,`password`,`role`,`family_name`,`is_permitted`,`discord_id`,`line_id`,`created_at`,`updated_at`) values 
(1,'oYpyq8Uf7X03gcQYVYIPcLz6DdwRxxkAIHHrgWre','nonaka@gmail.com',NULL,'$2y$10$5POdDNF0fFzVB9sEXXjdEOK6mvvh2jy2qywDGepDb.eLRS0KnXYLm','admin','のなかけいた',1,NULL,'1qaz2wsx3edc4rfv5tgb6yhn7ujm8ik9ol0p','2022-12-12 18:30:07','2023-02-06 14:25:43');

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
