<?php
session_start();

if (isset($_POST["name"])) {
    $_SESSION["username"] = trim($_POST["name"]);
    echo "OK";
}