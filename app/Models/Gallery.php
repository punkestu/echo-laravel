<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class Gallery extends Model
{
    protected $fillable = [
        'title',
        'description',
        'image_url',
        'priority'
    ];

    public static function get_cached()
    {
        $gallery = Cache::get("gallery");
        if (!$gallery) {
            $gallery = Gallery::orderBy('priority', 'desc')->get();
            Cache::put('gallery', $gallery, 60 * 24);
        }

        return $gallery;
    }
}
