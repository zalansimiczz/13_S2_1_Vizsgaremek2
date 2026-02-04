-- phpMyAdmin SQL Dump
-- version 5.2.3
-- https://www.phpmyadmin.net/
--
-- Gép: localhost
-- Létrehozás ideje: 2026. Jan 20. 22:32
-- Kiszolgáló verziója: 8.0.44
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
(6, 1, 'placeholder1@demo.hu', '$2y$10$xesnsmm9fLlElCpBODbnSenLzZVuVEOYm7SqBuerLeb/Ii.NDen.S', 'Demo G', 1, '2025-11-18 09:16:44', 'operator'),
(7, 3, 'zalansimicz@gmail.com', '$2y$12$cNtFfiVyKr2xoCo6NKmLMe5QSofYhCWmXyJeXmUEFV7JNsB8uOtBu', 'Kunu Márió', 1, '2025-12-11 18:47:12', 'operator'),
(8, 5, 'josi@gmail.com', '$2y$12$M1YUJCtg4cmlZqe9fkGoqei.qTWKuIe558EhtOH3Hv.au1w7PO3Oi', 'Josikaaa Boss', 1, '2025-12-11 19:00:20', 'operator'),
(9, 1, 'josi1@gmail.com', '$2y$12$Qo2AtQPvaFMb2qhpsM3nuugSFj.0ohEN0Oaq6YTFiwmvlxk/GRdrC', 'Josikaaa', 1, '2025-12-11 19:04:13', 'operator'),
(10, 6, 'shop.awesomeco@gmail.com', '$2y$12$FGlYOZJVTtCQRpXygl/trOXyZfaUjeEoN.phATdxKgbzd1jHaTYra', 'Josikaaa Boss', 1, '2026-01-20 20:49:22', 'operator'),
(11, 6, 'shop.awesomeco1@gmail.com', '$2y$12$6UfJA2yjcQnEDR.Q4dF5mesCMh8Y7WGkI2754Oh7MuRsmsf.vAcDm', 'elsss alllss', 1, '2026-01-20 20:55:38', 'operator'),
(12, 6, 'zalansimicz1@gmail.com', '$2y$12$hXg4CDaDdJt2go9d8hvLrOomzl0iEDFhrc6iBBzzKPAFTqdqrjRRq', 'Zalán Zoltán Simicz', 1, '2026-01-20 21:26:52', 'operator'),
(13, 6, 'zalansimicz2@gmail.com', '$2y$12$fWuTTo8n3t3xZhKV6bJ/4./HZBr.HnCC7/pZ69uiO1FBMaU4wdZOK', 'Zalán Zoltán Simicz', 0, '2026-01-20 21:29:06', 'operator');

--
-- Indexek a kiírt táblákhoz
--

--
-- A tábla indexei `felhasznalok`
--
ALTER TABLE `felhasznalok`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD KEY `ceg_id` (`ceg_id`);

--
-- A kiírt táblák AUTO_INCREMENT értéke
--

--
-- AUTO_INCREMENT a táblához `felhasznalok`
--
ALTER TABLE `felhasznalok`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- Megkötések a kiírt táblákhoz
--

--
-- Megkötések a táblához `felhasznalok`
--
ALTER TABLE `felhasznalok`
  ADD CONSTRAINT `felhasznalok_ibfk_1` FOREIGN KEY (`ceg_id`) REFERENCES `cegek` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
