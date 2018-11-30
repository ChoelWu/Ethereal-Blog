@extends('admin.common.layout')
@section('title')
    {{ $title['title'] }}
@endsection
@section('head_files')
    <link href="{{ asset(config('view.admin_static_path') . '/css/plugins/iCheck/custom.css') }}" rel="stylesheet">
@endsection
@section('inputModal')
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
                <div class="ibox-content">
                    <div class="row">
                        <div class="col-sm-2 col-sm-offset-10">
                            <button type="button" class="btn btn-sm btn-default"
                                    id="clear-all-rule"> 清空
                            </button>
                            <button type="button" class="btn btn-sm btn-info"
                                    id="choose-all-rule"> 全选
                            </button>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                            <tr>
                                <th>权限名称</th>
                                <th>权限名称</th>
                                <th>权限名称</th>
                                <th>权限名称</th>
                                <th>权限名称</th>
                                <th>权限名称</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($rule_list as $menu)
                                <tr>
                                    <th colspan="6">{{ $menu->name }}
                                        <span class="pull-right">
                                            <input type="checkbox" class="i-checks {{ $menu->id }} check-menu-all"
                                                   data-menu-id="{{ $menu->id }}" name="input[]"> 全选
                                        </span>
                                    </th>
                                </tr>
                                <tr>
                                    @foreach($menu->rules as $key => $rule)
                                        <td>
                                            <input type="checkbox" class="i-checks {{ $menu->id }} check-item"
                                                   data-menu-id="{{ $menu->id }}" name="rule-item"
                                                   value="{{ $rule->route }}"> {{ $rule->name }}
                                        </td>
                                        @if(($key + 1) / 6 == 0)
                                </tr>
                                <tr>
                                    @endif
                                    @endforeach
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('content')
    <div class="row wrapper border-bottom white-bg page-heading">
        <div class="col-lg-10">
            <h2>{{ $title['title'] }}</h2>
            <ol class="breadcrumb">
                <li>
                    <a href="{{ url('admin/role/index') }}">{{ $title['title'] }}</a>
                </li>
                <li class="active">
                    <strong>{{ $title['sub_title'] }}</strong>
                </li>
            </ol>
        </div>
        <div class="col-lg-2"></div>
    </div>
    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">
            <div class="col-lg-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <h5>{{ $title['sub_title'] }}</h5>
                        <div class="ibox-tools">
                            <span class="btn btn-xs btn-primary" id="role-add">
                                <i class="fa fa-plus"></i>
                                添加
                            </span>
                        </div>
                    </div>
                    <div class="ibox-content">
                        <table class="table table-hover">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>角色名</th>
                                <th>状态</th>
                                <th>授权</th>
                                @if(session('user')['role_id'] == '1')
                                    <th>创建者</th>
                                @endif
                                <th>操作</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($list as $key => $role)
                                <tr>
                                    <td>{{ $key + 1 }}</td>
                                    <td>{{ $role['role_name'] }}</td>
                                    <td>
                                        @if($role['status'] == '1')
                                            <button class="btn btn-xs btn-primary edit-role-status"
                                                    data-id="{{ $role['id'] }}" title="启用"><i class="fa fa-eye"></i>
                                            </button>
                                        @else
                                            <button class="btn btn-xs btn-default edit-role-status"
                                                    data-id="{{ $role['id'] }}" title="禁用"><i
                                                        class="fa fa-eye-slash"></i>
                                            </button>
                                        @endif
                                    </td>
                                    <td>
                                        <button class="btn btn-xs btn-warning role-authorize" id="role-authorize"
                                                data-id="{{ $role['id'] }}" title="授权" data-toggle="modal">
                                            <i class="fa fa-check-square-o"></i>
                                        </button>
                                    </td>
                                    @if(session('user')['role_id'] == '1')
                                        <td><b>&lt;{{ $role['user']['nickname'] }}&gt;</b> @ {{ $role['user']['account'] }}</td>
                                    @endif
                                    <td>
                                    <span class="btn btn-xs btn-primary edit-role" data-id="{{ $role['id'] }}"><i
                                                class="fa fa-edit"></i> 修改</span>
                                        <span class="btn btn-xs btn-danger delete-role" data-id="{{ $role['id'] }}"><i
                                                    class="fa fa-times"></i> 删除</span>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
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
            $("#role-add").click(function () {
                window.location.href = "{{ url('admin/role/add') }}";
            });
            $(".edit-role").click(function () {
                window.location.href = "{{ url('admin/role/edit') }}/" + $(this).data("id");
            });
            $(".delete-role").click(function () {
                let id = $(this).data("id");
                let token = "{{ csrf_token() }}";
                let url = "{{ url('admin/role/delete') }}";
                let type = "2";
                let refresh = {
                    type: "1",
                    timeout: 2000,
                    url: "{{ url('admin/role/index') }}",
                };
                let confirmData = {
                    type: "warning",
                    title: "你确定要删除角色吗？",
                    message: ""
                };
                let ajaxData = {
                    url: url,
                    data: {id: id, _token: token}
                };
                showAjaxMessage(type, confirmData, ajaxData, refresh);
            });
            $(".edit-role-status").click(function () {
                let id = $(this).data("id");
                let token = "{{ csrf_token() }}";
                let url = "{{ url('admin/role/update_status') }}";
                let type = "2";
                let refresh = {
                    type: "1",
                    timeout: 2000,
                    url: "{{ url('admin/role/index') }}",
                };
                let confirmData = {
                    type: "warning",
                    title: "你确定要更改角色状态吗？",
                    message: ""
                };
                let ajaxData = {
                    url: url,
                    data: {id: id, _token: token}
                };
                showAjaxMessage(type, confirmData, ajaxData, refresh);
            });
            $(".role-authorize").click(function () {
                $('#submit-btn').data('item', $(this).data('id'));
                inputModal("animated bounceInDown", "lg", "角色授权");
                $.get("{{ url('admin/role/get_authorize') }}", {"role_id": $(this).data("id")}, function (data) {
                    $('.i-checks').iCheck('uncheck');
                    $('.i-checks').each(function () {
                        let ele = $(this);
                        $.each(data, function (name, value) {
                            if (ele.val() == value) {
                                ele.iCheck('check');
                            }
                        });
                    });
                });
            });
            $('#submit-btn').click(function () {
                $("#inputModal").modal("hide");
                let checkBoxArr = [];
                let token = "{{ csrf_token() }}";
                let role_id = $(this).data('item');
                $('input[name="rule-item"]:checked').each(function () {
                    checkBoxArr.push($(this).val());
                });
                ajaxFromServer("{{ url('admin/role/authorize') }}", {
                    role_id: role_id,
                    rules: checkBoxArr,
                    _token: token
                }, function (data) {
                    if (data['status'] == '1') {
                        showMessageModal("animated flipInX", "sm", "success", "授权成功！", 2000);
                    } else if (data['status'] == '0') {
                        showMessageModal("animated flipInX", "sm", "error", "授权失败！", 2000);
                    }
                }, function () {
                    showMessageModal("animated flipInX", "sm", "error", "系统异常！", 2000);
                });
            });
            $('.i-checks').iCheck({
                checkboxClass: 'icheckbox_square-green',
                radioClass: 'iradio_square-green',
            });
            $('#choose-all-rule').click(function () {
                $('.i-checks').iCheck('check');
            });
            $('#clear-all-rule').click(function () {
                $('.i-checks').iCheck('uncheck');
            });
            $('.check-menu-all').on('ifChecked', function () {
                let checked_group = $(this).data('menu-id');
                $('.check-item.' + checked_group).iCheck('check');
            });
            $('.check-item').on('ifUnchecked', function () {
                let menu_id = $(this).data('menu-id');
                $('.check-menu-all.' + menu_id).iCheck('uncheck');
            });
        });
    </script>
@endsection