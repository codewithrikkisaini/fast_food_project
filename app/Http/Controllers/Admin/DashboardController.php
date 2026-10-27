<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\RestaurantDataService;

class DashboardController extends Controller
{
    protected RestaurantDataService $dataService;

    public function __construct(RestaurantDataService $dataService)
    {
        $this->dataService = $dataService;
    }

    /**
     * Display the Admin Dashboard metrics and activity feeds.
     */
    public function index()
    {
        // Step 1: Retrieve high-level statistics
        $stats = $this->dataService->getStats();

        // Step 2: Retrieve recent reservations and contact inquiries
        $recentReservations = array_slice($this->dataService->getReservations(), 0, 6);
        $recentContacts     = array_slice($this->dataService->getContacts(), 0, 5);

        // Step 3: Retrieve top menu items
        $menuItems = $this->dataService->getMenuItems();

        // Step 4: Render dashboard view with data
        return view('admin.dashboard', compact('stats', 'recentReservations', 'recentContacts', 'menuItems'));
    }
}
