-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 24, 2025 at 09:16 PM
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
(2, 2, 15, 'Non aut suscipit aut', 'Consequuntur atque s', 66.00, '', 1, 'approved', '2025-09-19 06:36:42', '2025-09-24 08:08:04'),
(3, 2, 15, 'Eius tenetur rerum l', 'Dolore dolorem Nam s', 45.00, 'cashapp', 0, 'approved', '2025-09-19 06:42:43', '2025-09-19 07:02:28'),
(4, 2, 16, 'Occaecat ea aut veni', 'Omnis voluptatem te', 46.00, 'other', 1, 'approved', '2025-09-19 06:46:38', '2025-09-19 07:02:20'),
(5, 2, 22, 'Earum est aliquam l', 'Commodi commodo illo', 74.00, 'paypal', 1, 'approved', '2025-09-23 05:31:28', '2025-09-23 07:21:51'),
(6, 2, 22, 'Earum est aliquam l', 'Commodi commodo illo', 74.00, 'paypal', 1, 'pending', '2025-09-23 05:31:43', '2025-09-23 05:31:43'),
(7, 2, 22, 'Dolore corrupti sin', 'Iusto odio proident', 78.00, 'zelle', 0, 'pending', '2025-09-23 05:33:19', '2025-09-23 05:33:19');

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
  `type` int(11) DEFAULT 0 COMMENT '0=contribution, 1=shortfall',
  `note` text DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT 0 COMMENT '0=submitted, 1=approved,2=declined',
  `owner_remarks` text DEFAULT NULL,
  `is_deleted` int(11) NOT NULL DEFAULT 0 COMMENT '0=active, 1=deleted',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `bill_payments`
--

INSERT INTO `bill_payments` (`id`, `bills_id`, `payer_id`, `amount_paid`, `payment_method`, `confirmation_number`, `receipt_path`, `type`, `note`, `status`, `owner_remarks`, `is_deleted`, `created_at`, `updated_at`) VALUES
(1, 7, 22, 62.00, 'cashapp', 'Assumenda omnis amet', '1758583594ChatGPT Image Sep 22_ 2025_ 01_59_10 PM.png', 0, NULL, 0, NULL, 0, '2025-09-23 06:26:34', '2025-09-23 06:26:34'),
(3, 7, 22, 78.00, 'cashapp', '4343443', '1758586656ChatGPT Image Sep 22_ 2025_ 01_59_10 PM.png', 0, NULL, 0, NULL, 0, '2025-09-23 07:17:36', '2025-09-23 07:17:36'),
(4, 5, 22, 74.00, 'bank_transfer', '5666', '1758586895ChatGPT Image Sep 22_ 2025_ 01_59_10 PM.png', 0, NULL, 0, NULL, 0, '2025-09-23 07:21:35', '2025-09-23 07:21:35'),
(5, 1, 25, 57.00, 'cashapp', 'Sed beatae aliquam e', '1758676024image 2 (1) (1).png', 0, NULL, 0, NULL, 0, '2025-09-24 08:07:04', '2025-09-24 08:07:04'),
(6, 2, 25, 62.00, 'paypal', 'Voluptatum sunt et c', '1758676075image 2 (1) (1).png', 0, NULL, 0, NULL, 0, '2025-09-24 08:07:55', '2025-09-24 08:07:55'),
(7, 7, 25, 59.00, 'cashapp', 'Maiores qui quam a a', '1758735286image 2 (1) (1).png', 0, NULL, 0, NULL, 0, '2025-09-25 00:34:46', '2025-09-25 00:34:46'),
(8, 7, 25, 55.00, 'paypal', 'Ea nobis ad qui iust', '1758736496image 2 (1) (1).png', 0, NULL, 0, NULL, 0, '2025-09-25 00:54:56', '2025-09-25 00:54:56'),
(9, 7, 25, 55.00, 'paypal', 'Ea nobis ad qui iust', '1758736524image 2 (1) (1).png', 0, NULL, 0, NULL, 0, '2025-09-25 00:55:24', '2025-09-25 00:55:24'),
(10, 3, 25, 97.00, 'paypal', 'In delectus ducimus', '1758736540image 2 (1) (1).png', 0, NULL, 0, NULL, 0, '2025-09-25 00:55:40', '2025-09-25 00:55:40'),
(11, 6, 25, 39.00, 'zelle', 'Quod dolor velit qui', '1758736579image 2 (1) (1).png', 1, NULL, 0, NULL, 0, '2025-09-25 00:56:19', '2025-09-25 00:56:19');

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
-- Table structure for table `contributions`
--

CREATE TABLE `contributions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `family_owner_id` int(11) NOT NULL,
  `family_member_id` int(11) NOT NULL,
  `bill_id` int(11) DEFAULT NULL,
  `amount` decimal(10,2) NOT NULL,
  `type` varchar(255) NOT NULL DEFAULT 'contribution',
  `note` varchar(255) DEFAULT NULL,
  `is_deleted` int(11) NOT NULL DEFAULT 0 COMMENT '0=not deleted, 1=deleted',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
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
(1, 2, 2, 15, 'Facilis quis officia', 'Cillum repudiandae d', '2025-09-18 23:34:35', 'cancelled', NULL, 0, '2025-09-19 04:43:35', '2025-09-20 05:21:36'),
(2, 2, 2, 12, 'Pariatur Aut dolor', 'Eu mollit sint eaqu', '2025-09-23 20:33:58', 'pending', NULL, 0, '2025-09-19 04:52:58', '2025-09-19 04:52:58'),
(3, 2, 2, 12, 'Pariatur Aut dolor', 'Eu mollit sint eaqu', '2025-09-23 20:34:09', 'expired', NULL, 0, '2025-09-19 04:53:09', '2025-09-24 05:23:48'),
(4, 2, 2, 15, 'Dolores voluptas lab', 'Ut fugit voluptatem', '2025-09-19 12:39:18', 'cancelled', NULL, 1, '2025-09-19 05:09:18', '2025-09-20 05:21:30'),
(5, 2, 2, 22, 'Est ea ipsa porro', 'Doloribus ipsum exp', '2025-09-25 16:53:10', 'submitted', 1, 0, '2025-09-23 07:30:10', '2025-09-23 07:30:28'),
(6, 2, 2, 22, 'Culpa non eaque volu', 'Necessitatibus optio', '2025-09-28 12:11:09', 'pending', NULL, 0, '2025-09-24 02:12:09', '2025-09-24 02:12:09');

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

--
-- Dumping data for table `emergency_documents`
--

INSERT INTO `emergency_documents` (`id`, `uploader_id`, `original_name`, `disk_path`, `mime`, `size`, `is_private`, `created_at`, `updated_at`) VALUES
(1, 22, 'image 2 (1) (1).png', 'emergency_documents/WNZjIyxP1E79N75U1YCesDDHKCDy1P0yxFZ54GIy.png', 'image/png', 163331, 1, '2025-09-23 07:30:28', '2025-09-23 07:30:28');

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
-- Table structure for table `family_notes`
--

CREATE TABLE `family_notes` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `family_owner_id` int(11) NOT NULL,
  `family_member_id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `content` text NOT NULL,
  `type` enum('note','feedback') NOT NULL DEFAULT 'note',
  `visibility` enum('private','family') NOT NULL DEFAULT 'family',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
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
-- Table structure for table `meetings`
--

CREATE TABLE `meetings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `senior_id` bigint(20) UNSIGNED NOT NULL,
  `created_by` bigint(20) UNSIGNED NOT NULL,
  `topic` varchar(255) NOT NULL,
  `agenda` text DEFAULT NULL,
  `start_time` datetime NOT NULL,
  `duration` int(11) NOT NULL DEFAULT 30,
  `zoom_meeting_id` varchar(255) DEFAULT NULL,
  `join_url` text DEFAULT NULL,
  `start_url` text DEFAULT NULL,
  `status` enum('scheduled','cancelled','completed') NOT NULL DEFAULT 'scheduled',
  `is_deleted` int(11) NOT NULL DEFAULT 0 COMMENT '0=active, 1=deleted',
  `is_active` int(11) NOT NULL DEFAULT 0 COMMENT '0=active, 1=inactive',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `meetings`
--

INSERT INTO `meetings` (`id`, `senior_id`, `created_by`, `topic`, `agenda`, `start_time`, `duration`, `zoom_meeting_id`, `join_url`, `start_url`, `status`, `is_deleted`, `is_active`, `created_at`, `updated_at`) VALUES
(3, 22, 22, 'Nemo labore est eos', 'Officia in consequat', '2025-12-12 03:26:00', 70, '96549489616', 'https://zoom.us/j/96549489616?pwd=cQ3ZX1O5JcrrXwvodT9bVLxeePnjto.1', 'https://zoom.us/s/96549489616?zak=eyJ0eXAiOiJKV1QiLCJzdiI6IjAwMDAwMiIsInptX3NrbSI6InptX28ybSIsImFsZyI6IkhTMjU2In0.eyJpc3MiOiJ3ZWIiLCJjbHQiOjAsIm1udW0iOiI5NjU0OTQ4OTYxNiIsImF1ZCI6ImNsaWVudHNtIiwidWlkIjoiUk8wb3A3MHlTSy10Vko3dkZhNF81USIsInppZCI6IjU3ODBiMDlmMTA5ZTQ5ZGM5YTdlZDc3OWI4MjkyZjAxIiwic2siOiIwIiwic3R5IjoxMDAsIndjZCI6ImF3MSIsImV4cCI6MTc1ODU4Njk3NCwiaWF0IjoxNzU4NTc5Nzc0LCJhaWQiOiJJaGxmWndfYVRjbUpRWWhfRTZuNVVRIiwiY2lkIjoiIn0.LaJmqms_90yIPfpniKO3Sydzcx1aU7RQrGQCxzpf5nc', 'scheduled', 0, 1, '2025-09-23 05:22:54', '2025-09-24 02:15:54'),
(4, 22, 22, 'Qui consequatur Est', 'Enim commodo non eum', '1976-03-01 11:51:00', 97, '99518246255', 'https://zoom.us/j/99518246255?pwd=GwfwrysZobaa1cFz686sMjDG8Ij4VF.1', 'https://zoom.us/s/99518246255?zak=eyJ0eXAiOiJKV1QiLCJzdiI6IjAwMDAwMiIsInptX3NrbSI6InptX28ybSIsImFsZyI6IkhTMjU2In0.eyJpc3MiOiJ3ZWIiLCJjbHQiOjAsIm1udW0iOiI5OTUxODI0NjI1NSIsImF1ZCI6ImNsaWVudHNtIiwidWlkIjoiUk8wb3A3MHlTSy10Vko3dkZhNF81USIsInppZCI6IjU1ZmQ0MDYyZDQ2OTRjNzhiNmRhOTFjMzE4MzZhMTgzIiwic2siOiIwIiwic3R5IjoxMDAsIndjZCI6ImF3MSIsImV4cCI6MTc1ODY2MjE1MywiaWF0IjoxNzU4NjU0OTUzLCJhaWQiOiJJaGxmWndfYVRjbUpRWWhfRTZuNVVRIiwiY2lkIjoiIn0.VR4n4gMtuAjhyiyKoyvGVSeof-tNp0tJ6w9M8FzbDTg', 'scheduled', 0, 0, '2025-09-24 02:15:54', '2025-09-24 02:15:54');

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
(25, '2025_09_18_222105_create_bill_payments_table', 16),
(27, '2025_09_19_164228_create_family_notes_table', 17),
(28, '2025_09_19_173547_create_subscriptions_table', 18),
(29, '2025_09_19_174627_create_payment_methods_table', 18),
(30, '2025_09_22_182921_create_voice_journals_table', 19),
(31, '2025_09_22_205821_create_meetings_table', 20),
(32, '2025_09_23_233711_create_contributions_table', 21),
(33, '2025_09_24_185107_create_reimbursements_table', 22);

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
-- Table structure for table `payment_methods`
--

CREATE TABLE `payment_methods` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `family_owner_id` bigint(20) UNSIGNED NOT NULL,
  `card_last_four` varchar(4) NOT NULL,
  `card_brand` varchar(255) NOT NULL,
  `expiry_month` varchar(2) NOT NULL,
  `expiry_year` varchar(4) NOT NULL,
  `is_primary` tinyint(1) NOT NULL DEFAULT 0,
  `gateway_token` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
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
(11, 16, 'view_reports', '2025-09-17 01:36:53', '2025-09-17 01:36:53'),
(47, 15, 'view_bills', '2025-09-20 01:45:48', '2025-09-20 01:45:48'),
(48, 15, 'upload_docs', '2025-09-20 01:45:48', '2025-09-20 01:45:48'),
(49, 15, 'manage_caregivers', '2025-09-20 01:45:48', '2025-09-20 01:45:48'),
(50, 15, 'view_reports', '2025-09-20 01:45:48', '2025-09-20 01:45:48'),
(51, 15, 'manage_tasks', '2025-09-20 01:45:48', '2025-09-20 01:45:48'),
(52, 15, 'manage_family_members', '2025-09-20 01:45:48', '2025-09-20 01:45:48'),
(53, 15, 'manage_subscription', '2025-09-20 01:45:48', '2025-09-20 01:45:48'),
(54, 15, 'emergency_doc', '2025-09-20 01:45:48', '2025-09-20 01:45:48'),
(72, 22, 'view_bills', '2025-09-23 05:56:28', '2025-09-23 05:56:28'),
(73, 22, 'manage_tasks', '2025-09-23 05:56:28', '2025-09-23 05:56:28'),
(74, 22, 'manage_family_members', '2025-09-23 05:56:28', '2025-09-23 05:56:28'),
(75, 22, 'emergency_doc', '2025-09-23 05:56:28', '2025-09-23 05:56:28'),
(76, 24, 'upload_docs', '2025-09-24 01:02:29', '2025-09-24 01:02:29'),
(77, 24, 'manage_caregivers', '2025-09-24 01:02:29', '2025-09-24 01:02:29'),
(78, 24, 'view_reports', '2025-09-24 01:02:29', '2025-09-24 01:02:29'),
(79, 24, 'manage_tasks', '2025-09-24 01:02:29', '2025-09-24 01:02:29'),
(80, 25, 'manage_caregivers', '2025-09-24 01:47:29', '2025-09-24 01:47:29'),
(81, 25, 'view_reports', '2025-09-24 01:47:29', '2025-09-24 01:47:29'),
(82, 25, 'manage_tasks', '2025-09-24 01:47:29', '2025-09-24 01:47:29'),
(83, 25, 'manage_family_members', '2025-09-24 01:47:29', '2025-09-24 01:47:29');

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
  `is_deleted` int(11) NOT NULL DEFAULT 0 COMMENT '0=active, 1=delted',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `pools`
--

INSERT INTO `pools` (`id`, `owner_id`, `title`, `description`, `status`, `voting_expires_at`, `final_decision_by`, `final_decision_notes`, `is_deleted`, `created_at`, `updated_at`) VALUES
(1, 2, 'Eius officia est ab', 'Libero autem eu quidsdasad', 'final_decision', '2020-11-02 04:26:00', 2, 'dsa', 0, '2025-09-19 00:04:47', '2025-09-23 08:13:48'),
(2, 2, 'Pariatur Laborum A', 'Expedita labore Nam', 'final_decision', '2025-11-12 22:10:00', 2, 'dsa', 1, '2025-09-19 00:50:56', '2025-09-20 05:22:59'),
(3, 2, 'Et laboris in fugiat', 'Numquam dolorem tota', 'open', '2025-12-31 05:35:00', NULL, NULL, 1, '2025-09-19 00:59:56', '2025-09-19 03:55:18'),
(4, 2, 'Et ut eu nulla venia', 'Quis officiis magna', 'open', '2025-11-21 05:29:00', NULL, NULL, 1, '2025-09-19 01:13:16', '2025-09-19 03:54:58'),
(5, 2, 'Hic do minim minim q', 'Non repellendus Sun', 'final_decision', '2025-12-12 04:33:00', 2, 'dsad dsad', 0, '2025-09-20 05:42:02', '2025-09-20 05:43:38'),
(6, 2, 'Ipsa voluptatum aut', 'Et non ut dolore nih', 'open', '1978-10-17 22:59:00', NULL, NULL, 0, '2025-09-24 03:38:46', '2025-09-24 03:38:46'),
(7, 2, 'dsa', 'dasd', 'final_decision', '2025-09-27 12:22:00', 2, 'dsd', 0, '2025-09-24 06:27:50', '2025-09-24 06:33:49');

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
(2, 4, 2, 'yes', '123', '2025-09-19 01:15:44', '2025-09-19 03:39:53'),
(3, 5, 2, 'yes', NULL, '2025-09-20 05:42:33', '2025-09-20 05:42:33'),
(4, 7, 25, 'yes', NULL, '2025-09-24 06:32:53', '2025-09-24 06:32:53'),
(5, 7, 2, 'no', NULL, '2025-09-24 06:33:18', '2025-09-24 06:33:36');

-- --------------------------------------------------------

--
-- Table structure for table `reimbursements`
--

CREATE TABLE `reimbursements` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `family_member_id` bigint(20) UNSIGNED NOT NULL,
  `bill_id` bigint(20) UNSIGNED DEFAULT NULL,
  `amount` decimal(10,2) NOT NULL,
  `reason` varchar(255) DEFAULT NULL,
  `status` enum('pending','approved','declined') NOT NULL DEFAULT 'pending',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `reimbursements`
--

INSERT INTO `reimbursements` (`id`, `family_member_id`, `bill_id`, `amount`, `reason`, `status`, `created_at`, `updated_at`) VALUES
(1, 25, 1, 500.00, 'dssaddsd sda', 'pending', '2025-09-25 02:06:24', '2025-09-25 02:11:01');

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
(2, 22, 2, '1960-02-12', 'B-', 'male', 'Minima nostrum rerum', 'Repellendus Explica', 'Keaton Savage', '+1 (119) 605-4025', 1, 1, '2025-09-20 04:05:29', '2025-09-20 05:13:22'),
(3, 24, 23, '1970-09-14', 'A+', 'female', 'injury, and nonpathologic health issue', 'Dr. Smith', '+1 (568) 797-1451', '+1 (568) 797-1451', 1, 1, '2025-09-24 00:49:31', '2025-09-24 00:49:31');

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
('mZUQGpSotaRpEQ9CmMtYv8Q8hJd0MYEKoBhVhn1t', 25, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36', 'YTo1OntzOjY6Il90b2tlbiI7czo0MDoiV0VLV212SVdYSFBkOUc5bWFpMWk3dUJzWlJBT1dxbGlFaVh4c3BNZSI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6NTM6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9mYW1pbHlNZW1iZXIvcmVpbWJ1cnNtZW50L2luZGV4Ijt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo1MDoibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO2k6MjU7czo0OiJhdXRoIjthOjE6e3M6MjE6InBhc3N3b3JkX2NvbmZpcm1lZF9hdCI7aToxNzU4NzM0NDI1O319', 1758741258);

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
-- Table structure for table `subscriptions`
--

CREATE TABLE `subscriptions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `family_owner_id` bigint(20) UNSIGNED NOT NULL,
  `plan` varchar(255) NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `status` enum('active','expired','cancelled') NOT NULL DEFAULT 'active',
  `is_recurring` tinyint(1) NOT NULL DEFAULT 1,
  `payment_method_id` bigint(20) UNSIGNED DEFAULT NULL,
  `start_date` date NOT NULL,
  `end_date` date DEFAULT NULL,
  `payment_gateway` varchar(255) NOT NULL DEFAULT 'stripe',
  `transaction_id` varchar(255) DEFAULT NULL,
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
  `is_deleted` int(11) NOT NULL DEFAULT 0 COMMENT '0=active, 1=deleted',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tasks`
--

INSERT INTO `tasks` (`id`, `owner_id`, `assignee_id`, `title`, `type`, `details`, `status`, `is_deleted`, `created_at`, `updated_at`) VALUES
(1, 2, 15, 'Cillum nobis atque l', 'medical', 'Quisquam vitae quaesaas', 'pending', 1, '2025-09-17 03:02:51', '2025-09-20 05:19:53'),
(2, 2, 15, 'Cillum nobis atque l', 'medical', 'Quisquam vitae quae', 'completed', 0, '2025-09-17 03:03:23', '2025-09-17 03:03:23'),
(3, 2, 2, 'Nam placeat rerum i', 'non-medical', 'Libero soluta volupt', 'pending', 1, '2025-09-17 03:03:49', '2025-09-20 05:20:29'),
(4, 2, 12, 'Elit blanditiis opt', 'non-medical', NULL, 'pending', 0, '2025-09-24 03:39:48', '2025-09-24 03:39:48'),
(5, 2, 22, 'sdsd', 'medical', NULL, 'pending', 0, '2025-09-24 04:23:53', '2025-09-24 04:23:53');

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
(8, 2, 1, 22, '2025-09-20 04:05:29', '2025-09-20 04:05:29'),
(9, 23, 1, 24, '2025-09-24 00:49:31', '2025-09-24 00:49:31'),
(10, 2, 1, 25, '2025-09-24 01:47:29', '2025-09-24 01:47:29');

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
(22, 2, 'Marsden Miles', 'Document Requested', ' Marsden Miles Requested for Document to Keiko Robertson', '2025-09-19 05:09:18', '2025-09-19 05:09:18'),
(23, 2, 'Marsden Miles', 'Updated senior', ' Marsden Miles Updated Keiko Robertson as Senior ', '2025-09-20 01:16:30', '2025-09-20 01:16:30'),
(24, 2, 'Marsden Miles', 'Updated senior', ' Marsden Miles Updated Keiko Robertson as Senior ', '2025-09-20 01:16:49', '2025-09-20 01:16:49'),
(25, 2, 'Marsden Miles', 'Updated senior', ' Marsden Miles Updated Keiko Robertson as Senior ', '2025-09-20 01:17:02', '2025-09-20 01:17:02'),
(26, 2, 'Marsden Miles', 'Account Deleted', ' Marsden Miles Deleted account ofSeptember Carlson', '2025-09-20 01:17:36', '2025-09-20 01:17:36'),
(27, 2, 'Marsden Miles', 'Updated senior', ' Marsden Miles Updated Keiko Robertson as Senior ', '2025-09-20 01:35:39', '2025-09-20 01:35:39'),
(28, 2, 'Marsden Miles', 'Updated senior', ' Marsden Miles Updated Keiko Robertson as Senior ', '2025-09-20 01:40:51', '2025-09-20 01:40:51'),
(29, 2, 'Marsden Miles', 'Updated senior', ' Marsden Miles Updated Keiko Robertson as Senior ', '2025-09-20 01:41:10', '2025-09-20 01:41:10'),
(30, 2, 'Marsden Miles', 'Updated senior', ' Marsden Miles Updated Keiko Robertson as Senior ', '2025-09-20 01:45:35', '2025-09-20 01:45:35'),
(31, 2, 'Marsden Miles', 'Updated senior', ' Marsden Miles Updated Keiko Robertson as Senior ', '2025-09-20 01:45:48', '2025-09-20 01:45:48'),
(32, 2, 'Marsden Miles', 'Created senior', ' Marsden Miles Created Addison Morton as Senior ', '2025-09-20 02:07:55', '2025-09-20 02:07:55'),
(33, 2, 'Marsden Miles', 'Account Deleted', ' Marsden Miles Deleted account ofLeilani Schultz', '2025-09-20 03:49:26', '2025-09-20 03:49:26'),
(34, 2, 'Marsden Miles', 'Account Deleted', ' Marsden Miles Deleted account ofLeilani Schultz', '2025-09-20 03:49:35', '2025-09-20 03:49:35'),
(35, 2, 'Marsden Miles', 'Updated senior', ' Marsden Miles Updated Addison Morton as Senior ', '2025-09-20 04:01:33', '2025-09-20 04:01:33'),
(36, 2, 'Marsden Miles', 'Created senior', ' Marsden Miles Created Molly Sheppard as Senior ', '2025-09-20 04:05:29', '2025-09-20 04:05:29'),
(37, 2, 'Marsden Miles', 'Updated senior', ' Marsden Miles Updated Molly Sheppard as Senior ', '2025-09-20 04:06:05', '2025-09-20 04:06:05'),
(38, 2, 'Marsden Miles', 'Updated senior', ' Marsden Miles Updated Molly Sheppard as Senior ', '2025-09-20 04:07:19', '2025-09-20 04:07:19'),
(39, 2, 'Marsden Miles', 'Updated senior', ' Marsden Miles Updated Molly Sheppard as Senior ', '2025-09-20 04:17:21', '2025-09-20 04:17:21'),
(40, 2, 'Marsden Miles', 'Updated senior', ' Marsden Miles Updated Molly Sheppard as Senior ', '2025-09-20 04:17:35', '2025-09-20 04:17:35'),
(41, 2, 'Marsden Miles', 'Account Deleted', ' Marsden Miles Deleted account ofLeilani Schultz', '2025-09-20 04:22:23', '2025-09-20 04:22:23'),
(42, 2, 'Marsden Miles', 'Account Deleted', ' Marsden Miles Deleted account ofLeilani Schultz', '2025-09-20 04:24:08', '2025-09-20 04:24:08'),
(43, 2, 'Marsden Miles', 'Account Deleted', ' Marsden Miles Deleted account ofLeilani Schultz', '2025-09-20 04:27:12', '2025-09-20 04:27:12'),
(44, 2, 'Marsden Miles', 'Account Deleted', ' Marsden Miles Deleted account ofLeilani Schultz', '2025-09-20 04:30:43', '2025-09-20 04:30:43'),
(45, 2, 'Marsden Miles', 'Account Deleted', ' Marsden Miles Deleted account ofLeilani Schultz', '2025-09-20 04:30:53', '2025-09-20 04:30:53'),
(46, 2, 'Marsden Miles', 'Account Deleted', ' Marsden Miles Deleted account ofLeilani Schultz', '2025-09-20 04:47:29', '2025-09-20 04:47:29'),
(47, 2, 'Marsden Miles', 'Account Deleted', ' Marsden Miles Deleted account ofLeilani Schultz', '2025-09-20 05:00:28', '2025-09-20 05:00:28'),
(48, 2, 'Marsden Miles', 'Account Deleted', ' Marsden Miles Deleted account ofLeilani Schultz', '2025-09-20 05:00:40', '2025-09-20 05:00:40'),
(49, 2, 'Marsden Miles', 'Account Deleted', ' Marsden Miles Deleted account ofLeilani Schultz', '2025-09-20 05:02:15', '2025-09-20 05:02:15'),
(50, 2, 'Marsden Miles', 'Account Deleted', ' Marsden Miles Deleted account ofAddison Morton', '2025-09-20 05:04:39', '2025-09-20 05:04:39'),
(51, 2, 'Marsden Miles', 'Account Deleted', ' Marsden Miles Deleted account ofBrennan Stokes', '2025-09-20 05:04:44', '2025-09-20 05:04:44'),
(52, 2, 'Marsden Miles', 'Account Deleted', ' Marsden Miles Deleted account ofXaviera King', '2025-09-20 05:04:49', '2025-09-20 05:04:49'),
(53, 2, 'Marsden Miles', 'Updated senior', ' Marsden Miles Updated Molly Sheppard as Senior ', '2025-09-20 05:05:21', '2025-09-20 05:05:21'),
(54, 2, 'Marsden Miles', 'Updated senior', ' Marsden Miles Updated Molly Sheppard as Senior ', '2025-09-20 05:13:22', '2025-09-20 05:13:22'),
(55, 2, 'Marsden Miles', 'Task updated', ' Marsden Miles Updated Task forKeiko Robertson ', '2025-09-20 05:16:55', '2025-09-20 05:16:55'),
(56, 2, 'Marsden Miles', 'Task Deleted', ' Marsden Miles Deleted Task forKeiko Robertson ', '2025-09-20 05:19:53', '2025-09-20 05:19:53'),
(57, 2, 'Marsden Miles', 'Task Deleted', ' Marsden Miles Deleted Task forMarsden Miles ', '2025-09-20 05:20:29', '2025-09-20 05:20:29'),
(58, 2, 'Marsden Miles', 'Pool deleted', ' Marsden Miles Pool deleted', '2025-09-20 05:22:59', '2025-09-20 05:22:59'),
(59, 2, 'Marsden Miles', 'Updated Pool', ' Marsden Miles Updated Pool', '2025-09-20 05:23:23', '2025-09-20 05:23:23'),
(60, 2, 'Marsden Miles', 'Updated Pool', ' Marsden Miles Updated Pool', '2025-09-20 05:23:31', '2025-09-20 05:23:31'),
(61, 2, 'Marsden Miles', 'Updated Pool', ' Marsden Miles Updated Pool', '2025-09-20 05:26:43', '2025-09-20 05:26:43'),
(62, 2, 'Marsden Miles', 'Updated Pool', ' Marsden Miles Updated Pool', '2025-09-20 05:28:37', '2025-09-20 05:28:37'),
(63, 2, 'Marsden Miles', 'Updated Pool', ' Marsden Miles Updated Pool', '2025-09-20 05:29:33', '2025-09-20 05:29:33'),
(64, 2, 'Marsden Miles', 'Updated Pool', ' Marsden Miles Updated Pool', '2025-09-20 05:29:53', '2025-09-20 05:29:53'),
(65, 2, 'Marsden Miles', 'Updated Pool', ' Marsden Miles Updated Pool', '2025-09-20 05:30:15', '2025-09-20 05:30:15'),
(66, 2, 'Marsden Miles', 'Updated Pool', ' Marsden Miles Updated Pool', '2025-09-20 05:32:09', '2025-09-20 05:32:09'),
(67, 2, 'Marsden Miles', 'Updated Pool', ' Marsden Miles Updated Pool', '2025-09-20 05:34:17', '2025-09-20 05:34:17'),
(68, 2, 'Marsden Miles', 'Updated Pool', ' Marsden Miles Updated Pool', '2025-09-20 05:40:57', '2025-09-20 05:40:57'),
(69, 2, 'Marsden Miles', 'Updated Pool', ' Marsden Miles Updated Pool', '2025-09-20 05:41:06', '2025-09-20 05:41:06'),
(70, 2, 'Marsden Miles', 'Updated Pool', ' Marsden Miles Updated Pool', '2025-09-20 05:41:16', '2025-09-20 05:41:16'),
(71, 2, 'Marsden Miles', 'Created Pool', ' Marsden Miles Created Pool', '2025-09-20 05:42:02', '2025-09-20 05:42:02'),
(72, 2, 'Marsden Miles', 'Took final Decision', ' Marsden Miles Took final Decision', '2025-09-20 05:43:38', '2025-09-20 05:43:38'),
(73, 2, 'Marsden Miles', 'Updated senior', ' Marsden Miles Updated Molly Sheppard as Senior ', '2025-09-23 05:56:28', '2025-09-23 05:56:28'),
(74, 2, 'Marsden Miles', 'Document Requested', ' Marsden Miles Requested for Document to Molly Sheppard', '2025-09-23 07:30:10', '2025-09-23 07:30:10'),
(75, 2, 'Marsden Miles', 'Updated Pool', ' Marsden Miles Updated Pool', '2025-09-23 08:13:48', '2025-09-23 08:13:48'),
(76, 23, 'Richard family', 'Created senior', ' Richard family Created Hedwig Carroll as Senior ', '2025-09-24 00:49:31', '2025-09-24 00:49:31'),
(77, 23, 'Richard family', 'Updated senior', ' Richard family Updated Hedwig Carroll as Senior ', '2025-09-24 01:02:29', '2025-09-24 01:02:29'),
(78, 23, 'Richard family', 'Created Family member', ' Richard family Created Abel Hoover as Member ', '2025-09-24 01:47:29', '2025-09-24 01:47:29'),
(79, 2, 'Marsden Miles', 'Document Requested', ' Marsden Miles Requested for Document to Molly Sheppard', '2025-09-24 02:12:09', '2025-09-24 02:12:09'),
(80, 2, 'Marsden Miles', 'Created Pool', ' Marsden Miles Created Pool', '2025-09-24 03:38:47', '2025-09-24 03:38:47'),
(81, 2, 'Marsden Miles', 'Task created', ' Marsden Miles Created Task forMadeson Maxwell ', '2025-09-24 03:39:48', '2025-09-24 03:39:48'),
(82, 2, 'Marsden Miles', 'Task created', ' Marsden Miles Created Task forMolly Sheppard ', '2025-09-24 04:23:53', '2025-09-24 04:23:53'),
(83, 2, 'Marsden Miles', 'Created Pool', ' Marsden Miles Created Pool', '2025-09-24 06:27:50', '2025-09-24 06:27:50'),
(84, 2, 'Marsden Miles', 'Took final Decision', ' Marsden Miles Took final Decision', '2025-09-24 06:33:49', '2025-09-24 06:33:49'),
(85, 2, 'Abel Hoover', 'Added contribution', ' Abel Hoover Added contribution Shortfall ', '2025-09-25 00:55:24', '2025-09-25 00:55:24'),
(86, 2, 'Abel Hoover', 'Added contribution', ' Abel Hoover Added contribution Shortfall ', '2025-09-25 00:55:40', '2025-09-25 00:55:40'),
(87, 2, 'Abel Hoover', 'Added contribution', ' Abel Hoover Added contribution Shortfall ', '2025-09-25 00:56:19', '2025-09-25 00:56:19');

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
(15, 3, 'Keiko Robertson', '1758047763Halloween Pumpkin.jpg', 'qadasdsacyv@mailinator.com', NULL, '$2y$12$e4GEyouS.UMIz9QjXPwmKO3mzS3OzYPV.3cEQ.pTyEL02ook7vqTS', 0, NULL, '2025-09-17 01:36:03', '2025-09-17 01:36:03'),
(16, 3, 'September Carlson', '1758047813Halloween Pumpkin.jpg', 'xuzaw@mailinator.com', NULL, '$2y$12$vxWSZSflSPQDSWqDw7n08eLRM1Ct9M.oEEm0g7EY7D7KjyuLTioLy', 2, NULL, '2025-09-17 01:36:53', '2025-09-20 01:17:36'),
(17, 3, 'Leilani Schultz', '1758308765360_F_180705627_AAtisO2IRkSEDnG72u7Rvlj5LRJBNYPO.jpg', 'sydoru@mailinator.com', NULL, '$2y$12$ERtZmxmoY8PBxxpXqK4sI.FVeLjxkiqXnrhCNFc4rnbx786lNwiTu', 2, NULL, '2025-09-20 02:06:05', '2025-09-20 05:02:15'),
(18, 2, 'Addison Morton', '1758308875360_F_180705627_AAtisO2IRkSEDnG72u7Rvlj5LRJBNYPO.jpg', 'dukivo@mailinator.com', NULL, '$2y$12$Kvz85FkPmBi7YhU9xIVizuqdSzyKAZxHeCPD0zuUax/w0vFxhWPly', 2, NULL, '2025-09-20 02:07:55', '2025-09-20 05:04:39'),
(19, 2, 'Brennan Stokes', '1758315793360_F_180705627_AAtisO2IRkSEDnG72u7Rvlj5LRJBNYPO.jpg', 'tohibacywy@mailinator.com', NULL, '$2y$12$z6Iv6i4lGqVcrALrYoLUwOryiFBTMpiw0KhfCXm6Gt.WPwciVQ8uS', 2, NULL, '2025-09-20 04:03:13', '2025-09-20 05:04:44'),
(20, 2, 'Xaviera King', '1758315883360_F_180705627_AAtisO2IRkSEDnG72u7Rvlj5LRJBNYPO.jpg', 'xaxedykojo@mailinator.com', NULL, '$2y$12$9Y1LLl3KKCXVsDYnKrc8W.DkLxBmq.7xznOSFzDP9LiQTcu5LvIiG', 2, NULL, '2025-09-20 04:04:43', '2025-09-20 05:04:49'),
(22, 2, 'Molly Sheppard', '1758315928360_F_180705627_AAtisO2IRkSEDnG72u7Rvlj5LRJBNYPO.jpg', 'huly@mailinator.com', NULL, '$2y$12$e4GEyouS.UMIz9QjXPwmKO3mzS3OzYPV.3cEQ.pTyEL02ook7vqTS', 0, NULL, '2025-09-20 04:05:29', '2025-09-20 04:06:05'),
(23, 4, 'Richard family', 'user_not_found.png', 'richard@mailinator.com', NULL, '$2y$12$KN5aznQYAKGXWwJnn07XZeWDJzTCbmlJJjCsY7ZcMFSBCOozGUXsm', 0, NULL, '2025-09-24 00:33:42', '2025-09-24 00:33:42'),
(24, 2, 'Hedwig Carroll', '1758649770360_F_180705627_AAtisO2IRkSEDnG72u7Rvlj5LRJBNYPO.jpg', 'rishard_senior@mailinator.com', NULL, '$2y$12$23TPmDxNmfI1nwPHZjE5Lebx/nzl0ygsq.yeuI9ClnimZgh6PpXEa', 0, NULL, '2025-09-24 00:49:31', '2025-09-24 00:49:31'),
(25, 3, 'Abel Hoover', '1758653249c7c7573174dec94de506ee682526bddb1b9535de.png', 'richard_familymember@mailinator.com', NULL, '$2y$12$7PY1ohfUg1fl7yv4tU6Rt..FoYlcEN7FubmwQRS6RZQjmmI3rLR8G', 0, NULL, '2025-09-24 01:47:29', '2025-09-24 01:47:29');

-- --------------------------------------------------------

--
-- Table structure for table `voice_journals`
--

CREATE TABLE `voice_journals` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `senior_id` bigint(20) UNSIGNED NOT NULL,
  `created_by` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) DEFAULT NULL,
  `file_path` varchar(255) NOT NULL,
  `transcription` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `voice_journals`
--

INSERT INTO `voice_journals` (`id`, `senior_id`, `created_by`, `title`, `file_path`, `transcription`, `created_at`, `updated_at`) VALUES
(1, 22, 22, NULL, 'voice_journals/68d19c5481dc5.mp3', NULL, '2025-09-23 01:58:28', '2025-09-23 01:58:28'),
(2, 22, 22, NULL, 'voice_journals/68d19cf470cc4.mp3', NULL, '2025-09-23 02:01:08', '2025-09-23 02:01:08'),
(3, 22, 22, NULL, 'voice_journals/68d19d8cb528b.mp3', NULL, '2025-09-23 02:03:40', '2025-09-23 02:03:40'),
(4, 22, 22, NULL, 'voice_journals/68d19e1a2adc2.webm', NULL, '2025-09-23 02:06:02', '2025-09-23 02:06:02');

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
(12, 4, 2, 11, 'dsda', '2025-09-19 03:48:52', '2025-09-19 03:48:52'),
(13, 5, 2, NULL, 'dasd', '2025-09-20 05:43:16', '2025-09-20 05:43:16'),
(14, 5, 2, 13, 'dasdsa', '2025-09-20 05:43:24', '2025-09-20 05:43:24'),
(15, 5, 2, NULL, 'dsadd', '2025-09-20 05:43:31', '2025-09-20 05:43:31'),
(16, 7, 25, NULL, 'dsa', '2025-09-24 06:33:00', '2025-09-24 06:33:00'),
(17, 7, 2, NULL, 'adsdsa', '2025-09-24 06:33:43', '2025-09-24 06:33:43');

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
-- Indexes for table `contributions`
--
ALTER TABLE `contributions`
  ADD PRIMARY KEY (`id`);

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
-- Indexes for table `family_notes`
--
ALTER TABLE `family_notes`
  ADD PRIMARY KEY (`id`);

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
-- Indexes for table `meetings`
--
ALTER TABLE `meetings`
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
-- Indexes for table `payment_methods`
--
ALTER TABLE `payment_methods`
  ADD PRIMARY KEY (`id`);

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
-- Indexes for table `reimbursements`
--
ALTER TABLE `reimbursements`
  ADD PRIMARY KEY (`id`);

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
-- Indexes for table `subscriptions`
--
ALTER TABLE `subscriptions`
  ADD PRIMARY KEY (`id`);

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
-- Indexes for table `voice_journals`
--
ALTER TABLE `voice_journals`
  ADD PRIMARY KEY (`id`);

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
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `bill_payments`
--
ALTER TABLE `bill_payments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `contributions`
--
ALTER TABLE `contributions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `document_requests`
--
ALTER TABLE `document_requests`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `document_responses`
--
ALTER TABLE `document_responses`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `emergency_documents`
--
ALTER TABLE `emergency_documents`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `family_notes`
--
ALTER TABLE `family_notes`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

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
-- AUTO_INCREMENT for table `meetings`
--
ALTER TABLE `meetings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT for table `payment_methods`
--
ALTER TABLE `payment_methods`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `permissions`
--
ALTER TABLE `permissions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=84;

--
-- AUTO_INCREMENT for table `pools`
--
ALTER TABLE `pools`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `pool_votings`
--
ALTER TABLE `pool_votings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `reimbursements`
--
ALTER TABLE `reimbursements`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `seniors`
--
ALTER TABLE `seniors`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `settings`
--
ALTER TABLE `settings`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `subscriptions`
--
ALTER TABLE `subscriptions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tasks`
--
ALTER TABLE `tasks`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `task_comments`
--
ALTER TABLE `task_comments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `tenants`
--
ALTER TABLE `tenants`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `timeline_logs`
--
ALTER TABLE `timeline_logs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=88;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `voice_journals`
--
ALTER TABLE `voice_journals`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `voting_comments`
--
ALTER TABLE `voting_comments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

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
