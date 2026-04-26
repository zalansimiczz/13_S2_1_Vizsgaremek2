-- phpMyAdmin SQL Dump
-- version 5.2.3
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Apr 26, 2026 at 08:54 PM
-- Server version: 8.0.45
-- PHP Version: 8.2.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `tollutdijadatbazis`
--

-- --------------------------------------------------------

--
-- Table structure for table `cegek`
--

CREATE TABLE `cegek` (
  `id` bigint UNSIGNED NOT NULL,
  `nev` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `adoszam` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `cim` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `statusz` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `cegek`
--

INSERT INTO `cegek` (`id`, `nev`, `adoszam`, `cim`, `statusz`, `created_at`) VALUES
(1, 'Simicz Kft.', '12345678-1-26', '6760 Budapest, Hihihi utca 11', 'aktiv', '2026-02-04 11:23:53'),
(2, 'Border Kft.', '12345678-1-24', '6760 Budapest, Hihihi utca 11', 'aktiv', '2026-02-18 10:28:57'),
(3, 'Teszt Ceg Kft.', '12345678-1-26', '6760 Teszt, Kod utca 1.', 'aktiv', '2026-02-18 12:05:37'),
(4, 'Simbovics1 Kft.', '12345678-1-26', '6760 Budapest, Hihihi utca 11', 'aktiv', '2026-02-20 07:27:52'),
(5, 'Demo Kft 2026', '12345678-1-26', '6760 Kistelek, Tisza utca 11', 'aktiv', '2026-02-20 10:46:12'),
(6, 'Nem Ceg', '12345678-1-26', '1234 Budapest, Demo utca 1.', 'aktiv', '2026-02-20 10:46:52'),
(7, 'Alfa Logistics Kft.', '23456789-2-13', '1117 Budapest, Fehervari ut 12.', 'aktiv', '2026-03-01 08:15:00'),
(8, 'Beta Transport Zrt.', '34567890-2-42', '9021 Gyor, Szechenyi ter 5.', 'aktiv', '2026-03-02 09:20:00'),
(9, 'Gamma Freight Kft.', '45678901-2-08', '6720 Szeged, Kossuth Lajos sgrt. 8.', 'aktiv', '2026-03-03 10:25:00'),
(10, 'Delta Fleet Kft.', '56789012-2-19', '3525 Miskolc, Arany Janos ter 3.', 'inaktiv', '2026-03-04 11:30:00');

-- --------------------------------------------------------

--
-- Table structure for table `felhasznalok`
--

CREATE TABLE `felhasznalok` (
  `id` bigint UNSIGNED NOT NULL,
  `ceg_id` bigint UNSIGNED DEFAULT NULL,
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `jelszo_hash` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `teljes_nev` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `aktiv` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `role` enum('rendszer_admin','ceg_admin','operator') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'operator',
  `email_verified_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `felhasznalok`
--

INSERT INTO `felhasznalok` (`id`, `ceg_id`, `email`, `jelszo_hash`, `teljes_nev`, `aktiv`, `created_at`, `role`, `email_verified_at`) VALUES
(2, 2, 'zalansimicz17@gmail.com', '$2y$12$gJy2dieYtZCIVybz8jDWDezcQJ0b4eI10iJVan6W8NFExaNuXYN2y', 'Simicz Zalanka', 1, '2026-02-18 09:28:58', 'operator', '2026-02-18 09:29:52'),
(3, 3, 'simiczzalan2005@gmail.com', '$2y$12$Z8GRQIA7DnKW/jI13wK9T.WaMy8hEAPEaGBgQvdTVuOlHH37s/uqO', 'Teszt Elek', 1, '2026-02-18 11:05:37', 'operator', NULL),
(4, 4, 'zalansimicz@gmail.com', '$2y$12$sIXnGJ8jSM/yqgi1ENFPTOB3WjczaTT1GR89deQzgmPItacC2Rlpq', 'Simicz Zalan', 1, '2026-02-20 06:27:53', 'rendszer_admin', '2026-02-20 06:28:24'),
(5, 5, 'ujteszt123456@gmail.com', '$2y$12$sogepAt6pajLqZ8UgEsKH.ICkhPILC2hAfR5nnXnRzsv3cnia.Xke', 'Simicz Zalan', 1, '2026-02-20 09:46:12', 'operator', NULL),
(6, 6, 'shop.awesomeco@gmail.com', '$2y$12$tmkms.8W1gLfhft3/xTub.ahA02NuCh0Uf5l7NGYJV374G0nCAw1q', 'Kiss Ede', 1, '2026-02-20 09:46:52', 'operator', NULL),
(7, 5, 'ujteszt1234568@gmail.com', '$2y$12$HkSlrW2r9B4DF6iAJBJI6eBq80VG6Mja3Vf.TZ1Z6xTlS/m2EBtHq', 'Simicz Zalan', 1, '2026-02-20 09:47:55', 'operator', NULL),
(8, 4, 'shop.awesomeco+teszt@gmail.com', '$2y$12$S0YT9rvXp9g8RFT5ZYA/4OhyuLKebx46duNHJPMFB2rabKfzoaxIe', 'Teszt Alkalmazott', 1, '2026-02-24 07:16:01', 'operator', NULL),
(9, 4, 'tesztalkalmazott@gmail.com', '$2y$12$W3xXI75A.dYfyFS6bWGthuwUoycXOI5AvuUzgAQ58.rdEXxx.cbAC', 'Teszt Alkalmazott', 1, '2026-02-24 07:18:49', 'operator', NULL),
(10, 4, 'tesztalkalmazott1@gmail.com', '$2y$12$lrooEVVk4DHXeMfEcT5Qaet1ddrF7PfDQApUd4jcEl.tMfgcBUGdW', 'Teszt Alkalmazott', 1, '2026-02-24 07:20:05', 'operator', NULL),
(11, 4, 'tesztalkalmazott2@gmail.com', '$2y$12$kqD1lRlLZdOBAqn4GpfqcObzMJ1zhxA/u8.GTcCKZLJ/XiCP.e7MS', 'Teszt Alkalmazott', 1, '2026-02-24 07:21:01', 'operator', NULL),
(12, 4, 'zalansimicz11@gmail.com', '$2y$12$Q1xX1GwLyXfjCnZqSU7RXOtr3TWYR0hR1OCrKFmOZr1l/m2mstlNG', 'Zalan Zoltan Simicz', 0, '2026-02-24 07:27:19', 'operator', NULL),
(13, 4, 'zalansimicz111@gmail.com', '$2y$12$eAlqwQl1e5NgukfeaniaL.uCYXJaN64AHR0wcip5ufcXUyv2UC.EO', 'Zalan Zoltan Simicz', 0, '2026-02-24 07:39:53', 'operator', NULL),
(15, 4, 'bela@gmail.com', '$2a$12$N0Am.tWe3VukUGLv25n/fO2edlEjOXx6AFfxP11zuTXV8c3sEq8nm', 'Kiss Belus', 1, '2026-03-25 07:24:36', 'rendszer_admin', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `felhasznalo_sessionok`
--

CREATE TABLE `felhasznalo_sessionok` (
  `id` int NOT NULL,
  `felhasznalo_id` int NOT NULL,
  `token` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `created_at` datetime NOT NULL,
  `lejart_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `felhasznalo_sessionok`
--

INSERT INTO `felhasznalo_sessionok` (`id`, `felhasznalo_id`, `token`, `created_at`, `lejart_at`) VALUES
(1, 15, 'a981da65cb8b4a9885a00d4c5a79fd9f', '2026-04-26 20:06:14', '2026-04-26 20:36:14'),
(2, 15, 'fb2388e051f441c8851bfa09b9f8d366', '2026-04-26 20:06:21', '2026-04-26 20:36:21'),
(3, 4, 'c0b31f36391a4755bcaf3d940d6bc111', '2026-04-26 18:00:00', '2026-04-26 18:30:00'),
(4, 2, '731aa3c1cfea4e55a1f507cc3fd81022', '2026-04-26 18:05:00', '2026-04-26 18:35:00'),
(5, 3, '3c54422bb1484d6f9c01d1f93bd99033', '2026-04-26 18:10:00', '2026-04-26 18:40:00'),
(6, 5, 'd235124fdbe9470db8331fef8364c044', '2026-04-26 18:15:00', '2026-04-26 18:45:00'),
(7, 6, 'f3dbef1f7160409183b04e3fb5d4f055', '2026-04-26 18:20:00', '2026-04-26 18:50:00'),
(8, 7, 'e10f77acb61a42c8a4c8d6f1b7ecb066', '2026-04-26 18:25:00', '2026-04-26 18:55:00'),
(9, 8, 'a8d42aef41554e89b62f5f6ef9f5d077', '2026-04-26 18:30:00', '2026-04-26 19:00:00'),
(10, 9, '18a2d70d85754caf95ca0b6f79c1a088', '2026-04-26 18:35:00', '2026-04-26 19:05:00'),
(11, 15, '83e1d07e19dc407cb796b6c328129f10', '2026-04-26 20:49:46', '2026-04-26 21:19:46');

-- --------------------------------------------------------

--
-- Table structure for table `jarmuvek`
--

CREATE TABLE `jarmuvek` (
  `id` bigint UNSIGNED NOT NULL,
  `ceg_id` bigint UNSIGNED NOT NULL,
  `kategoria` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `marka` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `tipus` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `tengelyszam` int NOT NULL,
  `rendszam` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `vin` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `euro_besorolas` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ossztomeg_kg` int DEFAULT NULL,
  `potkocsi_kepes` tinyint(1) NOT NULL DEFAULT '0',
  `device_id` bigint UNSIGNED DEFAULT NULL,
  `aktiv` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `jarmuvek`
--

INSERT INTO `jarmuvek` (`id`, `ceg_id`, `kategoria`, `marka`, `tipus`, `tengelyszam`, `rendszam`, `vin`, `euro_besorolas`, `ossztomeg_kg`, `potkocsi_kepes`, `device_id`, `aktiv`, `created_at`) VALUES
(1, 1, 'Szemelygepkocsi', 'Mercedes', 'Maybach S600', 2, 'SIM-100', 'WFO382473924UZUZH', '6', 2495, 0, NULL, 1, '2026-02-04 12:24:07'),
(2, 4, 'Szemelygepkocsi', 'dsadsadsa', 'dsasdaasd', 2, 'Sim100', 'dsadsaadssaasdsaasd', '6', 2312, 1, NULL, 1, '2026-03-25 06:55:18'),
(3, 5, 'Kisteherauto', 'Ford', 'Transit', 2, 'ABC-101', 'WF0XXXTTGXGA12345', '6', 3500, 1, 1, 1, '2026-03-10 07:10:00'),
(4, 6, 'Nyergesvontato', 'Volvo', 'FH16', 5, 'DEF-202', 'YV2RT40A7LB987654', '6', 18000, 1, 2, 1, '2026-03-10 07:20:00'),
(5, 7, 'Kamion', 'MAN', 'TGX', 5, 'GHI-303', 'WMA06XZZ8KP123456', '5', 19000, 1, 3, 1, '2026-03-10 07:30:00'),
(6, 8, 'Furgon', 'Renault', 'Master', 2, 'JKL-404', 'VF1MA000765432101', '6', 3300, 0, 4, 1, '2026-03-10 07:40:00'),
(7, 9, 'Kisteherauto', 'Iveco', 'Daily', 2, 'MNO-505', 'ZCFC235B405678901', '6', 3500, 1, 5, 1, '2026-03-10 07:50:00'),
(8, 10, 'Nyergesvontato', 'Scania', 'R450', 5, 'PQR-606', 'YS2R4X20005432109', '6', 18500, 1, 6, 0, '2026-03-10 08:00:00'),
(9, 4, 'Szemelygepkocsi', 'Skoda', 'Octavia', 2, 'STU-707', 'TMBJG7NE8L0123456', '6', 1450, 0, 7, 1, '2026-03-10 08:10:00'),
(10, 5, 'Furgon', 'Volkswagen', 'Crafter', 2, 'VWX-808', 'WV1ZZZSYZL9001122', '6', 3200, 1, 8, 1, '2026-03-10 08:20:00');

-- --------------------------------------------------------

--
-- Table structure for table `jogositvanyok`
--

CREATE TABLE `jogositvanyok` (
  `id` int UNSIGNED NOT NULL,
  `sofor_id` bigint UNSIGNED NOT NULL,
  `kategoria` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `erv_tol` date NOT NULL,
  `erv_ig` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `jogositvanyok`
--

INSERT INTO `jogositvanyok` (`id`, `sofor_id`, `kategoria`, `erv_tol`, `erv_ig`) VALUES
(1, 1, 'B', '2024-01-01', '2034-01-01'),
(2, 6, 'C', '2023-05-15', '2028-05-15'),
(3, 7, 'C', '2022-09-01', '2027-09-01'),
(4, 8, 'B', '2021-03-20', '2031-03-20'),
(5, 9, 'B', '2020-07-11', '2030-07-11'),
(6, 10, 'C', '2024-02-01', '2029-02-01'),
(7, 11, 'C', '2023-11-10', '2028-11-10'),
(8, 12, 'B', '2022-04-18', '2032-04-18'),
(9, 13, 'D', '2021-06-06', '2026-06-06'),
(11, 1, 'C', '2026-04-26', '2026-04-26'),
(12, 14, 'C1', '2026-04-26', '2026-04-26'),
(13, 11, 'B', '2026-04-26', '2026-04-26');

-- --------------------------------------------------------

--
-- Table structure for table `menetlevelek`
--

CREATE TABLE `menetlevelek` (
  `id` int UNSIGNED NOT NULL,
  `sofor_id` bigint UNSIGNED NOT NULL,
  `jarmu_id` bigint UNSIGNED NOT NULL,
  `device_id` bigint UNSIGNED NOT NULL,
  `start_idopont` timestamp NOT NULL,
  `end_idopont` timestamp NULL DEFAULT NULL,
  `start_azon_id` int UNSIGNED DEFAULT NULL,
  `end_azon_id` int UNSIGNED DEFAULT NULL,
  `start_location` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `end_location` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `menetlevelek`
--

INSERT INTO `menetlevelek` (`id`, `sofor_id`, `jarmu_id`, `device_id`, `start_idopont`, `end_idopont`, `start_azon_id`, `end_azon_id`, `start_location`, `end_location`) VALUES
(1, 1, 1, 1, '2026-04-10 06:00:00', '2026-04-10 09:15:00', 1, NULL, 'Budapest', 'Kecskemet'),
(2, 6, 2, 2, '2026-04-10 06:20:00', '2026-04-10 10:30:00', 2, NULL, 'Szeged', 'Budapest'),
(3, 7, 3, 3, '2026-04-10 06:35:00', '2026-04-10 11:05:00', 3, NULL, 'Gyor', 'Tatabanya'),
(4, 8, 4, 4, '2026-04-10 06:50:00', '2026-04-10 12:10:00', 4, NULL, 'Miskolc', 'Debrecen'),
(5, 9, 5, 5, '2026-04-10 07:05:00', NULL, 5, NULL, 'Pecs', NULL),
(6, 10, 6, 6, '2026-04-10 07:20:00', '2026-04-10 11:45:00', 6, NULL, 'Kecskemet', 'Szeged'),
(7, 11, 7, 7, '2026-04-10 07:35:00', '2026-04-10 12:40:00', 7, NULL, 'Nyiregyhaza', 'Miskolc'),
(8, 12, 8, 8, '2026-04-10 07:50:00', '2026-04-10 13:25:00', 8, NULL, 'Gyor', 'Sopron'),
(9, 13, 9, 9, '2026-04-10 08:05:00', NULL, 9, NULL, 'Budapest', NULL),
(10, 14, 10, 10, '2026-04-10 08:20:00', '2026-04-10 14:00:00', 10, NULL, 'Szeged', 'Baja');

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int UNSIGNED NOT NULL,
  `migration` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2026_02_03_101703_create_cegek_table', 1),
(2, '2026_02_03_101704_create_felhasznalok_table', 1),
(3, '2026_02_03_102931_create_soforok_table', 1),
(4, '2026_02_04_104452_create_trackereszkozok_table', 1),
(5, '2026_02_04_104711_create_jarmuvek_table', 1),
(6, '2026_02_05_083000_add_role_to_felhasznalok_table', 2),
(7, '2026_02_05_084500_add_email_verified_at_to_felhasznalok_table', 2),
(8, '2026_02_06_091500_add_statusz_to_cegek_table', 2),
(9, '2026_02_07_101000_create_felhasznalo_sessionok_table', 3),
(10, '2026_02_08_110000_add_device_id_to_jarmuvek_table', 3);

-- --------------------------------------------------------

--
-- Table structure for table `rfid_azonositasok`
--

CREATE TABLE `rfid_azonositasok` (
  `id` int UNSIGNED NOT NULL,
  `device_id` bigint UNSIGNED NOT NULL,
  `kartya_id` int UNSIGNED NOT NULL,
  `sofor_id` bigint UNSIGNED DEFAULT NULL,
  `eredmeny` tinyint(1) NOT NULL,
  `hibakod` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `idobelyeg` timestamp NOT NULL,
  `megjegyzes` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `rfid_azonositasok`
--

INSERT INTO `rfid_azonositasok` (`id`, `device_id`, `kartya_id`, `sofor_id`, `eredmeny`, `hibakod`, `idobelyeg`, `megjegyzes`) VALUES
(1, 1, 1, 1, 1, NULL, '2026-04-10 05:55:00', 'Indulas elotti sikeres azonositas'),
(2, 2, 2, 6, 1, NULL, '2026-04-10 06:10:00', 'Sofor beleptetve'),
(3, 3, 3, 7, 1, NULL, '2026-04-10 06:25:00', 'Sikeres olvasas'),
(4, 4, 4, 8, 1, NULL, '2026-04-10 06:40:00', 'Jarmu inditas engedelyezve'),
(5, 5, 5, 9, 0, 'nem_engedelyezett', '2026-04-10 06:55:00', 'Lejart kartya hozzarendeles'),
(6, 6, 6, 10, 1, NULL, '2026-04-10 07:10:00', 'Sikeres azonositas'),
(7, 7, 7, 11, 1, NULL, '2026-04-10 07:25:00', 'Sikeres olvasas'),
(8, 8, 8, 12, 1, NULL, '2026-04-10 07:40:00', 'Sikeres olvasas'),
(9, 9, 9, 13, 0, 'lejart', '2026-04-10 07:55:00', 'A kartya ervenyessege lejart'),
(10, 10, 10, 14, 1, NULL, '2026-04-10 08:10:00', 'Sikeres indulasi azonositas');

-- --------------------------------------------------------

--
-- Table structure for table `rfid_kartyak`
--

CREATE TABLE `rfid_kartyak` (
  `id` int UNSIGNED NOT NULL,
  `uid_hex` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `tipus` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `rfid_kartyak`
--

INSERT INTO `rfid_kartyak` (`id`, `uid_hex`, `tipus`) VALUES
(1, '04A1B2C3D4E501', 'MIFARE'),
(2, '04A1B2C3D4E502', 'MIFARE'),
(3, '04A1B2C3D4E503', 'MIFARE'),
(4, '04A1B2C3D4E504', 'eID'),
(5, '04A1B2C3D4E505', 'MIFARE'),
(6, '04A1B2C3D4E506', 'MIFARE'),
(7, '04A1B2C3D4E507', 'eID'),
(8, '04A1B2C3D4E508', 'MIFARE'),
(9, '04A1B2C3D4E509', 'MIFARE'),
(10, '04A1B2C3D4E510', 'eID');

-- --------------------------------------------------------

--
-- Table structure for table `rfid_kartya_hozzarendeles`
--

CREATE TABLE `rfid_kartya_hozzarendeles` (
  `id` int UNSIGNED NOT NULL,
  `kartya_id` int UNSIGNED NOT NULL,
  `sofor_id` bigint UNSIGNED NOT NULL,
  `erv_tol` timestamp NOT NULL,
  `erv_ig` timestamp NOT NULL,
  `aktiv` tinyint(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `rfid_kartya_hozzarendeles`
--

INSERT INTO `rfid_kartya_hozzarendeles` (`id`, `kartya_id`, `sofor_id`, `erv_tol`, `erv_ig`, `aktiv`) VALUES
(1, 1, 1, '2026-01-01 00:00:00', '2027-01-01 00:00:00', 1),
(2, 2, 6, '2026-01-01 00:00:00', '2027-01-01 00:00:00', 1),
(3, 3, 7, '2026-01-01 00:00:00', '2027-01-01 00:00:00', 1),
(4, 4, 8, '2026-01-01 00:00:00', '2027-01-01 00:00:00', 1),
(5, 5, 9, '2026-01-01 00:00:00', '2027-01-01 00:00:00', 1),
(6, 6, 10, '2026-01-01 00:00:00', '2027-01-01 00:00:00', 1),
(7, 7, 11, '2026-01-01 00:00:00', '2027-01-01 00:00:00', 1),
(8, 8, 12, '2026-01-01 00:00:00', '2027-01-01 00:00:00', 1),
(9, 9, 13, '2026-01-01 00:00:00', '2026-06-30 00:00:00', 0),
(10, 10, 14, '2026-01-01 00:00:00', '2027-01-01 00:00:00', 1);

-- --------------------------------------------------------

--
-- Table structure for table `soforok`
--

CREATE TABLE `soforok` (
  `id` bigint UNSIGNED NOT NULL,
  `ceg_id` bigint UNSIGNED DEFAULT NULL,
  `szemelyi_azonosito` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `nev` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `szuletesi_datum` date DEFAULT NULL,
  `telefonszam` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `cim` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `adoszam` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `aktiv` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `soforok`
--

INSERT INTO `soforok` (`id`, `ceg_id`, `szemelyi_azonosito`, `nev`, `szuletesi_datum`, `telefonszam`, `cim`, `adoszam`, `aktiv`, `created_at`) VALUES
(1, 4, '224195ME', 'Jani Nem Kiraly', '2005-08-17', '+36300803236', '6760 Budapest, Hihihi utca 11', '12345678-2-26', 1, '2026-02-24 09:04:07'),
(6, 4, '224195ME', 'Simicz Zalan', '2005-08-17', '+36300803236', '6760 Kistelek, Tisza utca 11.', '21312321-1-26', 1, '2026-03-25 06:54:45'),
(7, 4, '4324234', 'Jani', '2005-02-03', '42234324342', 'dsffdsfdsdsffsd', '432432324', 1, '2026-03-25 08:24:59'),
(8, 4, '224195ME', 'Teszt Elek1', '2000-01-01', '+36300803236', '6760 Kistelek, Tisza utca 11.', '12345678-1-26', 1, '2026-03-31 08:00:16'),
(9, 5, 'AA123456', 'Kovacs Peter', '1989-04-12', '+36301112233', '1117 Budapest, Irinyi Jozsef utca 4.', '11111111-1-44', 1, '2026-04-01 08:10:00'),
(10, 6, 'BB234567', 'Nagy Anna', '1992-07-23', '+36302223344', '9021 Gyor, Arpad ut 9.', '22222222-1-08', 1, '2026-04-01 08:20:00'),
(11, 7, 'CC345678', 'Toth Bela', '1985-11-05', '+36303334455', '6724 Szeged, Retek utca 2.', '33333333-1-06', 1, '2026-04-01 08:30:00'),
(12, 8, 'DD456789', 'Farkas Eva', '1990-01-15', '+36304445566', '3526 Miskolc, Dayka Gabor utca 7.', '44444444-1-05', 1, '2026-04-01 08:40:00'),
(13, 9, 'EE567890', 'Varga Istvan', '1988-09-30', '+36305556677', '6000 Kecskemet, Katona Jozsef ter 1.', '55555555-1-03', 0, '2026-04-01 08:50:00'),
(14, 10, 'FF678901', 'Szabo Marta', '1995-06-18', '+36306667788', '4400 Nyiregyhaza, Pazonyi ut 15.', '66666666-1-15', 1, '2026-04-01 09:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `trackereszkozok`
--

CREATE TABLE `trackereszkozok` (
  `id` bigint UNSIGNED NOT NULL,
  `imei` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `sim_iccid` varchar(25) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `modell` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `firmware_verzio` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `aktiv` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `trackereszkozok`
--

INSERT INTO `trackereszkozok` (`id`, `imei`, `sim_iccid`, `modell`, `firmware_verzio`, `aktiv`, `created_at`) VALUES
(1, '351756051523001', '8988211000000000001', 'Teltonika FMB920', '03.27.07.Rev.120', 1, '2026-03-09 06:10:00'),
(2, '351756051523002', '8988211000000000002', 'Teltonika FMC130', '04.00.12.Rev.08', 1, '2026-03-09 06:20:00'),
(3, '351756051523003', '8988211000000000003', 'Queclink GV57', 'A11V02', 1, '2026-03-09 06:30:00'),
(4, '351756051523004', '8988211000000000004', 'Ruptela Eco5', '01.14.05', 1, '2026-03-09 06:40:00'),
(5, '351756051523005', '8988211000000000005', 'Teltonika FMM003', '03.29.03.Rev.11', 1, '2026-03-09 06:50:00'),
(6, '351756051523006', '8988211000000000006', 'Queclink GL300', 'M05V12', 0, '2026-03-09 07:00:00'),
(7, '351756051523007', '8988211000000000007', 'Teltonika FMC003', '03.28.01.Rev.05', 1, '2026-03-09 07:10:00'),
(8, '351756051523008', '8988211000000000008', 'Ruptela Pro5', '02.11.00', 1, '2026-03-09 07:20:00'),
(9, '351756051523009', '8988211000000000009', 'Queclink GV350', 'A09V21', 1, '2026-03-09 07:30:00'),
(10, '351756051523010', '8988211000000000010', 'Teltonika FMB140', '03.25.14.Rev.09', 1, '2026-03-09 07:40:00');

-- --------------------------------------------------------

--
-- Table structure for table `tracker_poziciok`
--

CREATE TABLE `tracker_poziciok` (
  `id` int UNSIGNED NOT NULL,
  `device_id` bigint UNSIGNED NOT NULL,
  `menetlevel_id` int UNSIGNED DEFAULT NULL,
  `idobelyeg` timestamp NOT NULL,
  `lat` float NOT NULL,
  `lon` float NOT NULL,
  `sebesseg_kmh` float NOT NULL,
  `nyers_payload` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tracker_poziciok`
--

INSERT INTO `tracker_poziciok` (`id`, `device_id`, `menetlevel_id`, `idobelyeg`, `lat`, `lon`, `sebesseg_kmh`, `nyers_payload`) VALUES
(1, 1, 1, '2026-04-10 06:15:00', 47.4979, 19.0402, 52.4, '{\"ignition\":true,\"sat\":10}'),
(2, 2, 2, '2026-04-10 06:45:00', 46.253, 20.1414, 61.8, '{\"ignition\":true,\"sat\":12}'),
(3, 3, 3, '2026-04-10 07:05:00', 47.6875, 17.6504, 67, '{\"ignition\":true,\"sat\":11}'),
(4, 4, 4, '2026-04-10 07:25:00', 48.1035, 20.7784, 58.1, '{\"ignition\":true,\"sat\":9}'),
(5, 5, 5, '2026-04-10 07:45:00', 46.0727, 18.2323, 0, '{\"ignition\":false,\"sat\":8}'),
(6, 6, 6, '2026-04-10 08:00:00', 46.8964, 19.6897, 49.7, '{\"ignition\":true,\"sat\":10}'),
(7, 7, 7, '2026-04-10 08:20:00', 47.9554, 21.7167, 73.5, '{\"ignition\":true,\"sat\":13}'),
(8, 8, 8, '2026-04-10 08:40:00', 47.6817, 16.5845, 54.2, '{\"ignition\":true,\"sat\":12}'),
(9, 9, 9, '2026-04-10 09:00:00', 47.498, 19.0399, 0, '{\"ignition\":false,\"sat\":7}'),
(10, 10, 10, '2026-04-10 09:20:00', 46.2532, 20.147, 64.6, '{\"ignition\":true,\"sat\":11}');

-- --------------------------------------------------------

--
-- Table structure for table `utdij_kalkulaciok`
--

CREATE TABLE `utdij_kalkulaciok` (
  `id` int UNSIGNED NOT NULL,
  `menetlevel_id` int UNSIGNED NOT NULL,
  `jarmu_id` bigint UNSIGNED NOT NULL,
  `ut_id` int UNSIGNED NOT NULL,
  `szolgaltato` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `osszeg_brutto` decimal(12,2) NOT NULL,
  `penznem` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `kalkulalt_at` timestamp NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `utdij_kalkulaciok`
--

INSERT INTO `utdij_kalkulaciok` (`id`, `menetlevel_id`, `jarmu_id`, `ut_id`, `szolgaltato`, `osszeg_brutto`, `penznem`, `kalkulalt_at`) VALUES
(1, 1, 1, 1, 'HU-GO API', 4520.00, 'HUF', '2026-04-10 06:05:00'),
(2, 2, 2, 2, 'HU-GO API', 9860.00, 'HUF', '2026-04-10 06:25:00'),
(3, 3, 3, 3, 'HU-GO API', 4180.00, 'HUF', '2026-04-10 06:40:00'),
(4, 4, 4, 4, 'HU-GO API', 6550.00, 'HUF', '2026-04-10 06:55:00'),
(5, 5, 5, 5, 'HU-GO API', 11240.00, 'HUF', '2026-04-10 07:10:00'),
(6, 6, 6, 6, 'HU-GO API', 4390.00, 'HUF', '2026-04-10 07:25:00'),
(7, 7, 7, 7, 'HU-GO API', 4710.00, 'HUF', '2026-04-10 07:40:00'),
(8, 8, 8, 8, 'HU-GO API', 5030.00, 'HUF', '2026-04-10 07:55:00'),
(9, 9, 9, 9, 'HU-GO API', 5920.00, 'HUF', '2026-04-10 08:10:00'),
(10, 10, 10, 10, 'HU-GO API', 5480.00, 'HUF', '2026-04-10 08:25:00');

-- --------------------------------------------------------

--
-- Table structure for table `utvonalak`
--

CREATE TABLE `utvonalak` (
  `id` int UNSIGNED NOT NULL,
  `indulasi_pont` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `erkezesi_pont` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `tavolsag_m` int NOT NULL,
  `tervezet_gpx` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `letrehozva_at` timestamp NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `utvonalak`
--

INSERT INTO `utvonalak` (`id`, `indulasi_pont`, `erkezesi_pont`, `tavolsag_m`, `tervezet_gpx`, `letrehozva_at`) VALUES
(1, 'Budapest', 'Kecskemet', 89000, 'budapest_kecskemet.gpx', '2026-04-09 12:00:00'),
(2, 'Szeged', 'Budapest', 173000, 'szeged_budapest.gpx', '2026-04-09 12:10:00'),
(3, 'Gyor', 'Tatabanya', 77000, 'gyor_tatabanya.gpx', '2026-04-09 12:20:00'),
(4, 'Miskolc', 'Debrecen', 115000, 'miskolc_debrecen.gpx', '2026-04-09 12:30:00'),
(5, 'Pecs', 'Budapest', 201000, 'pecs_budapest.gpx', '2026-04-09 12:40:00'),
(6, 'Kecskemet', 'Szeged', 90000, 'kecskemet_szeged.gpx', '2026-04-09 12:50:00'),
(7, 'Nyiregyhaza', 'Miskolc', 87000, 'nyiregyhaza_miskolc.gpx', '2026-04-09 13:00:00'),
(8, 'Gyor', 'Sopron', 94000, 'gyor_sopron.gpx', '2026-04-09 13:10:00'),
(9, 'Budapest', 'Gyor', 124000, 'budapest_gyor.gpx', '2026-04-09 13:20:00'),
(10, 'Szeged', 'Baja', 114000, 'szeged_baja.gpx', '2026-04-09 13:30:00');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cegek`
--
ALTER TABLE `cegek`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `felhasznalok`
--
ALTER TABLE `felhasznalok`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `felhasznalok_email_unique` (`email`),
  ADD KEY `felhasznalok_ceg_id_foreign` (`ceg_id`);

--
-- Indexes for table `felhasznalo_sessionok`
--
ALTER TABLE `felhasznalo_sessionok`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `token` (`token`),
  ADD KEY `felhasznalo_id` (`felhasznalo_id`);

--
-- Indexes for table `jarmuvek`
--
ALTER TABLE `jarmuvek`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `jarmuvek_rendszam_unique` (`rendszam`),
  ADD KEY `jarmuvek_ceg_id_foreign` (`ceg_id`),
  ADD KEY `jarmuvek_device_id_foreign` (`device_id`);

--
-- Indexes for table `jogositvanyok`
--
ALTER TABLE `jogositvanyok`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jogositvanyok_sofor_id_foreign` (`sofor_id`);

--
-- Indexes for table `menetlevelek`
--
ALTER TABLE `menetlevelek`
  ADD PRIMARY KEY (`id`),
  ADD KEY `menetlevelek_sofor_id_foreign` (`sofor_id`),
  ADD KEY `menetlevelek_jarmu_id_foreign` (`jarmu_id`),
  ADD KEY `menetlevelek_device_id_foreign` (`device_id`),
  ADD KEY `menetlevelek_start_azon_id_foreign` (`start_azon_id`),
  ADD KEY `menetlevelek_end_azon_id_foreign` (`end_azon_id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `rfid_azonositasok`
--
ALTER TABLE `rfid_azonositasok`
  ADD PRIMARY KEY (`id`),
  ADD KEY `rfid_azonositasok_device_id_foreign` (`device_id`),
  ADD KEY `rfid_azonositasok_kartya_id_foreign` (`kartya_id`),
  ADD KEY `rfid_azonositasok_sofor_id_foreign` (`sofor_id`);

--
-- Indexes for table `rfid_kartyak`
--
ALTER TABLE `rfid_kartyak`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `rfid_kartyak_uid_hex_unique` (`uid_hex`);

--
-- Indexes for table `rfid_kartya_hozzarendeles`
--
ALTER TABLE `rfid_kartya_hozzarendeles`
  ADD PRIMARY KEY (`id`),
  ADD KEY `rfid_kartya_hozzarendeles_kartya_id_foreign` (`kartya_id`),
  ADD KEY `rfid_kartya_hozzarendeles_sofor_id_foreign` (`sofor_id`);

--
-- Indexes for table `soforok`
--
ALTER TABLE `soforok`
  ADD PRIMARY KEY (`id`),
  ADD KEY `soforok_ceg_id_foreign` (`ceg_id`);

--
-- Indexes for table `trackereszkozok`
--
ALTER TABLE `trackereszkozok`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `trackereszkozok_imei_unique` (`imei`);

--
-- Indexes for table `tracker_poziciok`
--
ALTER TABLE `tracker_poziciok`
  ADD PRIMARY KEY (`id`),
  ADD KEY `tracker_poziciok_device_id_foreign` (`device_id`),
  ADD KEY `tracker_poziciok_menetlevel_id_foreign` (`menetlevel_id`);

--
-- Indexes for table `utdij_kalkulaciok`
--
ALTER TABLE `utdij_kalkulaciok`
  ADD PRIMARY KEY (`id`),
  ADD KEY `utdij_kalkulaciok_menetlevel_id_foreign` (`menetlevel_id`),
  ADD KEY `utdij_kalkulaciok_jarmu_id_foreign` (`jarmu_id`),
  ADD KEY `utdij_kalkulaciok_ut_id_foreign` (`ut_id`);

--
-- Indexes for table `utvonalak`
--
ALTER TABLE `utvonalak`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `cegek`
--
ALTER TABLE `cegek`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `felhasznalok`
--
ALTER TABLE `felhasznalok`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `felhasznalo_sessionok`
--
ALTER TABLE `felhasznalo_sessionok`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `jarmuvek`
--
ALTER TABLE `jarmuvek`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `jogositvanyok`
--
ALTER TABLE `jogositvanyok`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `menetlevelek`
--
ALTER TABLE `menetlevelek`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `rfid_azonositasok`
--
ALTER TABLE `rfid_azonositasok`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `rfid_kartyak`
--
ALTER TABLE `rfid_kartyak`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `rfid_kartya_hozzarendeles`
--
ALTER TABLE `rfid_kartya_hozzarendeles`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `soforok`
--
ALTER TABLE `soforok`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `trackereszkozok`
--
ALTER TABLE `trackereszkozok`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `tracker_poziciok`
--
ALTER TABLE `tracker_poziciok`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `utdij_kalkulaciok`
--
ALTER TABLE `utdij_kalkulaciok`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `utvonalak`
--
ALTER TABLE `utvonalak`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `felhasznalok`
--
ALTER TABLE `felhasznalok`
  ADD CONSTRAINT `felhasznalok_ceg_id_foreign` FOREIGN KEY (`ceg_id`) REFERENCES `cegek` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `jarmuvek`
--
ALTER TABLE `jarmuvek`
  ADD CONSTRAINT `jarmuvek_ceg_id_foreign` FOREIGN KEY (`ceg_id`) REFERENCES `cegek` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `jarmuvek_device_id_foreign` FOREIGN KEY (`device_id`) REFERENCES `trackereszkozok` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `jogositvanyok`
--
ALTER TABLE `jogositvanyok`
  ADD CONSTRAINT `jogositvanyok_sofor_id_foreign` FOREIGN KEY (`sofor_id`) REFERENCES `soforok` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `menetlevelek`
--
ALTER TABLE `menetlevelek`
  ADD CONSTRAINT `menetlevelek_device_id_foreign` FOREIGN KEY (`device_id`) REFERENCES `trackereszkozok` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `menetlevelek_end_azon_id_foreign` FOREIGN KEY (`end_azon_id`) REFERENCES `rfid_azonositasok` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `menetlevelek_jarmu_id_foreign` FOREIGN KEY (`jarmu_id`) REFERENCES `jarmuvek` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `menetlevelek_sofor_id_foreign` FOREIGN KEY (`sofor_id`) REFERENCES `soforok` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `menetlevelek_start_azon_id_foreign` FOREIGN KEY (`start_azon_id`) REFERENCES `rfid_azonositasok` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `rfid_azonositasok`
--
ALTER TABLE `rfid_azonositasok`
  ADD CONSTRAINT `rfid_azonositasok_device_id_foreign` FOREIGN KEY (`device_id`) REFERENCES `trackereszkozok` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `rfid_azonositasok_kartya_id_foreign` FOREIGN KEY (`kartya_id`) REFERENCES `rfid_kartyak` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `rfid_azonositasok_sofor_id_foreign` FOREIGN KEY (`sofor_id`) REFERENCES `soforok` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `rfid_kartya_hozzarendeles`
--
ALTER TABLE `rfid_kartya_hozzarendeles`
  ADD CONSTRAINT `rfid_kartya_hozzarendeles_kartya_id_foreign` FOREIGN KEY (`kartya_id`) REFERENCES `rfid_kartyak` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `rfid_kartya_hozzarendeles_sofor_id_foreign` FOREIGN KEY (`sofor_id`) REFERENCES `soforok` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `soforok`
--
ALTER TABLE `soforok`
  ADD CONSTRAINT `soforok_ceg_id_foreign` FOREIGN KEY (`ceg_id`) REFERENCES `cegek` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `tracker_poziciok`
--
ALTER TABLE `tracker_poziciok`
  ADD CONSTRAINT `tracker_poziciok_device_id_foreign` FOREIGN KEY (`device_id`) REFERENCES `trackereszkozok` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `tracker_poziciok_menetlevel_id_foreign` FOREIGN KEY (`menetlevel_id`) REFERENCES `menetlevelek` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `utdij_kalkulaciok`
--
ALTER TABLE `utdij_kalkulaciok`
  ADD CONSTRAINT `utdij_kalkulaciok_jarmu_id_foreign` FOREIGN KEY (`jarmu_id`) REFERENCES `jarmuvek` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `utdij_kalkulaciok_menetlevel_id_foreign` FOREIGN KEY (`menetlevel_id`) REFERENCES `menetlevelek` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `utdij_kalkulaciok_ut_id_foreign` FOREIGN KEY (`ut_id`) REFERENCES `utvonalak` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
