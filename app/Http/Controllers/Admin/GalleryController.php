<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\RestaurantDataService;
use Illuminate\Http\Request;

class GalleryController extends Controller
{
    protected RestaurantDataService $dataService;

    // Service inject karna
    public function __construct(RestaurantDataService $dataService)
    {
        $this->dataService = $dataService;
    }

    /**
     * Gallery Page - Saari photos dekhne ke liye
     */
    public function index()
    {
        // Step 1: Saare gallery items lena
        $galleryItems = $this->dataService->getGalleryItems();

        // Step 2: Blade view me bhejna
        return view('admin.gallery', compact('galleryItems'));
    }

    /**
     * Gallery Photo Add ya Update karne ke liye
     */
    public function store(Request $request)
    {
        // Step 1: Form validation
        $request->validate([
            'title' => 'required|string',
            'desc'  => 'required|string',
        ]);

        // Form ka sara data lena
        $data = $request->except(['_token', 'image_file']);

        // Step 2: Photo upload karna
        if ($request->hasFile('image_file')) {
            $file = $request->file('image_file');
            $fileName = 'gallery_' . time() . '.' . $file->extension();
            $file->move(public_path('img/uploads'), $fileName);
            $data['image'] = 'img/uploads/' . $fileName;
        }

        // Agar photo select nahi ki to default photo lagana
        if (empty($data['image'])) {
            $data['image'] = 'img/portfolio/work1.jpg';
        }

        // Step 3: Photo save karna
        $this->dataService->saveGalleryItem($data);

        // Step 4: Success message ke sath wapas bhej dena
        return back()->with('success', 'Gallery item successfully save ho gaya!');
    }

    /**
     * Gallery Item Delete karne ke liye
     */
    public function destroy($id)
    {
        // ID ke basis par item delete karna
        $this->dataService->deleteGalleryItem((int) $id);

        return back()->with('success', 'Gallery item delete ho gaya!');
    }
}
