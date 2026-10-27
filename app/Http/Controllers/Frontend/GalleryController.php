<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Services\RestaurantDataService;

class GalleryController extends Controller
{
    protected RestaurantDataService $dataService;

    public function __construct(RestaurantDataService $dataService)
    {
        $this->dataService = $dataService;
    }

    /**
     * Display public gallery showcase page (Route: /gallery).
     */
    public function index()
    {
        // Step 1: Retrieve gallery showcase images from service
        $galleryItems = $this->dataService->getGalleryItems();

        // Step 2: Render gallery blade view with data
        return view('frontend.gallery', compact('galleryItems'));
    }
}
