<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ItemItemType extends Model
{
    protected $fillable = [
        'item_id',
        'item_type_id',
    ];

    public function item()
    {
        return $this->belongsTo(Item::class);
    }

    public function itemType()
    {
        return $this->belongsTo(ItemType::class);
    }
}
