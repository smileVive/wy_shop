@extends('layouts.wechat')
@section('css')
    <style>
        .option .btn-del {
            background-position: 10px -20px;
        }

        .btn-add, .btn-del {
            overflow: hidden;
            text-indent: -200px;
            background: url({{asset('img/shp-cart-icon-sprites.png')}}) no-repeat -15px -20px;
            background-size: 50px 100px;
        }

        .btn-add, .btn-del, .fm-txt {
            border: solid #ccc;
            float: left;
            width: 32px;
            height: 24px;
            line-height: 24px;
            text-align: center;
        }

        .btn-del {
            border-width: 1px 0 1px 1px;
            border-radius: 3px 0 0 3px;
            font-size: 20px;
        }

        .btn-add {
            border-width: 1px 1px 1px 0;
            border-radius: 0 3px 3px 0;
            font-size: 20px;
        }

        .fm-txt {
            border-width: 1px;
            font-size: 16px;
            border-radius: 0;
            -webkit-appearance: none;
            backgroumd-color: #fff;
        }

        .trash {
            position: absolute;
            right: 20px;
            bottom: 3px;
        }
    </style>
@stop
@section('content')

    <div data-am-widget="list_news" class="am-list-news am-list-news-default">
        <div class="am-list-news-bd">
            <ul class="am-list">

                @foreach($carts as $cart)
                        <!--缩略图在标题左边-->
                <li class="am-g am-list-item-desced am-list-item-thumbed am-list-item-thumb-left">
                    <div class="am-u-sm-4 am-list-thumb">
                        <a href="{{url('good', [$cart->good->id])}}" class="">
                            <img src="{{$cart->good->thumb}}" alt="{{$cart->good->name}}"/>
                        </a>
                    </div>

                    <div class=" am-u-sm-8 am-list-main">
                        <h3 class="am-list-item-hd">
                            <a href="{{url('good', [$cart->good->id])}}" class="">{{$cart->good->name}}</a>
                        </h3>

                        <div class="am-list-item-text">
                            {{$cart->good->price}}
                        </div>

                        <div class="am-list-item-text">
                            <section class="select">
                                <p class="option">
                                    <a class="btn-del" id="minus" onclick="minus();">-</a>
                                    <input type="text" class="fm-txt" value="{{$cart->num}}" id="num" onblur="modify();">
                                    <a class="btn-add" id="plus" onclick="plus();">+</a>
                                </p>
                            </section>
                            <span class="am-icon-trash am-icon-sm trash"></span>

                        </div>


                    </div>
                </li>
                @endforeach

                <li class="am-g">
                    <a class="am-list-item-hd ">
                        小计：￥<span class="total_price">{{number_format($total_price, 2)}}</span>
                    </a>
                </li>
            </ul>
        </div>

        <div style="padding:0 10px 10px;">
            <button type="button" class="am-btn am-btn-lg am-btn-danger am-radius am-btn-block" id="add_cart">
                <i class="am-icon-shopping-cart"></i>
                结算
            </button>
        </div>


    </div>
@stop

@section('js')

    <script>

    </script>
@stop

