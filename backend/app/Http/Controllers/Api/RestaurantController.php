<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Restaurant;
use Illuminate\Http\Request;

class RestaurantController extends Controller
{
    /**
     * Display a listing of active restaurants.
     */
    public function index()
    {
        $restaurants = Restaurant::where('is_active', true)
            ->with('menuItems')
            ->get();

        return response()->json([
            'success' => true,
            'data' => $restaurants
        ]);
    }

    /**
     * Display the specified restaurant.
     */
    public function show($id)
    {
        $restaurant = Restaurant::with('menuItems')->find($id);

        if (!$restaurant) {
            return response()->json([
                'success' => false,
                'message' => 'Restaurant not found'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $restaurant
        ]);
    }

    /**
     * Get menu items for a specific restaurant.
     */
    public function menu($id)
    {
        $restaurant = Restaurant::with(['menuItems' => function ($query) {
            $query->where('is_available', true);
        }])->find($id);

        if (!$restaurant) {
            return response()->json([
                'success' => false,
                'message' => 'Restaurant not found'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => [
                'restaurant' => $restaurant->only(['id', 'name', 'rating']),
                'menu_items' => $restaurant->menuItems
            ]
        ]);
    }
}
