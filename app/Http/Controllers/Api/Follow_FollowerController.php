<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Follow_Follower;
use App\Models\Notification;
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
            $notification=new Notification();
            $follow_true=Follow_Follower::where('follow_id',$user->id)->where('follower_id',$request->follower_id)->first();
//            return Response::json([
//
//                $follow_true->follow_id
//                ]);

            if($follow_true!=null)
            {
                return Response::json([
                    'message'=>'You are following',
                ]);
            }
            else {
                $follow->follow_id = $user->id;
                $follow->follower_id = $request->follower_id;
                $follow->saveOrFail();

                $notification->whom_id = $follow->follow_id;
                $notification->user_id = $follow->follower_id;
                $notification->notification_type = 'followed you';
                $notification->saveOrFail();
                return Response::json([
                    'Follow' => $user->user_name,
                    'Follower' => $request->follower_id,
                ]);
            }
        }
        else
        return Response::json([
            'error' => 'Unauthorised'
        ], 401);

    }
//    public function showFollow(Request $request)
//    {
//        $user =auth('api')->user();
//        $follow=Follow_Follower::where('follow_id',$user->id)->get();
//        if ($user != null)
//        {
//            return Response::json([
//                $follow,
//            ]);
//        }
//    }
//    public function showFollower(Request $request)
//    {
//        $user =auth('api')->user();
//        $follower=Follow_Follower::where('follower_id',$request->follower_id)->get();
//        if ($user != null)
//        {
//            return Response::json([
//                $follower,
//            ]);
//        }
//    }

    public function remove(Request $request)
    {
        $user =auth('api')->user();
        if($user==null)
            return Response::json([
                'message'=>'Not active users',
            ],401);
        else
        {
           $follow=Follow_Follower::find('follower_id',$request->follower_id)->first();
//            if($follow->follow_id = $user->id &  $follow->follower_id = $request->follower_id) {
                $follow->delete();
                return Response::json([
                    'message' => $request->follower_id . '.' . 'follower has been deleted',
                ]);
//            }
//            else
//            {
//                return Response::json([
//                    'message'=>$request->follower_id.'.'.'follower does not exist ',
//                ]);
//            }
        }
    }
}
