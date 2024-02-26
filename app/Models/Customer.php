<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Cart;
use App\Models\Order;
class Customer extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $dates = ['deleted_at'];
    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'gender',
        'phone',
    ];
    public function carts()
    {
        return $this->hasMany(Cart::class);
    }
    // public function order()
    // {
    //     return $this->hasMany(Order::class);
    // }
}
