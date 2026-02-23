# BiteSpot Project - Complete Structure

## 📁 Project Overview

BiteSpot is a full-stack food delivery web application with:
- **Frontend**: HTML, CSS (Bootstrap 5), JavaScript
- **Backend**: PHP Laravel 10 REST API
- **Database**: MySQL

---

## 🗂️ Directory Structure

```
food hub/
├── Frontend Files
│   ├── index.html              # Homepage
│   ├── restaurants.html        # Restaurant listings
│   ├── cart.html              # Shopping cart
│   ├── checkout.html          # Checkout form
│   ├── tracking.html          # Order tracking
│   ├── contact.html           # Contact page
│   ├── css/
│   │   └── styles.css         # Custom styles
│   ├── images/
│   │   ├── hs/                # Hero section images
│   │   ├── resturants/        # Restaurant images
│   │   └── sliders/           # Carousel images
│   └── js/
│       └── api.js             # API integration helper
│
└── backend/                    # Laravel Backend
    ├── app/
    │   ├── Http/Controllers/Api/
    │   │   ├── RestaurantController.php
    │   │   ├── MenuItemController.php
    │   │   └── OrderController.php
    │   └── Models/
    │       ├── Restaurant.php
    │       ├── MenuItem.php
    │       ├── Order.php
    │       └── OrderItem.php
    ├── database/
    │   ├── migrations/
    │   │   ├── 2024_01_01_000001_create_restaurants_table.php
    │   │   ├── 2024_01_01_000002_create_menu_items_table.php
    │   │   ├── 2024_01_01_000003_create_orders_table.php
    │   │   └── 2024_01_01_000004_create_order_items_table.php
    │   └── seeders/
    │       ├── DatabaseSeeder.php
    │       └── RestaurantSeeder.php
    ├── routes/
    │   ├── api.php              # API routes
    │   └── web.php              # Web routes
    ├── .env                     # Environment config
    ├── composer.json            # Dependencies
    ├── setup.bat                # Setup script
    ├── README.md                # Documentation
    └── QUICKSTART.md            # Quick start guide
```

---

## 🚀 Getting Started

### Backend Setup

1. **Navigate to backend directory:**
   ```cmd
   cd "food hub\backend"
   ```

2. **Run setup script:**
   ```cmd
   setup.bat
   ```
   
   OR manually:
   ```cmd
   composer install
   php artisan key:generate
   php artisan migrate
   php artisan db:seed
   ```

3. **Start Laravel server:**
   ```cmd
   php artisan serve
   ```
   Backend runs at: `http://localhost:8000`

### Frontend Setup

1. Open `index.html` in a browser, or
2. Use a local server (recommended):
   ```cmd
   php -S localhost:3000
   ```
   Frontend runs at: `http://localhost:3000`

---

## 🔌 API Endpoints

### Restaurants
- **GET** `/api/restaurants` - All restaurants
- **GET** `/api/restaurants/{id}` - Single restaurant
- **GET** `/api/restaurants/{id}/menu` - Restaurant menu

### Menu Items
- **GET** `/api/menu-items` - All menu items
- **GET** `/api/menu-items/{id}` - Single menu item

### Orders
- **POST** `/api/orders` - Create order
- **GET** `/api/orders/{id}` - Order details
- **GET** `/api/orders/track/{orderNumber}` - Track order
- **PATCH** `/api/orders/{id}/status` - Update status

### Health Check
- **GET** `/api/health` - API status

---

## 📊 Database Schema

### Restaurants Table
- id, name, description, category, rating, image, is_active

### Menu Items Table
- id, restaurant_id, name, description, price, image, category, is_available

### Orders Table
- id, restaurant_id, order_number, customer_name, customer_email, 
  customer_phone, delivery_address, payment_method, total_amount, status

### Order Items Table
- id, order_id, menu_item_id, quantity, price, subtotal

---

## 🔗 Frontend Integration

Add to your HTML files:

```html
<script src="js/api.js"></script>
<script>
  // Load restaurants
  async function loadRestaurants() {
    const result = await getRestaurants();
    if (result.success) {
      // Display restaurants
      console.log(result.data);
    }
  }
  
  // Place order
  async function checkout() {
    const order = {
      restaurant_id: 1,
      customer_name: "John Doe",
      customer_email: "john@example.com",
      customer_phone: "03001234567",
      delivery_address: "House 123, Street 45",
      payment_method: "Cash on Delivery",
      items: [
        { menu_item_id: 1, quantity: 2, price: 800 }
      ]
    };
    
    const result = await placeOrder(order);
    if (result.success) {
      alert('Order placed! Number: ' + result.data.order_number);
    }
  }
</script>
```

---

## 📦 Sample Data (After Seeding)

### Restaurants
1. Pizza Town (Fast Food) - ★4.7
2. Pasta Junction (Fast Food) - ★4.3
3. Burger Spot (Fast Food) - ★4.5
4. Flaming Shawarma (Fast Food) - ★4.4
5. Dastarkhwan (Desi) - ★4.6
6. Spice Villa (Desi) - ★4.8
7. Karachi Grill (BBQ) - ★4.5

### Sample Menu Items
- Margherita Pizza - Rs. 800
- Chicken Biryani - Rs. 700
- Beef Burger - Rs. 650
- Chicken Shawarma - Rs. 400
- And many more...

---

## 🛠️ Technologies Used

### Frontend
- HTML5
- CSS3 (Custom + Bootstrap 5.3.3)
- JavaScript (ES6+)
- Google Fonts (Poppins)

### Backend
- PHP 8.2
- Laravel 10
- MySQL Database
- RESTful API Architecture

---

## 🔒 CORS Configuration

If you encounter CORS issues, add to `backend/app/Http/Kernel.php`:

```php
protected $middleware = [
    \Illuminate\Http\Middleware\HandleCors::class,
];
```

Or install Laravel CORS package:
```cmd
composer require fruitcake/laravel-cors
```

---

## 📝 Development Tips

1. **API Testing**: Use Postman or Thunder Client in VS Code
2. **Database Management**: Use phpMyAdmin (comes with XAMPP)
3. **Debugging**: Check `backend/storage/logs/laravel.log`
4. **Frontend Testing**: Use browser DevTools Console

---

## 🐛 Common Issues

### "SQLSTATE[HY000] [1049] Unknown database"
- Create database: `CREATE DATABASE bitespot;`

### "Class not found"
- Run: `composer dump-autoload`

### CORS errors
- Install and configure Laravel CORS package

### API not responding
- Ensure Laravel server is running: `php artisan serve`

---

## 📚 Next Steps

1. ✅ Complete frontend integration with API
2. ✅ Add user authentication (Laravel Sanctum)
3. ✅ Implement real-time order tracking
4. ✅ Add payment gateway integration
5. ✅ Deploy to production server

---

## 📄 License

MIT License - Feel free to use for learning and projects!

---

## 👨‍💻 Support

For issues or questions:
1. Check QUICKSTART.md
2. Review API documentation in README.md
3. Check Laravel logs in `backend/storage/logs/`

---

**Happy Coding! 🚀**
