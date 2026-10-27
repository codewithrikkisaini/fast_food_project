<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Services\RestaurantDataService;

class MenuController extends Controller
{
    protected RestaurantDataService $dataService;

    public function __construct(RestaurantDataService $dataService)
    {
        $this->dataService = $dataService;
    }

    /**
     * Display public Menu page (Route: /menu).
     */
    public function index()
    {
        // Step 1: Retrieve all menu items and site settings
        $menuItems    = $this->dataService->getMenuItems();
        $homeSettings = $this->dataService->getHomeSettings();

        // Step 2: Render menu blade view with data
        return view('frontend.menu', compact('menuItems', 'homeSettings'));
    }
}
