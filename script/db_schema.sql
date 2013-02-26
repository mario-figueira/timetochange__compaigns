# --------------------------------------------------------
# Host:                         127.0.0.1
# Server version:               5.5.16
# Server OS:                    Win32
# HeidiSQL version:             6.0.0.3603
# Date/time:                    2013-02-26 10:03:59
# --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;

# Dumping structure for table app___hello_world
CREATE TABLE IF NOT EXISTS `app___hello_world` (
  `id` int(10) unsigned NOT NULL,
  `string_to_display` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

# Data exporting was unselected.


# Dumping structure for table app___users
CREATE TABLE IF NOT EXISTS `app___users` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `email` varchar(64) NOT NULL,
  `password` varchar(32) NOT NULL,
  `is_active` tinyint(4) NOT NULL DEFAULT '1',
  `record_creation_timestamp` datetime NOT NULL,
  `record_update_timestamp` datetime NOT NULL,
  `fk__user_community__id` int(11) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `app___users__uk_001` (`fk__user_community__id`,`email`),
  CONSTRAINT `app___user__fk_001` FOREIGN KEY (`fk__user_community__id`) REFERENCES `app___user_community` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

# Data exporting was unselected.


# Dumping structure for table app___user_community
CREATE TABLE IF NOT EXISTS `app___user_community` (
  `id` int(10) unsigned NOT NULL,
  `name` varchar(50) NOT NULL,
  `description` text,
  `is_active` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `record_creation_timestamp` datetime NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `app___user_community__uk_001` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

# Data exporting was unselected.


# Dumping structure for table app___zsystem_db_info
CREATE TABLE IF NOT EXISTS `app___zsystem_db_info` (
  `id` tinyint(3) unsigned NOT NULL DEFAULT '1',
  `database_version` smallint(5) unsigned NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

# Data exporting was unselected.
/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
