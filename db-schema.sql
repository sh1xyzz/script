-- Create database and tables for the Scriptovation project.
CREATE DATABASE IF NOT EXISTS `scriptovation` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE `scriptovation`;

CREATE TABLE IF NOT EXISTS `tracks` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `title` VARCHAR(200) NOT NULL,
  `slug` VARCHAR(200) NOT NULL,
  `short_description` TEXT NOT NULL,
  `level_description` VARCHAR(200) NOT NULL,
  `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `slug_unique` (`slug`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS `applications` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `reference` CHAR(10) NOT NULL,
  `name` VARCHAR(120) NOT NULL,
  `contact` VARCHAR(255) NOT NULL,
  `language` VARCHAR(200) NOT NULL,
  `message` TEXT NULL,
  `status` ENUM('new','reviewed','archived') NOT NULL DEFAULT 'new',
  `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `reference_unique` (`reference`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
