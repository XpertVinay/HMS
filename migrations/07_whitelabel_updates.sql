-- Add white-labeling columns to organizations
ALTER TABLE `organizations` ADD COLUMN `logo_url` VARCHAR(255) DEFAULT NULL;
ALTER TABLE `organizations` ADD COLUMN `primary_color` VARCHAR(20) DEFAULT NULL;
ALTER TABLE `organizations` ADD COLUMN `secondary_color` VARCHAR(20) DEFAULT NULL;
