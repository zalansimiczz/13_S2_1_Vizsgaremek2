<?php
require 'config.php';

function authenticate($conn) {

    $headers = getallheaders();
    $authHeader = $headers['Authorization'] ?? '';

    if (!str_starts_with($authHeader, 'Bearer ')) {
        http_response_code(401);
        exit(json_encode(["error" => "Unauthorized"]));
    }

    $token = substr($authHeader, 7);

    $stmt = $conn->prepare("
        SELECT * FROM felhasznalo_sessionok
        WHERE token = ? AND lejart_at > NOW()
    ");
    $stmt->execute([$token]);
    $session = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$session) {
        http_response_code(401);
        exit(json_encode(["error" => "Invalid or expired token"]));
    }

    return $session['felhasznalo_id'];
}