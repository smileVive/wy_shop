@extends('layouts.wechat')
@section('css')
    <style>
        .am-offcanvas-bar {
            background: #fff;
        }
    </style>
@stop
@section('content')
    <ul class="am-nav am-nav-pills am-nav-justify">
        <li class="am-active"><a href="#">综合</a></li>
        <li><a href="#">销量</a></li>
        <li><a href="#">价格</a></li>
        <li><a href="javascript: void 0;" data-am-offcanvas="{target: '#doc-oc-demo3', effect: 'push'}">筛选</a></li>
    </ul>


    <div id="doc-oc-demo3" class="am-offcanvas">
        <div class="am-offcanvas-bar am-offcanvas-bar-flip">
            <div class="am-offcanvas-content">

                <nav data-am-widget="menu" class="am-menu  am-menu-stack">
                    <a href="javascript: void(0)" class="am-menu-toggle">
                        <i class="am-menu-toggle-icon am-icon-bars"></i>
                    </a>

                    <ul class="am-menu-nav am-avg-sm-1 filter_attr">

                        @foreach ($attributes as $attr)
                            <li class="am-parent">
                                <a href="##" class="">{{$attr->name}} <span
                                            style="color: #c00000;float:right;margin-right:32px;">不限</span></a>
                                <ul class="am-menu-sub am-collapse  am-avg-sm-2 ">
                                    <li class="">
                                        <a href="javascript: void 0;" class="filter_value">不限</a>
                                    </li>
                                    @foreach(explode("\r\n", $attr->value) as $value)
                                        <li class="">
                                            <a href="javascript: void 0;" class="filter_value">{{$value}}</a>
                                        </li>
                                    @endforeach

                                </ul>
                            </li>
                        @endforeach
                    </ul>
                </nav>


                <div style="margin-top: 24px;">
                    <button type="button" class="am-btn am-btn-default am-radius clear-filter">清除</button>
                    <button type="button" class="am-btn am-btn-secondary am-radius go-filter">确认</button>
                </div>


            </div>
        </div>
    </div>



    {{--<ul class="am-nav am-nav-pills am-nav-justify">--}}
    {{--<li class="am-active"><a href="#">首页</a></li>--}}
    {{--<li><a href="#">开始使用</a></li>--}}
    {{--<li><a href="#">按需定制</a></li>--}}
    {{--<li><a href="#">加入我们</a></li>--}}
    {{--</ul>--}}


    <div data-am-widget="list_news" class="am-list-news am-list-news-default">
        <div class="am-list-news-bd">
            <ul class="am-list">
                @foreach($goods as $good)
                        <!--缩略图在标题左边-->
                <li class="am-g am-list-item-desced am-list-item-thumbed am-list-item-thumb-left">
                    <div class="am-u-sm-4 am-list-thumb">
                        <a href="{{url('good', [$good->id])}}" class="">
                            <img src="{{$good->thumb}}" alt="{{$good->name}}"/>
                        </a>
                    </div>

                    <div class=" am-u-sm-8 am-list-main">
                        <h3 class="am-list-item-hd">
                            <a href="{{url('good', [$good->id])}}" class="">{{$good->name}}</a>
                        </h3>

                        <div class="am-list-item-text">
                            {{$good->price}}
                        </div>

                    </div>
                </li>
                @endforeach
            </ul>
        </div>
    </div>
@stop

@section('js')

    <script>
        $(".filter_value").click(function () {
            var value = $(this).text();
            $(this).parents(".am-parent").find("span").text(value);
        })

        $(".clear-filter").click(function () {
            $(".filter_attr span").text("");
        })

        $(".go-filter").click(function () {
            var info = {};
            var filter_attr = [];
            $(".filter_attr span").each(function () {
                var attr_value = $(this).text()
                if (attr_value != "不限") {
                    filter_attr.push(attr_value);
                }
            })

            info.filter_attr = filter_attr;
            info.categry_id = "{{$category->id}}";

            $.ajax({
                type: "GET",
                data: info,
                url: "/category/" + info.categry_id + "/filter_attr",
                dataType: "json",
                success: function (data) {
                    console.log(data);
                }

            })

        })
    </script>
@stop

