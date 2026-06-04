ALTER TABLE `registry` DROP INDEX `person_name`;
ALTER TABLE `registry` CHANGE `person_name` `visitor_name` VARCHAR(50) NOT NULL;
ALTER TABLE `registry` ADD COLUMN `host_id` INT DEFAULT NULL;
ALTER TABLE `registry` ADD COLUMN `visitor_contact` VARCHAR(20) DEFAULT NULL;
ALTER TABLE `registry` ADD COLUMN `purpose` VARCHAR(255) DEFAULT NULL;
ALTER TABLE `registry` ADD COLUMN `status` ENUM('Pending', 'Approved', 'Rejected', 'Completed') DEFAULT 'Pending';
ALTER TABLE `registry` ADD COLUMN `out_time` DATETIME DEFAULT NULL;
ALTER TABLE `registry` ADD CONSTRAINT `fk_registry_host` FOREIGN KEY (`host_id`) REFERENCES `member` (`id`) ON DELETE SET NULL;
