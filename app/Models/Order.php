<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'number', 'total_price', ' paymanet_status', 'payment_url', 'delivery_address',
        'user_id', 'seller_id',
    ];
}
