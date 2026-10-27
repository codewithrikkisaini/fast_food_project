<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Services\RestaurantDataService;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    protected RestaurantDataService $dataService;

    // Service inject karna
    public function __construct(RestaurantDataService $dataService)
    {
        $this->dataService = $dataService;
    }

    /**
     * Customer Testimonials & Reviews Page (Route: /reviews)
     */
    public function index()
    {
        // Step 1: Reviews aur rating settings lena
        $reviews        = $this->dataService->getReviews();
        $reviewSettings = $this->dataService->getReviewSettings();

        // Step 2: Blade view me bhejna
        return view('frontend.reviews', compact('reviews', 'reviewSettings'));
    }

    /**
     * Customer ka Naya Review Save karna (Route: POST /reviews)
     */
    public function store(Request $request)
    {
        // Step 1: Form validation
        $validated = $request->validate([
            'name'    => 'required|string',
            'role'    => 'nullable|string',
            'rating'  => 'required|integer|min:1|max:5',
            'message' => 'required|string',
        ]);

        // Step 2: Review format prepare karke save karna
        $this->dataService->addReview([
            'name'   => $validated['name'],
            'role'   => $validated['role'] ?? 'Happy Customer',
            'rating' => (int) $validated['rating'],
            'text'   => $validated['message'],
            'status' => 'Approved'
        ]);

        // Step 3: Success message ke sath redirect karna
        return back()->with('success', 'Thank you! Aapka review successfully submit ho gaya hai.');
    }
}
