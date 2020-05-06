-- phpMyAdmin SQL Dump
-- version 5.0.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: May 06, 2020 at 07:47 PM
-- Server version: 10.4.11-MariaDB
-- PHP Version: 7.4.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `EXP2`
--

-- --------------------------------------------------------

--
-- Table structure for table `Lugar`
--

CREATE TABLE `Lugar` (
  `id` int(11) NOT NULL,
  `nombre` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `Lugar`
--

INSERT INTO `Lugar` (`id`, `nombre`) VALUES
(1, ' Centro turístico'),
(2, 'Laboratorios'),
(3, 'Restaurante'),
(4, 'Centro operativo'),
(5, 'Triceratops'),
(6, 'Dilofosaurios'),
(7, 'Velociraptors'),
(8, 'TRex'),
(9, 'Planicie de los herbívoros');

-- --------------------------------------------------------

--
-- Table structure for table `Lugar_Tipo`
--

CREATE TABLE `Lugar_Tipo` (
  `id` int(11) NOT NULL,
  `id_Lugar` int(11) NOT NULL,
  `id_Tipo` int(11) NOT NULL,
  `fechaCreacion` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `Lugar_Tipo`
--

INSERT INTO `Lugar_Tipo` (`id`, `id_Lugar`, `id_Tipo`, `fechaCreacion`) VALUES
(4, 2, 1, '2020-05-06 16:04:07'),
(7, 2, 3, '2020-05-06 16:04:34'),
(10, 4, 1, '2020-05-06 16:43:21'),
(11, 3, 2, '2020-05-06 16:43:31'),
(12, 2, 1, '2020-05-06 16:43:37'),
(13, 2, 1, '2020-05-06 16:44:15'),
(14, 2, 1, '2020-05-06 16:53:13'),
(15, 4, 4, '2020-05-06 16:53:53'),
(16, 4, 2, '2020-05-06 16:54:01'),
(17, 1, 1, '2020-05-06 16:54:10'),
(18, 6, 1, '2020-05-06 16:54:20'),
(19, 6, 2, '2020-05-06 16:54:27'),
(20, 4, 6, '2020-05-06 17:00:43');

-- --------------------------------------------------------

--
-- Table structure for table `Tipo`
--

CREATE TABLE `Tipo` (
  `id` int(11) NOT NULL,
  `nombre` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `Tipo`
--

INSERT INTO `Tipo` (`id`, `nombre`) VALUES
(1, 'Falla eléctrica'),
(2, 'Fuga de herbívoro'),
(3, 'Fuga de Velociraptors'),
(4, 'Fuga de TRex'),
(5, 'Robo de ADN'),
(6, 'Auto descompuesto'),
(7, 'Visitantes en zona no autorizada');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `Lugar`
--
ALTER TABLE `Lugar`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `Lugar_Tipo`
--
ALTER TABLE `Lugar_Tipo`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_Lugar` (`id_Lugar`),
  ADD KEY `id_Tipo` (`id_Tipo`);

--
-- Indexes for table `Tipo`
--
ALTER TABLE `Tipo`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `Lugar`
--
ALTER TABLE `Lugar`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `Lugar_Tipo`
--
ALTER TABLE `Lugar_Tipo`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `Tipo`
--
ALTER TABLE `Tipo`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `Lugar_Tipo`
--
ALTER TABLE `Lugar_Tipo`
  ADD CONSTRAINT `Lugar_Tipo_ibfk_1` FOREIGN KEY (`id_Lugar`) REFERENCES `Lugar` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `Lugar_Tipo_ibfk_2` FOREIGN KEY (`id_Tipo`) REFERENCES `Tipo` (`id`) ON UPDATE CASCADE;
COMMIT;


DELIMITER //
CREATE PROCEDURE agregaEstado(
  Pid_lugar NUMERIC(20),
    Pid_tipo NUMERIC(20))
    BEGIN 
     INSERT INTO Lugar_Tipo (id_lugar,id_tipo) VALUES (Pid_lugar,Pid_tipo);
    END;
//

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
