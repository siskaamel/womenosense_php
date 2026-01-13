<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Content-Type");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Content-Type: application/json");

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') exit;

include "koneksi.php";

$user_id = $_GET['user_id'] ?? null;
$tanggal = $_GET['tanggal'] ?? null;

if (!$user_id || !$tanggal) {
    echo json_encode(["status" => false, "message"=>"Parameter kurang"]);
    exit;
}

$sql = "SELECT * FROM promil_checklist 
        WHERE user_id = ? AND tanggal = ? LIMIT 1";

$stmt = $conn->prepare($sql);
$stmt->bind_param("is", $user_id, $tanggal);
$stmt->execute();

$result = $stmt->get_result();
$data = $result->fetch_assoc();

echo json_encode([
    "status" => $data ? true : false,
    "data" => $data
]);
