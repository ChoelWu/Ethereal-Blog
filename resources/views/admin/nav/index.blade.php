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
                    <a href="{{ url('admin/nav/index') }}">{{ $title['title'] }}</a>
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
                        <span class="btn btn-xs btn-primary" id="nav-add">
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
                            @foreach($list as $nav)
                                <tr>
                                    <td>{{ $nav['sort'] }}</td>
                                    <td>{{ $nav['name'] }}</td>
                                    <td><i class="fa fa-{{ $nav['icon'] }}"></i></td>
                                    <td>
                                        @if($nav['status'] == '1')
                                            <button class="btn btn-xs btn-primary edit-nav-status"
                                                    data-id="{{ $nav['id'] }}"
                                                    @if(!empty($nav['children']))disabled="disabled" @endif title="启用">
                                                <i
                                                        class="fa fa-eye"></i></button>
                                        @else
                                            <button class="btn btn-xs btn-default edit-nav-status"
                                                    data-id="{{ $nav['id'] }}"
                                                    @if(!empty($nav['children']))disabled="disabled" @endif title="禁用">
                                                <i
                                                        class="fa fa-eye-slash"></i></button>
                                        @endif
                                    </td>
                                    <td>
                                    <span class="btn btn-xs btn-primary edit-nav" data-id="{{ $nav['id'] }}"><i
                                                class="fa fa-edit"></i> 修改</span>
                                        <span class="btn btn-xs btn-danger delete-nav" data-id="{{ $nav['id'] }}"
                                              @if(!empty($nav['children']))disabled="disabled"@endif><i
                                                    class="fa fa-times"></i> 删除</span>
                                    </td>
                                </tr>
                                @if(!empty($nav['children']))
                                    @foreach($nav['children'] as $m)
                                        <tr>
                                            <td>{{ $m['sort'] }}</td>
                                            <td>&nbsp;&nbsp;&nbsp;&nbsp;| - - {{ $m['name'] }}</td>
                                            <td>
                                                <i class="fa fa-{{ $m['icon'] }}"></i>
                                            </td>
                                            <td>
                                                @if($m['status'] == '1')
                                                    <button class="btn btn-xs btn-primary edit-nav-status"
                                                            data-id="{{ $m['id'] }}" title="启用"><i
                                                                class="fa fa-eye"></i>
                                                    </button>
                                                @else
                                                    <button class="btn btn-xs btn-default edit-nav-status"
                                                            data-id="{{ $m['id'] }}"><i class="fa fa-eye-slash"
                                                                                        title="禁用"></i>
                                                    </button>
                                                @endif
                                            </td>
                                            <td>
                                            <span class="btn btn-xs btn-primary edit-nav" data-id="{{ $m['id'] }}"><i
                                                        class="fa fa-edit"></i> 修改</span>
                                                <span class="btn btn-xs btn-danger delete-nav"
                                                      data-id="{{ $m['id'] }}"><i
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
            $("#nav-add").click(function () {
                window.location.href = "{{ url('admin/nav/add') }}";
            });
            $(".edit-nav").click(function () {
                window.location.href = "{{ url('admin/nav/edit') }}/" + $(this).data("id");
            });
            $(".delete-nav").click(function () {
                var is_disabled = $(this).attr("disabled");
                if (is_disabled != "disabled") {
                    var nav_id = $(this).data("id");
                    $('#action-modal-label').html('删除');
                    $('#action-modal').find('.modal-body').html('<h3><i class="fa fa-exclamation-triangle text-warning"></i> 是否要删除导航？</h3>');
                    $('#action-modal').modal('show');
                    $('#action-modal').find('.confirm').click(function () {
                        $('#action-modal').modal('hide');
                        $('#action-modal').on('hidden.bs.modal', function () {
                            $.get("{{ url('admin/nav/delete') }}", {"nav_id": nav_id}, function (data, status) {
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
            $(".edit-nav-status").click(function () {
                $.get("{{ url('admin/nav/update_status') }}", {"nav_id": $(this).data("id")}, function () {
                    location.reload();
                });
            });
        });
    </script>
@endsection