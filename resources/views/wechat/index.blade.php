<!doctype html>
<html class="no-js">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>长乐商城</title>
    <meta name="description" content="">
    <meta name="keywords" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <meta name="renderer" content="webkit">
    <meta http-equiv="Cache-Control" content="no-siteapp"/>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" type="image/png" href="assets/i/favicon.png">
    <link rel="stylesheet" href="{{ asset('amaze/css/amazeui.min.css') }}"/>
    <link rel="stylesheet" href="{{ asset('amaze/css/app.css') }}"/>
    <link rel='stylesheet' href='{{ asset('NProgress/nprogress.css') }}'/>
    <style>
        .am-navbar-default .am-navbar-nav {
            background-color: #6f5499;
            background-image: linear-gradient(to bottom, #563d7c 0, #6f5499 100%);
            background-repeat: repeat-x;
            opacity: .9;
        }
    </style>
    @yield('css')
</head>
<body>


{{--<header data-am-widget="header"--}}
{{--class="am-header am-header-default">--}}
{{--<div class="am-header-left am-header-nav">--}}
{{--<a href="#left-link" class="">--}}

{{--<i class="am-header-icon am-icon-home"></i>--}}
{{--</a>--}}
{{--</div>--}}

{{--<h1 class="am-header-title">--}}
{{--<a href="#title-link" class="" data-am-offcanvas>--}}
{{--长乐商城--}}
{{--</a>--}}
{{--</h1>--}}

{{--<div class="am-header-right am-header-nav">--}}
{{--<a href="#sidebar" class="am-btn am-btn-sm am-icon-bars am-show-sm-only my-button" data-am-offcanvas><span class="am-sr-only">侧栏导航</span></a>--}}
{{--</div>--}}
{{--</header>--}}

<!-- Menu -->
<nav data-am-widget="menu" class="am-menu  am-menu-offcanvas1" data-am-menu-offcanvas>
    <div class="am-offcanvas" id="sidebar">
        <div class="am-offcanvas-bar">
            <ul class="am-menu-nav sm-block-grid-1">

                @foreach($categories as $category)
                    <li class="am-parent">
                        <a href="##">{{$category->name}}</a>
                        <ul class="am-menu-sub am-collapse">
                            @foreach($category->children as $c)
                                <li class="">
                                    <a href="##">{{$c->name}}</a>
                                </li>
                            @endforeach

                        </ul>
                    </li>
                @endforeach

            </ul>
        </div>
    </div>
</nav>

<!-- Slider -->
<div data-am-widget="slider" class="am-slider am-slider-a1" data-am-slider='{"directionNav":false}'>
    <ul class="am-slides">
        <li>
            <img src="http://s.amazeui.org/media/i/demos/bing-1.jpg">
        </li>
        <li>
            <img src="http://s.amazeui.org/media/i/demos/bing-2.jpg">
        </li>
        <li>
            <img src="http://s.amazeui.org/media/i/demos/bing-3.jpg">
        </li>
        <li>
            <img src="http://s.amazeui.org/media/i/demos/bing-4.jpg">
        </li>
    </ul>
</div>

<!-- List -->
<div data-am-widget="list_news" class="am-list-news am-list-news-default">
    <!--列表标题-->
    <div class="am-list-news-hd am-cf">
        <!--带更多链接-->
        <a href="###">
            <h2>左图 + 摘要</h2>
            <span class="am-list-news-more am-fr">更多 &raquo;</span>
        </a>
    </div>
    <div class="am-list-news-bd">
        <ul class="am-list">
            <!--缩略图在标题左边-->
            <li class="am-g am-list-item-desced am-list-item-thumbed am-list-item-thumb-left">
                <div class="am-u-sm-4 am-list-thumb">
                    <a href="http://www.douban.com/online/11614662/">
                        <img src="http://img5.douban.com/lpic/o636459.jpg" alt="我很囧，你保重....晒晒旅行中的那些囧！"
                                />
                    </a>
                </div>
                <div class="am-u-sm-8 am-list-main">
                    <h3 class="am-list-item-hd">
                        <a href="http://www.douban.com/online/11614662/">我很囧，你保重....晒晒旅行中的那些囧！</a>
                    </h3>

                    <div class="am-list-item-text">
                        囧人囧事囧照，人在囧途，越囧越萌。标记《带你出发，陪我回家》http://book.douban.com/subject/25711202/为“想读”“在读”或“读过”，有机会获得此书本活动进行3个月，每月送出三本书。会有不定期bonus！
                    </div>
                </div>
            </li>
            <li class="am-g am-list-item-desced am-list-item-thumbed am-list-item-thumb-left">
                <div class="am-u-sm-4 am-list-thumb">
                    <a href="http://www.douban.com/online/11624755/">
                        <img src="http://img3.douban.com/lpic/o637240.jpg" alt="我最喜欢的一张画"/>
                    </a>
                </div>
                <div class="am-u-sm-8 am-list-main">
                    <h3 class="am-list-item-hd">
                        <a href="http://www.douban.com/online/11624755/">我最喜欢的一张画</a>
                    </h3>

                    <div class="am-list-item-text">
                        你最喜欢的艺术作品，告诉大家它们的------名图画，色彩，交织，撞色，线条雕塑装置当代古代现代作品的照片美我最喜欢的画群296795413进群发画，少说多发图，
                    </div>
                </div>
            </li>
            <li class="am-g am-list-item-desced">
                <div class="am-list-main">
                    <h3 class="am-list-item-hd">
                        <a href="http://www.douban.com/online/11645411/">“你的旅行，是什么颜色？” 晒照片，换北欧梦幻极光之旅！</a>
                    </h3>

                    <div class="am-list-item-text">
                        还在苦恼圣诞礼物再也玩儿不出新意？快来抢2013最炫彩的跨国圣诞礼物！【参与方式】1.关注“UniqueWay无二之旅”豆瓣品牌小站http://brand.douban.com/uniqueway/2.上传一张**本人**在旅行中色彩最浓郁、最丰富的照片（色彩包含取景地、周边事物、服装饰品、女生彩妆等等，发挥你们无穷的创意想象力哦！^^）一定要有本人出现喔！3.
                        在照片下方，附上一句旅行宣言作为照片说明。 成功参与活动！* 听他们刚才说，上传照片的次
                    </div>
                </div>
            </li>
        </ul>
    </div>
</div>


<!-- Gallery -->
<ul data-am-widget="gallery" class="am-gallery am-avg-sm-2
  am-avg-md-3 am-avg-lg-4 am-gallery-default" data-am-gallery="{ pureview: true }">
    <li>
        <div class="am-gallery-item">
            <a href="http://s.amazeui.org/media/i/demos/bing-1.jpg"
               class="">
                <img src="http://s.amazeui.org/media/i/demos/bing-1.jpg"
                     alt="远方 有一个地方 那里种有我们的梦想"/>

                <h3 class="am-gallery-title">远方 有一个地方 那里种有我们的梦想</h3>

                <div class="am-gallery-desc">2375-09-26</div>
            </a>
        </div>
    </li>
    <li>
        <div class="am-gallery-item">
            <a href="http://s.amazeui.org/media/i/demos/bing-2.jpg"
               class="">
                <img src="http://s.amazeui.org/media/i/demos/bing-2.jpg"
                     alt="某天 也许会相遇 相遇在这个好地方"/>

                <h3 class="am-gallery-title">某天 也许会相遇 相遇在这个好地方</h3>

                <div class="am-gallery-desc">2375-09-26</div>
            </a>
        </div>
    </li>
    <li>
        <div class="am-gallery-item">
            <a href="http://s.amazeui.org/media/i/demos/bing-3.jpg"
               class="">
                <img src="http://s.amazeui.org/media/i/demos/bing-3.jpg"
                     alt="不要太担心 只因为我相信"/>

                <h3 class="am-gallery-title">不要太担心 只因为我相信</h3>

                <div class="am-gallery-desc">2375-09-26</div>
            </a>
        </div>
    </li>
    <li>
        <div class="am-gallery-item">
            <a href="http://s.amazeui.org/media/i/demos/bing-4.jpg"
               class="">
                <img src="http://s.amazeui.org/media/i/demos/bing-4.jpg"
                     alt="终会走过这条遥远的道路"/>

                <h3 class="am-gallery-title">终会走过这条遥远的道路</h3>

                <div class="am-gallery-desc">2375-09-26</div>
            </a>
        </div>
    </li>
</ul>

<!-- List -->
<div data-am-widget="list_news" class="am-list-news am-list-news-default">
    <!--列表标题-->
    <div class="am-list-news-hd am-cf">
        <!--带更多链接-->
        <a href="###">
            <h2>栏目标题</h2>
        </a>
    </div>
    <div class="am-list-news-bd">
        <ul class="am-list">
            <li class="am-g">
                <a href="http://www.douban.com/online/11614662/" class="am-list-item-hd">我很囧，你保重....晒晒旅行中的那些囧！</a>
            </li>
            <li class="am-g">
                <a href="http://www.douban.com/online/11624755/" class="am-list-item-hd">我最喜欢的一张画</a>
            </li>
            <li class="am-g">
                <a href="http://www.douban.com/online/11645411/" class="am-list-item-hd">“你的旅行，是什么颜色？”
                    晒照片，换北欧梦幻极光之旅！</a>
            </li>
        </ul>
    </div>
    <!--更多在底部-->
    <div class="am-list-news-ft">
        <a class="am-list-news-more am-btn am-btn-default" href="###">查看更多 &raquo;</a>
    </div>
</div>

<!-- Navbar -->
<div data-am-widget="navbar" class="am-navbar am-cf am-navbar-default "
     id="">
    <ul class="am-navbar-nav am-cf am-avg-sm-4">
        <li>
            <a href="/">
                <span class="am-icon-home"></span>
                <span class="am-navbar-label">首页</span>
            </a>
        </li>


        <li>
            {{--<a href="#sidebar" data-am-offcanvas="{target: '#sidebar', effect: 'push'}">--}}
            <a href="#sidebar" data-am-offcanvas>
                <span class="am-icon-th-list"></span>
                <span class="am-navbar-label">分类</span>
            </a>
        </li>
        <li data-am-navbar-qrcode>
            <a href="###">
                <span class="am-icon-shopping-cart"></span>
                <span class="am-navbar-label">购物车</span>
            </a>
        </li>
        <li>
            <a href="https://github.com/allmobilize/amazeui">
                <span class="am-icon-user"></span>
                <span class="am-navbar-label">我的</span>
            </a>
        </li>
    </ul>
</div>


<div data-am-widget="gotop" class="am-gotop am-gotop-fixed" style="width: auto;">
    <a href="#top" title="回到顶部" class="am-icon-btn am-icon-arrow-up am-active" id="amz-go-top"></a>
</div>


<!--[if lt IE 9]>
<script src="http://libs.baidu.com/jquery/1.11.1/jquery.min.js"></script>
<script src="http://cdn.staticfile.org/modernizr/2.8.3/modernizr.js"></script>
<script src="amaze/js/amazeui.ie8polyfill.min.js"></script>
<![endif]-->

<!--[if (gte IE 9)|!(IE)]><!-->
<script src="{{ asset('amaze/js/jquery.min.js') }}"></script>
<!--<![endif]-->
<script src="{{ asset('amaze/js/amazeui.min.js') }}"></script>
<script src="{{ asset('js/laravel.js') }}"></script>
<script src="{{ asset('NProgress/nprogress.js') }}"></script>
<script src="{{ asset('js/fastclick.js') }}"></script>
<script>
    $(function () {
        FastClick.attach(document.body);
    });

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    NProgress.start();
    NProgress.done();
</script>

@yield('js')
</body>
</html>
