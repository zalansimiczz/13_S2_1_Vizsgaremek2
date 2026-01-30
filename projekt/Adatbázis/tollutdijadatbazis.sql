-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Gép: localhost
-- Létrehozás ideje: 2026. Jan 30. 08:32
-- Kiszolgáló verziója: 8.0.42
-- PHP verzió: 8.2.29

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Adatbázis: `tollutdijadatbazis`
--
CREATE DATABASE IF NOT EXISTS `tollutdijadatbazis` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `tollutdijadatbazis`;

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `cegek`
--

CREATE TABLE `cegek` (
  `id` int NOT NULL,
  `nev` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `adoszam` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `cim` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `statusz` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- A tábla adatainak kiíratása `cegek`
--

INSERT INTO `cegek` (`id`, `nev`, `adoszam`, `cim`, `statusz`, `created_at`) VALUES
(1, 'Demo Cég2', '12345678-1-13', '1234 Budapest, Demo utca 1.', 'aktiv', '2025-11-12 11:07:09'),
(2, 'Demo Kft.', '12345678-1-25', '1234 Kakas, Liba utca 1.', 'aktiv', '2025-11-18 08:39:54'),
(3, 'Demo Cég', '12345678-1-12', '1234 Budapest, Demo utca 1.', 'aktiv', '2025-11-18 08:41:55'),
(4, 'Demo Huba Kft.', '12345678-1-26', '1234 Budapest, Kakas utca 1', 'aktiv', '2025-11-18 09:08:29');

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `felhasznalok`
--

CREATE TABLE `felhasznalok` (
  `id` int NOT NULL,
  `ceg_id` int DEFAULT NULL,
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `jelszo_hash` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `teljes_nev` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `aktiv` tinyint(1) DEFAULT '1',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `role` enum('rendszer_admin','ceg_admin','operator') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'operator'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- A tábla adatainak kiíratása `felhasznalok`
--

INSERT INTO `felhasznalok` (`id`, `ceg_id`, `email`, `jelszo_hash`, `teljes_nev`, `aktiv`, `created_at`, `role`) VALUES
(2, 1, 'placeholder@demo.hu', '$2a$12$UBhtdkUq1hGTrTg3sw3W0Oi7qQYPUi1zK0hKhhdYLCjq2kMmBOZsK', 'Demo Felhasználó', 1, '2025-11-12 11:07:18', 'ceg_admin'),
(3, 2, 'peter.demo@gmail.com', '$2y$10$zgIlByQN8R8WYth6MGhYAObpCd7r.0ak2dQ9NP/P4YvskHHX4jLAa', 'Demo Péter', 1, '2025-11-18 08:39:54', 'rendszer_admin'),
(4, 3, 'jozsi.demo@gmail.com', '$2y$10$YyQofnv673Cqg/ZZEg/QYuJyrEslN8L1H1ZI/2kcPDrH0VupDpctK', 'Demo Józsi', 1, '2025-11-18 08:41:55', 'operator'),
(5, 4, 'hubiii@gmail.com', '$2y$10$mNhtsYI5rOA.HzyA1Je5/uLcuTiR4q30E8/crRN5Y4ERWAvY9ccMm', 'Nagy Huba', 0, '2025-11-18 09:08:29', 'operator'),
(6, 1, 'placeholder1@demo.hu', '$2y$10$xesnsmm9fLlElCpBODbnSenLzZVuVEOYm7SqBuerLeb/Ii.NDen.S', 'Demo G', 1, '2025-11-18 09:16:44', 'operator');

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `felhasznalo_sessionok`
--

CREATE TABLE `felhasznalo_sessionok` (
  `id` int NOT NULL,
  `felhasznalo_id` int NOT NULL,
  `token` varchar(64) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `lejart_at` timestamp NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `jarmuvek`
--

CREATE TABLE `jarmuvek` (
  `id` int NOT NULL,
  `ceg_id` int DEFAULT NULL,
  `kategoria` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `marka` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `tipus` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `tengelyszam` int DEFAULT NULL,
  `rendszam` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `vin` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `euro_besorolas` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `ossztomeg_kg` int DEFAULT NULL,
  `potkocsi_kepes` tinyint(1) DEFAULT '0',
  `device_id` int DEFAULT NULL,
  `aktiv` tinyint(1) DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- A tábla adatainak kiíratása `jarmuvek`
--

INSERT INTO `jarmuvek` (`id`, `ceg_id`, `kategoria`, `marka`, `tipus`, `tengelyszam`, `rendszam`, `vin`, `euro_besorolas`, `ossztomeg_kg`, `potkocsi_kepes`, `device_id`, `aktiv`) VALUES
(6, 1, 'Teherautó', 'Volvo', 'FH', 2, 'ABC-123', 'VIN000000000001', 'EURO6', 18000, 1, 1, 1),
(7, 1, 'Teherautó', 'Scania', 'R450', 2, 'DEF-456', 'VIN000000000002', 'EURO6', 19000, 1, 2, 1),
(8, 1, 'Kisteher', 'Mercedes', 'Sprinter', 2, 'GHI-789', 'VIN000000000003', 'EURO6', 3500, 0, 3, 1),
(9, 2, 'Teherautó', 'MAN', 'TGX', 3, 'JKL-012', 'VIN000000000004', 'EURO5', 26000, 1, 4, 0);

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `jogositvanyok`
--

CREATE TABLE `jogositvanyok` (
  `id` int NOT NULL,
  `sofor_id` int DEFAULT NULL,
  `kategoria` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `erv_tol` date DEFAULT NULL,
  `erv_ig` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- A tábla adatainak kiíratása `jogositvanyok`
--

INSERT INTO `jogositvanyok` (`id`, `sofor_id`, `kategoria`, `erv_tol`, `erv_ig`) VALUES
(11, 2, 'B', '2010-01-01', '2026-12-31'),
(12, 2, 'C', '2012-06-15', '2024-06-14'),
(13, 2, 'D', '2015-03-01', '2025-03-01'),
(14, 3, 'B', '2018-05-10', '2028-05-09'),
(15, 5, 'D', '2019-07-01', '2029-06-30'),
(16, 2, 'C', '2026-01-27', '2031-01-27'),
(17, 2, 'CE', '2026-01-27', '2031-01-27'),
(18, 2, 'B', '2010-01-01', '2026-12-31'),
(19, 2, 'C1', '2026-01-27', '2031-01-27'),
(20, 2, 'B', '2010-01-01', '2027-01-02'),
(21, 2, 'CE', '2026-01-27', '2031-01-27');

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `menetlevelek`
--

CREATE TABLE `menetlevelek` (
  `id` int NOT NULL,
  `sofor_id` int DEFAULT NULL,
  `jarmu_id` int DEFAULT NULL,
  `device_id` int DEFAULT NULL,
  `start_idopont` timestamp NULL DEFAULT NULL,
  `end_idopont` timestamp NULL DEFAULT NULL,
  `start_azon_id` int DEFAULT NULL,
  `end_azon_id` int DEFAULT NULL,
  `start_location` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `end_location` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `rfid_azonositasok`
--

CREATE TABLE `rfid_azonositasok` (
  `id` int NOT NULL,
  `device_id` int DEFAULT NULL,
  `kartya_id` int DEFAULT NULL,
  `sofor_id` int DEFAULT NULL,
  `eredmeny` tinyint(1) DEFAULT NULL,
  `hibakod` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `idobelyeg` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `megjegyzes` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `rfid_kartyak`
--

CREATE TABLE `rfid_kartyak` (
  `id` int NOT NULL,
  `uid_hex` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `tipus` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `rfid_kartya_hozzarendeles`
--

CREATE TABLE `rfid_kartya_hozzarendeles` (
  `id` int NOT NULL,
  `kartya_id` int DEFAULT NULL,
  `sofor_id` int DEFAULT NULL,
  `erv_tol` timestamp NULL DEFAULT NULL,
  `erv_ig` timestamp NULL DEFAULT NULL,
  `aktiv` tinyint(1) DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `soforok`
--

CREATE TABLE `soforok` (
  `id` int NOT NULL,
  `ceg_id` int DEFAULT NULL,
  `szemelyi_azonosito` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `nev` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `szuletesi_datum` date DEFAULT NULL,
  `telefonszam` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `cim` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `adoszam` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `aktiv` tinyint(1) DEFAULT '1',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- A tábla adatainak kiíratása `soforok`
--

INSERT INTO `soforok` (`id`, `ceg_id`, `szemelyi_azonosito`, `nev`, `szuletesi_datum`, `telefonszam`, `cim`, `adoszam`, `aktiv`, `created_at`) VALUES
(2, 1, '234567BB', 'Nagy Anna', '1990-07-25', '+36201234568', '4025 Debrecen, Kossuth tér 5.', '23456789-1-09', 1, '2026-01-22 14:19:11'),
(3, 2, '345678CC', 'Szabó László', '1978-11-02', '+36701234569', '6720 Szeged, Tisza Lajos krt. 10.', '34567890-2-06', 0, '2026-01-22 14:19:11'),
(5, 3, '567890EE', 'Varga Gábor', '1982-09-30', '+36209998877', '8000 Székesfehérvár, Bartók Béla út 7.', '56789012-1-07', 1, '2026-01-22 14:19:11');

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `trackereszkozok`
--

CREATE TABLE `trackereszkozok` (
  `id` int NOT NULL,
  `imei` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `sim_iccid` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `modell` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `firmware_verzio` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `aktiv` tinyint(1) DEFAULT '1',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- A tábla adatainak kiíratása `trackereszkozok`
--

INSERT INTO `trackereszkozok` (`id`, `imei`, `sim_iccid`, `modell`, `firmware_verzio`, `aktiv`, `created_at`) VALUES
(1, '359881234567890', '2160123456789012345', 'Tracker X100', '1.0.3', 1, '2025-01-10 08:15:00'),
(2, '359881234567891', '2160123456789012346', 'Tracker X100', '1.0.3', 1, '2025-01-12 13:32:10'),
(3, '359881234567892', '2160123456789012347', 'Tracker Pro', '1.1.0', 0, '2025-01-15 07:05:44'),
(4, '359881234567893', '2160123456789012348', 'Tracker Mini', '0.9.8', 1, '2025-01-20 17:47:29');

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `tracker_poziciok`
--

CREATE TABLE `tracker_poziciok` (
  `id` int NOT NULL,
  `device_id` int DEFAULT NULL,
  `menetlevel_id` int DEFAULT NULL,
  `idobelyeg` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `lat` float DEFAULT NULL,
  `lon` float DEFAULT NULL,
  `sebesseg_kmh` float DEFAULT NULL,
  `nyers_payload` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `utdij_kalkulaciok`
--

CREATE TABLE `utdij_kalkulaciok` (
  `id` int NOT NULL,
  `menetlevel_id` int DEFAULT NULL,
  `jarmu_id` int DEFAULT NULL,
  `ut_id` int DEFAULT NULL,
  `szolgaltato` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `osszeg_brutto` decimal(12,2) DEFAULT NULL,
  `penznem` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `kalkulalt_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `utvonalak`
--

CREATE TABLE `utvonalak` (
  `id` int NOT NULL,
  `indulasi_pont` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `erkezesi_pont` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `tavolsag_m` int DEFAULT NULL,
  `tervezet_gpx` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `letrehozva_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexek a kiírt táblákhoz
--

--
-- A tábla indexei `cegek`
--
ALTER TABLE `cegek`
  ADD PRIMARY KEY (`id`);

--
-- A tábla indexei `felhasznalok`
--
ALTER TABLE `felhasznalok`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD KEY `ceg_id` (`ceg_id`);

--
-- A tábla indexei `felhasznalo_sessionok`
--
ALTER TABLE `felhasznalo_sessionok`
  ADD PRIMARY KEY (`id`),
  ADD KEY `felhasznalo_id` (`felhasznalo_id`);

--
-- A tábla indexei `jarmuvek`
--
ALTER TABLE `jarmuvek`
  ADD PRIMARY KEY (`id`),
  ADD KEY `ceg_id` (`ceg_id`),
  ADD KEY `device_id` (`device_id`);

--
-- A tábla indexei `jogositvanyok`
--
ALTER TABLE `jogositvanyok`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sofor_id` (`sofor_id`);

--
-- A tábla indexei `menetlevelek`
--
ALTER TABLE `menetlevelek`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sofor_id` (`sofor_id`),
  ADD KEY `jarmu_id` (`jarmu_id`),
  ADD KEY `device_id` (`device_id`),
  ADD KEY `start_azon_id` (`start_azon_id`),
  ADD KEY `end_azon_id` (`end_azon_id`);

--
-- A tábla indexei `rfid_azonositasok`
--
ALTER TABLE `rfid_azonositasok`
  ADD PRIMARY KEY (`id`),
  ADD KEY `device_id` (`device_id`),
  ADD KEY `kartya_id` (`kartya_id`),
  ADD KEY `sofor_id` (`sofor_id`);

--
-- A tábla indexei `rfid_kartyak`
--
ALTER TABLE `rfid_kartyak`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uid_hex` (`uid_hex`);

--
-- A tábla indexei `rfid_kartya_hozzarendeles`
--
ALTER TABLE `rfid_kartya_hozzarendeles`
  ADD PRIMARY KEY (`id`),
  ADD KEY `kartya_id` (`kartya_id`),
  ADD KEY `sofor_id` (`sofor_id`);

--
-- A tábla indexei `soforok`
--
ALTER TABLE `soforok`
  ADD PRIMARY KEY (`id`),
  ADD KEY `ceg_id` (`ceg_id`);

--
-- A tábla indexei `trackereszkozok`
--
ALTER TABLE `trackereszkozok`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `imei` (`imei`);

--
-- A tábla indexei `tracker_poziciok`
--
ALTER TABLE `tracker_poziciok`
  ADD PRIMARY KEY (`id`),
  ADD KEY `device_id` (`device_id`),
  ADD KEY `menetlevel_id` (`menetlevel_id`);

--
-- A tábla indexei `utdij_kalkulaciok`
--
ALTER TABLE `utdij_kalkulaciok`
  ADD PRIMARY KEY (`id`),
  ADD KEY `menetlevel_id` (`menetlevel_id`),
  ADD KEY `jarmu_id` (`jarmu_id`),
  ADD KEY `ut_id` (`ut_id`);

--
-- A tábla indexei `utvonalak`
--
ALTER TABLE `utvonalak`
  ADD PRIMARY KEY (`id`);

--
-- A kiírt táblák AUTO_INCREMENT értéke
--

--
-- AUTO_INCREMENT a táblához `cegek`
--
ALTER TABLE `cegek`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT a táblához `felhasznalok`
--
ALTER TABLE `felhasznalok`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT a táblához `felhasznalo_sessionok`
--
ALTER TABLE `felhasznalo_sessionok`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT a táblához `jarmuvek`
--
ALTER TABLE `jarmuvek`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT a táblához `jogositvanyok`
--
ALTER TABLE `jogositvanyok`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT a táblához `menetlevelek`
--
ALTER TABLE `menetlevelek`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT a táblához `rfid_azonositasok`
--
ALTER TABLE `rfid_azonositasok`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT a táblához `rfid_kartyak`
--
ALTER TABLE `rfid_kartyak`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT a táblához `rfid_kartya_hozzarendeles`
--
ALTER TABLE `rfid_kartya_hozzarendeles`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT a táblához `soforok`
--
ALTER TABLE `soforok`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT a táblához `trackereszkozok`
--
ALTER TABLE `trackereszkozok`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT a táblához `tracker_poziciok`
--
ALTER TABLE `tracker_poziciok`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT a táblához `utdij_kalkulaciok`
--
ALTER TABLE `utdij_kalkulaciok`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT a táblához `utvonalak`
--
ALTER TABLE `utvonalak`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- Megkötések a kiírt táblákhoz
--

--
-- Megkötések a táblához `felhasznalok`
--
ALTER TABLE `felhasznalok`
  ADD CONSTRAINT `felhasznalok_ibfk_1` FOREIGN KEY (`ceg_id`) REFERENCES `cegek` (`id`);

--
-- Megkötések a táblához `felhasznalo_sessionok`
--
ALTER TABLE `felhasznalo_sessionok`
  ADD CONSTRAINT `felhasznalo_sessionok_ibfk_1` FOREIGN KEY (`felhasznalo_id`) REFERENCES `felhasznalok` (`id`);

--
-- Megkötések a táblához `jarmuvek`
--
ALTER TABLE `jarmuvek`
  ADD CONSTRAINT `jarmuvek_ibfk_1` FOREIGN KEY (`ceg_id`) REFERENCES `cegek` (`id`),
  ADD CONSTRAINT `jarmuvek_ibfk_2` FOREIGN KEY (`device_id`) REFERENCES `trackereszkozok` (`id`);

--
-- Megkötések a táblához `jogositvanyok`
--
ALTER TABLE `jogositvanyok`
  ADD CONSTRAINT `jogositvanyok_ibfk_1` FOREIGN KEY (`sofor_id`) REFERENCES `soforok` (`id`);

--
-- Megkötések a táblához `menetlevelek`
--
ALTER TABLE `menetlevelek`
  ADD CONSTRAINT `menetlevelek_ibfk_1` FOREIGN KEY (`sofor_id`) REFERENCES `soforok` (`id`),
  ADD CONSTRAINT `menetlevelek_ibfk_2` FOREIGN KEY (`jarmu_id`) REFERENCES `jarmuvek` (`id`),
  ADD CONSTRAINT `menetlevelek_ibfk_3` FOREIGN KEY (`device_id`) REFERENCES `trackereszkozok` (`id`),
  ADD CONSTRAINT `menetlevelek_ibfk_4` FOREIGN KEY (`start_azon_id`) REFERENCES `rfid_azonositasok` (`id`),
  ADD CONSTRAINT `menetlevelek_ibfk_5` FOREIGN KEY (`end_azon_id`) REFERENCES `rfid_azonositasok` (`id`);

--
-- Megkötések a táblához `rfid_azonositasok`
--
ALTER TABLE `rfid_azonositasok`
  ADD CONSTRAINT `rfid_azonositasok_ibfk_1` FOREIGN KEY (`device_id`) REFERENCES `trackereszkozok` (`id`),
  ADD CONSTRAINT `rfid_azonositasok_ibfk_2` FOREIGN KEY (`kartya_id`) REFERENCES `rfid_kartyak` (`id`),
  ADD CONSTRAINT `rfid_azonositasok_ibfk_3` FOREIGN KEY (`sofor_id`) REFERENCES `soforok` (`id`);

--
-- Megkötések a táblához `rfid_kartya_hozzarendeles`
--
ALTER TABLE `rfid_kartya_hozzarendeles`
  ADD CONSTRAINT `rfid_kartya_hozzarendeles_ibfk_1` FOREIGN KEY (`kartya_id`) REFERENCES `rfid_kartyak` (`id`),
  ADD CONSTRAINT `rfid_kartya_hozzarendeles_ibfk_2` FOREIGN KEY (`sofor_id`) REFERENCES `soforok` (`id`);

--
-- Megkötések a táblához `soforok`
--
ALTER TABLE `soforok`
  ADD CONSTRAINT `soforok_ibfk_1` FOREIGN KEY (`ceg_id`) REFERENCES `cegek` (`id`);

--
-- Megkötések a táblához `tracker_poziciok`
--
ALTER TABLE `tracker_poziciok`
  ADD CONSTRAINT `tracker_poziciok_ibfk_1` FOREIGN KEY (`device_id`) REFERENCES `trackereszkozok` (`id`),
  ADD CONSTRAINT `tracker_poziciok_ibfk_2` FOREIGN KEY (`menetlevel_id`) REFERENCES `menetlevelek` (`id`);

--
-- Megkötések a táblához `utdij_kalkulaciok`
--
ALTER TABLE `utdij_kalkulaciok`
  ADD CONSTRAINT `utdij_kalkulaciok_ibfk_1` FOREIGN KEY (`menetlevel_id`) REFERENCES `menetlevelek` (`id`),
  ADD CONSTRAINT `utdij_kalkulaciok_ibfk_2` FOREIGN KEY (`jarmu_id`) REFERENCES `jarmuvek` (`id`),
  ADD CONSTRAINT `utdij_kalkulaciok_ibfk_3` FOREIGN KEY (`ut_id`) REFERENCES `utvonalak` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
