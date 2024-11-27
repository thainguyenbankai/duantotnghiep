<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reviews extends Model
{
    use HasFactory;

    protected $table = 'reviews';

    protected $fillable = ['review_text', 'rating', 'user_id', 'product_id', 'status'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
