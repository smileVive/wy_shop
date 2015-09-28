<?php

namespace App\Http\Controllers\Wechat;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Cache;
use App\Models\Category;

class IndexController extends Controller
{

    //获取栏目信息
    private function get_categories()
    {
        $categories = Cache::rememberForever('wechat_index_categories', function () {
            $categories = Category::with('children')->where('parent_id', '0')->orderBy('parent_id', 'asc')->orderBy('sort_order', 'asc')->orderBy('id', 'asc')->get();
            return $categories;
        });
        return $categories;
    }

    public function __construct()
    {
        view()->share(['categories' => $this->get_categories()]);
    }

    public function index()
    {
        return view('wechat.index');
    }


}
