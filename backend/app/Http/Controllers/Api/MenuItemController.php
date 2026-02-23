<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\MenuItem;
use Illuminate\Http\Request;

class MenuItemController extends Controller
{
    /**
     * Display a listing of available menu items.
     */
    public function index()
    {
        $menuItems = MenuItem::where('is_available', true)
            ->with('restaurant')
            ->get();

        return response()->json([
            'success' => true,
            'data' => $menuItems
        ]);
    }

    /**
     * Display the specified menu item.
     */
    public function show($id)
    {
        $menuItem = MenuItem::with('restaurant')->find($id);

        if (!$menuItem) {
            return response()->json([
                'success' => false,
                'message' => 'Menu item not found'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $menuItem
        ]);
    }
}
