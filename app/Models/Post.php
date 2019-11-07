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
    public function comments()
    {
        return $this->HasMany(Comments::class, 'id','post_id');
    }
    public function likes()
    {
        return $this->HasMany(Likes::class, 'id','post_id');
    }
}
