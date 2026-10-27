<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Services\RestaurantDataService;

class ChefController extends Controller
{
    protected RestaurantDataService $dataService;

    public function __construct(RestaurantDataService $dataService)
    {
        $this->dataService = $dataService;
    }

    /**
     * Display public culinary team page (Route: /chefs).
     */
    public function index()
    {
        // Step 1: Retrieve chef team profiles from service
        $chefs = $this->dataService->getChefs();

        // Step 2: Render chefs blade view with data
        return view('frontend.chefs', compact('chefs'));
    }
}
