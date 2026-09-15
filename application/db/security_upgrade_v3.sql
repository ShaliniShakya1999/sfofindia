-- Security and integrity upgrade v3.
--
-- Run this file with a database user that can ALTER TABLE and CREATE TABLE.
-- It is safe to run against fresh installations: existing indexes/columns are
-- detected and skipped. The migration aborts before changing schema if
-- duplicate non-empty receipt_no or payment_id values exist.

DELIMITER $$

DROP PROCEDURE IF EXISTS `sfof_security_upgrade_v3`$$

CREATE PROCEDURE `sfof_security_upgrade_v3`()
BEGIN
  DECLARE duplicate_receipts INT DEFAULT 0;
  DECLARE duplicate_payments INT DEFAULT 0;
  DECLARE has_receipt_index INT DEFAULT 0;
  DECLARE has_payment_index INT DEFAULT 0;
  DECLARE has_ip_column INT DEFAULT 0;
  DECLARE has_user_agent_column INT DEFAULT 0;
  DECLARE has_notification_link INT DEFAULT 0;

  IF NOT EXISTS (
    SELECT 1
    FROM information_schema.tables
    WHERE table_schema = DATABASE() AND table_name = 'donations'
  ) THEN
    SIGNAL SQLSTATE '45000'
      SET MESSAGE_TEXT = 'Migration stopped: donations table does not exist.';
  END IF;

  SELECT COUNT(*) INTO duplicate_receipts
  FROM (
    SELECT receipt_no
    FROM donations
    WHERE receipt_no IS NOT NULL AND receipt_no <> ''
    GROUP BY receipt_no
    HAVING COUNT(*) > 1
  ) AS duplicate_receipt_rows;

  IF duplicate_receipts > 0 THEN
    SIGNAL SQLSTATE '45000'
      SET MESSAGE_TEXT = 'Migration stopped: duplicate non-empty receipt_no values exist.';
  END IF;

  SELECT COUNT(*) INTO duplicate_payments
  FROM (
    SELECT payment_id
    FROM donations
    WHERE payment_id IS NOT NULL AND payment_id <> ''
    GROUP BY payment_id
    HAVING COUNT(*) > 1
  ) AS duplicate_payment_rows;

  IF duplicate_payments > 0 THEN
    SIGNAL SQLSTATE '45000'
      SET MESSAGE_TEXT = 'Migration stopped: duplicate non-empty payment_id values exist.';
  END IF;

  IF EXISTS (
    SELECT 1
    FROM information_schema.tables
    WHERE table_schema = DATABASE() AND table_name = 'ngom_notifications'
  ) THEN
    SELECT COUNT(*) INTO has_notification_link
    FROM information_schema.columns
    WHERE table_schema = DATABASE()
      AND table_name = 'ngom_notifications'
      AND column_name = 'link';

    IF has_notification_link = 0 THEN
      ALTER TABLE `ngom_notifications`
        ADD COLUMN `link` VARCHAR(255) NULL AFTER `message`;
    END IF;
  ELSE
    CREATE TABLE `ngom_notifications` (
      `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
      `type` VARCHAR(16) NOT NULL DEFAULT 'info',
      `title` VARCHAR(191) NOT NULL,
      `message` TEXT NULL,
      `link` VARCHAR(255) NULL,
      `is_read` TINYINT(1) NOT NULL DEFAULT 0,
      `created_at` DATETIME NOT NULL,
      PRIMARY KEY (`id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
  END IF;

  SELECT COUNT(*) INTO has_receipt_index
  FROM information_schema.statistics
  WHERE table_schema = DATABASE()
    AND table_name = 'donations'
    AND index_name = 'uniq_receipt_no';

  IF has_receipt_index = 0 THEN
    ALTER TABLE `donations`
      ADD UNIQUE KEY `uniq_receipt_no` (`receipt_no`);
  END IF;

  SELECT COUNT(*) INTO has_payment_index
  FROM information_schema.statistics
  WHERE table_schema = DATABASE()
    AND table_name = 'donations'
    AND index_name = 'uniq_payment_id';

  IF has_payment_index = 0 THEN
    ALTER TABLE `donations`
      ADD UNIQUE KEY `uniq_payment_id` (`payment_id`);
  END IF;

  IF NOT EXISTS (
    SELECT 1
    FROM information_schema.tables
    WHERE table_schema = DATABASE() AND table_name = 'ngom_admin_activity'
  ) THEN
    SIGNAL SQLSTATE '45000'
      SET MESSAGE_TEXT = 'Migration stopped: ngom_admin_activity table does not exist.';
  END IF;

  SELECT COUNT(*) INTO has_ip_column
  FROM information_schema.columns
  WHERE table_schema = DATABASE()
    AND table_name = 'ngom_admin_activity'
    AND column_name = 'ip_address';

  IF has_ip_column = 0 THEN
    ALTER TABLE `ngom_admin_activity`
      ADD COLUMN `ip_address` VARCHAR(45) NULL AFTER `detail`;
  END IF;

  SELECT COUNT(*) INTO has_user_agent_column
  FROM information_schema.columns
  WHERE table_schema = DATABASE()
    AND table_name = 'ngom_admin_activity'
    AND column_name = 'user_agent';

  IF has_user_agent_column = 0 THEN
    ALTER TABLE `ngom_admin_activity`
      ADD COLUMN `user_agent` VARCHAR(255) NULL AFTER `ip_address`;
  END IF;

  CREATE TABLE IF NOT EXISTS `razorpay_webhook_events` (
    `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
    `event_id` VARCHAR(128) NOT NULL,
    `payment_id` VARCHAR(64) NULL,
    `status` VARCHAR(32) NOT NULL DEFAULT 'received',
    `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `updated_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`),
    UNIQUE KEY `uniq_webhook_event_id` (`event_id`),
    KEY `idx_webhook_payment_id` (`payment_id`)
  ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
END$$

CALL `sfof_security_upgrade_v3`()$$

DROP PROCEDURE `sfof_security_upgrade_v3`$$

DELIMITER ;

-- Production deployments should keep private member documents outside the web root.
