<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Cart;
use App\Models\Product;
use App\Models\Customer;
use Illuminate\Support\Facades\DB;
use App\Models\Two;
use App\Http\Requests\CartDeleteRequest;

class CartController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
         $cartItems = Cart::join('products', 'carts.product_id', '=', 'products.id')
            ->join('customers', 'carts.customer_id', '=', 'customers.id')
            ->select('carts.*',
             'products.name as product_name',
             'products.code as product_code','products.salePrice as salePrice',
             'products.purchasePrice as purchasePrice','products.qty as product_quantity',
              'customers.first_name as first_name',
              'customers.last_name as last_name',
              'customers.email as email',
              'customers.phone as phone')
            ->get();
        return response()->json($cartItems, 200);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
$pId=$request->productId;
$product=Product::find($pId);
$productPrice=$product->salePrice;
$qty=$request->qty;
$totalPrice=$productPrice*$qty;
$cartItem=Cart::select('id','customer_id','product_id','qty','totalPrice')
                ->where('customer_id',$request->customer_id)
                ->where('product_id',$pId)
                ->first();
                DB::beginTransaction();
                if($cartItem){
                    $cart=Cart::find($cartItem->id);
                    $cart->qty=$cart->qty+$qty;
                    $cart->totalPrice+=$totalPrice;
                      $cart->save();
                    DB::commit();
                    return response()->json($cart, 200);
                }else{

 try {


    $cart=new Cart;
        $cart->customer_id=$request->customerId;
        $cart->product_id=$pId;
        $cart->qty=$qty;
        $cart->totalPrice=$totalPrice;
        $cart->save();
        DB::commit();
       return $this->insertMsg();
 } catch (\Throwable $e) {
   DB::rollback();
   return $this->errorMsg($e);
 }

                }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CartUpdateRequest $request)
    {
           $cartItem=Cart::find($request->id);
           if(is_null($cartItem)){
            return $this->notFoundMsg();
        }else{
            DB::beginTransaction();
       try {
        $cartItem->qty=$request->qty;
        $cartItem->save();
        DB::commit();
        return $this->updateMsg();
       } catch (\Throwable $e) {
        DB::rollback();
        return $this->errorMsg($e);
       }
    }
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(CartDeleteRequest $request)
    {
        $cartItem=Cart::find($request->id);
        if(is_null($cartItem)){
            return $this->notFoundMsg();
        }else{
        DB::beginTransaction();
        try {
            $cartItem->delete();
            DB::commit();
            return $this->deleteMsg();
        } catch (\Throwable $e) {
          DB::rollback();
          return $this->errorMsg($e);
        }
    }
    }
}
