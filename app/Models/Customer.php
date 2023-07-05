<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Customer extends Model

{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'id', 'nif', 'address', 'payment_type', 'payment_ref'
    ];


    public function user(): BelongsTo
    {
        //customer belongs to user (1:1)
        return $this->belongsTo(User::class, 'id', 'id')->withTrashed();
    }

    public function orders(): HasMany
    {
        //customer hasmany orders (1:N)
        return $this->hasMany(Order::class, 'customer_id', 'id');
    }

    public function tshirt_image(): HasMany
    {
        //customer hasmany orders (1:N)
        return $this->hasMany(Tshirt_image::class, 'customer_id', 'id');
    }
}
