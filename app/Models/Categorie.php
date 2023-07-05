<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Categorie extends Model
{
    use HasFactory;


    public function tshirt_image(): HasMany
    {
        //customer hasmany orders (1:N)
        return $this->hasMany(Tshirt_image::class, 'category_id', 'id');
    }
}
