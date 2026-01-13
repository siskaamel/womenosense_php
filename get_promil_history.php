<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Content-Type");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Content-Type: application/json");

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') exit;

include "koneksi.php";

$user_id = $_GET['user_id'] ?? null;

if (!$user_id) {
    echo json_encode(["status" => false, "message"=>"User ID kosong"]);
    exit;
}

$sql = "SELECT * FROM promil_checklist
        WHERE user_id = ?
        ORDER BY tanggal DESC";

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();

$result = $stmt->get_result();

$data = [];
while ($row = $result->fetch_assoc()) {
    $data[] = $row;
}

echo json_encode(["status" => true, "data" => $data]);
