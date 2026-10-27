<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\RestaurantDataService;
use Illuminate\Http\Request;

class GalleryController extends Controller
{
    protected RestaurantDataService $dataService;

    public function __construct(RestaurantDataService $dataService)
    {
        $this->dataService = $dataService;
    }

    /**
     * Display all gallery showcases.
     */
    public function index()
    {
        // Step 1: Retrieve all gallery items
        $galleryItems = $this->dataService->getGalleryItems();

        // Step 2: Render admin gallery view
        return view('admin.gallery', compact('galleryItems'));
    }

    /**
     * Create or update a gallery photo item.
     */
    public function store(Request $request)
    {
        // Step 1: Validate gallery inputs
        $request->validate([
            'title' => 'required|string',
            'desc'  => 'required|string',
        ]);

        $data = $request->except(['_token', 'image_file']);

        // Step 2: Upload gallery image if provided
        if ($request->hasFile('image_file')) {
            $file = $request->file('image_file');
            $fileName = 'gallery_' . time() . '.' . $file->extension();
            $file->move(public_path('img/uploads'), $fileName);
            $data['image'] = 'img/uploads/' . $fileName;
        }

        // Apply fallback default image if empty
        if (empty($data['image'])) {
            $data['image'] = 'img/portfolio/work1.jpg';
        }

        // Step 3: Save gallery item via service
        $this->dataService->saveGalleryItem($data);

        // Step 4: Redirect back with success status
        return back()->with('success', 'Gallery item saved successfully!');
    }

    /**
     * Remove a gallery item by ID.
     */
    public function destroy($id)
    {
        $this->dataService->deleteGalleryItem((int) $id);

        return back()->with('success', 'Gallery item deleted successfully!');
    }
}
