<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    protected $table = 'payments';
    protected $primaryKey = 'id';

    protected $fillable = [
        'user_id', 'order_id', 'order_code', 'amount', 'payment_method', 'transaction_id', 'transaction_date', 'transaction_status', 'vnp_response_code', 'bank_code', 'ip_address', 'note'
    ];
}
