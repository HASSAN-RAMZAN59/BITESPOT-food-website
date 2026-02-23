<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    exit(0);
}

$host = '127.0.0.1';
$dbname = 'bitespot';
$username = 'root';
$password = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Create new order
        $input = json_decode(file_get_contents('php://input'), true);
        
        // Generate order number
        $orderNumber = 'BS' . strtoupper(substr(uniqid(), -8));
        
        // Calculate total
        $total = 0;
        foreach ($input['items'] as $item) {
            $total += $item['price'] * $item['quantity'];
        }
        
        // Insert order
        $stmt = $pdo->prepare("INSERT INTO orders (restaurant_id, order_number, customer_name, customer_email, customer_phone, delivery_address, payment_method, total_amount, status) VALUES (?, ?, ?, ?, ?, ?, ?, ?, 'pending')");
        $stmt->execute([
            $input['restaurant_id'],
            $orderNumber,
            $input['customer_name'],
            $input['customer_email'] ?? '',
            $input['customer_phone'] ?? '',
            $input['delivery_address'],
            $input['payment_method'],
            $total
        ]);
        
        $orderId = $pdo->lastInsertId();
        
        // Insert order items
        foreach ($input['items'] as $item) {
            $subtotal = $item['price'] * $item['quantity'];
            $stmt = $pdo->prepare("INSERT INTO order_items (order_id, menu_item_id, quantity, price, subtotal) VALUES (?, ?, ?, ?, ?)");
            $stmt->execute([
                $orderId,
                $item['menu_item_id'],
                $item['quantity'],
                $item['price'],
                $subtotal
            ]);
        }
        
        // Fetch complete order
        $stmt = $pdo->prepare("SELECT * FROM orders WHERE id = ?");
        $stmt->execute([$orderId]);
        $order = $stmt->fetch(PDO::FETCH_ASSOC);
        
        $stmt = $pdo->prepare("SELECT * FROM order_items WHERE order_id = ?");
        $stmt->execute([$orderId]);
        $order['items'] = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        echo json_encode([
            'success' => true,
            'message' => 'Order placed successfully',
            'data' => $order
        ], JSON_PRETTY_PRINT);
        
    } else {
        // Get order by order number (for tracking)
        if (isset($_GET['order_number'])) {
            $orderNumber = $_GET['order_number'];
            
            // Fetch order
            $stmt = $pdo->prepare("SELECT * FROM orders WHERE order_number = ?");
            $stmt->execute([$orderNumber]);
            $order = $stmt->fetch(PDO::FETCH_ASSOC);
            
            if ($order) {
                // Fetch order items with menu item names
                $stmt = $pdo->prepare("
                    SELECT oi.*, mi.name as menu_item_name 
                    FROM order_items oi 
                    LEFT JOIN menu_items mi ON oi.menu_item_id = mi.id 
                    WHERE oi.order_id = ?
                ");
                $stmt->execute([$order['id']]);
                $order['items'] = $stmt->fetchAll(PDO::FETCH_ASSOC);
                
                echo json_encode([
                    'success' => true,
                    'data' => $order
                ], JSON_PRETTY_PRINT);
            } else {
                echo json_encode([
                    'success' => false,
                    'message' => 'Order not found'
                ]);
            }
        } else {
            // Get all orders
            $stmt = $pdo->query("SELECT * FROM orders ORDER BY created_at DESC");
            $orders = $stmt->fetchAll(PDO::FETCH_ASSOC);
            
            echo json_encode([
                'success' => true,
                'data' => $orders
            ], JSON_PRETTY_PRINT);
        }
    }
    
} catch(PDOException $e) {
    echo json_encode([
        'success' => false,
        'error' => $e->getMessage()
    ]);
}
