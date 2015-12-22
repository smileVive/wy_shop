@extends('layouts.wechat')
@section('content')
    <div data-am-widget="slider" class="am-slider am-slider-c1" data-am-slider='{"directionNav":false}'>
        <ul class="am-slides">
            @foreach($best_goods as $g)
                <li>
                    <img src="{{$g->thumb}}" class="flash_img">

                    <div class="am-slider-desc">{{$g->name}}/￥{{$g->price}}</div>
                </li>
            @endforeach
        </ul>
    </div>

    <!-- List -->
    <div data-am-widget="list_news" class="am-list-news am-list-news-default">
        <!--列表标题-->
        <div class="am-list-news-hd am-cf">
            <!--带更多链接-->
            <a href="###">
                <h2>新品推荐</h2>
                {{--<span class="am-list-news-more am-fr">更多 &raquo;</span>--}}
            </a>
        </div>
        <div class="am-list-news-bd">
            <!-- Gallery -->
            {{--<ul data-am-widget="gallery" class="am-gallery am-avg-sm-2 am-avg-md-3 am-avg-lg-4 am-gallery-default" data-am-gallery="{ pureview: true }">--}}
            <ul data-am-widget="gallery" class="am-gallery am-avg-sm-2 am-avg-md-3 am-avg-lg-4 am-gallery-default">

                @foreach($new_goods as $g)
                    <li>
                        <div class="am-gallery-item">
                            <a href="{{url('good', $g->id)}}"
                               class="">
                                <img src="{{$g->thumb}}"
                                     alt="远方 有一个地方 那里种有我们的梦想"/>

                                <h3 class="am-gallery-title">{{$g->name}}</h3>

                                <div class="am-gallery-desc">{{$g->price}}</div>
                            </a>
                        </div>
                    </li>
                @endforeach

            </ul>
        </div>
    </div>

    <div data-am-widget="list_news" class="am-list-news am-list-news-default">
        <!--列表标题-->
        <div class="am-list-news-hd am-cf">
            <!--带更多链接-->
            <a href="###">
                <h2>热门商品</h2>
            </a>
        </div>
        <div class="am-list-news-bd">
            <!-- Gallery -->
            <ul data-am-widget="gallery" class="am-gallery am-avg-sm-2 am-avg-md-3 am-avg-lg-4 am-gallery-default">

                @foreach($best_goods as $g)
                    <li>
                        <div class="am-gallery-item">
                            <a href="{{url('good', $g->id)}}"
                               class="">
                                <img src="{{$g->thumb}}"
                                     alt="{{$g->name}}"/>

                                <h3 class="am-gallery-title">{{$g->name}}</h3>

                                <div class="am-gallery-desc">{{$g->price}}</div>
                            </a>
                        </div>
                    </li>
                @endforeach

            </ul>
        </div>
    </div>
@stop

