<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\RestaurantDataService;
use Illuminate\Http\Request;

class MenuController extends Controller
{
    protected RestaurantDataService $dataService;

    // Service inject karna
    public function __construct(RestaurantDataService $dataService)
    {
        $this->dataService = $dataService;
    }

    /**
     * Menu Page - Saare menu items dekhne ke liye
     */
    public function index()
    {
        // Step 1: Saare menu items lena
        $menuItems = $this->dataService->getMenuItems();

        // Step 2: Blade view me data bhejna
        return view('admin.menu', compact('menuItems'));
    }

    /**
     * Menu Item Add ya Update karne ke liye
     */
    public function store(Request $request)
    {
        // Step 1: Form validation - zaroori fields check karna
        $request->validate([
            'title'    => 'required|string',
            'category' => 'required|string',
            'price'    => 'required|numeric',
            'desc'     => 'required|string',
        ]);

        // Form ka sara data lena
        $data = $request->except(['_token', 'image_file']);

        // Step 2: Dish ki image upload karna
        if ($request->hasFile('image_file')) {
            $file = $request->file('image_file');
            $fileName = 'menu_' . time() . '.' . $file->extension();
            $file->move(public_path('img/uploads'), $fileName);
            $data['image'] = 'img/uploads/' . $fileName;
        }

        // Step 3: Category ka naam set karna
        if (empty($data['category_name'])) {
            $data['category_name'] = ucfirst($data['category']);
        }

        // Step 4: Data save karna
        $this->dataService->saveMenuItem($data);

        // Step 5: Success message ke sath redirect karna
        return back()->with('success', 'Menu item successfully save ho gaya!');
    }

    /**
     * Menu Item Delete karne ke liye
     */
    public function destroy($id)
    {
        // ID ke basis par item delete karna
        $this->dataService->deleteMenuItem((int) $id);

        return back()->with('success', 'Menu item delete ho gaya!');
    }
}
