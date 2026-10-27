<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Services\RestaurantDataService;

class HomeController extends Controller
{
    protected RestaurantDataService $dataService;

    // Service inject karna
    public function __construct(RestaurantDataService $dataService)
    {
        $this->dataService = $dataService;
    }

    /**
     * Public Home Page (Route: /)
     */
    public function index()
    {
        // Step 1: Homepage par display hone wala data service se lena
        $menuItems     = $this->dataService->getMenuItems();
        $chefs         = $this->dataService->getChefs();
        $blogs         = $this->dataService->getBlogPosts();
        $reviews       = $this->dataService->getReviews();
        $homeSettings  = $this->dataService->getHomeSettings();
        $aboutSettings = $this->dataService->getAboutSettings();
        $galleryItems  = $this->dataService->getGalleryItems();

        // Step 2: Homepage blade view me saara data pass karna
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
