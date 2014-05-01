CREATE TABLE `sensorValues` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `sensor` int(10) unsigned NOT NULL,
  `value` varchar(255) NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `sensor` (`sensor`),
  KEY `date` (`date`),
  CONSTRAINT `FK_sensorValues_sensors` FOREIGN KEY (`sensor`) REFERENCES `sensors` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8