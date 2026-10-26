<?php

namespace App\Http\Controllers;

use App\Services\RestaurantDataService;
use Illuminate\Http\Request;

class FrontendController extends Controller
{
    protected RestaurantDataService $dataService;

    public function __construct(RestaurantDataService $dataService)
    {
        $this->dataService = $dataService;
    }

    /**
     * Home Page (Route: /)
     */
    public function home()
    {
        $menuItems = $this->dataService->getMenuItems();
        $chefs = $this->dataService->getChefs();
        $blogs = $this->dataService->getBlogPosts();
        $reviews = $this->dataService->getReviews();
        $homeSettings = $this->dataService->getHomeSettings();
        $aboutSettings = $this->dataService->getAboutSettings();

        return view('frontend.home', compact(
            'menuItems',
            'chefs',
            'blogs',
            'reviews',
            'homeSettings',
            'aboutSettings'
        ));
    }

    /**
     * About Us Page (Route: /about)
     */
    public function about()
    {
        $chefs = $this->dataService->getChefs();
        $aboutSettings = $this->dataService->getAboutSettings();
        $reviews = $this->dataService->getReviews();

        return view('frontend.about', compact('chefs', 'aboutSettings', 'reviews'));
    }

    /**
     * Menu Page (Route: /menu)
     */
    public function menu()
    {
        $menuItems = $this->dataService->getMenuItems();
        $homeSettings = $this->dataService->getHomeSettings();

        return view('frontend.menu', compact('menuItems', 'homeSettings'));
    }

    /**
     * Chefs Page (Route: /chefs)
     */
    public function chefs()
    {
        $chefs = $this->dataService->getChefs();

        return view('frontend.chefs', compact('chefs'));
    }

    /**
     * Table Reservation Page (Route: /reservation)
     */
    public function reservation()
    {
        $homeSettings = $this->dataService->getHomeSettings();

        return view('frontend.reservation', compact('homeSettings'));
    }

    /**
     * Handle Reservation Form Submit (Route: POST /reservation)
     */
    public function storeReservation(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:100',
            'phone' => 'required|string|max:25',
            'email' => 'required|email|max:100',
            'guests' => 'required|string',
            'date' => 'required|string',
            'time' => 'required|string',
            'special_requests' => 'nullable|string|max:500'
        ]);

        $this->dataService->addReservation($validated);

        return back()->with('success', 'Your table reservation request has been submitted successfully! We will confirm your booking shortly.');
    }

    /**
     * Gallery Showcase Page (Route: /gallery)
     */
    public function gallery()
    {
        $galleryItems = $this->dataService->getGalleryItems();
        return view('frontend.gallery', compact('galleryItems'));
    }

    /**
     * Customer Reviews Page (Route: /reviews)
     */
    public function reviews()
    {
        $reviews = $this->dataService->getReviews();
        $reviewSettings = $this->dataService->getReviewSettings();

        return view('frontend.reviews', compact('reviews', 'reviewSettings'));
    }

    /**
     * Store Customer Review (Route: POST /reviews)
     */
    public function storeReview(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:100',
            'role' => 'nullable|string|max:100',
            'rating' => 'required|integer|min:1|max:5',
            'message' => 'required|string|max:1000'
        ]);

        $this->dataService->addReview([
            'name' => $validated['name'],
            'role' => $validated['role'] ?? 'Diner',
            'rating' => (int)$validated['rating'],
            'text' => $validated['message'],
            'status' => 'Approved'
        ]);

        return back()->with('success', 'Thank you for your feedback! Your review has been submitted successfully.');
    }

    /**
     * Blog List Page (Route: /blog)
     */
    public function blog()
    {
        $blogs = $this->dataService->getBlogPosts();

        return view('frontend.blog', compact('blogs'));
    }

    /**
     * Blog Single Detail Page (Route: /blog/{id})
     */
    public function blogDetail($id)
    {
        $blogs = $this->dataService->getBlogPosts();
        $post = collect($blogs)->firstWhere('id', (int)$id) ?? ($blogs[0] ?? []);
        $recentPosts = collect($blogs)->where('id', '!=', $post['id'] ?? 0)->values();

        return view('frontend.blog-detail', compact('post', 'recentPosts'));
    }

    /**
     * Contact Us Page (Route: /contact)
     */
    public function contact()
    {
        $homeSettings = $this->dataService->getHomeSettings();

        return view('frontend.contact', compact('homeSettings'));
    }

    /**
     * Handle Contact Message Form Submit (Route: POST /contact)
     */
    public function storeContact(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:100',
            'email' => 'required|email|max:100',
            'phone' => 'nullable|string|max:35',
            'subject' => 'nullable|string|max:150',
            'message' => 'required|string|max:3000'
        ]);

        if (empty($validated['subject'])) {
            $validated['subject'] = 'General Inquiry';
        }

        $this->dataService->addContact($validated);

        return back()->with('success', 'Thank you for reaching out! Your message has been received, and our team will get back to you within 2 hours.');
    }

    /**
     * Shopping Cart / Order Page (Route: /cart)
     */
    public function cart()
    {
        $menuItems = $this->dataService->getMenuItems();

        return view('frontend.cart', compact('menuItems'));
    }
}
