-- NGO Management Step 1: members + donations (run after cms_install.sql)
-- MySQL 5.7+ / MariaDB

CREATE TABLE IF NOT EXISTS `members` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `public_id` CHAR(32) NOT NULL,
  `name` VARCHAR(191) NOT NULL,
  `mobile` VARCHAR(32) NOT NULL DEFAULT '',
  `email` VARCHAR(191) NOT NULL DEFAULT '',
  `photo` VARCHAR(255) NULL,
  `role` VARCHAR(64) NOT NULL DEFAULT 'member',
  `status` VARCHAR(32) NOT NULL DEFAULT 'active',
  `joining_date` DATE NULL,
  `referral_code` VARCHAR(32) NOT NULL,
  `added_by` INT UNSIGNED NULL,
  `notes` TEXT NULL,
  `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uniq_public_id` (`public_id`),
  UNIQUE KEY `uniq_referral` (`referral_code`),
  KEY `idx_status` (`status`),
  KEY `idx_joining` (`joining_date`),
  KEY `idx_added_by` (`added_by`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS `donations` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(191) NOT NULL,
  `mobile` VARCHAR(32) NOT NULL DEFAULT '',
  `email` VARCHAR(191) NOT NULL DEFAULT '',
  `amount` DECIMAL(12,2) NOT NULL,
  `currency` VARCHAR(8) NOT NULL DEFAULT 'INR',
  `razorpay_order_id` VARCHAR(64) NULL,
  `payment_id` VARCHAR(64) NULL,
  `signature_verified` TINYINT(1) NOT NULL DEFAULT 0,
  `status` VARCHAR(32) NOT NULL DEFAULT 'pending',
  `receipt_no` VARCHAR(32) NULL,
  `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uniq_payment_id` (`payment_id`),
  KEY `idx_order` (`razorpay_order_id`),
  KEY `idx_created` (`created_at`),
  KEY `idx_status` (`status`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
