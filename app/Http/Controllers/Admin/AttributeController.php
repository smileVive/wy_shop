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

    public function create($type_id)
    {
        $types = Type::all();
        return view('admin.attribute.create',['types'=>$types, 'type_id'=>$type_id]);
    }

    public function store(Request $request, $type_id)
    {
        $this->validate($request, [
            'name' => 'required'
        ]);

        Attribute::create($request->all());
        return redirect(route('admin.type.{type_id}.attribute.index', $request->type_id));
    }

    public function edit($type_id, $id)
    {
        $types = Type::all();
        $attribute = Attribute::find($id);
        return view('admin.attribute.edit',['types'=>$types, 'type_id'=>$type_id, 'attribute'=>$attribute]);
    }

    public function update(Request $request, $type_id, $id)
    {
        $attribute = Attribute::find($id);
        $attribute->update($request->all());
        return redirect(route('admin.type.{type_id}.attribute.index', $request->type_id));
    }

    public function destroy($type_id, $id)
    {
        Attribute::destroy($id);
        return back();
    }

}
