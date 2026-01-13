<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");

include 'koneksi.php';

$user_id = $_GET['user_id'] ?? null;

if (!$user_id) {
    echo json_encode(["status"=>false]);
    exit;
}

$sql = "SELECT * FROM menstruasi WHERE user_id=? ORDER BY id DESC LIMIT 1";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i",$user_id);
$stmt->execute();

$result = $stmt->get_result();

if ($row = $result->fetch_assoc()) {
    echo json_encode(["status"=>true,"data"=>$row]);
} else {
    echo json_encode(["status"=>false]);
}
