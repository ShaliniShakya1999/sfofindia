-- =====================================================
-- Shaheed Foundation of India (SFOI)
-- Production Database Schema
-- Generated: 2026-09-10 13:45:46
-- Compatible: MySQL 5.7+ / MariaDB 10.3+
-- =====================================================

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- Table: admin_users
CREATE TABLE IF NOT EXISTS `admin_users` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(64) NOT NULL,
  `password_hash` varchar(255) NOT NULL,
  `email` varchar(191) DEFAULT NULL,
  `role` varchar(32) DEFAULT 'admin',
  `status` tinyint(1) DEFAULT 1,
  `last_login` datetime DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `otp_code` varchar(16) DEFAULT NULL,
  `otp_expiry` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uniq_username` (`username`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Table: banners
CREATE TABLE IF NOT EXISTS `banners` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Table: blog
CREATE TABLE IF NOT EXISTS `blog` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `slug` varchar(255) DEFAULT NULL,
  `metaTitle` varchar(255) DEFAULT NULL,
  `metaDescription` text DEFAULT NULL,
  `metaKeyword` varchar(255) DEFAULT NULL,
  `title` varchar(255) DEFAULT NULL,
  `heading` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `postedBy` varchar(255) DEFAULT NULL,
  `postedDate` date DEFAULT NULL,
  `subject` varchar(255) DEFAULT NULL,
  `image` text DEFAULT NULL,
  `status` varchar(50) DEFAULT 'Active',
  `creationDate` datetime DEFAULT NULL,
  `updationDate` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Table: contact
CREATE TABLE IF NOT EXISTS `contact` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(191) DEFAULT NULL,
  `email` varchar(191) DEFAULT NULL,
  `phone` varchar(32) DEFAULT NULL,
  `subject` varchar(191) DEFAULT NULL,
  `message` text DEFAULT NULL,
  `created_at` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Table: donations
CREATE TABLE IF NOT EXISTS `donations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(191) NOT NULL,
  `mobile` varchar(32) NOT NULL DEFAULT '',
  `email` varchar(191) NOT NULL DEFAULT '',
  `amount` decimal(12,2) NOT NULL,
  `currency` varchar(8) NOT NULL DEFAULT 'INR',
  `razorpay_order_id` varchar(64) DEFAULT NULL,
  `payment_id` varchar(64) DEFAULT NULL,
  `signature_verified` tinyint(1) NOT NULL DEFAULT 0,
  `status` varchar(32) NOT NULL DEFAULT 'pending',
  `receipt_no` varchar(32) DEFAULT NULL,
  `campaign_id` int(10) unsigned DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `uniq_payment_id` (`payment_id`),
  KEY `idx_order` (`razorpay_order_id`),
  KEY `idx_created` (`created_at`),
  KEY `idx_status` (`status`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Table: dt_blog
CREATE TABLE IF NOT EXISTS `dt_blog` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `slug` varchar(200) NOT NULL,
  `heading` varchar(200) NOT NULL,
  `metaTitle` varchar(200) NOT NULL,
  `metaDescription` text NOT NULL,
  `metaKeyword` varchar(200) NOT NULL,
  `subject` varchar(200) NOT NULL,
  `description` text NOT NULL,
  `postedBy` varchar(31) NOT NULL,
  `postedDate` varchar(250) NOT NULL,
  `title` varchar(200) NOT NULL,
  `image` varchar(300) NOT NULL,
  `webp` varchar(250) NOT NULL,
  `status` enum('Active','Inactive','Deleted') NOT NULL,
  `updationDate` date NOT NULL,
  `creationDate` date NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=24 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Table: member_renewals
CREATE TABLE IF NOT EXISTS `member_renewals` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `member_id` int(10) unsigned NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `currency` varchar(8) NOT NULL DEFAULT 'INR',
  `razorpay_order_id` varchar(64) DEFAULT NULL,
  `payment_id` varchar(64) DEFAULT NULL,
  `signature_verified` tinyint(1) DEFAULT 0,
  `old_validity_end` date DEFAULT NULL,
  `new_validity_end` date DEFAULT NULL,
  `created_at` datetime NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `payment_id` (`payment_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Table: members
CREATE TABLE IF NOT EXISTS `members` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `public_id` char(32) NOT NULL,
  `name` varchar(191) NOT NULL,
  `gender` varchar(16) DEFAULT NULL,
  `dob` date DEFAULT NULL,
  `relation_type` varchar(16) DEFAULT NULL,
  `relation_name` varchar(191) DEFAULT NULL,
  `profession` varchar(100) DEFAULT NULL,
  `blood_group` varchar(16) DEFAULT NULL,
  `state` varchar(100) DEFAULT NULL,
  `district` varchar(100) DEFAULT NULL,
  `aadhar_no` varchar(32) DEFAULT NULL,
  `aadhar_verified` tinyint(1) DEFAULT 0,
  `aadhar_data` text DEFAULT NULL,
  `aadhar_front` varchar(255) DEFAULT NULL,
  `aadhar_back` varchar(255) DEFAULT NULL,
  `donation_amount` decimal(10,2) DEFAULT 0.00,
  `address` text DEFAULT NULL,
  `pin_code` varchar(16) DEFAULT NULL,
  `id_type` varchar(64) DEFAULT NULL,
  `id_document` varchar(255) DEFAULT NULL,
  `other_document` varchar(255) DEFAULT NULL,
  `authority` varchar(191) DEFAULT NULL,
  `validity_start` date DEFAULT NULL,
  `validity_end` date DEFAULT NULL,
  `payment_mode` varchar(64) DEFAULT NULL,
  `payment_receipt` varchar(255) DEFAULT NULL,
  `member_user_id` varchar(64) DEFAULT NULL,
  `member_password_hash` varchar(255) DEFAULT NULL,
  `member_id_code` varchar(32) DEFAULT NULL,
  `achievements` text DEFAULT NULL,
  `verified_at` datetime DEFAULT NULL,
  `verified_by` int(10) unsigned DEFAULT NULL,
  `mobile` varchar(32) NOT NULL DEFAULT '',
  `email` varchar(191) NOT NULL DEFAULT '',
  `photo` varchar(255) DEFAULT NULL,
  `role` varchar(64) NOT NULL DEFAULT 'member',
  `status` varchar(32) NOT NULL DEFAULT 'active',
  `joining_date` date DEFAULT NULL,
  `referral_code` varchar(32) NOT NULL,
  `added_by` int(10) unsigned DEFAULT NULL,
  `join_source` varchar(64) DEFAULT NULL,
  `notes` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `last_birthday_wish_year` int(11) DEFAULT NULL,
  `last_renewal_reminder_date` date DEFAULT NULL,
  `id_card_sent` tinyint(1) DEFAULT 0,
  `admin_notes` text DEFAULT NULL,
  `rejection_reason` text DEFAULT NULL,
  `rejected_at` datetime DEFAULT NULL,
  `rejected_by` int(10) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uniq_public_id` (`public_id`),
  UNIQUE KEY `uniq_referral` (`referral_code`),
  UNIQUE KEY `member_id_code` (`member_id_code`),
  KEY `idx_status` (`status`),
  KEY `idx_joining` (`joining_date`),
  KEY `idx_added_by` (`added_by`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Table: navbar
CREATE TABLE IF NOT EXISTS `navbar` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nav_name` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Table: ngom_admin_activity
CREATE TABLE IF NOT EXISTS `ngom_admin_activity` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `admin_user_id` int(11) DEFAULT NULL,
  `action` varchar(100) DEFAULT NULL,
  `detail` text DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `admin_user_id` (`admin_user_id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Table: ngom_audit_reports
CREATE TABLE IF NOT EXISTS `ngom_audit_reports` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) DEFAULT NULL,
  `file_path` text DEFAULT NULL,
  `admin_user_id` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Table: ngom_campaigns
CREATE TABLE IF NOT EXISTS `ngom_campaigns` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) DEFAULT NULL,
  `goal_amount` decimal(15,2) DEFAULT 0.00,
  `raised_display` varchar(100) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `image` text DEFAULT NULL,
  `status` varchar(50) DEFAULT 'active',
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Table: ngom_events
CREATE TABLE IF NOT EXISTS `ngom_events` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) DEFAULT NULL,
  `slug` varchar(255) DEFAULT NULL,
  `body` text DEFAULT NULL,
  `event_date` date DEFAULT NULL,
  `image` text DEFAULT NULL,
  `status` varchar(50) DEFAULT 'published',
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Table: ngom_gallery
CREATE TABLE IF NOT EXISTS `ngom_gallery` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) DEFAULT NULL,
  `image_path` text DEFAULT NULL,
  `sort_order` int(11) DEFAULT 0,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Table: ngom_notifications
CREATE TABLE IF NOT EXISTS `ngom_notifications` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(128) NOT NULL,
  `message` text DEFAULT NULL,
  `type` enum('info','success','warning','danger') DEFAULT 'info',
  `is_read` tinyint(4) DEFAULT 0,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Table: ngom_projects
CREATE TABLE IF NOT EXISTS `ngom_projects` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) DEFAULT NULL,
  `summary` text DEFAULT NULL,
  `body` text DEFAULT NULL,
  `image` text DEFAULT NULL,
  `status` varchar(50) DEFAULT 'active',
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Table: site_settings
CREATE TABLE IF NOT EXISTS `site_settings` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `setting_key` varchar(100) NOT NULL,
  `setting_value` longtext DEFAULT NULL,
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `uniq_setting_key` (`setting_key`)
) ENGINE=InnoDB AUTO_INCREMENT=62 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- -----------------------------------------------------
-- Essential Seed Data for site_settings
-- -----------------------------------------------------
INSERT INTO `site_settings` (`setting_key`, `setting_value`) VALUES ('site_name', 'Shaheed Foundation India') ON DUPLICATE KEY UPDATE `setting_value` = VALUES(`setting_value`);
INSERT INTO `site_settings` (`setting_key`, `setting_value`) VALUES ('meta_title', 'Shaheed Foundation India') ON DUPLICATE KEY UPDATE `setting_value` = VALUES(`setting_value`);
INSERT INTO `site_settings` (`setting_key`, `setting_value`) VALUES ('meta_description', 'Honoring sacrifice, supporting martyrs??? families with dignity and care.') ON DUPLICATE KEY UPDATE `setting_value` = VALUES(`setting_value`);
INSERT INTO `site_settings` (`setting_key`, `setting_value`) VALUES ('meta_keywords', 'NGO, martyrs, India, charity, donation') ON DUPLICATE KEY UPDATE `setting_value` = VALUES(`setting_value`);
INSERT INTO `site_settings` (`setting_key`, `setting_value`) VALUES ('contact_phone', '+012 345 67890') ON DUPLICATE KEY UPDATE `setting_value` = VALUES(`setting_value`);
INSERT INTO `site_settings` (`setting_key`, `setting_value`) VALUES ('contact_email', 'info@sfofindia.com') ON DUPLICATE KEY UPDATE `setting_value` = VALUES(`setting_value`);
INSERT INTO `site_settings` (`setting_key`, `setting_value`) VALUES ('contact_address', 'SCO-88 Second Floor, Opp. Sector 12 A Gurgaon') ON DUPLICATE KEY UPDATE `setting_value` = VALUES(`setting_value`);
INSERT INTO `site_settings` (`setting_key`, `setting_value`) VALUES ('newsletter_title', 'Subscribe the Newsletter') ON DUPLICATE KEY UPDATE `setting_value` = VALUES(`setting_value`);
INSERT INTO `site_settings` (`setting_key`, `setting_value`) VALUES ('newsletter_subtitle', 'Don\'t worry, we won\'t spam you with emails.') ON DUPLICATE KEY UPDATE `setting_value` = VALUES(`setting_value`);
INSERT INTO `site_settings` (`setting_key`, `setting_value`) VALUES ('slide1_title', 'Honoring Sacrifice. Supporting Families. Building Hope.') ON DUPLICATE KEY UPDATE `setting_value` = VALUES(`setting_value`);
INSERT INTO `site_settings` (`setting_key`, `setting_value`) VALUES ('slide1_text', 'At Shaheed Foundation of India, we stand beside the families of our martyrs, offering respect, support, and long-term assistance to help them live with dignity and security.') ON DUPLICATE KEY UPDATE `setting_value` = VALUES(`setting_value`);
INSERT INTO `site_settings` (`setting_key`, `setting_value`) VALUES ('slide1_btn1', 'Support a Martyr\'s Family') ON DUPLICATE KEY UPDATE `setting_value` = VALUES(`setting_value`);
INSERT INTO `site_settings` (`setting_key`, `setting_value`) VALUES ('slide1_btn2', 'Join as a Volunteer') ON DUPLICATE KEY UPDATE `setting_value` = VALUES(`setting_value`);
INSERT INTO `site_settings` (`setting_key`, `setting_value`) VALUES ('slide1_img', 'img/soldier1.avif') ON DUPLICATE KEY UPDATE `setting_value` = VALUES(`setting_value`);
INSERT INTO `site_settings` (`setting_key`, `setting_value`) VALUES ('slide2_title', 'Standing Strong with the Families of Our Fallen Heroes') ON DUPLICATE KEY UPDATE `setting_value` = VALUES(`setting_value`);
INSERT INTO `site_settings` (`setting_key`, `setting_value`) VALUES ('slide2_text', 'Shaheed Foundation of India is committed to honoring the brave souls who laid down their lives for the nation by ensuring care, dignity, and a secure future for their families.') ON DUPLICATE KEY UPDATE `setting_value` = VALUES(`setting_value`);
INSERT INTO `site_settings` (`setting_key`, `setting_value`) VALUES ('slide2_btn1', 'Support Disabled People') ON DUPLICATE KEY UPDATE `setting_value` = VALUES(`setting_value`);
INSERT INTO `site_settings` (`setting_key`, `setting_value`) VALUES ('slide2_btn2', 'Become a Volunteer') ON DUPLICATE KEY UPDATE `setting_value` = VALUES(`setting_value`);
INSERT INTO `site_settings` (`setting_key`, `setting_value`) VALUES ('slide2_img', 'img/army2.jpg') ON DUPLICATE KEY UPDATE `setting_value` = VALUES(`setting_value`);
INSERT INTO `site_settings` (`setting_key`, `setting_value`) VALUES ('slide3_title', 'A Strong Support System for the Families of Our Martyrs') ON DUPLICATE KEY UPDATE `setting_value` = VALUES(`setting_value`);
INSERT INTO `site_settings` (`setting_key`, `setting_value`) VALUES ('slide3_text', 'Shaheed Foundation of India is dedicated to honoring the supreme sacrifice of our brave martyrs by supporting their families with dignity, care, and long-term security.') ON DUPLICATE KEY UPDATE `setting_value` = VALUES(`setting_value`);
INSERT INTO `site_settings` (`setting_key`, `setting_value`) VALUES ('slide3_btn1', 'Donate Now') ON DUPLICATE KEY UPDATE `setting_value` = VALUES(`setting_value`);
INSERT INTO `site_settings` (`setting_key`, `setting_value`) VALUES ('slide3_btn2', 'Join as a Volunteer') ON DUPLICATE KEY UPDATE `setting_value` = VALUES(`setting_value`);
INSERT INTO `site_settings` (`setting_key`, `setting_value`) VALUES ('slide3_img', 'img/Army.jpg') ON DUPLICATE KEY UPDATE `setting_value` = VALUES(`setting_value`);
INSERT INTO `site_settings` (`setting_key`, `setting_value`) VALUES ('about_label', 'About Shaheed Foundation of India') ON DUPLICATE KEY UPDATE `setting_value` = VALUES(`setting_value`);
INSERT INTO `site_settings` (`setting_key`, `setting_value`) VALUES ('about_heading', 'Standing With Those Who Gave Everything') ON DUPLICATE KEY UPDATE `setting_value` = VALUES(`setting_value`);
INSERT INTO `site_settings` (`setting_key`, `setting_value`) VALUES ('about_p1', 'Shaheed Foundation of India is a non-profit organization dedicated to supporting the families of brave martyrs who sacrificed their lives for the nation. Our mission is to ensure that no martyr\'s family ever feels alone, forgotten, or helpless.') ON DUPLICATE KEY UPDATE `setting_value` = VALUES(`setting_value`);
INSERT INTO `site_settings` (`setting_key`, `setting_value`) VALUES ('about_quote', 'A nation that honors its martyrs must stand with their families.') ON DUPLICATE KEY UPDATE `setting_value` = VALUES(`setting_value`);
INSERT INTO `site_settings` (`setting_key`, `setting_value`) VALUES ('donation_box_text', 'Your contribution helps us provide dignity, care, and hope to the families of our martyrs.') ON DUPLICATE KEY UPDATE `setting_value` = VALUES(`setting_value`);
INSERT INTO `site_settings` (`setting_key`, `setting_value`) VALUES ('about_image', 'img/images.jpg') ON DUPLICATE KEY UPDATE `setting_value` = VALUES(`setting_value`);
INSERT INTO `site_settings` (`setting_key`, `setting_value`) VALUES ('what_we_do_1', 'Financial assistance for martyrs\' families') ON DUPLICATE KEY UPDATE `setting_value` = VALUES(`setting_value`);
INSERT INTO `site_settings` (`setting_key`, `setting_value`) VALUES ('what_we_do_2', 'Education and healthcare support') ON DUPLICATE KEY UPDATE `setting_value` = VALUES(`setting_value`);
INSERT INTO `site_settings` (`setting_key`, `setting_value`) VALUES ('what_we_do_3', 'Employment and skill development programs') ON DUPLICATE KEY UPDATE `setting_value` = VALUES(`setting_value`);
INSERT INTO `site_settings` (`setting_key`, `setting_value`) VALUES ('what_we_do_4', 'Emergency relief and crisis support') ON DUPLICATE KEY UPDATE `setting_value` = VALUES(`setting_value`);
INSERT INTO `site_settings` (`setting_key`, `setting_value`) VALUES ('page_about_html', '') ON DUPLICATE KEY UPDATE `setting_value` = VALUES(`setting_value`);
INSERT INTO `site_settings` (`setting_key`, `setting_value`) VALUES ('page_contact_html', '') ON DUPLICATE KEY UPDATE `setting_value` = VALUES(`setting_value`);
INSERT INTO `site_settings` (`setting_key`, `setting_value`) VALUES ('page_service_html', '') ON DUPLICATE KEY UPDATE `setting_value` = VALUES(`setting_value`);
INSERT INTO `site_settings` (`setting_key`, `setting_value`) VALUES ('page_donation_html', '') ON DUPLICATE KEY UPDATE `setting_value` = VALUES(`setting_value`);
INSERT INTO `site_settings` (`setting_key`, `setting_value`) VALUES ('page_financial_html', '') ON DUPLICATE KEY UPDATE `setting_value` = VALUES(`setting_value`);
INSERT INTO `site_settings` (`setting_key`, `setting_value`) VALUES ('page_education_html', '') ON DUPLICATE KEY UPDATE `setting_value` = VALUES(`setting_value`);
INSERT INTO `site_settings` (`setting_key`, `setting_value`) VALUES ('page_disability_html', '') ON DUPLICATE KEY UPDATE `setting_value` = VALUES(`setting_value`);
INSERT INTO `site_settings` (`setting_key`, `setting_value`) VALUES ('page_employment_html', '') ON DUPLICATE KEY UPDATE `setting_value` = VALUES(`setting_value`);
INSERT INTO `site_settings` (`setting_key`, `setting_value`) VALUES ('page_team_html', '') ON DUPLICATE KEY UPDATE `setting_value` = VALUES(`setting_value`);
INSERT INTO `site_settings` (`setting_key`, `setting_value`) VALUES ('page_gallery_html', '') ON DUPLICATE KEY UPDATE `setting_value` = VALUES(`setting_value`);
INSERT INTO `site_settings` (`setting_key`, `setting_value`) VALUES ('page_event_html', '') ON DUPLICATE KEY UPDATE `setting_value` = VALUES(`setting_value`);
INSERT INTO `site_settings` (`setting_key`, `setting_value`) VALUES ('page_feature_html', '') ON DUPLICATE KEY UPDATE `setting_value` = VALUES(`setting_value`);
INSERT INTO `site_settings` (`setting_key`, `setting_value`) VALUES ('page_documents_html', '') ON DUPLICATE KEY UPDATE `setting_value` = VALUES(`setting_value`);
INSERT INTO `site_settings` (`setting_key`, `setting_value`) VALUES ('page_terms_html', '') ON DUPLICATE KEY UPDATE `setting_value` = VALUES(`setting_value`);
INSERT INTO `site_settings` (`setting_key`, `setting_value`) VALUES ('page_privacy_html', '') ON DUPLICATE KEY UPDATE `setting_value` = VALUES(`setting_value`);
INSERT INTO `site_settings` (`setting_key`, `setting_value`) VALUES ('page_legal_html', '') ON DUPLICATE KEY UPDATE `setting_value` = VALUES(`setting_value`);
INSERT INTO `site_settings` (`setting_key`, `setting_value`) VALUES ('page_refund_html', '') ON DUPLICATE KEY UPDATE `setting_value` = VALUES(`setting_value`);
INSERT INTO `site_settings` (`setting_key`, `setting_value`) VALUES ('google_map_embed', '') ON DUPLICATE KEY UPDATE `setting_value` = VALUES(`setting_value`);
INSERT INTO `site_settings` (`setting_key`, `setting_value`) VALUES ('razorpay_key_id', '') ON DUPLICATE KEY UPDATE `setting_value` = VALUES(`setting_value`);
INSERT INTO `site_settings` (`setting_key`, `setting_value`) VALUES ('razorpay_key_secret', '') ON DUPLICATE KEY UPDATE `setting_value` = VALUES(`setting_value`);
INSERT INTO `site_settings` (`setting_key`, `setting_value`) VALUES ('stripe_public_key', '') ON DUPLICATE KEY UPDATE `setting_value` = VALUES(`setting_value`);
INSERT INTO `site_settings` (`setting_key`, `setting_value`) VALUES ('stripe_secret_key', '') ON DUPLICATE KEY UPDATE `setting_value` = VALUES(`setting_value`);
INSERT INTO `site_settings` (`setting_key`, `setting_value`) VALUES ('smtp_host', 'send.one.com') ON DUPLICATE KEY UPDATE `setting_value` = VALUES(`setting_value`);
INSERT INTO `site_settings` (`setting_key`, `setting_value`) VALUES ('smtp_port', '465') ON DUPLICATE KEY UPDATE `setting_value` = VALUES(`setting_value`);
INSERT INTO `site_settings` (`setting_key`, `setting_value`) VALUES ('smtp_crypto', 'ssl') ON DUPLICATE KEY UPDATE `setting_value` = VALUES(`setting_value`);
INSERT INTO `site_settings` (`setting_key`, `setting_value`) VALUES ('smtp_user', 'info@peyug.in') ON DUPLICATE KEY UPDATE `setting_value` = VALUES(`setting_value`);
INSERT INTO `site_settings` (`setting_key`, `setting_value`) VALUES ('smtp_pass', '@peyug.in') ON DUPLICATE KEY UPDATE `setting_value` = VALUES(`setting_value`);

SET FOREIGN_KEY_CHECKS = 1;
