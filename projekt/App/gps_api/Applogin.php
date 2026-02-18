<?php
header("Content-Type: application/json");

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode([
        "success" => false,
        "message" => "Csak POST engedélyezett"
    ]);
    exit;
}

$input = json_decode(file_get_contents("php://input"), true);

if (
    !isset($input['email']) ||
    !isset($input['password']) ||
    empty($input['email']) ||
    empty($input['password'])
) {
    http_response_code(400);
    echo json_encode([
        "success" => false,
        "message" => "Hiányzó adatok"
    ]);
    exit;
}

$email = trim($input['email']);
$password = $input['password'];

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
    SELECT id, ceg_id, jelszo_hash, role
    FROM felhasznalok
    WHERE email = ? AND aktiv = 1
");
$stmt->execute([$email]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$user) {
    http_response_code(401);
    echo json_encode([
        "success" => false,
        "message" => "Nincs ilyen aktív felhasználó"
    ]);
    exit;
}

if (!password_verify($password, $user['jelszo_hash'])) {
    http_response_code(401);
    echo json_encode([
        "success" => false,
        "message" => "Hibás jelszó"
    ]);
    exit;
}

$token = bin2hex(random_bytes(32));
$expiresAt = date("Y-m-d H:i:s", strtotime("+8 hours"));

$insert = $pdo->prepare("
    INSERT INTO felhasznalo_sessionok
    (felhasznalo_id, token, lejart_at)
    VALUES (?, ?, ?)
");
$insert->execute([
    $user['id'],
    $token,
    $expiresAt
]);

http_response_code(200);
echo json_encode([
    "success" => true,
    "user" => [
        "id" => (int)$user['id'],
        "ceg_id" => (int)$user['ceg_id'],
        "role" => $user['role']
    ],
    "token" => $token,
    "expires_at" => $expiresAt
]);
