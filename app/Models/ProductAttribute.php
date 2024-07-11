<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductAttribute extends Model
{


    protected $table = 'product_attributes';

      // Define the fillable attributes for mass assignment
      protected $fillable = [
        'product_id',
        'name',
        'value',
    ];

        /**
     * Get the product that owns the attribute.
     */
    public function product()
    {
        return $this->belongsTo(WpProduct::class, 'product_id');
    }


}
