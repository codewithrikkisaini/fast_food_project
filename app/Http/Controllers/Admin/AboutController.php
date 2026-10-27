<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\RestaurantDataService;
use Illuminate\Http\Request;

class AboutController extends Controller
{
    protected RestaurantDataService $dataService;

    public function __construct(RestaurantDataService $dataService)
    {
        $this->dataService = $dataService;
    }

    /**
     * Display the About page management view.
     */
    public function index()
    {
        // Step 1: Retrieve about settings from data service
        $about = $this->dataService->getAboutSettings();

        // Step 2: Render admin about view with data
        return view('admin.about', compact('about'));
    }

    /**
     * Update the About section content and images.
     */
    public function update(Request $request)
    {
        // Step 1: Validate incoming request
        $request->validate([
            'tagline' => 'required|string',
            'title'   => 'required|string',
            'desc'    => 'required|string',
        ]);

        $data = $request->except(['_token', 'image1_file', 'image2_file']);

        // Step 2: Upload primary about image if provided
        if ($request->hasFile('image1_file')) {
            $file = $request->file('image1_file');
            $fileName = 'about1_' . time() . '.' . $file->extension();
            $file->move(public_path('img/uploads'), $fileName);
            $data['image1'] = 'img/uploads/' . $fileName;
        }

        // Step 3: Upload secondary floating image if provided
        if ($request->hasFile('image2_file')) {
            $file = $request->file('image2_file');
            $fileName = 'about2_' . time() . '.' . $file->extension();
            $file->move(public_path('img/uploads'), $fileName);
            $data['image2'] = 'img/uploads/' . $fileName;
        }

        // Step 4: Filter quality feature points
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

        // Step 5: Save updated data via service
        $this->dataService->updateAboutSettings($data);

        // Step 6: Redirect back with success status
        return back()->with('success', 'About page content updated successfully!');
    }
}
