<?php

namespace App\Services;

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
        return $data['about'] ?? [];
    }

    public function updateAboutSettings(array $settings): void
    {
        $data = $this->getAllData();
        $data['about'] = array_merge($data['about'] ?? [], $settings);
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
            if ((int)$item['id'] === $id) {
                return $item;
            }
        }
        return null;
    }

    public function saveMenuItem(array $itemData): array
    {
        $data = $this->getAllData();
        $items = $data['menu_items'] ?? [];

        if (!empty($itemData['id'])) {
            $id = (int)$itemData['id'];
            foreach ($items as $idx => $existing) {
                if ((int)$existing['id'] === $id) {
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
            if ((int)$item['id'] > $maxId) {
                $maxId = (int)$item['id'];
            }
        }
        $itemData['id'] = $maxId + 1;
        if (empty($itemData['rating'])) $itemData['rating'] = 5.0;
        if (empty($itemData['reviews'])) $itemData['reviews'] = 1;
        if (empty($itemData['image'])) $itemData['image'] = 'img/menu/1.jpg';
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
        $filtered = array_filter($items, fn($i) => (int)$i['id'] !== $id);

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
            $id = (int)$chefData['id'];
            foreach ($chefs as $idx => $existing) {
                if ((int)($existing['id'] ?? 0) === $id) {
                    $chefs[$idx] = array_merge($existing, $chefData);
                    $data['chefs'] = array_values($chefs);
                    $this->saveAllData($data);
                    return $chefs[$idx];
                }
            }
        }

        $maxId = 0;
        foreach ($chefs as $chef) {
            if ((int)($chef['id'] ?? 0) > $maxId) {
                $maxId = (int)$chef['id'];
            }
        }
        $chefData['id'] = $maxId + 1;
        if (empty($chefData['image'])) $chefData['image'] = 'img/chefs/1.jpg';

        $chefs[] = $chefData;
        $data['chefs'] = array_values($chefs);
        $this->saveAllData($data);
        return $chefData;
    }

    public function deleteChef(int $id): bool
    {
        $data = $this->getAllData();
        $chefs = $data['chefs'] ?? [];
        $filtered = array_filter($chefs, fn($c) => (int)($c['id'] ?? 0) !== $id);

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
            $id = (int)$itemData['id'];
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
        $filtered = array_filter($items, fn($item) => (int)$item['id'] !== $id);

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
    public function getReservations(): array
    {
        $data = $this->getAllData();
        return $data['reservations'] ?? [];
    }

    public function addReservation(array $resData): array
    {
        $data = $this->getAllData();
        $reservations = $data['reservations'] ?? [];

        $maxId = 0;
        foreach ($reservations as $r) {
            if ((int)($r['id'] ?? 0) > $maxId) {
                $maxId = (int)$r['id'];
            }
        }

        $newReservation = [
            'id' => $maxId + 1,
            'name' => $resData['name'] ?? '',
            'phone' => $resData['phone'] ?? '',
            'email' => $resData['email'] ?? '',
            'guests' => $resData['guests'] ?? '2 People',
            'date' => $resData['date'] ?? date('Y-m-d'),
            'time' => $resData['time'] ?? '07:00 PM',
            'special_requests' => $resData['special_requests'] ?? ($resData['message'] ?? 'No special requests'),
            'status' => 'Pending', // Pending, Confirmed, Cancelled
            'created_at' => date('Y-m-d H:i:s')
        ];

        array_unshift($reservations, $newReservation);
        $data['reservations'] = $reservations;
        $this->saveAllData($data);

        return $newReservation;
    }

    public function updateReservationStatus(int $id, string $status): bool
    {
        $data = $this->getAllData();
        $reservations = $data['reservations'] ?? [];

        foreach ($reservations as $idx => $r) {
            if ((int)$r['id'] === $id) {
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
        $data = $this->getAllData();
        $reservations = $data['reservations'] ?? [];
        $filtered = array_filter($reservations, fn($r) => (int)$r['id'] !== $id);

        $data['reservations'] = array_values($filtered);
        $this->saveAllData($data);
        return true;
    }

    // ----------------------------------------------------
    // REVIEWS
    // ----------------------------------------------------
    public function getReviews(): array
    {
        $data = $this->getAllData();
        return $data['reviews'] ?? [];
    }

    public function addReview(array $revData): array
    {
        $data = $this->getAllData();
        $reviews = $data['reviews'] ?? [];

        $maxId = 0;
        foreach ($reviews as $r) {
            if ((int)($r['id'] ?? 0) > $maxId) {
                $maxId = (int)$r['id'];
            }
        }

        $newReview = [
            'id' => $maxId + 1,
            'name' => $revData['name'] ?? 'Guest Customer',
            'role' => $revData['role'] ?? 'Verified Diner',
            'rating' => (int)($revData['rating'] ?? 5),
            'text' => $revData['text'] ?? ($revData['message'] ?? 'Delicious food and excellent service!'),
            'image' => 'img/testimonial/' . (rand(1, 4)) . '.jpg',
            'status' => 'Approved', // Approved, Pending
            'created_at' => date('Y-m-d H:i:s')
        ];

        array_unshift($reviews, $newReview);
        $data['reviews'] = $reviews;
        $this->saveAllData($data);

        return $newReview;
    }

    public function updateReviewStatus(int $id, string $status): bool
    {
        $data = $this->getAllData();
        $reviews = $data['reviews'] ?? [];

        foreach ($reviews as $idx => $r) {
            if ((int)$r['id'] === $id) {
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
        $data = $this->getAllData();
        $reviews = $data['reviews'] ?? [];
        $filtered = array_filter($reviews, fn($r) => (int)$r['id'] !== $id);

        $data['reviews'] = array_values($filtered);
        $this->saveAllData($data);
        return true;
    }

    // ----------------------------------------------------
    // CONTACT INQUIRIES
    // ----------------------------------------------------
    public function getContacts(): array
    {
        $data = $this->getAllData();
        return $data['contacts'] ?? [];
    }

    public function addContact(array $contactData): array
    {
        $data = $this->getAllData();
        $contacts = $data['contacts'] ?? [];

        $maxId = 0;
        foreach ($contacts as $c) {
            if ((int)($c['id'] ?? 0) > $maxId) {
                $maxId = (int)$c['id'];
            }
        }

        $newContact = [
            'id' => $maxId + 1,
            'name' => $contactData['name'] ?? '',
            'email' => $contactData['email'] ?? '',
            'phone' => $contactData['phone'] ?? '',
            'subject' => $contactData['subject'] ?? 'General Inquiry',
            'message' => $contactData['message'] ?? '',
            'is_read' => false,
            'created_at' => date('Y-m-d H:i:s')
        ];

        array_unshift($contacts, $newContact);
        $data['contacts'] = $contacts;
        $this->saveAllData($data);

        return $newContact;
    }

    public function markContactRead(int $id): bool
    {
        $data = $this->getAllData();
        $contacts = $data['contacts'] ?? [];

        foreach ($contacts as $idx => $c) {
            if ((int)$c['id'] === $id) {
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
        $data = $this->getAllData();
        $contacts = $data['contacts'] ?? [];
        $filtered = array_filter($contacts, fn($c) => (int)$c['id'] !== $id);

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

    // ----------------------------------------------------
    // DASHBOARD STATS
    // ----------------------------------------------------
    public function getStats(): array
    {
        $menuItems = $this->getMenuItems();
        $reservations = $this->getReservations();
        $contacts = $this->getContacts();
        $reviews = $this->getReviews();

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
                'deal_old_price' => '$24.99'
            ],
            'about' => [
                'tagline' => 'Our Story & Heritage',
                'title' => 'We Invite You to Visit Our Food Restaurant',
                'desc' => 'Founded in 2012, Fast Food began as a small corner joint with a big dream - to serve food that brings people together. Today we\'re proud to serve thousands of happy customers every week with the same passion that started it all.',
                'years_badge' => '12+',
                'points' => [
                    [
                        'title' => '100% Fresh Ingredients',
                        'desc' => 'We source locally and sustainably. Every ingredient is hand-picked daily for maximum freshness.'
                    ],
                    [
                        'title' => 'Award-Winning Recipes',
                        'desc' => 'Our signature recipes have won national culinary awards 5 years in a row.'
                    ],
                    [
                        'title' => 'Lightning-Fast Delivery',
                        'desc' => 'Order online and get hot, fresh food at your door in under 25 minutes, guaranteed.'
                    ]
                ]
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
            ]
        ];
    }
}
