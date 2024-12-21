<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class WpOrderProduct extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'order_id',
        'product_id',
        'is_fullfilled',
        'sku',
        'quantity',
        'price',
        'total',
        'meta_data',
    ];

    public function order()
    {
        return $this->belongsTo(WpOrder::class, 'order_id', 'order_id');
    }

    public function product()
    {
        return $this->belongsTo(WpProduct::class, 'product_id', 'wp_product_id');
    }
}
