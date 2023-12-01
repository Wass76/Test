<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\API\BaseController as BaseController;
use App\Models\User;
use Auth;
use Hash;
use Illuminate\Http\Request;
use Validator;

class RegisterController extends BaseController
{
    public function register(Request $request){
        $validator = Validator::make($request->all(),[
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'required',
            'c_password' => 'required|same:password',
        ]);
        if ($validator->fails()) {
            return $this->sendError('please validate your data' , $validator->errors());
        }

        $input=$request->all();
        $input['password']=Hash::make($input['password']);
        $user=User::create($input);

        $success['token']=$user->createToken('Wassem')->accessToken;
        $success['name']=$user->name;
        return $this->sendResponse($success ,'Registration done successfully');
    }

    /**
     * Summary of login
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse|mixed
     */
    public function login(Request $request){
        if (Auth::attempt(['email' =>  $request->email, 'password' => $request->password])) {
           $user =Auth::user();
           $success['token']=$user->createToken('Wassem')->accessToken;
           $success['name']= $user->name;
           return $this->sendResponse($success ,'user login successfully');
        }
        else{
            return $this->sendError('please check your data' , ['errors' =>'Unauthorized']);
        }
    }


}

