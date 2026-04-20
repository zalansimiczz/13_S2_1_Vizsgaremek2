-- phpMyAdmin SQL Dump
-- version 5.2.3
-- https://www.phpmyadmin.net/
--
-- Gép: localhost
-- Létrehozás ideje: 2026. Ápr 17. 06:59
-- Kiszolgáló verziója: 8.0.44
-- PHP verzió: 8.2.29
CREATE DATABASE tollutdijadatbazis;
USE tollutdijadatbazis;
SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;



-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `cegek`
--

CREATE TABLE `cegek` (
  `id` bigint UNSIGNED NOT NULL,
  `nev` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `adoszam` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `cim` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `statusz` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- A tábla adatainak kiíratása `cegek`
--

INSERT INTO `cegek` (`id`, `nev`, `adoszam`, `cim`, `statusz`, `created_at`) VALUES
(1, 'Simicz Kft.', '12345678-1-26', '6760 Budapest, Hihihi utca 11', 'aktiv', '2026-02-04 11:23:53'),
(2, 'Border Kft.', '12345678-1-24', '6760 Budapest, Hihihi utca 11', 'aktiv', '2026-02-18 10:28:57'),
(3, 'Teszt Cég Kft.', '12345678-1-26', '6760 Tezst, Kód utca 1.', 'aktiv', '2026-02-18 12:05:37'),
(4, 'Simbovics1 Kft.', '12345678-1-26', '6760 Budapest, Hihihi utca 11', 'aktiv', '2026-02-20 07:27:52'),
(5, 'Demo Kft 2026', '12345678-1-26', '6760 Kistelek, Tisza utca 11', 'aktiv', '2026-02-20 10:46:12'),
(6, 'Nem Ceg', '12345678-1-26', '1234 Budapest, Demo utca 1.', 'aktiv', '2026-02-20 10:46:52');

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `felhasznalok`
--

CREATE TABLE `felhasznalok` (
  `id` bigint UNSIGNED NOT NULL,
  `ceg_id` bigint UNSIGNED DEFAULT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `jelszo_hash` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `teljes_nev` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `aktiv` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `role` enum('rendszer_admin','ceg_admin','operator') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'operator',
  `email_verified_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- A tábla adatainak kiíratása `felhasznalok`
--

INSERT INTO `felhasznalok` (`id`, `ceg_id`, `email`, `jelszo_hash`, `teljes_nev`, `aktiv`, `created_at`, `role`, `email_verified_at`) VALUES
(2, 2, 'zalansimicz17@gmail.com', '$2y$12$gJy2dieYtZCIVybz8jDWDezcQJ0b4eI10iJVan6W8NFExaNuXYN2y', 'Simicz Zalánka', 1, '2026-02-18 09:28:58', 'operator', '2026-02-18 09:29:52'),
(3, 3, 'simiczzalan2005@gmail.com', '$2y$12$Z8GRQIA7DnKW/jI13wK9T.WaMy8hEAPEaGBgQvdTVuOlHH37s/uqO', 'Teszt Elek', 1, '2026-02-18 11:05:37', 'operator', NULL),
(4, 4, 'zalansimicz@gmail.com', '$2y$12$sIXnGJ8jSM/yqgi1ENFPTOB3WjczaTT1GR89deQzgmPItacC2Rlpq', 'Simicz Zalán', 1, '2026-02-20 06:27:53', 'rendszer_admin', '2026-02-20 06:28:24'),
(5, 5, 'ujteszt123456@gmail.com', '$2y$12$sogepAt6pajLqZ8UgEsKH.ICkhPILC2hAfR5nnXnRzsv3cnia.Xke', 'Simicz Zalán', 1, '2026-02-20 09:46:12', 'operator', NULL),
(6, 6, 'shop.awesomeco@gmail.com', '$2y$12$tmkms.8W1gLfhft3/xTub.ahA02NuCh0Uf5l7NGYJV374G0nCAw1q', 'Kiss Ede', 1, '2026-02-20 09:46:52', 'operator', NULL),
(7, 5, 'ujteszt1234568@gmail.com', '$2y$12$HkSlrW2r9B4DF6iAJBJI6eBq80VG6Mja3Vf.TZ1Z6xTlS/m2EBtHq', 'Simicz Zalán', 1, '2026-02-20 09:47:55', 'operator', NULL),
(8, 4, 'shop.awesomeco+teszt@gmail.com', '$2y$12$S0YT9rvXp9g8RFT5ZYA/4OhyuLKebx46duNHJPMFB2rabKfzoaxIe', 'Teszt Alkalmazott', 1, '2026-02-24 07:16:01', 'operator', NULL),
(9, 4, 'tesztalkalmazott@gmail.com', '$2y$12$W3xXI75A.dYfyFS6bWGthuwUoycXOI5AvuUzgAQ58.rdEXxx.cbAC', 'Teszt Alkalmazott', 1, '2026-02-24 07:18:49', 'operator', NULL),
(10, 4, 'tesztalkalmazott1@gmail.com', '$2y$12$lrooEVVk4DHXeMfEcT5Qaet1ddrF7PfDQApUd4jcEl.tMfgcBUGdW', 'Teszt Alkalmazott', 1, '2026-02-24 07:20:05', 'operator', NULL),
(11, 4, 'tesztalkalmazott2@gmail.com', '$2y$12$kqD1lRlLZdOBAqn4GpfqcObzMJ1zhxA/u8.GTcCKZLJ/XiCP.e7MS', 'Teszt Alkalmazott', 1, '2026-02-24 07:21:01', 'operator', NULL),
(12, 4, 'zalansimicz11@gmail.com', '$2y$12$Q1xX1GwLyXfjCnZqSU7RXOtr3TWYR0hR1OCrKFmOZr1l/m2mstlNG', 'Zalán Zoltán Simicz', 0, '2026-02-24 07:27:19', 'operator', NULL),
(13, 4, 'zalansimicz111@gmail.com', '$2y$12$eAlqwQl1e5NgukfeaniaL.uCYXJaN64AHR0wcip5ufcXUyv2UC.EO', 'Zalán Zoltán Simicz', 0, '2026-02-24 07:39:53', 'operator', NULL),
(15, 4, 'bela@gmail.com', '$2y$12$/65zoQ2Ic40IpejlFVkcC.mIQ4XsA88RvwH/M9Qi.pY1C.FHEhhFK', 'Kiss Bélus', 1, '2026-03-25 07:24:36', 'operator', NULL);

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `jarmuvek`
--

CREATE TABLE `jarmuvek` (
  `id` bigint UNSIGNED NOT NULL,
  `ceg_id` bigint UNSIGNED NOT NULL,
  `kategoria` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `marka` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tipus` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tengelyszam` int NOT NULL,
  `rendszam` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `vin` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `euro_besorolas` varchar(10) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ossztomeg_kg` int DEFAULT NULL,
  `potkocsi_kepes` tinyint(1) NOT NULL DEFAULT '0',
  `device_id` bigint UNSIGNED DEFAULT NULL,
  `aktiv` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- A tábla adatainak kiíratása `jarmuvek`
--

INSERT INTO `jarmuvek` (`id`, `ceg_id`, `kategoria`, `marka`, `tipus`, `tengelyszam`, `rendszam`, `vin`, `euro_besorolas`, `ossztomeg_kg`, `potkocsi_kepes`, `device_id`, `aktiv`, `created_at`) VALUES
(1, 1, 'Személygépkocsi', 'Mercedes', 'Maybach S600', 2, 'SIM-100', 'WFO382473924UZUZH', '6', 2495, 0, NULL, 1, '2026-02-04 12:24:07'),
(2, 4, 'Személygépkocsi', 'dsadsadsa', 'dsasdaasd', 2, 'Sim100', 'dsadsaadssaasdsaasd', '6', 2312, 1, NULL, 1, '2026-03-25 06:55:18');

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `migrations`
--

CREATE TABLE `migrations` (
  `id` int UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- A tábla adatainak kiíratása `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2026_02_03_101703_create_cegek_table', 1),
(2, '2026_02_03_101704_create_felhasznalok_table', 1),
(3, '2026_02_03_102931_create_soforok_table', 1),
(4, '2026_02_04_104452_create_trackereszkozok_table', 1),
(5, '2026_02_04_104711_create_jarmuvek_table', 1);

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `soforok`
--

CREATE TABLE `soforok` (
  `id` bigint UNSIGNED NOT NULL,
  `ceg_id` bigint UNSIGNED DEFAULT NULL,
  `szemelyi_azonosito` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `nev` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `szuletesi_datum` date DEFAULT NULL,
  `telefonszam` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `cim` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `adoszam` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `aktiv` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- A tábla adatainak kiíratása `soforok`
--

INSERT INTO `soforok` (`id`, `ceg_id`, `szemelyi_azonosito`, `nev`, `szuletesi_datum`, `telefonszam`, `cim`, `adoszam`, `aktiv`, `created_at`) VALUES
(1, 4, '224195ME', 'Jani Nem Kiraly', '2005-08-17', '+36300803236', '6760 Budapest, Hihihi utca 11', '12345678-2-26', 1, '2026-02-24 09:04:07'),
(6, 4, '224195ME', 'Simicz Zalán', '2005-08-17', '+36300803236', '6760 Kistelek, Tisza utca 11.', '21312321-1-26', 1, '2026-03-25 06:54:45'),
(7, 4, '4324234', 'Jani', '2005-02-03', '42234324342', 'dsffdsfdsdsffsd', '432432324', 1, '2026-03-25 08:24:59'),
(8, 4, '224195ME', 'Teszt Elek1', '2000-01-01', '+36300803236', '6760 Kistelek, Tisza utca 11.', '12345678-1-26', 1, '2026-03-31 08:00:16');

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `trackereszkozok`
--

CREATE TABLE `trackereszkozok` (
  `id` bigint UNSIGNED NOT NULL,
  `imei` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `sim_iccid` varchar(25) COLLATE utf8mb4_unicode_ci NOT NULL,
  `modell` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `firmware_verzio` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `aktiv` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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
  ADD UNIQUE KEY `felhasznalok_email_unique` (`email`),
  ADD KEY `felhasznalok_ceg_id_foreign` (`ceg_id`);

--
-- A tábla indexei `jarmuvek`
--
ALTER TABLE `jarmuvek`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `jarmuvek_rendszam_unique` (`rendszam`),
  ADD KEY `jarmuvek_ceg_id_foreign` (`ceg_id`),
  ADD KEY `jarmuvek_device_id_foreign` (`device_id`);

--
-- A tábla indexei `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- A tábla indexei `soforok`
--
ALTER TABLE `soforok`
  ADD PRIMARY KEY (`id`),
  ADD KEY `soforok_ceg_id_foreign` (`ceg_id`);

--
-- A tábla indexei `trackereszkozok`
--
ALTER TABLE `trackereszkozok`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `trackereszkozok_imei_unique` (`imei`);

--
-- A kiírt táblák AUTO_INCREMENT értéke
--

--
-- AUTO_INCREMENT a táblához `cegek`
--
ALTER TABLE `cegek`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT a táblához `felhasznalok`
--
ALTER TABLE `felhasznalok`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT a táblához `jarmuvek`
--
ALTER TABLE `jarmuvek`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT a táblához `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT a táblához `soforok`
--
ALTER TABLE `soforok`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT a táblához `trackereszkozok`
--
ALTER TABLE `trackereszkozok`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- Megkötések a kiírt táblákhoz
--

--
-- Megkötések a táblához `felhasznalok`
--
ALTER TABLE `felhasznalok`
  ADD CONSTRAINT `felhasznalok_ceg_id_foreign` FOREIGN KEY (`ceg_id`) REFERENCES `cegek` (`id`) ON DELETE SET NULL;

--
-- Megkötések a táblához `jarmuvek`
--
ALTER TABLE `jarmuvek`
  ADD CONSTRAINT `jarmuvek_ceg_id_foreign` FOREIGN KEY (`ceg_id`) REFERENCES `cegek` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `jarmuvek_device_id_foreign` FOREIGN KEY (`device_id`) REFERENCES `trackereszkozok` (`id`) ON DELETE SET NULL;

--
-- Megkötések a táblához `soforok`
--
ALTER TABLE `soforok`
  ADD CONSTRAINT `soforok_ceg_id_foreign` FOREIGN KEY (`ceg_id`) REFERENCES `cegek` (`id`) ON DELETE SET NULL;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
