<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');

$path = __DIR__ . '/catalog.json';
if (!file_exists($path)) {
    http_response_code(500);
    echo json_encode(['error' => true, 'message' => 'catalog.json not found']);
    exit;
}

echo file_get_contents($path);
