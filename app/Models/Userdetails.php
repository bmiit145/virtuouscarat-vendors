<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\User;

class Userdetails extends Model
{
    use HasFactory;

    protected $fillable = ['user_id','business_name','business_type','bank_name','account_number','ifsc_code','branch_name','gst','communication_address','otp'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
