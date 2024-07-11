<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\User;

class WpProduct extends Model
{
    protected $table = 'wp_products';

    // Define the fillable attributes for mass assignment
    protected $fillable = [
        'name',
        'description',
        'short_description',
        'regular_price',
        'sale_price',
        'sku',
        'stock_status',
        'igi_certificate',
        'main_photo',
        'photo_gallery',
        'category_id',
        'quantity',
        'vendor_id'
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }


    /**
     * Get the attributes for the product.
     */
    public function attributes()
    {
        return $this->hasMany(ProductAttribute::class, 'product_id');
    }

    public function vendor()
    {
        return $this->belongsTo(User::class, 'vendor_id');
    }


    public static function getAllProduct(){
//        return WpProduct::with(['attributes','vendor' , 'category'])->orderBy('id','desc')->paginate(10);
        // show only product whose vendor_id is equal to the logged in user id
        return WpProduct::with(['attributes','vendor' , 'category'])->where('vendor_id', auth()->id())->orderBy('id','desc')->paginate(10);
    }

}
