<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class loginController extends Controller
{
   public function login(){
       if(Auth::attempt(['email' => request('email'), 'password' => request('password')])){
           $user = Auth::user();
           $token =  $user->createToken('MyApp')-> accessToken;

           return response()->json([
               'token' => $token,
               'user'=>$user
           ], $this-> successStatus);
       }
       else{
           return response()->json([
               'error'=>'Unauthorised'
           ], 401);
       }
   }
}
