<?php
require "db.php"; // pastikan berisi $pdo

$tanggal = $_GET['tanggal'] ?? '';

$stmt = $pdo->prepare("SELECT * FROM recap WHERE tanggal = :tgl");
$stmt->execute([":tgl" => $tanggal]);

$data = $stmt->fetch(PDO::FETCH_ASSOC);

if ($data) {
    $hash = md5(json_encode($data, JSON_UNESCAPED_UNICODE));
} else {
    $hash = "";
}

header("Content-Type: application/json");
echo json_encode(["hash" => $hash]);
