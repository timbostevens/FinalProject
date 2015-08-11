-- phpMyAdmin SQL Dump
-- version 4.4.3
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Aug 11, 2015 at 11:19 AM
-- Server version: 5.6.24
-- PHP Version: 5.6.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `test`
--
CREATE DATABASE IF NOT EXISTS `test` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `test`;

DELIMITER $$
--
-- Procedures
--
DROP PROCEDURE IF EXISTS `test_multi_sets`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `test_multi_sets`()
    DETERMINISTIC
begin
        select user() as first_col;
        select user() as first_col, now() as second_col;
        select user() as first_col, now() as second_col, now() as third_col;
        end$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `datapointsimport`
--

DROP TABLE IF EXISTS `datapointsimport`;
CREATE TABLE IF NOT EXISTS `datapointsimport` (
  `point_id` int(11) NOT NULL DEFAULT '0',
  `journey_id` int(11) NOT NULL DEFAULT '0',
  `point_timestamp` timestamp NULL DEFAULT NULL,
  `lat_dd` float DEFAULT NULL,
  `long_dd` float DEFAULT NULL,
  `battery_percent` float DEFAULT NULL,
  `dist_from_prev_mi` float DEFAULT NULL,
  `velocity_mph` float DEFAULT NULL,
  `time_elapsed_sec` float DEFAULT NULL,
  `MPG` float DEFAULT NULL,
  `total_dist_mi` float DEFAULT NULL,
  `route` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `datapointsimport`
--

INSERT INTO `datapointsimport` (`point_id`, `journey_id`, `point_timestamp`, `lat_dd`, `long_dd`, `battery_percent`, `dist_from_prev_mi`, `velocity_mph`, `time_elapsed_sec`, `MPG`, `total_dist_mi`, `route`) VALUES
(1, 1, '2015-01-23 15:20:00', 54.5798, -6.93619, 99.37, 0, 0, 1.14716, 0, 0, 0),
(1, 2, '2015-07-08 14:20:00', 54.5798, -7.93619, 99.37, 0, 0, 1.14716, 0, 0, 0),
(1, 3, '2015-07-07 14:20:00', 54.5798, -5.93619, 99.37, 0, 0, 1.14716, 0, 0, 0),
(2, 1, '2015-01-23 15:20:05', 54.5798, -6.93618, 99.36, 0.00046318, 1.66745, 6.14511, 0, 0.00046318, 0),
(2, 2, '2015-07-08 14:20:05', 54.5798, -7.93618, 99.36, 0.00046318, 1.66745, 6.14511, 0, 0.00046318, 0),
(2, 3, '2015-07-07 14:20:05', 54.5798, -5.93618, 99.36, 0.00046318, 1.66745, 6.14511, 0, 0.00046318, 0),
(3, 1, '2015-01-23 15:20:10', 54.5798, -6.93618, 99.35, 0.00133794, 4.81657, 11.196, 0, 0.00180112, 0),
(3, 2, '2015-07-08 14:20:10', 54.5798, -7.93618, 99.35, 0.00133794, 4.81657, 11.196, 0, 0.00180112, 0),
(3, 3, '2015-07-07 14:20:10', 54.5798, -5.93618, 99.35, 0.00133794, 4.81657, 11.196, 0, 0.00180112, 0);

-- --------------------------------------------------------

--
-- Table structure for table `journeysimport`
--

DROP TABLE IF EXISTS `journeysimport`;
CREATE TABLE IF NOT EXISTS `journeysimport` (
  `journey_id` int(11) NOT NULL DEFAULT '0',
  `upload_timestamp` timestamp NULL DEFAULT NULL,
  `source_file` varchar(100) DEFAULT NULL,
  `journey_date` date DEFAULT NULL,
  `start_time` time DEFAULT NULL,
  `end_time` time DEFAULT NULL,
  `average_speed_mph` float(5,2) DEFAULT NULL,
  `distance_mi` float DEFAULT NULL,
  `duration_mins` int(11) DEFAULT NULL,
  `energy_saved` int(11) DEFAULT NULL,
  `co2_saved` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `journeysimport`
--

INSERT INTO `journeysimport` (`journey_id`, `upload_timestamp`, `source_file`, `journey_date`, `start_time`, `end_time`, `average_speed_mph`, `distance_mi`, `duration_mins`, `energy_saved`, `co2_saved`) VALUES
(1, '2015-08-11 09:14:51', 'source/SmallJan.json', '2015-01-23', '15:20:00', '15:20:10', 0.58, 0.00180112, 0, NULL, NULL),
(2, '2015-08-11 09:14:51', 'source/SmallJul2.json', '2015-07-08', '15:20:00', '15:20:10', 0.58, 0.00180112, 0, NULL, NULL),
(3, '2015-08-11 09:14:51', 'source/SmallJuly.json', '2015-07-07', '15:20:00', '15:20:10', 0.58, 0.00180112, 0, NULL, NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `datapointsimport`
--
ALTER TABLE `datapointsimport`
  ADD PRIMARY KEY (`point_id`,`journey_id`),
  ADD KEY `journey_id` (`journey_id`);

--
-- Indexes for table `journeysimport`
--
ALTER TABLE `journeysimport`
  ADD PRIMARY KEY (`journey_id`);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `datapointsimport`
--
ALTER TABLE `datapointsimport`
  ADD CONSTRAINT `datapointsimport_ibfk_1` FOREIGN KEY (`journey_id`) REFERENCES `journeysimport` (`journey_id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
