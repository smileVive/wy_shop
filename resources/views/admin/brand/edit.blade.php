@extends('layouts.admin')
@section('content')
<div class="admin-content">

    <div class="am-cf am-padding">
        <div class="am-fl am-cf">
            <strong class="am-text-primary am-text-lg">商品管理</strong> / <small>添加商品</small>
        </div>
    </div>

    @include('layouts._message')

    <form class="am-form" action="{{ route('admin.brand.update', $brand->id) }}" method="post">
        {!! csrf_field() !!}
        {!! method_field('put') !!}

        <div class="am-g am-margin-top">
            <div class="am-u-sm-4 am-u-md-2 am-text-right">
                商品品牌
            </div>
            <div class="am-u-sm-8 am-u-md-4">
                <input type="text" class="am-input-sm" name="name" value="{{ $brand->name }}">
            </div>
            <div class="am-hide-sm-only am-u-md-6">*必填，不可重复</div>
        </div>

        <div class="am-g am-margin-top">
            <div class="am-u-sm-4 am-u-md-2 am-text-right">
                品牌网址
            </div>
            <div class="am-u-sm-8 am-u-md-4 am-u-end col-end">
                <input type="text" class="am-input-sm" name="url" value="{{ $brand->url }}">
            </div>
        </div>


        <div class="am-g am-margin-top">
            <div class="am-u-sm-4 am-u-md-2 am-text-right">
                品牌LOGO
            </div>
            <div class="am-u-sm-8 am-u-md-4 am-u-end col-end">
                <div class="am-form-group am-form-file">
                    <button type="button" class="am-btn am-btn-success am-btn-sm">
                        <i class="am-icon-cloud-upload" id="loading"></i> 选择要上传的logo
                    </button>
                    <input id="doc-form-file" type="file" multipleaa>
                    <input type="hidden" name="logo" value="{{ $brand->logo }}" id="img">
                </div>
                <div id="file-list"></div>
                <img src="{{ $brand->logo }}" alt="" id="img_show"/>
            </div>
        </div>

        <div class="am-g am-margin-top-sm">
            <div class="am-u-sm-12 am-u-md-2 am-text-right admin-form-text">
                品牌描述
            </div>
            <div class="am-u-sm-12 am-u-md-10">
                <textarea rows="10" name="desc">{{ $brand->desc }}</textarea>
            </div>
        </div>

        <div class="am-g am-margin-top">
            <div class="am-u-sm-4 am-u-md-2 am-text-right">
                是否显示
            </div>
            <div class="am-u-sm-8 am-u-md-4 am-u-end col-end">
                <input type="radio" name="is_show" value="1" @if($brand->is_show == 1) checked @endif>是
                <input type="radio" name="is_show" value="0" @if($brand->is_show == 0) checked @endif>否
            </div>
        </div>

        <div class="am-g am-margin-top">
            <div class="am-u-sm-4 am-u-md-2 am-text-right">
                排序
            </div>
            <div class="am-u-sm-8 am-u-md-4 am-u-end col-end">
                <input type="text" name="sort_order" class="am-input-sm" value="{{ $brand->sort_order }}">
            </div>
        </div>

        <div class="am-margin">
            <button type="submit" class="am-btn am-btn-primary am-btn-xs">提交保存</button>
        </div>
    </form>



</div>
@stop

@section('js')
<script src="{{ asset('js/jquery.html5-fileupload.js') }}"></script>
<script src="{{ asset('js/upload.js') }}"></script>
@stop
