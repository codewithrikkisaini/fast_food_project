<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Services\RestaurantDataService;

class BlogController extends Controller
{
    protected RestaurantDataService $dataService;

    // Service inject karna
    public function __construct(RestaurantDataService $dataService)
    {
        $this->dataService = $dataService;
    }

    /**
     * Blog List Page (Route: /blog)
     */
    public function index()
    {
        // Step 1: Saare blog posts service se lena
        $blogs = $this->dataService->getBlogPosts();

        // Step 2: Blog list view me bhejna
        return view('frontend.blog', compact('blogs'));
    }

    /**
     * Single Blog Detail Page (Route: /blog/{id})
     */
    public function show($id)
    {
        // Step 1: Saare blog posts lena
        $blogs = $this->dataService->getBlogPosts();

        // Step 2: URL ki ID ke hisab se specific blog post find karna
        $post = collect($blogs)->firstWhere('id', (int) $id) ?? ($blogs[0] ?? []);

        // Step 3: Sidebar me dikhane ke liye recent posts lena
        $recentPosts = collect($blogs)->where('id', '!=', $post['id'] ?? 0)->values();

        // Step 4: Blog detail blade view me data bhejna
        return view('frontend.blog-detail', compact('post', 'recentPosts'));
    }
}
