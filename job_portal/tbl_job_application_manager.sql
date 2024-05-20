-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 01, 2021 at 11:48 AM
-- Server version: 10.4.14-MariaDB
-- PHP Version: 7.4.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `sjpuc_schoolphins_v2`
--

-- --------------------------------------------------------

--
-- Table structure for table `tbl_job_application_manager`
--

CREATE TABLE `tbl_job_application_manager` (
  `row_id` int(64) NOT NULL,
  `subject` varchar(256) NOT NULL,
  `fullname` varchar(1024) NOT NULL,
  `qualification` varchar(256) NOT NULL,
  `sslc_percent` double(5,2) NOT NULL,
  `puc_percent` double(5,2) NOT NULL,
  `ug_percent` double(5,2) NOT NULL,
  `pg_percent` double(5,2) NOT NULL,
  `bed_percent` double(5,2) NOT NULL,
  `mobile_number` varchar(16) NOT NULL,
  `email_id` varchar(1024) NOT NULL,
  `religion` varchar(1024) NOT NULL,
  `cast` varchar(1024) NOT NULL,
  `dob` date NOT NULL,
  `marital_status` varchar(64) NOT NULL,
  `work_experience` double(5,2) NOT NULL,
  `expected_salary` double(10,2) NOT NULL,
  `blood_group` varchar(8) NOT NULL,
  `mother_tongue` varchar(64) NOT NULL,
  `languages_known` varchar(2048) NOT NULL,
  `additional_qualification` varchar(1024) NOT NULL,
  `hobbies_interests` varchar(2048) NOT NULL,
  `address` text NOT NULL,
  `profile_picture` text NOT NULL,
  `resume` text NOT NULL,
  `created_date_time` datetime NOT NULL,
  `updated_by` varchar(128) NOT NULL,
  `updated_date_time` datetime NOT NULL,
  `status` tinyint(1) NOT NULL,
  `is_deleted` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tbl_job_application_manager`
--
ALTER TABLE `tbl_job_application_manager`
  ADD PRIMARY KEY (`row_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tbl_job_application_manager`
--
ALTER TABLE `tbl_job_application_manager`
  MODIFY `row_id` int(64) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
