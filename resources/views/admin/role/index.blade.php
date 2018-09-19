@extends('admin.common.layout')
@section('title')
    {{ $title['title'] }}
@endsection
@section('head_files')
    <link href="{{ asset(config('view.admin_static_path') . '/css/plugins/iCheck/custom.css') }}" rel="stylesheet">
@endsection
@section('content')
    <div class="modal inmodal fade" id="role-authorize-modal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span
                                aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                    <h4 class="modal-title">角色授权</h4>
                </div>
                <div class="modal-body">
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
                                                            <input type="checkbox"
                                                                   class="i-checks {{ $menu->id }} check-menu-all"
                                                                   data-menu-id="{{ $menu->id }}" name="input[]">
                                                            全选
                                                        </span>
                                                    </th>
                                                </tr>
                                                <tr>
                                                    @foreach($menu->rules as $key => $rule)
                                                        <td>
                                                            <input type="checkbox"
                                                                   class="i-checks {{ $menu->id }} check-item"
                                                                   data-menu-id="{{ $menu->id }}"
                                                                   name="rule-item"
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
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-white" data-dismiss="modal">关闭</button>
                    <div class="btn btn-primary" data-item-id="" id="submit-rules">提交</div>
                </div>
            </div>
        </div>
    </div>
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
                                <th class="col-lg-2">状态</th>
                                <th class="col-lg-2">授权</th>
                                <th class="col-lg-2">操作</th>
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
                                        <button class="btn btn-xs btn-warning authorize" id="role-authorize"
                                                data-id="{{ $role['id'] }}" title="授权" data-toggle="modal">
                                            <i class="fa fa-check-square-o"></i>
                                        </button>
                                    </td>
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
                var id = $(this).data("id");
                var token = "{{ csrf_token() }}";
                var url = "{{ url('admin/role/delete') }}";
                var type = "2";
                var refresh = {
                    type: "1",
                    timeout: 2000,
                    url: "{{ url('admin/role/index') }}",
                };
                var confirmData = {
                    type: "warning",
                    title: "你确定要删除角色吗？",
                    message: ""
                };
                var ajaxData = {
                    url: url,
                    data: {id: id, _token: token}
                };
                showAjaxMessage(type, confirmData, ajaxData, refresh);
            });
            $(".edit-role-status").click(function () {
                var id = $(this).data("id");
                var token = "{{ csrf_token() }}";
                var url = "{{ url('admin/role/update_status') }}";
                var type = "2";
                var refresh = {
                    type: "1",
                    timeout: 2000,
                    url: "{{ url('admin/role/index') }}",
                };
                var confirmData = {
                    type: "warning",
                    title: "你确定要更改角色状态吗？",
                    message: ""
                };
                var ajaxData = {
                    url: url,
                    data: {id: id, _token: token}
                };
                showAjaxMessage(type, confirmData, ajaxData, refresh);
            });
            $("#role-authorize").click(function () {
                $('#role-authorize-modal').modal('show');
                $('#submit-rules').data('item-id', $(this).data('id'));
                $.get("{{ url('admin/role/get_authorize') }}", {"role_id": $(this).data("id")}, function (data) {
                    $('.i-checks').each(function (index, element) {
                        var ele = $(this);
                        $.each(data, function (name, value) {
                            if (ele.val() == value) {
                                ele.iCheck('check');
                            }
                        });
                    });
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
                var checked_group = $(this).data('menu-id');
                $('.check-item.' + checked_group).iCheck('check');
            });
            $('.check-item').on('ifUnchecked', function () {
                var menu_id = $(this).data('menu-id');
                $('.check-menu-all.' + menu_id).iCheck('uncheck');
            });
            $('#submit-rules').click(function () {
                var checkBoxArr = [];
                var token = "{{ csrf_token() }}";
                var role_id = $(this).data('item-id');
                $('input[name="rule-item"]:checked').each(function () {
                    checkBoxArr.push($(this).val());
                });
                $.ajax({
                    type: "post",
                    url: "{{ url('admin/role/authorize') }}",
                    cache: false,
                    data: {role_id: role_id, rules: checkBoxArr, _token: token},
                    dataType: "json",
                    success: function (data) {
                        $('#role-authorize-modal').modal('hide');
                        $('#role-authorize-modal').on('hidden.bs.modal', function () {
                            $('#submit-rules').data('item-id', '');
                            $('#message-modal-label').html(data['title']);
                            if ('200' == data['status']) {
                                $('#message-modal').find('.modal-body').html('<h3><i class="fa fa-check-square text-info"></i> ' + data['message'] + '</h3>');
                            } else {
                                $('#message-modal').find('.modal-body').html('<h3><i class="fa fa-exclamation-triangle text-danger"></i> ' + data['message'] + '</h3>');
                            }
                        });
                        setTimeout(function () {
                            $("#message-modal").modal({
                                keyboard: false,
                                backdrop: false
                            });
                            $('#message-modal').modal('show');
                        }, 600);
                        setTimeout(function () {
                            window.location.href = '';
                        }, 2500);
                    }
                });
            });
        });
    </script>
@endsection