<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;
    protected function showMsg($receiveData){
       $data=[ 'message' =>'Data Found',
        'status' =>1,
        'data' =>$receiveData
    ];
    return response()->json($data, 200);
}
    protected function insertMsg(){
        $data=[
            'message' => 'data successfully inserted',
            'status' => 1
        ];
        return response()->json($data, 200);
    }
    protected function notFoundMsg(){
        $data=[
            'message' => 'Data not found',
            'status' =>0
        ];
        return response()->json($data,404);
    }
    protected function updateMsg(){
        $data=[
            'message' => 'Data updated successfully',
            'status' =>1
        ];
        return response()->json($data,200);
    }
    protected function deleteMsg(){
        $data=[
            'message' => 'Data deleted successfully',
            'status' =>1
        ];
        return response()->json($data,200);
    }
    protected function errorMsg($e){
        $data=[
            'message' => 'Internal server error',
            'error'  =>$e->getMessage(),
            'status' =>0
        ];
        return response()->json($data,500);
    }
}
