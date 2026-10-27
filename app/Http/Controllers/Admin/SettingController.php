<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\RestaurantDataService;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    protected RestaurantDataService $dataService;

    public function __construct(RestaurantDataService $dataService)
    {
        $this->dataService = $dataService;
    }

    /**
     * Display restaurant site settings and contact information.
     */
    public function index()
    {
        // Step 1: Retrieve global site settings
        $settings = $this->dataService->getSiteSettings();

        // Step 2: Render admin settings view
        return view('admin.settings', compact('settings'));
    }

    /**
     * Update restaurant global settings.
     */
    public function update(Request $request)
    {
        // Step 1: Extract form data excluding token
        $data = $request->except('_token');

        // Step 2: Save updated site settings
        $this->dataService->updateSiteSettings($data);

        // Step 3: Redirect back with success message
        return back()->with('success', 'Restaurant settings updated successfully!');
    }
}
