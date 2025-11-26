<?php
include "db.php"; // pastikan berisi $pdo

$tanggal          = $_POST['tanggal'] ?? null;
$notes            = $_POST['notes'] ?? null;
$movie            = $_POST['movie'] ?? null;
$sports           = $_POST['sports'] ?? null;
$new_program      = $_POST['new_program'] ?? null;
$program_special  = $_POST['program_special'] ?? null;
$series           = $_POST['series'] ?? null;

if (!$tanggal) {
    echo "NO_DATE";
    exit;
}

$sql = "
INSERT INTO recap (tanggal, notes, movie, sports, new_program, program_special, series)
VALUES (:tanggal, :notes, :movie, :sports, :new_program, :program_special, :series)
ON DUPLICATE KEY UPDATE
    notes = VALUES(notes),
    movie = VALUES(movie),
    sports = VALUES(sports),
    new_program = VALUES(new_program),
    program_special = VALUES(program_special),
    series = VALUES(series)
";

$stmt = $pdo->prepare($sql);
$stmt->execute([
    ":tanggal"          => $tanggal,
    ":notes"            => $notes,
    ":movie"            => $movie,
    ":sports"           => $sports,
    ":new_program"      => $new_program,
    ":program_special"  => $program_special,
    ":series"           => $series,
]);

echo "OK";
