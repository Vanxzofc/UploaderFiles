<?php
require 'settings.php';
header('Content-Type: application/json');


$key = $_GET['apikey'] ?? '';
if ($key !== API_KEY) {
http_response_code(401);
echo json_encode(["status" => false, "message" => "API Key salah"]);
exit;
}


$dir = 'X/';
if (!is_dir($dir)) {
echo json_encode(["status" => true, "data" => []]);
exit;
}


$files = array_diff(scandir($dir), ['.', '..']);
$baseUrl = ($_SERVER['HTTPS'] ? "https" : "http") . "://" . $_SERVER['HTTP_HOST'] . "/" . $dir;


$data = [];
foreach ($files as $f) {
$filePath = $dir . $f;
$data[] = [
"filename" => $f,
"url" => $baseUrl . $f,
"size" => filesize($filePath),
"last_modified" => date("Y-m-d H:i:s", filemtime($filePath))
];
}

echo json_encode(["status" => true, "total" => count($data), "data" => $data]);
