<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ItemType extends Model
{
    protected $fillable = [
        'name',
        'thumb_url',
    ];

    public function items()
    {
        return $this->belongsToMany(Item::class, 'item_item_types');
    }

    public function itemItemTypes()
    {
        return $this->hasMany(ItemItemType::class);
    }
}
