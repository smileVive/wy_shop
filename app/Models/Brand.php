<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Brand extends Model
{
    //黑名单为空
    protected $guarded = [];

    //一个品牌有多个商品
    public function goods()
    {
        return $this->hasMany('App\Models\Good');
    }
}
