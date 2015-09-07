<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Cache;
use App\Models\Category;
use App\Models\Type;
use App\Models\Attribute;

class CategoryController extends Controller
{
    //获取栏目信息
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
//        if (!Cache::has('admin_category_categories')) {
//            $categories = $this->get_categories();
//            Cache::forever('admin_category_categories', $categories);
//        } else {
//            $categories = Cache::get('admin_category_categories');
//        }

        //查询栏目，并存入缓存
        $categories = $this->get_categories();
        return view('admin.category.index', ['categories' => $categories]);
    }

    public function create()
    {
        $categories = $this->get_categories();

        $types = Type::with("attributes")->get();
        return view('admin.category.create', ['categories' => $categories, 'types' => $types]);
    }

    public function store(Request $request)
    {
        Cache::forget('admin_category_categories');        //清除缓存
        $filter_attr = serialize(array_unique($request->filter_attr));     //数组去重复, 序列化

        //数组合并，两种方法都可以用
        //$category = array_merge($request->except('filter_attr'), ['filter_attr' => $filter_attr]);
        $category = array_add($request->except('filter_attr'), 'filter_attr', $filter_attr);
        Category::create($category);

        return redirect(route('admin.category.index'))->with('info', '添加分类成功');
    }

    public function edit($id)
    {
        $categories = $this->get_categories();

        $types = Type::with("attributes")->get();
        $category = Category::find($id);

        //将筛选数据重新插回当前栏目中
        $category->filter_attr = Attribute::with('type.attributes')->whereIn('id', unserialize($category->filter_attr))->get();

        return view('admin.category.edit', ['category' => $category, 'categories' => $categories, 'types'=>$types]);
    }

    public function update(Request $request, $id)
    {
        Cache::forget('admin_category_categories');
        $category = Category::find($id);

        $filter_attr = serialize(array_unique($request->filter_attr));     //数组去重复, 序列化
        $data = array_add($request->except('filter_attr'), 'filter_attr', $filter_attr);

        $category->update($data);
        return redirect(route('admin.category.index'));
    }

    public function destroy($id)
    {
        Cache::forget('admin_category_categories');
        Category::destroy($id);
        return back()->with('info', '删除分类成功');
    }
}
