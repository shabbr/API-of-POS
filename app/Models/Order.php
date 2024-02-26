<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Product;
use App\Models\Customer;
class Order extends Model
{
    use HasFactory;
    public function products(){
        return $this->belongsToMany(Product::class);
    }
    public function customers(){
        return $this->belongsToMany(Customer::class);
    }
}



