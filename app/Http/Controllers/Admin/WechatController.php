<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Cache;

use Overtrue\Wechat\Menu;
use Overtrue\Wechat\MenuItem;

class WechatController extends Controller
{
    private $app_id;
    private $secret;

    public function __construct(){
        $this->app_id = config('wechat.app_id');
        $this->secret = config('wechat.secret');
    }

    //获取菜单
    public function get_menu()
    {
        $menu = new Menu($this->app_id, $this->secret);
        return view('admin.wechat.menu')->with("menus", $menu->get());
    }


    //设置菜单
    public function set_menu(Request $request)
    {
        // $menus = $request->menus;
        // dd( $menus[0]);

        $menu = new Menu($this->app_id, $this->secret);
        $menus = $request->menus; // menus 是你自己后台管理中心表单post过来的一个数组
        $target = [];

        // 构建你的菜单
        foreach ($menus as $m) {
            // 创建一个菜单项
            $item = new MenuItem($m['name'], $m['type'], $m['key']);
            // 子菜单
            if (!empty($m['buttons'])) {
                $buttons = [];
                foreach ($m['buttons'] as $button) {
                    if($button['name'] != ''){
                        $buttons[] = new MenuItem($button['name'], $button['type'], $button['key']);
                    }
                }
                $item->buttons($buttons);
            }
            $target[] = $item;
        }
        // dd($target);
        $menu->set($target); // 失败会抛出异常
        return back();
    }

}