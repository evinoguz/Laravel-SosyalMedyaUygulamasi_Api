<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Follow_Follower;
use App\Models\Notification;
use App\Models\Post;
use App\Models\Profile;
use App\User;
use Illuminate\Contracts\Support\Responsable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;

class Follow_FollowerController extends Controller
{
    public function create(Request $request)
    {
        $user =auth('api')->user();
        if ($user != null) {
            $validator = Validator::make($request->all(), [
                'follower_id'=>'required',
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

            $follow=new Follow_Follower();
            $follow->follow_id=$user->id;
            $follow->follower_id=$request->follower_id;
            $follow->saveOrFail();

            $notification=new Notification();
            $notification->whom_id = $follow->follow_id;
            $notification->user_id = $follow->follower_id;
            $notification->notification_type = 'followed you';
            $notification->saveOrFail();
            return Response::json([
                'Follow'=>$user->user_name,
                'Follower'=>$request->follower_id,
            ]);
        }
        return Response::json([
            'error' => 'Unauthorised'
        ], 401);

    }
    public function showFollow_Follower(Request $request)
    {
        $user =auth('api')->user();
        $follow=Follow_Follower::where('follow_id',$user->id)->get();
        if ($user != null)
        {
            return Response::json([
                $follow,
            ],);
        }
    }


    public function remove(Request $request)
    {
        $user =auth('api')->user();
        if($user==null)
            return Response::json([
                'message'=>'Not active users',
            ],401);
        else
        {
            $follow=Follow_Follower::find($request->follower_id);
            $notification=Notification::find('user_id',$user->id);
            if($follow==null)
                return Response::json([
                    'message'=>'There is not Follow',
                ]);
            else
            {
                if($follow->user_id==$user->id)
                {
                    if($notification->user_id==$user->id)
                    {
                    $follow->delete();
                    $notification->delete();
                    return Response::json([
                        'message'=>$request->follower_id.'.'.'follower has been deleted',
                    ]);
                    }
                }
                else
                {
                    return Response::json([
                        'message'=>$request->follower_id.'.'.'number follower does not exist ',
                    ]);
                }
            }
        }
    }
}
