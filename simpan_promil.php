<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Content-Type");
header("Access-Control-Allow-Methods: POST, OPTIONS");
header("Content-Type: application/json");

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') exit;

include "koneksi.php";

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(["status"=>"error","message"=>"POST only"]);
    exit;
}

$user_id = $_POST['user_id'] ?? null;
$tanggal = $_POST['tanggal'] ?? null;

if (!$user_id || !$tanggal) {
    echo json_encode(["status"=>"error","message"=>"Data tidak lengkap"]);
    exit;
}

$vitamin  = $_POST['vitamin'] ?? 0;
$air      = $_POST['air'] ?? 0;
$hubungan = $_POST['hubungan'] ?? 0;
$olahraga = $_POST['olahraga'] ?? 0;
$kafein   = $_POST['kafein'] ?? 0;
$tidur    = $_POST['tidur'] ?? 0;
$makan    = $_POST['makan'] ?? 0;
$stres    = $_POST['stres'] ?? 0;
$rokok    = $_POST['rokok'] ?? 0;
$ovulasi  = $_POST['ovulasi'] ?? 0;

$skor  = $_POST['skor'] ?? 0;
$hasil = $_POST['hasil'] ?? '';

$sql = "INSERT INTO promil_checklist (
 user_id, tanggal, vitamin, air, hubungan, olahraga,
 kafein, tidur, makan, stres, rokok, ovulasi, skor, hasil
) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?)";

$stmt = $conn->prepare($sql);

$stmt->bind_param(
 "isiiiiiiiiiiis",
 $user_id, $tanggal, $vitamin, $air, $hubungan, $olahraga,
 $kafein, $tidur, $makan, $stres, $rokok, $ovulasi, $skor, $hasil
);

if ($stmt->execute()) {
    echo json_encode(["status"=>"success"]);
} else {
    echo json_encode(["status"=>"error","message"=>$stmt->error]);
}
