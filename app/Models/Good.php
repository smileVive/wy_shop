<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;

class Good extends Model
{
    protected $guarded = [];

    //每个商品都属于某一个品牌
    public function brand()
    {
        return $this->belongsTo('App\Models\Brand');
    }

    //每个商品都属于某一个分类
    public function category()
    {
        return $this->belongsTo('App\Models\Category');
    }

    //一个商品有很多属性
    public function good_attrs()
    {
        return $this->hasMany('App\Models\Good_attr');
    }
}
