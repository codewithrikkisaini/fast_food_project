<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Services\RestaurantDataService;

class ChefController extends Controller
{
    protected RestaurantDataService $dataService;

    // Service inject karna
    public function __construct(RestaurantDataService $dataService)
    {
        $this->dataService = $dataService;
    }

    /**
     * Public Chefs Team Page (Route: /chefs)
     */
    public function index()
    {
        // Step 1: Saare chefs ka data service se lena
        $chefs = $this->dataService->getChefs();

        // Step 2: Chefs blade view me data bhejna
        return view('frontend.chefs', compact('chefs'));
    }
}
