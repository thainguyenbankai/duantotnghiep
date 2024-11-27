<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ProductCart extends Model
{
    use HasFactory; 

    protected $table = 'product_cart';  
    protected $fillable = [
        'product_id',
        'user_id',    
        'quantity',
        'price',
        'option_id',
        'color_id',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }
    public function option()
{
    return $this->belongsTo(Options::class, 'option_id');
}

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id'); 
    }
    public function color()
{
    return $this->belongsTo(Colors::class, 'color_id');
}
}
