# BiteSpot Backend API

Laravel backend for the BiteSpot food delivery application.

## Features

- RESTful API for restaurants, menu items, and orders
- Complete CRUD operations
- Order tracking system
- Database seeding with sample data

## Requirements

- PHP >= 8.1
- Composer
- MySQL database
- Laravel 10

## Installation

1. Navigate to the backend directory:
```bash
cd "food hub/backend"
```

2. Install dependencies:
```bash
composer install
```

3. Copy environment file:
```bash
copy .env.example .env
```

4. Generate application key:
```bash
php artisan key:generate
```

5. Create database:
   - Create a MySQL database named `bitespot`
   - Update `.env` file with your database credentials

6. Run migrations:
```bash
php artisan migrate
```

7. Seed the database:
```bash
php artisan db:seed
```

8. Start the development server:
```bash
php artisan serve
```

The API will be available at `http://localhost:8000`

## API Endpoints

### Restaurants
- `GET /api/restaurants` - Get all restaurants
- `GET /api/restaurants/{id}` - Get specific restaurant
- `GET /api/restaurants/{id}/menu` - Get restaurant menu

### Menu Items
- `GET /api/menu-items` - Get all menu items
- `GET /api/menu-items/{id}` - Get specific menu item

### Orders
- `POST /api/orders` - Create new order
- `GET /api/orders/{id}` - Get order details
- `GET /api/orders/track/{orderNumber}` - Track order by order number
- `PATCH /api/orders/{id}/status` - Update order status

### Health Check
- `GET /api/health` - API health check

## Sample Order Request

```json
POST /api/orders
{
  "restaurant_id": 1,
  "customer_name": "John Doe",
  "customer_email": "john@example.com",
  "customer_phone": "03001234567",
  "delivery_address": "House 123, Street 45, Karachi",
  "payment_method": "Cash on Delivery",
  "items": [
    {
      "menu_item_id": 1,
      "quantity": 2,
      "price": 800
    }
  ]
}
```

## Database Structure

- **restaurants** - Restaurant information
- **menu_items** - Menu items for each restaurant
- **orders** - Customer orders
- **order_items** - Items in each order

## CORS Configuration

To enable CORS for your frontend, install and configure Laravel CORS:

```bash
composer require fruitcake/laravel-cors
php artisan vendor:publish --tag="cors"
```

Update `config/cors.php` to allow your frontend domain.

## License

MIT License
