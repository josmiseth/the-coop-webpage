-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Jun 01, 2024 at 23:09 PM
-- Server version: 10.4.18-MariaDB
-- PHP Version: 8.0.5

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


-- Database: `hatch_position`
--

--
-- --------------------------------------------------------

-- Table structure for table `hatch_position`
--

CREATE TABLE `hatch_position` (
  `id` int(10) NOT NULL,
  `status` int(2) NOT NULL,
  `pos` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
--
-- Indexes for table `hatch_position`
--
ALTER TABLE `hatch_position`
  ADD PRIMARY KEY (`id`);

INSERT INTO `hatch_position` (`id`, `status`, `pos`) VALUES
(1, 0, 'CLOSED'),
(2, 1, 'OPEN'),
(3, 2, 'IN MOTION')
