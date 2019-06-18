drop schema rsr;
create schema rsr
default character set utf8;

use rsr;
-- CREATE TABLE users (
--     id INT NOT NULL AUTO_INCREMENT,
--     name VARCHAR(100) NOT NULL,
--     email VARCHAR(100) NOT NULL,
--     username VARCHAR(100) UNIQUE,
--     password VARCHAR(512) NOT NULL,
--     birth_date DATE,
--     updated_at VARCHAR(4000),
--     created_at VARCHAR(4000),
--     profile_picture BLOB,
--     remember_token VARCHAR(100),
--     PRIMARY KEY (id)
-- );



-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 15, 2019 at 02:04 PM
-- Server version: 10.3.15-MariaDB
-- PHP Version: 7.3.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `rsr`
--

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_resets_table', 1),
(3, '2016_06_01_000001_create_oauth_auth_codes_table', 1),
(4, '2016_06_01_000002_create_oauth_access_tokens_table', 1),
(5, '2016_06_01_000003_create_oauth_refresh_tokens_table', 1),
(6, '2016_06_01_000004_create_oauth_clients_table', 1),
(7, '2016_06_01_000005_create_oauth_personal_access_clients_table', 1);

-- --------------------------------------------------------

--
-- Table structure for table `oauth_access_tokens`
--

CREATE TABLE `oauth_access_tokens` (
  `id` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `client_id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `scopes` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `revoked` tinyint(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `expires_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `oauth_auth_codes`
--

CREATE TABLE `oauth_auth_codes` (
  `id` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` int(11) NOT NULL,
  `client_id` int(10) UNSIGNED NOT NULL,
  `scopes` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `revoked` tinyint(1) NOT NULL,
  `expires_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `oauth_clients`
--

CREATE TABLE `oauth_clients` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `secret` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `redirect` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `personal_access_client` tinyint(1) NOT NULL,
  `password_client` tinyint(1) NOT NULL,
  `revoked` tinyint(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `oauth_personal_access_clients`
--

CREATE TABLE `oauth_personal_access_clients` (
  `id` int(10) UNSIGNED NOT NULL,
  `client_id` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `oauth_refresh_tokens`
--

CREATE TABLE `oauth_refresh_tokens` (
  `id` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `access_token_id` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `revoked` tinyint(1) NOT NULL,
  `expires_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `first_name` varchar(255) COLLATE utf8mb4_unicode_ci,
  `last_name` varchar(255) COLLATE utf8mb4_unicode_ci,
  `birth_date` Date,
  `profile_picture` BLOB,
  `chat_user_id` int NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `oauth_access_tokens`
--
ALTER TABLE `oauth_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD KEY `oauth_access_tokens_user_id_index` (`user_id`);

--
-- Indexes for table `oauth_auth_codes`
--
ALTER TABLE `oauth_auth_codes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `oauth_clients`
--
ALTER TABLE `oauth_clients`
  ADD PRIMARY KEY (`id`),
  ADD KEY `oauth_clients_user_id_index` (`user_id`);

--
-- Indexes for table `oauth_personal_access_clients`
--
ALTER TABLE `oauth_personal_access_clients`
  ADD PRIMARY KEY (`id`),
  ADD KEY `oauth_personal_access_clients_client_id_index` (`client_id`);

--
-- Indexes for table `oauth_refresh_tokens`
--
ALTER TABLE `oauth_refresh_tokens`
  ADD PRIMARY KEY (`id`),
  ADD KEY `oauth_refresh_tokens_access_token_id_index` (`access_token_id`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_user_name_unique` (`user_name`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `oauth_clients`
--
ALTER TABLE `oauth_clients`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `oauth_personal_access_clients`
--
ALTER TABLE `oauth_personal_access_clients`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;


CREATE TABLE user_sessions (
    user_session_id INT NOT NULL AUTO_INCREMENT,
    user_id INT NOT NULL,
    session VARCHAR(4000),
    PRIMARY KEY (user_session_id)
);

CREATE TABLE points (
    id INT NOT NULL AUTO_INCREMENT,
    user_id bigint(20) UNSIGNED NOT NULL,
    point INT NOT NULL,
    PRIMARY KEY (id),
    FOREIGN KEY (user_id)
        REFERENCES users (id)
);


CREATE TABLE rating_types (
    id INT NOT NULL AUTO_INCREMENT,
    rating_name VARCHAR(50) NOT NULL,
    lower_limit INT NOT NULL,
    PRIMARY KEY (id)
);

CREATE TABLE friendships (
    id INT NOT NULL AUTO_INCREMENT,
    user_one_id bigint(20) UNSIGNED NOT NULL,
    user_two_id bigint(20) UNSIGNED NOT NULL,
    PRIMARY KEY (id),
    FOREIGN KEY (user_one_id)
        REFERENCES users (id),
    FOREIGN KEY (user_two_id)
        REFERENCES users (id)
);

CREATE TABLE friend_requests (
    id INT NOT NULL AUTO_INCREMENT,
    user_one_id bigint(20) UNSIGNED NOT NULL,
    user_two_id bigint(20) UNSIGNED NOT NULL,
    PRIMARY KEY (id),
    FOREIGN KEY (user_one_id)
        REFERENCES users (id),
    FOREIGN KEY (user_two_id)
        REFERENCES users (id)
);


CREATE TABLE room_roles (
    id INT NOT NULL AUTO_INCREMENT,
    room_role_type VARCHAR(50),
    PRIMARY KEY (id)
);


CREATE TABLE rooms (
    id INT NOT NULL AUTO_INCREMENT,
    user_id bigint(20) UNSIGNED NOT NULL,
    name VARCHAR(100),
    PRIMARY KEY (id),
    FOREIGN KEY (user_id)
        REFERENCES users (id)
);

CREATE TABLE room_requests (
    id INT NOT NULL AUTO_INCREMENT,
    user_one_id bigint(20) UNSIGNED NOT NULL,
    user_two_id bigint(20) UNSIGNED NOT NULL,
    room_id INT NOT NULL,
    room_role_id INT NOT NULL,
    PRIMARY KEY (id),
    FOREIGN KEY (user_one_id)
        REFERENCES users (id),
    FOREIGN KEY (user_two_id)
        REFERENCES users (id),
    FOREIGN KEY (room_id)
        REFERENCES rooms (id),
    FOREIGN KEY (room_role_id)
        REFERENCES room_roles (id)
);

CREATE TABLE room_members (
    id INT NOT NULL AUTO_INCREMENT,
    user_id bigint(20) UNSIGNED NOT NULL,
    room_id int NOT NULL,
    PRIMARY KEY (id),
    FOREIGN KEY (room_id)
        REFERENCES rooms (id),
    FOREIGN KEY (user_id)
        REFERENCES users (id)
);

CREATE TABLE message_types (
    id INT NOT NULL AUTO_INCREMENT,
    message_type VARCHAR(50) NOT NULL,
    PRIMARY KEY (id)
);

CREATE TABLE room_messages (
    id INT NOT NULL AUTO_INCREMENT,
    user_id bigint(20) UNSIGNED NOT NULL,
    room_id INT NOT NULL,
    message VARCHAR(4000),
    message_type_id INT NOT NULL,
    PRIMARY KEY (id),
    FOREIGN KEY (room_id)
        REFERENCES rooms (id),
    FOREIGN KEY (user_id)
        REFERENCES users (id),
    FOREIGN KEY (message_type_id)
        REFERENCES message_types (id)
);

CREATE TABLE room_answers (
    id INT NOT NULL AUTO_INCREMENT,
    room_message_id INT NOT NULL,
    answer VARCHAR(4000),
    PRIMARY KEY (id),
    FOREIGN KEY (room_message_id)
        REFERENCES room_messages (id)
);


CREATE TABLE questions (
    id INT NOT NULL AUTO_INCREMENT,
    user_id bigint(20) UNSIGNED NOT NULL,
    question_content VARCHAR(4000),
    PRIMARY KEY (id),
    FOREIGN KEY (user_id)
        REFERENCES users (id)
);

CREATE TABLE answers (
    id INT NOT NULL AUTO_INCREMENT,
    question_id INT NOT NULL,
    answer VARCHAR(4000),
    PRIMARY KEY (id),
    FOREIGN KEY (question_id)
        REFERENCES questions (id)
);


CREATE TABLE answered_questions (
    id INT NOT NULL AUTO_INCREMENT,
    user_id bigint(20) UNSIGNED NOT NULL,
    question_id INT NOT NULL,
    PRIMARY KEY (id),
    FOREIGN KEY (question_id)
        REFERENCES questions (id),
    FOREIGN KEY (user_id)
        REFERENCES users (id)
);

CREATE TABLE tournament_statuses (
    id INT NOT NULL AUTO_INCREMENT,
    status VARCHAR(50),
    PRIMARY KEY (id)
);


CREATE TABLE tournaments (
    id INT NOT NULL AUTO_INCREMENT,
    tournament_name VARCHAR(100) NOT NULL,
    user_id bigint(20) UNSIGNED NOT NULL,
    start_time DATETIME NOT NULL,
    min_rating_type_id INT NOT NULL,
    max_rating_type_id INT NOT NULL,
    tournament_status_id INT NOT NULL,
    PRIMARY KEY (id),
    FOREIGN KEY (user_id)
        REFERENCES users (id),
    FOREIGN KEY (min_rating_type_id)
        REFERENCES rating_types (id),
    FOREIGN KEY (max_rating_type_id)
        REFERENCES rating_types (id),
    FOREIGN KEY (tournament_status_id)
        REFERENCES tournament_statuses (id)
);

CREATE TABLE tournament_questions (
    id INT NOT NULL AUTO_INCREMENT,
    question_id INT NOT NULL,
    tournament_id INT NOT NULL,
    PRIMARY KEY (id),
    FOREIGN KEY (question_id)
        REFERENCES questions (id),
    FOREIGN KEY (tournament_id)
        REFERENCES tournaments (id)
);


CREATE TABLE tournament_users (
    id INT NOT NULL AUTO_INCREMENT,
    user_id bigint(20) UNSIGNED NOT NULL,
    tournament_id INT NOT NULL,
    PRIMARY KEY (id),
    FOREIGN KEY (user_id)
        REFERENCES users (id),
    FOREIGN KEY (tournament_id)
        REFERENCES tournaments (id)
);