<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\RestaurantDataService;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    protected RestaurantDataService $dataService;

    // Service inject karna
    public function __construct(RestaurantDataService $dataService)
    {
        $this->dataService = $dataService;
    }

    /**
     * Home Section Settings Page open karna
     */
    public function index()
    {
        // Step 1: Existing home data lena
        $home = $this->dataService->getHomeSettings();

        // Step 2: Blade view me data bhejna
        return view('admin.home', compact('home'));
    }

    /**
     * Home Section (Hero Banner & Deal) ko update karna
     */
    public function update(Request $request)
    {
        // Step 1: Form Validation - zaroori fields check karna
        $request->validate([
            'hero_badge' => 'required|string',
            'hero_title' => 'required|string',
            'hero_desc'  => 'required|string',
        ]);

        // Form ka sara data lena
        $data = $request->except(['_token', 'hero_image_file', 'deal_image_file']);

        // Step 2: Hero image upload karna
        if ($request->hasFile('hero_image_file')) {
            $file = $request->file('hero_image_file');
            $fileName = 'hero_' . time() . '.' . $file->extension();
            $file->move(public_path('img/uploads'), $fileName);
            $data['hero_image'] = 'img/uploads/' . $fileName;
        }

        // Step 3: Deal image upload karna
        if ($request->hasFile('deal_image_file')) {
            $file = $request->file('deal_image_file');
            $fileName = 'deal_' . time() . '.' . $file->extension();
            $file->move(public_path('img/uploads'), $fileName);
            $data['deal_image'] = 'img/uploads/' . $fileName;
        }

        // Step 4: Data save karna
        $this->dataService->updateHomeSettings($data);

        // Step 5: Success message ke sath wapas bhej dena
        return back()->with('success', 'Home section content successfully update ho gaya!');
    }
}
