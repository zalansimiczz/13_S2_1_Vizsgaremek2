<?php
$host = "localhost";
$db = "tollutdijadatbazis";
$user = "root";
$pass = "mysql";

$conn = new PDO("mysql:host=$host;dbname=$db;charset=utf8mb4", $user, $pass);
$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
?>