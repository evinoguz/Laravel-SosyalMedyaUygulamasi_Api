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
        'content',
        'tag_friends',
        'location',
    ];
}
