<?php

namespace App\Http\Controllers\api;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\CustomerRequest;
use App\Http\Requests\CustomerUpdateRequest;
use App\Models\Customer;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $customers=Customer::select('id','first_name','last_name','gender','email','phone')->get();
        if(is_null($customers)){
            return $this->notFoundMsg();
        }else{
            return response()->json($customers, 200);
        }

        // return $this->success();
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
    public function store(CustomerRequest $request)
    {

 $data=[
    "first_name"=>$request->fname,
    "last_name"=>$request->lname,
       "gender"=>$request->gender,
       "email"=>$request->email,
       "phone"=>$request->phone,
 ];
 DB::beginTransaction();
 if($data){
    $user=Customer::create($data);
    DB::commit();
      return $this->insertMsg();
    }else{
        DB::rollback();
        return $this->errorMsg();
    }

}

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $customer=Customer::find($id);
        if(is_null($customer)){
            return $this->notFoundMsg();
        }else{
            return $this->showMsg($customer);
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
   public function update(CustomerUpdateRequest $request, string $id)
  {
        $customer=Customer::find($id);
        if(is_null($customer)){
            return $this->notFoundMsg();
        }
        else{
            DB::beginTransaction();
              try {
                $customer->first_name=$request->fname;
                $customer->last_name=$request->lname;
                $customer->gender=$request->gender;
                $customer->email=$request->email;
                $customer->phone=$request->phone;
                  $customer->save();
                  DB::commit();
                  //rollback() never working by this line
                  //return $this->update();
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
    public function destroy(string $id)
    {
        $customer=Customer::find($id);
        if(is_null($customer)){
            return $this->notFoundMsg();
        }else{
            DB::beginTransaction();
            try {
             $customer->delete();
              DB::commit();
              return $this->deleteMsg();
            } catch (\Throwable $e) {
                DB::rollback();
                return $this->errorMsg($e);
            }
        }
    }

    public function restore(Request $request){
       // $restoreId=$request->restoreId;
      $customer=Customer::withTrashed()->get();

  return response()->json( $customer, 200);
    }

}
