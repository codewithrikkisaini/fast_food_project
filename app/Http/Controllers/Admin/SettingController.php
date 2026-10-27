<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\RestaurantDataService;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    protected RestaurantDataService $dataService;

    // Service inject karna
    public function __construct(RestaurantDataService $dataService)
    {
        $this->dataService = $dataService;
    }

    /**
     * Restaurant Settings Page - Phone, Address, Timings, Social links dekhna
     */
    public function index()
    {
        // Step 1: Restaurant ki site settings lena
        $settings = $this->dataService->getSiteSettings();

        // Step 2: Blade view me bhejna
        return view('admin.settings', compact('settings'));
    }

    /**
     * Restaurant Settings Update karna
     */
    public function update(Request $request)
    {
        // Step 1: Form ka saara data lena
        $data = $request->except('_token');

        // Step 2: Settings save karna
        $this->dataService->updateSiteSettings($data);

        // Step 3: Success message ke sath wapas bhejna
        return back()->with('success', 'Restaurant settings successfully update ho gayi!');
    }
}
