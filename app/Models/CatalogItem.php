<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CatalogItem extends Model
{
    protected $fillable = [
        'catalog_id',
        'item_id',
        'qty',
    ];

    public function catalog()
    {
        return $this->belongsTo(Catalog::class);
    }

    public function item()
    {
        return $this->belongsTo(Item::class);
    }
}
