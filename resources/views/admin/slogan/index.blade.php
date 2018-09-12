@extends('admin.common.layout')
@section('title')
    index
@endsection
@section('head_files')
    <!-- Toastr style -->
    <link href="{{ asset(config('view.admin_static_path') . '/css/plugins/toastr/toastr.min.css') }}" rel="stylesheet">
    <!-- Gritter -->
    <link href="{{ asset(config('view.admin_static_path') . '/js/plugins/gritter/jquery.gritter.css') }}"
          rel="stylesheet">
    <link href="{{ asset(config('view.admin_static_path') . '/css/plugins/dropzone/basic.css') }}" rel="stylesheet">
    <link href="{{ asset(config('view.admin_static_path') . '/css/plugins/dropzone/dropzone.css') }}" rel="stylesheet">
    <link href="{{ asset(config('view.admin_static_path') . '/css/plugins/jasny/jasny-bootstrap.min.css') }}"
          rel="stylesheet">
@endsection
@section('content')
    <div class="modal inmodal" id="add-modal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content animated fadeIn">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">
                        <span aria-hidden="true">&times;</span>
                        <span class="sr-only">Close</span>
                    </button>
                    <h4 class="modal-title">添加广告位</h4>
                </div>
                <div class="modal-body">
                    <form class="form-horizontal" id="add-slogan-form">
                        @csrf
                        <div class="hr-line-dashed"></div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">广告位标题：</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" name="title" placeholder="请输入广告位标题">
                            </div>
                            <span class="text-danger">*</span>
                        </div>
                        <div class="hr-line-dashed"></div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">链接地址：</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" name="url" placeholder="请输入链接地址">
                            </div>
                            <span class="text-danger">*</span>
                        </div>
                        <div class="hr-line-dashed"></div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">内容简要：</label>
                            <div class="col-sm-8">
                                <textarea class="form-control" name="summary" rows="5"
                                          style="resize: vertical;"></textarea>
                            </div>
                            <span class="text-danger">*</span>
                        </div>
                        <div class="hr-line-dashed"></div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">广告位图片：</label>
                            <div class="col-sm-8">
                                <div class="fileinput fileinput-new input-group" data-provides="fileinput">
                                    <div class="form-control" data-trigger="fileinput"><i
                                                class="glyphicon glyphicon-file fileinput-exists"></i> <span
                                                class="fileinput-filename"></span>
                                    </div>
                                    <span class="input-group-addon btn btn-default btn-file">
                                        <span class="fileinput-new">选择文件</span>
                                        <span class="fileinput-exists">更改</span>
                                        <input type="file" name="img">
                                    </span>
                                    <a href="#" class="input-group-addon btn btn-default fileinput-exists"
                                       data-dismiss="fileinput">删除</a>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <div class="btn btn-default" data-dismiss="modal">关闭</div>
                    <div class="btn btn-primary" id="submit-slogan">提交</div>
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
        <div class="col-lg-2">
        </div>
    </div>
    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">
            <div class="col-md-12">
                <div class="ibox">
                    <div class="ibox-title">
                        <h5>{{ $title['sub_title'] }}</h5>
                        <div class="ibox-tools">
                            <span class="btn btn-xs btn-primary" id="slogan-add">
                                <i class="fa fa-plus"></i>
                                添加
                            </span>
                        </div>
                    </div>
                    <div class="ibox-content">
                        <div class="table-responsive">
                            <table class="table shoping-cart-table">
                                <tbody>
                                @foreach($list as $slogan)
                                    <tr>
                                        <td width="200">
                                            <img src="{{ asset($slogan['img']) }}" alt=""
                                                 width="200">
                                        </td>
                                        <td class="desc">
                                            <h3>
                                                <a href="{{ $slogan->url }}" class="text-navy"
                                                   target="_blank">{{ $slogan->title }}</a>
                                            </h3>
                                            <p class="small">{{ $slogan->summary }}</p>
                                            <div class="m-t-sm">
                                                <a class="text-info edit-slogan" data-id="{{ $slogan->id }}"><i
                                                            class="fa fa-edit"></i> 修改</a>
                                                |
                                                <a class="text-danger delete-slogan" data-id="{{ $slogan->id }}"><i
                                                            class="fa fa-trash"></i> 删除</a>
                                                |
                                                @if($slogan->status == '1')
                                                    <a class="text-muted update-status-slogan"
                                                       data-id="{{ $slogan->id }}"><i class="fa fa-eye-slash"></i>
                                                        禁用</a>
                                                @else
                                                    <a class="text-success update-status-slogan"
                                                       data-id="{{ $slogan->id }}"><i class="fa fa-eye"></i> 启用</a>
                                                @endif
                                                |
                                                @if($slogan->is_top == '0')
                                                    <a class="text-warning stick-slogan"
                                                       data-id="{{ $slogan->id }}"><i class="fa fa-level-up"></i> 置顶</a>
                                                @else
                                                    <a class="text-muted stick-slogan"
                                                       data-id="{{ $slogan->id }}"><i class="fa fa-level-down"></i> 取消置顶</a>
                                                @endif
                                            </div>
                                        </td>
                                        <td></td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                            <div class="hr-line-dashed"></div>
                            <div class="pull-right">
                                {{ $list->links() }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('foot_files')
    <!-- Jasny -->
    <script src="{{ asset(config('view.admin_static_path') . '/js/plugins/jasny/jasny-bootstrap.min.js') }}"></script>
    <!-- DROPZONE -->
    <script src="{{ asset(config('view.admin_static_path') . '/js/plugins/dropzone/dropzone.js') }}"></script>
    <script>
        $(document).ready(function () {
            $("#slogan-add").click(function () {
                $('#add-modal').modal('show');
            });
            $("#submit-slogan").click(function () {
                var url = "{{ url('admin/slogan/add') }}";
                var form_data = new FormData($("#add-slogan-form")[0]);
                $.ajax({
                    url: url,
                    type: "post",
                    cache: false,
                    processData: false,
                    contentType: false,
                    async: false,
                    data: form_data,
                    dataType: "json",
                    success: function (data) {
                        $('#add-modal').modal('hide');
                        $('#message-modal-label').html("添加用户");
                        if ('200' == data['status']) {
                            $('#message-modal').find('.modal-body').html('<h3><i class="fa fa-check-square text-info"></i> ' + data['message'] + '</h3>');
                        } else {
                            $('#message-modal').find('.modal-body').html('<h3><i class="fa fa-exclamation-triangle text-danger"></i> ' + data['message'] + '</h3>');
                        }
                        setTimeout(function () {
                            $("#message-modal").modal({
                                keyboard: false,
                                backdrop: false
                            });
                            $('#message-modal').modal('show');
                        }, 600);
                        if ('200' == data['status']) {
                            setTimeout(function () {
                                window.location.href = "{{ url('admin/slogan/index') }}";
                            }, 2500);
                        } else {
                            setTimeout(function () {
                                $('#message-modal').modal('hide');
                            }, 2500);
                        }
                    }
                });
            });
            $(".delete-slogan").click(function () {
                var url = "{{ url('admin/slogan/delete') }}";
                var id = $(this).data('id');
                $.get(url, {id: id}, function (data) {
                    console.log(data);
                });
            });
            $(".stick-slogan").click(function () {
                var url = "{{ url('admin/slogan/stick') }}";
                var id = $(this).data('id');
                $.get(url, {id: id}, function (data) {
                    console.log(data);
                });
            });
            $(".update-status-slogan").click(function () {
                var url = "{{ url('admin/slogan/updateStatus') }}";
                var id = $(this).data('id');
                $.get(url, {id: id}, function (data) {
                    console.log(data);
                });
            });
        });
    </script>
@endsection