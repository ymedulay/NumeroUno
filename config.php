<?php
define('DB_SERVER', 'sql102.infinityfree.com');
define('DB_USERNAME', 'if0_38515794');
define('DB_PASSWORD', 'XR664iQyMf');
define('DB_NAME', 'if0_38515794_uno_db');

    try {
        $pdo = new PDO("mysql:host=" . DB_SERVER . ";dbname=" . DB_NAME . ";charset=utf8", DB_USERNAME, DB_PASSWORD);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch (PDOException $e) {
        die("Connection failed: " . $e->getMessage());
    }
?>



