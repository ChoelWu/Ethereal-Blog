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
                    <a href="{{ url('admin/user/index') }}">{{ $title['title'] }}</a>
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
                            <span class="btn btn-xs btn-primary" id="user-add">
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
                                <th>头像</th>
                                <th>昵称</th>
                                <th>e-mail</th>
                                <th>电话</th>
                                <th>状态</th>
                                <th class="col-lg-2">操作</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($list as $key => $user)
                                <tr>
                                    <td>{{ $key + 1 }}</td>
                                    <td>
                                        <img alt="image" class="img-circle img-sm"
                                             src="@if('' != $user['header_img']){{ asset($user['header_img']) }}@else{{ asset(config('view.admin_static_path') . '/img/default_user.png') }}@endif">
                                    </td>
                                    <td>{{ $user['nickname'] }}</td>
                                    <td>{{ $user['e_mail'] }}</td>
                                    <td>{{ $user['phone'] }}</td>
                                    <td>
                                        @if($user['status'] == '1')
                                            <button class="btn btn-xs btn-primary edit-user-status"
                                                    data-id="{{ $user['id'] }}" title="启用">
                                                <i class="fa fa-eye"></i>
                                            </button>
                                        @else
                                            <button class="btn btn-xs btn-default edit-user-status"
                                                    data-id="{{ $user['id'] }}" title="禁用">
                                                <i class="fa fa-eye-slash"></i>
                                            </button>
                                        @endif
                                    </td>
                                    <td>
                                        <span class="btn btn-xs btn-primary edit-user" data-id="{{ $user['id'] }}">
                                            <i class="fa fa-edit"></i> 修改
                                        </span>
                                        <span class="btn btn-xs btn-danger delete-user" data-id="{{ $user['id'] }}">
                                            <i class="fa fa-times"></i> 删除
                                        </span>
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
            $("#user-add").click(function () {
                window.location.href = "{{ url('admin/user/add') }}";
            });
            $(".edit-user").click(function () {
                window.location.href = "{{ url('admin/user/edit') }}/" + $(this).data("id");
            });
            $(".delete-user").click(function () {
                var id = $(this).data("id");
                var token = "{{ csrf_token() }}";
                var url = "{{ url('admin/user/delete') }}";
                var type = "2";
                var refresh = {
                    type: "1",
                    timeout: 2000,
                    url: "{{ url('admin/user/index') }}",
                };
                var confirmData = {
                    type: "warning",
                    title: "你确定要删除用户吗？",
                    message: ""
                };
                var ajaxData = {
                    url: url,
                    data: {id: id, _token: token}
                };
                showAjaxMessage(type, confirmData, ajaxData, refresh);
            });
            $(".edit-user-status").click(function () {
                var id = $(this).data("id");
                var token = "{{ csrf_token() }}";
                var url = "{{ url('admin/user/update_status') }}";
                var type = "2";
                var refresh = {
                    type: "1",
                    timeout: 2000,
                    url: "{{ url('admin/user/index') }}",
                };
                var confirmData = {
                    type: "warning",
                    title: "你确定要更改用户状态吗？",
                    message: ""
                };
                var ajaxData = {
                    url: url,
                    data: {id: id, _token: token}
                };
                showAjaxMessage(type, confirmData, ajaxData, refresh);
            });
        });
    </script>
@endsection