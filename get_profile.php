<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");

include 'koneksi.php';

$username = $_GET['username'] ?? null;

if (!$username) {
    echo json_encode(["status"=>"error"]);
    exit;
}

$sql = "SELECT profile_image FROM users WHERE username=?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s",$username);
$stmt->execute();

$result = $stmt->get_result();
$row = $result->fetch_assoc();

if ($row) {
    echo json_encode(["status"=>"success","profile_image"=>$row['profile_image']]);
} else {
    echo json_encode(["status"=>"error"]);
}
