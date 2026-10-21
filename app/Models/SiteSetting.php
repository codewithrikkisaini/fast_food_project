<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SiteSetting extends Model
{
    use HasFactory;

    protected $table = 'site_settings';

    protected $fillable = [
        'restaurant_name',
        'phone',
        'email',
        'address',
        'hours',
        'announcement',
        'facebook',
        'instagram',
        'twitter',
        'youtube',
        'tiktok',
        'footer_desc',
    ];
}
