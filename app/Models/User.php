<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, HasApiTokens;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'nohp',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    public function carts()
    {
        return $this->hasMany(Cart::class);
    }

    public function nohp_withcode()
    {
        // remove all non-numeric characters
        $nohp = preg_replace('/[\-]/', '', $this->nohp);
        if (str_starts_with($nohp, '0')) {
            return '+62' . substr($nohp, 1);
        } elseif (str_starts_with($nohp, '62')) {
            return '+' . $nohp;
        } elseif (str_starts_with($nohp, '+62')) {
            return $nohp;
        }

        return $nohp;
    }

    public function order_count()
    {
        return $this->hasMany(Order::class)->count();
    }

    public function order_price_sum()
    {
        return $this->hasMany(Order::class)->sum('price');
    }

    public function discounts()
    {
        return $this->hasMany(Discount::class)->where('used', 0);
    }
}
