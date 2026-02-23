<?php

// Direct database setup without Laravel artisan
$host = '127.0.0.1';
$dbname = 'bitespot';
$username = 'root';
$password = '';

try {
    $pdo = new PDO("mysql:host=$host", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    // Create database
    $pdo->exec("CREATE DATABASE IF NOT EXISTS $dbname");
    echo "✓ Database 'bitespot' created\n";
    
    // Use database
    $pdo->exec("USE $dbname");
    
    // Create restaurants table
    $pdo->exec("CREATE TABLE IF NOT EXISTS restaurants (
        id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        name VARCHAR(255) NOT NULL,
        description TEXT,
        category VARCHAR(255) DEFAULT 'Fast Food',
        rating DECIMAL(2,1) DEFAULT 0.0,
        image VARCHAR(255),
        is_active BOOLEAN DEFAULT TRUE,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
    )");
    echo "✓ Restaurants table created\n";
    
    // Create menu_items table
    $pdo->exec("CREATE TABLE IF NOT EXISTS menu_items (
        id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        restaurant_id BIGINT UNSIGNED NOT NULL,
        name VARCHAR(255) NOT NULL,
        description TEXT,
        price DECIMAL(10,2) NOT NULL,
        image VARCHAR(255),
        category VARCHAR(255) DEFAULT 'Main Course',
        is_available BOOLEAN DEFAULT TRUE,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
        FOREIGN KEY (restaurant_id) REFERENCES restaurants(id) ON DELETE CASCADE
    )");
    echo "✓ Menu items table created\n";
    
    // Create orders table
    $pdo->exec("CREATE TABLE IF NOT EXISTS orders (
        id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        restaurant_id BIGINT UNSIGNED NOT NULL,
        order_number VARCHAR(255) UNIQUE NOT NULL,
        customer_name VARCHAR(255) NOT NULL,
        customer_email VARCHAR(255),
        customer_phone VARCHAR(255),
        delivery_address TEXT NOT NULL,
        payment_method VARCHAR(255) NOT NULL,
        total_amount DECIMAL(10,2) NOT NULL,
        status ENUM('pending','confirmed','preparing','out_for_delivery','delivered','cancelled') DEFAULT 'pending',
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
        FOREIGN KEY (restaurant_id) REFERENCES restaurants(id) ON DELETE CASCADE
    )");
    echo "✓ Orders table created\n";
    
    // Create order_items table
    $pdo->exec("CREATE TABLE IF NOT EXISTS order_items (
        id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        order_id BIGINT UNSIGNED NOT NULL,
        menu_item_id BIGINT UNSIGNED NOT NULL,
        quantity INT NOT NULL DEFAULT 1,
        price DECIMAL(10,2) NOT NULL,
        subtotal DECIMAL(10,2) NOT NULL,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
        FOREIGN KEY (order_id) REFERENCES orders(id) ON DELETE CASCADE,
        FOREIGN KEY (menu_item_id) REFERENCES menu_items(id) ON DELETE CASCADE
    )");
    echo "✓ Order items table created\n";
    
    // Check if we need to seed data
    $stmt = $pdo->query("SELECT COUNT(*) FROM restaurants");
    $count = $stmt->fetchColumn();
    
    if ($count == 0) {
        // Seed restaurants
        $restaurants = [
            ['Pizza Town', 'Best pizza in town with authentic Italian flavors', 'Fast Food', 4.7, 'images/resturants/1.jpg'],
            ['Pasta Junction', 'Delicious pasta varieties and Italian cuisine', 'Fast Food', 4.3, 'images/resturants/2.jpg'],
            ['Burger Spot', 'Juicy burgers and crispy fries', 'Fast Food', 4.5, 'images/resturants/3.jpg'],
            ['Flaming Shawarma', 'Authentic Middle Eastern shawarma', 'Fast Food', 4.4, 'images/resturants/4.jpg'],
            ['Dastarkhwan', 'Traditional desi cuisine', 'Desi', 4.6, 'images/resturants/5.jpeg'],
            ['Spice Villa', 'Spicy and flavorful Pakistani dishes', 'Desi', 4.8, 'images/resturants/6.jpg'],
            ['Karachi Grill', 'BBQ and grilled specialties', 'BBQ', 4.5, 'images/resturants/7.jpg']
        ];
        
        foreach ($restaurants as $r) {
            $pdo->exec("INSERT INTO restaurants (name, description, category, rating, image) VALUES ('$r[0]', '$r[1]', '$r[2]', $r[3], '$r[4]')");
        }
        echo "✓ Seeded 7 restaurants\n";
        
        // Seed some menu items
        $menuItems = [
            [1, 'Margherita Pizza', 'Classic pizza with tomato and mozzarella', 800, 'Pizza'],
            [1, 'Pepperoni Pizza', 'Loaded with pepperoni and cheese', 950, 'Pizza'],
            [2, 'Spaghetti Carbonara', 'Creamy pasta with bacon', 750, 'Pasta'],
            [2, 'Fettuccine Alfredo', 'Rich and creamy white sauce pasta', 850, 'Pasta'],
            [3, 'Classic Beef Burger', 'Juicy beef patty with fresh vegetables', 650, 'Burgers'],
            [3, 'Chicken Burger', 'Crispy chicken with special sauce', 600, 'Burgers'],
            [4, 'Chicken Shawarma', 'Tender chicken with garlic sauce', 400, 'Shawarma'],
            [4, 'Beef Shawarma', 'Spiced beef with tahini', 450, 'Shawarma'],
            [5, 'Chicken Biryani', 'Aromatic basmati rice with spiced chicken', 700, 'Biryani'],
            [5, 'Seekh Kabab', 'Grilled minced meat skewers', 250, 'Kababs'],
            [6, 'Chicken Tikka', 'Marinated grilled chicken', 600, 'BBQ'],
            [6, 'Nihari', 'Slow-cooked beef stew', 750, 'Curries'],
            [7, 'Mixed Grill Platter', 'Assorted grilled meats', 1200, 'BBQ'],
            [7, 'Chapli Kabab', 'Spiced flat kababs', 300, 'Kababs']
        ];
        
        foreach ($menuItems as $m) {
            $pdo->exec("INSERT INTO menu_items (restaurant_id, name, description, price, category) VALUES ($m[0], '$m[1]', '$m[2]', $m[3], '$m[4]')");
        }
        echo "✓ Seeded menu items\n";
    } else {
        echo "✓ Data already exists, skipping seed\n";
    }
    
    // Show summary
    $stmt = $pdo->query("SELECT COUNT(*) FROM restaurants");
    echo "\n📊 Database Summary:\n";
    echo "  Restaurants: " . $stmt->fetchColumn() . "\n";
    
    $stmt = $pdo->query("SELECT COUNT(*) FROM menu_items");
    echo "  Menu Items: " . $stmt->fetchColumn() . "\n";
    
    $stmt = $pdo->query("SELECT COUNT(*) FROM orders");
    echo "  Orders: " . $stmt->fetchColumn() . "\n";
    
    echo "\n✅ Database setup complete!\n";
    echo "🚀 You can now start the server with: php -S localhost:8000 -t public\n";
    
} catch(PDOException $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
}
