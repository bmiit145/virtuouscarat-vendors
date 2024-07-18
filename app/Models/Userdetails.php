<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Userdetails extends Model
{
    use HasFactory;

    protected $fillable = ['user_id','business_name','business_type','bank_name','account_number','ifsc_code','brand_name','gst','otp'];
}
