<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderCatalog extends Model
{
    protected $fillable = [
        'order_id',
        'catalog_id',
        'qty'
    ];
}
