@extends('admin.common.layout')
@section('title')
    {{ $title['title'] }}
@endsection
@section('content')
    <div class="row wrapper border-bottom white-bg page-heading">
        <div class="col-lg-10">
            <h2>{{ $title['title'] }}</h2>
            <ol class="breadcrumb">
                <li>
                    <a href="{{ url('admin/rule/index') }}">{{ $title['title'] }}</a>
                </li>
                <li class="active">
                    <strong>{{ $title['sub_title'] }}</strong>
                </li>
            </ol>
        </div>
        <div class="col-lg-2">
        </div>
    </div>
    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">
            <div class="col-lg-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <h5>{{ $title['sub_title'] }}</h5>
                        <div class="ibox-tools">
                            <span class="btn btn-xs btn-primary" id="rule-add">
                                <i class="fa fa-plus"></i>
                                添加
                            </span>
                        </div>
                    </div>
                    <div class="ibox-content">
                        <div class="row">
                            <form class="form-horizontal" id="index-rule-form" method="post">
                                @csrf
                                <div class="col-sm-4">
                                    <div class="input-group">
                                        <input placeholder="请输入路由规则/规则名称进行搜索..." class="form-control" type="text"
                                               name="route"
                                               value="{{ $route }}">
                                        <span class="input-group-btn">
                                        <button type="submit" class="btn btn-primary"> 搜索 </button>
                                    </span>
                                    </div>
                                </div>
                                <div class="col-sm-3 m-b-xs">
                                    <select class="form-control input-s-xs inline" name="menu_id" id="menu-selection">
                                        <option disabled="disabled">- - - - - - - - - - - - - - - - - - - - - - - - -
                                        </option>
                                        <option value="">所有菜单</option>
                                        <option disabled="disabled">- - - - - - - - - - - - - - - - - - - - - - - - -
                                        </option>
                                        @foreach($menu_list as $item)
                                            <option value="{{ $item['id'] }}"
                                                    @if($menu_id == $item['id']) selected="selected" @endif>{{ $item['name'] }}</option>
                                            @foreach($item['children'] as $v)
                                                <option value="{{ $v['id'] }}"
                                                        @if($menu_id == $v['id']) selected="selected" @endif>&nbsp;&nbsp;&nbsp;&nbsp;|
                                                    -
                                                    - {{ $v['name'] }}</option>
                                            @endforeach
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-sm-1">
                                    <div class="input-group">
                                        <span id="search-reset" class="btn btn-warning"> 重置 </span>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th>规则名称</th>
                                    <th>路由规则</th>
                                    <th>规则序号</th>
                                    <th>所属菜单</th>
                                    <th>状态</th>
                                    <th class="col-lg-2">操作</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($list as $key => $rule)
                                    <tr>
                                        <td>{{ $key + 1 }}</td>
                                        <td>{{ $rule->name }}</td>
                                        <td>{{ $rule->route }}</td>
                                        <td>{{ $rule->sort }}</td>
                                        <td>@if(empty($rule->menu->parent)) <b>{{ $rule->menu->name }}</b> @else
                                                <b>{{ $rule->menu->parent->name }}</b> >> {{ $rule->menu->name }} @endif
                                        </td>
                                        <td>
                                            @if($rule['status'] == '1')
                                                <button class="btn btn-xs btn-primary edit-rule-status"
                                                        data-id="{{ $rule['id'] }}" title="启用"><i class="fa fa-eye"></i>
                                                </button>
                                            @else
                                                <button class="btn btn-xs btn-default edit-rule-status"
                                                        data-id="{{ $rule['id'] }}" title="禁用"><i
                                                            class="fa fa-eye-slash"></i>
                                                </button>
                                            @endif
                                        </td>
                                        <td>
                                        <span class="btn btn-xs btn-primary edit-rule" data-id="{{ $rule['id'] }}"><i
                                                    class="fa fa-edit"></i> 修改</span>
                                            <span class="btn btn-xs btn-danger delete-rule" data-id="{{ $rule['id'] }}"><i
                                                        class="fa fa-times"></i> 删除</span>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                            <div class="pull-right">
                                {{ $list->appends(['route' => $route, 'menu_id' => $menu_id])->links() }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('foot_files')
    <!-- Peity -->
    <script src="{{ asset(config('view.admin_static_path') . '/js/plugins/peity/jquery.peity.min.js') }}"></script>
    <!-- iCheck -->
    <script src="{{ asset(config('view.admin_static_path') . '/js/plugins/iCheck/icheck.min.js') }}"></script>
    <!-- Peity -->
    <script src="{{ asset(config('view.admin_static_path') . '/js/demo/peity-demo.js') }}"></script>
    <script>
        $(document).ready(function () {
            $("#rule-add").click(function () {
                window.location.href = "{{ url('admin/rule/add') }}";
            });
            $(".edit-rule").click(function () {
                window.location.href = "{{ url('admin/rule/edit') }}/" + $(this).data("id");
            });
            $(".delete-rule").click(function () {
                var id = $(this).data("id");
                var token = "{{ csrf_token() }}";
                var url = "{{ url('admin/rule/delete') }}";
                var type = "2";
                var refresh = {
                    type: "1",
                    timeout: 2000,
                    url: "{{ url('admin/rule/index') }}",
                };
                var confirmData = {
                    type: "warning",
                    title: "你确定要删除权限规则吗？",
                    message: ""
                };
                var ajaxData = {
                    url: url,
                    data: {id: id, _token: token}
                };
                showAjaxMessage(type, confirmData, ajaxData, refresh);
            });
            $(".edit-rule-status").click(function () {
                var id = $(this).data("id");
                var token = "{{ csrf_token() }}";
                var url = "{{ url('admin/rule/update_status') }}";
                var type = "2";
                var refresh = {
                    type: "1",
                    timeout: 2000,
                    url: "{{ url('admin/rule/index') }}",
                };
                var confirmData = {
                    type: "warning",
                    title: "你确定要更改菜权限规则态吗？",
                    message: ""
                };
                var ajaxData = {
                    url: url,
                    data: {id: id, _token: token}
                };
                showAjaxMessage(type, confirmData, ajaxData, refresh);
            });
            $('#menu-selection').change(function () {
                $("#index-rule-form").attr("action", '').submit();
            });
            $('#search-reset').click(function () {
                $('#index-rule-form div').find('input').val('');
                $('#menu-selection').find("option:nth-child(2)").attr("selected", "selected");
                $("#index-rule-form").attr("action", '').submit();
            });
        });
    </script>
@endsection