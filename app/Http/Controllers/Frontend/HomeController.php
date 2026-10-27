<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Services\RestaurantDataService;

class HomeController extends Controller
{
    protected RestaurantDataService $dataService;

    public function __construct(RestaurantDataService $dataService)
    {
        $this->dataService = $dataService;
    }

    /**
     * Display public landing page (Route: /).
     */
    public function index()
    {
        // Step 1: Retrieve all homepage showcases and settings
        $menuItems     = $this->dataService->getMenuItems();
        $chefs         = $this->dataService->getChefs();
        $blogs         = $this->dataService->getBlogPosts();
        $reviews       = $this->dataService->getReviews();
        $homeSettings  = $this->dataService->getHomeSettings();
        $aboutSettings = $this->dataService->getAboutSettings();
        $galleryItems  = $this->dataService->getGalleryItems();

        // Step 2: Render home blade view with data
        return view('frontend.home', compact(
            'menuItems',
            'chefs',
            'blogs',
            'reviews',
            'homeSettings',
            'aboutSettings',
            'galleryItems'
        ));
    }
}
