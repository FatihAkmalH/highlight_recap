<?php
require "db.php";

$tanggal = $_GET["tanggal"] ?? "";

$stmt = $pdo->prepare("SELECT typing_user, typing_time
                       FROM recap WHERE tanggal = :t");
$stmt->execute([":t" => $tanggal]);
$row = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$row || !$row["typing_time"] || !$row["typing_user"]) {
    echo json_encode(["status" => ""]);
    exit;
}

// Cek timeout (lebih dari 3 detik dianggap stop)
if (time() - strtotime($row["typing_time"]) > 3) {
    echo json_encode(["status" => ""]);
    exit;
}

$list = explode("||", $row["typing_user"]);
$list = array_filter($list, fn($v) => trim($v) != "");
$list = array_values($list);

$count = count($list);

// Tidak ada yang mengetik
if ($count === 0) {
    echo json_encode(["status" => ""]);
    exit;
}

// Format kalimat:
if ($count === 1) {
    $text = "{$list[0]} sedang mengetik...";
} elseif ($count === 2) {
    $text = "{$list[0]} dan {$list[1]} sedang mengetik...";
} else {
    // contoh: Budi, Andi, Siska
    $last = array_pop($list);
    $text = implode(", ", $list) . " dan " . $last . " sedang mengetik...";
}

echo json_encode(["status" => $text]);
