<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Company;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class CompanyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
    $company=Company::select('id','name')->get();
    if(is_null($company)){
        return $this->notFoundMsg();
    }else{
     return $this->showMsg($company);
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
    public function store(Request $request)
    {
        $validator=Validator::make($request->all(),[
            'name' => 'required'
        ]);
        if($validator->fails()){
            return response()->json($validator->messages(),401);
        }else{
            DB::beginTransaction();
            try {
                $company=new Company();
                $company->name=$request->name;
                $company->save();
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
       $company=Company::find($id);
       if(is_null($company)){
        return $this->notFoundMsg();
       }else{
        //return $this->showMsg($company);


        try {
            return $this->showMsg($company);
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
    public function update(Request $request, string $id)
    {
        $company=Company::find($id);
        if(is_null($company)){
            return $this->notFoundMsg();
        }else{
            $validator=Validator::make($request->all(),[
                'name'=>'required'
            ]);
            if($validator->fails()){
                return response()->json($validator->messages(),401);
            }else{
             DB::beginTransaction();
             try {
                $company->name=$request->name;
                $company->save();
                DB::commit();
                return $this->updateMsg();
             } catch (\Throwable $e) {
                DB::rollback();
                return $this->errorMsg($e);
             }
            }
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $company=Company::find($id);
        if(is_null($company)){
         return $this->notFoundMsg();
        }else{
            DB::beginTransaction();
            try {
                $company->delete();
               DB::commit();
                return $this->deleteMsg();
            } catch (\Throwable $e) {
                DB::rollback();
                return $this->errorMsg($e);
            }
        }
    }
}
