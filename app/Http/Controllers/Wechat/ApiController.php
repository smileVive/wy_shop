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
        $server->on('event', function ($event) {
            switch ($event->Event) {
                case 'subscribe':
                    return Message::make('text')->content('您好！欢迎关注 长乐商城');
                    break;
                case 'CLICK':
                    switch ($event->EventKey) {
                        case 'rq':
                            return $this->rq();
                            break;
                        case 'hot':
                            return Message::make('text')->content('您好！欢迎关注 长乐未央');
                            break;
                        default:
                            return $this->default_msg();
                            break;
                    }
                    break;
            }

        });

        //语音回复

        $server->on('message', 'voice', function ($message) {
            switch ($message->Recognition) {
                //人气商品
                case '人气商品！':
                    return $this->rq();
                    break;

                //热门商品
                case 'hot':
                    return $this->hot();
                    break;

                default:
                    return $this->default_msg($message->Recognition);
                    break;
            }
        });

        $server->on('message', 'text', function ($message) {
            switch ($message->Content) {
                //人气商品
                case 'rq':
                    return $this->rq();
                    break;

                //热门商品
                case 'hot':
                    return $this->hot();
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
    private function rq()
    {
        $news = Message::make('news')->items(function () {
            $goods = Good::where('hot', true)->get();
            $info = array();
            foreach ($goods as $good) {
                $info[] = Message::make('news_item')->title($good->name)->picUrl('http://wyshop.whphp.com/' . $good->thumb);
            }
            return $info;
        });
        return $news;
    }

    //查询热门商品
    private function hot()
    {
        return Message::make('text')->content('热门商品！');
    }

    //默认消息
    private function default_msg($msg = '默认消息！')
    {
        return Message::make('text')->content($msg);
    }
}