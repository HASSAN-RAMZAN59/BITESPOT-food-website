<?php

namespace Database\Seeders;

use App\Models\Restaurant;
use App\Models\MenuItem;
use Illuminate\Database\Seeder;

class RestaurantSeeder extends Seeder
{
    public function run(): void
    {
        $restaurants = [
            [
                'name' => 'Pizza Town',
                'description' => 'Best pizza in town with authentic Italian flavors',
                'category' => 'Fast Food',
                'rating' => 4.7,
                'image' => 'images/resturants/1.jpg',
                'menu_items' => [
                    ['name' => 'Margherita Pizza', 'description' => 'Classic pizza with tomato and mozzarella', 'price' => 800, 'category' => 'Pizza'],
                    ['name' => 'Pepperoni Pizza', 'description' => 'Loaded with pepperoni and cheese', 'price' => 950, 'category' => 'Pizza'],
                    ['name' => 'BBQ Chicken Pizza', 'description' => 'Grilled chicken with BBQ sauce', 'price' => 1100, 'category' => 'Pizza'],
                ]
            ],
            [
                'name' => 'Pasta Junction',
                'description' => 'Delicious pasta varieties and Italian cuisine',
                'category' => 'Fast Food',
                'rating' => 4.3,
                'image' => 'images/resturants/2.jpg',
                'menu_items' => [
                    ['name' => 'Spaghetti Carbonara', 'description' => 'Creamy pasta with bacon', 'price' => 750, 'category' => 'Pasta'],
                    ['name' => 'Fettuccine Alfredo', 'description' => 'Rich and creamy white sauce pasta', 'price' => 850, 'category' => 'Pasta'],
                    ['name' => 'Penne Arrabbiata', 'description' => 'Spicy tomato sauce pasta', 'price' => 700, 'category' => 'Pasta'],
                ]
            ],
            [
                'name' => 'Burger Spot',
                'description' => 'Juicy burgers and crispy fries',
                'category' => 'Fast Food',
                'rating' => 4.5,
                'image' => 'images/resturants/3.jpg',
                'menu_items' => [
                    ['name' => 'Classic Beef Burger', 'description' => 'Juicy beef patty with fresh vegetables', 'price' => 650, 'category' => 'Burgers'],
                    ['name' => 'Chicken Burger', 'description' => 'Crispy chicken with special sauce', 'price' => 600, 'category' => 'Burgers'],
                    ['name' => 'Cheese Burger', 'description' => 'Double cheese with beef patty', 'price' => 700, 'category' => 'Burgers'],
                    ['name' => 'French Fries', 'description' => 'Crispy golden fries', 'price' => 250, 'category' => 'Sides'],
                ]
            ],
            [
                'name' => 'Flaming Shawarma',
                'description' => 'Authentic Middle Eastern shawarma',
                'category' => 'Fast Food',
                'rating' => 4.4,
                'image' => 'images/resturants/4.jpg',
                'menu_items' => [
                    ['name' => 'Chicken Shawarma', 'description' => 'Tender chicken with garlic sauce', 'price' => 400, 'category' => 'Shawarma'],
                    ['name' => 'Beef Shawarma', 'description' => 'Spiced beef with tahini', 'price' => 450, 'category' => 'Shawarma'],
                    ['name' => 'Falafel Wrap', 'description' => 'Crispy falafel with vegetables', 'price' => 350, 'category' => 'Vegetarian'],
                ]
            ],
            [
                'name' => 'Dastarkhwan',
                'description' => 'Traditional desi cuisine',
                'category' => 'Desi',
                'rating' => 4.6,
                'image' => 'images/resturants/5.jpeg',
                'menu_items' => [
                    ['name' => 'Chicken Biryani', 'description' => 'Aromatic basmati rice with spiced chicken', 'price' => 700, 'category' => 'Biryani'],
                    ['name' => 'Mutton Biryani', 'description' => 'Tender mutton with fragrant rice', 'price' => 900, 'category' => 'Biryani'],
                    ['name' => 'Seekh Kabab', 'description' => 'Grilled minced meat skewers', 'price' => 250, 'category' => 'Kababs'],
                    ['name' => 'Chicken Karahi', 'description' => 'Spicy chicken curry', 'price' => 800, 'category' => 'Curries'],
                ]
            ],
            [
                'name' => 'Spice Villa',
                'description' => 'Spicy and flavorful Pakistani dishes',
                'category' => 'Desi',
                'rating' => 4.8,
                'image' => 'images/resturants/6.jpg',
                'menu_items' => [
                    ['name' => 'Chicken Tikka', 'description' => 'Marinated grilled chicken', 'price' => 600, 'category' => 'BBQ'],
                    ['name' => 'Nihari', 'description' => 'Slow-cooked beef stew', 'price' => 750, 'category' => 'Curries'],
                    ['name' => 'Haleem', 'description' => 'Mixed lentils with meat', 'price' => 500, 'category' => 'Traditional'],
                ]
            ],
            [
                'name' => 'Karachi Grill',
                'description' => 'BBQ and grilled specialties',
                'category' => 'BBQ',
                'rating' => 4.5,
                'image' => 'images/resturants/7.jpg',
                'menu_items' => [
                    ['name' => 'Mixed Grill Platter', 'description' => 'Assorted grilled meats', 'price' => 1200, 'category' => 'BBQ'],
                    ['name' => 'Chapli Kabab', 'description' => 'Spiced flat kababs', 'price' => 300, 'category' => 'Kababs'],
                    ['name' => 'Chicken Malai Boti', 'description' => 'Creamy grilled chicken', 'price' => 650, 'category' => 'BBQ'],
                ]
            ]
        ];

        foreach ($restaurants as $restaurantData) {
            $menuItems = $restaurantData['menu_items'];
            unset($restaurantData['menu_items']);

            $restaurant = Restaurant::create($restaurantData);

            foreach ($menuItems as $menuItem) {
                $restaurant->menuItems()->create($menuItem);
            }
        }
    }
}
