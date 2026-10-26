<?php

namespace App\Services;

use App\Models\Contact;
use App\Models\Reservation;
use App\Models\Review;
use App\Models\SiteSetting;
use Illuminate\Support\Facades\Schema;

class RestaurantDataService
{
    protected string $filePath;

    public function __construct()
    {
        $this->filePath = storage_path('app/restaurant_data.json');
        $this->ensureDataFileExists();
    }

    /**
     * Ensure storage data file exists with default seed data
     */
    protected function ensureDataFileExists(): void
    {
        $dir = dirname($this->filePath);
        if (!is_dir($dir)) {
            mkdir($dir, 0755, true);
        }

        if (!file_exists($this->filePath)) {
            $defaultData = $this->getDefaultData();
            file_put_contents($this->filePath, json_encode($defaultData, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES));
        }
    }

    /**
     * Read all data from JSON store
     */
    public function getAllData(): array
    {
        $this->ensureDataFileExists();
        $content = file_get_contents($this->filePath);
        $data = json_decode($content, true);
        return is_array($data) ? $data : $this->getDefaultData();
    }

    /**
     * Save all data to JSON store
     */
    public function saveAllData(array $data): void
    {
        file_put_contents($this->filePath, json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES));
    }

    // ----------------------------------------------------
    // HOME & SITE SETTINGS
    // ----------------------------------------------------
    public function getHomeSettings(): array
    {
        $data = $this->getAllData();
        $home = $data['home'] ?? [];
        if (empty($home['hero_image'])) {
            $home['hero_image'] = 'img/banner-img.jpg';
        }
        if (empty($home['deal_image'])) {
            $home['deal_image'] = 'img/off-img.jpg';
        }
        if (!isset($home['hero_highlight'])) {
            $home['hero_highlight'] = 'Fast Food';
        }

        // Hero Badge & Buttons
        $home['hero_badge_icon'] = $home['hero_badge_icon'] ?? 'fas fa-star';
        $home['hero_btn1_text'] = $home['hero_btn1_text'] ?? 'Explore Menu';
        $home['hero_btn1_url'] = $home['hero_btn1_url'] ?? '';
        $home['hero_btn2_text'] = $home['hero_btn2_text'] ?? 'Watch Our Story';
        $home['hero_btn2_url'] = $home['hero_btn2_url'] ?? 'https://www.youtube.com/watch?v=RXv_uIN6e-Y';

        // Stats Labels
        $home['happy_customers_label'] = $home['happy_customers_label'] ?? 'Happy Customers';
        $home['menu_count_label'] = $home['menu_count_label'] ?? 'Menu Items';
        $home['chefs_count_label'] = $home['chefs_count_label'] ?? 'Expert Chefs';
        $home['experience_years_label'] = $home['experience_years_label'] ?? 'Experience';

        // Hero Floating Cards (Badges around hero image)
        $home['card1_title'] = $home['card1_title'] ?? 'Hot Deal';
        $home['card1_subtitle'] = $home['card1_subtitle'] ?? '30% off today';
        $home['card1_icon'] = $home['card1_icon'] ?? 'fas fa-fire';

        $home['card2_title'] = $home['card2_title'] ?? '20 min';
        $home['card2_subtitle'] = $home['card2_subtitle'] ?? 'Fast delivery';
        $home['card2_icon'] = $home['card2_icon'] ?? 'fas fa-clock';

        $home['card3_title'] = $home['card3_title'] ?? '4.9/5';
        $home['card3_subtitle'] = $home['card3_subtitle'] ?? '2k+ reviews';
        $home['card3_icon'] = $home['card3_icon'] ?? 'fas fa-star';

        return $home;
    }

    public function updateHomeSettings(array $settings): void
    {
        $data = $this->getAllData();
        $data['home'] = array_merge($data['home'] ?? [], $settings);
        $this->saveAllData($data);
    }

    // ----------------------------------------------------
    // ABOUT SETTINGS
    // ----------------------------------------------------
    public function getAboutSettings(): array
    {
        $data = $this->getAllData();
        $about = $data['about'] ?? [];

        $defaultPoints = [
            [
                'icon' => 'fas fa-leaf',
                'color' => 'r',
                'title' => '100% Fresh Farm Ingredients',
                'desc' => 'We source locally and sustainably. Every ingredient is hand-picked daily for maximum freshness and flavor integrity.',
            ],
            [
                'icon' => 'fas fa-award',
                'color' => 'y',
                'title' => 'Award-Winning Master Chefs',
                'desc' => 'Our kitchen is led by executive chefs whose signature recipes have earned national culinary recognition.',
            ],
            [
                'icon' => 'fas fa-shipping-fast',
                'color' => 'g',
                'title' => 'Fast & Eco-Conscious Delivery',
                'desc' => 'Order online and enjoy piping hot, fresh comfort food delivered straight to your doorstep in under 35 minutes.',
            ],
        ];

        if (!isset($about['points']) || !is_array($about['points']) || empty($about['points'])) {
            $about['points'] = $defaultPoints;
        } else {
            foreach ($about['points'] as $i => &$pt) {
                $pt['icon'] = $pt['icon'] ?? ($defaultPoints[$i]['icon'] ?? 'fas fa-check-circle');
                $pt['color'] = $pt['color'] ?? ($defaultPoints[$i]['color'] ?? 'r');
                $pt['title'] = $pt['title'] ?? ($defaultPoints[$i]['title'] ?? '');
                $pt['desc'] = $pt['desc'] ?? ($defaultPoints[$i]['desc'] ?? '');
            }
            unset($pt);
        }

        $about['tagline'] = $about['tagline'] ?? 'Our Heritage';
        $about['title'] = $about['title'] ?? "We Invite You to Visit\nOur Food Restaurant";
        $about['desc'] = $about['desc'] ?? "Founded in 2012, Fast Food began as a small corner joint with a big dream - to serve food that brings people together. Today we're proud to serve thousands of happy customers every week with the same passion that started it all.";
        $about['years_badge'] = $about['years_badge'] ?? '12+';
        $about['years_badge_text'] = $about['years_badge_text'] ?? "Years of\nExcellence";
        $about['image1'] = $about['image1'] ?? 'img/about1.jpg';
        $about['image2'] = $about['image2'] ?? 'img/about2.jpg';
        $about['btn1_text'] = $about['btn1_text'] ?? 'Explore Our Menu';
        $about['btn1_url'] = $about['btn1_url'] ?? '';
        $about['btn2_text'] = $about['btn2_text'] ?? 'Book a Table';
        $about['btn2_url'] = $about['btn2_url'] ?? '';

        return $about;
    }

    public function updateAboutSettings(array $settings): void
    {
        $data = $this->getAllData();
        $data['about'] = array_merge($data['about'] ?? [], $settings);
        $this->saveAllData($data);
    }

    protected ?array $cachedSiteSettings = null;

    // ----------------------------------------------------
    // GENERAL SITE SETTINGS (Address, Phone, Email, Hours, Social Links)
    // ----------------------------------------------------
    public function getSiteSettings(): array
    {
        if ($this->cachedSiteSettings !== null) {
            return $this->cachedSiteSettings;
        }

        $defaults = [
            'restaurant_name' => 'Fast Food',
            'phone' => '+1 (800) 123-4567',
            'email' => 'hello@fastfood.com',
            'address' => '42 Flavor Street, Manhattan, NY 10001',
            'hours' => 'Wed - Sun: 09 AM - 11 PM',
            'announcement' => 'Free Delivery Today on Orders Over $25!',
            'facebook' => 'https://facebook.com',
            'instagram' => 'https://instagram.com',
            'twitter' => 'https://twitter.com',
            'youtube' => 'https://youtube.com',
            'tiktok' => 'https://tiktok.com',
            'footer_desc' => "We bring the world's finest flavors together in a fast, friendly, and affordable experience. Every meal crafted with love."
        ];

        // 1. Try from database table
        try {
            if (Schema::hasTable('site_settings')) {
                $dbSetting = SiteSetting::first();
                if (!$dbSetting) {
                    $dbSetting = SiteSetting::create($defaults);
                }
                if ($dbSetting) {
                    $this->cachedSiteSettings = array_merge($defaults, array_filter($dbSetting->toArray(), fn($v) => !is_null($v)));
                    return $this->cachedSiteSettings;
                }
            }
        } catch (\Throwable $e) {
        }

        // 2. Fallback to JSON store
        $data = $this->getAllData();
        $stored = $data['settings'] ?? [];
        $this->cachedSiteSettings = array_merge($defaults, $stored);
        return $this->cachedSiteSettings;
    }

    public function updateSiteSettings(array $settings): void
    {
        $this->cachedSiteSettings = null;

        // 1. Save to Database
        try {
            if (Schema::hasTable('site_settings')) {
                $dbSetting = SiteSetting::first();
                if ($dbSetting) {
                    $dbSetting->update($settings);
                } else {
                    SiteSetting::create($settings);
                }
            }
        } catch (\Throwable $e) {
        }

        // 2. Save to JSON store
        $data = $this->getAllData();
        $data['settings'] = array_merge($data['settings'] ?? [], $settings);
        if (isset($settings['phone']))
            $data['home']['phone'] = $settings['phone'];
        if (isset($settings['email']))
            $data['home']['email'] = $settings['email'];
        if (isset($settings['address']))
            $data['home']['address'] = $settings['address'];
        if (isset($settings['announcement']))
            $data['home']['announcement'] = $settings['announcement'];
        $this->saveAllData($data);
    }

    // ----------------------------------------------------
    // MENU ITEMS
    // ----------------------------------------------------
    public function getMenuItems(): array
    {
        $data = $this->getAllData();
        return $data['menu_items'] ?? [];
    }

    public function getMenuItemById(int $id): ?array
    {
        $items = $this->getMenuItems();
        foreach ($items as $item) {
            if ((int) $item['id'] === $id) {
                return $item;
            }
        }
        return null;
    }

    public function saveMenuItem(array $itemData): array
    {
        $data = $this->getAllData();
        $items = $data['menu_items'] ?? [];

        if (is_string($itemData['tags'] ?? null)) {
            $itemData['tags'] = array_values(array_filter(array_map('trim', explode(',', $itemData['tags']))));
        }

        if (!empty($itemData['id'])) {
            $id = (int) $itemData['id'];
            foreach ($items as $idx => $existing) {
                if ((int) $existing['id'] === $id) {
                    $items[$idx] = array_merge($existing, $itemData);
                    $data['menu_items'] = array_values($items);
                    $this->saveAllData($data);
                    return $items[$idx];
                }
            }
        }

        // New item
        $maxId = 0;
        foreach ($items as $item) {
            if ((int) $item['id'] > $maxId) {
                $maxId = (int) $item['id'];
            }
        }
        $itemData['id'] = $maxId + 1;
        if (empty($itemData['rating']))
            $itemData['rating'] = 5.0;
        if (empty($itemData['reviews']))
            $itemData['reviews'] = 1;
        if (empty($itemData['image']))
            $itemData['image'] = 'img/menu/1.jpg';
        if (is_string($itemData['tags'] ?? null)) {
            $itemData['tags'] = array_map('trim', explode(',', $itemData['tags']));
        }

        $items[] = $itemData;
        $data['menu_items'] = array_values($items);
        $this->saveAllData($data);
        return $itemData;
    }

    public function deleteMenuItem(int $id): bool
    {
        $data = $this->getAllData();
        $items = $data['menu_items'] ?? [];
        $initialCount = count($items);
        $filtered = array_filter($items, fn($i) => (int) $i['id'] !== $id);

        if (count($filtered) !== $initialCount) {
            $data['menu_items'] = array_values($filtered);
            $this->saveAllData($data);
            return true;
        }
        return false;
    }

    // ----------------------------------------------------
    // CHEFS
    // ----------------------------------------------------
    public function getChefs(): array
    {
        $data = $this->getAllData();
        return $data['chefs'] ?? [];
    }

    public function saveChef(array $chefData): array
    {
        $data = $this->getAllData();
        $chefs = $data['chefs'] ?? [];

        if (!empty($chefData['id'])) {
            $id = (int) $chefData['id'];
            foreach ($chefs as $idx => $existing) {
                if ((int) ($existing['id'] ?? 0) === $id) {
                    $chefs[$idx] = array_merge($existing, $chefData);
                    $data['chefs'] = array_values($chefs);
                    $this->saveAllData($data);
                    return $chefs[$idx];
                }
            }
        }

        $maxId = 0;
        foreach ($chefs as $chef) {
            if ((int) ($chef['id'] ?? 0) > $maxId) {
                $maxId = (int) $chef['id'];
            }
        }
        $chefData['id'] = $maxId + 1;
        if (empty($chefData['image']))
            $chefData['image'] = 'img/chefs/1.jpg';

        $chefs[] = $chefData;
        $data['chefs'] = array_values($chefs);
        $this->saveAllData($data);
        return $chefData;
    }

    public function deleteChef(int $id): bool
    {
        $data = $this->getAllData();
        $chefs = $data['chefs'] ?? [];
        $filtered = array_filter($chefs, fn($c) => (int) ($c['id'] ?? 0) !== $id);

        $data['chefs'] = array_values($filtered);
        $this->saveAllData($data);
        return true;
    }

    // ----------------------------------------------------
    // GALLERY ITEMS
    // ----------------------------------------------------
    public function getGalleryItems(): array
    {
        $data = $this->getAllData();
        if (!isset($data['gallery_items'])) {
            $defaultItems = [
                [
                    'id' => 1,
                    'title' => 'Gourmet Smash Burgers',
                    'desc' => 'Double-smashed beef patties, melted aged cheddar, caramelized shallots, and house-made secret sauce on toasted brioche.',
                    'image' => 'img/portfolio/work1.jpg',
                    'category' => 'Gourmet Burgers'
                ],
                [
                    'id' => 2,
                    'title' => 'Wood-Fired Truffle Pizza',
                    'desc' => 'Hand-stretched 48-hour fermented sourdough fired at 900°F in our wood-burning stone oven.',
                    'image' => 'img/portfolio/work2.jpg',
                    'category' => 'Wood-Fired Pizza'
                ],
                [
                    'id' => 3,
                    'title' => 'Nashville Hot Crispy Chicken',
                    'desc' => 'Double-brined, buttermilk battered golden fried chicken tossed in fiery cayenne-infused spices.',
                    'image' => 'img/portfolio/work3.jpg',
                    'category' => 'Crispy Fried Chicken'
                ],
                [
                    'id' => 4,
                    'title' => 'Molten Nutella Lava Cake',
                    'desc' => 'Warm chocolate molten cake filled with decadent hazelnut cream, served with Madagascar vanilla ice cream.',
                    'image' => 'img/portfolio/work4.jpg',
                    'category' => 'Sweet Desserts'
                ],
                [
                    'id' => 5,
                    'title' => 'Loaded Fajita Wraps',
                    'desc' => 'Fresh grilled chicken breast, roasted bell peppers, fresh guacamole and house-made salsa verde.',
                    'image' => 'img/portfolio/work5.jpg',
                    'category' => 'Fresh Wraps & Rolls'
                ]
            ];
            $data['gallery_items'] = $defaultItems;
            $this->saveAllData($data);
            return $defaultItems;
        }
        return $data['gallery_items'];
    }

    public function saveGalleryItem(array $itemData): array
    {
        $data = $this->getAllData();
        $items = $this->getGalleryItems();

        if (!empty($itemData['id'])) {
            $id = (int) $itemData['id'];
            foreach ($items as &$item) {
                if ($item['id'] === $id) {
                    $item = array_merge($item, $itemData);
                    $data['gallery_items'] = array_values($items);
                    $this->saveAllData($data);
                    return $item;
                }
            }
        }

        $newId = empty($items) ? 1 : (max(array_column($items, 'id')) + 1);
        $itemData['id'] = $newId;
        $items[] = $itemData;
        $data['gallery_items'] = array_values($items);
        $this->saveAllData($data);

        return $itemData;
    }

    public function deleteGalleryItem(int $id): bool
    {
        $data = $this->getAllData();
        $items = $this->getGalleryItems();
        $filtered = array_filter($items, fn($item) => (int) $item['id'] !== $id);

        if (count($filtered) !== count($items)) {
            $data['gallery_items'] = array_values($filtered);
            $this->saveAllData($data);
            return true;
        }
        return false;
    }

    // ----------------------------------------------------
    // RESERVATIONS
    // ----------------------------------------------------
    // RESERVATIONS (Database & JSON Sync)
    // ----------------------------------------------------
    public function getReservations(): array
    {
        try {
            if (Schema::hasTable('reservations')) {
                if (Reservation::count() === 0) {
                    $data = $this->getAllData();
                    foreach (array_reverse($data['reservations'] ?? []) as $r) {
                        Reservation::create([
                            'name' => $r['name'] ?? '',
                            'phone' => $r['phone'] ?? '',
                            'email' => $r['email'] ?? '',
                            'guests' => $r['guests'] ?? '2 People',
                            'date' => $r['date'] ?? date('Y-m-d'),
                            'time' => $r['time'] ?? '07:00 PM',
                            'special_requests' => $r['special_requests'] ?? null,
                            'status' => $r['status'] ?? 'Pending',
                        ]);
                    }
                }
                $dbItems = Reservation::orderBy('id', 'desc')->get()->toArray();
                if (!empty($dbItems)) {
                    return $dbItems;
                }
            }
        } catch (\Throwable $e) {
        }

        $data = $this->getAllData();
        return $data['reservations'] ?? [];
    }

    public function addReservation(array $resData): array
    {
        $newReservation = [
            'name' => $resData['name'] ?? '',
            'phone' => $resData['phone'] ?? '',
            'email' => $resData['email'] ?? '',
            'guests' => $resData['guests'] ?? '2 People',
            'date' => $resData['date'] ?? date('Y-m-d'),
            'time' => $resData['time'] ?? '07:00 PM',
            'special_requests' => $resData['special_requests'] ?? ($resData['message'] ?? 'No special requests'),
            'status' => 'Pending',
            'created_at' => date('Y-m-d H:i:s')
        ];

        // 1. Save directly into Database table
        try {
            if (Schema::hasTable('reservations')) {
                $created = Reservation::create($newReservation);
                $newReservation['id'] = $created->id;
            }
        } catch (\Throwable $e) {
        }

        // 2. Synchronize with JSON store
        $data = $this->getAllData();
        $reservations = $data['reservations'] ?? [];
        if (empty($newReservation['id'])) {
            $maxId = 0;
            foreach ($reservations as $r) {
                if ((int) ($r['id'] ?? 0) > $maxId) {
                    $maxId = (int) $r['id'];
                }
            }
            $newReservation['id'] = $maxId + 1;
        }

        array_unshift($reservations, $newReservation);
        $data['reservations'] = $reservations;
        $this->saveAllData($data);

        return $newReservation;
    }

    public function updateReservationStatus(int $id, string $status): bool
    {
        try {
            if (Schema::hasTable('reservations')) {
                $item = Reservation::find($id);
                if ($item) {
                    $item->update(['status' => $status]);
                }
            }
        } catch (\Throwable $e) {
        }

        $data = $this->getAllData();
        $reservations = $data['reservations'] ?? [];

        foreach ($reservations as $idx => $r) {
            if ((int) $r['id'] === $id) {
                $reservations[$idx]['status'] = $status;
                $data['reservations'] = $reservations;
                $this->saveAllData($data);
                return true;
            }
        }
        return false;
    }

    public function deleteReservation(int $id): bool
    {
        try {
            if (Schema::hasTable('reservations')) {
                Reservation::where('id', $id)->delete();
            }
        } catch (\Throwable $e) {
        }

        $data = $this->getAllData();
        $reservations = $data['reservations'] ?? [];
        $filtered = array_filter($reservations, fn($r) => (int) $r['id'] !== $id);

        $data['reservations'] = array_values($filtered);
        $this->saveAllData($data);
        return true;
    }

    // ----------------------------------------------------
    // REVIEWS (Database & JSON Sync)
    // ----------------------------------------------------
    public function getReviews(): array
    {
        try {
            if (Schema::hasTable('reviews')) {
                return Review::orderBy('id', 'desc')->get()->toArray();
            }
        } catch (\Throwable $e) {
        }

        $data = $this->getAllData();
        return $data['reviews'] ?? [];
    }

    public function addReview(array $revData): array
    {
        $newReview = [
            'name' => $revData['name'] ?? 'Guest Customer',
            'role' => $revData['role'] ?? 'Verified Diner',
            'rating' => (int) ($revData['rating'] ?? 5),
            'text' => $revData['text'] ?? ($revData['message'] ?? 'Delicious food and excellent service!'),
            'image' => $revData['image'] ?? ('img/testimonial/' . (rand(1, 4)) . '.jpg'),
            'status' => $revData['status'] ?? 'Approved',
            'created_at' => date('Y-m-d H:i:s')
        ];

        // 1. Save directly into Database table
        try {
            if (Schema::hasTable('reviews')) {
                $created = Review::create($newReview);
                $newReview['id'] = $created->id;
            }
        } catch (\Throwable $e) {
        }

        // 2. Synchronize with JSON store
        $data = $this->getAllData();
        $reviews = $data['reviews'] ?? [];
        if (empty($newReview['id'])) {
            $maxId = 0;
            foreach ($reviews as $r) {
                if ((int) ($r['id'] ?? 0) > $maxId) {
                    $maxId = (int) $r['id'];
                }
            }
            $newReview['id'] = $maxId + 1;
        }

        array_unshift($reviews, $newReview);
        $data['reviews'] = $reviews;
        $this->saveAllData($data);

        return $newReview;
    }

    public function getReviewSettings(): array
    {
        $data = $this->getAllData();
        $settings = $data['review_settings'] ?? [];

        return [
            'overall_rating' => $settings['overall_rating'] ?? '4.9',
            'rating_subtitle' => $settings['rating_subtitle'] ?? 'Overall Diner Rating (850+ Reviews)',
            'metric1_label' => $settings['metric1_label'] ?? 'Food Quality & Freshness',
            'metric1_percent' => (int) ($settings['metric1_percent'] ?? 98),
            'metric2_label' => $settings['metric2_label'] ?? 'Delivery Speed (< 25 mins)',
            'metric2_percent' => (int) ($settings['metric2_percent'] ?? 95),
            'metric3_label' => $settings['metric3_label'] ?? 'Friendly Customer Care',
            'metric3_percent' => (int) ($settings['metric3_percent'] ?? 99),
        ];
    }

    public function updateReviewSettings(array $settings): void
    {
        $data = $this->getAllData();
        $current = $data['review_settings'] ?? [];
        $data['review_settings'] = array_merge($current, $settings);
        $this->saveAllData($data);
    }

    public function updateReview(int $id, array $revData): bool
    {
        try {
            if (Schema::hasTable('reviews')) {
                $item = Review::find($id);
                if ($item) {
                    $item->update([
                        'name' => $revData['name'] ?? $item->name,
                        'role' => $revData['role'] ?? $item->role,
                        'rating' => isset($revData['rating']) ? (int) $revData['rating'] : $item->rating,
                        'text' => $revData['text'] ?? ($revData['message'] ?? $item->text),
                        'image' => $revData['image'] ?? $item->image,
                        'status' => $revData['status'] ?? $item->status,
                    ]);
                }
            }
        } catch (\Throwable $e) {
        }

        $data = $this->getAllData();
        $reviews = $data['reviews'] ?? [];
        foreach ($reviews as $idx => $r) {
            if ((int) $r['id'] === $id) {
                $reviews[$idx] = array_merge($r, array_filter([
                    'name' => $revData['name'] ?? null,
                    'role' => $revData['role'] ?? null,
                    'rating' => isset($revData['rating']) ? (int) $revData['rating'] : null,
                    'text' => $revData['text'] ?? ($revData['message'] ?? null),
                    'image' => $revData['image'] ?? null,
                    'status' => $revData['status'] ?? null,
                ], fn($val) => !is_null($val)));
                $data['reviews'] = $reviews;
                $this->saveAllData($data);
                return true;
            }
        }
        return false;
    }

    public function updateReviewStatus(int $id, string $status): bool
    {
        try {
            if (Schema::hasTable('reviews')) {
                $item = Review::find($id);
                if ($item) {
                    $item->update(['status' => $status]);
                }
            }
        } catch (\Throwable $e) {
        }

        $data = $this->getAllData();
        $reviews = $data['reviews'] ?? [];

        foreach ($reviews as $idx => $r) {
            if ((int) $r['id'] === $id) {
                $reviews[$idx]['status'] = $status;
                $data['reviews'] = $reviews;
                $this->saveAllData($data);
                return true;
            }
        }
        return false;
    }

    public function deleteReview(int $id): bool
    {
        try {
            if (Schema::hasTable('reviews')) {
                Review::where('id', $id)->delete();
            }
        } catch (\Throwable $e) {
        }

        $data = $this->getAllData();
        $reviews = $data['reviews'] ?? [];
        $filtered = array_filter($reviews, fn($r) => (int) $r['id'] !== $id);

        $data['reviews'] = array_values($filtered);
        $this->saveAllData($data);
        return true;
    }

    public function deleteAllReviews(): bool
    {
        try {
            if (Schema::hasTable('reviews')) {
                Review::truncate();
            }
        } catch (\Throwable $e) {
            try {
                Review::query()->delete();
            } catch (\Throwable $ex) {
            }
        }

        $data = $this->getAllData();
        $data['reviews'] = [];
        $this->saveAllData($data);
        return true;
    }

    // ----------------------------------------------------
    // CONTACT INQUIRIES (Database & JSON Sync)
    // ----------------------------------------------------
    public function getContacts(): array
    {
        try {
            if (Schema::hasTable('contacts')) {
                if (Contact::count() === 0) {
                    $data = $this->getAllData();
                    foreach (array_reverse($data['contacts'] ?? []) as $c) {
                        Contact::create([
                            'name' => $c['name'] ?? '',
                            'email' => $c['email'] ?? '',
                            'phone' => $c['phone'] ?? '',
                            'subject' => $c['subject'] ?? 'General Inquiry',
                            'message' => $c['message'] ?? '',
                            'is_read' => !empty($c['is_read']),
                        ]);
                    }
                }
                $dbItems = Contact::orderBy('id', 'desc')->get()->toArray();
                if (!empty($dbItems)) {
                    return $dbItems;
                }
            }
        } catch (\Throwable $e) {
        }

        $data = $this->getAllData();
        return $data['contacts'] ?? [];
    }

    public function addContact(array $contactData): array
    {
        $newContact = [
            'name' => $contactData['name'] ?? '',
            'email' => $contactData['email'] ?? '',
            'phone' => $contactData['phone'] ?? '',
            'subject' => $contactData['subject'] ?? 'General Inquiry',
            'message' => $contactData['message'] ?? '',
            'is_read' => false,
            'created_at' => date('Y-m-d H:i:s')
        ];

        // 1. Save directly into Database table
        try {
            if (Schema::hasTable('contacts')) {
                $created = Contact::create($newContact);
                $newContact['id'] = $created->id;
            }
        } catch (\Throwable $e) {
        }

        // 2. Synchronize with JSON store
        $data = $this->getAllData();
        $contacts = $data['contacts'] ?? [];
        if (empty($newContact['id'])) {
            $maxId = 0;
            foreach ($contacts as $c) {
                if ((int) ($c['id'] ?? 0) > $maxId) {
                    $maxId = (int) $c['id'];
                }
            }
            $newContact['id'] = $maxId + 1;
        }

        array_unshift($contacts, $newContact);
        $data['contacts'] = $contacts;
        $this->saveAllData($data);

        return $newContact;
    }

    public function markContactRead(int $id): bool
    {
        try {
            if (Schema::hasTable('contacts')) {
                $item = Contact::find($id);
                if ($item) {
                    $item->update(['is_read' => true]);
                }
            }
        } catch (\Throwable $e) {
        }

        $data = $this->getAllData();
        $contacts = $data['contacts'] ?? [];

        foreach ($contacts as $idx => $c) {
            if ((int) $c['id'] === $id) {
                $contacts[$idx]['is_read'] = true;
                $data['contacts'] = $contacts;
                $this->saveAllData($data);
                return true;
            }
        }
        return false;
    }

    public function deleteContact(int $id): bool
    {
        try {
            if (Schema::hasTable('contacts')) {
                Contact::where('id', $id)->delete();
            }
        } catch (\Throwable $e) {
        }

        $data = $this->getAllData();
        $contacts = $data['contacts'] ?? [];
        $filtered = array_filter($contacts, fn($c) => (int) $c['id'] !== $id);

        $data['contacts'] = array_values($filtered);
        $this->saveAllData($data);
        return true;
    }

    // ----------------------------------------------------
    // BLOG POSTS
    // ----------------------------------------------------
    public function getBlogPosts(): array
    {
        $data = $this->getAllData();
        return $data['blogs'] ?? [];
    }

    public function getBlogPost(int $id): ?array
    {
        $blogs = $this->getBlogPosts();
        foreach ($blogs as $blog) {
            if ((int) ($blog['id'] ?? 0) === $id) {
                return $blog;
            }
        }
        return null;
    }

    public function addBlogPost(array $blogData): array
    {
        $data = $this->getAllData();
        $blogs = $data['blogs'] ?? [];

        $maxId = 0;
        foreach ($blogs as $b) {
            if ((int) ($b['id'] ?? 0) > $maxId) {
                $maxId = (int) $b['id'];
            }
        }

        $newBlog = [
            'id' => $maxId + 1,
            'title' => $blogData['title'] ?? 'New Article',
            'category' => $blogData['category'] ?? 'Culinary Science',
            'author' => $blogData['author'] ?? 'Executive Chef',
            'comments' => (int) ($blogData['comments'] ?? rand(10, 30)),
            'day' => $blogData['day'] ?? date('d'),
            'month' => $blogData['month'] ?? date('M'),
            'image' => $blogData['image'] ?? 'img/blog/1.jpg',
            'excerpt' => $blogData['excerpt'] ?? '',
            'content' => $blogData['content'] ?? '',
        ];

        array_unshift($blogs, $newBlog);
        $data['blogs'] = $blogs;
        $this->saveAllData($data);

        return $newBlog;
    }

    public function updateBlogPost(int $id, array $blogData): bool
    {
        $data = $this->getAllData();
        $blogs = $data['blogs'] ?? [];

        foreach ($blogs as $idx => $b) {
            if ((int) ($b['id'] ?? 0) === $id) {
                $blogs[$idx] = array_merge($b, array_filter([
                    'title' => $blogData['title'] ?? null,
                    'category' => $blogData['category'] ?? null,
                    'author' => $blogData['author'] ?? null,
                    'comments' => isset($blogData['comments']) ? (int) $blogData['comments'] : null,
                    'day' => $blogData['day'] ?? null,
                    'month' => $blogData['month'] ?? null,
                    'image' => $blogData['image'] ?? null,
                    'excerpt' => $blogData['excerpt'] ?? null,
                    'content' => $blogData['content'] ?? null,
                ], fn($val) => !is_null($val)));

                $data['blogs'] = $blogs;
                $this->saveAllData($data);
                return true;
            }
        }

        return false;
    }

    public function deleteBlogPost(int $id): bool
    {
        $data = $this->getAllData();
        $blogs = $data['blogs'] ?? [];
        $filtered = array_filter($blogs, fn($b) => (int) ($b['id'] ?? 0) !== $id);

        $data['blogs'] = array_values($filtered);
        $this->saveAllData($data);
        return true;
    }

    // ----------------------------------------------------
    // DASHBOARD STATS
    // ----------------------------------------------------
    public function getStats(): array
    {
        $menuItems = $this->getMenuItems();
        $reservations = $this->getReservations();
        $contacts = $this->getContacts();
        $reviews = $this->getReviews();
        $blogs = $this->getBlogPosts();

        $pendingReservations = count(array_filter($reservations, fn($r) => ($r['status'] ?? '') === 'Pending'));
        $confirmedReservations = count(array_filter($reservations, fn($r) => ($r['status'] ?? '') === 'Confirmed'));
        $unreadContacts = count(array_filter($contacts, fn($c) => empty($c['is_read'])));

        return [
            'total_menu_items' => count($menuItems),
            'total_reservations' => count($reservations),
            'pending_reservations' => $pendingReservations,
            'confirmed_reservations' => $confirmedReservations,
            'total_contacts' => count($contacts),
            'unread_contacts' => $unreadContacts,
            'total_reviews' => count($reviews),
            'total_chefs' => count($this->getChefs()),
            'total_blogs' => count($blogs),
            'estimated_revenue' => '$24,850'
        ];
    }

    /**
     * Default initial data
     */
    protected function getDefaultData(): array
    {
        return [
            'home' => [
                'hero_badge' => '#1 Rated Fast Food in New York',
                'hero_title' => 'Delicious Fast Food for Every Moment',
                'hero_highlight' => 'Fast Food',
                'hero_desc' => 'Experience bold flavors crafted from premium ingredients. From crispy smashed burgers to gourmet pizzas - every bite is an adventure worth savoring.',
                'hero_image' => 'img/banner-img.jpg',
                'deal_image' => 'img/off-img.jpg',
                'announcement' => 'Free Delivery Today on Orders Over $25!',
                'phone' => '+1 (800) 123-4567',
                'email' => 'hello@fastfood.com',
                'address' => '42 Flavor Street, NY',
                'happy_customers' => '850+',
                'menu_count' => '120+',
                'chefs_count' => '15+',
                'experience_years' => '12yr',
                'deal_title' => 'Get 30% Off Our Signature Burger Meal',
                'deal_desc' => 'Don\'t miss our weekend special - grab our award-winning signature burger combo with loaded fries and a premium shake at an unbeatable price.',
                'deal_price' => '$17.49',
                'deal_old_price' => '$24.99',
                'card1_title' => 'Hot Deal',
                'card1_subtitle' => '30% off today',
                'card1_icon' => 'fas fa-fire',
                'card2_title' => '20 min',
                'card2_subtitle' => 'Fast delivery',
                'card2_icon' => 'fas fa-clock',
                'card3_title' => '4.9/5',
                'card3_subtitle' => '2k+ reviews',
                'card3_icon' => 'fas fa-star'
            ],
            'about' => [
                'tagline' => 'Our Story & Heritage',
                'title' => 'We Invite You to Visit Our Food Restaurant',
                'desc' => 'Founded in 2012, Fast Food began as a small corner joint with a big dream - to serve food that brings people together. Today we\'re proud to serve thousands of happy customers every week with the same passion that started it all.',
                'years_badge' => '12+',
                'years_badge_text' => "Years of\nExcellence",
                'image1' => 'img/about1.jpg',
                'image2' => 'img/about2.jpg',
                'btn1_text' => 'Explore Our Menu',
                'btn1_url' => '',
                'btn2_text' => 'Book a Table',
                'btn2_url' => '',
                'points' => [
                    [
                        'icon' => 'fas fa-leaf',
                        'color' => 'r',
                        'title' => '100% Fresh Farm Ingredients',
                        'desc' => 'We source locally and sustainably. Every ingredient is hand-picked daily for maximum freshness and flavor integrity.',
                    ],
                    [
                        'icon' => 'fas fa-award',
                        'color' => 'y',
                        'title' => 'Award-Winning Master Chefs',
                        'desc' => 'Our kitchen is led by executive chefs whose signature recipes have earned national culinary recognition.',
                    ],
                    [
                        'icon' => 'fas fa-shipping-fast',
                        'color' => 'g',
                        'title' => 'Fast & Eco-Conscious Delivery',
                        'desc' => 'Order online and enjoy piping hot, fresh comfort food delivered straight to your doorstep in under 35 minutes.',
                    ],
                ],
            ],
            'menu_items' => [
                [
                    'id' => 1,
                    'title' => 'Classic Smash Burger',
                    'category' => 'burgers',
                    'category_name' => 'Burgers',
                    'price' => 14.99,
                    'old_price' => 18.99,
                    'rating' => 4.9,
                    'reviews' => 128,
                    'cal' => 620,
                    'time' => 12,
                    'image' => 'img/menu/1.jpg',
                    'badge' => 'Hot',
                    'badge_class' => 'hot',
                    'desc' => 'Double smashed patty, cheddar cheese, caramelized onions, house pickles and our legendary special sauce. Made fresh to order on a toasted brioche bun.',
                    'tags' => ['Spicy', 'Bestseller', 'Beef']
                ],
                [
                    'id' => 2,
                    'title' => 'Margherita Royale Pizza',
                    'category' => 'pizza',
                    'category_name' => 'Pizza',
                    'price' => 19.99,
                    'old_price' => 24.99,
                    'rating' => 4.8,
                    'reviews' => 95,
                    'cal' => 480,
                    'time' => 18,
                    'image' => 'img/menu/2.jpg',
                    'badge' => 'New',
                    'badge_class' => 'new',
                    'desc' => 'San Marzano tomatoes, fresh buffalo mozzarella, fragrant basil leaves, drizzled with Italian truffle oil on a hand-stretched sourdough base.',
                    'tags' => ['Vegetarian', 'New', 'Italian']
                ],
                [
                    'id' => 3,
                    'title' => 'Nashville Hot Crispy Chicken',
                    'category' => 'chicken',
                    'category_name' => 'Chicken',
                    'price' => 12.99,
                    'old_price' => 16.99,
                    'rating' => 5.0,
                    'reviews' => 210,
                    'cal' => 710,
                    'time' => 15,
                    'image' => 'img/menu/3.jpg',
                    'badge' => 'Best Seller',
                    'badge_class' => 'hot',
                    'desc' => 'Extra-crispy fried chicken tossed in our signature fiery Nashville spice blend, served with honey drizzle and house pickles on a toasted brioche bun.',
                    'tags' => ['Spicy', 'Bestseller', 'Crispy']
                ],
                [
                    'id' => 4,
                    'title' => 'Loaded Fajita Chicken Wrap',
                    'category' => 'wraps',
                    'category_name' => 'Wraps',
                    'price' => 10.99,
                    'old_price' => null,
                    'rating' => 4.5,
                    'reviews' => 74,
                    'cal' => 520,
                    'time' => 10,
                    'image' => 'img/menu/4.jpg',
                    'badge' => null,
                    'badge_class' => '',
                    'desc' => 'Grilled chicken strips, sautéed bell peppers and onions, sour cream, fresh guacamole and salsa wrapped in a warm flour tortilla with melted cheddar.',
                    'tags' => ['Grilled', 'Fresh', 'Mexican']
                ],
                [
                    'id' => 5,
                    'title' => 'Nutella Lava Molten Cake',
                    'category' => 'desserts',
                    'category_name' => 'Desserts',
                    'price' => 8.99,
                    'old_price' => 11.99,
                    'rating' => 4.9,
                    'reviews' => 56,
                    'cal' => 390,
                    'time' => 8,
                    'image' => 'img/menu/5.jpg',
                    'badge' => 'New',
                    'badge_class' => 'new',
                    'desc' => 'Warm molten chocolate cake with a gooey Nutella center, served alongside Madagascar vanilla bean ice cream with salted caramel drizzle and fresh berries.',
                    'tags' => ['Sweet', 'New', 'Chocolate']
                ],
                [
                    'id' => 6,
                    'title' => 'Truffle Wild Mushroom Pasta',
                    'category' => 'pasta',
                    'category_name' => 'Pasta',
                    'price' => 16.99,
                    'old_price' => null,
                    'rating' => 4.9,
                    'reviews' => 88,
                    'cal' => 560,
                    'time' => 20,
                    'image' => 'img/menu/6.jpg',
                    'badge' => "Chef's Pick",
                    'badge_class' => 'hot',
                    'desc' => 'Al dente tagliatelle tossed with mixed wild mushrooms, freshly shaved black truffle, aged parmesan, fresh thyme and a touch of cream in garlic butter.',
                    'tags' => ['Vegetarian', "Chef's Pick", 'Italian']
                ]
            ],
            'chefs' => [
                ['id' => 1, 'name' => 'Alice Mortal', 'role' => 'Executive Head Chef', 'exp' => '12 years experience', 'image' => 'img/chefs/1.jpg', 'bio' => 'Awarded master chef with culinary distinction from Le Cordon Bleu.'],
                ['id' => 2, 'name' => 'Michael Corn', 'role' => 'Master Grill Specialist', 'exp' => '8 years experience', 'image' => 'img/chefs/2.jpg', 'bio' => 'Master of the wood-fired grill and authentic smoked meats.'],
                ['id' => 3, 'name' => 'Faz Chowdel', 'role' => 'Executive Pastry Chef', 'exp' => '10 years experience', 'image' => 'img/chefs/3.jpg', 'bio' => 'Crafting decadent desserts, molten cakes, and gourmet artisan pastries.'],
                ['id' => 4, 'name' => 'William Latnum', 'role' => 'Artisan Pizza Master', 'exp' => '9 years experience', 'image' => 'img/chefs/4.jpg', 'bio' => 'Specialized in hand-stretched sourdough and 900°F stone-oven pizzas.']
            ],
            'reservations' => [
                [
                    'id' => 1,
                    'name' => 'Sarah Johnson',
                    'phone' => '+1 (555) 234-5678',
                    'email' => 'sarah.j@example.com',
                    'guests' => '4 People',
                    'date' => date('Y-m-d', strtotime('+1 day')),
                    'time' => '07:30 PM',
                    'special_requests' => 'Window booth table preferred, anniversary celebration',
                    'status' => 'Confirmed',
                    'created_at' => date('Y-m-d 10:15:00')
                ],
                [
                    'id' => 2,
                    'name' => 'David Miller',
                    'phone' => '+1 (555) 876-5432',
                    'email' => 'dmiller@example.com',
                    'guests' => '2 People',
                    'date' => date('Y-m-d', strtotime('+2 days')),
                    'time' => '08:00 PM',
                    'special_requests' => 'Gluten-free menu items please',
                    'status' => 'Pending',
                    'created_at' => date('Y-m-d 14:30:00')
                ],
                [
                    'id' => 3,
                    'name' => 'Elena Rostova',
                    'phone' => '+1 (555) 345-9876',
                    'email' => 'elena.rostova@example.com',
                    'guests' => '6 People',
                    'date' => date('Y-m-d', strtotime('+3 days')),
                    'time' => '06:00 PM',
                    'special_requests' => 'Family dinner with 2 kids high chairs',
                    'status' => 'Confirmed',
                    'created_at' => date('Y-m-d 16:45:00')
                ]
            ],
            'reviews' => [
                [
                    'id' => 1,
                    'name' => 'Monica Wilber',
                    'role' => 'Regular Customer',
                    'rating' => 5,
                    'text' => 'Honestly the best burgers I\'ve ever had. The smash burger is incredible - perfectly crispy edges, juicy inside, and those pickles! We come every Friday now.',
                    'image' => 'img/testimonial/1.jpg',
                    'status' => 'Approved',
                    'created_at' => date('Y-m-d H:i:s', strtotime('-2 days'))
                ],
                [
                    'id' => 2,
                    'name' => 'Cameron Fox',
                    'role' => 'Food Blogger',
                    'rating' => 5,
                    'text' => 'Ordered delivery and the food arrived hot and fresh in 22 minutes. Portions are generous. Fast Food has become my go-to comfort food spot without question.',
                    'image' => 'img/testimonial/2.jpg',
                    'status' => 'Approved',
                    'created_at' => date('Y-m-d H:i:s', strtotime('-4 days'))
                ],
                [
                    'id' => 3,
                    'name' => 'Priya Sharma',
                    'role' => 'Food Enthusiast',
                    'rating' => 5,
                    'text' => 'The truffle pasta blew my mind. I didn\'t expect that quality from a fast food place. Great ambiance, super friendly staff. Highly recommended!',
                    'image' => 'img/testimonial/3.jpg',
                    'status' => 'Approved',
                    'created_at' => date('Y-m-d H:i:s', strtotime('-5 days'))
                ],
                [
                    'id' => 4,
                    'name' => 'David Park',
                    'role' => 'Corporate Client',
                    'rating' => 5,
                    'text' => 'Catered our office party of 50 people and everything was flawless. Fresh, delicious, on time and well presented. Nashville chicken was the absolute star!',
                    'image' => 'img/testimonial/4.jpg',
                    'status' => 'Approved',
                    'created_at' => date('Y-m-d H:i:s', strtotime('-7 days'))
                ]
            ],
            'contacts' => [
                [
                    'id' => 1,
                    'name' => 'Robert Sterling',
                    'email' => 'robert@sterlingmedia.com',
                    'phone' => '+1 (555) 998-1122',
                    'subject' => 'Catering & Events',
                    'message' => 'Hello! We are organizing a corporate summit for 80 attendees next month and would love a custom quote for your smash burger and wrap catering packages.',
                    'is_read' => false,
                    'created_at' => date('Y-m-d 09:20:00')
                ],
                [
                    'id' => 2,
                    'name' => 'Jessica Alba',
                    'email' => 'jessica.a@example.com',
                    'phone' => '+1 (555) 443-8899',
                    'subject' => 'Feedback',
                    'message' => 'Had an amazing dinner at your Manhattan location yesterday! The staff was super attentive and the Nashville hot chicken was out of this world.',
                    'is_read' => true,
                    'created_at' => date('Y-m-d 11:45:00', strtotime('-1 day'))
                ]
            ],
            'blogs' => [
                [
                    'id' => 1,
                    'title' => 'Healthy Fast Food: A Myth or Beautiful Reality in 2026',
                    'category' => 'Food & Health',
                    'author' => 'James Writer',
                    'comments' => 24,
                    'day' => '14',
                    'month' => 'Mar',
                    'image' => 'img/blog/1.jpg',
                    'excerpt' => 'Discover how we craft nutritious yet indulgent fast-food options that keep you energetic without compromising on rich flavor.',
                    'content' => 'In today\'s fast-paced world, eating well on the go has evolved from a rare luxury to an everyday necessity. At Fast Food, we believe you shouldn\'t have to sacrifice nutritional integrity for speed and flavor. By sourcing 100% grass-fed beef, organic sourdough buns, and pesticide-free heirloom vegetables, every single meal fuels your lifestyle while satisfying your deepest comfort cravings.'
                ],
                [
                    'id' => 2,
                    'title' => "Is Fast Food Getting Healthier? Here's What Our Nutritionists Found",
                    'category' => 'Food Science',
                    'author' => 'Sarah Grain',
                    'comments' => 18,
                    'day' => '28',
                    'month' => 'Feb',
                    'image' => 'img/blog/2.jpg',
                    'excerpt' => 'An in-depth look into modern cooking techniques, healthy oils, and farm-to-table freshness in today’s restaurant kitchens.',
                    'content' => 'Modern gastronomy is undergoing a massive revolution. From air-fry convection ovens that eliminate excess saturated fats to cold-pressed avocado and extra-virgin olive oil drizzles, our kitchen blends ancient culinary science with contemporary wellness standards.'
                ],
                [
                    'id' => 3,
                    'title' => "Innovative Hot Chickpeas & Smashed Patty Recipe at Home",
                    'category' => 'Recipes',
                    'author' => 'Chef Marcus',
                    'comments' => 32,
                    'day' => '05',
                    'month' => 'Jan',
                    'image' => 'img/blog/3.jpg',
                    'excerpt' => 'Step-by-step culinary masterclass on making mouth-watering crispy smashed bites with our secret blend of seasoning.',
                    'content' => 'Want to achieve that iconic lacy, crispy crust on your burger at home? In this masterclass, Chef Marcus breaks down the temperature dynamics of cast iron skillets, the secret 80/20 lean-to-fat beef ratio, and how a pinch of smoked sea salt transforms everything.'
                ]
            ],
            'gallery_items' => [
                [
                    'id' => 1,
                    'title' => 'Gourmet Smash Burgers',
                    'desc' => 'Double-smashed beef patties, melted aged cheddar, caramelized shallots, and house-made secret sauce on toasted brioche.',
                    'image' => 'img/portfolio/work1.jpg',
                    'category' => 'Gourmet Burgers'
                ],
                [
                    'id' => 2,
                    'title' => 'Wood-Fired Truffle Pizza',
                    'desc' => 'Hand-stretched 48-hour fermented sourdough fired at 900°F in our wood-burning stone oven.',
                    'image' => 'img/portfolio/work2.jpg',
                    'category' => 'Wood-Fired Pizza'
                ],
                [
                    'id' => 3,
                    'title' => 'Nashville Hot Crispy Chicken',
                    'desc' => 'Double-brined, buttermilk battered golden fried chicken tossed in fiery cayenne-infused spices.',
                    'image' => 'img/portfolio/work3.jpg',
                    'category' => 'Crispy Fried Chicken'
                ],
                [
                    'id' => 4,
                    'title' => 'Molten Nutella Lava Cake',
                    'desc' => 'Warm chocolate molten cake filled with decadent hazelnut cream, served with Madagascar vanilla ice cream.',
                    'image' => 'img/portfolio/work4.jpg',
                    'category' => 'Sweet Desserts'
                ],
                [
                    'id' => 5,
                    'title' => 'Loaded Fajita Wraps',
                    'desc' => 'Fresh grilled chicken breast, roasted bell peppers, fresh guacamole and house-made salsa verde.',
                    'image' => 'img/portfolio/work5.jpg',
                    'category' => 'Fresh Wraps & Rolls'
                ]
            ],
            'review_settings' => [
                'overall_rating' => '4.9',
                'rating_subtitle' => 'Overall Diner Rating (850+ Reviews)',
                'metric1_label' => 'Food Quality & Freshness',
                'metric1_percent' => 98,
                'metric2_label' => 'Delivery Speed (< 25 mins)',
                'metric2_percent' => 95,
                'metric3_label' => 'Friendly Customer Care',
                'metric3_percent' => 99
            ],
            'settings' => [
                'restaurant_name' => 'Fast Food',
                'phone' => '+1 (800) 123-4567',
                'email' => 'hello@fastfood.com',
                'address' => '42 Flavor Street, Manhattan, NY 10001',
                'hours' => 'Wed - Sun: 09 AM - 11 PM',
                'announcement' => 'Free Delivery Today on Orders Over $25!',
                'facebook' => 'https://facebook.com',
                'instagram' => 'https://instagram.com',
                'twitter' => 'https://twitter.com',
                'youtube' => 'https://youtube.com',
                'tiktok' => 'https://tiktok.com',
                'footer_desc' => "We bring the world's finest flavors together in a fast, friendly, and affordable experience. Every meal crafted with love."
            ]
        ];
    }
}
