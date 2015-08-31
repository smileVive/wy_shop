<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Type;
use App\Models\Attribute;

class AttributeController extends Controller
{
    public function index($type_id)
    {
        $types = Type::all();
        $attributes = Attribute::with('type')->where('type_id', $type_id)->paginate(config('wyshop.page_size'));
        return view('admin.attribute.index', ['types'=>$types, 'type_id'=>$type_id, 'attributes'=>$attributes]);
    }


    public function destroy($type_id, $id)
    {
        Attribute::destroy($id);
        return back();
    }

}
