<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Settings extends Model
{
    protected $fillable = [
        'bname',
        'email',
        'phone',
        'currency',
        'address',
        'logo',
        'favicon',
        'copyright',
        'powered_by',
        'footer_info',
        'seo_title',
        'seo_description',
        'seo_keywords',
        'map',
        'social',
        'other'
    ];

    protected $casts = [
        'social' => 'array',
        'other'  => 'array',
    ];
}
