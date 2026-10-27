<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\RestaurantDataService;

class ContactController extends Controller
{
    protected RestaurantDataService $dataService;

    public function __construct(RestaurantDataService $dataService)
    {
        $this->dataService = $dataService;
    }

    /**
     * Display all visitor contact inquiries.
     */
    public function index()
    {
        // Step 1: Retrieve all contact submissions
        $contacts = $this->dataService->getContacts();

        // Step 2: Render admin contact inquiries view
        return view('admin.contact', compact('contacts'));
    }

    /**
     * Mark an inquiry message as read.
     */
    public function markRead($id)
    {
        $this->dataService->markContactRead((int) $id);

        return back()->with('success', 'Message marked as read.');
    }

    /**
     * Remove an inquiry message by ID.
     */
    public function destroy($id)
    {
        $this->dataService->deleteContact((int) $id);

        return back()->with('success', 'Contact message removed successfully!');
    }
}
