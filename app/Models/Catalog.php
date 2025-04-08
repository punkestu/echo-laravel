<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Catalog extends Model
{
    protected $fillable = [
        'name',
        'description',
        'thumb_url',
        'price'
    ];

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
