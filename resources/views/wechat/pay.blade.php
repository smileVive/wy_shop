@extends('layouts.wechat')


@section('css')
    <style type="text/css">
    </style>
@stop

@section('content')
    <header class="mui-bar mui-bar-nav">
        <button class="mui-btn mui-btn-link mui-btn-nav mui-pull-left">
            长乐商城
        </button>
        <a id="offCanvasBtn" href="#offCanvasSide" class="mui-icon mui-action-menu mui-icon-bars mui-pull-right"></a>

        <h1 class="mui-title">微信支付</h1>
    </header>


    <button class="mui-btn mui-btn-primary" id="pay">
        <span class="mui-icon mui-icon-search"></span>
        点我付钱
    </button>
@stop

@section('js')
    <script src="http://res.wx.qq.com/open/js/jweixin-1.0.0.js"></script>
    <script type="text/javascript">
        $(function () {
            $("#pay").click(function () {
                if (typeof WeixinJSBridge === 'undefined') {
                    alert('请在微信在打开页面！');
                    return false;
                }
                WeixinJSBridge.invoke(
                        'getBrandWCPayRequest', {!! $config !!}, function (res) {
                            switch (res.err_msg) {
                                case 'get_brand_wcpay_request:cancel':
                                    alert('用户取消支付！');
                                    break;
                                case 'get_brand_wcpay_request:fail':
                                    alert('支付失败！（' + res.err_desc + '）');
                                    break;
                                case 'get_brand_wcpay_request:ok':
                                    alert('支付成功！');
                                    break;
                                default:
                                    alert(JSON.stringify(res));
                                    break;
                            }
                        });
            })
        })

    </script>
@stop