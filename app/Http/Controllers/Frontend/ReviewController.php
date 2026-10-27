<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Services\RestaurantDataService;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    protected RestaurantDataService $dataService;

    public function __construct(RestaurantDataService $dataService)
    {
        $this->dataService = $dataService;
    }

    /**
     * Display customer reviews and testimonials page (Route: /reviews).
     */
    public function index()
    {
        // Step 1: Retrieve customer reviews and rating metrics
        $reviews        = $this->dataService->getReviews();
        $reviewSettings = $this->dataService->getReviewSettings();

        // Step 2: Render reviews blade view with data
        return view('frontend.reviews', compact('reviews', 'reviewSettings'));
    }

    /**
     * Store visitor review submission (Route: POST /reviews).
     */
    public function store(Request $request)
    {
        // Step 1: Validate customer review fields
        $validated = $request->validate([
            'name'    => 'required|string',
            'role'    => 'nullable|string',
            'rating'  => 'required|integer|min:1|max:5',
            'message' => 'required|string',
        ]);

        // Step 2: Persist approved customer review
        $this->dataService->addReview([
            'name'   => $validated['name'],
            'role'   => $validated['role'] ?? 'Happy Diner',
            'rating' => (int) $validated['rating'],
            'text'   => $validated['message'],
            'status' => 'Approved'
        ]);

        // Step 3: Redirect back with success status
        return back()->with('success', 'Thank you for your feedback! Your review has been submitted successfully.');
    }
}
