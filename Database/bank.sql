-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 21, 2022 at 07:11 PM
-- Server version: 10.4.19-MariaDB
-- PHP Version: 8.0.7

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `bank`
--

-- --------------------------------------------------------

--
-- Table structure for table `budgetreleasing`
--

CREATE TABLE `budgetreleasing` (
  `P_ID` int(200) UNSIGNED NOT NULL,
  `P_Code` int(200) NOT NULL,
  `P_Department` varchar(200) NOT NULL,
  `P_Requestor` varchar(200) NOT NULL,
  `P_Purpose` varchar(200) NOT NULL,
  `P_Amount` int(200) NOT NULL,
  `P_Date` date NOT NULL,
  `P_Tablename` varchar(200) NOT NULL,
  `P_Status` int(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `claim`
--

CREATE TABLE `claim` (
  `claim_id` int(11) NOT NULL,
  `claim` varchar(200) NOT NULL,
  `claim_date` date NOT NULL,
  `status` varchar(50) NOT NULL,
  `accepted` int(10) UNSIGNED DEFAULT NULL,
  `user_id` int(11) NOT NULL,
  `username` varchar(200) NOT NULL,
  `user_level` int(11) NOT NULL,
  `name` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `claim`
--

INSERT INTO `claim` (`claim_id`, `claim`, `claim_date`, `status`, `accepted`, `user_id`, `username`, `user_level`, `name`) VALUES
(1, 'Life Insurance Claims', '2022-04-17', 'Pending', 0, 16, 'lj', 1, 'Lawrence'),
(2, 'Health Insurance Claims', '2022-04-17', 'Rejected by Admin RJ', 2, 17, 'Hanna', 3, 'Hanna'),
(3, 'Casualty Claims', '2022-04-17', 'Accepted by Admin RJ', 1, 12, 'rjinxed', 3, 'jin rodriguez'),
(108, 'Payable Leaves( Vacation leave)', '2022-04-18', 'Accepted by Admin RJ', 1, 6, 'employee', 3, 'Employee'),
(109, 'Payable Leaves( Medical Leave)', '2022-04-18', 'Pending', 0, 7, 'Admin', 1, 'Admin Account'),
(110, 'Payable Leaves( Casual Leave)', '2022-04-18', 'Accepted by Admin Account', 1, 6, 'employee', 3, 'Employee'),
(111, 'Payable Leaves( Casual Leave)', '2022-04-18', 'Accepted by Admin Account', 1, 6, 'employee', 3, 'Employee'),
(112, 'Payable Leaves( Sick Leave)', '2022-04-18', 'Accepted by Admin Account', 1, 6, 'employee', 3, 'Employee'),
(113, 'Payable Leaves( Leave Type test)', '2022-04-18', 'Accepted by Admin Account', 1, 6, 'employee', 3, 'Employee'),
(114, 'Claim type test', '2022-04-18', 'Accepted by Admin Account', 1, 6, 'employee', 3, 'Employee');

-- --------------------------------------------------------

--
-- Table structure for table `claim_archive`
--

CREATE TABLE `claim_archive` (
  `claim_id` int(11) NOT NULL,
  `claim` varchar(200) NOT NULL,
  `claim_date` date NOT NULL,
  `status` varchar(50) NOT NULL,
  `accepted` int(10) UNSIGNED DEFAULT NULL,
  `user_id` int(11) NOT NULL,
  `username` varchar(200) NOT NULL,
  `user_level` int(11) NOT NULL,
  `name` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `claim_archive`
--

INSERT INTO `claim_archive` (`claim_id`, `claim`, `claim_date`, `status`, `accepted`, `user_id`, `username`, `user_level`, `name`) VALUES
(2, 'Health Insurance Claims', '2022-01-08', 'Pending', 0, 8, 'staff', 2, 'HR STAFF'),
(11, 'Payable Leaves( Maternity leave)', '2022-04-17', 'Pending', 0, 7, 'Admin', 1, 'Admin Account');

-- --------------------------------------------------------

--
-- Table structure for table `claim_type_admin`
--

CREATE TABLE `claim_type_admin` (
  `claim_type_id` int(11) NOT NULL,
  `type` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `claim_type_admin`
--

INSERT INTO `claim_type_admin` (`claim_type_id`, `type`) VALUES
(1, 'Claim type test'),
(9, 'Health Insurance Claims'),
(10, 'Life Insurance Claims'),
(25, 'Property Claims'),
(26, 'Casualty Claims');

-- --------------------------------------------------------

--
-- Table structure for table `collection`
--

CREATE TABLE `collection` (
  `Co_Code` int(100) NOT NULL,
  `LS_Account_name` varchar(200) NOT NULL,
  `A_Number` int(100) NOT NULL,
  `Co_Status` int(100) NOT NULL,
  `LS_Date` date NOT NULL,
  `LS_Address` varchar(200) NOT NULL,
  `LS_City` varchar(200) NOT NULL,
  `LS_Country` varchar(200) NOT NULL,
  `LS_Desc` varchar(255) NOT NULL,
  `LS_Department` varchar(200) NOT NULL,
  `LS_Type` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `collection`
--

INSERT INTO `collection` (`Co_Code`, `LS_Account_name`, `A_Number`, `Co_Status`, `LS_Date`, `LS_Address`, `LS_City`, `LS_Country`, `LS_Desc`, `LS_Department`, `LS_Type`) VALUES
(101, 'ian james barbosa', 18011424, 102, '2021-12-11', 'Sanbenisa Garden villas', 'Quezon city', 'Philippines', 'This Record is a paid through agreed Contract', 'Core 1', 'Loans'),
(103, 'Ellie Barbosa', 10999212, 102, '2021-12-11', 'Sanbenisa Garden villas', 'Quezon City', 'Philippines', 'This Record is a paid through agreed Contract', 'Core 1', 'Loans'),
(104, 'Cristy Vargas', 18013999, 102, '2022-01-04', 'Cloocan kaligayahan villas', 'Quezon City', 'Philippines', 'This Record is a record of deposit by the user', 'Core 1', 'Deposits'),
(105, 'Thedore jhon', 16052100, 102, '2022-01-04', 'Pasig uranbo villas', 'Pasig City', 'Philippines', 'This Record is a record of deposit by the user', 'Core 1', 'Deposits'),
(106, 'Andrew Artis', 16013231, 102, '2022-01-12', 'Bagong Silang, caloocan City', 'Calocan City', 'Philippines', 'This Record is a record of deposit by the user', 'Core 1', 'Deposits'),
(107, 'Will Baylie', 18202542, 102, '2022-01-13', 'Camarin, Caloocan City', 'Calocan City', 'Philippines', 'This Record is a record of deposit by the user', 'Core 1', 'Loans'),
(108, 'Aron Legaspi', 18014278, 102, '2022-01-14', 'Lagro, Quezon City', 'Quezon City', 'Philippines', 'This Record is a record of deposit by the user', 'Core 1', 'Deposits'),
(109, 'Berry Jhon', 16010051, 102, '2022-01-15', 'North Fairview, Quezon City', 'Quezon City', 'Philippines', 'This Record is a record of deposit by the user', 'Core 1', 'Loans'),
(110, 'Cecille Alex', 17012232, 102, '2022-01-16', 'Novaliches, Quezon City', 'Quezon City', 'Philippines', 'This Record is a record of deposit by the user', 'Core 1', 'Deposits'),
(111, 'Eva Chavez', 12316737, 102, '2022-01-12', 'Zabarte road, Caloocan City', 'Calocan City', 'Philippines', 'This Record is a record of deposit by the user', 'Core 1', 'Loans'),
(112, 'Frits Howard', 18956875, 102, '2022-01-12', 'Liano, Caloocan', 'Calocan City', 'Philippines', 'This Record is a record of deposit by the user', 'Core 1', 'Deposits'),
(113, 'Edward Cruz', 27326143, 102, '2022-01-12', '11th avenue, caloocan City', 'Calocan City', 'Philippines', 'This Record is a record of deposit by the user', 'Core 1', 'Loans'),
(114, 'Stephen curry', 41120130, 102, '2022-01-20', 'Talisayan, Caloocan City', 'Calocan City', 'Philippines', 'This Record is a record of deposit by the user', 'Core 1', 'Loans'),
(115, 'Daniel Daviz', 59067090, 102, '2022-01-21', 'tondo, manila', 'Manila', 'Philippines', 'This Record is a record of deposit by the user', 'Core 1', 'Deposits'),
(116, 'James Thomas', 12837248, 102, '2022-01-22', 'alfonso, tondo, manila', 'Manila', 'Philippines', 'This Record is a record of deposit by the user', 'Core 1', 'Loans');

-- --------------------------------------------------------

--
-- Table structure for table `collection_transactions`
--

CREATE TABLE `collection_transactions` (
  `LT_id` int(200) NOT NULL,
  `LT_Recieved` int(200) NOT NULL,
  `LT_Charges` int(200) NOT NULL,
  `LT_date` date NOT NULL,
  `A_Number` int(200) NOT NULL,
  `LT_Type` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `collection_transactions`
--

INSERT INTO `collection_transactions` (`LT_id`, `LT_Recieved`, `LT_Charges`, `LT_date`, `A_Number`, `LT_Type`) VALUES
(1, 1000, 70, '2021-04-05', 18011424, 'Loan Payment'),
(2, 1000, 60, '2021-05-05', 18011424, 'Loan Payment'),
(3, 200, 10, '2021-06-05', 18011424, 'Loan Payment'),
(4, 2000, 40, '2021-06-15', 10999212, 'Loan Payment'),
(5, 2000, 40, '2021-07-15', 10999212, 'Loan Payment'),
(6, 2000, 40, '2021-08-15', 10999212, 'Loan Payment'),
(7, 3000, 50, '2021-09-15', 10999212, 'Loan Payment'),
(8, 500000, 20, '2021-12-13', 18013999, 'deposit'),
(9, 100000, 20, '2021-12-14', 16052100, 'deposit'),
(10, 80000, 20, '2021-12-15', 16013231, 'deposit'),
(11, 95000, 20, '2021-12-18', 18014278, 'deposit'),
(12, 8500, 40, '2021-12-19', 16010051, 'Loan Payment'),
(13, 100000, 20, '2021-12-21', 17012232, 'deposit'),
(14, 4000, 50, '2021-12-22', 12316737, 'Loan Payment'),
(15, 70000, 20, '2021-12-23', 18956875, 'deposit'),
(16, 1000, 30, '2021-12-26', 27326143, 'Loan Payment'),
(17, 2500, 40, '2021-12-27', 41120130, 'Loan Payment'),
(18, 15000, 20, '2021-12-29', 59067090, 'deposit'),
(19, 4000, 50, '2022-01-02', 12837248, 'Loan Payment'),
(21, 3000, 40, '2022-01-03', 18202542, 'Loan Payment');

-- --------------------------------------------------------

--
-- Table structure for table `complaints`
--

CREATE TABLE `complaints` (
  `complaint_id` int(11) NOT NULL,
  `complaint` varchar(255) NOT NULL,
  `complaint_date` datetime NOT NULL,
  `status` varchar(255) NOT NULL,
  `accepted` int(10) UNSIGNED NOT NULL,
  `user_id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `user_level` int(11) NOT NULL,
  `name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `complaints`
--

INSERT INTO `complaints` (`complaint_id`, `complaint`, `complaint_date`, `status`, `accepted`, `user_id`, `username`, `user_level`, `name`) VALUES
(1, 'I accidentally pressed end shift', '2022-01-08 18:45:32', 'Pending', 0, 7, 'Admin', 1, 'Admin Account'),
(2, 'My login time bugged, please edit it.', '2022-01-08 18:59:22', 'Accepted by Admin Account', 1, 8, 'staff', 2, 'HR STAFF'),
(9, 'I accidentally pressed end shift, I ended work at 6pm', '2022-01-10 15:34:49', 'Accepted by Admin Account', 1, 10, 'rjinxed', 3, 'jin rodriguez'),
(10, 'Accidentally pressed end shift, I ended my shift in 8:00pm same day', '2022-01-10 19:43:18', 'Accepted by Admin Account', 1, 10, 'rjinxed', 3, 'jin rodriguez'),
(11, 'Complaint Test Jin', '2022-01-11 17:00:11', 'Accepted by Admin RJ', 1, 10, 'rjinxed', 3, 'jin rodriguez'),
(12, 'Test 2 Jin Support', '2022-01-11 17:02:18', 'Accepted by Admin RJ', 1, 10, 'rjinxed', 3, 'jin rodriguez'),
(13, 'set logout time to 8pm', '2022-01-11 18:35:00', 'Accepted by Admin Account', 1, 10, 'rjinxed', 3, 'jin rodriguez');

-- --------------------------------------------------------

--
-- Table structure for table `events`
--

CREATE TABLE `events` (
  `event_id` int(11) NOT NULL,
  `event` varchar(255) NOT NULL,
  `fromdate` date NOT NULL,
  `todate` date NOT NULL,
  `min_user_level` int(11) NOT NULL,
  `author` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `events`
--

INSERT INTO `events` (`event_id`, `event`, `fromdate`, `todate`, `min_user_level`, `author`) VALUES
(1, 'RJ Mamuyac Birthday', '2022-01-11', '2022-01-11', 3, 'Admin RJ'),
(2, 'Jin Rodriguez Birthday', '2022-01-01', '2022-01-09', 1, 'Admin RJ'),
(14, 'Admins Only Event Test', '2022-01-11', '2022-01-11', 1, 'Admin RJ'),
(15, 'Staff Only Event Test', '2022-01-10', '2022-01-10', 2, 'Admin RJ'),
(16, 'Employee Only Event Test', '2022-01-10', '2022-01-10', 0, 'Admin RJ'),
(25, 'staff test', '2022-01-11', '2022-01-11', 2, 'Admin Account');

-- --------------------------------------------------------

--
-- Table structure for table `expenses`
--

CREATE TABLE `expenses` (
  `Id` int(200) NOT NULL,
  `Expenses` int(200) NOT NULL,
  `Date` date NOT NULL,
  `Collection` int(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `expenses`
--

INSERT INTO `expenses` (`Id`, `Expenses`, `Date`, `Collection`) VALUES
(29, 0, '2021-12-12', 0),
(73, 0, '2022-01-06', 2340),
(74, 0, '2022-01-06', 5020),
(82, 0, '2022-01-10', 2340),
(83, 0, '2022-01-10', 10020),
(84, 0, '2022-01-11', 9170),
(85, 2400, '2022-01-11', 0),
(86, 3140, '2022-01-11', 0),
(87, 0, '2022-01-21', 2340),
(88, 0, '2022-01-21', 500020),
(89, 250, '2022-01-21', 0),
(90, 0, '2022-03-11', 2340),
(91, 0, '2022-03-11', 500020),
(92, 0, '2022-03-11', 100020),
(93, 0, '2022-03-11', 2340),
(94, 0, '2022-03-11', 9170),
(95, 0, '2022-03-11', 500020),
(96, 0, '2022-03-12', 2340),
(97, 0, '2022-03-15', 2340);

-- --------------------------------------------------------

--
-- Table structure for table `media`
--

CREATE TABLE `media` (
  `id` int(11) UNSIGNED NOT NULL,
  `file_name` varchar(255) NOT NULL,
  `file_type` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `obudget`
--

CREATE TABLE `obudget` (
  `Id` int(200) NOT NULL,
  `Budget` int(200) NOT NULL,
  `Date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `obudget`
--

INSERT INTO `obudget` (`Id`, `Budget`, `Date`) VALUES
(1, 3994210, '2021-03-12');

-- --------------------------------------------------------

--
-- Table structure for table `procurment`
--

CREATE TABLE `procurment` (
  `Co_Code` int(200) NOT NULL,
  `PRO_Requestor` varchar(200) NOT NULL,
  `PRO_Department` varchar(200) NOT NULL,
  `Co_Status` int(200) NOT NULL,
  `PRO_Desc` varchar(200) NOT NULL,
  `PRO_Amount` int(200) NOT NULL,
  `PRO_Date` date NOT NULL,
  `PRO_Supplier` varchar(255) NOT NULL,
  `PRO_City` varchar(255) NOT NULL,
  `PRO_Country` varchar(255) NOT NULL,
  `PRO_Address` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `procurment`
--

INSERT INTO `procurment` (`Co_Code`, `PRO_Requestor`, `PRO_Department`, `Co_Status`, `PRO_Desc`, `PRO_Amount`, `PRO_Date`, `PRO_Supplier`, `PRO_City`, `PRO_Country`, `PRO_Address`) VALUES
(101, 'Elvira Barbosa', 'Logistics 2', 102, 'For purchase of new machines', 3000000, '2021-11-30', 'Hp links', 'Quezon city', 'Philippines', 'san ben calocas kaligayahan'),
(102, 'Critina Vargas', 'Logistics 2', 102, 'For purchase of land', 4000000, '2021-11-29', 'Camella', 'Calocan', 'Philippines', 'san ben calocas kaligayahan'),
(104, 'Allie Adams', 'Logistics 2', 102, 'For purchase of new machines', 3000000, '2022-01-11', 'hexa mech tools', 'Quezon city', 'Philippines', 'san bartolome, Q.C.'),
(105, 'Alex Abadi', 'Logistics 2', 102, 'For purchase of new machines', 3000000, '2022-01-12', 'Forward machines', 'Quezon city', 'Philippines', 'san bartolome, Q.C.'),
(106, 'Kara Mary', 'Logistics 2', 102, 'For purchase of new machines', 3000000, '2022-01-13', 'Vision tools', 'Calocan City', 'Philippines', 'Reparo, Caloocan City'),
(107, 'Rickiew Aliman', 'Logistics 2', 102, 'For purchase of new machines', 3000000, '2022-01-14', 'belter tools', 'Valenzuela City', 'Philippines', 'Gen-T, Valenzuela City'),
(108, 'Daniel Alexander', 'Logistics 2', 102, 'For purchase of land', 3000000, '2022-01-15', 'Camella', 'Pasay City', 'Philippines', 'Diosdado, Pasay City'),
(109, 'Sam Allen', 'Logistics 2', 102, 'For purchase of land', 3000000, '2022-01-16', 'Villar', 'Paraniaque City', 'Philippines', 'Reparo, Caloocan City'),
(110, 'Lucy Alvarez', 'Logistics 2', 102, 'For purchase of new machines', 3000000, '2022-01-17', 'Factory machines', 'Makati City', 'Philippines', 'Reparo, Caloocan City');

-- --------------------------------------------------------

--
-- Table structure for table `proposals`
--

CREATE TABLE `proposals` (
  `Co_Code` int(200) NOT NULL,
  `PR_Department` varchar(255) NOT NULL,
  `PR_Requestor` varchar(255) NOT NULL,
  `PR_Amount` int(200) NOT NULL,
  `PR_Date` date NOT NULL,
  `Co_Status` int(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `proposals`
--

INSERT INTO `proposals` (`Co_Code`, `PR_Department`, `PR_Requestor`, `PR_Amount`, `PR_Date`, `Co_Status`) VALUES
(1100, 'HR1', 'jonathan', 300000, '2022-01-13', 102),
(1101, 'HR2', 'Ian james', 300000, '2022-01-13', 102),
(1103, 'HR3', 'Jaymie cabradillia', 300000, '2022-01-13', 102),
(1104, 'HR4', 'Maricor guilliermo bituin', 300000, '2022-01-13', 102),
(1105, 'CORE 1', 'jamela cruz', 400000, '2022-01-13', 102),
(1106, 'CORE 2', 'Eliie sabinay', 400000, '2022-01-13', 102),
(1107, 'LOG 1', 'theodore jhon valera', 300000, '2022-01-13', 102),
(1108, 'LOG 2', 'Karl angelo', 300000, '2022-01-13', 102),
(1109, 'Admin', 'michaela leigh valera', 300000, '2022-01-13', 101);

-- --------------------------------------------------------

--
-- Table structure for table `purchases`
--

CREATE TABLE `purchases` (
  `PU_id` int(200) NOT NULL,
  `Co_Code` int(200) NOT NULL,
  `Pu_Item` varchar(200) NOT NULL,
  `Pu_Quantity` int(200) NOT NULL,
  `Pu_Price` int(200) NOT NULL,
  `Pu_Date` date NOT NULL,
  `Pu_Total` int(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `purchases`
--

INSERT INTO `purchases` (`PU_id`, `Co_Code`, `Pu_Item`, `Pu_Quantity`, `Pu_Price`, `Pu_Date`, `Pu_Total`) VALUES
(1, 1001, 'Bus Fare', 5, 50, '2021-10-12', 250),
(2, 1002, 'Meal', 10, 150, '2021-11-12', 1500),
(3, 1002, 'Drinks', 15, 40, '2021-11-12', 600),
(4, 1002, 'Deserts', 12, 20, '2021-11-12', 240),
(5, 1003, 'Laptop', 1, 20000, '2021-12-12', 20000),
(6, 1002, 'Drinks', 20, 40, '2021-12-13', 800),
(7, 1003, 'Printer', 1, 30000, '2021-12-13', 30000),
(8, 101, 'Printers', 5, 50000, '2021-12-14', 500000),
(9, 102, 'Processor', 4, 16000, '2021-12-14', 16000),
(10, 1, 'electricity', 1, 5000, '2022-01-04', 5000),
(11, 1, 'gas', 1, 6000, '2022-01-04', 6000),
(12, 1, 'Internet connections', 1, 2500, '2022-01-04', 2500),
(13, 1, 'telephones', 1, 2300, '2022-01-04', 2300),
(14, 1, 'water', 1, 2500, '2022-01-04', 2500),
(15, 1004, 'chicken ', 5, 150, '2022-01-02', 750),
(16, 1004, 'Meat', 5, 300, '2022-01-02', 1500),
(17, 1004, 'drinks', 10, 15, '2022-01-02', 150),
(18, 1005, 'laptop - Acer Nitro 5', 1, 21, '2022-01-03', 21),
(19, 1006, 'keybroad-PSR- EW300', 1, 19998, '2022-01-04', 19998),
(20, 1007, 'Bond paper - Hard copy ', 1, 815, '2022-01-04', 815),
(21, 104, 'BTools 82 pcs tools socket', 1, 1729, '2022-01-03', 1729),
(22, 105, 'CNC pressure spring machine', 1, 74200, '2022-01-05', 74200),
(23, 106, 'Antenna Alignment tool ', 1, 6995, '2022-01-05', 6995),
(24, 107, 'lotus Sheet finish Sander', 1, 1210, '2022-01-06', 1210),
(25, 108, 'M-R-3 Acquired Property ', 1, 1000000, '2022-01-06', 1000000),
(26, 109, 'Forbes Park property ', 1, 4000000, '2022-01-07', 4000000),
(27, 110, 'Paper cup making machine', 1, 720000, '2022-01-08', 720000),
(28, 2, 'Renovation ', 0, 200000, '2022-01-03', 200000),
(29, 3, 'Transportation', 0, 100000, '2022-01-09', 100000);

-- --------------------------------------------------------

--
-- Table structure for table `reimbursements`
--

CREATE TABLE `reimbursements` (
  `reimbursement_id` int(11) NOT NULL,
  `username` varchar(20) NOT NULL,
  `name` varchar(50) NOT NULL,
  `user_level` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `reimbursement` varchar(100) NOT NULL,
  `reimbursement_date` date NOT NULL,
  `amount` int(11) NOT NULL,
  `status` varchar(50) NOT NULL,
  `accepted` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `reimbursements`
--

INSERT INTO `reimbursements` (`reimbursement_id`, `username`, `name`, `user_level`, `user_id`, `reimbursement`, `reimbursement_date`, `amount`, `status`, `accepted`) VALUES
(1, 'rjinxed', 'jin rodriguez', 3, 10, 'A4 Papers', '2022-01-08', 100, 'Accepted by Admin Account', 1),
(2, 'rjinxed', 'jin rodriguez', 3, 10, '19.5 inch ThinkVision Computer Monitor', '2022-01-08', 6000, 'Accepted by Admin Account', 1),
(3, 'Admin', 'Admin Account', 1, 7, 'Thinkpad x250 as a workstation laptop', '2022-01-08', 15000, 'Accepted by Admin RJ', 1),
(7, 'rjinxed', 'jin rodriguez', 3, 10, 'Reimburse Test Jin', '2022-01-11', 100, 'Accepted by Admin RJ', 1),
(9, 'Admin', 'Admin Account', 1, 7, 'Test', '2022-01-26', 1000, 'Accepted by Admin RJ', 1),
(10, 'employee', 'Employee', 3, 6, 'test1', '2022-04-17', 100, 'Rejected by Admin Account', 2),
(11, 'Admin', 'Admin Account', 1, 7, 'test', '2022-04-18', 431, 'Accepted by Admin RJ', 1);

-- --------------------------------------------------------

--
-- Table structure for table `reimbursements_archive`
--

CREATE TABLE `reimbursements_archive` (
  `reimbursement_id` int(11) NOT NULL,
  `username` varchar(20) NOT NULL,
  `name` varchar(50) NOT NULL,
  `user_level` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `reimbursement` varchar(100) NOT NULL,
  `reimbursement_date` date NOT NULL,
  `amount` int(11) NOT NULL,
  `status` varchar(50) NOT NULL,
  `accepted` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `reimbursment`
--

CREATE TABLE `reimbursment` (
  `Co_Code` int(200) NOT NULL,
  `Co_Source` varchar(200) NOT NULL,
  `Co_Desc` varchar(200) NOT NULL,
  `Co_Date` date NOT NULL,
  `Co_Status` varchar(200) NOT NULL,
  `Co_Purpose` varchar(200) NOT NULL,
  `Co_Supplier` varchar(200) NOT NULL,
  `Co_Address` varchar(200) NOT NULL,
  `Co_City` varchar(200) NOT NULL,
  `Co_Country` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `reimbursment`
--

INSERT INTO `reimbursment` (`Co_Code`, `Co_Source`, `Co_Desc`, `Co_Date`, `Co_Status`, `Co_Purpose`, `Co_Supplier`, `Co_Address`, `Co_City`, `Co_Country`) VALUES
(1001, 'HR3', 'maircor bituin', '2021-10-12', '102', 'for buying equipment', 'HP technologies', 'sanbenisa', 'Quezon city', 'philippines'),
(1002, 'HR3', 'ian james barbosa', '2021-10-12', '102', 'for buying machines', 'intel core', 'caloocan city, brgy kaligayahan', 'Caloocan city', 'philippines'),
(1003, 'HR3', 'ellie sabinay', '2021-10-13', '102', 'for buying food', 'jollibee corp', 'caloocan city, brgy kaligayahan', 'Caloocan city', 'philippines'),
(1004, 'HR3', 'melanie cabradilla', '2021-10-13', '102', 'for buying food', 'mang inasa corp', 'caloocan city, brgy kaligayahan', 'Caloocan city', 'philippines'),
(1005, 'HR3', 'elvira Aliga', '2022-01-11', '102', 'for loptop', 'ASUS', 'novaliches, quezon city', 'Quezon city', 'philippines'),
(1006, 'HR3', 'Tin Pachoco', '2022-01-11', '102', 'for key board', 'FANTECH', 'cubao, quezon city', 'Quezon city', 'philippines'),
(1007, 'HR3', 'Theodore jhon valera', '2022-01-11', '102', 'for bondpaper', 'HARD COPY', 'sampaloc, manila city', 'Manila city', 'philippines');

-- --------------------------------------------------------

--
-- Table structure for table `status`
--

CREATE TABLE `status` (
  `Status_Code` int(200) NOT NULL,
  `Name` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `status`
--

INSERT INTO `status` (`Status_Code`, `Name`) VALUES
(101, 'Approved'),
(102, 'Pending'),
(103, 'Settled'),
(104, 'Credit'),
(105, 'Debit');

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
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbldepartments`
--

INSERT INTO `tbldepartments` (`id`, `DepartmentName`, `DepartmentShortName`, `DepartmentCode`, `CreationDate`) VALUES
(1, 'Human Resource', 'HR', 'HR001', '2017-11-01 07:16:25'),
(2, 'Information Technology', 'IT', 'IT001', '2017-11-01 07:19:37'),
(3, 'Operations', 'OP', 'OP1', '2017-12-02 21:28:56');

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
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tblemployees`
--

INSERT INTO `tblemployees` (`id`, `EmpId`, `FirstName`, `LastName`, `EmailId`, `Password`, `Gender`, `Dob`, `Department`, `Address`, `City`, `Country`, `Phonenumber`, `Status`, `RegDate`) VALUES
(1, 'EMP10806121', 'Johnny', 'doe', 'johnny@gmail.com', 'f925916e2754e5e03f75dd58a5733251', 'Male', '3 February, 1990', 'Human Resource', 'N NEPO', 'NEPO', 'IRE', '9857555555', 1, '2017-11-10 11:29:59'),
(2, 'DEMP2132', 'James', 'doe', 'james@gmail.com', 'f925916e2754e5e03f75dd58a5733251', 'Male', '3 February, 1990', 'Information Technology', 'N NEPO', 'NEPO', 'IRE', '8587944255', 1, '2017-11-10 13:40:02'),
(3, 'EMP1801', 'Lawence Joshua', 'Salazar', 'ljsalazar1615@gmail.com', 'ljslzr', 'Male', 'June 16,1998', 'CCS', 'Phase 10-B', 'Caloocan City', 'Philippines', '09150974090', 1, '2021-11-20 11:28:26');

-- --------------------------------------------------------

--
-- Table structure for table `tblleaves`
--

CREATE TABLE `tblleaves` (
  `id` int(11) NOT NULL,
  `LeaveType` varchar(110) NOT NULL,
  `FromDate` varchar(120) NOT NULL,
  `ToDate` varchar(120) NOT NULL,
  `Description` mediumtext NOT NULL,
  `PostingDate` date NOT NULL DEFAULT current_timestamp(),
  `AdminRemark` mediumtext DEFAULT NULL,
  `AdminRemarkDate` varchar(120) DEFAULT NULL,
  `Status` int(1) NOT NULL,
  `IsRead` int(1) NOT NULL,
  `empid` int(11) DEFAULT NULL,
  `emp_read` int(1) NOT NULL,
  `amount_of_days` int(50) NOT NULL,
  `remaining_days` int(50) UNSIGNED NOT NULL,
  `paid` int(1) UNSIGNED NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tblleaves`
--

INSERT INTO `tblleaves` (`id`, `LeaveType`, `FromDate`, `ToDate`, `Description`, `PostingDate`, `AdminRemark`, `AdminRemarkDate`, `Status`, `IsRead`, `empid`, `emp_read`, `amount_of_days`, `remaining_days`, `paid`) VALUES
(1, 'Medical Leave', '2022-04-28', '2022-04-29', 'sdf', '2022-04-18', 'sdf', '2022-04-18 0:02:25 ', 1, 1, 7, 0, 2, 12, 1),
(2, 'Vacation leave', '2022-04-23', '2022-04-24', 'vacation test', '2022-04-18', 'ok', '2022-04-18 12:01:24 ', 1, 1, 6, 1, 2, 7, 1),
(3, 'Casual Leave', '2022-05-05', '2022-05-06', 'asd', '2022-04-18', 'ok\r\n', '2022-04-18 12:24:19 ', 1, 1, 6, 1, 2, 18, 2),
(4, 'Sick Leave', '2022-04-29', '2022-04-30', 'sick leave test', '2022-04-18', 'ok', '2022-04-18 12:33:34 ', 1, 1, 6, 1, 2, 12, 2),
(5, 'Leave Type test', '2022-04-21', '2022-04-22', 'description', '2022-04-18', 'granted', '2022-04-18 18:28:24 ', 1, 1, 7, 0, 2, 4, 0),
(6, 'Leave Type test', '2022-04-20', '2022-04-29', 'description', '2022-04-18', 'ok', '2022-04-18 18:30:22 ', 1, 1, 6, 1, 10, 11, 2),
(7, 'Maternity leave', '2022-04-20', '2022-05-05', '--', '2022-04-20', 'no', '2022-04-20 20:41:24 ', 2, 1, 17, 0, 16, 15, 0),
(8, 'Vacation leave', '2022-04-20', '2022-04-23', '--', '2022-04-20', 'ok', '2022-04-20 20:56:41 ', 1, 1, 17, 1, 4, 3, 0),
(9, 'Casual Leave', '2022-04-24', '2022-04-30', 'PL\'s', '2022-04-20', 'granted', '2022-04-20 21:02:16 ', 1, 1, 6, 1, 7, 10, 0);

-- --------------------------------------------------------

--
-- Table structure for table `tblleavetype`
--

CREATE TABLE `tblleavetype` (
  `id` int(11) NOT NULL,
  `LeaveType` varchar(200) DEFAULT NULL,
  `Description` mediumtext DEFAULT NULL,
  `CreationDate` timestamp NOT NULL DEFAULT current_timestamp(),
  `earned_leaves` int(50) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tblleavetype`
--

INSERT INTO `tblleavetype` (`id`, `LeaveType`, `Description`, `CreationDate`, `earned_leaves`) VALUES
(34, 'Casual Leave', 'is granted to an eligible employee if they cannot report to work due to an unforeseen situation.', '2022-04-21 11:09:54', 11),
(35, 'Vacation leave', 'granted to employee for personal reasons, the approval of which is contingent upon the necessities of the service. • Vacation leave without pay is considered a gap. in the service.\r\n\r\n', '2022-04-21 11:09:56', 11),
(36, 'Sick Leave', 'can be used when an employee is ill or injured. An employee may have to take time off to care for an immediate family or household member who is sick or injured or help during a family emergency. ', '2022-04-21 11:10:09', 11),
(37, 'Paternity Leave', 'a period of time that a father is legally allowed to be away from his job so that he can spend time with his new baby: on paternity leave He was on paternity leave after the birth of his son.\r\n\r\n', '2022-04-21 11:10:14', 11),
(38, 'Maternity leave', 'a period of absence from work granted to a mother before and after the birth of her child.', '2022-04-21 11:10:16', 11);

-- --------------------------------------------------------

--
-- Table structure for table `tblleavetype_archive`
--

CREATE TABLE `tblleavetype_archive` (
  `id` int(11) NOT NULL,
  `LeaveType` varchar(200) DEFAULT NULL,
  `Description` mediumtext DEFAULT NULL,
  `DeletionDate` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `earned_leaves` int(50) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tblleavetype_archive`
--

INSERT INTO `tblleavetype_archive` (`id`, `LeaveType`, `Description`, `DeletionDate`, `earned_leaves`) VALUES
(17, 'Medical Leave', 'provides certain employees with up to 12 weeks of unpaid, job-protected leave per year. It also requires that their group health benefits be maintained during the leave.', '2022-04-21 11:09:30', 11);

-- --------------------------------------------------------

--
-- Table structure for table `tblschedule`
--

CREATE TABLE `tblschedule` (
  `id` int(11) NOT NULL,
  `days` varchar(120) NOT NULL,
  `PostingDate` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `AdminRemark` mediumtext DEFAULT NULL,
  `AdminRemarkDate` varchar(120) DEFAULT NULL,
  `Status` int(1) NOT NULL,
  `IsRead` int(1) NOT NULL,
  `empid` int(11) DEFAULT NULL,
  `emp_read` int(1) NOT NULL,
  `shift_type_id` int(11) NOT NULL,
  `shift_type_detail` varchar(120) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tblschedule`
--

INSERT INTO `tblschedule` (`id`, `days`, `PostingDate`, `AdminRemark`, `AdminRemarkDate`, `Status`, `IsRead`, `empid`, `emp_read`, `shift_type_id`, `shift_type_detail`) VALUES
(7, 'Tue-Thu-Sat-', '2022-04-09 02:56:01', 'Granted', '2022-04-09 10:49:28 ', 1, 1, 6, 1, 13, 'From 8:00 am To 6:00 pm'),
(8, 'Mon-Wed-Fri-', '2022-04-18 10:43:17', 'ok\r\n', '2022-04-18 18:43:05 ', 1, 1, 6, 1, 14, 'From 6:42 pm To 10:42 pm'),
(9, 'Mon-Tue-Wed-Thu-Fri-Sat-', '2022-04-19 10:46:48', 'Granted', '2022-04-19 16:40:26 ', 1, 1, 17, 1, 14, 'From 6:42 pm To 10:42 pm');

-- --------------------------------------------------------

--
-- Table structure for table `tblschedule_archive`
--

CREATE TABLE `tblschedule_archive` (
  `id` int(11) NOT NULL,
  `shift_schedule` varchar(120) NOT NULL,
  `days` varchar(120) NOT NULL,
  `empid` int(11) NOT NULL,
  `DeletionDate` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tblschedule_archive`
--

INSERT INTO `tblschedule_archive` (`id`, `shift_schedule`, `days`, `empid`, `DeletionDate`) VALUES
(1, 'Split Shift (from 06:00 to 11:00)', 'Thursday', 15, '2021-12-01 08:27:14'),
(2, 'Overload (from 08:00 to 20:00)', 'Saturday', 15, '2021-12-01 08:32:06'),
(3, 'Fixed Shift (from 07:00 to 22:00)', 'Friday', 15, '2021-12-01 08:35:45'),
(4, 'Night Shift (from 20:00 to 06:00)', 'Tuesday', 15, '2021-12-01 09:26:14'),
(5, 'Day Shift (from 07:00 to 20:00)', 'Monday', 15, '2021-12-02 05:25:26'),
(6, 'Night Shift (from:22:00:00 to:06:00:00)', 'Wednesday', 12, '2021-12-04 01:00:46'),
(7, ' (from: to:)', 'Tue-Wed-Fri-', 6, '2022-03-31 07:19:08');

-- --------------------------------------------------------

--
-- Table structure for table `tblshifttype_archive`
--

CREATE TABLE `tblshifttype_archive` (
  `id` int(11) NOT NULL,
  `name` varchar(120) NOT NULL,
  `fromTime` varchar(120) NOT NULL,
  `toTime` varchar(120) NOT NULL,
  `DeletionDate` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tblshifttype_archive`
--

INSERT INTO `tblshifttype_archive` (`id`, `name`, `fromTime`, `toTime`, `DeletionDate`) VALUES
(1, 'Premuim', '07:00', '17:00', '2021-12-02 05:27:48'),
(2, 'shit', '06:00', '20:00', '2021-12-02 05:27:48');

-- --------------------------------------------------------

--
-- Table structure for table `tblshift_type`
--

CREATE TABLE `tblshift_type` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `fromTime` time NOT NULL,
  `toTime` time NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tblshift_type`
--

INSERT INTO `tblshift_type` (`id`, `name`, `fromTime`, `toTime`) VALUES
(13, 'Day Shift', '08:00:00', '18:00:00'),
(14, 'sample shift', '18:42:00', '22:42:00'),
(15, 'Night Shift', '18:00:00', '03:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `time_attendance`
--

CREATE TABLE `time_attendance` (
  `time_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `login_time` datetime NOT NULL,
  `logout_time` datetime NOT NULL,
  `username` varchar(20) NOT NULL,
  `name` varchar(200) NOT NULL,
  `user_level` int(11) NOT NULL,
  `calculated_work` varchar(200) NOT NULL,
  `working` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `time_attendance`
--

INSERT INTO `time_attendance` (`time_id`, `user_id`, `login_time`, `logout_time`, `username`, `name`, `user_level`, `calculated_work`, `working`) VALUES
(4, 11, '2022-03-30 18:53:32', '2022-03-30 18:53:34', 'admin1', 'Admin RJ', 1, '0 Hours (0.03 Minutes)', 0),
(5, 11, '2022-03-30 21:46:56', '2022-03-30 21:47:13', 'admin1', 'Admin RJ', 1, '0 Hours (0.28 Minutes)', 0),
(6, 11, '2022-03-30 21:47:20', '2022-03-30 21:48:08', 'admin1', 'Admin RJ', 1, '0.01 Hours (0.8 Minutes)', 0),
(7, 17, '2022-04-08 10:44:57', '2022-04-08 10:44:59', 'hanna', 'Hanna', 2, '0 Hours (0.03 Minutes)', 0),
(8, 17, '2022-04-08 11:14:58', '2022-04-08 14:15:00', 'Hanna', 'Hanna', 3, '3 Hours (180.03 Minutes)', 0),
(10, 6, '2022-04-19 19:10:57', '2022-04-19 19:10:58', 'Employee', 'Employee', 3, '0 Hours (0.02 Minutes)', 0),
(11, 17, '2022-04-19 18:47:38', '2022-04-19 18:49:36', 'Hanna', 'Hanna', 3, '0.03 Hours (1.97 Minutes)', 0);

-- --------------------------------------------------------

--
-- Table structure for table `time_attendance_archive`
--

CREATE TABLE `time_attendance_archive` (
  `time_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `login_time` datetime NOT NULL,
  `logout_time` datetime NOT NULL,
  `username` varchar(20) NOT NULL,
  `name` varchar(200) NOT NULL,
  `user_level` int(11) NOT NULL,
  `calculated_work` varchar(200) NOT NULL,
  `working` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `time_attendance_archive`
--

INSERT INTO `time_attendance_archive` (`time_id`, `user_id`, `login_time`, `logout_time`, `username`, `name`, `user_level`, `calculated_work`, `working`) VALUES
(112, 11, '2022-01-11 16:44:19', '2022-01-11 16:45:43', 'admin1', 'Admin RJ', 1, '0.02 Hours (1.4 Minutes)', 0),
(1, 11, '2022-03-30 18:51:05', '0000-00-00 00:00:00', 'admin1', 'Admin RJ', 1, '0 Hours (0.27 Minutes)', 0),
(3, 11, '2022-03-30 18:52:58', '0000-00-00 00:00:00', 'admin1', 'Admin RJ', 1, '0 Hours (0.02 Minutes)', 0),
(2, 11, '2022-03-30 18:51:34', '0000-00-00 00:00:00', 'admin1', 'Admin RJ', 1, '0.01 Hours (0.48 Minutes)', 0),
(9, 6, '2022-04-19 18:46:59', '2022-04-19 21:47:08', 'employee', 'Employee', 3, '3 Hours (180.15 Minutes)', 0);

-- --------------------------------------------------------

--
-- Table structure for table `uexpenses`
--

CREATE TABLE `uexpenses` (
  `Co_Code` int(200) NOT NULL,
  `UE_Department` varchar(200) NOT NULL,
  `UE_Requestor` varchar(200) NOT NULL,
  `UE_date` date NOT NULL,
  `UE_Desc` varchar(200) NOT NULL,
  `Co_Status` int(200) NOT NULL,
  `UE_Supplier` varchar(200) NOT NULL,
  `UE_Address` varchar(200) NOT NULL,
  `UE_City` varchar(200) NOT NULL,
  `UE_Country` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `uexpenses`
--

INSERT INTO `uexpenses` (`Co_Code`, `UE_Department`, `UE_Requestor`, `UE_date`, `UE_Desc`, `Co_Status`, `UE_Supplier`, `UE_Address`, `UE_City`, `UE_Country`) VALUES
(1, 'Admin', 'Admin manager', '2021-12-03', 'for utilities and expenses', 102, 'Admin', 'Quirino Highway, Novaliches', 'Quezon City', 'Philippines'),
(2, 'Admin', 'Admin manager', '2021-12-04', 'maintenance', 102, 'Admin', 'Quirino Highway, Novaliches', 'Quezon City', 'Philippines'),
(3, 'Admin', 'Admin manager', '2021-12-07', 'Transportation', 102, 'Admin', 'Quirino Highway, Novaliches', 'Quezon City', 'Philippines');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) UNSIGNED NOT NULL,
  `name` varchar(60) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `user_level` int(11) NOT NULL,
  `image` varchar(255) DEFAULT 'no_image.jpg',
  `status` int(1) NOT NULL,
  `last_login` datetime DEFAULT NULL,
  `reimbursement_budget` int(11) UNSIGNED NOT NULL,
  `reimbursement_notif` int(10) UNSIGNED NOT NULL,
  `claim_notif` int(10) UNSIGNED NOT NULL,
  `complaint_notif` int(10) UNSIGNED NOT NULL,
  `leave_token` int(50) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `username`, `password`, `user_level`, `image`, `status`, `last_login`, `reimbursement_budget`, `reimbursement_notif`, `claim_notif`, `complaint_notif`, `leave_token`) VALUES
(6, 'Employee', 'Employee', 'caf322f0bbed721eac4a36bf7aff1103079faf25', 3, 'no_image.jpg', 1, '2022-04-20 21:01:54', 10010, 0, 0, 0, 55),
(7, 'Admin Account', 'Admin', 'b3aca92c793ee0e9b1a9b0a5f5fc044e05140df3', 1, 'hjwkjm57.jpg', 1, '2022-04-19 19:13:57', 80000, 1, 0, 0, 55),
(8, 'HR STAFF', 'Staff', '6ccb4b7c39a6e77f76ecfa935a855c6c46ad5611', 2, 'no_image.jpg', 1, '2022-04-20 13:37:56', 25000, 0, 0, 0, 55),
(11, 'Admin RJ', 'admin1', '6c7ca345f63f835cb353ff15bd6c5e052ec08e7a', 1, 'no_image.jpg', 1, '2022-04-18 18:40:27', 49900, 0, 0, 0, 55),
(12, 'jin rodriguez', 'rjinxed', 'edfe1a7498382498795c8aec7c4c2f18db6d10e4', 3, 'ism81pq10.jpg', 1, '2022-03-30 17:49:32', 700, 0, 2, 0, 55),
(13, 'name', 'username', '5baa61e4c9b93f3f0682250b6cf8331b7ee68fd8', 1, 'no_image.jpg', 1, NULL, 5000, 0, 0, 0, 55),
(15, 'asdasd', 'asdasd', '85136c79cbf9fe36bb9d05d0639c70c265c18d37', 1, 'no_image.jpg', 1, '2022-03-21 15:17:30', 100, 0, 0, 0, 55),
(16, 'Lawrence', 'lj', '846251899cbc801a4d307becd54393a88ad1536d', 1, 'bso7e8j116.jpg', 1, '2022-04-21 15:36:28', 0, 0, 0, 0, 55),
(17, 'Hanna', 'Hanna', '26f769205f6a2faa1521d5d628ecf51210aebeb0', 3, 'no_image.jpg', 1, '2022-04-20 20:39:23', 0, 0, 1, 0, 55),
(18, 'Juan DLC', 'juan', 'b49a5780a99ea81284fc0746a78f84a30e4d5c73', 3, 'no_image.jpg', 1, '2022-04-20 21:16:28', 0, 0, 0, 0, 55);

-- --------------------------------------------------------

--
-- Table structure for table `users_1`
--

CREATE TABLE `users_1` (
  `id` int(11) UNSIGNED NOT NULL,
  `name` varchar(60) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `user_level` int(11) NOT NULL,
  `image` varchar(255) DEFAULT 'no_image.jpg',
  `status` int(1) NOT NULL,
  `last_login` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users_1`
--

INSERT INTO `users_1` (`id`, `name`, `username`, `password`, `user_level`, `image`, `status`, `last_login`) VALUES
(10, 'Peter', 'Admin', '134096e12368b9bce038ccac61963716c01fa8ee', 1, 'lsu2olid10.jpg', 1, '2022-03-21 15:04:06'),
(12, 'Mae Ann Caunca', 'User', '12dea96fec20593566ab75692c9949596833adc9', 2, '3gy5cpqg12.jpg', 0, '2022-03-20 16:19:05'),
(14, 'AnotherAdmin', 'AnotherAdmin11', '8451ba8a14d79753d34cb33b51ba46b4b025eb81', 1, 'no_image.jpg', 1, '2022-03-15 00:04:21');

-- --------------------------------------------------------

--
-- Table structure for table `user_groups`
--

CREATE TABLE `user_groups` (
  `id` int(11) NOT NULL,
  `group_name` varchar(150) NOT NULL,
  `group_level` int(11) NOT NULL,
  `group_status` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user_groups`
--

INSERT INTO `user_groups` (`id`, `group_name`, `group_level`, `group_status`) VALUES
(1, 'Super Admin', 1, 1),
(2, 'Admin', 2, 1),
(3, 'User', 3, 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `budgetreleasing`
--
ALTER TABLE `budgetreleasing`
  ADD PRIMARY KEY (`P_ID`),
  ADD KEY `FK_budgetreleasing_s` (`P_Status`),
  ADD KEY `FK_procurmentreleasing` (`P_Code`);

--
-- Indexes for table `claim`
--
ALTER TABLE `claim`
  ADD PRIMARY KEY (`claim_id`);

--
-- Indexes for table `claim_archive`
--
ALTER TABLE `claim_archive`
  ADD PRIMARY KEY (`claim_id`);

--
-- Indexes for table `claim_type_admin`
--
ALTER TABLE `claim_type_admin`
  ADD PRIMARY KEY (`claim_type_id`);

--
-- Indexes for table `collection`
--
ALTER TABLE `collection`
  ADD PRIMARY KEY (`Co_Code`);

--
-- Indexes for table `collection_transactions`
--
ALTER TABLE `collection_transactions`
  ADD PRIMARY KEY (`LT_id`);

--
-- Indexes for table `complaints`
--
ALTER TABLE `complaints`
  ADD PRIMARY KEY (`complaint_id`);

--
-- Indexes for table `events`
--
ALTER TABLE `events`
  ADD PRIMARY KEY (`event_id`);

--
-- Indexes for table `expenses`
--
ALTER TABLE `expenses`
  ADD PRIMARY KEY (`Id`);

--
-- Indexes for table `obudget`
--
ALTER TABLE `obudget`
  ADD PRIMARY KEY (`Id`);

--
-- Indexes for table `procurment`
--
ALTER TABLE `procurment`
  ADD PRIMARY KEY (`Co_Code`),
  ADD KEY `FK_procurment` (`Co_Status`);

--
-- Indexes for table `proposals`
--
ALTER TABLE `proposals`
  ADD PRIMARY KEY (`Co_Code`);

--
-- Indexes for table `purchases`
--
ALTER TABLE `purchases`
  ADD PRIMARY KEY (`PU_id`);

--
-- Indexes for table `reimbursements`
--
ALTER TABLE `reimbursements`
  ADD PRIMARY KEY (`reimbursement_id`);

--
-- Indexes for table `reimbursment`
--
ALTER TABLE `reimbursment`
  ADD PRIMARY KEY (`Co_Code`);

--
-- Indexes for table `status`
--
ALTER TABLE `status`
  ADD PRIMARY KEY (`Status_Code`);

--
-- Indexes for table `tblleaves`
--
ALTER TABLE `tblleaves`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tblleavetype`
--
ALTER TABLE `tblleavetype`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tblleavetype_archive`
--
ALTER TABLE `tblleavetype_archive`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tblschedule`
--
ALTER TABLE `tblschedule`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tblschedule_archive`
--
ALTER TABLE `tblschedule_archive`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tblshifttype_archive`
--
ALTER TABLE `tblshifttype_archive`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tblshift_type`
--
ALTER TABLE `tblshift_type`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `time_attendance`
--
ALTER TABLE `time_attendance`
  ADD PRIMARY KEY (`time_id`);

--
-- Indexes for table `uexpenses`
--
ALTER TABLE `uexpenses`
  ADD PRIMARY KEY (`Co_Code`),
  ADD KEY `FK_uexpenses` (`Co_Status`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_level` (`user_level`);

--
-- Indexes for table `users_1`
--
ALTER TABLE `users_1`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_level` (`user_level`);

--
-- Indexes for table `user_groups`
--
ALTER TABLE `user_groups`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `group_level` (`group_level`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `budgetreleasing`
--
ALTER TABLE `budgetreleasing`
  MODIFY `P_ID` int(200) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=257;

--
-- AUTO_INCREMENT for table `claim`
--
ALTER TABLE `claim`
  MODIFY `claim_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=115;

--
-- AUTO_INCREMENT for table `claim_archive`
--
ALTER TABLE `claim_archive`
  MODIFY `claim_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `claim_type_admin`
--
ALTER TABLE `claim_type_admin`
  MODIFY `claim_type_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `collection`
--
ALTER TABLE `collection`
  MODIFY `Co_Code` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=117;

--
-- AUTO_INCREMENT for table `collection_transactions`
--
ALTER TABLE `collection_transactions`
  MODIFY `LT_id` int(200) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `events`
--
ALTER TABLE `events`
  MODIFY `event_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `expenses`
--
ALTER TABLE `expenses`
  MODIFY `Id` int(200) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=98;

--
-- AUTO_INCREMENT for table `obudget`
--
ALTER TABLE `obudget`
  MODIFY `Id` int(200) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `procurment`
--
ALTER TABLE `procurment`
  MODIFY `Co_Code` int(200) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=111;

--
-- AUTO_INCREMENT for table `proposals`
--
ALTER TABLE `proposals`
  MODIFY `Co_Code` int(200) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1110;

--
-- AUTO_INCREMENT for table `purchases`
--
ALTER TABLE `purchases`
  MODIFY `PU_id` int(200) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT for table `reimbursements`
--
ALTER TABLE `reimbursements`
  MODIFY `reimbursement_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `reimbursment`
--
ALTER TABLE `reimbursment`
  MODIFY `Co_Code` int(200) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1008;

--
-- AUTO_INCREMENT for table `status`
--
ALTER TABLE `status`
  MODIFY `Status_Code` int(200) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=106;

--
-- AUTO_INCREMENT for table `tblleaves`
--
ALTER TABLE `tblleaves`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `tblleavetype`
--
ALTER TABLE `tblleavetype`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;

--
-- AUTO_INCREMENT for table `tblleavetype_archive`
--
ALTER TABLE `tblleavetype_archive`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `tblschedule`
--
ALTER TABLE `tblschedule`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `tblschedule_archive`
--
ALTER TABLE `tblschedule_archive`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `tblshifttype_archive`
--
ALTER TABLE `tblshifttype_archive`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `tblshift_type`
--
ALTER TABLE `tblshift_type`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `time_attendance`
--
ALTER TABLE `time_attendance`
  MODIFY `time_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `uexpenses`
--
ALTER TABLE `uexpenses`
  MODIFY `Co_Code` int(200) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `users_1`
--
ALTER TABLE `users_1`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `budgetreleasing`
--
ALTER TABLE `budgetreleasing`
  ADD CONSTRAINT `FK_budgetreleasing_s` FOREIGN KEY (`P_Status`) REFERENCES `status` (`Status_Code`);

--
-- Constraints for table `uexpenses`
--
ALTER TABLE `uexpenses`
  ADD CONSTRAINT `FK_uexpenses` FOREIGN KEY (`Co_Status`) REFERENCES `status` (`Status_Code`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
