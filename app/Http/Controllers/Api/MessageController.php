<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;

use App\Models\Message;
use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;

class MessageController extends Controller
{
    //
    public function create_message(Request $request)
    {
        $user=Auth('api')->user();
        if($user!=null) {
            $message = new Message();
            $message->whom_id = $request->input('whom_id');
            $message->user_id = $user->id;
            $message->message_content = $request->input('message_content');
            $message->save();
            $notification=new Notification();
            $notification->whom_id = $message->user_id;
            $notification->user_id = $message->whom_id;
            $notification->notification_type = 'send you message';
            $notification->save();
            return Response::json([

                'user_id' => $message->user_id,
                'whom_id' => $message->whom_id,
                'message_content' => $message->message_content,

            ]);
        }
        else{
            return response()->json([
                'error'=>'Unauthorised'
            ]);
        }
    }
    public function remove_message(Request $request){

        $user=Auth('api')->user();
        $message = Message::where('id', $request->id)->first();
        if($user!=null) {
            if($message->user_id==$user->id) {
                $message->delete();
                return response()->json([
                    'message' => 'message removed',
                    'mes' => $message,

                ]);
            }else{
                return response()->json([
                    'message' => 'message doesnt exist',
                ]);
            }
        }
        else{
            return response()->json([
                'error'=>'Unauthorised'
            ]);
        }
    }

    public function remove_all(){
        $user=Auth('api')->user();
        if($user!=null) {
            $message = Message::where('user_id', $user->id)->delete();
            return response()->json([
                'message' => 'message removed',
            ]);
        }
        else{
            return response()->json([
                'error'=>'Unauthorised'
            ]);
        }
    }

    public function get_message(Request $request)
    {
        $user=Auth('api')->user();
        $message = Message::where('user_id', $user->id)->get();
        if ($user != null) {
            return response()->json([
                'message' => $message
            ]);
        } else {
            return response()->json([
                'error' => 'Unauthorised'
            ]);
        }
    }
}
