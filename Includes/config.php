<?php
if (basename(__FILE__) == basename($_SERVER["SCRIPT_FILENAME"])) { die('Direct access not permitted.'); }

require_once(__DIR__ . "/Database.php");

// Backward compatibility: instantiate the singleton and expose $con
$db = Database::getInstance();
$con = $db->getConnection();
?>