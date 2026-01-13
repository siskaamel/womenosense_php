<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");

include 'koneksi.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(["status"=>false,"message"=>"POST only"]);
    exit;
}

$user_id      = $_POST['user_id'] ?? null;
$start_date   = $_POST['start_date'] ?? null;
$end_date     = $_POST['end_date'] ?? null;
$cycle_length = $_POST['cycle_length'] ?? null;

if (!$user_id || !$start_date || !$end_date) {
    echo json_encode(["status"=>false,"message"=>"Data tidak lengkap"]);
    exit;
}

$sql = "INSERT INTO menstruasi (user_id,start_date,end_date,cycle_length)
        VALUES (?,?,?,?)";

$stmt = $conn->prepare($sql);
$stmt->bind_param("issi",$user_id,$start_date,$end_date,$cycle_length);

if ($stmt->execute()) {
    echo json_encode(["status"=>true]);
} else {
    echo json_encode(["status"=>false,"message"=>$stmt->error]);
}
