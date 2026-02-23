<?php
require 'config.php';
require 'auth.php';

$userId = authenticate($conn);

$data = json_decode(file_get_contents("php://input"), true);

$lat = $data['lat'];
$lon = $data['lon'];
$speed = $data['speed'] ?? 0;

if ($lat < -90 || $lat > 90 || $lon < -180 || $lon > 180) {
    http_response_code(400);
    exit(json_encode(["error" => "Invalid coordinates"]));
}

$stmt = $conn->prepare("
    INSERT INTO tracker_poziciok (device_id, lat, lon, sebesseg_kmh)
    VALUES (?, ?, ?, ?)
");

$deviceId = 1; // demo device

$stmt->execute([$deviceId, $lat, $lon, $speed]);

echo json_encode(["success" => true]);