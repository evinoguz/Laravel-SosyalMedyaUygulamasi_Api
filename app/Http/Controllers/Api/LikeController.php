<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Notification;
use Illuminate\Http\Request;

class LikeController extends Controller
{
    public function create(Request $request){
        $user = Auth::user();
        if($user!=null){
            $like = new LikeModel();
            $like->post_id = $request->id;
            $like->user_id = $user->id;
            $like->save();
            $notification=new Notification();
            $notification->whom_id = $like->post_id;
            $notification->user_id = $like->user_id;
            $notification->notification_type = 'liked your post';
            $notification->save();
            return response()->json([
                'like'=>$like,
                'user'=>$user
            ]);
        }
        return response()->json([
            'error'=>'Unauthorised'
        ], 401);
    }

    public function getLike(Request $request){
        $user = Auth::user();
        if($user!=null){
            $like = $like = LikeModel::where('post_id',$request->id)->where('user_id',$user->id)->first();
            if($like!=null){
                return response()->json([
                    'message'=>'you liked this post',
                    'like'=>$like,
                    'user'=>$user
                ]);
            }
            else{
                return response()->json([
                    'message'=>'you have no like at this post',
                    'user'=>$user
                ]);
            }
        }
        return response()->json([
            'error'=>'Unauthorised'
        ], 401);
    }

    public function delete(Request $request){
        $user = Auth::user();
        if($user!=null){
            $like = LikeModel::where('post_id',$request->id)->where('user_id',$user->id)->first();
            if($like !=null){
                $like->delete();
                return response()->json([
                    'message'=>'like was removed',
                    'user'=>$user
                ]);
            }
            else{
                return response()->json([
                    'message'=>'you have no like at this post',
                    'user'=>$user
                ]);
            }

        }
        return response()->json([
            'error'=>'Unauthorised'
        ], 401);
    }
}
