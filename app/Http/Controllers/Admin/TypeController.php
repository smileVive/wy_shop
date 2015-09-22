<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Type;

class TypeController extends Controller
{
    public function __construct()
    {
        view()->share(['_good' => 'am-in', '_type' => 'am-active']);
    }

    public function index()
    {
        $types = Type::with('attributes')->paginate(config('wyshop.page_size'));
        return view('admin.type.index', ['types' => $types]);
    }

    public function create()
    {
        return view('admin.type.create');
    }

    public function store(Request $request)
    {
        Type::create($request->all());
        return redirect(route('admin.type.index'));
    }

    public function edit($id)
    {
        $type = Type::find($id);
        return view('admin.Type.edit', ['type' => $type]);
    }

    public function update(Request $request, $id)
    {
        $type = Type::find($id);
        $type->update($request->all());
        return redirect(route('admin.type.index'));
    }

    public function destroy($id)
    {
        Type::destroy($id);
        return back();
    }
}
