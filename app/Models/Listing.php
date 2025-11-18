<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Listing extends Model
{
    use HasFactory;

    protected $table = 'Listing';

    protected $fillable = [
        'pavadinimas', 'aprasymas', 'kaina', 'tipas',
        'user_id', 'Category_id', 'statusas'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

   public function Category()
   {
    return $this->belongsTo(Category::class, 'Category_id');
   }

    public function ListingPhoto()
    {
        return $this->hasMany(ListingPhoto::class);
    }

    public function Review()
    {
        return $this->hasMany(Review::class);
    }
}
