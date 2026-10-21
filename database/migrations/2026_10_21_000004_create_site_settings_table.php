<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('site_settings', function (Blueprint $table) {
            $table->id();
            $table->string('restaurant_name', 100)->default('Fast Food');
            $table->string('phone', 50)->default('+1 (800) 123-4567');
            $table->string('email', 100)->default('hello@fastfood.com');
            $table->string('address', 255)->default('42 Flavor Street, Manhattan, NY 10001');
            $table->string('hours', 100)->default('Wed - Sun: 09 AM - 11 PM');
            $table->string('announcement', 150)->nullable()->default('Free Delivery on Orders $25+');
            $table->string('facebook', 255)->nullable()->default('https://facebook.com');
            $table->string('instagram', 255)->nullable()->default('https://instagram.com');
            $table->string('twitter', 255)->nullable()->default('https://twitter.com');
            $table->string('youtube', 255)->nullable()->default('https://youtube.com');
            $table->string('tiktok', 255)->nullable()->default('https://tiktok.com');
            $table->text('footer_desc')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('site_settings');
    }
};
