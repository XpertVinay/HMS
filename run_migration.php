<?php
require_once "./Includes/config.php";

$sql = file_get_contents("multi_tenant_migration.sql");
$queries = explode(";", $sql);

$pdo = Database::getInstance()->getPDO();

foreach ($queries as $query) {
    $q = trim($query);
    if (!empty($q)) {
        try {
            $pdo->exec($q);
            echo "Executed successfully.\n";
        } catch (PDOException $e) {
            echo "Error executing query: " . $e->getMessage() . "\n";
            echo "Query: $q\n\n";
        }
    }
}
echo "Migration complete.\n";
