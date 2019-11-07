<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Comments extends Model
{
    protected $table="comments";
    public $timestamps=true;
    protected $fillable=[
        'post_id',
        'user_id',
        'comment_content',
    ];
    public function notification()
    {
        return $this->hasMany('App\Model\Notification', 'notification_type', 'id');
    }
}
