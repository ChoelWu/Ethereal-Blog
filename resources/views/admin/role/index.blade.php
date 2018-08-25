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
                    <a href="{{ url('admin/role/index') }}">{{ $title['title'] }}</a>
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
                                        <button class="btn btn-xs btn-warning authorize"
                                                data-id="{{ $role['id'] }}" title="授权"><i
                                                    class="fa fa-check-square-o"></i>
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
                var is_disabled = $(this).attr("disabled");
                if (is_disabled != "disabled") {
                    var role_id = $(this).data("id");
                    $('#action-modal').find('.modal-body').html('<h3><i class="fa fa-exclamation-triangle text-warning"></i> 是否要删除用户？</h3>');
                    $('#action-modal').modal('show');
                    $('#action-modal').find('.confirm').click(function () {
                        $('#action-modal').modal('hide');
                        $('#action-modal').on('hidden.bs.modal', function () {
                            $.get("{{ url('admin/role/delete') }}", {"role_id": role_id}, function (data, status) {
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
            $(".edit-role-status").click(function () {
                $.get("{{ url('admin/role/update_status') }}", {"role_id": $(this).data("id")}, function () {
                    location.reload();
                });
            });
            $(".authorize").click(function () {
                $.get("{{ url('admin/role/authorize') }}", {"role_id": $(this).data("id")}, function () {
                    // location.reload();
                });
            });
        });
    </script>
@endsection