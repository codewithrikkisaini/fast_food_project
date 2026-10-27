<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Services\RestaurantDataService;
use Illuminate\Http\Request;

class ReservationController extends Controller
{
    protected RestaurantDataService $dataService;

    public function __construct(RestaurantDataService $dataService)
    {
        $this->dataService = $dataService;
    }

    /**
     * Display table booking page (Route: /reservation).
     */
    public function index()
    {
        // Step 1: Retrieve restaurant settings
        $homeSettings = $this->dataService->getHomeSettings();

        // Step 2: Render reservation blade view
        return view('frontend.reservation', compact('homeSettings'));
    }

    /**
     * Process visitor table booking request (Route: POST /reservation).
     */
    public function store(Request $request)
    {
        // Step 1: Validate table reservation fields
        $validated = $request->validate([
            'name'             => 'required|string',
            'phone'            => 'required|string',
            'email'            => 'required|email',
            'guests'           => 'required|string',
            'date'             => 'required|string',
            'time'             => 'required|string',
            'special_requests' => 'nullable|string',
        ]);

        // Step 2: Save reservation submission via service
        $this->dataService->addReservation($validated);

        // Step 3: Redirect back with success status
        return back()->with('success', 'Your table reservation request has been submitted successfully! We will confirm your booking shortly.');
    }
}
