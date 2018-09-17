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
        <div class="col-lg-2"></div>
    </div>
    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">
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
                                <tr class="active">
                                    <td>{{ $menu->sort }}</td>
                                    <td>{{ $menu->name }}</td>
                                    <td><i class="fa fa-{{ $menu->icon }}"></i></td>
                                    <td>
                                        @if($menu->status == '1')
                                            <button class="btn btn-xs btn-primary edit-menu-status"
                                                    data-id="{{ $menu->id }}"
                                                    @if(!empty($menu->children))disabled="disabled" @endif title="启用">
                                                <i class="fa fa-eye"></i>
                                            </button>
                                        @else
                                            <button class="btn btn-xs btn-default edit-menu-status"
                                                    data-id="{{ $menu->id }}"
                                                    @if(!empty($menu->children))disabled="disabled" @endif title="禁用">
                                                <i class="fa fa-eye-slash"></i>
                                            </button>
                                        @endif
                                    </td>
                                    <td>
                                        <button class="btn btn-xs btn-primary edit-menu" data-id="{{ $menu->id }}">
                                            <i class="fa fa-edit"></i> 修改
                                        </button>
                                        <button class="btn btn-xs btn-danger delete-menu" data-id="{{ $menu->id }}"
                                              @if(!empty($menu->children))disabled="disabled"@endif>
                                            <i class="fa fa-times"></i> 删除
                                        </button>
                                    </td>
                                </tr>
                                @if(!empty($menu->children))
                                    @foreach($menu->children as $m)
                                        <tr>
                                            <td>{{ $m->sort }}</td>
                                            <td>&nbsp;&nbsp;&nbsp;&nbsp;| - - {{ $m->name }}</td>
                                            <td>
                                                <i class="fa fa-{{ $m->icon }}"></i>
                                            </td>
                                            <td>
                                                @if($m['status'] == '1')
                                                    <button class="btn btn-xs btn-primary edit-menu-status"
                                                            data-id="{{ $m->id }}" title="启用">
                                                        <i class="fa fa-eye"></i>
                                                    </button>
                                                @else
                                                    <button class="btn btn-xs btn-default edit-menu-status"
                                                            data-id="{{ $m->id }}">
                                                        <i class="fa fa-eye-slash" title="禁用"></i>
                                                    </button>
                                                @endif
                                            </td>
                                            <td>
                                                <span class="btn btn-xs btn-primary edit-menu" data-id="{{ $m->id }}">
                                                    <i class="fa fa-edit"></i> 修改
                                                </span>
                                                <span class="btn btn-xs btn-danger delete-menu"
                                                      data-id="{{ $m->id }}">
                                                    <i class="fa fa-times"></i> 删除
                                                </span>
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
            $("#menu-add").click(function () {
                window.location.href = "{{ url('admin/menu/add') }}";
            });
            $(".edit-menu").click(function () {
                window.location.href = "{{ url('admin/menu/edit') }}/" + $(this).data("id");
            });
            $('.delete-menu').click(function () {
                var id = $(this).data("id");
                var token = "{{ csrf_token() }}";
                var url = "{{ url('admin/menu/delete') }}";
                var type = "2";
                var refresh = {
                    type: "1",
                    timeout: 2000,
                    url: "{{ url('admin/menu/index') }}",
                };
                var confirmData = {
                    type: "warning",
                    title: "你确定要删除菜单吗？",
                    message: ""
                };
                var ajaxData = {
                    url: url,
                    data: {id: id, _token: token}
                };
                showAjaxMessage(type, confirmData, ajaxData, refresh);
            });
            $('.edit-menu-status').click(function () {
                var id = $(this).data("id");
                var token = "{{ csrf_token() }}";
                var url = "{{ url('admin/menu/update_status') }}";
                var type = "2";
                var refresh = {
                    type: "1",
                    timeout: 2000,
                    url: "{{ url('admin/menu/index') }}",
                };
                var confirmData = {
                    type: "warning",
                    title: "你确定要更改菜单状态吗？",
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