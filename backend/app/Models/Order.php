<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'restaurant_id',
        'customer_name',
        'customer_email',
        'customer_phone',
        'delivery_address',
        'payment_method',
        'total_amount',
        'status',
        'order_number'
    ];

    protected $casts = [
        'total_amount' => 'decimal:2',
    ];

    public function restaurant()
    {
        return $this->belongsTo(Restaurant::class);
    }

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($order) {
            if (empty($order->order_number)) {
                $order->order_number = 'BS' . strtoupper(substr(uniqid(), -8));
            }
        });
    }
}
