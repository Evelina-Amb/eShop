<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable

{
    use HasFactory;

    protected $fillable = [
        'vardas', 'pavarde', 'el_pastas', 'slaptazodis',
        'telefonas', 'address_id', 'role'
    ];

    public function Address()
    {
        return $this->belongsTo(Address::class);
    }

    public function Listing()
    {
        return $this->hasMany(Listing::class);
    }

    public function Review()
    {
        return $this->hasMany(Review::class);
    }

    public function Cart()
    {
        return $this->hasMany(Cart::class);
    }

    public function Favorite()
    {
        return $this->hasMany(Favorite::class);
    }

    public function Order()
    {
        return $this->hasMany(Order::class);
    }
}
