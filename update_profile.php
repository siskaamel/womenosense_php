<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");

include 'koneksi.php';

$username = $_POST['username'] ?? null;
$image = $_FILES['image'] ?? null;

if (!$username || !$image) {
    echo json_encode(["status"=>"error"]);
    exit;
}

$target_dir = "uploads/";
if (!is_dir($target_dir)) mkdir($target_dir);

$check = $conn->prepare("SELECT profile_image FROM users WHERE username=?");
$check->bind_param("s",$username);
$check->execute();
$old = $check->get_result()->fetch_assoc();

if ($old && $old['profile_image']) {
    $old_path = $target_dir.$old['profile_image'];
    if (file_exists($old_path)) unlink($old_path);
}

$ext = pathinfo($image["name"], PATHINFO_EXTENSION);
$image_name = time()."_".$username.".".$ext;
$target_file = $target_dir.$image_name;

if (move_uploaded_file($image["tmp_name"], $target_file)) {

    $up = $conn->prepare("UPDATE users SET profile_image=? WHERE username=?");
    $up->bind_param("ss",$image_name,$username);

    if ($up->execute()) {
        echo json_encode(["status"=>"success","profile_image"=>$image_name]);
    } else {
        echo json_encode(["status"=>"error"]);
    }

} else {
    echo json_encode(["status"=>"error"]);
}
