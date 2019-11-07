<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Message;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;

class MessageController extends Controller
{
    public function create_message(Request $request)
    {
        $user = Auth::user();
        if($user!=null) {
            $message = new Message();
            $message->whom_id = $request->input('whom_id');
            $message->user_id = $request->input('user_id');
            $message->message_content = $request->input('message_content');
            $message->save();
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
        $user = Auth::user();
        $message = Message::where('id', $request->id)->first();
        if($user!=null) {
            $message->delete();
            return response()->json([
                'message' => 'message removed',
                'to_whom'=>$message->whom_id,
                'user' => $user
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
        $user = Auth::user();

        $message = Message::where('id', $request->id)->first();
        if ($user != null) {
            return response()->json([
                'message' => $message->message_content,
                'user' => $user,
                'to_whom' => $message->whom_id,
            ]);
        } else {
            return response()->json([
                'error' => 'Unauthorised'
            ]);
        }
    }
}
