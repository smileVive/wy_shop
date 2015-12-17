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
    public function __construct()
    {
        view()->share(['_good' => 'am-in', '_category' => 'am-active']);

    }

    //获取栏目信息
    private function get_categories()
    {
//        if (!Cache::has('wyshop_admin_category_categories')) {
//            $categories = Category::orderBy('parent_id', 'asc')->orderBy('sort_order', 'asc')->orderBy('id', 'asc')->get();
//            Cache::forever('wyshop_admin_category_categories', tree($categories));
//        }
//        return Cache::get('wyshop_admin_category_categories');


        $categories = Cache::rememberForever('wyshop_admin_category_categories', function () {
            $categories = Category::orderBy('parent_id', 'asc')->orderBy('sort_order', 'asc')->orderBy('id', 'asc')->get();
            return tree($categories);
        });
        return $categories;
    }


    public function index()
    {
        //查询栏目，并存入缓存


//        $categories = Category::orderBy('parent_id', 'asc')->orderBy('sort_order', 'asc')->orderBy('id', 'asc')->get();

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


        Cache::forget('wyshop_admin_category_categories');        //清除缓存
        //判断是否为空，数组去重复, 序列化
        $filter_attr = $request->filter_attr == "" ? "" : serialize(array_unique($request->filter_attr));
        //合并数组
        $category = array_add($request->except('filter_attr'), 'filter_attr', $filter_attr);
        return $category;

        Category::create($category);
        return redirect(route('admin.category.index'))->with('info', '添加分类成功');
    }

    public function edit($id)
    {
        $categories = $this->get_categories();
        $types = Type::with("attributes")->get();
        $category = Category::find($id);

        //将筛选数据重新插回当前栏目中
        if ($category->filter_attr) {
            $category->filter_attr = Attribute::with('type.attributes')->whereIn('id', unserialize($category->filter_attr))->get();
        }

        return view('admin.category.edit', ['category' => $category, 'categories' => $categories, 'types' => $types]);
    }

    public function update(Request $request, $id)
    {
        $category = Category::find($id);
        $filter_attr = $request->filter_attr == "" ? "" : serialize(array_unique($request->filter_attr));
        $data = array_add($request->except('filter_attr'), 'filter_attr', $filter_attr);

        $category->update($data);

        Cache::forget('wyshop_admin_category_categories');
        return redirect(route('admin.category.index'));
    }

    //查询子节点
    public function child_node($parent_id)
    {
        static $result = array();
        $category = Category::where('parent_id', $parent_id)->get();
        if ($category) {
            foreach ($category as $cate) {
                $result[] = $cate->id;
                $this->get_child($cate->id);
            }
        }
        return $result;
    }

    public function destroy($id)
    {
        Cache::forget('wyshop_admin_category_categories');
        Category::destroy($id);
        return back()->with('info', '删除分类成功');
    }
}
