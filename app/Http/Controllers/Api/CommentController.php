<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Comments;
use App\Models\Notification;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CommentController extends Controller
{
    public function create(Request $request){
        $user=Auth('api')->user();
        if($user!=null){
            $validator = Validator::make($request->all(),[
                'post_id' => 'required',
                'comment_content' => 'required'
            ]);
            if ($validator->fails()) {
                return response()->json([
                    'error'=>$validator->errors()
                ], 401);
            }

            $comment = new Comments();
            $comment->user_id = $user->id;
            $comment->post_id = $request->post_id;
            $comment->comment_content = $request->comment_content;
            $comment->save();

            $post=Post::find($request)->first();
            $notification=new Notification();
            $notification->whom_id = $comment->user_id;
            $notification->user_id = $post->user_id;
            $notification->notification_type = 'commented on your post';
            $notification->save();
            return response()->json([
                'message'=>'comment was created',
                'user'=>$user,
            ]);
        }
        return response()->json([
            'error'=>'Unauthorised'
        ], 401);
    }

    public function getComments(Request $request){
        $comments = Comments::where('post_id', $request->post_id)->get();
        if($comments!=null){
            return response()->json([
                'comments'=>$comments,
                'post_id'=>$request->post_id
            ]);
        }
        return response()->json([
            'message'=>'there is no post with this id '.$request->post_id,
        ]);
    }

    public function delete(Request $request){
        $user=Auth('api')->user();
        if($user!=null){
            $comment = Comments::find($request->id);
            if($comment!=null){
                $comment->delete();
                return response()->json([
                    'message'=>'comment was deleted',
                    'user'=>$user
                ]);
            }
            return response()->json([
                'message'=>'there is no comment with id '.$request->id,
                'user'=>$user
            ]);
        }
        else{
            return response()->json([
                'error'=>'Unauthorised'
            ], 401);
        }
    }

    public function updateComment(Request $request){
        $user=Auth('api')->user();
        if($user!=null){
            $validator = Validator::make($request->all(),[
                'post_id' => 'required',
                'comment_content' => 'required'
            ]);
            if ($validator->fails()) {
                return response()->json([
                    'error'=>$validator->errors()
                ], 401);
            }

            $comment = Comments::find($request->id);
            if($comment!=null){
                $comment->user_id = $user->id;
                $comment->post_id = $request->post_id;
                $comment->comment_content = $request->comment_content;

                $comment->save();
                return response()->json([
                    'message'=>'comment was updated',
                    'user'=>$user
                ]);
            }
            return response()->json([
                'message'=>'you have no comment with id '.$request->id,
                'user'=>$user
            ]);
        }
        return response()->json([
            'error'=>'Unauthorised'
        ], 401);
    }
}
