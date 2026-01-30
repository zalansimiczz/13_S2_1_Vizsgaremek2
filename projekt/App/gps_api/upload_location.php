<?php
header('Content-Type: application/json');
$conn = new mysqli('localhost', 'root', 'mysql', 'tollutdijadatbazis');

$data = json_decode(file_get_contents("php://input"), true);

$device_id = (int)$data['device_id'];
$menetlevel_id = isset($data['menetlevel_id']) ? (int)$data['menetlevel_id'] : null;
$lat = (float)$data['latitude'];
$lon = (float)$data['longitude'];
$seb = isset($data['sebesseg']) ? (float)$data['sebesseg'] : null;
$raw = json_encode($data);

$stmt = $conn->prepare("
    INSERT INTO tracker_poziciok 
    (device_id, menetlevel_id, idobelyeg, lat, lon, sebesseg_kmh, nyers_payload)
    VALUES (?, ?, NOW(), ?, ?, ?, ?)
");

$stmt->bind_param("iiddss", $device_id, $menetlevel_id, $lat, $lon, $seb, $raw);
$stmt->execute();

echo json_encode(['status' => 'ok']);