@extends('layouts.admin')
@section('content')
<div class="admin-content">
    <div class="am-cf am-padding">
        <div class="am-fl am-cf">
            <strong class="am-text-primary am-text-lg">系统设置</strong> / <small>物流运费</small>
        </div>
    </div>

    @include('layouts._message')

    <div class="am-g">
        <div class="am-u-sm-12 am-u-md-6">
            <div class="am-btn-toolbar">
                <div class="am-btn-group am-btn-group-xs">
                    <a class="am-btn am-btn-default" href="{{ route('admin.express.create') }}">
                        <span class="am-icon-plus"></span> 新增
                    </a>
                </div>
            </div>
        </div>

        <form class="" action="/admin/brand/search" method="get">
            <div class="am-u-sm-12 am-u-md-3">
                <div class="am-input-group am-input-group-sm">
                    <input type="text" class="am-form-field" name="keyword">
                    <span class="am-input-group-btn">
                        <button class="am-btn am-btn-default" type="submit">搜索</button>
                    </span>
                </div>
            </div>
        </form>

    </div>

    <div class="am-g">
        <div class="am-u-sm-12">
            <form class="am-form">
                <table class="am-table am-table-striped am-table-hover table-main">
                    <thead>
                        <tr>
                            <th>编号</th>
                            <th>配送方式描述</th>
                            <th>是否可用</th>
                            <th>排序</th>
                            <th class="table-set">操作</th>
                        </tr>
                    </thead>
                    <tbody>


                        @foreach($expresses as $express)
                        <tr>
                            <td>{{ $express->id }}</td>
                            <td>{{ $express->name }}</td>
                            <td>{{ $express->desc }}</td>
                            <td class="am-hide-sm-only">
                                @if($express->enabled == true)
                                    <span class="am-icon-check"></span>
                                @else
                                    <span class="am-icon-close"></span>
                                @endif
                            </td>
                            <td>{{ $express->sort_order }}</td>

                            <td>
                                <div class="am-btn-toolbar">
                                    <div class="am-btn-group am-btn-group-xs">
                                        <a class="am-btn am-btn-default am-btn-xs am-text-secondary" href="{{ route('admin.express.edit', $express->id) }}">
                                            <span class="am-icon-list-alt"></span> 编辑
                                        </a>
                                        <a class="am-btn am-btn-default am-btn-xs am-text-danger am-hide-sm-only" href="{{ route('admin.express.destroy', $express->id) }}" data-method="delete" data-token="{{csrf_token()}}" data-confirm="确定删除吗？">
                                            <span class="am-icon-trash-o"></span> 删除
                                        </a>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        @endforeach

                    </tbody>
                </table>

                <div class="am-cf">
                    <div class="am-fr">

                        {!! $expresses->render() !!}
                    </div>
                </div>

            </form>
        </div>
    </div>

</div>
@stop

@section('js')
<script type="text/javascript">

</script>
@stop
