-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Czas generowania: 01 Lis 2017, 21:31
-- Wersja serwera: 10.1.28-MariaDB
-- Wersja PHP: 7.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Baza danych: `zielnik`
--

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `receptury`
--

CREATE TABLE `receptury` (
  `id` int(11) NOT NULL,
  `name` text COLLATE utf8_polish_ci NOT NULL,
  `description` text COLLATE utf8_polish_ci NOT NULL,
  `image` text COLLATE utf8_polish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

--
-- Zrzut danych tabeli `receptury`
--

INSERT INTO `receptury` (`id`, `name`, `description`, `image`) VALUES
(1, 'Kot', 'Å‚Ä…cz odpowiednie skÅ‚Ä…dniki ze sobÄ….                   \r\n                                ', 'kot'),
(2, 'JaskÃ³Å‚ka', 'Ten przepis naleÅ¼y uwaÅ¼yÄ‡ w kotle z krÃ³likami i robakami.\r\nGotowaÄ‡ z czosnkiem przez 10minut.                   \r\n                                ', 'jaskolka');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `uzytkownicy`
--

CREATE TABLE `uzytkownicy` (
  `id` int(11) NOT NULL,
  `login` text COLLATE utf8_polish_ci NOT NULL,
  `password` text COLLATE utf8_polish_ci NOT NULL,
  `email` text COLLATE utf8_polish_ci NOT NULL,
  `adminright` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

--
-- Zrzut danych tabeli `uzytkownicy`
--

INSERT INTO `uzytkownicy` (`id`, `login`, `password`, `email`, `adminright`) VALUES
(1, 'admin123', '$2y$10$xSn0b.kqS/5W6cG3.VYAzO8hzHCsXnXCJdCIpAqo0b2DkVRHNbKca', 'admin@admin.pl', 1),
(2, 'adam', '$2y$10$97t23kZIB1z9wFQp2.VnUeVxDDzv0qFT5P8P8fbMrIyxq9IwCluRS', 'adam@gmail.com', 0);

--
-- Indeksy dla zrzutów tabel
--

--
-- Indexes for table `receptury`
--
ALTER TABLE `receptury`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `uzytkownicy`
--
ALTER TABLE `uzytkownicy`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT dla tabeli `receptury`
--
ALTER TABLE `receptury`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT dla tabeli `uzytkownicy`
--
ALTER TABLE `uzytkownicy`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
