-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 19, 2024 at 07:24 PM
-- Server version: 10.4.27-MariaDB
-- PHP Version: 8.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `employeeleavedb`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id` int(11) NOT NULL,
  `UserName` varchar(100) NOT NULL,
  `Password` varchar(100) NOT NULL,
  `fullname` varchar(255) NOT NULL,
  `email` varchar(55) NOT NULL,
  `updationDate` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `UserName`, `Password`, `fullname`, `email`, `updationDate`) VALUES
(1, 'admin', 'd00f5d5217896fb7fd601412cb890830', 'Liam Moore', 'admin@mail.com', '2022-02-09 15:15:46'),
(2, 'bruno', '5f4dcc3b5aa765d61d8327deb882cf99', 'Bruno Den', 'itsbruno@mail.com', '2022-02-09 15:15:50'),
(3, 'greenwood', '5f4dcc3b5aa765d61d8327deb882cf99', 'Johnny Greenwood', 'greenwood@mail.com', '2022-02-09 15:15:54');

-- --------------------------------------------------------

--
-- Table structure for table `class_transfers`
--

CREATE TABLE `class_transfers` (
  `id` int(11) NOT NULL,
  `EmpId` varchar(100) NOT NULL,
  `current_class` varchar(255) DEFAULT NULL,
  `desired_class` varchar(255) DEFAULT NULL,
  `reason` text DEFAULT NULL,
  `status` varchar(20) DEFAULT 'Pending',
  `requested_by` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `hod`
--

CREATE TABLE `hod` (
  `id` int(11) NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `fullname` varchar(255) NOT NULL,
  `email` varchar(55) NOT NULL,
  `updation date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `hod`
--

INSERT INTO `hod` (`id`, `username`, `password`, `fullname`, `email`, `updation date`) VALUES
(1, 'hod', '21232f297a57a5a743894a0e4a801fc3', 'Hod', 'hod@email.com', '2024-11-19 16:23:33');

-- --------------------------------------------------------

--
-- Table structure for table `tblclasstransfers`
--

CREATE TABLE `tblclasstransfers` (
  `id` int(11) NOT NULL,
  `CurrentClass` varchar(255) NOT NULL,
  `DesiredClass` varchar(255) NOT NULL,
  `Reason` text NOT NULL,
  `Status` int(11) DEFAULT 0,
  `empid` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbldepartments`
--

CREATE TABLE `tbldepartments` (
  `id` int(11) NOT NULL,
  `DepartmentName` varchar(150) DEFAULT NULL,
  `DepartmentShortName` varchar(100) NOT NULL,
  `DepartmentCode` varchar(50) DEFAULT NULL,
  `CreationDate` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `tbldepartments`
--

INSERT INTO `tbldepartments` (`id`, `DepartmentName`, `DepartmentShortName`, `DepartmentCode`, `CreationDate`) VALUES
(1, 'Human Resource', 'HR', 'HR160', '2020-11-01 07:16:25'),
(2, 'Information Technology', 'IT', 'IT807', '2020-11-01 07:19:37'),
(3, 'Operations', 'OP', 'OP640', '2020-12-02 21:28:56'),
(4, 'Volunteer', 'VL', 'VL9696', '2021-03-03 08:27:52'),
(5, 'Marketing', 'MK', 'MK369', '2021-03-03 10:53:52'),
(6, 'Finance', 'FI', 'FI123', '2021-03-03 10:54:27'),
(7, 'Sales', 'SS', 'SS469', '2021-03-03 10:55:24'),
(8, 'Research', 'RS', 'RS666', '2021-03-03 16:39:03');

-- --------------------------------------------------------

--
-- Table structure for table `tblemployees`
--

CREATE TABLE `tblemployees` (
  `id` int(11) NOT NULL,
  `EmpId` varchar(100) NOT NULL,
  `FirstName` varchar(150) NOT NULL,
  `LastName` varchar(150) NOT NULL,
  `EmailId` varchar(200) NOT NULL,
  `Password` varchar(180) NOT NULL,
  `Gender` varchar(100) NOT NULL,
  `Dob` varchar(100) NOT NULL,
  `Department` varchar(255) NOT NULL,
  `Address` varchar(255) NOT NULL,
  `City` varchar(200) NOT NULL,
  `Country` varchar(150) NOT NULL,
  `Phonenumber` char(11) NOT NULL,
  `Status` int(1) NOT NULL,
  `RegDate` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `tblemployees`
--

INSERT INTO `tblemployees` (`id`, `EmpId`, `FirstName`, `LastName`, `EmailId`, `Password`, `Gender`, `Dob`, `Department`, `Address`, `City`, `Country`, `Phonenumber`, `Status`, `RegDate`) VALUES
(1, 'ASTR001245', 'Johnny', 'Scott', 'johnny@mail.com', '21232f297a57a5a743894a0e4a801fc3', 'Male', '1996-06-12', 'Information Technology', '49 Arron Smith Drive', 'Honolulu', 'US', '7854785477', 1, '2020-11-10 11:29:59'),
(2, 'ASTR001369', 'Milton', 'Doe', 'milt@mail.com', 'f925916e2754e5e03f75dd58a5733251', 'Male', '1990-02-02', 'Operations', '15 Kincheloe Road', 'Salem', 'US', '8587944255', 1, '2020-11-10 13:40:02'),
(3, 'ASTR004699', 'Shawn', 'Den', 'Shawnden@mail.com', '3b87c97d15e8eb11e51aa25e9a5770e9', 'Male', '1995-03-22', 'Human Resource', '239 Desert Court', 'Wayne', 'US', '7458887169', 1, '2021-03-03 07:24:17'),
(4, 'ASTR002996', 'Carol', 'Reed', 'carol@mail.com', '723e1489a45d2cbaefec82eee410abd5', 'Female', '1989-03-23', 'Volunteer', 'Demo Address', 'Demo City', 'Demo Country', '7854448550', 1, '2021-03-03 10:44:13'),
(5, 'ASTR001439', 'Danny', 'Wood', 'danny@mail.com', 'b7bee6b36bd35b773132d4e3a74c2bb5', 'Male', '1986-03-12', 'Research', '11 Rardin Drive', 'San Francisco', 'US', '4587777744', 1, '2021-03-04 17:14:48'),
(6, 'ASTR006946', 'Shawn', 'Martin', 'shawn@mail.com', 'a3cceba83235dc95f750108d22c14731', 'Male', '1992-08-28', 'Finance', '3259 Ray Court', 'Wilmington', 'US', '8520259670', 1, '2021-03-04 17:46:02'),
(7, 'ASTR000084', 'Jennifer', 'Foltz', 'jennifer@mail.com', '5f4dcc3b5aa765d61d8327deb882cf99', 'Female', '1992-12-11', 'Marketing', '977 Smithfield Avenue', 'Elkins', 'US', '7401256696', 1, '2022-02-09 15:29:00'),
(8, 'ASTR012447', 'Will', 'Williams', 'williams@mail.com', '5f4dcc3b5aa765d61d8327deb882cf99', 'Male', '1992-02-15', 'Research', '366 Cemetery Street', 'Houston', 'US', '7854000065', 1, '2022-02-10 15:52:32'),
(9, 'Saurav2003', 'Saurav', 'D', 'Saurav123@gmail.com', '21232f297a57a5a743894a0e4a801fc3', 'Male', '2003-09-13', 'Information Technology', 'xyz, new lane', 'XYS', 'Australia', '9328859140', 1, '2024-09-30 08:35:22'),
(10, 'admin', 'Waqar', 'Ali', 'homeremedytc@gmail.com', '15adbed66d8b58997e0e2bd114c52ce4', 'Male', '1996-02-05', 'Human Resource', '255', 'city', 'Italy', '33333333', 1, '2024-11-19 05:57:52');

-- --------------------------------------------------------

--
-- Table structure for table `tblleaves`
--

CREATE TABLE `tblleaves` (
  `id` int(11) NOT NULL,
  `LeaveType` varchar(110) NOT NULL,
  `ToDate` varchar(120) NOT NULL,
  `FromDate` varchar(120) NOT NULL,
  `Description` mediumtext NOT NULL,
  `PostingDate` timestamp NOT NULL DEFAULT current_timestamp(),
  `AdminRemark` mediumtext DEFAULT NULL,
  `AdminRemarkDate` varchar(120) DEFAULT NULL,
  `Status` int(1) NOT NULL,
  `IsRead` int(1) NOT NULL,
  `empid` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `tblleaves`
--

INSERT INTO `tblleaves` (`id`, `LeaveType`, `ToDate`, `FromDate`, `Description`, `PostingDate`, `AdminRemark`, `AdminRemarkDate`, `Status`, `IsRead`, `empid`) VALUES
(7, 'Casual Leave', '30/11/2020', '29/10/2020', 'Test Test Demo Test Test Demo Test Test Demo', '2020-11-19 13:11:21', 'A demo Admin Remarks for Testing!', '2020-12-02 23:26:27 ', 2, 1, 1),
(8, 'Medical Leave', '21/10/2020', '25/10/2020', 'Test Test Demo Test Test Demo Test Test Demo Test Test Demo', '2020-11-20 11:14:14', 'A demo Admin Remarks for Testing!', '2020-12-02 23:24:39 ', 1, 1, 1),
(9, 'Medical Leave', '08/12/2020', '12/12/2020', 'This is a demo description for testing purpose', '2020-12-02 18:26:01', 'All good make your time and hope you\'ll be fine and get back to work asap! Best Regards, Admin.', '2021-03-03 11:19:29 ', 1, 1, 2),
(10, 'Restricted Holiday', '25/12/2020', '25/12/2020', 'This is a demo description for testing purpose', '2020-12-03 08:29:07', 'A demo Admin Remarks for Testing!', '2020-12-03 14:06:12 ', 1, 1, 1),
(11, 'Medical Leave', '02/12/2020', '06/12/2020', 'This is a demo description for testing purpose', '2020-04-29 15:01:14', 'A demo Admin Remarks for Testing!', '2020-04-29 20:33:21 ', 1, 1, 1),
(12, 'Casual Leave', '02/02/2020', '03/03/2020', 'This is a demo description for testing purpose', '2020-07-03 08:11:11', 'A demo Admin Remarks for Testing!', '2020-07-03 13:42:05 ', 1, 1, 1),
(14, 'Medical Leave', '2020-03-05', '2020-06-05', 'This is a demo description for testing purpose', '2021-03-02 09:31:01', NULL, NULL, 0, 1, 2),
(15, 'Casual Leave', '2021-03-15', '2021-03-05', 'None, Testing', '2021-03-02 09:32:42', 'casual leave not allowed for a week, the company\'s gotta huge project which should be completed within this week.', '2021-03-03 11:47:33 ', 2, 1, 1),
(17, 'Paternity Leave', '2021-03-03', '2021-03-10', 'Being a father i\'ve got to look after my new borns and spend some time with my families too!', '2021-03-03 10:58:18', NULL, NULL, 0, 1, 3),
(18, 'Medical Leave', '2021-03-04', '2021-03-05', 'i\'ve to go for my body checkup. got an appointment for tommorow', '2021-03-03 12:09:44', 'No comments on it.', '2021-03-04 22:56:24 ', 1, 1, 4),
(19, 'Compensatory Leave', '2024-02-03', '2024-02-02', 'been working over time since last night, so i\'d like a day off', '2021-03-03 12:24:15', NULL, NULL, 0, 1, 1),
(20, 'Casual Leave', '2022-02-09', '2022-02-12', 'None, Test Mode', '2022-02-09 15:31:15', NULL, NULL, 0, 1, 7),
(21, 'Self-Quarantine Leave', '2022-02-11', '2022-02-18', 'This is just a demo condition for testing purpose!!', '2022-02-10 16:05:30', 'No comments!!', '2022-02-10 21:37:15 ', 1, 1, 8),
(22, 'Personal Time Off', '2020-03-05', '2020-03-07', 'this is time', '2024-11-19 10:18:59', NULL, NULL, 0, 1, 1),
(23, 'medical leave', '2024-11-20', '2024-11-19', 'i need one day leave', '2024-11-19 15:22:55', NULL, NULL, 0, 1, 1),
(24, 'Personal Time Off', '2024-11-21', '2024-11-20', 'this is test', '2024-11-19 15:35:04', NULL, NULL, 0, 1, 1),
(25, 'Personal Time Off', '2024-11-23', '2024-11-25', 'i need checkup', '2024-11-19 17:36:59', NULL, NULL, 0, 0, 1),
(26, 'Personal Time Off', '2024-11-28', '2024-11-30', 'ok', '2024-11-19 17:41:05', NULL, NULL, 0, 0, 1),
(27, 'Self-Quarantine Leave', '2024-11-19', '2024-11-21', 'kkmk', '2024-11-19 17:43:03', NULL, NULL, 0, 0, 1),
(28, 'Personal Time Off', '2024-11-20', '2024-11-21', 'jnuuuhu', '2024-11-19 17:58:37', NULL, NULL, 0, 0, 1);

-- --------------------------------------------------------

--
-- Table structure for table `tblleavetype`
--

CREATE TABLE `tblleavetype` (
  `id` int(11) NOT NULL,
  `LeaveType` varchar(200) DEFAULT NULL,
  `Description` mediumtext DEFAULT NULL,
  `CreationDate` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `tblleavetype`
--

INSERT INTO `tblleavetype` (`id`, `LeaveType`, `Description`, `CreationDate`) VALUES
(1, 'Casual Leave', 'Provided for urgent or unforeseen matters to the employees.', '2020-11-01 12:07:56'),
(2, 'Medical Leave', 'Related to Health Problems of Employee', '2020-11-06 13:16:09'),
(3, 'Restricted Holiday', 'Holiday that is optional', '2020-11-06 13:16:38'),
(5, 'Paternity Leave', 'To take care of newborns', '2021-03-03 10:46:31'),
(6, 'Bereavement Leave', 'Grieve their loss of losing loved ones', '2021-03-03 10:47:48'),
(7, 'Compensatory Leave', 'For Overtime workers', '2021-03-03 10:48:37'),
(8, 'Maternity Leave', 'Taking care of newborn ,recoveries', '2021-03-03 10:50:17'),
(9, 'Religious Holidays', 'Based on employee\'s followed religion', '2021-03-03 10:51:26'),
(10, 'Adverse Weather Leave', 'In terms of extreme weather conditions', '2021-03-03 13:18:26'),
(11, 'Voting Leave', 'For official election day', '2021-03-03 13:19:06'),
(12, 'Self-Quarantine Leave', 'Related to COVID-19 issues', '2021-03-03 13:19:48'),
(13, 'Personal Time Off', 'To manage some private matters', '2021-03-03 13:21:10'),
(14, 'medical leave', 'bcuyevcjhcnz ibcj zxmn ib cmn ', '2024-09-30 12:05:56');

-- --------------------------------------------------------

--
-- Table structure for table `tblloadtransfer`
--

CREATE TABLE `tblloadtransfer` (
  `id` int(11) NOT NULL,
  `faculty_from` varchar(255) NOT NULL,
  `faculty_to` varchar(255) NOT NULL,
  `transfer_date` date NOT NULL,
  `time_slot` varchar(50) NOT NULL,
  `subject` varchar(191) DEFAULT NULL,
  `remarks` text DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tblloadtransfer`
--

INSERT INTO `tblloadtransfer` (`id`, `faculty_from`, `faculty_to`, `transfer_date`, `time_slot`, `subject`, `remarks`, `status`, `created_at`, `updated_at`) VALUES
(1, '1', '9', '2024-11-20', '8:30 AM - 9:30 AM', 'CS101', '', 1, '2024-11-19 17:47:35', '2024-11-19 17:58:11'),
(2, '1', '9', '2024-11-21', '9:30 AM - 10:30 AM', 'testing', '', 1, '2024-11-19 17:47:56', '2024-11-19 17:58:14'),
(3, '1', '9', '2024-11-22', '9:30 AM - 10:30 AM', 'testing', '', 1, '2024-11-19 17:47:56', '2024-11-19 17:58:17');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `class_transfers`
--
ALTER TABLE `class_transfers`
  ADD PRIMARY KEY (`id`),
  ADD KEY `empid` (`EmpId`),
  ADD KEY `requested_by` (`requested_by`);

--
-- Indexes for table `hod`
--
ALTER TABLE `hod`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tblclasstransfers`
--
ALTER TABLE `tblclasstransfers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbldepartments`
--
ALTER TABLE `tbldepartments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tblemployees`
--
ALTER TABLE `tblemployees`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tblleaves`
--
ALTER TABLE `tblleaves`
  ADD PRIMARY KEY (`id`),
  ADD KEY `UserEmail` (`empid`);

--
-- Indexes for table `tblleavetype`
--
ALTER TABLE `tblleavetype`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tblloadtransfer`
--
ALTER TABLE `tblloadtransfer`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `class_transfers`
--
ALTER TABLE `class_transfers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `hod`
--
ALTER TABLE `hod`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tblclasstransfers`
--
ALTER TABLE `tblclasstransfers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `tbldepartments`
--
ALTER TABLE `tbldepartments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `tblemployees`
--
ALTER TABLE `tblemployees`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `tblleaves`
--
ALTER TABLE `tblleaves`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT for table `tblleavetype`
--
ALTER TABLE `tblleavetype`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `tblloadtransfer`
--
ALTER TABLE `tblloadtransfer`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
