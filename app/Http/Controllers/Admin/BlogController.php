<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\RestaurantDataService;
use Illuminate\Http\Request;

class BlogController extends Controller
{
    protected RestaurantDataService $dataService;

    // Service inject karna
    public function __construct(RestaurantDataService $dataService)
    {
        $this->dataService = $dataService;
    }

    /**
     * Blog Page - Sabhi blog posts dekhne ke liye
     */
    public function index()
    {
        // Step 1: Saare blog posts lena
        $blogs = $this->dataService->getBlogPosts();

        // Step 2: Blade view me bhejna
        return view('admin.blog', compact('blogs'));
    }

    /**
     * Naya Blog Post Publish karna
     */
    public function store(Request $request)
    {
        // Step 1: Form validation
        $request->validate([
            'title'    => 'required|string',
            'category' => 'required|string',
            'author'   => 'required|string',
            'excerpt'  => 'required|string',
            'content'  => 'required|string',
        ]);

        // Form ka sara data lena
        $data = $request->except(['_token', 'image_file']);

        // Step 2: Blog image upload karna
        if ($request->hasFile('image_file')) {
            $file = $request->file('image_file');
            $fileName = 'blog_' . time() . '.' . $file->extension();
            $file->move(public_path('img/uploads'), $fileName);
            $data['image'] = 'img/uploads/' . $fileName;
        }

        // Default image agar user ne image na lagayi ho
        if (empty($data['image'])) {
            $data['image'] = 'img/blog/1.jpg';
        }

        // Current date set karna agar missing ho
        if (empty($data['day'])) {
            $data['day'] = date('d');
        }
        if (empty($data['month'])) {
            $data['month'] = date('M');
        }

        // Step 3: Blog post save karna
        $this->dataService->addBlogPost($data);

        return back()->with('success', 'Naya blog article successfully publish ho gaya!');
    }

    /**
     * Existing Blog Post Update karna
     */
    public function update(Request $request, $id)
    {
        // Step 1: Form validation
        $request->validate([
            'title'    => 'required|string',
            'category' => 'required|string',
            'author'   => 'required|string',
            'excerpt'  => 'required|string',
            'content'  => 'required|string',
        ]);

        $data = $request->except(['_token', 'image_file']);

        // Step 2: Nayi image upload karna agar select ki gayi ho
        if ($request->hasFile('image_file')) {
            $file = $request->file('image_file');
            $fileName = 'blog_' . time() . '.' . $file->extension();
            $file->move(public_path('img/uploads'), $fileName);
            $data['image'] = 'img/uploads/' . $fileName;
        }

        // Step 3: Blog post update karna
        $this->dataService->updateBlogPost((int) $id, $data);

        return back()->with('success', 'Blog article successfully update ho gaya!');
    }

    /**
     * Blog Post Delete karna
     */
    public function destroy($id)
    {
        // ID ke basis par blog delete karna
        $this->dataService->deleteBlogPost((int) $id);

        return back()->with('success', 'Blog article delete ho gaya!');
    }
}
