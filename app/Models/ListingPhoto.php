<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ListingPhoto extends Model
{
    use HasFactory;
    protected $table = 'ListingPhoto';

    protected $fillable = ['Listing_id', 'failo_url'];

    public function Listing()
    {
        return $this->belongsTo(Listing::class);
    }
}
