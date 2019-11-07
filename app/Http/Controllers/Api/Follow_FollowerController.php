<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Follow_Follower;
use App\Models\Notification;
use App\Models\Profile;
use App\User;
use Illuminate\Contracts\Support\Responsable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;

class Follow_FollowerController extends Controller
{
    public function create(Request $request)
    {
        $user=Auth::user();
        if($user==null)
            return Response::json([
                'message'=>'Not active users',
            ]);
        else
            {
                $follow=new Follow_Follower();
                $follow->follow_id=$user->id;
                $follow->folower=$request->id;
                $follow->save();
                $notification=new Notification();
                $notification->whom_id = $follow->follower_id;
                $notification->user_id = $follow->follow_id;
                $notification->notification_type = 'followed you';
                $notification->save();
                return Response::json([
                    'Follow'=>$user->name,
                    'Follower'=>$request->id,
                ]);
            }

    }
    public function remove(Request $request)
    {
        $user=Auth::user();
        if($user==null)
            return Response::json([
                'message'=>'Not active users',
            ]);
        else
        {
            $follow=Follow_Follower::find($request->id);
            if($follow==null)
                return Response::json([
                   'message'=>'You are not already following'
                ]);
            else
            {
                $follow->delete();
                $notification=new Notification();
                $notification->whom_id = $follow->follower_id;
                $notification->user_id = $follow->follow_id;
                $notification->notification_type = 'unfollowed you';
                $notification->save();
            }

        }
    }
}
