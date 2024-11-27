<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderUser extends Model
{
    use HasFactory;

    protected $table = 'orders_user';
    protected $primaryKey = 'id';
    protected $fillable = [
        'user_id',
        'name',
        'phone',
        'street',
        'payment_method',
        'total_amount',
        'status_id',
        'products',
        "order_code",
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // In Order model
    public function products()
    {
        return $this->hasMany(Product::class);
    }


    public function items()
    {
        return $this->hasMany(OrderItem::class, 'id');
    }
    public function orderStatus()
    {
        return $this->belongsTo(OrderStatus::class, 'status_id');
    }
}
