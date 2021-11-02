-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Gép: 127.0.0.1
-- Létrehozás ideje: 2021. Okt 31. 21:22
-- Kiszolgáló verziója: 10.4.21-MariaDB
-- PHP verzió: 8.0.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

CREATE DATABASE `taviranyito`
CHARACTER SET utf8
COLLATE utf8_hungarian_ci;

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Adatbázis: `taviranyito`
--

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `taviranyitok`
--

CREATE TABLE `taviranyitok` (
  `id` int(11) NOT NULL,
  `gyarto` varchar(255) COLLATE utf8_hungarian_ci NOT NULL,
  `termek_nev` varchar(516) COLLATE utf8_hungarian_ci NOT NULL,
  `megjelenes` date NOT NULL,
  `ar` int(11) NOT NULL,
  `elerheto` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_hungarian_ci;

--
-- A tábla adatainak kiíratása `taviranyitok`
--

INSERT INTO `taviranyitok` (`id`, `gyarto`, `termek_nev`, `megjelenes`, `ar`, `elerheto`) VALUES
(1, 'LG', 'taviranyitó Pro max', '2021-10-22', 10000, 0),
(2, "Philip's", 'Táv-irány-ító', '2021-10-22', 250000, 0),
(3, 'Sony', 'Pju-Pju 5000', '2021-10-22', 2500, 0),
(4, 'Lég-kondik', 'levegőztető 2000', '2021-10-22', 12000, 0),
(5, 'Lég-kondik', 'telefonos app', '2021-10-22', 100, 0);

--
-- Indexek a kiírt táblákhoz
--

--
-- A tábla indexei `taviranyitok`
--
ALTER TABLE `taviranyitok`
  ADD PRIMARY KEY (`id`);

--
-- A kiírt táblák AUTO_INCREMENT értéke
--

--
-- AUTO_INCREMENT a táblához `taviranyitok`
--
ALTER TABLE `taviranyitok`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
