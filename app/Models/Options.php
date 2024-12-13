<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Options extends Model
{
    use SoftDeletes;

    protected $fillable = ['ram', 'rom'];
}
