<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\User;

class loginController extends Controller
{
   public function login(){
       if(Auth::attempt(['email' => request('email'), 'password' => request('password')])){
           $user = Auth::user();
           $success['token'] =  $user->createToken('AppName')-> accessToken;
           return response()->json(['success' => $success], 200);
       } else{
           return response()->json(['error'=>'Unauthorised'], 401);
       }
//       if(Auth::attempt(['email' => request('email'), 'password' => request('password')])){
//           $user = Auth::user();
//          // $token =  $user->createToken('MyApp')-> accessToken;
//
//           return response()->json([
//             //  'token' => $token,
//               'user'=>$user
//           ], $this-> successStatus);
//       }
//       else{
//           return response()->json([
//               'error'=>'Unauthorised'
//           ], 401);
//       }
   }
}
