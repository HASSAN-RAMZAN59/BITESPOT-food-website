<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');

echo json_encode([
    'success' => true,
    'message' => 'BiteSpot Backend API is running!',
    'version' => '1.0',
    'timestamp' => date('Y-m-d H:i:s')
]);
