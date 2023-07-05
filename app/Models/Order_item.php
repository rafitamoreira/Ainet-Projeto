<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Order_item extends Model
{
    use HasFactory;

    protected $fillable = [
        'id', 'order_id', 'tshirt_image_id', 'color_code', 'size', 'qty', 'unit_price', 'sub_total',
    ];


    public function order(): BelongsTo
    {

        return $this->belongsTo(Order::class, 'order_id', 'id');
    }

    public function color(): BelongsTo
    {

        return $this->belongsTo(Color::class, 'color_code', 'code');
    }

    public function tshirt_image(): BelongsTo
    {

        return $this->belongsTo(Tshirt_image::class, 'tshirt_image_id', 'code');
    }
}
