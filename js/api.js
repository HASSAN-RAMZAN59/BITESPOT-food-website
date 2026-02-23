/**
 * BiteSpot API Client
 * Helper functions to connect frontend with backend
 */

const API_BASE_URL = 'http://localhost:8000/api';

/**
 * Fetch all restaurants
 */
async function getRestaurants() {
    try {
        const response = await fetch(`${API_BASE_URL}/restaurants.php`);
        const data = await response.json();
        return data;
    } catch (error) {
        console.error('Error fetching restaurants:', error);
        return { success: false, error: error.message };
    }
}

/**
 * Get specific restaurant with menu
 */
async function getRestaurantMenu(restaurantId) {
    try {
        const response = await fetch(`${API_BASE_URL}/restaurants.php`);
        const data = await response.json();
        if (data.success) {
            const restaurant = data.data.find(r => r.id == restaurantId);
            return { success: true, data: restaurant };
        }
        return data;
    } catch (error) {
        console.error('Error fetching menu:', error);
        return { success: false, error: error.message };
    }
}

/**
 * Place a new order
 */
async function placeOrder(orderData) {
    try {
        const response = await fetch(`${API_BASE_URL}/orders.php`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json'
            },
            body: JSON.stringify(orderData)
        });
        const data = await response.json();
        return data;
    } catch (error) {
        console.error('Error placing order:', error);
        return { success: false, error: error.message };
    }
}

/**
 * Track order by order number
 */
async function trackOrder(orderNumber) {
    try {
        const response = await fetch(`${API_BASE_URL}/orders.php?order_number=${orderNumber}`);
        const data = await response.json();
        return data;
    } catch (error) {
        console.error('Error tracking order:', error);
        return { success: false, error: error.message };
    }
}

/**
 * Example: Load restaurants on page
 */
async function loadRestaurantsExample() {
    const result = await getRestaurants();
    
    if (result.success) {
        const restaurants = result.data;
        console.log('Restaurants loaded:', restaurants);
        
        // Example: Display in your HTML
        // restaurants.forEach(restaurant => {
        //     console.log(`${restaurant.name} - Rating: ${restaurant.rating}`);
        // });
    } else {
        console.error('Failed to load restaurants');
    }
}

/**
 * Example: Place an order
 */
async function placeOrderExample() {
    const orderData = {
        restaurant_id: 1,
        customer_name: "John Doe",
        customer_email: "john@example.com",
        customer_phone: "03001234567",
        delivery_address: "House 123, Street 45, Karachi",
        payment_method: "Cash on Delivery",
        items: [
            {
                menu_item_id: 1,
                quantity: 2,
                price: 800
            },
            {
                menu_item_id: 2,
                quantity: 1,
                price: 950
            }
        ]
    };
    
    const result = await placeOrder(orderData);
    
    if (result.success) {
        console.log('Order placed successfully!');
        console.log('Order number:', result.data.order_number);
        alert(`Order placed! Your order number is: ${result.data.order_number}`);
    } else {
        console.error('Order failed:', result.errors);
    }
}

/**
 * Example: Track order
 */
async function trackOrderExample(orderNumber) {
    const result = await trackOrder(orderNumber);
    
    if (result.success) {
        console.log('Order found:', result.data);
        console.log('Status:', result.data.status);
        console.log('Total:', result.data.total_amount);
    } else {
        console.error('Order not found');
    }
}

// Export functions for use in other files
if (typeof module !== 'undefined' && module.exports) {
    module.exports = {
        getRestaurants,
        getRestaurantMenu,
        placeOrder,
        trackOrder
    };
}
