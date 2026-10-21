<?php

namespace Database\Seeders;

use App\Models\Contact;
use App\Models\Reservation;
use App\Models\Review;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Seed initial reservations if empty
        if (Schema::hasTable('reservations') && Reservation::count() === 0) {
            Reservation::create([
                'name' => 'Sarah Johnson',
                'phone' => '+1 (555) 234-5678',
                'email' => 'sarah.j@example.com',
                'guests' => '4 People',
                'date' => date('Y-m-d', strtotime('+1 day')),
                'time' => '07:30 PM',
                'special_requests' => 'Window booth table preferred, anniversary celebration',
                'status' => 'Confirmed',
            ]);
            Reservation::create([
                'name' => 'David Miller',
                'phone' => '+1 (555) 876-5432',
                'email' => 'dmiller@example.com',
                'guests' => '2 People',
                'date' => date('Y-m-d', strtotime('+2 days')),
                'time' => '08:00 PM',
                'special_requests' => 'Gluten-free menu items please',
                'status' => 'Pending',
            ]);
            Reservation::create([
                'name' => 'Elena Rostova',
                'phone' => '+1 (555) 345-9876',
                'email' => 'elena.rostova@example.com',
                'guests' => '6 People',
                'date' => date('Y-m-d', strtotime('+3 days')),
                'time' => '06:00 PM',
                'special_requests' => 'Family dinner with 2 kids high chairs',
                'status' => 'Confirmed',
            ]);
        }

        // Seed initial reviews if empty
        if (Schema::hasTable('reviews') && Review::count() === 0) {
            Review::create([
                'name' => 'Monica Wilber',
                'role' => 'Regular Customer',
                'rating' => 5,
                'text' => 'Honestly the best burgers I\'ve ever had. The smash burger is incredible - perfectly crispy edges, juicy inside, and those pickles! We come every Friday now.',
                'image' => 'img/testimonial/1.jpg',
                'status' => 'Approved',
            ]);
            Review::create([
                'name' => 'Cameron Fox',
                'role' => 'Food Blogger',
                'rating' => 5,
                'text' => 'Ordered delivery and the food arrived hot and fresh in 22 minutes. Portions are generous. Fast Food has become my go-to comfort food spot without question.',
                'image' => 'img/testimonial/2.jpg',
                'status' => 'Approved',
            ]);
            Review::create([
                'name' => 'Priya Sharma',
                'role' => 'Food Enthusiast',
                'rating' => 5,
                'text' => 'The truffle pasta blew my mind. I didn\'t expect that quality from a fast food place. Great ambiance, super friendly staff. Highly recommended!',
                'image' => 'img/testimonial/3.jpg',
                'status' => 'Approved',
            ]);
            Review::create([
                'name' => 'David Park',
                'role' => 'Corporate Client',
                'rating' => 5,
                'text' => 'Catered our office party of 50 people and everything was flawless. Fresh, delicious, on time and well presented. Nashville chicken was the absolute star!',
                'image' => 'img/testimonial/4.jpg',
                'status' => 'Approved',
            ]);
        }

        // Seed initial contacts if empty
        if (Schema::hasTable('contacts') && Contact::count() === 0) {
            Contact::create([
                'name' => 'Robert Sterling',
                'email' => 'robert@sterlingmedia.com',
                'phone' => '+1 (555) 998-1122',
                'subject' => 'Catering & Events',
                'message' => 'Hello! We are organizing a corporate summit for 80 attendees next month and would love a custom quote for your smash burger and wrap catering packages.',
                'is_read' => false,
            ]);
            Contact::create([
                'name' => 'Jessica Alba',
                'email' => 'jessica.a@example.com',
                'phone' => '+1 (555) 443-8899',
                'subject' => 'Feedback',
                'message' => 'Had an amazing dinner at your Manhattan location yesterday! The staff was super attentive and the Nashville hot chicken was out of this world.',
                'is_read' => true,
            ]);
        }
    }
}
