-- phpMyAdmin SQL Dump
-- version 4.6.5.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 30, 2017 at 08:25 AM
-- Server version: 10.1.21-MariaDB
-- PHP Version: 7.1.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- Database: `earthfire`
--

-- --------------------------------------------------------

--
-- Table structure for table `incident`
--

CREATE TABLE `incident` (
  `id` int(11) NOT NULL,
  `user` int(11) NOT NULL,
  `type` varchar(32) CHARACTER SET utf8mb4 NOT NULL,
  `news` text CHARACTER SET utf8mb4 NOT NULL,
  `image` text CHARACTER SET utf8mb4 NOT NULL,
  `video` text CHARACTER SET utf8mb4 NOT NULL,
  `location` text CHARACTER SET utf8mb4 NOT NULL,
  `lat` float NOT NULL,
  `lon` float NOT NULL,
  `time` int(11) NOT NULL,
  `post_time` int(11) NOT NULL,
  `update_time` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `first_name` text CHARACTER SET utf8mb4 NOT NULL,
  `last_name` text CHARACTER SET utf8mb4 NOT NULL,
  `password` varchar(32) NOT NULL,
  `mail` text NOT NULL,
  `phone` text NOT NULL,
  `alert` tinyint(1) NOT NULL DEFAULT '0',
  `location` text CHARACTER SET utf8mb4 NOT NULL,
  `lat` float DEFAULT NULL,
  `lon` float DEFAULT NULL,
  `last_active` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;


ALTER TABLE `incident`
  ADD PRIMARY KEY (`id`);


ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD KEY `lat` (`lat`),
  ADD KEY `lon` (`lon`);
