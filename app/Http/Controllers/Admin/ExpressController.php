<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Express;

class ExpressController extends Controller
{
    public function __construct()
    {
        view()->share(['_system' => 'am-in', '_express' => 'am-active']);
    }

    public function index()
    {
        $expresses = Express::orderBy('sort_order', 'asc')->paginate(config('wyshop.page_size'));
        return view('admin.express.index', ['expresses' => $expresses]);
    }


    public function create()
    {
        $expresses = config('wyshop.expresses');
        return view('admin.express.create', ['expresses' => $expresses]);
    }


    public function store(Request $request)
    {
        $expresses = config('wyshop.expresses');
        $name = $expresses["$request->key"];
        $data = array_add($request->all(), 'name', $name);
        Express::create($data);
        return redirect(route('admin.express.index'))->with('info', '新增物流成功~');
    }


    public function show($id)
    {
        //
    }


    public function edit($id)
    {
        $express = Express::find($id);
        $expresses = config('wyshop.expresses');
        return view('admin.express.edit', ['express' => $express, 'expresses' => $expresses]);
    }

    public function update(Request $request, $id)
    {
        $express = Express::find($id);
        $expresses = config('wyshop.expresses');
        $name = $expresses["$request->key"];
        $data = array_add($request->all(), 'name', $name);
        $express->update($data);
        return redirect(route('admin.express.index'))->with('info', '修改物流信息成功');;
    }

    public function destroy($id)
    {
        Express::destroy($id);
        return back()->with('info', '删除物流成功');
    }
}
