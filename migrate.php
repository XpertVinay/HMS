<?php
require_once 'Includes/config.php';
$conn = $con;

// Check if run from CLI or Web for output formatting
$is_cli = php_sapi_name() === 'cli';
function out($msg) {
    global $is_cli;
    echo $msg . ($is_cli ? "\n" : "<br>\n");
}

out("Starting database migrations...");

// 1. Create a table to track which migrations have run
$conn->query("CREATE TABLE IF NOT EXISTS `migrations` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `migration_file` VARCHAR(255) NOT NULL UNIQUE,
    `executed_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)");

$migrations_dir = __DIR__ . '/migrations';
if (!is_dir($migrations_dir)) {
    out("Migrations directory not found!");
    exit(1);
}

// Get all .sql files and sort them alphabetically
$files = scandir($migrations_dir);
sort($files);

// Safe MySQL error codes to ignore (makes the script idempotent)
$safe_error_codes = [
    1050, // Table already exists
    1060, // Duplicate column name
    1061, // Duplicate key name
    1062, // Duplicate entry for PRIMARY/UNIQUE key
    1091, // Can't drop field/key (doesn't exist)
    1146, // Table doesn't exist (if trying to drop/rename a table that's already dropped/renamed)
    1826, // Duplicate foreign key constraint name
];

foreach ($files as $file) {
    if (pathinfo($file, PATHINFO_EXTENSION) === 'sql') {
        
        // Check if already executed
        $stmt = $conn->prepare("SELECT id FROM migrations WHERE migration_file = ?");
        $stmt->bind_param("s", $file);
        $stmt->execute();
        
        if ($stmt->get_result()->num_rows === 0) {
            out("---------------------------------");
            out("Executing $file...");
            $sql = file_get_contents($migrations_dir . '/' . $file);
            
            // Split by semicolon to run queries individually
            // This is required so we can catch and ignore specific safe errors per query
            $queries = array_filter(array_map('trim', explode(';', $sql)));
            $has_fatal_error = false;
            
            foreach ($queries as $query) {
                if (empty($query)) continue;
                
                try {
                    $conn->query($query);
                } catch (mysqli_sql_exception $e) {
                    $errno = $e->getCode();
                    $error = $e->getMessage();
                    
                    if (in_array($errno, $safe_error_codes)) {
                        out("  [Ignored safe error $errno]: $error");
                    } else {
                        out("  [FATAL ERROR $errno]: $error");
                        out("  Query: $query");
                        $has_fatal_error = true;
                        break;
                    }
                }
            }
            
            if (!$has_fatal_error) {
                $stmt = $conn->prepare("INSERT INTO migrations (migration_file) VALUES (?)");
                $stmt->bind_param("s", $file);
                $stmt->execute();
                out("Success: $file");
            } else {
                out("Migration stopped due to fatal error in $file.");
                exit(1);
            }
        } else {
            out("Skipping $file (already executed).");
        }
    }
}
out("---------------------------------");
out("All migrations are complete and up-to-date.");
?>
