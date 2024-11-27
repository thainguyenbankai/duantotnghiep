<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductOptions extends Model
{
    use HasFactory;

    protected $table = 'product_options';

    protected $fillable = [
        'product_id',
        'ram',
        'rom',      
        'color',
        'price',
        'stock'
    ];

    protected $casts = [
        'color' => 'array', 
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
