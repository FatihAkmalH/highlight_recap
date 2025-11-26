<?php
require "db.php";

$tanggal = $_POST['tanggal'] ?? '';

if (!$tanggal) {
    echo "NO_DATE";
    exit;
}

$stmt = $pdo->prepare("DELETE FROM recap WHERE tanggal = :tanggal");
$stmt->execute([':tanggal' => $tanggal]);

echo "OK";
