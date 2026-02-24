<?php
require 'config.php';

header("Content-Type: application/json");

$data = json_decode(file_get_contents("php://input"), true);

$email = $data['email'] ?? '';
$password = $data['password'] ?? '';

$stmt = $conn->prepare("SELECT * FROM felhasznalok WHERE email = ?");
$stmt->execute([$email]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

if ($user && password_verify($password, $user['jelszo_hash']) && $user['aktiv'] == 1) {

    $token = bin2hex(random_bytes(32));
    $expiry = date("Y-m-d H:i:s", strtotime("+7 days"));

    $stmt = $conn->prepare("INSERT INTO felhasznalo_sessionok (felhasznalo_id, token, lejart_at) VALUES (?, ?, ?)");
    $stmt->execute([$user['id'], $token, $expiry]);

    echo json_encode(["success" => true, "token" => $token]);

} else {
    http_response_code(401);
    echo json_encode(["success" => false]);
}