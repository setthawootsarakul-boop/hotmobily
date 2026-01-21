<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CartItem extends Model
{
    use HasFactory;
    
    protected $table = 'cart_items'; 

    protected $fillable = [
        'session_id',
        'user_id',
        'product_id',
        'options',
        'quantity',
    ];

    protected $casts = [
        'options' => 'array',
    ];
}