<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Services\RestaurantDataService;

class MenuController extends Controller
{
    protected RestaurantDataService $dataService;

    // Service inject karna
    public function __construct(RestaurantDataService $dataService)
    {
        $this->dataService = $dataService;
    }

    /**
     * Public Menu Page (Route: /menu)
     */
    public function index()
    {
        // Step 1: Saare food menu items aur settings lena
        $menuItems    = $this->dataService->getMenuItems();
        $homeSettings = $this->dataService->getHomeSettings();

        // Step 2: Menu blade view me data bhejna
        return view('frontend.menu', compact('menuItems', 'homeSettings'));
    }
}
