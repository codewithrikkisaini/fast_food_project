<?php

namespace App\Http\Controllers\Admin;

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
     * Display all customer reviews and overview metrics.
     */
    public function index()
    {
        // Step 1: Retrieve reviews and rating settings
        $reviews = $this->dataService->getReviews();
        $reviewSettings = $this->dataService->getReviewSettings();

        // Step 2: Render admin reviews view
        return view('admin.reviews', compact('reviews', 'reviewSettings'));
    }

    /**
     * Update rating overview settings and percentages.
     */
    public function updateSettings(Request $request)
    {
        // Step 1: Validate metric inputs
        $validated = $request->validate([
            'overall_rating'  => 'required|string',
            'rating_subtitle' => 'required|string',
            'metric1_label'   => 'required|string',
            'metric1_percent' => 'required|integer',
            'metric2_label'   => 'required|string',
            'metric2_percent' => 'required|integer',
            'metric3_label'   => 'required|string',
            'metric3_percent' => 'required|integer',
        ]);

        // Step 2: Save updated metrics
        $this->dataService->updateReviewSettings($validated);

        return back()->with('success', 'Reviews settings updated successfully!');
    }

    /**
     * Add a new customer review record.
     */
    public function store(Request $request)
    {
        // Step 1: Validate review data
        $request->validate([
            'name'   => 'required|string',
            'rating' => 'required|integer|min:1|max:5',
            'text'   => 'required|string',
            'status' => 'required|string',
        ]);

        $data = $request->except(['_token', 'image_file']);

        // Step 2: Upload customer photo if provided
        if ($request->hasFile('image_file')) {
            $file = $request->file('image_file');
            $fileName = 'rev_' . time() . '.' . $file->extension();
            $file->move(public_path('img/uploads'), $fileName);
            $data['image'] = 'img/uploads/' . $fileName;
        }

        // Apply default customer avatar if empty
        if (empty($data['image'])) {
            $data['image'] = 'img/testimonial/1.jpg';
        }

        // Step 3: Save review via service
        $this->dataService->addReview($data);

        return back()->with('success', 'Customer review added successfully!');
    }

    /**
     * Update an existing customer review.
     */
    public function update(Request $request, $id)
    {
        // Step 1: Validate review update inputs
        $request->validate([
            'name'   => 'required|string',
            'rating' => 'required|integer|min:1|max:5',
            'text'   => 'required|string',
            'status' => 'required|string',
        ]);

        $data = $request->except(['_token', 'image_file']);

        // Step 2: Handle optional new image upload
        if ($request->hasFile('image_file')) {
            $file = $request->file('image_file');
            $fileName = 'rev_' . time() . '.' . $file->extension();
            $file->move(public_path('img/uploads'), $fileName);
            $data['image'] = 'img/uploads/' . $fileName;
        }

        // Step 3: Save review modifications
        $this->dataService->updateReview((int) $id, $data);

        return back()->with('success', 'Review #' . $id . ' updated successfully!');
    }

    /**
     * Update visibility status of a review (Approved or Hidden).
     */
    public function updateStatus(Request $request, $id)
    {
        $status = $request->input('status', 'Approved');
        $this->dataService->updateReviewStatus((int) $id, $status);

        return back()->with('success', "Review #{$id} status updated to {$status}!");
    }

    /**
     * Delete a single review record.
     */
    public function destroy($id)
    {
        $this->dataService->deleteReview((int) $id);

        return back()->with('success', 'Review deleted successfully!');
    }

    /**
     * Remove all customer reviews.
     */
    public function destroyAll()
    {
        $this->dataService->deleteAllReviews();

        return back()->with('success', 'All customer reviews cleared successfully!');
    }
}
