<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    use HasFactory;

    protected $fillable = [
        'phone',
        'email',
        'facebook_url',
        'twitter_url',
        'youtube_url',
        'instagram_url',
        'about_app',
    ];
}
