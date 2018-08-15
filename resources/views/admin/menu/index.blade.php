@extends('admin.common.layout')
@section('title')
    index
@endsection
@section('content')
    <div class="row wrapper border-bottom white-bg page-heading">
        <div class="col-lg-10">
            <h2>{{ $title['title'] }}</h2>
            <ol class="breadcrumb">
                <li>
                    <a href="{{ url('admin/menu/index') }}">{{ $title['title'] }}</a>
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
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>{{ $title['sub_title'] }}</h5>
                    <div class="ibox-tools">
                        <span class="btn btn-xs btn-primary" id="menu-add">
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
                            <th>名称</th>
                            <th>图标</th>
                            <th>状态</th>
                            <th class="col-lg-2">操作</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($list as $menu)
                            <tr>
                                <td>{{ $menu['sort'] }}</td>
                                <td>{{ $menu['name'] }}</td>
                                <td><i class="fa fa-{{ $menu['icon'] }}"></i></td>
                                <td>
                                    @if($menu['status'] == '1')
                                        <button class="btn btn-xs btn-primary edit-menu-status"
                                                data-id="{{ $menu['id'] }}"
                                                @if(!empty($menu['children']))disabled="disabled" @endif title="启用"><i
                                                    class="fa fa-eye"></i></button>
                                    @else
                                        <button class="btn btn-xs btn-default edit-menu-status"
                                                data-id="{{ $menu['id'] }}"
                                                @if(!empty($menu['children']))disabled="disabled" @endif title="禁用"><i
                                                    class="fa fa-eye-slash"></i></button>
                                    @endif
                                </td>
                                <td>
                                    <span class="btn btn-xs btn-primary edit-menu" data-id="{{ $menu['id'] }}"><i
                                                class="fa fa-edit"></i> 修改</span>
                                    <span class="btn btn-xs btn-danger delete-menu" data-id="{{ $menu['id'] }}"
                                          @if(!empty($menu['children']))disabled="disabled"@endif><i
                                                class="fa fa-times"></i> 删除</span>
                                </td>
                            </tr>
                            @if(!empty($menu['children']))
                                @foreach($menu['children'] as $m)
                                    <tr>
                                        <td>{{ $m['sort'] }}</td>
                                        <td>&nbsp;&nbsp;&nbsp;&nbsp;| - - {{ $m['name'] }}</td>
                                        <td>
                                            <i class="fa fa-{{ $m['icon'] }}"></i>
                                        </td>
                                        <td>
                                            @if($m['status'] == '1')
                                                <button class="btn btn-xs btn-primary edit-menu-status"
                                                        data-id="{{ $m['id'] }}" title="启用"><i class="fa fa-eye"></i>
                                                </button>
                                            @else
                                                <button class="btn btn-xs btn-default edit-menu-status"
                                                        data-id="{{ $m['id'] }}"><i class="fa fa-eye-slash"
                                                                                    title="禁用"></i>
                                                </button>
                                            @endif
                                        </td>
                                        <td>
                                            <span class="btn btn-xs btn-primary edit-menu" data-id="{{ $m['id'] }}"><i
                                                        class="fa fa-edit"></i> 修改</span>
                                            <span class="btn btn-xs btn-danger delete-menu" data-id="{{ $m['id'] }}"><i
                                                        class="fa fa-times"></i> 删除</span>
                                        </td>
                                    </tr>
                                @endforeach
                            @endif
                        @endforeach
                        </tbody>
                    </table>
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
            $("#menu-add").click(function () {
                window.location.href = "{{ url('admin/menu/add') }}";
            });
            $(".edit-menu").click(function () {
                window.location.href = "{{ url('admin/menu/edit') }}/id/" + $(this).data("id");
            });
            $(".delete-menu").click(function () {
                var is_disabled = $(this).attr("disabled");
                if (is_disabled != "disabled") {
                    var menu_id = $(this).data("id");
                    $('#action-modal-label').html('删除');
                    $('#action-modal').find('.modal-body').html('<h3><i class="fa fa-exclamation-triangle text-warning"></i> 是否要删除菜单？</h3>');
                    $('#action-modal').modal('show');
                    $('#action-modal').find('.confirm').click(function () {
                        $('#action-modal').modal('hide');
                        $('#action-modal').on('hidden.bs.modal', function () {
                            $.get("{{ url('admin/menu/delete') }}", {"menu_id": menu_id}, function (data, status) {
                                $('#message-modal-label').html(data['title']);
                                if ('success' == status) {
                                    if ('200' == data['status']) {
                                        $('#message-modal').find('.modal-body').html('<h3><i class="fa fa-check-square text-info"></i> ' + data['message'] + '</h3>');
                                    } else {
                                        $('#message-modal').find('.modal-body').html('<h3><i class="fa fa-exclamation-triangle text-danger"></i> ' + data['message'] + '</h3>');
                                    }
                                }
                            });
                        });
                        setTimeout(function () {
                            $("#message-modal").modal({
                                keyboard: false,
                                backdrop: false
                            });
                            $('#message-modal').modal('show');
                        }, 600);
                        setTimeout(function () {
                            location.reload();
                        }, 2500);
                    });
                }
            });
            $(".edit-menu-status").click(function () {
                $.get("{{ url('admin/menu/update_status') }}", {"menu_id": $(this).data("id")}, function () {
                    location.reload();
                });
            });
        });
    </script>
@endsection