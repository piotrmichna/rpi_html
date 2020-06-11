-- phpMyAdmin SQL Dump
-- version 4.6.6deb5
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Czas generowania: 02 Maj 2020, 06:06
-- Wersja serwera: 10.0.28-MariaDB-2+b1
-- Wersja PHP: 7.3.14-1~deb10u1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Baza danych: `homster`
--

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `item`
--

CREATE TABLE `item` (
  `id` int(11) NOT NULL,
  `nazwa` varchar(60) NOT NULL,
  `opis` varchar(250) NOT NULL,
  `typid` int(2) NOT NULL,
  `gpio` int(2) NOT NULL,
  `stan` tinyint(1) NOT NULL DEFAULT '0',
  `stime` int(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Zrzut danych tabeli `item`
--

INSERT INTO `item` (`id`, `nazwa`, `opis`, `typid`, `gpio`, `stan`, `stime`) VALUES
(1, 'Pompa', 'Sterowanie pompą', 1, 1, 1, 0),
(2, 'Sekcja 1', 'opis', 2, 4, 1, 60),
(3, 'Sekcja 2', 'opis', 2, 5, 1, 60),
(4, 'Sekcja 3', 'opis', 2, 6, 1, 60),
(5, 'Sekcja 4', 'opis..', 2, 10, 1, 60),
(6, 'Sekcja 5', 'Opis..', 2, 11, 1, 60),
(7, 'Sekcja 6', 'Opis...', 2, 31, 1, 60),
(8, 'Sekcja 7', 'Opis...', 2, 26, 1, 300),
(9, 'Sekcja 8', 'Opis...', 2, 27, 1, 600),
(10, 'Dolewanie ', 'Elektrozawór uzupełniania wody...', 3, 28, 1, 0);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `start_time`
--

CREATE TABLE `start_time` (
  `id` int(11) NOT NULL,
  `nazwa` varchar(60) NOT NULL,
  `hr` int(2) NOT NULL,
  `min` int(2) NOT NULL,
  `stan` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Zrzut danych tabeli `start_time`
--

INSERT INTO `start_time` (`id`, `nazwa`, `hr`, `min`, `stan`) VALUES
(18, 'Start', 22, 25, 0),
(19, 'Start', 22, 32, 0),
(20, 'Start', 22, 44, 0),
(21, 'Start', 10, 0, 0),
(22, 'Start', 23, 15, 0);

--
-- Indeksy dla zrzutów tabel
--

--
-- Indexes for table `item`
--
ALTER TABLE `item`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `start_time`
--
ALTER TABLE `start_time`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT dla tabeli `item`
--
ALTER TABLE `item`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
--
-- AUTO_INCREMENT dla tabeli `start_time`
--
ALTER TABLE `start_time`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
