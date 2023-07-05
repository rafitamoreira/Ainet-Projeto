<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Tshirt_image extends Model
{
    use HasFactory;

    protected $hidden = [
        'created_at',
        'deleted_at',
        'updated_at'
    ];
    public function customer(): BelongsTo
    {

        return $this->belongsTo(Customer::class, 'customer_id', 'id');
    }

    public function order_item(): HasMany
    {
        //customer hasmany orders (1:N)
        return $this->hasMany(Order_item::class, 'tshirt_image_id', 'id');
    }

    public function category(): BelongsTo
    {

        return $this->belongsTo(Categorie::class, 'category_id', 'id');
    }
}
