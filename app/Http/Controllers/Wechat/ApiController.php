<?php
namespace App\Http\Controllers\Wechat;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Overtrue\Wechat\Server;
use Overtrue\Wechat\Message;
use App\Models\Good;

class ApiController extends Controller
{
    /**
     * 处理微信的请求消息
     */
    public function serve(Server $server)
    {


        // $server->on('event', 'subscribe', function($event){
// 			return Message::make('text')->content('您好！欢迎关注 长乐未央');
// 		});

//        //点击事件回复
        $server->on('event', function ($event) {
            switch ($event->Event) {
                case 'subscribe':
                    return Message::make('text')->content('您好！欢迎关注 长乐商城');
                    break;
                case 'CLICK':
                    switch ($event->EventKey) {
                        case 'best':
                            return $this->best();
                            break;
                        case 'hot':
                            return $this->hot();
                            break;
                        case 'new':
                            return $this->new_goods();
                            break;
//                        case 'order':
//                            return $this->order_list();
//                            break;
                        case 'help':
                            return $this->help();
                            break;
                        default:
                            return $this->default_msg();
                            break;
                    }
                    break;
            }

        });
//
//        //语音回复
        $server->on('message', 'voice', function ($message) {
            switch ($message->Recognition) {
                //人气商品
                case '人气！':
                    return $this->best();
                    break;

                //热门商品
                case '热门！':
                    return $this->hot();
                    break;

                case '最新！':
                    return $this->new_goods();
                    break;

                case '帮助！':
                    return $this->help();
                    break;

                default:
                    return $this->default_msg($message->Recognition);
                    break;
            }
        });
//
//        //文字回复
        $server->on('message', 'text', function ($message) {
            switch ($message->Content) {
                case '人气':
                    return $this->best();
                    break;
                case '热门':
                    return $this->hot();
                    break;
                case '最新':
                    return $this->new_goods();
                    break;
                case '帮助':
                    return $this->help();
                    break;
                default:
                    return $this->default_msg();
                    break;
            }
        });

        // return Message::make('text')->content('我们已经收到您发送的图片！');
        return $server->serve(); // 或者 return $server;
    }

    //查询人气商品
    private function best()
    {
        $news = Message::make('news')->items(function () {
            $goods = Good::where('best', true)->get();
            $info = array();
            foreach ($goods as $good) {
                $info[] = Message::make('news_item')->title($good->name)->url(url('good', [$good->id]))->picUrl('http://wyshop.whphp.com/' . $good->thumb);
            }
            return $info;
        });
        return $news;
    }

    //查询热门商品
    private function hot()
    {
        $news = Message::make('news')->items(function () {
            $goods = Good::where('hot', true)->get();
            $info = array();
            foreach ($goods as $good) {
                $info[] = Message::make('news_item')->title($good->name)->url(url('good', [$good->id]))->picUrl('http://wyshop.whphp.com/' . $good->thumb);
            }
            return $info;
        });
        return $news;
    }

    //查询最新商品
    private function new_goods()
    {
        $news = Message::make('news')->items(function () {
            $goods = Good::where('new', true)->get();
            $info = array();
            foreach ($goods as $good) {
                $info[] = Message::make('news_item')->title($good->name)->url(url('good', [$good->id]))->picUrl('http://wyshop.whphp.com/' . $good->thumb);
            }
            return $info;
        });
        return $news;
    }



    private function help()
    {
        $msg = "回复[人气]，显示人气商品\n回复[最新]，显示最新商品\n回复[热门]，显示热门商品";
        return Message::make('text')->content($msg);
    }

    //默认消息
    private function default_msg($msg = '默认消息！')
    {
        return Message::make('text')->content($msg);
    }
}