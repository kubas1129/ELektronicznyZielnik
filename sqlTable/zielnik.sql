-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Czas generowania: 11 Sty 2018, 16:51
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
-- Struktura tabeli dla tabeli `przepisy`
--

CREATE TABLE `przepisy` (
  `id` int(11) NOT NULL,
  `name` text COLLATE utf8_polish_ci NOT NULL,
  `description` text COLLATE utf8_polish_ci NOT NULL,
  `recipe` text COLLATE utf8_polish_ci NOT NULL,
  `image` text COLLATE utf8_polish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

--
-- Zrzut danych tabeli `przepisy`
--

INSERT INTO `przepisy` (`id`, `name`, `description`, `recipe`, `image`) VALUES
(4, 'Koktajl miÄ™towy', 'none', 'Do przepisu potrzebujemy Å›wieÅ¼ej miÄ™ty, pieprzu cytrynowego oraz cukru trzcinowego. MiÄ™tÄ™ i cukier miksujemy razem ze sobÄ…, nastÄ™pnie dodajemy pieprz, czekamy aÅ¼ przez 5 minut i dolewamy wody do smaku. Gotowe!                   \r\n                                ', 'cytrynowa.jpg');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `receptury`
--

CREATE TABLE `receptury` (
  `id` int(11) NOT NULL,
  `name` text COLLATE utf8_polish_ci NOT NULL,
  `description` text COLLATE utf8_polish_ci NOT NULL,
  `image` text COLLATE utf8_polish_ci NOT NULL,
  `recipe` text COLLATE utf8_polish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

--
-- Zrzut danych tabeli `receptury`
--

INSERT INTO `receptury` (`id`, `name`, `description`, `image`, `recipe`) VALUES
(18, 'Bazylia', 'Bazylia - rodzaj roÅ›lin z rodziny jasnotowatych. Liczy ok. 35 gatunkÃ³w, rosnÄ…cych dziko gÅ‚Ã³wnie w strefie tropikalnej i subtropikalnej Afryki i Azji.                   \r\n                                ', 'bazylia.jpg', 'NapeÅ‚niamy czysty sÅ‚oik Å›wieÅ¼o zebranymi zioÅ‚ami i zalewamy je olejem z krokoszu barwierskiego, sÅ‚onecznikowym lub oliwÄ… z oliwek tÅ‚oczonÄ… na zimno (oleje o wysokiej trwaÅ‚oÅ›ci) o temperaturze pokojowej. Przykrywamy gazÄ… i zostawiamy na 2 tygodnie do naciÄ…gniÄ™cia, na parapecie nasÅ‚onecznionego okna. Codziennie mieszamy. NastÄ™pnie przecedzamy przez gazÄ™ i sprawdzamy smak. JeÅ›li jest dostatecznie mocny, zlewamy do butelki i opisujemy (oklejamy etykietÄ…: data, nazwa). Przechowujemy w chÅ‚odnym  i ciemnym miejscu (w ciemnych butelkach).                    \r\n                                '),
(19, 'MiÄ™ta', 'MiÄ™ta - rodzaj roÅ›lin z rodziny jasnotowatych (Lamiaceae Lindl.). WystÄ™pujÄ… gÅ‚Ã³wnie w Europie, Azji i Afryce.                   \r\n                                ', 'mieta.jpg', 'PomaraÅ„cze przekrawamy na pÃ³Å‚ i wyciskamy z nich sok. MiÄ™tÄ™ oraz natkÄ™ pietruszki myjemy, siekamy i wrzucamy do pojemnika, w ktÃ³rym bÄ™dziemy blendowaÄ‡ koktajl. Wlewamy takÅ¼e do niego sok z pomaraÅ„czy, dokÅ‚adamy miÄ…Å¼sz, ktÃ³ry pozostaÅ‚ po wyciÅ›niÄ™ciu owocÃ³w, miÃ³d oraz kostki lodu. Blender wÅ‚Ä…czamy na najwyÅ¼sze obroty i miksujemy wszystko jak najdokÅ‚adniej. Koktajl rozlewamy do szklanek, ktÃ³re dekorujemy plasterkiem pomaraÅ„czy.                   \r\n                                ');

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
-- Indexes for table `przepisy`
--
ALTER TABLE `przepisy`
  ADD PRIMARY KEY (`id`);

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
-- AUTO_INCREMENT dla tabeli `przepisy`
--
ALTER TABLE `przepisy`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT dla tabeli `receptury`
--
ALTER TABLE `receptury`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT dla tabeli `uzytkownicy`
--
ALTER TABLE `uzytkownicy`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
