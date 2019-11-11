<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Models\Profile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;

class ProfileController extends Controller
{
    public function create(Request $request)
    {
        $user =auth('api')->user();

        if ($user != null) {
            $validator = Validator::make($request->all(), [
                'img_url'=>'',
                'biography'=>'',

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
                return Response::json([
                    "result"=>"error",
                    "errors"=>$errors,
                ]);
            }

            $profile=new Profile();
            $profile->user_id=$user->id;
            if($request->has('img_url')){
                $file=$request->img_url;
                $file->move(public_path().'/profile/',$file->getClientOriginalName());
                $profile->img_url='/profile/'.$file->getClientOriginalName();

            }
            $profile->biography=$request->biography;
            $profile->saveOrFail();
            return Response::json([
                "result" => "ok",
                "message" => "Kayit Basarili",
            ]);
        }
        return Response::json([
            'error' => 'Unauthorised'
        ], 401);
    }


    public function updateProfile(Request $request)
    {
        $user = auth('api')->user();
        if ($user == null)
            return Response::json([
                'message' => 'Not active users',
            ], 401);
        else {
            $profile = Profile::where('user_id',$user->id)->first();
            if ($profile == null)
                return Response::json([
                    'message' => 'There is not user',
                ]);
            else {
                    $profile->user_id = $user->id;
                    if ($request->has('img_url')) {
                        if (file_exists(public_path() . $profile->img_url)) {
                            unlink(public_path() . $profile->img_url);
                        }
                        $file = $request->img_url;
                        $file->move(public_path() . '/profile/', $file->getClientOriginalName());
                        $profile->img_url = '/profile/' . $file->getClientOriginalName();
                    }
                    $profile->biography=$request->biography;
                    $profile->saveOrFail();

                    return Response::json([
                        "result" => "ok",
                        "message" => "Kayit Güncellendi",
                        $profile,
                    ]);

            }
        }
    }
}
