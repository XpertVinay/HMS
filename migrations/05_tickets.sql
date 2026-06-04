CREATE TABLE IF NOT EXISTS `tickets` (
    `id` INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
    `organization_id` INT NOT NULL DEFAULT 1,
    `member_id` INT NOT NULL,
    `subject` VARCHAR(255) NOT NULL,
    `description` TEXT NOT NULL,
    `category` VARCHAR(100) NOT NULL,
    `status` ENUM('pending', 'in_progress', 'resolved') NOT NULL DEFAULT 'pending',
    `response` TEXT DEFAULT NULL,
    `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT `fk_tickets_org` FOREIGN KEY (`organization_id`) REFERENCES `organizations`(`id`) ON DELETE CASCADE,
    CONSTRAINT `fk_tickets_member` FOREIGN KEY (`member_id`) REFERENCES `member`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
