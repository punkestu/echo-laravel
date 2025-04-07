<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    protected $fillable = [
        'name',
        'thumb_url',
        'description',
        'qty',
        'good_qty',
        'bad_qty',
        'rent_qty',
        'base_price',
        'price',
    ];

    public function itemTypes()
    {
        return $this->belongsToMany(ItemType::class, 'item_item_types');
    }
}
