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
use Overtrue\Wechat\Payment;
use Overtrue\Wechat\Payment\Order;
use Overtrue\Wechat\Payment\Business;
use Overtrue\Wechat\Payment\UnifiedOrder;

class IndexController extends Controller
{

    private $app_id;
    private $secret;
    private $user;

    public function __construct()
    {
        $this->app_id = config('wechat.app_id');
        $this->secret = config('wechat.secret');


        $this->check_login();
        $this->user = session()->get('user');
        //初始化用户购物车的数量
        view()->share(['cart_number' => $this->cart_number()]);
    }

    //统计用户购物车商品数量
    private function cart_number()
    {
        return Cart::where('user_id', $this->user->id)->sum('num');
    }

    //获取用户信息
    private function check_login()
    {

        if (!session()->has('user')) {
            //获取用户信息
            $auth = new Auth($this->app_id, $this->secret);
            $user_info = $auth->authorize($to = null, $scope = 'snsapi_userinfo', $state = 'STATE');


            $check = User::where("openid", $user_info->openid)->first();

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
            session()->put('user', $user);
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

    //首页
    public function index()
    {
        $best_goods = Good::where('best', true)->orderBy('created_at', 'desc')->take(4)->get();
        $hot_goods = Good::where('hot', true)->orderBy('created_at', 'desc')->take(4)->get();
        $new_goods = Good::where('new', true)->orderBy('created_at', 'desc')->take(4)->get();
        return view('wechat.index', ['best_goods' => $best_goods, 'hot_goods' => $hot_goods, 'new_goods' => $new_goods]);
    }

    //栏目
    public function category()
    {
        return view('wechat.category', ['categories' => $this->get_categories()]);
    }

    //商品列表
    public function good_list($category_id)
    {
        $category = Category::find($category_id);
        $goods = Good::where('onsale', true)->where('category_id', $category_id)->orderBy('created_at', 'desc')->get();
        return view('wechat.good_list', ['category' => $category, 'goods' => $goods]);
    }

    //商品信息
    public function good($good_id)
    {
        $good = Good::with('good_galleries', 'comments.user')->find($good_id);
        return view('wechat.good', ['good' => $good]);
    }

    //添加商品到购物车
    public function add_cart(Request $request)
    {
        //判断购物车，当前商品是否有记录
        $cart = Cart::where('good_id', $request->good_id)->where('user_id', $this->user->id)->first();

        //当前商品库存数
        $number = Good::find($request->good_id)->number;

        //如果是初次新增到购物车
        if (!$cart) {
            //如果用户提交数大于库存数，提示商品库存不足
            if ($request->num > $number) {
                return response()->json(['status' => 0, 'info' => '商品库存不足']);
            }

            Cart::create(['good_id' => $request->good_id, 'user_id' => $this->user->id, 'num' => $request->num]);
            return response()->json(['status' => 1, 'info' => '恭喜，已添至购物车~', 'cart_number' => $this->cart_number()]);
        }

        //如果购物车已经有该商品的记录
        //购物车里的数量+用户新提交的数量 > 库存数
        $new_num = $cart->num + $request->num;
        if ($new_num > $number) {
            return response()->json(['status' => 0, 'info' => '商品库存不足']);
        }

        $cart->num = $new_num;
        $cart->save();

        return response()->json(['status' => 1, 'info' => '恭喜，已添至购物车~', 'cart_number' => $this->cart_number()]);
    }

    //购物车
    public function cart()
    {
        $carts = Cart::with('good')->where('user_id', $this->user->id)->get();
        return view('wechat.cart', ['carts' => $carts, 'total_price' => $this->total_price()]);
    }

    //计算总价
    private function total_price()
    {
        $total_price = 0;
        $carts = Cart::with('good')->where('user_id', $this->user->id)->get();
        foreach ($carts as $cart) {
            $total_price += $cart->num * $cart->good->price;
        }
        return $total_price;
    }

    //我的账户
    public function account()
    {
        return view('wechat.account');
    }

    //微信支付
    public function pay()
    {
        $business = new Business(
            $this->app_id,							// APP_ID,
            '13e1c42de4b27e00892faf1f226c3145',		// AppSecret,
            1230390602,								// 微信支付商户号,
            '1123325aedfafqr34234123421wqerwq'		// api秘钥
        );


        /**
         * 第 2 步：定义订单
         */
        $order = new Order();
        $order->body = '长乐商城订单';
        $order->out_trade_no = md5(uniqid().microtime());
        $order->total_fee = '1';    // 单位为 “分”, 字符串类型
        $order->openid = session()->get('user')->openid;

        $order->notify_url = 'http://wyshop.whphp.comcom/wechat';

        /**
         * 第 3 步：统一下单
         */
        $unifiedOrder = new UnifiedOrder($business, $order);
        /**
         * 第 4 步：生成支付配置文件
         */
        $payment = new Payment($unifiedOrder);
        // return $payment->getConfig();
        return view('wechat.pay')->with('config', $payment->getConfig());
    }

    public function notify(){
        $notify = new Notify(
            $this->app_id,							// APP_ID,
            '13e1c42de4b27e00892faf1f226c3145',		// AppSecret,
            1230390602,								// 微信支付商户号,
            '1123325aedfafqr34234123421wqerwq'		// api秘钥
        );

        $transaction = $notify->verify();

        if (!$transaction) {
            $notify->reply('FAIL', 'verify transaction error');
        }

        //修改订单状态

        echo $notify->reply();
    }

}
