<?php

namespace App\Http\Controllers\Wechat;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Cache;
use App\Models\Category;
use App\Models\Good;
use App\Models\User;
use App\Models\Cart;
use Overtrue\Wechat\Auth;
use Session;


class IndexController extends Controller
{

    private $app_id;
    private $secret;

    public function __construct()
    {
        $this->app_id = config('wechat.app_id');
        $this->secret = config('wechat.secret');

//        $this->check_login();
    }

    //获取用户信息
    private function check_login()
    {
        //如果session中没有用户信息
        if (!Session::has('user')) {
            //获取用户信息
            $auth = new Auth($this->app_id, $this->secret);
            $user_info = $auth->authorize($to = null, $scope = 'snsapi_userinfo', $state = 'STATE');


            $check = User::where("openid", $user_info->openid)->get();

            //如果数据库没有用户记录，存入数据库
            if ($check->count() == 0) {

                $user = User::create([
                    'openid' => $user_info->openid,
                    'sex' => $user_info->sex,
                    'nickname' => $user_info->nickname,
                    'city' => $user_info->city,
                    'province' => $user_info->province,
                    'headimgurl' => $user_info->headimgurl
                ]);

            } else {
                //如果数据库中已经有了当前用户
                $user = $check;
            }

            //用户信息存入session，并跳转到微商城首页
            Session::put('user', $user);
            return back();
        }
    }

    //获取栏目信息
    private function get_categories()
    {
        $categories = Cache::rememberForever('wechat_index_categories', function () {
            $categories = Category::with('children')->where('parent_id', '0')->orderBy('parent_id', 'asc')->orderBy('sort_order', 'asc')->orderBy('id', 'asc')->get();
            return $categories;
        });
        return $categories;
    }

    public function index()
    {
        $best_goods = Good::where('best', true)->orderBy('created_at', 'desc')->take(4)->get();
        $hot_goods = Good::where('hot', true)->orderBy('created_at', 'desc')->take(4)->get();
        $new_goods = Good::where('new', true)->orderBy('created_at', 'desc')->take(4)->get();
        return view('wechat.index', ['best_goods' => $best_goods, 'hot_goods' => $hot_goods, 'new_goods' => $new_goods]);
    }

    public function category()
    {
        return view('wechat.category', ['categories' => $this->get_categories()]);
    }

    public function good_list($category_id)
    {
        $category = Category::find($category_id);
        $goods = Good::where('onsale', true)->where('category_id', $category_id)->orderBy('created_at', 'desc')->get();
        return view('wechat.good_list', ['category' => $category, 'goods' => $goods]);
    }

    public function good($good_id)
    {
        $good = Good::with('good_galleries', 'comments.user')->find($good_id);
        return view('wechat.good', ['good' => $good]);

    }

    /**
     * 购物车
     * @return \Illuminate\View\View
     */
    public function cart()
    {
        //记得取session里当前用户的id
//        $carts = Cart::with('good')->where('user_id','session')->get();

        $carts = Cart::with('good')->get();
        return view('wechat.cart', ['carts' => $carts]);
    }


}
