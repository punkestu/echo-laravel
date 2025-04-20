<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'user_id',
        'nama',
        'no_telp',
        'alamat',
        'jaminan',
        'pengambilan',
        'tempat_cod',
        'jam_ambil',
        'jam_kembali',
        'status',
        'price',
        'discount',
        'bukti_dp',
        'bukti_lunas',
        'bukti_dibawa',
        'bukti_kembali',
    ];

    public function catalogs()
    {
        return $this->belongsToMany(Catalog::class, 'order_catalogs');
    }

    public function theprice()
    {
        return $this->price - $this->discount;
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function nohp_withcode()
    {
        // remove all non-numeric characters
        $nohp = preg_replace('/[\-]/', '', $this->no_telp);
        if (str_starts_with($nohp, '0')) {
            return '+62' . substr($nohp, 1);
        } elseif (str_starts_with($nohp, '62')) {
            return '+' . $nohp;
        } elseif (str_starts_with($nohp, '+62')) {
            return $nohp;
        };
    }
}
