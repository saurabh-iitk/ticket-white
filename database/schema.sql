-- phpMyAdmin SQL Dump - Split File
-- Original: u634575380_ops26.sql
-- Database: u634575380_ops26

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

-- SCHEMA STRUCTURE (CREATE TABLE, ALTER TABLE, indexes, constraints)

-- Table structure for table `bookings`
--

CREATE TABLE `bookings` (
  `id` int(11) NOT NULL,
  `is_feedback_sent` enum('YES','NO','INVALID_NO','ERROR') NOT NULL DEFAULT 'NO',
  `invoice_no` varchar(50) DEFAULT NULL,
  `feedback_value` varchar(255) DEFAULT NULL,
  `feedback_comment` text DEFAULT NULL,
  `seat_details` text DEFAULT NULL,
  `booking_id_str` varchar(20) DEFAULT NULL,
  `bms_id` varchar(30) DEFAULT NULL,
  `ip` varchar(100) DEFAULT NULL,
  `vendor_id` int(11) DEFAULT NULL,
  `event_id` int(11) NOT NULL,
  `event_schedule_id` int(11) NOT NULL,
  `event_schedule_list_id` int(11) NOT NULL,
  `event_show_time_id` int(11) NOT NULL,
  `venue_id` int(11) NOT NULL,
  `layout_id` int(11) NOT NULL,
  `booking_amount` decimal(10,2) DEFAULT NULL,
  `paid_amount` decimal(10,2) DEFAULT NULL,
  `is_gst_applicable` tinyint(1) DEFAULT 0,
  `taxable_amount` decimal(10,2) DEFAULT 0.00,
  `cgst_value` decimal(10,2) DEFAULT NULL,
  `sgst_value` decimal(10,2) DEFAULT NULL,
  `igst_value` decimal(10,2) DEFAULT NULL,
  `cgst_percent` decimal(10,2) DEFAULT NULL,
  `sgst_percent` decimal(10,2) DEFAULT NULL,
  `igst_percent` decimal(10,2) DEFAULT NULL,
  `gst_amount` decimal(10,2) DEFAULT 0.00,
  `total_quantity` int(11) NOT NULL DEFAULT 0,
  `grand_total` decimal(10,2) NOT NULL,
  `discount` decimal(10,2) DEFAULT NULL,
  `booking_code` text DEFAULT NULL,
  `booking_date` date DEFAULT NULL,
  `booking_time` varchar(255) DEFAULT NULL,
  `payment_status` enum('PAID','PARTIAL','PENDING') NOT NULL DEFAULT 'PAID',
  `booking_source_id` int(11) DEFAULT NULL,
  `customer_id` int(11) DEFAULT NULL,
  `state` varchar(200) DEFAULT NULL,
  `payment_method_id` int(11) DEFAULT NULL,
  `status` enum('ACTIVE','INACTIVE') DEFAULT 'ACTIVE',
  `is_whatsapp_sent` enum('NO','YES') NOT NULL DEFAULT 'NO',
  `is_email_sent` enum('NO','YES') NOT NULL DEFAULT 'NO',
  `issued_by` varchar(100) DEFAULT NULL,
  `guest_designation` varchar(100) DEFAULT NULL,
  `utm_source` varchar(1000) DEFAULT NULL,
  `utm_medium` varchar(1000) DEFAULT NULL,
  `utm_campaign` varchar(1000) DEFAULT NULL,
  `utm_content` varchar(1000) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

--
-- Table structure for table `booking_details`
--

CREATE TABLE `booking_details` (
  `id` int(11) NOT NULL,
  `booking_id` int(11) NOT NULL,
  `venue_id` int(11) NOT NULL,
  `seat_id` int(11) NOT NULL,
  `ticket_type_id` int(11) DEFAULT NULL,
  `quantity` int(11) DEFAULT 1,
  `base_price` decimal(10,2) DEFAULT NULL,
  `discount` decimal(10,2) DEFAULT NULL,
  `gst_applicable` tinyint(1) DEFAULT 0,
  `taxable_price` decimal(10,2) DEFAULT 0.00,
  `gst_price` decimal(10,2) DEFAULT 0.00,
  `seat_no` varchar(255) NOT NULL,
  `row_id` int(11) NOT NULL,
  `row_name` varchar(255) DEFAULT NULL,
  `col_id` int(11) NOT NULL,
  `col_name` varchar(255) DEFAULT NULL,
  `status` enum('ACTIVE','INACTIVE') NOT NULL DEFAULT 'ACTIVE',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  `is_scanned` tinyint(1) NOT NULL DEFAULT 0,
  `scan_time` datetime DEFAULT NULL,
  `scanned_by` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

--
-- Table structure for table `booking_payments`
--

CREATE TABLE `booking_payments` (
  `id` int(11) NOT NULL,
  `booking_id` int(11) NOT NULL,
  `payment_method_id` int(11) NOT NULL,
  `reference_no` varchar(255) NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `discount` decimal(10,2) DEFAULT 0.00,
  `note` text DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

--
-- Table structure for table `booking_platform`
--

CREATE TABLE `booking_platform` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `status` enum('ACTIVE','INACTIVE') NOT NULL DEFAULT 'ACTIVE',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cancelled_bookings`
--

CREATE TABLE `cancelled_bookings` (
  `id` int(11) NOT NULL,
  `ticket_type_id` int(11) NOT NULL,
  `quantity` int(10) NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `discount` decimal(10,2) NOT NULL DEFAULT 0.00,
  `seat_details` text DEFAULT NULL,
  `user_id` varchar(50) NOT NULL COMMENT 'cancelled by',
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

--
-- Table structure for table `cart`
--

CREATE TABLE `cart` (
  `id` int(11) NOT NULL,
  `seat_id` int(11) NOT NULL,
  `event_schedule_list_id` int(11) NOT NULL,
  `event_show_time_id` int(11) NOT NULL,
  `ticket_type_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL DEFAULT 1,
  `rate` decimal(10,2) NOT NULL,
  `discount` decimal(10,2) DEFAULT NULL,
  `status` enum('ACTIVE','INACTIVE') NOT NULL DEFAULT 'ACTIVE',
  `user_id` int(11) DEFAULT 0,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cities`
--

CREATE TABLE `cities` (
  `id` int(11) NOT NULL,
  `state_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `status` enum('ACTIVE','INACTIVE') NOT NULL DEFAULT 'ACTIVE',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

--
-- Table structure for table `company`
--

CREATE TABLE `company` (
  `id` int(11) NOT NULL,
  `state_id` int(11) NOT NULL,
  `city_id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `address` varchar(500) DEFAULT NULL,
  `pincode` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `website` varchar(50) DEFAULT NULL,
  `contact_person` varchar(255) DEFAULT NULL,
  `gst_no` varchar(16) DEFAULT NULL,
  `registered_address` varchar(500) DEFAULT NULL,
  `category` varchar(30) DEFAULT NULL,
  `helpline` varchar(10) DEFAULT NULL,
  `logo` varchar(500) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `status` enum('ACTIVE','INACTIVE') NOT NULL DEFAULT 'ACTIVE',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `configuration`
--

CREATE TABLE `configuration` (
  `id` int(11) NOT NULL,
  `email` varchar(50) NOT NULL,
  `status` enum('ACTIVE','INACTIVE') NOT NULL DEFAULT 'ACTIVE',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `coupons`
--

CREATE TABLE `coupons` (
  `id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  `coupon_code` varchar(20) NOT NULL,
  `is_used` enum('NO','YES') NOT NULL DEFAULT 'NO',
  `status` enum('ACTIVE','INACTIVE') NOT NULL DEFAULT 'ACTIVE',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `coupons_category`
--

CREATE TABLE `coupons_category` (
  `id` int(11) NOT NULL,
  `event_id` int(11) NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  `discount_value` int(11) NOT NULL,
  `discount_unit` int(11) NOT NULL,
  `valid_from` datetime NOT NULL,
  `valid_till` datetime NOT NULL,
  `max_order_value` int(11) NOT NULL,
  `max_discount_value` int(11) NOT NULL,
  `is_redeemable` enum('YES','NO') NOT NULL DEFAULT 'YES',
  `status` enum('ACTIVE','INACTIVE') NOT NULL DEFAULT 'ACTIVE',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `customers`
--

CREATE TABLE `customers` (
  `id` int(11) NOT NULL,
  `mobile_no` varchar(15) NOT NULL,
  `customer_name` varchar(255) NOT NULL,
  `email` varchar(255) DEFAULT NULL,
  `coupon_code` varchar(255) DEFAULT NULL,
  `status` enum('ACTIVE','INACTIVE') NOT NULL DEFAULT 'ACTIVE',
  `user_id` int(11) DEFAULT 0,
  `vendor_id` int(11) DEFAULT 0,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Table structure for table `customer_cart`
--

CREATE TABLE `customer_cart` (
  `id` int(11) NOT NULL,
  `event_id` int(11) DEFAULT NULL,
  `seat_id` int(11) NOT NULL,
  `event_schedule_list_id` int(11) NOT NULL,
  `event_show_time_id` int(11) NOT NULL,
  `ticket_type_id` int(11) NOT NULL,
  `utm_source` varchar(1000) DEFAULT NULL,
  `utm_medium` varchar(1000) DEFAULT NULL,
  `utm_campaign` varchar(1000) DEFAULT NULL,
  `utm_content` varchar(1000) DEFAULT NULL,
  `quantity` int(11) NOT NULL DEFAULT 1,
  `rate` decimal(10,2) NOT NULL,
  `discount` decimal(10,2) DEFAULT NULL,
  `status` enum('ACTIVE','INACTIVE') NOT NULL DEFAULT 'ACTIVE',
  `user_id` varchar(50) DEFAULT '0',
  `is_hold_for_booking` enum('NO','YES') NOT NULL DEFAULT 'NO',
  `hold_on` datetime DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  `layout_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Table structure for table `events`
--

CREATE TABLE `events` (
  `id` int(11) NOT NULL,
  `state_id` int(11) NOT NULL,
  `state` varchar(200) DEFAULT NULL,
  `event_state` varchar(200) DEFAULT NULL,
  `city_id` int(11) NOT NULL,
  `gst_name` varchar(100) DEFAULT NULL,
  `gst_no` varchar(16) DEFAULT NULL,
  `invoice_prefix` varchar(10) DEFAULT NULL,
  `venue_id` int(11) NOT NULL,
  `sub_venue_id` int(11) NOT NULL,
  `organizer_id` int(11) NOT NULL,
  `event_title` varchar(255) NOT NULL,
  `event_title_ticket` varchar(255) DEFAULT NULL,
  `event_description` text DEFAULT NULL,
  `start_date` date DEFAULT NULL,
  `end_date` date DEFAULT NULL,
  `event_banner` varchar(255) DEFAULT NULL,
  `event_video` varchar(255) DEFAULT NULL,
  `event_type` enum('SINGLE_DAY','RECURRING') NOT NULL DEFAULT 'SINGLE_DAY',
  `gst_address` varchar(500) DEFAULT NULL,
  `recurring_type` enum('DAILY','ALTERNATIVE','WEEKLY','MONTHLY') NOT NULL DEFAULT 'DAILY',
  `event_category` enum('COMEDY','CONFERENCE','LIVE_PERFORMANCE','MAGIC_SHOW','OTHER') NOT NULL DEFAULT 'OTHER',
  `is_published` enum('YES','NO') NOT NULL DEFAULT 'NO',
  `show_hide_time` varchar(20) NOT NULL DEFAULT '+30',
  `status` enum('ACTIVE','INACTIVE') NOT NULL DEFAULT 'ACTIVE',
  `is_default` enum('YES','NO') NOT NULL DEFAULT 'NO',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

--
-- Table structure for table `event_schedule`
--

CREATE TABLE `event_schedule` (
  `id` int(11) NOT NULL,
  `event_id` int(11) NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `status` enum('ACTIVE','INACTIVE') NOT NULL DEFAULT 'ACTIVE',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

--
-- Table structure for table `event_schedule_list`
--

CREATE TABLE `event_schedule_list` (
  `id` int(11) NOT NULL,
  `event_id` int(11) NOT NULL,
  `event_schedule_id` int(11) NOT NULL,
  `event_date` date NOT NULL,
  `event_datetime` datetime DEFAULT NULL,
  `status` enum('ACTIVE','INACTIVE') NOT NULL DEFAULT 'ACTIVE',
  `allow_online_booking` enum('YES','NO') NOT NULL DEFAULT 'YES',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

--
-- Table structure for table `event_seat`
--

CREATE TABLE `event_seat` (
  `id` int(11) NOT NULL,
  `event_id` int(11) NOT NULL,
  `event_schedule_list_id` int(11) DEFAULT NULL,
  `event_show_time_id` int(11) DEFAULT NULL,
  `event_ticket_id` int(11) NOT NULL,
  `event_ticket_type_id` int(11) DEFAULT NULL,
  `total_ticket` int(11) DEFAULT NULL,
  `base_price` decimal(10,2) DEFAULT NULL,
  `ticket_regular_price` decimal(10,2) DEFAULT NULL,
  `ticket_offer_price` decimal(10,2) DEFAULT NULL,
  `total_discount` decimal(10,2) DEFAULT 0.00,
  `payment_method_id` int(11) DEFAULT NULL,
  `layout_id` int(11) NOT NULL,
  `row_no` int(11) DEFAULT NULL,
  `col_no` int(11) DEFAULT NULL,
  `name` varchar(30) DEFAULT NULL,
  `label` varchar(10) DEFAULT NULL,
  `uniqueid` varchar(100) DEFAULT NULL,
  `seatno` varchar(10) DEFAULT NULL,
  `is_reserved_for_customer` enum('YES','NO') NOT NULL DEFAULT 'NO',
  `is_reserved` enum('NO','YES') DEFAULT 'NO',
  `is_damaged` enum('YES','NO') NOT NULL DEFAULT 'NO',
  `is_visible` enum('NO','YES') DEFAULT 'YES',
  `is_removed` enum('YES','NO') NOT NULL DEFAULT 'NO',
  `is_labeled` enum('YES','NO') NOT NULL DEFAULT 'NO',
  `is_grouping_allowed` enum('ALLOWED','BLOCKED') NOT NULL DEFAULT 'ALLOWED',
  `is_complimentary` enum('ALLOWED','BLOCKED') NOT NULL DEFAULT 'ALLOWED',
  `is_vendor_book_allowed` enum('ALLOWED','BLOCKED') NOT NULL DEFAULT 'ALLOWED',
  `is_discount_allowed` enum('ALLOWED','BLOCKED') NOT NULL DEFAULT 'ALLOWED',
  `is_online_book_allowed` enum('ALLOWED','BLOCKED') NOT NULL DEFAULT 'ALLOWED',
  `booking_id` int(11) DEFAULT NULL,
  `booking_time` datetime DEFAULT NULL,
  `entrytime` datetime DEFAULT current_timestamp(),
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `is_scanned` bigint(1) NOT NULL DEFAULT 0,
  `scan_time` datetime DEFAULT NULL,
  `scanned_by` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

--
-- Table structure for table `event_show_schedule`
--

CREATE TABLE `event_show_schedule` (
  `id` int(11) NOT NULL,
  `event_id` int(11) NOT NULL,
  `event_schedule_list_id` int(11) NOT NULL,
  `event_show_time_id` int(11) NOT NULL,
  `start_time` varchar(20) DEFAULT NULL,
  `end_time` varchar(20) DEFAULT NULL,
  `vendor_booking` enum('ALLOWED','NOT_ALLOWED') NOT NULL DEFAULT 'ALLOWED',
  `customer_booking` enum('NOT_ALLOWED','ALLOWED') NOT NULL DEFAULT 'ALLOWED',
  `booking` enum('ALLOWED','NOT_ALLOWED') NOT NULL DEFAULT 'ALLOWED',
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT NULL ON UPDATE current_timestamp(),
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Table structure for table `event_show_time`
--

CREATE TABLE `event_show_time` (
  `id` int(11) NOT NULL,
  `event_id` int(11) NOT NULL,
  `event_schedule_id` int(11) NOT NULL,
  `start_time` varchar(20) NOT NULL,
  `end_time` varchar(20) NOT NULL,
  `allow_online_booking` enum('YES','NO') NOT NULL DEFAULT 'YES',
  `status` enum('ACTIVE','INACTIVE') NOT NULL DEFAULT 'ACTIVE',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

--
-- Table structure for table `event_tickets`
--

CREATE TABLE `event_tickets` (
  `id` int(11) NOT NULL,
  `event_id` int(11) NOT NULL,
  `event_schedule_id` int(11) NOT NULL,
  `event_schedule_list_id` text DEFAULT NULL,
  `event_show_time_id` text DEFAULT NULL,
  `layout_id` int(11) DEFAULT NULL,
  `skip_label` varchar(100) DEFAULT NULL,
  `ticket_type_id` text DEFAULT NULL,
  `total_ticket` text DEFAULT NULL,
  `base_price` text DEFAULT NULL,
  `total_discount` text DEFAULT NULL,
  `discounted_amount` text DEFAULT NULL,
  `final_price` text DEFAULT NULL,
  `status` enum('ACTIVE','INACTIVE') NOT NULL DEFAULT 'ACTIVE',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

--
-- Table structure for table `event_ticket_lists`
--

CREATE TABLE `event_ticket_lists` (
  `id` int(11) NOT NULL,
  `event_id` int(11) NOT NULL,
  `event_schedule_list_id` int(11) DEFAULT NULL,
  `event_show_time_id` int(11) DEFAULT NULL,
  `event_ticket_id` int(11) UNSIGNED NOT NULL DEFAULT 0,
  `ticket_type_id` int(11) DEFAULT NULL,
  `total_ticket` int(11) DEFAULT NULL,
  `base_price` decimal(10,2) DEFAULT NULL,
  `total_discount` decimal(10,2) DEFAULT NULL,
  `discounted_amount` decimal(10,2) DEFAULT NULL,
  `final_price` decimal(10,2) DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `fc`
--

CREATE TABLE `fc` (
  `id` int(11) NOT NULL,
  `bid` int(11) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `update_at` datetime DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Table structure for table `general_feedback`
--

CREATE TABLE `general_feedback` (
  `id` int(11) NOT NULL,
  `text` varchar(100) NOT NULL,
  `feedback` mediumtext DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT NULL,
  `mobile` varchar(20) DEFAULT NULL,
  `browser` varchar(1000) DEFAULT NULL,
  `device` varchar(1000) DEFAULT NULL,
  `platform` varchar(1000) DEFAULT NULL,
  `ip_address` varchar(200) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Table structure for table `layouts`
--

CREATE TABLE `layouts` (
  `id` int(11) NOT NULL,
  `venue_id` int(11) NOT NULL,
  `sub_venue_id` int(11) NOT NULL,
  `layout_name` varchar(255) DEFAULT NULL,
  `layout_row_label` text DEFAULT NULL,
  `layout_skip_label` varchar(100) DEFAULT NULL,
  `stage_direction` enum('UP','DOWN') NOT NULL DEFAULT 'UP',
  `status` enum('ACTIVE','INACTIVE') NOT NULL DEFAULT 'ACTIVE',
  `default_layout` enum('YES','NO') NOT NULL DEFAULT 'NO',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

--
-- Table structure for table `layout_details`
--

CREATE TABLE `layout_details` (
  `id` int(11) NOT NULL,
  `layout_id` int(11) NOT NULL,
  `row_no` int(11) DEFAULT NULL,
  `col_no` int(11) DEFAULT NULL,
  `name` varchar(30) DEFAULT NULL,
  `label` varchar(10) DEFAULT NULL,
  `uniqueid` varchar(100) DEFAULT NULL,
  `seatno` varchar(10) DEFAULT NULL,
  `is_reserved` enum('NO','YES') DEFAULT 'NO',
  `is_damaged` enum('YES','NO') NOT NULL DEFAULT 'NO',
  `is_visible` enum('NO','YES') DEFAULT 'YES',
  `is_labeled` enum('YES','NO') DEFAULT 'NO',
  `is_removed` enum('YES','NO') DEFAULT 'NO',
  `entrytime` datetime DEFAULT current_timestamp(),
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(191) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Table structure for table `modules`
--

CREATE TABLE `modules` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) NOT NULL,
  `display_name` varchar(191) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Table structure for table `organizers`
--

CREATE TABLE `organizers` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone` varchar(255) NOT NULL,
  `contact_person` varchar(255) NOT NULL,
  `website` varchar(255) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `status` enum('ACTIVE','INACTIVE') NOT NULL DEFAULT 'ACTIVE',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(191) NOT NULL,
  `token` varchar(191) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Table structure for table `payment_logs`
--

CREATE TABLE `payment_logs` (
  `id` int(11) NOT NULL,
  `status` varchar(20) DEFAULT NULL,
  `customerName` varchar(255) DEFAULT NULL,
  `customerEmail` varchar(100) DEFAULT NULL,
  `customerPhone` varchar(20) DEFAULT NULL,
  `paymentId` varchar(100) DEFAULT NULL,
  `merchantTransactionId` varchar(100) DEFAULT NULL,
  `paymentMode` varchar(20) DEFAULT NULL,
  `amount` decimal(10,2) DEFAULT NULL,
  `additionalCharges` varchar(10) DEFAULT NULL,
  `hash` varchar(500) DEFAULT NULL,
  `error_Message` text DEFAULT NULL,
  `productInfo` varchar(500) DEFAULT NULL,
  `split_info` varchar(100) DEFAULT NULL,
  `udf1` varchar(500) DEFAULT NULL,
  `udf2` varchar(500) DEFAULT NULL,
  `udf3` varchar(500) DEFAULT NULL,
  `udf4` varchar(500) DEFAULT NULL,
  `udf5` varchar(500) DEFAULT NULL,
  `udf6` varchar(100) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

--
-- Table structure for table `payment_method`
--

CREATE TABLE `payment_method` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `status` enum('ACTIVE','INACTIVE') NOT NULL DEFAULT 'ACTIVE',
  `show_hide_price` enum('SHOW','HIDE') NOT NULL DEFAULT 'SHOW',
  `method_type` enum('FULL','DISCOUNT','COMPLEMENTARY','BARTER') NOT NULL DEFAULT 'FULL',
  `method_group` varchar(100) NOT NULL,
  `color` varchar(20) DEFAULT NULL,
  `parent_method` int(11) DEFAULT NULL,
  `operation` int(11) NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

--
-- Table structure for table `permissions`
--

CREATE TABLE `permissions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `module_id` smallint(6) NOT NULL,
  `name` varchar(191) NOT NULL,
  `display_name` varchar(191) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Table structure for table `photo_content`
--

CREATE TABLE `photo_content` (
  `id` int(11) NOT NULL,
  `gallery_id` int(11) NOT NULL,
  `sequence` int(11) NOT NULL DEFAULT 1,
  `cover_img` varchar(200) DEFAULT NULL,
  `name` varchar(200) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT NULL ON UPDATE current_timestamp(),
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Table structure for table `photo_gallery`
--

CREATE TABLE `photo_gallery` (
  `id` int(11) NOT NULL,
  `sequence` int(11) NOT NULL DEFAULT 1,
  `cover_img` varchar(200) DEFAULT NULL,
  `name` varchar(200) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT NULL ON UPDATE current_timestamp(),
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Table structure for table `pincodes`
--

CREATE TABLE `pincodes` (
  `id` int(11) NOT NULL,
  `state_id` int(11) NOT NULL,
  `city_id` int(11) NOT NULL,
  `pincode` varchar(6) NOT NULL,
  `status` enum('ACTIVE','INACTIVE') NOT NULL DEFAULT 'ACTIVE',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) NOT NULL,
  `is_locked` tinyint(1) DEFAULT 0,
  `is_admin` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Table structure for table `role_module_permissions`
--

CREATE TABLE `role_module_permissions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `role_id` smallint(6) NOT NULL,
  `module_id` smallint(6) NOT NULL,
  `permission_id` smallint(6) NOT NULL,
  `module_permission_name` varchar(191) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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
-- Table structure for table `settings`
--

CREATE TABLE `settings` (
  `id` int(11) NOT NULL,
  `site_title` varchar(255) DEFAULT NULL,
  `home_title` varchar(255) DEFAULT 'Home',
  `mobile_mandatory` enum('YES','NO') NOT NULL DEFAULT 'NO',
  `site_description` varchar(500) DEFAULT NULL,
  `keywords` varchar(500) DEFAULT NULL,
  `facebook_url` varchar(500) DEFAULT NULL,
  `twitter_url` varchar(500) DEFAULT NULL,
  `google_url` varchar(500) DEFAULT NULL,
  `instagram_url` varchar(500) DEFAULT NULL,
  `pinterest_url` varchar(500) DEFAULT NULL,
  `linkedin_url` varchar(500) DEFAULT NULL,
  `vk_url` varchar(500) DEFAULT NULL,
  `youtube_url` varchar(500) DEFAULT NULL,
  `contact_address` varchar(500) DEFAULT NULL,
  `contact_email` varchar(255) DEFAULT NULL,
  `contact_phone` varchar(255) DEFAULT NULL,
  `copyright` varchar(500) DEFAULT NULL,
  `mail_protocol` varchar(255) DEFAULT 'smtp',
  `mail_host` varchar(255) DEFAULT NULL,
  `mail_port` varchar(255) DEFAULT NULL,
  `mail_username` varchar(255) DEFAULT NULL,
  `mail_password` varchar(255) DEFAULT NULL,
  `mail_title` varchar(255) DEFAULT NULL,
  `ticket_hold_time` int(11) NOT NULL,
  `status` enum('ACTIVE','INACTIVE') DEFAULT 'ACTIVE',
  `convenience_fee` decimal(10,2) DEFAULT NULL,
  `sms_check` enum('ON','OFF') DEFAULT NULL,
  `whatsapp_check` enum('ON','OFF') DEFAULT NULL,
  `mail_check` enum('ON','OFF') DEFAULT NULL,
  `mobile_for_check` varchar(200) DEFAULT NULL,
  `email_for_check` varchar(200) DEFAULT NULL,
  `gst_waiver_rate` int(11) NOT NULL,
  `booking_id_for_check` int(11) NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

--
-- Table structure for table `states`
--

CREATE TABLE `states` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `status` enum('ACTIVE','INACTIVE') NOT NULL DEFAULT 'ACTIVE',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

--
-- Table structure for table `sub_venues`
--

CREATE TABLE `sub_venues` (
  `id` int(11) NOT NULL,
  `venue_id` int(11) NOT NULL,
  `name` varchar(150) NOT NULL,
  `type` enum('COMMERCIAL_BUILDING','MALL','THEATRE','UNIVERSITY','OTHER') DEFAULT 'OTHER',
  `status` enum('ACTIVE','INACTIVE') NOT NULL DEFAULT 'ACTIVE',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

--
-- Table structure for table `tax_rates`
--

CREATE TABLE `tax_rates` (
  `id` int(11) NOT NULL,
  `name` varchar(55) NOT NULL,
  `code` varchar(10) DEFAULT NULL,
  `rate` decimal(12,2) NOT NULL,
  `type` varchar(50) DEFAULT NULL,
  `status` enum('ACTIVE','INACTIVE') NOT NULL DEFAULT 'ACTIVE',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

--
-- Table structure for table `ticket_type`
--

CREATE TABLE `ticket_type` (
  `id` int(11) NOT NULL,
  `event_id` int(11) NOT NULL,
  `ticket_type_name` varchar(255) NOT NULL,
  `color` varchar(20) NOT NULL,
  `status` enum('ACTIVE','INACTIVE') NOT NULL DEFAULT 'ACTIVE',
  `show_hide_seat_no` enum('SHOW','HIDE') NOT NULL DEFAULT 'SHOW',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

--
-- Table structure for table `transactions`
--

CREATE TABLE `transactions` (
  `id` int(11) NOT NULL,
  `user_id` varchar(100) NOT NULL,
  `customer_id` int(11) DEFAULT NULL,
  `event_id` int(11) NOT NULL,
  `event_schedule_list_id` int(11) NOT NULL,
  `event_show_time_id` int(11) NOT NULL,
  `ticket_type_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `mobile` varchar(15) NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `discount` decimal(10,2) DEFAULT 0.00,
  `txnid` varchar(100) NOT NULL,
  `seat_details` text DEFAULT NULL,
  `find_us` varchar(255) DEFAULT NULL,
  `state` varchar(200) DEFAULT NULL,
  `seat_ids` text DEFAULT NULL,
  `pg_txn` varchar(100) DEFAULT NULL,
  `productinfo` varchar(100) NOT NULL,
  `payment_gateway` varchar(100) DEFAULT NULL,
  `bank_ref_num` varchar(100) DEFAULT NULL,
  `hash` text DEFAULT NULL,
  `booking_id` int(11) DEFAULT NULL,
  `note` text DEFAULT NULL,
  `status` varchar(20) DEFAULT NULL,
  `booked_by_cron` varchar(10) NOT NULL DEFAULT 'NO',
  `created_at` datetime DEFAULT NULL,
  `cron_checked` tinyint(1) NOT NULL DEFAULT 0 COMMENT '0=Not Checked\r\n1=Checked',
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `role_id` smallint(6) NOT NULL,
  `name` varchar(191) NOT NULL,
  `mobile` varchar(15) DEFAULT NULL,
  `email` varchar(191) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(191) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `payment_method_not_allowed` varchar(100) DEFAULT NULL,
  `avatar` varchar(255) DEFAULT NULL,
  `reserve_unreserve` enum('NOT_ALLOWED','ALLOWED') DEFAULT 'NOT_ALLOWED',
  `res_unres_dmg_hide` enum('NOT_ALLOWED','ALLOWED') DEFAULT 'NOT_ALLOWED',
  `status` enum('ACTIVE','INACTIVE') NOT NULL DEFAULT 'ACTIVE',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `remove_unremoved` enum('ALLOWED','NOT_ALLOWED') NOT NULL DEFAULT 'NOT_ALLOWED'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Table structure for table `venues`
--

CREATE TABLE `venues` (
  `id` int(11) NOT NULL,
  `state_id` int(11) NOT NULL,
  `city_id` int(11) NOT NULL,
  `pincode_id` int(11) NOT NULL,
  `name` varchar(150) NOT NULL,
  `address` longtext DEFAULT NULL,
  `map` text DEFAULT NULL,
  `capacity` int(11) NOT NULL,
  `contact_person_name` varchar(150) NOT NULL,
  `contact_no` varchar(15) NOT NULL,
  `parking` enum('YES','NO') NOT NULL DEFAULT 'NO',
  `type` enum('COMMERCIAL_BUILDING','MALL','THEATRE','UNIVERSITY','OTHER') NOT NULL DEFAULT 'OTHER',
  `status` enum('ACTIVE','INACTIVE') NOT NULL DEFAULT 'ACTIVE',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

--
-- Table structure for table `video_gallery`
--

CREATE TABLE `video_gallery` (
  `id` int(11) NOT NULL,
  `sequence` int(11) NOT NULL DEFAULT 1,
  `youtube_id` varchar(200) DEFAULT NULL,
  `name` varchar(200) DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT NULL ON UPDATE current_timestamp(),
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Table structure for table `visitor_logs`
--

CREATE TABLE `visitor_logs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `utm_source` varchar(1000) DEFAULT NULL,
  `utm_medium` varchar(1000) DEFAULT NULL,
  `utm_campaign` varchar(1000) DEFAULT NULL,
  `utm_content` varchar(1000) DEFAULT NULL,
  `ip_address` varchar(1000) DEFAULT NULL,
  `booking_id` int(11) DEFAULT NULL,
  `amount` decimal(10,2) DEFAULT 0.00,
  `tickets` int(11) DEFAULT 0,
  `browser` varchar(1000) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `bookings`
--
ALTER TABLE `bookings`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id` (`id`,`event_id`,`event_schedule_id`,`event_schedule_list_id`,`event_show_time_id`,`venue_id`,`layout_id`,`booking_source_id`,`customer_id`,`vendor_id`),
  ADD KEY `payment_method_id` (`payment_method_id`);

--
-- Indexes for table `booking_details`
--
ALTER TABLE `booking_details`
  ADD PRIMARY KEY (`id`),
  ADD KEY `booking_details_ibfk_1` (`booking_id`),
  ADD KEY `booking_details_ibfk_2` (`venue_id`),
  ADD KEY `id` (`id`,`booking_id`,`venue_id`,`seat_id`,`ticket_type_id`,`row_id`,`col_id`);

--
-- Indexes for table `booking_payments`
--
ALTER TABLE `booking_payments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `booking_payments_ibfk_1` (`booking_id`),
  ADD KEY `id` (`id`,`booking_id`) USING BTREE,
  ADD KEY `payment_method_id` (`payment_method_id`);

--
-- Indexes for table `booking_platform`
--
ALTER TABLE `booking_platform`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id` (`id`);

--
-- Indexes for table `cancelled_bookings`
--
ALTER TABLE `cancelled_bookings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id` (`id`,`seat_id`,`event_schedule_list_id`,`event_show_time_id`,`ticket_type_id`,`user_id`);

--
-- Indexes for table `cities`
--
ALTER TABLE `cities`
  ADD PRIMARY KEY (`id`),
  ADD KEY `state_k` (`state_id`),
  ADD KEY `id` (`id`);

--
-- Indexes for table `company`
--
ALTER TABLE `company`
  ADD PRIMARY KEY (`id`),
  ADD KEY `state_id` (`state_id`,`city_id`);

--
-- Indexes for table `configuration`
--
ALTER TABLE `configuration`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id` (`id`);

--
-- Indexes for table `coupons`
--
ALTER TABLE `coupons`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id` (`id`,`category_id`);

--
-- Indexes for table `coupons_category`
--
ALTER TABLE `coupons_category`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id` (`id`,`event_id`);

--
-- Indexes for table `customers`
--
ALTER TABLE `customers`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id` (`id`,`mobile_no`,`user_id`,`vendor_id`);

--
-- Indexes for table `customer_cart`
--
ALTER TABLE `customer_cart`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id` (`id`,`seat_id`,`event_schedule_list_id`,`event_show_time_id`,`ticket_type_id`,`user_id`);

--
-- Indexes for table `events`
--
ALTER TABLE `events`
  ADD PRIMARY KEY (`id`),
  ADD KEY ` events_ibfk_3` (`city_id`),
  ADD KEY ` events_ibfk_4` (`organizer_id`),
  ADD KEY ` events_ibfk_5` (`venue_id`),
  ADD KEY `events_ibfk_2` (`state_id`);

--
-- Indexes for table `event_schedule`
--
ALTER TABLE `event_schedule`
  ADD PRIMARY KEY (`id`),
  ADD KEY `event_schedule_ibfk_1` (`event_id`),
  ADD KEY `id` (`id`);

--
-- Indexes for table `event_schedule_list`
--
ALTER TABLE `event_schedule_list`
  ADD PRIMARY KEY (`id`),
  ADD KEY `event_schedule_ibfk_1` (`event_id`),
  ADD KEY `id` (`id`,`event_schedule_id`);

--
-- Indexes for table `event_seat`
--
ALTER TABLE `event_seat`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id` (`id`),
  ADD KEY `event_id` (`event_id`,`event_schedule_list_id`,`event_show_time_id`,`event_ticket_id`,`event_ticket_type_id`,`layout_id`,`booking_id`);

--
-- Indexes for table `event_show_schedule`
--
ALTER TABLE `event_show_schedule`
  ADD PRIMARY KEY (`id`),
  ADD KEY `event_show_time_id` (`event_show_time_id`),
  ADD KEY `event_schedule_list_id` (`event_schedule_list_id`),
  ADD KEY `id` (`id`,`event_id`);

--
-- Indexes for table `event_show_time`
--
ALTER TABLE `event_show_time`
  ADD PRIMARY KEY (`id`),
  ADD KEY `event_show_time_ibfk_1` (`event_id`),
  ADD KEY `event_show_time_ibfk_2` (`event_schedule_id`),
  ADD KEY `id` (`id`);

--
-- Indexes for table `event_tickets`
--
ALTER TABLE `event_tickets`
  ADD PRIMARY KEY (`id`),
  ADD KEY `event_tickets_ibfk_1` (`event_id`),
  ADD KEY `event_tickets_ibfk_2` (`event_schedule_id`),
  ADD KEY `event_schedule_id` (`event_schedule_id`),
  ADD KEY `event_id` (`event_id`),
  ADD KEY `id` (`id`);

--
-- Indexes for table `event_ticket_lists`
--
ALTER TABLE `event_ticket_lists`
  ADD PRIMARY KEY (`id`),
  ADD KEY `event_id` (`event_id`,`event_schedule_list_id`,`event_show_time_id`,`event_ticket_id`,`ticket_type_id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `fc`
--
ALTER TABLE `fc`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `general_feedback`
--
ALTER TABLE `general_feedback`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `layouts`
--
ALTER TABLE `layouts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id` (`id`,`venue_id`,`sub_venue_id`);

--
-- Indexes for table `layout_details`
--
ALTER TABLE `layout_details`
  ADD PRIMARY KEY (`id`),
  ADD KEY `layout_id` (`layout_id`),
  ADD KEY `id` (`id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `modules`
--
ALTER TABLE `modules`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `organizers`
--
ALTER TABLE `organizers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- Indexes for table `payment_logs`
--
ALTER TABLE `payment_logs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id` (`id`);

--
-- Indexes for table `payment_method`
--
ALTER TABLE `payment_method`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `permissions`
--
ALTER TABLE `permissions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `photo_content`
--
ALTER TABLE `photo_content`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `photo_gallery`
--
ALTER TABLE `photo_gallery`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pincodes`
--
ALTER TABLE `pincodes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `pincode_state_k` (`state_id`),
  ADD KEY `pincode_city_k` (`city_id`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `role_module_permissions`
--
ALTER TABLE `role_module_permissions`
  ADD PRIMARY KEY (`id`);

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
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `states`
--
ALTER TABLE `states`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id` (`id`);

--
-- Indexes for table `sub_venues`
--
ALTER TABLE `sub_venues`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sub_venue_venue_k` (`venue_id`) USING BTREE,
  ADD KEY `id` (`id`);

--
-- Indexes for table `tax_rates`
--
ALTER TABLE `tax_rates`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id` (`id`);

--
-- Indexes for table `ticket_type`
--
ALTER TABLE `ticket_type`
  ADD PRIMARY KEY (`id`),
  ADD KEY `ticket_type_ibfk_1` (`event_id`),
  ADD KEY `id` (`id`,`event_id`);

--
-- Indexes for table `transactions`
--
ALTER TABLE `transactions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `booking_payments_ibfk_1` (`txnid`),
  ADD KEY `booking_payments_ibfk_2` (`mobile`),
  ADD KEY `id` (`id`,`txnid`,`mobile`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`),
  ADD KEY `id` (`id`,`role_id`);

--
-- Indexes for table `venues`
--
ALTER TABLE `venues`
  ADD PRIMARY KEY (`id`),
  ADD KEY `venue_city_k` (`city_id`),
  ADD KEY `venue_state_k` (`state_id`),
  ADD KEY `id` (`id`,`pincode_id`);

--
-- Indexes for table `video_gallery`
--
ALTER TABLE `video_gallery`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `visitor_logs`
--
ALTER TABLE `visitor_logs`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `bookings`
--
ALTER TABLE `bookings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23025;

--
-- AUTO_INCREMENT for table `booking_details`
--
ALTER TABLE `booking_details`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=75952;

--
-- AUTO_INCREMENT for table `booking_payments`
--
ALTER TABLE `booking_payments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23013;

--
-- AUTO_INCREMENT for table `booking_platform`
--
ALTER TABLE `booking_platform`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `cancelled_bookings`
--
ALTER TABLE `cancelled_bookings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=109;

--
-- AUTO_INCREMENT for table `cart`
--
ALTER TABLE `cart`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=202508;

--
-- AUTO_INCREMENT for table `cities`
--
ALTER TABLE `cities`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `company`
--
ALTER TABLE `company`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `configuration`
--
ALTER TABLE `configuration`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `coupons`
--
ALTER TABLE `coupons`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `coupons_category`
--
ALTER TABLE `coupons_category`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `customers`
--
ALTER TABLE `customers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=115783;

--
-- AUTO_INCREMENT for table `customer_cart`
--
ALTER TABLE `customer_cart`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=166974;

--
-- AUTO_INCREMENT for table `events`
--
ALTER TABLE `events`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `event_schedule`
--
ALTER TABLE `event_schedule`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `event_schedule_list`
--
ALTER TABLE `event_schedule_list`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=144;

--
-- AUTO_INCREMENT for table `event_seat`
--
ALTER TABLE `event_seat`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=429176;

--
-- AUTO_INCREMENT for table `event_show_schedule`
--
ALTER TABLE `event_show_schedule`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=326;

--
-- AUTO_INCREMENT for table `event_show_time`
--
ALTER TABLE `event_show_time`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `event_tickets`
--
ALTER TABLE `event_tickets`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=326;

--
-- AUTO_INCREMENT for table `event_ticket_lists`
--
ALTER TABLE `event_ticket_lists`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1236;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `fc`
--
ALTER TABLE `fc`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1724;

--
-- AUTO_INCREMENT for table `general_feedback`
--
ALTER TABLE `general_feedback`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `layouts`
--
ALTER TABLE `layouts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `layout_details`
--
ALTER TABLE `layout_details`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5307;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `modules`
--
ALTER TABLE `modules`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=51;

--
-- AUTO_INCREMENT for table `organizers`
--
ALTER TABLE `organizers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `payment_logs`
--
ALTER TABLE `payment_logs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4072;

--
-- AUTO_INCREMENT for table `payment_method`
--
ALTER TABLE `payment_method`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `permissions`
--
ALTER TABLE `permissions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=175;

--
-- AUTO_INCREMENT for table `photo_content`
--
ALTER TABLE `photo_content`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- AUTO_INCREMENT for table `photo_gallery`
--
ALTER TABLE `photo_gallery`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `pincodes`
--
ALTER TABLE `pincodes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `role_module_permissions`
--
ALTER TABLE `role_module_permissions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5502;

--
-- AUTO_INCREMENT for table `settings`
--
ALTER TABLE `settings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `states`
--
ALTER TABLE `states`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `sub_venues`
--
ALTER TABLE `sub_venues`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `tax_rates`
--
ALTER TABLE `tax_rates`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `ticket_type`
--
ALTER TABLE `ticket_type`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=49;

--
-- AUTO_INCREMENT for table `transactions`
--
ALTER TABLE `transactions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5801;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `venues`
--
ALTER TABLE `venues`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `video_gallery`
--
ALTER TABLE `video_gallery`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `visitor_logs`
--
ALTER TABLE `visitor_logs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1779713;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `booking_details`
--
ALTER TABLE `booking_details`
  ADD CONSTRAINT `booking_details_ibfk_1` FOREIGN KEY (`booking_id`) REFERENCES `bookings` (`id`),
  ADD CONSTRAINT `booking_details_ibfk_2` FOREIGN KEY (`venue_id`) REFERENCES `venues` (`id`);

--
-- Constraints for table `booking_payments`
--
ALTER TABLE `booking_payments`
  ADD CONSTRAINT `booking_payments_ibfk_1` FOREIGN KEY (`booking_id`) REFERENCES `bookings` (`id`),
  ADD CONSTRAINT `booking_payments_ibfk_2` FOREIGN KEY (`payment_method_id`) REFERENCES `payment_method` (`id`);

--
-- Constraints for table `cities`
--
ALTER TABLE `cities`
  ADD CONSTRAINT `state_k` FOREIGN KEY (`state_id`) REFERENCES `states` (`id`);

--
-- Constraints for table `events`
--
ALTER TABLE `events`
  ADD CONSTRAINT ` events_ibfk_3` FOREIGN KEY (`city_id`) REFERENCES `cities` (`id`),
  ADD CONSTRAINT ` events_ibfk_4` FOREIGN KEY (`organizer_id`) REFERENCES `organizers` (`id`),
  ADD CONSTRAINT ` events_ibfk_5` FOREIGN KEY (`venue_id`) REFERENCES `venues` (`id`),
  ADD CONSTRAINT `events_ibfk_2` FOREIGN KEY (`state_id`) REFERENCES `states` (`id`);

--
-- Constraints for table `event_schedule`
--
ALTER TABLE `event_schedule`
  ADD CONSTRAINT `event_schedule_ibfk_1` FOREIGN KEY (`event_id`) REFERENCES `events` (`id`);

--
-- Constraints for table `event_show_schedule`
--
ALTER TABLE `event_show_schedule`
  ADD CONSTRAINT `event_show_schedule_ibfk_1` FOREIGN KEY (`event_show_time_id`) REFERENCES `event_show_time` (`id`),
  ADD CONSTRAINT `event_show_schedule_ibfk_2` FOREIGN KEY (`event_schedule_list_id`) REFERENCES `event_schedule_list` (`id`);

--
-- Constraints for table `event_show_time`
--
ALTER TABLE `event_show_time`
  ADD CONSTRAINT `event_show_time_ibfk_1` FOREIGN KEY (`event_id`) REFERENCES `events` (`id`),
  ADD CONSTRAINT `event_show_time_ibfk_2` FOREIGN KEY (`event_schedule_id`) REFERENCES `event_schedule` (`id`);

--
-- Constraints for table `event_tickets`
--
ALTER TABLE `event_tickets`
  ADD CONSTRAINT `event_tickets_ibfk_1` FOREIGN KEY (`event_id`) REFERENCES `events` (`id`),
  ADD CONSTRAINT `event_tickets_ibfk_2` FOREIGN KEY (`event_schedule_id`) REFERENCES `event_schedule` (`id`);

--
-- Constraints for table `pincodes`
--
ALTER TABLE `pincodes`
  ADD CONSTRAINT `pincode_city_k` FOREIGN KEY (`city_id`) REFERENCES `cities` (`id`),
  ADD CONSTRAINT `pincode_state_k` FOREIGN KEY (`state_id`) REFERENCES `states` (`id`);


COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

