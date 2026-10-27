<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\RestaurantDataService;
use Illuminate\Http\Request;

class AboutController extends Controller
{
    protected RestaurantDataService $dataService;

    // Service inject karna
    public function __construct(RestaurantDataService $dataService)
    {
        $this->dataService = $dataService;
    }

    /**
     * About Us Settings Page open karna
     */
    public function index()
    {
        // Step 1: Service se about page ka data lena
        $about = $this->dataService->getAboutSettings();

        // Step 2: Blade view me data pass karna
        return view('admin.about', compact('about'));
    }

    /**
     * About Us Section ko update karna
     */
    public function update(Request $request)
    {
        // Step 1: Form Validation - zaroori fields check karna
        $request->validate([
            'tagline' => 'required|string',
            'title'   => 'required|string',
            'desc'    => 'required|string',
        ]);

        // Form ka sara data lena
        $data = $request->except(['_token', 'image1_file', 'image2_file']);

        // Step 2: Main image upload karna agar user ne choose ki hai
        if ($request->hasFile('image1_file')) {
            $file = $request->file('image1_file');
            $fileName = 'about1_' . time() . '.' . $file->extension();
            $file->move(public_path('img/uploads'), $fileName);
            $data['image1'] = 'img/uploads/' . $fileName;
        }

        // Step 3: Second floating image upload karna
        if ($request->hasFile('image2_file')) {
            $file = $request->file('image2_file');
            $fileName = 'about2_' . time() . '.' . $file->extension();
            $file->move(public_path('img/uploads'), $fileName);
            $data['image2'] = 'img/uploads/' . $fileName;
        }

        // Step 4: Quality points ko filter karna (sirf bhare hue points save honge)
        if (!empty($request->points)) {
            $points = [];
            foreach ($request->points as $item) {
                if (!empty($item['title'])) {
                    $points[] = [
                        'title' => $item['title'],
                        'desc'  => $item['desc'] ?? '',
                        'icon'  => !empty($item['icon']) ? $item['icon'] : 'fas fa-check-circle',
                        'color' => !empty($item['color']) ? $item['color'] : 'r',
                    ];
                }
            }
            $data['points'] = $points;
        }

        // Step 5: Data save karna
        $this->dataService->updateAboutSettings($data);

        // Step 6: Success message ke sath wapas bhej dena
        return back()->with('success', 'About page successfully update ho gaya!');
    }
}
