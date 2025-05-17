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

    public function nohp_withcode()
    {

        // remove all non-numeric characters
        $nohp = preg_replace('/[\-]/', '', $this->phone);
        if (str_starts_with($nohp, '0')) {
            return '+62' . substr($nohp, 1);
        } elseif (str_starts_with($nohp, '62')) {
            return '+' . $nohp;
        } elseif (str_starts_with($nohp, '+62')) {
            return $nohp;
        }

        return $nohp;
    }

    public function discounts()
    {
        return $this->hasMany(Discount::class)->where('used', 0);
    }
}
