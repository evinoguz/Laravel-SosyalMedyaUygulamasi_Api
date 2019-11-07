<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;
use App\User;
use Illuminate\Support\Facades\Validator;
class PostController extends Controller
{
    public function create(Request $request)
    {
        $user = Auth::user();
        if ($user != null) {
            $validator = Validator::make($request->all(), [
                'img_url'=>'required',
//                'content'=>'',
//                'tag_friends'=>'',
//                'location'=>'',
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

            $post=new Post();
            $post->user_id=$user->id;
            $post->img_url=$request->img_url;
            $post->contents=$request->contents;
            $post->tag_friends=$request->tag_friends;
            $post->location=$request->location;
            $post->saveOrFail();

            return Response()->json([
                "result" => "ok",
                "message" => "Kayit Basarili",
            ]);
        }
        return response()->json([
            'error' => 'Unauthorised'
        ], 401);
    }

    public function remove(Request $request)
    {
        $user=auth::user();
        if($user==null)
            return Response()->json([
                'message'=>'Not active users',
            ],401);
        else
        {
            $post=Post::find($request->post_id);
            if($post==null)
            return Response()->json([
                'message'=>'There is not post',
            ]);
            else
            {
                $post->delete();
                return Response()->json([
                    'message'=>$request->post_id.'.'.'post has been deleted',
                ]);
            }
        }
    }
    public function updatePost(Request $request){
        $user= Auth::user();
        if($user!=null){
            $post = Post::find($request->post_id);
            $post->id=$request->id;
            $post->user_id=$request->$user->id;
            $post->img_url=$request->img_url;
            $post->contents=$request->contens;
            $post->tag_friends=$request->tag_friends;
            $post->location=$request->location;
            return Response()->json([
                'id'=>$request->id,
                'user_id'=>$request->$user->id,
                'img_url'=>$request->img_url,
                'contents'=>$request->contents,
                'tag_friends'=>$request->tag_friends,
                'location'=>$request->loction,
            ]);
        }
    }
}
