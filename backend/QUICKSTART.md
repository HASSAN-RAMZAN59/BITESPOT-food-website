# BiteSpot Backend - Quick Start Guide

## Prerequisites

Make sure you have:
- ✅ PHP 8.1 or higher
- ✅ Composer
- ✅ MySQL server running
- ✅ XAMPP or similar (for MySQL)

## Quick Setup

### Option 1: Automated Setup (Recommended)

1. Open PowerShell or Command Prompt in the backend directory
2. Run the setup script:
```cmd
setup.bat
```

The script will:
- Install all dependencies
- Generate application key
- Run database migrations
- Seed sample data

### Option 2: Manual Setup

```bash
# 1. Install dependencies
composer install

# 2. Generate application key
php artisan key:generate

# 3. Create database
# Create a MySQL database named 'bitespot'

# 4. Configure .env file
# Update database credentials in .env

# 5. Run migrations
php artisan migrate

# 6. Seed database
php artisan db:seed

# 7. Start server
php artisan serve
```

## Testing the API

Once the server is running, test these endpoints:

```
# Health check
GET http://localhost:8000/api/health

# Get all restaurants
GET http://localhost:8000/api/restaurants

# Get restaurant menu
GET http://localhost:8000/api/restaurants/1/menu
```

## Database Configuration

Edit `.env` file:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=bitespot
DB_USERNAME=root
DB_PASSWORD=
```

## API Documentation

### Restaurants
- `GET /api/restaurants` - List all restaurants
- `GET /api/restaurants/{id}` - Get restaurant details
- `GET /api/restaurants/{id}/menu` - Get restaurant menu

### Orders
- `POST /api/orders` - Place new order
- `GET /api/orders/track/{orderNumber}` - Track order

## Sample Data

After seeding, you'll have:
- 7 restaurants (Pizza Town, Pasta Junction, etc.)
- ~25 menu items
- Various categories (Fast Food, BBQ, Desi, etc.)

## Troubleshooting

### "could not find driver"
Install PHP MySQL extension in php.ini:
```
extension=pdo_mysql
extension=mysqli
```

### "Access denied for user"
Check MySQL credentials in .env file

### "Class not found"
Run: `composer dump-autoload`

## Next Steps

1. Start the development server: `php artisan serve`
2. Test API endpoints using Postman or browser
3. Update frontend HTML files to connect to API
4. Enable CORS if needed

## Production Deployment

For production:
1. Set `APP_DEBUG=false` in .env
2. Run `php artisan config:cache`
3. Run `php artisan route:cache`
4. Configure proper web server (Apache/Nginx)
