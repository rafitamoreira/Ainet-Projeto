<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Preco extends Model
{
    use HasFactory;

    protected $fillable = [
        'id', 'unit_price_catalog', 'unit_price_own', 'unit_price_catalog_discount', 'unit_price_own_discount', 'qty_discount',
    ];

    protected $hidden = [
        'deleted_at',
    ];

    protected $table = 'Prices';
}
