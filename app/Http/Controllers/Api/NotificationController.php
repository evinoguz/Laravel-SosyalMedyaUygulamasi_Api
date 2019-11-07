<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    public function remove_notification(Request $request){
        $user = Auth::user();
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
        $user = Auth::user();

        $notification = Notification::where('id', $request->id)->first();
        if ($user != null) {
            return response()->json([
                'message' => $notification,
                'user' => $user,
            ]);
        } else {
            return response()->json([
                'error' => 'Unauthorised'
            ]);
        }
    }
}
