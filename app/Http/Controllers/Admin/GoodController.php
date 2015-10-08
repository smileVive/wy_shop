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
use App\Models\Good_gallery;


class GoodController extends Controller
{
    public function __construct()
    {
        view()->share(['_good' => 'am-in', '_goods' => 'am-active']);
    }

    private function get_categories()
    {
        $categories = Cache::rememberForever('wyshop_admin_category_categories', function () {
            $categories = Category::orderBy('parent_id', 'asc')->orderBy('sort_order', 'asc')->orderBy('id', 'asc')->get();
            return tree($categories);
        });
        return $categories;
    }

    public function index()
    {
        $goods = Good::with('category')->orderBy('created_at', 'desc')->paginate(config('wyshop.page_size'));
        return view('admin.good.index', ['goods' => $goods]);
    }

    public function create()
    {
        $brands = Brand::orderBy('sort_order')->get();
        $categories = $this->get_categories();

        $types = Type::with('attributes')->get();
        return view('admin.good.create', ['brands' => $brands, 'categories' => $categories, 'types' => $types, '_new_good' => 'am-active', '_goods' => '']);
    }

    public function store(Request $request)
    {
        $messages = [
            'name.required' => '商品名称不能为空！',
            'category_id.required' => '商品分类不能为空！'
        ];
        $this->validate($request, [
            'name' => 'required',
            'category_id' => 'required'
        ], $messages);

        //新增商品
        $good = Good::create($request->except(['imgs', 'attr_id_list', 'attr_value_list', 'attr_price_list']));

        //增加属性
        if ($request->attr_id_list) {
            foreach ($request->attr_id_list as $k => $v) {
                $good_attr = new Good_attr;
                $good_attr->good_id = $good->id;
                $good_attr->attr_id = $v;
                $good_attr->attr_value = $request->attr_value_list["$k"];
                $good_attr->attr_price = $request->attr_price_list["$k"];
                $good_attr->save();
            }
        }

        //商品相册
        if ($request->imgs) {
            foreach ($request->imgs as $img) {
                $good_gallery = new Good_gallery();
                $good_gallery->good_id = $good->id;
                $good_gallery->img = $img;
                $good_gallery->save();
            }
        }

        return redirect(route('admin.good.index'))->with('info', '添加商品成功');
    }

    public function edit($id)
    {
        $brands = Brand::orderBy('sort_order')->get();
        $categories = $this->get_categories();
        $types = Type::with('attributes')->get();
        $good = Good::with('good_attrs', 'good_galleries')->find($id);
//        return $good;
        return view('admin.good.edit', ['good' => $good, 'brands' => $brands, 'categories' => $categories, 'types' => $types]);
    }

    public function update(Request $request, $id)
    {
        $messages = [
            'name.required' => '商品名称不能为空！',
            'category_id.required' => '商品分类不能为空！'
        ];
        $this->validate($request, [
            'name' => 'required',
            'category_id' => 'required'
        ], $messages);

        $good = Good::find($id);

        $result = $request->except(['imgs', 'attr_id_list', 'attr_value_list', 'attr_price_list']);
        //如果checkbox未选中，设置为false
        $result = isset($request->best) ? $result : array_add($result, 'best', false);
        $result = isset($request->new) ? $result : array_add($result, 'new', false);
        $result = isset($request->hot) ? $result : array_add($result, 'hot', false);
        $result = isset($request->onsale) ? $result : array_add($result, 'onsale', false);

        $good->update($result);

        //增加属性
        if ($request->attr_id_list) {
            //先删除原有属性
            Good_attr::where('good_id', $id)->delete();
            foreach ($request->attr_id_list as $k => $v) {
                $good_attr = new Good_attr;
                $good_attr->good_id = $good->id;
                $good_attr->attr_id = $v;
                $good_attr->attr_value = $request->attr_value_list["$k"];
                $good_attr->attr_price = $request->attr_price_list["$k"];
                $good_attr->save();
            }
        }

        //商品相册
        if ($request->imgs) {
            foreach ($request->imgs as $img) {
                $good_gallery = new Good_gallery();
                $good_gallery->good_id = $good->id;
                $good_gallery->img = $img;
                $good_gallery->save();
            }
        }

        return redirect(route('admin.good.index'))->with('info', '编辑商品成功');
    }

    public function destroy($id)
    {
        Good::destroy($id);
        Good_attr::where('good_id', $id)->delete();
        return back()->with('info', '删除分类成功');
    }

    //商品回收站
    public function trash()
    {
        $goods = Good::onlyTrashed()->paginate(config('wyshop.page_size'));
        return view('admin.good.trash', ['goods' => $goods, '_trash' => 'am-active', '_goods' => '']);
    }

    public function restore($id)
    {
        $good = Good::withTrashed()->find($id);
        $good->restore();
        return back()->with('info', '还原成功');
    }

    public function force_destroy($id)
    {
        $good = Good::withTrashed()->find($id);
        $good->forceDelete();
        return back()->with('info', '删除成功');
    }
}