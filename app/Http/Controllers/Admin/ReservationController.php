<?php

namespace App\Http\Controllers\Admin;

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
     * Table Bookings Page - Sabhi reservations dekhne ke liye
     */
    public function index()
    {
        // Step 1: Saari reservations lena
        $reservations = $this->dataService->getReservations();

        // Step 2: Blade view me bhejna
        return view('admin.reservations', compact('reservations'));
    }

    /**
     * Reservation Status Update karna (Confirmed ya Cancelled)
     */
    public function updateStatus(Request $request, $id)
    {
        // Request se status lena (default: Confirmed)
        $status = $request->input('status', 'Confirmed');

        // Status update karna
        $this->dataService->updateReservationStatus((int) $id, $status);

        return back()->with('success', "Reservation #{$id} ka status {$status} ho gaya!");
    }

    /**
     * Reservation Delete karne ke liye
     */
    public function destroy($id)
    {
        // ID ke basis par reservation record delete karna
        $this->dataService->deleteReservation((int) $id);

        return back()->with('success', 'Reservation record delete ho gaya!');
    }
}
