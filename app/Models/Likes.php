<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Likes extends Model
{
    protected $table = "likes";
    public $timestamps = true;
    protected $fillable=[
        'post_id',
        'user_id',
    ];

    public function notification()
    {
        return $this->hasMany('App\Model\Notification', 'notification_type', 'id');
    }
}
