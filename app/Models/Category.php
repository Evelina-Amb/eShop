<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;
    
    protected $table = 'Category';

    protected $fillable = ['pavadinimas', 'aprasymas', 'tipo_zenklas'];

    public function Listing()
    {
        return $this->hasMany(Skelbimas::class);
    }
}
