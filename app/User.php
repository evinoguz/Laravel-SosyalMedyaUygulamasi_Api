<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, Notifiable;

    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password','birth_day','gender','phone_number'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function getPosts(){
        return $this->hasMany('app\Models\Post','user_id','id');
    }
    public function getMessages(){
        return $this->hasMany('app\Models\Message','user_id','id');
    }
    public function getNotification(){
        return $this->hasMany('app\Models\Notification','user_id','id');
    }
    public function getLikes(){
        return $this->hasMany('app\Models\Likes','user_id','id');
    }
    public function getProfile(){
        return $this->hasMany('app\Models\Profile','user_id','id');
    }
    public function getMessage(){
        return $this->hasMany('app\Models\Message','user_id','id');
    }


}
