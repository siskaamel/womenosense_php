<?php
include 'koneksi.php';

// Mendapatkan parameter dari URL (GET)
$user_id = isset($_GET['user_id']) ? $_GET['user_id'] : null;
$doctor_id = isset($_GET['doctor_id']) ? $_GET['doctor_id'] : null;

if ($user_id && $doctor_id) {
    // Query untuk mengambil pesan dua arah (dari user ke dokter ATAU dokter ke user)
    $sql = "SELECT * FROM messages 
            WHERE (sender_id = ? AND receiver_id = ?) 
            OR (sender_id = ? AND receiver_id = ?) 
            ORDER BY sent_at ASC";

    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "iiii", $user_id, $doctor_id, $doctor_id, $user_id);
    mysqli_stmt_execute($stmt);
    
    $result = mysqli_stmt_get_result($stmt);
    $messages = [];

    while ($row = mysqli_fetch_assoc($result)) {
        $messages[] = $row;
    }

    echo json_encode($messages);
} else {
    echo json_encode(["status" => "error", "message" => "Parameter user_id atau doctor_id tidak ditemukan"]);
}

mysqli_close($conn);
?>