<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Services\RestaurantDataService;

class AboutController extends Controller
{
    protected RestaurantDataService $dataService;

    public function __construct(RestaurantDataService $dataService)
    {
        $this->dataService = $dataService;
    }

    /**
     * Display public About Us page (Route: /about).
     */
    public function index()
    {
        // Step 1: Retrieve chefs, about content, and customer reviews
        $chefs         = $this->dataService->getChefs();
        $aboutSettings = $this->dataService->getAboutSettings();
        $reviews       = $this->dataService->getReviews();

        // Step 2: Render about blade view with data
        return view('frontend.about', compact('chefs', 'aboutSettings', 'reviews'));
    }
}
