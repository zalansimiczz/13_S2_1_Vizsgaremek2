<?php
require 'config.php';

$data = json_decode(file_get_contents("php://input"), true);

if (!isset($data['token'])) {
    http_response_code(401);
    echo json_encode(["error" => "No token provided"]);
    exit;
}

$token = $data['token'];

$stmt = $conn->prepare("
    SELECT felhasznalo_id 
    FROM felhasznalo_sessionok
    WHERE token = ? AND lejart_at > NOW()
    LIMIT 1
");
$stmt->execute([$token]);

$session = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$session) {
    http_response_code(401);
    echo json_encode(["error" => "Invalid or expired token"]);
    exit;
}

$userId = $session['felhasznalo_id'];