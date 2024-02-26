<?php
namespace App\Http\Controllers\api;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use App\Models\Product;
use App\Models\Company;
use App\Http\Requests\ProductRequest;
use App\Http\Requests\ProductUpdateRequest;
use App\Http\Requests\ProductSearchRequest;
class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
          $products=Product::with('company')->get();
          if(is_null($products)){
            return $this->notFoundMsg();
          }else{
          return $this->showMsg(['product'=>$products]);
          }
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
    public function store(ProductRequest $request)
    {
            DB::beginTransaction();
            try {
                $product=new Product();
                $product->company_id=$request->companyId;
                $product->name=$request->name;
                $product->purchasePrice=$request-> purchasePrice;
                $product->salePrice=$request-> salePrice;
                $product->code=$request-> code;
                $product->qty=$request->qty ;
                $product->save();
                DB::commit();
                return $this->insertMsg();
            } catch (\Throwable $e) {
             DB::rollback();
             return $this->errorMsg($e);
            }
    }

    /**
     * Display the specified resource.
     */
    public function show(ProductSearchRequest $request)
    {
        $id=$request->id;
        $product=Product::find($id);
        $productCompany=$product->company->name;
        if(is_null($product)){
            return $this->notFoundMsg();
        }else{
       try {
        return $this->showMsg(['product'=>$product,'company'=>$productCompany]);
       } catch (\Throwable $e) {
        return $this->errorMsg($e);
       }
        }
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
    public function update(ProductUpdateRequest $request)
    {

        $product=Product::find($request->id);
        if(is_null($product)){
            return $this->notFoundMsg();
        }else{
        DB::beginTransaction();
        try {
            $product->company_id=$request->companyId;
            $product->name=$request->name;
            $product->purchasePrice=$request-> purchasePrice;
            $product->salePrice=$request-> salePrice;
            $product->qty=$request->qty ;
            $product->save();
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
    public function destroy(ProductSearchRequest $request)
    {
        $product=Product::find($request->id);
        if(is_null($product)){
            return $this->notFoundMsg();
        }else{
        DB::beginTransaction();
        try {
            $product->delete();
            DB::commit();
            return $this->deleteMsg();
        } catch (\Throwable $e) {
          DB::rollback();
          return $this->errorMsg($e);
        }
    }
}
}
