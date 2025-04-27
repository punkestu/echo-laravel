<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class Catalog extends Model
{
    protected $fillable = [
        'name',
        'description',
        'thumb_url',
        'price'
    ];

    public static function get_cached($filter_type, $search)
    {
        if ($filter_type){
            $catalogs = Cache::get('catalogs' . $filter_type);
            if (!$catalogs) {
                $catalogs = Catalog::with(['catalogItems' => function ($query) {
                    $query->with('item');
                }])
                    ->whereHas('catalogItems.item.itemTypes', function ($query) use ($filter_type) {
                        $query->where('item_types.id', $filter_type);
                    })
                    ->get();
                Cache::put('catalogs' . $filter_type, $catalogs, 60);
            }
        } else {
            $catalogs = Cache::get('catalogs');
            if (!$catalogs) {
                $catalogs = Catalog::with(['catalogItems' => function ($query) {
                    $query->with('item');
                }])
                    ->get();
                Cache::put('catalogs', $catalogs, 60);
            }
        }

        if ($search) {
            $catalogs = $catalogs->filter(function ($catalog) use ($search) {
                return str_contains($catalog->name, $search) || str_contains($catalog->description, $search);
            });
        }

        return $catalogs;
    }

    public function items()
    {
        return $this->belongsToMany(Item::class, 'catalog_items');
    }

    public function catalogItems()
    {
        return $this->hasMany(CatalogItem::class);
    }

    public function isavailable()
    {
        // check is items good_qty - rent_qty >= catalog_items qty
        $isAvailable = true;
        foreach ($this->catalogItems as $catalogItem) {
            $item = Item::find($catalogItem->item_id);
            if ($item->good_qty - $item->rent_qty < $catalogItem->qty) {
                $isAvailable = false;
                break;
            }
        }
        return $isAvailable;
    }
}
