@extends('layouts.wechat')
@section('css')
    <style>
        .am-titlebar-multi {
            border-top: none;
        }

        .am-titlebar {
            margin-top: 0;
        }

        #price {
            color: #f24b48;
        }

        .am-titlebar-multi .am-titlebar-title {
            color: #252525;
            font-weight: normal;
        }

        .am-titlebar-multi a {
            color: #6f5499;
        }

        .am-tabs-bd .am-tab-panel {
            padding: 0;
        }

        .p_10 {
            padding: 0 10px;
        }

    </style>
@stop
@section('content')
    <div data-am-widget="tabs" class="am-tabs am-tabs-d2" data-am-tabs-noswipe="1">
        <ul class="am-tabs-nav am-cf">
            <li class="am-active"><a href="[data-tab-panel-0]">商品</a></li>
            <li class=""><a href="[data-tab-panel-1]">详情</a></li>
            <li class=""><a href="[data-tab-panel-2]">评价</a></li>
        </ul>
        <div class="am-tabs-bd">
            <div data-tab-panel-0 class="am-tab-panel am-active">

                <div data-am-widget="slider" class="am-slider am-slider-a1" data-am-slider='{"directionNav":false}'>
                    <ul class="am-slides">
                        @foreach($good->good_galleries as $g)
                            <li><img src="{{$g->img}}" class="good_img"></li>
                        @endforeach

                    </ul>
                </div>


                <div data-am-widget="titlebar" class="am-titlebar am-titlebar-multi">
                    <h2 class="am-titlebar-title" id="price">
                        ￥{{number_format($good->price, 2)}}
                    </h2>
                </div>

                <div data-am-widget="titlebar" class="am-titlebar am-titlebar-multi" id="info">
                    <h2 class="am-titlebar-title ">
                        {{$good->name}}
                    </h2>

                    <nav class="am-titlebar-nav">
                        <a href="#more">&raquo;</a>
                    </nav>
                </div>

                <div data-am-widget="titlebar" class="am-titlebar am-titlebar-multi">
                    <h2 class="am-titlebar-title">
                        库存：{{$good->number}}
                    </h2>
                </div>

                <hr data-am-widget="divider" style="" class="am-divider am-divider-default"/>
                <div style="padding:0 10px 10px;">
                    <button type="button" class="am-btn am-btn-lg am-btn-success am-radius am-btn-block">
                        <i class="am-icon-shopping-cart"></i>
                        加入购物车
                    </button>
                </div>
            </div>
            <div data-tab-panel-1 class="am-tab-panel ">
                <div class="p_10">
                    {!! $good->desc !!}
                </div>
            </div>
            <div data-tab-panel-2 class="am-tab-panel ">
                <div class="p_10">
                    <ul class="am-comments-list am-comments-list-flip">

                        @foreach($good->comments as $comment)
                            <article class="am-comment">
                                <a href="#link-to-user-home">
                                    <img src="{{$comment->user->headimgurl}}" alt="" class="am-comment-avatar" width="48" height="48"/>
                                </a>

                                <div class="am-comment-main">
                                    <header class="am-comment-hd">
                                        <!--<h3 class="am-comment-title">评论标题</h3>-->
                                        <div class="am-comment-meta">
                                            <a href="#link-to-user" class="am-comment-author">{{$comment->user->nickname}}</a>
                                            于 {{$comment->created_at}} 对 {{$good->name}} 发表评论
                                        </div>
                                    </header>

                                    <div class="am-comment-bd">
                                        {{$comment->content}}
                                    </div>
                                </div>
                            </article>
                        @endforeach
                    </ul>
                </div>

            </div>
        </div>
    </div>

@stop

@section('js')

    <script>
        $(function () {
            $('#info').click(function () {
                $(".am-tabs").tabs('open', 1);
            })
        })
    </script>
@stop

