<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\RestaurantDataService;

class ContactController extends Controller
{
    protected RestaurantDataService $dataService;

    // Service inject karna
    public function __construct(RestaurantDataService $dataService)
    {
        $this->dataService = $dataService;
    }

    /**
     * Contact Messages Page - Sabhi visitor messages dekhna
     */
    public function index()
    {
        // Step 1: Saare contact messages lena
        $contacts = $this->dataService->getContacts();

        // Step 2: Blade view me bhejna
        return view('admin.contact', compact('contacts'));
    }

    /**
     * Message ko Read mark karna
     */
    public function markRead($id)
    {
        // ID ke basis par message ko 'read' mark karna
        $this->dataService->markContactRead((int) $id);

        return back()->with('success', 'Message marked as read.');
    }

    /**
     * Message ko Delete karna
     */
    public function destroy($id)
    {
        // ID ke basis par contact message delete karna
        $this->dataService->deleteContact((int) $id);

        return back()->with('success', 'Contact message delete ho gaya!');
    }
}
