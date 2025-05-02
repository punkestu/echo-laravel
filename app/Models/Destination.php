<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class Destination extends Model
{
    protected $fillable = [
        'name',
        'address',
        'city',
        'country',
        'description',
        'thumb_url',
        'map_url',
        'tags',
    ];
    protected $casts = [
        'tags' => 'array',
    ];

    public static function get_cached($query = null)
    {
        $destinations = Cache::get('destinations');
        if (!$destinations) {
            $destinations = self::all();
            Cache::put('destinations', $destinations, 60);
        }
        
        if ($query) {
            return $destinations->filter(function ($destination) use ($query) {
                return str_contains($destination->name, $query) || in_array(strtolower($query), $destination->tags);
            });
        }

        return $destinations;
    }

    public static function sync_cache()
    {
        Cache::forget('destinations');
        Cache::put('destinations', self::all(), 60);
    }
}
