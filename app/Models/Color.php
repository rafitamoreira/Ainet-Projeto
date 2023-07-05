<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Color extends Model
{
    use HasFactory, SoftDeletes;

    protected $primaryKey = 'code';
    protected $keyType = 'string';



    protected $fillable = [
        'code', 'nome',
    ];

    protected $hidden = [
        'deleted_at',
    ];

    public function order_items(): HasMany
    {

        return $this->hasMany(Order_item::class, 'color_code', 'code');
    }
}
