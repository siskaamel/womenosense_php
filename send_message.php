<?php
include 'koneksi.php';

// Menerima data JSON dari body request Flutter
$inputJSON = file_get_contents('php://input');
$input = json_decode($inputJSON, TRUE);

$sender_id   = isset($input['sender_id']) ? $input['sender_id'] : null;
$receiver_id = isset($input['receiver_id']) ? $input['receiver_id'] : null;
$message     = isset($input['message']) ? $input['message'] : null;

if ($sender_id && $receiver_id && $message) {
    // Query Insert menggunakan Prepared Statement
    $sql = "INSERT INTO messages (sender_id, receiver_id, message) VALUES (?, ?, ?)";
    
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "iis", $sender_id, $receiver_id, $message);

    if (mysqli_stmt_execute($stmt)) {
        echo json_encode([
            "status" => "success",
            "message" => "Pesan berhasil dikirim"
        ]);
    } else {
        echo json_encode([
            "status" => "error", 
            "message" => "Gagal menyimpan pesan: " . mysqli_error($conn)
        ]);
    }
} else {
    echo json_encode([
        "status" => "error", 
        "message" => "Data tidak lengkap (sender_id, receiver_id, dan message diperlukan)"
    ]);
}

mysqli_close($conn);
?>