<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'code', 'sku', 'name', 'description', 'category', 'brand',
        'cost', 'pvp1', 'pvp2', 'pvp3', 'pvp4', 'pvp5', 'pvp6',
        'stock', 'min_stock', 'is_active',
        'available_local', 'available_whatsapp', 'available_online',
        'woocommerce_status', 'image_path'
    ];
}
