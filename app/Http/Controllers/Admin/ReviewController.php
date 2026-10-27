<?php

namespace App\Http\Controllers\Admin;

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
     * Reviews Page - Customer reviews aur rating settings dekhna
     */
    public function index()
    {
        // Step 1: Saare reviews aur settings data lena
        $reviews = $this->dataService->getReviews();
        $reviewSettings = $this->dataService->getReviewSettings();

        // Step 2: Blade view me bhejna
        return view('admin.reviews', compact('reviews', 'reviewSettings'));
    }

    /**
     * Review Overview Settings (Overall Rating, Percentages) update karna
     */
    public function updateSettings(Request $request)
    {
        // Step 1: Form validation
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

        // Step 2: Settings save karna
        $this->dataService->updateReviewSettings($validated);

        return back()->with('success', 'Reviews settings successfully update ho gayi!');
    }

    /**
     * Naya Customer Review Add karna
     */
    public function store(Request $request)
    {
        // Step 1: Form validation
        $request->validate([
            'name'   => 'required|string',
            'rating' => 'required|integer|min:1|max:5',
            'text'   => 'required|string',
            'status' => 'required|string',
        ]);

        // Form ka sara data lena
        $data = $request->except(['_token', 'image_file']);

        // Step 2: Customer photo upload karna
        if ($request->hasFile('image_file')) {
            $file = $request->file('image_file');
            $fileName = 'rev_' . time() . '.' . $file->extension();
            $file->move(public_path('img/uploads'), $fileName);
            $data['image'] = 'img/uploads/' . $fileName;
        }

        // Default avatar image agar photo na ho
        if (empty($data['image'])) {
            $data['image'] = 'img/testimonial/1.jpg';
        }

        // Step 3: Review save karna
        $this->dataService->addReview($data);

        return back()->with('success', 'Customer review successfully add ho gaya!');
    }

    /**
     * Existing Customer Review Update karna
     */
    public function update(Request $request, $id)
    {
        // Step 1: Form validation
        $request->validate([
            'name'   => 'required|string',
            'rating' => 'required|integer|min:1|max:5',
            'text'   => 'required|string',
            'status' => 'required|string',
        ]);

        $data = $request->except(['_token', 'image_file']);

        // Step 2: Photo upload agar nayi photo select ki gayi ho
        if ($request->hasFile('image_file')) {
            $file = $request->file('image_file');
            $fileName = 'rev_' . time() . '.' . $file->extension();
            $file->move(public_path('img/uploads'), $fileName);
            $data['image'] = 'img/uploads/' . $fileName;
        }

        // Step 3: Review update karna
        $this->dataService->updateReview((int) $id, $data);

        return back()->with('success', 'Review #' . $id . ' successfully update ho gaya!');
    }

    /**
     * Review Status Update karna (Approved ya Hidden)
     */
    public function updateStatus(Request $request, $id)
    {
        $status = $request->input('status', 'Approved');
        $this->dataService->updateReviewStatus((int) $id, $status);

        return back()->with('success', "Review #{$id} ka status {$status} ho gaya!");
    }

    /**
     * Single Review Delete karna
     */
    public function destroy($id)
    {
        $this->dataService->deleteReview((int) $id);
        return back()->with('success', 'Review record delete ho gaya!');
    }

    /**
     * Saare Reviews Delete karna
     */
    public function destroyAll()
    {
        $this->dataService->deleteAllReviews();
        return back()->with('success', 'Sabhi reviews delete ho gaye!');
    }
}
