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
                    <a href="{{ url('admin/tag/index') }}">{{ $title['title'] }}</a>
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
                        <span class="btn btn-xs btn-primary" id="tag-add">
                            <i class="fa fa-plus"></i>
                            添加
                        </span>
                        </div>
                    </div>
                    <div class="ibox-content">
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th>标签名称</th>
                                    <th>状态</th>
                                    <th class="col-lg-2">操作</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($list as $key => $tag)
                                    <tr>
                                        <td>{{ $key + 1 }}</td>
                                        <td>{{ $tag->name }}</td>
                                        <td>
                                            @if($tag['status'] == '1')
                                                <button class="btn btn-xs btn-primary edit-tag-status"
                                                        data-id="{{ $tag['id'] }}" title="启用"><i class="fa fa-eye"></i>
                                                </button>
                                            @else
                                                <button class="btn btn-xs btn-default edit-tag-status"
                                                        data-id="{{ $tag['id'] }}" title="禁用"><i
                                                            class="fa fa-eye-slash"></i>
                                                </button>
                                            @endif
                                        </td>
                                        <td>
                                        <span class="btn btn-xs btn-primary edit-tag" data-id="{{ $tag['id'] }}"><i
                                                    class="fa fa-edit"></i> 修改</span>
                                            <span class="btn btn-xs btn-danger delete-tag" data-id="{{ $tag['id'] }}"><i
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
            $("#tag-add").click(function () {
                window.location.href = "{{ url('admin/tag/add') }}";
            });
            $(".edit-tag").click(function () {
                window.location.href = "{{ url('admin/tag/edit') }}/" + $(this).data("id");
            });
            $(".delete-tag").click(function () {
                var is_disabled = $(this).attr("disabled");
                if (is_disabled != "disabled") {
                    var tag_id = $(this).data("id");
                    $('#action-modal').find('.modal-body').html('<h3><i class="fa fa-exclamation-triangle text-warning"></i> 是否要删除用户？</h3>');
                    $('#action-modal').modal('show');
                    $('#action-modal').find('.confirm').click(function () {
                        $('#action-modal').modal('hide');
                        $('#action-modal').on('hidden.bs.modal', function () {
                            $.get("{{ url('admin/tag/delete') }}", {"tag_id": tag_id}, function (data, status) {
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
            $(".edit-tag-status").click(function () {
                $.get("{{ url('admin/tag/update_status') }}", {"tag_id": $(this).data("id")}, function () {
                    location.reload();
                });
            });
            $('#menu-selection').change(function () {
                $("#index-tag-form").attr("action", '').submit();
            });
            $('#search-reset').click(function () {
                $('#index-tag-form div').find('input').val('');
                $('#menu-selection').find("option:nth-child(2)").attr("selected", "selected");
                $("#index-tag-form").attr("action", '').submit();
            });
        });
    </script>
@endsection