<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Services\RestaurantDataService;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    protected RestaurantDataService $dataService;

    // Service inject karna
    public function __construct(RestaurantDataService $dataService)
    {
        $this->dataService = $dataService;
    }

    /**
     * Contact Us Page (Route: /contact)
     */
    public function index()
    {
        // Step 1: Restaurant settings lena (phone, email, address etc.)
        $homeSettings = $this->dataService->getHomeSettings();

        // Step 2: Blade view me bhejna
        return view('frontend.contact', compact('homeSettings'));
    }

    /**
     * Visitor ka Contact Message Submit karna (Route: POST /contact)
     */
    public function store(Request $request)
    {
        // Step 1: Form validation
        $validated = $request->validate([
            'name'    => 'required|string',
            'email'   => 'required|email',
            'phone'   => 'nullable|string',
            'subject' => 'nullable|string',
            'message' => 'required|string',
        ]);

        // Default subject agar user ne na diya ho
        if (empty($validated['subject'])) {
            $validated['subject'] = 'General Inquiry';
        }

        // Step 2: Contact message save karna
        $this->dataService->addContact($validated);

        // Step 3: Success message ke sath wapas redirect karna
        return back()->with('success', 'Thank you! Aapka message successfully receive ho gaya hai.');
    }
}
