<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Services\RestaurantDataService;

class GalleryController extends Controller
{
    protected RestaurantDataService $dataService;

    // Service inject karna
    public function __construct(RestaurantDataService $dataService)
    {
        $this->dataService = $dataService;
    }

    /**
     * Public Gallery Showcase Page (Route: /gallery)
     */
    public function index()
    {
        // Step 1: Saari gallery photos service se lena
        $galleryItems = $this->dataService->getGalleryItems();

        // Step 2: Gallery blade view me bhejna
        return view('frontend.gallery', compact('galleryItems'));
    }
}
