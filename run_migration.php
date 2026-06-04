<?php
require_once("Includes/Database.php");

$db = Database::getInstance();
$con = $db->getPDO();

// Create migrations table if it doesn't exist
$con->exec("
    CREATE TABLE IF NOT EXISTS migrations (
        id INT AUTO_INCREMENT PRIMARY KEY,
        migration_file VARCHAR(255) NOT NULL UNIQUE,
        executed_at DATETIME DEFAULT CURRENT_TIMESTAMP
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
");

$migrationsDir = __DIR__ . '/migrations/';
if (!is_dir($migrationsDir)) {
    echo "Migrations directory not found.\n";
    exit;
}

$files = scandir($migrationsDir);
$files = array_filter($files, function($file) {
    return pathinfo($file, PATHINFO_EXTENSION) === 'sql' || pathinfo($file, PATHINFO_EXTENSION) === 'php';
});
sort($files);

foreach ($files as $file) {
    $stmt = $con->prepare("SELECT COUNT(*) FROM migrations WHERE migration_file = :file");
    $stmt->execute([':file' => $file]);
    if ($stmt->fetchColumn() > 0) {
        // Already executed
        continue;
    }

    echo "Running migration: $file\n";
    try {
        if (pathinfo($file, PATHINFO_EXTENSION) === 'sql') {
            $sql = file_get_contents($migrationsDir . $file);
            
            // Split into individual queries to handle partial failures (like Duplicate Column) gracefully
            $queries = explode(';', $sql);
            foreach ($queries as $query) {
                $query = trim($query);
                if (empty($query)) continue;
                
                try {
                    $con->exec($query);
                } catch (PDOException $e) {
                    // Ignore duplicate column errors (1060 or 42S21)
                    if ($e->getCode() == '42S21' || strpos($e->getMessage(), 'Duplicate column name') !== false) {
                        echo "  Notice: " . $e->getMessage() . " (Ignored)\n";
                    } elseif ($e->getCode() == '42S01' || strpos($e->getMessage(), 'already exists') !== false) {
                         echo "  Notice: Table already exists (Ignored)\n";
                    } else {
                        throw $e;
                    }
                }
            }
        } elseif (pathinfo($file, PATHINFO_EXTENSION) === 'php') {
            require_once $migrationsDir . $file;
        }

        $stmt = $con->prepare("INSERT INTO migrations (migration_file) VALUES (:file)");
        $stmt->execute([':file' => $file]);
        echo "Successfully migrated: $file\n";

    } catch (Exception $e) {
        echo "Migration failed for $file: " . $e->getMessage() . "\n";
        exit(1);
    }
}

echo "All migrations executed successfully.\n";
?>
