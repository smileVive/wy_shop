<!DOCTYPE html>
<html>
<head>
    <title>@yield('title')-商城系统</title>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="{{ asset('/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('/css/app.css') }}" rel="stylesheet" type="text/css">

    @yield('css')
</head>
<body>
<nav class="navbar navbar-default navbar-fixed-top">
    <div class="container-fluid">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">

            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse"
                    data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="/admin">
                <span class="glyphicon glyphicon-home" aria-hidden="true"></span>
            </a>
        </div>

        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            <ul class="nav navbar-nav">

                <li class="{{ $order_controller or '' }}">
                    <a href="">
                        <span class="glyphicon glyphicon-list-alt" aria-hidden="true"></span>
                        订单管理
                    </a>
                </li>

                <li class="dropdown  {{ $merchant_controller or '' }}">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true"
                       aria-expanded="false">
                        <span class="glyphicon glyphicon-cutlery" aria-hidden="true"></span>
                        餐厅管理
                        <span class="caret"></span></a>
                    <ul class="dropdown-menu">
                        <li><a href="">餐厅列表</a></li>
                        <li role="separator" class="divider"></li>
                        <li><a href="">新商户审核</a></li>
                    </ul>
                </li>
                <li class="{{ $buyer_controller or '' }}">
                    <a href="">
                        <span class="glyphicon glyphicon-user" aria-hidden="true"></span>
                        用户管理
                    </a>
                </li>
                <li>
                    <a href="#">
                        <span class="glyphicon glyphicon-cog" aria-hidden="true"></span>
                        系统设置
                    </a>
                </li>
                <li>
                    <a href="#">
                        <span class="glyphicon glyphicon-earphone" aria-hidden="true"></span>
                        服务中心
                    </a>
                </li>
                <li class="{{ $wechat_controller or '' }}">
                    <a href="/admin/wechat/get_menu">
                        <span class="glyphicon glyphicon-globe" aria-hidden="true"></span>
                        微信管理
                    </a>
                </li>
            </ul>
            <!-- <form class="navbar-form navbar-left" role="search">
              <div class="form-group">
                <input type="text" class="form-control" placeholder="Search">
              </div>
              <button type="submit" class="btn btn-default">Submit</button>
            </form> -->
            <ul class="nav navbar-nav navbar-right">
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true"
                       aria-expanded="false">尊敬的Admin<span class="caret"></span></a>
                    <ul class="dropdown-menu">
                        <li><a href="#">修改密码</a></li>
                        <li role="separator" class="divider"></li>
                        <li><a href="/admin/logout">安全退出</a></li>
                    </ul>
                </li>
            </ul>
        </div>
        <!-- /.navbar-collapse -->
    </div>
    <!-- /.container-fluid -->
</nav>
<div class="container">
    @yield('content')
</div>
<script type="text/javascript" src="{{ asset('/js/jquery.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('/js/laravel.js') }}"></script>
<script type="text/javascript" src="{{ asset('/bootstrap/js/bootstrap.min.js') }}"></script>

<script>
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
</script>
@yield('js')
</body>
</html>