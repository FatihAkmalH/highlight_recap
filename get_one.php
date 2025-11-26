<?php
require "db.php";

header("Content-Type: application/json; charset=UTF-8");

$tanggal = $_GET['tanggal'] ?? '';

if (!$tanggal) {
    echo json_encode([]);
    exit;
}

$stmt = $pdo->prepare("SELECT * FROM recap WHERE tanggal = :tgl LIMIT 1");
$stmt->execute([':tgl' => $tanggal]);

$data = $stmt->fetch(PDO::FETCH_ASSOC);

echo json_encode($data ?: []);
