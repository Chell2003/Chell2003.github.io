-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 14, 2024 at 11:26 AM
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
-- Database: `acs_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `clients`
--

CREATE TABLE `clients` (
  `id` int(11) NOT NULL,
  `Student_Num` varchar(255) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `yearandsection` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `clients`
--

INSERT INTO `clients` (`id`, `Student_Num`, `name`, `email`, `phone`, `yearandsection`) VALUES
(13, '202110305', 'Jelixces Cajontoy', 'jelixcescajontoy539@gmail.com', '+639924271899', 'BSCS 3-1'),
(14, '202211854', 'Sumalo	Emmanuel	P.', 'bc.emmanuel.sumalo@cvsu.edu.ph', '09487112541', 'BSCS 3-1'),
(15, '202211984', 'Torres, Joseph Bryant M.', 'joseph.bryantt.torres153@yahoo.com', '09924271899', 'BSCS 3-1'),
(16, '19-01-0624	', 'Perez, John Phillip', 'johnphillip.perez@cvsu.edu.ph', '+639924271899', 'BSCS 3-1'),
(17, '20-01-1278	', 'Maligang, Niño', 'nino.maligang@cvsu.edu.ph', '09924271899', 'BSCS 3-1'),
(18, '202211889', 'Lequin, Anne Raquizha', 'bc.anneraquizha.lequin@cvsu.edu.ph', '+639924271899', 'BSCS 3-1'),
(19, '202110321	', 'Hampac, Neil', 'bc.neil.hampac@cvsu.edu.ph', '09924271899', 'BSCS 3-1'),
(20, '20-01-1209	', 'GALGAO, ZERGS CYRIL', 'zergscyril.galgao@cvsu.edu.ph', '+639924271899', 'BSCS 3-3'),
(21, '202211887', 'Esponga, JSM', 'joannams022101@gmail.com', '+639924271899', 'BSCS 3-3'),
(22, '202211886', 'Dizon, Princess Nicole', 'bc.princessnicole.dizon@cvsu.edu.ph', '+639924271899', 'BSCS 3-3'),
(23, '20-01-1254', 'Dini-ay, Kenneth', 'kenneth.dini-ay@cvsu.edu.ph', '09924271899', 'BSCS 3-1'),
(24, '17-01-0416	', 'Dapiton, Edmar', 'edmardasaviour@gmail.com	', '+639924271899', 'BSCS 1-2');

-- --------------------------------------------------------

--
-- Table structure for table `payments`
--

CREATE TABLE `payments` (
  `id` int(11) NOT NULL,
  `student_id` int(11) DEFAULT NULL,
  `amount_paid` decimal(10,2) DEFAULT NULL,
  `payment_date` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `payments`
--

INSERT INTO `payments` (`id`, `student_id`, `amount_paid`, `payment_date`) VALUES
(13, 13, 120.00, '2024-02-14'),
(14, 14, 120.00, '2024-02-14'),
(15, 15, 120.00, '2024-02-14'),
(16, 16, 120.00, '2024-02-14'),
(17, 17, 120.00, '2024-02-14'),
(18, 18, 120.00, '2024-02-14'),
(19, 19, 120.00, '2024-02-14'),
(20, 20, 120.00, '2024-02-14'),
(21, 21, 120.00, '2024-02-14'),
(22, 22, 120.00, '2024-02-14'),
(23, 23, 120.00, '2024-02-14');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`) VALUES
(1, 'admin', 'admin@123', 'admin123');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `clients`
--
ALTER TABLE `clients`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `payments`
--
ALTER TABLE `payments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `student_id` (`student_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `clients`
--
ALTER TABLE `clients`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `payments`
--
ALTER TABLE `payments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `payments`
--
ALTER TABLE `payments`
  ADD CONSTRAINT `fk_payments_clients` FOREIGN KEY (`student_id`) REFERENCES `clients` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `payments_ibfk_1` FOREIGN KEY (`student_id`) REFERENCES `clients` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
