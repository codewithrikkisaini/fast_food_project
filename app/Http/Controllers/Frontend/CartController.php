<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Services\RestaurantDataService;

class CartController extends Controller
{
    protected RestaurantDataService $dataService;

    public function __construct(RestaurantDataService $dataService)
    {
        $this->dataService = $dataService;
    }

    /**
     * Display shopping cart and order summary (Route: /cart).
     */
    public function index()
    {
        // Step 1: Retrieve menu items for cart display & suggestions
        $menuItems = $this->dataService->getMenuItems();

        // Step 2: Render cart blade view with data
        return view('frontend.cart', compact('menuItems'));
    }
}
