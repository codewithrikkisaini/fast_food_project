<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Services\RestaurantDataService;

class CartController extends Controller
{
    protected RestaurantDataService $dataService;

    // Service inject karna
    public function __construct(RestaurantDataService $dataService)
    {
        $this->dataService = $dataService;
    }

    /**
     * Shopping Cart / Order Summary Page (Route: /cart)
     */
    public function index()
    {
        // Step 1: Saare menu items lena (cart suggestions ke liye)
        $menuItems = $this->dataService->getMenuItems();

        // Step 2: Cart blade view me bhejna
        return view('frontend.cart', compact('menuItems'));
    }
}
