<?php
include "db.php";

$tanggal = $_GET['tanggal'] ?? '';

if (!$tanggal) {
    echo "";
    exit;
}

$stmt = $pdo->prepare("
    SELECT *
    FROM recap
    WHERE tanggal = :tgl
    LIMIT 1
");
$stmt->execute([':tgl' => $tanggal]);
$data = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$data) {
    echo "";
    exit;
}

$hari = [
    'Sunday' => 'Minggu',
    'Monday' => 'Senin',
    'Tuesday' => 'Selasa',
    'Wednesday' => 'Rabu',
    'Thursday' => 'Kamis',
    'Friday' => 'Jumat',
    'Saturday' => 'Sabtu'
];

$dayName = $hari[date("l", strtotime($data['tanggal']))];
$tglID   = date("d F Y", strtotime($data['tanggal']));

function addBlock($title, $content){
    if (!trim($content)) return "";
    return "*[$title]*\n{$content}\n\n";
}

$output  = "*Berikut Recap Movie, Series, Sports, Special, New Program*\n";
$output .= "*{$dayName}, {$tglID}*\n\n";

$output .= addBlock("NOTES",        $data['notes']);
$output .= addBlock("MOVIE",        $data['movie']);
$output .= addBlock("SPORTS",       $data['sports']);
$output .= addBlock("NEW PROGRAM",  $data['new_program']);
$output .= addBlock("SPECIAL",      $data['program_special']);
$output .= addBlock("SERIES",       $data['series']);

echo trim($output);
