<?php
require 'config.php';
require 'auth.php';

header("Content-Type: application/json");

$data = json_decode(file_get_contents("php://input"), true);

if (!isset($data['lat']) || !isset($data['lon'])) {
    http_response_code(400);
    echo json_encode(["error" => "Missing coordinates"]);
    exit;
}

$lat = $data['lat'];
$lon = $data['lon'];

$userId = $userId;

$deviceId = $userId;

$stmt = $conn->prepare("
    INSERT INTO tracker_poziciok (user_id, device_id, lat, lon)
    VALUES (?, ?, ?, ?)
");

$stmt->execute([$userId, $deviceId, $lat, $lon]);

echo json_encode(["success" => true]);