<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\RestaurantDataService;
use Illuminate\Http\Request;

class MenuController extends Controller
{
    protected RestaurantDataService $dataService;

    public function __construct(RestaurantDataService $dataService)
    {
        $this->dataService = $dataService;
    }

    /**
     * Display all restaurant menu items.
     */
    public function index()
    {
        // Step 1: Retrieve all menu items from data service
        $menuItems = $this->dataService->getMenuItems();

        // Step 2: Render admin menu view
        return view('admin.menu', compact('menuItems'));
    }

    /**
     * Create or update a menu dish item.
     */
    public function store(Request $request)
    {
        // Step 1: Validate menu input fields
        $request->validate([
            'title'    => 'required|string',
            'category' => 'required|string',
            'price'    => 'required|numeric',
            'desc'     => 'required|string',
        ]);

        $data = $request->except(['_token', 'image_file']);

        // Step 2: Upload dish photo if provided
        if ($request->hasFile('image_file')) {
            $file = $request->file('image_file');
            $fileName = 'menu_' . time() . '.' . $file->extension();
            $file->move(public_path('img/uploads'), $fileName);
            $data['image'] = 'img/uploads/' . $fileName;
        }

        // Step 3: Set formatted category name if missing
        if (empty($data['category_name'])) {
            $data['category_name'] = ucfirst($data['category']);
        }

        // Step 4: Persist menu item via service
        $this->dataService->saveMenuItem($data);

        // Step 5: Redirect back with success status
        return back()->with('success', 'Menu item saved successfully!');
    }

    /**
     * Remove a menu item by ID.
     */
    public function destroy($id)
    {
        $this->dataService->deleteMenuItem((int) $id);

        return back()->with('success', 'Menu item deleted successfully!');
    }
}
