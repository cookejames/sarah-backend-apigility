CREATE TABLE `sensors` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL,
  `valueType` varchar(255) NOT NULL,
  `units` varchar(255) DEFAULT NULL,
  `isRanged` tinyint(4) NOT NULL,
  `rangeMin` float DEFAULT NULL,
  `rangeMax` float DEFAULT NULL,
  `scalingFactor` float DEFAULT '1',
  `isEnabled` tinyint(4) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`),
  KEY `Index 2` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8