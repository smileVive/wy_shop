<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Brand;

class BrandController extends Controller
{
    //品牌列表
    public function index()
    {
        $brands = Brand::orderBy('sort_order')->paginate(config('wyshop.page_size'));
        return view('admin.brand.index', ['brands' => $brands]);
    }

    //新增品牌
    public function create()
    {
        return view('admin.brand.create');
    }

    public function store(Request $request)
    {
        Brand::create($request->all());
        return redirect(route('admin.brand.index'));
    }

    //修改品牌
    public function edit($id)
    {
        $brand = Brand::find($id);
        return view('admin.brand.edit', ['brand' => $brand]);
    }

    public function update(Request $request, $id)
    {
        $brand = Brand::find($id);
        $brand->update($request->all());
        return redirect(route('admin.brand.index'));
    }

    public function destroy($id)
    {
        Brand::destroy($id);
        return back();
    }


    public function search(Request $request)
    {
        $keyword = $request->keyword."%";
        $brands = Brand::orderBy('sort_order')->where('name', 'like', $keyword)->paginate(config('wyshop.page_size'));

        return view('admin.brand.index', ['brands' => $brands]);
    }

    public function sort(Request $request)
    {
        $brand = Brand::find($request->id);
        $brand->sort_order = $request->sort_order;
        $brand->save();
    }
}