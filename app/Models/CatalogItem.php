<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class CatalogItem extends Model
{
    protected $fillable = [
        'catalog_id',
        'item_id',
        'qty',
    ];

    public static function get_cached()
    {
        $catalog_items = Cache::get("catalog_items");
        if (!$catalog_items) {
            $catalog_items = CatalogItem::all();
            Cache::put("catalog_items", $catalog_items, 60 * 24);
        }

        return $catalog_items;
    }

    public function catalog()
    {
        return $this->belongsTo(Catalog::class);
    }

    public function item()
    {
        return $this->belongsTo(Item::class);
    }
}
