<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    protected $fillable = [
        'name',
        'phone',
    ];

    public static function registernewCustomer($name, $phone)
    {
        return self::firstOrCreate(
            [
                'phone' => $phone,
                'name' => $name
            ],
            [
                'phone' => $phone,
                'name' => $name
            ]
        );
    }
}
