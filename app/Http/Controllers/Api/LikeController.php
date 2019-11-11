<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Likes;
use App\Models\Notification;
use App\Models\Post;
use Illuminate\Http\Request;

class LikeController extends Controller
{
    public function create(Request $request){
        $user=Auth('api')->user();
        if($user!=null){
            $like = new Likes();
            $like->post_id = $request->input('post_id');
            $like->user_id = $user->id;
            $like->save();

            $post=Post::find($request)->first();
            $notification=new Notification();
            $notification->whom_id = $like->user_id;
            $notification->user_id =$post->user_id;
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
        $user=Auth('api')->user();
        if($user!=null){
            $like = Likes::where('user_id', $user->id)->get();
            if($like!=null){
                return response()->json([
                    'message'=>'you liked this post',
                    'like'=>$like,
                    'user'=>$user,
                ]);
            }
            else{
                return response()->json([
                    'message'=>'you have no like at this post',
                    'user'=>$user,
                ]);
            }
        }
        return response()->json([
            'error'=>'Unauthorised'
        ], 401);
    }

    public function delete(Request $request){
        $user=Auth('api')->user();
        if($user!=null){
            $like = Likes::where('id', $request->id)->first();
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
