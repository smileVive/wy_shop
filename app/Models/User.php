<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    //一个用户有很多评论
    public function comments()
    {
        return $this->hasMany('App\Models\Comment');
    }
}
