<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    //
    public function remove_notification(Request $request){
        $user=Auth('api')->user();
        $notification = Notification::where('id', $request->id)->first();
        if($user!=null) {
            $notification->delete();
            return response()->json([
                'message' => 'notification removed',
                'user' => $user
            ]);
        }
        else{
            return response()->json([
                'error'=>'Unauthorised'
            ]);
        }
    }

    public function get_notification(Request $request)
    {
        $user=Auth('api')->user();

        $notification = Notification::where('user_id', $user->id)->get();
        if ($user != null) {
            return response()->json([
                'message' => $notification,
            ]);
        } else {
            return response()->json([
                'error' => 'Unauthorised'
            ]);
        }
    }
}
