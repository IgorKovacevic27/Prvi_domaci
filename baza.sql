/*
SQLyog Community
MySQL - 10.4.11-MariaDB : Database - sport
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`sport` /*!40100 DEFAULT CHARACTER SET utf8mb4 */;

USE `sport`;

/*Table structure for table `igrac` */

DROP TABLE IF EXISTS `igrac`;

CREATE TABLE `igrac` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `ime` varchar(30) DEFAULT NULL,
  `prezime` varchar(30) DEFAULT NULL,
  `broj` int(11) DEFAULT NULL,
  `tim_id` bigint(20) unsigned DEFAULT NULL,
  `pozicija_id` bigint(20) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `pozicija_id` (`pozicija_id`),
  KEY `igrac_ibfk_1` (`tim_id`),
  CONSTRAINT `igrac_ibfk_1` FOREIGN KEY (`tim_id`) REFERENCES `tim` (`id`) ON DELETE SET NULL,
  CONSTRAINT `igrac_ibfk_2` FOREIGN KEY (`pozicija_id`) REFERENCES `pozicija` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4;

/*Data for the table `igrac` */

insert  into `igrac`(`id`,`ime`,`prezime`,`broj`,`tim_id`,`pozicija_id`) values 
(7,'Waynevfbgfsdg','VBGNV',55,3,4);

/*Table structure for table `pozicija` */

DROP TABLE IF EXISTS `pozicija`;

CREATE TABLE `pozicija` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `naziv` varchar(30) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4;

/*Data for the table `pozicija` */

insert  into `pozicija`(`id`,`naziv`) values 
(1,'golman'),
(2,'stoper'),
(3,'bek'),
(4,'krilo'),
(5,'vezni'),
(6,'napadac'),
(7,'spic');

/*Table structure for table `tim` */

DROP TABLE IF EXISTS `tim`;

CREATE TABLE `tim` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `naziv` varchar(60) DEFAULT NULL,
  `skraceno` varchar(5) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4;

/*Data for the table `tim` */

insert  into `tim`(`id`,`naziv`,`skraceno`) values 
(1,'zfb','VDFBG'),
(3,'Liverpoolasgdhf','LIV34'),
(4,'Everton','EVE'),
(5,'Mancester city dafdsgh','MCI');

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
