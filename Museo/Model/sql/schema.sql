
CREATE DATABASE IF NOT EXISTS `museo` DEFAULT CHARACTER SET UTF8 COLLATE utf8_general_ci;
USE `museo`;

DROP TABLE IF EXISTS `museumcategory`;
DROP TABLE IF EXISTS `category`;
DROP TABLE IF EXISTS `museum`;

CREATE TABLE `category` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `parentid` int(10) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `category_parent` (`parentid`),
  UNIQUE KEY `unique_same_level` (`name`,`parentid`),
  CONSTRAINT `category_parent` FOREIGN KEY (`parentid`) 
    REFERENCES `category` (`id`) ON DELETE CASCADE ON UPDATE CASCADE  
) ENGINE=InnoDB DEFAULT CHARSET=UTF8 AUTO_INCREMENT=1 ;

CREATE TABLE `museum` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `description` varchar(1000) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=UTF8 AUTO_INCREMENT=1 ;

CREATE TABLE `museumcategory` (
  `category_id` int(10) NOT NULL DEFAULT '0',
  `museum_id` int(10) NOT NULL DEFAULT '0',
  PRIMARY KEY (`category_id`,`museum_id`),
  KEY `museum_id` (`museum_id`)
) ENGINE=InnoDB DEFAULT CHARSET=UTF8;
	
ALTER TABLE `museumcategory`
  ADD CONSTRAINT `museumcategory_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `category` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `museumcategory_ibfk_2` FOREIGN KEY (`museum_id`) REFERENCES `museum` (`id`) ON DELETE CASCADE;

