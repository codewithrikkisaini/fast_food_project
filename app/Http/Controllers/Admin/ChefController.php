<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\RestaurantDataService;
use Illuminate\Http\Request;

class ChefController extends Controller
{
    protected RestaurantDataService $dataService;

    // Service inject karna
    public function __construct(RestaurantDataService $dataService)
    {
        $this->dataService = $dataService;
    }

    /**
     * Chefs Page - Sabhi chefs ki list dekhne ke liye
     */
    public function index()
    {
        // Step 1: Saare chefs ka data lena
        $chefs = $this->dataService->getChefs();

        // Step 2: Blade view me data bhejna
        return view('admin.chefs', compact('chefs'));
    }

    /**
     * Chef ko add ya update karne ke liye
     */
    public function store(Request $request)
    {
        // Step 1: Form validation - zaroori fields check karna
        $request->validate([
            'name' => 'required|string',
            'role' => 'required|string',
            'exp'  => 'required|string',
        ]);

        // Form ka sara data lena
        $data = $request->except(['_token', 'image_file']);

        // Step 2: Chef ki photo upload karna
        if ($request->hasFile('image_file')) {
            $file = $request->file('image_file');
            $fileName = 'chef_' . time() . '.' . $file->extension();
            $file->move(public_path('img/uploads'), $fileName);
            $data['image'] = 'img/uploads/' . $fileName;
        }

        // Agar koi photo nahi hai to default photo lagana
        if (empty($data['image'])) {
            $data['image'] = 'img/chefs/1.jpg';
        }

        // Step 3: Data save karna
        $this->dataService->saveChef($data);

        // Step 4: Success message ke sath wapas bhej dena
        return back()->with('success', 'Chef profile successfully save ho gayi!');
    }

    /**
     * Chef ko delete karne ke liye
     */
    public function destroy($id)
    {
        // ID ke hisab se chef delete karna
        $this->dataService->deleteChef((int) $id);

        return back()->with('success', 'Chef profile delete ho gayi!');
    }
}
