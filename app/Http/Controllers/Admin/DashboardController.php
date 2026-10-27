<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\RestaurantDataService;

class DashboardController extends Controller
{
    protected RestaurantDataService $dataService;

    // Service inject karna
    public function __construct(RestaurantDataService $dataService)
    {
        $this->dataService = $dataService;
    }

    /**
     * Admin Dashboard Page - Summary statistics aur latest activity
     */
    public function index()
    {
        // Step 1: Total stats lena (reservations count, menu count, etc.)
        $stats = $this->dataService->getStats();

        // Step 2: Recent 6 reservations aur recent 5 contact messages lena
        $recentReservations = array_slice($this->dataService->getReservations(), 0, 6);
        $recentContacts     = array_slice($this->dataService->getContacts(), 0, 5);

        // Step 3: Top menu items lena
        $menuItems = $this->dataService->getMenuItems();

        // Step 4: Dashboard view me saara data pass karna
        return view('admin.dashboard', compact('stats', 'recentReservations', 'recentContacts', 'menuItems'));
    }
}
