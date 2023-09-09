-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 29, 2023 at 12:33 PM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ozone_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `admin_id` int(13) NOT NULL,
  `first_name` varchar(40) NOT NULL,
  `last_name` varchar(40) NOT NULL,
  `password` varchar(60) NOT NULL,
  `last_login` datetime NOT NULL,
  `is_deleted` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`admin_id`, `first_name`, `last_name`, `password`, `last_login`, `is_deleted`) VALUES
(1, 'admin', 'admin', '23d42f5f3f66498b2c8ff4c20b8c5ac826e47146', '2023-06-26 11:14:02', 0);

-- --------------------------------------------------------

--
-- Table structure for table `announcement`
--

CREATE TABLE `announcement` (
  `a_id` int(13) NOT NULL,
  `announcement` text NOT NULL,
  `active` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `announcement`
--

INSERT INTO `announcement` (`a_id`, `announcement`, `active`) VALUES
(2, 'open gym at 9.am', 'YES');

-- --------------------------------------------------------

--
-- Table structure for table `manager`
--

CREATE TABLE `manager` (
  `m_id` int(13) NOT NULL,
  `first_name` varchar(100) NOT NULL,
  `last_name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(40) NOT NULL,
  `last_login` datetime NOT NULL,
  `is_deleted` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `manager`
--

INSERT INTO `manager` (`m_id`, `first_name`, `last_name`, `email`, `password`, `last_login`, `is_deleted`) VALUES
(2, 'Manager', 'manager', 'infoozonefitness@gmail.com', '5baa61e4c9b93f3f0682250b6cf8331b7ee68fd8', '2023-08-29 15:57:52', 0);

-- --------------------------------------------------------

--
-- Table structure for table `membership`
--

CREATE TABLE `membership` (
  `member_id` int(13) NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `u_id` int(13) NOT NULL,
  `membership_status` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `membership`
--

INSERT INTO `membership` (`member_id`, `start_date`, `end_date`, `u_id`, `membership_status`) VALUES
(25, '2023-08-29', '2023-10-24', 20, 'Approved');

-- --------------------------------------------------------

--
-- Table structure for table `package`
--

CREATE TABLE `package` (
  `p_id` int(13) NOT NULL,
  `package_name` varchar(20) NOT NULL,
  `package_dec` varchar(100) NOT NULL,
  `validity` varchar(20) NOT NULL,
  `amount` int(10) NOT NULL,
  `active` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `package`
--

INSERT INTO `package` (`p_id`, `package_name`, `package_dec`, `validity`, `amount`, `active`) VALUES
(6, 'Standerd', 'zumba,\r\ncardio,\r\nweightlift,\r\nmucesles', 'one year', 5000, 'active'),
(7, 'Basic', 'weight lift,cross fit,cardio', 'six months', 1500, 'active'),
(8, 'Professional', 'Cross fit,cardio,zumba,mucel builid', 'Two Years', 8000, 'active'),
(10, 'Ultimate', 'Smash Fit\r\nInfliction Fitness\r\nFitness Rats\r\nPower Up\r\nCrossFit zone\r\nFitness Bash', 'four years', 9500, 'active');

-- --------------------------------------------------------

--
-- Table structure for table `payment`
--

CREATE TABLE `payment` (
  `payment_id` int(13) NOT NULL,
  `package_id` int(13) NOT NULL,
  `package_desc` varchar(100) NOT NULL,
  `package_validity` varchar(40) NOT NULL,
  `package_amount` int(10) NOT NULL,
  `card_owner_name` varchar(100) NOT NULL,
  `card_number` varchar(20) NOT NULL,
  `card_expiration` date NOT NULL,
  `card_cvv` int(4) NOT NULL,
  `card_type` varchar(20) NOT NULL,
  `u_id` int(13) NOT NULL,
  `status` varchar(20) NOT NULL,
  `paid_date` date NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `payment`
--

INSERT INTO `payment` (`payment_id`, `package_id`, `package_desc`, `package_validity`, `package_amount`, `card_owner_name`, `card_number`, `card_expiration`, `card_cvv`, `card_type`, `u_id`, `status`, `paid_date`) VALUES
(31, 8, '8', '8', 8, 'kavitha', '34877932333', '2023-08-30', 434, 'master card', 20, 'Paid', '2023-08-29');

-- --------------------------------------------------------

--
-- Table structure for table `schedule`
--

CREATE TABLE `schedule` (
  `schedule_id` int(11) NOT NULL,
  `s_name` varchar(50) NOT NULL,
  `workout1` varchar(20) NOT NULL,
  `workout2` varchar(20) NOT NULL,
  `workout3` varchar(20) NOT NULL,
  `workout4` varchar(20) NOT NULL,
  `workout5` varchar(20) NOT NULL,
  `workout6` varchar(20) NOT NULL,
  `workout7` varchar(20) NOT NULL,
  `workout8` varchar(20) NOT NULL,
  `date` date NOT NULL,
  `user_id` int(11) NOT NULL,
  `status` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `schedule`
--

INSERT INTO `schedule` (`schedule_id`, `s_name`, `workout1`, `workout2`, `workout3`, `workout4`, `workout5`, `workout6`, `workout7`, `workout8`, `date`, `user_id`, `status`) VALUES
(6, 'Beginner', 'legs 2x', 'arm 3x', 'scout 2x', 'pushup 6x', 'cardio', 'shoulder 4x', 'zumba', 'weightlift', '2023-08-29', 20, 'active');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(13) NOT NULL,
  `first_name` varchar(100) NOT NULL,
  `last_name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `gender` varchar(20) NOT NULL,
  `address` varchar(100) NOT NULL,
  `tpnumber` varchar(20) NOT NULL,
  `body_type` varchar(50) NOT NULL,
  `age` int(11) NOT NULL,
  `height` double NOT NULL,
  `weight` double NOT NULL,
  `password` varchar(40) NOT NULL,
  `last_login` datetime NOT NULL,
  `is_deleted` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `first_name`, `last_name`, `email`, `gender`, `address`, `tpnumber`, `body_type`, `age`, `height`, `weight`, `password`, `last_login`, `is_deleted`) VALUES
(20, 'kavitha', 'kavindi', 'hexaportrs@gmail.com', 'female', 'hettipola', '076344559', 'ectomorph', 25, 23.6, 50, '5baa61e4c9b93f3f0682250b6cf8331b7ee68fd8', '2023-08-29 15:54:15', 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`admin_id`);

--
-- Indexes for table `announcement`
--
ALTER TABLE `announcement`
  ADD PRIMARY KEY (`a_id`);
ALTER TABLE `announcement` ADD FULLTEXT KEY `announcement` (`announcement`);

--
-- Indexes for table `manager`
--
ALTER TABLE `manager`
  ADD PRIMARY KEY (`m_id`);

--
-- Indexes for table `membership`
--
ALTER TABLE `membership`
  ADD PRIMARY KEY (`member_id`),
  ADD KEY `u_id` (`u_id`);

--
-- Indexes for table `package`
--
ALTER TABLE `package`
  ADD PRIMARY KEY (`p_id`);

--
-- Indexes for table `payment`
--
ALTER TABLE `payment`
  ADD PRIMARY KEY (`payment_id`),
  ADD KEY `u_id` (`u_id`),
  ADD KEY `package_id` (`package_id`);

--
-- Indexes for table `schedule`
--
ALTER TABLE `schedule`
  ADD PRIMARY KEY (`schedule_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `user_id_2` (`user_id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `admin_id` int(13) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `announcement`
--
ALTER TABLE `announcement`
  MODIFY `a_id` int(13) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `manager`
--
ALTER TABLE `manager`
  MODIFY `m_id` int(13) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `membership`
--
ALTER TABLE `membership`
  MODIFY `member_id` int(13) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `package`
--
ALTER TABLE `package`
  MODIFY `p_id` int(13) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `payment`
--
ALTER TABLE `payment`
  MODIFY `payment_id` int(13) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT for table `schedule`
--
ALTER TABLE `schedule`
  MODIFY `schedule_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(13) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `membership`
--
ALTER TABLE `membership`
  ADD CONSTRAINT `membership_ibfk_1` FOREIGN KEY (`u_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `payment`
--
ALTER TABLE `payment`
  ADD CONSTRAINT `payment_ibfk_1` FOREIGN KEY (`u_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `payment_ibfk_2` FOREIGN KEY (`package_id`) REFERENCES `package` (`p_id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
