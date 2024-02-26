<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Cart;
use App\Models\Product;
use App\Models\Order;
use App\Models\Customer;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $orders = Order::join('customers', 'customers.id', '=', 'orders.customerId')
        ->select(
            'customers.first_name',
            'customers.last_name',
            'orders.customerId',
            DB::raw('SUM(orders.qty) as total_qty'),
            DB::raw('SUM(orders.totalPrice) as total_price')
        )
        ->groupBy('customers.id', 'orders.orderCode' , 'orders.customerId', 'customers.first_name', 'customers.last_name')
        ->get();
        return response()->json($orders, 200);
    }

    //show details
    public function details(Request $request)
    {
        $orderCode = $request->orderCode;
        $orderDetails = Order::join('products', 'products.id', '=', 'orders.productId')
            ->join('customers', 'customers.id', '=', 'orders.customerId')
            ->select(
                'customers.first_name',
                'products.id',
                'products.name',
                'products.salePrice',
                'orders.qty',
                'orders.totalPrice'
            )
            ->where('orderCode', '=', $orderCode)
            ->groupBy('products.id','customers.first_name', 'orders.orderCode', 'products.name', 'products.salePrice', 'orders.qty', 'orders.totalPrice')
            ->get();
        return response()->json($orderDetails, 200);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
         $carts=Cart::get();
        $last=Order::latest()->first();
        if($last){
        $orderCode= $last->id;
        }else{
            $orderCode=1;
        }
         try {
            foreach($carts as $cart){
                $product=Product::find($cart->product_id);
            $order=new Order;
                $order->customerId=$cart->customer_id;
                $order->productId=$cart->product_id;
                $order->qty=$cart->qty;
                $order->orderCode=$orderCode;
                $order->totalPrice=$cart->totalPrice;
                $order->save();
                $product->qty-=$cart->qty;
                $product->save();
                $cart->delete();
         }

         DB::commit();
         return $this->insertMsg();
         }
         catch (\Throwable $e) {
           DB::rollback();
           return $this->errorMsg($e);
         }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

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
    public function update(Request $request, string $id)
    {

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        $item=Order::find($request->id);
       if(is_null($item)){
              return $this->notFoundMsg();
          }else{
          DB::beginTransaction();
          try {
              $item->delete();
              DB::commit();
              return $this->deleteMsg();
          } catch (\Throwable $e) {
            DB::rollback();
            return $this->errorMsg($e);
          }
      }
    }
}
