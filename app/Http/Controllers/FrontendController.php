<?php

namespace App\Http\Controllers;

/**
 * FrontendController has been fully refactored and separated into individual domain controllers.
 * All visitor-facing frontend functionality is now handled by dedicated controllers in App\Http\Controllers\Frontend\*:
 *
 * - HomeController: Public landing page with hero, deals & showcases
 * - AboutController: Story & quality pillars page
 * - MenuController: Filterable food menu
 * - ChefController: Culinary team showcase
 * - GalleryController: Atmosphere & dish photography gallery
 * - ReservationController: Table bookings and reservation requests
 * - ReviewController: Customer testimonials and feedback submission
 * - BlogController: Food news, articles & single article detail
 * - ContactController: Contact info & visitor inquiries
 * - CartController: Cart and ordering summary
 */
class FrontendController extends Controller
{
    // All frontend control logic has been completely separated into dedicated controllers.
}
