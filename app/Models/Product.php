<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $table = 'products';

    protected $fillable = [
        'asin',
        'image',
        'reg_price',
        'price',
        'pro',
        'tar_price',
        'in_stock',
        'user_id',
        'machine_id',
        'is_notified',
        'url',
        'error',
    ];
}
