<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Services\RestaurantDataService;

class BlogController extends Controller
{
    protected RestaurantDataService $dataService;

    public function __construct(RestaurantDataService $dataService)
    {
        $this->dataService = $dataService;
    }

    /**
     * Display public blog articles list (Route: /blog).
     */
    public function index()
    {
        // Step 1: Retrieve all published articles
        $blogs = $this->dataService->getBlogPosts();

        // Step 2: Render blog list view with data
        return view('frontend.blog', compact('blogs'));
    }

    /**
     * Display single blog article detail (Route: /blog/{id}).
     */
    public function show($id)
    {
        // Step 1: Retrieve all blog articles
        $blogs = $this->dataService->getBlogPosts();

        // Step 2: Find target article by ID with fallback
        $post = collect($blogs)->firstWhere('id', (int) $id) ?? ($blogs[0] ?? []);

        // Step 3: Retrieve recent sidebar articles
        $recentPosts = collect($blogs)->where('id', '!=', $post['id'] ?? 0)->values();

        // Step 4: Render blog detail blade view
        return view('frontend.blog-detail', compact('post', 'recentPosts'));
    }
}
