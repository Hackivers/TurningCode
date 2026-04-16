<?php
$dsn = "mysql:host=metro.proxy.rlwy.net;port=58294;dbname=railway;charset=utf8mb4";
$user = "root";
$pass = "vgVMnUjzJUSLIdrzoagRcntBpvxOOYWL";

try {
    $pdo = new PDO($dsn, $user, $pass, [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
    $stmt = $pdo->query("SELECT id, attempts, reserved_at, available_at FROM jobs ORDER BY id ASC LIMIT 5");
    print_r($stmt->fetchAll(PDO::FETCH_ASSOC));
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}
