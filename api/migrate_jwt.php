<?php
require_once __DIR__ . '/../Includes/Database.php';

$pdo = Database::getInstance()->getPDO();

$sql = "
CREATE TABLE IF NOT EXISTS jwt_denylist (
    jti VARCHAR(128) PRIMARY KEY,
    user_id INT NOT NULL,
    expires_at DATETIME NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
";

try {
    $pdo->exec($sql);
    echo "jwt_denylist table created successfully.\n";
} catch (PDOException $e) {
    echo "Error creating table: " . $e->getMessage() . "\n";
}
