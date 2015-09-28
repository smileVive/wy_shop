@extends('layouts.admin')
@section('content')
    <div class="admin-content">

        <div class="am-cf am-padding">
            <div class="am-fl am-cf">
                <strong class="am-text-primary am-text-lg">系统设置</strong> /
                <small>添加物流</small>
            </div>
        </div>

        @include('layouts._message')

        <form class="am-form" action="{{ route('admin.express.update', $express->id) }}" method="post">
            {!! csrf_field() !!}
            {!! method_field('put') !!}

            <div class="am-g am-margin-top">
                <div class="am-u-sm-4 am-u-md-2 am-text-right">
                    物流名称
                </div>

                <div class="am-u-sm-8 am-u-md-4 am-u-end col-end">
                    <select data-am-selected="{btnWidth: '100%',  btnStyle: 'secondary', btnSize: 'sm', maxHeight: 360, searchBox: 1}"
                            name="key">
                        <option value="">请选择</option>
                        @foreach ($expresses as $k=>$v)
                            <option value="{{$k}}" @if($express->key == $k) selected @endif>
                                {{$v}}
                            </option>
                        @endforeach
                    </select>
                </div>

            </div>

            <div class="am-g am-margin-top">
                <div class="am-u-sm-4 am-u-md-2 am-text-right">
                    物流运费
                </div>
                <div class="am-u-sm-8 am-u-md-4 am-u-end col-end">
                    <input type="text" class="am-input-sm" name="shipping_money" value="{{ $express->shipping_money }}">
                </div>
            </div>

            <div class="am-g am-margin-top">
                <div class="am-u-sm-4 am-u-md-2 am-text-right">
                    满额免物流费
                </div>
                <div class="am-u-sm-8 am-u-md-4 am-u-end col-end">
                    <input type="text" class="am-input-sm" name="shipping_free" value="{{ $express->shipping_free }}">
                </div>
            </div>

            <div class="am-g am-margin-top-sm">
                <div class="am-u-sm-12 am-u-md-2 am-text-right admin-form-text">
                    物流描述
                </div>
                <div class="am-u-sm-12 am-u-md-10">
                    <textarea rows="10" name="desc">{{ $express->desc }}</textarea>
                </div>
            </div>

            <div class="am-g am-margin-top">
                <div class="am-u-sm-4 am-u-md-2 am-text-right">
                    是否可用
                </div>
                <div class="am-u-sm-8 am-u-md-4 am-u-end col-end">
                    <input type="radio" name="enabled" value="1" @if($express->enabled == 1) checked @endif>是
                    <input type="radio" name="enabled" value="0" @if($express->enabled == 0) checked @endif>否
                </div>
            </div>

            <div class="am-g am-margin-top">
                <div class="am-u-sm-4 am-u-md-2 am-text-right">
                    排序
                </div>
                <div class="am-u-sm-8 am-u-md-4 am-u-end col-end">
                    <input type="text" name="sort_order" class="am-input-sm" value="{{ $express->sort_order }}">
                </div>
            </div>

            <div class="am-margin">
                <button type="submit" class="am-btn am-btn-primary am-btn-xs">提交保存</button>
            </div>
        </form>


    </div>
@stop


@section('js')
@stop
