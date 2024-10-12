<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductVariant extends Model
{
    use HasFactory;
    protected $table = 'product_variants';
    protected $fillable = [
        'product_id',
        'color_id',
        'size_id',
        'price',
        'stock',
        'sku',
        'image_url',
    ];

    /**
     * Get the product that owns the variant.
     */
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    /**
     * Get the color associated with the variant.
     */
    public function color()
    {
        return $this->belongsTo(Color::class);
    }

    /**
     * Get the size associated with the variant.
     */
    public function size()
    {
        return $this->belongsTo(Size::class);
    }
}
