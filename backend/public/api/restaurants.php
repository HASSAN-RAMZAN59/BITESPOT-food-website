<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');

$host = '127.0.0.1';
$dbname = 'bitespot';
$username = 'root';
$password = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    // Get all restaurants with their menu items
    $stmt = $pdo->query("SELECT * FROM restaurants WHERE is_active = 1");
    $restaurants = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    foreach ($restaurants as &$restaurant) {
        $stmt = $pdo->prepare("SELECT * FROM menu_items WHERE restaurant_id = ? AND is_available = 1");
        $stmt->execute([$restaurant['id']]);
        $restaurant['menu_items'] = $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    echo json_encode([
        'success' => true,
        'data' => $restaurants
    ], JSON_PRETTY_PRINT);
    
} catch(PDOException $e) {
    echo json_encode([
        'success' => false,
        'error' => $e->getMessage()
    ]);
}
