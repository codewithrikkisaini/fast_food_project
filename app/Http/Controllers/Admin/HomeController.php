<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\RestaurantDataService;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    protected RestaurantDataService $dataService;

    public function __construct(RestaurantDataService $dataService)
    {
        $this->dataService = $dataService;
    }

    /**
     * Display the Home section management view.
     */
    public function index()
    {
        // Step 1: Retrieve existing home settings
        $home = $this->dataService->getHomeSettings();

        // Step 2: Render admin home view with data
        return view('admin.home', compact('home'));
    }

    /**
     * Update hero banner and deal section content.
     */
    public function update(Request $request)
    {
        // Step 1: Validate required fields
        $request->validate([
            'hero_badge' => 'required|string',
            'hero_title' => 'required|string',
            'hero_desc'  => 'required|string',
        ]);

        $data = $request->except(['_token', 'hero_image_file', 'deal_image_file']);

        // Step 2: Upload hero background image if provided
        if ($request->hasFile('hero_image_file')) {
            $file = $request->file('hero_image_file');
            $fileName = 'hero_' . time() . '.' . $file->extension();
            $file->move(public_path('img/uploads'), $fileName);
            $data['hero_image'] = 'img/uploads/' . $fileName;
        }

        // Step 3: Upload promotional deal image if provided
        if ($request->hasFile('deal_image_file')) {
            $file = $request->file('deal_image_file');
            $fileName = 'deal_' . time() . '.' . $file->extension();
            $file->move(public_path('img/uploads'), $fileName);
            $data['deal_image'] = 'img/uploads/' . $fileName;
        }

        // Step 4: Save updated settings via service
        $this->dataService->updateHomeSettings($data);

        // Step 5: Redirect back with success status
        return back()->with('success', 'Home section content updated successfully!');
    }
}
