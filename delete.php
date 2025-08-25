<?php
require 'settings.php';
header('Content-Type: application/json');

$key = $_GET['apikey'] ?? '';
if ($key !== API_KEY) {
http_response_code(401);
echo json_encode(["status" => false, "message" => "API Key salah"]);
exit;
}

$filename = $_GET['file'] ?? '';
if (!$filename) {
echo json_encode(["status" => false, "message" => "Nama file tidak diberikan"]);
exit;
}

$path = 'X/' . basename($filename);
if (!file_exists($path)) {
echo json_encode(["status" => false, "message" => "File tidak ditemukan"]);
exit;
}

if (unlink($path)) {
echo json_encode(["status" => true, "message" => "File berhasil dihapus"]);
} else {
echo json_encode(["status" => false, "message" => "Gagal menghapus file"]);
}
