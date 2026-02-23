# BiteSpot - Installation & Testing Guide

## 🎯 Step-by-Step Setup

### Step 1: Backend Installation

```powershell
# Navigate to backend folder
cd "d:\Projects\Web project\food hub\backend"

# Run automated setup
.\setup.bat
```

**What the setup script does:**
1. ✅ Installs Laravel dependencies via Composer
2. ✅ Generates application security key
3. ✅ Prompts you to configure database
4. ✅ Runs database migrations (creates tables)
5. ✅ Seeds sample data (7 restaurants, ~25 menu items)

### Step 2: Database Configuration

Before running migrations, ensure:

1. **XAMPP/MySQL is running**
2. **Create database:**
   ```sql
   CREATE DATABASE bitespot;
   ```

3. **Edit `.env` file if needed:**
   ```env
   DB_DATABASE=bitespot
   DB_USERNAME=root
   DB_PASSWORD=
   ```

### Step 3: Start Backend Server

```powershell
php artisan serve
```

Backend now running at: **http://localhost:8000**

### Step 4: Test API

Open browser and visit:
```
http://localhost:8000/api/health
```

Expected response:
```json
{
  "status": "ok",
  "timestamp": "2026-01-02T12:00:00Z"
}
```

---

## 🧪 Testing Endpoints

### Using Browser (GET Requests Only)

1. **Get all restaurants:**
   ```
   http://localhost:8000/api/restaurants
   ```

2. **Get restaurant menu:**
   ```
   http://localhost:8000/api/restaurants/1/menu
   ```

### Using Postman

1. Import the Postman collection: `BiteSpot_API.postman_collection.json`
2. Test all endpoints with pre-configured requests

### Using cURL (PowerShell)

**Get Restaurants:**
```powershell
curl http://localhost:8000/api/restaurants
```

**Place Order:**
```powershell
$body = @{
    restaurant_id = 1
    customer_name = "John Doe"
    customer_email = "john@example.com"
    customer_phone = "03001234567"
    delivery_address = "House 123, Street 45"
    payment_method = "Cash on Delivery"
    items = @(
        @{
            menu_item_id = 1
            quantity = 2
            price = 800
        }
    )
} | ConvertTo-Json

Invoke-RestMethod -Uri "http://localhost:8000/api/orders" -Method POST -Body $body -ContentType "application/json"
```

---

## 🌐 Frontend Integration

### Step 1: Add API Script to HTML

Add before closing `</body>` tag in your HTML files:

```html
<script src="js/api.js"></script>
```

### Step 2: Load Restaurants Dynamically

**Example for `restaurants.html`:**

```javascript
<script>
async function loadRestaurants() {
    const result = await getRestaurants();
    
    if (result.success) {
        const container = document.querySelector('.row.g-4');
        container.innerHTML = ''; // Clear existing
        
        result.data.forEach(restaurant => {
            const card = `
                <div class="col-sm-6 col-md-4 col-lg-3">
                    <div class="card h-100 border-0 shadow-sm">
                        <img src="${restaurant.image}" class="card-img-top" 
                             alt="${restaurant.name}" style="height:160px;object-fit:cover;">
                        <div class="card-body">
                            <h5 class="card-title mb-1">${restaurant.name}</h5>
                            <p class="card-text small text-muted">
                                ${restaurant.category} • ★ ${restaurant.rating}
                            </p>
                            <a href="cart.html?restaurant=${restaurant.id}" 
                               class="btn btn-sm text-white" style="background:#ff7a00;">
                                View Menu
                            </a>
                        </div>
                    </div>
                </div>
            `;
            container.innerHTML += card;
        });
    }
}

// Load when page loads
document.addEventListener('DOMContentLoaded', loadRestaurants);
</script>
```

### Step 3: Implement Cart Functionality

**Example for `cart.html`:**

```javascript
<script>
// Get restaurant ID from URL
const urlParams = new URLSearchParams(window.location.search);
const restaurantId = urlParams.get('restaurant');

async function loadMenu() {
    const result = await getRestaurantMenu(restaurantId);
    
    if (result.success) {
        const menuItems = result.data.menu_items;
        // Display menu items...
    }
}

// Add to cart
let cart = [];

function addToCart(menuItem) {
    cart.push({
        menu_item_id: menuItem.id,
        name: menuItem.name,
        quantity: 1,
        price: menuItem.price
    });
    updateCartDisplay();
}
</script>
```

### Step 4: Checkout Implementation

**Example for `checkout.html`:**

```javascript
<script>
document.querySelector('form').addEventListener('submit', async (e) => {
    e.preventDefault();
    
    const orderData = {
        restaurant_id: 1, // Get from cart
        customer_name: document.querySelector('input[type="text"]').value,
        customer_email: document.querySelector('input[type="email"]').value,
        customer_phone: "03001234567",
        delivery_address: document.querySelector('textarea').value,
        payment_method: document.querySelector('select').value,
        items: getCartItems() // Your cart items
    };
    
    const result = await placeOrder(orderData);
    
    if (result.success) {
        alert(`Order placed! Your order number is: ${result.data.order_number}`);
        window.location.href = `tracking.html?order=${result.data.order_number}`;
    } else {
        alert('Order failed. Please try again.');
    }
});
</script>
```

### Step 5: Order Tracking

**Example for `tracking.html`:**

```javascript
<script>
async function trackMyOrder() {
    const orderNumber = document.querySelector('input').value;
    const result = await trackOrder(orderNumber);
    
    if (result.success) {
        const order = result.data;
        
        // Update status display
        document.querySelector('.order-status').textContent = order.status;
        
        // Update progress bar
        const statusMap = {
            'pending': 25,
            'confirmed': 50,
            'preparing': 75,
            'out_for_delivery': 90,
            'delivered': 100
        };
        
        const progress = statusMap[order.status] || 0;
        document.querySelector('.progress-bar').style.width = progress + '%';
    }
}
</script>
```

---

## 📊 Sample API Responses

### Get Restaurants
```json
{
  "success": true,
  "data": [
    {
      "id": 1,
      "name": "Pizza Town",
      "description": "Best pizza in town",
      "category": "Fast Food",
      "rating": "4.7",
      "image": "images/resturants/1.jpg",
      "is_active": true
    }
  ]
}
```

### Place Order
```json
{
  "success": true,
  "message": "Order placed successfully",
  "data": {
    "id": 1,
    "order_number": "BS8F2A3B4C",
    "restaurant_id": 1,
    "customer_name": "John Doe",
    "total_amount": "2550.00",
    "status": "pending",
    "created_at": "2026-01-02T12:00:00.000000Z"
  }
}
```

---

## 🔧 Troubleshooting

### Backend Issues

**Error: "could not find driver"**
```ini
# Edit php.ini and uncomment:
extension=pdo_mysql
extension=mysqli
```

**Error: "Class not found"**
```powershell
composer dump-autoload
```

**Error: "SQLSTATE[HY000] [1049]"**
```sql
-- Create database in MySQL
CREATE DATABASE bitespot;
```

### CORS Issues

If frontend can't access API:

```powershell
# Install Laravel CORS
cd backend
composer require fruitcake/laravel-cors
```

Or add to `public/index.php` (temporary fix):
```php
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, PATCH, DELETE');
header('Access-Control-Allow-Headers: Content-Type');
```

---

## ✅ Verification Checklist

- [ ] MySQL/XAMPP running
- [ ] Database `bitespot` created
- [ ] `composer install` completed
- [ ] `.env` configured correctly
- [ ] `php artisan migrate` successful
- [ ] `php artisan db:seed` completed
- [ ] `php artisan serve` running
- [ ] API health check returns 200 OK
- [ ] Can fetch restaurants list
- [ ] Frontend can connect to API

---

## 🎓 Learning Resources

### Laravel Documentation
- Official Docs: https://laravel.com/docs
- API Resources: https://laravel.com/docs/eloquent-resources
- Migrations: https://laravel.com/docs/migrations

### API Testing Tools
- Postman: https://www.postman.com/
- Thunder Client (VS Code): Install from Extensions

---

## 🚀 Next Development Steps

1. **Authentication**
   - Add user registration/login
   - Implement Laravel Sanctum for API tokens

2. **Advanced Features**
   - Real-time order tracking with WebSockets
   - Email notifications
   - SMS integration for order updates

3. **Admin Panel**
   - Manage restaurants
   - View orders
   - Update order status

4. **Deployment**
   - Move to production server
   - Configure Apache/Nginx
   - Set up SSL certificate

---

**Need Help?** Check the documentation files:
- `README.md` - Full documentation
- `QUICKSTART.md` - Quick start guide
- `PROJECT_STRUCTURE.md` - Complete overview
