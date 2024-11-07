-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 06, 2024 at 08:02 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `cdcms_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `attendance`
--

CREATE TABLE `attendance` (
  `id` int(11) NOT NULL,
  `enrollment_id` int(11) NOT NULL,
  `date` date NOT NULL,
  `status` enum('Present','Absent') NOT NULL,
  `notes` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `attendance`
--

INSERT INTO `attendance` (`id`, `enrollment_id`, `date`, `status`, `notes`) VALUES
(14, 34, '2024-11-07', 'Present', 'Avtive in class');

-- --------------------------------------------------------

--
-- Table structure for table `babysitter_details`
--

CREATE TABLE `babysitter_details` (
  `babysitter_id` int(30) NOT NULL,
  `meta_field` text NOT NULL,
  `meta_value` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `babysitter_details`
--

INSERT INTO `babysitter_details` (`babysitter_id`, `meta_field`, `meta_value`) VALUES
(1, 'firstname', 'Claire'),
(1, 'middlename', 'C'),
(1, 'lastname', 'Blake'),
(1, 'gender', 'Female'),
(1, 'email', 'cblake@sample.com'),
(1, 'contact', '09123456789'),
(1, 'address', 'Here Street, There City, Anywhere, 1014'),
(1, 'skills', 'Achievement 101, Achievement 102, Achievement 103, Achievement 104, and Achievement 105'),
(1, 'years_experience', '5'),
(1, 'other', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nullam id augue est. Praesent eu augue efficitur, sodales lacus eget, sagittis est. Praesent ultricies eleifend facilisis. Praesent maximus justo tellus, in pharetra nulla mollis ut. Interdum et malesuada fames ac ante ipsum primis in faucibus.'),
(1, 'firstname', 'Claire'),
(1, 'middlename', 'C'),
(1, 'lastname', 'Blake'),
(1, 'gender', 'Female'),
(1, 'email', 'cblake@sample.com'),
(1, 'contact', '09123456789'),
(1, 'address', 'Here Street, There City, Anywhere, 1014'),
(1, 'skills', 'Skill 101, Skill 102, Skill 103, Skill 104, and Skill 105'),
(1, 'years_experience', '5'),
(1, 'achievement', 'Achievement 101, Achievement 102, Achievement 103, Achievement 104, and Achievement 105'),
(1, 'other', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nullam id augue est. Praesent eu augue efficitur, sodales lacus eget, sagittis est. Praesent ultricies eleifend facilisis. Praesent maximus justo tellus, in pharetra nulla mollis ut. Interdum et malesuada fames ac ante ipsum primis in faucibus.'),
(1, 'firstname', 'Claire'),
(1, 'middlename', 'C'),
(1, 'lastname', 'Blake'),
(1, 'gender', 'Female'),
(1, 'email', 'cblake@sample.com'),
(1, 'contact', '09123456789'),
(1, 'address', 'Here Street, There City, Anywhere, 1014'),
(1, 'skills', 'Skill 101, Skill 102, Skill 103, Skill 104, and Skill 105'),
(1, 'years_experience', '5'),
(1, 'achievement', 'Achievement 101, Achievement 102, Achievement 103, Achievement 104, and Achievement 105'),
(1, 'other', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nullam id augue est. Praesent eu augue efficitur, sodales lacus eget, sagittis est. Praesent ultricies eleifend facilisis. Praesent maximus justo tellus, in pharetra nulla mollis ut. Interdum et malesuada fames ac ante ipsum primis in faucibus.'),
(2, 'firstname', 'Mark'),
(2, 'middlename', 'D'),
(2, 'lastname', 'Cooper'),
(2, 'gender', 'Male'),
(2, 'email', 'mcooper@sample.com'),
(2, 'contact', '09123456789'),
(2, 'address', 'Sample Address'),
(2, 'skills', 'Sample Skills'),
(2, 'years_experience', '2'),
(2, 'achievement', 'Sample Achievements'),
(2, 'other', 'Sample Other'),
(3, 'firstname', 'Samantha'),
(3, 'middlename', ''),
(3, 'lastname', 'Lou'),
(3, 'gender', 'Female'),
(3, 'email', 'slou@sample.com'),
(3, 'contact', '09786654499'),
(3, 'address', 'Sample Address 101'),
(3, 'skills', 'Sample Skills 101'),
(3, 'years_experience', '1'),
(3, 'achievement', 'Sample Achievements 101'),
(3, 'other', 'N/A'),
(4, 'firstname', 'Cynthia'),
(4, 'middlename', 'C'),
(4, 'lastname', 'Anthony'),
(4, 'gender', 'Female'),
(4, 'email', 'canthony@sample.com'),
(4, 'contact', '09875469999'),
(4, 'address', 'Sample Address 102'),
(4, 'skills', 'Sample Skill 102'),
(4, 'years_experience', '2'),
(4, 'achievement', 'Sample Achievements 102'),
(4, 'other', 'N/A'),
(4, 'firstname', 'Cynthia'),
(4, 'middlename', 'C'),
(4, 'lastname', 'Anthony'),
(4, 'gender', 'Female'),
(4, 'email', 'canthony@sample.com'),
(4, 'contact', '09875469999'),
(4, 'address', 'Sample Address 102'),
(4, 'skills', 'Sample Skill 102'),
(4, 'years_experience', '2'),
(4, 'achievement', 'Sample Achievements 102'),
(4, 'other', 'N/A'),
(4, 'firstname', 'Cynthia'),
(4, 'middlename', 'C'),
(4, 'lastname', 'Anthony'),
(4, 'gender', 'Female'),
(4, 'email', 'canthony@sample.com'),
(4, 'contact', '09875469999'),
(4, 'address', 'Sample Address 102'),
(4, 'skills', 'Sample Skill 102'),
(4, 'years_experience', '2'),
(4, 'achievement', 'Sample Achievements 102'),
(4, 'other', 'N/A');

-- --------------------------------------------------------

--
-- Table structure for table `babysitter_list`
--

CREATE TABLE `babysitter_list` (
  `id` int(30) NOT NULL,
  `code` varchar(50) NOT NULL DEFAULT '50',
  `fullname` text NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `date_created` datetime NOT NULL DEFAULT current_timestamp(),
  `date_updated` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `babysitter_list`
--

INSERT INTO `babysitter_list` (`id`, `code`, `fullname`, `status`, `date_created`, `date_updated`) VALUES
(1, 'BS-2021120001', 'Blake, Claire C', 1, '2021-12-14 11:45:43', '2021-12-14 11:47:36'),
(2, 'BS-2021120002', 'Cooper, Mark D', 1, '2021-12-14 13:14:42', '2021-12-14 13:14:42'),
(3, 'BS-2021120003', 'Lou, Samantha ', 1, '2021-12-14 13:16:46', '2021-12-14 13:16:46'),
(4, 'BS-2021120004', 'Anthony, Cynthia C', 1, '2021-12-14 13:18:13', '2021-12-14 15:45:44');

-- --------------------------------------------------------

--
-- Table structure for table `billing`
--

CREATE TABLE `billing` (
  `id` int(11) NOT NULL,
  `enrollment_id` int(11) NOT NULL,
  `invoice_id` int(11) NOT NULL,
  `child_fullname` varchar(255) NOT NULL,
  `parent_fullname` varchar(255) NOT NULL,
  `service_id` int(11) DEFAULT NULL,
  `amount` decimal(10,2) DEFAULT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 0,
  `date_created` datetime DEFAULT current_timestamp(),
  `date_updated` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `billing`
--

INSERT INTO `billing` (`id`, `enrollment_id`, `invoice_id`, `child_fullname`, `parent_fullname`, `service_id`, `amount`, `status`, `date_created`, `date_updated`) VALUES
(30, 34, 32, '', '', 4, 300.00, 1, '2024-11-07 00:00:00', '2024-11-06 21:10:01'),
(31, 35, 33, '', '', 9, 400.00, 1, '2024-11-07 00:00:00', '2024-11-06 21:11:53'),
(32, 36, 34, '', '', 4, 300.00, 1, '2024-11-07 00:00:00', '2024-11-06 21:12:19');

-- --------------------------------------------------------

--
-- Table structure for table `enrollment_details`
--

CREATE TABLE `enrollment_details` (
  `enrollment_id` int(30) NOT NULL,
  `meta_field` text NOT NULL,
  `meta_value` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `enrollment_details`
--

INSERT INTO `enrollment_details` (`enrollment_id`, `meta_field`, `meta_value`) VALUES
(34, 'gender', 'Female'),
(34, 'dob', '2020-04-08'),
(34, 'address', '0'),
(34, 'child_firstname', 'Michelle'),
(34, 'child_middlename', 'Lexy'),
(34, 'child_lastname', 'Lexy'),
(34, 'gender', 'Female'),
(34, 'child_dob', '2021-07-19'),
(34, 'parent_firstname', 'Peter'),
(34, 'parent_middlename', 'Pan'),
(34, 'parent_lastname', 'Pan'),
(34, 'parent_contact', '09123456789'),
(34, 'parent_email', 'ppan@example.com'),
(34, 'address', 'Some Street, Some City, 1234'),
(34, 'child_fullname', 'Lexy, Michelle'),
(34, 'parent_fullname', 'Pan, Peter'),
(35, 'child_firstname', 'James'),
(35, 'child_middlename', 'D'),
(35, 'child_lastname', 'McDowell'),
(35, 'gender', 'Male'),
(35, 'child_dob', '2020-11-30'),
(35, 'parent_firstname', 'John'),
(35, 'parent_middlename', 'C'),
(35, 'parent_lastname', 'McDowell'),
(35, 'parent_contact', '09123789564'),
(35, 'parent_email', 'jMcDowell@sample.com'),
(35, 'address', 'Here Street, There City, Anywhere 2306'),
(35, 'child_fullname', 'McDowell, James D'),
(35, 'parent_fullname', 'McDowell, John C'),
(36, 'child_firstname', 'Sofie Angeline'),
(36, 'child_middlename', 'M'),
(36, 'child_lastname', 'Richards'),
(36, 'gender', 'Female'),
(36, 'child_dob', '2021-02-08'),
(36, 'parent_firstname', 'Maureen'),
(36, 'parent_middlename', 'D'),
(36, 'parent_lastname', 'Richards'),
(36, 'parent_contact', '09123987546'),
(36, 'parent_email', 'mrichards@gmail.com'),
(36, 'address', 'Over There Block, Lot Here, Down There City, Every...'),
(36, 'child_fullname', 'Richards, Sofie Angeline M'),
(36, 'parent_fullname', 'Richards, Maureen D'),
(37, 'child_firstname', 'Ethan'),
(37, 'child_middlename', 'Johnson'),
(37, 'child_lastname', 'Johnson'),
(37, 'gender', 'Male'),
(37, 'child_dob', '2021-03-15'),
(37, 'parent_firstname', 'Michael'),
(37, 'parent_middlename', 'Johnson'),
(37, 'parent_lastname', 'Johnson'),
(37, 'parent_contact', '09127894562'),
(37, 'parent_email', 'mjohnson@example.com'),
(37, 'address', 'Street Name, City, 4567'),
(37, 'child_fullname', 'Johnson, Ethan'),
(37, 'parent_fullname', 'Johnson, Michael'),
(38, 'child_firstname', 'Amelia'),
(38, 'child_middlename', 'Davis'),
(38, 'child_lastname', 'Davis'),
(38, 'gender', 'Female'),
(38, 'child_dob', '2020-08-19'),
(38, 'parent_firstname', 'Sarah'),
(38, 'parent_middlename', 'Davis'),
(38, 'parent_lastname', 'Davis'),
(38, 'parent_contact', '09128563245'),
(38, 'parent_email', 'sdavis@example.com'),
(38, 'address', 'Another Street, City, 6789'),
(38, 'child_fullname', 'Davis, Amelia D'),
(38, 'parent_fullname', 'Davis, Sarah D'),
(39, 'child_firstname', 'Oliver'),
(39, 'child_middlename', 'Miller'),
(39, 'child_lastname', 'Miller'),
(39, 'gender', 'Male'),
(39, 'child_dob', '2021-01-10'),
(39, 'parent_firstname', 'David'),
(39, 'parent_middlename', 'Miller'),
(39, 'parent_lastname', 'Miller'),
(39, 'parent_contact', '09124587654'),
(39, 'parent_email', 'dmiller@example.com'),
(39, 'address', 'Street 3, City 3, 7890'),
(39, 'child_fullname', 'Miller, Oliver M'),
(39, 'parent_fullname', 'Miller, David M'),
(40, 'child_firstname', 'Lily'),
(40, 'child_middlename', 'Williams'),
(40, 'child_lastname', 'Williams'),
(40, 'gender', 'Female'),
(40, 'child_dob', '2021-09-12'),
(40, 'parent_firstname', 'Catherine'),
(40, 'parent_middlename', 'Williams'),
(40, 'parent_lastname', 'Williams'),
(40, 'parent_contact', '09127789867'),
(40, 'parent_email', 'catherine@example.com'),
(40, 'address', 'Somewhere Road, City, 0123'),
(40, 'child_fullname', 'Williams, Lily W'),
(40, 'parent_fullname', 'Williams, Catherine W'),
(41, 'child_firstname', 'Zoe'),
(41, 'child_middlename', 'Taylor'),
(41, 'child_lastname', 'Taylor'),
(41, 'gender', 'Female'),
(41, 'child_dob', '2020-10-21'),
(41, 'parent_firstname', 'Amanda'),
(41, 'parent_middlename', 'Taylor'),
(41, 'parent_lastname', 'Taylor'),
(41, 'parent_contact', '09125467891'),
(41, 'parent_email', 'amanda.taylor@example.com'),
(41, 'address', 'Block D, City Center, 6543'),
(41, 'child_fullname', 'Taylor, Zoe T'),
(41, 'parent_fullname', 'Taylor, Amanda T'),
(42, 'child_firstname', 'Lucas'),
(42, 'child_middlename', 'Martin'),
(42, 'child_lastname', 'Martin'),
(42, 'gender', 'Male'),
(42, 'child_dob', '2021-11-01'),
(42, 'parent_firstname', 'Rachel'),
(42, 'parent_middlename', 'Martin'),
(42, 'parent_lastname', 'Martin'),
(42, 'parent_contact', '09129987654'),
(42, 'parent_email', 'rachel.martin@example.com'),
(42, 'address', 'New Street, City, 5432'),
(42, 'child_fullname', 'Martin, Lucas M'),
(42, 'parent_fullname', 'Martin, Rachel M'),
(43, 'child_firstname', 'Ella'),
(43, 'child_middlename', 'Garcia'),
(43, 'child_lastname', 'Garcia'),
(43, 'gender', 'Female'),
(43, 'child_dob', '2021-04-15'),
(43, 'parent_firstname', 'Peter'),
(43, 'parent_middlename', 'Garcia'),
(43, 'parent_lastname', 'Garcia'),
(43, 'parent_contact', '09126654321'),
(43, 'parent_email', 'pg@example.com'),
(43, 'address', 'Corner of Street, City, 1122'),
(43, 'child_fullname', 'Garcia, Ella G'),
(43, 'parent_fullname', 'Garcia, Peter G'),
(44, 'child_firstname', 'Matthew'),
(44, 'child_middlename', 'Wilson'),
(44, 'child_lastname', 'Wilson'),
(44, 'gender', 'Male'),
(44, 'child_dob', '2020-12-05'),
(44, 'parent_firstname', 'Emma'),
(44, 'parent_middlename', 'Wilson'),
(44, 'parent_lastname', 'Wilson'),
(44, 'parent_contact', '09125543987'),
(44, 'parent_email', 'emma.wilson@example.com'),
(44, 'address', 'North Block, City, 9999'),
(44, 'child_fullname', 'Wilson, Matthew W'),
(44, 'parent_fullname', 'Wilson, Emma W');

-- --------------------------------------------------------

--
-- Table structure for table `enrollment_list`
--

CREATE TABLE `enrollment_list` (
  `id` int(30) NOT NULL,
  `code` varchar(50) NOT NULL,
  `child_fullname` text NOT NULL,
  `parent_fullname` text NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 0,
  `date_created` datetime NOT NULL DEFAULT current_timestamp(),
  `date_updated` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `enrollment_list`
--

INSERT INTO `enrollment_list` (`id`, `code`, `child_fullname`, `parent_fullname`, `status`, `date_created`, `date_updated`) VALUES
(34, '672baad0defc4', 'Michelle  Lexy', 'Peter  Pan', 1, '2024-11-06 20:43:44', '2024-11-06 20:44:57'),
(35, 'ENR001', 'James McDowell', 'John McDowell', 1, '2024-11-06 20:59:47', '2024-11-06 20:59:47'),
(36, 'ENR002', 'Sofie Angeline Richards', 'Maureen Richards', 1, '2024-11-06 20:59:47', '2024-11-06 20:59:47'),
(37, 'ENR003', 'Ethan Johnson', 'Michael Johnson', 0, '2024-11-06 20:59:47', '2024-11-06 20:59:47'),
(38, 'ENR004', 'Amelia Davis', 'Sarah Davis', 1, '2024-11-06 20:59:47', '2024-11-06 20:59:47'),
(39, 'ENR005', 'Oliver Miller', 'David Miller', 1, '2024-11-06 20:59:47', '2024-11-06 20:59:47'),
(40, 'ENR006', 'Lily Williams', 'Catherine Williams', 0, '2024-11-06 20:59:47', '2024-11-06 20:59:47'),
(41, 'ENR007', 'Zoe Taylor', 'Amanda Taylor', 0, '2024-11-06 20:59:47', '2024-11-06 20:59:47'),
(42, 'ENR008', 'Lucas Martin', 'Rachel Martin', 1, '2024-11-06 20:59:47', '2024-11-06 20:59:47'),
(43, 'ENR009', 'Ella Garcia', 'Peter Garcia', 0, '2024-11-06 20:59:47', '2024-11-06 20:59:47'),
(44, 'ENR010', 'Matthew Wilson', 'Emma Wilson', 1, '2024-11-06 20:59:47', '2024-11-06 20:59:47');

-- --------------------------------------------------------

--
-- Table structure for table `invoices`
--

CREATE TABLE `invoices` (
  `id` int(11) NOT NULL,
  `enrollment_id` int(11) NOT NULL,
  `total_amount` decimal(10,2) NOT NULL,
  `status` enum('pending','paid') NOT NULL,
  `date_created` datetime NOT NULL DEFAULT current_timestamp(),
  `date_paid` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `invoices`
--

INSERT INTO `invoices` (`id`, `enrollment_id`, `total_amount`, `status`, `date_created`, `date_paid`) VALUES
(32, 34, 300.00, 'pending', '2024-11-06 21:10:01', NULL),
(33, 35, 400.00, 'pending', '2024-11-06 21:11:53', NULL),
(34, 36, 300.00, 'pending', '2024-11-06 21:12:19', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `invoice_items`
--

CREATE TABLE `invoice_items` (
  `id` int(11) NOT NULL,
  `invoice_id` int(11) NOT NULL,
  `service_id` int(11) NOT NULL,
  `description` text NOT NULL,
  `amount` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE `notifications` (
  `id` int(11) NOT NULL,
  `enrollment_id` int(11) NOT NULL,
  `message` varchar(255) NOT NULL,
  `status` enum('unread','read') DEFAULT 'unread',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `user_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `service_list`
--

CREATE TABLE `service_list` (
  `id` int(30) NOT NULL,
  `name` text NOT NULL,
  `description` text NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `date_created` datetime NOT NULL DEFAULT current_timestamp(),
  `date_updated` datetime DEFAULT NULL ON UPDATE current_timestamp(),
  `price` decimal(10,2) NOT NULL DEFAULT 0.00
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `service_list`
--

INSERT INTO `service_list` (`id`, `name`, `description`, `status`, `date_created`, `date_updated`, `price`) VALUES
(1, 'Infant Care', 'Specialized care for babies from newborn to 12 months, including bottle feeding, diaper changing, and sensory activities.', 1, '2021-12-14 10:02:00', '2024-11-06 21:08:37', 0.00),
(2, 'Toddler Care', 'Play-based learning to develop motor skills, language, and emotional growth, with a focus on creativity and socialization.', 1, '2021-12-14 10:02:23', '2024-11-06 21:08:37', 0.00),
(3, 'Preschool', 'Early childhood education to prepare children for school, focusing on literacy, math, and social skills.', 1, '2021-12-14 10:02:33', '2024-11-06 21:08:37', 0.00),
(4, 'After-School', 'Care for children after school hours, offering homework help, recreational activities, and transportation.', 1, '2021-12-14 10:02:52', '2024-11-06 21:08:37', 0.00),
(5, 'Summer Camp', 'Special seasonal programs with outdoor activities, field trips, and fun learning experiences.', 1, '2021-12-14 10:05:32', '2024-11-06 21:08:37', 0.00),
(6, 'Full-Day Care', 'All-day care for children, offering a balanced schedule of educational activities, meals, naps, and free play.', 1, '2024-11-06 21:11:27', '2024-11-06 21:11:27', 0.00),
(7, 'Part-Time Care', 'Flexible part-time care options for children, tailored to meet the needs of working parents.', 1, '2024-11-06 21:11:27', '2024-11-06 21:11:27', 0.00),
(8, 'Language Development', 'Programs designed to enhance communication skills in young children, focusing on speaking, listening, and vocabulary building.', 1, '2024-11-06 21:11:27', '2024-11-06 21:11:27', 0.00),
(9, 'Outdoor Adventure', 'Outdoor-focused programs where children engage in nature exploration, physical activities, and team-building games.', 1, '2024-11-06 21:11:27', '2024-11-06 21:11:27', 0.00),
(10, 'Special Needs Care', 'Individualized care and support for children with special needs, focusing on personalized attention and therapy.', 1, '2024-11-06 21:11:27', '2024-11-06 21:11:27', 0.00);

-- --------------------------------------------------------

--
-- Table structure for table `service_usage`
--

CREATE TABLE `service_usage` (
  `id` int(11) NOT NULL,
  `service_id` int(11) NOT NULL,
  `enrollment_id` int(11) NOT NULL,
  `date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `system_info`
--

CREATE TABLE `system_info` (
  `id` int(30) NOT NULL,
  `meta_field` text NOT NULL,
  `meta_value` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `system_info`
--

INSERT INTO `system_info` (`id`, `meta_field`, `meta_value`) VALUES
(1, 'name', 'Child Day Care Management System - PHP'),
(6, 'short_name', 'CDCMS - PHP'),
(11, 'logo', 'uploads/logo-1639445951.png'),
(13, 'user_avatar', 'uploads/user_avatar.jpg'),
(14, 'cover', 'uploads/cover-1639445951.png'),
(15, 'content', 'Array'),
(16, 'email', 'info@babycareXYZ.com'),
(17, 'contact', '09854698789 / 78945632'),
(18, 'from_time', '11:00'),
(19, 'to_time', '21:30'),
(20, 'address', 'ABC Street, There City, Here, 2306');

-- --------------------------------------------------------

--
-- Table structure for table `temp_enrollment`
--

CREATE TABLE `temp_enrollment` (
  `id` int(11) NOT NULL,
  `code` varchar(255) NOT NULL,
  `child_fullname` varchar(255) NOT NULL,
  `parent_fullname` varchar(255) NOT NULL,
  `parent_contact` varchar(50) NOT NULL,
  `parent_email` varchar(255) NOT NULL,
  `address` text NOT NULL,
  `status` tinyint(1) DEFAULT 0,
  `date_created` timestamp NOT NULL DEFAULT current_timestamp(),
  `date_updated` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `temp_enrollment`
--

INSERT INTO `temp_enrollment` (`id`, `code`, `child_fullname`, `parent_fullname`, `parent_contact`, `parent_email`, `address`, `status`, `date_created`, `date_updated`) VALUES
(1, '672a8a14c6936', 'melo  sfs', 'dadd  add', '24424', 'da@fd', 'fsf', 0, '2024-11-05 21:11:48', '2024-11-05 21:11:48'),
(2, '672a9dfc1ab23', 'mello  milka', 'dsd  dada', '42', 'ad@sf', 'sfsfs', 0, '2024-11-05 22:36:44', '2024-11-05 22:36:44');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(50) NOT NULL,
  `firstname` varchar(250) NOT NULL,
  `middlename` text DEFAULT NULL,
  `lastname` varchar(250) NOT NULL,
  `username` text NOT NULL,
  `password` text NOT NULL,
  `avatar` text DEFAULT NULL,
  `last_login` datetime DEFAULT NULL,
  `type` tinyint(1) NOT NULL DEFAULT 0,
  `status` int(1) NOT NULL DEFAULT 1 COMMENT '0=not verified, 1 = verified',
  `date_added` datetime NOT NULL DEFAULT current_timestamp(),
  `date_updated` datetime DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `firstname`, `middlename`, `lastname`, `username`, `password`, `avatar`, `last_login`, `type`, `status`, `date_added`, `date_updated`) VALUES
(1, 'Adminstrator', NULL, 'Admin', 'admin', '0192023a7bbd73250516f069df18b500', 'uploads/avatar-1.png?v=1639468007', NULL, 1, 1, '2021-01-20 14:02:37', '2021-12-14 15:47:08'),
(3, 'Claire', NULL, 'Blake', 'cblake', '4744ddea876b11dcb1d169fadf494418', 'uploads/avatar-3.png?v=1639467985', NULL, 2, 1, '2021-12-14 15:46:25', '2021-12-14 15:46:25');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `attendance`
--
ALTER TABLE `attendance`
  ADD PRIMARY KEY (`id`),
  ADD KEY `attendance_ibfk_1` (`enrollment_id`);

--
-- Indexes for table `babysitter_details`
--
ALTER TABLE `babysitter_details`
  ADD KEY `babysitter_id` (`babysitter_id`);

--
-- Indexes for table `babysitter_list`
--
ALTER TABLE `babysitter_list`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `billing`
--
ALTER TABLE `billing`
  ADD PRIMARY KEY (`id`),
  ADD KEY `enrollment_id` (`enrollment_id`),
  ADD KEY `billing_ibfk_2` (`invoice_id`);

--
-- Indexes for table `enrollment_details`
--
ALTER TABLE `enrollment_details`
  ADD KEY `enrollment_id` (`enrollment_id`);

--
-- Indexes for table `enrollment_list`
--
ALTER TABLE `enrollment_list`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `invoices`
--
ALTER TABLE `invoices`
  ADD PRIMARY KEY (`id`),
  ADD KEY `enrollment_id` (`enrollment_id`);

--
-- Indexes for table `invoice_items`
--
ALTER TABLE `invoice_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `invoice_id` (`invoice_id`),
  ADD KEY `service_id` (`service_id`);

--
-- Indexes for table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`id`),
  ADD KEY `enrollment_id` (`enrollment_id`);

--
-- Indexes for table `service_list`
--
ALTER TABLE `service_list`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `service_usage`
--
ALTER TABLE `service_usage`
  ADD PRIMARY KEY (`id`),
  ADD KEY `service_id` (`service_id`),
  ADD KEY `enrollment_id` (`enrollment_id`);

--
-- Indexes for table `system_info`
--
ALTER TABLE `system_info`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `temp_enrollment`
--
ALTER TABLE `temp_enrollment`
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
-- AUTO_INCREMENT for table `attendance`
--
ALTER TABLE `attendance`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `babysitter_list`
--
ALTER TABLE `babysitter_list`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `billing`
--
ALTER TABLE `billing`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT for table `enrollment_list`
--
ALTER TABLE `enrollment_list`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=45;

--
-- AUTO_INCREMENT for table `invoices`
--
ALTER TABLE `invoices`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT for table `invoice_items`
--
ALTER TABLE `invoice_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `notifications`
--
ALTER TABLE `notifications`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `service_list`
--
ALTER TABLE `service_list`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `service_usage`
--
ALTER TABLE `service_usage`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `system_info`
--
ALTER TABLE `system_info`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `temp_enrollment`
--
ALTER TABLE `temp_enrollment`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(50) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `attendance`
--
ALTER TABLE `attendance`
  ADD CONSTRAINT `attendance_ibfk_1` FOREIGN KEY (`enrollment_id`) REFERENCES `enrollment_list` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `babysitter_details`
--
ALTER TABLE `babysitter_details`
  ADD CONSTRAINT `babysitter_details_ibfk_1` FOREIGN KEY (`babysitter_id`) REFERENCES `babysitter_list` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `billing`
--
ALTER TABLE `billing`
  ADD CONSTRAINT `billing_ibfk_1` FOREIGN KEY (`enrollment_id`) REFERENCES `enrollment_list` (`id`),
  ADD CONSTRAINT `billing_ibfk_2` FOREIGN KEY (`invoice_id`) REFERENCES `invoices` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `enrollment_details`
--
ALTER TABLE `enrollment_details`
  ADD CONSTRAINT `enrollment_details_ibfk_1` FOREIGN KEY (`enrollment_id`) REFERENCES `enrollment_list` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `invoices`
--
ALTER TABLE `invoices`
  ADD CONSTRAINT `invoices_ibfk_1` FOREIGN KEY (`enrollment_id`) REFERENCES `enrollment_list` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `invoice_items`
--
ALTER TABLE `invoice_items`
  ADD CONSTRAINT `invoice_items_ibfk_1` FOREIGN KEY (`invoice_id`) REFERENCES `invoices` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `invoice_items_ibfk_2` FOREIGN KEY (`service_id`) REFERENCES `service_list` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `notifications`
--
ALTER TABLE `notifications`
  ADD CONSTRAINT `notifications_ibfk_1` FOREIGN KEY (`enrollment_id`) REFERENCES `enrollment_list` (`id`);

--
-- Constraints for table `service_usage`
--
ALTER TABLE `service_usage`
  ADD CONSTRAINT `service_usage_ibfk_1` FOREIGN KEY (`service_id`) REFERENCES `service_list` (`id`),
  ADD CONSTRAINT `service_usage_ibfk_2` FOREIGN KEY (`enrollment_id`) REFERENCES `enrollment_list` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
