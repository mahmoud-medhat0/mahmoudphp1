-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Server version:               10.4.24-MariaDB - mariadb.org binary distribution
-- Server OS:                    Win64
-- HeidiSQL Version:             12.1.0.6537
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


-- Dumping database structure for e-commerce
CREATE DATABASE IF NOT EXISTS `e-commerce` /*!40100 DEFAULT CHARACTER SET utf8mb4 */;
USE `e-commerce`;

-- Dumping structure for table e-commerce.addresses
CREATE TABLE IF NOT EXISTS `addresses` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `street` varchar(512) NOT NULL,
  `floor` char(20) NOT NULL,
  `building` char(20) NOT NULL,
  `flat` int(3) unsigned NOT NULL,
  `notes` varchar(50) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `user_id` bigint(20) unsigned NOT NULL,
  `region_id` bigint(20) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_addresses_users` (`user_id`),
  KEY `FK_addresses_regions` (`region_id`),
  CONSTRAINT `FK_addresses_regions` FOREIGN KEY (`region_id`) REFERENCES `regions` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `FK_addresses_users` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Data exporting was unselected.

-- Dumping structure for table e-commerce.admins
CREATE TABLE IF NOT EXISTS `admins` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(512) NOT NULL,
  `email` char(50) NOT NULL,
  `password` varchar(255) NOT NULL DEFAULT '0',
  `image` varchar(255) NOT NULL,
  `gender` enum('f','m') NOT NULL COMMENT 'f =>female m=>male',
  `verification_code` int(6) unsigned NOT NULL,
  `expired_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `status` tinyint(1) NOT NULL DEFAULT 0 COMMENT '0=>flase 1=>true',
  `email_verified_at` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`),
  UNIQUE KEY `image` (`image`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Data exporting was unselected.

-- Dumping structure for table e-commerce.admins_phone
CREATE TABLE IF NOT EXISTS `admins_phone` (
  `phone` int(11) NOT NULL,
  `Admins_id` bigint(20) unsigned NOT NULL,
  PRIMARY KEY (`phone`,`Admins_id`),
  KEY `FK_admins_phone_admins` (`Admins_id`),
  CONSTRAINT `FK_admins_phone_admins` FOREIGN KEY (`Admins_id`) REFERENCES `admins` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Data exporting was unselected.

-- Dumping structure for table e-commerce.brands
CREATE TABLE IF NOT EXISTS `brands` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(512) NOT NULL,
  `image` varchar(255) NOT NULL,
  `status` tinyint(1) NOT NULL COMMENT '0 => false 1 => true	',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `id_subcategories` bigint(20) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`),
  UNIQUE KEY `image` (`image`),
  KEY `FK_brands_subcategories` (`id_subcategories`),
  CONSTRAINT `FK_brands_subcategories` FOREIGN KEY (`id_subcategories`) REFERENCES `subcategories` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Data exporting was unselected.

-- Dumping structure for table e-commerce.categories
CREATE TABLE IF NOT EXISTS `categories` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name_en` varchar(512) NOT NULL,
  `name_ar` varchar(512) NOT NULL,
  `image` varchar(255) NOT NULL DEFAULT '',
  `status` tinyint(1) NOT NULL DEFAULT 0 COMMENT '	0 => false 1 => true	',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `name_en` (`name_en`),
  UNIQUE KEY `name_ar` (`name_ar`),
  UNIQUE KEY `image` (`image`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Data exporting was unselected.

-- Dumping structure for table e-commerce.cities
CREATE TABLE IF NOT EXISTS `cities` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name_en` varchar(512) NOT NULL,
  `name_ar` varchar(512) NOT NULL,
  `status` tinyint(1) NOT NULL COMMENT '	0 => false 1 => true	',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `name_en` (`name_en`),
  UNIQUE KEY `name_ar` (`name_ar`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Data exporting was unselected.

-- Dumping structure for table e-commerce.coupons
CREATE TABLE IF NOT EXISTS `coupons` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `code` varchar(10) NOT NULL,
  `discount` int(3) NOT NULL,
  `discount_type` int(11) NOT NULL,
  `max_discount_value` int(11) NOT NULL,
  `max_usage` int(11) NOT NULL,
  `max_usage_per_user` int(11) NOT NULL,
  `mini_order` int(11) NOT NULL,
  `start_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `end_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `code` (`code`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Data exporting was unselected.

-- Dumping structure for table e-commerce.fav
CREATE TABLE IF NOT EXISTS `fav` (
  `user_id` bigint(20) unsigned NOT NULL,
  `product_id` bigint(20) unsigned NOT NULL,
  PRIMARY KEY (`user_id`,`product_id`),
  KEY `FK_fav_products` (`product_id`),
  CONSTRAINT `FK_fav_products` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `FK_fav_users` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Data exporting was unselected.

-- Dumping structure for table e-commerce.offers
CREATE TABLE IF NOT EXISTS `offers` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(50) NOT NULL,
  `image` varchar(255) NOT NULL,
  `discount` int(11) NOT NULL,
  `discount_type` int(11) NOT NULL DEFAULT 0,
  `start_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `end_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `image` (`image`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Data exporting was unselected.

-- Dumping structure for table e-commerce.offers_products
CREATE TABLE IF NOT EXISTS `offers_products` (
  `offer_id` bigint(20) unsigned NOT NULL,
  `product_id` bigint(20) unsigned NOT NULL,
  `price_after_offer` int(11) unsigned NOT NULL,
  PRIMARY KEY (`product_id`,`offer_id`),
  KEY `FK_offers_products_offers` (`offer_id`),
  CONSTRAINT `FK_offers_products_offers` FOREIGN KEY (`offer_id`) REFERENCES `offers` (`id`),
  CONSTRAINT `FK_offers_products_products` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Data exporting was unselected.

-- Dumping structure for table e-commerce.orders
CREATE TABLE IF NOT EXISTS `orders` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `total_price` int(11) unsigned NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 0 COMMENT '0 => pending 1 => in progres 2=>delevered	',
  `delivered_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `addres_id` bigint(20) unsigned NOT NULL,
  `coupoun_id` bigint(20) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_orders_addresses` (`addres_id`),
  KEY `FK_orders_coupons` (`coupoun_id`),
  CONSTRAINT `FK_orders_addresses` FOREIGN KEY (`addres_id`) REFERENCES `addresses` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `FK_orders_coupons` FOREIGN KEY (`coupoun_id`) REFERENCES `coupons` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Data exporting was unselected.

-- Dumping structure for table e-commerce.order_products
CREATE TABLE IF NOT EXISTS `order_products` (
  `order_id` bigint(20) unsigned NOT NULL,
  `product_id` bigint(20) unsigned NOT NULL,
  `quantitiy` int(11) NOT NULL,
  `price` decimal(7,2) NOT NULL,
  PRIMARY KEY (`order_id`,`product_id`),
  KEY `FK_order_products_products` (`product_id`),
  CONSTRAINT `FK_order_products_orders` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `FK_order_products_products` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Data exporting was unselected.

-- Dumping structure for table e-commerce.products
CREATE TABLE IF NOT EXISTS `products` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name_en` varchar(512) NOT NULL,
  `name_ar` varchar(512) NOT NULL,
  `price` decimal(7,2) NOT NULL,
  `quantitiy` smallint(3) NOT NULL DEFAULT 1,
  `status` tinyint(1) NOT NULL COMMENT '0 => false 1 => true',
  `details_ar` text NOT NULL,
  `details_en` text NOT NULL,
  `image` varchar(255) NOT NULL,
  `code` mediumint(9) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL,
  `sub_categories_id` bigint(20) unsigned NOT NULL,
  `brand_id` bigint(20) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `code` (`code`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Data exporting was unselected.

-- Dumping structure for table e-commerce.products_specs
CREATE TABLE IF NOT EXISTS `products_specs` (
  `product_id` bigint(20) unsigned NOT NULL,
  `spec_id` bigint(20) unsigned NOT NULL,
  `value` int(11) NOT NULL,
  PRIMARY KEY (`product_id`,`spec_id`),
  KEY `FK_products_specs_specs` (`spec_id`),
  CONSTRAINT `FK_products_specs_products` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`),
  CONSTRAINT `FK_products_specs_specs` FOREIGN KEY (`spec_id`) REFERENCES `specs` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Data exporting was unselected.

-- Dumping structure for table e-commerce.regions
CREATE TABLE IF NOT EXISTS `regions` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name_en` varchar(512) NOT NULL,
  `name_ar` varchar(512) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 0 COMMENT '0 => false 1 => true	',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `city_id` bigint(20) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name_en` (`name_en`),
  UNIQUE KEY `name_ar` (`name_ar`),
  KEY `FK_regions_cities` (`city_id`),
  CONSTRAINT `FK_regions_cities` FOREIGN KEY (`city_id`) REFERENCES `cities` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Data exporting was unselected.

-- Dumping structure for table e-commerce.specs
CREATE TABLE IF NOT EXISTS `specs` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Data exporting was unselected.

-- Dumping structure for table e-commerce.subcategories
CREATE TABLE IF NOT EXISTS `subcategories` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name_en` varchar(512) NOT NULL,
  `name_ar` varchar(512) NOT NULL,
  `image` varchar(255) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 0 COMMENT '0 => false 1 => true	',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `id_categories` bigint(20) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `image` (`image`),
  KEY `FK_subcategories_categories` (`id_categories`),
  CONSTRAINT `FK_subcategories_categories` FOREIGN KEY (`id_categories`) REFERENCES `categories` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Data exporting was unselected.

-- Dumping structure for table e-commerce.users
CREATE TABLE IF NOT EXISTS `users` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name_en` varchar(512) NOT NULL,
  `name_ar` varchar(512) NOT NULL,
  `email` char(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `image` varchar(255) DEFAULT '"path/to/default/photo"',
  `gender` enum('f','m') NOT NULL COMMENT 'f=>female m=>male',
  `verification_code` int(6) unsigned NOT NULL,
  `expired_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `status` tinyint(1) NOT NULL DEFAULT 0 COMMENT '0 => banned 1 => actived	',
  `email_verified_at` enum('Y','N') NOT NULL DEFAULT 'N' COMMENT 'y=> verified n=>not_actived',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Data exporting was unselected.

-- Dumping structure for table e-commerce.users_phone
CREATE TABLE IF NOT EXISTS `users_phone` (
  `phone` int(11) unsigned NOT NULL,
  `user_id` bigint(20) unsigned NOT NULL DEFAULT 0,
  PRIMARY KEY (`phone`,`user_id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Data exporting was unselected.

-- Dumping structure for table e-commerce.user_products
CREATE TABLE IF NOT EXISTS `user_products` (
  `user_id` bigint(20) unsigned NOT NULL DEFAULT 0,
  `product_id` bigint(20) unsigned NOT NULL DEFAULT 0,
  PRIMARY KEY (`user_id`,`product_id`),
  KEY `FK_user_products_products` (`product_id`),
  CONSTRAINT `FK_user_products_products` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `FK_user_products_users` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Data exporting was unselected.

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
