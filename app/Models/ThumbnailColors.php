<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ThumbnailColors extends Model
{
    protected $table = 'thumbnail_colors';
    protected $fillable = ['color_id', 'image_url'];
}
