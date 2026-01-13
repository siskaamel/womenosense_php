<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST, GET, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With");
header("Content-Type: application/json");

if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
    exit;
}

require_once "koneksi.php";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $username = trim($_POST['username'] ?? '');
    $email    = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';

    if ($username && $email && $password) {

        $hashed = password_hash($password, PASSWORD_DEFAULT);

        $stmt = $conn->prepare(
            "INSERT INTO users (username, email, password) VALUES (?, ?, ?)"
        );

        $stmt->bind_param("sss", $username, $email, $hashed);

        if ($stmt->execute()) {
            echo json_encode([
                "status" => "success",
                "message" => "Berhasil mendaftar"
            ]);
        } else {
            echo json_encode([
                "status" => "error",
                "message" => "Gagal daftar",
                "detail" => $stmt->error
            ]);
        }

        $stmt->close();

    } else {
        echo json_encode([
            "status" => "error",
            "message" => "Data tidak lengkap"
        ]);
    }

} else {
    echo json_encode([
        "status" => "error",
        "message" => "Metode salah"
    ]);
}
