<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    use HasFactory;

        protected $table = 'OrderItem';
    protected $fillable = ['Order_id', 'Listing_id', 'kaina', 'kiekis'];

    public function Order()
    {
        return $this->belongsTo(Order::class);
    }

    public function Listing()
    {
        return $this->belongsTo(Listing::class);
    }
}
