<?php

function requireAuth($allowedRoles = [])
{
    header("Content-Type: application/json");

    $headers = getallheaders();

    if (!isset($headers['Authorization'])) {
        http_response_code(401);
        echo json_encode([
            "success" => false,
            "message" => "Hiányzó token"
        ]);
        exit;
    }

    $token = str_replace("Bearer ", "", $headers['Authorization']);

    try {
        $pdo = new PDO(
            "mysql:host=localhost;dbname=tollutdijadatbazis;charset=utf8mb4",
            "root",
            "",
            [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
        );
    } catch (PDOException $e) {
        http_response_code(500);
        echo json_encode([
            "success" => false,
            "message" => "Adatbázis hiba"
        ]);
        exit;
    }

    $stmt = $pdo->prepare("
        SELECT f.id, f.ceg_id, f.role, s.lejart_at
        FROM felhasznalo_sessionok s
        JOIN felhasznalok f ON s.felhasznalo_id = f.id
        WHERE s.token = ?
    ");
    $stmt->execute([$token]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$user) {
        http_response_code(401);
        echo json_encode([
            "success" => false,
            "message" => "Érvénytelen token"
        ]);
        exit;
    }

    if (strtotime($user['lejart_at']) < time()) {
        http_response_code(401);
        echo json_encode([
            "success" => false,
            "message" => "Token lejárt"
        ]);
        exit;
    }

    if (!empty($allowedRoles) && !in_array($user['role'], $allowedRoles)) {
        http_response_code(403);
        echo json_encode([
            "success" => false,
            "message" => "Nincs jogosultság"
        ]);
        exit;
    }

    return $user; // visszaadjuk a bejelentkezett user adatait
}
