@extends('layouts.admin')
@section('content')
<div class="admin-content">
    <div class="am-cf am-padding">
        <div class="am-fl am-cf">
            <strong class="am-text-primary am-text-lg">微信管理</strong> / <small>自定义菜单</small>
        </div>
    </div>

    @include('layouts._message')




    <div class="row">

        <div class="col-sm-10">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">菜单设置</h3>
                </div>
                <div class="panel-body">
                    <form action="/admin/wechat/set_menu" method="post">
                        {!! method_field('put') !!}

                                <!-- Nav tabs -->
                        <ul class="nav nav-tabs" role="tablist" id="tabs">
                            <li role="presentation" class="active">
                                <a href="#tab0" aria-controls="tab0" role="tab" data-toggle="tab">菜单一</a>
                            </li>
                            <li role="presentation">
                                <a href="#tab1" aria-controls="tab1" role="tab" data-toggle="tab">菜单二</a>
                            </li>
                            <li role="presentation">
                                <a href="#tab2" aria-controls="tab2" role="tab" data-toggle="tab">菜单三</a>
                            </li>
                        </ul>

                        <!-- Tab panes -->
                        <div class="tab-content">
                            @foreach($menus as $key=>$menu)
                                <div role="tabpanel" class="tab-pane fade in @if($key==0) active @endif" id="tab{{$key}}">
                                    <table class="table table-hover">
                                        <thead>
                                        <tr>
                                            <th>级别</th>
                                            <th>类型</th>
                                            <th>名称</th>
                                            <th>值</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <tr>
                                            <td>一级菜单：</td>
                                            <td>
                                                <select class="form-control" name="menus[{{$key}}][type]">
                                                    <option value="">click</option>
                                                    <option value="">view</option>
                                                </select>
                                            </td>
                                            <td><input type="text" name="menus[{{$key}}][name]" value="{{$menu['name']}}" class="form-control"></td>
                                            <td><input type="text" name="menus[{{$key}}][key]" value="" class="form-control"></td>
                                        </tr>
                                        @foreach($menu['sub_button'] as $k=>$button)
                                            <tr>
                                                <td>二级菜单：{{$k+1}}</td>
                                                <td>
                                                    <select class="form-control" name="menus[{{$key}}][buttons][{{$k}}][type]">
                                                        <option value="click" @if($button['type']=='click') selected @endif>click</option>
                                                        <option value="view" @if($button['type']=='view') selected @endif>view</option>
                                                    </select>
                                                </td>
                                                <td><input type="text" name="menus[{{$key}}][buttons][{{$k}}][name]" value="{{$button['name']}}" class="form-control"></td>
                                                <td><input type="text" name="menus[{{$key}}][buttons][{{$k}}][key]" value="{{$button['url'] or $button['key']}}" class="form-control"></td>
                                            </tr>
                                        @endforeach

                                        @if(4-$k > 0)
                                            @for($i=0;$i<4-$k; $i++)
                                                <tr>
                                                    <td>二级菜单：{{$k+$i+2}}</td>
                                                    <td>
                                                        <select class="form-control" name="menus[{{$key}}][buttons][{{$k+$i+1}}][type]">
                                                            <option value="click">click</option>
                                                            <option value="view">view</option>
                                                        </select>
                                                    </td>
                                                    <td><input type="text" name="menus[{{$key}}][buttons][{{$k+$i+1}}][name]" value="" class="form-control"></td>
                                                    <td><input type="text" name="menus[{{$key}}][buttons][{{$k+$i+1}}][key]" value="" class="form-control"></td>
                                                </tr>
                                            @endfor
                                        @endif

                                        </tbody>
                                    </table>
                                </div>
                            @endforeach
                            <div role="tabpanel" class="tab-pane fade" id="second">2</div>
                            <div role="tabpanel" class="tab-pane fade" id="third">3</div>
                        </div>

                        <input type="submit" class="btn btn-info">

                    </form>
                </div>
            </div>
        </div>



</div>
@stop
