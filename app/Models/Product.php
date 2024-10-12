<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $table = 'products';
    protected $fillable = [
        'name',
        'description',
        'price',
        'quantity',
        'brand_id',
        'image',
        'status_id',
        'type_id',
        'discount_id',
        'supplier_id',
        'category_id',
        'user_id'
    ];

    // Các thuộc tính quan hệ với các bảng khác (nếu có)
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }


    public function type()
    {
        return $this->belongsTo(ProductType::class);
    }

    public function discount()
    {
        return $this->belongsTo(Discount::class);
    }

    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
