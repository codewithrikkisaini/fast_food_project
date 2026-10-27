<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\RestaurantDataService;
use Illuminate\Http\Request;

class ChefController extends Controller
{
    protected RestaurantDataService $dataService;

    public function __construct(RestaurantDataService $dataService)
    {
        $this->dataService = $dataService;
    }

    /**
     * Display all chef team profiles.
     */
    public function index()
    {
        // Step 1: Retrieve all chef profiles from service
        $chefs = $this->dataService->getChefs();

        // Step 2: Render admin chefs view
        return view('admin.chefs', compact('chefs'));
    }

    /**
     * Create or update a chef profile.
     */
    public function store(Request $request)
    {
        // Step 1: Validate required chef information
        $request->validate([
            'name' => 'required|string',
            'role' => 'required|string',
            'exp'  => 'required|string',
        ]);

        $data = $request->except(['_token', 'image_file']);

        // Step 2: Upload chef photo if provided
        if ($request->hasFile('image_file')) {
            $file = $request->file('image_file');
            $fileName = 'chef_' . time() . '.' . $file->extension();
            $file->move(public_path('img/uploads'), $fileName);
            $data['image'] = 'img/uploads/' . $fileName;
        }

        // Apply default placeholder image if none exists
        if (empty($data['image'])) {
            $data['image'] = 'img/chefs/1.jpg';
        }

        // Step 3: Save chef profile via service
        $this->dataService->saveChef($data);

        // Step 4: Redirect back with success status
        return back()->with('success', 'Chef profile saved successfully!');
    }

    /**
     * Delete a chef profile by ID.
     */
    public function destroy($id)
    {
        $this->dataService->deleteChef((int) $id);

        return back()->with('success', 'Chef profile removed successfully!');
    }
}
