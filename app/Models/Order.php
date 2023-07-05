<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'id', 'status', 'customer_id', 'date', 'total_price', 'notes', 'nif', 'address', 'payment_type', 'payment_ref', 'receipt_url',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    public function customer(): BelongsTo
    {

        return $this->belongsTo(Customer::class, 'customer_id', 'id')->withTrashed();
    }

    public function order_item(): HasMany
    {

        return $this->hasMany(Order_item::class, 'order_id', 'id');
    }
}
