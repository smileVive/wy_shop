<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Good_attr extends Model
{
    //
    public $timestamps = false;

    public function attribute()
    {
        return $this->belongsTo('App\Models\Attribute', 'attr_id');
    }
}
