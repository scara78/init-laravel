-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 05, 2019 at 03:38 PM
-- Server version: 10.4.6-MariaDB
-- PHP Version: 7.1.32

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `streamapp`
--

-- --------------------------------------------------------

--
-- Table structure for table `embeds`
--

CREATE TABLE `embeds` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `code` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `episodes`
--

CREATE TABLE `episodes` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tmdb_id` int(10) UNSIGNED DEFAULT NULL,
  `season_id` bigint(20) UNSIGNED NOT NULL,
  `episode_number` int(10) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `overview` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `still_path` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `vote_average` double(8,2) UNSIGNED DEFAULT NULL,
  `vote_count` double(8,2) UNSIGNED DEFAULT NULL,
  `views` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `air_date` date DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `genres`
--

CREATE TABLE `genres` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `livetvs`
--

CREATE TABLE `livetvs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `overview` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `poster_path` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `backdrop_path` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `link` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `views` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(16, '2014_10_12_000000_create_users_table', 1),
(17, '2014_10_12_100000_create_password_resets_table', 1),
(18, '2019_06_29_210234_create_movies_table', 1),
(19, '2019_06_29_210235_create_genres_table', 1),
(20, '2019_06_29_210255_create_movie_videos_table', 1),
(21, '2019_06_29_210310_create_movie_genres_table', 1),
(22, '2019_07_15_224942_create_servers_table', 1),
(23, '2019_07_21_001804_create_series_table', 1),
(24, '2019_07_21_001913_create_seasons_table', 1),
(25, '2019_07_21_001927_create_episodes_table', 1),
(26, '2019_07_21_002012_create_serie_genres_table', 1),
(27, '2019_07_23_085704_create_serie_videos_table', 1),
(28, '2019_07_28_232727_create_livetvs_table', 1),
(29, '2019_08_08_210737_create_settings_table', 1),
(30, '2019_08_25_142122_create_embeds_table', 1);

-- --------------------------------------------------------

--
-- Table structure for table `movies`
--

CREATE TABLE `movies` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tmdb_id` int(10) UNSIGNED DEFAULT NULL,
  `title` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `overview` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `poster_path` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `backdrop_path` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `preview_path` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `vote_average` double(8,2) UNSIGNED DEFAULT NULL,
  `vote_count` double(8,2) UNSIGNED DEFAULT NULL,
  `popularity` double(8,2) UNSIGNED DEFAULT NULL,
  `views` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `release_date` date DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `movie_genres`
--

CREATE TABLE `movie_genres` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `movie_id` bigint(20) UNSIGNED NOT NULL,
  `genre_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `movie_videos`
--

CREATE TABLE `movie_videos` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `movie_id` bigint(20) UNSIGNED NOT NULL,
  `server` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `link` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `lang` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `hd` tinyint(1) NOT NULL DEFAULT 0,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `seasons`
--

CREATE TABLE `seasons` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tmdb_id` int(10) UNSIGNED DEFAULT NULL,
  `serie_id` bigint(20) UNSIGNED NOT NULL,
  `season_number` int(10) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `overview` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `poster_path` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `air_date` date DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `series`
--

CREATE TABLE `series` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tmdb_id` int(10) UNSIGNED DEFAULT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `overview` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `poster_path` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `backdrop_path` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `preview_path` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `vote_average` double(8,2) UNSIGNED DEFAULT NULL,
  `vote_count` double(8,2) UNSIGNED DEFAULT NULL,
  `popularity` double(8,2) UNSIGNED DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `first_air_date` date DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `serie_genres`
--

CREATE TABLE `serie_genres` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `serie_id` bigint(20) UNSIGNED NOT NULL,
  `genre_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `serie_videos`
--

CREATE TABLE `serie_videos` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `episode_id` bigint(20) UNSIGNED NOT NULL,
  `server` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `link` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `lang` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `hd` tinyint(1) NOT NULL DEFAULT 0,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `servers`
--

CREATE TABLE `servers` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

CREATE TABLE `settings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `app_name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `authorization` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tmdb_api_key` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tmdb_lang` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `aws_s3_storage` tinyint(1) NOT NULL DEFAULT 0,
  `aws_access_key_id` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `aws_secret_access_key` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `aws_default_region` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `aws_bucket` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `app_url_android` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `app_url_ios` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `title_in_poster` tinyint(1) NOT NULL,
  `app_bar_animation` tinyint(1) NOT NULL,
  `livetv` tinyint(1) NOT NULL,
  `kids` tinyint(1) NOT NULL,
  `ad_app_id` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ad_banner` tinyint(1) NOT NULL,
  `ad_unit_id_banner` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ad_interstitial` tinyint(1) NOT NULL,
  `ad_unit_id_interstitial` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ad_ios_app_id` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ad_ios_banner` tinyint(1) NOT NULL,
  `ad_ios_unit_id_banner` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ad_ios_interstitial` tinyint(1) NOT NULL,
  `ad_ios_unit_id_interstitial` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `app_color_dark` tinyint(1) NOT NULL,
  `app_background_color` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `app_header_recent_task_color` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `app_primary_color` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `app_splash_color` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `app_buttons_color` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `app_bar_color` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `app_bar_opacity` double(8,2) UNSIGNED NOT NULL,
  `app_bar_icons_color` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `bottom_navigation_bar_color` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `icons_color` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `text_color` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `app_bar_title_color` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `settings`
--

INSERT INTO `settings` (`id`, `app_name`, `authorization`, `tmdb_api_key`, `tmdb_lang`, `aws_s3_storage`, `aws_access_key_id`, `aws_secret_access_key`, `aws_default_region`, `aws_bucket`, `app_url_android`, `app_url_ios`, `title_in_poster`, `app_bar_animation`, `livetv`, `kids`, `ad_app_id`, `ad_banner`, `ad_unit_id_banner`, `ad_interstitial`, `ad_unit_id_interstitial`, `ad_ios_app_id`, `ad_ios_banner`, `ad_ios_unit_id_banner`, `ad_ios_interstitial`, `ad_ios_unit_id_interstitial`, `app_color_dark`, `app_background_color`, `app_header_recent_task_color`, `app_primary_color`, `app_splash_color`, `app_buttons_color`, `app_bar_color`, `app_bar_opacity`, `app_bar_icons_color`, `bottom_navigation_bar_color`, `icons_color`, `text_color`, `app_bar_title_color`, `created_at`, `updated_at`) VALUES
(1, 'StreamApp', '', 'a95c0a3b234912d28326d5c272124ad1', '{\"english_name\":\"English\",\"iso_639_1\":\"en\",\"name\":\"English\"}', 0, NULL, NULL, NULL, NULL, '', '', 0, 1, 1, 1, 'ca-app-pub-3940256099942544~3347511713', 0, 'ca-app-pub-3940256099942544/6300978111', 0, 'ca-app-pub-3940256099942544/1033173712', 'ca-app-pub-3940256099942544~1458002511', 0, 'ca-app-pub-3940256099942544/2934735716', 0, 'ca-app-pub-3940256099942544/4411468910', 1, '#1C1C1C', '#212121', '#FF4500', '#FF4500', '#FF4500', '#000000', 0.15, '#FFFFFF', '#1C1C1C', '#FFFFFF', '#FFFFFF', '#FFFFFF', '2019-09-05 17:38:18', '2019-09-05 17:38:18');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `role` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'user',
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `avatar` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `role`, `name`, `email`, `avatar`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'admin', 'admin', 'admin@streamapp.test', NULL, NULL, '$2y$10$F2qkJcyfi1qrs4w4TgAqJubkwXBpPVgqAot8KjpKffKPvjd3bTPba', NULL, '2019-09-05 17:38:18', '2019-09-05 17:38:18');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `embeds`
--
ALTER TABLE `embeds`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `episodes`
--
ALTER TABLE `episodes`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `episodes_tmdb_id_unique` (`tmdb_id`),
  ADD KEY `episodes_season_id_foreign` (`season_id`);

--
-- Indexes for table `genres`
--
ALTER TABLE `genres`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `livetvs`
--
ALTER TABLE `livetvs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `movies`
--
ALTER TABLE `movies`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `movies_tmdb_id_unique` (`tmdb_id`);

--
-- Indexes for table `movie_genres`
--
ALTER TABLE `movie_genres`
  ADD PRIMARY KEY (`id`),
  ADD KEY `movie_genres_movie_id_foreign` (`movie_id`),
  ADD KEY `movie_genres_genre_id_foreign` (`genre_id`);

--
-- Indexes for table `movie_videos`
--
ALTER TABLE `movie_videos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `movie_videos_movie_id_foreign` (`movie_id`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- Indexes for table `seasons`
--
ALTER TABLE `seasons`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `seasons_tmdb_id_unique` (`tmdb_id`),
  ADD KEY `seasons_serie_id_foreign` (`serie_id`);

--
-- Indexes for table `series`
--
ALTER TABLE `series`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `series_tmdb_id_unique` (`tmdb_id`);

--
-- Indexes for table `serie_genres`
--
ALTER TABLE `serie_genres`
  ADD PRIMARY KEY (`id`),
  ADD KEY `serie_genres_serie_id_foreign` (`serie_id`),
  ADD KEY `serie_genres_genre_id_foreign` (`genre_id`);

--
-- Indexes for table `serie_videos`
--
ALTER TABLE `serie_videos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `serie_videos_episode_id_foreign` (`episode_id`);

--
-- Indexes for table `servers`
--
ALTER TABLE `servers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `settings`
--
ALTER TABLE `settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `embeds`
--
ALTER TABLE `embeds`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `episodes`
--
ALTER TABLE `episodes`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `genres`
--
ALTER TABLE `genres`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `livetvs`
--
ALTER TABLE `livetvs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT for table `movies`
--
ALTER TABLE `movies`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `movie_genres`
--
ALTER TABLE `movie_genres`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `movie_videos`
--
ALTER TABLE `movie_videos`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `seasons`
--
ALTER TABLE `seasons`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `series`
--
ALTER TABLE `series`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `serie_genres`
--
ALTER TABLE `serie_genres`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `serie_videos`
--
ALTER TABLE `serie_videos`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `servers`
--
ALTER TABLE `servers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `settings`
--
ALTER TABLE `settings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `episodes`
--
ALTER TABLE `episodes`
  ADD CONSTRAINT `episodes_season_id_foreign` FOREIGN KEY (`season_id`) REFERENCES `seasons` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `movie_genres`
--
ALTER TABLE `movie_genres`
  ADD CONSTRAINT `movie_genres_genre_id_foreign` FOREIGN KEY (`genre_id`) REFERENCES `genres` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `movie_genres_movie_id_foreign` FOREIGN KEY (`movie_id`) REFERENCES `movies` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `movie_videos`
--
ALTER TABLE `movie_videos`
  ADD CONSTRAINT `movie_videos_movie_id_foreign` FOREIGN KEY (`movie_id`) REFERENCES `movies` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `seasons`
--
ALTER TABLE `seasons`
  ADD CONSTRAINT `seasons_serie_id_foreign` FOREIGN KEY (`serie_id`) REFERENCES `series` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `serie_genres`
--
ALTER TABLE `serie_genres`
  ADD CONSTRAINT `serie_genres_genre_id_foreign` FOREIGN KEY (`genre_id`) REFERENCES `genres` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `serie_genres_serie_id_foreign` FOREIGN KEY (`serie_id`) REFERENCES `series` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `serie_videos`
--
ALTER TABLE `serie_videos`
  ADD CONSTRAINT `serie_videos_episode_id_foreign` FOREIGN KEY (`episode_id`) REFERENCES `episodes` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
