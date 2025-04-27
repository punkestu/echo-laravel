<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class ItemType extends Model
{
    protected $fillable = [
        'name',
        'thumb_url',
    ];

    public static function get_cached()
    {
        $item_types = Cache::get("item_types");
        if (!$item_types) {
            $item_types = ItemType::all();
            Cache::put("item_types", $item_types, 60 * 24);
        }

        return $item_types;
    }

    public function items()
    {
        return $this->belongsToMany(Item::class, 'item_item_types');
    }

    public function itemItemTypes()
    {
        return $this->hasMany(ItemItemType::class);
    }
}
