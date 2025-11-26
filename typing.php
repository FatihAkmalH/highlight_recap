<?php
require "db.php";

$tanggal = $_POST["tanggal"] ?? "";
$user    = trim($_POST["user"] ?? "");
$action  = $_POST["action"] ?? "typing"; // typing / stop

if (!$tanggal) exit;

$stmt = $pdo->prepare("SELECT typing_user FROM recap WHERE tanggal = :t");
$stmt->execute([":t" => $tanggal]);
$row = $stmt->fetch(PDO::FETCH_ASSOC);

$current = $row["typing_user"] ?? "";
$list = $current ? explode("||", $current) : [];

// Bersihkan array
$list = array_filter($list, fn($v) => trim($v) != "");

// === USER BERHENTI MENGETIK ===
if ($action === "stop") {

    // hapus user dari list
    $list = array_filter($list, fn($v) => $v !== $user);

    $final = implode("||", $list);

    $stmt = $pdo->prepare("
        UPDATE recap 
        SET typing_user = :u, typing_time = NOW()
        WHERE tanggal = :t
    ");
    $stmt->execute([
        ":u" => $final,
        ":t" => $tanggal
    ]);

    echo "STOPPED";
    exit;
}

// === USER MULAI MENGETIK ===
if (!in_array($user, $list)) {
    $list[] = $user;
}

$final = implode("||", $list);

$stmt = $pdo->prepare("
    UPDATE recap 
    SET typing_user = :u, typing_time = NOW()
    WHERE tanggal = :t
");
$stmt->execute([
    ":u" => $final,
    ":t" => $tanggal
]);

echo "OK";
