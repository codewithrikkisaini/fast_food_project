<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Services\RestaurantDataService;
use Illuminate\Http\Request;

class ReservationController extends Controller
{
    protected RestaurantDataService $dataService;

    // Service inject karna
    public function __construct(RestaurantDataService $dataService)
    {
        $this->dataService = $dataService;
    }

    /**
     * Table Booking Page open karna (Route: /reservation)
     */
    public function index()
    {
        // Step 1: Restaurant ki home settings lena
        $homeSettings = $this->dataService->getHomeSettings();

        // Step 2: Blade view me bhejna
        return view('frontend.reservation', compact('homeSettings'));
    }

    /**
     * Customer ki Table Booking Request Save karna (Route: POST /reservation)
     */
    public function store(Request $request)
    {
        // Step 1: Form validation - zaroori fields check karna
        $validated = $request->validate([
            'name'             => 'required|string',
            'phone'            => 'required|string',
            'email'            => 'required|email',
            'guests'           => 'required|string',
            'date'             => 'required|string',
            'time'             => 'required|string',
            'special_requests' => 'nullable|string',
        ]);

        // Step 2: Service ke zariye reservation save karna
        $this->dataService->addReservation($validated);

        // Step 3: Success message ke sath redirect back karna
        return back()->with('success', 'Aapka table reservation request successfully submit ho gaya hai! Hum jald hi confirm karenge.');
    }
}
