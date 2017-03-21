-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Mar 21, 2017 at 07:23 AM
-- Server version: 10.1.16-MariaDB
-- PHP Version: 7.0.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `cs372`
--

-- --------------------------------------------------------

--
-- Table structure for table `appointments`
--

CREATE TABLE `appointments` (
  `id` int(11) NOT NULL,
  `user` int(11) DEFAULT NULL,
  `stylist` int(11) DEFAULT NULL,
  `location` int(11) DEFAULT NULL,
  `service` varchar(32) NOT NULL,
  `details` varchar(255) DEFAULT NULL,
  `start` int(11) DEFAULT NULL,
  `end` int(11) DEFAULT NULL,
  `title` varchar(128) NOT NULL,
  `image` varchar(128) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `appointments`
--

INSERT INTO `appointments` (`id`, `user`, `stylist`, `location`, `service`, `details`, `start`, `end`, `title`, `image`) VALUES
(4, 3, 1, 1, '1', '', 1490695200, 1490697000, 'Appointment', ''),
(6, 3, 1, 1, '1', '', 1490868000, 1490869800, 'Appointment', ''),
(7, 3, 1, 1, '1', 'dsadasdasdasd', 1491040800, 1491042600, 'Appointment', '');

-- --------------------------------------------------------

--
-- Table structure for table `availability`
--

CREATE TABLE `availability` (
  `id` int(11) NOT NULL,
  `stylist` int(11) NOT NULL,
  `sun` tinyint(1) NOT NULL DEFAULT '1',
  `mon` tinyint(1) NOT NULL DEFAULT '1',
  `tues` tinyint(1) NOT NULL DEFAULT '1',
  `wed` tinyint(1) NOT NULL DEFAULT '1',
  `thurs` tinyint(1) NOT NULL DEFAULT '1',
  `fri` tinyint(1) NOT NULL DEFAULT '1',
  `sat` tinyint(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `availability`
--

INSERT INTO `availability` (`id`, `stylist`, `sun`, `mon`, `tues`, `wed`, `thurs`, `fri`, `sat`) VALUES
(1, 2, 0, 1, 0, 1, 0, 1, 0),
(2, 1, 0, 0, 1, 0, 1, 0, 1);

-- --------------------------------------------------------

--
-- Table structure for table `config`
--

CREATE TABLE `config` (
  `id` int(11) NOT NULL,
  `sun` tinyint(1) NOT NULL DEFAULT '1',
  `mon` tinyint(1) NOT NULL DEFAULT '1',
  `tues` tinyint(1) NOT NULL DEFAULT '1',
  `wed` tinyint(1) NOT NULL DEFAULT '1',
  `thurs` tinyint(1) NOT NULL DEFAULT '1',
  `fri` tinyint(1) NOT NULL DEFAULT '1',
  `sat` tinyint(1) NOT NULL DEFAULT '1',
  `open` time NOT NULL DEFAULT '10:00:00',
  `close` time NOT NULL DEFAULT '18:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `config`
--

INSERT INTO `config` (`id`, `sun`, `mon`, `tues`, `wed`, `thurs`, `fri`, `sat`, `open`, `close`) VALUES
(1, 0, 1, 1, 1, 1, 1, 1, '10:00:00', '18:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `locations`
--

CREATE TABLE `locations` (
  `id` int(11) NOT NULL,
  `country` varchar(256) NOT NULL,
  `province` varchar(256) NOT NULL,
  `city` varchar(256) NOT NULL,
  `address` varchar(256) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `locations`
--

INSERT INTO `locations` (`id`, `country`, `province`, `city`, `address`) VALUES
(1, 'Canada', 'Saskatchewan', 'Regina', 'Cornwall');

-- --------------------------------------------------------

--
-- Table structure for table `services`
--

CREATE TABLE `services` (
  `id` int(11) NOT NULL,
  `service` varchar(64) NOT NULL,
  `minutes` int(11) NOT NULL DEFAULT '30'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `services`
--

INSERT INTO `services` (`id`, `service`, `minutes`) VALUES
(1, 'Haircut', 30),
(2, 'Dye', 120),
(3, 'Perm', 120);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `firstName` varchar(128) NOT NULL,
  `lastName` varchar(128) NOT NULL,
  `birthday` date NOT NULL,
  `country` varchar(128) NOT NULL,
  `province` varchar(128) NOT NULL,
  `city` varchar(128) NOT NULL,
  `rank` int(11) NOT NULL DEFAULT '0',
  `location` int(11) DEFAULT NULL,
  `image` varchar(256) NOT NULL DEFAULT 'default.jpg'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `email`, `password`, `firstName`, `lastName`, `birthday`, `country`, `province`, `city`, `rank`, `location`, `image`) VALUES
(1, 'janedoe@email.com', '$2y$10$uDNJ4UoKDmV5WwMIfiWuJexCON1yMg4/JUP4I6iCPzmr4DikgOujq', 'Jane', 'Doe', '1978-01-01', 'Canada', 'Saskatchewan', 'Regina', 1, 1, 'default.jpg'),
(2, 'johndoe@email.com', '$2y$10$qNarlo.WZ7JxmcyrAWNnH.KtmPPxVlY48msKmabWgWdR3FdOCx0z6', 'John', 'Doe', '1977-09-01', 'Canada', 'Saskatchewan', 'Regina', 1, 1, 'default.jpg'),
(3, 'bobsmith@email.ca', '$2y$10$f9HbVk8xQNwPFL3wthEGUO8aYIJM0TejxFHw7X3.3g10yivkCDfqm', 'Bob', 'Smith', '1983-11-01', 'Canada', 'Saskatchewan', 'Regina', 0, 0, 'default.jpg');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `appointments`
--
ALTER TABLE `appointments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `availability`
--
ALTER TABLE `availability`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `config`
--
ALTER TABLE `config`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `locations`
--
ALTER TABLE `locations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `services`
--
ALTER TABLE `services`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `appointments`
--
ALTER TABLE `appointments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT for table `availability`
--
ALTER TABLE `availability`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `config`
--
ALTER TABLE `config`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `locations`
--
ALTER TABLE `locations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `services`
--
ALTER TABLE `services`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
