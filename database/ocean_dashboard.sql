-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 19, 2025 at 06:07 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ocean_dashboard`
--

-- --------------------------------------------------------

--
-- Table structure for table `bills`
--

CREATE TABLE `bills` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `owner_id` bigint(20) UNSIGNED NOT NULL,
  `assigned_to` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `details` text NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `payment_method` varchar(122) NOT NULL,
  `type` int(11) NOT NULL,
  `status` varchar(112) NOT NULL DEFAULT 'pending',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `bills`
--

INSERT INTO `bills` (`id`, `owner_id`, `assigned_to`, `title`, `details`, `amount`, `payment_method`, `type`, `status`, `created_at`, `updated_at`) VALUES
(1, 2, 15, 'Non aut suscipit aut', 'Consequuntur atque s', 66.00, '', 1, 'declined', '2025-09-19 06:36:23', '2025-09-19 07:02:32'),
(2, 2, 15, 'Non aut suscipit aut', 'Consequuntur atque s', 66.00, '', 1, 'pending', '2025-09-19 06:36:42', '2025-09-19 06:36:42'),
(3, 2, 15, 'Eius tenetur rerum l', 'Dolore dolorem Nam s', 45.00, 'cashapp', 0, 'approved', '2025-09-19 06:42:43', '2025-09-19 07:02:28'),
(4, 2, 16, 'Occaecat ea aut veni', 'Omnis voluptatem te', 46.00, 'other', 1, 'approved', '2025-09-19 06:46:38', '2025-09-19 07:02:20');

-- --------------------------------------------------------

--
-- Table structure for table `bill_payments`
--

CREATE TABLE `bill_payments` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `bills_id` bigint(20) UNSIGNED NOT NULL,
  `payer_id` bigint(20) UNSIGNED NOT NULL,
  `amount_paid` decimal(10,2) NOT NULL,
  `payment_method` varchar(255) NOT NULL,
  `confirmation_number` varchar(255) NOT NULL,
  `receipt_path` varchar(255) NOT NULL,
  `status` enum('submitted','approved','declined') NOT NULL DEFAULT 'submitted',
  `owner_remarks` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `document_requests`
--

CREATE TABLE `document_requests` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `family_owner_id` int(11) NOT NULL,
  `requester_id` int(11) NOT NULL,
  `target_user_id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `message` text DEFAULT NULL,
  `expires_at` datetime NOT NULL,
  `status` enum('pending','submitted','expired','cancelled') NOT NULL DEFAULT 'pending',
  `document_id` int(11) DEFAULT NULL,
  `type` int(11) NOT NULL DEFAULT 0 COMMENT '0=normal doc, 1=medical',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `document_requests`
--

INSERT INTO `document_requests` (`id`, `family_owner_id`, `requester_id`, `target_user_id`, `title`, `message`, `expires_at`, `status`, `document_id`, `type`, `created_at`, `updated_at`) VALUES
(1, 2, 2, 15, 'Facilis quis officia', 'Cillum repudiandae d', '2025-09-18 23:34:35', 'pending', NULL, 0, '2025-09-19 04:43:35', '2025-09-19 04:43:35'),
(2, 2, 2, 12, 'Pariatur Aut dolor', 'Eu mollit sint eaqu', '2025-09-23 20:33:58', 'pending', NULL, 0, '2025-09-19 04:52:58', '2025-09-19 04:52:58'),
(3, 2, 2, 12, 'Pariatur Aut dolor', 'Eu mollit sint eaqu', '2025-09-23 20:34:09', 'pending', NULL, 0, '2025-09-19 04:53:09', '2025-09-19 04:53:09'),
(4, 2, 2, 15, 'Dolores voluptas lab', 'Ut fugit voluptatem', '2025-09-19 12:39:18', 'pending', NULL, 1, '2025-09-19 05:09:18', '2025-09-19 05:09:18');

-- --------------------------------------------------------

--
-- Table structure for table `document_responses`
--

CREATE TABLE `document_responses` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `request_id` bigint(20) UNSIGNED NOT NULL,
  `uploader_id` bigint(20) UNSIGNED NOT NULL,
  `original_name` varchar(255) NOT NULL,
  `disk_path` varchar(255) NOT NULL,
  `mime` varchar(255) DEFAULT NULL,
  `size` bigint(20) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `emergency_documents`
--

CREATE TABLE `emergency_documents` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uploader_id` int(11) NOT NULL,
  `original_name` varchar(255) NOT NULL,
  `disk_path` varchar(255) NOT NULL,
  `mime` varchar(255) DEFAULT NULL,
  `size` bigint(20) UNSIGNED DEFAULT NULL,
  `is_private` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `family_owners`
--

CREATE TABLE `family_owners` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `plan` enum('standard','family_plus') NOT NULL DEFAULT 'standard',
  `owner_id` bigint(20) UNSIGNED NOT NULL,
  `primary_senior_id` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `family_owners`
--

INSERT INTO `family_owners` (`id`, `name`, `plan`, `owner_id`, `primary_senior_id`, `created_at`, `updated_at`) VALUES
(1, 'test', 'standard', 2, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `queue` varchar(255) NOT NULL,
  `payload` longtext NOT NULL,
  `attempts` tinyint(3) UNSIGNED NOT NULL,
  `reserved_at` int(10) UNSIGNED DEFAULT NULL,
  `available_at` int(10) UNSIGNED NOT NULL,
  `created_at` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `job_batches`
--

CREATE TABLE `job_batches` (
  `id` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `total_jobs` int(11) NOT NULL,
  `pending_jobs` int(11) NOT NULL,
  `failed_jobs` int(11) NOT NULL,
  `failed_job_ids` longtext NOT NULL,
  `options` mediumtext DEFAULT NULL,
  `cancelled_at` int(11) DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `finished_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1),
(4, '2015_08_04_131614_create_settings_table', 1),
(5, '2025_09_08_211109_create_tenants_table', 2),
(6, '2025_09_08_232249_create_seniors_table', 3),
(7, '2025_09_08_233000_create_roles_table', 4),
(8, '2025_09_08_232021_create_family_owners_table', 5),
(9, '2025_09_15_201313_create_permissions_table', 6),
(10, '2025_09_15_203134_create_timeline_logs_table', 7),
(11, '2025_09_15_205545_create_tenants_table', 8),
(14, '2025_09_16_193741_create_tasks_table', 9),
(15, '2025_09_16_193923_create_task_comments_table', 9),
(17, '2025_09_16_232342_create_emergency_documents_table', 11),
(18, '2025_09_18_001632_create_pools_table', 12),
(19, '2025_09_18_001647_create_pool_votings_table', 12),
(20, '2025_09_18_001846_create_voting_comments_table', 12),
(22, '2025_09_18_212045_create_document_responses_table', 14),
(23, '2025_09_16_232327_create_document_requests_table', 15),
(24, '2025_09_18_222032_create_bills_table', 16),
(25, '2025_09_18_222105_create_bill_payments_table', 16);

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `permissions`
--

CREATE TABLE `permissions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` int(11) NOT NULL,
  `feature_name` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `permissions`
--

INSERT INTO `permissions` (`id`, `user_id`, `feature_name`, `created_at`, `updated_at`) VALUES
(8, 12, 'upload_docs', '2025-09-17 00:14:51', '2025-09-17 00:14:51'),
(9, 12, 'manage_caregivers', '2025-09-17 00:14:51', '2025-09-17 00:14:51'),
(10, 16, 'upload_docs', '2025-09-17 01:36:53', '2025-09-17 01:36:53'),
(11, 16, 'view_reports', '2025-09-17 01:36:53', '2025-09-17 01:36:53');

-- --------------------------------------------------------

--
-- Table structure for table `pools`
--

CREATE TABLE `pools` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `owner_id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `status` enum('open','closed','final_decision') NOT NULL DEFAULT 'open',
  `voting_expires_at` datetime DEFAULT NULL,
  `final_decision_by` bigint(20) UNSIGNED DEFAULT NULL,
  `final_decision_notes` text DEFAULT NULL,
  `is_deleted` int(11) NOT NULL COMMENT '0=active, 1=delted',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `pools`
--

INSERT INTO `pools` (`id`, `owner_id`, `title`, `description`, `status`, `voting_expires_at`, `final_decision_by`, `final_decision_notes`, `is_deleted`, `created_at`, `updated_at`) VALUES
(1, 2, 'Eius officia est ab', 'Libero autem eu qui', 'final_decision', '2020-11-02 04:26:00', 2, 'dsa', 0, '2025-09-19 00:04:47', '2025-09-19 00:49:20'),
(2, 2, 'Pariatur Laborum A', 'Expedita labore Nam', 'final_decision', '2025-11-12 22:10:00', 2, 'dsa', 0, '2025-09-19 00:50:56', '2025-09-19 00:58:10'),
(3, 2, 'Et laboris in fugiat', 'Numquam dolorem tota', 'open', '2025-12-31 05:35:00', NULL, NULL, 1, '2025-09-19 00:59:56', '2025-09-19 03:55:18'),
(4, 2, 'Et ut eu nulla venia', 'Quis officiis magna', 'open', '2025-11-21 05:29:00', NULL, NULL, 1, '2025-09-19 01:13:16', '2025-09-19 03:54:58');

-- --------------------------------------------------------

--
-- Table structure for table `pool_votings`
--

CREATE TABLE `pool_votings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `pool_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `choice` enum('yes','no','abstain') NOT NULL,
  `comment` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `pool_votings`
--

INSERT INTO `pool_votings` (`id`, `pool_id`, `user_id`, `choice`, `comment`, `created_at`, `updated_at`) VALUES
(1, 3, 2, 'yes', NULL, '2025-09-19 01:07:09', '2025-09-19 01:07:09'),
(2, 4, 2, 'yes', '123', '2025-09-19 01:15:44', '2025-09-19 03:39:53');

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `name`, `created_at`, `updated_at`) VALUES
(1, 'superAdmin', NULL, NULL),
(2, 'Senior', NULL, NULL),
(3, 'familyMember', NULL, NULL),
(4, 'familyOwner', NULL, NULL),
(5, 'CareGiver', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `seniors`
--

CREATE TABLE `seniors` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `family_owner_id` bigint(20) UNSIGNED NOT NULL,
  `dob` date DEFAULT NULL,
  `blood_type` varchar(122) NOT NULL,
  `gender` varchar(255) DEFAULT NULL,
  `medical_condition` varchar(255) DEFAULT NULL,
  `primary_doctor` varchar(255) DEFAULT NULL,
  `emergency_contact_name` varchar(255) DEFAULT NULL,
  `emergency_contact_phone` varchar(255) DEFAULT NULL,
  `has_dementia` tinyint(1) NOT NULL DEFAULT 0,
  `has_alzheimer` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `seniors`
--

INSERT INTO `seniors` (`id`, `user_id`, `family_owner_id`, `dob`, `blood_type`, `gender`, `medical_condition`, `primary_doctor`, `emergency_contact_name`, `emergency_contact_phone`, `has_dementia`, `has_alzheimer`, `created_at`, `updated_at`) VALUES
(6, 12, 2, '1998-06-24', 'AB-', 'male', 'Natus aut nihil vel', 'Saepe voluptatibus a', 'Kellie Medina', '+1 (711) 803-9724', 1, 1, '2025-09-16 04:00:00', '2025-09-16 04:00:00'),
(7, 16, 2, '1981-05-23', 'AB positive', 'female', 'Tempor debitis dolor', 'Eveniet amet minim', 'Mercedes Sheppard', '+1 (568) 797-1451', 1, 1, '2025-09-17 01:36:53', '2025-09-17 01:36:53');

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` longtext NOT NULL,
  `last_activity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('UEwCiPC0QJcNA0gnZmaH3aMWNL54jGzlHdJWOp9k', 2, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36', 'YTo1OntzOjY6Il90b2tlbiI7czo0MDoidm8yd3pDWWFwOTZVWVIwZms0WWJkU1RzMjZEZHpZUDZDVlFwRmZKVyI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6NDM6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9mYW1pbHlPd25lci9kYXNoYm9hcmQiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX1zOjUwOiJsb2dpbl93ZWJfNTliYTM2YWRkYzJiMmY5NDAxNTgwZjAxNGM3ZjU4ZWE0ZTMwOTg5ZCI7aToyO3M6NDoiYXV0aCI7YToxOntzOjIxOiJwYXNzd29yZF9jb25maXJtZWRfYXQiO2k6MTc1ODIxMzM4OTt9fQ==', 1758243419);

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

CREATE TABLE `settings` (
  `id` int(10) UNSIGNED NOT NULL,
  `key` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` varchar(255) DEFAULT NULL,
  `value` text DEFAULT NULL,
  `field` text NOT NULL,
  `active` tinyint(4) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tasks`
--

CREATE TABLE `tasks` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `owner_id` int(11) NOT NULL,
  `assignee_id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `type` enum('medical','non-medical') NOT NULL,
  `details` text DEFAULT NULL,
  `status` enum('pending','in_progress','completed') NOT NULL DEFAULT 'pending',
  `is_deleted` int(11) NOT NULL COMMENT '0=active, 1=deleted',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tasks`
--

INSERT INTO `tasks` (`id`, `owner_id`, `assignee_id`, `title`, `type`, `details`, `status`, `is_deleted`, `created_at`, `updated_at`) VALUES
(1, 2, 15, 'Cillum nobis atque l', 'medical', 'Quisquam vitae quae', 'pending', 0, '2025-09-17 03:02:51', '2025-09-17 06:02:04'),
(2, 2, 15, 'Cillum nobis atque l', 'medical', 'Quisquam vitae quae', 'pending', 0, '2025-09-17 03:03:23', '2025-09-17 03:03:23'),
(3, 2, 2, 'Nam placeat rerum i', 'non-medical', 'Libero soluta volupt', 'pending', 0, '2025-09-17 03:03:49', '2025-09-17 03:03:49');

-- --------------------------------------------------------

--
-- Table structure for table `task_comments`
--

CREATE TABLE `task_comments` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `task_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `parent_id` int(11) DEFAULT NULL,
  `message` text NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `task_comments`
--

INSERT INTO `task_comments` (`id`, `task_id`, `user_id`, `parent_id`, `message`, `created_at`, `updated_at`) VALUES
(1, 1, 2, 0, 'this is comment', '2025-09-17 05:29:24', '2025-09-17 05:29:24'),
(2, 1, 2, 0, 'dasd', '2025-09-17 05:31:02', '2025-09-17 05:31:02'),
(3, 1, 2, 0, 'dasd', '2025-09-17 05:31:24', '2025-09-17 05:31:24'),
(4, 1, 2, 0, 'ds', '2025-09-17 05:31:51', '2025-09-17 05:31:51'),
(5, 1, 2, 1, 'this is reply', '2025-09-17 05:34:13', '2025-09-17 05:34:13'),
(6, 1, 2, 4, 'reply 2', '2025-09-17 05:34:22', '2025-09-17 05:34:22'),
(7, 1, 2, 5, 'this', '2025-09-17 05:34:33', '2025-09-17 05:34:33');

-- --------------------------------------------------------

--
-- Table structure for table `tenants`
--

CREATE TABLE `tenants` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `owner_id` int(11) NOT NULL,
  `owner_has_child` int(11) NOT NULL DEFAULT 0 COMMENT '0=no child, 1 has child',
  `child_id` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tenants`
--

INSERT INTO `tenants` (`id`, `owner_id`, `owner_has_child`, `child_id`, `created_at`, `updated_at`) VALUES
(1, 2, 1, 12, '2025-09-16 04:00:00', '2025-09-16 04:00:00'),
(2, 2, 1, 15, '2025-09-17 01:36:04', '2025-09-17 01:36:04'),
(3, 2, 1, 16, '2025-09-17 01:36:53', '2025-09-17 01:36:53');

-- --------------------------------------------------------

--
-- Table structure for table `timeline_logs`
--

CREATE TABLE `timeline_logs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `family_owner_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `action_name` varchar(255) NOT NULL,
  `action_desc` text NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `timeline_logs`
--

INSERT INTO `timeline_logs` (`id`, `family_owner_id`, `name`, `action_name`, `action_desc`, `created_at`, `updated_at`) VALUES
(1, 2, 'Marsden Miles', 'Created senior', '', '2025-09-16 03:37:12', '2025-09-16 03:37:12'),
(2, 2, 'Marsden Miles', 'Created senior', '', '2025-09-16 04:00:00', '2025-09-16 04:00:00'),
(3, 2, 'Marsden Miles', 'Updated senior', '', '2025-09-17 00:08:25', '2025-09-17 00:08:25'),
(4, 2, 'Marsden Miles', 'Updated senior', '', '2025-09-17 00:09:47', '2025-09-17 00:09:47'),
(5, 2, 'Marsden Miles', 'Updated senior', '', '2025-09-17 00:10:17', '2025-09-17 00:10:17'),
(6, 2, 'Marsden Miles', 'Updated senior', '', '2025-09-17 00:10:43', '2025-09-17 00:10:43'),
(7, 2, 'Marsden Miles', 'Updated senior', '', '2025-09-17 00:13:31', '2025-09-17 00:13:31'),
(8, 2, 'Marsden Miles', 'Updated senior', '', '2025-09-17 00:13:55', '2025-09-17 00:13:55'),
(9, 2, 'Marsden Miles', 'Updated senior', '', '2025-09-17 00:14:13', '2025-09-17 00:14:13'),
(10, 2, 'Marsden Miles', 'Updated senior', '', '2025-09-17 00:14:37', '2025-09-17 00:14:37'),
(11, 2, 'Marsden Miles', 'Updated senior', '', '2025-09-17 00:14:45', '2025-09-17 00:14:45'),
(12, 2, 'Marsden Miles', 'Updated senior', '', '2025-09-17 00:14:51', '2025-09-17 00:14:51'),
(13, 2, 'Marsden Miles', 'Created senior', ' Marsden Miles Created September Carlson as Senior ', '2025-09-17 01:36:53', '2025-09-17 01:36:53'),
(14, 2, 'Marsden Miles', 'Updated Account Status', ' Marsden Miles Updated Madeson Maxwell Account status as Active ', '2025-09-17 01:42:23', '2025-09-17 01:42:23'),
(15, 2, 'Marsden Miles', 'Task updated', ' Marsden Miles Updated Task forKim Valentine ', '2025-09-17 06:01:39', '2025-09-17 06:01:39'),
(16, 2, 'Marsden Miles', 'Task updated', ' Marsden Miles Updated Task forSeptember Carlson ', '2025-09-17 06:02:04', '2025-09-17 06:02:04'),
(17, 2, 'Marsden Miles', 'Pool deleted', ' Marsden Miles Pool deleted', '2025-09-19 03:54:58', '2025-09-19 03:54:58'),
(18, 2, 'Marsden Miles', 'Pool deleted', ' Marsden Miles Pool deleted', '2025-09-19 03:55:18', '2025-09-19 03:55:18'),
(19, 2, 'Marsden Miles', 'Document Requested', ' Marsden Miles Requested for Document to Keiko Robertson', '2025-09-19 04:43:35', '2025-09-19 04:43:35'),
(20, 2, 'Marsden Miles', 'Document Requested', ' Marsden Miles Requested for Document to Madeson Maxwell', '2025-09-19 04:52:58', '2025-09-19 04:52:58'),
(21, 2, 'Marsden Miles', 'Document Requested', ' Marsden Miles Requested for Document to Madeson Maxwell', '2025-09-19 04:53:09', '2025-09-19 04:53:09'),
(22, 2, 'Marsden Miles', 'Document Requested', ' Marsden Miles Requested for Document to Keiko Robertson', '2025-09-19 05:09:18', '2025-09-19 05:09:18');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `role_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `d_pic` varchar(122) NOT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `account_status` int(11) NOT NULL DEFAULT 0 COMMENT '0=active, 1=inactive, 2=deleted',
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `role_id`, `name`, `d_pic`, `email`, `email_verified_at`, `password`, `account_status`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 1, 'Kim Valentine', '', 'admin@admin.com', NULL, '$2y$12$e4GEyouS.UMIz9QjXPwmKO3mzS3OzYPV.3cEQ.pTyEL02ook7vqTS', 0, NULL, '2025-09-05 00:19:48', '2025-09-05 00:19:48'),
(2, 4, 'Marsden Miles', '1758042891c7c7573174dec94de506ee682526bddb1b9535de.png', 'family_owner@familyowner.com', NULL, '$2y$12$e4GEyouS.UMIz9QjXPwmKO3mzS3OzYPV.3cEQ.pTyEL02ook7vqTS', 0, NULL, '2025-09-05 00:20:44', '2025-09-05 00:20:44'),
(12, 3, 'Madeson Maxwell', '1758042891c7c7573174dec94de506ee682526bddb1b9535de.png', 'xywepa@mailinator.com', NULL, '$2y$12$DttHJLZAGFpdNxaMyZTQCeiNGSayoPtGMSjdJUzFGU/TZtcNC5sti', 0, NULL, '2025-09-16 04:00:00', '2025-09-17 01:42:23'),
(15, 3, 'Keiko Robertson', '1758047763Halloween Pumpkin.jpg', 'qacyv@mailinator.com', NULL, '$2y$12$GFvjqAXk44yQ6FWZkklITOJqg7H1/gN9NI526i6wtpfph5eKe6RDW', 0, NULL, '2025-09-17 01:36:03', '2025-09-17 01:36:03'),
(16, 3, 'September Carlson', '1758047813Halloween Pumpkin.jpg', 'xuzaw@mailinator.com', NULL, '$2y$12$vxWSZSflSPQDSWqDw7n08eLRM1Ct9M.oEEm0g7EY7D7KjyuLTioLy', 0, NULL, '2025-09-17 01:36:53', '2025-09-17 01:36:53');

-- --------------------------------------------------------

--
-- Table structure for table `voting_comments`
--

CREATE TABLE `voting_comments` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `pool_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `parent_id` bigint(20) UNSIGNED DEFAULT NULL,
  `message` text NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `voting_comments`
--

INSERT INTO `voting_comments` (`id`, `pool_id`, `user_id`, `parent_id`, `message`, `created_at`, `updated_at`) VALUES
(1, 1, 2, 2, 'dsadadsa', '2025-09-19 00:39:04', '2025-09-19 00:39:04'),
(2, 2, 2, 2, 'dsd', '2025-09-19 00:57:58', '2025-09-19 00:57:58'),
(3, 4, 2, 2, 'dff', '2025-09-19 01:46:47', '2025-09-19 01:46:47'),
(4, 2, 2, 2, 'dasddsa', '2025-09-19 01:49:06', '2025-09-19 01:49:06'),
(5, 2, 2, 2, 'dasddsa', '2025-09-19 01:49:26', '2025-09-19 01:49:26'),
(6, 2, 2, 2, 'sdds', '2025-09-19 01:56:38', '2025-09-19 01:56:38'),
(7, 4, 2, 2, 'sadd', '2025-09-19 02:11:12', '2025-09-19 02:11:12'),
(8, 4, 2, 2, 'sadd', '2025-09-19 02:11:20', '2025-09-19 02:11:20'),
(9, 4, 2, 2, 'asdsa', '2025-09-19 02:12:39', '2025-09-19 02:12:39'),
(10, 4, 2, 2, 'dsd', '2025-09-19 03:38:59', '2025-09-19 03:38:59'),
(11, 4, 2, NULL, 'dsdsd', '2025-09-19 03:47:11', '2025-09-19 03:47:11'),
(12, 4, 2, 11, 'dsda', '2025-09-19 03:48:52', '2025-09-19 03:48:52');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `bills`
--
ALTER TABLE `bills`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `bill_payments`
--
ALTER TABLE `bill_payments`
  ADD PRIMARY KEY (`id`);

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
-- Indexes for table `document_requests`
--
ALTER TABLE `document_requests`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `document_responses`
--
ALTER TABLE `document_responses`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `emergency_documents`
--
ALTER TABLE `emergency_documents`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `family_owners`
--
ALTER TABLE `family_owners`
  ADD PRIMARY KEY (`id`),
  ADD KEY `family_owners_owner_id_foreign` (`owner_id`),
  ADD KEY `family_owners_primary_senior_id_foreign` (`primary_senior_id`);

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
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `permissions`
--
ALTER TABLE `permissions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pools`
--
ALTER TABLE `pools`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pool_votings`
--
ALTER TABLE `pool_votings`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `pool_votings_voting_pool_id_user_id_unique` (`pool_id`,`user_id`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `seniors`
--
ALTER TABLE `seniors`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `senoirs_user_id_unique` (`user_id`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indexes for table `settings`
--
ALTER TABLE `settings`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `settings_key_unique` (`key`);

--
-- Indexes for table `tasks`
--
ALTER TABLE `tasks`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `task_comments`
--
ALTER TABLE `task_comments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tenants`
--
ALTER TABLE `tenants`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `timeline_logs`
--
ALTER TABLE `timeline_logs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- Indexes for table `voting_comments`
--
ALTER TABLE `voting_comments`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `bills`
--
ALTER TABLE `bills`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `bill_payments`
--
ALTER TABLE `bill_payments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `document_requests`
--
ALTER TABLE `document_requests`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `document_responses`
--
ALTER TABLE `document_responses`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `emergency_documents`
--
ALTER TABLE `emergency_documents`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `family_owners`
--
ALTER TABLE `family_owners`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `permissions`
--
ALTER TABLE `permissions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `pools`
--
ALTER TABLE `pools`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `pool_votings`
--
ALTER TABLE `pool_votings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `seniors`
--
ALTER TABLE `seniors`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `settings`
--
ALTER TABLE `settings`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tasks`
--
ALTER TABLE `tasks`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `task_comments`
--
ALTER TABLE `task_comments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `tenants`
--
ALTER TABLE `tenants`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `timeline_logs`
--
ALTER TABLE `timeline_logs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `voting_comments`
--
ALTER TABLE `voting_comments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `family_owners`
--
ALTER TABLE `family_owners`
  ADD CONSTRAINT `family_owners_owner_id_foreign` FOREIGN KEY (`owner_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `family_owners_primary_senior_id_foreign` FOREIGN KEY (`primary_senior_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `seniors`
--
ALTER TABLE `seniors`
  ADD CONSTRAINT `senoirs_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
