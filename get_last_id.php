<?php
require "db.php";

$stmt = $pdo->query("SELECT id FROM recap ORDER BY id DESC LIMIT 1");
$last = $stmt->fetch(PDO::FETCH_ASSOC);

echo $last ? $last['id'] : 0;
