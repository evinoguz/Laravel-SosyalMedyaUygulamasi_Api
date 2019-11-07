<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $table='posts';
    public $timestamps='true';
    protected $fillable=[
        'user_id',
        'img_url',
        'contents',
        'tag_friends',
        'location',
    ];
    public function likes(){
        return $this->hasMany('app\Models\Likes','post_id','id');
    }
    public function comment(){
        return $this->hasMany('app\Models\Comments','post_id','id');
    }

}
