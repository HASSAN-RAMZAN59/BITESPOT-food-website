<?php
// Add more menu items to restaurants

$host = '127.0.0.1';
$dbname = 'bitespot';
$username = 'root';
$password = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    // Additional menu items for each restaurant
    $menuItems = [
        // Pizza Town (id=1)
        ['restaurant_id' => 1, 'name' => 'BBQ Chicken Pizza', 'description' => 'Smoky BBQ sauce with grilled chicken', 'price' => 950],
        ['restaurant_id' => 1, 'name' => 'Veggie Supreme', 'description' => 'Fresh vegetables with mozzarella', 'price' => 750],
        ['restaurant_id' => 1, 'name' => 'Cheese Burst Pizza', 'description' => 'Extra cheese in the crust', 'price' => 1100],
        ['restaurant_id' => 1, 'name' => 'Pepperoni Delight', 'description' => 'Classic pepperoni with extra cheese', 'price' => 1000],
        ['restaurant_id' => 1, 'name' => 'Garlic Bread', 'description' => 'Crispy bread with garlic butter', 'price' => 250],
        
        // Pasta Junction (id=2)
        ['restaurant_id' => 2, 'name' => 'Chicken Fettuccine', 'description' => 'Creamy fettuccine with grilled chicken', 'price' => 850],
        ['restaurant_id' => 2, 'name' => 'Penne Arrabbiata', 'description' => 'Spicy tomato sauce pasta', 'price' => 700],
        ['restaurant_id' => 2, 'name' => 'Mac & Cheese', 'description' => 'Classic macaroni in cheese sauce', 'price' => 650],
        ['restaurant_id' => 2, 'name' => 'Lasagna', 'description' => 'Layered pasta with meat sauce', 'price' => 900],
        ['restaurant_id' => 2, 'name' => 'Garlic Parmesan Pasta', 'description' => 'Creamy garlic pasta with parmesan', 'price' => 750],
        
        // Burger Spot (id=3)
        ['restaurant_id' => 3, 'name' => 'Double Cheeseburger', 'description' => 'Two beef patties with cheese', 'price' => 800],
        ['restaurant_id' => 3, 'name' => 'Grilled Chicken Burger', 'description' => 'Grilled chicken with special sauce', 'price' => 700],
        ['restaurant_id' => 3, 'name' => 'Veggie Burger', 'description' => 'Plant-based patty with fresh veggies', 'price' => 600],
        ['restaurant_id' => 3, 'name' => 'Loaded Fries', 'description' => 'Fries with cheese and bacon', 'price' => 450],
        ['restaurant_id' => 3, 'name' => 'Chicken Nuggets', 'description' => '8 pieces crispy nuggets', 'price' => 500],
        
        // Flaming Shawarma (id=4)
        ['restaurant_id' => 4, 'name' => 'Beef Shawarma', 'description' => 'Tender beef with tahini sauce', 'price' => 550],
        ['restaurant_id' => 4, 'name' => 'Falafel Wrap', 'description' => 'Crispy falafel with hummus', 'price' => 450],
        ['restaurant_id' => 4, 'name' => 'Chicken Platter', 'description' => 'Shawarma with rice and salad', 'price' => 850],
        ['restaurant_id' => 4, 'name' => 'Mixed Grill', 'description' => 'Chicken and beef shawarma combo', 'price' => 950],
        ['restaurant_id' => 4, 'name' => 'Hummus Bowl', 'description' => 'Fresh hummus with pita bread', 'price' => 400],
        
        // Dastarkhwan (id=5)
        ['restaurant_id' => 5, 'name' => 'Chicken Karahi', 'description' => 'Spicy chicken cooked in karahi', 'price' => 1200],
        ['restaurant_id' => 5, 'name' => 'Mutton Biryani', 'description' => 'Aromatic mutton biryani', 'price' => 1400],
        ['restaurant_id' => 5, 'name' => 'Nihari', 'description' => 'Slow cooked beef stew', 'price' => 1100],
        ['restaurant_id' => 5, 'name' => 'Dal Makhani', 'description' => 'Creamy black lentils', 'price' => 600],
        ['restaurant_id' => 5, 'name' => 'Tandoori Naan', 'description' => 'Fresh from tandoor', 'price' => 80],
        
        // Spice Villa (id=6)
        ['restaurant_id' => 6, 'name' => 'Chicken Tikka Masala', 'description' => 'Creamy tomato curry with chicken', 'price' => 950],
        ['restaurant_id' => 6, 'name' => 'Palak Paneer', 'description' => 'Spinach curry with cottage cheese', 'price' => 750],
        ['restaurant_id' => 6, 'name' => 'Butter Chicken', 'description' => 'Rich butter chicken curry', 'price' => 1000],
        ['restaurant_id' => 6, 'name' => 'Seekh Kabab', 'description' => 'Minced meat kebabs', 'price' => 850],
        ['restaurant_id' => 6, 'name' => 'Gulab Jamun', 'description' => 'Sweet dessert (2 pieces)', 'price' => 200],
        
        // Karachi Grill (id=7)
        ['restaurant_id' => 7, 'name' => 'Reshmi Kabab', 'description' => 'Tender chicken kababs', 'price' => 800],
        ['restaurant_id' => 7, 'name' => 'Chapli Kabab', 'description' => 'Spicy Peshawari kabab', 'price' => 900],
        ['restaurant_id' => 7, 'name' => 'BBQ Platter', 'description' => 'Mixed grill platter', 'price' => 1500],
        ['restaurant_id' => 7, 'name' => 'Chicken Malai Boti', 'description' => 'Creamy chicken cubes', 'price' => 850],
        ['restaurant_id' => 7, 'name' => 'Raita', 'description' => 'Yogurt with cucumber', 'price' => 150],
    ];
    
    $stmt = $pdo->prepare("INSERT INTO menu_items (restaurant_id, name, description, price, is_available) VALUES (?, ?, ?, ?, 1)");
    
    foreach ($menuItems as $item) {
        $stmt->execute([
            $item['restaurant_id'],
            $item['name'],
            $item['description'],
            $item['price']
        ]);
    }
    
    echo "Successfully added " . count($menuItems) . " menu items!\n";
    
    // Show count per restaurant
    $stmt = $pdo->query("SELECT r.name, COUNT(m.id) as count FROM restaurants r LEFT JOIN menu_items m ON r.id = m.restaurant_id GROUP BY r.id ORDER BY r.id");
    echo "\nMenu items per restaurant:\n";
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        echo "- {$row['name']}: {$row['count']} items\n";
    }
    
} catch(PDOException $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
