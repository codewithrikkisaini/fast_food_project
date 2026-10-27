<?php

namespace App\Http\Controllers\Admin;

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
     * Display all table reservations.
     */
    public function index()
    {
        // Step 1: Retrieve all reservation records
        $reservations = $this->dataService->getReservations();

        // Step 2: Render admin reservations view
        return view('admin.reservations', compact('reservations'));
    }

    /**
     * Update status of a reservation (Confirmed or Cancelled).
     */
    public function updateStatus(Request $request, $id)
    {
        $status = $request->input('status', 'Confirmed');

        $this->dataService->updateReservationStatus((int) $id, $status);

        return back()->with('success', "Reservation #{$id} marked as {$status}!");
    }

    /**
     * Delete a reservation record by ID.
     */
    public function destroy($id)
    {
        $this->dataService->deleteReservation((int) $id);

        return back()->with('success', 'Reservation record deleted successfully!');
    }
}
