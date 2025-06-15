-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jun 15, 2025 at 03:37 AM
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
(1, 1, 'mimin', '80.00', 'lokal', 1, '2025-06-12 20:50:33', '2025-06-12 20:50:33', 1, 10, 1),
(2, 2, 'pai', '80.00', 'lokal', 1, '2025-06-12 23:11:48', '2025-06-12 23:11:48', 1, 30, 1),
(3, 2, 'paii', '80.00', 'lokal', 1, '2025-06-12 23:28:09', '2025-06-12 23:31:43', 1, 19, 1);

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
(12, '2025_06_11_000002_add_period_columns_to_indicators_table', 1);

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
(1, 2, '2025-06-01', 11, 2, '550.00', '2025-06-12 23:27:17', '2025-06-12 23:27:17'),
(2, 3, '2025-06-01', 6, 3, '200.00', '2025-06-12 23:32:14', '2025-06-12 23:32:14');

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
(1, 'Administrator', 'admin', 'Super admin dengan akses penuh', '2025-06-12 20:48:46', '2025-06-12 20:48:46'),
(2, 'Kepala Unit', 'unit_head', 'Kepala unit dengan akses ke data unit', '2025-06-12 20:48:46', '2025-06-12 20:48:46'),
(3, 'Staff Unit', 'unit_staff', 'Staff unit dengan akses terbatas', '2025-06-12 20:48:46', '2025-06-12 20:48:46'),
(4, 'Tim Mutu', 'quality_team', 'Tim mutu dengan akses ke semua data mutu', '2025-06-12 20:48:46', '2025-06-12 20:48:46'),
(5, 'Manajemen', 'management', 'Manajemen dengan akses monitoring', '2025-06-12 20:48:46', '2025-06-12 20:48:46');

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
('i0fZLGdx98HThhQAtppF2POusxhx7kgNFHuxeVD3', 1, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/137.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiemprQmFiRWtmckZHSk9ZWko0Y2t4VmVlSENNNlM5WlBxd084YWlUNSI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6NDY6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9tYXN0ZXItaW5kaWthdG9yL2Zvcm11bGEiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX1zOjUwOiJsb2dpbl93ZWJfNTliYTM2YWRkYzJiMmY5NDAxNTgwZjAxNGM3ZjU4ZWE0ZTMwOTg5ZCI7aToxO30=', 1749803052),
('SUkzFdQH566yqlyYdVJtiQVR82Zdo5BMHfRdgr4T', 2, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/137.0.0.0 Safari/537.36 Edg/137.0.0.0', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiSnQ3WVhFdExUTTBkN1VMYmNsUEZUUVlJQ0xsc0JGVVhVQ0g1WGFCTiI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Mzg6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9tYXN0ZXItaW5kaWthdG9yIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo1MDoibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO2k6Mjt9', 1749798958);

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
(1, 'Administrator', 'ADM001', 'Unit yang memiliki akses penuh ke sistem', 1, '2025-06-12 20:48:46', '2025-06-12 20:48:46'),
(2, 'Unit Mutu', 'UNT001', 'Unit yang menangani mutu rumah sakit', 1, '2025-06-12 20:48:46', '2025-06-12 20:48:46'),
(3, 'Unit Pelayanan', 'UNT002', 'Unit yang menangani pelayanan pasien', 1, '2025-06-12 20:48:46', '2025-06-12 20:48:46'),
(4, 'Unit Keuangan', 'UNT003', 'Unit yang menangani keuangan rumah sakit', 1, '2025-06-12 20:48:46', '2025-06-12 20:48:46');

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
(1, 'Administrator', 'admin', 'admin@rsazra.com', '$2y$12$JQ0uUs4nAMrp2E7elzyDAugIsg6OrRnCnMkVOmD5Fa2cZ4uydN5KO', 1, 2, 1, NULL, '2025-06-12 20:48:46', '2025-06-12 20:48:46'),
(2, 'pai', 'pai', 'PAI@GMAIL.COM', '$2y$12$6t2ERNPonPMTZ0D3cp0L3OBYmhNcGlDr9IR.qQilZCdKGMTTIsc7q', 3, 2, 1, NULL, '2025-06-12 23:09:38', '2025-06-12 23:09:38');

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
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

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
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `indicators`
--
ALTER TABLE `indicators`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `indicator_formulas`
--
ALTER TABLE `indicator_formulas`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `monthly_indicator_data`
--
ALTER TABLE `monthly_indicator_data`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

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
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

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
