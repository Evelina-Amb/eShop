<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Favorite extends Model
{
    use HasFactory;
    
     protected $table = 'Favorite';

    protected $fillable = ['user_id', 'Listing_id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function Listing()
    {
        return $this->belongsTo(Listing::class);
    }
}
