<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    protected $table = 'notification';
    public $timestamps = 'true';
    protected $fillable = [
        'user_id',
        'whom_id',
        'notification_type',
        ];
}
