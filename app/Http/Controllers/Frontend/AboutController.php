<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Services\RestaurantDataService;

class AboutController extends Controller
{
    protected RestaurantDataService $dataService;

    // Service inject karna
    public function __construct(RestaurantDataService $dataService)
    {
        $this->dataService = $dataService;
    }

    /**
     * Public About Us Page (Route: /about)
     */
    public function index()
    {
        // Step 1: About page ke liye data lena (chefs, about text, reviews)
        $chefs         = $this->dataService->getChefs();
        $aboutSettings = $this->dataService->getAboutSettings();
        $reviews       = $this->dataService->getReviews();

        // Step 2: About blade view me data bhejna
        return view('frontend.about', compact('chefs', 'aboutSettings', 'reviews'));
    }
}
