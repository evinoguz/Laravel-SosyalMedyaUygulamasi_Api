<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;
use App\User;
class RegisterController extends Controller
{
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_name' => 'required|unique:users',
            'name'=>'required|min:3',
            'surname'=>'required|min:3',
            'gender'=>'required|in:0,1',
            'birthdate'=>'required|date_format:d/m/Y',
            'email'=>'required|email|min:5|unique:users',
            'password'=>'required|min:6',
            'c_password' => 'required|same:password',
        ]);
        if($validator->fails())
        {
            $errors=array();
            $i=0;
            foreach ($validator -> errors()->messages() as $key=>$value)
            {
                $i+=1;
                $errors[]=[
                    'field'=>$key,
                    $i.'.'.'messages'=>$value[0],
                ];
            }
            return Response()->json([
                "result"=>"error",
                "errors"=>$errors,
            ]);
        }
        $users = new User();
        $users->user_name = $request->user_name;
        $users->name = $request->name;
        $users->surname = $request->surname;
        $users->birthdate = $request->birthdate;
        $users->gender = $request->gender;
        $users->email = $request->email;
        $users->password = Hash::make($request->password);
        $users->saveOrFail();

        return Response::json([
            "result" => "ok",
            "message" => "Kayit Basarili",
        ]);

//        $input = $request->all();
//        $input['password'] = bcrypt($input['password']);
//        $user = User::create($input);
//        $token=$user->createToken('MyApp')-> accessToken;
//        $success['name'] =  $user->name;
//        return response()->json([
//            'token'=>$token
//        ], $this-> successStatus);
    }
}
