-- phpMyAdmin SQL Dump
-- version 4.0.10deb1
-- http://www.phpmyadmin.net
--
-- Client: localhost
-- Généré le: Dim 09 Novembre 2014 à 17:53
-- Version du serveur: 5.5.40-0ubuntu0.14.04.1
-- Version de PHP: 5.5.9-1ubuntu4.5

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de données: `ece_webarena`
--

-- --------------------------------------------------------

--
-- Structure de la table `events`
--

CREATE TABLE IF NOT EXISTS `events` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `date` datetime NOT NULL,
  `coordinate_x` int(11) NOT NULL,
  `coordinate_y` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Contenu de la table `events`
--

INSERT INTO `events` (`id`, `name`, `date`, `coordinate_x`, `coordinate_y`) VALUES
(1, 'Entrée de Aragorn', '2014-11-07 12:00:00', 2, 3);

-- --------------------------------------------------------

--
-- Structure de la table `fighters`
--

CREATE TABLE IF NOT EXISTS `fighters` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(45) NOT NULL,
  `player_id` char(36) NOT NULL,
  `coordinate_x` int(11) NOT NULL,
  `coordinate_y` int(11) NOT NULL,
  `level` int(11) NOT NULL,
  `xp` int(11) NOT NULL,
  `skill_sight` int(11) NOT NULL,
  `skill_strength` int(11) NOT NULL,
  `skill_health` int(11) NOT NULL,
  `current_health` int(11) NOT NULL,
  `next_action_time` datetime DEFAULT NULL,
  `guild_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fighters_id` (`player_id`),
  KEY `fighters_id1` (`guild_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Contenu de la table `fighters`
--

INSERT INTO `fighters` (`id`, `name`, `player_id`, `coordinate_x`, `coordinate_y`, `level`, `xp`, `skill_sight`, `skill_strength`, `skill_health`, `current_health`, `next_action_time`, `guild_id`) VALUES
(1, 'Aragorn', '545f827c-576c-4dc5-ab6d-27c33186dc3e', 2, 3, 3, 10, 2, 1, 3, 3, '0000-00-00 00:00:00', NULL),
(2, 'Angmar', '545f827c-576c-4dc5-ab6d-27c33186dc3e', 3, 3, 3, 10, 0, 1, 9, 9, '0000-00-00 00:00:00', NULL);

-- --------------------------------------------------------

--
-- Structure de la table `guilds`
--

CREATE TABLE IF NOT EXISTS `guilds` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(45) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Structure de la table `messages`
--

CREATE TABLE IF NOT EXISTS `messages` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `date` datetime NOT NULL,
  `title` varchar(45) NOT NULL,
  `message` text NOT NULL,
  `fighter_id_from` int(11) NOT NULL,
  `fighter_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `messages_id1` (`fighter_id`),
  KEY `messages_id2` (`fighter_id_from`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Structure de la table `players`
--

CREATE TABLE IF NOT EXISTS `players` (
  `id` char(36) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email_UNIQUE` (`email`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Contenu de la table `players`
--

INSERT INTO `players` (`id`, `email`, `password`) VALUES
('545f827c-576c-4dc5-ab6d-27c33186dc3e', 'admin@test.com', 'toto');

-- --------------------------------------------------------

--
-- Structure de la table `surroundings`
--

CREATE TABLE IF NOT EXISTS `surroundings` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type` varchar(45) NOT NULL,
  `coordinate_x` int(11) NOT NULL,
  `coordinate_y` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Structure de la table `tools`
--

CREATE TABLE IF NOT EXISTS `tools` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type` varchar(45) NOT NULL,
  `bonus` int(11) NOT NULL,
  `coordinate_x` int(11) DEFAULT NULL,
  `coordinate_y` int(11) DEFAULT NULL,
  `fighter_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `tools_id1` (`fighter_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
