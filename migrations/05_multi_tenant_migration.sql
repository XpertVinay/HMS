-- Multi-tenant and Super Admin migration

-- 1. Create super_admin table
CREATE TABLE IF NOT EXISTS `super_admin` (
    `id` INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
    `username` VARCHAR(50) NOT NULL UNIQUE,
    `email` VARCHAR(100) NOT NULL UNIQUE,
    `password` VARCHAR(255) NOT NULL,
    `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Insert a default super admin (password: password)
INSERT INTO `super_admin` (`username`, `email`, `password`) VALUES ('superadmin', 'superadmin@businzo.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi') ON DUPLICATE KEY UPDATE `id`=`id`;

-- 2. Create organizations table
CREATE TABLE IF NOT EXISTS `organizations` (
    `id` INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
    `name` VARCHAR(255) NOT NULL,
    `address` TEXT NOT NULL,
    `registration_code` VARCHAR(100) NOT NULL UNIQUE,
    `subdomain` VARCHAR(100) NOT NULL UNIQUE,
    `status` ENUM('pending', 'approved', 'rejected') NOT NULL DEFAULT 'pending',
    `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Insert a default organization for existing users (assuming they belong to a primary one initially, for backwards compatibility)
INSERT INTO `organizations` (`id`, `name`, `address`, `registration_code`, `subdomain`, `status`) VALUES (1, 'Default RWA', 'Default Address', 'DEFAULT-RWA-001', 'default', 'approved') ON DUPLICATE KEY UPDATE `id`=`id`;

-- 3. Add organization_id to existing tables
-- admin
ALTER TABLE `admin` ADD COLUMN `organization_id` INT NOT NULL DEFAULT 1;
ALTER TABLE `admin` ADD COLUMN `role` ENUM('admin', 'sub-admin') NOT NULL DEFAULT 'admin';
ALTER TABLE `admin` ADD CONSTRAINT `fk_admin_org` FOREIGN KEY (`organization_id`) REFERENCES `organizations`(`id`) ON DELETE CASCADE;

-- member
ALTER TABLE `member` ADD COLUMN `organization_id` INT NOT NULL DEFAULT 1;
ALTER TABLE `member` ADD CONSTRAINT `fk_member_org` FOREIGN KEY (`organization_id`) REFERENCES `organizations`(`id`) ON DELETE CASCADE;

-- staff
ALTER TABLE `staff` ADD COLUMN `organization_id` INT NOT NULL DEFAULT 1;
ALTER TABLE `staff` ADD CONSTRAINT `fk_staff_org` FOREIGN KEY (`organization_id`) REFERENCES `organizations`(`id`) ON DELETE CASCADE;

-- billing
ALTER TABLE `maintenance` ADD COLUMN `organization_id` INT NOT NULL DEFAULT 1;
ALTER TABLE `maintenance` ADD CONSTRAINT `fk_billing_org` FOREIGN KEY (`organization_id`) REFERENCES `organizations`(`id`) ON DELETE CASCADE;

-- bills
ALTER TABLE `maintenance_items` ADD COLUMN `organization_id` INT NOT NULL DEFAULT 1;
ALTER TABLE `maintenance_items` ADD CONSTRAINT `fk_bills_org` FOREIGN KEY (`organization_id`) REFERENCES `organizations`(`id`) ON DELETE CASCADE;

-- registry
ALTER TABLE `registry` ADD COLUMN `organization_id` INT NOT NULL DEFAULT 1;
ALTER TABLE `registry` ADD CONSTRAINT `fk_registry_org` FOREIGN KEY (`organization_id`) REFERENCES `organizations`(`id`) ON DELETE CASCADE;

-- announcement
ALTER TABLE `announcement` ADD COLUMN `organization_id` INT NOT NULL DEFAULT 1;
ALTER TABLE `announcement` ADD CONSTRAINT `fk_announcement_org` FOREIGN KEY (`organization_id`) REFERENCES `organizations`(`id`) ON DELETE CASCADE;

-- donors
ALTER TABLE `donors` ADD COLUMN `organization_id` INT NOT NULL DEFAULT 1;
ALTER TABLE `donors` ADD CONSTRAINT `fk_donors_org` FOREIGN KEY (`organization_id`) REFERENCES `organizations`(`id`) ON DELETE CASCADE;

-- sponsors
ALTER TABLE `sponsors` ADD COLUMN `organization_id` INT NOT NULL DEFAULT 1;
ALTER TABLE `sponsors` ADD CONSTRAINT `fk_sponsors_org` FOREIGN KEY (`organization_id`) REFERENCES `organizations`(`id`) ON DELETE CASCADE;

-- events
ALTER TABLE `events` ADD COLUMN `organization_id` INT NOT NULL DEFAULT 1;
ALTER TABLE `events` ADD CONSTRAINT `fk_events_org` FOREIGN KEY (`organization_id`) REFERENCES `organizations`(`id`) ON DELETE CASCADE;

-- gallery
ALTER TABLE `gallery` ADD COLUMN `organization_id` INT NOT NULL DEFAULT 1;
ALTER TABLE `gallery` ADD CONSTRAINT `fk_gallery_org` FOREIGN KEY (`organization_id`) REFERENCES `organizations`(`id`) ON DELETE CASCADE;
