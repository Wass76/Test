<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request\API;
use Illuminate\Http\Request;
use  App\Http\Controllers\Controller as Controller;

class BaseController extends Controller
{
    public function sendResponse($result ,$messege){
     $response=[
        'success' => true,
        'data' => $result,
        'messege' => $messege,
     ];
     return response()->json($response , 200);
    }

    public function sendError($error ,$Errormessege=[] , $code = 404){
        $response=[
           'success' => false,
           'data' => $error,
        ];
        if(!empty($Errormessege)){
            $response['data']= $Errormessege;
        }
        return response()->json($response , $code);
       }
}
