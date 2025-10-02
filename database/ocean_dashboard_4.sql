-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 02, 2025 at 02:44 AM
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
-- Database: `ocean_dashboard_new`
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
-- Table structure for table `events`
--

CREATE TABLE `events` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `type` enum('vacation','outing') NOT NULL DEFAULT 'outing',
  `description` text DEFAULT NULL,
  `start_date` date NOT NULL,
  `end_date` date DEFAULT NULL,
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
(33, '2025_09_24_185107_create_reimbursements_table', 22),
(34, '2025_09_24_212300_create_vacations_table', 23),
(35, '2025_09_24_212318_create_vacation_users_table', 23),
(36, '2025_09_26_175748_create_events_table', 23),
(37, '2025_09_29_181556_add_need_help_status_to_tasks_table', 23);

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
(1, 2, 'bills_insert', '2025-10-02 01:38:08', '2025-10-02 01:38:08'),
(2, 2, 'bills_update', '2025-10-02 01:38:08', '2025-10-02 01:38:08'),
(3, 2, 'bills_delete', '2025-10-02 01:38:08', '2025-10-02 01:38:08'),
(4, 2, 'bills_show', '2025-10-02 01:38:08', '2025-10-02 01:38:08'),
(5, 2, 'bill_payments_insert', '2025-10-02 01:38:08', '2025-10-02 01:38:08'),
(6, 2, 'bill_payments_update', '2025-10-02 01:38:08', '2025-10-02 01:38:08'),
(7, 2, 'bill_payments_delete', '2025-10-02 01:38:08', '2025-10-02 01:38:08'),
(8, 2, 'bill_payments_show', '2025-10-02 01:38:08', '2025-10-02 01:38:08'),
(9, 2, 'contributions_insert', '2025-10-02 01:38:08', '2025-10-02 01:38:08'),
(10, 2, 'contributions_update', '2025-10-02 01:38:08', '2025-10-02 01:38:08'),
(11, 2, 'contributions_delete', '2025-10-02 01:38:08', '2025-10-02 01:38:08'),
(12, 2, 'contributions_show', '2025-10-02 01:38:08', '2025-10-02 01:38:08'),
(13, 2, 'reimbursements_insert', '2025-10-02 01:38:08', '2025-10-02 01:38:08'),
(14, 2, 'reimbursements_update', '2025-10-02 01:38:08', '2025-10-02 01:38:08'),
(15, 2, 'reimbursements_delete', '2025-10-02 01:38:08', '2025-10-02 01:38:08'),
(16, 2, 'reimbursements_show', '2025-10-02 01:38:08', '2025-10-02 01:38:08'),
(17, 2, 'documents_insert', '2025-10-02 01:38:08', '2025-10-02 01:38:08'),
(18, 2, 'documents_update', '2025-10-02 01:38:08', '2025-10-02 01:38:08'),
(19, 2, 'documents_delete', '2025-10-02 01:38:08', '2025-10-02 01:38:08'),
(20, 2, 'documents_show', '2025-10-02 01:38:08', '2025-10-02 01:38:08'),
(21, 2, 'medical_docs_insert', '2025-10-02 01:38:08', '2025-10-02 01:38:08'),
(22, 2, 'medical_docs_update', '2025-10-02 01:38:08', '2025-10-02 01:38:08'),
(23, 2, 'medical_docs_delete', '2025-10-02 01:38:09', '2025-10-02 01:38:09'),
(24, 2, 'medical_docs_show', '2025-10-02 01:38:09', '2025-10-02 01:38:09'),
(25, 2, 'insurance_docs_insert', '2025-10-02 01:38:09', '2025-10-02 01:38:09'),
(26, 2, 'insurance_docs_update', '2025-10-02 01:38:09', '2025-10-02 01:38:09'),
(27, 2, 'insurance_docs_delete', '2025-10-02 01:38:09', '2025-10-02 01:38:09'),
(28, 2, 'insurance_docs_show', '2025-10-02 01:38:09', '2025-10-02 01:38:09'),
(29, 2, 'emergency_docs_insert', '2025-10-02 01:38:09', '2025-10-02 01:38:09'),
(30, 2, 'emergency_docs_update', '2025-10-02 01:38:09', '2025-10-02 01:38:09'),
(31, 2, 'emergency_docs_delete', '2025-10-02 01:38:09', '2025-10-02 01:38:09'),
(32, 2, 'emergency_docs_show', '2025-10-02 01:38:09', '2025-10-02 01:38:09'),
(33, 2, 'caregivers_insert', '2025-10-02 01:38:09', '2025-10-02 01:38:09'),
(34, 2, 'caregivers_update', '2025-10-02 01:38:09', '2025-10-02 01:38:09'),
(35, 2, 'caregivers_delete', '2025-10-02 01:38:09', '2025-10-02 01:38:09'),
(36, 2, 'caregivers_show', '2025-10-02 01:38:09', '2025-10-02 01:38:09'),
(37, 2, 'reports_insert', '2025-10-02 01:38:09', '2025-10-02 01:38:09'),
(38, 2, 'reports_update', '2025-10-02 01:38:09', '2025-10-02 01:38:09'),
(39, 2, 'reports_delete', '2025-10-02 01:38:09', '2025-10-02 01:38:09'),
(40, 2, 'reports_show', '2025-10-02 01:38:09', '2025-10-02 01:38:09'),
(41, 2, 'tasks_insert', '2025-10-02 01:38:09', '2025-10-02 01:38:09'),
(42, 2, 'tasks_update', '2025-10-02 01:38:09', '2025-10-02 01:38:09'),
(43, 2, 'tasks_delete', '2025-10-02 01:38:09', '2025-10-02 01:38:09'),
(44, 2, 'tasks_show', '2025-10-02 01:38:09', '2025-10-02 01:38:09'),
(45, 2, 'members_insert', '2025-10-02 01:38:09', '2025-10-02 01:38:09'),
(46, 2, 'members_update', '2025-10-02 01:38:09', '2025-10-02 01:38:09'),
(47, 2, 'members_delete', '2025-10-02 01:38:09', '2025-10-02 01:38:09'),
(48, 2, 'members_show', '2025-10-02 01:38:09', '2025-10-02 01:38:09'),
(49, 2, 'subscription_insert', '2025-10-02 01:38:09', '2025-10-02 01:38:09'),
(50, 2, 'subscription_update', '2025-10-02 01:38:09', '2025-10-02 01:38:09'),
(51, 2, 'subscription_delete', '2025-10-02 01:38:09', '2025-10-02 01:38:09'),
(52, 2, 'subscription_show', '2025-10-02 01:38:09', '2025-10-02 01:38:09'),
(53, 2, 'payment_methods_insert', '2025-10-02 01:38:09', '2025-10-02 01:38:09'),
(54, 2, 'payment_methods_update', '2025-10-02 01:38:09', '2025-10-02 01:38:09'),
(55, 2, 'payment_methods_delete', '2025-10-02 01:38:09', '2025-10-02 01:38:09'),
(56, 2, 'payment_methods_show', '2025-10-02 01:38:09', '2025-10-02 01:38:09'),
(57, 2, 'family_notes_insert', '2025-10-02 01:38:09', '2025-10-02 01:38:09'),
(58, 2, 'family_notes_update', '2025-10-02 01:38:09', '2025-10-02 01:38:09'),
(59, 2, 'family_notes_delete', '2025-10-02 01:38:09', '2025-10-02 01:38:09'),
(60, 2, 'family_notes_show', '2025-10-02 01:38:09', '2025-10-02 01:38:09'),
(61, 2, 'voice_journals_insert', '2025-10-02 01:38:09', '2025-10-02 01:38:09'),
(62, 2, 'voice_journals_update', '2025-10-02 01:38:09', '2025-10-02 01:38:09'),
(63, 2, 'voice_journals_delete', '2025-10-02 01:38:09', '2025-10-02 01:38:09'),
(64, 2, 'voice_journals_show', '2025-10-02 01:38:09', '2025-10-02 01:38:09'),
(65, 2, 'meetings_insert', '2025-10-02 01:38:09', '2025-10-02 01:38:09'),
(66, 2, 'meetings_update', '2025-10-02 01:38:09', '2025-10-02 01:38:09'),
(67, 2, 'meetings_delete', '2025-10-02 01:38:09', '2025-10-02 01:38:09'),
(68, 2, 'meetings_show', '2025-10-02 01:38:09', '2025-10-02 01:38:09'),
(69, 2, 'events_insert', '2025-10-02 01:38:09', '2025-10-02 01:38:09'),
(70, 2, 'events_update', '2025-10-02 01:38:09', '2025-10-02 01:38:09'),
(71, 2, 'events_delete', '2025-10-02 01:38:09', '2025-10-02 01:38:09'),
(72, 2, 'events_show', '2025-10-02 01:38:09', '2025-10-02 01:38:09'),
(73, 2, 'vacations_insert', '2025-10-02 01:38:09', '2025-10-02 01:38:09'),
(74, 2, 'vacations_update', '2025-10-02 01:38:09', '2025-10-02 01:38:09'),
(75, 2, 'vacations_delete', '2025-10-02 01:38:09', '2025-10-02 01:38:09'),
(76, 2, 'vacations_show', '2025-10-02 01:38:09', '2025-10-02 01:38:09'),
(77, 2, 'pools_insert', '2025-10-02 01:38:09', '2025-10-02 01:38:09'),
(78, 2, 'pools_update', '2025-10-02 01:38:09', '2025-10-02 01:38:09'),
(79, 2, 'pools_delete', '2025-10-02 01:38:09', '2025-10-02 01:38:09'),
(80, 2, 'pools_show', '2025-10-02 01:38:09', '2025-10-02 01:38:09'),
(81, 2, 'daily_updates_insert', '2025-10-02 01:38:09', '2025-10-02 01:38:09'),
(82, 2, 'daily_updates_update', '2025-10-02 01:38:09', '2025-10-02 01:38:09'),
(83, 2, 'daily_updates_delete', '2025-10-02 01:38:09', '2025-10-02 01:38:09'),
(84, 2, 'daily_updates_show', '2025-10-02 01:38:09', '2025-10-02 01:38:09'),
(85, 3, 'reimbursements_insert', '2025-10-02 02:16:02', '2025-10-02 02:16:02'),
(86, 3, 'reimbursements_update', '2025-10-02 02:16:02', '2025-10-02 02:16:02'),
(87, 3, 'reimbursements_delete', '2025-10-02 02:16:02', '2025-10-02 02:16:02'),
(88, 3, 'reimbursements_show', '2025-10-02 02:16:02', '2025-10-02 02:16:02');

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
(1, 3, 1, '1985-12-25', 'A+', 'male', 'Tempor debitis dolor', 'Eveniet amet minim', '+1 (568) 797-1451', '+1 (568) 797-1451', 1, 1, '2025-10-02 02:16:02', '2025-10-02 02:16:02');

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
  `status` enum('pending','in_progress','completed','need_outside_help') NOT NULL DEFAULT 'pending',
  `is_deleted` int(11) NOT NULL DEFAULT 0 COMMENT '0=active, 1=deleted',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tasks`
--

INSERT INTO `tasks` (`id`, `owner_id`, `assignee_id`, `title`, `type`, `details`, `status`, `is_deleted`, `created_at`, `updated_at`) VALUES
(1, 1, 2, 'Soluta omnis consect', 'non-medical', 'Expedita aut error q', 'pending', 0, '2025-10-02 02:16:57', '2025-10-02 02:16:57');

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
(1, 1, 1, 2, '2025-10-02 01:38:08', '2025-10-02 01:38:08'),
(2, 1, 1, 3, '2025-10-02 02:16:02', '2025-10-02 02:16:02');

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
(1, 1, 'Family owner', 'Created Family member', ' Family owner Created Rogan Gould as Member ', '2025-10-02 01:38:09', '2025-10-02 01:38:09'),
(2, 1, 'Family owner', 'Created senior', ' Family owner Created senior as Senior ', '2025-10-02 02:16:02', '2025-10-02 02:16:02'),
(3, 1, 'Family owner', 'Created Family member', ' Family owner Created senior as Member ', '2025-10-02 02:16:02', '2025-10-02 02:16:02');

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
(1, 4, 'Family owner', 'user_not_found.png', 'family_owner@familyowner.com', NULL, '$2y$12$TmLIAKZmFcTKbvq9aTGXWuBtnnSUle9Y..yp8EfbvKJIYFrYZGnhi', 0, NULL, '2025-10-02 00:50:02', '2025-10-02 00:50:02'),
(2, 3, 'Rogan Gould', '1759343888ChatGPT Image Sep 22_ 2025_ 01_59_10 PM.png', 'family_member1@familymember.com', NULL, '$2y$12$suFVmqJPvbLO8JDxeSFWhe14o4tqsAU1iIrlBKVJEuyeHx2nY26Ce', 0, NULL, '2025-10-02 01:38:08', '2025-10-02 01:38:08'),
(3, 2, 'senior', '1759346162ChatGPT Image Sep 22_ 2025_ 01_59_10 PM.png', 'senior@senior.com', NULL, '$2y$12$ioFQeb5qsFcuDdXpc5qXQ.H4q9W09gHQ5oWD.NMynFg/xexg4IMsS', 0, NULL, '2025-10-02 02:16:02', '2025-10-02 02:16:02');

-- --------------------------------------------------------

--
-- Table structure for table `vacations`
--

CREATE TABLE `vacations` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `start_date` date NOT NULL,
  `end_date` date DEFAULT NULL,
  `type` enum('vacation','outing') NOT NULL DEFAULT 'outing',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `vacation_users`
--

CREATE TABLE `vacation_users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `vacation_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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
-- Indexes for table `events`
--
ALTER TABLE `events`
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
-- Indexes for table `vacations`
--
ALTER TABLE `vacations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `vacation_users`
--
ALTER TABLE `vacation_users`
  ADD PRIMARY KEY (`id`);

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
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `bill_payments`
--
ALTER TABLE `bill_payments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `contributions`
--
ALTER TABLE `contributions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `document_requests`
--
ALTER TABLE `document_requests`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

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
-- AUTO_INCREMENT for table `events`
--
ALTER TABLE `events`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `family_notes`
--
ALTER TABLE `family_notes`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `family_owners`
--
ALTER TABLE `family_owners`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `meetings`
--
ALTER TABLE `meetings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- AUTO_INCREMENT for table `payment_methods`
--
ALTER TABLE `payment_methods`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `permissions`
--
ALTER TABLE `permissions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=89;

--
-- AUTO_INCREMENT for table `pools`
--
ALTER TABLE `pools`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `pool_votings`
--
ALTER TABLE `pool_votings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `reimbursements`
--
ALTER TABLE `reimbursements`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `seniors`
--
ALTER TABLE `seniors`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

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
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `task_comments`
--
ALTER TABLE `task_comments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tenants`
--
ALTER TABLE `tenants`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `timeline_logs`
--
ALTER TABLE `timeline_logs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `vacations`
--
ALTER TABLE `vacations`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `vacation_users`
--
ALTER TABLE `vacation_users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `voice_journals`
--
ALTER TABLE `voice_journals`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `voting_comments`
--
ALTER TABLE `voting_comments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

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
