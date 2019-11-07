<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    protected $table = 'messages';
    public $timestamps = 'true';
    protected $fillable = [
        'user_id',
        'whom_id',
        'message_content',

    ];
    public function notification()
    {
        return $this->hasMany('App\Model\Notification', 'notification_type', 'id');
    }
}
