-- phpMyAdmin SQL Dump
-- version 3.4.5
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Apr 22, 2012 at 08:55 PM
-- Server version: 5.5.16
-- PHP Version: 5.3.8

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `sbtemp`
--

-- --------------------------------------------------------

--
-- Table structure for table `space_roles`
--

CREATE TABLE IF NOT EXISTS `space_roles` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(50) DEFAULT NULL,
  `pages` smallint(6) DEFAULT NULL,
  `global` smallint(6) DEFAULT NULL,
  `dash` smallint(6) DEFAULT NULL,
  `users` smallint(6) DEFAULT NULL,
  `plugins` smallint(6) DEFAULT NULL,
  `worlds` smallint(6) DEFAULT NULL,
  `servers` smallint(6) DEFAULT NULL,
  `backups` smallint(6) DEFAULT NULL,
  `permissions` smallint(6) DEFAULT NULL,
  `timeline` smallint(6) DEFAULT NULL,
  `settings` smallint(6) DEFAULT NULL,
  `fallback` tinyint(4) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `space_roles`
--

INSERT INTO `space_roles` (`id`, `title`, `pages`, `global`, `dash`, `users`, `plugins`, `worlds`, `servers`, `backups`, `permissions`, `timeline`, `settings`, `fallback`) VALUES
(1, 'Owner', 63, 0, 0, 0, 0, 0, 0, NULL, NULL, NULL, 0, 0),
(2, 'Administrator', 63, 0, 0, 0, 0, 0, 0, NULL, NULL, NULL, NULL, 0),
(3, 'Moderator', 63, 127, 0, 0, 0, 0, 0, NULL, NULL, NULL, NULL, 0),
(4, 'Viewer', 1, 0, 0, 0, 0, 0, 0, NULL, NULL, NULL, NULL, 1);

-- --------------------------------------------------------

--
-- Table structure for table `space_servers`
--

CREATE TABLE IF NOT EXISTS `space_servers` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(50) DEFAULT NULL,
  `address` varchar(50) DEFAULT NULL,
  `external_address` varchar(50) DEFAULT NULL,
  `password` varchar(50) DEFAULT NULL,
  `port1` varchar(50) DEFAULT NULL,
  `port2` varchar(50) DEFAULT NULL,
  `default_role` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

-- --------------------------------------------------------

--
-- Table structure for table `space_servers_users`
--

CREATE TABLE IF NOT EXISTS `space_servers_users` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) unsigned NOT NULL,
  `server_id` int(10) unsigned NOT NULL,
  `role_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

-- --------------------------------------------------------

--
-- Table structure for table `space_users`
--

CREATE TABLE IF NOT EXISTS `space_users` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `favourite_server` int(10) unsigned NOT NULL DEFAULT '1',
  `username` varchar(50) DEFAULT NULL,
  `password` varchar(50) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  `theme` varchar(60) DEFAULT NULL,
  `language` varchar(50) DEFAULT NULL,
  `is_super` tinyint(4) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
