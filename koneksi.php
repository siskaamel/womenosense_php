<?php
// 1. Header untuk Keamanan dan CORS (Penting untuk Flutter)
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST, GET, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With");
header("Content-Type: application/json; charset=UTF-8");

// Menangani request OPTIONS (Preflight) dari browser/Flutter
if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
    http_response_code(200);
    exit();
}

// 2. // Railway ENV (otomatis ada di Variables)
$host = getenv('MYSQLHOST') ?: "localhost";
$user = getenv('MYSQLUSER') ?: "root";
$pass = getenv('MYSQLPASSWORD') ?: "";
$db   = getenv('MYSQLDATABASE') ?: "db_womenosense";
$port = getenv('MYSQLPORT') ?: "3306";

// 3. Eksekusi Koneksi
$conn = mysqli_connect($host, $user, $pass, $db, $port);

// 4. Cek Koneksi
if (!$conn) {
    echo json_encode([
        "status" => "error", 
        "message" => "Koneksi Gagal: " . mysqli_connect_error()
    ]);
    exit();
}

// Jika berhasil, tidak perlu echo apapun agar tidak mengganggu output JSON di file API lainnya
?>