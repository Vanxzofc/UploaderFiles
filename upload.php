<?php
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
http_response_code(405);
echo json_encode(["status" => false, "message" => "Gunakan metode POST"]);
exit;
}

if (!isset($_FILES['file'])) {
echo json_encode(["status" => false, "message" => "File tidak ditemukan"]);
exit;
}


$allowedTypes = ['image/jpeg', 'image/png', 'image/webp', 'audio/mpeg', 'video/mp4'];
$maxSize = 20 * 1024 * 1024; // 20MB
$target_dir = "X/";


function generateRandomName($length = 8) {
return substr(str_shuffle('abcdefghijklmnopqrstuvwxyz0123456789'), 0, $length);
}


$file = $_FILES['file'];
$type = mime_content_type($file['tmp_name']);
$size = $file['size'];


if (!in_array($type, $allowedTypes)) {
echo json_encode(["status" => false, "message" => "Format tidak didukung"]);
exit;
}


if ($size > $maxSize) {
echo json_encode(["status" => false, "message" => "Maksimal ukuran file 20MB"]);
exit;
}


$ext = pathinfo($file['name'], PATHINFO_EXTENSION);
$randomName = generateRandomName();
$filename = $randomName . "." . $ext;
$target_file = $target_dir . $filename;


if (!is_dir($target_dir)) {
mkdir($target_dir, 0755, true);
}


if (move_uploaded_file($file['tmp_name'], $target_file)) {
echo json_encode([
"status" => true,
"message" => "Berhasil diunggah!",
"filename" => $filename,
"url" => ($_SERVER['REQUEST_SCHEME'] ?? 'https') . "://" . $_SERVER['HTTP_HOST'] . "/" . $target_file
]);
} else {
http_response_code(500);
echo json_encode([
"status" => false,
"message" => "Gagal menyimpan file."
]);
}
?>
