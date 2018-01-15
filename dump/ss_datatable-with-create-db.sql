-- Adminer 4.3.1 MySQL dump

SET NAMES utf8;
SET time_zone = '+00:00';
SET foreign_key_checks = 0;
SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO';

SET NAMES utf8mb4;

CREATE DATABASE `ss_datatable` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci */;
USE `ss_datatable`;

CREATE TABLE `category` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `name` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `slug` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `total` int(11) NOT NULL DEFAULT '0',
  `created` datetime NOT NULL,
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `name` (`name`(191)),
  KEY `slug` (`slug`(191))
) ENGINE=InnoDB AUTO_INCREMENT=89 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `category` (`id`, `name`, `slug`, `total`, `created`, `modified`) VALUES
(70,	'Umum',	'umum',	0,	'2017-11-09 14:29:20',	'2017-12-04 15:39:33'),
(71,	'Hiburan',	'hiburan',	10,	'2017-11-09 14:29:20',	NULL),
(72,	'Perjalanan & Pariwisata',	'perjalanan-pariwisata',	0,	'2017-11-09 14:29:20',	NULL),
(73,	'Sains & Teknologi',	'sains-teknologi',	5,	'2017-11-09 14:29:20',	NULL),
(74,	'Kesenian',	'kesenian',	95,	'2017-11-09 14:29:20',	NULL),
(75,	'Transportasi',	'transportasi',	0,	'2017-11-09 14:29:20',	NULL),
(76,	'Sosial Budaya',	'sosial-budaya',	0,	'2017-11-09 14:29:20',	NULL),
(77,	'Ekonomi & Bisnis',	'ekonomi-bisnis',	0,	'2017-11-09 14:29:20',	NULL),
(78,	'Olahraga',	'olahraga',	12,	'2017-11-09 14:29:20',	NULL),
(79,	'Sejarah',	'sejarah',	19,	'2017-11-09 14:29:20',	NULL),
(80,	'Wawancara',	'wawancara',	2,	'2017-11-09 14:29:20',	NULL),
(81,	'Urban Development',	'urban-development',	0,	'2017-11-09 14:29:20',	NULL),
(82,	'Viral',	'viral',	94,	'2017-11-09 14:29:20',	NULL),
(83,	'Kekayaan Alam',	'kekayaan-alam',	0,	'2017-11-09 14:29:20',	NULL),
(84,	'Militer',	'militer',	0,	'2017-11-09 14:29:20',	NULL),
(85,	'Pendidikan',	'pendidikan',	0,	'2017-11-09 14:29:20',	NULL),
(86,	'Profil',	'profil',	0,	'2017-11-09 14:29:20',	NULL),
(87,	'Ulasan Kegiatan',	'ulasan-kegiatan',	0,	'2017-11-09 14:29:20',	NULL),
(88,	'Komunitas Ku',	'komunitas',	0,	'2017-11-09 14:29:20',	'2018-01-15 22:26:35');

CREATE TABLE `ci_sessions` (
  `id` varchar(128) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci NOT NULL,
  `timestamp` int(10) unsigned NOT NULL DEFAULT '0',
  `data` blob NOT NULL,
  PRIMARY KEY (`id`,`ip_address`),
  KEY `ci_sessions_timestamp` (`timestamp`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `ci_sessions` (`id`, `ip_address`, `timestamp`, `data`) VALUES
('kr94239rvsu7sprvvvl278squdpm53ll',	'127.0.0.1',	1516030137,	'__ci_last_regenerate|i:1516028924;');

-- 2018-01-15 15:34:01
