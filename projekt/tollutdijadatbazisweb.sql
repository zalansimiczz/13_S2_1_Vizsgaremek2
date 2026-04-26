-- phpMyAdmin SQL Dump
-- version 5.2.3
-- https://www.phpmyadmin.net/
--
-- Gép: localhost
-- Létrehozás ideje: 2026. Ápr 26. 20:37
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

--
-- Indexek a kiírt táblákhoz
--

--
-- A tábla indexei `felhasznalok`
--
ALTER TABLE `felhasznalok`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `felhasznalok_email_unique` (`email`),
  ADD KEY `felhasznalok_ceg_id_foreign` (`ceg_id`);

--
-- A kiírt táblák AUTO_INCREMENT értéke
--

--
-- AUTO_INCREMENT a táblához `felhasznalok`
--
ALTER TABLE `felhasznalok`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- Megkötések a kiírt táblákhoz
--

--
-- Megkötések a táblához `felhasznalok`
--
ALTER TABLE `felhasznalok`
  ADD CONSTRAINT `felhasznalok_ceg_id_foreign` FOREIGN KEY (`ceg_id`) REFERENCES `cegek` (`id`) ON DELETE SET NULL;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
