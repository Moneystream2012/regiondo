--
-- Table structure for table `bookings`
--

DROP TABLE IF EXISTS `bookings`;

CREATE TABLE `bookings` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `first_name` varchar(50) NOT NULL,
  `last_name` varchar(50) NOT NULL,
  `company` varchar(50) DEFAULT NULL,
  `booked_from` datetime NOT NULL,
  `booked_to` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='bookings for Regiondo';

--
-- Dumping data for table `bookings`
--

LOCK TABLES `bookings` WRITE;

INSERT INTO `bookings` (`first_name`, `last_name`, `company`, `booked_from`, `booked_to`)
VALUES
('Denys','Bulakh','Regiondo','2019-06-12 12:03:10','2019-06-12 16:03:10'),
('Andrii','Tarasenko','','2019-06-16 10:02:59','2019-06-16 12:02:59');

UNLOCK TABLES;
