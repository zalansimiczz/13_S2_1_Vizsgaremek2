<?php
header('Content-Type: application/json');
$conn = new mysqli('localhost', 'root', 'mysql', 'tollutdijadatbazis');

$data = json_decode(file_get_contents("php://input"), true);

if (!$data || !isset($data['email']) || !isset($data['password'])) {
    echo json_encode(['status' => 'error', 'message' => 'Hiányzó adatok']);
    exit;
}

$email = $conn->real_escape_string($data['email']);
$password = $data['password'];

$result = $conn->query("SELECT * FROM felhasznalok WHERE email='$email' AND aktiv=1");

if ($result->num_rows > 0) {
    $user = $result->fetch_assoc();
    if (password_verify($password, $user['jelszo_hash'])) {
        echo json_encode([
            'status' => 'success',
            'user_id' => $user['id'],
            'ceg_id' => $user['ceg_id']
        ]);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Hibás jelszó']);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'Nincs ilyen aktív felhasználó']);
}