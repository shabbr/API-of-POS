<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Product;
use App\Models\Customer;

class Cart extends Model
{
    use HasFactory;
    public function products(){
        return $this->belongsTo(Product::class);
    }
    public function customers(){
        return $this->belongsTo(Customer::class);
    }
}

