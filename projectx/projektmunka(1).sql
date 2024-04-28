-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Gép: 127.0.0.1
-- Létrehozás ideje: 2024. Ápr 28. 19:55
-- Kiszolgáló verziója: 10.4.28-MariaDB
-- PHP verzió: 8.1.17

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Adatbázis: `projektmunka`
--

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `kategoria`
--

CREATE TABLE `kategoria` (
  `kategoria_id` int(11) NOT NULL,
  `nev` varchar(64) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- A tábla adatainak kiíratása `kategoria`
--

INSERT INTO `kategoria` (`kategoria_id`, `nev`) VALUES
(1, 'Nyári gumi'),
(2, 'Téli gumi'),
(3, 'Négyévszakos');

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `kepek`
--

CREATE TABLE `kepek` (
  `kep_id` int(11) NOT NULL,
  `file_name` varchar(255) NOT NULL,
  `file_type` varchar(50) NOT NULL,
  `file_size` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- A tábla adatainak kiíratása `kepek`
--

INSERT INTO `kepek` (`kep_id`, `file_name`, `file_type`, `file_size`) VALUES
(1, 'cvkep.jpg', 'jpg', 26155),
(2, 'png-clipart-car-tires-realistic-tire-car-thumbnail.png', 'png', 13806),
(3, 'heart.png', 'png', 21413);

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `kosar`
--

CREATE TABLE `kosar` (
  `kosar_id` int(11) NOT NULL,
  `termek_id` int(11) NOT NULL,
  `termek_neve` varchar(255) NOT NULL,
  `szelesseg` int(11) DEFAULT NULL,
  `darab` int(11) NOT NULL,
  `ara` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `kosarbane` int(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- A tábla adatainak kiíratása `kosar`
--

INSERT INTO `kosar` (`kosar_id`, `termek_id`, `termek_neve`, `szelesseg`, `darab`, `ara`, `user_id`, `kosarbane`) VALUES
(51, 2, 'kerek', 0, 10, 30, 16, 1),
(55, 2, 'kolozsvár', 320, 3, 42000, 13, 1);

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `rendeles`
--

CREATE TABLE `rendeles` (
  `order_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `lastName` varchar(255) NOT NULL,
  `firstName` varchar(255) NOT NULL,
  `termek_id` int(11) NOT NULL,
  `termek_nev` varchar(255) NOT NULL,
  `darab` int(11) NOT NULL,
  `ar` int(11) NOT NULL,
  `aktiv` int(11) NOT NULL DEFAULT 0,
  `iranyitoszam` int(11) DEFAULT NULL,
  `utca` varchar(255) DEFAULT NULL,
  `hazszam` int(255) DEFAULT NULL,
  `phone` varchar(11) NOT NULL,
  `szallitas` int(1) NOT NULL,
  `date` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- A tábla adatainak kiíratása `rendeles`
--

INSERT INTO `rendeles` (`order_id`, `user_id`, `lastName`, `firstName`, `termek_id`, `termek_nev`, `darab`, `ar`, `aktiv`, `iranyitoszam`, `utca`, `hazszam`, `phone`, `szallitas`, `date`) VALUES
(31, 12, '', '', 1, 'fal', 1, 100, 4, NULL, NULL, NULL, '', 0, '2024-04-26'),
(32, 12, '', '', 2, 'kerek', 1, 30, 4, NULL, NULL, NULL, '', 0, '2024-04-26'),
(33, 12, 'e', 'e', 1, 'fal', 1, 100, 2, NULL, NULL, NULL, 'w', 0, '2024-04-27'),
(34, 12, 'e', 'e', 2, 'kerek', 1, 30, 2, NULL, NULL, NULL, 'w', 0, '2024-04-27'),
(35, 12, '', '', 1, 'fal', 1, 100, 2, 0, 'w', 2, '', 1, '2024-04-28'),
(36, 12, '', '', 2, 'kerek', 1, 30, 2, 0, 'w', 2, '', 1, '2024-04-28'),
(37, 13, 'asdasd', 'asdasd', 2, 'fal', 2, 200, 3, 7100, 'asdasagfasfa', 33, '0674412541', 0, '2024-04-28'),
(38, 0, '', '', 1, 'fal', 1, 190, 0, NULL, NULL, NULL, '', 0, NULL),
(39, 0, '', '', 2, 'kerek', 3, 190, 0, NULL, NULL, NULL, '', 0, NULL),
(47, 13, 'Fekete', 'Gergő', 1, 'fal', 1, 100, 3, 7100, 'Klapka', 44, '067412541', 1, '2024-04-24'),
(48, 13, 'Fekete', 'Gergő', 2, 'kerek', 1, 30, 3, 7100, 'Klapka', 44, '067412541', 1, '2024-04-24'),
(50, 13, 'jakab', 'levi', 1, 'fal', 1, 100, 2, NULL, NULL, NULL, '06745698741', 0, '2024-04-23'),
(51, 16, 'jenics', 'ka', 2, 'kerek', 10, 30, 2, NULL, NULL, NULL, '03468468', 0, '2024-04-28'),
(52, 13, 'qwe', 'qwe', 1, 'fal', 1, 100, 2, NULL, NULL, NULL, '2651', 0, '2024-04-28'),
(53, 13, 'qwe', 'qwe', 1, 'fal', 10, 100, 2, NULL, NULL, NULL, '2651', 0, '2024-04-28'),
(56, 13, 'Köcsög', 'Jankó', 2, 'kolozsvár', 3, 42000, 3, 134, 'Ödön', 10, '063056546', 1, '2024-04-29');

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `termekek`
--

CREATE TABLE `termekek` (
  `termek_id` int(11) NOT NULL,
  `nev` varchar(64) NOT NULL,
  `szelesseg` int(11) NOT NULL,
  `profil` int(11) NOT NULL,
  `atmero` int(11) NOT NULL,
  `kategoria_id` int(11) NOT NULL,
  `kep_id` int(11) NOT NULL,
  `ar` int(11) NOT NULL,
  `mennyiseg` int(11) NOT NULL,
  `leiras` varchar(512) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- A tábla adatainak kiíratása `termekek`
--

INSERT INTO `termekek` (`termek_id`, `nev`, `szelesseg`, `profil`, `atmero`, `kategoria_id`, `kep_id`, `ar`, `mennyiseg`, `leiras`) VALUES
(2, 'kolozsvár', 320, 25, 20, 2, 2, 42000, 17, 'gyáá teso nagyon fogja az utat'),
(3, 'Dunlop heee', 205, 40, 16, 1, 3, 3000, 12, 'asdasdasd');

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `fname` varchar(255) NOT NULL,
  `lname` varchar(255) NOT NULL,
  `uname` varchar(255) NOT NULL,
  `email` varchar(200) DEFAULT NULL,
  `password` varchar(200) DEFAULT NULL,
  `admin` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- A tábla adatainak kiíratása `users`
--

INSERT INTO `users` (`id`, `fname`, `lname`, `uname`, `email`, `password`, `admin`) VALUES
(9, 'er', 'er', 'er', 'er@hu', '818f9c45cfa30eeff277ef38bcbe9910', 0),
(10, 'egy', 'egy', 'egy', 'egy@hu', '6a73901588db3d2eac37156006ceb546', 0),
(11, 'x', 'x', 'x', 'x@hu', '9dd4e461268c8034f5c8564e155c67a6', 0),
(12, 'q', 'q', 'q', 'q@q.hu', '7694f4a66316e53c8cdd9d9954bd611d', 0),
(13, 'asdasd', 'asdasd', 'asdasd', 'asd@asd.hu', 'a8f5f167f44f4964e6c998dee827110c', 0),
(14, 'jani', 'jani', 'feketeg', 'jani@ka.hu', 'a8f5f167f44f4964e6c998dee827110c', 1),
(16, 'teszt', 'jani', 'tesz222', 'teszt@teszt.hu', 'a8f5f167f44f4964e6c998dee827110c', 0);

--
-- Indexek a kiírt táblákhoz
--

--
-- A tábla indexei `kategoria`
--
ALTER TABLE `kategoria`
  ADD PRIMARY KEY (`kategoria_id`);

--
-- A tábla indexei `kepek`
--
ALTER TABLE `kepek`
  ADD PRIMARY KEY (`kep_id`);

--
-- A tábla indexei `kosar`
--
ALTER TABLE `kosar`
  ADD PRIMARY KEY (`kosar_id`);

--
-- A tábla indexei `rendeles`
--
ALTER TABLE `rendeles`
  ADD PRIMARY KEY (`order_id`);

--
-- A tábla indexei `termekek`
--
ALTER TABLE `termekek`
  ADD PRIMARY KEY (`termek_id`);

--
-- A tábla indexei `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- A kiírt táblák AUTO_INCREMENT értéke
--

--
-- AUTO_INCREMENT a táblához `kategoria`
--
ALTER TABLE `kategoria`
  MODIFY `kategoria_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT a táblához `kepek`
--
ALTER TABLE `kepek`
  MODIFY `kep_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT a táblához `kosar`
--
ALTER TABLE `kosar`
  MODIFY `kosar_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=56;

--
-- AUTO_INCREMENT a táblához `rendeles`
--
ALTER TABLE `rendeles`
  MODIFY `order_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=57;

--
-- AUTO_INCREMENT a táblához `termekek`
--
ALTER TABLE `termekek`
  MODIFY `termek_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT a táblához `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
