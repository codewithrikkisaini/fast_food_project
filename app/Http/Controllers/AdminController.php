<?php

namespace App\Http\Controllers;

use App\Services\RestaurantDataService;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    protected RestaurantDataService $dataService;

    public function __construct(RestaurantDataService $dataService)
    {
        $this->dataService = $dataService;
    }

    /**
     * Foodie Admin Dashboard
     */
    public function dashboard()
    {
        $stats = $this->dataService->getStats();
        $recentReservations = array_slice($this->dataService->getReservations(), 0, 6);
        $recentContacts = array_slice($this->dataService->getContacts(), 0, 5);
        $menuItems = $this->dataService->getMenuItems();

        return view('admin.dashboard', compact('stats', 'recentReservations', 'recentContacts', 'menuItems'));
    }

    /**
     * Home Section Settings
     */
    public function home()
    {
        $home = $this->dataService->getHomeSettings();
        return view('admin.home', compact('home'));
    }

    /**
     * Update Home Section Settings
     */
    public function updateHome(Request $request)
    {
        $data = $request->validate([
            'hero_badge' => 'required|string|max:150',
            'hero_title' => 'required|string|max:200',
            'hero_highlight' => 'nullable|string|max:100',
            'hero_desc' => 'required|string|max:500',
            'hero_image' => 'nullable|string|max:255',
            'deal_image' => 'nullable|string|max:255',
            'hero_image_file' => 'nullable|image|mimes:jpeg,png,jpg,webp,gif|max:5120',
            'deal_image_file' => 'nullable|image|mimes:jpeg,png,jpg,webp,gif|max:5120',
            'announcement' => 'nullable|string|max:150',
            'phone' => 'nullable|string|max:50',
            'email' => 'nullable|string|max:100',
            'address' => 'nullable|string|max:150',
            'happy_customers' => 'nullable|string|max:50',
            'menu_count' => 'nullable|string|max:50',
            'chefs_count' => 'nullable|string|max:50',
            'experience_years' => 'nullable|string|max:50',
            'deal_title' => 'nullable|string|max:150',
            'deal_desc' => 'nullable|string|max:400',
            'deal_price' => 'nullable|string|max:50',
            'hero_badge_icon' => 'nullable|string|max:100',
            'hero_btn1_text' => 'nullable|string|max:100',
            'hero_btn1_url' => 'nullable|string|max:255',
            'hero_btn2_text' => 'nullable|string|max:100',
            'hero_btn2_url' => 'nullable|string|max:255',
            'happy_customers_label' => 'nullable|string|max:100',
            'menu_count_label' => 'nullable|string|max:100',
            'chefs_count_label' => 'nullable|string|max:100',
            'experience_years_label' => 'nullable|string|max:100',
            'card1_title' => 'nullable|string|max:100',
            'card1_subtitle' => 'nullable|string|max:100',
            'card1_icon' => 'nullable|string|max:100',
            'card2_title' => 'nullable|string|max:100',
            'card2_subtitle' => 'nullable|string|max:100',
            'card2_icon' => 'nullable|string|max:100',
            'card3_title' => 'nullable|string|max:100',
            'card3_subtitle' => 'nullable|string|max:100',
            'card3_icon' => 'nullable|string|max:100',
        ]);

        // Process Hero Image Upload
        if ($request->hasFile('hero_image_file')) {
            $uploadDir = public_path('img/uploads');
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0755, true);
            }
            $file = $request->file('hero_image_file');
            $fileName = 'hero_' . time() . '.' . $file->getClientOriginalExtension();
            $file->move($uploadDir, $fileName);
            $data['hero_image'] = 'img/uploads/' . $fileName;
        }

        // Process Deal Image Upload
        if ($request->hasFile('deal_image_file')) {
            $uploadDir = public_path('img/uploads');
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0755, true);
            }
            $file = $request->file('deal_image_file');
            $fileName = 'deal_' . time() . '.' . $file->getClientOriginalExtension();
            $file->move($uploadDir, $fileName);
            $data['deal_image'] = 'img/uploads/' . $fileName;
        }

        unset($data['hero_image_file'], $data['deal_image_file']);

        $this->dataService->updateHomeSettings($data);

        return back()->with('success', 'Home section heading, images, and content updated successfully!');
    }

    /**
     * About Section Settings
     */
    public function about()
    {
        $about = $this->dataService->getAboutSettings();
        return view('admin.about', compact('about'));
    }

    /**
     * Update About Section Settings
     */
    public function updateAbout(Request $request)
    {
        $data = $request->validate([
            'tagline' => 'required|string|max:100',
            'title' => 'required|string|max:200',
            'desc' => 'required|string|max:1500',
            'years_badge' => 'nullable|string|max:50',
            'years_badge_text' => 'nullable|string|max:100',
            'image1' => 'nullable|string|max:255',
            'image2' => 'nullable|string|max:255',
            'image1_file' => 'nullable|image|mimes:jpeg,png,jpg,webp,gif|max:5120',
            'image2_file' => 'nullable|image|mimes:jpeg,png,jpg,webp,gif|max:5120',
            'btn1_text' => 'nullable|string|max:100',
            'btn1_url' => 'nullable|string|max:255',
            'btn2_text' => 'nullable|string|max:100',
            'btn2_url' => 'nullable|string|max:255',
            'points' => 'nullable|array',
            'points.*.title' => 'nullable|string|max:150',
            'points.*.desc' => 'nullable|string|max:500',
            'points.*.icon' => 'nullable|string|max:100',
            'points.*.color' => 'nullable|string|max:50',
        ]);

        // Process Main About Image Upload
        if ($request->hasFile('image1_file')) {
            $uploadDir = public_path('img/uploads');
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0755, true);
            }
            $file = $request->file('image1_file');
            $fileName = 'about1_' . time() . '.' . $file->getClientOriginalExtension();
            $file->move($uploadDir, $fileName);
            $data['image1'] = 'img/uploads/' . $fileName;
        }

        // Process Secondary Floating Image Upload
        if ($request->hasFile('image2_file')) {
            $uploadDir = public_path('img/uploads');
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0755, true);
            }
            $file = $request->file('image2_file');
            $fileName = 'about2_' . time() . '.' . $file->getClientOriginalExtension();
            $file->move($uploadDir, $fileName);
            $data['image2'] = 'img/uploads/' . $fileName;
        }

        unset($data['image1_file'], $data['image2_file']);

        // Process & Sanitize Quality Pillars / Feature Highlights
        if (isset($data['points']) && is_array($data['points'])) {
            $cleanedPoints = [];
            foreach ($data['points'] as $pt) {
                $t = trim($pt['title'] ?? '');
                $d = trim($pt['desc'] ?? '');
                if ($t !== '' || $d !== '') {
                    $cleanedPoints[] = [
                        'title' => $t,
                        'desc' => $d,
                        'icon' => !empty(trim($pt['icon'] ?? '')) ? trim($pt['icon']) : 'fas fa-check-circle',
                        'color' => !empty(trim($pt['color'] ?? '')) ? trim($pt['color']) : 'r',
                    ];
                }
            }
            $data['points'] = $cleanedPoints;
        }

        $this->dataService->updateAboutSettings($data);

        return back()->with('success', 'About page content and quality features updated successfully!');
    }

    /**
     * Menu Management
     */
    public function menu()
    {
        $menuItems = $this->dataService->getMenuItems();
        return view('admin.menu', compact('menuItems'));
    }

    /**
     * Store or Update Menu Item
     */
    public function storeMenuItem(Request $request)
    {
        $data = $request->validate([
            'id' => 'nullable|integer',
            'title' => 'required|string|max:150',
            'category' => 'required|string|max:50',
            'category_name' => 'nullable|string|max:50',
            'price' => 'required|numeric|min:0',
            'old_price' => 'nullable|numeric|min:0',
            'cal' => 'nullable|integer',
            'time' => 'nullable|integer',
            'badge' => 'nullable|string|max:50',
            'badge_class' => 'nullable|string|max:50',
            'desc' => 'required|string|max:1000',
            'tags' => 'nullable|string|max:200',
            'image' => 'nullable|string|max:255',
            'image_file' => 'nullable|image|mimes:jpeg,png,jpg,webp,gif|max:5120'
        ]);

        $categoryNames = [
            'burgers' => 'Burgers',
            'pizza' => 'Pizza',
            'chicken' => 'Chicken',
            'wraps' => 'Wraps',
            'desserts' => 'Desserts',
            'pasta' => 'Pasta',
            'drinks' => 'Drinks',
            'salads' => 'Salads'
        ];
        if (empty($data['category_name'])) {
            $data['category_name'] = $categoryNames[$data['category']] ?? ucfirst($data['category']);
        }

        // Handle Image Upload
        if ($request->hasFile('image_file')) {
            $uploadDir = public_path('img/uploads');
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0755, true);
            }
            $file = $request->file('image_file');
            $fileName = 'menu_' . time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $file->move($uploadDir, $fileName);
            $data['image'] = 'img/uploads/' . $fileName;
        }
        unset($data['image_file']);

        if (empty($data['image'])) {
            $catImages = [
                'burgers' => 'img/menu/1.jpg',
                'pizza' => 'img/menu/2.jpg',
                'chicken' => 'img/menu/3.jpg',
                'wraps' => 'img/menu/4.jpg',
                'desserts' => 'img/menu/5.jpg',
                'pasta' => 'img/menu/6.jpg',
                'drinks' => 'img/menu/1.jpg',
                'salads' => 'img/menu/2.jpg'
            ];
            $data['image'] = $catImages[$data['category']] ?? 'img/menu/1.jpg';
        }

        // Format tags
        if (!empty($data['tags']) && is_string($data['tags'])) {
            $data['tags'] = array_values(array_filter(array_map('trim', explode(',', $data['tags']))));
        }

        // Format badge class
        if (!empty($data['badge']) && empty($data['badge_class'])) {
            $bLower = strtolower($data['badge']);
            if (str_contains($bLower, 'new')) {
                $data['badge_class'] = 'new';
            } else {
                $data['badge_class'] = 'hot';
            }
        }

        $this->dataService->saveMenuItem($data);

        return back()->with('success', 'Menu item saved successfully!');
    }

    /**
     * Delete Menu Item
     */
    public function deleteMenuItem($id)
    {
        $this->dataService->deleteMenuItem((int) $id);
        return back()->with('success', 'Menu item removed successfully!');
    }

    /**
     * Chefs Management
     */
    public function chefs()
    {
        $chefs = $this->dataService->getChefs();
        return view('admin.chefs', compact('chefs'));
    }

    /**
     * Store or Update Chef
     */
    public function storeChef(Request $request)
    {
        $data = $request->validate([
            'id' => 'nullable|integer',
            'name' => 'required|string|max:100',
            'role' => 'required|string|max:100',
            'exp' => 'required|string|max:100',
            'bio' => 'nullable|string|max:500',
            'image' => 'nullable|string|max:255',
            'image_file' => 'nullable|image|mimes:jpeg,png,jpg,webp,gif|max:5120',
            'instagram' => 'nullable|string|max:255',
            'facebook' => 'nullable|string|max:255',
            'twitter' => 'nullable|string|max:255'
        ]);

        // Handle Chef Photo Upload
        if ($request->hasFile('image_file')) {
            $uploadDir = public_path('img/uploads');
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0755, true);
            }
            $file = $request->file('image_file');
            $fileName = 'chef_' . time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $file->move($uploadDir, $fileName);
            $data['image'] = 'img/uploads/' . $fileName;
        }
        unset($data['image_file']);

        if (empty($data['image'])) {
            $data['image'] = 'img/chefs/1.jpg';
        }

        $this->dataService->saveChef($data);

        return back()->with('success', 'Chef profile saved successfully!');
    }

    /**
     * Delete Chef
     */
    public function deleteChef($id)
    {
        $this->dataService->deleteChef((int) $id);
        return back()->with('success', 'Chef profile removed successfully!');
    }

    /**
     * Table Reservations Management
     */
    public function reservations()
    {
        $reservations = $this->dataService->getReservations();
        return view('admin.reservations', compact('reservations'));
    }

    /**
     * Update Reservation Status
     */
    public function updateReservationStatus(Request $request, $id)
    {
        $status = $request->input('status', 'Confirmed');
        $this->dataService->updateReservationStatus((int) $id, $status);

        return back()->with('success', "Reservation #{$id} marked as {$status}!");
    }

    /**
     * Delete Reservation
     */
    public function deleteReservation($id)
    {
        $this->dataService->deleteReservation((int) $id);
        return back()->with('success', 'Reservation record deleted successfully!');
    }

    /**
     * Customer Reviews Management
     */
    public function reviews()
    {
        $reviews = $this->dataService->getReviews();
        return view('admin.reviews', compact('reviews'));
    }

    /**
     * Update Review Status
     */
    public function updateReviewStatus(Request $request, $id)
    {
        $status = $request->input('status', 'Approved');
        $this->dataService->updateReviewStatus((int) $id, $status);

        return back()->with('success', "Review #{$id} status updated to {$status}!");
    }

    /**
     * Delete Review
     */
    public function deleteReview($id)
    {
        $this->dataService->deleteReview((int) $id);
        return back()->with('success', 'Customer review deleted successfully!');
    }

    /**
     * Contact Messages Management
     */
    public function contact()
    {
        $contacts = $this->dataService->getContacts();
        return view('admin.contact', compact('contacts'));
    }

    /**
     * Mark Contact Message as Read
     */
    public function markContactRead($id)
    {
        $this->dataService->markContactRead((int) $id);
        return back()->with('success', 'Message marked as read.');
    }

    /**
     * Delete Contact Message
     */
    public function deleteContact($id)
    {
        $this->dataService->deleteContact((int) $id);
        return back()->with('success', 'Contact message removed successfully!');
    }

    /**
     * Gallery Showcase Management
     */
    public function gallery()
    {
        $galleryItems = $this->dataService->getGalleryItems();
        return view('admin.gallery', compact('galleryItems'));
    }

    /**
     * Store or Update Gallery Item
     */
    public function storeGalleryItem(Request $request)
    {
        $data = $request->validate([
            'id' => 'nullable|integer',
            'title' => 'required|string|max:150',
            'category' => 'nullable|string|max:100',
            'desc' => 'required|string|max:500',
            'image' => 'nullable|string|max:255',
            'image_file' => 'nullable|image|mimes:jpeg,png,jpg,webp,gif|max:5120'
        ]);

        if ($request->hasFile('image_file')) {
            $uploadDir = public_path('img/uploads');
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0755, true);
            }
            $file = $request->file('image_file');
            $fileName = 'gallery_' . time() . '.' . $file->getClientOriginalExtension();
            $file->move($uploadDir, $fileName);
            $data['image'] = 'img/uploads/' . $fileName;
        }

        if (empty($data['image'])) {
            $data['image'] = 'img/portfolio/work1.jpg';
        }

        unset($data['image_file']);

        $this->dataService->saveGalleryItem($data);

        return back()->with('success', 'Gallery item saved successfully!');
    }

    /**
     * Delete Gallery Item
     */
    public function deleteGalleryItem($id)
    {
        $this->dataService->deleteGalleryItem((int) $id);
        return back()->with('success', 'Gallery item deleted successfully!');
    }
}
