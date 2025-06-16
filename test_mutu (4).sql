-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jun 16, 2025 at 11:32 PM
-- Server version: 8.0.30
-- PHP Version: 8.2.27

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `test_mutu`
--

-- --------------------------------------------------------

--
-- Table structure for table `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `owner` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cakupan_data`
--

CREATE TABLE `cakupan_data` (
  `id` bigint UNSIGNED NOT NULL,
  `nama` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `cakupan_data`
--

INSERT INTO `cakupan_data` (`id`, `nama`, `created_at`, `updated_at`) VALUES
(1, 'cakupan data', '2025-06-16 16:18:29', '2025-06-16 16:18:29');

-- --------------------------------------------------------

--
-- Table structure for table `dimensi_mutu`
--

CREATE TABLE `dimensi_mutu` (
  `id` bigint UNSIGNED NOT NULL,
  `nama` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `dimensi_mutu`
--

INSERT INTO `dimensi_mutu` (`id`, `nama`, `created_at`, `updated_at`) VALUES
(1, 'dimensi', '2025-06-16 16:28:19', '2025-06-16 16:28:19');

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint UNSIGNED NOT NULL,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `frekuensi_analisa_data`
--

CREATE TABLE `frekuensi_analisa_data` (
  `id` bigint UNSIGNED NOT NULL,
  `nama` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `frekuensi_analisa_data`
--

INSERT INTO `frekuensi_analisa_data` (`id`, `nama`, `created_at`, `updated_at`) VALUES
(1, 'analisan data', '2025-06-16 16:26:18', '2025-06-16 16:26:18');

-- --------------------------------------------------------

--
-- Table structure for table `frekuensi_pengumpulan_data`
--

CREATE TABLE `frekuensi_pengumpulan_data` (
  `id` bigint UNSIGNED NOT NULL,
  `nama` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `frekuensi_pengumpulan_data`
--

INSERT INTO `frekuensi_pengumpulan_data` (`id`, `nama`, `created_at`, `updated_at`) VALUES
(1, 'frekuensi pengumpulan data', '2025-06-16 16:19:12', '2025-06-16 16:19:12');

-- --------------------------------------------------------

--
-- Table structure for table `indicators`
--

CREATE TABLE `indicators` (
  `id` bigint UNSIGNED NOT NULL,
  `unit_id` bigint UNSIGNED NOT NULL,
  `name` text COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'Nama indikator mutu',
  `target_percentage` decimal(5,2) NOT NULL COMMENT 'Target pencapaian dalam persentase',
  `type` enum('nasional','lokal') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'lokal' COMMENT 'Tipe indikator',
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `reporting_start_day` int NOT NULL DEFAULT '1' COMMENT 'Tanggal mulai pelaporan (1-31)',
  `reporting_end_day` int NOT NULL DEFAULT '10' COMMENT 'Tanggal selesai pelaporan (1-31)',
  `is_period_active` tinyint(1) NOT NULL DEFAULT '1' COMMENT 'Status aktif periode pengisian'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `indicators`
--

INSERT INTO `indicators` (`id`, `unit_id`, `name`, `target_percentage`, `type`, `is_active`, `created_at`, `updated_at`, `reporting_start_day`, `reporting_end_day`, `is_period_active`) VALUES
(1, 1, 'alif', '80.00', 'lokal', 1, '2025-06-15 20:04:37', '2025-06-15 21:43:45', 1, 30, 1),
(2, 1, '111', '30.00', 'lokal', 1, '2025-06-15 22:13:41', '2025-06-15 22:13:41', 1, 30, 1);

-- --------------------------------------------------------

--
-- Table structure for table `indicator_formulas`
--

CREATE TABLE `indicator_formulas` (
  `id` bigint UNSIGNED NOT NULL,
  `indicator_id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'Nama rumus perhitungan',
  `numerator_label` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'Label untuk input pembilang',
  `numerator_type` enum('count','sum','boolean') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'count' COMMENT 'Tipe perhitungan pembilang',
  `denominator_label` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'Label untuk input penyebut',
  `denominator_type` enum('count','sum','boolean') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'count' COMMENT 'Tipe perhitungan penyebut',
  `calculation_type` enum('percentage','ratio','average') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'percentage' COMMENT 'Tipe perhitungan akhir',
  `multiplier` decimal(5,2) NOT NULL DEFAULT '100.00' COMMENT 'Pengali hasil (default 100 untuk persentase)',
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `interpretasi_data`
--

CREATE TABLE `interpretasi_data` (
  `id` bigint UNSIGNED NOT NULL,
  `nama` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `interpretasi_data`
--

INSERT INTO `interpretasi_data` (`id`, `nama`, `created_at`, `updated_at`) VALUES
(1, 'inter pretasi', '2025-06-16 16:27:22', '2025-06-16 16:27:22');

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint UNSIGNED NOT NULL,
  `queue` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `attempts` tinyint UNSIGNED NOT NULL,
  `reserved_at` int UNSIGNED DEFAULT NULL,
  `available_at` int UNSIGNED NOT NULL,
  `created_at` int UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `job_batches`
--

CREATE TABLE `job_batches` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `total_jobs` int NOT NULL,
  `pending_jobs` int NOT NULL,
  `failed_jobs` int NOT NULL,
  `failed_job_ids` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `options` mediumtext COLLATE utf8mb4_unicode_ci,
  `cancelled_at` int DEFAULT NULL,
  `created_at` int NOT NULL,
  `finished_at` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `kamus_indikator_mutu`
--

CREATE TABLE `kamus_indikator_mutu` (
  `id` bigint UNSIGNED NOT NULL,
  `indikator_id` bigint UNSIGNED NOT NULL,
  `definisi_operasional` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `tujuan` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `dimensi_mutu_id` bigint UNSIGNED NOT NULL,
  `dasar_pemikiran` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `formula_pengukuran` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `metodologi_pengumpulan_data` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `metodologi_pengumpulan_data_id` bigint UNSIGNED NOT NULL,
  `cakupan_data_id` bigint UNSIGNED NOT NULL,
  `pengumpulan_data` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `frekuensi_pengumpulan_data_id` bigint UNSIGNED NOT NULL,
  `frekuensi_analisa_data_id` bigint UNSIGNED NOT NULL,
  `metodologi_analisa_data_id` bigint UNSIGNED NOT NULL,
  `interpretasi_data_id` bigint UNSIGNED NOT NULL,
  `sumber_data` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `penanggung_jawab_pengumpul_data` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `publikasi_data_id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `menu_access`
--

CREATE TABLE `menu_access` (
  `id` bigint UNSIGNED NOT NULL,
  `role_id` bigint UNSIGNED NOT NULL,
  `menu_key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `menu_access`
--

INSERT INTO `menu_access` (`id`, `role_id`, `menu_key`, `created_at`, `updated_at`) VALUES
(1, 1, 'dashboard', '2025-06-15 19:50:46', '2025-06-15 19:50:46'),
(2, 1, 'master_indikator', '2025-06-15 19:50:46', '2025-06-15 19:50:46'),
(3, 1, 'formula', '2025-06-15 19:50:46', '2025-06-15 19:50:46'),
(4, 1, 'laporan_analisis', '2025-06-15 19:50:46', '2025-06-15 19:50:46'),
(5, 1, 'database', '2025-06-15 19:50:46', '2025-06-15 19:50:46'),
(6, 1, 'unit', '2025-06-15 19:50:46', '2025-06-15 19:50:46'),
(7, 1, 'manajemen_user', '2025-06-15 19:50:46', '2025-06-15 19:50:46'),
(8, 1, 'manage_role', '2025-06-15 19:50:46', '2025-06-15 19:50:46'),
(9, 1, 'manajemen_unit', '2025-06-15 19:50:46', '2025-06-15 19:50:46'),
(10, 1, 'hak_akses', '2025-06-15 19:50:46', '2025-06-15 19:50:46'),
(11, 1, 'cakupan_data', '2025-06-15 19:50:46', '2025-06-15 19:50:46'),
(12, 1, 'dimensi_mutu', '2025-06-15 19:50:46', '2025-06-15 19:50:46'),
(13, 1, 'frekuensi_analisa_data', '2025-06-15 19:50:46', '2025-06-15 19:50:46'),
(14, 1, 'frekuensi_pengumpulan_data', '2025-06-15 19:50:46', '2025-06-15 19:50:46'),
(15, 1, 'interpretasi_data', '2025-06-15 19:50:46', '2025-06-15 19:50:46'),
(16, 1, 'metodologi_analisa_data', '2025-06-15 19:50:46', '2025-06-15 19:50:46'),
(17, 1, 'metodologi_pengumpulan_data', '2025-06-15 19:50:46', '2025-06-15 19:50:46'),
(18, 1, 'publikasi_data', '2025-06-15 19:50:46', '2025-06-15 19:50:46'),
(19, 2, 'dashboard', '2025-06-15 19:50:46', '2025-06-15 19:50:46'),
(20, 2, 'laporan_analisis', '2025-06-15 19:50:46', '2025-06-15 19:50:46'),
(21, 3, 'dashboard', '2025-06-15 19:50:46', '2025-06-15 19:50:46'),
(22, 3, 'laporan_analisis', '2025-06-15 19:50:46', '2025-06-15 19:50:46'),
(23, 4, 'dashboard', '2025-06-15 19:50:46', '2025-06-15 19:50:46'),
(24, 4, 'master_indikator', '2025-06-15 19:50:46', '2025-06-15 19:50:46'),
(25, 4, 'formula', '2025-06-15 19:50:46', '2025-06-15 19:50:46'),
(26, 4, 'laporan_analisis', '2025-06-15 19:50:46', '2025-06-15 19:50:46'),
(27, 4, 'cakupan_data', '2025-06-15 19:50:46', '2025-06-15 19:50:46'),
(28, 4, 'dimensi_mutu', '2025-06-15 19:50:46', '2025-06-15 19:50:46'),
(29, 4, 'frekuensi_analisa_data', '2025-06-15 19:50:46', '2025-06-15 19:50:46'),
(30, 4, 'frekuensi_pengumpulan_data', '2025-06-15 19:50:46', '2025-06-15 19:50:46'),
(31, 4, 'interpretasi_data', '2025-06-15 19:50:46', '2025-06-15 19:50:46'),
(32, 4, 'metodologi_analisa_data', '2025-06-15 19:50:46', '2025-06-15 19:50:46'),
(33, 4, 'metodologi_pengumpulan_data', '2025-06-15 19:50:46', '2025-06-15 19:50:46'),
(34, 4, 'publikasi_data', '2025-06-15 19:50:46', '2025-06-15 19:50:46'),
(35, 5, 'dashboard', '2025-06-15 19:50:46', '2025-06-15 19:50:46'),
(36, 5, 'laporan_analisis', '2025-06-15 19:50:46', '2025-06-15 19:50:46');

-- --------------------------------------------------------

--
-- Table structure for table `metodologi_analisa_data`
--

CREATE TABLE `metodologi_analisa_data` (
  `id` bigint UNSIGNED NOT NULL,
  `nama` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `metodologi_analisa_data`
--

INSERT INTO `metodologi_analisa_data` (`id`, `nama`, `created_at`, `updated_at`) VALUES
(1, 'metodologi analisa data', '2025-06-16 16:26:59', '2025-06-16 16:26:59');

-- --------------------------------------------------------

--
-- Table structure for table `metodologi_pengumpulan_data`
--

CREATE TABLE `metodologi_pengumpulan_data` (
  `id` bigint UNSIGNED NOT NULL,
  `nama` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `metodologi_pengumpulan_data`
--

INSERT INTO `metodologi_pengumpulan_data` (`id`, `nama`, `created_at`, `updated_at`) VALUES
(1, 'naruto', '2025-06-16 16:17:27', '2025-06-16 16:17:27');

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000001_create_cache_table', 1),
(2, '0001_01_01_000002_create_jobs_table', 1),
(3, '2024_03_09_000000_create_units_table', 1),
(4, '2024_03_09_000001_create_roles_table', 1),
(5, '2024_03_09_000002_create_users_table', 1),
(6, '2025_06_09_042604_create_personal_access_tokens_table', 1),
(7, '2025_06_09_042720_create_sessions_table', 1),
(8, '2025_06_10_112541_create_indicators_table', 1),
(9, '2025_06_10_112553_create_daily_indicator_data_table', 1),
(10, '2025_06_10_112651_create_indicator_formulas_table', 1),
(11, '2025_06_11_000001_modify_indicator_formulas_table', 1),
(12, '2025_06_11_000002_add_period_columns_to_indicators_table', 1),
(13, '2025_06_15_034521_create_menu_access_table', 1),
(14, '2025_06_16_000001_create_kamus_indikator_mutu_table', 1);

-- --------------------------------------------------------

--
-- Table structure for table `monthly_indicator_data`
--

CREATE TABLE `monthly_indicator_data` (
  `id` bigint UNSIGNED NOT NULL,
  `indicator_id` bigint UNSIGNED NOT NULL,
  `date` date NOT NULL COMMENT 'Tanggal pengukuran',
  `numerator` int NOT NULL DEFAULT '0' COMMENT 'Pembilang',
  `denominator` int NOT NULL DEFAULT '0' COMMENT 'Penyebut',
  `achievement_percentage` decimal(5,2) DEFAULT NULL COMMENT 'Persentase pencapaian',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `month` int GENERATED ALWAYS AS (month(`date`)) STORED,
  `year` int GENERATED ALWAYS AS (year(`date`)) STORED
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `monthly_indicator_data`
--

INSERT INTO `monthly_indicator_data` (`id`, `indicator_id`, `date`, `numerator`, `denominator`, `achievement_percentage`, `created_at`, `updated_at`) VALUES
(1, 1, '2025-06-01', 22, 22, '100.00', '2025-06-15 20:04:55', '2025-06-15 20:04:55'),
(2, 1, '2025-05-01', 22, 22, '100.00', '2025-06-15 21:48:23', '2025-06-15 21:48:23'),
(3, 1, '2025-04-01', 5, 1, '500.00', '2025-06-15 21:49:18', '2025-06-15 21:49:18'),
(4, 2, '2025-06-01', 5, 8, '62.50', '2025-06-15 22:14:09', '2025-06-15 22:14:09');

-- --------------------------------------------------------

--
-- Table structure for table `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text COLLATE utf8mb4_unicode_ci,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `publikasi_data`
--

CREATE TABLE `publikasi_data` (
  `id` bigint UNSIGNED NOT NULL,
  `nama` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `publikasi_data`
--

INSERT INTO `publikasi_data` (`id`, `nama`, `created_at`, `updated_at`) VALUES
(1, 'lii', '2025-06-16 16:29:31', '2025-06-16 16:29:31');

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `name`, `slug`, `description`, `created_at`, `updated_at`) VALUES
(1, 'Administrator', 'admin', 'Super admin dengan akses penuh', '2025-06-15 19:50:45', '2025-06-15 19:50:45'),
(2, 'Kepala Unit', 'unit_head', 'Kepala unit dengan akses ke data unit', '2025-06-15 19:50:45', '2025-06-15 19:50:45'),
(3, 'Staff Unit', 'unit_staff', 'Staff unit dengan akses terbatas', '2025-06-15 19:50:45', '2025-06-15 19:50:45'),
(4, 'Tim Mutu', 'quality_team', 'Tim mutu dengan akses ke semua data mutu', '2025-06-15 19:50:45', '2025-06-15 19:50:45'),
(5, 'Manajemen', 'management', 'Manajemen dengan akses monitoring', '2025-06-15 19:50:45', '2025-06-15 19:50:45');

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text COLLATE utf8mb4_unicode_ci,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_activity` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('I2BiAaTOIIlcZMyTs8MzCWRfpJ4vD7lkSkyZ1xAJ', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/137.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiVVhieWhHWnRmODlTUjBJWkxUMHEzM1l1eFdpekpMSVdsNUN4MlNRbyI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Mzc6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9rYW11cy1pbmRpa2F0b3IiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1750115178),
('LmWI6dJ0DjVStXtNuLohdpNo6RWqcZxcEOX2OOAN', 1, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/137.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiMUQzaTBGMVdTdDc2QWdlWVg1UzFVYnIwVk05M2RtNHZzbFpPaVlGTiI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6NDQ6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9rYW11cy1pbmRpa2F0b3IvY3JlYXRlIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo1MDoibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO2k6MTt9', 1750116577);

-- --------------------------------------------------------

--
-- Table structure for table `units`
--

CREATE TABLE `units` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `code` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `units`
--

INSERT INTO `units` (`id`, `name`, `code`, `description`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 'Administrator', 'ADM001', 'Unit yang memiliki akses penuh ke sistem', 1, '2025-06-15 19:50:45', '2025-06-15 19:50:45'),
(2, 'Unit Mutu', 'UNT001', 'Unit yang menangani mutu rumah sakit', 1, '2025-06-15 19:50:46', '2025-06-15 19:50:46'),
(3, 'Unit Pelayanan', 'UNT002', 'Unit yang menangani pelayanan pasien', 1, '2025-06-15 19:50:46', '2025-06-15 19:50:46'),
(4, 'Unit Keuangan', 'UNT003', 'Unit yang menangani keuangan rumah sakit', 1, '2025-06-15 19:50:46', '2025-06-15 19:50:46');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `username` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `role_id` bigint UNSIGNED NOT NULL,
  `unit_id` bigint UNSIGNED DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `username`, `email`, `password`, `role_id`, `unit_id`, `is_active`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Administrator', 'admin', 'admin@rsazra.com', '$2y$12$NERLlKGoDCxFYTJqovx4VOEPz/CV5V.9gdfmreA5bRt1swMFtm2JK', 1, 2, 1, NULL, '2025-06-15 19:50:46', '2025-06-15 19:50:46');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `cakupan_data`
--
ALTER TABLE `cakupan_data`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `dimensi_mutu`
--
ALTER TABLE `dimensi_mutu`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `frekuensi_analisa_data`
--
ALTER TABLE `frekuensi_analisa_data`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `frekuensi_pengumpulan_data`
--
ALTER TABLE `frekuensi_pengumpulan_data`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `indicators`
--
ALTER TABLE `indicators`
  ADD PRIMARY KEY (`id`),
  ADD KEY `indicators_unit_id_foreign` (`unit_id`);

--
-- Indexes for table `indicator_formulas`
--
ALTER TABLE `indicator_formulas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `indicator_formulas_indicator_id_foreign` (`indicator_id`);

--
-- Indexes for table `interpretasi_data`
--
ALTER TABLE `interpretasi_data`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Indexes for table `job_batches`
--
ALTER TABLE `job_batches`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `kamus_indikator_mutu`
--
ALTER TABLE `kamus_indikator_mutu`
  ADD PRIMARY KEY (`id`),
  ADD KEY `kamus_indikator_mutu_indikator_id_foreign` (`indikator_id`),
  ADD KEY `kamus_indikator_mutu_dimensi_mutu_id_foreign` (`dimensi_mutu_id`),
  ADD KEY `kamus_indikator_mutu_metodologi_pengumpulan_data_id_foreign` (`metodologi_pengumpulan_data_id`),
  ADD KEY `kamus_indikator_mutu_cakupan_data_id_foreign` (`cakupan_data_id`),
  ADD KEY `kamus_indikator_mutu_frekuensi_pengumpulan_data_id_foreign` (`frekuensi_pengumpulan_data_id`),
  ADD KEY `kamus_indikator_mutu_frekuensi_analisa_data_id_foreign` (`frekuensi_analisa_data_id`),
  ADD KEY `kamus_indikator_mutu_metodologi_analisa_data_id_foreign` (`metodologi_analisa_data_id`),
  ADD KEY `kamus_indikator_mutu_interpretasi_data_id_foreign` (`interpretasi_data_id`),
  ADD KEY `kamus_indikator_mutu_publikasi_data_id_foreign` (`publikasi_data_id`);

--
-- Indexes for table `menu_access`
--
ALTER TABLE `menu_access`
  ADD PRIMARY KEY (`id`),
  ADD KEY `menu_access_role_id_foreign` (`role_id`);

--
-- Indexes for table `metodologi_analisa_data`
--
ALTER TABLE `metodologi_analisa_data`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `metodologi_pengumpulan_data`
--
ALTER TABLE `metodologi_pengumpulan_data`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `monthly_indicator_data`
--
ALTER TABLE `monthly_indicator_data`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_daily_measurement` (`indicator_id`,`date`);

--
-- Indexes for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indexes for table `publikasi_data`
--
ALTER TABLE `publikasi_data`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `roles_slug_unique` (`slug`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indexes for table `units`
--
ALTER TABLE `units`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `units_code_unique` (`code`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_username_unique` (`username`),
  ADD UNIQUE KEY `users_email_unique` (`email`),
  ADD KEY `users_role_id_foreign` (`role_id`),
  ADD KEY `users_unit_id_foreign` (`unit_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `cakupan_data`
--
ALTER TABLE `cakupan_data`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `dimensi_mutu`
--
ALTER TABLE `dimensi_mutu`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `frekuensi_analisa_data`
--
ALTER TABLE `frekuensi_analisa_data`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `frekuensi_pengumpulan_data`
--
ALTER TABLE `frekuensi_pengumpulan_data`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `indicators`
--
ALTER TABLE `indicators`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `indicator_formulas`
--
ALTER TABLE `indicator_formulas`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `interpretasi_data`
--
ALTER TABLE `interpretasi_data`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `kamus_indikator_mutu`
--
ALTER TABLE `kamus_indikator_mutu`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `menu_access`
--
ALTER TABLE `menu_access`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- AUTO_INCREMENT for table `metodologi_analisa_data`
--
ALTER TABLE `metodologi_analisa_data`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `metodologi_pengumpulan_data`
--
ALTER TABLE `metodologi_pengumpulan_data`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `monthly_indicator_data`
--
ALTER TABLE `monthly_indicator_data`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `publikasi_data`
--
ALTER TABLE `publikasi_data`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `units`
--
ALTER TABLE `units`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `indicators`
--
ALTER TABLE `indicators`
  ADD CONSTRAINT `indicators_unit_id_foreign` FOREIGN KEY (`unit_id`) REFERENCES `units` (`id`);

--
-- Constraints for table `indicator_formulas`
--
ALTER TABLE `indicator_formulas`
  ADD CONSTRAINT `indicator_formulas_indicator_id_foreign` FOREIGN KEY (`indicator_id`) REFERENCES `indicators` (`id`);

--
-- Constraints for table `kamus_indikator_mutu`
--
ALTER TABLE `kamus_indikator_mutu`
  ADD CONSTRAINT `kamus_indikator_mutu_cakupan_data_id_foreign` FOREIGN KEY (`cakupan_data_id`) REFERENCES `cakupan_data` (`id`),
  ADD CONSTRAINT `kamus_indikator_mutu_dimensi_mutu_id_foreign` FOREIGN KEY (`dimensi_mutu_id`) REFERENCES `dimensi_mutu` (`id`),
  ADD CONSTRAINT `kamus_indikator_mutu_frekuensi_analisa_data_id_foreign` FOREIGN KEY (`frekuensi_analisa_data_id`) REFERENCES `frekuensi_analisa_data` (`id`),
  ADD CONSTRAINT `kamus_indikator_mutu_frekuensi_pengumpulan_data_id_foreign` FOREIGN KEY (`frekuensi_pengumpulan_data_id`) REFERENCES `frekuensi_pengumpulan_data` (`id`),
  ADD CONSTRAINT `kamus_indikator_mutu_indikator_id_foreign` FOREIGN KEY (`indikator_id`) REFERENCES `indicators` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `kamus_indikator_mutu_interpretasi_data_id_foreign` FOREIGN KEY (`interpretasi_data_id`) REFERENCES `interpretasi_data` (`id`),
  ADD CONSTRAINT `kamus_indikator_mutu_metodologi_analisa_data_id_foreign` FOREIGN KEY (`metodologi_analisa_data_id`) REFERENCES `metodologi_analisa_data` (`id`),
  ADD CONSTRAINT `kamus_indikator_mutu_metodologi_pengumpulan_data_id_foreign` FOREIGN KEY (`metodologi_pengumpulan_data_id`) REFERENCES `metodologi_pengumpulan_data` (`id`),
  ADD CONSTRAINT `kamus_indikator_mutu_publikasi_data_id_foreign` FOREIGN KEY (`publikasi_data_id`) REFERENCES `publikasi_data` (`id`);

--
-- Constraints for table `menu_access`
--
ALTER TABLE `menu_access`
  ADD CONSTRAINT `menu_access_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `monthly_indicator_data`
--
ALTER TABLE `monthly_indicator_data`
  ADD CONSTRAINT `monthly_indicator_data_indicator_id_foreign` FOREIGN KEY (`indicator_id`) REFERENCES `indicators` (`id`);

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`),
  ADD CONSTRAINT `users_unit_id_foreign` FOREIGN KEY (`unit_id`) REFERENCES `units` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
