<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Profile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;

class ProfileController extends Controller
{
    public function get_profile(Request $request)
    {
        $user=Auth::user();
        $profile=Profile::find($request->id);
        if($user==null)
        return Response::json([
            'message'=>'Not active users',
        ]);

        else
        {
            return Response()->json([
                'id'=>$profile->id,
                'user_id'=>$user->id,
                'img_url'=>$profile->img_url,
                'biography'=>$profile->biography,
            ]);
        }

    }
    public function edit_profile(Request $request)
    {
        $user=Auth::user();
        $profile=Profile::find($request->id);
        if($user==null)
            return Response::json([
                'message'=>'Not active users',
            ]);

        else
        {
            $profile->id=$request->id;
            $profile->user_id=$user->id;
            $profile->img_url=$request->img_url;
            $profile->biography=$request->biography;
            $profile->save();

            return Response()->json([
                'id'=>$request->id,
                'user_id'=>$user->id,
                'img_url'=>$request->img_url,
                'biography'=>$request->biography,
            ]);
        }

    }
}
