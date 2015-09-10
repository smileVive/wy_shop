<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Good;
use App\Models\Brand;
use App\Models\Category;
use Cache;
use App\Models\Type;
use App\Models\Good_attr;


class GoodController extends Controller
{
    private function get_categories()
    {
        $categories = Cache::rememberForever('admin_category_categories', function () {
            $categories = Category::orderBy('parent_id', 'asc', 'sort_order', 'asc', 'id', 'asc')->get();
            return tree($categories);
        });
        return $categories;
    }


    public function index()
    {
        $goods = Good::orderBy('created_at', 'desc')->paginate(config('wyshop.page_size'));
        return view('admin.good.index', ['goods' => $goods]);
    }

    public function create()
    {
        $brands = Brand::orderBy('sort_order')->get();
        $categories = $this->get_categories();

        $types = Type::with('attributes')->get();
        return view('admin.good.create', ['brands' => $brands, 'categories' => $categories, 'types' => $types]);
    }

    public function store(Request $request)
    {

//        return $request->except(['attr_id_list', 'attr_value_list', 'attr_price_list']);
        //新增商品
        $good = Good::create($request->except(['attr_id_list', 'attr_value_list', 'attr_price_list']));

        //增加属性
        foreach ($request->attr_id_list as $k => $v) {
            $good_attr = new Good_attr;
            $good_attr->good_id = $good->id;
            $good_attr->attr_id = $v;
            $good_attr->attr_value = $request->attr_value_list["$k"];
            $good_attr->attr_price = $request->attr_price_list["$k"];
            $good_attr->save();
        }

        return redirect(route('admin.good.index'))->with('info', '添加商品成功');
    }

    public function edit($id)
    {
        $brands = Brand::orderBy('sort_order')->get();
        $categories = $this->get_categories();
        $types = Type::with('attributes')->get();
        $good = Good::with('good_attrs')->find($id);
//        return $good;
        return view('admin.good.edit', ['good' => $good, 'brands' => $brands, 'categories' => $categories, 'types' => $types]);
    }

    public function update(Request $request, $id)
    {
        return $request->all();
    }

    public function destroy($id)
    {
        Good::destroy($id);
        Good_attr::where('good_id', $id)->delete();
        return back()->with('info', '删除分类成功');
    }
}
