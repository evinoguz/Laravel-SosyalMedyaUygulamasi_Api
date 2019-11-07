<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Follow_Follower extends Model
{
    protected $table="follow_followers";
    public $timestamps=true;
    protected $fillable=[
        'follow_id',
        'follower_id',
    ];
    public function notification()
    {
        return $this->hasMany('App\Model\Notification', 'notification_type', 'id');
    }


}
