<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\RestaurantDataService;
use Illuminate\Http\Request;

class BlogController extends Controller
{
    protected RestaurantDataService $dataService;

    public function __construct(RestaurantDataService $dataService)
    {
        $this->dataService = $dataService;
    }

    /**
     * Display all blog articles.
     */
    public function index()
    {
        // Step 1: Retrieve all blog articles
        $blogs = $this->dataService->getBlogPosts();

        // Step 2: Render admin blog view
        return view('admin.blog', compact('blogs'));
    }

    /**
     * Publish a new blog article.
     */
    public function store(Request $request)
    {
        // Step 1: Validate article inputs
        $request->validate([
            'title'    => 'required|string',
            'category' => 'required|string',
            'author'   => 'required|string',
            'excerpt'  => 'required|string',
            'content'  => 'required|string',
        ]);

        $data = $request->except(['_token', 'image_file']);

        // Step 2: Upload article thumbnail if provided
        if ($request->hasFile('image_file')) {
            $file = $request->file('image_file');
            $fileName = 'blog_' . time() . '.' . $file->extension();
            $file->move(public_path('img/uploads'), $fileName);
            $data['image'] = 'img/uploads/' . $fileName;
        }

        // Apply default thumbnail if none selected
        if (empty($data['image'])) {
            $data['image'] = 'img/blog/1.jpg';
        }

        // Set publishing timestamp if empty
        if (empty($data['day'])) {
            $data['day'] = date('d');
        }
        if (empty($data['month'])) {
            $data['month'] = date('M');
        }

        // Step 3: Save article via service
        $this->dataService->addBlogPost($data);

        // Step 4: Redirect back with success status
        return back()->with('success', 'Blog article published successfully!');
    }

    /**
     * Update an existing blog article.
     */
    public function update(Request $request, $id)
    {
        // Step 1: Validate updated article inputs
        $request->validate([
            'title'    => 'required|string',
            'category' => 'required|string',
            'author'   => 'required|string',
            'excerpt'  => 'required|string',
            'content'  => 'required|string',
        ]);

        $data = $request->except(['_token', 'image_file']);

        // Step 2: Upload new thumbnail if provided
        if ($request->hasFile('image_file')) {
            $file = $request->file('image_file');
            $fileName = 'blog_' . time() . '.' . $file->extension();
            $file->move(public_path('img/uploads'), $fileName);
            $data['image'] = 'img/uploads/' . $fileName;
        }

        // Step 3: Update article record
        $this->dataService->updateBlogPost((int) $id, $data);

        return back()->with('success', 'Blog article updated successfully!');
    }

    /**
     * Delete an article by ID.
     */
    public function destroy($id)
    {
        $this->dataService->deleteBlogPost((int) $id);

        return back()->with('success', 'Blog article deleted successfully!');
    }
}
