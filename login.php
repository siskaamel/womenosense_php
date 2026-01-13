<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");
header("Content-Type: application/json");

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    echo json_encode(["status" => "ok"]);
    exit;
}

require_once "koneksi.php";

$username = strtolower(trim($_POST['username'] ?? ''));
$password = $_POST['password'] ?? '';

$stmt = $conn->prepare("SELECT id, username, password FROM users WHERE LOWER(username)=?");
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    echo json_encode(["status" => "error", "message" => "User tidak ditemukan"]);
    exit;
}

$user = $result->fetch_assoc();

if (!password_verify($password, $user['password'])) {
    echo json_encode(["status" => "error", "message" => "Password salah"]);
    exit;
}

echo json_encode([
    "status" => "success",
    "user_id" => $user['id'],
    "username" => $user['username']
]);