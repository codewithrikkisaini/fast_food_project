<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Services\RestaurantDataService;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    protected RestaurantDataService $dataService;

    public function __construct(RestaurantDataService $dataService)
    {
        $this->dataService = $dataService;
    }

    /**
     * Display public contact page (Route: /contact).
     */
    public function index()
    {
        // Step 1: Retrieve contact details from settings
        $homeSettings = $this->dataService->getHomeSettings();

        // Step 2: Render contact blade view with data
        return view('frontend.contact', compact('homeSettings'));
    }

    /**
     * Process visitor contact inquiry submission (Route: POST /contact).
     */
    public function store(Request $request)
    {
        // Step 1: Validate contact form fields
        $validated = $request->validate([
            'name'    => 'required|string',
            'email'   => 'required|email',
            'phone'   => 'nullable|string',
            'subject' => 'nullable|string',
            'message' => 'required|string',
        ]);

        if (empty($validated['subject'])) {
            $validated['subject'] = 'General Inquiry';
        }

        // Step 2: Save inquiry message via service
        $this->dataService->addContact($validated);

        // Step 3: Redirect back with success status
        return back()->with('success', 'Thank you for reaching out! Your message has been received.');
    }
}
